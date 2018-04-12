<?php

namespace otp_gen\Model;

use Illuminate\Database\Eloquent\Model;

class OTP_Base extends Model
{
	protected $table = 'mavis_otp_base';
	
	protected $fillable = [
		'otp',
		'username',
		'type',
		'destination',
		'status',
	];
}
