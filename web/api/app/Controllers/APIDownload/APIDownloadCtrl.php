<?php
namespace tgui\Controllers\APIDownload;

use tgui\Controllers\Controller;

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
		$path = '/opt/tacacsgui/temp/';
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
}
