<?PHP
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

/*
  -------------------------------------------------------------------------
      PHP Form Validator (formvalidator.php)
              Version 1.1
    This program is free software published under the
    terms of the GNU Lesser General Public License.

    This program is distributed in the hope that it will
    be useful - WITHOUT ANY WARRANTY; without even the
    implied warranty of MERCHANTABILITY or FITNESS FOR A
    PARTICULAR PURPOSE.
		
	For updates, please visit:
	http://www.html-form-guide.com/php-form/php-form-validation.html
	
	Questions & comments please send to info@html-form-guide.com
  -------------------------------------------------------------------------  
*/

/**
* Carries information about each of the form validations
*/
class ValidatorObj
{
	var $variable_name;
	var $validator_string;
	var $error_string;
}



/**
* Base class for custom validation objects
**/
class CustomValidator 
{
	function DoValidate(&$formars,&$error_hash)
	{
		return true;
	}
}

/** Default error messages*/
define("E_VAL_REQUIRED_VALUE","Please enter the value for %s");
define("E_VAL_MAXLEN_EXCEEDED","Maximum length exceeded for %s.");
define("E_VAL_MINLEN_CHECK_FAILED","Please enter input with length more than %d for %s");
define("E_VAL_ALNUM_CHECK_FAILED","Please provide an alpha-numeric input for %s");
define("E_VAL_ALNUM_S_CHECK_FAILED","Please provide an alpha-numeric input for %s");
define("E_VAL_NUM_CHECK_FAILED","Please provide numeric input for %s");
define("E_VAL_ALPHA_CHECK_FAILED","Please provide alphabetic input for %s");
define("E_VAL_ALPHA_S_CHECK_FAILED","Please provide alphabetic input for %s");
define("E_VAL_EMAIL_CHECK_FAILED","Please provide a valide email address");
define("E_VAL_LESSTHAN_CHECK_FAILED","Enter a value less than %f for %s");
define("E_VAL_GREATERTHAN_CHECK_FAILED","Enter a value greater than %f for %s");
define("E_VAL_REGEXP_CHECK_FAILED","Please provide a valid input for %s");
define("E_VAL_DONTSEL_CHECK_FAILED","Wrong option selected for %s");
define("E_VAL_SELMIN_CHECK_FAILED","Please select minimum %d options for %s");
define("E_VAL_SELONE_CHECK_FAILED","Please select an option for %s");
define("E_VAL_EQELMNT_CHECK_FAILED","Value of %s should be same as that of %s");
define("E_VAL_NEELMNT_CHECK_FAILED","Value of %s should not be same as that of %s");
define("E_VAL_CITY_CHECK_FAILED","Please provide valid city name");
define("E_VAL_BUSINESSNAME_CHECK_FAILED","Please provide valid business name");
define("E_VAL_TITLE_CHECK_FAILED","Do not use special characters in title");


/**
* FormValidator: The main class that does all the form validations
**/
class FormValidator 
{
	var $validator_array;
    var $error_hash;
	var $custom_validators;
	
	function FormValidator()
	{	
		$this->validator_array = array();
        $this->error_hash = array();
		$this->custom_validators=array();
	}
	
	function AddCustomValidator(&$customv)
	{
		array_push($this->custom_validators,$customv);
	}
	
	function addValidation($variable,$validator,$error)
	{
		$validator_obj = new ValidatorObj();
		$validator_obj->variable_name = $variable;
		$validator_obj->validator_string = $validator;
		$validator_obj->error_string = $error;
		array_push($this->validator_array,$validator_obj);
	}
    function GetErrors()
    {
		return $this->error_hash;
    }
	
	function GetError()
	{
		$error_hash = $this->GetErrors();
		$error="";
		$i=0;
		 foreach($error_hash as $inpname => $inp_err)
		 {
			 $error=$inp_err;
			if($i>0)
			{
				break;
			}
			
			$i++;
		 } 
		 
		 return $error;
	}

	function ValidateForm($formData=array())
	{
		$bret = true;
		
		$error_string="";
		$error_to_display = "";

        
		if(!empty($formData))
		{ 
		
			$form_variables = $formData;
		}
		else if(1==1)
		{
			$form_variables = $_POST;
		}
		else
		{
		$form_variables = $_GET;

		}
		
        $vcount = count($this->validator_array);
        

		foreach($this->validator_array as $val_obj)
		{
			if(!$this->ValidateObject($val_obj,$form_variables,$error_string))
			{
				$bret = false;
                $this->error_hash[$val_obj->variable_name] = $error_string;
				return false;
			}
		}

		if(true == $bret && count($this->custom_validators) > 0)
		{
            foreach( $this->custom_validators as $custom_val)
			{
				if(false == $custom_val->DoValidate($form_variables,$this->error_hash))
				{
					$bret = false;
				}
			}
		}
		return $bret;
	}


	function ValidateObject($validatorobj,$formvariables,&$error_string)
	{
		$bret = true;

		$splitted = explode("=",$validatorobj->validator_string);
		$command = $splitted[0];
		$command_value = '';

		if(isset($splitted[1]) && strlen($splitted[1])>0)
		{
			$command_value = $splitted[1];
		}

		$default_error_message="";
		
		$input_value ="";

		if(isset($formvariables[$validatorobj->variable_name]))
		{
		 $input_value = $formvariables[$validatorobj->variable_name];
		}

		$bret = $this->ValidateCommand($command,$command_value,$input_value,
									$default_error_message,
									$validatorobj->variable_name,
									$formvariables);

		
		if(false == $bret)
		{
			if(isset($validatorobj->error_string) &&
				strlen($validatorobj->error_string)>0)
			{
				$error_string = $validatorobj->error_string;
			}
			else
			{
				$error_string = $default_error_message;
			}

		}//if
		return $bret;
	}
    	
	function validate_req($input_value, &$default_error_message,$variable_name)
	{
	  $bret = true;
      	if(!isset($input_value) ||
			strlen(trim($input_value)) <=0)
		{
			$bret=false;
			$default_error_message = sprintf(E_VAL_REQUIRED_VALUE,$variable_name);
		}	
	  return $bret;	
	}

	function validate_maxlen($input_value,$max_len,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(isset($input_value) )
		{
			$input_length = strlen(trim($input_value));
			if($input_length > $max_len)
			{
				$bret=false;
				$default_error_message = sprintf(E_VAL_MAXLEN_EXCEEDED,$variable_name);
			}
		}
		return $bret;
	}

	function validate_minlen($input_value,$min_len,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(isset($input_value) )
		{
			$input_length = strlen(trim($input_value));
			if($input_length < $min_len)
			{
				$bret=false;
				$default_error_message = sprintf(E_VAL_MINLEN_CHECK_FAILED,$min_len,$variable_name);
			}
		}
		return $bret;
	}
	function validate_pass_match($input_value,$cpassword,$variable_name)
	{
		$bret = true;
		
			$cpassword_value = $_POST[$cpassword];
			if(trim($cpassword_value) != trim($input_value))
			{
				$bret=false;
			}
		
		return $bret;
	}


	function test_datatype($input_value,$reg_exp)
	{
		if(preg_match($reg_exp,$input_value))
		{
			return false;
		}
		return true;
	}

	function validate_email($email) 
	{
		return preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/", $email);
	}
	function validate_profile_name($name) 
	{
		return preg_match("/^[a-zA-Z0-9_]*$/", $name);
	}
	function validate_uszipcode($zipcode) 
	{
		if(preg_match("/^([0-9]{5})(-[0-9]{4})?$/i",$zipcode))
			return true;
		else
			return false;
	}
	function validate_city($city) 
	{
		if(preg_match("/^[A-Za-z ]*$/",$city))
			return true;
		else
			return false;
	}
	
	function validate_name($name) 
	{
		if(preg_match("/^[A-Za-z]*$/",trim($name)))
			return true;
		else
			return false;
	}
	
	function validate_fullname($name) 
	{
		if(preg_match("/^[A-Za-z ]*$/",trim($name)))
			return true;
		else
			return false;
	} 
	function validate_businessName($city) 
	{
		if(preg_match("/^[A-Za-z0-9-&,\. ']*$/",trim($city)))
			return true;
		else
			return false;
	} 
	function validate_title($city) 
	{
		if(preg_match("/^[A-Za-z-#&,\. ']*$/",trim($city)))
			return true;
		else
			return false;
	}
	
	function validate_todo_title($todo) 
	{
		if(preg_match("/^[A-Za-z-0-9#&,\"\. :\/\n\r']*$/",trim($todo)))
			return true;
		else
			return false;
	}
	
	function validate_website($website) 
	{
		if(preg_match("/^(http(s?):\/\/)?[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/",trim($website)))
			return true;
		else
			return false;
	}
	
	function validate_address($city) 
	{
		if(preg_match("/^[A-Za-z0-9-#:()&,\. ']*$/",trim($city)))
			return true;
		else
			return false;
	}
	
	function validate_description($city) 
	{
		if(preg_match("/^[A-Za-z0-9-!#&,?;\.\n\r ']*$/",trim($city)))
			return true;
		else
			return false;
	}
	
	function validate_comment($comment) 
	{
		if(preg_match("/^[A-Za-z0-9-!?,\.\n\r '\"]*$/",trim($comment)))
			return true;
		else
			return false;
	}
	
	function validate_usphone($number)
	{
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
	function validate_for_numeric_input($input_value,&$validation_success)
	{
		
		$more_validations=true;
		$validation_success = true;
		if(strlen(trim($input_value))>0)
		{
			
			if(false == is_numeric($input_value))
			{
				$validation_success = false;
				$more_validations=false;
			}
		}
		else
		{
			$more_validations=false;
		}
		return $more_validations;
	}

	function validate_lessthan($command_value,$input_value,
                $variable_name,&$default_error_message)
	{
		$bret = true;
		if(false == $this->validate_for_numeric_input($input_value,
                                    $bret))
		{
			return $bret;
		}
		if($bret)
		{
			$lessthan = doubleval($command_value);
			$float_inputval = doubleval($input_value);
			if($float_inputval >= $lessthan)
			{
				$default_error_message = sprintf(E_VAL_LESSTHAN_CHECK_FAILED,
										$lessthan,
										$variable_name);
				$bret = false;
			}//if
		}
		return $bret ;
	}

	function validate_greaterthan($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(false == $this->validate_for_numeric_input($input_value,$bret))
		{
			return $bret;
		}
		if($bret)
		{
			$greaterthan = doubleval($command_value);
			$float_inputval = doubleval($input_value);
			if($float_inputval <= $greaterthan)
			{
				$default_error_message = sprintf(E_VAL_GREATERTHAN_CHECK_FAILED,
										$greaterthan,
										$variable_name);
				$bret = false;
			}//if
		}
		return $bret ;
	}

    function validate_select($input_value,$command_value,&$default_error_message,$variable_name)
    {
	    $bret=false;
		if(is_array($input_value))
		{
			foreach($input_value as $value)
			{
				if($value == $command_value)
				{
					$bret=true;
					break;
				}
			}
		}
		else
		{
			if($command_value == $input_value)
			{
				$bret=true;
			}

		}
        if(false == $bret)
        {
            $default_error_message = sprintf(E_VAL_SHOULD_SEL_CHECK_FAILED,
                                            $command_value,$variable_name);
        }
	    return $bret;
    }

	function validate_dontselect($input_value,$command_value,&$default_error_message,$variable_name)
	{
	   $bret=true;
		if(is_array($input_value))
		{
			foreach($input_value as $value)
			{
				if($value == $command_value)
				{
					$bret=false;
					$default_error_message = sprintf(E_VAL_DONTSEL_CHECK_FAILED,$variable_name);
					break;
				}
			}
		}
		else
		{
			if($command_value == $input_value)
			{
				$bret=false;
				$default_error_message = sprintf(E_VAL_DONTSEL_CHECK_FAILED,$variable_name);
			}
		}
	  return $bret;
	}



	function ValidateCommand($command,$command_value,$input_value,&$default_error_message,$variable_name,$formvariables)
	{
		$bret=true;
		switch($command)
		{
			case 'req':
						{
							$bret = $this->validate_req($input_value, $default_error_message,$variable_name);
							break;
						}

			case 'maxlen':
						{
							$max_len = intval($command_value);
							$bret = $this->validate_maxlen($input_value,$max_len,$variable_name,
												$default_error_message);
							break;
						}

			case 'minlen':
						{
							$min_len = intval($command_value);
							$bret = $this->validate_minlen($input_value,$min_len,$variable_name,
											$default_error_message);
							break;
						}
						
			case 'pass_match':
						{
							$cpassword = $command_value;
							 $bret = $this->validate_pass_match($input_value,$cpassword,$variable_name);
							if(false == $bret)
							{
								$default_error_message = sprintf(E_VAL_ALNUM_CHECK_FAILED,$variable_name);
							}
							break;
						}

			case 'alnum':
						{
							$bret= $this->test_datatype($input_value,"[^A-Za-z0-9]");
							if(false == $bret)
							{
								$default_error_message = sprintf(E_VAL_ALNUM_CHECK_FAILED,$variable_name);
							}
							break;
						}

			case 'alnum_s':
						{
							$bret= $this->test_datatype($input_value,"[^A-Za-z0-9 ]");
							if(false == $bret)
							{
								$default_error_message = sprintf(E_VAL_ALNUM_S_CHECK_FAILED,$variable_name);
							}
							break;
						}

			case 'num':
            case 'numeric':
						{
							$bret= $this->test_datatype($input_value,"[^0-9]");
							if(false == $bret)
							{
								$default_error_message = sprintf(E_VAL_NUM_CHECK_FAILED,$variable_name);
							}
							break;							
						}

			case 'alpha':
						{
							$bret= $this->test_datatype($input_value,"[^A-Za-z]");
							if(false == $bret)
							{
								$default_error_message = sprintf(E_VAL_ALPHA_CHECK_FAILED,$variable_name);
							}
							break;
						}
			case 'alpha_s':
						{
							$bret= $this->test_datatype($input_value,"[^A-Za-z ]");
							if(false == $bret)
							{
								$default_error_message = sprintf(E_VAL_ALPHA_S_CHECK_FAILED,$variable_name);
							}
							break;
						}
			case 'profile':
						{
							$bret= $this->validate_profile_name($input_value);
							if(0 == $bret)
							{
								$default_error_message = sprintf(E_VAL_ALPHA_S_CHECK_FAILED,$variable_name);
							}
							break;
						}
			case 'email':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validate_email($input_value);
								if(false == $bret)
								{
									$default_error_message = E_VAL_EMAIL_CHECK_FAILED;
								}
							}
							break;
						}
						
			case 'uszipcode':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validate_uszipcode($input_value);
								if(false == $bret)
								{
									$default_error_message = E_VAL_EMAIL_CHECK_FAILED;
								}
							}
							break;
						}
						
			case 'city':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validate_city($input_value);
								if(false == $bret)
								{
									$default_error_message = E_VAL_CITY_CHECK_FAILED;
								}
							}
							break;
						}
						
			case 'name':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validate_name($input_value);
								if(false == $bret)
								{
									$default_error_message = E_VAL_CITY_CHECK_FAILED;
								}
							}
							break;
						}
									
			case 'businessName':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_businessName($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_BUSINESSNAME_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'title':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_title($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_TITLE_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'todoTitle':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_todo_title($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_TITLE_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'fullname':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_fullname($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_BUSINESSNAME_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'website':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_website($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_CITY_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'address':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_address($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_CITY_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'description':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_description($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_CITY_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'comment':
			{
				if(isset($input_value) && strlen($input_value)>0)
				{
					$bret= $this->validate_comment($input_value);
					if(false == $bret)
					{
						$default_error_message = E_VAL_CITY_CHECK_FAILED;
					}
				}
				break;
			}
			
			case 'usphone':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validate_usphone($input_value);
								if(false == $bret)
								{
									$default_error_message = E_VAL_EMAIL_CHECK_FAILED;
								}
							}
							break;
						}
						
			case "lt": 
			case "lessthan": 
						{
							$bret = $this->validate_lessthan($command_value,
													$input_value,
													$variable_name,
													$default_error_message);
							break;
						}
			case "gt": 
			case "greaterthan": 
						{
							$bret = $this->validate_greaterthan($command_value,
													$input_value,
													$variable_name,
													$default_error_message);
							break;
						}

			case "regexp":
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								if(!preg_match("$command_value",$input_value))
								{
									$bret=false;
									$default_error_message = sprintf(E_VAL_REGEXP_CHECK_FAILED,$variable_name);
								}
							}
							break;
						}
		  case "dontselect": 
		  case "dontselectchk":
          case "dontselectradio":
						{
							$bret = $this->validate_dontselect($input_value,
															   $command_value,
															   $default_error_message,
																$variable_name);
							 break;
						}//case

          case "shouldselchk":
          case "selectradio":
                      {
                            $bret = $this->validate_select($input_value,
							       $command_value,
							       $default_error_message,
								    $variable_name);
                            break;
                      }//case
		  case "selmin":
						{
							$min_count = intval($command_value);

							if(isset($input_value))
                            {
							    if($min_count > 1)
							    {
							        $bret = (count($input_value) >= $min_count )?true:false;
							    }
                                else
                                {
                                  $bret = true;
                                }
                            }
							else
							{
								$bret= false;
								$default_error_message = sprintf(E_VAL_SELMIN_CHECK_FAILED,$min_count,$variable_name);
							}

							break;
						}//case
		 case "selone":
						{
							if(false == isset($input_value)||
								strlen($input_value)<=0)
							{
								$bret= false;
								$default_error_message = sprintf(E_VAL_SELONE_CHECK_FAILED,$variable_name);
							}
							break;
						}
		 case "eqelmnt":
						{

							if(isset($formvariables[$command_value]) &&
							   strcmp($input_value,$formvariables[$command_value])==0 )
							{
								$bret=true;
							}
							else
							{
								$bret= false;
								$default_error_message = sprintf(E_VAL_EQELMNT_CHECK_FAILED,$variable_name,$command_value);
							}
						break;
						}
		  case "neelmnt":
						{
							if(isset($formvariables[$command_value]) &&
							   strcmp($input_value,$formvariables[$command_value]) !=0 )
							{
								$bret=true;
							}
							else
							{
								$bret= false;
								$default_error_message = sprintf(E_VAL_NEELMNT_CHECK_FAILED,$variable_name,$command_value);
							}
							break;
						}
		 
		}//switch
		return $bret;
	}//validdate command


}