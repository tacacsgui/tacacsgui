<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APIUserGrps extends Model
{
	protected $table = 'api_user_groups';

	protected $fillable = [
		'name',
		'rights',
		'default_flag',
		'bad_authentication_notice',
		'bad_authorization_notice',
	];
}
