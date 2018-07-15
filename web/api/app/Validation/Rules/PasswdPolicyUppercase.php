<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class PasswdPolicyUppercase extends AbstractRule
{
  public $policy;
	public function __construct($policy = 1)
  {
    $this->policy = $policy;
  }

	public function validate($input)
	{
    if ($this->policy == 0) return true;
		return preg_match('/[A-Z]+/',$input);
	}
}
