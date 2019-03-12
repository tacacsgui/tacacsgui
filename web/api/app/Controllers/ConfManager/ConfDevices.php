<?php

namespace tgui\Controllers\ConfManager;

use tgui\Models\Conf_Devices;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;
use tgui\Controllers\ConfManager\ConfManagerHelper as Helper;

class ConfDevices extends Controller
{
################################################
	public function postAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confDevices',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Devices' ),
			'ip' => v::ip()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Devices', 0, 'ip' ),
			'protocol' => v::notEmpty()->oneOf( v::equals('ssh'), v::equals('telnet') ),
			'port' => v::numeric()->notEmpty()->between(1, 65535),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		$creden = (empty( $allParams['creden'] )) ? false : $allParams['creden'];
		$tac_dev = (empty( $allParams['tac_dev'] )) ? false : $allParams['tac_dev'];
		unset($allParams['creden']);
		unset($allParams['tac_dev']);

		$device = Conf_Devices::create($allParams);

		if ($creden) $this->db::table('confM_bind_devices_creden')->insert(['device_id' => $device->id, 'creden_id' => $creden]);
		if ($tac_dev) $this->db::table('confM_bind_cmdev_tacdev')->insert(['cm_dev' => $device->id, 'tac_dev' => $tac_dev]);

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confDevices',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'id' => v::numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['device'] = Conf_Devices::leftJoin('confM_bind_devices_creden as dc', 'confM_devices.id', '=', 'device_id')->
		leftJoin('confM_bind_cmdev_tacdev as ct', 'confM_devices.id', '=', 'ct.cm_dev')->
		select('confM_devices.*','creden_id as creden','ct.tac_dev as tac_dev')->where('id', $req->getParam('id'))->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
////////////////////////////////////////////////////////////
	public function postEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confDevices',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

    $validation = $this->validator->validate($req, [
			'name' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Devices' )->setName('Name') ),
			'ip' => v::when( v::nullType() , v::alwaysValid(), v::ip()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Devices', 0, 'ip' )->setName('IP Address') ),
			'protocol' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()->oneOf( v::equals('ssh'), v::equals('telnet') )->setName('Protocol') ),
			'port' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->notEmpty()->between(1, 65535)->setName('Port') ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		$name_old = '';
		if (isset($allParams['name_old'])) {
			$name_old = $allParams['name_old'];
			unset($allParams['name_old']);
		}
		$creden = ( !isset( $allParams['creden'] ) ) ? false : $allParams['creden'];
		$tac_dev = ( !isset( $allParams['tac_dev'] ) ) ? false : $allParams['tac_dev'];
		unset($allParams['creden']);
		unset($allParams['tac_dev']);

		$cmd = Conf_Devices::where( 'id', $req->getParam('id') )->update($allParams);

		if ( $creden !== false ){
			$this->db::table('confM_bind_devices_creden')->where( 'device_id', $req->getParam('id') )->delete();
			if ($creden != '') $this->db::table('confM_bind_devices_creden')->insert(['device_id' => $req->getParam('id'), 'creden_id' => $creden]);
		}
		if ( $tac_dev !== false ){
			$this->db::table('confM_bind_cmdev_tacdev')->where( 'cm_dev', $req->getParam('id') )->delete();
			if ($tac_dev != '') $this->db::table('confM_bind_cmdev_tacdev')->insert(['cm_dev' => $req->getParam('id'), 'tac_dev' => $tac_dev]);
		}

		if ($name_old AND $allParams['name']) {
			$data['rename']=Helper::deviceRename($name_old, $allParams['name']);
		}

		if ( $this->db::table('confM_bind_query_devices')->where( 'device_id', $req->getParam('id') )->count() ){
			$this->ConfManager->createConfig();
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////////////////
	public function postDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confDevices',
			'action' => 'del',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty(),//->theSameNameUsed( '\tgui\Models\Conf_Devices' ),
			'id' => v::numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ( $this->db::table('confM_bind_query_devices')->where( 'device_id', $req->getParam('id') )->count() ){
			$data['result'] = 0;
		} else $data['result'] = Conf_Devices::where( 'id', $req->getParam('id') )->delete();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

  public function postDatatables($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'post',
      'object' => 'confDevices',
      'action' => 'datatables',
    ]);
    #check error#
    if ($_SESSION['error']['status']){
      $data['error']=$_SESSION['error'];
      return $res -> withStatus(401) -> write(json_encode($data));
    }
    //INITIAL CODE////END//

    unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

    //CHECK ACCESS TO THAT FUNCTION//START//
    if(!$this->checkAccess(4, true))
    {
      $data['data'] = [];
      $data['recordsTotal'] = 0;
      $data['recordsFiltered'] = 0;
      return $res -> withStatus(200) -> write(json_encode($data));
    }
    //CHECK ACCESS TO THAT FUNCTION//END//

    $params = $req->getParams(); //Get ALL parameters form Datatables

    $columns = $this->APICheckerCtrl->getTableTitles('confM_devices'); //Array of all columnes that will used
    array_unshift( $columns, 'id' );
    array_push( $columns, 'created_at', 'updated_at', 'ct.tac_dev as tacdev_id', 'dc.creden_id as creden_id' );
    $data['columns'] = $columns;
    $queries = [];
    $data['filter'] = [];
    $data['filter']['error'] = false;
    $data['filter']['message'] = '';
    //Filter start
    $searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
    $temp = $this->queriesMaker($columns, $searchString);
    $queries = $temp['queries'];
    $data['filter'] = $temp['filter'];

    $data['queries'] = $queries;
    $data['columns'] = $columns;
    //Filter end
    $data['recordsTotal'] = Conf_Devices::count();
    //Get temp data for Datatables with Fliter and some other parameters
    $tempData = Conf_Devices::select($columns)->
			leftJoin('confM_bind_cmdev_tacdev as ct', 'confM_devices.id', '=', 'ct.cm_dev')->
			leftJoin('confM_bind_devices_creden as dc', 'confM_devices.id', '=', 'dc.device_id')->
      when( !empty($queries),
        function($query) use ($queries)
        {
          foreach ($queries as $condition => $attr) {
            switch ($condition) {
              case '!==':
                foreach ($attr as $column => $value) {
                  $query->whereNotIn($column, $value);
                }
                break;
              case '==':
                foreach ($attr as $column => $value) {
                  $query->whereIn($column, $value);
                }
                break;
              case '!=':
                foreach ($attr as $column => $valueArr) {
                  for ($i=0; $i < count($valueArr); $i++) {
                    if ($i == 0) $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
                    $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
                  }
                }
                break;
              case '=':
                foreach ($attr as $column => $valueArr) {
                  for ($i=0; $i < count($valueArr); $i++) {
                    if ($i == 0) $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
                    $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
                  }
                }
                break;
              default:
                //return $query;
                break;
            }
          }
          return $query;
        });
        $data['recordsFiltered'] = $tempData->count();

  			$tempData = $tempData->
  			orderBy($params['columns'][$params['order'][0]['column']]['data'],$params['order'][0]['dir'])->
  			take($params['length'])->
  			offset($params['start'])->
  			get()->toArray();
  		//Creating correct array of answer to Datatables
  		$data['data']=array();
  		foreach($tempData as $device){
  			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="cm_devices.get(\''.$device['id'].'\',\''.$device['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="cm_devices.del(\''.$device['id'].'\',\''.$device['name'].'\')">Del</button>';
  			$device['buttons'] = $buttons;
  			array_push($data['data'],$device);
  		}
  		//Some additional parameters for Datatables
  		$data['draw']=intval( $params['draw'] );

  		return $res -> withStatus(200) -> write(json_encode($data));
  }

	public function getList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confmanager',
			'action' => 'device list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(3, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('byId') != null){
			$id = $req->getParam('byId');

			$data['item'] = ( is_array($id) ) ? Conf_Devices::select(['id','name AS text'])->whereIn('id', $id)->get() : Conf_Devices::select(['id','name AS text'])->where('id', $req->getParam('byId') )->first();
			//$data['item']['text'] = $data['item']['name'];
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = Conf_Devices::select(['id','name'])->count();
		$search = $req->getParam('search');
		$take = 10 * $req->getParam('page');
		$offset = 10 * ($req->getParam('page') - 1);
		$data['take'] = $take;
		$data['offset'] = $offset;
		$tempData = Conf_Devices::select(['id','name AS text'])->
			when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			})->
			take($take)->
			offset($offset);

		$tempCounter = $tempData->count();

		$tempData = $tempData->get()->toArray();
		$data['results']=array();
		$data['pagination'] = (!$tempData OR $tempCounter < 10) ? ['more' => false] : [ 'more' => true];
		foreach($tempData as $model)
		{
			//$model['text'] = $model['name'];
			//unset($model['name']);
			array_push($data['results'],$model);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}

}//END OF CLASS//
