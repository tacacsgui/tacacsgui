<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class HaRole extends AbstractRule
{
	private $role1;
	private $role2;
	private $roleList = [
    'disabled' => '0',
    'master' => '1',
    'slave' => '2',
  ];

	public function __construct($role1 = 1, $role2 = 'master')
	{
		$this->role1=$role1;
		$this->role2=$role2;
	}

	public function validate($input)
	{
    return $this->roleList[$this->role2] == $this->role1;
	}
}
