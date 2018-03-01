<?php

require __DIR__ . '/../web/api/config.php';
$loader = require __DIR__ . '/../web/api/vendor/autoload.php';
$loader->addPsr4('parser\\', __DIR__ . '/app');

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

/*php ./parser/parser.php accounting '2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>'*/
/*php ./parser/parser.php authentication '2018-01-21 15:11:47 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|shell login succeeded'*/
/*php ./parser/parser.php authorization '2018-01-21 15:42:51 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|permit|!|no|!|aaa authorization commands 14 default <cr>'

echo -e '2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>\n2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>\n2018-01-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr> | /opt/tgui/parser/tacacs_parser.sh accounting'
*/
	
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($settings['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = new Container;
$container->logType = $argv[1];
$container->logLine = $argv[2];
$container->db = $capsule;

$container->accounting = new \parser\Controllers\Accounting\AccountingController($container);
$container->authentication = new \parser\Controllers\Authentication\AuthenticationController($container);
$container->authorization = new \parser\Controllers\Authorization\AuthorizationController($container);

switch ($container->logType) {
	case ('accounting'):
		$container->accounting->parser();
		break;
	case ('authorization'):
		var_dump($container->authorization->parser());
		break;
	case ('authentication'):
		$container->authentication->parser();
		break;
}

