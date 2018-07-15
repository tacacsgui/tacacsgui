<?php

namespace tgui\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PasswdPolicyLowercaseException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => '{{name}} must contain lower-case letters (a-z)',
		],
	];
}
