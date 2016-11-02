<?php

/**
 * This is the model class for table "todo_lists".
 *
 * The followings are the available columns in table 'todo_lists':
 * @property string $id
 * @property string $name
 * @property string $key
 * @property string $description
 * @property string $createdBy
 * @property string $status
 * @property string $createdAt
 * @property string $modifiedAt
 */
class TodoLists extends CActiveRecord
{
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TodoLists the static model class
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
		return 'todo_lists';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('name, key, description, createdBy, createdAt, modifiedAt', 'required'),
			//array('name', 'length', 'max'=>255),
			//array('key', 'length', 'max'=>5),
			//array('createdBy', 'length', 'max'=>20),
			//array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, name, key, description, createdBy, status, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'key' => 'Key',
			'description' => 'Description',
			'createdBy' => 'Created By',
			'status' => 'Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('createdBy',$this->createdBy,true);
		$criteria->compare('status',$this->status,true);
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
	
	function callDaemon($daemon_name = "hirenow") {
        $sig = new signals_lib();
        $sig->get_queue($this->arr[$daemon_name]);
        $sig->send_msg($daemon_name);
    }
	
	
	function addInviteUser($data,$sessionArray=array())
	{
		$error=array();
		$success=array();
		if(isset($data['userlist']) && $data['userlist'] != '')
		{
			$userlist = explode(',',$data['userlist']);
			
			for($i=0;$i<count($userlist);$i++)
			{
				if(trim($userlist[$i])!="")
				{
					$validationOBJ = new Validation();
					$res = $validationOBJ->is_valid_email($userlist[$i]);
					if($res == true)
					{
						$userObj = new Users();
						$loginObj = new Login();
						$result1 = array();
						$result1 = $loginObj->getUserByEmail($userlist[$i]);
					
						if(isset($result1) && $result1['id'] != $data['createdBy'])
						{
							if(!empty($result1))
							{
								$invitesObj =  new Invites();
								$isInvited=$invitesObj->chkInvited($data['listId'],$data['createdBy'],$result1['id']);
								$isInvitedInverse=$invitesObj->chkInvited($data['listId'],$result1['id'],$data['createdBy']);
								if($isInvited || $isInvitedInverse)
								{								
									$error[] = array("email"=>$userlist[$i],"message"=>$this->msg['_INVITE_MESSAGE_']);	
								}
								else
								{
									
									$inviteArr = array();
									$inviteArr['listId'] = $data['listId'];
									$inviteArr['senderId'] = $data['createdBy'];
									$inviteArr['receiverId'] = $result1['id'];
									$inviteArr['createdAt'] = date("Y-m-d H:i:s");
									$invitesObj->setData($inviteArr);
									$invId = $invitesObj->insertData();
									
									$todonetworkObj = new Todonetwork();
									$isInNetwork=$todonetworkObj->checkInNetwork( $data['createdBy'],$result1['id']);
									if(!$isInNetwork)
									{
									$toDoNetworkArr = array();
									$toDoNetworkArr['userId'] = $data['createdBy'];
									$toDoNetworkArr['networkId'] = $result1['id'];
									$toDoNetworkArr['listId'] = $data['listId'];
									$toDoNetworkArr['created'] = date("Y-m-d H:i:s");
									$todonetworkObj->setData($toDoNetworkArr);
									$todonetworkObj->insertData();
					
									$toDoNetworkArr = array();
									$todonetworkObj = new Todonetwork();
									$toDoNetworkArr['userId'] = $result1['id'];
									$toDoNetworkArr['networkId'] = $data['createdBy'];
									$toDoNetworkArr['listId'] = $data['listId'];
									$toDoNetworkArr['created'] = date("Y-m-d H:i:s");
									$todonetworkObj->setData($toDoNetworkArr);
									$todonetworkObj->insertData();
									}
									$algObj = new Algoencryption();
									$invId = $algObj->encrypt($invId);
									$registerLink=Yii::app()->params->base_path."site/signin/userId/".$invId;
									$to      = $result1['loginId'];
									$subject = 'Invites On Todooli';
									$Yii = Yii::app();	
									$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/invite-registerconfirmation-link';
									$message = file_get_contents($url);
									$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
									$message = str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
									$message = str_replace("_REGISTER_",$registerLink,$message);
									$helperObj=new Helper();
									$helperObj->mailSetup($to,$subject,$message,$data['createdBy'],$result1['id']);
									$success[] = array("email"=>$userlist[$i],"message"=>" invited successfully.");
								
								}
								
								
							}
							else
							{
								
									$registerLink=Yii::app()->params->base_path."site/signUpMain&userId=".$data['createdBy']."&listId=".$data['listId']."&email=".$userlist[$i];
									$listName = $this->getMyListById($data['listId']);		
									$to      = $userlist[$i];
									$subject = 'Invites On Todooli';
									$Yii = Yii::app();	
									$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/invite-confirmation-link';
									$message = file_get_contents($url);
									$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
									$message = str_replace("_ASSIGNER_",$sessionArray['fullname'],$message);
									$message = str_replace("_LISTNAME_",$listName['name'],$message);				
									$message = str_replace("_INVITE_",$registerLink,$message);
									$helperObj=new Helper();
									$helperObj->mailSetup($to,$subject,$message,$data['createdBy'],0);
									
									$success[] = array("email"=>$userlist[$i],"message"=>$this->msg['_INVITE_SEND_MESSAGE_']);
								
							}
							
						}
						else
						{
							//$this->msg['_INVITE_INVALID_MESSAGE_']
							$error[] = array("email"=>$userlist[$i],"status"=>$this->errorCode['_INVITE_INVALID_MESSAGE_'],"message"=>" You can't invite yourself.");
						}
					
				  }
				  else
					{
						$error[] = array("email"=>$userlist[$i],"status"=>$this->errorCode['_INVITE_INVALID_MESSAGE_'],"message"=>$this->msg['_INVITE_INVALID_MESSAGE_']);
					}
				  
			}
		 }
		}
		return array($success,$error);	
	}
	
	public function inviteOnRegister($data)
	{
			$invitesObj =  new Invites();
			$isInvited=$invitesObj->chkInvited($data['listId'],$data['createdBy'],$data['receiverId']);
			
			if(!$isInvited)
			{
				$inviteArr = array();
				$inviteArr['listId'] = $data['listId'];
				$inviteArr['senderId'] = $data['createdBy'];
				$inviteArr['status'] = 1;
				$inviteArr['receiverId'] = $data['receiverId'];
				$inviteArr['createdAt'] = date("Y-m-d H:i:s");
				$invitesObj->setData($inviteArr);
				$invitesObj->insertData();
			}
			
			$todonetworkObj = new Todonetwork();
			$isInNetwork=$todonetworkObj->checkInNetwork( $data['createdBy'],$data['receiverId']);
			if(!$isInNetwork)
			{
				$toDoNetworkArr = array();
				$toDoNetworkArr['userId'] = $data['createdBy'];
				$toDoNetworkArr['networkId'] = $data['receiverId'];
				$toDoNetworkArr['listId'] = $data['listId'];
				$toDoNetworkArr['created'] = date("Y-m-d H:i:s");
				$todonetworkObj->setData($toDoNetworkArr);
				$todonetworkObj->insertData();
				
				$toDoNetworkArr = array();
				$todonetworkObj = new Todonetwork();
				$toDoNetworkArr['userId'] = $data['receiverId'];
				$toDoNetworkArr['networkId'] = $data['createdBy'];
				$toDoNetworkArr['listId'] = $data['listId'];
				$toDoNetworkArr['created'] = date("Y-m-d H:i:s");
				$todonetworkObj->setData($toDoNetworkArr);
				$todonetworkObj->insertData();
			}	
	}
			
	/*
	DESCRIPTION : GET ALL LISTS WITH PAGINATION
	*/
	public function getAllPaginatedLists($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		
 		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (
name like '%".$keyword."%' or description='%".$keyword."%' or l.loginId='%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and t.createdAt > '".date("Y-m-d",strtotime($startDate))."' and t.createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}

		 $sql_list = "select t.id,t.name,t.description,t.createdAt,t.modifiedAt,u.firstName,u.lastName from todo_lists t,users u,login l where t.name not like 'self' and t.createdBy = l.id and l.userId = u.id ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		 $sql_count = "select count(*) from todo_lists t,users u,login l where t.name not like 'self' and t.createdBy = l.id and l.userId = u.id ".$search." ".$dateSearch."";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_list, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>$limit,
						),
					));
		
		return array('pagination'=>$item->pagination, 'lists'=>$item->getData());
	}
	
	public function getMyList($user)
	{
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->where('createdBy=:createdBy', array(':createdBy'=>$user))	
   	 	->queryAll();	
		return $result;	
	}
	

	
	/*
	DESCRIPTION : GET LIST BY ID
	PARAMS : $Id -> LIST ID
	*/
	public function getMyListById($id=NULL, $fields='*')
	{
		$list	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->where('id=:id', array(':id'=>$id))	
					->queryRow();
					
		return $list;
	}
	
	public function getReminderListByIds($lists=NULL, $fields='*')
	{
		$list	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->where(array('in', 'id', $lists))
					//->where('id=:id', array(':id'=>$id))	
					->queryAll();
					
		return $list;
	}
	
	/*
	DESCRIPTION : GET ALL LISTS
	*/
	public function getAllLists($fields='*')
	{
		$lists	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->queryAll();
					
		return $lists;
	}
	
	/*
	DESCRIPTION : GET ALL LISTS
	*/
	public function getListsForStatistics($fields='*')
	{
		 $sql = "SELECT  * from todo_lists where name != 'self'";
		 $arr	=	Yii::app()->db->createCommand($sql)->queryAll();
		 return $arr;
	}
	
	/*
	DESCRIPTION : GET ALL MY TODO LISTS
	PARAMS : $id -> USER ID
	*/
	public function getAllMyList($id=NULL,$limit=NULL)
	{
		
		 $sql = "SELECT  list.id,list.name,u.firstName,u.lastName,list.description,list.createdBy,list.createdAt FROM todo_lists as list ,login l, users as u where list.createdBy = l.id and l.userId = u.id  and (list.`createdBy`= ".$id."  or list.`id` in(select listId from invites where receiverId=".$id." and status='1')) group by list.`id`";
		$arr	=	Yii::app()->db->createCommand($sql)->queryAll();

		
		 $sql_dupl = "SELECT  lower(list.name) FROM todo_lists as list where (list.`createdBy`= ".$id."  or list.`id` in(select listId from invites where receiverId=".$id." and status='1')) group by UPPER(list.name) Having count(list.name) > 1";
		$list_dupl	=	Yii::app()->db->createCommand($sql_dupl)->queryColumn();
		$generalObj = new General();
		$userObj =  new Users();
		$todoItemsObj	=	new TodoItems();
		$algoencryptionObj	=	new Algoencryption();
  		$index = 0;	
		$finalArray = array();	
		$pendingItems=0;
		$finalArray['pendingItems']=0;
		foreach($arr as $itemData){
			$finalArray[$index]['id']  =  $itemData['id'];
			$finalArray[$index]['id_encrypt']  =  $algoencryptionObj->encrypt($itemData['id']);
			$finalArray[$index]['name']=$itemData['name'];
			if(!empty($list_dupl))
			{
				if(in_array(strtolower($itemData['name']),$list_dupl))
				{
					$finalArray[$index]['name']  =  $itemData['name'].'  ['.$itemData['firstName'].' '.$itemData['lastName'].']';
				}
			}
			
			$finalArray[$index]['description']  =  $itemData['description'];
			$finalArray[$index]['createdBy']  =  $itemData['createdBy'];
			$finalArray[$index]['firstName']	=	$itemData['firstName'];
			$finalArray[$index]['lastName']	=	$itemData['lastName'];
			$finalArray[$index]['createdAt']  =  $itemData['createdAt'];
   			$finalArray[$index]['time'] = $generalObj->rel_time($itemData['createdAt']);
			$finalArray[$index]['pendingItems'] =	$todoItemsObj->getPendingItems($itemData['id']);
			$finalArray['pendingItems'] =   $finalArray['pendingItems'] + $finalArray[$index]['pendingItems'];
			$index++;
		}
		return $finalArray;
		
	}
	
	public function getAllMyListIdsArray($id=NULL,$limit=NULL)
	{
		
		$sql = "SELECT  list.id FROM todo_lists as list ,login l, users as u where list.createdBy = l.id and l.userId = u.id  and (list.`createdBy`= ".$id."  or list.`id` in(select listId from invites where receiverId=".$id." and status='1')) group by list.`id`";
	
		$arr	=	Yii::app()->db->createCommand($sql)->queryColumn();
		return $arr;
		
	}
	
	public function myLists($id=NULL,$limit=5,$sortType="desc",$sortBy="id",$keyword=NULL)
	{
		$search='';
		if($keyword==NULL)
		{
			$search='';
		}
		else
		{
			$search = " and list.name like '%".$keyword."%' ";
		}
		$getTotalItems="(SELECT count(id)   from todo_items where listId = list.`id`) as totalItems";	
		$getPendingItems="(SELECT count(id)  from todo_items where listId = list.`id` and status = 1) as pendingItems";	
		$sql = "SELECT  list.id,list.name,u.firstName,u.lastName,list.description,list.createdBy,list.createdAt,".$getTotalItems.",".$getPendingItems." FROM todo_lists as list ,login l, users as u where list.createdBy = l.id and l.userId = u.id ".$search." and (list.`createdBy`= ".$id."  or list.`id` in(select listId from invites where receiverId=".$id." and status='1'))   group by list.`id` order by ".$sortBy."  ".$sortType."";
		
		$count_sql = "SELECT  count(*) FROM todo_lists as list ,login l, users as u where list.createdBy = l.id and l.userId = u.id ".$search." and (list.`createdBy`= ".$id."  or list.`id` in(select listId from invites where receiverId=".$id." and status='1')) ";
		
		$count	=	Yii::app()->db->createCommand($count_sql)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>$limit,
						),
					));
		$generalObj = new General();
		$userObj =  new Users();
		$algoencryptionObj	=	new Algoencryption();
  		$index = 0;	
		$finalArray = array();		
		foreach($item->getData() as $itemData){ 
			$finalArray[$index]['id']  =  $itemData['id'];
			$finalArray[$index]['id_encrypt']  =  $algoencryptionObj->encrypt($itemData['id']);
			$finalArray[$index]['name']  =  $itemData['name'];
			$finalArray[$index]['description']  =  $itemData['description'];
			$finalArray[$index]['createdBy']  =  $itemData['createdBy'];
			$finalArray[$index]['totalItems']  =  $itemData['totalItems'];
			$finalArray[$index]['pendingItems']  =  $itemData['pendingItems'];
			$res =	$userObj->getUserDetail($itemData['createdBy']);
			$assignedTo = $res['result'];	
			$finalArray[$index]['firstName']	=	$assignedTo['firstName'];
			$finalArray[$index]['lastName']	=	$assignedTo['lastName'];
			$finalArray[$index]['createdAt']  =  $itemData['createdAt'];
   			$finalArray[$index]['time'] = $generalObj->rel_time($itemData['createdAt']);
   			$index++;
		}
		return array('pagination'=>$item->pagination,"items"=>$finalArray);
	}
	
	
	public function getUserToDoList($id=NULL)
	{
		$result	=	Yii::app()->db->createCommand()
						->select('*')
						->from($this->tableName())
						->where('createdBy=:createdBy', array(':createdBy'=>$id))
						->queryAll();
		return $result;
	}
	
	public function getListOwner($id=NULL)
	{
		$sql = "select u.firstName,u.lastName from todo_lists as list ,login l, users as u where list.createdBy = l.id and l.userId = u.id and list.createdBy = ".$id."";
		return Yii::app()->db->createCommand($sql)->queryRow();
		
	}
	
	/*
	DESCRIPTION : GET ITEM DETAILS BY ID
	PARAMS : $id -> ITEM ID
	*/
	public function getListDetails($id=NULL, $fields='*')
	{
		$algObj = new Algoencryption();
		if(!is_numeric($id))
		{
			$id  =  $algObj->decrypt($id);
		}
		
		$item	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->where('id=:id', array(':id'=>$id))
					->queryRow();
		
		$listObj	=	new TodoLists();
		$usersObj	=	new Users();
		if(isset($item['id']) && $item['id']!='')
		{
			$item['listName']	=	$listObj->getMyListById($item['id'], 'name');
			$res  = 	$usersObj->getUserDetail($item['createdBy']);
			$assignedBy = $res['result'];
			$item['assignedByFname']	=	$assignedBy['firstName'];
			$item['assignedByLname']	=	$assignedBy['lastName'];
	
			$res =	$usersObj->getUserDetail($item['createdBy']);
			$assignedTo = $res['result'];
			$item['assignedToFname']	=	$assignedTo['firstName'];
			$item['assignedToLname']	=	$assignedTo['lastName'];
			
			$generalObj	=	new General();
			$item['time']	=	$generalObj->rel_time($item['createdAt']);
			$item['id_encrypt']	=	 $algObj->encrypt($item['id']);
		}
		return $item;
	}
	
	public function deleteToDoList($id)
	{
		$condition = "createdBy=:createdBy";
		$params[':createdBy'] = $id;			
		TodoLists::model()->deleteAll($condition,$params);			
		
	}
	
	public function deleteList($id)
	{
		$todoNetwork=TodoLists::model()->findbyPk($id);
		$todoNetwork->delete();	
		
		$condition = "listId=:listId";
		$params[':listId'] = $id;			
		TodoItems::model()->deleteAll($condition,$params);
		
		$condition = "listId=:listId";
		$params[':listId'] = $id;			
		Invites::model()->deleteAll($condition,$params);	
		
		$condition = "listId=:listId";
		$params[':listId'] = $id;			
		Reminder::model()->deleteAll($condition,$params);	
		
		$condition = "listId=:listId";
		$params[':listId'] = $id;			
		Reminder::model()->deleteAll($condition,$params);	
		
		$condition = "listId=:listId";
		$params[':listId'] = $id;			
		Comments::model()->deleteAll($condition,$params);	
		
				
	}
	
	public function checkList($listName,$createdBy)
	{
		$item	=	Yii::app()->db->createCommand()
					->select('id')
					->from($this->tableName())
					->where('name=:name and createdBy=:createdBy', array(':name'=>$listName,'createdBy'=>$createdBy))
					->queryScalar();
		return $item;
	}
	
	public function SaveTodoList($post,$sessionArray=NULL)
	{
		
		$validationObj = new Validation();
		$res = $validationObj->saveToDoList($post['todoList']);
		if($res['status'] != 0)
		{
			return $res;
			exit;
		}
		$data['name'] = $post['todoList'];
		$data['description'] = $post['description'];
		$data['createdBy'] = Yii::app()->session['loginId'];
		$data['createdAt'] = date('Y-m-d H:i:s');
		$this->setData($data);
		$id = $this->insertData();
		
		//$id = Yii::app()->db->getLastInsertID();
		$todoListObj = new TodoLists();
		$post['listId']=$id;
		$post['createdBy']=Yii::app()->session['loginId'];
		$sessionArray['loginId']=$sessionArray['loginId'];
		$sessionArray['fullname']=$sessionArray['fullname'];
		$res = $todoListObj->addInviteUser($post,$sessionArray);
		return $res;
	}
	
}