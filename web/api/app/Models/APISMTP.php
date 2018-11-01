<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APISMTP extends Model
{
	protected $table = 'api_smtp';

	protected $fillable = [
    'smtp_servers',
		'smtp_auth',
		'smtp_autotls',
		'smtp_from',
		'smtp_username',
		'smtp_password',
		'smtp_port',
		'smtp_secure'
	];
}
