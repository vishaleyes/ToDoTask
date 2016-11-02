<?php
/**
 * Copyright (c) 2011 All Right Reserved, Todooli, Inc.
 *
 * This source is subject to the Todooli Permissive License. Any Modification
 * must not alter or remove any copyright notices in the Software or Package,
 * generated or otherwise. All derivative work as well as any Distribution of
 * this asis or in Modified
form or derivative requires express written consent
 * from Todooli, Inc.
 *
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
 * PARTICULAR PURPOSE.
 *
 *
**/ 

/**
 * This is the model class for table "api_function_params".
 *
 * The followings are the available columns in table 'api_function_params':
 * @property integer $id
 * @property integer $fn_id
 * @property string $fnParamName
 * @property string $fnParamDescription
 * @property string $ParamType
 * @property string $example
 * @property string $uiValidationRule
 * @property string $published
 * @property string $createdAt
 * @property string $modifiedAt
 */
class ApiFunctionParam extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Api_function_param the static model class
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
		return 'api_function_params';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fn_id, fnParamName, fnParamDescription, ParamType, example, uiValidationRule, createdAt, modifiedAt', 'required'),
			array('fn_id', 'numerical', 'integerOnly'=>true),
			array('fnParamName', 'length', 'max'=>255),
			array('ParamType, published', 'length', 'max'=>1),
			array('example', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fn_id, fnParamName, fnParamDescription, ParamType, example, uiValidationRule, published, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'fn_id' => 'Fn',
			'fnParamName' => 'Fn Param Name',
			'fnParamDescription' => 'Fn Param Description',
			'ParamType' => 'Param Type',
			'example' => 'Example',
			'uiValidationRule' => 'Ui Validation Rule',
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
		$criteria->compare('fn_id',$this->fn_id);
		$criteria->compare('fnParamName',$this->fnParamName,true);
		$criteria->compare('fnParamDescription',$this->fnParamDescription,true);
		$criteria->compare('ParamType',$this->ParamType,true);
		$criteria->compare('example',$this->example,true);
		$criteria->compare('uiValidationRule',$this->uiValidationRule,true);
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
	
		
	function listParam($fn_id,$page=1)
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition('fn_id= '.$fn_id);
		$criteria->order='id desc';
		
		$dataProvider=new CActiveDataProvider('ApiFunctionParam', array(
			'criteria' => $criteria,
		    'pagination'=>array(
		        'pageSize'=>ADMIN_PAGINATE_LIMIT,
			),
		));
		$data=array();
		$index	=	0;
		foreach ($dataProvider->getData() as $result) {
			$data[$index]['id']	=	$result->id;
			$data[$index]['fn_id']	=	$result->fn_id;
			$data[$index]['fnParamName']	=	$result->fnParamName;
			$data[$index]['published']	=	$result->published;
			$index++;
		}
		
		return array($dataProvider->pagination,$data);

	}
	
	function getParameters($id)
	{
		$result = Yii::app()->db->createCommand()
		->select('id,fn_id,fnParamName,fnParamDescription,ParamType,uiValidationRule,example')
		->from($this->tableName())
		->where('published=:published and fn_id=:fn_id', array(':published'=>1,':fn_id'=>$id))
		->order('id ASC')
		->queryAll();
		
		return $result;	
		
	}
	
	function getParameter($id)
	{
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryRow();
		
		return $result;
	}
	
	function deleteParameter($id)
	{
		$ApiFunctionParamObj=ApiFunctionParam::model()->findByPk($id);
		$ApiFunctionParamObj->delete();		
	}
	function deleteParamByFnId($fn_id)
	{
		$ApiFunctionParamObj=ApiFunctionParam::model()->findByPk($fn_id);
		if(is_object($ApiFunctionParamObj))
		{
			$ApiFunctionParamObj->delete();
		}
	}
	
}