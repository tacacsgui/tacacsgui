<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACUsers extends Model
{
	protected $table = 'tac_users';

	protected $fillable = [
		'username',
		'email',
		'login',
		'login_flag',
		'pap',
		'pap_flag',
		'pap_clone',
		'chap',
		'ms_chap',
		'enable',
		'enable_flag',
		'group',
		'disabled',
		'message',
		//'priv-lvl', #deprecated
		'acl',
		'service',
		'device_list_action',
		'device_list',
		'device_group_list',
		// 'mavis_otp_ebabled',
		'mavis_otp_secret',
		// 'mavis_otp_period',
		// 'mavis_otp_digits',
		// 'mavis_otp_digest',
		// 'mavis_sms_enabled',
		'mavis_sms_number',
		'default_service',
		'valid_from',
		'valid_until',
		//'client_ip', #deprecated
		//'server_ip', #deprecated
		'manual',
	];
}
