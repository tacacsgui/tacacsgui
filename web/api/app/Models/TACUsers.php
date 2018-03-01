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
		'enable',
		'enable_flag',
		'group',
		'disabled',
		'message',
		'default_service',
		'manual',
	];
}
