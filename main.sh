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
		*)
			echo 'Unexpected argument for check. Exit.'
			exit 0
		;;
		esac
	;;
	install)
		
	;;
	*)
		echo 'Unexpected main argument. Exit.'
		exit 0
	;;
esac

exit 0;