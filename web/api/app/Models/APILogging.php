<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APILogging extends Model
{
	protected $connection = 'logging';

	protected $table = 'api_logging';

	protected $fillable = [
		'username',
		'uid',
		'user_ip',
		'obj_name',
		'obj_ip',
		'action',
		'section',
		'message',
	];
}
