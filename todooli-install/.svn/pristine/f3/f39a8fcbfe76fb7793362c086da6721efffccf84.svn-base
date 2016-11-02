#!/bin/bash
#

source "include.sh"

killall
clean_queues 

rm -rf /home/todooli/mytemp
mkdir /home/todooli/mytemp
cd /home/todooli/html2
cp -rf /home/todooli/html2/assets/upload /home/todooli/mytemp
rm -rf *
cd /home/todooli/todooli-install
svn up
rm -rf /home/todooli/todooli-install/dlogs
mkdir /home/todooli/todooli-install/dlogs
mkdir /home/todooli/html2/dlogs
touch /home/todooli/todooli-install/dlogs/php.log
chmod 777 /home/todooli/todooli-install/dlogs/php.log
touch /home/todooli/todooli-install/dlogs/error.log
chmod 777 /home/todooli/todooli-install/dlogs/error.log
touch /home/todooli/todooli-install/dlogs/summary.txt
chmod 777 /home/todooli/todooli-install/dlogs/summary.txt
mkdir /home/todooli/todooli-install/dlogs/session
chmod 777 /home/todooli/todooli-install/dlogs/session
chmod 777 /home/todooli/todooli-install/dlogs
rsync -r --exclude=.svn /home/todooli/todooli-install/html/* /home/todooli/html2
cp /home/todooli/todooli-install/html/.htaccess /home/todooli/html2
chmod 777 /home/todooli/html2/dlogs
chmod 777 /home/todooli/todooli-install/dlogs
cp -rf /home/todooli/mytemp/upload/* /home/todooli/html2/assets/upload
cd /home/todooli/todooli-install
./monitor_todooli.sh &
chmod 777 -R /home/todooli/html2/assets
