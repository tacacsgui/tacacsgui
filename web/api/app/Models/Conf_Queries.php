<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_Queries extends Model
{
	protected $table = 'confM_queries';

	protected $fillable = [
    'name',
    'f_group',
    'disabled',
    'omit_lines',
    'credential',
    'model',
	];
}
