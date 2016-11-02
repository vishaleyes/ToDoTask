<?php
$errorFlag = 1;
if(isset($_REQUEST['email']) && $_REQUEST['email']!='')
{
	
	 if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST['email'])) { 
		  $errorFlag=0; 
	  } 
}

if($errorFlag==1)
{
	echo 0;
	exit;	
}

	
		
require_once('config.php');
error_reporting(E_ALL);
$objConnect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD) or die(mysql_error());
$objDB = mysql_select_db(DB_DATABASE);
$strSQL	=	'SELECT * FROM project_history where 1=1 ';
$objQuery = mysql_query($strSQL);
$rowCount=mysql_num_rows($objQuery);
 if($rowCount>0)
{
$message	=	'<table cellpadding="0" cellspacing="0" border="0">
								 <tr>
								 	<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Date</th>
								 	<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Changed</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Project name</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Owner</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Next milestone</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Date in danger</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Original date</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">New date</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Status</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Issues</th>
									<th style="background: none repeat scroll 0 0 #77A423; border-color: #D7D7D7; border-style: solid none solid solid; border-width: 1px medium 1px 1px; color: #fff; font-size: 13px; margin: 0; padding:8px 5px;">Action items</th>
									
								 </tr>
								 
								 ';
								 while($objResult = mysql_fetch_array($objQuery))
							{ 
                                 	$isDangerDate="No";
                                    if($objResult["isDangerDate"]==1)
                                    {
                                    	$isDangerDate="No";
                                   	}
                                    
                                   
                                    if($objResult["status"]==1)
                                    {
                                    	 $status="Green";
                                   	}
                                    else if($objResult["status"]==2)
                                    {
                                    	 $status="Yellow";
                                    }
                                    else
                                    {
                                    	 $status="Red";
                                    }
									if($objResult["newDate"]=='' || $objResult["newDate"]=="0000-00-00 00:00:00")
									{
										$newDate="";
											
									}
									else
									{
										$newDate=date("m-d-Y", strtotime($objResult["newDate"]));	
									}
                     		$message	.=	'<tr>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.date("m-d-Y", strtotime($objResult["modifiedAt"])).'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$objResult["changed"].'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$objResult["projectName"].'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$objResult["owner"].'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$objResult["nextMilestone"].'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$isDangerDate.'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.date("m-d-Y", strtotime($objResult["originalDate"])).'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$newDate.'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$status.'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$objResult["issues"].'</td>
													<td style="border-bottom: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0;border-right: 1px solid #D7D7D7;  color: #666666; font-size: 12px; margin: 0; padding:3px 5px; text-align: left; vertical-align: top;">'.$objResult["actionItems"].'</td>
													
												 </tr>' ;
									 
								 }
								 
					$message.='</table>';
					$message.='<br><br>Thanks.'; 
					$to      = $_REQUEST['email'];
					$subject = 'Project history';
					$message = $message;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					
					// More headers
					
					$headers .= 'From: no-reply@todooli.com' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
					$headers .= 'Cc: kalpesh@todooli.com' . "\r\n";	
					echo mail($to, $subject, $message, $headers);
					
										
}