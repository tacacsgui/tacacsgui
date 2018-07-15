<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use tgui\Controllers\Controller;

class CheckAccess extends AbstractRule
{
	private $value;

	public function __construct($value = 0)
	{
		$this->value=$value;
	}

	public function validate($input)
	{
		return Controller::checkAccess($this->value);
	}
}
