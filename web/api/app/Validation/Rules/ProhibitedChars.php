<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class ProhibitedChars extends AbstractRule
{

	public function validate($input)
	{

		return !preg_match('/["\'\\\\*]/',$input);
	}
}
