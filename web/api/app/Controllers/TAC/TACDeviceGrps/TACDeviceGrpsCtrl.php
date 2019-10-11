<?php

namespace tgui\Controllers\TAC\TACDeviceGrps;

use tgui\Models\TACDeviceGrps;
use tgui\Models\TACDevices;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACDeviceGrpsCtrl extends Controller
{

	public function itemValidation($req = [], $state = 'add'){
		$id = 0;
		if (is_object($req)){
			$id = ($state == 'edit') ? $req->getParam('id') : 0;
		}

		$policy = APIPWPolicy::select()->first(1);
		return $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\TACDeviceGrps', $id )->theSameNameUsed( '\tgui\Models\TACDevices' ),
			'enable' => v::when( v::oneOf( v::nullType(), v::equals('') ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->setName('Enable') ),
			'enable_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('2'), v::equals('0') ) ),
			'key' => v::noWhitespace()->prohibitedChars(),
		]);
	}

################################################
	#########	POST Add New Device	Group#########
	public function postDeviceGroupAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device group',
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
		if(!$this->checkAccess(3))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->itemValidation($req);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ($allParams['default_flag']) TACDeviceGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);

		if ( ! empty( $allParams['enable'] ) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'], 1);
		}

		$deviceGroup = TACDeviceGrps::create($allParams);

		$data['deviceGroup']=$deviceGroup;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'obj_name' => $deviceGroup['name'], 'obj_id' => $deviceGroup['id'], 'section' => 'tacacs device groups', 'message' => 202);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New Device Group	###############END###########
################################################
########	Edit Device	Group###############START###########
	#########	GET Edit Device	Group#########
	public function getDeviceGroupEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'device group',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(3))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['group']=TACDeviceGrps::select()->
			where('id',$req->getParam('id'))->
			first();

		$data['group']->acl = $this->db->table('tac_acl')->
			select(['name as text','id'])->where('id',$data['group']->acl)->get();

		$data['group']->user_group = $this->db->table('tac_user_groups')->
			select(['name as text','id'])->where('id',$data['group']->user_group)->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit Device Group	#########
	public function postDeviceGroupEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device group',
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
		if(!$this->checkAccess(3))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->itemValidation($req, 'edit');

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ($allParams['default_flag']) TACDeviceGrps::where('default_flag', 1)->update(['default_flag' => 0]);

		if ( ! empty( $allParams['enable'] ) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'], 1);
		}

		$id = $allParams['id'];

		unset($allParams['id']);
		unset($allParams['enable_encrypt']);

		$data['save']=TACDeviceGrps::where('id',$id)->
			update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$name = TACDeviceGrps::select('name')->where([['id','=',$id]])->first();

		$logEntry=array('action' => 'edit', 'obj_name' => $name['name'], 'obj_id' => $id, 'section' => 'tacacs device groups', 'message' => 302);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit Device	Group###############END###########
################################################
########	Delete Device Group	###############START###########
	#########	GET Delete Device Group	#########
	// public function getDeviceGroupDelete($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'device group',
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

	#########	POST Delete Device	Group#########
	public function postDeviceGroupDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device group',
			'action' => 'delete',
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
		if(!$this->checkAccess(3))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		if (TACDeviceGrps::select()->where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name')],['default_flag','=',1]])->count()) {
			$data['error']['status']=true;
			$data['error']['reason']='default_flag';
			$data['error']['message']="You can't delete the default group";
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['result'] = 0;

		if (TACDevices::where([['group','=',$req->getParam('id')]])->count())
		{
			$defaultGroup=TACDeviceGrps::select('id')->where([['default_flag','=',1]])->first();
			TACDevices::where([['group','=',$req->getParam('id')]])->update([
				'group' => $defaultGroup['id'],
			]);
		}

		$data['result']=TACDeviceGrps::where([
			['id','=',$req->getParam('id')],
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'tacacs device groups', 'message' => 402);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete Device Group	###############END###########
################################################
#########	POST CSV Device	Group#########
public function postDeviceGroupCsv($req,$res)
{
	//INITIAL CODE////START//
	$data=array();
	$data=$this->initialData([
		'type' => 'post',
		'object' => 'device group',
		'action' => 'csv',
	]);
	#check error#
	if ($_SESSION['error']['status']){
		$data['error']=$_SESSION['error'];
		return $res -> withStatus(401) -> write(json_encode($data));
	}
	//INITIAL CODE////END//
	//CHECK ACCESS TO THAT FUNCTION//START//
	if(!$this->checkAccess(3))
	{
		return $res -> withStatus(403) -> write(json_encode($data));
	}
	//CHECK ACCESS TO THAT FUNCTION//END//
	$data['clear'] = shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');
	$path = TAC_ROOT_PATH . '/temp/';
	$filename = 'tac_device_groups_'. $this->generateRandomString(8) .'.csv';

	$columns = $this->APICheckerCtrl->getTableTitles('tac_device_groups');

  $f = fopen($path.$filename, 'w');
	$idList = $req->getParam('idList');
	$array = [];
	$array = ( empty($idList) ) ? TACDeviceGrps::select($columns)->get()->toArray() : TACDeviceGrps::select($columns)->whereIn('id', $idList)->get()->toArray();

	fputcsv($f, $columns /*, ',)'*/);
  foreach ($array as $line) {
	fputcsv($f, $line /*, ',)'*/);
  }

	$data['filename']=$filename;
	sleep(3);
	return $res -> withStatus(200) -> write(json_encode($data));
}
########	CSV Device	Group###############END###########
################################################
########	Device Groups Datatables ###############START###########
	#########	POST Device Groups Datatables	#########
	public function postDeviceGroupsDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device group',
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
		if(!$this->checkAccess(3, true))
		{
			$data['data'] = [];
			$data['recordsTotal'] = 0;
			$data['recordsFiltered'] = 0;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = $this->APICheckerCtrl->getTableTitles('tac_device_groups'); //Array of all columnes that will used
		array_unshift( $columns, 'id' );
		array_push( $columns, 'created_at', 'updated_at' );
		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];
		//Filter end
		$data['recordsTotal'] = TACDeviceGrps::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACDeviceGrps::select($columns)->
		select($columns)->
		when( !empty($queries),
			function($query) use ($queries)
			{
				$query->where('name','LIKE', '%'.$queries.'%');
				return $query;
			});

		$data['recordsFiltered'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	Device Groups Datatables	###############END###########
################################################
########	List Device Group	###############START###########
	#########	GET List Device	Group#########
	public function getDeviceGroupList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'device group',
			'action' => 'list',
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

			$data['results'] = TACDeviceGrps::select(['id','name AS text'])->whereIn('id', $id)->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = TACDeviceGrps::select(['id','name as text']);
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('name','asc')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List Device Group	###############END###########
################################################

}//END OF CLASS//
