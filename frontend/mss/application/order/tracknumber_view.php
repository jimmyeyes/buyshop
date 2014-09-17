<?= $menu ?>

<script>

function check_all(obj,cName) 
{ 
  
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div class="box themed_box">
			<h2 class="box-header">上傳運送編號 </h2>
			<div class="box-content">
			
			 <form action="<?=$url?>order/tracknumber" method="post">
			<labe>  起日期： </label>
			<input class="form-field datepicker" value="<?=$sdate?>"    type="text" name="spdate">
			
			<labe>  訖日期： </label>
			<input class="form-field datepicker" value="<?=$edate?>"   type="text" name="epdate">
			  <input type="submit" value="搜尋" >
			</form>
			
			
			 <form action="<?=$url?>order/updatetrackerbath" method="post"> 	
			<input type='hidden' name ='orderlistid' value='<?=$orderlistid ?>'>
			 <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
				<table class="display" id="tabledata">
                <thead>
                    <tr>
                    <th></th>
                    <th>SN</th>
                    <th>OrderID</th>
                    <th>CreatedTime</th>
                    <th>eBay ITEM-ID/TXN-ID</th>
                    <th>TXN Type</th>
                    <th>buyer</th>
                    <th>AmountPaid</th>
                    <th>QuantityPurchased</th>
                     <th>ShipmentTrackingNumber</th>
                      <th>ShippingCarrierUsed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                    		if($row->Status!="Complete" && $row->txnid=="" )
							continue;
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	<td><input type="checkbox" value="<?= $row->orderlistid ?>" name="chk[]"/></td>
                        	<td class="nCategory"><?=$i?>  </td>	
                        	 <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "" ?>/<?= $row->OrderID ?>"><?= $row->OrderID ?></a></td>
                        	 <td class="nCategory"><?=$row->CreatedTime?>  </td>	
                             <td class="nTitle"><?=$row->ItemID?><br><?=$row->txnid?></td>
                             <td class="nCategory"><?=$row->TRANSACTIONTYPE?>  </td>
                              <td class="nCategory"><?=$row->FIRSTNAME?> <?=$row->LASTNAME?><br /><?=$row->buyerEmail?>  </td>
                            <td class="nCategory"><?=$row->AmountPaid?>  </td>
							<td class="nCategory"><?=$row->QuantityPurchased?>  </td>
							
								<td class="nCategory"><input type="text" name="tracknumber<?= $row->orderlistid ?>" value='<?=$row->tracknumber?>'>  </td>	
								<td class="nCategory"><input type="text" name="carrier<?= $row->orderlistid ?>" value='<?=$row->carrier?>'>  </td>	
							
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
                <input type="submit" value="Update" >
            </form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>

	</div>

</div>

