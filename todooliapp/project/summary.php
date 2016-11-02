<?php
require_once('config.php');
$objConnect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die(mysql_error());
$objDB = mysql_select_db(DB_DATABASE);

if (isset($_POST['startDate'])) {
  $startDate = $_POST['startDate'];
} else {
  $startDate = date("Y-m-d", strtotime("-6 months"));
}

if (isset($_POST['endDate'])) {
  $endDate = $_POST['endDate'];
} else {
  $endDate = date("Y-m-d", strtotime("+12 months"));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project summary</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo BASE_PATH;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo BASE_PATH;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-ui-1.8.13.custom.min.js"></script>
<script language="javascript">
                    var $j = jQuery.noConflict();
                    $j(document).ready(function()
                    {
						$j(function() {
							var dates = $j( "#startDate, #endDate" ).datepicker({
								defaultDate: "+1w",
								changeMonth: true,
								 dateFormat: "yy-mm-dd" ,
								numberOfMonths: 1,
								onSelect: function( selectedDate ) {
									var option = this.id == "startDate" ? "minDate" : "maxDate",
										instance = $j( this ).data( "datepicker" ),
										date = $j.datepicker.parseDate(
											instance.settings.dateFormat ||
											$j.datepicker._defaults.dateFormat,
											selectedDate, instance.settings );
									dates.not( this ).datepicker( "option", option, date );
								}
							});
						});
                    });
    
                </script>
</head>

<body>
<div class="wrapper">
	<h2 class="floatLeft">Project summary</h2>
    <div class="topNav">
    	<a href="index.php">Home</a> | <a href="history.php">History</a>
    </div>
    <div class="clear"></div>
	<h3 align="right"><a href="index.php" class="btn">Back</a></h3>
      
    <form id="selectionForm" name="selectionForm" method="post" action="">
    
    <div class="field sidelist">
        <label>Start date:</label>
        <input type="text" id="startDate"  name="startDate" value="<?php echo $startDate;?>" class="textbox width150" />
    </div>
    
    <div class="field sidelist">
        <label>End date:</label>
        <input type="text" id="endDate" name="endDate" value="<?php echo $endDate;?>" class="textbox width150" />
    </div>
    
    <div class="fieldBtn sidelist">
    	<input type="submit" name="btnSubmit" value="submit" class="btn"   />
    </div>
    
    <div class="clear"></div>
    
    </form>
</div>

<div style="float:clear;"> </div>

<?php
$sqlProject="select * from project_history where IF(newDate Like '%0000%',originalDate,newDate) >= '".$startDate."' && IF(newDate Like '%0000%',originalDate,newDate) <= '".$endDate."'";
//$sqlProject = "SELECT id,projectName,originalDate,newDate,status,owner FROM project";
$resultProjects=@mysql_query($sqlProject);
$numOfProjects = mysql_num_rows($resultProjects);
$projects=array();
$smallestDate = null;
if($numOfProjects>0)
{
	while($objResult = mysql_fetch_array($resultProjects))
	{
		$tempData=array();
		$tempData['id']=$objResult['id'];
		$tempData['projectName']=$objResult['projectName'];
		$tempData['originalDate']=$objResult['originalDate'];
		$tempData['newDate']=$objResult['newDate'];
                $milestoneDate = $tempData['newDate'];
                if ($milestoneDate == '0000-00-00 00:00:00') {
                   $milestoneDate = $tempData['originalDate'];
                }
                if ($smallestDate == null) {
                  $smallestDate = strtotime($milestoneDate); 
                } else {
                  $m_date = strtotime($milestoneDate); 
                  if ($m_date < $smallestDate) {
                     $smallestDate = $m_date;
                  }
                }
		$tempData['status']=$objResult['status'];
		$tempData['owner']=$objResult['owner'];
		$projects[]=$tempData;
	}
} 

//print_r($projects);

$startDate = strtotime('last monday', $smallestDate);

echo '<div style="padding:20px;">';
echo '<table border=1 cellpadding=0 cellspacing=0 style="border-color:white;border-style:solid; font-size:10px;">';
echo '<tr>';
echo '<td width=200 style="border-color:white;border-style:solid;">';
echo '&nbsp;';
echo '</td>';
echo '<td width=32 style="border-color:white;border-style:solid;">&nbsp;</td>';
for ($j = 1; $j < 26; $j++ ) { 
    $weekDate = $startDate + ($j * 14 * 24 * 60 * 60);
    $week2Date = $startDate + (($j-1) * 14 * 24 * 60 * 60);
    $m1 = date("n", $weekDate); 
    $m2 = date("n", $week2Date); 
    if ($m1 >= $m2) { 
      echo '<td width=32 style="border-color:white;border-style:solid;">';
      echo '&nbsp;';
    } else {
      echo '<td width=32 style="border-color:white;border-style:solid;border-left:1px gray solid;">';
      echo '&nbsp;';
      echo date("Y", $weekDate);
    }
    echo '</td>';
}
echo '</tr>';
echo '</table>';
echo '<table border=1 cellpadding=0 cellspacing=0 bordercolor=green style="font-size:10px;">';
for ($i = 0; $i < count($projects) ; $i++ ) { 
  if ($projects[$i]['status'] != 1) {
    continue;
  }    
  echo '<tr>';
  echo '<td width="200">';
  echo $projects[$i]['projectName'];
  echo '</td>';
  $milestoneDate = $projects[$i]['newDate'];
  if ($milestoneDate == '0000-00-00 00:00:00') {
    $milestoneDate = $projects[$i]['originalDate'];
  }
  $m_date = strtotime($milestoneDate);
  for ($j = 0; $j < 26; $j++ ) { 
    $weekDate = $startDate + ($j * 14 * 24 * 60 * 60);
    $week2Date = $startDate + (($j+1) * 14 * 24 * 60 * 60);
    if (($m_date >= $weekDate) && ($m_date < $week2Date)) {
      echo '<td bgcolor=green width=32>&nbsp;</td>';
    } else {
      echo '<td width=32>&nbsp;</td>';
    }
  }
  echo '</tr>';
}
echo '</table>';

echo '<table border=1 cellpadding=0 cellspacing=0 bordercolor=lightgray style="font-size:10px;">';
echo '<tr>';
echo '<td width=200>';
echo '&nbsp;';
echo '</td>';
for ($j = 0; $j < 26; $j++ ) { 
    echo '<td bgcolor=lightgray width=32>';
    $weekDate = $startDate + ($j * 14 * 24 * 60 * 60);
    echo date("m/d", $weekDate);
    echo '</td>';
}
echo '</tr>';
echo '</table>';

echo '<table border=1 cellpadding=0 cellspacing=0 bordercolor=yellow style="font-size:10px;">';
for ($i = 0; $i < count($projects) ; $i++ ) { 
  if ($projects[$i]['status'] != 2) {
    continue;
  }    
  echo '<tr>';
  echo '<td width=200>';
  echo $projects[$i]['projectName'];
  echo '</td>';
  $milestoneDate = $projects[$i]['newDate'];
  if ($milestoneDate == '0000-00-00 00:00:00') {
    $milestoneDate = $projects[$i]['originalDate'];
  }
  $m_date = strtotime($milestoneDate);
  for ($j = 0; $j < 26; $j++ ) { 
    $weekDate = $startDate + ($j * 14 * 24 * 60 * 60);
    $week2Date = $startDate + (($j+1) * 14 * 24 * 60 * 60);
    if (($m_date >= $weekDate) && ($m_date < $week2Date)) {
      echo '<td bgcolor=yellow width=32>&nbsp;</td>';
    } else {
      echo '<td width=32>&nbsp;</td>';
    }
  }
  echo '</tr>';
}
echo '</table>';

echo '<table border=1 cellpadding=0 cellspacing=0 bordercolor=red style="font-size:10px;">';
for ($i = 0; $i < count($projects) ; $i++ ) { 
  if ($projects[$i]['status'] != 3) {
    continue;
  }    
  echo '<tr>';
  echo '<td width=200>';
  echo $projects[$i]['projectName'];
  echo '</td>';
  $milestoneDate = $projects[$i]['newDate'];
  if ($milestoneDate == '0000-00-00 00:00:00') {
    $milestoneDate = $projects[$i]['originalDate'];
  }
  $m_date = strtotime($milestoneDate);
  for ($j = 0; $j < 26; $j++ ) { 
    $weekDate = $startDate + ($j * 14 * 24 * 60 * 60);
    $week2Date = $startDate + (($j+1) * 14 * 24 * 60 * 60);
    if (($m_date >= $weekDate) && ($m_date < $week2Date)) {
      echo '<td bgcolor=red width=32>&nbsp;</td>';
    } else {
      echo '<td width=32>&nbsp;</td>';
    }
  }
  echo '</tr>';
}
echo '</table>';


echo '</div>';

?>

</body>
</html>
