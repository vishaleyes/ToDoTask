#include <stdio.h>
#include <sys/msg.h>
#include <string.h>
#include <errno.h>

int main(int argc, char **argv) {
  struct message {
    long type;
    char text[20];
  } msg;
  long msgtyp = 0;
  int msqid =0;
  int msg_q_key =0;
  int rc =0;

  if (argc != 2) {
    printf("NO ARG %d", 1);
	return -1;
  }
  msg_q_key = atoi(argv[1]);

  if ((msqid = msgget(msg_q_key, 0)) == -1) {
    printf("DOES NOT EXIST ERROR %d", errno);
    if ((msqid = msgget(msg_q_key, IPC_CREAT | IPC_EXCL | 0666)) == -1) {
       printf("CREATE ERROR %d", errno);
       return -1;
    }
  }

  rc = msgrcv(
	msqid, 
	(void *) 
	&msg, 
	sizeof(msg.text), 
	msgtyp, 
	MSG_NOERROR | IPC_NOWAIT);
  
  if (rc == -1) {
    printf("RCV ERROR %d", errno);
	return rc;
  } else {
    printf("%s", msg.text);
  }
  return rc;
}
