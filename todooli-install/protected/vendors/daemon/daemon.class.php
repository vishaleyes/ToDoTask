<?php 
	
	/* Daemon Class
	*  
	*/	
	class Daemon 
	{
		private $daemon_prefix 				= "daemon";
		private $author_name 				= "todooli";
		private $daemon_name 				= "todoolid";
		private $domain_name 				= "todooli.com";
		
		private $dtasks;
		
		function __construct($load_libs = true)
		{
        	require_once (FILE_PATH.'protected/vendors/lib/SystemDaemon/System_Daemon.php');
        	require_once (FILE_PATH.'protected/vendors/lib/signals_lib.php');
			if( $load_libs )
			{
        			require_once (FILE_PATH.'protected/vendors/lib/daemon_tasks.php');
        			$this->dtasks = new daemon_tasks();
			}
		}
		
		function setRestartCounter($file)
		{
			if (file_exists($file))
				$val = file_get_contents($file, false);
			else
				$val = 0;
				
			$num = (int)$val;
			$num++;
			file_put_contents($file, $num);
		}

		
		function start($daemon_name = "")
		{
			if($daemon_name!="") $this->daemon_name = $this->daemon_prefix . "_" . $daemon_name;
            		error_log("Daemon " . $this->daemon_name . " started");
			 
			System_Daemon::setOption("appName", $this->daemon_name); // Minimum configuration
			System_Daemon::setOption("usePEAR", false); 
			System_Daemon::setOption("authorName", $this->author_name); 
			System_Daemon::setOption("authorEmail", "support@" . $this->domain_name); 
			System_Daemon::setOption("appDescription", $this->author_name . " daemons"); 
			System_Daemon::setOption("appDir", getcwd()); 
			System_Daemon::setOption("logVerbosity", System_Daemon::LOG_WARNING);
			System_Daemon::setOption("logLocation", LOGS_PATH . $this->daemon_name . ".log");
			System_Daemon::setOption("logPhpErrors", true);
			System_Daemon::setOption("logFilePosition", false);
			System_Daemon::setOption("appRunAsUID", posix_getuid());
			System_Daemon::setOption("appRunAsGID", posix_getgid());
			
			if (!file_exists(LOGS_PATH . $this->daemon_name)) {
				
				mkdir (LOGS_PATH . $this->daemon_name);
			}
			if (file_exists(LOGS_PATH . $this->daemon_name . "/" . $this->daemon_name . ".pid")) {
				unlink(LOGS_PATH . $this->daemon_name . "/" . $this->daemon_name . ".pid");
			}
			if (file_exists(LOGS_PATH . $this->daemon_name . ".log")) {
				unlink(LOGS_PATH . $this->daemon_name . ".log");
			}
			if (file_exists(LOGS_PATH . $this->daemon_name . ".cnt")) {
				unlink(LOGS_PATH . $this->daemon_name . ".cnt");
			}
			touch(LOGS_PATH . $this->daemon_name . ".log");
			touch(LOGS_PATH . $this->daemon_name . ".cnt");
			System_Daemon::setOption("appPidLocation", LOGS_PATH . $this->daemon_name . "/" . $this->daemon_name . ".pid");
			
			$this->setRestartCounter(LOGS_PATH . $this->daemon_name . ".cnt");
			//System_Daemon::setBasePath(dirname(__FILE__)); 
			
			//System_Daemon::log(System_Daemon::LOG_INFO, "Daemon not yet started so this will be written on-screen");
			System_Daemon::start();
			System_Daemon::log(System_Daemon::LOG_INFO, 
							   "Daemon: '". System_Daemon::getOption("appName"). "' spawned! " .
							   "This will be written to ". System_Daemon::getOption("logLocation")
							   );
			
		    // lets start the daemons
			if($daemon_name === "rcv_rest")
			{
				$this->doTasks_rcv_rest();
			}
			else if($daemon_name === "rcv_rest_expire")
			{
				$this->doTasks_rcv_rest_expire();
			}
			else if($daemon_name === "rcv_android_note")
			{
				$this->doTasks_rcv_android_note();
			}
			else if($daemon_name === "rcv_iphone_note")
			{
				$this->doTasks_rcv_iphone_note();
			}
			else if($daemon_name === "send_email")
			{
				$this->doTasks_send_email();
			}
			else if($daemon_name === "rcv_sms")
			{
				$this->doTasks_rcv_sms();
			}
			else if($daemon_name === "send_sms")
			{
				$this->doTasks_send_sms();
			}
			else if($daemon_name === "reminder")
			{
				$this->doTasks_reminder();
			}
			else if($daemon_name === "todo_updated")
			{
				$this->doTasks_todo_updated();
			}
			else if($daemon_name === "notify_users")
			{
				$this->doTasks_notify_users();
			}
			
			
			
            		error_log("Daemon " . $this->daemon_name . " stopped");
			System_Daemon::stop();
		}
	
	  	//
	  	// daemon rcv_sms: Received SMS Processing
	  	//
		function doTasks_rcv_sms()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370, "rcv_rest_expire" => 200371);
			$sig = new signals_lib();
			$sig->get_queue($arr["rcv_sms"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_inbound_sms();
			}
		}

	  	//
	  	// daemon send_sms: SEND SMS from here
	  	//
		function doTasks_send_sms()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370, "rcv_rest_expire" => 200371);
			$sig = new signals_lib();
			$sig->get_queue($arr["send_sms"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_outbound_sms();
			}
		}

		//
	  	// daemon rcv_rest: process rcv_rest requests here
	  	//
		function doTasks_rcv_rest()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370);
			$sig = new signals_lib();
			$sig->get_queue($arr["rcv_rest"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_rcv_rest();
			}
		}
		
		function doTasks_rcv_android_note()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
			$sig = new signals_lib();
			$sig->get_queue($arr["rcv_android_note"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_rcv_android_note();
			}
		}
		function doTasks_rcv_iphone_note()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
			$sig = new signals_lib();
			$sig->get_queue($arr["rcv_iphone_note"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_rcv_iphone_note();
			}
		}
		
			function doTasks_rcv_rest_expire()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370, "rcv_rest_expire" => 200371);
			while (true)
			{
				sleep(60*60*3);		
				$result = $this->dtasks->process_rcv_rest_expire();
			}
		}
		
	  	//
	  	// daemon send_email: SEND email from here
	  	//
		function doTasks_send_email()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373, "rcv_rest" => 200370);
			$sig = new signals_lib();
			$sig->get_queue($arr["send_email"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_outbound_email();
			}
		}
		
		//
	  	// daemon reminder
	  	//
		function doTasks_reminder()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373,"rcv_rest" => 200370, "reminder" => 200376, "todo_updated" => 200375, "notify_users" => 200377);
			$sig = new signals_lib();
			$sig->get_queue($arr["reminder"]);
			while (true)
			{	
				$result = $this->dtasks->process_reminder();
				sleep(60*60);	
			}
		}
		
		//
	  	// daemon todo_updated
	  	//
		function doTasks_todo_updated()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373,"rcv_rest" => 200370, "reminder" => 200376, "todo_updated" => 200375, "notify_users" => 200377);
			$sig = new signals_lib();
			$sig->get_queue($arr["todo_updated"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_todo_updated();
			}
		}
		
		//
	  	// daemon notify_users
	  	//
		function doTasks_notify_users()
		{
			$arr = array("send_sms" => 200372,"send_email" => 200374,"rcv_sms" => 200373,"rcv_rest" => 200370, "reminder" => 200376, "todo_updated" => 200375, "notify_users" => 200377);
			$sig = new signals_lib();
			$sig->get_queue($arr["notify_users"]);
			while (true)
			{
				$debug_value = $sig->receive_msg2();
				$this->dtasks->set_debug_level($debug_value);
				$result = $this->dtasks->process_notify_users();
			}
		}
	}
?>
