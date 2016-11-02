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
//error_reporting(0);
include(FILE_PATH."protected/vendors/Smarty/smartyml.class.php");
//Yii::import("application.vendors.Smarty.smartyml.class.php");
class RestController extends Controller 
{
	
	private $arr =  array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	private $languages;
	private $language_names;
	private $fn_name;
	private $userId;
	private $client_id;
	private $oauth_token;
	private $format='json'; 
	public $msg;
	public $errorCode;
	
	function beforeAction() 
	{
		
		global $msg;
		global $errorCode;
		global $fn_name;
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
		$fn_names=array();
		if(isset($_GET['functionname']) && $_GET['functionname']!=NULL)
		{
			if(isset($_REQUEST['format']))
			{
				if($_REQUEST['format']==1)
				{
					$this->format='xml';
				}
									
			}
				$this->fn_name=$_GET['functionname'];
			
			//Check if function is authorize or not
			$result=$this->authorize($this->fn_name);
			
			if($result[0]==0)
			{
				 $this->userId=$result['userId'];
				if(isset($_REQUEST['client_id']) && isset($_REQUEST['oauth_token']))
				{
					$this->oauth_token=$_REQUEST['oauth_token'];
					$this->client_id=$_REQUEST['client_id'];
				}
				
				if(isset($_REQUEST['client_id']))
				{
					unset($_POST['client_id']);
					unset($_GET['client_id']);
				}
				if(isset($_REQUEST['oauth_token']))
				{
					unset($_POST['oauth_token']);
					unset($_GET['oauth_token']);
				}
				
			}
			
			else
			{	
				
				$data=array('status'=>$result[0],'message'=>$result[1]);
				$responseFunction=$this->format.'Response';
				
				$this->$responseFunction($data);
				exit;
			}
		}
		else
		{
			
			$data=array('status'=>$this->errorCode['_FUNCTION_MISSING_'],'message'=>$this->msg['_FUNCTION_MISSING_']);
			$responseFunction=$this->format.'Response';
			$this->$responseFunction($data);
			exit;
		}	
		return true;
	}
	
	function actionindex($functionname=NULL,$id=NULL,$resFormat='xml')
	{	
		if(isset($_GET['uri']) && $_GET['uri']!='')
		{
			$this->get($_GET['uri']);
		}
		else if( (isset($_GET['functionname']) || $functionname!=NULL) && $_GET['functionname']!='get')
		{
			
			$functionname=$_GET['functionname'];
			$client_ip=$_SERVER['REMOTE_ADDR'];
			$restArray['clientIp']=$client_ip;
			$restArray['requestTime']=date('Y-m-d H:i:s');
			$restArray['functionname']=$functionname;
			if(!empty($_GET))
			{
				$restArray['getParameter']=serialize($_GET);
				error_log("INFO REST CALL GET PARA:".$this->getStructuredArray($_GET));
			}
			if(!empty($_FILES))
			{
				if(isset($_FILES['avatar']['name']) && isset($_REQUEST['accountManagerId']))
				{
					$_POST['accountManagerId']=$_REQUEST['accountManagerId'];
					$account_manager = new AccountManagers();
					$result=$account_manager->uploadAvatar($_POST,$_FILES);
					error_log("INFO ACM AVATAR:".$this->getStructuredArray($result));
					if($result['status']==0)
					{
						$_POST['file_name']=$result['result'];
					}
				}
				if(isset($_FILES['avatar']['name']) && isset($_REQUEST['seekerId']))
				{
					$_POST['seekerId']=$_REQUEST['seekerId'];
					$seekerObj = new Seeker();
					$result=$seekerObj->uploadAvatar($_POST,$_FILES);
					error_log("INFO SEEKER AVATAR:".$this->getStructuredArray($result));
					if($result['status']==0)
					{
						$_POST['file_name']=$result['result'];
					}
				}
			
				if(isset($_FILES['businessLogoFile']['name']))
				{
					$employerObj = new Employer();
					$result=$employerObj->uploadBusinessLogo($_POST,$_FILES);
					if($result['status']==0)
					{
						$_POST['logo_file_name']=$result['result'];
					}
				}
				
				
				if(isset($_FILES['businessProfileFile']['name']))
				{
					$employerObj = new Employer();
					$result=$employerObj->businessProfileImage($_POST,$_FILES);
					if($result['status']==0)
					{
						$_POST['profile_file_name']=$result['result'];
					}
				}
					
			}
			
			if(!empty($_POST))
			{
				$restArray['postParameter']=serialize($_POST);
				error_log("INFO REST CALL POST PARA:".$this->getStructuredArray($_POST));
			}
			
			$restArray['status']=200;
			$restArray['expiry']=time()+API_LINK_EXPIRY_TIME;
			$restArray['uri']=md5(date('Y-m-d H:i:s').rand());
			$restArray['created']=date('Y-m-d H:i:s');
			$incoming_rest_callObj=new IncomingRestCalls();
			
			$incoming_rest_callObj->setData($restArray);
			$id=$incoming_rest_callObj->insertData();
			error_log("INFO Deamon called for ID:".$id,3,"/var/www/html2/dlogs/log.txt");
			error_log("INFO Deamon called for ID:".$id,3,"/var/www/html2/dlogs/log.txt");
			
			error_log("INFO Deamon called for ID:".$id);
			error_log("INFO SET URI:".$restArray['uri']);
			error_log("INFO REQUEST FOR:".$restArray['uri']);
			$data=array('status'=>0,'uri'=>$restArray['uri']);
			$responseFunction=$this->format.'Response';
			$this->$responseFunction($data);
			$sig = new signals_lib();
			$sig->get_queue($this->arr['rcv_rest']);
            $sig->send_msg("rcv_rest");
			
		}
		else
		{
			$data=array('status'=>2,'message'=>'Invalid Url.');
			$responseFunction=$this->format.'Response';
			$this->$responseFunction($data);
				
		} 
	}
	
	function get($uri)
	{
		if($uri!='')
		{
			$incoming_rest_callObj=new IncomingRestCalls();			
			$data = $incoming_rest_callObj->getrestdata($uri);
			
			if(!empty($data))
			{
				$smarty = new smartyML('eng');
				$dataResult=smarty_prefilter_i18n($data,$smarty);
				
				$result['response']=json_decode($dataResult['response']);
				$result['status']=$dataResult['status'];
				if($dataResult['status']==200)
				{
					$result['message']="In progress...";
				}
				$responseFun=$this->format."Response";
				$this->$responseFun($result);
			}
			else
			{
				$result['response']='';
				$result['status']='';
				$responseFun=$this->format."Response";
				$this->$responseFun(array("status"=>0,"response"=>$this->msg['_REQUEST_NOT_FOUND_']));
			   
			}	
		}
		else
		{
			echo "please enter uri";	
		}
	}
	
	
	function authorize($fn_name)
	{
		$unauthorize=unserialize(UNAUTHORIZE_ACTION);
		$authorize=unserialize(AUTHORIZE_ACTION);
		if(in_array($fn_name,$unauthorize))
		{	
			return array(0,"userId"=>0);
		}
		else if(!in_array($fn_name,$authorize))
		{
			return array(1,'Invalid action.');
		}
		else
		{
			$authObj=new Oauth();
			if(isset($_REQUEST['client_id']) && isset($_REQUEST['oauth_token']))
			{
				$result=$authObj->getAuthDetailsByclientId($_REQUEST['client_id']);
				if(!empty($result) && $result['oauth_token']==trim($_REQUEST['oauth_token']))
				{
				
				$response=$authObj->verifyAccessToken();
					if($response[0]==0)
					{
						$result[0]=0;
						if(isset($response[1]['userId']) && $response[1]['userId']!='')
						{
							$userObj=new User();
							$data=$userObj->getSession($response[1]['userId']);	
							if($data[0]!=0)
							{
								return $data;	
							}
						}
						return $result;
						
					}
					else
					{
						return $response;
					}
				 
				}
				else
				{
					return array(501,$this->msg['_INVALID_CREDENTIAL_']);
				}
				
			}
			else
			{
				return array(501,$this->msg['_INVALID_CREDENTIAL_']);
			}
		}
	}
	
	//xmlResponse($response);
	// call for response formate
	function xmlResponse($data)
	{
		$xml = new Xmlresponse();
		echo $xml->array2xml($data);
		
	}
		
	// call for json response formate
	function jsonResponse($data)
	{
		$jsonResponse['response']=$data;
		echo json_encode($jsonResponse);
		return;	
	}
	
	function compile_obj($obj,$status=false)
	{	
		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #009900;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#009900;">&nbsp;&nbsp;profiler_post_data&nbsp;&nbsp;</legend>';
		$output .= "\n";
				
		if (count($obj) == 0)
		{
			$output .= "<div style='color:#009900;font-weight:normal;padding:4px 0 4px 0'>profiler_no_post</div>";
		}
		else
		{
			$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";
		
			foreach ($obj as $key => $val)
			{
				if ( ! is_numeric($key))
				{
					$key = "'".$key."'";
				}
			
				$output .= "<tr><td width='50%' style='color:#000;background-color:#ddd;'>&#36;_POST[".$key."]&nbsp;&nbsp; </td><td width='50%' style='color:#009900;font-weight:normal;background-color:#ddd;'>";
				if (is_array($val))
				{
					$output .= "<pre>" . htmlspecialchars(stripslashes(print_r($val, true))) . "</pre>";
				}
				else
				{
					$output .= htmlspecialchars(stripslashes($val));
				}
				$output .= "</td></tr>\n";
			}
			
			$output .= "</table>\n";
		}
		$output .= "</fieldset>";

		return $output;	
	}
	 /////////////////
	function afterAction() 
	{
	
	}
	
	function getStructuredArray($data)
	{
		if(!empty($data))
		{
			$textData="";
			foreach($data as $key=>$result)
			{
				$textData.="&".$key.'='.$result;
			}
			return $textData;
		}
		else
		{
			return "";	
		}
	}	
}
