<?php

namespace tgui\Controllers\TACDevices;

use tgui\Models\TACDevices;
use tgui\Models\TACDeviceGrps;
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
		/*if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}*/
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
	public function getDeviceAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'device',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->deviceNameAvailable(0),
			'group' => v::noWhitespace()->notEmpty(),
			'enable' => v::noWhitespace()->prohibitedChars(),
			'enable_flag' => v::noWhitespace(),
			'key' => v::noWhitespace()->tacacsKeyAvailable($req->getParam('group'))->prohibitedChars(),
			'ipaddr' => v::noWhitespace()->notEmpty()->ip(),
			'prefix' => v::noWhitespace()->notEmpty(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['enable']=$req->getParam('enable');
		$data['group']=$req->getParam('group');

		if (isset($data['enable']) AND ($req->getParam('enable_encrypt') === true OR $req->getParam('enable_encrypt') === 'true'))
		{
			if ($req->getParam('enable_flag') == 1)
			{
				$data['enable']=trim(shell_exec('openssl passwd -1 '.$data['enable']));
			} elseif ($req->getParam('enable_flag') == 2)
			{
				$data['enable']=trim(shell_exec('openssl passwd crypt '.$data['enable']));
			}
		}

		$device = TACDevices::create([
			'name' => $req->getParam('name'),
			'disabled' => intval($req->getParam('disabled')),
			'ipaddr' => $req->getParam('ipaddr'),
			'prefix' => $req->getParam('prefix'),
			'key' => $req->getParam('key'),
			'enable' => $data['enable'],
			'group' => $data['group'],
			'enable_flag' => $req->getParam('enable_flag'),
			'banner_welcome' => $req->getParam('banner_welcome'),
			'banner_motd' => $req->getParam('banner_motd'),
			'banner_failed' => $req->getParam('banner_failed'),
			'manual' => $req->getParam('manual'),
		]);

		$data['device']=$device;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'objectName' => $device['name'], 'objectId' => $device['id'], 'section' => 'tacacs devices', 'message' => 201);
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

		$data['device']=TACDevices::select('id','name','ipaddr','prefix','key','enable','enable_flag','group','disabled','banner_welcome','banner_motd','banner_failed','manual','created_at', 'updated_at')->
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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->deviceNameAvailable($req->getParam('id')),
			'group' => v::noWhitespace()->notEmpty(),
			'enable' => v::noWhitespace()->prohibitedChars(),
			'enable_flag' => v::noWhitespace()->numeric(),
			'key' => v::noWhitespace()->tacacsKeyAvailable($req->getParam('group'))->prohibitedChars(),
			'ipaddr' => v::noWhitespace()->notEmpty()->ip(),
			'prefix' => v::noWhitespace()->notEmpty(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['enable']=$req->getParam('enable');
		$data['group']=$req->getParam('group');

		if (isset($data['enable']) AND ($req->getParam('enable_encrypt') === true OR $req->getParam('enable_encrypt') === 'true'))
		{
			if ($req->getParam('enable_flag') == 1)
			{
				$data['enable']=trim(shell_exec('openssl passwd -1 '.$data['enable']));
			} elseif ($req->getParam('enable_flag') == 2)
			{
				$data['enable']=trim(shell_exec('openssl passwd crypt '.$data['enable']));
			}
		}

		$data['device_update']=TACDevices::where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name_old')]])->
			update([
				'name' => $req->getParam('name'),
				'disabled' => intval($req->getParam('disabled')),
				'group' => $req->getParam('group'),
				'ipaddr' => $req->getParam('ipaddr'),
				'prefix' => $req->getParam('prefix'),
				'key' => $req->getParam('key'),
				'enable' => $data['enable'],
				'enable_flag' => $req->getParam('enable_flag'),
				'banner_welcome' => $req->getParam('banner_welcome'),
				'banner_motd' => $req->getParam('banner_motd'),
				'banner_failed' => $req->getParam('banner_failed'),
				'manual' => $req->getParam('manual'),
			]);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs devices', 'message' => 301);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit Device	###############END###########
################################################
########	Delete Device	###############START###########
	#########	GET Delete Device	#########
	public function getDeviceDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'device',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(2))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['deleteDevice']=TACDevices::where([
			['id','=',$req->getParam('id')],
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs devices', 'message' => 401);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete Device	###############END###########
################################################
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

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = array(
		// datatable column index  => database column name
			0 => 'id',
			1 => 'name',
			2 => 'ipaddr',
			3 => 'prefix',
			4 => 'enable',
			5 => 'enable_flag',
			6 => 'group',
			7 => 'key',
			8 => 'disabled',
		); //Array of all columnes that will used

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACDevices::select($columns)->
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
			when($params['columns'][2]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
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
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="editDevice(\''.$device['id'].'\',\''.$device['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="deleteDevice(\''.$device['id'].'\',\''.$device['name'].'\')">Del</button>';
			$device['buttons'] = $buttons;
			$device['ipaddr'].="/".$device['prefix'];
			$grpID=$device['group'];
			$device['group']=$tempGroupsNew[$grpID]['name'];
			$device['groupKey']=$tempGroupsNew[$grpID]['key'];
			$device['groupEnable']=$tempGroupsNew[$grpID]['enable'];
			$device['enable'] = ($device['enable']!== '') ? true : false;
			$device['key'] = ($device['key']!== '') ? true : false;
			//$device['enable'].="/".$device['enable_flag'];
			//unset($device['prefix']);unset($device['enable_flag']);
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = TACDevices::count();
		$data['recordsFiltered'] = TACDevices::select($columns)->
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
			when($params['columns'][2]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
				count();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	Device Datatables	###############END###########
################################################

}//END OF CLASS//
