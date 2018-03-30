#!/usr/bin/php
<?php
require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';

use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;
use Telegram\Bot\Api;

$telegram = new Api('key');

$response = $telegram->getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$username = $response->getUsername();

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
    $myfile = file_put_contents('/opt/tacacsgui/outputtest.txt', $f, FILE_APPEND);
	$tempArray = explode(" ", trim($f));
	if (trim($f) == '=') break;
	if (trim($f) == '') continue;
	$input[$tempArray[0]]=trim($tempArray[1]);
	if (trim($tempArray[0]) == 4) $username = trim($tempArray[1]);
	if (trim($tempArray[0]) == 8) $otp_password = trim($tempArray[1]);
}

			$input[6] = 'NAK';
			$input[32] = 'Permission denied.';
			$result = 0;

ksort($input);

$output = '';
foreach($input as $index => $value)
{
	$output.= $index.' '.$value."\n";
}
$output.="=".$result."\n";

fwrite(STDOUT, $output);
die();