<?php

namespace tgui\Controllers\MAVISOTP;

use tgui\Models\TACUsers;
use tgui\Models\MAVISOTP;
use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class MAVISOTPCtrl extends Controller
{
	public function secret()
	{
		return trim(Base32::encodeUpper(random_bytes(128)), '=');
	}

	public function globalStatus()

	{
		return MAVISOTP::select('enabled')->first()->enabled;
	}
################################################
########	MAVIS OTP Secret	###############START###########
	public function postOTPSecret($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis otp',
			'action' => 'secret',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$secret = $req->getParam('secret');
		$period = $req->getParam('period');
		$digits = $req->getParam('digits');
		$digest = $req->getParam('digest');

		$user = TACUsers::select('username')->where([['id','=',$req->getParam('id')]])->first();

		$data['secret'] = ($secret == 'new') ? $this->secret() : $secret;
		$otp = TOTP::create(
				$data['secret'],
				intVal($period),     // The period (30 seconds)
				$digest, // The digest algorithm
				intVal($digits)
			);
		$otp->setLabel($user->username); // The label (string)
		$otp->setIssuer('tacacsgui');
		$data['url'] = $otp->getProvisioningUri();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS OTP Secret	###############END###########
################################################
########	MAVIS OTP URL	###############START###########
	public function postOTPurl($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis otp',
			'action' => 'url',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS OTP URL	###############END###########
################################################
########	MAVIS OTP Parameters GET	###############START###########
	public function getOTPParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'mavis otp',
			'action' => 'parameters',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['OTP_Params']=MAVISOTP::select()->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS OTP Parameters GET	###############END###########
################################################
########	MAVIS OTP Parameters POST	###############START###########
	public function postOTPParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis otp',
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
			'period' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->intVal()->between(30, 120)),
			'digits' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->intVal()->between(5, 8)),
			'digest' => v::when( v::nullType() , v::alwaysValid(), v::oneOf(v::equals('sha1'), v::equals('md5'))),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['mavis_otp_update'] = MAVISOTP::where([['id','=',1]])->update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'MAVIS', 'obj_id' => 'OTP', 'section' => 'MAVIS OTP', 'message' => 702);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS OTP Parameters POST	###############END###########
################################################
########	MAVIS OTP Check	###############START###########
	public function postOTPCheck($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis otp',
			'action' => 'check',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'username' => v::notEmpty(),
			'ot_password' => v::notEmpty()->numeric(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['test_configuration'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration("\n "));

		$data['check_result']=shell_exec(TAC_ROOT_PATH . '/main.sh check mavis '.$req->getParam('username').' '.$req->getParam('ot_password').' 2>&1');

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS OTP Check	###############END###########
}//END OF CLASS//
