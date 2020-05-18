<?php

namespace mavis\Controllers\LDAP;

use mavis\Controllers\Controller;

use Respect\Validation\Validator as v;
use Adldap\Adldap as Adldap;
use Adldap\Schemas\ActiveDirectory as ActiveDirectory;
use Adldap\Schemas\OpenLDAP as OpenLDAP;


class LDAP extends Controller
{
  private $provider;
  private $ldap;
  private $ad;
  private $adUser;
  private function dPrefix()
  {
    $date = new \DateTime();
    return  $date->format('Y-m-d H:i:s') . ' LDAP Module. ';
  }
	public function check()
	{
    //$check_first = $this->db->table('mavis_ldap')->where('enabled', 1)->count();
    if ( ! $this->modules[0]->m_ldap ){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Module Disabled' );
      return false;
    }
    if ( ! in_array($this->mavis->getVariable(AV_A_TACTYPE), ['AUTH', 'INFO']) ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: TACTYPE '.$this->mavis->getVariable(AV_A_TACTYPE).' Unsupported. Exit' );
      return false;
    }
    if ( !$this->conn() ){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Can not connect to ldap server' );
      return false;
    }
    $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Connected Successful' );
    if ( !$this->search() ){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: User Not Found' );
      return false;
    }
    if ($this->adUser){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: User Found' );
      $this->mavis->result('NFD');
      return true;
    }
    return false;
  }

  public function run()
  {
    $this->mavis->debugIn( $this->dPrefix() .'DN: '. $this->adUser->distinguishedname[0]);
    //var_dump($this->adUser->gidnumber);
    $this->mavis->result('NAK');
    //var_dump($this->adUser->dn[0]); die;
    //var_dump( $this->ad->auth()->attempt( $this->adUser->dn[0], $this->mavis->getPassword() ) ); die;

    if ( $this->mavis->getVariable(AV_A_TACTYPE) == 'AUTH' ) try {
        $nice_try = false;
        switch ($this->ldap->type) {
          case 'openldap':
            $dn_attr = ( is_array($this->adUser->dn) ) ? $this->adUser->dn[0] : $this->adUser->dn;
            $nice_try = $this->ad->auth()->attempt( $dn_attr, $this->mavis->getPassword() );
            break;

          default:
            $nice_try = $this->ad->auth()->attempt( $this->adUser->distinguishedname[0], $this->mavis->getPassword() );
            break;
        }

        if ( ! $nice_try ) {
    			$this->mavis->debugIn( $this->dPrefix() .'Auth FAIL!');
          return false;
    		}

    } catch (Adldap\Auth\UsernameRequiredException $e) {
        // The user didn't supply a username.
        $this->mavis->debugIn( $this->dPrefix() .'Auth FAIL! Exit.');
        return false;
    } catch (Adldap\Auth\PasswordRequiredException $e) {
        // The user didn't supply a password.
        $this->mavis->debugIn( $this->dPrefix() .'Auth FAIL! Exit.');
        return false;
    }

    //var_dump($this->adUser);

    $this->mavis->debugIn( $this->dPrefix() . ( ($this->mavis->getVariable(AV_A_TACTYPE) == 'AUTH') ? 'Auth Success!' : 'Auth via INFO!') );

    $usr = $this->db->table('tac_users')->select('login_flag')->whereRaw("BINARY `username`='{$this->mavis->getUsername()}'")->where([['login_flag', 20],['disabled',0]]);
    $usr_local = $usr->count();
    $this->mavis->debugIn( $this->dPrefix() .'Does it locally predefined? '. ( ( $usr_local ) ? 'Yes' : 'No') );

    if ( $usr_local == 0 ){

      $this->mavis->debugIn( $this->dPrefix() .'Get Groups');

      $search = $this->provider->search();

      $this->adUser->gidnumber = ( is_array($this->adUser->gidnumber) ) ? $this->adUser->gidnumber : [$this->adUser->gidnumber];

      $groupList = [];
      $groupList_fullNames = [];

      if ( $this->ldap->type == 'openldap' ) {
        //OpenLDAP//
        // var_dump($this->adUser->gidnumber);
        for ($mgui=0; $mgui < count($this->adUser->gidnumber); $mgui++) {
          $mainGUI = $search->where('objectclass', 'posixGroup')->where( 'gidNumber', $this->adUser->gidnumber[$mgui] )->first();
          if (!$mainGUI) continue;
          $groupList_fullNames[] = ( is_array($mainGUI->dn) ) ? $mainGUI->dn[0] : $mainGUI->dn;

          $this->mavis->debugIn( $this->dPrefix() .'CN: '. ( ( is_array($mainGUI->cn) ) ? $mainGUI->cn[0] : $mainGUI->cn ) );
          $groupList[] = ( is_array($mainGUI->cn) ) ? $mainGUI->cn[0] : $mainGUI->cn;
        }

        $subGUI = $search->where('objectclass', 'posixGroup')->where( 'memberUid', $this->mavis->getUsername() )->get();
        for ($sgui=0; $sgui < count($subGUI); $sgui++) {
          $group_temp_full = ( is_array($subGUI[$sgui]->dn) ) ? $subGUI[$sgui]->dn[0] : $subGUI[$sgui]->dn;
          $group_temp = ( is_array($subGUI[$sgui]->cn) ) ? $subGUI[$sgui]->cn[0] : $subGUI[$sgui]->cn;
          if ( !in_array( $group_temp, $groupList ) )  $groupList[] = $group_temp;
          if ( !in_array( $group_temp_full, $groupList_fullNames ) ) $groupList_fullNames[] = $group_temp_full;
        }

        if ( is_array(@$this->adUser->memberOf) ) {
          for ($memOf=0; $memOf < count($this->adUser->memberof); $memOf++) {
            $this->mavis->debugIn( $this->dPrefix() . 'User memberof: ' . $this->adUser->memberof[$memOf] );
            // var_dump($this->adUser->memberof[$memOf]);
          	preg_match_all('/^CN=(.*?),.*/is', $this->adUser->memberof[$memOf], $groupName);
            // var_dump($groupName);
          	$groupList[] = $groupName[1][0];
          }
          $groupList_fullNames = array_merge($groupList_fullNames, $this->adUser->memberof);
        }

        //var_dump($groupList); var_dump($groupList_fullNames); die; //gidnumber $search->where( $this->ldap->filter, $this->mavis->getUsername() )->first()
      } else {
        //General LDAP//
        $this->mavis->debugIn( $this->dPrefix() . ( is_array(@$this->adUser->memberof) ? 'memberof, exist' : 'memberof, notexist') );
        if ( is_array(@$this->adUser->memberOf) ) for ($i=0; $i < count($this->adUser->memberof); $i++) {
          $this->mavis->debugIn( $this->dPrefix() . 'User memberof: ' . $this->adUser->memberof[$i] );
        	preg_match_all('/^CN=(.*?),.*/s', $this->adUser->memberof[$i], $groupName);
        	$groupList[] = $groupName[1][0];
        }

        $groupList_fullNames = $this->adUser->memberof;

      }

      $this->mavis->debugIn( $this->dPrefix() . 'Trying to find group match...' );
      $groupList_result = [];
      if ( ! empty($groupList) ){
      	$user_grps = $this->db->table('tac_user_groups as tug')->select('name')->
            leftJoin('ldap_bind as lb', 'lb.tac_grp_id','=','tug.id')->
            leftJoin('ldap_groups as lg', 'lg.id','=','lb.ldap_id')->
      			where(function ($query) use ($groupList_fullNames, $groupList) {
      					for ($i=0; $i < count($groupList_fullNames) ; $i++) {
      						if ( $i == 0 ) { $query->where('lg.dn', 'like', '%'.$groupList_fullNames[$i].'%')->orWhere('name', $groupList[$i]); continue; }
      						$query->orWhere('lg.dn', 'LIKE', '%'.$groupList_fullNames[$i].'%')->orWhere('name', $groupList[$i]);
      					}
      	    })->get()->toArray();
      	foreach ($user_grps as $ugrp) {
      		//if ( ! in_array($ugrp->name, $groupList) ) $groupList[] = $ugrp->name;
      		$groupList_result[] = $ugrp->name;
      	}
      }

      if ( ! count( $groupList_result ) ){
      	$this->mavis->debugIn( $this->dPrefix() .'Group Not found! Exit.');
      	return false;
      }

      $this->mavis->debugIn( $this->dPrefix() .'Group List: '. implode(',', $groupList_result));
      $this->mavis->setMempership( $groupList_result , $this->ldap->group_selection );

      $tacprofile = '';
      if ($this->ldap->enable_login) $tacprofile .= ' enable = login ';
      if ($this->ldap->pap_login) $tacprofile .= ' pap = login ';
      if ( !empty($tacprofile) ) $tacprofile = ' login = mavis ' . $tacprofile;

      if ($this->ldap->message_flag) $tacprofile .= ' message = "\nHello '.$this->adUser->cn[0].'.\nYour ip address is %%c, you are connected to %%r.\nToday is %F.\n\nHave a nice day! " ';

      if ( !empty($tacprofile) ) $this->mavis->setVariable(AV_A_TACPROFILE, '{'.$tacprofile.'}');

    } //search group end


    $this->mavis->auth();
  }

  private function conn()
  {
    $this->ldap = $this->db->table('mavis_ldap')->select()->first();

    $username = ( strpos($this->ldap->user, '@') !== false ) ? $this->ldap->user : $this->ldap->user . '@'.( str_replace( ',', '.', preg_replace('/DC=/i', '', $this->ldap->base) ) );

		$username = ( $this->ldap->type == 'openldap' ) ? $this->ldap->user : $username;

    $config = [
    	// Mandatory Configuration Options
    	'hosts'            => array_map('trim', explode(',', $this->ldap->hosts) ),
    	'base_dn'          => $this->ldap->base,
    	'username'         => $username,
    	'password'         => $this->ldap->password,
    	// Optional Configuration Options
    	'schema'           => ( $this->ldap->type == 'openldap' ) ? OpenLDAP::class : ActiveDirectory::class,
    	'port'             => $this->ldap->port,
      'use_ssl'          => !!$this->ldap->ssl,
    	'version'          => 3,
    	'timeout'          => 5,
    ];

    $this->mavis->debugIn( $this->dPrefix() .'Set LDAP Config');

    $this->ad = new Adldap();

    $this->ad->addProvider($config);

    try {
    		$this->mavis->debugIn( $this->dPrefix() .'Attempt to connect');
        $this->provider = $this->ad->connect();
    } catch (\Adldap\Auth\BindException $e) {
    		$this->mavis->debugIn( $this->dPrefix() .'Connect FAIL! '.$e->getMessage().' Exit.');
        return false;
    }
    return true;
  }
  private function search()
  {
    $search = $this->provider->search();

    $this->adUser = ( $this->ldap->type == 'openldap' ) ?
      $search->select(['*', 'memberof'])->where('objectclass', 'inetOrgPerson')->where( $this->ldap->filter, $this->mavis->getUsername() )->first()
      :
      $search->select()->where('objectclass', 'user')->
        where( $this->ldap->filter, $this->mavis->getUsername() )->first();

    if ( !$this->adUser ) return false;
    if ( $this->adUser->getAttribute('shadowexpire') )
      if ( $this->adUser->getAttribute('shadowexpire', 0) AND $this->adUser->getAttribute('shadowexpire', 0) * 86400 < time()){
          $this->mavis->debugIn( $this->dPrefix() .'shadowExpire set: '. ( $this->adUser->getAttribute('shadowexpire', 0) * 86400 ) );
          $this->mavis->debugIn( $this->dPrefix() .'Now: '. time() );
          $this->mavis->debugIn( $this->dPrefix() .'Password expired! Exit.');
          $this->mavis->setVariable(AV_A_USER_RESPONSE, 'Password has expired' );
          return false;
      }
    return true;
  }
}
