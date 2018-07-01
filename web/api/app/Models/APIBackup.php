<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APIBackup extends Model
{
	protected $table = 'api_backup';

	protected $fillable = [
		'tcfgSet',
		'apicfgSet',
	];
}
