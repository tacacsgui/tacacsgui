<?php

namespace tgui\Controllers\API\APIUsers;

use tgui\Models\APIUsers;
use tgui\Models\APIUserGrps;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

use Firebase\JWT\JWT;

class APIUsersCtrl extends Controller
{
################################################
########	Add New User	###############START###########
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

		$policy = APIPWPolicy::select()->first(1);

		$validation = $this->validator->validate($req, [
			'email' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->email()->setName('Email')),
			'username' => v::noWhitespace()->notEmpty()->usernameAvailable(),
			'group' => v::notEmpty(),//->adminRights(),
			'password' => v::noWhitespace()->
					notContainChars()->
					length($policy['api_pw_length'], 64)->
					notEmpty()->
					checkPassword($req->getParam('repassword'))->
					passwdPolicyUppercase($policy['api_pw_uppercase'])->
					passwdPolicyLowercase($policy['api_pw_lowercase'])->
					passwdPolicySpecial($policy['api_pw_special'])->
					passwdPolicyNumbers($policy['api_pw_numbers']),
			'repassword' => v::checkPassword($req->getParam('password'))->setName('Password Repeat'),
		]);

		$data['policy'] = $policy;

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		unset($allParams['repassword']);
		$allParams['password'] = password_hash($allParams['password'], PASSWORD_DEFAULT);
		$user = APIUsers::create($allParams);
		$password = $allParams['password'];
		// APIUsers::where('id',$user->id)->
		// 		update([
		// 			'password' => password_hash($password, PASSWORD_DEFAULT)
		// 		]);

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
		if( !$this->checkAccess(1) )
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$data['user']=APIUsers::leftJoin('api_user_groups as ug', 'ug.id','=','group')->
			select(['api_users.*','ug.name as gname'])->where('api_users.id',$req->getParam('id'))->first();
		$data['user']->group = [['id' => $data['user']->group, 'text' => $data['user']->gname ]];
		unset($data['user']->gname);

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

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if( !$this->checkAccess(1) )
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$password = APIUsers::where('id', $req->getParam('id'))->first()->password;

		$policy = APIPWPolicy::select()->first(1);

		$validation = $this->validator->validate($req, [
			'email' => v::when( v::oneOf(v::nullType(), v::equals('')) , v::alwaysValid(), v::noWhitespace()->email()->notEmpty()->setName('Email')),
			'password' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->
					notContainChars()->
					length($policy['api_pw_length'], 64)->
					notEmpty()->
					checkPassword($req->getParam('repassword'))->
					passwdPolicyUppercase($policy['api_pw_uppercase'])->
					passwdPolicyLowercase($policy['api_pw_lowercase'])->
					passwdPolicySpecial($policy['api_pw_special'])->
					passwdPolicySame($policy['api_pw_same'], $password, 'api')->
					passwdPolicyNumbers($policy['api_pw_numbers'])->setName('Password') ),
			'repassword' => v::checkPassword($req->getParam('password')),
			'group' => v::notEmpty()->checkAccess(7)->setName('Group')//->adminRights()->setName('Group')
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		unset($allParams['repassword']);

		if (!empty($allParams['password']) ) $allParams['password'] = password_hash($allParams['password'], PASSWORD_DEFAULT);
		$id = $allParams['id'];

		$data['user_woPasswd']=APIUsers::where('id',$id)->
			update($allParams);

		$data['save'] = 1;

		$username = APIUsers::select('username')->where('id',$id)->first()->username;

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

		if ($_SESSION['uid'] == $req->getParam('id'))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}

		$data['result']=APIUsers::where('id',$req->getParam('id'))->delete();
		$data['id']=$req->getParam('id');
		$data['name
		']=$req->getParam('name');

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'api users', 'message' => 405);
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
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		//Filter end
		$data['recordsTotal'] = APIUsers::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APIUsers::select($columns)->
		when( !empty($queries),
			function($query) use ($queries)
			{
				$query->where('username','LIKE', '%'.$queries.'%');
				return $query;
			});
		$data['recordsFiltered'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

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

		$data['decrypt'] = $req->getAttribute('decoded_token_data');

		if ($data['decrypt']['id'] != $_SESSION['uid'] ){
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		$data['user']=APIUsers::select()->where([
			['id','=',$_SESSION['uid']],
			['username','=',$_SESSION['uname']],
		])->first();
		$data['user']['groupRights'] = $_SESSION['groupRights'];
		$data['changeConfiguration'] = $this->db->table('tac_global_settings')->select('changeFlag')->first()->changeFlag;
		$data['token'] = JWT::encode(['id' => $data['user']->id, 'username' => $data['user']->username], "supersecretkeyyoushouldnotcommittogithub", "HS256");


		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Get User Info	###############END###########
########	Get User Status	###############START###########
	#########	GET User Status	#########
	public function getUserStatus($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user',
			'action' => 'status',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['changeConfiguration']=$this->db->table('tac_global_settings')->select('changeFlag')->first()->changeFlag;

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Get User Status	###############END###########
######################################################
	public static function changeCmdType($type = 0)
	{
		return APIUsers::where('id', $_SESSION['uid'])->update(['cmd_type' => $type]);
	}
}//END OF CLASS//
