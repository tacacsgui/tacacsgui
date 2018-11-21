<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACServices extends Model
{
	protected $table = 'tac_services';

	protected $fillable = [
		'name',
		'priv-lvl',
		'default_cmd',
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
			'cisco_rs_cmd',
			'cisco_rs_autocmd',
			'cisco_rs_manual',
			//Cisco WLC//
			'cisco_wlc_enable',
			'cisco_wlc_roles',
			'cisco_wlc_manual',
			//FortiOS//
			'fortios_enable',
			'fortios_admin_prof',
			'fortios_manual',
			//PaloAlto//
			'paloalto_enable',
			'paloalto_admin_role',
			'paloalto_admin_domain',
			'paloalto_panorama_admin_role',
			'paloalto_panorama_admin_domain',
			'paloalto_user_group',
			'paloalto_manual',
		//END Pattern List
	];
}
