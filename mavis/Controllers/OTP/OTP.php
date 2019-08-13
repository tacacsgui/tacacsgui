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
    //$check_first = $this->db->table('mavis_otp')->where('enabled', 1)->count();
    if (! $this->modules[0]->m_otp ){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Module Disabled' );
      return false;
    }
    if ( ! in_array($this->mavis->getVariable(AV_A_TACTYPE), ['AUTH']) ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: TACTYPE '.$this->mavis->getVariable(AV_A_TACTYPE).' Unsupported. Exit' );
      return false;
    }
    $this->user = $this->db->table('tac_users')->
        select('mavis_otp_secret','id')->
        // leftJoin('tac_bind_usrGrp as tb', 'tb.user_id', '=', 'tu.id')->
        whereRaw("BINARY `username`='{$this->mavis->getUsername()}'")->whereIn('login_flag', [10, 12]);
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
    $this->mavis->debugIn( $this->dPrefix() .'Global OTP: '.json_encode ( $this->otp_settings ));

    $otp = TOTP::create(
        $this->user->mavis_otp_secret,
        $this->otp_settings->period,//$this->user->mavis_otp_period, // The period (30 seconds)
        $this->otp_settings->digest,//$this->user->mavis_otp_digest, // The digest algorithm
        $this->otp_settings->digits//$this->user->mavis_otp_digits
    );
    $verification = false;
    try {
      $verification = $otp->verify( $this->mavis->getPassword() );
    } catch (\Exception $e) {
      $this->mavis->debugIn( $this->dPrefix() .'OTP Secret: '.json_encode ( $this->user->mavis_otp_secret ));
      $this->mavis->debugIn( $this->dPrefix() .'OTP Error: '.json_encode ( $e ));
    }


		//$verification = $otp->verify( $this->mavis->getPassword() );
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
