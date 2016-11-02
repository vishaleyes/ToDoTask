<?php
error_reporting(E_ALL);
class UserController extends Controller
{
	public $msg;
	public $errorCode;
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	public function beforeAction()
	{
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
		if($this->isAjaxRequest())
		{			
			if(!$this->isLogin())
			{
				Yii::app()->user->logout();
				Yii::app()->session->destroy();
				echo "logout";
				exit;							
			}
		}
		else
		{
			
			if(!$this->isLogin())
			{
				Yii::app()->user->logout();
				Yii::app()->session->destroy();
				if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
				{					
					Yii::app()->session['todoId']=$_REQUEST['id'];
					$this->redirect(Yii::app()->params->base_path.'site/signin&todoId='.$_REQUEST['id']);
					exit;
				}
				$this->redirect(Yii::app()->params->base_path.'site');
				exit;
			}
			
		}
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
	
	function isLogin()
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
		if(isset(Yii::app()->session['todoId']) && Yii::app()->session['todoId']!='')
		{
			$id=Yii::app()->session['todoId'];
			unset(Yii::app()->session['todoId']);
			$this->redirect(Yii::app()->params->base_path.'user/itemDescription/id/'.$id.'/from/home');
			exit;
		}
			$todoitemsObj =  new TodoItems();
			$todoListsObj =  new TodoLists();
			$userObj = new Users();
			$loginObj	=	new Login();
			$invitesObj =  new Invites();
		
			$invites	=	$invitesObj->getInvitesByReceiverId(Yii::app()->session['loginId'],2);
			$myLists	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
			unset($myLists['pendingItems']);
			//echo '<pre>';print_r($myLists);exit;
			$algo=new Algoencryption();
			$imageDir=$algo->encrypt("USER_".Yii::app()->session['userId']);
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('home',array('imageDir'=>$imageDir,'invites'=>$invites['invites'], 'myLists'=>$myLists,"isAjax"=>'true'));
			}
			else
			{
				$this->render('home',array('imageDir'=>$imageDir,'invites'=>$invites['invites'], 'myLists'=>$myLists,"isAjax"=>'false'));
			}
	}
	
	function actionleftview()
	{
			$userObj = new Users();
			$loginObj	=	new Login();
			$res = $userObj->getUserDetail(Yii::app()->session['loginId']);
			$users = $res['result'];
			$users['email']		=	$loginObj->getVerifiedEmailById(Yii::app()->session['loginId']);
			$users['vPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['userId'], 1);
			$users['uPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['userId']);
			
			$algo=new Algoencryption();
			$imageDir=$algo->encrypt("USER_".Yii::app()->session['userId']);
			
			$this->renderPartial('leftview',array('users'=>$users,'imageDir'=>$imageDir));
	}
	
	function actionGetUpdatedCount()
	{
		$todoItemObj	=	new TodoItems();
		$result=$todoItemObj->getUpdatedCount(Yii::app()->session['loginId']);
		echo json_encode($result);
	}
	
	/******* MY TODO ITEMS AJAX FUNCTION *******/
	public function actionMyTodoItem($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keywordMyTODO=NULL)
	{
		error_reporting(E_ALL);
		$extraPaginationPara="";
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='id';
		}
		$limit=5;
		if(isset($_REQUEST['moreflag']) && $_REQUEST['moreflag']==1)
		{
			$limit=10;	
		}
		else
		{
			$_REQUEST['moreflag']=0;
		}
		
		if(!isset($_REQUEST['mylist']))
		{
			$_REQUEST['mylist']=0;
		}
		if(!isset($_REQUEST['mytodoStatus']))
		{
			$_REQUEST['mytodoStatus']=0;
			
		}		
		if(!isset($_REQUEST['keywordMyTODO']))
		{
			$_REQUEST['keywordMyTODO']='';
			
		}	
		if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!='')
		{
			$_REQUEST['keywordMyTODO']=$_REQUEST['keyword'];
		}
		if(!isset($_REQUEST['assignBySearch']))
		{
			$_REQUEST['assignBySearch']='';
		}
		if(!isset($_REQUEST['flag']))
		{
			$_REQUEST['flag']=0;
			
		}
				
		$todoItemObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$extraPara=$_REQUEST;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['mylist']=$_REQUEST['mylist'];
		$sessionArray['mytodoStatus']=$_REQUEST['mytodoStatus'];
		$items	=	$todoItemObj->getMyToDoItems($sessionArray,$limit, $_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keywordMyTODO'],$_REQUEST['assignBySearch']);
		
		$items['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'myOpenStatus , myDoneStatus, myCloseStatus');
		$items['moreflag']=$_REQUEST['moreflag'];
		
		if($_REQUEST['sortType'] == 'desc'){
			$items['sortType']	=	'asc';
			$items['img_name']	=	'arrow_up.png';
		} else {
			$items['sortType']	=	'desc';
			$items['img_name']	=	'arrow_down.png';
		}
		if($_REQUEST['flag'] == 0){
			$items['img_name']	=	'';
		}
		
		$items['sortBy']	=	$_REQUEST['sortBy'];
		$items['flag']=$_REQUEST['flag'];
		$items['mylist']=$_REQUEST['mylist'];
		$items['assignBySearch']=$_REQUEST['assignBySearch'];
		$items['count']	=	$todoItemObj->getMyTodoCount(Yii::app()->session['loginId']);
		$items['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['pendingItems'] = $items['myLists']['pendingItems'];
		unset($items['myLists']['pendingItems']);
		if(isset($_REQUEST['currentList']) && $_REQUEST['currentList']!=0) {			
			$items['currentList']=$_REQUEST['currentList'];
		}
		
		$this->renderPartial('myTodoAjax', array('items'=>$items,'extraPara'=>$extraPara));
	}
	
	/******* ASSIGNED BY ME TODO ITEMS AJAX FUNCTION *******/
	public function actionAssignedByMeTodoItem($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keywordAssignByMe=NULL)
	{
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='item.id';
		}
		$limit=5;
		if(isset($_REQUEST['moreflag']) && $_REQUEST['moreflag']==1)
		{
			$limit=10;	
		}
		else
		{
			$_REQUEST['moreflag']=0;
		}
		if(!isset($_REQUEST['mylist']))
		{
			$_REQUEST['mylist']=0;
			$mylist=0;
		}
		if(!isset($_REQUEST['mytodoStatus']))
		{
			$_REQUEST['mytodoStatus']=0;
			$mytodoStatus=0;
		}		
		if(!isset($_REQUEST['keywordAssignByMe']))
		{
			$_REQUEST['keywordAssignByMe']='';
		}	
		if(!isset($_REQUEST['assignToSearch']))
		{
			$_REQUEST['assignToSearch']='';
		}
		if(isset($_REQUEST['keyword']))
		{
			$_REQUEST['keywordAssignByMe']=$_REQUEST['keyword'];
		}
		if(!isset($_REQUEST['flag']))
		{
			$_REQUEST['flag']=0;
			$flag=0;
		}
		$sessionArray['mylist']=$_REQUEST['mylist'];
		$sessionArray['mytodoStatus']=$_REQUEST['mytodoStatus'];
		$extraPara=$_REQUEST;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		
		$todoItemObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$assignbyme	=	$todoItemObj->getAssignedByMeItems($sessionArray, $limit, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keywordAssignByMe'], $_REQUEST['assignToSearch']);
		$assignbyme['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'byMeOpenStatus, byMeDoneStatus, byMeCloseStatus');
		
		$assignbyme['moreflag']=$_REQUEST['moreflag'];
		if($_REQUEST['sortType'] == 'desc'){
			$assignbyme['sortType']	=	'asc';
			$assignbyme['img_name']	=	'arrow_up.png';
		} else {
			$assignbyme['sortType']	=	'desc';
			$assignbyme['img_name']	=	'arrow_down.png';
		}
		if($flag == 0){
			$assignbyme['img_name']	=	'';
		}
		$assignbyme['sortBy']	=	$_REQUEST['sortBy'];
		$assignbyme['assignToSearch']	=	$_REQUEST['assignToSearch'];
		
		$assignbyme['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['pendingItems'] = $assignbyme['myLists']['pendingItems'];
		unset($assignbyme['myLists']['pendingItems']);
		$assignbyme['count']		=	$todoItemObj->getByMeTodoCount(Yii::app()->session['loginId']);
		if(isset($_REQUEST['currentList']) && $_REQUEST['currentList']!=0) {			
			$assignbyme['currentList']=$_REQUEST['currentList'];
		}
		$this->renderPartial('assignedByMeTodoAjax', array('assignbyme'=>$assignbyme,'extraPara'=>$extraPara));
	}
	
	/******* OTHER TODO ITEMS AJAX FUNCTION *******/
	public function actionOtherTodoItem($moreflag=0,$sortType='desc', $sortBy='itemId', $flag=0,$keywordOther=NULL)
	{
	
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='item.id';
		}
		$limit=5;
		if(isset($_REQUEST['moreflag']) && $_REQUEST['moreflag']==1)
		{
			$limit=10;	
		}
		else
		{
			$_REQUEST['moreflag']=0;
		}
		if(!isset($_REQUEST['mylist']))
		{
			$_REQUEST['mylist']=0;
		}
		if(!isset($_REQUEST['mytodoStatus']))
		{
			$_REQUEST['mytodoStatus']=0;
		}		
		if(!isset($_REQUEST['keywordOther']))
		{
			$_REQUEST['keywordOther']='';
		}	
		if(isset($_REQUEST['keyword']))
		{
			$_REQUEST['keywordOther']=$_REQUEST['keyword'];
		}
		if(!isset($_REQUEST['assignToSearch']))
		{
			$_REQUEST['assignToSearch']='';
		}
		if(!isset($_REQUEST['assignBySearch']))
		{
			$_REQUEST['assignBySearch']='';
		}
		if(!isset($_REQUEST['flag']))
		{
			$_REQUEST['flag']=0;
		}
		
		$extraPara=$_REQUEST;
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['userId']=Yii::app()->session['userId'];
		$sessionArray['mylist']=$_REQUEST['mylist'];
		
		$todoItemObj	=	new TodoItems();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$others	=	$todoItemObj->getOtherToDoItems($sessionArray, $limit, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keywordOther'], $_REQUEST['assignBySearch'],$_REQUEST['assignToSearch']);
		$others['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'otherOpenStatus, otherDoneStatus, otherCloseStatus');
		
		$others['moreflag']=$_REQUEST['moreflag'];
		if($_REQUEST['sortType'] == 'desc'){
			$others['sortType']	=	'asc';
			$others['img_name']	=	'arrow_up.png';
		} else {
			$others['sortType']	=	'desc';
			$others['img_name']	=	'arrow_down.png';
		}
		if($flag == 0){
			$others['img_name']	=	'';
		}
		$others['sortBy']	=	$_REQUEST['sortBy'];
		$others['assignBySearch']=$_REQUEST['assignBySearch'];
		$others['assignToSearch']	=	$_REQUEST['assignToSearch'];
		$others['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$items['pendingItems'] = $others['myLists']['pendingItems'];
		unset($others['myLists']['pendingItems']);
		$others['count']	=	$todoItemObj->getOtherTodoCount(Yii::app()->session['loginId']);
		if(isset($_REQUEST['currentList']) && $_REQUEST['currentList']!=0) {			
			$others['currentList']=$_REQUEST['currentList'];
		}
		$this->renderPartial('othersTodoAjax', array('others'=>$others,'extraPara'=>$extraPara));
	}
	
	function actionShowAll()
	{
		$usersObj	=	new Users();
		$result	=	$usersObj->showAll(Yii::app()->session['userId']);
		echo json_encode($result);
	}
	
	function actionChangeShowStatus()
	{
		if( isset($_POST['field']) ) {
			$usersObj	=	new Users();
			$result	=	$usersObj->changeShowStatus(Yii::app()->session['userId'], $_POST);
			
			if( $result['status'] == 0 ) {
				echo json_encode($result);
			} else {
				$this->render("/site/error");
			}
		} else {
			$this->render("/site/error");
		}
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
		$userObj	=	new Users();
		$loginObj	=	new Login();
		$data	=	array();
		$res	=	$userObj->getUserDetail(Yii::app()->session['loginId']);
		$data['userData'] = $res['result'];
		$data['vPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['userId'], 1);
		$data['uPhone']	=	$loginObj->getUserPhonesById(Yii::app()->session['userId']);
		$data['email']	=	$loginObj->getVerifiedEmailById(Yii::app()->session['loginId']);
		$genralObj	=	new General();
        $timezone	=	$genralObj->getTimeZones();
		$this->renderPartial("aboutme",array('data'=>$data,'timezone'=>$timezone));
	}
	
	function actiondeletePhone($id=NULL)
	{
		if($this->isAjaxRequest())
		{
		
			if($id != NULL)
			{
				if(!is_numeric($id)){
					$algoencryptionObj	=	new Algoencryption();
					$id	=	$algoencryptionObj->decrypt($id);
				}
				$userObj = new Users();
				$res	=	$userObj->getUserDetail($id);
				$phoneNum  = $res["result"];
  				$result=$userObj->deleteById($id);
				if($result[0]==0)
				{							
					echo "success";
				}
				else
				{
					echo $result[1];
				}
			}
		}
		else
		{
			$this->render("/site/error");
		}
	}
	
	/*********** 	INVITES FUNCTION  ***********/
	public function actionInvites()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
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
		$invitesObj	=	new Invites();
		$invites	=	$invitesObj->getInvitesByReceiverId(Yii::app()->session['loginId'],NULL,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$this->renderPartial('invites', array('data'=>$invites['invites'],'pagination'=>$invites['pagination'],'ext'=>$ext));
	}
		
	function actionInviteAjax()
	{
		$invitesObj	=	new Invites();
		$invites	=	$invitesObj->getInvitesByReceiverId(Yii::app()->session['loginId'], 2);
		$this->renderPartial('invitesAjax',
							  array('data'=>$invites['invites'], 'pagination'=>$invites['pagination']));
	}
	
	function actionListAjax()
	{
		$todoListsObj	=	new TodoLists();
		$todoItemsObj	=	new TodoItems();
		$myLists	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		$this->renderPartial('listAjax', array('data'=>$myLists,'pendingItems'=>$myLists['pendingItems']));
	}
	
	function actionItemAjax()
	{
		$todoListsObj	=	new TodoLists();
		$todoItemsObj	=	new TodoItems();
		$myLists	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($myLists['pendingItems']);
		$mytodoitems =	$todoItemsObj->getMyToDoItemsUserWiseCount(Yii::app()->session['loginId']);
		$othersTodoItems =	$todoItemsObj->getOtherToDoItemsUserWiseCount(Yii::app()->session['loginId']);
		$assingByMeItems =	$todoItemsObj->getassingByMeItemsUserWiseCount(Yii::app()->session['loginId']);
		$this->renderPartial('itemWidgetAjax', array('data'=>$myLists,'mytodoitems'=>$mytodoitems['items'],'assingByMeItems'=>$assingByMeItems['items'],'othersTodoItems'=>$othersTodoItems['items']));
	}
	
	function array_sort($array, $on, $order=SORT_ASC)
	{
			$new_array = array();
			$sortable_array = array();
		
			if (count($array) > 0) {
				foreach ($array as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $k2 => $v2) {
							if ($k2 == $on) {
								$sortable_array[$k] = $v2;
							}
						}
					} else {
						$sortable_array[$k] = $v;
					}
				}
		
				switch ($order) {
					case SORT_ASC:
						asort($sortable_array);
					break;
					case SORT_DESC:
						arsort($sortable_array);
					break;
				}
		
				foreach ($sortable_array as $k => $v) {
					$new_array[$k] = $array[$k];
				}
			}
		
			return $new_array;
	}
		

	/*********** 	DELETE INVITATION FUNCTION  ***********/
	public function actionDeleteInvite($id=NULL)
	{
		if(isset($id)){
			$invitesObj	=	new Invites();
			$res = $invitesObj->deleteInvites($id);
			echo $res;
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
			$res = $invitesObj->changeStatus($id, $status);
			echo $res;
			exit;
		} else {
			$this->redirect('index');
		}
	}
	
	public function actionChangeItemField($field)
	{
		if(isset($_POST)){
			if( $_POST['value'] == '' ) {
				if( $field == 'title' ) {
					echo $this->msg['_TODOTITLE_VALIDATE_'];
				} else if( $field == 'dueDate' ) {
					echo $this->msg['_DUEDATE_EMPTY_'];
				}
				exit;
			} else {
				if( $field == 'dueDate' ) {
					$validationObj	=	new Validation();
					if( !$validationObj->checkDateTime($_POST['value']) ) {
						echo $this->msg['_DUEDATE_NOT_VALID_FORMATE_'];
						exit;
					}
				}
			}
			
			$todoItemsObj	=	new TodoItems();
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$sessionArray['fullname']	=	Yii::app()->session['fullname'];
			$todoItemsObj->changeItemField($_POST['id'], $_POST['value'], $field, $sessionArray);
			echo 'success';
			exit;
		}
		$this->render('user');
	}
	
	/***********  CHANGE ITEM STATUS FUNCTION  ***********/
	public function actionChangeItemStatus($id=NULL, $stat=NULL)
	{
		
		if(isset($_POST['value'])){
			$id	=	$_POST['id'];
			$stat	=	$_POST['value'];
		} else {
			$_POST['value']	=	'';
		}
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$sessionArray['fullname']	=	Yii::app()->session['fullname'];
		$todoItemsObj	=	new TodoItems();
		$todoItemsObj->changeTodoItemsStatus($id,$stat,$sessionArray);
		echo json_encode(array('status'=>0, 'message'=>$this->msg['_STATUS_UPDATE_'], 'change'=>$_POST['value']));
        exit;
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
			
			echo json_encode($result);
			exit;
		}
		$this->renderPartial('assignBack', array('data'=>$itemId));
	}
	
	/*********** 	REMINDERS FUNCTION  ***********/
	public function actionReminders()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$reminderObj	=	new Reminder();
		$reminders	=	$reminderObj->getReminderByUserId(Yii::app()->session['loginId']);
		$this->renderPartial('reminders', array('data'=>$reminders));
	}
	
	/*********** 	SEND REMINDER AGAIN FUNCTION  ***********/
	public function actionRemindAgain($itemId=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$reminderObj	=	new Reminder();
		
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['fullname']=Yii::app()->session['fullname'];
		$result	=	$reminderObj->remindeAgain($itemId, $sessionArray);
		
		echo json_encode($result);
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
	
	/*********** 	REMINDERS FUNCTION  ***********/
	public function actionRemindersAjax()
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$reminderObj	=	new Reminder();
		$reminders	=	$reminderObj->getReminderByUserId(Yii::app()->session['loginId']);
		
		$this->renderPartial('remindersAjax', array('data'=>$reminders));
	}
	
	/*********** 	ADD TODO ITEMS FUNCTION  ***********/
	public function actionAddTodo($from=NULL)
	{		
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$items = array();
		$userObj = new Users();
		$loginObj = new Login();
		$logindata=$loginObj->getUserId(Yii::app()->session['loginId']);
		$items = $userObj->getAllUsers();
		
		$todoListsObj	=	new TodoLists();
		$res	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($res['pendingItems']);
		$items['myLists'] = $res;
		$items['from']	=	$from;
		
		$result = array();
		$this->renderPartial('addTodoItem', array('data'=>$items,'lastFavrite'=>$logindata));
	}
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionmyLists()
	{
		$todoListsObj	=	new TodoLists();
		$todoItemsObj	=	new TodoItems();
		$limit = 10;
		
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
		$this->renderPartial('myLists', array('data'=>$myLists['items'],'pagination'=>$myLists['pagination'],'ext'=>$ext));
	
	}
	
	function actionaddToDoItem($edit=NULL, $popUp=NULL)
	{
		$TodoItemsObj=new TodoItems();
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['fullname']=Yii::app()->session['fullname'];
		
		if(!isset($edit)){
			$result=$TodoItemsObj->addTodoItem($_POST,$sessionArray);
		} else {
			$result=$TodoItemsObj->addTodoItem($_POST,$sessionArray,$_POST['id']);
		}
		
		if( isset($popUp) ) {
			$result['message']	.=	'<script type="text/javascript">setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );</script>';
		}
		
		echo json_encode($result);
	}
	
	
	
	function actionsaveToDoList()
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
			echo json_encode(array('succstr'=>$succstr, 'errstr'=>$errstr));		
	}
	
	function actionaddInviteUser($id=NULL)
	{
		$data = array();
	
		if($_POST['todoList'] == '')
		{
			echo json_encode(array('status'=>$this->errorCode['_INVITE_VALIDATION_'], 'message'=>$this->msg['_INVITE_VALIDATION_']));
			exit;
		}
		if(isset($_POST['email']) && $_POST['email'] != '')
		{
			$_POST['userlist']=$_POST['email'];
		}
		$_POST['listId']=$_POST['todoList'];
		$_POST['createdBy']=Yii::app()->session['loginId'];
		$todoListObj =  new TodoLists();
		
		$sessionArray['loginId']=Yii::app()->session['loginId'];
		$sessionArray['fullname']=Yii::app()->session['fullname'];		
		$res = $todoListObj->addInviteUser($_POST,$sessionArray);
		$succstr = '';
		$errstr = '';
		
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
		
		echo json_encode(array('succstr'=>$succstr, 'errstr'=>$errstr));
	}
	
	function callDaemon($daemon_name = "hirenow") {
        $sig = new signals_lib();
        $sig->get_queue($this->arr[$daemon_name]);
        $sig->send_msg($daemon_name);
    }
	
	 /*****************Upload Avatar ***************/
 	function actionAvatar($stat = NULL)
	{
		$session = Yii::app()->getSession();
		$_POST['loginId']=$session['loginId'];
		$_POST['userId']=$session['userId'];
		$_POST['loginIdType']=$session['loginIdType'];
		$userObj = new Users;
		$result=$userObj->uploadAvatar($_POST,$_FILES,$stat);
		echo json_encode($result);
		
	}	 	
	
	 /*****************Upload Avatar ***************/
 	function actionAttachment($stat = NULL)
	{
		$session = Yii::app()->getSession();
		//$helperObj = new Helper();
		/*if(!isset(Yii::app()->session['random']))
		{
		Yii::app()->session['random'] = $helperObj->getRandomString();
		}*/
		$_POST['userId']=$session['loginId'];
		$_POST['loginIdType']=$session['loginIdType'];
		//$_POST['random']=Yii::app()->session['random'];
		
		$userObj = new Users;
		$result=$userObj->uploadAttachment($_POST,$_FILES,$stat);
		
		echo json_encode($result['message']);
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
		
		$result = array();
		$this->renderPartial('addTodoList', array('data'=>$items));
	}
	
	/*********** 	ADD TODO ITEMS FUNCTION  ***********/
	public function actionAddInvite($id=NULL, $from='invites')
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
		unset($myLists['pendingItems']);
		$items['from']	=	$from;
		$this->renderPartial('addTodoInvite', array('data'=>$items,'myList'=>$myLists,'listId'=>$id));
	}
	
	/*********** 	MY TODO ITEMS FUNCTION  ***********/
	public function actionMyTodo($sortType='desc', $sortBy='itemId', $flag=0)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$keyword = NULL;
		if(isset($_POST['keyword']))
		{
			$keyword = $_POST['keyword'];
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
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$data	=	$todoItemsObj->getMyToDoItems($sessionArray,LIMIT_10, $sortType, $sortBy,$keyword);
		$data['myTodoCount']		=	$todoItemsObj->getMyTodoCount(Yii::app()->session['loginId']);
		$data['user']	=	$usersObj->getUserById(Yii::app()->session['userId'], 'myOpenStatus , myDoneStatus, myCloseStatus');
		
		if($sortType == 'desc'){
			$data['sortType']	=	'asc';
			$data['img_name']	=	'arrow_up.png';
		} else {
			$data['sortType']	=	'desc';
			$data['img_name']	=	'arrow_down.png';
		}
		if($flag == 0){
			$data['img_name']	=	'';
		}
		$data['sortBy']	=	$sortBy;
		$data['myLists']	=	$todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($data['myLists']['pendingItems']);
		$this->renderPartial('myTodoItems', array('data'=>$data));
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
	public function actionItemDescription($id=NULL, $flag=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$todoItemsObj	=	new TodoItems();
		$item	=	$todoItemsObj->getItemDetails($id);
		if($item)
		{
			$item['flag']	=	$flag;
			if( isset($_REQUEST['url']) ) {
				$item['url']	=	$_REQUEST['url'];
			} else {
				$item['flag']	=	0;
			}
			if($this->isAjaxRequest())
			{
				$this->renderPartial('description', array('data'=>$item));
			}
			else
			{
				$this->render('description', array('data'=>$item));
			}
		}
		else
		{
			$this->redirect(Yii::app()->params->base_path."user/index");
		}
	}
	
	public function actiongetItemHistory($id=NULL)
	{
		$todoItemChangeHistoryObj	=	new TodoItemChangeHistory();
		$itemHistory	=	$todoItemChangeHistoryObj->getItemHistory($id);
		$this->renderPartial('moreHistoryAjax', array('history'=>$itemHistory[1]));
	}
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionmoreItemHistory($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		
		$todoItemChangeHistoryObj	=	new TodoItemChangeHistory();
		$itemHistory	=	$todoItemChangeHistoryObj->getItemHistory($id);
		$this->renderPartial('moreHistory', array('history'=>$itemHistory,"itemId"=>$id));
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
		$listMembers	=	$inviteObj->getListMembers($id);
		
		$this->renderPartial('listdescription', array('data'=>$item,'listMembers'=>$listMembers['users'],'pagination'=>$listMembers['pagination']));
	}
	
	/*********** 	GET COMMENTS FUNCTION  ***********/
	public function actionGetComments($id=NULL)
	{
		if(!$this->isLogin()){
			$this->redirect('index');
			exit;
		}
		$commentsObj	=	new Comments();
		$usersObj	=	new Users();
		$loginObj	=	new Login();
		$generalObj	=	new General();
		$algoencryptionObj	=	new Algoencryption();
		$comments	=	$commentsObj->getcommentsByItem($id);
		$index	=	0;
		
		foreach($comments as $comment){
			$res	=	$usersObj->getUserDetail($comment['userId']);
			$commentBy  = $res['result'];
			$userId	=	$loginObj->getUserIdByid($comment['userId']);
			$comments[$index]['commentedByFname']	=	$commentBy['firstName'];
			$comments[$index]['commentedByLname']	=	$commentBy['lastName'];
			$comments[$index]['avatar']	=	$commentBy['avatar'];
			$comments[$index]['imageDir']	=	$algoencryptionObj->encrypt("USER_".$userId);
			$comments[$index]['time']	=	$generalObj->rel_time($commentBy['createdAt']);
			$index++;
		}
		$this->renderPartial('comments', array('data'=>$comments));
	}
	
	public function actionDeleteComment($id=NULL)
	{
		$commentsObj	=	new Comments();
		$post	=	$commentsObj->findByPk($id); 
		if($post)
		{
			$post->delete();
			echo 'success';
		}
	}
	
	/*********** 	ADD COMMENTS FUNCTION  ***********/
	public function actionAddComments()
	{
		$commentsObj	=	new Comments();
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$sessionArray['userId']	=	Yii::app()->session['userId'];
		$result	=	$commentsObj->addItemComments($_POST, $sessionArray);
		echo json_encode($result);
	}
	
	/*********** 	DELETE REMINDER FUNCTION  ***********/
	public function actionDeleteReminder($id=NULL)
	{
		if(isset($id)){
			$reminderObj	=	new Reminder();
			$result	=	$reminderObj->deleteReminder($id);
			echo json_encode($result);
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
			//$result	=	array('status'=>0, 'message'=>'success');
			echo json_encode($result);
		} else {
			$this->redirect('index');
		}
	}
	
	public function actionReassignTask($id=NULL)
	{
		$loginObj=new Login();
		$loginData=$loginObj->getLoginDetailsById(Yii::app()->session['loginId'],'last_todoassign');
		$this->renderPartial('reassignTask', array('id'=>$id,'last_todoassign'=>$loginData['last_todoassign']));
	}
	
	/*********** 	ADD REMINDER FUNCTION  ***********/
	public function actionAddReminder($id=NULL)
	{
		$reminderObj	=	new Reminder();
		$data	=	array();
		if(isset($id)){
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
			
			echo json_encode($result);
			exit;
		}
		$todoListObj	=	new TodoLists();
		$data['lists']	=	$todoListObj->getAllMyList(Yii::app()->session['loginId']);
		unset($data['lists']['pendingItems']);
		$this->renderPartial('addReminder', array('data'=>$data));
	}
	
	public function actionReminderViewMore($id=NULL, $popUp=NULL)
	{
		$reminderObj	=	new Reminder();
		$reminder	=	$reminderObj->getReminderById($id);
		$this->renderPartial('reminderViewMore', array('data'=>$reminder));
	}
	
	//close account
	function actioncloseAccount()
	{
		
		//if($this->isAjaxRequest())
		//{
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
				echo $result[1];
			}
			else
			{	
				$this->renderPartial('setting');	
			}
		/*}
		else
		{
			$this->render("/site/error");
		}*/
		
	}
	
	/*********** 	VIEW MORE FOR INVITATION FUNCTION  ***********/
	public function actionviewMoreInvite($id=NULL, $popUp=NULL)
	{
		$inviteObj	=	new Invites();
		$todoListsObj	=	new TodoLists();
		$usersObj	=	new Users();
		
		$data	=	$inviteObj->getInviteById($id);
		$data['listDetails']	=	$todoListsObj->getMyListById($data['listId']);
		$res	=	$usersObj->getUserDetail($data['listDetails']['createdBy']);
		$data['createdByDetails'] = $res['result'];
		if(isset($popUp)){
			$this->renderPartial('viewMoreInvitePopup', array('data'=>$data));
		} else {
			$this->renderPartial('viewMoreInvite', array('data'=>$data));
		}
	}
	
	function actionPrefferedLanguage($lang='eng')
	{
		if(isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']>0)
		{
			$userObj=new User();
			$userObj->setPrefferedLanguage(Yii::app()->session['loginId'],$lang);
		}
		
		Yii::app()->session['prefferd_language']=$lang;
		
		$this->redirect(Yii::app()->params->base_path."user/index");
	}
	
	
	function actionverifyPhone()
	{
		$this->render("verify_phone");
	}
	
	
	/*********** 	Checking Email address except current account manager  ***********/ 
	function actioncheckOtherEmail($type=NULL)
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($type != NULL)
			{
				$userObj = new User();
				$userId='-1';
				$result=$userObj->checkOtherEmail($_POST['email'],$userId,$type);
				if($result == '')
				{				
					echo false;
				}
				else
				{
					echo true;
				}
			}
		}
		
	}

	function actionLogin()
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
				Yii::app()->user->setFlash('error', $this->msg['_LOGIN_ERROR_']);
				header('location:'.Yii::app()->params->base_path.'user/signin');
			}
		}
		else
		{
			header('location:'.BASE_PATH.'user/index');
		}
	
		exit;
	}
	
	function isAjaxRequest()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function actioneditProfile()
	{
		if(isset($_GET['id']))
		{
			$sessionArray['userId']		=	Yii::app()->session['userId'];
			$sessionArray['loginId']	=	Yii::app()->session['loginId'];
			$generalObj = new General();
			$users = new Users();
			$result=$users->editProfile($_POST,$sessionArray);
			
			if(!empty($result) && $result['status'] == 0)
			{
				Yii::app()->session['fullname'] = '';
				Yii::app()->session['fullname'] = $_POST['fName'] .'&nbsp;'.$_POST['lName']; 
				
				echo "success, Profile updated successfully";
			}
		}
		else
		{
			echo Yii::app()->user->setFlash('error', $result['message']); 
		}
	}
	
	/*********** 	Logout   ***********/ 
	function actionLogout()
	{
		global $msg;
		$temp=Yii::app()->session['prefferd_language'];
		if(isset(Yii::app()->session['loginId']))
		{
			Yii::app()->session->destroy();			
		}
		Yii::app()->session['prefferd_language']=$temp;		
		header('location:'.Yii::app()->params->base_path.'site');
	}
	
	
	
	
	/*********************Get Web Phone Verify*******************/
	function actiongetVerifyCode()
	{
		$jsonarray= array();
		
		if(isset($_POST['phone']))
		{
			$userObj=new Users();
			if(!is_numeric($_POST['phone'])){
				$algoencryptionObj	=	new Algoencryption();
				$_POST['phone']	=	$algoencryptionObj->decrypt($_POST['phone']);
			}
			$result=$userObj->getVerifyCodeById($_POST['phone'],'-1');
			$jsonarray['status']=$result['status'];
			$jsonarray['message']=$result['message'];
		}
		else
		{
			$message=$this->msg['ONLY_PHONE_VALIDATE'];
			$jsonarray['status']='false';
			$jsonarray['message']=$message;
		}
		echo $jsonarray['message'];
	}
	
	/*********** 	Checking phone number  ***********/ 
	function actionchkPhone($type=0)
	{
		global $msg;	
		$generalObj=new General();
		$userObj=new Users();
		$loginObj=new Login();
		$phone=$generalObj->clearPhone($_POST['phoneNumber']);
		if(isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']!='')
		{
			$session=new CHttpSession;
			$result=$loginObj->isExistPhone($phone,1,$session);	
		}
		else
		{
			$result=$loginObj->isExistPhone($phone,1);	
		}
		
		if($result)
		{	
			if(isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']!='')
			{
				$userId=0;
				
				$resultmore=$loginObj->isVerifiedPhone(Yii::app()->session['loginId'],$phone,$userId);
			
				if($resultmore)
				{
					echo 2;
				}
				else
				{
					echo true;
				}
			}
			else
			{			
				echo true;
			}
		}
		else
		{
			echo false;
		}
	}
	
	function actiongetActiveVerifyCode()
	{
		$jsonarray= array();
		if(isset($_POST['phone']))
		{	
			$userObj=new User();
			$result=$userObj->getVerifyCode($_POST['phone'],'-1');
			$jsonarray['status']=$result[0];
			$jsonarray['message']=$result[1];
			
		}
		else
		{
			$message=$this->msg['ONLY_PHONE_VALIDATE'];
			$jsonarray['status']='false';
			$jsonarray['message']=$message;
		}
		echo $jsonarray['status'].'**'.$jsonarray['message']; 
	}
	
	/*********************Phone Verify*******************/
	function actionVerifyNow()
	{
		if(isset($_POST['phoneNumber']))
		{
			$verify_code=rand(10,99).rand(10,99).rand(10,99);
			$verify_sms = new VerifySms();
			$verify_sms->setVerifyCode($_POST['phoneNumber'],$verify_code);
			echo $verify_code;
		}
	}
	
	/*****************method - change password ***************/
	function actionchangePassword()
	{
		error_reporting(E_ALL);
		if($this->isAjaxRequest())
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
					 echo "success";
					 exit;
				}
				else
				{
					echo $result[1];
					exit;
				}			
			}
			else
			{
				$this->renderPartial('changepassword',array('result'=>'','fToken'=>'',
									'encryptedUserId'=>$encryptedUserId,'userId'=>Yii::app()->session['loginId']));
				
			}
		}
		else
		{
			
			$this->render("/site/error");
		}
	}
	
	function actioncheckemail()
	{
		$email = $_GET['email'];
		$loginObj = new Login();
		$res = $loginObj->checkOtherEmail($email);
		if(isset($res) && $res!='')
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		exit;
	}
	
	public function actionSetting()
	{
		$this->renderPartial('setting');
	}
	
	public function actionmyNetwork($sortType='desc', $sortBy='id', $flag=0)
	{
		$todoNetworkObj	=	new Todonetwork();
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
		
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId'], LIMIT_10, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		$todoLists = new TodoLists();
		$list = $todoLists->getAllMyList(Yii::app()->session['loginId']);
		unset($list['pendingItems']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$networks['sortBy']	=	$sortBy;
		$this->renderPartial('myNetwork', array('networks'=>$networks,'list'=>$list,'ext'=>$ext));
	}
	
	public function actionmyNetworkUser()
	{	
		$todoNetworkObj	=	new Todonetwork();
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
		
		
		$networks	=	$todoNetworkObj->getMyPaginatedNetwork(Yii::app()->session['loginId'],LIMIT_10, $_REQUEST['sortType'], $_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$this->renderPartial('myNetworkUser', array('networks'=>$networks,'ext'=>$ext));
	}
	
	public function actiongetNetworkUserDetails()
	{
		$id = $_GET['id'];
		$toDoNetworkObj = new Todonetwork();
		$dataProvider=$toDoNetworkObj->getNetworkUserDetail($id);
		$this->renderPartial('myNetworkUserDetail', array('dataProvider'=>$dataProvider));
		
	}
	
	public function actionremoveFrommyNetwork()
	{
		$id = $_GET['id'];
		$todoNetwork=Todonetwork::model()->findbyPk($id);
		$todoNetwork->delete();
		$this->actionmyNetwork();
	}
	
	public function actionremoveList($id=NULL)
	{
		$id = $_GET['id'];
		$toDoListObj =  new TodoLists();
		$res = $toDoListObj->deleteList($id);
		$this->actionmyLists();
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
	
	public function actionupdateLink()
	{
		if($this->isAjaxRequest())
	 	{	
			$userObj	=	new Users();
			$_POST['id']	=	Yii::app()->session['userId'];
			$res	=	$userObj->updateSocialLink($_POST);
			
			if($res['status']==0)
			{
				echo "success";
			}
			else
			{
				echo "error";
			}
		}
		else
		{
			$this->render("/site/error");
		}
	}
	
	/*****************method - add phone number ***************/
	public function actionaddUniquePhone()
	{
		
		if($this->isAjaxRequest())
		{
			if(isset($_POST['userphoneNumber'])) 
			{
				$sessionArray['loginId']=Yii::app()->session['loginId'];
				$sessionArray['userId']=Yii::app()->session['userId'];
				$loginObj=new Login();
				$total=$loginObj->gettotalPhone($sessionArray['userId'],1);
				if($total > 1)
				{
					echo "Limit Exist!";
					exit;
				}
				$totalUnverifiedPhone=$loginObj->gettotalUnverifiedPhone($sessionArray['userId'],1);
				if($totalUnverifiedPhone==1)
				{
					echo "Please first verify unverified phone.";
					exit;
				}
			
				$result=$loginObj->addPhone($_POST,1,$sessionArray);
				
				if($result['status']==0)
				{
					echo "success";
				}
				else
				{
					echo $result['message']; 
				}
			}
		}
		else
		{
			$this->render("/site/error");
		}
	}	
	
	/*****************method - Phone list ***************/
	function actionUserPhoneList()
	{
		//if($this->isAjaxRequest())
		//{
			$loginObj=new Login();
			
			$algoencryptionObj	=	new Algoencryption();
			$userArray=$loginObj->getPhones(Yii::app()->session['userId'],1);
			$i	=	0;
			foreach($userArray as $phoneId){
				$userArray[$i]['encryptedId']	= $algoencryptionObj->encrypt($phoneId['id']);
				$i++;
			}
			$userPhoneArray=$userArray;
			$totalVerfied = $loginObj->gettotalVerifiedPhone(Yii::app()->session['accountManagerId'],1);
			$sessionArray['userId']=Yii::app()->session['userId'];
			$sessionArray['employerId']=Yii::app()->session['employerId'];
			$sessionArray['accountManagerId']=Yii::app()->session['accountManagerId'];
			$userObj = new Users();
			$loggedin_user=$userObj->getUserDetail(Yii::app()->session['loginId']);
			$loggedin_user=$loggedin_user['result'];      
			$totalVerfied=$totalVerfied;
			$this->renderPartial('leftphonelist',array('userPhoneArray'=>$userPhoneArray,'loggedin_user'=>$loggedin_user,'totalVerfied'=>$totalVerfied));
		/*}
		else
		{
			$this->render("/site/error");
		}*/
	}
	
	public function actionRemindMe($reminderId=NULL)
	{
		$reminderObj	=	new Reminder();
		$sessionArray['loginId']	=	Yii::app()->session['loginId'];
		$result	=	$reminderObj->remindMe($reminderId, $sessionArray);
		echo json_encode($result);
	}
	
	function actiontest(){
		$reminderObj	=	new Reminder();
		$reminderObj->getReminderEmail(2, 4, 2, 0);
	}

	public function actionMyworkstatus()
	{
		$todoListsObj =  new TodoLists();

		$myLists = $todoListsObj->getAllMyList(Yii::app()->session['loginId']);
		unset($myLists['pendingItems']);
		$this->renderpartial('myworkstatus',array('mylist'=>$myLists), 0, true);
		
	}
		
}