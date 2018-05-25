<?php

namespace tgui\Controllers\APIUserGrps;

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
################################################
########	Add New User Group	###############START###########
	#########	GET Add New User Group	#########
	public function getUserGroupAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user group',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->apiUserGroupNameAvailable(0),
			'rights' => v::not(v::nullType())->notEmpty()->arrayType(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['default_flag'] = ($req->getParam('default_flag') === true OR $req->getParam('default_flag') === 'true') ? 1 : 0;

		if ($data['default_flag']) APIUserGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);

		$group = APIUserGrps::create([
			'name' => $req->getParam('name'),
			'rights' => $this->rightsToOneValue($req->getParam('rights')),
			'default_flag' => $data['default_flag'],
		]);

		$logEntry=array('action' => 'add', 'objectName' => $group->name, 'objectId' => $group->id, 'section' => 'api user groups', 'message' => 206);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		//$this->auth->check();
		$data['group']=$group;

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

		$data['group']=APIUserGrps::select()->
			where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name')]])->
			first();
		$data['test']=1;

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->apiUserGroupNameAvailable($req->getParam('id')),
			'rights' => v::not(v::nullType())->notEmpty()->arrayType(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['default_flag'] = ($req->getParam('default_flag') === true OR $req->getParam('default_flag') === 'true') ? 1 : 0;

		if ($data['default_flag']) APIUserGrps::where([['default_flag', '=', 1]])->update(['default_flag' => 0]);

		$data['group_update']=APIUserGrps::where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name_old')]])->
			update([
				'name' => $req->getParam('name'),
				'rights' => $this->rightsToOneValue($req->getParam('rights')),
				'default_flag' => $data['default_flag'],
			]);

		$logEntry=array('action' => 'edit', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'api user groups', 'message' => 306);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit User Group	###############END###########
################################################
########	Delete User Group	###############START###########
	#########	GET Delete User Group	#########
	public function getUserGroupDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'user group',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		return $res -> withStatus(200) -> write(json_encode($data));
	}

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(8))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['deleteGroup']=APIUserGrps::where([
			['id','=',$req->getParam('id')],
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'api user groups', 'message' => 306);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

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

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = array(
		// datatable column index  => database column name
			0 => 'id',
			1 => 'name',
			2 => 'rights',
			3 => 'default_flag',
		); //Array of all columnes that will used

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APIUserGrps::select($columns)->
			when($params['columns'][0]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[1],'LIKE','%'.$params['columns'][1]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables
		$data['data']=array();

		foreach($tempData as $group){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="editGroup(\''.$group['id'].'\',\''.$group['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="deleteGroup(\''.$group['id'].'\',\''.$group['name'].'\')">Del</button>';
			$group['buttons'] = $buttons;
			$group['rightsBinary'] = decbin($group['rights']);
			$group['rightsBinaryArray'] = array_reverse ( str_split( decbin($group['rights']) ) );
			array_push($data['data'],$group);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = APIUserGrps::count();
		$data['recordsFiltered'] = APIUserGrps::select($columns)->
			when($params['columns'][0]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'],
				function($query) use ($params,$columns)
				{
					return $query->where($columns[1],'LIKE','%'.$params['columns'][1]['search']['value'].'%');
				}) ->
				count();

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
		[ 'name' => 'Add/Edit/Delete API Users', 'value' => '7'],
		[ 'name' => 'Add/Edit/Delete API User Groups', 'value' => '8'],
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

		///IF GROUPID SET///
		if ($req->getParam('groupId') != null){
			if ($req->getParam('groupId') == 0) {

				if (APIUserGrps::select()->where([['default_flag', '=', 1]])->count() > 0)
				{
					$data['item'] = APIUserGrps::select()->where([['default_flag', '=', 1]])->first();
					$data['item']['text'] = $data['item']['name'];
					$data['item']['default_flag'] = ($data['item']['default_flag'] == 1) ? true : false;
				}
				else
				{
					$data['item']['text'] = 'None';
					$data['item']['id'] = 0;
					$data['item']['default_flag'] = false;
				}
			}
			if ($req->getParam('groupId') > 0)
			{
				$data['item'] = APIUserGrps::select()->
				where([['id', '=', $req->getParam('groupId')]])->
				first();
				$data['item']['text'] = $data['item']['name'];
				//$data['item']['key'] = ($data['item']['key'] != '') ? true : false;
				//$data['item']['enable'] = ($data['item']['enable'] != '') ? true : false;
				$data['item']['default_flag'] = ($data['item']['default_flag'] == 1) ? true : false;
			}
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = APIUserGrps::select(['id','name'])->count();
		$tempData = APIUserGrps::select()->get()->toArray();
		$data['items']=array();
		array_push($data['items'],array('id' => 0, 'text' => 'None', 'default_flag' => false));
		foreach($tempData as $group)
		{
			$group['text'] = $group['name'];
			//unset($group['name']);
			//$group['key'] = ($group['key'] != '') ? true : false;
			//$group['enable'] = ($group['enable'] != '') ? true : false;
			//$group['default_flag'] = ($group['default_flag'] == 1) ? true : false;
			$group['selected'] = ($group['default_flag']) ? true : false;
			array_push($data['items'],$group);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List User Group	###############END###########
################################################
}//END OF CLASS//
