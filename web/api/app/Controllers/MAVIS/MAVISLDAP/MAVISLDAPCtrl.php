<?php

namespace tgui\Controllers\MAVIS\MAVISLDAP;

use tgui\Models\MAVISLDAP;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

use Adldap\Adldap as Adldap;
use Adldap\Schemas\ActiveDirectory as ActiveDirectory;
use Adldap\Schemas\OpenLDAP as OpenLDAP;

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

		$data['params']=MAVISLDAP::select()->first();

		$data['params']['password'] = '***************';//$this->generateRandomString( strlen($data['LDAP_Params']['password']) );

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

		$data['mavis_ldap_update'] = MAVISLDAP::where('id',1)->update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'MAVIS', 'obj_id' => 'LDAP', 'section' => 'MAVIS LDAP', 'message' => 701);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP Parameters	###############END###########
	#########	POST LDAP Search	#########
	public function postLdapSearch($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis ldap',
			'action' => 'search',
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

		$ldap = MAVISLDAP::select()->first();

		$data['results'] = [ [
			'error' => true,
			'text' => '<p class="text-danger">Server Error!</p>',
			] ];

		if ( ! $ldap->enabled ){
			$data['results'][0]['text'] = '<p class="text-danger">LDAP Disabled!</p>';
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$username = ( strpos($ldap->user, '@') !== false ) ? $ldap->user : $ldap->user . '@'.( str_replace( ',', '.', preg_replace('/DC=/i', '', $ldap->base) ) );

		$username = ( $ldap->type == 'openldap' ) ? $ldap->user : $username;

		$config = [
			// Mandatory Configuration Options
			'hosts'            => array_map('trim', explode(',', $ldap->hosts) ),
			'base_dn'          => $ldap->base,
			'username'         => $username,
			'password'         => $ldap->password,
			// Optional Configuration Options
			'schema'           => ( $ldap->type == 'openldap' ) ?\Adldap\Schemas\OpenLDAP::class : \Adldap\Schemas\ActiveDirectory::class,
			'port'             => $ldap->port,
			'use_ssl'          => !!$ldap->ssl,
			'version'          => 3,
			'timeout'          => 5,
		];

		$ad = new Adldap();
		$ad->addProvider($config);

		$data['data'] = [];
		$data['database'] = [
			'errors' => [],
		];

		try {
		    $provider = $ad->connect();
		} catch (\Adldap\Auth\BindException $e) {
				$data['database']['errors'][] = $e->getMessage();
				//var_dump($e); die;
				return $res -> withStatus(200) -> write(json_encode($data));
		}

		$adSearch = $provider->search();

		$search = $req->getParam('searchTerm');
		$pageSize = empty($req->getParam('pageSize')) ? 10 : $req->getParam('pageSize');
		$pageNum = empty($req->getParam('page')) ? 0 : $req->getParam('page') - 1 ;

		$ldapBind = $this->db->table('ldap_groups')->select('cn')->pluck('cn')->toArray();

		if ( $ldap->type == 'openldap' ) {

			$adQuery = $adSearch->select()->orWhere('objectclass', '=', 'posixGroup')->orWhere('objectclass', '=', 'groupOfNames');
			$data['recordsTotal'] =	$adQuery->get()->count();

			$adQuery = ( empty($search) ) ? $adQuery : $adQuery->where('cn', 'contains', $search);
			$data['total'] =	$adQuery->get()->count();

			$records = $adQuery->paginate($pageSize, $pageNum)->getIterator();

			foreach ($records as $record) {
				$reg = '/cn='. ( is_array($record['cn']) ? $record['cn'][0] : $record['cn'] ) .'/i';
				$data['data'][] = [
					'cn' => is_array($record['cn']) ? $record['cn'][0] : $record['cn'],
					'dn' => is_array($record['dn']) ? $record['dn'][0] : $record['dn'],
					// 'regex' => $reg,
					'added' => +!!preg_grep( $reg, $ldapBind),
					'disabled' => +!!preg_grep( $reg, $ldapBind),
				];
			}

		} else {

			$adQuery = $adSearch->groups()->select();
			$data['recordsTotal'] =	$adQuery->get()->count();

			$adQuery = ( empty($search) ) ? $adQuery : $adQuery->where('cn', 'contains', $search);
			$data['total'] =	$adQuery->get()->count();

			$records = $adQuery->paginate($pageSize, $pageNum)->getIterator();

			$data['test1'] = $records;

			foreach ($records as $record) {
				$reg = '/cn='. ( is_array($record['cn']) ? $record['cn'][0] : $record['cn'] ) .'/i';
				$data['data'][] = [
					'cn' => is_array($record['cn']) ? $record['cn'][0] : $record['cn'],
					'dn' => is_array($record['distinguishedname']) ? $record['distinguishedname'][0] : $record['distinguishedname'],
					// 'regex' => $reg,
					'added' => +!!preg_grep( $reg, $ldapBind),
					'disabled' => +!!preg_grep( $reg, $ldapBind),
				];
			}

		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP Search	###############END###########
################################################
########	MAVIS LDAP Bind	###############START###########
	public function postLdapBind($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis ldap',
			'action' => 'bind',
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

		if (!$req->getParam('action')){
			$cn = explode(',', $req->getParam('dn'))[0];
			$this->db->table('ldap_groups')->insert([
				'cn'=>$cn,
				'dn'=> $req->getParam('dn'),
				'created_at' => date('Y-m-d H:i:s', time()),
				'updated_at' => date('Y-m-d H:i:s', time())
			]);
		} else {
			$this->db->table('ldap_groups')->where('dn', $req->getParam('dn'))->delete();
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP Bind	###############END###########
########	MAVIS LDAP Bind	###############START###########
	public function postBindTable($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'mavis ldap',
			'action' => 'bind table',
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

		$data['data'] = [];

		$query = $this->db->table('ldap_groups as lg')->
		select(['lg.*', $this->db::raw('(SELECT COUNT(*) FROM ldap_bind WHERE ldap_id = lg.id) as ref')]);
		$data['total'] = $query->count();
		$search = $req->getParam('searchTerm');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('cn','LIKE', '%'.$search.'%');
				$query->orWhere('dn','LIKE', '%'.$search.'%');
			});

		$data['data']=$query->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getBindRef($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'ldap bind',
			'action' => 'ref',
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

		$data['obj'] = $this->db::table('ldap_groups')->select(['id','cn as text'])->where('id',$req->getParam('id'))->first();
		$data['mainlist'] = [
			[ 'name' => 'TACACS User Groups', 'list' => [] ],
			[ 'name' => 'API User Groups', 'list' => [] ],
		];

		$data['mainlist'][0]['list'] = $this->db::table('ldap_bind as lb')->
		leftJoin('tac_user_groups as tug', 'tug.id', '=', 'lb.tac_grp_id')->
		select(['tug.name as text', 'tug.id as id'])->
		where('lb.ldap_id',$req->getParam('id'))->whereNull('api_grp_id')->get();

		$data['mainlist'][1]['list'] = $this->db::table('ldap_bind as lb')->
		leftJoin('api_user_groups as aug', 'aug.id', '=', 'lb.api_grp_id')->
		select(['aug.name as text', 'aug.id as id'])->
		where('lb.ldap_id',$req->getParam('id'))->whereNull('tac_grp_id')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function postBindDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'ldap bind',
			'action' => 'delete',
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

		$data['result'] = $this->db::table('ldap_groups')->where('id', $req->getParam('id'))->delete();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP Bind	###############END###########
########	MAVIS LDAP Check	###############START###########
	// public function postLDAPCheck($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'post',
	// 		'object' => 'mavis ldap',
	// 		'action' => 'check',
	// 	]);
	// 	#check error#
	// 	if ($_SESSION['error']['status']){
	// 		$data['error']=$_SESSION['error'];
	// 		return $res -> withStatus(401) -> write(json_encode($data));
	// 	}
	// 	//INITIAL CODE////END//
	//
	// 	//CHECK ACCESS TO THAT FUNCTION//START//
	// 	if(!$this->checkAccess(11, true))
	// 	{
	// 		return $res -> withStatus(403) -> write(json_encode($data));
	// 	}
	// 	//CHECK ACCESS TO THAT FUNCTION//END//
	//
	// 	$validation = $this->validator->validate($req, [
	// 		'test_username' => v::notEmpty(),
	// 		'test_password' => v::notEmpty()
	// 	]);
	//
	// 	if ($validation->failed()){
	// 		$data['error']['status']=true;
	// 		$data['error']['validation']=$validation->error_messages;
	// 		return $res -> withStatus(200) -> write(json_encode($data));
	// 	}
	//
	// 	$data['test_configuration'] = $this->TACConfigCtrl->testConfiguration($this->TACConfigCtrl->createConfiguration("\n "));
	//
	// 	$data['check_result']=preg_replace('/PASSWORD\s+.*/i', "PASSWORD\t\t******", shell_exec(TAC_ROOT_PATH . '/main.sh check mavis '.escapeshellarg( $req->getParam('test_username') ).' '.escapeshellarg($req->getParam('test_password')).' 2>&1') );
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
	// }
########	MAVIS LDAP Check	###############END###########
########	MAVIS LDAP List	###############START###########
	public function getLdapList($req,$res)
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
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('id') != null){
			$id = explode(',', $req->getParam('id'));

			$data['results'] = $this->db->table('ldap_groups')->select(['id','cn AS text'])->whereIn('id', $id)->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = $this->db->table('ldap_groups')->select(['id','cn AS text']);
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('cn','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('dn','asc')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	MAVIS LDAP List	###############END###########
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

		$username = ( strpos($allParams['user'], '@') !== false ) ? $allParams['user'] : $allParams['user'] . '@'.( str_replace( ',', '.', preg_replace('/DC=/i', '', $allParams['base']) ) );

		$username = ( $allParams['type'] == 'openldap' ) ? $allParams['user'] : $username;

		$data['test22'] = $allParams;

		$config = [
			// Mandatory Configuration Options
			'hosts'            => array_map('trim', explode(',', $allParams['hosts']) ),
			'base_dn'          => $allParams['base'],
			'username'         => $username,
			'password'         => ( empty(preg_replace('/[\*]+/', '', $allParams['password'])) ) ? $ldap->password : $allParams['password'],
			// Optional Configuration Options
			'schema'           => ( $allParams['type'] == 'openldap' ) ? OpenLDAP::class : ActiveDirectory::class,
			'port'             => intval($allParams['port']),
			'follow_referrals' => false,
			'use_ssl'          => !!$allParams['ssl'],
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
