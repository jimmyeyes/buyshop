<script>
function ValidateNumber(e, value){
     document.getElementById('nowlen').innerHTML =value.length; 
    // console.log(value.length);
   // alert(value.length);
    return false;
}
</script>
	    <?php
              $sql="select m.* from  product_img m   where m.proid = $id ";
              $count=$this->db->query($sql)->num_rows();
            //  echo "系統目前有".$count."張圖，下面圖片是從ebay 抓下來的產品圖。<br />";
            //  echo form_open_multipart('product/updateebayitem'); ?>
          	<?
            $sql="select m.*,r1.username from  productonebay m left join accounttoken r1 on m.accounttokenid=r1.accounttokenid  where m.productid = $id and r1.accounttokenid='$accounttokenid' and `on` ='1' limit 2";
            $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                $itemdetail=	$this->all_model->product_ebay_get_item($rowv->accounttokenid,$rowv->ItemID);
                //echo $itemdetail;
                $xml=simplexml_load_string($itemdetail);
                //print_r($xml);
                $endtime= @$xml->Item->ListingDetails->EndTime;
                $seconds_left=  $this->time_model->ebaytimeleft($endtime);
                if($seconds_left <0){
                    $sql="update productonebay set `on`='0' where ItemID='$rowv->ItemID' and accounttokenid='$rowv->accounttokenid' and productid='$id'";
                    $this->db->query($sql);
                  }
                $this->all_model-> updateproductebayitem($id,$rowv->ItemID,$accounttokenid );
            }
            $itemid="";

        $row=  $this -> db -> get_where('productactive', array('productactiveid' => $id)) -> row();
        if($row==null){
            echo "back error";
            return;
        }
        ?>
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>Upload Image
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <?php echo form_open_multipart('product/productactive_add_img'); ?>
        <input type="file" name="userfile" size="20" />

        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <input type="hidden" value="<?=$accounttokenid ?>" name='accounttokenid'>

        <input type="submit"  class="btn blue" value="Upload" />
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

                        <form action='<?php echo $adminurl; ?>productactive_img_del' method='post'>
                            <input type="hidden" value="<?php echo $rowimg->productactive_imgid; ?>" name='id'>
                            <input type="hidden" value="<?php echo $rowimg->prodid; ?>" name='proid'>
                            <input type="hidden" value="<?=$accounttokenid ?>" name='accounttokenid'>

                            <input type='submit'  class="btn blue" value='刪除' /></form>
                    </td>
                <?php endforeach; ?>
        </table>
    </div>
</div>


<div class="portlet box blue">
<div class="portlet-title">
    <div class="caption">
        <i class="fa fa-reorder"></i>eBay Data
    </div>
    <div class="tools">
        <a href="javascript:;" class="collapse"></a>
        <a href="javascript:;" class="remove"></a>
    </div>
</div>
<div class="portlet-body form">

            <?php echo form_open_multipart('product/ReviseItem'); ?>

            <input type="hidden" value="<?=$accounttokenid ?>" name='accounttokenid'>
            <input type="hidden" value="<?=$itemid ?>" name='itemid'>
            <input type="hidden" value="<?=$id ?>" name='productid'>

            <label class=""> Ebay Account: </label>
            <select name="accountitem">
                <?
                $sql="select m.*,r1.username from  productonebay m left join accounttoken r1 on m.accounttokenid=r1.accounttokenid  where m.productid = $id and m.accounttokenid=$accounttokenid  and `on`=1";
                $query=$this->db->query($sql);
                foreach($query->result() as $rowv){

                $accounttokenid=$rowv->accounttokenid;
                $itemid=$rowv->ItemID;
                ?>
                    <option value='<?=$accounttokenid."-".$itemid?>'><?=$rowv->username?></option>
                <? } ?>
            </select>
            <br>

           
              <label class=""> Category: </label>
            <input type="text"  value="<?=$row->category?>" name="category" size="20" />
             <a href='http://listings.ebay.com/_W0QQloctZShowCatIdsQQsacatZQ2d1QQsalocationZatsQQsocmdZListingCategoryList'>Select Category</a>


            <label class="">Store Category: </label>
            <select name="storecategory">
                <?  $sql="select * from  accounttoken where accounttokenid=$accounttokenid";
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
                        <option <? if($row->storecategory ==$row1->CategoryID){ ?>selected<?}?>value='<?=$row1->CategoryID?>'>*<?=$row1->Name?></option>

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
            <input type="text"  value="<?=$row->ProductReferenceID?>" name="ProductReferenceID" size="20" />
            <br>

            <label class="">  Title: </label> <label style="color:red;" id="nowlen" ></label>
            <input type="text" class="form-field" maxlength="80" value='<?=$row->ebaytitle?>' onkeyup="ValidateNumber(this,value)" name="ebaytitle" size="50" />
           
            
              <label class=""> Condition: </label>
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

            <label class="">Brand: </label>
            <input type="text"  value='<?=$row->brand?>' name="brand" size="20" />

            <label class=""> SKU： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> sku ?>" name="sku">
            <label > UPC： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> upc ?>" name="upc">


            <label > EAN： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> ean ?>" name="ean">

            <label class=""> MPN： </label>
            <input class="form-field 20px" type="text" value="<?php echo $row -> mpn ?>" name="mpn">

            <br >

               <?

            $sql="select m.*,r1.username,r1.Currency from  productonebay m left join accounttoken r1 on m.accounttokenid=r1.accounttokenid  where m.productid = $id and m. accounttokenid=$accounttokenid and `on` ='1' ";
           // echo $sql;
               $query=$this->db->query($sql);
            foreach($query->result() as $rowv){
                $Currency=$rowv->Currency;
            ?>

            <br />

            <a target="_blank" href='<?=$this->all_model->getlisturl()?><?=$rowv->ItemID?>'>ItemID:<?=$rowv->ItemID?></a>

            結束時間:
            <?
            $itemdetail=	$this->all_model->product_ebay_get_item($rowv->accounttokenid,$rowv->ItemID);
            $xml=simplexml_load_string($itemdetail);
            $endtime= @$xml->Item->ListingDetails->EndTime."";
            echo $endtime;



            echo  "(".$this->time_model->ebaytimeleft($endtime).")<br />";
            $imgurl= @$xml->Item->PictureDetails->PictureURL;
            if($imgurl){
                ?>
                <img src="<?=$imgurl?>" width="150px" />
            <?
            }

            ?>
            <br />

                <input name="productid" type="hidden" value="<?= $id; ?>">
                <input name="itemid" type="hidden" value="<?= $itemid ?>">
                <input name="accounttokenid" type="hidden" value="<?=$accounttokenid ?>">
                <a href="<?=$url?>product/product_ebay_pic_update/<?= $id; ?>/<?= $itemid ?>/<?=$accounttokenid ?>"   class="button white"  >Update ebay pic</a>
            <br />
            <? }?>


            <?
            if($row->currencyID=="GBP"){

                ?>

                <label class=""> Price: </label>

                <input type="text"  value="<?=$row->PriceGBP?>" name="PriceGBP" size="20" />


                GBP Dollar
            <?

            }else  if($row->currencyID=="AUD"){
                ?>
                <label class=""> Price: </label>

                <input type="text"  value="<?=$row->PriceAUD?>" name="PriceAUD" size="20" />

                AUD Dollar
            <?


            }else  if($row->currencyID=="USD"){
                ?>


                <label class=""> Price: </label>
                <input type="text"  value="<?=$row->StartPrice?>" name="StartPrice" size="20" />

                US Dollar
            <?

            }
            ?>


            <label class=""> Quantity: </label>
           	 <input type="text"   value="<?=$row->Quantity?>"  name="quantity" size="20" />

             
                <label class=""> ListingDuration: </label>
         	 <select name="ListingDuration">
          	<?  $sql="select * from  varlist where type=3 ";
          		$query=$this->db->query($sql);
				foreach($query->result() as $rowv){
          	?>
          			<option
          			<?
          			if($row->ListingDuration ==$rowv->no){
          				?>
          				selected
          				<?
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

                <input type="text"  value="<?=$row->PayPalEmailAddress?>" name="PayPalEmailAddress" size="20" />


            <label class="">  Auto Pay</label>
            <? if($row->AutoPay=="true"){?>
                <input type="checkbox" checked name="autopay"  />
            <?}else{?>
                <input type="checkbox" name="autopay" />

            <?}?>
            Require immediate payment when buyer uses Buy It Now
            <br>



            <div class="column full">

                <div class="box">
                    <h2 class="box-header">	規格 </h2>
                    <div class="box-content">

                        <textarea class="ckeditor"   name="spec"  id="spec" cols="" rows=""><?php echo $row -> spec; ?></textarea>
                    </div>

                </div>
            </div>


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
                        <?
                        if($row->ShippingService ==$rowv->no){?>selected
                        <?

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
                <input type="text"  name="ShippingServiceCost" value="<?=$row->ShippingServiceCost?>" size="20" />
            <br>
            <label class="">AdditionalCost: </label>
                <input type="text"  name="ShippingServiceAdditionalCost" value="<?=$row->ShippingServiceAdditionalCost?>" size="20" />
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
                        <?

                        if($row->ShippingService2 ==$rowv->no){?>selected
                        <?
                        }

                        ?> value='<?=$rowv->no?>'><?=$rowv->name?></option>
                <? }?>
            </select>
            <br>
            <label class=""> Cost2: </label>


                <input type="text"  name="ShippingServiceCost2" value="<?=$row->ShippingServiceCost2?>" size="20" />


            <br>

            <label class=""> AdditionalCost2: </label>


                <input type="text"  name="ShippingServiceAdditionalCost2" value="<?=$row->ShippingServiceAdditionalCost2?>" size="20" />


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
                <input type="text"  name="InternationalShippingServiceCost" value="<?=$row->InternationalShippingServiceCost?>" size="20" />
            <br>
            <label class=""> ServiceAdditionalCost: </label>
                <input type="text"  name="InternationalShippingServiceAdditionalCost" value="<?=$row->InternationalShippingServiceAdditionalCost?>" size="20" />
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

                <input type="text"  name="InternationalShippingServiceCost2" value="<?=$row->InternationalShippingServiceCost2?>" size="20" />

            <br>

            <label class=""> ServiceAdditionalCost2: </label>


                <input type="text"  name="InternationalShippingServiceAdditionalCost2" value="<?=$row->InternationalShippingServiceAdditionalCost2?>" size="20" />

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
            <hr >
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


            <?}?>

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
        <input type="text"  value='<?=$row->Location?>' name="Location" size="20" />

            <br>

		  
               <label class=""> DispatchTimeMax: </label>
	 		 <input type="text"  name="DispatchTimeMax" value="<?=$row->DispatchTimeMax?>" size="20" />
		</div>

            <div class="col-md-6">
                <hr >
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

            <input name="accounttokenid" type="hidden" value="<?=$accounttokenid ?>">

            <input type="submit"  class="btn blue" value="更新 eBay 資料" />
            </form>

        </div>
      </div>