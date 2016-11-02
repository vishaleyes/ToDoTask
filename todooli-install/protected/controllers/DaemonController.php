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
/*.
    require_module 'standard';
    require_module 'pcre';
    require_module 'mysql';
.*/

error_reporting(-1);
date_default_timezone_set('America/Los_Angeles');
class DaemonController extends Controller 
{
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	// Twilio REST API version
	private $ApiVersion = "2010-04-01";
	// Set our AccountSid and AuthToken
	private $AccountSid = "AC755fcae1c088b171b14507c4c62f2622";
	private $AuthToken = "ca16bb034165c272a1d1e435cea85a66";
	private $languages;
	private $language_names;
	private $global;
	private $algo;
	private $admin_email=ADMIN_EMAIL;
	private $group_email=ADMIN_EMAIL;
	
	private $general;
			
	function __construct() {
		 
		/*$this->algo = new Algoencryption();
		$this->general = new General();*/
	}
	
	function actionprocess_rcv_rest($debug_level = false) {
		
		$incoming_rest_callObj=new IncomingRestCalls();
		$result=$incoming_rest_callObj->getAllUnreadRestCall();
		$count=count($result);
		error_log("INFO process_rcv_rest"." debug_level:".$debug_level." Got ".$count." incoming api call");
		if($count>0)
		{
			foreach($result as $incoming_rest_call)
			{
				$functionname=$incoming_rest_call['functionname'];
				$post=unserialize($incoming_rest_call['postParameter']);
				$get=unserialize($incoming_rest_call['getParameter']);
				$id=$incoming_rest_call['id'];
				error_log("INFO CALL FUNCTION :".$functionname);
				
				$data=$incoming_rest_callObj->$functionname($get,$post);
				$incoming_rest_call_data['response']=json_encode($data);
				$incoming_rest_call_data['status']='0';
				$incoming_rest_call_data['modified']=date('Y-m-d H:i:s');
				$incoming_rest_callObj->setData($incoming_rest_call_data);
				$incoming_rest_callObj->insertData($id);
			}
			
		}
	}
	
	function actionprocess_reminder()
	{
		
			$reminderObj=new Reminder();	
			$helperObj	=	new Helper();		
			$reminders=$reminderObj->getAllReminder();	
			$totalReminder=count($reminders);
			error_log("INFO GETTING TOTAL :".$totalReminder. "REMINDERS");
			if($totalReminder>0)
			{
				$generalObj	=new General();
				$todoListObj=new TodoLists();
				foreach($reminders as $reminder)
				{
					//get email content
					$time=date("H").":00:00";
					error_log($reminder['matchTime']."____".$time);
					if($reminder['matchTime']== $time)
					{
						$reminder['reminderList']	=	explode(',', $reminder['listId']);
						if( $reminder['name'] != '' ) {
							$subject	=	$reminder['name'];
						} else {
							$listIds	=	$reminder['reminderList'];
							if( in_array(0, $listIds) ) {
								$subject	=	'All Lists';
							} else {
								$subject	=	'';
								for( $i=0; $i<count($listIds); $i++ ) {
									$name	=	$todoListObj->getMyListById($listIds[$i]);
									if( $i == count($listIds)-1 ) {
										$subject	.=	$name['name'];
									} else {
										$subject	.=	$name['name'].', ';
									}
								}
							}
						}
						
						if( $reminder['summaryStatus'] == 1 ) {
							$template	=	'all-list-summary';
							$emailContent	=	$reminderObj->getAllSummaryReminderEmail($reminder['reminderList'], $reminder['userId'], $reminder['itemStatus'], $reminder['dueDate']);
							$emailContent['subject']	=	$subject.' summary reminder';
						} else {
							if( $reminder['listId'] == 0 ) {
								$template	=	'all-list-reminder';
								$emailContent	=	$reminderObj->getAllListReminderEmail($reminder['userId'], $reminder['itemStatus'], $reminder['dueDate']);
							} else {
								$template	=	'reminder';
								$emailContent	=	$reminderObj->getReminderEmail($reminder['reminderList'], $reminder['userId'], $reminder['itemStatus'], $reminder['dueDate']);
							}
							$emailContent['subject']	=	$subject.' reminder';
						}
						
						if(!empty($emailContent))
						{
							error_log("INFO Sending email to".$emailContent['emailTo']. "With subject:".$emailContent['subject']);
						
							$helperObj->mailSetup($emailContent['emailTo'],$emailContent['subject'],$emailContent['message'],$reminder['userId']);
		
						}
						$nextData=$generalObj->getNextDate($reminder['duration']);
						$reminderArray['id']=$reminder['id'];
						$reminderArray['nextDate']=$nextData;
						$reminderObj->updateNextReminder($reminderArray);
					}
				}
			}
		
	}
	
	function actionprocess_rcv_android_note($debug_level = false) {
		$rcv_android_note_callObj=new IncomingAndroidNotification();
		$result=$rcv_android_note_callObj->getAllUnreadRestCall();
		$count=count($result);
		error_log("INFO process_rcv_android_note"." debug_level:".$debug_level." Got ".$count." incoming api call");
		if($count>0)
		{
			foreach($result as $incoming_android_note_data)
			{
				$result=$rcv_android_note_callObj->sendNotification($incoming_android_note_data);
				//$result=false;
				if($result['status']==0)
				{
					$incoming_android_note_data['status']='1';
					$rcv_android_note_callObj->setData($incoming_android_note_data);
					$rcv_android_note_callObj->insertData($incoming_android_note_data['id']);
				}
			}
			
		}
	}
	
	function actionprocess_rcv_rest_expire($debug_level = false) {
		$incoming_rest_callObj=new IncomingRestCalls();
		$result=$incoming_rest_callObj->getAllExpiredCall();
		if(is_array($result) && !empty($result))
		{
		    $count=count($result);
		    $this->log("INFO process_rcv_rest_expire"." debug_level:".$debug_level." Got ".$count." expired call");
			$incoming_rest_callObj->deleteAll("id in(".implode(',',$result).")");
		}
	}
	
	function log($message) {
		$trace=debug_backtrace();
		$args = $trace[1]['args'];
		if(isset($trace[1]['file']))
		{
			$filename = basename($trace[1]['file']);
		}
		else
		{
			$filename = '';
			
		}
		$functionname = $trace[1]['function'];
		switch (count($args)) {
		    case 0: 
				$functionname = $functionname."()";
				break;
			case 1:
		        $functionname = $functionname."(".$args[0].")";
				break;
			case 2:
		        $functionname = $functionname."(".$args[0].",".$args[1].")";
				break;
			case 3:
		        $functionname = $functionname."(".$args[0].",".$args[1].",".$args[2].")";
				break;
			default:
		        $functionname = $functionname."(".$args[0].",".$args[1].",".$args[2]."+)";
				break;
		} 
		if(isset($trace[1]['line']))
		{
			$linename = $trace[1]['line'];
		}
		else
		{
			$linename = '';
		}
		if ($filename == "") {
		  $msg = "INFO [".$functionname."] ".$message;
		} else {
		  $msg = "INFO [".$filename.",".$functionname.",".$linename."] ".$message;
		}
		error_log($msg);
	}		
		
	function actionprocess_outbound_email($debug_level = false) {
		$this->log("TST");
		$outgoing_email = new DaemonOutgoingEmails();
		
		// Fetch outgoing email data		
		$outgoing_email_data = $outgoing_email->getAllUnreadEmail();	
		
		$count = count($outgoing_email_data);
		$this->log("process_outbound_email	"." debug_level:".$debug_level." Got ".$count." outgoing_email_data");
		if($count>0)
		{
			foreach($outgoing_email_data as $outgoing_email_row)
			{
				// Send Email to seeker
				$date = date("F j, Y");
				$message = $outgoing_email_row['emailBody'];
				$subject = $outgoing_email_row['subject'];
				$email = $outgoing_email_row['emailTo'];
				$fromName=$outgoing_email_row['fromName'];
				$message = str_replace("_DATE_",$date,$message);
				error_log("INFO Sending email to ".$email. "With subject: ".$subject);
				$fromName = str_replace("&nbsp;",' ',$fromName);
				$message = str_replace('_FROMNAME_',$fromName,$message);
				$mailHelper = new Helper();
				if ($mailHelper->sendMail($email,$subject,$message,$fromName))
				{
					$outgoing_email = new DaemonOutgoingEmails();
					$outgoing_email->setData(array("status"=>1));
					$outgoing_email->insertData($outgoing_email_row['id']);
				}
			}
		}
	}
	
	function actionprocess_outbound_sms($debug_level = false)	{
		$outgoing_sms = new OutgoingSMS();
		$outgoing_sms_data = $outgoing_sms->getAllUnreadSMS();
		$count = count($outgoing_sms_data);
		$this->log("process_outbound_sms 	"." debug_level:".$debug_level." Got ".$count." outgoing_sms_data");
		
		if($count>0)
		{
			// Twilio API
			$twilio_helper = new TwilioHelper();		
			// Instantiate a new Twilio Rest Client
			$client = new TwilioRestClient($this->AccountSid, $this->AuthToken);
		
			foreach($outgoing_sms_data as $outgoing_sms_row)
			{
				
				$pos = strpos($outgoing_sms_row['smsReceiver'], "111");
				if ((SMS_NUMBER == '4086457916') ||
					(($pos !== false) && ($pos === 0))) {
					$this->log("FAKE IT: SUCCESS Sending SMS to ".$outgoing_sms_row['smsReceiver']." ".$outgoing_sms_row['smsBody']);
					$outgoing_sms->setData(array("status"=>STATE_READ));
					$outgoing_sms->insertData($outgoing_sms_row['id']);
				}
				else
				{
					$outgoing_sms_row['smsBody'] = $this->truncateName($outgoing_sms_row['smsBody'],160);
					$response = $client->request("/$this->ApiVersion/Accounts/$this->AccountSid/SMS/Messages", 
						"POST", array(
						"To" => $outgoing_sms_row['smsReceiver'],
						"From" => SMS_NUMBER,
						"Body" => $outgoing_sms_row['smsBody']
						));
						
					if($response->IsError) {
						$this->log("Failed to send SMS Error: {$response->ErrorMessage}");
						
					$outgoing_sms->setData(array("status"=>STATE_ERROR_PROCESSING));
					$outgoing_sms->insertData($outgoing_sms_row['id']);
					}
					else {			
						$this->log("SUCCESS Sending (ACTUAL) SMS to ".$outgoing_sms_row['smsReceiver']." ".$outgoing_sms_row['smsBody']);
					$outgoing_sms->setData(array("status"=>STATE_READ));
					$outgoing_sms->insertData($outgoing_sms_row['id']);
					}
				}
			}
		}
	}
	
	function actionprocess_inbound_sms($debug_level = false) {
		$outgoing_sms = new OutgoingSMS();
		$verify_sms = new VerifySms();
		$user = new User();
		//fetch received messages
		$incoming_sms = new IncomingSMS();
		$incoming_sms_data = $incoming_sms->getAllUnreadSms();
		$count = count($incoming_sms_data);
		$this->log("process_inbound_sms 	"." debug_level:".$debug_level." Got ".$count." incoming SMS");
		if($count>0)
		{
			try
			{
				foreach($incoming_sms_data as $incoming_sms_row)
				{
					$incoming_sms_sender = $incoming_sms_row['smsSender'];
					$user_language = $this->getPreferredLanguage($incoming_sms_sender);
					
					$incoming_sms_body = trim($incoming_sms_row['smsBody'],
												"\'\"\r\n\t, ");
					// lets parse what we got in $smsBody
					$this->log ("From: ".$incoming_sms_sender." BODY: ".$incoming_sms_body);
					$keywordsArray = preg_split("/[\s,]+/", $incoming_sms_body, 2, PREG_SPLIT_OFFSET_CAPTURE);
				
					$keyword = trim($keywordsArray[0][0],"\'\"\r\n\t, ");
				
					$argument="";
					if(isset($keywordsArray[1][0]))
					{
						$argument = trim($keywordsArray[1][0],"\'\"\r\n\t, ");
					}
					
					// first check if verification is initiated by the user
					if ($verify_sms->inVerificationProcess($incoming_sms_sender)) {
						
						// $this->log ("The user with this SMS is trying verification.");
						$pos = stripos("verify", $keyword);
						if ($pos === false) {
						  $pos = stripos("activate", $keyword);
						}
						
						$code = trim($argument);
						if ($pos !== false ) {
							$userId = $verify_sms->verifyNumber($incoming_sms_sender,$code);
							error_log("USERID".$userId);
							if ($userId !== false) {
								$this->log ("Verification PASSED.");
								// deletePhoneNumber deletes all entries in user 
								// which are not matching to $userId
								$user->deletePhoneNumber($incoming_sms_sender,$userId);
								$this->log("We have a new verified user - userId =>".$userId);
								//delete other verified phone
								$user->deleteOtherVerifiedPhone($userId);
								$this->log("Deleted other verified Phone - userId =>".$userId);
								
								$user->verifyUserById($userId);
								
								// remove this number from spam
								$sms_spam = new SmsSpam();
								$sms_spam->removeFromSpam($incoming_sms_sender);
								
								$this->setOutgoingSMS(
									$incoming_sms_sender,
									$this->languages[$user_language]['_VERIFICATION_PASS_SMS_']);
								
								//set status 1
								$this->setIncomingSMSAsRead($incoming_sms_row['id']);
								$recent_activities=new RecentActivities();	
								$recent_activities->setPreActivity($userId,$incoming_sms_sender);
								continue;
							}
							else {
								$this->log ("Verification FAILED.");
								$this->setOutgoingSMS(
									$incoming_sms_sender,
									$this->languages[$user_language]['_VERIFICATION_FAIL_SMS_']);
								//set status 1
								$this->setIncomingSMSAsRead($incoming_sms_row['id']);
								continue;
							}
						}
						//lets not waste money on people who are typing wrong 
						$this->log ("Verification FAILED.");
						// continue below as somebody may have 
						// started verification on someone else's number
					}
					$last_question = new LastQuestions();
					$last_question_number = $last_question->getLastQuestionNo($incoming_sms_sender);
					if ($last_question_number !== false) {
					  $this->log($this->questions[$last_question_number][QUESTIONS_ANSWER_FUNCTION] ."(".$incoming_sms_sender.",".$incoming_sms_body.")");
					}
					$count = count($this->commands);
					$i = $count;
					$cnt = 0;
					$multiple = "";
					if ($last_question_number === false) {
						//
						// we need to figure out what command so 
						// we take an action based on the command
						// we support commands in all languages//
						for ($k = 0; $k < $count; $k++) {
							$pos = stripos($this->languages[$user_language][$this->commands[$k][COMMAND_NAME]], $keyword);
							if ( $pos === false ) {
								continue;	
							} else {
								if ( $pos == 0 ) {
									$i = $k;	
									if ($cnt == 0) {
									  $multiple .= $this->languages[$user_language][$this->commands[$k][COMMAND_NAME]];
									} else {
									  $multiple .= ", " . $this->languages[$user_language][$this->commands[$k][COMMAND_NAME]];
									}
									$cnt++;	
								 } else {
									continue;	
								}
							}
						}
						if ($cnt < 1) {
							if ($user_language == _COMMUNICATION_LANGUAGE_ESPANOL) {
								$other_language = _COMMUNICATION_LANGUAGE_ENGLISH;
							} else {
								$other_language = _COMMUNICATION_LANGUAGE_ESPANOL;
							}
							for ($k = 0; $k < $count; $k++) {
								$pos = stripos($this->languages[$other_language][$this->commands[$k][COMMAND_NAME]], $keyword);
								if ( $pos === false ) {
									continue;	
								} else {
									if ( $pos == 0 ) {
										$i = $k;	
										if ($cnt == 0) {
										  $multiple .= $this->languages[$other_language][$this->commands[$k][COMMAND_NAME]];
										} else {
										  $multiple .= ", " . $this->languages[$other_language][$this->commands[$k][COMMAND_NAME]];
										}
										$cnt++;	
									 } else {
										continue;	
									}
								}
							}
						}
					} else {
						//
						// Check for user typing complete command
						//
						for ($k = 0; $k < $count; $k++) {
							$pos = stripos($keyword, $this->languages[$user_language][$this->commands[$k][COMMAND_NAME]]);
							if ( $pos === false ) {
								continue;	
							} else {
								if ( $pos == 0 ) {
									$i = $k;	
									$multiple .= $this->languages[$user_language][$this->commands[$k][COMMAND_NAME]];
									$cnt++;	
								 } else {
									continue;	
								}
							}
						}
					}
					
					//$this->log("INFO: Found matching commands: ".$cnt);
					$processed = false;
					$ambiguous = 0;
					if ($cnt > 1) {
						$ambiguous = 1;
					} else {
					  if ($i < $count) {
						// 
						// Verify if this is from a user of type as we expect
						// 
						$processed = true;
						if ($this->isValidUser(
							$user_language, 
							$incoming_sms_sender, 
							$this->commands[$i][COMMAND_ACCOUNT_STATE],
							$this->commands[$i][COMMAND_ACCOUNT_TYPE])) { 
							// since we got a valid command from user, it means he is no more answering
							// profile questions. deleteLast question
							$lastQuestions = new LastQuestions();
							$lastQuestions->deleteLastQuestion($incoming_sms_sender);
							$processed = call_user_func_array(
										array($this, $this->commands[$i][COMMAND_FUNCTION]), 
										array(
											$user_language,
											$incoming_sms_sender,
											$argument));
						}
					  } else {
						$answer = trim($incoming_sms_body,"\'\"\r\n\t, ");
						$processed = $this->process_answer (
								$user_language,
								$incoming_sms_sender, 
								$answer);
					  }
					}
					
					$this->setIncomingSMSAsRead($incoming_sms_row['id']);
					if ($processed === false) {
						$this->process_unknown_command (
								$user_language,
								$incoming_sms_sender, 
								$incoming_sms_body,
								$ambiguous,
								$multiple);
						// since we got a valid command from user, it means he is no more answering
						// profile questions. deleteLast question
						$lastQuestions = new LastQuestions();
						$lastQuestions->deleteLastQuestion($incoming_sms_sender);
						}
					}
				} catch (Exception $e) {
				error_log( 'Exception caught: ' . $e->getMessage());
				}
		}
		
	}
	
	function checkSmsSpam($user_language, $smsSender) {
		$sms_spam = new SmsSpam();
		$sms_spam_count = $sms_spam->CountSpam($smsSender);
		$this->log("user language is:".$user_language);
		if($sms_spam_count == 0) {
		   // this is first SPAM
		  $this->log($this->languages[$user_language]['_NOT_REGISTERED_SMS_']);
		  $this->setOutgoingSMS($smsSender, $this->languages[$user_language]['_NOT_REGISTERED_SMS_']);
		  $this->callDaemon('send_sms');	
		} else {
		   if($sms_spam_count == 1) {
			 // this is second SPAM
			 $this->log($this->languages[$user_language]['_ALREADY_IN_SPAM_SMS_']);
		  $this->setOutgoingSMS($smsSender, $this->languages[$user_language]['_NOT_REGISTERED_SMS_']);
			 $this->callDaemon('send_sms');	
		   } else {
			 // this candidate keeps sending SPAM,= just ignore!
			 $this->log("Phone number is found in spam");
		  $this->setOutgoingSMS($smsSender, $this->languages[$user_language]['_NOT_REGISTERED_SMS_']);
			 $this->callDaemon('send_sms');	
		   } 
		}
		$sms_spam->updateData($smsSender);
	}
	
	function process_command_debug ($user_language, $smsSender, $argument) {
			$this->log($smsSender." ".$argument);
			$this->log("Debug =>".$argument);		
			$debug_array = preg_split("/[\s,]+/", strtolower($argument));
			if (count($debug_array) != 2) {
			    $smsBody = $this->languages[$user_language]['_DEBUG_SYNTAX_SMS_'];
			} else {
			  $s1 = $debug_array[0];
			  $s2 = $debug_array[1];
			  if ((($s1 == "on") || ($s1 == "off")) && 
				  (($s2 == "hirenow") || 
				   ($s2 == "rcv_sms") || 
				   ($s2 == "send_sms") || 
				   ($s2 == "send_email") || 
				   ($s2 == "rcv_rest") || 
				   ($s2 == "rcv_rest_expire") || 
				     ($s2 == "rcv_android_note") || 
				   ($s2 == "bulk_update") || 
				   ($s2 == "seekers_response") || 
				   ($s2 == "seeker_updated") || 
				   ($s2 == "contact_seekers"))) {
			    $this->callDaemon($s2, $s1);
			    $command = '_DEBUG_'.trim(strtoupper($s1)).'_SMS_';
			    $smsBody = $this->languages[$user_language][$command]. " for ". $s2;
		      } else {
			    $smsBody = $this->languages[$user_language]['_DEBUG_SYNTAX_SMS_'];
			  }
			}
			$this->setOutgoingSMS($smsSender,$smsBody);
			return true;
	}

	/**
	 * function process_unknown_command
	 * 
	 * @param   $type	0 if unknown and 1 if ambiguous command
	 *
	 **/
	function process_unknown_command ($user_language, $smsSender, $argument, $type=0, $multiple="") {
			$this->log($smsSender." ".$argument);
			if ($type == 0) {
			  $smsBody = $this->languages[$user_language]['_UNKNOWN_COMMAND_SMS_'];
			} else {
			  $smsBody = $this->languages[$user_language]['_AMBIGUOUS_COMMAND_SMS_'];
			  $smsBody = str_replace("_COMMAND_",$argument,$smsBody);
			  $smsBody = str_replace("_MULTIPLE_",$multiple,$smsBody);
			}
			$this->setOutgoingSMS($smsSender,$smsBody);
			return true;
	}

	function setOutgoingSMS($smsReceiver,$smsBody,$jobId="",$hire_match_id=""){
		// insert data in outgoing_sms table
		$smsBody = str_replace("##",'',$smsBody);
		$outgoing_sms = new OutgoingSMS();
		$outgoing_sms_data['smsBody'] = substr($smsBody,0,160);
		$outgoing_sms_data['smsReceiver'] = $smsReceiver;
		$outgoing_sms_data['jobId'] = $jobId;
		$outgoing_sms_data['hire_matching_user_id'] = $hire_match_id;
		$outgoing_sms_data['status'] = STATE_NOT_READ;
		$outgoing_sms_data['created'] = date("Y-m-d H:i:s");
			$outgoing_sms_data['created'] = date("Y-m-d\TH:i:s");
		$outgoing_sms_data['createdTimeStamp']=substr((string)microtime(), 1, 8);
;
		//error_log('TimeStampOutgoing:'.$outgoing_sms_data['createdTimeStamp']);
		$outgoing_sms->setData($outgoing_sms_data);
		$outgoing_sms->insertData();
		
		///sends a signal to send_sms
		$this->callDaemon('send_sms');
	}
	
	
	
	function setIncommingAndroidNotification($senderId,$message,$senderType,$deviceId="") { 
		// insert data in outgoing_email table
		$incomming_notification = new IncomingAndroidNotification();
		$incomming_android_data['senderId'] = $senderId;
		$incomming_android_data['message'] = $message;
		$incomming_android_data['senderType'] = $senderType;
		$incomming_android_data['deviceId'] = $deviceId;
		$incomming_android_data['status'] = STATE_NOT_READ;
		$incomming_android_data['created'] = date("Y-m-d H:i:s");
		$incomming_notification->setData($incomming_android_data);
		$incomming_notification->insertData();
		
		///sends a signal to send_email
	}
	
	function setIncomingSMSAsRead($id,$status=STATE_READ)	{
		$incoming_sms = new IncomingSMS();
		$incoming_sms->setData(array("status"=>$status));
		$incoming_sms->insertData($id);
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
	
	function process_test() {
		//error_log("testDemaon", 3, "home/todooli/html2/log.txt");
		mail('g.neil7788@gmail.com', 'testing daemon', 'this just a test');
	}
}
?>
