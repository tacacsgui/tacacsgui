<?php
namespace tgui\Controllers\TAC\TACExport;

use tgui\Models\TACDevices;

use tgui\Controllers\Controller;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class TACExportCtrl extends Controller
{
  public function getExport($req,$res)
  {
  	//INITIAL CODE////START//
  	$data=array();
  	$data=$this->initialData([
  		'type' => 'get',
  		'object' => 'export',
  		'action' => 'tacacs',
  	]);
  	#check error#
  	if ($_SESSION['error']['status']){
  		$data['error']=$_SESSION['error'];
  		return $res -> withStatus(401) -> write(json_encode($data));
  	}
  	//INITIAL CODE////END//
    shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');

    $model = false;
    $path = TAC_ROOT_PATH . '/temp/';
    $allParams = $req->getParams();
    $allParams['ids'] = isset($allParams['ids']) ? explode(',',$allParams['ids']) : [];
    $query = false;
    $columns = [];

    switch ( $allParams['target'] ) {
      case 'devices':
        list($columns, $query)= $this->getTacDevices($allParams);
        // $model = new TACDevices;
        $mainName = 'tac_devices';
        break;
      case 'device-groups':
        list($columns, $query)= $this->getTacDeviceGroups($allParams);
        // $model = new TACDevices;
        $mainName = 'tac_device_groups';
        break;
      case 'addresses':
        list($columns, $query)= $this->getObjAddr($allParams);
        $mainName = 'obj_addresses';
        break;
      case 'tac_users':
        list($columns, $query)= $this->getTacUsers($allParams);
        $mainName = 'tac_users';
        break;
      case 'tac_user_groups':
        list($columns, $query)= $this->getTacUserGroups($allParams);
        $mainName = 'tac_user_groups';
        break;
    }

    if ( !$query ){
      echo '<h1>Query error! Sorry</h1>';
			return $res -> withStatus(500) -> withHeader('Content-type', 'text/html');
    }

  	$filename = $mainName.'_'. $this->generateRandomString(8) .'.csv';
  	//$columns = $this->APICheckerCtrl->getTableTitles($mainName);
    $f = fopen($path.$filename, 'w');
    $resArray = [];
    $resArray = $query->get()->toArray();// : $query->whereIn('id', $allParams['ids'])->get()->toArray();

    fputcsv($f, $columns /*, ',)'*/);
    $resArray = json_decode(json_encode($resArray), true);
    foreach ($resArray as $line) {
      fputcsv($f, $line /*, ',)'*/);
    }

    if ( !file_exists($path.$filename) ) {
			echo '<h1>Error. File '.$path . $file .' Not Found</h1>';
			return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
		}

    header("X-Sendfile: ".$path."".$filename);
    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    exit(0);

  }

  public function getTacDevices($params = []){
    $columns = $this->db::getSchemaBuilder()->getColumnListing('tac_devices');
    $query = $this->db::table('tac_devices')->select(['tac_devices.*', 'addr.address as address'])->
    leftJoin('obj_addresses as addr', 'addr.id','=','tac_devices.address');
    if ( count($params['ids']) ) $query->whereIn('tac_devices.id', $params['ids']);
    return [$columns, $query];
  }

  public function getTacDeviceGroups($params = []){
    $columns = $this->db::getSchemaBuilder()->getColumnListing('tac_device_groups');
    $query = $this->db::table('tac_device_groups')->select(['tac_device_groups.*']);
    if ( count($params['ids']) ) $query->whereIn('id', $params['ids']);
    return [$columns, $query];
  }

  public function getObjAddr($params = []){
    $columns = $this->db::getSchemaBuilder()->getColumnListing('obj_addresses');
    $query = $this->db::table('obj_addresses')->select(["obj_addresses.*", $this->db::raw("IF(obj_addresses.type=1,'ipv6','ipv4') as type")]);
    if ( count($params['ids']) ) $query->whereIn('obj_addresses.id', $params['ids']);
    return [$columns, $query];
  }

  public function getTacUsers($params = []){
    $columns = $this->db::getSchemaBuilder()->getColumnListing('tac_users');
    if (($key = array_search('login', $columns)) !== false) {
      unset($columns[$key]);
    }
    if (($key = array_search('login_date', $columns)) !== false) {
      unset($columns[$key]);
    }
    if (($key = array_search('mavis_otp_secret', $columns)) !== false) {
      unset($columns[$key]);
    }

    $query = $this->db::table('tac_users')->select($columns);
    if ( count($params['ids']) ) $query->whereIn('tac_users.id', $params['ids']);
    return [$columns, $query];
  }

  public function getTacUserGroups($params = []){
    $columns = $this->db::getSchemaBuilder()->getColumnListing('tac_user_groups');

    $query = $this->db::table('tac_user_groups')->select($columns);
    if ( count($params['ids']) ) $query->whereIn('tac_user_groups.id', $params['ids']);
    return [$columns, $query];
  }

}
