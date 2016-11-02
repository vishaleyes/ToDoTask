<?php

require_once('Apache/Solr/Service.php');

class SolrEmployers 
{
	protected $_esolr;
	protected $_epath = '/solr/employers/';

	/*
	 * Constructor
	 * @param host string = hostname of the solr server (default localhost)
	 * @param port string = port where the solr servide is listening (default 8933)
	 * @param path string = path to solr index files (default /solr/
	 */

	public function __construct($host = 'localhost', $port = 8983, $path = '/solr/')
	{
		if (USE_SOLR == 'false') {
			return true;
		}
		try {
		$this->_esolr = new Apache_Solr_Service($host, $port, $this->_epath);
		} catch (Exception $e) {
			$this->_esolr = null ;
		}
	}

	/*
	 * Adds an employer 
     *
	 * @param string $employer_id
	 * @param int	 $employer_db_id
	 * @param string $lnglat
	 * @param array  occupation 	<- multiple occupations here
	 * @param bool   commit (optional, default true) commits in the index after completion
	 * The commit argument is useful for batch updates
	 * @return bool
	 */
	public function addEmployer (
		$employer_id, 
		$employer_db_id, 
		$lnglat, 
		$occupation, 
		$commit=true)
	{
		$solr = $this->_esolr;
        if ( $solr == null ) {
           return false;
        }

		error_log("INFO solr->addEmployer ".$employer_id." lnglat=".$lnglat);
		if ($solr->ping())
		{
			$document = new Apache_Solr_Document();
/**
 *
 * schema
   <field name="id" type="string" indexed="true" stored="true" required="true" /> 
   <field name="id_int" type="tlong" indexed="true" stored="true" required="true" />
   <field name="lnglat" type="location" indexed="true" stored="true" multiValued="false"/>
   <field name="occupation" type="string" indexed="true" stored="true" multiValued="true"/>
**/
			$document->id = $employer_id; 
			$document->id_int = $employer_db_id; 
			$document->lnglat = $lnglat;
			
			// Adds the array values to the document, each value in a different multivalued
			// field
			$document = $this->multiAdd($document, "occupation", $occupation);
			
			$solr->addDocument($document);

			if($commit){
	 	                $solr->commit(); //commit to see the deletes and the document
				$solr->optimize(); //merges multiple segments into one
			}
		}
		else{
			trigger_error("Connection to employer solr index failed");
			return false;
		}
		return true;
	}

	/*
	 * Given an address and params looks for all the employers near that address 
	 * 
	 * @param latlong string in pattern "/\d+\.\d+,-?\d+\d+/"
	 * @param radius 
	 * @param limit maximum number of results to return
	 * @param order (asc, desc): sorting order for the resultset, 
	 *                           based on distance from the address
	 * @param filters @array with key => value pairs for filtering
	 *                            The values are also arrays, as the filter 
	 *                            can be multivalued.
     *                           (
	 *                            "occupation" => ("Cashier"), 
     *                            )
	 * 
	 * @returns Apache_Solr_Result or null in case of problems
	 */
	public function searchEmployersAroundAddress (
						$latlong, 
						$radius, 
						$limit,
						$order = 'asc',
						$filters=null)
	{
		$solr= $this->_esolr;
		if (USE_SOLR == 'false') {
			return null;
		}
        if ( $solr == null ) {
           return null;
        }

		$filter_query=null;
		$fq_initialized=false;

		// 
		// Constructs a filter query to get the records 
		// that match occupation
		// 
		if(! is_null($filters) )
		{
			foreach ($filters as $key => $array_values)
			{
				$filter = null;
				$filter_initialized=false;
				
				foreach ($array_values as $value)
				{
					$keyval = "$key:$value";
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

				if(!is_null($filter))
				{
					if($fq_initialized)
					{
						$filter_query .= " AND ($filter)";
						//$filter_query .= " OR ($filter)";
					}
					else{
						$filter_query .= "$filter";
						$fq_initialized=true;
					}
				}
			}	
		}		

		// Looks for all employers in a job radius area, sorted by distance to the address 

		if(is_null($filter_query))
		{
			$additionalParameters = array( "sort" => "geodist($latlong,address) $order", "fq" => "{!geofilt pt=$latlong sfield=address d=$radius}", "fl" => "*,score");
		}
		else
		{
			$additionalParameters = array( "sort" => "geodist($latlong,address) $order", "fq" => "($filter_query) AND _query_:\"{!geofilt pt=$latlong sfield=address d=$radius}\"", "fl" => "*,score");
			
		}
		$query = "{!func}geodist($latlong,address)";

		
		$results = $solr->search("$query", 0, $limit, $additionalParameters);
		$total = (int) $results->response->numFound;
		if($total == 0){
			return $results;
		}

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

	public function deleteEmployer (
		$employer_id,
		$commit = true )
	{
		$solr = $this->_esolr;

		if (USE_SOLR == 'false') {
			return false;
		}
        if ( $solr == null ) {
           return false;
        }

		$response = $solr->deleteById($employer_id);
		
		if ($response->getHttpStatus() != 200){
			trigger_error("Couldn't delete index entry employers [$employer_id] ".$response->getHttpStatusMessage());
			return false;
		}
		
		// Commits changes so the delete gets applied
		if($commit){
	 	        $solr->commit();
			$solr->optimize();
		}

		return true;
	}
}

