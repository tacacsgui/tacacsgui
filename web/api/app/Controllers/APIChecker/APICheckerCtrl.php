<?php
namespace tgui\Controllers\APIChecker;

use tgui\Controllers\Controller;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use tgui\Models\TACGlobalConf;

class APICheckerCtrl extends Controller
{

	protected $tablesNameArr = array('api_users','tac_users','tac_devices','tac_user_groups');

	public function getTableTitles($table = '', $db = 'default')
	{
		switch ($db) {
			case 'logging':
				return ($table) ? array_keys( $this->tablesArr_log[$table] ) : [];
				break;
			default:
				return ($table) ? array_keys( $this->tablesArr[$table] ) : [];
				break;
		}
	}

	public function myFirstTable()
	{
		$this->createTable('default', 'api_users', $this->tablesArr['api_users']);
		$this->createTable('default', 'api_user_groups', $this->tablesArr['api_user_groups']);
		if(!$this->db::connection('logging')->getSchemaBuilder()->hasTable('api_logging'))
		$this->createTable('logging', 'api_logging', $this->tablesArr_log['api_logging']);

		$this->setDefaultValues('default', 'api_users');
		$this->setDefaultValues('default', 'api_user_groups');
		//$this->setDefaultValues('logging', 'api_logging');
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
				if( //(isset($columnAttr[1]) )//OR $columnAttr[1] == 0)  AND
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
			case 'api_notification':
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
			case 'mavis_local':
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
		//var_dump( $this->db::getSchemaBuilder()->getColumnType('tac_users', 'username') ); die;
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
						$this->createTable($database, $tableName, $tableColumns);
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

		$data['time']=$this->serverTime();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	################################################
	private function databaseFix()
	{
		$response = ['status' => false, 'message' => ''];

		if ( $this->db::connection('default')->getSchemaBuilder()->hasTable('tac_users') AND $this->db::connection('default')->getSchemaBuilder()->getColumnType('tac_users', 'group') == 'integer' ) {
			$response['status'] = true;
			$this->db::connection('default')->getSchemaBuilder()->table('tac_users', function (Blueprint $table) {
			    $table->string('group')->nullable()->change();
					//$table->renameColumn('group', 'groups');
			});

			$response['message'] = 'Table fix for tac_users';
		}

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
