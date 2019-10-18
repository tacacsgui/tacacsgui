<?php

#########################################
########TACACSGUI API###################
		define('APIVER', '0.9.82');
		define('APIREVISION', 10);
		define('TACVER', trim(preg_replace('/^tac_plus\s+version\s+/i', '', shell_exec('tac_plus -v 2>&1') )) );
		define('MAINSCRIPT', '/opt/tacacsgui/main.sh');
#########################################
#########################################
#########################################
########TACACSGUI HIGH AVAILABILITY###################
		define('HASETTINGS', '/opt/tgui_data/ha/ha-settings.yaml');
		define('HAMASTER', '/opt/tgui_data/ha/ha-master.yaml');
		define('HASLAVES', '/opt/tgui_data/ha/ha-slaves.yaml');
#########################################
#########################################
