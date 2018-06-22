<?php

namespace tgui\Controllers\TACServices;

use tgui\Models\TACServices;
use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACServicesCtrl extends Controller
{
################################################
########	Add New Service	###############START###########
	#########	GET Add New Service	#########
	// public function getServiceAdd($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'service',
	// 		'action' => 'add',
	// 	]);
	// 	#check error#
	// 	if ($_SESSION['error']['status']){
	// 		$data['error']=$_SESSION['error'];
	// 		return $res -> withStatus(401) -> write(json_encode($data));
	// 	}
	// 	//INITIAL CODE////END//
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
	// }

	#########	POST Add New Service	#########
	public function postServiceAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->serviceTacAvailable(0),
			'priv-lvl' => v::noWhitespace()->numeric()->between(-1, 15),
			'default_cmd' => v::noWhitespace()->boolVal(),
			'manual_conf_only' => v::noWhitespace()->boolVal(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$service = TACServices::create($allParams);

		$data['service']=$service;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'objectName' => $service['name'], 'objectId' => $service['id'], 'section' => 'tacacs services', 'message' => 208);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New Service	###############END###########
################################################
########	Edit Service	###############START###########
	#########	GET Edit Service	#########
	public function getServiceEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'service',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['service']=TACServices::select()->
			where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name')]])->
			first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit ACL	#########
	public function postServiceEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::notEmpty()->serviceTacAvailable($req->getParam('id'))),
			'priv-lvl' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()->between(-1, 15)),
			'default_cmd' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::boolVal()),
			'manual_conf_only' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::boolVal()),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$id = $allParams['id'];
		unset($allParams['id']);

		$data['service_update']=TACServices::where([['id','=',$req->getParam('id')]])->
			update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$name = TACServices::select('name')->where([['id','=',$id]])->first();

		$logEntry=array('action' => 'edit', 'objectName' => $name['name'], 'objectId' => $id, 'section' => 'tacacs services', 'message' => 308);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit Service	###############END###########
################################################
########	Delete Service	###############START###########
	#########	GET Delete Service	#########
	// public function getServiceDelete($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'service',
	// 		'action' => 'delete',
	// 	]);
	// 	#check error#
	// 	if ($_SESSION['error']['status']){
	// 		$data['error']=$_SESSION['error'];
	// 		return $res -> withStatus(401) -> write(json_encode($data));
	// 	}
	// 	//INITIAL CODE////END//
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
	// }

	#########	POST Delete Service	#########
	public function postServiceDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=TACServices::where([
			['id','=',$req->getParam('id')],
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs services', 'message' => 408);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['footprints_users']=TACUsers::where([['service','=',$req->getParam('id')]])->update(['service' => '0']);
		$data['footprints_groups']=TACUserGrps::where([['service','=',$req->getParam('id')]])->update(['service' => '0']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete Service	###############END###########
################################################
########	Service Datatables ###############START###########
	#########	POST Service Datatables	#########
	public function postServiceDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
			'action' => 'datatables',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = array(
		// datatable column index  => database column name
			0 => 'id',
			1 => 'name',
		); //Array of all columnes that will used

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACServices::select()->
			when($params['columns'][0]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[1],'LIKE','%'.$params['columns'][1]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables
		$data['data']=array();
		foreach($tempData as $service){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_service.getService(\''.$service['id'].'\',\''.$service['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_service.delete(\''.$service['id'].'\',\''.$service['name'].'\')">Del</button>';
			$service['buttons'] = $buttons;
			array_push($data['data'],$service);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = TACServices::select()->count();
		$data['recordsFiltered'] = TACServices::select()->
			when($params['columns'][0]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[1],'LIKE','%'.$params['columns'][1]['search']['value'].'%');
				}) ->
				count();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	Service Datatables	###############END###########
################################################
################################################
########	List of Services	###############START###########
	#########	GET List Services#########
	public function getServiceList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'services',
			'action' => 'list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$noneItem = array('id' => 0, 'text' => 'None');
		///IF GROUPID SET///
		if ($req->getParam('byId') != null){
			if ($req->getParam('byId') == 0)
			{
				$data['item']=$noneItem;
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			$data['item'] = TACServices::select(['id','name'])->
			where([['id', '=', $req->getParam('byId')]])->
			first();

			$data['item']['text'] = $data['item']['name'];
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = TACServices::select(['id','name'])->count();
		$tempData = TACServices::select(['id','name'])->get()->toArray();
		$data['items']=array( 0 => $noneItem);
		foreach($tempData as $group)
		{
			$group['text'] = $group['name'];
			array_push($data['items'],$group);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List of Services	###############END###########
################################################

}//END OF CLASS//
