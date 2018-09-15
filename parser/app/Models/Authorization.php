<?php

namespace parser\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
	protected $table = 'tac_log_authorization';

	protected $fillable = [
		'server',
		'date',
		'NAS',
		'username',
		'line',
		'NAC',
		'action',
		'cmd',
	];
}
