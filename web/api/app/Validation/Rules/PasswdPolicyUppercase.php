<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class PasswdPolicyUppercase extends AbstractRule
{
  private $policy;
  private $login_flag;
	public function __construct($policy = 1, $login_flag = 0)
  {
    $this->policy = $policy;
    $this->login_flag = $login_flag;
  }

	public function validate($input)
	{
    if ( $this->policy == 0 OR !in_array( $this->login_flag, [0,1,3]) ) return true;
		return preg_match('/[A-Z]+/',$input);
	}
}
