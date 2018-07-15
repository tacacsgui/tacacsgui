<?php

namespace tgui\PHPMailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailEngine
{
  private $smtp_servers = 'smtp.example.com';
  private $smtp_username = '';
  private $smtp_password = '';
  private $smtp_port = 465;
  private $smtp_secure = 'SSL';
  private $smtp_auth = true;
  private $smtp_debug = false;
  public $mail;

  public function __construct($params = [])
  {
    $this->mail = new PHPMailer(true);

    $this->mail->Host = ( isset($params['smtp_servers']) ) ? $params['smtp_servers'] : 'smtp.example.com';
    $this->mail->Username = ( isset($params['smtp_username']) ) ? $params['smtp_username'] : '';
    $this->mail->Password = ( isset($params['smtp_password']) ) ? $params['smtp_password'] : '';
    $this->mail->Port = ( isset($params['smtp_port']) ) ? $params['smtp_port'] : 465;
    $this->mail->SMTPSecure = ( isset($params['smtp_secure']) ) ? $params['smtp_secure'] : 'ssl';
    $this->mail->SMTPAuth = ( isset($params['smtp_auth']) ) ? $params['smtp_auth'] : true;

    $this->mail->Subject = 'Hello From TacacsGUI';
    $this->mail->Body    = 'Something goes <b>wrong!</b>';
    $this->mail->AltBody = '';
  }

  public function setTemplate($name = 'test', $variables = [])
  {
    if ( isset( $this->default_titles[$name]) ) $this->mail->Subject = $this->default_titles[$name];

    // if ($name == 'feedback') $this->mail->Subject = $this->default_titles[$name] .' '. ucfirst($variables['type']);

    extract($variables);
    ob_start();
    include( __DIR__ . '/EmailTemplates/'.$name.'.php');
    $this->mail->Body = ob_get_clean();

    return $this;
  }

  public function debug()
  {
    $this->smtp_debug = true;

    return $this;
  }

  public function send()
  {
    try {
        //Server settings
        if ($this->smtp_debug) $this->mail->SMTPDebug = 2;          // Enable verbose debug output
        $this->mail->isSMTP();                                      // Set mailer to use SMTP

        //Recipients
        $this->mail->setFrom($this->mail->Username, 'TacacsGUI');
        //$this->mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient


        //Content
        $this->mail->isHTML(true);                                  // Set email format to HTML

        $this->mail->send();
        return 'Message has been sent';
    } catch (Exception $e) {
        return 'Message could not be sent. Mailer Error: '. $this->mail->ErrorInfo;
    }
  }
}
