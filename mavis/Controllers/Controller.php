<?php
namespace mavis\Controllers;
require __DIR__ . '/../constants.php';

class Controller
{
  public $V_IN = [];
  public $debug = true;
  private $mavis_result = MAVIS_FINAL;
  private $result = AV_V_RESULT_ERROR;

  protected $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function __get($property)
	{
		if($this->container->{$property})
		{
			return $this->container->{$property};
		}
	}

  public function in($value = '')
  {
    if ($this->debug) $myfile = file_put_contents('/var/log/tacacsgui/mavis_debug.txt', $value, FILE_APPEND);
    $tempArray = explode(" ", trim($value));
  	$this->V_IN[$tempArray[0]]=trim($tempArray[1]);
  	//if (trim($tempArray[0]) == 4) $username = trim($tempArray[1]);
  	//if (trim($tempArray[0]) == 8) $password = trim($tempArray[1]);
  	return true;
  }

  public function getUsername()
  {
    if ( isset($this->V_IN[AV_A_USER]) ) return $this->V_IN[AV_A_USER];
    return false;
  }

  public function getPassword()
  {
    if ( isset($this->V_IN[AV_A_PASSWORD]) ) return $this->V_IN[AV_A_PASSWORD];
    return false;
  }

  public function auth($g = true)
  {
    $this->result = AV_V_RESULT_OK;
    $this->mavis_result = MAVIS_CONF_OK;
    return false;
  }

  public function setMempership($value = '', $manula_set = false)
  {
    $separator = ( $manula_set ) ? '/' : '","';
    if ( empty($value) ) return false;
    if ( is_array($value) ) $value = '"'.implode($separator, $value).'"';;
    $this->V_IN[AV_A_TACMEMBER] = $value;
    return true;
  }

  public function unsetVariable($attr)
  {
    if ( empty($attr) OR empty($this->V_IN[$attr]) ) return $this;
    unset( $this->V_IN[$attr] );
    return $this;
  }
  public function setVariable($attr = 0, $value='')
  {
    if ( empty($attr) OR empty($value) ) return false;
    $this->V_IN[$attr] = $value;
    return $this;
  }

  public function getVariable($attr = '')
  {
    if ( empty($this->V_IN[$attr]) ) return false;
    return $this->V_IN[$attr];
  }

  public function debugIn($var = '')
  {
    if ( empty($var) OR !$this->debug ) return false;
    file_put_contents('/var/log/tacacsgui/mavis_debug.txt', $var."\n", FILE_APPEND);
    return true;
  }
  public function debugEmpty()
  {
    file_put_contents('/var/log/tacacsgui/mavis_debug.txt', "");
    return true;
  }

  public function mavisErr()
  {
    $this->mavis_result = MAVIS_INIT_ERR;
    return $this;
  }
  public function mavisFinal()
  {
    $this->mavis_result = MAVIS_FINAL;
    return $this;
  }
  public function mavisOk()
  {
    $this->mavis_result = MAVIS_INIT_OK;
    return $this;
  }
  public function mavisDown()
  {
    $this->mavis_result = MAVIS_DOWN;
    return $this;
  }
  public function result( $val = '' )
  {
    switch ($val) {
      case 'ERR':
        $this->result = AV_V_RESULT_ERROR;
        break;
      case 'NAK':
        $this->result = AV_V_RESULT_FAIL;
        break;
      case 'NFD':
        $this->result = AV_V_RESULT_NOTFOUND;
        break;
      case 'ACK':
        $this->result = AV_V_RESULT_OK;
        break;
    }
    return $this;
  }

  public function out()
  {
    $this->V_IN[AV_A_RESULT] = $this->result;

    $output = '';
    ksort($this->V_IN);
    if ($this->V_IN[AV_A_TACTYPE] == 'CHAL' AND $this->V_IN[AV_A_RESULT] == AV_V_RESULT_ERROR) unset($this->V_IN[AV_A_RESULT]);
    foreach($this->V_IN as $index => $value)
    {
    	$output.= $index.' '.$value."\n";
    }
    $output.="=".$this->mavis_result."\n";
    if ($this->debug) file_put_contents('/var/log/tacacsgui/mavis_debug.txt', $output, FILE_APPEND);

    fwrite(STDOUT, $output);
    exit(0);
  }


}

 ?>
