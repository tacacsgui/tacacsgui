<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_Models extends Model
{
	protected $table = 'confM_models';

	protected $fillable = [
		'name',
    'prompt',
    'expectations',
	];
}
