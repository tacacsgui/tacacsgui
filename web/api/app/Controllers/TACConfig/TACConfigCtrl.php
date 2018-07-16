<?php

namespace tgui\Controllers\TACConfig;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Models\TACDevices;
use tgui\Models\TACDeviceGrps;
use tgui\Models\TACGlobalConf;
use tgui\Models\TACServices;
use tgui\Models\TACACL;
use tgui\Models\MAVISOTP;
use tgui\Models\MAVISSMS;
use tgui\Models\MAVISLDAP;
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

	private function tacDevicesPartGen($html = false, $id = 0)
	{

		$allDevices = ( $id == 0 ) ? TACDevices::select()->get()->toArray() : TACDevices::select()->where('id', $id)->get()->toArray();
		if ( $id == 0 ) $outputDevices[0][0]=array('title_flag' => 1, 'name' =>
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
			if ($host['disabled'] AND $id == 0) continue;
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
			($html) ? $this->html_tags['param'][0] . "key" . $this->html_tags['param'][1] . ' = "' . $this->html_tags['val'][0] .$host['key']. $this->html_tags['val'][1].'"'
			:
			'key = "'.$host['key'].'"');
			///DEVICE ENABLE///
			if ($host['enable']!='')array_push($outputDevices[$host['id']],
			($html) ? $this->html_tags['param'][0] . "enable" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$this->crypto_flag[$host['enable_flag']] . ' '. $host['enable'] . $this->html_tags['val'][1]
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

	private function tacDeviceGroupsPartGen($html = false, $id = 0)
	{

		$allDeviceGroups = ( $id == 0 ) ? TACDeviceGrps::select()->get()->toArray() : TACDeviceGrps::select()->where('id', $id)->get()->toArray();
		if ( $id == 0 ) $outputDeviceGroups[0][0]=array('title_flag' => 1, 'name' =>
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
			($html) ? $this->html_tags['param'][0] . "key" . $this->html_tags['param'][1] . ' = "' . $this->html_tags['val'][0] .$group['key']. $this->html_tags['val'][1] .'"'
			:
			'key = "'.$group['key'] .'"');
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

	private function tacACLPartGen($html = false, $id = 0)
	{
		$allACL = ( $id == 0 ) ? TACACL::select()->where([['line_number','=',0]])->get()->toArray() : TACACL::select()->where([['line_number','=',0],['id','=',$id]])->get()->toArray();

		if ( $id == 0 ) $outputACL[0][0]=array('title_flag' => 1, 'name' =>
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
			array_push($outputACL[$acl['id']], ($html) ? $this->html_tags['comment'][0] . '###ACL '.$acl['name'].' END###' . $this->html_tags['comment'][1]
			:
			'###ACL '.$acl['name'].' END###');
		}

		return $outputACL;
	}

	private function tacUserGroupsPartGen($html = false, $id = 0)
	{

		$allUserGroups = ( $id == 0 ) ? TACUserGrps::select()->get()->toArray() : TACUserGrps::select()->where('id', $id)->get()->toArray();
		$allACL_array = TACACL::select('id','name')->where([['line_number','=',0]])->get()->toArray();

		$allACL = array();
		foreach($allACL_array as $acl)
		{
			$allACL[$acl['id']]=$acl['name'];
		}

		if ( $id == 0 ) $outputUserGroup[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF USER GROUPS####" . $this->html_tags['comment'][1]
		:
		"####LIST OF USER GROUPS####");
		foreach($allUserGroups as $group)
		{
			if ($group['priv-lvl'] < 0) $group['priv-lvl'] = 15;
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
			///USER GROUP ACL///
			if ($group['acl'] > 0) {
				array_push($outputUserGroup[$group['id']],
				($html) ? '	' .$this->html_tags['param'][0] . "acl" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $allACL[$group['acl']] . $this->html_tags['val'][1]
				:
				'	acl = '. $allACL[$group['acl']]);
			}
			///USER GROUP DEFAULT SERVICE///
			$default_service = ($group['default_service']) ? 'permit' : 'deny';
			array_push($outputUserGroup[$group['id']],
			($html) ? '	' . $this->html_tags['param'][0] . "default service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$default_service. $this->html_tags['val'][1]
			:
			'	default service = '. $default_service);
			///USER GROUP SERVICE SHELL///
			if ($group['service'] != 0) {
				$service = TACServices::select()->where([['id','=',$group['service']]])->first() ;
				array_push($outputUserGroup[$group['id']],
				($html) ? '	' . $this->html_tags['comment'][0] . "### PREDEFINED SERVICE - " .$service->name. $this->html_tags['comment'][1]
				:
				'	### PREDEFINED SERVICE - '.$service->name );

				if ($service->manual_conf_only == 0){
					array_push($outputUserGroup[$group['id']],
					($html) ? '	' . $this->html_tags['param'][0] . "service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['attr'][0] .'shell {'. $this->html_tags['attr'][1]
					:
					'	service = shell {');
					$default_cmd = ($service['default_cmd'] == 1) ? 'permit' : 'deny';
					array_push($outputUserGroup[$group['id']],
					($html) ? '		' . $this->html_tags['param'][0] . "default cmd" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $default_cmd . $this->html_tags['val'][1]
					:
					'		default cmd = ' . $default_cmd);

					$service_privilege = ($group['priv-lvl'] < 0) ? 0 : $group['priv-lvl'];
					if (!$service_privilege) $service_privilege = ($service['priv-lvl'] < 0) ? 15 : $service['priv-lvl'];
					//$service_privilege = 123;
					array_push($outputUserGroup[$group['id']],
					($html) ? '		' . $this->html_tags['param'][0] . "set priv-lvl" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$service_privilege. $this->html_tags['val'][1]
					:
					'		set priv-lvl = '.$service_privilege);
				}

				$arrayService=explode(PHP_EOL, $service->manual);
				foreach($arrayService as $item)
				{
					array_push($outputUserGroup[$group['id']], '		'.$item);
				}

				if ($service->manual_conf_only == 0){
					array_push($outputUserGroup[$group['id']],
					($html) ? '	' . $this->html_tags['attr'][0] .'}'. $this->html_tags['attr'][1]
					:
					'	}');
				}

			} else {
				array_push($outputUserGroup[$group['id']],
				($html) ? '	' . $this->html_tags['param'][0] . "service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['attr'][0] .'shell {'. $this->html_tags['attr'][1]
				:
				'	service = shell {');
				array_push($outputUserGroup[$group['id']],
				($html) ? '		' . $this->html_tags['param'][0] . "default cmd" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'permit'. $this->html_tags['val'][1]
				:
				'		default cmd = permit');
				array_push($outputUserGroup[$group['id']],
				($html) ? '		' . $this->html_tags['param'][0] . "set priv-lvl" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$group['priv-lvl']. $this->html_tags['val'][1]
				:
				'		set priv-lvl = '.$group['priv-lvl']);
				array_push($outputUserGroup[$group['id']],
				($html) ? '	' . $this->html_tags['attr'][0] .'}'. $this->html_tags['attr'][1]
				:
				'	}');
			}
			///USER GROUP MANUAL CONFIGURATION///
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

	private function tacUsersPartGen($html = false, $id = 0)
	{

		$allUsers = ($id == 0) ? TACUsers::select()->get()->toArray() : TACUsers::select()->where('id', $id)->get()->toArray();

		$allACL_array = TACACL::select('id','name')->where([['line_number','=',0]])->get()->toArray();
		$allUserGroups_array = TACUserGrps::select('id','name')->get()->toArray();
		$allACL = array();
		$allUserGroups = array();
		foreach($allACL_array as $acl)
		{
			$allACL[$acl['id']]=$acl['name'];
		}

		foreach($allUserGroups_array as $ugrp)
		{
			$allUserGroups[$ugrp['id']]=$ugrp['name'];
		}

		if ($id == 0) $outputUsers[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####LIST OF USERS####" . $this->html_tags['comment'][1]
		:
		"####LIST OF USERS####");
		foreach($allUsers as $user)
		{
			if ($user['disabled'] == 1 AND $id == 0) continue;
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
			$login = $this->crypto_flag[$user['login_flag']].' '.$user['login'];
			if ($user['mavis_otp_enabled'] == 1 OR $user['mavis_sms_enabled'] == 1) $login = 'mavis';
			array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "login" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $login . $this->html_tags['val'][1]
			:
			'	login = '. $login);
			///USER PAP///
			if ($user['pap_clone'] == 1) array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "pap" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $login . $this->html_tags['val'][1]
			:
			'	pap = '. $login);
			if ($user['pap_clone'] !== 1 AND !empty($user['pap'])) array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "pap" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $this->crypto_flag[$user['pap_flag']].' '.$user['pap'] . $this->html_tags['val'][1]
			:
			'	pap = '. $this->crypto_flag[$user['pap_flag']].' '.$user['pap']);
			///USER CHAP///
			if (!empty($user['chap'])) array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "chap" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . 'clear '.$user['chap'] . $this->html_tags['val'][1]
			:
			'	chap = '. 'clear '.$user['chap']);
			///USER MS-CHAP///
			if (!empty($user['ms-chap'])) array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "ms-chap" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . 'clear '.$user['ms-chap'] . $this->html_tags['val'][1]
			:
			'	ms-chap = '. 'clear '.$user['ms-chap']);
			///USER ENABLE///
			if ($user['enable']!='')array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "enable" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $this->crypto_flag[$user['enable_flag']].' '.$user['enable']. $this->html_tags['val'][1]
			:
			'	enable = '.$this->crypto_flag[$user['enable_flag']].' '.$user['enable']);
			///USER ACL///
			if ($user['acl'] > 0)array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "acl" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $allACL[$user['acl']] . $this->html_tags['val'][1]
			:
			'	acl = '. $allACL[$user['acl']]);
			///USER MESSAGE///
			if ($user['message']!='')array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "message" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'.$user['message'].'"'. $this->html_tags['val'][1]
			:
			'	message = "'.$user['message'].'"');
			///USER MEMBER///
			if ($user['group'] > 0)array_push($outputUsers[$user['id']],
			($html) ? '	'.$this->html_tags['param'][0] . "member" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $allUserGroups[$user['group']] . $this->html_tags['val'][1]
			:
			'	member = '.$allUserGroups[$user['group']]);
			///USER SERVICE SHELL///
			if ($user['service'] == 0 AND  $user['group'] == 0) {
				///USER DEFAULT SERVICE///
				$default_service = ($user['default_service']) ? 'permit' : 'deny';
				array_push($outputUsers[$user['id']],
				($html) ? '	' . $this->html_tags['param'][0] . "default service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$default_service. $this->html_tags['val'][1]
				:
				'	default service = '. $default_service);
				///////////////////////////////////////////
				if ($user['priv-lvl'] < 0) $user['priv-lvl'] = 15;
				array_push($outputUsers[$user['id']],
				($html) ? '	' . $this->html_tags['param'][0] . "service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['attr'][0] .'shell {'. $this->html_tags['attr'][1]
				:
				'	service = shell {');
				array_push($outputUsers[$user['id']],
				($html) ? '		' . $this->html_tags['param'][0] . "default cmd" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'permit'. $this->html_tags['val'][1]
				:
				'		default cmd = permit');
				array_push($outputUsers[$user['id']],
				($html) ? '		' . $this->html_tags['param'][0] . "set priv-lvl" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$user['priv-lvl']. $this->html_tags['val'][1]
				:
				'		set priv-lvl = '.$user['priv-lvl']);
				array_push($outputUsers[$user['id']],
				($html) ? '	' . $this->html_tags['attr'][0] .'}'. $this->html_tags['attr'][1]
				:
				'	}');
			}
			if ($user['service'] != 0) {
				///USER DEFAULT SERVICE///
				$default_service = ($user['default_service']) ? 'permit' : 'deny';
				array_push($outputUsers[$user['id']],
				($html) ? '	' . $this->html_tags['param'][0] . "default service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$default_service. $this->html_tags['val'][1]
				:
				'	default service = '. $default_service);
				///////////////////////////////////////////
				$service = TACServices::select()->where([['id','=',$user['service']]])->first() ;
				array_push($outputUsers[$user['id']],
				($html) ? '	' . $this->html_tags['comment'][0] . "### PREDEFINED SERVICE - " .$service->name. $this->html_tags['comment'][1]
				:
				'	### PREDEFINED SERVICE - '.$service->name );

				if ($service->manual_conf_only == 0){
					array_push($outputUsers[$user['id']],
					($html) ? '	' . $this->html_tags['param'][0] . "service" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['attr'][0] .'shell {'. $this->html_tags['attr'][1]
					:
					'	service = shell {');
					$default_cmd = ($service['default_cmd'] == 1) ? 'permit' : 'deny';
					array_push($outputUsers[$user['id']],
					($html) ? '		' . $this->html_tags['param'][0] . "default cmd" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $default_cmd . $this->html_tags['val'][1]
					:
					'		default cmd = '. $default_cmd);

					$service_privilege = ($user['priv-lvl'] < 0) ? 0 : $user['priv-lvl'];
					if (!$service_privilege) $service_privilege = ($service['priv-lvl'] < 0) ? 15 : $service['priv-lvl'];
					//$service_privilege = 123;
					array_push($outputUsers[$user['id']],
					($html) ? '		' . $this->html_tags['param'][0] . "set priv-lvl" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .$service_privilege. $this->html_tags['val'][1]
					:
					'		set priv-lvl = '.$service_privilege);
				}

				$arrayService=explode(PHP_EOL, $service->manual);
				foreach($arrayService as $item)
				{
					array_push($outputUsers[$user['id']], '		'.$item);
				}

				if ($service->manual_conf_only == 0){
					array_push($outputUsers[$user['id']],
					($html) ? '	' . $this->html_tags['attr'][0] .'}'. $this->html_tags['attr'][1]
					:
					'	}');
				}

			}
			elseif($user['group'] != 0){
				array_push($outputUsers[$user['id']],
				($html) ? '	' . $this->html_tags['comment'][0] . "### GET SERVICES FROM GROUP" . $this->html_tags['comment'][1]
				:
				'	### GET SERVICES FROM GROUP');
			}
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

	private function tacMavisLdapGen($html)
	{
		$html = (empty($html)) ? false : true;

		$mavis_ldap_settings = MAVISLDAP::select()->first();

		if ($mavis_ldap_settings->enabled == 0) return array('title_flag' => 0, 'name' =>"");

		$id = $mavis_ldap_settings->id;

		$outputMavisLdap[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####MAVIS LDAP MODULE####" . $this->html_tags['comment'][1]
		:
		"####MAVIS LDAP MODULE####");
		///EMPTY ARRAY///
		$outputMavisLdap[$id] = array();
		///MAVIS LDAP TITLE///
		$outputMavisLdap[$id][0] = array('title_flag' => 0, 'name' =>"");
		///MAVIS LDAP SETTINGS START///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['attr'][0] . "mavis module" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] . 'external' . $this->html_tags['object'][1] . ' {'
		:
		'mavis module = external {');
		///LDAP SERVER TYPE///

		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_SERVER_TYPE" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'. $mavis_ldap_settings['type'] .'"'. $this->html_tags['val'][1]
		:
		'	setenv LDAP_SERVER_TYPE = "'. $mavis_ldap_settings['type'].'"');
		///LDAP HOSTS///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_HOSTS" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'. $mavis_ldap_settings['hosts'] .'"'. $this->html_tags['val'][1]
		:
		'	setenv LDAP_HOSTS = "'. $mavis_ldap_settings['hosts'].'"');
		///LDAP SCOPE///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_SCOPE" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['scope'] . $this->html_tags['val'][1]
		:
		'	setenv LDAP_SCOPE = '. $mavis_ldap_settings['scope']);
		///LDAP BASE///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_BASE" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'. $mavis_ldap_settings['base'] .'"'. $this->html_tags['val'][1]
		:
		'	setenv LDAP_BASE = "'. $mavis_ldap_settings['base'].'"');
		///LDAP FILTER///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_FILTER" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'. $mavis_ldap_settings['filter'] .'"'. $this->html_tags['val'][1]
		:
		'	setenv LDAP_FILTER = "'. $mavis_ldap_settings['filter'].'"');
		///LDAP USER///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_USER" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'. $mavis_ldap_settings['user'] .'"'. $this->html_tags['val'][1]
		:
		'	setenv LDAP_USER = "'. $mavis_ldap_settings['user'].'"');
		///LDAP PASSWD///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv LDAP_PASSWD" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] .'"'. ( (!$mavis_ldap_settings['password_hide'] ) ? $mavis_ldap_settings['password'] : '********')  .'"'. $this->html_tags['val'][1]
		:
		'	setenv LDAP_PASSWD = "'. $mavis_ldap_settings['password'].'"');
		///LDAP AD GROUP PREFIX///
		$commentChar = ($mavis_ldap_settings['group_prefix'] == '') ? '#' : '';
		array_push($outputMavisLdap[$id],
		($html) ?  $commentChar . $this->html_tags['param'][0] . "	setenv AD_GROUP_PREFIX" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['group_prefix'] . $this->html_tags['val'][1] . '# default prefix is <i>tacacs</i>'
		:
		$commentChar .'	setenv AD_GROUP_PREFIX = '. $mavis_ldap_settings['group_prefix']);
		///LDAP PRIFIX REQUIRED///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv REQUIRE_AD_GROUP_PREFIX" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['group_prefix_flag'] . $this->html_tags['val'][1]
		:
		'	setenv REQUIRE_AD_GROUP_PREFIX = '. $mavis_ldap_settings['group_prefix_flag']);
		///LDAP TLS///
		array_push($outputMavisLdap[$id],
		($html) ? ( ($mavis_ldap_settings['tls']) ? '': '#') . $this->html_tags['param'][0] . "	setenv USE_TLS" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['tls'] . $this->html_tags['val'][1]
		:
		( ($mavis_ldap_settings['tls']) ? '': '#') . '	setenv USE_TLS = '. $mavis_ldap_settings['tls']);
		///LDAP CACHE CONN///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv FLAG_CACHE_CONNECTION" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['cache_conn'] . $this->html_tags['val'][1]
		:
		'	setenv FLAG_CACHE_CONNECTION  = '. $mavis_ldap_settings['cache_conn']);
		///LDAP MEMBEROF///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv FLAG_USE_MEMBEROF" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['memberOf'] . $this->html_tags['val'][1]
		:
		'	setenv FLAG_USE_MEMBEROF  = '. $mavis_ldap_settings['memberOf']);
		///LDAP FALLTHROUGH///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	setenv FLAG_FALLTHROUGH" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['fallthrough'] . $this->html_tags['val'][1]
		:
		'	setenv FLAG_FALLTHROUGH  = '. $mavis_ldap_settings['fallthrough']);
		///LDAP PATH///
		array_push($outputMavisLdap[$id],
		($html) ? $this->html_tags['param'][0] . "	exec" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . $mavis_ldap_settings['path'] . $this->html_tags['val'][1]
		:
		'	exec  = '. $mavis_ldap_settings['path']);
		///USER MANUAL CONFIGURATION///
		/*if ($group['manual']!="")
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
		}*/

		array_push($outputMavisLdap[$id],
		($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF MAVIS LDAP SETTINGS' . $this->html_tags['comment'][1]
		:
		'} #END OF MAVIS LDAP SETTINGS');

		return $outputMavisLdap;
	}

	private function tacMavisGeneralGen($html)
	{
		$html = (empty($html)) ? false : true;

		$mavis_ldap_settings = MAVISLDAP::select()->first();
		$mavis_otp_settings = MAVISOTP::select()->first();
		$mavis_sms_settings = MAVISSMS::select()->first();

		if ($mavis_ldap_settings->enabled == 0 AND $mavis_otp_settings->enabled == 0 AND $mavis_sms_settings->enabled == 0) return array('title_flag' => 0, 'name' =>"");

		$outputMavisGeneral[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####MAVIS GENERAL SETTINGS####" . $this->html_tags['comment'][1]
		:
		"####MAVIS GENERAL SETTINGS####");
		///EMPTY ARRAY///
		$outputMavisGeneral[1] = array();
		///MAVIS GENERAL TITLE///
		$outputMavisGeneral[1][0] = array('title_flag' => 0, 'name' =>"");
		///MAVIS GENERAL SETTINGS START///
		array_push($outputMavisGeneral[1],
		($html) ? $this->html_tags['attr'][0] . "user backend" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] . 'mavis' . $this->html_tags['object'][1]
		:
		'user backend = mavis');
		array_push($outputMavisGeneral[1],
		($html) ? $this->html_tags['attr'][0] . "login backend" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] . 'mavis chalresp' . $this->html_tags['object'][1]
		:
		'login backend = mavis chalresp');
		array_push($outputMavisGeneral[1],
		($html) ? $this->html_tags['attr'][0] . "pap backend" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] . 'mavis' . $this->html_tags['object'][1]
		:
		'pap backend = mavis');

	return $outputMavisGeneral;
	}

	private function tacMavisOTPGen($html)
	{
		$html = (empty($html)) ? false : true;

		$mavis_otp_settings = MAVISOTP::select('enabled')->first();

		if ($mavis_otp_settings->enabled == 0) return array('title_flag' => 0, 'name' =>"");

		$outputMavisOTP[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####MAVIS OTP SETTINGS####" . $this->html_tags['comment'][1]
		:
		"####MAVIS OTP SETTINGS####");
		///EMPTY ARRAY///
		$outputMavisOTP[1] = array();
		///MAVIS OTP TITLE///
		$outputMavisOTP[1][0] = array('title_flag' => 0, 'name' =>"");
		///MAVIS OTP SETTINGS START///
		array_push($outputMavisOTP[1],
		($html) ? $this->html_tags['attr'][0] . "mavis module" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] . 'external' . $this->html_tags['object'][1] . ' {'
		:
		'mavis module = external {');

		///OTP PATH///
		array_push($outputMavisOTP[1],
		($html) ? $this->html_tags['param'][0] . "	exec" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . TAC_ROOT_PATH . '/mavis-modules/otp/module.php' . $this->html_tags['val'][1]
		:
		'	exec  = ' . TAC_ROOT_PATH . '/mavis-modules/otp/module.php');

		array_push($outputMavisOTP[1],
		($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF MAVIS OTP SETTINGS' . $this->html_tags['comment'][1]
		:
		'} #END OF MAVIS OTP SETTINGS');



	return $outputMavisOTP;
	}

	////MAVIS SMS////
	private function tacMavisSMSGen($html)
	{
		$html = (empty($html)) ? false : true;

		$mavis_sms_settings = MAVISSMS::select('enabled')->first();

		if ($mavis_sms_settings->enabled == 0) return array('title_flag' => 0, 'name' =>"");

		$outputMavisSMS[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $this->html_tags['comment'][0] . "####MAVIS SMS SETTINGS####" . $this->html_tags['comment'][1]
		:
		"####MAVIS SMS SETTINGS####");
		///EMPTY ARRAY///
		$outputMavisSMS[1] = array();
		///MAVIS SMS TITLE///
		$outputMavisSMS[1][0] = array('title_flag' => 0, 'name' =>"");
		///MAVIS SMS SETTINGS START///
		array_push($outputMavisSMS[1],
		($html) ? $this->html_tags['attr'][0] . "mavis module" . $this->html_tags['attr'][1] . ' = ' . $this->html_tags['object'][0] . 'external' . $this->html_tags['object'][1] . ' {'
		:
		'mavis module = external {');

		///SMS PATH///
		array_push($outputMavisSMS[1],
		($html) ? $this->html_tags['param'][0] . "	exec" . $this->html_tags['param'][1] . ' = ' . $this->html_tags['val'][0] . TAC_ROOT_PATH . '/mavis-modules/sms/module.php' . $this->html_tags['val'][1]
		:
		'	exec  = ' . TAC_ROOT_PATH . '/mavis-modules/sms/module.php');

		array_push($outputMavisSMS[1],
		($html) ? '} ' . $this->html_tags['comment'][0] . '#END OF MAVIS SMS SETTINGS' . $this->html_tags['comment'][1]
		:
		'} #END OF MAVIS SMS SETTINGS');



	return $outputMavisSMS;
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

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$html = (empty($req->getParam('html'))) ? false : true;

		$data['mavisGeneralConfig']=array_values($this->tacMavisGeneralGen($html));
		$data['mavisOTPConfig']=array_values($this->tacMavisOTPGen($html));
		$data['mavisSMSConfig']=array_values($this->tacMavisSMSGen($html));
		$data['mavisLdapConfig']=array_values($this->tacMavisLdapGen($html));
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
	public function testConfiguration($confText)
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
	public function createConfiguration($lineSeparator)
	{
		$tempMavisGeneralArray=$this->tacMavisGeneralGen(false);
		$tempMavisOTPArray=$this->tacMavisOTPGen(false);
		$tempMavisSMSArray=$this->tacMavisSMSGen(false);
		$tempMavisLdapArray=$this->tacMavisLdapGen(false);
		$tempDeviceArray=$this->tacDevicesPartGen(false);
		$tempDeviceGroupArray=$this->tacDeviceGroupsPartGen(false);
		$tempUserGroupArray=$this->tacUserGroupsPartGen(false);
		$tempUserArray=$this->tacUsersPartGen(false);
		$tempSpawndConfArray=$this->tacSpawndPartGen(false);
		$tempGlobalConfArray=$this->tacGeneralPartGen(false);
		$tempACL=$this->tacACLPartGen(false);

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
		//MAVIS GENERAL CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempMavisGeneralArray,$lineSeparator);
		//MAVIS GENERAL CONFIGURATION//END//
		////////////////////////////////////
		//MAVIS OTP CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempMavisOTPArray,$lineSeparator);
		//MAVIS OTP CONFIGURATION//END//
		////////////////////////////////////
		//MAVIS SMS CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempMavisSMSArray,$lineSeparator);
		//MAVIS SMS CONFIGURATION//END//
		////////////////////////////////////
		//MAVIS LDAP CONFIGURATION//START//
		$output.=$this->arrayParserToText($tempMavisLdapArray,$lineSeparator);
		//MAVIS LDAP CONFIGURATION//END//
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

		return $output;
	}

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

		$lineSeparator = ($req->getParam('contentType') == 'html' ) ? '</p>' : "\n ";
		$contentTypeOutput = ($req->getParam('contentType') == 'html' ) ? 'text/html' : 'application/json';
		$output="";

		$output = $this->createConfiguration($lineSeparator);

		if ($req->getParam('confSave')=='yes'){

			$data['confTest']=$this->testConfiguration($output);

			if($data['confTest']['error'])
			{
				$data['error']['status'] = $data['confTest']['error'];
				///LOGGING//start//
				$logEntry=array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 502);
				$this->APILoggingCtrl->makeLogEntry($logEntry);
				///LOGGING//end//
				return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
			}
			///LOGGING//start//
			$logEntry = array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 501);
			$this->APILoggingCtrl->makeLogEntry($logEntry);
			///LOGGING//end//
			$doBackup=$req->getParam('doBackup');
			if ( $doBackup == 'true') {
				$data['backup'] = $doBackup = $this->APIBackupCtrl->makeBackup(['make' => 'tcfg']);
				if ( !$doBackup['status'] ) {
					$data['applyStatus'] = ['error' => true, 'message' => $doBackup['message'], 'errorLine' => 0];
					return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
				}
			}
			///LOGGING//
			$data['applyStatus']=$this->applyConfiguration($output);

			///LOGGING//start//
			$logEntry2 = (!$data['applyStatus']['error']) ? array('action' => 'tacacs apply conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 503) : array('action' => 'tacacs apply conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 504 );
			$data['test']=$this->APILoggingCtrl->makeLogEntry($logEntry2);
			///LOGGING//end//

			$data['changeConfiguration']= (!$data['applyStatus']['error']) ? $this->changeConfigurationFlag(['unset' => 1]) : 0;

			return $res -> withStatus(200) -> withHeader('Content-type', $contentTypeOutput) -> write(json_encode($data));
		}

		if($req->getParam('confTest') == 'on')
		{
			$data['confTest']=$this->testConfiguration($output);
			$data['error']['status'] = $data['confTest']['error'];
			///LOGGING//start//
			$logEntry= ($data['confTest']['error']) ? array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 502) : array('action' => 'tacacs test conf', 'obj_name' => 'tacacs configuration', 'section' => 'tacacs configuration', 'message' => 501);
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
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'port' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'max_attempts' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'backoff' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'connection_timeout' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'context_timeout' => v::noWhitespace()->when( v::nullType() , v::alwaysValid(), v::positive()->min(1,true)->intVal()),
			'authentication' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'authorization' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
			'accounting' => v::when( v::nullType() , v::alwaysValid(), v::notEmpty()),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$data['tglobal_update']=TACGlobalConf::where([['id','=',1]])->
			update($allParams);

		$data['changeConfiguration']=$this->changeConfigurationFlag(['unset' => 0]);

		$logEntry=array('action' => 'edit', 'obj_name' => 'tacacs global settings', 'obj_id' => '', 'section' => 'tacacs global settings', 'message' => 505);
		$data['logging']=$this->APILoggingCtrl->makeLogEntry($logEntry);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////
	////////POST EDIT GLOBAL PARAMETERS//////////////
	public function postConfPart($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'config',
			'action' => 'config part',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		// if(!$this->checkAccess(6))
		// {
		// 	return $res -> withStatus(403) -> write(json_encode($data));
		// }
		//CHECK ACCESS TO THAT FUNCTION//END//
		$allParams = $req->getParams();

		if ( empty($allParams['target']) ){
			$data['error']['status']=true;
			$data['error']['message']='Bad Request';
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		switch ($allParams['target']) {
			case 'device':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(2, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = $this->tacDevicesPartGen(true, $allParams['id']);
				break;
			case 'deviceGrp':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(3, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = $this->tacDeviceGroupsPartGen(true, $allParams['id']);
				break;
			case 'user':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(4, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = $this->tacUsersPartGen(true, $allParams['id']);
				break;
			case 'userGrp':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(5, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = $this->tacUserGroupsPartGen(true, $allParams['id']);
				break;
			case 'acl':
				//CHECK ACCESS TO THAT FUNCTION//START//
				if(!$this->checkAccess(11, true))
				{
					return $res -> withStatus(403) -> write(json_encode($data));
				}
				//CHECK ACCESS TO THAT FUNCTION//END//
				if ( !isset($allParams['id']) OR $allParams['id'] == 0){
					$data['error']['status']=true;
					$data['error']['message']='Bad Request';
					return $res -> withStatus(200) -> write(json_encode($data));
				}
				$data['output'] = $this->tacACLPartGen(true, $allParams['id']);
				break;
			default:
				$data['error']['status']=true;
				$data['error']['message']='Bad Request';
				return $res -> withStatus(200) -> write(json_encode($data));
		}

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
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(6))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$data['action'] = $action = ( !empty($req->getParam('action')) ) ? $req->getParam('action') : '';

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
