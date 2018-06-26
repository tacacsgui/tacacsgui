<?php

namespace tgui\Controllers\APIBackup;

use tgui\Controllers\Controller;
use tgui\Models\TACGlobalConf;

class APIBackupCtrl extends Controller
{
#######################################
#####	LIST OF TABLES FOR BACKUP	###
#######################################
private $listOfTacacsConfTables = '"--tables tac_devices tac_device_groups tacGlobalConf tac_users tac_user_groups"';
private $listOfTacacsReportsTables = '--tables tac_log_accounting tac_log_authorization tac_log_authentication';

	###################	MAKE Backup########START##
	public function makeBackup($attrArray = ['make'=>'all'])
	{
		$backupPart=$attrArray['make'];
		shell_exec(TAC_ROOT_PATH . '/backup.sh check'); //check
		$data['make'] = shell_exec(TAC_ROOT_PATH . '/backup.sh make '. DB_USER . ' ' . DB_PASSWORD . ' '. DB_NAME ." '". $backupPart ."'");//make
		$revision = TACGlobalConf::find(1);
		$data['diff'] = intval( trim( shell_exec(TAC_ROOT_PATH . '/backup.sh diff ' ."'". $backupPart ."' '". $revision->revisionNum ."'") ) );//diff
		if ( $revision->revisionNum == 0 ) $data['diff'] = 999;
		if ( $data['diff'] == 0) {
			shell_exec(TAC_ROOT_PATH . '/backup.sh removeLast' );
			return ['status'=> false, 'message'=> 'Changes not found '];
		}

		shell_exec(TAC_ROOT_PATH . '/backup.sh removeLast' );
		$revision->timestamps = false;
		$revision->revisionNum += 1;
		$revision->changeFlag = 0;
		$revision->save();
		$data['make'] = shell_exec(TAC_ROOT_PATH . '/backup.sh make '. DB_USER . ' ' . DB_PASSWORD . ' '. DB_NAME. ' '. $backupPart .' '. $revision->revisionNum);//make
		$logEntry=array('action' => 'add', 'objectName' => $backupPart, 'section' => 'api backup', 'message' => 601);
		$this->APILoggingCtrl->makeLogEntry($logEntry);
		return ['status'=> true, 'message'=> 'Backup added'];
	}
	###################	MAKE Backup########END##
	#######################################
	###################	POST BACKUP DATATABLES ########START##
	public function postBackupDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'backup',
			'action' => 'datatables',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = $data['recordsFiltered'] = 1;

		$START=$params['start']+1;
		$LENGTH=$params['length'] + $params['start'];
		$ORDER=$params['order'][0]['dir'];

		//$backupCommand="mysqldump -u ".DB_USER." -p".DB_PASSWORD." ".DB_NAME." > /var/www/html/backups/database/".date('Y-m-d_H:i:s', time())."_all.sql";

		//$data['check'] =shell_exec("ls ".TAC_ROOT_PATH."/backups/database/ -r | sed '10,20!d' | paste -s -d ' ' "); //check
		$data['result'] = trim(shell_exec(TAC_ROOT_PATH . '/backup.sh datatables '. $START .' '.$LENGTH.' '.$ORDER)); //check

		$data['result2'] = explode("\n", $data['result'] );
		$data['result3'] = explode(";", $data['result2'][0] );
		$data['recordsTotal']=$data['recordsFiltered'] = $data['result3'][0];
		//$data['recordsFiltered']=$data['result3'][1];

		$data['result4'] = explode(" ", $data['result2'][1] );

		$data['data']=array();
		$tempArray=array();

		$revision = TACGlobalConf::select('revisionNum')->first()->revisionNum;

		for ($i=0; $i < count($data['result4']); $i++)
		{
			if ($data['result4'][$i] == '') continue;
			$tempVariable = explode( '.', explode('_',$data['result4'][$i])[3] )[0];
			$tempArray['fileName']=$data['result4'][$i];
			$tempArray['size']=$data['result4'][$i+1].'byte';
			$tempArray['version']=$tempVariable . ( ($tempVariable == $revision) ? ' Used Now' : '');
			$tempArray['used']= ( ($tempVariable == $revision) ? 1 : 0 );
			$tempArray['buttons']='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_apiBackup.restore(\''.$data['result4'][$i].'\',\''.$deviceGroup['name'].'\')">Restore</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_apiBackup.delete(\''.$data['result4'][$i].'\',\''.$deviceGroup['name'].'\')">Del</button>';
			array_push($data['data'],$tempArray);
			$i++;
		}

		//$data['make'] = shell_exec(TAC_ROOT_PATH . '/backup.sh make '. DB_USER . ' ' . DB_PASSWORD . ' '. DB_NAME. ' '. 'tcfg' );//make
		//gurkin33@tgui:/var/www/html$ ls backups/database/ -lr | awk {'print $9,$5'}
		//$data['make'] = shell_exec(TAC_ROOT_PATH . '/backup.sh make '. DB_USER . ' ' . DB_PASSWORD . ' '. DB_NAME );//make
		//ls backups/database/ -lr | grep -Eo "(20[1-7][0-9]-[0-1][0-9]-[0-3][0-9]_[0-2][0-9]:[0-6][0-9]:[0-6][0-9].+$)" | sed '11,20!d'

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	###################	POST BACKUP DATATABLES ########END##
	#####################################################
	###################	POST BACKUP DELETE ########START##
	public function postBackupDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'backup',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(9))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result'] = trim(shell_exec(TAC_ROOT_PATH . '/backup.sh delete '. $req->getParam('name')));

		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('name'), 'section' => 'api backup', 'message' => 602);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP DELETE ########END##
	###################################################
	###################	POST BACKUP RESTORE ########START##
	public function postBackupRestore($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'backup',
			'action' => 'restore',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(9))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result'] = trim(shell_exec(TAC_ROOT_PATH . '/backup.sh restore '. DB_USER . ' ' . DB_PASSWORD . ' '. DB_NAME. ' '. $req->getParam('name')));

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'restore', 'objectName' => $req->getParam('name'), 'section' => 'api backup', 'message' => 603);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP DELETE ########END##
}
