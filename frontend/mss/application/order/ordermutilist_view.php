<?= $menu ?>

<?
/*
$xml = simplexml_load_string($sdk->getsession());
//echo $xml->SessionID;

$sql="insert into 	webconfig values ('','','','".$xml->SessionID."','',NOW())";
$query=mysql_query($sql);


$xml = $sdk->gettoken($xml->SessionID);
 
 */
 
 // echo $sdk->GetSellerTransactions("testuser_taiwanliu",'','');

	//$xml=simplexml_load_string($sdk->GetSellerList("testuser_taiwanliu"));
	//print_r($xml);
	
	
	//echo $xml->ItemArray->Item->ItemID->ListingDetails->StartTime;
	
	
?>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div class="box themed_box">
			<h2 class="box-header">訂單管理 </h2>
			<div class="box-content">
				
			 <form action="<?=$url?>order/index" method="post">
			<labe>  起日期： </label>
			<input class="form-field datepicker" value="<?=$sdate?>"    type="text" name="spdate">
			
			<labe>  訖日期： </label>
			<input class="form-field datepicker" value="<?=$edate?>"   type="text" name="epdate">
			  <input type="submit" value="搜尋" >
			</form>
				
				<table class="display" id="tabledata">
                <thead>
                    <tr>
                    <th>SN</th>
                    	<th>OrderID</th>
                      <th>Date</th>
                        <th>eBay ITEM-ID/TXN-ID</th>
                         <th>TXN Type</th>
                       <th>buyer</th>
                      
                        <th>AmountPaid</th>
                        <th>Seller</th>
                        
                         <th>Status</th>
                        
                          <th>Shipping Paid</th>
                          <th>Seller Protection</th>
                           <th>Note</th>
                            <th>Shipment Information</th>
                         
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	
                        	<td class="nCategory"><?=$i?>  </td>	
                        	 <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "" ?>/<?= $row->OrderID ?>"><?= $row->orderlistid ?><br><?= $row->OrderID ?></a></td>
                        	 <td class="nCategory"><?=$row->CreatedTime?>  </td>	
                            <td class="nTitle"><?=$row->ItemID?><br><?=$row->txnid?></td>
                            <td class="nCategory"><?=$row->TRANSACTIONTYPE?>  </td>
                              <td class="nCategory"><?=$row->FIRSTNAME?> <?=$row->LASTNAME?><br /><?=$row->BuyerUserID?>  </td>
                              
                            <td class="nCategory"><?=$row->AmountPaid?>  </td>
                            <td class="nCategory"><?=$row->SellerEmail?>  </td>
                           <td class="nCategory"><?=$row->PAYMENTSTATUS?>  </td>
                           
							<td class="nCategory"><?=$row->SHIPPINGAMT?>  </td>	
						<td class="nCategory"><?=$row->PROTECTIONELIGIBILITY?>  </td>	
						
							<td class="nCategory"><a href="<?= $adminurl . "" ?>/">Info</a>  </td>
						<td class="nCategory"><a href="<?= $adminurl . "" ?>/">Note</a>  </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>

	</div>

</div>

