<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
	protected $connection = 'logging';

	protected $table = 'tac_log_accounting';

	protected $fillable = [
		'date',
		'nas',
		'username',
		'line',
		'nac',
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
