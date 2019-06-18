<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACDevices extends Model
{
	protected $table = 'tac_devices';

	protected $fillable = [
		'address',
		'name',
		'key',
		'enable',
		'enable_flag',
		'group',
		'model',
		'vendor',
		'type',
		'sn',
		'disabled',
		'acl',
		'user_group',
		'connection_timeout',
		'banner_welcome',
		'banner_motd',
		'banner_failed',
		'manual',
	];
}
