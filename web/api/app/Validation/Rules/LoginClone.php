<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class LoginClone extends AbstractRule
{
	private $flag;

	public function __construct($value)
	{
		$this->flag=$value;
	}

	public function validate($input)
	{
		return ( $this->flag == 4 );
	}
}
