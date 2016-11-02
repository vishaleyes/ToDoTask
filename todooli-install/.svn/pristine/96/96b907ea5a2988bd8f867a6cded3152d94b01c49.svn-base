<?php

// make sure browsers see this page as utf-8 encoded HTML
header('Content-Type: text/html; charset=utf-8');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;
$limit = 10;
$results = false;
$type=false;
$response_msg=false;
$response_color=false;

// The Apache Solr Client library should be on the include path
// which is usually most easily accomplished by placing in the
// same directory as this script ( . or current directory is a default
// php include path entry in the php.ini)
require_once('SolrUsers.php');

// create a new solr service instance - host, port, and webapp
// path (all defaults in this example)

$users = new Ludika_SolrUsers('localhost', 8983, '/solr/');


if ($action == "Add employer")
{
	$type = "employer";

	$employer_id = $_REQUEST['ei'];
	$employer_address = $_REQUEST['ea'];

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
    	$employer_id = stripslashes($_REQUEST['ei']);
		$employer_address = stripslashes($_REQUEST['ea']);
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if($users->addEmployer($employer_id, $employer_address)){
			$response_msg = "Added Employer [$employer_id]: [$employer_address]";
			$response_color = "";
		}
		else{
			$response_msg = "ERROR ADDING: Employer [$employer_id]: [$employer_address]";
			$response_color = "";
		}
	}
		catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>ADD EMPLOYER EXCEPTION ($employer_id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}

}

if ($action == "Add seeker")
{
	$type = "seeker";

	$seeker_id = $_REQUEST['si'];
	$seeker_address = $_REQUEST['sa'];
	$seeker_radius = $_REQUEST['sr'];


	//Gets the value of the checkboxes for occupation
	$occupation_value = getOccupation();		

	//Gets the value of the radio for payrange 
	if(!is_null($_REQUEST['payrange'])){
		$payrange_value = $_REQUEST['payrange'];
	}

	//Gets the value of the checkboxes for jobtype 
	$jobtype_value=getJobtype();

	//Gets the value of the checkboxes for workschedule
	$workschedule_value=getWorkschedule(); 


	//Gets the value of the checkboxes for language 
	$language_value=getLanguages();

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
		$seeker_id = stripslashes($_REQUEST['si']);
		$seeker_address = stripslashes($_REQUEST['sa']);
		$seeker_radius = stripslashes($_REQUEST['sr']);
		$occupation_value =stripslashes($occupation_value);
		$payrange_value =stripslashes($payrange_value);
		$jobtype_value =stripslashes($jobtype_value);
		$workschedule_value =stripslashes($workschedule_value);
		$language_value =stripslashes($language_value);
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if($users->addSeeker($seeker_id, $seeker_address, $seeker_radius, $occupation_value,$payrange_value,$jobtype_value,$workschedule_value,$language_value)){
			$response_msg = "Added Seeker [$seeker_id]: [$seeker_address]";
			$response_color = "";
		}
		else{
			$response_msg = "ERROR ADDING: Seeker [$seeker_id]: [$seeker_address]";
			$response_color = "";
		}
	}
	catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>ADD SEEKER EXCEPTION ($seeker_id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}

if ($action == "Add job")
{

	$type = "job";

	$job_id = $_REQUEST['ji'];
	$employer_mgr_id = $_REQUEST['jemi'];
	$account_mgr_id = $_REQUEST['jami'];
	$job_title = $_REQUEST['jt'];

	//Gets the value of the radio for payrange 
	if(!is_null($_REQUEST['payrange'])){
		$payrange = $_REQUEST['payrange'];
	}

	//Gets the value of the checkboxes for jobtype 
	$job_type=getJobtype();

	//Gets the value of the checkboxes for workschedule
	$workschedule=getWorkschedule();

	//Gets the value of the checkboxes for language 
	$languages=getLanguages();

	$age = $_REQUEST['jage'];
	$experience = $_REQUEST['je'];
	$special_text = $_REQUEST['jst'];
	$address = $_REQUEST['ja'];

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
		$job_id = stripslashes($_REQUEST['ji']);
		$employer_mgr_id = stripslashes($_REQUEST['jemi']);
		$account_mgr_id = stripslashes($_REQUEST['jami']);
		$job_title = stripslashes($_REQUEST['jt']);
		$payrange = stripslashes($payrange);
		$job_type = stripslashes($job_type);
		$workschedule = stripslashes($workschedule);
		$languages = stripslashes($languages);
		$age = stripslashes($_REQUEST['jage']);
		$experience = stripslashes($_REQUEST['je']);
		$special_text = stripslashes($_REQUEST['jst']);
		$address = stripslashes($_REQUEST['ja']);
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if($users->addJob($job_id, $employer_mgr_id, $account_mgr_id,
                                        $job_title, $payrange, $job_type, $workschedule,
                                        $languages, $age, $experience, $special_text,
                                        $address)){
			$response_msg = "Added Job [$job_id]: [$address]. Searching for Seekers in the area";
			$response_color = "";
			// Added the job, now look for seekers in the area
			//$type="seeker";
			//$results=$users->searchByAddress($type,$address,null,$limit);
		}
		else{
			$response_msg = "ERROR ADDING: Job [$job_id]: [$address]";
			$response_color = "";
		
		}

	}
	catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>ADD JOB EXCEPTION ($job_id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}

if ($action == "Modify employer")
{
	$type = "employer";

	$id = $_REQUEST['id'];
	$address = $_REQUEST['address'];

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
		$id = stripslashes($id);
		$address = stripslashes($address);
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if ($users->modifyEmployer($id, $address))
		{
			$response_msg = "Modified $type: [$id]: [$address]";
			$response_color = "";
		}
		else{
			$response_msg = "ERROR MODIFYING $type: [$id]: [$address]";
			$response_color = "";

		}
	}
	catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>MODIFY EMPLOYER EXCEPTION ($id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}

if ($action == "Modify seeker")
{
	$type = "seeker";

	$seeker_id = $_REQUEST['id'];
	$seeker_address = $_REQUEST['address'];
	$seeker_radius = $_REQUEST['radius'];

	//Gets the value of the checkboxes for occupation
	$occupation_value=getOccupation();
	
	//Gets the value of the radio for payrange 
	if(!is_null($_REQUEST['payrange'])){
		$payrange_value = $_REQUEST['payrange'];
	}

	//Gets the value of the checkboxes for jobtype 
	$jobtype_value=getJobtype();

	//Gets the value of the checkboxes for workschedule
	$workschedule_value=getWorkschedule();

	//Gets the value of the checkboxes for language 
	$language_value=getLanguages();

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
		$seeker_id = stripslashes($_REQUEST['id']);
		$seeker_address = stripslashes($_REQUEST['address']);
		$seeker_radius = stripslashes($_REQUEST['radius']);
		$occupation_value =stripslashes($occupation_value);
		$payrange_value =stripslashes($payrange_value);
		$jobtype_value =stripslashes($jobtype_value);
		$workschedule_value =stripslashes($workschedule_value);
		$language_value =stripslashes($language_value);
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if ($users->modifySeeker($seeker_id, $seeker_address, $seeker_radius,$occupation_value,$payrange_value,$jobtype_value,$workschedule_value,$language_value))
		{
			$response_msg = "Modified $type: [$seeker_id]: [$seeker_address] [$seeker_radius]";
			$response_color = "";
		}
		else{
			$response_msg = "ERROR MODIFYING $type: [$seeker_id]: [$seeker_address]";
			$response_color = "";
		}
	}
	catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>MODIFY SEEKER EXCEPTION ($seeker_id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}

if ($action == "Modify job")
{

	$type = "job";

	$job_id = $_REQUEST['id'];
	$employer_mgr_id = $_REQUEST['employer_mgr_id'];
	$account_mgr_id = $_REQUEST['acct_mgr_id'];
	$job_title = $_REQUEST['job_title'];

	//Gets the value of the radio for payrange 
	if(!is_null($_REQUEST['payrange'])){
		$payrange = $_REQUEST['payrange'];
	}

	//Gets the value of the checkboxes for jobtype 
	$job_type=getJobtype();

	//Gets the value of the checkboxes for workschedule
	$workschedule=getWorkschedule();

	//Gets the value of the checkboxes for language 
	$languages=getLanguages();

	$age = $_REQUEST['age'];
	$experience = $_REQUEST['experience'];
	$special_text = $_REQUEST['special_text'];
	$address = $_REQUEST['address'];

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
		$job_id = stripslashes($job_id);
		$employer_mgr_id = stripslashes($employer_mgr_id);
		$account_mgr_id = stripslashes($account_mgr_id);
		$job_title = stripslashes($job_title);
		$payrange = stripslashes($payrange);
		$job_type = stripslashes($job_type);
		$workschedule = stripslashes($workschedule);
		$languages = stripslashes($languages);
		$age = stripslashes($age);
		$experience = stripslashes($experience);
		$special_text = stripslashes($special_text);
		$address = stripslashes($address);;
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if($users->modifyJob($job_id, $employer_mgr_id, $account_mgr_id,
                                        $job_title, $payrange, $job_type, $workschedule,
                                        $languages, $age, $experience, $special_text,
                                        $address))
		{
			$response_msg = "Modified $type: [$job_id]: [$address]";
			$response_color = "";
		}
		else
		{
			$response_msg = "ERROR MODIFYING $type: [$job_id]: [$address]";
			$response_color = "";
		}

	}
	catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>MODIFY JOB EXCEPTION ($job_id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}


if ($action == "Delete employer" || $action == "Delete seeker" || $action == "Delete job")
{
	$type = $_REQUEST['type'];

	$id = $_REQUEST['id'];

	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
		$id = stripslashes($id);
	}

	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		if ($users->deleteById($type,$id))
		{
			$response_msg = "Deleted [$type]: [$id]";
			$response_color = "";
		}
	}
	catch (Exception $e)
	{
		// in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("<html><head><title>DELETE EXCEPTION ($type)($id) </title><body><pre>{$e->__toString()}</pre></body></html>");
	}
}

if ($action == "Search by Id")
{
	$type = $_REQUEST['type'];

	$id = $_REQUEST['q'];
	
	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1)
	{
	  $id = stripslashes($id);
	}
	
	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		$results = $users->searchById($type, $id, $limit);
	}
	catch (Exception $e)
	{
	  // in production you'd probably log or email this error to an admin
	      // and then show a special message to the user but for this example
	      // we're going to show the full exception
	      die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
	}
	
}

if ($action == "Search by Address")
{

        $type = $_REQUEST['type'];

        $address = $_REQUEST['q'];
        $radius = $_REQUEST['r'];
        $order = $_REQUEST['order'];


        // if magic quotes is enabled then stripslashes will be needed
        if (get_magic_quotes_gpc() == 1 && $address)
        {
                $address = stripslashes($address);
                $radius = stripslashes($radius);
                $order = stripslashes($order);
        }

        // in production code you'll always want to use a try /catch for any
        // possible exceptions emitted  by searching (i.e. connection
        // problems or a query parsing error)
        try
        {
                $results = $users->searchjobsInArea($address, $radius, $limit,$order);
        }
        catch (Exception $e)
        {
          // in production you'd probably log or email this error to an admin
              // and then show a special message to the user but for this example
              // we're going to show the full exception
              die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
        }

}

if ($action == "Search Seekers")
{

	$type = $_REQUEST['type'];

	$address = $_REQUEST['q'];
	$order = $_REQUEST['order'];

	// Gets all the parameters for filters
	$filters = array();

	//Gets the value of the checkboxes for occupation
	$occupation_filter_value=getOccupation();
	
	if(!is_null($occupation_filter_value)){
		$filters["occupation"] = $occupation_filter_value;
	}

	//Gets the value of the radio for payrange 
	$payrange = getPayrange(); 

	if(!is_null($payrange)){
		$filters["payrange"] = $payrange;
	}

	//Gets the value of the checkboxes for jobtype 
	$max_jobtype = 3;
	$i=1;
	$jobtype_filter_value=null;
	while($i <= $max_jobtype){
		if(!is_null($_REQUEST["jobtype$i"]))
		{
			$jobtype_filter_value .= is_null($jobtype_filter_value) ? $_REQUEST["jobtype$i"] : ",".$_REQUEST["jobtype$i"];
		}
		$i++;
	}
	if(!is_null($jobtype_filter_value)){
		$filters[] = array("jobtype" => "$jobtype_filter_value");
	}


	//Gets the value of the checkboxes for workschedule
	$max_workschedule = 6;
	$i=1;
	$workschedule_filter_value=null;
	while($i <= $max_workschedule){
		if(!is_null($_REQUEST["workschedule$i"]))
		{
			$workschedule_filter_value .= is_null($workschedule_filter_value) ? $_REQUEST["workschedule$i"] : ",".$_REQUEST["workschedule$i"];
		}
		$i++;
	}
	if(!is_null($workschedule_filter_value)){
		$filters[] = array("workschedule" => "$workschedule_filter_value");
	}

	//Gets the value of the checkboxes for language 
	$max_language = 3;
	$i=1;
	$language_filter_value=null;
	while($i <= $max_language){
		if(!is_null($_REQUEST["language$i"]))
		{
			$language_filter_value .= is_null($language_filter_value) ? $_REQUEST["language$i"] : ",".$_REQUEST["language$i"];
		}
		$i++;
	}
	if(!is_null($language_filter_value)){
		$filters[] = array("language" => "$language_filter_value");
	}

	
	// if magic quotes is enabled then stripslashes will be needed
	if (get_magic_quotes_gpc() == 1 && $address)
	{
		$address = stripslashes($address);
		$order = stripslashes($order);
		
	}
	
	// in production code you'll always want to use a try /catch for any
	// possible exceptions emitted  by searching (i.e. connection
	// problems or a query parsing error)
	try
	{
		// Not working properly yet
		$results = $users->searchSeekersAroundAddress($address, $limit,$order,$filters);
	}
	catch (Exception $e)
	{
	  // in production you'd probably log or email this error to an admin
	      // and then show a special message to the user but for this example
	      // we're going to show the full exception
	      die("<html><head><title>SEARCH EXCEPTION</title><body><pre>{$e->__toString()}</pre></body></html>");
	}
	
}

// Parses the _REQUEST to get the value of occupation
// returns an array with the lists
function getOccupation()
{
	$occupation_value= array();

	if(!is_null($_REQUEST["occupation"]))
	{
		$occupation_value=explode(",",$_REQUEST["occupation"]);
	}
	else
	{
		$max_occupation = 7;
		$i=1;
		while($i <= $max_occupation)
		{
			if(!is_null($_REQUEST["occupation$i"]))
			{
				array_push($occupation_value, $_REQUEST["occupation$i"]); 
			}
			$i++;
		}
	}
	return $occupation_value;	
}

function getJobtype()
{
	$jobtype_value=array ();

	if(!is_null($_REQUEST["jobtype"]))
	{
		$jobtype_value=explode(",",$_REQUEST["jobtype"]);
	}
	else
	{
		$max_jobtype = 3;
		$i=1;
		while($i <= $max_jobtype)
		{
			if(!is_null($_REQUEST["jobtype$i"]))
			{
				array_push($jobtype_value, $_REQUEST["jobtype$i"]);
			}
			$i++;
		}
	}
	return $jobtype_value;
}

function getWorkschedule()
{
	$workschedule_value= array();
	if(!is_null($_REQUEST["workschedule"]))
	{
		$jobtype_value=explode(",",$_REQUEST["workschedule"]);
	}
	else
	{
		$max_workschedule = 6;
		$i=1;
		while($i <= $max_workschedule)
		{
			if(!is_null($_REQUEST["workschedule$i"]))
			{
				array_push($workschedule_value,$_REQUEST["workschedule$i"]);
			}
			$i++;
		}
	}
	return $workschedule_value;
}

function getLanguages()
{
	$language_value=array();
	
	if(!is_null($_REQUEST["languages"]))
	{
		$jobtype_value=explode(",",$_REQUEST["workschedule"]);
	}
	else
	{
		$max_language = 3;
		$i=1;
		while($i <= $max_language)
		{
			if(!is_null($_REQUEST["language$i"]))
			{
				array_push($language_value,$_REQUEST["language$i"]);
			}
			$i++;
		}
	}
	return $language_value;
}

function getPayrange()
{
	$payrange=array();
	
	if(!is_null($_REQUEST["payrange"]))
	{
		$payrange=explode(",",$_REQUEST["payrange"]);
	}
	return $payrange;
}


?>
<html>
  <head>
    <title>Employer / Seeker API Example</title>
  </head>
  <body>
	<center>
	<table>
		<tr>
			<td>
				<form  accept-charset="utf-8" method="get">
				<table style="border: 1px solid black">
					<tr bgcolor=#FFDD77>
						<td colspan=2 align=center><b>Employer</b></td>
					</tr>
					<tr>
						<td> Employer Id: </td>
						<td align=center> <input id="ei" name="ei" type="text"/>
					</tr>
					<tr>
						<td> Address: </td>
						<td><input id="ea" name="ea" type="text"/></td>
					</tr>
					<tr>
						<td colspan=2 align=center>
						      <input type="submit" name='action' value="Add employer"/>
					</tr>
				</table>
				</form>
			</td>
			<td rowspan=2>		
				<form  accept-charset="utf-8" method="get">
				<table style="border: 1px solid black">
					<tr bgcolor=#FFDD77>
						<td colspan=2 align=center><b>Job</b></td>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td> Job Id: </td>
						<td> <input id="ji" name="ji" type="text"/>
					</tr>
					<tr>
						<td> Employer Mgr Id: </td>
						<td><input id="jemi" name="jemi" type="text"/></td>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td> Account Manager Id: </td>
						<td><input id="jami" name="jami" type="text"/></td>
					</tr>
					<tr>
						<td> Job Title: </td>
						<td><input id="jt" name="jt" type="text"/></td>
					</tr>
					<tr><td></td></tr>
					<tr bgcolor=#EEEEEE>
						<td>Payrange: </td>
						<td>
							<input id="payrange" name="payrange" value ="8" type="radio"/> $8/hour or above
							<input id="payrange" name="payrange" value ="9" type="radio"/> $9/hour or above<br>
							<input id="payrange" name="payrange" value ="10" type="radio"/> $10/hour or above
							<input id="payrange" name="payrange" value ="11" type="radio"/> $11/hour or above<br>
							<input id="payrange" name="payrange" value ="12" type="radio"/> $12/hour or above<br>
						</td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>Jobtype: </td>
						<td>
							<input id="jobtype1" name="jobtype1" value="fulltime" type="checkbox"/> Full Time
							<input id="jobtype2" name="jobtype2" value="parttime" type="checkbox"/> Part Time
							<input id="jobtype3" name="jobtype3" value="any" type="checkbox"/>  Any
		
						<td>
					</tr>
					<tr><td></td></tr>
					<tr bgcolor=#EEEEEE>
						<td>WorkSchedule: </td>
						<td>
							<input id="workschedule1" name="workschedule1" value="shift1" type="checkbox"/> Shift 1 
							<input id="workschedule2" name="workschedule2" value="shift2" type="checkbox"/> Shift 2 
							<input id="workschedule3" name="workschedule3" value="shift3" type="checkbox"/> Shift 3 <br>
							<input id="workschedule4" name="workschedule4" value="weekdays" type="checkbox"/> Weekdays 
							<input id="workschedule5" name="workschedule5" value="weekends" type="checkbox"/> Weekends 
							<input id="workschedule6" name="workschedule6" value="any" type="checkbox"/> Any 
		
						<td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>Language: </td>
						<td>
							<input id="language1" name="language1" value="english" type="checkbox"/> English 
							<input id="language2" name="language2" value="spanish" type="checkbox"/> Spanish 
							<input id="language3" name="language3" value="other" type="checkbox"/> Other 
		
						<td>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td> Age: </td>
						<td><input id="jage" name="jage" type="text"/></td>
					</tr>
					<tr>
						<td> Experience: </td>
						<td><input id="je" name="je" type="text"/></td>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td> Special Text: </td>
						<td><input id="jst" name="jst" type="text"/></td>
					</tr>
					<tr>
						<td> Address: </td>
						<td><input id="ja" name="ja" type="text"/></td>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td colspan=2 align=center>
						      <input type="submit" name='action' value="Add job"/>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td>		
				<form  accept-charset="utf-8" method="get">
				<table style="border: 1px solid black">
					<tr bgcolor=#FFDD77>
						<td colspan=2 align=center><b>Seeker</b></td>
					</tr>
					<tr>
						<td> Seeker Id: </td>
						<td><input id="si" name="si" type="text"/>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td> Address: </td>
						<td><input id="sa" name="sa" type="text"/></td>
					</tr>
					<tr>
						<td> Radius: </td>
						<td><input id="sr" name="sr" type="text"/></td>
					</tr>
					<tr bgcolor=#EEEEEE>
						<td>Occupation: </td>
						<td>
							<input id="occupation1" name="occupation1" value ="Salesperson" type="checkbox"/> Salesperson 
							<input id="occupation2" name="occupation2" value = "Cashier" type="checkbox"/> Cashier<br>
							<input id="occupation3" name="occupation3" value = "Stock Clerk/Order Filter" type="checkbox"/> Stock Clerk/Order Filter
							<input id="occupation4" name="occupation4" value = "Freight Materials Mover" type="checkbox"/> Freight Materials Mover<br>
							<input id="occupation5" name="occupation5" value = "1st Line Retail Supervisor" type="checkbox"/> 1st Line Retail Supervisor
							<input id="occupation6" name="occupation6" value = "General Store Laborer" type="checkbox"/> General Store Laborer<br>
							<input id="occupation7" name="occupation7" value = "any" type="checkbox"/> Any<br>
						</td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>Payrange: </td>
						<td>
							<input id="payrange" name="payrange" value ="8" type="radio"/> $8/hour or above
							<input id="payrange" name="payrange" value ="9" type="radio"/> $9/hour or above<br>
							<input id="payrange" name="payrange" value ="10" type="radio"/> $10/hour or above
							<input id="payrange" name="payrange" value ="11" type="radio"/> $11/hour or above<br>
							<input id="payrange" name="payrange" value ="12" type="radio"/> $12/hour or above<br>
						</td>
					</tr>
					<tr><td></td></tr>
					<tr bgcolor=#EEEEEE>
						<td>Jobtype: </td>
						<td>
							<input id="jobtype1" name="jobtype1" value="fulltime" type="checkbox"/> Full Time
							<input id="jobtype2" name="jobtype2" value="parttime" type="checkbox"/> Part Time
							<input id="jobtype3" name="jobtype3" value="any" type="checkbox"/>  Any
		
						<td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>WorkSchedule: </td>
						<td>
							<input id="workschedule1" name="workschedule1" value="shift1" type="checkbox"/> Shift 1 
							<input id="workschedule2" name="workschedule2" value="shift2" type="checkbox"/> Shift 2 
							<input id="workschedule3" name="workschedule3" value="shift3" type="checkbox"/> Shift 3 <br>
							<input id="workschedule4" name="workschedule4" value="weekdays" type="checkbox"/> Weekdays 
							<input id="workschedule5" name="workschedule5" value="weekends" type="checkbox"/> Weekends 
							<input id="workschedule6" name="workschedule6" value="any" type="checkbox"/> Any 
		
						<td>
					</tr>
					<tr><td></td></tr>
					<tr bgcolor=#EEEEEE>
						<td>Language: </td>
						<td>
							<input id="language1" name="language1" value="english" type="checkbox"/> English 
							<input id="language2" name="language2" value="spanish" type="checkbox"/> Spanish 
							<input id="language3" name="language3" value="other" type="checkbox"/> Other 
		
						<td>
					</tr>
					<tr>
						<td colspan=2 align=center>
						      <input type="submit" name='action' value="Add seeker"/>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	<br>
	<br>
	
	<form  accept-charset="utf-8" method="get">
	<table style="border: 1px solid black">
		<tr>
			<td align=center bgcolor=#CCFF00><b>Search<b></td>
		</tr>
		<tr>
			<td bgcolor=#EEEEEE>
				  <input id="type" name="type" type=radio value="employer"/>Employer
				  <input id="type" name="type" type=radio value="seeker" checked/> Seeker
				  <input id="type" name="type" type=radio value="job"/> Job
			
			<td>
		</tr>
		<tr>
		<tr>
			<td bgcolor=#EEEEEE>
			      <label for="q">Id:</label>
			      <input id="q" name="q" type="text"/>
			      <input type="submit" name='action' value="Search by Id"/>
			</td>
		</tr>
	</table>
	</form>
	<form  accept-charset="utf-8" method="get">
	<table style="border: 1px solid black">
		<tr>
			<td align=center bgcolor=#CCFF00><b>Search<b></td>
		</tr>
		<tr>
			<td bgcolor=#EEEEEE>
				Jobs withinin <input id="r" name="r" size=2 type="text"/> miles around <input id="q" name="q" type="text"/><br>
			      <label for="order">Sort:</label>
				  <input id="order" name="order" type=radio value="asc" checked/>Ascending
				  <input id="order" name="order" type=radio value="desc"/>Descending
			</td>
		</tr>
		<tr>
			<td align=center>
				<input type=hidden id="type" name='type' value="job"/>
			      <input type="submit" name='action' value="Search by Address"/>
			</td>
		</tr>
	</table>
	</form>
	<form  accept-charset="utf-8" method="get">
	<table style="border: 1px solid black">
		<tr>
			<td align=center bgcolor=#CCFF00><b>Search<b></td>
		</tr>
		<tr>
			<td bgcolor=#EEEEEE>
				Seekers around <input id="q" name="q" type="text"/>
			</td>
		</tr>
		<tr>
			<td align=center bgcolor=#CCFF01> Extra filters (optional)</td>
		</tr>
		<tr>
			<td bgcolor=#EEEEEE>
				<table border=0>
					<tr>
						<td>Occupation: </td>
						<td>
							<input id="occupation1" name="occupation1" value ="Salesperson" type="checkbox"/> Salesperson 
							<input id="occupation2" name="occupation2" value = "Cashier" type="checkbox"/> Cashier<br>
							<input id="occupation3" name="occupation3" value = "Stock Clerk/Order Filter" type="checkbox"/> Stock Clerk/Order Filter
							<input id="occupation4" name="occupation4" value = "Freight Materials Mover" type="checkbox"/> Freight Materials Mover<br>
							<input id="occupation5" name="occupation5" value = "1st Line Retail Supervisor" type="checkbox"/> 1st Line Retail Supervisor
							<input id="occupation6" name="occupation6" value = "General Store Laborer" type="checkbox"/> General Store Laborer<br>
							<input id="occupation7" name="occupation7" value = "any" type="checkbox"/> Any<br>
						</td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>Payrange: </td>
						<td>
							<input id="payrange" name="payrange" value ="8" type="radio"/> $8/hour or above
							<input id="payrange" name="payrange" value ="9" type="radio"/> $9/hour or above<br>
							<input id="payrange" name="payrange" value ="10" type="radio"/> $10/hour or above
							<input id="payrange" name="payrange" value ="11" type="radio"/> $11/hour or above<br>
							<input id="payrange" name="payrange" value ="12" type="radio"/> $12/hour or above<br>
						</td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>Jobtype: </td>
						<td>
							<input id="jobtype1" name="jobtype1" value="fulltime" type="checkbox"/> Full Time
							<input id="jobtype2" name="jobtype2" value="parttime" type="checkbox"/> Part Time
							<input id="jobtype3" name="jobtype3" value="any" type="checkbox"/>  Any
		
						<td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>WorkSchedule: </td>
						<td>
							<input id="workschedule1" name="workschedule1" value="shift1" type="checkbox"/> Shift 1 
							<input id="workschedule2" name="workschedule2" value="shift2" type="checkbox"/> Shift 2 
							<input id="workschedule3" name="workschedule3" value="shift3" type="checkbox"/> Shift 3 <br>
							<input id="workschedule4" name="workschedule4" value="weekdays" type="checkbox"/> Weekdays 
							<input id="workschedule5" name="workschedule5" value="weekends" type="checkbox"/> Weekends 
							<input id="workschedule6" name="workschedule6" value="any" type="checkbox"/> Any 
		
						<td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td>Language: </td>
						<td>
							<input id="language1" name="language1" value="english" type="checkbox"/> English 
							<input id="language2" name="language2" value="spanish" type="checkbox"/> Spanish 
							<input id="language3" name="language3" value="other" type="checkbox"/> Other 
		
						<td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>
			      <label for="order">Sort:</label>
				  <input id="order" name="order" type=radio value="asc" checked/>Ascending
				  <input id="order" name="order" type=radio value="desc"/>Descending
			</td>
		</tr>
		<tr>
			<td align=center>
				<input type=hidden id="type" name='type' value="seeker"/>
			      <input type="submit" name='action' value="Search Seekers"/>
			</td
		</tr>
	</table>
	</form>
	<pre><?php echo htmlspecialchars($response_msg, ENT_QUOTES, 'utf-8'); ?></pre>
<?php

// display results
if ($results)
{
  $total = (int) $results->response->numFound;
  $start = min(1, $total);
  $end = min($limit, $total);
?>
    <div>Results <?php echo $start; ?> - <?php echo $end;?> of <?php echo $total; ?>:</div>
    <ol>
<?php
  // iterate result documents
  foreach ($results->response->docs as $doc)
  {
?>
      <li>
	<form  accept-charset="utf-8" method="get">
        <table style="border: 1px solid black; text-align: left">
<?php
    // iterate document fields / values
    foreach ($doc as $field => $value)
    {
	// if the response is an array, pass it to a comma separated string
	if(is_array($value)){
		$value=implode(',',$value);
	}
?>
          <tr>
            <th><?php echo htmlspecialchars($field, ENT_NOQUOTES, 'utf-8'); ?></th>
            <td><input id=<?php echo htmlspecialchars($field, ENT_QUOTES, 'utf-8'); ?> name=<?php echo htmlspecialchars($field, ENT_QUOTES, 'utf-8'); ?> type=text value="<?php echo htmlspecialchars($value, ENT_NOQUOTES, 'utf-8'); ?>" /></td>
          </tr>
<?php
    }
?>
	  <tr>	
	    <td align=center>
			<input type=hidden id="type" name='type' value="<?php echo htmlspecialchars($type, ENT_QUOTES, 'utf-8'); ?>"/>
			<input type="submit" name='action' value="Delete <?php echo htmlspecialchars($type, ENT_QUOTES, 'utf-8'); ?>"/> <input type="submit" name='action' value="Modify <?php echo htmlspecialchars($type, ENT_QUOTES, 'utf-8'); ?>"/>
		</td>
	   </tr>
        </table>
	</form>
      </li>
<?php
  }
?>
    </ol>
<?php
}
?>
	</center>
  </body>
</html>
