<?php


$client = new \GuzzleHttp\Client();

$res = $client->request( 'POST', 'https://domain.com:4443/api/', ['verify' => '/opt/tacacsgui/ssl/tacacsgui.local.pem'] );
//echo $res->getStatusCode();
// 200
//echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
// '{"id": 1420053, "name": "guzzle", ...}'
