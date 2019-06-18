<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class ObjAddress_ extends Model
{
	protected $table = 'obj_addresses';

	protected $fillable = [
    'type', //0-ipv4; 1-ipv6; 2-fqdn
    'name',
    'address',
	];
}
