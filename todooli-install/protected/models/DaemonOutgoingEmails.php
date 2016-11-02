<?php

/**
 * This is the model class for table "daemon_outgoing_emails".
 *
 * The followings are the available columns in table 'daemon_outgoing_emails':
 * @property integer $id
 * @property integer $senderId
 * @property integer $receiverId
 * @property string $emailTo
 * @property string $subject
 * @property string $emailBody
 * @property string $status
 * @property string $createdAt
 */
class DaemonOutgoingEmails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaemonOutgoingEmails the static model class
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
		return 'daemon_outgoing_emails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('senderId, receiverId, emailTo, subject, emailBody, createdAt', 'required'),
			//array('senderId, receiverId', 'numerical', 'integerOnly'=>true),
			//array('emailTo, subject', 'length', 'max'=>255),
			//array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, senderId, receiverId, emailTo, subject, emailBody, status, createdAt', 'safe', 'on'=>'search'),
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
			'senderId' => 'Sender',
			'receiverId' => 'Receiver',
			'emailTo' => 'Email To',
			'subject' => 'Subject',
			'emailBody' => 'Email Body',
			'status' => 'Status',
			'createdAt' => 'Created At',
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
		$criteria->compare('senderId',$this->senderId);
		$criteria->compare('receiverId',$this->receiverId);
		$criteria->compare('emailTo',$this->emailTo,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('emailBody',$this->emailBody,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('createdAt',$this->createdAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	//Deamon
	//Params 
	function getAllUnreadEmail()
	{
		try {
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from('daemon_outgoing_emails')
		->where('status=:status', array(':status'=>0))
		->order('id asc')
		->queryAll();
		return $result;
		 } catch (Exception $e) {
            error_log('Exception caught: ' . $e->getMessage());
        }
	}
	
	
}