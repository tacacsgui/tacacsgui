<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_Credentials extends Model
{
	protected $table = 'confM_credentials';

	protected $hidden = ['password'];

	protected $fillable = [
    'name',
    'username',
    'password',
	];
}
