<?php

/**
 * This is the model class for table "response_formats".
 *
 * The followings are the available columns in table 'response_formats':
 * @property integer $id
 * @property string $label
 * @property string $value
 * @property string $published
 * @property string $createdAt
 * @property string $modifiedAt
 */
class ResponseFormat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Response_format the static model class
	 */
	 
	  public function __construct()
	{
		
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
		return 'response_formats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label, value, createdAt, modifiedAt', 'required'),
			array('label, value', 'length', 'max'=>25),
			array('published', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, label, value, published, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'label' => 'Label',
			'value' => 'Value',
			'published' => 'Published',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('published',$this->published,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	private $data = array();
	private $insertedId;
	
	/////////////////
	// set the user data
	function set($data)
	{
		$this->data = $data;
	}
	
	// insert the user
	function insert($id=NULL)
	{
		$this->id=$id;
		$this->insertedId = $this->save($this->data);
	}
	
	// get insert id
	function getInsertId()
	{
		return $this->insertedId;
	}
	
	function getResponseFormat()
	{
		$ResponseFormat["id"] = array();
		$ResponseFormat["label"] = array();
		
		$ResponseFormat_detail = Yii::app()->db->createCommand()
		->select('id,label')
		->from($this->tableName())
		->where('published=:published', array(':published'=>1))
		->queryAll();
		
		foreach ($ResponseFormat_detail as $ResponseFormat)
		{
			$ResponseFormats['id'][] = $ResponseFormat['id'];
			$ResponseFormats['label'][] = $ResponseFormat['label'];
		}
		if(!empty($ResponseFormat_detail))
		{
			return $ResponseFormats;
		}
		else
		{
		return ;
		}
	}
	
}