<?php

namespace tgui\Controllers\TACUserGrps;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACUserGrpsCtrl extends Controller
{
################################################
########	Add New User Group	###############START###########	
	#########	GET Add New User Group	#########
	public function getUserGroupAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'tacacs user group',
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
			'object' => 'tacacs user group',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(5))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->userGroupTacAvailable(),
			'enable' => v::noWhitespace(),
			'enable_flag' => v::noWhitespace()->numeric(),
		]);
		
		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$data['enable']=$req->getParam('enable');
		
		$data['default_service'] = ($req->getParam('default_service') === 'true') ? 1 : 0;
		
		if (isset($data['enable']) AND $req->getParam('enable_encrypt') == 'true')
		{
			if ($req->getParam('enable_flag') == 1)
			{
				$data['enable']=trim(shell_exec('openssl passwd -1 '.$data['enable']));
			} 
			if ($req->getParam('enable_flag') == 2)
			{
				$data['enable']=trim(shell_exec('openssl passwd -crypt '.$data['enable']));
			} 
		} 
		
		$group = TACUserGrps::create([
			'name' => $req->getParam('name'),
			'enable' => $data['enable'],
			'enable_flag' => $req->getParam('enable_flag'),
			'acl' => $req->getParam('acl'),
			'priv-lvl' => $req->getParam('priv-lvl'),
			'message' => $req->getParam('message'),
			'default_service' => $data['default_service'],
			'manual' => $req->getParam('manual'),
		]);
		
		//$this->auth->check();
		$data['group']=$group; 
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'add', 'objectName' => $group['name'], 'objectId' => $group['id'], 'section' => 'tacacs user groups', 'message' => 204);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
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
			'object' => 'tacacs user group',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$data['group']=TACUserGrps::select()->
			where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name')]])->
			first();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	
	#########	POST Edit User Group	#########
	public function postUserGroupEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'tacacs user group',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(5))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->userGroupTacAvailable($req->getParam('id')),
			'enable' => v::noWhitespace(),
			'enable_flag' => v::noWhitespace()->numeric(),
		]);
		
		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$data['enable']=$req->getParam('enable');
		
		$data['default_service'] = ($req->getParam('default_service') === 'true') ? 1 : 0;
		
		if (isset($data['enable']) AND $req->getParam('enable_encrypt') == 'true')
		{
			if ($req->getParam('enable_flag') == 1)
			{
				$data['enable']=trim(shell_exec('openssl passwd -1 '.$data['enable']));
			} 
			if ($req->getParam('enable_flag') == 2)
			{
				$data['enable']=trim(shell_exec('openssl passwd -crypt '.$data['enable']));
			} 
		} 
		
		$data['group_update'] = TACUserGrps::where([['id','=',$req->getParam('id')],['name','=',$req->getParam('name_old')]])->
			update([
			'name' => $req->getParam('name'),
			'enable' => $data['enable'],
			'enable_flag' => $req->getParam('enable_flag'),
			'acl' => $req->getParam('acl'),
			'priv-lvl' => $req->getParam('priv-lvl'),
			'default_service' => $data['default_service'],
			'message' => $req->getParam('message'),
			'manual' => $req->getParam('manual'),
		]);
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'edit', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs user groups', 'message' => 304);
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
			'object' => 'tacacs user group',
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
			'object' => 'tacacs user group',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(5))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		if (TACUsers::where([['group','=',$req->getParam('id')]])->count())
		{
			TACUsers::where([['group','=',$req->getParam('id')]])->update([
				'group' => '0',
			]);
		}
		
		$data['deleteGroup']=TACUserGrps::where([
			['id','=',$req->getParam('id')],
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs user groups', 'message' => 404);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete User	Group###############END###########
################################################
########	User Group Datatables ###############START###########
	#########	POST User Group Datatables	#########
	public function postUserGroupDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'tacacs user group',
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
			2 => 'enable',
			3 => 'enable_flag',
			4 => 'message',
			5 => 'valid_from',
			6 => 'valid_until',
		); //Array of all columnes that will used
		
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACUserGrps::select($columns)->
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
			$group['enable'] = ($group['enable']!== '' AND $group['enable']!== NULL) ? true : false;
			$group['message'] = ($group['message']!== '' AND $group['message']!== NULL) ? true : false;
			array_push($data['data'],$group);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = TACUserGrps::count();
		$data['recordsFiltered'] = TACUserGrps::select($columns)->
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
########	List User Group	###############START###########
	#########	GET List User	Group#########
	public function getUserGroupList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'tacacs user group',
			'action' => 'list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$noneItem = array('id' => 0, 'text' => 'None', 'message' => false, 'enable' => false);
		///IF GROUPID SET///
		if ($req->getParam('groupId') != null){
			if ($req->getParam('groupId') == 0)
			{
				$data['item']=$noneItem;
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			$data['item'] = TACUserGrps::select(['id','name','enable','message'])->
			where([['id', '=', $req->getParam('groupId')]])->
			first();
			
			$data['item']['text'] = $data['item']['name'];
			$data['item']['message'] = ($data['item']['message'] != '') ? true : false;
			$data['item']['enable'] = ($data['item']['enable'] != '') ? true : false;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = TACUserGrps::select(['id','name'])->count();
		$tempData = TACUserGrps::select(['id','name','enable','message'])->get()->toArray();
		$data['items']=array( 0 => $noneItem);
		foreach($tempData as $group)
		{
			$group['text'] = $group['name'];
			$group['message'] = ($group['message'] != '') ? true : false;
			$group['enable'] = ($group['enable'] != '') ? true : false;
			array_push($data['items'],$group);
		}
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List User Group	###############END###########
################################################


}//END OF CLASS//

