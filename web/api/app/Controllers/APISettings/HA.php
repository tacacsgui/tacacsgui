<?php

namespace tgui\Controllers\APISettings;

use Webmozart\Json\JsonEncoder as jsone;
use Webmozart\Json\JsonDecoder as jsond;
use Webmozart\Json\JsonValidator;
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

    $this->encoder = new jsone();
    $this->decoder = new jsond();

    if ($params['capsule']){
      $this->capsule = new \Illuminate\Database\Capsule\Manager;
      $this->capsule->addConnection([
          'driver' => 'mysql',
          'host'	=> DB_HOST,
          'database' => DB_NAME,
          'username' => DB_USER,
          'password' => DB_PASSWORD,
          'charset' => DB_CHARSET,
          'collation' => DB_COLLATE,
          'prefix' => ''
        ]);
      $this->capsule->setAsGlobal();
      $this->capsule->schema();
      $this->capsule->bootEloquent();
    }
    $apiChecker = new APIDatabase;
    $this->tablesArr = $apiChecker->tablesArr;

    if ( ! file_exists('/opt/tgui_data/ha/ha.cfg') ){
      $this->initial_file();
    }
    $this->decoder->setObjectDecoding(1);

    $this->ha_data = $this->decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );

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
    $output=[];
    if ( ! self::isThereSlaves() ) return $output;

    foreach ($this->ha_data['server_list']['slave'] as $value) {
      $session_params =
      [
        'server_ip' => $value['ipaddr'],
        'path' => '/api/ha/do/apply/',
        'guzzle_params' => [],
    	  'form_params' =>
          [
            'psk' => $this->ha_data['server']['psk_master'],
            'action' => 'apply',
            'api_version' => APIVER,
            'unique_id' => $value['unique_id'],
            'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
          ]
      ];
      $response = self::sendRequest($session_params);

      if ($response[1] != 200 ) {
        $output[count($output)] = ['ip'=> $value['ipaddr'], 'uid' => $value['unique_id'], 'response' => $response ];
        continue;
      }
      self::updateSlaveTime(['ipaddr' => $value['ipaddr'], 'unique_id'=> $value['unique_id']]);
      $response[0] = json_decode($response[0], true );
      $response[0]['db_check'] = ($params['checksum'] == $response[0]['checksum']);
      if ($response[0]['db_check'] AND $response[0]['version_check'] AND !$response[0]['applyStatus']['error'] AND self::unconfiguredSlaves($value['ipaddr'])) self::slaveConfigured($value['ipaddr'], $this->ha_data['server']['config_uid']);

      $output[count($output)] = ['ip'=> $value['ipaddr'], 'uid' => $value['unique_id'], 'response' => $response , 'configured' => self::unconfiguredSlaves($value['ipaddr'])];
    }

    return $output;
  }
  public function getMysqlParams()
	{
    return explode( ' ', trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$this->ha_data['server']['psk_master']."'  brief 2>&1" ) ) );
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

    if ( ! isset($this->ha_data['server_list']) OR ! isset($this->ha_data['server_list']['slave']) OR count($this->ha_data['server_list']['slave']) == 0){
      $this->ha_data['server_list']['slave'] = [];
      $this->ha_data['server_list']['slave'][0] = $slave;
      $this->encoder->setPrettyPrinting(true);
      $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
      return true;
    }
    count($this->ha_data['server_list']['slave']);
    for ($i=0; $i < count($this->ha_data['server_list']['slave']); $i++) {
      if ($this->ha_data['server_list']['slave'][$i]['ipaddr'] == $_SERVER['REMOTE_ADDR']) {
        $this->ha_data['server_list']['slave'][$i] = $slave;
        $this->encoder->setPrettyPrinting(true);
        $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
        return true;
      }
    }

    $this->ha_data['server_list']['slave'][count($this->ha_data['server_list']['slave'])] = $slave;
    $this->encoder->setPrettyPrinting(true);
    $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
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
            'lastchk' => ''
          ],
          'slave' => []
        ];

        $this->encoder->setPrettyPrinting(true);
        $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
        break;
      case 'slave':
        $output['role'] = $this->ha_data['server']['role'];
        if ($params['step'] < 5 ) $this->ha_data['server']['role'] = '';
        $output = $this->slave_settings( $output, $params );

        $this->encoder->setPrettyPrinting(true);
        $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');

        if ($params['step'] >= 5 ) {
          session_unset(); session_destroy();
        }
        break;
      case 'disabled':
        $this->ha_data = [];
        $this->encoder->setPrettyPrinting(true);
        $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
        $output['ha_status_disabled'] = trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha disable 2>&1 ") );
        $output['status'] = '';
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
    $rootpw = $params['rootpw'];
    if ( ! $this->check_rootpw($rootpw) ){
      $output['type'] = 'rootpw';
      return $output;
    }
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
    $output['ha_status'] = trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$this->ha_data['server']['psk_master']."' 2>&1 ") );

    $output['status'] = '';
    $output['stop'] = true;
    return $output;
  }
  public function setupMasterStep1( $output, $params )
  {
    //prepare my.cnf//
    $output['my.cnf']=trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha mycnf '".$this->ha_data['server']['ipaddr']."' 2>&1" ) );
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupMasterStep2( $output, $params )
  {
    $rootpw = $params['rootpw'];

    //prepare replication user//
    $output['replication']=trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha replication '".$rootpw."' '" .$this->ha_data['server']['psk_master']."' 2>&1" ) );
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  private function slave_settings( $output = [], $params = [] )
  {
    if ( ! Controller::activated() ){
      $output['type'] = 'message';
      $output['message'] = 'Unregistered system. Register system to enable that feature.';
      $output['master_resp'] = [];
      return $output;
    }

    if ( ! $this->check_rootpw($params['rootpw']) ){
      $output['type'] = 'rootpw';
      return $output;
    }
    if ( empty($params['rootpw']) ) $params['rootpw'] = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw' ) );
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


    $output['ha_status'] = trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status slave '".$this->ha_data['server']['psk_slave']."' 2>&1" ) );

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
      $output['type'] = 'message';
      $output['message'] = 'Incorrect PSK or Master IP';
      $output['master_resp'] = [];
      return $output;
    }

    $master_response[0] = json_decode($master_response[0], true );
    $output['master_resp'] = [ 'body' => $master_response[0], 'code' => $master_response[1] ];
    if ( $output['master_resp']['code'] !== 200 ){
      $output['type'] = 'message';
      $output['message'] = 'Incorrect PSK or Master IP';
      $output['master_resp'] = [];
      return $output;
    }
    $this->ha_data['server']['bin_file'] = $master_response[0]['mysql'][0];
    $this->ha_data['server']['position'] = $master_response[0]['mysql'][1];
    $this->ha_data['server']['ipaddr_slave'] = $master_response[0]['remoteip'];
    $makeIdVar=explode('.', $master_response[0]['remoteip']);
    $this->ha_data['server']['slave_id'] = $makeIdVar[3] + 1;

    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupSlaveStep2($output, $params)
  {
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
      $output['type'] = 'message';
      $output['message'] = 'Incorrect PSK or Master IP';
      $output['master_resp'] = [];
      return $output;
    }

    file_put_contents('/opt/tacacsgui/temp/dumpForSlave.sql', $master_response[0], LOCK_EX);

    if ( ! file_exists ( '/opt/tacacsgui/temp/dumpForSlave.sql' ) ) {
      $output['type'] = 'message';
      $output['message'] = 'Where is dump file?';
      $output['step'] = $params['step'];
      return $output;
    }
    $output['ha_restore'] = trim( shell_exec( "mysql -u tgui_user --password='".DB_PASSWORD."' tgui < /opt/tacacsgui/temp/dumpForSlave.sql" ) );
    $output['dump'] = true;
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupSlaveStep3($output, $params)
  {
    $rootpw = $params['rootpw'];
    //prepare my.cnf//
    $output['my.cnf']=trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha mycnf slave '".$this->ha_data['server']['slave_id']."' 2>&1" ) );

    //start slave//
    $linuxCmdTemp = "sudo /opt/tacacsgui/main.sh ha slave start '".$rootpw."' '".$this->ha_data['server']['ipaddr_master']."' '".$this->ha_data['server']['psk_slave']."' '".$this->ha_data['server']['bin_file']."' '".$this->ha_data['server']['position']."' 2>&1";

    $output['slave_start_cmd']=$linuxCmdTemp ;
    $output['tgui_ro']=trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha tgui_ro '".$rootpw."' '". $this->ha_data['server']['psk_slave']."'" ) ) ;
    $output['replication']=trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha replication '".$rootpw."' '" .$this->ha_data['server']['psk_slave']."' 2>&1" ) );
    $output['slave_start']=trim( shell_exec( $linuxCmdTemp ) ) ;

    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  public function setupSlaveStep4($output, $params)
  {

    $output['timezone_data'] = $this->capsule::table('api_settings')->select(['timezone', 'ntp_list'])->find(1);

    $output['timezone_settings'] = APISettingsCtrl::applyTimeSettings([
      'timezone' => $output['timezone_data']->timezone,
      'ntp_list' => $output['timezone_data']->ntp_list
    ]);
    $output['result_ntp'] = (  $output['timezone_settings']) ? trim( shell_exec( 'sudo '. TAC_ROOT_PATH . "/main.sh ntp get-config ") ) : false;

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
        'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
      ]
    ];

    $master_response = self::sendRequest($session_params);

    if ( $master_response[1] !== 200 ){
      $output['type'] = 'message';
      $output['message'] = 'Incorrect PSK or Master IP';
      $output['master_resp'] = [];
      return $output;
    }

	  $master_response[0] = json_decode($master_response[0], true );
    $output['master_resp'] = [ 'body' => $master_response[0], 'code' => $master_response[1] ];

    $ha_status = self::getStatus();
    $this->ha_data['server_list'] = [
      'master' => [
        'ipaddr' => $this->ha_data['server']['ipaddr_master'],
        'location' => 'remote',
        'status' => ( strpos($ha_status['ha_status_brief'], 'Waiting for') !== false ) ? 'Available':'Unknown',
        'lastchk' => trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") )
      ],
      'slave' => [
        [
          'ipaddr' => $this->ha_data['server']['ipaddr_slave'],
          'location' => 'localhost',
          'status' => 'Available',
          'lastchk' => ''
        ]
      ]
    ];
    $this->ha_data['server']['role'] = 'slave';
    $this->encoder->setPrettyPrinting(true);
    $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
    $output['final'] = true;
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  private function check_rootpw( $rootpw = '' )
  {
    if ( ! empty($rootpw) ){
      if (trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha rootpw '".$rootpw."' 2>&1" ) ) == 1) return true;
    }

    $rootpw = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw' ) );
    if (trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha rootpw '".$rootpw."' 2>&1" ) ) == 1) return true;

    return false;
  }

  private function initial_file()
  {
    $this->encoder->encodeFile( $this->initial_data, '/opt/tgui_data/ha/ha.cfg');
  }
  public static function getFullConfiguration()
  {
    $decoder = new jsond();
    $decoder->setObjectDecoding(1);
    return $decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );
  }
  public static function getServerRole()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return 'none';
    return  $ha_data['server']['role'];
  }
  public static function isMaster()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return false;
    return $ha_data['server']['role'] == 'master';
  }
  public static function isSlave()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return false;
    return  $ha_data['server']['role'] == 'slave';
  }
  public static function slavePsk()
  {
    $ha_data = self::getFullConfiguration();
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return false;
    return  $ha_data['server']['psk_slave'];
  }
  public static function getStatus()
  {
    $output=[];
    $ha_data = self::getFullConfiguration();
    $role = 'disabled';
    if ( is_array( $ha_data ) AND is_array($ha_data['server'] ) AND isset($ha_data['server']['role']) ) $role = $ha_data['server']['role'];
    switch ($role) {
      case 'master':
        $output['ha_status'] = trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status master '".$ha_data['server']['psk_master']."' 2>&1 ") );
        break;
      case 'slave':
        $output['ha_status'] = trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status slave '".$ha_data['server']['psk_slave']."' 2>&1" ) );
        $output['ha_status_brief'] = trim( shell_exec( "sudo /opt/tacacsgui/main.sh ha status slave '".$ha_data['server']['psk_slave']."' 2>&1 | grep Slave_IO_State" ) );
        break;
      default:
        $output['ha_status'] = 'disabled';
        break;
    }
    $output['role'] = $role;
    $output['my_cnf'] = trim(shell_exec('cat /etc/mysql/my.cnf'));
    return  $output;
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
          $encoder = new jsone();
          $encoder->setPrettyPrinting(true);
          $encoder->encodeFile( $ha_data, '/opt/tgui_data/ha/ha.cfg');
        }
      }
    }

    return false;
  }
  public static function updateSlaveTime($params)
  {
    $ha_data = self::getFullConfiguration();
    if ( isset($ha_data['server_list']) AND isset($ha_data['server_list']['slave']) AND count($ha_data['server_list']['slave'])){
      for ($i=0; $i < count($ha_data['server_list']['slave']); $i++) {
        if ( $ha_data['server_list']['slave'][$i]['ipaddr'] == $params['ipaddr'] AND  $ha_data['server_list']['slave'][$i]['unique_id'] == $params['unique_id']){
          $ha_data['server_list']['slave'][$i]['lastchk'] = trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") );
          $encoder = new jsone();
          $encoder->setPrettyPrinting(true);
          $encoder->encodeFile( $ha_data, '/opt/tgui_data/ha/ha.cfg');
        }
      }
    }

    return false;
  }
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
          //'api_version' => '',
          'unique_id' => $ha_data['server']['unique_id'],
          'sha1_attrs' => ['action', 'psk', 'unique_id', 'log_type']
        ]
    ];
    $response = self::sendRequest($session_params);

    return ($response[1] == 200);
  }
}
