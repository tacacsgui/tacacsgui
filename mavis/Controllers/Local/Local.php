<?php

namespace mavis\Controllers\Local;

use mavis\Controllers\Controller;

use \Respect\Validation\Validator as v;

class Local extends Controller
{
  private $user;
  private function dPrefix()
  {
    $date = new \DateTime();
    return  $date->format('Y-m-d H:i:s') . ' Local Module. ';
  }
	public function check()
	{
    //$check_first = $this->db->table('mavis_local')->where('enabled', 1)->count();
    if (! $this->modules[0]->m_local){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Module Disabled' );
      return false;
    }
    if ( ! in_array($this->mavis->getVariable(AV_A_TACTYPE), ['AUTH', 'CHPW']) ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: TACTYPE '.$this->mavis->getVariable(AV_A_TACTYPE).' Unsupported. Exit' );
      return false;
    }
    $this->user = $this->db->table('tac_users')->select('id','login', 'login_flag', 'login_change')->whereRaw("BINARY `username`='{$this->mavis->getUsername()}'")->whereIn('login_flag', [3, 5]);
    $this->mavis->debugIn( $this->dPrefix() . 'Check Status: ' . ( ($this->user->count()) ? 'User Found. Run' : 'User Not Found. Exit' ) );
    return $this->user->count();
  }

  public function run()
  {
    $this->user = $this->user->first();
    if (!$this->user) return false;
    $this->mavis->debugIn( $this->dPrefix() . 'User '.$this->mavis->getUsername().' ID: '. $this->user->id );
    //$this->mavis->debugIn( $this->dPrefix() . 'passwd: '. $this->mavis->getPassword() );
    $this->mavis->debugIn( $this->dPrefix() . 'MAVIS TACTYPE: '. $this->mavis->getVariable(AV_A_TACTYPE) );

    switch ( $this->mavis->getVariable(AV_A_TACTYPE) ) {
      case 'AUTH':
        $this->mavis->debugIn($this->dPrefix() . 'Verification status: ' . ( ( password_verify($this->mavis->getPassword(), $this->user->login) ) ? 'allow' : 'deny' ) );
        if ( password_verify($this->mavis->getPassword(), $this->user->login) )
        {
          $this->mavis->debugIn($this->dPrefix() . 'User Auth Success! Exit.');
          $this->mavis->setVariable(AV_A_COMMENT, 'local auth')->auth();
        }
        else
        {
          $this->mavis->debugIn($this->dPrefix() .'User Access Deny! Exit.');
          $this->mavis->setVariable(AV_A_COMMENT, 'local auth')->result('NAK');
        }
        break;
      case 'CHPW':
        $this->mavis->debugIn($this->dPrefix().'Change password init');
        $settings = $this->db->table('mavis_local')->select('enabled', 'change_passwd_cli')->first();

        if ( ! password_verify($this->mavis->getPassword(), $this->user->login) ) {
          $this->mavis->debugIn($this->dPrefix().'Incorrect Old Password. Exit.');
          $this->mavis->setVariable(AV_A_TACTYPE, AV_V_TACTYPE_AUTH)->result('NAK');
          break;
        }

        if ( $settings->change_passwd_cli AND $this->user->login_change AND password_verify($this->mavis->getPassword(), $this->user->login))
        {
          $validation = $this->validation();

          if ($validation != ''){
            $this->mavis->setVariable(AV_A_USER_RESPONSE, '# ERROR # !!! ATTENTION !!! Password should contain: ' . $validation . ' # ERROR #' );
            $this->mavis->debugIn( $this->dPrefix().'Password policy not met! Exit.' );
            $this->mavis->setVariable(AV_A_TACTYPE, AV_V_TACTYPE_AUTH)->result('NAK');
            break;
          }

          $this->db->table('tac_users')->where([['username', $this->mavis->getUsername()],['id', $this->user->id]])->update([
            'login' => password_hash( $this->mavis->getVariable(AV_A_PASSWORD_NEW), PASSWORD_DEFAULT )
          ]);
          $this->mavis->setVariable(AV_A_USER_RESPONSE, '# Success # Password was changed');
          $this->mavis->setVariable(AV_A_TACTYPE, AV_V_TACTYPE_AUTH);
          $this->mavis->debugIn($this->dPrefix().'Password Changed. User Auth Success! Exit.');
          $this->mavis->auth();
        }
        break;
    }

    return true;
  }

  private function validation($value='')
  {
    $validation = '';
    $policy = $this->db->table('api_password_policy')->select()->first(1);

    $validation .= ( ! v::length($policy->tac_pw_length, 64)->validate( $this->mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' minimum length is '. $policy->tac_pw_length.';' : '';
    $validation .= ( $policy->tac_pw_uppercase AND !v::regex('/[A-Z]/')->validate( $this->mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 uppercase letter;' : '';
    $validation .= ( $policy->tac_pw_lowercase AND !v::regex('/[a-z]/')->validate( $this->mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 lowercase letter;' : '';
    $regex = '/[&\^$%\*\+\.\?\/~!@#=`|(){}[\]:;<>,_-]/'; //$%^&
    $validation .= ( $policy->tac_pw_special AND !v::regex($regex)->validate( $this->mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 special char;' : '';
    $validation .= ( $policy->tac_pw_numbers AND !v::regex('/[0-9]/')->validate( $this->mavis->getVariable(AV_A_PASSWORD_NEW) ) ) ? ' min 1 number;' : '';

    $validation .= ( $policy->tac_pw_same AND $this->mavis->getPassword() == $this->mavis->getVariable(AV_A_PASSWORD_NEW)  ) ? ' password can not be the same;' : '';

    return $validation;
  }
}
