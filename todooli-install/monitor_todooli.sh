#!/bin/bash
# this script montiors messgae queue 200369 to kill or restart daemons
#

source "include.sh"

while true
do
  MESSAGE=`msg_recv 200369`
  case "$MESSAGE" in 
  *ERROR*)
    ;;
  start)
    echo "Start command received" >> /home/todooli/todooli-install/dlogs/monitor_todooli.log 2>&1
    start_all
    ;;
  stop)
    echo "Stop command received" >> /home/todooli/todooli-install/dlogs/monitor_todooli.log 2>&1
    stop_all
    ;;
  restart)
    echo "Restart command received" >> /home/todooli/todooli-install/dlogs/monitor_todooli.log 2>&1
    restart_all
    ;;
  esac
  sleep 2 
done

