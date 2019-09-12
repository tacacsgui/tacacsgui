<?php

namespace tgui\Controllers\APIUpdate;

use tgui\Controllers\Controller;
use tgui\Models\APISettings;

use GuzzleHttp\Client as gclient;
use GuzzleHttp\Exception\RequestException;

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

		$data['info']=APISettings::select('update_url', 'update_signin')->first();
		$data['info']['update_key']=$this->uuid_hash();
		$data['info']['update_activated']=$this->activated();
		$data['info']['version']=APIVER;
		$data['slaves'] = [];
		if ( $this->HAGeneral->isMaster() ){
			$data['slaves'] = $this->HAMaster->getSlaves();
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	GET Global Info	#########
	public function postInfoSlave($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'update',
			'action' => 'slave info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$allParams = $req->getParams();
		$ha = new HA();
		$session_params =
    [
      'server_ip' => $allParams['ipaddr'],
      'path' => '/api/ha/update/check/',
      'guzzle_params' => [],
  	  'form_params' =>
			[
				'psk' => $ha->psk(),
				'action' => 'update_info',
				'api_version' => APIVER,
				'revision' => APIREVISION,
				'unique_id' => $allParams['unique_id'],
				'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
			]
    ];
		$data['gclient'] = false;
    $master_response = HA::sendRequest($session_params);
		$data['code'] = $master_response[1];
		$data['slave_ip'] = $allParams['ipaddr'];
		if ($master_response[1] !== 200) return $res -> withStatus(200) -> write(json_encode($data));
		HA::slaveTimeUpdate($allParams['ipaddr']);
		$data['gclient'] = json_decode($master_response[0], true );
		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function postUpgradeSlave($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'update',
			'action' => 'slave upgrade',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$allParams = $req->getParams();
		$ha = new HA();
		$session_params =
    [
      'server_ip' => $allParams['ipaddr'],
      'path' => '/api/ha/update/setup/',
      'guzzle_params' => [],
  	  'form_params' =>
			[
				'psk' => $ha->psk(),
				'action' => 'update',
				'api_version' => APIVER,
				'revision' => APIREVISION,
				'unique_id' => $allParams['unique_id'],
				'sha1_attrs' => ['action', 'psk', 'api_version', 'unique_id']
			]
    ];
		$data['gclient'] = false;
    $master_response = HA::sendRequest($session_params);
		$data['gclient_status'] = $master_response[1];
		$data['gclient_params'] = $session_params;

		if ($master_response[1] !== 200) return $res -> withStatus(200) -> write(json_encode($data));
		HA::slaveTimeUpdate($allParams['ipaddr']);
		$data['gclient'] = json_decode($master_response[0], true );
		return $res -> withStatus(200) -> write(json_encode($data));
	}
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
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
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
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		$update = APISettings::select('update_url')->first();
		$requestParams=[
			'url'=> $update->update_url,
			'guzzle_params'=>[
				'verify'=> false,
				'http_errors'=> false,
				'connect_timeout'=> 7,
				'form_params'=>
				[
					'key'=> [ $this->uuid_hash() ],
					'version' => APIVER,
					'revision' => APIREVISION,
				]
			]
		];
		$gclient = self::sendRequest($requestParams);
		switch (true) {
			case !$gclient:
				$data['output'] = ['error' => ['message'=>'Server Unreachable']];
				break;
			case $gclient[1]!=200:
				$data['output'] = ['error' => ['message'=>'Main Server Error']];
				break;
			case $gclient[1]==200:
				$data['output'] = json_decode($gclient[0], true);
				if ($data['output'] AND $data['output']['error'] AND $data['output']['error']['type']){
					if ($data['output']['error']['type'] == 'not match') file_put_contents(TAC_ROOT_PATH.'/../tgui_data/tgui.key', '');
				}
				if (!$data['output']['error'] AND !$this->activated()) {
					file_put_contents(TAC_ROOT_PATH.'/../tgui_data/tgui.key', $this->uuid_hash());
				}
				break;
			default:
				$data['output'] = ['error' => ['message'=>'Something goes wrong... Is it developer mistake?']];
				break;
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	public static function sendRequest($params=[])
	{
		try {
      $gclient = new gclient();
      $res = $gclient->request('POST', $params['url'], $params['guzzle_params']);
    } catch (RequestException $e) {
      return false;
    }
    return [ $res->getBody()->getContents(), $res->getStatusCode() ];
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
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK Registration//START//
		if( ! $this->activated() )
		{
			$data['error'] = [ 'message' => 'Unregistered Server!'];
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK Registration//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(10))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['upgrade'] = self::gitPull();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	public static function gitPull()
	{
		return shell_exec('git -C '.TAC_ROOT_PATH.'/ pull origin master 2>&1');
	}
} //END OF CLASS
