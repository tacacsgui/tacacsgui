<?php

namespace parser\Models;

use Illuminate\Database\Eloquent\Model;

class PostBuffer extends Model
{
	protected $table = 'post_buffer';

	protected $fillable = [
    'server',
    'date',
    'type',
    'username',
    'user_ipaddr',
    'device_ipaddr',
    'count',
  ];
}
