<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class Conf_Devices extends Model
{
	protected $table = 'confM_devices';

	protected $fillable = [
    'name',
    'prompt',
    'protocol',
    'port',
    'tac_device',
    'credential',
    'address'
	];
}
