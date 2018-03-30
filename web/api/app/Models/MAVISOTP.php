<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class MAVISOTP extends Model
{
	protected $table = 'mavis_otp';
	
	protected $fillable = [
		'enabled',
		'period',
		'digits',
		'digest',
	];
}
