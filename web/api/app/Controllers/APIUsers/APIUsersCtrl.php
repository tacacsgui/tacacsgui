<?php

namespace tgui\Controllers\APIUsers;

use tgui\Models\APIUsers;
use tgui\Models\APIUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class APIUsersCtrl extends Controller
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
	// 		'object' => 'user',
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
			'object' => 'user',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(7))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$validation = $this->validator->validate($req, [
			'email' => v::noWhitespace(),//->email(),//->notEmpty()->emailAvailable(),
			'username' => v::noWhitespace()->notEmpty()->usernameAvailable(),
			'password' => v::noWhitespace()->notContainChars()->length(5, 24)->notEmpty()->checkPassword($req->getParam('rep_password')),
			'rep_password' => v::noWhitespace()->notEmpty()->checkPassword($req->getParam('password')),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$user = APIUsers::create($allParams);

		$logEntry=array('action' => 'add', 'objectName' => $user->username, 'objectId' => $user->id, 'section' => 'api users', 'message' => 205);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		//$this->auth->check();
		$data['user']=$user;

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
			'object' => 'user',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['user']=APIUsers::select()->where([['id','=',$req->getParam('id')],['username','=',$req->getParam('username')]])->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit User	#########
	public function postUserEdit($req,$res)
	{

		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		//$data['test01']=(!$this->checkAccess(7) AND $this->checkAccess(0));
		if( !$this->checkAccess(0) OR ( !$this->checkAccess(7) AND ( $req->getParam('id') != @$_SESSION['uid'] ) ) )
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'email' => v::noWhitespace(),//->email(),//->notEmpty()->emailAvailable(),
			'password' => v::notContainChars()->checkPassword($req->getParam('rep_password')),
			'rep_password' => v::checkPassword($req->getParam('password')),
			//'repPassword' => v::noWhitespace()->notContainChars()->notEmpty()->checkPassword(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$password = ( !empty($allParams) ) ? $allParams['password'] : '';
		$id = $allParams['id'];

		unset($allParams['id']);
		unset($allParams['password']);
		unset($allParams['rep_password']);

		$data['user_woPasswd']=APIUsers::where([['id','=',$id]])->
			update($allParams);

		if ($password !== ''){
			$data['user_wPasswd']=APIUsers::where([['id','=',$id]])->
				update([
					'password' => password_hash($password, PASSWORD_DEFAULT)
				]);
		}

		$username = APIUsers::select('username')->where([['id','=',$id]])->first()->username;

		$logEntry=array('action' => 'edit', 'objectName' => $username, 'objectId' => $id, 'section' => 'api users', 'message' => 305);
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
	// 		'object' => 'user',
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
			'object' => 'user',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(7))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		if ($_SESSION['uid'] == $req->getParam('id'))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}

		$data['result']=APIUsers::where([
			['id','=',$req->getParam('id')],
			['username','=',$req->getParam('username')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['username
		']=$req->getParam('username');

		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('username'), 'objectId' => $req->getParam('id'), 'section' => 'api users', 'message' => 405);
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
			'object' => 'user',
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
			2 => 'email',
			3 => 'firstname',
			4 => 'surname',
			5 => 'position',
			6 => 'group',
			//6 => 'description'
		); //Array of all columnes that will used

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APIUsers::select($columns)->
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

		$tempGroups = APIUserGrps::select()->get()->toArray();

		foreach($tempGroups as $group){
			$tempGroupsNew[$group['id']] = array('name' => $group['name']);
		}

		$tempGroupsNew[0] = array('name' => 'None');

		//Creating correct array of answer to Datatables
		$data['data']=array();

		foreach($tempData as $user){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_userApi.getInfo(\''.$user['id'].'\',\''.$user['username'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_userApi.delete(\''.$user['id'].'\',\''.$user['username'].'\')">Del</button>';
			$user['buttons']=$buttons;
			$grpID=$user['group'];
			$user['group']=$tempGroupsNew[$grpID]['name'];
			array_push($data['data'],$user);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = APIUsers::count();
		$data['recordsFiltered'] = APIUsers::select($columns)->
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
########	Get User Info	###############START###########
	#########	GET User Info	#########
	public function getUserInfo($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user',
			'action' => 'info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['user']=APIUsers::select()->where([
			['id','=',$_SESSION['uid']],
			['username','=',$_SESSION['uname']],
		])->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Get User Info	###############END###########
######################################################
}//END OF CLASS//
