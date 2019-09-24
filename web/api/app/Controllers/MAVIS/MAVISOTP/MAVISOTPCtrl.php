<?php

namespace tgui\Controllers\MAVIS\MAVISOTP;

use tgui\Models\TACUsers;
use tgui\Models\MAVISOTP;
use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class MAVISOTPCtrl extends Controller
{
	public function secret($secret = '')
	{
		if (empty($secret)) $secret = random_bytes(128);
		return trim(Base32::encodeUpper($secret), '=');
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
		$allParams = $req->getParams();

		if (empty($allParams['secret']))
			$secret = $this->secret();
		else
			$secret = $allParams['secret'];
		//$secret = $this->secret($req->getParam('secret'));
		$username = ($req->getParam('username')) ? $req->getParam('username') : 'Unknown';
		// $period = $req->getParam('period');
		// $digits = $req->getParam('digits');
		// $digest = $req->getParam('digest');
		//
		// $user = TACUsers::select('username')->where([['id','=',$req->getParam('id')]])->first();
		$mavis = MAVISOTP::select()->first();

		//$data['secret'] = ($secret == 'new') ? $this->secret() : $secret;
		$otp = TOTP::create(
				$secret,
				intVal($mavis->period),     // The period (30 seconds)
				$mavis->digest, // The digest algorithm
				intVal($mavis->digits)
			);
		$otp->setLabel($username); // The label (string)
		$otp->setIssuer('TACACSGUI');
		$data['url'] = $otp->getProvisioningUri();
		$data['secret'] = $secret;
		// $data['url'] = 'otpauth://totp/tacacsgui:'.$username.'?secret='.$secret.'&issuer=tacacsgui&algorithm=SHA1&digits='.$mavis->digits.'&period='.$mavis->period;
		// $data['url'] = 'otpauth://totp/tacacsgui:'.$username.'?secret='.$secret.'&issuer=tacacsgui&algorithm='.strtoupper($mavis->digest).'&digits=6&period=30';
		//$data['url'] = 'otpauth://totp/tacacsgui:otpu?secret=243Z2MMW7XZ3W45DWDVGGXFAWJ26SLU4&issuer=tacacsgui&algorithm=SHA1&digits=6&period=30';

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public static function getUrl($username, $secret){

		$mavis = MAVISOTP::select()->first();

		//$data['secret'] = ($secret == 'new') ? $this->secret() : $secret;
		$otp = TOTP::create(
				$secret,
				intVal($mavis->period),     // The period (30 seconds)
				$mavis->digest, // The digest algorithm
				intVal($mavis->digits)
			);
		$otp->setLabel($username); // The label (string)
		$otp->setIssuer('TACACSGUI');
		return $otp->getProvisioningUri();

	}
	public static function newSecret(){
		return trim(Base32::encodeUpper(random_bytes(128)), '=');
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

		$data['params']=MAVISOTP::select()->first();

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
			'password' => v::notEmpty(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['test_configuration'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration("\n "));

		$data['check_result'] = preg_replace('/PASSWORD\s+.*/i', "PASSWORD\t\t******", CMDRun::init()->setCmd(TAC_ROOT_PATH . '/main.sh')->setAttr(['check','mavis',$req->getParam('username'),$req->getParam('password')])->setStdOut('2>&1')->get() );
		//$data['check_result']=preg_replace('/PASSWORD\s+.*/i', "PASSWORD\t\t******", shell_exec(TAC_ROOT_PATH . '/main.sh check mavis '.escapeshellarg( $req->getParam('username') ).' '.escapeshellarg($req->getParam('password')).' 2>&1') );

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS OTP Check	###############END###########
}//END OF CLASS//
