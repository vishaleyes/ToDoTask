<?php
require_once('config.php');
error_reporting(E_ALL);
$setFlash=array();
$projectDetails['projectName']='Project name';
$projectDetails['owner']='Owner';
$projectDetails['nextMilestone']='Next milestone';
$projectDetails['isDangerDate']='Date in danger';
$projectDetails['newDate']='New date';
$projectDetails['status']='Status';
$projectDetails['issues']='Issues';
$projectDetails['actionItems']='Action items';
if(isset($_GET['success']) && $_GET['success']==1)
{
	//echo "Project added successfully.";	
	$setFlash=array("class"=>'successmsg',"message"=>"Project added successfully.");
}
else if (isset($_GET['success']) && $_GET['success']==2)
{
	//echo "Project Updated Successfully.";	
	$setFlash=array("class"=>'successmsg',"message"=>"Project Updated Successfully.");
}else if (isset($_GET['success']) && $_GET['success']==3)
{
	header('Location: index.php');	
}

include('FormValidator.php');
$objConnect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die(mysql_error());
$objDB = mysql_select_db(DB_DATABASE);
$urlConnect="?";
function validateAddProject($post)
{
	$validator	=	new FormValidator();
	$validator->addValidation("newprojectName","req",'Please enter project name');
	$validator->addValidation("newowner","req",'Please enter owner');
	$validator->addValidation("newnextMilestone","req",'Please enter next Milestone');
	$validator->addValidation("newisDangerDate","req",'Please select danger date status');
	$validator->addValidation("neworiginalDate","req",'Please enter origanal date');
	$validator->addValidation("newstatus","req",'Please select status');
	
	if(!$validator->ValidateForm())
	{
		
		$error_hash = $validator->GetError();
		$status = array('status'=>1,'message'=>$error_hash);
		return $status;
	}
	else
	{
		return array('status'=>0,'message'=>'success');
	}
}


function validateEditProject($post)
{
	$validator	=	new FormValidator();
	$validator->addValidation("projectName","req",'Please enter project name');
	$validator->addValidation("owner","req",'Please enter owner');
	$validator->addValidation("nextMilestone","req",'Please enter next Milestone');
	$validator->addValidation("isDangerDate","req",'Please select danger date status');
	$validator->addValidation("status","req",'Please select status');
	
	if(!$validator->ValidateForm())
	{
		
		$error_hash = $validator->GetError();
		$status = array('status'=>1,'message'=>$error_hash);
		return $status;
	}
	else
	{
		return array('status'=>0,'message'=>'success');
	}
}

//*** Add Condition ***//
if(isset($_POST["hdnCmd"]) && $_POST["hdnCmd"] == "Add")
{
	$isValidObj=validateAddProject($_POST);
	if($isValidObj['status']==0)
	{
		
		$strSQL = "SELECT id FROM project where ";
		$strSQL .=" projectName = '".$_POST["newprojectName"]."' AND ";
		$strSQL .=" owner = '".$_POST["newowner"]."'  AND ";
		$strSQL .=" nextMilestone = '".$_POST["newnextMilestone"]."'  AND ";
		$strSQL .=" isDangerDate = '".$_POST["newisDangerDate"]."'  AND ";
		$strSQL .=" newDate = '".$_POST["neworiginalDate"]." 00:00:00'  AND ";
		$strSQL .=" status = '".$_POST["newstatus"]."'  AND ";
		$strSQL .=" issues = '".$_POST["newissues"]."'  AND ";
		$strSQL .=" actionItems = '".$_POST["newactionItems"]."'  ";
		$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
		$num_rows = mysql_num_rows($objQuery);
		if($num_rows<=0)
		{
			$strSQL = "INSERT INTO project ";
			$strSQL .="(projectName,owner,nextMilestone,isDangerDate,originalDate,status,issues,actionItems,createdAt,modifiedAt) ";
			$strSQL .="VALUES ";
			$strSQL .="('".$_POST["newprojectName"]."','".$_POST["newowner"]."' ";
			$strSQL .=" ,'".$_POST["newnextMilestone"]."' ";
			$strSQL .=",'".$_POST["newisDangerDate"]."','".$_POST["neworiginalDate"]."' ";
			$strSQL .=", '".$_POST["newstatus"]."' ";
			$strSQL .=",'".$_POST["newissues"]."','".$_POST["newactionItems"]."' ";
			$strSQL .=",'".date('Y-m-d h:m:s')."','".date('Y-m-d h:m:s')."') ";
			$objQuery = mysql_query($strSQL);
			if(!$objQuery)
			{
				//echo "Error Save [".mysql_error()."]";
				$setFlash=array("class"=>'errormsg',"message"=>"Error Save [".mysql_error()."]");	
			}
		}
		else
		{
			//echo "Record already exist.";	
				$setFlash=array("class"=>'errormsg',"message"=>"Record already exist.");	
		}
	}
	else
	{
		//echo $isValidObj['message'];
		$setFlash=array("class"=>'errormsg',"message"=>$isValidObj['message']);
	}
	//header("location:$_SERVER[PHP_SELF]");
	//exit();
}

//*** Update Condition ***//
if(isset($_POST["hdnCmd"]) && $_POST["hdnCmd"] == "Update")
{
	
	$errorFlag=0;
	$isValidObj=validateEditProject($_POST);
	if($isValidObj['status']==0)
	{
			$newDate="0000-00-00 00:00:00";	
			if(isset($_POST["newDate"]) && $_POST["newDate"]!='')
			{
				$newDate=$_POST["newDate"];
			}
			$strSQL = "SELECT * FROM project_history where projectId=".$_POST["id"]." order By id desc limit 1";
			$objQuery = mysql_query($strSQL);
			$objResultData = mysql_fetch_array($objQuery);
			$strSQL = "SELECT id FROM project_history where ";
			$strSQL .=" projectName = '".$_POST["projectName"]."' AND ";
			$strSQL .=" owner = '".$_POST["owner"]."'  AND ";
			$strSQL .=" nextMilestone = '".$_POST["nextMilestone"]."'  AND ";
			$strSQL .=" isDangerDate = '".$_POST["isDangerDate"]."'  AND ";
			$strSQL .=" newDate = '".$newDate."'  AND ";
			$strSQL .=" status = '".$_POST["status"]."'  AND ";
			$strSQL .=" issues = '".$_POST["issues"]."'  AND ";
			$strSQL .=" actionItems = '".$_POST["actionItems"]."' and id=".$objResultData['id'];
			$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
			$num_rows = mysql_num_rows($objQuery);
			if($num_rows<=0)
			{
			$changedFields=array();
			$chngedString="";
			
			if(!empty($objResultData))
			{
				$i=1;
				foreach($objResultData as $key=>$value)
				{
					
					if(!is_numeric($key))
					{
						
						if(isset($_POST[$key]) && $key!='id')
						{
							//echo "<br />".$value.'!='.$_POST[$key]."<br />";
							
							if($value!=$_POST[$key])
							{
								if($key=='newDate' && isset($_POST[$key]) && $_POST[$key]=='')
								{
									
								}
								else
								{
														
									$changedFields[]=$key;
									if(isset($projectDetails[$key]))
									{
										$chngedString.=$projectDetails[$key].",";
									}	
								}
							}	
							
						}
					}
					$i++;	
				}				
				
			}
			$changedFieldsArray=serialize($changedFields);
			
			
			/*if($num_rows_history<=0)
			{*/
				$chngedString=substr_replace($chngedString,"",-1);
				$strSQLInsertBkp = "INSERT INTO project_history ";
				$strSQLInsertBkp .="(projectName,owner,nextMilestone,projectId,isDangerDate,originalDate,status,newDate,issues,actionItems,createdAt,modifiedAt,changed,changedField) ";
				$strSQLInsertBkp .="VALUES ";
				$strSQLInsertBkp .="('".$_POST["projectName"]."','".$_POST["owner"]."' ";
				$strSQLInsertBkp .=" ,'".$_POST["nextMilestone"]."'  ,'".$_POST["id"]."' ";
				$strSQLInsertBkp .=",'".$_POST["isDangerDate"]."','".$objResultData["originalDate"]."' ";
				$strSQLInsertBkp .=", '".$_POST["status"]."', '".$_POST["newDate"]."' ";
				$strSQLInsertBkp .=",'".$_POST["issues"]."','".$_POST["actionItems"]."' ";
				$strSQLInsertBkp .=",'".date('Y-m-d h:m:s')."','".date('Y-m-d h:m:s')."','".$chngedString."','".$changedFieldsArray."') ";
				$objQuery = mysql_query($strSQLInsertBkp);
				if(!$objQuery)
				{
					//echo "Error Save [".mysql_error()."]";
					$setFlash=array("class"=>'errormsg',"message"=>"Error Save [".mysql_error()."]");
					$errorFlag=1;
				}
			/*}
			else
			{
				//echo "Already in history.";	
				$setFlash=array("class"=>'errormsg',"message"=>"Already in history.");
				$errorFlag=1;
			}*/
			$strSQL = "UPDATE project SET ";
			$strSQL .="projectName = '".$_POST["projectName"]."' ";
			$strSQL .=",owner = '".$_POST["owner"]."' ";
			$strSQL .=",nextMilestone = '".$_POST["nextMilestone"]."' ";
			$strSQL .=",isDangerDate = '".$_POST["isDangerDate"]."' ";
			$strSQL .=",newDate = '".$_POST["newDate"]."' ";
			$strSQL .=",status = '".$_POST["status"]."' ";
			$strSQL .=",issues = '".$_POST["issues"]."' ";
			$strSQL .=",actionItems = '".$_POST["actionItems"]."' ";
			$strSQL .=",modifiedAt = '".date('Y-m-d h:m:s')."' ";
			$strSQL .="WHERE id = '".$_POST["id"]."' ";
			$objQuery = mysql_query($strSQL);
			if(!$objQuery)
			{
				//echo "Error Update [".mysql_error()."]";
				$setFlash=array("class"=>'errormsg',"message"=>"Error Update [".mysql_error()."]");
			}
			if($errorFlag==0)
			{
				if(!isset($_REQUEST['page']))
				{
					$_REQUEST['page']=1;	
				}
				header('Location: index.php?success=2&page='.$_REQUEST['page']);
				exit;
			}
		
		}
		else
		{
			//echo "Project already exist.";	
			$setFlash=array("class"=>'errormsg',"message"=>"Already in history.");
		}	
	
	}
	else
	{
		//echo $isValidObj['message'];
		$setFlash=array("class"=>'errormsg',"message"=>$isValidObj['message']);
	}
	//header("location:$_SERVER[PHP_SELF]");
	//exit();
}
if(isset($_GET["Action"]) && $_GET["Action"] == "Delete")
{
	if(isset($_GET["id"]) && $_GET["id"]!='' && is_numeric($_GET["id"]))
	{
		$queryFetch = "SELECT * FROM project where id=".$_GET["id"];
		if (!$resultFetchCount=@mysql_query($queryFetch)){
			$setFlash=array("class"=>'errormsg',"message"=>"Project already deleted.");
			$errorFlag=1;
		} else {
			$row_fetch = mysql_fetch_array($resultFetchCount);
			$changedFieldsArray=serialize($projectDetails);
			$chngedString='Deleted';
			$strSQLInsertBkp = "INSERT INTO project_history ";
			$strSQLInsertBkp .="(projectName,owner,nextMilestone,projectId,isDangerDate,originalDate,status,newDate,issues,actionItems,createdAt,modifiedAt,changed,changedField) ";
			$strSQLInsertBkp .="VALUES ";
			$strSQLInsertBkp .="('".$row_fetch["projectName"]."','".$row_fetch["owner"]."' ";
			$strSQLInsertBkp .=" ,'".$row_fetch["nextMilestone"]."'  ,'".$row_fetch["id"]."' ";
			$strSQLInsertBkp .=",'".$row_fetch["isDangerDate"]."','".$row_fetch["originalDate"]."' ";
			$strSQLInsertBkp .=", '".$row_fetch["status"]."', '".$row_fetch["newDate"]."' ";
			$strSQLInsertBkp .=",'".$row_fetch["issues"]."','".$row_fetch["actionItems"]."' ";
			$strSQLInsertBkp .=",'".date('Y-m-d h:m:s')."','".date('Y-m-d h:m:s')."','".$chngedString."','".$changedFieldsArray."') ";
			$objQuery = mysql_query($strSQLInsertBkp);
			if(!$objQuery)
			{
				//echo "Error Save [".mysql_error()."]";
				$setFlash=array("class"=>'errormsg',"message"=>"Error Save [".mysql_error()."]");
				$errorFlag=1;
			}
			
			$deleteProjectSql="DELETE From project where id=".$_GET["id"];	
			$objQuery = mysql_query($deleteProjectSql);
			
			
			$setFlash=array("class"=>'successmsg',"message"=>"Project deleted successfully.");
		}
		
		
	}
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

if(isset($_GET['Action']) && $_GET['Action']='Edit' && isset($_GET['id']))
{
	$urlConnect.="&Action=Edit&id=".$_GET['id'];		
}


//Pagination/////////////
$totalRecordsPerPage = PAGE_LIMIT;
$rowCount = 0;

if(!isset($_REQUEST['page'])){
	$page=1;
}else{
	if($_REQUEST['page']=='' || !is_numeric($_REQUEST['page']))
	{
		$page=1;	
	}
	else
	{
		$page = $_REQUEST['page'];
	}
}
$urlConnect.='&page='.$page;
$setLimit = 'limit ' .($page - 1) * $totalRecordsPerPage .',' .$totalRecordsPerPage;

$queryCount = "SELECT count(*) as recordcount FROM project";

if (!$resultSetCount=@mysql_query($queryCount)){
	//echo "0";
} else {
	$row1 = mysql_fetch_array($resultSetCount);
	$rowCount = $row1['recordcount'];
}

//End of pagination //////////

$strSQL	=	'SELECT * FROM project ORDER BY '.$sortBy.' '.$sortType .' '.$setLimit;
	

$objQuery = mysql_query($strSQL);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtm	+l">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project Document</title>
<link type="text/css" rel="stylesheet" href="<?php echo BASE_PATH;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo BASE_PATH;?>css/custom-theme/jquery-ui-1.8.13.custom.css" />
<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-ui-1.8.13.custom.min.js"></script>
<script language="javascript">

	var $j = jQuery.noConflict();
	$j(document).ready(function()
	{
		
		
		$j("#flashMessage").click(function() {
			$j("#flashMessage").fadeOut();
		});
			$j(".deleteIcon").click(function() {
				  /*jConfirm('##_ASSIGNED_BY_ME_AJAX_CLOSE_TODO_##', 'Confirmation dialog', function(res){
                    if(res == true){
							
					}
					});	*/
				result=confirm("Are you sure want to delete this project?"); 
				if(result==true)
				{
					window.location=$j(this).attr('lang');	
				}
				//alert(result);
		});
		
		
		
	$j('.sort').click(function() {
		var url	=	$j(this).attr('lang');
		$j('#items').load(url);
	});
	});
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
<link type="text/css" rel="stylesheet" href="css/custom-theme/jquery-ui-1.8.13.custom.css" />
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
        <input type="button" value="Send" onclick="sendEmail();"  class="btn" />
    </div>        
    <div class="clear"></div>
</div>

<div class="wrapper">
 	<h2 class="floatLeft">Project Management</h2>
    <div class="topNav">
    	<a href="<?php echo $_SERVER["PHP_SELF"];?>">Home</a> | <a href="summary.php">Summary</a> | <a href="history.php">History</a>
    </div>
    <div class="clear"></div>
    
    <h3 align="right"><a href="add.php" class="btn">Add Project</a>  <?php if($rowCount>0){ ?>&nbsp;<a href="javascript:;" onclick="$j('#login-form').toggle();" class="btn">Send Email</a><?php } ?></h3>
    <div id="flashMessage">
    <?php if(isset($setFlash) && isset($setFlash['message'])){?>
    <div class="<?php echo $setFlash['class'];?>">
    	<?php echo $setFlash['message'];?>
    </div>
	<?php }?>
    </div>
     <div class="clear"></div>
    <form name="frmMain" method="post" action="<?php echo $_SERVER["PHP_SELF"].$urlConnect;?>">
        <input type="hidden" name="hdnCmd" value="">
        <table border="0" cellpadding="0" cellspacing="0" class="listing">
            <tr>
                <th width="10%">
                	<a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=projectName&Action=sort&dflag=1" >Project name
                <?php 
                if($img_name != '' && $isortBy == 'projectName'){ ?>
                <img src="images/<?php echo $img_name;?>" class="sortImage" />
                <?php
                } ?>
                </a>
                </th>
                <th width="8%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=owner&Action=sort&dflag=1" >Owner
                    <?php 
                    if($img_name != '' && $isortBy == 'owner'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                    } ?>
                    </a>
                </th>
                <th width="10%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=nextMilestone&Action=sort&dflag=1" >Next milestone
                    <?php 
                    if($img_name != '' && $isortBy == 'nextMilestone'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                    } ?>
                    </a>
                </th>
                <th width="5%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=isDangerDate&Action=sort&dflag=1" >Date in danger
                    <?php 
                    if($img_name != '' && $isortBy == 'isDangerDate'){ ?>
                    <img src="images/<?php echo $img_name;?>" class="sortImage" />
                    <?php
                    } ?>
                    </a>
                </th>
                <th width="7%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=originalDate&Action=sort&dflag=1" >Original date
						<?php 
                        if($img_name != '' && $isortBy == 'originalDate'){ ?>
                        <img src="images/<?php echo $img_name;?>" class="sortImage" />
                        <?php
                        } ?>
                    </a>
                </th>
                <th width="7%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=newDate&Action=sort&dflag=1" >New date
						<?php 
                        if($img_name != '' && $isortBy == 'newDate'){ ?>
                        <img src="images/<?php echo $img_name;?>" class="sortImage" />
                        <?php
                        } ?>
                    </a>
                </th>
                <th width="5%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=status&Action=sort&dflag=1" >Status
						<?php 
                        if($img_name != '' && $isortBy == 'status'){ ?>
                        <img src="images/<?php echo $img_name;?>" class="sortImage" />
                        <?php
                        } ?>
                    </a>
                </th>
                <th width="20%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=issues&Action=sort&dflag=1" >Issues
						<?php 
                        if($img_name != '' && $isortBy == 'issues'){ ?>
                        <img src="images/<?php echo $img_name;?>" class="sortImage" />
                        <?php
                        } ?>
                    </a>
                </th>
                <th width="20%">
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>?sortType=<?php echo $sortTypePass;?>&sortBy=actionItems&Action=sort&dflag=1" >Action items
						<?php 
                        if($img_name != '' && $isortBy == 'actionItems'){ ?>
                        <img src="images/<?php echo $img_name;?>" class="sortImage" />
                        <?php
                        } ?>
                    </a>
                </th>
                <th colspan="2" width="8%">Action</th>
            </tr>
        <?php
		 if($rowCount>0)
		{
			while($objResult = mysql_fetch_array($objQuery))
			{ 
				?>
				  <?php
					if(isset($_GET["id"]) && isset($_GET["Action"]) && $objResult["id"] == $_GET["id"] && $_GET["Action"] == "Edit")
					{
				  ?>
				 		<td>
                            <input type="hidden" name="id" value="<?php echo $_GET["id"];?>" />
                            <input type="text" name="projectName" value="<?php if(isset($_POST['projectName'])){ echo $_POST['projectName']; }else if(isset($objResult["projectName"])){echo $objResult["projectName"];}?>" class="textbox" />
                        </td>
                        <td> 
                        <input type="text" name="owner"  value="<?php if(isset($_POST['owner'])){ echo $_POST['owner']; }else if(isset($objResult["owner"])){echo $objResult["owner"];}?>" class="textbox" />
                        </td>
                        <td> 
                        <input type="text" name="nextMilestone" value="<?php if(isset($_POST['nextMilestone'])){ echo $_POST['nextMilestone']; }else if(isset($objResult["nextMilestone"])){echo $objResult["nextMilestone"];} ?>" class="textbox" />
                        </td>
                        <td>
                            <div class="checkbox">
                                <input type="radio" name="isDangerDate" <?php if(isset($_POST['newisDangerDate']) && $_POST['newisDangerDate']==0){ echo 'checked="checked"'; } else if(isset($objResult["newisDangerDate"]) && $objResult["newisDangerDate"]==0){ echo 'checked="checked"';} ?> checked value="0" /><span>No</span>
                           </div>
                            <div class="checkbox"><input type="radio" name="isDangerDate" <?php if(isset($_POST['newisDangerDate']) && $_POST['newisDangerDate']==1){ echo 'checked="checked"'; } else if(isset($objResult["newisDangerDate"]) && $objResult["newisDangerDate"]==1){ echo 'checked="checked"';}?>  value="1" /><span>Yes</span>
                            </div>
                        </td>
                        <td> 
                        <input type="text" id="startdate" name="originalDate" disabled="disabled"  value="<?php if(isset($objResult["originalDate"])){echo $objResult["originalDate"];}else { echo date("Y/m/d", strtotime("1 days"));}?>" class="textbox" />
                        </td>
                        <td>      
                    	<input type="text" id="newDate" name="newDate" value="<?php if(isset($_POST['newDate'])){ echo $_POST['newDate']; } else if(isset($objResult["newDate"]) && $objResult["newDate"]!="0000-00-00 00:00:00"){echo $objResult["newDate"];} ?>" class="textbox" />
					<?php
                    $date = strtotime(date("Y/m/d", strtotime($objResult["originalDate"])) . " +1 day");
                    ?>
					<script language="javascript">
                    var $j = jQuery.noConflict();
                    $j(document).ready(function()
                    {
                    $j(function() {
                            var dates = $j( "#newDate" ).datepicker({
                                defaultDate: "<?php echo date("Y-m-d", $date);?>",
                                minDate: "<?php echo date("Y-m-d", $date);?>",
                                dateFormat: "yy-mm-dd" ,
                                changeMonth: true,
                                numberOfMonths: 1,
                                onSelect: function( selectedDate ) {
                                    var option = this.id == "newDate" ? "minDate" : "maxDate",
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
						</td>
                        <td>
                			<select name="status" class="selectbox">
                    <option <?php if(isset($_POST['status']) && ($_POST['status']==1)){ echo 'selected="selected"'; } else if(isset($objResult["status"]) && $objResult["status"]==1){ echo 'selected="selected"';} ?> value="1">Green</option>
                    <option <?php if(isset($_POST['status']) && ($_POST['status']==2)){ echo 'selected="selected"'; } else if(isset($objResult["status"]) && $objResult["status"]==2){ echo 'selected="selected"';}  ?> value="2">Yellow</option>
                    <option <?php if(isset($_POST['status']) && ($_POST['status']==3)){ echo 'selected="selected"'; } else if(isset($objResult["status"]) && $objResult["status"]==3){ echo 'selected="selected"';} ?> value="3">Red</option>
                </select>
                		</td>
                        <td> 
                        	<textarea name="issues" class="textarea"><?php if(isset($_POST['issues'])){ echo $_POST['issues']; }else if(isset($objResult["issues"])) {echo $objResult["issues"];} ?></textarea>
                        </td>
                        <td>
                        	<textarea name="actionItems" class="textarea"><?php if(isset($_POST['actionItems'])){ echo $_POST['actionItems']; } else if(isset($objResult["actionItems"])){ echo $objResult["actionItems"];}?></textarea>
                       </td>
                        <td colspan="2">
                        	<input type="submit" value="Update" name="hdnCmd"  />
                        	<input type="button" value="Cancel" onclick="javascript:window.location='index.php';" />
                        </td>	
				  <?php
					}
				  else
					{	
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
                        <td><?php echo $objResult["projectName"];?></td>
                        <td><?php echo $objResult["owner"];?></td>
                        <td><?php echo $objResult["nextMilestone"];?></td>
                        <td align="center"><?php if($objResult["isDangerDate"]==1){ echo "Yes";}else echo "No"; ?></td>
                        <td><?php echo date("m-d-Y", strtotime($objResult["originalDate"]));?></td>
                        <td><?php echo $newDate;?></td>
                        <td align="center"><?php if($objResult["status"]==1){ echo '<span>Green</span>';}else if($objResult["status"]==2){ echo '<span>Yellow</span>';}else { echo '<span>Red</span>';} ?></td>
                        <td><?php echo $objResult["issues"];?>&nbsp;</td>
                        <td><?php echo $objResult["actionItems"];?>&nbsp;</td>
                        <td colspan="2" align="center">
                        	<a class="editIcon"  href="<?php echo $_SERVER["PHP_SELF"];?>?Action=Edit&id=<?php echo $objResult["id"].'&page='.$page;?>">Edit</a> | 
                        	<a class="deleteIcon" lang="<?php echo $_SERVER["PHP_SELF"];?>?Action=Delete&id=<?php echo $objResult["id"];?>">Delete</a>
                        </td>
                      </tr>
				  <?php
					}				
				}		  
        	}
			else
			{
        	?>
          		<tr>
                	<td colspan="11" style="padding-left:10px;">No record found.</td>
                </tr>
			<?php
			}
			?>
        
        </table>
        <div id="pagination-clean">		
			<?php 
            if($rowCount>0){
                $totalPage = ceil($rowCount / $totalRecordsPerPage);
                $counter = 1;
                Pagination($totalPage,$page,$counter);			
            }
            ?>		
		</div>
        <div class="clear"></div>
    </form>

<?php
mysql_close($objConnect);
?>
</div>
</body>
</html>