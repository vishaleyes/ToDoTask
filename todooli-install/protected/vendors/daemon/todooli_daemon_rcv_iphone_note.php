<?php
     	require_once ('/var/www/html2/logs/config.php');
	require_once('daemon.class.php');
	chdir(DAEMON_FILE_PATH."daemon");
	$d = new Daemon();
	$d->start("rcv_iphone_note");
?>
