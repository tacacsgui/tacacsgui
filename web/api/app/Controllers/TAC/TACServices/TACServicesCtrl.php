<?php

namespace tgui\Controllers\TAC\TACServices;

use tgui\Models\TACServices;
use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class TACServicesCtrl extends Controller
{
################################################
########	Add New Service	###############START###########
	#########	POST Add New Service	#########
	public function postServiceAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
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
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			//Service Name//
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\TACServices' ),
			//Cisco General Pattern//
			'cisco_rs_enable' => v::noWhitespace()->boolVal(),
			'cisco_rs_privlvl' => v::oneOf(v::notEmpty(), v::numeric())->between(-1, 15)->setName('Privilege Level'),
			'cisco_rs_def_cmd' => v::noWhitespace()->boolVal(),
			'cisco_rs_def_attr' => v::noWhitespace()->boolVal(),
			'cisco_rs_idletime' => v::when( v::nullType(), v::alwaysValid(), v::numeric()->between(0, 128)->setName('Idle time') ),
			'cisco_rs_timeout' => v::when( v::nullType(), v::alwaysValid(), v::numeric()->between(0, 128)->setName('Connection timeout') ),
			'cisco_rs_debug_message' => v::noWhitespace()->boolVal(),
			//'cisco_rs_cmd' => ['string', ''],
			//'cisco_rs_autocmd' => ['string', ''],
			//'cisco_rs_nexus_roles' => ['string', ''],
			//'cisco_rs_manual' => ['text', '_'],
			//H3C General Pattern//
			'h3c_enable' => v::noWhitespace()->boolVal(),
			'h3c_privlvl' => v::oneOf(v::notEmpty(), v::numeric())->between(-1, 15)->setName('Privilege Level'),
			'h3c_def_cmd' => v::noWhitespace()->boolVal(),
			'h3c_def_attr' => v::noWhitespace()->boolVal(),
			'h3c_idletime' => v::when( v::nullType(), v::alwaysValid(), v::numeric()->between(0, 128)->setName('Idle time') ),
			'h3c_timeout' => v::when( v::nullType(), v::alwaysValid(), v::numeric()->between(0, 128)->setName('Connection timeout') ),
			//'default_cmd' => v::noWhitespace()->boolVal(),
			'manual_conf_only' => v::noWhitespace()->boolVal(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$cisco_rs_cmd = $allParams['cisco_rs_cmd'];
		$h3c_cmd = $allParams['h3c_cmd'];
		$huawei_cmd = $allParams['huawei_cmd'];
		$extreme_cmd = $allParams['extreme_cmd'];
		$junos_cmd_ao = $allParams['junos_cmd_ao'];
		$junos_cmd_do = $allParams['junos_cmd_do'];
		$junos_cmd_ac = $allParams['junos_cmd_ac'];
		$junos_cmd_dc = $allParams['junos_cmd_dc'];
		unset($allParams['cisco_rs_cmd']);unset($allParams['h3c_cmd']);
		unset($allParams['huawei_cmd']);unset($allParams['extreme_cmd']);
		unset($allParams['junos_cmd_ao']);unset($allParams['junos_cmd_do']);
		unset($allParams['junos_cmd_ac']);unset($allParams['junos_cmd_dc']);

		$data['service'] = TACServices::create($allParams);
		$tempId = $data['service']['id'];

		$service_cmd = [];
		foreach ($cisco_rs_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'cisco_rs_cmd'];
		}
		foreach ($h3c_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'h3c_cmd'];
		}
		foreach ($huawei_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'huawei_cmd'];
		}
		foreach ($extreme_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'extreme_cmd'];
		}
		foreach ($junos_cmd_ao as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_ao'];
		}
		foreach ($junos_cmd_do as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_do'];
		}
		foreach ($junos_cmd_ac as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_ac'];
		}
		foreach ($junos_cmd_dc as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_dc'];
		}

		if (count($service_cmd)) $this->db::table('bind_service_cmd')->insert($service_cmd);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'add', 'obj_name' => $data['service']['name'], 'obj_id' => $data['service']['id'], 'section' => 'tacacs services', 'message' => 208);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New Service	###############END###########
################################################
########	Edit Service	###############START###########
	#########	GET Edit Service	#########
	public function getServiceEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'service',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$sections = [
			'cisco_rs_cmd' => [],
			'h3c_cmd' => [],
			'huawei_cmd' => [],
			'extreme_cmd' => [],
			'junos_cmd_ao' => [],
			'junos_cmd_do' => [],
			'junos_cmd_ac' => [],
			'junos_cmd_dc' => []
		];


		$data['service']=TACServices::select()->where('id',$req->getParam('id'))->first();

		$tempData = $this->db->table('bind_service_cmd as bsc')->
			select(['section', 'cmd.id as id', 'cmd.name as text'])->
			leftJoin('tac_cmd as cmd', 'cmd.id', '=', 'bsc.cmd_id')->
			where('service_id', $req->getParam('id'))->get();

		foreach ($tempData as $cmdSet) {
			$sections[$cmdSet->section][] = ['id' => $cmdSet->id, 'text' => $cmdSet->text];
		}

		$data['service']->cisco_rs_cmd = $sections['cisco_rs_cmd'];
		$data['service']->h3c_cmd = $sections['h3c_cmd'];
		$data['service']->huawei_cmd = $sections['huawei_cmd'];
		$data['service']->extreme_cmd = $sections['extreme_cmd'];
		$data['service']->junos_cmd_ao = $sections['junos_cmd_ao'];
		$data['service']->junos_cmd_do = $sections['junos_cmd_do'];
		$data['service']->junos_cmd_ac = $sections['junos_cmd_ac'];
		$data['service']->junos_cmd_dc = $sections['junos_cmd_dc'];
		$data['service']->cisco_wlc_roles = explode(';;', $data['service']->cisco_wlc_roles);

		$data['service']->acl = $this->db::table('tac_acl')->select(['id','name as text'])->where('id', $data['service']->acl)->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	#########	POST Edit ACL	#########
	public function postServiceEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
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
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::notEmpty()->theSameNameUsed( '\tgui\Models\TACServices', $req->getParam('id') ),
			'cisco_rs_privlvl' => v::oneOf(v::notEmpty(), v::numeric())->between(-1, 15)->setName('Privilege Level'),
			'h3c_privlvl' => v::oneOf(v::notEmpty(), v::numeric())->between(-1, 15)->setName('Privilege Level'),
			//'priv-lvl' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::numeric()->between(-1, 15)),
			//'default_cmd' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::boolVal()),
			'manual_conf_only' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::boolVal()),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$cisco_rs_cmd = $allParams['cisco_rs_cmd'];
		$h3c_cmd = $allParams['h3c_cmd'];
		$huawei_cmd = $allParams['huawei_cmd'];
		$extreme_cmd = $allParams['extreme_cmd'];
		$junos_cmd_ao = $allParams['junos_cmd_ao'];
		$junos_cmd_do = $allParams['junos_cmd_do'];
		$junos_cmd_ac = $allParams['junos_cmd_ac'];
		$junos_cmd_dc = $allParams['junos_cmd_dc'];
		unset($allParams['cisco_rs_cmd']);unset($allParams['h3c_cmd']);
		unset($allParams['huawei_cmd']);unset($allParams['extreme_cmd']);
		unset($allParams['junos_cmd_ao']);unset($allParams['junos_cmd_do']);
		unset($allParams['junos_cmd_ac']);unset($allParams['junos_cmd_dc']);

		$data['service_update']=TACServices::where('id',$req->getParam('id'))->
			update($allParams);

		$tempId = $req->getParam('id');

		$service_cmd = [];
		foreach ($cisco_rs_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'cisco_rs_cmd'];
		}
		foreach ($h3c_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'h3c_cmd'];
		}
		foreach ($huawei_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'huawei_cmd'];
		}
		foreach ($extreme_cmd as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'extreme_cmd'];
		}
		foreach ($junos_cmd_ao as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_ao'];
		}
		foreach ($junos_cmd_do as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_do'];
		}
		foreach ($junos_cmd_ac as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_ac'];
		}
		foreach ($junos_cmd_dc as $value) {
			if (empty($value)) continue;
			$service_cmd[] = [ 'service_id' => $tempId, 'cmd_id' => $value, 'section' => 'junos_cmd_dc'];
		}
		$this->db::table('bind_service_cmd')->where('service_id',$tempId)->delete();
		if (count($service_cmd)) $this->db::table('bind_service_cmd')->insert($service_cmd);

		$data['save'] = 1;

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => $allParams['name'], 'obj_id' => $allParams['id'], 'section' => 'tacacs services', 'message' => 308);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Edit Service	###############END###########
################################################
########	Delete Service	###############START###########
	#########	POST Delete Service	#########
	public function postServiceDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
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
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['result']=TACServices::where('id',$req->getParam('id'))->delete();
		$data['id']=$req->getParam('id');
		$data['name']=$req->getParam('name');

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'delete', 'obj_name' => $req->getParam('name'), 'obj_id' => $req->getParam('id'), 'section' => 'tacacs services', 'message' => 408);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		// $data['footprints_users']=TACUsers::where([['service','=',$req->getParam('id')]])->update(['service' => '0']);
		// $data['footprints_groups']=TACUserGrps::where([['service','=',$req->getParam('id')]])->update(['service' => '0']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Delete Service	###############END###########
################################################
#########	POST CSV 	#########
	public function postServiceCsv($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
			'action' => 'csv',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$data['clear'] = shell_exec( TAC_ROOT_PATH . '/main.sh delete temp');
		$path = TAC_ROOT_PATH . '/temp/';
		$filename = 'tac_services_'. $this->generateRandomString(8) .'.csv';

		$columns = $this->APICheckerCtrl->getTableTitles('tac_services');

	  $f = fopen($path.$filename, 'w');
		$idList = $req->getParam('idList');
		$array = [];
		$array = ( empty($idList) ) ? TACServices::select($columns)->get()->toArray() : TACServices::select($columns)->whereIn('id', $idList)->get()->toArray();

		fputcsv($f, $columns /*, ',)'*/);
	  foreach ($array as $line) {
		fputcsv($f, $line /*, ',)'*/);
	  }

		$data['filename']=$filename;
		sleep(3);
		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	CSV 	###############END###########
################################################
########	Service Datatables ###############START###########
	#########	POST Service Datatables	#########
	public function postServiceDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'service',
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
		if(!$this->checkAccess(13, true))
		{
			$data['data'] = [];
			$data['recordsTotal'] = 0;
			$data['recordsFiltered'] = 0;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		//$columns = $this->APICheckerCtrl->getTableTitles('tac_services'); //Array of all columnes that will used
		$columns = [];
		array_unshift( $columns, 'tac_services.*' );
		array_push( $columns, $this->db::raw('(SELECT COUNT(*) FROM tac_bind_service WHERE service_id = tac_services.id) as ref'));
		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		//Filter end
		$data['recordsTotal'] = TACServices::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = TACServices:://leftJoin('tac_bind_service as tbs','tbs.service_id','=','tac_services.id')->
		select($columns)->
		//groupBy('tac_services.id')->
		when( !empty($queries),
			function($query) use ($queries)
			{
				$query->where('name','LIKE', '%'.$queries.'%');
				return $query;
			});
		$data['recordsFiltered'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	Service Datatables	###############END###########
################################################
################################################
########	List of Services	###############START###########
	#########	GET List Services#########
	public function getServiceList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'services',
			'action' => 'list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('id') != null){
			$id = explode(',', $req->getParam('id'));

			$data['results'] = TACServices::select(['id','name AS text'])->whereIn('id', $id)->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = TACServices::select(['id','name as text']);
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('name','asc')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List of Services	###############END###########
################################################
########	List of Service Reference	###############START###########
	#########	GET List Service Reference#########
	public function getServiceRef($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'services',
			'action' => 'ref',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(13, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['obj'] = TACServices::select(['id','name as text'])->where('id',$req->getParam('id'))->first();
		$data['mainlist'] = [
			[ 'name' => 'TACACS Users', 'list' => [] ],
			[ 'name' => 'TACACS User Groups', 'list' => [] ],
		];

		$data['mainlist'][0]['list'] = $this->db->table('tac_bind_service')->
		leftJoin('tac_users as tu', 'tu.id', '=', 'tac_usr_id')->
		select(['tu.username as text', 'tu.id as id'])->
		where([['service_id',$req->getParam('id')], ['tac_usr_id', '<>', null]])->get();

		$data['mainlist'][1]['list'] = $this->db->table('tac_bind_service')->
		leftJoin('tac_user_groups as tug', 'tug.id', '=', 'tac_grp_id')->
		select(['tug.name as text', 'tug.id as id'])->
		where([['service_id',$req->getParam('id')], ['tac_grp_id', '<>', null]])->get();


		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	List of Service Reference	###############END###########
################################################

}//END OF CLASS//
