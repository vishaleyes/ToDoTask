<HTML>
<?php include_once("config.php");?>
<HEAD><title><?php echo _SITENAME_;?> - Start monitor</title></HEAD>
<BODY> 
<?php 

error_reporting(E_ALL);


define('LOGSBASE_PATH','/');

$command = "/bin/bash ".FILE_PATH."logs/monitor_daemons.sh" . " >> ".FILE_PATH."dlogs/monitor_daemons.log 2>&1 &";
echo "<br> Issued passthru ".$command;
passthru($command);
?>

</BODY>
</HTML>

