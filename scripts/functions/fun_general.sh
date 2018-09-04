#!/bin/bash
####  FUNCTIONS ####
function first_appearance () {
  echo $(cat /etc/network/interfaces | grep interfaces.sh | wc -l | tr -d '[:space:]');
  return;
}
function error_message() {
  echo \
"###########    Error!    ###########"$'\n'\
$1$'\n'\
"####################################"; return;
}
function root_access() {
  if [ $(id -u) -ne 0 ]; then
    echo -n 0; return;
  fi
  echo -n 1; return;
}
function check_mysql_root () {
  echo $( echo "SHOW DATABASES;" | mysql -uroot -p$1 2>/dev/null | grep base | wc -l );
  return;
}
