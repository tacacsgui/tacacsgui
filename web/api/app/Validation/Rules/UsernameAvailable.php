<?php

namespace tgui\Validation\Rules;

use tgui\Models\APIUsers;
use Respect\Validation\Rules\AbstractRule;

class UsernameAvailable extends AbstractRule
{
	public function validate($input)
	{
		return APIUsers::where('username', $input)->count() === 0;
	}
}
