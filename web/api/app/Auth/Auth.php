<?php

namespace tgui\Auth;

use Illuminate\Database\Capsule\Manager as Capsule;

use tgui\Models\APIUsers;
use tgui\Models\APIUserGrps;

use Adldap\Adldap as Adldap;
use Adldap\Schemas\ActiveDirectory as ActiveDirectory;
use Adldap\Schemas\OpenLDAP as OpenLDAP;

class Auth
{
#################################################
#####	Get the User #############START###########
	public function user()
	{
		return APIUsers::where('id', $_SESSION['uid'])->first();
	}
#####	Get the User #############END###########
#################################################
#####	Check User Auth #############START###########
	public function check()
	{
		if(!isset($_SESSION['uid'])){
			$_SESSION['error']['authorized']=false;
			$_SESSION['error']['message']='You are not authorized';
			$_SESSION['error']['status']=true;
		} else {
			$_SESSION['error']['authorized']=true;
			$_SESSION['error']['message']='Well done';
			$_SESSION['error']['status']=false;
		};

		return isset($_SESSION['uid']);
	}
#####	Check User Auth #############END###########
#################################################
#####	Attempt User Auth#############START###########
	public function attempt($username, $password)
	{
		//grab the user by username
		$user = APIUsers::where('username', strtolower($username))->first();

		if (!$user){
			if ($this->ldapAuth($username, $password)){
				$_SESSION['error']['message']='123123123123';
				return true;
			}
			$_SESSION['error']['authorized']=false;
			$_SESSION['error']['message']='Username or Password is incorrect';
			$_SESSION['error']['status']=true;
			return false;
		}

		//verify password for user
		if (password_verify($password, $user->password)){
			$_SESSION['uid'] = $user->id;
			$_SESSION['uname'] = $user->username;
			$_SESSION['changePasswd'] = $user->changePasswd;
			$_SESSION['groupId'] = $user->group;
			if ($_SESSION['groupId'] != 0 )
			{
				$group = APIUserGrps::where('id', $user->group )->first();
				$_SESSION['groupRights'] = $group->rights;
			} else {$_SESSION['groupRights'] = 1;}
			$_SESSION['error']['status']=false;
			$_SESSION['error']['authorized']=true;
			return true;
		}

		$_SESSION['error']['authorized']=false;
		$_SESSION['error']['message']='Username or Password is incorrect';
		$_SESSION['error']['status']=true;

		return false;
	}
#####	Attempt User Auth#############END###########
#################################################

	public function ldapAuth($uname = '', $passwd = ''){

		$ldapGroups = Capsule::table('ldap_bind as lb')->leftJoin('ldap_groups as lg','lg.id','=','lb.ldap_id')->
		leftJoin('api_user_groups as aug', 'aug.id','=','lb.api_grp_id')->orderBy('aug.rights', 'asc')->
		whereNotNull('api_grp_id')->select(['lg.dn as dn','aug.name as name', 'aug.rights as rights', 'aug.id as gid']);

		if ( $ldapGroups->count() == 0 ) return false;
		$ldap = Capsule::table('mavis_ldap')->select()->first();

		$username = ( strpos($ldap->user, '@') !== false ) ? $ldap->user : $ldap->user . '@'.( str_replace( ',', '.', preg_replace('/DC=/i', '', $ldap->base) ) );

		$username = ( $ldap->type == 'openldap' ) ? $ldap->user : $username;

		$config = [
			// Mandatory Configuration Options
			'hosts'            => array_map('trim', explode(',', $ldap->hosts) ),
			'base_dn'          => $ldap->base,
			'username'         => $username,
			'password'         => $ldap->password,
			// Optional Configuration Options
			'schema'           => ( $ldap->type == 'openldap' ) ? OpenLDAP::class : ActiveDirectory::class,
			'port'             => $ldap->port,
			'use_ssl'          => !!$ldap->ssl,
			'version'          => 3,
			'timeout'          => 5,
		];

		$ad = new Adldap();

		$ad->addProvider($config);

		try {
				$provider = $ad->connect();

				$search = $provider->search();

				$adUser = ( $ldap->type == 'openldap' ) ?
					$search->select(['*', 'memberof'])->where('objectclass', 'inetOrgPerson')->where( $ldap->filter, $uname )->first()
					:
					$search->select()->where('objectclass', 'user')->
						where( $ldap->filter, $uname )->first();

				if (!$adUser)
					return false;

				$nice_try = false;

        switch ($ldap->type) {
          case 'openldap':
            $dn_attr = ( is_array($adUser->dn) ) ? $adUser->dn[0] : $adUser->dn;
            $nice_try = $ad->auth()->attempt( $dn_attr, $passwd );
            break;

          default:
            $nice_try = $ad->auth()->attempt( $adUser->distinguishedname[0], $passwd );
            break;
        }

        if ( ! $nice_try ) {
          return false;
    		}

				$groupList = [];
				$groupList_fullNames = [];


				if ( $ldap->type == 'openldap' ) {
					//OpenLDAP//
					for ($mgui=0; $mgui < count($adUser->gidnumber); $mgui++) {
						$mainGUI = $search->where('objectclass', 'posixGroup')->where( 'gidNumber', $adUser->gidnumber[$mgui] )->first();
						$groupList_fullNames[] = ( is_array($mainGUI->dn) ) ? $mainGUI->dn[0] : $mainGUI->dn;

						$groupList[] = ( is_array($mainGUI->cn) ) ? $mainGUI->cn[0] : $mainGUI->cn;
					}
					$subGUI = $search->where('objectclass', 'posixGroup')->where( 'memberUid', $uname )->get();
					for ($sgui=0; $sgui < count($subGUI); $sgui++) {
						$group_temp_full = ( is_array($subGUI[$sgui]->dn) ) ? $subGUI[$sgui]->dn[0] : $subGUI[$sgui]->dn;
						$group_temp = ( is_array($subGUI[$sgui]->cn) ) ? $subGUI[$sgui]->cn[0] : $subGUI[$sgui]->cn;
						if ( !in_array( $group_temp, $groupList ) )  $groupList[] = $group_temp;
						if ( !in_array( $group_temp_full, $groupList_fullNames ) ) $groupList_fullNames[] = $group_temp_full;
					}

					if ( is_array(@$adUser->memberOf) ) {
						for ($memOf=0; $memOf < count($adUser->memberof); $memOf++) {
							// $this->mavis->debugIn( $this->dPrefix() . 'User memberof: ' . $adUser->memberof[$memOf] );
							// var_dump($adUser->memberof[$memOf]);
							preg_match_all('/^CN=(.*?),.*/is', $adUser->memberof[$memOf], $groupName);
							// var_dump($groupName);
							$groupList[] = $groupName[1][0];
						}
						$groupList_fullNames = array_merge($groupList_fullNames, $adUser->memberof);
					}

					//var_dump($groupList); var_dump($groupList_fullNames); die; //gidnumber $search->where( $ldap->filter, $uname )->first()
				} else {
					//General LDAP//
					if ( is_array(@$adUser->memberOf) ) for ($i=0; $i < count($adUser->memberof); $i++) {
						preg_match_all('/^CN=(.*?),.*/s', $adUser->memberof[$i], $groupName);
						$groupList[] = $groupName[1][0];
					}

					$groupList_fullNames = $adUser->memberof;

				}

				$AUG = $ldapGroups->whereIn('lg.dn',$groupList_fullNames)->first();

				if ($AUG->rights){
					$_SESSION['uid'] = 0;
					$_SESSION['ldap'] = true;
					$_SESSION['uname'] = $uname;
					$_SESSION['changePasswd'] = 0;
					$_SESSION['groupId'] = $AUG->gid;
					$_SESSION['groupRights'] = $AUG->rights;
					$_SESSION['error']['status']=false;
					$_SESSION['error']['authorized']=true;
					$_SESSION['user']=[
						'bad_authentication_notice' => 0,
						'bad_authorization_notice' => 0,
						'changePasswd' => 0,
						'cmd_type' => 0,
						'created_at' => "",
						'email' => "",
						'firstname' => '',
						'group' => $AUG->gid,
						'id' => 0,
						'position' => "",
						'surname' => '',
						'updated_at' => "",
						'username' => $uname
					];
					//var_dump($adUser);die;
					return true;
				}

				//var_dump(  );die; //->whereIn('lg.dn',$groupList)->
				// var_dump( $groupList_fullNames );die; //

				return false;
		} catch (\Adldap\Auth\BindException $e) {
				return false;
		}

		return false;
	}
}//END OF CALSS//
