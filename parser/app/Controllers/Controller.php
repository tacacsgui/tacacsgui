<?php

namespace parser\Controllers;

use Symfony\Component\Yaml\Yaml;

class Controller
{
	protected $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function __get($property)
	{
		if($this->container->{$property})
		{
			return $this->container->{$property};
		}
	}

	private function notificationSettingsCreate($value='')
	{
		//file_put_contents('/opt/tgui_data/tmp_notification_settings.yaml', '{}');
		$settings = $this->db->connection('api_settings')->table('api_notification')->select('bad_authentication_enable', 'bad_authorization_enable')->first();

		$notification_settings = [ 'bad_authentication_enable' => $settings->bad_authentication_enable, 'bad_authorization_enable' => $settings->bad_authorization_enable ] ;

		file_put_contents('/opt/tgui_data/tmp_notification_settings.yaml', Yaml::dump( $notification_settings ) );
		return $notification_settings;
	}

	public function notificationSettings($value='')
	{
		if ( ! file_exists('/opt/tgui_data/tmp_notification_settings.yaml') ) {
			return $this->notificationSettingsCreate();
		}
		$settings = Yaml::parseFile('/opt/tgui_data/tmp_notification_settings.yaml');

		if ( !isset($settings['bad_authentication_enable']) || !isset($settings['bad_authorization_enable']) ) return $this->notificationSettingsCreate();

		return $settings;
	}

	public function missLoggingCheck($type = 'authe')
	{
		if ( !file_exists('/opt/tgui_data/parser') OR !file_exists('/opt/tgui_data/parser/missRules.yaml')) return false;
		try {
			$missConfig = Yaml::parseFile('/opt/tgui_data/parser/missRules.yaml');
		} catch (\Exception $e) {
			return false;
		}
		if ( empty($missConfig['tacacs']) OR empty($missConfig['tacacs'][$type]))
			return false;
		else
			return $missConfig['tacacs'][$type];
	}

	public function missLoggingTry($username = '', $nac = '', $config = []){
		if ( empty($username) OR empty($config) )
			return false;

		$filter = array_values(array_filter($config, function($x) use ($username) { return $x['username'] == $username;}));

		if (empty($filter))
			return false;

		if ( count( array_filter( $filter, function($x) { return $x['nac'] == null; } ) ) )
			return true;

		//var_dump($filter);die;

		if (
			filter_var($nac, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV6]) == false
			AND
			filter_var($nac, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV4]) == false
			)
			return false;

		$ipv6Flag = (filter_var($nac, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV6]) == false) ? '' : ' --ipv6 ';

		if ( count( array_filter( $filter, function($x) use ($username) { return $x['nac'] == null; } ) ) )
			return true;

		for ($i=0; $i < count($filter); $i++) {
			//var_dump('/opt/tacacsgui/parser/cidr.py -net '.$filter[$i]['nac'].' -addr '.$nac.$ipv6Flag);
			if ( trim(shell_exec('/opt/tacacsgui/parser/cidr.py -net '.$filter[$i]['nac'].' -addr '.$nac.$ipv6Flag)) == '1' )
				return true;
		}

		return false;
	}

}
