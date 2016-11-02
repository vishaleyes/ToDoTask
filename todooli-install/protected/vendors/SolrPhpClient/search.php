<?php

/*require_once('SolrPhpClient/Apache/Solr/Service.php');
$solr = new Apache_Solr_Service('localhost', 8983, '/solr/');

if($solr->ping()) {

	echo "qwe";

}
else {

	echo "Nope...";

}

 $solr->search("enver", 0, 100);

echo $total = (int) $results->response->numFound;*/
// make sure browsers see this page as utf-8 encoded HTML
header('Content-Type: text/html; charset=utf-8');


$limit = 10;

$_REQUEST['q']='name:qwe';

$query = isset($_REQUEST['q']) ? $_REQUEST['q'] : false;
$results = false;

if ($query)
{
  // The Apache Solr Client library should be on the include path
  // which is usually most easily accomplished by placing in the
  // same directory as this script ( . or current directory is a default
  // php include path entry in the php.ini)
  require_once('SolrPhpClient/Apache/Solr/Service.php');

  // create a new solr service instance - host, port, and webapp
  // path (all defaults in this example)
  $solr = new Apache_Solr_Service('192.168.1.5', 8983, '/solr/weather/');

  // if magic quotes is enabled then stripslashes will be needed
  if (get_magic_quotes_gpc() == 1)
  {
    $query = stripslashes($query);
	
  }

  // in production code you'll always want to use a try /catch for any
  // possible exceptions emitted  by searching (i.e. connection
  // problems or a query parsing error)
  try
  {
    $results = $solr->search($query, 0, $limit);
	var_dump($results);echo $total = (int) $results->response->numFound;
  }
  catch (Exception $e)
  {
    // in production you'd probably log or email this error to an admin
        // and then show a special message to the user but for this example
        // we're going to show the full exception
        die("{$e->__toString()}");
  }
}

?>
