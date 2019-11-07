<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes // FIX LOOP Timeout Issue
set_time_limit(300); // FIX LOOP Timeout Issue
ini_set('memory_limit', '1024M'); // or you could use 1G
// date_default_timezone_set ( trim( shell_exec("timedatectl | grep 'Time zone:' | awk '{ print $3 }'")) );

require __DIR__ . '/../constants.php';

use Respect\Validation\Validator as v;

session_start();

$_SESSION['error']=array();
$_SESSION['error']['status']=true;
$_SESSION['error']['authorized']=false;
$_SESSION['error']['message']='Unknown Error';

require __DIR__ . '/../config.php';
require __DIR__ . '/../vendor/autoload.php';

use tgui\Controllers\APIHA\HAGeneral;
use Illuminate\Database\Capsule\Manager as Capsule;
$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
		'db' => [
			'default' => [
				'driver' => 'mysql',
				'host'	=> DB_HOST,
				'database' => DB_NAME,
				'username' => ( ! HAGeneral::isSlave() ) ? DB_USER : 'tgui_ro',
				'password' => ( ! HAGeneral::isSlave() ) ? DB_PASSWORD : HAGeneral::isSlave(),
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
	return new \tgui\Controllers\API\APIUsers\APIUsersCtrl($container);
};

$container['APIUpdateCtrl'] = function($container) {
	return new \tgui\Controllers\APIUpdate\APIUpdateCtrl($container);
};

$container['APIUserGrpsCtrl'] = function($container) {
	return new \tgui\Controllers\API\APIUserGrps\APIUserGrpsCtrl($container);
};

$container['APISettingsCtrl'] = function($container) {
	return new \tgui\Controllers\APISettings\APISettingsCtrl($container);
};

$container['APIHACtrl'] = function($container) {
	return new \tgui\Controllers\APIHA\APIHACtrl($container);
};

$container['APINotificationCtrl'] = function($container) {
	return new \tgui\Controllers\APINotification\APINotificationCtrl($container);
};
$container['APIDevCtrl'] = function($container) {
	return new \tgui\Controllers\APIDev\APIDevCtrl($container);
};

$container['TACDevicesCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACDevices\TACDevicesCtrl($container);
};
$container['TACDeviceGrpsCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACDeviceGrps\TACDeviceGrpsCtrl($container);
};
$container['TACUsersCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACUsers\TACUsersCtrl($container);
};

$container['TACUserGrpsCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACUserGrps\TACUserGrpsCtrl($container);
};

$container['TACACLCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACACL\TACACLCtrl($container);
};

$container['TACServicesCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACServices\TACServicesCtrl($container);
};

$container['TACCMDCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACCMD\TACCMDCtrl($container);
};

$container['TACConfigCtrl'] = function($container) {
	return new \tgui\Controllers\TACConfig\TACConfigCtrl($container);
};

$container['TACExportCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACExport\TACExportCtrl($container);
};
$container['TACImportCtrl'] = function($container) {
	return new \tgui\Controllers\TAC\TACImport\TACImportCtrl($container);
};

$container['ObjAddress'] = function($container) {
	return new \tgui\Controllers\Obj\ObjAddress\ObjAddress($container);
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
	return new \tgui\Controllers\MAVIS\MAVISLDAP\MAVISLDAPCtrl($container);
};
$container['MAVISLocal'] = function($container) {
	return new \tgui\Controllers\MAVIS\MAVISLocal\MAVISLocalCtrl($container);
};
$container['MAVISOTP'] = function($container) {
	return new \tgui\Controllers\MAVIS\MAVISOTP\MAVISOTPCtrl($container);
};
$container['MAVISSMS'] = function($container) {
	return new \tgui\Controllers\MAVIS\MAVISSMS\MAVISSMSCtrl($container);
};

$container['ConfManager'] = function($container) {
	return new \tgui\Controllers\ConfManager\ConfManager($container);
};
$container['ConfModels'] = function($container) {
	return new \tgui\Controllers\ConfManager\ConfModels($container);
};
$container['ConfDevices'] = function($container) {
	return new \tgui\Controllers\ConfManager\ConfDevices($container);
};
$container['ConfGroups'] = function($container) {
	return new \tgui\Controllers\ConfManager\ConfGroups($container);
};
$container['ConfigCredentials'] = function($container) {
	return new \tgui\Controllers\ConfManager\ConfigCredentials($container);
};
$container['ConfQueries'] = function($container) {
	return new \tgui\Controllers\ConfManager\ConfQueries($container);
};

$container['HAGeneral'] = function($container) {
	return new \tgui\Controllers\APIHA\HAGeneral($container);
};
$container['HAMaster'] = function($container) {
	return new \tgui\Controllers\APIHA\HAMaster($container);
};
$container['HASlave'] = function($container) {
	return new \tgui\Controllers\APIHA\HASlave($container);
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

$app->add(new Tuupola\Middleware\JwtAuthentication([
		//"path" => "/api/auth/123",
		"ignore" => ["/auth", "/tacacs/user/change_passwd/change/", "/backup/download/", "/backup/upload/", '/ha/', '/export/', '/import/'],
		"attribute" => "decoded_token_data",
    "secret" => DB_PASSWORD,
		"algorithm" => ["HS256"],
		"secure" => false,
		"error" => function ($response, $arguments) {
				$data["status"] = "error";
				$data["message"] = $arguments["message"];
				return $response
						->withHeader("Content-Type", "application/json")
						->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}
]));

//$app->add($container->csrf); //Turn on CSRF for all project//

v::with('tgui\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
