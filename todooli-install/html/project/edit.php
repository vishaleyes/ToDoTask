<?php
error_reporting(E_ALL);
require_once('FormValidator.php');
require_once('config.php');
$objConnect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die(mysql_error());
$objDB = mysql_select_db(DB_DATABASE);
$setFlash=array();
function validateAddProject($post)
{
	$validator	=	new FormValidator();
	$validator->addValidation("projectName","req",'Please enter project name');
	$validator->addValidation("owner","req",'Please enter owner');
	$validator->addValidation("nextMilestone","req",'Please enter next Milestone');
	$validator->addValidation("isDangerDate","req",'Please select danger date status');
	$validator->addValidation("originalDate","req",'Please enter origanal date');
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
	//error_reporting(E_ALL);
	$isValidObj=validateAddProject($_POST);
	if($isValidObj['status']==0)
	{
		$strSQL = "SELECT id FROM project where ";
		$strSQL .=" projectName = '".$_POST["projectName"]."' AND ";
		$strSQL .=" owner = '".$_POST["owner"]."'  AND ";
		$strSQL .=" nextMilestone = '".$_POST["nextMilestone"]."'  AND ";
		$strSQL .=" isDangerDate = '".$_POST["isDangerDate"]."'  AND ";
		$strSQL .=" originalDate = '".$_POST["originalDate"]." 00:00:00'  AND ";
		$strSQL .=" status = '".$_POST["status"]."'  AND ";
		$strSQL .=" issues = '".$_POST["issues"]."'  AND ";
		$strSQL .=" actionItems = '".$_POST["actionItems"]."'  ";
		$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
		$num_rows = mysql_num_rows($objQuery);
		if($num_rows<=0)
		{
			$strSQL = "INSERT INTO project ";
			$strSQL .="(projectName,owner,nextMilestone,isDangerDate,originalDate,status,issues,actionItems,createdAt,modifiedAt) ";
			$strSQL .="VALUES ";
			$strSQL .="('".$_POST["projectName"]."','".$_POST["owner"]."' ";
			$strSQL .=" ,'".$_POST["nextMilestone"]."' ";
			$strSQL .=",'".$_POST["isDangerDate"]."','".$_POST["originalDate"]."' ";
			$strSQL .=", '".$_POST["status"]."' ";
			$strSQL .=",'".$_POST["issues"]."','".$_POST["actionItems"]."' ";
			$strSQL .=",'".date('Y-m-d h:m:s')."','".date('Y-m-d h:m:s')."') ";
			$objQuery = mysql_query($strSQL);
			$id = mysql_insert_id();
			if(!$objQuery)
			{
				$setFlash=array("class"=>'errormsg',"message"=>"Error Save [".mysql_error()."]");
			}
			
			$strSQLHISTORY = "SELECT id FROM project_history where ";
			$strSQLHISTORY .=" projectName = '".$_POST["projectName"]."' AND ";
			$strSQLHISTORY .=" owner = '".$_POST["owner"]."'  AND ";
			$strSQLHISTORY .=" nextMilestone = '".$_POST["nextMilestone"]."'  AND ";
			$strSQLHISTORY .=" isDangerDate = '".$_POST["isDangerDate"]."'  AND ";
			$strSQLHISTORY .=" originalDate = '".$_POST["originalDate"]." 00:00:00'  AND ";
			$strSQLHISTORY .=" status = '".$_POST["status"]."'  AND ";
			$strSQLHISTORY .=" issues = '".$_POST["issues"]."'  AND ";
			$strSQLHISTORY .=" actionItems = '".$_POST["actionItems"]."'  ";
			$objQueryHISTORY = mysql_query($strSQLHISTORY) or die ("Error Query [".$strSQLHISTORY."]");
			$num_rows_history = mysql_num_rows($objQueryHISTORY);
			if($num_rows_history<=0)
			{
				$strSQLInsertBkp = "INSERT INTO project_history ";
				$strSQLInsertBkp .="(projectName,owner,nextMilestone,projectId,isDangerDate,originalDate,status,newDate,issues,actionItems,createdAt,modifiedAt,changed) ";
				$strSQLInsertBkp .="VALUES ";
				$strSQLInsertBkp .="('".$_POST["projectName"]."','".$_POST["owner"]."' ";
				$strSQLInsertBkp .=" ,'".$_POST["nextMilestone"]."'  ,'".$id."' ";
				$strSQLInsertBkp .=",'".$_POST["isDangerDate"]."','".$_POST["originalDate"]."' ";
				$strSQLInsertBkp .=", '".$_POST["status"]."', '' ";
				$strSQLInsertBkp .=",'".$_POST["issues"]."','".$_POST["actionItems"]."' ";
				$strSQLInsertBkp .=",'".date('Y-m-d h:m:s')."','".date('Y-m-d h:m:s')."','created') ";
				$objQuery = mysql_query($strSQLInsertBkp);
				if(!$objQuery)
				{
					//echo "Error Save [".mysql_error()."]";
					$setFlash=array("class"=>'errormsg',"message"=>"Error Save [".mysql_error()."]");
					$errorFlag=1;
				}
			}
			else
			{
				//echo "Already in history.";	
				$setFlash=array("class"=>'errormsg',"message"=>"Already in history.");
				$errorFlag=1;
			}
			 
			header('Location: index.php?success=1');
		}
		else
		{
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
				?>
                	<script language="javascript">
					parent.window.location="summary.php?success=1";
					</script>
                <?php
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
$urlConnect="";
if(isset($_GET["Action"]) && $_GET["Action"] == "Edit")
{
if(isset($_GET['id']) && $_GET['id']!='' && is_numeric($_GET['id']))
{	
	$urlConnect.="?Action=".$_GET["Action"].'&id='.$_GET['id'];	
	$strSQL = "SELECT * FROM project where id =".$_GET['id'];
	$objQuery = mysql_query($strSQL) or header('Location: index.php?success=3');
	while($objResult = mysql_fetch_array($objQuery))
	{
		$array = $objResult;
	} $objResult = $array;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project Document</title>
<link rel="stylesheet" href="<?php echo BASE_PATH;?>css/style.css" type="text/css" />
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
		$j(function() {
			var dates = $j( "#startdate, #enddate" ).datepicker({
				defaultDate: "+1w",
				dateFormat: "yy-mm-dd" ,
				changeMonth: true,
				numberOfMonths: 1,
				onSelect: function( selectedDate ) {
					var option = this.id == "startdate" ? "minDate" : "maxDate",
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

<div class="" id="edit-form">
   
    <?php if(isset($setFlash) && isset($setFlash['message'])){?>
    <div  id="flashMessage" style="width:80% !important;margin-left:10px;" class="<?php echo $setFlash['class'];?>">
    	<?php echo $setFlash['message'];?>
    </div>
    
	<?php }?>
    <div class="innerBox">
        <form name="frmMain" method="post" action="<?php echo $_SERVER["PHP_SELF"].$urlConnect;?>">
            <input type="hidden" name="hdnCmd" value="">        
            <div class="field">
                <label>Project name</label>
                <input type="hidden" name="id"  value="<?php if(isset($objResult["id"])){ echo $objResult["id"];}?>">
                <input type="text" name="projectName" value="<?php if(isset($objResult["projectName"])){echo $objResult["projectName"];}else if(isset($_POST['projectName'])){ echo $_POST['projectName']; }?>" class="textbox" />
            </div>
            
            <div class="field">
                <label>Owner</label>
                <input type="text" name="owner"  value="<?php if(isset($objResult["owner"])){echo $objResult["owner"];}else if(isset($_POST['owner'])){ echo $_POST['owner']; }?>" class="textbox" />
            </div>
            
            <div class="clear"></div>
            
            <div class="field">
                <label>Next milestone</label>
                <input type="text" name="nextMilestone" value="<?php if(isset($objResult["nextMilestone"])){echo $objResult["nextMilestone"];}else if(isset($_POST['nextMilestone'])){ echo $_POST['nextMilestone']; }?>" class="textbox" />
            </div>
            
            <div class="field">
                <label>Date in danger</label>
                <div class="checkbox"><input type="radio" name="isDangerDate" <?php if(isset($objResult["newisDangerDate"]) && $_GET["newisDangerDate"]==0){ echo 'checked="checked"';}else if(isset($_POST['newisDangerDate'])){ echo 'checked="checked"'; }?> checked value="0" /><span>No</span></div>
                <div class="checkbox"><input type="radio" name="isDangerDate" <?php if(isset($objResult["newisDangerDate"]) && $_GET["newisDangerDate"]==1){ echo 'checked="checked"';}else if(isset($_POST['newisDangerDate'])){ echo 'checked="checked"'; }?>  value="1" /><span>Yes</span></div>
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
            
            <?php if(isset($_GET["id"]) && $_GET["Action"] == "Edit")
            { ?>
                <div class="field">
                    <label>Original date</label>
                    <input type="text" id="startdate" name="originalDate" disabled="disabled"  value="<?php if(isset($objResult["originalDate"])){echo $objResult["originalDate"];}else if(isset($_POST['originalDate'])){ echo $_POST['originalDate']; }else { echo date("Y/m/d", strtotime("1 days"));}?>" class="textbox" />
                </div>            
                <div class="field">
                    <label>New date</label>
                    <input type="text" id="newDate" name="newDate" value="<?php if(isset($objResult["newDate"]) && $objResult["newDate"]!="0000-00-00 00:00:00"){echo $objResult["newDate"];}else if(isset($_POST['newDate'])){ echo $_POST['newDate']; }?>" class="textbox" />
                </div> 
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
              
            <?php } else { ?>        
                <div class="field">
                    <label>Original date</label>
                    <input type="text" id="startdate" name="originalDate" value="<?php if(isset($objResult["originalDate"]) && $objResult["originalDate"]!="0000-00-00 00:00:00"){echo $objResult["originalDate"];}else if(isset($_POST['originalDate'])){ echo $_POST['originalDate']; }else { echo date("Y/m/d", strtotime("1 days"));}?>" class="textbox" />
                </div>            
                <div class="field">
                    <label>New date</label>
                    <input type="text" id="newDate" name="newDate" disabled="disabled"  value="" class="textbox" />
                </div>
            <?php } ?>
            
            <div class="clear"></div>
            
            <div class="field">
                <label>Status</label>
                <select name="status" class="selectbox">
                    <option <?php if(isset($objResult["status"]) && $objResult["status"]==1){ echo 'selected="selected"';} else if(isset($_POST['status'])){ echo 'selected="selected"'; }?> value="1">Green</option>
                    <option <?php if(isset($objResult["status"]) && $objResult["status"]==2){ echo 'selected="selected"';} else if(isset($_POST['status'])){ echo 'selected="selected"'; }?> value="2">Yellow</option>
                    <option <?php if(isset($objResult["status"]) && $objResult["status"]==3){ echo 'selected="selected"';} else if(isset($_POST['status'])){ echo 'selected="selected"'; }?> value="3">Red</option>
                </select>
            </div>
            
            <div class="clear"></div>
            
            <div class="field">
                <label>Issues</label>
                <textarea name="issues" class="textarea"><?php if(isset($objResult["issues"])) {echo $objResult["issues"];}else if(isset($_POST['issues'])){ echo $_POST['issues']; }?></textarea>
            </div>
            
            <div class="field">
                <label>Action items</label>
                <textarea name="actionItems" class="textarea"><?php if(isset($objResult["actionItems"])){ echo $objResult["actionItems"];}else if(isset($_POST['actionItems'])){ echo $_POST['actionItems']; }?></textarea>
            </div>
            
           
            
           <!-- <div class="clear"></div>
             <div class="field">
                <input type="checkbox" name="sendMail" value="1" />
                Send mail
            </div>-->
             <div class="clear"></div>
             
            <div class="fieldBtn">
            
                <?php if(isset($_GET['id']))
                { ?>
                    <input name="btnAdd" type="button" id="btnUpdate" value="Update" OnClick="frmMain.hdnCmd.value='Update';frmMain.submit();" class="btn" />
                    <input type="button" name="Cancel" value="Cancel" onclick="parent.window.location='summary.php'" class="btn" />  <?php } else{ ?>
                    <input name="btnAdd" type="button" id="btnAdd" value="Add" OnClick="frmMain.hdnCmd.value='Add';frmMain.submit();" class="btn" />
              
                    <input type="reset" name="Reset" value="Reset" class="btn" />
                    
                <?php } ?>
            
            </div>
            
            <div class="clear"></div>
            
        </form>
    </div>
    <?php
    mysql_close($objConnect);
    ?>
</div>
</body>
</html>