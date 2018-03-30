<?php

namespace tgui\Validation\Rules;

use tgui\Models\TACDeviceGrps;
use Respect\Validation\Rules\AbstractRule;

class DeviceGroupAvailable extends AbstractRule
{
	private $groupID;
	
	public function __construct($groupID)
	{
		$this->groupID=$groupID;
	}
	
	public function validate($input)
	{	
		if ($this->groupID !== 0){
			
			return TACDeviceGrps::where([['name', '=' ,$input],['id', '<>', $this->groupID]])->count() === 0;
		}
		return TACDeviceGrps::where('name', $input)->count() === 0;
	}
}
