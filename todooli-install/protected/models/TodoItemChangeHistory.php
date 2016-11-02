<?php

/**
 * This is the model class for table "todo_item_change_history".
 *
 * The followings are the available columns in table 'todo_item_change_history':
 * @property integer $id
 * @property integer $itemId
 * @property integer $listId
 * @property integer $assignedById
 * @property integer $assignedToId
 * @property string $dueDate
 * @property string $createdDate
 * @property string $modifiedDate
 */
class TodoItemChangeHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TodoItemChangeHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'todo_item_change_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('itemId, listId, assignedById, assignedToId, dueDate, createdDate, modifiedDate', 'required'),
			//array('itemId, listId, assignedById, assignedToId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, itemId, listId, assignedById, assignedToId, dueDate, createdDate, modifiedDate', 'safe', 'on'=>'search'),
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
			'itemId' => 'Item',
			'listId' => 'List',
			'assignedById' => 'Assigned By',
			'assignedToId' => 'Assigned To',
			'dueDate' => 'Due Date',
			'createdDate' => 'Created Date',
			'modifiedDate' => 'Modified Date',
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
		$criteria->compare('itemId',$this->itemId);
		$criteria->compare('listId',$this->listId);
		$criteria->compare('assignedById',$this->assignedById);
		$criteria->compare('assignedToId',$this->assignedToId);
		$criteria->compare('dueDate',$this->dueDate,true);
		$criteria->compare('createdDate',$this->createdDate,true);
		$criteria->compare('modifiedDate',$this->modifiedDate,true);

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
	
	public function getItemHistory($itemId,$limit=10,$page=1)
	{
		if(!is_numeric($itemId))
		{
			$algoencryptionObj	=	new Algoencryption();
			$itemId	=	$algoencryptionObj->decrypt($itemId);
		}
		
		$_REQUEST['page'] = $page;
		$sql = "select todo_item_change_history.*,users.firstName,users.lastName  from  todo_item_change_history,login,users where todo_item_change_history.actionBy = login.id and login.userId = users.id and todo_item_change_history.itemId = ".$itemId."";
		$sql_count = "select count(*)  from  todo_item_change_history,login,users where todo_item_change_history.actionBy = login.id and login.userId = users.id and todo_item_change_history.itemId = ".$itemId."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		$itemHistory	=	new CSqlDataProvider($sql, array(
					'totalItemCount'=>$count,
					'sort'=>array(
							'attributes'=>array(
								 'title',
							),
						),
					'pagination'=>array(
						'pageSize'=>$limit,
					),
				));
		return array($itemHistory->pagination,$itemHistory->getData());
	}
}