<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i> OrderID:<?=$orderlistid?>
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

                <form action="<?=$url?>order/addorderlist_update" method="post">

                    <label class="form-label"> Date： </label>

                    <div class="input-group input-medium date date-picker " data-date="v"  data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                        <input type="text" name="date" class="form-control" value="<?=$date?>" readonly>
                                 <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                    </div>

                    <label class="">Buyer ： </label>
                    <input class="form-control" type="text" value="<?=$buyeruserid?>" name="buyerpaypalemail">

                    <label class="">Seller： </label>
                    <input class="form-control" type="text" value="<?=$selleremail?>" name="sellerpaypalemail">

                    <label class="form-label">  PaymentStatus： </label>
                    <input class="form-control" type="text" value="<?=$paystatus?>" name="paystatus">


                    <label class=""> Product Fee： </label>
                    <input class="form-control" type="text" value="<?=$total?>" name="total">

                    <label class=""> Shipping Fee： </label>
                    <input class="form-control" type="text" value="<?=$shippingpaid?>" name="shippingpaid">

                    <label class="">Buyer Note： </label>
                    <input class="form-control" type="text" value="<?=$buynote?>" name="buynote">


                    <input type="hidden" value="<?=$orderlistid ?>" name='orderlistid'>
                    <input type="hidden" value="<?=$buyeruserid ?>" name='buyeruserid'>


                    <br /><br />
                    <input type="submit" class="btn blue" value="Add" >

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
</div>
