<?php
session_start();

require "mysql.php";

class sdk {

var $url="https://api.sandbox.ebay.com/ws/api.dll";
var $runame="none-com.jwliu.ebay-nqjvlqwzo";
var $cer;
var $dev;
var $app;

function sdk(){
		
	$sql="select *  from webconfig ";
	//echo $sql;
	$result = mysql_query($sql);
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$this->cer=$row['cert'];
		$this->dev=$row['dev'];
		$this->app=$row['app'];
	}
	
}

function runfunction($post_string,$callname){
	
	  $session  = curl_init($this->url);                       // create a curl session

    curl_setopt($session, CURLOPT_POST, true);              // POST request type
    curl_setopt($session, CURLOPT_POSTFIELDS, $post_string); // set the body of the POST
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out
    
    
    $headers = array(
      "X-EBAY-API-CALL-NAME:".$callname."",
      "X-EBAY-API-SITEID:0",                                // Site 0 is for US
      "X-EBAY-API-COMPATIBILITY-LEVEL:833",
       "X-EBAY-API-CERT-NAME:".$this->cer."",
      "X-EBAY-API-DEV-NAME:".$this->dev."",
      "X-EBAY-API-APP-NAME:".$this->app."",
      "Content-Type:text/xml;charset=utf-8"
    );
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //set headers using the above array of headers

    $responseXML = curl_exec($session);                     // send the request
    curl_close($session);

    return $responseXML;  // returns a string
}

function getsession()
{
    // create the xml request that will be POSTed
$post_string = '<?xml version="1.0" encoding="utf-8"?>
<GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RuName>'.$this->runame.'</RuName>
</GetSessionIDRequest>';

  return runfunction($post_string,"GetSessionID");
    
   
} // function


function gettoken($sessionid)
{
    // create the xml request that will be POSTed
    $url="https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn&RuName=".$this->runame."&SessID=".$sessionid;
	//echo $url;
	?>
	<input type="button" value="開新視窗" onclick="window.open(' <?=$url?> ', 'Yahoo');" />
<?
} // function

function retrivetoken($sessionid){
	
	//echo $sessionid;
	  // create the xml request that will be POSTed
$post_string = '	<?xml version="1.0" encoding="utf-8"?>
<FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <SessionID>'.$sessionid.'</SessionID>
</FetchTokenRequest>
	';

    return runfunction($post_string,"FetchToken");
  
}

function GetSellerTransactions($accountid,$start,$to)
{
	
	$token;
		$sql="select * from account where accountid='".$accountid."'";

	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		  $token= $row['token'];
	}
	
	if($start=="" && $to ==""){
		$to= date("Y-m-d\TH:i:s\Z");
		$start = date("Y-m-d\TH:i:s\Z", strtotime("-30 days"));
	}
	
	
	$post_string = '<?xml version="1.0" encoding="utf-8"?>
<GetSellerTransactionsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>'.$token.'</eBayAuthToken>
</RequesterCredentials>
<ModTimeFrom>'.$start.'</ModTimeFrom>
<ModTimeTo>'.$to.'</ModTimeTo>
</GetSellerTransactionsRequest>';


return runfunction($post_string,"GetSellerTransactions");

   
	
}

function GetSellerList($accountid){
	$token;
	$sql="select * from account where accountid='".$accountid."'";

	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		  $token= $row['token'];
	}

	
		$to= date("Y-m-d\TH:i:s\Z");
		$start = date("Y-m-d\TH:i:s\Z", strtotime("-30 days"));
	
	
		$to= date("Y-m-d\TH:i:s\Z");
		$start = date("Y-m-d\TH:i:s\Z", strtotime("-30 days"));
	
	$post_string = '<?xml version="1.0" encoding="utf-8"?>
<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>'.$token.'</eBayAuthToken>
</RequesterCredentials>
<EndTimeFrom>'.$start.'</EndTimeFrom>
<EndTimeTo>'.$to.'</EndTimeTo>
</GetSellerListRequest>​';



return runfunction($post_string,"GetSellerList");

   
}



function AddItem($accountid,$productid){
	
	$token;
	$sql="select * from account where accountid='".$accountid."'";

	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		  $token= $row['token'];
	}
	
		
$Title="";
$Description="";
$CategoryID="";
$StartPrice="";
$ConditionID="";
$Country="";
$Currency="";
$DispatchTimeMax="";
$ListingDuration="";
$ListingType="";
$PaymentMethods="";
$PayPalEmailAddress="";
$PostalCode="";
$Quantity="";
$ReturnsAcceptedOption="";

$RefundOption="";
$RefundOption="";
$ReturnsWithinOption="";
$ReturnsDescription="";
$ShippingCostPaidByOption="";
$ShippingType="";
$ShippingServicePriority="";
$ShippingService="";
$ShippingServiceCost="";
$Site="";
$BuyItNowPrice="";

	$sql="select * from product where productid='".$productid."'";
	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		 	
$Title=$row['Title'];
$Description=$row['Description'];
$CategoryID=$row['CategoryID'];
$StartPrice=$row['StartPrice'];
$BuyItNowPrice=$row['BuyItNowPrice'];

   

$ConditionID=$row['ConditionID'];
$Country=$row['Country'];
$Currency=$row['Currency'];
$DispatchTimeMax=$row['DispatchTimeMax'];
$ListingDuration=$row['ListingDuration'];
$ListingType=$row['ListingType'];
$PaymentMethods=$row['PaymentMethods'];
$PayPalEmailAddress=$row['PayPalEmailAddress'];
$PostalCode=$row['PostalCode'];
$Quantity=$row['Quantity'];

$ReturnsAcceptedOption=$row['ReturnsAcceptedOption'];
$RefundOption=$row['RefundOption'];
$ReturnsWithinOption=$row['ReturnsWithinOption'];

$ReturnsDescription=$row['ReturnsDescription'];
$ShippingCostPaidByOption=$row['ShippingCostPaidByOption'];
$ShippingType=$row['ShippingType'];
$ShippingServicePriority=$row['ShippingServicePriority'];
$ShippingService=$row['ShippingService'];
$ShippingServiceCost=$row['ShippingServiceCost'];
$Site=$row['Site'];
	}




$post_string ="<?xml version=\"1.0\" encoding=\"utf-8\"?>
<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<ErrorLanguage>en_US</ErrorLanguage>
<WarningLevel>High</WarningLevel>
<Item>
<Title>".$Title."</Title>
<Description>".$Description."</Description>
<PrimaryCategory>
<CategoryID>".$CategoryID."</CategoryID>
</PrimaryCategory>
<StartPrice>".$StartPrice."</StartPrice>
<ConditionID>".$ConditionID."</ConditionID>
<Country>".$Country."</Country>
<Currency>".$Currency."</Currency>
<DispatchTimeMax>".$DispatchTimeMax."</DispatchTimeMax>
<ListingDuration>".$ListingDuration."</ListingDuration>
<ListingType>".$ListingType."</ListingType>
<PaymentMethods>".$PaymentMethods."</PaymentMethods>
<PayPalEmailAddress>".$PayPalEmailAddress."</PayPalEmailAddress>
<PostalCode>".$PostalCode."</PostalCode>
<Quantity>".$Quantity."</Quantity>
<ReturnPolicy>
<ReturnsAcceptedOption>".$ReturnsAcceptedOption."</ReturnsAcceptedOption>
<RefundOption>".$RefundOption."</RefundOption>
<ReturnsWithinOption>".$ReturnsWithinOption."</ReturnsWithinOption>
<Description>".$ReturnsDescription."</Description>
<ShippingCostPaidByOption>".$ShippingCostPaidByOption."</ShippingCostPaidByOption>
</ReturnPolicy>
<ShippingDetails>
<ShippingType>".$ShippingType."</ShippingType>
<ShippingServiceOptions>
<ShippingServicePriority>".$ShippingServicePriority."</ShippingServicePriority>
<ShippingService>".$ShippingService."</ShippingService>
<ShippingServiceCost>".$ShippingServiceCost."</ShippingServiceCost>
</ShippingServiceOptions>
</ShippingDetails>
<Site>".$Site."</Site>
</Item>
<RequesterCredentials>
<eBayAuthToken>".$token."</eBayAuthToken>
</RequesterCredentials>
</AddItemRequest>";

  return $this->runfunction($post_string,"AddItem");

   
}


function AddFixPriceItem($accountid,$productid){
	
	$token;
	$sql="select * from account where accountid='".$accountid."'";
	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		  $token= $row['token'];
	}
	
		
$Title="";
$Description="";
$CategoryID="";
$StartPrice="";
$ConditionID="";
$Country="";
$Currency="";
$DispatchTimeMax="";
$ListingDuration="";
$ListingType="";
$PaymentMethods="";
$PayPalEmailAddress="";
$PostalCode="";
$Quantity="";
$ReturnsAcceptedOption="";

$RefundOption="";
$RefundOption="";
$ReturnsWithinOption="";
$ReturnsDescription="";
$ShippingCostPaidByOption="";
$ShippingType="";
$ShippingServicePriority="";
$ShippingService="";
$ShippingServiceCost="";
$Site="";
$BuyItNowPrice="";

	$sql="select * from product where productid='".$productid."'";
	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		 	
$Title=$row['Title'];
$Description=$row['Description'];
$CategoryID=$row['CategoryID'];
$StartPrice=$row['StartPrice'];
$BuyItNowPrice=$row['BuyItNowPrice'];

   

$ConditionID=$row['ConditionID'];
$Country=$row['Country'];
$Currency=$row['Currency'];
$DispatchTimeMax=$row['DispatchTimeMax'];
$ListingDuration=$row['ListingDuration'];
$ListingType=$row['ListingType'];
$PaymentMethods=$row['PaymentMethods'];
$PayPalEmailAddress=$row['PayPalEmailAddress'];
$PostalCode=$row['PostalCode'];
$Quantity=$row['Quantity'];

$ReturnsAcceptedOption=$row['ReturnsAcceptedOption'];
$RefundOption=$row['RefundOption'];
$ReturnsWithinOption=$row['ReturnsWithinOption'];

$ReturnsDescription=$row['ReturnsDescription'];
$ShippingCostPaidByOption=$row['ShippingCostPaidByOption'];
$ShippingType=$row['ShippingType'];
$ShippingServicePriority=$row['ShippingServicePriority'];
$ShippingService=$row['ShippingService'];
$ShippingServiceCost=$row['ShippingServiceCost'];
$Site=$row['Site'];
	}




$post_string ="<?xml version=\"1.0\" encoding=\"utf-8\"?>
<AddFixedPriceItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<ErrorLanguage>en_US</ErrorLanguage>
<WarningLevel>High</WarningLevel>
<Item>
<Title>".$Title."</Title>
<Description>".$Description."</Description>
<PrimaryCategory>
<CategoryID>".$CategoryID."</CategoryID>
</PrimaryCategory>
<StartPrice>".$StartPrice."</StartPrice>
<CategoryMappingAllowed>true</CategoryMappingAllowed>
<ConditionID>".$ConditionID."</ConditionID>
<Country>".$Country."</Country>
<Currency>".$Currency."</Currency>
<DispatchTimeMax>".$DispatchTimeMax."</DispatchTimeMax>
<ListingDuration>".$ListingDuration."</ListingDuration>
<ListingType>".$ListingType."</ListingType>
<PaymentMethods>".$PaymentMethods."</PaymentMethods>
<PayPalEmailAddress>".$PayPalEmailAddress."</PayPalEmailAddress>
<PostalCode>".$PostalCode."</PostalCode>
<Quantity>".$Quantity."</Quantity>
<ReturnPolicy>
<ReturnsAcceptedOption>".$ReturnsAcceptedOption."</ReturnsAcceptedOption>
<RefundOption>".$RefundOption."</RefundOption>
<ReturnsWithinOption>".$ReturnsWithinOption."</ReturnsWithinOption>
<Description>".$ReturnsDescription."</Description>
<ShippingCostPaidByOption>".$ShippingCostPaidByOption."</ShippingCostPaidByOption>
</ReturnPolicy>
<ShippingDetails>
<ShippingType>".$ShippingType."</ShippingType>
<ShippingServiceOptions>
<ShippingServicePriority>".$ShippingServicePriority."</ShippingServicePriority>
<ShippingService>".$ShippingService."</ShippingService>
<ShippingServiceCost>".$ShippingServiceCost."</ShippingServiceCost>
</ShippingServiceOptions>
</ShippingDetails>
<Site>".$Site."</Site>
</Item>
<RequesterCredentials>
<eBayAuthToken>".$token."</eBayAuthToken>
</RequesterCredentials>
</AddFixedPriceItemRequest>";

  return $this->runfunction($post_string,"AddFixedPriceItem");

   
}


function GetOrders($accountid){
	$token;
	$sql="select * from account where accountid='".$accountid."'";
	$result = mysql_query($sql) or die(mysql_error());
	if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
 		  $token= $row['token'];
	}

	
		$to= date("Y-m-d\TH:i:s\Z");
		$start = date("Y-m-d\TH:i:s\Z", strtotime("-30 days"));
	
	
		$to= date("Y-m-d\TH:i:s\Z");
		$start = date("Y-m-d\TH:i:s\Z", strtotime("-30 days"));
	
	$post_string = '<?xml version="1.0" encoding="utf-8"?>
<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>'.$token.'</eBayAuthToken>
</RequesterCredentials>
  <NumberOfDays>10</NumberOfDays>
<WarningLevel>High</WarningLevel>
</GetOrdersRequest>​​';



return $this->runfunction($post_string,"GetOrders");

   
}



}//echo $xml;
?>