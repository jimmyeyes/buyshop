<?= $menu ?>
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
                     <th>CreatedTime</th>
                     <th>eBay ITEM-ID/TXN-ID</th>
                     <th>TXN Type</th>
                     <th>buyer</th>
                     <th>AmountPaid</th>
                     <th>Status</th>
                     <th>QuantityPurchased</th>
                     <th>BuyerUserID</th>
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
                        <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "" ?>/<?= $row->OrderID ?>"><?= $row->OrderID ?></a></td>
                        <td class="nCategory"><?=$row->CreatedTime?>  </td>	
                         <td class="nTitle"><?=$row->ItemID?><br><?=$row->txnid?></td>
                         <td class="nCategory"><?=$row->TRANSACTIONTYPE?>  </td>
                         <td class="nCategory"><?=$row->FIRSTNAME?> <?=$row->LASTNAME?><br /><?=$row->buyerEmail?>  </td>
                         <td class="nCategory"><?=$row->AmountPaid?>  </td>
                         <td class="nCategory"><?=$row->Status?>  </td>
						<td class="nCategory"><?=$row->QuantityPurchased?>  </td>	
						<td class="nCategory"><?=$row->BuyerUserID?>  </td>	
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
