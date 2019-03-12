<?php

namespace tgui\Services\CMDRun;


class CMDRun
{
  private $cmd = '';
  private $attr =[];
  private $TRIM = true;
  private $stdOut_parameter = '';
  private $sudo = '';
  private $grep = '';
  private $back = '';

  public function __cunstruct($params = [])
  {
    // code...
  }

  public static function init($params = [])
  {
    return new CMDRun($params);
  }

  public function setCmd($cmd = '')
  {
    $this->cmd = escapeshellcmd($cmd);
    $this->attr = [];
    return $this;
  }

  public function setAttr($attr = [])
  {
    $attr = is_array( $attr ) ? $attr : [$attr];
    for ($i=0; $i < count($attr); $i++) {
      $this->attr[] = escapeshellarg($attr[$i]);
    }
    return $this;
  }

  public function setSudo($param = true)
  {
    $this->sudo = 'sudo';
    return $this;
  }

  public function setGrep($value = '')
  {
    $this->grep = $value;
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

      default:
        $this->stdOut_parameter = '';
        break;
    }
    return $this;
  }

  public function get($trim = true)
  {
    #$output = shell_exec( $this->showCmd() );
    $output = shell_exec( $this->showCmd() );

    if ( preg_match('/^error:\n/', $output) ) {
      throw new \Exception( trim( preg_replace('/^error:\n/', '', $output) ) );
    }

    return ($trim) ? trim(  $output ) : $output;
  }

  public function showCmd()
  {
    $attr_list = ' ';
    for ($i=0; $i < count($this->attr); $i++) {
      $attr_list .= $this->attr[$i] . ' ';
    }
    return $this->sudo .' '.$this->cmd.' '.$attr_list .' '. $this->stdOut_parameter . ( ( empty($this->grep) ) ? '' : ' | grep '. $this->grep) . $this->back;
  }
}
