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
  		'group' => ['integer', '0'],
  		'position' => ['string', ''],
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
  	'tac_global_settings' =>
  	[
  		'port' => ['integer', 49],
  		'accounting' => ['string', 'accounting_log'],
  		'authorization' => ['string', 'authorization_log'],
  		'authentication' => ['string', 'authentication_log'],
  		'connection_timeout' => ['integer', 600],
  		'context_timeout' => ['integer', 3600],
  		'max_attempts' => ['integer', 1],
  		'backoff' => ['integer', 1],
  		'manual' => ['text', '_'],
  		'changeFlag' => ['integer', '0'],
  		'revisionNum' => ['integer', '0'],
  	],
  	'tac_users' =>
  	[
  		'username' => ['string', ''],
  		'login' => ['string', ''],
  		'login_flag' => ['integer', '0'],
  		'login_change' => ['integer', '1'],
  		'enable' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
  		'enable_change' => ['integer', '1'],
  		'group' => ['integer', '0'],
  		'disabled' => ['integer', '0'],
  		'message' => ['text', '_'],
  		'manual_beginning' => ['text', '_'],
  		'manual' => ['text', '_'],
  		'acl' => ['integer', '0'],
  		'service' => ['integer', '0'],
  		'pap' => ['string', '_'],
  		'pap_flag' => ['integer', '0'],
  		'pap_clone' => ['integer', '0'],
  		'chap' => ['string', '_'],
  		'ms-chap' => ['string', '_'],
  		'priv-lvl' => ['integer', '15'],
  		'mavis_otp_enabled' => ['integer', '0'],
  		'mavis_otp_secret' => ['text', '_'],
  		'mavis_otp_period' => ['integer', '30'],
  		'mavis_otp_digits' => ['integer', '6'],
  		'mavis_otp_digest' => ['string', 'sha1'],
  		'mavis_sms_enabled' => ['integer', '0'],
  		'mavis_sms_number' => ['string', ''],
  		'valid_from' => ['timestamp', '_'],
  		'valid_until' => ['timestamp', '_'],
  		'client_ip' => ['string', '_'],
  		'server_ip' => ['string', '_'],
  		'default_service' => ['integer', '0'],
  	],
  	'tac_devices' =>
  	[
  		'name' => ['string', ''],
  		'ipaddr' => ['string', ''],
  		'prefix' => ['integer', '32'],
  		'enable' => ['string', ''],
  		'key' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
  		'group' => ['integer', '0'],
  		'disabled' => ['integer', '0'],
  		'acl' => ['integer', '0'],
  		'user_group' => ['integer', '0'],
  		'connection_timeout' => ['integer', '0'],
  		'vendor' => ['string', ''],
  		'model' => ['string', ''],
  		'type' => ['string', ''],
  		'sn' => ['string', ''],
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
  		'valid_from' => ['timestamp', '_'],
  		'valid_until' => ['timestamp', '_'],
  		'acl' => ['integer', '0'],
  		'service' => ['integer', '0'],
  		'priv-lvl' => ['integer', -1],
  		'default_service' => ['integer', '0'],
      'client_ip' => ['string', '_'],
  		'server_ip' => ['string', '_'],
  		'manual_beginning' => ['text', '_'],
  		'manual' => ['text', '_'],
  	],
  	'tac_device_groups' =>
  	[
  		'name' => ['string',''],
  		'enable' => ['string', ''],
  		'key' => ['string', ''],
  		'enable_flag' => ['integer', '0'],
      'acl' => ['integer', '0'],
      'user_group' => ['integer', '0'],
      'connection_timeout' => ['integer', '0'],
  		'banner_welcome' => ['text', '_'],
  		'banner_failed' => ['text', '_'],
  		'banner_motd' => ['text', '_'],
  		'manual' => ['text', '_'],
  		'default_flag' => ['integer', '0']
  	],
  	'tac_acl' =>
  	[
  		'name' => ['string',''],
  		'line_number' => ['integer', '0'],
  		'action' => ['string', ''],
  		'nac' => ['string', ''],
  		'nas' => ['string', ''],
  		'timerange' => ['string', '']
  	],
  	'tac_services' =>
  	[
  		'name' => ['string',''],
  		'priv-lvl' => ['integer', -1],
  		'default_cmd' => ['integer', '0'],
      //Patterns List//
        //Cisco RS//
        'cisco_rs_enable' => ['integer', '0'],
        'cisco_rs_privlvl' => ['integer', '15'],
        'cisco_rs_def_cmd' => ['integer', '1'],
        'cisco_rs_def_attr' => ['integer', '1'],
        'cisco_rs_idletime' => ['integer', '_'],
        'cisco_rs_timeout' => ['integer', '_'],
        'cisco_rs_debug_message' => ['integer', '0'],
        'cisco_rs_cmd' => ['string', ''],
        'cisco_rs_autocmd' => ['string', ''],
        'cisco_rs_manual' => ['text', '_'],
        //Cisco WLC//
        'cisco_wlc_enable' => ['integer', '0'],
        'cisco_wlc_roles' => ['string', ''],
        'cisco_wlc_manual' => ['text', '_'],
        //FortiOS//
        'fortios_enable' => ['integer', '0'],
        'fortios_admin_prof' => ['string', ''],
        'fortios_manual' => ['text', '_'],
        //PaloAlto//
        'paloalto_enable' => ['integer', '0'],
        'paloalto_admin_role' => ['string', ''],
        'paloalto_admin_domain' => ['string', ''],
        'paloalto_panorama_admin_role' => ['string', ''],
        'paloalto_panorama_admin_domain' => ['string', ''],
        'paloalto_user_group' => ['string', ''],
        'paloalto_manual' => ['text', '_'],
      //END Pattern List
  		'manual' => ['text', '_'],
  		'manual_conf_only' => ['integer', '0'],
  	],
  	'tac_cmd' =>
  	[
  		'name' => ['string',''],
      'type' => ['string',''],
      'cmd' => ['string',''],
      'cmd_attr' => ['text','_'],
      'cmd_permit_end' => ['integer',0],
      'manual' => ['text','_'],
      'message_deny' => ['string',''],
      'message_permit' => ['string',''],
  	],
  	'mavis_ldap' =>
  	[
  		'enabled' => ['integer', '0'],
  		'type' => ['string', 'microsoft'],
  		'scope' => ['string', 'sub'],
  		'hosts' => ['string', ''],
  		'base' => ['string', ''],
  		'filter' => ['string', ''],
  		'user' => ['string', ''],
  		'password' => ['string', ''],
  		'password_hide' => ['integer', '1'],
  		'group_prefix' => ['string', ''],
  		'group_prefix_flag' => ['integer', '0'],
  		'memberOf' => ['integer', '0'],
  		'fallthrough' => ['integer', '0'],
  		'cache_conn' => ['integer', '0'],
  		'tls' => ['integer', '0'],
  		'path' => ['string', '/usr/local/lib/mavis/mavis_tacplus_ldap.pl'],
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
  		]
  	);
}
