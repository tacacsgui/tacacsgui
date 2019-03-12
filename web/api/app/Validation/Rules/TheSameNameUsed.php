<?php

namespace tgui\Validation\Rules;

use tgui\Models\Conf_Models;
use Respect\Validation\Rules\AbstractRule;

class TheSameNameUsed extends AbstractRule
{
	private $serviceID;
	private $model;
	private $field;

	public function __construct($model, $serviceID = 0, $field = 'name')
	{
		$this->serviceID=$serviceID;
		$this->model=$model;
		$this->field=$field;
	}

	public function validate($input)
	{
		if ($this->serviceID != 0){

			return $this->model::where([[$this->field, '=' ,$input],['id', '<>', $this->serviceID]])->count() === 0;
		}

		return $this->model::where($this->field, $input)->count() === 0;
	}
}
