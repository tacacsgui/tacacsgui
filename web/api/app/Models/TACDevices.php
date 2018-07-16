<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACDevices extends Model
{
	protected $table = 'tac_devices';

	protected $fillable = [
		'ipaddr',
		'name',
		'prefix',
		'key',
		'enable',
		'enable_flag',
		'group',
		'model',
		'vendor',
		'type',
		'sn',
		'disabled',
		'banner_welcome',
		'banner_motd',
		'banner_failed',
		'manual',
	];
}
