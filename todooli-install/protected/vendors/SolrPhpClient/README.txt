
LudikaSolUsers PHP Library

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
