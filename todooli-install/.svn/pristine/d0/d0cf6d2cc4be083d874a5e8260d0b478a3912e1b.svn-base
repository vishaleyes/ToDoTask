#!/bin/awk -f
BEGIN {
  daemons[0] = "daemon_hirenow.php";
  daemons[1] = "daemon_rcv_sms.php";
  daemons[2] = "daemon_contact_seekers.php";
  daemons[3] = "daemon_seekers_response.php";
  daemons[4] = "daemon_send_email.php";
  daemons[5] = "daemon_send_sms.php";
  daemons[6] = "daemon_seeker_updated.php";
  daemons[7] = "daemon_bulk_update.php";
  daemons[8] = "daemon_rcv_rest.php";
}
{
}
END {
  for (x in daemons) {
    print x , "\t", daemons[x]
    $command = "php " daemons[x] " &" ;
    system ($command);
    system ("sleep 2");
  } 
  system("ps -ef | grep daemon_ | grep -v grep");
}
