<?
require "mysql.php";
function retrivetoken($sessionid,$currency){
	
	$cer;
	$dev;
	$app;
	$sql="select * from webauth ";
	
	$result = mysql_query($sql);
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$cer=$row['cert'];
		$dev=$row['dev'];
		$app=$row['app'];
	}
	
	$url="https://api.ebay.com/ws/api.dll";
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


    $siteid="0";
    if($currency=="USD"){
        $siteid="0";
    }else if($currency=="AUD"){
        $siteid="15";
    }else if($currency=="GBP"){
        $siteid="3";
    }

    
    $headers = array(
      'X-EBAY-API-CALL-NAME:FetchToken',
      "X-EBAY-API-SITEID:".$siteid."",                                // Site 0 is for US
      "X-EBAY-API-COMPATIBILITY-LEVEL:613",
      "X-EBAY-API-CERT-NAME:".$cer."",
      "X-EBAY-API-DEV-NAME:".$dev."",
      "X-EBAY-API-APP-NAME:".$app."",
      "Content-Type:text/xml;charset=utf-8"
    );
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //set headers using the above array of headers

    $responseXML = curl_exec($session);                     // send the request
    curl_close($session);
	//echo $responseXML;

    $xml=simplexml_load_string($responseXML);
   // print_r($xml);
    echo $xml->Ack;

    if($xml->Ack=="Success"){
        echo "綁定成功，關閉此視窗回到新增頁面查看";
        echo '<input onclick="window.close();" value="關閉視窗" type="button">';
    }else{
        echo "綁定失敗，請再試一次";

        print_r($xml);

        }

    return $responseXML;  // returns a string

}
$maxid="";
$sql="SELECT * FROM `accounttoken` order by accounttokenid desc limit 1 ";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$maxid=$row['accounttokenid'];

    $xml=simplexml_load_string(retrivetoken($row['sessionid'],$row['Currency']));
	
	//echo $xml;
	
	$objDateTime = new DateTime($xml->HardExpirationTime);
	$time =$objDateTime->format('Y-m-d h:i:s');

	$username=$_GET['username'];
	$sql="update  accounttoken set token='".$xml->eBayAuthToken."',exptime='".$time."',username='".$username."' where accounttokenid='".$maxid."' ";
	 mysql_query($sql);
}


?>