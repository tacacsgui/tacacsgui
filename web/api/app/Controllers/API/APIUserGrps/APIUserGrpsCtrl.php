<?php

namespace tgui\Controllers\API\APIUserGrps;

use tgui\Models\APIUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class APIUserGrpsCtrl extends Controller
{
	private function rightsToOneValue($array)
	{
		$return=0;
		for ($i=0; $i < count($array); $i++)
		{
			$return+=pow(2, $array[$i]);
		}
		return $return;
	}
###############################################
	#########	POST Add New User Group	#########
	public function postUserGroupAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user group',
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
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\APIUserGrps' ),
			'rights' => v::numeric()->notEmpty()->min(1),//->arrayType(),//->adminRights(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$ldapGroups = $allParams['ldap_groups'];
		unset($allParams['ldap_groups']);

		// if ($allParams['default_flag']) APIUserGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);
		//
		// $allParams['rights'] = $this->rightsToOneValue($allParams['rights']);

		$data['group'] = APIUserGrps::create($allParams);

		$ldap_bind = [];
		foreach ($ldapGroups as $ldapGroup) {
			$ldap_bind[] = ['api_grp_id' => $data['group']->id, 'ldap_id' => $ldapGroup];
		}
		$this->db::table('ldap_bind')->insert($ldap_bind);

		$logEntry=array('action' => 'add', 'obj_name' => $data['group']->name, 'obj_id' => $data['group']->id, 'section' => 'api user groups', 'message' => 206);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['backup_status'] = $this->APIBackupCtrl->apicfgSet();
		if ( $this->APIBackupCtrl->apicfgSet() )
		$data['backup'] = $this->APIBackupCtrl->makeBackup(['make' => 'apicfg']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New User Group	###############END###########
################################################
########	Edit User Group	###############START###########
	#########	GET Edit User Group	#########
	public function getUserGroupEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user group',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['group']=APIUserGrps::select()->
			where('id',$req->getParam('id'))->
			first();

		$data['group']['ldap_groups']=$this->db::table('ldap_bind')->
			leftJoin('ldap_groups as ld','ld.id','=','ldap_id')->
			select(['ld.cn as text', 'ld.id as id'])->where('api_grp_id',$req->getParam('id'))->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit User Group	#########
	public function postUserGroupEdit($req,$res)
	{

		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user group',
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
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\APIUserGrps', $req->getParam('id') ),
			'rights' => v::numeric()->notEmpty()->min(1),
			'id' => v::numeric()->notEmpty()->min(1),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$ldapGroups = $allParams['ldap_groups'];
		unset($allParams['ldap_groups']);

		// if ($allParams['default_flag']) APIUserGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);
		// $id = $allParams['id'];
		// unset($allParams['id']);
		// $allParams['rights'] = $this->rightsToOneValue($allParams['rights']);
		$id = $allParams['id'];
		$data['save']=APIUserGrps::where('id',$id)->
			update($allParams);

		$ldap_bind = [];
		foreach ($ldapGroups as $ldapGroup) {
			$ldap_bind[] = ['api_grp_id' => $id, 'ldap_id' => $ldapGroup];
		}
		$this->db::table('ldap_bind')->where('api_grp_id', $id)->delete();
		$this->db::table('ldap_bind')->insert($ldap_bind);

		$data['save'] = 1;

		$name = $allParams['name'];

		$logEntry=array('action' => 'edit', 'obj_name' => $name, 'obj_id' => $id, 'section' => 'api user groups', 'message' => 306);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['backup_status'] = $this->APIBackupCtrl->apicfgSet();
		if ( $this->APIBackupCtrl->apicfgSet() )
		$data['backup'] = $this->APIBackupCtrl->makeBackup(['make' => 'apicfg']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit User Group	###############END###########
################################################
########	Delete User Group	###############START##########
	#########	POST Delete User Group	#########
	public function postUserGroupDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user group',
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
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=APIUserGrps::where('id',$req->getParam('id'))->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'api user groups', 'message' => 306);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['backup_status'] = $this->APIBackupCtrl->apicfgSet();
		if ( $this->APIBackupCtrl->apicfgSet() )
		$data['backup'] = $this->APIBackupCtrl->makeBackup(['make' => 'apicfg']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete User Group	###############END###########
################################################
########	User Group Datatables ###############START###########
	#########	POST User Group Datatables	#########
	public function postUserGroupDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user group',
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
		if(!$this->checkAccess(8, true))
		{
			$data['data'] = [];
			$data['recordsTotal'] = 0;
			$data['recordsFiltered'] = 0;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = $this->APICheckerCtrl->getTableTitles('api_user_groups'); //Array of all columnes that will used
		array_unshift( $columns, 'id' );
		array_push( $columns, 'created_at', 'updated_at' );
		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		//Filter end
		$data['recordsTotal'] = APIUserGrps::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APIUserGrps::select($columns)->
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

########	User Group Datatables	###############END###########
################################################
########	User Group Rights List ###############START###########
	private $rightsList=array(
		[ 'name' => 'DEMO (just view all)', 'value' => '0'],
		[ 'name' => 'Administrator', 'value' => '1'],
		[ 'name' => 'Add/Edit/Delete Tac Devices', 'value' => '2'],
		[ 'name' => 'Add/Edit/Delete Tac Device Groups', 'value' => '3'],
		[ 'name' => 'Add/Edit/Delete Tac Users', 'value' => '4'],
		[ 'name' => 'Add/Edit/Delete Tac User Groups', 'value' => '5'],
		[ 'name' => 'Edit/Apply/Test Tac Configuration', 'value' => '6'],
		// [ 'name' => 'Add/Edit/Delete API Users', 'value' => '7'],
		// [ 'name' => 'Add/Edit/Delete API User Groups', 'value' => '8'],
		[ 'name' => 'Add/Edit/Delete Object Addresses', 'value' => '14'],
		[ 'name' => 'Delete/Restore Backups', 'value' => '9'],
		[ 'name' => 'Upgrade API', 'value' => '10'],
		[ 'name' => 'MAVIS', 'value' => '11'],
		[ 'name' => 'Add/Edit/Delete Tac ACL', 'value' => '12'],
		[ 'name' => 'Add/Edit/Delete Tac Services', 'value' => '13'],
	);
	#########	POST User Group 	#########
	public function postUserGroupRightsList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'user group rights',
			'action' => 'list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['rights']=$this->rightsList;

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	User Group Rights List	###############END###########
################################################
########	List User Group	###############START###########
	#########	GET List User	Group#########
	public function getUserGroupList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user group',
			'action' => 'list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(8, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('id') != null){
			$id = explode(',', $req->getParam('id'));

			$data['results'] = APIUserGrps::select(['id','name AS text'])->whereIn('id', $id)->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = APIUserGrps::select(['id','name as text']);
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('name','asc')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List User Group	###############END###########
################################################
}//END OF CLASS//
