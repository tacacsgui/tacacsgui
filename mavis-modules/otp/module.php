#!/usr/bin/php
<?php
require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';

use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;

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

$capsule = new \Illuminate\Database\Capsule\Manager;
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
	
	$user = $capsule->table('tac_users')->select('mavis_otp_secret','mavis_otp_period','mavis_otp_digits','mavis_otp_digest','group')->where([['username', '=', $username],['mavis_otp_enabled', '=', 1]])->first();


	if ($user == NULL){
		$input[6] = 'NFD';
		$input[32] = 'User not found. OTP Module';
		$result = 16;
		if ($input[49] == 'CHAL') $input[32] = '';
	}
	else
	{
		//$otp = TOTP::create($user->mavis_otp_secret);
		$otp = TOTP::create(
				$user->mavis_otp_secret,
				$user->mavis_otp_period,     // The period (30 seconds)
				$user->mavis_otp_digest, // The digest algorithm
				$user->mavis_otp_digits     
		);
		$verification = $otp->verify($otp_password);

		switch ($input[49]) {
			case 'CHAL':
				$input[32] = 'Please use your OTP password';
				$result = 0;
				break;
			case 'AUTH':
				if ($verification)
				{
					/*if ($user->group != 0) {
						$group = $capsule->table('tac_user_groups')->select('name')->where([['id', '=', $user->group]])->first();
						$input[47] = '"'. $group->name .'"';
					}*/
					$input[6] = 'ACK';
					$input[32] = 'Permission accepted. OTP Module';
					$result = 0;
				}
				else
				{
					$input[6] = 'NAK';
					$input[32] = 'Permission denied. OTP Module';
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