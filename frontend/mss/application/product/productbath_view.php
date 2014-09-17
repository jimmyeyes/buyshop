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
        	
        	  <form action="<?=$url?>product/product_updatebath" method="post">
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
                            <td class="nTitle"><input class="form-field px240"    type="text" value="<?=$row->prodname?>"  name="prodname<?=$row->productid ?>"></td>
                            <td class="nCategory"><input class="form-field "    type="text" value="<?=$row->model?>"  name="model<?=$row->productid ?>">  </td>
                          <td class="nCategory"><input class="form-field "    type="text" value="<?=$row->sku?>"  name="sku<?=$row->productid ?>"></td>
                            <td class="nCategory">  <input class="form-field "    type="text" value="<?=$row->ean?>"  name="ean<?=$row->productid ?>"> </td>
                             <td class="nCategory"><input class="form-field "    type="text" value="<?=$row->upc?>"  name="upc<?=$row->productid ?>"> </td>
                               <td class="nCategory"> <input class="form-field "    type="text" value="<?=$row->mpn?>"  name="mpn<?=$row->productid ?>"></td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            
            <br /> <br />
            
              <input type="submit" class="button themed" value="UPDATE">
            </form>
            
            <div class="clear"></div>
        </div>
    </div>
    
    
   
</div>
