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

		$logEntry = APILogging::create( array_merge($attrArrayStatic, $attrArray) );

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

		$columns = $this->APICheckerCtrl->getTableTitles('api_logging', 'logging'); //Array of all columnes that will used
		array_unshift( $columns, 'id' );
		array_push( $columns, 'created_at');
		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];
		$size = $params['pageSize'];
		$start = $params['pageSize'] * ($params['page'] - 1);
		//Filter end
		$data['recordsTotal'] = APILogging::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = APILogging::select($columns)->
		when( !empty($queries),
			function($query) use ($queries)
			{
				$query->where('username','LIKE', '%'.$queries.'%');
				$query->orWhere('user_ip','LIKE', '%'.$queries.'%');
				return $query;
			})->
		take($size)->
		offset($start);
		$data['total'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	###################	POST LOGGING DATATABLES ########END##
	public function postLoggingDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'logging',
			'action' => 'delete',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$allParams = $req->getParams();
		$period = '';
		if (!preg_match('/^[0-9]\s(year[s]{0,1}|month[s]{0,1})', $allParams['period']))
		{
			$dateCount = new \DateTime;
			$dateCount->modify('-'.$allParams['period']);
			$period = $dateCount->format('Y-m-d H:i:s');
		}
		if ($allParams['period'] == 'all') $period = 'all';

		if (empty($period)){
			$data['error']['status']=true;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$data['period'] = $period;
		$data['result'] = ($period == 'all') ?  APILogging::delete() : APILogging::where('created_at','<=',$period)->delete();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
}
