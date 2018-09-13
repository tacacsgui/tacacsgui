<?php

namespace tgui\Controllers\TACACL;

use tgui\Models\TACACL;
use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACACLCtrl extends Controller
{
################################################
########	Add New ACL	###############START###########
	// #########	GET Add New ACL	#########
	// public function getACLAdd($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'acl',
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
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(12))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->aclNameAvailable(0),
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

		$logEntry=array('action' => 'add', 'obj_name' => $aclName, 'obj_id' => $aclId, 'section' => 'tacacs acl', 'message' => 207);
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

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(12))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//
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
		'<button type="button" class="btn btn-default" onclick="tgui_acl.ace.move(this, \'down\')"><i class="fa fa-caret-down"></i></button>'.
		'<button type="button" class="btn btn-default" onclick="tgui_acl.ace.move(this, \'up\')"><i class="fa fa-caret-up"></i></button>'.
		'<button type="button" class="btn btn-warning" onclick="tgui_acl.ace.edit(this)"><i class="fa fa-edit"></i></button>'.
		'<button type="button" class="btn btn-danger" onclick="tgui_acl.ace.delete(this)"><i class="fa fa-trash"></i></button>'.
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
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(12))
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
		//var_dump(123);die();
		if ( !empty( $req->getParam('name') ) AND !empty( $req->getParam('name_native') )){
			TACACL::where([['name','=',$req->getParam('name_native')]])->
			update(['name' => $req->getParam('name')]);
		}

		unset($ACEs[0]);

		$data['ace']=array();

		foreach ($ACEs as $ACE)
		{
			$ACE['name']=$req->getParam('name');
			if (!empty($ACE['id'])) { array_push($data['ace'],$ACE); $aceId=$ACE['id']; unset($ACE['id']); TACACL::where([['id','=',$aceId]])->update($ACE); }
			else {
				$ACE['action']=$ACE['action'];
				$data['test1'][count($data['test1'])]=$ACE;
				array_push($data['ace'],TACACL::create($ACE));
			}

		}

		$deleted_aces=$req->getParam('deleted_aces');

		if (count($deleted_aces)>0) TACACL::whereIn('id',$deleted_aces)->delete();

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'tacacs acl', 'message' => 307);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit ACL	###############END###########
################################################
########	Delete ACL	###############START###########
	#########	GET Delete ACL	#########
	// public function getACLDelete($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'get',
	// 		'object' => 'acl',
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
		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(12))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=TACACL::where([
			['name','=',$req->getParam('name')],
		])->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'tacacs acl', 'message' => 407);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		$data['footprints_users']=TACUsers::where([['acl','=',$req->getParam('id')]])->update(['acl' => '0']);
		$data['footprints_groups']=TACUserGrps::where([['acl','=',$req->getParam('id')]])->update(['acl' => '0']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete ACL	###############END###########
################################################
#########	POST CSV	#########
	public function postACLCsv($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'acl',
			'action' => 'csv',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(12))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$data['clear'] = shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');
		$path = TAC_ROOT_PATH . '/temp/';
		$filename = 'tac_acl_'. $this->generateRandomString(8) .'.csv';

		$columns = $this->APICheckerCtrl->getTableTitles('tac_acl');

	  $f = fopen($path.$filename, 'w');
		$idList = $req->getParam('idList');
		$array = [];
		$array = ( empty($idList) ) ? TACACL::select($columns)->get()->toArray() : TACACL::select($columns)->whereIn('id', $idList)->get()->toArray();

		fputcsv($f, $columns /*, ',)'*/);
	  foreach ($array as $line) {
		fputcsv($f, $line /*, ',)'*/);
	  }

		$data['filename']=$filename;
		sleep(3);
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	CSV	###############END###########
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

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(12, true))
		{
			$data['data'] = [];
			$data['recordsTotal'] = 0;
			$data['recordsFiltered'] = 0;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = $this->APICheckerCtrl->getTableTitles('tac_acl'); //Array of all columnes that will used
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
		$data['recordsTotal'] = TACACL::where([['line_number','=', 0]])->count();

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACACL::select()->where([['line_number','=', 0]])->
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
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables
		$data['data']=array();
		foreach($tempData as $acl){
			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="tgui_acl.getAcl(\''.$acl['id'].'\',\''.$acl['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="tgui_acl.delete(\''.$acl['id'].'\',\''.$acl['name'].'\')">Del</button>';
			$acl['buttons'] = $buttons;
			array_push($data['data'],$acl);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	ACL Datatables	###############END###########
################################################
################################################
########	List ACL	###############START###########
	#########	GET List ACL#########
	public function getAclList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'acl',
			'action' => 'list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$noneItem = array('id' => 0, 'text' => 'None');
		///IF GROUPID SET///
		if ($req->getParam('byId') != null){
			if ($req->getParam('byId') == 0)
			{
				$data['item']=$noneItem;
				return $res -> withStatus(200) -> write(json_encode($data));
			}
			$data['item'] = TACACL::select(['id','name'])->
			where([['id', '=', $req->getParam('byId')],['line_number','=',0]])->
			first();

			$data['item']['text'] = $data['item']['name'];
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = TACACL::select(['id','name'])->count();
		$search = $req->getParam('search');
		$take = 10 * $req->getParam('page');
		$offset = 10 * ($req->getParam('page') - 1);
		$data['take'] = $take;
		$data['offset'] = $offset;
		$tempData = TACACL::select(['id','name'])->where([['line_number','=',0]])->
			when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			})->
			take($take)->
			offset($offset);

		$tempCounter = $tempData->count();

		$tempData = $tempData->get()->toArray();
		$data['pagination'] = (!$tempData OR $tempCounter < 10) ? ['more' => false] : [ 'more' => true];
		$data['results']= ( $take == 10 AND empty($search) ) ? array( 0 => $noneItem) : array();

		foreach($tempData as $group)
		{
			$group['text'] = $group['name'];
			array_push($data['results'],$group);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List ACL	###############END###########
################################################

}//END OF CLASS//
