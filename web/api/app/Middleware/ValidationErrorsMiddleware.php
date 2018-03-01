<?php

namespace tgui\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		//echo'<pre>'; var_dump($_SESSION['error']['status']); die(); echo'</pre>';
		/*if($_SESSION['error']['status']){
			if (!$_SESSION['error']['authorized'] and !isset($_SESSION['uid'])){
				//$response = $response->withStatus(401);
			} else{
				//$response = $response->withStatus(501);
			}
		} */
		$response = $next($request, $response);
		return $response;
	}
}
