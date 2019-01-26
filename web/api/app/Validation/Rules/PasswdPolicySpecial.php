<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class PasswdPolicySpecial extends AbstractRule
{
  public $policy;
  public function __construct($policy = 1, $login_flag = 0)
  {
    $this->policy = $policy;
    $this->login_flag = $login_flag;
  }

	public function validate($input)
	{
    if ( $this->policy == 0 OR !in_array( $this->login_flag, [0,1,3]) ) return true;
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
