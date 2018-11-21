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
    if ( isset($params['smtp_username']) ) $this->mail->Username = $params['smtp_username'];
    if ( isset($params['smtp_password']) ) $this->mail->Password = $params['smtp_password'];
    $this->mail->Port = ( isset($params['smtp_port']) ) ? $params['smtp_port'] : 465;
    if ( isset($params['smtp_secure']) ) $this->mail->SMTPSecure = $params['smtp_secure'];
    if ( isset($params['smtp_auth']) ) $this->mail->SMTPAuth = $params['smtp_auth'];
    $this->mail->setFrom($params['smtp_from'], 'TacacsGUI');
    $this->mail->SMTPAutoTLS = ( isset($params['smtp_autotls']) ) ? $params['smtp_autotls'] : false;
    $this->mail->Subject = 'Hello From TacacsGUI';
    $this->mail->Body    = 'Something goes <b>wrong!</b>';
    $this->mail->AltBody = '';
    $this->mail->isHTML(true); // Set email format to HTML
    $this->mail->isSMTP(); // Set mailer to use SMTP
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
                                              

        $this->mail->send();
        return 'Message has been sent';
    } catch (Exception $e) {
        return 'Message could not be sent. Mailer Error: '. $this->mail->ErrorInfo;
    }
  }
}
