<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class PasswdPolicySame extends AbstractRule
{
  public $policy;
  public $target;
  public $password;
	public function __construct($policy = 1, $password = '', $target = 'api')
  {
    $this->policy = $policy;
    $this->password = $password;
    $this->target = $target;
  }

	public function validate($input)
	{
    if ($this->policy == 0) return true;
    return !password_verify($input, $this->password);
	}
}
