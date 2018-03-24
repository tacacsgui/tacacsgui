<?php

namespace tgui\Controllers\MAVISLDAP;

use tgui\Models\MAVISLDAP;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

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
				//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(11))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$data['mavis_ldap_update'] = MAVISLDAP::where([['id','=',1]])->
			update([
				'enabled' => $req->getParam('enabled'),
				'type' => $req->getParam('ldap_type'),
				'scope' => $req->getParam('ldap_scope'),
				'hosts' => $req->getParam('hosts'),
				'base' => $req->getParam('base'),
				'filter' => $req->getParam('filter'),
				'user' => $req->getParam('user'),
				'password' => $req->getParam('password'),
				'group_prefix' => $req->getParam('group_prefix'),
				'group_prefix_flag' => $req->getParam('group_prefix_flag'),
				'memberOf' => $req->getParam('memberOf'),
				'fallthrough' => $req->getParam('fallthrough'),
				'cache_conn' => $req->getParam('cache_conn'),
				'tls' => $req->getParam('tls'),
				'path' => $req->getParam('path'),
			]);
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'edit', 'objectName' => 'MAVIS', 'objectId' => 'LDAP', 'section' => 'MAVIS LDAP', 'message' => 701);
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
		
		$data['test_configuration'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration("\n "));
		
		$data['ldap_check']=shell_exec(TAC_ROOT_PATH . '/main.sh check tacacs-ldap '.$req->getParam('username').' '.$req->getParam('password').' 2>&1');
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP Check	###############END###########
}//END OF CLASS//