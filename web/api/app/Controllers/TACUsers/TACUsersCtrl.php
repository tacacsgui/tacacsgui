<?php

namespace tgui\Controllers\TACUsers;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACUsersCtrl extends Controller
{
################################################
########	Add New User	###############START###########	
	#########	GET Add New User	#########
	public function getUserAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user_tacacs',
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
			'username' => v::noWhitespace()->notEmpty()->userTacAvailable(),
			'group' => v::noWhitespace(),
			'enable' => v::noWhitespace(),
			'enable_flag' => v::noWhitespace()->numeric(),
			'login' => v::noWhitespace()->notEmpty(),
			'login_flag' => v::noWhitespace()->numeric(),
		]);
		
		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$data['default_service'] = ($req->getParam('default_service') === true OR $req->getParam('default_service') === 'true') ? 1 : 0;
		
		$data['enable']=$req->getParam('enable');
		$data['login']=$req->getParam('login');
		$data['group']=$req->getParam('group');

		if (isset($data['login']) AND $req->getParam('login_encrypt'))
		{
			if ($req->getParam('login_flag') == 1)
			{
				$data['login']=trim(shell_exec('openssl passwd -1 '.$data['login']));
			} elseif ($req->getParam('login_flag') == 2)
			{
				$data['login']=trim(shell_exec('openssl passwd crypt '.$data['login']));
			} 
		} 
		
		if (isset($data['enable']) AND $req->getParam('enable_encrypt'))
		{
			if ($req->getParam('enable_flag') == 1)
			{
				$data['enable']=trim(shell_exec('openssl passwd -1 '.$data['enable']));
			} elseif ($req->getParam('enable_flag') == 2)
			{
				$data['enable']=trim(shell_exec('openssl passwd crypt '.$data['enable']));
			} 
		} 
		
		$user = TACUsers::create([
			'username' => $req->getParam('username'),
			'login' => $data['login'],
			'login_flag' => $req->getParam('login_flag'),
			'enable' => $data['enable'],
			'enable_flag' => $req->getParam('enable_flag'),
			'group' => $req->getParam('group'),
			'default_service' => $data['default_service'],
			'message' => $req->getParam('message'),
			'manual' => $req->getParam('manual'),
		]);
		
		//$this->auth->check();
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
		
		$data['user']=TACUsers::select('id','username','login','login_flag','enable','enable_flag','group','message','default_service','manual','created_at', 'updated_at')->
			where([['id','=',$req->getParam('id')],['username','=',$req->getParam('username')]])->
			first();
		
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
			'username' => v::noWhitespace()->notEmpty()->userTacAvailable($req->getParam('id')),
			'group' => v::noWhitespace()->numeric(),
			'enable' => v::noWhitespace(),
			'enable_flag' => v::noWhitespace()->numeric(),
			'login' => v::noWhitespace()->notEmpty(),
			'login_flag' => v::noWhitespace()->numeric(),
		]);
		
		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$data['default_service'] = ($req->getParam('default_service') === true OR $req->getParam('default_service') === 'true') ? 1 : 0;
		
		$data['enable']=$req->getParam('enable');
		$data['login']=$req->getParam('login');
		$data['group']=$req->getParam('group');

		if (isset($data['login']) AND $req->getParam('login_encrypt'))
		{
			if ($req->getParam('login_flag') == 1)
			{
				$data['login']=trim(shell_exec('openssl passwd -1 '.$data['login']));
			} elseif ($req->getParam('login_flag') == 2)
			{
				$data['login']=trim(shell_exec('openssl passwd crypt '.$data['login']));
			} 
		} 
		
		if (isset($data['enable']) AND $req->getParam('enable_encrypt'))
		{
			if ($req->getParam('enable_flag') == 1)
			{
				$data['enable']=trim(shell_exec('openssl passwd -1 '.$data['enable']));
			} elseif ($req->getParam('enable_flag') == 2)
			{
				$data['enable']=trim(shell_exec('openssl passwd crypt '.$data['enable']));
			} 
		} 
		
		$data['json']=$req->getParams();
		
		$data['user_update']=TACUsers::where([['id','=',$req->getParam('id')],['username','=',$req->getParam('username_old')]])->
			update([
				'username' => $req->getParam('username'),
				'login' => $data['login'],
				'login_flag' => $req->getParam('login_flag'),
				'enable' => $data['enable'],
				'enable_flag' => $req->getParam('enable_flag'),
				'group' => $req->getParam('group'),
				'default_service' => $data['default_service'],
				'message' => $req->getParam('message'),
				'manual' => $req->getParam('manual'),
			]);
			
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'edit', 'objectName' => $req->getParam('username'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs users', 'message' => 303);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit User	###############END###########
################################################
########	Delete User	###############START###########
	#########	GET Delete User	#########
	public function getUserDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user_tacacs',
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
		
		$data['deleteUser']=TACUsers::where([
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
		
		$params=$req->getParams(); //Get ALL parameters form Datatables
		
		$columns = array( 
		// datatable column index  => database column name
			0 => 'id', 
			1 => 'username',
			2 => 'group',
			3 => 'enable',
			4 => 'message',
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
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="editUser(\''.$user['id'].'\',\''.$user['username'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="deleteUser(\''.$user['id'].'\',\''.$user['username'].'\')">Del</button>';
			$grpID=$user['group'];
			$user['group']=$tempGroupsNew[$grpID]['name'];
			$user['groupMessage']=$tempGroupsNew[$grpID]['message'];
			$user['groupEnable']=$tempGroupsNew[$grpID]['enable'];
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

