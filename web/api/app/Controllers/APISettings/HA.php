<?php

namespace tgui\Controllers\APISettings;

use Webmozart\Json\JsonEncoder as jsone;
use Webmozart\Json\JsonDecoder as jsond;
use Webmozart\Json\JsonValidator;
use GuzzleHttp\Client as gclient;
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
    return [ $this->ha_data['server']['bin_file'], $this->ha_data['server']['position']];
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
      if ($key == 'rootpw') continue;
      $this->ha_data['server'][$key]=$value;
    }

    switch ($this->ha_data['server']['role']) {
      case 'master':
        $output = $this->master_settings( $output, $params['rootpw'] );
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
        $output = $this->slave_settings( $output, $params['rootpw'] );
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
      default:
        $output['message'] = 'Internal Error';
        break;
    }

    return $output;
  }

  private function master_settings( $output = [], $rootpw = '')
  {

    if ( ! $this->check_rootpw($rootpw) ){
      $output['type'] = 'rootpw';
      return $output;
    }
    $output['rootpw'] = true;
    //prepare my.cnf//
    $output['my.cnf']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha mycnf '.$this->ha_data['server']['ipaddr'].' 2>&1' ) );

    //prepare replication user//
    $output['replication']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha replication '.$rootpw.' '.$rootpw.' 2>&1' ) );

    $master_params = explode( ' ', trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status master '.$rootpw.' brief 2>&1' ) ) );
    $this->ha_data['server']['bin_file'] = $master_params[0];
    $this->ha_data['server']['position'] = $master_params[1];

    $output['ha_status'] = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status master '.$rootpw.' 2>&1' ) );

    $output['status'] = '';
    return $output;
  }

  private function slave_settings( $output = [], $rootpw )
  {
    if ( ! $this->check_rootpw($rootpw) ){
      $output['type'] = 'rootpw';
      return $output;
    }
    $output['rootpw'] = true;
    $gclient = new gclient();

    $current_time = time();
    $res = $gclient->request('POST', 'https://'.$this->ha_data['server']['ipaddr_master'].':4443/api/ha/sync/',
    [
      'verify' => false,
      'http_errors' => false,
      'form_params' =>
      [
        'time' => $current_time,
        'masterip' => $this->ha_data['server']['ipaddr_master'],
        'action' => 'sync-init',
        'sha1' => sha1( $current_time . '&'. $this->ha_data['server']['ipaddr_master']. '&' . $this->ha_data['server']['psk_slave'] . '&'. 'sync-init' )
      ]
    ]);
    //var_dump($res);die();
    $master_res = json_decode($res->getBody()->getContents(), true );
    $output['master_resp'] = [ 'body' => $master_res , 'code' => $res->getStatusCode()];
    switch ($output['master_resp']['code']) {
      case 200:
        $output['sync-init'] = 'success';
        break;
      case 403:
        $output['type'] = 'message';
        $output['message'] = 'Incorrect PSK or Master IP';
        return $output;
        break;
      case 500:
        $output['type'] = 'message';
        $output['message'] = 'Unexpected error on Master server';
        return $output;
        break;
      default:
        $output['type'] = 'message';
        $output['message'] = 'Incorrect PSK or Master IP';
        return $output;
        break;
    }
    //slave
    $this->ha_data['server']['bin_file'] = $master_res['mysql'][0];
    $this->ha_data['server']['position'] = $master_res['mysql'][1];
    //$dumpFile = fopen('/opt/tacacsgui/temp/dumpForSlave.sql', 'w') or die('Problems');
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

    $output['ha_restore'] = trim( shell_exec( "mysql -u tgui_user --password='".DB_PASSWORD."' tgui < /opt/tacacsgui/temp/dumpForSlave.sql" ) );

    //prepare my.cnf//
    $output['my.cnf']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha mycnf slave 2 2>&1' ) );

    //start slave//
    $output['my.cnf']=trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha slave start '.$rootpw.' '.$this->ha_data['server']['ipaddr_master'].' '.$this->ha_data['server']['psk_slave'].' '.$this->ha_data['server']['bin_file'].' '.$this->ha_data['server']['position'].' 2>&1' ) );

    $output['titles_checksum'] = implode(",",array_keys($this->tablesArr));
    $output['ha_checksum'] = [];
    $tempArray = $this->capsule::select( 'CHECKSUM TABLE '. implode(",",array_keys($this->tablesArr) ) );
    for ($i=0; $i < count($tempArray); $i++) {
      $output['ha_checksum'][$tempArray[$i]->Table]=$tempArray[$i]->Checksum;
    }


    $output['ha_status'] = trim( shell_exec( 'sudo /opt/tacacsgui/main.sh ha status slave '.$rootpw.' 2>&1' ) );

    $output['status'] = '';
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

}
