<?php

require_once('Apache/Solr/Service.php');

class SolrSeekers 
{
	protected $_ssolr;
	protected $_spath = '/solr/seekers/';

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
		$this->_ssolr = new Apache_Solr_Service($host, $port, $this->_spath);
		} catch (Exception $e) {
			$this->_ssolr = null;
		}
	}

	/*
	 * Adds a seeker 
	 * @param string $seeker_id
	 * @param int	 $seeker_db_id
	 * @param string $lnglat
	 * @param string radius
	 * @param int    age 			<- 1 value here which indicates seeker is 16-18, 18-21 or 21+
	 * @param array  occupation 	<- multiple occupations here
	 * @param array  payrange		<- multiple ranges here
	 * @param array  jobtype 		<- multiple values here
	 * @param array  workschedule	<- multiple values here
	 * @param array  shift 			<- multiple values here
	 * @param array  languages 		<- multiple values here
	 * @param bool   commit (optional, default true) commits in the index after completion
	 * The commit argument is useful for batch updates
	 * @return bool
	 */
	public function addSeeker (
		$seeker_id, 
		$seeker_db_id, 
		$lnglat, 
		$radius, 
		$age, 
		$occupation, 
		$payrange, 
		$jobtype, 
		$workschedule, 
		$shift, 
		$languages, 
		$commit=true)
	{
		$solr = $this->_ssolr;
				error_log("INFO SOLR DETAILS :seeker_id:.".$seeker_id."__ssekerId:.".$seeker_db_id."__latlong:".$lnglat."__radius:".$radius."__age:".$age."__occupation:".$occupation."__payrange:".$payrange."__jobtype:".$jobtype."__workschedule:".$workschedule."__workshift:".$shift."__languages:".$languages."commit".$commit);
		if (USE_SOLR == 'false') {
			return true;
		}

		error_log("INFO SOLR solr->addSeeker ".$seeker_id." lnglat=".$lnglat." radius=".$radius);
		if ($solr == null) {
			return true;
		}
		if ($solr->ping())
		{
			$document = new Apache_Solr_Document();
/**
 *
 * schema
   <field name="id" type="string" indexed="true" stored="true" required="true" /> 
   <field name="id_int" type="tlong" indexed="true" stored="true" required="true" />
   <field name="lnglat" type="location" indexed="true" stored="true" multiValued="false"/>
   <field name="radius" type="string" indexed="true" stored="true" multiValued="false"/>
   <field name="age" type="int" indexed="true" stored="true" multiValued="false"/>
   <field name="occupation" type="string" indexed="true" stored="true" multiValued="true"/>
   <field name="payrange" type="string" indexed="true" stored="true" multiValued="true"/>
   <field name="jobtype" type="string" indexed="true" stored="true" multiValued="true"/>
   <field name="workschedule" type="string" indexed="true" stored="true" multiValued="true"/>
   <field name="shift" type="string" indexed="true" stored="true" multiValued="true"/>
   <field name="languages" type="string" indexed="true" stored="true" multiValued="true"/>
**/
			$document->id = $seeker_id; 
			$document->id_int = $seeker_db_id; 
			$document->lnglat = $lnglat;
			$document->radius = $radius * 1.609344;
			$document->age = $age;
			
			// Adds the array values to the document, each value in a different multivalued
			// field
			$document = $this->multiAdd($document, "occupation", $occupation);
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
		else{
			trigger_error("Connection to seeker solr index failed");
			return false;
		}
		return true;
	}

	/*
	 * Given an address and params looks for all the seekers whose area covers this address 
	 * 
	 * Due to some limitations in the spacial search in this solr version, the 
	 * function creates a search area and then filters within that area all the 
	 * seekers whose radius covers that address
	 * 
	 * @param latlong string in pattern "/\d+\.\d+,-?\d+\d+/"
	 * @param limit maximum number of results to return
	 * @param order (asc, desc): sorting order for the resultset, 
	 *                           based on distance from the address
	 * @param filters @array with key => value pairs for filtering
	 *                            The values are also arrays, as the filter 
	 *                            can be multivalued.
     *                           (
	 *                            "age" => _AGE_21,	// this is not array
	 *                            "occupation" => ("Cashier"), 
     *                            "payrange" => ("1"), 
     *                            "jobtype" => ("1"), 
     *                            "workschedule" => ("1","2"), 
     *                            "shift" => ("1","2"), 
     *                            "languages" => ("1");
	 * 
	 * @returns Apache_Solr_Result or null in case of problems
	 */
	public function searchSeekersAroundAddress (
						$latlong, 
						$limit,
						$order = 'asc',
						$filters=null)
	{
		$solr= $this->_ssolr;

		if (USE_SOLR == 'false') {
			return null;
		}
		if ($solr == null) {
			return null;
		}
		$filter_query=null;
		$fq_initialized=false;

		// Constructs a filter query to get the records 
		// that match age, occupation, payrange, jobtype, schedule, shift and languages// need to boost some of these
		if(! is_null($filters) )
		{
			foreach ($filters as $key => $array_values)
			{
				$filter = null;
				$filter_initialized=false;

				if($key == "age") {
					$value = $array_values;	// for age its not an array
					switch ($value) {
					case _AGE_16:
						$filter = "age:"._AGE_16." OR age:"._AGE_18." OR age:"._AGE_21;
						break;
					case _AGE_18:
						$filter = "age:"._AGE_18." OR age:"._AGE_21;
						break;
					case _AGE_21:
					default:
						$filter = "age:"._AGE_21;
						break;
					} 
				} else {
					foreach ($array_values as $value) {
						$keyval = "$key:$value";
						if($filter_initialized) {
							$filter .= " OR $keyval";
						} else {
							$filter .= "$keyval";
							$filter_initialized =true;
						}
					}
				}
				if(!is_null($filter))
				{
					if($fq_initialized)
					{
						$filter_query .= " AND ($filter)";
						//$filter_query .= " OR ($filter)";
					}
					else{
						$filter_query = "($filter)";
						$fq_initialized=true;
					}
				}
			}	
		}		

		// Looks for al seekers in a job radius area, sorted by distance to the address 

		// Query field with boosting argument
		//$qf = "score^100 occupation^10 jobtype^9 payrange^8 workschedule^7 language^6";
		//$qf = "score^100";

		if(is_null($filter_query))
		{
			$additionalParameters = array( "sort" => "geodist($latlong,lnglat) $order", "fq" => "{!geofilt pt=$latlong sfield=lnglat d=100}", "fl" => "*,score");
		}
		else
		{
			//$additionalParameters = array( "sort" => "geodist($latlong,lnglat) $order", "fq" => "($filter_query) AND _query_:\"{!geofilt pt=$latlong sfield=lnglat d=100}\"", "fl" => "*,score", "qf" => "$qf");
			$additionalParameters = array( "sort" => "geodist($latlong,lnglat) $order", "fq" => "($filter_query) AND _query_:\"{!geofilt pt=$latlong sfield=lnglat d=100}\"", "fl" => "*,score");
			
		}
		$query = "{!func}geodist($latlong,lnglat)";

		error_log("INFO SOLR seekerSearch: issuing query: ".$query);
		error_log("INFO SOLR filter: ".$filter_query);
		try {
		  $results = $solr->search("$query", 0, $limit, $additionalParameters);
		} catch (Exception $e) {
			$total = "0";
    		echo 'Exception caught: ',  $e->getMessage(), "\n";
			return null;
		}
		$total = (int) $results->response->numFound;
		if($total == 0){
			error_log("SOLR seekerSearch: 0 matches");
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
			else{
				// error_log("Dist [".$dist."] for id [".$id."] is out of range [$radius]");
				;
			}
		}
		$results->response->numFound = $numFound;
		$results->response->docs = $documents;
		
		error_log("SOLR seekerSearch: initial matches: ".$total." Final matches:".$results->response->numFound);
		return $results;
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

	public function deleteSeeker (
		$seeker_id,
		$commit = true )
	{
		if (USE_SOLR == 'false') {
			return true;
		}

		$solr = $this->_ssolr;

		if ($solr == null) {
			return true;
		}

		error_log("SOLR deleteSeeker: ".$seeker_id);
		$response = $solr->deleteById($seeker_id);
		
		if ($response->getHttpStatus() != 200){
			trigger_error("Couldn't delete index entry seekers [$seeker_id] ".$response->getHttpStatusMessage());
			return false;
		}
		
		// Commits changes so the delete gets applied
		if($commit){
	 	        $solr->commit();
			$solr->optimize();
		}

		error_log("SOLR SUCCESS deleteSeeker: ".$seeker_id);
		return true;
	}
}

