<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACUserGrps extends Model
{
	protected $table = 'tac_user_groups';
	
	protected $fillable = [
		'name',
		'enable',
		'enable_flag',
		'message',
		'default_flag',
		'valid_from',
		'valid_until',
		'manual',
	];
}
