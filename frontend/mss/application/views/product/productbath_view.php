<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            商品批次修改
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">商品批次修改</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>
        </div>
        <div class="actions">

        </div>
    </div>
    <div class="portlet-body">

        	
        	  <form action="<?=$url?>product/product_updatebath" method="post">
            <input type='hidden' name ='productid' value='<?=$productid ?>'>

                  <table class="table table-striped table-bordered table-hover" id="sample_2">
                <thead>
                    <tr>
                    	<th>    <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/></th>
                    	<th>類別名稱</th>
                    	 <th>品牌</th>
                        <th style="width:300px;">品名</th>
     					<th>型號</th>
                        <th>SKU</th>
                         <th>EAN</th>
                         <th>UPC</th>
                         <th>MPN</th>
                        <th>Available</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        ?>
                        <tr >
                        	  <td><input class="checkboxes" type="checkbox" value="<?=$row->productid ?>" name="chk[]"/></td>
                        	 <td ><?=$row->category?>  </td>
                        	 <td ><?=$row->brand?>  </td>
                            <td ><input class="form-control"    type="text" value="<?=$row->prodname?>"  name="prodname<?=$row->productid ?>"></td>
                            <td ><input class="form-control"     type="text" value="<?=$row->model?>"  name="model<?=$row->productid ?>">  </td>
                          <td ><input class="form-control"     type="text" value="<?=$row->sku?>"  name="sku<?=$row->productid ?>"></td>
                            <td >  <input class="form-control"     type="text" value="<?=$row->ean?>"  name="ean<?=$row->productid ?>"> </td>
                             <td ><input class="form-control"     type="text" value="<?=$row->upc?>"  name="upc<?=$row->productid ?>"> </td>
                               <td > <input class="form-control"     type="text" value="<?=$row->mpn?>"  name="mpn<?=$row->productid ?>"></td>
                            <td > <input class="form-control"     type="text" value="<?=$row->Quantity?>"  name="Quantity<?=$row->productid ?>"></td>

                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>

              <input type="submit" class="btn blue" value="UPDATE">
            </form>
            

        </div>
    </div>
    
    

</div>
