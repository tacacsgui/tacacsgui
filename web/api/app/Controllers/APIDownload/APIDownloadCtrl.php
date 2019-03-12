<?php
namespace tgui\Controllers\APIDownload;

use tgui\Controllers\Controller;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class APIDownloadCtrl extends Controller
{
  public function getDownloadCsv($req,$res)
  {
  	//INITIAL CODE////START//
  	$data=array();
  	$data=$this->initialData([
  		'type' => 'get',
  		'object' => 'download',
  		'action' => 'csv',
  	]);
  	#check error#
  	if ($_SESSION['error']['status']){
  		$data['error']=$_SESSION['error'];
  		return $res -> withStatus(401) -> write(json_encode($data));
  	}
  	//INITIAL CODE////END//
    $data['clear'] = shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');

    $file = str_replace("'","", urldecode( $req->getParam('file') ) );
		if ( empty($file) ) {
			echo '<h1>Error. File Parameter Inavailable</h1>';
			return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
		}
		$path = TAC_ROOT_PATH . '/temp/';
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

  public function getDownloadLog($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'get',
      'object' => 'download',
      'action' => 'csv',
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

    $file = str_replace("'","", urldecode( $req->getParam('file') ) );
    $filename = (!empty( $req->getParam('filename') )) ? str_replace("'","", urldecode( $req->getParam('filename') ) ) : '';
    if ( empty($file) ) {
      echo '<h1>Error. File Parameter Inavailable</h1>';
      return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
    }
    $path = '/var/log/tacacsgui';
    //$path = '/backups/database/';

    if ( !file_exists($path.$file) ) {
      echo '<h1>Error. File '.$path . $file .' Not Found</h1>';
      return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
    }
    $path = $path.$file;
    header("X-Sendfile: $path");
    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename="'. ( (empty($filename)) ? $file : $filename) .'"');
    exit(0);
  }

  public function getDlCm($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'get',
      'object' => 'download',
      'action' => 'configuration',
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

    $file = $filename = $req->getParam('name');
    $folder = $req->getParam('group');
    if ( $folder ) $file = $folder.'/'.$file;
    if ( empty($file) ) {
      echo '<h1>Error. File Parameter Inavailable</h1>'.$req->getParam('name').$req->getParam('group');
      return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
    }
    $path = '/opt/tgui_data/confManager/configs/';
    //$path = '/backups/database/';

    if ( !file_exists($path.$file) ) {
      echo '<h1>Error. File '.$path . $file .' Not Found</h1>';
      return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
    }
    $path = $path.$file;
    header("X-Sendfile: $path");
    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename="'. ( (empty($filename)) ? $file : $filename) .'"');
    exit(0);
  }

  public function getCmHash($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'get',
      'object' => 'download',
      'action' => 'configuration',
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

    $file = $req->getParam('show');
    $filename = $req->getParam('name');
    $hash = $req->getParam('hash');

    if ( empty($file) OR  empty($filename) OR empty($hash)) {
      echo '<h1>Error. File Parameter Inavailable</h1>'.$req->getParam('name').$req->getParam('show').$req->getParam('hash');
      return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
    }
    $path = '/opt/tacacsgui/temp/';
    //$path = '/backups/database/';
    $filename = CMDRun::init()->setCmd(MAINSCRIPT)->
      setAttr(
        [
        'run',
        'cmd',
        '/opt/tacacsgui/plugins/ConfigManager/cm_git.sh',
        '--set-filename='.$filename,
        '--show-redirect='.$hash.':'.$file
        ])->
      get();
    if ( !$filename AND !file_exists($path.$filename) ) {
      echo '<h1>Error. File '.$path . $filename .' Not Found</h1>';
      return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
    }
    $path = $path.$filename;
    header("X-Sendfile: $path");
    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename="'. $filename .'"');
    exit(0);
  }
}
