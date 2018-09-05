<?php
namespace tgui\Controllers\APIHA;

use tgui\Controllers\Controller;
use tgui\Controllers\APISettings\HA;

class APIHACtrl extends Controller
{
  ####HA Sync####
  public function postHASync($req,$res)
  {
    //INITIAL CODE////START//
    $data=array(
      'remoteip' => $_SERVER['REMOTE_ADDR'],
      'serverip' => $_SERVER['SERVER_ADDR'],
      'time' => time(),
      'access' => false);
    $ha = new HA();
    $allParams = $req->getParams();
    if (! $ha->isMaster() OR ! $ha->checkAccess( $_SERVER['REMOTE_ADDR'] ) ) return $res -> withStatus(403) -> write('Access Restricted!');

    $sha1 = sha1( $allParams['time'] . '&'. $allParams['masterip']. '&' . $ha->psk() . '&'. $allParams['action'] );
    //$data['sha1'] = $sha1;
    if ( $sha1 !== $allParams['sha1']) return $res -> withStatus(403) -> write('Access Restricted!'.$sha1);
    switch ($allParams['action']) {
      case 'sync-init':
        $data['mysql'] = $ha->getMysqlParams();
        $data['dump'] = trim( shell_exec('sudo '.TAC_ROOT_PATH.'/main.sh ha dump '. DB_USER . ' ' . DB_PASSWORD) );
        break;
      case 'dump':
        $path = TAC_ROOT_PATH . '/temp/';
        $file = 'tgui_dump.sql';

        if ( !file_exists($path.$file) ) {
          echo '<h1>Error. File '.$path . $file .' Not Found</h1>';
          return $res -> withStatus(404) -> withHeader('Content-type', 'text/html');
        }
        $path = $path.$file;
        header("X-Sendfile: $path");
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="'.$file.'"');
        exit(0);
        break;
      default:
        return $res -> withStatus(403) -> write('Access Restricted!');
        break;
    }
    //$data['params'] = $allParams;
    //$data['sha1'] = $sha1;
    $data['access'] = true;
    //$data['psk'] = $ha->psk();

    return $res -> withStatus(200) -> write(json_encode($data));
  }
  ####HA Sync####End
  ####HA Keepalive####
  public function postHAKeepalive($req,$res)
  {
    //INITIAL CODE////START//
    $data=array(
      'remoteip' => $_SERVER['REMOTE_ADDR'],
      'serverip' => $_SERVER['SERVER_ADDR'],
      'time' => time(),
      'access' => false);
    $ha = new HA();
  }
  ####HA Keepalive####End
}
