<?php

#########################################
########TACACS GUI API###################
		define('APIVER', '0.9.73');
		define('APIREVISION', 10);
		define('TACVER', trim(preg_replace('/^tac_plus\s+version\s+/i', '', shell_exec('tac_plus -v 2>&1') )) );
		define('MAINSCRIPT', '/opt/tacacsgui/main.sh');
#########################################
#########################################
