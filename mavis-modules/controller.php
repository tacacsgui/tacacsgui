<?php

require __DIR__ . '/constants.php';

class mavis_cotrl
{
  public $V_IN = [];
  public $debug = true;
  //private $result = MAVIS_INIT_ERR;
  private $result = MAVIS_DOWN;

  public function __construct($val = [])
  {
    //if ( ! empty($val['debugCleare']) )
    file_put_contents('/var/log/tacacsgui/mavis_debug.txt', "");
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
    $this->V_IN[AV_A_RESULT] = AV_V_RESULT_OK;
    $this->result = MAVIS_CONF_OK;
    return false;
  }

  public function setMempership($value = '')
  {
    if ( empty($value) ) return false;
    if ( is_array($value) ) $value = '"'.implode('","', $value).'"';;
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
    if ( empty($var) ) return false;
    file_put_contents('/var/log/tacacsgui/mavis_debug.txt', $var."\n", FILE_APPEND);
    return true;
  }

  public function mavisErr()
  {
    $this->result = MAVIS_INIT_ERR;
    return $this;
  }
  public function mavisOk()
  {
    $this->result = MAVIS_INIT_OK;
    return $this;
  }

  public function out($result_error = '', $mavis_result = 1)
  {
    if ( ! empty($result_error) ) $this->V_IN[AV_A_RESULT] = $result_error;
    if ( empty($this->V_IN[AV_A_RESULT]) ) $this->V_IN[AV_A_RESULT] = AV_V_RESULT_ERROR;

    $output = '';
    ksort($this->V_IN);
    foreach($this->V_IN as $index => $value)
    {
    	$output.= $index.' '.$value."\n";
    }
    $output.="=".$this->result."\n";
    if ($this->debug) file_put_contents('/var/log/tacacsgui/mavis_debug.txt', $output, FILE_APPEND);

    fwrite(STDOUT, $output);
    exit(0);
  }


}

 ?>
