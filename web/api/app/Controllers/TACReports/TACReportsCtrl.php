<?php

namespace tgui\Controllers\TACReports;

use tgui\Models\TACDevices;
use tgui\Models\TACUsers;
use tgui\Models\Accounting;
use tgui\Models\Authentication;
use tgui\Models\Authorization;
use tgui\Controllers\Controller;

class TACReportsCtrl extends Controller
{
	############################################
	##########STATISTICS PLEASE#######SATART##
	public function getGeneralReport($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'general report',
			'action' => 'get',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		
		//$data['22']=Authentication::select()->distinct(['action'])->get()->toArray();
		$data['numberOfDevices']=TACDevices::select()->get()->count();
		$data['numberOfDevicesDisables']=TACDevices::select()->where([['disabled','=','1']])->get()->count();
		$data['numberOfUsers']=TACUsers::select()->get()->count();
		$data['numberOfUsersDisables']=TACUsers::select()->where([['disabled','=','1']])->get()->count();
		
		$weekTimeRange=array(
			date('Y-m-d H:i:s', (time()-(60*60*24*7+1))),
			date('Y-m-d H:i:s', time())
		);
		$data['range']=$weekTimeRange;
		/////////////NAMBER OF FAILED AUTH/////START//
		$data['numberOfAuthFails']=Authentication::select()->whereBetween('date', $weekTimeRange)->where([['action','LIKE','%fail%']])->get()->count();
		
		$data['tacacsStatusCommand'] = 'sudo '.TAC_DEAMON.' status';
		$data['tacacsStatusUser'] = trim(shell_exec('id -u -n'));
		$data['tacacsStatusEmptyCommand'] = trim(shell_exec('sudo '.TAC_DEAMON));
		$data['tacacsStatusMessage'] = trim(shell_exec('sudo '.TAC_DEAMON.' status'));
		$data['tacacsStatus']=0;
		if ($data['tacacsStatusMessage'] == null)
		{
			$data['tacacsStatusMessage']="Can't run";
		} elseif (preg_match('/.+is running.+/',$data['tacacsStatusMessage']))
		{
			$data['tacacsStatus']=1;
		}
		/////////////NAMBER OF FAILED AUTH/////end//
		//////////Top users///start//
		$data['activeUserslist']=Authentication::whereBetween('date', $weekTimeRange)->distinct()->get(['username']);
		$data['activeUsers']=array();
		for ($i=0; $i < count($data['activeUserslist']); $i++)
		{
			if ($data['activeUserslist'][$i]['username']=='') continue;
			$data['activeUsers'][$data['activeUserslist'][$i]['username']]=Authentication::whereBetween('date', $weekTimeRange)->where([['username','=',$data['activeUserslist'][$i]['username']]])->get()->count();
			
		}
		arsort($data['activeUsers']);
		$data['topUsers']=array_slice($data['activeUsers'], 0, 5);
		//////////Top users///end//
		//////////////////////////////
		//////////Top Devices///start//
		$data['activeDeviceslist']=Authentication::whereBetween('date', $weekTimeRange)->distinct()->get(['NAS']);
		$data['activeDevices']=array();
		for ($i=0; $i < count($data['activeDeviceslist']); $i++)
		{
			if ($data['activeDeviceslist'][$i]['NAS']=='') continue;
			$data['activeDevices'][$data['activeDeviceslist'][$i]['NAS']]=Authentication::whereBetween('date', $weekTimeRange)->where([['NAS','=',$data['activeDeviceslist'][$i]['NAS']]])->get()->count();
			
		}
		arsort($data['activeDevices']);
		$data['topDevices']=array_slice($data['activeDevices'], 0, 5);
		$data['nameOfDevices']=TACDevices::whereIn('ipaddr',array_keys($data['topDevices']))->get(['name', 'ipaddr']);
		$data['topDevicesNamed']=array();
		foreach ($data['topDevices'] as $ipaddress => $numberOfAuth)
		{
			for ($y=0; $y < count($data['nameOfDevices']);$y++)
			{
				if ($data['nameOfDevices'][$y]['ipaddr']==$ipaddress) $data['topDevicesNamed'][$data['nameOfDevices'][$y]['name']] = $numberOfAuth;
			}
		}
		//////////Top Devices///end//
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	##########STATISTICS PLEASE#######END##
	################################################
	################################################
########	Accounting Datatables ###############START###########
	#########	POST Accounting Datatables	#########
	public function postAccountingDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'reports accounting',
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
			1 => 'date',
			2 => 'NAS',
			3 => 'username',
			4 => 'NAC',
			5 => 'line',
			6 => 'cmd',
		); //Array of all columnes that will used
		
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Accounting::select()->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][1]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[1], $dateRange);
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			when($params['columns'][5]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
			when($params['columns'][6]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables 
		$data['data']=array();
		
		foreach($tempData as $device){
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = Accounting::count();
		$data['recordsFiltered'] = Accounting::select($columns)->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][1]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[1], $dateRange);
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			when($params['columns'][5]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
			when($params['columns'][6]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
				count();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	
########	Accounting Datatables	###############END###########
################################################
	################################################
########	Authentication Datatables ###############START###########
	#########	POST Authentication Datatables	#########
	public function postAuthenticationDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'reports authentication',
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
			1 => 'date',
			2 => 'NAS',
			3 => 'username',
			4 => 'NAC',
			5 => 'line',
		); //Array of all columnes that will used
		
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Authentication::select()->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][1]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[1], $dateRange);
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			when($params['columns'][5]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables 
		$data['data']=array();
		
		foreach($tempData as $device){
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = Authentication::count();
		$data['recordsFiltered'] = Authentication::select($columns)->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][1]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[1], $dateRange);
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			when($params['columns'][5]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
				count();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	
########	Authentication Datatables	###############END###########
################################################
	################################################
########	Authorization Datatables ###############START###########
	#########	POST Authorization Datatables	#########
	public function postAuthorizationDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'reports authorization',
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
			1 => 'date',
			2 => 'NAS',
			3 => 'username',
			4 => 'NAC',
			5 => 'line',
		); //Array of all columnes that will used
		
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Authorization::select()->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][1]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[1], $dateRange);
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			when($params['columns'][5]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables 
		$data['data']=array();
		
		foreach($tempData as $device){
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = Authorization::count();
		$data['recordsFiltered'] = Authorization::select($columns)->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[0],'LIKE','%'.$params['columns'][0]['search']['value'].'%');
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][1]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[1], $dateRange);
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[2],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			when($params['columns'][5]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[5],'LIKE','%'.$params['columns'][5]['search']['value'].'%');
				}) ->
				count();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	
########	Authorization Datatables	###############END###########
################################################
}