#!/bin/bash

GIT_REPO_PATH='/opt/tgui_data/confManager/configs'
GIT_REPO_PATH_REGEX='\/opt\/tgui_data\/confManager\/configs\/'
SORT='date_change'
SHOW_DIR_TABLE=0
REVERSE=0
DEBUG=0
FILTER_NAME=''
FILTER_GROUP=''
END_LINE=''
START_LINE=1
FILTER=()

function usage()
{
    echo -e "\t-h --help"
    echo -e "\t--sort=$SORT|name|group|size|commits|date_change|date_commit"
    echo -e "\t--reverse=$REVERSE|1"
    echo -e "\t--start-line=<number>"
    echo -e "\t--end-line=<number>"
    echo -e "\t--show-dir-table=$SHOW_DIR_TABLE|1"
    echo -e "\t--debug=$DEBUG|1"
    echo ""
}

function dirList(){
  # ls -R '/opt/tgui_data/confManager/configs' | grep ":$" | \
  # ls '/opt/tgui_data/confManager/configs' | grep ":$" | \
  # sed -n -e 's/^.*\/opt\/tgui_data\/confManager\/configs/root/p' | \
  # sed -e 's/:$//' -e 's/[^-][^\/]*\//-/g' -e 's/^//'
  ls -dl /opt/tgui_data/confManager/configs$1*/ | sed -n -e 's/^.*\/opt\/tgui_data\/confManager\/configs//p'
}

function dirExploer(){
  ls -la /opt/tgui_data/confManager/configs$1 | awk 'NR > 3 { print $1, $9 }' | grep -v ".git"
}

while [ "$1" != "" ]; do
    PARAM=`echo $1 | awk -F= '{print $1}'`
    VALUE=`echo $1 | awk -F= '{print $2}'`
    case $PARAM in
        -h | --help)
            usage
            exit
            ;;
        --sort)
            SORT=$VALUE
            ;;
        --debug)
            DEBUG=$VALUE
            ;;
        --dir-list)
            dirList $VALUE
            exit
            ;;
        --dir-exploer)
            dirExploer $VALUE
            exit
            ;;
        --start-line)
            START_LINE=$VALUE
            ;;
        --end-line)
            END_LINE=$VALUE
            ;;
        --name)
            FILTER_NAME='-name '"'*${VALUE}*'"
            ;;
        --group)
            FILTER_GROUP='-path '"*${VALUE}*"
            ;;
        --reverse)
            REVERSE=$VALUE
            ;;
        --show-dir-table)
            SHOW_DIR_TABLE=$VALUE
            ;;
        *)
            echo "ERROR: unknown parameter \"$PARAM\""
            usage
            exit 1
            ;;
    esac
    shift
done

if [[ $REVERSE -eq 1 ]]; then
  REVERSE='-r'
else
  REVERSE=''
fi

if [[ $SHOW_DIR_TABLE -eq 1 ]]; then
  FINAL_SORT="sort -t$' ' -k2 "$REVERSE
  case $SORT in
    date)
        FINAL_SORT="sort -t$' ' -k1 -n "$REVERSE
      ;;
    members)
        FINAL_SORT="sort -t$' ' -k3 -n "$REVERSE
      ;;
  esac
  FIND_START='find '$GIT_REPO_PATH'/ -mindepth 1 -type d -not -path "*\.git*" -printf "%Ts %f\n"'
  FIND_START_FILTERED='find '$GIT_REPO_PATH'/ -mindepth 1 -type d '$FILTER_NAME' -not -path "*\.git*" -printf "%Ts %f\n"'
  echo "total $( eval $FIND_START | wc -l)"

  FINAL_LIST="$(eval $FIND_START_FILTERED | while read line; do
    IFS=' ' read size dir <<< "$line"
    echo "$line $(ls -ld ${GIT_REPO_PATH}/${dir}/* 2>/dev/null | wc -l)"
  done | eval $FINAL_SORT;)"
  echo "filtered $( echo "$FINAL_LIST" | wc -l)"
  if [[ $START_LINE != 1 ]] || [[ $END_LINE != '' ]]; then
    if [[ $END_LINE != '' ]]; then
      FINAL_LIST="$( echo "$FINAL_LIST" | sed $START_LINE','$END_LINE'!d' )"
    elif [[ $START_LINE != 1 ]]; then
      FINAL_LIST="$( echo "$FINAL_LIST" | sed $START_LINE','$TOTAL'!d' )"
    fi
  fi

  echo -n "$FINAL_LIST"
  exit 0;
fi

FINAL_SORT=" sort -t$' ' -k1 -n "$REVERSE

FINAL_FILTER=""
if [ ${#FILTER[@]} != 0 ]; then
  function join_by { local d=$1; shift; echo -n "$1"; shift; printf "%s" "${@/#/$d}"; }
  FINAL_FILTER=$( join_by '&&' "${FILTER[@]}" )
  # echo "$FINAL_FILTER"
fi
#FINAL_FILTER=" awk -F '\t' '{ if( \$6 ~ /folder/ ) { print } }'"
FIND_START='find '$GIT_REPO_PATH' -type f -not -path "*\.git*" -printf "%Ts %s %f %P\n"'
FIND_START_FILTERED='find '$GIT_REPO_PATH' -type f '$FILTER_NAME' '$FILTER_GROUP' -not -path "*\.git*" -printf "%Ts %s %f %P\n"'
case $SORT in
  date_change)
      #echo $FIND_START
    ;;
  # date_commit)
  #     FINAL_SORT="sort -t$'\t' -k2 -n "$REVERSE
  #     #echo $FIND_START
  #   ;;
  name)
      FINAL_SORT="sort -t$' ' -k3 "$REVERSE
      #echo $FIND_START
    ;;
  group)
      FINAL_SORT="sort -t$' ' -k4 "$REVERSE
      #echo $FIND_START
    ;;
  size)
      FINAL_SORT="sort -t$' ' -k2 -n "$REVERSE
      #echo $FIND_START
    ;;
  # commits)
  #     FINAL_SORT="sort -t$'\t' -k4 -n "$REVERSE
  #     #echo $FIND_START
  #   ;;
esac

if [[ $DEBUG -eq 1 ]]; then
  echo "All variables:"
  echo -e "\tSORT="$SORT
  echo -e "\tREVERSE="$REVERSE
  echo -en "\tFIND_START="; echo $FIND_START
  echo "Move further..."
fi

#echo "$FIND_START_FILTERED | $FINAL_SORT";
#find $GIT_REPO_PATH -type f -printf "%TY-%Tm-%Td %TH:%TM:%TS %s %p\n" | grep -v ".git" #| awk '{ print $2,$3,$4,$5,$6 }'

FINAL_FULL_LIST="$(eval $FIND_START_FILTERED | eval $FINAL_SORT)"
TOTAL=$(eval $FIND_START | wc -l)
echo "total "$TOTAL
if [[ $FINAL_FULL_LIST == '' ]]; then
  echo "filtered 0"
else
  echo "filtered "$(echo "$FINAL_FULL_LIST" | wc -l)
fi
FINAL_LIST="$FINAL_FULL_LIST"

##pagination
if [[ $START_LINE != 1 ]] || [[ $END_LINE != '' ]]; then
  if [[ $END_LINE != '' ]]; then
    FINAL_LIST="$( echo "$FINAL_LIST" | sed $START_LINE','$END_LINE'!d' )"
  elif [[ $START_LINE != 1 ]]; then
    FINAL_LIST="$( echo "$FINAL_LIST" | sed $START_LINE','$TOTAL'!d' )"
  fi
fi

echo "$FINAL_LIST"

exit 0;
# FINAL_FULL_LIST="$(eval $FIND_START | while read line; do
#     filename=$( echo $line | awk '{ print $4 }')
#     date_m='1'#$( date -d "$( echo $line | awk '{ print $1,$2 }' | sed -r 's/\.[0-9]+//')"  +"%s" )
#     size=$( echo $line | awk '{ print $3 }' | sed -r 's/\.[0-9]+//')
#     VERSION_COUNT='1'#$(git -C ${GIT_REPO_PATH} log --reverse --format="%h" -- $filename | wc -l)
#     if [[ $VERSION_COUNT -eq 0 ]]; then
#       continue
#     fi
#
#     FILE_COMM_DATE='1'#$( date -d "$(git -C ${GIT_REPO_PATH} log -1 --format='%ai' -- $filename | awk '{ print $1,$2 }' )"  +"%s" )
#     FILE_NAME_=$( echo $filename | sed s/$GIT_REPO_PATH_REGEX// | sed 's/.*\///' )
#     FILE_GROUP_=$( echo $filename | sed s/$GIT_REPO_PATH_REGEX// | sed 's/\/.*$//' )
#     if [[ $FILE_NAME_ == $FILE_GROUP_ ]]; then
#       FILE_GROUP_=""
#     fi
#     ROW="$date_m\t$FILE_COMM_DATE\t$size\t$VERSION_COUNT\t$FILE_NAME_\t$FILE_GROUP_";
#     echo -e $ROW
#   done | eval $FINAL_SORT)"
# TOTAL=$(echo "$FINAL_FULL_LIST" | wc -l)
# echo "total "$TOTAL
# FINAL_LIST="$FINAL_FULL_LIST"
#
# if [[ $FINAL_FILTER != '' ]]; then
#   FINAL_LIST="$( echo "$FINAL_LIST" |  awk -F '\t' "{ if( $FINAL_FILTER ) { print } }")"
# fi
# echo "filtered "$(echo "$FINAL_LIST" | wc -l)
#
# if [[ $START_LINE != 1 ]] || [[ $END_LINE != '' ]]; then
#   if [[ $END_LINE != '' ]]; then
#     FINAL_LIST="$( echo "$FINAL_LIST" | sed $START_LINE','$END_LINE'!d' )"
#   elif [[ $START_LINE != 1 ]]; then
#     FINAL_LIST="$( echo "$FINAL_LIST" | sed $START_LINE','$TOTAL'!d' )"
#   fi
#
# fi
#
# echo "$FINAL_LIST"
