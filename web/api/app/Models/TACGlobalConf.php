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
		'syslog_ip',
		'syslog_port',
		'connection_timeout',
		'context_timeout',
		'skip_conflicting_groups',
		'skip_missing_groups',
		'max_attempts',
		'backoff',
		'manual',
		'changeFlag',
		'revisionNum',
	];
}
