<?php

/**
 * This is the model class for table "invites".
 *
 * The followings are the available columns in table 'invites':
 * @property integer $id
 * @property integer $listId
 * @property integer $senderId
 * @property integer $receiverId
 * @property string $role
 * @property string $status
 * @property string $createdAt
 */
class Invites extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invites the static model class
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
		return 'invites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('listId, senderId, receiverId, createdAt', 'required'),
			//array('listId, senderId, receiverId', 'numerical', 'integerOnly'=>true),
			//array('role, status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, listId, senderId, receiverId, role, status, createdAt', 'safe', 'on'=>'search'),
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
			'senderId' => 'Sender',
			'receiverId' => 'Receiver',
			'role' => 'Role',
			'status' => 'Status',
			'createdAt' => 'Created At',
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
		$criteria->compare('listId',$this->listId);
		$criteria->compare('senderId',$this->senderId);
		$criteria->compare('receiverId',$this->receiverId);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('createdAt',$this->createdAt,true);

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
	DESCRIPTION : GET INVITES BY RECEIVER ID
	PARAMS : $Id -> RECEIVER ID,
			 $status -> REJECTED (0), ACCEPTED (1), PENDING (2) AND ALL INVITES (NULL)
	*/
	
	function chkInvited($listId,$senderId,$receiverId)
	{
		$inviteId	=	Yii::app()->db->createCommand()
					->select('id')
					->from($this->tableName())
					->where('listId=:listId and senderId=:senderId and receiverId=:receiverId', array(':listId'=>$listId,':senderId'=>$senderId,':receiverId'=>$receiverId))
					->queryScalar();
		return $inviteId;			
	}
	
	function totalInvitesByReceiverId($id)
	{
		$inviteId	=	Yii::app()->db->createCommand()
					->select('count(id)')
					->from($this->tableName())
					->where("status='2' and receiverId=".$id)
					->queryScalar();
		return $inviteId;	
	}
	
	public function getInvitesByReceiverId($id=NULL,$status=NULL,$sortType="desc",$sortBy="id",$limit=LIMIT_10)
	{
		$cond ='';
		if(isset($status) && !is_null($status)){
			$cond .= "and i.status='".$status."'";
		}
		
		 $sql_invites = "select i.id,li.name as listName,(select u.firstName from users u,login l  where l.userId=u.id and  l.id=i.senderId) as firstName,(select u.lastName from users u,login l  where l.userId=u.id and  l.id=i.senderId) as lastName,(select u.firstName from users u,login l  where l.userId=u.id and  l.id=li.createdBy) as ownerFirstName,(select u.lastName from users u,login l  where l.userId=u.id and  l.id=li.createdBy) as ownerLastName,i.role,i.status,i.createdAt from invites i,users u,login l,todo_lists li where i.receiverId = l.id and l.userId=u.id and i.listId = li.id and i.receiverId=".$id." ".$cond." order by ".$sortBy."  ".$sortType."";
		
		$sql_invites_count = "select count(*) as total from invites i,users u,login l,todo_lists li where i.receiverId = l.id and l.userId=u.id and i.listId = li.id and i.receiverId=".$id." ".$cond ;	
		$res	=	Yii::app()->db->createCommand($sql_invites_count)->queryScalar();
		$invites=new CSqlDataProvider($sql_invites, array(
			'totalItemCount'=>$res,
						'pagination'=>array(
							'pageSize'=>$limit,
			),
		));
		
		$usersObj	=	new Users();
		$todoListsObj	=	new TodoLists();
		$algoencryptionObj	=	new Algoencryption();
		$generalObj	=	new General();
		$index=0;$invite=array();
		foreach($invites->getData() as $invitation){ 
			
			$invite[$index]['senderFirstName']	=	$invitation['firstName'];
			$invite[$index]['senderLastName']	=	$invitation['lastName'];
			$invite[$index]['listcreatedBy']	=	$invitation['firstName'].' '.$invitation['lastName'];
			$invite[$index]['listOwner']	=	$invitation['ownerFirstName'].' '.$invitation['ownerLastName']; 
			$invite[$index]['listName']	=	$invitation['listName'];
			$invite[$index]['role']	=	$invitation['role'];
			$invite[$index]['id']	=	$invitation['id'];
			$invite[$index]['id_encrypt']	=	$algoencryptionObj->encrypt($invitation['id']);
			$invite[$index]['status']	=	$invitation['status'];
			$invite[$index]['time']	=	$generalObj->rel_time($invitation['createdAt']);
			
			$index++;
		}
		return array('pagination'=>$invites->pagination, 'invites'=>$invite);
	}
	
	/*
	DESCRIPTION : GET INVITES BY ID
	PARAMS : $Id -> ID
	*/
	public function getInviteById($id=NULL, $fields='*')
	{
		$algObj = new Algoencryption();
		if(!is_numeric($id))
		{
			$id  =  $algObj->decrypt($id);
		}
		$invite	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->where('id=:id', array(':id'=>$id))
					->queryRow();
					
		$generalObj	=	new General();
		$invite['time']	=	$generalObj->rel_time($invite['createdAt']);
		$invite['id_encrypt']	=	 $algObj->encrypt($id);
		
		return $invite;
	}
	
	public function invite($get)
	{
		$comments = new Invites();
		$comments->setData($get);
		$comments->setIsNewRecord(true);
		$userId=$User->insertData();
		return $userId;
	}
	
	/*
	DESCRIPTION : CHANGE INVITATION STATUS
	PARAMS : $id -> INVITATION ID,
			 $status -> REJECTED (0), ACCEPTED (1) AND PENDING (2)
	*/
	public function changeStatus($id=NULL, $status=2)
	{
		$algo=new Algoencryption();
		if( !is_numeric($id) ) {
			$id	=	$algo->decrypt($id);
		}
		$this->setData(array('status'=>$status));
		$this->insertData($id);
		if($status==1)
		{
			$invite	=	Yii::app()->db->createCommand()
						->select('*')
						->from($this->tableName())
						->where('id=:id', array(':id'=>$id))	
						->queryRow();
			if(!empty($invite))
			{			
			$todonetworkObj = new Todonetwork();
			$isInNetwork=$todonetworkObj->checkInNetwork($invite['senderId'],$invite['receiverId']);
			if(!$isInNetwork)
			{
				$toDoNetworkArr = array();
				$toDoNetworkArr['userId'] = $invite['receiverId'];
				$toDoNetworkArr['networkId'] = $invite['senderId'];
				$toDoNetworkArr['listId'] = $invite['listId'];
				$toDoNetworkArr['created'] = date("Y-m-d H:i:s");
				$todonetworkObj->setData($toDoNetworkArr);
				$todonetworkObj->insertData();
				
				$toDoNetworkArr = array();
				$todonetworkObj = new Todonetwork();
				$toDoNetworkArr['userId'] = $invite['senderId'];
				$toDoNetworkArr['networkId'] = $invite['receiverId'];
				$toDoNetworkArr['listId'] = $invite['listId'];
				$toDoNetworkArr['created'] = date("Y-m-d H:i:s");
				$todonetworkObj->setData($toDoNetworkArr);
				$todonetworkObj->insertData();
			}
			}
			return json_encode(array('status'=>0, 'message'=>$this->msg['_INVITE_ACCEPT_']));
		}
		else
		{
			return json_encode(array('status'=>1, 'message'=>"error"));
		}
	}
	
	
	
	public function getDistinctTodoList($id=NULL)
	{
		$todoLists	=	Yii::app()->db->createCommand()
						->select('*')
						->from($this->tableName())
						->where('receiverId=:receiverId', array(':receiverId'=>$id))	
						->queryAll();
		
		$todoListObj	=	new TodoLists();
		$usersObj	=	new Users();
		$index	=	0;
		foreach($todoLists as $list){
			$listName	=	$todoListObj->getMyListById($list['listId']);
			$todoLists[$index]['listName']	=	$listName['name'];
			$todoLists[$index]['description']	=	$listName['description'];
			$todoLists[$index]['key']	=	$listName['key'];
			
			$assignedTo	=	$usersObj->getUserById($listName['createdBy']);
			$todoLists[$index]['createdByFname']	=	$assignedTo['firstName'];
			$todoLists[$index]['createdByLname']	=	$assignedTo['lastName'];
			
			$index++;
		}
		return $todoLists;
	}
	
	public function checkInviteUser($listId,$reciverId)
	{
		$todoLists	=	Yii::app()->db->createCommand()
						->select('*')
						->from($this->tableName())
						->where('listId=:listId and receiverId=:receiverId', array(':listId'=>$listId,':receiverId'=>$reciverId))	
						->queryRow();
		if(empty($todoLists))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function isExistInviteUser($listId,$reciverId,$senderId)
	{
		$id	=	Yii::app()->db->createCommand()
						->select('id')
						->from($this->tableName())
						->where('listId=:listId and receiverId=:receiverId and senderId=:senderId',array(':listId'=>$listId,':receiverId'=>$reciverId,':senderId'=>$senderId))	
						->queryScalar();
		return $id;		
	}
	
	
	
	public function getListMembers($id)
	{
		$algObj = new Algoencryption();
		if(!is_numeric($id))
		{
			$id  =  $algObj->decrypt($id);
		}
		$users = array();
		$sql = "select * from invites i, login l,users u where i.receiverId=l.id and l.userId=u.id and i.listId = ".$id." and i.receiverId != ''  group by i.receiverId";
		$res	=	Yii::app()->db->createCommand($sql)->queryAll();
		$list_data=new CSqlDataProvider($sql, array(
			'totalItemCount'=>count($res),
						'pagination'=>array(
							'pageSize'=>5,
			),
		));
		
		$index  =   0;
		$lists	=	array();
		foreach($list_data->getData() as $listData){
				$userObj =  new Users();
				$generalObj	=	new General();
				
				$listData['time']	=	$generalObj->rel_time($listData['createdAt']);
				
				if(isset($listData['firstName']) && isset($listData['lastName']))	
				{
					$lists[] = $listData;
					
				}
				$index++;
		}
		
		return array('pagination'=>$list_data->pagination, 'users'=>$lists);
	}
	
	public function deleteInvitesByListId($userId)
	{
		$algObj = new Algoencryption();
		if(!is_numeric($userId))
		{
			$userId  =  $algObj->decrypt($userId);
		}
		$condition = "senderId=:senderId or receiverId=:receiverId";
		$params[':senderId'] = $userId;
		$params[':receiverId'] = $userId;
		Invites::model()->deleteAll($condition,$params);
	}
	
	public function deleteInvites($id)
	{
		$algObj = new Algoencryption();
		if(!is_numeric($id))
		{
			$id  =  $algObj->decrypt($id);
		}
		$this->deleteByPk($id);
		return json_encode(array('status'=>0, 'message'=>$this->msg['_INVITE_DELETE_']));
	}
	
	public function getInviterByInviteId($id)
	{
		$inviter	=	Yii::app()->db->createCommand()
						->select('senderId')
						->from($this->tableName())
						->where('id=:id', array(':id'=>$id))
						->queryScalar();
						
		$usersObj	=	new Users();
		$inviterDetails	=	$usersObj->getUserById($inviter, 'firstName, lastName');
		return $inviterDetails;
	}
	
	
}