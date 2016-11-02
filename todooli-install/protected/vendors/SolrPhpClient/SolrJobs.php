<?php

require_once('Apache/Solr/Service.php');
class SolrJobs 
{
	protected $_jsolr;
	protected $_jpath = '/solr/jobs/';

	/*
	 * Constructor
	 * @param host string = hostname of the solr server (default localhost)
	 * @param port string = port where the solr servide is listening (default 8933)
	 * @param path string = path to solr index files (default /solr/
	 */

	public function __construct($host = 'localhost', $port = 8983, $path = '/solr/')
	{
		if (USE_SOLR == 'false') {
			return;
		}
		try {
		$this->_jsolr = new Apache_Solr_Service($host, $port, $this->_jpath);
		} catch (Exception $e) {
			$this->_jsolr = null;
		}
	}

	/*
	 *
	 * @example: get_jobs_from_solr(
	 * function get_jobs_from_solr($latlng, $radius, $limit, $order = 'asc')
	 *
	 */
	function searchJobs($latlng, $radius, $limit, $order = 'asc', $filter = null)
	{
		if (USE_SOLR == 'false') {
			return false;
		}
		$solr= $this->_jsolr;
        if ( $solr == null ) {
           return false;
        }
        if ( ! $solr->ping() ) {
           return false;
        }
		error_log("INFO SOLR searchJobs: latlng".$latlng." radius: ".$radius);
		$additionalParameters = array( "sort" => "geodist($latlng,latlng) $order", "fq" => "{!geofilt pt=$latlng sfield=latlng d=$radius}");
		$query = "id:*";

		return $solr->search("$query", 0, $limit, $additionalParameters);
	}
	
	/*
	 *
	 * @example: this function is used to add jobs 2 solr
	 * addJob('211113', '3', '4', '4', '22', '1', '5', Array, Array, Array, Array, Array, '37.3895297,-122...', true) 
     *
	 */
	function addJob (
					$job_id, 
					$job_db_id, 
					$employer_id, 
					$acct_mgr_id, 
					$age, 			// not array
					$experience, 	// not array
					$occupation, 	// not array
					$payrange, 		// array
					$jobtype, 		// array
					$workschedule,	// array
					$shift,			// array
                    $languages, 	// array
					$latlng, 		// not array
					$commit=true)
	{
		$solr = $this->_jsolr;

		if (USE_SOLR == 'false') {
			return false;
		}

        if ( $solr == null ) {
           return false;
        }

		error_log("INFO SOLR addJobs: id".$job_id." occupation: ".$occupation);
		if ($solr->ping())
		{
			$document = new Apache_Solr_Document();
			$document->id 				= $job_id;
			$document->id_int 			= $job_db_id;
			$document->employer_id 		= $employer_id;
			$document->acct_mgr_id 		= $acct_mgr_id;
			$document->age		        = $age;
			$document->experience	    = $experience;
			$document->occupation	    = $occupation;
			$document->latlng	        = $latlng;

			// Adds the array values to the document, each value in a different multivalued
			// field
	 		// @param int    age 			<- 1 value here
	 		// @param array  occupation 	<- 1 value here
	 		// @param array  payrange		<- multiple ranges here
	 		// @param array  jobtype 		<- multiple values here
	 		// @param array  workschedule	<- multiple values here
	 		// @param array  shift 			<- multiple values here
	 		// @param array  languages 		<- multiple values here

			$document = $this->multiAdd($document, "payrange", $payrange);
			$document = $this->multiAdd($document, "jobtype", $jobtype);
			$document = $this->multiAdd($document, "workschedule", $workschedule);
			$document = $this->multiAdd($document, "shift", $shift);
			$document = $this->multiAdd($document, "languages", $languages);

			$solr->addDocument($document);
			
			if($commit){
	 	                $solr->commit(); //commit to see the deletes and the document
				$solr->optimize(); //merges multiple segments into one
			}
		}
		else {
			trigger_error("Connection to job solr index failed");
			return false;
		}
		return true;
	}

	public function deleteJob (
		$job_id,
		$commit = true )
	{
		if (USE_SOLR == 'false') {
			return true;
		}

		$solr = $this->_jsolr;

		if ($solr == null) {
			return true;
		}

		error_log("INFO SOLR deleteJob: id".$job_id);
		$response = $solr->deleteById($job_id);
		
		if ($response->getHttpStatus() != 200){
			trigger_error("Couldn't delete index entry jobs [$job_id] ".$response->getHttpStatusMessage());
			return false;
		}
		
		// Commits changes so the delete gets applied
		if($commit){
	 	        $solr->commit();
			$solr->optimize();
		}

		error_log("INFO SOLR SUCCESS deleteJob: id".$job_id);
		return true;
	}

    function convertDateToSolrFormat($dt)
    {
        $GMT_Difference = date('O');
        if( substr($GMT_Difference,0,1)=="+" )
            $GMT_Difference = "-" . substr($GMT_Difference,1);
        else
            $GMT_Difference = "+" . substr($GMT_Difference,1);
        $GMT_Difference = substr($GMT_Difference,0,3); // . "." . substr($GMT_Difference,3);

        $solr_date = date('c',  strtotime($dt . " " . $GMT_Difference ." hours"));
        $solr_date = substr($solr_date,0,19). "Z";

        return $solr_date;
    }

    function escape_string_for_solr($string) {
        $chars = '\\`~!@$%^&()-=+|?;:[]{},/<>';

        if((substr_count($string, '"')) % 2 != 0 )
        {
            $chars .= '"';
        }

        for($i=0; $i<strlen($chars); $i++)
        {
            $chr = substr($chars,$i,1);
            $string = str_replace($chr ,"\\".$chr,$string);
        }
        return $string;
    }

    function escape_quotes($string, $quote="'") {
        $double_quote = htmlentities('"',ENT_QUOTES);
        $string = str_replace($double_quote,"\\" . $double_quote,$string);

        $single_quote = htmlentities("'",ENT_QUOTES);
        $string = str_replace($single_quote,"\\" . $single_quote,$string);

        return html_entity_decode($string);
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

	/*
	 * Adds an array into multivalued fields in a document. Each value goes in a new field
	 * 
	 * @param string field
	 * @param array values
	*/
	public function normalize($address)
	{
		$address = strtolower(trim($address,"\r\n\t, "));
		$address = preg_replace('/(?:\s\s+|\n|\t)/', ' ', $address);
		$address = preg_replace("/\s+,/", ',', $address); 
		$address = preg_replace("/[\s,]+us$/", '', $address); 
		$address = preg_replace("/[\s,]+usa$/", '', $address); 
		$address = preg_replace("/[\s,]+america$/", '', $address); 
		$address = preg_replace("/[\s,]+united states$/", '', $address); 
		$address = $address . ", usa";		
		return ($address);
	}
}
