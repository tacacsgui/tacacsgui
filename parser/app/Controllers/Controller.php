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

}
