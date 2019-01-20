<?php

namespace parser\Controllers\PostEngine;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use parser\Models\PostBuffer;
use parser\Models\PostLog;
use parser\Controllers\Controller;

class PostEngine extends Controller
{
  private $error = false;
  private $engine;
  private $debug_flag = false;
  private $path_to_templates = __DIR__ .'/../../../../web/api/app/PHPMailer/EmailTemplates';
  private function debug($message = '', $key = 'echo')
  {
    if (! $this->debug_flag ) return false;
    switch ($key) {
      case 'var_dump':
        var_dump($key);
        break;
      case 'echo':
        echo $message . "\n";
        break;
    }
    return false;
  }
  private function getSmtpSettings()
  {
    return $this->db->connection('api_settings')->table('api_smtp')->select()->first();
  }
  private function authAlertEnabled()
  {
    return $this->notificationSettings();
    //return $this->db->connection('api_settings')->table('api_notification')->select('bad_authentication_enable', 'bad_authorization_enable')->first();
  }
  private function emailList_support($type='')
  {
    // code...
  }
  private function emailList($type = '')
  {
    if (empty($type)) return [];

    $extra_list = $this->db->connection('api_settings')->table('api_notification')->select($type . '_email_list')->first();
    $group_list = $this->db->connection('api_settings')->table('api_user_groups')->select('id')->where($type .  '_notice','=',1)->get()->toArray();
    $group_list_id = [];
    foreach ($group_list as $value) {
      $group_list_id[count($group_list_id)] = $value->id;
    }
    $user_list = $this->db->connection('api_settings')->table('api_users')->select('email')->where([[ $type . '_notice','=',1],['email','<>','']])->
    orWhere(function($subquery)  use ($group_list_id){
        $subquery->where('email','<>','');
        $subquery->whereIn('group', $group_list_id);
      }
      )->get()->toArray();
    $user_list_email = [];
    foreach ($user_list as $value) {
      $user_list_email[count($user_list_email)] = $value->email;
    }
    //var_dump($user_list_email);
    $extra_list_type = $type . '_email_list';
    $result = array_unique( array_merge($user_list_email, array_filter( explode('; ', $extra_list->$extra_list_type), function($value) { return $value !== ''; }) ) );
    //var_dump($result);
    return $result;
  }
  public function run($params = [])
  {
    if ( isset($params['type']) ){
      $check = $this->authAlertEnabled();
      $type_enable = $params['type'] . '_enable';
      if ( ! $check[$type_enable] ) return false;
    }
    $settings = $this->getSmtpSettings();
    if (!$settings) return false;
    if (!$settings->smtp_servers OR !$settings->smtp_port) return false;
    if ($settings->smtp_auth AND (!$settings->smtp_username OR !$settings->smtp_password)) return false;
    $mail = new PHPMailer(true);

    $mail->Host = ( isset($settings->smtp_servers) ) ? $settings->smtp_servers : 'smtp.example.com';
    if ( isset($settings->smtp_username) ) $mail->Username = $settings->smtp_username;
    if ( isset($settings->smtp_password) ) $mail->Password = $settings->smtp_password;
    $mail->Port = ( isset($settings->smtp_port) ) ? $settings->smtp_port : 465;
    if ( isset($settings->smtp_secure) ) $mail->SMTPSecure = $settings->smtp_secure;
    if ( isset($settings->smtp_auth) ) $mail->SMTPAuth = $settings->smtp_auth;
    $mail->setFrom($settings->smtp_from, 'TacacsGUI');
    $mail->SMTPAutoTLS = ( isset($settings->smtp_autotls) ) ? $settings->smtp_autotls : false;
    $mail->Subject = 'Hello From TacacsGUI';
    $mail->Body    = 'Something goes <b>wrong!</b>';
    $mail->AltBody = '';
    $mail->isHTML(true); // Set email format to HTML
    $mail->isSMTP(); // Set mailer to use SMTP


    $this->engine = $mail;
    return true;
  }
  public function setAddresses($type = 'default')
  {
    if ($type == 'default') return false;
    $list = $this->emailList($type);
    foreach ($list as $email) {
      $this->engine->addAddress($email);
    }
    return true;
  }
  public function sendAlert($data = [])
  {
    $postLogData = $data;
    if ( !isset($data['type']) ) $data['type'] = '';
    if (! $this->setAddresses($data['type'])) return false;
    $this->engine->Subject = (isset($data['title'])) ? $data['title'] : 'Alert!';
    extract($data);
    ob_start();
    include( $this->path_to_templates . '/alert.php' );
    $this->engine->Body = ob_get_clean();
    if ( ! $this->postBuffer($postLogData) ) return false;
    $this->debug('sendAlert send messege');
    $postLogData['status'] = $this->engine->send();
    $postLogData['receivers'] = implode(',', $this->emailList($data['type']));
    $this->postLogCreat( $postLogData );
    return true;
  }
  private function postLogCreat($data = [])
  {
    $postLog = [];
    $postLog['server'] = ( isset($data['server']) ) ? $data['server'] : 'undefined';
    $postLog['date'] = ( isset($data['date']) ) ? $data['date'] : 'undefined';
    $postLog['type'] = ( isset($data['type']) ) ? $data['type'] : 'undefined';
    $postLog['username'] = ( isset($data['username']) ) ? $data['username'] : 'undefined';
    $postLog['user_ipaddr'] = ( isset($data['NAC']) ) ? $data['NAC'] : 'undefined';
    $postLog['device_ipaddr'] = ( isset($data['NAS']) ) ? $data['NAS'] : 'undefined';
    $postLog['receivers'] = ( isset($data['receivers']) ) ? $data['receivers'] : 'undefined';
    $postLog['status'] = ( isset($data['status']) ) ? $data['status'] : 'undefined';
    PostLog::create( $postLog );
  }
  private function postBuffer($data = [])
  {
    $postLog['server'] = ( isset($data['server']) ) ? $data['server'] : 'undefined';
    $postLog['date'] = trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") );
    $postLog['type'] = ( isset($data['type']) ) ? $data['type'] : 'undefined';
    $postLog['username'] = ( isset($data['username']) ) ? $data['username'] : 'undefined';
    $postLog['user_ipaddr'] = ( isset($data['NAC']) ) ? $data['NAC'] : 'undefined';
    $postLog['device_ipaddr'] = ( isset($data['NAS']) ) ? $data['NAS'] : 'undefined';
    $settings = $this->db->connection('api_settings')->table('api_notification')->select()->first();
    $this->debug('postBuffer type: ' . $postLog['type']);
    $this->postBufferCheckInterval($postLog['type']);

    $buffer = PostBuffer::where([['user_ipaddr', '=', $data['NAC']],['type','=',$data['type']]]);
    $type_count = $data['type'] . '_count';
    if ( ! $buffer->count() )
    {
      $this->debug('postBuffer notFound: ' . $data['NAC']);
      if ( $settings->$type_count > 1 ) $postLog['date'] = null;
      $postLog['count'] = 1;
      $buffer = PostBuffer::create( $postLog );
      $this->debug( "postBuffer Configured count " . $settings->$type_count );
      if ( $settings->$type_count <= 1 ) return true;
    }
    else
    {
      $line = $buffer->first();
      $this->debug( "postBuffer line_count was: " . $line->count );
      $line->count++;
      $this->debug( "postBuffer line_count now: " . $line->count );
      if ( $settings->$type_count <= $line->count) {
        $this->debug( "postBuffer line_count 0");
        $upadate = ['count'=> 0];
        $this->debug( "postBuffer line_date: " . empty($line->date) );
        if ( empty($line->date) ) $upadate['date'] = trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") );
        $buffer->update($upadate);
        return true;
      }
      $update_line = $buffer->update(['count'=> $line->count ]);
    }

    if ( ! PostBuffer::where('user_ipaddr', '=', $data['NAC'])->count() )
    return false;
  }
  private function postBufferCheckInterval($type = '')
  {
    $this->debug('postBufferCheckInterval start');
    $this->debug('postBufferCheckInterval type: ' . $type);
    $current_time = trim( shell_exec(TAC_ROOT_PATH . "/main.sh ntp get-time") );
    $interval = $this->db->connection('api_settings')->table('api_notification')->select($type . '_interval')->first();
    $type_interval = $type . '_interval';
    $interval = $interval->$type_interval;
    $this->debug('postBufferCheckInterval interval: ' . $interval);
    $date_interval = date('Y-m-d H:i:s' , strtotime("-".$interval." minutes", strtotime($current_time) ) );
    $date_created_at = date('Y-m-d H:i:s' , strtotime("-1 minutes", strtotime($current_time) ) );
    $this->debug('postBufferCheckInterval current_time: ' . $current_time);
    $this->debug('postBufferCheckInterval date_interval: ' . $date_interval);
    $this->debug('postBufferCheckInterval date_created_at: ' . $date_created_at);
    $deleted_lines = PostBuffer::where([ ['date', '<', $date_interval], ['type', '=' , $type]])->
    orWhere([ ['date', '=', null], ['created_at', '<', $date_created_at] /*, ['type', '=' , 'bad_authentication']*/ ])->
    delete();
    $this->debug('postBufferCheckInterval deleted_lines: ' . $deleted_lines);
    return true;
  }
}
