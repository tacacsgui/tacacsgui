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
	],
	'api_user_groups' =>
	[
		'name' => ['string',''],
		'rights' => ['integer', '0'],
		'default_flag' => ['integer', '0'],
	],
	'api_settings' =>
	[
		'timezone' => ['string', ''],
		'update_url' => ['string', 'https://tacacsgui.com/api/tacacsgui/update/'],
		'update_activated' => ['integer', '0'],
		'update_signin' => ['integer', '1'],
		'api_logging_max_entries' => ['integer', 500],
		'update_key' => ['string', ''],
	],
	'api_logging' =>
	[
		'userName' => ['string',''],
		'userId' => ['string',''],
		'userIp' => ['string',''],
		'objectName' => ['string', ''],
		'objectId' => ['string', ''],
		'action' => ['string', ''],
		'section' => ['string', ''],
		'message' => ['text', '_'],
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
		'priv-lvl' => ['integer', -1],
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
	'tac_log_accounting' =>
	[
		'date' => ['timestamp', '_'],
		'NAS' => ['string', '_'],
		'username' => ['string', '_'],
		'line' => ['string', '_'],
		'NAC' => ['string', '_'],
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
		'NAS' => ['string', '_'],
		'username' => ['string', '_'],
		'line' => ['string', '_'],
		'NAC' => ['string', '_'],
		'action' => ['string', '_'],
		'unknown' => ['string', '_'],
	],
	'tac_log_authorization' =>
	[
		'date' => ['timestamp', '_'],
		'NAS' => ['string', '_'],
		'username' => ['string', '_'],
		'line' => ['string', '_'],
		'NAC' => ['string', '_'],
		'action' => ['string', '_'],
		'cmd' => ['string', '_'],
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
);	

	public function myFirstTable()
	{
		$this->createTable('api_users', $this->tablesArr['api_users']);
		$this->createTable('api_user_groups', $this->tablesArr['api_user_groups']);
		$this->createTable('api_logging', $this->tablesArr['api_logging']);
		$this->setDefaultValues('api_users');
		$this->setDefaultValues('api_user_groups');
		$this->setDefaultValues('api_logging');
	}
	
	private function createTable($tableName,$tableColumns)
	{
		$this->db::schema()->create($tableName, function($table) use ($tableColumns){
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
	
	private function setDefaultValues($tableName)
	{
		switch ($tableName) {
			case 'api_users':
				$this->db::table($tableName)->insert([
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
				$this->db::table($tableName)->insert([
					'name' => 'Administrator',
					'rights' => 2 ,
					'default_flag' => 1 ,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'api_settings':
				$this->db::table($tableName)->insert([
					'update_key' => $this->generateRandomString(),
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_global_settings':
				$this->db::table($tableName)->insert([
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
				$this->db::table($tableName)->insert([
					'username' => strtolower('admin'),
					'login' => 'test',
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_devices':
				$this->db::table($tableName)->insert([
					'name' => 'deviceExample',
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_user_groups':
				$this->db::table($tableName)->insert([
					'name' => 'defaultUserGroup',
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'tac_device_groups':
				$this->db::table($tableName)->insert([
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
				]);
				break;
			case 'mavis_ldap':
				$this->db::table($tableName)->insert([
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				break;
			case 'mavis_otp':
				$this->db::table($tableName)->insert([
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
		
		foreach($this->tablesArr as $tableName => $tableColumns){
			if(!$this->db::schema()->hasTable($tableName))
			{
				//CREATE TABLE//
				$this->createTable($tableName,$tableColumns);
				////////////DEFAULT VALUES/////////
				$this->setDefaultValues($tableName);
				///////////////////////////////////
				$data["message"]="Table ".$tableName." created";
				sleep(1);
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			//IF TABLE ALREADY EXIST CHECK COLUMNS//
			else if(!$this->db::schema()->hasColumns($tableName,array_keys($tableColumns)))
			{
				$preColumnName='id';//IN EVERY TABLE THE FIRST COLUMN IS id// 
				//ADD COLUMNS CHECK//
				foreach($tableColumns as $columnName => $columnType)
				{
					if(!$this->db::schema()->hasColumn($tableName,$columnName))
					{
						//ADD COLUMN//
						$this->db::schema()->table($tableName, function(Blueprint $table) use ($columnName,$preColumnName,$tableColumns) 
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
						$data["message"]="Column ".$columnName." in the table ".$tableName." created";
						sleep(1);
						return $res -> withStatus(200) -> write(json_encode($data));
					}
					$preColumnName=$columnName;
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
	
}