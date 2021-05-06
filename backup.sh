#!/bin/bash

ROOT_PATH="/opt/tgui_data"

if [ $# -eq 0 ]
then

echo '#######################################################################'
echo '###########################Instruction#################################'
echo '#######################################################################'
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
		NEW=''; OLD=''; REVISION=$4 ; DBTYPE=$3 ;
		#if [ -z "$REVISION" ]; then
			for ITEM in $(ls -utr $ROOT_PATH/backups/database/ | grep $DBTYPE | tail -n 2)
				do
					if [[ $OLD = "" ]]; then
						OLD=$ITEM
					else NEW=$ITEM
					fi
				done
		#else
		#	NEW=$(ls -utr $ROOT_PATH/backups/database/ | grep $DBTYPE | tail -n 1);
		# if [ $DBTYPE = "apicfg" ] || [ $DBTYPE = "full" ]; then
		# 		REVISION=$(echo -e "$(ls -utr $ROOT_PATH/backups/database/ | grep $DBTYPE | tail -n 1 | sed -r 's/.*_([0-9]*)\..*/\1/g')" | tr -d '[:space:]');
		# 		OLD=$(ls -ut $ROOT_PATH/backups/database/ | grep $DBTYPE | sed '2,1!d');
		# 		#if [[ $REVISION = "0" ]]; then
		# 		if [ $REVISION -eq 0 ] || [ $REVISION -gt 0 ]; then
		# 			REVISION=$REVISION+1;
		# 		fi
		# 		if [[ $REVISION = "" ]]; then
		# 			REVISION=0;
		# 		fi
		#	else
	#			OLD=$(ls -utr $ROOT_PATH/backups/database/ | grep $DBTYPE | grep $REVISION.sql | tail -n 1);
	#		fi

			#ls -tr $ROOT_PATH/backups/database/ | grep apicfg | grep 12.sql | tail -n 1
	#	fi

			#echo "NEW: $NEW";
			#echo "OLD: $OLD";

			if [[ $OLD = "" ]]; then
				echo 999; exit 1;
			fi
			if [[ $NEW = "" ]]; then
				echo 999; exit 1;
			fi

			diff -I "Dump completed" $ROOT_PATH/backups/database/$NEW $ROOT_PATH/backups/database/$OLD #| wc -l
	;;
	removeLast)
		rm $ROOT_PATH/backups/database/$(ls -tur $ROOT_PATH/backups/database/ | grep $DBTYPE | tail -n 1);
	;;
	make)
#		#$3 username $4 password $5 DBname $6 tables list $file name
		#mysql -utgui_user -p'_I2YSwfp_mWFV0UpR15Yx{4KA4vq`IA8' -N information_schema -e "select table_name from tables where table_schema = ’tgui’ and table_name like ‘tac_%’"
		#
		END_OF_NAME=$6
		REVISION=$7
		if [ -z "$END_OF_NAME" ]; then
			END_OF_NAME="all"
		fi
		if [ -z "$REVISION" ]; then
			REVISION=0
		fi
		TABLES=$6
		TYPE=""
		if [ $TABLES = "full" ]; then
			TYPE=$TABLES
			REVISION=$(echo -e "$(ls -tr $ROOT_PATH/backups/database/ | grep $TYPE | tail -n 1 | sed -r 's/.*_([0-9]*)\..*/\1/g')" | tr -d '[:space:]');
			#FOO_NO_WHITESPACE="$(echo -e "$(ls -tr $ROOT_PATH/backups/database/ | grep apicfg | tail -n 1 | sed -r 's/.*_([0-9]*)\..*/\1/g')" | tr -d '[:space:]')"
			if [[ $REVISION = "" ]]; then
				REVISION=1;
			else
				REVISION=$((REVISION+1));
			fi
			# TABLES="--tables mavis_ldap mavis_otp mavis_sms tac_acl tac_devices tac_device_groups tac_global_settings tac_services tac_users tac_user_groups api_users api_user_groups api_settings api_password_policy api_smtp";
			TABLES="";
		elif [ $TABLES = "tcfg" ]; then
			TYPE=$TABLES
			TABLES="--tables "$(mysql -u $3 -p$4 -h $2 -D $5 -Bse \
	"show tables where Tables_in_tgui like 'tac\_%' or Tables_in_tgui like 'mavis\_%' \
	or Tables_in_tgui like 'ldap\_%' or Tables_in_tgui like 'obj\_%' or Tables_in_tgui like 'bind\_%'" 2>/dev/null | xargs)
		elif [ $TABLES = "tlog" ]; then
			TYPE=$TABLES
			TABLES="--tables tac_log_accounting tac_log_authorization tac_log_authentication"
		elif [ $TABLES = "apicfg" ]; then
			TYPE=$TABLES
			REVISION=$(echo -e "$(ls -tr $ROOT_PATH/backups/database/ | grep $TYPE | tail -n 1 | sed -r 's/.*_([0-9]*)\..*/\1/g')" | tr -d '[:space:]');
			#FOO_NO_WHITESPACE="$(echo -e "$(ls -tr $ROOT_PATH/backups/database/ | grep apicfg | tail -n 1 | sed -r 's/.*_([0-9]*)\..*/\1/g')" | tr -d '[:space:]')"
			if [[ $REVISION = "" ]]; then
				REVISION=1;
			else
				REVISION=$((REVISION+1));
			fi
			TABLES="--tables $(mysql -u $3 -p$4  -h $2 -D $5 -Bse \
	"show tables where Tables_in_tgui like 'api\_%'" 2>/dev/null | xargs)"
		elif [ $TABLES = "api_log" ]; then
			TYPE=$TABLES
			TABLES="api_logging"
		fi
		#echo "mysqldump -u $3 -p$4 $5 $TABLES> $ROOT_PATH/backups/database/$(date '+%Y-%m-%d_%H:%M:%S')_$END_OF_NAME.sql"
		umask 111; mysqldump -u $3 -p$4  -h $2 $5 $TABLES | grep -v "Using a password" > $ROOT_PATH/backups/database/$(date '+%Y-%m-%d')_${END_OF_NAME}_${REVISION}.sql 2>&1 | grep -v "Using a password"

		for f in $(ls $ROOT_PATH/backups/database/ -r | grep $TYPE | sed '21,30!d'); do
			rm "$ROOT_PATH/backups/database/$f"
		done
		REVISION=0;
		echo "done";
	;;
	datatables)

		# START=$3; LENGTH=$4;
		ORDER=$3; DTTYPE=$4

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

		if [ $DTTYPE = "full" ]; then
			echo $(ls -l $ROOT_PATH/backups/database/ | \
					grep -v apicfg | grep -v tcfg | grep -v total | \
					wc -l)";"$(ls $ROOT_PATH/backups/database/ $ORDER | \
					grep -v apicfg | grep -v tcfg | \ #| sed "${START},${LENGTH}!d"
					grep -v total | wc -l);
			echo $( ls $ROOT_PATH/backups/database/ -utl $ORDER | grep -v apicfg | grep -v tcfg | awk {'print $9,$6'} ) #| sed "${START},${LENGTH}!d"
			echo "done";
			exit 0;
		fi

		echo $(ls -l $ROOT_PATH/backups/database/ | grep $DTTYPE | grep -v total | wc -l)\
					";"$(ls $ROOT_PATH/backups/database/ $ORDER | grep $DTTYPE | \ #sed "${START},${LENGTH}!d" | \
					grep -v total | wc -l);

		echo $( ls $ROOT_PATH/backups/database/ -utl $ORDER | grep $DTTYPE | awk {'print $9,$6'} ) #| sed "${START},${LENGTH}!d")

		echo "done";
	;;
	delete)
		rm $ROOT_PATH/backups/database/$3;
		echo 1;
	;;
	restore)
		#mysql -u tgui_user -ptgui123 tgui < /var/www/html/backups/database/2018-01-27_14:50:34_tcfg.sql
		mysql -u $3 -p$4  -h $2  $5 < $ROOT_PATH/backups/database/$6
		#echo $(mysql -u $3 -p$4 $5 < $ROOT_PATH/backups/database/$5);
		echo 1;
	;;
	*)
		echo 'Unexpected argument. Exit.'
		exit 0
	;;
esac

exit 0;
