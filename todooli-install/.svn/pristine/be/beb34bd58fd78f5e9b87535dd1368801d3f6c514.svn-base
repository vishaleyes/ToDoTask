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
 * This is the model class for table "api_functions".
 *
 * The followings are the available columns in table 'api_functions':
 * @property integer $id
 * @property string $function_name
 * @property string $fn_description
 * @property integer $moduleId
 * @property string $uiTeamApproval
 * @property string $backendTeamApproval
 * @property string $overallApproval
 * @property string $published
 * @property string $createdAt
 * @property string $modifiedAt
 */
class ApiFunction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Api_function the static model class
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
		return 'api_functions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('function_name, fn_description, moduleId, createdAt, modifiedAt', 'required'),
			array('moduleId', 'numerical', 'integerOnly'=>true),
			array('function_name', 'length', 'max'=>255),
			array('uiTeamApproval, backendTeamApproval, overallApproval, published', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, function_name, fn_description, moduleId, uiTeamApproval, backendTeamApproval, overallApproval, published, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'function_name' => 'Function Name',
			'fn_description' => 'Fn Description',
			'moduleId' => 'Module',
			'uiTeamApproval' => 'Ui Team Approval',
			'backendTeamApproval' => 'Backend Team Approval',
			'overallApproval' => 'Overall Approval',
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
		$criteria->compare('function_name',$this->function_name,true);
		$criteria->compare('fn_description',$this->fn_description,true);
		$criteria->compare('moduleId',$this->moduleId);
		$criteria->compare('uiTeamApproval',$this->uiTeamApproval,true);
		$criteria->compare('backendTeamApproval',$this->backendTeamApproval,true);
		$criteria->compare('overallApproval',$this->overallApproval,true);
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
		
	function getFunction($id)
	{
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryRow();
		
		return $result;
	}
	function listFunction($module=-'1',$page=1,$like=NULL)
	{
		//$this->where('published','1');
		$criteria=new CDbCriteria;
		if($module!='-1')
		{
			$criteria->addCondition('moduleId= '.$module);
		}
		$criteria->addSearchCondition('function_name', $like,true,'AND');
		$criteria->order='id asc';
		
		$dataProvider=new CActiveDataProvider('ApiFunction', array(
			'criteria' => $criteria,
		    'pagination'=>array(
		        'pageSize'=>ADMIN_PAGINATE_LIMIT,
			),
		));
		$index	=	0;
		$data=array();
		foreach ($dataProvider->getData() as $result) {
			$data[$index]['id']	=	$result->id;
			$data[$index]['function_name']	=	$result->function_name;
			$data[$index]['moduleId']	=	$result->moduleId;
			$data[$index]['published']	=	$result->published;
			$data[$index]['uiTeamApproval']	=	$result->uiTeamApproval;
			$data[$index]['backendTeamApproval']	=	$result->backendTeamApproval;
			$data[$index]['overallApproval']	=	$result->overallApproval;
			$index++;
		}
		
		return array($dataProvider->pagination,$data);

	}
	
	function setApproval($post)
	{
		$dataValue[$post['statusName']]=$post['statusValue'];
		
		$this->setData($dataValue);	
		$this->insertData($post['id']);	
		
		return true;
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
	
	function deleteFunction($id)
	{
		$ApiFunctionObj=ApiFunction::model()->findByPk($id);
		if(is_object($ApiFunctionObj))
		{
			$ApiFunctionObj->delete();
		}
		$Api_function_paramObj=new ApiFunctionParam();
		$Api_function_paramObj->deleteParamByFnId($id);	
		
	}
	
	function getFunctionByModuleId($moduleId)
	{
		$result = Yii::app()->db->createCommand()
		->select('id,function_name,published,fn_description')
		->from($this->tableName())
		->where('published=:published and moduleId=:moduleId', array(':published'=>1,':moduleId'=>$moduleId))
		->order('id ASC')
		->queryAll();
		
		return $result;
	}
	
	function getFunctions($front=0)
	{
		$condition='published=:published';
		$params=array(':published'=>1);
		if($front=1)
		{
			$orderBy = 'moduleId';
			$select = 'id,function_name,published,fn_description';
		}
		else
		{
			$orderBy = 'id';
			$select = 'id,function_name,uiTeamApproval,backendTeamApproval,overallApproval';
		}
		$result = Yii::app()->db->createCommand()
		->select($select)
		->from($this->tableName())
		->where($condition,$params)
		->order($orderBy.' asc')
		->queryAll();
		
		return $result;
		
	}
}