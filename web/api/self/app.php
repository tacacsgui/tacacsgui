#!/usr/bin/php
<?php

require __DIR__ . '/../constants.php';
require __DIR__ . '/../config.php';
require __DIR__ . '/../vendor/autoload.php';
// $loader = require __DIR__ . '/../vendor/autoload.php';
// $loader->addPsr4('self\\', __DIR__ . '/');

$app = new \Slim\App();

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
$capsule->addConnection($settings['db'], 'default');
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = $app->getContainer();

$container['debug'] = (in_array('debug', $argv) === true);

$container['db'] = function($container) use ($capsule) {
	return $capsule;
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

$container->HAGeneral->check();
