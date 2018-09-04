<?php

namespace tgui\Controllers\TACReports;

use tgui\Models\TACDevices;
use tgui\Models\TACUsers;
use tgui\Models\Accounting;
use tgui\Models\Authentication;
use tgui\Models\Authorization;
use tgui\Models\APISettings;
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
		$data['update_check'] = APISettings::find(1)->update_signin;
		$weekTimeRange=array(
			date('Y-m-d H:i:s', (time()-(60*60*24*7+1))),
			date('Y-m-d H:i:s', time())
		);
		$data['range']=$weekTimeRange;
		/////////////NAMBER OF FAILED AUTH/////START//
		$data['numberOfAuthFails']=Authentication::select()->whereBetween('date', $weekTimeRange)->where([['action','LIKE','%fail%']])->get()->count();
		/////////////NUMBER OF FAILED AUTH/////end//
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	##########STATISTICS PLEASE#######END##
	################################################
	public function getTopAccess($req,$res)
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
		$weekTimeRange=array(
			date('Y-m-d H:i:s', (time()-(60*60*24*7+1))),
			date('Y-m-d H:i:s', time())
		);
		$data['range']=$weekTimeRange;

		$allParams = $req->getParams();
		$allParams['users'] = ( !empty($allParams['users']) ) ? $allParams['users'] : 5;
		$allParams['devices'] = ( !empty($allParams['devices']) ) ? $allParams['devices'] : 5;
		//$allParams['devicesReload'] = ( !empty($allParams['devicesReload']) ) ? $allParams['devicesReload'] : 1;
		//$allParams['usersReload'] = ( !empty($allParams['usersReload']) ) ? $allParams['usersReload'] : 1;
		if ($allParams['usersReload']){
			//////////Top users///start//
			$activeUserslist=Authentication::whereBetween('date', $weekTimeRange)->distinct()->limit($allParams['users'])->get(['username']);
			$data['topUsers']=array();
			for ($i=0; $i < count($activeUserslist); $i++)
			{
				if ($activeUserslist[$i]['username']=='') continue;
				$data['topUsers'][$activeUserslist[$i]['username']]=Authentication::whereBetween('date', $weekTimeRange)->where([['username','=',$activeUserslist[$i]['username']]])->get()->count();
			}
			//arsort($data['topUsers']);
			$data['topUsers'] = $data['topUsers'];
			//////////Top users///end//
		}
		//////////////////////////////
		//////////Top Devices///start//
		if ($allParams['devicesReload']){
			$activeDeviceslist=Authentication::whereBetween('date', $weekTimeRange)->distinct()->limit($allParams['devices'])->get(['NAS']);
			$data['activeDevices']=array();
			for ($i=0; $i < count($activeDeviceslist); $i++)
			{
				if ($activeDeviceslist[$i]['NAS']=='') continue;
				$data['activeDevices'][$activeDeviceslist[$i]['NAS']]=Authentication::whereBetween('date', $weekTimeRange)->where([['NAS','=',$activeDeviceslist[$i]['NAS']]])->get()->count();
			}
			arsort($data['activeDevices']);
			$data['topDevices'] = $data['activeDevices'];
			$data['nameOfDevices']=TACDevices::whereIn('ipaddr',array_keys($data['topDevices']))->get(['name', 'ipaddr']);
			$data['topDevicesNamed']=array();
			foreach ($data['topDevices'] as $ipaddress => $numberOfAuth)
			{
				for ($y=0; $y < count($data['nameOfDevices']);$y++)
				{
					if ($data['nameOfDevices'][$y]['ipaddr']==$ipaddress) $data['topDevicesNamed'][$data['nameOfDevices'][$y]['name']] = $numberOfAuth;
				}
			}
		}
		//////////Top Devices///end//
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	public function getDaemonStatus($req,$res)
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
		return $res -> withStatus(200) -> write(json_encode($data));
	}
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

		$columns = $this->APICheckerCtrl->getTableTitles('tac_log_accounting', 'logging'); //Array of all columnes that will used
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
		$data['recordsTotal'] = Accounting::count();

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Accounting::select()->
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
		//Creating correct array of answer to Datatables
		$data['data']=array();

		foreach($tempData as $device){
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

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

		$columns = $this->APICheckerCtrl->getTableTitles('tac_log_authentication', 'logging'); //Array of all columnes that will used
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
		$data['recordsTotal'] = Authentication::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Authentication::select()->
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
		//Creating correct array of answer to Datatables
		$data['data']=array();

		foreach($tempData as $device){
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

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

		$columns = $this->APICheckerCtrl->getTableTitles('tac_log_authorization', 'logging'); //Array of all columnes that will used
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
		$data['recordsTotal'] = Authorization::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Authorization::select()->
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
		//Creating correct array of answer to Datatables
		$data['data']=array();

		foreach($tempData as $device){
			array_push($data['data'],$device);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

		return $res -> withStatus(200) -> write(json_encode($data));
	}

########	Authorization Datatables	###############END###########
################################################
########	File Tree ###############START###########
	#########	POST	#########
	public function postFileTree($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'file tree',
			'action' => 'tree',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		$allParams = $req->getParams();
		$root = '/var/log/tacacsgui';
		if( !$root ) exit("ERROR: Root filesystem directory not set in jqueryFileTree.php");
		$postDir = rawurldecode($root.(isset($allParams['dir']) ? $allParams['dir'] : null ));
		// set checkbox if multiSelect set to true
		$checkbox = ( isset($allParams['multiSelect']) && $allParams['multiSelect'] == 'true' ) ? "<input type='checkbox' />" : null;
		$onlyFolders = ( isset($allParams['onlyFolders']) && $allParams['onlyFolders'] == 'true' ) ? true : false;
		$onlyFiles = ( isset($allParams['onlyFiles']) && $allParams['onlyFiles'] == 'true' ) ? true : false;
		if( file_exists($postDir) ) {
			$files		= scandir($postDir);
			$returnDir	= substr($postDir, strlen($root));
			natcasesort($files);
			if( count($files) > 2 ) { // The 2 accounts for . and ..
				echo "<ul class='jqueryFileTree'>";
				foreach( $files as $file ) {
					$htmlRel	= htmlentities($returnDir . $file,ENT_QUOTES);
					$htmlName	= htmlentities($file);
					$ext		= preg_replace('/^.*\./', '', $file);
					if( file_exists($postDir . $file) && $file != '.' && $file != '..' ) {
						if( is_dir($postDir . $file) && (!$onlyFiles || $onlyFolders) )
							echo "<li class='directory collapsed'>{$checkbox}<a rel='" .$htmlRel. "/'>" . $htmlName . "</a></li>";
						else if ( (!$onlyFolders || $onlyFiles) AND $htmlName != '.gitkeep')
							echo "<li class='file ext_{$ext}'>{$checkbox}<a rel='" . $htmlRel . "' href=\"/api/download/log/?file=".$htmlRel."&filename=".$htmlName."\" target=\"_blank\">" . $htmlName . "</a></li>";
					}
				}
				echo "</ul>";
			}
		}

		return $res -> withStatus(200);
	}
	########	File Tree	###############END###########
	################################################
	########	Delete Log ###############START###########
	#########	POST	#########
	public function postLogDelete($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'tac log',
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

		$allParams = $req->getParams();
		$period = '';
		if (!preg_match('/^[0-9]\s(year[s]{0,1}|month[s]{0,1})', $allParams['period']))
		{
			$dateCount = new \DateTime;
			$dateCount->modify('-'.$allParams['period']);
			$period = $dateCount->format('Y-m-d H:i:s');
		}
		if ($allParams['period'] == 'all') $period = 'all';

		if (empty($period) OR empty($allParams['target'])){
			$data['error']=true;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$data['period'] = $period;
		switch ($allParams['target']) {
			case 'accounting':
				$data['result'] = ($period == 'all') ?  Accounting::delete() : Accounting::where('date','<=',$period)->delete();
				break;

			case 'authentication':
				$data['result'] = ($period == 'all') ?  Authentication::delete() : Authentication::where('date','<=',$period)->delete();
				break;

			case 'authorization':
				$data['result'] = ($period == 'all') ?  Authorization::delete() : Authorization::where('date','<=',$period)->delete();
				break;

			default:
				$data['error']=true;
				return $res -> withStatus(200) -> write(json_encode($data));
				break;
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	########	Delete Log ###############END###########
}
