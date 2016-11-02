<?php

require_once('Apache/Solr/Service.php');

class SolrGoogleCache 
{
	protected $_gsolr;
	protected $_gpath = '/solr/google/';

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
			$this->_gsolr = new Apache_Solr_Service($host, $port, $this->_gpath);
		} catch (Exception $e) {
			$this->_gsolr = null;	
		} 
	}

	/*
	 *
	 *
	 * @example: get_location_from_solr("Sunnyvale, CA")
	 *
	 */
	function get_location_from_solr($loc)
	{
		$solr= $this->_gsolr;

		if (USE_SOLR == 'false') {
			return null;
		}
        if ( $solr == null ) {
           return null;
        }
        if ( ! $solr->ping() ) {
           return null;
        }
       	$address = $this->normalize($loc); 
        $address = $this->escape_string_for_solr($address);
        $offset = 0;
		$limit 	= 1;
      
	    $q1 = '+title:"' . $address . '"';
        
		$queries            =   array($q1);
        $result             =   array();
        
        $response = $solr->search( $q1, $offset, $limit);
		if ( $response->getHttpStatus() == 200 ) {
			if ( $response->response->numFound > 0 ) {
				$this->total_records = $response->response->numFound;
				foreach ( $response->response->docs as $doc ) {
					$result[]=$doc;
				}
			}
		}
		else {
			return false;
		}
		return $result;
	}
	
	/*
	 *
	 * @example: this function is used to add location details to solr
     *
	 */
	function add_location_to_solr($data, $commit=true)
	{
		$solr= $this->_gsolr;

		if (USE_SOLR == 'false') {
			return false;
		}
        if ( $solr == null ) {
           return false;
        }
		
		if ( ! $solr->ping() ) {
		   trigger_error("Connection to employer solr index failed");
           return false;
        }
		
		$document = new Apache_Solr_Document();
		$document->id = $data['id'];
        $document->title = $data['title'];
        $document->alternate_address = $data['alternate_address'];
        $document->administrative_area = $data['administrative_area'];
        $document->sub_administrative_area = $data['sub_administrative_area'];
        $document->country  = $data['country'];
        $document->created_on  = $data['created_on'];
        $document->locality  = $data['locality'];
        $document->dependent_locality  = $data['dependent_locality'];
        $document->thorough_fare  = $data['thorough_fare'];
        $document->postal  = $data['postal'];
        $document->accuracy  = $data['accuracy'];
        $document->actual_address  = $data['actual_address'];
        $document->results  = $data['results'];
        $document->lng  = $data['lng'];
        $document->lat  = $data['lat'];
			
		$solr->addDocument($document);

		if($commit){
	    	$solr->commit(); //commit to see the deletes and the document
			$solr->optimize(); //merges multiple segments into one
		} 
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
