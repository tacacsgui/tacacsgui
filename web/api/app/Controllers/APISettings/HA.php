<?php

namespace tgui\Controllers\APISettings;

use Symfony\Component\Yaml\Yaml;

use tgui\Services\CMDRun\CMDRun as CMDRun;
use GuzzleHttp\Client as gclient;
use GuzzleHttp\Exception\RequestException;
use tgui\Controllers\APIChecker\APIDatabase;
use tgui\Controllers\APISettings\APISettingsCtrl;
use tgui\Controllers\Controller;


class HA
{
  private $ha_data;
  private $initial_data = [
    'server' => [
      'role' => '',
      'ipaddr' => '',
      'ipaddr_master' => '',
      'ipaddr_slave' => '',
      'interface' => '',
      'psk_slave' => '',
      'psk_master'  => ''
    ],
    'server_list' => [],
    'revision' => 0
  ];
  private $initial_schema = [
    'server' => [
      'role','ipaddr','ipaddr_master','interface','psk_slave','psk_master'
    ],
    'server_list' => []
  ];
  private $decoder;
  private $encoder;
  private $tablesArr;
  private $capsule;

  public function __construct( $params = ['capsule' => true ] )
  {

    // $this->encoder = new jsone();
    // $this->decoder = new jsond();

    if ($params['capsule']){
      $this->capsule = self::_capsule();
    }
    $apiChecker = new APIDatabase;
    $this->tablesArr = $apiChecker->tablesArr;

    if ( ! file_exists('/opt/tgui_data/ha/ha.yaml') ){
      self::saveConfg([]);
    }
    // $this->decoder->setObjectDecoding(1);
    //
    // $this->ha_data = $this->decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );
    $this->ha_data = self::getFullConfiguration();

  }

  private static function _capsule()
  {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection([
        'driver' => 'mysql',
        'host'	=> DB_HOST,
        'database' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASSWORD,
        'charset' => DB_CHARSET,
        'collation' => DB_COLLATE,
        'prefix' => ''
      ]);
    $capsule->setAsGlobal();
    $capsule->schema();
    $capsule->bootEloquent();

    return $capsule;
  }

  public function psk( $role = 'master')
  {
    return $this->ha_data['server']['psk_'.$role];
  }
  public function getServerList()
	{
    return $this->ha_data['server_list'];
  }
  public function sendConfigurationApply($params = [])
	{
    isset($params['checksum']) || $params['checksum'] = [];
    isset($params['sid']) || $params['sid'] = 0;
    $output=[];
    if ( !count($this->ha_data['server_list']['slave']) OR !isset( $this->ha_data['server_list']['slave'][$params['sid']] ) ) return $output;
    $slave = $this->ha_data['server_list']['slave'][$params['sid']];
      $session_params =
      [
        'server_ip' => $slave['ipaddr'],
        'path' => '/api/ha/do/apply/',
        'guzzle_params' => [],
    	  'form_params' =>
          [
            'psk' => $this->ha_data['server']['psk_master'],
            'action' => 'apply',
            'checksum' => $params['checksum'],
            'api_version' => APIVER,
            'unique_id' => $slave['unique_id'],
            'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
          ]
      ];
      $response = self::sendRequest($session_params);

      if ($response[1] != 200 ) {
        $output = ['ip'=> $slave['ipaddr'], 'uid' => $slave['unique_id'], 'response' => false ];
        return $output;
        //continue;
      }
      //$output['responce'] = true;
      //self::slaveTimeUpdate($slave['ipaddr']);
      $response[0] = $output['responce'] = json_decode($response[0], true );
      // $response[0]['db_check'] = ($params['checksum'] == $response[0]['checksum']);
      // if ($response[0]['db_check'] AND $response[0]['version_check'] AND !$response[0]['applyStatus']['error'] AND self::unconfiguredSlaves($slave['ipaddr'])) self::slaveConfigured($slave['ipaddr'], $this->ha_data['server']['config_uid']);
      //
      // $output = ['ip'=> $slave['ipaddr'], 'uid' => $slave['unique_id'], 'response' => $response , 'configured' => self::unconfiguredSlaves($slave['ipaddr'])];

    return $output;
  }
  public function getMysqlParams()
	{
    //return explode( ' ', trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$this->ha_data['server']['psk_master']."'  brief 2>&1" ) ) );
    return explode( ' ', CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','status','master', $this->ha_data['server']['psk_master'], 'brief'])->get() );
  }
  public function getFullData()
	{
    return $this->ha_data;
  }
  public function addNewSlave($params=[])
	{
    $slave = ['ipaddr' => $_SERVER['REMOTE_ADDR'], 'location' => 'remote', 'status' => 'Available', 'lastchk' => trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") )];

    $slave['api_version'] = isset($params['api_version']) ? $params['api_version'] : '0';
    $slave['unique_id'] = isset($params['unique_id']) ? $params['unique_id'] : '0';
    $slave['slave_id'] = isset($params['slave_id']) ? $params['slave_id'] : '0';

    foreach ($this->ha_data['server_list']['slave'] as $sid => $slave_params) {
      if( $slave_params['ipaddr'] == $_SERVER['REMOTE_ADDR'] ){
        unset( $this->ha_data['server_list']['slave'][$sid] );
      }
    }

    $this->ha_data['server_list']['slave'][$slave['slave_id']] = $slave;
    // $this->encoder->setPrettyPrinting(true);
    // $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
    self::saveConfg($this->ha_data);
    return true;
  }
  public function checkAccessPolicy($ip = '', $role = 'master')
	{
    if ( $role == 'master'){
      $testArray = explode( ',', $this->ha_data['server']['slaves_ip'] );
      return in_array($ip, $testArray);
    }
    if ( isset($this->ha_data['server_list']) AND  isset($this->ha_data['server_list']['slave']) AND count($this->ha_data['server_list']['slave']) )
    foreach ($this->ha_data['server_list']['slave'] as $value) {
      if ($value['ipaddr'] == $ip) return true;
    }
    return true;
  }

  public function save($params)
	{
    $output = [
      'status' => 'error',
      'type' => '',
      'message' => '',
      'rootpw' => false
    ];

    foreach ($params as $key => $value) {
      if ( in_array($key, array('rootpw','bin_file','position','step') ) ) continue;
      $this->ha_data['server'][$key]=$value;
    }

    switch ($this->ha_data['server']['role']) {
      case 'master':
        $output = $this->master_settings( $output, $params );
        $output['role'] = $this->ha_data['server']['role'];
        $this->ha_data['server']['config_uid'] = Controller::generateRandomString(24);

        $this->ha_data['server_list'] = [
          'master' => [
            'ipaddr' => $this->ha_data['server']['ipaddr'],
            'location' => 'localhost',
            'status' => 'Available',
            'lastchk' => Controller::serverTime()
          ],
          'slave' => []
        ];

        self::saveConfg($this->ha_data );

        break;
      case 'slave':
        $output['role'] = $this->ha_data['server']['role'];
        //if ($params['step'] < 5 ) $this->ha_data['server']['role'] = '';
        $output = $this->slave_settings( $output, $params );

        self::saveConfg($this->ha_data );

        if ($params['step'] >= 5 AND !$params['debug']) {
          session_unset(); session_destroy();
        }
        break;
      case 'disabled':
        $output['log'] = [ 'messages' => [], 'error' => false, 'disableOnError' => true ];
        $this->ha_data = [];
        self::saveConfg ( [] );
        $output['log']['messages'][] = "Erase configuration...Done";
        $output['ha_status_disabled'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','disable'])->get();
        $output['log']['messages'][] = "Erase my.cnf...Done";
        //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha disable 2>&1 ") );
        $output['status'] = '';
        $output['log']['messages'][] = "High Availability was disabled.";
        $output['stop'] = true;
        break;
      default:
        $output['message'] = 'Internal Error';
        break;
    }

    return $output;
  }

  private function master_settings( $output = [], $params )
  {
    $output['log'] = [ 'messages' => [], 'error' => false, 'disableOnError' => true ];
    $rootpw = $params['rootpw'];
    //$output['test'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw', '123123' ] )->showCmd();
    if ( ! $this->check_rootpw($rootpw) ){
      $output['type'] = 'rootpw';
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Warning ###:\n MySQL root password required.";
      return $output;
    }

    if ( empty($params['rootpw']) ) $params['rootpw'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','rootpw'])->get();
    //trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw' ) );
    $output['rootpw'] = true;

    switch ($params['step']) {
      case 1:
        $output = $this->setupMasterStep1($output, $params); //prepare my.cnf//
        return $output;
      case 2:
        $output = $this->setupMasterStep2($output, $params);
        return $output;
    }
    $output['current_mysql'] = $this->getMysqlParams();
    //$output['test11'] = $this->ha_data;
    $output['log']['messages'][] = 'Master Status:';
    $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','status', 'master', $this->ha_data['server']['psk_master'] ])->get();
    //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$this->ha_data['server']['psk_master']."' 2>&1 ") );

    $output['status'] = '';
    $output['stop'] = true;
    return $output;
  }
  public function setupMasterStep1( $output, $params )
  {
    //prepare my.cnf//
    $output['log']['messages'][] = 'Step 1. Check my.cnf';
    $this->ha_data['server']['slave_id_list'] = '';
    $output['log']['messages'][] = 'Current Slave list was deleted.';
    try {
      $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'mycnf', $this->ha_data['server']['ipaddr'] ] )->get();
    } catch (\Exception $e) {
      $output['my.cnf'] = '' ;
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Warning ###:\n".$e->getMessage();
    }
    $output['log']['messages'][] = 'Done';
    //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha mycnf '".$this->ha_data['server']['ipaddr']."' 2>&1" ) );
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupMasterStep2( $output, $params )
  {
    $rootpw = $params['rootpw'];
    $output['log']['messages'][] = 'Step 2. Create replication user';
    //prepare replication user//
    $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'replication', $rootpw, $this->ha_data['server']['psk_master'] ] )->get();
    $output['log']['messages'][] = 'Done';
    //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha replication '".$rootpw."' '" .$this->ha_data['server']['psk_master']."' 2>&1" ) );
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  private function slave_settings( $output = [], $params = [] )
  {
    $output['log'] = [ 'messages' => [], 'error' => false, 'disableOnError' => true ];
    if ( ! Controller::activated() ){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Warning ###:\nUnregistered system. Register system to enable that feature.";
      return $output;
    }

    $rootpw = $params['rootpw'];
    //$output['test'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw', '123123' ] )->showCmd();
    if ( ! $this->check_rootpw($rootpw) ){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Warning ###:\n MySQL root password required.";
      return $output;
    }
    if ( empty($params['rootpw']) ) $params['rootpw'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','rootpw'])->get();
    //trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw' ) );
    $output['rootpw'] = true;

    switch ($params['step']) {
      case 1:
        $output = $this->setupSlaveStep1($output, $params); //check
        return $output;
      case 2:
        $output = $this->setupSlaveStep2($output, $params);
        return $output;
      case 3:
        $output = $this->setupSlaveStep3($output, $params);
        return $output;
      case 4:
        $output = $this->setupSlaveStep4($output, $params);
        $this->ha_data['server']['role'] = 'slave';
        return $output;
    }
    /*
    //slave
    */
    $output['titles_checksum'] = implode(",",array_keys($this->tablesArr));
    $output['ha_checksum'] = [];
    $tempArray = $this->capsule::select( 'CHECKSUM TABLE '. implode(",",array_keys($this->tablesArr) ) );
    for ($i=0; $i < count($tempArray); $i++) {
      $output['ha_checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
    }


    $output['ha_status'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'status', 'slave', $this->ha_data['server']['psk_slave'] ] )->get();
    //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status slave '".$this->ha_data['server']['psk_slave']."' 2>&1" ) );

    $output['status'] = '';
    $output['stop'] = true;
    return $output;
  }

  public static function sendRequest($params = [])
  {
    $current_time = time();

    isset($params['server_ip']) || $params['server_ip'] = '10.6.20.10';
    isset($params['path']) || $params['path'] = '/api/ha/sync/';
    isset($params['port']) || $params['port'] = '4443';
    isset($params['https']) || $params['https'] = true;

    isset($params['guzzle_params']) || $params['guzzle_params'] = [];

    isset($params['guzzle_params']['verify']) || $params['guzzle_params']['verify'] = false;
    isset($params['guzzle_params']['http_errors']) || $params['guzzle_params']['http_errors'] = false;
    isset($params['guzzle_params']['connect_timeout']) || $params['guzzle_params']['connect_timeout'] = 7;

    isset($params['form_params']) || $params['form_params'] = [];
    isset($params['form_params']['time']) || $params['form_params']['time'] = $current_time;
    isset($params['form_params']['action']) || $params['form_params']['action'] = 'default';
    isset($params['form_params']['psk']) || $params['form_params']['psk'] = 'default';
    isset($params['form_params']['sha1_attrs']) || $params['form_params']['sha1_attrs'] = ['action'];

    $sha1_hash = $current_time;
    foreach ($params['form_params']['sha1_attrs'] as $value) {
      $sha1_hash .= ( isset($params['form_params'][$value]) ) ? '&'.$params['form_params'][$value] : '';
    }
    $params['form_params']['sha1'] = sha1($sha1_hash);
    unset($params['form_params']['psk']);
    $params['guzzle_params']['form_params'] = $params['form_params'];

    try {
      $gclient = new gclient();
      $res = $gclient->request('POST', 'https://'.$params['server_ip'].':'.$params['port'].$params['path'], $params['guzzle_params']);
    } catch (RequestException $e) {
      return false;
    }
    return [ $res->getBody()->getContents(), $res->getStatusCode() ];
    //return [ $params['guzzle_params'], $res->getStatusCode() ];
  }

  public function setupSlaveStep1($output, $params)
  {
    $output['log']['messages'][] = 'Step 1. Check Master';
    $this->ha_data['server']['unique_id'] = Controller::generateRandomString(24);

    $session_params =
    [
      'server_ip' => $this->ha_data['server']['ipaddr_master'],
      'path' => '/api/ha/sync/',
      'guzzle_params' => [],
  	  'form_params' =>
        [
          'psk' => $this->ha_data['server']['psk_slave'],
          'action' => 'sync-init',
          'api_version' => APIVER,
          'unique_id' => $this->ha_data['server']['unique_id'],
          'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
        ]
    ];

    $master_response = self::sendRequest($session_params);
    if (! $master_response ) {
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Error!  ###\nIncorrect Master IP Or Master does not response";
      return $output;
    }

    $master_response[0] = json_decode($master_response[0], true );
    $output['master_resp'] = [ 'body' => $master_response[0], 'code' => $master_response[1] ];
    if ( $output['master_resp']['code'] !== 200 ){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Error!  ###\nMaster Response: Incorrect PSK";
      return $output;
    }
    $this->ha_data['server']['bin_file'] = $master_response[0]['mysql'][0];
    $this->ha_data['server']['position'] = $master_response[0]['mysql'][1];
    $output['log']['messages'][] = "Master Available. PSK is Ok";
    $output['log']['messages'][] = 'Bin File: ' . $master_response[0]['mysql'][0];
    $output['log']['messages'][] = 'Position: ' . $master_response[0]['mysql'][1];
    $output['slave_id'] = $master_response[0]['slave_id'];
    $output['log']['messages'][] = 'Uniquie ID: ' . $master_response[0]['slave_id'];
    $this->ha_data['server']['ipaddr_slave'] = $master_response[0]['remoteip'];
    $makeIdVar=explode('.', $master_response[0]['remoteip']);
    $this->ha_data['server']['slave_id'] = $makeIdVar[3] + 1;

    $output['step'] = $params['step'];
    return $output;
  }
  public function setupSlaveStep2($output, $params)
  {
    $output['log']['messages'][] = "Step 2. Download and deploy dump file";
    $session_params =
    [
      'server_ip' => $this->ha_data['server']['ipaddr_master'],
      'path' => '/api/ha/sync/',
      'guzzle_params' => [],
  	  'form_params' =>
      [
        'psk' => $this->ha_data['server']['psk_slave'],
        'action' => 'dump',
        'api_version' => APIVER,
        'unique_id' => $this->ha_data['server']['unique_id'],
        'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
      ]
    ];

    $master_response = self::sendRequest($session_params);

    if ( $master_response[1] !== 200 ){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Error!  ###\nIncorrect Master IP Or Master does not response";
      return $output;
    }
    if ($params['debug']) $output['master_resp'] = $master_response[0];
    file_put_contents('/opt/tacacsgui/temp/dumpForSlave.sql', $master_response[0], LOCK_EX);
    $output['file_exists'] = file_exists ( '/opt/tacacsgui/temp/dumpForSlave.sql' );
    if ( ! file_exists ( '/opt/tacacsgui/temp/dumpForSlave.sql' ) ) {
      $output['type'] = 'message';
      $output['message'] = "### Error!  ###\nWhere is dump file?";
      $output['step'] = $params['step'];
      return $output;
    }
    $output['log']['messages'][] = 'Deploy: '. CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr(['ha','dump-deploy', DB_PASSWORD])->get();
    //trim( shell_exec( "mysql -u tgui_user --password='".DB_PASSWORD."' tgui < /opt/tacacsgui/temp/dumpForSlave.sql" ) );
    $output['dump'] = true;
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupSlaveStep3($output, $params)
  {
    $output['log']['messages'][] = 'Step 3. Change my.cnf and start slave role';
    $rootpw = $params['rootpw'];
    //prepare my.cnf//
    $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','mycnf', 'slave', $this->ha_data['server']['slave_id'] ])->get();
    //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha mycnf slave '".$this->ha_data['server']['slave_id']."' 2>&1" ) );

    //start slave//
    $linuxCmdTemp = "sudo /opt/tacacsgui/main.sh ha slave start '".$rootpw."' '".$this->ha_data['server']['ipaddr_master']."' '".$this->ha_data['server']['psk_slave']."' '".$this->ha_data['server']['bin_file']."' '".$this->ha_data['server']['position']."' 2>&1";

    $output['slave_start_cmd']=$linuxCmdTemp ;
    /*$output['slave_start_cmd']=CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha', 'slave', 'start',
      $rootpw,
      $this->ha_data['server']['ipaddr_master'],
      $this->ha_data['server']['psk_slave'],
      $this->ha_data['server']['bin_file'],
      $this->ha_data['server']['position'] ])->get(); */
    //$output['tmp111'] = $this->ha_data['server'];
    $output['log']['messages'][] = "Create user tgui_ro";
    $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','tgui_ro', $rootpw, $this->ha_data['server']['psk_slave'] ])->get();
    //( shell_exec( "sudo /opt/tacacsgui/main.sh ha tgui_ro '".$rootpw."' '". $this->ha_data['server']['psk_slave']."'" ) ) ;
    $output['log']['messages'][] =
    CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha','replication', $rootpw, $this->ha_data['server']['psk_slave'] ])->get();//trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha replication '".$rootpw."' '" .$this->ha_data['server']['psk_slave']."' 2>&1" ) );
    $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ha', 'slave', 'start',
      $rootpw,
      $this->ha_data['server']['ipaddr_master'],
      $this->ha_data['server']['psk_slave'],
      $this->ha_data['server']['bin_file'],
      $this->ha_data['server']['position'] ])->get();

    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  public function setupSlaveStep4($output, $params)
  {
    $output['log']['messages'][] = "Step 4. Set time settings";
    $output['timezone_data'] = $this->capsule::table('api_settings')->select(['timezone', 'ntp_list'])->find(1);

    $output['timezone_settings'] = APISettingsCtrl::applyTimeSettings([
      'timezone' => $output['timezone_data']->timezone,
      'ntp_list' => $output['timezone_data']->ntp_list
    ]);
    $output['log']['messages'][] = "Timezone: ". $output['timezone_data']->timezone . ' NTP list:' . $output['timezone_data']->ntp_list;
    $output['log']['messages'][] = "Status: " . (  $output['timezone_settings'] ) ? CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr([ 'ntp', 'get-config' ])->get() : false; //trim( shell_exec( 'sudo '. TAC_ROOT_PATH . "/main.sh ntp get-config ") ) : false;

    $session_params =
    [
      'server_ip' => $this->ha_data['server']['ipaddr_master'],
      'path' => '/api/ha/sync/',
      'guzzle_params' => [],
  	  'form_params' =>
      [
        'psk' => $this->ha_data['server']['psk_slave'],
        'action' => 'final',
        'api_version' => APIVER,
        'unique_id' => $this->ha_data['server']['unique_id'],
        'slave_id' => $this->ha_data['server']['slave_id'],
        'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id', 'slave_id']
      ]
    ];

    $master_response = self::sendRequest($session_params);

    if ( $master_response[1] !== 200 ){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Error!  ###\nIncorrect Master IP Or Master does not response";
      return $output;
    }
    $output['log']['messages'][] = 'Got Master response';
	  $master_response[0] = json_decode($master_response[0], true );
    $output['master_resp'] = [ 'body' => $master_response[0], 'code' => $master_response[1] ];

    $output['log']['messages'][] = 'Master api v.: '. $master_response[0]['apiver'] . '; Slave api v.: ' . APIVER;
    if ( $master_response[0]['apiver'] != APIVER ){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Error!  ###\nYou must have the same version!";
      return $output;
    }

    $tempArray = $this->capsule::select( 'CHECKSUM TABLE '. implode(",",array_keys($this->tablesArr) ) );
    for ($i=0; $i < count($tempArray); $i++) {
      $output['ha_checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
    }
    if ( $output['ha_checksum'] != $master_response[0]['checksum']){
      $output['log']['error'] = true;
      $output['log']['messages'][] = "### Error!  ###\nDatabase does not sync!";
      return $output;
    }
    $output['log']['messages'][] = "Database check is Ok";
    $output['log']['messages'][] = "Save Configuration";

    $ha_status = self::getStatus('slave');
    $output['log']['messages'][] = $ha_status['ha_status_brief'];
    $replication_status = explode(':', $ha_status['ha_status_brief']);
    $this->ha_data['server_list'] = [
      'master' => [
        'ipaddr' => $this->ha_data['server']['ipaddr_master'],
        'location' => 'remote',
        'status' => ( strpos($ha_status['ha_status_brief'], 'Waiting for') !== false ) ? 'Available':'Unknown',
        'lastchk' => CMDRun::init()->setCmd(MAINSCRIPT)->setAttr( [ 'ntp', 'get-time' ] )->get(),//trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") ),
        'dbcheck' => 'Ok',
        'dbcheck_check' => true,
        'dbreplication' => trim($replication_status[1]),
        'apiver' => APIVER,
        'apiver_check' => true
      ],
      'slave' => [ $this->ha_data['server']['slave_id'] =>
        [
          'ipaddr' => $this->ha_data['server']['ipaddr_slave'],
          'location' => 'localhost',
          'status' => 'Available',
          'lastchk' => CMDRun::init()->setCmd(MAINSCRIPT)->setAttr( [ 'ntp', 'get-time' ] )->get()
        ]
      ]
    ];
    $this->ha_data['server']['role'] = 'slave';
    self::saveConfg($this->ha_data);
    $output['log']['messages'][] = "Done. ". ( strpos($ha_status['ha_status_brief'], 'Waiting for') !== false ) ? 'Success':'###  FAIL ###';
    $output['final'] = true;
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  private function check_rootpw( $rootpw = '' )
  {
    if ( ! empty($rootpw) ){
      if ( CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw', $rootpw ] )->get() == 1 ) return true;
        //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha rootpw '".$rootpw."' 2>&1" ) ) == 1) return true;
    }

    $rootpw = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw' ] )->get();
    if ( CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'rootpw', $rootpw ] )->get() == 1 ) return true;

    return false;
  }

  public function makeSlaveId($value='')
  {
    if ( !isset($this->ha_data['server']['slave_id_list']) ) $this->ha_data['server']['slave_id_list'] = '';

    $slaveId = 0;
    while (true) {
      if ( $slaveId != 0 AND ! in_array( $slaveId, explode( ';;', $this->ha_data['server']['slave_id_list'] ) ) ) break;
      $slaveId = rand(10,100);
    }
    $this->ha_data['server']['slave_id_list'] = $this->ha_data['server']['slave_id_list'] . ( ( empty($this->ha_data['server']['slave_id_list']) ) ? '' : ';;' ) . $slaveId;
    self::saveConfg($this->ha_data);
    return $slaveId;
  }

  public function delEmptySlaveId($value='')
  {
    $this->ha_data['server']['slave_id_list'] = implode(';;', array_keys( $this->ha_data['server_list']['slave'] ) );
    return $this;
  }

  private function initial_file()
  {
    $this->encoder->encodeFile( $this->initial_data, '/opt/tgui_data/ha/ha.cfg');
  }
  public static function getFullConfiguration()
  {

    if ( ! file_exists('/opt/tgui_data/ha/ha.yaml') ) file_put_contents('/opt/tgui_data/ha/ha.yaml', '{ }');
    //if ( ! file_exists('/opt/tgui_data/ha/ha.php') ) file_put_contents('/opt/tgui_data/ha/ha.php', '<?php return array();');

    return Yaml::parseFile('/opt/tgui_data/ha/ha.yaml');
    //if ( (isset($this) && get_class($this) == __CLASS__) ) $this->ha_data = include '/opt/tgui_data/ha/ha.php';
    //return include '/opt/tgui_data/ha/ha.php';
  }
  public function saveConfg($ha_data = [ 'bugaga' => true ])
  {
    if (isset($ha_data['bugaga'])) return false;
     $yaml = Yaml::dump($ha_data);
     file_put_contents('/opt/tgui_data/ha/ha.yaml', $yaml);
     //file_put_contents('/opt/tgui_data/ha/ha.php', '<?php return ' . var_export( $ha_data, true ) . ';');

    return true;
  }
  public static function getServerRole()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array(@$ha_data['server'] ) ) return 'none';
    return  $ha_data['server']['role'];
  }
  public static function isMaster()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array(@$ha_data['server'] ) ) return false;
    return $ha_data['server']['role'] == 'master';
  }
  public static function isSlave()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array(@$ha_data['server'] ) ) return false;
    return  $ha_data['server']['role'] == 'slave';
  }
  public static function slavePsk()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return false;
    return  $ha_data['server']['psk_slave'];
  }
  public static function getStatus( $role = '', $params = [ 'touchMaster' => false ] )
  {
    $output=[ 'log' => ['messages' => [] ] ];
    $params = ( empty(@$params) ) ? [ 'touchMaster' => false ] : $params;
    $params['touchMaster'] = empty($params['touchMaster']);

    $ha_data = self::getFullConfiguration();

    //$role = 'disabled';
    if ( is_array( $ha_data ) AND is_array($ha_data['server'] ) AND isset($ha_data['server']['role']) AND $role == '') $role = $ha_data['server']['role'];

    $output['log']['messages'][] = 'Server Role: '. $role;
    $output['log']['messages'][] = 'Server Replication Status: ';

    switch ($role) {
      case 'master':
        $output['ha_status'] = $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'status', 'master', $ha_data['server']['psk_master'] ] )->get();
        //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$ha_data['server']['psk_master']."' 2>&1 ") );
        break;
      case 'slave':
        $output['ha_status_brief'] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'status', 'slave', $ha_data['server']['psk_slave'] ] )->setGrep('Slave_IO_State')->get();
        //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status slave '".$ha_data['server']['psk_slave']."' 2>&1 | grep Slave_IO_State" ) );
        $output['log']['messages'][] = 'Briefly: ' . ( ( strpos($output['ha_status_brief'], 'Waiting for') !== false ) ? 'Ok':'Error!' );
        $output['ha_status'] = $output['log']['messages'][] = CMDRun::init()->setSudo()->setCmd(MAINSCRIPT)->setAttr( [ 'ha', 'status', 'slave', $ha_data['server']['psk_slave'] ] )->get();
        //trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status slave '".$ha_data['server']['psk_slave']."' 2>&1" ) );
        break;
      default:
        $output['ha_status'] = $output['log']['messages'][] = 'disabled';
        break;
    }
    $output['role'] = $role;
    $output['log']['messages'][] = "my.cnf file:";
    $output['my_cnf'] = $output['log']['messages'][] = CMDRun::init()->setCmd('cat')->setAttr( '/etc/mysql/my.cnf' )->get();
    //trim(shell_exec('cat /etc/mysql/my.cnf'));
    if ( HA::isSlave() ) {
      $output['log']['messages'][] = 'Try to get Master Info: ';
      $session_params =
      [
        'server_ip' => $ha_data['server']['ipaddr_master'],
        'path' => '/api/ha/info/',
        'guzzle_params' => [],
    	  'form_params' =>
        [
          'psk' => $ha_data['server']['psk_slave'],
          'action' => 'info',
          'api_version' => APIVER,
          'unique_id' => $ha_data['server']['unique_id'],
          'sha1_attrs' => ['action', 'psk', 'unique_id']
        ]
      ];

      $master_response = self::sendRequest($session_params);

      if ( $master_response[1] !== 200 ){
        $output['log']['messages'][] = "### Error!  ###\nIncorrect Master IP Or Master does not response";
        self::masterCheckIn(['unavailable' => true]);
        return $output;
      }

      $output['master_resp'] = [ 'body' => json_decode($master_response[0], true ) ];

      $output['log']['messages'][] = "Master Version: " . ( ( empty($output['master_resp']['body']['apiver']) ) ? 'Unknown' : $output['master_resp']['body']['apiver'] );

      $capsule = self::_capsule();
      $apiDatabase = new APIDatabase;
      $tempArray = $capsule::select( 'CHECKSUM TABLE '. implode(",",array_keys($apiDatabase->tablesArr) ) );
      for ($i=0; $i < count($tempArray); $i++) {
        $output['slave_checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
      }
      if ( $output['slave_checksum'] != $output['master_resp']['body']['checksum'] ) $output['log']['messages'][] = "### Error!  ### Database does not sync!";
      else $output['log']['messages'][] = "Database is synced. Ok";

      if (self::masterCheckIn(['apiver' => $output['master_resp']['body']['apiver'], 'dbcheck' => ( ($output['slave_checksum'] == $output['master_resp']['body']['checksum']) ? 'Ok' : 'Error!') ]) ){
        $output['log']['messages'][] = "Master info was updated.";
        $output['tableRefresh'] = true;
      }
    } //is Slave Status extra
    //$output['isMaster'] = $ha_data['server_list'];
    if ( HA::isMaster() ){
      $capsule = self::_capsule();
      foreach ($ha_data['server_list']['slave'] as $sid => $slave_) {
        $output['log']['messages'][] = 'Try to connect to slave ' . $slave_['ipaddr'] .' ('.$slave_['slave_id'].')';

        $session_params =
        [
          'server_ip' => $slave_['ipaddr'],
          'path' => '/api/ha/info/',
          'guzzle_params' => [],
          'form_params' =>
          [
            'psk' => $ha_data['server']['psk_master'],
            'action' => 'info',
            'role' => 'master',
            'api_version' => APIVER,
            'sha1_attrs' => ['action', 'psk', 'api_version']
          ]
        ];

        $slave_response = self::sendRequest($session_params);
        $output['slave_'.$sid] = $slave_response;
        if ( $slave_response[1] !== 200 ){
          $output['log']['messages'][] = "### Error!  ###\nIncorrect Slave IP Or Slave does not response";
          //self::masterCheckIn(['unavailable' => true]);
          return $output;
        }
        $output['slave_'.$sid] = [ 'body' => json_decode($slave_response[0], true ) ];
        $output['log']['messages'][] = "Success.";
        $output['log']['messages'][] = "Version: ".$output['slave_'.$sid]['body']['apiver'];
        $output['log']['messages'][] = "############################";
        self::slaveTimeUpdate($slave_['ipaddr']);
      }
      $output['tableRefresh'] = true;
    }
    return  $output;
  }

  public static function masterCheckIn($attrs = [])
  {
    $ha_data = $ha_data_old = self::getFullConfiguration();

    if ( ! empty($attrs['apiver']) ) {
      $ha_data['server_list']['master']['apiver'] = $attrs['apiver'];
      $ha_data['server_list']['master']['apiver_check'] = ( $attrs['apiver'] === APIVER );
    }

    if ( ! empty($attrs['dbcheck']) ) {
      $ha_data['server_list']['master']['dbcheck'] = $attrs['dbcheck'];
      $ha_data['server_list']['master']['dbcheck_check'] = ( $attrs['dbcheck'] === 'Ok' );
    }

    if ( ! empty($attrs['unavailable']) ) {
      $ha_data['server_list']['master']['sratus'] = false;
    }

    $ha_data['server_list']['master']['lastchk'] = CMDRun::init()->setCmd(MAINSCRIPT)->setAttr( [ 'ntp', 'get-time' ] )->get();

    self::saveConfg( $ha_data );

    return true;
  }

  public static function unconfiguredSlaves($ip = '')
  {
    $ha_data = self::getFullConfiguration();
    if ( isset($ha_data['server_list']) AND isset($ha_data['server_list']['slave']) AND count($ha_data['server_list']['slave'])){
      foreach ($ha_data['server_list']['slave'] as $value) {
        if ( ! isset($value['config_uid']) AND $ip == '' OR $value['config_uid'] != $ha_data['server']['config_uid']) return true;
        if ( ! isset($value['config_uid']) AND $ip == $value['ipaddr'] OR $value['config_uid'] != $ha_data['server']['config_uid']) return true;
      }
    }

    return false;
  }
  public static function slaveConfigured($ip = '0.0.0.0', $config_uid = '')
  {
    $ha_data = self::getFullConfiguration();
    if ( isset($ha_data['server_list']) AND isset($ha_data['server_list']['slave']) AND count($ha_data['server_list']['slave'])){
      for ($i=0; $i < count($ha_data['server_list']['slave']); $i++) {
        if ( ! isset($ha_data['server_list']['slave'][$i]['config_uid']) ){
          $ha_data['server_list']['slave'][$i]['config_uid'] = $config_uid;
          self::saveConfg($ha_data);
          // $encoder = new jsone();
          // $encoder->setPrettyPrinting(true);
          // $encoder->encodeFile( $ha_data, '/opt/tgui_data/ha/ha.cfg');
        }
      }
    }

    return false;
  }
  //SHOULD BE DEPRICATED//!!!
  // public static function updateSlaveTime($params)
  // {
  //   $ha_data = self::getFullConfiguration();
  //   if ( isset($ha_data['server_list']) AND isset($ha_data['server_list']['slave']) AND count($ha_data['server_list']['slave'])){
  //     for ($i=0; $i < count($ha_data['server_list']['slave']); $i++) {
  //       if ( $ha_data['server_list']['slave'][$i]['ipaddr'] == $params['ipaddr'] AND  $ha_data['server_list']['slave'][$i]['unique_id'] == $params['unique_id']){
  //         $ha_data['server_list']['slave'][$i]['lastchk'] = trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") );
  //         $encoder = new jsone();
  //         $encoder->setPrettyPrinting(true);
  //         $encoder->encodeFile( $ha_data, '/opt/tgui_data/ha/ha.cfg');
  //       }
  //     }
  //   }
  //
  //   return false;
  // }
  /////////////////////////////////////
  public static function isThereSlaves()
  {
    $ha_data = self::getFullConfiguration();
    if ( isset($ha_data['server_list']) AND isset($ha_data['server_list']['slave']) AND count($ha_data['server_list']['slave'])) return true;

    return false;
  }
  public static function sendLogEvent($params = [])
  {
    isset($params['log_type']) || $params['log_type'] = '';
    isset($params['log_entry']) || $params['log_entry'] = '';
    $ha_data = self::getFullConfiguration();
    $session_params =
    [
      'server_ip' => $ha_data['server']['ipaddr_master'],
      'path' => '/api/ha/log/add/',
      'guzzle_params' => [],
      'form_params' =>
        [
          'psk' => $ha_data['server']['psk_slave'],
          'action' => 'logging',
          'log_type' => $params['log_type'],
          'log_entry' => $params['log_entry'],
          'api_version' => APIVER,
          'unique_id' => $ha_data['server']['unique_id'],
          'sha1_attrs' => ['action', 'psk', 'unique_id', 'log_type']
        ]
    ];
    $response = self::sendRequest($session_params);

    return ($response[1] == 200);
  }
  public static function searchSlave($ipaddr = '', $server_array = [])
  {
    foreach ($server_array as $arrId => $slave) {
      if (!isset($slave['ipaddr'])) continue;
      if ($slave['ipaddr'] == $ipaddr) {
        return $arrId;
      }
    }
    return null;
  }
  public static function slaveTimeUpdate($ipaddr = '', $params = [])
  {
    $ha_data = self::getFullConfiguration();
    if ( !isset($ha_data['server_list']) OR !isset($ha_data['server_list']['slave']) OR !count($ha_data['server_list']['slave'])) return false;
    $id = self::searchSlave($ipaddr, $ha_data['server_list']['slave']);
    if ( $id === null ) return false;
    $ha_data['server_list']['slave'][$id]['lastchk'] = Controller::serverTime();
    if ( isset($params['api_version']) ) $ha_data['server_list']['slave'][$id]['api_version'] = $params['api_version'];
    self::saveConfg($ha_data);
  }
  public static function delSlave($sid=0)
  {
    $ha_data = self::getFullConfiguration();
    if  (! isset($ha_data['server_list']['slave'][$sid]) ) return false;
    unset($ha_data['server_list']['slave'][$sid]);
    self::saveConfg($ha_data);
    return true;
  }
}
