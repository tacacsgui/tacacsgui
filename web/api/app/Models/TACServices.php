<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACServices extends Model
{
	protected $table = 'tac_services';
	
	protected $fillable = [
		'name',
		'priv-lvl',
		'default_cmd',
		'manual',
		'manual_conf_only',
	];
}
