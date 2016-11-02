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

class daemon_tasks{
	private $debug_on 				    = false;
	
	public function daemon_tasks()
	{
	}

	public function set_debug_level($debug_value)
	{
		if ($debug_value == "on") {
			  $this->debug_on = true;
		}
		if ($debug_value == "off") {
		  $this->debug_on = false;
		}
	}
	
	public function process_inbound_sms()
	{
		$this->do_process("daemon","process_inbound_sms");
	}
	
	public function process_outbound_sms()
	{
		$this->do_process("daemon","process_outbound_sms");
	}

	public function process_rcv_rest()
	{
		$this->do_process("daemon","process_rcv_rest");
	}
	
		public function process_rcv_rest_expire()
	{
		$this->do_process("daemon","process_rcv_rest_expire");
	}
	
	public function process_rcv_android_note()
	{
		$this->do_process("daemon","process_rcv_android_note");
	}
	
	public function process_rcv_iphone_note()
	{
		$this->do_process("daemon","process_rcv_iphone_note");
	}
	
	public function process_outbound_email()
	{
		$this->do_process("daemon","process_outbound_email");
	}
	
	
	public function process_reminder()
	{
		$this->do_process("daemon","process_reminder");
	}
	
	
	public function process_todo_updated()
	{
		$this->do_process("daemon","process_todo_updated");
	}
	
	
	public function process_notify_users()
	{
		$this->do_process("daemon","process_notify_users");
	}
	
	private function do_process($controller,$action)
	{
		$_GET['r'] = $controller."/".$action;
		try{
			if (defined('YII_DEBUG'))
			{	
			
				$finalAction='action'.$action;
				$controllerName = ucfirst($controller).'Controller';
				$dispatch = new $controllerName($controller,$action);
				
				$dispatch->$finalAction();
						
			}
			else
			{
				require_once("/home/todooli/html2/index.php");
			}
		}catch (Exception $e) {
            error_log('Exception caught By Daemon Task: ' . $e->getMessage());
        }
		
	}
	
	function log($message) {
		$trace=debug_backtrace();
		$args = $trace[1]['args'];
		if(isset($trace[1]['file']))
		{
			$filename = basename($trace[1]['file']);
		}
		else
		{
			$filename = '';			
		}
		$functionname = $trace[1]['function'];
		switch (count($args)) {
		    case 0: 
				$functionname = $functionname."()";
				break;
			case 1:
		        $functionname = $functionname."(".$args[0].")";
				break;
			case 2:
		        $functionname = $functionname."(".$args[0].",".$args[1].")";
				break;
			case 3:
		        $functionname = $functionname."(".$args[0].",".$args[1].",".$args[2].")";
				break;
			default:
		        $functionname = $functionname."(".$args[0].",".$args[1].",".$args[2]."+)";
				break;
		} 
		if(isset($trace[1]['line']))
		{
			$linename = $trace[1]['line'];
		}
		else
		{
			$linename = '';
		}
		if ($filename == "") {
		  $msg = "INFO [".$functionname."] ".$message;
		} else {
		  $msg = "INFO [".$filename.",".$functionname.",".$linename."] ".$message;
		}
		error_log($msg);
	}		
}


