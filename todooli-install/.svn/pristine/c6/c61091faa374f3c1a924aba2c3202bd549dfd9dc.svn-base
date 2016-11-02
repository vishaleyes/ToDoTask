#!/bin/bash
# this script montiors all daemons and if a a daemon has stopped, 
# tries to restart it
# this scrpit is run by cron job every minute
#

#  echo "$1 $2" | mail -s "$1 $2" ajaymalik@yahoo.com         
#  echo "$1 $2" | mail -s "$1 $2" 4082035641@txt.att.net

function notify_admin {
   sleep 2 
}

#
# check daemon is running or not
#
function monitor {
  ps -ef | grep $1
  if [ $? != 0 ]
  then
    cd /var/www/html2/protected/vendors/daemon
    php $2 > /dev/null 2>&1 &
    sleep 2
    ps -ef | grep $1 > /dev/null 2>&1 
    if [ $? != 0 ]
    then
      notify_admin $3 "down. Could not be restarted"
    else
      notify_admin $3 "down. Restarted"
    fi	
  fi
}

while :
do
monitor todooli_daemon_rcv_rest.php todooli_daemon_rcv_rest.php rcv_rest
monitor todooli_daemon_rcv_rest_expire.php todooli_daemon_rcv_rest_expire.php rcv_expire
monitor todooli_daemon_send_sms.php todooli_daemon_send_sms.php send_sms
monitor todooli_daemon_rcv_sms.php todooli_daemon_rcv_sms.php rcv_sms
monitor todooli_daemon_send_email.php todooli_daemon_send_email.php send_email
monitor todooli_daemon_rcv_android_note.php todooli_daemon_rcv_android_note.php android_note
monitor todooli_daemon_rcv_iphone_note.php todooli_daemon_rcv_iphone_note.php iphone_note
monitor todooli_daemon_todo_updated.php todooli_daemon_todo_updated.php todo_updated
monitor todooli_daemon_reminder.php todooli_daemon_reminder.php reminder
monitor todooli_daemon_notify_users.php todooli_daemon_notify_users.php notify_users

sleep 60
done

