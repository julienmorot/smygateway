#!/bin/bash

NAME=squid
DAEMON=/usr/sbin/squid
LIB=/usr/lib/squid
PIDFILE=/var/run/$NAME.pid
SQUID_ARGS="-D -YC"
CHUID="root"

cp /var/www/config/squid/squid.conf /etc/squid/
#start-stop-daemon --stop --pidfile $PIDFILE --name squid
#sleep 2
#start-stop-daemon --start --pidfile $PIDFILE --chuid $CHUID --exec $DAEMON -- $SQUID_ARGS
/etc/init.d/squid stop
/etc/init.d/squid start



