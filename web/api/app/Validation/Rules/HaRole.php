<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use tgui\Controllers\Controller;

class HaRole extends AbstractRule
{
	private $mainRole;
	private $currentRole;

	public function __construct($mainRole = 'master', $currentRole = 'master')
	{
		$this->mainRole=$mainRole;
		$this->currentRole=$currentRole;
	}

	public function validate($input)
	{
		return $this->mainRole == $this->currentRole;
	}
}
