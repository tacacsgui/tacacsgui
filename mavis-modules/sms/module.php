#!/usr/bin/php
<?php

require __DIR__ . '/smppclient.php';

use Illuminate\Database\Capsule\Manager as Capsule;

	$settings = array(
	'db' => [
		'driver' => 'mysql',
		'host'	=> DB_HOST,
		'database' => DB_NAME,
		'username' => DB_USER,
		'password' => DB_PASSWORD,
		'charset' => DB_CHARSET,
		'collation' => DB_COLLATE,
		'prefix' => ''
	]);
	
	$capsule = new Capsule;
	$capsule->addConnection($settings['db']);
	$capsule->setAsGlobal();
	$capsule->bootEloquent();

$input = array();
$tempArray = array();
$username = $otp_password = '';
$result = 16;

while($f = fgets(STDIN)){
	//$myfile = file_put_contents('/opt/tacacsgui/outputtest.txt', $f, FILE_APPEND);
	if (trim($f) == '=') break;
	if (trim($f) == '') continue;
	$tempArray = explode(" ", trim($f));
	$input[$tempArray[0]]=trim($tempArray[1]);
	if (trim($tempArray[0]) == 4) $username = trim($tempArray[1]);
	if (trim($tempArray[0]) == 8) $otp_password = trim($tempArray[1]);
}
	
	$user = $capsule->table('tac_users')->select('mavis_sms_number','group')->where([['username', '=', $username],['mavis_sms_enabled', '=', 1]])->first();


	if ($user == NULL){
		$input[6] = 'NFD';
		$input[32] = 'User not found. OTP Module';
		$result = 16;
		if ($input[49] == 'CHAL') $input[32] = '';
	}
	else
	{
		$smppclient = new mavis_smpp($capsule);
		//$otp_gen = new otp_gen;
		
		switch ($input[49]) {
			case 'CHAL':
				//$input[32] = 'Please use your OTP password';
				$settings = $capsule->table('mavis_sms')->select()->first();
				
				$smppclient->ipaddr = $settings->ipaddr;
				$smppclient->port = $settings->port;
				//$smppclient->debug = $debug;
				$smppclient->login = $settings->login;
				$smppclient->pass = $settings->pass;
				$smppclient->srcname = $settings->srcname;
				$smppclient->number = $user->mavis_sms_number;
				
				$smppclient->send(
					array(
						'type' => 'sms',
						'message' => 'otp',
						'username' => $input[4], 
						'destination' => $user->mavis_sms_number
					)
				);
				
				$input[32] = 'Please use your OTP password SMS';
				$result = 0;
				break;
			case 'AUTH':
				$verification = $smppclient->check_auth($input[4],$input[8]);
				
				if ($verification)
				{
					/*if ($user->group != 0) {
						$group = $capsule->table('tac_user_groups')->select('name')->where([['id', '=', $user->group]])->first();
						$input[47] = '"'. $group->name .'"';
					}*/
					$input[6] = 'ACK';
					$input[32] = 'Permission accepted. SMS Module';
					$result = 0;
				}
				else
				{
					$input[6] = 'NAK';
					$input[32] = 'Permission denied. SMS Module';
					$result = 0;
				}
				break;
			case 'CHPW':
				$input[32] = 'You can\'t use that function here!';
				$input[6] = 'NAK';
				$input[49] = 'AUTH';
				unset($input[50]);
				unset($input[3]);
				$result = 1;
				break;
		}	
	}

ksort($input);

$output = '';
foreach($input as $index => $value)
{
	$output.= $index.' '.$value."\n";
}
$output.="=".$result."\n";

//$myfile = file_put_contents('/opt/tacacsgui/outputtest.txt', $output , FILE_APPEND);
//$myfile = file_put_contents('/opt/tacacsgui/outputtest.txt', 'OTP = '. $output.PHP_EOL , FILE_APPEND);

fwrite(STDOUT, $output);
die();