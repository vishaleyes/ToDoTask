<HTML>
<?php 
error_reporting(E_ALL);
$daemonFlag=1;
$config='config.php';
require_once($config);

?>
<HEAD><title><?php echo _SITENAME_;?> - Health check</title></HEAD>
<!-- include the Tools -->
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.flowplayer.org/tools/css/overlay-apple.css"/>
	
	<style>
	/* use a semi-transparent image for the overlay */
	/*#overlay {
		background-image:url(/logs/overlay_bg.png);
		color:#333;
		height:450px;
	}*/
	
	/* container for external content. uses vertical scrollbar, if needed */
	/*div.contentWrap {
		height:441px;
		overflow-y:auto;
	}*/
	</style>

<!-- make all links with the 'rel' attribute open overlays -->
<script>

$(function() {

	// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	$("a[rel]").overlay({

		mask: 'gray',
		effect: 'apple',

		onBeforeLoad: function() {

			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");

			// load the page specified in the trigger
			wrap.load(this.getTrigger().attr("href"));
		}

	});
});
</script>
	
<BODY> 
<?php 
$daemons = array( "hirenow", "contact_seekers", "seekers_response", "send_sms", "send_email", "rcv_sms" , "seeker_updated", "bulk_update", "rcv_rest","rcv_rest_expire","rcv_android_note") ;

error_reporting(E_ALL);


define('LOGSBASE_PATH','/dlogs/');

function read_file($file, $lines) {
    //global $fsize;
    $handle = fopen($file, "r");
    if ($handle === FALSE)
      return array();
    $linecounter = $lines;
    $pos = -2;
    $beginning = false;
    $text = array();
    while ($linecounter > 0) {
        $t = " ";
        while ($t != "\n") {
            if(fseek($handle, $pos, SEEK_END) == -1) {
                $beginning = true; 
                break; 
            }
            $t = fgetc($handle);
            $pos --;
        }
        $linecounter --;
        if ($beginning) {
            rewind($handle);
        }
        $text[$lines-$linecounter-1] = fgets($handle);
        if ($beginning) break;
    }
    fclose ($handle);
    return array_reverse($text);
}

function returnDate($querydate){
    $remaining  = time() - $querydate;
    if ($remaining > (30 * 24 * 60 * 60)) {
      $date_string = date("F j, Y, g:i a");
    } else {
     $days    = floor($remaining / (24 * 60 * 60));
     $remaining  = $remaining % (24 * 60 * 60);
     $hours   = floor($remaining / (60 * 60));
     $remaining  = $remaining % (60 * 60);
     $minutes = floor($remaining / (60));
     $seconds = $remaining % (60);
     if ($days == 0) {
       if ($hours != 0) {
         $date_string = $hours . " hour " . $minutes . " min " . $seconds . " sec" . " ago";
       } else {
         if ($minutes != 0) {
           $date_string = $minutes . " min " . $seconds . " sec" . " ago";
         } else {
           $date_string = $seconds . " sec" . " ago";
         }
       }
     } else {
       $date_string = $days . " days " . $hours . " hour " . $minutes . " min " . $seconds . " sec" . " ago";
     }
    }

    return $date_string;
}


/**
 * get file size of log file
 */
function get_logfile_size($file, $file2, $name = "logFile") {
  if (file_exists($file)) {
    $lines = read_file($file, 0);
    foreach ($lines as $line) {
        $result = $result . $line;
        $result = $result . '<br />';
    }
    $result = '<td>' ;
    $result = $result . "<a href=\"" . $file2 . "\">" . $name . "</a>" . '<br />';
	$result = $result . 'Size = ' . filesize($file) . '<br />' . date ("F d Y H:i:s.", filemtime($file));
    $result = $result . '</td>';
    return $result;
  } else {
    echo '<td>' . $name . ': NO SUCH FILE</td><td>&nbsp;</td>';
  } 
}

/**
 * get restart count for the daemon from the .cnt file
 */
function get_restart_count($file) {
  if (file_exists($file)) {
    return '<td>' . 'Restart Count = ' . file_get_contents($file) . '<br />' . date ("F d Y H:i:s.", filemtime($file)) . '</td>' ;
  } else {
    echo '<td>NO SUCH FILE</td><td>&nbsp;</td>';
  } 
}

/**
 * Get process id by filename
 * @param $file[optional] Filename
 * @return Boolean
 */
function getProcessID($file = false) {
    $exists     = "";
    $file       = $file ? $file : __FILE__;

    // Check if file is in process list
    // echo $file ;
    $pids = '';
    exec("ps -ef", $pids);
    $count = count($pids);
    for ($i = 0 ; $i < $count; $i++) {
      if (strstr($pids[$i], "grep"))
        continue;
      if (strstr($pids[$i], $file)) {
		$pieces = preg_split("/[\s,]+/", $pids[$i]);
        $exists = $pieces[1];
        break;
      }
    }
    return $exists;
}

/**
 * Check for a current process by filename
 * @param $file[optional] Filename
 * @return Boolean
 */
function processExists($file = false) {

    $exists     = false;
    $file       = $file ? $file : __FILE__;

    // Check if file is in process list
    // echo $file ;
	$pids = '';
    exec("ps -ef", $pids);
    $lines = count($pids);
    for ($i = 0 ; $i < $lines; $i++) {
      if (strstr($pids[$i], "grep"))
        continue;
      if (strstr($pids[$i], $file)) {
        $exists = true;
        break;
      }
    }
    return $exists;
}

/**
 * kill process if running
 * @param $file[optional] Filename
 * @return Boolean
 */
function killProcess($file = false) {

    $exists     = false;
    $file       = $file ? $file : __FILE__;

    // Check if file is in process list
    // echo $file ;
	$pids = '';
    exec("ps -ef", $pids);
    $lines = count($pids);
    for ($i = 0 ; $i < $lines; $i++) {
      if (strstr($pids[$i], "grep"))
        continue;
      if (strstr($pids[$i], $file)) {
		$pieces = preg_split("/[\s,]+/", $pids[$i]);
		echo "<BR> Process is ".$pieces[1];
    	exec("kill ".$pieces[1]);
        $exists = true;
        break;
      }
    }
    return $exists;
}

/**
 * Return status in string if processExists
 */
function processExistsStatus($file = false) {

    $exists     = false;
    $file       = $file ? $file : __FILE__;

    // Check if file is in process list
    // echo $file ;
	$pids = '';
    exec("ps -ef", $pids);
    $lines = count($pids);
    for ($i = 0 ; $i < $lines; $i++) {
      if (strstr($pids[$i], "grep"))
        continue;
      if (strstr($pids[$i], $file)) {
        $exists = true;
        break;
      }
    }
    if ($exists === true) {
      return "RUNNING";
    } else {
      return "NOT RUNNING";
    }
}

function displaySummary() 
{
   $file = LOGS_PATH."summary.txt" ;
   $lines = read_file($file, 1);
   if (count($lines) == 0)  {
     echo "";
   } else {
     $found = strpos($lines[0], "100");
     if ($found === FALSE) {
       echo "<font style=\"color:red;font-weight:bold;\">$lines[0]</font><br />";
     } else {
       echo "<font style=\"color:green;font-weight:bold;\">$lines[0]</font><br />";
     }
   }
}

function update() 
{
	echo "Updating code" ;
	$command = "/var/www/html/utils/msg_send 200368 update";
	system($command);
    restart_all_daemons();
    error_log("All code updated & daemons restarted");
}

function svninfo() 
{
	echo "Current version here<br />" ;
	$command = "cd /var/www/html ; svn info | grep 'Rev\|Last'; cd logs ;";
	system($command);
	//echo "<br />Latest version in repo<br />" ;
	//$command = 'cd /var/www/html ; svn info -r HEAD ; cd logs ;';
	//system($command);
}

function compare_database() 
{
	echo "Comparing databases not implemented" ;
}

function clearlogs()
{
	echo "Clearing logs" ;
	$command = "rm /var/www/html/dlogs/php.log";
	system($command);
    error_log("All logs cleared");
}

function cleardatabase() 
{
	echo "Clear database not implemented" ;
}

function start_fut() 
{
	echo "Starting Automated SMS testing" ;
	$command = "/var/www/html/utils/msg_send 200368 start";
	system($command);
}

function start_solr() 
{
	echo "Starting SOLR" ;
	$command = "/var/www/html/utils/msg_send 200369 start";
	system($command);
}

function stop_solr() 
{
	echo "Stopping SOLR" ;
	$command = "/var/www/html/utils/msg_send 200369 stop";
	system($command);
}

function restart_solr() 
{
	echo "Restarting SOLR" ;
	$command = "/var/www/html/utils/msg_send 200369 restart";
	system($command);
}


svninfo();

$linkchoice='';
if (isset($_GET['run'])) $linkchoice=$_GET['run'];
switch($linkchoice){
case 'update' :
    update();
    break;

case 'svn' :
    svninfo();
    break; 

case 'clearlogs' :
    clearlogs();
    break; 

case 'cleardatabase' :
    cleardatabase();
    break; 

case 'start_fut' :
    start_fut();
    break; 

case 'start_solr' :
    start_solr();
    break; 

case 'stop_solr' :
    stop_solr();
    break; 

case 'restart_solr' :
    restart_solr();
    break; 
}

function restart_all_daemons() {
  global $daemons;
		foreach ($daemons as $daemon) {
			killProcess($daemon);
		}
    	// echo "<br>";
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_hirenow.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_rcv_sms.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_send_sms.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_send_email.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_bulk_update.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_seeker_updated.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_seekers_response.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_contact_seekers.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
    	// echo "<br>";
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_rcv_rest.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
		
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_rcv_rest_expire.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
		
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_rcv_android_note.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
		
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/daemon_rcv_iphone_note.php >> ".LOGS_PATH."daemons.log 2>&1 &";
		passthru($command);
    	// echo "<br> Issued passthru ".$command;
    	// echo "<br>";
}

function stop_all_daemons() {
  global $daemons;
		foreach ($daemons as $daemon) {
			killProcess($daemon);
		}
}

if(isset($_POST['submit'])) 
{ 
    error_log("INFO Request to " . $_POST['action'] . " daemon: " . $_POST['name'] . " is received");
    if (strcasecmp($_POST['action'], "start all") == 0) {
        restart_all_daemons();
	}
    if (strcasecmp($_POST['action'], "stop all") == 0) {
        stop_all_daemons();
	}
    if (strcasecmp($_POST['action'], "stop") == 0) {
		killProcess($_POST['name']);	
	}
    if (strcasecmp($_POST['action'], "start") == 0) {
		killProcess($_POST['name']);
		$command = "/usr/bin/php ".DAEMON_FILE_PATH."daemon/" . $_POST['name'] . " >> ".LOGS_PATH."daemons.log 2>&1 &";
    	echo "<br> Issued passthru ".$command;
		passthru($command,$result);
		$content_grabbed=ob_get_contents();
		var_dump($result);
		if($result=0){
		 echo '<div>',$content_grabbed,'</div>';
		}
	}
}
?>

<!-- overlayed element -->

<div class="apple_overlay" id="overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>

</div>

<table border="1" style="font-size:11px;">
<thead>
<th> Name </th>
<th> Status </th>
<th> Action (only if not running) </th>
<th> Restart Count <br /> Last Restarted at </th>
<th>&nbsp;  </th>
</thead>
<tr>
<td>
<FORM method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="hidden" name="name" value="all" />
   <input type="hidden" name="action" value="Stop All" />
   <input type="submit" name="submit" value="Stop All"><br>
</FORM>
</td>
<td>
<FORM method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="hidden" name="name" value="all" />
   <input type="hidden" name="action" value="Start All" />
   <input type="submit" name="submit" value="Start All"><br>
</FORM>
</td>
<td>
<a href="index.php?run=update"> Update all code </a> <br />
<a href="index.php?run=clearlogs">Clear Logs</a> <br />
<a href="index.php?run=cleardatabase">Clear Database</a>
</td>
<?php 
$logFile = LOGS_PATH."monitor_fut" . ".log" ;
$logFile_relative = LOGSBASE_PATH."monitor_fut" . ".log" ;
echo get_logfile_size($logFile, $logFile_relative, "monitor_fut");
?>
<td>&nbsp;  </td>
</tr>

<tr>
<td> monitor </td>
<?php
  if (processExists("monitor_daemons.sh")) {
	 echo "<td> Daemons Monitor RUNNING <br/>";
  	 echo getProcessID("monitor_daemons.sh");
	 echo "&nbsp; <br/>" ;
     echo "</td>" ;
  } else {
	 echo "<td style=\"color:red;font-weight:bold;\">Daemons Monitor Not RUNNING &nbsp; <br />" ;
     echo "<a href=\"/logs/monitor.php\" rel=\"#overlay\">Click here to start</a>";
	 echo "</td>" ;
  }
  if (processExists("monitor_solr.sh")) {
	 echo "<td> SOLR Monitor RUNNING<br/>";
  	 echo getProcessID("monitor_solr.sh");
	 echo "&nbsp; <br/>" ;
     echo "</td>" ;
  } else {
	 echo "<td style=\"color:red;font-weight:bold;\">SOLR Monitor Not RUNNING</td>" ;
  }
?>
<?php
  if (processExists("monitor_fut.sh")) {
	 echo "<td> FUT RUNNING<br/>";
  	 echo getProcessID("monitor_fut.sh");
	 echo "&nbsp; <br/>" ;
     echo "</td>" ;
  } else {
	 echo "<td style=\"color:red;font-weight:bold;\">FUT Not RUNNING</td>" ;
  }
?>
<?php
  if (processExists("monitor_heartbeat.sh")) {
	 echo "<td> Heartbeat RUNNING<br/>";
  	 echo getProcessID("monitor_heartbeat.sh");
	 echo "&nbsp; <br/>" ;
     echo "</td>" ;
  } else {
	 echo "<td style=\"color:red;font-weight:bold;\">Heartbeat Not RUNNING</td>" ;
  }
?>
</tr>

<tr>
<td> Automated <?php echo _SITENAME_;?> SMS Testing </td>
<?php
  if (processExists("futs.php")) {
	 echo "<td>RUNNING<br/>" ;
  	 echo getProcessID("futs.php");
	 echo "</td>" ;
  } else {
	 echo "<td style=\"color:blue;font-weight:bold;\">Not RUNNING<br/>" ;
	 echo "</td>" ;
  }
?>
</td>
<td>
    <a href="index.php?run=start_fut">Click here to run automated SMS test</a>
</td>
<td>
    <?php displaySummary(); ?>
</td>
<td>
    <a href="/dlogs/summary.txt">Results Summary</a> <br />
    <a href="/dlogs/details.txt">Results Details</a>
</td>
</tr>

<tr>
<td> SOLR </td>
<?php
  if (processExists("start.jar")) {
	 echo "<td>RUNNING <br/>" ;
  	 echo getProcessID("start.jar");
	 echo "&nbsp; <br/>" ;
     echo "<a href=\"index.php?run=stop_solr\">Click here to stop</a>" ;
	 echo "</td>" ;
  } else {
	 echo "<td style=\"color:red;font-weight:bold;\">SOLR Not RUNNING<br/>" ;
     echo "<a href=\"index.php?run=start_solr\">Click here to start</a>";
	 echo "</td>" ;
  }
?>
</td>
<td>
    <a href="index.php?run=restart_solr">Click here to restart</a>
</td>
</tr>

<?php foreach ($daemons as $daemon) {
  echo "<tr><td>" . $daemon . "</td> ";
   $processName = "daemon_" . $daemon . ".php" ;
  if (processExists($processName)) {
	 echo "<td>RUNNING<br/>" ;
  	 echo getProcessID($processName);
	 echo "</td>" ;
?>
<td>
<FORM method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="hidden" name="name" value=<?php echo $processName; ?> />
   <input type="hidden" name="action" value="Stop" />
   <input type="submit" name="submit" value="Stop"><br>
</FORM>
</td>
<?php
      } else {
	 echo "<td style=\"color:red;font-weight:bold;\">Not RUNNING</td>" ;
?>
<td>
<FORM method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="hidden" name="name" value=<?php echo $processName; ?> />
   <input type="hidden" name="action" value="Start" />
   <input type="submit" name="submit" value="Start"><br>
</FORM>
<?php
      }
?>
</td>
<?php 
echo get_restart_count(LOGS_PATH."daemon_" . $daemon . '.cnt');
?>
<?php 
$logFile = LOGS_PATH."daemon_" . $daemon. ".log" ;
$logFile_relative = LOGSBASE_PATH."daemon_" . $daemon. ".log" ;
echo get_logfile_size($logFile, $logFile_relative, $daemon . ".log");
?>
</tr>
<?php 
  }
?>

</table>
<br />
<table width="100%">
<tr>
<td>
<?php
  $logFile = LOGS_PATH."php.log" ;
  //echo date('l jS \of F Y H:i:s');
  //echo "<br>";
  if (file_exists($logFile)) {
    echo "<a href=\"/logs/logs.php". "\">ERRORS logFile </a> and ";
    echo "<a href=\"/dlogs/php.log". "\">logFile </a> ";
    $result = 'Size: ' . filesize($logFile) ;
    $result = $result . ' Last updated at: ' . date ("F d Y H:i:s.", filemtime($logFile)) . '<br />' ;
    $lines = read_file($logFile, 600);
    $sizeof_arr = sizeof($lines);
    for ($i=0; $i<$sizeof_arr; $i++) {
        $count = preg_match('/INFO/', $lines[$sizeof_arr-$i-1]);
		if ($count > 0) {
			$color = "black";
		} else {
        	$count2 = preg_match('/SOLR/', $lines[$sizeof_arr-$i-1]);
			if ($count2 > 0) {
				$color = "blue";
			} else {
				$color = "red";
			}
		}
        $count = preg_match('/Exception/', $lines[$sizeof_arr-$i-1]);
        $count = $count + preg_match('/Notice/', $lines[$sizeof_arr-$i-1]);
        $count = $count + preg_match('/Error/', $lines[$sizeof_arr-$i-1]);
		if ($count > 0) {
			$color = "red";
			$weight = "bold";
		} else {
			$weight = "normal";
		}
        $result = $result . "<font style='color:".$color.";font-weight:".$weight."'>" ;
        $log_line = $lines[$sizeof_arr-$i-1];
        $count = preg_match('/\[.*\]/U', $log_line, $matches);
        if ($count == 0) {
          $result = $result . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          $result = $result . $log_line;
        } else {
          $date_of_log = trim($matches[0],'[]');
          $time_of_log = strtotime($date_of_log) ;
          if ($time_of_log == '') {
            $result = $result . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $result = $result . $log_line;
          } else {
            $result = $result . "<font style='color:#808080;'> Line " .$i . ": </font>" . "<b>" . returnDate($time_of_log) . "</b>: ";
            $result = $result . substr($log_line, strlen($matches[0])+1);
          }
        }
        $result = $result .  "</font>";
        $result = $result . '<br />';
    }
    echo $result;
  } else {
    echo 'NO Log file. Thats a good thing :-).';
  } 
?>
</td>
</tr>
</table>

</BODY>
</HTML>

