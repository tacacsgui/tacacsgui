<?php

namespace tgui\Controllers\APIChecker;


class APIDatabase
{
  public $databases = ['default', 'logging'];

  public $tablesArr = array(

  	'api_users' =>
  	[
  		'username' => ['string',''],
  		'email' => ['string', ''],
  		'password' => ['string',''],
  		'firstname' => ['string', ''],
  		'surname' => ['string', ''],
  		'group' => ['foreign-null', ['references'=>'id', 'on'=>'api_user_groups', 'onDelete'=>'restrict'] ],
  		'position' => ['string', ''],
  		'cmd_type' => ['integer', '0'],
  		'bad_authentication_notice' => ['integer', '0'],
  		'bad_authorization_notice' => ['integer', '0'],
  		'changePasswd' => ['integer', '1'],
  	],
  	'api_user_groups' =>
  	[
  		'name' => ['string',''],
  		'rights' => ['integer', '0'],
  		'default_flag' => ['integer', '0'],
      'bad_authentication_notice' => ['integer', '0'],
  		'bad_authorization_notice' => ['integer', '0'],
  	],
  	'api_notification' =>
  	[
  		'bad_authentication_enable' => ['integer', '0'],
  		'bad_authentication_count' => ['integer', '0'],
  		'bad_authentication_interval' => ['integer', '0'],
  		'bad_authentication_email_list' => ['text', '_'],
  		'bad_authorization_enable' => ['integer', '0'],
  		'bad_authorization_count' => ['integer', '0'],
  		'bad_authorization_interval' => ['integer', '0'],
  		'bad_authorization_email_list' => ['text', '_'],
  	],
  	'api_settings' =>
  	[
  		'timezone' => ['string', '348'],
  		'update_url' => ['string', 'https://tacacsgui.com/updates/'],
  		'update_activated' => ['integer', '0'],
  		'update_signin' => ['integer', '1'],
  		'ntp_list' => ['string', ''],
  		'api_logging_max_entries' => ['integer', 500],
  		'update_key' => ['string', ''],
  	],
  	'api_logging_miss_rules' =>
  	[
  		'name' => ['string', ''],
  		'type' => ['integer', '0'],	# 0 tacacs 1 radius
  		'tacacs_type' => ['integer', '0'],	# 0 authe 1 autho 2 acc
  		'username' => ['string', ''],
      'nac_address' => ['foreign-null', ['references'=>'id', 'on'=>'obj_addresses', 'onDelete'=>'restrict'] ],
      'nas_address' => ['foreign-null', ['references'=>'id', 'on'=>'obj_addresses', 'onDelete'=>'restrict'] ],
      'description' => ['text', '_' ],
  	],
  	'api_password_policy' =>
  	[
  		'api_pw_length' => ['integer', '8'],
  		'api_pw_uppercase' => ['integer', '0'],
  		'api_pw_lowercase' => ['integer', '0'],
  		'api_pw_numbers' => ['integer', '0'],
  		'api_pw_special' => ['integer', '0'],
  		'api_pw_same' => ['integer', '0'],
  		'tac_pw_length' => ['integer', '8'],
  		'tac_pw_uppercase' => ['integer', '0'],
  		'tac_pw_lowercase' => ['integer', '0'],
  		'tac_pw_numbers' => ['integer', '0'],
  		'tac_pw_special' => ['integer', '0'],
  		'tac_pw_same' => ['integer', '0'],
  	],
  	'api_smtp' =>
  	[
  		'smtp_servers' => ['string', ''],
  		'smtp_auth' => ['integer', '0'],
  		'smtp_autotls' => ['integer', '0'],
  		'smtp_from' => ['string', ''],
  		'smtp_username' => ['string', ''],
  		'smtp_password' => ['string', ''],
  		'smtp_port' => ['integer', '25'],
  		'smtp_secure' => ['string', ''],
  	],
  	'api_backup' =>
  	[
  		'tcfgSet' => ['integer', '1'],
  		'apicfgSet' => ['integer', '1'],
  	],
  	'obj_addresses' =>
  	[
  		'type' => ['integer', '0'], //0-ipv4; 1-ipv6; 2-fqdn
  		'name' => ['string', ''],
  		'address' => ['string', ''],
  		// 'addressv6' => ['string', ''],
  		// 'prefix' => ['integer', '32'],
  		// 'prefixv6' => ['integer', '128'],
  	],
  	'tac_global_settings' =>
  	[
  		'port' => ['integer', 49],
  		'accounting' => ['string', 'accounting_log'],
  		'authorization' => ['string', 'authorization_log'],
  		'authentication' => ['string', 'authentication_log'],
  		'syslog_ip' => ['string', ''],
  		'syslog_port' => ['integer', 514],
  		'connection_timeout' => ['integer', 600],
  		'context_timeout' => ['integer', 3600],
  		'separation_tag' => ['string', '*'],
  		'skip_conflicting_groups' => ['integer', 1],
  		'skip_missing_groups' => ['integer', 1],
  		'max_attempts' => ['integer', 1],
  		'backoff' => ['integer', 1],
  		'manual' => ['text', '_'],
  		'changeFlag' => ['integer', '0'],
  		'revisionNum' => ['integer', '0'],
  	],
  	'tac_users' =>
  	[
  		'username' => ['string', ''],
  		'email' => ['string', ''],
  		'login_date' => ['timestamp', '_'],
  		'login' => ['string', ''],
  		'login_flag' => ['integer', '0'],
  		'login_change' => ['integer', '1'],
  		'enable' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
  		'enable_change' => ['integer', '1'],
  		// 'group' => ['string', ''],
  		'disabled' => ['integer', '0'],
  		'message' => ['text', '_'],
  		// 'manual_beginning' => ['text', '_'],
  		'manual' => ['text', '_'],
  		'acl' => ['foreign-null', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'restrict'] ],
  		// 'service' => ['foreign-null', ['references'=>'id', 'on'=>'tac_services', 'onDelete'=>'restrict'] ],
      'device_list_action' => ['integer', '0'],
  		// 'device_list' => ['string',''],
  		// 'device_group_list' => ['string',''],
  		'pap' => ['string', '_'],
  		'pap_flag' => ['integer', '0'],
  		'pap_clone' => ['integer', '0'],
  		'chap' => ['string', '_'],
  		'ms_chap' => ['string', '_'],
  		//'priv-lvl' => ['integer', '15'], #deprecated
  		// 'mavis_otp_enabled' => ['integer', '0'],
  		'mavis_otp_secret' => ['text', '_'],
  		// 'mavis_otp_period' => ['integer', '30'],
  		// 'mavis_otp_digits' => ['integer', '6'],
  		// 'mavis_otp_digest' => ['string', 'sha1'],
  		// 'mavis_sms_enabled' => ['integer', '0'],
  		'mavis_sms_number' => ['string', ''],
  		'valid_from' => ['timestamp', '_'],
  		'valid_until' => ['timestamp', '_'],
  		//'client_ip' => ['string', '_'], #deprecated
  		//'server_ip' => ['string', '_'], #deprecated
  		'default_service' => ['integer', '0'],
  	],

    'tac_bind_usrGrp' =>
    [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'user_id' => ['foreign', ['references'=>'id', 'on'=>'tac_users', 'onDelete'=>'cascade'] ],
      'group_id' => ['foreign', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'cascade'] ],
      'order' => ['integer', '0'],
    ],
    'tac_bind_dev' =>
    [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'user_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_users', 'onDelete'=>'cascade'] ],
      'group_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'cascade'] ],
      'device_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_devices', 'onDelete'=>'cascade'] ],
    ],
    'tac_bind_devGrp' =>
    [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'user_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_users', 'onDelete'=>'cascade'] ],
      'group_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'cascade'] ],
      'devGroup_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_device_groups', 'onDelete'=>'cascade'] ],
    ],

  	'tac_devices' =>
  	[
  		'name' => ['string', ''],
  		//'ipaddr' => ['string', ''],
  		//'prefix' => ['integer', '32'],
      'address' => ['foreign-null', ['references'=>'id', 'on'=>'obj_addresses', 'onDelete'=>'restrict'] ],
  		'enable' => ['string', ''],
  		'key' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
  		'group' => ['foreign-null', ['references'=>'id', 'on'=>'tac_device_groups', 'onDelete'=>'restrict'] ],
  		'disabled' => ['integer', '0'],
  		'acl' => ['foreign-null', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'restrict'] ],
  		'user_group' => ['foreign-null', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'restrict'] ],
  		'connection_timeout' => ['integer', '_'],
  		'vendor' => ['string', ''],
  		'model' => ['string', ''],
  		'type' => ['string', ''],
  		'sn' => ['string', ''],
      'comment' => ['text', '_'],
  		'banner_welcome' => ['text', '_'],
  		'banner_failed' => ['text', '_'],
  		'banner_motd' => ['text', '_'],
  		'manual' => ['text', '_'],
  	],
  	'tac_user_groups' =>
  	[
  		'name' => ['string',''],
  		'enable' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
  		'message' => ['text', '_'],
  		'default_flag' => ['integer', '0'],
  		'priority' => ['integer', '0'],
  		'valid_from' => ['timestamp', '_'],
  		'valid_until' => ['timestamp', '_'],
      'acl' => ['foreign-null', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'restrict'] ],
      'acl_match' => ['foreign-null', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'restrict'] ],
      // 'service' => ['foreign-null', ['references'=>'id', 'on'=>'tac_services', 'onDelete'=>'restrict'] ],
  		// 'ldap_groups' => ['text', '_'],
  		//'priv-lvl' => ['integer', -1], #deprecated
  		'default_service' => ['integer', '0'],
  		'device_list_action' => ['integer', '0'],
  		// 'device_list' => ['string',''],
  		// 'device_group_list' => ['string',''],
      //'client_ip' => ['string', '_'], #deprecated
  		//'server_ip' => ['string', '_'], #deprecated
  		// 'manual_beginning' => ['text', '_'],
  		'manual' => ['text', '_'],
  	],
    'ldap_bind' => [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'ldap_id' => ['foreign-null', ['references'=>'id', 'on'=>'ldap_groups', 'onDelete'=>'restrict'] ],
      'tac_grp_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'cascade'] ],
      'api_grp_id' => ['foreign-null', ['references'=>'id', 'on'=>'api_user_groups', 'onDelete'=>'cascade'] ],
    ],

    'ldap_groups' => [
      'cn' => ['string',''],
      'dn' => ['string',''],
    ],
  	'tac_device_groups' =>
  	[
  		'name' => ['string',''],
  		'enable' => ['string', ''],
  		'key' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
      'acl' => ['foreign-null', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'restrict'] ],
      'user_group' => ['foreign-null', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'restrict'] ],
      'connection_timeout' => ['integer', '_'],
  		'banner_welcome' => ['text', '_'],
  		'banner_failed' => ['text', '_'],
  		'banner_motd' => ['text', '_'],
  		'manual' => ['text', '_'],
  		'default_flag' => ['integer', '0']
  	],
  	'tac_acl' =>
  	[
  		'name' => ['string',''],
  		// 'line_number' => ['integer', '0'],
  		// 'action' => ['string', ''],
  		// 'nac' => ['string', ''],
  		// 'nas' => ['string', ''],
  		// 'timerange' => ['string', '']
  	],
  	'tac_acl_ace' =>
  	[
      'unsetId' => true,
      'unsetTimestamp' => true,
      'acl_id' => ['foreign', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'cascade'] ],
      'action' => ['integer', '1'],
      'order' => ['integer', '0'],
      'nac' => ['foreign-null', ['references'=>'id', 'on'=>'obj_addresses', 'onDelete'=>'restrict'] ],
  		'nas' => ['foreign-null', ['references'=>'id', 'on'=>'obj_addresses', 'onDelete'=>'restrict'] ],
  	],

    'tac_bind_service' => [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'order' => ['integer', '0' ],
      'service_id' => ['foreign', ['references'=>'id', 'on'=>'tac_services', 'onDelete'=>'restrict'] ],
      'tac_usr_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_users', 'onDelete'=>'cascade'] ],
      'tac_grp_id' => ['foreign-null', ['references'=>'id', 'on'=>'tac_user_groups', 'onDelete'=>'cascade'] ],
    ],

  	'tac_services' =>
  	[
  		'name' => ['string',''],
  		'acl' => ['foreign-null', ['references'=>'id', 'on'=>'tac_acl', 'onDelete'=>'cascade'] ],
  		// 'priv-lvl' => ['integer', -1],
  		// 'default_cmd' => ['integer', '0'],
      //Patterns List//
        //Cisco General//
        'cisco_rs_enable' => ['integer', '0'],
        'cisco_rs_privlvl' => ['integer', '15'],
        'cisco_rs_def_cmd' => ['integer', '1'],
        'cisco_rs_def_attr' => ['integer', '1'],
        'cisco_rs_idletime' => ['integer', '_'],
        'cisco_rs_timeout' => ['integer', '_'],
        'cisco_rs_debug_message' => ['integer', '0'],
        // 'cisco_rs_cmd' => ['string', ''],
        'cisco_rs_autocmd' => ['string', ''],
        'cisco_rs_nexus_roles' => ['string', ''],
        'cisco_rs_manual' => ['text', '_'],
        //ASR//
        //'cisco_asr_enable' => ['integer', '0'],
        //Cisco WLC//
        'cisco_wlc_enable' => ['integer', '0'],
        'cisco_wlc_roles' => ['string', ''],
        'cisco_wlc_manual' => ['text', '_'],
        //H3C General//
        'h3c_enable' => ['integer', '0'],
        'h3c_privlvl' => ['integer', '15'],
        'h3c_def_cmd' => ['integer', '1'],
        'h3c_def_attr' => ['integer', '1'],
        'h3c_idletime' => ['integer', '_'],
        'h3c_timeout' => ['integer', '_'],
        'h3c_manual' => ['text', '_'],
        //HUAWEI General//
        'huawei_enable' => ['integer', '0'],
        'huawei_privlvl' => ['integer', '15'],
        'huawei_def_cmd' => ['integer', '1'],
        'huawei_def_attr' => ['integer', '1'],
        'huawei_idletime' => ['integer', '_'],
        'huawei_timeout' => ['integer', '_'],
        'huawei_manual' => ['text', '_'],
        //Extreme Networks General//
        'extreme_enable' => ['integer', '0'],
        'extreme_privlvl' => ['integer', '15'],
        'extreme_def_cmd' => ['integer', '1'],
        'extreme_def_attr' => ['integer', '1'],
        'extreme_idletime' => ['integer', '_'],
        'extreme_timeout' => ['integer', '_'],
        'extreme_manual' => ['text', '_'],
        //FortiOS//
        'fortios_enable' => ['integer', '0'],
        'fortios_admin_prof' => ['string', ''],
        'fortios_manual' => ['text', '_'],
        //JunOS//
        'junos_enable' => ['integer', '0'],
        'junos_username' => ['string', ''],
        // 'junos_cmd_ao' => ['string', ''],
        // 'junos_cmd_do' => ['string', ''],
        // 'junos_cmd_ac' => ['string', ''],
        // 'junos_cmd_dc' => ['string', ''],
        'junos_manual' => ['text', '_'],
        //PaloAlto//
        'paloalto_enable' => ['integer', '0'],
        'paloalto_admin_role' => ['string', ''],
        'paloalto_admin_domain' => ['string', ''],
        'paloalto_panorama_admin_role' => ['string', ''],
        'paloalto_panorama_admin_domain' => ['string', ''],
        'paloalto_user_group' => ['string', ''],
        'paloalto_manual' => ['text', '_'],
        //Silver Peak//
        'silverpeak_enable' => ['integer', '0'],
        'silverpeak_role' => ['string', 'admin'],
        'silverpeak_manual' => ['text', '_'],
      //END Pattern List
  		'manual' => ['text', '_'],
  		'manual_conf_only' => ['integer', '0'],
  	],
    'bind_service_cmd' => [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'cmd_id' => ['foreign', ['references'=>'id', 'on'=>'tac_cmd', 'onDelete'=>'cascade'] ],
      'service_id' => ['foreign', ['references'=>'id', 'on'=>'tac_services', 'onDelete'=>'cascade'] ],
      'section' => ['string','_'],
      'order' => ['integer','0'],
    ],
  	'tac_cmd' =>
  	[
  		'name' => ['string',''],
      'type' => ['integer','0'],
      'cmd' => ['string',''],
      'junos' => ['text','_'],
      'cmd_permit_end' => ['integer','0'],
      'manual' => ['text','_'],
      'message_deny' => ['string',''],
      'message_permit' => ['string',''],
  	],
  	'tac_cmd_arg' =>
  	[
      'unsetId' => true,
      'unsetTimestamp' => true,
      'tac_cmd_id' => ['foreign', ['references'=>'id', 'on'=>'tac_cmd', 'onDelete'=>'cascade'] ],
      'arg' => ['string','_'],
      'order' => ['integer','0'],
      'action' => ['integer','0'],
  	],
  	'mavis_ldap' =>
  	[
  		'enabled' => ['integer', '0'],
  		'type' => ['string', 'microsoft'],
  		'group_selection' => ['integer', '1'],
  		'scope' => ['string', 'sub'],
  		'hosts' => ['string', ''],
  		'port' => ['integer', '389'],
  		'base' => ['string', ''],
  		'filter' => ['string', 'samAccountName'],
  		'user' => ['string', ''],
  		'password' => ['string', ''],
  		//'password_hide' => ['integer', '1'],
  		//'group_prefix' => ['string', ''],
  		//'group_prefix_flag' => ['integer', '0'],
  		//'memberOf' => ['integer', '0'],
  		//'fallthrough' => ['integer', '0'],
  		//'cache_conn' => ['integer', '0'],
  		'tls' => ['integer', '0'],
  		'ssl' => ['integer', '0'],
  		'enable_login' => ['integer', '1'],
  		'pap_login' => ['integer', '1'],
  		'message_flag' => ['integer', '0'],
  		//'path' => ['string', '/usr/local/lib/mavis/mavis_tacplus_ldap.pl'],
  	],
  	'mavis_otp' =>
  	[
  		'enabled' => ['integer', '0'],
  		'period' => ['integer', '30'],
  		'digits' => ['integer', '6'],
  		'digest' => ['string', 'sha1'],
  	],
  	'mavis_sms' =>
  	[
  		'enabled' => ['integer', '0'],
  		'ipaddr' => ['string', ''],
  		'port' => ['integer', '2775'],
  		'login' => ['string', ''],
  		'pass' => ['string', ''],
  		'srcname' => ['string', ''],
  	],
  	'mavis_local' =>
  	[
  		'enabled' => ['integer', '1'],
  		'change_passwd_cli' => ['integer', '1'],
  		'change_passwd_gui' => ['integer', '1'],
  	],
  	'mavis_otp_base' =>
  	[
  		'otp' => ['string', ''],
  		'username' => ['string', ''],
  		'type' => ['string', ''],
  		'destination' => ['string', ''],
  		'status' => ['string', ''],
  	],

  	'confM_models' =>
  	[
  		'name' => ['string', ''],
  		'prompt' => ['string', '']
  	],
  	'confM_devices' =>
  	[
  		'name' => ['string', ''],
  		// 'ip' => ['string', ''],
  		'address' => ['foreign-null', ['references'=>'id', 'on'=>'obj_addresses', 'onDelete'=>'restrict'] ],
  		'prompt' => ['string', ''],
  		'protocol' => ['string', 'ssh'],
  		'port' => ['integer', '22'],
      'tac_device' => ['foreign-null', ['references'=>'id', 'on'=>'tac_devices', 'onDelete'=>'cascade'] ],
      'credential' => ['foreign-null', ['references'=>'id', 'on'=>'confM_credentials', 'onDelete'=>'cascade'] ]
  	],
  	'confM_queries' =>
  	[
  		'name' => ['string', ''],
  		'disabled' => ['integer', '0'],
  		'f_group' => ['string', ''],
  		'path' => ['string', '/'],
  		'omit_lines' => ['string', ''],
      'credential' => ['foreign-null', ['references'=>'id', 'on'=>'confM_credentials', 'onDelete'=>'cascade'] ],
      'model' => ['foreign-null', ['references'=>'id', 'on'=>'confM_models', 'onDelete'=>'cascade'] ],
  	],
  	'confM_credentials' =>
  	[
  		'name' => ['string', ''],
  		'username' => ['string', '_'],
  		'password' => ['string', '_'],
  	],
    // 'confM_bind_query_model' =>
    // [
    //   'unsetId' => true,
    //   'unsetTimestamp' => true,
    //   'query_id' => ['foreign', ['references'=>'id', 'on'=>'confM_queries', 'onDelete'=>'cascade'] ],
    //   'model_id' => ['foreign', ['references'=>'id', 'on'=>'confM_models',  'onDelete'=>'cascade'] ],
    // ],
    'confM_bind_query_devices' =>
    [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'query_id' => ['foreign', ['references'=>'id', 'on'=>'confM_queries', 'onDelete'=>'cascade'] ],
      'device_id' => ['foreign', ['references'=>'id', 'on'=>'confM_devices', 'onDelete'=>'cascade'] ],
    ],
    // 'confM_bind_query_creden' =>
    // [
    //   'unsetId' => true,
    //   'unsetTimestamp' => true,
    //   'query_id' => ['foreign', ['references'=>'id', 'on'=>'confM_queries', 'onDelete'=>'cascade'] ],
    //   'creden_id' => ['foreign', ['references'=>'id', 'on'=>'confM_credentials', 'onDelete'=>'cascade'] ],
    // ],
    // 'confM_bind_devices_creden' =>
    // [
    //   'unsetId' => true,
    //   'unsetTimestamp' => true,
    //   'creden_id' => ['foreign', ['references'=>'id', 'on'=>'confM_credentials', 'onDelete'=>'cascade'] ],
    //   'device_id' => ['foreign', ['references'=>'id', 'on'=>'confM_devices', 'onDelete'=>'cascade'] ],
    // ],
    'confM_bind_model_expect' =>
    [
      'unsetId' => true,
      'unsetTimestamp' => true,
      'model_id' => ['foreign', ['references'=>'id', 'on'=>'confM_models', 'onDelete'=>'cascade'] ],
      'hidden' => ['integer', '0'],
      'order' => ['integer', '0'],
  		'write' => ['integer', '0'],
  		'expect' => ['string', '_'],
  		'send' => ['string', ''],
    ],
    // 'confM_bind_cmdev_tacdev' =>
    // [
    //   'unsetId' => true,
    //   'unsetTimestamp' => true,
    //   'tac_dev' => ['foreign', ['references'=>'id', 'on'=>'tac_devices', 'onDelete'=>'cascade'] ],
    //   'cm_dev' => ['foreign', ['references'=>'id', 'on'=>'confM_devices',  'onDelete'=>'cascade'] ],
    // ],

  );

  	public $tablesArr_log = array(
  		'api_logging' =>
  		[
  			'username' => ['string',''],
  			'uid' => ['string',''],
  			'user_ip' => ['string',''],
  			'obj_name' => ['string', ''],
  			'obj_id' => ['string', ''],
  			'action' => ['string', ''],
  			'section' => ['string', ''],
  			'message' => ['text', '_'],
  		],
  		'tac_log_accounting' =>
  		[
  			'server' => ['string', '_'],
  			'date' => ['timestamp', '_'],
  			'nas' => ['string', '_'],
  			'username' => ['string', '_'],
  			'line' => ['string', '_'],
  			'nac' => ['string', '_'],
  			'action' => ['string', '_'],
  			'task_id' => ['string', '_'],
  			'timezone' => ['string', '_'],
  			'service' => ['string', '_'],
  			'priv-lvl' => ['string', '_'],
  			'cmd' => ['string', '_'],
  			'disc-cause' => ['string', '_'],
  			'disc-cause-ext' => ['string', '_'],
  			'pre-session-time' => ['string', '_'],
  			'elapsed_time' => ['string', '_'],
  			'stop_time' => ['string', '_'],
  			'nas-rx-speed' => ['string', '_'],
  			'nas-tx-speed' => ['string', '_'],
  			'unknown' => ['string', '_'],
  		],
  		'tac_log_authentication' =>
  		[
  			'server' => ['string', '_'],
  			'date' => ['timestamp', '_'],
  			'nas' => ['string', '_'],
  			'username' => ['string', '_'],
  			'line' => ['string', '_'],
  			'nac' => ['string', '_'],
  			'action' => ['string', '_'],
  			'unknown' => ['string', '_'],
  		],
  		'tac_log_authorization' =>
  		[
  			'server' => ['string', '_'],
  			'date' => ['timestamp', '_'],
  			'nas' => ['string', '_'],
  			'username' => ['string', '_'],
  			'line' => ['string', '_'],
  			'nac' => ['string', '_'],
  			'action' => ['string', '_'],
  			'cmd' => ['string', '_'],
  		],
  		'post_log' =>
  		[
  			'server' => ['string', '_'],
  			'date' => ['timestamp', '_'],
  			'type' => ['string', '_'],
  			'username' => ['string', '_'],
  			'user_ipaddr' => ['string', '_'],
  			'device_ipaddr' => ['string', '_'],
  			'receivers' => ['string', '_'],
  			'status' => ['string', '_'],
  		],
  		'post_buffer' =>
  		[
  			'server' => ['string', '_'],
  			'date' => ['timestamp', '_'],
  			'type' => ['string', '_'],
  			'username' => ['string', '_'],
  			'user_ipaddr' => ['string', '_'],
  			'device_ipaddr' => ['string', '_'],
  			'count' => ['string', '_'],
  		],
      'cm_log' =>
    	[
    		'date' => ['timestamp', ''],
    		'timestamp' => ['integer', '0'],
    		'device_id' => ['integer', '0'],
    		'device_name' => ['string', '_'],
    		'query_id' => ['integer', '0'],
    		'query_name' => ['string', '_'],
    		'ip' => ['string', '_'],
    		'protocol' => ['string', '_'],
    		'port' => ['integer', '_'],
    		'uname_type' => ['string', '_'],
    		'uname' => ['string', '_'],
    		'path' => ['string', '_'],
    		// 'group' => ['string', '_'],
    		'status' => ['string', '_'],
    		'message' => ['text', '_'],
    	],
  	);
}
