<?php

namespace tgui\Services\CMDRun;


class CMDRun
{
  private $cmd = '';
  private $cmd_ = ''; //version 2
  private $attr =[];
  private $TRIM = true;
  private $stdOut_parameter = '';
  private $sudo = '';
  private $grep = '';
  private $back = '';
  private $v = 1;

  public function __construct($params = [])
  {
    //if ( isset($params['version'] ) ) $this->v = $params['version'];
    $this->v = (empty($params['version'])) ? 1 : $params['version'];
  }

  public static function init($params = [])
  {
    //var_dump($params); die();
    return new CMDRun($params);
  }

  public function v2($params = [])
  {
    $this->v = 2;
    return $this;
  }

  public function setCmd($cmd = '')
  {
    if ($this->v == 2) {
      $this->cmd_ .= escapeshellcmd($cmd) . ' ';
      return $this;
    }

    $this->cmd = escapeshellcmd($cmd);
    $this->attr = [];
    return $this;
  }

  public function setAttr($attr = [])
  {

    $attr = is_array( $attr ) ? $attr : [$attr];

    if ($this->v == 2) {
      for ($i=0; $i < count($attr); $i++) {
        $this->cmd_ .= escapeshellarg($attr[$i]) . ' ';
      }
      return $this;
    }

    for ($i=0; $i < count($attr); $i++) {
      $this->attr[] = escapeshellarg($attr[$i]);
    }
    return $this;
  }

  public function setSudo($param = true)
  {

    if ($this->v == 2) {
      $this->cmd_ = 'sudo ' . $this->cmd_;
      return $this;
    }

    $this->sudo = 'sudo';
    return $this;
  }

  public function setGrep($value = '')
  {
    $this->grep = $value;
    return $this;
  }

  public function setPipe($value = '')
  {
    if ($this->v == 2) {
      $this->cmd_ .= ' | ';
      return $this;
    }
    return $this;
  }

  public function toBackground($value = '')
  {
    $this->back = ' > /dev/null 2>/dev/null & ';
    return $this;
  }

  public function setStdOut($parameter = '')
  {
    switch ( $parameter ) {
      case '2>&1':
        $this->stdOut_parameter = $parameter;
        break;
      case '2>/dev/null':
        $this->stdOut_parameter = $parameter;
        break;

      default:
        $this->stdOut_parameter = '';
        break;
    }
    return $this;
  }

  public function get($trim = true)
  {
    #$output = shell_exec( $this->showCmd() );
    if ($this->v == 2)
      $output = shell_exec( $this->cmd_ );
    else
      $output = shell_exec( $this->showCmd() );

    if ( preg_match('/^error:\n/', $output) ) {
      throw new \Exception( trim( preg_replace('/^error:\n/', '', $output) ) );
    }

    return ($trim) ? trim(  $output ) : $output;
  }

  public function showCmd()
  {
    if ($this->v == 2) {
      return $this->cmd_;
    }
    $attr_list = ' ';
    for ($i=0; $i < count($this->attr); $i++) {
      $attr_list .= $this->attr[$i] . ' ';
    }
    return $this->sudo .' '.$this->cmd.' '.$attr_list .' '. $this->stdOut_parameter . ( ( empty($this->grep) ) ? '' : ' | grep '. $this->grep) . $this->back;
  }
}
