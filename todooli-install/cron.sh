#!/bin/bash

while :
do
if [ ! -f /home/todooli/todooli-install/not_active ];
then 
  sh monitor_daemons.sh
fi
sleep 60
done

