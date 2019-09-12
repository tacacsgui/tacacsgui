<?php
namespace tgui\Controllers\APIChecker;

use tgui\Controllers\Controller;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use tgui\Models\TACGlobalConf;

use tgui\Services\CMDRun\CMDRun as CMDRun;

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
			if ( ! @$tableColumns['unsetId'] ) $table->increments('id');
			else unset($tableColumns['unsetId']);
			$timestamp = ( @$tableColumns['unsetTimestamp'] ) ? false : true;
			unset($tableColumns['unsetTimestamp']);
			$this->db::getSchemaBuilder()->disableForeignKeyConstraints();
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
					case 'foreign-null':
						$table->integer($columnName)->nullable()->unsigned();
    				$table->foreign($columnName)->references($columnAttr[1]['references'])->on($columnAttr[1]['on'])->onDelete($columnAttr[1]['onDelete']);
						break;
					case 'foreign':
						$table->unsignedInteger($columnName);
    				$table->foreign($columnName)->references($columnAttr[1]['references'])->on($columnAttr[1]['on'])->onDelete($columnAttr[1]['onDelete']);
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
				elseif( $columnAttr[0] != 'foreign' AND $columnAttr[0] != 'foreign-null')
				{
					$columnObj -> nullable();
				}
			}
			if( $timestamp ) $table->timestamps();
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
				$this->db::connection($database)->table($tableName)->insert([
					'name' => 'defaultGroup',
					// 'enable' => 'cisco123',
					// 'key' => 'tguiKey',
					// 'enable_flag' => 0,
					'banner_welcome' => 'Unauthorized access is prohibited!',
					'banner_failed' => 'Go away! Unauthorized access is prohibited!',
					'banner_motd' => 'Today is a perfect day! Have a nice day!',
					'default_flag' => 1,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
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
		//Sel self-check script//
		CMDRun::init()->setCmd(MAINSCRIPT)->setAttr( [ 'self-test'] )->get();
		/////////////////////////
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
				$data["debug"] = json_encode($tableName);
				if(!$this->db::connection($database)->getSchemaBuilder()->hasTable($tableName))
				{
					$data["messages"][count($data["messages"])] = "Table ".$tableName." created";
					if ($updateFlag) {
						//CREATE TABLE//
						$this->createTable($database, $tableName, $tableColumns);
						////////////DEFAULT VALUES/////////
						$this->setDefaultValues($database, $tableName);
						///////////////////////////////////
						//$this->databaseFix();
						sleep(1); return $res -> withStatus(200) -> write(json_encode($data));
					}
				}
				//IF TABLE ALREADY EXIST CHECK COLUMNS//
				else if(!$this->db::connection($database)->getSchemaBuilder()->hasColumns($tableName,array_keys($tableColumns)))
				{
					$preColumnName = ($this->db::connection($database)->getSchemaBuilder()->hasColumn($tableName,'id')) ? 'id' : '';
					if ( @$tableColumns['unsetId'] ) unset($tableColumns['unsetId']);
					$timestamp = ( @$tableColumns['unsetTimestamp'] ) ? false : true;
					unset($tableColumns['unsetTimestamp']);
					//IN EVERY TABLE THE FIRST COLUMN IS id//
					//ADD COLUMNS CHECK//
					foreach($tableColumns as $columnName => $columnType)
					{

						if(!$this->db::connection($database)->getSchemaBuilder()->hasColumn($tableName,$columnName))
						{
							//var_dump($tableName);var_dump($columnName);die();
							$data["messages"][count($data["messages"])]="Column ".$columnName." in the table ".$tableName." created";
							if ($updateFlag) {
								//$databaseFix = $this->databaseFix();
								//var_dump($this->db::getSchemaBuilder()->hasColumn('confM_bind_cmdev_tacdev','tac_dev'));die();
								if ($databaseFix['status']){
									$data["messages"][0]=$databaseFix['message'];
									//$data['test1'] = $this->db::connection($database)->getSchemaBuilder()->getColumnListing('api_logging');
									sleep(1); return $res -> withStatus(200) -> write(json_encode($data));
								}
								//ADD COLUMN//
								$this->db::getSchemaBuilder()->disableForeignKeyConstraints();
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
										case 'foreign-null':
											$columnObj = $table->integer($columnName)->nullable()->unsigned();
					    				$table->foreign($columnName)->references($tableColumns[$columnName][1]['references'])->
												on($tableColumns[$columnName][1]['on'])->onDelete($tableColumns[$columnName][1]['onDelete']);
											break;
										case 'foreign':
											$columnObj = $table->unsignedInteger($columnName);
					    				$table->foreign($columnName)->references($tableColumns[$columnName][1]['references'])->
												on($tableColumns[$columnName][1]['on'])->onDelete($tableColumns[$columnName][1]['onDelete']);
											break;
									}
									//var_dump($preColumnName);die();
									if ($preColumnName) $columnObj -> after($preColumnName); else  $columnObj -> first();
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
									elseif ( $tableColumns[$columnName][0] != 'foreign')
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
			}// for end
			//HERE
		} //end of for each database
		if ($updateFlag) {
			//SOME FIX
			$data['fix'] = $this->databaseFix();
			if ($data['fix']['message'] !== '') $data['messages'][] = $data['fix']['message'];
			sleep(1); return $res -> withStatus(200) -> write(json_encode($data));
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
		$data['epoch']=time();
		$data['timezone']=CMDRun::init()->setCmd('cat')->setAttr('/etc/timezone')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	################################################
	private function databaseFix()
	{
		$response = ['status' => false, 'message' => ''];

		// if ( $this->db::connection('default')->getSchemaBuilder()->hasTable('tac_users') AND $this->db::connection('default')->getSchemaBuilder()->getColumnType('tac_users', 'group') == 'integer' ) {
		// 	$response['status'] = true;
		// 	$this->db::connection('default')->getSchemaBuilder()->table('tac_users', function (Blueprint $table) {
		// 	    $table->string('group')->nullable()->change();
		// 			//$table->renameColumn('group', 'groups');
		// 	});
		//
		// 	$response['message'] = 'Table fix for tac_users';
		// }

		if ( $this->db::getSchemaBuilder()->hasColumn('confM_bind_cmdev_tacdev','tac_dev') )
		{
			$this->db::getSchemaBuilder()->table('confM_bind_cmdev_tacdev', function (Blueprint $table) {
        $table->dropForeign('confm_bind_cmdev_tacdev_cm_dev_foreign');
				$table->dropForeign('confm_bind_cmdev_tacdev_tac_dev_foreign');
				$table->dropIndex('confm_bind_cmdev_tacdev_cm_dev_foreign');
				$table->dropIndex('confm_bind_cmdev_tacdev_tac_dev_foreign');
      });
			$this->db::connection('default')->getSchemaBuilder()->dropIfExists('confM_bind_cmdev_tacdev');
			$response['message'] = 'Table confM_bind_cmdev_tacdev deleted';
		}

		if ( $this->db::getSchemaBuilder()->hasColumn('confM_bind_devices_creden','device_id') )
		{
			$this->db::getSchemaBuilder()->table('confM_bind_devices_creden', function (Blueprint $table) {
        $table->dropForeign('confm_bind_devices_creden_creden_id_foreign');
				$table->dropForeign('confm_bind_devices_creden_device_id_foreign');
				$table->dropIndex('confm_bind_devices_creden_creden_id_foreign');
				$table->dropIndex('confm_bind_devices_creden_device_id_foreign');
      });
			$this->db::connection('default')->getSchemaBuilder()->dropIfExists('confM_bind_devices_creden');
			$response['message'] = 'Table confM_bind_devices_creden deleted';
		}

		if ( $this->db::getSchemaBuilder()->hasColumn('confM_bind_query_model','model_id') )
		{
			$this->db::getSchemaBuilder()->table('confM_bind_query_model', function (Blueprint $table) {
        $table->dropForeign('confm_bind_query_model_model_id_foreign');
				$table->dropForeign('confm_bind_query_model_query_id_foreign');
				$table->dropIndex('confm_bind_query_model_model_id_foreign');
				$table->dropIndex('confm_bind_query_model_query_id_foreign');
      });
			$this->db::connection('default')->getSchemaBuilder()->dropIfExists('confM_bind_query_model');
			$this->db::getSchemaBuilder()->table('confM_bind_query_creden', function (Blueprint $table) {
        $table->dropForeign('confm_bind_query_creden_creden_id_foreign');
				$table->dropForeign('confm_bind_query_creden_query_id_foreign');
				$table->dropIndex('confm_bind_query_creden_creden_id_foreign');
				$table->dropIndex('confm_bind_query_creden_query_id_foreign');
      });
			$this->db::connection('default')->getSchemaBuilder()->dropIfExists('confM_bind_query_creden');
			$response['message'] = 'Table confM_bind_query_model and confM_bind_query_creden deleted';
		}
////////////////////////////////////////
////////////////////////////////////////
////////////////////////////////////////
		///BIG UPGRADE///
		if ( array_search('prefix', $this->db::connection('default')->getSchemaBuilder()->getColumnListing('tac_devices')) ){
			$response['status'] = true;
			$this->db::getSchemaBuilder()->disableForeignKeyConstraints();
			$tempData = $this->db::table('tac_devices')->select(['id','name','ipaddr','prefix'])->get();
			foreach ($tempData as $device) {
				$addr = $this->db::table('obj_addresses')->insertGetId([
					'name' => $device->name,
					'address' => $device->ipaddr.'/'.$device->prefix,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);
				$this->db::table('tac_devices')->where('id',$device->id)->update(['address' => $addr]);
			}
			$this->db::getSchemaBuilder()->disableForeignKeyConstraints();
			/////////////////
			///TACACS DEVICE FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_devices', function(Blueprint $table) {
            $table->dropColumn(['prefix', 'ipaddr']);
						$table->integer('connection_timeout')->nullable()->default(null)->change();
						$table->integer('group')->nullable()->unsigned()->default(null)->change();
						$table->foreign('group')->references('id')->
							on('tac_device_groups')->onDelete('restrict');
						$table->integer('acl')->nullable()->unsigned()->default(null)->change();
						$table->foreign('acl')->references('id')->
							on('tac_acl')->onDelete('restrict');
						$table->integer('user_group')->nullable()->unsigned()->default(null)->change();
						$table->foreign('user_group')->references('id')->
							on('tac_user_groups')->onDelete('restrict');
      });
			/////////////////
			///TACACS DEVICE GROUP FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_device_groups', function(Blueprint $table) {
						$table->integer('connection_timeout')->nullable()->default(null)->change();
						$table->integer('acl')->nullable()->unsigned()->default(null)->change();
						$table->foreign('acl')->references('id')->
							on('tac_acl')->onDelete('restrict');
						$table->integer('user_group')->nullable()->unsigned()->default(null)->change();
						$table->foreign('user_group')->references('id')->
							on('tac_user_groups')->onDelete('restrict');
      });
			/////////////////
			///TACACS USER FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_users', function(Blueprint $table) {

				$tempData = $this->db::table('tac_users')->select(['id','group','device_list','device_group_list'])->get();
				foreach ($tempData as $user) {
					$groups = explode(';;', $user->group);
					for ($i=0; $i < count($groups); $i++) {
						if (empty($groups[$i])) continue;
						$addr = $this->db::table('tac_bind_usrGrp')->insert([
							'user_id' => $user->id,
							'group_id' => $groups[$i],
							'order' => $i,
						]);
					}
					$devs = explode(';;', $user->device_list);
					foreach ($devs as $dev) {
						if (empty($dev)) continue;
						$addr = $this->db::table('tac_bind_dev')->insert([
							'user_id' => $user->id,
							'device_id' => $dev
						]);
					}
					$devGrps = explode(';;', $user->device_group_list);
					foreach ($devGrps as $devGrp) {
						if (empty($devGrp)) continue;
						$addr = $this->db::table('tac_bind_devGrp')->insert([
							'user_id' => $user->id,
							'devGroup_id' => $devGrp
						]);
					}
				}

				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'group')) $table->dropColumn('group');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'device_list')) $table->dropColumn('device_list');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'device_group_list')) $table->dropColumn('device_group_list');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'priv-lvl')) $table->dropColumn('priv-lvl');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'test1')) $table->dropColumn('test1');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'client_ip')) $table->dropColumn('client_ip');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'server_ip')) $table->dropColumn('server_ip');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'mavis_otp_enabled')) $table->dropColumn('mavis_otp_enabled');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'mavis_otp_period')) $table->dropColumn('mavis_otp_period');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'mavis_otp_digits')) $table->dropColumn('mavis_otp_digits');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'mavis_otp_digest')) $table->dropColumn('mavis_otp_digest');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'mavis_sms_enabled')) $table->dropColumn('mavis_sms_enabled');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'manual_beginning')) $table->dropColumn('manual_beginning');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_users', 'ms-chap')) $table->dropColumn('ms-chap');

				$table->integer('acl')->nullable()->unsigned()->default(null)->change();
				$table->foreign('acl')->references('id')->
					on('tac_acl')->onDelete('restrict');

				$table->integer('service')->nullable()->unsigned()->default(null)->change();
				$table->foreign('service')->references('id')->
					on('tac_services')->onDelete('restrict');
				// $table->dropColumn(['priv-lvl', 'test1', 'client_ip','server_ip',
				// 	'mavis_otp_enabled','mavis_otp_period','mavis_otp_digits','mavis_otp_digest','manual_beginning']);
      });
			/////////////////
			///TACACS USER GROUP FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_user_groups', function(Blueprint $table) {

				$tempData = $this->db::table('tac_user_groups')->select(['id','device_list','device_group_list','ldap_groups'])->get();
				foreach ($tempData as $group) {
					$devs = explode(';;', $group->device_list);
					foreach ($devs as $dev) {
						if (empty($dev)) continue;
						$addr = $this->db::table('tac_bind_dev')->insert([
							'group_id' => $group->id,
							'device_id' => $dev
						]);
					}
					$devGrps = explode(';;', $group->device_group_list);
					foreach ($devGrps as $devGrp) {
						if (empty($devGrp)) continue;
						$addr = $this->db::table('tac_bind_devGrp')->insert([
							'group_id' => $group->id,
							'devGroup_id' => $devGrp
						]);
					}
					$ldapGrps = explode(';;', $group->ldap_groups);
					foreach ($ldapGrps as $ldapGrp) {
						$group_parse = explode(',', $ldapGrp);

						if (empty($ldapGrp)) continue;
						$id = 0;
						$ldapTest = $this->db::table('ldap_groups')->select('id')->where('cn', $group_parse[0])->first();
						if ( !$ldapTest )
							$id = $this->db::table('ldap_groups')->insertGetId([
								'cn' => $group_parse[0],
								'dn' => $ldapGrp,
								'created_at' => date('Y-m-d H:i:s', time()),
								'updated_at' => date('Y-m-d H:i:s', time())
							]);
						else $id = $ldapTest->id;
						$this->db::table('ldap_bind')->insert([
							'ldap_id' => $id,
							'tac_grp_id' => $group->id
						]);

					}
				}

				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'ldap_groups')) $table->dropColumn('ldap_groups');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'device_list')) $table->dropColumn('device_list');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'device_group_list')) $table->dropColumn('device_group_list');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'priv-lvl')) $table->dropColumn('priv-lvl');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'client_ip')) $table->dropColumn('client_ip');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'server_ip')) $table->dropColumn('server_ip');
				if ($this->db::getSchemaBuilder()->hasColumn('tac_user_groups', 'manual_beginning')) $table->dropColumn('manual_beginning');

				$table->integer('acl')->nullable()->unsigned()->default(null)->change();
				$table->foreign('acl')->references('id')->
					on('tac_acl')->onDelete('restrict');

				$table->integer('service')->nullable()->unsigned()->default(null)->change();
				$table->foreign('service')->references('id')->
					on('tac_services')->onDelete('restrict');
      });
			/////////////////
			///TACACS ACL FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_acl', function(Blueprint $table) {

				$tempData = $this->db::table('tac_acl')->where('line_number', 0)->select(['id','name'])->get();
				foreach ($tempData as $acl) {
					$tempData_ace = $this->db::table('tac_acl')->where('line_number','<>', 0)->where('name',$acl->name)->select(['action','nac','nas','line_number'])->get();
					foreach ($tempData_ace as $ace) {
						$nas = null;
						$nac = null;
						// $ipAddr_nas = explode('/', $ace->nas);
						// $ipAddr_nac = explode('/', $ace->nac);
						// if (empty($ipAddr_nas[1])) $ipAddr_nas[1] = 32;
						$searchNas = $this->db::table('obj_addresses')->where('name', $ace->nas)->first();
						if ($searchNas) {
							$nas = $searchNas->id;
						} else {
							$nas = $this->db::table('obj_addresses')->insertGetId([
								'name' => $ace->nas,
								'address' => $ace->nas,
								// 'prefix' => $ipAddr_nas[1],
								'created_at' => date('Y-m-d H:i:s', time()),
								'updated_at' => date('Y-m-d H:i:s', time())
							]);
						}
						$searchNac = $this->db::table('obj_addresses')->where('name', $ace->nac)->first();
						if ($searchNac) {
							$nac = $searchNac->id;
						} else {
							$nac = $this->db::table('obj_addresses')->insertGetId([
								'name' => $ace->nac,
								'address' => $ace->nac,
								// 'prefix' => $ipAddr_nac[1],
								'created_at' => date('Y-m-d H:i:s', time()),
								'updated_at' => date('Y-m-d H:i:s', time())
							]);
						}

						$this->db::table('tac_acl_ace')->insert([
							'acl_id' => $acl->id,
				      'action' => ($ace->action == 'permit') ? 1 : 0,
				      'order' => $ace->line_number,
				      'nac' => $nac,
				  		'nas' => $nas,
						]);
					}
				}

				$this->db::table('tac_acl')->where('line_number','<>', 0)->delete();
				$table->dropColumn('line_number');
				$table->dropColumn('nas');
				$table->dropColumn('nac');
				$table->dropColumn('action');
				$table->dropColumn('timerange');
      });
			/////////////////
			///TACACS CMD FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_cmd', function(Blueprint $table) {

				$tempData = $this->db::table('tac_cmd')->select(['id','cmd_attr','type'])->get();
				foreach ($tempData as $cmd) {
					if ($cmd->type == 'junos'){
						$this->db::table('tac_cmd')->where('id',$cmd->id)->update([
							'type' => 1,
							'junos' => implode(',', explode(';;', $cmd->cmd_attr))
						]);
					} else {
						$this->db::table('tac_cmd')->where('id',$cmd->id)->update([
							'type' => 0,
						]);
						$args = explode(';;', $cmd->cmd_attr);

						for ($i=0; $i < count($args); $i++) {
							$action = ( preg_match( '/(^permit )/', $args[$i] ) ) ? 1 : 0;
							$args[$i] = preg_replace('/(^permit )/', '', $args[$i]);
							$args[$i] = preg_replace('/(^deny )/', '', $args[$i]);

							if (!trim($args[$i])) continue;

							$this->db::table('tac_cmd_arg')->insert([
								'tac_cmd_id' => $cmd->id,
					      'action' => $action,
					      'order' => $i,
					      'arg' => trim($args[$i]),
							]);
						}
					}
				}

				$table->dropColumn('cmd_attr');

      });
			/////////////////
			///TACACS Service FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('tac_services', function(Blueprint $table) {

				$tempData = $this->db::table('tac_services')->select()->get();

				function filter_cmd($e) {
				    return !empty($e['service_id']) AND !empty($e['cmd_id']) AND !empty($e['section']);
				};

				foreach ($tempData as $service) {
					$service_cmd = [];
					$tempId = $service->id;
					$cisco_rs_cmd = explode(';;', $service->cisco_rs_cmd);
					$h3c_cmd = explode(';;', $service->h3c_cmd);
					$junos_cmd_ao = explode(';;', $service->junos_cmd_ao);
					$junos_cmd_do = explode(';;', $service->junos_cmd_do);
					$junos_cmd_ac = explode(';;', $service->junos_cmd_ac);
					$junos_cmd_dc = explode(';;', $service->junos_cmd_dc);

					foreach ($cisco_rs_cmd as $value) {
						if (empty($value)) continue;
						$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'cisco_rs_cmd'];
					}
					foreach ($h3c_cmd as $value) {
						if (empty($value)) continue;
						$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'h3c_cmd'];
					}
					foreach ($junos_cmd_ao as $value) {
						if (empty($value)) continue;
						$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_ao'];
					}
					foreach ($junos_cmd_do as $value) {
						if (empty($value)) continue;
						$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_do'];
					}
					foreach ($junos_cmd_ac as $value) {
						if (empty($value)) continue;
						$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_ac'];
					}
					foreach ($junos_cmd_dc as $value) {
						if (empty($value)) continue;
						$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_dc'];
					}

					if (count($service_cmd)) $this->db::table('bind_service_cmd')->insert($service_cmd);
				}

				$table->dropColumn('cisco_rs_cmd');
				$table->dropColumn('h3c_cmd');
				$table->dropColumn('junos_cmd_ao');
				$table->dropColumn('junos_cmd_do');
				$table->dropColumn('junos_cmd_ac');
				$table->dropColumn('junos_cmd_dc');
				$table->dropColumn('priv-lvl');
				$table->dropColumn('default_cmd');

      });
			/////////////////
			///API USER FIX
			////////////////
			$this->db::connection('default')->getSchemaBuilder()->table('api_users', function(Blueprint $table) {
						$table->integer('group')->nullable()->unsigned()->default(null)->change();
						$table->foreign('group')->references('id')->
							on('api_user_groups')->onDelete('restrict');
			});
			////////////////////////////////////////
			////////////////////////////////////////
			////////////////////////////////////////
			///END OF BIG UPDATE
			////////////////////////////////////////
			////////////////////////////////////////
			////////////////////////////////////////
			$response['message'] = 'Table tac_devices rebuild';
		}

		////////////////////////////////////////
		///Version 0.9.72 Multiple service
		////////////////////////////////////////
		if ( array_search('service', $this->db::connection('default')->getSchemaBuilder()->getColumnListing('tac_users')) )
		{
			$response['status'] = true;

			$this->db::getSchemaBuilder()->disableForeignKeyConstraints();
			$services = [];

			$users = $this->db::table('tac_users')->select(['id','service'])->get();
			foreach ($users as $user) {
				if ( empty($user->service) ) continue;
				$services[] = ['service_id' => $user->service, 'tac_usr_id' => $user->id, 'tac_grp_id' => null];
			}

			$grps = $this->db::table('tac_user_groups')->select(['id','service'])->get();
			foreach ($grps as $grp) {
				if ( empty($grp->service) ) continue;
				$services[] = ['service_id' => $grp->service, 'tac_usr_id' => null, 'tac_grp_id' => $grp->id];
			}
			if (! empty($services) )
				$this->db::table('tac_bind_service')->insert($services);

			$this->db::getSchemaBuilder()->table('tac_users', function (Blueprint $table) {
        $table->dropForeign('tac_users_service_foreign');
				$table->dropIndex('tac_users_service_foreign');
				$table->dropColumn('service');
      });
			$this->db::getSchemaBuilder()->table('tac_user_groups', function (Blueprint $table) {
        $table->dropForeign('tac_user_groups_service_foreign');
				$table->dropIndex('tac_user_groups_service_foreign');
				$table->dropColumn('service');
      });

			$response['message'] = 'Table fix for service';
			//$this->db::connection('logging')->getSchemaBuilder()->table('api_logging')->renameColumn('userName', 'username');
		}
		/////////////////////////////////////////

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
////////////////////////////////////////
////////////////////////////////////////
////////////////////////////////////////
////////////////////////////////////////
///Version 0.9.74 Service Fix
////////////////////////////////////////

$serviceRef = $this->db::table('INFORMATION_SCHEMA.KEY_COLUMN_USAGE as U')->
	leftJoin('INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS as C', 'U.CONSTRAINT_NAME', '=', 'C.CONSTRAINT_NAME')->
	where([ ['U.TABLE_SCHEMA', 'tgui'], ['U.TABLE_NAME', 'tac_bind_service'], ['U.COLUMN_NAME', 'tac_grp_id'] ])->
	select(['U.COLUMN_NAME', 'C.DELETE_RULE' ])->first();

if ($serviceRef->DELETE_RULE == 'NO ACTION'){
	$this->db::getSchemaBuilder()->disableForeignKeyConstraints();

	$this->db::connection()->getSchemaBuilder()->table('tac_bind_service', function(Blueprint $table) {
		$table->integer('tac_grp_id')->nullable()->unsigned()->default(null)->change();
		$table->dropForeign(['tac_grp_id']);
		$table->foreign('tac_grp_id')->references('id')->on('tac_user_groups')->onDelete('cascade');

		$table->integer('tac_usr_id')->nullable()->unsigned()->default(null)->change();
		$table->dropForeign(['tac_usr_id']);
		$table->foreign('tac_usr_id')->references('id')->on('tac_users')->onDelete('cascade');
	});

	$this->db::connection()->getSchemaBuilder()->table('ldap_bind', function(Blueprint $table) {
		$table->integer('tac_grp_id')->nullable()->unsigned()->default(null)->change();
		$table->dropForeign(['tac_grp_id']);
		$table->foreign('tac_grp_id')->references('id')->on('tac_user_groups')->onDelete('cascade');

		$table->integer('api_grp_id')->nullable()->unsigned()->default(null)->change();
		$table->dropForeign(['api_grp_id']);
		$table->foreign('api_grp_id')->references('id')->on('api_user_groups')->onDelete('cascade');
	});


}


////////////////////////////////////////
////////////////////////////////////////
////////////////////////////////////////
////////////////////////////////////////

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
