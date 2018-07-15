<?php

namespace tgui\Controllers\APIUsers;

use tgui\Models\APIUsers;
use tgui\Models\APIUserGrps;
use tgui\Models\APIPWPolicy;
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

		$policy = APIPWPolicy::select()->first(1);

		$validation = $this->validator->validate($req, [
			'email' => v::noWhitespace(),//->email(),//->notEmpty()->emailAvailable(),
			'username' => v::noWhitespace()->notEmpty()->usernameAvailable(),
			'group' => v::adminRights(),
			'password' => v::noWhitespace()->
					notContainChars()->
					length($policy['api_pw_length'], 64)->
					notEmpty()->
					checkPassword($req->getParam('rep_password'))->
					passwdPolicyUppercase($policy['api_pw_uppercase'])->
					passwdPolicyLowercase($policy['api_pw_lowercase'])->
					passwdPolicySpecial($policy['api_pw_special'])->
					passwdPolicyNumbers($policy['api_pw_numbers']),
			'rep_password' => v::checkPassword($req->getParam('password'))->setName('Password Repeat'),
		]);

		$data['policy'] = $policy;

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$user = APIUsers::create($allParams);
		$password = ( !empty($allParams) ) ? $allParams['password'] : '';
		APIUsers::where([['id','=',$user->id]])->
				update([
					'password' => password_hash($password, PASSWORD_DEFAULT)
				]);

		$logEntry=array('action' => 'add', 'obj_name' => $user->username, 'obj_id' => $user->id, 'section' => 'api users', 'message' => 205);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['user']=$user;

		$data['backup_status'] = $this->APIBackupCtrl->apicfgSet();
		if ( $this->APIBackupCtrl->apicfgSet() )
		$data['backup'] = $this->APIBackupCtrl->makeBackup(['make' => 'apicfg']);

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if( !$this->checkAccess(7) AND ( $req->getParam('id') != @$_SESSION['uid'] ) )
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
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
		if( !$this->checkAccess(7) AND ( $this->checkAccess(0) OR $req->getParam('id') != @$_SESSION['uid'] ) )
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$password = APIUsers::where('id', $req->getParam('id'))->first()->password;

		$policy = APIPWPolicy::select()->first(1);

		$validation = $this->validator->validate($req, [
			'email' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->email()->notEmpty()->emailAvailable()->setName('Email')),
			'password' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->
					notContainChars()->
					length($policy['api_pw_length'], 64)->
					notEmpty()->
					checkPassword($req->getParam('rep_password'))->
					passwdPolicyUppercase($policy['api_pw_uppercase'])->
					passwdPolicyLowercase($policy['api_pw_lowercase'])->
					passwdPolicySpecial($policy['api_pw_special'])->
					passwdPolicySame($policy['api_pw_same'], $password, 'api')->
					passwdPolicyNumbers($policy['api_pw_numbers'])->setName('Password') ),
			'rep_password' => v::checkPassword($req->getParam('password')),
			'group' => v::when( v::nullType() , v::alwaysValid(), v::checkAccess(7)->adminRights()->setName('Group'))
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$password = ( !empty($allParams['password']) ) ? $allParams['password'] : '';
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

		$logEntry=array('action' => 'edit', 'obj_name' => $username, 'obj_id' => $id, 'section' => 'api users', 'message' => 305);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['backup_status'] = $this->APIBackupCtrl->apicfgSet();
		if ( $this->APIBackupCtrl->apicfgSet() )
		$data['backup'] = $this->APIBackupCtrl->makeBackup(['make' => 'apicfg']);

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

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('username'), 'obj_id' => $req->getParam('id'), 'section' => 'api users', 'message' => 405);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['backup_status'] = $this->APIBackupCtrl->apicfgSet();
		if ( $this->APIBackupCtrl->apicfgSet() )
		$data['backup'] = $this->APIBackupCtrl->makeBackup(['make' => 'apicfg']);

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

		$columns = $this->APICheckerCtrl->getTableTitles('api_users'); //Array of all columnes that will used
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
		$data['recordsTotal'] = ( !$this->checkAccess(7, true) ) ? 1 : APIUsers::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$userSelfId = $_SESSION['uid'];
		$tempData = APIUsers::select($columns)->
			when(!$this->checkAccess(7, true),
				function($query) use ( $userSelfId )
				{
					return $query->where('id', $userSelfId);
				}
			)->
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
		$data['user']['groupRights'] = $_SESSION['groupRights'];

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Get User Info	###############END###########
######################################################
}//END OF CLASS//
