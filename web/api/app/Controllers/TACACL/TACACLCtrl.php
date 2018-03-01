<?php

namespace tgui\Controllers\TACACL;

use tgui\Models\TACACL;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACACLCtrl extends Controller
{
################################################
########	Add New ACL	###############START###########	
	#########	GET Add New ACL	#########
	public function getACLAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'acl',
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
	
	#########	POST Add New ACL	#########
	public function postACLAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'acl',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(10))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->aclNameAvailable(),
		]);
		
		$ACEs=$req->getParam('ACEs');
		
		$data['error']['validation']['ACEs']=null;
		
		if ($validation->failed() OR count($ACEs) < 2){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			if (count($ACEs) < 2) $data['error']['validation']['ACEs'][0]='You should add at least one entry';
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$acl = array();
		$acl[0] = TACACL::create($ACEs[0]);
		
		$aclName=$acl[0]->name;$aclId=$acl[0]->id;
		
		unset($ACEs[0]);
		
		foreach ($ACEs as $ACE)
		{
			$ACE['name']=$aclName;
			array_push($data['ace'],TACACL::create($ACE));
		}
		
		$data['acl']=$acl; 
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'add', 'objectName' => $aclName, 'objectId' => $aclId, 'section' => 'tacacs acl', 'message' => 207);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New ACL	###############END###########	
################################################
########	Edit ACL	###############START###########
	#########	GET Edit ACL	#########
	public function getACLEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'acl',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		
		$data['data']=array();
		$data['recordsTotal'] = 0;
		$data['recordsFiltered'] = 0;
		$data['draw'] = 1;
		
		if ($req->getParam('action') == 'getACEs') unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//
		
		$tempData = TACACL::select()->where([['line_number','<>', 0],['name','=', $req->getParam('name') ]])->
			
			orderBy('line_number','asc')->
			get()->toArray();
		//Creating correct array of answer to Datatables 
		$data['data']=array();
		foreach($tempData as $acl){
			$buttons='<div class="btn-group text-center">'.
		'<button type="button" class="btn btn-default" onclick="moveRow(event, \'down\',\'editForm\')"><i class="fa fa-caret-down"></i></button>'.
		'<button type="button" class="btn btn-default" onclick="moveRow(event, \'up\',\'editForm\')"><i class="fa fa-caret-up"></i></button>'.
		'<button type="button" class="btn btn-warning" onclick="editRow(event,\'editForm\')"><i class="fa fa-edit"></i></button>'.
		'<button type="button" class="btn btn-danger" onclick="deleteRow(event,\'editForm\')"><i class="fa fa-trash"></i></button>'.
		'</div>';
			$acl['buttons'] = $buttons;
			array_push($data['data'],$acl);
		}
		//Some additional parameters for Datatables
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	
	#########	POST Edit ACL	#########
	public function postACLEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'acl',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(10))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->aclNameAvailable($req->getParam('id')),
		]);
		
		$ACEs=$req->getParam('ACEs');
		
		if ($validation->failed() OR count($ACEs) < 2){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			if (count($ACEs) < 2) $data['error']['validation']['ACEs'][0]='You should add at least one entry';
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		if ($req->getParam('name') != $req->getParam('name_old')){
			TACACL::where([['name','=',$req->getParam('name_old')]])->
			update(['name' => $req->getParam('name')]);
		}
		
		unset($ACEs[0]);
		
		$data['ace']=array();
		
		foreach ($ACEs as $ACE)
		{
			$ACE['name']=$req->getParam('name');
			if (!empty($ACE['id'])) { array_push($data['ace'],$ACE); $aceId=$ACE['id']; unset($ACE['id']); TACACL::where([['id','=',$aceId]])->
			update($ACE);}
			else {
				array_push($data['ace'],TACACL::create($ACE));
			}
			
		}
		
		$deleted_aces=$req->getParam('deleted_aces');
		
		if (count($deleted_aces)>0) TACACL::whereIn('id',$deleted_aces)->delete();
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'edit', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs acl', 'message' => 307);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit ACL	###############END###########
################################################
########	Delete ACL	###############START###########
	#########	GET Delete ACL	#########
	public function getACLDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'acl',
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
	
	#########	POST Delete ACL	#########
	public function postACLDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'acl',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(10))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$data['deleteACL']=TACACL::where([
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');
		
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
		
		$logEntry=array('action' => 'delete', 'objectName' => $req->getParam('name'), 'objectId' => $req->getParam('id'), 'section' => 'tacacs acl', 'message' => 407);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete ACL	###############END###########
################################################
########	ACL Datatables ###############START###########
	#########	POST ACL Datatables	#########
	public function postACLDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'acl',
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
		); //Array of all columnes that will used
		
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACACL::select()->where([['line_number','=', 0]])->
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
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables 
		$data['data']=array();
		foreach($tempData as $acl){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="editACL(\''.$acl['id'].'\',\''.$acl['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="deleteACL(\''.$acl['id'].'\',\''.$acl['name'].'\')">Del</button>';
			$acl['buttons'] = $buttons;
			array_push($data['data'],$acl);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = TACACL::where([['line_number','=', 0]])->count();
		$data['recordsFiltered'] = TACACL::select()->where([['line_number','=', 0]])->
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
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) -> 
				count();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	
########	ACL Datatables	###############END###########
################################################

}//END OF CLASS//