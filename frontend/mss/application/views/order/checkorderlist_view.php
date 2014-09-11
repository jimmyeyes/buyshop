<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>手動增加訂單
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

                <form action="<?=$url?>order/updateorderlist" method="post">
                    <input type='hidden' name ='orderlistid' value='<?=$orderlistids1 ?>'>
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
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


                                $i++;
                                $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                                ?>
                                <tr class="<?= $bgColor; ?>">
                                    <td><input type="checkbox" value="<?=$row->orderlistid ?>" name="chk1[]"/></td>

                                    <td class="nTitle"><a target="_blank" href='<?= $adminurl . "addorderlist_detail" ?>/<?=$row->orderlistid?>'><?=$row->orderlistid?></a></td>
                                    <td class="nCategory"><?=$row->CreatedTime?>  </td>
                                    <?
                                    $sql="select * from orderlistprod where orderlistid='$row->orderlistid'";
                                    $query=$this->db->query($sql);
                                    $count=$query->num_rows();
                                    ?>
                                    <td class="nTitle">
                                        <? foreach($query->result() as $row3){?>
                                            <a target="_blank" href='http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?=$row3->ItemID?>'><?=$row3->ItemID."($row3->QuantityPurchased)"?></a><br>
                                        <? } ?>

                                    </td>
                                    <td class="nCategory"> </td>
                                    <td class="nCategory"><?=$row->BuyerUserID?>  </td>
                                    <td class="nCategory">  </td>
                                    <td class="nCategory">  </td>
                                    <td class="nCategory"><?=$row->Total?>  </td>
                                    <td class="nCategory">X<?=$count."   "?><?=$row->ShippingServiceCost?>USD<br />  </td>
                                    <td class="nCategory">
                                        <?
                                        if($row->BuyerCheckoutMessage!=""){
                                            ?>
                                            <a href="<?= $adminurl . "buyernote" ?>/<?=$row->orderlistid?>" >Note</a>
                                        <?
                                        }


                                        ?>

                                    </td>
                                    <td class="nCategory"><a href="<?= $adminurl . "ordernote" ?>/<?=$row->orderlistid?>">Note</a>   </td>
                                    <td class="nCategory"><a href="<?= $adminurl . "shippinginfo" ?>/<?=$row->orderlistid?>">Input Shipping</a>  </td>
                                    <td class="nCategory">  </td>
                                </tr>
                            <? }
                        ?>
                        </tbody>
                    </table>



                </form>



     </div>
</div>
