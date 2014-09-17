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
        <h2 class="box-header">待訂 </h2>
        <div class="box-content">
        	
        	 <form id="form" action="<?=$url?>purchase/orderbathupdate" method="post">
       	    <input type='hidden' name ='purchaseid' value='<?=$purchaseid ?>'>
       	      <input type='hidden' name ='type' value='1'>
        	  <label > 公司名稱 </label>
            <?
            echo "<select id=\"select\" name='companyid'>";
            $sql = "select * from company";

            $query2 = $this->db->query($sql);
			 echo "<option value=''></option> ";
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
               
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
            
            <label >  日期： </label>
			
			<input class="form-field datepicker"   type="text"  name="pdate">

			
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>選擇</th>
                    	<th>操作</th>
                        <th>日期</th>
                         <th>類別名稱</th>
                        <th>品牌</th>
     					<th>品名</th>
     					
                        <th>型號</th>
                         <th>SKU</th>
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
                        	<td><input type="checkbox" value="<?= $row->purchaseid ?>" id="chk" name="chk[]"/></td>
                        	
                        	 <td class="nTitle"><a onClick="return check();"  href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                             <td class="nTitle"><a href="<?= $adminurl . "preorder_detail" ?>/<?= $row->purchaseid ?>"><?= $row->pdate ?></a></td>
                              <td class="nCategory"><?=$row->category?>  </td>
                             <td class="nCategory"><?=$row->brand?>  </td>
                             <td class="nCategory"><?=$row->prodname?>  </td>
                            
                            <td class="nCategory"><?=$row->model?>  </td>
                             <td class="nCategory"><?=$row->sku?>  </td>		
							<td class="nCategory"><input class="form-field "   type="text" value="<?=$row->amount?>" name="amount<?=$row->purchaseid ?>">  </td>	
						
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
               <input type="submit" value="已訂" >
            </form>
            <div class="clear"></div>
        </div>
    </div>
</div>