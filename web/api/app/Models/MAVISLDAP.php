<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class MAVISLDAP extends Model
{
	protected $table = 'mavis_ldap';

	protected $fillable = [
		'enabled',
		'type',
		'scope' ,
		'hosts' ,
		'base' ,
		'port' ,
		'filter' ,
		'user' ,
		'password' ,
		'password_hide' ,
		'group_prefix',
		'group_prefix_flag' ,
		'memberOf' ,
		'fallthrough' ,
		'cache_conn' ,
		'tls' ,
		'path' ,
	];
}
