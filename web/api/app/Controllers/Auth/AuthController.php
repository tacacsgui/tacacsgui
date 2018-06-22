<?php

namespace tgui\Controllers\Auth;

use tgui\Models\APIUsers;
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
		$lockTime = 6;
		$badLoginLimit = 10;

		if ($_SESSION['failedLoginCount'] > $badLoginLimit AND empty($_SESSION['blockTime'])){
			$_SESSION['error']['status']=true;
			$_SESSION['error']['message']='You was blocked for 10 minutes';
			$_SESSION['blockTime'] = time();
			///LOGGING//start//
			$logEntry = array('userName' => $req->getParam('username'), 'userId' => 0, 'action' => 'singin', 'section' => 'api auth', 'message' => 104);
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


		$auth = $this->auth->attempt(
			$req->getParam('username'),
			$req->getParam('password')
		);

		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			///LOGGING//start//
			$logEntry = array('userName' => $req->getParam('username'), 'userId' => 0, 'action' => 'singin', 'section' => 'api auth', 'message' => 103);
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

		$validation = $this->validator->validate($req, [
			'password' => v::noWhitespace()->notContainChars()->length(5, 24)->notEmpty()->checkPassword($req->getParam('reppassword')),
			//'reppassword' => v::noWhitespace()->notEmpty()->checkPassword($req->getParam('password')),
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
				'password' => password_hash($req->getParam('password'), PASSWORD_DEFAULT),
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
