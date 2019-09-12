<?php
namespace tgui\Controllers\APIHA;

use tgui\Services\CMDRun\CMDRun as CMDRun;
use Symfony\Component\Yaml\Yaml;

use tgui\Controllers\Controller;
use tgui\Controllers\APIUpdate\APIUpdateCtrl;

use tgui\Controllers\APIHA\HAMaster;
use tgui\Controllers\APIHA\HASlave;

class HAGeneral extends Controller
{
  private $mainDir = '/opt/tgui_data/ha';
  private $mainFile = '/opt/tgui_data/ha/ha-settings.yaml';
  public $config;
  public $psk;
  private $rootpw;

  public function isSlave(){
    $mainFile = '/opt/tgui_data/ha/ha-settings.yaml';
    if ( ! file_exists($mainFile) ) return false;
    $cfg = Yaml::parseFile($mainFile);
    return ($cfg['role'] == 2) ? $cfg['psk_s'] : false;
  }
  public function isMaster(){
    $mainFile = '/opt/tgui_data/ha/ha-settings.yaml';
    if ( ! file_exists($mainFile) ) return false;
    $cfg = Yaml::parseFile($mainFile);
    return $cfg['role'] == 1;
  }
  public function getRole(){
    $mainFile = '/opt/tgui_data/ha/ha-settings.yaml';
    if ( ! file_exists($mainFile) ) return 0;
    $cfg = Yaml::parseFile($mainFile);
    return $cfg['role'];
  }

  public function setCfg(){
    $this->getFullConfig();
    $this->config['cfg'] = $this->databaseHash()[0];
    return $this->saveCfg($this->config);
  }

  public function getFullConfig(){
    $this->config = [];
    if ( ! file_exists($this->mainFile) ) return [];
    $this->config = Yaml::parseFile($this->mainFile);
    if ($this->config['role'] == 1)
      $this->psk = $this->config['psk'];
    if ($this->config['role'] == 2)
      $this->psk = $this->config['psk_s'];
    return $this->config;
  }

  public function saveCfg( $cfg = [] ){
    if (!empty($cfg['rootpw'])) unset($cfg['rootpw']);
    $yaml = Yaml::dump($cfg);
    return file_put_contents($this->mainFile, $yaml);
    //return $this;
  }

  public function getStatus($role = 0){
    $output = [];
    $cfg = $this->getFullConfig();
    $psk = ($role == 1) ? $cfg['psk'] : $cfg['psk_s'];

    switch ($role) {
      case '1':
        $output[] = 'Master Status';
        $output[] = 'Master MySQL Settings:';
        $output[] = HAMaster::status($psk);
        $output[] = 'my.cnf:';
        $output[] = $this->getMyCnf();
        break;
      case '2':
        $output[] = 'Slave Status';
        $output[] = 'Slave MySQL Settings (Short):';
        $output[] = $this->HASlave->status($psk, 'short');//'Slave Status';
        $output[] = 'my.cnf:';
        $output[] = $this->getMyCnf();
        break;
      default:
        $output[] = 'High Availability disabled';
        break;
    }

    return $output;
  }

  public function getMyCnf(){
    return CMDRun::init()->setCmd('cat')->setAttr( [ '/etc/mysql/my.cnf' ] )->get();
  }

  public function getMaster(){
    $master = $this->getFullConfig();

    return ( empty($master['master']) ) ? [] : $master['master'];
  }

  public function getSlaves(){
    $slaves = $this->getFullConfig();

    return ( empty($slaves['slaves']) ) ? [] : $slaves['slaves'];
  }

  public function setRootpw($rootpw = ''){
    $this->rootpw = $rootpw;
    return $this;
  }

  public function getRootpw(){
    return CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw' ] )->get();
  }

  public function checkRoot($rootpw = ''){
    $rootpw_cfg = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw' ] )->get();
    if ( CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw', $rootpw_cfg ] )->get() == 1 ) return true;

    if ( ! empty($rootpw) ){
      if ( CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw', $rootpw ] )->get() == 1 ) return true;
        //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha rootpw '".$rootpw."' 2>&1" ) ) == 1) return true;
    }

    return false;
  }

  public function disable($rootpw = ''){
    $result = [ 'error' => false, 'messages' => [], 'msg' => ''];
    //$result['messages'][] = ( $this->saveCfg() ) ? 'File config erased' : 'File config NOT erased!' ;
    $result['messages'][] = 'File config erased' ;
    unlink($this->mainFile);
    $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','disable'])->get();
    $result['messages'][] = 'Done';
    $result['msg'] = 'HA Disabled';

    unlink($this->HAMaster->slavesFile);
    unlink($this->HASlave->masterFile);
    return $result;
  }

  public static function checkActivation($uuid = [])
  {
    $requestParams=[
      'url'=> 'https://tacacsgui.com/updates/',
      'guzzle_params'=>[
        'verify'=> false,
        'http_errors'=> false,
        'connect_timeout'=> 7,
        'form_params'=>
        [
          'key'=> $uuid,
          'version' => APIVER,
          'revision' => APIREVISION,
        ]
      ]
    ];

     $resp = APIUpdateCtrl::sendRequest($requestParams);
     if (!$resp OR $resp[1]!=200)
      return false;
     $resp[0] = json_decode($resp[0], true);
     // return $resp;
     return empty($resp[0]['error']);
  }

  public function authorization($params = [])
  {
    $config = $this->getFullConfig();
    if ( !in_array($config['role'], [1,2]) )
      return false;
    if ( $config['role'] == 1 AND count($config['slaves_ip']) AND !in_array($_SERVER['REMOTE_ADDR'], $config['slaves_ip']))
      return false;
    if ( $config['role'] == 2 ){
      $master = $this->HASlave->getMaster();
      if ( count($master) AND $master[0]['ip'] != $_SERVER['REMOTE_ADDR'])
        return false;
    }

    $psk = ($config['role'] == 1) ? $config['psk'] : $config['psk_s'];

    $sha1 = sha1($params['api'].$params['action'].$params['dbHash'].$psk);

    return ($sha1 === $params['sha1']) ? $config : null;
  }

  public function check(){
    $this->debMsg('Run HA Module', 'HA');
    $this->getFullConfig();
    if ( empty($this->config) )
    {
      $this->debMsg('Config not found. Exit', 'HA');
      return $this;
    }

    $this->debMsg('Current role is '.$this->config['role'], 'HA');
    if ($this->config['role'] == 1 AND count($this->HAMaster->getSlaves()))
      $this->HAMaster->checkSlaves();
    if ($this->config['role'] == 2 AND count($this->HASlave->getMaster()))
      $this->HASlave->checkMaster();
    $this->debMsg('Exit HA Module', 'HA');
    return $this;
  }

}
