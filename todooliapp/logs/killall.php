<HTML>
<?php include_once("config.php");?>
<HEAD><title><?php echo _SITENAME_;?> - Health check</title></HEAD>
<BODY> 
<?php 
$deamons = array( "hirenow", "contact_seekers", "seekers_response", "send_sms", "send_email", "rcv_sms" , "seeker_updated", "bulk_update", "rcv_rest","rcv_rest_expire","rcv_android_note","rcv_iphone_note") ;

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

$minusdate = date('ymdHi') - $querydate;

if($minusdate > 88697640 && $minusdate < 100000000){
    $minusdate = $minusdate - 88697640;
}

    switch ($minusdate) {

        case ($minusdate < 99):
                    if($minusdate == 1){
                        $date_string = '1 minute ago';
                    }
                    elseif($minusdate > 59){
                        $date_string =  ($minusdate - 40).' minutes ago';
                    }
                    elseif($minusdate > 1 && $minusdate < 59){
                        $date_string = $minusdate.' minutes ago';
                    }
        break;

        case ($minusdate > 99 && $minusdate < 2359):
                    $flr = floor($minusdate * .01);
                    if($flr == 1){
                        $date_string = '1 hour ago';
                    }
                    else{
                        $date_string =  $flr.' hours ago';
                    }
        break;
       
        case ($minusdate > 2359 && $minusdate < 310000):
                    $flr = floor($minusdate * .0001);
                    if($flr == 1){
                        $date_string = '1 day ago';
                    }
                    else{
                        $date_string =  $flr.' days ago';
                    }
        break;
       
        case ($minusdate > 310001 && $minusdate < 12320000):
                    $flr = floor($minusdate * .000001);
                    if($flr == 1){
                        $date_string = "1 month ago";
                    }
                    else{
                        $date_string =  $flr.' months ago';
                    }
        break;
       
        case ($minusdate > 100000000):
                $flr = floor($minusdate * .00000001);
                if($flr == 1){
                        $date_string = '1 year ago.';
                }
                else{
                        $date_string = $flr.' years ago';
                }
        }
       

   
    return $date_string;
}


/**
 * get file size of log file
 */
function get_logfile_size($file, $file2) {
  if (file_exists($file)) {
    $result = '<td>' . filesize($file) . '</td>' . '<td>' . date ("F d Y H:i:s.", filemtime($file)) . '</td>' . '<td>' ;
    $lines = read_file($file, 0);
    foreach ($lines as $line) {
        $result = $result . $line;
        $result = $result . '<br />';
    }
    $result = $result . "<a href=\"" . $file2 . "\">logFile </a>";
    $result = $result . '</td>';
    return $result;
  } else {
    echo '<td>NO SUCH FILE</td><td>&nbsp;</td><td>&nbsp;</td>';
  } 
}

/**
 * get restart count for the daemon from the .cnt file
 */
function get_restart_count($file) {
  if (file_exists($file)) {
    return '<td>' . file_get_contents($file) . '</td>' . '<td>' . date ("F d Y H:i:s.", filemtime($file)) . '</td>' ;
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
    exec("ps -ef | grep -i $file | grep -v grep", $pids);
    //print_r($pids);
    if (count($pids) >= 1) {
		$pieces = preg_split("/[\s,]+/", $pids[0]);
    	//print_r($pieces);
        $exists = $pieces[1];
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
    exec("ps -ef | grep -i $file | grep -v grep", $pids);
    print_r($pids);
    if (count($pids) >= 1) {
        $exists = true; 
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
    exec("ps -ef | grep -i $file | grep -v grep | awk '{print $2}'", $pids);
    // print_r($pids);
    if (count($pids) >= 1) {
        $exists = true; 
		echo "<BR> Process is ".$pids[0];
    	exec("kill ".$pids[0]);
    }
    return $exists;
}

/**
 * kill process All if running
 * @param $file[optional] Filename
 * @return Boolean
 */
function killProcessAll($file = false) {
    $exists     = false;
    $file       = $file ? $file : __FILE__;

    // Check if file is in process list
    // echo $file;
    while (true) {
      $pids = '';
      $exists = false; 
      exec("ps -ef | grep -i $file | grep -v grep | awk '{print $2}'", $pids);
      // print_r($pids);
      if (count($pids) >= 1) {
        $exists = true; 
	echo "<BR> Process is ".$pids[0];
    	exec("kill ".$pids[0]);
      }
      if ($exists === false)
        break;
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
    exec("ps -ef | grep -i $file | grep -v grep", $pids);
    // print_r($pids);
    if (count($pids) == 1) {
        $exists = true; 
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
   echo "<font style=\"color:green;font-weight:bold;\">$lines[0]</font><br />";
}


  killProcessAll("daemon_");
?>

