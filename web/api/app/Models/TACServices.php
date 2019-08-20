<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACServices extends Model
{
	protected $table = 'tac_services';

	protected $fillable = [
		'name',
		'acl',
		'manual',
		'manual_conf_only',
		//Patterns List//
			//Cisco RS//
			'cisco_rs_enable',
			'cisco_rs_privlvl',
			'cisco_rs_def_cmd',
			'cisco_rs_def_attr',
			'cisco_rs_idletime',
			'cisco_rs_debug_message',
			'cisco_rs_timeout',
			'cisco_rs_autocmd',
			'cisco_rs_nexus_roles',
			'cisco_rs_manual',
			//Cisco WLC//
			'cisco_wlc_enable',
			'cisco_wlc_roles',
			'cisco_wlc_manual',
			//H3C//
			'h3c_enable',
			'h3c_privlvl',
			'h3c_def_cmd',
			'h3c_def_attr',
			'h3c_idletime',
			'h3c_timeout',
			'h3c_manual',
			//Huawei//
			'huawei_enable',
			'huawei_privlvl',
			'huawei_def_cmd',
			'huawei_def_attr',
			'huawei_idletime',
			'huawei_timeout',
			'huawei_manual',
			//Extreme Networks//
			'extreme_enable',
			'extreme_privlvl',
			'extreme_def_cmd',
			'extreme_def_attr',
			'extreme_idletime',
			'extreme_timeout',
			'extreme_manual',
			//FortiOS//
			'fortios_enable',
			'fortios_admin_prof',
			'fortios_manual',
			//FortiOS//
			'junos_enable',
			'junos_username',
			// 'junos_cmd_ao',
			// 'junos_cmd_do',
			// 'junos_cmd_ac',
			// 'junos_cmd_dc',
			'junos_manual',
			//PaloAlto//
			'paloalto_enable',
			'paloalto_admin_role',
			'paloalto_admin_domain',
			'paloalto_panorama_admin_role',
			'paloalto_panorama_admin_domain',
			'paloalto_user_group',
			'paloalto_manual',
			//Silver Peak//
			'silverpeak_enable',
			'silverpeak_role',
			'silverpeak_manual',
		//END Pattern List
	];
}
