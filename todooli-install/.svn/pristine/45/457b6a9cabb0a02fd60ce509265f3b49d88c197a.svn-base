#!/bin/bash
#

source "include.sh"

killall
clean_queues

./monitor_todooli.sh &
/home/todooli/bin/msg_send 200369 start
