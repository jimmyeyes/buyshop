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

        	  <form action="<?=$url?>product/product_bath" method="post">
            <input type='hidden' name ='productid' value='<?=$productid ?>'>
            	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選
            		
           <select name="modtype">
         
          <option value="1">編輯</option>
           <option value="3">上傳ebay</option>
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
                        <th>ITEMID</th>
                        <th>END Date</th>

                        
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
                                <td><input type="checkbox" value="<?=$row->productid ?>" name="chk[]"/></td>
                                <!--	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "product_del" ?>/<?= $row->productid ?>">刪除</a></td> -->
                                <td class="nCategory"><?=$row->category?>  </td>
                                <td class="nCategory"><?=$row->brand?>  </td>
                                <td class="nTitle"><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>
                                <td class="nCategory"><?=$row->model?>  </td>
                                <td class="nCategory"><?=$row->ItemID?></td>
                                <td class="nCategory">

                                <?
                                if($row->accounttokenid !=""){
                                    $itemdetail=  $this->all_model->product_ebay_get_item($row->accounttokenid,$row->ItemID);
                                    //echo $itemdetail;

                                    $xml=simplexml_load_string($itemdetail);
                                    echo $xml->Item->ListingDetails->EndTime;
                                }
                                ?>

                            </td>

                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            
            <br /> <br />
            
         <!--     <input type="submit" class="button themed" value="Submit">-->
            </form>
            
            <div class="clear"></div>
        </div>
    </div>
    

   
</div>
