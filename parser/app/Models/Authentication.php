<?php

namespace parser\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
	protected $table = 'tac_log_authentication';

	protected $fillable = [
		'server',
		'date',
		'NAS',
		'username',
		'line',
		'NAC',
		'action',
		'unknown',
	];
}
