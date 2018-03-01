<?php

namespace tgui\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator 
{
	protected $errors;
	public $error_messages;
	
	public function validate($request, array $rules)
	{
		foreach ($rules as $field => $rule) {
			$this->error_messages[$field] = null;
			
			try {
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
				
			} catch (NestedValidationException $e) { //$e is Exception
				
				$this->errors[] = $e->getMessages();
				$this->error_messages[$field] = $e->getMessages();
				
			}
		}
		
		return $this;
	}
	
	public function failed()
	{
		return !empty($this->errors);
	}
}
