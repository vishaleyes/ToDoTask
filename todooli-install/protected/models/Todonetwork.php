<?php

/**
 * This is the model class for table "todonetwork".
 *
 * The followings are the available columns in table 'todonetwork':
 * @property integer $id
 * @property integer $userId
 * @property integer $networkId
 * @property integer $listId
 * @property string $created
 */
class Todonetwork extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Todonetwork the static model class
	 */
	public $msg;
	public $errorCode;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'todonetwork';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('userId, networkId, listId', 'numerical', 'integerOnly'=>true),
			//array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, userId, networkId, listId, created', 'safe', 'on'=>'search'),
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
			'networkId' => 'Network',
			'listId' => 'List',
			'created' => 'Created',
		);
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('networkId',$this->networkId);
		$criteria->compare('listId',$this->listId);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function checkInNetwork($userId,$userlist)
	{
		$result = Yii::app()->db->createCommand()
    	->select('id')
    	->from($this->tableName())
   	 	->where('userId=:userId and networkId=:networkId', array(':userId'=>$userId,':networkId'=>$userlist))	
   	 	->queryScalar();
		return $result;
	}
	
	public function getMyNetwork($id)
	{
		 $query = "select users.id,todonetwork.id as todoid,users.firstName,users.lastName,todo_lists.name,login.loginId,todonetwork.created from todonetwork,users,todo_lists,login where todonetwork.networkId = login.id and todonetwork.listId = todo_lists.id and users.id = login.userId and todonetwork.userId = ".$id." order by todonetwork.id desc";
		$dataProvider=new CSqlDataProvider($query, array(		
		));
		
		return $dataProvider;
	}
	
	public function getNetworkDropdown($userId,$assignTo=0)
	{
		$result = Yii::app()->db->createCommand("select DISTINCT(login.loginId) from todonetwork,login where todonetwork.networkId = login.id and todonetwork.userId = ".$userId." order by todonetwork.id desc")
    	->queryAll();
		$loginObj=new Login();
		$html='<select id="value" name="value" >';
		foreach($result as $data)
		{
			$selected="";
			if($assignTo==$data['loginId'])
			{
				$selected='selected="selected"';	
			}
			$html.='<option '.$selected.' value="'.$data['loginId'].'">'.$data['loginId'].'</option>';
		}
		$html.='</select>';
		return $html;
	}
	
	
	public function getNetworkUserDetail($id)
	{
		$query = "select users.id,todonetwork.id as todoid,users.firstName,users.lastName,todo_lists.name as listName,login.loginId,todonetwork.created from todonetwork,users,todo_lists,login where todonetwork.networkId = login.id and todonetwork.listId = todo_lists.id and users.id = login.userId and todonetwork.id = ".$id."";
		$dataProvider=new CSqlDataProvider($query, array(		
		));
		
		$generalObj	=	new General();
		foreach($dataProvider->getData() as $data){
			$data['time']	=	$generalObj->rel_time($data['created']);
			$dataProvider->setData($data);
		}
		return $dataProvider;
	}
	
	public function checkNetworkUser($user,$networkuser)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('id')
					->from($this->tableName())
					->where('userId=:userId and networkId=:networkId', array(':userId'=>$user,':networkId'=>$networkuser))
					->queryScalar();
		return  $result;
	}
	
	public function insertNetwork($data)
	{
		$todonetworkObj = new Todonetwork();
		$data['created'] = date("Y-m-d H:i:s");
		$todonetworkObj->setData($data);
		return $todonetworkObj->insertData();
	}
	
	/*
	DESCRIPTION : GET MY PAGINATED NETWORK
	*/
	public function getMyPaginatedNetwork($id=NULL, $limit=10, $sortType='desc', $sortBy='id',$keyword=NULL)
	{
		if($keyword=="")
		{
			$search = "";
		}
		else
		{
			$search = "and (u.firstName like '%".$keyword."%' or u.lastName like '%".$keyword."%' or l.loginId like '%".$keyword."%')";
		}
		  $sql = "select distinct(networkId),count(*) as total,network.id as netId,listId,network.created,u.*,l.loginId from todonetwork as network,login as l,users as u where  network.networkId = l.id and l.userId = u.id and network.userId = ".$id."  ".$search." group by l.loginId order by ".$sortBy."  ".$sortType."";
		$count	=	Yii::app()->db->createCommand($sql)->queryAll();
		$networkData	=	new CSqlDataProvider($sql, array(
					'totalItemCount'=>count($count),
					'pagination'=>array(
						'pageSize'=>$limit,
					),
				));
		
		$userObj	=	new Users();
		$todoListObj	=	new TodoLists();
		$generalObj	=	new General();
		$index  =   0;
		$networks	=	array();
		foreach($networkData->getData() as $data){
			$networks[$index]['networkId']	=	$data['networkId'];
			$networks[$index]['id']	=	$data['id'];
			$networks[$index]['netId']	=	$data['netId'];
			$networks[$index]['listId']	=	$data['listId'];
			$networks[$index]['created']	=	$data['created'];
			$networks[$index]['firstName']	=	$data['firstName'];
			$networks[$index]['lastName']	=	$data['lastName'];
			$networks[$index]['loginId']	=	$data['loginId'];
			
			$networks[$index]['time']	=	$generalObj->rel_time($data['created']);
			$res	=	$userObj->getUserDetail($data['networkId']);
			$networks[$index]['user'] = $res['result'];	
			$networks[$index]['list']	=	$todoListObj->getMyListById($data['listId']);
			$index++;
		}
		return array('pagination'=>$networkData->pagination, 'networks'=>$networks);
	}
	
	public function deleteNetworkByListId($userId)
	{
		$condition = "userId=:userId or networkId=:networkId";
		$params[':userId'] = $userId;
		$params[':networkId'] = $userId;
		Todonetwork::model()->deleteAll($condition,$params);
	}
			
}
