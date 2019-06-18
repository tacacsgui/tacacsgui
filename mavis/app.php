#!/usr/bin/php
<?php
require __DIR__ . '/../web/api/config.php';
require __DIR__ . '/../web/api/constants.php';
$loader = require __DIR__ . '/../web/api/vendor/autoload.php';
$loader->addPsr4('mavis\\', __DIR__ . '/');

class Container {

	private $objects;

	public function __get($class)
	{
		if(isset($this->objects[$class]))
		{
			return $this->objects[$class];
		}
		return $this->objects[$class] = new $class();
	}
}

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

$container = new Container;
// $container->logType = $argv[1];
// $container->logLine = $argv[2];
// $container->server_ip = ( isset($argv[3]) ) ? $argv[3] : 'localhost';
$container->db = $capsule;

$container->local = new \mavis\Controllers\Local\Local($container);
$container->otp = new \mavis\Controllers\OTP\OTP($container);
$container->sms = new \mavis\Controllers\SMS\SMS($container);
$container->tguiotp = new \mavis\Controllers\TGUIOTP\TGUIOTP($container);
$container->ldap = new \mavis\Controllers\LDAP\LDAP($container);

$container->mavis = new \mavis\Controllers\Controller($container);

$container->mavis->debugEmpty();

$container->modules = $container->db::select( $container->db::raw( "SELECT ".
	"(SELECT COUNT(*) FROM tgui.mavis_local where `enabled` = 1) as m_local, ".
	"(SELECT COUNT(*) FROM tgui.mavis_ldap where `enabled` = 1) as m_ldap, ".
	"(SELECT COUNT(*) FROM tgui.mavis_otp where `enabled` = 1) as m_otp, ".
	"(SELECT COUNT(*) FROM tgui.mavis_sms where `enabled` = 1) as m_sms" ) );

$container->otp_settings = $container->db->table('mavis_otp')->select(['period','digest','digits'])->first();

$container->mavis->debugIn( 'Debug MAVIS Start' );
$container->mavis->debugIn( 'Modules: ' . json_encode ( $container->modules ) );

while($f = fgets(STDIN)){
	$container->mavis->in($f);
	if ( ! preg_match("/^=$/i", trim($f) ) ) continue;
	// if (trim($f) == '=') break;
	// if (trim($f) == '') continue;

	switch (true) {
		case ( $container->local->check() ):
			$container->local->run();

			break;
		case ( $container->otp->check() ):
			$container->otp->run();

			break;
		case ( $container->sms->check() ):
			$container->sms->run();

			break;
		case ( $container->ldap->check() ):
			$container->ldap->run();

			break;
	  default:
		  $container->mavis->result('NFD');
	}

	$container->mavis->out();
//exit (0);
}
