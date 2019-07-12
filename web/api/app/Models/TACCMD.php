<?php

namespace tgui\Models;

use Illuminate\Database\Eloquent\Model;

class TACCMD extends Model
{
	protected $table = 'tac_cmd';

	protected $fillable = [
    'name',
    'cmd',
    'cmd_attr',
    'junos',
    'cmd_permit_end',
    'type',
    'manual',
    'message_deny',
    'message_permit',
	];
}
