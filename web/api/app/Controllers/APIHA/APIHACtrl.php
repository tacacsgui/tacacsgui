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

    if ( ! $this->checkServerAccess( $allParams ) ) return $res -> withStatus(403);// -> write('Access Restricted!');

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
        $this->changeConfigurationFlag(['unset' => 0]);
        break;
      default:
        return $res -> withStatus(403);// -> write('Access Restricted!');
        break;
    }
    $data['access'] = true;

    return $res -> withStatus(200) -> write(json_encode($data));
  }
  ####HA Sync####End
  public function postHADoApplyConfig($req,$res)
  {
    //INITIAL CODE////START//
    $data=array(
      'remoteip' => $_SERVER['REMOTE_ADDR'],
      'serverip' => $_SERVER['SERVER_ADDR'],
      'time' => time(),
      'access' => false);
    $ha = new HA();
    $allParams = $req->getParams();
    if ( ! $this->checkServerAccess( $allParams, 'slave' ) ) return $res -> withStatus(403);
    $data['access'] = true;
    $data['checksum'] = [];
    $tempArray = $this->db::select( 'CHECKSUM TABLE '. implode( ",", array_keys($this->tablesArr) ) );
    for ($i=0; $i < count($tempArray); $i++) {
      $data['checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
    }
    $data['applyStatus'] = ['error' => true];
    $data['testStatus'] = ['error' => true];
    $data['version_check'] = (APIVER == $allParams['api_version']);
    if (! $data['version_check'] ) return $res -> withStatus(200) -> write(json_encode($data));
    $data['testStatus'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration());
    if ( ! $data['testStatus']['error'] ) $data['applyStatus'] = $this->TACConfigCtrl->applyConfiguration($this->TACConfigCtrl->createConfiguration());
    return $res -> withStatus(200) -> write(json_encode($data));
  }

  ####HA Keepalive####
  public function postLoggingEvent($req,$res)
  {
    $data=array(
      'remoteip' => $_SERVER['REMOTE_ADDR'],
      'serverip' => $_SERVER['SERVER_ADDR'],
      'time' => time(),
      'access' => false);
    $ha = new HA();
    $allParams = $req->getParams();

    //if ( ! $this->checkServerAccess( $allParams ) ) return $res -> withStatus(403);
    //$event = '2018-09-18 11:39:40 +0300|!|10.10.50.251|!|cisco123|!|tty1|!|10.10.50.200|!|stop|!|task_id=124|!|timezone=UTC|!|service=shell|!|priv-lvl=15|!|cmd=configure terminal <cr>';
    shell_exec('php '.TAC_ROOT_PATH."/parser/parser.php ".$allParams['log_type']." '".$allParams['log_entry']."' '".$_SERVER['REMOTE_ADDR']."'");

    $data['access'] = true;

    return $res -> withStatus(200) -> write(json_encode($data));
  }
  // public function postHAKeepalive($req,$res)
  // {
  //   //INITIAL CODE////START//
  //   $data=array(
  //     'remoteip' => $_SERVER['REMOTE_ADDR'],
  //     'serverip' => $_SERVER['SERVER_ADDR'],
  //     'time' => time(),
  //     'access' => false);
  //   $ha = new HA();
  // }
  ####HA Keepalive####End
  protected function checkServerAccess( $allParams = [], $role = 'master' )
  {
    $ha = new HA();
    $accessPolicy = ( $role == 'master') ? $ha->checkAccessPolicy( $_SERVER['REMOTE_ADDR'] ) : $ha->checkAccessPolicy( $_SERVER['REMOTE_ADDR'], 'slave' );
    $roleCheck = ( $role == 'master') ? $ha->isMaster() : HA::isSlave();

    if (! $roleCheck OR ! $accessPolicy ) return false;
    if ( ! isset( $allParams['sha1_attrs'] ) OR ! is_array($allParams['sha1_attrs'])) return false;
    $sha1_hash = $allParams['time'];
    foreach ($allParams['sha1_attrs'] as $value) {
      if ( $value == 'psk' ) $allParams[$value] = $ha->psk($role);
      if ( ! isset($allParams[$value]) ) return false;
      $sha1_hash .= ( isset($allParams[$value]) ) ? '&'.$allParams[$value] : '';
    }

    return $allParams['sha1'] == sha1($sha1_hash);
  }
}
