#!/bin/bash
#

source "include.sh"

killall
clean_queues

cd /home/todooli/todooli-install
rm -rf /home/todooli/todooli-install/dlogs
mkdir /home/todooli/todooli-install/dlogs
touch /home/todooli/todooli-install/dlogs/php.log
chmod 777 /home/todooli/todooli-install/dlogs/php.log
mkdir /home/todooli/todooli-install/dlogs/session
chmod 777 /home/todooli/todooli-install/dlogs/session
chmod 777 /home/todooli/todooli-install/dlogs
chmod 777 /home/todooli/html/assets
./monitor_todooli.sh &
