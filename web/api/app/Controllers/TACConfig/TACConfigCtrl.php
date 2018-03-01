<?php

namespace tgui\Controllers\TACConfig;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Models\TACDevices;
use tgui\Models\TACDeviceGrps;
use tgui\Models\TACGlobalConf;
use tgui\Models\TACACL;
use tgui\Controllers\Controller;

use Respect\Validation\Validator as v;

class TACConfigCtrl extends Controller
{
	private $crypto_flag = array(0 => 'clear', 1 => 'crypt', 2 => 'crypt', 7 => '7');
	private $html_tags = array(
		'comment' => [
			0 => '<tac_comment>',
			1 => '</tac_comment>'
		],
		'attr' => [
			0 => '<tac_attr>',
			1 => '</tac_attr>'
		],
		'param' => [
			0 => '<tac_param>',
			1 => '</tac_param>'
		],
		'val' => [
			0 => '<tac_val>',
			1 => '</tac_val>'
		],
		'object' => [
			0 => '<tac_object>',
			1 => '</tac_object>'
		],
	);
	
	private function tacSpawndPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$globalVariables=TACGlobalConf::select('port')->first();
		$outputSpawnd = array();
		$outputSpawnd[0][0]=array('title_flag' => 1, 'name' => (
		($html) ? $this->html_tags['comment'][0] . "####SPAWND####" . $this->html_tags['comment'][1] 
		: 
		"####SPAWND####" ));
			///EMPTY ARRAY///
			$outputSpawnd[1] = array();
			///GENERAL CONF TITLE///
			$outputSpawnd[1][0] = array('title_flag' => 0, 'name' =>"");
			///LISTENING PORT///
			array_push($outputSpawnd[1], (
				($html) ? $this->html_tags['attr'][0] . 'listen' . $this->html_tags['attr'][1] .
				' = { '.$this->html_tags['param'][0].'port'.$this->html_tags['param'][1].
				' = '.$this->html_tags['val'][0].$globalVariables['port'].$this->html_tags['val'][1].' }' 
				: 
				'listen = { port = '.$globalVariables['port'].' }'));

		
		return $outputSpawnd;
	}
	
	private function tacGeneralPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$globalVariables=TACGlobalConf::select()->first();
		$outputGeneralConf = array();
		$outputGeneralConf[0][0]=array('title_flag' => 1, 'name' => (
			($html) ? $this->html_tags['comment'][0] . "####GENERAL CONFIGURATION####" . $this->html_tags['comment'][1] 
			:
			"####GENERAL CONFIGURATION####"));
			///EMPTY ARRAY///
			$outputGeneralConf[1] = array();
			///GENERAL CONF TITLE///
			$outputGeneralConf[1][0] = array('title_flag' => 0, 'name' =>"");
			///////////MANUAL CONFIGURATION/////////////
			if ($globalVariables['manual']!="") 
			{
				array_push($outputGeneralConf[1], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $globalVariables['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputGeneralConf[1], $item);
				}
				array_push($outputGeneralConf[1], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION END###');
			}
			///ACCOUNTING LOG///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'accounting log' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['accounting'] . $this->html_tags['val'][1]
			:
			'accounting log = '.$globalVariables['accounting']);
			///AUTHENTICATION LOG///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'authentication log' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['authentication'] . $this->html_tags['val'][1]
			:
			'authentication log = '.$globalVariables['authentication']);
			///AUTHORIZATION LOG///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'authorization log' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['authorization'] . $this->html_tags['val'][1]
			:
			'authorization log = '.$globalVariables['authorization']);
			///CONNECTION TIMEOUT TO NAS///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'connection timeout' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['connection_timeout'] . $this->html_tags['val'][1]
			:
			'connection timeout = '.$globalVariables['connection_timeout']);
			///Context TIMEOUT///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'context timeout' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['context_timeout'] . $this->html_tags['val'][1]
			:
			'context timeout = '.$globalVariables['context_timeout']);
			///Max attempt///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'password max-attempts' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['max_attempts'] . $this->html_tags['val'][1]
			:
			'password max-attempts = '.$globalVariables['max_attempts']);
			///Backoff settings///
			array_push($outputGeneralConf[1], 
			($html) ? $this->html_tags['attr'][0] . 'password backoff' . $this->html_tags['attr'][1] . ' = ' .$this->html_tags['val'][0] . $globalVariables['backoff'] . $this->html_tags['val'][1]
			:
			'password backoff = '.$globalVariables['backoff']);
		
		return $outputGeneralConf;
	}
	
	private function tacDevicesPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$allDevices = TACDevices::select()->get()->toArray();
		$outputDevices[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF HOSTS####" . $this->html_tags['comment'][1] 
		:
		"####LIST OF HOSTS####");
		$allGroupsArrTemp=TACDeviceGrps::select('id','name')->get()->toArray();
		$allGroupsArr=array();
		foreach($allGroupsArrTemp as $gropItem)
		{
			$allGroupsArr[$gropItem['id']]=$gropItem['name'];
		}
		foreach($allDevices as $host)
		{
			if ($host['disabled']) continue;
			///EMPTY ARRAY///
			$outputDevices[$host['id']] = array();
			///DEVICE TITLE///
			$outputDevices[$host['id']][0] = array('title_flag' => 0, 'name' =>"");
			///DEVICE NAME///
			array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['attr'][0] . "host" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] .$host['name']. $this->html_tags['object'][1] . ' {'
			:
			'host = '.$host['name'].' {');
			///DEVICE IP ADDRESS///
			array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['param'][0] . "address" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$host['ipaddr'].'/'.$host['prefix']. $this->html_tags['val'][1]
			:
			'address = "'.$host['ipaddr'].'/'.$host['prefix'].'"');
			///DEVICE KEY///
			if ($host['key']!='')array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['param'][0] . "key" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$host['key']. $this->html_tags['val'][1]
			:
			'key = '.$host['key']);
			///DEVICE ENABLE///
			if ($host['enable']!='')array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['param'][0] . "enable" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$this->crypto_flag[$host['enable_flag']].' '.$host['enable']. $this->html_tags['val'][1]
			:
			'enable = '.$this->crypto_flag[$host['enable_flag']].' '.$host['enable']);
			///DEVICE BANNER WELCOME///
			if ($host['banner_welcome']!='')array_push($outputDevices[$host['id']],  
			($html) ? $this->html_tags['param'][0] . "welcome banner" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$host['banner_welcome'].'"'. $this->html_tags['val'][1]
			:
			'welcome banner = "'.$host['banner_welcome'].'"');
			///DEVICE BANNER MOTD///
			if ($host['banner_motd']!='')array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['param'][0] . "motd banner" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$host['banner_motd'].'"'. $this->html_tags['val'][1]
			:
			'motd banner = "'.$host['banner_motd'].'"');
			///DEVICE BANNER FAILED AUTH///
			if ($host['banner_failed']!='')array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['param'][0] . "failed authentication banner" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$host['banner_failed'].'"'. $this->html_tags['val'][1]
			:
			'failed authentication banner = "'.$host['banner_failed'].'"');
			///DEVICE GROUP///
			array_push($outputDevices[$host['id']], 
			($html) ? $this->html_tags['param'][0] . "template" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$allGroupsArr[$host['group']]. $this->html_tags['val'][1]
			:
			'template = '.$allGroupsArr[$host['group']].'');
			///DEVICE MANUAL CONFIGURATION/// 
			if ($host['manual']!="") 
			{
				array_push($outputDevices[$host['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $host['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputDevices[$host['id']], $item);
				}
				array_push($outputDevices[$host['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION END###');
			}
			
			array_push($outputDevices[$host['id']], 
			($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF '.$host['name'] . $this->html_tags['comment'][1] 
			:
			'} #END OF '.$host['name']);
			
		}
		
		return $outputDevices;
	}
	
	private function tacDeviceGroupsPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$allDeviceGroups = TACDeviceGrps::select()->get()->toArray();
		$outputDeviceGroups[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF DEVICE GROUPS####" . $this->html_tags['comment'][1] 
		:
		"####LIST OF DEVICE GROUPS####");
		foreach($allDeviceGroups as $group)
		{
			///EMPTY ARRAY///
			$outputDeviceGroups[$group['id']] = array();
			///GROUP TITLE///
			$outputDeviceGroups[$group['id']][0] = array('title_flag' => 0, 'name' =>"");
			///GROUP NAME///
			array_push($outputDeviceGroups[$group['id']], 
			($html) ? $this->html_tags['attr'][0] . "host" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] .$group['name']. $this->html_tags['object'][1] . ' {'
			:
			'host = '.$group['name'].' {');
			///GROUP KEY///
			if ($group['key']!='')array_push($outputDeviceGroups[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "key" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$group['key']. $this->html_tags['val'][1]
			:
			'key = '.$group['key']);
			///GROUP ENABLE///
			if ($group['enable']!='')array_push($outputDeviceGroups[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "enable" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $this->crypto_flag[$group['enable_flag']] . ' ' . $group['enable']. $this->html_tags['val'][1]
			:
			'enable = '.$this->crypto_flag[$group['enable_flag']].' '.$group['enable']);
			///GROUP BANNER WELCOME///
			if ($group['banner_welcome']!='')array_push($outputDeviceGroups[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "welcome banner" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$group['banner_welcome'].'"'. $this->html_tags['val'][1]
			:
			'welcome banner = "'.$group['banner_welcome'].'"');
			///GROUP BANNER MOTD///
			if ($group['banner_motd']!='')array_push($outputDeviceGroups[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "motd banner" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$group['banner_motd'].'"'. $this->html_tags['val'][1]
			:
			'motd banner = "'.$group['banner_motd'].'"');
			///GROUP BANNER FAILED AUTH///
			if ($group['banner_failed']!='')array_push($outputDeviceGroups[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "failed authentication banner" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$group['banner_failed'].'"'. $this->html_tags['val'][1]
			:
			'failed authentication banner = "'.$group['banner_failed'].'"');
			///GROUP MANUAL CONFIGURATION/// 
			if ($group['manual']!="") 
			{
				array_push($outputDeviceGroups[$group['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $group['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputDeviceGroups[$group['id']], $item);
				}
				array_push($outputDeviceGroups[$group['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION END###');
			}
			array_push($outputDeviceGroups[$group['id']], 
			($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF '.$group['name'] . $this->html_tags['comment'][1] 
			:
			'} #END OF '.$group['name']);
			
		}
		
		return $outputDeviceGroups;
	}
	
	private function tacACLPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$allACL = TACACL::select()->where([['line_number','=',0]])->get()->toArray();
		
		$outputACL[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF ACL####" . $this->html_tags['comment'][1] 
		:
		"####LIST OF ACL####");
		foreach($allACL as $acl)
		{
			///EMPTY ARRAY///
			$outputACL[$acl['id']] = array();
			///ACL TITLE///
			$outputACL[$acl['id']][0] = array('title_flag' => 0, 'name' =>"");
			array_push($outputACL[$acl['id']], ($html) ? $this->html_tags['comment'][0] . '###ACL '.$acl['name'].' START###' . $this->html_tags['comment'][1] 
			:
			'###ACL '.$acl['name'].' START###');
			$allAces = TACACL::select()->where([['line_number','<>',0],['name','=',$acl['name']]])->get()->toArray();
			foreach($allAces as $ace)
			{
				///ACL NAME///
				array_push($outputACL[$acl['id']], 
				($html) ? $this->html_tags['attr'][0] . "acl" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] .$acl['name']. $this->html_tags['object'][1] . ' '.$ace['action'].' {'
				:
				'acl = '.$acl['name'].' '.$ace['action'].' {');
				
				///ACL NAC///
				array_push($outputACL[$acl['id']], 
				($html) ? $this->html_tags['param'][0] . "	nac" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$ace['nac']. $this->html_tags['val'][1]
				:
				'nac = '.$ace['nac']);
				
				///ACL NAS///
				array_push($outputACL[$acl['id']], 
				($html) ? $this->html_tags['param'][0] . "	nas" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$ace['nas']. $this->html_tags['val'][1]
				:
				'nas = '.$ace['nas']);
				///ACL NAS///
				array_push($outputACL[$acl['id']], '}');
			}
			array_push($outputACL[$acl['id']], ($html) ? $this->html_tags['comment'][0] . '###ACL '.$acl['name'].' START###' . $this->html_tags['comment'][1] 
			:
			'###ACL '.$acl['name'].' END###');
		}
		
		return $outputACL;
	}
	
	private function tacUserGroupsPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$allUserGroups = TACUserGrps::select()->get()->toArray();
		
		$outputUserGroup[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF USER GROUPS####" . $this->html_tags['comment'][1] 
		:
		"####LIST OF USER GROUPS####");
		foreach($allUserGroups as $group)
		{
			///EMPTY ARRAY///
			$outputUserGroup[$group['id']] = array();
			///USER GROUP TITLE///
			$outputUserGroup[$group['id']][0] = array('title_flag' => 0, 'name' =>"");
			///USER GROUP NAME///
			array_push($outputUserGroup[$group['id']], 
			($html) ? $this->html_tags['attr'][0] . "group" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] .$group['name']. $this->html_tags['object'][1] . ' {'
			:
			'group = '.$group['name'].' {');
			///USER GROUP ENABLE///
			if ($group['enable'] != '')array_push($outputUserGroup[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "enable" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $this->crypto_flag[$group['enable_flag']] .' '. $group['enable']. $this->html_tags['val'][1]
			:
			'enable = '.$this->crypto_flag[$group['enable_flag']].' '.$group['enable']);
			///USER GROUP MESSAGE///
			if ($group['message']!='')array_push($outputUserGroup[$group['id']], 
			($html) ? $this->html_tags['param'][0] . "message" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$group['message'].'"'. $this->html_tags['val'][1]
			:
			'message = "'.$group['message'].'"');
			///USER MANUAL CONFIGURATION/// 
			if ($group['manual']!="") 
			{
				array_push($outputUserGroup[$group['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $group['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputUserGroup[$group['id']], $item);
				}
				array_push($outputUserGroup[$group['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION END###');
			}
			
			array_push($outputUserGroup[$group['id']], 
			($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF '.$group['name'] . $this->html_tags['comment'][1] 
			:
			'} #END OF '.$group['name']);
			
		}
		
		return $outputUserGroup;
	}
	
	private function tacUsersPartGen($html)
	{
		$html = (empty($html)) ? false : true;
		
		$allUsers = TACUsers::select()->get()->toArray();
		
		$outputUsers[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF USERS####" . $this->html_tags['comment'][1] 
		:
		"####LIST OF USERS####");
		foreach($allUsers as $user)
		{
			///EMPTY ARRAY///
			$outputUsers[$user['id']] = array();
			///USER TITLE///
			$outputUsers[$user['id']][0] = array('title_flag' => 0, 'name' =>"");
			///USER NAME///
			array_push($outputUsers[$user['id']], 
			($html) ? $this->html_tags['attr'][0] . "user" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] .$user['username']. $this->html_tags['object'][1] . ' {'
			:
			'user = '.$user['username'].' {');
			///USER KEY///
			array_push($outputUsers[$user['id']], 
			($html) ? $this->html_tags['param'][0] . "login" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $this->crypto_flag[$user['login_flag']].' '.$user['login']. $this->html_tags['val'][1]
			:
			'login = '.$this->crypto_flag[$user['login_flag']].' '.$user['login']);
			///USER ENABLE///
			if ($user['enable']!='')array_push($outputUsers[$user['id']], 
			($html) ? $this->html_tags['param'][0] . "enable" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $this->crypto_flag[$user['enable_flag']].' '.$user['enable']. $this->html_tags['val'][1]
			:
			'enable = '.$this->crypto_flag[$user['enable_flag']].' '.$user['enable']);
			///USER MESSAGE///
			if ($user['message']!='')array_push($outputUsers[$user['id']], 
			($html) ? $this->html_tags['param'][0] . "message" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$user['message'].'"'. $this->html_tags['val'][1]
			:
			'message = "'.$user['message'].'"');
			///USER DEFAULT SERVICE///
			$default_service = ($user['default_service']) ? 'permit' : 'deny';
			array_push($outputUsers[$user['id']], 
			($html) ? $this->html_tags['param'][0] . "default service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$default_service. $this->html_tags['val'][1] 
			:
			'default service = '. $default_service);
			///USER MANUAL CONFIGURATION/// 
			if ($user['manual']!="") 
			{
				array_push($outputUsers[$user['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $user['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputUsers[$user['id']], $item);
				}
				array_push($outputUsers[$user['id']], ($html) ? $this->html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . $this->html_tags['comment'][1] 
				:
				'###MANUAL CONFIGURATION END###');
			}
			
			array_push($outputUsers[$user['id']], 
			($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF '.$user['username'] . $this->html_tags['comment'][1] 
			:
			'} #END OF '.$user['username']);
			
		}
		
		return $outputUsers;
	}
	
	public function getConfigGen($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'config',
			'action' => 'generate',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		
		$html = (empty($req->getParam('html'))) ? false : true;
		
		$data['devicesConfig']=array_values($this->tacDevicesPartGen($html));
		$data['deviceGroupsConfig']=array_values($this->tacDeviceGroupsPartGen($html));
		$data['userGroupsConfig']=array_values($this->tacUserGroupsPartGen($html));
		$data['usersConfig']=array_values($this->tacUsersPartGen($html));
		$data['spawndConfig']=array_values($this->tacSpawndPartGen($html));
		$data['tacGeneralConfig']=array_values($this->tacGeneralPartGen($html));
		$data['tacACL']=array_values($this->tacACLPartGen($html));
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////OUTPUT PARSER///////////////////START//
	private function arrayParserToText($array,$separator)
	{
		$output='';
		foreach($array as $someId => $someParams)
		{
			if ($someId == 0)
			{
				$output.=$someParams[0]['name']." ".$separator;
			}
			else
			{
				for($someLine = 0; $someLine < count($someParams); $someLine++)
				{
					
					if ($someLine == 0) {
						$output.=$someParams[$someLine]['name']." ".$separator; continue;
					}
					else{
						$output.=$someParams[$someLine]." ".$separator;
					}
				}
			}
		}
		return $output;
	
	}
	//////////////OUTPUT PARSER///////////////////END//
	////////////////////////////////////////////////
	////////////TEST CONFIGURATION////START//
	private function testConfiguration($confText)
	{
		$errorFlag=false;
		$confTestFile = fopen(TAC_PLUS_CFG_TEST, 'w') or $errorFlag=true;
		if ($errorFlag) return array('error' => true, 'message' => 'Unable to open '.TAC_PLUS_CFG_TEST.' file! Verify file availability and rights to it', 'errorLine' => 0);
		
		fwrite($confTestFile, $confText);
		
		if (!fclose($confTestFile)) return array('error' => true, 'message' => 'Unable to close '.TAC_PLUS_CFG_TEST.' file! Verify file availability and rights to it', 'errorLine' => 0);
		
		shell_exec('tac_plus -P '.TAC_PLUS_CFG_TEST.' 2> '.TAC_PLUS_PARSING);
				
		$openLogFile=fopen(TAC_PLUS_PARSING, 'r') or $errorFlag=true;
		if ($errorFlag) return array('error' => true, 'message' => 'Unable to open '.TAC_PLUS_PARSING.' file! Verify file availability and rights to it', 'errorLine' => 0);
		
		$parseData=fread($openLogFile, filesize(TAC_PLUS_PARSING));
				
		if (!$parseData)
		{
			return array('error' => false, 'message' => 'Success', 'errorLine' => 0);
		}
		else
		{
			preg_match('/.+:(\d+):.+/',$parseData, $matches);
			return array('error' => true, 'message' => $parseData, 'errorLine' => $matches[1]);
		}
		
		
		return array('error' => true, 'message' => 'Something goes wrong', 'errorLine' => 0);
	}
	////////////TEST CONFIGURATION////END//
	////////////APPLY CONFIGURATION////START//
	private function applyConfiguration($confText)
	{
		$errorFlag=false;
		$confFile = fopen(TAC_PLUS_CFG, 'w') or $errorFlag=true;
		if ($errorFlag) return array('error' => true, 'message' => 'Unable to open '.TAC_PLUS_CFG.' file! Verify file availability and rights to it', 'errorLine' => 0);
		
		fwrite($confFile, $confText);
		
		if (!fclose($confFile)) return array('error' => true, 'message' => 'Unable to close '.TAC_PLUS_CFG.' file! Verify file availability and rights to it', 'errorLine' => 0);
		
		$someOutput = shell_exec('sudo '.TAC_DEAMON.' status');
		
		if ($someOutput == null)
		{
			return array('error' => true, 'message' => 'Error while get tac status. Did you set sudo rights?', 'errorLine' => 0);
		}
		
		if(preg_match('/.+(not running|not exist).+/',$someOutput))
		{
			if (preg_match('/.+(not running).+/',$someOutput))
			{
				$tryToStart=shell_exec('sudo '.TAC_DEAMON.' start');
				if (preg_match('/.+(done).+/',$tryToStart))
				{
					return array('error' => false, 'message' => 'Deamon was disabled. Success. '.$tryToStart, 'errorLine' => 0);
				}
				return array('error' => true, 'message' => 'Some inside error. '.$tryToStart, 'errorLine' => 0);
			}

			return array('error' => true, 'message' => 'Some inside error. '.$someOutput, 'errorLine' => 0);
		}
		
		if(preg_match('/.+(is running).+/',$someOutput))
		{
			$tryToReload=shell_exec('sudo '.TAC_DEAMON.' reload');
			return array('error' => false, 'message' => 'Deamon was Reloaded. Success. '.$tryToReload, 'errorLine' => 0);
		}
		
		
		return array('error' => true, 'message' => 'Something goes wrong', 'errorLine' => 0);
	}
	////////////APPLY CONFIGURATION////END//
	////////////////////////////////////////////////
	//////////////CREATE CONFIGURATION////START//
	public function getConfigGenFile($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'config',
			'action' => 'generate to file',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$tempDeviceArray=$this->tacDevicesPartGen();
		$tempDeviceGroupArray=$this->tacDeviceGroupsPartGen();
		$tempUserGroupArray=$this->tacUserGroupsPartGen();
		$tempUserArray=$this->tacUsersPartGen();
		$tempSpawndConfArray=$this->tacSpawndPartGen();
		$tempGlobalConfArray=$this->tacGeneralPartGen();
		$tempACL=$this->tacACLPartGen();
		
		$lineSeparator = ($req->getParam('contentType') == 'html' ) ? '</p>' : "\n ";
		$contentTypeOutput = ($req->getParam('contentType') == 'html' ) ? 'text/html' : 'application/json';
		$output="";
		
		////////////////////////////////////
		//SPAWND CONFIGURATION//START//
		$output.="id = spawnd {".$lineSeparator;
		$output.=$this->arrayParserToText($tempSpawndConfArray,$lineSeparator);
		$output.="} ##END OF SPAWND".$lineSeparator;
		//SPAWND CONFIGURATION//END//
		////////////////////////////////////
		//GLOBAL CONFIGURATION//START//
		$output.="id = tac_plus { ##START GLOBAL CONFIGURATION".$lineSeparator;
		$output.=$this->arrayParserToText($tempGlobalConfArray,$lineSeparator);
		//GLOBAL CONFIGURATION//END//
		////////////////////////////////////
		//DEVICE GROUP LIST CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempDeviceGroupArray,$lineSeparator);
		//DEVICE GROUP LIST CONFIGURATION//END//
		////////////////////////////////////
		//DEVICE LIST CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempDeviceArray,$lineSeparator);
		//DEVICE LIST CONFIGURATION//END//
		//////////////////////////////////
		//ACL LIST CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempACL,$lineSeparator);
		//ACL LIST CONFIGURATION//END//
		//////////////////////////////////
		//USER GROUP LIST CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempUserGroupArray,$lineSeparator);
		//USER GROUP LIST CONFIGURATION//END//
		//////////////////////////////////
		//USER LIST CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempUserArray,$lineSeparator);
		//USER LIST CONFIGURATION//END//
		//////////////////////////////////
		$output.="}##END GLOBAL CONFIGURATION".$lineSeparator;
		//////////////////////////////////
		
		if ($req->getParam('confSave')=='yes'){
			
			$data['confTest']=$this->testConfiguration($output);
			
			if($data['confTest']['error'])
			{
				$data['error']['status'] = $data['confTest']['error'];
				///LOGGING//start//
				$logEntry=array('action' => 'tacacs test conf', 'objectName' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 502);
				$this->APILoggingCtrl->makeLogEntry($logEntry);
				///LOGGING//end//
				return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
			}
			///LOGGING//start//
			$logEntry = array('action' => 'tacacs test conf', 'objectName' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 501);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			$data['applyStatus']=$this->applyConfiguration($output);
			
			///LOGGING//start//
			$logEntry2 = (!$data['applyStatus']['error']) ? array('action' => 'tacacs apply conf', 'objectName' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 503) : array('action' => 'tacacs apply conf', 'objectName' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 504 );
			$data['test']=$this->APILoggingCtrl->makeLogEntry($logEntry2);
			///LOGGING//end//
			
			$data['changeConfiguration']= (!$data['applyStatus']['error']) ? $this->changeConfigurationFlag(['unset' => 1]) : 0;
	
			$doBackup=$req->getParam('doBackup');
			
			if (!$data['applyStatus']['error'] AND $doBackup == 'true' AND $this->checkAccess(9)) { $data['backup']=$this->APIBackupCtrl->makeBackup(array('make' => 'tcfg')); }
			
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}
		
		if($req->getParam('confTest') == 'on')
		{
			$data['confTest']=$this->testConfiguration($output);
			$data['error']['status'] = $data['confTest']['error'];
			///LOGGING//start//
			$logEntry= ($data['confTest']['error']) ? array('action' => 'tacacs test conf', 'objectName' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 502) : array('action' => 'tacacs test conf', 'objectName' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 501);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}
		
		
		if ($req->getParam('contentType') != 'html') 
		{
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}
		else
		{
			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write($output);
		}
	}
	//////////////CREATE CONFIGURATION////END//
	public function postConfigGen($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'config',
			'action' => 'generate',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////////
	////////GET EDIT GLOBAL PARAMETERS//////////////
	public function getEditConfigGlobal($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'config',
			'action' => 'global edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		$data['global_variables']=TACGlobalConf::select()->first();
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	/////////////////////////////////////////////////
	////////POST EDIT GLOBAL PARAMETERS//////////////
	public function postEditConfigGlobal($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'config',
			'action' => 'global edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//
		
		$validation = $this->validator->validate($req, [
			'port' => v::noWhitespace()->notEmpty()->positive()->min(1,true)->intVal(),
			'max_attempts' => v::noWhitespace()->notEmpty()->positive()->min(1,true)->intVal(),
			'backoff' => v::noWhitespace()->notEmpty()->positive()->min(1,true)->intVal(),
			'connection_timeout' => v::noWhitespace()->notEmpty()->positive()->min(1,true)->intVal(),
			'context_timeout' => v::noWhitespace()->notEmpty()->positive()->min(1,true)->intVal(),
			'authentication' => v::notEmpty(),
			'authorization' => v::notEmpty(),
			'accounting' => v::notEmpty(),
		]);
		
		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		
		$data['tglobal_update']=TACGlobalConf::where([['id','=',1]])->
			update([
				'port' => $req->getParam('port'),
				'max_attempts' => $req->getParam('max_attempts'),
				'backoff' => $req->getParam('backoff'),
				'connection_timeout' => $req->getParam('connection_timeout'),
				'context_timeout' => $req->getParam('context_timeout'),
				'authentication' => $req->getParam('authentication'),
				'authorization' => $req->getParam('authorization'),
				'accounting' => $req->getParam('accounting'),
				'manual' => $req->getParam('manual'),
			]);
			
		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);
			
		$logEntry=array('action' => 'edit', 'objectName' => 'tacacs global settings', 'objectId' => '', 'section' => 'tacacs global settings', 'message' => 505);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////
	////////POST DEAMON CONFIG//////////////
	public function postDeamonConfig($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'deamon',
			'action' => 'config',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		
		$data['tacacsStatusMessage'] = trim(shell_exec('sudo '.TAC_DEAMON.' status'));
		
		$data['action'] = $action = (!empty($req->getParam('action'))) ? $req->getParam('action') : '';
		
		switch ($action) {
			case ('start'):
				$data['action'] = 'start';
				$data['tacacsStatusMessage'] = trim(shell_exec('sudo '.TAC_DEAMON.' start'));
				$data['tacacsStatusMessage'] .= '; ';
				sleep(2);
				$data['tacacsStatusMessage'] .= trim(shell_exec('sudo '.TAC_DEAMON.' status'));
				break;
			case ('stop'):
				$data['action'] = 'stop';
				$data['tacacsStatusMessage'] = trim(shell_exec('sudo '.TAC_DEAMON.' stop'));
				$data['tacacsStatusMessage'] .= '; ';
				sleep(2);
				$data['tacacsStatusMessage'] .= trim(shell_exec('sudo '.TAC_DEAMON.' status'));
				break;
			case ('reload'):
				$data['action'] = 'reload';
				$data['tacacsStatusMessage'] = trim(shell_exec('sudo '.TAC_DEAMON.' reload'));
				$data['tacacsStatusMessage'] .= '; ';
				sleep(2);
				$data['tacacsStatusMessage'] .= trim(shell_exec('sudo '.TAC_DEAMON.' status'));
				break;
		}
		
		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////
}##END OF CLASS