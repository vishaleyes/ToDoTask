#include <stdio.h>
#include <sys/msg.h> 
#include <string.h>
#include <errno.h>

int main(int argc, char **argv) {
  struct message {
    long type;
    char text[20];
  } msg;
  int msqid =0;
  int msg_q_key =0;
  int rc =0;

  if (argc != 3) {
    printf("NO ARG %d", 1);
	return -1;
  }
  msg_q_key = atoi(argv[1]);
  msg.type = 1;
  strcpy(msg.text, argv[2]);

  if ((msqid = msgget(msg_q_key, 0)) == -1) {
    printf("DOES NOT EXIST ERROR %d", errno);
    if ((msqid = msgget(msg_q_key, IPC_CREAT | IPC_EXCL | 0666)) == -1) {
       printf("CREATE ERROR %d", errno);
       return -1;
    }
  }

  rc= msgsnd(msqid, (void *) &msg, sizeof(msg.text), IPC_NOWAIT);

  return rc;
}
