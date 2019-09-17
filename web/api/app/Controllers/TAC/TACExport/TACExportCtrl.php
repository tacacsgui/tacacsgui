<?php
namespace tgui\Controllers\TAC\TACExport;

use tgui\Models\TACDevices;
use tgui\Models\TACDeviceGrps;

use tgui\Controllers\Controller;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class TACExportCtrl extends Controller
{
  public function getExport($req,$res)
  {
  	//INITIAL CODE////START//
  	$data=array();
  	$data=$this->initialData([
  		'type' => 'get',
  		'object' => 'export',
  		'action' => 'tacacs',
  	]);
  	#check error#
  	if ($_SESSION['error']['status']){
  		$data['error']=$_SESSION['error'];
  		return $res -> withStatus(401) -> write(json_encode($data));
  	}
  	//INITIAL CODE////END//
    shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');

    $model = false;
    $path = TAC_ROOT_PATH . '/temp/';
    $allParams = $req->getParams();
    $allParams['ids'] = isset($allParams['ids']) ? explode(',',$allParams['ids']) : [];
    $query = false;
    $columns = [];

    switch ( $allParams['target'] ) {
      case 'devices':
        list($columns, $query)= $this->getTacDevices($allParams);
        // $model = new TACDevices;
        $mainName = 'tac_devices';
        break;
    }

  	$filename = $mainName.'_'. $this->generateRandomString(8) .'.csv';
  	//$columns = $this->APICheckerCtrl->getTableTitles($mainName);
    $f = fopen($path.$filename, 'w');
    $array = [];
    $array = $query->get()->toArray();// : $query->whereIn('id', $allParams['ids'])->get()->toArray();

    fputcsv($f, $columns /*, ',)'*/);
    foreach ($array as $line) {
      fputcsv($f, $line /*, ',)'*/);
    }

    if ( !file_exists($path.$filename) ) {
			echo '<h1>Error. File '.$path . $file .' Not Found</h1>';
			return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
		}

    header("X-Sendfile: ".$path."".$filename);
    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    exit(0);

  }

  public function getTacDevices($params = []){
    $columns = $this->db::getSchemaBuilder()->getColumnListing('tac_devices');
    $query = TACDevices::select(['tac_devices.*', 'addr.address as address'])->
    leftJoin('obj_addresses as addr', 'addr.id','=','tac_devices.address');
    if ( count($params['ids']) ) $query->whereIn('tac_devices.id', $params['ids'])->get()->toArray();
    return [$columns, $query];
  }

}
