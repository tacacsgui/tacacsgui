<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class checkLoginType extends AbstractRule
{
	private $flag;
	private $type;

	public function __construct($flag = '', $type = '')
	{
		$this->flag=$flag;
		$this->type=$type;
	}

	public function validate($input)
	{
		switch ($this->type) {
			case 'email':
				return !( in_array($this->flag, [5,12]) );

			default:
				return !( in_array($this->flag, [0,1,2,3]) );
		}

	}
}
