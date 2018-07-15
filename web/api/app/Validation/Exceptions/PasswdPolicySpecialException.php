<?php

namespace tgui\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class PasswdPolicySpecialException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => '{{name}} must contain special chars (~!@#$%^&*_-+=`|(){}[]:;<>,.?/)',
		],
	];
}
