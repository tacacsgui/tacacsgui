<?php

namespace tgui\Controllers\APISettings;

use tgui\PHPMailer\EmailEngine;
use tgui\Models\APIPWPolicy;
use tgui\Models\APISMTP;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class APISettingsCtrl extends Controller
{
####PASSWORD POLICY#####
  public function getPasswdPolicy($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'api settings',
			'action' => 'info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

    $data['policy'] = APIPWPolicy::select()->find(1);

    return $res -> withStatus(200) -> write(json_encode($data));
  }

  public function postPasswdPolicy($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'api settings',
			'action' => 'change',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

    $validation = $this->validator->validate($req, [
      'api_pw_length' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(4)->setName('API Password length')),
      'tac_pw_length' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(4)->setName('Tacacs Password length')),
      'api_pw_uppercase' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('API Uppercase Characters')),
      'api_pw_lowercase' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('API Lowcase Characters')),
      'api_pw_numbers' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('API Numbers Characters')),
      'api_pw_special' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('API Special Characters')),
      'tac_pw_uppercase' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('TACACS Uppercase Characters')),
      'tac_pw_lowercase' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('TACACS Lowcase Characters')),
      'tac_pw_numbers' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('TACACS Numbers Characters')),
      'tac_pw_special' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)->setName('TACACS Special Characters')),
    ]);

    if ($validation->failed()){
      $data['error']['status']=true;
      $data['error']['validation']=$validation->error_messages;
      return $res -> withStatus(200) -> write(json_encode($data));
    }

    $allParams = $req->getParams();

		unset($allParams['id']);

    $data['result'] = APIPWPolicy::where('id', 1)->update($allParams);

    return $res -> withStatus(200) -> write(json_encode($data));
  }
####PASSWORD POLICY#####End
####SMTP SETTINGS######
public function getSmtp($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'get',
    'object' => 'api settings',
    'action' => 'info',
  ]);
  #check error#
  if ($_SESSION['error']['status']){
    $data['error']=$_SESSION['error'];
    return $res -> withStatus(401) -> write(json_encode($data));
  }
  //INITIAL CODE////END//
  //CHECK ACCESS TO THAT FUNCTION//START//
  if(!$this->checkAccess(1, true))
  {
    return $res -> withStatus(403) -> write(json_encode($data));
  }
  //CHECK ACCESS TO THAT FUNCTION//END//

  $data['smtp'] = APISMTP::select()->find(1);

  $data['smtp']['smtp_password'] = $this->generateRandomString( strlen($data['smtp']['smtp_password']) );

  return $res -> withStatus(200) -> write(json_encode($data));
}

public function postSmtp($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'post',
    'object' => 'api settings',
    'action' => 'change',
  ]);
  #check error#
  if ($_SESSION['error']['status']){
    $data['error']=$_SESSION['error'];
    return $res -> withStatus(401) -> write(json_encode($data));
  }
  //INITIAL CODE////END//
  //CHECK ACCESS TO THAT FUNCTION//START//
  if(!$this->checkAccess(1))
  {
    return $res -> withStatus(403) -> write(json_encode($data));
  }
  //CHECK ACCESS TO THAT FUNCTION//END//

  $validation = $this->validator->validate($req, [
    'smtp_port' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->between(1, 64000)->setName('SMTP Port')),
  ]);

  if ($validation->failed()){
    $data['error']['status']=true;
    $data['error']['validation']=$validation->error_messages;
    return $res -> withStatus(200) -> write(json_encode($data));
  }

  $allParams = $req->getParams();

  unset($allParams['id']);

  $data['result'] = APISMTP::where('id', 1)->update($allParams);

  return $res -> withStatus(200) -> write(json_encode($data));
}

public function postSmtpTest($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'post',
    'object' => 'smtp',
    'action' => 'test',
  ]);
  #check error#
  if ($_SESSION['error']['status']){
    $data['error']=$_SESSION['error'];
    return $res -> withStatus(401) -> write(json_encode($data));
  }
  //INITIAL CODE////END//
  //CHECK ACCESS TO THAT FUNCTION//START//
  if(!$this->checkAccess(1))
  {
    return $res -> withStatus(403) -> write(json_encode($data));
  }
  //CHECK ACCESS TO THAT FUNCTION//END//

  $validation = $this->validator->validate($req, [
    'smtp_test_email' => v::when( v::alwaysValid(), v::email()->notEmpty()->setName('Email') ),
  ]);

  if ($validation->failed()){
    $data['error']['status']=true;
    $data['error']['validation']=$validation->error_messages;
    return $res -> withStatus(200) -> write(json_encode($data));
  }

  $allParams = $req->getParams();

  $email = new EmailEngine(APISMTP::select()->find(1));
  $email->mail->addAddress($allParams['smtp_test_email']);
  $email->setTemplate();
  $data['result'] = $email->send();

  return $res -> withStatus(200) -> write(json_encode($data));
}
####SMTP SETTINGS######End
}
