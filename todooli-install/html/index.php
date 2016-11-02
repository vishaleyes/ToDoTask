<?php
//ini_set('error_reporting', E_ALL);
ini_set('error_reporting', E_ALL);

// change the following paths if necessary

/*$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$signals_lib=dirname(__FILE__).'/protected/vendors/lib/signals_lib.php';
$SolrPhpClient=dirname(__FILE__).'/protected/vendors/SolrPhpClient/config.php';*/
$yii='/home/todooli/todooli-install/framework/yii.php';
$config='/home/todooli/todooli-install/protected/config/main.php';
$signals_lib='/home/todooli/todooli-install/protected/vendors/lib/signals_lib.php';
//	$SolrPhpClient='/home/todooli/todooli-install/protected/vendors/SolrPhpClient/config.php';

global $msg;
global $errorCode;
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
if(file_exists($signals_lib))
{
	require_once($signals_lib);
}

/*if(file_exists($SolrPhpClient))
{
	require_once($SolrPhpClient);
}*/
setlocale(LC_TIME, 'en_US.ISO_8859-1');

Yii::createWebApplication($config)->run();
