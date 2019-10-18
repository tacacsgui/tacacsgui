<?php

namespace tgui\Controllers\Obj\ObjAddress;

use tgui\Models\ObjAddress_;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class ObjAddress extends Controller
{
################################################
	public function itemValidation($req, $state = 'add'){
		$id = 0;
		$type = 0;
		if (is_object($req)){
			$id = ($state == 'edit') ? $req->getParam('id') : 0;
			$type = $req->getParam('type');
		} else {
			$type = (isset($req['type'])) ? $req['type'] : 0;
		}
		return $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\ObjAddress_', $id ),
			'address' => v::notEmpty()->checkAddress($type)->setName('Address'),
			'type' => v::numeric()->oneOf( v::equals(0), v::equals(1), v::equals(2)),
		]);
	}

	public function postAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'obj address',
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
		if(!$this->checkAccess(14))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->itemValidation($req);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['address'] = ObjAddress_::create($allParams);


		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'obj address',
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
		if(!$this->checkAccess(14))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'id' => v::numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['address'] = ObjAddress_::select()->where('id', $req->getParam('id'))->first();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
////////////////////////////////////////////////////////////
	public function postEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'obj address',
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
		if(!$this->checkAccess(14))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $validation = $this->itemValidation($req, 'edit');

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['save']=ObjAddress_::where('id', $allParams['id'])->update($allParams);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////////////////
	public function postDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'obj address',
			'action' => 'del',
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
		if(!$this->checkAccess(14))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'id' => v::numeric()->notEmpty()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		// if ( $this->db::table('confM_bind_query_devices')->where( 'device_id', $req->getParam('id') )->count() ){
		// 	$data['result'] = 0;
		// } else
		$data['result'] = ObjAddress_::where( 'id', $req->getParam('id') )->delete();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

  public function postDatatables($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'post',
      'object' => 'confDevices',
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
    if(!$this->checkAccess(14, true))
    {
      $data['data'] = [];
      $data['recordsTotal'] = 0;
      $data['recordsFiltered'] = 0;
      return $res -> withStatus(200) -> write(json_encode($data));
    }
    //CHECK ACCESS TO THAT FUNCTION//END//

    $params = $req->getParams(); //Get ALL parameters form Datatables

		//$columns = $this->APICheckerCtrl->getTableTitles('obj_addresses'); //Array of all columnes that will used
		$columns = [];
		array_unshift( $columns, 'obj_addresses.*' );
		array_push( $columns,
			$this->db::raw('(SELECT COUNT(*) FROM tac_devices WHERE address = obj_addresses.id) + '.
			'(SELECT COUNT(*) FROM confM_devices WHERE address = obj_addresses.id) + '.
			'(select count(distinct tae.acl_id) from tgui.tac_acl_ace tae where tae.nac = obj_addresses.id or tae.nas = obj_addresses.id ) as ref')
		);
		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		$data['recordsTotal'] = ObjAddress_::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = ObjAddress_::
			// leftJoin('tac_acl as acl', 'acl.id', '=', 'tac_devices.acl')->
			select($columns)->
			when( !empty($queries),
				function($query) use ($queries)
				{
					$query->where('obj_addresses.name','LIKE', '%'.$queries.'%');
					$query->orWhere('obj_addresses.address','LIKE', '%'.$queries.'%');
					return $query;
				});
			$data['recordsFiltered'] = $tempData->count();

			if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
					$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);
			$data['sql'] = $tempData->toSql();
			$data['data'] = $tempData->
			get()->toArray();

  	return $res -> withStatus(200) -> write(json_encode($data));
  }

	public function getList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'obj',
			'action' => 'address list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(14, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('id') != null){
			$result = ( is_array($id) ) ? ObjAddress_::select(['id','name AS text','type','address'])->whereIn('id', $req->getParam('id'))
			:
			ObjAddress_::select(['id','name AS text','type','address'])->where('id', $req->getParam('id'));
			$data['results'] = $result->orderBy('name')->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = ObjAddress_::select(['id','name AS text','type','address'])->orderBy('name');
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('name')->get()->toArray();

		$extra = json_decode($req->getParam('extra'));

		if ( $extra AND !empty($extra->any) )
			array_unshift( $data['results'], ['text' => 'any', 'id' => 0, 'address' => 'any']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getRef($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'obj',
			'action' => 'address ref',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(14, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['obj'] = ObjAddress_::select(['id','name as text'])->where('id',$req->getParam('id'))->first();
		$data['mainlist'] = [
			[ 'name' => 'TACACS Devices', 'list' => [] ],
			[ 'name' => 'TACACS ACLs', 'list' => [] ],
			[ 'name' => 'ConfManger Devices', 'list' => [] ],
		];

		$data['mainlist'][0]['list'] = $this->db->table('tac_devices as td')->
		select(['td.name as text', 'td.id as id'])->
		where('address',$req->getParam('id'))->get();

		$data['mainlist'][1]['list'] = $this->db->table('tac_acl as ta')->
		leftJoin('tac_acl_ace as tae', 'tae.acl_id','=','ta.id')->
		select(['ta.name as text', 'ta.id as id'])->
		groupBy('ta.id')->
		where('tae.nas',$req->getParam('id'))->orWhere('tae.nac',$req->getParam('id'))->get();

		$data['mainlist'][2]['list'] = $this->db->table('confM_devices as cd')->
		select(['cd.name as text', 'cd.id as id'])->
		where('address',$req->getParam('id'))->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function selectType($type = 0){
		if (is_int($type))
			return $type;
		if ($type == 'ipv6')
			return 2;

		return 0;
	}

	public function getAddressId($address, $name = ''){
		$id = 0;
		$messages = [];
		$type = 0;
		switch (true) {
			case (v::CheckAddress(0)->validate($address)):
				break;
			case (v::CheckAddress(1)->validate($address)):
				$type = 1;
				break;
			default:
				if ( ctype_digit( (string) $address ) ){
					$temp = ObjAddress_::select('name')->where('id', $address)->first();
					if ($temp)
						return [$address, ['Address found: '. $temp->name]];
					else
						return [0, ['Address with id '.$address.' NOT found']];
				}
				else
					return [0, ['Incorrect Address '.$address]];
		}

		$temp = ObjAddress_::select(['id','name'])->where('address', $address)->first();
		if ($temp)
			return [$temp->id, ['Address found: '. $temp->name]];

		if (empty($name))
			$name = $address;

		$newAddr = ObjAddress_::create([
			'name' => $name,
			'address' => $address,
			'type' => $type,
		]);

		return [$newAddr->id, ['New Address was added: '. $newAddr->name]];
	}

}//END OF CLASS//
