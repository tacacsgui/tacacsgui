<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class MAVISLocal extends Model
{
	protected $table = 'mavis_local';

	protected $fillable = [
		'enabled',
		'change_passwd_cli',
		'change_passwd_gui',
	];
}
