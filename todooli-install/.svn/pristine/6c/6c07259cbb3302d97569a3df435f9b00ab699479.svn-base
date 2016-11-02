<?php

/**
 * This is the model class for table "login".
 *
 * The followings are the available columns in table 'login':
 * @property integer $id
 * @property string $isVerified
 * @property string $status
 * @property string $smsOk
 * @property string $created
 * @property string $modified
 * @property string $loginId
 * @property string $loginIdType
 * @property string $password
 * @property integer $userId
 */
class Login extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Login the static model class
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
		return 'login';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('isVerified, created, modified, loginId, password, userId', 'required'),
			//array('userId', 'numerical', 'integerOnly'=>true),
			//array('isVerified, loginId', 'length', 'max'=>100),
			//array('status, smsOk, loginIdType', 'length', 'max'=>1),
			//array('password', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, isVerified, status, smsOk, created, modified, loginId, loginIdType, password, userId', 'safe', 'on'=>'search'),
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
			'isVerified' => 'Is Verified',
			'status' => 'Status',
			'smsOk' => 'Sms Ok',
			'created' => 'Created',
			'modified' => 'Modified',
			'loginId' => 'Login',
			'loginIdType' => 'Login Id Type',
			'password' => 'Password',
			'userId' => 'User',
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
		$criteria->compare('isVerified',$this->isVerified,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('smsOk',$this->smsOk,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('loginId',$this->loginId,true);
		$criteria->compare('loginIdType',$this->loginIdType,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('userId',$this->userId);

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
	DESCRIPTION : CHECK OTHER SAME EMAIL EXISTS OR NOT
	*/
	function checkOtherEmail($email,$chkUserId='-1',$type=NULL)
	{
		$condition='loginId=:loginId';
		$params=array(':loginId'=>$email);
		if ($chkUserId != -1) {
			$condition.=' and userId!=:userId';
			$params[':userId']=$chkUserId;
        }
		
		$result = Yii::app()->db->createCommand()
		->select('loginId')
		->from($this->tableName())
		->where($condition,$params)
		->order('id asc')
		->queryScalar();
	
		return $result;
	}
	
	function getUserIdByLoginId($loginId, $fields='*')
	{
		$result = Yii::app()->db->createCommand()
		->select($fields)
		->from($this->tableName())
		->where('loginId=:loginId', array(':loginId'=>$loginId))
		->queryRow();
		
		return $result;
	}
	
	//GET PHONE NUMBER FROM ADMIN
	function getPhoneById($id=NULL, $verified=NULL)
	{
		$condition	=	'id=:id and loginIdType=:loginIdType';
		$params	=	array(':id'=>$id,':loginIdType'=>1);
		
		if(isset($verified)){
			$condition	.=	' and isVerified=:isVerified';
			$params[':isVerified']	=	1;
		}
		
		$incoming_sms_sender	=	Yii::app()->db->createCommand()
									->select("loginId")
									->from($this->tablename())
									->where($condition, $params)
									->queryScalar();
		return $incoming_sms_sender;
	}
	
	function veriryUser($data,$id)
	{
		$this->setData($data);
		return $this->insertData($id);
	}
	
	
	function getLoginIdById($id)
	{
		$result = Yii::app()->db->createCommand()
		->select('loginId')
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryScalar();
		
		return $result;
	}
	
	function getLoginDetailsById($id,$fields="*")
	{
		$result = Yii::app()->db->createCommand()
		->select($fields)
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryRow();
		
		return $result;
	}
	
	
	/*
	DESCRIPTION : GET VERIFIED USER
	*/
	function getVerifiedUser($loginId)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('loginId=:loginId and isVerified=:isVerified',
							 array(':loginId'=>$loginId,':isVerified'=>'1'))	
					->queryAll();
		
		return $result;
	}
	
	
	/*
	DESCRIPTION : GET USER ID
	*/
	public function getUserId($id=NULL)
	{
		$result = Yii::app()->db->createCommand()
    	->select('userId,status,loginId,password,isVerified,loginIdType,last_todoassign,last_listId,last_priority,last_duedate')
    	->from($this->tableName())
   	 	->where('id=:id', array(':id'=>$id))	
   	 	->queryRow();
		
		return $result;
	}
	
	function getIdByfpasswordConfirm($token)
	{
		$result = Yii::app()->db->createCommand()
		->select('id')
		->from($this->tableName())
		->where('fpasswordConfirm=:fpasswordConfirm', array(':fpasswordConfirm'=>$token))
		->queryRow();
		return $result;
	}
	/*
	DESCRIPTION : GET USER BY ID
	PARAMS : $userId -> USER ID,
			 $verified -> VERIFIED PHONES (1), UNVERIFIED PHONE (0) AND ALL PHONES (NULL)
	*/
	public function getUserPhonesById($userId, $verified=NULL)
	{
		
		$condition	=	'userId=:userId and loginIdType=:loginIdType';
		$params	=	array(':userId'=>$userId, ':loginIdType'=>1);
		if(isset($verified))
		{
			$condition.=' and isVerified=:isVerified';
			$params['isVerified']	=	$verified;
		}
		else
		{
			$condition.=' and isVerified!=:isVerified';
			$params['isVerified']	=	1;
		}
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where($condition, $params)
					->queryRow();
		
		
		return $result;
	}
	
	public function getVerifiedEmailById($id=NULL)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('loginId')
					->from($this->tableName())
					->where('id=:id and isVerified=:isVerified and loginIdType=:loginIdType', array(':id'=>$id, ':isVerified'=>1, ':loginIdType'=>0))
					->queryScalar();
		
		return $result;
	}
	
	/*
	DESCRIPTION : GET USER BY ID
	*/
	public function getUserByEmail($email=NULL)
	{
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->where('loginId=:loginId', array(':loginId'=>$email))	
   	 	->queryRow();
		
		return $result;
	}
	
	function chkemail($email,$chkUserId='-1')
	{		
		$condition='loginId=:loginId';
		$params=array(':loginId'=>$email);
		if ($chkUserId != -1) {
			$condition.=' and id!=:id';
			$params[':id']=$chkUserId;
        }
		
		$loginObj	=	new Login();
		$result	=	Yii::app()->db->createCommand()
					->select('loginId')
					->from($this->tableName())
					->where($condition,$params)
					->order('id asc')
					->queryScalar();
		
		return $result;
	}	
	
	/*
	DESCRIPTION : CHANGE PASWORD FUNCTION
	PARAMS : $data -> POST DATA
	*/
	public function changesPassword($data = array())
	{
		if(!empty($data))
		{
			if($data['new_password']=='' || strlen($data['new_password'])<6)
			{
				return array(false,Yii::app()->params->msg['_PASSWORD_LENGTH_ERROR_'],68);
			}
			if($data['new_password']!=$data['c_password'])
			{
				return array(false,Yii::app()->params->msg['_BOTH_PASSWORD_NOT_METCH_'],70);
			}
			if($data['old_password']==$data['new_password'])
			{
				return array(false,Yii::app()->params->msg['_OLD_NEW_PASSWORD_SAME_'],114);
			}
			
			if(!is_numeric($data['user_id'])){
				$algoencryptionObj	=	new Algoencryption();
				$data['user_id']	=	$algoencryptionObj->decrypt($data['user_id']);
			}
			$userData = $this->getUserById($data['user_id'],'userId,password');
			$generalObj = new General();
			$res = $generalObj->validate_password($data['old_password'],$userData['password']);
					
			if($res==true)
			{
				
				$user_data["password"] = $generalObj->encrypt_password($data['new_password']);	
				$this->setData(array('password'=>$user_data['password']));
				$this->insertData($data['user_id']);
				
				return array(true,Yii::app()->params->msg['_PASSWORD_CHANGE_SUCCESS_'],0);
				
			}
			else
			{
				return array(false,Yii::app()->params->msg['_OLD_PASSWORD_NOT_METCH_'],69);
			}
		}
	}
	
	
	function verifyaccount($key,$id,$by='WEB')
	{
		if(!is_numeric($id))
		{
			$algoObj= new Algoencryption();
			$pid=$algoObj->decrypt($id);
		}
		else
		{
			$pid=$id;
		}
		//print_r($pid);
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('id=:id', array(':id'=>$pid))
					->queryRow();
		
		if(!empty($result))
		{
			if(time() > $result['expiry'] )
			{
				//exit('4');
				return 4;
			}
			else if($result['isVerified'] == '1')
			{
		 		//exit('2');
				return 2;
			}
			else if($result['isVerified'] == $key)
			{
				$modifieddate= date('Y-m-d H:i:s');
				$UserArray['isVerified']='1';
				$UserArray['modified']=$modifieddate;
				
				$this->setData($UserArray);
				$this->insertData($result['id']);
				
				//exit('1');
				return 1;
			}
			else
			{	
				//exit('3');
				return 3;
			}
		}
		else
		{		
			return 3;
		}
	}
	
	public function checkNetworkUser($user,$networkuser)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from('todonetwork')
					->where('userId=:userId and networkId=:networkId', array(':userId'=>$user,':networkId'=>$networkuser))
					->queryRow();
		return  $result;
	}
	
	function getVerifyCode($phone,$type=0)
	{
		$generalObj=new General();
		$phone=$generalObj->clearPhone($phone);
		$result=$this->getUserDetailByLoginId($phone,'-1',$type);
		if(empty($result) || $result == '')
		{
			return array('false',$this->msg['ACCOUNT_NOT_AVAILABLE']);
		}
		else if($result[0]['isVerified']==1)
		{
			return array('false',$this->msg['ACCOUNT_ALREADY_VERIFIED']);
		}
		else
		{
			$message = str_replace("_TOKEN_", $result[0]['isVerified'] ,$this->msg['SMS_TOKEN_MSG']);
			return array('true',$message);
		}	
	}
	
	function getUserDetailByLoginId($loginId,$isVerified='-1',$type='-1')
	{
		try{
		$condition = "loginId=:loginId";
		$params[':loginId'] = $loginId;
		if($isVerified!='-1')
		{
			$condition .= " and isVerified=:isVerified";
			$params[':isVerified'] = 1;
		}
		if($type!='-1')
		{
			
			$condition .= " and accountType=:accountType";
			$params[':accountType'] = $type;
		}
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->where($condition,$params)
  	 	->queryAll();
		} catch (Exception $e) {
            error_log('Exception caught: ' . $e->getMessage());
        }
		return $result;
	}
	
	public function isExistPhone($phone_number,$isVerified=NULL,$sessionArray=array())
	{
		
		if($isVerified==NULL && empty($sessionArray))
		{
			return false;	
		}
		
		$condition='loginId=:loginId and ';
		$params=array(':loginId'=>$phone_number);
		if ($isVerified != NULL) {
			
			if(!empty($sessionArray))
			{
				
					$condition.='userId=:userId';
					
					$params[':userId']=$sessionArray['userId'];
				
			}
			else
			{
				
				$condition.=' and isVerified=:isVerified';
				$params[':isVerified']=1;
			}
        }
		$result = Yii::app()->db->createCommand()
		->select('loginId')
		->from($this->tableName())
		->where($condition,$params)
		->queryScalar();
		
		if($result)
		{
			return true;
		}
		return false;
	}
	
	function gettotalVerifiedPhone($userid,$type=0)
	{
		$result = Yii::app()->db->createCommand()
    					->select("id")
						->from($this->tableName())
						->where('userId=:userId  and loginIdType=:loginIdType and isVerified=:isVerified and status=:status', array(':userId'=>$userid,':loginIdType'=>1,':isVerified'=>1,':status'=>1))
						->queryAll();
		
		return count($result);
	}
	
	
	function gettotalPhone($userid,$type=0)
	{			
		$result = Yii::app()->db->createCommand()
		->select("id")
		->from($this->tableName())
		->where('userId=:userId and loginIdType=:loginIdType', array(':userId'=>$userid,':loginIdType'=>1))
		->queryAll();
			
		return count($result);
	}
	
	function gettotalUnverifiedPhone($userid,$type=0)
	{		
		$condition='userId=:userId and isVerified!=:isVerified and status=:status';
		$params=array(':userId'=>$userid,':isVerified'=>1,':status'=>1);
		$result = Yii::app()->db->createCommand()
		->select('id')
		->from($this->tableName())
		->where($condition,$params)
		->order('id asc')
		->queryAll();
		
		return count($result);
	}
	
	function addPhone($data,$type=1,$sessionArray)
	{
		
		$loginObj=new Login();
		
		
			$total=$this->gettotalPhone($sessionArray['userId']);
			$totalUnverifiedPhone=$this->gettotalUnverifiedPhone($sessionArray['userId']);
	
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
			$user = new Users();
			
			if($sessionArray['userId']==NULL)
			{
				$password = rand(10,99).rand(10,99).rand(10,99).rand(10,99);
			}
			else
			{
				$password = $this->getPasswordByUserIdVer($sessionArray['userId']);
			}
			
			$token=rand(10,99).rand(10,99).rand(10,99);
			
			$user = new Users();
			$User_value['isVerified']=$token;
			$User_value['password']= $password;
			$User_value['created']= date("Y-m-d H:i:s");
			$User_value['loginId'] = $data['userphoneNumber'];
			$User_value['userId'] = $sessionArray['userId'];
			$User_value['loginIdType'] ='1';
			if(isset($data['smsOk'])) {
				$User_value['smsOk'] = $data['smsOk'];
			} else {
				$User_value['smsOk']='0';
			}
			$loginObj = new Login();
			$loginObj->setData($User_value);
			$user_id=$loginObj->insertData();
			
			if($user_id) {
				
				//$verify_smsObj = new VerifySms();
				//$verify_smsObj->setVerifyCode($data['userphoneNumber'],$token,$user_id);
				if($type==1)
				{
					/*$generalObj = new General();
					$employerObj=new Employer();
					$account_manager = new AccountManagers();
					
					$businessName = $employerObj->getBusinessName($sessionArray['employerId']);
					$accountManagerName = $account_manager->getNameById($sessionArray['accountManagerId']);
					$smsBody = $this->msg['_ADD_ACC_MANAGER_PHONE_SMS_'];
					$smsBody = str_replace("_BUSINESS_NAME_",$generalObj->truncateBusinessName($businessName,20),$smsBody);
					$smsBody = str_replace("_TOKEN_",$token,$smsBody);
					$smsBody = str_replace("_ACCOUNT_MANAGER_",$generalObj->truncateName($accountManagerName,13),$smsBody);
					$outgoing_sms = new OutgoingSMS();
					$outgoing_sms->setOutgoingSMS($data['userphoneNumber'],$smsBody);*/
				}				
			}
			return array('status'=>'0','message'=>$this->msg['_PHONE_SUCCESS_']);
		} else {
			
			return array('status'=>$this->errorCode['_ENTER_VALID_PHONE_OR_ALREADY_EXIST_'],'message'=>$this->msg['_ENTER_VALID_PHONE_OR_ALREADY_EXIST_']);
			
		}
	
	}
	
	function getPasswordByUserIdVer($id)
	{
		
		$result = Yii::app()->db->createCommand()
		->select("password")
		->from($this->tableName())
		->where('userId=:userId', array(':userId'=>$id))
		->queryScalar();
		
		return $result;
	}
	
	function getPhones($userId,$acc_type,$isVerified=NULL)
	{	
		$ver=0;
		if($isVerified!=NULL)
		{
			$ver=1;
			$result = Yii::app()->db->createCommand()
				->select("loginId,isVerified,id")
				->from($this->tableName())
				->where('userId=:userId and loginIdType=:loginIdType and isVerified=:isVerified and status=:status', array(':userId'=>$userId,'loginIdType'=>'1',':isVerified'=>'1',':status'=>'1'))
				->order('id asc')
				->queryAll();
		}else{
			$result = Yii::app()->db->createCommand()
				->select("loginId,isVerified,id")
				->from($this->tableName())
				->where('userId=:userId and loginIdType=:loginIdType and status=:status', array(':userId'=>$userId,'loginIdType'=>'1',':status'=>'1'))
				->order('id asc')
				->queryAll();
		}
		if(!empty($result)){
			$algoencryptionObj	=	new Algoencryption();
			for($i=0; $i<count($result); $i++){
				$result[$i]['encryptedId']	=	$algoencryptionObj->encrypt($result[$i]['id']);
			}
		}
		return $result;
	}
	
	function isVerifiedPhone($type,$loginid,$userId)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('loginId')
					->from($this->tableName())
					->where('userId=:userId  and loginIdType=:loginIdType and
							 isVerified=:isVerified and status=:status and loginId=:loginId',
							 array(':userId'=>$userId, ':loginIdType'=>'1',
							 		 ':isVerified'=>'1',':status'=>'1',':loginId'=>$loginid))
					->queryScalar();
		
		if(count($result)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function deleteById($id,$reason='')
	{
		$userObj = new Users();
		$data=$userObj->getUserDetail($id);
		$data = $data['result'];
		$result = $this->getBothUserAccount($data['id']);
		$todoLists =  new TodoLists();
		$lists = $todoLists->getUserToDoList($id);
		
		$toDoListObj =  new TodoLists();
		$res = $toDoListObj->deleteToDoList($id);
		
		$toDoItemObj =  new TodoItems();
		$toDoItemObj->deleteItemsByListId($id);
			
		$toDoNetworkObj =  new Todonetwork();
		$toDoNetworkObj->deleteNetworkByListId($id);
			
		$reminderObj =  new Reminder();
		$reminderObj->deleteReminderByListId($id);
			
		$invitesObj =  new Invites();
		$invitesObj->deleteInvitesByListId($id);
			
		$commentsObj =  new Comments();
		$commentsObj->deleteCommentsByListId($id);
			
		$attachmentsObj =  new Attachments();
		$attachmentsObj->deleteAttachmentsByListId($id);
		
		$userObj=Users::model()->findbyPk($data['id']);
		$userObj->delete();
		
		for($i=0;$i<count($result);$i++)
		{
			$loginObj=Login::model()->findbyPk($result[$i]['id']);
			$loginObj->delete();
		}
		
		return array(0,'success');
	}
	
	function getBothUserAccount($id)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('userId=:userId',
							 array(':userId'=>$id))
					->queryAll();
		return $result;
	}
	
	function getTotalLoginByUserId($userId,$actype,$loginIdType=-1)
	{		
		$condition='userId=:userId';
		$params=array(':userId'=>$userId);
		if ($loginIdType != -1) {
			$condition.=' and loginIdType=:loginIdType';
			$params[':loginIdType']=$loginIdType;
        }
		$result = Yii::app()->db->createCommand()
		->select('id')
		->from($this->tableName())
		->where($condition,$params)
		->queryAll();
		
		return count($result);	
	}
	
	function getTotalAccountByloginIdType($userId,$actype,$loginIdType)
	{
		$emailId = Yii::app()->db->createCommand()
		->select("id,loginId")
		->from($this->tableName())
		->where('loginIdType=:loginIdType and userId=:userId and isVerified=:isVerified', array(':loginIdType'=>$loginIdType,':userId'=>$userId,':isVerified'=>1))
		->queryRow();
		
		return count($emailId);
	}
	
	function getUserIdByid($loginId=NULL)
	{
		$userId	=	Yii::app()->db->createCommand()
					->select('userId')
					->from($this->tableName())
					->where('id=:id', array(':id'=>$loginId))
					->queryScalar();
					
		return $userId;
	}
		
	
}