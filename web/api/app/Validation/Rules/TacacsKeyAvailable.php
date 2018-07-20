<?php

namespace tgui\Validation\Rules;

use tgui\Models\TACDeviceGrps;
use Respect\Validation\Rules\AbstractRule;

class TacacsKeyAvailable extends AbstractRule
{
	private $groupID;

	public function __construct($groupID = 0)
	{
		$this->groupID=$groupID;
	}

	public function validate($input)
	{
		return ( TACDeviceGrps::where([['key', '<>' ,''],['id', '=', $this->groupID]])->count() != 0 );
	}
}
