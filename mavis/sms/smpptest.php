<?php 

if (empty($argv[1]) OR empty($argv[2]) OR empty($argv[3]) OR empty($argv[4]) OR empty($argv[5]) OR empty($argv[6]) OR empty($argv[7]) OR empty($argv[8]) ) die("Some of arguments did not set! \n");

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

$type = $argv[1];
$ipaddr = $argv[2];
$port = $argv[3];
$debug = $argv[4];
$login = $argv[5];
$pass = $argv[6];
$srcname = $argv[7];
$number = $argv[8];
$username = (empty($argv[9])) ? '' : $argv[9];

$smppclient = new mavis_smpp($capsule);
$smppclient->ipaddr = $ipaddr;
$smppclient->port = $port;
$smppclient->debug = $debug;
$smppclient->login = $login;
$smppclient->pass = $pass;
$smppclient->srcname = $srcname;
$smppclient->number = $number;

($username == '' ) ? 
	$smppclient->send(array('destination' => $number)) 
	: 
	$smppclient->send(
		array(
			'type' => 'sms',
			'message' => 'otp',
			'username' => $username, 
			'destination' => $number
		)
	);