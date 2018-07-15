<?php

namespace tgui\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PasswdPolicyNumbersException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => '{{name}} must contain numbers [0-9]',
		],
	];
}
