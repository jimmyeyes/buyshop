<?php

$host = "jwliu.com";
$user = "root";
$pass = "761010";
$database = "mss";

$conn = @mysql_connect($host, $user, $pass);
@mysql_select_db($database, $conn) or die("Unable to select the database. Please check your MySQL database configuration.");

/**
 * @author 
 * @copyright 2013
 * @Email 
 */
header ( 'Cache-Control: no-store, no-cache, must-revalidate' );
header ( 'Cache-Control: post-check=0, pre-check=0', false );
header ( 'Pragma: no-cache' );
// 資料庫設定


if (!empty($_GET['act'])) {
    $action = $_GET['act'];
}
if (!empty($_GET['val'])) {
    $parentId = $_GET['val'];
}
//$list = array();
$list ="";
  if($action=="first"){


  
   	$sql="select * from product where categoryid='$parentId'";
  // echo $sql;
		$result = mysql_query($sql);

		$list .= '{\'When\':\'' . "1" . '\',\'Value\':\'' ."". '\',\'Text\':\'' . "Select" . '\'},';
    	while ($row = mysql_fetch_array($result)) {
     	//	echo "$name";
     	$list .= '{\'When\':\'' . $parentId . '\',\'Value\':\'' .$row["productid"]. '\',\'Text\':\'' . $row["prodname"] . '\'},';
			//   $arr = array ('When' => $parentId, 'Value' => $row["productid"], 'Text' => $row["prodname"]);
          //  $list[] = $arr;
    	}
  
		
        


  }else if($action=="second"){
  	
		$sql="select * from product where productid='$parentId'";
   //echo $sql;
		$result = mysql_query($sql);

		
    	while ($row = mysql_fetch_array($result)) {
    		
          $list .= '{\'When\':\'' . $parentId . '\',\'Value\':\'' .$row["sku"]. '\',\'Text\':\'' . $row["sku"] . '\'},';
    
		}
	
	
	
  }

echo $list;
//echo json_encode($list);

?>