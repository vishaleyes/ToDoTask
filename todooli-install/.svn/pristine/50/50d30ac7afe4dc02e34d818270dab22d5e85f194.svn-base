<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here
	require_once("mainheader.php");
	
	global $themename; 
	global $msg;
	global $errorCode;
	global $daemonFlag;
	global $adminmsg;
	if($daemonFlag!=1)
	{
	$session	=	new CHttpSession;
	$session->open();
	$prefferd_language	=	$session['prefferd_language'];
	$adminLanguagePath=FILE_PATH."protected/vendors/Smarty/languages/".DEFAULT_LANGUAGE."/admin_global.php";
	
	if(isset($adminLanguagePath))
	{
		$adminmsg = include_once($adminLanguagePath);
	}
	if(isset($prefferd_language))
	{
		$languagePath=FILE_PATH."protected/vendors/Smarty/languages/".$prefferd_language."/global.php";
	}
	else
	{
		$languagePath=FILE_PATH."protected/vendors/Smarty/languages/".DEFAULT_LANGUAGE."/global.php";
	}
	if (file_exists($languagePath))
	{	
		global $msg;
		$msg = include_once($languagePath);
	} else {
		//error_log("FATAL ERROR: do not know the language! Using English");
		global $msg;
		$prefferd_language=DEFAULT_LANGUAGE;
		$languagePath=FILE_PATH."protected/vendors/Smarty/languages/".$prefferd_language."/global.php";
		$msg = include_once($languagePath);
		
	}
	$errorCodePath=FILE_PATH."protected/vendors/Smarty/languages/errorcode.php";
	if (file_exists($errorCodePath))
	{
		global $errorCode;
		$errorCode = include_once($errorCodePath);
	}
	

	
	$themename = 'todooli';
	$errorPage='site/error';
	$mobileRed = detect_mobile();
	$statusFlag=true;
	 if($mobileRed === true)
	 {	
		$expResult=array();
		$result=isMobileController(1);
		if(strtolower($result['controller'])=='admin' || strtolower($result['controller'])=='support' ||
			 strtolower($result['controller'])=='api' || strtolower($result['controller'])=='apidoc')
		{
			$themename = '';
		}
		else
		{
			$themename = 'mobile';
			$errorPage='site/merror';
		}
	 }
	 else
	 {
		 
		$result=isMobileController();
		
		if(strtolower($result['controller'])=='rest' ||strtolower($result['controller'])=='restoutlook' || strtolower($result['controller'])=='debug' || strtolower($result['controller'])=='sms' || strtolower($result['controller'])=='daemon')
		{
			$statusFlag=false;	
		}
		if(strtolower($result['controller'])=='admin' || strtolower($result['controller'])=='support' ||
			 strtolower($result['controller'])=='api')
		{
			$themename = "";
		}
		else if($result['isMobile']==1)
		{
			$themename = 'mobile';	
			$errorPage='site/merror';
		}
		else if(strtolower($result['controller'])=='user')
		{
			$themename = 'todooli';	
		}
		else
		{
			$themename = 'todooli';
		}
	 }
 
	}
	
	$error=array(
            'errorAction'=>$errorPage,
        );
	ini_set('memory_limit', '512M');
	return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Todooli App',
	'defaultController'=>'site',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'111111',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'request'=>array(
			// enable CSRF
			'enableCsrfValidation'=>$statusFlag,
		),
		
		
			'viewRenderer'=>array(
		  'class'=>'application.extensions.ESmartyViewRenderer',
			'fileExtension' => '.tpl',
		),
		'verifyCode'=>array(
          'type'=>'system.web.widgets.captcha.CCaptcha',
),
		// uncomment the following to enable URLs in path-format
		
		'db'=>array(
			'connectionString' => 'mysql:host='.DB_SERVER.';dbname='.DB_DATABASE,
			'emulatePrepare' => true,
			'username' => DB_SERVER_USERNAME,
			'password' => DB_SERVER_PASSWORD,
			'charset' => 'utf8',
		),
		
		'errorHandler'=>$error,
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
			),
		),
	),
		
			
	 'theme'=>$themename,
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'base_path'=>'http://'.WEB_HOST_NAME.'/'.SITE_NAME.'',
		'base_url'=>'http://'.WEB_HOST_NAME.'/'.SITE_NAME.'',
		'base_path_language'=>'http://'.WEB_HOST_NAME.'/'.SITE_NAME.'js/',
		'image_path'=>'http://'.WEB_HOST_NAME.'/'.SITE_NAME.'images',
		'msg'=>$msg,
		'adminmsg'=>$adminmsg,
		'errorCode'=>$errorCode,
		
	),
);



function detect_mobile()
{
	$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
 
	$mobile_browser = '0';
 
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
			$mobile_browser++;
	}
	if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
		$mobile_browser++;
 
	if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
		$mobile_browser++;
 
	if(isset($_SERVER['HTTP_PROFILE']))
		$mobile_browser++;
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
	}
	else
	{
		$mobile_ua = '';
	}
	$mobile_agents = array(
						'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
						'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
						'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
						'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
						'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
						'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
						'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
						'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
						'wapr','webc','winw','winw','xda','xda-'
						);
 
	if(in_array($mobile_ua, $mobile_agents))
		$mobile_browser++;
 
	
	if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
		$mobile_browser++;
 
	// Pre-final check to reset everything if the user is on Windows
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
		$mobile_browser=0;
	}
	// But WP7 is also Windows, with a slightly different characteristic
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
		$mobile_browser++;
	}
	if($mobile_browser>0)
		return true;
	else
		return false;
}

function isMobileController($ismobile=0)
{
	$isMobile=0;
	if(isset($_GET['r']))
	{
		$expResult=explode('/',$_GET['r']);
		
		if(isset($expResult[0]) && $expResult[0]!='admin' && $expResult[0]!='apidoc' && $expResult[0]!='upload' && $expResult[0]!='')
		{
			$isMobilecheck=substr($expResult[0],0,1);
			if($isMobilecheck=='m' || $isMobilecheck=='M')
			{
				$controller=$expResult[0];	
				$isMobile=1;
			}
			else
			{
				if($ismobile==1)
				{
					$controller='m'.$expResult[0];	
				}
				else
				{
					$controller=$expResult[0];	
				}
							
			}
		}
		else if($expResult[0]=='admin')
		{
			$controller='admin';
		}
		else if($expResult[0]=='apidoc')
		{
			$controller='apidoc';
		}
		else if($expResult[0]=='upload')
		{
			$controller='upload';
		}
		else
		{
			
			if($ismobile==1)
			{
				$controller='muser';
			}
			else
			{
				$controller='site';
			}
		}
	}
	else
	{
		if($ismobile==1)
		{
			$controller='muser';
		}
		else
		{
			$controller='site';
		}
	}	
	$expResult[0]=$controller;
	$getUrl=implode('/',$expResult);
	$_GET['r']=$getUrl;
	return array("controller"=>$controller,"isMobile"=>$isMobile);
}
