#!/usr/bin/php
<?php
require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';

require __DIR__ . '/../controller.php';

$mavis = new mavis_cotrl;

$debug = true;
$debugPrefix = 'LDAP Module. ';

$settings = array(
	'db' => [
		'driver' => 'mysql',
		'host'	=> DB_HOST,
		'database' => DB_NAME,
		'username' => DB_USER,
		'password' => DB_PASSWORD,
		'charset' => DB_CHARSET,
		'collation' => DB_COLLATE,
		'prefix' => ''
]);

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($settings['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

while($f = fgets(STDIN)){
	if (trim($f) == '=') break;
	if (trim($f) == '') continue;
	$mavis->in($f);
}

if ($debug) $mavis->debugIn($debugPrefix.'Start!');

$ldap = $capsule->table('mavis_ldap')->select()->first();

$config = [
	// Mandatory Configuration Options
	'hosts'            => array_map('trim', explode(',', $ldap->hosts) ),
	'base_dn'          => $ldap->base,
	'username'         => $ldap->user,
	'password'         => $ldap->password,

	// Optional Configuration Options
	'schema'           => Adldap\Schemas\ActiveDirectory::class,
	//'account_prefix'   => 'ACME-',
	//'account_suffix'   => '@acme.org',
	'port'             => $ldap->port,
	'follow_referrals' => false,
	'use_ssl'          => false,
	'use_tls'          => false,
	'version'          => 3,
	'timeout'          => 5,
];

if ($debug) $mavis->debugIn($debugPrefix.'Set LDAP Config');

$ad = new Adldap\Adldap();

$ad->addProvider($config);

try {
		if ($debug) $mavis->debugIn($debugPrefix.'Attempt to connect');
    $provider = $ad->connect();
} catch (Adldap\Auth\BindException $e) {
		if ($debug) $mavis->debugIn($debugPrefix.'Connect FAIL! Exit.');
		$mavis->out();
}
if ($debug) $mavis->debugIn($debugPrefix.'Connect Success!');
$search = $provider->search();

//$filter = 'CN=FileAccess_1';

$adUser = $search->select(['cn', 'memberOf'])->where('objectclass', 'user')->where( $ldap->filter, $mavis->getUsername() )->first();

if ( !$adUser ) {
	if ($debug) $mavis->debugIn($debugPrefix.'User not found! Exit.');
	$mavis->out(AV_V_RESULT_NOTFOUND);
}

try {

    if ( ! $ad->auth()->attempt( $mavis->getUsername(), $mavis->getPassword() ) ) {
			if ($debug) $mavis->debugIn($debugPrefix.'Auth FAIL!');
			$mavis->out(AV_V_RESULT_FAIL);
		}

} catch (Adldap\Auth\UsernameRequiredException $e) {
    // The user didn't supply a username.
    if ($debug) $mavis->debugIn($debugPrefix.'Auth FAIL! Exit.');
    $mavis->out(AV_V_RESULT_FAIL);
} catch (Adldap\Auth\PasswordRequiredException $e) {
    // The user didn't supply a password.
    if ($debug) $mavis->debugIn($debugPrefix.'Auth FAIL! Exit.');
    $mavis->out(AV_V_RESULT_FAIL);
}

if ($debug) $mavis->debugIn($debugPrefix.'Auth Success!');

if ( ! $ad->auth()->attempt( $mavis->getUsername(), $mavis->getPassword() ) ) $mavis->out(AV_V_RESULT_FAIL);

//$adUser = $search->rawFilter($filter)->get();
if ($debug) $mavis->debugIn($debugPrefix.'Get Groups');
$groupList = [];
for ($i=0; $i < count($adUser->memberof); $i++) {
	preg_match_all('/^CN=(.*?),.*/s', $adUser->memberof[$i], $groupName);
	$groupList[] = $groupName[1][0];
}

$groupList_fullNames = $adUser->memberof;
$groupList_result = [];
if ( ! empty($groupList) ){
	$user_grps = $capsule->table('tac_user_groups')->select('name')->
			where(function ($query) use ($groupList_fullNames, $groupList) {
					for ($i=0; $i < count($groupList_fullNames) ; $i++) {
						if ( $i == 0 ) { $query->where('ldap_groups', 'like', '%'.$groupList_fullNames[$i].'%')->orWhere('name', $groupList[$i]); continue; }
						$query->orWhere('ldap_groups', 'LIKE', '%'.$groupList_fullNames[$i].'%')->orWhere('name', $groupList[$i]);
					}
	    })->get()->toArray();
	foreach ($user_grps as $ugrp) {
		//if ( ! in_array($ugrp->name, $groupList) ) $groupList[] = $ugrp->name;
		$groupList_result[] = $ugrp->name;
	}
}
if ($debug) $mavis->debugIn($debugPrefix.'Group List: '. implode(',', $groupList_result));
$mavis->setMempership($groupList_result);

$mavis->auth();
if ($debug) $mavis->debugIn($debugPrefix.'Exit');
$mavis->out();


die();

if ($debug) $mavis->debugIn($debugPrefix.'Outside of Module!! Exit.');
