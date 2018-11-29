#!/usr/bin/php
<?php
require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';

use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;

require __DIR__ . '/../controller.php';

$mavis = new mavis_cotrl();

$debug = true;
$debugPrefix = 'OTP Module. ';

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

while($f = fgets(STDIN)){
	if (trim($f) == '=') break;
	if (trim($f) == '') continue;
	$mavis->in($f);
}

if ($debug) $mavis->debugIn($debugPrefix.'Start!');

	$user = $capsule->table('tac_users')->select('mavis_otp_secret','mavis_otp_period','mavis_otp_digits','mavis_otp_digest','group')->where([['username', '=', $mavis->getUsername()],['mavis_otp_enabled', '=', 1]])->first();


	if ($user == NULL){
		// $input[6] = 'NFD';
		// $input[32] = 'User not found. OTP Module';
		// $result = 16;
		// if ($input[49] == 'CHAL') $input[32] = '';
		if ($debug) $mavis->debugIn($debugPrefix.'User not found! Exit.');
		$mavis->out(AV_V_RESULT_NOTFOUND);
	}
	else
	{
		//$otp = TOTP::create($user->mavis_otp_secret);
		if ($debug) $mavis->debugIn($debugPrefix.'User found! Create the key.');
		$otp = TOTP::create(
				$user->mavis_otp_secret,
				$user->mavis_otp_period, // The period (30 seconds)
				$user->mavis_otp_digest, // The digest algorithm
				$user->mavis_otp_digits
		);
		$verification = $otp->verify($mavis->getPassword());
		if ($debug) $mavis->debugIn($debugPrefix.'Verification status: ' . ( ($verification) ? 'allow' : 'deny' ) );
	switch ($mavis->getVariable(AV_A_TACTYPE)/*$input[49]*/) {
			// case 'CHAL':
			// 	$input[32] = 'Please use your OTP password';
			// 	$result = 0;
			// 	break;
			case 'AUTH':
				if ($verification)
				{
					if ($debug) $mavis->debugIn($debugPrefix.'User Auth Success! Exit.');
					$mavis->auth();
					$mavis->out();
				}
				else
				{
					if ($debug) $mavis->debugIn($debugPrefix.'User Access Deny! Exit.');
					$mavis->out(AV_V_RESULT_FAIL);
				}
				break;
			case 'CHPW':
				if ($debug) $mavis->debugIn($debugPrefix.'WTF is this ?! Change passwd? Really? Exit.');
				$mavis->out();
				// $input[32] = 'You can\'t use that function here!';
				// $input[6] = 'NAK';
				// $input[49] = 'AUTH';
				// unset($input[50]);
				// unset($input[3]);
				// $result = 1;
				break;
		}
	}
if ($debug) $mavis->debugIn($debugPrefix.'Outside of module!');

die();
