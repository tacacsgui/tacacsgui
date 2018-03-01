<?php

namespace tgui\Validation\Rules;

use tgui\Models\APIUsers;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
	public function validate($input)
	{
		return APIUsers::where('email', $input)->count() === 0;
	}
}
