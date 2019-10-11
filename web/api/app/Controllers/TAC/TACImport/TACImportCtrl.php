<?php
namespace tgui\Controllers\TAC\TACImport;

use tgui\Controllers\Controller;

use Respect\Validation\Validator as v;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class TACImportCtrl extends Controller
{
  public function postFile($req,$res)
  {
  	//INITIAL CODE////START//
  	$data=array();
  	$data=$this->initialData([
  		'type' => 'post',
  		'object' => 'import',
  		'action' => 'file',
  	]);
  	#check error#
  	if ($_SESSION['error']['status']){
  		$data['error']=$_SESSION['error'];
  		return $res -> withStatus(401) -> write(json_encode($data));
  	}
  	//INITIAL CODE////END//
    //CHECK ACCESS TO THAT FUNCTION//START//
    if(!$this->checkAccess(1))
    {
      return $res -> withStatus(403) -> write(json_encode($data));
    }
    //CHECK ACCESS TO THAT FUNCTION//END//
    shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');

    foreach ($_FILES as $key => $value) {
			$data['name'] = $_FILES[$key]['name'];
			$data['path'] = $_FILES[$key]['tmp_name'];
		}

    if (!v::file()->readable()->size(null, '5MB')->validate($data['path'])){
      $data['error']['status']=true;
			$data['error']['validation']=['file' => ['Incorrect file!']];
			return $res -> withStatus(200) -> write(json_encode($data));
    }

    $data['csv'] = array_map('str_getcsv', file($data['path']));
    array_walk($data['csv'], function(&$a) use ($data) {
      $a = array_combine($data['csv'][0], $a);
    });
    $header = $data['csv'][0];
    array_shift($data['csv']);

    if (in_array('id', $header)){
      $data['output'] = [['name'=>'Header Error', 'validation'=>['Please delete ID column']]];
      return $res -> withStatus(200) -> write(json_encode($data));
    }

    $data['output'] = [];

    switch ($req->getParam('target')) {
      case 'addresses':
        $data['output'] = $this->addresses($data['csv'], $header);
        break;
      case 'devices':
        $data['output'] = $this->tac_devices($data['csv'], $header);
        break;
      case 'device-groups':
        $data['output'] = $this->tac_device_groups($data['csv'], $header);
        break;
      case 'tac_users':
        $data['output'] = $this->tac_users($data['csv'], $header);
        break;
      case 'tac_user_groups':
        $data['output'] = $this->tac_user_groups($data['csv'], $header);
        break;
      default:
        $data['output'] = [['name'=>'Server Error', 'validation'=>['Something goes wrong']]];
        return $res -> withStatus(200) -> write(json_encode($data));
    }

    if (array_search(true, array_column($data['output'], 'db_status')) !== false ){
      $data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
    }

    return $res -> withStatus(200) -> write(json_encode($data));
  }

  public function checkHeader($header_main, $header_csv){
    for ($i=0; $i < count($header_main); $i++) {
      if (!v::in($header_csv)->validate($header_main[$i]))
        return false;
    }

    return true;
  }

  public function addresses($items = [], $header = []){
    $itemHeader = ['address', 'name'];
    if (!$this->checkHeader($itemHeader, $header))
      return [['name'=>'File Error', 'validation'=>['Incorrect file header. Please, use required columns '. implode(', ', $itemHeader)]]];
    $output = [];
    for ($i=0; $i < count($items); $i++) {
      $items[$i]['type'] = $this->ObjAddress->selectType(@$items[$i]['type']);

      $validation = $this->ObjAddress->itemValidation($items[$i]);
      $output[$i] = [
        'name' => $items[$i]['name'],
        'messages' => [],
        'validation' => $validation->getMessages(),
        'db_status' => false
      ];
      if (empty($output[$i]['validation']))
        try {
          $output[$i]['db_status'] = $this->db::table('obj_addresses')->insert(
            array_merge($items[$i], ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')])
          );
        } catch (\Exception $e) {
          $output[$i]['validation'][] = $e->getMessage();
        }
    }

    return $output;
  }

  public function tac_devices($items = [], $header = []){
    $itemHeader = ['address', 'name'];
    if (!$this->checkHeader($itemHeader, $header))
      return [['name'=>'File Error', 'validation'=>['Incorrect file header. Please, use required columns '. implode(', ', $itemHeader)]]];
    $output = [];

    for ($i=0; $i < count($items); $i++) {
      $messages = [];
      list($addrId, $messages) = $this->ObjAddress->getAddressId($items[$i]['address'], $items[$i]['name']);
      if (empty($addrId))
        return [['name'=>'Object Error', 'validation'=> $messages]];

      if (!empty($items[$i]['acl'])){
        list($items[$i]['acl'], $messages) = $this->TACACLCtrl->getAclId($items[$i]['acl']);
        if (empty($items[$i]['acl']))
          return [['name'=>'ACL Error', 'validation'=> $messages]];
      }

      $items[$i]['address'] = $addrId;

      $validation = $this->TACDevicesCtrl->itemValidation($items[$i]);
      $output[$i] = [
        'name' => $items[$i]['name'],
        'validation' => $validation->getMessages(),
        'messages' => $messages,
        'db_status' => false
      ];
      if (empty($output[$i]['validation']))
        try {
          $output[$i]['db_status'] = $this->db::table('tac_devices')->insert(
            array_merge($items[$i], ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            )
          );
        } catch (\Exception $e) {
          $output[$i]['validation'][] = $e->getMessage();
        }
    }

    return $output;
  }

  public function tac_device_groups($items = [], $header = []){
    $itemHeader = ['name'];
    if (!$this->checkHeader($itemHeader, $header))
      return [['name'=>'File Error', 'validation'=>['Incorrect file header. Please, use required columns '. implode(', ', $itemHeader)]]];
    $output = [];

    for ($i=0; $i < count($items); $i++) {
      $messages = [];

      if (!empty($items[$i]['acl'])){
        list($items[$i]['acl'], $messages) = $this->TACACLCtrl->getAclId($items[$i]['acl']);
        if (empty($items[$i]['acl']))
          return [['name'=>'ACL Error', 'validation'=> $messages]];
      }

      $validation = $this->TACDeviceGrpsCtrl->itemValidation($items[$i]);
      $output[$i] = [
        'name' => $items[$i]['name'],
        'validation' => $validation->getMessages(),
        'messages' => $messages,
        'db_status' => false
      ];
      if (empty($output[$i]['validation']))
        try {
          $output[$i]['db_status'] = $this->db::table('tac_device_groups')->insert(
            array_merge($items[$i], ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            )
          );
        } catch (\Exception $e) {
          $output[$i]['validation'][] = $e->getMessage();
        }
    }

    return $output;
  }

  public function tac_users($items = [], $header = []){
    $itemHeader = ['username','login'];
    if (!$this->checkHeader($itemHeader, $header))
      return [['name'=>'File Error', 'validation'=>['Incorrect file header. Please, use required columns '. implode(', ', $itemHeader)]]];
    $output = [];

    for ($i=0; $i < count($items); $i++) {
      $messages = [];

      if (!empty($items[$i]['acl'])){
        list($items[$i]['acl'], $messages) = $this->TACACLCtrl->getAclId($items[$i]['acl']);
        if (empty($items[$i]['acl']))
          return [['name'=>'ACL Error', 'validation'=> $messages]];
      }

      $validation = $this->TACUsersCtrl->itemValidation($items[$i]);
      $output[$i] = [
        'name' => $items[$i]['username'],
        'validation' => $validation->getMessages(),
        'messages' => $messages,
        'db_status' => false
      ];
      if (empty($output[$i]['validation']))
        try {
          $output[$i]['db_status'] = $this->db::table('tac_users')->insert(
            array_merge($items[$i], ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            )
          );
        } catch (\Exception $e) {
          $output[$i]['validation'][] = $e->getMessage();
        }
    }

    return $output;
  }

  public function tac_user_groups($items = [], $header = []){
    $itemHeader = ['name'];
    if (!$this->checkHeader($itemHeader, $header))
      return [['name'=>'File Error', 'validation'=>['Incorrect file header. Please, use required columns '. implode(', ', $itemHeader)]]];
    $output = [];

    for ($i=0; $i < count($items); $i++) {
      $messages = [];

      if (!empty($items[$i]['acl'])){
        list($items[$i]['acl'], $messages) = $this->TACACLCtrl->getAclId($items[$i]['acl']);
        if (empty($items[$i]['acl']))
          return [['name'=>'ACL Error', 'validation'=> $messages]];
      }

      $validation = $this->TACUserGrpsCtrl->itemValidation($items[$i]);
      $output[$i] = [
        'name' => $items[$i]['name'],
        'validation' => $validation->getMessages(),
        'messages' => $messages,
        'db_status' => false
      ];
      if (empty($output[$i]['validation']))
        try {
          $output[$i]['db_status'] = $this->db::table('tac_user_groups')->insert(
            array_merge($items[$i], ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            )
          );
        } catch (\Exception $e) {
          $output[$i]['validation'][] = $e->getMessage();
        }
    }

    return $output;
  }

}
