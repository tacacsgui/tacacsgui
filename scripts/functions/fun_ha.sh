#!/bin/bash
####  FUNCTIONS ####
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
  echo "STOP SLAVE; RESET SLAVE; CHANGE MASTER TO MASTER_HOST='$2',MASTER_USER='tgui_replication', MASTER_PASSWORD='$3', MASTER_LOG_FILE='$4', MASTER_LOG_POS=$5; START SLAVE;";
  echo $( echo "STOP SLAVE; RESET SLAVE; CHANGE MASTER TO MASTER_HOST='$2',MASTER_USER='tgui_replication', MASTER_PASSWORD='$3', MASTER_LOG_FILE='$4', MASTER_LOG_POS=$5; START SLAVE;" | mysql -uroot -p$1 2>/dev/null | wc -l );
  return;
}
function stop_slave () {
  echo $( echo "STOP SLAVE;" | mysql -uroot -p$1 2>/dev/null | wc -l );
  return;
}
function tgui_read_only_user () {
  echo "GRANT SELECT ON tgui.* TO 'tgui_ro'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
function check_mysql_replication_user () {
  echo $( echo "select User from mysql.user;" | mysql -uroot -p$1 2>/dev/null | grep tgui_replication | wc -l );
  return;
}
function replication_user_new_passwd() {
  #echo "use mysql; ALTER USER 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | mysql -uroot -p$1 2>/dev/null;
  echo "GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
function replication_user_create() {
  echo "GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
function master_status() {
  if [[ -z $2 ]]; then
    echo "SHOW MASTER STATUS;" | mysql -utgui_replication -p$1 2>/dev/null | awk '{print $1" " $2}' | grep -v File;
    return;
  fi
  echo "SHOW MASTER STATUS\G;" | mysql -utgui_replication -p$1 2>/dev/null;
  return;
}
function slave_restore() {
  COMMAND="mysql -u tgui_user --password='$1' tgui < /opt/tacacsgui/temp/dumpForSlave.sql"
  echo $COMMAND;
  mysql -u tgui_user --password=\'$1\' tgui < /opt/tacacsgui/temp/dumpForSlave.sql
  return;
}
function slave_status() {
  echo "SHOW SLAVE STATUS\G;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
