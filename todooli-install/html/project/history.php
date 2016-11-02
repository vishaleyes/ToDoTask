<?php
error_reporting(E_ALL);
require_once('config.php');
include('FormValidator.php');

$objConnect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die(mysql_error());
$objDB = mysql_select_db(DB_DATABASE);
$totalRecordsPerPage = PAGE_LIMIT;
$rowCount = 0;
if(!isset($_REQUEST['page'])){
	$page=1;
}else{
	$page = $_REQUEST['page'];
}
$setLimit = 'limit ' .($page - 1) * $totalRecordsPerPage .',' .$totalRecordsPerPage;

$queryCount = "SELECT count(*) as recordcount FROM project_history where 1=1";

if (!$resultSetCount=@mysql_query($queryCount)){
	echo "0";
} else {
	$row1 = mysql_fetch_array($resultSetCount);
	$rowCount = $row1['recordcount'];
} 

$sortType='asc';
$sortBy='id';
$img_name='';
$isortBy='id';
$sortTypePass="desc";
if(isset($_GET["Action"]) && $_GET["Action"] == "sort")
{
	
	if(isset($_GET['sortType']) && $_GET['sortType']=='desc')
	{
		$sortType='desc';
	}
	
	if(isset($_GET['sortBy']) && $_GET['sortBy']!='')
	{
		$sortBy=$_GET['sortBy'];
	}
	$flag=0;
	if(isset($_GET['dflag']) && $_GET['dflag']==1)
	{
		$flag=1;
	}
	$isortBy=$sortBy;
	if($sortType == 'desc'){
			$sortTypePass	=	'asc';
			$img_name	=	'asc.png';
		} else {
			$sortTypePass	=	'desc';
			$img_name	=	'desc.png';
		}
		if($flag == 0){
			$img_name	=	'';
		}
		//$items['sortBy']	=	$sortBy;	
}

$strSQL = "SELECT * FROM project_history where 1=1 ORDER BY ".$sortBy." ".$sortType ." ".$setLimit;
$objQuery = mysql_query($strSQL) or header('Location: index.php?success=3');

$totalRecord = mysql_num_rows($objQuery);

if(!isset($_GET['id']))
{
	$_GET['id']='';	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project history</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo BASE_PATH;?>css/style.css" />
<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-1.7.2.min.js"></script>
<script language="javascript">
var $j = jQuery.noConflict();
	function sendEmail()
	{
		var userEmail=document.getElementById('userEmail').value;
		if(userEmail=='')
		{
			$j("#errorEmail").removeClass();
			$j("#errorEmail").addClass('false');
			$j("#errorEmail").html('Please enter valid email.');
			$j("#errorEmail").fadeIn();
			return false;
		}
		$j.ajax ({
		url:"<?php echo BASE_PATH;?>project_history_email_tpl.php",
		type:'get',
		data:'email='+userEmail,
		success: function(response)
		{
			if(response==1)
			{
					$j('#flashMessage').removeClass();
					$j('#flashMessage').addClass('successmsg');
					$j('#flashMessage').html("Mail sent successfully.");
					$j('#flashMessage').fadeIn();
					$j('#login-form').toggle();
			}
			else
			{
					$j("#errorEmail").removeClass();
					$j("#errorEmail").addClass('false');
					$j("#errorEmail").html('Please enter valid email.');
					$j("#errorEmail").fadeIn();
			}
			//inner tab menu
			//close inner tab menu
			setTimeout(function() { $j("#flashMessage").fadeOut();}, 10000 );
			return false;
		}
		});
	}
</script>
</head>

<body>

<div id="login-form" style="display:none"> 
	<a href="javascript:;" onclick="$j('#login-form').toggle();" class="popupClose"><img src="images/close.png" alt="" border="0" /></a>   
    <div class="field">
        <label>Email:<span id="errorEmail"></span></label>
        <input type="text" id="userEmail" onkeypress="$j('#errorEmail').fadeOut()" name="userEmail" class="textbox" />
    </div>        
    <div class="clear"></div>
    
    <div class="fieldBtn sidelist">
        <input type="submit" value="Send" onclick="sendEmail();"  class="btn" />
    </div>        
    <div class="clear"></div>
</div>

<div class="wrapper">
	<h2 class="floatLeft">Project history</h2>
    <div class="topNav">
    	<a href="index.php">Home</a> | <a href="summary.php">Summary</a>
    </div>
    <div class="clear"></div>
	<h3 align="right"><?php if($rowCount>0){ ?>&nbsp;<a href="javascript:;" onclick="$j('#login-form').toggle();" class="btn">Send Email</a><?php } ?></h3>
    <table border="0" cellpadding="0" cellspacing="0" class="listing">
      <tr>
                 <th><a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=createdAt&Action=sort&dflag=1" >Date
                <?php 
                if($img_name != '' && $isortBy == 'createdAt'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
               </th>
                <th><a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=changed&Action=sort&dflag=1" >Changed
                <?php 
                if($img_name != '' && $isortBy == 'changed'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
               </th>
               <th><a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=projectName&Action=sort&dflag=1" >Project name
                <?php 
                if($img_name != '' && $isortBy == 'projectName'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
               </th>
               <th>
                <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=owner&Action=sort&dflag=1" >Owner
                <?php 
                if($img_name != '' && $isortBy == 'owner'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
               </th>
               <th>
                <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=nextMilestone&Action=sort&dflag=1" >Next milestone
                <?php 
                if($img_name != '' && $isortBy == 'nextMilestone'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
               </th>
               <th>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=isDangerDate&Action=sort&dflag=1" >Date in danger
                <?php 
                if($img_name != '' && $isortBy == 'isDangerDate'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
                </th>
               <th>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=originalDate&Action=sort&dflag=1" >Original date
                <?php 
                if($img_name != '' && $isortBy == 'originalDate'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
                </th>
               <th>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=newDate&Action=sort&dflag=1" >New date
                <?php 
                if($img_name != '' && $isortBy == 'newDate'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
                </th>
                <th>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=status&Action=sort&dflag=1" >Status
                <?php 
                if($img_name != '' && $isortBy == 'status'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
                </th>
                <th>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=issues&Action=sort&dflag=1" >Issues
                <?php 
                if($img_name != '' && $isortBy == 'issues'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
                </th>
                <th>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=actionItems&Action=sort&dflag=1" >Action items
                <?php 
                if($img_name != '' && $isortBy == 'actionItems'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                } ?>
                </a>
                </th>
     </tr>
    <?php if($totalRecord>0){ 
            while($objResult = mysql_fetch_array($objQuery)){	
            $changedArray=unserialize($objResult["changedField"]);
            if(!is_array($changedArray))
            {
                $changedArray=array();
            }
            if($objResult["newDate"]=='' || $objResult["newDate"]=="0000-00-00 00:00:00")
            {
                $newDate="";
            }
            else
            {
                $newDate=date("m-d-Y", strtotime($objResult["newDate"]));	
            }	
            
            
    ?>
     <tr>
        <td><?php echo date("m-d-Y h:m A", strtotime($objResult["createdAt"]));?></td>
        <td <?php if($objResult['changed']=='Deleted'){ echo 'class="red"'; }?> ><?php echo $objResult["changed"];?></td>
        <td <?php if(in_array('projectName',$changedArray)){ echo 'class="red"';}?> ><?php echo $objResult["projectName"];?></td>
        <td <?php if(in_array('owner',$changedArray)){ echo 'class="red"';}?> ><?php echo $objResult["owner"];?></td>
        <td <?php if(in_array('nextMilestone',$changedArray)){ echo 'class="red"';}?> ><?php echo $objResult["nextMilestone"];?></td>
        <td <?php if(in_array('isDangerDate',$changedArray)){ echo 'class="red"';}?> ><?php if($objResult["isDangerDate"]==1){ echo "Yes";}else echo "No"; ?></td>
        <td <?php if(in_array('originalDate',$changedArray)){ echo 'class="red"';}?> ><?php echo date("m-d-Y", strtotime($objResult["originalDate"]));?></td>
        <td <?php if(in_array('newDate',$changedArray)){ echo 'class="red"';}?> ><?php echo $newDate;?></td>
        <td <?php if(in_array('status',$changedArray)){ echo 'class="red"';}?> ><?php if($objResult["status"]==1){ echo 'Green';}else if($objResult["status"]==2){ echo "Yello";}else { echo "Red";} ?></td>
        <td <?php if(in_array('issues',$changedArray)){ echo 'class="red"';}?> ><?php echo $objResult["issues"];?>&nbsp;</td>
        <td <?php if(in_array('actionItems',$changedArray)){ echo 'class="red"';}?> ><?php echo $objResult["actionItems"];?>&nbsp;</td>
        
     </tr>
     
      <?php	}}else{?>
        <tr><td align="left" colspan="9">No history found...</td></tr>
      <?php  } ?>
    </table>
    <div id="pagination-clean" >		
        <?php 
        if($totalRecord>0){
            $totalPage = ceil($rowCount / $totalRecordsPerPage);
            $counter = 1;
            Pagination($totalPage,$page,$counter,$_GET['id']);
        }
        ?>		
    </div>
    <div class="clear"></div>
</div>
</body>
</html>