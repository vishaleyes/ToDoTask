<?php

class BridgecallController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{	
		$this->renderPartial('index');
	}
	 
	public function actionScreenshot()
	{	
		$this->renderPartial('screenshot');
	}
	
	
}