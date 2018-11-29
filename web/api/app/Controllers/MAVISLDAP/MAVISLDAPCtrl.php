<?php

namespace tgui\Controllers\MAVISLDAP;

use tgui\Models\MAVISLDAP;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

use Adldap\Adldap as Adldap;
use Adldap\Schemas\ActiveDirectory as ActiveDirectory;

class MAVISLDAPCtrl extends Controller
{
################################################
########	MAVIS LDAP Parameters	###############START###########
	#########	GET LDAP Params	#########
	public function getLDAPParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'mavis ldap',
			'action' => 'get params',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['LDAP_Params']=MAVISLDAP::select()->first();

		$data['LDAP_Params']['password'] = '***************';//$this->generateRandomString( strlen($data['LDAP_Params']['password']) );

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST LDAP Params	#########
	public function postLDAPParams($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis ldap',
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
		if(!$this->checkAccess(11))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'user' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'password' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'hosts' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'path' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'enabled' => v::when( v::nullType() , v::alwaysValid(), v::numeric()),
			'password_hide' => v::when( v::nullType() , v::alwaysValid(), v::numeric())
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['mavis_ldap_update'] = MAVISLDAP::where([['id','=',1]])->update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'MAVIS', 'obj_id' => 'LDAP', 'section' => 'MAVIS LDAP', 'message' => 701);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP Parameters	###############END###########
################################################
########	MAVIS LDAP Check	###############START###########
	public function postLDAPCheck($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis ldap',
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
########	MAVIS LDAP Check	###############END###########
########	LDAP Test	###############START###########
	public function postTest($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis ldap',
			'action' => 'test',
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

		$data['test'] = false;

		$allParams = $req->getParams();

		$ldap = MAVISLDAP::select()->first();

		$config = [
			// Mandatory Configuration Options
			'hosts'            => array_map('trim', explode(',', $allParams['hosts']) ),
			'base_dn'          => $allParams['base'],
			'username'         => ( strpos($allParams['user'], '@') !== false ) ? $allParams['user'] : $allParams['user'] . '@'.( str_replace( ',', '.', preg_replace('/DC=/i', '', $allParams['base']) ) ),
			'password'         => ( empty(preg_replace('/[\*]+/', '', $allParams['password'])) ) ? $ldap->password : $allParams['password'],
			// Optional Configuration Options
			'schema'           => ActiveDirectory::class,
			'port'             => intval($allParams['port']),
			'follow_referrals' => false,
			'use_ssl'          => false,
			'use_tls'          => false,
			'version'          => 3,
			'timeout'          => 5,
		];

		$ad = new Adldap();

		$ad->addProvider($config);

		try {
		    $provider = $ad->connect();
		} catch (\Adldap\Auth\BindException $e) {
				$data['test'] = 1;
				$data['exception'] = $e->getMessage();
				//var_dump($e); die;
				return $res -> withStatus(200) -> write(json_encode($data));
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	LDAP Test	###############END###########
}//END OF CLASS//
