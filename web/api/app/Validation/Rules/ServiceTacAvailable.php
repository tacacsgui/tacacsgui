<?php

namespace tgui\Validation\Rules;

use tgui\Models\TACServices;
use Respect\Validation\Rules\AbstractRule;

class ServiceTacAvailable extends AbstractRule
{
	private $serviceID;
	
	public function __construct($serviceID)
	{
		$this->serviceID=$serviceID;
	}
	
	public function validate($input)
	{
		if ($this->serviceID != 0){
			
			return TACServices::where([['name', '=' ,$input],['id', '<>', $this->serviceID]])->count() === 0;
		}
		
		return TACServices::where('name', $input)->count() === 0;
	}
}
