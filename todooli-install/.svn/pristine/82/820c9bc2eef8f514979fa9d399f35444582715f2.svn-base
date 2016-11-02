<?php

/*
 Apache solr search library

. Ludika Tech

Installation And dependencies
=============================
	
	This library dependes on Apache Solr methods to work, so the SolrUsers.php file containing
	the class needs to be deployed under the SolrPhpClient directory contained in the 
	apache-solr package. 

	It alse requires php curl to work properly in order to do the http request to the 
	google maps api


Solr Indexes
============
	
	The library works with 3 solr indexes that should be created under the solr instance
	The indexes 'employers', 'seekers', and 'jobs', they access path through the solr webapp
	should be ;/solr/employers/' and '/solr/seekers/' and '/solr/jobs/';

	Schema xml files for each one of the indexes should come with this library



Public Methods
===============


. public function addEmployer ($employer_id, $address, $commit=true)

	Adds an employer to the employers index
	The optional commit argument is useful for batch updates, when its false the record 
	will be added but won't show up in the index searches until a later invocation of 
	a function with commit=true

	An error is logged in the php default error log (ie, apache logs, stdout) if result is false

	@param string $employer_id
	@param string $address . String with the address, can also be a string with "lat,long" values
	@param bool commit (optional, default true) commits in the index after completion

	@return bool


. public function addSeeker ($seeker_id, $address, $radius, $occupation, $payrange, $jobtype, $workschedule, $language, $commit=true)

	Adds a seeker to the seekers index 
	An error is logged in the php default error log (ie, apache logs, stdout) if result is false

	@param string $seeker_id
	@param string $address	String with the address, can also be a string with "lat,long" values
	@param string radius
	@param array occupation. An array with all the occupations for this seeker. ie ('Salesperson', 'Cashier')  
	@param string payrange
	@param array jobtype . An array with all the jobtypes this seeker has. ie: ('fulltime', 'partime')
	@param array workschedule . ie ('shift1', 'weekdays')
	@param array languages 
	@param bool commit (optional, default true) commits in the index after completion
	
	@return bool


. public function addJob ($job_id, $employer_mgr_id, $acct_mgr_id, $job_title, $payrange, $jobtype, $workschedule, $languages, $age, $experience, $specialtext, $address, $commit=true)

	Adds a job to the jobs index 

	An error is logged in the php default error log (ie, apache logs, stdout) if result is false
	
	@param string $job_id
	@param string $employer_mgr_id
	@param string $acct_mgr_id
	@param string $job_title
	@param string $payrange
	@param array $jobtype	ie: ('parttime')
	@param array $workschedule ie: ('weekdays', 'any')
	@param array $languages ie ('english')
	@param string $age
	@param string $experience
	@param string $specialtext
	@param string $address String with the address, can also be a string with "lat,long" values
	@param bool commit (optional, default true) commits in the index after completion
	
	@return bool
	 

. public function modifyEmployer ($employer_id, $address, $commit=true)
. public function modifySeeker($seeker_id, $address, $radius,$occupation, $payrange, $jobtype, $workschedule, $language, $commit=true)
. public function modifyJob ($job_id, $employer_mgr_id, $acct_mgr_id, $job_title, $payrange, $jobtype, $workschedule, $languages, $age, $experience, $specialtext, $address, $commit=true)

	Modifier functions for employer, seekers, and jobs. They take the same arguments as their counterparts for adding the record. 
	If the desired record doesn exists in the index, the return value is 'false'
	An error is logged in the php default error log (ie, apache logs, stdout) if result is false


. public function deleteById ($core, $id, $commit=true)

	General delete function.
	Deletes a record in the desired core, searching it by id.
	An error is logged in the php default error log (ie, apache logs, stdout) if result is false

	BEWARE: if id='*' all the records in the index are removed!

	@param core string (one of: employer,seeker, job). Selects the core to work with
	@param id string . Id to delete in the selected core
	@param commit bool. When true (default) the record is immediately removed from the index
	@returns bool


.public function deleteEmployer ($id,$commit=true)
.public function deleteSeeker ($id, $commit=true)
.public function deleteJob ($id, $commit=true)

	Delete functions by id. These are a wrapper of deleteById, so we don't need to specify the core.
	An error is logged in the php default error log (ie, apache logs, stdout) if result is false

	@param id string. Id to delete
	@param commit bool

	@return bool


.public function searchById($core, $id,$limit=1)

	Searches a record in the cores by id

	@param core string (one of: employer, seeker, job)
	@param id string . The id we are looking for. if this is '*' all the records up to the limit are returned
	@param limit string. Ammount of records to return.

	@returns a Apache_Solr_Response or null if error

	If response is null, an error will be logged in the php default error log.
	

. public function searchJobsInArea ($address, $radius, $limit, $order = 'asc')

	Given an address and a radius returns all jobs in that area
	 
	@param address string
	@param radius string
	@param limit maximum number of results to return
	@param order (asc, desc): sorting order for the resultset, based on distance from the address

	@returns Apache_Solr_Result or null in case of problems

	If response is null, an error will be logged in the php default error log.

. public function searchSeekersAroundAddress ($address, $limit, $order = 'asc', $filters=null)

	Given an address looks for all the seekers whose area covers this address 

	@param address string
	@param limit maximum number of results to return
	@param order (asc, desc): sorting order for the resultset, based on distance from the address
	@param filters @array with key => value pairs for filtering. The values are also arrays, as the filter can be multivalued.
		ie: ("occupation" => ("Cashier", "Salesperson"), "payrange" => ("8"), "jobtype" => ("Full-time"), "workschedule" => ("Shift1", "Weekdays"), "languages" => ("en","sp"));

	@returns Apache_Solr_Result or null in case of problems

	If response is null, an error will be logged in the php default error log.


. public function getGeoCode($address)

	Gets lat and long for a given address. This calls the google maps api wich is free,
	but is limited to 2500 hits per day

	@param address string
	@return latlong string (<lat>,<long) or null in case of problems

	If response is null, an error will be logged in the php default error log.
*/








require_once('Apache/Solr/Service.php');

class Ludika_SolrUsers 
{
	protected $_esolr;
	protected $_ssolr;
	protected $_jsolr;
	protected $_epath = '/solr/employers/';
	protected $_spath = '/solr/seekers/';
	protected $_jpath = '/solr/jobs/';
	protected $_maps_url = "http://maps.googleapis.com/maps/api/geocode/";
	protected $_seeker_max_radius = 100;


	/*
	 * Constructor
	 * @param host string = hostname of the solr server (default localhost)
	 * @param port string = port where the solr servide is listening (default 8933)
	 * @param path string = path to solr index files (default /solr/
	 */

	public function __construct($host = 'localhost', $port = 8983, $path = '/solr/')
	{
		$this->_esolr = new Apache_Solr_Service($host, $port, $this->_epath);
		$this->_ssolr = new Apache_Solr_Service($host, $port, $this->_spath);
		$this->_jsolr = new Apache_Solr_Service($host, $port, $this->_jpath);
	}

	/***************************************************************
	 *
	 * API functions to add employers, seekers, and searching
	 *
	 * In all of them, if the 'commit' argument is false the document
	 * will be added but won't show up in the index until a later 
	 * invocation of a function with commit=true. 
	 * This is usefull to perform several batch inserts in bulk so
	 * we don't choke the index performance.
         *
	 **************************************************************/


	/*
	 * Adds an employer
	 * @param string $employer_id
	 * @param string $address
	 * @param bool commit (optional, default true) commits in the index after completion
	 * The commit argument is useful for batch updates
	 * @return bool
	 */
	public function addEmployer ($employer_id, $address, $commit=true)
	{
		$solr = $this->_esolr;
		
		$latlong = $this->getGeocode($address);
		if(is_null($latlong)){
			trigger_error("Couldn't get geolocation for address [$address]");
			return false;
		}

		if ($solr->ping())
		{
			$document = new Apache_Solr_Document();
			$document->id = $employer_id;
			$document->address = $latlong;

			$solr->addDocument($document);
			if($commit){	
	 	                $solr->commit(); //commit to see the deletes and the document
				$solr->optimize(); //merges multiple segments into one
			}
		}
		else {
			trigger_error("Connection to employer solr index failed");
			return false;
		}
		return true;
	}

	/*
	 * Adds a seeker 
	 * @param string $seeker_id
	 * @param string $address
	 * @param string radius
	 * @param array occupation 
	 * @param string payrange
	 * @param array jobtype 
	 * @param array workschedule
	 * @param array languages 
	 * @param bool commit (optional, default true) commits in the index after completion
	 * The commit argument is useful for batch updates
	 * @return bool
	 */
	public function addSeeker ($seeker_id, $address, $radius, $occupation, $payrange, $jobtype, $workschedule, $language, $commit=true)
	{
		$solr = $this->_ssolr;

		$latlong = $this->getGeocode($address);
		if(is_null($latlong)){
			trigger_error("Couldn't get geolocation for address [$address]");
			return false;
		}

		if ($solr->ping())
		{
			$document = new Apache_Solr_Document();
			$document->id = $seeker_id; 
			$document->address = $latlong;
			$document->radius = $radius;
			$document->payrange = $payrange;
			
			// Adds the array values to the document, each value in a different multivalued
			// field
			$document = $this->multiAdd($document, "occupation", $occupation);
			$document = $this->multiAdd($document, "jobtype", $jobtype);
			$document = $this->multiAdd($document, "workschedule", $workschedule);
			$document = $this->multiAdd($document, "languages", $language);
			
			$solr->addDocument($document);

			if($commit){
	 	                $solr->commit(); //commit to see the deletes and the document
				$solr->optimize(); //merges multiple segments into one
			}
		}
		else{
			trigger_error("Connection to seeker solr index failed");
			return false;
		}
		return true;
	}

	/*
	 * Adds a job 
	 * @param string $job_id
	 * @param string $employer_mgr_id
	 * @param string $acct_mgr_id
	 * @param string $job_title
	 * @param string $payrange
	 * @param string $jobtype
	 * @param string $workschedule
	 * @param string $languages
	 * @param string $age
	 * @param string $experience
	 * @param string $specialtext
	 * @param string $address
	 * @param bool commit (optional, default true) commits in the index after completion
	 * @return bool
	 */
	public function addJob ($job_id, $employer_mgr_id, $acct_mgr_id, 
					$job_title, $payrange, $jobtype, $workschedule,
                                        $languages, $age, $experience, $specialtext, 
					$address, $commit=true)
	{
		$solr = $this->_jsolr;

		$latlong = $this->getGeocode($address);
		if(is_null($latlong)){
			trigger_error("Couldn't get geolocation fro address [$address]");
			return false;
		}

		if ($solr->ping())
		{
			$document = new Apache_Solr_Document();
			$document->id 			= $job_id;
			$document->employer_mgr_id 	= $employer_mgr_id;
			$document->acct_mgr_id 		= $acct_mgr_id;
			$document->job_title 		= $job_title;
			$document->payrange 		= $payrange;
			$document->age		        = $age;
			$document->experience	        = $experience;
			$document->special_text	        = $specialtext;
			$document->address	        = $latlong;

			// Adds the array values to the document, each value in a different multivalued
			// field

			$document = $this->multiAdd($document, "jobtype", $jobtype);
			$document = $this->multiAdd($document, "workschedule", $workschedule);
			$document = $this->multiAdd($document, "languages", $language);

			$solr->addDocument($document);
			
			if($commit){
	 	                $solr->commit(); //commit to see the deletes and the document
				$solr->optimize(); //merges multiple segments into one
			}
		}
		else{
			trigger_error("Connection to job solr index failed");
			return false;
		}
		return true;
	}
	
	/*
	 * Modifiers for all of the above
	 */

	/**
	 * 
	 * Modifies a document entry for an employer 
	 * Every field in the document except the id reassigned and resubmitted
	 * return bool
	 */
	public function modifyEmployer ($employer_id, $address, $commit=true)
	{
		$solr = $this->_esolr;


		// Search the index entry for the employer, return an error if it doesn't
		// exists
		$result = $this->searchById("employer", $employer_id);
		if( (int) $result->response->numFound == 0 ){
			trigger_error("Couldn't find an entry for employer [$employer_id]");
			return false;
		}

		return $this->addEmployer ($employer_id, $address, $commit);
	}

	/**
	 * 
	 * Modifies a document entry for a seeker. Every field except the id
	 * is resubmitted
	 * return bool
	 */

	public function modifySeeker($seeker_id, $address, $radius,$occupation, $payrange, $jobtype, $workschedule, $language, $commit=true)
	{
		$solr = $this->_ssolr;

		// Search the index entry for the seeker, return an error if it doesn't
		// exists
		$result = $this->searchById("seeker", $seeker_id);
		if( (int) $result->response->numFound == 0 ){
			trigger_error("Couldn't find an entry for seeker [$seeker_id]");
			return false;
		}

		return $this->addSeeker($seeker_id, $address, $radius,$occupation, $payrange, $jobtype, $workschedule, $language, $commit);
	}

	/**
	 * 
	 * Modifies a document entry for a job. Every field except the id
	 * is resubmitted
	 * return bool
	 */
	public function modifyJob ($job_id, $employer_mgr_id, $acct_mgr_id, 
					$job_title, $payrange, $jobtype, $workschedule,
                                        $languages, $age, $experience, $specialtext, 
					$address, $commit=true)
	{
		$solr = $this->_jsolr;

		// Search the index entry for the job, return an error if it doesn't
		// exists
		$result = $this->searchById("job", $job_id);
		if( (int) $result->response->numFound == 0 ){
			trigger_error("Couldn't find an entry for job [$job_id]");
			return false;
		}

		return $this->addJob ($job_id, $employer_mgr_id, $acct_mgr_id, 
					$job_title, $payrange, $jobtype, $workschedule,
                                        $languages, $age, $experience, $specialtext, 
					$address, $commit);
	}

	/*
	 * Delete functions by id. These are a wrapper of deleteById 
	 * @param id string. Id to delete
	 * @param commit bool
	 * return bool
	 */
	public function deleteEmployer ($id,$commit=true)
	{
		return $this->deleteById('employer', $id, $commit);
	}

	public function deleteSeeker ($id, $commit=true)
	{
		return $this->deleteById('seeker', $id, $commit);
	}

	public function deleteJob ($id, $commit=true)
	{
		return $this->deleteById('job', $id, $commit);
	}


	/*
	 * General delete function.
	 * @param core string (one of: employer,seeker, job). Selects the core to work with
	 * @param id string . Id to delete in the selected core
	 * @param commit bool. When true (default) the record is immediately removed from the index
	 * returns bool
	 */
	public function deleteById ($core, $id, $commit=true)
	{
		if($core == "employer")
		{
			$solr = $this->_esolr;
		}
		elseif($core == "seeker")
		{
			$solr = $this->_ssolr;
		}
		elseif($core == "job")
		{
			$solr= $this->_jsolr;
		}
		else
		{
			trigger_error("Invalid core in search by id:[$core] (must be one of employer, seeker, job)");
			return false;
		}

		$response = $solr->deleteById($id);
		
		if ($response->getHttpStatus() != 200){
			trigger_error("Couldn't delete index entry [$core] [$id] ".$response->getHttpStatusMessage());
			return false;
		}
		
		// Commits changes so the delete gets applied
		if($commit){
	 	        $solr->commit();
			$solr->optimize();
		}

		return true;
	}

	/*
	 *  Searches a record in the cores by id
	 * @param core string (one of: employer, seeker, job)
	 * @param id string . if this is '*' all the records up to the limit are returned
	 * @param limit string. Ammount of records to return.
	 * returns a Apache_Solr_Response or null if error
	 */
	public function searchById($core, $id,$limit=1){
		if($core == "employer")
		{
			$solr = $this->_esolr;
		}
		elseif($core == "seeker")
		{
			$solr = $this->_ssolr;
		}
		elseif($core == "job")
		{
			$solr = $this->_jsolr;
		}
		else
		{
			trigger_error("Invalid core in search by id:[$core] (must be one of employer, seeker, job)");
			return null;
		}
		
		//if asked the full list of ids, we need to modify the search limit
		if($id == "*" && $limit == 1){
			$limit= null;
		}

		return $solr->search("id:$id",0,$limit);
	}


	/*
	 * Given an address and a radius returns all jobs in that area
	 *
	 * @param address string
	 * @param radius string
	 * @param limit maximum number of results to return
	 * @param order (asc, desc): sorting order for the resultset, based on distance from the address
	 * 
	 * @returns Apache_Solr_Result or null in case of problems
	 */
	public function searchJobsInArea ($address, $radius, $limit, $order = 'asc')
	{
		$solr= $this->_jsolr;
		$latlong = null;
		// If the address is not geocoded we need to convert it.
		if(preg_match("/\d+\.\d+,-?\d+\d+/", $address) == 0) {	
			$latlong = $this->getGeocode($address);
			if(is_null($latlong)){
				trigger_error("Couldn't get geolocation for address [$address]");
				return null;
			}
		} else {
			$latlong = $address;
		}

		$additionalParameters = array( "sort" => "geodist($latlong,address) $order", "fq" => "{!geofilt pt=$latlong sfield=address d=$radius}");
		$query = "id:*";

		return $solr->search("$query", 0, $limit, $additionalParameters);
	}

	/*
	 * Given an address looks for all the seekers whose area covers this address 
	 *
	 * Due to some limitations in the spacial search in this solr version, the function creates
	 * a search area and then filters within that area all the seekers whose radius covers that address
	 * 
	 * @param address string
	 * @param limit maximum number of results to return
	 * @param order (asc, desc): sorting order for the resultset, based on distance from the address
	 * @param filters @array with key => value pairs for filtering  
	 *   ie: ("occupation" => "Cashier", "payrange" => "8+", "jobtype" => "Full-time", "workschedule" => "Shift1", "languages" => "en,sp");
	 * 
	 * @returns Apache_Solr_Result or null in case of problems
	 */
	public function searchSeekersAroundAddress ($address, $limit, $order = 'asc', $filters=null)
	{
		$solr= $this->_ssolr;
		$latlong = null;
		$filters = null;
		// If the address is not geocoded we need to convert it.
		if(preg_match("/\d+\.\d+,-?\d+\d+/", $address) == 0)
		{	
			$latlong = $this->getGeocode($address);
			if(is_null($latlong)){
				trigger_error("Couldn't get geolocation for address [$address]");
				return null;
			}
		}
		else
		{
			$latlong = $address;
		}

		$filter_query=null;
		$fq_initialized=false;
		// Constructs a filter query to get the records that match occupation, payrange, etc
		// need to boost some of these
		if(! is_null($filters) )
		{
			foreach ($filters as $key => $array_values)
			{
				$filter = null;
				$filter_initialized=false;
				
				foreach ($array_values as $value)
				{
					$keyval = "$key:$value";
					if($key == "payrange"){
						$keyval = "$key:[$value TO *]";
					}
					if($filter_initialized)
					{
						$filter .= " OR $keyval";
					}
					else
					{
						$filter .= "$keyval";
						$filter_initialized =true;
					}
				}

				if($key == "occupation" && !is_null($filter))
				{
					$filter .= " OR occupation:any";
				}
				elseif($key =="workschedule" && !is_null($filter))
				{
					$filter .= " OR workschedule:any";
				}
				elseif($key == "jobtype" && ! is_null($filter)){
					$filter .= " OR jobtype:any";
				}
				
				if(!is_null($filter))
				{
					if($fq_initialized)
					{
						//$filter_query .= " AND ($filter)";
						$filter_query .= " OR ($filter)";
					}
					else{
						$filter_query .= "$filter";
						$fq_initialized=true;
					}
				}
			}	
		}		

		// Looks for al seekers in a job radius area, sorted by distance to the address 
		//$additionalParameters = array( "sort" => "geodist($latlong,address) $order", "fq" => "(radius:[{!func _val_:score} TO $this->_seeker_max_radius ]) AND _query_:\"{!geofilt pt=$latlong sfield=address d=$this->_seeker_max_radius}\"", "fl" => "id,address,radius,score");

		// Query field with boosting argument
		$qf = "score^100 occupation^10 jobtype^9 payrange^8 workschedule^7 language^6";


		if(is_null($filter_query))
		{
			$additionalParameters = array( "sort" => "geodist($latlong,lnglat) $order", "fq" => "{!geofilt pt=$latlong sfield=lnglat d=$this->_seeker_max_radius}", "fl" => "*,score");
		}
		else
		{
			$additionalParameters = array( "sort" => "geodist($latlong,lnglat) $order", "fq" => "($filter_query) AND _query_:\"{!geofilt pt=$latlong sfield=lnglat d=$this->_seeker_max_radius}\"", "fl" => "*,score", "qf" => "$qf");
			
		}
		$query = "{!func}geodist($latlong,lnglat)";

		error_log("INFO $query");	
		$results = $solr->search("$query", 0, $limit, $additionalParameters);
		$total = (int) $results->response->numFound;
		if($total == 0){
			return $results;
		}

		$documents = array();
		$numFound = 0;

		foreach ($results->response->docs as $doc)
		{
			$id	=	$doc->__get("id");
			$radius = 	$doc->__get("radius");
			$dist	=	$doc->__get("score");
			if( $dist < $radius){
				$numFound++;
				$documents[] = $doc;
			}
//			else{
//				trigger_error("Dist [$dist] for id [$id] is out of range [$radius]");
//			}
		}
		$results->response->numFound = $numFound;
		$results->response->docs = $documents;
		
		return $results;

	}

	/*
	 * Gets lat and long for a given address. This calls the google maps api wich is free,
	 * but is limited to 2500 hits per day
	 * @param address string
	 * @return latlong string (<lat>,<long) or null in case of problems
	*/	
	public function getGeoCode($address)
	{
	
		if(preg_match("/\d+\.\d+,-?\d+\d+/", $address) == 1)
		{	
			$latlong = $address;
			return $latlong;
		}
	
		$request_url = $this->_maps_url . "xml?sensor=false&address=" . urlencode($address);
		$latlong = null;

		$response = $this->url_get("$request_url");

		if(!$response){
			trigger_error("Couldn't load maps url [$request_url]");
			return null;
		}

		$xml = simplexml_load_string($response);
		if(!$xml){
			trigger_error("Google Maps api response is not a well formed xml [$response]");
			return null;
		}

		$status = (string) $xml->status;

		if (strcmp($status, "OK") == 0) {
      			// Successful geocode
      			$lat = $xml->result->geometry->location->lat;
      			$lng = $xml->result->geometry->location->lng;
			$latlong="$lat,$lng";
		}
		else{
			trigger_error("Google maps api error [$status]");
			return null;
		}
		return $latlong; 
	}

	/*
	 * Implements an http request.
	*/
	public function url_get($url)
	{
		$crl = curl_init();
		$timeout = 15;
		curl_setopt ($crl, CURLOPT_URL,$url);
		curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
		$ret = curl_exec($crl);
		$result = curl_multi_getcontent  ( $crl );
		$err = curl_error($crl);
		if($err){
			trigger_error("get_url error [$err]");
		}
		curl_close($crl);
 		return $result;
	}


	/*
	 * Adds an array into multivalued fields in a document. Each value goes in a new field
	 * 
	 * @param Apache_Solr_Document document
	 * @param string field
	 * @param array values
	*/
	public function multiAdd($document, $field, $values)
	{
		foreach ($values as $val)
		{
			$document->addField($field,$val);	
		}
		return $document;
	}

}
