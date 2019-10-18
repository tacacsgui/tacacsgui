<?php

namespace tgui\Controllers;

use tgui\Models\TACGlobalConf;
use tgui\Controllers\APIChecker\APIDatabase;
use tgui\Controllers\APIHA\HAGeneral;
use tgui\Models\APIPWPolicy;

class Controller
{
	protected $container;
	public $databases;
	public $tablesArr;
	public $tablesArr_log;

	public function __construct($container)
	{
		$this->container = $container;
		$apiDatabase = new APIDatabase;
		$this->databases = $apiDatabase->databases;
		$this->tablesArr = $apiDatabase->tablesArr;
		$this->tablesArr_log = $apiDatabase->tablesArr_log;
	}

	public function __get($property)
	{
		if($this->container->{$property})
		{
			return $this->container->{$property};
		}
	}
	//////////////////////////////////////
	////INITIAL DATA FUNCTION////START//
	protected function initialData($array)
	{
		$data['info'] = array(
			'general' => [
				'type' => $array['type'],
				'object' => $array['object'],
				'action' => $array['action'],
				'time' => time()
			],
			'version' => [
				'TACVER' => TACVER,
				'APIVER' => APIVER,
			],
			'user' => [
				'id' => ( isset($_SESSION['uid']) ) ? $_SESSION['uid'] : 'empty',
				'username' => (isset($_SESSION['uname'])) ? $_SESSION['uname'] : 'empty',
				'groupId' => (isset($_SESSION['groupId'])) ? $_SESSION['groupId'] : 'empty',
				'groupRights' => (isset($_SESSION['groupRights'])) ? $_SESSION['groupRights'] : 'empty',
				'changePasswd' => (isset($_SESSION['changePasswd'])) ? $_SESSION['changePasswd'] : 'empty',
			],
		);
		$data['error'] = array(
				'status' => false,
		);
		#check user auth#
		$data['authorised']=$this->auth->check();

		if ($data['info']['user']['changePasswd'] == 1){
			$_SESSION['error']['status']=true;
		}
		$data['ha_role'] = ( $data['authorised'] ) ? HAGeneral::getRole() : 'empty';
		//$data['ha_slave'] = $data['ha_role'] == 'slave';
		return $data;
	}
	public function getHaRole(){
		return HAGeneral::getRole();
	}
	////INITIAL DATA FUNCTION////END//
	///////////////////////////////////
	////CHANGE CONFIGURATION STATUS////START//
	protected function changeConfigurationFlag($array = ['unset'=>1])
	{
		$variable = ($array['unset']) ? 0 : 1;
		$changeFlag = TACGlobalConf::find(1);
		$changeFlag->timestamps = false;
		$changeFlag->changeFlag = $variable;
		$changeFlag->save();
		return $variable;
		//return TACGlobalConf::where([['id','=',1]])->update(['changeFlag' => $variable]);
	}
	////CHANGE CONFIGURATION STATUS////END//
	////////////////////////////////////////
	////CHECK SLAVE HA////END//
	public function shouldIStopThis()
	{
		if ( HAGeneral::isSlave() ) return [ 'message' => 'Server in Slave mode! Changes Forbidden!'];
		return false;
	}
	////CHECK SLAVE HA////END//
	////////////////////////////////////////
	////CHECK ACCESS FOR USER////START//
	public static function checkAccess($value = 0, $demo = false)
	{
		$rightsArray = array_reverse ( str_split( decbin($_SESSION['groupRights']) ) );
		//Clear DEMO//
		if (count($rightsArray) !== 1 AND $rightsArray[0] !== 1) $demo = false;
		//DEMO//
		//$value = ( HAGeneral::getRole() == 'slave' ) ? 0 : $value;
		if ($value == 0 AND count($rightsArray) == 1 AND $rightsArray[0] == 1) return true;
		//Administrator//
		if ($rightsArray[1] == 1) return true;
		//Add/Edit/Delete Tac Devices//
		if ($value == 2 AND $rightsArray[2] == 1 OR $demo) return true;
		//Add/Edit/Delete Tac Device Groups//
		if ($value == 3 AND $rightsArray[3] == 1 OR $demo) return true;
		//Add/Edit/Delete Tac Users//
		if ($value == 4 AND $rightsArray[4] == 1 OR $demo) return true;
		//Add/Edit/Delete Tac User Groups//
		if ($value == 5 AND $rightsArray[5] == 1 OR $demo) return true;
		//Apply/Test Tac Configuration//
		if ($value == 6 AND $rightsArray[6] == 1 OR $demo) return true;
		//Add/Edit/Delete API Users//
		if ($value == 7 AND $rightsArray[7] == 1 OR $demo) return true;
		//Add/Edit/Delete API User Groups//
		if ($value == 8 AND $rightsArray[8] == 1 OR $demo) return true;
		//Delete/Restore Backups//
		if ($value == 9 AND $rightsArray[9] == 1 OR $demo) return true;
		//Upgrade API//
		if ($value == 10 AND $rightsArray[10] == 1 OR $demo) return true;
		//MAVIS//
		if ($value == 11 AND $rightsArray[11] == 1 OR $demo) return true;
		//Add/Edit/Delete Tac ACL//
		if ($value == 12 AND $rightsArray[12] == 1 OR $demo) return true;
		//Add/Edit/Delete Tac Services//
		if ($value == 13 AND $rightsArray[13] == 1 OR $demo) return true;
		//Add/Edit/Delete Address Objects//
		if ($value == 14 AND $rightsArray[14] == 1 OR $demo) return true;
		//Default false//
		return false;
	}
	////CHECK ACCESS FOR USER////END//
	////////////////////////////////////////
	public static function generateRandomString($length = 64) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public static function generatePassword($lp = true, $length = 9, $available_sets = 'luds') {
		if ($lp) {
			$policy = APIPWPolicy::select()->first(1);
			$length = $policy['tac_pw_length'];
			$available_sets = '';
			$available_sets .= ($policy['tac_pw_uppercase']) ? 'u': '';
			$available_sets .= ($policy['tac_pw_lowercase']) ? 'l': '';
			$available_sets .= ($policy['tac_pw_special']) ? 's': '';
			$available_sets .= ($policy['tac_pw_numbers']) ? 'n': '';
			if ( empty($available_sets) ) $available_sets = 'lu';
		}
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];
		$password = str_shuffle($password);

		return $password;

	}
	////////////////////////////////////////
	////////////////////////////////////////
  public static function serverTime()
  {
  	return trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") );
  }
	////////////////////////////////////////
	////////////////////////////////////////
	public static function uuid_hash() {
		return trim(shell_exec('sudo '. TAC_ROOT_PATH.'/main.sh uuid_hash'));
	}
	////////////////////////////////////////
	////////////////////////////////////////
	public function databaseHash() {
		$list = $this->db::select( 'CHECKSUM TABLE '. implode( ",", array_keys($this->tablesArr) ) );
    return [ sha1( implode(',', array_map(function($x){ return $x->Checksum;}, $list) ) ), $list];
	}
	////////////////////////////////////////
	////////////////////////////////////////
	public static function activated() {
		if (! file_exists(TAC_ROOT_PATH.'/../tgui_data/tgui.key') ) return false;
		return file_get_contents(TAC_ROOT_PATH.'/../tgui_data/tgui.key') == self::uuid_hash();
	}
	////////////////////////////////////////
	protected function encryption( $password = '', $type = 0 , $encrypt = 0)
	{
		if ($type == 1 AND $encrypt == 1 )
		{
			return trim(shell_exec('openssl passwd -1 \''.$password."'"));
		} elseif ($type == 2 AND $encrypt == 1 )
		{
			return $password;
			//return trim(shell_exec('openssl passwd -crypt \''.$password."'"));
		} elseif ($type == 3)
		{
			return password_hash($password, PASSWORD_DEFAULT);
		}
		return $password;
	}
	////////////////////////////////////////
	public function queriesMaker( $columns = [], $searchString = '' )
	{
		$filter = [];
		$filter['error'] = false;
		$filter['message'] = '';
		$queries = [];
		$searchRequests = explode( ',' , $searchString );
		foreach ($searchRequests as $searchRequest) {
			if ($filter['error']) return ['filter' => $filter, 'queries' => $queries];
			if ( !trim( $searchRequest ) ) continue;
			$searchRequest = $searchRequest; //delete spaces
			switch (true) {
				case (preg_match('/([a-zA-Z]+!==.+)/', $searchRequest)):
						$temp = $this->searchParser('!==',$searchRequest,$queries, $filter, $columns);
						$queries = $temp['queries'];
						$filter = $temp['filter'];
					break;
				case (preg_match('/([a-zA-Z]+==.+)/', $searchRequest)):
						$temp = $this->searchParser('==',$searchRequest,$queries, $filter, $columns);
						$queries = $temp['queries'];
						$filter = $temp['filter'];
					break;
				case (preg_match('/([a-zA-Z]+!=.+)/', $searchRequest)):
						$temp = $this->searchParser('!=',$searchRequest,$queries, $filter, $columns);
						$queries = $temp['queries'];
						$filter = $temp['filter'];
					break;
				case (preg_match('/([a-zA-Z]+=.+)/', $searchRequest)):
						$temp = $this->searchParser('=',$searchRequest,$queries, $filter, $columns);
						$queries = $temp['queries'];
						$filter = $temp['filter'];
					break;
				default:
					$filter['error'] = true;
					$filter['message'] = 'unrecognized condition';
					break;
			}
		}
		return ['filter' => $filter, 'queries' => $queries];
	}
	public function searchParser($condition = '', $searchRequest = '', $queries = [], $filter = [], $columns = [])
	{
		$search = explode($condition,$searchRequest);
		$search[0] = trim($search[0]);
		if ( empty($search[0]) OR is_null($search[1]) OR $search[1] == '') return ['filter' => $filter, 'queries' => $queries];
		if ( empty( $queries[$condition]) ) $queries[$condition] = [];

		if ( !array_search(strtolower($search[0]), $columns) AND !array_search(strtoupper($search[0]), $columns)) {
			$filter['error'] = true; $filter['message'] = $search[0] . ' - attribute not found';
			return ['filter' => $filter, 'queries' => $queries];}
		$search[0] = ( array_search(strtolower($search[0]), $columns) ) ? $columns[array_search(strtolower($search[0]), $columns)] : $columns[array_search(strtoupper($search[0]), $columns)];
		if ( empty($queries[$condition][$search[0]]) ) $queries[$condition][$search[0]] = [];
		$queries[$condition][$search[0]][count($queries[$condition][$search[0]])] = $search[1];

		return ['filter' => $filter, 'queries' => $queries];
	}
	////////////////////////////////////////
	public function debMsg($message = '', $prefix = ''){

		if ($this->container->debug)
			echo date('Y-m-d H:i:s') .' '.$prefix.' '.$message."\n";

		return $this;
	}
}
