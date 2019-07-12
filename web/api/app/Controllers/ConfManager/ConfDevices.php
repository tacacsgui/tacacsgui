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
			'address' => v::notEmpty()->numeric(),
			'protocol' => v::notEmpty()->oneOf( v::equals('ssh'), v::equals('telnet') ),
			'port' => v::numeric()->notEmpty()->between(1, 65535),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		if ( empty($allParams['credential']) ) unset($allParams['credential']);
		if ( empty($allParams['tac_device']) ) unset($allParams['tac_device']);

		$device = Conf_Devices::create($allParams);

		$data['device'] = 1;

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

		$data['device'] = Conf_Devices::leftJoin('confM_credentials as cc','cc.id','=','confM_devices.credential')->
		select(['confM_devices.*', 'cc.name as credo_name'])->
		where('confM_devices.id', $req->getParam('id'))->first();

		$data['device']['address'] = $this->db->table('obj_addresses')->
			select(['name as text','id','type','address'])->where('id',$data['device']->address)->get();
		$data['device']['credential'] = (empty($data['device']['credo_name'])) ?
			[] : [[ 'id' => $data['device']['credential'], 'text' => $data['device']['credo_name']]];
		unset($data['device']['credo_name']);

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
			'name' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notEmpty()->
				theSameNameUsed( '\tgui\Models\Conf_Devices', $req->getParam('id') )->setName('Name') ),
			'address' => v::notEmpty()->numeric(),
			'protocol' => v::notEmpty()->oneOf( v::equals('ssh'), v::equals('telnet') )->setName('Protocol'),
			'port' => v::numeric()->notEmpty()->between(1, 65535)->setName('Port'),
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

		if ( isset($allParams['credential']) AND $allParams['credential'] == '') $allParams['credential'] = null;
		if ( isset($allParams['tac_device']) AND $allParams['tac_device'] == '' ) $allParams['tac_device'] = null;

		$cmd = Conf_Devices::where( 'id', $req->getParam('id') )->update($allParams);

		if ($name_old AND $allParams['name']) {
			$data['rename']=Helper::deviceRename($name_old, $allParams['name']);
		}

		if ( $this->db::table('confM_bind_query_devices')->where( 'device_id', $req->getParam('id') )->count() ){
			$this->ConfManager->createConfig();
		}

		$data['save'] = 1;

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

    $columns = []; //$this->APICheckerCtrl->getTableTitles('confM_devices'); //Array of all columnes that will used
    array_unshift( $columns, 'confM_devices.*' );
    array_push( $columns, 'cre.name as creden_name',
		 	'td.name as tgui_device',
			$this->db::raw('(SELECT COUNT(*) FROM confM_bind_query_devices WHERE device_id = qd.device_id) as ref') );
		if (($key = array_search('name', $columns)) !== false) {
    	unset($columns[$key]);
			array_push( $columns, 'confM_devices.name as name');
		}

		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		//Filter end
		$data['recordsTotal'] = Conf_Devices::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Conf_Devices::select($columns)->
			leftJoin('tac_devices as td', 'td.id', '=', 'confM_devices.tac_device')->
			leftJoin('confM_credentials as cre', 'cre.id', '=', 'confM_devices.credential')->
			leftJoin('confM_bind_query_devices as qd', 'qd.device_id', '=', 'confM_devices.id')->
			groupBy('confM_devices.id')->
			select($columns);
		// when( !empty($queries),
		// 	function($query) use ($queries)
		// 	{
		// 		$query->where('username','LIKE', '%'.$queries.'%');
		// 		return $query;
		// 	});
		$data['recordsFiltered'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));

    // $data['columns'] = $columns;
    // $queries = [];
    // $data['filter'] = [];
    // $data['filter']['error'] = false;
    // $data['filter']['message'] = '';
    // //Filter start
    // $searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
    // $temp = $this->queriesMaker($columns, $searchString);
    // $queries = $temp['queries'];
    // $data['filter'] = $temp['filter'];
		//
    // $data['queries'] = $queries;
    // $data['columns'] = $columns;
    // //Filter end
    // $data['recordsTotal'] = Conf_Devices::count();
    // //Get temp data for Datatables with Fliter and some other parameters
    // $tempData = Conf_Devices::select($columns)->
		// 	leftJoin('tac_devices as td', 'td.id', '=', 'confM_devices.tac_device')->
		// 	leftJoin('confM_credentials as cre', 'cre.id', '=', 'confM_devices.credential')->
		// 	leftJoin('confM_bind_query_devices as qd', 'qd.device_id', '=', 'confM_devices.id')->
		// 	groupBy('confM_devices.id')->
    //   when( !empty($queries),
    //     function($query) use ($queries)
    //     {
    //       foreach ($queries as $condition => $attr) {
    //         switch ($condition) {
    //           case '!==':
    //             foreach ($attr as $column => $value) {
    //               $query->whereNotIn($column, $value);
    //             }
    //             break;
    //           case '==':
    //             foreach ($attr as $column => $value) {
    //               $query->whereIn($column, $value);
    //             }
    //             break;
    //           case '!=':
    //             foreach ($attr as $column => $valueArr) {
    //               for ($i=0; $i < count($valueArr); $i++) {
    //                 if ($i == 0) $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
    //                 $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
    //               }
    //             }
    //             break;
    //           case '=':
    //             foreach ($attr as $column => $valueArr) {
    //               for ($i=0; $i < count($valueArr); $i++) {
    //                 if ($i == 0) $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
    //                 $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
    //               }
    //             }
    //             break;
    //           default:
    //             //return $query;
    //             break;
    //         }
    //       }
    //       return $query;
    //     });
    //     $data['recordsFiltered'] = $tempData->count();
		//
  	// 		$tempData = $tempData->
  	// 		orderBy($params['columns'][$params['order'][0]['column']]['data'],$params['order'][0]['dir'])->
  	// 		take($params['length'])->
  	// 		offset($params['start'])->
  	// 		get()->toArray();
  	// 		//toSql();
		// 	//var_dump($tempData);die();
  	// 	//Creating correct array of answer to Datatables
  	// 	$data['data']=array();
  	// 	foreach($tempData as $device){
  	// 		$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="cm_devices.get(\''.$device['id'].'\',\''.$device['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="cm_devices.del(\''.$device['id'].'\',\''.$device['name'].'\')">Del</button>';
  	// 		$device['buttons'] = $buttons;
  	// 		array_push($data['data'],$device);
  	// 	}
  	// 	//Some additional parameters for Datatables
  	// 	$data['draw']=intval( $params['draw'] );
		//
  	// 	return $res -> withStatus(200) -> write(json_encode($data));
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
		if ($req->getParam('id') != null){
			$id = explode(',', $req->getParam('id'));

			$data['results'] = Conf_Devices::select(['id','name AS text'])->whereIn('id', $id)->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = Conf_Devices::select(['id','name as text']);
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('name')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

}//END OF CLASS//
