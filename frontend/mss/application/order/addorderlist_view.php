<?= $menu ?>

<script>



</script>
<div id="subnavbar"></div>
<div id="content">
    <div class="column full">
        <div class="box themed_box">
            <h2 class="box-header"> Order </h2>
            <div class="box-content">
                <form action="<?=$url?>order/addorderlist_update" method="post">
                OrderID:<?=$orderlistid?> <br />

                    <label class="form-label"> Date： </label>
                    <input class="form-field datepicker"  type="text" value="<?=$date?>" name="date">

                    <label class="">TXN Type： </label>
                    <input class="form-field small" type="text" value="<?=$txn?>" name="txn">

                    <label class="">Buyer ： </label>
                    <input class="form-field small" type="text" value="<?=$buyeruserid?>" name="buyerpaypalemail">

                    <label class="">Seller： </label>
                    <input class="form-field small" type="text" value="<?=$selleremail?>" name="sellerpaypalemail">

                    <label class="form-label">  PaymentStatus： </label>
                    <input class="form-field px20" type="text" value="<?=$paystatus?>" name="paystatus">


                    <label class=""> Total paid： </label>
                    <input class="form-field small" type="text" value="<?=$total?>" name="total">

                    <label class=""> Shipping Paid： </label>
                    <input class="form-field small" type="text" value="<?=$shippingpaid?>" name="shippingpaid">

                    <label class="">Buyer Note： </label>
                    <input class="form-field small" type="text" value="<?=$buynote?>" name="buynote">


                    <input type="hidden" value="<?=$orderlistid ?>" name='orderlistid'>
                    <input type="hidden" value="<?=$buyeruserid ?>" name='buyeruserid'>


                    <br /><br />
                    <input type="submit" class="button themed" value="Update" >

                </form>

                <!--

                <form action="<?=$url?>order/addorderlist_prodadd" method="post">
                    <label > 類別名稱 </label>
                    <select id='categoryid' name='categoryid' onchange="SelZero(this.options[this.options.selectedIndex].value);">
                        <option value=''></option>
                        <?
                        $sql = "select m.* from category m order by categoryid asc";
                        //echo $sql;
                        $query = $this->db->query($sql);
                        echo " ";
                        foreach ($query->result() as $row2) {
                            echo "<option value='{$row2->categoryid}' ";
                            echo ">{$row2->category}</option>";
                        }
                        echo "</select>";
                        ?>

                        <label > 品牌 </label>
                        <select id='brandid' name='brandid' onchange="SelZero3(this.options[this.options.selectedIndex].value);">
                        </select>

                        <label>  型號： </label>
                        <select id='model' name="model"   onchange="SelZero2(this.options[this.options.selectedIndex].value);">
                        </select>


                        <label > 品名 </label>
                        <select id='productid' name='productid'  onchange="SelZero4(this.options[this.options.selectedIndex].value);" >
                        </select>

                        <label > 數量 </label>
                        <input class="form-field 20px" type="text" value="" name="qty">

                        </select>

                        <label > 金額 </label>
                        <input class="form-field 20px" type="text" value="" name="amount">

                        </select>
                    <input type="submit" class="button white" value="Add" >

                    <input type="hidden" value="<?=$orderlistid ?>" name='orderlistid'>

                </form>

                <?
                if($num_rows >0){
                ?>
                <table class="display" id="">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>QTY</th>
                        <th>AMOUNT</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($prodlist -> result() as $row) {

                            $i++;
                            $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                            ?>
                            <tr class="<?= $bgColor; ?>">
                                <td><a href="<?=$adminurl?>addorder_delprod/<?=$row -> orderlistprodid?>">DEL</a></td>

                                <td class="nTitle"><?=$row->Title?></td>
                                <td class="nCategory"><?=$row->QuantityPurchased?>  </td>
                                <td class="nCategory"><?=$row->TransactionPrice?>  </td>

                            </tr>
                        <? }?>
                    </tbody>
                </table>

                <? }?>
                <div class="clear"></div>
            </div>

            -->
        </div>
        <div class="clear"></div>
    </div>
</div>
