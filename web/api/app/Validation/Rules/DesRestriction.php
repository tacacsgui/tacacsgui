<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class DesRestriction extends AbstractRule
{
	private $des;

	public function __construct($value)
	{
		$this->des=$value;
	}

	public function validate($input)
	{
    if ($this->des != 2) return true;
		return ( strlen($input) <= 8 );
	}
}
