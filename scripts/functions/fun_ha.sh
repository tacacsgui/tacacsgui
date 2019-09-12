#!/bin/bash
####  FUNCTIONS ####
function sinitize_passwd () {
  #echo $(echo "\"$1\"");
  echo "'"$1"'";
  return;
}
function mysql_query() {
  local USERNAME='root'
  if [[ ! -z $2 ]]; then
    USERNAME=$2;
  fi
  echo "mysql -u${USERNAME} -p'${1}' 2>/dev/null";
  return;
}
function check_mysql_root () {
  mysql=$(mysql_query $1);
  echo $( echo "SHOW DATABASES;" | eval $mysql | grep base | wc -l );
  return;
}
###### MY.CNF FUNCTIONS ##############
function check_old_mycnf_existance () {
  echo $( ls -l /etc/mysql/my.cnf_old 2>/dev/null | wc -l );
  return;
}
function check_old_mycnf_tgui () {
  echo $( cat /etc/mysql/my.cnf 2>/dev/null | grep -E "tgui|tacacsgui" | wc -l );
  return;
}
function backup_old_mycnf () {
  cp /etc/mysql/my.cnf /etc/mysql/my.cnf_old;
  return;
}
##########GET Root PASSWORD###############
function rootPasswd (){
  if [[  $(cat /opt/tacacsgui/web/api/config.php 2>/dev/null | grep -o -P "(?<=ROOT_PASSWD=).*(?=$)" | wc -l) -gt 0 ]]; then
    MYSQL_PASSWORD=$( cat /opt/tacacsgui/web/api/config.php 2>/dev/null | grep -o -P "(?<=ROOT_PASSWD=).*(?=$)" );
    if [[ $(check_mysql_root $MYSQL_PASSWORD) -ne 0 ]]
    then
      echo $MYSQL_PASSWORD;
    else
      echo 0;
    fi
  else
    echo 0;
  fi
  return
}
############ MASTER FUNCTIONS ###############
function make_master_mycnf () {
  local ipaddr='0.0.0.0';
  if [[ ! -z $1 ]]; then
    ipaddr=$1;
  fi
  echo "###     tacacsgui       config  ###
### tgui master ###
###################
[mysqld]
bind-address = ${ipaddr}
server-id = 4443
log_bin = /var/log/mysql/mysql-bin.log
binlog_do_db = tgui
###################" > /etc/mysql/my.cnf;
  return;
}
function master_status() {
  mysql=$(mysql_query $1 'tgui_replication');
  #echo $mysql;
  if [[ -z $2 ]]; then
    echo "SHOW MASTER STATUS;" | eval $mysql | awk '{print $1" " $2}' | grep -v File;
    return;
  fi
  echo "SHOW MASTER STATUS\G;" | eval $mysql | sed -n '1!p' | awk '{print $1$2}';
  return;
}
function mycfg_master() {
  case $1 in
    exist)
      echo $(cat /etc/mysql/my.cnf | grep "tgui master" | wc -l);
    ;;
    diff)
      echo $(diff <(echo "$(cat /etc/mysql/my.cnf)") <(echo "###     tacacsgui       config  ###"$'\n'"### tgui master ###"$'\n'"###################"$'\n'"[mysqld]"$'\n'"bind-address = $2"$'\n'"server-id = 4443"$'\n'"log_bin = /var/log/mysql/mysql-bin.log"$'\n'"binlog_do_db = tgui"$'\n'"###################") | wc -l );
    ;;
  esac
  return;
}
############# SLAVE FUNCTIONS ###############
function make_slave_mycnf () {
  echo "###     tacacsgui       config  ###
### tgui slave ###
###################
[mysqld]
server-id = $1
relay-log = /var/log/mysql/mysql-relay-bin.log
log_bin = /var/log/mysql/mysql-bin.log
binlog_do_db = tgui
###################" > /etc/mysql/my.cnf;
  return;
}
function start_slave () {
  mysql=$(mysql_query $1);
  #echo "STOP SLAVE; RESET SLAVE; CHANGE MASTER TO MASTER_HOST='$2',MASTER_USER='tgui_replication', MASTER_PASSWORD='$3', MASTER_LOG_FILE='$4', MASTER_LOG_POS=$5; START SLAVE;";
  echo -n "$(date_)STOP, RESET, CHANGE, START SLAVE...";
  echo "STOP SLAVE; RESET SLAVE; CHANGE MASTER TO MASTER_HOST='$2',MASTER_USER='tgui_replication', MASTER_PASSWORD='$3', MASTER_LOG_FILE='$4', MASTER_LOG_POS=$5; START SLAVE;" | eval $mysql;
  echo "Done.";
  echo -e "STOP SLAVE; RESET SLAVE;\nCHANGE MASTER TO MASTER_HOST='$2',\nMASTER_USER='tgui_replication',\nMASTER_PASSWORD='$3',\nMASTER_LOG_FILE='$4',\nMASTER_LOG_POS=$5;\nSTART SLAVE;"
  return;
}
function stop_slave () {
  mysql=$(mysql_query $1);
  echo $( echo "STOP SLAVE;" | eval $mysql | wc -l );
  return;
}
function slave_restore() {
  mysql=$(mysql_query $1 'tgui_user');
  COMMAND=$mysql" tgui < /opt/tacacsgui/temp/dumpForSlave.sql"
  echo $COMMAND;
  eval $COMMAND;
  return;
}
function slave_status() {
  mysql=$(mysql_query $1 'tgui_replication');
  echo "SHOW SLAVE STATUS\G;" | eval $mysql;
  return;
}
function mycfg_slave() {
  case $1 in
    exist)
      echo $(cat /etc/mysql/my.cnf | grep "tgui slave" | wc -l);
    ;;
    diff)
      echo $(diff <(echo "$(cat /etc/mysql/my.cnf)") <(echo "###     tacacsgui       config  ###"$'\n'"### tgui slave ###"$'\n'"###################"$'\n'"[mysqld]"$'\n'"server-id = $2"$'\n'"relay-log = /var/log/mysql/mysql-relay-bin.log"$'\n'"log_bin = /var/log/mysql/mysql-bin.log"$'\n'"binlog_do_db = tgui"$'\n'"###################") | wc -l );
    ;;
  esac
  return;
}
############ OTHER FUNCTIONS ######################
function ha_disable_mycnf () {
  echo "###     tacacsgui       config  ###
### tgui ha disable ###
###################" > /etc/mysql/my.cnf;
  return;
}
function tgui_read_only_user () {
  mysql=$(mysql_query $1);
  echo "GRANT SELECT ON tgui.* TO 'tgui_ro'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | eval $mysql;
  echo "GRANT SELECT ON tgui_log.* TO 'tgui_ro'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | eval $mysql;
  echo "$(date_) Read-only user tgui_ro was created"
  return;
}
function check_mysql_replication_user () {
  case $1 in
    exist)
      mysql=$(mysql_query $2 'tgui_replication');
      echo $( echo "show grants;" | eval $mysql | grep 'SLAVE, REPLICATION CLIENT' | wc -l );
    ;;
    *)
      mysql=$(mysql_query $1);
      echo $( echo "select User from mysql.user;" | eval $mysql | grep tgui_replication | wc -l );
    ;;
  esac
  return;
}
function replication_user_new_passwd() {
  mysql=$(mysql_query $1);
  #echo "use mysql; ALTER USER 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | eval $mysql;
  #echo "GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES; | "$mysql;
  echo "GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | eval $mysql;
  return;
}
function replication_user_create() {
  mysql=$(mysql_query $1);
  echo "GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | eval $mysql;
  return;
}
