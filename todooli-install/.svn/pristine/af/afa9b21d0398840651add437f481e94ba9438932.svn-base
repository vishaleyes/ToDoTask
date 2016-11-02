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

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class General extends CFormModel
{
//function for verify correct admin
	var $max;                           //Highest value of the array
	var $min;                           //Lowest value of the array   
	var $ntick = 10;                     //Number of tick marks      

	public $genrallibObj;
	function __construct()
	{
		
	}
	
	public function getNextDate($type=0,$reminderTime=0,$firstflag=0)
	{
	
		switch ($type) {
			case 0:
					if($firstflag==1 && date('H')<$reminderTime)
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' +1 day'));
					}
				break;
			case 1:
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Sunday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Sunday'));
					}
				break;
			case 2:					
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Monday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Monday'));
					}
				break;
			case 3:									
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Tuesday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Tuesday'));
					}
				break;
			case 4:											
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Wednesday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Wednesday'));
					}
				break;
			case 5:										
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Thursday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Thursday'));
					}
				break;
			case 6:									
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Friday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Friday'));
					}
				break;
			case 7:								
					if($firstflag==1 && date('H')<$reminderTime && date('l')=="Saturday")
					{
						return date('Y-m-d H:i:s'); 	
					}
					else
					{
						return date('Y-m-d H:i:s', strtotime(' next Saturday'));
					}
				break;
			case 8:
				return date('Y-m-d H:i:s', strtotime('first day next month'));
				break;
			case 9:
				return date('Y-m-d H:i:s', strtotime('first day next year'));
				break;
		}
	}
	
	function ConvertOneTimezoneToAnotherTimezone($time,$timezoneRequired)
{
   $system_timezone = date_default_timezone_get();
   // $local_timezone = $currentTimezone;
    //date_default_timezone_set($system_timezone);
    $local = date("Y-m-d h:i:s A");
    date_default_timezone_set("GMT");
    $gmt = date("Y-m-d h:i:s A");
 
    $require_timezone = $timezoneRequired;
    date_default_timezone_set($require_timezone);
    $required = date("Y-m-d h:i:s A");
 
    date_default_timezone_set($system_timezone);

    $diff1 = (strtotime($gmt) - strtotime($local));
    $diff2 = (strtotime($required) - strtotime($gmt));

	$dateinsec=strtotime($time);
	$newdate=$dateinsec+$diff1+$diff2;
	//echo date('D M H:i:s Y',$newdate);
   // $date = new DateTime($time);
   // $date->modify("+$diff1 seconds");
   // $date->modify("+$diff2 seconds");
	//$timestamp1=$date->format("Y-m-d H:i:s");
	//$hour1 = $date->format("H");
    $timestamp = date("Y-m-d H:i:s",$newdate);
	 $date = date("Y-m-d",$newdate);
    $hour = date("H",$newdate);
    return array($timestamp,$hour,$date);
}
 
	function clearPhone($phone)
	{
		$phone=trim($phone);
		$metcharray=array('[',']','(',')',' ','.','-');
		$replacearray=array('');
		$data=str_replace($metcharray,$replacearray,$phone);
		return trim($data);
	}
	
	function isValidEmail($email)
    {
        $lengthPattern = "/^[^@]{1,64}@[^@]{1,255}$/";
        $syntaxPattern = "/^((([\w\+\-]+)(\.[\w\+\-]+)*)|(\"[^(\\|\")]{0,62}\"))@(([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9]{2,})|\[?([1]?\d{1,2}|2[0-4]{1}\d{1}|25[0-5]{1})(\.([1]?\d{1,2}|2[0-4]{1}\d{1}|25[0-5]{1})){3}\]?)$/";
        return ((preg_match($lengthPattern, $email) > 0) && (preg_match($syntaxPattern, $email) > 0)) ? true : false;
    }
	
	
	function clearPost($dataArray)
	{
		$search = unserialize(NOT_ALLOW_CHAR);
		$replace = array( '');
		$temp=$dataArray;
		
		$post = str_replace($search, $replace, $dataArray,$count);
		if(isset($count) && $count>0)
		{
			if(isset($_SERVER["HTTP_REFERER"]))
			{
			}
			if(isset($_SERVER["HTTP_USER_AGENT"]))
			{
			}
		}
		return $temp;
	}
	
	function check_password($password,$cpassword=NULL)
	{
		if($password == "")
		{
			return 1;
		}
		else if(strlen($password) < 6)
		{
			return 2;
		}
		else if(!preg_match("/[a-z]/", $password))
		{
			return 3;
		}
		else if(!preg_match("/[A-Z]/", $password))
		{
			return 4;
		}
		else if(!preg_match("/[0-9]/", $password))
		{
			return 5;
		}
		else if(!preg_match("/[.,!,@,#,$,%,^,&,*,?,_,~,-,£,(,)]/", $password))
		{
			return 6;
		}
		else if(isset($cpassword))
		{
			if($password != $cpassword)
			{
				return 7;
			}
		}
		else
		{
			return 0;
		}
	}
	
	function validate_phoneUS($number){
		$numStripX = array('(', ')', '-', '.', '+');
		$numCheck = str_replace($numStripX, '', $number); 
		$firstNum = substr($number, 0, 1);
		if(($firstNum == 0) || ($firstNum == 1)) {return false;}
		elseif(!is_numeric($numCheck)){return false;}
		elseif(strlen($numCheck) > 10){return false;}
		elseif(strlen($numCheck) < 10){return false;}
		else{
			$formats = array('###-###-####', '(###) ###-####', '(###)###-####', '##########', '###.###.####', '(###) ###.####', '(###)###.####');
			$format = trim(preg_replace("/[0-9]/", "#", $number));
			return (in_array($format, $formats)) ? true : false;
		}
	}
	
	/* 
	 * 
	 * method - getAgeInYears
	 * 
	 * @param birthday is date in format "%Y-%m-%d"
	 * @return - age in years
     */
	function getAgeInYears($birthday) {
      list($year,$month,$day) = explode("-",$birthday);
      $year_diff  = date("Y") - $year;
      $month_diff = date("m") - $month;
      $day_diff   = date("d") - $day;
      if ($day_diff < 0 || $month_diff < 0)
        $year_diff--;
      return $year_diff;
    }
	
	function checkInArray($actualArray,$testingArray)
	{
		$result = array_merge((array)array_unique($actualArray), (array)array_unique($testingArray));
		$resultfinal=array_unique($result);
		if(count($resultfinal)>count($actualArray))
		{
			return 1;	
		}
		else
		{
			return 0;	
		}	
	}
	
	function truncateName($string,$length=10) {
		$string = substr($string,0,$length);
		return $string;
	}
	
	public function ago($querydate)
    {
		global $msg;
		$dat=$querydate;
        $querydate=strtotime($querydate);
        $minusdate = strtotime(date('Y-m-d H:i:s')) - $querydate;
        if($minusdate > 88697640 && $minusdate < 100000000)
        {
            $minusdate = $minusdate - 88697640;
        }
        switch ($minusdate)
        {
            case ($minusdate <= 0):
            return $msg['_JUST_NOW_'];
            break;
            case ($minusdate < 2359):
            if($minusdate < 59)
            {
                return $date_string = $minusdate.$msg['_SECOND_AGO_'];
            }
            elseif($minusdate > 59)
            {
				$minutes=(int)($minusdate/60);
				if($minutes==1)
				{
					return $date_string = $msg['_ONE_MINUTE_AGO_'];
				}
				else
				{
                	return $date_string = $minutes.$msg['_MINUTES_AGO_'];
            	}
			}
            break;
            case ($minusdate > 2359 && $minusdate < 86400):
            $flr = (int)($minusdate/3600);
            if($flr == 1)
            {
                return $date_string = $msg['_ONE_HOUR_AGO_'];
            }
            else
            {
				if($flr==0)
				{
					return $date_string =$msg['_ONE_HOUR_AGO_'];
				}
				else
				{
                	return $date_string = $flr.$msg['_HOURS_AGO_'];
            	}
            }
            break;
            case ($minusdate > 2359 && $minusdate < 2629743):
            $flr = (int)($minusdate/86400);
            if($flr == 1)
            {
                return $msg['_ONE_DAY_AGO_'];
            }
            else
            {
                return $date_string = $flr.$msg['_DAYS_AGO_'];
            }
            break;
            case ($minusdate > 2629743 && $minusdate < 12320000):
            return date("j F, Y",strtotime($dat));
           
            break;
            case ($minusdate > 100000000):
            return date("j F, Y",strtotime($dat));
        }
    }  
	
	function rel_time($querydate, $to = null)
	{
		global $msg;
		$dat=$querydate;
		$querydate=strtotime($querydate);
		$minusdate = strtotime(date('Y-m-d H:i:s')) - $querydate;
		if($minusdate > 88697640 && $minusdate < 100000000)
		{
			$minusdate = $minusdate - 88697640;
		}
		switch ($minusdate)
		{
			case ($minusdate <= 0):
				return $msg['_JUST_NOW_'];
				break;
			case ($minusdate < 2359):
				if($minusdate < 59)
				{
					return $date_string = $minusdate.$msg['_SECOND_AGO_'];
				}
				elseif($minusdate > 59)
				{
					$minutes=(int)($minusdate/60);
					if($minutes==1)
					{
						return $date_string = $msg['_ONE_MINUTE_AGO_'];
					}
					else
					{
						return $date_string = $minutes.$msg['_MINUTES_AGO_'];
					}
				}
				break;
			case ($minusdate > 2359 && $minusdate < 86400):
				$flr = (int)($minusdate/3600);
				if($flr == 1)
				{
					return $date_string = $msg['_ONE_HOUR_AGO_'];
				}
				else
				{
					if($flr==0)
					{
						return $date_string =$msg['_ONE_HOUR_AGO_'];
					}
					else
					{
						return $date_string = $flr.$msg['_HOURS_AGO_'];
					}
				}
				break;
			case ($minusdate > 2359 && $minusdate < 2629743):
				$flr = (int)($minusdate/86400);
				if($flr == 1)
				{
					return $date_string = $msg['_ONE_DAY_AGO_'];
				}
				else
				{
					return $date_string = $flr.$msg['_DAYS_AGO_'];
				}
				break;
			case ($minusdate > 2629743 && $minusdate < 12320000):
				return date("j F, Y",strtotime($dat));
				
				break;
			case ($minusdate > 100000000):
				return date("j F, Y",strtotime($dat));
		}
	}
	
	function pastdue($querydate, $myTimeZone)
	{
		$returnArray=array('class'=>'','value'=>$querydate);
		$querydateRef=$querydate;
		date_default_timezone_set($myTimeZone);
		if( $querydate == date('Y-m-d') ) {
			$returnArray['value']	=	'Today';
			return $returnArray;
		} else if( $querydate == date('Y-m-d', strtotime("+1 day")) ) {
			 $returnArray['value']	=	'Tomorrow';
			return $returnArray;
		} else {
		
		global $msg;
		$dat=$querydate;
		$querydate=strtotime($querydate);
		$minusdate = strtotime(date('Y-m-d H:i:s')) - $querydate;
		if($minusdate<0)
		{
			 $returnArray['value']=$querydateRef;	
			return $returnArray;
		}
		if($minusdate > 88697640 && $minusdate < 100000000)
		{
			$minusdate = $minusdate - 88697640;
		}
		date_default_timezone_set(date_default_timezone_get());
		switch ($minusdate)
		{
			case ($minusdate <= 0):
				 $returnArray['value']=$msg['_JUST_NOW_'];
				return $returnArray;
				break;
			case ($minusdate < 2359):
				if($minusdate < 59)
				{
					 $returnArray['value'] = $minusdate.$msg['_SECOND_AGO_'];
					return $returnArray;
				}
				elseif($minusdate > 59)
				{
					$minutes=(int)($minusdate/60);
					if($minutes==1)
					{
						 $returnArray['value'] = $msg['_ONE_MINUTE_AGO_'];
						 return $returnArray;
					}
					else
					{
						 $returnArray['value']  = $minutes.$msg['_MINUTES_AGO_'];
						  return $returnArray;
					}
				}
				break;
			case ($minusdate > 2359 && $minusdate < 86400):
				$flr = (int)($minusdate/3600);
				if($flr == 1)
				{
					 $returnArray['value'] = $msg['_ONE_HOUR_AGO_'];
					  return $returnArray;
				}
				else
				{
					if($flr==0)
					{
						 $returnArray['value'] =$msg['_ONE_HOUR_AGO_'];
						 return $returnArray;
					}
					else
					{
						 $returnArray['value'] = $flr.$msg['_HOURS_AGO_'];
						 return $returnArray;
					}
				}
				break;
			case ($minusdate > 2359 && $minusdate < 2629743):
				$flr = (int)($minusdate/86400);
				if($flr == 1)
				{
					 $returnArray['value'] = '1 day past due';
					 $returnArray['class']='red';
					 return $returnArray;
				}
				else
				{
					 $returnArray['value'] = $flr.' days past due';
					 $returnArray['class']='red';
					 return $returnArray;
				}
				break;
			case ($minusdate > 2629743 && $minusdate < 12320000):
				
				 $returnArray['value']=  $querydateRef.' past due';
				$returnArray['class']='red';
				return $returnArray;
				
				break;
			case ($minusdate > 100000000):
				$returnArray['value']=  $querydateRef.' past due';
				$returnArray['class']='red';
				 return $returnArray;
		}
		}
	}
	
	function resizeImage($img_name,$filename, $new_w, $new_h, $ratio = true,$resizesmall = false){

		//get image extension.

		$ext = $this->getExtension($img_name);

		//creates the new image using the appropriate function from gd library
		if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext)) $src_img = imagecreatefromjpeg($img_name);

		if(!strcmp("png",$ext)) $src_img = imagecreatefrompng($img_name);

		if(!strcmp("gif",$ext)) $src_img = imagecreatefromgif($img_name);

		if(!strcmp("bmp",$ext)) $src_img = imagecreatefromwbmp($img_name);

		//gets the dimmensions of the image
		$old_x= imageSX($src_img);
		$old_y= imageSY($src_img);

		if ((($old_x >= $new_w) && ($old_y >= $new_h)) || (($old_x >= $new_w) || ($old_y >= $new_h) && $ratio == true) || $resizesmall == true)
		{

			// next we will calculate the new dimmensions for the thumbnail image
			// the next steps will be taken:
			// 1. calculate the ratio by dividing the old dimmensions with the new ones
			//	 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
			//	 and the height will be calculated so the image ratio will not change
			//	 3. otherwise we will use the height ratio for the image
			// as a result, only one of the dimmensions will be from the fixed ones
			$ratio1 = $old_x / $new_w;
			$ratio2 = $old_y / $new_h;
			if ($ratio1 > $ratio2){
				$thumb_w=$new_w;
				$thumb_h=$old_y/$ratio1;
			} else {
				$thumb_h=$new_h;
				$thumb_w=$old_x/$ratio2;
			}

			if($ratio == false)
			{
				$thumb_w = $new_w;
				$thumb_h = $new_h;
			}

			// we create a new image with the new dimmensions
			$dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
			//$dst_img = imagecreate($thumb_w, $thumb_h);

			// resize the big image to the new created one
			imagecopyresampled($dst_img, $src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

			// output the created image to the file. Now we will have the thumbnail into the file named by $filename
			if(!strcmp("png",$ext)){
				imagepng($dst_img,$filename);
			} else {
				imagejpeg($dst_img,$filename);
			}
		} else {
			
		}
		//destroys source and destination images.
		//imagedestroy($dst_img);
		//imagedestroy($src_img);
	}

	// This function reads the extension of the file. It is used to determine if the file is an image by checking the extension.
	function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}

	function getStringOfArray($arrayVar) {
		if(is_array($arrayVar))
		{
		$new_array = array_map(
						create_function('$key, $value', 'return $key.":".$value." # ";'), 
						array_keys($arrayVar), array_values($arrayVar));
		return (implode($new_array));
		}
		return $arrayVar;
	}
	
	function isURL($url = NULL) {
        if($url==NULL) return false;
		$url=strtolower($url);
        $protocol = '(http://|https://)';
        $allowed = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';

        $regex = "/^". $protocol . // must include the protocol
                         '(' . $allowed . '{1,63}\.)+'. // 1 or several sub domains with a max of 63 chars
                         '[a-z]' . '{2,6}^$/i'; // followed by a TLD
        
		if(preg_match($regex, $url)==true) return true;
        else return false;
	}
	
	function isValidURL($url)
	{
		if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', strtolower($url)))
		{
			if(!preg_match('/[<>\?\%\\=\$]/',$url))
			{
				return true;	
			}
			else
			{
				return false;	
			}
		}
		else
		{
			return false;	
		}
	}
	
	function remove_directory($directory, $empty=FALSE)
	{
		
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/')
		{
			$directory = substr($directory,0,-1);
		}
	
		// if the path is not valid or is not a directory ...
		if(!file_exists($directory) || !is_dir($directory))
		{
			// ... we return false and exit the function
			return FALSE;
	
		// ... if the path is not readable
		}elseif(!is_readable($directory))
		{
			// ... we return false and exit the function
			return FALSE;
	
		// ... else if the path is readable
		}else{
	
			// we open the directory
			$handle = opendir($directory);
	
			// and scan through the items inside
			while (FALSE !== ($item = readdir($handle)))
			{
				// if the filepointer is not the current directory
				// or the parent directory
				if($item != '.' && $item != '..')
				{
					// we build the new path to delete
					$path = $directory.'/'.$item;
	
					// if the new path is a directory
					if(is_dir($path)) 
					{
						// we call this function with the new path
						$this->remove_directory($path);
	
					// if the new path is a file
					} else {
						// we remove the file
						$is_svn = strstr($directory, '.svn');
						if ($is_svn === FALSE) {
							
							unlink($path);
						}
					}
				}
			}
			// close the directory
			closedir($handle);
	
			// if the option to empty is not set to true
			if($empty == FALSE)
			{
				// try to delete the now empty directory
				$is_svn = strstr($directory, '.svn');
				if ($is_svn === FALSE) {
				  if(!rmdir($directory)) {
					// return false if not possible
					return FALSE;
				  }
				}
			}
			// return success
			return TRUE;
		}
	}
	
	/************ GENERATION TOKEN IN SESSION ***********/
	function generateToken()
	{
		unset($_SESSION['fToken']);
		$_SESSION['fToken']	=	md5(uniqid() . microtime() . rand());
		return $_SESSION['fToken'];
	}
	
	/************ CHECK FOR VALID TOKEN ************/
	function checkValidToken($token)
	{
		
		if(Yii::app()->session['fToken'] == $token){
			return true;
		}else{
			return false;
		}
	}
	
	 function validate_password($plain, $encrypted) {
	if ($this->chk_not_null($plain) && $this->chk_not_null($encrypted)) {
// split apart the hash / salt
      $stack = explode(':', $encrypted);
	
      if (sizeof($stack) != 2) return false;
     
	  if (md5($stack[1] . $plain) == $stack[0]) {
		    return true;
      }
    }
    return false;
  }
  
   function chk_not_null($value) {
    $class='queryFactoryResult';
	if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } elseif($value instanceof $class) {
      if (sizeof($value->result) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      
		if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen($value) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }

////
// This function makes a new password from a plaintext password. 
  function encrypt_password($plain) {
    $password = '';
    for ($i=0; $i<10; $i++) {
      $password .= $this->get_rand();
    }

    $salt = substr(md5($password), 0, 2);

    $password = md5($salt . $plain) . ':' . $salt;

    return $password;
  }
  
  // Return a random value
  function get_rand($min = null, $max = null) {
    static $seeded;

    if (!$seeded) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }
  
  function autolink($str, $isFalse=0, $attributes=array() ) {
	if( isset($isFalse) && $isFalse == 0  ) {
		$attrs = '';
		foreach ($attributes as $attribute => $value) {
			$attrs .= " {$attribute}=\"{$value}\"";
		}
		$str = ' ' . $str;
		$str = preg_replace(
			'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
			'$1<a target="_blank" href="$2"'.$attrs.'>$2</a>',
			$str
		);
		$str = substr($str, 1);
	}
	
	return $str;
}
	//Function to calculate the Y-Axis scale for the trend data.         
	function y_axis_for_trend($trend_array)
	{
		$this->max = $trend_array[0];
		$array_length = count($trend_array);      //Length of the array
		// Calculate the highest trend value. 
		for ($i = 0; $i < ($array_length); $i++) 
		{
			if ($trend_array[$i] >= $this->max)
			{
				$this->max = $trend_array[$i];
		   	}
		}
		
		if ($this->max == 0)   {$this->max = 10;}   //If the Trend Array is empty or all values are zero, set the default Max Value to 10
		
		$this->min = $this->max;
		// Calculate the lowest trend value. 
		for ($i = 0; $i < ($array_length); $i++) 
		{
			if ($trend_array[$i] <= $this->min)
			{
				$this->min = $trend_array[$i];
			}   
		}            
		
		//Algorithm to calculate the graph axis tick marks
		$range = $this->nicenum($this->max - $this->min, 'false');
		$d = $this->nicenum(($range) / ($this->ntick - 1), 'true');   //Tick mark spacing
		$d	=	round($d);
		if($d == 0){
			$d =	1;
		}
		
		$graphmin = floor($this->min / $d) * $d;            //Graph range min
		$graphmax = ceil($this->max / $d) * $d;            //Graph range max
		$nfrac = max( -floor(log10($d)),0);
		
		$total = $graphmin - $d;
		$tick_marks = array();
		for ($i = 0; $total < ($graphmax); $i++) 
		{   
		   $total = $total + $d;
		   $tick_marks[$i] = round($total, $nfrac);   
		}
		
		if($graphmin > 0){
			$graphmin	=	0;	//	MINIMUM RANGE VALUE IS MADE 0 MANUALLY 
		}
		
		$result = array();
		$result[] = $graphmin;
		$result[] = $graphmax;
		$result[] = $d;
		return $result;
	}
	
	function nicenum($x, $round1)
	{
		$exp = floor(log10($x));   //Exponent of X
		$f = $x / pow(10,$exp);      //Fractional part of X
		if($round1)
		{
		if($f < 1.5)   {
		   $nf = 1;
		} elseif ($f < 3)   {
		   $nf = 2;
		} elseif ($f < 7)   {
		   $nf = 5;
		} else   {
		   $nf = 10;   
		}
		} else   {
		if ($f <= 1)   {
		   $nf = 1;
		} elseif ($f <= 2)   {
		   $nf = 2;
		} elseif ($f <= 5)   {
		   $nf = 5;
		} else   {
		   $nf = 10;      
		}
		}
		$nicenum = $nf * pow(10,$exp);   
		return $nicenum;
	}
	
	/**
	 * Returns a nested array of timzones by continant. Suitable for input into
	 */
	public static function getTimeZones()
	{
			return array (
					'America (North & South)' => array (
							'America/Scoresbysund' => '[GMT-01:00] Eastern Greenland Time (America/ Scoresbysund)',
							'America/Noronha' => '[GMT-02:00] Fernando de Noronha Time (America/ Noronha)',
							'America/Argentina/Buenos_Aires' => '[GMT-03:00] Argentine Time (AGT)',
							'America/Belem' => '[GMT-03:00] Brazil Time (America/ Belem)',
							'America/Sao_Paulo' => '[GMT-03:00] Brazil Time (BET)',
							'America/Cayenne' => '[GMT-03:00] French Guiana Time (America/ Cayenne)',
							'America/Miquelon' => '[GMT-03:00] Pierre & Miquelon Standard Time (America/ Miquelon)',
							'America/Paramaribo' => '[GMT-03:00] Suriname Time (America/ Paramaribo)',
							'America/Montevideo' => '[GMT-03:00] Uruguay Time (America/ Montevideo)',
							'America/Godthab' => '[GMT-03:00] Western Greenland Time (America/ Godthab)',
							'America/St_Johns' => '[GMT-03:30] Newfoundland Standard Time (America/ St Johns)',
							'America/Cuiaba' => '[GMT-04:00] Amazon Standard Time (America/ Cuiaba)',
							'America/Glace_Bay' => '[GMT-04:00] Atlantic Standard Time (America/ Glace Bay)',
							'America/La_Paz' => '[GMT-04:00] Bolivia Time (America/ La Paz)',
							'America/Santiago' => '[GMT-04:00] Chile Time (America/ Santiago)',
							'America/Guyana' => '[GMT-04:00] Guyana Time (America/ Guyana)',
							'America/Asuncion' => '[GMT-04:00] Paraguay Time (America/ Asuncion)',
							'America/Caracas' => '[GMT-04:00] Venezuela Time (America/ Caracas)',
							'America/Porto_Acre' => '[GMT-05:00] Acre Time (America/ Porto Acre)',
							'America/Havana' => '[GMT-05:00] Central Standard Time (America/ Havana)',
							'America/Bogota' => '[GMT-05:00] Colombia Time (America/ Bogota)',
							'America/Jamaica' => '[GMT-05:00] Eastern Standard Time (America/ Jamaica)',
							'America/Indianapolis' => '[GMT-05:00] Eastern Standard Time (US/ East-Indiana)',
							'America/Guayaquil' => '[GMT-05:00] Ecuador Time (America/ Guayaquil)',
							'America/Lima' => '[GMT-05:00] Peru Time (America/ Lima)',
							'America/El_Salvador' => '[GMT-06:00] Central Standard Time (America/ El Salvador)',
							'America/Regina' => '[GMT-06:00] Central Standard Time (Canada/ Saskatchewan)',
							'America/Chicago' => '[GMT-06:00] Central Standard Time (US & Canada)',
							'America/Phoenix' => '[GMT-07:00] Mountain Standard Time (US/ Arizona)',
							'America/Los_Angeles' => '[GMT-08:00] Pacific Standard Time (US & Canada)',
							'America/Anchorage' => '[GMT-09:00] Alaska Standard Time (AST)',
							'America/Adak' => '[GMT-10:00] Hawaii-Aleutian Standard Time (America/ Adak)',
					),
					'Africa' => array (
							'Africa/Casablanca' => '[GMT+00:00] Western European Time (Africa/ Casablanca)',
							'Africa/Algiers' => '[GMT+01:00] Central European Time (Africa/ Algiers)',
							'Africa/Bangui' => '[GMT+01:00] Western African Time (Africa/ Bangui)',
							'Africa/Windhoek' => '[GMT+01:00] Western African Time (Africa/ Windhoek)',
							'Africa/Tripoli' => '[GMT+02:00] Eastern European Time (Africa/ Tripoli)',
							'Africa/Johannesburg' => '[GMT+02:00] South Africa Standard Time (Africa/ Johannesburg)',
							'Africa/Dar_es_Salaam' => '[GMT+03:00] Eastern African Time (EAT)',
					),
					'Antarctica' => array (
							'Antarctica/Syowa' => '[GMT+03:00] Syowa Time (Antarctica/ Syowa)',
							'Antarctica/Mawson' => '[GMT+06:00] Mawson Time (Antarctica/ Mawson)',
							'Antarctica/Vostok' => '[GMT+06:00] Vostok Time (Antarctica/ Vostok)',
							'Antarctica/Davis' => '[GMT+07:00] Davis Time (Antarctica/ Davis)',
							'Antarctica/DumontDUrville' => '[GMT+10:00] Dumont-d\'Urville Time (Antarctica/ DumontDUrville)',
							'Antarctica/Rothera' => '[GMT-03:00] Rothera Time (Antarctica/ Rothera)',
					),
					'Asia' => array (
							'Asia/Jerusalem' => '[GMT+02:00] Israel Standard Time (Asia/ Jerusalem)',
							'Asia/Baghdad' => '[GMT+03:00] Arabia Standard Time (Asia/ Baghdad)',
							'Asia/Kuwait' => '[GMT+03:00] Arabia Standard Time (Asia/ Kuwait)',
							'Asia/Tehran' => '[GMT+03:30] Iran Standard Time (Asia/ Tehran)',
							'Asia/Aqtau' => '[GMT+04:00] Aqtau Time (Asia/ Aqtau)',
							'Asia/Yerevan' => '[GMT+04:00] Armenia Time (NET)',
							'Asia/Baku' => '[GMT+04:00] Azerbaijan Time (Asia/ Baku)',
							'Asia/Tbilisi' => '[GMT+04:00] Georgia Time (Asia/ Tbilisi)',
							'Asia/Dubai' => '[GMT+04:00] Gulf Standard Time (Asia/ Dubai)',
							'Asia/Oral' => '[GMT+04:00] Oral Time (Asia/ Oral)',
							'Asia/Kabul' => '[GMT+04:30] Afghanistan Time (Asia/ Kabul)',
							'Asia/Aqtobe' => '[GMT+05:00] Aqtobe Time (Asia/ Aqtobe)',
							'Asia/Bishkek' => '[GMT+05:00] Kirgizstan Time (Asia/ Bishkek)',
							'Asia/Karachi' => '[GMT+05:00] Pakistan Time (PLT)',
							'Asia/Dushanbe' => '[GMT+05:00] Tajikistan Time (Asia/ Dushanbe)',
							'Asia/Ashgabat' => '[GMT+05:00] Turkmenistan Time (Asia/ Ashgabat)',
							'Asia/Tashkent' => '[GMT+05:00] Uzbekistan Time (Asia/ Tashkent)',
							'Asia/Yekaterinburg' => '[GMT+05:00] Yekaterinburg Time (Asia/ Yekaterinburg)',
							'Asia/Calcutta' => '[GMT+05:30] Asia/Calcutta (India Standard Time)',
							'Asia/Katmandu' => '[GMT+05:45] Nepal Time (Asia/ Katmandu)',
							'Asia/Almaty' => '[GMT+06:00] Alma-Ata Time (Asia/ Almaty)',
							'Asia/Thimbu' => '[GMT+06:00] Bhutan Time (Asia/ Thimbu)',
							'Asia/Novosibirsk' => '[GMT+06:00] Novosibirsk Time (Asia/ Novosibirsk)',
							'Asia/Omsk' => '[GMT+06:00] Omsk Time (Asia/ Omsk)',
							'Asia/Qyzylorda' => '[GMT+06:00] Qyzylorda Time (Asia/ Qyzylorda)',
							'Asia/Colombo' => '[GMT+06:00] Sri Lanka Time (Asia/ Colombo)',
							'Asia/Rangoon' => '[GMT+06:30] Myanmar Time (Asia/ Rangoon)',
							'Asia/Hovd' => '[GMT+07:00] Hovd Time (Asia/ Hovd)',
							'Asia/Krasnoyarsk' => '[GMT+07:00] Krasnoyarsk Time (Asia/ Krasnoyarsk)',
							'Asia/Jakarta' => '[GMT+07:00] West Indonesia Time (Asia/ Jakarta)',
							'Asia/Brunei' => '[GMT+08:00] Brunei Time (Asia/ Brunei)',
							'Asia/Makassar' => '[GMT+08:00] Central Indonesia Time (Asia/ Makassar)',
							'Asia/Hong_Kong' => '[GMT+08:00] Hong Kong Time (Asia/ Hong Kong)',
							'Asia/Irkutsk' => '[GMT+08:00] Irkutsk Time (Asia/ Irkutsk)',
							'Asia/Kuala_Lumpur' => '[GMT+08:00] Malaysia Time (Asia/ Kuala Lumpur)',
							'Asia/Manila' => '[GMT+08:00] Philippines Time (Asia/ Manila)',
							'Asia/Shanghai' => '[GMT+08:00] Shanghai Time (Asia/ Shanghai)',
							'Asia/Singapore' => '[GMT+08:00] Singapore Time (Asia/ Singapore)',
							'Asia/Taipei' => '[GMT+08:00] Taipei Time (Asia/ Taipei)',
							'Asia/Ulaanbaatar' => '[GMT+08:00] Ulaanbaatar Time (Asia/ Ulaanbaatar)',
							'Asia/Choibalsan' => '[GMT+09:00] Choibalsan Time (Asia/ Choibalsan)',
							'Asia/Jayapura' => '[GMT+09:00] East Indonesia Time (Asia/ Jayapura)',
							'Asia/Dili' => '[GMT+09:00] East Timor Time (Asia/ Dili)',
							'Asia/Tokyo' => '[GMT+09:00] Japan Standard Time (JST)',
							'Asia/Seoul' => '[GMT+09:00] Korea Standard Time (Asia/ Seoul)',
							'Asia/Yakutsk' => '[GMT+09:00] Yakutsk Time (Asia/ Yakutsk)',
							'Asia/Sakhalin' => '[GMT+10:00] Sakhalin Time (Asia/ Sakhalin)',
							'Asia/Vladivostok' => '[GMT+10:00] Vladivostok Time (Asia/ Vladivostok)',
							'Asia/Magadan' => '[GMT+11:00] Magadan Time (Asia/ Magadan)',
							'Asia/Anadyr' => '[GMT+12:00] Anadyr Time (Asia/ Anadyr)',
							'Asia/Kamchatka' => '[GMT+12:00] Petropavlovsk-Kamchatski Time (Asia/ Kamchatka)',
					),
					'Atlantic Ocean' => array (
							'Atlantic/Jan_Mayen' => '[GMT+01:00] Eastern Greenland Time (Atlantic/ Jan Mayen)',
							'Atlantic/Azores' => '[GMT-01:00] Azores Time (Atlantic/ Azores)',
							'Atlantic/Cape_Verde' => '[GMT-01:00] Cape Verde Time (Atlantic/ Cape Verde)',
							'Atlantic/South_Georgia' => '[GMT-02:00] South Georgia Standard Time (Atlantic/ South Georgia)',
							'Atlantic/Bermuda' => '[GMT-04:00] Atlantic Standard Time (Atlantic/ Bermuda)',
							'Atlantic/Stanley' => '[GMT-04:00] Falkland Is. Time (Atlantic/ Stanley)',
					),
					'Australia' => array (
							'Australia/Perth' => '[GMT+08:00] Western Standard Time (Australia) (Australia/ Perth)',
							'Australia/Broken_Hill' => '[GMT+09:30] Central Standard Time (Australia/ Broken Hill)',
							'Australia/Darwin' => '[GMT+09:30] Central Standard Time (Northern Territory) (ACT)',
							'Australia/Adelaide' => '[GMT+09:30] Central Standard Time (South Australia) (Australia/ Adelaide)',
							'Australia/Sydney' => '[GMT+10:00] Eastern Standard Time (New South Wales) (Australia/ Sydney)',
							'Australia/Brisbane' => '[GMT+10:00] Eastern Standard Time (Queensland) (Australia/ Brisbane)',
							'Australia/Hobart' => '[GMT+10:00] Eastern Standard Time (Tasmania) (Australia/ Hobart)',
							'Australia/Melbourne' => '[GMT+10:00] Eastern Standard Time (Victoria) (Australia/ Melbourne)',
							'Australia/Lord_Howe' => '[GMT+10:30] Load Howe Standard Time (Australia/ Lord Howe)',
					),
					'Europe' => array (
							'Europe/Lisbon' => '[GMT+00:00] Western European Time (Europe/ Lisbon)',
							'Europe/Berlin' => '[GMT+01:00] Central European Time (Europe/ Berlin)',
							'Europe/Istanbul' => '[GMT+02:00] Eastern European Time (Europe/ Istanbul)',
							'Europe/Moscow' => '[GMT+03:00] Moscow Standard Time (Europe/ Moscow)',
							'Europe/Samara' => '[GMT+04:00] Samara Time (Europe/ Samara)',
					),
					'Indian' => array (
							'Indian/Mauritius' => '[GMT+04:00] Mauritius Time (Indian/ Mauritius)',
							'Indian/Reunion' => '[GMT+04:00] Reunion Time (Indian/ Reunion)',
							'Indian/Mahe' => '[GMT+04:00] Seychelles Time (Indian/ Mahe)',
							'Indian/Kerguelen' => '[GMT+05:00] French Southern & Antarctic Lands Time (Indian/ Kerguelen)',
							'Indian/Maldives' => '[GMT+05:00] Maldives Time (Indian/ Maldives)',
							'Indian/Chagos' => '[GMT+06:00] Indian Ocean Territory Time (Indian/ Chagos)',
							'Indian/Cocos' => '[GMT+06:30] Cocos Islands Time (Indian/ Cocos)',
							'Indian/Christmas' => '[GMT+07:00] Christmas Island Time (Indian/ Christmas)',
					),
					'Pacific Ocean' => array (
							'Pacific/Palau' => '[GMT+09:00] Palau Time (Pacific/ Palau)',
							'Pacific/Guam' => '[GMT+10:00] Chamorro Standard Time (Pacific/ Guam)',
							'Pacific/Port_Moresby' => '[GMT+10:00] Papua New Guinea Time (Pacific/ Port Moresby)',
							'Pacific/Truk' => '[GMT+10:00] Truk Time (Pacific/ Truk)',
							'Pacific/Yap' => '[GMT+10:00] Yap Time (Pacific/ Yap)',
							'Pacific/Kosrae' => '[GMT+11:00] Kosrae Time (Pacific/ Kosrae)',
							'Pacific/Noumea' => '[GMT+11:00] New Caledonia Time (Pacific/ Noumea)',
							'Pacific/Ponape' => '[GMT+11:00] Ponape Time (Pacific/ Ponape)',
							'Pacific/Efate' => '[GMT+11:00] Vanuatu Time (Pacific/ Efate)',
							'Pacific/Norfolk' => '[GMT+11:30] Norfolk Time (Pacific/ Norfolk)',
							'Pacific/Fiji' => '[GMT+12:00] Fiji Time (Pacific/ Fiji)',
							'Pacific/Tarawa' => '[GMT+12:00] Gilbert Is. Time (Pacific/ Tarawa)',
							'Pacific/Majuro' => '[GMT+12:00] Marshall Islands Time (Pacific/ Majuro)',
							'Pacific/Nauru' => '[GMT+12:00] Nauru Time (Pacific/ Nauru)',
							'Pacific/Auckland' => '[GMT+12:00] New Zealand Standard Time (Pacific/ Auckland)',
							'Pacific/Funafuti' => '[GMT+12:00] Tuvalu Time (Pacific/ Funafuti)',
							'Pacific/Wake' => '[GMT+12:00] Wake Time (Pacific/ Wake)',
							'Pacific/Wallis' => '[GMT+12:00] Wallis & Futuna Time (Pacific/ Wallis)',
							'Pacific/Chatham' => '[GMT+12:45] Chatham Standard Time (Pacific/ Chatham)',
							'Pacific/Enderbury' => '[GMT+13:00] Phoenix Is. Time (Pacific/ Enderbury)',
							'Pacific/Tongatapu' => '[GMT+13:00] Tonga Time (Pacific/ Tongatapu)',
							'Pacific/Kiritimati' => '[GMT+14:00] Line Is. Time (Pacific/ Kiritimati)',
							'Pacific/Easter' => '[GMT-06:00] Easter Is. Time (Pacific/ Easter)',
							'Pacific/Galapagos' => '[GMT-06:00] Galapagos Time (Pacific/ Galapagos)',
							'Pacific/Pitcairn' => '[GMT-08:00] Pitcairn Standard Time (Pacific/ Pitcairn)',
							'Pacific/Gambier' => '[GMT-09:00] Gambier Time (Pacific/ Gambier)',
							'Pacific/Marquesas' => '[GMT-09:30] Marquesas Time (Pacific/ Marquesas)',
							'Pacific/Rarotonga' => '[GMT-10:00] Cook Is. Time (Pacific/ Rarotonga)',
							'Pacific/Tahiti' => '[GMT-10:00] Tahiti Time (Pacific/ Tahiti)',
							'Pacific/Fakaofo' => '[GMT-10:00] Tokelau Time (Pacific/ Fakaofo)',
							'Pacific/Niue' => '[GMT-11:00] Niue Time (Pacific/ Niue)',
							'Pacific/Apia' => '[GMT-11:00] West Samoa Time (MIT)',
					),
			);
	}

}