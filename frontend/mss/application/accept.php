<?

require "mysql.php";


function retrivetoken($sessionid){
	
	$cer;
	$dev;
	$app;
	$sql="select *  from webconfig ";
	
	$result = mysql_query($sql);
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$cer=$row['cert'];
		$dev=$row['dev'];
		$app=$row['app'];
	}
	
	$url="https://api.sandbox.ebay.com/ws/api.dll";
	//echo $sessionid;
	  // create the xml request that will be POSTed
$post_string = '	<?xml version="1.0" encoding="utf-8"?> 
<FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
   <SessionID>'.$sessionid.'</SessionID> 
</FetchTokenRequest> 
	';

    $session  = curl_init($url);                       // create a curl session

    curl_setopt($session, CURLOPT_POST, true);              // POST request type
    curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out
    
    
    $headers = array(
      'X-EBAY-API-CALL-NAME:FetchToken',
      'X-EBAY-API-SITEID:0',                                // Site 0 is for US
      "X-EBAY-API-COMPATIBILITY-LEVEL:613",
      "X-EBAY-API-CERT-NAME:".$cer."",
      "X-EBAY-API-DEV-NAME:".$dev."",
      "X-EBAY-API-APP-NAME:".$app."",
      "Content-Type:text/xml;charset=utf-8"
    );
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //set headers using the above array of headers

    $responseXML = curl_exec($session);                     // send the request
    curl_close($session);
	echo $responseXML;

    return $responseXML;  // returns a string

}
$maxid="";
$sql="select max(accountid) as co  from account ";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$maxid=$row['co'];
}


$sql="select * from account where accountid =".$maxid." ";
//echo $sql;
$result = mysql_query($sql) or die(mysql_error());
if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $xml=simplexml_load_string(retrivetoken($row['sessionid']));
	
	//echo $xml;
	
	$objDateTime = new DateTime($xml->HardExpirationTime);
$time =$objDateTime->format('Y-m-d h:i:s');

$username=$_GET['username'];
$sql="update  account set token='".$xml->eBayAuthToken."',exptime='".$time."',username='".$username."' where accountid='".$maxid."' ";
	 mysql_query($sql);
}


?>