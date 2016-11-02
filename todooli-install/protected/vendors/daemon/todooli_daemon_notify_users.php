<?php
	require_once ('/home/todooli/html2/logs/config.php');
	require_once('daemon.class.php');
	chdir(DAEMON_FILE_PATH."daemon");
	$d = new Daemon();
	$d->start("notify_users");
?>
