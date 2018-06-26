#!/bin/bash

ROOT_PATH="/opt/tacacsgui"

if [ $# -eq 0 ]
then

echo '#######################################################################'
echo '###########################Instruction#################################'
echo '#######################################################################'
echo '#                                                                     #'
echo '# you can execute the sctipt like this:                               #'
echo '# ./backup.sh <>						    #'
echo '#                                                                     #'
echo '# 						                    #'
echo '# 						                    #'
echo '#                                                                     #'
echo '# 						                    #'
echo '#                                                                     #'
echo '#           						            #'
echo '#######################################################################'$'\n'
exit 0

fi

case $1 in
	check)
		OUTPUT=""
		if [ ! -d $ROOT_PATH/backups/database/ ]
			then
				echo "Dir backups/database doesn't exist. Creating."
				mkdir -p $ROOT_PATH/backups/database/;
				chmod 777 $ROOT_PATH/backups;
				chmod 777 $(find $ROOT_PATH/backups -type d);
		fi
		if [ ! -d $ROOT_PATH/backups/api/ ]
			then
				echo "Dir backups/api doesn't exist. Creating."
				mkdir -p $ROOT_PATH/backups/api/;
				chmod 777 $ROOT_PATH/backups;
				chmod 777 $(find $ROOT_PATH/backups -type d);
		fi
		if [ ! -d $ROOT_PATH/backups/gui/ ]
			then
				echo "Dir backups/gui doesn't exist. Creating."
				mkdir -p $ROOT_PATH/backups/gui/;
				chmod 777 $ROOT_PATH/backups;
				chmod 777 $(find $ROOT_PATH/backups -type d);
		fi
	;;
	diff)
		NEW=''; OLD=''; REVISION=$3 ; DBTYPE=$2 ;
		if [ -z "$REVISION" ]; then
			for ITEM in $(ls -tr $ROOT_PATH/backups/database/ | grep $DBTYPE | tail -n 2)
				do
					if [[ $OLD = "" ]]; then
						OLD=$ITEM
					else NEW=$ITEM
					fi
				done
		else
			NEW=$(ls -tr $ROOT_PATH/backups/database/ | grep $DBTYPE | tail -n 1);
			OLD=$(ls -tr $ROOT_PATH/backups/database/ | grep $DBTYPE | grep $REVISION.sql | tail -n 1);
		fi

			#echo "NEW: $NEW";
			#echo "OLD: $OLD";
			diff -I "Dump completed" $ROOT_PATH/backups/database/$NEW $ROOT_PATH/backups/database/$OLD | wc -l
	;;
	removeLast)
		rm $ROOT_PATH/backups/database/$(ls -tr $ROOT_PATH/backups/database/ | tail -n 1);
	;;
	make)
		#$2 username $3 password $4 DBname $5 tables list $file name
		END_OF_NAME=$5
		REVISION=$6
		if [ -z "$END_OF_NAME" ]; then
			END_OF_NAME="all"
		fi
		if [ -z "$REVISION" ]; then
			REVISION=0
		fi
		TABLES=$5
		if [ $TABLES = "all" ]; then
			TABLES=""
		elif [ $TABLES = "tcfg" ]; then
			TABLES="--tables mavis_ldap mavis_otp mavis_sms tac_acl tac_devices tac_device_groups tac_global_settings tac_services tac_users tac_user_groups"
		elif [ $TABLES = "tlog" ]; then
			TABLES="--tables tac_log_accounting tac_log_authorization tac_log_authentication"
		elif [ $TABLES = "api" ]; then
			TABLES="api_users api_user_groups api_settings"
		elif [ $TABLES = "api_log" ]; then
			TABLES="api_logging"
		fi
		#echo "mysqldump -u $2 -p$3 $4 $TABLES> $ROOT_PATH/backups/database/$(date '+%Y-%m-%d_%H:%M:%S')_$END_OF_NAME.sql"
		umask 111; mysqldump -u $2 -p$3 $4 $TABLES | grep -v "Using a password" > $ROOT_PATH/backups/database/$(date '+%Y-%m-%d_%H:%M:%S')_${END_OF_NAME}_${REVISION}.sql 2>&1 | grep -v "Using a password"

		for f in $(ls $ROOT_PATH/backups/database/ -r | sed '21,30!d'); do
			rm "$ROOT_PATH/backups/database/$f"
		done

		echo "done";
	;;
	datatables)

		START=$2; LENGTH=$3; ORDER=$4; DTTYPE=$5

		if [ -z "$DTTYPE" ]; then
			DTTYPE='tcfg';
		fi

		if [ -z "$START" ]; then
			START=1;
		fi

		if [ -z "$LENGTH" ]; then
			LENGTH=10;
		fi

		if [ -z "$ORDER" ]; then
			ORDER='-r';
		fi
		if [ $ORDER = "asc" ]; then
			ORDER=""
		else
			ORDER='-r';
		fi

		echo $(ls -l $ROOT_PATH/backups/database/ | grep $DTTYPE | grep -v total | wc -l)";"$(ls $ROOT_PATH/backups/database/ $ORDER | grep $DTTYPE | sed "${START},${LENGTH}!d" | grep -v total | wc -l);

		echo $( ls $ROOT_PATH/backups/database/ -l $ORDER | grep $DTTYPE | awk {'print $9,$5'} | sed "${START},${LENGTH}!d")

		echo "done";
	;;
	delete)
		rm $ROOT_PATH/backups/database/$2;
		echo 1;
	;;
	restore)
		#mysql -u tgui_user -ptgui123 tgui < /var/www/html/backups/database/2018-01-27_14:50:34_tcfg.sql
		mysql -u $2 -p$3 $4 < $ROOT_PATH/backups/database/$5
		#echo $(mysql -u $2 -p$3 $4 < $ROOT_PATH/backups/database/$5);
		echo 1;
	;;
	*)
		echo 'Unexpected argument. Exit.'
		exit 0
	;;
esac

exit 0;
