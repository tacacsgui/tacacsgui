<?php

namespace tgui\Controllers\TACUsers;

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
########	Add New User	###############START###########
	#########	GET Add New User	#########
	// public function getUserAdd($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'user_tacacs',
	// 		'action' => 'add',
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
		//CHECK SERVER ROLE SLAVE//START//
		if( $this->isSlaveHA() )
		{
			$data['message'] = $this->isSlaveHA('message');
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SERVER ROLE SLAVE//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->notEmpty()->userTacAvailable(0),
			'group' => v::noWhitespace(),
			'enable' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::noWhitespace()->numeric(),
			'pap' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('pap_flag'))->setName('PAP') ),
			'pap_flag' => v::noWhitespace()->numeric(),
			'login' => v::noWhitespace()->
					notContainChars()->
					length($policy['tac_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['tac_pw_uppercase'])->
					passwdPolicyLowercase($policy['tac_pw_lowercase'])->
					passwdPolicySpecial($policy['tac_pw_special'])->
					passwdPolicyNumbers($policy['tac_pw_numbers'])->
					desRestriction($req->getParam('login_flag')),
			'login_flag' => v::noWhitespace()->numeric(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ( (!empty($allParams['enable']) AND (@$allParams['enable_encrypt'] == 1)) AND (intval( @$allParams['enable_flag'] ) !== 0) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'] );
		}
		if ( (!empty($allParams['login']) AND (@$allParams['login_encrypt'] == 1)) AND (intval( @$allParams['login_flag'] ) !== 0) )
		{
			$allParams['login'] = $this->encryption( $allParams['login'], $allParams['login_flag'] );
		}
		if ( (!empty($allParams['pap']) AND (@$allParams['pap_encrypt'] == 1)) AND (intval( @$allParams['pap_flag'] ) !== 0) )
		{
			$allParams['pap'] = $this->encryption( $allParams['pap'], $allParams['pap_flag'] );
		}

		$otp_default = MAVISOTP::select()->first();
		//$nxos_support = TACGlobalConf::select('nxos_support')->first();

		$allParams['mavis_otp_secret'] = $this->MAVISOTP->secret();
		$allParams['mavis_otp_period'] = $otp_default->period;
		$allParams['mavis_otp_digits'] = $otp_default->digits;

		$user = TACUsers::create($allParams);

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

		$data['user']=TACUsers::select()->
			where([['id','=',$req->getParam('id')],['username','=',$req->getParam('username')]])->
			first();
		$data['otp_status']=$this->MAVISOTP->globalStatus();
		$data['sms_status']=$this->MAVISSMS->globalStatus();

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$policy = APIPWPolicy::select()->first(1);
		$validation = $this->validator->validate($req, [
			'username' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::notEmpty()->userTacAvailable($req->getParam('id'))),
			'group' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'enable' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('enable_flag'))->setName('Enable') ),
			'enable_flag' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'login' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->
					notContainChars()->
					length($policy['tac_pw_length'], 64)->
					notEmpty()->
					passwdPolicyUppercase($policy['tac_pw_uppercase'])->
					passwdPolicyLowercase($policy['tac_pw_lowercase'])->
					passwdPolicySpecial($policy['tac_pw_special'])->
					passwdPolicyNumbers($policy['tac_pw_numbers'])->
					desRestriction($req->getParam('login_flag'))->setName('Login') ),
			'login_flag' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'pap' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notContainChars()->
				length($policy['tac_pw_length'], 64)->
				notEmpty()->
				passwdPolicyUppercase($policy['tac_pw_uppercase'])->
				passwdPolicyLowercase($policy['tac_pw_lowercase'])->
				passwdPolicySpecial($policy['tac_pw_special'])->
				passwdPolicyNumbers($policy['tac_pw_numbers'])->
				desRestriction($req->getParam('pap_flag'))->setName('PAP') ),
			'pap_flag' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()),
			'mavis_otp_period' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::intVal()->between(30, 120)),
			'mavis_otp_digits' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::intVal()->between(5, 8)),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		if ( (!empty($allParams['enable']) AND (@$allParams['enable_encrypt'] == 1)) AND (intval( @$allParams['enable_flag'] ) !== 0) )
		{
			$allParams['enable'] = $this->encryption( $allParams['enable'], $allParams['enable_flag'] );
		}
		if ( (!empty($allParams['login']) AND (@$allParams['login_encrypt'] == 1)) AND (intval( @$allParams['login_flag'] ) !== 0) )
		{
			$allParams['login'] = $this->encryption( $allParams['login'], $allParams['login_flag'] );
		}
		if ( (!empty($allParams['pap']) AND (@$allParams['pap_encrypt'] == 1)) AND (intval( @$allParams['pap_flag'] ) !== 0) )
		{
			$allParams['pap'] = $this->encryption( $allParams['pap'], $allParams['pap_flag'] );
		}

		$id = $allParams['id'];

		unset($allParams['id']);
		unset($allParams['enable_encrypt']);
		unset($allParams['login_encrypt']);
		unset($allParams['pap_encrypt']);

		$data['user_update']=TACUsers::where([['id','=',$req->getParam('id')]])->
			update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$username = TACUsers::select('username')->where([['id','=',$id]])->first();

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(4))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=TACUsers::where([
			['id','=',$req->getParam('id')],
			['username','=',$req->getParam('username')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['username']=$req->getParam('username');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('username'), 'obj_id' => $req->getParam('id'), 'section' => 'tacacs users', 'message' => 403);
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
		$queries = [];
		$data['filter'] = [];
		$data['filter']['error'] = false;
		$data['filter']['message'] = '';
		//Filter start
		$searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
		$temp = $this->queriesMaker($columns, $searchString);
		$queries = $temp['queries'];
		$data['filter'] = $temp['filter'];

		$data['queries'] = $queries;
		$data['columns'] = $columns;
		//Filter end
		$data['recordsTotal'] = TACUsers::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACUsers::select($columns)->
			when( !empty($queries),
				function($query) use ($queries)
				{
					foreach ($queries as $condition => $attr) {
						switch ($condition) {
							case '!==':
								foreach ($attr as $column => $value) {
									$query->whereNotIn($column, $value);
								}
								break;
							case '==':
								foreach ($attr as $column => $value) {
									$query->whereIn($column, $value);
								}
								break;
							case '!=':
								foreach ($attr as $column => $valueArr) {
									for ($i=0; $i < count($valueArr); $i++) {
										if ($i == 0) $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
										$query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
									}
								}
								break;
							case '=':
								foreach ($attr as $column => $valueArr) {
									for ($i=0; $i < count($valueArr); $i++) {
										if ($i == 0) $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
										$query->where($column,'LIKE', '%'.$valueArr[$i].'%');
									}
								}
								break;
							default:
								//return $query;
								break;
						}
					}
					return $query;
				});
			$data['recordsFiltered'] = $tempData->count();
			$tempData = $tempData->
			orderBy($params['columns'][$params['order'][0]['column']]['data'],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();

		//Creating correct array of answer to Datatables
		$data['data']=array();

		$tempGroups = TACUserGrps::select('id','name','enable','message')->get()->toArray();

		foreach($tempGroups as $group){

			$messageExist = ($group['message']!== '') ? true : false;
			$enableExist = ($group['enable']!== '') ? true : false;
			$tempGroupsNew[$group['id']] = array('name' => $group['name'], 'message' => $messageExist, 'enable' => $enableExist);
		}

		foreach($tempData as $user){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_tacUser.getUserInfo(\''.$user['id'].'\',\''.$user['username'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_tacUser.delete(\''.$user['id'].'\',\''.$user['username'].'\')">Del</button>';
			$grpID = $user['group'];
			$user['group'] = (empty($tempGroupsNew[$grpID]['name'])) ? null : $tempGroupsNew[$grpID]['name'];
			$user['groupMessage'] = (empty($tempGroupsNew[$grpID]['message'])) ? null : $tempGroupsNew[$grpID]['message'];
			$user['groupEnable']=(empty($tempGroupsNew[$grpID]['enable'])) ? null : $tempGroupsNew[$grpID]['enable'];
			$user['enable']=($user['enable']!== '' AND $user['enable']!== NULL) ? true : false;
			$user['message']=($user['message']!== '' AND $user['message']!== NULL) ? true : false;
			$user['buttons']=$buttons;
			array_push($data['data'],$user);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	User Datatables	###############END###########
################################################

}//END OF CLASS//
