<?php

namespace mavis\Controllers\SMS;

use mavis\Controllers\Controller;
use mavis\Controllers\TGUIOTP\TGUIOTP;

require_once TAC_ROOT_PATH .'/web/api/vendor/php-smpp/php-smpp/smppclient.class.php';
require_once TAC_ROOT_PATH .'/web/api/vendor/php-smpp/php-smpp/gsmencoder.class.php';
require_once TAC_ROOT_PATH .'/web/api/vendor/php-smpp/php-smpp/sockettransport.class.php';

use SocketTransport;
use SmppClient;
use GsmEncoder;
use SmppAddress;
use SMPP;

class SMS extends Controller
{
  private $user;
  private $tguiotp;

  private function dPrefix()
  {
    $date = new \DateTime();
    return  $date->format('Y-m-d H:i:s') . ' SMS Module. ';
  }
	public function check()
	{
    //$check_first = $this->db->table('mavis_sms')->where('enabled', 1)->count();
    if (! $this->modules[0]->m_sms ){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Module Disabled' );
      return false;
    }
    if ( ! in_array($this->mavis->getVariable(AV_A_TACTYPE), ['CHAL','AUTH', 'CHPW']) ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: TACTYPE '.$this->mavis->getVariable(AV_A_TACTYPE).' Unsupported. Exit' );
      return false;
    }
    $this->user = $this->db->table('tac_users')->select('username','mavis_sms_number','group')->whereRaw("BINARY `username`='{$this->mavis->getUsername()}'")->where('login_flag', 30);
    $this->mavis->debugIn( $this->dPrefix() . 'Check Status: ' . ( ($this->user->count()) ? 'User Found. Run' : 'User Not Found. Exit' ) );
    return $this->user->count();
  }
  public function run()
  {

    $this->user = $this->user->first();
    $this->mavis->result('NAK');
    $this->mavis->debugIn( $this->dPrefix() .'User '.$this->mavis->getUsername().' found!');
    $this->mavis->debugIn( $this->dPrefix() . 'MAVIS TACTYPE: '. $this->mavis->getVariable(AV_A_TACTYPE) );

    switch ( $this->mavis->getVariable(AV_A_TACTYPE) ) {
			case 'CHAL':
				$this->sendOtp();

				break;
			case 'AUTH':
				$verification = $this->container->tguiotp->validate( $this->mavis->getUsername(), $this->mavis->getPassword() );

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
				break;
			case 'CHPW':

				$this->sendOtp();
				break;
		}

  }

  private function sendOtp( $options = array() )
  {
    $this->mavis->debugIn( $this->dPrefix() .'Send SMS Start!');
    $set = $this->db->table('mavis_sms')->select()->first();
    $message = (empty($options['message'])) ? 'default' : $options['message'];
		$type = (empty($options['type'])) ? 'sms' : $options['type'];
		$username = $this->user->username;
    $otp = '';
    if ( empty($this->user->mavis_sms_number) ) return false;
		$number = $this->user->mavis_sms_number;
    $this->mavis->debugIn( $this->dPrefix() .'Send SMS Start. Number ' . $number);

    $otp = $this->container->tguiotp->otpMake(['username' => $username, 'destination' => $number]); //$this->generate_otp($options);
    if (!$otp) return false;
    $message = "TacacsGUI. Use OTP: " . $otp . "\nHave a nice day!";

		// Construct transport and client
		$transport = new SocketTransport(array($set->ipaddr),$set->port);

		$transport->setRecvTimeout(10000);
		$smpp = new SmppClient($transport);

		// Activate binary hex-output of server interaction
		//$smpp->debug = true;
		//$transport->debug = true;
    try {

      // Open the connection
  		$transport->open();
  		$smpp->bindTransmitter($set->login,$set->pass);

    } catch (\Exception $e) {
      //echo $e->getMessage();
      return false;
    }

    try {

      // Optional connection specific overrides
      SmppClient::$sms_null_terminate_octetstrings = false;
      //SmppClient::$csms_method = SmppClient::CSMS_PAYLOAD;
      //SmppClient::$sms_registered_delivery_flag = SMPP::REG_DELIVERY_SMSC_BOTH;

      // Prepare message
      $encodedMessage = GsmEncoder::utf8_to_gsm0338($message);
      $from = new SmppAddress($set->srcname,SMPP::TON_ALPHANUMERIC);
      $to = new SmppAddress($number,SMPP::TON_INTERNATIONAL,SMPP::NPI_E164);
      $tags=array();
      // Send
      $info = $smpp->sendSMS($from,$to,$encodedMessage,$tags);
      //var_dump( $info );
      // Close connection
      $smpp->close();

    } catch (\Exception $e) {
      return false;
    }



		return true;
  }
}
