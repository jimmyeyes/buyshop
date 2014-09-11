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
        <h2 class="box-header">商品列表 </h2>
        <div class="box-content">
        	
        	  <form action="<?=$url?>product/product_ebayuploadbath" method="post">

            <input type='hidden' name ='productid' value='<?=$productid ?>'>
            	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
        	
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th></th>
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
                        	 <td class="nCategory"><?=$row->category?>  </td>
                        	 <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nTitle"><?=$row->prodname?></td>
                            <td class="nCategory"><?=$row->model?> </td>
                           <td class="nCategory"><?=$row->sku?></td>
                           <td class="nCategory">  <?=$row->ean?> </td>
                           <td class="nCategory"><?=$row->upc?> </td>
                            <td class="nCategory"><?=$row->mpn?></td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            
            <br /> <br />
            

            
            <div class="clear"></div>
        </div>

        <div  class="box themed_box">
        <h2 class="box-header">上傳ebay</h2>
        <div class="box-content">

        <label class="form-label"> ebay ID: </label>
        <select name="accounttokenid">
            <?  $sql="select * from  accounttoken  ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option


                    value='<?=$rowv->accounttokenid?>'><?=$rowv->username?></option>
            <? }?>
        </select>
        <label class="form-label"> Category: </label>
        <input type="text" class="form-field 10" value="" name="category" size="20" />
        <a target="_blank" href='http://listings.ebay.com/_W0QQloctZShowCatIdsQQsacatZQ2d1QQsalocationZatsQQsocmdZListingCategoryList'>Select Category</a>
        <br>

        <label class="form-label"> Condition: </label>
        <select name="condition">
            <?  $sql="select * from  varlist where type=2 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>


        <label class="form-label"> Country: </label>
        <select name="Country">
            <? if($row->Country=="US"){?>
                <option selected value='US'>US</option>
                <option  value='TW'>TW</option>
            <?}else{?>
                <option value='US'>US</option>
                <option selected  value='TW'>TW</option>

            <?}?>
        </select>
        <br>

        <label class="form-label"> PaymentMethods: </label>
        <select name="PaymentMethods">
            <option value='PayPal'>PayPal</option>
        </select>
        <br>

        <label class="form-label"> PayPalEmailAddress: </label>
          <input type="text" class="form-field 30" value="jwliu@me.com" name="PayPalEmailAddress" size="20" />


        <br>

        <label class="form-label"> Price: </label>
        <input type="text" class="form-field 10" value="45.4" name="StartPrice" size="20" />US Dollar



        <select name="pricetype">

            <? if($row->pricetype=="auction"){?>
                <option selected value='auction'>auction</option>
                <option  value='fix'>fixed-price</option>
            <?}else{?>
                <option value='auction'>auction</option>
                <option selected value='fix'>fixed-price</option>

            <?}?>
        </select>


        <br>
        <label class="form-label"> Quantity: </label>


            <input type="text" class="form-field 10"  value="4"  name="quantity" size="20" />

        <br>

        <label class="form-label"> ListingDuration: </label>
        <select name="ListingDuration">
            <?  $sql="select * from  varlist where type=3 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option
                    <?
                    if($rowv->no=="Days_30"){
                        ?>
                        selected
                    <?

                    }
                    ?>

                    value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>

        <label class="form-label"> ReturnsAcceptedOption: </label>
        <select name="ReturnsAcceptedOption">



                <option selected  value='ReturnsAccepted'>ReturnsAccepted</option>
                <option  value='ReturnsNotAccepted'>ReturnsNotAccepted</option>

        </select>
        <br>

        <label class="form-label"> RefundOption: </label>
        <select name="RefundOption">
            <?  $sql="select * from  varlist where type=4 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>



        <label class="form-label"> ReturnsWithinOption: </label>
        <select name="ReturnsWithinOption">
            <?  $sql="select * from  varlist where type=5 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>

        <label class="form-label"> Description: </label>



            <textarea name="Description"   id="spec" cols="50" rows="5"></textarea>

     	<br>

        <label class="form-label"> ShippingType: </label>
        <select name="ShippingType">
            <?  $sql="select * from  varlist where type=6 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option


                    value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>
        <label class="form-label"> FreeShipping: </label>
        <select name="FreeShipping">



                <option  value='1'>1</option>
                <option selected  value='0'>0</option>

        </select>
        <br>


        <label class="form-label"> ShippingCostPaidByOption: </label>
        <select name="ShippingCostPaidByOption">

                <option  value='Buyer'>Buyer</option>

        </select>
        <br>


        <label class="form-label"> ShippingServicePriority: </label>
        <select name="ShippingServicePriority">
            <?
            for($i=0;$i<6;$i++){
                ?>
                <option value='<?=$i?>'><?=$i?></option>
            <? }?>
        </select>
        <br>
        <label class="form-label"> ShippingService: </label>
        <select name="ShippingService">
            <?  $sql="select * from  varlist where type=7 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option
                    <?
                    if($rowv->no=="ExpeditedShippingFromOutsideUS"){?>selected
                    <?
                    }
                    ?> value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>
        <label class="form-label"> ShippingServiceCost: </label>
        <input type="text" class="form-field 10" name="ShippingServiceCost" value="12.0" size="20" />


        <br>
        <label class="form-label"> InternationalShippingServiceOption: </label>

        <label class="form-label"> InternationalShipToLocation: </label>
        <select name="InternationalShipToLocation">
            <?  $sql="select * from  varlist where type=8 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option

                    value='<?=$rowv->no?>'><?=$rowv->name?></option>
            <? }?>
        </select>
        <br>


        <label class="form-label"> InternationalShippingService: </label>
        <select name="InternationalShippingService">
            <?  $sql="select * from  varlist where type=7 ";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                ?>
                <option

                    <?
                    if($rowv->no=="FedExInternationalEconomy"){?>
                    selected
                    <?
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
        <label class="form-label"> InternationalShippingServiceCost: </label>



            <input type="text" class="form-field 10" name="InternationalShippingServiceCost" value="20.0" size="20" />

        <br>

        <label class="form-label"> DispatchTimeMax: </label>


            <input type="text" class="form-field 10" name="DispatchTimeMax" value="3" size="20" />



        <br>

        <input name="ListingType" type="hidden" value="FixedPriceItem">

        <input type="submit"  class="button white" value="上傳ebay" />
        </form>
        </div>
        </div>

    </div>

   
</div>
