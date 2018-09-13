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

    if ( ! $this->checkSlaveAccess( $allParams ) ) return $res -> withStatus(403);// -> write('Access Restricted!');

    switch ($allParams['action']) {
      case 'sync-init':
        $data['dump'] = trim( shell_exec( TAC_ROOT_PATH . "/main.sh ha dump '". DB_USER ."' '". DB_PASSWORD."'") );
        $data['mysql'] = $ha->getMysqlParams();
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
      case 'final':
        $data['final'] = $ha->addNewSlave($allParams);
        $data['checksum'] = [];

        $tempArray = $this->db::select( 'CHECKSUM TABLE '. implode( ",", array_keys($this->tablesArr) ) );
        for ($i=0; $i < count($tempArray); $i++) {
          $data['checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
        }
        break;
      default:
        return $res -> withStatus(403);// -> write('Access Restricted!');
        break;
    }
    $data['access'] = true;

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
  protected function checkSlaveAccess( $allParams = [] )
  {
    $ha = new HA();
    if (! $ha->isMaster() OR ! $ha->checkAccessPolicy( $_SERVER['REMOTE_ADDR'] ) ) return false;
    if ( ! isset( $allParams['sha1_attrs'] ) OR ! is_array($allParams['sha1_attrs'])) return false;
    $sha1_hash = $allParams['time'];
    foreach ($allParams['sha1_attrs'] as $value) {
      if ( $value == 'psk' ) $allParams[$value] = $ha->psk();
      if ( ! isset($allParams[$value]) ) return false;
      $sha1_hash .= ( isset($allParams[$value]) ) ? '&'.$allParams[$value] : '';
    }

    return $allParams['sha1'] == sha1($sha1_hash);
  }
}
