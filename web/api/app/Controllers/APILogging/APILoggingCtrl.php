<?php

namespace tgui\Controllers\APILogging;

use tgui\Models\APILogging;
use tgui\Controllers\Controller;



class APILoggingCtrl extends Controller
{
	###################	MAKE LOG ENTRIES########START##
	public function makeLogEntry($attrArray)
	{
		$attrArrayStatic=array('userName' => (empty($_SESSION['uname']))? '' : $_SESSION['uname'], 'userId' => (empty($_SESSION['uid']))? '' : $_SESSION['uid'], 'userIp' => $_SERVER['REMOTE_ADDR']);
		
		if (isset($attrArray['message']))
		{
			require __DIR__ . '/messages.php';
			$attrArray['message']=$MESSAGES[$attrArray['message']];
		}
		
		$logEntry = APILogging::create(array_merge($attrArrayStatic,$attrArray));
		
		return $logEntry;
	}
	###################	MAKE LOG ENTRIES########END##
	#######################################
	###################	POST LOGGING DATATABLES ########START##
	public function postLoggingDatatables($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'logging',
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
			0 => 'created_at', 
			1 => 'userName',
			2 => 'userId',
			3 => 'userIp',
			4 => 'objectName',
			5 => 'objectId',
			6 => 'action',
			7 => 'section',
			8 => 'message',
		); //Array of all columnes that will used
		
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APILogging::select($columns)->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][0]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[0], $dateRange);
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[1],'LIKE','%'.$params['columns'][1]['search']['value'].'%')->
					orWhere($columns[2],'LIKE','%'.$params['columns'][1]['search']['value'].'%');
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[7],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%')->
					orWhere($columns[5],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
			orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])->
			take($params['length'])->
			offset($params['start'])->
			get()->toArray();
		//Creating correct array of answer to Datatables 
		$data['data']=array();
		
		foreach($tempData as $loggingEntry){
			$loggingEntry['userName'] .= ($loggingEntry['userId'] !== '') ? ' ('.$loggingEntry['userId'].')' : '';
			$loggingEntry['objectName'] .= ($loggingEntry['objectId'] !== '') ? ' ('.$loggingEntry['objectId'].')' : '';
			array_push($data['data'],$loggingEntry);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );
		$data['recordsTotal'] = APILogging::count();
		$data['recordsFiltered'] = APILogging::select($columns)->
			when($params['columns'][0]['search']['value'], 
				function($query) use ($params,$columns)
				{
					$dateRange=explode(' - ', $params['columns'][0]['search']['value']);
					$dateRange[0] .= ' 00:00:00';
					$dateRange[1] .= ' 23:59:59';
					return $query->whereBetween($columns[0], $dateRange);
				}) ->
			when($params['columns'][1]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[1],'LIKE','%'.$params['columns'][1]['search']['value'].'%')->
					orWhere($columns[2],'LIKE','%'.$params['columns'][1]['search']['value'].'%');
				}) ->
			when($params['columns'][2]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[3],'LIKE','%'.$params['columns'][2]['search']['value'].'%');
				}) ->
			when($params['columns'][3]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[7],'LIKE','%'.$params['columns'][3]['search']['value'].'%');
				}) ->
			when($params['columns'][4]['search']['value'], 
				function($query) use ($params,$columns)
				{
					return $query->where($columns[4],'LIKE','%'.$params['columns'][4]['search']['value'].'%')->
					orWhere($columns[5],'LIKE','%'.$params['columns'][4]['search']['value'].'%');
				}) ->
				count();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}

	###################	POST LOGGING DATATABLES ########END##
}