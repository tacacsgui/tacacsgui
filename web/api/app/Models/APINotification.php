<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class APINotification extends Model
{
	protected $table = 'api_notification';

	protected $fillable = [
    'bad_authentication_enable',
    'bad_authentication_count',
    'bad_authentication_interval',
    'bad_authentication_email_list',
    'bad_authorization_enable',
    'bad_authorization_count',
    'bad_authorization_interval',
    'bad_authorization_email_list',
	];
}
