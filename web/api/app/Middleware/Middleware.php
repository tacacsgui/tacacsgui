<?php

namespace tgui\Middleware;

class Middleware
{
	protected $container;
	
	public function __construct($container)
	{
		$this->container = $container;
	}
}
