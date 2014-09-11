<?= $menu ?>
<script>
function check_all(obj,cName) 
{ 
	
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 

</script>
<div id="subnavbar">
</div>
<div id="content">
        <div class="box themed_box">
        <h2 class="box-header"> 新增商品</h2>
        <div class="box-content">
            <?php echo form_open_multipart('product/product_adds'); ?>
           <input class="form-field small" type="text"  name="name">
            <input type="submit" class="button white" value="ADD">
            </form>
        </div>
        </div>


        <div id="tabs" class="box tabs themed_box">
        <h2 class="box-header"></h2>
        <ul class="tabs-nav">
            <li class="tab"><a href="#tabs-1">商品列表</a></li>
            <li class="tab"><a href="#tabs-2">eBay Active</a></li>
            <li class="tab"><a href="#tabs-3">待上傳</a></li>

        </ul>
        <div class="box-content">



        <div id="tabs-1">
            <div class="box themed_box">
                <h2 class="box-header">商品列表 </h2>
                <div class="box-content">


               <!--    <a  class="button white" href="<?=$url?>product/ebayitemlist" >查看上傳列表</a>
                    <a  class="button white" href="<?=$url?>product/prodtoebay" >查看待上傳列表</a> -->

                    <form action="<?=$url?>product/product_bath" method="post">
                        <input type='hidden' name ='productid' value='<?=$productid ?>'>
                        <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選

                            <select name="modtype">

                                <option value="1">編輯</option>
                                <option value="3">加入上傳至ebay</option>
                                <option value="2">刪除</option>
                            </select>
                        </p>

                        <table class="display" id="tabledata">
                            <thead>
                            <tr>
                                <th></th>
                                <!--	<th>操作</th> -->
                                <th>類別名稱</th>
                                <th>品牌</th>
                                <th>品名</th>
                                <th>型號</th>
                                <th>SKU</th>
                                <th>EAN</th>
                                <th>UPC</th>
                                <th>MPN</th>

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
                                    <td><input type="checkbox" value="<?=$row->productid ?>" name="chk[]"/></td>
                                    <!--	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "product_del" ?>/<?= $row->productid ?>">刪除</a></td> -->
                                    <td class="nCategory"><?=$row->category?>  </td>
                                    <td class="nCategory"><?=$row->brand?>  </td>
                                    <td class="nTitle"><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>
                                    <td class="nCategory"><?=$row->model?>  </td>
                                    <td class="nCategory"><?=$row->sku?></td>
                                    <td class="nCategory"> <?=$row->ean?> </td>
                                    <td class="nCategory"><?=$row->upc?></td>
                                    <td class="nCategory"><?=$row->mpn?></td>
                                </tr>
                            <? }
                            ?>
                            </tbody>
                        </table>

                        <br /> <br />

                        <input type="submit" class="button themed" value="Submit">
                    </form>

                    <div class="clear"></div>
                </div>
            </div>

            <div class="box themed_box">
                <h2 class="box-header">商品類別</h2>
                <div class="box-content">
                    <table class="display" id="tabledata1">
                        <thead>
                        <tr>
                            <th>操作</th>
                            <th>類別名稱</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        foreach ($querycate->result() as $row) {
                            $i++;
                            $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                            ?>
                            <tr class="<?= $bgColor; ?>">
                                <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "category_del" ?>/<?= $row->category ?>">刪除</a></td>
                                <td class="nCategory"><a  href="<?= $adminurl . "productcate" ?>/<?= $row->categoryid ?>"><?=$row->category?></a>  </td>

                            </tr>
                        <? }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>



       
            <div id="tabs-2">
                <div class="box themed_box">
                    <h2 class="box-header">eBay Active </h2>
                    <div class="box-content">
                        <form action="<?=$url?>product/getEbayactive" method="post">
                            <input type="submit" value="Update" >
                        </form>

                        <?php
                        $i = 2;
                        foreach ($querypro2->result() as $rowid) {
                            $sql="select * from productonebay m where  m.on=1 and m.accounttokenid='".$rowid->accounttokenid."' ";
                            $count=$this->db->query($sql)->num_rows();
                            if($count ==0)
                                continue;
                            echo "<h2>".$rowid->username."</h2><br>";

                            $sql="select DISTINCT (r1.productid), r1.* from productonebay m left join product r1 on m.productid=r1.productid left join accounttoken r2 on r2.accounttokenid=r1.accounttokenid  where r1.productid is not null and m.on=1 and m.accounttokenid='".$rowid->accounttokenid."' ";
                          //  echo $sql;
                            $query = $this -> db -> query($sql);
                            $string="";
                            foreach($query->result() as $row){
                                if($string==""){
                                    $string=$row->productid;
                                }else{
                                    $string.=",".$row->productid;
                                }
                            }
                            $productid=$string;

                            ?>

                    <form action="<?=$url?>product/productonebayupdate_bath" method="post">
                    <input type='hidden' name ='productid' value='<?=$productid ?>'>
                       <input type='hidden' name ='accounttokenid' value='<?=$rowid->accounttokenid ?>'>

                        <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選

                        <table class="display" id="tabledata<?=$i?>">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th width="40%">品名</th>
                                <th>數量</th>

                                <?
                                if($rowid->Currency=="USD"){
                                    ?>
                                    <th>USD</th>
                                <?

                                }else if($rowid->Currency=="GBP"){

                                    ?>
                                    <th>AUD</th>
                                <?

                                }else if($rowid->Currency=="AUD"){
                                    ?>
                                    <th>GBP</th>
                                <?
                                }
                                ?>
                                <!--  <th>END Date</th> -->
                            </tr>
                            </thead>
                            <tbody>
                                <?
                                $i++;
                                $sql="select DISTINCT (r1.productid), m.ItemID,r1.* from productonebay m left join product r1 on m.productid=r1.productid left join accounttoken r2 on r2.accounttokenid=r1.accounttokenid  where r1.productid is not null and m.on=1 and m.accounttokenid='".$rowid->accounttokenid."' ";
                              //  echo $sql;
                                $query=$this->db->query($sql);
                                foreach($query->result() as $row){
                                ?>
                                <tr class="">


                                    <td><input type="checkbox" value="<?=$row->productid ?>" name="chk[]"/></td>

                                    <td class="nCategory">

                                            <a href="<?= $adminurl . "updateebayitem" ?>/<?= $row->productid ?>/<?=$rowid->accounttokenid?>">  <img style='border:2px solid #000000' src='<?=$row->picurl?>' width="50px" height="50px" /></a>
                                    </td>
                                    <!--	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "product_del" ?>/<?= $row->productid ?>">刪除</a></td> -->
                                    <td class="nTitle"><a href="<?= $adminurl . "updateebayitem" ?>/<?= $row->productid ?>/<?=$rowid->accounttokenid?>"><?= $row->ebaytitle ?></a></td>
                                    <td class="nCategory"><input type="text" value="<?=$row->Quantity ?>" name="Quantity<?= $row->productid ?>"/>  </td>

                                    <?
                                    if($rowid->Currency=="USD"){
                                        ?>
                                        <td class="nCategory"><input type="text" value="<?=$row->StartPrice ?>" name="StartPrice<?= $row->productid ?>"/></td>

                                    <?

                                    }else if($rowid->Currency=="GBP"){

                                        ?>
                                        <td class="nCategory"><input type="text" value="<?=$row->PriceAUD ?>" name="PriceAUD<?= $row->productid ?>"/> </td>
                                    <?
                                    }else if($rowid->Currency=="AUD"){
                                        ?>
                                        <td class="nCategory"><input type="text" value="<?=$row->PriceGBP ?>" name="PriceGBP<?= $row->productid ?>"/> </td>
                                    <?}
                                    ?>

                                    <input type="hidden" value="<?=$row->ItemID ?>" name="itemid<?= $row->productid ?>"/>

                                </tr>
                                <? }
                                ?>
                            </tbody>
                        </table>

                
                            <input type="submit" class="button themed" value="Submit">
                            </form>

                            

                        <? 
                            }
                        ?>

                        <div class="clear"></div>
                    </div>
                </div>

     
            </div>

            <div id="tabs-3">

            <div class="box themed_box">
            <h2 class="box-header">待上傳 </h2>
            <div class="box-content">

                <form action="<?=$url?>product/product_ebayuploadbath" method="post">

                    <input type='hidden' name ='productid' value='<?=$productid3 ?>'>
                    <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk3[]')" />全選</p>

                    <table class="display" id="tabledata">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>品名</th>
                            <th>天數</th>
                            <th>SKU</th>
                            <th>USD</th>
                            <th>AUD</th>
                            <th>GBP</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        foreach ($query3->result() as $row) {
                            $i++;
                            $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                            ?>
                            <tr class="<?= $bgColor; ?>">
                                <td class="nTitle"> <a  href="<?= $adminurl . "product_toebaydel/".$row->prodtoebayid ?>">DEL</a></td>
                                <td><input type="checkbox" value="<?=$row->productid ?>" name="chk3[]"/></td>
                                <td>

                                    <?
                                    $sql="select * from product_img where proid='$row->productid' limit 1";
                                    $queryimg=$this->db->query($sql);
                                    foreach($queryimg->result() as $rowimg){
                                    ?>
                                    <img  style='border:2px solid #000000' width="50px"  src="<?php echo base_url() . $rowimg->url; ?>" />
                                    <?
                                    }
                                    ?>

                                </td>

                                <td class="" width="40%"> <a  href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>#tabs-2"><?=$row->ebaytitle?></a></td>
                                <td class="nCategory">  <?=$row->ListingDuration?> </td>
                                <td class="nCategory"> <a  href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>#tabs-2"><?=$row->sku?></a></td>
                                <td class="nCategory"><?=$row->StartPrice?> </td>
                                <td class="nCategory"><?=$row->PriceAUD?> </td>
                                <td class="nCategory"><?=$row->PriceGBP?> </td>
                            </tr>
                        <? }
                        ?>
                        </tbody>
                    </table>

                    <br /> <br />
                    <label class="form-label"> ebay ID: </label>
                    <select name="accounttokenid">
                        <?  $sql="select * from  accounttoken  ";
                        $query=$this->db->query($sql);
                        foreach($query->result() as $rowv){
                            ?>
                            <option  value='<?=$rowv->accounttokenid?>'><?=$rowv->username."-".$rowv->Currency?></option>
                        <? }?>
                    </select>



                    <input type="submit"  class="button white" value="上架" />

                </form>


                    <div class="clear"></div>
            </div>

            </div>
            </div>
          </div>
        </div>
</div>