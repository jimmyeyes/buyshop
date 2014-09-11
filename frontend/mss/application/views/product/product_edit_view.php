<script type="text/javascript" src="http://buyshoptw.com/mss//application/views/ckeditor.js"></script>
<script type="text/javascript" src="http://buyshoptw.com/mss/ckfinder/ckfinder.js"></script>

<script>
function SelZero(vall){
    var arr=new Array();
    var arr2=new Array();
    <?php 
            $string="";
            $val="";
           
		   for($i=0;$i<4;$i++){
			if($row->amount==""){
				 $sql = "select max(productid) as productid ,amountother from product where currencyid ='".$i."'";
            	$queryarr = $this->db->query($sql);
            	foreach ($queryarr->result() as $rowarr) {
                    echo "arr[".$i."] = '".$rowarr->amountother."';";
           		 }
			}else{
				$arr=array('usamount','ukamount','auamount','amountother');
				 $sql = "select ".$arr[$i]." as amountother from product where productid ='".$row->productid."'";
            	$queryarr = $this->db->query($sql);
            	foreach ($queryarr->result() as $rowarr) {
                    echo "arr[".$i."] = '".$rowarr->amountother."';";
           		 }
			}
		   }
    ?>
$("#amountother").val(arr[vall]);
}
function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
}


function ValidateNumber(e, value){

     document.getElementById('nowlen').innerHTML =value.length; 
    // console.log(value.length);
   // alert(value.length);
    return false;
}


</script>


<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Product Detail
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="/index.php/product">Inventory</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li>
                <a href="#">Product Detail</a>
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
    <li class="tab active"><a data-toggle="tab" href="#tabs-1">編輯商品</a></li>

    <?   if (($authority & 2048) == 2048) { ?>

        <li class="tab"><a data-toggle="tab" href="#tabs-2">上架資料</a></li>
    <? }?>
</ul>
<div class="tab-content">
<div  class="tab-pane active" id="tabs-1">

    <div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <?php echo form_open_multipart('product/product_add_img'); ?>

        <span class="btn green fileinput-button">
        <i class="fa fa-plus"></i>
        <span>
            Add files...
        </span>

        <input type="file" name="userfile"  />

        </span>

        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <button type="submit" class="btn blue start">
            <i class="fa fa-upload"></i>
            <span>
                Start upload
            </span>
        </button>

        </form>
        <label class="form-label"> 目前檔案: </label>
        <table>
            <tr>
                <?php foreach ($queryimg->result() as $rowimg): ?>
                    <td width="120" align="center">
                        <?
                       $url= $rowimg->url;
                        $str=str_replace("//","/",$url);
                        ?>

                        <a href="<?php echo base_url() . $str; ?>" target="_blank"><?php echo $rowimg->name; ?></a>
                           <br >
                        <img  style='border:2px solid #000000' width="50px"  src="<?php echo base_url() . $str; ?>" />
                        <br>

                        <form action='<?php echo $adminurl; ?>product_img_del' method='post'>
                            <input type="hidden" value="<?php echo $rowimg->id; ?>" name='id'>
                            <input type="hidden" value="<?php echo $rowimg->proid; ?>" name='proid'>
                            <input type='submit'  class="btn blue" value='刪除' /></form>
                    </td>


                <?php endforeach; ?>
        </table>

    </div>
    </div>


    <div class="clearfix">
    </div>

    <div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i><?=$row -> prodname; ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body ">

    <form action="<?php echo $adminurl; ?>product_edit_update" method="post" class="form-inline" role="form">
    <div class="col-md-2">

            <label> Brand： </label>
            <input class="form-control" type="text" value="<?php echo $row -> brand; ?>"  name="brand">
    </div>

    <div class="col-md-2">

            <label > 商品類別 </label>

            <?
            echo "<select class=\"form-control input-medium select2me\" name='categoryid'>";
            $sql = "select * from category";

            $query = $this->db->query($sql);
            echo "<option value=''></option> ";
            foreach ($query->result() as $row2) {
                echo "<option value='{$row2->categoryid}' ";
                if ($row2->categoryid == $row->categoryid) {
                    echo "selected='selected'";
                }
                echo ">{$row2->category}</option>";
            }
            echo "</select>";
            ?>
    </div>
    <div class="col-md-3">
            <label > 品名： </label>

            <input class="form-control"  type="text" value='<?=$row -> prodname; ?>'  name="prodname">
</div>
    <div class="col-md-2">
            <label > 型號： </label>
            <input class="form-control" type="text" value="<?php echo $row -> model ?>" name="model">

    </div>

    <div class="col-md-2">
            <label class=""> SKU： </label>
            <input class="form-control" type="text" value="<?php echo $row -> sku ?>" name="sku">
       </div>
    <div class="col-md-2">
            <label > UPC： </label>
            <input class="form-control" type="text" value="<?php echo $row -> upc ?>" name="upc">
    </div>
    <div class="col-md-2">
            <label > EAN： </label>
            <input class="form-control" type="text" value="<?php echo $row -> ean ?>" name="ean">
</div>
    <div class="col-md-2">
            <label class=""> MPN： </label>
            <input class="form-control" type="text" value="<?php echo $row -> mpn ?>" name="mpn">
</div>

    <div class="col-md-2">
        <label class=""> Available： </label>
        <input class="form-control" type="text" value="<?php echo $row -> Quantity ?>" name="qty">
    </div>

            <?   if (($authority & 128) == 128) { ?>

    <div class="col-md-12">
    <div class="col-md-2">
            <label class=""> Cost： </label>
            <input class="form-control" type="text" value="<?php
            $sql2=" SELECT max(productid) as productid  FROM `product` WHERE amount !='' ";
            //echo $sql2;
            $query2=$this->db->query($sql2);
            foreach($query2->result() as $row2){
                if($row -> amount==""){
                    $sql="select * from product where productid='".($row2->productid)."'";
                    //echo $sql;
                    $query3=$this->db->query($sql);
                    foreach($query3->result() as $row3){
                        echo $row3->amount;
                    }
                }else{
                    echo  $row->amount;
                }
            }

            ?>" name="amount">
</div>
    <div class="col-md-2">
            <label class=""> 運費:</label>
            <label class=""> Fedex IE</label>
            <?
            echo "<select class=\"layout-option form-control input-medium\" name='shippingid'>";
            $sql = "select * from shipping";
            $shippingfee="";
            $query = $this->db->query($sql);
            echo "<option value=''></option> ";
            foreach ($query->result() as $row2) {
                echo "<option value='{$row2->shippingid}' ";
                if ($row2->shippingid == $row->shippingid) {
                    echo "selected='selected'";
                    $shippingfee=$row2->fee;
                }
                echo ">{$row2->kg}kg-{$row2->fee}</option>";
            }
            echo "</select>";
            ?>
        </div>
        <div class="col-md-2">
            <label class=""> Air Mail</label>
            <input class="form-control" type="text" value="<?php echo $row -> gram ?>" name="gram">
</div>
            <?php
            if($row -> gram ){

                echo $this->all_model->getGramPrice($row -> gram);
            }
            ?>


    <div class="col-md-2">
            <label class=""> 幣別:</label>
            <?
            $dallor = $this -> all_model -> getDallor();
            ?>
            <select class="layout-option form-control input-medium" name='currencyid'  onchange="SelZero(this.options[this.options.selectedIndex].value);">
                <?
                $i=0;
                echo "<option value=''></option> ";
                foreach ($dallor as $da) {
                    echo "<option value='{$i}' ";
                    if ($row->currencyid == $i) {
                        echo "selected='selected'";
                    }
                    echo ">{$da}</option>";
                    $i++;
                }
                ?>
            </select>

        </div>

        <div class="col-md-2">

            <input class="form-control" type="text" value="<?php

            $sql2=" SELECT max(productid) as productid  FROM `product` WHERE amountother !='' ";
            //echo $sql2;
            $query2=$this->db->query($sql2);
            foreach($query2->result() as $row2){
                if($row -> amount==""){
                    $sql="select * from product where productid='".($row2->productid)."'";
                    //echo $sql;
                    $query3=$this->db->query($sql);
                    foreach($query3->result() as $row3){
                        echo $row3->amountother;
                    }
                }else{
                    $arr=array($row->usamount,$row->ukamount,$row->auamount,$row->amountother);
                    echo $arr[$row->currencyid];
                    $amountother=$arr[$row->currencyid];

                }
            }
            ?>" name="amountother" id='amountother' placeholder="售價">
</div>
            </div>

                <div class="col-md-2">
                    運費兩種選一種填，當AIR MAIL不是為0時就會以這個來計算運費
                </div>

            <?}?>


            <input type="hidden" value="<?php echo $id; ?>" name='id'>
    <div class="col-md-2">
            <input type="submit" class="btn blue" value="Update" />
</div>
            <?php

            if (($authority & 128) == 128) {
                    if(@$amountother!="" & ($row->shippingid !=""| $row -> gram!="")){
                        if($row->currencyid=="3"){

                   $table=" <div class=\"col-md-12\"><table class=\"table table-striped table-bordered table-hover\" id=\"\">";
					$table.="<tr><td>電匯手續費用</td>
					<td>售價B</td><td>TAX</td><td>PROFIT</td><td>%</td></tr>
					</thead>";

                        }else{

                            $table="<div class=\"col-md-12\"><table class=\"table table-striped table-bordered table-hover\" id=\"\">";
                            $table.="<tr><td>費用A</td><td>費用B</td>
                                <td>售價A</td><td>售價B</td><td>TAX</td><td>PROFIT</td><td>%</td></tr>
                                </thead>";
                        }

                        $query=$this->db->query("select * from webprofile")->row();

                        if($row -> gram ){

                            $shippingfee= $this->all_model->getGramPrice($row -> gram);
                        }

                        if($row->currencyid =="0"){
                            ?>
                             <div class="col-md-2">
                            <label class="form-label"> <h2>美金:</h2></label>
                            </div>
                            <?

                            $feea=$amountother*$query->usfee1+$query->usfee2;
                            $feeb1=$amountother*$query->usfee3;
                            $feeb2=$amountother*$query->usfee4;
                            $feeb3=$amountother*$query->usfee5;

                            $table.= "<tbody class=\"openable-tbody\">";

                            $table.="<tr>";

                           // $table.="<td>".$row->amount."</td>";
                            //$table.="<td>".$shippingfee."</td>";
                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$feeb1."</td>";
                            $table.="<td>".(($amountother)-($feeb1))."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";
                            $profit=($amountother-$feea-$feeb1)*$query->pus-$shippingfee-$row->amount;
                            $table.="<td>".$profit."</td>";
                            $table.="<td>";
                            if($amountother!=0){
                                $table.=($profit/($amountother*$query->pus))*100 ;
                            }
                            $table.="%</td>";
                            $table.="</tr>";

                           $table.="<tr>";
                            //<td>".$row->amount."</td>";
                           // $table.="<td>".$shippingfee."</td>";
                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$feeb2."</td>";
                            $table.="<td>".(($amountother)-($feeb2))."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";
                            $profit=($amountother-$feea-$feeb2)*$query->pus-$shippingfee-$row->amount;
                            $table.="<td>".$profit."</td>";
                            //$table.="<td>".($profit/($amountother*$query->pus))*100 ."%</td>";


                            $table.="<td>";
                            if($amountother!=0){
                                $table.=($profit/($amountother*$query->pus))*100 ;
                            }
                            $table.="%</td>";
                            $table.="</tr>";

                            $table.="<tr>";
                            //<td>".$row->amount."</td>";

                           // $table.="<td>".$shippingfee."</td>";
                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$feeb3."</td>";
                            $table.="<td>".(($amountother)-($feeb3))."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";
                            $profit=($amountother-$feea-$feeb3)*$query->pus-$shippingfee-$row->amount;
                            $table.="<td>".$profit."</td>";
                            //$table.="<td>".($profit/($amountother*$query->pus))*100 ."%</td>";
                            $table.="<td>";
                            if($amountother!=0){
                                $table.=($profit/($amountother*$query->pus))*100 ;
                            }
                            $table.="%</td>";


                            $table.="</tr>";

                            $table.="</tbody>";

                        }else if($row->currencyid =="1"){
                            ?>
    <div class="col-md-2">
                            <label class="form-label"> <h2>英鎊:</h2></label>
</div>
                            <?

                            $feea=$amountother*$query->ukfee1+$query->ukfee2;
                            $feeb1=$amountother*$query->ukfee3;
                            $table.= "<tbody class=\"openable-tbody\">";


                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$feeb1."</td>";
                            $table.="<td>".(($amountother)-($feeb1))."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";

                            //$profit=($amountother-$feea-$feeb3)*$query->pus-$shippingfee-$row->amount;


                            $profit=($amountother-$feea-$feeb1)*$query->puk-$shippingfee-$row->amount;



                            $table.="<td>".$profit."</td>";


                            //$table.="<td>".($profit/($amountother*$query->puk))*100 ."%</td>";
                            $table.="<td>";
                            if($amountother!=0){
                                $table.=($profit/($amountother*$query->puk))*100 ;
                            }
                            $table.="%</td>";



                            $table.="</tr>";

                        }else if($row->currencyid =="2"){
                            ?>
    <div class="col-md-2">
                            <label class="form-label"> <h2>澳幣:</h2></label>
</div>
                            <?

                            $feea=$amountother*$query->aufee1+$query->aufee2;
                            $feeb1=$amountother*$query->aufee3;

                            $table.= "<tbody class=\"openable-tbody\">";
                            $table.="<tr>";
                         //   $table.="<td>".$row->amount."</td>";
                           // $table.="<td>".$shippingfee."</td>";
                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$feeb1."</td>";
                            $table.="<td>".(($amountother)-($feeb1))."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";
                            $profit=($amountother-$feea-$feeb1)*$query->pau-$shippingfee-$row->amount;
                            $table.="<td>".$profit."</td>";
                            $table.="<td>".($profit/($amountother*$query->pau))*100 ."%</td>";
                            $table.="</tr>";

                        }else if($row->currencyid =="3"){
                            ?>
    <div class="col-md-2">
                            <label class="form-label"> <h2>電匯:</h2></label>
</div>
                            <?
                            $feea=$query->busfee1;
                            $table.= "<tbody class=\"openable-tbody\">";
                            $table.="<tr>";

                        //    $table.=" <td>".$row->amount."</td>";
                          //  $table.="<td>".$shippingfee."</td>";
                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";
                            $profit=($amountother)*$query->bus-$row->amount-$shippingfee-$feea;
                            $table.="<td>".$profit."</td>";
                            $table.="<td>".($profit/($amountother*$query->bus))*100 ."%</td>";
                            $table.="</tr>";

                        }
                        echo $table."</table></div>";

                    }
                    ?>

            <?php }?>



    <div class="clearfix">
    </div>
            <script>
                CKFinder.setupCKEditor( null, '/ckfinder/' );
                var editor = CKEDITOR.replace( 'spec' );

               // console.log(editor);
                CKFinder.setupCKEditor( null, '/ckfinder/' );
                 editor = CKEDITOR.replace( 'feture' );


            </script>


            <div class="col-md-12">
                    <h2 class="box-header">	EN Description </h2>

                        <textarea class="ckeditor"   name="spec"  id="spec" cols="" rows=""><?php echo $row -> spec; ?></textarea>
                </div>

            <div class="col-md-12">

                     <h2 class="box-header">CH Description </h2>

                        <textarea class="ckeditor"   name="feture" id="feture" ><?php echo $row -> feture; ?></textarea>
            </div>





        </form>

    </div>

</div>

    <div class="clearfix">
    </div>




</div>


<script>

    function SuggestedCategories(){

        var oform = document.forms["ebayform"];
       var title= oform.elements.ebaytitle.value;

        <?

        $sql="select * from accounttoken limit 1";

          $row1234=  $this->db->query($sql)->row();
            $accounttokenid=$row1234->accounttokenid;

        ?>



        window.open('<?=$adminurl?>SuggestedCategories/<?=$accounttokenid?>/'+title, 'SuggestedCategories', config='height=600,width=800');
    }

    function FindProduct(){
        var oform = document.forms["ebayform"];
        var title= oform.elements.ebaytitle.value;


        window.open('<?=$adminurl?>FindProduct/'+title, 'FindProduct', config='height=600,width=800');

    }

</script>

<?   if (($authority & 2048) == 2048) { ?>


    <div  class="tab-pane "  id="tabs-2">
    <div  class="box themed_box">
    <h2 class="box-header">上架資料</h2>
    <div class="box-content">
    <form METHOD="post" id="ebayform" action="<?=$adminurl?>addSaveItem">


    <label class=""> Category: </label>
    <input type="text" class="form-field 10" value="<?=$row->category?>" name="category" size="20" />
    <a href='http://listings.ebay.com/_W0QQloctZShowCatIdsQQsacatZQ2d1QQsalocationZatsQQsocmdZListingCategoryList'>Select Category</a>

    <a target="_blank" onclick="SuggestedCategories()" >依照標題尋找推薦目錄</a>


    <label class="">Store Category: </label>
    <select name="storecategory">
        <?  $sql="select * from  accounttoken ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option value=''>---<?=$rowv->username?></option>
            <?
            $xml= $this -> all_model -> getStore($rowv->accounttokenid);
            $xml=simplexml_load_string($xml);
            // print_r($xml);
            $order= $xml->Store->CustomCategories->CustomCategory;
            foreach($order as $row1){
                ?>
                <option  <? if($row->storecategory ==$row1->CategoryID){ ?> selected <?  }?>  value='<?=$row1->CategoryID?>'>*<?=$row1->Name?></option>
                <?
                if(count($row1->ChildCategory) >0){
                    $child=$row1->ChildCategory;
                    foreach($child as $row2){
                        ?>
                        <option  <? if($row->storecategory ==$row2->CategoryID){ ?> selected <?  }?>  value='<?=$row2->CategoryID?>'>--<?=$row2->Name?></option>
                        <?
                        if(count($row2->ChildCategory) >0){
                            $child2=$row2->ChildCategory;
                            foreach($child2 as $row3){
                                ?>
                                <option  <? if($row->storecategory ==$row3->CategoryID){ ?> selected <?  }?>  value='<?=$row3->CategoryID?>'>--*<?=$row3->Name?></option>

                            <?
                            }

                        }



                    }

                }



            }
        }?>
    </select>

    <label class=""> ProductReferenceID: </label>
    <input type="text" class="form-field 10" value="<?=$row->ProductReferenceID?>" name="ProductReferenceID" size="20" />

    <a target="_blank" onclick="FindProduct()" >依照編題尋找是否在ebay上有專屬目錄</a>
    <br>

    <label class=""> eBay Title: </label><label style="color:red;" id="nowlen" ></label>
    <input type="text" class="form-field" value='<?=$row->ebaytitle?>' onkeyup="ValidateNumber(this,value)" name="ebaytitle" size="50" maxlength="80" />


    <label > Condition: </label>
    <select name="condition">
        <?  $sql="select * from  varlist where type=2 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option
                <?
                if($row->ConditionID ==$rowv->no){
                    ?>
                    selected
                <?
                }
                ?>

                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>





    <label class=""> Price: </label>

    <input type="text" class="form-field 10" value="<?=$row->StartPrice?>" name="StartPrice" size="20" />


    US Dollar

    <label class=""> Price: </label>


    <input type="text" class="form-field 10" value="<?=$row->PriceGBP?>" name="PriceGBP" size="20" />

    UK Dollar

    <label class=""> Price: </label>

    <input type="text" class="form-field 10" value="<?=$row->PriceAUD?>" name="PriceAUD" size="20" />

    AU Dollar


    <label class=""> Quantity: </label>

    <?
    if($row->Quantity==""){
        ?>
        <input type="text" class="form-field 10"  value="4"  name="quantity" size="20" />

    <?
    }else{
        ?>
        <input type="text" class="form-field 10"  value="<?=$row->Quantity?>"  name="quantity" size="20" />
    <?

    }

    ?>



    <label class=""> ListingDuration: </label>
    <select name="ListingDuration">
        <?  $sql="select * from  varlist where type=3 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option
                <?
                if($row->ListingDuration=="" && $rowv->no=="Days_30"){
                    ?>
                    selected
                <?

                }else{

                    if($row->ListingDuration ==$rowv->no){
                        ?>
                        selected
                    <?
                    }
                }
                ?>

                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>

    <label class=""> PrivateListing</label>

    <? if($row->PrivateListing=="true"){?>
        <input type="checkbox" checked name="PrivateListing"  />
    <?}else{?>
        <input type="checkbox" name="PrivateListing" />
    <?}?>
    Allow buyers to remain anonymous to other eBay users
    <br>



    <label class=""> PaymentMethods: </label>
    <select name="PaymentMethods">
        <option value='PayPal'>PayPal</option>
    </select>


    <label class=""> PayPalEmailAddress: </label>
    <?
    if($row->PayPalEmailAddress==""){
        ?>
        <input type="text" class="form-field 30" value="" name="PayPalEmailAddress" size="20" />
    <?
    }else{
        ?>
        <input type="text" class="form-field 30" value="<?=$row->PayPalEmailAddress?>" name="PayPalEmailAddress" size="20" />
    <?
    }
    ?>


    <label class="">  Auto Pay</label>
    <? if($row->AutoPay=="true"){?>
        <input type="checkbox" checked name="autopay"  />
    <?}else{?>
        <input type="checkbox" name="autopay" />

    <?}?>
    Require immediate payment when buyer uses Buy It Now

    <br>



    <!--
  -->
    <div class="col-md-6">

    <h2 class="box-header">	US </h2>
    <label class=""> Flat: </label>
    <select name="ShippingType">
        <?  $sql="select * from  varlist where type=6 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option

                <?

                if($row->ShippingType=="" && $rowv->no=="Flat"){
                    ?>
                    selected
                <?

                }else{

                    if($row->ShippingType ==$rowv->no){
                        ?>
                        selected
                    <?
                    }
                }
                ?>
                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>


    <label class=""> Priority: </label>
    <select name="ShippingServicePriority">
        <?
        for($i=1;$i<5;$i++){
            ?>
            <option
                <?
                if($row->ShippingServicePriority ==$i){
                    ?>
                    selected
                <?
                }
                ?>

                value='<?=$i?>'><?=$i?></option>
        <? }?>
    </select>
    <br>
    <label class=""> Service: </label>
    <select name="ShippingService">
        <?  $sql="select * from  varlist where type=7 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option
                <?if($row->ShippingService=="" ){
                if($rowv->no=="ExpeditedShippingFromOutsideUS"){?>selected
                <?
                }

                }else{

                if($row->ShippingService ==$rowv->no){?>selected
                <?
                }
                }
                ?> value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>

    <label class=""> FreeShipping: </label>

    <? if($row->FreeShipping=="true"){?>
        <input type="checkbox" checked name="FreeShipping"  />
    <?}else{?>
        <input type="checkbox" name="FreeShipping" />
    <?}?>

    <br>


    <label class=""> Cost: </label>

    <?
    if($row->ShippingServiceCost==""){
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceCost" value="" size="20" />

    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceCost" value="<?=$row->ShippingServiceCost?>" size="20" />

    <?

    }

    ?>

    <br>

    <label class="">AdditionalCost: </label>

    <?
    if($row->ShippingServiceAdditionalCost==""){
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceAdditionalCost" value="" size="20" />

    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceAdditionalCost" value="<?=$row->ShippingServiceAdditionalCost?>" size="20" />

    <?

    }

    ?>

    <br>


    <hr />

    <label class=""> Priority2: </label>
    <select name="ShippingServicePriority2">
        <?
        for($i=0;$i<6;$i++){
            ?>
            <option
                <?
                if($row->ShippingServicePriority2 ==$i){
                    ?>
                    selected
                <?
                }
                ?>

                value='<?=$i?>'><?=$i?></option>
        <? }?>
    </select>
    <br>
    <label class=""> Service2: </label>
    <select name="ShippingService2">
        <?  $sql="select * from  varlist where type=7 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option
                <?if($row->ShippingService2=="" ){
                if($rowv->no=="ExpeditedShippingFromOutsideUS"){?>selected
                <?
                }

                }else{

                if($row->ShippingService2 ==$rowv->no){?>selected
                <?
                }
                }
                ?> value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>
    <label class=""> Cost2: </label>

    <?
    if($row->ShippingServiceCost2==""){
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceCost2" value="" size="20" />

    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceCost2" value="<?=$row->ShippingServiceCost2?>" size="20" />

    <?

    }

    ?>

    <br>


    <label class=""> AdditionalCost2: </label>

    <?
    if($row->ShippingServiceAdditionalCost2==""){
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceAdditionalCost2" value="" size="20" />

    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="ShippingServiceAdditionalCost2" value="<?=$row->ShippingServiceAdditionalCost2?>" size="20" />

    <?

    }

    ?>

   </div>




    <div class="col-md-6">

    <h2 class="box-header">	International </h2>


    <label class=""> ServiceOption: </label>

    <label class=""> InternationalShipToLocation: </label>
    <select name="InternationalShipToLocation">
        <?  $sql="select * from  varlist where type=8 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option
                <?
                if($row->InternationalShipToLocation ==$rowv->no){
                    ?>
                    selected
                <?
                }
                ?>
                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>


    <label class=""> Service: </label>
    <select name="InternationalShippingService">
        <?  $sql="select * from  varlist where type=7 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option

                <?

                if($row->InternationalShippingService=="" ){
                if($rowv->no=="FedExInternationalEconomy"){?>selected
                <?
                }

                }else{

                    if($row->InternationalShippingService ==$rowv->no){
                        ?>
                        selected
                    <?
                    }
                }
                ?>
                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>

    <!--	<label class="form-label"> InternationalShippingServicePriority: </label>
         	 <select name="InternationalShippingServicePriority">
          	<?
				for($i=0;$i<6;$i++){
          	?>
          			<option
          			<?
          			if($row->InternationalShippingServicePriority ==$i){
          				?>
          				selected
          				<?
          			}
          			?>

          			 value='<?=$i?>'><?=$i?></option>
          	<? }?>
       </select>

              <br>-->
    <label class=""> ServiceCost: </label>

    <?
    if($row->InternationalShippingServiceCost==""){

        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceCost" value="" size="20" />
    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceCost" value="<?=$row->InternationalShippingServiceCost?>" size="20" />
    <?
    }
    ?>


    <br>


    <label class=""> ServiceAdditionalCost: </label>

    <?
    if($row->InternationalShippingServiceAdditionalCost==""){

        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceAdditionalCost" value="" size="20" />
    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceAdditionalCost" value="<?=$row->InternationalShippingServiceAdditionalCost?>" size="20" />
    <?
    }
    ?>


    <br>

    <label class=""> ServicePriority: </label>
    <select name="InternationalShippingServicePriority">
        <?
        for($i=0;$i<6;$i++){
            ?>
            <option
                <?
                if($row->InternationalShippingServicePriority ==$i){
                    ?>
                    selected
                <?
                }
                ?>

                value='<?=$i?>'><?=$i?></option>
        <? }?>
    </select>
    <br>

    <hr />

    <!---- -->


    <label class=""> ServiceOption2: </label>

    <label class=""> InternationalShipToLocation2: </label>
    <select name="InternationalShipToLocation2">
        <?  $sql="select * from  varlist where type=8 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option
                <?
                if($row->InternationalShipToLocation2 ==$rowv->no){
                    ?>
                    selected
                <?
                }
                ?>
                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>


    <label class=""> Service2: </label>
    <select name="InternationalShippingService2">
        <?  $sql="select * from  varlist where type=7 ";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option

                <?

                if($row->InternationalShippingService2=="" ){
                if($rowv->no=="FedExInternationalEconomy"){?>selected
                <?
                }

                }else{

                    if($row->InternationalShippingService2 ==$rowv->no){
                        ?>
                        selected
                    <?
                    }
                }
                ?>
                value='<?=$rowv->no?>'><?=$rowv->name?></option>
        <? }?>
    </select>
    <br>

    <!--	<label class="form-label"> InternationalShippingServicePriority: </label>
         	 <select name="InternationalShippingServicePriority">
          	<?
				for($i=1;$i<5;$i++){
          	?>
          			<option
          			<?
          			if($row->InternationalShippingServicePriority2 ==$i){
          				?>
          				selected
          				<?
          			}
          			?>

          			 value='<?=$i?>'><?=$i?></option>
          	<? }?>
       </select>

              <br>-->

    <label class="">ServiceCost2: </label>
    <?
    if($row->InternationalShippingServiceCost2==""){
        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceCost2" value="" size="20" />
    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceCost2" value="<?=$row->InternationalShippingServiceCost2?>" size="20" />
    <?
    }
    ?>
    <br>

    <label class=""> ServiceAdditionalCost2: </label>

    <?
    if($row->InternationalShippingServiceAdditionalCost2==""){

        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceAdditionalCost2" value="" size="20" />
    <?
    }else{
        ?>
        <input type="text" class="form-field 10" name="InternationalShippingServiceAdditionalCost2" value="<?=$row->InternationalShippingServiceAdditionalCost2?>" size="20" />
    <?
    }
    ?>
    <br>
    <!-- -->

    <label class=""> ServicePriority2: </label>
    <select name="InternationalShippingServicePriority2">
        <?
        for($i=0;$i<6;$i++){
            ?>
            <option
                <?
                if($row->InternationalShippingServicePriority2 ==$i){
                    ?>
                    selected
                <?
                }
                ?>

                value='<?=$i?>'><?=$i?></option>
        <? }?>
    </select>
    <br>

    </div>

    <div class="col-md-6">


    <hr>
    <label class=""> ExcludeShipToLocation: </label>
    <?
    $exclude=explode(',',$row->exclude);
    $sql="select * from varlist where `type`='20'";
    $query1=$this->db->query($sql);
    foreach($query1->result() as $rowv){
        ?>
        <input
        <?

        foreach($exclude as $ex){
            if($rowv->no==$ex){
                echo "checked";
            }
        }
        ?>
        type="checkbox" name="exclude[]" value="<?=$rowv->no?>"><?=$rowv->name?>


    <?

    }?>
    <br>
    <label class=""> DispatchTimeMax: </label>
    <?
    if($row->DispatchTimeMax==""){
        ?>
        <input type="text" class="form-field 10" name="DispatchTimeMax" value="3" size="20" />
    <?

    }else{
        ?>
        <input type="text" class="form-field 10" name="DispatchTimeMax" value="<?=$row->DispatchTimeMax?>" size="20" />
    <?
    }
    ?>
    <label class="">Item country: </label>

    <select name="Country">
        <?
        $sql="select * from varlist where `type`='20'";
        $query1=$this->db->query($sql);
        foreach($query1->result() as $rowv){
            ?>
            <option
                <?
                if($row->Country==$rowv->no){
                    echo "selected";}
                ?>
                value="<?=$rowv->no?>"><?=$rowv->name?></option>
        <?}?>
    </select>


    <label class="">location: </label>

    <? if($row->Location!=""){?>
        <input type="text" class="form-field 30" value='<?=$row->Location?>' name="Location" size="20" />
    <?}else{?>

        <input type="text" class="form-field 30" value='TW' name="Location" size="20" />
    <?}?>

</div>


    <div class="col-md-6">

    <h2 class="box-header">	Return </h2>

                <label class=""> ReturnsAcceptedOption: </label>
                <select name="ReturnsAcceptedOption">


                    <? if($row->ReturnsAcceptedOption=="ReturnsAccepted"){?>
                        <option selected value='ReturnsAccepted'>ReturnsAccepted</option>
                        <option value='ReturnsNotAccepted'>ReturnsNotAccepted</option>
                    <?}else{?>
                        <option  value='ReturnsAccepted'>ReturnsAccepted</option>
                        <option selected value='ReturnsNotAccepted'>ReturnsNotAccepted</option>

                    <?}?>
                </select>
                <br>

                <label class=""> RefundOption: </label>
                <select name="RefundOption">
                    <?  $sql="select * from  varlist where type=4 ";
                    $query=$this->db->query($sql);
                    foreach($query->result() as $rowv){
                        ?>
                        <option

                            <?
                            if($row->RefundOption ==$rowv->no){
                                ?>
                                selected
                            <?
                            }
                            ?>
                            value='<?=$rowv->no?>'><?=$rowv->name?></option>
                    <? }?>
                </select>
                <br>



                <label class=""> ReturnsWithinOption: </label>
                <select name="ReturnsWithinOption">
                    <?  $sql="select * from  varlist where type=5 ";
                    $query=$this->db->query($sql);
                    foreach($query->result() as $rowv){
                        ?>
                        <option
                            <?
                            if($row->ReturnsWithinOption ==$rowv->no){
                                ?>
                                selected
                            <?
                            }
                            ?>

                            value='<?=$rowv->no?>'><?=$rowv->name?></option>
                    <? }?>
                </select>
                <br>

                <label class=""> Description: </label>
                <textarea name="Description"  class="form-field small"  id="spec" cols="" rows=""><?=$row->ReturnsDescription?></textarea>

    </div>



    <input name="ListingType" type="hidden" value="FixedPriceItem">
    <input name="id" type="hidden" value="<?php echo $id; ?>">
    <input type="submit"  class="btn blue" value="SAVE" />

    <div class="clear"></div>

    </form>

    </div>
    </div>

    </div>

<? }?>


</div>
</div>
</div>
</div>


