<?php

namespace mavis\Controllers\LDAP;

use mavis\Controllers\Controller;

use Respect\Validation\Validator as v;
use Adldap\Adldap as Adldap;
use Adldap\Schemas\ActiveDirectory as ActiveDirectory;


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
    $check_first = $this->db->table('mavis_ldap')->where('enabled', 1)->count();
    if (!$check_first){
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: Module Disabled' );
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
    if ( ! in_array($this->mavis->getVariable(AV_A_TACTYPE), ['AUTH']) ) {
      $this->mavis->debugIn( $this->dPrefix() . 'Check Status: TACTYPE '.$this->mavis->getVariable(AV_A_TACTYPE).' Unsupported. Exit' );
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
    $this->mavis->result('NAK');
    try {

        if ( ! $this->ad->auth()->attempt( $this->adUser->distinguishedname[0], $this->mavis->getPassword() ) ) {
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

    $this->mavis->debugIn( $this->dPrefix() .'Auth Success!');

    $this->mavis->debugIn( $this->dPrefix() .'Get Groups');
    $groupList = [];
    for ($i=0; $i < count($this->adUser->memberof); $i++) {
    	preg_match_all('/^CN=(.*?),.*/s', $this->adUser->memberof[$i], $groupName);
    	$groupList[] = $groupName[1][0];
    }

    $groupList_fullNames = $this->adUser->memberof;
    $groupList_result = [];
    if ( ! empty($groupList) ){
    	$user_grps = $this->db->table('tac_user_groups')->select('name')->
    			where(function ($query) use ($groupList_fullNames, $groupList) {
    					for ($i=0; $i < count($groupList_fullNames) ; $i++) {
    						if ( $i == 0 ) { $query->where('ldap_groups', 'like', '%'.$groupList_fullNames[$i].'%')->orWhere('name', $groupList[$i]); continue; }
    						$query->orWhere('ldap_groups', 'LIKE', '%'.$groupList_fullNames[$i].'%')->orWhere('name', $groupList[$i]);
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
    $this->mavis->setMempership($groupList_result);

    $this->mavis->auth();
  }

  private function conn()
  {
    $this->ldap = $this->db->table('mavis_ldap')->select()->first();

    $config = [
    	// Mandatory Configuration Options
    	'hosts'            => array_map('trim', explode(',', $this->ldap->hosts) ),
    	'base_dn'          => $this->ldap->base,
    	'username'         => ( strpos($this->ldap->user, '@') !== false ) ? $this->ldap->user : $this->ldap->user . '@'.( str_replace( ',', '.', preg_replace('/DC=/i', '', $this->ldap->base) ) ),
    	'password'         => $this->ldap->password,
    	// Optional Configuration Options
    	'schema'           => ActiveDirectory::class,
    	'port'             => $this->ldap->port,
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

    $this->adUser = $search->select(['distinguishedname', 'name', 'memberOf'])->where('objectclass', 'user')->where( $this->ldap->filter, $this->mavis->getUsername() )->first();

    if ( !$this->adUser ) return false;

    return true;
  }
}
