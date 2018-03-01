<?php

namespace tgui\Validation\Rules;

use tgui\Models\TACACL;
use Respect\Validation\Rules\AbstractRule;

class AclNameAvailable extends AbstractRule
{
	private $aclId;
	
	public function __construct($aclId)
	{
		$this->aclId=$aclId;
	}
	
	public function validate($input)
	{	
		if ($this->aclId){
			
			return TACACL::where([['name', '=' ,$input],['line_number', '=' ,0],['id', '<>', $this->aclId]])->count() === 0;
		}
		return TACACL::where('name', $input)->count() === 0;
	}
}
