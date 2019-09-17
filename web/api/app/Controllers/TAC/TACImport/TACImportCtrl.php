<?php
namespace tgui\Controllers\TAC\TACImport;

use tgui\Controllers\Controller;

use Respect\Validation\Validator as v;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class TACImportCtrl extends Controller
{
  public function postFile($req,$res)
  {
  	//INITIAL CODE////START//
  	$data=array();
  	$data=$this->initialData([
  		'type' => 'post',
  		'object' => 'import',
  		'action' => 'file',
  	]);
  	#check error#
  	if ($_SESSION['error']['status']){
  		$data['error']=$_SESSION['error'];
  		return $res -> withStatus(401) -> write(json_encode($data));
  	}
  	//INITIAL CODE////END//
    //CHECK ACCESS TO THAT FUNCTION//START//
    if(!$this->checkAccess(1))
    {
      return $res -> withStatus(403) -> write(json_encode($data));
    }
    //CHECK ACCESS TO THAT FUNCTION//END//
    shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');

    foreach ($_FILES as $key => $value) {
			$data['name'] = $_FILES[$key]['name'];
			$data['path'] = $_FILES[$key]['tmp_name'];
		}

    if (!v::readable()->size(null, '5MB')->validate($data['path'])){
      $data['error']['status']=true;
			$data['error']['validation']=['file' => ['Incorrect file!']];
			return $res -> withStatus(200) -> write(json_encode($data));
    }



    return $res -> withStatus(200) -> write(json_encode($data));
  }

}
