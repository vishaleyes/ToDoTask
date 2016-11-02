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
 * This is the model class for table "api_function_resources".
 *
 * The followings are the available columns in table 'api_function_resources':
 * @property integer $id
 * @property integer $fn_id
 * @property string $limited
 * @property string $authentication
 * @property string $response_formats
 * @property string $http_methods
 * @property string $resource_url
 * @property string $example
 * @property string $response
 * @property string $uiValidationRule
 */
class ApiFunctionResource extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Api_function_resource the static model class
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
		return 'api_function_resources';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fn_id, resource_url, example, response, uiValidationRule', 'required'),
			array('fn_id', 'numerical', 'integerOnly'=>true),
			array('limited, authentication, response_formats, http_methods', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fn_id, limited, authentication, response_formats, http_methods, resource_url, example, response, uiValidationRule', 'safe', 'on'=>'search'),
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
			'limited' => 'Limited',
			'authentication' => 'Authentication',
			'response_formats' => 'Response Formats',
			'http_methods' => 'Http Methods',
			'resource_url' => 'Resource Url',
			'example' => 'Example',
			'response' => 'Response',
			'uiValidationRule' => 'Ui Validation Rule',
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
		$criteria->compare('limited',$this->limited,true);
		$criteria->compare('authentication',$this->authentication,true);
		$criteria->compare('response_formats',$this->response_formats,true);
		$criteria->compare('http_methods',$this->http_methods,true);
		$criteria->compare('resource_url',$this->resource_url,true);
		$criteria->compare('example',$this->example,true);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('uiValidationRule',$this->uiValidationRule,true);

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
	
	function getData($fn_id)
	{
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->where('fn_id=:fn_id', array(':fn_id'=>$fn_id))
		->queryRow();
		
		return $result;
	}
}