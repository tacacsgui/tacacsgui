<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
	protected $table = 'tac_log_authentication';

	protected $fillable = [
		'date',
		'nas',
		'username',
		'line',
		'nac',
		'action',
		'unknown',
	];
}
