<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            eBay
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">eBay</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <a href="#">Active</a>
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
    <div class="tabbable portlet-tabs"  id="tabs">
            <ul class="nav nav-tabs">

                <?   if (($authority & 2048) == 2048) { ?>


                    <li class="tab active"><a data-toggle="tab" href="#tabs-2">eBay Active</a></li>
                    <li class="tab"><a  data-toggle="tab"href="#tabs-3">Awaiting Upload</a></li>
                <?}?>
            </ul>
        <div class="tab-content">



            <?   if (($authority & 2048) == 2048) { ?>

                <div  class="tab-pane active" id="tabs-2">

                            <form action="<?=$url?>product/getEbayactive" method="post">
                                <input class="btn gray" type="submit" value="Update" >
                            </form>

                            <?php
                            $i = 2;
                            foreach ($querypro2->result() as $rowid) {
                                $sql="select * from productonebay m where  m.on=1 and m.accounttokenid='".$rowid->accounttokenid."' ";
                                $count=$this->db->query($sql)->num_rows();
                                if($count ==0)
                                    continue;
                               // echo "<h2></h2><br>";

                                $sql="select DISTINCT (r1.productactiveid), r1.* from productonebay m left join productactive r1 on m.productid=r1.productactiveid left join accounttoken r2 on r2.accounttokenid=r1.accounttokenid  where r1.productactiveid is not null and m.on=1 and m.accounttokenid='".$rowid->accounttokenid."' ";
                                //  echo $sql;
                                $query = $this -> db -> query($sql);
                                $string="";
                                foreach($query->result() as $row){
                                    if($string==""){
                                        $string=$row->productactiveid;
                                    }else{
                                        $string.=",".$row->productactiveid;
                                    }
                                }
                                $productid=$string;

                                ?>

                                <form action="<?=$url?>product/productonebayupdate_bath" method="post">
                                    <input type='hidden' name ='productid' value='<?=$productid ?>'>
                                    <input type='hidden' name ='accounttokenid' value='<?=$rowid->accounttokenid ?>'>


                                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="portlet box grey">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-user"></i><?=$rowid->username?>
                                            </div>
                                            <div class="actions">
                                                <div class="btn-group">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_<?=$i?>">
                                        <thead>
                                        <tr>
                                            <th>  <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/></th>
                                            <th>PIC</th>
                                            <th width="40%">品名</th>
                                            <th>數量</th>

                                            <th>幣別</th>
                                            <!--  <th>END Date</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                        $i++;
                                        $sql="select DISTINCT (r1.productactiveid), m.ItemID,r1.* from productonebay m left join productactive r1 on m.productid=r1.productactiveid left join accounttoken r2 on r2.accounttokenid=r1.accounttokenid  where r1.productactiveid is not null and m.on=1 and m.accounttokenid='".$rowid->accounttokenid."' ";
                                        //  echo $sql;
                                        $query=$this->db->query($sql);
                                        foreach($query->result() as $row){
                                            ?>
                                            <tr class="">


                                                <td><input type="checkbox" value="<?=$row->productactiveid ?>" name="chk[]"/></td>

                                                <td >

                                                    <a href="<?= $adminurl . "updateebayitem" ?>/<?= $row->productactiveid ?>/<?=$rowid->accounttokenid?>">  <img style='border:2px solid #000000' src='<?=$row->picurl?>' width="50px" height="50px" /></a>
                                                </td>
                                                <!--	 <td ><a onClick="return check();" href="<?= $adminurl . "product_del" ?>/<?= $row->productactiveid ?>">刪除</a></td> -->
                                                <td ><a href="<?= $adminurl . "updateebayitem" ?>/<?= $row->productactiveid ?>/<?=$rowid->accounttokenid?>"><?= $row->ebaytitle ?></a></td>
                                                <td ><input type="text" class="form-control"  value="<?=$row->Quantity ?>" name="Quantity<?= $row->productactiveid ?>"/>  </td>


                                                <?

                                                $currname="";
                                                $price="";
                                                if($row->currencyID=="USD"){

                                                    $currname="StartPrice";
                                                    $price=$row->StartPrice ;


                                                }else  if($row->currencyID=="GBP"){
                                                    $currname="PriceGBP";
                                                    $price=$row->PriceGBP;

                                                }else  if($row->currencyID=="AUD"){
                                                    $currname="PriceAUD";
                                                    $price=$row->PriceAUD;

                                                }

                                                ?>

                                                <td ><?=$row->currencyID?><input type="text" class="form-control"  value="<?=$price ?>" name="<?=$currname?><?= $row->productactiveid ?>"/> </td>

                                                <input type="hidden" value="<?=$row->ItemID ?>" name="itemid<?= $row->productactiveid ?>"/>

                                            </tr>
                                        <? }
                                        ?>
                                        </tbody>
                                    </table>
                                        </div>
                                    </div>
                                    <!-- END EXAMPLE TABLE PORTLET-->

                                    <input type="submit" class="btn blue" value="Submit">
                                </form>
                            <?
                            }
                            ?>
                </div>

                <div  class="tab-pane " id="tabs-3">

                            <form action="<?=$url?>product/product_ebayuploadbath" method="post">

                                <input type='hidden' name ='productid' value='<?=$productid3 ?>'>

                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet box grey">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="actions">
                                            <a href="#" class="btn blue"><i class="fa fa-pencil"></i> Add</a>
                                            <div class="btn-group">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_3">
                                    <thead>
                                    <tr>
                                        <th>動作</th>
                                        <th> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>                                        </th>
                                        <th>PIC</th>
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
                                            <td > <a  href="<?= $adminurl . "product_toebaydel/".$row->prodtoebayid ?>">DEL</a></td>
                                            <td><input class="checkboxes" type="checkbox" value="<?=$row->productid ?>" name="chk3[]"/></td>
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
                                            <td >  <?=$row->ListingDuration?> </td>
                                            <td > <a  href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>#tabs-2"><?=$row->sku?></a></td>
                                            <td ><?=$row->StartPrice?> </td>
                                            <td ><?=$row->PriceAUD?> </td>
                                            <td ><?=$row->PriceGBP?> </td>
                                        </tr>
                                    <? }
                                    ?>
                                    </tbody>
                                </table>

                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->


                                <label class="form-label"> ebay ID: </label>
                                <select class="layout-option form-control input-big" name="accounttokenid">
                                    <?  $sql="select * from  accounttoken  ";
                                    $query=$this->db->query($sql);
                                    foreach($query->result() as $rowv){
                                        ?>
                                        <option  value='<?=$rowv->accounttokenid?>'><?=$rowv->username."-".$rowv->Currency?></option>
                                    <? }?>
                                </select>



                                <input type="submit"  class="btn blue" value="上架" />

                            </form>



                </div>

            <?}?>


        </div>
    </div>
</div>
</div>



