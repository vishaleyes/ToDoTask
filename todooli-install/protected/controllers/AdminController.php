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
 * */
//include("protected/vendors/lib/excel_reader2.php");
error_reporting(0);
class AdminController extends Controller {

    private $algo;
    private $adminmsg;
    private $msg;
    private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
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

	
	/* =============== Content Of Check Login Session =============== */

    function isLogin() {
        if (isset(Yii::app()->session['adminUser'])) {
            return true;
        } else {
            Yii::app()->user->setFlash("error", "Username or password required");
            header("Location: " . Yii::app()->params->base_path . "admin");
            exit;
        }
    }

    function actionindex() 
	{
		if(isset(Yii::app()->session['adminUser'])){
			$this->actionstatistics();
		} else {
			$this->render("index");
		}
    }
	
	function actionAdminLogin()
	{
		error_reporting(E_ALL);
		$captcha = Yii::app()->getController()->createAction('captcha');
		
		if (isset($_POST['submit_login'])) {
			
			if(!$captcha->validate($_POST['verifyCode'],1)) {
				Yii::app()->user->setFlash("error","Enter valid captcha.");
				$this->render('index');
				exit;
			}
			
			if(isset($_POST['email_admin']))
			{
				$email_admin = $_POST['email_admin'];
				$pwd = $_POST['password_admin'];
					
				$adminObj	=	new Admin();
				$admin_data	=	$adminObj->getAdminDetailsByEmail($email_admin);
			}
			$generalObj	=	new General();
			$isValid	=	$generalObj->validate_password($_POST['password_admin'], $admin_data['password']);
			
			if ( $isValid === true ) {
				Yii::app()->session['adminUser'] = $admin_data['id'];
				Yii::app()->session['email'] = $admin_data['email'];
				Yii::app()->session['fullName'] = $admin_data['first_name'] . ' ' . $admin_data['last_name'];
				$this->actionIndex();
				exit;
			} else {
				Yii::app()->user->setFlash("error","Username not valid");
				$this->render('index');
				exit;
			}	
		}
	}

	function actionLogout()
	{
		Yii::app()->session->destroy();
		$this->render('index');
	}
	
	/***** ALL USERS *****/
	function actionstatistics() 
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='u.id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(isset($_GET['listId']) && $_GET['listId'] != '')
		{
			if($_GET['listId']==0)
			{
				$_GET['listId'] = '';
			}
			Yii::app()->session['listId'] = $_GET['listId'];
		}
		else
		{
			$_GET['listId'] = Yii::app()->session['listId'];
		}
		
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$todoItemObj	=	new TodoItems();
		$statistics	=	$todoItemObj->getAllPaginatedStatistics(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		
		$todoListObj =  new TodoLists();
		$lists = $todoListObj->getListsForStatistics();
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		Yii::app()->session['current']	=	'statistics';
		$this->render("statastics", array('data'=>$statistics,'ext'=>$ext,'lists'=>$lists,'selectedList'=>$_GET['listId']));
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
	
	/***** ALL USERS *****/
	function actionUsers() 
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='u.id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$usersObj	=	new Users();
		$users	=	$usersObj->getAllPaginatedUsers(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['startdate']=$_REQUEST['startdate'];
		$ext['enddate']=$_REQUEST['enddate'];
		$ext['currentSortType']=$_REQUEST['currentSortType'];
		
		$data['pagination']	=	$users['pagination'];
        $data['users']	=	$users['users'];
		Yii::app()->session['current']	=	'users';
		$this->render("user", array('data'=>$data,'ext'=>$ext));
    }
	
	/***** ALL LISTS *****/
	function actionLists() 
	{
		$this->isLogin();
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
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		$listsObj	=	new TodoLists();
		$lists	=	$listsObj->getAllPaginatedLists(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate']);
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['sortBy'] = $_REQUEST['sortBy'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['currentSortType'] = $_REQUEST['currentSortType'];
		
		$data['pagination']	=	$lists['pagination'];
        $data['lists']	=	$lists['lists'];
		Yii::app()->session['current']	=	'lists';
        $this->render("lists", array('data'=>$data,'ext'=>$ext));
    }
	
	
	/***** ALL LISTS *****/
	function actionitems() 
	{
		$this->isLogin();
		
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
		if(!isset($_REQUEST['stat4']))
		{
			$_REQUEST['stat4']='';
			
		}
		if(!isset($_REQUEST['stat3']))
		{
			$_REQUEST['stat3']='';
			
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
			
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
			
		}
		
		$_REQUEST['currentSortType'] = $_REQUEST['sortType']; 
		
		$adminObj = new Admin();
		$adminObj->saveToDoStatus($_REQUEST);
		
		$result = $adminObj->findByPk(Yii::app()->session['adminUser']);
		$result = $result->attributes;
		
		$itemsObj	=	new TodoItems();
		$items	=	$itemsObj->getAllPaginatedItems(LIMIT_10,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['startdate'],$_REQUEST['enddate'],$result['myOpenStatus'],$result['myDoneStatus'],$result['myCloseStatus']);
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['sortBy'] = $_REQUEST['sortBy'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['stat1'] = $result['myOpenStatus'];
		$ext['stat3'] = $result['myDoneStatus'];
		$ext['stat4'] = $result['myCloseStatus'];
		$ext['currentSortType'] = $_REQUEST['currentSortType'];
		$data['pagination']	=	$items['pagination'];
        $data['items']	=	$items['items'];
		Yii::app()->session['current']	=	'items';
        $this->render("items", array('data'=>$data,'ext'=>$ext));
    }
	
		
	function actioncleanDB() 
	{
 		$adminObj = new Admin();
		$adminObj->cleanDB();
		$command="/var/www/html/utils/msg_send 200369 restart";
		passthru($command);
		Yii::app()->user->setFlash("success","DataBase cleaned successfully");
        header("location:" . Yii::app()->params->base_path . "admin");
		exit;
    }
	
	/****** Api Doc ******/

    function actionapprovalApiFunction() {
        if (isset($_POST['statusName']) && isset($_POST['statusValue'])) {
            $Api_functionObj = new ApiFunction();
            $result = $Api_functionObj->setApproval($_POST);
			if($result['status'] == 0){
				return true;
			}else{
				return false;
			}
        }
        return false;
    }

    /*
     * Method:apiFunctions
     * Display function list for rest api
     * $page=>page no for pagination
     */

    function actionapiFunctions($module='-1', $page=1) 
	{
		error_reporting(E_ALL);
		$this->isLogin();
		if(isset($_POST['findname']) && $_POST['findname'] == '')
		{
			unset(Yii::app()->session['findname']);
		}
        $adminObj = new Admin();
        $adminId = $adminObj->getAdminDetailsByEmail(Yii::app()->session['email']);
		$adminDetails = $adminObj->getAdminDetailsById($adminId['id']);
       	
			$Api_functionObj = new ApiFunction();
        $Api_function_resourceObj = new ApiFunctionResource();
        if(isset($_POST['findname']) && $_POST['findname'] != '')
		{
			
	    	$result = $Api_functionObj->listFunction($module, $page,trim($_POST['findname']));
			$data['findname']=trim($_POST['findname']);
		}
		else
		{
			$result = $Api_functionObj->listFunction($module, $page);
		}
        $Api_moduleObj = new ApiModule();
		
        $i = 0;
        foreach ($result[1] as $data) {
            $moduleData = $Api_moduleObj->getModule($data['moduleId']);
            if (isset($moduleData['label'])) {
                $result[1][$i]['moduleLabel'] = $moduleData['label'];
            }
            $resourceData = $Api_function_resourceObj->getData($data['id']);

            if (!empty($resourceData)) {
                $httpmethod = "REQUEST";
                if ($resourceData['http_methods'] == '0') {
                    $httpmethod = "GET";
                }
                if ($resourceData['http_methods'] == '1') {
                    $httpmethod = "POST";
                }

                $response_formats = "XML,JSON";
                if ($resourceData['response_formats'] == '1') {
                    $response_formats = "XML";
                }
                if ($resourceData['response_formats'] == 2) {
                    $response_formats = "JSON";
                }
                $result[1][$i]['resource_url'] = $resourceData['resource_url'];
                $result[1][$i]['http_methods'] = $httpmethod;
                $result[1][$i]['response_formats'] = $response_formats;
            }
            $i++;
        }
		
	   if(isset($_POST['findname']) && $_POST['findname']!='')
	   {
	   		Yii::app()->session['findname'] = $_POST['findname'];
	   }
	    
		$data=array('pagination'=>$result[0],'functionList'=>$result[1],'adminDetails'=>$adminDetails,'advanced'=>"Selected",'title'=>$this->msg['_TITLE_FJN_ADMIN_API_FUNCTIONS_']);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('api-functions',$data);
    }
	
	/*
     * Method:addApiFunction
     * Add/Edit function
     * $id=>id for function
     */

    function actionaddApiFunction($id=NULL) {
     
		$this->isLogin();
		
        $Api_moduleObj = new ApiModule();
        $modules = $Api_moduleObj->getModules();
        $Api_functionObj = new ApiFunction();
        $title = 'Add Function';
		$result=array();
        if ($id != NULL) {
            $title = 'Edit Functions';
            $result=$Api_functionObj->getFunction($id);
			$_POST['id']=$result['id'];
        }
        if (isset($_POST['FormSubmit'])) {
            $id = NULL;
            $Api_functionArray['function_name'] = $_POST['function_name'];
            $Api_functionArray['moduleId'] = $_POST['moduleId'];
            $Api_functionArray['fn_description'] = $_POST['fn_description'];
            $Api_functionArray['published'] = isset($_POST['published']) ? $_POST['published'] : 1;

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $Api_functionArray['id'] = $_POST['id'];
                $Api_functionArray['modifiedAt'] = 'now()';
                $id = $_POST['id'];
            } else {
                $Api_functionArray['createdAt'] = 'now()';
            }
			
			if(isset($id) && $id!=NULL)
			{
				$Api_functionObj->setData($Api_functionArray);
				$Api_functionObj->insertData($id);
			}
			else
			{
				$Api_functionObj->setData($Api_functionArray);
				$insertedId= $Api_functionObj->insertData();
			}
            if(isset($insertedId) && $insertedId > 0) {
				Yii::app()->user->setFlash('success', "Function added successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/apiFunctions');
                exit;
            } else {
				Yii::app()->user->setFlash('success', "Function updated successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/apiFunctions');
                exit;
            }
        }
		
		$data=array('result'=>$result,'modules'=>$modules,'advanced'=>"Selected",'title'=>$title);
		Yii::app()->session['current'] = 'advanced';
		$this->render('add-api-function',$data);
    }

	/*
     * Method:deleteApiFunction
     * delete function
     * $id=>id for function
     */

    function actiondeleteApiFunction($id) {
        $this->isLogin();
        $Api_functionObj = new ApiFunction();
        $Api_functionObj->deleteFunction($id);
		
		Yii::app()->user->setFlash('success', "Function deleted successfully.");
        header('location:' . Yii::app()->params->base_path . 'admin/apiFunctions');
		exit;
    }

    /*
     * Method:functionParametes
     * Display list of function parameters
     * $fn_id=>function id
     * $page=>page no. for function parameters
     */

    function actionfunctionParametes($fn_id=NULL, $page=1) {
        $this->isLogin();
		if(!isset($fn_id)){
			header("Location:" . Yii::app()->params->base_path . "admin/apiFunctions");
		}
        $Api_function_paramObj = new ApiFunctionParam();
        $result = $Api_function_paramObj->listParam($fn_id, $page);
		$data=array('pagination'=>$result[0],'paramList'=>$result[1],'advanced'=>"Selected",'fun_ref_id'=>$fn_id);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('function-parameters',$data);
    }

 	/*
     * Method:addFunctionParamete
     * Add/Edit function parameter
     * $id=>id for function parameter
     */

    function actionaddFunctionParameter($fn_id, $id=NULL) {
		
        $this->isLogin();
        $Api_function_paramObj = new ApiFunctionParam();
        $Api_functionObj = new ApiFunction();
        $functions = $Api_functionObj->getFunctions();
		$result=array();
        $title = 'Add Parameter';
        if ($id != NULL) {
            $title = 'Edit Parameter';
            $result = $Api_function_paramObj->getParameter($id);
            $fn_id = $result['fn_id'];
			$_POST['id'] = $result['id'];
        }
        if (isset($_POST['FormSubmit'])) {
            $id = NULL;
            $paramArray['fnParamName'] = $_POST['fnParamName'];
            $paramArray['fnParamDescription'] = $_POST['fnParamDescription'];
            $paramArray['example'] = $_POST['example'];
            $paramArray['uiValidationRule'] = $_POST['uiValidationRule'];
            $paramArray['fn_id'] = $_POST['fn_id'];
            $paramArray['ParamType'] = isset($_POST['ParamType']) ? $_POST['ParamType'] : 1;
            $paramArray['published'] = isset($_POST['published']) ? $_POST['published'] : 1;

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $paramArray['id'] = $_POST['id'];
                $paramArray['modifiedAt'] = 'now()';
                $id = $_POST['id'];
            } else {
                $paramArray['createdAt'] = 'now()';
            }
			if(isset($id) && $id!=NULL)
			{
				$Api_function_paramObj->setData($paramArray);
				$Api_function_paramObj->insertData($id);
			}
			else
			{
				$Api_function_paramObj->setData($paramArray);
				$insertedId= $Api_function_paramObj->insertData();
			}
            if(isset($insertedId) && $insertedId > 0) {
				Yii::app()->user->setFlash('success', "Parameter added successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/functionParametes/&fn_id=' . $fn_id);
                exit;
            } else {
				Yii::app()->user->setFlash('success', "Parameter updated successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/functionParametes/&fn_id=' . $fn_id);
                exit;
            }
			
        }
		
		$data=array('result'=>$result,'functions'=>$functions,'fun_ref_id'=>$fn_id,'advanced'=>"Selected",'title'=>$title);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('add-function-parameter',$data);
		
    }

    /*
     * Method:deleteFunctionParameter
     * delete function
     * $id=>id for function
     */

    function actiondeleteFunctionParameter($fn_id, $id) {
        $this->isLogin();
        $Api_function_paramObj = new ApiFunctionParam();
        $Api_function_paramObj->deleteParameter($id);
		Yii::app()->user->setFlash('success', "Parameter deleted successfully.");
        header('location:' . Yii::app()->params->base_path . 'admin/functionParametes/fn_id/' . $fn_id);
		exit;
    }

    function actionapiResource($fn_id=NULL) {
        $this->isLogin();
		error_reporting(E_ALL);
		if(!isset($fn_id)){
			header("Location:" . Yii::app()->params->base_path . "admin/apiFunctions");
		}
        $Api_function_resourceObj = new ApiFunctionResource();
        if (isset($_POST['FormSubmit'])) {
            $dataArray['resource_url'] = $_POST['resource_url'];
            $dataArray['authentication'] = $_POST['authentication'];
            $dataArray['response_formats'] = $_POST['response_formats'];
            $dataArray['http_methods'] = $_POST['http_methods'];
            $dataArray['example'] = $_POST['example'];
            $dataArray['response'] = $_POST['response'];
            $dataArray['fn_id'] = $fn_id;
            $Api_function_resourceObj->setData($dataArray);
            $Api_function_resourceObj->insertData($_POST['id']);
			Yii::app()->user->setFlash('success', "Resource url updated successfully.");
        }
        $data = $Api_function_resourceObj->getData($fn_id);
        $Response_formatObj = new ResponseFormat();
        $resResult = $Response_formatObj->getResponseFormat();
		$data=array('data'=>$data,'fn_id'=>$fn_id,'http_mth_id'=>array(0, 1, 2),'http_mth_val'=>array('GET ', 'POST', 'REQUEST'),'http_mth_selected'=>(isset($data['http_methods']) ? $data['http_methods'] : 0),'res_fr_id'=>$resResult['id'],'res_fr_val'=>$resResult['label'],'res_fr_selected'=>(isset($data['response_formats']) ? $data['response_formats'] : 1),'advanced'=>"Selected");
		
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('function-resource',$data);
    }
	
	/****** End Api Doc ******/
	
	/*
     * Method:apiModules
     * Display module list for rest api
     * $page=>page no for pagination
     */

    function actionapiModules($page=1) {
        $this->isLogin();
		Yii::app()->session['current'] = 'apiFunctions';
        $adminObj = new Admin();
        $adminId = $adminObj->getAdminDetailsByEmail(Yii::app()->session['email']);
        $adminDetails = $adminObj->getAdminDetailsById($adminId);
      
        $Api_moduleObj = new ApiModule();
        $result[0] = $Api_moduleObj->getModules($page);

		$data=array('moduleList'=>$result[0],'adminDetails'=>$adminDetails,'advanced'=>"Selected",'TITLE_ADMIN'=>$this->msg['_TITLE_FJN_ADMIN_API_MODULES_']);
		$this->render('api_modules',$data);
    }

    /*
     * Method:addApiModule
     * Add/Edit module
     * $id=>id for module
     */

    function actionaddApiModule($id=NULL) {
        $this->isLogin();
        $Api_moduleObj = new ApiModule();
        $title = 'Add Module';
		$result =array();
        if ($id != NULL) {
            $title = 'Edit Module';
			$result=$Api_moduleObj->getModule($id);
			$_POST['id']=$result['id'];
        }
        if (isset($_POST['FormSubmit'])) {
            $id = NULL;
            $Api_moduleArray['label'] = $_POST['label'];
            $Api_moduleArray['description'] = $_POST['description'];
            $Api_moduleArray['published'] = isset($_POST['published']) ? $_POST['published'] : 1;

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $Api_moduleArray['id'] = $_POST['id'];
                $Api_moduleArray['modifiedAt'] = 'now()';
                $id = $_POST['id'];
            } else {
                $Api_moduleArray['createdAt'] = 'now()';
            }
			
			if(isset($id) && $id!=NULL)
			{
				$Api_moduleObj->setData($Api_moduleArray);
				$Api_moduleObj->insertData($id);
			}
			else
			{
				$Api_moduleObj->setData($Api_moduleArray);
				$insertedId= $Api_moduleObj->insertData();
			}
            if(isset($insertedId) && $insertedId > 0) {
				Yii::app()->user->setFlash('success', "Module added successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/apiModules');
                exit;
            } else {
				Yii::app()->user->setFlash('success', "Module updated successfully.");
                header('location:' . Yii::app()->params->base_path . 'admin/apiModules');
                exit;
            }
        }
		$data=array('result'=>$result,'advanced'=>"Selected",'title'=>$title);
		Yii::app()->session['current'] = 'apiFunctions';
		$this->render('add_api_module',$data);
    }

    /*
     * Method:deleteApiModule
     * delete module
     * $id=>id for module
     */

    function actiondeleteApiModule($id) {
        $this->isLogin();
        $Api_moduleObj = new ApiModule();
        $Api_moduleObj->deleteModule($id);
		Yii::app()->user->setFlash('success', "Module deleted successfully.");
        header('location:' . Yii::app()->params->base_path . 'admin/apiModules');
		exit;
    }
	
	function actionmyprofile()
	{
		
		Yii::app()->session['current']   =   'settings';
		$adminObj	=	new Admin();
		
		if(isset(Yii::app()->session['email'])){
    		$adminId	=	$adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
    		$adminDetails	=	$adminObj->getAdminDetailsById($adminId);
            $data['adminDetails']   =   $adminDetails;
			$this->render('myprofile', array('data'=>$data));
		}else{
            $this->redirect(Yii::app()->params->base_path.'admin/index');
		}
	}
	
	function actionsaveProfile()
	{	
		   error_reporting(E_ALL);
		   $adminObj	=	new Admin();
           $Admin_value['first_name'] = $_POST['FirstName'];
		   $Admin_value['last_name'] = $_POST['LastName'];
		   $validationObj = new Validation();
		   $res = $validationObj->updateAdminProfile($Admin_value);	
		   if($res['status'] == 0)
		   {
		   		 $adminObj->updateProfile($Admin_value,$_POST['AdminID']);
		  		 Yii::app()->session['FullName'] = $Admin_value['first_name'] .''.$Admin_value['last_name'];
		   		 Yii::app()->user->setFlash('success', Yii::app()->params->adminmsg['_UPDATE_SUCC_MSG_']);
		   }
		   else
		   {
			    Yii::app()->user->setFlash('error',$res['message']);
		   }
		   $this->actionmyprofile();   
	}
	
	function actionchangePassword()
	{
		$this->isLogin();
		if(!isset($_REQUEST['ajax']))
		{
			$_REQUEST['ajax']='false';
		}
		$resultArray['ajax']=$_REQUEST['ajax'];
		if(isset($_GET['id']) && $_GET['id'] != '')
		{
			$resultArray['id']=$_GET['id'];
		}
		else
		{
			$resultArray['id']=Yii::app()->session['adminUser'];
		}
		if($_REQUEST['ajax']=='true')
		{
			$this->render('change_password',$resultArray);	
		}
		else
		{
			$this->render('change_password',$resultArray);	
		}	
	}
	
	function actionchangeAdminPassword()
	{
		$this->isLogin();
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != '')
		{
			$adminObj = new Admin();
			$adminId = $adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
			$adminDetails = $adminObj->getAdminDetailsById($adminId);
			Yii::app()->session['current'] =   'settings';
			$data['adminDetails']=$adminDetails;
			$data['id']=$adminId;
			$data["settings"]= "Selected";
			$data['TITLE_ADMIN']=$this->msg['_TITLE_FJN_ADMIN_CHANGE_PASSWORD_'];
			$pass_flag = 0;
			if (isset($_POST['Save'])) {
				$adminObj=Admin::model()->findbyPk($adminId);
				$res = $adminObj->attributes;
				$generalObj = new General();
				$res = $generalObj->validate_password($_POST['opassword'],$res['password']);
				if($res!=true)
				{	
					Yii::app()->user->setFlash("error","Old Password is wrong.");
				}
				else
				{
					$generalObj = new General();
					$password_flag = $generalObj->check_password($_POST['password'], $_POST['cpassword']);
		
					switch ($password_flag) {
						case 0:
							$pass_flag = 0;
							break;
						case 1:
							
							Yii::app()->user->setFlash("error","Please don't blank password.");
							$pass_flag = 1;
							break;
						case 2:
							
							Yii::app()->user->setFlash("error","Password minimum length need to six character.");
							$pass_flag = 1;
							break;
						case 3:
							Yii::app()->user->setFlash("error","Password minimum need to one lowercase.");
							
							$pass_flag = 1;
							break;
						case 4:
							Yii::app()->user->setFlash("error","Password minimum need to one upercase.");
							$pass_flag = 1;
							break;
						case 5:
							Yii::app()->user->setFlash("error","Password minimum need to one digit number.");
							$pass_flag = 1;
							break;
						case 6:
							Yii::app()->user->setFlash("error","Password minimum need to one special character.");
							$pass_flag = 1;
							break;
						case 7:
							Yii::app()->user->setFlash("error","Password is not match with confirm password.");
							$pass_flag = 1;
							break;
					}
				
					if ($pass_flag == 0) {
						if (isset($_POST['opassword'])) {
							if (strlen($_POST['opassword']) < 1) {
								
								 Yii::app()->user->setFlash("error",$this->msg['WRONG_PASS_MSG']);
							} else if (strlen($_POST['password']) < 5) {
								
								 Yii::app()->user->setFlash("error",$this->msg['_VALIDATE_PASSWORD_GT_6_']);
							} else if ($_POST['password'] != $_POST['cpassword']) {
								
								 Yii::app()->user->setFlash("error",$this->msg['_CONFIRM_PASSWORD_NOT_MATCH_']);
							} else {
								$admin = new admin();
								$result = $admin->changePassword(Yii::app()->session['adminUser'], $_POST);
								if ($result == '2') {
								   
									Yii::app()->user->setFlash("error","Old Password don't match with over database.");
								} else {
								  
									Yii::app()->user->setFlash("error",$this->msg['_PASSWORD_CHANGE_SUCCESS_']);
									Yii::app()->user->setFlash('success',"Successfully Changed Password.");
								}
							}
						}
					}
				}
			}
		}
		if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
		{
			if (isset($_POST['Save'])) {
				$loginObj=Login::model()->findbyPk($_REQUEST['user_id']);
				$res = $loginObj->attributes;
				$generalObj = new General();
				$res = $generalObj->validate_password($_POST['opassword'],$res['password']);
				if($res!=true)
				{	
					Yii::app()->user->setFlash("error","Old Password is wrong.");
				}
				$adminObj = new admin();
				$result = $adminObj->changeUserPassword($_REQUEST['user_id'], $_REQUEST);
				Yii::app()->user->setFlash("error",$this->msg['_PASSWORD_CHANGE_SUCCESS_']);
				Yii::app()->user->setFlash('success',"Successfully Changed Password.");
			}
		}
		
		$this->render("change_password",$data);
	}
	
	function actionforgotPassword() 
	{
		$captcha = Yii::app()->getController()->createAction('captcha');
        if (isset(Yii::app()->session['adminUser'])) {
			 Yii::app()->request->redirect( Yii::app()->params->base_path . 'admin');
        }
		
        if (isset($_POST['verifyCode']) && !$captcha->validate($_POST['verifyCode'],1)) 
		{
			Yii::app()->user->setFlash("error",Yii::app()->params->msg['_INVALID_CAPTCHA_']);
            header("Location: " . Yii::app()->params->base_path . 'admin/forgotPassword');
            exit;
        } else {
            if (isset($_POST['loginId'])) {
                $AdminObj = new Admin();
                $result = $AdminObj->forgot_password($_POST['loginId']);
                if ($result[0] == 'success') {
					Yii::app()->user->setFlash("success",$result[1]);
                    $data['message_static']=$result[1];
                    $this->render("password_confirm",array("data"=>$data));
					exit;
                } else {
					Yii::app()->user->setFlash("error",$result[1]);
                    $this->render("forgot_password");
					exit;
                }
            }
        }
		if(empty($_POST))
		{
			$this->render("forgot_password");
		}
    }

    function actionresetPassword() 
	{
        $message = '';
        if (isset($_POST['submit_reset_password_btn'])) {
            $adminObj = new Admin();
            $result = $adminObj->resetpassword($_POST);
            $message = $result[1];
            if ($result[0] == 'success') {
				Yii::app()->user->setFlash("success",$message);
                header("Location: " . Yii::app()->params->base_path . 'admin/');
                exit;
            }
			else
			{
				Yii::app()->user->setFlash("error",$message);
                header("Location: " . Yii::app()->params->base_path . 'admin/resetpassword');
                exit;
			}
        }
        if ($message != '') {
			Yii::app()->user->setFlash("success",$message);
        }
        $this->render("password_confirm");
    }
	
	/* =============== Contain Of Approve User Login ============== */

    function actionapproveUser($id=NULL) 
	{
		error_reporting(E_ALL);
        $this->isLogin();
        if(!isset($id)){
			header("Location: " . Yii::app()->params->base_path . "admin/user");
		}
		//	DELETE OTHER VERIFIED PHONE NUMBERS
		$loginObj	=	new Login();
		$incoming_sms_sender	=	$loginObj->getPhoneById($id);
		
		if($incoming_sms_sender!=''){
			$userObj = new Users();
			//$userObj->deletePhoneNumber($incoming_sms_sender,$id);
			//$userObj->deleteOtherVerifiedPhone($id);
		}
		$loginObj=Login::model()->findByPk($id);
		$user_value['id'] = $id;
        $user_value['modified']=date('Y-m-d h:m:s');
        $user_value['isVerified'] = '1';
		$loginObj = new Login();
		$loginObj->veriryUser($user_value,$id);
		$vefiry = "Verified Successfully";
		Yii::app()->user->setFlash('success',$vefiry);
        $this->actionusers();
    }

}
//classs