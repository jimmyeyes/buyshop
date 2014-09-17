<?= $menu ?>
<div id="subnavbar">
</div>

<script>
function check_all(obj,cName) 
{ 
	
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 

</script>
<div id="content">

<div class="column full">
    <div class="box themed_box">
        <h2 class="box-header">列表 </h2>
        <div class="box-content">
        	  <form action="<?=$url?>inventory/inventory_update2" method="post">
       	   <input type='hidden' name ='inventorylistid' value='<?=$inventorylistid ?>'>
		 <input type='hidden' name ='inventoryid' value='<?=$inventoryid ?>'>

          	 <label >  單價： </label>
			<input class="form-field "    type="text"  name="price">
			
			 <label >  數量： </label>
			<input class="form-field "    type="text"  name="amount">
			
		
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>選擇</th>
                        <th>品名</th>
      					<th>單價</th>
                        <th>數量</th>
                      
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
                        	
                         	<td><input type="checkbox" value="<?= $row->inventorylistid ?>" name="chk[]"/>
                         		<a onClick="return check();" href="<?= $adminurl . "inventory_del" ?>/<?= $row->inventorylistid ?>/2/<?= $row->productid ?>">刪除</a>
                         	
                         	</td>
                           <td class="nTitle"><?= $row->prodname ?></td>
                           <td class="nCategory"><?=$row->price?>  </td>
                           <td class="nCategory"><?=$row->amount?>  </td>

                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
             <input type="submit" value="更新" >
            </form>
            <div class="clear"></div>
        </div>
    </div>
     </div>
     
     <div class="column full">
    <div class="box themed_box">
        <h2 class="box-header">退貨操作列表 </h2>
        <div class="box-content">
        
			
            <table class="display" id="tabledata1">
                <thead>
                    <tr>
                    	<th>選擇</th>
                        <th>品名</th>
      					<th>單價</th>
                        <th>數量</th>
                      
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
                        	
                        	<td>
                        	  <form action="<?=$url?>welcome/inventory_back_opt" method="post">
       	 		      
 					    <input type='hidden' name ='inventorylistid' value='<?=$row->inventorylistid ?>'>
                        	
                        	  <input type="submit" value="退貨" >
                         	</td>
                           <td class="nTitle"><?= $row->prodname ?></td>
                           <td class="nCategory"><?=$row->price?>  </td>
                           <td class="nCategory"><input type="text" value="<?=$row->amount?>" name ="amount">  </td>
                           
							</form>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
           
            </form>
            <div class="clear"></div>
        </div>
    </div>
     </div>
 
</div>
