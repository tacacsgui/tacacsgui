<?php

namespace tgui\Controllers\APISettings;

use tgui\PHPMailer\EmailEngine;
use tgui\Models\APIPWPolicy;
use tgui\Models\APISMTP;
use tgui\Models\APISettings;
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
############
####TIME####
public function getTimeTimezones($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'post',
    'object' => 'time',
    'action' => 'list',
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
  $byId = $req->getParam('byId');

  if ( !empty($byId) ){
    $byId = preg_replace('/[^0-9]/', '', $byId);
    $tempData = trim( shell_exec("timedatectl list-timezones | nl | sed '".$byId."!d'" ) );

    $tempData = ( empty($tempData) ) ?  $byId . ' Error Appeared' : $tempData;
    $data['item'] = array();
    $tempTimezone = preg_split('/\s+/', trim( $tempData ) );
    $data['item'] = [ 'id' => $tempTimezone[0], 'text' =>$tempTimezone[1] ];

    return $res -> withStatus(200) -> write(json_encode($data));
  }

  $search = preg_replace('/[^a-zA-Z0-9]/', '', $req->getParam('search'));
  $page = $req->getParam('page');
  $take = 10 * $page;
  $offset = (10 * ($page - 1)) + 1;

  $tempData = trim( shell_exec('timedatectl list-timezones | nl '.( (empty($search) ? '': '| grep -i '.$search ) ) .' | sed -n "'.$offset.','.$take.'p" ' ) );
  $tempData = explode(PHP_EOL, $tempData);
  $tempData = ( empty($tempData[0]) ) ? [] : $tempData;
  #timedatectl list-timezones |  sed '30!d'
  //$data['test3'] = 'timedatectl list-timezones '.( (empty($search) ? '': '| grep '.$search ) ) .' | sed -n "'.$offset.','.$take.'p" ' ;
	$data['pagination'] = (!$tempData OR count($tempData) < 10) ? ['more' => false] : [ 'more' => true];
  $data['results'] = array();
  for ($i=0; $i < count($tempData); $i++) {
    $tempTimezone = preg_split('/\s+/', trim($tempData[$i]) );
    $timezone = [ 'id' => $tempTimezone[0], 'text' =>$tempTimezone[1] ];
    array_push($data['results'],$timezone);
  }

  return $res -> withStatus(200) -> write(json_encode($data));
}

public function getTimeSettings($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'get',
    'object' => 'time',
    'action' => 'settings',
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
  $data['time'] = APISettings::select(['timezone', 'ntp_list'])->find(1);

  return $res -> withStatus(200) -> write(json_encode($data));
}

public function postTimeSettings($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'post',
    'object' => 'time',
    'action' => 'settings',
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
    'timezone' => v::when( v::nullType(), v::alwaysValid(), v::numeric()->notEmpty()->setName('Timezone') ),
  ]);

  if ($validation->failed()){
    $data['error']['status']=true;
    $data['error']['validation']=$validation->error_messages;
    return $res -> withStatus(200) -> write(json_encode($data));
  }

  $allParams = $req->getParams();

  if ( !empty($allParams['timezone']) ){
    $timezoneName = trim( shell_exec( "timedatectl list-timezones |  sed '".$allParams['timezone']."!d'" ) );
    $data['result_timezone'] = trim( shell_exec( 'sudo '. TAC_ROOT_PATH . "/main.sh ntp timezone ".$timezoneName ) );
  }

  if ( !empty($allParams['ntp_list']) ){

    $ntpfile = fopen(TAC_ROOT_PATH ."/temp/ntp.conf", "w");

    $txt = "# /etc/ntp.conf, configuration for ntpd; see ntp.conf(5) for help\n".
            "         ####!!!created by TacacsGUI project!!!####\n".
            "driftfile /var/lib/ntp/ntp.drift\n";
    $txt .="# By default, exchange time with everybody, but don't allow configuration.\n".
"restrict -4 default kod notrap nomodify nopeer noquery limited\n".
"restrict -6 default kod notrap nomodify nopeer noquery limited\n".
"restrict 127.0.0.1\n".
"restrict ::1\n".
"# Needed for adding pool entries\n".
"restrict source notrap nomodify noquery\n";

    $ntp_list = explode(";", $allParams['ntp_list']);
    for ($i=0; $i < count($ntp_list); $i++) {
      if ( empty(trim($ntp_list[$i])) ) continue;
      $txt .= 'server ' . trim($ntp_list[$i]) . "\n";
    }
    fwrite($ntpfile, $txt);
    fclose($ntpfile);
    $data['result_ntp'] = trim( shell_exec( 'sudo '. TAC_ROOT_PATH . "/main.sh ntp get-config ") );
  }

  $data['result'] = APISettings::where('id', 1)->update($allParams);
  sleep(1);
  return $res -> withStatus(200) -> write(json_encode($data));
}

public function getTimeStatus($req,$res)
{
  //INITIAL CODE////START//
  $data=array();
  $data=$this->initialData([
    'type' => 'get',
    'object' => 'time',
    'action' => 'status',
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
  $output = "command timedatectl :\n";
  $output .= shell_exec('timedatectl');
  $output .= "\n";
  $output .= "command ntpq -p :\n";
  $output .= shell_exec('ntpq -p');

  $data['output'] = $output;

  return $res -> withStatus(200) -> write(json_encode($data));
}
####TIME SETTINGS######End
}
