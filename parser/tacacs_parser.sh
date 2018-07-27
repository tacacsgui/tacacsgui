#!/bin/bash

PATH_TACLOG='/var/log/tacacsgui'
PATH_PHPPARSER='/opt/tacacsgui'

if [ $# -eq 0 ]
then

echo '#######################################################################'
echo '###########################Instruction#################################'
echo '#######################################################################'
echo '#######################################################################'$'\n'
exit 0

elif [ $# -eq 1 ]
then
LOG_TYPE=$1

elif [ $# -gt 1 ]
then
echo "Too match arguments! Exit."
exit 0
fi

#read LOG_LINE;

case $1 in
	accounting)
		if [ ! -d $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/accounting/ ]
			then
				echo "Dir doesn't exist. Creating."
				mkdir -p $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/accounting/;
				chmod 777 $(find $PATH_TACLOG/tac_plus -type d);
		fi
		while read LINE; do
			if [ ! -f $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/accounting/$(date +%Y-%m-%d)-accounting.log ]
				then
				echo "File doesn't exist. Creating."
				echo "###The beginning of file###" > $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/accounting/$(date +%Y-%m-%d)-accounting.log
				chmod 666 $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/accounting/$(date +%Y-%m-%d)-accounting.log;
			fi
			echo $LINE >> $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/accounting/$(date +%Y-%m-%d)-accounting.log;
			#REPLACE=$(echo $LOG_LINE | sed "s/'/\\\'/g")
			php $PATH_PHPPARSER/parser/parser.php $1 "${LINE}"
		done
	;;
	authorization)
		echo "2222"
		if [ ! -d $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authorization/ ]
			then
				mkdir -p $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authorization/;
				chmod 777 $(find $PATH_TACLOG/tac_plus -type d);
        fi
		while read LINE; do
			if [ ! -f $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authorization/$(date +%Y-%m-%d)-authorization.log ]
				then
				echo "###The beginning of file###" > $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authorization/$(date +%Y-%m-%d)-authorization.log;
				chmod 666 $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authorization/$(date +%Y-%m-%d)-authorization.log;
			fi
			echo $LINE >> $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authorization/$(date +%Y-%m-%d)-authorization.log;
			php $PATH_PHPPARSER/parser/parser.php $1 "${LINE}"
		done
	;;
	authentication)
		echo "3333"
		if [ ! -d $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authentication/ ]
			then
				mkdir -p $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authentication/;
				chmod 777 $(find $PATH_TACLOG/tac_plus -type d);
		fi
		while read LINE; do
			if [ ! -f $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authentication/$(date +%Y-%m-%d)-authentication.log ]
				then
				echo "###The beginning of file###" > $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authentication/$(date +%Y-%m-%d)-authentication.log;
				chmod 666 $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authentication/$(date +%Y-%m-%d)-authentication.log;
			fi
			echo $LINE >> $PATH_TACLOG/tac_plus/$(date +%Y)/$(date +%m)/authentication/$(date +%Y-%m-%d)-authentication.log;
			php $PATH_PHPPARSER/parser/parser.php $1 "${LINE}"
		done
	;;
	*)
		echo 'Unexpected argument. Exit.'
		exit 0
	;;
esac

exit 0;
