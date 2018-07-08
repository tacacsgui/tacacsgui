#!/bin/bash

ROOT_PATH="/opt/tacacsgui"

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
		case $2 in
		mavis)
			/usr/local/bin/mavistest $ROOT_PATH/tac_plus.cfg_test tac_plus TACPLUS $3 $4
		;;

		ldapsearch)
			#ldapsearch -x -LLL -h WIN-I8GVEDVHNBK.WIN2008.G33 -D "CN=Alexey AM,CN=Users,DC=win2008,DC=g33" -w cisco123 -b 'CN=Users,DC=win2008,DC=g33' -s sub '(&(objectclass=user)(sAMAccountName=user2))'
		;;

		smpp-client)
			#php $ROOT_PATH/mavis-modules/sms/smpptest.php <type> <ipddr> <port> <debug> <login> <pass> <srcname> <number> <username>
			php $ROOT_PATH/mavis-modules/sms/smpptest.php $3 $4 $5 $6 $7 $8 $9 ${10} ${11}
		;;

		*)
			echo 'Unexpected argument for check. Exit.'
			exit 0
		;;
		esac
	;;
	delete)
		#find $ROOT_PATH/$3 -mmin +15 -exec rm -f {} \;
		DIRECTORY=$2;
		if [[ $DIRECTORY = "temp" ]]; then
			find ./temp/ -mmin +15 -type f -exec rm -f {} \;
			echo 'temp clear';
		else echo 'non ';
		fi
	;;
	*)
		echo 'Unexpected main argument. Exit.'
		exit 0
	;;
esac

exit 0;
