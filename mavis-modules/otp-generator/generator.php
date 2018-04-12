<?php

//require __DIR__ . '/../../web/api/config.php';
$loader = require __DIR__ . '/../../web/api/vendor/autoload.php';
$loader->addPsr4('otp_gen\\', __DIR__ . '/app');

class otp_gen
{
	public $db;
	
	private function check()
	{
		$some_time = date('Y-m-d H:i:s', time() - 120);
		return $this->db->table('mavis_otp_base')->where([['created_at','<', $some_time]])->delete();
	}
	
	public function check_auth($username = '',$password = '')
	{
		$getEntry = $this->db->table('mavis_otp_base')->orderBy('created_at', 'desc')->where([['username','=',$username]])->first();
		if ($getEntry == null)
		{
			return false;
		}
		
		if ($getEntry->otp == $password) $this->db->table('mavis_otp_base')->where([['username','=',$username]])->delete();
		
		return $getEntry->otp == $password;
	}
	
	private function make_entry($options = array())
	{
		$this->check();
		
		$options['username'] = (empty($options['username'])) ? '' : $options['username'];
		$options['otp'] = (empty($options['otp'])) ? 'error' : $options['otp'];
		$options['type'] = (empty($options['type'])) ? 'udefined' : $options['type'];
		$destination = (empty($options['destination'])) ? 'undefined' : $options['destination'];

		return $this->db->table('mavis_otp_base')->insertGetId([
			'username' => $options['username'],
			'type' => $options['type'],
			'otp' => $options['otp'],
			'status' => 'unused',
			'destination' => $destination,
			
			'created_at' => date('Y-m-d H:i:s', time()),
		]);
	}
	
	public function generate_otp($options = array())
	{
		$length = 6; $digits = true; $lowcasechar = false; $uppercasechar = false;
		if (!$digits AND !$lowcasechar AND !$uppercasechar) return false;
		$characters = '';
		if ($digits) $characters .= '0123456789';
		if ($lowcasechar) $characters = 'abcdefghijklmnopqrstuvwxyz';
		if ($uppercasechar) $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		$options['otp'] = $randomString;
		
		$this->make_entry($options);
		
		return $randomString;
		//return $this->db->table('mavis_sms')->select('enabled')->first()->enabled;
	}
}

