<?php

namespace tgui\Controllers\Auth;

use tgui\Models\APIUsers;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
################################################
########	Sign IN	###############START###########
	#########	GET Sign IN	#########
	public function getSignIn($req,$res,$arg)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'auth',
			'action' => 'Signin',
		]);
		#check error#
		$data['tacacs'] = ( $this->db::getSchemaBuilder()->hasTable('mavis_local') ) ? $this->MAVISLocal->change_passwd_gui() : 0;
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		if ( !isset($_SESSION['ldap']) AND isset($_SESSION['uid']) ){

			$data['user']=APIUsers::from('api_users as au')->
			leftJoin('api_user_groups as aug','aug.id','=','au.group')->
			select(['au.*', 'aug.rights as rights'])->
			where('au.id',$_SESSION['uid'])->first();

		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Sign IN	#########
	public function postSignIn($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'auth',
			'action' => 'Signin',
		]);
		//INITIAL CODE////END//

		//////////////////////
		$data['authorised']=false;

		$_SESSION['failedLoginCount'] = (empty($_SESSION['failedLoginCount'])) ? 1 : $_SESSION['failedLoginCount']+1;
		$lockTime = 300;
		$badLoginLimit = 5;

		if ($_SESSION['failedLoginCount'] > $badLoginLimit AND empty($_SESSION['blockTime'])){
			$_SESSION['error']['status']=true;
			$_SESSION['error']['message']='You was blocked for 5 minutes';
			$_SESSION['blockTime'] = time();
			///LOGGING//start//
			$username = $req->getParam('username');
			$logEntry = array('username' => empty($username) ? '' : $username, 'uid' => 0, 'action' => 'Signin', 'section' => 'api auth', 'message' => 104);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		//$data['test']=$_SESSION;

		if (!empty($_SESSION['blockTime']))
		{
			if ((time() - $_SESSION['blockTime']) > $lockTime)
			{
				unset($_SESSION['blockTime']);
				$_SESSION['failedLoginCount'] = 1;
			}
			else
			{
				$_SESSION['error']['status']=true;
				$_SESSION['error']['message']='You was blocked for 5 minutes';
				$data['error']=$_SESSION['error'];
				return $res -> withStatus(401) -> write(json_encode($data));
			}
		}

		if(!$this->db::schema()->hasTable('api_users'))
		{
			$this->APICheckerCtrl->myFirstTable();
		}

		$validation = $this->validator->validate($req, [
			'username' => v::notEmpty(),
			'password' => v::notEmpty()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		$auth = $this->auth->attempt(
			$req->getParam('username'),
			$req->getParam('password')
		);

		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			///LOGGING//start//
			$logEntry = array('username' => $req->getParam('username'), 'uid' => 0, 'action' => 'Signin', 'section' => 'api auth', 'message' => 103);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		if ( !isset($_SESSION['ldap']) ){
			$data['user']=APIUsers::from('api_users as au')->
			leftJoin('api_user_groups as aug','aug.id','=','au.group')->
			select(['au.*', 'aug.rights as rights'])->
			where('au.id',$_SESSION['uid'])->first();
			$data['info']['user']['id']=(isset($_SESSION['uid'])) ? $_SESSION['uid'] : 'empty';
			$data['info']['user']['username']=(isset($_SESSION['uname'])) ? $_SESSION['uname'] : 'empty';
		} else {
			$data['user']=$_SESSION['user'];
			$data['user']['rights'] = $this->db::table('api_user_groups')->select()->where('id',$_SESSION['groupId'])->first()->rights;
		}

		///LOGGING//start//
		$logEntry = array('action' => 'Signin', 'section' => 'api auth', 'message' => 101);
		$this->APILoggingCtrl->makeLogEntry($logEntry);
		///LOGGING//end//

		$data['authorised']=$this->auth->check();
		$data['info']['user']['changePasswd'] = (isset($_SESSION['changePasswd'])) ? $_SESSION['changePasswd'] : 'empty';

    $data['token'] = JWT::encode(['id' => $data['user']->id, 'username' => $data['user']->username], DB_PASSWORD, "HS256");

		//$data['error']='authorised'; //$this->message->getError(false, 6, 0);
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Sign IN	###############END###########
################################################
	#########	POST CHANGE PASSWORD	#########
	public function postChangePassword($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'auth',
			'action' => 'change password',
		]);
		#check error#
		if ($_SESSION['error']['status'] AND $data['info']['user']['changePasswd'] != 1){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$password = APIUsers::where('id', $_SESSION['uid'])->first()->password;

		if($this->db::schema()->hasTable('api_password_policy'))
		{
			$policy = APIPWPolicy::select()->first(1);
		} else {
			$policy = ['api_pw_length' => 8, 'api_pw_same' => true];
		}
		$validation = $this->validator->validate($req, [
			'change_passwd' => v::when( v::alwaysValid() , v::notContainChars()->
					length($policy['api_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['api_pw_uppercase'])->
					passwdPolicyLowercase($policy['api_pw_lowercase'])->
					passwdPolicySpecial($policy['api_pw_special'])->
					passwdPolicySame($policy['api_pw_same'], $password, 'api')->
					passwdPolicyNumbers($policy['api_pw_numbers'])->
					checkPassword($req->getParam('change_passwd_repeat'))->setName('Password') ),
			'change_passwd_repeat' => v::checkPassword($req->getParam('change_passwd')),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ( !isset($_SESSION['ldap']) ){
			$user = APIUsers::from('api_users as au')->
			leftJoin('api_user_groups as aug','aug.id','=','au.group')->
			select(['au.*', 'aug.rights as rights'])->
			where('au.id',$_SESSION['uid'])->first();
		} else {
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ($user->changePasswd == 0){
			$data['error']['status']=true;
			$data['error']['message']='Operation not permitted!';
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		$data['status']=APIUsers::where('id',$_SESSION['uid'])->
			update([
				'password' => password_hash($req->getParam('change_passwd'), PASSWORD_DEFAULT),
				'changePasswd' => 0
			]);
		$_SESSION['changePasswd'] = 0;
		$data['info']['user']['changePasswd'] = (isset($_SESSION['changePasswd'])) ? $_SESSION['changePasswd'] : 'empty';

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	CHANGE PASSWORD	###############END###########
################################################
########	Sign OUT	###############START###########
	#########	GET Sign OUT	#########
	public function getSignOut($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'auth',
			'action' => 'signout',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		///LOGGING//start//
		$logEntry = array('action' => 'signout', 'section' => 'api auth', 'message' => 102);
		$this->APILoggingCtrl->makeLogEntry($logEntry);
		///LOGGING//end//

		session_unset(); session_destroy();
		$data['authorised']=$this->auth->check();
		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Sign OUT	#########
	public function postSignOut($req,$res)
	{

		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'auth',
			'action' => 'signout',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		session_unset(); session_destroy();
		$data['authorised']=$this->auth->check();
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Sign OUT	###############END###########
################################################
}//END OF CLASS//
