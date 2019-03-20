<?php

namespace tgui\Controllers\ConfManager;

use Respect\Validation\Validator as v;

use tgui\Models\Conf_Queries;
use tgui\Models\Conf_Devices;
use tgui\Models\Conf_Models;

use Symfony\Component\Yaml\Yaml;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class ConfManagerHelper
{
  private $cmPath = '/opt/tacacsgui/plugins/ConfigManager';
  public static function init()
  {
    return new ConfManagerHelper();
  }
  public static function checkStatus($value='')
  {
    $message = [];

    if ( !is_dir('/opt/tgui_data/confManager') ) $message[] = 'Is there the main';
    return [ false, $message ];
  }
  public function cmGeneralCheck() {
    if ( ! is_dir ( $this->cmPath ) ) return false;
    try {
      return CMDRun::init()->setCmd( MAINSCRIPT )->setAttr(['run', 'cmd', $this->cmPath . '/cm.py', '-v'])->get();
    } catch (\Exception $e) {
      return false;
    }
		return true;
  }
  public static function forceCommit() {
    ///opt/tacacsgui/plugins/ConfigManager/cm.py --git-commit -c /opt/tgui_data/confManager/config.yaml
		return CMDRun::init()->setCmd( MAINSCRIPT )->setAttr(['run', 'cmd', '/opt/tacacsgui/plugins/ConfigManager/cm.py' , '--git-commit', '-c', '/opt/tgui_data/confManager/config.yaml'])->toBackground()->get();;
  }
  public static function deviceRename($old='unknown',$new='unknown') {
    ///opt/tacacsgui/plugins/ConfigManager/cm.py --git-commit -c /opt/tgui_data/confManager/config.yaml
		CMDRun::init()->setCmd( MAINSCRIPT )->setAttr(['run', 'cmd', '/opt/tacacsgui/plugins/ConfigManager/cm_git.sh' ,
    '--mv-bunch-from='.$old,
    '--mv-bunch-to='.$new,
    ])->get();
    self::forceCommit();
    return true;
  }
  public static function CmInfoStatus()
  {
     return CMDRun::init()->
      setCmd(MAINSCRIPT)->
      setAttr(
        ['run','cmd', '/opt/tacacsgui/plugins/ConfigManager/cm.py', '-c', '/opt/tgui_data/confManager/config.yaml', '--status'])->
      get();
  }
}//END OF CLASS//
