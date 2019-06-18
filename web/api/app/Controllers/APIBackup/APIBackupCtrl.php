<?php

namespace tgui\Controllers\APIBackup;

use tgui\Controllers\Controller;
use tgui\Models\TACGlobalConf;
use tgui\Models\APIBackup;
use tgui\Services\CMDRun\CMDRun as CMDRun;

class APIBackupCtrl extends Controller
{
#######################################
#####	LIST OF TABLES FOR BACKUP	###
#######################################
private $listOfTacacsConfTables = '"--tables tac_devices tac_device_groups tacGlobalConf tac_users tac_user_groups"';
private $listOfTacacsReportsTables = '--tables tac_log_accounting tac_log_authorization tac_log_authentication';

	public function tcfgSet()
	{
		return APIBackup::select()->find(1)->tcfgSet;
	}

	public function apicfgSet()
	{
		return APIBackup::select()->find(1)->apicfgSet;
	}

	###################	MAKE Backup########START##
	public function makeBackup( $attrArray = ['make'=>'full', 'diff'=>true] )
	{
		$backupPart=$attrArray['make'];
		if ( !isset($attrArray['diff']) ) $attrArray['diff'] = true;
		shell_exec(TAC_ROOT_PATH . '/backup.sh check'); //check

		$revision = ($attrArray['make'] == 'tcfg') ? TACGlobalConf::find(1)->revisionNum : 0;

		$makeBkp = CMDRun::init()->setCmd(TAC_ROOT_PATH . '/backup.sh')->
				setAttr(['make',DB_USER, DB_PASSWORD, DB_NAME, $backupPart]);

		$data['make'] = $makeBkp->setAttr(($revision + 1))->get();//make
		$test01= $makeBkp->setAttr(($revision + 1))->showCmd();
		$diff = CMDRun::init()->v2()->setCmd(TAC_ROOT_PATH . '/backup.sh')->
				setAttr(['diff', $backupPart, $revision]);
		$data['diff'] = ( $attrArray['diff'] ) ? intval( trim( $diff->get() ) ) : 999;//diff
		$test02 = $diff->showCmd();
		if ( $data['diff'] == 0) {
			shell_exec(TAC_ROOT_PATH . '/backup.sh removeLast' );
			return ['status'=> false, 'message'=> 'Changes not found ' , 'test' => $test02 ];
		}

		if ( $attrArray['make'] == 'tcfg' ) {
			shell_exec(TAC_ROOT_PATH . '/backup.sh removeLast' );
			$revision = TACGlobalConf::find(1);
			$revision->timestamps = false;
			$revision->revisionNum += 1;
			$revision->changeFlag = 0;
			$revision->save();
			$revision = $revision->revisionNum;
			// $data['make'] = shell_exec(TAC_ROOT_PATH . '/backup.sh make '. DB_USER . ' ' . DB_PASSWORD . ' '. DB_NAME. ' '. $backupPart .' '. $revision);//make
			$data['make'] = $makeBkp->setAttr($revision)->get();//make
		}

		$logEntry=array('action' => 'add', 'obj_name' => $backupPart, 'section' => 'api backup', 'message' => 601);
		$this->APILoggingCtrl->makeLogEntry($logEntry);
		return ['status'=> true, 'message'=> 'Backup added ', 'test' => $test02 ] ;
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
		$ORDER=$params['sortDirection'];
		$TYPE=$params['extra']['type'];
		$data['test222'] = $params['extra']['type'];

		//$backupCommand="mysqldump -u ".DB_USER." -p".DB_PASSWORD." ".DB_NAME." > /var/www/html/backups/database/".date('Y-m-d_H:i:s', time())."_all.sql";

		//$data['check'] =shell_exec("ls ".TAC_ROOT_PATH."/backups/database/ -r | sed '10,20!d' | paste -s -d ' ' "); //check

		// $data['result'] = trim(shell_exec(TAC_ROOT_PATH . '/backup.sh datatables '.  .' '..' '. .' '.)); //check
		$data['result'] = CMDRun::init()->setCmd(TAC_ROOT_PATH . '/backup.sh')->
				setAttr(['datatables',$ORDER,$TYPE]);
		$data['cmd2'] = $data['result']->showCmd();
		$data['result'] = $data['result']->get();
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
			$tempVariable = explode( '.', explode('_',$data['result4'][$i])[2] )[0];
			$tempArray['filename']=$data['result4'][$i];
			$tempArray['size']=$data['result4'][$i+1].'byte';
			$tempArray['version']=$tempVariable . ( ($tempVariable == $revision) ? ' Used Now' : '');
			$tempArray['used']= ( ($tempVariable == $revision) ? 1 : 0 );
			$tempArray['type']= $TYPE;
			// $tempArray['buttons']='<a class="btn btn-info btn-xs btn-flat" target="_blank" href="/api/backup/download/?file=\''.$data['result4'][$i].'\'"><i class="fa fa-download"></i></a> <button class="btn btn-warning btn-xs btn-flat" onclick="tgui_apiBackup.restore(\''.$data['result4'][$i].'\',\''.$TYPE.'\')">Restore</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_apiBackup.delete(\''.$data['result4'][$i].'\',\''.$TYPE.'\')">Del</button>';
			$tempArray['href']='/api/backup/download/?file=\''.$data['result4'][$i];
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

		// $data['result'] = trim(shell_exec(TAC_ROOT_PATH . '/backup.sh delete '. $req->getParam('name')));
		$data['result'] = CMDRun::init()->setCmd(TAC_ROOT_PATH . '/backup.sh')->
				setAttr(['delete',$req->getParam('name')])->get();

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'section' => 'api backup', 'message' => 602);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP DELETE ########END##
	#####################################################
	###################	GET BACKUP SETTINGS ########START##
	public function getBackupSettings($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'backup',
			'action' => 'settings',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['settings'] = APIBackup::select()->find(1);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	GET BACKUP SETTINGS ########END##
	#####################################################
	###################	POST BACKUP SETTINGS ########START##
	public function postBackupSettings($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'backup',
			'action' => 'settings',
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

		$allParams = $req->getParams();
		$update = [];
		if (@$allParams['target'] == 'tcfgSet' OR @$allParams['target']  == 'apicfgSet')
		$update[$allParams['target']] = $allParams['set'];
		$data['test'] = $update;
		$data['result'] = APIBackup::where('id',1)->update($update);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP SETTINGS ########END##
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
		$type = $req->getParam('type');
		$data['cmd'] = CMDRun::init()->setCmd(TAC_ROOT_PATH . '/backup.sh')->setAttr(['restore',DB_USER,DB_PASSWORD, DB_NAME, $req->getParam('name')])->showCmd();
		$data['result'] = CMDRun::init()->setCmd(TAC_ROOT_PATH . '/backup.sh')->setAttr(['restore',DB_USER,DB_PASSWORD, DB_NAME, $req->getParam('name')])->get();

		if ( !empty($type) AND $type != 'apicfg' ) $data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'restore', 'obj_name' => $req->getParam('name'), 'section' => 'api backup', 'message' => 603);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP RESTORE ########END##
	###################################################
	###################	GET BACKUP DOWNLOAD ########START##
	public function getBackupDownload($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'backup',
			'action' => 'download',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			echo '<h1>Error. Access Restricted</h1>';
			return $res -> withStatus(401) -> withHeader('Content-type', 'text/html');
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(9))
		{
			echo '<h1>Error. Access Restricted</h1>';
			return $res -> withStatus(403) -> withHeader('Content-type', 'text/html');
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$file = str_replace("'","", urldecode( $req->getParam('file') ) );
		if ( empty($file) ) {
			echo '<h1>Error. File Parameter Inavailable</h1>';
			return;
		}
		$path = '/opt/tgui_data/backups/database/';
		//$path = '/backups/database/';

		if ( !file_exists($path.$file) ) {
			echo '<h1>Error. File '.$path . $file .' Not Found</h1>';
			return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
		}
		$path = $path.$file;
		header("X-Sendfile: $path");
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="'.$file.'"');
		exit(0);

	}
	###################	GET BACKUP DOWNLOAD ########END##
	###################################################
	###################	POST BACKUP UPLOAD ########START##
	public function postBackupUpload($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'backup',
			'action' => 'upload',
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

		$uploaddir = '/opt/tgui_data/backups/database/';

		if (!file_exists($uploaddir)) {
		   mkdir($uploaddir, 0777, true);
		}

		$action = $req->getParam('action');
		if ($action == 'check') {
			if ( file_exists($uploaddir. $req->getParam('name')) ) {
				$data['error']['status']=true;
				$data['error']['message']='File with the same name exist';
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		foreach ($_FILES as $key => $value) {
			$fileName = $data['name'] = $_FILES[$key]['name'];
			$fileTempLoc = $data['path'] = $_FILES[$key]['tmp_name'];
		}

		if ( file_exists($uploaddir.$fileName) ) {
			$data['error']['status']=true;
			$data['error']['message']='File with the same name exist';
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$data['result'] = 'Error';
		foreach($_FILES as $index => $file)
    {
			$fileName = $data['name'] = $file['name'];
			$fileTempLoc = $data['path'] = $file['tmp_name'];
      if(move_uploaded_file($file['tmp_name'], $uploaddir . basename($file['name'])))
      {
          $data['result'] = 'File ' . $file['name'] . ' was uploaded';
      }
      else
      {
					$data['file'] = $_FILES;
          $data['error']['status'] = true;
          $data['error']['message'] = 'move_uploaded_file function broken';
      }
    }

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP UPLOAD ########END##
	###################################################
	###################	POST BACKUP MAKE ########START##
	public function postBackupMake($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'backup',
			'action' => 'make',
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

		$allParams = $req->getParams();

		if ( empty($allParams['type']) ){
			$data['error']['status']=true;
			$data['error']['message']='Type backup error';
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ( !isset($allParams['diff']) ){
			$allParams['diff'] = 1;
		}

		switch ($allParams['type']) {
			case 'apicfg':
					$data['result'] = $this->makeBackup(['make'=>'apicfg', 'diff' => $allParams['diff']]);
				break;
			case 'full':
					$data['result'] = $this->makeBackup(['make'=>'full', 'diff' => $allParams['diff']]);
				break;

			default:
				$data['error']['status']=true;
				$data['error']['message']='Type backup error';
				return $res -> withStatus(200) -> write(json_encode($data));
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST BACKUP MAKE ########END##
}
