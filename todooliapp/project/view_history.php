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

$queryCount = "SELECT count(*) as recordcount FROM project_history where projectId =".$_GET['id']."";

if (!$resultSetCount=@mysql_query($queryCount)){
	echo "0";
} else {
	$row1 = mysql_fetch_array($resultSetCount);
	$rowCount = $row1['recordcount'];
} 

$sortType='desc';
$sortBy='id';
$img_name='';
$isortBy='id';
$sortTypePass="asc";
if(isset($_GET["Action"]) && $_GET["Action"] == "sort")
{
	
	if(isset($_GET['sortType']) && $_GET['sortType']=='asc')
	{
		$sortType='asc';
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

$strSQL = "SELECT * FROM project_history where projectId =".$_GET['id']." ORDER BY ".$sortBy." ".$sortType ." ".$setLimit;
$objQuery = mysql_query($strSQL) or header('Location: index.php?success=3');

$totalRecord = mysql_num_rows($objQuery);
$SQL_project= "SELECT projectName FROM project where id =".$_GET['id'];
$objQuery_project = mysql_query($SQL_project) or header('Location: index.php?success=3');
$objResult_project = mysql_fetch_array($objQuery_project);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project history</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo BASE_PATH;?>css/style.css" />
</head>

<body>
<div class="wrapper">
<h2><?php echo $objResult_project["projectName"]; ?> history</h2><h3 align="right"><a href="index.php" class="btn">Back</a></h3>
<table border="0" cellpadding="0" cellspacing="0" class="listing">
  <tr>
    	   <th><a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=projectName&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Project name
            <?php 
            if($img_name != '' && $isortBy == 'projectName'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
           </th>
           <th>
           	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=owner&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Owner
            <?php 
            if($img_name != '' && $isortBy == 'owner'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
           </th>
           <th>
           	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=nextMilestone&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Next milestone
            <?php 
            if($img_name != '' && $isortBy == 'nextMilestone'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
           </th>
           <th>
            	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=isDangerDate&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Date in danger
            <?php 
            if($img_name != '' && $isortBy == 'isDangerDate'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
            </th>
           <th>
            	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=originalDate&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Original date
            <?php 
            if($img_name != '' && $isortBy == 'originalDate'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
            </th>
           <th>
            	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=newDate&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >New date
            <?php 
            if($img_name != '' && $isortBy == 'newDate'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
            </th>
            <th>
            	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=status&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Status
            <?php 
            if($img_name != '' && $isortBy == 'status'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
            </th>
            <th>
            	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=issues&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Issues
            <?php 
            if($img_name != '' && $isortBy == 'issues'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
            </th>
            <th>
            	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=actionItems&Action=sort&id=<?php echo $_GET['id'];?>&dflag=1" >Action items
            <?php 
            if($img_name != '' && $isortBy == 'actionItems'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
            } ?>
            </a>
            </th>
 </tr>
<?php if($totalRecord>0){ while($objResult = mysql_fetch_array($objQuery)){	?>
 <tr>
    <td><?php echo $objResult["projectName"];?></td>
    <td><?php echo $objResult["owner"];?></td>
    <td><?php echo $objResult["nextMilestone"];?></td>
    <td><?php if($objResult["isDangerDate"]==1){ echo "Yes";}else echo "No"; ?></td>
    <td><?php echo $objResult["originalDate"];?></td>
    <td><?php echo $objResult["newDate"];?></td>
    <td><?php if($objResult["status"]==1){ echo 'Green';}else if($objResult["status"]==2){ echo "Yello";}else { echo "Red";} ?></td>
    <td><?php echo $objResult["issues"];?>&nbsp;</td>
    <td><?php echo $objResult["actionItems"];?>&nbsp;</td>
    
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