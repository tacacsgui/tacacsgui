<?php 

require __DIR__ . '/../../web/api/config.php';
require __DIR__ . '/../otp-generator/generator.php';

//use otp_gen;

require_once TAC_ROOT_PATH .'/web/api/vendor/php-smpp/php-smpp/smppclient.class.php';
require_once TAC_ROOT_PATH .'/web/api/vendor/php-smpp/php-smpp/gsmencoder.class.php';
require_once TAC_ROOT_PATH .'/web/api/vendor/php-smpp/php-smpp/sockettransport.class.php';

class mavis_smpp extends otp_gen
{
	public $ipaddr;
	public $port;
	public $debug = false;
	public $login;
	public $pass;
	public $srcname;
	public $number;
	public $db;
	
	public function __construct($db = null) {
		$this->db = $db;
	}
	
	public function writeinfo($buffer)
	{
		$this->info.=$buffer;
	}
	
	public function send( $options = array() )
	{	
		$message = (empty($options['message'])) ? 'default' : $options['message'];
		$type = (empty($options['type'])) ? 'sms' : $options['type'];
		$username = (empty($options['username'])) ? '' : $options['username'];
	
		$otp = $this->generate_otp($options);
	
		if ($this->debug) {
			echo 'IP: '.$this->ipaddr;
			echo '. Port: '.$this->port."\n";
			echo 'Login: '.$this->login."\n";
			echo 'SrcName: '.$this->srcname."\n";
			echo 'Number: '.$this->number."\n";
			echo 'OTP: '.$otp."\n";
			//var_dump($options);
		}
		
		switch ($message) {
			case "otp":
				$message = "TacacsGUI Auth\n use OTP: ".$otp;
				break;
			default:
				$message = 'Hello, it is TacacsGUI!';
		}
		// Construct transport and client
		$transport = new SocketTransport(array($this->ipaddr),$this->port);
		
		$transport->setRecvTimeout(10000);
		$smpp = new SmppClient($transport);
		
		// Activate binary hex-output of server interaction
		$smpp->debug = $this->debug;
		$transport->debug = $this->debug;
		
		// Open the connection
		$transport->open();
		$smpp->bindTransmitter($this->login,$this->pass);
		
		// Optional connection specific overrides
		SmppClient::$sms_null_terminate_octetstrings = false;
		//SmppClient::$csms_method = SmppClient::CSMS_PAYLOAD;
		//SmppClient::$sms_registered_delivery_flag = SMPP::REG_DELIVERY_SMSC_BOTH;
		
		// Prepare message
		$encodedMessage = GsmEncoder::utf8_to_gsm0338($message);
		$from = new SmppAddress($this->srcname,SMPP::TON_ALPHANUMERIC);
		$to = new SmppAddress($this->number,SMPP::TON_INTERNATIONAL,SMPP::NPI_E164);
		$tags=array();
		// Send
		$info = $smpp->sendSMS($from,$to,$encodedMessage,$tags);
		
		// Close connection
		$smpp->close();
		
		return true;
	}
}
		
		