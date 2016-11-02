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

    .button {
      background:none!important;
      border:none; 
      padding:0!important;
      /* border is optional */
      border-bottom:1px solid #444; 
    }
    form input[type="submit"]{

    background: none;
    border: none;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
    }


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
$daemons = array( "send_sms", "send_email", "rcv_sms" , "rcv_rest","rcv_rest_expire","rcv_android_note","rcv_iphone_note", "reminder", "todo_updated", "notify_users") ;

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
	$command = "/home/todooli/html2/utils/msg_send 200369 update";
	system($command);
    sleep(10);
}

function svninfo() 
{
	echo "Current version here<br />" ;
	$command = "cd /home/todooli/html2 ; svn info | grep 'Rev\|Last'; cd logs ;";
	system($command);
	//echo "<br />Latest version in repo<br />" ;
	//$command = 'cd /var/www/html ; svn info -r HEAD ; cd logs ;';
	//system($command);
}

function start_all() 
{
	echo "Starting all" ;
	$command = "/home/todooli/html2/utils/msg_send 200369 start";
	system($command);
    sleep(10);
}

function stop_all() 
{
	echo "Stopping All" ;
	$command = "/home/todooli/html2/utils/msg_send 200369 stop";
	system($command);
    sleep(10);
}

if(isset($_POST['submit'])) 
{ 
    error_log("INFO Request to " . $_POST['action'] . " daemon: " . $_POST['name'] . " is received");
    if (strcasecmp($_POST['action'], "start all") == 0) {
        start_all();
	}
    if (strcasecmp($_POST['action'], "stop all") == 0) {
        stop_all();
	}
}
?>

<!-- overlayed element -->

<div class="apple_overlay" id="overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>

</div>

<!--
<table border="1" style="width:80%">
<tr>
<td style="vertical-align:top;">
<img src="/logs/pause.png" />
<br />
<FORM method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="hidden" name="name" value="all" />
   <input type="hidden" name="action" value="Stop All" />
   <input type="submit" name="submit" value="Stop All"><br>
</FORM>
</td>
<td style="vertical-align:top;">
<img src="/logs/play.png" />
<br />
<FORM method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="hidden" name="name" value="all" />
   <input type="hidden" name="action" value="Start All" />
   <input type="submit" name="submit" value="Start All"><br>
</FORM>
</td>
</tr>
</table>
-->

<table border="1">
<tr>
<?php foreach ($daemons as $daemon) {
        echo "<td>" . $daemon . "</td> ";
      }
?>
</tr>
<tr>
<?php foreach ($daemons as $daemon) {
        $processName = "todooli_daemon_" . $daemon . ".php" ;
        if (processExists($processName)) {
	      echo "<td>RUNNING</td>" ;
  	      //echo getProcessID($processName);
        } else {
	      echo "<td style=\"color:red;font-weight:bold;\">Not RUNNING" ;
	      echo "</td>" ;
        }
      }
?>
</tr>
</table>
<br />
<hr />
Daemon Error Log
<table width="100%">
<tr>
<td>
<?php foreach ($daemons as $daemon) {
        $logName = $daemon.".log" ;
        $logFile = LOGS_PATH.$logName;
        if (file_exists($logFile)) {
          $lines = read_file($logFile, 600);
          $sizeof_arr = sizeof($lines);
          for ($i=0; $i<$sizeof_arr; $i++) {
            $count = preg_match('/Error/', $lines[$i]);
		    if ($count > 0) {
              echo $lines[$i];
            }
          }
        }
      }
?>
</td>
</tr>
</table>
<br />
<hr />
PHP Log
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

