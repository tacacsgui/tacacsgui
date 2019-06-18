<?php

namespace tgui\Controllers\MAVIS\MAVISSMS;

use tgui\Models\TACUsers;
use tgui\Models\MAVISSMS;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class MAVISSMSCtrl extends Controller
{
	public function globalStatus()

	{
		return MAVISSMS::select('enabled')->first()->enabled;
	}
################################################
########	MAVIS SMS Parameters GET	###############START###########
	public function getSMSParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'mavis sms',
			'action' => 'parameters',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['params']=MAVISSMS::select()->first();

		$data['params']['pass'] = $this->generateRandomString( 8 );

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Parameters GET	###############END###########
################################################
########	MAVIS SMS Parameters POST	###############START###########
	public function postSMSParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis sms',
			'action' => 'parameters',
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
		if(!$this->checkAccess(11))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'port' => v::when( v::nullType() , v::alwaysValid(), v::numeric())
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['mavis_sms_update'] = MAVISSMS::where([['id','=',1]])->update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'MAVIS', 'obj_id' => 'SMS', 'section' => 'MAVIS SMS', 'message' => 703);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Parameters POST	###############END###########
################################################
########	MAVIS SMS Send	###############START###########
	public function postSMSSend($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis sms',
			'action' => 'send',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'port' => v::notEmpty()->numeric(),
			'ipaddr' => v::notEmpty()->oneOf( v::ip(), v::domain() ),
			'login' => v::notEmpty(),
			'srcname' => v::notEmpty(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$username = $req->getParam('username');
		$number = $req->getParam('number');

		if ( !empty($username) )
		{
			$number = TACUsers::select('mavis_sms_number')->where([['username', '=', $username]])->first()->mavis_sms_number;
			if ($number == null)
			{
				$data['check_result']='Number for username '. $username . ' not found';
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			$data['number']=$number;
		} elseif ( !empty($number) ) {
			$data['number']=$number;
			$username = '';
		} else {
			$data['check_result']='Username or Number do not set';
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$pass = MAVISSMS::select('pass')->where('id',1)->first()->pass;

		$link = "/main.sh check smpp-client 'number' ".
			'"'.$req->getParam('ipaddr').'" '.
			'"'.$req->getParam('port').'" '.
			'"true" '.
			'"'.$req->getParam('login').'" '.
			'"'.$pass.'" '.
			'"'.$req->getParam('srcname').'" '.
			'"'.$number.'" '.
			'"'.$username.'" '.
			' 2>&1';

		$data['link']=$link;

		$data['check_result']=shell_exec(TAC_ROOT_PATH . $link);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Send	###############END###########
########	MAVIS SMS Check	###############START###########
	public function postSMSCheck($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis sms',
			'action' => 'check',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'test_username' => v::notEmpty(),
			'sms_password' => v::notEmpty()->numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['test_configuration'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration("\n "));

		$data['check_result']=shell_exec(TAC_ROOT_PATH . '/main.sh check mavis '.$req->getParam('test_username').' '.$req->getParam('sms_password').' 2>&1');

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Check	###############END###########
}//END OF CLASS//
