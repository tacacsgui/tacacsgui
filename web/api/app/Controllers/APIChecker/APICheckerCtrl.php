<?php
namespace tgui\Controllers\APIChecker;

use tgui\Controllers\Controller;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use tgui\Models\TACGlobalConf;

class APICheckerCtrl extends Controller
{

protected $tablesNameArr = array('api_users','tac_users','tac_devices','tac_user_groups');

protected $tablesArr = array(

	'api_users' =>
	[
		'username' => ['string',''],
		'email' => ['string', ''],
		'password' => ['string',''],
		'firstname' => ['string', ''],
		'surname' => ['string', ''],
		'group' => ['integer', '0'],
		'position' => ['string', ''],
		'changePasswd' => ['integer', '1'],
	],
	'api_user_groups' =>
	[
		'name' => ['string',''],
		'rights' => ['integer', '0'],
		'default_flag' => ['integer', '0'],
	],
	'api_settings' =>
	[
		'timezone' => ['string', '348'],
		'update_url' => ['string', 'https://tacacsgui.com/updates/'],
		'update_activated' => ['integer', '0'],
		'update_signin' => ['integer', '1'],
		'ntp_list' => ['string', ''],
		'api_logging_max_entries' => ['integer', 500],
		'update_key' => ['string', ''],
	],
	'api_password_policy' =>
	[
		'api_pw_length' => ['integer', '8'],
		'api_pw_uppercase' => ['integer', '0'],
		'api_pw_lowercase' => ['integer', '0'],
		'api_pw_numbers' => ['integer', '0'],
		'api_pw_special' => ['integer', '0'],
		'api_pw_same' => ['integer', '0'],
		'tac_pw_length' => ['integer', '8'],
		'tac_pw_uppercase' => ['integer', '0'],
		'tac_pw_lowercase' => ['integer', '0'],
		'tac_pw_numbers' => ['integer', '0'],
		'tac_pw_special' => ['integer', '0'],
		'tac_pw_same' => ['integer', '0'],
	],
	'api_smtp' =>
	[
		'smtp_servers' => ['string', ''],
		'smtp_auth' => ['integer', '1'],
		'smtp_username' => ['string', ''],
		'smtp_password' => ['string', ''],
		'smtp_port' => ['integer', '465'],
		'smtp_secure' => ['string', 'ssl'],
	],
	'api_backup' =>
	[
		'tcfgSet' => ['integer', '1'],
		'apicfgSet' => ['integer', '1'],
	],
	'tac_global_settings' =>
	[
		'port' => ['integer', 49],
		'accounting' => ['string', 'accounting_log'],
		'authorization' => ['string', 'authorization_log'],
		'authentication' => ['string', 'authentication_log'],
		'connection_timeout' => ['integer', 600],
		'context_timeout' => ['integer', 3600],
		'max_attempts' => ['integer', 1],
		'backoff' => ['integer', 1],
		'manual' => ['text', '_'],
		'changeFlag' => ['integer', '0'],
		'revisionNum' => ['integer', '0'],
	],
	'tac_users' =>
	[
		'username' => ['string', ''],
		'login' => ['string', ''],
		'login_flag' => ['integer', '0'],
		'enable' => ['string', ''],
		'enable_flag' => ['integer', '0'],
		'group' => ['integer', '0'],
		'disabled' => ['integer', '0'],
		'message' => ['text', '_'],
		'manual_beginning' => ['text', '_'],
		'manual' => ['text', '_'],
		'acl' => ['integer', '0'],
		'service' => ['integer', '0'],
		'pap' => ['string', '_'],
		'pap_flag' => ['integer', '0'],
		'pap_clone' => ['integer', '0'],
		'chap' => ['string', '_'],
		'ms-chap' => ['string', '_'],
		'priv-lvl' => ['integer', '15'],
		'mavis_otp_enabled' => ['integer', '0'],
		'mavis_otp_secret' => ['text', '_'],
		'mavis_otp_period' => ['integer', '30'],
		'mavis_otp_digits' => ['integer', '6'],
		'mavis_otp_digest' => ['string', 'sha1'],
		'mavis_sms_enabled' => ['integer', '0'],
		'mavis_sms_number' => ['string', ''],
		'valid_from' => ['string', '_'],
		'valid_until' => ['string', '_'],
		'default_service' => ['integer', '0'],
	],
	'tac_devices' =>
	[
		'name' => ['string', ''],
		'ipaddr' => ['string', ''],
		'prefix' => ['integer', '32'],
		'enable' => ['string', ''],
		'key' => ['string', ''],
		'enable_flag' => ['integer', '0'],
		'group' => ['integer', '0'],
		'disabled' => ['integer', '0'],
		'vendor' => ['string', ''],
		'model' => ['string', ''],
		'type' => ['string', ''],
		'sn' => ['string', ''],
		'banner_welcome' => ['text', '_'],
		'banner_failed' => ['text', '_'],
		'banner_motd' => ['text', '_'],
		'manual' => ['text', '_'],
	],
	'tac_user_groups' =>
	[
		'name' => ['string',''],
		'enable' => ['string', ''],
		'enable_flag' => ['integer', '0'],
		'message' => ['text', '_'],
		'default_flag' => ['integer', '0'],
		'valid_from' => ['string', '_'],
		'valid_until' => ['string', '_'],
		'acl' => ['integer', '0'],
		'service' => ['integer', '0'],
		'priv-lvl' => ['integer', -1],
		'default_service' => ['integer', '0'],
		'manual_beginning' => ['text', '_'],
		'manual' => ['text', '_'],
	],
	'tac_device_groups' =>
	[
		'name' => ['string',''],
		'enable' => ['string', ''],
		'key' => ['string', ''],
		'enable_flag' => ['integer', '0'],
		'banner_welcome' => ['text', '_'],
		'banner_failed' => ['text', '_'],
		'banner_motd' => ['text', '_'],
		'manual' => ['text', '_'],
		'default_flag' => ['integer', '0']
	],
	'tac_acl' =>
	[
		'name' => ['string',''],
		'line_number' => ['integer', '0'],
		'action' => ['string', ''],
		'nac' => ['string', ''],
		'nas' => ['string', ''],
		'timerange' => ['string', '']
	],
	'tac_services' =>
	[
		'name' => ['string',''],
		'priv-lvl' => ['integer', -1],
		'default_cmd' => ['integer', '0'],
		'manual' => ['text', '_'],
		'manual_conf_only' => ['integer', '0'],
	],
	'mavis_ldap' =>
	[
		'enabled' => ['integer', '0'],
		'type' => ['string', 'microsoft'],
		'scope' => ['string', 'sub'],
		'hosts' => ['string', ''],
		'base' => ['string', ''],
		'filter' => ['string', ''],
		'user' => ['string', ''],
		'password' => ['string', ''],
		'password_hide' => ['integer', '1'],
		'group_prefix' => ['string', ''],
		'group_prefix_flag' => ['integer', '0'],
		'memberOf' => ['integer', '0'],
		'fallthrough' => ['integer', '0'],
		'cache_conn' => ['integer', '0'],
		'tls' => ['integer', '0'],
		'path' => ['string', '/usr/local/lib/mavis/mavis_tacplus_ldap.pl'],
	],
	'mavis_otp' =>
	[
		'enabled' => ['integer', '0'],
		'period' => ['integer', '30'],
		'digits' => ['integer', '6'],
		'digest' => ['string', 'sha1'],
	],
	'mavis_sms' =>
	[
		'enabled' => ['integer', '0'],
		'ipaddr' => ['string', ''],
		'port' => ['integer', '2775'],
		'login' => ['string', ''],
		'pass' => ['string', ''],
		'srcname' => ['string', ''],
	],
	'mavis_otp_base' =>
	[
		'otp' => ['string', ''],
		'username' => ['string', ''],
		'type' => ['string', ''],
		'destination' => ['string', ''],
		'status' => ['string', ''],
	],

);

	protected $tablesArr_log = array(
		'api_logging' =>
		[
			'username' => ['string',''],
			'uid' => ['string',''],
			'user_ip' => ['string',''],
			'obj_name' => ['string', ''],
			'obj_id' => ['string', ''],
			'action' => ['string', ''],
			'section' => ['string', ''],
			'message' => ['text', '_'],
		],
		'tac_log_accounting' =>
		[
			'date' => ['timestamp', '_'],
			'nas' => ['string', '_'],
			'username' => ['string', '_'],
			'line' => ['string', '_'],
			'nac' => ['string', '_'],
			'action' => ['string', '_'],
			'task_id' => ['string', '_'],
			'timezone' => ['string', '_'],
			'service' => ['string', '_'],
			'priv-lvl' => ['string', '_'],
			'cmd' => ['string', '_'],
			'disc-cause' => ['string', '_'],
			'disc-cause-ext' => ['string', '_'],
			'pre-session-time' => ['string', '_'],
			'elapsed_time' => ['string', '_'],
			'stop_time' => ['string', '_'],
			'nas-rx-speed' => ['string', '_'],
			'nas-tx-speed' => ['string', '_'],
			'unknown' => ['string', '_'],
		],
		'tac_log_authentication' =>
		[
			'date' => ['timestamp', '_'],
			'nas' => ['string', '_'],
			'username' => ['string', '_'],
			'line' => ['string', '_'],
			'nac' => ['string', '_'],
			'action' => ['string', '_'],
			'unknown' => ['string', '_'],
		],
		'tac_log_authorization' =>
		[
			'date' => ['timestamp', '_'],
			'nas' => ['string', '_'],
			'username' => ['string', '_'],
			'line' => ['string', '_'],
			'nac' => ['string', '_'],
			'action' => ['string', '_'],
			'cmd' => ['string', '_'],
		]
	);

	protected $databases = ['default', 'logging'];

	public function getTableTitles($table = '')
	{
		return ($table) ? array_keys( $this->tablesArr[$table] ) : [];
	}

	public function myFirstTable()
	{
		$this->createTable('default', 'api_users', $this->tablesArr['api_users']);
		$this->createTable('default', 'api_user_groups', $this->tablesArr['api_user_groups']);
		$this->createTable('logging', 'api_logging', $this->tablesArr_log['api_logging']);
		$this->setDefaultValues('default', 'api_users');
		$this->setDefaultValues('default', 'api_user_groups');
		$this->setDefaultValues('logging', 'api_logging');
	}

	private function createTable($database = 'default', $tableName, $tableColumns)
	{
		$this->db::connection($database)->getSchemaBuilder()->create($tableName, function($table) use ($tableColumns){
			$table->increments('id');
			foreach($tableColumns as $columnName => $columnAttr){
				switch ($columnAttr[0]) {
					case 'string':
						$columnObj = $table->string($columnName);
						break;
					case 'integer':
						$columnObj = $table->integer($columnName);
						break;
					case 'text':
						$columnObj = $table->text($columnName);
						break;
					case 'timestamp':
						$columnObj = $table->timestamp($columnName);
						break;
				}
				if( (isset($columnAttr[1]) OR $columnAttr[1] == 0)
					AND
					($columnAttr[0]=='integer' AND $columnAttr[1] != '_')
					OR
					($columnAttr[1]!='_' AND $columnAttr[0]=='string')
					OR
					($columnAttr[1]!='_' AND $columnAttr[0]=='text')
				)//end if
				{
					$columnObj->default($columnAttr[1]);
				}
				else
				{
					$columnObj -> nullable();
				}
			}
			$table->timestamps();
		});
	}

	private function setDefaultValues($database = 'default', $tableName)
	{
		switch ($tableName) {
			case 'api_users':
				$this->db::connection($database)->table($tableName)->insert([
					'username' => strtolower('tacgui'),
					'password' => '$2y$10$zZPJVM/qGizgWqq1Mbs0T.E6uCG.fz09pWYxsYj2oieAhm2BZtUPe', //tacgui//
					'email' => '',
					'firstname' => 'tacgui',
					'surname' => 'tacgui',
					'position' => '',
					'group' => 1 ,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'api_user_groups':
				$this->db::connection($database)->table($tableName)->insert([
					'name' => 'Administrator',
					'rights' => 2 ,
					'default_flag' => 1 ,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'api_settings':
				$this->db::connection($database)->table($tableName)->insert([
					'update_key' => $this->generateRandomString(),
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'api_password_policy':
				$this->db::connection($database)->table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'api_smtp':
				$this->db::connection($database)->table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'api_backup':
				$this->db::connection($database)->table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_global_settings':
				$this->db::connection($database)->table($tableName)->insert([
					'manual' => "log = accounting_log {\n".
					"	destination =  \"| ".TAC_ROOT_PATH."/parser/tacacs_parser.sh accounting\" \n".
					"	log separator = \"|!|\"} \n".
					"log = authentication_log {\n".
					"	destination = \"| ".TAC_ROOT_PATH."/parser/tacacs_parser.sh authentication\"\n".
					"	log separator = \"|!|\"}\n".
					"log = authorization_log {\n".
					"	destination = \"| ".TAC_ROOT_PATH."/parser/tacacs_parser.sh authorization\"\n".
					"	log separator = \"|!|\"}",

					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_users':
				$this->db::connection($database)->table($tableName)->insert([
					'username' => strtolower('admin'),
					'login' => 'test',
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_devices':
				/*$this->db::connection($database)->table($tableName)->insert([
					'name' => 'deviceExample',
					'ipaddr' => '10.1.1.1',
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]); */
				break;
			case 'tac_user_groups':
				$this->db::connection($database)->table($tableName)->insert([
					'name' => 'defaultUserGroup',
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_device_groups':
				/*$this->db::connection($database)->table($tableName)->insert([
					'name' => 'defaultGroup',
					'enable' => 'cisco123',
					'key' => 'tguiKey',
					'enable_flag' => 0,
					'banner_welcome' => 'Unauthorized access is prohibited!',
					'banner_failed' => 'Go away! Unauthorized access is prohibited!',
					'banner_motd' => 'Today is a perfect day! Have a nice day!',
					'default_flag' => 1,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);*/
				break;
			case 'mavis_ldap':
				$this->db::connection($database)->table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'mavis_otp':
				$this->db::connection($database)->table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'mavis_sms':
				$this->db::connection($database)->table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
		}
	}

################################################

	public function getCheckDatabase($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'apichecker',
			'action' => 'check database',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$updateFlag = (@$req->getParam('update')) ? 1 : 0;
		//var_dump($req->getParam('update'));die();
		$data['messages'] = array( );
		foreach ($this->databases as $database) {
			switch ($database) {
				case 'logging':
					$tablesArr = $this->tablesArr_log;
					break;

				default:
					$tablesArr = $this->tablesArr;
					break;
			}
			foreach($tablesArr as $tableName => $tableColumns){
				if(!$this->db::connection($database)->getSchemaBuilder()->hasTable($tableName))
				{
					$data["messages"][count($data["messages"])] = "Table ".$tableName." created";
					if ($updateFlag) {
						$this->databaseFix();
						//CREATE TABLE//
						$this->createTable($database, $tableName,$tableColumns);
						////////////DEFAULT VALUES/////////
						$this->setDefaultValues($database, $tableName);
						///////////////////////////////////
						sleep(1); return $res -> withStatus(200) -> write(json_encode($data));
					}
				}
				//IF TABLE ALREADY EXIST CHECK COLUMNS//
				else if(!$this->db::connection($database)->getSchemaBuilder()->hasColumns($tableName,array_keys($tableColumns)))
				{
					$preColumnName='id';//IN EVERY TABLE THE FIRST COLUMN IS id//
					//ADD COLUMNS CHECK//
					foreach($tableColumns as $columnName => $columnType)
					{
						if(!$this->db::connection($database)->getSchemaBuilder()->hasColumn($tableName,$columnName))
						{
							$data["messages"][count($data["messages"])]="Column ".$columnName." in the table ".$tableName." created";
							if ($updateFlag) {
								$databaseFix = $this->databaseFix();
								if ($databaseFix['status']){
									$data["messages"][0]=$databaseFix['message'];
									$data['test1'] = $this->db::connection($database)->getSchemaBuilder()->getColumnListing('api_logging');
									sleep(1); return $res -> withStatus(200) -> write(json_encode($data));
								}
								//ADD COLUMN//
								$this->db::connection($database)->getSchemaBuilder()->table($tableName, function(Blueprint $table) use ($columnName,$preColumnName,$tableColumns)
								{
									switch ($tableColumns[$columnName][0]) {
										case 'string':
											$columnObj = $table->string($columnName);
											break;
										case 'integer':
											$columnObj = $table->integer($columnName);
											break;
										case 'text':
											$columnObj = $table->text($columnName);
											break;
										case 'timestamp':
											$columnObj = $table->timestamp($columnName);
										break;
									}

									$columnObj -> after($preColumnName);
									if(isset($tableColumns[$columnName][1])
										AND
										($tableColumns[$columnName][0]=='integer' AND $tableColumns[$columnName][1]!= '_' )
										OR
										($tableColumns[$columnName][1]!='_' AND $tableColumns[$columnName][0]=='string')
										OR
										($tableColumns[$columnName][1]!='_' AND $tableColumns[$columnName][0]=='text')
									)//end if
									{
										$columnObj -> default($tableColumns[$columnName][1]);//ADD DEFAULT VALUE IF SET////
									}
									else
									{
										$columnObj -> nullable();
									}
								});
								sleep(1); return $res -> withStatus(200) -> write(json_encode($data));
							}//if $updateFlag end
						}
						$preColumnName=$columnName;
					}
				}
			}
		}
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	################################################
	###################API STATUS MAIN##############
	public function getApiStatus($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'apichecker',
			'action' => 'api status',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['configuration']=TACGlobalConf::select('changeFlag')->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	################################################
	###################API TIME MAIN##############
	public function getApiTime($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'apichecker',
			'action' => 'api time',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['time']=trim(shell_exec('date +"%T %D"'));

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	################################################
	private function databaseFix()
	{
		$response = ['status' => false, 'message' => ''];

		if ( array_search('userName', $this->db::connection('logging')->getSchemaBuilder()->getColumnListing('api_logging')) )
		{
			$response['status'] = true;
			$this->db::connection('logging')->getSchemaBuilder()->table('api_logging', function(Blueprint $table) {
            $table->dropColumn('userName');
            $table->dropColumn('userId');
            $table->dropColumn('userIp');
            $table->dropColumn('objectName');
            $table->dropColumn('objectId');
      });
			$response['message'] = 'Table fix for api_logging';
			//$this->db::connection('logging')->getSchemaBuilder()->table('api_logging')->renameColumn('userName', 'username');
		}

		if ( array_search('NAS', $this->db::connection('logging')->getSchemaBuilder()->getColumnListing('tac_log_authentication')) )
		{
			$response['status'] = true;
			$this->db::connection('logging')->getSchemaBuilder()->table('tac_log_authentication', function(Blueprint $table) {
            $table->renameColumn('NAS', 'nas');
            $table->renameColumn('NAC', 'nac');
      });
			$this->db::connection('logging')->getSchemaBuilder()->table('tac_log_authorization', function(Blueprint $table) {
            $table->renameColumn('NAS', 'nas');
						$table->renameColumn('NAC', 'nac');
      });
			$this->db::connection('logging')->getSchemaBuilder()->table('tac_log_accounting', function(Blueprint $table) {
            $table->renameColumn('NAS', 'nas');
						$table->renameColumn('NAC', 'nac');
      });
			$response['message'] = 'Table fix for tac_log_* tables';
		}
		return $response;
	}
}
