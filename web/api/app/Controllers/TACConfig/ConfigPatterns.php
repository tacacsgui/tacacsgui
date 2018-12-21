<?php

namespace tgui\Controllers\TACConfig;

use tgui\Models\TACUsers;
use tgui\Models\TACUserGrps;
use tgui\Models\TACDevices;
use tgui\Models\TACDeviceGrps;
use tgui\Models\TACGlobalConf;
use tgui\Models\TACServices;
use tgui\Models\TACCMD;
use tgui\Models\TACACL;
use tgui\Models\MAVISOTP;
use tgui\Models\MAVISSMS;
use tgui\Models\MAVISLDAP;
use tgui\Models\MAVISLocal;

/**
 *
 */
class ConfigPatterns
{
  public static $ciscoWLCRoles =
  [
    0 => 'ALL',
    2 => 'LOBBY',
    4 => 'MONITOR',
    8 => 'WLAN',
    10 => 'CONTROLLER',
    20 => 'WIRELESS',
    40 => 'SECURITY',
    80 => 'MANAGEMENT',
    100 => 'COMMANDS',
  ];

  public static $crypto_flag = array(0 => 'clear', 1 => 'crypt', 2 => 'crypt', 3 => 'mavis', 4 => 'login');
	public static $html_tags = array(
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

  public static function tacSpawndPartGen($html)
	{
		$html = (empty($html)) ? false : true;
    $sp = new spacer();
		$globalVariables=TACGlobalConf::select('port')->first();
		$outputSpawnd = array();
		$outputSpawnd[0][0]=array('title_flag' => 1, 'name' => (
		($html) ? $sp->put('i') . self::$html_tags['comment'][0] . "####SPAWND####" . self::$html_tags['comment'][1]
		:
		$sp->put('i') . "####SPAWND####" ));
			///EMPTY ARRAY///
			$outputSpawnd[1] = array();
			///GENERAL CONF TITLE///
			$outputSpawnd[1][0] = array('title_flag' => 0, 'name' =>"");
			///LISTENING PORT///
			array_push($outputSpawnd[1], (
				($html) ? $sp->put('a') . self::$html_tags['attr'][0] .'listen' . self::$html_tags['attr'][1] .
				' = { '.self::$html_tags['param'][0].'port'.self::$html_tags['param'][1].
				' = '.self::$html_tags['val'][0].$globalVariables['port'].self::$html_tags['val'][1].' }'
				:
				$sp->put('a') . 'listen = { port = '.$globalVariables['port'].' }'));


		return $outputSpawnd;
	}

  public static function tacGeneralPartGen($html)
	{
		$html = (empty($html)) ? false : true;
    $sp = new spacer();
		$globalVariables=TACGlobalConf::select()->first();
		$outputGeneralConf = array();
		$outputGeneralConf[0][0]=array('title_flag' => 1, 'name' => (
			($html) ? $sp->put('i') . self::$html_tags['comment'][0] . "####GENERAL CONFIGURATION####" . self::$html_tags['comment'][1]
			:
			$sp->put('i') . "####GENERAL CONFIGURATION####"));
			///EMPTY ARRAY///
			$outputGeneralConf[1] = array();
			///GENERAL CONF TITLE///
			$outputGeneralConf[1][0] = array('title_flag' => 0, 'name' =>"");
			///////////MANUAL CONFIGURATION/////////////
			if ($globalVariables['manual']!="")
			{
				array_push($outputGeneralConf[1], ($html) ? $sp->put('a') . self::$html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . self::$html_tags['comment'][1]
				:
				$sp->put('a') . '###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $globalVariables['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputGeneralConf[1], $item);
				}
				array_push($outputGeneralConf[1], ($html) ? $sp->put() . self::$html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . self::$html_tags['comment'][1]
				:
				$sp->put() . '###MANUAL CONFIGURATION END###');
			}
			///ACCOUNTING LOG///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'accounting log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['accounting'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'accounting log = '.$globalVariables['accounting']);
			///AUTHENTICATION LOG///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'authentication log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['authentication'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'authentication log = '.$globalVariables['authentication']);
			///AUTHORIZATION LOG///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'authorization log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['authorization'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'authorization log = '.$globalVariables['authorization']);
			///CONNECTION TIMEOUT TO NAS///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'connection timeout' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['connection_timeout'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'connection timeout = '.$globalVariables['connection_timeout']);
			///Context TIMEOUT///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'context timeout' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['context_timeout'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'context timeout = '.$globalVariables['context_timeout']);
			///Max attempt///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'password max-attempts' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['max_attempts'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'password max-attempts = '.$globalVariables['max_attempts']);
			///Backoff settings///
			array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'password backoff' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['backoff'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'password backoff = '.$globalVariables['backoff']);
			///Separation Tag///
			if ( !empty($globalVariables['separation_tag']) ) array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'separation tag' . self::$html_tags['attr'][1] . ' = "' .self::$html_tags['val'][0] .$globalVariables['separation_tag']. self::$html_tags['val'][1].'"'
			:
			$sp->put() . 'separation tag = "'.$globalVariables['separation_tag'].'"');
			///Skip conflicting groups///
			if ( $globalVariables['skip_conflicting_groups'] ) array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'skip conflicting groups' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] .'yes'. self::$html_tags['val'][1]
			:
			$sp->put() . 'skip conflicting groups = yes');
			///Skip missing groups///
			if ( $globalVariables['skip_missing_groups'] ) array_push($outputGeneralConf[1],
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'skip missing groups' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] .'yes'. self::$html_tags['val'][1]
			:
			$sp->put() . 'skip missing groups = yes');

		return $outputGeneralConf;
	}

	public static function tacDevicesPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
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

		$allDevices = ( $id == 0 ) ? TACDevices::select()->get()->toArray() : TACDevices::select()->where('id', $id)->get()->toArray();
		if ( $id == 0 ) $outputDevices[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF HOSTS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF HOSTS####");
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
			($html) ? $sp->put().self::$html_tags['attr'][0] . "host" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$host['name']. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'host = '.$host['name'].' {');
			///DEVICE IP ADDRESS///
			array_push($outputDevices[$host['id']],
			($html) ? $sp->put('a').self::$html_tags['param'][0] . "address" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] .$host['ipaddr'].'/'.$host['prefix']. self::$html_tags['val'][1].'"'
			:
			$sp->put('a').'address = "'.$host['ipaddr'].'/'.$host['prefix'].'"');
			///DEVICE KEY///
			if ($host['key']!='')array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "key" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] .$host['key']. self::$html_tags['val'][1].'"'
			:
			$sp->put().'key = "'.$host['key'].'"');
			///DEVICE ENABLE///
			if ($host['enable']!='')array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .self::$crypto_flag[$host['enable_flag']] . ' '. $host['enable'] . self::$html_tags['val'][1]
			:
			$sp->put().'enable = '.self::$crypto_flag[$host['enable_flag']].' '.$host['enable']);
      ///DEVICE ACL///
			if ($host['acl'] > 0)array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "access acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $allACL[$host['acl']] . self::$html_tags['val'][1]
			:
			$sp->put().'access acl = '. $allACL[$host['acl']]);
      ///DEFAULT USER GROUP///
			if ($host['user_group'] > 0)array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "default group" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $allUserGroups[$host['user_group']] . self::$html_tags['val'][1]
			:
			$sp->put().'default group = '.$allUserGroups[$host['user_group']]);
      ///CONNECTION TIMEOUT///
			if ($host['connection_timeout'] > 0)array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "connection timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $host['connection_timeout'] . self::$html_tags['val'][1]
			:
			$sp->put().'connection timeout = '.$host['connection_timeout']);
			///DEVICE BANNER WELCOME///
			if ($host['banner_welcome']!='')array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "welcome banner" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$host['banner_welcome'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'welcome banner = "'.$host['banner_welcome'].'"');
			///DEVICE BANNER MOTD///
			if ($host['banner_motd']!='')array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "motd banner" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$host['banner_motd'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'motd banner = "'.$host['banner_motd'].'"');
			///DEVICE BANNER FAILED AUTH///
			if ($host['banner_failed']!='')array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "failed authentication banner" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$host['banner_failed'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'failed authentication banner = "'.$host['banner_failed'].'"');
			///DEVICE GROUP///
			array_push($outputDevices[$host['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "template" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$allGroupsArr[$host['group']]. self::$html_tags['val'][1]
			:
			$sp->put().'template = '.$allGroupsArr[$host['group']]);

      ///DEVICE MANUAL CONFIGURATION///
			$outputDevices[$host['id']] = array_merge( $outputDevices[$host['id']],  self::manualConfigPrint($host['manual'], $html) );

			array_push($outputDevices[$host['id']],
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$host['name'] . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$host['name']);

		}

		return $outputDevices;
	}

	public static function tacDeviceGroupsPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
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

		$allDeviceGroups = ( $id == 0 ) ? TACDeviceGrps::select()->get()->toArray() : TACDeviceGrps::select()->where('id', $id)->get()->toArray();
		if ( $id == 0 ) $outputDeviceGroups[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF DEVICE GROUPS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF DEVICE GROUPS####");
		foreach($allDeviceGroups as $group)
		{
			///EMPTY ARRAY///
			$outputDeviceGroups[$group['id']] = array();
			///GROUP TITLE///
			$outputDeviceGroups[$group['id']][0] = array('title_flag' => 0, 'name' =>"");
			///GROUP NAME///
			array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put().self::$html_tags['attr'][0] . "host" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$group['name']. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'host = '.$group['name'].' {');
			///GROUP KEY///
			if ($group['key']!='')array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put('a').self::$html_tags['param'][0] . "key" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] .$group['key']. self::$html_tags['val'][1] .'"'
			:
			$sp->put('a').'key = "'.$group['key'] .'"');
			///GROUP ENABLE///
			if ($group['enable']!='')array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$group['enable_flag']] . ' ' . $group['enable']. self::$html_tags['val'][1]
			:
			$sp->put().'enable = '.self::$crypto_flag[$group['enable_flag']].' '.$group['enable']);
      ///DEVICE ACL///
      if ($group['acl'] > 0)array_push($outputDeviceGroups[$group['id']],
      ($html) ? $sp->put().self::$html_tags['param'][0] . "access acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $allACL[$group['acl']] . self::$html_tags['val'][1]
      :
      $sp->put().'access acl = '. $allACL[$group['acl']]);
      ///DEFAULT USER GROUP///
      if ($group['user_group'] > 0)array_push($outputDeviceGroups[$group['id']],
      ($html) ? $sp->put().self::$html_tags['param'][0] . "default group" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $allUserGroups[$group['user_group']] . self::$html_tags['val'][1]
      :
      $sp->put().'default group = '.$allUserGroups[$group['user_group']]);
      ///CONNECTION TIMEOUT///
      if ($group['connection_timeout'] > 0)array_push($outputDeviceGroups[$group['id']],
      ($html) ? $sp->put().self::$html_tags['param'][0] . "connection timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group['connection_timeout'] . self::$html_tags['val'][1]
      :
      $sp->put().'connection timeout = '.$group['connection_timeout']);
			///GROUP BANNER WELCOME///
			if ($group['banner_welcome']!='')array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "welcome banner" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$group['banner_welcome'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'welcome banner = "'.$group['banner_welcome'].'"');
			///GROUP BANNER MOTD///
			if ($group['banner_motd']!='')array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "motd banner" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$group['banner_motd'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'motd banner = "'.$group['banner_motd'].'"');
			///GROUP BANNER FAILED AUTH///
			if ($group['banner_failed']!='')array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "failed authentication banner" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$group['banner_failed'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'failed authentication banner = "'.$group['banner_failed'].'"');

      ///GROUP MANUAL CONFIGURATION///
      $outputDeviceGroups[$group['id']] = array_merge( $outputDeviceGroups[$group['id']],  self::manualConfigPrint($group['manual'], $html) );

			array_push($outputDeviceGroups[$group['id']],
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$group['name'] . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$group['name']);

		}

		return $outputDeviceGroups;
	}

	public static function tacACLPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
		$allACL = ( $id == 0 ) ? TACACL::select()->where('line_number',0)->get()->toArray() : TACACL::select()->where([['line_number','=',0],['id','=',$id]])->get()->toArray();

		if ( $id == 0 ) $outputACL[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF ACL####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF ACL####");
		foreach($allACL as $acl)
		{
			///EMPTY ARRAY///
			$outputACL[$acl['id']] = array();
			///ACL TITLE///
			$outputACL[$acl['id']][0] = array('title_flag' => 0, 'name' =>"");
			array_push($outputACL[$acl['id']], ($html) ? $sp->put().self::$html_tags['comment'][0] . '###ACL '.$acl['name'].' START###' . self::$html_tags['comment'][1]
			:
			$sp->put().'###ACL '.$acl['name'].' START###');
			$allAces = TACACL::select()->where([['line_number','<>',0],['name','=',$acl['name']]])->get()->toArray();
			foreach($allAces as $ace)
			{
				///ACL NAME///
				array_push($outputACL[$acl['id']],
				($html) ? $sp->put().self::$html_tags['attr'][0] . "acl" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$acl['name']. self::$html_tags['object'][1] . ' '.$ace['action'].' {'
				:
				$sp->put().'acl = '.$acl['name'].' '.$ace['action'].' {');

				///ACL NAC///
				array_push($outputACL[$acl['id']],
				($html) ? $sp->put('a').self::$html_tags['param'][0] . "nac" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$ace['nac']. self::$html_tags['val'][1]
				:
				$sp->put('a').'nac = '.$ace['nac']);

				///ACL NAS///
				array_push($outputACL[$acl['id']],
				($html) ? $sp->put().self::$html_tags['param'][0] . "nas" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$ace['nas']. self::$html_tags['val'][1]
				:
				$sp->put().'nas = '.$ace['nas']);
				///ACL NAS///
				array_push($outputACL[$acl['id']], $sp->put('d').'}');
			}
			array_push($outputACL[$acl['id']], ($html) ? $sp->put().self::$html_tags['comment'][0] . '###ACL '.$acl['name'].' END###' . self::$html_tags['comment'][1]
			:
			$sp->put().'###ACL '.$acl['name'].' END###');
		}

		return $outputACL;
	}

	public static function tacUserGroupsPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
		$allUserGroups = ( $id == 0 ) ? TACUserGrps::select()->get()->toArray() : TACUserGrps::select()->where('id', $id)->get()->toArray();
		$allACL_array = TACACL::select('id','name')->where([['line_number','=',0]])->get()->toArray();

		$allACL = array();
		foreach($allACL_array as $acl)
		{
			$allACL[$acl['id']]=$acl['name'];
		}

		if ( $id == 0 ) $outputUserGroup[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF USER GROUPS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF USER GROUPS####");
    //$sp->put('a');
		foreach($allUserGroups as $group)
		{
			///EMPTY ARRAY///
			$outputUserGroup[$group['id']] = array();
			///USER GROUP TITLE///
			$outputUserGroup[$group['id']][0] = array('title_flag' => 0, 'name' =>"");
			///USER GROUP NAME///
			array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put().self::$html_tags['attr'][0] . "group" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$group['name']. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'group = '.$group['name'].' {');
      $sp->put('a');
      ///LDAP Groups///
      if ( $group['ldap_groups'] ){
        $ldapGrp = explode(';;', $group['ldap_groups']);
        array_push($outputUserGroup[$group['id']],
    		($html) ? $sp->put().self::$html_tags['comment'][0] . "#### LDAP Groups List #### DistinguishedName ###" . self::$html_tags['comment'][1]
    		:
    		$sp->put()."#### LDAP Groups List #### DistinguishedName ###");
        for ($i=0; $i < count($ldapGrp); $i++) {
          array_push($outputUserGroup[$group['id']],
      		($html) ? $sp->put().self::$html_tags['comment'][0] . "### ".$ldapGrp[$i]." ###" . self::$html_tags['comment'][1]
      		:
      		$sp->put()."### ".$ldapGrp[$i]." ###");
        }
      }
			///USER GROUP ENABLE///
			if ($group['enable'] != '')array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$group['enable_flag']] .' '. $group['enable']. self::$html_tags['val'][1]
			:
			$sp->put().'enable = '.self::$crypto_flag[$group['enable_flag']].' '.$group['enable']);
			///USER GROUP MESSAGE///
			if ($group['message']!='')array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "message" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$group['message'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'message = "'.$group['message'].'"');
      ///USER Valid From///
      if ($group['valid_from']!='')array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid from" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($group['valid_from']). self::$html_tags['val'][1] .' # '.$group['valid_from']
			:
			$sp->put().'valid from = '.strtotime($group['valid_from']).' # '.$group['valid_from']);
      ///USER Valid Until///
      if ($group['valid_until']!='')array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid until" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($group['valid_until']). self::$html_tags['val'][1] .' # '.$group['valid_until']
			:
			$sp->put().'valid until = '.strtotime($group['valid_until']).' # '.$group['valid_until']);
			///USER GROUP ACL///
			if ($group['acl'] > 0) {
				array_push($outputUserGroup[$group['id']],
				($html) ? $sp->put().self::$html_tags['param'][0] . "acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $allACL[$group['acl']] . self::$html_tags['val'][1]
				:
				$sp->put().'acl = '. $allACL[$group['acl']]);
			}
      ///USER CLIENT IP///
      // if ($group['client_ip'] > 0)array_push($outputUserGroup[$group['id']],
      // ($html) ? $sp->put().self::$html_tags['param'][0] . "client" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group['client_ip'] . self::$html_tags['val'][1] . ' # NAC ip must be in that range'
      // :
      // $sp->put().'client = '. $group['client_ip']);
      ///USER SERVER IP///
      if ( !empty($group['device_group_list']) OR !empty($group['device_list']) ){
        $dev_list = TACDevices::select('name', 'ipaddr', 'prefix', 'disabled')->whereIn( 'id', explode(';;', $group['device_list']) )->get();
        $devg_list = TACDevices::select('name', 'ipaddr', 'prefix', 'disabled')->whereIn( 'group', explode(';;', $group['device_group_list']) )->get();
        $tempArray_d = [];
        $action_html = ( $group['device_list_action']) ? self::$html_tags['param'][0] .'permit'.self::$html_tags['param'][1] : self::$html_tags['object'][0].'deny'.self::$html_tags['object'][1];
        $action = ( $group['device_list_action']) ? 'permit' : 'deny';
        for ($i=0; $i < count($dev_list) ; $i++) {
          if ($dev_list[$i]->disabled) continue;
          $tempArray_d[] = $dev_list[$i]->name;
          array_push($outputUserGroup[$group['id']],
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $dev_list[$i]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $dev_list[$i]->ipaddr . '/' . $dev_list[$i]->prefix . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $dev_list[$i]->name);
        }
        for ($dg=0; $dg < count($devg_list) ; $dg++) {
          if ( $devg_list[$dg]->disabled ) continue;
          if (in_array($devg_list[$dg]->name, $tempArray_d)) continue;
          array_push($outputUserGroup[$group['id']],
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $devg_list[$dg]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $devg_list[$dg]->ipaddr . '/' . $devg_list[$dg]->prefix . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $devg_list[$dg]->name);
        }
        if ( $group['device_list_action'] ) array_push($outputUserGroup[$group['id']],
        ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['object'][0].'deny 0.0.0.0/0'. self::$html_tags['object'][1] . self::$html_tags['comment'][0] . ' # permit ONLY' . self::$html_tags['comment'][1]
        :
        $sp->put().'server = deny 0.0.0.0/0 # permit ONLY');

      }
      // if ($group['server_ip'] > 0)array_push($outputUserGroup[$group['id']],
      // ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group['server_ip'] . self::$html_tags['val'][1] . ' # NAS ip must be in that range'
      // :
      // $sp->put().'server = '. $group['server_ip']);
			///USER GROUP DEFAULT SERVICE///
			$default_service = ($group['default_service']) ? 'permit' : 'deny';
			array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "default service" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$default_service. self::$html_tags['val'][1]
			:
			$sp->put().'default service = '. $default_service);
			///USER GROUP SERVICE SHELL///
			if ( $group['service'] != 0 ) {

        $outputUserGroup[$group['id']] = array_merge( $outputUserGroup[$group['id']],  self::tacService($html, $group['service'], true) );

			} else {
        array_push($outputUserGroup[$group['id']],
				($html) ? $sp->put().self::$html_tags['comment'][0] . "### Service no set ###" . self::$html_tags['comment'][1]
				:
				$sp->put().'### Service no set ###');
			}

			///USER GROUP MANUAL CONFIGURATION///
      $outputUserGroup[$group['id']] = array_merge( $outputUserGroup[$group['id']],  self::manualConfigPrint($group['manual'], $html) );

			array_push($outputUserGroup[$group['id']],
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$group['name'] . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$group['name']);

		}

		return $outputUserGroup;
	}

	public static function tacUsersPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
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
		($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF USERS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF USERS####");
		foreach($allUsers as $user)
		{
			if ($user['disabled'] == 1 AND $id == 0) continue;
			///EMPTY ARRAY///
			$outputUsers[$user['id']] = array();
			///USER TITLE///
			$outputUsers[$user['id']][0] = array('title_flag' => 0, 'name' =>"");
			///USER NAME///
			array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['attr'][0] . "user" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$user['username']. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'user = '.$user['username'].' {');
			///USER KEY///
			$login = self::$crypto_flag[$user['login_flag']].' '. ( ($user['login_flag'] != 3 ) ? $user['login'] : '#local' );
			if ($user['mavis_otp_enabled'] == 1 OR $user['mavis_sms_enabled'] == 1) $login = 'mavis';
			array_push($outputUsers[$user['id']],
			($html) ? $sp->put('a').self::$html_tags['param'][0] . "login" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $login . self::$html_tags['val'][1]
			:
			$sp->put('a').'login = '. $login);
      ///USER MEMBER///
			if ( !empty($user['group']) ){
        $user_group_id = explode(';;', $user['group']);
        $user_group = '';
        for ($i=0; $i < count($user_group_id); $i++) {
          if ( isset($allUserGroups[$user_group_id[$i]]) ) {
            if ( $i == 0 ) $user_group .= $allUserGroups[$user_group_id[$i]];
            else $user_group .= '/'.$allUserGroups[$user_group_id[$i]];
          }
        }

        array_push($outputUsers[$user['id']],
  			($html) ? $sp->put().self::$html_tags['param'][0] . "member" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user_group . self::$html_tags['val'][1]
  			:
  			$sp->put().'member = '.$user_group);
      }
			///USER PAP///
			// if ($user['pap_clone'] == 1) array_push($outputUsers[$user['id']],
			// ($html) ? '	'.self::$html_tags['param'][0] . "pap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $login . self::$html_tags['val'][1]
			// :
			// '	pap = '. $login);
			if ( $user['pap_flag'] == 3 ) $user['pap'] = ' #local';
			if ( $user['pap'] != '' OR $user['pap_flag'] == 3 OR $user['pap_flag'] == 4 ) array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "pap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$user['pap_flag']].' '. ( ( $user['pap_flag'] != 4 ) ? $user['pap'] : '' ) . self::$html_tags['val'][1]
			:
			$sp->put().'pap = '. self::$crypto_flag[$user['pap_flag']].' '. ( ($user['pap_flag'] != 4 ) ? $user['pap'] : '' ) );
			///USER CHAP///
			if (!empty($user['chap'])) array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "chap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'clear '.$user['chap'] . self::$html_tags['val'][1]
			:
			$sp->put().'chap = '. 'clear '.$user['chap']);
			///USER MS-CHAP///
			if (!empty($user['ms-chap'])) array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "ms-chap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'clear '.$user['ms-chap'] . self::$html_tags['val'][1]
			:
			$sp->put().'ms-chap = '. 'clear '.$user['ms-chap']);
			///USER ENABLE///
			if ( $user['enable_flag'] == 3 ) $user['enable'] = ' #local';
			if ($user['enable'] != '' OR $user['enable_flag'] == 4 ) array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$user['enable_flag']].' '. ( ($user['enable_flag'] != 4 ) ? $user['enable'] : '') . self::$html_tags['val'][1]
			:
			$sp->put().'enable = '.self::$crypto_flag[$user['enable_flag']].' '. ( ($user['enable_flag'] != 4 ) ? $user['enable'] : '') );
			///USER ACL///
			if ($user['acl'] > 0)array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $allACL[$user['acl']] . self::$html_tags['val'][1]
			:
			$sp->put().'acl = '. $allACL[$user['acl']]);
			///USER MESSAGE///
			///USER CLIENT IP///
			// if ($user['client_ip'] > 0)array_push($outputUsers[$user['id']],
			// ($html) ? $sp->put().self::$html_tags['param'][0] . "client" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user['client_ip'] . self::$html_tags['val'][1] . ' # NAC ip must be in that range'
			// :
			// $sp->put().'client = '. $user['client_ip']);
			// ///USER SERVER IP///
			// if ($user['server_ip'] > 0)array_push($outputUsers[$user['id']],
			// ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user['server_ip'] . self::$html_tags['val'][1] . ' # NAS ip must be in that range'
			// :
			// $sp->put().'server = '. $user['server_ip']);
			///USER MESSAGE///
			if ($user['message']!='')array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "message" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$user['message'].'"'. self::$html_tags['val'][1]
			:
			$sp->put().'message = "'.$user['message'].'"');
      ///USER Valid From///
      if ($user['valid_from']!='')array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid from" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($user['valid_from']). self::$html_tags['val'][1] .' # '.$user['valid_from']
			:
			$sp->put().'valid from = '.strtotime($user['valid_from']).' # '.$user['valid_from']);
      ///USER Valid Until///
      if ($user['valid_until']!='')array_push($outputUsers[$user['id']],
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid until" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($user['valid_until']). self::$html_tags['val'][1] .' # '.$user['valid_until']
			:
			$sp->put().'valid until = '.strtotime($user['valid_until']).' # '.$user['valid_until']);
      ///USER DEFAULT SERVICE///
      if ( $user['default_service'] ) array_push($outputUsers[$user['id']],
      ($html) ? $sp->put().self::$html_tags['param'][0] . "default service" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'permit'. self::$html_tags['val'][1]
      :
      $sp->put().'default service = permit');

      ///USER SERVER IP///
      if ( !empty($user['device_group_list']) OR !empty($user['device_list']) ){
        $dev_list = TACDevices::select('name', 'ipaddr', 'prefix', 'disabled')->whereIn( 'id', explode(';;', $user['device_list']) )->get();
        $devg_list = TACDevices::select('name', 'ipaddr', 'prefix', 'disabled')->whereIn( 'group', explode(';;', $user['device_group_list']) )->get();
        $tempArray_d = [];
        $action_html = ( $user['device_list_action']) ? self::$html_tags['param'][0] .'permit'.self::$html_tags['param'][1] : self::$html_tags['object'][0].'deny'.self::$html_tags['object'][1];
        $action = ( $user['device_list_action']) ? 'permit' : 'deny';
        for ($i=0; $i < count($dev_list) ; $i++) {
          if ($dev_list[$i]->disabled) continue;
          $tempArray_d[] = $dev_list[$i]->name;
          array_push($outputUsers[$user['id']],
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $dev_list[$i]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $dev_list[$i]->ipaddr . '/' . $dev_list[$i]->prefix . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $dev_list[$i]->name);
        }
        for ($dg=0; $dg < count($devg_list) ; $dg++) {
          if ( $devg_list[$dg]->disabled ) continue;
          if (in_array($devg_list[$dg]->name, $tempArray_d)) continue;
          array_push($outputUsers[$user['id']],
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $devg_list[$dg]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $devg_list[$dg]->ipaddr . '/' . $devg_list[$dg]->prefix . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $devg_list[$dg]->name);
        }
        if ( $user['device_list_action'] ) array_push($outputUsers[$user['id']],
        ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['object'][0].'deny 0.0.0.0/0'. self::$html_tags['object'][1] . self::$html_tags['comment'][0] . ' # permit ONLY' . self::$html_tags['comment'][1]
        :
        $sp->put().'server = deny 0.0.0.0/0 # permit ONLY');

      }

			///USER SERVICE SHELL///
			if ($user['service'] == 0 AND  $user['group'] == 0) {

        array_push($outputUsers[$user['id']],
				($html) ? $sp->put().self::$html_tags['comment'][0] . "### Service no set ###" . self::$html_tags['comment'][1]
				:
				$sp->put().'### Service no set ###');

			}

			if ($user['service'] != 0) {

				$outputUsers[$user['id']] = array_merge( $outputUsers[$user['id']],  self::tacService($html, $user['service'], true) );

			}
			elseif($user['group'] != 0){
				array_push($outputUsers[$user['id']],
				($html) ? $sp->put().self::$html_tags['comment'][0] . "### GET SERVICES FROM GROUP" . self::$html_tags['comment'][1]
				:
				$sp->put().'### GET SERVICES FROM GROUP');
			}

      ///USER MANUAL CONFIGURATION///
      $outputUsers[$user['id']] = array_merge( $outputUsers[$user['id']],  self::manualConfigPrint($user['manual'], $html) );

			array_push($outputUsers[$user['id']],
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$user['username'] . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$user['username']);

		}

		return $outputUsers;
	}

	public static function tacMavisGeneralGen($html)
	{
		$html = (empty($html)) ? false : true;
    $sp = new spacer();
		$mavis_ldap_settings = MAVISLDAP::select()->first();
		$mavis_otp_settings = MAVISOTP::select()->first();
		$mavis_sms_settings = MAVISSMS::select()->first();
		$mavis_local_settings = MAVISLocal::select()->first();

		if ($mavis_ldap_settings->enabled == 0 AND $mavis_otp_settings->enabled == 0 AND $mavis_sms_settings->enabled == 0 AND $mavis_local_settings->enabled == 0) return array('title_flag' => 0, 'name' =>"");

		$outputMavisGeneral[0][0]=array('title_flag' => 1, 'name' =>
		($html) ? $sp->put('a').self::$html_tags['comment'][0] . "####MAVIS GENERAL SETTINGS####" . self::$html_tags['comment'][1]
		:
		$sp->put('a')."####MAVIS GENERAL SETTINGS####");
		///EMPTY ARRAY///
		$outputMavisGeneral[1] = array();
		///MAVIS GENERAL TITLE///
		$outputMavisGeneral[1][0] = array('title_flag' => 0, 'name' =>"");
		///MAVIS GENERAL SETTINGS START///
		array_push($outputMavisGeneral[1],
		($html) ? $sp->put().self::$html_tags['attr'][0] . "user backend" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'mavis' . self::$html_tags['object'][1]
		:
		$sp->put().'user backend = mavis');
    $mavis_params = '';
    $mavis_params .= ( MAVISLocal::where([['enabled', 1],['change_passwd_cli', 1]])->count() ) ? ' chpass' : '';
    $mavis_params .= ( MAVISSMS::where('enabled', 1)->count() ) ? ' chalresp' : '';
		array_push($outputMavisGeneral[1],
		($html) ? $sp->put().self::$html_tags['attr'][0] . "login backend" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'mavis'.  $mavis_params . self::$html_tags['object'][1]
		:
		$sp->put().'login backend = mavis'. $mavis_params);
		array_push($outputMavisGeneral[1],
		($html) ? $sp->put().self::$html_tags['attr'][0] . "pap backend" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'mavis' . self::$html_tags['object'][1]
		:
		$sp->put().'pap backend = mavis');

    if ( MAVISLocal::where('enabled', 1)->count() OR MAVISLDAP::where('enabled', 1)->count() OR MAVISOTP::where('enabled', 1)->count() OR MAVISSMS::where('enabled', 1)->count() ){
      array_push($outputMavisGeneral[1],
  		($html) ? $sp->put().self::$html_tags['attr'][0] . "mavis module" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'external' . self::$html_tags['object'][1] . ' {'
  		:
  		$sp->put().'mavis module = external {');

  		///MAVIS GLOBAL PATH///
  		array_push($outputMavisGeneral[1],
  		($html) ? $sp->put('a').self::$html_tags['param'][0] . "exec" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . TAC_ROOT_PATH . '/mavis/app.php' . self::$html_tags['val'][1]
  		:
  		$sp->put('a').'exec = ' . TAC_ROOT_PATH . '/mavis/app.php');

  		array_push($outputMavisGeneral[1],
  		($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF MAVIS GLOBAL SETTINGS' . self::$html_tags['comment'][1]
  		:
  		$sp->put('d').'} #END OF MAVIS GLOBAL SETTINGS');
    }

	return $outputMavisGeneral;
	}

  public static function tacService($html = false, $id = 0, $noPreview = false, $space = 0)
	{
    if ( $id == 0 ) return [];
    $sp = new spacer(1);
    $service = TACServices::select()->where('id', $id)->first()->toArray();

			///EMPTY ARRAY///
			$outputService[$service['id']] = array();
			///Service TITLE///
			if ( ! $noPreview ) $outputService[$service['id']][0] = array('title_flag' => 0, 'name' =>"");
			array_push($outputService[$service['id']], ($html) ? $sp->put('a').self::$html_tags['comment'][0] . '###Service '.$service['name'].' START###' . self::$html_tags['comment'][1]
			:
			$sp->put('a').'###Service '.$service['name'].' START###');

      if( ! $service['manual_conf_only'] ){

        ///Cisco RS///START///
        if ( $service['cisco_rs_enable'] ) {
          //start//
          // if ( !empty($service['cisco_rs_privlvl']) ) array_push($outputService[$service['id']],
    			// ($html) ? self::$html_tags['param'][0] . "priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_privlvl'] . self::$html_tags['val'][1]
    			// :
    			// 'priv-lvl = '.$service['cisco_rs_privlvl']);

          array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
    			:
    			$sp->put().'service = shell {');

          $autoCmd = explode( ';;', $service['cisco_rs_autocmd'] );
          $sp->put('a');
          for ($i=0; $i < count($autoCmd); $i++) {
            if ( empty($autoCmd[$i]) ) continue;

            array_push($outputService[$service['id']],
      			($html) ? $sp->put().self::$html_tags['param'][0] . "set autocmd" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] . $autoCmd[$i] . self::$html_tags['val'][1] . '"'
      			:
      			$sp->put().'set autocmd = "' . $autoCmd[$i] . '"');
          }

          if ( $service['cisco_rs_privlvl'] != -1 ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_privlvl'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set priv-lvl = '.$service['cisco_rs_privlvl']);

          if ( !empty($service['cisco_rs_def_attr']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default attribute" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default attribute = permit');
          if ( !empty($service['cisco_rs_def_cmd']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default cmd = permit');
          if ( !empty($service['cisco_rs_idletime']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set idletime" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_idletime'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set idletime = ' . $service['cisco_rs_idletime']);
          if ( !empty($service['cisco_rs_timeout']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_timeout'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set timeout = ' . $service['cisco_rs_timeout']);

          if ( !empty($service['cisco_rs_cmd']) ){

            $cmdIdList = explode( ';;', $service['cisco_rs_cmd'] );

            $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::tacCMDAttr($html, $cmdIdList, 'cisco', 3) );

          }

          if ( !empty($service['cisco_rs_nexus_roles']) ){

            $nexusRoles = explode( ' ', $service['cisco_rs_nexus_roles'] );
            $shellRoles = '';
            for ($nxr=0; $nxr < count($nexusRoles); $nxr++) {
              $comma = ($nxr == 0 ) ? '' : ',';
              $shellRoles .= $comma.'\"'.$nexusRoles[$nxr].'\"';
            }
            array_push($outputService[$service['id']],
      			($html) ? $sp->put().self::$html_tags['param'][0] . "set shell:roles" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] . $shellRoles . self::$html_tags['val'][1] .'"'
      			:
      			$sp->put().'set shell:roles = "' . $shellRoles .'"');

          }

          if ( !empty($service['cisco_rs_debug_message']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "message debug" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . '"to permit: cmd = %c { permit /^%a$/ } to deny: cmd = %c { deny /^%a$/ }"' . self::$html_tags['val'][1]
    			:
    			$sp->put().'message debug = ' . '"to permit: cmd = %c { permit /^%a$/ } to deny: cmd = %c { deny /^%a$/ }"');

          $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['cisco_rs_manual'], $html) );

          //end//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Cisco Router/Switch Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Cisco Router/Switch Service');
        }
        ///Cisco RS///END///
        ///H3C///START///
        if ( $service['h3c_enable'] ) {
          //start//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
    			:
    			$sp->put().'service = shell {');

          if ( $service['h3c_privlvl'] != -1 ) array_push($outputService[$service['id']],
    			($html) ? $sp->put('a').self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['h3c_privlvl'] . self::$html_tags['val'][1]
    			:
    			$sp->put('a').'set priv-lvl = '.$service['h3c_privlvl']);

          if ( !empty($service['h3c_def_attr']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default attribute" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default attribute = permit');
          if ( !empty($service['h3c_def_cmd']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default cmd = permit');
          if ( !empty($service['h3c_idletime']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set idletime" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['h3c_idletime'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set idletime = ' . $service['h3c_idletime']);
          if ( !empty($service['h3c_timeout']) ) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['h3c_timeout'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set timeout = ' . $service['h3c_timeout']);

          if ( !empty($service['h3c_cmd']) ){

            $cmdIdList = explode( ';;', $service['h3c_cmd'] );

            $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::tacCMDAttr($html, $cmdIdList, 'cisco', 3) );

          }

          $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['h3c_manual'], $html) );

          //end//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF H3C General Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF H3C General Service');
        }
        ///H3C///END///
        ///JunOS///START///
        if ( $service['junos_enable'] ) {
          //start//
          array_push($outputService[$service['id']],
          ($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'junos-exec' . self::$html_tags['object'][1] . ' {'
          :
          $sp->put().'service = junos-exec {');

          if ( empty($service['junos_username']) != -1 ) array_push($outputService[$service['id']],
          ($html) ? $sp->put('a').self::$html_tags['param'][0] . "set local-user-name" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] . $service['junos_username'] . self::$html_tags['val'][1] . '"'
          :
          $sp->put('a').'set local-user-name = "'.$service['junos_username'].'"');

          if ( !empty($service['junos_cmd_ao']) ){

            $cmdIdList = explode( ';;', $service['junos_cmd_ao'] );

            array_push($outputService[$service['id']],
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set set allow-commands" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3)
            :
            $sp->put().'set allow-commands = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3));

          }
          if ( !empty($service['junos_cmd_do']) ){

            $cmdIdList = explode( ';;', $service['junos_cmd_do'] );

            array_push($outputService[$service['id']],
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set set allow-commands" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3, ['action' => 'deny'])
            :
            $sp->put().'set deny-commands = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3));

          }
          if ( !empty($service['junos_cmd_ac']) ){

            $cmdIdList = explode( ';;', $service['junos_cmd_ac'] );

            array_push($outputService[$service['id']],
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set set allow-configuration" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3)
            :
            $sp->put().'set allow-configuration = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3));

          }
          if ( !empty($service['junos_cmd_dc']) ){

            $cmdIdList = explode( ';;', $service['junos_cmd_dc'] );

            array_push($outputService[$service['id']],
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set set deny-configuration" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3, ['action' => 'deny'])
            :
            $sp->put().'set deny-configuration = ' . self::tacCMDAttr($html, $cmdIdList, 'junos', 3));

          }

          $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['junos_manual'], $html) );

          //end//
          array_push($outputService[$service['id']],
          ($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF JunOS General Service'. self::$html_tags['comment'][1]
          :
          $sp->put('d').'} #END OF JunOS General Service');
        }
        ///JunOS///END///
        ///Cisco WLC///START///
        if ( $service['cisco_wlc_enable'] ) {
          //start//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put('a').self::$html_tags['attr'][0] . "service " . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'ciscowlc' . self::$html_tags['object'][1] . ' {'
    			:
    			$sp->put().'service = ciscowlc {');
          $sp->put('a');
          $roles = explode( ';;', $service['cisco_wlc_roles'] );

          for ($i=0; $i < count($roles); $i++) {
            if (! in_array($roles[$i], array_keys(self::$ciscoWLCRoles) ) ) continue;

            array_push($outputService[$service['id']],
      			($html) ? $sp->put().self::$html_tags['param'][0] . "set role". ($i + 1) . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$ciscoWLCRoles[$roles[$i]] . self::$html_tags['val'][1]
      			:
      			$sp->put().'set role'. ($i + 1) .' = ' . self::$ciscoWLCRoles[$roles[$i]] );
          }

          $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['cisco_wlc_manual'], $html) );

          //end//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Cisco WLC Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Cisco WLC Service');
        }
        ///Cisco WLC///END///
        ///FortiOS///START///
        if ( $service['fortios_enable'] ) {
          //start//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['attr'][0] . "service " . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'fortigate' . self::$html_tags['object'][1] . ' {'
    			:
    			$sp->put().'service = fortigate {');

          if (!empty($service['fortios_admin_prof'])) array_push($outputService[$service['id']],
    			($html) ? $sp->put('a').self::$html_tags['param'][0] . "optional admin_prof" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['fortios_admin_prof'] . self::$html_tags['val'][1]
    			:
    			$sp->put('a').'optional admin_prof = '.$service['fortios_admin_prof']);

          $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['fortios_manual'], $html) );

          //end//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF FortiOS Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF FortiOS Service');
        }
        ///FortiOS///END///
        ///PaloALto///START///
        if ( $service['paloalto_enable'] ) {
          //start//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'PaloAlto' . self::$html_tags['object'][1] . ' {'
    			:
    			$sp->put().'service = PaloAlto {');

          array_push($outputService[$service['id']],
    			($html) ? $sp->put('a').self::$html_tags['object'][0] . "set protocol = firewall" . self::$html_tags['object'][1] . self::$html_tags['comment'][0] . " #default settings" . self::$html_tags['comment'][1]
    			:
    			$sp->put('a').'set protocol = firewall #default settings');

          if (!empty($service['paloalto_admin_role'])) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Admin-Role" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_admin_role'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Admin-Role = '.$service['paloalto_admin_role']);

          if (!empty($service['paloalto_admin_domain'])) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Admin-Access-Domain" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_admin_domain'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Admin-Access-Domain = '.$service['paloalto_admin_domain']);

          if (!empty($service['paloalto_panorama_admin_role'])) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Panorama-Admin-Role" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_panorama_admin_role'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Panorama-Admin-Role = '.$service['paloalto_panorama_admin_role']);

          if (!empty($service['paloalto_panorama_admin_domain'])) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Panorama-Admin-Access-Domain" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_panorama_admin_domain'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Panorama-Admin-Access-Domain = '.$service['paloalto_panorama_admin_domain']);

          if (!empty($service['paloalto_user_group'])) array_push($outputService[$service['id']],
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-User-Group" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_user_group'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-User-Group = '.$service['paloalto_user_group']);

          $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['paloalto_manual'], $html) );

          //end//
          array_push($outputService[$service['id']],
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF PaloAlto Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF PaloAlto Service');
        }
        ///PaloAlto///END///
      }


      $outputService[$service['id']] = array_merge( $outputService[$service['id']],  self::manualConfigPrint($service['manual'], $html) );

			array_push($outputService[$service['id']], ($html) ? $sp->put().self::$html_tags['comment'][0] . '###Service '.$service['name'].' END###' . self::$html_tags['comment'][1]
			:
			$sp->put().'###Service '.$service['name'].' END###');

		if ( $noPreview ) return $outputService[$service['id']]; else return $outputService;
	}

  public static function tacCMDAttr($html = false, $id = [], $type = '', $space = 0, $params = [] )
  {
    $junosCmdTag = ( isset( $params['action'] )  AND $params['action'] == 'deny' ) ? self::$html_tags['object'] : self::$html_tags['val'];

    $cmdList = ( is_array($id) ) ? TACCMD::select()->where('type', $type)->whereIn('id', $id)->get() : TACCMD::select()->where('id', $id)->get();

    $onlyOne = ( !is_array($id) ) ; //VERY IMPORTANT FOR PREVIEW!!!//
    $sp = new spacer($space);

    $outputCMDAttr[0] = array();

    if ( $type == 'junos'){
      for ($cl=0; $cl < count($cmdList); $cl++) {
        $outputCMDAttr[0] = array_merge( $outputCMDAttr[0], explode( ';;', $cmdList[$cl]->cmd_attr ) );
      }

      $cmdAttrList = ( $html ) ? '"('.implode( '|', preg_filter('/$/', $junosCmdTag[1], preg_filter('/^/', $junosCmdTag[0], $outputCMDAttr[0] ) ) ) .')"'
      :
      '"('.implode( '|', $outputCMDAttr[0] ) .')"';
      //var_dump($cmdAttrList);die;
      return $cmdAttrList;
    }

    for ($cl=0; $cl < count($cmdList); $cl++) {
      if ( empty($cmdList[$cl]) ) continue;
      $cmdId = ($onlyOne) ? $cmdList[$cl]->id : 0;
      ///EMPTY ARRAY///
      $outputCMDAttr[$cmdId] = ($onlyOne) ? array() : $outputCMDAttr[$cmdId];
      ///Service TITLE///
      if ($onlyOne) $outputCMDAttr[$cmdId][0] = array('title_flag' => 0, 'name' =>"");
      array_push($outputCMDAttr[$cmdId], ($html) ? $sp->put().self::$html_tags['comment'][0] . '###CMD Attr '.$cmdList[$cl]->name.' START###' . self::$html_tags['comment'][1]
      :
      $sp->put().'###CMD Attr '.$cmdList[$cl]->name.' START###');
      if ( $cmdList[$cl]->type == 'junos' ){
        array_push($outputCMDAttr[$cmdId], ($html) ? $sp->put().self::$html_tags['comment'][0] . '### JunOS Attr ###' . self::$html_tags['comment'][1]
        :
        $sp->put().'### JunOS Attr ###');

        $cmdAttrList = '"('.implode( '|', preg_filter('/$/', self::$html_tags['val'][1], preg_filter('/^/', self::$html_tags['val'][0], explode( ';;', $cmdList[$cl]->cmd_attr ) ) ) ) .')"';

        array_push($outputCMDAttr[$cmdId], ($html) ? $sp->put(). $cmdAttrList
        :
        $sp->put().$cmdAttrList);

        if ($onlyOne) return $outputCMDAttr; else return $outputCMDAttr[0];
      }
      array_push($outputCMDAttr[$cmdId],
      ($html) ? $sp->put().self::$html_tags['param'][0] . "cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $cmdList[$cl]->cmd . self::$html_tags['val'][1]. ' {'
      :
      $sp->put().'cmd = ' . $cmdList[$cl]->cmd . ' {');
      $sp->put('a');
      $cmdAttrList = explode( ';;', $cmdList[$cl]->cmd_attr );
      for ($al=0; $al < count($cmdAttrList); $al++) {
        if ( empty($cmdAttrList[$al]) ) continue;

        array_push($outputCMDAttr[$cmdId],
        ($html) ?  $sp->put().$cmdAttrList[$al]
        :
        $sp->put().$cmdAttrList[$al]);
      }

      $outputCMDAttr[$cmdId] = array_merge( $outputCMDAttr[$cmdId],  self::manualConfigPrint($cmdList[$cl]->manual, $html) );

      if ( !empty($cmdList[$cl]->cmd_permit_end) ) array_push($outputCMDAttr[$cmdId],
      ($html) ? $sp->put().'permit .*'.self::$html_tags['comment'][0].' # default permit any'.self::$html_tags['comment'][1]
      :
      $sp->put().'permit .* # default permit any');
      if ( !empty($cmdList[$cl]->message_permit) ) array_push($outputCMDAttr[$cmdId],
      ($html) ? $sp->put().'message permit = "'.$cmdList[$cl]->message_permit.'"'
      :
      $sp->put().'message permit = "'.$cmdList[$cl]->message_permit.'"');
      if ( !empty($cmdList[$cl]->message_deny) ) array_push($outputCMDAttr[$cmdId],
      ($html) ? $sp->put().'message deny = "'.$cmdList[$cl]->message_deny.'"'
      :
      $sp->put().'message deny = "'.$cmdList[$cl]->message_deny.'"');

      array_push($outputCMDAttr[$cmdId],
      ($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF CMD Attr ' . $cmdList[$cl]->name . self::$html_tags['comment'][1]
      :
      $sp->put('d').'} #END OF CMD Attr ' . $cmdList[$cl]->name );
    }

    if ($onlyOne) return $outputCMDAttr; else return $outputCMDAttr[0];
  }


  public static function manualConfigPrint($data = '', $html = false)
  {
    ///MANUAL CONFIGURATION///
    $output = [];
		if ( ! empty($data) )
		{
			array_push($output, ($html) ? self::$html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . self::$html_tags['comment'][1]
			:
			'###MANUAL CONFIGURATION START###');
			$arrayManual=explode(PHP_EOL, $data);
			foreach($arrayManual as $item)
			{
				array_push($output, $item);
			}
			array_push($output, ($html) ? self::$html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . self::$html_tags['comment'][1]
			:
			'###MANUAL CONFIGURATION END###');
		}
    return $output;
  }

}

class spacer
{
  public $space;

  public function __construct($value = 0)
  {
    $this->space = '';
    for ($i=0; $i < $value; $i++) {
      $this->space .= '  ';
    }
  }

  public function put($action = 'n')
  {
    switch ($action) {
      case 'i':
        $this->space = '';
        return $this->space;

      case 'a':
        $this->space .= '  ';
        return $this->space;

      case 'd':
        if ($this->space == '' OR $this->space == ' ') {
          $this->space = '';
          return $this->space;
        }
        $this->space = preg_replace('/\s{2}$/', '', $this->space);;
        return $this->space;
    }
    return $this->space;
  }
}
