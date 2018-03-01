<?php

namespace tgui\Validation\Rules;

use tgui\Models\TACUsers;
use Respect\Validation\Rules\AbstractRule;

class UserTacAvailable extends AbstractRule
{
	private $userID;
	
	public function __construct($userID)
	{
		$this->userID=$userID;
	}
	
	public function validate($input)
	{
		if (isset($this->userID)){
			
			return TACUsers::where([['username', '=' ,$input],['id', '<>', $this->userID]])->count() === 0;
		}
		
		return TACUsers::where('username', $input)->count() === 0;
	}
}
