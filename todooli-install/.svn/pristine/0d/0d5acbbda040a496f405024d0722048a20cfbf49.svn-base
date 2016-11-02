<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property string $id
 * @property string $userId
 * @property string $listId
 * @property string $itemId
 * @property string $parentCommentId
 * @property string $commentText
 * @property string $attachmentIds
 * @property string $createdAt
 * @property string $modifiedAt
 */
class Comments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('userId, listId, itemId, parentCommentId, commentText, attachmentIds, createdAt, modifiedAt', 'required'),
			//array('userId, listId, itemId, parentCommentId', 'length', 'max'=>20),
			///array('attachmentIds', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, userId, listId, itemId, parentCommentId, commentText, attachmentIds, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'userId' => 'User',
			'listId' => 'List',
			'itemId' => 'Item',
			'parentCommentId' => 'Parent Comment',
			'commentText' => 'Comment Text',
			'attachmentIds' => 'Attachment Ids',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
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
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('listId',$this->listId,true);
		$criteria->compare('itemId',$this->itemId,true);
		$criteria->compare('parentCommentId',$this->parentCommentId,true);
		$criteria->compare('commentText',$this->commentText,true);
		$criteria->compare('attachmentIds',$this->attachmentIds,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);

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
	DESCRIPTION : GET ALL COMMENTS WITH PAGINATION
	*/
	public function getAllPaginatedComments()
	{
 		$criteria = new CDbCriteria();
		
		$comment_data=new CActiveDataProvider($this,array(
			'criteria'=>$criteria,
		 	'pagination'=>array(
		        'pageSize'=>10,
			),
		));
		
		$index  =   0;
		$comments	=	array();
		foreach($comment_data->getData() as $commentData){
				$userObj = new Users();
				$data = $userObj->getUserDetail($commentData->attributes['userId']);
				$data = $data['result'];
				$result = $commentData->attributes;
				$result['firstName'] = $data['firstName'];
				$result['lastName'] = $data['lastName'];
				$comments[$index] =   $result;
				$index++;
		}
		return array('pagination'=>$comment_data->pagination, 'comments'=>$comments);
	}
	
	/*
	DESCRIPTION : ADD TODO ITEM COMMENT FUNCTION
	*/
	public function addItemComments($postData=array(), $sessionArray=array())
	{
		$validationObj	=	new Validation();
		$todoItemsObj	=	new TodoItems();
		$usersObj	=	new Users();
		$todoListObj	=	new TodoLists();
		$algoencryptionObj	=	new Algoencryption();
		
		if(isset($postData['itemId']) && !is_numeric($postData['itemId']))
		{
			$postData['itemId']=$algoencryptionObj->decrypt($postData['itemId']);				
		}
		$result	=	$validationObj->addItemComments($postData);
		
		if( $result['status'] != 0 ) {
			return $result;
		} else {
			$commentsValue['userId']	=	$sessionArray['loginId'];
			$commentsValue['listId']	=	$postData['listId'];
			$commentsValue['itemId']	=	$postData['itemId'];
			$commentsValue['parentCommentId']	=	0; 
			$commentsValue['commentText']	=	$postData['comments'];
			$commentsValue['createdAt']	=	date('Y-m-d H:i:s');
			$commentsValue['modifiedAt']	=	date('Y-m-d H:i:s');
			$this->setData($commentsValue);
			$commentId	=	$this->insertData();
			
			$todoHistArr =  array();
			$todoHistArr['listId']  = $postData['listId'];
			$todoHistArr['itemId']  = $postData['itemId'];
			$todoHistArr['assignedBy']  = $sessionArray['loginId'];
			$todoHistArr['assignTo']  = '0';
			$todoHistArr['action']  = 'commented';
			$todoHistArr['actionBy']  = $sessionArray['loginId'];
			$todoHistArr['createdAt']  = date("Y-m-d H:i:s");
			$todoItemChangeObj =  new TodoItemChangeHistory();
			$todoItemChangeObj->setData($todoHistArr);
			$historyId = $todoItemChangeObj->insertData();
			if( isset($postData['attachment']) && $postData['attachment']!='' ) {
				
				$algo	=	new Algoencryption();	
				$newdir	=	$algo->encrypt("USER_".$sessionArray['loginId']);
				
				$attach  =  array();
				$attachmentsObj =  new Attachments();
				$attach['userId']  = $sessionArray['loginId'];
				$attach['listId']  = $postData['listId'];
				$attach['itemId']  = $postData['itemId'];
				$attach['name']  = $postData['attachment'];
				$attach['path']  = $newdir;
				$attach['type']  = 0;
				$attach['createdAt']  = date("Y-m-d H:i:s");
				$attachmentsObj->setData($attach);
				$attachId = $attachmentsObj->insertData();
				
				$data	=	array();
				$data['attachmentIds']	=	$attachId;
				$this->setData($data);
				$this->insertData($commentId);
			}
			$assginerUserDetail	=	$todoItemsObj->getAssignerUserByItem($postData['itemId']);
			$assignToUser	=	$todoItemsObj->getAssignedUserByItem($postData['itemId']);
			$currentUser	=	$usersObj->getUserDetail($sessionArray['loginId']);
			$currentUser  = $currentUser['result'];
			$itemDetails	=	$todoItemsObj->getItemDetails($postData['itemId'], '*', 1);
			if( is_numeric($postData['itemId']) ) {
				$itemEncryptedId	=	$algoencryptionObj->encrypt($postData['itemId']);
			} else {
				$itemEncryptedId	=	$postData['itemId'];
			}
			$todoLink=Yii::app()->params->base_path.'user/itemDescription/id/'.$itemEncryptedId.'/from/home';
			
			/*echo '<pre>';print_r($assginerUserDetail);
			print_r($assignToUser);exit;*/
			if( $currentUser['loginId'] == $assginerUserDetail['loginId'] ) {	
				$url	=	Yii::app()->params->base_path.'templatemaster/setTemplate/lng/eng/file/comment';			
				$fullName	=	$assginerUserDetail['firstName']. ' ' .$assginerUserDetail['lastName'];
				$to	=	$assignToUser['loginId'];
				$subject	=	'['.$itemDetails['listName']['name'].'] Comment: '.$itemDetails['title'];
				$message	=	file_get_contents($url);
				$message	=	str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				
				$message	=	str_replace("_COMMENT_ITEM_COMMENTED_",$this->msg['_ASSIGNEDTO_COMMENT_ITEM_COMMENTED_'],$message);
				
				$message	=	str_replace("_TODO_ITEM_NAME_",$itemDetails['title'],$message);
				$message	=	str_replace("_TODO_LIST_NAME_",$itemDetails['listName']['name'],$message);
				$message	=	str_replace("_ASSIGNER_",$fullName,$message);
				$message    =   str_replace("_TODO_LINK_",$todoLink,$message);
				$message	=	str_replace("_TITLE_",$postData['comments'],$message);
				$message = str_replace("_DESCRIPTION_",$itemDetails['description'],$message);
				$helperObj=new Helper();
				$helperObj->mailSetup($to,$subject,$message,$sessionArray['loginId'],'',$fullName);
			} else if( $currentUser['loginId'] == $assignToUser['loginId'] ) {
				$fullName	=	$assignToUser['firstName']. ' ' .$assignToUser['lastName'];
				$to	=	$assginerUserDetail['loginId'];
				$subject	=	'['.$itemDetails['listName']['name'].'] Comment: '.$itemDetails['title'];
				$url	=	Yii::app()->params->base_path.'templatemaster/setTemplate/lng/eng/file/comment';
				$message	=	file_get_contents($url);
				$message	=	str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				
				$message	=	str_replace("_COMMENT_ITEM_COMMENTED_",$this->msg['_ASSIGNER_COMMENT_ITEM_COMMENTED_'],$message);
				
				$message	=	str_replace("_TODO_ITEM_NAME_",$itemDetails['title'],$message);
				$message	=	str_replace("_TODO_LIST_NAME_",$itemDetails['listName']['name'],$message);
				$message	=	str_replace("_ASSIGNER_",$fullName,$message);
				$message    =   str_replace("_TODO_LINK_",$todoLink,$message);
				$message	=	str_replace("_TITLE_",$postData['comments'],$message);
				$message = str_replace("_DESCRIPTION_",$itemDetails['description'],$message);
				$helperObj	=	new Helper();
				$helperObj->mailSetup($to,$subject,$message,$sessionArray['loginId'],'',$fullName);
			} else {
				$currentUserFullName	=	$currentUser['firstName']. ' ' .$currentUser['lastName'];
				$assginerFullName	=	$assginerUserDetail['firstName']. ' ' .$assginerUserDetail['lastName'];
				
				$to1	=	$assginerUserDetail['loginId'];
				$to2	=	$assignToUser['loginId'];
				$subject	=	'['.$itemDetails['listName']['name'].'] Comment: '.$itemDetails['title'];
				$url	=	Yii::app()->params->base_path.'templatemaster/setTemplate/lng/eng/file/comment';
				$message	=	file_get_contents($url);
				$message	=	str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				$message	=	str_replace("_COMMENT_ITEM_COMMENTED_",$this->msg['_ASSIGNER_COMMENT_ITEM_COMMENTED_'],$message);
				$message	=	str_replace("_TODO_ITEM_NAME_",$itemDetails['title'],$message);
				$message	=	str_replace("_TODO_LIST_NAME_",$itemDetails['listName']['name'],$message);
				$message	=	str_replace("_ASSIGNER_",$currentUserFullName,$message);
				$message    =   str_replace("_TODO_LINK_",$todoLink,$message);
				$message	=	str_replace("_TITLE_",$postData['comments'],$message);
				$message 	= str_replace("_DESCRIPTION_",$itemDetails['description'],$message);
				
				$helperObj=new Helper();
				$helperObj->mailSetup($to1,$subject,$message,$sessionArray['loginId'],'',$assginerFullName);
				if(isset($assignToUser['id']) && $assignToUser['id']!=0)
				{
					$message	=	str_replace($this->msg['_ASSIGNER_COMMENT_ITEM_COMMENTED_'],$this->msg['_ASSIGNEDTO_COMMENT_ITEM_COMMENTED_'],$message);
					$assginToFullName	=	$assignToUser['firstName']. ' ' .$assignToUser['lastName'];
					$helperObj->mailSetup($to2,$subject,$message,$sessionArray['loginId'],'',$assginToFullName);
				}
			}
			return array('status'=>0, 'message'=>$this->msg['_COMMENT_ADD_MESSAGE_']);
		}
	}
	
	public function addComments($post)
	{
		$arr = array();
		$arr['userId'] = $post['userId'];
		$arr['listId'] = $post['listId'];
		$arr['itemId'] = $post['itemId'];
		if(isset($post['parentCommentId']) && $post['parentCommentId'] != '')
		{
			$arr['parentCommentId'] = $post['parentCommentId'];
		}
		$arr['commentText'] = $post['commentText'];
		if(isset($post['attachmentIds']) && $post['attachmentIds'] != '')
		{
			$arr['attachmentIds'] = $post['attachmentIds'];
		}
		$arr['createdAt'] = date("Y-m-d H:i:s");
		
		$comments = new Comments();
		$comments->userId = $arr['userId'];
		$comments->listId = $arr['listId'];
		$comments->itemId = $arr['itemId'];
		if(isset($post['parentCommentId']) && $post['parentCommentId'] != '')
		{
			$comments->parentCommentId = $arr['parentCommentId'];
		}
		$comments->commentText = $arr['commentText'];
		if(isset($post['attachmentIds']) && $post['attachmentIds'] != '')
		{
			$comments->attachmentIds = $arr['attachmentIds'];
		}
		$comments->createdAt = $arr['createdAt'];
		$res = $comments->save();
		//$comments->setData($arr);
		//$comments->setIsNewRecord(true);
		//$userId=$User->insertData();
		return $res;
	}
	
	public function getcommentsByList($listId)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from('comments')
					->where('listId=:listId', array(':listId'=>$listId))	
					->queryAll();
		return $result;
	}
	
	public function getcommentsByUser($userId)
	{
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from('comments')
   	 	->where('userId=:userId', array(':userId'=>$userId))	
   	 	->queryAll();
		return $result;
	}
	
	public function getcommentsByItem($itemId)
	{
		$algo=new Algoencryption();
		if( !is_numeric($itemId) ) {
			$itemId	=	$algo->decrypt($itemId);
		}
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from('comments')
					->where('itemId=:itemId', array(':itemId'=>$itemId))	
					->order('id desc')
					->queryAll();
		
		$attachmentObj	=	new Attachments();
		$algo	=	new Algoencryption();
		$general = new General();
		
		if( count($result) > 0 ) {
			$index	=	0;
			foreach( $result as $each ) {
				$result[$index]['createdAt'] = $general->rel_time($each['createdAt']);
				if( $each['attachmentIds'] != '' ) {
					$attachmentDetails	=	$attachmentObj->getAttachmentsById($each['attachmentIds']);
					$result[$index]['attachmentFile']=$attachmentDetails['name'];
					$attachmentDir=$algo->encrypt("USER_".$attachmentDetails['userId']);
					$result[$index]['attachmentDir']=$attachmentDir;
					$result[$index]['attachmentDir']=$attachmentDir;
						
				}
				$index++;
			}
		}
		return $result;
	}
	public function deleteCommentsByListId($userId)
	{
		$condition = "userId=:userId";
		$params[':userId'] = $userId;
		Comments::model()->deleteAll($condition,$params);
	}
	
	function getCommentsCount($itemId)
	{
		$count	=	Yii::app()->db->createCommand()
					->select('count(id)')
					->from($this->tableName())
					->where('itemId=:itemId', array(':itemId'=>$itemId))
					->queryScalar();
					
		return $count;
	}
}