<?php

namespace tgui\Controllers\TACDevices;

use tgui\Models\TACDevices;
use tgui\Models\TACDeviceGrps;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACDevicesCtrl extends Controller
{
////////////////////////////////////
////Device Ping///////////Start///////
	public function getDevicePing($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'device',
			'action' => 'ping'
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(2, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'ipaddr' => v::noWhitespace()->notEmpty()->ip()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['pingResponses'] = intval(trim(shell_exec('ping '.$req->getParam('ipaddr').' -c4 | grep "64 bytes from" | wc -l')));


		return $res -> withStatus(200) -> write(json_encode($data));
	}
////Device Ping///////////End///////
################################################
########	Add New Device	###############START###########
	#########	GET Add New Device	#########
	// public function getDeviceAdd($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'device',
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

	#########	POST Add New Device	#########
	public function postDeviceAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device',
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
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$policy = APIPWPolicy::select()->first(1);

		$allParams = $req->getParams();

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->deviceNameAvailable(0),
			'group' => v::noWhitespace()->notEmpty(),
			'enable' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::noWhitespace(),
			'key' => v::when( v::tacacsKeyAvailable($allParams['group']), v::alwaysValid(),
			 	v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->setName('Tacacs Key') ),
			'ipaddr' => v::noWhitespace()->notEmpty()->ip(),
			'prefix' => v::noWhitespace()->notEmpty(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ( (!empty($allParams['enable']) AND (@$allParams['enable_encrypt'] == 1)) AND (intval( @$allParams['enable_flag'] ) !== 0) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'] );
		}

		$device = TACDevices::create($allParams);

		$data['device']=$device;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'obj_name' => $device['name'], 'obj_id' => $device['id'], 'section' => 'tacacs devices', 'message' => 201);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New Device	###############END###########
################################################
########	Edit Device	###############START###########
	#########	GET Edit Device	#########
	public function getDeviceEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'device',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['device']=TACDevices::select()->
			where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name')]])->
			first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit Device	#########
	public function postDeviceEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device',
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
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$policy = APIPWPolicy::select()->first(1);

		$allParams = $req->getParams();

		$group= (empty($allParams['group'])) ? TACDevices::where([['id','=',$allParams['id']]])->first()->group : $allParams['group'];

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::notEmpty()->deviceNameAvailable($req->getParam('id'))),
			'group' => v::when( v::nullType(), v::alwaysValid(), v::numeric() ),
			'enable' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'key' => v::when( v::tacacsKeyAvailable($group) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->setName('Tacacs Key') ),
			'ipaddr' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::ip()),
			'prefix' => v::noWhitespace()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ( (!empty($allParams['enable']) AND (@$allParams['enable_encrypt'] == 1)) AND (intval( @$allParams['enable_flag'] ) !== 0) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'] );
		}

		$id = $allParams['id'];

		unset($allParams['id']);
		unset($allParams['enable_encrypt']);

		$data['device_update']=TACDevices::where([['id','=',$id]])->update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$name = TACDevices::select('name')->where([['id','=',$id]])->first();

		$logEntry=array('action' => 'edit', 'obj_name' => $name['name'], 'obj_id' => $id, 'section' => 'tacacs devices', 'message' => 301);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit Device	###############END###########
################################################
########	Delete Device	###############START###########
	#########	GET Delete Device	#########
	// public function getDeviceDelete($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'device',
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

	#########	POST Delete Device	#########
	public function postDeviceDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device',
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
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=TACDevices::where([
			['id','=',$req->getParam('id')],
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'tacacs devices', 'message' => 401);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete Device	###############END###########
################################################
#########	POST CSV Device	#########
public function postDeviceCsv($req,$res)
{
	//INITIAL CODE////START//
	$data=array();
	$data=$this->initialData([
		'type' => 'post',
		'object' => 'device',
		'action' => 'csv',
	]);
	#check error#
	if ($_SESSION['error']['status']){
		$data['error']=$_SESSION['error'];
		return $res -> withStatus(401) -> write(json_encode($data));
	}
	//INITIAL CODE////END//
	//CHECK ACCESS TO THAT FUNCTION//START//
	if(!$this->checkAccess(2))
	{
		return $res -> withStatus(403) -> write(json_encode($data));
	}
	//CHECK ACCESS TO THAT FUNCTION//END//
	$data['clear'] = shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');
	$path = TAC_ROOT_PATH . '/temp/';
	$filename = 'tac_devices_'. $this->generateRandomString(8) .'.csv';

	$columns = $this->APICheckerCtrl->getTableTitles('tac_devices');

  $f = fopen($path.$filename, 'w');
	$idList = $req->getParam('idList');
	$array = [];
	$array = ( empty($idList) ) ? TACDevices::select($columns)->get()->toArray() : TACDevices::select($columns)->whereIn('id', $idList)->get()->toArray();

	fputcsv($f, $columns /*, ',)'*/);
  foreach ($array as $line) {
	fputcsv($f, $line /*, ',)'*/);
  }

	$data['filename']=$filename;
	sleep(3);
	return $res -> withStatus(200) -> write(json_encode($data));
}
########	CSV Device	###############END###########
########	#########################
########	Device Datatables ###############START###########
	#########	POST Device Datatables	#########
	public function postDeviceDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'device',
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
		if(!$this->checkAccess(2, true))
		{
			$data['data'] = [];
			$data['recordsTotal'] = 0;
			$data['recordsFiltered'] = 0;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		//$data['columns'] = $this->APICheckerCtrl->getTableTitles('tac_devices');

		$columns = $this->APICheckerCtrl->getTableTitles('tac_devices'); //Array of all columnes that will used
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
		$data['recordsTotal'] = TACDevices::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACDevices::select($columns)->
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

		$tempGroups = TACDeviceGrps::select('id','name','key','enable')->get()->toArray();

		foreach($tempGroups as $group){

			$keyExist = ($group['key']!== '') ? true : false;
			$enableExist = ($group['enable']!== '') ? true : false;
			$tempGroupsNew[$group['id']] = array('name' => $group['name'], 'key' => $keyExist, 'enable' => $enableExist);
		}

		foreach($tempData as $device){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_device.getDevInfo(\''.$device['id'].'\',\''.$device['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_device.delete(\''.$device['id'].'\',\''.$device['name'].'\')">Del</button>';
			$device['buttons'] = $buttons;
			$device['ipaddr'].="/".$device['prefix'];
			$grpID=$device['group'];
			$device['group']=$tempGroupsNew[$grpID]['name'];
			$device['groupKey']=$tempGroupsNew[$grpID]['key'];
			$device['groupEnable']=$tempGroupsNew[$grpID]['enable'];
			$device['enable'] = ($device['enable']!== '') ? true : false;
			$device['key'] = ($device['key']!== '') ? true : false;

			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	Device Datatables	###############END###########
################################################

}//END OF CLASS//
