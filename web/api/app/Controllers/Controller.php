<?php

namespace tgui\Controllers;

use tgui\Models\TACGlobalConf;

class Controller
{
	protected $container;

	public function __construct($container)
	{
		$this->container = $container;
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
				'id' => (isset($_SESSION['uid'])) ? $_SESSION['uid'] : 'empty',
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

		return $data;
	}
	////INITIAL DATA FUNCTION////END//
	///////////////////////////////////
	////CHANGE CONFIGURATION STATUS////START//
	protected function changeConfigurationFlag($array)
	{
		$variable = ($array['unset']) ? 0 : 1;
		return TACGlobalConf::where([['id','=',1]])->update(['changeFlag' => $variable]);
	}
	////CHANGE CONFIGURATION STATUS////END//
	////////////////////////////////////////
	////CHECK ACCESS FOR USER////START//
	protected function checkAccess($value)
	{
		$rightsArray = array_reverse ( str_split( decbin($_SESSION['groupRights']) ) );
		//Clear DEMO//
		if ($value == 0 AND $rightsArray[0] == 1) return true;
		//DEMO//
		if ($rightsArray[0] == 0 AND count($rightsArray) == 1) return false;
		//Administrator//
		if ($rightsArray[1] == 1) return true;
		//Add/Edit/Delete Tac Devices//
		if ($value == 2 AND $rightsArray[2] == 1) return true;
		//Add/Edit/Delete Tac Device Groups//
		if ($value == 3 AND $rightsArray[3] == 1) return true;
		//Add/Edit/Delete Tac Users//
		if ($value == 4 AND $rightsArray[4] == 1) return true;
		//Add/Edit/Delete Tac User Groups//
		if ($value == 5 AND $rightsArray[5] == 1) return true;
		//Apply/Test Tac Configuration//
		if ($value == 6 AND $rightsArray[6] == 1) return true;
		//Add/Edit/Delete API Users//
		if ($value == 7 AND $rightsArray[7] == 1) return true;
		//Add/Edit/Delete API User Groups//
		if ($value == 8 AND $rightsArray[8] == 1) return true;
		//Delete/Restore Backups//
		if ($value == 9 AND $rightsArray[9] == 1) return true;
		//Default false//
		return false;
	}
	////CHECK ACCESS FOR USER////END//
	////////////////////////////////////////
	protected function generateRandomString($length = 64) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
