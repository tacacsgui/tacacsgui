<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APILoggingMissRules extends Model
{

	protected $table = 'api_logging_miss_rules';

	protected $fillable = [
		'username',
		'name',
		'nas_address',
		'nac_address',
		'type',
		'tacacs_type',
		'description',
	];
}
