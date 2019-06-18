<?php

namespace tgui\Controllers\MAVIS\MAVISLocal;

use tgui\Models\MAVISLocal;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class MAVISLocalCtrl extends Controller
{
	public static function change_passwd_gui()
	{
		return MAVISLocal::select('change_passwd_gui')->where('change_passwd_gui',1)->count();
	}
################################################
########	MAVIS Local DB Parameters	###############START###########
	#########	GET Local DB Params	#########
	public function getParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'mavis local',
			'action' => 'get params',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['params']=MAVISLocal::select()->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Local DB Params	#########
	public function postParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis local',
			'action' => 'set params',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'enabled' => v::when( v::nullType() , v::alwaysValid(), v::numeric()),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['mavis_local_update'] = MAVISLocal::where([['id','=',1]])->update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'MAVIS', 'obj_id' => 'Local DB', 'section' => 'MAVIS Local DB', 'message' => 701);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS Local DB Parameters	###############END###########
################################################
########	MAVIS Local DB Check	###############START###########
	public function postCheck($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis local',
			'action' => 'check',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'test_username' => v::notEmpty(),
			'test_password' => v::notEmpty()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['test_configuration'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration("\n "));

		$data['check_result']=shell_exec(TAC_ROOT_PATH . '/main.sh check mavis '.$req->getParam('test_username').' '.$req->getParam('test_password').' 2>&1');

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS Local DB Check	###############END###########
}//END OF CLASS//
