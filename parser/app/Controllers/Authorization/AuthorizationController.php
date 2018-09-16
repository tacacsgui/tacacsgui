<?php

namespace parser\Controllers\Authorization;

use parser\Models\Authorization;
use parser\Controllers\Controller;

class AuthorizationController extends Controller
{
	public function parser()
	{

		$logLineArray=explode('|!|',$this->logLine);

		$returnData=array();

		$arrayLength=count($logLineArray);

		for ($x = 0; $x < $arrayLength; $x++) {

			switch (true) {
				case ($x==0 AND preg_match('/([\d]{4}-[\d]{2}-[\d]{2}\s+[\d]{2}:[\d]{2}:[\d]{2})/', $logLineArray[$x])):
					preg_match('/([\d]{4}-[\d]{2}-[\d]{2}\s+[\d]{2}:[\d]{2}:[\d]{2})/', $logLineArray[$x], $matches);
					$returnData['date']=$matches[0];
					unset($logLineArray[$x]);
					break;
				case ($x==1 AND preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})/', $logLineArray[$x])):
					$returnData['NAS']=$logLineArray[$x];
					unset($logLineArray[$x]);
					break;
				case ($x==2):
					$returnData['username']=$logLineArray[$x];
					unset($logLineArray[$x]);
					break;
				case ($x==3):
					$returnData['line']=$logLineArray[$x];
					unset($logLineArray[$x]);
					break;
				case ($x==4):
					$returnData['NAC']=$logLineArray[$x];
					unset($logLineArray[$x]);
					break;
				case ($x==5):
					$returnData['action']=$logLineArray[$x];
					unset($logLineArray[$x]);
					break;
			}//end switch
		}//end for

		if (count($logLineArray) > 0)
		{
			$unknownElements='';
			foreach($logLineArray as $wtf)
			{
				$unknownElements.=$wtf.' | ';
			}
			$returnData['cmd']=$unknownElements;
		}
		$returnData['server'] = $this->server_ip;
		$authorization = Authorization::create($returnData);

		return $authorization;
	}//end of parser function
}
