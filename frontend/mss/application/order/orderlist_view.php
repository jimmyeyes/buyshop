<?= $menu ?>
<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div id="tabs" class="box tabs themed_box">
			<h2 class="box-header"></h2>
			<ul class="tabs-nav">
				<li class="tab"><a href="#tabs-1">待運送</a></li>
				<li class="tab"><a href="#tabs-2">合併運送</a></li>
				<li class="tab"><a href="#tabs-3">待確認</a></li>
				<li class="tab"><a href="#tabs-4">搜尋訂單</a></li>
   				<li class="tab"><a href="#tabs-5">上傳追蹤碼</a></li>
   				<li class="tab"><a href="#tabs-6">退貨清單</a></li>
			</ul>
			<div class="box-content">
				
			 <?php echo form_open_multipart('order/orderlist_adds'); ?>
          	<input class="form-field small" type="text" size="10" name="buyeruserid">
            <input type="submit" class="button white" value="ADD">
            </form>


    <div id="tabs-1">
			<div class="box themed_box">
			<h2 class="box-header">待運送 </h2>
			<div class="box-content">
			 <form action="<?=$url?>order/refreshorderlist" method="post">
 				 <input type="submit" value="Update" >
			</form>
			  <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk1[]')" />全選
			 <form action="<?=$url?>order/updateorderlist" method="post">
			  <select name="modtype">
          		<option value="Reserved">列印出貨單</option>
          		<option value="Shipping">輸入掛號號碼</option>
          		<option value="return">退貨</option>
        </select>
			 <input type='hidden' name ='orderlistid' value='<?=$orderlistids1 ?>'>
				<table class="display" id="">
                <thead>
                    <tr>
                     <th></th>
                     <th>OrderID</th>
                     <th>Date</th>
                     <th>eBay ITEM-ID/TXN-ID</th>
                     <th>TXN Type</th>
                     <th>Buyer</th>
                     <th>Seller</th>
                     <th>PaymentStatus</th>
                     <th>TotalPaid</th>
                     <th>ShippingPaid</th>
                     <th>BuyerNote</th>
                     <th>SellerNote</th>
                     <th>ShippingInformation</th>
                     <th>SellerProtection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {


                    	if($row->transactionidarr=="" && $row->OrderID !="")
	  						         continue;

                      //echo $row->orderlistid;

					           	if($row->backnumber !="" )
  								       continue;

                        //echo $row->orderlistid;

                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        if($row->OrderID ==""){
                    ?>
                      <tr class="<?= $bgColor; ?>">
                        	<td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>

                        	 <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?> </td>
                            <td class="nTitle"> </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                            <td class="nCategory"><?=$row->sellername?>  </td>
                            <td class="nCategory"><?=$row->OrderStatus?>  </td>
                            <td class="nCategory"><?=$row->Total?>  </td>
                            <td class="nCategory"><?=$row->ShippingServiceCost?>USD<br />  </td>
                            <td class="nCategory">
                                <?
                                if($row->BuyerCheckoutMessage!=""){
                                    ?>
                                    <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                <?
                                }
                                ?>
                            </td>
                            <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                <?
                                    $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                    $query=$this->db->query($sql);
                                    $count2=$query->num_rows();
                                    if($count2>0){
                                        echo "(Y)";
                                    } ?></a></td>
                            <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                            <td class="nCategory"> </td>
                            </tr>
                            <?
                        }else{

                            $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and L_NUMBER0 in ($row->itemidarr)";
                            $query=$this->db->query($sql);
                           // echo $sql;
                            
                            foreach($query->result() as $row2){
                                if(($row2->PAYMENTSTATUS!="Completed" ) || ($row->reserved=='1')  && $row->OrderID !="" )
                                    continue;
                                     ?>
                                    <tr class="<?= $bgColor; ?>">
                                    <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>

                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                     <td class="nTitle">
                                    <? foreach($query->result() as $row3){?>
                                    <a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                    <? } ?>
                                    <a target="_blank" href='<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                                    </td>
                                    <td class="nCategory"><?=$row2->TRANSACTIONTYPE?>  </td>
                                    <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row2->PAYMENTSTATUS?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  USD<br /><?=$row2->SHIPTOCOUNTRYNAME?>  </td>
                                    <td class="nCategory">
                                        <?
                                        if($row->BuyerCheckoutMessage!=""){
                                            ?>
                                            <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                            <?
                                        }
                                        ?>
                                     </td>
                                        <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                                <?
                                                $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                                $query=$this->db->query($sql);
                                                $count2=$query->num_rows();
                                                if($count2>0){
                                                    echo "(Y)";
                                                } ?></a></td>
                                        <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                                    <td class="nCategory"><?=$row2->PROTECTIONELIGIBILITY?>  </td>
                            </tr>
                        <? }}}
                    ?>
                </tbody>
            </table>
            
              <input type="submit" value="Submit" class="button white" >
            
            	</form>

				<div class="clear"></div>
			</div>
		</div>
				</div>
		<div id="tabs-2">
					<div class="box themed_box">
			<h2 class="box-header">合併運送 </h2>
			<div class="box-content">
		  <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk2[]')" />全選/全不選

			 <form action="<?=$url?>order/index#tabs-2" method="post">
			
			
			</form>
				
			<form action="<?=$url?>order/updateorderlist" method="post">
			 <input type='hidden' name ='orderlistid' value='<?=$orderlistids2 ?>'>
			 <input type='hidden' name ='type' value='2'>
			 
			   <select name="modtype">
          		<option value="Reserved">列印出貨單</option>
          		<option value="Shipping">輸入掛號號碼</option>
          		<option value="return">退貨</option>

         	 </select>
			 
				<table class="display" id="">
                <thead>
                    <tr>
                   <th></th>
                   <th>OrderID</th>
                     <th>Date</th>
                     <th>eBay ITEM-ID/TXN-ID</th>
                     <th>TXN Type</th>
                     <th>Buyer</th>
                      <th>Seller</th>
                     <th>PaymentStatus</th>
                     <th>TotalPaid</th>
                     <th>ShippingPaid</th>
                     <th>BuyerNote</th>
                     <th>SellerNote</th>
                      <th>ShippingInformation</th>
                     <th>SellerProtection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($querymulti->result() as $row) {
                    	if($row->transactionidarr=="" && $row->OrderID !="")
							continue;
						if($row->backnumber !="" && $row->OrderID !="")
							continue;
                            if($row->OrderID ==""){

                                ?>
                                <tr class="<?= $bgColor; ?>">
                                    <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <td class="nTitle">
                                    </td>
                                    <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                                    <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row->OrderStatus?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  USD<br /><?=$row2->SHIPTOCOUNTRYNAME?>  </td>
                                    <td class="nCategory">
                                        <?
                                        if($row->BuyerCheckoutMessage!=""){
                                            ?>
                                            <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                        <?
                                        }
                                        ?>

                                    </td>
                                    <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                            <?
                                            $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                            $query=$this->db->query($sql);
                                            $count2=$query->num_rows();
                                            if($count2>0){
                                                echo "(Y)";
                                            } ?></a></td>
                                    <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                                    <td class="nCategory"> </td>
                                </tr>
                            <?
                            }else{

                                $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and L_NUMBER0 in ($row->itemidarr)";
                                $query=$this->db->query($sql);
                                //echo $sql."<br />";
                                foreach($query->result() as $row2){
                                    if(($row2->PAYMENTSTATUS!="Completed" ) || ($row->reserved=='1') ){
                                     //   echo $row2->PAYMENTSTATUS."   ddasdfasdf  ".$row->reserved;
                                        continue;
                                    }
                                    $i++;
                                    $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                                   ?>
                                    <tr class="<?= $bgColor; ?>">
                                    <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk2[]"/></td>

                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>                        <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                     <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in ($row->transactionidarr)";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                    <td class="nTitle">
                                        <? foreach($query->result() as $row3){?>
                                        <a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                        <? } ?>
                                        <a target="_blank" href='<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>

                                        </td>   <td class="nCategory"><?=$row2->TRANSACTIONTYPE?>  </td>
                                    <td class="nCategory"><?=$row->Name?><br /><?=$row->BuyerUserID?>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row2->PAYMENTSTATUS?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>USD<br /><?=$row2->SHIPTOCOUNTRYNAME?>  </td>
                                    <td class="nCategory"><a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a> </td>
                                        <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                                <?
                                                $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                                $query=$this->db->query($sql);
                                                $count2=$query->num_rows();
                                                if($count2>0){
                                                    echo "(Y)";
                                                } ?></a></td>
                                        <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                                    <td class="nCategory"><?=$row2->PROTECTIONELIGIBILITY?>  </td>
                                    </tr>
                                        <? }} } ?>
                                </tbody>
                            </table>
                          <input type="submit" value="Submit" class="button white" >
                       </form>
				<div class="clear"></div>
			</div>
		</div>
				</div>
				

			<div id="tabs-3">
			<div class="box themed_box">
			<h2 class="box-header">待確認 </h2>
			<div class="box-content">
			 <form action="<?=$url?>order/bathdel" method="post">

                 <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk4[]')" />全選/全不選
                 <input type="hidden" name="problemqueryids" value="<?=$problemqueryids?>" />
				<table class="display" id="">
                <thead>
                    <tr>
                        <th></th>
                        <th>OrderID</th>
                        <th>Date</th>
                        <th>eBay ITEM-ID/TXN-ID</th>
                        <th>TXN Type</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th>PaymentStatus</th>
                        <th>TotalPaid</th>
                        <th>ShippingPaid</th>
                        <th>BuyerNote</th>
                        <th>SellerNote</th>
                        <th>ShippingInformation</th>
                        <th>SellerProtection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($problemquery->result() as $row) {

                    	if($row->transactionidarr=="")
							continue;

                        if($row->reserved=="1")
                            continue;
						
						if(($row->OrderStatus=="Completed" ) )
								continue;

                      //  echo $row->orderlistid;
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                            <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk4[]"/></td>
                            <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?>  </td>
                            <?
                            $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                            $query=$this->db->query($sql);
                            $count=$query->num_rows();
                            ?>
                            <td class="nTitle">
                                <? foreach($query->result() as $row3){?>
                                    <a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                <? } ?>
                                <a target="_blank" href='<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                            </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                            <td class="nCategory"><?=$row->sellername?>  </td>
                            <td class="nCategory"><?=$row->OrderStatus?>  </td>
                            <td class="nCategory"><?=$row->Total?>  </td>
                            <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  USD </td>
                            <td class="nCategory">
                                <?
                                if($row->BuyerCheckoutMessage!=""){
                                    ?>
                                    <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                <?
                                }
                                ?>

                            </td>
                            <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                    <?
                                    $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                    $query=$this->db->query($sql);
                                    $count2=$query->num_rows();
                                    if($count2>0){
                                        echo "(Y)";
                                    } ?></a></td>
                            <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                            <td class="nCategory"> </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
                 <input type="submit" value="Del" class="button white" >
             </form>
				<div class="clear"></div>
			</div>
		</div>
				</div>
				
		<div id="tabs-4">
			<div class="box themed_box">
			<h2 class="box-header">搜尋訂單 </h2>
			<div class="box-content">

			 <form action="<?=$url?>order/index#tabs-4" method="post">
		
			<labe>  搜尋類型： </label>
			<select name="type">
				<?
				$sql="select * from varlist where type=9";
				$query=$this->db->query($sql);
				foreach ($query->result() as $rowv) {
					?>
					<option
					<?
					if($rowv->no==$type){
						echo "selected";
					}
					?>
					 value="<?=$rowv->no?>"><?=$rowv->name?></option>
					<?
				}
				 ?>
		
			</select>
				
			<labe>  搜尋： </label>
			<input class="form-field"   type="text" value="<?=$keyword?>" name="keyword">
			  <input type="submit" value="搜尋" >
			</form>
		 <form action="<?=$url?>order/updateorderlist" method="post">
			
				<table class="display" >
                <thead>
                    <tr>
                        <th></th>
                        <th>OrderID</th>
                        <th>Date</th>
                        <th>eBay ITEM-ID/TXN-ID</th>
                        <th>TXN Type</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th>PaymentStatus</th>
                        <th>TotalPaid</th>
                        <th>ShippingPaid</th>
                        <th>BuyerNote</th>
                        <th>SellerNote</th>
                        <th>ShippingInformation</th>
                        <th>SellerProtection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
					if($querysearchrownum!=0){
                    foreach ($querysearch->result() as $row) {
                        if($row->transactionidarr !='' && $row->itemidarr!=''){
                        $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and L_NUMBER0 in ($row->itemidarr)";
                        $query=$this->db->query($sql);
                        //echo $sql."<br />";
                        foreach($query->result() as $row2){
                            if(($row2->PAYMENTSTATUS!="Completed" ) || ($row->reserved=='1') ){
                                //   echo $row2->PAYMENTSTATUS."   ddasdfasdf  ".$row->reserved;
                                continue;
                            }
                    	$i++;

                        ?>
                        <tr>

                            <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                            <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?>  </td>
                            <?
                            $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                            $query=$this->db->query($sql);
                            $count=$query->num_rows();
                            ?>
                            <td class="nTitle">
                                <? foreach($query->result() as $row3){?>
                                    <a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                <? } ?>
                                <a target="_blank" href='<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                            </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                            <td class="nCategory"><?=$row->sellername?>  </td>
                            <td class="nCategory"><?=$row->OrderStatus?>  </td>
                            <td class="nCategory"><?=$row->Total?>  </td>
                            <td class="nCategory"><?=$row->ShippingServiceCost?>  USD<br />  </td>
                            <td class="nCategory">
                                <?
                                if($row->BuyerCheckoutMessage!=""){
                                    ?>
                                    <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                <?
                                }
                                ?>

                            </td>
                            <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                    <?
                                    $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                    $query=$this->db->query($sql);
                                    $count2=$query->num_rows();
                                    if($count2>0){
                                        echo "(Y)";
                                    } ?></a></td>
                            <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                            <td class="nCategory"> <?=$row2->PROTECTIONELIGIBILITY?></td>
                        </tr>
                        <? }
                        }else{
                        ?>

                        <tr>

                            <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                            <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?>  </td>

                            <td class="nTitle">

                            </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                            <td class="nCategory"><?=$row->sellername?>  </td>
                            <td class="nCategory"><?=$row->OrderStatus?>  </td>
                            <td class="nCategory"><?=$row->Total?>  </td>
                            <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  USD </td>
                            <td class="nCategory">
                                <?
                                if($row->BuyerCheckoutMessage!=""){
                                    ?>
                                    <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                <?
                                }
                                ?>

                            </td>
                            <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                    <?
                                    $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                    $query=$this->db->query($sql);
                                    $count2=$query->num_rows();
                                    if($count2>0){
                                        echo "(Y)";
                                    } ?></a></td>
                            <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                            <td class="nCategory"> </td>
                        </tr>
                    <?

                        }
                        }}
                    ?>
                </tbody>
            </table>
           </form>
				<div class="clear"></div>
			</div>
		</div>
				</div>
				
		<div id="tabs-5">
			<div class="box themed_box">
			<h2 class="box-header">上傳追蹤碼 </h2>
			<div class="box-content">
			 <form action="<?=$url?>order/index#tabs-5" method="post">
			<labe>  起日期： </label>
			<input class="form-field datepicker" value="<?=$sdate?>"    type="text" name="spdate">
			<labe>  訖日期： </label>
			<input class="form-field datepicker" value="<?=$edate?>"   type="text" name="epdate">
			<input  type="hidden" name="tracksearch"  value="1">
			<input type="submit" value="搜尋" >
			</form>
		
			 <form action="<?=$url?>order/updatetrackerbath" method="post">
		 	  <input type='hidden' name ='orderlistid' value='<?=$orderlistids ?>'>
	 	      <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk4[]')" />全選</p>
				<table class="display" id="">
                <thead>
                    <tr>
                   	 <th></th>
                     <th>OrderID</th>
                     <th>Date</th>
                     <th>eBay ITEM-ID/TXN-ID</th>
                     <th>TXN Type</th>
                     <th>Buyer</th>
                      <th>Seller</th>
                     <th>PaymentStatus</th>
                     <th>TotalPaid</th>
                     <th>ShippingPaid</th>
                     <th>BuyerNote</th>
                     <th>SellerNote</th>
                      <th>ShippingInformation</th>
                     <th>SellerProtection</th>
            
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
					if($querytrachrownum!=0){
                    foreach ($trackerquery->result() as $row) {

                        if($row->transactionidarr !='' && $row->itemidarr!=''){
                            $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and L_NUMBER0 in ($row->itemidarr)";
                            $query=$this->db->query($sql);
                            //echo $sql."<br />";
                            foreach($query->result() as $row2){
                                if(($row2->PAYMENTSTATUS!="Completed" ) || ($row->reserved=='1') ){
                                    //   echo $row2->PAYMENTSTATUS."   ddasdfasdf  ".$row->reserved;
                                    continue;
                                }
                                $i++;


                                $sql="select m.*,r2.name as couriername from tracknumber m left join orderlist r1 on m.orderlistid=r1.orderlistid  ";
                                $sql.=" left join courier r2 on m.courierid= r2.courierid   where m.orderlistid='".$row->orderlistid."'";

                                $countquery=$this->db->query($sql);

                                $count=$countquery->num_rows();
                                if($count ==0){
                                    continue;
                                }

                                ?>
                                <tr>

                                    <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk4[]"/></td>
                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                    <td class="nTitle">
                                        <? foreach($query->result() as $row3){?>
                                            <a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                        <? } ?>
                                        <a target="_blank" href='<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                                    </td>
                                    <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                                    <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row->OrderStatus?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory"><?=$row->ShippingServiceCost?>  USD<br />  </td>
                                    <td class="nCategory">
                                        <?
                                        if($row->BuyerCheckoutMessage!=""){
                                            ?>
                                            <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                        <?
                                        }
                                        ?>

                                    </td>

                                    <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                            <?
                                            $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                            $query=$this->db->query($sql);
                                            $count2=$query->num_rows();
                                            if($count2>0){
                                                echo "(Y)";
                                            } ?></a></td>
                                    <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                                    <td class="nCategory"> <?=$row2->PROTECTIONELIGIBILITY?></td>
                                </tr>
                            <? }
                        }else{
                            ?>

                            <tr>

                                <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                                <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                <td class="nCategory"><?=$row->CreatedTime?>  </td>

                                <td class="nTitle">

                                </td>
                                <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                                <td class="nCategory"><?=$row->Name?> <br /><?=$row->BuyerUserID?>  </td>
                                <td class="nCategory"><?=$row->sellername?>  </td>
                                <td class="nCategory"><?=$row->OrderStatus?>  </td>
                                <td class="nCategory"><?=$row->Total?>  </td>
                                <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  USD </td>
                                <td class="nCategory">
                                    <?
                                    if($row->BuyerCheckoutMessage!=""){
                                        ?>
                                        <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                    <?
                                    }
                                    ?>

                                </td>
                                <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                        <?
                                        $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                        $query=$this->db->query($sql);
                                        $count2=$query->num_rows();
                                        if($count2>0){
                                            echo "(Y)";
                                        } ?></a></td>
                                <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                                <td class="nCategory"> </td>
                            </tr>
                        <?

                        }}
                        }
                    ?>
                </tbody>
            </table>
                 <br />
                <input type="submit" value="Update" class="button themed" >
            </form>
				<div class="clear"></div>
			</div>
			</div>
			   </div>
			   
			   <div id="tabs-6">
					<div class="box themed_box">
			<h2 class="box-header">退貨清單 </h2>
			<div class="box-content">

			 <form action="<?=$url?>order/index#tabs-6" method="post">
			
			
			</form>
				
			<form action="<?=$url?>order/updateorderlist" method="post">
			 <input type='hidden' name ='orderlistid' value='<?=$orderlistids2 ?>'>
			 <input type='hidden' name ='type' value='2'>
				<table class="display" id="">
                <thead>
                    <tr>

                         <th>OrderID</th>
                         <th>Date</th>
                         <th>eBay ITEM-ID/TXN-ID</th>
                         <th>TXN Type</th>
                         <th>Buyer</th>
                         <th>Seller</th>
                         <th>PaymentStatus</th>
                         <th>TotalPaid</th>
                         <th>ShippingPaid</th>
                         <th>BuyerNote</th>
                         <th>SellerNote</th>
                         <th>ShippingInformation</th>
                         <th>SellerProtection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($backquery->result() as $row) {
                    	if($row->transactionidarr=="")
							continue;
						
						$sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and L_NUMBER0 in ($row->itemidarr)";
						$query=$this->db->query($sql);
						//echo $sql."<br />";
						foreach($query->result() as $row2){

                    		if(($row2->PAYMENTSTATUS!="Completed" ) || ($row->reserved=='1') ){
                    			//echo $row2->PAYMENTSTATUS."   ddasdfasdf  ".$row->reserved;	
								continue;
							}
							if($row->backnumber =="")
								continue;
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">

						<td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                        <td class="nCategory"><?=$row->CreatedTime?>  </td>
                         <?
                        $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in ($row->transactionidarr)";
                        $query=$this->db->query($sql);
						$count=$query->num_rows();
                        ?>
                        <td class="nTitle">
                        	<? foreach($query->result() as $row3){?>
                        	<a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                        	<? } ?>
                        	<a target="_blank" href='<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                        	
                        	</td>
                         <td class="nCategory"><?=$row2->TRANSACTIONTYPE?>  </td>
                        <td class="nCategory"><?=$row->Name?><br /><?=$row->BuyerUserID?>  </td>
                        <td class="nCategory"><?=$row->sellername?>  </td>
                        <td class="nCategory"><?=$row2->PAYMENTSTATUS?>  </td>
                        <td class="nCategory"><?=$row->Total?>  </td>
						<td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>USD<br /><?=$row2->SHIPTOCOUNTRYNAME?>  </td>	
						<td class="nCategory"><a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a> </td>

                            <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note
                                    <?
                                    $sql="select * from ordernote where orderlistid='".$row->orderlistid."'";
                                    $query=$this->db->query($sql);
                                    $count2=$query->num_rows();
                                    if($count2>0){
                                        echo "(Y)";
                                    } ?></a></td>
                            <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
						<td class="nCategory"><?=$row2->PROTECTIONELIGIBILITY?>  </td>	
                        </tr>
                        <? }}  ?>
                </tbody>
            </table>
            
           </form>
				<div class="clear"></div>
			</div>
		</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
