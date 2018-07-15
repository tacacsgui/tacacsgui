<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APIPWPolicy extends Model
{
	protected $table = 'api_password_policy';

	protected $fillable = [
    'api_pw_length',
		'api_pw_uppercase',
		'api_pw_lowercase',
		'api_pw_numbers',
		'api_pw_special',
		'api_pw_same',
		'tac_pw_length',
		'tac_pw_uppercase',
		'tac_pw_lowercase',
		'tac_pw_numbers',
		'tac_pw_special',
		'tac_pw_same',
	];
}
