<?php

namespace tgui\Controllers\TACReports;

use Illuminate\Support\Facades\DB as DB;

use tgui\Services\CMDRun\CMDRun as CMDRun;

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

		$weekTimeRange=array(
			date('Y-m-d H:i:s', strtotime( trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") ))-(60*60*24*7+1)),
			trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") )
		);
		$data['range']=$weekTimeRange;
		/////////////NAMBER OF FAILED AUTH/////START//
		//$data['numberOfAuthFails']=Authentication::select()->whereBetween('date', $weekTimeRange)->where([['action','LIKE','%fail%']])->get()->count();
		/////////////NUMBER OF FAILED AUTH/////end//
		$data['widgets'] = $this->db::select( $this->db::raw(" SELECT ".
			" (SELECT COUNT(*) FROM tgui.api_settings where `update_signin` = 1) as update_, ".
  		' (SELECT COUNT(*) FROM tgui.tac_users) as users, '.
  		" (SELECT COUNT(*) FROM tgui.tac_users where `disabled` = '1') as users_disabled, ".
  		' (SELECT COUNT(*) FROM tgui.tac_devices) as devices,'.
  		" (SELECT COUNT(*) FROM tgui.tac_devices where `disabled` = '1') as devices_disabled, ".
  		" (SELECT COUNT(*) FROM tgui_log.tac_log_authentication where `date` between '".$weekTimeRange[0]."' and '".$weekTimeRange[1]."' and (`action` LIKE '%fail%') OR (`action` LIKE '%deny%') ) as authe_err ") );
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	##########STATISTICS PLEASE#######END##
	################################################
	public function getAuthChartData($req,$res)
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
		$data['time_range'] = [];

		$now = $startDate = date('Y-m-d', strtotime( trim( trim( CMDRun::init()->setCmd(MAINSCRIPT)->setAttr(['ntp','get-time'])->get() ) ) ) );
		$days = 7;
		$dateArray = [];
		for ($i=0; $i < $days ; $i++) {
			$dateArray[] = $startDate;
			$startDate = date('Y-m-d', strtotime( $startDate . " 00:00:00" ) - 86399);
		}
		$now = $now . ' 23:59:59';
		$startDate = $startDate . ' 00:00:00';
		$data['time_range'] = array_reverse( $dateArray );

		$data['authe'] = [];
		$data['autho'] = [];
		$data['authe']['db'] = $this->db::select( $this->db::raw("select date_ date,sum(authe_s) authe_s ,sum(authe_f) authe_f  from(".
"select date_,if(`action_`='permit',count,0) authe_s,if(`action_`='deny',count,0) authe_f from".
"(select date_format(date,'%Y-%m-%d') date_, if( `action` like \"%succeeded\",\"permit\",\"deny\") `action_`, count(*) count from tgui_log.tac_log_authentication where date between '".$startDate."' and '".$now."'  group by date_, action_) authe" .
") test group by date_") );
		$data['autho']['db'] = $this->db::select( $this->db::raw("select date_ date,sum(autho_s) autho_s ,sum(autho_f) autho_f  from(".
			"select date_,if(action='permit',count,0) autho_s,if(action='deny',count,0) autho_f from".
			"(select date_format(date,'%Y-%m-%d') date_,action, count(*) count from tgui_log.tac_log_authorization where date between '".$startDate."' and '".$now."' group by date_,action) autho".
			") test group by date_ ") );

		$data['authe']['arr'] = [];
		$data['autho']['arr'] = [];
		for ($i=0; $i < count($data['authe']['db']); $i++) {
			$data['authe']['arr'][$data['authe']['db'][$i]->date] = ['s' => $data['authe']['db'][$i]->authe_s, 'f' => $data['authe']['db'][$i]->authe_f];
		}
		for ($i=0; $i < count($data['autho']['db']); $i++) {
			$data['autho']['arr'][$data['autho']['db'][$i]->date] = ['s' => $data['autho']['db'][$i]->autho_s, 'f' => $data['autho']['db'][$i]->autho_f];
		}

		$data['authe']['chart'] = [];
		$data['autho']['chart'] = [];
		for ($i=0; $i < count( $data['time_range'] ); $i++) {
			$data['authe']['chart']['s'][$i] = ( array_key_exists($data['time_range'][$i], $data['authe']['arr']) ) ? $data['authe']['arr'][$data['time_range'][$i]]['s'] : 0;
			$data['authe']['chart']['f'][$i] = ( array_key_exists($data['time_range'][$i], $data['authe']['arr']) ) ? $data['authe']['arr'][$data['time_range'][$i]]['f']  : 0;
			$data['autho']['chart']['s'][$i] = ( array_key_exists($data['time_range'][$i], $data['autho']['arr']) ) ? $data['autho']['arr'][$data['time_range'][$i]]['s']  : 0;
			$data['autho']['chart']['f'][$i] = ( array_key_exists($data['time_range'][$i], $data['autho']['arr']) ) ? $data['autho']['arr'][$data['time_range'][$i]]['f']  : 0;
		}

		$data['authe']['step'] = ( max( $data['authe']['chart']['s'] ) > max( $data['authe']['chart']['f'] ) ) ?
			max( $data['authe']['chart']['s'] )
			:
			max( $data['authe']['chart']['f'] );
		$data['authe']['step'] = ( $data['authe']['step'] < 50 ) ? 10 : round($data['authe']['step'] / 5);
		$data['autho']['step'] = ( max( $data['autho']['chart']['s'] ) > max( $data['autho']['chart']['f'] ) ) ?
			max( $data['autho']['chart']['s'] )
			:
			max( $data['autho']['chart']['f'] );
		$data['autho']['step'] = ( $data['autho']['step'] < 50 ) ? 10 : round($data['autho']['step'] / 5);


		return $res -> withStatus(200) -> write(json_encode($data));
	}
	public static function chartStep($max=1, $step=1)
	{
		return (round($max / 5) < $step ) ? $step : round($max / 5);
	}

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
			date('Y-m-d H:i:s', (strtotime(trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") ))-(60*60*24*7+1))),
			trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") )
		);
		$data['range']=$weekTimeRange;

		$allParams = $req->getParams();
		$allParams['users'] = ( !empty($allParams['users']) ) ? $allParams['users'] : 5;
		$allParams['devices'] = ( !empty($allParams['devices']) ) ? $allParams['devices'] : 5;
		//$allParams['devicesReload'] = ( !empty($allParams['devicesReload']) ) ? $allParams['devicesReload'] : 1;
		//$allParams['usersReload'] = ( !empty($allParams['usersReload']) ) ? $allParams['usersReload'] : 1;
		if ($allParams['usersReload']){
			//////////Top users///start//
			$data['topUsers'] = Authentication::select('username as label', $this->db::raw('COUNT(1) as count') )->where('action', 'LIKE', '%succeeded')->whereBetween('date', $weekTimeRange)->groupBy('username')->orderBy('count','desc')->limit($allParams['users'])->get();
			//////////Top users///end//
		}
		//////////////////////////////
		//////////Top Devices///start//
		if ($allParams['devicesReload']){

			$data['topDevices'] = $this->db::select( $this->db::raw("select IFNULL(dev.name, log.nas) label, log.count from (select nas, COUNT(1) as count from `tgui_log`.`tac_log_authentication`  where `tac_log_authentication`.`action` LIKE '%succeeded' and `tac_log_authentication`.`date` between '".$weekTimeRange[0]."' and '".$weekTimeRange[1]."' group by `nas` order by count desc limit ".$allParams['users'].") as log left join `tgui`.`tac_devices` as `dev` on log.`nas` = `dev`.`ipaddr` order by log.count desc;") );
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
				$data['result'] = ($period == 'all') ?  Accounting::query()->delete() : Accounting::where('date','<=',$period)->delete();
				break;

			case 'authentication':
				$data['result'] = ($period == 'all') ?  Authentication::query()->delete() : Authentication::where('date','<=',$period)->delete();
				break;

			case 'authorization':
				$data['result'] = ($period == 'all') ?  Authorization::query()->delete() : Authorization::where('date','<=',$period)->delete();
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
