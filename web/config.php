<?php

/** GUI version */
define('GUI_VER', '0.8.0');
/** Link to api */
define('API_LINK', '/api/'); // e.i. if the same server then - /tgui/api/, if remote server then - www.tacacsgui.com/api/ or 1.1.1.1/somefolder/api/ . Don't forget the last slash char!
//define('API_LINK', 'https://'.$_SERVER['SERVER_ADDR'].'/api/'); // e.i. if the same server then - /tgui/api/, if remote server then - www.tacacsgui.com/api/ or 1.1.1.1/somefolder/api/ . Don't forget the last slash char!
/** GUI Skin */
define('GUI_SKIN', 'skin-green');
//skin-green//skin-blue//skin-yellow


/////////////////////////////
//////////MAIN MENU//////////
/////////////////////////////
$HOME = array(
	'id' => 10,
	'name' => 'Dashboard',
	'href' => '/dashboard.php',
	'li-class' => '',
	'icon' => 'fa fa-dashboard',
	'icon-class' => 'text-purple',
	'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
	'submenuFlag' => 0,
	'submenu' => [],//.submenu
);

$TAC_DEVICES = array(
	'id' => 20,
	'name' => 'Tacacs Devices',
	'href' => '#',
	'li-class' => '',
	'icon' => 'fa fa-server',
	'icon-class' => 'text-blue',
	'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
	'submenuFlag' => 1,
	'submenu' => [
		'devices' => [
			'id' => 210,
			'name' => 'Devices',
			'href' => 'tac_devices.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-blue',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
		'device_groups' => [
			'id' => 220,
			'name' => 'Device Groups',
			'href' => 'tac_device_groups.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-blue',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
	],//.submenu
);

$TAC_USERS = array(
	'id' => 30,
	'name' => 'Tacacs Users',
	'href' => '#',
	'li-class' => 'parent_access',
	'icon' => 'fa fa-child',
	'icon-class' => 'text-yellow',
	'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
	'submenuFlag' => 1,
	'submenu' => [
		'users' => [
			'id' => 310,
			'name' => 'Users',
			'href' => 'tac_users.php',
			'li-class' => 'grp_access_4',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-yellow',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
		'user_groups' => [
			'id' => 320,
			'name' => 'User Groups',
			'href' => 'tac_user_groups.php',
			'li-class' => 'grp_access_5',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-yellow',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
	],//.submenu
);

$TAC_CONFIGURATION = array(
	'id' => 40,
	'name' => 'Tacacs Configuration',
	'href' => '',
	'li-class' => '',
	'icon' => 'fa fa-cogs',
	'icon-class' => 'text-green',
	'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
	'submenuFlag' => 1,
	'submenu' => [
		'users' => [
			'id' => 410,
			'name' => 'Global Settings',
			'href' => 'tac_global_settings.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-green',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
		'user_groups' => [
			'id' => 420,
			'name' => 'Test & Apply',
			'href' => 'tac_configuration.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-green',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
	],//.submenu
);

$TAC_ACL = array(
	'id' => 50,
	'name' => 'Access Rules',
	'href' => '',
	'li-class' => '',
	'icon' => 'fa fa-exchange',
	'icon-class' => 'text-red',
	'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
	'submenuFlag' => 1,
	'submenu' => [
			'acls' => [
			'id' => 510,
			'name' => 'ACLs',
			'href' => 'tac_acl.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-red',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
			],
			'services' => [
			'id' => 520,
			'name' => 'Services',
			'href' => 'tac_services.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-red',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
			],
	],//.submenu
);

$TAC_REPORTS = array(
	'id' => 90,
	'name' => 'Tacacs Reports',
	'href' => '#',
	'li-class' => '',
	'icon' => 'fa fa-binoculars',
	'icon-class' => 'text-aqua',
	'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
	'submenuFlag' => 1,
	'submenu' => [
		'authentication' => [
			'id' => 910,
			'name' => 'Authentication',
			'href' => 'tac_authentication.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-aqua',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
		'authorization' => [
			'id' => 920,
			'name' => 'Authorization',
			'href' => 'tac_authorization.php',
			'li-class' => '',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-aqua',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
		'accounting' => [
			'id' => 930,
			'name' => 'Accounting',
			'href' => 'tac_accounting.php',
			'li-class' => 'text-aqua',
			'icon' => 'fa fa-circle-o',
			'icon-class' => 'text-aqua',
			'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
			'submenuFlag' => 0,
			'submenu' => [],//.submenu
		],
	],//.submenu
);

$MAIN_MENU = array(

	'head' => [
	'name' => 'Menu',
	'li-class' => 'text-center',
	'icon' => '',
	'icon-class' => '',
	'type' => 1, //type 0 used for linked menu item, type 1 user for header in menu
	],

	'home' => $HOME,

	'tacacsHeader' => [
	'name' => 'Tacacs',
	'li-class' => 'text-center',
	'icon' => '',
	'icon-class' => '',
	'type' => 1, //type 0 used for linked menu item, type 1 user for header in menu
	],

	'tacacs_devices' => $TAC_DEVICES,

	'tacacs_users' => $TAC_USERS,

	'tacacs_configuration' => $TAC_CONFIGURATION,

	'tacacs_acls' => $TAC_ACL,

	'tacacs_reports' => $TAC_REPORTS,

	'mavis_header' => [
	'name' => 'MAVIS',
	'li-class' => 'text-center',
	'icon' => '',
	'icon-class' => '',
	'type' => 1, //type 0 used for linked menu item, type 1 user for header in menu
	],

	'mavis_section' => [
		'id' => 900,
		'name' => 'MAVIS Modules',
		'href' => '#',
		'li-class' => '',
		'icon' => 'fa fa-cog fa-spin fa-fw',
		'icon-class' => 'text-green',
		'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
		'submenuFlag' => 1,
		'submenu' => [
			'otp' => [
				'id' => 910,
				'name' => 'OTP Auth',
				'href' => 'mavis_otp.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
			'ldap' => [
				'id' => 920,
				'name' => 'LDAP Auth',
				'href' => 'mavis_ldap.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
			'sms' => [
				'id' => 930,
				'name' => 'SMS Auth',
				'href' => 'mavis_sms.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
			'telegram' => [
				'id' => 940,
				'name' => 'Telegram Auth',
				'href' => 'mavis_telegram.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			]
		]
	],

	'api_settins' => [
	'name' => 'API Settings',
	'li-class' => 'text-center',
	'icon' => '',
	'icon-class' => '',
	'type' => 1, //type 0 used for linked menu item, type 1 user for header in menu
	],

	'administration' => [
		'id' => 1000,
		'name' => 'Administration',
		'href' => '#',
		'li-class' => '',
		'icon' => 'fa fa-cog',
		'icon-class' => 'text-green',
		'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
		'submenuFlag' => 1,
		'submenu' => [
			'users' => [
				'id' => 1010,
				'name' => 'API Users',
				'href' => 'api_users.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
			'userGroups' => [
				'id' => 1020,
				'name' => 'API User Groups',
				'href' => 'api_user_groups.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
			'api_settings' => [
				'id' => 1030,
				'name' => 'API Settings',
				'href' => 'api_settings.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
			'api_update' => [
				'id' => 1040,
				'name' => 'API Update',
				'href' => 'api_update.php',
				'li-class' => '',
				'icon' => 'fa fa-circle-o',
				'icon-class' => '',
				'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
				'submenuFlag' => 0,
				'submenu' => [],//.submenu
			],
		],//.submenu
	],

	'API_Logging' => [
		'id' => 1100,
		'name' => 'API Logging',
		'href' => 'api_logging.php',
		'li-class' => '',
		'icon' => 'fa fa-binoculars',
		'icon-class' => 'text-aqua',
		'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
		'submenuFlag' => 0,
		'submenu' => [],
	],

	'backup' => [
		'id' => 1200,
		'name' => 'System Backup',
		'href' => 'api_backup.php',
		'li-class' => '',
		'icon' => 'fa fa-database',
		'icon-class' => 'text-green',
		'type' => 0, //type 0 used for linked menu item, type 1 user for header in menu
		'submenuFlag' => 0,
		'submenu' => [],
	],

/*	'end' => [
	'name' => 'END',
	'li-class' => '',
	'icon' => '',
	'icon-class' => '',
	'type' => 1, //type 0 used for linked menu item, type 1 user for header in menu
	], */
);
