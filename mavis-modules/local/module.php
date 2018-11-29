#!/usr/bin/php
<?php
require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';

use Respect\Validation\Validator as v;

require __DIR__ . '/../controller.php';

$mavis = new mavis_cotrl();

$debug = true;
$date = new DateTime();
$debugPrefix = $date->format('Y-m-d H:i:s') . ' Local Module. ';

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

	$user = $capsule->table('tac_users')->select('id','login', 'login_flag', 'login_change')->where([['username', '=', $mavis->getUsername()],['login_flag','=',3]])->first();


	if ($user == NULL){
		if ($debug) $mavis->debugIn($debugPrefix.'User not found! Exit.');
		$mavis->out(AV_V_RESULT_NOTFOUND);
	}
	else
	{
		switch ( $mavis->getVariable(AV_A_TACTYPE) ) {
			// case 'CHAL':
			// 	$input[32] = 'Hello! Please type your password';
			// 	$result = 0;
			// 	break;
			case 'AUTH':
				if ($debug) $mavis->debugIn($debugPrefix.'Verification status: ' . ( ( password_verify($mavis->getPassword(), $user->login) ) ? 'allow' : 'deny' ) );
				if ( password_verify($mavis->getPassword(), $user->login) )
				{
					if ($debug) $mavis->debugIn($debugPrefix.'User Auth Success! Exit.');
					$mavis->auth();
					$mavis->out();
				}
				else
				{
					if ($debug) $mavis->debugIn($debugPrefix.'User Access Deny! Exit.');
					$mavis->out(AV_V_RESULT_FAIL);
				}
				break;
			case 'CHPW':
				if ($debug) $mavis->debugIn($debugPrefix.'Change password init');
				$settings = $capsule->table('mavis_local')->select('enabled', 'change_passwd_cli')->first();

				if ($settings->enabled AND $settings->change_passwd_cli AND $user->login_change AND password_verify($mavis->getPassword(), $user->login))
				{
					/*if ($user->group != 0) {
						$group = $capsule->table('tac_user_groups')->select('name')->where([['id', '=', $user->group]])->first();
						$input[47] = '"'. $group->name .'"';
					}*/
					$policy = $capsule->table('api_password_policy')->select()->first(1);
					$validation = '';
					$validation .= ( ! v::length($policy->tac_pw_length, 64)->validate( $mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' minimum length is '. $policy->tac_pw_length.';' : '';
					$validation .= ( $policy->tac_pw_uppercase AND !v::regex('/[A-Z]/')->validate( $mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 uppercase letter;' : '';
					$validation .= ( $policy->tac_pw_lowercase AND !v::regex('/[a-z]/')->validate( $mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 lowercase letter;' : '';
					$regex = '/[&\^$%\*\+\.\?\/~!@#=`|(){}[\]:;<>,_-]/'; //$%^&
					$validation .= ( $policy->tac_pw_special AND !v::regex($regex)->validate( $mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 special char;' : '';
					$validation .= ( $policy->tac_pw_numbers AND !v::regex('/[0-9]/')->validate( $mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 number;' : '';

					$validation .= ( $policy->tac_pw_same AND $mavis->getPassword() == $mavis->getVariable(AV_A_PASSWORD_NEW)  ) ? ' password can not be the same;' : '';

					if ($validation != ''){
						$mavis->setVariable(AV_A_USER_RESPONSE, '# ERROR # !!! ATTENTION !!! Password should contain: ' . $validation . ' # ERROR #' );
						if ($debug) $mavis->debugIn($debugPrefix.'Password policy not met! Exit.');
						$mavis->mavisOk()->out(AV_V_RESULT_FAIL); // mavis ok to show the message
					}

					$capsule->table('tac_users')->where([['username', '=', $mavis->getUsername()],['id','=',$user->id]])->update([
						'login' => password_hash( $mavis->getVariable(AV_A_PASSWORD_NEW), PASSWORD_DEFAULT )
					]);
					$mavis->setVariable(AV_A_USER_RESPONSE, '# Success # Password was changed');
					$mavis->setVariable(AV_A_TACTYPE, AV_V_TACTYPE_AUTH);
					if ($debug) $mavis->debugIn($debugPrefix.'Password Changed. User Auth Success! Exit.');
					$mavis->auth();
					$mavis->unsetVariable(AV_A_PASSWORD_NEW)->out(); //->unsetVariable(AV_A_TIMESTAMP)

				}
				if ($debug) $mavis->debugIn($debugPrefix.'Incorrect Old Password. Exit.');
				$mavis->unsetVariable(AV_A_PASSWORD_NEW)->unsetVariable(AV_A_TIMESTAMP)->out(AV_V_RESULT_FAIL);
				// $input[32] = '# ERROR # Incorrect password!';
				// $input[6] = 'NAK';
				// $input[49] = 'AUTH';
				// unset($input[50]);
				// unset($input[3]);
				// $result = 1;
				break;
		}
	}

	if ($debug) $mavis->debugIn($debugPrefix.'Outside of module!');

	//die();
