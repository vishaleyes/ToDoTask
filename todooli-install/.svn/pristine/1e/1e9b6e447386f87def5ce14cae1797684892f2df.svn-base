<?php

class signals_lib {
	
	//private $CI;
	private $queue_id;
	private $queue_handle;
	
	public function signals_lib()
	{
		
	}
	
	public function get_queue($queue_id)
	{
		if( $queue_id == '' ) $queue_id = 200379;
		
		$this->queue_id 	= $queue_id;
		// Create System V Message Queue. Integer value is the number of the Queue		
		if (function_exists('msg_get_queue'))
		{
			$this->queue_handle	= msg_get_queue($this->queue_id);
		} else {
		  error_log ("Failed to create message queue " . $queue_id );
        }
	}
	
	public function send_msg($msg)
	{
		// Create System V Message Queue. Integer value is the number of the Queue
		if (function_exists('msg_get_queue'))
		{
			
			//$queue = msg_get_queue($this->queue_id);
			
			// Sendoptions
			$message			= $msg;    	// Transfering Data
			$serialize_needed	= false;	// Must the transfer data be serialized ?
			$block_send			= true; 	// Block if Message could not be send (Queue full...) (true/false)
			$msgtype_send		= 1;    	// Any Integer above 0. It signeds every Message. So you could handle multible message
											// type in one Queue.
			
			$err = 0;
			if( msg_send($this->queue_handle,$msgtype_send, $message,$serialize_needed, $block_send,$err) === true )
			{
				return true;
							  
			} else {
				return false;
			}
			
		}
		else 
		{
			return false;
		}
	}
	
	public function receive_msg()
	{
		
		// Receiveoptions
		$serialize_needed	= false;	// Must the transfer data be serialized ?
		$msgtype_receive=1;     // Whiche type of Message we want to receive ? (Here, the type is the same as the type we send,
							  	// but if you set this to 0 you receive the next Message in the Queue with any type.
		$maxsize=100;			// How long is the maximal data you like to receive.
		$option_receive=0; 		// MSG_IPC_NOWAIT; // If there are no messages of the wanted type in the Queue continue without wating.
							  	// If is set to NULL wait for a Message.
		
		if (msg_receive($this->queue_handle, $msgtype_receive ,$msgtype_erhalten,$maxsize,$daten,$serialize_needed, $option_receive, $err)===true)
		{
			
			$this->send_signal($daten);
		}
	}

	public function receive_msg2()
	{
		
		// Receiveoptions
		$serialize_needed	= false;	// Must the transfer data be serialized ?
		$msgtype_receive=1;     // Whiche type of Message we want to receive ? (Here, the type is the same as the type we send,
							  	// but if you set this to 0 you receive the next Message in the Queue with any type.
		$maxsize=100;			// How long is the maximal data you like to receive.
		$option_receive=0; 		// MSG_IPC_NOWAIT; // If there are no messages of the wanted type in the Queue continue without wating.
							  	// If is set to NULL wait for a Message.
		
		if (msg_receive($this->queue_handle, $msgtype_receive ,$msgtype_erhalten,$maxsize,$daten,$serialize_needed, $option_receive, $err)===true)
		{
			
			return $daten;
		}
	}
	
	public function processExists($process)
	{
		// Check if file is in process list
		exec("ps -ef|grep $process|grep -v grep", $pids);
		if (count($pids) >= 1)
		{
			$pid = implode(" ", array_filter(explode(" ", $pids[0])));			
			$data = explode(" ", $pid);
			if( isset($data[1]) )
			{
				return $data[1];
				exit();
			}
		}
		return 0;
	}
	
	public function send_signal($signal_msg)
	{		
		// 
		// deamon name is daemon_$signal_msg.php
		// $signal_msg is sent to daemon name daemon_$signal_msg.php
		//
		error_log($signal_msg,3,"/var/www/html2/dlogs/log1.txt");
		$daemon 		= "daemon_" . $signal_msg . ".php" ;
		$signal_type 	= SIGUSR1;

		$pid = $this->processExists($daemon);
		if($pid > 0)
		{
			if ( posix_kill( $pid , $signal_type ) )
			{
				return $pid;
			}
		}
		else
		{
			return false;
		}
	}
}


