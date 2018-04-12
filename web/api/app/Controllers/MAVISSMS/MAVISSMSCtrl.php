<?php

namespace tgui\Controllers\MAVISSMS;

use tgui\Models\TACUsers;
use tgui\Models\MAVISSMS;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class MAVISSMSCtrl extends Controller
{
	public function globalStatus()
	
	{
		return MAVISSMS::select('enabled')->first()->enabled;
	}
################################################
########	MAVIS SMS Parameters GET	###############START###########
	public function getSMSParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'mavis sms',
			'action' => 'parameters',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['SMS_Params']=MAVISSMS::select()->first();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Parameters GET	###############END###########
################################################
########	MAVIS SMS Parameters POST	###############START###########
	public function postSMSParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis sms',
			'action' => 'parameters',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->validator->validate($req, [
			'port' => v::noWhitespace()->intVal(),
		]);
		
		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$data['mavis_sms_update'] = MAVISSMS::where([['id','=',1]])->
			update([
				'enabled' => $req->getParam('enabled'),
				'port' => $req->getParam('port'),
				'ipaddr' => $req->getParam('ipaddr'),
				'login' => $req->getParam('login'),
				'pass' => $req->getParam('pass'),
				'srcname' => $req->getParam('srcname'),
			]);
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'edit', 'objectName' => 'MAVIS', 'objectId' => 'SMS', 'section' => 'MAVIS SMS', 'message' => 703);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Parameters POST	###############END###########
################################################
########	MAVIS SMS Send	###############START###########
	public function postSMSSend($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis sms',
			'action' => 'send',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$username = $req->getParam('username');
		$number = $req->getParam('number');
		
		if ($username !== null AND $username !== '')
		{
			$number = TACUsers::select('mavis_sms_number')->where([['username', '=', $username]])->first()->mavis_sms_number;
			if ($number == null)
			{
				$data['smpp_check']='Number for username '. $username . ' not found';
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			$data['number']=$number;
		} elseif ( $number !== null) {
			$data['number']=$number;
			$username = '';
		} else {
			$data['smpp_check']='Username or Number do not set';
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$link = "/main.sh check smpp-client 'number' ".
			'"'.$req->getParam('ipaddr').'" '.
			'"'.$req->getParam('port').'" '.
			'"true" '.
			'"'.$req->getParam('login').'" '.
			'"'.$req->getParam('pass').'" '.
			'"'.$req->getParam('srcname').'" '.
			'"'.$number.'" '.
			'"'.$username.'" '.
			' 2>&1';
		
		$data['link']=$link;
		
		$data['smpp_check']=shell_exec(TAC_ROOT_PATH . $link);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Send	###############END###########
########	MAVIS SMS Check	###############START###########
	public function postSMSCheck($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis sms',
			'action' => 'check',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS SMS Check	###############END###########
}//END OF CLASS//