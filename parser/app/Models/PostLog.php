<?php

namespace parser\Models;

use Illuminate\Database\Eloquent\Model;

class PostLog extends Model
{
	protected $table = 'post_log';

	protected $fillable = [
    'server',
    'date',
    'type',
    'username',
    'user_ipaddr',
    'device_ipaddr',
    'receivers',
    'status',
  ];
}
