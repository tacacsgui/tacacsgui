<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class checkLoginType extends AbstractRule
{
	private $type;

	public function __construct($type = '')
	{
		$this->type=$type;
	}

	public function validate($input)
	{
		return !( in_array($this->type, [0,1,3]) );
	}
}
