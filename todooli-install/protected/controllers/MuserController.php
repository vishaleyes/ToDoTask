<?php
error_reporting(E_ALL);
class MUserController extends Controller
{
	public $msg;
	public $errorCode;
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	
	public function beforeAction()
	{
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
		
		if(!$this->isLogin())
		{
			Yii::app()->user->logout();
			Yii::app()->session->destroy();
			$this->redirect(Yii::app()->params->base_path."site");
			exit;							
		}
		$todoItemsObj	=	new TodoItems();
		$invitesObj	=	new Invites();
		Yii::app()->session['myTodoCount']	=	$todoItemsObj->getMyTodoCount(Yii::app()->session['loginId']);
		Yii::app()->session['byTodoCount']	=	$todoItemsObj->getByMeTodoCount(Yii::app()->session['loginId']);
		Yii::app()->session['otherTodoCount']	=$todoItemsObj->getOtherTodoCount(Yii::app()->session['loginId']);
		Yii::app()->session['invites']	=$invitesObj->totalInvitesByReceiverId(Yii::app()->session['loginId']);
		//echo Yii::app()->session['myTodoCount'];
		return true;
	}
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function isLogin()
	{
		if(!Yii::app()->session['loginId']){
			
			Yii::app()->session->destroy();
			return false;
		}else{
			
			$userId=Yii::app()->session['loginId'];	
			$user=new Login();
			$data=$user->getUserId($userId);
			
			if(!$data)
			{
				Yii::app()->session->destroy();
				return false;			
			}
			return true;
		}
	
	}
	
	public function actionIndex()
	{
		$this->redirect(Yii::app()->params->base_path.'muser/myTodo');
		exit;
		
	}
	
	public function actionHome()
	{
		if(!$this->isLogin())
		{
			$this->redirect('index');
			exit;
		}
		$userObj	=	new Users();
		$loginObj	=	new Login();
		
		$data['userData']	=	$userObj->getUserById(Yii::app()->session['loginId']);
		$data['verifiedPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['loginId'], 1);
		$data['unverifiedPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['loginId'], 0);
		
		$this->render('home');
	}
	
	/*********** 	ABOUT ME FUNCTION  ***********/
	public function actionaboutme()
	{
		error_reporting(E_ALL);
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/aboutme","About me",1);
		
		if(isset($_POST['id']))
        {
			
			$sessionArray['userId']		=	Yii::app()->session['userId'];
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$users = new Users();
			$result=$users->editProfile($_POST,$sessionArray);
			
			if(!empty($result) && $result['status'] == 0){
				
				Yii::app()->session['fullname'] = $_POST['fName'].' '.$_POST['lName'];
				Yii::app()->user->setFlash("success",$this->msg['_PROFILE_SUCESS_']);
			}
			else
			{
				Yii::app()->user->setFlash("error",$result['message']);
			}
        }
			
		$userObj	=	new Users();
		$loginObj	=	new Login();
		$data	=	array();
		$userData	=	$userObj->getUserDetail(Yii::app()->session['loginId']);
		$data['userData'] = $userData['result'];
		$data['email']	=	$loginObj->getVerifiedEmailById(Yii::app()->session['loginId']);
		$genralObj	=	new General();
        $timezone	=	$genralObj->getTimeZones();
		$this->render("aboutme",array('data'=>$data,'timezone'=>$timezone));
	}
	/*
	//Redirecting to todo items page	
	public function actiontodoTabs()
	{
		$this->render("todoTabs");	
	}*/
	
	//Redirecting to todo items page	
	public function actionsettingsTab()
	{
		$helperObj=new Helper();
		$usersObj	=	new Users();
		$helperObj->setMobileBreadCrumb("muser/settingsTab","My profile",0);
		$data	=	$usersObj->getUserDetail(Yii::app()->session['loginId']);
		
		$this->render("settingTabs", array('data'=>$data['result']));
	}
	
	function actiongetMyNetworkDropdown()
	{
		if(!isset($_REQUEST['assignTo']))
		{
			$_REQUEST['assignTo']=0;	
		}
		
		$todoNetworkObj	=	new Todonetwork();
		$networks	=	$todoNetworkObj->getNetworkDropdown(Yii::app()->session['loginId'],$_REQUEST['assignTo']);
		echo $networks;	
	}
	
	/*********** 	INVITES FUNCTION  ***********/
	public function actionInvites()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$invitesObj	=	new Invites();
		$invites	=	$invitesObj->getInvitesByReceiverId(Yii::app()->session['loginId'],NULL,'desc','i.status',5);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/invites","Invite",0);
		
		$this->render('invites', array('data'=>$invites['invites'],'pagination'=>$invites['pagination']));
	}
	
	/*********** 	VIEW MORE FOR INVITATION FUNCTION  ***********/
	public function actionviewMoreInvite($id='0')
	{
		$errorFlag=0;
		if($id == '0')
		{
			$errorFlag=1;
		}
		
		$inviteObj	=	new Invites();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		$data	=	$inviteObj->getInviteById($id);
		
		if(!isset($data['listId']))
		{
			$errorFlag=1;
		}
		if($errorFlag==1)
		{
			$this->redirect(Yii::app()->params->base_path."muser/invites");	
		}
		$data['listDetails']	=	$todoListsObj->getMyListById($data['listId']);
		$createdByDetails	=	$usersObj->getUserDetail($data['listDetails']['createdBy']);
		$data['createdByDetails'] = $createdByDetails['result'];
		$data['invitedBy']	=	$inviteObj->getInviterByInviteId($id);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/viewMoreInvite/id/".$id,"ViewMoreInvite",1);
		$this->render('inviteViewMore', array('data'=>$data));
		
	}		
	/*********** 	DELETE INVITATION FUNCTION  ***********/
	public function actionDeleteInvite($id=NULL)
	{
		if(isset($id)){
			$invitesObj	=	new Invites();
			$res = $invitesObj->deleteInvites($id);
			Yii::app()->user->setFlash("success", $this->msg['_INVITE_DELETE_']);
         	$this->redirect(Yii::app()->params->base_path."muser/invites");
            exit;
		} else {
			$this->redirect('index');
		}
	}

	/*********** 	DELETE TODO ITEM FUNCTION  ***********/
	public function actionDeleteItem($id=NULL)
	{
		if(isset($id)) {
			$todoItemObj	=	new TodoItems();
			$result	=	$todoItemObj->deleteItemById($id);
			Yii::app()->user->setFlash("success", $this->msg['_RECORD_DELETE_']);
         	$this->redirect(Yii::app()->params->base_path."muser/AssignedByMe");
			exit;
		} else {
			$this->redirect('index');
		}
	}
	
	/*********** 	DELETE TODO ITEM FUNCTION  ***********/
	public function actionDeleteMyTodoItem($id=NULL)
	{
		if(isset($id)) {
			$todoItemObj	=	new TodoItems();
			$result	=	$todoItemObj->deleteItemById($id);
			Yii::app()->user->setFlash("success", $this->msg['_RECORD_DELETE_']);
         	$this->redirect(Yii::app()->params->base_path."muser/mytodo");
			exit;
		} else {
			$this->redirect('index');
		}
	}
	
	/*********** 	CHANGE INVITATION STATUS FUNCTION  ***********/
	public function actionChangeStatus($id=NULL, $status=2)
	{
		if(isset($id)){
			$invitesObj	=	new Invites();
			$invitesObj->changeStatus($id, $status);
			Yii::app()->user->setFlash("success", $this->msg['_INVITE_ACCEPT_']);
         	$this->redirect(Yii::app()->params->base_path."muser/invites");
			exit;
		} else {
			$this->redirect('index');
		}
	}
	
	/***********  CHANGE ITEM STATUS FUNCTION  ***********/
	public function actionChangeTodoItemStatus($id=NULL, $stat=NULL)
	{
		if( isset($id) && isset($stat) ){
			$id	=	$id;
			$stat	=	$stat;
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$sessionArray['fullname']	=	Yii::app()->session['fullname'];
			$todoItemsObj	=	new TodoItems();
			$todoItemsObj->changeTodoItemsStatus($id,$stat,$sessionArray);
			Yii::app()->user->setFlash('success',$this->msg['_STATUS_UPDATE_']);	
			$this->redirect(Yii::app()->params->base_path."muser/itemDescription/id/".$id);
			exit;
		} else {
			$this->redirect(Yii::app()->params->base_path.'muser/index');
		}
	}

	public function actionReminderViewMore($id=NULL, $popUp=NULL)
	{	$errorFlag=0;
		if($id == NULL && $id == '')
		{
			$errorFlag=1;
		}
		
		if($errorFlag==1)
		{
			$this->redirect(Yii::app()->params->base_path."muser/invites");	
		}
		$reminderObj	=	new Reminder();
		$reminder	=	$reminderObj->getReminderById($id);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/invites/id".$id,"Invite",1);
		if(!empty($reminder) && $reminder!='')
		{
			$this->render('reminderViewMore', array('data'=>$reminder));
		}
		else
		{
			$this->render("/site/error");
		}
	}
	/*********** 	REMINDERS FUNCTION  ***********/
	public function actionReminders($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$reminderObj	=	new Reminder();
		if($id!=NULL)
		{
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$result	=	$reminderObj->remindMe($id, $sessionArray);
			Yii::app()->user->setFlash('success',$result['message']);
		}
		$reminders	=	$reminderObj->getReminderByUserId(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/reminders","Reminders",0);
		$this->render('reminders', array('data'=>$reminders));
	}
	
	/*********** 	ADD TODO ITEMS FUNCTION  ***********/
	public function actionAddTodo($edit=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$errorFlag=0;
		if(isset($_POST) && !empty($_POST))
		{
			$TodoItemsObj=new TodoItems();
				
			if(isset($_FILES['attachmentFile']['tmp_name']) && $_FILES['attachmentFile']['tmp_name']!='')
			{
				$_POST['userId']=Yii::app()->session['loginId'];
				$_POST['loginIdType']=Yii::app()->session['loginIdType'];
				$userObj = new Users;
				$result=$userObj->uploadAttachment($_POST,$_FILES);
				if($result['status']!=0)
				{
					Yii::app()->user->setFlash('error',$result['message']);
					$errorFlag=1;
				}
				$_POST['attachment']=$result['message'];
			}
				
			if(!isset($_POST['attachment'])){
				$_POST['attachment']='';
			}	
			if(isset($_POST['title']) && $_POST['title']=='')
			{	
				Yii::app()->user->setFlash('error', $this->msg['_TODOTITLE_VALIDATE_']);
				$errorFlag=1;
			}
			if($errorFlag==0)
			{	
				$sessionArray['loginId']=Yii::app()->session['loginId'];
				$sessionArray['fullname']=Yii::app()->session['fullname'];
				if(isset($_POST['id']) && $_POST['id']!=''){
					$result=$TodoItemsObj->addTodoItem($_POST,$sessionArray,$_POST['id']);
				} else {
					$result=$TodoItemsObj->addTodoItem($_POST,$sessionArray);
				}
				
				if($result['status']==0)
				{	
					Yii::app()->user->setFlash('success',$result['message']);
					$this->redirect(Yii::app()->params->base_path."muser/index");
					exit;
				}
				else
				{
					Yii::app()->user->setFlash('error',$result['message']);
					if(isset($_POST['action']) && $_POST['action']=='reassign')
					{					
						$this->redirect(Yii::app()->params->base_path."muser/reassignTask/id/".$_POST['id']);
						exit;
						
					}
					
					
				}
			}
		}
		$items = array();
		$userObj = new Users();
		$items = $userObj->getAllUsers();
		$loginObj = new Login();
		$logindata=$loginObj->getUserId(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddTodo","Add TODO",0);
		$todoListsObj	=	new TodoLists();
		$items['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($items['myLists']['pendingItems']);
		$todoNetworkObj =  new Todonetwork();
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId']);
		
				
		$this->render('addTodoItem', array('data'=>$items,'networkdata'=>$networks['networks'],'lastFavrite'=>$logindata));
	}
	
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionmyLists()
	{
		
		$todoListsObj	=	new TodoLists();
		$todoItemsObj	=	new TodoItems();
		$limit = 5;
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/myLists","My List",0);
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		$myLists	=	$todoListsObj->myLists(Yii::app()->session['loginId'],$limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->render('myLists', array('data'=>$myLists['items'],'pagination'=>$myLists['pagination'],'ext'=>$ext));
		//$this->render('myLists', array('data'=>$myListsResult,'pagination'=>$myLists['pagination']));
	}
	
	
	public function actionItemAjax()
	{
		$todoListsObj	=	new TodoLists();
		$todoItemsObj	=	new TodoItems();
		$myLists	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($myLists['myLists']['pendingItems']);
		$mytodoitems =	$todoItemsObj->getMyToDoItemsUserWiseCount(Yii::app()->session['loginId']);
		$othersTodoItems =	$todoItemsObj->getOtherToDoItemsUserWiseCount(Yii::app()->session['loginId']);
		$assingByMeItems =	$todoItemsObj->getassingByMeItemsUserWiseCount(Yii::app()->session['loginId']);
		$myLists = $this->array_sort($myLists, 'pendingItems', SORT_DESC);
		$this->render('itemWidgetAjax', array('data'=>$myLists,'mytodoitems'=>$mytodoitems['items'],'assingByMeItems'=>$assingByMeItems['items'],'othersTodoItems'=>$othersTodoItems['items']));
	}
	
	//for confirming delete request
	public function actionDeleteConfirm()
	{
			if(isset($_REQUEST['functionname']) && isset($_REQUEST['deleteId']))
			{
				$this->render('delete_confirm', array('data'=>$_REQUEST));
			}
			else
			{
				$this->redirect(Yii::app()->params->base_path."muser/index");	
			}
	}
	
	public function actionReassignTask($id=NULL)
	{
		$loginObj=new Login();
		$loginData=$loginObj->getLoginDetailsById(Yii::app()->session['loginId'],'last_todoassign');
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/reassignTask/id/".$id,"ReassignTask",2);
		$this->render('reassignTask', array('id'=>$id,'last_todoassign'=>$loginData['last_todoassign']));
		
	}
	
	/***********  QUERY TODO ITEM FUNCTION  ***********/
	public function actionAssignBack($itemId=NULL)
	{
		$todoItemsObj	=	new TodoItems();
			
		if( isset($_POST['id']) ) {			
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$_POST['userId']	=	Yii::app()->session['loginId'];
			$result	=	$todoItemsObj->assignBack($_POST, $sessionArray);
			//$result	=	array('status'=>0, 'message'=>'success');
			$result['message']	.=	'<script type="text/javascript">setTimeout(function() {
				$j("#update-message").fadeOut();
			}, 10000 );</script>';
			if($result['status']==0)
			{
				Yii::app()->user->setFlash("success", $result['message']);
				$this->redirect(Yii::app()->params->base_path."muser/mytodo");
			}
			else
			{
				Yii::app()->user->setFlash("error", $result['message']);
				$this->redirect(Yii::app()->params->base_path."muser/AssignBack/itemId/".$_REQUEST['id']);
			}
						
			
			
			exit;
		}
			$helperObj=new Helper();
			$helperObj->setMobileBreadCrumb("muser/assignBack/id/".$itemId['id'],"AssignBack",2);
			
			$this->render('assignBack', array('data'=>$itemId));
	}
	
	
	public function actionaddToDoItem($edit=NULL)
	{
		
	}
	
	public function actionsaveToDoList()
	{
		$data = array();
		$succstr = '';
		$errstr = '';
		
		if($_POST['todoList'] == '' || $_POST['id'] == '')
		{
			echo json_encode(array("status"=>$this->errorCode['_ADDTODO_VALIDATION_'],"message"=>$this->msg['_ADDTODO_VALIDATION_']));
			exit;
		}
			$todoListObj =  new TodoLists();
			$res = $todoListObj->checkList($_POST['todoList'],Yii::app()->session['loginId']);
			if($res == NULL)
			{
				$sessionArray['loginId']=Yii::app()->session['loginId'];
				$sessionArray['fullname']=Yii::app()->session['fullname'];
				$res = $todoListObj->SaveTodoList($_POST,$sessionArray);
				$succstr .= $this->msg['_TODO_ADD_SUCCESS_'];
				if(!empty($res[0]))
					{
							for($i=0;$i<count($res[0]);$i++)
							{
								$succstr .= $res[0][$i]['email'].''.$res[0][$i]['message'].'<br>';
							}
					}
					if(!empty($res[1]))
					{
						$str = '';
						for($i=0;$i<count($res[1]);$i++)
						{
							$errstr .= $res[1][$i]['email'].''.$res[1][$i]['message'].'<br>';
						}
					}
					$this->callDaemon('send_email');
				
			}
			else
			{
				$errstr .= $this->msg['_LIST_NAME_EXIT_'];
			}
			if(isset($errstr) && $errstr != '')
			{
				Yii::app()->user->setFlash('error',$errstr);
			}
			if(isset($errstr) && $errstr != '')
			{
				Yii::app()->user->setFlash('success',$succstr);
			}
			//echo json_encode(array('succstr'=>$succstr, 'errstr'=>$errstr));	
			$this->redirect(Yii::app()->params->base_path."muser/myLists");
		/*$data = array();
		$succstr = '';
		$errstr = '';
		
		if($_POST['todoList'] == '' || $_POST['id'] == '')
		{
			Yii::app()->user->setFlash('error',$this->msg['_ADDTODO_VALIDATION_']);
			$this->redirect(Yii::app()->params->base_path."muser/AddTodoList");
			exit;
		}
			$todoListObj =  new TodoLists();
			$res = $todoListObj->checkList($_POST['todoList'],Yii::app()->session['loginId']);
			if($res == NULL)
			{
				$sessionArray['loginId']=Yii::app()->session['loginId'];
				$sessionArray['fullname']=Yii::app()->session['fullname'];
				$res = $todoListObj->SaveTodoList($_POST, $sessionArray);
				if(!empty($res))
				{
					$id = Yii::app()->db->getLastInsertID();
					$_POST['listId']=$id;
					$_POST['createdBy']=Yii::app()->session['loginId'];
					$sessionArray['loginId']=Yii::app()->session['loginId'];
					$sessionArray['fullname']=Yii::app()->session['fullname'];
					$res = $todoListObj->addInviteUser($_POST,$sessionArray);
					
					$succstr .= $this->msg['_TODO_ADD_SUCCESS_'];
					if(!empty($res[0]))
					{
							for($i=0;$i<count($res[0]);$i++)
							{
								$succstr .= $res[0][$i]['email'].''.$res[0][$i]['message'].'<br>';
							}
					}
					if(!empty($res[1]))
					{
						$str = '';
						for($i=0;$i<count($res[1]);$i++)
						{
							$errstr .= $res[1][$i]['email'].''.$res[1][$i]['message'].'<br>';
						}
					}
					$this->callDaemon('send_email');
				}
			}
			else
			{
				$errstr .= $this->msg['_LIST_NAME_EXIT_'];
			}
			if(isset($errstr) && $errstr != '')
			{
				Yii::app()->user->setFlash('error',$errstr);
			}
			if(isset($errstr) && $errstr != '')
			{
				Yii::app()->user->setFlash('success',$succstr);
			}
			$this->redirect(Yii::app()->params->base_path."muser/myLists");*/
			
	}
	
	public function actionaddInviteUser()
	{
		
		$data = array();
		if($_POST['todoList'] == '' || $_POST['id'] == '')
		{
			Yii::app()->user->setFlash('error',$this->msg['_EMAIL_VALIDATION_']);
			$this->redirect(Yii::app()->params->base_path."muser/addnetwork");
			exit;
		}
		if(isset($_POST['email']) && $_POST['email'] == '')
		{
			Yii::app()->user->setFlash('error',$this->msg['_EMAIL_VALIDATION_']);
			$this->redirect(Yii::app()->params->base_path."muser/addnetwork");
			exit;
		}
		if(isset($_POST['userlist']) && $_POST['userlist'] == '')
		{
			Yii::app()->user->setFlash('error',$this->msg['_EMAIL_VALIDATION_']);
			$this->redirect(Yii::app()->params->base_path."muser/addinvite");
			exit;
		}
		if(isset($_POST['email']) && $_POST['email'] != '')
		{
			$_POST['userlist']=$_POST['email'];
		}
		$_POST['listId']=$_POST['todoList'];
		$_POST['createdBy']=Yii::app()->session['loginId'];
		
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['fullname']=Yii::app()->session['fullname'];		
		$todoListObj =  new TodoLists();
		$result = $todoListObj->addInviteUser($_POST,$sessionArray);
		if(empty($result[0]) && isset($result[1]))
		{
			Yii::app()->user->setFlash('error',$result[1][0]['message']);
			if(isset($_POST['userlist']))
			{
				$this->redirect(Yii::app()->params->base_path."muser/addinvite");
			}
			else
			{
				$this->redirect(Yii::app()->params->base_path."muser/addnetwork");
			}
			exit;
		}
		
		//$this->callDaemon('send_email');
		if(isset($_POST['email']) && $_POST['email'] != '')
		{
			Yii::app()->user->setFlash('success',$this->msg['_ADD_NETWORK_']);
			$this->redirect(Yii::app()->params->base_path."muser/myNetwork");
			exit;
		}
		else
		{
			Yii::app()->user->setFlash('success',$this->msg['_USER_INVITE_']);
			$this->redirect(Yii::app()->params->base_path."muser/invites");
			exit;
		}
	}
	
	public function callDaemon($daemon_name = "hirenow")
	{
        $sig = new signals_lib();
        $sig->get_queue($this->arr[$daemon_name]);
        $sig->send_msg($daemon_name);
    }
	
	
	 /*****************Upload Avatar ***************/
 	public function actionAvatar($stat = NULL)
	{
		$session = Yii::app()->getSession();
		$_POST['userId']=$session['loginId'];
		$_POST['loginIdType']=$session['loginIdType'];
		$userObj = new Users;
		$result=$userObj->uploadAvatar($_POST,$_FILES,$stat);
		echo json_encode($result);
		
	}	 	
	
	 /*****************Upload Avatar ***************/
 	public function actionAttachment($stat = NULL)
	{
		$session = Yii::app()->getSession();
		$_POST['userId']=$session['loginId'];
		$_POST['loginIdType']=$session['loginIdType'];
		$userObj = new Users;
		$result=$userObj->uploadAttachment($_POST,$_FILES,$stat);
		echo json_encode($result);
		
	}	 	
	
	/*********** 	ADD TODO ITEMS FUNCTION  ***********/
	public function actionAddTodoList()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$items = array();
		$userObj = new Users();
		$items = $userObj->getAllUsers();
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddTodoList","AddTodoList",1);
		$result = array();
		$this->render('addTodoList', array('data'=>$items));
	}
	
	/*********** 	ADD TODO ITEMS FUNCTION  ***********/
	public function actionAddInvite()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$items = array();
		$userObj = new Users();
		$items = $userObj->getAllUsers();
		$todoListsObj	=	new TodoLists();
		$myLists	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddInvite","Add Invite",1);
		unset($myLists['pendingItems']);
		$result = array();
		$this->render('addTodoInvite', array('data'=>$items,'myList'=>$myLists));
	}
	
	/*********** 	MY TODO ITEMS FUNCTION  ***********/
	public function actionMyTodo($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keyword=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/mytodo","My TODO",0);
		
		$sessionArray['mylist']=0;
		$sessionArray['mytodoStatus']=0;
		if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0)
		{			
			$sessionArray['mylist']=$_REQUEST['mylist'];
		}
		else
		{
			$sessionArray['mylist']=0;
		}
		if(isset($_POST['mytodoStatus']) && $_POST['mytodoStatus']!=0)
		{			
			$sessionArray['mytodoStatus']=$_POST['mytodoStatus'];
		}
		if(isset($_GET['from']))
		{			
			$from=$_GET['from'];
		}else
		{
			$from='index';
		}
		if($moreflag==1) {
			$limit=LIMIT_10;	
		} else {
			$limit=5;
		}
		
		$todoItemsObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj = new Users();
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$items['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'myOpenStatus , myDoneStatus, myCloseStatus');
		$items['moreflag']=$moreflag;
		
		$data	=	$todoItemsObj->getMyToDoItems($sessionArray,$limit, $sortType, $sortBy);
		$items['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['currentList']	=	$sessionArray['mylist'];
		unset($items['myLists']['pendingItems']);
		
		$this->render('myTodo', array('data'=>$data,'items'=>$items));
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionAssignedByMe($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$id=NULL,$keyword=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AssignedByMe","Assigned by me",0);
		
		$sessionArray['mylist']=0;
		$sessionArray['mytodoStatus']=0;
		if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0)
		{			
			$sessionArray['mylist']=$_REQUEST['mylist'];
		}
		else 
		{
			$sessionArray['mylist']=0;
		}
		if(isset($_REQUEST['mytodoStatus']) && $_REQUEST['mytodoStatus']!=0)
		{			
			$sessionArray['mytodoStatus']=$_REQUEST['mytodoStatus'];
		}
		if(isset($_GET['from']))
		{			
			$from=$_GET['from'];
		}else
		{
			$from='index';
		}

		$extraPara=$sessionArray;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		if( $moreflag == 1 ) {
			$limit=10;	
		} else {
			$limit=5;
		}		
		
		$todoItemsObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		$items	=	$todoItemsObj->getAssignedByMeItems($sessionArray, 5, $sortType, $sortBy);
		$items['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'byMeOpenStatus, byMeDoneStatus, byMeCloseStatus');
		$items['moreflag']=$moreflag;
		$items['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['currentList']	=	$sessionArray['mylist'];
		unset($items['myLists']['pendingItems']);
		
		$this->render('assignedByMeTodo', array('data'=>$items));
	}
	
	/*********** 	OTHERS TODO ITEMS FUNCTION  ***********/
	public function actionOthersTodo($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keyword=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/OthersTodo","Others TODO",0);
		
		$sessionArray['mylist']=0;
		$sessionArray['mytodoStatus']=0;
		if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0)
		{			
			$sessionArray['mylist']=$_REQUEST['mylist'];
		}
		else
		{
			$sessionArray['mylist']=0;
		}
		if(isset($_REQUEST['mytodoStatus']) && $_REQUEST['mytodoStatus']!=0)
		{			
			$sessionArray['mytodoStatus']=$_REQUEST['mytodoStatus'];
		}
		if(isset($_GET['from']))
		{			
			$from=$_GET['from'];
		}else
		{
			$from='index';
		}

		if( $moreflag == 1 ) {
			$limit=10;	
		} else {
			$limit=5;
		}
		$extraPara=$sessionArray;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['userId']=Yii::app()->session['userId'];
		
		$todoItemsObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		$others	=	$todoItemsObj->getOtherToDoItems($sessionArray, 5, $sortType, $sortBy);
		$others['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'otherOpenStatus, otherDoneStatus, otherCloseStatus');
		$others['moreflag']=$moreflag;
		$others['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$others['currentList']	=	$sessionArray['mylist'];
		unset($others['myLists']['pendingItems']);
		
		$this->render('othersTodo', array('data'=>$others));
	}

	
	function actionChangeShowStatus()
	{
		
		if( isset($_GET['field']) ) {
			$usersObj	=	new Users();
			$result	=	$usersObj->changeShowStatus(Yii::app()->session['userId'], $_GET);
			
			if( $result['status'] == 0 ) {
				if(isset($_REQUEST['mylist']) && $_REQUEST['mylist']!=0) {			
					$sessionArray['mylist']=$_REQUEST['mylist'];
				} else {
					$sessionArray['mylist']=0;
				}
				
				if( isset($_REQUEST['url']) ) {			
					$url	=	$_REQUEST['url'];
				} else {
					$url	=	'mytodo';
				}
				
				$this->redirect(Yii::app()->params->base_path.'muser/'.$url.'/mylist/'.$sessionArray['mylist']);
			} else {
				$this->render("/site/error");
			}
		} else {
			$this->render("/site/error");
		}
	}
	
	/*********** 	OTHERS TODO ITEMS FUNCTION  ***********/
	public function actionTodoItems($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$sessionArray['mylist']=0;
		$sessionArray['mytodoStatus']=0;
		if(isset($_POST['mylist']) && $_POST['mylist']!=0)
		{			
			$sessionArray['mylist']=$_POST['mylist'];
		}
		if(isset($_POST['mytodoStatus']) && $_POST['mytodoStatus']!=0)
		{			
			$sessionArray['mytodoStatus']=$_POST['mytodoStatus'];
		}
		$sessionArray['loginId']=Yii::app()->session['loginId'];

		$todoItemsObj	=	new TodoItems();
		$items	=	$todoItemsObj->getMyTodoItemsByList($sessionArray, $id);
		
		$this->render('myItems', array('data'=>$items));
	}

	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionItemDescription($id=NULL,$event='')
	{
		
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		if($event=='email')
		{
			$reminderObj	=	new Reminder();
			$sessionArray['loginId']=Yii::app()->session['loginId'];
			$sessionArray['fullname']=Yii::app()->session['fullname'];
			$result = $reminderObj->remindeAgain($id, $sessionArray);
			Yii::app()->user->setFlash('success',$result['message']);
		}
		$todoItemsObj	=	new TodoItems();
		$item	=	$todoItemsObj->getItemDetails($id);
		$commentsObj	=	new Comments();
		$usersObj	=	new Users();
		$generalObj	=	new General();
		$algoencryptionObj	=	new Algoencryption();
		$comments	=	$commentsObj->getcommentsByItem($id);
		$index	=	0;
	    	
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/itemDescription/id/".$id,"TODO description",1);
		if(!empty($item) && $item!='')
		{
			foreach($comments as $comment){
				$commentByRes	=	$usersObj->getUserDetail($comment['userId']);
				$commentBy = $commentByRes['result'];
				$comments[$index]['commentedByFname']	=	$commentBy['firstName'];
				$comments[$index]['commentedByLname']	=	$commentBy['lastName'];
				$comments[$index]['avatar']	=	$commentBy['avatar'];
				$comments[$index]['imageDir']	=	$algoencryptionObj->encrypt("USER_".$comment['userId']);
				$comments[$index]['time']	=	$generalObj->rel_time($commentBy['createdAt'],date('Y-m-d H:i:s'));
				$index++;
			}
			$this->render('description', array('data'=>$item,'comments'=>$comments));
		}
		else
		{
			$this->render("/site/error");	
		}
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionlistDescription($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$todoListObj	=	new TodoLists();
		$inviteObj	=	new Invites();
		$item	=	$todoListObj->getListDetails($id);
		
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/listDescription/id/".$id,"List Description",1);

		
		if(!empty($item) && $item!='')
		{
			$listMembers	=	$inviteObj->getListMembers($id);
			$this->render('listdescription', array('data'=>$item,'listMembers'=>$listMembers['users'],'pagination'=>$listMembers['pagination']));
		}
		else
		{
			$this->render("/site/error");	
		}
	}
	
	/*********** 	ADD COMMENTS FUNCTION  ***********/
	public function actionAddComments()
	{
		$commentsObj	=	new Comments();
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$sessionArray['userId']	=	Yii::app()->session['userId'];
		$result	=	$commentsObj->addItemComments($_POST, $sessionArray);
		
		if( $result['status'] != 0 ) {
			Yii::app()->user->setFlash('error', $result['message']);
		} else {
			Yii::app()->user->setFlash('success', $result['message']);
		}
		$this->redirect(Yii::app()->params->base_path."muser/itemDescription/id/".$_POST['itemId']);
	}
	
	public function actiongetItemHistory($id=NULL)
	{
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/getItemHistory/id/".$id,"Item history",2);
		$todoItemChangeHistoryObj	=	new TodoItemChangeHistory();
		$itemHistory	=	$todoItemChangeHistoryObj->getItemHistory($id);
		$list=array();
		if(isset($itemHistory[1][0]['listId']))
		{			
			$todoListsObj = new TodoLists();
			$list	=	$todoListsObj->getMyListById($itemHistory[1][0]['listId']);
		}
		$item=array();
		$title="";
		if(isset($itemHistory[1][0]['itemId']))
		{
			$todoItem = new TodoItems();
			$item	=	$todoItem->findByPk($itemHistory[1][0]['itemId']);
			$title = $item->attributes['title'];
		}
		
		$this->render('moreHistoryAjax', array('history'=>$itemHistory[1],'pagination'=>$itemHistory[0],'list'=>$list,'title'=>$title));
	}
	
	
	/*********** 	DELETE REMINDER FUNCTION  ***********/
	public function actionDeleteReminder($id=NULL)
	{
		if(isset($id)){
			$algo=new Algoencryption();
			if( !is_numeric($id) ) {
				$id	=	$algo->decrypt($id);
			}
			$reminderObj	=	new Reminder();
			$reminderObj->deleteByPk($id);
			Yii::app()->user->setFlash('success',$this->msg['_REMINDER_DELETE_MESSAGE_']);
			$this->redirect(Yii::app()->params->base_path."muser/reminders");
			exit;
		} else {
			$this->redirect(Yii::app()->params->base_path."muser/reminders");
			exit;
		}
	}
	
	/*********** 	ADD REMINDER FUNCTION  ***********/
	public function actionAddReminder($id=NULL)
	{
		$reminderObj	=	new Reminder();
		$algoencryptionObj	=	new Algoencryption();
		$data	=	array();
		if(isset($id) && $id != '' ){
			$data	=	$reminderObj->getReminderById($id);
			$data['ampm']	=	date('a', strtotime($data['time']));
			$data['time']	=	date('g', strtotime($data['time']));
		}
		
		if($_POST){
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$reminderObj	=	new Reminder();
			
			if( !isset($_POST['id']) ) {
				$result	=	$reminderObj->addReminder($_POST, $sessionArray);
			} else {
				$result	=	$reminderObj->addReminder($_POST, $sessionArray, $_POST['id']);
			}
			if($result['status']==0)
			{
				Yii::app()->user->setFlash('success', $result['message']);
				$this->redirect(Yii::app()->params->base_path."muser/reminders");
			}
			else
			{
				Yii::app()->user->setFlash('error', $result['message']);
				if( isset($_POST['id']) ) {
					$encryptId	=	$algoencryptionObj->encrypt($_POST['id']);
					$this->redirect(Yii::app()->params->base_path."muser/addReminder/id/".$encryptId);
				} else {
					$this->redirect(Yii::app()->params->base_path."muser/addReminder");
				}
			}
			//echo json_encode($result);
			exit;
		}
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddReminder","AddReminder",1);
		$todoListObj	=	new TodoLists();
		$data['lists']	=	$todoListObj->getAllMyList(Yii::app()->session['loginId']);
		unset($data['lists']['pendingItems']);
		$this->render('addReminder', array('data'=>$data));
	}
	
	
	/*********** 	DELETE REMINDER FUNCTION  ***********/
	public function actionCloseAccount()
	{
		$reason='';
		if(isset($_POST['reason']) && $_POST['reason']!='')
		{
			if($_POST['reason']!='' && $_POST['reason']!='Other')
			{
				$reason=$_POST['reason'];
			}
			else
			{
				$reason=$_POST['txtother'];
			}
			$loginObj=new Login();
			$result=$loginObj->deleteById(Yii::app()->session['loginId'],$reason);
			Yii::app()->user->setFlash("success", $this->msg['_ACCOUNT_DELETE_']);
         	$this->redirect(Yii::app()->params->base_path."muser/index");
            exit;
		}
		else
		{	
			$this->redirect(Yii::app()->params->base_path."muser/index");
		}
		
	}
	
	
	public function actionverifyPhone()
	{
		$this->render("verify_phone");
	}
	
	public function actionLogin()
	{
		/***********		Login		************/
		if(isset($_POST['submit_login']))
		{
			$remember=0;
			if(isset($_POST['remenber']))
			{
				$remember=1;
			}
			
			$email_login = $_POST['email_login'];
			$password_login = $_POST['password_login'];
			$Userobj=new Users();		
			$result = $Userobj->login(trim($email_login),$password_login,$remember);
			if($result['status'] == 0)
			{
				$this->redirect(Yii::app()->params->base_path.'user/index');
				exit;
			}
			else
			{
				Yii::app()->user->setFlash($this->errorCode['_LOGIN_ERROR_'], $this->msg['_LOGIN_ERROR_']);
				header('location:'.Yii::app()->params->base_path.'user/signin');
			}
		}
		else
		{
			header('location:'.BASE_PATH.'user/index');
		}
	
		exit;
	}
	
	/*********** 	Logout   ***********/ 
	public function actionLogout()
	{
		global $msg;
		$temp=Yii::app()->session['prefferd_language'];
		if(isset(Yii::app()->session['loginId']))
		{
			Yii::app()->session->destroy();			
		}
		Yii::app()->session['prefferd_language']=$temp;		
		header('location:'.Yii::app()->params->base_path.'msite');
		exit;
	}
	
	/*****************method - change password ***************/
	public function actionchangePassword()
	{
		$algoencryptionObj	=	new Algoencryption();
		$generalObj	=	new General();
		$encryptedUserId	=	$algoencryptionObj->encrypt(Yii::app()->session['loginId']);
		
		if(isset($_POST['oldpassword']))
		{
			$_POST['userId']=Yii::app()->session['loginId'];
			$user = new Users();
			$result=$user->changePassword($_POST);
			if($result[0]==true)
			{
				Yii::app()->user->setFlash("success",$this->msg['_PASSWORD_CHANGE_']);
				unset($_POST);
			}
			else
			{
				Yii::app()->user->setFlash("error",$result[1]);
				
			}			
		}
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/changePassword","changePassword",1);
		
		$this->render('changepassword',array('result'=>'','fToken'=>'','encryptedUserId'=>$encryptedUserId,'userId'=>Yii::app()->session['loginId']));
	}
	
	public function actionSetting()
	{
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/setting","Setting",1);
		$this->render('setting');
	}
	
	public function actionDeleteAccountConfirm()
	{
		$data	=	$_POST;
		$validator = new FormValidator();
		if(isset($_POST['reason']))
		{
			if($_POST['reason']!='' && $_POST['reason']!='Other')
			{
				$reason=$_POST['reason'];
			}
			else
			{
				$reason=$_POST['txtother'];
			}
			if(trim($reason)=='')
			{
				Yii::app()->user->setFlash($this->errorCode['_REASON_SPECIFY_'],$this->msg['_REASON_SPECIFY_']);
				header('location:'.Yii::app()->params->base_path.'muser/setting');
				exit;
			}
			if(isset($_POST['txtother']))
			{
				$validator->addValidation("txtother","description",$this->msg['_REASON_SPECIAL_CHAR_']);		
			}
			if(!$validator->ValidateForm())
			{
				Yii::app()->user->setFlash($this->errorCode['_DONT_USE_SPECIAL_CHAR_'],$this->msg['_DONT_USE_SPECIAL_CHAR_']);				
				header('location:'.Yii::app()->params->base_path.'muser/setting');
				exit;			
			}
		}
		$this->render("delete_account_confirm", array('data'=>$data));
		
	}
	
	public function actionmyNetwork($sortType='desc', $sortBy='id', $flag=0)
	{
		$todoNetworkObj	=	new Todonetwork();
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId'], LIMIT_10, $sortType, $sortBy);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/myNetwork","My Network",0);
		$todoLists = new TodoLists();
		$list = $todoLists->getAllMyList(Yii::app()->session['loginId']);
		unset($list['pendingItems']);
		if($sortType == 'desc'){
			$networks['sortType']	=	'asc';
			$networks['img_name']	=	'arrow_up.png';
		} else {
			$networks['sortType']	=	'desc';
			$networks['img_name']	=	'arrow_down.png';
		}
		if($flag == 0){
			$networks['img_name']	=	'';
		}
		$networks['sortBy']	=	$sortBy;
		
		$this->render('myNetwork', array('networks'=>$networks,'list'=>$list));
	}
	
	/*public function actionaddnetwork()
	{	
		$todoLists = new TodoLists();
		$list = $todoLists->getAllMyList(Yii::app()->session['loginId']);
		unset($list['pendingItems']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/addnetwork","addnetwork",1);
		$this->render('addNetwork', array('list'=>$list));
	}*/
	
	public function actionmyNetworkUser()
	{	
		$todoNetworkObj	=	new Todonetwork();
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/myNetwork","My Network",0);
		$this->renderPartial('myNetworkUser', array('networks'=>$networks));
	}

	
	public function actionremoveFrommyNetwork()
	{
		$id = $_GET['id'];
		$todoNetwork=Todonetwork::model()->findbyPk($id);
		$todoNetwork->delete();
		Yii::app()->user->setFlash("success", $this->msg['_NETWORK_DELETE_']);
		$this->redirect(Yii::app()->params->base_path."muser/myNetwork");
		exit;
	}
	
	public function actionremoveList()
	{
		$id = $_GET['id'];
		$todoLists=TodoLists::model()->findbyPk($id);
		$todoLists->delete();
		Yii::app()->user->setFlash("success", $this->msg['_ITEM_DELETE_']);
		$this->redirect(Yii::app()->params->base_path."muser/myLists");
		exit;
	}
	
	public function actionupdateToDoList()
	{
		$data  = array();
		$data['name'] = $_GET['title'];
		$data['description'] = $_GET['desc'];
		$data['id'] = $_GET['listId'];
		$todoLists=TodoLists::model()->findbyPk($data['id']);
		$todoLists->setData($data);
		$todoLists->insertData($data['id']);
		echo 1;
	}
	
	//Redirecting to add linkedin page	
	public function actionAddLinkedin()
	{
		$userObj = new Users();
		$data = $userObj->getUserDetail(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddLinkedin","AddLinkedin",1);
		$this->render("linkedin", array('data'=>$data['result']));	
	}
	
	//Redirecting to add twitter page	
	public function actionAddTwitter()
	{
		$userObj = new Users();
		$data = $userObj->getUserDetail(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddTwitter","AddTwitter",1);
		$this->render("twitter", array('data'=>$data['result']));	
	}
	
	//Redirecting to add facebook page	
	public function actionAddFacebook()
	{
		$userObj = new Users();
		$data = $userObj->getUserDetail(Yii::app()->session['loginId']);
		$helperObj=new Helper();
		$helperObj->setMobileBreadCrumb("muser/AddFacebook","AddFacebook",1);
		$this->render("facebook", array('data'=>$data['result']));	
	}

	public function actionupdateLink()
	{
		$userObj	=	new Users();
		$_POST['id']	=	Yii::app()->session['userId'];
		$result	=	$userObj->updateSocialLink($_POST);
		
		if($result['status']==0)
		{
			if($result['message']!='success')
			{
				Yii::app()->user->setFlash("success",$result['message']);
			}
			Yii::app()->user->setFlash("success",$this->msg['_SUCCESSFULLY_UPDATED_']);
			header('location:'.Yii::app()->params->base_path.'muser/'.$_POST['action']);
			exit;
		}
		else
		{
			Yii::app()->user->setFlash("error",$result['message']);
			header('location:'.Yii::app()->params->base_path.'muser/'.$_POST['action']);
			exit;
		} 
	}
}