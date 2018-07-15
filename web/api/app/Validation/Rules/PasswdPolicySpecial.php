<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class PasswdPolicySpecial extends AbstractRule
{
  public $policy;
	public function __construct($policy = 1)
  {
    $this->policy = $policy;
  }

	public function validate($input)
	{
    if ($this->policy == 0) return true;
    switch (true) {
      case preg_match('/[~!@#=`|(){}[\]:;<>,]/', $input):
        return true;
        break;
      case preg_match('/[$%^&_-]/', $input):
        return true;
        break;
      case preg_match('/[\*\+\.\?\/]/', $input):
        return true;
        break;

      default:
        return false;
        break;
    }
    //~!@#$%^&*_-+=`|(){}[]:;<>,.?/
	}
}
