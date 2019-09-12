<?php

namespace tgui\Controllers\TACConfig;

use tgui\Controllers\TACConfig\ConfigPatterns;
use tgui\Models\TACGlobalConf;
use tgui\Controllers\Controller;
// use tgui\Controllers\APISettings\HA;

use Respect\Validation\Validator as v;

class TACConfigCtrl extends Controller
{
	public function getConfigGen($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'config',
			'action' => 'generate',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$html = (empty($req->getParam('html'))) ? false : true;

		$data['ha'] = ['config'=>[], 'slaves'=>[],'master'=>[]];
		$data['ha']['config'] = $this->HAGeneral->getFullConfig();
		if (empty($data['ha']['config'])) $data['ha']['config'] = false;
		$data['ha']['slaves'] = $this->HAMaster->getSlaves();
		$data['ha']['master'] = $this->HASlave->getMaster();

		$data['tac_mavis']=array_values(ConfigPatterns::tacMavisGeneralGen($html));
		$data['tac_devices']=array_values(ConfigPatterns::tacDevicesPartGen($html));
		$data['tac_devGrps']=array_values(ConfigPatterns::tacDeviceGroupsPartGen($html));
		$data['tac_usrGrps']=array_values(ConfigPatterns::tacUserGroupsPartGen($html));
		$data['tac_users']=array_values(ConfigPatterns::tacUsersPartGen($html));
		$data['spawnd']=array_values(ConfigPatterns::tacSpawndPartGen($html));
		$data['tac_general']=array_values(ConfigPatterns::tacGeneralPartGen($html));
		$data['tac_acl']=array_values(ConfigPatterns::tacACLPartGen($html));

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////OUTPUT PARSER///////////////////START//
	private function arrayParserToText($array,$separator)
	{
		$output='';
		foreach($array as $someId => $someParams)
		//for($someId = 0; $someId < count($array); $someId++)
		{
			// if ($someId == 0)
			// {
			// 	$output.=$someParams[0]['name'].$separator;
			// }
			// else
			// {
			  //$someParams = $array[$someId];
				for($someLine = 0; $someLine < count($someParams); $someLine++)
				{
					if ( empty($someParams[$someLine]) ) continue;

					switch ($someLine) {
						case 0:
							$output.=$someParams[$someLine]['name'].$separator;
							break;

						default:
							$output.=$someParams[$someLine].$separator;
							break;
					}
				//}
			}
		}
		return $output;

	}
	//////////////OUTPUT PARSER///////////////////END//
	////////////////////////////////////////////////
	////////////TEST CONFIGURATION////START//
	public static function testConfiguration($confText)
	{
		$errorFlag=false;
		$confTestFile = fopen(TAC_PLUS_CFG_TEST, 'w') or $errorFlag=true;
		if ($errorFlag) return array('error' => true, 'message' => 'Unable to open '.TAC_PLUS_CFG_TEST.' file! Verify file availability and rights to it', 'errorLine' => 0);

		fwrite($confTestFile, $confText);

		if (!fclose($confTestFile)) return array('error' => true, 'message' => 'Unable to close '.TAC_PLUS_CFG_TEST.' file! Verify file availability and rights to it', 'errorLine' => 0);

		shell_exec('tac_plus -P '.TAC_PLUS_CFG_TEST.' 2> '.TAC_PLUS_PARSING);

		$openLogFile=fopen(TAC_PLUS_PARSING, 'r') or $errorFlag=true;
		if ($errorFlag) return array('error' => true, 'message' => 'Unable to open '.TAC_PLUS_PARSING.' file! Verify file availability and rights to it', 'errorLine' => 0);

		$parseData=fread($openLogFile, filesize(TAC_PLUS_PARSING));

		if (!$parseData)
		{
			return array('error' => false, 'message' => 'Success', 'errorLine' => 0);
		}
		else
		{
			preg_match('/.+:(\d+):.+/',$parseData, $matches);
			return array('error' => true, 'message' => $parseData, 'errorLine' => $matches[1]);
		}


		return array('error' => true, 'message' => 'Something goes wrong', 'errorLine' => 0);
	}
	////////////TEST CONFIGURATION////END//
	////////////APPLY CONFIGURATION////START//
	public function applyConfiguration($confText)
	{
		$errorFlag=false;
		$confFile = fopen(TAC_PLUS_CFG, 'w') or $errorFlag=true;
		if ($errorFlag) return array('error' => true, 'message' => 'Unable to open '.TAC_PLUS_CFG.' file! Verify file availability and rights to it', 'errorLine' => 0);

		fwrite($confFile, $confText);

		if (!fclose($confFile)) return array('error' => true, 'message' => 'Unable to close '.TAC_PLUS_CFG.' file! Verify file availability and rights to it', 'errorLine' => 0);

		$someOutput = shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief');

		if ($someOutput == null)
		{
			return array('error' => true, 'message' => 'Error while get tac status. Did you set sudo rights?', 'errorLine' => 0);
		}

		if(preg_match('/.+(inactive\s+.+dead).+/',$someOutput))
		{
			$tryToStart=shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus start');
			$someOutput = shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief');
			if(preg_match('/.+(active\s+.+running).+/',$someOutput))
			{
				return array('error' => false, 'message' => 'Daemon was disabled. Success. '.$someOutput, 'errorLine' => 0);
			}
			return array('error' => true, 'message' => 'Some inside error. '.$someOutput, 'errorLine' => 0);
		}

		if(preg_match('/.+(active\s+.+running).+/',$someOutput))
		{
			$tryToReload=shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus restart');
			$someOutput = shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief');
			return array('error' => false, 'message' => 'Daemon was Reloaded. Success. '."\n".$someOutput, 'errorLine' => 0);
		}


		return array('error' => true, 'message' => $someOutput, 'errorLine' => 0);
	}
	////////////APPLY CONFIGURATION////END//
	////////////////////////////////////////////////
	//////////////CREATE CONFIGURATION////START//
	public function createConfiguration($lineSeparator = "\n")
	{
		$tempMavisGeneralArray=ConfigPatterns::tacMavisGeneralGen(false);
		$tempDeviceArray=ConfigPatterns::tacDevicesPartGen(false);
		$tempDeviceGroupArray=ConfigPatterns::tacDeviceGroupsPartGen(false);
		$tempUserGroupArray=ConfigPatterns::tacUserGroupsPartGen(false);
		$tempUserArray=ConfigPatterns::tacUsersPartGen(false);
		$tempSpawndConfArray=ConfigPatterns::tacSpawndPartGen(false);
		$tempGlobalConfArray=ConfigPatterns::tacGeneralPartGen(false);
		$tempACL=ConfigPatterns::tacACLPartGen(false);

		$output = implode("\n", array_merge (
			ConfigPatterns::tacSpawndPartGen(false),
			ConfigPatterns::tacGeneralPartGen(false),
			ConfigPatterns::tacMavisGeneralGen(false),
			ConfigPatterns::tacACLPartGen(false),
			ConfigPatterns::tacDeviceGroupsPartGen(false),
			ConfigPatterns::tacDevicesPartGen(false),
			ConfigPatterns::tacUserGroupsPartGen(false),
			ConfigPatterns::tacUsersPartGen(false)
		));

		//////////////////////////////////
		$output.="\n}##END GLOBAL CONFIGURATION".$lineSeparator;
		//////////////////////////////////

		return $output;
	}

	public function getConfigGenFile($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'config',
			'action' => 'generate to file',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$lineSeparator = ($req->getParam('contentType') == 'html' ) ? '</p>' : "\n";
		$contentTypeOutput = ($req->getParam('contentType') == 'html' ) ? 'text/html' : 'application/json';
		$output="";

		$output = $this->createConfiguration($lineSeparator);

		if ($req->getParam('confSave')=='yes'){

			$data['confTest']=$this->testConfiguration($output);

			if($data['confTest']['error'])
			{
				$data['error']['status'] = $data['confTest']['error'];
				///LOGGING//start//
				$logEntry=array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 502);
				$this->APILoggingCtrl->makeLogEntry($logEntry);
				///LOGGING//end//
				return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
			}
			///LOGGING//start//
			$logEntry = array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 501);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			$data['slaves'] = [];
			$data['cfg']='';
			$data['api']=APIVER;
			//Backup check and make
			$doBackup = $req->getParam('doBackup');

			$unstoppable = true;
			if ($this->HAGeneral->isMaster())
				$unstoppable = $this->HAMaster->checkSlaveCfg();

			if ( $doBackup /*OR $unstoppable*/ ) {
				$data['backup'] = $doBackup = $this->APIBackupCtrl->makeBackup(['make' => 'tcfg']);
			if ( !$doBackup['status'] AND $unstoppable) {
					$data['applyStatus'] = ['error' => true, 'message' => $doBackup['message'], 'errorLine' => 0];
					return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
				}
			}
			///LOGGING//
			$data['applyStatus']=$this->applyConfiguration($output);

			if ($this->HAGeneral->isMaster() AND !$data['applyStatus']['error']){
				$this->HAGeneral->setCfg();
				$data['cfg']= $this->HAGeneral->config['cfg'];
				//$this->HAGeneral->getFullConfig();
				$db = $this->databaseHash()[0];
				$data['slaves'] = $this->HAMaster->getSlaves();
				for ($sl=0; $sl < count($data['slaves']); $sl++) {
					$data['slaves'][$sl]['resp'] = $this->HAMaster->slaveRequest($data['slaves'][$sl]['ip'], 'apply', $this->HAGeneral->psk, $db);
					if ($data['slaves'][$sl]['resp']) {
						$this->HAMaster->setSlave([
							'api' => $data['slaves'][$sl]['resp']->api,
							'db' => $data['slaves'][$sl]['resp']->db,
							'status' => ($data['slaves'][$sl]['resp']->status) ? 99 : 90,
							'cfg' => $data['slaves'][$sl]['resp']->cfg,
						],$data['slaves'][$sl]['ip']);
					}
					$data['slaves'][$sl]['api'] = $data['slaves'][$sl]['resp']->api;
					$data['slaves'][$sl]['db'] = $data['slaves'][$sl]['resp']->db;
					$data['slaves'][$sl]['cfg'] = $data['slaves'][$sl]['resp']->cfg;
					$data['slaves'][$sl]['date'] = date('Y-m-d H:i:s', time());
					$data['slaves'][$sl]['status'] = ($data['slaves'][$sl]['resp']->status) ? 99 : 90;
				}
			}

			///LOGGING//start//
			$logEntry = [ 'action' => 'tacacs apply conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => (( !$data['applyStatus']['error'] ) ? 503 : 504)];

			///LOGGING//end//

			$data['changeConfiguration']= ( !$data['applyStatus']['error'] ) ? $this->changeConfigurationFlag(['unset' => 1]) : 0;

			$this->APILoggingCtrl->makeLogEntry($logEntry);
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}

		if($req->getParam('confTest') == 'on')
		{
			$data['confTest']=$this->testConfiguration($output);
			$data['error']['status'] = $data['confTest']['error'];
			///LOGGING//start//
			$logEntry= ($data['confTest']['error']) ? array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 502) : array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 501);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}


		if ($req->getParam('contentType') != 'html')
		{
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}
		else
		{
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write($output);
		}
	}
	//////////////CREATE CONFIGURATION////END//
	// public function ApplySlaveCfg($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'post',
	// 		'object' => 'config',
	// 		'action' => 'slave apply',
	// 	]);
	// 	#check error#
	// 	if ($_SESSION['error']['status']){
	// 		$data['error']=$_SESSION['error'];
	// 		return $res -> withStatus(401) -> write(json_encode($data));
	// 	}
	// 	//INITIAL CODE////END//
	//
	// 	//CHECK SHOULD I STOP THIS?//START//
	// 	if( $this->shouldIStopThis() )
	// 	{
	// 		$data['error'] = $this->shouldIStopThis();
	// 		return $res -> withStatus(400) -> write(json_encode($data));
	// 	}
	// 	//CHECK SHOULD I STOP THIS?//END//
	// 	//CHECK ACCESS TO THAT FUNCTION//START//
	// 	if(!$this->checkAccess(6))
	// 	{
	// 		return $res -> withStatus(403) -> write(json_encode($data));
	// 	}
	// 	//CHECK ACCESS TO THAT FUNCTION//END//
	//
	// 	$ha = new HA();
	// 	$data['checksum'] = [];
	// 	$tempArray = $this->db::select( 'CHECKSUM TABLE '. implode( ",", array_keys($this->tablesArr) ) );
	// 	for ($i=0; $i < count($tempArray); $i++) {
	// 	  $data['checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
	// 	}
	// 	$data['server_response'] = $ha->sendConfigurationApply([ 'checksum'=>$data['checksum'], 'sid' => $req->getParam('sid')]);
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
	// }
	public function postConfigGen($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'config',
			'action' => 'generate',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////////
	////////GET EDIT GLOBAL PARAMETERS//////////////
	public function getEditConfigGlobal($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'config',
			'action' => 'global edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$data['global_variables']=TACGlobalConf::select()->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	/////////////////////////////////////////////////
	////////POST EDIT GLOBAL PARAMETERS//////////////
	public function postEditConfigGlobal($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'config',
			'action' => 'global edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'port' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'max_attempts' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'backoff' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'connection_timeout' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'context_timeout' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'authentication' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'authorization' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'accounting' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'syslog_ip' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::ip(), v::equals('') )->setName('IP Address') ),
			'syslog_port' => v::when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()->setName('Port')),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['tglobal_update']=TACGlobalConf::where([['id','=',1]])->
			update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'tacacs global settings', 'obj_id' => '', 'section' => 'tacacs global settings', 'message' => 505);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////
	////////POST EDIT GLOBAL PARAMETERS//////////////
	public function postConfPart($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'config',
			'action' => 'config part',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		// if(!$this->checkAccess(6))
		// {
		// 	return $res -> withStatus(403) -> write(json_encode($data));
		// }
		//CHECK ACCESS TO THAT FUNCTION//END//
		$allParams = $req->getParams();

		if ( empty($allParams['target']) ){
			$data['error']['status']=true;
			$data['error']['message']='Bad Request';
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		switch ($allParams['target']) {
			case 'device':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(2, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacDevicesPartGen(true, $allParams['id']);
				break;
			case 'deviceGrp':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(3, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacDeviceGroupsPartGen(true, $allParams['id']);
				break;
			case 'user':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(4, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacUsersPartGen(true, $allParams['id']);
				break;
			case 'userGrp':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(5, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacUserGroupsPartGen(true, $allParams['id']);
				break;
			case 'acl':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(11, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacACLPartGen(true, $allParams['id']);
				break;
			case 'service':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(11, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacService(true, $allParams['id']);
				break;
			case 'cmd':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(11, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = ConfigPatterns::tacCMDAttr(true, $allParams['id']);
				break;
			default:
				$data['error']['status']=true;
				$data['error']['message']='Bad Request';
				return $res -> withStatus(200) -> write(json_encode($data));
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////
	////////POST Daemon CONFIG//////////////
	public function postDaemonConfig($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'Daemon',
			'action' => 'config',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$data['tacacsStatusMessage'] = trim(shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief'));
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['action'] = $action = ( !empty($req->getParam('action')) ) ? $req->getParam('action') : '';

		switch ($action) {
			case ('start'):
				$data['action'] = 'start';
				$data['tacacsStatusMessage'] = trim(shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus start'));
				sleep(2);
				$data['tacacsStatusMessage'] .= trim(shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief'));
				break;
			case ('stop'):
				$data['action'] = 'stop';
				$data['tacacsStatusMessage'] = trim(shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus stop'));
				sleep(2);
				$data['tacacsStatusMessage'] .= trim(shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief'));
				break;
			case ('reload'):
				$data['action'] = 'reload';
				$data['tacacsStatusMessage'] = trim( shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus restart') );
				sleep(2);
				$data['tacacsStatusMessage'] .= trim(shell_exec('sudo '. TAC_ROOT_PATH .'/main.sh tac_plus status brief'));
				break;
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////
}##END OF CLASS
