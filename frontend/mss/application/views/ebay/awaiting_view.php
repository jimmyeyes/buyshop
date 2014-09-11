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
                <a href="#">Awaiting Upload</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>



<div class="portlet box blue ">
<div class="portlet-title">
    <div class="caption">
        <i class="fa fa-reorder"></i>
    </div>
</div>
<div class="portlet-body">


        <form action="<?=$url?>product/product_ebayuploadbath" method="post">

            <input type='hidden' name ='productid' value='<?=$productid3 ?>'>

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Awaiting Upload
                    </div>

                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                <thead>
                <tr>
                    <th>Action</th>
                    <th> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>  </th>
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
            <select class="layout-option form-control input-medium" name="accounttokenid">
                <?  $sql="select * from  accounttoken  ";
                $query=$this->db->query($sql);
                foreach($query->result() as $rowv){
                    ?>
                     <option  value='<?=$rowv->accounttokenid?>'><?=$rowv->username."-".$rowv->Currency?></option>
                <? }?>

                <option  value='del'>DEL</option>


            </select>
            <input type="submit"  class="btn blue" value="Action" />

        </form>


</div>
</div>



