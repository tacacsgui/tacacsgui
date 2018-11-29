<?php

namespace tgui\Controllers\TACDeviceGrps;

use tgui\Models\TACDeviceGrps;
use tgui\Models\TACDevices;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACDeviceGrpsCtrl extends Controller
{
################################################
########	Add New Device Group	###############START###########
	#########	GET Add New Device Group	#########
	// public function getDeviceGroupAdd($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'device group',
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
		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->deviceGroupAvailable(0),
			'enable' => v::when( v::oneOf( v::nullType(), v::equals('') ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0') ) ),
			'key' => v::noWhitespace()->prohibitedChars(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ($allParams['default_flag']) TACDeviceGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);

		if ( ! empty( $allParams['enable'] ) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'],  $allParams['enable_encrypt']);
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
			where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name')]])->
			first();

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
		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::deviceGroupAvailable($req->getParam('id'))),
			'enable' => v::when( v::oneOf( v::nullType(), v::equals('') ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0') ) ),
			'key' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::prohibitedChars()),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ($allParams['default_flag']) TACDeviceGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);

		if ( ! empty( $allParams['enable'] ) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'],  $allParams['enable_encrypt']);
		}

		$id = $allParams['id'];

		unset($allParams['id']);
		unset($allParams['enable_encrypt']);

		$data['group_update']=TACDeviceGrps::where([['id','=',$id]])->
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
		$data['recordsTotal'] = TACDeviceGrps::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACDeviceGrps::select($columns)->
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
							//nothing
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

		foreach($tempData as $deviceGroup){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_devGrp.getGrpInfo(\''.$deviceGroup['id'].'\',\''.$deviceGroup['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_devGrp.delete(\''.$deviceGroup['id'].'\',\''.$deviceGroup['name'].'\')">Del</button>';
			$deviceGroup['buttons']=$buttons;
			$deviceGroup['key']= ($deviceGroup['key'] != '') ? true : false;
			$deviceGroup['enable']=($deviceGroup['enable'] != '') ? true : false;
			if($deviceGroup['default_flag']){array_unshift($data['data'],$deviceGroup);}
			else array_push($data['data'],$deviceGroup);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

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
		if ($req->getParam('byId') != null){
			if ($req->getParam('byId') == 0) {
				$data['item'] = TACDeviceGrps::select(['id','name AS text','key','enable','default_flag'])->
				where([['default_flag', '=', 1]])->
				first();
				//$data['item']['text'] = $data['item']['name'];
				$data['item']['key'] = ($data['item']['key'] != '') ? true : false;
				$data['item']['enable'] = ($data['item']['enable'] != '') ? true : false;
				$data['item']['default_flag'] = ($data['item']['default_flag'] == 1) ? true : false;
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			$id = $req->getParam('byId');

				$data['item'] = ( is_array($id) ) ? TACDeviceGrps::select(['id','name AS text'])->whereIn('id', $id)->get()
				:
				TACDeviceGrps::select(['id','name AS text','key','enable','default_flag'])->where('id', $id)->first();
				if ( is_array($id) ) return $res -> withStatus(200) -> write(json_encode($data));
				$data['item']['text'] = $data['item']['name'];
				$data['item']['key'] = ($data['item']['key'] != '') ? true : false;
				$data['item']['enable'] = ($data['item']['enable'] != '') ? true : false;
				$data['item']['default_flag'] = ($data['item']['default_flag'] == 1) ? true : false;

			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = TACDeviceGrps::select(['id','name'])->count();
		$search = $req->getParam('search');
		$take = 10 * $req->getParam('page');
		$offset = 10 * ($req->getParam('page') - 1);
		$data['take'] = $take;
		$data['offset'] = $offset;
		$tempData = TACDeviceGrps::select(['id','name AS text','key','enable','default_flag'])->
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
		foreach($tempData as $group)
		{
			//$group['text'] = $group['name'];
			//unset($group['name']);
			$group['key'] = ($group['key'] != '') ? true : false;
			$group['enable'] = ($group['enable'] != '') ? true : false;
			$group['default_flag'] = ($group['default_flag'] == 1) ? true : false;
			$group['selected'] = ($group['default_flag']) ? true : false;
			array_push($data['results'],$group);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List Device Group	###############END###########
################################################

}//END OF CLASS//
