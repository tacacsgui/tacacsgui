<?php

namespace parser\Models;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
	protected $table = 'tac_log_accounting';

	protected $fillable = [
		'server',
		'date',
		'NAS',
		'username',
		'line',
		'NAC',
		'action',
		'task_id',
		'timezone',
		'service',
		'priv-lvl',
		'cmd',
		'disc-cause',
		'disc-cause-ext',
		'pre-session-time',
		'elapsed_time',
		'stop_time',
		'unknown',
	];
}
