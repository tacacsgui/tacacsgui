<?php

namespace tgui\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PasswdPolicyUppercaseException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => '{{name}} must contain upper-case letters (A-Z)',
		],
	];
}
