<?php

namespace tgui\Controllers\TAC\TACUsers;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Models\MAVISOTP;
use tgui\Models\TACGlobalConf;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACUsersCtrl extends Controller
{
################################################
	#########	POST Add New User	#########
	public function postUserAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'add',
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
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		//$enable_flag_test = $req->getParam('enable_flag');
		$allParams = $req->getParams();
		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->notEmpty()->userTacAvailable(0)->
				not( v::oneOf(
						v::contains('@'),
						v::contains('='),
						v::contains('*'),
						v::contains('/'),
						v::contains('%'),
						v::contains('$')
					)
				),
			// 'group' => v::noWhitespace(),
			'enable' => v::when( v::oneOf( v::nullType(), v::equals(''), v::loginClone( $req->getParam('enable_flag') ) ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0'), v::equals('4') ) ),
			'pap' => v::when( v::oneOf( v::nullType(), v::equals(''), v::loginClone( $req->getParam('pap_flag') ) ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('pap_flag'))->setName('PAP') ),
			'pap_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0'), v::equals('4') ) ),
			'login' => v::when( v::checkLoginType($req->getParam('login_flag')), v::alwaysValid(), v::noWhitespace()->
					notContainChars()->
					length($policy['tac_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['tac_pw_uppercase'], $allParams['login_flag'])->
					passwdPolicyLowercase($policy['tac_pw_lowercase'], $allParams['login_flag'])->
					passwdPolicySpecial($policy['tac_pw_special'], $allParams['login_flag'])->
					passwdPolicyNumbers($policy['tac_pw_numbers'], $allParams['login_flag'])->
					desRestriction($req->getParam('login_flag'))->setName('Login Password') ),
			'login_flag' => v::noWhitespace()->numeric()->oneOf( v::equals('1'), v::equals('0'), v::equals('3'), v::equals('10'), v::equals('20'), v::equals('30') ),
			'valid_from' => v::when( v::nullType() , v::alwaysValid(), v::date('Y-m-d')->setName('Valid From') ),
			'valid_until' => v::when( v::nullType() , v::alwaysValid(), v::date('Y-m-d')->setName('Valid Until') )
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ( ! empty( $allParams['enable'] ) )
		{
		$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'],  1/*$allParams['enable_encrypt']*/);
		}
		if ( !empty($allParams['login']) )
		{
		$allParams['login'] = $this->encryption( $allParams['login'], $allParams['login_flag'], 1 /*$allParams['login_encrypt']*/ );
		}
		if ( !empty($allParams['pap']) )
		{
		$allParams['pap'] = $this->encryption( $allParams['pap'], $allParams['pap_flag'], 1 /*$allParams['pap_encrypt']*/ );
		}

		// $otp_default = MAVISOTP::select()->first();
		//$nxos_support = TACGlobalConf::select('nxos_support')->first();

		// $allParams['mavis_otp_secret'] = $this->MAVISOTP->secret();
		// $allParams['mavis_otp_period'] = $otp_default->period;
		// $allParams['mavis_otp_digits'] = $otp_default->digits;

		$groups = $allParams['group'];
		$services = $allParams['service'];
		$devices = $allParams['device_list'];
		$devGroups = $allParams['device_group_list'];
		unset($allParams['group']);
		unset($allParams['service']);
		unset($allParams['device_group_list']);
		unset($allParams['device_list']);


		$user = TACUsers::create($allParams);

		$groups_bind = [];
		for ($i=0; $i < count($groups); $i++) {
			$groups_bind[] = ['user_id' => $user->id, 'group_id' => $groups[$i], 'order' => $i];
		}
		$this->db::table('tac_bind_usrGrp')->insert($groups_bind);

		$services_bind = [];
		for ($i=0; $i < count($services); $i++) {
			$services_bind[] = ['tac_usr_id' => $user->id, 'service_id' => $services[$i], 'order' => $i];
		}
		$this->db::table('tac_bind_service')->insert($services_bind);

		$devices_bind = [];
		foreach ($devices as $device) {
			$devices_bind[] = ['user_id' => $user->id, 'device_id' => $device];
		}
		$this->db::table('tac_bind_dev')->insert($devices_bind);

		$devGrps_bind = [];
		foreach ($devGroups as $devGroup) {
			$devGrps_bind[] = ['user_id' => $user->id, 'devGroup_id' => $devGroup];
		}
		$this->db::table('tac_bind_devGrp')->insert($devGrps_bind);

		$data['user']=$user;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'obj_name' => $user['username'], 'obj_id' => $user['id'], 'section' => 'tacacs users', 'message' => 203);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New User	###############END###########
################################################
########	Edit User	###############START###########
	#########	GET Edit User	#########
	public function getUserEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user_tacacs',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['user']=TACUsers::select()->where('id',$req->getParam('id'))->first();
		$data['user']['service'] = $this->db::table('tac_bind_service')->
			leftJoin('tac_services as ts','ts.id','=','service_id')->
			select(['ts.id as id', 'ts.name as text'])->where('tac_usr_id',$req->getParam('id'))->get();
		$data['user']['group']=$this->db::table('tac_bind_usrGrp')->select('group_id')->where('user_id',$req->getParam('id'))->pluck('group_id')->toArray();
		$data['user']['device_list']=$this->db::table('tac_bind_dev')->select('device_id')->where('user_id',$req->getParam('id'))->pluck('device_id')->toArray();
		$data['user']['device_group_list']=$this->db::table('tac_bind_devGrp')->select('devGroup_id')->where('user_id',$req->getParam('id'))->pluck('devGroup_id')->toArray();
		// $data['otp_status']=$this->MAVISOTP->globalStatus();
		// $data['sms_status']=$this->MAVISSMS->globalStatus();
		// $data['user']->login = ( $data['user']->login_flag == 3 ) ? $this->generateRandomString(12) : $data['user']->login;
		// $data['user']->enable = ( $data['user']->enable_flag == 3 ) ? $this->generateRandomString(12) : $data['user']->enable;

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit User	#########
	public function postUserEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'edit',
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
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$allParams = $req->getParams();

		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(),
				v::notEmpty()->userTacAvailable($req->getParam('id'))->
				not( v::oneOf(
						v::contains('@'),
						v::contains('='),
						v::contains('*'),
						v::contains('/'),
						v::contains('%'),
						v::contains('$')
					)
				)
			),
			//'group' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'enable' => v::when( v::oneOf( v::nullType(), v::equals(''), v::loginClone( $req->getParam('enable_flag') ) ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0'), v::equals('4') ) ),
			'login' => v::when( v::oneOf( v::nullType(), v::checkLoginType($req->getParam('login_flag')) ) , v::alwaysValid(), v::noWhitespace()->
					notContainChars()->
					length($policy['tac_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['tac_pw_uppercase'], $allParams['login_flag'])->
					passwdPolicyLowercase($policy['tac_pw_lowercase'], $allParams['login_flag'])->
					passwdPolicySpecial($policy['tac_pw_special'], $allParams['login_flag'])->
					passwdPolicyNumbers($policy['tac_pw_numbers'], $allParams['login_flag'])->
					desRestriction($req->getParam('login_flag'))->setName('Login') ),
			'login_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0'), v::equals('3'), v::equals('10'), v::equals('20'), v::equals('30') ) ),
			'pap' => v::when( v::oneOf( v::nullType(), v::equals(''), v::loginClone( $req->getParam('pap_flag') ) ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('pap_flag'))->setName('PAP') ),
			'pap_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0'), v::equals('4') ) ),
			'mavis_otp_period' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::intVal()->between(30, 120)),
			'mavis_otp_digits' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::intVal()->between(5, 8)),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		if ( ! empty( $allParams['enable'] ) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'],  1/*$allParams['enable_encrypt']*/);
		}
		if ( !empty($allParams['login']) )
		{
			$allParams['login'] = $this->encryption( $allParams['login'], $allParams['login_flag'], 1 /*$allParams['login_encrypt']*/ );
		}
		if ( !empty($allParams['pap']) )
		{
			$allParams['pap'] = $this->encryption( $allParams['pap'], $allParams['pap_flag'], 1 /*$allParams['pap_encrypt']*/ );
		}

		$id = $allParams['id'];

		// unset($allParams['id']);
		// unset($allParams['enable_encrypt']);
		// unset($allParams['login_encrypt']);
		// unset($allParams['pap_encrypt']);
		$groups = $allParams['group'];
		$services = $allParams['service'];
		$devices = $allParams['device_list'];
		$devGroups = $allParams['device_group_list'];
		unset($allParams['service']);
		unset($allParams['group']);
		unset($allParams['device_group_list']);
		unset($allParams['device_list']);


		$data['save']=TACUsers::where('id',$req->getParam('id'))->
			update($allParams);

		$groups_bind = [];
		for ($i=0; $i < count($groups); $i++) {
			$groups_bind[] = ['user_id' => $id, 'group_id' => $groups[$i], 'order' => $i];
		}
		$this->db::table('tac_bind_usrGrp')->where('user_id', $id)->delete();
		$this->db::table('tac_bind_usrGrp')->insert($groups_bind);

		$services_bind = [];
		for ($i=0; $i < count($services); $i++) {
			$services_bind[] = ['tac_usr_id' => $id, 'service_id' => $services[$i], 'order' => $i];
		}
		$this->db::table('tac_bind_service')->where('tac_usr_id', $id)->delete();
		$this->db::table('tac_bind_service')->insert($services_bind);

		$devices_bind = [];
		foreach ($devices as $device) {
			$devices_bind[] = ['user_id' => $id, 'device_id' => $device];
		}
		$this->db::table('tac_bind_dev')->where('user_id', $id)->delete();
		$this->db::table('tac_bind_dev')->insert($devices_bind);

		$devGrps_bind = [];
		foreach ($devGroups as $devGroup) {
			$devGrps_bind[] = ['user_id' => $id, 'devGroup_id' => $devGroup];
		}
		$this->db::table('tac_bind_devGrp')->where('user_id', $id)->delete();
		$this->db::table('tac_bind_devGrp')->insert($devGrps_bind);

		$data['save']=1;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$username = TACUsers::select('username')->where('id',$id)->first();

		$logEntry=array('action' => 'edit', 'obj_name' => $username['username'], 'obj_id' => $id, 'section' => 'tacacs users', 'message' => 303);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit User	###############END###########
################################################
########	Delete User	###############START###########
	#########	GET Delete User	#########
	// public function getUserDelete($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'user_tacacs',
	// 		'action' => 'delete',
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

	#########	POST Delete User	#########
	public function postUserDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'delete',
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
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$user=TACUsers::where('id',$req->getParam('id'))->select('username')->first();
		$data['result']=TACUsers::where('id',$req->getParam('id'))->delete();
		$data['id']=$req->getParam('id');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'obj_name' => $user->username, 'obj_id' => $req->getParam('id'), 'section' => 'tacacs users', 'message' => 403);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete User	###############END###########
################################################
#########	POST CSV User	#########
	public function postUserCsv($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user',
			'action' => 'csv',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$data['clear'] = shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');
		$path = TAC_ROOT_PATH . '/temp/';
		$filename = 'tac_users_'. $this->generateRandomString(8) .'.csv';

		$columns = $this->APICheckerCtrl->getTableTitles('tac_users');

	  $f = fopen($path.$filename, 'w');
		$idList = $req->getParam('idList');
		$array = [];
		$array = ( empty($idList) ) ? TACUsers::select($columns)->get()->toArray() : TACUsers::select($columns)->whereIn('id', $idList)->get()->toArray();

		fputcsv($f, $columns /*, ',)'*/);
	  foreach ($array as $line) {
		fputcsv($f, $line /*, ',)'*/);
	  }

		$data['filename']=$filename;
		sleep(3);
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	CSV User	###############END###########
################################################
########	User Datatables ###############START###########
	#########	POST User Datatables	#########
	public function postUserDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user_tacacs',
			'action' => 'datatables',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4, true))
		{
			$data['data'] = [];
			$data['recordsTotal'] = 0;
			$data['recordsFiltered'] = 0;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$params = $req->getParams(); //Get ALL parameters form Datatables

		$columns = $this->APICheckerCtrl->getTableTitles('tac_users'); //Array of all columnes that will used
		array_unshift( $columns, 'id' );
		array_push( $columns, 'created_at', 'updated_at' );
		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		//Filter end
		$data['recordsTotal'] = TACUsers::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACUsers::select($columns)->
		when( !empty($queries),
			function($query) use ($queries)
			{
				$query->where('username','LIKE', '%'.$queries.'%');
				return $query;
			});
		$data['recordsFiltered'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	User Datatables	###############END###########
################################################
	public function postUserPWChange($req,$res)
	{
		if ( ! $this->MAVISLocal->change_passwd_gui() ) return $res -> withStatus(404) -> write('Access Resticted!');
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user',
			'action' => 'change passwd login',
		]);
		#check error#
		//INITIAL CODE////END//
		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->notEmpty(),
			'password' => v::when(v::equals('1'), v::alwaysValid(), v::notEmpty()->setName('Old Password')),
			'new_password' => v::when(v::equals('1'), v::alwaysValid(), v::notEmpty()->checkPassword($req->getParam('new_password_repeat'))->setName('New Password')),
			'new_password_repeat' => v::when(v::equals('1'), v::alwaysValid(), v::notEmpty()->checkPassword($req->getParam('new_password'))->setName('Repeat New Password')),
			'object' => v::oneOf(v::equals('login'),v::equals('enable')),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$allParams = $req->getParams();
		$user = TACUsers::select()->where([['username','=',$allParams['username']], ['login_flag','=',3]])->orWhere([['username','=',$allParams['username']], ['enable_flag','=',3]])->first();
		$data['success'] = false;
		// $data['test5'] = empty($user);
		// $data['test1'] = ($allParams['object'] == 'login' AND !password_verify($allParams['password'], $user->login) );
		// $data['test4'] = ($allParams['object'] == 'enable' AND !password_verify($allParams['password'], $user->enable) );
		// $data['test2'] = ($allParams['object'] == 'login' AND (!$user->login_change OR $user->login_flag != 3 ));
		// $data['test3'] = ($allParams['object'] == 'enable' AND (!$user->enable_change OR $user->enable_flag != 3 ) );
		if (
			empty($user) OR
			($allParams['object'] == 'login' AND !password_verify($allParams['password'], $user->login) ) OR
			($allParams['object'] == 'enable' AND !password_verify($allParams['password'], $user->enable) ) OR
			($allParams['object'] == 'login' AND (!$user->login_change OR $user->login_flag != 3 ) )OR
			($allParams['object'] == 'enable' AND (!$user->enable_change OR $user->enable_flag != 3 ) )
		){
			$_SESSION['error']['status']=true;
			$_SESSION['error']['message']="Incorrect username or password <br> Do you have rights to change password?";
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$password = '';

		switch ($allParams['object']) {
			case 'login':
				$password = $user->login;
				break;
			case 'enable':
				$password = $user->enable;
				break;
		}

		$validation = $this->validator->validate($req, [
			'new_password' => v::when(v::equals('1'), v::alwaysValid(),
					v::length($policy['tac_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['tac_pw_uppercase'])->
					passwdPolicyLowercase($policy['tac_pw_lowercase'])->
					passwdPolicySpecial($policy['tac_pw_special'])->
					passwdPolicyNumbers($policy['tac_pw_numbers'])->
					passwdPolicySame($policy['tac_pw_same'], $password, 'api')->
					setName('New Password')
			 ),
			'new_password_repeat' => v::when(v::equals('1'), v::alwaysValid(), v::notEmpty()->setName('Repeat New Password')),
			'object' => v::oneOf(v::equals('login'),v::equals('enable')),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['success'] = TACUsers::where('id',$user->id)->update([$allParams['object'] => password_hash($allParams['new_password'], PASSWORD_DEFAULT)]);



		return $res -> withStatus(200) -> write(json_encode($data));
	}
}//END OF CLASS//
