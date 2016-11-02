#!/bin/awk -f
BEGIN {
}
{
  print $0;
  $command = "kill " $2 ;
  system($command);
}
END {
  system("ps -ef | grep daemon_ | grep -v grep");
}

