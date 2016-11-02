<?php
/**
 * Copyright (c) 2011 All Right Reserved, Todooli, Inc.
 *
 * This source is subject to the Todooli Permissive License. Any Modification
 * must not alter or remove any copyright notices in the Software or Package,
 * generated or otherwise. All derivative work as well as any Distribution of
 * this asis or in Modified
form or derivative requires express written consent
 * from Todooli, Inc.
 *
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
 * PARTICULAR PURPOSE.
 *
 *
**/ 
/**
 *
 */
class Helper extends CFormModel
 {

	// method - send Mail
	// param $email -> receiver email address
	// param $subject
	// param $message -> email body
	// param $from
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	 public function __construct()
	{
		
	}
	
	function sendMail(
				$email, 
				$subject, 
				$message, 
				$from = NULL) {
					if($from==NULL || $from=='')
					{
						$from='no-reply@'._SITENAME_NO_CAPS_.'.com';	
					}
		global $msg;	
		$pos = strstr( $email,'@fake.com');
		if($pos)
		{
			error_log( "FAKE email addresses used for testing are ignored.");
			return true;	
		}
		if(isset($_SERVER["HTTP_REFERER"]))
		{	
			if($_SERVER["REMOTE_ADDR"]!='' && $_SERVER["HTTP_USER_AGENT"]!='' && $_SERVER["HTTP_REFERER"]!='')
			{
				if($email==$msg['_ADMIN_EMAIL_']) {
					$msg   ="<table>";
					$msg  .= "<tr>---User information---</tr>"; //Title
					$msg  .= "<tr> <td>User IP</td> <td>  :  </td> <td>".$_SERVER["REMOTE_ADDR"]."</td> </tr>"; //Sender's IP
					$msg  .= "<tr> <td>Browser info</td> <td>  :  </td> <td>".$_SERVER["HTTP_USER_AGENT"]."</td> </tr>"; //User agent
					$msg  .= "<tr> <td>User come from</td> <td>  :  </td> <td>".$_SERVER["HTTP_REFERER"]."</td> </tr></table>"; //Referrer
					$msg   .="</table>";
					$message.='<br />'.$msg;
				}
			}
		}
		
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;	
		$mail->Subject = $subject;
		$mail->From       = 'no-reply@'._SITENAME_NO_CAPS_.'.com';
		$mail->FromName   = $from;
		$mail->MsgHTML($message);
		$mail->AddAddress($email,'');
		$mailResponse = $mail->Send();
	
		if(!$mailResponse) 
		{
			error_log("Email:".$email);
			error_log("Mail Error Subject=>".$subject.'   Error:=>'.$mail->ErrorInfo);
			return false;
		} 
		else 
		{
			error_log("INFO Mail Success Subject=>".$subject."to=>".$email." Name:".$from);
			return true;
		}
	}
	function setMobileBreadCrumb($link='muser/index',$title="Home",$position=0)
	{
		$breadCrumbArray=array();
		if($position==0)
		{
			if(isset(Yii::app()->session['breadCrumb']))
			{
				unset(Yii::app()->session['breadCrumb']);
			}	
		}
		else
		{
			if(isset(Yii::app()->session['breadCrumb']))
			{
				$breadCrumbArray=Yii::app()->session['breadCrumb'];
			}
		}
		
		$breadCrumb['title']=$title;
		$breadCrumb['link']=$link;
		$breadCrumbArray[$position]=$breadCrumb;
		$breadCrumbArray['position']=$position;
		Yii::app()->session['breadCrumb']=$breadCrumbArray;
		
	}
	
	function displayMobileBreadCrumb()
	{
		
		if(isset(Yii::app()->session['breadCrumb']['position']))
		{
			
			$currentPosition=Yii::app()->session['breadCrumb']['position'];
			$position=(int)($currentPosition-1);
			echo '<div class="blue-area">';
			if($currentPosition>0)
			{
				
				
				if(!isset(Yii::app()->session['breadCrumb'][$position]['link']))
				{
					$link="muser/index";
					$title="Home";	
				}
				else
				{			
					$link=Yii::app()->session['breadCrumb'][$position]['link'];
					$title=Yii::app()->session['breadCrumb'][$position]['title'];	
				}	
			?>
				
                <a href="<?php  echo Yii::app()->params->base_path;?><?php echo $link;?>">##_MOBILE_USER_BACK_TO_## <?php echo $title;?></a>
               
			<?php
			}
		echo "</div>";	
		}	
	}
	function callDaemon($daemon_name = "hirenow", $message = "") {
		//$this->doNotRenderHeader = 1;
		$sig = new signals_lib();
		$sig->get_queue($this->arr[$daemon_name]);
        if ($message == "") {
		  $sig->send_msg($daemon_name);
        } else {
		  $sig->send_msg($message);
        }
	}
	
	function setOutgoingSMS($smsReceiver,$smsBody,$jobId="",$hire_match_id="")
	{
		// insert data in outgoing_sms table
		$smsBody = str_replace("##",'',$smsBody);
		$outgoing_sms_data = array();
		$outgoing_sms_data['smsBody'] = substr($smsBody,0,160);
		$outgoing_sms_data['smsReceiver'] = $smsReceiver;
		$outgoing_sms_data['jobId'] = $jobId;
		$outgoing_sms_data['hire_matching_user_id'] = $hire_match_id;
		$outgoing_sms_data['status'] = STATE_NOT_READ;
		$outgoing_sms_data['created'] = date('Y-m-d H:i:s');
		$outgoingSmsObj	=	new OutgoingSMS();
		$outgoingSmsObj->setData($outgoing_sms_data);
		$outgoingSmsObj->insertData();
		///sends a signal to send_sms
		$this->callDaemon('send_sms');
	}
	
	public function mailSetup($to,$subject,$message,$sender=0,$userId=0,$fromName='')
	{
		$outgoing_email = new DaemonOutgoingEmails();
		$outgoing_email_data['senderId'] = $sender;
		$outgoing_email_data['receiverId'] = $userId;
		$outgoing_email_data['emailTo'] = $to;
		$outgoing_email_data['fromName'] = $fromName;
		$outgoing_email_data['emailBody'] = $message;
		$outgoing_email_data['subject'] = $subject;
		$outgoing_email_data['status'] = 0;
		$outgoing_email_data['createdAt'] = date("Y-m-d H:i:s");
		
		$outgoing_email->setData($outgoing_email_data);
		$outgoing_email->insertData();
		$this->callDaemon('send_email');
		return true;
		
		
	}
	
	function getRandomString()
	{
		$abc= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"); 
		$num= array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
					
		$rand = date("m").date("d").date("Y").date("H").date("i").date("s").$abc[rand(0,25)].$num[rand(0,9)].$abc[rand(0,25)].$num[rand(0,9)].strtoupper($abc[rand(0,25)]).$num[rand(0,9)].strtoupper($abc[rand(0,25)]).$num[rand(0,9)];
		return $rand;
	}
	
	function deleteAttachement($post,$session)
	{
			$algo=new Algoencryption();
			$newdir=$algo->encrypt("USER_".$session['loginId']);
			$uploaddir = FILE_UPLOAD.'attachment/'.trim($newdir);
			if(is_dir($uploaddir))
			{
				if ($handle = opendir($uploaddir)) 
				{
					while (false !== ($file = readdir($handle))) 
					{
						
						$filepath=$uploaddir.'/'.$file;
						if(strlen($file)>6)
						{
							
							if(file_exists($filepath))
							{
								
								if($file!=$post['attachment'])
								{
										unlink($filepath);
								}
							}
						}
					}
				}
			}
	}
	

}
