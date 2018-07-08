<?php

namespace tgui\Controllers\APILogging;

use tgui\Models\APILogging;
use tgui\Controllers\Controller;



class APILoggingCtrl extends Controller
{
	###################	MAKE LOG ENTRIES########START##
	public function makeLogEntry($attrArray)
	{
		$attrArrayStatic=array('username' => (empty($_SESSION['uname']))? '' : $_SESSION['uname'], 'uid' => (empty($_SESSION['uid']))? '' : $_SESSION['uid'], 'user_ip' => $_SERVER['REMOTE_ADDR']);

		if (isset($attrArray['message']))
		{
			require __DIR__ . '/messages.php';
			$attrArray['message']=$MESSAGES[$attrArray['message']];
		}

		$logEntry = APILogging::create( array_merge($attrArrayStatic,$attrArray) );

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

		$columns = $this->APICheckerCtrl->getTableTitles('api_logging'); //Array of all columnes that will used
		array_unshift( $columns, 'id' );

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
		$data['recordsTotal'] = APILogging::count();

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APILogging::select()->
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
			$data['data'] = [];
		foreach($tempData as $loggingEntry){
			$loggingEntry['username'] .= ($loggingEntry['uid'] !== '') ? ' ('.$loggingEntry['uid'].')' : '';
			$loggingEntry['obj_name'] .= ($loggingEntry['obj_id'] !== '') ? ' ('.$loggingEntry['obj_id'].')' : '';
			array_push($data['data'],$loggingEntry);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	###################	POST LOGGING DATATABLES ########END##
}
