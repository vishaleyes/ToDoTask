<?php

class ApiController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{	
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	/*
	Method : GET OR POST
	params : firstname,lastname,age,sex,username,password,email
	*/
	function actionregister()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['email']) && $_REQUEST['email'] !='' && isset($_REQUEST['password']) && $_REQUEST['password'] !='')
		{
			$data=array();
			if(isset($_REQUEST['firstName']) && $_REQUEST['firstName'] != '')
			{
				$data['firstName'] = $_REQUEST['firstName'];
			}
			if(isset($_REQUEST['lastName']) && $_REQUEST['lastName'] != '')
			{
				$data['lastName'] = $_REQUEST['lastName'];
			}
			if(isset($_REQUEST['type']) && $_REQUEST['type'] != '')
			{
				$data['type'] = $_REQUEST['type'];
			}
			$data['email'] = $_REQUEST['email'];
			$data['password'] = $_REQUEST['password'];
			$api = new Api();
			$bool = $api->checkemail($_REQUEST['email']);
			if($bool==false)
			{
				echo json_encode(array("status"=>'1',"message"=>"email already in use."));
				exit;
			}
			$api = new Users();
			$api->firstName=$data['firstName'];
			$api->lastName=$data['lastName'];
			$api->email=$data['email'];
			$api->password=$data['password'];
			$res = $api->save($data);
			if(!empty($res))
			{
				$result['status'] = 1;
				$result['message'] = "Successfully Registered";
				echo json_encode(array("status"=>'1',"message"=>$result));
			}
			else
			{
				echo json_encode(array("status"=>'-1',"message"=>"problem in registration"));
			}
		}
		else
		{
			echo json_encode(array("status"=>'-2',"message"=>"Permision Denied"));
		}
	}
	
	/*
	Method : GET OR POST
	params : firstname,lastname,age,sex,username,password,email
	*/
	function actioneditProfile()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId'] !='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId'] !='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$data=array();
				if(isset($_REQUEST['firstName']) && $_REQUEST['firstName'] != '')
				{
					$data['firstName'] = $_REQUEST['firstName'];
				}
				if(isset($_REQUEST['lastName']) && $_REQUEST['lastName'] != '')
				{
					$data['lastName'] = $_REQUEST['lastName'];
				}
				if(isset($_REQUEST['password']) && $_REQUEST['password'] != '')
				{
					$data['password'] = $_REQUEST['password'];
				}
				//$data['email'] = $_REQUEST['email'];
				if(isset($_REQUEST['email']) && $_REQUEST['email'] != '')
				{
					
					$api = new Api();
					$bool = $api->checkemail($_REQUEST['email']);
					if($bool==false)
					{
						echo json_encode(array("status"=>'1',"message"=>"email already in use."));
						exit;
					}
					$data['email'] = $_REQUEST['email'];
				}
				
				
				$api=Users::model()->findByPk($_REQUEST['userId']);
				$api->firstName=$data['firstName'];
				$api->lastName=$data['lastName'];
				if(isset($data['email']) && $data['email'] != '')
				{
					$api->email=$data['email'];
				}
				if(isset($data['email']) && $data['email'] != '')
				{
					$api->password=$data['password'];
				}
				$res = $api->save($data);
				if(!empty($res))
				{
					$result['status'] = 1;
					$result['message'] = "Successfully Updated";
					echo json_encode(array("status"=>'1',"message"=>$result));
				}
				else
				{
					echo json_encode(array("status"=>'-1',"message"=>"problem in Updating Profile"));
				}
			}
			else
			{
				echo json_encode(array("status"=>'-3',"message"=>"Invalid Session."));
			}
		}
		else
		{
			echo json_encode(array("status"=>'-2',"message"=>"Permision Denied"));
		}
	}
	
	
	/*
	Method : GET OR POST
	params : username,password
	*/
	public function actionlogin()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['email']) && $_REQUEST['email']!='' && isset($_REQUEST['password']) && $_REQUEST['password']!='')
		{
			$data=array();
			$data['email'] 	= $_REQUEST['email'];
			$data['password'] 	= $_REQUEST['password'];
			$apiObj = new Api();
			$res = $apiObj->auth_login($data);
			
			if(!empty($res))
			{	
								
				$abc= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
										"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
										"0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
				$sessionId = $abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
				$sessionId = $sessionId.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
				$tempdata=array();
				$tempdata['id'] = $res['id'];
				$tempdata['sessionId'] = $sessionId;
				$user=Users::model()->findByPk($res['id']);
				$user->sessionId=$sessionId;
				$user->save(); // save the change to database
				$apiObj = new Api();
				$user = $apiObj->getUserData($res['id']);
				$result['status'] = 1;
				$result['message'] = $user;
				if(!empty($res))
				{
					echo json_encode($result);	
				}
				else
				{
					echo json_encode(array('status'=>'0','error'=>'Invalid Username or Password'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'2','error'=>'No Data Found'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	public function checksession($userId,$sessionId)
	{
			$apiObj = new Api();
			$res = $apiObj->checksession($userId,$sessionId);
			if(!empty($res) && $res['user_id'] != '')
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	
	public function actionlogout()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$user=Users::model()->findByPk($_REQUEST['userId']);
				$user->sessionId='';
				$res =  $user->save(); // save the change to database
				if($res ==  1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully Logged Out.'));
				}
				else
				{
					echo json_encode(array('status'=>'0','error'=>'Invalid Parameters.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','error'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	public function actionaskQuestion()
	{
		
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['title']) && $_REQUEST['title']!='' && isset($_REQUEST['description']) && $_REQUEST['description']!='' && isset($_REQUEST['questionType']) && $_REQUEST['questionType']!='' && isset($_REQUEST['authorId']) && $_REQUEST['authorId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
					$data=array();
					$data['userId']  =  $_REQUEST['userId'];
					$data['title']  =  $_REQUEST['title'];
					$data['description']  =  $_REQUEST['description'];
					if(isset($_REQUEST['attachment']) && $_REQUEST['attachment'] != '')
					{
						$data['attachment']  =   $_REQUEST['attachment'];
					}
					$data['questionType'] = $_REQUEST['questionType'];
					$data['authorId'] = $_REQUEST['authorId'];
					$user= new Questions();
					$user->userId=$data['userId'];
					$user->title=$data['title'];
					$user->description=$data['description'];
					if(isset($_REQUEST['attachment']) && $_REQUEST['attachment'] != '')
					{
						$user->attachment=$data['attachment'];
					}
					$user->questionType=$data['questionType'];
					$user->authorId=$data['authorId'];
					echo $res = $user->save(); // save the change to database
					if($res == 1)
					{
						echo json_encode(array('status'=>'1','message'=>'Succesfuuly Added Your Question.'));
					}
					else
					{
						echo json_encode(array('status'=>'0','message'=>'permision Denied'));
					}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	
	public function sendNotificationToAuthors($para=array())
	{
		/*$authcode = $this->googleAuthenticate(base64_decode('dnBhbmNoYWw5MTFAZ21haWwuY29t'),base64_decode("OTExcGFuY2hhbA=="), $source="Tod-test-2.2", $service="ac2dm");*/
		//$authcode = $this->googleAuthenticate('patel.kiran33@gmail.com','9723388860', $source="Tod-test-2.2", $service="ac2dm");
		/*$authcode = "DQAAAMEAAACZTe8iIuB7ePhtuyanQcylQMN9IBuhouVKZxVNtY4ednyQaju_mTONfOOvhIDeRuTQtjmP5TV6qqDOZiFQ3SraTaG_4lhZjw2ofkz7cYG6ldZnjbNA4wleOVBXPxpYCTcvhNQMzmq3kSjOwasYH8R2bSxTOLaoNlZbpn1aXytmNCN8kKfUn0txhR3L5tXbV20abUMeNre5T2kiaaEQjTNJzIzjSOVwKFC41xjQwyN5ZlQM8E4Bj_q0lgGWjIYaZTZIfr_r5rc6g3bEqs_ByaJP";*/
		$authcode = "DQAAALQAAAB0Fdu--PyOnIpzfKhvJCoqz3o__6baV46JdOvXwXiY93nD7D1FQvxYrFjnRX2kzBr_k5j4X3tP0aSMYfC1XrOdQ4QnY4iHqt3J_d2fTC6mh07Y0ER_8oo5aKuz-DUcLORegM7frSU7NLNmscRWYblMI5wR96LcqA1aihTaJ1LXKlW-J8AzVXjOhhWWg5LqKDZLM1-c5JFbchGmDsX6nxCLCGtYyRHhh7jRNEbQ3-60aUKJeOcSHxOF-gM7WOWnDvs";
		
		if(isset($para['deviceId']) && $para['deviceId']!='')
		{
			
		$msgType="text";
		$smarty = new smartyML('eng');
		$messageText=smarty_prefilter_i18n($para['message'],$smarty);
		
		$notificationData=array('senderType'=>$para['senderType'],'message'=>$messageText);
		$headers = array('Authorization: GoogleLogin auth=' . $authcode);
		$data = array(
		 'registration_id' => $para['deviceId'],
		 'collapse_key' => 'text',
		 'data.payload' => $para['senderType']."::".$messageText //TODO Add more params with just simple data instead 
		 );
		 
		$ch = curl_init();
	 	
		curl_setopt($ch, CURLOPT_URL, "https://android.apis.google.com/c2dm/send");
		if ($headers)
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	  
		$response = curl_exec($ch);
		curl_close($ch);
		error_log("Android Response".print_r($response,true));
		return array("status"=>0,'message'=>$response);
		}
		return json_encode(array("status"=>505,'message'=>"Invalid deviceId."));
	}
	
	
	function googleAuthenticate($username, $password, $source="Company-AppName-Version", $service="ac2dm") 
	{    

		if( isset($_SESSION['google_auth_id']) && $_SESSION['google_auth_id'] != null)
			return $_SESSION['google_auth_id'];
	
		// get an authorization token
		$ch = curl_init();
		if(!$ch){
			return false;
		}
	
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
		$post_fields = "accountType=" . urlencode('HOSTED_OR_GOOGLE')
			. "&Email=" . urlencode($username)
			. "&Passwd=" . urlencode($password)
			. "&source=" . urlencode($source)
			. "&service=" . urlencode($service);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);    
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
		// for debugging the request
		//curl_setopt($ch, CURLINFO_HEADER_OUT, true); // for debugging the request
	
		$response = curl_exec($ch);
		
		curl_close($ch);
	
		if (strpos($response, '200 OK') === false) {
			return false;
		}
	
		// find the auth code
		preg_match("/(Auth=)([\w|-]+)/", $response, $matches);
	
		if (!$matches[2]) {
			return false;
		}
	
		$_SESSION['google_auth_id'] = $matches[2];
		return $matches[2];
	}
	
	function actionrateAnswer()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['answerId']) && $_REQUEST['answerId']!='' && isset($_REQUEST['rate']) && $_REQUEST['rate']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
					error_reporting(E_ALL);
					$user = new Ratings();
					$user->userId = $_REQUEST['userId'];
					$user->answerId = $_REQUEST['answerId'];
					$user->rating = $_REQUEST['rate'];
					$user->modifiedDate = "";
					$user->createdDate = date("Y-m-d H:i:s");
					$res = $user->save(); // save the change to database
					if($res == 1)
					{
						echo json_encode(array('status'=>'1','message'=>'Successfully Rate the Author.'));
					}
					else
					{
						echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
					}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	function actionrateAuthor()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['authorId']) && $_REQUEST['authorId']!='' && isset($_REQUEST['rate']) && $_REQUEST['rate']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$data=array();
				$user = new RatingAuthors();
				$user->userId = $_REQUEST['userId'];
				$user->authorId = $_REQUEST['authorId'];
				$user->rating = $_REQUEST['rate'];
				$user->modifiedDate = "";
				$user->createdDate = date("Y-m-d H:i:s");
				$res = $user->save(); // save the change to database
				if($res == 1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully Rate the Author.'));
				}
				else
				{
					echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	function claim()
	{
		
	}
	
	function actionfollow()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['authorId']) && $_REQUEST['authorId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$data=array();
				$followers= new Followers();
				$followers->authorId=$_REQUEST['authorId'];
				$followers->userId=$_REQUEST['userId'];
				$res = $followers->save(); // save the change to database
				if($res == 1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully follow author.'));
				}
				else
				{
					echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	function actionunFollow()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['authorId']) && $_REQUEST['authorId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$data=array();
				$followers=Followers::model()->findByPk($_REQUEST['authorId']);
				$res = $followers->delete(); // save the change to database
				if($res == 1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully Unfollow author.'));
				}
				else
				{
					echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	public function actionanswerTheQuestion()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['questionId']) && $_REQUEST['questionId']!='' && isset($_REQUEST['authorId']) && $_REQUEST['authorId']!='' && isset($_REQUEST['description']) && $_REQUEST['description']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$data=array();
				$data['userId'] = $_REQUEST['userId'];
				$data['questionId'] = $_REQUEST['questionId'];
				$data['authorId'] = $_REQUEST['authorId'];
				$data['description'] = $_REQUEST['description'];
				$ansObj= new Answers();
				$ansObj->authorId=$_REQUEST['authorId'];
				//$ansObj->userId=$_REQUEST['userId'];
				$ansObj->questionId=$_REQUEST['questionId'];
				$ansObj->description=$_REQUEST['description'];
				$ansObj->createdDate=date("Y-m-d h:i:s");
				$res = $ansObj->save(); // save the change to database
				if($res == 1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully Added your answer.'));
				}
				else
				{
					echo json_encode(array('status'=>'-1','message'=>'Invalid Parameters.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	public function actiongetBookListing()
	{
		$bookObj = new Books();
		$result = $bookObj->getAllPaginatedBooks();
		if(!empty($result))
		{
			echo json_encode(array("status"=>1,"message"=>$result));
		}
		else
		{
			echo json_encode(array("status"=>0,"message"=>"No Data Found."));
		}
	}
	
	public function actiongetMyProfile()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$userObj= new Users();
				$res = $userObj->getUserById($_REQUEST['userId']); // save the change to database
				if(!empty($res))
				{
					echo json_encode(array('status'=>'1','message'=>$res));
				}
				else
				{
					echo json_encode(array('status'=>'-3','message'=>'No Data Found.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	
	public function actiongetAuthors()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$authorObj= new Authors();
				$res = $authorObj->getAuthors(); // save the change to database
				if(!empty($res))
				{
					echo json_encode(array('status'=>'1','message'=>$res));
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No Data Found.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	public function actionchangePassword()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['oldpassword']) && $_REQUEST['oldpassword']!='' && isset($_REQUEST['newpassword']) && $_REQUEST['newpassword']!='' && isset($_REQUEST['confirmpassword']) && $_REQUEST['confirmpassword']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
				$userObj= new Users();
				$res = $userObj->getUserById($_REQUEST['userId']); // save the change to database
				if(!empty($res))
				{
					if($_REQUEST['oldpassword']==$res['password'])
					{
						if($_REQUEST['newpassword'] == $_REQUEST['confirmpassword'])
						{
							$user=Users::model()->findByPk($_REQUEST['userId']);
							$user->password =  $_REQUEST['newpassword'];
							$res = $user->save();
							echo json_encode(array('status'=>'1','message'=>"successfully changed Password"));
						}
						else
						{
							echo json_encode(array('status'=>'-3','message'=>"New Password and Confirm Password is not matched."));
						}
					}
					else
					{
						echo json_encode(array('status'=>'-1','message'=>"Old Password is not Correct"));
					}
				}
				else
				{
					echo json_encode(array('status'=>'0','message'=>'No Data Found.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	
	public function actionquestionListingByAuthor()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='' && isset($_REQUEST['authorId']) && $_REQUEST['authorId']!='')
		{
			$apiObj = new Api();
			$user = $apiObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user) && $user['id']!='')
			{
					$authorObj= new Authors();
					$res = $authorObj->questionListingByAuthor($_REQUEST['authorId']); // save the change to database
					if(!empty($res))
					{
						echo json_encode(array('status'=>'1','message'=>$res));
					}
					else
					{
						echo json_encode(array('status'=>'0','message'=>'No Data Found.'));
					}
			}
			else
			{
				echo json_encode(array('status'=>'-2','message'=>'Invalid Session.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','message'=>'permision Denied'));
		}
	}
	
	public function fileUpload($file)
	{
		$base=$file;
		//error_log(print_r($base,true),3,'test.txt');
		// base64 encoded utf-8 string
		$binary=base64_decode($base);
		// binary, utf-8 bytes
		header('Content-Type: bitmap; charset=utf-8');
		// print($binary);
		//$theFile = base64_decode($image_data);
		$str = rand(1000,100000);
		$file = fopen('theauthor/att_"'.$str.'.png', 'wb');
		$filename = 'att_"'.$str.'.png';
		fwrite($file, $binary);
		fclose($file);
		return $filename;
	}
	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{	
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	
}