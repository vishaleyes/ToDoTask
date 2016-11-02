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
 * This is the model class for table "oauths".
 *
 * The followings are the available columns in table 'oauths':
 * @property integer $id
 * @property string $client_id
 * @property string $client_secret
 * @property string $redirect_uri
 * @property string $oauth_token
 * @property string $expires
 * @property string $scope
 * @property integer $userId
 */
 
class Oauth extends Oauth2
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Oauth the static model class
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
		return 'oauths';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, client_secret, redirect_uri, oauth_token, expires, scope, userId', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('client_id', 'length', 'max'=>100),
			array('client_secret, expires', 'length', 'max'=>20),
			array('redirect_uri', 'length', 'max'=>255),
			array('oauth_token', 'length', 'max'=>40),
			array('scope', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, client_id, client_secret, redirect_uri, oauth_token, expires, scope, userId', 'safe', 'on'=>'search'),
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
			'client_id' => 'Client',
			'client_secret' => 'Client Secret',
			'redirect_uri' => 'Redirect Uri',
			'oauth_token' => 'Oauth Token',
			'expires' => 'Expires',
			'scope' => 'Scope',
			'userId' => 'User',
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
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('client_secret',$this->client_secret,true);
		$criteria->compare('redirect_uri',$this->redirect_uri,true);
		$criteria->compare('oauth_token',$this->oauth_token,true);
		$criteria->compare('expires',$this->expires,true);
		$criteria->compare('scope',$this->scope,true);
		$criteria->compare('userId',$this->userId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	private $data = array();
	private $insertedId;
	
	

	 private function handleException($e) {
    echo "Database error: " . $e->getMessage();
    exit;
   }
	/////////////////
   // set the location data
    function setData($data) {
		$this->data = $data;
    }

    // insert the location
    function insertData($id=NULL) {
		if($id!=NULL)
		{
			
			$transaction=$this->dbConnection->beginTransaction();
			try
			{
				$post=$this->findByPk($id);
				if(is_object($post))
				{
					$post->attributes=$this->data;
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
			
			$this->attributes=$p;
			$this->setIsNewRecord(true);
			$this->save(false);
			return Yii::app()->db->getLastInsertID();
		}
      
    }
	
	// get insert id
	function getInsertId()
	{
		return $this->insertedId;
	}
	
	 /**
   * Little helper function to add a new client to the database.
   *
   * Do NOT use this in production! This sample code stores the secret
   * in plaintext!
   *
   * @param $client_id
   *   Client identifier to be stored.
   * @param $client_secret
   *   Client secret to be stored.
   * @param $redirect_uri
   *   Redirect URI to be stored.
   */
  public function addClient($userId=NULL,$id=NULL,$redirect_uri=NULL,$client_id=NULL, $client_secret=NULL) {
	  
   	$oauthObj=new Oauth();
	$oauthArray['client_id']=$this->generateClientId();
	$oauthArray['userId']=$userId;
	$oauthArray['client_secret']=$this->generateClientSecret();
	$oauthObj->setData($oauthArray);
	$oauthObj->insertedId=$oauthObj->insertData();
	if($oauthObj->insertedId)
	{
		$oauthArray['id']=$oauthObj->insertedId;
		return $oauthArray;	
	}
  }
  
  public function updateClient($id,$data)
  {
	  $this->set($data);
	  $this->insert($id);
  }
  
  function generateClientId()
  {
	   return md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
  }
  
   function generateClientSecret()
  {
	   return md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
  }

  /**
   * Implements OAuth2::checkClientCredentials().
   *
   * Do NOT use this in production! This sample code stores the secret
   * in plaintext!
   */
  public function checkClientCredentials($client_id, $client_secret = NULL) {
    try {
			$oauthObj=new Oauth();
			$oauthObj->id=NULL;
			$oauthObj->where('client_id',$client_id);
			$result=$oauthObj->getRows('client_secret');
           if ($client_secret === NULL)
          return $result !== FALSE;

      return $result["client_secret"] == $client_secret;
    } catch (PDOException $e) {
      $this->handleException($e);
    }
  }

  /**
   * Implements OAuth2::getRedirectUri().
   */
  public function getRedirectUri($client_id) {
    try {
      	
		$result = Yii::app()->db->createCommand()
				->select("redirect_uri")
				->from($this->tableName())
				->where('client_id=:client_id', array(':client_id'=>$client_id))
				->queryRow();
					
      if ($result === FALSE)
          return FALSE;

      return isset($result["redirect_uri"]) && $result["redirect_uri"] ? $result["redirect_uri"] : NULL;
    } catch (PDOException $e) {
      $this->handleException($e);
    }
  }

  /**
   * Implements OAuth2::getAccessToken().
   */
  public function getAccessToken($oauth_token) {
    try {
    
		$result = Yii::app()->db->createCommand()
				->select("client_id,expires,scope,userId")
				->from($this->tableName())
				->where('oauth_token=:oauth_token', array(':oauth_token'=>$oauth_token))
				->queryAll();
				
    	  return $result !== FALSE ? $result : NULL;
    } catch (PDOException $e) {
      $this->handleException($e);
    }
  }

  /**
   * Implements OAuth2::setAccessToken().
   */
  public function setAccessToken($oauth_token, $client_id, $expires,$userId=NULL,$scope = NULL,$id=NULL) {
    try {
		$oauthArray=$this->getAuthDetailsByclientId($client_id);
     	$oauthArray['oauth_token']=$oauth_token;
		$oauthArray['client_id']=$client_id;
		$oauthArray['expires']=$expires;
		$oauthArray['scope']=$scope;
		$oauthObj=new Oauth();
		
		if(!empty($oauthArray))
		{
			$id=$oauthArray['id'];	
		}
		//$oauthObj->insert($id);
		$oauthObj->setData($oauthArray);
		$oauthObj->insertedId=$oauthObj->insertData($id);
    } catch (PDOException $e) {
      $this->handleException($e);
    }
  }
  
  function getAuthDetailsByclientId($id,$byId='client_id')
  {
		$oauthObj=new Oauth();
		
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from('oauths')
		->where($byId."='".$id."'")
		->order('id asc')
		->queryRow();
		return $result;
  }

  /**
   * Overrides OAuth2::getSupportedGrantTypes().
   */
  public function getSupportedGrantTypes() {
    return array(
      OAUTH2_GRANT_TYPE_AUTH_CODE,
    );
  }

  /**
   * Overrides OAuth2::getAuthCode().
   */
  public function getAuthCode($code) {
    try {
		return true;
     /* $sql = "SELECT code, client_id, redirect_uri, expires, scope FROM auth_codes WHERE code ='$code'";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(":code", $code, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result !== FALSE ? $result : NULL;*/
    } catch (PDOException $e) {
      $this->handleException($e);
    }
  }

  /**
   * Overrides OAuth2::setAuthCode().
   */
  public function setAuthCode($code, $client_id, $redirect_uri, $expires, $scope = NULL) {
    try {
		return true;
     /* $sql = "INSERT INTO auth_codes (code, client_id, redirect_uri, expires, scope) VALUES (:code, :client_id, :redirect_uri, :expires, :scope)";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(":code", $code, PDO::PARAM_STR);
      $stmt->bindParam(":client_id", $client_id, PDO::PARAM_STR);
      $stmt->bindParam(":redirect_uri", $redirect_uri, PDO::PARAM_STR);
      $stmt->bindParam(":expires", $expires, PDO::PARAM_INT);
      $stmt->bindParam(":scope", $scope, PDO::PARAM_STR);

      $stmt->execute();*/
    } catch (PDOException $e) {
      $this->handleException($e);
    }
  }
	
}