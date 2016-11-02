<?php

/**
 * This is the model class for table "attachments".
 *
 * The followings are the available columns in table 'attachments':
 * @property string $id
 * @property integer $userId
 * @property string $listId
 * @property string $itemId
 * @property string $name
 * @property string $path
 * @property string $type
 * @property string $createdAt
 * @property string $modifiedAt
 */
class Attachments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attachments the static model class
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
		return 'attachments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('userId, listId, itemId, name, path, type, createdAt, modifiedAt', 'required'),
			//array('userId', 'numerical', 'integerOnly'=>true),
			//array('listId, itemId', 'length', 'max'=>20),
			//array('name, path', 'length', 'max'=>255),
			//array('type', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, userId, listId, itemId, name, path, type, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'path' => 'Path',
			'type' => 'Type',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
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
	
	function getAttachmentsById($id,$fields="*")
	{
		$item	=	Yii::app()->db->createCommand()
					->select($fields)
					->from($this->tableName())
					->where('id=:id', array(':id'=>$id))
					->queryRow();
		return $item;				
	}
	
	/*function getAttachmentsById($id=NULL)
	{
		$todoItemsObj	=	new TodoItems();
		$item	=	Yii::app()->db->createCommand()
					->select('attachmentIds')
					->from($todoItemsObj->tableName())
					->where('id=:id', array(':id'=>$id))
					->queryScalar();
					
		$attachment	=	$this->getAttachmentsById($item);
		return $attachment;
	}*/

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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('listId',$this->listId,true);
		$criteria->compare('itemId',$this->itemId,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function deleteAttachmentsByListId($userId)
	{
		$condition = "userId=:userId";
		$params[':userId'] = $userId;
		Attachments::model()->deleteAll($condition,$params);
	}
}