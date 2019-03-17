#!/bin/bash

###Script for network interface configuring###
ROOT_PATH="/opt/tacacsgui"
TABSPACE='      ';
function interface_list () {
  ip link | grep -Po '(?<=[0-9]: )[a-z0-9]+(?=:)' | sed "s/^/${TABSPACE}/";
}
function interface_list_ip () {
  ip addr | awk '/^[0-9]+:/ { sub(/:/,"",$2); iface=$2 } /\s*inet / { split($2, a, "/"); print iface"-"a[1]}'
}

function interface_existance () {
  if [ -z "$1" ]; then
    echo 0;
    return;
  fi
  echo $(ip addr | grep -oh "$1:" | grep -E "^[a-z]+[0-9]+:$|^lo:$" | wc -l | tr -d '[:space:]');
  return;
}

function if_settings () {
  if [ -z "$1" ]; then
    echo "Interface name can not be empty";
    return;
  fi
  if [ ! -f /etc/network/interfaces.d/$1.cfg ]; then
    echo "Settings for that interface not found";
    return;
  fi
  local output=$(cat /etc/network/interfaces.d/$1.cfg | tr '\n' "\n")
  cat /etc/network/interfaces.d/$1.cfg;
  return;
}

function first_appearance () {
  echo $(cat /etc/network/interfaces | grep interfaces.sh | wc -l | tr -d '[:space:]')
  return;
}

function make_backup () {
  sudo cp /etc/network/interfaces /etc/network/interfaces_old;
  echo 1;
  return;
}

function main_file_prepare () {
  sudo echo -e "# file was automatically created by interfaces.sh #\n source /etc/network/interfaces.d/*" > /etc/network/interfaces
  if [ ! -f /etc/network/interfaces.d/lo.cfg ]
  then
    sudo echo -e "auto lo\niface lo inet loopback" > /etc/network/interfaces.d/lo.cfg
  fi
  echo 1;
  return;
}

function valid_ip()
{
    local  ip=$1
    local  stat=1

    if [[ $ip =~ ^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$ ]]; then
        OIFS=$IFS
        IFS='.'
        ip=($ip)
        IFS=$OIFS
        if [[ ${ip[0]} -le 255 && ${ip[1]} -le 255 \
            && ${ip[2]} -le 255 && ${ip[3]} -le 255 ]]; then stat=0;
        fi
    fi
    echo $stat;
}


if [ $# -eq 0 ]
then
  while true; do
    clear;
    echo; echo "${TABSPACE}Hello! You are inside of interactive mode. Choose the action:";
    echo
    echo "${TABSPACE}1 Show Interface List";
    echo "${TABSPACE}2 Show Interface Settings";
    echo "${TABSPACE}3 Configure interface";
    echo "${TABSPACE}9 Clear and Show Menu";
    echo "${TABSPACE}0 Exit";
    while true; do
      echo; echo; echo -n 'Choose the action: ';
      read -e ACTION;
      case $ACTION in
        0)
          echo 'Goodbye!'; exit 0;
        ;;
      	1)
          echo; echo; echo "${TABSPACE}Interface List:" ;
          interface_list;
        ;;
        2)
          echo; echo; echo -n 'Type the name of interface: '; read -e IFNAME;
          IFNAME="$(echo -e "${IFNAME}" | sed -e 's/^[[:space:]]*//' | tr '[:upper:]' '[:lower:]' )"

          if [[ $(interface_existance $IFNAME) -eq '0' ]];
          then
            echo 'Unrecognized Interface';
            continue;
          fi
          if_settings $IFNAME;
        ;;
        3)
          if [ $(id -u) -ne 0 ]
          then
            echo; echo "${TABSPACE}Error!";
            echo "${TABSPACE}To make that change please run sctipt as root or use sudo!";
            continue;
          fi
          echo; echo; echo -n 'Type the name of interface: '; read -e IFNAME;
          IFNAME="$(echo -e "${IFNAME}" | sed -e 's/^[[:space:]]*//' | tr '[:upper:]' '[:lower:]' )"

          if [[ $(interface_existance $IFNAME) -eq '0' ]];
          then
            echo 'Unrecognized Interface';
            continue;
          fi
          FULLINTRFACECONF='';
          while true; do
            while true; do
              echo; echo -n 'Type IP Address (Required!): '; read -e IP_ADDRESS;
              IP_ADDRESS="$(echo -e "${IP_ADDRESS}" | sed -e 's/^[[:space:]]*//')"
              CH=$(valid_ip $IP_ADDRESS);
              if [[ $CH -ne 0 ]]; then
                echo; echo "${TABSPACE}Error!"; echo "${TABSPACE}This is $IP_ADDRESS incorrect ip address! Try one more time."; continue;
              else
                break;
              fi
            done
            FULLINTRFACECONF="address ${IP_ADDRESS}";
            while true; do
              echo; echo -n 'Type Network Mask (Required!): '; read -e IP_MASK;
              IP_MASK="$(echo -e "${IP_MASK}" | sed -e 's/^[[:space:]]*//')"
              CH=$(valid_ip $IP_MASK);
              if [[ $CH -ne 0 ]]; then
                echo; echo "${TABSPACE}Error!"; echo "${TABSPACE}This is $IP_MASK incorrect mask! Try one more time."; continue;
              else
                break;
              fi
            done
            FULLINTRFACECONF="${FULLINTRFACECONF}\nnetmask ${IP_MASK}";
            while true; do
              echo; echo -n 'Type Network Gateway (OR leave it empty): '; read -e IP_GATEWAY;
              IP_GATEWAY="$(echo -e "${IP_GATEWAY}" | sed -e 's/^[[:space:]]*//')";
              if [[ ! -z $IP_GATEWAY ]]; then
                CH=$(valid_ip $IP_GATEWAY);
                if [[ $CH -ne 0 ]]; then
                  echo; echo "${TABSPACE}Error!"; echo "${TABSPACE}This is $IP_GATEWAY incorrect ip address! Try one more time."; continue;
                else
                  FULLINTRFACECONF="${FULLINTRFACECONF}\ngateway ${IP_GATEWAY}"; break;
                fi
              fi
              break;
            done
            while true; do
              echo; echo -n 'Type Primary DNS Server (OR leave it empty): '; read -e IP_PRIMARYDNS;
              IP_PRIMARYDNS="$(echo -e "${IP_PRIMARYDNS}" | sed -e 's/^[[:space:]]*//')"
              IP_SECONDARYDNS='';
              if [[ ! -z $IP_PRIMARYDNS ]]; then
                CH=$(valid_ip $IP_PRIMARYDNS);
                if [[ $CH -ne 0 ]]; then
                  echo; echo "${TABSPACE}Error!"; echo "${TABSPACE}This is $IP_PRIMARYDNS incorrect ip address! Try one more time."; continue;
                else
                  FULLINTRFACECONF="${FULLINTRFACECONF}\ndns-nameservers ${IP_PRIMARYDNS}"; #break;
                fi
                echo; echo -n 'Type Secondary DNS Server (OR leave it empty): '; read -e IP_SECONDARYDNS;
                IP_SECONDARYDNS="$(echo -e "${IP_SECONDARYDNS}" | sed -e 's/^[[:space:]]*//')"
                if [[ ! -z $IP_SECONDARYDNS ]]; then
                  CH=$(valid_ip $IP_SECONDARYDNS);
                  if [[ $CH -ne 0 ]]; then
                    echo; echo "${TABSPACE}Error!"; echo "${TABSPACE}This is $IP_SECONDARYDNS incorrect ip address! Try one more time."; continue;
                  else
                    FULLINTRFACECONF="${FULLINTRFACECONF} ${IP_SECONDARYDNS}"; break;
                  fi
                fi
                break;
              fi
              break;
            done
            echo; echo "${TABSPACE}Configuration for interface ${IFNAME}:";
            echo -e $FULLINTRFACECONF;
            echo "
            ###########################################
            ###         Caution! Attention!         ###
            ### Check these settings twice          ###
            ### If you manage that server remotely  ###
            ### YOU WILL LOST THE CONNECTION        ###
            ###########################################
            "
            echo; echo -n 'Is it correct settings? (y/n): '; read DECISION;
            if [ "$DECISION" != "${DECISION#[Yy]}" ]; then
              break;
            else
              echo; echo "${TABSPACE}Ok. Try one more time. Configuration of ${IFNAME}:";
              continue;
            fi
          done #full interface configuration
          if [[ $(first_appearance) -eq 0 ]]
          then
            echo; echo -n 'It is the first time you run the script. Rewrite the interface file? (y/n): '; read DECISION;
            if [ "$DECISION" == "${DECISION#[Yy]}" ]; then
              echo; echo "${TABSPACE}Ok. Maybe later.";
              continue;
            fi
            echo -n 'Backup Status: '; echo -n $(make_backup);   echo 'Create main file Status: '; echo -n $(main_file_prepare);
            echo; echo "${TABSPACE}New File was created.";
          fi
          echo -e "auto ${IFNAME}\niface ${IFNAME} inet static\n${FULLINTRFACECONF}" > /etc/network/interfaces.d/$IFNAME.cfg;
          echo "${TABSPACE}New Interface File was created (/etc/network/interfaces.d/${IFNAME}.cfg).";

          echo "Network Interface restart...";

          sudo ip addr flush dev ${IFNAME}; sudo ifdown ${IFNAME}; sudo ifup ${IFNAME};
        ;;
        9)
          break;
        ;;
        *)
          echo 'Unrecognised Action. Pleases write the number of action.'
        ;;
      esac
    done
  done
fi

case $1 in
  list )
    if [[ ! -z $2 ]] && [[ $2 -eq 'ip' ]];then
      interface_list_ip;
      exit 0
    fi
    interface_list | sed -e 's/^[[:space:]]*//';
    ;;
  restart )
    if [[ $(interface_existance $2) -eq '0' ]];
    then
      echo 'Unrecognized Interface';
      exit;
    fi
    sudo ip addr flush dev $2; sudo ifdown $2; sudo ifup $2;
    ;;
  get )
    if [[ $(interface_existance $2) -eq '0' ]];
    then
      echo 'Unrecognized Interface';
      exit;
    fi
    SKIP=0;
    if [[ ! -z $3 ]] && [[ $3 -eq 'skip' ]]; then
      re='^[0-9]+$';
      if [[ ! -z $4 ]] && [[ $4 =~ $re ]]; then
        SKIP=$4;
      fi
    fi
    if_settings $2 | tail -n +$SKIP;
    ;;
  *)
    echo 'Unrecognised Action.'
  ;;
esac
exit 0
