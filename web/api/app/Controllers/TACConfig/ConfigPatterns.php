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

  public static $crypto_flag = array(0 => 'clear', 1 => 'crypt', 2 => 'crypt', 3 => '# Local Database', 4 => '# Clone login', 10 => '# One-Time Password', 20 => '# LDAP', 30 => '# SMS');
	public static $html_tags = array(
		'comment' => [
			0 => '<span class="tac-comment">',
			1 => '</span>'
		],
		'attr' => [
			0 => '<span class="tac-attr">',
			1 => '</span>'
		],
		'param' => [
			0 => '<span class="tac-param">',
			1 => '</span>'
		],
		'val' => [
			0 => '<span class="tac-val">',
			1 => '</span>'
		],
		'object' => [
			0 => '<span class="tac-object">',
			1 => '</span>'
		],
	);

  public static function tacSpawndPartGen($html)
	{
		$html = (empty($html)) ? false : true;
    $sp = new spacer();
		$globalVariables=TACGlobalConf::select('port')->first();
		$outputSpawnd = array();
		$outputSpawnd[]= ($html) ? $sp->put('i') . self::$html_tags['comment'][0] . "####SPAWND####" . self::$html_tags['comment'][1]
		:
		$sp->put('i') . "####SPAWND####";
			///EMPTY ARRAY///
			//$outputSpawnd[1] = array();
			///GENERAL CONF TITLE///
			///LISTENING PORT///
		$outputSpawnd[] = "id = spawnd {";
		$outputSpawnd[] =
				($html) ? $sp->put('a') . self::$html_tags['attr'][0] .'listen' . self::$html_tags['attr'][1] .
				' = { '.self::$html_tags['param'][0].'port'.self::$html_tags['param'][1].
				' = '.self::$html_tags['val'][0].$globalVariables['port'].self::$html_tags['val'][1].' }'
				:
				$sp->put('a') . 'listen = { port = '.$globalVariables['port'].' }';
    $outputSpawnd[] = ($html) ? '} '.self::$html_tags['comment'][0] .'##END OF SPAWND'.self::$html_tags['comment'][1]
      :
      '} ##END OF SPAWND';

		return $outputSpawnd;
	}

  public static function tacGeneralPartGen($html)
	{
		$html = (empty($html)) ? false : true;
    $sp = new spacer();
		$globalVariables=TACGlobalConf::select()->first();
		$outputGeneralConf = array();
		$outputGeneralConf[] =
			($html) ? $sp->put('i') . self::$html_tags['comment'][0] . "####GENERAL CONFIGURATION####" . self::$html_tags['comment'][1]
			:
			$sp->put('i') . "####GENERAL CONFIGURATION####";
			///EMPTY ARRAY///
			$outputGeneralConf[] = 'id = tac_plus {';
			///GENERAL CONF TITLE///

			///////////MANUAL CONFIGURATION/////////////
			if ($globalVariables['manual']!="")
			{
				array_push($outputGeneralConf, ($html) ? $sp->put('a') . self::$html_tags['comment'][0] . '###MANUAL CONFIGURATION START###' . self::$html_tags['comment'][1]
				:
				$sp->put('a') . '###MANUAL CONFIGURATION START###');
				$arrayManual=explode(PHP_EOL, $globalVariables['manual']);
				foreach($arrayManual as $item)
				{
					array_push($outputGeneralConf, $item);
				}
				array_push($outputGeneralConf, ($html) ? $sp->put() . self::$html_tags['comment'][0] . '###MANUAL CONFIGURATION END###' . self::$html_tags['comment'][1]
				:
				$sp->put() . '###MANUAL CONFIGURATION END###');
			}
			///ACCOUNTING LOG///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'accounting log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['accounting'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'accounting log = '.$globalVariables['accounting']);
			///AUTHENTICATION LOG///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'authentication log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['authentication'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'authentication log = '.$globalVariables['authentication']);
			///AUTHORIZATION LOG///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'authorization log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['authorization'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'authorization log = '.$globalVariables['authorization']);
      ///Syslog Settings///
      if ( !empty($globalVariables['syslog_ip']) ) {
        array_push($outputGeneralConf, ($html) ? $sp->put() . self::$html_tags['comment'][0] . '###Syslog Settings###' . self::$html_tags['comment'][1]
				:
				$sp->put() . '###Syslog Settings###');
        array_push($outputGeneralConf,
  			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'authentication log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['syslog_ip'].':'.$globalVariables['syslog_port'] . self::$html_tags['val'][1]
  			:
  			$sp->put() . 'authentication log = '.$globalVariables['syslog_ip'].':'.$globalVariables['syslog_port']);
        array_push($outputGeneralConf,
  			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'authorization log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['syslog_ip'].':'.$globalVariables['syslog_port'] . self::$html_tags['val'][1]
  			:
  			$sp->put() . 'authorization log = '.$globalVariables['syslog_ip'].':'.$globalVariables['syslog_port']);
        array_push($outputGeneralConf,
  			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'accounting log' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['syslog_ip'].':'.$globalVariables['syslog_port'] . self::$html_tags['val'][1]
  			:
  			$sp->put() . 'accounting log = '.$globalVariables['syslog_ip'].':'.$globalVariables['syslog_port']);
      }
			///CONNECTION TIMEOUT TO NAS///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'connection timeout' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['connection_timeout'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'connection timeout = '.$globalVariables['connection_timeout']);
			///Context TIMEOUT///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'context timeout' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['context_timeout'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'context timeout = '.$globalVariables['context_timeout']);
			///Max attempt///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'password max-attempts' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['max_attempts'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'password max-attempts = '.$globalVariables['max_attempts']);
			///Backoff settings///
			array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'password backoff' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] . $globalVariables['backoff'] . self::$html_tags['val'][1]
			:
			$sp->put() . 'password backoff = '.$globalVariables['backoff']);
			///Separation Tag///
			if ( !empty($globalVariables['separation_tag']) ) array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'separation tag' . self::$html_tags['attr'][1] . ' = "' .self::$html_tags['val'][0] .$globalVariables['separation_tag']. self::$html_tags['val'][1].'"'
			:
			$sp->put() . 'separation tag = "'.$globalVariables['separation_tag'].'"');
			///Skip conflicting groups///
			if ( $globalVariables['skip_conflicting_groups'] ) array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'skip conflicting groups' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] .'yes'. self::$html_tags['val'][1]
			:
			$sp->put() . 'skip conflicting groups = yes');
			///Skip missing groups///
			if ( $globalVariables['skip_missing_groups'] ) array_push($outputGeneralConf,
			($html) ? $sp->put() . self::$html_tags['attr'][0] . 'skip missing groups' . self::$html_tags['attr'][1] . ' = ' .self::$html_tags['val'][0] .'yes'. self::$html_tags['val'][1]
			:
			$sp->put() . 'skip missing groups = yes');

		return $outputGeneralConf;
	}

	public static function tacDevicesPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);

    $outputDevices = [];

    $query = TACDevices::select(['tac_devices.*', 'addr.address as address', 'addr.type as addr_type',
        'a.name as acl', 'ug.name as ugroup', 'dg.name as group'])->
      leftJoin('obj_addresses as addr', 'addr.id', '=', 'tac_devices.address')->
      leftJoin('tac_device_groups as dg', 'dg.id', '=', 'tac_devices.group')->
      leftJoin('tac_user_groups as ug', 'ug.id', '=', 'tac_devices.user_group')->
      leftJoin('tac_acl as a', 'a.id', '=', 'tac_devices.acl');

		$allDevices = ( $id == 0 ) ? $query->get() : $query->where('tac_devices.id', $id)->get();
		if ( $id == 0 ) $outputDevices[]= ($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF HOSTS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF HOSTS####";

		foreach($allDevices as $host)
		{
			if ($host['disabled'] AND $id == 0) continue;

			///DEVICE NAME///
      $hostname = ($host->addr_type == 2) ? $host->address : $host->name;
			array_push($outputDevices,
			($html) ? $sp->put().self::$html_tags['attr'][0] . "host" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$hostname. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'host = '.$hostname.' {');
			///DEVICE IP ADDRESS///
      if ($host->addr_type != 2)
  			array_push($outputDevices,
  			($html) ? $sp->put('a').self::$html_tags['param'][0] . "address" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] .$host->address. self::$html_tags['val'][1].'"'
  			:
  			$sp->put('a').'address = "'.$host->address.'"');
			///DEVICE KEY///
			if ($host['key']!='')array_push($outputDevices,
			($html) ? $sp->put().self::$html_tags['param'][0] . "key" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] .$host->key. self::$html_tags['val'][1].'"'
			:
			$sp->put().'key = "'.$host->key.'"');
			///DEVICE ENABLE///
			if ($host['enable']!=''){
        if ($host->enable_flag == 0) $host['enable'] = '"'.$host['enable'].'"';
        array_push($outputDevices,
  			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .self::$crypto_flag[$host->enable_flag] . ' '. $host->enable . self::$html_tags['val'][1]
  			:
  			$sp->put().'enable = '.self::$crypto_flag[$host->enable_flag].' '.$host->enable);
      }
      ///DEVICE ACL///
			if ($host->acl)array_push($outputDevices,
			($html) ? $sp->put().self::$html_tags['param'][0] . "access acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $host->acl . self::$html_tags['val'][1]
			:
			$sp->put().'access acl = '. $host->acl);
      ///DEFAULT USER GROUP///
			if ($host->ugroup)array_push($outputDevices,
			($html) ? $sp->put().self::$html_tags['param'][0] . "default group" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $host->ugroup . self::$html_tags['val'][1]
			:
			$sp->put().'default group = '.$host->ugroup);
      ///CONNECTION TIMEOUT///
			if ($host->connection_timeout)array_push($outputDevices,
			($html) ? $sp->put().self::$html_tags['param'][0] . "connection timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $host->connection_timeout . self::$html_tags['val'][1]
			:
			$sp->put().'connection timeout = '.$host->connection_timeout);
			///DEVICE BANNER WELCOME///
			if ($host->banner_welcome) {
        $outputDevices = array_merge( $outputDevices,  self::messagePrint($host->banner_welcome ,'welcome banner', $html, $sp->put()) );
      }

			///DEVICE BANNER MOTD///
      if ($host->banner_motd) {
        $outputDevices = array_merge( $outputDevices,  self::messagePrint($host->banner_motd, 'motd banner', $html, $sp->put()) );
      }

			///DEVICE BANNER FAILED AUTH///
      if ($host->banner_failed) {
        $outputDevices = array_merge( $outputDevices,  self::messagePrint($host->banner_failed, 'failed authentication banner', $html, $sp->put()) );
      }

			///DEVICE GROUP///
			if ($host->group) array_push($outputDevices,
			($html) ? $sp->put().self::$html_tags['param'][0] . "template" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$host->group. self::$html_tags['val'][1]
			:
			$sp->put().'template = '.$host->group);

      ///DEVICE MANUAL CONFIGURATION///
			$outputDevices = array_merge( $outputDevices,  self::manualConfigPrint($host->manual, $html) );

			array_push($outputDevices,
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$host->name . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$host->name);

		}

		return $outputDevices;
	}

	public static function tacDeviceGroupsPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
    // $allACL_array = TACACL::select('id','name')->get()->toArray();
		// $allUserGroups_array = TACUserGrps::select('id','name')->get()->toArray();
		// $allACL = array();
		// $allUserGroups = array();
		// foreach($allACL_array as $acl)
		// {
		// 	$allACL[$acl['id']]=$acl['name'];
		// }
    //
		// foreach($allUserGroups_array as $ugrp)
		// {
		// 	$allUserGroups[$ugrp['id']]=$ugrp['name'];
		// }
    $outputDeviceGroups = [];
    $query = TACDeviceGrps::select(['tac_device_groups.*',
        'a.name as acl', 'ug.name as ugroup'])->
      leftJoin('tac_user_groups as ug', 'ug.id', '=', 'tac_device_groups.user_group')->
      leftJoin('tac_acl as a', 'a.id', '=', 'tac_device_groups.acl');

		$allDeviceGroups = ( $id == 0 ) ? $query->get() : $query->where('tac_device_groups.id', $id)->get();

		if ( $id == 0 ) $outputDeviceGroups[] = ($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF DEVICE GROUPS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF DEVICE GROUPS####";
		foreach($allDeviceGroups as $group)
		{
			///EMPTY ARRAY///
			// $outputDeviceGroups[$group['id']] = array();
			///GROUP TITLE///
			// $outputDeviceGroups[$group['id']][0] = array('title_flag' => 0, 'name' =>"");
			///GROUP NAME///
			array_push($outputDeviceGroups,
			($html) ? $sp->put().self::$html_tags['attr'][0] . "host" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$group->name. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'host = '.$group->name.' {');
      $sp->put('a');
			///GROUP KEY///
			if ($group->key)array_push($outputDeviceGroups,
			($html) ? $sp->put().self::$html_tags['param'][0] . "key" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] .$group->key. self::$html_tags['val'][1] .'"'
			:
			$sp->put().'key = "'.$group->key .'"');
			///GROUP ENABLE///
			if ($group->enable){
        if ($group->enable_flag == 0) $group->enable = '"'.$group->enable.'"';
        array_push($outputDeviceGroups,
  			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$group->enable_flag] . ' ' . $group->enable. self::$html_tags['val'][1]
  			:
  			$sp->put().'enable = '.self::$crypto_flag[$group->enable_flag].' '.$group->enable);
      }
      ///DEVICE ACL///
      if ($group->acl)array_push($outputDeviceGroups,
      ($html) ? $sp->put().self::$html_tags['param'][0] . "access acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group->acl . self::$html_tags['val'][1]
      :
      $sp->put().'access acl = '. $group->acl);
      ///DEFAULT USER GROUP///
      if ($group->ugroup)array_push($outputDeviceGroups,
      ($html) ? $sp->put().self::$html_tags['param'][0] . "default group" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group->ugroup . self::$html_tags['val'][1]
      :
      $sp->put().'default group = '.$group->ugroup);
      ///CONNECTION TIMEOUT///
      if ($group->connection_timeout)array_push($outputDeviceGroups,
      ($html) ? $sp->put().self::$html_tags['param'][0] . "connection timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group->connection_timeout . self::$html_tags['val'][1]
      :
      $sp->put().'connection timeout = '.$group->connection_timeout);
      ///GROUP BANNER WELCOME///
      if ($group->banner_welcome) {
        $outputDeviceGroups = array_merge( $outputDeviceGroups,  self::messagePrint($group->banner_welcome ,'welcome banner', $html, $sp->put()) );
      }

      ///GROUP BANNER MOTD///
      if ($group->banner_motd) {
        $outputDeviceGroups = array_merge( $outputDeviceGroups,  self::messagePrint($group->banner_motd, 'motd banner', $html, $sp->put()) );
      }

      ///GROUP BANNER FAILED AUTH///
      if ($group->banner_failed) {
        $outputDeviceGroups = array_merge( $outputDeviceGroups,  self::messagePrint($group->banner_failed, 'failed authentication banner', $html, $sp->put()) );
      }

      ///GROUP MANUAL CONFIGURATION///
      $outputDeviceGroups = array_merge( $outputDeviceGroups,  self::manualConfigPrint($group->manual, $html) );

			array_push($outputDeviceGroups,
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$group->name . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$group->name);

		}

		return $outputDeviceGroups;
	}

	public static function tacACLPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);
		$quety = TACACL::
      leftJoin('tac_acl_ace as ace', 'ace.acl_id', '=', 'tac_acl.id')->
      leftJoin('obj_addresses as addr_s', 'addr_s.id', '=', 'ace.nas')->
      leftJoin('obj_addresses as addr_c', 'addr_c.id', '=', 'ace.nac')->
      select(['tac_acl.name as name', 'tac_acl.nas as nas_id', 'tac_acl.nac as nac_id',
        'addr_s.name as nas_name', 'addr_c.name as nac_name', 'tac_acl.action',
        // 'addr_s.prefix as nas_prefix', 'addr_c.prefix as nac_prefix',
        'addr_s.address as nas', 'addr_c.address as nac',])->
      orderBy('name', 'ASC')->orderBy('ace.order', 'asc');
    $allACL = ( $id == 0 ) ? $quety->get() : $quety->where('tac_acl.id',$id)->get();

    $outputACL = [];
		if ( $id == 0 ) $outputACL[] = ($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF ACL####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF ACL####";
    $commentSwitcher = '';
		foreach($allACL as $acl)
		{
      if (!($commentSwitcher == $acl->name AND $commentSwitcher != '')) {
        array_push($outputACL, ($html) ? $sp->put().self::$html_tags['comment'][0] . '###ACL '.$acl->name.' START###' . self::$html_tags['comment'][1]
  			:
  			$sp->put().'###ACL '.$acl->name.' START###');
      }
      $commentSwitcher = $acl->name;
			///EMPTY ARRAY///
			//$outputACL[$acl['id']] = array();
			///ACL TITLE///
			// $outputACL[$acl['id']][0] = array('title_flag' => 0, 'name' =>"");
			// array_push($outputACL, ($html) ? $sp->put().self::$html_tags['comment'][0] . '###ACL '.$acl->name.' START###' . self::$html_tags['comment'][1]
			// :
			// $sp->put().'###ACL '.$acl->name.' START###');
			// $allAces = TACACL::select()->get()->toArray();
			// foreach($allACL as $ace)
			// {
				///ACL NAME///
        $action = ($acl['action']) ? 'permit' : 'deny';
				array_push($outputACL,
				($html) ? $sp->put().self::$html_tags['attr'][0] . "acl" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$acl->name. self::$html_tags['object'][1] . ' '.$action.' {'
				:
				$sp->put().'acl = '.$acl->name.' '.$action.' {');
        $sp->put('a');
				///ACL NAC///
        if ( !empty($acl->nac) )
  				array_push($outputACL,
  				($html) ? $sp->put().self::$html_tags['param'][0] . "nac" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$acl->nac. self::$html_tags['val'][1]
  				:
  				$sp->put().'nac = '.$acl->nac);
        else
          array_push($outputACL,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "# nac" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'any'. self::$html_tags['val'][1]
          :
          $sp->put().'# nac = any');

				///ACL NAS///
        if ( !empty($acl->nas) )
  				array_push($outputACL,
  				($html) ? $sp->put().self::$html_tags['param'][0] . "nas" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .$acl->nas. self::$html_tags['val'][1]
  				:
  				$sp->put().'nas = '.$acl->nas);
        else
          array_push($outputACL,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "# nas" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'any'. self::$html_tags['val'][1]
          :
          $sp->put().'# nas = any');
				///ACL END///
				array_push($outputACL, $sp->put('d').'}');
			// }
			// array_push($outputACL, ($html) ? $sp->put().self::$html_tags['comment'][0] . '###ACL '.$acl['name'].' END###' . self::$html_tags['comment'][1]
			// :
			// $sp->put().'###ACL '.$acl['name'].' END###');
		}

		return $outputACL;
	}

	public static function tacUserGroupsPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);

    $query = TACUserGrps::select(['tac_user_groups.*','ta.name as acl_name', 'ta2.name as acl_name2'])->
      leftJoin('tac_acl as ta', 'ta.id', '=', 'tac_user_groups.acl')->
      leftJoin('tac_acl as ta2', 'ta2.id', '=', 'tac_user_groups.acl_match');

		$allUserGroups = ($id == 0) ? $query->get()->toArray() : $query->where('tac_user_groups.id', $id)->get()->toArray();

		// $allUserGroups = ( $id == 0 ) ? TACUserGrps::select()->get()->toArray() : TACUserGrps::select()->where('id', $id)->get()->toArray();
		// $allACL_array = TACACL::select('id','name')->get()->toArray();

		// $allACL = array();
		// foreach($allACL_array as $acl)
		// {
		// 	$allACL[$acl['id']]=$acl['name'];
		// }
    $outputUserGroup = [];
		if ( $id == 0 ) $outputUserGroup[] = ($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF USER GROUPS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF USER GROUPS####";
    //$sp->put('a');
		foreach($allUserGroups as $group)
		{
			///EMPTY ARRAY///
			// $outputUserGroup[$group['id']] = array();
			///USER GROUP TITLE///
			// $outputUserGroup[$group['id']][0] = array('title_flag' => 0, 'name' =>"");
			///USER GROUP NAME///

			array_push($outputUserGroup,
			($html) ? $sp->put().self::$html_tags['attr'][0] . "group" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$group['name']. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'group = '.$group['name'].' {');
      $sp->put('a');
      if ($group['acl_name2'])
        array_push($outputUserGroup,
        ($html) ? $sp->put().self::$html_tags['comment'][0] . '### Associated with ACL '. $group['acl_name2'] . self::$html_tags['comment'][1]
        :
        $sp->put().'### Associated with ACL '. $group['acl_name2']);

      ///LDAP Groups///
      $ldapDn = TACUserGrps::from('tac_user_groups as tug')->leftJoin('ldap_bind as lb', 'lb.tac_grp_id','=','tug.id')->
        leftJoin('ldap_groups as ld','ld.id','=','lb.ldap_id')->
        select(['ld.dn as dn'])->where('lb.tac_grp_id',$group['id'])->get();

      if ( count($ldapDn) ){
        array_push($outputUserGroup,
    		($html) ? $sp->put().self::$html_tags['comment'][0] . "#### LDAP Groups List #### DistinguishedName ###" . self::$html_tags['comment'][1]
    		:
    		$sp->put()."#### LDAP Groups List #### DistinguishedName ###");
        for ($i=0; $i < count($ldapDn); $i++) {
          array_push($outputUserGroup,
      		($html) ? $sp->put().self::$html_tags['comment'][0] . "### ".$ldapDn[$i]->dn . self::$html_tags['comment'][1]
      		:
      		$sp->put()."### ".$ldapDn[$i]->dn);
        }
      }
			///USER GROUP ENABLE///
			if ($group['enable'] != ''){
        if ($group['enable_flag'] == 0) $group['enable'] = '"'.$group['enable'].'"';
        array_push($outputUserGroup,
  			($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$group['enable_flag']] .' '. $group['enable']. self::$html_tags['val'][1]
  			:
  			$sp->put().'enable = '.self::$crypto_flag[$group['enable_flag']].' '.$group['enable']);
      }
			///USER GROUP MESSAGE///
			if ($group['message']) {
        $outputUserGroup = array_merge( $outputUserGroup,  self::messagePrint($group['message'], 'message', $html, $sp->put()) );
      }
      // array_push($outputUserGroup,
			// ($html) ? $sp->put().self::$html_tags['param'][0] . "message" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$group['message'].'"'. self::$html_tags['val'][1]
			// :
			// $sp->put().'message = "'.$group['message'].'"');
      ///USER Valid From///
      if ($group['valid_from']!='')array_push($outputUserGroup,
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid from" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($group['valid_from']). self::$html_tags['val'][1] .' # '.$group['valid_from']
			:
			$sp->put().'valid from = '.strtotime($group['valid_from']).' # '.$group['valid_from']);
      ///USER Valid Until///
      if ($group['valid_until']!='')array_push($outputUserGroup,
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid until" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($group['valid_until']). self::$html_tags['val'][1] .' # '.$group['valid_until']
			:
			$sp->put().'valid until = '.strtotime($group['valid_until']).' # '.$group['valid_until']);
			///USER GROUP ACL///
			if ( !empty($group['acl_name']) ) {
				array_push($outputUserGroup,
				($html) ? $sp->put().self::$html_tags['param'][0] . "acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group['acl_name'] . self::$html_tags['val'][1]
				:
				$sp->put().'acl = '. $group['acl_name']);
			}
      ///USER CLIENT IP///
      // if ($group['client_ip'] > 0)array_push($outputUserGroup,
      // ($html) ? $sp->put().self::$html_tags['param'][0] . "client" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group['client_ip'] . self::$html_tags['val'][1] . ' # NAC ip must be in that range'
      // :
      // $sp->put().'client = '. $group['client_ip']);
      ///USER SERVER IP///
      $dev_list = TACDevices::select('tac_devices.name as name', 'disabled' , 'oa.address as address')-> //'ipaddr', 'prefix',
        leftJoin('tac_bind_dev as tb', 'tb.device_id', '=', 'id')->
        leftJoin('obj_addresses as oa', 'oa.id', '=', 'tac_devices.address')->
        where( 'tb.group_id', $group['id'] )->get();

      //array_push($outputUsers,   $group['id']);
      $devg_list = TACDevices::select('tac_devices.name as name', 'disabled' , 'oa.address as address')->
        leftJoin('tac_bind_devGrp as tb', 'tb.devGroup_id', '=', 'group')->
        leftJoin('obj_addresses as oa', 'oa.id', '=', 'tac_devices.address')->
        where( 'tb.group_id', $group['id'] )->get();

      if ( count($dev_list) OR count($devg_list) ){
        $tempArray_d = [];
        $action_html = ( $group['device_list_action']) ? self::$html_tags['param'][0] .'permit'.self::$html_tags['param'][1] : self::$html_tags['object'][0].'deny'.self::$html_tags['object'][1];
        $action = ( $group['device_list_action']) ? 'permit' : 'deny';
        for ($i=0; $i < count($dev_list) ; $i++) {
          if ($dev_list[$i]->disabled) continue;
          $tempArray_d[] = $dev_list[$i]->name;
          array_push($outputUserGroup,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $dev_list[$i]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $dev_list[$i]->address . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $dev_list[$i]->name);
        }
        for ($dg=0; $dg < count($devg_list) ; $dg++) {
          if ( $devg_list[$dg]->disabled ) continue;
          if (in_array($devg_list[$dg]->name, $tempArray_d)) continue;
          array_push($outputUserGroup,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $devg_list[$dg]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $devg_list[$dg]->address . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $devg_list[$dg]->name);
        }
        if ( $group['device_list_action'] ) array_push($outputUserGroup,
        ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['object'][0].'deny 0.0.0.0/0'. self::$html_tags['object'][1] . self::$html_tags['comment'][0] . ' # permit ONLY' . self::$html_tags['comment'][1]
        :
        $sp->put().'server = deny 0.0.0.0/0 # permit ONLY');

      }
      // if ($group['server_ip'] > 0)array_push($outputUserGroup,
      // ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $group['server_ip'] . self::$html_tags['val'][1] . ' # NAS ip must be in that range'
      // :
      // $sp->put().'server = '. $group['server_ip']);
			///USER GROUP DEFAULT SERVICE///
			if ($group['default_service'] == 1)
        array_push($outputUserGroup,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default service" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'permit'. self::$html_tags['val'][1]
    			:
    			$sp->put().'default service = permit');
			///USER GROUP SERVICE SHELL///
      $services = TACUserGrps::from('tac_user_groups as tug')->leftJoin('tac_bind_service as ts','ts.tac_grp_id','=','tug.id')->
        where('tug.id',$group['id'])->select('ts.service_id as serv_id')->get();
      for ($i=0; $i < count($services); $i++) {
        $outputUserGroup = array_merge( $outputUserGroup,  self::tacService($html, $services[$i]->serv_id, true) );
      }

			///USER GROUP MANUAL CONFIGURATION///
      $outputUserGroup = array_merge( $outputUserGroup,  self::manualConfigPrint($group['manual'], $html) );

			array_push($outputUserGroup,
			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF '.$group['name'] . self::$html_tags['comment'][1]
			:
			$sp->put('d').'} #END OF '.$group['name']);

		}

		return $outputUserGroup;
	}

	public static function tacUsersPartGen($html = false, $id = 0)
	{
    $sp = new spacer(1);

    $query = TACUsers::select(['tac_users.*','ta.name as acl_name'])->
      leftJoin('tac_acl as ta', 'ta.id', '=', 'tac_users.acl');

		$allUsers = ($id == 0) ? $query->get()->toArray() : $query->where('tac_users.id', $id)->get()->toArray();

    $outputUsers = [];
		if ($id == 0) $outputUsers[] = ($html) ? $sp->put().self::$html_tags['comment'][0] . "####LIST OF USERS####" . self::$html_tags['comment'][1]
		:
		$sp->put()."####LIST OF USERS####";
		foreach($allUsers as $user)
		{
			if ($user['disabled'] == 1 AND $id == 0) continue;
			///EMPTY ARRAY///
			// $outputUsers[$user['id']] = array();
			///USER TITLE///
			// $outputUsers[$user['id']][0] = array('title_flag' => 0, 'name' =>"");
			///USER NAME///
			array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['attr'][0] . "user" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] .$user['username']. self::$html_tags['object'][1] . ' {'
			:
			$sp->put().'user = '.$user['username'].' {');
			///USER KEY///
			$login = '';
			if ( !in_array( $user['login_flag'], [1, 2, 0] ) ) {
        $login = 'mavis ' . self::$crypto_flag[$user['login_flag']];
      } else $login = self::$crypto_flag[$user['login_flag']].' "'. $user['login'].'"';
			//$login = self::$crypto_flag[$user['login_flag']].' '. ( ($user['login_flag'] != 3 ) ? $user['login'] : '#local' );
			if ($user['mavis_otp_enabled'] == 1 OR $user['mavis_sms_enabled'] == 1) $login = 'mavis';
			array_push($outputUsers,
			($html) ? $sp->put('a').self::$html_tags['param'][0] . "login" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $login . self::$html_tags['val'][1]
			:
			$sp->put('a').'login = '. $login);
      ///USER MEMBER///
      $groups = TACUserGrps::from('tac_user_groups as tug')->
        select(['tug.name as name', 'ta.name as acl'])->
        leftJoin('tac_bind_usrGrp as tb', 'tb.group_id', '=', 'tug.id')->
        leftJoin('tac_acl as ta', 'ta.id', '=', 'tug.acl_match')->
        where('tb.user_id', $user['id'])->orderBy('tb.order', 'asc')->get();
			if ( count($groups) ){
        $user_group = '';
        $user_group_acl = [];
        for ($g=0; $g < count($groups); $g++) {
          if (!empty($groups[$g]->acl)) {
            $user_group_acl[] = ['acl' => $groups[$g]->acl, 'name' => $groups[$g]->name];
            continue;
          }
          if ( empty($user_group) ) $user_group .= $groups[$g]->name;
          else $user_group .= '/'.$groups[$g]->name;
        }

        if ( !empty($user_group) )
          array_push($outputUsers,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "member" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user_group . self::$html_tags['val'][1]
    			:
    			$sp->put().'member = '.$user_group);

        for ($ga=0; $ga < count($user_group_acl); $ga++) {
          $textLine = self::$html_tags['object'][0] .' acl '. $user_group_acl[$ga]['acl'] . self::$html_tags['object'][1];
          array_push($outputUsers,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "member" . self::$html_tags['param'][1] . $textLine .' = ' . self::$html_tags['val'][0] . $user_group_acl[$ga]['name'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'member acl '.$user_group_acl[$ga]['acl'].' = '.$user_group_acl[$ga]['name']);
        }
      }
			///USER PAP///
      $pap = '';
			if ( $user['pap_flag'] == 4 ) {
        $pap = 'login ' . self::$crypto_flag[$user['pap_flag']];
      } else $pap = (empty($user['pap'])) ? '' : self::$crypto_flag[$user['pap_flag']].' '. $user['pap'];
			if ( $pap != '' ) array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['param'][0] . "pap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $pap . self::$html_tags['val'][1]
			:
			$sp->put().'pap = '. $pap );
			///USER CHAP///
			if (!empty($user['chap'])) array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['param'][0] . "chap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'clear '.$user['chap'] . self::$html_tags['val'][1]
			:
			$sp->put().'chap = '. 'clear '.$user['chap']);
			///USER MS-CHAP///
			if (!empty($user['ms-chap'])) array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['param'][0] . "ms-chap" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'clear '.$user['ms-chap'] . self::$html_tags['val'][1]
			:
			$sp->put().'ms-chap = '. 'clear '.$user['ms-chap']);
			///USER ENABLE///
      $enable = '';
      if ( !in_array($user['enable_flag'], [1, 2, 0]) ) {
        $enable = 'login ' . self::$crypto_flag[$user['enable_flag']];
      }
      if ( !empty($user['enable']) AND in_array($user['enable_flag'], [1, 2, 0]) ) {
        if ($user['enable_flag'] == 0) $user['enable'] = '"'.$user['enable'].'"';
        $enable = self::$crypto_flag[$user['enable_flag']].' '. $user['enable'];
      }
      if ( !empty($enable) ) array_push($outputUsers,
      ($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $enable . self::$html_tags['val'][1]
      :
      $sp->put().'enable = '. $enable );
      // if ( $user['enable_flag'] == 3 ) $user['enable'] = ' #local';
			// if ($user['enable'] != '' OR $user['enable_flag'] == 4 ) array_push($outputUsers,
			// ($html) ? $sp->put().self::$html_tags['param'][0] . "enable" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$crypto_flag[$user['enable_flag']].' '. ( ($user['enable_flag'] != 4 ) ? $user['enable'] : '') . self::$html_tags['val'][1]
			// :
			// $sp->put().'enable = '.self::$crypto_flag[$user['enable_flag']].' '. ( ($user['enable_flag'] != 4 ) ? $user['enable'] : '') );
			///USER ACL///
      //array_push($outputUsers, $user['acl']);
			if ( $user['acl_name'] )array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['param'][0] . "acl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user['acl_name'] . self::$html_tags['val'][1]
			:
			$sp->put().'acl = '. $user['acl_name']);
			///USER MESSAGE///
			///USER CLIENT IP///
			// if ($user['client_ip'] > 0)array_push($outputUsers,
			// ($html) ? $sp->put().self::$html_tags['param'][0] . "client" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user['client_ip'] . self::$html_tags['val'][1] . ' # NAC ip must be in that range'
			// :
			// $sp->put().'client = '. $user['client_ip']);
			// ///USER SERVER IP///
			// if ($user['server_ip'] > 0)array_push($outputUsers,
			// ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $user['server_ip'] . self::$html_tags['val'][1] . ' # NAS ip must be in that range'
			// :
			// $sp->put().'server = '. $user['server_ip']);
			///USER MESSAGE///
			if ($user['message']!='') {
        $outputUsers = array_merge( $outputUsers,  self::messagePrint($user['message'], 'message', $html, $sp->put()) );
      }
      ///USER Valid From///
      if ($user['valid_from']!='')array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid from" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($user['valid_from']). self::$html_tags['val'][1] .' # '.$user['valid_from']
			:
			$sp->put().'valid from = '.strtotime($user['valid_from']).' # '.$user['valid_from']);
      ///USER Valid Until///
      if ($user['valid_until']!='')array_push($outputUsers,
			($html) ? $sp->put().self::$html_tags['param'][0] . "valid until" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .strtotime($user['valid_until']). self::$html_tags['val'][1] .' # '.$user['valid_until']
			:
			$sp->put().'valid until = '.strtotime($user['valid_until']).' # '.$user['valid_until']);
      ///USER DEFAULT SERVICE///
      if ( $user['default_service'] ) array_push($outputUsers,
      ($html) ? $sp->put().self::$html_tags['param'][0] . "default service" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'permit'. self::$html_tags['val'][1]
      :
      $sp->put().'default service = permit');

      ///USER SERVER IP///
      // if ( !empty($user['device_group_list']) OR !empty($user['device_list']) ){
      $dev_list = TACDevices::select('tac_devices.name as name', 'disabled' , 'oa.address as address')-> //'ipaddr', 'prefix',
        leftJoin('tac_bind_dev as tb', 'tb.device_id', '=', 'id')->
        leftJoin('obj_addresses as oa', 'oa.id', '=', 'tac_devices.address')->
        where( 'tb.user_id', $user['id'] )->get();

      //array_push($outputUsers,   $user['id']);
      $devg_list = TACDevices::select('tac_devices.name as name', 'disabled' , 'oa.address as address')->
        leftJoin('tac_bind_devGrp as tb', 'tb.devGroup_id', '=', 'group')->
        leftJoin('obj_addresses as oa', 'oa.id', '=', 'tac_devices.address')->
        where( 'tb.user_id', $user['id'] )->get();

      if ( count($dev_list) OR count($devg_list) ){
        $tempArray_d = [];
        $action_html = ( $user['device_list_action']) ? self::$html_tags['param'][0] .'permit'.self::$html_tags['param'][1] : self::$html_tags['object'][0].'deny'.self::$html_tags['object'][1];
        $action = ( $user['device_list_action']) ? 'permit' : 'deny';
        for ($i=0; $i < count($dev_list) ; $i++) {
          if ($dev_list[$i]->disabled) continue;
          $tempArray_d[] = $dev_list[$i]->name;
          array_push($outputUsers,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $dev_list[$i]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $dev_list[$i]->address . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $dev_list[$i]->name);
        }
        for ($dg=0; $dg < count($devg_list) ; $dg++) {
          if ( $devg_list[$dg]->disabled ) continue;
          if (in_array($devg_list[$dg]->name, $tempArray_d)) continue;
          array_push($outputUsers,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . $action_html . ' ' . self::$html_tags['val'][0] . $devg_list[$dg]->name . self::$html_tags['val'][1] . self::$html_tags['comment'][0] . ' # ' . $devg_list[$dg]->address . self::$html_tags['comment'][1]
          :
          $sp->put().'server = '. $action . ' ' . $devg_list[$dg]->name);
        }
        if ( $user['device_list_action'] ) array_push($outputUsers,
        ($html) ? $sp->put().self::$html_tags['param'][0] . "server" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['object'][0].'deny 0.0.0.0/0'. self::$html_tags['object'][1] . self::$html_tags['comment'][0] . ' # permit ONLY' . self::$html_tags['comment'][1]
        :
        $sp->put().'server = deny 0.0.0.0/0 # permit ONLY');

      }

			///USER SERVICE SHELL///
      $services = TacUsers::from('tac_users as tu')->leftJoin('tac_bind_service as ts','ts.tac_usr_id','=','tu.id')->
        where('tu.id',$user['id'])->select('ts.service_id as serv_id')->get();
      for ($i=0; $i < count($services); $i++) {
        $outputUsers = array_merge( $outputUsers,  self::tacService($html, $services[$i]->serv_id, true) );
      }

      ///USER MANUAL CONFIGURATION///
      $outputUsers = array_merge( $outputUsers,  self::manualConfigPrint($user['manual'], $html) );

			array_push($outputUsers,
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

		if ($mavis_ldap_settings->enabled == 0 AND $mavis_otp_settings->enabled == 0 AND $mavis_sms_settings->enabled == 0 AND $mavis_local_settings->enabled == 0)
      return array();
    $outputMavisGeneral = [];
		$outputMavisGeneral[]= ($html) ? $sp->put('a').self::$html_tags['comment'][0] . "####MAVIS GENERAL SETTINGS####" . self::$html_tags['comment'][1]
		:
		$sp->put('a')."####MAVIS GENERAL SETTINGS####";
		///EMPTY ARRAY///
		//$outputMavisGeneral[1] = array();
		///MAVIS GENERAL TITLE///
		//$outputMavisGeneral[1][0] = array('title_flag' => 0, 'name' =>"");
		///MAVIS GENERAL SETTINGS START///
		array_push($outputMavisGeneral,
		($html) ? $sp->put().self::$html_tags['attr'][0] . "user backend" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'mavis' . self::$html_tags['object'][1]
		:
		$sp->put().'user backend = mavis');
    $mavis_params = '';
    $mavis_params .= ( MAVISLocal::where([['enabled', 1],['change_passwd_cli', 1]])->count() ) ? ' chpass' : '';
    $mavis_params .= ( MAVISSMS::where('enabled', 1)->count() ) ? ' chalresp' : '';
		array_push($outputMavisGeneral,
		($html) ? $sp->put().self::$html_tags['attr'][0] . "login backend" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'mavis'.  $mavis_params . self::$html_tags['object'][1]
		:
		$sp->put().'login backend = mavis'. $mavis_params);
		array_push($outputMavisGeneral,
		($html) ? $sp->put().self::$html_tags['attr'][0] . "pap backend" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'mavis' . self::$html_tags['object'][1]
		:
		$sp->put().'pap backend = mavis');

    if ( MAVISLocal::where('enabled', 1)->count() OR MAVISLDAP::where('enabled', 1)->count() OR MAVISOTP::where('enabled', 1)->count() OR MAVISSMS::where('enabled', 1)->count() ){
      array_push($outputMavisGeneral,
  		($html) ? $sp->put().self::$html_tags['attr'][0] . "mavis module" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0] . 'external' . self::$html_tags['object'][1] . ' {'
  		:
  		$sp->put().'mavis module = external {');

  		///MAVIS GLOBAL PATH///
  		array_push($outputMavisGeneral,
  		($html) ? $sp->put('a').self::$html_tags['param'][0] . "exec" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . TAC_ROOT_PATH . '/mavis/app.php' . self::$html_tags['val'][1]
  		:
  		$sp->put('a').'exec = ' . TAC_ROOT_PATH . '/mavis/app.php');

  		array_push($outputMavisGeneral,
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
    $acl = TACACL::select('name')->where('id',$service['acl'])->first();

			///EMPTY ARRAY///
			$outputService = array();
			///Service TITLE///
			// if ( ! $noPreview ) $outputService[0] = array('title_flag' => 0, 'name' =>"");
			array_push($outputService, ($html) ? $sp->put('a').self::$html_tags['comment'][0] . '###Service '.$service['name'].' START###' . self::$html_tags['comment'][1]
			:
			$sp->put('a').'###Service '.$service['name'].' START###');

      if( ! $service['manual_conf_only'] ){

        ///Cisco RS///START///
        if ( $service['cisco_rs_enable'] ) {
          //start//
          $general_cmds = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','cisco_rs_cmd')->pluck('bsc.cmd_id')->toArray();

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = shell {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = shell {');

          $autoCmd = explode( ';;', $service['cisco_rs_autocmd'] );
          $sp->put('a');
          for ($i=0; $i < count($autoCmd); $i++) {
            if ( empty($autoCmd[$i]) ) continue;

            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['param'][0] . "set autocmd" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] . $autoCmd[$i] . self::$html_tags['val'][1] . '"'
      			:
      			$sp->put().'set autocmd = "' . $autoCmd[$i] . '"');
          }

          if ( $service['cisco_rs_privlvl'] != -1 ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_privlvl'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set priv-lvl = '.$service['cisco_rs_privlvl']);

          if ( !empty($service['cisco_rs_def_attr']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default attribute" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default attribute = permit');
          if ( !empty($service['cisco_rs_def_cmd']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default cmd = permit');
          if ( !empty($service['cisco_rs_idletime']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set idletime" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_idletime'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set idletime = ' . $service['cisco_rs_idletime']);
          if ( !empty($service['cisco_rs_timeout']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['cisco_rs_timeout'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set timeout = ' . $service['cisco_rs_timeout']);

          // array_push($outputService, implode(',', $general_cmds));

          if ( $general_cmds ){
            $outputService = array_merge( $outputService,  self::tacCMDAttr($html, $general_cmds, 0, 3) );
          }

          if ( !empty($service['cisco_rs_nexus_roles']) ){

            $nexusRoles = explode( ' ', $service['cisco_rs_nexus_roles'] );
            $shellRoles = '';
            for ($nxr=0; $nxr < count($nexusRoles); $nxr++) {
              $comma = ($nxr == 0 ) ? '' : ',';
              $shellRoles .= $comma.'\"'.$nexusRoles[$nxr].'\"';
            }
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['param'][0] . "set shell:roles" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] . $shellRoles . self::$html_tags['val'][1] .'"'
      			:
      			$sp->put().'set shell:roles = "' . $shellRoles .'"');

          }

          if ( !empty($service['cisco_rs_debug_message']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "message debug" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . '"to permit: cmd = %c { permit /^%a$/ } to deny: cmd = %c { deny /^%a$/ }"' . self::$html_tags['val'][1]
    			:
    			$sp->put().'message debug = ' . '"to permit: cmd = %c { permit /^%a$/ } to deny: cmd = %c { deny /^%a$/ }"');

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['cisco_rs_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Cisco Router/Switch Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Cisco Router/Switch Service');
        }
        ///Cisco RS///END///
        ///H3C///START///
        if ( $service['h3c_enable'] ) {
          //start//
          $general_cmds = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','h3c_cmd')->pluck('bsc.cmd_id')->toArray();

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = shell {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = shell {');
          $sp->put('a');
          if ( $service['h3c_privlvl'] != -1 ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['h3c_privlvl'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set priv-lvl = '.$service['h3c_privlvl']);

          if ( !empty($service['h3c_def_attr']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default attribute" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default attribute = permit');
          if ( !empty($service['h3c_def_cmd']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default cmd = permit');
          if ( !empty($service['h3c_idletime']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set idletime" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['h3c_idletime'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set idletime = ' . $service['h3c_idletime']);
          if ( !empty($service['h3c_timeout']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['h3c_timeout'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set timeout = ' . $service['h3c_timeout']);

          if ( $general_cmds ){
            $outputService = array_merge( $outputService,  self::tacCMDAttr($html, $general_cmds, 0, 3) );
          }

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['h3c_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF H3C General Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF H3C General Service');
        }
        ///H3C///END///
        ///Huawei///START///
        if ( $service['huawei_enable'] ) {
          //start//
          $general_cmds = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','huawei_cmd')->pluck('bsc.cmd_id')->toArray();

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = shell {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = shell {');
          $sp->put('a');
          if ( $service['huawei_privlvl'] != -1 ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['huawei_privlvl'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set priv-lvl = '.$service['huawei_privlvl']);

          if ( !empty($service['huawei_def_attr']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default attribute" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default attribute = permit');
          if ( !empty($service['huawei_def_cmd']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default cmd = permit');
          if ( !empty($service['huawei_idletime']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set idletime" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['huawei_idletime'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set idletime = ' . $service['huawei_idletime']);
          if ( !empty($service['huawei_timeout']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['huawei_timeout'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set timeout = ' . $service['huawei_timeout']);

          if ( $general_cmds ){
            $outputService = array_merge( $outputService,  self::tacCMDAttr($html, $general_cmds, 0, 3) );
          }

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['huawei_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Huawei General Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Huawei General Service');
        }
        ///Huawei///END///
        ///Extreme Networks///START///
        if ( $service['extreme_enable'] ) {
          //start//
          $general_cmds = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','extreme_cmd')->pluck('bsc.cmd_id')->toArray();

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = shell {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'shell' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = shell {');
          $sp->put('a');
          if ( $service['extreme_privlvl'] != -1 ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['extreme_privlvl'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set priv-lvl = '.$service['extreme_privlvl']);

          if ( !empty($service['extreme_def_attr']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default attribute" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default attribute = permit');
          if ( !empty($service['extreme_def_cmd']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "default cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . 'permit' . self::$html_tags['val'][1]
    			:
    			$sp->put().'default cmd = permit');
          if ( !empty($service['extreme_idletime']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set idletime" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['extreme_idletime'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set idletime = ' . $service['extreme_idletime']);
          if ( !empty($service['extreme_timeout']) ) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set timeout" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['extreme_timeout'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set timeout = ' . $service['extreme_timeout']);

          if ( $general_cmds ){
            $outputService = array_merge( $outputService,  self::tacCMDAttr($html, $general_cmds, 0, 3) );
          }

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['extreme_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Extreme Networks Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Extreme Networks Service');
        }
        ///Extreme Networks///END///
        ///JunOS///START///
        if ( $service['junos_enable'] ) {
          //start//
          $junos_cmd_ao = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','junos_cmd_ao')->pluck('bsc.cmd_id')->toArray();
          $junos_cmd_do = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','junos_cmd_do')->pluck('bsc.cmd_id')->toArray();
          $junos_cmd_ac = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','junos_cmd_ac')->pluck('bsc.cmd_id')->toArray();
          $junos_cmd_dc = TACServices::
          leftJoin('bind_service_cmd as bsc', 'bsc.service_id','=', 'id')->
          select('bsc.cmd_id')->where('id', $id)->where('bsc.section','junos_cmd_dc')->pluck('bsc.cmd_id')->toArray();

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'junos-exec' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = junos-exec {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'junos-exec' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = junos-exec {');

          $sp->put('a');

          if ( empty($service['junos_username']) != -1 ) array_push($outputService,
          ($html) ? $sp->put().self::$html_tags['param'][0] . "set local-user-name" . self::$html_tags['param'][1] . ' = "' . self::$html_tags['val'][0] . $service['junos_username'] . self::$html_tags['val'][1] . '"'
          :
          $sp->put().'set local-user-name = "'.$service['junos_username'].'"');

          if ( $junos_cmd_ao ){

            array_push($outputService,
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set allow-commands" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $junos_cmd_ao, 1, 3)
            :
            $sp->put().'set allow-commands = ' . self::tacCMDAttr($html, $junos_cmd_ao, 1, 3));

          }
          if ( $junos_cmd_do ){

            array_push($outputService,
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set deny-commands" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $junos_cmd_do, 1, 3, ['action' => 'deny'])
            :
            $sp->put().'set deny-commands = ' . self::tacCMDAttr($html, $junos_cmd_do, 1, 3));

          }
          if ( $junos_cmd_ac ){

            array_push($outputService,
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set allow-configuration" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $junos_cmd_ac, 1, 3)
            :
            $sp->put().'set allow-configuration = ' . self::tacCMDAttr($html, $junos_cmd_ac, 1, 3));

          }
          if ( $junos_cmd_dc ){

            array_push($outputService,
            ($html) ? $sp->put().self::$html_tags['param'][0] . "set deny-configuration" . self::$html_tags['param'][1] . ' = ' . self::tacCMDAttr($html, $junos_cmd_dc, 1, 3, ['action' => 'deny'])
            :
            $sp->put().'set deny-configuration = ' . self::tacCMDAttr($html, $junos_cmd_dc, 1, 3));

          }

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['junos_manual'], $html) );

          //end//
          array_push($outputService,
          ($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF JunOS General Service'. self::$html_tags['comment'][1]
          :
          $sp->put('d').'} #END OF JunOS General Service');
        }
        ///JunOS///END///
        ///Cisco WLC///START///
        if ( $service['cisco_wlc_enable'] ) {
          //start//

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'ciscowlc' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = ciscowlc {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'ciscowlc' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = ciscowlc {');

          $sp->put('a');
          $roles = explode( ';;', $service['cisco_wlc_roles'] );
          $roles_filtered = array_values( array_filter( $roles, function($x){ return $x != '';} ) );

          for ($i=0; $i < count($roles_filtered); $i++) {
            if ($roles_filtered[$i] == '') continue;
            if (! in_array($roles_filtered[$i], array_keys(self::$ciscoWLCRoles) ) ) continue;

            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['param'][0] . "set role". ($i + 1) . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . self::$ciscoWLCRoles[$roles_filtered[$i]] . self::$html_tags['val'][1]
      			:
      			$sp->put().'set role'. ($i + 1) .' = ' . self::$ciscoWLCRoles[$roles_filtered[$i]] );
          }

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['cisco_wlc_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Cisco WLC Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Cisco WLC Service');
        }
        ///Cisco WLC///END///
        ///FortiOS///START///
        if ( $service['fortios_enable'] ) {
          //start//

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'fortigate' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = fortigate {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'fortigate' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = fortigate {');


          if (!empty($service['fortios_admin_prof'])) array_push($outputService,
    			($html) ? $sp->put('a').self::$html_tags['param'][0] . "optional admin_prof" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['fortios_admin_prof'] . self::$html_tags['val'][1]
    			:
    			$sp->put('a').'optional admin_prof = '.$service['fortios_admin_prof']);

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['fortios_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF FortiOS Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF FortiOS Service');
        }
        ///FortiOS///END///
        ///PaloALto///START///
        if ( $service['paloalto_enable'] ) {
          //start//

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'PaloAlto' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = PaloAlto {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'PaloAlto' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = PaloAlto {');

          array_push($outputService,
    			($html) ? $sp->put('a').self::$html_tags['object'][0] . "set protocol = firewall" . self::$html_tags['object'][1] . self::$html_tags['comment'][0] . " #default settings" . self::$html_tags['comment'][1]
    			:
    			$sp->put('a').'set protocol = firewall #default settings');

          if (!empty($service['paloalto_admin_role'])) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Admin-Role" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_admin_role'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Admin-Role = '.$service['paloalto_admin_role']);

          if (!empty($service['paloalto_admin_domain'])) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Admin-Access-Domain" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_admin_domain'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Admin-Access-Domain = '.$service['paloalto_admin_domain']);

          if (!empty($service['paloalto_panorama_admin_role'])) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Panorama-Admin-Role" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_panorama_admin_role'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Panorama-Admin-Role = '.$service['paloalto_panorama_admin_role']);

          if (!empty($service['paloalto_panorama_admin_domain'])) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-Panorama-Admin-Access-Domain" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_panorama_admin_domain'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-Panorama-Admin-Access-Domain = '.$service['paloalto_panorama_admin_domain']);

          if (!empty($service['paloalto_user_group'])) array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set PaloAlto-User-Group" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['paloalto_user_group'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set PaloAlto-User-Group = '.$service['paloalto_user_group']);

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['paloalto_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF PaloAlto Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF PaloAlto Service');
        }
        ///PaloAlto///END///
        ///Silver Peak///START///
        if ( $service['silverpeak_enable'] ) {
          //start//

          if ( empty($service['acl']) )
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] . ' = ' . self::$html_tags['object'][0]. 'silverpeak' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service = silverpeak {');
          else
            array_push($outputService,
      			($html) ? $sp->put().self::$html_tags['attr'][0] . "service" . self::$html_tags['attr'][1] .
              ' acl '.self::$html_tags['object'][0].$acl->name.self::$html_tags['object'][1].' = ' .
              self::$html_tags['object'][0]. 'silverpeak' . self::$html_tags['object'][1] . ' {'
      			:
      			$sp->put().'service acl '.$acl->name.' = silverpeak {');

          if ( @$service['silverpeak_role'] == 'admin') {
            array_push($outputService,
      			($html) ? $sp->put('a').self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . '7' . self::$html_tags['val'][1]
      			:
      			$sp->put('a').'set priv-lvl = 7');
          } else {
            array_push($outputService,
      			($html) ? $sp->put('a').self::$html_tags['param'][0] . "set priv-lvl" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . '0' . self::$html_tags['val'][1]
      			:
      			$sp->put('a').'set priv-lvl = 0');
          }
          array_push($outputService,
    			($html) ? $sp->put().self::$html_tags['param'][0] . "set role" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $service['silverpeak_role'] . self::$html_tags['val'][1]
    			:
    			$sp->put().'set role = '.$service['silverpeak_role']);

          $outputService = array_merge( $outputService,  self::manualConfigPrint($service['fortios_manual'], $html) );

          //end//
          array_push($outputService,
    			($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF Silver Peak Service'. self::$html_tags['comment'][1]
    			:
    			$sp->put('d').'} #END OF Silver Peak Service');
        }
        ///Silver Peak///END///
      }


      $outputService = array_merge( $outputService,  self::manualConfigPrint($service['manual'], $html) );

			array_push($outputService, ($html) ? $sp->put().self::$html_tags['comment'][0] . '###Service '.$service['name'].' END###' . self::$html_tags['comment'][1]
			:
			$sp->put().'###Service '.$service['name'].' END###');

		if ( $noPreview ) return $outputService; else return $outputService;
	}

  public static function tacCMDAttr($html = false, $id = [], $type = '', $space = 0, $params = [] )
  {
    $junosCmdTag = ( isset( $params['action'] )  AND $params['action'] == 'deny' ) ? self::$html_tags['object'] : self::$html_tags['val'];

    $query = TACCMD::select();

    $cmdList = ( is_array($id) ) ? $query->where('type', $type)->whereIn('id', $id)->get() : $query->where('id', $id)->get();
    if ( ! is_array($id) ) $type = $cmdList[0]->type;

    $onlyOne = ( !is_array($id) ) ; //VERY IMPORTANT FOR PREVIEW!!!//
    $sp = new spacer($space);

    $outputCMDAttr = array();

    if ( $type == '1'){
      $checkId = [];
      for ($cl=0; $cl < count($cmdList); $cl++) {
        if ( in_array($cmdList[$cl]->id, $checkId) ) continue;
        $checkId[]=$cmdList[$cl]->id;
        $outputCMDAttr = array_merge( $outputCMDAttr, explode( ',', $cmdList[$cl]->junos ) );
      }

      $cmdAttrList = ( $html ) ? '"('.implode( '|', preg_filter('/$/', $junosCmdTag[1], preg_filter('/^/', $junosCmdTag[0], $outputCMDAttr ) ) ) .')"'
      :
      '"('.implode( '|', $outputCMDAttr ) .')"';
      //var_dump($cmdAttrList);die;
      if (is_array($id)) return $cmdAttrList; else return [$cmdAttrList];
    }

    for ($cl=0; $cl < count($cmdList); $cl++) {
      if ( empty($cmdList[$cl]) OR empty($cmdList[$cl]->cmd) ) continue;
      $args = TACCMD::leftJoin('tac_cmd_arg', 'tac_cmd_id', '=', 'id')->select()->where('id', $cmdList[$cl]->id)->get();
      $cmdId = ($onlyOne) ? $cmdList[$cl]->id : 0;
      ///EMPTY ARRAY///
      $outputCMDAttr = ($onlyOne) ? array() : $outputCMDAttr;
      ///Service TITLE///
      // $outputCMDAttr[0] = array('title_flag' => 0, 'name' =>"");
      array_push($outputCMDAttr, ($html) ? $sp->put().self::$html_tags['comment'][0] . '###CMD Attr '.$cmdList[$cl]->name.' START###' . self::$html_tags['comment'][1]
      :
      $sp->put().'###CMD Attr '.$cmdList[$cl]->name.' START###');
      if ( $cmdList[$cl]->type == 1 ){
        array_push($outputCMDAttr, ($html) ? $sp->put().self::$html_tags['comment'][0] . '### JunOS Attr ###' . self::$html_tags['comment'][1]
        :
        $sp->put().'### JunOS Attr ###');

        $cmdAttrList = '"('.implode( '|', preg_filter('/$/', self::$html_tags['val'][1], preg_filter('/^/', self::$html_tags['val'][0], explode( ';;', $cmdList[$cl]->cmd_attr ) ) ) ) .')"';

        array_push($outputCMDAttr, ($html) ? $sp->put(). $cmdAttrList
        :
        $sp->put().$cmdAttrList);

        return $outputCMDAttr;
      }
      array_push($outputCMDAttr,
      ($html) ? $sp->put().self::$html_tags['param'][0] . "cmd" . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] . $cmdList[$cl]->cmd . self::$html_tags['val'][1]. ' {'
      :
      $sp->put().'cmd = ' . $cmdList[$cl]->cmd . ' {');
      $sp->put('a');

      for ($al=0; $al < count($args); $al++) {
        if ( empty($args[$al]) OR empty($args[$al]->arg) ) continue;

        array_push($outputCMDAttr,
        ($html) ?  $sp->put(). ( ($args[$al]->action) ? 'permit ' : 'deny ' ) .  $args[$al]->arg
        :
        $sp->put(). ( ($args[$al]->action) ? 'permit ' : 'deny ' ).$args[$al]->arg);
      }

      $outputCMDAttr = array_merge( $outputCMDAttr,  self::manualConfigPrint($cmdList[$cl]->manual, $html) );

      if ( !empty($cmdList[$cl]->cmd_permit_end) ) array_push($outputCMDAttr,
      ($html) ? $sp->put().'permit .*'.self::$html_tags['comment'][0].' # default permit any'.self::$html_tags['comment'][1]
      :
      $sp->put().'permit .* # default permit any');
      if ( !empty($cmdList[$cl]->message_permit) ) array_push($outputCMDAttr,
      ($html) ? $sp->put().'message permit = "'.$cmdList[$cl]->message_permit.'"'
      :
      $sp->put().'message permit = "'.$cmdList[$cl]->message_permit.'"');
      if ( !empty($cmdList[$cl]->message_deny) ) array_push($outputCMDAttr,
      ($html) ? $sp->put().'message deny = "'.$cmdList[$cl]->message_deny.'"'
      :
      $sp->put().'message deny = "'.$cmdList[$cl]->message_deny.'"');

      array_push($outputCMDAttr,
      ($html) ? $sp->put('d').'} ' . self::$html_tags['comment'][0] . '#END OF CMD Attr ' . $cmdList[$cl]->name . self::$html_tags['comment'][1]
      :
      $sp->put('d').'} #END OF CMD Attr ' . $cmdList[$cl]->name );
    }

    return $outputCMDAttr;
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

  public static function messagePrint($data = '', $attr = '', $html = false, $space = '')
  {
    $message = explode(PHP_EOL, $data);
    $output = [];
    for ($i=0; $i < count($message); $i++) {
      if ( count($message) == 1 ){
        array_push($output,
        ($html) ? $space . self::$html_tags['param'][0] . $attr . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$message[$i].'"'. self::$html_tags['val'][1]
        :
        $space . $attr.' = "'.$message[$i].'"');
        continue;
      }
      if ( $i == 0 ){
        array_push($output,
        ($html) ? $space . self::$html_tags['param'][0] . $attr . self::$html_tags['param'][1] . ' = ' . self::$html_tags['val'][0] .'"'.$message[$i]. self::$html_tags['val'][1]
        :
        $space . $attr.' = "'.$message[$i]);
        continue;
      }
      if (($i+1) == count($message)){
        array_push($output,
        ($html) ? self::$html_tags['val'][0] .$message[$i].'"'. self::$html_tags['val'][1]
        :
        $message[$i].'"');
        continue;
      }
      array_push($output,
      ($html) ? self::$html_tags['val'][0] .$message[$i]. self::$html_tags['val'][1]
      :
      $message[$i]);
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
