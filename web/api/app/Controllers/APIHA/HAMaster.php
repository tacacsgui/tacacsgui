<?php
namespace tgui\Controllers\APIHA;

use tgui\Controllers\Controller;
use tgui\Controllers\APIUpdate\APIUpdateCtrl;

use GuzzleHttp\Client as gclient;
use GuzzleHttp\Exception\RequestException;

use tgui\PHPMailer\EmailEngine;
use tgui\Models\APISMTP;

use tgui\Services\CMDRun\CMDRun as CMDRun;

use Symfony\Component\Yaml\Yaml;

class HAMaster extends Controller
{
  public $slavesFile = '/opt/tgui_data/ha/ha-slaves.yaml';
  public static function status($psk){
    return CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'status', 'master', $psk ] )->get();
  }

  public function setup($params){
    $result = [ 'error' => true, 'messages' => [], 'msg' => ''];

    $result['messages'][] = 'Installation key: '.Controller::uuid_hash();

    if (!$this->HAGeneral->checkActivation([ Controller::uuid_hash() ])){
      $result['messages'][] = 'Error: Can\'t check activation';
      return $result;
    } else
      $result['messages'][] = 'Installation Activated';

    $status = $this->status($params['psk']);

    if ( !empty($status) ){
      $result['messages'][] = 'Already Master';
      $result['msg'] = 'Configuration saved';
      $result['error'] = false;
      $result['messages'][] = $status;

      $this->HAGeneral->saveCfg($params);
      return $result;
    }
    unlink($this->slavesFile);
    //APIUpdateCtrl::sendRequest($requestParams);
    //$output = ['error' => true, 'messages' => []];
    $result['messages'][] = 'Step 1. Check my.cnf';
    // $this->ha_data['server']['slave_id_list'] = '';
    // $result['messages'][] = 'Current Slave list was deleted.';
    try {
      $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'mycnf', $params['ip'] ] )->get();
      $error = false;
    } catch (\Exception $e) {
      $result['messages'][] = "### Warning ###:\n".$e->getMessage();
      $result['msg'] = 'Server Error!';
      return $result;
    }

    //Step 2

    //$rootpw = $params['rootpw'];
    $result['messages'][] = 'Step 2. Create replication user';
    //prepare replication user//
    $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'replication', $params['rootpw'], $params['psk'] ] )->get();
    $result['messages'][] = 'Done';

    $this->HAGeneral->saveCfg($params);
    $result['error'] = false;
    $result['msg'] = 'Configuration saved';

    return $result;
  }

  public static function makeDump(){
    $file = TAC_ROOT_PATH . '/temp/'.'tgui_dump.sql';
    if (file_exists($file))
      unlink( $file );
    return CMDRun::init()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'dump', DB_USER, DB_PASSWORD] )->get();
  }

  public static function getMysqlParams($psk)
	{
    //return explode( ' ', trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$this->ha_data['server']['psk_master']."'  brief 2>&1" ) ) );
    return explode( ' ', CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','status','master', $psk, 'brief'])->get() );
  }

  public function slaveRequest($ip = '', $action = 'check', $psk = '', $dbHash = '', $debug = false){
    if (empty($ip) or empty($psk))
      return false;
    $path = '/api/ha/check/';

    if ( $action == 'apply' )
      $path = '/api/ha/cfg/apply/';
    if ( $action == 'upgrade' )
      $path = '/api/ha/slave/update/do/';

    $request =
    [
      'url' => 'https://'.$ip.':4443'.$path,
      'guzzle_params'=>[
        'verify'=> false,
        'http_errors'=> false,
        'connect_timeout'=> 20,
        'form_params'=>
        [
          'dbHash'=> $dbHash,
          'api' => APIVER,
          'emails' => $this->HAGeneral->config['emails'],
          'action' => $action,
          'sha1' => sha1(APIVER.$action.$dbHash.$psk),
        ]
      ]
    ];

    // if ($debug)
      // return $request;

    try {
      $gclient = new gclient();
      $res = $gclient->request('POST', $request['url'], $request['guzzle_params']);
    } catch (RequestException $e) {
      return false;
    }
    // if ($debug)
    //   return '123123';
    if ( $res->getStatusCode() !== 200 )
      return false;
    return json_decode( $res->getBody()->getContents() );

    //return $res;
  }

  public function setSlave($params = [], $ip = ''){
    $slaves = $this->getSlaves();
    $ip = (empty($ip)) ? $_SERVER['REMOTE_ADDR'] : $ip;
    if (empty($ip))
      return false;
    $index = array_search($ip, array_column($slaves, 'ip'));

    if ($index !== false) {
      $slaves[$index]['date'] = date('Y-m-d H:i:s', time());
      if (isset($params['status'])) $slaves[$index]['status'] = $params['status'];
      // 99 - suucess, 90 - wrong status
      if (isset($params['cfg'])) $slaves[$index]['cfg'] = $params['cfg'];
      if (isset($params['db'])) $slaves[$index]['db'] = $params['db'];
      if (isset($params['api'])) $slaves[$index]['api'] =  $params['api'];
    } else {
      $slaves[] = [
        'ip'=> $_SERVER['REMOTE_ADDR'],
        'date' => date('Y-m-d H:i:s', time()),
        'cfg' => '',
        'status' => $params['status'],
        'db' => $params['db'],
        'id' => $this->makeSlaveId(),
        'api' => $params['api'],
      ];
    }
    $yaml = Yaml::dump($slaves);
    return file_put_contents($this->slavesFile, $yaml);
  }
  public function getSlaves(){
    if ( ! file_exists($this->slavesFile) ) return [];

    return Yaml::parseFile($this->slavesFile);
  }
  public function delSlave($ip = ''){
    $slaves = $this->getSlaves();
    if (empty($ip))
      return false;
    $index = array_search($ip, array_column($slaves, 'ip'));

    if ($index !== false) {
      unset($slaves[$index]);
      $slaves = array_values($slaves);
      $yaml = Yaml::dump($slaves);
      return file_put_contents($this->slavesFile, $yaml);
    }

    return false;
  }

  public function checkSlaveCfg($cfg = ''){
    $slaves = $this->getSlaves();
    for ($sl=0; $sl < count($slaves); $sl++) {
      if ( empty($slaves[$sl]['cfg']) )
        return false;
      if ( !empty($cfg) AND $slaves[$sl]['cfg'] != $cfg)
        return false;
    }

    return true;
  }

  public function makeSlaveId(){
    $sid = explode('.', $_SERVER['REMOTE_ADDR']);
    unset($sid[0]);
    return (int) implode('',$sid);
  }

  public function checkSlaves(){
    $slaves = $this->getSlaves();
    $config = $this->HAGeneral->getFullConfig();
    for ($sl=0; $sl < count($slaves); $sl++) {
      $this->debMsg('Check slave '.$slaves[$sl]['ip'], 'HA');
      $resp = $this->slaveRequest($slaves[$sl]['ip'], 'check', $this->HAGeneral->psk, $this->databaseHash()[0]);

      if (!$resp){
        $this->debMsg('Can\'t connect to slave', 'HA');
        //Send Message!
        if (count($config['emails'])){
          $variables = [
            'role' => 1,
            'message' => 'Can\'t reach a Slave ('.$slaves[$sl]['ip'].')! Please check connectivity between nodes.',
            'subject' => '!! Slave Server unreachable !!'
          ];
          $mail = new EmailEngine(APISMTP::select()->find(1));
          $mailStatus = $mail->addAddresses($config['emails'])->setTemplate('ha-error', $variables)->send(true);
      		$this->debMsg('Message send: '. $mailStatus, 'HA');
        }

        //Set new status!
        $this->setSlave(['status'=>90], $slaves[$sl]['ip']);

        continue;
      }
      $status = (!!$resp->status) ? 99 : 90;
      //Send Message if status not 99
      if ( $status != 99 AND count($config['emails']) ){

        $variables = [
          'role' => 1,
          'message' => 'Slave ('.$slaves[$sl]['ip'].') out of Sync! Please check connectivity between nodes.',
          'subject' => '!! Slave Server OUT OF SYNC !!'
        ];
        $mail = new EmailEngine(APISMTP::select()->find(1));
        $mailStatus = $mail->addAddresses($config['emails'])->setTemplate('ha-error', $variables)->send(true);
    		$this->debMsg('Message send: '. $mailStatus, 'HA');

      }
      //Set new status!
      $this->setSlave(['status'=>$status, 'api'=>$resp->api, 'db'=>$resp->db], $slaves[$sl]['ip']);
      if ($this->debug) var_dump($resp);
    }

    return false;
  }

}
