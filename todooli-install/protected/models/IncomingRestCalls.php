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
 * This is the model class for table "incoming_rest_calls".
 *
 * The followings are the available columns in table 'incoming_rest_calls':
 * @property integer $id
 * @property string $clientIp
 * @property string $requestTime
 * @property integer $expiry
 * @property string $uri
 * @property string $functionname
 * @property string $postParameter
 * @property string $getParameter
 * @property string $fileParameter
 * @property string $response
 * @property integer $status
 * @property string $created
 * @property string $modified
 */
//include("xmlresponse.php");	
class IncomingRestCalls extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IncomingRestCalls the static model class
	 */
	private $data = array();
	private $insertedId;
	public $total_pages = 0;
	public $total_rows = 0;
	private $arr =  array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	public $msg;
	public $errorCode;
	
	public function __construct()
	{
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'incoming_rest_calls';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clientIp, requestTime, expiry, uri, functionname, postParameter, getParameter, response, status, created, modified', 'required'),
			array('expiry, status', 'numerical', 'integerOnly'=>true),
			array('clientIp', 'length', 'max'=>20),
			array('uri', 'length', 'max'=>255),
			array('functionname', 'length', 'max'=>250),
			array('fileParameter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clientIp, requestTime, expiry, uri, functionname, postParameter, getParameter, fileParameter, response, status, created, modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'clientIp' => 'Client Ip',
			'requestTime' => 'Request Time',
			'expiry' => 'Expiry',
			'uri' => 'Uri',
			'functionname' => 'Functionname',
			'postParameter' => 'Post Parameter',
			'getParameter' => 'Get Parameter',
			'fileParameter' => 'File Parameter',
			'response' => 'Response',
			'status' => 'Status',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('clientIp',$this->clientIp,true);
		$criteria->compare('requestTime',$this->requestTime,true);
		$criteria->compare('expiry',$this->expiry);
		$criteria->compare('uri',$this->uri,true);
		$criteria->compare('functionname',$this->functionname,true);
		$criteria->compare('postParameter',$this->postParameter,true);
		$criteria->compare('getParameter',$this->getParameter,true);
		$criteria->compare('fileParameter',$this->fileParameter,true);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	   // set the location data
    function setData($data) {
		$this->data = $data;
    }


	function testAjax()
	{
		error_log("TETING SERVICES");
	   echo json_encode("tst");	
	}
    // insert the location
    function insertData($id=NULL) {
		if($id!=NULL)
		{
			$transaction=$this->dbConnection->beginTransaction();
			try
			{
				$post=$this->findByPk($id);
				if(is_object($post))
				{
					$post->attributes=$this->data;
					$post->save(false);
				}
				$transaction->commit();
					
			}
			catch(Exception $e)
			{						
				$transaction->rollBack();
			}
		}
		else
		{
			$p=$this->data;
			foreach($p as $key=>$value)
			{
				$this->$key=$value;
			}
			
			$this->attributes=$p;
			$this->setIsNewRecord(true);
			$this->save(false);
			return Yii::app()->db->getLastInsertID();
		}
      
    }
	
	// get insert id
	function getInsertId()
	{
		return $this->insertedId;
	}
	
	/*
	DESCRIPTION : For Register Seeker 
	METHOD : POST
	PARAMS : fName,lName,email,password,timezone,phoneNumber,smsOk[0/1]
	*/	
	function signUp($get,$post)
	{
		if(!empty($post))
		{	
			$validationOBJ = new Validation();
			$result = $validationOBJ->Signup($post,0,0);
			if($result['status'] == 0)
			{
				$userObj = new Users();
				$userResponse=$userObj->addRegisterUser($post);
				return $userResponse;		
			}
			else 
			{				
				return $result;	
			}
			
		}
	}
	
	/*
	DESCRIPTION : For Login 
	METHOD : GET
	PARAM GET->loginId,password
	*/
	function login($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['loginId']) && $get['loginId'] != '' && isset($get['password']) && $get['password'] != '')
		{
			$_POST['email_login']=$get['loginId'];
			$userObj=new Users();
			$result=$userObj->login($get['loginId'],$get['password'],0,1);
			return $result;
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;	
		}
	
	}
	
	/*
	DESCRIPTION : For Forgot Password
	METHOD : POST
	PARAM GET->loginId
	*/
	function forgotPassword($get=NULL,$post=NULL)
	{
		
		if(!empty($post) && isset($post['loginId']) && $post['loginId'] != '')
		{
			if(isset($post['loginId']))
				{
					if(isset($post['lang']))
					{
						$lang = $post['lang'];
					}
					else
					{
						$lang = 'eng';
					}
					$usersObj = new Users();
					$result=$usersObj->forgot_password($post['loginId'],0,$lang);
				}
				else
				{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				}
		}
		else
		{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
		}
		return $result;
	}
	
	/*
	DESCRIPTION : For Reset Users Password
	METHOD : POST
	PARAM Post->token,new_password,new_password_confirm
	*/
	function resetPassword($get=NULL,$post=NULL)
	{
		if(!empty($post) && isset($post['token']))
		{			
			$validationOBJ = new Validation();
			$res = $validationOBJ->resetpassword($post);
			if($res['status']==0)
			{
				$usersObj = new Users();
				$res = $usersObj->resetpassword($post);
				return $res;	
			}
			else
			{
				return $res;
			}
		}
		else
		{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;	
		}
	}
	
	/*
	DESCRIPTION : For Activate Users Account
	METHOD : POST
	PARAM POST->loginId[email]
	*/
	function activate($get=NULL,$post=NULL)
	{
		if(!empty($post) && isset($post['loginId']))
		{
			$validationOBJ = new Validation();
			$usersObj = new Users();
			if(!is_numeric($post['loginId']))
			{
				$res = $validationOBJ->is_valid_email($post['loginId']);
				if($res==true)
				{
					$res = $usersObj->activate($post['loginId'],1);
					return $res;
				}
				else
				{
					$result['status'] = 1;
					$result['message'] = "Not Valid Email.";	
					return $result;
				}
			}
			else
			{
				$res=$loginObj->getVerifyCode($post['loginId'],'-1');
				return $res;
			}
		}
		else
		{
			  $result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			  $result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			  return $result;
		}
	}
	
	function privacyPolicy()
	{
		$message = '<div class="main-wrapper">
<div class="middle"><div class="error-msg-area"> </div><div class="bg-pattern" style="height:auto;"><div class="wrapper"><div class="about-content" style="padding:0 20px;">
<h2>Privacy</h2><div style="padding-left:20px;"><ol><li><label>Your privacy is our top concern</label><p>We work hard to earn and keep your trust, so we adhere to the following principles to protect your privacy:</p><ul><li>We do not rent or sell your personally identifiable information to third parties for marketing purposes.</li>
<li>We do not share your contact information with another User without your consent.</li>
<li>Any personally identifiable information that you provide will be secured with industry standard protocols and technology.</li><li>We dont send you unsolicited communications for marketing purposes.</li><li>We offer identity anonymization &amp; relay, to reduce 3rd party harvesting &amp; spam.</li><li>Account information is password-protected. Keep your password safe.</li><li>todooliapp.COM, or people who post on todooliapp.COM, may provide links to third party websites, which may have different privacy practices. We are not responsible for, nor have any control over, the privacy policies of those third party websites, and encourage all users to read the privacy policies of each and every website visited.</li>
</ul><p>We reserve the right to modify this privacy statement at any time, so please review it frequently. If we make material changes to this policy, we will notify you here, by email, or by means of a notice on our home page. By continuing to use todooliapp.COM after notice of changes have been sent to you or published on our website, you are consenting to the changes.</p><p>Due to the communications standards on the Internet, when you visit the todooliapp.COM web site we automatically receive the URL of the site from which you came and the site to which you are going when you leave todooliapp.COM. We also receive the Internet protocol (IP) address of your computer (or the proxy server you use to access the World Wide Web), your computer operating system and type of web browser you are using, email patterns, as well as the name of your ISP. This information is used to analyze overall trends to help us improve the todooliapp.COM service. The linkage between your IP address and your personally identifiable information is not shared with third-parties without your permission or except when required by law.</p><p>Certain information you provide to todooliapp.COM may reveal, or allow others to identify, your nationality, ethnic origin, religion or other aspects of your private life, and more generally about you. Please be aware that in providing information to todooliapp.COM for the purposes of opening your user account, you are expressly and voluntarily accepting the terms and conditions of this Privacy Policy and todooliapp.COMs User Agreement. The supplying of all such information by you to todooliapp.COM, including all information deemed sensitive by applicable law, is entirely voluntary on your part. You have the right to withdraw your consent at any time, in accordance with the terms of this Privacy Policy and the User Agreement, but please note that your withdrawal of consent will not be retroactive.</p>
<p>You have a right to access, modify, correct and eliminate the data about you which has been collected pursuant to your decision to become a User. If you update any of your information, we may keep a copy of the information which you originally provided to us in our archives for uses documented herein.</p></li><li><label>Data we collect</label><ul><li>We collect your email address, phone number, social network accounts, for purposes such as sending self-publishing and confirmation emails, authenticating user accounts, providing subscription email services, registering for forums, etc.</li>
<li>We collect your email, phone number, social network accounts information for account authentication purposes, SMS, phone calls etc. for sending you communication as you request.</li><li>Our web logs collect standard web log entries for each page served, including your IP address, page URL, and timestamp. Web logs help us to diagnose problems with our server, to administer the todooliapp.COM site, and to otherwise provide our service to you.</li>
</ul></li><li><label>Data we store</label><ul><li>All postings are stored in our database, even after "deletion," and may be archived elsewhere.</li><li>Our web logs and other records are stored indefinitely.</li>
<li>Registered job posters can access and update their account information through the account homepage.</li><li>Although we make good faith efforts to store the information in a secure operating environment that is not available to the public, we cannot guarantee complete security.</li>
</ul></li><li><label>Archiving and display of todooliapp.COM postings by search engines and other sites</label><p>Search engines and other sites not affiliated with todooliapp.COM - including google.com, and yahoo.com - archive or otherwise make available todooliapp.COM postings.</p>
</li><li><label>Circumstances in which todooliapp.COM may release information </label>
<ul><li>todooliapp.COM may disclose information about its users if required to do so by law or in the good faith belief that such disclosure is reasonably necessary to respond to subpoenas, court orders, or other legal process.</li><li>todooliapp.COM may also disclose information about its users to law enforcement officers or others, in the good faith belief that such disclosure is reasonably necessary to: enforce our Terms of Use; respond to claims that any posting or other content violates the rights of third-parties; or protect the rights, property, or personal safety of todooliapp.COM, its users or the general public.</li></ul></li><li><label>International Users</label>
<p>By visiting our web site and providing us with data, you acknowledge and agree that due to the international dimension of todooliapp.COM we may use the data collected in the course of our relationship for the purposes identified in this policy or in our other communications with you, including the transmission of information outside your resident jurisdiction. In addition, please understand that such data may be stored on servers located in the United States. By providing us with your data, you consent to the transfer of such data.</p>
</li></ol></div></div></div></div></div>';	
	$result['status'] = 0;
	$result['message'] = $message;
	return $result;
	}
	
	function termsCondition($get=NULL,$post=NULL)
	{
		if(isset($get['type']) && $get['type']==1)
		{
			$message = '<div class="content-box">  
<div class="content-box-header">
<h3 style="cursor: s-resize;">Employers Terms and conditions</h3>
</div> 
<div class="middle">
	<div class="field-area">
		
	 	<ol> 		<li>ACCEPTANCE OF TERMS</li> 		<li>MODIFICATIONS TO THIS AGREEMENT</li> 		<li>CONTENT</li> 		<li>THIRD PARTY CONTENT, SITES, AND SERVICES</li> 		<li>NOTIFICATION OF CLAIMS OF INFRINGEMENT</li> 		<li>PRIVACY AND INFORMATION DISCLOSURE</li> 	</ol> 

	    <div class="clear"></div>
    </div>
</div>
</div>';
		}
		else
		{
			$message = '<div class="content-box">  
<div class="content-box-header">
<h3 style="cursor: s-resize;">Seekers Terms & Conditions</h3>
</div> 
<div class="middle">
	<div class="field-area">
		
	 	<ol> 		<li>ACCEPTANCE OF TERMS</li> 		<li>MODIFICATIONS TO THIS AGREEMENT</li> 		<li>CONTENT</li> 		<li>THIRD PARTY CONTENT, SITES, AND SERVICES</li> 		<li>NOTIFICATION OF CLAIMS OF INFRINGEMENT</li> 		<li>PRIVACY AND INFORMATION DISCLOSURE</li> 	</ol> 

	    <div class="clear"></div>
    </div>
</div>
</div>';
		}
	$result['status'] = 0;
	$result['message'] = $message;
	return $result;
	}
	
	/*
	DESCRIPTION : For Contact Us Form
	METHOD : POST
	PARAM POST->name,email,comment
	*/
	function contactUs($get=NULL,$post=NULL)
	{
		if(!empty($post))
		{
			$validationOBJ = new Validation();
			$res = $validationOBJ->contactUs($post);
			if($res['status']==0)
			{
				$userObj = new Users();
				$result = $userObj->contactUs($post);
				return $result;
			}
			else
			{
				return $res;
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
	
	}
	
	/*
	DESCRIPTION : For MyProfile 
	METHOD : POST
	PARAM POST->userId
	*/
	function getMyProfile($get=NULL,$post=NULL)
	{
		$errorFlag=0;
		if(!isset($post['userId']))
		{
			$errorFlag=1;
		}		
		if($errorFlag==0)
		{
			$userObj=new Users();
			$result=$userObj->getUserDetail($post['userId']);			
			return $result;
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;	
		}
	}
	
	/*
	DESCRIPTION : For geting users Todo List
	METHOD : GET
	PARAM GET->userId
	*/
	function getMyList($get=NULL,$post=NULL)
	{
			$result=array();
			if(!isset($get['userId']))
			{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					return $result;
			}
			if(!empty($get))
			{
				
					if(isset($get['userId']) && !is_numeric($get['userId']))
					{
						 $algObj = new Algoencryption();
						 $res = $algObj->decrypt($get['userId']);
						 $get['userId'] = $res;
					}
					if(is_numeric($get['userId']))
					{
						$todoObj = new TodoLists();
						$res = $todoObj->getMyList($get['userId']);
						if(!empty($res) && $res!='')
						{
							$result['status'] = 1;						
							$result['message'] = $res;
						}
						else
						{
							$result['status'] = 0;						
							$result['message'] = "No Data Found.";
						}
					}
					else
					{
						$result['result'] = "Permision Denied";
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
						return $result;
					}
				}
			return $result;
	}
	
	
	function deleteList($get=NULL,$post=NULL)
	{
			$result=array();
			if(!isset($get['userId']) || !isset($get['listId']))
			{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					return $result;
			}
			if(!empty($get))
			{
					if(isset($get['userId']) && !is_numeric($get['userId']))
					{
						 $algObj = new Algoencryption();
						 $res = $algObj->decrypt($get['userId']);
						 $get['userId'] = $res;
					}
					if(is_numeric($get['userId']))
					{
						$toDoListObj =  new TodoLists();
						$todoObj = $toDoListObj->findByPk($get['listId']);
						if(isset($todoObj))
						{
							$res = $toDoListObj->deleteList($get['listId']);
							$result['status'] = 1;						
							$result['message'] = "successfully deleted.";
						}
						else
						{
							$result['status'] = $this->errorCode['_INVALID_REQUEST_'];						
							$result['message'] = $this->msg["_INVALID_REQUEST_"];
						}
					}
					else
					{
						$result['result'] = "Permision Denied";
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
						return $result;
					}
			}
			return $result;
	}
	
	
	/*
	DESCRIPTION : For updateProfile 
	METHOD : POST
	PARAM POST->userId,loginIdType
	*/
	function updateProfile($get=NULL,$post=NULL)
	{
		$errorFlag=0;
		if(!isset($post['userId']))
		{
			$errorFlag=1;
		}		
		if(!isset($post['loginIdType']))
		{
			$errorFlag=1;
		}
		
		if($errorFlag==0)
		{
			$sessionArray['userId']=$post['userId'];
			$sessionArray['loginId']=$post['userId'];
			$sessionArray['loginIdType']=$post['loginIdType'];
			$post['id']=$post['userId'];
			$usersObj=new Users();
			$resultProfile=$usersObj->editProfile($post,$sessionArray);	
			if($resultProfile['status']!=0)
			{
				return $resultProfile;	
			}
			$resultSocial=$this->updateSocialLink($post);
			if($resultSocial['status']!=0)
			{
				return $resultSocial;	
			}
			
			return $resultProfile;
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;	
		}
	}
	
	function updateSocialLink($_POST)
	{
		
		$linkValue[0]['link_name']	=	'linkedinLink';
		if(isset($_POST['linkedinLink_value']))
		{
			$linkValue[0]['link_value']	=	$_POST['linkedinLink_value'];
		}
		else
		{
			$linkValue[0]['link_value']	=	'';
		}
		$linkValue[1]['link_name']	=	'facebookLink';
		if(isset($_POST['facebookLink_value']))
		{
			$linkValue[1]['link_value']	=	$_POST['facebookLink_value'];
		}
		else
		{
			$linkValue[1]['link_value']	=	'';
		}
		$linkValue[2]['link_name']	=	'twitterLink';
		if(isset($_POST['twitterLink_value']))
		{
			$linkValue[2]['link_value']	=	$_POST['twitterLink_value'];
		}
		else
		{
			$linkValue[2]['link_value']	=	'';
		}
		$Obj=new Users();	
		foreach($linkValue as $link){
			$_POST['link_name']	=	$link['link_name'];
			$_POST['link_value']	=	$link['link_value'];
			if($_POST['link_name']!='')
			{
				$result=$Obj->updateSocialLink($_POST);
				if($result['status']!=0)
				{
					return $result;	
					break;
				}
			}
		}	
									
	}
	
	
	/*
	DESCRIPTION : add phone number to users profile
	METHOD : POST
	*/
	function addPhone($get=NULL,$post=NULL)
	{
			if(isset($post['userphoneNumber']) && $post['userphoneNumber'] != '' && isset($post['userId']) && $post['userId'] != '') 
			{
				$sessionArray['userId']=$post['userId'];
				$sessionArray['loginId']=Yii::app()->session['loginId'];
				$loginObj = new Login();
				$result=$loginObj->addPhone($post,1,$sessionArray);
				return $result;
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;	
			}
	}
	
	/*
	DESCRIPTION : Delete the Phone from users Profile
	METHOD : POST
	PARAM POST->id[encrypted],seekerId/accountManagerId,Type
	*/
	function deletePhone($get=NULL,$post=NULL)
	{
		
		$algObj = new Algoencryption();
		
		if(!empty($post) && isset($post['id']) && $post['id']!='')
		{
			if($post['Type']==1 && isset($post['accountManagerId']) && $post['accountManagerId']!='')
			{
				$algObj = new Algoencryption();
				if(!is_numeric($post['id']))
				{
					$post['id'] = $algObj->decrypt($post['id']);
				} 
				if(!is_numeric($post['accountManagerId']))
				{
					$post['accountManagerId'] = $algObj->decrypt($post['accountManagerId']);
				}
				if($post['id']!='' && is_numeric($post['id']))
				{
					 
						$user = new User();
						
						$str1 = Yii::app()->db->createCommand()
						->select("loginId")
						->from('users')
						->where('userId=:userId and id=:id', array(':userId'=>$post['accountManagerId'],':id'=>$post['id']))
						->queryScalar();
						
						if(is_numeric($str1))
						{
							$res=$user->deleteById($post['id']);
							$result['status'] = $res[0];
							$result['message'] = $res[1];
							return $result;
						}
						else
						{
							$result['status'] = 1;
							$result['message'] = "Login Authentication is Invalid.";
							return $result;
						}
					
				}
				else
				{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					return $result;
				}
			}
			else
			{
				if( isset($post) && $post['id']!='' && isset($post['seekerId']) &&  $post['seekerId']!='' && isset($post['Type']) && $post['Type']==0)
				{
					if(!is_numeric($post['id']))
					{
						$post['id'] = $algObj->decrypt($post['id']);
					} 
					if(!is_numeric($post['seekerId']))
					{
						$post['seekerId'] = $algObj->decrypt($post['seekerId']);
					}
					if(is_numeric($post['seekerId']) && is_numeric($post['id']))
					{
						
						$str = Yii::app()->db->createCommand()
						->select("loginId")
						->from('users')
						->where('userId=:userId and id=:id', array(':userId'=>$post['seekerId'],':id'=>$post['id']))
						->queryScalar();
						
						if(is_numeric($str))
						{
							$userObj = new User();
							$res=$userObj->deleteById($post['id']);
							$result['status'] = 0;
							$result['message'] = $res[1];
							return $result;
						}
						else
						{
							$result['status'] = 1;
							$result['message'] = "Login Authentication is invalid.";
							return $result;
						}
					}
					else
					{
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
						return $result;
					}
					
				}
				else
				{					
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					return $result;
				}

			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
			
		}
	
	}
	
	/*
	DESCRIPTION : For geting my Todo Items
	METHOD : GET
	PARAM GET->userId,sortType,sortBy,keyword
	*/
	
	function getMyToDoItems($get=NULL,$post=NULL)
	{
			$result=array();
			if(!empty($get) && isset($get['userId']) &&  $get['userId'] != '')
			{
					if(isset($get['userId']) && !is_numeric($get['userId']))
					{
						 $algObj = new Algoencryption();
						 $res = $algObj->decrypt($get['userId']);
						 $get['userId'] = $res;
					}
					if(!isset($get['sortType']))
					{
						$get['sortType'] = "desc";
					}
					if(!isset($get['sortBy']))
					{
						$get['sortBy'] = "id";
					}
					if(!isset($get['keyword']))
					{
						$get['keyword'] = "";
					}
					
					if(is_numeric($get['userId']))
					{
						$sessionArray['userId'] = $get['userId'];
						$sessionArray['loginId'] = $get['userId'];
						$todoObj = new TodoItems();
						$res = $todoObj->getMyToDoItems($sessionArray,LIMIT_10,$get['sortType'],$get['sortBy'],$get['keyword']);
						$result['result'] = $res;
						$result['status'] = 0;
						$result['message'] = "success";
					}
					else
					{
						$result['result'] = "Permision Denied";
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					}
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			}
			return $result;
	}
	
	/*
	DESCRIPTION : For geting assign by me Todo Items
	METHOD : GET
	PARAM GET->userId,sortType,sortBy,keywordAssignByMe
	*/
	function getAssignedByMeItems($get=NULL,$post=NULL)
	{
			$result=array();
			if(!empty($get) && isset($get['userId']) &&  $get['userId'] != '')
			{
					if(isset($get['userId']) && !is_numeric($get['userId']))
					{
						 $algObj = new Algoencryption();
						 $res = $algObj->decrypt($get['userId']);
						 $get['userId'] = $res;
					}
					if(!isset($get['sortType']))
					{
						$get['sortType'] = "desc";
					}
					if(!isset($get['sortBy']))
					{
						$get['sortBy'] = "id";
					}
					if(!isset($get['keywordAssignByMe']))
					{
						$get['keywordAssignByMe'] = "";
					}
					
					if(is_numeric($get['userId']))
					{
						$sessionArray['userId'] = $get['userId'];
						$sessionArray['loginId'] = $get['userId'];
						$todoItemObj = new TodoItems();
						$res = $todoItemObj->getAssignedByMeItems($sessionArray,LIMIT_10,$get['sortType'],$get['sortBy'],$get['keywordAssignByMe']);
						$result['result'] = $res;
						$result['status'] = 0;
						$result['message'] = "success";
					}
					else
					{
						$result['result'] = "Permision Denied";
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					}
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			}
			return $result;
	}
	
	
	/*
	DESCRIPTION : For geting assign by me Todo Items
	METHOD : GET
	PARAM GET->userId,sortType,sortBy,keywordOther
	*/
	function getOtherToDoItems($get=NULL,$post=NULL)
	{
			$result=array();
			if(!empty($get) && isset($get['userId']) &&  $get['userId'] != '')
			{
					if(isset($get['userId']) && !is_numeric($get['userId']))
					{
						 $algObj = new Algoencryption();
						 $res = $algObj->decrypt($get['userId']);
						 $get['userId'] = $res;
					}
					if(!isset($get['sortType']))
					{
						$get['sortType'] = "desc";
					}
					if(!isset($get['sortBy']))
					{
						$get['sortBy'] = "id";
					}
					if(!isset($get['keywordOther']))
					{
						$get['keywordOther'] = "";
					}
					
					if(is_numeric($get['userId']))
					{
						$sessionArray['userId'] = $get['userId'];
						$sessionArray['loginId'] = $get['userId'];
						$todoItemObj = new TodoItems();
						$res = $todoItemObj->getOtherToDoItems($sessionArray,LIMIT_10,$get['sortType'],$get['sortBy'],$get['keywordOther']);
						$result['result'] = $res;
						$result['status'] = 0;
						$result['message'] = "success";
					}
					else
					{
						$result['result'] = "Permision Denied";
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					}
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			}
			return $result;
	}
	
	/*
	DESCRIPTION : For geting users reminders
	METHOD : GET
	PARAM GET->userId
	*/
	
	function getMyReminders($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['userId']) && $get['userId'] != '')
		{
			$reminderObj	=	new Reminder();
			$reminders	=	$reminderObj->getReminderByUserId(Yii::app()->session['loginId']);
			$result['status'] = 0;
			$result['message'] ="success";
			$result['result'] =$reminders;
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
		}
		return $result;
	}
	
	/*
	DESCRIPTION : For geting assign by me Todo Items
	METHOD : GET
	PARAM GET->userId,sortType,sortBy,keywordOther
	*/
	function getInvites($get=NULL,$post=NULL)
	{
			$result=array();
			if(!empty($get) && isset($get['userId']) &&  $get['userId'] != '')
			{
					if(isset($get['userId']) && !is_numeric($get['userId']))
					{
						 $algObj = new Algoencryption();
						 $res = $algObj->decrypt($get['userId']);
						 $get['userId'] = $res;
					}
					if(!isset($get['sortType']))
					{
						$get['sortType'] = "desc";
					}
					if(!isset($get['sortBy']))
					{
						$get['sortBy'] = "id";
					}
					if(!isset($get['keyword']))
					{
						$get['keyword'] = "";
					}
					
					if(is_numeric($get['userId']))
					{
						$sessionArray['userId'] = $get['userId'];
						$sessionArray['loginId'] = $get['userId'];
						$invitesObj = new Invites();
						$res = $invitesObj->getInvitesByReceiverId($sessionArray['loginId'],NULL,$get['sortType'],$get['sortBy'],$get['keyword']);
						$result['result'] = $res;
						$result['status'] = 0;
						$result['message'] = "success";
					}
					else
					{
						$result['result'] = "Permision Denied";
						$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
						$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					}
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			}
			return $result;
	}
	
	function changePassword($get=NULL,$post=NULL)
	{
			if(!empty($get) && isset($get['userId']) && $get['userId'] != '' && isset($get['oldpassword']) && $get['oldpassword'] != '' && isset($get['newpassword']) && $get['newpassword'] != '' && isset($get['confirmpassword']) && $get['confirmpassword'] != '')
			{
					$result = array();
					$userObj = new Users();
					$res = $userObj->checkOldPassword($get['userId']);
					$res = $userObj->changePassword($get);
					return $res;
			}
			else
			{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
					return $result;
			}
			
			return $result;
	}
	
	/*
	DESCRIPTION : For Upload profile pic for User
	METHOD : POST
	*/
	function uploadAvatar($get=NULL,$post=NULL)
	{
		$_GET['inserver'] = 3;
		if(!isset($post['file_name']))
		{
			return array("status"=>302,"message"=>"File upload error.");	
		}
		if(isset($post['userId']))
        {
			$usersObj = new Users();
			$result=$usersObj->uploadAvatar($post,array(),'update');
			return $result;
		}	
		return array('status'=>302,"message"=>"File parameter NULL.");
	}
	
	
	
	public function addcomments($get=NULL,$post=NULL)
	{
		if(!empty($post) && isset($post['userId']) && $post['userId'] != '' && isset($post['listId']) && $post['listId'] != '' && isset($post['itemId']) && $post['itemId'] != '' && isset($post['commentText']) && $post['commentText'] != '')
			{
				$result = array();
				$commentsObj	=	new Comments();
				$post['comments'] = $post['commentText'];
				$sessionArray['loginId']	=	Yii::app()->session['loginId'];
				$sessionArray['userId']	=	Yii::app()->session['userId'];
				$result	=	$commentsObj->addItemComments($post, $sessionArray);
				return $result;
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;
			}
	}
	

	public function getcommentsByList($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['userId']) && $get['userId'] != '' && isset($get['listId']) && $get['listId'] != '')
			{
				$result = array();
				$commentObj = new Comments();	
				$res = $commentObj->getcommentsByList($get['listId']);
				if(!empty($res) && $res != '')
				{
					$result['status'] = 0;
					$result['message'] = $res;
				}
				else
				{
					$result['status'] = -4;
					$result['message'] =$this->msg['_COMMENT_ERROR_'];
				}
				return $result;
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;
			}
	}
	
	public function getcommentsByUser($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['userId']) && $get['userId'] != '')
			{
				$result = array();
				$commentObj = new Comments();	
				$res = $commentObj->getcommentsByUser($get);
				if(!empty($res) && $res != '')
				{
					$result['status'] = 0;
					$result['message'] = $res;
				}
				else
				{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] =$this->msg['_COMMENT_ERROR_'];
				}
				return $result;
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;
			}
	}
	
	public function getcommentsByItem($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['userId']) && $get['userId'] != '' && isset($get['itemId']) && $get['itemId'] != '')
			{
				$result = array();
				$commentObj = new Comments();	
				$res = $commentObj->getcommentsByItem($get);
				if(!empty($res) && $res != '')
				{
					$result['status'] = 0;
					$result['message'] = $res;
				}
				else
				{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] =$this->msg['_COMMENT_ERROR_'];
				}
				return $result;
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;
			}
	}
	
	/*********** 	DELETE REMINDER FUNCTION  ***********/
	public function deleteReminder($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
				$reminderObj	=	new Reminder();
				if(!is_numeric($get['id']) ) {
				$algoencryptionObj	=	new Algoencryption();
				$get['id']	=	$algoencryptionObj->decrypt($get['id']);
				}
				$result	=	$reminderObj->deleteReminder($get['id']);
				return json_encode($result);
		} else {
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				return $result;
		}
	}
	
	/*********** 	DELETE TODO ITEM FUNCTION  ***********/
	public function deleteItem($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
			$todoItemObj	=	new TodoItems();
			if(!is_numeric($get['id']) ) {
			$algoencryptionObj	=	new Algoencryption();
			$get['id']	=	$algoencryptionObj->decrypt($get['id']);
			}
			$result	=	$todoItemObj->deleteItemById($get['id']);
			return json_encode($result);
		} else {
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
	}
	
	public function itemDescription($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
			$todoItemsObj	=	new TodoItems();
			$item	=	$todoItemsObj->getItemDetails($get['id']);
			if($item)
			{
				$result['status'] = 0;
				$result['message'] = "success";
				$result['result'] = $item;
			}
			else
			{
				$result['status'] = 1;
				$result['message'] = "No Data Found.";
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
		}
		return $result;
	}
	
	public function getItemHistory($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
			
			if(isset($get['page']))
			{
				$_REQUEST['page'] = $get['page'];
			}else
			{
				$_REQUEST['page'] = 1;
			}
			
			$todoItemChangeHistoryObj	=	new TodoItemChangeHistory();
			$itemHistory	=	$todoItemChangeHistoryObj->getItemHistory($get['id'],NULL,$_REQUEST['page']);
			
			if(!empty($itemHistory[1]))
			{
				$result['status'] = 0;
				$result['message'] = "success";
				$result['result'] = $itemHistory;
				$result['itemId'] = $get['id'];
			}
			else
			{ 
				$result['status'] = 1;
				$result['message'] = "No Data Found.";
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
		}
		return $result;

	}
	
	public function deleteComment($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
			$commentsObj	=	new Comments();
			$post	=	$commentsObj->findByPk($get['id']); 
			if($post)
			{
				$post->delete();
				$result['status'] = "0";
				$result['message'] = "success";
			}
			else
			{
				$result['status'] = "1";
				$result['message'] = "fail";
			}
		}else {
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
		}
		return $result;
	}
	
	public function removeFrommyNetwork($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
			$id = $get['id'];
			if(!is_numeric($id) ) {
			$algoencryptionObj	=	new Algoencryption();
			$id	=	$algoencryptionObj->decrypt($id);
			}
			$todoNetwork=Todonetwork::model()->findbyPk($id);
			if(!empty($todoNetwork))
			{
				$todoNetwork->delete();
				$todoItemObj = new TodoItems();
				$result	=	$todoItemObj->deleteItemById($get['id']);
				return json_encode(array("status"=>0,"message"=>"Successfully remove from your network."));
			}
			else
			{
				return json_encode(array("status"=>-5,"message"=>"you passed invalid network id."));
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
	}
	
	public function getNetworkUserDetails($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['id']) && $get['id'] != '')
		{
			$id = $get['id'];
			if(!is_numeric($id) ) {
			$algoencryptionObj	=	new Algoencryption();
			$id	=	$algoencryptionObj->decrypt($id);
			}
			$toDoNetworkObj = new Todonetwork();
			$dataProvider=$toDoNetworkObj->getNetworkUserDetail($id);
			return json_encode(array("status"=>0,"message"=>"success","result"=>$dataProvider->getData()));
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
		
	}
	
	public function invite($get=NULL,$post=NULL)
	{
		if(!empty($get) && !isset($get['listId']) && $get['listId'] != '' && !isset($get['senderId']) && $get['senderId'] != '' && !isset($get['receiverId']) && $get['receiverId'] != '' && !isset($get['role']) && $get['role'] != '')
			{
				$invObj =  new Invites();
				$res = $invObj->invite($get);
				if(!empty($res) && $res != '')
				{
					$result['status'] = 0;
					$result['message'] = $this->msg['_FRIEND_INVITE_'];
				}
				else
				{
					$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
					$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
				}
			}
			else
			{
				$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
				$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			}
			return $result;
	}
	
	public function reassignTask($get=NULL,$post=NULL)
	{
		if(!empty($get) && isset($get['loginId']) && $get['loginId'] != '')
		{
			$loginObj=new Login();
			$loginData=$loginObj->getLoginDetailsById($get['loginId'],'last_todoassign');
			if(isset($get['id']) && !is_numeric($get['id']) ) {
				$algoencryptionObj	=	new Algoencryption();
				$id	=	$algoencryptionObj->decrypt($get['id']);
			}
			if(isset($loginData) && $loginData['last_todoassign'] !='')
			{
				$result['status'] = 0;
				$result['message'] = "success";
				$result['id'] = $get['id'];
				$result['last_todoassign'] = $loginData['last_todoassign'];
			}
			else
			{
				$result['status'] = 1;
				$result['message'] = "No Data Found.";
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
		}
		return $result;
	}
	
	
	function addToDoList($get=NULL,$post=NULL)
	{
		if(!empty($post) && isset($post['todoList']) && $post['todoList'] != '' && isset($post['id']) && $post['id'] != '')
		{
			$data = array();
			$succstr = '';
			$errstr = '';
			if($post['todoList'] == '' || $post['id'] == '')
			{
				return json_encode(array("status"=>$this->errorCode['_ADDTODO_VALIDATION_'],"message"=>$this->msg['_ADDTODO_VALIDATION_']));
				exit;
			}
				$todoListObj =  new TodoLists();
				$res = $todoListObj->checkList($post['todoList'],$post['loginId']);
				if($res == NULL)
				{
					$sessionArray['loginId']=$post['loginId'];
					$sessionArray['fullname']=$post['fullname'];
					$res = $todoListObj->SaveTodoList($post,$sessionArray);
					
					$succstr .= $this->msg['_TODO_ADD_SUCCESS_'];
					if(!empty($res[0]))
						{
								for($i=0;$i<count($res[0]);$i++)
								{
									$succstr .= $res[0][$i]['email'].''.$res[0][$i]['message'].'<br>';
								}
						}
						if(!empty($res[1]))
						{
							$str = '';
							for($i=0;$i<count($res[1]);$i++)
							{
								$errstr .= $res[1][$i]['email'].''.$res[1][$i]['message'].'<br>';
							}
						}
						$this->callDaemon('send_email');
					
				}
				else
				{
					$errstr .= $this->msg['_LIST_NAME_EXIT_'];
				}
				$arr[] = $succstr;
				$arr[] = $errstr;
				return $arr;
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
	}
	
	/*
	PARAMS : id,todoList,title,description,attachment,priority,duedate,assignerType,userlist
	COND   : Edit => id and value [email id for reassign]
	METHOD : POST
	*/
	function addToDoItem($get=NULL,$post=NULL)
	{
		if(!empty($post) && isset($post['todoList']) && $post['todoList'] != '' && isset($post['title']) && $post['title'] != '' && isset($post['priority']) && $post['priority'] != '')
		{
			$TodoItemsObj=new TodoItems();
			$sessionArray['loginId']=$post['loginId'];
			$sessionArray['fullname']=$post['fullname'];
			
			if(!isset($post['id'])){
				$result=$TodoItemsObj->addTodoItem($post,$sessionArray);
			} else {
				$result=$TodoItemsObj->addTodoItem($post,$sessionArray,$post['id']);
			}
			return $result;
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
	}
	
	/*
	PARAMS : id[itemId],comment,loginId
	METHOD : POST
	*/
	public function assignBack($get=NULL,$post=NULL)
	{
		if(!empty($post) && isset($post['id']) && $post['id'] != '' && isset($post['comments']) && $post['comments'] != '')
		{
			
			$todoItemsObj	=	new TodoItems();
			if(isset($post['id']) ) {
				$sessionArray['loginId']	=	$post['loginId'];
				$post['userId']	=	$post['loginId'];
				$result	=	$todoItemsObj->assignBack($post, $sessionArray);
				//$result	=	array('status'=>0, 'message'=>'success');
				return json_encode($result);
				exit;
			}
			//$this->renderPartial('assignBack', array('data'=>$itemId));
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
	}
	
	function callDaemon($daemon_name = "hirenow")
	{
		$sig = new signals_lib();
		$sig->get_queue($this->arr[$daemon_name]);
		$sig->send_msg($daemon_name);
	}
	
	
	//Deamon
	//Params 
	function getAllUnreadRestCall()
	{
		try {
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->where('status=:status',array(':status'=>200))
		->queryAll();
		return $result;
		 } catch (Exception $e) {
            error_log('Exception caught: ' . $e->getMessage());

        }
	}
	
	//Deamon
	//Params 
	function getAllExpiredCall()
	{
		try {
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from('incoming_rest_calls')
		->where('expiry<=:expiry', array(':expiry'=>time()))
		->queryColumn();
		return $result;
		 } catch (Exception $e) {
            error_log('Exception caught: ' . $e->getMessage());
        }
	}
	
	function getrestdata($uri)
	{
		$data = Yii::app()->db->createCommand()
			->select('*')
			->from('incoming_rest_calls')
			->where('uri=:uri', array(':uri'=>$uri))
			->queryRow();
		return $data;
	}
	
}