#!/bin/bash

ROOT_PATH="/opt/tacacsgui"

function interface_list () {
  echo 'list';
}

function interface_existance () {
  if [ -z "$1" ]; then
    echo 0;
    return;
  fi
  echo $(ip addr | grep -oh "$1:" | wc -l | tr -d '[:space:]');
  return;
}

if [ $# -eq 0 ]
then
  while true; do
    echo; echo "You are inside of interactive mode. Choose the action:";
    echo
    echo '1 Show Interface List';
    echo '2 Configure interface';
    echo '9 Show Menu';
    echo '0 Exit';
    while true; do
      echo; echo; echo -n 'Choose the action: ';
      read ACTION;
      case $ACTION in
        0)
          echo 'Goodbye!'; exit 0;
        ;;
      	1)
          echo; echo; echo 'Interface List: ';
          interface_list;
        ;;
        2)
          echo; echo; echo -n 'Put the name of intrface: ';
          read IFNAME;
          #EXISTANCE=$(interface_existance $IFNAME);
          if [[ $(interface_existance $IFNAME) -eq '0' ]];
          then
            echo 'Unrecognized Interface';
            continue;
          fi
          echo 'here';
        ;;
        9)
          break;
        ;;
        *)
          echo 'Unrecognised Action. Exit.'
          exit 0
        ;;
      esac
    done
  done
fi

exit 0
