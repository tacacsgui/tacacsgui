<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use tgui\Controllers\Controller;

class CmdType extends AbstractRule
{
	private $value;
	private $type;

	public function __construct($type = 0, $value = 0)
	{
		$this->value=$value;
		$this->type=$type;
	}

	public function validate($input)
	{
		return $this->value == $this->type;
	}
}
