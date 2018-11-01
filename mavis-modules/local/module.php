#!/usr/bin/php
<?php
require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';

use Respect\Validation\Validator as v;

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

$input = array();
$tempArray = array();
$username = '';
$result = 16;

while($f = fgets(STDIN)){
	//$myfile = file_put_contents('/opt/tacacsgui/outputtest.txt', $f, FILE_APPEND);
	if (trim($f) == '=') break;
	if (trim($f) == '') continue;
	$tempArray = explode(" ", trim($f));
	$input[$tempArray[0]]=trim($tempArray[1]);
	if (trim($tempArray[0]) == 4) $username = trim($tempArray[1]);
	if (trim($tempArray[0]) == 8) $password = trim($tempArray[1]);
}

	$user = $capsule->table('tac_users')->select('id','login', 'login_flag', 'login_change')->where([['username', '=', $username],['login_flag','=',3]])->first();


	if ($user == NULL){
		$input[6] = 'NFD';
		$input[32] = 'User not found. Local Module';
		$result = 16;
		if ($input[49] == 'CHAL') $input[32] = '';
	}
	else
	{
		switch ($input[49]) {
			case 'CHAL':
				$input[32] = 'Hello! Please type your password';
				$result = 0;
				break;
			case 'AUTH':
				if (password_verify($password, $user->login))
				{
					/*if ($user->group != 0) {
						$group = $capsule->table('tac_user_groups')->select('name')->where([['id', '=', $user->group]])->first();
						$input[47] = '"'. $group->name .'"';
					}*/
					$input[6] = 'ACK';
					$input[32] = 'Successfully logged in!';
					$result = 0;
					// $input[53] = 'y';
					// $input[32] = "!!! ATTENTION !!! Please change your password!";
					// $result = 0;
				}
				else
				{
					$input[6] = 'NAK';
					$input[32] = '# ERROR # Incorrect username or password';
					$result = 0;
				}
				break;
			case 'CHPW':
				$settings = $capsule->table('mavis_local')->select('enabled', 'change_passwd_cli')->first();

				if ($settings->enabled AND $settings->change_passwd_cli AND $user->login_change AND password_verify($password, $user->login))
				{
					/*if ($user->group != 0) {
						$group = $capsule->table('tac_user_groups')->select('name')->where([['id', '=', $user->group]])->first();
						$input[47] = '"'. $group->name .'"';
					}*/
					$policy = $capsule->table('api_password_policy')->select()->first(1);
					$validation = '';
					$validation .= ( ! v::length($policy->tac_pw_length, 64)->validate( $input[50] ) ) ? ' minimum length is '. $policy->tac_pw_length.';' : '';
					$validation .= ( $policy->tac_pw_uppercase AND !v::regex('/[A-Z]/')->validate( $input[50] ) ) ? ' min 1 uppercase letter;' : '';
					$validation .= ( $policy->tac_pw_lowercase AND !v::regex('/[a-z]/')->validate( $input[50] ) ) ? ' min 1 lowercase letter;' : '';
					$regex = '/[&\^$%\*\+\.\?\/~!@#=`|(){}[\]:;<>,_-]/'; //$%^&
					$validation .= ( $policy->tac_pw_special AND !v::regex($regex)->validate( $input[50] ) ) ? ' min 1 special char;' : '';
					$validation .= ( $policy->tac_pw_numbers AND !v::regex('/[0-9]/')->validate( $input[50] ) ) ? ' min 1 number;' : '';

					$validation .= ( $policy->tac_pw_same AND $password == $input[50]  ) ? ' password can not be the same;' : '';

					if ($validation != ''){
						$input[32] = '\'# ERROR # !!! ATTENTION !!! Password should contain: ' . $validation . ' # ERROR #\'';
						$input[6] = 'NAK';
						$result = 0;
						break;
					}

					$input[6] = 'ACK';
					$capsule->table('tac_users')->where([['username', '=', $username],['id','=',$user->id]])->update([
						'login' => password_hash( $input[50], PASSWORD_DEFAULT )
					]);
					$input[32] = '# Success # Password was changed';
					$result = 0;
					break;
				}
				$input[32] = '# ERROR # Incorrect password!';
				$input[6] = 'NAK';
				$input[49] = 'AUTH';
				unset($input[50]);
				unset($input[3]);
				$result = 1;
				break;
		}
	}

ksort($input);

$output = '';
foreach($input as $index => $value)
{
	$output.= $index.' '.$value."\n";
}
$output.="=".$result."\n";

fwrite(STDOUT, $output);
die();
