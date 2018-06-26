<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACGlobalConf extends Model
{
	protected $table = 'tac_global_settings';

	protected $fillable = [
		'port',
		'accounting',
		'authorization',
		'authentication',
		'connection_timeout',
		'context_timeout',
		'max_attempts',
		'backoff',
		'manual',
		'changeFlag',
		'revisionNum',
	];
}
