<?php

namespace tgui\Controllers\ConfManager;

use tgui\Controllers\Controller;
use tgui\Controllers\ConfManager\ConfManagerHelper as Helper;
use Respect\Validation\Validator as v;

use tgui\Models\Conf_Queries;
use tgui\Models\Conf_Devices;

use tgui\Services\CMDRun\CMDRun as CMDRun;
use Symfony\Component\Yaml\Yaml;

class ConfManager extends Controller
{
	private $GIT_PATH = '/opt/tacacsgui/plugins/ConfigManager/cm_git.sh';
################################################
	public function getInfo($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confManager',
			'action' => 'info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$info = Helper::CmInfoStatus();
		$data['response'] = $info;
		$info = explode(' ', $info);
		$message = '';
		switch ($info[0]) {
			case 'running':
				$info[3] = ( $info[3] == 'Not') ? $info[3].' '.$info[4] : $info[3];
				$message = 'Running (pid '.$info[1].'). Was run at '. date('Y-m-d H:i:s', $info[2]).'. '. $info[3];
				break;
			case 'ready':
				$info[2] = ( $info[2] == 'Not') ? $info[2].' '.$info[3] : $info[2];
				$message = 'Ready. Last ended at '. date('Y-m-d H:i:s', $info[1]).'. '. $info[2];
				break;
			default:
				$message = 'Was never run';
				break;
		}
		$data['info'] = $message;
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	#########	POST Add New User	#########
	public function postToggle($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'toggle',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(7))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		switch ($req->getParam('action')) {
			case 'start':
				$data['info'] = Helper::CmInfoStatus();
				$this->createConfig();
				$data['status'] = $this->startCron([],true);
				break;
			case 'stop':
				$data['status'] = CMDRun::init()->
					setCmd(MAINSCRIPT)->
					setAttr(
						[
						'run',
						'cmd',
						'/opt/tacacsgui/plugins/ConfigManager/cm.py',
						'--cron-stop'
						])->
					get();
				break;
			case 'force':
				// /opt/tacacsgui/plugins/ConfigManager/cm.py -c /opt/tgui_data/confManager/config.yaml
				$this->createConfig();
				$data['status'] = CMDRun::init()->
					setCmd('/opt/tacacsgui/plugins/ConfigManager/cm.py')->
					setAttr(
						[
						'-c',
						'/opt/tgui_data/confManager/config.yaml',

						])->toBackground()->
					get();
					sleep(3);
				break;

			default:
				$data['status'] = 'error';
				break;
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New User	###############END###########
#################
	public function postDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'del',
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
		$filename = $req->getParam('name');
		$group = $req->getParam('group');
		if ( $group ) $filename = $group.'/'.$filename;
		$request_attr = '--delete='.$filename;
		$data['result'] = CMDRun::init()->
			setCmd(MAINSCRIPT)->
			setAttr(['run', 'cmd', $this->GIT_PATH, $request_attr])->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	// public function postTacgui($req,$res)
	// {
	// 	//INITIAL CODE////START//
	// 	$data=array();
	// 	$data=$this->initialData([
	// 		'type' => 'post',
	// 		'object' => 'confManager',
	// 		'action' => 'tacgui users',
	// 	]);
	// 	#check error#
	// 	if ($_SESSION['error']['status']){
	// 		$data['error']=$_SESSION['error'];
	// 		return $res -> withStatus(401) -> write(json_encode($data));
	// 	}
	// 	//INITIAL CODE////END//
	// 	//CHECK ACCESS TO THAT FUNCTION//START//
	// 	if(!$this->checkAccess(1))
	// 	{
	// 		return $res -> withStatus(403) -> write(json_encode($data));
	// 	}
	// 	//CHECK ACCESS TO THAT FUNCTION//END//
	// 	$validation = $this->validator->validate($req, [
	// 		'ip' => v::NotEmpty()->ip(),
	// 		'date_a' => v::NotEmpty()->date(),
	// 		'date_b' => v::NotEmpty()->date(),
	// 	]);
	//
	// 	if ($validation->failed()){
	// 		$data['error']['status']=true;
	// 		$data['error']['validation']=$validation->error_messages;
	// 		return $res -> withStatus(200) -> write(json_encode($data));
	// 	}
	//
	// 	$ip = $req->getParam('ip');
	// 	$date_start = date('Y-m-d H:i:s', min( strtotime($req->getParam('date_a')), strtotime($req->getParam('date_b')) ) );
	// 	$date_end = date('Y-m-d H:i:s', max( strtotime($req->getParam('date_a')), strtotime($req->getParam('date_b')) ) );
	//
	// 	$data['users'] = $this->db::connection('logging')->select( $this->db::raw("
	// 		SELECT username, sum(authe) as authe, sum(autho) as autho, sum(acc) as acc FROM (
	// 			SELECT username, COUNT(*) AS authe, 0 AS autho, 0 AS acc
	// 			FROM tgui_log.tac_log_authentication AS tae
	// 			WHERE tae.nas='".$ip."' AND action LIKE '%succeeded' AND
	// 				tae.date BETWEEN '".$date_start."' AND '".$date_end."'
	// 			GROUP BY tae.username
	// 			UNION ALL
	// 			SELECT username, 0 AS authe, COUNT(*) AS autho, 0 AS acc
	// 			FROM tgui_log.tac_log_authorization AS tao
	// 			WHERE tao.nas='".$ip."' AND action='permit' AND
	// 				tao.date BETWEEN '".$date_start."' AND '".$date_end."'
	// 			GROUP BY tao.username
	// 			UNION ALL
	// 			SELECT username, 0 AS authe, 0 AS autho, COUNT(*) AS acc
	// 			FROM tgui_log.tac_log_accounting AS tac
	// 			WHERE tac.nas='".$ip."' AND cmd IS NOT NULL AND
	// 				tac.date BETWEEN '".$date_start."' AND '".$date_end."'
	// 			GROUP BY tac.username
	// 		) AS total_u GROUP BY username
	// 	"));
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
	// }
	public function postTacguiAAA($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'tacgui aaa',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$validation = $this->validator->validate($req, [
			'ip' => v::NotEmpty()->ip(),
			'date_a' => v::NotEmpty()->date(),
			'date_b' => v::NotEmpty()->date(),
			'section' => v::oneOf( v::equals('authe'), v::equals('autho'), v::equals('acc') ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$ip = $req->getParam('ip');
		$uname = $req->getParam('username');
		if ($uname == 'undefined') $uname = '';
		$section = $req->getParam('section');
		$date_start = date('Y-m-d H:i:s', min( strtotime($req->getParam('date_a')), strtotime($req->getParam('date_b')) ) );
		$date_end = date('Y-m-d H:i:s', max( strtotime($req->getParam('date_a')), strtotime($req->getParam('date_b')) ) );

		$table = 'tac_log_authentication';
		$select = ['nac','date','action'];
		$data['log'] = [];

		switch ($section) {
			case 'authe':
				$data['log'] = $this->db::connection('logging')->table($table)->select($select)->
					where([['username',$uname],['nas',$ip]])->
					where('action', 'like', '%succeeded')->
					whereBetween('date', [$date_start, $date_end])->get();
				break;
			case 'autho':
				$table = 'tac_log_authorization';
				$select = ['nac','date','cmd'];
				$data['log'] = $this->db::connection('logging')->table($table)->select($select)->
					where([['username',$uname],['nas',$ip],['action','permit']])->
					whereBetween('date', [$date_start, $date_end])->get();
				break;
			case 'acc':
				$table = 'tac_log_accounting';
				$select = ['nac','date','cmd'];
				$data['log'] = $this->db::connection('logging')->table($table)->select($select)->
					where([['username',$uname],['nas',$ip]])->
					whereNotNull('cmd')->
					whereBetween('date', [$date_start, $date_end]);
				//$data['sql'] = $data['log']->toSql();
				$data['log'] = $data['log']->get();
				break;
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	public function postDiffBrief($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'diff',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$validation = $this->validator->validate($req, [
			'type' => v::oneOf( v::equals('brief'), v::equals('full'), v::equals('preview'), v::equals('native') ),
			'context' => v::numeric(),
			'hash_a' => v::alnum(),
			'hash_b' => v::alnum(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$filename = preg_replace('/^\//', '', $req->getParam('filename') );
		// $data['test__'] = $filename;
		// /opt/tacacsgui/plugins/ConfigManager/cm_git.sh '--show=1a2819b:/123123/router_12__15_17'

		$data['native'] = '';
		$data['show'] = '';
		$data['test23'] =true;
		if ( $req->getParam('type') == 'preview') {
			$data['show'] = CMDRun::init()->
				setCmd(MAINSCRIPT)->
				setAttr(
					['run','cmd',$this->GIT_PATH,'--show='.$req->getParam('hash_a').':'.$filename])->
				get();

			return $res -> withStatus(200) -> write(json_encode($data));
		}
		if ( $req->getParam('type') == 'native') {
			$data['native'] = CMDRun::init()->
				setCmd(MAINSCRIPT)->
				setAttr(
					[
					'run',
					'cmd',
					$this->GIT_PATH,
					'--context='.$req->getParam('context'),
					'--file-b='. ( $filename ),
					'--diff='.$req->getParam('hash_b').':'.$req->getParam('hash_a').':'.$filename
					])->
				get();
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$request = [
			'run',
			'cmd',
			$this->GIT_PATH,
			'--context='.$req->getParam('context'),
			'--file-b='. ( $filename ),
			'--full-file='. ( ($req->getParam('type') == 'full') ? '1' : '0' ),
			'--diff='.$req->getParam('hash_b').':'.$req->getParam('hash_a').':'.$filename
		];
		//$req->getParam('filename_a');

		$diff_cmd = CMDRun::init()->
			setCmd(MAINSCRIPT)->
			setAttr($request);
		$data['cmd_diff'] = $diff_cmd->showCMD();
		$data['diff'] = false;
		#return $res -> withStatus(200) -> write(json_encode($data));
		$diff_full = $diff_cmd->get();
		if ( empty( $diff_full ) ){

			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$diff_full = explode( PHP_EOL, $diff_full );

	  $diff_header = explode(' ', $diff_full[0]);
		$data['diff']['header'] = [
			'rename' => [
				'from' => '',
				'to' => ''
			],
			'diff' => [],
			'similarity' => ''
		];
		//$data['diff']['header'] = [ $diff_header[2], $diff_header[3]];
		//$diff_markers = [explode(' ', $diff_full[2]), explode(' ', $diff_full[3])];
		//$data['diff']['markes'] = [ $diff_markers[0][0] => $diff_markers[0][1], $diff_markers[1][0] => $diff_markers[1][1]];
		//$diff_full = array_slice($diff_full, 4);
		$data['diff']['full_diff'] = $diff_full;
		$data['diff']['chunk_list'] = ['counters' => []];
		$data['diff']['file_a'] = [];
		$data['diff']['file_b'] = [];
		$data['diff']['unknown'] = [];
		$chunck_trigger = false;
		$chunck_current_a = '';
		$chunck_current_b = '';
		$ommitLines = 0;
		for ($i=0; $i < count($diff_full); $i++) {
			if ($ommitLines) {
				$ommitLines--;
				continue;
			}
			$diff_full[$i] = trim($diff_full[$i]);
			if ( preg_match('/(^@@.*@@.*)/', $diff_full[$i]) ){
				// if ( $chunck_trigger ){
				// 	$data['diff']['file_a'][] = sprintf('<span class="chunk_trigger">%s</span>', '--- omitted text ---' );
				// 	$data['diff']['file_b'][] = sprintf('<span class="chunk_trigger">%s</span>', '--- omitted text ---' );
				// }
				$chunck_trigger = true;
				preg_match('/^(@@.*@@)/', $diff_full[$i], $matches, PREG_OFFSET_CAPTURE);
				$matches = explode(' ', $matches[1][0]);
				$matches[2] = preg_replace('/^\+/', '', $matches[2]);
				$matches[1] = preg_replace('/^-/', '', $matches[1]);
				$file_a_line_num = explode(',', $matches[2]);
				$file_b_line_num = explode(',', $matches[1]);
				$data['diff']['chunk_list']['file_a'][] = $chunck_current_a = 'chunk_'.$file_a_line_num[0].' '.($file_a_line_num[0] - 1);
				$data['diff']['chunk_list']['file_b'][] = $chunck_current_b = 'chunk_'.$file_b_line_num[0].' '.($file_b_line_num[0] - 1);
				if ( ! in_array('chunk_'.$file_a_line_num[0], $data['diff']['chunk_list']['counters']) )
					$data['diff']['chunk_list']['counters'][] = 'chunk_'.$file_a_line_num[0];
				if ( ! in_array('chunk_'.$file_b_line_num[0], $data['diff']['chunk_list']['counters']) )
					$data['diff']['chunk_list']['counters'][] = 'chunk_'.$file_b_line_num[0];

				//$startPart = trim( preg_replace('/(^@@.*@@)/', '', $diff_full[$i]) );
				if ( $file_a_line_num[0] != 1 ) $data['diff']['file_a'][] = [
					'text' =>  'New Chunk. Start from line ' . $file_a_line_num[0],
					'class' => 'chunk_trigger'
				];

				if ( $file_b_line_num[0] != 1 ) $data['diff']['file_b'][] = [
					'text' =>  'New Chunk. Start from line ' . $file_b_line_num[0],
					'class' => 'chunk_trigger'
				];

				// if ( $startPart ) {
				// 	$data['diff']['file_a'][] = sprintf('<div class="unchanged %s">%s</div>', $chunck_current_a, $startPart);
				// 	$data['diff']['file_b'][] = sprintf('<div class="unchanged %s">%s</div>', $chunck_current_a, $startPart);
				// }
				continue;
			} elseif ( ! $chunck_trigger ) {
				switch (true) {
					case ( preg_match('/^diff --git/', $diff_full[$i]) ):
						$data['diff']['header']['diff'] = array_slice( explode(' ', $diff_full[$i]), 2);
						break;
					case ( preg_match('/^rename to/', $diff_full[$i]) ):
						$data['diff']['header']['rename']['to'] = $diff_full[$i];
						break;
					case ( preg_match('/^rename from/', $diff_full[$i]) ):
						$data['diff']['header']['rename']['from'] = $diff_full[$i];
						break;
					case ( preg_match('/^similarity/', $diff_full[$i]) ):
						$data['diff']['header']['similarity'] = $diff_full[$i];
						break;
					default:
						$data['diff']['unknown'][] = $diff_full[$i];
						break;
				}
				continue;
			}

			if ( preg_match('/.*No newline at end of file.*/', $diff_full[$i]) ) continue;
			if ( preg_match('/(^-.*$|^\+.*$)/', $diff_full[$i]) )
			{
				if ( preg_match('/^\+.*$/', $diff_full[$i]) AND !preg_match('/^-.*$/', $diff_full[$i-1]) ) {
					$data['diff']['file_a'][] = [
						'text' =>  preg_replace('/^\+/', '', $diff_full[$i]),
						'class' => 'addition',
						'chunk_css' => $chunck_current_a,
						'chunk' => explode(' ', $chunck_current_a)[0]
					];
					// sprintf('<div class="addition %s">%s</div>', $chunck_current_a, preg_replace('/^\+/', '', $diff_full[$i]) );
					$data['diff']['file_b'][] = [
						'text' =>  '',
						'class' => 'empty',

					]; //'<div class="empty"> </div>';
				}
				if ( preg_match('/^\-.*$/', $diff_full[$i]) ) {
					if ( preg_match('/^\+.*$/', $diff_full[$i+1] ) ){
						$data['diff']['file_a'][] = [
							'text' =>  preg_replace('/^\+/', '', trim( $diff_full[$i+1] ) ),
							'class' => 'addition',
							'chunk_css' => $chunck_current_a,
							'chunk' => explode(' ', $chunck_current_a)[0]
						];
						// sprintf('<div class="addition %s">%s</div>', $chunck_current_a, preg_replace('/^\+/', '', trim( $diff_full[$i+1] ) ) );
						$data['diff']['file_b'][] = [
							'text' =>  preg_replace('/^-/', '', $diff_full[$i]),
							'class' => 'subtract',
							'chunk_css' => $chunck_current_b,
							'chunk' => explode(' ', $chunck_current_b)[0]
						];
						// sprintf('<div class="subtract %s">%s</div>', $chunck_current_b, preg_replace('/^-/', '', $diff_full[$i]) );
					} elseif ( preg_match('/^\-.*$/', $diff_full[$i+1] ) ) {
						//$ommitLines = 0;
						$deletions = 0;
						$additions = 0;
						while (true) {
							$ommitLines++;
							$deletions++;
							if ( ! preg_match('/^\-.*$/', $diff_full[$i+$ommitLines]) ) break;
						}
						if ( preg_match('/^\+.*$/', $diff_full[$i+$ommitLines]) ){
							while (true) {
								$ommitLines++;
								$additions++;
								if ( ! preg_match('/^\+.*$/', $diff_full[$i+$ommitLines]) ) break;
							}
							$additions_i = $additions;
							$deletions_i = $deletions;
							for ($io=0; $io < $ommitLines; $io++) {
								if (!$deletions AND !$additions) continue;
								if ($deletions){
									$data['diff']['file_b'][] = [
										'text' =>  preg_replace('/^-/', '', $diff_full[$i+$io]),
										'class' => 'subtract',
										'chunk_css' => $chunck_current_b,
										'chunk' => explode(' ', $chunck_current_b)[0]
									];
									// sprintf('<div class="subtract %s">%s</div>', $chunck_current_b, preg_replace('/^-/', '', $diff_full[$i+$io]) );
									$deletions--;
								} else {
									$data['diff']['file_b'][] = [
										'text' => '',
										'class' => 'empty',
									];
									// '<div class="empty"> </div>';
								}
								if ($additions){
									$data['diff']['file_a'][] = [
										'text' =>  preg_replace('/^\+/', '', trim( $diff_full[$i+$io+$deletions_i] ) ),
										'class' => 'addition',
										'chunk_css' => $chunck_current_a,
										'chunk' => explode(' ', $chunck_current_a)[0]
									];
									// sprintf('<div class="addition %s">%s</div>', $chunck_current_a, preg_replace('/^\+/', '', trim( $diff_full[$i+$io+$deletions_i] ) ) );
									$additions--;
								} else {
									$data['diff']['file_a'][] = [
										'text' => '',
										'class' => 'empty',
									];
									// '<div class="empty"> </div>';
								}
							}
							$ommitLines--;
						} else {
							for ($io=0; $io < $ommitLines; $io++) {
								$data['diff']['file_b'][] = [
									'text' =>  preg_replace('/^-/', '', $diff_full[$i+$io]),
									'class' => 'subtract',
									'chunk_css' => $chunck_current_b,
									'chunk' => explode(' ', $chunck_current_b)[0]
								];
								// sprintf('<div class="subtract %s">%s</div>', $chunck_current_b, preg_replace('/^-/', '', $diff_full[$i+$io]) );
								$data['diff']['file_a'][] = [
									'text' => '',
									'class' => 'empty',
								];
								// '<div class="empty"> </div>';
							}
						}
					} else {
						$data['diff']['file_b'][] = [
							'text' =>  preg_replace('/^-/', '', $diff_full[$i]),
							'class' => 'subtract',
							'chunk_css' => $chunck_current_b,
							'chunk' => explode(' ', $chunck_current_b)[0]
						];
						// sprintf('<div class="subtract %s">%s</div>', $chunck_current_b, preg_replace('/^-/', '', $diff_full[$i]) );
						$data['diff']['file_a'][] = [
							'text' => '',
							'class' => 'empty',
						];
						// '<div class="empty"> </div>';
					}
				}
			} else {
				$data['diff']['file_a'][] = [
					'text' => $diff_full[$i],
					'class' => 'unchanged',
					'chunk_css' => $chunck_current_a,
					'chunk' => explode(' ', $chunck_current_a)[0]
				];
				// sprintf('<div class="unchanged %s">%s</div>', $chunck_current_a, $diff_full[$i]);
				$data['diff']['file_b'][] = [
					'text' => $diff_full[$i],
					'class' => 'unchanged',
					'chunk_css' => $chunck_current_b,
					'chunk' => explode(' ', $chunck_current_b)[0]
				];
				// sprintf('<div class="unchanged %s">%s</div>', $chunck_current_b, $diff_full[$i]);
			}

		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}
########	Add New User	###############END###########
#################
	public function postTacacs($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'diff info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$filename = end(explode( '/', preg_replace('/^\//', '', $req->getParam('filename') ) ));
		$data['info'] = false;
		list($dev_id, $q_id) = explode( '_', explode('__', $filename)[1] );
		//$data['info1'] = $dev_id;
		$data['info'] = $dev = $this->db::table('confM_devices as cd')->
			leftJoin('obj_addresses as addr', 'addr.id', '=', 'cd.address')->
			leftJoin('tac_devices as td', 'td.address', '=', 'cd.address')->
			select(['cd.*','addr.address as ipaddress','td.name as tacdevice'])->
			where('cd.id',$dev_id)->first();
		if (!$dev)
			return $res -> withStatus(200) -> write(json_encode($data));
		if (!empty($dev->ipaddress)) $dev->ipaddress = explode('/', $dev->ipaddress)[0];
		$ip = $dev->ipaddress;
		$date_start = date('Y-m-d H:i:s', min( strtotime($req->getParam('date_a')), strtotime($req->getParam('date_b')) ) );
		$date_end = date('Y-m-d H:i:s', max( strtotime($req->getParam('date_a')), strtotime($req->getParam('date_b')) ) );

		$data['users'] = $this->db::connection('logging')->select( $this->db::raw("
			SELECT username, sum(authe) as authe, sum(autho) as autho, sum(acc) as acc FROM (
				SELECT username, COUNT(*) AS authe, 0 AS autho, 0 AS acc
				FROM tgui_log.tac_log_authentication AS tae
				WHERE tae.nas='".$ip."' AND action LIKE '%succeeded' AND
					tae.date BETWEEN '".$date_start."' AND '".$date_end."'
				GROUP BY tae.username
				UNION ALL
				SELECT username, 0 AS authe, COUNT(*) AS autho, 0 AS acc
				FROM tgui_log.tac_log_authorization AS tao
				WHERE tao.nas='".$ip."' AND action='permit' AND
					tao.date BETWEEN '".$date_start."' AND '".$date_end."'
				GROUP BY tao.username
				UNION ALL
				SELECT username, 0 AS authe, 0 AS autho, COUNT(*) AS acc
				FROM tgui_log.tac_log_accounting AS tac
				WHERE tac.nas='".$ip."' AND cmd IS NOT NULL AND
					tac.date BETWEEN '".$date_start."' AND '".$date_end."'
				GROUP BY tac.username
			) AS total_u GROUP BY username
		"));

		return $res -> withStatus(200) -> write(json_encode($data));
}
	public function getDiffList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'diff info',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$data['results'] = [];
		$params = $req->getParams();
		$params['extra'] = json_decode($params['extra']);
		$data['isFile'] = file_exists('/opt/tgui_data/confManager/configs'.$params['extra']->file);
		$data['path'] = '/opt/tgui_data/confManager/configs'.$params['extra']->file;
		$params['extra']->file = preg_replace('/^\//', '', $params['extra']->file);
		if (!$data['isFile'] OR empty($params['extra']->file)){
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$cmd = CMDRun::init()->
			setCMD($this->GIT_PATH)->setAttr('--commit-list='.$params['extra']->file);
		$data['cmd'] = $cmd->showCMD();
		$tempData = $cmd->get();
		if (empty(trim($tempData))){
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$tempData = explode(PHP_EOL, $tempData);
		for ($i=0; $i < count($tempData); $i++) {
			$tempData[$i] = explode(' ', $tempData[$i]);
			$test = $tempData[$i][0];
			$data['results'][]=[
				'epoch' => $tempData[$i][0],
				'text' => date( 'Y-m-d H:i:s', $tempData[$i][0]),
				'id' => date( 'Y-m-d H:i:s', $tempData[$i][0]),
				'hash' => $tempData[$i][1],
			];
		}

		$data['timezone'] = date_default_timezone_get();
		$data['test'] = $test;
		// $page = $req->getParam('page');
		// $start = 1 + ( ($page - 1) * 10 );
		// $end = $page * 10;
		//
		// $cmd = CMDRun::init()->
		// 	setCmd(MAINSCRIPT)->
		// 	setAttr(['run', 'cmd', $this->GIT_PATH, '--commit-start='.$start, '--commit-end='.$end,'--commit-list='.$req->getParam('extra')['filename']]);
		// $data['cmd'] = $cmd->showCMD();
		//
		// $commit_list = $cmd->get();
		//
		// $commit_list = explode(PHP_EOL, $commit_list);
		// for ($i=0; $i < count($commit_list); $i++) {
		// 	$commit_list[$i] = explode(' ', $commit_list[$i]);
		// 	$data['results'][] = [
		// 			'id' => $commit_list[$i][1],
		// 			'text' => date( 'Y-m-d H:i:s', $commit_list[$i][0]),
		// 			'hash' =>$commit_list[$i][1],
		// 			'filename' =>$commit_list[$i][2]
		// 		];
		// }
		//
		// $data['pagination'] = ['more'=> count($data['results']) == 10];

		return $res -> withStatus(200) -> write(json_encode($data));
}
	public function postMore($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'more',
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

		//$data['rowId'] = $req->getParam('rowId');
		$filename = $req->getParam('name');
		$group = $req->getParam('group');
		if ( $group ) $filename = $group.'/'.$filename;
		$request_attr = ['--info='.$filename];
		$data['more'] = explode(' ', CMDRun::init()->
			setCmd($this->GIT_PATH)->
			setAttr($request_attr)->get() );
		if ( isset($data['more'][1]) ) $data['more'][1] = date( 'Y-m-d H:i:s', $data['more'][1]);
		return $res -> withStatus(200) -> write(json_encode($data));
}
	public function getCron($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confManager',
			'action' => 'cron',
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
		$cron = [
			'cm' => [
				'period' => 'day',
				'time' => '00:00',
				'week' => 1,
			],
			'git' => [
				'period' => 60,
			]
		];
		if ( !is_file('/opt/tgui_data/confManager/cron.yaml') ){
			$yaml = Yaml::dump( $cron, 4 );
			file_put_contents( '/opt/tgui_data/confManager/cron.yaml', $yaml);
			$data['file'] = 'creating';
			$data['cron'] = $cron;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		$data['file'] = 'created';
		$data['cron'] = Yaml::parseFile('/opt/tgui_data/confManager/cron.yaml');

		return $res -> withStatus(200) -> write(json_encode($data));
}
	public function postCron($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'cron',
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
		if ( !isset($allParams['cm']) ) $allParams['cm'] = [];
		if ( !isset($allParams['git']) ) $allParams['git'] = [];
		$this->createConfig();
		$data['crontab'] = $this->startCron($allParams);

		return $res -> withStatus(200) -> write(json_encode($data));
}


	public function getDir($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confManager',
			'action' => 'dir',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$cmd = CMDRun::init()->setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
			setAttr('--dir-list'.'='.$req->getParam('path'));
		$data['_cmd'] = $cmd->showCMD();
		$list = explode(PHP_EOL, $cmd->get());
		$list_out = [];
		$level = 0;
		for ($i=0; $i < count($list); $i++) {
			if (empty(trim($list[$i]))) continue;
			$list_out[]= [
				'name' => preg_replace('/\/$/', '', str_replace($req->getParam('path'), '', $list[$i]) ),
				'path' => $list[$i],
				'id' => $list[$i],
				'partial_path' => array_slice( explode('/', $list[$i]), 0, -1 ),
				'hasChildren' => true
			];
		}
		$data['list'] = $list_out;

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getDirExploer($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confManager',
			'action' => 'dir exploer',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		$cmd = CMDRun::init()->setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
			setAttr('--dir-exploer'.'='.$req->getParam('path'));
		$data['_cmd'] = $cmd->showCMD();
		$list = explode(PHP_EOL, $cmd->get());
		$list_out = [];
		if (count($list) == 1 and empty($list[0])) $list = [];
		$data['list'] = $list;

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function postDirAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'dir add',
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
		$validation = $this->validator->validate($req, [
			'fname' => v::noWhitespace()->notEmpty(),
			'parent' => v::noWhitespace()->notEmpty()->directory(),
			'path' => v::noWhitespace()->notEmpty()->not( v::directory())->not(v::file() ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['status'] = mkdir($req->getParam('path'));

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function postDirMove($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'dir move',
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
		$validation = $this->validator->validate($req, [
			'fname' => v::noWhitespace()->notEmpty(),
			'path_old' => v::noWhitespace()->notEmpty()->oneOf( v::directory())->not(v::file() ),
			'path' => v::noWhitespace()->notEmpty()->not( v::directory())->not(v::file() ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['status'] = rename($req->getParam('path_old'), $req->getParam('path'));

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function postDirDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confManager',
			'action' => 'dir del',
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
		$validation = $this->validator->validate($req, [
			'path' => v::noWhitespace()->notEmpty()->oneOf( v::directory(), v::file() ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['status'] = CMDRun::init()->setCmd('rm')->setAttr(['-rf', $req->getParam('path')])->get();//rmdir($req->getParam('path'));
		$data['status'] = empty($data['status']);

		return $res -> withStatus(200) -> write(json_encode($data));
	}



// public function postDatatables($req,$res)
// {
// 	//INITIAL CODE////START//
// 	$data=array();
// 	$data=$this->initialData([
// 		'type' => 'post',
// 		'object' => 'main list',
// 		'action' => 'datatables',
// 	]);
// 	#check error#
// 	if ($_SESSION['error']['status']){
// 		$data['error']=$_SESSION['error'];
// 		return $res -> withStatus(401) -> write(json_encode($data));
// 	}
// 	//INITIAL CODE////END//
//
// 	unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//
//
// 	//CHECK ACCESS TO THAT FUNCTION//START//
// 	if(!$this->checkAccess(4, true))
// 	{
// 		$data['data'] = [];
// 		$data['recordsTotal'] = 0;
// 		$data['recordsFiltered'] = 0;
// 		return $res -> withStatus(200) -> write(json_encode($data));
// 	}
// 	//CHECK ACCESS TO THAT FUNCTION//END//
//
// 	$params = $req->getParams(); //Get ALL parameters form Datatables
//
// 	#/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh --reverse=1 --sort=name --start-line=1 --end-line=7 --name=fi --group=fold
// 	#/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh  '--reverse=0' '--sort=date_c' '--start-line=1' '--end-line=10'
// 	$start_line = 10 * ( $params['page'] - 1 );
// 	$end_line = 10 * ( $params['page'] - 1 ) + $params['pageSize'];
// 	$reverse = ( $params['order'][0]['dir'] == 'asc') ? 0 : 1;
// 	$sort_colum = $params['columns'][$params['order'][0]['column']]['data'];
// 	$columns = ['','name','group'];
//
// 	$searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
// 	$temp = $this->queriesMaker($columns, $searchString);
// 	$queries = $temp['queries'];
//
// 	$data['filter'] = $temp['filter'];
//
// 	$data['queries'] = $queries;
// 	$data['columns'] = $columns;
//
// 	$request_attr = ['--reverse='.$reverse,'--sort='.$sort_colum,'--start-line='.$start_line,'--end-line='.$end_line];
// 	// $request_attr = ['--reverse='.$reverse,'--sort='.$sort_colum];
//
// 	if ( $data['queries'] ){
// 		if ( $data['queries']['='] ){
// 			foreach ($data['queries']['='] as $key => $value_arr) {
// 				foreach ($value_arr as $value) {
// 					array_push( $request_attr, '--'.$key.'='.$value );
// 				}
// 			}
// 		}
// 	}
//
// 	$data['cmd_'] = CMDRun::init()->
// 		setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
// 		setAttr($request_attr)->showCMD();
// 	$table_data = CMDRun::init()->
// 		setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
// 		setAttr($request_attr)->
// 		get();
// 	$table_data = explode(PHP_EOL, $table_data);
//
// 	// $data['preg'] = [];
// 	// preg_match_all('/.*__(\d)_(\d)$/',
//   //   'foo bar',)
// 	$data['recordsTotal'] = intval( preg_replace('/total\s+/', '', $table_data[0]) );
// 	$data['recordsFiltered'] = intval( preg_replace('/filtered\s+/', '', $table_data[1]) );
// 	unset($table_data[1]); unset($table_data[0]);
// 	//Fast Review
// 	$d_q_id = [];
// 	foreach ($table_data as $row) {
// 		$columns = preg_split('/\s+/', $row);
// 		if ( !preg_match_all('/.*__(\d+)_(\d+)/', $columns[2]) ) continue;
// 		preg_match_all( '/.*__(\d+)_(\d+)/', $columns[2], $match );
// 		$d_q_id[] = [ 'd_id' => $match[1][0], 'q_id' => $match[2][0]];
// 	}
//
// 	$data['log2'] = $d_q_id;
// 	$data['log1'] = $this->db::connection('logging')->
// 		table('cm_log as L1')->
// 		select([$this->db::raw("concat(device_id, '_', query_id) as suffix"), 'status'])->
// 		when( !empty($d_q_id),
// 			function($query) use ($d_q_id)
// 			{
// 				foreach ($d_q_id as $dq) {
// 					$query->orWhere([ ['device_id', $dq['d_id']], ['query_id', $dq['q_id']] ]);
// 				}
// 			}
// 		)->
// 		whereRaw('L1.DATE=(SELECT MAX(DATE) FROM cm_log AS L2 WHERE L2.device_id=L1.device_id AND L2.query_id=L1.query_id)')->
// 		get()->keyBy('suffix');
//
// 	$queries_data = Conf_Queries::select(['id','name'])->get()->keyBy('id');
// 	//$devices_data = Conf_Devices::select(['id','name'])->get()->keyBy('id');
//
// 	$data['data'] = [];
// 	foreach ($table_data as $row) {
// 		$columns = preg_split('/\s+/', $row);
// 		preg_match_all( '/.*__(\d+)_(\d+)$/', $columns[2], $match );
// 		$dev_id = (isset($match[1]) AND isset($match[1][0])) ? $match[1][0] : 0;
// 		$que_id = (isset($match[2]) AND isset($match[2][0])) ? $match[2][0] : 0;
//
// 		$buttons='<a class="btn btn-xs btn-default btn-flat" title="download latest version" href="/api/confmanager/file/download/?group='.preg_replace("/[\/]?$columns[2]/", '', $columns[3]).'&name='.$columns[2].'" target="_blank"><i class="fa fa-cloud-download"></i></a>'.
// 		' <a class="btn btn-info btn-xs btn-flat"  title="quick refresh" disabled><i class="fa fa-refresh"></i></a>'.
// 		' <a class="btn btn-warning btn-xs btn-flat" href="/confM_preview.php?group='.preg_replace("/[\/]?$columns[2]/", '', $columns[3]).'&name='.$columns[2].'">diff</a>'.
// 		' <button class="btn btn-danger btn-xs btn-flat" onclick="cm_list.del(\''.preg_replace("/[\/]?$columns[2]/", '', $columns[3]).'\',\''.$columns[2].'\')">Del</button>';
//
// 		$data['data'][] = [
// 			'name' => $columns[2],
// 			'device_name' => (preg_match_all('/.*__(\d+)_(\d+)$/',
// 		    $columns[2])) ?  preg_replace('/__(\d+)_(\d+)$/', '', $columns[2]) : $columns[2],
// 			'query_name' => ( isset($queries_data[$que_id]) ) ? $queries_data[$que_id]->name : '',
// 			'device_id' => $dev_id,
// 			'query_id' => $que_id,
// 			'match' => $match,
// 			'group' => preg_replace("/[\/]?$columns[2]/", '', $columns[3]),
// 			'date_change' => date( 'Y-m-d H:i:s', $columns[0]),
// 			'date_commit' => '<i class="fa fa-circle-o-notch fa-spin"></i>',
// 			'commits' => '<i class="fa fa-circle-o-notch fa-spin"></i>',
// 			'size' => $columns[1],
// 			'status' => ( isset($data['log1'][$dev_id.'_'.$que_id]) ) ? $data['log1'][$dev_id.'_'.$que_id]->status : '',
// 			'buttons' => $buttons,
// 		];
// 	}
//
// 	//Some additional parameters for Datatables
// 	$data['draw']=intval( $params['draw'] );
//
// 	return $res -> withStatus(200) -> write(json_encode($data));
// }


public function postLogDatatables($req,$res)
{
	//INITIAL CODE////START//
	$data=array();
	$data=$this->initialData([
		'type' => 'post',
		'object' => 'confModels log',
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
	if(!$this->checkAccess(4, true))
	{
		$data['data'] = [];
		$data['recordsTotal'] = 0;
		$data['recordsFiltered'] = 0;
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	//CHECK ACCESS TO THAT FUNCTION//END//

	$params = $req->getParams(); //Get ALL parameters form Datatables

	$columns = $this->APICheckerCtrl->getTableTitles('cm_log','logging'); //Array of all columnes that will used
	array_unshift( $columns, 'id' );
	//array_push( $columns, 'created_at', 'updated_at' );
	$data['columns'] = $columns;
	$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];
	$size = $params['pageSize'];
	$start = $params['pageSize'] * ($params['page'] - 1);
	//Filter end
	$data['recordsTotal'] = $this->db::connection('logging')->table('cm_log')->count();
	//Get temp data for Datatables with Fliter and some other parameters
	$tempData = $this->db::connection('logging')->table('cm_log')->select($columns)->
	when( !empty($queries),
		function($query) use ($queries)
		{
			$query->orWhere('date','LIKE', '%'.$queries.'%');
			return $query;
		});
	$data['total'] = $tempData->count();

	$tempData->take($size)->offset($start);

	if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
			$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

	$data['data'] = $tempData->get()->toArray();

	return $res -> withStatus(200) -> write(json_encode($data));
	// $data['columns'] = $columns;
	// $queries = [];
	// $data['filter'] = [];
	// $data['filter']['error'] = false;
	// $data['filter']['message'] = '';
	// //Filter start
	// $searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
	// $temp = $this->queriesMaker($columns, $searchString);
	// $queries = $temp['queries'];
	// $data['filter'] = $temp['filter'];
	//
	// $data['queries'] = $queries;
	// $data['columns'] = $columns;
	// //Filter end
	// $data['recordsTotal'] = $this->db::connection('logging')->table('cm_log')->count();
	// //Get temp data for Datatables with Fliter and some other parameters
	// $tempData = $this->db::connection('logging')->table('cm_log')->select($columns)->
	// 	when( !empty($queries),
	// 		function($query) use ($queries)
	// 		{
	// 			foreach ($queries as $condition => $attr) {
	// 				switch ($condition) {
	// 					case '!==':
	// 						foreach ($attr as $column => $value) {
	// 							$query->whereNotIn($column, $value);
	// 						}
	// 						break;
	// 					case '==':
	// 						foreach ($attr as $column => $value) {
	// 							$query->whereIn($column, $value);
	// 						}
	// 						break;
	// 					case '!=':
	// 						foreach ($attr as $column => $valueArr) {
	// 							for ($i=0; $i < count($valueArr); $i++) {
	// 								if ($i == 0) $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
	// 								$query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
	// 							}
	// 						}
	// 						break;
	// 					case '=':
	// 						foreach ($attr as $column => $valueArr) {
	// 							for ($i=0; $i < count($valueArr); $i++) {
	// 								if ($i == 0) $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
	// 								$query->where($column,'LIKE', '%'.$valueArr[$i].'%');
	// 							}
	// 						}
	// 						break;
	// 					default:
	// 						//return $query;
	// 						break;
	// 				}
	// 			}
	// 			return $query;
	// 		});
	// 		$data['recordsFiltered'] = $tempData->count();
	//
	// 		$tempData = $tempData->
	// 		orderBy($params['columns'][$params['order'][0]['column']]['data'],$params['order'][0]['dir'])->
	// 		take($params['length'])->
	// 		offset($params['start'])->
	// 		get()->toArray();
	// 	//Creating correct array of answer to Datatables
	// 	$data['data']=array();
	// 	foreach($tempData as $model){
	// 		// $buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="cm_models.get(\''.$model['id'].'\',\''.$model['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="cm_models.del(\''.$model['id'].'\',\''.$model['name'].'\')">Del</button>';
	// 		// $model['buttons'] = $buttons;
	// 		array_push($data['data'],$model);
	// 	}
	// 	//Some additional parameters for Datatables
	// 	$data['draw']=intval( $params['draw'] );
	//
	// 	return $res -> withStatus(200) -> write(json_encode($data));
}



public function getPreview($req,$res)
{
	//INITIAL CODE////START//
	$data=array();
	$data=$this->initialData([
		'type' => 'post',
		'object' => 'confManager',
		'action' => 'preview',
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

	$data['preview'] = $this->createConfig(['write'=>false, 'preview'=>true]);
	//$data['preview2'] = $this->createConfig();
	return $res -> withStatus(200) -> write(json_encode($data));
}
################################################
	public function createConfig( $params = array() )
	{
		$params['write'] = ( isset($params['write']) ) ? $params['write'] : true;
		$params['preview'] = ( isset($params['preview']) ) ? $params['preview'] : false;

		$output = $this->db::table('confM_queries as q')->
			leftJoin('confM_bind_query_devices as qu_de', 'qu_de.query_id', '=', 'q.id')->
			// leftJoin('confM_bind_query_model as qu_mo', 'qu_mo.query_id', '=', 'q.id')->
			// leftJoin('confM_bind_query_creden as qu_cr', 'qu_cr.query_id', '=', 'q.id')->
			leftJoin('confM_credentials as cq', 'cq.id', '=', 'q.credential')->
			leftJoin('confM_devices as d', 'd.id', '=', 'qu_de.device_id')->
			leftJoin('obj_addresses as addr', 'addr.id', '=', 'd.address')->
			// leftJoin('confM_bind_devices_creden as de_cr', 'de_cr.device_id', '=', 'd.id')->
			leftJoin('confM_credentials as cd', 'cd.id', '=', 'd.credential')->
			leftJoin('confM_models as m', 'm.id', '=', 'q.model')->
			select([
				'q.id as q_id',
				'q.name as q_name',
				'q.path as path',
				'cq.username as q_uname',
				'cq.password as q_passwd',
				'q.f_group as group',
				'q.omit_lines as omitLines',
				'qu_de.device_id as d_id',
				'm.id as m_id',
				'd.name as d_name',
				'm.name as m_name',
				'm.prompt as m_prompt',
				$this->db::raw("substring_index(addr.address,'/',1) as ip"),
				// 'd.ip as ip',
				'd.protocol as protocol',
				'd.port as port',
				'd.prompt as d_prompt',
				'cd.username as d_uname',
				'cd.password as d_passwd'
			])->where('q.disabled',0)->get();
			//return $output;
			$output = json_decode( json_encode($output),true );

			$config = [
				'queries' => [],
				'git' => [
						'path' => '/opt/tgui_data/confManager/configs'
					],
				'log' => [
					'target' => 'mysql',
					'database' => DB_NAME_LOG,
					'username' => DB_USER,
					'password' => (!$params['preview']) ? DB_PASSWORD : '******',
					'host' => DB_HOST
				]
			];

			foreach ($output as $out) {
				//$prompt = ( !empty($out['d_prompt']) ) ? $out['d_prompt'] : $out['m_prompt'];
				$prompt_m = array_filter( array_map('trim', explode(',', $out['d_prompt']) ), function($value) { return $value !== ''; } );
				$prompt_d = array_filter( array_map('trim', explode(',', $out['m_prompt']) ), function($value) { return $value !== ''; } );
				if (!$params['preview'])
					$passwd = ( ( !empty($out['d_uname']) OR !empty($out['d_passwd']) ) ? $out['d_passwd'] : $out['q_passwd'] );
				else
					$passwd = '******';

				$config['queries'][] =
					[
						'name' => $out['d_name'].'__'.$out['d_id'].'_'.$out['q_id'],
						'ip' => $out['ip'],
						'protocol' => $out['protocol'],
						'port' => $out['port'],
						'device_id' => $out['d_id'],
						'device_name' => $out['d_name'],
						'query_name' => $out['q_name'],
						'query_id' => $out['q_id'],
						'credential' => [
							'type' => 'text',
							'username' => ( ( !empty($out['d_uname']) OR !empty($out['d_passwd']) ) ? $out['d_uname'] : $out['q_uname'] ),
							'password' => $passwd,
						],
						// 'group' => $out['group'],
						'path' => $out['path'],
						'prompt' => array_merge($prompt_d, $prompt_m),
						'omitLines' => array_filter( array_map('trim', explode(',', $out['omitLines']) ), function($value) { return $value !== ''; } ),
						'timeout' => 15,
						'expectations' => json_decode( json_encode( $this->db::table('confM_bind_model_expect')->
							select(['send','expect','write'])->
							where('model_id', $out['m_id'])->get() ), true )
					];
			}

			$yaml = Yaml::dump( $config, 4 );
			if ( $params['write'] ) {
				file_put_contents( '/opt/tgui_data/confManager/config.yaml', $yaml);
				return $config;
			} else {
				return $yaml;
			}

	}

	private function startCron($params, $read=false){
		$cron=[];
		if ( !$read ){
				$cron = [
					'cm' => [
						'period' => (isset($params['cm']['period'])) ? $params['cm']['period'] : 'day',
						'time' => (isset($params['cm']['time'])) ? $params['cm']['time'] : '00:00',
						'week' => (isset($params['cm']['week'])) ? $params['cm']['week'] : 0,
					],
					'git' => [
						'period' => (isset($params['git']['period'])) ? $params['git']['period'] : 60,
					]
				];
			$yaml = Yaml::dump( $cron, 4 );

			if ( file_put_contents( '/opt/tgui_data/confManager/cron.yaml', $yaml) )
				return CMDRun::init()->
					setCmd(MAINSCRIPT)->
					setAttr(
						[
						'run',
						'cmd',
						'/opt/tacacsgui/plugins/ConfigManager/cm.py',
						'--cron-set',
						'/opt/tgui_data/confManager/cron.yaml'
						])->
					get();
				else return 'error';
		}
		return CMDRun::init()->
			setCmd(MAINSCRIPT)->
			setAttr(
				[
				'run',
				'cmd',
				'/opt/tacacsgui/plugins/ConfigManager/cm.py',
				'--cron-set',
				'/opt/tgui_data/confManager/cron.yaml'
				])->
			get();
	}
}//END OF CLASS//
