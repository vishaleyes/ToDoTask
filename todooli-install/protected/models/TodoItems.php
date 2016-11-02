<?php

/**
 * This is the model class for table "todo_items".
 *
 * The followings are the available columns in table 'todo_items':
 * @property string $id
 * @property string $listId
 * @property string $key
 * @property string $title
 * @property string $description
 * @property string $attachmentIds
 * @property string $assignedBy
 * @property string $assignTo
 * @property string $dueDate
 * @property integer $priority
 * @property string $status
 * @property string $createdAt
 * @property string $modifiedAt
 * @property string $deletedAt
 */
class TodoItems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TodoItems the static model class
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
		return 'todo_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('listId, key, title, description, attachmentIds, assignedBy, assignTo, dueDate, priority, createdAt, modifiedAt, deletedAt', 'required'),
			//array('priority', 'numerical', 'integerOnly'=>true),
			//array('listId, assignedBy', 'length', 'max'=>20),
			//array('key', 'length', 'max'=>15),
			//array('title, attachmentIds', 'length', 'max'=>255),
			//array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, listId, key, title, description, attachmentIds, assignedBy, assignTo, dueDate, priority, status, createdAt, modifiedAt, deletedAt', 'safe', 'on'=>'search'),
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
			'listId' => 'List',
			'key' => 'Key',
			'title' => 'Title',
			'description' => 'Description',
			'attachmentIds' => 'Attachment Ids',
			'assignedBy' => 'Assigned By',
			'assignTo' => 'Assign To',
			'dueDate' => 'Due Date',
			'priority' => 'Priority',
			'status' => 'Status',
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
		$criteria->compare('listId',$this->listId,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('attachmentIds',$this->attachmentIds,true);
		$criteria->compare('assignedBy',$this->assignedBy,true);
		$criteria->compare('assignTo',$this->assignTo,true);
		$criteria->compare('dueDate',$this->dueDate,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('status',$this->status,true);
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
						if($key=='status' && $value=='')
						{
							$value='1';	
						}
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
	DESCRIPTION : GET ALL ITEMS WITH PAGINATION
	*/
	public function getAllPaginatedItems($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL,$stat1=NULL,$stat3=NULL,$stat4=NULL)
	{
		$search = '';
		$dateSearch = '';
		if($stat1!=NULL && $stat1 != 0)
		{
			$cond .=  " t.status=".$stat1;
		}
		if(!empty($stat3) && $stat3 != 0)
		{
			if($stat1!=NULL && $stat1 != 0) 
			{
				$cond .=  " or t.status=".$stat3;
			}
			else
			{
				$cond .=  " t.status=".$stat3;
			}
		}
		if($stat4!=NULL && $stat4 != 0)
		{
			if($stat1!=NULL && $stat1!=0 || $stat3!=NULL && $stat3!=0)
			{
				$cond .=  " or t.status=".$stat4;
			}
			else
			{
				$cond .=  " t.status=".$stat4;
			}
		}
		if($cond!='')
		{
			$finalCond = " and (".$cond.")";
		}
		
		
		if(isset($keyword) && $keyword != NULL )
		{
/*			$search = " HAVING ( item.title like '%".$keyword."%' or  list.name like '%".$keyword."%' or item.description like '%".$keyword."%' or item.dueDate like '%".$keyword."%' or item.priority like '%".$keyword."%' or assignedByFname like '%".$arr[0]."%'";
*/			
			$search = " HAVING (title like '%".$keyword."%' or description like '%".$keyword."%' or  assignToFname like '%".$keyword."%' or assignedByFname like '%".$keyword."%')";
			
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and t.createdAt > '".date("Y-m-d",strtotime($startDate))."' and t.createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}

		 $sql_list = "select t.id,t.title,t.description,t.dueDate,t.status,u.firstName as assignedByFname,u.lastName as assignedByLname,(select u.firstName  from users u where u.id = t.assignTo) as assignToFname,(select u.lastName  from users u where u.id = t.assignTo) as assignToLname,t.createdAt,t.modifiedAt  from todo_items t,login l,users u where t.assignedBy = l.id and l.userId = u.id   ".$finalCond." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select t.id,t.title,t.description,t.dueDate,u.firstName as assignedByFname,u.lastName as assignedByLname,(select u.firstName  from users u where u.id = t.assignTo) as assignToFname,(select u.lastName  from users u where u.id = t.assignTo) as assignToLname,t.createdAt,t.modifiedAt  from todo_items t,login l,users u where t.assignedBy = l.id and l.userId = u.id  ".$finalCond." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryAll();
		
		$item	=	new CSqlDataProvider($sql_list, array(
						'totalItemCount'=>count($count),
						'pagination'=>array(
							'pageSize'=>$limit,
						),
					));
		
		return array('pagination'=>$item->pagination, 'items'=>$item->getData());
 	
	}
	
	/*
	DESCRIPTION : GET ALL USERS WITH PAGINATION
	*/
	public function getAllPaginatedStatistics($limit=10,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
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
		elseif(isset($startDate) && $startDate != NULL )
		{
			$dateSearch = " and DATE_FORMAT(createdAt , '%Y-%m-%d') = '".date("Y-m-d",strtotime($startDate))."'";	
		}
		elseif(isset($endDate) && $endDate != NULL)
		{
			$dateSearch = "and DATE_FORMAT(createdAt , '%Y-%m-%d') = '".date("Y-m-d",strtotime($endDate))."'";	
		}
		$listSearch='';
		
		
		if(Yii::app()->session['listId'])
		{
			$listSearch = "and listId=".Yii::app()->session['listId'];
		}
		$sql_open = "(select count(id) as totalopenCount from todo_items where  assignTo = l.id and status = 1 ".$listSearch." ".$dateSearch.") as openCount";
		$sql_done = "(select count(id) as donecount from todo_items where  assignTo = l.id and status = 3 ".$listSearch." ".$dateSearch.") as doneCount ";
		$sql_close = "(select count(*) as closecount from todo_items where  assignTo = l.id and status = 4 ".$listSearch." ".$dateSearch.") as closeCount ";
		$sql_openByMe = "(select count(*) as openbymecount from todo_items where  assignedBy = l.id and status = 1 ".$listSearch." ".$dateSearch.") as  openByMeCount";
		$sql_closeByMe = "(select count(*) as closebymecount from todo_items where  assignedBy = l.id and status = 4 ".$listSearch." ".$dateSearch.") as closeByMeCount";
		$sql_users = "select *,l.id as logId,".$sql_open.",".$sql_done.",".$sql_close.",".$sql_openByMe.",".$sql_closeByMe."  from users u,login l where u.id=l.userId ".$search."   order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from users u,login l where u.id=l.userId ".$search." ".$dateSearch." ";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		
		return array('pagination'=>$item->pagination, 'data'=>$item->getData());
	}
	
	/*
	DESCRIPTION : CHANGE TODO ITEM ATTRIBUTE
	PARAMS : $itemId -> TODO ITEM ID,
			 $status -> LOW(0), MEDIUM(1), HIGH(2) AND URGENT(3),
			 $field -> ATTRIBUTE NAME
	*/
	public function changeItemField($itemId=NULL, $status=1, $field=NULL, $sessionArray=array())
	{
		$itemData[''.$field.'']	=	$status;
		$this->setData($itemData);
		$this->insertData($itemId);
		
		if( is_numeric($itemId) ) {
			$algoencryptionObj	=	new Algoencryption();
			$encryptedId	=	$algoencryptionObj->encrypt($itemId);
		} else {
			$encryptedId	=	$itemId;
		}
		
		$itemDetail	=	$this->getItemDetails($itemId, '*', 1);
		$assignedUserDetail	=	$this->getAssignedUserByItem($itemId);
		$assignerUserDetail	=	$this->getAssignerUserByItem($itemId);
		
		if( $itemDetail['status'] == 1 ) {
			$status	=	'Open';
		} else if( $itemDetail['status'] == 3 ) {
			$status	=	'Done';
		} else{
			$status	=	'Close';
		}
		
		if( $field == 'listId' ) {
			$subjectText	=	$this->msg['_ITEM_LIST_UPDATE_'];
		} else if( $field == 'priority' ) {
			$subjectText	=	$this->msg['_ITEM_PRIORITY_UPDATE_'];
		} else if( $field == 'title' ) {
			$subjectText	=	$this->msg['_ITEM_TITLE_UPDATE_'];
		} else if( $field == 'description' ) {
			$subjectText	=	$this->msg['_ITEM_DESCRIPTION_UPDATE_'];
		} else if( $field == 'dueDate' ) {
			$subjectText	=	$this->msg['_ITEM_DUEDATE_UPDATE_'];
		} else {
			$subjectText	=	$this->msg['_ITEM_TODO_UPDATE_'];
		}
		
		$todoLink=Yii::app()->params->base_path.'user/itemDescription/id/'.$encryptedId.'/from/home';
		$to	=	$assignedUserDetail['loginId'];
		$subject	=	$subjectText;
		$url	=	Yii::app()->params->base_path.'templatemaster/setTemplate/lng/eng/file/item-update';
		$message	= file_get_contents($url);
		$message	= str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
		$message	= str_replace("_ITEM_UPDATED_",$subjectText,$message);
		$message	= str_replace("_NEWSTATUS_",$status,$message);
		$message	= str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
		$message	= str_replace("_TITLE_",$itemDetail['title'],$message);
		$message	= str_replace("_DESCRIPTION_",$itemDetail['description'],$message);
		$message	= str_replace("_DUEDATE_",$itemDetail['dueDate'],$message);
		$message	= str_replace("_TODO_LINK_",$todoLink,$message);
		$message	= str_replace("_ASSIGNBY_",$assignerUserDetail['firstName'].' '.$assignerUserDetail['lastName'],$message);
		$message	= str_replace("_CREATE_",$itemDetail['createdAt'],$message);
		
		//echo '<pre>';print_r($message);exit;
		
		$helperObj	= new Helper();
		$helperObj->mailSetup($to,$subject,$message,$sessionArray['loginId'],$assignedUserDetail['id'], $sessionArray['fullname']);
		
	}
	
	function changeTodoItemsStatus($id,$stat,$sessionArray=array())
	{
		if( is_numeric($id) ) {
			$algoencryptionObj	=	new Algoencryption();
			$encryptedId	=	$algoencryptionObj->encrypt($id);
		} else {
			$encryptedId	=	$id;
		}
		$this->changeStatus($id, $stat);
		$itemDetail	=	$this->getItemDetails($id, '*', 1);
		$assignedUserDetail	=	$this->getAssignedUserByItem($id);
		$assignerUserDetail	=	$this->getAssignerUserByItem($id);
		
		$todoHistArr =  array();
		$todoHistArr['listId']  = $itemDetail['listId'];
		$todoHistArr['itemId']  = $itemDetail['id'];
		$todoHistArr['assignedBy']  = $itemDetail['assignedBy'];
		$todoHistArr['assignTo']  = $sessionArray['loginId'];
		if($stat==1)
		{
			$todoHistArr['action']  = 'reopened';
			
		}
		if($stat==3)
		{
			$todoHistArr['action']  = 'marked done';
		}
		if($stat==4)
		{
			$todoHistArr['action']  = 'close';
		}
		$todoHistArr['actionBy']  = $sessionArray['loginId'];
		$todoHistArr['createdAt']  = date("Y-m-d H:i:s");
		$todoItemChangeObj =  new TodoItemChangeHistory();
		$todoItemChangeObj->setData($todoHistArr);
		$historyId = $todoItemChangeObj->insertData();
		$todoLink=Yii::app()->params->base_path.'user/itemDescription/id/'.$encryptedId.'/from/home';
		
		if($stat == 4){
			$to	=	$assignedUserDetail['loginId'];
			$subject	='['.$itemDetail['listName']['name'].'] Close: '.$itemDetail['title'];
			$url	=	Yii::app()->params->base_path.'templatemaster/setTemplate/lng/eng/file/item-closed';
			$message	= file_get_contents($url);
			$message	= str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
			$message	= str_replace("_NEWSTATUS_",'Close',$message);
			$message	= str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
			$message	= str_replace("_TITLE_",$itemDetail['title'],$message);
			$message	= str_replace("_DESCRIPTION_",$itemDetail['description'],$message);
			$message	= str_replace("_DUEDATE_",$itemDetail['dueDate'],$message);
			$message	= str_replace("_TODO_LINK_",$todoLink,$message);
			$message	= str_replace("_ASSIGNBY_",$assignerUserDetail['firstName'].' '.$assignerUserDetail['lastName'],$message);
			$message	= str_replace("_CREATE_",$itemDetail['createdAt'],$message);
			$helperObj	= new Helper();
			$helperObj->mailSetup($to,$subject,$message,$sessionArray['loginId'],$assignedUserDetail['id'], $sessionArray['fullname']);
		} else if ($stat == 3) {
			$to	=	$assignerUserDetail['loginId'];
			$subject	='['.$itemDetail['listName']['name'].'] Done: '.$itemDetail['title'];
			$url	=	Yii::app()->params->base_path.'templatemaster/setTemplate/lng/eng/file/item-done';
			$message = file_get_contents($url);
			$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
			$message = str_replace("_NEWSTATUS_",'Done',$message);
			$message = str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
			$message = str_replace("_TITLE_",$itemDetail['title'],$message);
				$message 	= str_replace("_DESCRIPTION_",$itemDetail['description'],$message);
			$message = str_replace("_DUEDATE_",$itemDetail['dueDate'],$message);
			$message = str_replace("_TODO_LINK_",$todoLink,$message);
			$message = str_replace("_ASSIGNBY_",$assignerUserDetail['firstName'].' '.$assignerUserDetail['lastName'],$message);
			$message = str_replace("_CREATE_",$itemDetail['createdAt'],$message);
			$helperObj = new Helper();
			$helperObj->mailSetup($to,$subject,$message,$sessionArray['loginId'],$assignerUserDetail['id'], $sessionArray['fullname']);
		}	
	}
	
	function addTodoItem($postData, $sessionArray, $itemId=NULL)
	{
		$sessionArray['current']=$sessionArray['loginId'];
		$assignToEmail='';
		if(isset($itemId) && !is_numeric($itemId))
		{
			$algoencryptionObj	=	new Algoencryption();
			$itemId=$algoencryptionObj->decrypt($itemId);				
		}
		
		if(!isset($itemId))
		{
			$validationOBJ = new Validation();
			$result = $validationOBJ->addTodoItems($postData);
			if($result['status']!=0)
			{
				return $result;
			}
		}
		//If self TODO
		if(isset($postData['assignerType']) && $postData['assignerType']=='self')
		{
			$assignToId=$sessionArray['loginId'];
			$assignById=0;	
			$assignByIdStatus=0;	
		}
		else
		{	
			if(isset($itemId) && $itemId!='')
			{
				$loginObj	=	new Login();
				$getCurrentUser	=	$loginObj->getLoginIdById($sessionArray['loginId']);
				
				if( !isset($postData['value']) || $postData['value'] == '' ) {	//	SELF ASSIGN CONDITION
					return array('status'=>$this->errorCode['_EMPTY_REASSIGN_VALIDATION_'],'message'=>$this->msg['_EMPTY_REASSIGN_VALIDATION_']);
				}
				if( $getCurrentUser == $postData['value'] ) {	//	SELF ASSIGN CONDITION
					return array('status'=>$this->errorCode['_REASSIGN_VALIDATION_'],'message'=>$this->msg['_REASSIGN_VALIDATION_']);
				}
				
				$getData	=	$this->getItemDetails($itemId, '*', 1);
				//Set parameter for todo add
				$postData['todoList']	=	$getData['listId'];
				$postData['title']	=	$getData['title'];
				$postData['description']	=	$getData['description'];
				$postData['priority']	=	$getData['priority'];
				$postData['duedate']	=	date('Y/m/d', strtotime($getData['dueDate']));
				$postData['assignerType']	=	'other';
				$postData['attachment']	=	'';
				$postData['userlist']	=	$postData['value'];
				
				if($getData['assignedBy']==0)
				{
					$sessionArray['loginId']	=	$getData['assignTo'];
				}
				else
				{
					$sessionArray['loginId']	=	$getData['assignedBy'];	
				}
				
				//	CHECK IF ASSIGNED FOR TO THE OWNER
				$getAssignedToId	=	$loginObj->getUserIdByLoginId($postData['value']);
				if( !empty($getAssignedToId) && $getAssignedToId['id']	==	$sessionArray['loginId'] ) {
				return array('status'=>$this->errorCode['_REASSIGN_VALIDATION_'],'message'=>$this->msg['_REASSIGN_VALIDATION_']);
				}
			}
		   
			$loginObj = new Login();
			
			if( !isset($postData['userlist']) || $postData['userlist'] == '' ) {	//	SELF ASSIGN CONDITION
				return array('status'=>$this->errorCode['_EMPTY_REASSIGN_VALIDATION_'],'message'=>$this->msg['_EMPTY_REASSIGN_VALIDATION_']);
			}
			$result1 = $loginObj->getUserByEmail($postData['userlist']);
			
			if(!empty($result1))
			{
				if($result1['id'] == $sessionArray['current'] ) {
					$assignToId=$sessionArray['loginId'];
					$assignById=0;	
					$assignByIdStatus=0;
				} else {
					$assignToId=$result1['id'];
					$assignByIdStatus=$postData['userlist'];
					$assignById=$sessionArray['loginId'];
				
					$todoNetworkObj	=	new Todonetwork();
					$networkExits	=	$todoNetworkObj->checkNetworkUser($sessionArray['loginId'], $assignToId);
					$networkData	=	array();
					if( isset($networkExits) && $networkExits == '' ) {	//ADD TO NETWORK FUNCTIONALITY
						$networkData['userId']	=	$sessionArray['loginId'];
						$networkData['networkId']	=	$assignToId;
						$networkData['listId']	=	$postData['todoList'];
						$networkData['created']	=	date("Y-m-d H:i:s");
						$todoNetworkObj->setData($networkData);
						$todoNetworkObj->insertData();
						
						$todoNetworkObj	=	new Todonetwork();
						$networkData['userId']	=	$assignToId;
						$networkData['networkId']	=	$sessionArray['loginId'];
						$networkData['listId']	=	$postData['todoList'];
						$networkData['created']	=	date("Y-m-d H:i:s");
						$todoNetworkObj->setData($networkData);
						$todoNetworkObj->insertData();
					}
				}
			}
			else
			{
				$assignToEmail=$postData['userlist'];
				$assignToId=0;
			}	
		}
		
		$loginObj	=	new Login();
		$data = array();
		$data['title'] = $postData['title'];
		$data['description'] = $postData['description'];
		$data['assignedBy'] = $assignById;
		$data['assignTo'] = $assignToId;
		$data['dueDate'] = date('Y-m-d',strtotime($postData['duedate']));
		$data['priority'] = $postData['priority'];
		$data['listId'] = $postData['todoList'];
		if(isset($postData['attachment']))
		{
			$data['attachment'] = $postData['attachment'];
		}
		if($postData['assignerType']=='other')
		{
			$invitesObj =  new Invites();
			$resbool = $invitesObj->isExistInviteUser($postData['todoList'],$data['assignTo'],$data['assignedBy']);
			if(!$resbool)
			{	
				if($sessionArray['loginId'] != $data['assignTo'])
				{		
					$inviteArr['listId'] = $postData['todoList'];
					$inviteArr['senderId'] = $data['assignedBy'];
					$inviteArr['receiverId'] = $data['assignTo'];
					$inviteArr['createdAt'] = date("Y-m-d H:i:s");
					$invitesObj->setData($inviteArr);
					$invitesObj->insertData();
				}
			}
		}
		
		$todoArr =  array();
		$todoArr['listId']  = $data['listId'];
		$todoArr['title']  = $data['title'];
		$todoArr['description']  = $data['description'];
		$todoArr['assignedBy']  = $data['assignedBy'];
		$todoArr['assignTo']  = $assignToId;
		$todoArr['assignToEmail']  = $assignToEmail;
		$todoArr['dueDate']  = date('Y-m-d',strtotime($data['dueDate']));
		$todoArr['priority']  = $data['priority'];
		if(!isset($itemId)){
			$todoArr['createdAt']  = date("Y-m-d H:i:s");
			$todoArr['creater']  = $sessionArray['current'];
			
			$todoItemsObj =  new TodoItems();
			$todoItemsObj->setData($todoArr);
			$id = $todoItemsObj->insertData();
		} else {
			$todoArr['modifiedAt']  = date("Y-m-d H:i:s");
		
			$todoItemsObj =  new TodoItems();
			$todoItemsObj->setData($todoArr);
			$id = $todoItemsObj->insertData($itemId);
			$id=$itemId;
		}
		
		$loginData['last_listId']=$data['listId'];
		$loginData['last_priority']=$data['priority'];
		$loginData['last_todoassign']=$assignByIdStatus;
		$loginData['last_duedate']= date('Y-m-d',strtotime($data['dueDate']));	
		$loginObj->setData($loginData);
		$loginObj->insertData($sessionArray['current']);
		
		
		$todoHistArr =  array();
		$todoHistArr['listId']  = $data['listId'];
		$todoHistArr['itemId']  = $id;
		$todoHistArr['assignedBy']  = $data['assignedBy'];
		$todoHistArr['assignTo']  = $assignToId;
		$todoHistArr['actionBy']  = $data['assignedBy'];
		$todoHistArr['createdAt']  = date("Y-m-d H:i:s");	
		$todoHistArr['actionBy']  = $sessionArray['current'];
		if(!isset($postData['action']))
		{
			$postData['action']="assigned";
		}
		$todoHistArr['action']=$postData['action'];
		
		if(isset($postData['action']) && $postData['action']=='assigned')
		{
			$todoHistArr['action']  = 'created';
			$todoItemChangeObj =  new TodoItemChangeHistory();
			$todoItemChangeObj->setData($todoHistArr);
			$historyId = $todoItemChangeObj->insertData();
			$todoHistArr['action']  = 'assigned';
		}
		$todoItemChangeObj =  new TodoItemChangeHistory();
		$todoItemChangeObj->setData($todoHistArr);
		$historyId = $todoItemChangeObj->insertData();
				
		if(isset($postData['userlist']) && $postData['userlist']!='' && $postData['assignerType']!='self')
		{
			if( is_numeric($id) ) {
				$algoencryptionObj	=	new Algoencryption();
				$encryptedId	=	$algoencryptionObj->encrypt($id);
			} else {
				$encryptedId	=	$id;
			}
			$todoListsObj =  new TodoLists();
			$lists=$todoListsObj->getMyListById($data['listId'],'name');
			
			$to      = $postData['userlist'];
			$subject = '['.$lists['name'].'] New: '.$data['title'];
			$todoLink=Yii::app()->params->base_path.'user/itemDescription/id/'.$encryptedId.'/from/home';
			$Yii = Yii::app();	
			if($assignToId==0)
			{
				$registerLink=Yii::app()->params->base_path."site/signUpMain&userId=".$data['assignedBy']."&listId=".$data['listId']."&email=".$postData['userlist'];
				$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/assign-task-link-register';
				$message = file_get_contents($url);
				$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				$message = str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
				$message = str_replace("_TITLE_",$todoArr['title'],$message);
				$message = str_replace("_DESCRIPTION_",$todoArr['description'],$message);
				$message = str_replace("_DUEDATE_",$todoArr['dueDate'],$message);
				$message = str_replace("_TODO_LINK_",$todoLink,$message);
				$message = str_replace("_REGISTER_",$registerLink,$message);
			}
			else
			{
				$registerLink=Yii::app()->params->base_path;
				$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/assign-task-link';
				$message = file_get_contents($url);
				$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				$message = str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
				$message = str_replace("_TITLE_",$todoArr['title'],$message);
				$message = str_replace("_DESCRIPTION_",$todoArr['description'],$message);
				$message = str_replace("_DUEDATE_",$todoArr['dueDate'],$message);
				$message = str_replace("_TODO_LINK_",$todoLink,$message); 
				$message = str_replace("_REGISTER_",$registerLink,$message);
			}
			$helperObj = new Helper();
			$helperObj->mailSetup($to,$subject,$message,$sessionArray['loginId'],$assignToId,$sessionArray['fullname']);
		}
		
		$algo=new Algoencryption();	
		$newdir=$algo->encrypt("USER_".$data['assignedBy']);
		$imgPath = $newdir;
		
		if(isset($postData['attachment']) && $postData['attachment']!='')
		{
			$arr  =  array();
			$attachmentsObj =  new Attachments();
			$attachmentsObj->userId =  $data['assignedBy'];
			$arr['userId']  = $sessionArray['loginId'];
			$arr['listId']  = $data['listId'];
			$arr['itemId']  = $id;
			$arr['name']  = $data['attachment'];
			$arr['path']  = $imgPath;
			$arr['type']  = 0;
			$arr['createdAt']  = date("Y-m-d H:i:s");
			$attachmentsObj->setData($arr);
			$res = $attachmentsObj->insertData();
			
			$todoItems=TodoItems::model()->findbyPk($id);
			$data = array();
			$data['attachmentIds'] = $res;
			$todoItems->setData($data);
			$res = $todoItems->insertData($id);
		}
		
		if(!isset($itemId)) {
			return array("status"=>0,"message"=>$this->msg['_ADD_TODO_MESSAGE_']);	
		} else {
			return array("status"=>0,"message"=>$this->msg['_TODO_REASSIGNED_']);
		}
	}
	function updateTodoItemsEmail($loginId,$email)
	{
		$updatedArray['assignTo']=$loginId;
		$condition="assignToEmail=:assignToEmail";
		$params=array(":assignToEmail"=>$email);
		$this->updateAll($updatedArray, $condition, $params);
	}

	/*
	DESCRIPTION : GET ALL TODO ITEMS BY USER ID
	PARAMS : $id -> ASSIGNED TO ID,
			 $other -> MINE (NULL) AND OTHER (TRUE)
	*/
	public function getMyToDoItems($sessionArray=array(), $limit=5, $sortType='desc', $sortBy='itemId',$keyword=NULL,$assignByMe='')
	{
		$id=$sessionArray['loginId'];
		$todoListsObj	=	new TodoLists();
		$attachmentObj	=	new Attachments();
		
		$algoencryptionObj	=	new Algoencryption();
		$listsIds	=	array();
		$listsIds	=	$todoListsObj->getAllMyListIdsArray($id);
		$orderByidArray=array("itemId","assignedByFname","listName","title","dueDate","priority","status");
		if(!in_array($sortBy,$orderByidArray))
		{
			 $sortBy='itemId';
		}
		
		$search = "";
		
		if(trim($keyword)!="" || trim($assignByMe)!='')
		{
			$arr = explode(' ',trim($keyword));
			
			$search.= " HAVING ( ";
			
			if(trim($keyword)!="")
			{
				$search.=" item.title like '%".$keyword."%' or  list.name like '%".$keyword."%' or item.description like '%".$keyword."%' or item.dueDate like '%".$keyword."%' or item.id='".$keyword."' or item.priority like '%".$keyword."%' or assignedByFname like '%".$arr[0]."%'";
				if(isset($arr[1]))
				{
					$search.=" or assignedByLname like '%".$arr[1]."%' ";
				}	
			}
			
			if(trim($assignByMe)!='') {	
				$arr = explode(' ',trim($assignByMe));
				if(trim($keyword)!="")
				{
					$search.=" and ";
				}
				if(strtolower($arr[0])=='me')
				{
					$search.="item.assignedBy= 0";	
				}
				else
				{
					$search.=	" ( assignedByFname like '%".$arr[0]."%'";
					if(isset($arr[1]))
					{
						$search.=" and assignedByLname like '%".$arr[1]."%' ";
					}
					$search.=" ) ";
				}
			}
			
			$search.=" )";
			
		}
		
		
		
		$listSearch='';
		if(isset($sessionArray['mylist']) && $sessionArray['mylist']!=0)
		{
			$listSearch.='and item.listId='.$sessionArray['mylist'];
		}
		
		$listStatusSearch='';
		if(isset($sessionArray['mytodoStatus']) && $sessionArray['mytodoStatus']!=0)
		{
			$listStatusSearch.='and item.status='.$sessionArray['mytodoStatus'];
			if($sessionArray['mytodoStatus']==4)
			{
				$closeItems	=	'';
			}
		}
		
		  $sql = "SELECT item.id as id,item.id as itemId,item.creater,item.attachmentIds,item.assignedBy as assignedBy,item.assignTo, item.title as title,item.createdAt,item.description as description, item.dueDate as dueDate, item.priority as priority, item.status as status, list.name as listId,list.name as listName,list.createdBy, u.id as uId, u.firstName as assignedToFname, u.lastName as assignedToLname,(select lu.firstName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignedBy) as assignedByFname,(select lu.lastName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignedBy) as assignedByLname  FROM todo_items item, todo_lists list, users u, login l WHERE  (item.status=u.myOpenStatus or item.status=u.myCloseStatus or item.status=u.myDoneStatus) and item.assignTo = l.id AND l.userId = u.id AND list.id=item.listId AND item.assignTo =".$id."  AND listId in (".implode(',',$listsIds).")  ".$listSearch." ".$listStatusSearch." ".$search."  order by ".$sortBy." ".$sortType."";
	
		
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($count),
			'pagination'=>array(
				'pageSize'=>$limit,
			),
		));
		
		$items = array();
		$index = 0;
		$generalObj	=	new General();
		$algObj = new Algoencryption();
		$commentsObj	=	new Comments();
		$userObj	=	new Users();
		$timeZone	=	$userObj->getTimeZone(Yii::app()->session['userId']);
		foreach($dataProvider->getData() as $itemData){
				$items[$index]['id'] =   $itemData['itemId'];
				$items[$index]['id_encrypt'] =  $algObj->encrypt($itemData['itemId']);
				$items[$index]['assignedBy'] =   $itemData['assignedBy'];
				$items[$index]['myTimeZone'] =   $timeZone;
				$items[$index]['creater'] =   $itemData['creater'];
				$items[$index]['description'] =   $generalObj->autolink($itemData['description']);
				$items[$index]['createdAt'] =   $itemData['createdAt'];
				$items[$index]['time'] =   $generalObj->rel_time($itemData['createdAt']);
				$items[$index]['title'] =   $generalObj->autolink($itemData['title']);
				$items[$index]['assignedByFname'] =   $itemData['assignedByFname'];
				$items[$index]['assignedByLname'] =   $itemData['assignedByLname'];
				$items[$index]['dueDate'] =   $itemData['dueDate'];
				$items[$index]['dueDays']	=	$generalObj->rel_time($itemData['dueDate']);
				$items[$index]['priority'] =   $itemData['priority'];
				$items[$index]['status'] =   $itemData['status'];
				$items[$index]['listName'] =   $itemData['listName'];
				$todoListsObj = new TodoLists();
				$ListData = $todoListsObj->getListOwner($itemData['createdBy']);
				$items[$index]['listOwner'] =   $ListData['firstName'].' '.$ListData['lastName'];
				$items[$index]['listcreatedBy'] =   $itemData['createdBy'];
				if($itemData['assignedBy']==0)
				{
					$items[$index]['assignedByFname']	=	'Me';
					$items[$index]['assignedByLname']	=	'';
				}
				
				if(isset($itemData['attachmentIds']) && trim($itemData['attachmentIds'])!='') {
					$attachment	=	$attachmentObj->getAttachmentsById($itemData['attachmentIds']);
					
					if(trim($attachment['name'])!='')
					{
						$items[$index]['attachmentFile']	=	$attachment['name'];
						$attachmentDir	=	$algoencryptionObj->encrypt("USER_".$attachment['userId']);
						$items[$index]['attachmentDir']	=	$attachmentDir;
					}
				}
				
				$items[$index]['commentCount']	=	$commentsObj->getCommentsCount($itemData['itemId']);
				$index++;
		}
				
		return array('pagination'=>$dataProvider->pagination, 'items'=>$items);
	}
	
	
	public function getMyToDoItemsUserWiseCount($id)
	{
		
		$todoListsObj	=	new TodoLists();
		$algoencryptionObj	=	new Algoencryption();
		$lists	=	$todoListsObj->getAllMyList($id);
		$listsIds	=	array();
		foreach($lists as $list){
			if($list['id']!='')
			{
				$listsIds[]	=	$list['id'];
			}
		}
		$sql = "SELECT item.id as id,item.id as itemId,count('item.id') as total,item.assignedBy as assignedBy,item.assignTo FROM todo_items item, todo_lists list, users u, login l WHERE item.assignTo = l.id AND l.userId = u.id AND list.id=item.listId AND item.assignTo =".$id." and item.status =1 AND listId in (".implode(',',$listsIds).") group by assignedBy order by total desc";
		
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($count),
		));
		$items = array();
		$index = 0;
		$generalObj	=	new General();
		foreach($dataProvider->getData() as $itemData){
				$items[$index]['id'] =   $itemData['itemId'];
				$items[$index]['total'] =   $itemData['total'];
				$items[$index]['assignedBy'] =   $itemData['assignedBy'];
				if($itemData['assignedBy']==0)
				{
					$items[$index]['assignedByFname']	=	'Me';
					$items[$index]['assignedByLname']	=	'';
				}
				else
				{	
					$usersObj=new Users();
					$res	=	$usersObj->getUserDetail($itemData['assignedBy']);
					$assignedTo=$res['result'];
					$items[$index]['assignedByFname'] =   $assignedTo['firstName'];
					$items[$index]['assignedByLname'] =   $assignedTo['lastName'];
				}
				$index++;
		}
				
		return array('pagination'=>'', 'items'=>$items);
	}
	
	/*
	DESCRIPTION : GET ALL TODO ITEMS BY USER ID
	PARAMS : $id -> ASSIGNED TO ID,
			 $other -> MINE (NULL) AND OTHER (TRUE)
	*/
	public function getOtherToDoItems($sessionArray=array(), $limit=5, $sortType='desc', $sortBy='itemId',$keyword=NULL, $assignByMe='',$assignTo='')
	{
		$id=$sessionArray['loginId'];
		
		if(isset($sessionArray['userId']))
		{
			$usersObj=new Users();
			$userData=$usersObj->getUserById($sessionArray['userId']);	
			
			if(!empty($userData))
			{
				$otherOpenStatus="'".$userData['otherOpenStatus']."'";
				$otherCloseStatus="'".$userData['otherCloseStatus']."'";
				$otherDoneStatus="'".$userData['otherDoneStatus']."'";	
			}
			else
			{			
				$otherOpenStatus='1';
				$otherCloseStatus='4';
				$otherDoneStatus='3';
			}
			$todoListsObj	=	new TodoLists();
			$attachmentObj	=	new Attachments();
			$algoencryptionObj	=	new Algoencryption();
			$listsIds	=	array();
			$listsIds	=	$todoListsObj->getAllMyListIdsArray($id);
		
		}
		
		$orderByidArray=array("itemId","assignedByFname","assignedToFname","listName","title","dueDate","priority","status");
		if(!in_array($sortBy,$orderByidArray))
		{
			 $sortBy='itemId';
		}
		$search="";	
				
		if(trim($keyword)!="" || trim($assignByMe)!='' || trim($assignTo)!='')
		{
			$search.= " HAVING ( ";
			if(trim($keyword)!="")
			{
				$arr = explode(' ',trim($keyword));
				$search.="  item.title like '%".$keyword."%' or item.description like '%".$keyword."%' or  list.name like '%".$keyword."%' or item.dueDate like '%".$keyword."%' or item.id='".$keyword."'  or item.priority like '%".$keyword."%' or assignedToFname  like '%".$arr[0]."%'  or assignedByFname  like '%".$arr[0]."%' ";
				if(isset($arr[1]))
				{
					$search.=" or assignedToLname like '%".$arr[1]."%'  or assignedByLname like '%".$arr[1]."%' ";
				}
			}
			
			if(trim($assignByMe)!='') {	
				$arr = explode(' ',trim($assignByMe));
				if(trim($keyword)!="")
				{
					$search.=" and ";
				}
				$search.=	" ( assignedByFname like '%".$arr[0]."%'";
				if(isset($arr[1]))
				{
					$search.=" and assignedByLname like '%".$arr[1]."%' ";
				}
				$search.=" ) ";
			}
			
			if(trim($assignTo)!='') {	
				$arr = explode(' ',trim($assignTo));
				if(trim($keyword)!="" || trim($assignByMe)!='')
				{
					$search.=" and ";
				}
				$search.=	" ( assignedToFname like '%".$arr[0]."%'";
				if(isset($arr[1]))
				{
					$search.=" and assignedToLname like '%".$arr[1]."%' ";
				}
				$search.=" ) ";
			}
			
			$search.=" )";
			
		
		}
		
		$listSearch='';
		if(isset($sessionArray['mylist']) && $sessionArray['mylist']!=0)
		{
			$listSearch.='and item.listId='.$sessionArray['mylist'];
		}
		
		$listStatusSearch='';
		if(isset($sessionArray['mytodoStatus']) && $sessionArray['mytodoStatus']!=0)
		{
			$listStatusSearch.='and item.status='.$sessionArray['mytodoStatus'];
			if($sessionArray['mytodoStatus']==4)
			{
				$closeItems	=	'';
			}
		}
		$sql_assingToFname = "(select lu.firstName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignTo) as assignedToFname";
		
		$sql_assingToLname = "(select lu.lastName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignTo) as assignedToLname";	
		
		$sql_assingByFname = "(select lu.firstName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignedBy) as assignedByFname";
		
		$sql_assingByLname = "(select lu.lastName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignedBy) as assignedByLname";
		
		 $sql = "SELECT item.id as itemId,item.attachmentIds,item.assignedBy as assignedBy,item.description,item.createdAt,item.assignTo as assignTo, item.title as title, item.dueDate as dueDate, item.priority as priority, item.status as status, list.name as listName,list.createdBy, u.id as uId,".$sql_assingToFname.",".$sql_assingToLname.",".$sql_assingByFname.",".$sql_assingByLname."
      FROM todo_items item, todo_lists list, users u, login l WHERE (item.status=".$otherOpenStatus." or item.status=".$otherCloseStatus." or item.status=".$otherDoneStatus.") AND item.assignedBy = l.id AND l.userId = u.id AND list.id=item.listId AND (item.assignTo !=".$id." OR item.assignTo=0) AND item.assignedBy not in (0,".$id.") and listId in (".implode(',',$listsIds).")  ".$listSearch." ".$listStatusSearch." ".$search."   order by ".$sortBy." ".$sortType."";
	  
	  
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($count),
			'pagination'=>array(
				'pageSize'=>$limit,
			),
		));
		
		$items = array();
		$index = 0;
		$generalObj	=	new General();
		$algObj = new Algoencryption();
		$commentsObj	=	new Comments();
		$userObj	=	new Users();
		$timeZone	=	$userObj->getTimeZone(Yii::app()->session['userId']);
		foreach($dataProvider->getData() as $itemData){
				$items[$index]['id'] =   $itemData['itemId'];
				$items[$index]['id_encrypt'] =  $algObj->encrypt($itemData['itemId']);
				$items[$index]['assignedBy'] =   $itemData['assignedBy'];
				$items[$index]['myTimeZone'] =   $timeZone;
				$items[$index]['description'] =   $generalObj->autolink($itemData['description']);
				$items[$index]['createdAt'] =   $itemData['createdAt'];
				$items[$index]['time'] =   $generalObj->rel_time($itemData['createdAt']);
				$items[$index]['title'] =   $generalObj->autolink($itemData['title']);
				$items[$index]['dueDate'] =   $itemData['dueDate'];
				$items[$index]['priority'] =   $itemData['priority'];
				$items[$index]['status'] =   $itemData['status'];
				$items[$index]['listName'] =   $itemData['listName'];
				$todoListsObj = new TodoLists();
				$ListData = $todoListsObj->getListOwner($itemData['createdBy']);
				$items[$index]['listOwner'] =   $ListData['firstName'].' '.$ListData['lastName'];
				$items[$index]['listcreatedBy'] =   $itemData['createdBy'];
				$items[$index]['assignedToFname'] =   $itemData['assignedToFname'];
				$items[$index]['assignedToLname'] =   $itemData['assignedToLname'];
				$items[$index]['assignedByFname']	=	$itemData['assignedByFname'];
				$items[$index]['assignedByLname']	=	$itemData['assignedByLname'];
								
				
				if(isset($itemData['attachmentIds']) && trim($itemData['attachmentIds'])!='') {
					$attachment	=	$attachmentObj->getAttachmentsById($itemData['attachmentIds']);
	
					if(trim($attachment['name'])!='')
					{
						$items[$index]['attachmentFile']	=	$attachment['name'];
						$attachmentDir	=	$algoencryptionObj->encrypt("USER_".$attachment['userId']);
						$items[$index]['attachmentDir']	=	$attachmentDir;
					}
				}
				$items[$index]['commentCount']	=	$commentsObj->getCommentsCount($itemData['itemId']);
				
				$index++;
		}
		
		return array('pagination'=>$dataProvider->pagination, 'items'=>$items);
	}
	
	public function getOtherToDoItemsUserWiseCount($id)
	{
		
		$algoencryptionObj	=	new Algoencryption();
		$todoListsObj = new TodoLists();
		$listsIds	=	array();
		$listsIds	=	$todoListsObj->getAllMyListIdsArray($id);
		
		$sql = "SELECT item.id as itemId,item.assignedBy as assignedBy,item.assignTo as assignTo,count(item.id) as total FROM todo_items item, todo_lists list, users u, login l WHERE item.assignTo = l.id AND l.userId = u.id AND list.id=item.listId AND item.status=1 AND item.assignTo !=".$id." and item.assignedBy not in (0,".$id.") and listId in (".implode(',',$listsIds).") group by assignTo order by total desc";
	  
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($count),
		));
		
		$items = array();
		$index = 0;
		$generalObj	=	new General();
		foreach($dataProvider->getData() as $itemData){
			
				$items[$index]['id'] =   $itemData['itemId'];
				$items[$index]['total'] =   $itemData['total'];
				$items[$index]['assignedBy'] =   $itemData['assignedBy'];
				$userObj = new Users();
				$res	=	$userObj->getUserDetail($itemData['assignTo']);
				$assignedTo=$res['result'];
				$items[$index]['assignedByFname']	=	$assignedTo['firstName'];
				$items[$index]['assignedByLname']	=	$assignedTo['lastName'];
				$index++;
		}
		
		return array('pagination'=>'', 'items'=>$items);
	}
	
	/*
	DESCRIPTION : GET ALL ITEMS ASSIGNED MY ME
	PARAMS : $id -> ASSIGNED BY ID
	*/
	public function getAssignedByMeItems($sessionArray=array(), $limit=5, $sortType='desc', $sortBy='itemId',$keyword=NULL, $assignTo='')
	{
		$id=$sessionArray['loginId'];
		$orderByidArray=array("itemId","assignedToFname","listName","title","dueDate","priority","status");
		if(!in_array($sortBy,$orderByidArray))
		{
			 $sortBy='itemId';
		}
		$search="";	
		
		if(trim($keyword)!="" || trim($assignTo)!='')
		{
			$search.= " HAVING ( ";
			if(trim($keyword)!="")
			{
				
				$search.= " item.title like '%".$keyword."%' or  list.name like '%".$keyword."%' or item.description like '%".$keyword."%' or item.dueDate like '%".$keyword."%' or item.id='".$keyword."'  or item.priority like '%".$keyword."%'  or  assignedToFname like '%".$keyword."%' or assignedToLname like '%".$keyword."%'";				
				if(isset($arr[1]))
				{
					$search.=" or assignedToLname like '%".$arr[1]."%' ";
				}
			}
			
			if(trim($assignTo)!='') {	
				$arr = explode(' ',trim($assignTo));
				if(trim($keyword)!="")
				{
					$search.=" and ";
				}
				$search.=	" ( assignedToFname like '%".$arr[0]."%'";
				if(isset($arr[1]))
				{
					$search.=" and assignedToLname like '%".$arr[1]."%' ";
				}
				$search.=" ) ";
			}
			
			$search.=" )";
			
		
		}
		
		
		$listSearch='';
		if(isset($sessionArray['mylist']) && $sessionArray['mylist']!=0)
		{
			$listSearch.='and item.listId='.$sessionArray['mylist'];
		}
		
		$listStatusSearch='';
		if(isset($sessionArray['mytodoStatus']) && $sessionArray['mytodoStatus']!=0)
		{
			$listStatusSearch.='and item.status='.$sessionArray['mytodoStatus'];
			if($sessionArray['mytodoStatus']==4)
			{
				$closeItems	=	'';
			}
		}
		$sql_assingToFname = "(select lu.firstName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignTo) as assignedToFname";
		
		$sql_assingToLname = "(select lu.lastName from login as lm left join users as lu on lm.userId=lu.id where lm.id=item.assignTo) as assignedToLname";
		
	 	   $sql = "SELECT item.id as itemId,item.creater,item.attachmentIds,item.assignToEmail,item.assignTo as assignTo,item.description,item.createdAt,item.title as title, item.dueDate as dueDate, item.priority as priority, item.status as status, list.name as listName,list.createdBy, u.id as uId, u.firstName as assignedByFname, u.lastName as assignedByLname,".$sql_assingToFname.",".$sql_assingToLname."
      FROM todo_items item, todo_lists list, users u, login l WHERE (item.status=u.byMeOpenStatus or item.status=u.byMeCloseStatus or item.status=u.byMeDoneStatus) AND  l.userId = u.id AND list.id=item.listId AND item.assignedBy=l.id  AND item.assignedBy =".$id." ".$listSearch." ".$listStatusSearch." ".$search." order by ".$sortBy." ".$sortType."";
		
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($count),
			'pagination'=>array(
				'pageSize'=>$limit,
			),
		));
		
		$items = array();
		$index = 0;
		
		$generalObj	=	new General();
		$attachmentObj	=	new Attachments();
		$algoencryptionObj	=	new Algoencryption();
		$commentsObj	=	new Comments();
		$userObj	=	new Users();
		$timeZone	=	$userObj->getTimeZone(Yii::app()->session['userId']);
		foreach($dataProvider->getData() as $itemData){
				$items[$index]['id'] =   $itemData['itemId'];
				
				$items[$index]['id_encrypt'] =  $algoencryptionObj->encrypt($itemData['itemId']);
				$items[$index]['assignTo'] =   $itemData['assignTo'];
				$items[$index]['myTimeZone'] =   $timeZone;
				$items[$index]['creater'] =   $itemData['creater'];
				$items[$index]['description'] =   $generalObj->autolink($itemData['description']);
				$items[$index]['createdAt'] =   $itemData['createdAt'];
				$items[$index]['time']	=	$generalObj->rel_time($itemData['createdAt']);
				$items[$index]['title'] =   $generalObj->autolink($itemData['title']);
				$items[$index]['dueDate'] =   $itemData['dueDate'];
				
				$items[$index]['dueDays']	=	$generalObj->rel_time($itemData['dueDate']);
				$items[$index]['priority'] =   $itemData['priority'];
				$items[$index]['status'] =   $itemData['status'];
				$items[$index]['listName'] =   $itemData['listName'];
				$items[$index]['assignedByFname'] =   $itemData['assignedToFname'];
				$items[$index]['assignedByLname'] =   $itemData['assignedToLname'];
				$todoListsObj = new TodoLists();
				$ListData = $todoListsObj->getListOwner($itemData['createdBy']);
				$items[$index]['listOwner'] =   $ListData['firstName'].' '.$ListData['lastName'];
				$items[$index]['listcreatedBy'] =   $itemData['createdBy'];
				if($itemData['assignTo']==0)
				{
					$items[$index]['assignedByFname']	=	$itemData['assignToEmail'];
					$items[$index]['assignedByLname']	=	'';
				}
							
				
				if(isset($itemData['attachmentIds']) && trim($itemData['attachmentIds'])!='') {
					$attachment	=	$attachmentObj->getAttachmentsById($itemData['attachmentIds']);
					if(trim($attachment['name'])!='')
					{
						$items[$index]['attachmentFile']	=	$attachment['name'];
						$attachmentDir	=	$algoencryptionObj->encrypt("USER_".$attachment['userId']);
						$items[$index]['attachmentDir']	=	$attachmentDir;
					}
				}
				$items[$index]['commentCount']	=	$commentsObj->getCommentsCount($itemData['itemId']);
				
				$index++;
		}
		
		
		return array('pagination'=>$dataProvider->pagination, 'items'=>$items);
	}
	
	public function getassingByMeItemsUserWiseCount($id)
	{
		$sql = "SELECT item.id as itemId,item.assignToEmail,item.assignTo as assignTo,count(*) as total FROM todo_items item, todo_lists list, users u, login l WHERE  l.userId = u.id AND list.id=item.listId AND item.assignedBy=l.id AND item.assignedBy =".$id." AND item.status=1 group by assignTo order by total desc";
		
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($count),
		));
		
		$items = array();
		$index = 0;
		$generalObj	=	new General();
		$algoencryptionObj	=	new Algoencryption();
		foreach($dataProvider->getData() as $itemData){
				$items[$index]['id'] =   $itemData['itemId'];
				$items[$index]['assignTo'] =   $itemData['assignTo'];
				$items[$index]['total'] =   $itemData['total'];
				if($itemData['assignTo']==0)
				{
					$items[$index]['assignedByFname']	=	$itemData['assignToEmail'];
					$items[$index]['assignedByLname']	=	'';
				}
				else
				{	
					$usersObj=new Users();
					$res	=	$usersObj->getUserDetail($itemData['assignTo']);
					$assignedTo  = $res['result']; 
					$items[$index]['assignedByFname'] =   $assignedTo['firstName'];
					$items[$index]['assignedByLname'] =   $assignedTo['lastName'];
				}
				$index++;
		}
		return array('pagination'=>'', 'items'=>$items);
	}
	
	/*
	DESCRIPTION : GET ITEM DETAILS BY ID
	PARAMS : $id -> ITEM ID
	*/
	public function getItemDetails($id=NULL, $fields='*', $autoLink=0)
	{
		$algo=new Algoencryption();
		if( !is_numeric($id) ) {
			$id	=	$algo->decrypt($id);
		}
		$item	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->where('id=:id', array(':id'=>$id))
					->queryRow();
		if(!isset($item['listId']))
		{
			return 0;
		}
		$listObj	=	new TodoLists();
		$usersObj	=	new Users();
		$loginObj	=	new Login();
		$generalObj	=	new General();
		$algObj = new Algoencryption();
		$timeZone	=	$usersObj->getTimeZone(Yii::app()->session['userId']);
		$item['listName']	=	$listObj->getMyListById($item['listId'], 'name');
		$item['id_encrypt']	=$algObj->encrypt($item['id']);;
		$item['myTimeZone']	=$timeZone;
		if(isset($item['attachmentIds']) && $item['attachmentIds']!='')
		{
			$AttachmentsObj=new Attachments();
			$attachData=$AttachmentsObj->getAttachmentsById($item['attachmentIds']);
			
			$item['attachmentFile']=$attachData['name'];
			
			$attachmentDir=$algo->encrypt("USER_".$attachData['userId']);
			$item['attachmentDir']=$attachmentDir;		
		}
		$res	=	$usersObj->getUserDetail($item['assignedBy']);
		$assignedBy = $res['result'];	
		$item['description']=$generalObj->autolink($item['description'], $autoLink);
		$item['title']=$generalObj->autolink($item['title'], $autoLink);
		if(isset($assignedBy['firstName']) && isset($assignedBy['lastName']))
		{
			$item['assignedByFname']	=	$assignedBy['firstName'];
			$item['assignedByLname']	=	$assignedBy['lastName'];
			$item['assignedByEmail']	=	$loginObj->getVerifiedEmailById($item['assignedBy']);
		}
		else
		{
			$item['assignedByFname']	=	'';
			$item['assignedByLname']	=	'';
			$item['assignedByEmail']	=	'';
		}
		
		if($item['assignTo'] == 0){
			$item['assignedToFname']	=	$item['assignToEmail'];
			$item['assignedToLname']	=	'';
		} else {
			$res =  $usersObj->getUserDetail($item['assignTo']);
			$assignedTo = $res['result'];
			$item['assignedToFname']	=	$assignedTo['firstName'];
			$item['assignedToLname']	=	$assignedTo['lastName'];
			$item['assignedToEmail']	=	$loginObj->getVerifiedEmailById($item['assignTo']);
		}
		
		return $item;
	}
	
	/*
	DESCRIPTION : GET MY TODO COUNT
	PARAMS : $id -> ASSIGNED TO ID
	*/
	public function getMyTodoCount($id=NULL)
	{
		$listId="";
		if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0)
		{
			$listId.=" AND item.listId=".$_REQUEST['mylist'];
		}
		$todoListsObj	=	new TodoLists();
		$listsIds	=	$todoListsObj->getAllMyListIdsArray($id);
		
		
		$sql = "SELECT count(item.id)  FROM todo_items item WHERE item.assignTo =".$id." AND item.status = 1 AND item.listId in (".implode(',',$listsIds).")".$listId;
		$todos	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $todos;
	}
	
	/*
	DESCRIPTION : GET ASSIGNED BY ME TODO COUNT
	PARAMS : $id -> ASSIGNED BY ID
	*/
	public function getByMeTodoCount($id=NULL)
	{
		$listId="";
		if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0)
		{
			$listId.=" AND item.listId=".$_REQUEST['mylist'];
		}
		$sql = "SELECT count(item.id) FROM todo_items item WHERE item.status=3 AND item.assignedBy =".$id.$listId;
		$todos	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $todos;
	}
	
	/*
	DESCRIPTION : GET OTHER TODO COUNT
	PARAMS : $id -> ASSIGNED TO ID
	*/
	public function getOtherTodoCount($id=NULL)
	{
		$todoListsObj	=	new TodoLists();
		$listsIds	=	$todoListsObj->getAllMyListIdsArray($id);
		
		$listId="";
		if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0)
		{
			$listId.=" AND item.listId=".$_REQUEST['mylist'];
		}
		$sql = "SELECT count(item.id) FROM todo_items item WHERE item.status=1 AND item.assignTo !=".$id." and item.assignedBy not in (0,".$id.") and listId in (".implode(',',$listsIds).") ".$listId;
	  
		$item_data	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $item_data;
	}
	
	/*
	DESCRIPTION : GET TODO ITEMS BY TODO LIST
	PARAMS : $listId -> TODO LIST ID
	*/
	public function getItemsByList($listId=NULL, $status=NULL)
	{
		$condition	=	'listId=:listId';
		$params[':listId']	=	$listId;
		if( isset($status) ) {
			$condition .= " and status=:status";
			$params[':status'] = $status;
		}
		//exit($condition);
		$items	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where($condition, $params)
					->queryAll();
		return $items;
	}
	
	/*
	DESCRIPTION : GET TODO ITEM ASSIGNED TO DETAILS
	PARAMS : $itemId -> TODO ITEM ID
	*/
	public function getAssignedUserByItem($itemId=NULL)
	{
		$user	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('id=:id', array(':id'=>$itemId))
					->queryRow();
		
		$userObj	=	new Users();
		if($user['assignTo'] == 0){
			$userDetail['loginId']	=	$user['assignToEmail'];
			$userDetail['id']	=	0;
		} else {
			$res  = 	$userObj->getUserDetail($user['assignTo']);
			$userDetail = $res['result'];
		}
		return $userDetail;
	}
	
	/*
	DESCRIPTION : GET TODO ITEM ASSIGNER DETAILS
	PARAMS : $itemId -> TODO ITEM ID
	*/
	public function getAssignerUserByItem($itemId=NULL)
	{
		$user	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('id=:id', array(':id'=>$itemId))
					->queryRow();
		if($user['assignedBy'] == 0){
			//$user	=	Yii::app()->session['loginId'];
			$user['assignedBy']	=	$user['assignTo'];
		}
		$userObj	=	new Users();
		$res	=	$userObj->getUserDetail($user['assignedBy']);
		$userDetail = $res['result'];
		return $userDetail;
	}
	
	/*
	DESCRIPTION : CHANGE TODO ITEM STATUS
	PARAMS : $itemId -> TODO ITEM ID,
			 $status -> OPEN(1), QA(2), RESOLVED(3) AND CLOSE(4)
	*/
	public function changeStatus($itemId=NULL, $status=1)
	{
		$itemData['status']	=	$status;
		$this->setData($itemData);
		$this->insertData($itemId);
	}
	
	public function assignBack($postData=NULL, $sessionArray=array())
	{
		if(isset($postData['id']) && !is_numeric($postData['id']))
		{
			$algoencryptionObj	=	new Algoencryption();
			$postData['id']=$algoencryptionObj->decrypt($postData['id']);				
		}
		$validation	=	new Validation();
		$result	=	$validation->assignBack($postData);
		
		if($result['status'] != 0) {
			return $result;
		} else {
			$itemDetails	=	$this->getItemDetails($postData['id']);
			
			$commetsObj	=	new Comments();
			$commentArray	=	array();
			$commentArray['listId']	=	$itemDetails['listId'];
			$commentArray['itemId']	=	$postData['id'];
			$commentArray['comments']	=	$postData['comments'];
			$commentArray['userId']	=	$sessionArray['loginId'];
			$commetsObj->addItemComments($commentArray, $sessionArray);
			
			$itemArray	=	array();
			$itemArray['assignTo']	=	$itemDetails['assignedBy'];
			$itemArray['assignedBy']	=	$itemDetails['assignTo'];
			$this->setData($itemArray);
			$this->insertData($postData['id']);
			
			$changeHistoryObj	=	new TodoItemChangeHistory();
			$historyArray	=	array();
			$historyArray['itemId']	=	$postData['id'];
			$historyArray['listId']	=	$itemDetails['listId'];
			$historyArray['assignedBy']	=	$itemArray['assignedBy'];
			$historyArray['assignTo']	=	$itemArray['assignTo'];
			$historyArray['action']	=	'assign back';
			$historyArray['createdAt']	=	date("Y-m-d H:i:s");
			$changeHistoryObj->setData($historyArray);
			$changeHistoryObj->insertData();
			
			return array('status'=>0, 'message'=>$this->msg['_ASSIGN_BACK_']);
		}
	}
	
	public function deleteItemById($id=NULL)
	{
		if(isset($id)) {
			$this->deleteByPk($id);
			return array('status'=>0, 'message'=>$this->msg['_TODO_ITEAM_DELETE_MESSAGE_']);
		} else {
			return array('status'=>$this->errorCode['_TODO_ITEAM_DELETE_'],'message'=>$this->msg['_TODO_ITEAM_DELETE_']);
			
		}
	}
	
	public function deleteItemsByListId($userId)
	{
		$condition = "assignedBy=:assignedBy or assignTo=:assignTo";
		
		$params[':assignedBy'] = $userId;
		$params[':assignTo'] = $userId;
		TodoItems::model()->deleteAll($condition,$params);
	}
	
	function getUpdatedCount($userId)
	{
		$queryOpenMy="SELECT count(id) from todo_items where status=1 and assignTo=".$userId;
		$queryOpenTo="SELECT count(id) from todo_items where status=1 and assignedBy=".$userId;	
		$queryInvite="SELECT count(id) from invites where receiverId=".$userId;	
		$resultOpenMy	=	Yii::app()->db->createCommand($queryOpenMy)
					->queryScalar();
		$resultOpenTo	=	Yii::app()->db->createCommand($queryOpenTo)
					->queryScalar();
		$resultInvite=	Yii::app()->db->createCommand($queryInvite)
					->queryScalar();
		return array("open"=>$resultOpenMy,"resolved"=>$resultOpenTo,"close"=>0,"invite"=>$resultInvite);		
	}
	
	public function getTotalItems($id)
	{
		$getTotalItems="SELECT count(id)  from todo_items where listId = ".$id;	
		$getTotalItems	=	Yii::app()->db->createCommand($getTotalItems)
					->queryScalar();
		return $getTotalItems;
	}
	
	public function getPendingItems($id)
	{
		$getPendingItems="SELECT count(id)  from todo_items where listId = ".$id." and status = 1";	
		$getPendingItems	=	Yii::app()->db->createCommand($getPendingItems)->queryScalar();
		return $getPendingItems;
	}
	
	
	public function getUsersAssignedToList($id=NULL)
	{
		
	}
	
	public function getMyAlert()
	{
		
	}
	
	function getItemCount($listId=NULL, $itemStatus=0)
	{
		
			$openItems	=	Yii::app()->db->createCommand()
							->select('count(id)')
							->from($this->tableName())
							->where('listId=:listId and status=:status',
									 array(':listId'=>$listId, ':status'=>1))
							->queryScalar();
							
			$doneItems	=	Yii::app()->db->createCommand()
							->select('count(id)')
							->from($this->tableName())
							->where('listId=:listId and status=:status',
									 array(':listId'=>$listId, ':status'=>3))
							->queryScalar();
							
			$closeItems	=	Yii::app()->db->createCommand()
							->select('count(id)')
							->from($this->tableName())
							->where('listId=:listId and status=:status',
									 array(':listId'=>$listId, ':status'=>4))
							->queryScalar();
							
			return array('open'=>$openItems, 'done'=>$doneItems, 'close'=>$closeItems);
		//}
						
		
	}
	
	
	
}