<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class CheckPassword extends AbstractRule
{
	private $value;

	public function __construct($value = '')
	{
		$this->value=$value;
	}

	public function validate($input)
	{
		return ($this->value == $input);
	}
}
