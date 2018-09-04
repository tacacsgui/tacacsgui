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
function check_mysql_replication_user () {
  echo $( echo "select User from mysql.user;" | mysql -uroot -p$1 2>/dev/null | grep tgui_replication | wc -l );
  return;
}
function replication_user_new_passwd() {
  echo "use mysql; ALTER USER 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
function replication_user_create() {
  echo "GRANT REPLICATION SLAVE ON tgui.* TO 'tgui_replication'@'%' IDENTIFIED BY '$2'; FLUSH PRIVILEGES;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
function master_status() {
  if [[ -z $2 ]]; then
    echo "SHOW MASTER STATUS;" | mysql -uroot -p$1 2>/dev/null | awk '{print $1" " $2}' | grep -v File;
    return;
  fi
  echo "SHOW MASTER STATUS;" | mysql -uroot -p$1 2>/dev/null;
  return;
}
function slave_status() {
  echo 'SlaVe';
  return;
}
