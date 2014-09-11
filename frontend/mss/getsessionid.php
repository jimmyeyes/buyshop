<?

$sdk=new sdk();

/*
$xml = simplexml_load_string($sdk->getsession());
//echo $xml->SessionID;

$sql="insert into account values ('','','','".$xml->SessionID."','',NOW())";
$query=mysql_query($sql);


$xml = $sdk->gettoken($xml->SessionID);
 
 */
 
 echo $sdk->GetSellerTransactions("testuser_taiwanliu",'','');
 
