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
    <div class="box themed_box">
        <h2 class="box-header">退貨列表 </h2>
        <div class="box-content">
        	
        	  <form action="<?=$url?>inventory/inventory_back_bathupdate" method="post">
       	   <input type='hidden' name ='inventorylistid' value='<?=$inventorylistid ?>'>

		<!--	  <label > 公司名稱 </label>
            <select id='company' name='companyid' >
           <option value=''></option>
          
            	 <?
            $sql = "select m.* from company m ";
	//echo $sql;
            $query2 = $this->db->query($sql);
			 echo " ";
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
			
			 <label >  發票號碼： </label>
			<input class="form-field "   type="text"  name="no">
			
        		<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選/全不選</p> -->
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<!--<th>選擇</th> -->
                    	<th>操作</th>   
                        <th>類別名稱</th>
                         <th>品牌</th>
                        <th>品名</th>
     					<th>型號</th>
                        <th>SKU</th>
                        <th>數量</th>
                        <th>單價</th>
                       
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
                        	<!-- <td><input type="checkbox" value="<?=$row->inventorylistid ?>" name="chk[]"/></td> -->
                        	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "inventory_del" ?>/<?= $row->inventorylistid ?>/1">刪除</a> </td>
                         
                                <td class="nCategory"><?=$row->category?>  </td>
                           <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nTitle"><?= $row->prodname ?></td>
                            <td class="nCategory"><?=$row->model?>  </td>
                            <td class="nCategory"><?=$row->sku?>  </td>
                           <td class="nCategory"><?=$row->amount?>  </td>
                        <td class="nCategory"><?=$row->price?>  </td>       
                          
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
           <!--   <input type="submit" value="更新" >
           </form> -->
            <div class="clear"></div>
        </div>
    </div>

</div>
