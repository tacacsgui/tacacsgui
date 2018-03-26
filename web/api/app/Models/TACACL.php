<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACACL extends Model
{
	protected $table = 'tac_acl';
	
	protected $fillable = [
		'name',
		'action',
		'nac',
		'nas',
		'line_number',
		'timerange',
	];
}
