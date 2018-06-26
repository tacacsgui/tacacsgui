<?php

namespace tgui\Controllers\APIUpdate;

use tgui\Controllers\Controller;
use tgui\Models\APISettings;

class APIUpdateCtrl extends Controller
{

################################################
	#########	GET Local Info	#########
	public function getInfo($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'update',
			'action' => 'local info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['info']=APISettings::select('update_url', 'update_signin', 'update_key', 'update_activated')->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	GET Global Info	#########
	// public function postInfo($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'post',
	// 		'object' => 'update',
	// 		'action' => 'global info',
	// 	]);
	// 	#check error#
	// 	if ($_SESSION['error']['status']){
	// 		$data['error']=$_SESSION['error'];
	// 		return $res -> withStatus(401) -> write(json_encode($data));
	// 	}
	// 	//INITIAL CODE////END//
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
	// }
	#########	POST Change local Info	#########
	public function postChange($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'update',
			'action' => 'change',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(10))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		switch ( $req->getParam('settings')) {
			case ('1'):
				$data['update_signin'] = $req->getParam('update_signin');

				$data['change_status'] = APISettings::where([['id','=',1]])->update([
					'update_signin' => $data['update_signin']
				]);
				break;
			case ('2'):
				$data['change_status'] = APISettings::where([['id','=',1]])->update([
					'update_key' => $this->generateRandomString(),
					'update_activated' => 0
				]);
 				break;
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	#########	POST Check Update	#########
	public function postCheck($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'update',
			'action' => 'check',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$update = APISettings::select('update_url', 'update_key', 'update_activated')->first();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $update->update_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$update->update_key."&version=".APIVER);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data['output'] = json_decode(curl_exec($ch));

		curl_close($ch);

		if ($data['output'] != null) if (!$update->update_activated) {
			APISettings::where([['id','=',1]])->update([
					'update_activated' => 1
			]);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	#########	POST Upgrade	#########
	public function postUpgrade($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'update',
			'action' => 'upgrade',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(10))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['upgrade'] = shell_exec('git -C '.TAC_ROOT_PATH.' pull origin master');

		return $res -> withStatus(200) -> write(json_encode($data));
	}
} //END OF CLASS
