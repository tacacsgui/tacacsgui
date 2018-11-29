<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACUserGrps extends Model
{
	protected $table = 'tac_user_groups';

	protected $fillable = [
		'name',
		'enable',
		'enable_flag',
		'message',
		'default_flag',
		//'priv-lvl', #deprecated
		'acl',
		'service',
		'ldap_groups',
		'default_service',
		'device_list_action',
		'device_list',
		'device_group_list',
		'valid_from',
		'valid_until',
		//'client_ip', #deprecated
		//'server_ip', #deprecated
		'manual',
	];
}
