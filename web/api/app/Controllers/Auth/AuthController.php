<?php

namespace tgui\Controllers\Auth;

use tgui\Models\APIUsers;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
################################################
########	SING IN	###############START###########
	#########	GET SING IN	#########
	public function getSingIn($req,$res,$arg)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'auth',
			'action' => 'singin',
		]);
		#check error#
		$data['tacacs'] = ( $this->db::getSchemaBuilder()->hasTable('mavis_local') ) ? $this->MAVISLocal->change_passwd_gui() : 0;
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST SING IN	#########
	public function postSingIn($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'auth',
			'action' => 'singin',
		]);
		//INITIAL CODE////END//

		//////////////////////
		$data['authorised']=false;

		$_SESSION['failedLoginCount'] = (empty($_SESSION['failedLoginCount'])) ? 1 : $_SESSION['failedLoginCount']+1;
		$lockTime = 0;
		$badLoginLimit = 7;

		if ($_SESSION['failedLoginCount'] > $badLoginLimit AND empty($_SESSION['blockTime'])){
			$_SESSION['error']['status']=true;
			$_SESSION['error']['message']='You was blocked for 5 minutes';
			$_SESSION['blockTime'] = time();
			///LOGGING//start//
			$username = $req->getParam('username');
			$logEntry = array('username' => empty($username) ? '' : $username, 'uid' => 0, 'action' => 'singin', 'section' => 'api auth', 'message' => 104);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		$data['test']=$_SESSION;

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
				$_SESSION['error']['message']='You was blocked for 10 minutes';
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
			$logEntry = array('username' => $req->getParam('username'), 'uid' => 0, 'action' => 'singin', 'section' => 'api auth', 'message' => 103);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		$data['info']['user']['id']=(isset($_SESSION['uid'])) ? $_SESSION['uid'] : 'empty';
		$data['info']['user']['username']=(isset($_SESSION['uname'])) ? $_SESSION['uname'] : 'empty';

		///LOGGING//start//
		$logEntry = array('action' => 'singin', 'section' => 'api auth', 'message' => 101);
		$this->APILoggingCtrl->makeLogEntry($logEntry);
		///LOGGING//end//

		$data['authorised']=$this->auth->check();
		$data['info']['user']['changePasswd'] = (isset($_SESSION['changePasswd'])) ? $_SESSION['changePasswd'] : 'empty';
		//$data['error']='authorised'; //$this->message->getError(false, 6, 0);
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	SING IN	###############END###########
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

		$user = APIUsers::select()->where([['id','=',$_SESSION['uid']]])->first();

		if ($user->changePasswd == 0){
			$data['error']['status']=true;
			$data['error']['message']='Operation not permitted!';
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		$data['status']=APIUsers::where([['id','=',$_SESSION['uid']]])->
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
########	SING OUT	###############START###########
	#########	GET SING OUT	#########
	public function getSingOut($req,$res)
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

	#########	POST SING OUT	#########
	public function postSingOut($req,$res)
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
########	SING OUT	###############END###########
################################################
}//END OF CLASS//
