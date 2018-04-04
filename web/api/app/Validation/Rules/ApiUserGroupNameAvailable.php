<?php

namespace tgui\Validation\Rules;

use tgui\Models\APIUserGrps;
use Respect\Validation\Rules\AbstractRule;

class ApiUserGroupNameAvailable extends AbstractRule
{
	private $groupID;
	
	public function __construct($groupID)
	{
		$this->groupID=$groupID;
	}
	
	public function validate($input)
	{	
		if ($this->groupID != 0){
			
			return APIUserGrps::where([['name', '=' ,$input],['id', '<>', $this->groupID]])->count() === 0;
		}
		return APIUserGrps::where('name', $input)->count() === 0;
	}
}
