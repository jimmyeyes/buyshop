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
       	    <input type='hidden' name ='purchaseid' value='<?=$purchaseid1 ?>'>
       	      <input type='hidden' name ='type' value='1'>
        	  <label > 公司名稱 </label>
            <?
            $type=1;
            
            echo "<select id=\"select\" name='companyid'>";
            $sql = "select * from company";

            $queryco = $this->db->query($sql);
			 echo "<option value=''></option> ";
            foreach ($queryco->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
               
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
            
          
			
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk1[]')" />全選</p> 
            <table class="display" id="">
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
                    foreach ($query1->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	<td><input type="checkbox" value="<?= $row->purchaseid ?>" id="chk" name="chk1[]"/></td>
                        	 <td class="nTitle"><a onClick="return check();"  href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                             <td class="nTitle"><input class="form-field datepicker"   type="text" value="<?= $row->pdate ?>"  name="pdate"></td>
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
    
    
    <div class="box themed_box">
        <h2 class="box-header">已訂 </h2>
        <div class="box-content">
       <form action="<?=$url?>purchase/orderbathupdate" method="post">
       	    <input type='hidden' name ='purchaseid' value='<?=$purchaseid2 ?>'>
       	      <input type='hidden' name ='type' value='2'>
        	
        		<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk2[]')" />全選</p> 
            <table class="display" id="">
                <thead>
                    <tr>
                    	<th>選擇</th>
                    	<th>操作</th>
                        <th>日期</th>
                        <th>發票號碼</th>
                        <th>單價</th>
                        <th>付款狀態</th>
                        <th>交易條件</th>
                        <th>公司名稱</th>
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
                    $type="2";
                    $i = 0;
                    foreach ($query2->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	<td><input type="checkbox" value="<?= $row->purchaseid ?>" name="chk2[]"/></td>
                           <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                            <td class="nTitle"><input class="form-field datepicker"   type="text" value="<?= $row->pdate ?>"  name="pdate<?=$row->purchaseid ?>"></td>
                            
                          <td class="nCategory">  <input class="form-field "    type="text"  name="no<?=$row->purchaseid ?>"></td>
                           <td class="nCategory"><input class="form-field "    type="text"  name="price<?=$row->purchaseid ?>">  </td>
                            <td class="nCategory"> 
                            <select   name='paytype<?=$row->purchaseid ?>'>
				<option value='0'>待付</option> 
           		 <option value='1'>結清 </option>
              </select>
                            	 </td>
                           <td class="nCategory">  <select  name='alpay<?=$row->purchaseid ?>'>
				<option value='0'>現金</option> 
           		 <option value='1'>支票 </option>
              </select> </td>
                            
                            
                            <td class="nCategory"><?=$row->companyname?>  </td>
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
            <input type="submit" value="入庫" >
            </form>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="box themed_box">
        <h2 class="box-header">歷史訂單 </h2>
        <div class="box-content">
        	  <form action="<?=$url?>purchase/historyorderbath" method="post">
            <input type='hidden' name ='purchaseid' value='<?=$purchaseid4 ?>'>
       	      <input type='hidden' name ='type' value='4'>
        	
            
            <label >  日期： </label>
			<input class="form-field datepicker"    type="text" value="<?=$pdate?>" name="pdate">
			
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk3[]')" />全選/全不選
        		
        		 <select name="modtype">
         
          <option value="1">編輯</option>
            <option value="2">刪除</option>
          </select>
          </p> 
        		
            <table class="display" id="tabledata4">
                <thead>
                    <tr>
                   	<th>選擇</th>
                   <!-- <th>操作</th> -->
                    <th>日期</th>
                    <th>公司名稱</th>
                    <th>類別名稱</th>
                    <th>品牌</th>
     				<th>品名</th>
                    <th>型號</th>
                    <th>SKU</th>
                     <th>數量</th>
                     <th>發票號碼</th>
                     <th>單價</th>
                     <th>付款狀態</th>
                    <th>交易條件</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $type=4;
                    $i = 0;
                    foreach ($query4->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	<td><input type="checkbox" value="<?=$row->purchaseid ?>" name="chk3[]"/></td>
                          
                        <!--    <td class="nTitle"><a onClick="return check();"  href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td> -->
                        	 <td class="nTitle"><?= $row->pdate ?></td>
                             <td class="nCategory"><?=$row->companyname?>  </td>
                               <td class="nCategory"><?=$row->category?>  </td>
                               <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nCategory"><?=$row->prodname?>  </td>
                           <td class="nCategory"><?=$row->model?>  </td>
                           	<td class="nCategory"><?=$row->sku?>  </td>	
                           	<td class="nCategory"><?=$row->amount?>   </td>		
							<td class="nCategory"><?=$row->no?> </td>	
							<td class="nCategory"><?=$row->price?>  </td>	
						
					<!--	 <td class="nCategory"> 
                            <select   name='paytype<?=$row->purchaseid ?>'>
                            	<?if($row->paytype==0){?>
								<option selected value='0'>待付</option> 
           						 <option value='1'>結清 </option>
           						 <?}else{?>
           		 				<option value='0'>待付</option> 
           						 <option selected value='1'>結清 </option>
           						  <?}?>
           						  </select>
                            	 </td>
                           <td class="nCategory">  <select  name='alpay<?=$row->purchaseid ?>'>
                           	
                           	<?if($row->alpay==0){?>
           						 <option selected value='0'>現金</option> 
           						 <option value='1'>支票 </option>
           		 
           						  <?}else{?>
           						 <option value='0'>現金</option> 
           						  <option selected value='1'>支票 </option>
           		 	 	
           		 	 	 	 <?}?>
           						  </select> </td>-->
						
						
						<td class="nCategory"><?=$this->all_model->getPayType($row->paytype)?>  </td>	
						<td class="nCategory"><?=$this->all_model->getAlPay($row->alpay)?>  </td>	
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
               <br /> <br />
            
            <input type="submit" class="button themed" value="Submit" >
            </form>
            <div class="clear"></div>
        </div>
    </div>
    
    
</div>