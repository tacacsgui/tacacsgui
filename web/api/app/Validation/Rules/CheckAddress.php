<?php

namespace tgui\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class CheckAddress extends AbstractRule
{
	private $type;

	public function __construct($value = 0)
	{
		$this->type=$value;
	}

	public function validate($input)
	{
    switch ($this->type) {
      case 1:
        $input = explode('/', $input);
        // var_dump($input); die;
        return (filter_var($input[0], FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV6]) !== false)
        AND
        ( !isset($input[1]) OR (is_numeric($input[1]) AND $input[1] >= 0 AND $input[1] <= 128));
        break;
      case 2:
      //var_dump($input);
      return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $input) //valid chars check
          AND preg_match("/^.{1,253}$/", $input) //overall length check
          AND preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $input)   ); //length of each label
        break;

      default:
        $input = explode('/', $input);
        // var_dump($input); die;
        return (filter_var($input[0], FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV4]) !== false)
        AND
        ( !isset($input[1]) OR (is_numeric($input[1]) AND $input[1] >= 0 AND $input[1] <= 32));
    }
    return false;
	}
}
