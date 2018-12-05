<?php

namespace mavis\Controllers\TGUIOTP;

use mavis\Controllers\Controller;

class TGUIOTP extends Controller
{
	private function check()
	{
		$some_time = date('Y-m-d H:i:s', time() - 120);
		return $this->db->table('mavis_otp_base')->where('created_at','<', $some_time)->delete();
	}

	public function validate($username = '',$password = '')
	{
    $this->check();
		if ( $this->db->table('mavis_otp_base')->orderBy('created_at', 'desc')->where([['username',$username],['otp',$password]])->count() )
		{
      $this->db->table('mavis_otp_base')->orderBy('created_at', 'desc')->where([['username',$username],['otp',$password]])->delete();
			return true;
		}

		return false;
	}

	public function otpMake( $options = array() )
	{
		$this->check();
    $otp = $this->generate_otp();
		$options['username'] = (empty($options['username'])) ? '' : $options['username'];
		$options['type'] = (empty($options['type'])) ? 'udefined' : $options['type'];
		$destination = (empty($options['destination'])) ? 'undefined' : $options['destination'];

		$this->db->table('mavis_otp_base')->insert([
			'username' => $options['username'],
			'type' => $options['type'],
			'otp' => $otp,
			'status' => 'unused',
			'destination' => $destination,
      'created_at' => date( 'Y-m-d H:i:s', time() )
		]);

    return $otp;
	}

	private function generate_otp( $options = array() )
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

		return $randomString;
		//return $this->db->table('mavis_sms')->select('enabled')->first()->enabled;
	}
}
