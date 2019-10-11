<?php

namespace tgui\Controllers\TAC\TACUsers;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Models\MAVISOTP;
use tgui\Models\TACGlobalConf;
use tgui\Models\APIPWPolicy;
use tgui\Controllers\Controller;
use ParagonIE\ConstantTime\Base32;

use tgui\PHPMailer\EmailEngine;
use tgui\Models\APISMTP;

// use BaconQrCode\Renderer\ImageRenderer;
// use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
// use BaconQrCode\Renderer\RendererStyle\RendererStyle;
// use BaconQrCode\Writer;

use Respect\Validation\Validator as v;

class TACUsersCtrl extends Controller
{

	public function itemValidation($req = [], $state = 'add'){
		$id = 0;
		// $group = 0;
		if (is_object($req)){
			$id = ($state == 'edit') ? $req->getParam('id') : 0;
			$req = $req->getParams();
		}

		$policy = APIPWPolicy::select()->first();

		return $this->validator->validate($req, [
			'username' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\TACUsers', $id, 'username' )->
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
			'enable' => v::when( v::oneOf( v::nullType(), v::equals(''), v::loginClone( $req['enable_flag'] ) ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->setName('Enable') ),
			'enable_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('2'), v::equals('0'), v::equals('4') ) ),
			'pap' => v::when( v::oneOf( v::nullType(), v::equals(''), v::loginClone( $req['pap_flag'] ) ) , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->setName('PAP') ),
			'pap_flag' => v::when( v::nullType() , v::alwaysValid(), v::oneOf( v::equals('1'), v::equals('0'), v::equals('4') ) ),
			'login' => v::when( v::oneOf(v::checkLoginType($req['login_flag']), v::nullType()), v::alwaysValid(), v::noWhitespace()->
					notContainChars()->
					length($policy['tac_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['tac_pw_uppercase'], $allParams['login_flag'])->
					passwdPolicyLowercase($policy['tac_pw_lowercase'], $allParams['login_flag'])->
					passwdPolicySpecial($policy['tac_pw_special'], $allParams['login_flag'])->
					passwdPolicyNumbers($policy['tac_pw_numbers'], $allParams['login_flag'])->setName('Login Password') ),
			'login_flag' => v::noWhitespace()->numeric()->
				oneOf(
					v::equals('1'),
					v::equals('0'),
					v::equals('2'),
					v::equals('3'),
					v::equals('5'),
					v::equals('10'),
					v::equals('12'),
					v::equals('20'),
					v::equals('30')
				),
			'email' => v::when( v::checkLoginType($req['login_flag'], 'email'), v::alwaysValid(), v::notEmpty()->email()->setName('Email') ),
			'valid_from' => v::when( v::nullType() , v::alwaysValid(), v::date('Y-m-d')->setName('Valid From') ),
			'valid_until' => v::when( v::nullType() , v::alwaysValid(), v::date('Y-m-d')->setName('Valid Until') )
		]);

	}

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

		$validation = $this->itemValidation($req);

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
		// if (isset($allParams['mavis_otp_secret']))
		// 	$allParams['mavis_otp_secret'] = trim(Base32::encodeUpper($allParams['mavis_otp_secret']), '=');
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

		if (in_array($allParams['login_flag'], [12, 5])){
			$password = ($allParams['login_flag'] == 12) ? $secret = $this->MAVISOTP::newSecret() : $this->generatePassword();

			$data = $this->passwdSender($data, $user->id, $password, $allParams['email'], $allParams['login_flag']);


			if (!$data['mail'])
				return $res -> withStatus(200) -> write(json_encode($data));

			$data['login_date'] = date('Y-m-d H:i:s',time());

			switch ($allParams['login_flag']) {
				case '12':
					TACUsers::where('id',$user->id)->update([
						'login' => '',
						'login_date' => $data['login_date'],
						'mavis_otp_secret' => $password
					]);
					break;

				default:
					TACUsers::where('id',$user->id)->update([
						'login' => password_hash($password, PASSWORD_DEFAULT),
						'login_date' => $data['login_date']
					]);
					break;
			}
		}

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
		$data['user']->acl = $this->db->table('tac_acl')->
			select(['name as text','id'])->where('id',$data['user']->acl)->get();

		$data['user']['service'] = $this->db::table('tac_bind_service')->
			leftJoin('tac_services as ts','ts.id','=','service_id')->
			select(['ts.id as id', 'ts.name as text'])->where('tac_usr_id',$req->getParam('id'))->get();

		$data['user']['group']=$this->db::table('tac_bind_usrGrp as tbug')->
			leftJoin('tac_user_groups as tug','tug.id','=','tbug.group_id')->
			select(['tug.name as text', 'tug.id as id', 'tug.acl_match as acl_match', $this->db::raw('(SELECT COUNT(*) FROM ldap_bind WHERE tac_grp_id = tug.id) as ldap')])->
			where('tbug.user_id',$req->getParam('id'))->get();

		$data['user']['device_list']=$this->db::table('tac_bind_dev')->
			leftJoin('tac_devices as td','td.id','=','device_id')->
			select(['td.name as text', 'td.id as id'])->where('user_id',$req->getParam('id'))->get();

		$data['user']['device_group_list']=$this->db::table('tac_bind_devGrp')->
			leftJoin('tac_device_groups as tdg','tdg.id','=','devGroup_id')->
			select(['tdg.name as text', 'tdg.id as id'])->where('user_id',$req->getParam('id'))->get();

		if ($data['user']['login_flag'] == 3) unset($data['user']['login']);

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

		$validation = $this->itemValidation($req, 'edit');

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

		// if (isset($allParams['mavis_otp_secret']))
		// 	$allParams['mavis_otp_secret'] = trim(Base32::encodeUpper($allParams['mavis_otp_secret']), '=');

		//$sendEmail = false;
		$oldData = TACUsers::where('id',$req->getParam('id'))->select(['login_flag', 'email'])->first();
		$changes = (
			( in_array($allParams['login_flag'], [12, 5]) ) AND
			($oldData->login_flag != $allParams['login_flag'] OR $oldData->email != $allParams['email'])
		);

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

	if ($changes){
			$password = ($allParams['login_flag'] == 12) ? $secret = $this->MAVISOTP::newSecret() : $this->generatePassword();

			$data = $this->passwdSender($data, $id, $password, $allParams['email'], $allParams['login_flag']);


			if (!$data['mail'])
				return $res -> withStatus(200) -> write(json_encode($data));

			$data['login_date'] = date('Y-m-d H:i:s',time());

			switch ($allParams['login_flag']) {
				case '12':
					TACUsers::where('id',$id)->update([
						'login' => '',
						'login_date' => $data['login_date'],
						'mavis_otp_secret' => $password
					]);
					break;

				default:
					TACUsers::where('id',$id)->update([
						'login' => password_hash($password, PASSWORD_DEFAULT),
						'login_date' => $data['login_date']
					]);
					break;
			}
		}

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
		$user = TACUsers::select()->where([['username','=',$allParams['username']]])->
		//orWhere([['username','=',$allParams['username']], ['enable_flag','=',3]])->
		whereIn('login_flag',[3,5])->
			first();

		$data['success'] = false;
		// $data['test5'] = empty($user);
		// $data['test1'] = ($allParams['object'] == 'login' AND !password_verify($allParams['password'], $user->login) );
		// $data['test4'] = ($allParams['object'] == 'enable' AND !password_verify($allParams['password'], $user->enable) );
		// $data['test2'] = ($allParams['object'] == 'login' AND (!$user->login_change OR $user->login_flag != 3 ));
		// $data['test3'] = ($allParams['object'] == 'enable' AND (!$user->enable_change OR $user->enable_flag != 3 ) );
		$data['user'] = password_verify($allParams['password'], $user->login);
		if (
			empty($user) OR
			($allParams['object'] == 'login' AND !password_verify($allParams['password'], $user->login) ) OR
			($allParams['object'] == 'enable' AND !password_verify($allParams['password'], $user->enable) ) OR
			($allParams['object'] == 'login' AND (!$user->login_change OR !in_array($user->login_flag, [3,5]) ) )OR
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

	public function postSendPasswd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user',
			'action' => 'send passwd login',
		]);
		#check error#
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

		//$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'id' => v::noWhitespace()->notEmpty()->numeric(),
			'flag' => v::noWhitespace()->notEmpty()->numeric(),
			'email' => v::notEmpty()->email(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$allParams = $req->getParams();
		$id = $allParams['id'];

		$password = ($allParams['flag'] == 12) ? $secret = $this->MAVISOTP::newSecret() : $this->generatePassword();

		$data = $this->passwdSender($data, $id, $password, $allParams['email'], $allParams['flag']);


		if (!$data['mail'])
			return $res -> withStatus(200) -> write(json_encode($data));

		$data['login_date'] = date('Y-m-d H:i:s',time());

		switch ($allParams['flag']) {
			case '12':
				TACUsers::where('id',$id)->update([
					'login' => '',
					'login_date' => $data['login_date'],
					'email' => $allParams['email'],
					'mavis_otp_secret' => $password
				]);
				break;

			default:
				TACUsers::where('id',$id)->update([
					'login' => password_hash($password, PASSWORD_DEFAULT),
					'login_date' => $data['login_date'],
					'email' => $allParams['email']
				]);
				break;
		}

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	private function passwdSender($data = [], $uid = 0, $password = '', $email = '', $flag = 5){

		$user = TACUsers::where('id', $uid)->select()->first();

		$variables = [
			'subject' => 'TACACSGUI New Credential',
			'username' => $user->username,
		];

		$template = 'newpw';

		if (file_exists('/opt/tacacsgui/temp/qrcode_.png'))
			unlink('/opt/tacacsgui/temp/qrcode_.png');

		switch ($flag) {
			case '12':
				$variables['qr'] = '/opt/tacacsgui/temp/qrcode_.png';
				$renderer = new \BaconQrCode\Renderer\Image\Png();
				$renderer->setHeight(256);
				$renderer->setWidth(256);
				$writer = new \BaconQrCode\Writer($renderer);

				$writer->writeFile($this->MAVISOTP::getUrl($user->username, $password), $variables['qr']);
				$template = 'newqr';
				break;

			default:

				$variables['password'] = $password;
				TACUsers::where('id',$uid)->update([
					'login' => password_hash($variables['password'], PASSWORD_DEFAULT),
				]);
				break;
		}

		$mail = new EmailEngine(APISMTP::select()->find(1));
		$data['mail'] = $mail->addAddress($email)->setTemplate($template, $variables)->send(true);
		return $data;
	}
}//END OF CLASS//
