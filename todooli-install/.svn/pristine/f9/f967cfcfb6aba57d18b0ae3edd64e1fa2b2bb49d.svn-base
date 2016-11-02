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

class UploadController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	function actiongetAvatar($dir='images',$fileName='avatar.png')
	{
		$name = FILE_UPLOAD.'avatar/'.$dir.'/'.$fileName;
		
		$ext=$this->actiongetExt($fileName);
		if(file_exists($name))
		{
			$fp = fopen($name, 'rb');	
		}
		else
		{
			$name=DEFAULT_FILE_PATH.'images/avatar.png';
			// $name='/home/jobtaxi/html/images/avatar.png';
			$fp = fopen($name, 'rb');
		}
		
		header("Content-Type: image/".$ext);
		header("Content-Length: " . filesize($name));
		fpassthru($fp);
	}
	
	function actiongetAttach($dir='images',$fileName='avatar.png')
	{
		//$name = FILE_UPLOAD.'attachment/'.$dir.'/'.$fileName;
		$uploaddir = FILE_UPLOAD.'attachment/';
		$path=$uploaddir.$dir.'/'.$fileName;
		if(file_exists($path))
		{
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".$fileName);
			readfile($path);
		}

	}
	

	function actiongetExt($filename='')
	{
		if($filename!='')
		{
			$fileData=explode('.',$filename);	
			return $fileData[count($fileData)-1];
		}	
	}
}