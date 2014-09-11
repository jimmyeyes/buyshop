<?= $menu ?>
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
<?
$url="http://jwliu.com/ebayuploadpic/a80_hdtv_adapter_1200.jpg";
//$respXmlObj=$this->all_model->UploadSiteHostedPictures("14",$url,"pic1");

//$respXmlObj=simplexml_load_string($respXmlObj);

//print_r($respXmlObj);

	// $ack  = $respXmlObj->Ack;
   // $picNameOut = $respXmlObj->SiteHostedPictureDetails->PictureName;
   // $picURL     = $respXmlObj->SiteHostedPictureDetails->FullURL;
    
   // print "<P>Picture Upload Outcome : $ack </P>\n";
   // print "<P>picNameOut = $picNameOut </P>\n";
   // print "<P>picURL = $picURL</P>\n";
   // print "<IMG SRC=\"$picURL\">";

?>
<div id="subnavbar"></div>
<div id="content">

<div class="column full">
<div id="tabs" class="box tabs themed_box">
<h2 class="box-header"></h2>
<ul class="tabs-nav">
    <li class="tab"><a href="#tabs-1">編輯商品</a></li>
    <li class="tab"><a href="#tabs-2">上架資料</a></li>

</ul>
<div class="box-content">
<div id="tabs-1">

<div class="box themed_box">
    <h2 class="box-header">編輯商品</h2>
    <div class="box-content">


    <div  class="box themed_box">
    <h2 class="box-header">上傳圖片</h2>
    <div class="box-content">
        <?php echo form_open_multipart('product/product_add_img'); ?>
        <input type="file" name="userfile" size="20" />

        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <input type="submit"  class="button white" value="上傳" />
        </form>
        <label class="form-label"> 目前檔案: </label>
        <table>
            <tr>
                <?php foreach ($queryimg->result() as $rowimg): ?>
                    <td width="120" align="center">
                        <a href="<?php echo base_url() . $rowimg->url; ?>" target="_blank"><?php echo $rowimg->name; ?></a>
                           <br >
                        <img  style='border:2px solid #000000' width="50px"  src="<?php echo base_url() . $rowimg->url; ?>" />
                        <br>

                        <form action='<?php echo $adminurl; ?>product_img_del' method='post'>
                            <input type="hidden" value="<?php echo $rowimg->id; ?>" name='id'>
                            <input type="hidden" value="<?php echo $rowimg->proid; ?>" name='proid'>
                            <input type='submit'  class="button white" value='刪除' /></form>
                    </td>


                <?php endforeach; ?>
        </table>

    </div>


    <br />

    <form action="<?php echo $adminurl; ?>product_edit_update" method="post">
            <label> 品牌： </label>
            <input class="form-field 10px" type="text" value="<?php echo $row -> brand; ?>"  name="brand">
            <label > 商品類別 </label>
            <?
            echo "<select name='categoryid'>";
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

            <label > 品名： </label>

            <input class="form-field small" type="text" value='<?=$row -> prodname; ?>'  name="prodname">

            <label > 型號： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> model ?>" name="model">
            <br>
            <label class="">Brand: </label>
            <input type="text" class="form-field 30" value='<?=$row->brand?>' name="brand" size="20" />

            <label class=""> SKU： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> sku ?>" name="sku">
            <label > UPC： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> upc ?>" name="upc">


            <label > EAN： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> ean ?>" name="ean">

            <label class=""> MPN： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> mpn ?>" name="mpn">

            <br>


            <label class=""> 台幣單價： </label>
            <input class="form-field 10" type="text" value="<?php
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

            <label class=""> 運費:</label>
            <label class=""> Fedex IE</label>
            <?
            echo "<select name='shippingid'>";
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
            <label class=""> Air Mail</label>
            <input class="form-field 10" type="text" value="<?php echo $row -> gram ?>" name="gram">

            <?php
            if($row -> gram ){

                echo $this->all_model->getGramPrice($row -> gram);
            }
            ?>

            運費兩種選一種填，當AIR MAIL不是為0時就會以這個來計算運費

            <label class=""> 幣別:</label>
            <?
            $dallor = $this -> all_model -> getDallor();
            ?>
            <select name='currencyid'  onchange="SelZero(this.options[this.options.selectedIndex].value);">
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

            <input class="form-field 10" type="text" value="<?php

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
            ?>" name="amountother" id='amountother'>售價

            <input type="hidden" value="<?php echo $id; ?>" name='id'>
            <input type="submit" class="button white" value="Update" />


            <br />



            <?php

            if (($authority & 128) == 128) {

            ?>
            <div class="box themed_box">
                <h2 class="box-header">售價 </h2>
                <div class="box-content">

                    <?
                    if(@$amountother!="" & ($row->shippingid !=""| $row -> gram!="")){
                        if($row->currencyid=="3"){

                            $table="<table class=\"tablebox\" cellspacing=\"4\"  cellpadding=\"4\"><thead class=\"table-header\">
					<tr><td>台幣單價</td><td>運費</td><td>電匯手續費用</td>
					<td>售價B</td><td>TAX</td><td>PROFIT</td><td>%</td></tr>
					</thead>";

                        }else{

                            $table="<table class=\"tablebox\" cellspacing=\"4\"  cellpadding=\"4\"><thead class=\"table-header\">
					<tr><td>台幣單價</td><td>運費</td><td>費用A</td><td>費用B</td>
					<td>售價A</td><td>售價B</td><td>TAX</td><td>PROFIT</td><td>%</td></tr>
					</thead>";
                        }

                        $query=$this->db->query("select * from webprofile")->row();

                        if($row -> gram ){

                            $shippingfee= $this->all_model->getGramPrice($row -> gram);
                        }

                        if($row->currencyid =="0"){
                            ?>
                            <label class="form-label"> <h2>美金:</h2></label>

                            <?

                            $feea=$amountother*$query->usfee1+$query->usfee2;
                            $feeb1=$amountother*$query->usfee3;
                            $feeb2=$amountother*$query->usfee4;
                            $feeb3=$amountother*$query->usfee5;

                            $table.= "<tbody class=\"openable-tbody\">";

                            $table.="<tr><td>".$row->amount."</td>";
                            $table.="<td>".$shippingfee."</td>";
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

                            $table.="<tr><td>".$row->amount."</td>";
                            $table.="<td>".$shippingfee."</td>";
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

                            $table.="<tr><td>".$row->amount."</td>";
                            $table.="<td>".$shippingfee."</td>";
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
                            <label class="form-label"> <h2>英鎊:</h2></label>

                            <?

                            $feea=$amountother*$query->ukfee1+$query->ukfee2;
                            $feeb1=$amountother*$query->ukfee3;
                            $table.= "<tbody class=\"openable-tbody\">";

                            $table.="<tr><td>".$row->amount."</td>";
                            $table.="<td>".$shippingfee."</td>";
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
                            <label class="form-label"> <h2>澳幣:</h2></label>

                            <?

                            $feea=$amountother*$query->aufee1+$query->aufee2;
                            $feeb1=$amountother*$query->aufee3;

                            $table.= "<tbody class=\"openable-tbody\">";
                            $table.="<tr><td>".$row->amount."</td>";
                            $table.="<td>".$shippingfee."</td>";
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
                            <label class="form-label"> <h2>電匯:</h2></label>

                            <?
                            $feea=$query->busfee1;
                            $table.= "<tbody class=\"openable-tbody\">";
                            $table.="<tr><td>".$row->amount."</td>";
                            $table.="<td>".$shippingfee."</td>";
                            $table.="<td>".$feea."</td>";
                            $table.="<td>".$amountother."</td>";
                            $table.="<td>".$row->amount/21 ."</td>";
                            $profit=($amountother)*$query->bus-$row->amount-$shippingfee-$feea;
                            $table.="<td>".$profit."</td>";
                            $table.="<td>".($profit/($amountother*$query->bus))*100 ."%</td>";
                            $table.="</tr>";

                        }
                        echo $table."</table>";

                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </div>



</div>


            <script>
                CKFinder.setupCKEditor( null, '/ckfinder/' );
                var editor = CKEDITOR.replace( 'spec' );

                CKFinder.setupCKEditor( null, '/ckfinder/' );
                 editor = CKEDITOR.replace( 'feture' );

            </script>


            <div class="column half fl">

                <div class="box">
                    <h2 class="box-header">	規格 </h2>
                    <div class="box-content">



                        <textarea class="ckeditor"   name="spec"  id="spec" cols="" rows=""><?php echo $row -> spec; ?></textarea>
                    </div>

                    </div>
                </div>



            <div class="column half fr">

                <div class="box">
                    <h2 class="box-header">	 特色 </h2>
                    <div class="box-content">

                        <textarea class="ckeditor"   name="feture" id="feture" ><?php echo $row -> feture; ?></textarea>

                    </div>

                </div>
            </div>


<br />
            <div class="clear"></div>


            <script>
                CKFinder.setupCKEditor( null, '/ckfinder/' );
                var editor = CKEDITOR.replace( 'temp1' );

                CKFinder.setupCKEditor( null, '/ckfinder/' );
                editor = CKEDITOR.replace( 'temp2' );

            </script>


            <div class="column half fl">

                <div class="box">
                    <h2 class="box-header">	temp1 </h2>
                    <div class="box-content">



                        <textarea class="ckeditor"   name="temp1"  id="temp1" cols="" rows=""><?php echo $row -> temp1; ?></textarea>
                    </div>

                </div>
            </div>



            <div class="column half fr">

                <div class="box">
                    <h2 class="box-header">	 temp2 </h2>
                    <div class="box-content">

                        <textarea class="ckeditor"   name="temp2" id="temp2" ><?php echo $row -> temp2; ?></textarea>

                    </div>

                </div>
            </div>


            <br />
            <div class="clear"></div>




        </form>
        <div class="clear"></div>
    </div>
</div>



<?
$authsql="select * from webprofile";
$authquery=$this->db->query($authsql)->row();
if($authquery->ebay==1){
    ?>


<?
}
?>



    <div class="box themed_box">
        <h2 class="box-header">商品列表 </h2>
        <div class="box-content">

            <?php echo form_open_multipart('product/product_addcompanyprice'); ?>
            <label class="form-label required"> 公司名稱 </label>
            <?
            echo "<select name='companyid'>";



            echo "<option value=''></option> ";
            foreach ($company->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";

                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>


            <input class="form-field 10px" type="text" size="10" name="price">
            <input type="hidden" value="<?=$id ?>" name='proid'>
            <input type="submit" class="button white" value="ADD">
            </form>

            <form action="<?=base_url()?>index.php/product/product_companypriceupdate" method="post">
                <input type='hidden' name ='prodcopriceid' value='<?=$prodcopriceid ?>'>
                <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選/全不選</p>
                <input type="hidden" value="<?=$id ?>" name='proid'>
                <table class="display" id="tabledata">
                    <thead>
                    <tr>
                        <th>選擇</th>
                        <th>操作</th>
                        <th>公司名稱</th>
                        <th>單價</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($querypro->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                            <td><input type="checkbox" value="<?= $row->prodcopriceid ?>" name="chk[]"/></td>
                            <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "product_companypricedel" ?>/<?= $row->prodcopriceid ?>/<?= $row->productid ?>">刪除</a></td>
                            <td class="nCategory"><?=$row->companyname?>  </td>

                            <td class="nCategory"> <input class="form-field "    type="text" value="<?=$row->price?>"  name="price<?=$row->prodcopriceid ?>">  </td>
                        </tr>
                    <? }
                    ?>
                    </tbody>
                </table>
                <input type="submit" class="button white" value="更新" >
            </form>

            <div class="clear"></div>
        </div>
    </div>


<?php }?>
</div>


<script>

    function SuggestedCategories(){

        var oform = document.forms["ebayform"];
       var title= oform.elements.ebaytitle.value;


        window.open('<?=$adminurl?>SuggestedCategories/19/'+title, 'SuggestedCategories', config='height=600,width=800');
    }

    function FindProduct(){
        var oform = document.forms["ebayform"];
        var title= oform.elements.ebaytitle.value;


        window.open('<?=$adminurl?>FindProduct/'+title, 'FindProduct', config='height=600,width=800');

    }

</script>
  <div id="tabs-2">


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
        <?  $sql="select * from  accounttoken";
        $query=$this->db->query($sql);
        foreach($query->result() as $rowv){
            ?>
            <option value=''>---<?=$rowv->username?></option>
            <?
            $xml= $this -> all_model -> getStore($rowv->accounttokenid);
            $xml=simplexml_load_string($xml);
            $order= $xml->Store->CustomCategories->CustomCategory;
            foreach($order as $row1){
                ?>
                <option
                    <?
                    if($row->storecategory ==$row1->CategoryID){
                        ?>
                        selected
                    <?
                    }
                    ?>
                    value='<?=$row1->CategoryID?>'><?=$row1->Name?></option>
            <?
            }
        }?>
    </select>

    <label class=""> ProductReferenceID: </label>
    <input type="text" class="form-field 10" value="<?=$row->ProductReferenceID?>" name="ProductReferenceID" size="20" />

   <a target="_blank" onclick="FindProduct()" >依照編題尋找是否在ebay上有專屬目錄</a>
    <br>

    <label class=""> eBay Title: </label><label style="color:red;" id="nowlen" ></label>
    <input type="text" class="form-field" value="<?=$row->ebaytitle?>" onkeyup="ValidateNumber(this,value)" name="ebaytitle" size="50" maxlength="80" />


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
        <input type="text" class="form-field 30" value="jwliu@me.com" name="PayPalEmailAddress" size="20" />
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
    <div class="column half fl">

    <div class="box">
        <h2 class="box-header">	US </h2>
        <div class="box-content">


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

            <br>



        </div>
    </div>
</div>

    <div class="column half fr">

    <div class="box">
    <h2 class="box-header">	International </h2>
    <div class="box-content">


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
    </div>
    </div>

<!-- -->

    <div class="clear"></div>

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

    <br>



    <div class="column full">

        <div class="box">
            <h2 class="box-header">	Return </h2>
            <div class="box-content">

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
        </div>
    </div>



    <input name="ListingType" type="hidden" value="FixedPriceItem">
    <input name="id" type="hidden" value="<?php echo $id; ?>">
    <input type="submit"  class="button white" value="SAVE" />

    <div class="clear"></div>

    </form>

    </div>
    </div>

    </div>

</div>
</div>
</div>




      
</div>



