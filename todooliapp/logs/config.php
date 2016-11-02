<?php
	$basepath = str_replace("\\","/",dirname(dirname(__FILE__)));
	$basepath .= "/";
	define('BASEPATH',  $basepath);
		
	define("_SITENAME_",'Todooli');
	define("_SITENAME_NO_CAPS_",'todooli');
	define("_SITENAME_CAPS_",'TODOOLI');
	  /*define('FILE_PATH','/home/todooli/todooli-install/');
	  define('DAEMON_FILE_PATH','/var/www/html/protected/vendors/');*/
	  define('FILE_PATH','/home/todooli/todooli-install/');
	  define('DAEMON_FILE_PATH','/home/todooli/todooli-install/protected/vendors/');
	  
	  define('LOGS_PATH','/home/todooli/todooli-install/dlogs/');
	  define('HOST_NAME','todooli.com');
	  ini_set("error_log", "/home/todooli/todooli-install/dlogs/php.log");

?>
