<?php

namespace tgui\Controllers\APISettings;

use Webmozart\Json\JsonEncoder as jsone;
use Webmozart\Json\JsonDecoder as jsond;
use Webmozart\Json\JsonValidator;

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

  public function __construct( $some_data = [] )
  {

    $this->encoder = new jsone();
    $this->decoder = new jsond();

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
  public function checkAccess($ip = '')
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

    //slave
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
