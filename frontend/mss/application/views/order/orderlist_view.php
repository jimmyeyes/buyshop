
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Order
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Order</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>




<div class="portlet box blue tabbable">
<div class="portlet-title">
    <div class="caption">
        <i class="fa fa-reorder"></i>
    </div>
</div>
<div class="portlet-body">
        <div class="tabbable portlet-tabs">
        <ul class="nav nav-tabs">

            <li class="tab active"><a data-toggle="tab" href="#tabs-1">待運送</a></li>
            <li class="tab"><a data-toggle="tab" href="#tabs-2">合併運送</a></li>
            <li class="tab"><a data-toggle="tab" href="#tabs-3">待確認</a></li>

            <li class="tab"><a data-toggle="tab" href="#tabs-4">搜尋訂單</a></li>


            <li class="tab"><a data-toggle="tab" href="#tabs-5">上傳追蹤碼</a></li>
            <!--
            <li class="tab"><a data-toggle="tab" href="#tabs-6">退貨清單</a></li> -->
			</ul>
        <div class="tab-content">

    <div class="tab-pane active"  id="tabs-1">

			 <form action="<?=$url?>order/refreshorderlist" method="post">
 				 <input type="submit" value="Update" class="btn red" >
			</form>
			 <form action="<?=$url?>order/updateorderlist" method="post">
                    <input type='hidden' name ='type' value='1' />
			 <!-- <select class="layout-option form-control input-small" name="modtype">

                    <option value="print">列印出貨單</option>
                    <option value="Shipping">輸入掛號號碼</option>
                    <option value="return">退貨</option>

              </select>-->
			 <input type='hidden' name ='orderlistid' value='<?=$orderlistids1 ?>'>
                 <table class="table table-striped table-bordered table-hover" id="">
                <thead>
                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                        </th>
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
                        	<td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>

                        	 <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?> </td>
                            <td class="nTitle"> </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                          <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
                            <td class="nCategory"><?=$row->sellername?>  </td>
                            <td class="nCategory"><?=$row->OrderStatus?>  </td>
                            <td class="nCategory"><?=$row->Total?>  </td>
                            <td class="nCategory"><?=$row->ShippingServiceCost?> USD<br />  </td>
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

                            $sql="select * from paypalTransactionDetail  where L_EBAYITEMTXNID0 in ($row->transactionidarr) and itemidarr in ($row->itemidarr)";
                            $query=$this->db->query($sql);
                           // echo $sql;
                            
                            foreach($query->result() as $row2){
                                if(($row2->PAYMENTSTATUS!="Completed" ) || ($row->reserved=='1')  && $row->OrderID !="" )
                                    continue;
                                     ?>
                                    <tr class="<?= $bgColor; ?>">
                                    <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>

                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a>

                                        <?
                                      /*  $sql="  SELECT * FROM `orderlist` m left join paypalTransactionDetail r1 on L_EBAYITEMTXNID0 in (m.transactionidarr) and L_NUMBER0 in (m.itemidarr)";
                                        $sql.=" left join orderlistprod r2 on r2.orderlistid =m.orderlistid";
                                        $sql.=" where r1.`SHIPTONAME` !=''  and r2.SKU !='' and m.orderlistid='".$row->orderlistid."'";
                                        $dhlcount=$this->db->query($sql)->num_rows();

                                        if($dhlcount>0){
                                            echo "<a href='".$adminurl."dhl_call/$row->orderlistid' >(R)</a>";
                                        }

                                        $sql="select * from dhlserviceresponse where orderlistid  ='".$row->orderlistid."'";
                                        $dhlcount=$this->db->query($sql)->num_rows();

                                        if($dhlcount>0){
                                            echo "<a href='".$adminurl."dhl_label/$row->orderlistid' target='_blank'>(D)</a>";
                                        }*/

                                        ?>
                                    </td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                     <td class="nTitle">
                                    <? foreach($query->result() as $row3){?>
                                    <a target="_blank" href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                    <? } ?>
                                    <a target="_blank" href='https://www.paypal.com/us/vst/id=<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                                    </td>
                                    <td class="nCategory"><?=$row2->TRANSACTIONTYPE?>  </td>
                                        <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row2->PAYMENTSTATUS?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  <?=$row2->CURRENCYCODE?> <br /><?=$row2->SHIPTOCOUNTRYNAME?>  </td>
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
                                        <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>

                                        </td>
                                    <td class="nCategory"><?=$row2->PROTECTIONELIGIBILITY?>  </td>
                            </tr>
                        <? }}}
                    ?>
                </tbody>
            </table>
            
              <input type="submit" value="Submit" class="btn blue" >
            
           </form>


		</div>
		<div class="tab-pane"  id="tabs-2">

			 <form action="<?=$url?>order/index#tabs-2" method="post">

			</form>
				
			<form action="<?=$url?>order/updateorderlist" method="post">
			 <input type='hidden' name ='orderlistid' value='<?=$orderlistids2 ?>'>
			 <input type='hidden' name ='type' value='2'>
			 
			   <select  class="layout-option form-control input-small" name="modtype">
                    <option value="print">列印出貨單</option>
                    <option value="Shipping">輸入掛號號碼</option>
                    <option value="return">退貨</option>
         	     </select>

                <table class="table table-striped table-bordered table-hover" id="sample_3">
                <thead>
                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
                        </th>
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
                                    <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <td class="nTitle">
                                    </td>
                                    <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                                    <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row->OrderStatus?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>

                                    <?
                                    $count="0";

                                    ?>

                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  USD<br />  </td>
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
                                    <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk2[]"/></td>

                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>                        <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                     <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in ($row->transactionidarr)";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                    <td class="nTitle">
                                        <? foreach($query->result() as $row3){?>
                                        <a target="_blank" href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                        <? } ?>
                                        <a target="_blank" href='https://www.paypal.com/us/vst/id=<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>

                                        </td>   <td class="nCategory"><?=$row2->TRANSACTIONTYPE?>  </td>
                                        <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
                                    <td class="nCategory"><?=$row->sellername?>  </td>
                                    <td class="nCategory"><?=$row2->PAYMENTSTATUS?>  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>  <?=$row2->CURRENCYCODE?><br /><?=$row2->SHIPTOCOUNTRYNAME?>  </td>
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
                          <input type="submit" value="Submit" class="btn blue" >
                       </form>

			</div>
				

			<div class="tab-pane" id="tabs-3">

			 <form action="<?=$url?>order/bathdel" method="post">

                 <input type="hidden" name="problemqueryids" value="<?=$problemqueryids?>" />
                 <table class="table table-striped table-bordered table-hover" id="sample_4">

                 <thead>
                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_4 .checkboxes"/>
                        </th>
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
                            <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk4[]"/></td>
                            <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?>  </td>
                            <?
                            $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                            $query=$this->db->query($sql);
                            $count=$query->num_rows();
                            ?>
                            <td class="nTitle">
                                <? foreach($query->result() as $row3){?>
                                    <a target="_blank" href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                <? } ?>

                            </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
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
                 <input type="submit" value="Del" class="btn blue" >
             </form>

		</div>

		<div class="tab-pane" id="tabs-4">

			 <form action="<?=$url?>order/index#tabs-4" method="post">
		
			<label>  搜尋類型： </label>
			<select class="form-control input-medium select2me"  name="type">
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
				
			<label>  搜尋： </label>
			<input class="form-control"   type="text" value="<?=$keyword?>" name="keyword">
			  <input type="submit" value="搜尋" class="btn blue" >
			</form>
		 <form action="<?=$url?>order/updateorderlist" method="post">
             <table class="table table-striped table-bordered table-hover" id="sample_5">
                <thead>
                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_5 .checkboxes"/>
                        </th>
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

                            <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                            <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?>  </td>
                            <?
                            $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                            $query=$this->db->query($sql);
                            $count=$query->num_rows();
                            ?>
                            <td class="nTitle">
                                <? foreach($query->result() as $row3){?>
                                    <a target="_blank" href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                <? } ?>
                                <a target="_blank" href='https://www.paypal.com/us/vst/id=<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                            </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
                            <td class="nCategory"><?=$row->sellername?>  </td>
                            <td class="nCategory"><?=$row->OrderStatus?>  </td>
                            <td class="nCategory"><?=$row->Total?>  </td>
                            <td class="nCategory"><?=$row->ShippingServiceCost?>   <?=$row2->CURRENCYCODE?><br />  </td>
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

                            <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                            <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                            <td class="nCategory"><?=$row->CreatedTime?>  </td>

                            <td class="nTitle">

                            </td>
                            <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
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

		</div>

		<div class="tab-pane" id="tabs-5">

			 <form action="<?=$url?>order/index#tabs-5" method="post">


                 <div class="form-group">

                     <div class="col-md-4">
                         <div class="input-group input-large date-picker input-daterange" data-date="<?=$sdate?>" data-date-format="yyyy-mm-dd">
                             <input type="text"  value="<?=$sdate?>" class="form-control" name="spdate">
												<span class="input-group-addon">
													to
												</span>
                             <input type="text" value="<?=$edate?>" class="form-control" name="epdate">
                         </div>

											<span class="help-block">
												Select date range
											</span>
                     </div>



                    <input  type="hidden" name="tracksearch"  value="1">
                    <input type="submit" value="搜尋" class="btn blue" >
                    </div>
			</form>

            <div class="clearfix">
            </div>

            <form action="<?=$url?>order/updatetrackerbath" method="post">
		 	  <input type='hidden' name ='orderlistid' value='<?=$orderlistids ?>'>

                 <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_6 .checkboxes"/>
                        </th>
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

                                    <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk4[]"/></td>
                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid' and ItemID in ($row->itemidarr) and TransactionID in (".$row->transactionidarr.")";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                    <td class="nTitle">
                                        <? foreach($query->result() as $row3){?>
                                            <a target="_blank" href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                        <? } ?>
                                        <a target="_blank" href='https://www.paypal.com/us/vst/id=<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                                    </td>
                                    <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                                    <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
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

                                <td><input class="checkboxes" type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>
                                <td class="nTitle"><a target="_blank" href='<?= $adminurl . "ordershipinfo" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                <td class="nCategory"><?=$row->CreatedTime?>  </td>

                                <td class="nTitle">

                                </td>
                                <td class="nCategory"><?=$row->PaymentMethods?>  </td>
                                <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
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
                <input type="submit" value="Update" class="btn blue" >
            </form>

			 </div>
    <!--

			 <div class="tab-pane" id="tabs-6">

			 <form action="<?=$url?>order/index#tabs-6" method="post">
			
			
			</form>
				
			<form action="<?=$url?>order/updateorderlist" method="post">
			 <input type='hidden' name ='orderlistid' value='<?=$orderlistids2 ?>'>
			 <input type='hidden' name ='type' value='2'>
                <table class="table table-striped table-bordered table-hover" id="sample_7">
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
                        	<a target="_blank" href='http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                        	<? } ?>
                        	<a target="_blank" href='https://www.paypal.com/us/vst/id=<?=$row2->TRANSACTIONID?>'><?=$row2->TRANSACTIONID?></a>
                        	
                        	</td>
                         <td class="nCategory"><?=$row2->TRANSACTIONTYPE?>  </td>
                            <td class="nCategory"><?=$row->Name?> <br /> <a target="_blank" href='http://cgi6.ebay.com/ws/eBayISAPI.dll?ViewBidItems&all=1&_rdc=1&userid=<?=$row->BuyerUserID?>&&rows=25&completed=1&sort=3&guest=1'><?=$row->BuyerUserID?></a>  </td>
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
			</div>

        -->
		</div>
	</div>
</div>
</div>

