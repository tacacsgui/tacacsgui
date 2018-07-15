<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use tgui\Models\APIUserGrps;
use tgui\Controllers\Controller;

class AdminRights extends AbstractRule
{
	private $value;

	public function __construct($value = 0)
	{
		$this->value=$value;
	}

	public function validate($input)
	{
    if ( is_array($input) AND in_array(1, $input) ) return Controller::checkAccess(1);

    if ( !is_array($input) ) {
      $input = intval($input);
      $grpRights = APIUserGrps::where('id', $input)->first()->rights;
      if (!$grpRights) return false;
      $grpRightsArr = array_reverse ( str_split( decbin( $grpRights ) ) );
      if ($grpRightsArr[1] == 0) return true;
      return Controller::checkAccess(1);
    }
    else return false;
	}
}
