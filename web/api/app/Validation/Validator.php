<?php

namespace tgui\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
	protected $errors;
	public $error_messages;
	public $messages;

	public function validate($request, array $rules)
	{
		$this->errors = [];
		$this->error_messages = [];
		$this->messages = [];
		foreach ($rules as $field => $rule) {
			$this->error_messages[$field] = null;
			$item = (is_array($request)) ? $request[$field] : $request->getParam($field);
			try {
				$rule->setName(ucfirst($field))->assert($item);

			} catch (NestedValidationException $e) { //$e is Exception

				$this->errors[] = $e->getMessages();
				$this->error_messages[$field] = $e->getMessages();
				$this->messages = array_merge($this->messages, $e->getMessages());

			}
		}

		return $this;
	}

	public function failed()
	{
		return !empty($this->errors);
	}

	public function getMessages()
	{
		return $this->messages;
	}
}
