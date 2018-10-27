<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APIUsers extends Model
{
	protected $table = 'api_users';

	protected $hidden = ['password'];

	protected $fillable = [
		'email',
		'username',
		'password',
		'firstname',
		'surname',
		'position',
		'group',
		'changePasswd',
		'bad_authentication_notice',
		'bad_authorization_notice',
	];
}
