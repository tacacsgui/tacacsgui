<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class NotContainChars extends AbstractRule
{
	
	public function validate($input)
	{
		
		return !preg_match('/[\']/',$input);
	}
}
