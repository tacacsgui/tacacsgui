<?php

namespace tgui\Controllers\TACUsers;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Models\MAVISOTP;
use tgui\Models\TACGlobalConf;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACUsersCtrl extends Controller
{
################################################
########	Add New User	###############START###########
	#########	GET Add New User	#########
	// public function getUserAdd($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'user_tacacs',
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

	#########	POST Add New User	#########
	public function postUserAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->notEmpty()->userTacAvailable(0),
			'group' => v::noWhitespace(),
			'enable' => v::noWhitespace()->prohibitedChars(),
			'enable_flag' => v::noWhitespace()->numeric(),
			'login' => v::noWhitespace()->notEmpty()->prohibitedChars(),
			'login_flag' => v::noWhitespace()->numeric(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ( (!empty($allParams['enable']) AND (@$allParams['enable_encrypt'] == 1)) AND (intval( @$allParams['enable_flag'] ) !== 0) )
		{
			if ($allParams['enable_flag'] == 1)
			{
				$allParams['enable']=trim(shell_exec('openssl passwd -1 '.$allParams['enable']));
			} elseif ($allParams['enable_flag'] == 2)
			{
				$allParams['enable']=trim(shell_exec('openssl passwd -crypt '.$allParams['enable']));
			}
		}
		if ( (!empty($allParams['login']) AND (@$allParams['login_encrypt'] == 1)) AND (intval( @$allParams['login_flag'] ) !== 0) )
		{
			if ($allParams['login_flag'] == 1)
			{
				$allParams['login']=trim(shell_exec('openssl passwd -1 '.$allParams['login']));
			} elseif ($allParams['login_flag'] == 2)
			{
				$allParams['login']=trim(shell_exec('openssl passwd -crypt '.$allParams['login']));
			}
		}
		if ( (!empty($allParams['pap']) AND (@$allParams['pap_encrypt'] == 1)) AND (intval( @$allParams['pap_flag'] ) !== 0) )
		{
			if ($allParams['pap_flag'] == 1)
			{
				$allParams['pap']=trim(shell_exec('openssl passwd -1 '.$allParams['pap']));
			} elseif ($allParams['pap_flag'] == 2)
			{
				$allParams['pap']=trim(shell_exec('openssl passwd -crypt '.$allParams['pap']));
			}
		}

		$otp_default = MAVISOTP::select()->first();
		//$nxos_support = TACGlobalConf::select('nxos_support')->first();

		$allParams['mavis_otp_secret'] = $this->MAVISOTP->secret();
		$allParams['mavis_otp_period'] = $otp_default->period;
		$allParams['mavis_otp_digits'] = $otp_default->digits;

		$user = TACUsers::create($allParams);

		$data['user']=$user;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'objectName' => $user['username'], 'objectId' => $user['id'], 'section' => 'tacacs users', 'message' => 203);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New User	###############END###########
################################################
########	Edit User	###############START###########
	#########	GET Edit User	#########
	public function getUserEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user_tacacs',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['user']=TACUsers::select()->
			where([['id','=',$req->getParam('id')],['username','=',$req->getParam('username')]])->
			first();
		$data['otp_status']=$this->MAVISOTP->globalStatus();
		$data['sms_status']=$this->MAVISSMS->globalStatus();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit User	#########
	public function postUserEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::notEmpty()->userTacAvailable($req->getParam('id'))),
			'group' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'enable' => v::noWhitespace()->prohibitedChars(),
			'enable_flag' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'login' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::prohibitedChars()),
			'login_flag' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'mavis_otp_period' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::intVal()->between(30, 120)),
			'mavis_otp_digits' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::intVal()->between(5, 8)),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ( (!empty($allParams['enable']) AND (@$allParams['enable_encrypt'] == 1)) AND (intval( @$allParams['enable_flag'] ) !== 0) )
		{
			if ($allParams['enable_flag'] == 1)
			{
				$allParams['enable']=trim(shell_exec('openssl passwd -1 '.$allParams['enable']));
			} elseif ($allParams['enable_flag'] == 2)
			{
				$allParams['enable']=trim(shell_exec('openssl passwd -crypt '.$allParams['enable']));
			}
		}
		if ( (!empty($allParams['login']) AND (@$allParams['login_encrypt'] == 1)) AND (intval( @$allParams['login_flag'] ) !== 0) )
		{
			if ($allParams['login_flag'] == 1)
			{
				$allParams['login']=trim(shell_exec('openssl passwd -1 '.$allParams['login']));
			} elseif ($allParams['login_flag'] == 2)
			{
				$allParams['login']=trim(shell_exec('openssl passwd -crypt '.$allParams['login']));
			}
		}
		if ( (!empty($allParams['pap']) AND (@$allParams['pap_encrypt'] == 1)) AND (intval( @$allParams['pap_flag'] ) !== 0) )
		{
			if ($allParams['pap_flag'] == 1)
			{
				$allParams['pap']=trim(shell_exec('openssl passwd -1 '.$allParams['pap']));
			} elseif ($allParams['pap_flag'] == 2)
			{
				$allParams['pap']=trim(shell_exec('openssl passwd -crypt '.$allParams['pap']));
			}
		}

		$id = $allParams['id'];

		unset($allParams['id']);
		unset($allParams['enable_encrypt']);
		unset($allParams['login_encrypt']);
		unset($allParams['pap_encrypt']);

		$data['user_update']=TACUsers::where([['id','=',$req->getParam('id')]])->
			update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$username = TACUsers::select('username')->where([['id','=',$id]])->first();

		$logEntry=array('action' => 'edit', 'objectName' => $username['username'], 'objectId' => $id, 'section' => 'tacacs users', 'message' => 303);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit User	###############END###########
################################################
########	Delete User	###############START###########
	#########	GET Delete User	#########
	// public function getUserDelete($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'user_tacacs',
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

	#########	POST Delete User	#########
	public function postUserDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=TACUsers::where([
			['id','=',$req->getParam('id')],
			['username','=',$req->getParam('username')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['username']=$req->getParam('username');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('username'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs users', 'message' => 403);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete User	###############END###########
################################################
########	User Datatables ###############START###########
	#########	POST User Datatables	#########
	public function postUserDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'datatables',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

		$params = $req->getParams(); //Get ALL parameters form Datatables

		$columns = array(
		// datatable column index  => database column name
			0 => 'id',
			1 => 'username',
			2 => 'group',
			3 => 'enable',
			4 => 'message',
			5 => 'disabled',
		); //Array of all columnes that will used

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACUsers::select($columns)->
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

		$tempGroups = TACUserGrps::select('id','name','enable','message')->get()->toArray();

		foreach($tempGroups as $group){

			$messageExist = ($group['message']!== '') ? true : false;
			$enableExist = ($group['enable']!== '') ? true : false;
			$tempGroupsNew[$group['id']] = array('name' => $group['name'], 'message' => $messageExist, 'enable' => $enableExist);
		}

		foreach($tempData as $user){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_tacUser.getUserInfo(\''.$user['id'].'\',\''.$user['username'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_tacUser.delete(\''.$user['id'].'\',\''.$user['username'].'\')">Del</button>';
			$grpID = $user['group'];
			$user['group'] = (empty($tempGroupsNew[$grpID]['name'])) ? null : $tempGroupsNew[$grpID]['name'];
			$user['groupMessage'] = (empty($tempGroupsNew[$grpID]['message'])) ? null : $tempGroupsNew[$grpID]['message'];
			$user['groupEnable']=(empty($tempGroupsNew[$grpID]['enable'])) ? null : $tempGroupsNew[$grpID]['enable'];
			$user['enable']=($user['enable']!== '' AND $user['enable']!== NULL) ? true : false;
			$user['message']=($user['message']!== '' AND $user['message']!== NULL) ? true : false;
			$user['buttons']=$buttons;
			array_push($data['data'],$user);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = TACUsers::count();
		$data['recordsFiltered'] = TACUsers::select($columns)->
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

########	User Datatables	###############END###########
################################################

}//END OF CLASS//
