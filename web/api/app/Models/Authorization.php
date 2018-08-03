<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
	protected $connection = 'logging';

	protected $table = 'tac_log_authorization';

	protected $fillable = [
		'date',
		'nas',
		'username',
		'line',
		'nac',
		'action',
		'cmd',
	];
}
