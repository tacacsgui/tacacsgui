<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APISettings extends Model
{
	protected $table = 'api_settings';
	
	protected $fillable = [
		'name',
		'update_url',
		'update_signin',
		'api_logging_max_entries',
	];
}
