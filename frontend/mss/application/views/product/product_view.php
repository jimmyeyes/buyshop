
<script>
    function post_to_url(path, params, method) {
        method = method || "post"; // Set method to post by default, if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
           // console.log(hiddenField);
        }


        document.body.appendChild(form);    // Not entirely sure if this is necessary
         form.submit();
    }


    var nowtime =new Date().getTime();

    function addproduct(){


        post_to_url('/index.php/product/product_adds/', {'name':''+nowtime+''});
    }


    function checkCli(){

        var tu= confirm("Are you sure you want to submit");
        if(tu==true){

        }

    }

</script>

<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Product Inventory
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Inventory</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <a href="#">Product Inventory</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>



<!-- END PAGE HEADER-->

<div class="portlet box blue tabbable">
<div class="portlet-title">
    <div class="caption">
        <i class="fa fa-reorder"></i>
    </div>
</div>
<div class="portlet-body">
    <div class="tabbable portlet-tabs">
            <ul class="nav nav-tabs">
                <li class="tab active">
                    <a data-toggle="tab" href="#tabs-1">Product Inventory</a></li>


            </ul>
        <div class="tab-content">
            <div  class="tab-pane active" id="tabs-1">

                       <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-square"></i>
                            </div>
                            <div class="actions">
                                <button id="sample_editable_1_new"  onclick="addproduct()" class="btn green">
                                    Add New Product<i class="fa fa-plus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="portlet-body">

                            <div class="col-md-6">
                            <form action="<?=$url?>product/product" method="post" class="form-inline" role="form">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category" id="selectcategory" class="layout-option form-control input-small">
                                        <option value="All">All</option>
                                        <?php
                                        foreach ($querycate->result() as $row) {
                                            ?>
                                            <option value="<?= $row->categoryid ?>"><?=$row->category?></option>

                                        <? }
                                        ?>
                                    </select>

                                    <input class="btn blue" type="submit" value="GO">

                                    <a href="<?=$url?>product/category">Manage Category</a>

                                </div>
                            </form>

                            <div class="form-group">
                            <!--  -->
                             </div>


                                <br />

                                <form action="<?=$url?>product/product" method="post" class="form-inline" role="form">

                                        <div class="form-group">

                                        <label class=" control-label">Search </label>
                                        <select name="type"  class="layout-option form-control ">
                                            <option value="prodname">Product Name</option>
                                            <option value="sku">SKU</option>
                                            <option value="brand">Brand</option>
                                        </select>

                                            <input class="" name="keyword" type="text" placeholder="keyword">

                                        </div>

                                    <input class="btn blue" type="submit" value="Search">
                                </form>

                                </div>



                            <div class="clearfix">
                            </div>

                            <form id="form11" onSubmit="if(!confirm('Is the form filled out correctly?')){return false;}"  action="<?=$url?>product/product_bath" method="post" class="form-inline" role="form">
                                <div class="form-body form">
                                <input type='hidden' name ='productid' value='<?=$productid ?>'>

                                    <select name="modtype" class="layout-option form-control input-medium">
                                        <option value="0">Select Action</option>
                                        <option value="4">Update</option>
                                        <option value="1">Edit</option>
                                        <option value="3">add eBay</option>
                                        <option value="2">Delete</option>
                                    </select>
                                    <input type="submit" class="btn blue"  value="Go">

                                    <table class="table table-hover" id="">
                                        <!--sampleadv_1 -->
                                <thead>
                                <tr>
                                    <th style="width1:8px;">
                                        <input type="checkbox" class="group-checkable" onclick="check_all(this,'chk[]')"/>
                                    </th>
                                    <th>Photo</th>
                                    <th>Product Name</th>
                                    <th>SKU</th>
                                    <?
                                    $bo = $this -> all_model -> getSecurity(32);
                                    if (!$bo) {

                                    }else{
                                    ?>

                                        <th>Avg Unit Cost</th>
                                        <th>Available</th>
                                    <?
                                    }
                                    ?>
                                    <th>型號</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($query->result() as $row) {

                                    ?>
                                    <tr>
                                        <td><input class="checkboxes" type="checkbox" value="<?=$row->productid ?>" name="chk[]"/></td>
                                        <td>
                                            <?
                                            $queryimg = $this -> db -> query("SELECT * FROM product_img where proid='" . $row->productid . "' limit 1");
                                            $count =$queryimg->num_rows();
                                            if($count >0){


                                                $queryimg=$queryimg->row()->url;


                                                if(file_exists($queryimg)){
                                                ?>
                                            <img src="/index.php/product/showpic?path=<?=$currurl.$queryimg?>" width="50px" />
                                            <?
                                            }
                                            }



                                            ?>

                                        </td>
                                        <td ><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>

                                        <td ><?=$row->sku?></td>


                                        <?
                                            $totalorg=0;
                                            $countamount=0;
                                        $price=0;

                                            if($row->Quantity==""|| $row->Quantity=="0"){
                                                $amount=0;
                                            }else{
                                                $amount=$row->Quantity;
                                                $countamount=$amount;
                                            }



                                            if($row->Quantity=="" || $row->Quantity=="0"){
                                                $totalorg=0;
                                            }else{
                                                if($row->avg =="" || $row->avg ==0){
                                                    $totalorg=0;
                                                }else{
                                                    $totalorg=$row->orgamount*$row->avg;

                                                }
                                            }


                                           // $price=0;
                                           // $amount=0;
                                            $total=0;
                                            $sim=   $this -> db -> query("SELECT * FROM inventorylist where  productid ='".$row->productid."' ");
                                            foreach($sim->result() as $row2){
                                                $amount=$row2->amount;
                                                $price=$row2->price;
                                                $total=$row2->amount*$row2->price;
                                                $totalorg=$totalorg+$total;
                                            }

                                            if($total==0 || $price==0 || $row->Quantity ==0 ||$row->Quantity==''){
                                                $avg=0;
                                            }else{
                                               // $total=$total+$totalorg;
                                                $avg=@($totalorg)/$row->Quantity;
                                            }
                                            if($avg==0)
                                                $avg=$row->avg;
                                            else{
                                               // $avg=$row->avg;
                                            }
                                            ?>
                                            <?
                                            $bo = $this -> all_model -> getSecurity(32);
                                            if (!$bo) {

                                            }else{

                                                if($row->isIn ==1){

                                                    $sql="insert into inventorylist values (null,NOW(),'".$row->productid."','0','".$row->avg."','".$row->Quantity."',NOW())";
                                                    $query = $this -> db -> query($sql);

                                                    $sql="update product set avg='0',isIn='0' where productid='".$row->productid."' ";
                                                    $query = $this -> db -> query($sql);

                                                    $avg=$avg;

                                                }else{
                                                    if($row->avg=='' ||$row->avg ==0){
                                                        $avg=$avg;
                                                    }else{

                                                       $avg=$row->avg;
                                                    }
                                                  }

                                                ?>
                                           <td> <input    type="text" value="<?=round($avg,0)?>"  name="avg<?=$row->productid ?>">  </td>
                                             <?
                                            }
                                            ?>


                                        <?
                                        $Quantity= $row->Quantity;
                                        if($Quantity =="")
                                            $Quantity=0;
                                        ?>

                                        <?
                                        $bo = $this -> all_model -> getSecurity(32);
                                        if (!$bo) {

                                        }else{
                                            ?>
                                            <td > <input   type="text" value="<?=$Quantity?>"  name="Quantity<?=$row->productid ?>">  </td>
                                        <?
                                        }
                                        ?>



                                        <td ><?=$row->model?>  </td>
                                        <td ><?=$row->brand?>  </td>
                                        <td ><?=$row->category?>  </td>

                                    </tr>
                                <? }
                                ?>

                                </tbody>
                            </table>

                                </div>
                         </form>

                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->






                </div>
        </div>
    </div>
</div>
</div>



