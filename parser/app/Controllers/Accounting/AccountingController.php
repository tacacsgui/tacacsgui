<?php

namespace parser\Controllers\Accounting;

use parser\Models\Accounting;
use parser\Controllers\Controller;

class AccountingController extends Controller
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
				case ($x==6 AND preg_match('/(task_id=\d+)/', $logLineArray[$x])):
					preg_match('/task_id=(\d+)/', $logLineArray[$x], $matches);
					$returnData['task_id']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(timezone=.+)/', $logLineArray[$x])):
					preg_match('/timezone=(.+)/', $logLineArray[$x], $matches);
					$returnData['timezone']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(service=.+)/', $logLineArray[$x])):
					preg_match('/service=(.+)/', $logLineArray[$x], $matches);
					$returnData['service']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(cmd=)/', $logLineArray[$x])):
					preg_match('/cmd=(.*)/', $logLineArray[$x], $matches);
					$returnData['cmd']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(cmd-arg=)/', $logLineArray[$x])):
					preg_match('/cmd-arg=(.*)/', $logLineArray[$x], $matches);
					$returnData['cmd'].=' ' . $matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(priv-lvl=\d+)/', $logLineArray[$x])):
					preg_match('/priv-lvl=(\d+)/', $logLineArray[$x], $matches);
					$returnData['priv-lvl']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(disc-cause=\d+)/', $logLineArray[$x])):
					preg_match('/disc-cause=(\d+)/', $logLineArray[$x], $matches);
					$returnData['disc-cause']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(disc-cause-ext=\d+)/', $logLineArray[$x])):
					preg_match('/disc-cause-ext=(\d+)/', $logLineArray[$x], $matches);
					$returnData['disc-cause-ext']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(pre-session-time=\d+)/', $logLineArray[$x])):
					preg_match('/pre-session-time=(\d+)/', $logLineArray[$x], $matches);
					$returnData['pre-session-time']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(elapsed_time=\d+)/', $logLineArray[$x])):
					preg_match('/elapsed_time=(\d+)/', $logLineArray[$x], $matches);
					$returnData['elapsed_time']=$matches[1];
					unset($logLineArray[$x]);
					break;
				case (preg_match('/(stop_time=\d+)/', $logLineArray[$x])):
					preg_match('/(stop_time=\d+)/', $logLineArray[$x], $matches);
					$returnData['stop_time']=$matches[1];
					unset($logLineArray[$x]);
				case (preg_match('/(start_time=\d+)/', $logLineArray[$x])):
					preg_match('/(start_time=\d+)/', $logLineArray[$x], $matches);
					$returnData['start_time']=$matches[1];
					unset($logLineArray[$x]);
				case (preg_match('/(nas-rx-speed=\d+)/', $logLineArray[$x])):
					preg_match('/(nas-rx-speed=\d+)/', $logLineArray[$x], $matches);
					$returnData['nas-rx-speed']=$matches[1];
					unset($logLineArray[$x]);
				case (preg_match('/(nas-tx-speed=\d+)/', $logLineArray[$x])):
					preg_match('/(nas-tx-speed=\d+)/', $logLineArray[$x], $matches);
					$returnData['nas-tx-speed']=$matches[1];
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

		$missConfig = $this->missLoggingCheck('acc');
		if ( $missConfig ) {
			//var_dump($this->missLoggingTry($returnData['username'], $returnData['NAC'], $missConfig));//die;
			if( $this->missLoggingTry($returnData['username'], $returnData['NAC'], $missConfig) )
				return "miss";
		}

		$accounting = Accounting::create($returnData);

		return $accounting;
	}//end of parser function
}
