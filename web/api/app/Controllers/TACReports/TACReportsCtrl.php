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
		$data['ha'] = [
			'config' => $this->HAGeneral->getFullConfig(),
			'slaves' => $this->HAMaster->getSlaves(),
			'master' => $this->HASlave->getMaster(),
			'db' => $this->databaseHash()[0],
			'api' => APIVER,
		];
		/////////////NAMBER OF FAILED AUTH/////START//
		//$data['numberOfAuthFails']=Authentication::select()->whereBetween('date', $weekTimeRange)->where([['action','LIKE','%fail%']])->get()->count();
		/////////////NUMBER OF FAILED AUTH/////end//
		$data['widgets'] = $this->db::select( $this->db::raw(" SELECT ".
			" (SELECT COUNT(*) FROM tgui.api_settings where `update_signin` = 1) as update_, ".
  		' (SELECT COUNT(*) FROM tgui.tac_users) as users, '.
  		" (SELECT COUNT(*) FROM tgui.tac_users where `disabled` = '1') as users_disabled, ".
  		' (SELECT COUNT(*) FROM tgui.tac_devices) as devices,'.
  		" (SELECT COUNT(*) FROM tgui.tac_devices where `disabled` = '1') as devices_disabled, ".
  		" (SELECT COUNT(*) FROM tgui_log.tac_log_authentication) as authe, ".
  		" (SELECT COUNT(*) FROM tgui_log.tac_log_authorization) as autho, ".
  		" (SELECT COUNT(*) FROM tgui_log.tac_log_accounting) as acc, ".
  		" (SELECT COUNT(*) FROM tgui_log.tac_log_authentication where `date` between '".$weekTimeRange[0]."' and '".$weekTimeRange[1]."' and (`action` LIKE '%fail%') OR (`action` LIKE '%deny%') ) as authe_err ") );

			$data['widgets'][0]->TACVER = TACVER;
			$data['widgets'][0]->APIVER = APIVER;
			$data['widgets'][0]->tac_status = preg_split( '/\s+/',
					trim(
						CMDRun::init()->setCmd('service')->setAttr(['tac_plus','status'])->setGrep('Active: ')->get()
					)
				)[1];
			$data['widgets'][0]->ha = $this->getHaRole();

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

			$data['topDevices'] = $this->db::select(
				$this->db::raw("select ".
							" IFNULL(dev.name, log.nas) label, addr.id as name, ".
							"log.count from (select nas, COUNT(1) as count from `tgui_log`.`tac_log_authentication` ".
							"where `tac_log_authentication`.`action` LIKE '%succeeded' and ".
							"`tac_log_authentication`.`date` between '".$weekTimeRange[0]."' and '".$weekTimeRange[1]."' ".
							"group by `nas` order by count desc limit ".$allParams['devices'].") as log ".
							"left join `tgui`.`obj_addresses` as `addr` on log.`nas` = `addr`.`address` ".
							"left join `tgui`.`tac_devices` as `dev` on `addr`.`id` = `dev`.`address` order by log.count desc;") );
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
		$queries = (empty($params['filterTerm'])) ? [] : $params['filterTerm'];
		$size = $params['pageSize'];
		$start = $params['pageSize'] * ($params['page'] - 1);
		//Filter end
		$data['recordsTotal'] = Accounting::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Accounting::select($columns)->
		when( !empty($queries),
		function($query) use ($queries)
		{
			for ($bliat=0; $bliat < count($queries); $bliat++) {
				$plezSayNot = !!preg_match("/^!/i", $queries[$bliat]['value']);
				$queries[$bliat]['value'] = preg_replace("/^!/i",'', $queries[$bliat]['value']);
				$splitMePlz = array_map('trim', explode(',', $queries[$bliat]['value']));
				switch ($queries[$bliat]['queryName']) {
					case 'date':
						for ($bliat_1=0; $bliat_1 < count($splitMePlz); $bliat_1++) {
							if ( $bliat_1 == 0) {
								if ($plezSayNot)
									$query->whereNotBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
								else
									$query->whereBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
								continue;
							}
							if ($plezSayNot)
								$query->orWhereNotBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
							else
								$query->orWhereBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
						}
						break;

					case 'nas':
						if ($plezSayNot)
							$query->whereNotIn('nas', $splitMePlz);
						else
							$query->whereIn('nas', $splitMePlz);
						break;
					case 'nac':
						if ($plezSayNot)
							$query->whereNotIn('nac', $splitMePlz);
						else
							$query->whereIn('nac', $splitMePlz);
						break;
					case 'username':
						if ($plezSayNot)
							$query->whereNotIn('username', $splitMePlz);
						else
							$query->whereIn('username', $splitMePlz);
						break;
					case 'action':
						for ($bliat_2=0; $bliat_2 < count($splitMePlz); $bliat_2++) {
							if ( $bliat_2 == 0) {
								if ($plezSayNot)
									$query->where('action','NOT LIKE', '%'.$splitMePlz[$bliat_2].'%');
								else
									$query->where('action','LIKE', '%'.$splitMePlz[$bliat_2].'%');
								continue;
							}
							if ($plezSayNot)
								$query->orWhere('action','NOT LIKE', '%'.$splitMePlz[$bliat_2].'%');
							else
								$query->orWhere('action','LIKE', '%'.$splitMePlz[$bliat_2].'%');
						}
						break;
					case 'cmd':
						for ($bliat_3=0; $bliat_3 < count($splitMePlz); $bliat_3++) {
							if ( $bliat_3 == 0) {
								if ($plezSayNot)
									$query->where('cmd','NOT LIKE', '%'.$splitMePlz[$bliat_3].'%');
								else
									$query->where('cmd','LIKE', '%'.$splitMePlz[$bliat_3].'%');
								continue;
							}
							if ($plezSayNot)
								$query->orWhere('cmd','NOT LIKE', '%'.$splitMePlz[$bliat_3].'%');
							else
								$query->orWhere('cmd','LIKE', '%'.$splitMePlz[$bliat_3].'%');
						}
						break;

				}
			}

			return $query;
		});

		$data['total'] = $tempData->count();

		$tempData = $tempData->take($size)->offset($start);

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

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
		$queries = (empty($params['filterTerm'])) ? [] : $params['filterTerm'];
		$size = $params['pageSize'];
		$start = $params['pageSize'] * ($params['page'] - 1);
		//Filter end
		$data['recordsTotal'] = Authentication::count();
		$data['test23'] = array_map('trim', explode(' - ', $queries[0]['value']));
		$splitMePlz = [];
		$plezSayNot = false;
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Authentication::select($columns)->
		when( !empty($queries),
			function($query) use ($queries)
			{
				// var_dump($queries); die;
				for ($bliat=0; $bliat < count($queries); $bliat++) {
					// if ($bliat > 0 ) { var_dump($queries[$bliat]); die;}
					$plezSayNot = !!preg_match("/^!/i", $queries[$bliat]['value']);
					$queries[$bliat]['value'] = preg_replace("/^!/i",'', $queries[$bliat]['value']);
					$splitMePlz = array_map('trim', explode(',', $queries[$bliat]['value']));
					switch ($queries[$bliat]['queryName']) {
						case 'date':
							for ($bliat_1=0; $bliat_1 < count($splitMePlz); $bliat_1++) {
								if ( $bliat_1 == 0) {
									if ($plezSayNot)
										$query->whereNotBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
									else
										$query->whereBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
									//continue;
								} else {
									if ($plezSayNot)
										$query->orWhereNotBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
									else
										$query->orWhereBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
								}
							}
							break;

						case 'nas':
							if ($plezSayNot)
								$query->whereNotIn('nas', $splitMePlz);
							else
								$query->whereIn('nas', $splitMePlz);
							break;
						case 'nac':
							if ($plezSayNot)
								$query->whereNotIn('nac', $splitMePlz);
							else
								$query->whereIn('nac', $splitMePlz);
							break;
						case 'username':
							if ($plezSayNot)
								$query->whereNotIn('username', $splitMePlz);
							else
								$query->whereIn('username', $splitMePlz);
							break;
						case 'action':
							for ($bliat_2=0; $bliat_2 < count($splitMePlz); $bliat_2++) {
								if ( $bliat_2 == 0) {
									if ($plezSayNot)
										$query->where('action','NOT LIKE', '%'.$splitMePlz[$bliat_2].'%');
									else
										$query->where('action','LIKE', '%'.$splitMePlz[$bliat_2].'%');
								} else {
									if ($plezSayNot)
										$query->orWhere('action','NOT LIKE', '%'.$splitMePlz[$bliat_2].'%');
									else
										$query->orWhere('action','LIKE', '%'.$splitMePlz[$bliat_2].'%');
								}
							}
							break;

					}
				}

				return $query;
			});

		$data['total'] = $tempData->count();

		$tempData = $tempData->take($size)->offset($start);

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		//$data['querySql'] = $tempData; //$tempData->toSql();

		$data['data'] = $tempData->get();

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
		$queries = (empty($params['filterTerm'])) ? [] : $params['filterTerm'];
		$size = $params['pageSize'];
		$start = $params['pageSize'] * ($params['page'] - 1);
		//Filter end
		$data['recordsTotal'] = Authorization::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Authorization::select($columns)->
		when( !empty($queries),
		function($query) use ($queries)
		{
			for ($bliat=0; $bliat < count($queries); $bliat++) {
				$plezSayNot = !!preg_match("/^!/i", $queries[$bliat]['value']);
				$queries[$bliat]['value'] = preg_replace("/^!/i",'', $queries[$bliat]['value']);
				$splitMePlz = array_map('trim', explode(',', $queries[$bliat]['value']));
				switch ($queries[$bliat]['queryName']) {
					case 'date':
						for ($bliat_1=0; $bliat_1 < count($splitMePlz); $bliat_1++) {
							if ( $bliat_1 == 0) {
								if ($plezSayNot)
									$query->whereNotBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
								else
									$query->whereBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
								continue;
							}
							if ($plezSayNot)
								$query->orWhereNotBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
							else
								$query->orWhereBetween('date', array_map('trim', explode(' - ', $splitMePlz[$bliat_1])) );
						}
						break;

					case 'nas':
						if ($plezSayNot)
							$query->whereNotIn('nas', $splitMePlz);
						else
							$query->whereIn('nas', $splitMePlz);
						break;
					case 'nac':
						if ($plezSayNot)
							$query->whereNotIn('nac', $splitMePlz);
						else
							$query->whereIn('nac', $splitMePlz);
						break;
					case 'username':
						if ($plezSayNot)
							$query->whereNotIn('username', $splitMePlz);
						else
							$query->whereIn('username', $splitMePlz);
						break;
					case 'action':
						for ($bliat_2=0; $bliat_2 < count($splitMePlz); $bliat_2++) {
							if ( $bliat_2 == 0) {
								if ($plezSayNot)
									$query->where('action','NOT LIKE', '%'.$splitMePlz[$bliat_2].'%');
								else
									$query->where('action','LIKE', '%'.$splitMePlz[$bliat_2].'%');
								continue;
							}
							if ($plezSayNot)
								$query->orWhere('action','NOT LIKE', '%'.$splitMePlz[$bliat_2].'%');
							else
								$query->orWhere('action','LIKE', '%'.$splitMePlz[$bliat_2].'%');
						}
						break;
					case 'cmd':
						for ($bliat_3=0; $bliat_3 < count($splitMePlz); $bliat_3++) {
							if ( $bliat_3 == 0) {
								if ($plezSayNot)
									$query->where('cmd','NOT LIKE', '%'.$splitMePlz[$bliat_3].'%');
								else
									$query->where('cmd','LIKE', '%'.$splitMePlz[$bliat_3].'%');
								continue;
							}
							if ($plezSayNot)
								$query->orWhere('cmd','NOT LIKE', '%'.$splitMePlz[$bliat_3].'%');
							else
								$query->orWhere('cmd','LIKE', '%'.$splitMePlz[$bliat_3].'%');
						}
						break;

				}
			}

			return $query;
		});

		$data['total'] = $tempData->count();

		$tempData = $tempData->take($size)->offset($start);

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

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

		if ( empty($period) OR empty($allParams['target']) ){
			$data['test23'] = $period;
			$data['test232'] = $allParams['target'];
			$data['error']['status']=true;
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
