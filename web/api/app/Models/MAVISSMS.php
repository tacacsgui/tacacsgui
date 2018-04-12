<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class MAVISSMS extends Model
{
	protected $table = 'mavis_sms';
	
	protected $fillable = [
		'enabled',
		'ipaddr',
		'port',
		'login',
		'pass',
		'srcname',
	];
}
