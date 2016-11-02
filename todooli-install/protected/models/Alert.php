<?php

/**
 * This is the model class for table "alert".
 *
 * The followings are the available columns in table 'alert':
 * @property integer $id
 * @property integer $alertToId
 * @property integer $alertById
 * @property integer $itemId
 * @property string $message
 * @property string $status
 * @property string $createdDate
 * @property string $modifiedDate
 */
class Alert extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Alert the static model class
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
		return 'alert';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alertToId, alertById, itemId, message, status, createdDate, modifiedDate', 'required'),
			array('alertToId, alertById, itemId', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, alertToId, alertById, itemId, message, status, createdDate, modifiedDate', 'safe', 'on'=>'search'),
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
			'alertToId' => 'Alert To',
			'alertById' => 'Alert By',
			'itemId' => 'Item',
			'message' => 'Message',
			'status' => 'Status',
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
		$criteria->compare('alertToId',$this->alertToId);
		$criteria->compare('alertById',$this->alertById);
		$criteria->compare('itemId',$this->itemId);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('createdDate',$this->createdDate,true);
		$criteria->compare('modifiedDate',$this->modifiedDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/*
	DESCRIPTION : GET ALL ALERTS WITH PAGINATION
	*/
	public function getAllPaginatedAlerts()
	{
 		$criteria = new CDbCriteria();
		
		$alert_data=new CActiveDataProvider($this,array(
			'criteria'=>$criteria,
		 	'pagination'=>array(
		        'pageSize'=>10,
			),
		));
		
		$index  =   0;
		$alerts	=	array();
		foreach($alert_data->getData() as $alertData){
				$alerts[$index] =   $alertData->attributes;
				$index++;
		}
		return array('pagination'=>$alert_data->pagination, 'alerts'=>$alerts);
	}
	
	public function getMyAlert($user)
	{
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->where('alertToId=:alertToId', array(':alertToId'=>$id))	
   	 	->queryAll();	
		return $result;
	}
}