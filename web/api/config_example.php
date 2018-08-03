<?php

/** The name of the database */
define('DB_NAME', 'tgui');
define('DB_NAME_LOG', 'tgui_log');

/** MySQL database username */
define('DB_USER', 'tgui_user');

/** MySQL database password */
define('DB_PASSWORD', '<datatabase_passwd_here>');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', 'utf8_unicode_ci');

/** Tacacs Root Path */
define('TAC_ROOT_PATH', '/opt/tacacsgui');

/** Tacacs Configuration File */
define('TAC_PLUS_CFG', TAC_ROOT_PATH . '/tac_plus.cfg');

/** Tacacs Configuration File (for tacacs Parsing)*/
define('TAC_PLUS_CFG_TEST', TAC_ROOT_PATH . '/tac_plus.cfg_test');

/** Tacacs Output of Parsing (for tacacs Parsing)*/
define('TAC_PLUS_PARSING', TAC_ROOT_PATH. '/tacTestOutput.txt');

/** Tacacs deamon script*/
define('TAC_DEAMON', TAC_ROOT_PATH . '/tac_plus.sh');

/** Path to Backup Files */
define('BACKUP_PATH', TAC_ROOT_PATH . '/backup/database/');
