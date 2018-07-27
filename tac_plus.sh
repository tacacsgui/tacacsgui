#!/bin/sh
#
# Start-stop script for tac_plus
#
### BEGIN INIT INFO
# Provides:          tac_plus
# Required-Start:    $remote_fs $syslog $time
# Required-Stop:     $remote_fs $syslog $time
# Should-Start:      $network
# Should-Stop:       $network
# Default-Start:     2 3 4 5
# Default-Stop:
# Short-Description: Starts and stops the tac_plus server process.
# Description:       Starts and stops the tac_plus server process.
### END INIT INFO
# $Id: etc_init.d_tac_plus,v 1.1 2011/07/22 17:04:03 marc Exp $
# (C)2001-2010 by Marc Huber <Marc.Huber@web.de>
PATH=/bin:/usr/bin:/sbin:/usr/sbin
export PATH

DEFAULT=/etc/default/tacplus-tac_plus

PROG=/usr/local/sbin/tac_plus
CONF=/opt/tacacsgui/tac_plus.cfg
PIDFILE=/var/run/tac_plus.pid
NAME=tac_plus

[ -f "$DEFAULT" ] && . "$DEFAULT"

for FILE in $PROG $CONF ; do
	if ! [ -f "$FILE" ] ; then
		echo $FILE does not exist.
		DIE=1
	fi
done

if [ "$DIE" != "" ] ; then
	echo Exiting.
	exit 1
fi

start () {
	/bin/echo -n "Starting $NAME: "
	if $PROG -bp $PIDFILE $CONF
	then
		echo "done."
	else
		echo "failed."
	fi
}

restart () {
	PID=`cat $PIDFILE 2>/dev/null`
	/bin/echo -n "Restarting $NAME: "
	if [ "x$PID" = "x" ]
	then
		echo "failed (service not running)"
	else
		kill -1 $PID 2>/dev/null
		echo "initiated."
	fi
}

stop () {
	PID=`cat $PIDFILE 2>/dev/null`
	/bin/echo -n "Stopping $NAME: "
	if [ "x$PID" = "x" ]
	then
		echo "failed ($NAME is not running)"
	else
		kill -9 $PID 2>/dev/null
		rm -f $PIDFILE
		echo "done."
	fi
}

case "$1" in
    stop)
	stop
	;;
    status)
	PID=`cat $PIDFILE 2>/dev/null`
	if [ "x$PID" = "x" ]
	then
		echo "$NAME is not running."
		exit 1
	fi
	if ps -p $PID 2>/dev/null >&2
	then
		echo "$NAME ($PID) is running."
		exit 0
	fi
	echo "$NAME ($PID) is not running but pid file exists."
	;;
    start|restart|force-reload|reload)
	if $PROG -P $CONF ;then
		if [ "$1" = "start" ]
		then
			stop 2>/dev/null >&2
			start
		else
			restart
		fi
	else
		cat <<EOT
********************************************************************************
* Unable to $1 $NAME ... please fix the configuration problem
* indicated above.
********************************************************************************
EOT
		exit 1
	fi
	;;
    *)
	echo "Usage: $0 {start|stop|restart|force-reload|reload|status}"
	exit 1
;;
esac

exit 0
