#!/bin/bash
# TacacsGUI Path map
# Author: Aleksey Mochalin
# echo "${BASH_SOURCE%/*}";
# LOG FILE #
#LOG_FILE="$PWD/log/tacacsgui.log";
# FUNCTIONS #
ROOT_PATH="/opt/tacacsgui";
FUN_GENERAL="$ROOT_PATH/scripts/functions/fun_general.sh";
FUN_HA="$ROOT_PATH/scripts/functions/fun_ha.sh";
#FUN_IFACE="$PWD/inc/src/func_if.sh";
# SCRIPTS #
# NETWORK="$PWD/inc/interfaces.sh";
# NET_SCRIPT_PATH="inc/interfaces.sh";
HA_SCRIPT_PATH="$ROOT_PATH/scripts/ha.sh";
CMDRUN="$ROOT_PATH/scripts/services/cmdrun.sh"
