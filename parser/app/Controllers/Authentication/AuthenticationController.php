<?php

namespace parser\Controllers\Authentication;

use parser\Models\Authentication;
use parser\Controllers\Controller;
use parser\Controllers\PostEngine\PostEngine;

class AuthenticationController extends Controller
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
				//case ($x==1 AND preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})/', $logLineArray[$x])):
				case ($x==1 AND
							(
								filter_var($logLineArray[$x], FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV6]) !== false OR
								filter_var($logLineArray[$x], FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV4]) !== false
							)
						):
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
				$unknownElements.=$wtf.'::#?';
			}
			$returnData['unknown']=$unknownElements;
		}
		$returnData['server'] = $this->server_ip;

		$missConfig = $this->missLoggingCheck();
		//var_dump( !preg_match('/.*succeeded.*/', $returnData['action']) );die;
		if ( !!preg_match('/.*succeeded.*/', $returnData['action']) AND $missConfig) {
			//var_dump($this->missLoggingTry($returnData['username'], $returnData['NAC'], $missConfig));//die;
			if( $this->missLoggingTry($returnData['username'], $returnData['NAC'], $missConfig) )
				return "miss";
		}
		
		$authentication = Authentication::create($returnData);

		if ($this->server_ip == 'localhost' AND strpos($returnData['action'], 'fail') !== false AND $this->postEngine->run(['type' => 'bad_authentication']) ){
			$data = $returnData;
			$data['type'] = 'bad_authentication';
			$data['title'] = 'Bad Authentication!';
			$this->postEngine->sendAlert($data);
		}

		return $authentication;
	}//end of parser function
}
