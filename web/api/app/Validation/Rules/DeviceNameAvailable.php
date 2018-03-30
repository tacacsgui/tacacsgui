<?php

namespace tgui\Validation\Rules;

use tgui\Models\TACDevices;
use Respect\Validation\Rules\AbstractRule;

class DeviceNameAvailable extends AbstractRule
{
	private $deviceID;
	
	public function __construct($deviceID)
	{
		$this->deviceID=$deviceID;
	}
	
	public function validate($input)
	{	
		if ($this->deviceID !== 0){
			
			return TACDevices::where([['name', '=' ,$input],['id', '<>', $this->deviceID]])->count() === 0;
		}
		return TACDevices::where('name', $input)->count() === 0;
	}
}
