<?php
ini_set('memory_limit', '1024M'); // or you could use 1G

require __DIR__ . '/../constants.php';

use Respect\Validation\Validator as v;

session_start();

$_SESSION['error']=array();
$_SESSION['error']['status']=true;
$_SESSION['error']['authorized']=false;
$_SESSION['error']['message']='Unknown Error';

require __DIR__ . '/../config.php';
require __DIR__ . '/../vendor/autoload.php';

use tgui\Controllers\APISettings\HA;
use Illuminate\Database\Capsule\Manager as Capsule;
$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
		'db' => [
			'default' => [
				'driver' => 'mysql',
				'host'	=> DB_HOST,
				'database' => DB_NAME,
				'username' => ( ! HA::isSlave() ) ? DB_USER : 'tgui_ro',
				'password' => ( ! HA::isSlave() ) ? DB_PASSWORD : HA::slavePsk(),
				'charset' => DB_CHARSET,
				'collation' => DB_COLLATE,
				'prefix' => ''
			],
			'logging' => [
				'driver' => 'mysql',
				'host'	=> DB_HOST,
				'database' => DB_NAME_LOG,
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'charset' => DB_CHARSET,
				'collation' => DB_COLLATE,
				'prefix' => ''
			]
		]
	],
]);

$container = $app->getContainer();

$capsule = new Capsule;
$capsule->addConnection($container['settings']['db']['default'], 'default');
$capsule->addConnection($container['settings']['db']['logging'], 'logging');
$capsule->setAsGlobal();
$capsule->schema();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule) {
	return $capsule;
};

$container['validator'] = function($container) {
	return new \tgui\Validation\Validator;
};

$container['HomeController'] = function($container) {
	return new \tgui\Controllers\HomeController($container);
};

$container['AuthController'] = function($container) {
	return new \tgui\Controllers\Auth\AuthController($container);
};

$container['APIUsersCtrl'] = function($container) {
	return new \tgui\Controllers\APIUsers\APIUsersCtrl($container);
};

$container['APIUpdateCtrl'] = function($container) {
	return new \tgui\Controllers\APIUpdate\APIUpdateCtrl($container);
};

$container['APIUserGrpsCtrl'] = function($container) {
	return new \tgui\Controllers\APIUserGrps\APIUserGrpsCtrl($container);
};

$container['APISettingsCtrl'] = function($container) {
	return new \tgui\Controllers\APISettings\APISettingsCtrl($container);
};

$container['APIHACtrl'] = function($container) {
	return new \tgui\Controllers\APIHA\APIHACtrl($container);
};

$container['APIDevCtrl'] = function($container) {
	return new \tgui\Controllers\APIDev\APIDevCtrl($container);
};

$container['TACDevicesCtrl'] = function($container) {
	return new \tgui\Controllers\TACDevices\TACDevicesCtrl($container);
};
$container['TACDeviceGrpsCtrl'] = function($container) {
	return new \tgui\Controllers\TACDeviceGrps\TACDeviceGrpsCtrl($container);
};
$container['TACUsersCtrl'] = function($container) {
	return new \tgui\Controllers\TACUsers\TACUsersCtrl($container);
};

$container['TACUserGrpsCtrl'] = function($container) {
	return new \tgui\Controllers\TACUserGrps\TACUserGrpsCtrl($container);
};

$container['TACACLCtrl'] = function($container) {
	return new \tgui\Controllers\TACACL\TACACLCtrl($container);
};

$container['TACServicesCtrl'] = function($container) {
	return new \tgui\Controllers\TACServices\TACServicesCtrl($container);
};

$container['TACConfigCtrl'] = function($container) {
	return new \tgui\Controllers\TACConfig\TACConfigCtrl($container);
};

$container['APICheckerCtrl'] = function($container) {
	return new \tgui\Controllers\APIChecker\APICheckerCtrl($container);
};
$container['TACReportsCtrl'] = function($container) {
	return new \tgui\Controllers\TACReports\TACReportsCtrl($container);
};
$container['APILoggingCtrl'] = function($container) {
	return new \tgui\Controllers\APILogging\APILoggingCtrl($container);
};
$container['APIBackupCtrl'] = function($container) {
	return new \tgui\Controllers\APIBackup\APIBackupCtrl($container);
};
$container['APIDownloadCtrl'] = function($container) {
	return new \tgui\Controllers\APIDownload\APIDownloadCtrl($container);
};
$container['MAVISLDAP'] = function($container) {
	return new \tgui\Controllers\MAVISLDAP\MAVISLDAPCtrl($container);
};
$container['MAVISOTP'] = function($container) {
	return new \tgui\Controllers\MAVISOTP\MAVISOTPCtrl($container);
};
$container['MAVISSMS'] = function($container) {
	return new \tgui\Controllers\MAVISSMS\MAVISSMSCtrl($container);
};

/*$container['csrf'] = function($container) {
	return new \Slim\Csrf\Guard;
};*/

$container['auth'] = function($container) {
	return new \tgui\Auth\Auth;
};

//$app->add(new \tgui\Middleware\ValidationErrorsMiddleware($container));
//$app->add(new \tgui\Middleware\OldInputMiddleware($container));
$app->add(new \tgui\Middleware\ChangeHeaderMiddleware($container));

//$app->add($container->csrf); //Turn on CSRF for all project//

v::with('tgui\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
