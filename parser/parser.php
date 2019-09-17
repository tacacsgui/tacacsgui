<?php
// require '/opt/tacacsgui/web/api/app/Controllers/APIHA/HAGeneral.php';
// require '/opt/tacacsgui/web/api/app/Controllers/APIHA/HASlave.php';
require __DIR__ . '/../web/api/config.php';
require __DIR__ . '/../web/api/constants.php';
$loader = require __DIR__ . '/../web/api/vendor/autoload.php';
$loader->addPsr4('parser\\', __DIR__ . '/app');

use tgui\Controllers\APIHA\HAGeneral;
use tgui\Controllers\APIHA\HASlave;

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
		'database' => DB_NAME_LOG,
		'username' => DB_USER,
		'password' => DB_PASSWORD,
		'charset' => DB_CHARSET,
		'collation' => DB_COLLATE,
		'prefix' => ''
		],
	'api_settings' => [
		'driver' => 'mysql',
		'host'	=> DB_HOST,
		'database' => DB_NAME,
		'username' => DB_USER,
		'password' => DB_PASSWORD,
		'charset' => DB_CHARSET,
		'collation' => DB_COLLATE,
		'prefix' => ''
		]);

/*php ./parser/parser.php accounting '2019-09-11 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>'*/
/*php ./parser/parser.php authentication '2019-09-17 15:11:47 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|shell login succeeded'*/
/*php ./parser/parser.php authentication '2019-09-11 15:11:47 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|shell login failed'*/
/*php ./parser/parser.php authorization '2018-01-21 15:42:51 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|permit|!|no|!|aaa authorization commands 14 default <cr>'

echo -e '2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>\n2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>\n2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr> | /opt/tgui/parser/tacacs_parser.sh accounting'
*/

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($settings['db'], 'default');
$capsule->addConnection($settings['api_settings'], 'api_settings');
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = new Container;
$container->logType = $argv[1];
$container->logLine = $argv[2];
$container->server_ip = ( isset($argv[3]) ) ? $argv[3] : 'localhost';
$container->db = $capsule;

$container->accounting = new \parser\Controllers\Accounting\AccountingController($container);
$container->authentication = new \parser\Controllers\Authentication\AuthenticationController($container);
$container->authorization = new \parser\Controllers\Authorization\AuthorizationController($container);
$container->postEngine = new \parser\Controllers\PostEngine\PostEngine($container);

switch ($container->logType) {
	case ('accounting'):
		$container->accounting->parser();
		break;
	case ('authorization'):
		$container->authorization->parser();
		//file_put_contents ( __DIR__ . '/test.txt' , $argv[2]);
		break;
	case ('authentication'):
		$container->authentication->parser();
		break;
}

if (HAGeneral::isSlave()){
	// var_dump(HASlave::sendLogEvent(['log_type' => $container->logType, 'log_entry' => $container->logLine]));
	if (!HASlave::sendLogEvent(['log_type' => $container->logType, 'log_entry' => $container->logLine]));
		echo 0;
}
