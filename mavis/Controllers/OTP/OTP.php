<?php

namespace mavis\Controllers\OTP;

use mavis\Controllers\Controller;

use OTPHP\TOTP as TOTP;
use ParagonIE\ConstantTime\Base32;

class OTP extends Controller
{
  private $user;
  private function dPrefix()
  {
    $date = new \DateTime();
    return  $date->format('Y-m-d H:i:s') . ' OTP Module. ';
  }
	public function check()
	{
    $check_first = $this->db->table('mavis_otp')->where('enabled', 1)->count();
    if (!$check_first){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Module Disabled' );
      return false;
    }
    if ( ! in_array($this->mavis->getVariable(AV_A_TACTYPE), ['AUTH']) ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: TACTYPE '.$this->mavis->getVariable(AV_A_TACTYPE).' Unsupported. Exit' );
      return false;
    }
    $this->user = $this->db->table('tac_users')->select('mavis_otp_secret','mavis_otp_period','mavis_otp_digits','mavis_otp_digest','group')->where([['username', $this->mavis->getUsername()],['mavis_otp_enabled', 1],['mavis_sms_enabled', 0]]);
    $this->mavis->debugIn( $this->dPrefix() . 'Check Status: ' . ( ($this->user->count()) ? 'User Found. Run' : 'User Not Found. Exit' ) );
    return $this->user->count();
  }
  public function run()
  {
    $this->user = $this->user->first();
    $this->mavis->result('NAK');
    $this->mavis->debugIn( $this->dPrefix() .'User '.$this->mavis->getUsername().' found! Create the key.');
    $this->mavis->debugIn( $this->dPrefix() . 'MAVIS TACTYPE: '. $this->mavis->getVariable(AV_A_TACTYPE) );
    if ( $this->mavis->getVariable(AV_A_TACTYPE) !== 'AUTH' ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Only AUTH allowed! Exit' );
      return false;
    }
		$otp = TOTP::create(
				$this->user->mavis_otp_secret,
				$this->user->mavis_otp_period, // The period (30 seconds)
				$this->user->mavis_otp_digest, // The digest algorithm
				$this->user->mavis_otp_digits
		);
		$verification = $otp->verify( $this->mavis->getPassword() );
		$this->mavis->debugIn( $this->dPrefix() .'Verification status: ' . ( ( $verification ) ? 'allow' : 'deny' ) );
    if ($verification)
    {
      $this->mavis->debugIn( $this->dPrefix() .'User Auth Success! Exit.');
      $this->mavis->auth();
    }
    else
    {
      $this->mavis->debugIn( $this->dPrefix() .'User Access Deny! Exit.');
      return false;
    }
  }
}
