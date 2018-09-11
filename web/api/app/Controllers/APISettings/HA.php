<?php

namespace tgui\Controllers\APISettings;

use Webmozart\Json\JsonEncoder as jsone;
use Webmozart\Json\JsonDecoder as jsond;
use Webmozart\Json\JsonValidator;
use GuzzleHttp\Client as gclient;
use GuzzleHttp\Exception\RequestException;
use tgui\Controllers\APIChecker\APIDatabase;


class HA
{
  private $ha_data;
  private $initial_data = [
    'server' => [
      'role' => '',
      'ipaddr' => '',
      'ipaddr_master' => '',
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
  protected $capsule;

  public function __construct( $some_data = [] )
  {

    $this->encoder = new jsone();
    $this->decoder = new jsond();

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

    $apiChecker = new APIDatabase;
    $this->tablesArr = $apiChecker->tablesArr;

    if ( ! file_exists('/opt/tgui_data/ha/ha.cfg') ){
      $this->initial_file();
    }
    //var_dump($this->decoder->getObjectDecoding());die(); //return 0
    $this->decoder->setObjectDecoding(1);
    //var_dump($this->decoder->getObjectDecoding());die(); //return 1

    $this->ha_data = $this->decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );

  }
  public function psk()
  {
    return $this->ha_data['server']['psk_master'];
  }
  public function isMaster()
  {
    return $this->ha_data['server']['role'] == 'master';
  }
  public function getServerList()
	{
    return $this->ha_data['server_list'];
  }
  public function getMysqlParams()
	{
    return explode( ' ', trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status master '.$this->ha_data['server']['psk_master'].' brief 2>&1' ) ) );
  }
  public function getFullData()
	{
    return $this->ha_data;
  }
  public function checkAccessPolicy($ip = '')
	{
    $testArray = explode( ',', $this->ha_data['server']['slaves_ip'] );
    return in_array($ip, $testArray);
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
        $output = $this->slave_settings( $output, $params );
        $output['role'] = $this->ha_data['server']['role'];

        $this->ha_data['server_list'] = [
          'master' => [
            'ipaddr' => $this->ha_data['server']['ipaddr_master'],
            'location' => 'remote',
            'status' => 'Unknown',
            'lastchk' => ''
          ],
          'slave' => [
            [
              'ipaddr' => '',
              'location' => 'localhost',
              'status' => 'Available',
              'lastchk' => ''
            ]
          ]
        ];

        $this->encoder->setPrettyPrinting(true);
        $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
        break;
      case 'disabled':
        $output['disabled'] = true;
        $this->ha_data = [];
        $this->encoder->setPrettyPrinting(true);
        $this->encoder->encodeFile( $this->ha_data, '/opt/tgui_data/ha/ha.cfg');
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
      // case 3:
      //   $output = $this->setupMasterStep3($output, $params);
      //   return $output;
    }

    // $master_params = explode( ' ', trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status master '.$rootpw.' brief 2>&1' ) ) );
    // $this->ha_data['server']['bin_file'] = $master_params[0];
    // $this->ha_data['server']['position'] = $master_params[1];
    $output['current_mysql'] = $this->getMysqlParams();
    $output['ha_status'] = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status master '.$this->ha_data['server']['psk_master'].' 2>&1' ) );

    $output['status'] = '';
    $output['stop'] = true;
    return $output;
  }
  public function setupMasterStep1( $output, $params )
  {
    //prepare my.cnf//
    $output['my.cnf']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha mycnf '.$this->ha_data['server']['ipaddr'].' 2>&1' ) );
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupMasterStep2( $output, $params )
  {
    $rootpw = $params['rootpw'];

    //prepare replication user//
    $output['replication']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha replication '.$rootpw.' '.$this->ha_data['server']['psk_master'].' 2>&1' ) );
    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  private function slave_settings( $output = [], $params = [] )
  {
    $rootpw = $params['rootpw'];
    if ( ! $this->check_rootpw($rootpw) ){
      $output['type'] = 'rootpw';
      return $output;
    }
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


    $output['ha_status'] = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status slave '.$rootpw.' 2>&1' ) );

    $output['status'] = '';
    $output['stop'] = true;
    return $output;
  }

  public function setupSlaveStep1($output, $params)
  {
    try {
      $gclient = new gclient();
      $current_time = time();
      $res = $gclient->request('POST', 'https://'.$this->ha_data['server']['ipaddr_master'].':4443/api/ha/sync/',
      [
        'verify' => false,
        'http_errors' => false,
        'connect_timeout' => 5,
        'form_params' =>
        [
          'time' => $current_time,
          'masterip' => $this->ha_data['server']['ipaddr_master'],
          'action' => 'sync-init',
          'sha1' => sha1( $current_time . '&'. $this->ha_data['server']['ipaddr_master']. '&' . $this->ha_data['server']['psk_slave'] . '&'. 'sync-init' )
        ]
      ]);
    } catch (RequestException $e) {
      $output['type'] = 'message';
      $output['message'] = 'Incorrect PSK or Master IP';
      $output['master_resp'] = [];
      return $output;
        //echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    $master_res = json_decode($res->getBody()->getContents(), true );
    $output['master_resp'] = [ 'body' => $master_res , 'code' => $res->getStatusCode() ];
    if ( $output['master_resp']['code'] !== 200 ){
      $output['type'] = 'message';
      $output['message'] = 'Incorrect PSK or Master IP';
      $output['master_resp'] = [];
      return $output;
    }
    $this->ha_data['server']['bin_file'] = $master_res['mysql'][0];
    $this->ha_data['server']['position'] = $master_res['mysql'][1];
    $makeIdVar=explode('.', $master_res['remoteip']);
    $this->ha_data['server']['slave_id'] = $makeIdVar[3] + 1;

    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }
  public function setupSlaveStep2($output, $params)
  {
    $current_time = time();
    $gclient = new gclient();
    $dump_res = $gclient->request('POST', 'https://'.$this->ha_data['server']['ipaddr_master'].':4443/api/ha/sync/',
    [
      'verify' => false,
      'http_errors' => false,
      'form_params' =>
      [
        'time' => $current_time,
        'masterip' => $this->ha_data['server']['ipaddr_master'],
        'action' => 'dump',
        'sha1' => sha1( $current_time . '&'. $this->ha_data['server']['ipaddr_master']. '&' . $this->ha_data['server']['psk_slave'] . '&'. 'dump' )
      ]
    ]);
    file_put_contents('/opt/tacacsgui/temp/dumpForSlave.sql', $dump_res->getBody()->getContents(), LOCK_EX);

    if ( !file_exists ( '/opt/tacacsgui/temp/dumpForSlave.sql' ) ) {
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
    $output['my.cnf']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha mycnf slave '.$this->ha_data['server']['slave_id'].' 2>&1' ) );

    //start slave//
    $linuxCmdTemp = 'sudo /opt/tacacsgui/main.sh ha slave start '.$rootpw.' '.$this->ha_data['server']['ipaddr_master'].' '.$this->ha_data['server']['psk_slave'].' '.$this->ha_data['server']['bin_file'].' '.$this->ha_data['server']['position'].' 2>&1';

    $output['slave_start_cmd']=$linuxCmdTemp ;
    $output['tgui_ro']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha tgui_ro '.$rootpw.' '. $this->ha_data['server']['psk_slave'] ) ) ;
    $output['slave_start']=trim( shell_exec( $linuxCmdTemp ) ) ;

    $output['status'] = '';
    $output['step'] = $params['step'];
    return $output;
  }

  private function check_rootpw($rootpw = '')
  {
    if ( ! empty($rootpw) ){
      if (trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw '.$rootpw.' 2>&1' ) ) == 1) return true;
    }

    $rootpw = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw' ) );
    if (trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha rootpw '.$rootpw.' 2>&1' ) ) == 1) return true;

    return false;
  }

  private function initial_file()
  {
    $this->encoder->encodeFile( $this->initial_data, '/opt/tgui_data/ha/ha.cfg');
  }
  public static function getServerRole()
  {
    $decoder = new jsond();
    $decoder->setObjectDecoding(1);
    $ha_data = $decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return 'none';
    return  $ha_data['server']['role'];
  }
  public static function isSlave()
  {
    $decoder = new jsond();
    $decoder->setObjectDecoding(1);
    $ha_data = $decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return false;
    return  $ha_data['server']['role'] == 'slave';
  }
  public static function slavePsk()
  {
    $decoder = new jsond();
    $decoder->setObjectDecoding(1);
    $ha_data = $decoder->decodeFile( '/opt/tgui_data/ha/ha.cfg' );
    if ( ! is_array( $ha_data ) OR ! is_array($ha_data['server'] ) ) return false;
    return  $ha_data['server']['psk_slave'];
  }
}
