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
class ApidocController extends Controller 
{
	/*function beforeAction() 
	{
		
	}*/
	
	function actionindex()
	{
		$this->render('index');
	}
	
	function actionstart()
	{
		$this->render('getting_started');
	}
	
	function actionintro()
	{
		$this->render('intro');
	}
	
	function actionapi()
	{
		$Api_functionObj=new ApiFunction();
		$Api_moduleObj=new ApiModule();
		$modules=$Api_moduleObj->getModules();
		$i=0;
		foreach($modules as $module)
		{
			$modules[$i]['function']=$Api_functionObj->getFunctionByModuleId($module['id']);
			$i++;
		}
		
		$data=array('modules'=>$modules);
		$this->render('api',$data);
	}
	
	function actionmethod($id=NULL)
	{
		if(isset($id) && $id!='')
		{
			$Api_functionObj=new ApiFunction();
			$function=$Api_functionObj->getFunction($id);
			
			$Api_function_resourceObj=new ApiFunctionResource();
			$resource=$Api_function_resourceObj->getData($id);
			
			$Api_function_paramObj=new ApiFunctionParam();
			$parameters=$Api_function_paramObj->getParameters($id);
			
			$data=array('method'=>$id,'function'=>$function,'resource'=>$resource,'parameters'=>$parameters);
			$this->render('view-more-function',$data);
		}
		else
		{
			 header("Location: " . Yii::app()->params->base_path . "apidoc/api");
			 exit;
		}
	}
	
	function actionerror_codes($method)
	{
		global $errorCode;
		global $msg;

		$error = array();
		foreach($errorCode as $key => $value){
			$error[$value] = $msg[$key];
		}
		$data=array('error'=>$error,'method'=>$method);
		$this->render('error-codes',$data);
	}
	
	function actionfield_values($method)
	{		
		$ageObj = new AgeType();
		$businessObj = new BusinessType();
		$languageObj = new LanguageTypes();
		$communicationObj = new CommMethod();
		$experienceObj = new ExperienceLevelTypes();
		$jobObj = new JobTypes();
		$payrangeObj = new PayRanges();
		$stateObj = new StateMaster();
		$workscheduleObj = new WorkScheduleTypes();
		$workshiftObj = new WorkShiftTypes();
		
		$tables_types = array(
							'Age'=>$ageObj->getAgeType2(),
							'Langauge'=>$languageObj->getLanguageTypes2(),
							'Communication method'=>$communicationObj->getAllCommMethod(),
							'Experience'=>$experienceObj->getExperienceLevelTypes2(),
							'Job'=>$jobObj->getJobTypes2(),
							'Pay Range'=>$payrangeObj->getPayranges2(),
							'Work Schedule'=>$workscheduleObj->getWorkScheduleTypes2(),
							'Work Shift'=>$workshiftObj->getWorkShiftTypes2(),
							'Business'=>$businessObj->getAllOccupation(),
							'State'=>$stateObj->getState()
							);
		
		$data=array('tables_types'=>$tables_types,'method'=>$method);
		$this->render('field-values',$data);
	}
			
	function afterAction() 
	{
	
	}		
}
