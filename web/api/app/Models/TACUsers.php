<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACUsers extends Model
{
	protected $table = 'tac_users';

	protected $fillable = [
		'username',
		'login',
		'login_flag',
		'pap',
		'pap_flag',
		'pap_clone',
		'chap',
		'ms-chap',
		'enable',
		'enable_flag',
		'group',
		'disabled',
		'message',
		'priv-lvl',
		'acl',
		'service',
		'mavis_otp_ebabled',
		'mavis_otp_secret',
		'mavis_otp_period',
		'mavis_otp_digits',
		'mavis_otp_digest',
		'mavis_sms_enabled',
		'mavis_sms_number',
		'default_service',
		'manual',
	];
}
