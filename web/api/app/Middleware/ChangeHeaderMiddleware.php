<?php

namespace tgui\Middleware;

class ChangeHeaderMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		$response = $response->withHeader('Access-Control-Allow-Origin', '*');
		$response = $response->withHeader('Content-type', 'application/json');
		$response = $response->withHeader('Application-name', 'tacacsgui');
		$response = $response->withHeader('Author-Name', 'Alexey Mochalin');
		$response = $response->withHeader('Application-version', APIVER);
		$response = $next($request, $response);
		//echo '<pre>'; var_dump($response); die(); echo '</pre>';
		return $response;
	}
}
