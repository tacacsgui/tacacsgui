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

class HASlave extends Controller
{
  public $masterFile = '/opt/tgui_data/ha/ha-master.yaml';

  public function status($psk, $type = 'full'){
    $output =  CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'status', 'slave', $psk ] )->get();
    if ($type == 'short'){
      $matches = [];
      preg_match_all('/(Slave_IO_State:.*|Master_Host:.*)/', $output, $matches);
      return (empty($matches[0])) ? 'Server Error!' : implode("\n",$matches[0]);
    }
    if ($type == 'brief'){
      return preg_match('/(.*Waiting for master.*)/', $output);
    }

    return $output;
  }

  public function setup($params = []){
    $result = ['error' => true, 'messages' => [], 'msg' => ''];

    $result['messages'][] = 'Check Master Access';
    list($dbHash,$dbHashList) = $this->databaseHash();
    /*
      Step one INIT
    */

    $resp = self::masterRequest($params['ip_m'], 'init', $params['psk_s'], $dbHash);
    if (!$resp){
      $result['messages'][] = 'Can\'t access master. Please check ip and pre-shared key';
      return $result;
    }
    if ($resp->error){
      $result['messages'] = array_merge ($result['messages'],  $resp->messages) ;
      $result['msg'] = 'Master Error';
      return $result;
    }
    if (empty($resp->mysql)){
      $result['messages'][] = 'Didn\'t find mysql settings from Master' ;
      $result['msg'] = 'Master Error';
      return $result;
    }
    $this->setMaster(['ip' => $params['ip_m'], 'status' => 0, 'api' => $resp->api, 'db' => $resp->db]);
    $mysqlMaster = $resp->mysql;
    $sid = 1000;
    if (empty($resp->sid)){
      $result['messages'][] = 'Didn\'t find Slave ID from Master' ;
      $result['msg'] = 'Master Error';
      return $result;
    }
    $sid = (int) $resp->sid;
    $result['messages'][] = 'Slave ID: '.$sid ;
    $result['messages'][] = 'Master MySQL Settings: ' ;
    $result['messages'][] = implode(', ', $mysqlMaster) ;
    /*
      Step two DUMP
    */
    $this->setMaster(['ip' => $params['ip_m'], 'status' => 1]);
    $resp = self::masterRequest($params['ip_m'], 'dump', $params['psk_s'], $dbHash, true);
    if (!$resp){
      //$result['messages'][] = $resp;
      $result['messages'][] = 'Can\'t access master on Step 2';
      return $result;
    }
    $dumpFile = '/opt/tacacsgui/temp/dumpForSlave.sql';
    unlink($dumpFile);
    file_put_contents($dumpFile, $resp, LOCK_EX);
    if (!file_exists ( $dumpFile ) OR !filesize($dumpFile)){
      //$result['messages'][] = $resp;
      $result['messages'][] = 'Something wrong with dump file!'.filesize($dumpFile);
      return $result;
    } else
      $result['messages'][] = 'Dump from Master uploaded';

    $result['messages'][] = 'Deploy: '. CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','dump-deploy', DB_PASSWORD])->get();
    /*
      Step three ENABLE REPLECATION
    */
    $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','mycnf', 'slave', $sid ])->get();
    $result['messages'][] = "Create user tgui_ro";
    $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','tgui_ro', $params['rootpw'], $params['psk_s'] ])->get();
    $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','replication', $params['rootpw'], $params['psk_s'] ])->get();
    $result['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha', 'slave', 'start',
      $params['rootpw'],
      $params['ip_m'],
      $params['psk_s'],
      $mysqlMaster[0],
      $mysqlMaster[1] ])->get();

    /*
      Step four Final Check!
    */
    $this->setMaster(['ip' => $params['ip_m'], 'status' => 2]);

    list($dbHash,$pdbHashList) = $this->databaseHash();
    $resp = self::masterRequest($params['ip_m'], 'final', $params['psk_s'], $dbHash);
    if (!$resp){
      $result['messages'][] = 'Can\'t access master. Final Step!';
      $this->HAGeneral->saveCfg($params);
      return $result;
    }
    if ($resp->error){
      $result['messages'] = array_merge ($result['messages'],  $resp->messages) ;
      $result['msg'] = 'Master Error';
      $this->HAGeneral->saveCfg($params);
      return $result;
    }
    $dbSync = ($dbHash == $resp->db);
    $result['messages'][] = 'Database SYNC: ' . $dbSync;

    $result['messages'][] = 'Short Status: ' . $this->status($params['psk_s'], 'short');
    $result['messages'][] = 'Done: ' . ( $this->status($params['psk_s'], 'brief') );
    $result['messages'][] = 'Email list: ' . ( implode(', ', $resp->emails) );

    $this->setMaster(['ip' => $params['ip_m'], 'status' => 99, 'db' => $resp->db, 'emails' => $resp->emails]);

    $this->HAGeneral->saveCfg($params);
    $result['error'] = false;
    $result['msg'] = 'Configuration saved';
    unlink($dumpFile);


    return $result;
  }

  public function masterRequest($ip = '', $action = 'check', $psk = '', $dbHash = '', $debug = false){
    if (empty($ip) or empty($psk))
      return false;
    $path = '/api/ha/check/';

    if ( in_array($action, ['init', 'dump', 'final']))
      $path = '/api/ha/init/';

    $request =
    [
      'url' => 'https://'.$ip.':4443'.$path,
      'guzzle_params'=>[
				'verify'=> false,
				'http_errors'=> false,
				'connect_timeout'=> 7,
				'form_params'=>
				[
					'dbHash'=> $dbHash,
					'api' => APIVER,
					'action' => $action,
          'key'=> Controller::uuid_hash(),
					'sha1' => sha1(APIVER.$action.$dbHash.$psk),
				]
			]
    ];

    // if ($debug)
    //   return $request;

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
    return ($action != 'dump') ? json_decode( $res->getBody()->getContents() ) : $res->getBody()->getContents();

    //return $res;
  }

  public function setMaster($params = []){
    $master = $this->getMaster();

    if (count($master)){
      if (isset($params['ip'])) $master[0]['ip'] = $params['ip'];
      if (isset($params['api'])) $master[0]['api'] = $params['api'];
      if (isset($params['status'])) $master[0]['status'] = $params['status'];
      //status// 0 - init, 1 - dump, 2 - final, 99 - success
      $master[0]['date'] = date('Y-m-d H:i:s', time());
      if (isset($params['cfg'])) $master[0]['cfg'] = $params['cfg'];
      if (isset($params['emails'])) $master[0]['emails'] = $params['emails'];
      if (isset($params['db'])) $master[0]['db'] = $params['db'];
    } else {
      $master[] = [
        'ip' => (empty($params['ip'])) ? '' : $params['ip'],
        'api' => (empty($params['api'])) ? '' : $params['api'],
        'status' => (empty($params['status'])) ? 0 : $params['status'],
        'date' => date('Y-m-d H:i:s', time()),
        'cfg' => (empty($params['cfg'])) ? '' : $params['cfg'],
        'emails' => (empty($params['emails'])) ? [] : $params['emails'],
        'db' => (empty($params['db'])) ? '' : $params['db'],
      ];
    }

    $yaml = Yaml::dump($master);
    return file_put_contents($this->masterFile, $yaml);
  }

  public function getMaster(){
    if ( ! file_exists($this->masterFile) ) return [];

    return Yaml::parseFile($this->masterFile);
  }

  public function checkMaster(){
    $master = $this->getMaster()[0];
    $this->debMsg('Start check master', 'HA');
    if( ( time() - strtotime($master['date']) < 600) ) {
      $this->debMsg('Master fresh check found. Exit', 'HA');
      return false;
    }
    $config = $this->HAGeneral->getFullConfig();
    $resp = $this->masterRequest($master['ip'], 'check', $this->HAGeneral->psk, $this->databaseHash()[0]);
    if (!$resp AND count($master['emails'])) {
      $variables = [
        'role' => 2,
        'message' => 'Can\'t reach a Master ('.$master['ip'].')! Please check connectivity between nodes.',
        'subject' => '!! Master Server UNREACHABLE !!'
      ];
      $mail = new EmailEngine(APISMTP::select()->find(1));
      $mailStatus = $mail->addAddresses($master['emails'])->setTemplate('ha-error', $variables)->send(true);
      $this->debMsg('Message send: '. $mailStatus, 'HA');
    }
    //var_dump($resp);
  }

  public static function sendLogEvent($params = []){

    if ( ! file_exists('/opt/tgui_data/ha/ha-settings.yaml') OR ! file_exists('/opt/tgui_data/ha/ha-master.yaml') ) return false;
    $config = Yaml::parseFile('/opt/tgui_data/ha/ha-settings.yaml');
    $master = Yaml::parseFile('/opt/tgui_data/ha/ha-master.yaml')[0];

    $request =
    [
      'url' => 'https://'.$master['ip'].':4443/api/ha/log/add/',
      'guzzle_params'=>[
        'verify'=> false,
        'http_errors'=> false,
        'connect_timeout'=> 15,
        'form_params'=>
        [
          'dbHash'=> '',
          'api' => APIVER,
          'action' => $params['log_type'],
          'entry' => $params['log_entry'],
          'key'=> Controller::uuid_hash(),
          'sha1' => sha1(APIVER.$params['log_type'].$config['psk_s']),
        ]
      ]
    ];

    //return $request;

    try {
      $gclient = new gclient();
      $resp = $gclient->request('POST', $request['url'], $request['guzzle_params']);
    } catch (RequestException $e) {
      return false;
    }

    // return $resp->getBody()->getContents();

    if ( $resp->getStatusCode() !== 200 )
      return false;

    return true;

  }
}
