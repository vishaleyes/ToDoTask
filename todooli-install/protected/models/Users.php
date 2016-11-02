<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $firstName
 * @property string $lastName
 * @property string $birthDate
 * @property string $address
 * @property string $avatar
 * @property string $createdAt
 * @property string $modifiedAt
 * @property string $deletedAt
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('firstName, lastName, birthDate, address, avatar, createdAt, modifiedAt, deletedAt', 'required'),
			//array('firstName, lastName', 'length', 'max'=>50),
			//array('avatar', 'length', 'max'=>255),
			//array('deletedAt', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, firstName, lastName, birthDate, address, avatar, createdAt, modifiedAt, deletedAt', 'safe', 'on'=>'search'),
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
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'birthDate' => 'Birth Date',
			'address' => 'Address',
			'avatar' => 'Avatar',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
			'deletedAt' => 'Deleted At',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('birthDate',$this->birthDate,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
		$criteria->compare('deletedAt',$this->deletedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// set the user data
	function setData($data)
	{
		$this->data = $data;
	}
	
	// insert the user
	function insertData($id=NULL)
	{
		if($id!=NULL)
		{
			$transaction=$this->dbConnection->beginTransaction();
			try
			{
				$post=$this->findByPk($id);
				if(is_object($post))
				{
					$p=$this->data;
					
					foreach($p as $key=>$value)
					{
						$post->$key=$value;
					}
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
			$this->setIsNewRecord(true);
			$this->save(false);
			return Yii::app()->db->getLastInsertID();
		}
		
	}
	
	/*
	DESCRIPTION : GET ALL USERS WITH PAGINATION
	*/
	public function getAllPaginatedUsers($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
 		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (u.firstName like '%".$keyword."%' or u.lastName like '%".$keyword."%' or l.loginId like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and createdAt > '".date("Y-m-d",strtotime($startDate))."' and createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}
		
		
		 $sql_users = "select *,l.id as logId from users u,login l where u.id=l.userId ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from users u,login l where u.id=l.userId ".$search." ".$dateSearch."";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'users'=>$item->getData());
	}
	
	/*
	DESCRIPTION : ADD USER
	*/
	function addRegisterUser($data,$mobile=0,$fromApi=1)
	{
		$generalObj	=	new General();
		$algoObj	=	new Algoencryption();
		$loginObj	=	new Login();
		$flagerroremail	=	0;
		$flagsuccessemail	=	0;
		$flagsuccessmsg	=	0;	
		$flagerrormsg	=	0;
		$Password	=	$generalObj->encrypt_password($data['password']);
		if(isset(Yii::app()->session['adminUser']) && Yii::app()->session['adminUser']!='' && isset($data['admin']) && $data['admin']!='')
		{			
			$everify_code=1;
			$User_value['modified'] = date('Y-m-d H:i:s');
		}
		else
		{			
			$everify_code=$generalObj->encrypt_password(rand(0,99).rand(0,99).rand(0,99).rand(0,99));
		}
		//Insert multiple entries in users table
		$User_value['isVerified']=$everify_code;//1;
		$User_value['expiry']=time()+ACTIVATION_LINK_EXPIRY_TIME;
		$User_value['created'] = date('Y-m-d H:i:s');
		$User_value['password'] = $Password;
		
		if(isset($data['phoneNumber']) && $data['phoneNumber']!='' && strtolower($data['phoneNumber'])!=strtolower($this->msg['_PHONE_NUMBER_']))
		{
			$data['phoneNumber']	=	$data['phoneNumber'];
		}
		else
		{
			$data['phoneNumber']	=	'';
		}
		if(isset($data['email']) && $data['email']!='' && $data['email']!=$this->msg['_EMAIL_'])
		{
			$data['email']	=	$data['email'];
		}
		else
		{
			$data['email']	=	'';
		}
		$fullname=$data['fName'].' '.$data['lName'];
		$phonenumber=$data['phoneNumber'];
		$email=$data['email'];
		$helperObj = new Helper();
		// for with mail in without api 
		
		if($fromApi==0)
		{
			
			$email_admin =	$this->msg['_ADMIN_EMAIL_'];	
			$subject_admin = $this->msg['_SIGNUP_SEEKER_DETAIL_ADMIN_MSG_SUBJECT_'];
						
			$serverPara='Web';	
			if($mobile==1)
			{
				$serverPara='Mobile web';
			}
			if(isset($_POST['inServer']))
			{
				if($_POST['inServer']==3)
				{
					$serverPara='Android';
				}
				else if($_POST['inServer']==4)
				{
					$serverPara='Iphone';
				}
				else
				{
					$serverPara='Web';	
				}
			}
			$Yii = Yii::app();	
			$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/'.$this->msg['_ET_SIGNUP_SEEKER_DETAIL_ADMIN_MSG_TPL_'].'';
			$message_admin = file_get_contents($url);
			
			$message_admin = str_replace("_BASEPATH_",Yii::app()->params->image_path,$message_admin);			
			$message_admin = str_replace("_FULL_NAME_",$fullname,$message_admin);
			$message_admin = str_replace("_PHONE_NUMBER_",$phonenumber,$message_admin);
			$message_admin = str_replace("_EMAIL_",$email,$message_admin);
			$message_admin = str_replace("_USING_",$serverPara,$message_admin);
			
			
			$helperObj->mailSetup($email_admin,$subject_admin,$message_admin);
		}
		
		if($data['email'] != "" && $data['email'] != $this->msg['_EMAIL_'] )
		{
			if($generalObj->isValidEmail($data['email']))
			{
				$User_value['loginId']	=	$data['email'];
				$User_value['loginIdType']	=	'0';
				
				$userData['firstName']	=	$data['fName'];
				$userData['lastName']	=	$data['lName'];
				$userData['timezone'] = $data['timezone'];
				$userData['createdAt']	=	date('Y-m-d H:i:s');
				$userData['modifiedAt']	=	date('Y-m-d H:i:s');
				unset($userData['isVerified']);
				$this->setData($userData);
				$this->setIsNewRecord(true);
				$userId=$this->insertData();
				
				/**** ADD TO LOGIN TABLE ****/
				$User_value['userId']	=	$userId;
				$User_value['status']	=	1;
				$User_value['smsOk']	=	0;
				$loginObj = new Login();
				$loginObj->setData($User_value);
				$loginObj->setIsNewRecord(true);
				$loginId = $loginObj->insertData();
				
				/**** ADD DEFAULT TODO LIST ****/
				$todoListObj	=	new TodoLists();
				$todoList['name']	=	'Self';
				$todoList['createdBy']	=	$loginId;
				$todoList['status']	=	0;
				$todoList['createdAt']	=	date('Y-m-d H:i:s');
				$todoList['modifiedAt']	=	date('Y-m-d H:i:s');
				$todoListObj->setData($todoList);
				$todoListObj->insertData();
				
				/**** ADD DEFAULT REMINDER ****/
				$reminderObj	=	new Reminder();
				$reminder['userId']	=	$loginId;
				$reminder['listId']	=	0;
				$reminder['itemStatus']	=	0;
				$reminder['dueDate']	=	0;
				$reminder['duration']	=	0;
				$reminder['time']	=	date('G:00:00', strtotime('6 am'));
				$reminder['nextDate']	=	date("Y-m-d 00:00:00", strtotime("1 days"));
				$reminder['createdDate']	=	date('Y-m-d H:i:s');
				$reminder['modifiedDate']	=	date('Y-m-d H:i:s');
				$reminderObj->setData($reminder);
				$reminderObj->insertData();
				
				if(trim($data['userIdForNetwork']) != '' && trim($data['listId']) != '')
				{
						
						$inviteArr = array();
						$inviteArr['listId'] = $data['listId'];
						$inviteArr['createdBy'] = $data['userIdForNetwork'];
						$inviteArr['receiverId'] = $loginId;
						$todoListObj =  new TodoLists();
						$todoListObj->inviteOnRegister($inviteArr);
						$todoitemsObj =  new TodoItems();
						$todoitemsObj->updateTodoItemsEmail($loginId,$data['email']);
				}
				$Yii = Yii::app();	
				$emailLink = $Yii->params->base_path."site/verifyAccount/key/".$everify_code.'/id/'.$algoObj->encrypt($loginId).'/lng/eng';
				
				$recipients = $data['email'];							
				$email =$data['email'];							
				$fullname=$data['fName'].' '.$data['lName'];
				$subject= 'Todooli Account Confirmation.';
				
				$Yii = Yii::app();	
				if(isset(Yii::app()->session['adminUser']) && Yii::app()->session['adminUser']!=''  && isset($data['admin']) && $data['admin']!='')
				{
					$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/useradmin-confirmation-link';
				}
				else
				{
					$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/user-confirmation-link';
				}
				$message = file_get_contents($url);
				$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->base_url.'images',$message);
				
				if($mobile==1)
				{
					$message = str_replace("_BASEPATH_",BASE_PATH.'m/',$message);
				}
				else
				{
					$message = str_replace("_BASEPATH_",BASE_PATH,$message);
				}									
				$message = str_replace("_EMAIL_LINK_",$emailLink,$message);
				
				$message = str_replace("_LOGINID_",$data['email'],$message);
				$message = str_replace("_USER_CONFIRMATION_VERIFY_LINK_",$this->msg['_USER_CONFIRMATION_VERIFY_LINK_'],$message);
				$message = str_replace("_PASSWORD_",$data['password'],$message);
				
				$helperObj = new Helper();
				$mailResponse=$helperObj->mailSetup($email,$subject,$message);
				
				if($mailResponse!=true)
				{
				  $flagerroremail=1;
				}
				else
				{	  $flagsuccessemail=1;
					if(isset(Yii::app()->session['userId']))
					{
						unset(Yii::app()->session['userId']);
					}
				}	
			}
		}
		
		
		if($data['phoneNumber'] != "" && strtolower($data['phoneNumber']) != strtolower($this->msg['_PHONE_NUMBER_']))
		{
			if($generalObj->validate_phoneUS($data['phoneNumber']))
			{
				if(isset($_SESSION['adminUser']) && $_SESSION['adminUser']!='' && isset($data['admin']) && $data['admin']!='')
				{
					$token=1;	
				}
				else
				{
					$token=rand(10,99).rand(10,99).rand(10,99);
				}
				
				$User_value['loginId'] = $data['phoneNumber'];
				$User_value['loginIdType'] ='1';
				$User_value['isVerified']=$token;
				if(isset($data['smsOk']))
				{
					$User_value['smsOk'] = $data['smsOk'];
				}
				
				$User = new Login();
				$User->setData($User_value);
				$User->setIsNewRecord(true);
				$loginId_phone=$User->insertData();
				
				if(trim($data['userIdForNetwork']) != '' &&  trim($data['listId']) != '')
				{
						$inviteArr = array();
						$inviteArr['listId'] = $data['listId'];
						$inviteArr['createdBy'] = $data['userIdForNetwork'];
						$inviteArr['receiverId'] = $loginId_phone;
						$todoListObj =  new TodoLists();
						$todoListObj->inviteOnRegister($inviteArr);
				}
				$flagsuccessmsg=1;	
			}	
		}
	
		if($flagerrormsg==1 && $flagerroremail==1)
		{
			return array('status'=>$this->errorCode['EMAIL_SMS_SEND_ERROR'],'message'=>$this->msg['EMAIL_SMS_SEND_ERROR']);
		}
		else if($flagerrormsg==1)
		{
			return array('status'=>$this->errorCode['SMS_SEND_ERROR'],'message'=>$this->msg['SMS_SEND_ERROR']);
		}
		else if($flagerroremail==1)
		{
			return array('status'=>$this->errorCode['_EMAIL_SEND_ERROR_'],'message'=>$this->msg['_EMAIL_SEND_ERROR_']);
		}
		else
		{
		
			if($flagsuccessmsg==1 && $flagsuccessemail==1)
			{
				$msgmsg=$this->msg['SUCCESS_MSG_BOTH'];
				$message = str_replace("_token_",$token,$msgmsg);	
				return array('status'=>0,'message'=>$message,'token'=>$token,'Id'=>$loginId);
			}
			else if($flagsuccessmsg==1)
			{
				$msgmsg=$this->msg['SUCCESS_MSG_SMS'];
				$message = str_replace("_token_",$token,$msgmsg);	
				return array('status'=>0,'message'=>$message,'token'=>$token,'Id'=>$loginId_phone);
			}
			else
			{
				$msgmsg=$this->msg['SUCCESS_MSG_EMAIL'];
				return array('status'=>0,'message'=>$msgmsg,'Id'=>$loginId);
			}
		}	
	
	}
	/*
	DESCRIPTION : USER LOGIN
	*/
	function login($email,$password,$remember=0,$apiLogin=0)
	{
		global $msg;
		$isSuccess=0;
		$successType='seeker';
		if($remember==1)
		{		
			setcookie("password_login", $password, time()+60*60*24*500, "/");
			setcookie("email_login",$email, time()+60*60*24*500, "/");
		}
		$generalObj=new General;
		if($generalObj->validate_phoneUS($email))
		{
			$email=$generalObj->clearPhone($email);
			
		}
		$loginObj	=	new Login();
		$users = $loginObj->getVerifiedUser($email);
		$err_msg = NULL;
		if(!empty($users))
		{
			$users = $users[0];
			
			if($users['isVerified'] != 1)
			{
				$err_msg = 'ERROR_VERIFICATION_MSG';
			}
			elseif($users['status'] != 1)
			{
				$err_msg = 'ERROR_STATUS_MSG_0';
			}
			elseif(false==$generalObj->validate_password($password, $users['password']))
			{
				$err_msg	=	'EMAIL_PHONE_MSG';
			}
			else
			{
				
				$isSuccess=1;
				$algoObj = new Algoencryption();
				$fullname	=	$this->getUserById($users['userId']);
				
				Yii::app()->session['userId']=$users['userId'];
				Yii::app()->session['loginId']=$users['id'];
				if(!empty($fullname))
				{
					Yii::app()->session['fullname'] =$fullname['firstName'].'&nbsp;'.$fullname['lastName'];
					
				}
				else
				{
					Yii::app()->session['fullname']='Username';
				}
					
				Yii::app()->session['loginIdType'] =  $users['loginIdType'];
				Yii::app()->session['email'] =  $users['loginId'];
				
				if(isset(Yii::app()->session['email_login']))
				{
					unset(Yii::app()->session['email_login']);
				}
			}
		}
		else
		{
			$err_msg = 'EMAIL_PHONE_MSG';
		}
		
		if($isSuccess==1)
		{	
			if($apiLogin==1)
			{
				$algoObj= new Algoencryption();
				$oauthObj=new Oauth();
				
				$oauthDetail=$oauthObj->getAuthDetailsByclientId(Yii::app()->session['userId'],'userId');
				
				if(empty($oauthDetail) || $oauthDetail['client_id']==NULL || $oauthDetail['client_id']=='')
				{
					$oauthDetail=$oauthObj->addClient(Yii::app()->session['userId']);
				}
					$token=$oauthObj->createAccessToken($oauthDetail['client_id']);
					$returnData['client_id']=$oauthDetail['client_id'];
					$returnData['client_secret']=$oauthDetail['client_secret'];
					$returnData['oauth_token']=$token['access_token'];
					$returnData['userId']=$algoObj->encrypt(Yii::app()->session['userId']);
					return array("status"=>0,"message"=>$this->msg['_LOGIN_MESSAGE_'],"outhDetails"=>$returnData);
			
			}
			Yii::app()->session['firstLoadFlag']=1;
			return array("status"=>0,"message"=>$successType);
			
		}
		else
		{
			Yii::app()->session['email_login']=$email;
			return array('status'=>$this->errorCode['_LOGIN_ERROR_'],'message'=>$this->msg['_LOGIN_ERROR_']);
			
		}
	}
	
	/*
	DESCRIPTION : GET USER BY ID
	*/
	public function getUserById($id=NULL, $fields='*')
	{
		$result = Yii::app()->db->createCommand()
    	->select($fields)
    	->from($this->tableName())
   	 	->where('id=:id', array(':id'=>$id))	
   	 	->queryRow();
		
		return $result;
	}	
	
	
	/*
	DESCRIPTION : GET USER BY ID
	*/
	public function getUserDetail($id=NULL, $fields='*')
	{
		
		$algoencryptionObj = new Algoencryption();	
		if(!is_numeric($id))
		{	
			$id=$algoencryptionObj->decrypt($id);
		}
		$loginObj =  new Login();
		$loginArr = $loginObj->getUserId($id);
		
		$result = Yii::app()->db->createCommand()
    	->select($fields)
    	->from($this->tableName())
   	 	->where('id=:id', array(':id'=>$loginArr['userId']))	
   	 	->queryRow();
		
		if(!empty($loginArr))
		{
			$result['loginId']=$loginArr['loginId'];
			$result['password']=$loginArr['password'];
			$result['loginIdType']=$loginArr['loginIdType'];
			$result['isVerified']=$loginArr['isVerified'];
			$result['status']=$loginArr['status'];
			$res = array("status"=>0,"result"=>$result);
		}
		else
		{
			$res=array("status"=>"-1","message"=>"No Data Found.","result"=>"no data");
		}
		return $res;
	}	
	
	public function checkOldPassword($id)
	{
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from('login')
   	 	->where('userId=:userId', array(':userId'=>$id))	
   	 	->queryRow();
		
		return $result;
	}
	
	
	
	function editProfile($post,$sess)
	{
		$data=array();
		$validation = new Validation();
		$res = $validation->editProfile($post);
		if($res['status']==0)
		{
		$data['firstName'] = $post['fName'];
		$data['lastName'] = $post['lName'];
		$data['loginId'] = $post['email'];
		$data['timezone'] = $post['timezone'];
		$algoencryptionObj = new Algoencryption();	
		if(!is_numeric($sess['userId']))
		{	
			$sess['userId']=$algoencryptionObj->decrypt($sess['userId']);
		}
		$userObj=Users::model()->findByPk($sess['userId']);
		if(isset($userObj->id) && $userObj->id != '')
		{
			$userObj->firstName = $data['firstName'];
			$userObj->lastName = $data['lastName'];
			$userObj->timezone = $data['timezone'];
			$userObj->save();
		}
		else
		{
			return array("status"=>-2,"message"=>"Invalid User Id.");	
		}

		$loginObj=Login::model()->findByPk($sess['loginId']);
		if(isset($loginObj->id) && $loginObj->id != '')
		{
			$loginObj->loginId = $data['loginId'];
			$res = $loginObj->save();
		}
		else
		{
			return array("status"=>-2,"message"=>"Invalid User Id.");	
		}
		return array("status"=>0,"message"=>"Successfully Updated.","result"=>$res);
		}
		else
		{
			return $res;
		}
	}
	
	
	function addPhone($data,$type=1,$sessionArray)
	{
		$userObj=new User();
		if($sessionArray['accountType']==1)
		{
			$total=$userObj->gettotalPhone($sessionArray['accountManagerId'],$sessionArray['accountType']);
			$totalUnverifiedPhone=$userObj->gettotalUnverifiedPhone($sessionArray['accountManagerId'],$sessionArray['accountType']);
		}
		else
		{
			$total=$userObj->gettotalPhone($sessionArray['seekerId'],$sessionArray['accountType']);
			$totalUnverifiedPhone=$userObj->gettotalUnverifiedPhone($sessionArray['seekerId'],$sessionArray['accountType']);
		}
		if($total > 1)
		{
			return array('status'=>$this->errorCode['_LIMIT_EXISTS_'],'message'=>$this->msg['_LIMIT_EXISTS_']);
		}
	
		
		if($totalUnverifiedPhone==1)
		{
			return array('status'=>$this->errorCode['_FIRST_VERIFY_PHONE_'],'message'=>$this->msg['_FIRST_VERIFY_PHONE_']);
		}
		
		$generalObj=new General();
		
		if($generalObj->validate_phoneUS($data['userphoneNumber']) && !$this->isExistPhone($data['userphoneNumber'],1,$sessionArray)) {
			$user = new User();
			
			if($sessionArray['userId']==NULL)
			{
				$password = rand(10,99).rand(10,99).rand(10,99).rand(10,99);
			}
			else
			{
				
				if($sessionArray['accountType']==1)
				{
					$password = $this->getPasswordByUserIdVer($sessionArray['accountManagerId']);
				}
				else
				{
					$password = $this->getPasswordByUserIdVer($sessionArray['seekerId']);
					
				}
				
			}
			
			$token=rand(10,99).rand(10,99).rand(10,99);
			
			$user = new User();
			$User_value['isVerified']=$token;
			$User_value['password']= $password;
			$User_value['accountType']= $type;
			$User_value['created']= date("Y-m-d H:i:s");
			$User_value['loginId'] = $data['userphoneNumber'];
			if($type==0)
			{
				$User_value['userId'] = $sessionArray['seekerId'];
			}
			else
			{
				$User_value['userId'] = $sessionArray['accountManagerId'];
			}	
			
			if(isset($sessionArray['prefferd_language']))
			{
					$User_value['prefferd_language'] = $this->getPrefferedLanguageCode($sessionArray['prefferd_language']);
			}
			$User_value['loginIdType'] ='1';
			if(isset($data['smsOk'])) {
				$User_value['smsOk'] = $data['smsOk'];
			} else {
				$User_value['smsOk']='0';
			}
			
			$this->setData($User_value);
			$user_id=$this->insertData();
			if($user_id) {
				
				$verify_smsObj = new VerifySms();
				$verify_smsObj->setVerifyCode($data['userphoneNumber'],$token,$user_id);
				if($type==1)
				{
					$generalObj = new General();
					$employerObj=new Employer();
					$account_manager = new AccountManagers();
					
					$businessName = $employerObj->getBusinessName($sessionArray['employerId']);
					$accountManagerName = $account_manager->getNameById($sessionArray['accountManagerId']);
					$smsBody = $this->msg['_ADD_ACC_MANAGER_PHONE_SMS_'];
					$smsBody = str_replace("_BUSINESS_NAME_",$generalObj->truncateBusinessName($businessName,20),$smsBody);
					$smsBody = str_replace("_TOKEN_",$token,$smsBody);
					$smsBody = str_replace("_ACCOUNT_MANAGER_",$generalObj->truncateName($accountManagerName,13),$smsBody);
					$outgoing_sms = new OutgoingSMS();
					$outgoing_sms->setOutgoingSMS($data['userphoneNumber'],$smsBody);
				}				
			}
			return array('status'=>'0','message'=>$this->msg['_PHONE_SUCCESS_']);
		} else {
			
			return array('status'=>$this->errorCode['_ENTER_VALID_PHONE_OR_ALREADY_EXIST_'],'message'=>$this->msg['_ENTER_VALID_PHONE_OR_ALREADY_EXIST_']);
			
		}
	
	}
	
	
	function getAllUsers()
	{
		$users = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->queryAll();
		return $users;
	}
	
	function contactUs($data,$mobile=0,$lng='eng')
	{		
		$recipients = $data['email'];							
		$email =$data['email'];							
		$name =$data['name'];
		$comment = htmlentities($data['comment']);
		$Yii = Yii::app();	
		
		$url=Yii::app()->params->base_path.'templatemaster/setTemplate/lng/'.$lng.'/file/contact-us-link';
		$message = file_get_contents($url);
		$message = str_replace("_BASEPATH_",BASE_PATH,$message);
		$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
		$message = str_replace("_NAME_",$name,$message);
		$message = str_replace("_COMMENT_",$comment,$message);
		$message = str_replace("_EMAIL_",$email,$message);
		
		$subject = $this->msg['CONTACT_US_SUCCESS'];
		$helperObj	=	new Helper();	
		$mailResponse=$helperObj->mailSetup($email,$subject,$message);
		if($mailResponse!=true) {	
			$msg= $mailResponse;
			return array('status'=>$this->errorCode['_USER_MAIL_ERROR_'],'message'=>$this->msg['_USER_MAIL_ERROR_']);
		} else {
		   return array('status'=>0,'message'=>$this->msg['CONTACT_US_SUCCESS']);
		}		
		
	}
	function activate($loginId,$mobile=0)
	{
		$loginObj	=	new Login();
		$result = $loginObj->getUserIdByLoginId($loginId);
		if(count($result) && $result!='')
		{
			if($result['isVerified']==1)
				{			
					$msgmsg=$this->msg['NAEMAIL_MSG'];
					$responceArray=array("status"=>$this->errorCode['NAEMAIL_MSG'],"message"=>$msgmsg);
					return $responceArray;	
				}
				else
				{
					$generalObj = new General();
					$algoObj = new Algoencryption();
					$everify_code=$generalObj->encrypt_password(rand(0,99).rand(0,99).rand(0,99).rand(0,99));
					$userArray=array();
					$userArray['isVerified']=$everify_code;
					$userArray['expiry']=time()+ACTIVATION_LINK_EXPIRY_TIME;
					$loginObj	=	new Login();					
					$loginObj->setData($userArray);
					$loginObj->insertData($result['id']);
					$emailLink = Yii::app()->params->base_path."site/verifyaccount/&key=".$everify_code.'&id='.$algoObj->encrypt($result['id']).'&lng=eng';	
					
					
					$url=Yii::app()->params->base_path.'templatemaster/setTemplate/&lng=eng&file='.$this->msg['_ET_ACCOUNT_ACTIVATION_LINK_TPL_'].'';
					$message = file_get_contents($url);
		
					$recipients = $loginId;							
					$email =$loginId;
					$subject = "Todooli account confirmation";	
					$message = str_replace("_BASEPATHLOGO_",Yii::app()->params->image_path,$message);
					
					if($mobile==1)
					{
						$message = str_replace("_BASEPATH_",BASE_PATH.'m/',$message);
					}
					else
					{
						$message = str_replace("_BASEPATH_",BASE_PATH,$message);
					}
					$message = str_replace("_USER_NAME_",$email,$message);
					$message = str_replace("_EMAIL_LINK_",$emailLink,$message);
					$message = str_replace("_USER_CONFIRMATION_VERIFY_LINK_",$this->msg['_USER_CONFIRMATION_VERIFY_LINK_'],$message);
					$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
					$helperObj	=	new Helper();
					$mailResponse=$helperObj->mailSetup($email,$subject,$message);
					
					if($mailResponse!=true) {
						
						$msg= $mailResponse;
						return array('status'=>$this->errorCode['_USER_MAIL_ERROR_'],"message"=>$this->msg['_USER_MAIL_ERROR_'].$msg);
					} 
					else
					{						
						return  array('status'=>0,"message"=>$this->msg['ACT_MSG']);
					}		
				}
		}
		else
		{
			$msgmsg=$this->msg['AEMAIL_MSG'];
			$responceArray=array("status"=>$this->errorCode['AEMAIL_MSG'],"message"=>$msgmsg);
			return $responceArray;	
		}
	}
	
	
	function forgot_password($loginId,$mobile=0,$lng='eng')
	{
		$generalObj=new General();
		if($generalObj->validate_phoneUS($loginId))
		{
			$loginId=$generalObj->clearPhone($loginId);
		}
			$loginObj	=	new Login();
			$id = $loginObj->getUserIdByLoginId($loginId);
		
			if($id>0)
			{
				
				$new_password = $this->genPassword();
				$userObj=Login::model()->findByPk($id['id']);
				$userObj->fpasswordConfirm=$new_password;	
				$res = $userObj->save();				
				
				if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$loginId)) 
				{
					
					$url=Yii::app()->params->base_path.'templatemaster/setTemplate&lng=eng&file='.$this->msg['_ET_FORGOT_PASSWORD_LINK_TPL_'].'';
					
					$message = file_get_contents($url);
					
					$recipients = $loginId;							
					$email =$loginId;
					$subject = $this->msg['FORGOT_PASSWORD_SUBJECT'];
					$message = str_replace("_BASEPATHLOGO_",Yii::app()->params->image_path,$message);
					
					if($mobile==1)
					{
						$message = str_replace("_BASEPATH_",BASE_PATH.'m',$message);
					}
					else
					{
						$message = str_replace("_BASEPATH_",Yii::app()->params->base_path,$message);
					}
					$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
					$message = str_replace("_PASSWORD_CODE_",$new_password,$message);
					
					$helperObj	=	new Helper();
					$mailResponse=$helperObj->mailSetup($email,$subject,$message);
					
					if($mailResponse!=true) {		
						$msg= $mailResponse;
						return array('status'=>$this->errorCode['_USER_MAIL_ERROR_'],"message"=>$this->msg['_USER_MAIL_ERROR_'].$msg);
					} 
					else
					{
						return  array('status'=>0,"message"=>$this->msg['NEW_PASS_MSG'],'token'=>$new_password);
					}
				} 
				else 
				{
					
					error_log("Forgot password message sending to ".$loginId);
					
					$twilio_helper = new TwilioHelper();		
					// Instantiate a new Twilio Rest Client
					$twilio = new Twilio();
					$client = new TwilioRestClient($twilio->AccountSid, $twilio->AuthToken);
					$message =$this->msg['_TEXT_TO_FORGOT_PASS_SMS_'];
					$response = $client->request("/$twilio->ApiVersion/Accounts/$twilio->AccountSid/SMS/Messages", 
						"POST", array(
						"To" => $loginId,
						"From" => SMS_NUMBER,
						"Body" => $message
						));
						
					if($response->IsError)
					{
						error_log("Forgot password message sent Error: {$response->ErrorMessage}");
						$message=$this->msg['FPASS_SEND_SMS_ERROR'];
						return array("status"=>$this->errorCode['FPASS_SEND_SMS_ERROR'],"message"=>$message);
					}
					else
					{			
						error_log("INFO Forgot password message sent successfully to ".$loginId);
						error_log("INFO SMS INFO:".$message);
						$message=$this->msg['FPASS_SEND_SMS_SUCCESS'];
						return array('status'=>'0',"message"=>$message,'token'=>$new_password);
					}
				}
				if($res == 1)
				{
					return array('status'=>0,"message"=>$this->msg['_PASSWORD_SUCCESSFULLY_MESSAGE_']);
				}
				else
				{
					return array('status'=>$this->errorCode['_PASSWORD_MESSAGE_'],"message"=>$this->msg['_PASSWORD_MESSAGE_']);	
				}
			}
			else
			{
				return array('status'=>$this->errorCode['EMAIL_PHONE_MSG'],"message"=>$this->msg['EMAIL_PHONE_MSG']);
			}
	}
	
	
	function genPassword()
	{
		$pass_char = array();
		$password = '';
		for($i=65 ; $i < 91 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=97 ; $i < 123 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=48 ; $i < 58 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=0 ; $i<8 ; $i++)
		{
			$password .= $pass_char[rand(0,61)];
		}
		return $password;
	}
	
	//reset password confirmation
	function resetpassword($data)
	{
		if($data['token']!='')
		{
			if(strlen($data['new_password'])>=6)
			{
				if($data['new_password']==$data['new_password_confirm'])
				{
					$generalObj = new General();
					$loginObj=new Login();
					$id=$loginObj->getIdByfpasswordConfirm($data['token']);
					if($id > 0)
					{
						$new_password =$generalObj->encrypt_password($data['new_password']);
						$User_field['password'] = $new_password;
						$User_field['fpasswordConfirm']= '1';
						$loginObj->setData($User_field);
						$loginObj->insertData($id['id']);
				
						return array("status"=>'0',"message"=>$this->msg['_PASSWORD_CHANGE_SUCCESS_']);						
					}
					else
					{
						return array('status'=>$this->errorCode['NO_USER_METCH'],"message"=>$this->msg['NO_USER_METCH']);
					}	
				}
				else
				{
					return array('status'=>$this->errorCode['_VALIDATE_PASS_CPASS_MATCH_'],'message'=>$this->msg['_VALIDATE_PASS_CPASS_MATCH_']);
				}
			}
			else
			{
				return array('status'=>$this->errorCode['_VALIDATE_PASSWORD_GT_6_'],"message"=>$this->msg['_VALIDATE_PASSWORD_GT_6_']);
			}
		}
		else
		{
			return array('status'=>$this->errorCode['VALIDATE_TOKEN'],"message"=>$this->msg['VALIDATE_TOKEN']);
		}
	}
	
	
	function uploadAvatar($_POST=array(),$_FILES=array(),$stat=NULL)
	{
		
	
		if(isset($_POST['userId']))
		{
			if(!is_numeric($_POST['userId']))
			{
				$algObj = new Algoencryption();					
				$_POST['userId'] = $algObj->decrypt($_POST['userId']);
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
		if($stat != NULL && $stat == "update")
		{
			
				if(isset($_POST['file_name']) && $_POST['file_name'] != "" && isset($_POST['userId']) && $_POST['userId']!='')
				{
					$this->setData(array('avatar'=>$_POST['file_name']));
					$this->insertData($_POST['userId']);
						
					//Deleting other file
					$algo=new Algoencryption();
					$newdir=$algo->encrypt("USER_".$_POST['userId']);
					
					$uploaddir = FILE_UPLOAD.'avatar/'.trim($newdir);
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
										
										if($file!=$_POST['file_name'])
										{
												unlink($filepath);
										}
									}
								}
							}
						}
					}
					$response_data['status']=0;
					$response_data['dir']=$newdir;
					$response_data['result']=$_POST['file_name'];
					$response_data['message']=$this->msg['_AVATAR_UPLOAD_'];
					return $response_data;
				}
				else
				{
					$response_data['status']=$this->errorCode['_INVALID_PARAMETERS_'];
					$response_data['message']=$this->msg['_INVALID_PARAMETERS_'];
					$response_data['result']='';
					return $response_data;
				}
			
		}
		else
		{
		
        if(isset($_FILES['avatar']))
        {
            $uploaddir = FILE_UPLOAD.'avatar/';
			$extArray=unserialize(IMAGE_EXT);
			$filedata=explode('.',$_FILES['avatar']['name']);
           
			$fileext=$filedata[count($filedata)-1];
			
			if(in_array($fileext,$extArray))
			{
				
				//create new dir
				$algo=new Algoencryption();	
				$newdir=$algo->encrypt("USER_".$_POST['userId']);
				if(!is_dir($uploaddir.$newdir))
				{
					
					$oldmask = umask(0);
					mkdir($uploaddir.$newdir,0777);
					umask($oldmask);
					
					
				}
				
				//checking if file name is exist or not
				$filename=md5(rand()).'.'.$fileext;
				$file = $uploaddir.$newdir.'/'.$filename;
				while(file_exists($file))
				{
					$filename=md5(rand()).'.'.$fileext;
					$file = $uploaddir.$newdir.'/'.$filename;
				}
				if (move_uploaded_file($_FILES['avatar']['tmp_name'], $file))
				{
					chmod($file, 0777);
					list($width,$height) = getimagesize($file);
					if($width > 90 || $height > 90)
					{
						$generalObj=new General();
						$generalObj->resizeImage($file, $file, 90, 90);
					}
					
					$response_data['status']=0;
					$response_data['result']=$filename;
					$response_data['dir']=$newdir;
					$response_data['message']='Success';
					return $response_data;
				}
				else
				{
					$response_data['status']=$this->errorCode['_INVALID_PARAMETERS_'];
					$response_data['message']=$this->msg['_FILE_UPLOAD_ERROR_'];
					$response_data['result']=$this->msg['_FILE_UPLOAD_ERROR_'];
					return $response_data;
				}
			}
			else
			{
				
				$response_data['status']=$this->errorCode['_INVALID_EXTENSION_'];
				$response_data['message']=$this->msg['_INVALID_EXTENSION_'];
				$response_data['result']=$this->msg['_INVALID_EXTENSION_'];
				return $response_data;
			}
        }
		}
		
	}
	
	function uploadAttachment($_POST=array(),$_FILES=array(),$stat=NULL)
	{
		
		if(isset($_POST['userId']))
		{
				$_POST['userId']=$_POST['userId'];
		}
		if(isset($_POST['userId']))
		{
			if(!is_numeric($_POST['userId']))
			{
				$algObj = new Algoencryption();					
				$_POST['userId'] = $algObj->decrypt($_POST['userId']);
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
		if($stat != NULL && $stat == "update")
		{
			
				if(isset($_POST['file_name']) && $_POST['file_name'] != "" && isset($_POST['userId']) && $_POST['userId']!='')
				{
					$this->setData(array('avatar'=>$_POST['file_name']));
					$this->insertData($_POST['userId']);
						
					//Deleting other file
					$algo=new Algoencryption();
					$newdir=$algo->encrypt("USER_".$_POST['userId']);
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
										
										if($file!=$_POST['file_name'])
										{
												unlink($filepath);
										}
									}
								}
							}
						}
					}
					//$response_data['status']=0;
					//$response_data['dir']=$newdir;
					$response_data['result']=$_POST['file_name'];
					//$response_data['message']='Attachment uploaded successfully';
					return $_POST['file_name'];
				}
				else
				{
					$response_data['status']=$this->errorCode['_INVALID_PARAMETERS_'];
					$response_data['message']=$this->msg['_INVALID_PARAMETERS_'];
					$response_data['result']='';
					return 0;
				}
			
		}
		else
		{
		
        if(isset($_FILES['attachmentFile']))
        {
            $uploaddir = FILE_UPLOAD.'attachment/';
			$extArray=unserialize(FILE_NOT_EXT);
			$filedata=explode('.',$_FILES['attachmentFile']['name']);
            $fileext=$filedata[count($filedata)-1];
			if(!in_array($fileext,$extArray))
			{
				
				//create new dir
				$algo=new Algoencryption();	
				$newdir=$algo->encrypt("USER_".$_POST['userId']);
				if(!is_dir($uploaddir.$newdir))
				{
					
					$oldmask = umask(0);
					mkdir($uploaddir.$newdir,0777);
					umask($oldmask);
					
					
				}
				
				//checking if file name is exist or not
				$filename=md5(rand()).'.'.$fileext;
				$file = $uploaddir.$newdir.'/'.$filename;
				while(file_exists($file))
				{
					$filename=md5(rand()).'.'.$fileext;
					$file = $uploaddir.$newdir.'/'.$filename;
				}
				if (move_uploaded_file($_FILES['attachmentFile']['tmp_name'], $file))
				{
						$response_data['status']=0;
						$response_data['message']=$filename;
						$response_data['result']=$filename;
						return $response_data;
				}
				else
				{
						$response_data['status']=40;
						$response_data['message']=PHP_EOL;
						$response_data['result']='';
					return  $response_data;
				}
			}
			else
			{
				$response_data['status']=$this->errorCode['_INVALID_EXTENSION_'];
				$response_data['message']=$this->msg['_INVALID_EXTENSION_'];
				$response_data['result']='';
				return $response_data;
			}
        }
		}
		
	}
	
	function changePassword($data = array())
	{
		if(!empty($data))
		{
			if($data['newpassword']=='' || strlen($data['newpassword'])<6)
			{
				return array(false,Yii::app()->params->msg['_PASSWORD_LENGTH_ERROR_'],68);
			}
			if($data['newpassword']!=$data['confirmpassword'])
			{
				return array(false,Yii::app()->params->msg['_BOTH_PASSWORD_NOT_METCH_'],70);
			}
			if($data['oldpassword']==$data['newpassword'])
			{
				return array(false,Yii::app()->params->msg['_OLD_NEW_PASSWORD_SAME_'],114);
			}
			
			if(!is_numeric($data['userId'])){
				$algoencryptionObj	=	new Algoencryption();
				$data['userId']	=	$algoencryptionObj->decrypt($data['userId']);
			}
			$res = $this->getUserDetail($data['userId']);
			$userData = $res['result'];
			$generalObj = new General();
			
			if($generalObj->validate_password($data['oldpassword'],$userData['password']))
			{
				$res = true;
			}
			else
			{
				$res = false;
			}
			if($res==true)
			{
				
				$login=Login::model()->findbyPk($data['userId']);
				$password = $generalObj->encrypt_password($data['newpassword']);
				$arr = array();
				$arr['password'] = $password;
				$login->setData($arr);
				$login->insertData($data['userId']);
				return array(true,Yii::app()->params->msg['_PASSWORD_CHANGE_SUCCESS_'],0);
			}
			else
			{
				return array(false,Yii::app()->params->msg['_OLD_PASSWORD_NOT_METCH_'],69);
			}
		}
	}
	
	function updateSocialLink($data)
	{
		
		if(isset($data['link_value']))
			{
				$data['link_value']=trim($data['link_value']);
				$data['link_name']=trim($data['link_name']);
				
				$linkType=array("linkedinLink","facebookLink","twitterLink");
				if(!in_array($data['link_name'],$linkType))
				{
					$result['status'] = $this->errorCode['_LINK_NAME_NOT_FOUND_'];
					$result['message'] = $this->msg['_LINK_NAME_NOT_FOUND_'];
					return $result;	
				}
				if($data['link_value']=='')
				{
					$employer_data[$data['link_name']] = $data['link_value'];
					$userObj=Users::model()->findbyPk($data['id']);
					$userObj->$data['link_name'] = $data['link_value'];
					$res =  $userObj->save($data['id']);
					if($res==true)
					{
						$result['status'] = 0;
						$result['message'] = 'success';
					}
					else
					{
						$result['status'] = $this->errorCode['_LINK_FAIL_'];
						$result['message'] = $this->msg['_LINK_FAIL_'];
					}
					return $result;
				}
				else
				{
					
					$general = new General();
					if($general->isValidURL($data['link_value']))
					{	
						$rest = substr($data['link_name'], 0, -4);
						$link_value=strtolower($data['link_value']);
						$msg='';
						switch($rest)
						{
							case "linkedin":								
											if(strstr($link_value,'//www.linkedin.com/') || strstr($link_value,'//linkedin.com/'))
											{
												$msg='';
											}
											else
											{
												$msg=$this->msg['_LINK_NOT_VALID_']." ".ucfirst($data['link_name']);	
											}
											break;
							case "facebook":
											if(strstr($link_value,'//facebook.com/') || strstr($link_value,'//www.facebook.com/'))
											{
													$msg='';
											}
											else
											{
												$msg=$this->msg['_LINK_NOT_VALID_']." ".ucfirst($data['link_name']);
											}
											break;
							case "twitter":									
											if(strstr($link_value,'//twitter.com/') || strstr($link_value,'//www.twitter.com/'))
											{
												$msg='';	
											}
											else
											{
												$msg=$this->msg['_LINK_NOT_VALID_']." ".ucfirst($data['link_name']);
											}
											break;
							default:
										$msg="Link name not found.";	
										break;			
						}
						if($msg=='')
						{
							$employer_data = array();
							$employer_data[$data['link_name']] = $data['link_value'];
							$userObj=Users::model()->findbyPk($data['id']);
							$userObj->$data['link_name'] = $data['link_value'];
							$res =  $userObj->save($data['id']);
							if($res==true)
							{
							$result['status'] = 0;
							$result['message'] = ucfirst($data['link_name'])." ".$this->msg['_LINK_UPDATE_SUCCESS_'];
							}
							else
							{
								
								$result['status']=$this->errorCode['_LINK_FAIL_'];
								$result['message']=$this->msg['_LINK_FAIL_'];
							}
							return $result;
						}
						else
						{
							
							$result['status'] = $this->errorCode['_LINK_NAME_NOT_FOUND_'];
							$result['message'] = $this->msg['_LINK_NAME_NOT_FOUND_'];
							return $result;
						}
					}
					else
					{
						
						$result['status'] = $this->errorCode['_LINK_NOT_VALID_'];
						$result['message'] =$this->msg['_LINK_NOT_VALID_']." ".ucfirst($data['link_name']);
						return $result;
					}					
				}
		   
        	}
	}
	
	function gettotalPhone($userid,$type=0)
	{			
		$result = Yii::app()->db->createCommand()
		->select("id")
		->from($this->tableName())
		->where('userId=:userId and status=:status', array(':userId'=>$userid,':status'=>1))
		->queryAll();
			
		return count($result);
	}
	
	function getTimeZone($id)
	{
		$result = Yii::app()->db->createCommand()
		->select("timezone")
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryScalar();
		return $result;
	}
	
	function deleteById($id,$reason='')
	{
		$res=$this->getUserDetail($id);
		$data = $res['result'];
		if(!empty($data))
		{
			
				if($data['loginIdType']==1)
				{
					$login = new Login();
					$totalPhoneId = $login->getTotalLoginByUserId($data['id'],$data['loginIdType'],1);
					$user = new Users();
					$isVerifiedEmailId = $login->getTotalAccountByloginIdType($data['id'],$data['loginIdType'],0);error_log("delete 4");
					if($totalPhoneId==1 && $isVerifiedEmailId==0)
					{
						return array($this->errorCode['_PHONE_CANT_DELETED_'],$this->msg['_PHONE_CANT_DELETED_']);
					}
					
				}
			$login = new Login();
			$totalAccount=$login->getTotalLoginByUserId($data['id'],$data['loginIdType']);
			if($totalAccount < 2)
			{
				$userId=$data['id'];
				$this->deleteUserAcount($userId,$data['loginIdType']);
			}
			else
			{	
				$post=Login::model()->findByPk($id);
				if(is_object($post))
				{
					$post->delete();
				}
				
			}
		}
		if(isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']==$id)
		{
			Yii::app()->session->destroy();
			return array($this->errorCode['SESSION_EXPIRE'],"logout");
			exit;
		}
		return array(0,'success');
	}
	
	function getVerifyCodeById($id)
	{
		$generalObj=new General();
		$res=$this->getUserDetail($id);
		$result = $res['result'];
		if(empty($result))
		{
			return array('status'=>$this->errorCode['ACCOUNT_NOT_AVAILABLE'],'message'=>$this->msg['ACCOUNT_NOT_AVAILABLE']);
		}
		else if($result['isVerified']==1)
		{
			return array('status'=>$this->errorCode['ACCOUNT_NOT_AVAILABLE'],'message'=>$this->msg['ACCOUNT_ALREADY_VERIFIED']);
		}
		else
		{
			$message = str_replace("_TOKEN_", $result['isVerified'] ,$this->msg['SMS_TOKEN_MSG']);
			return array('status'=>0,'message'=>$message);
		}	
	}
	
	function changeShowStatus($userId=NULL, $data)
	{
		if( isset($userId) ) {
			$userArray[$data['field']]	=	$data['status'];
			$this->setData($userArray);
			$this->insertData($userId);
			return array('status'=>0,'message'=>'success');
		}
	}
	
	function showAll($userId)
	{
		if( isset($userId) ) {
			$status['myOpenStatus']	=	'1';
			$status['myDoneStatus']	=	'0';
			$status['myCloseStatus']	=	'0';
			
			$status['byMeOpenStatus']	=	'1';
			$status['byMeDoneStatus']	=	'0';
			$status['byMeCloseStatus']	=	'0';
			
			$status['otherOpenStatus']	=	'1';
			$status['otherDoneStatus']	=	'0';
			$status['otherCloseStatus']	=	'0';
			
			$this->setData($status);
			$this->insertData($userId);
			return array('status'=>0, 'message'=>'success');
		} else {
			return array('status'=>$this->errorCode['MISSING_PARAMETER'], 'message'=>$this->msg['MISSING_PARAMETER']);
		}
	}
	
	function mobilechangeShowStatus($userId=NULL, $data)
	{
		if( isset($userId) ) {
			$this->setData($data);
			$this->insertData($userId);
			return array('status'=>0,'message'=>'success');
		}
	}
	
	
}