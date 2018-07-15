<?php

namespace tgui\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class AdminRightsException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => 'Access Restricted',
		],
	];
}
