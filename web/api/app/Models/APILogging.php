<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APILogging extends Model
{
	protected $table = 'api_logging';
	
	protected $fillable = [
		'userName',
		'userId',
		'userIp',
		'objectName',
		'objectId',
		'action',
		'section',
		'message',
	];
}
