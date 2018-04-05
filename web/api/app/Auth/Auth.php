<?php

namespace tgui\Auth;

use tgui\Models\APIUsers;
use tgui\Models\APIUserGrps;

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
}//END OF CALSS//


