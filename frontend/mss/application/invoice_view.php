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
        <h2 class="box-header"> 新增項目</h2>
        <div class="box-content">
            <?php echo form_open_multipart('account/account_adds'); ?>
           
             <label>  日期： </label>
		<input class="form-field datepicker"    type="text" name="pdate">
           
           公司名稱
            <?
            echo "<select name='companyid'>";
            $sql = "select * from company";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
               
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
           
          
            <select name='invoicetype'>
			<option value='1'>進項發票</option> 
      		 <option value='2'>銷項發票</option>
      		
            </select>
            
              發票號碼 <input class="form-field 10px" type="text" name='invoiceno' value="">
            
            會計科目
               
            <?
            echo "<select name='accounttypeid'>";
            $sql = "select * from accounttype where type=4";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
            
            金額 <input class="form-field 10px" type="text" name='amount' value="">
            
            
            <label >付款狀態</label>

			 <select id="select"  name='alpay'>
				<option value='0'>待付</option> 
           		 <option value='1'>結清 </option>
              </select>

             <label > 交易條件 </label>
         	 <select id="select"  name='paytype'>
				<option value='0'>現金</option> 
           		 <option value='1'>支票 </option>
              </select>
          
            
            <input type="submit" class="button white" value="ADD">
            </form>
        </div>
        </div>

        <div class="box themed_box">
        <h2 class="box-header"> 發票管理</h2>
        <div class="box-content">
        	
        	    <!--   <form action="<?=$url?>account/account" method="post">

        <labe>  日期： </label>
			<input class="form-field datepicker"  value="<?=$pdates?>"   type="text" name="pdates">
			
			<input class="form-field datepicker"  value="<?=$pdatee?>"  type="text" name="pdatee">
           
            <input type="submit" class="button white" value="搜尋">
            </form>
            
            -->
        	
        	  <form action="<?=$url?>account/account_bath_update" method="post">
            <input type='hidden' name ='invoiceid' value='<?=$invoiceid ?>'>

         <!--   公司名稱
            <?
            echo "<select name='companyid'>";
            $sql = "select * from company";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
               
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
			
			 <label >  發票號碼： </label>
			<input class="form-field "    type="text"  name="no"> -->
			
			<!-- <label >  金額： </label>
			<input class="form-field "    type="text"  name="amount">

                 <select name='invoicetype'>
			<option value='1'>進項發票</option> 
      		 <option value='2'>銷項發票</option>
      		
            </select>
               會計科目
               
            <?
            echo "<select name='accounttypeid'>";
            $sql = "select * from accounttype where type=4";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
            
            	<label >付款狀態</label>
			 <select id="select"  name='alpay'>
				<option value='0'>待付</option> 
           		 <option value='1'>結清 </option>
              </select>

             <label > 交易條件 </label>
         	 <select id="select"  name='paytype'>
				<option value='0'>現金</option> 
           		 <option value='1'>支票 </option>
              </select>
             -->
           
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
        	
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    		<th>選擇</th>
                    	<th>操作</th>
                        <th>日期</th>
                          <th>公司名稱</th>
                          <th>發票類型</th>
                         <th>發票號碼</th>
                          <th>會計科目</th>
                           <th>金額</th>
                           <th>付款狀態</th>
                            <th>交易條件</th>
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
                        	<td><input type="checkbox" value="<?=$row->invoiceid ?>" name="chk[]"/></td>
                        
                        	 <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "account_del" ?>/<?= $row->invoiceid ?>">刪除</a></td>
                            <td class="nTitle"><?= $row->pdate ?></td>
                            <td class="nCategory"><?=$row->companyname?>  </td>
                            <td class="nCategory">
                             <select name='invoicetype<?= $row->invoiceid ?>'>
                            	  		<?
								 	
								 	if($row->invoicetype=="1"){
								 	?>
								 	<option value='1' selected>進項發票</option> 
      								 <option value='2'>銷項發票</option>
								 	
								 	<?
									}else{
								 	?>
								 		<option value='1' >進項發票</option> 
      									 <option value='2' selected>銷項發票</option>
								 	
								 	<?
									}
								 	?>
                            	</select>
                            	<?//$this->all_model->getInvoicetype($row->invoicetype)?> 
                            	
                            	 </td>
                            <td class="nCategory"><?=$row->invoiceno?>  </td>
                           <td class="nCategory"><?=$row->accountname?> 
                           	
                           	 <?
            echo "<select name='accounttypeid$row->invoiceid'>";
            $sql = "select * from accounttype where type=4";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option";
                
				if($row2->accounttypeid==$row->accounttypeid){
					echo " selected ";
				}
				
				
                echo " value='{$row2->accounttypeid}' ";
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
                           	
                           	
                           	 </td>
                             <td class="nCategory"><input class="form-field "    type="text" value="<?=$row->amount?>"  name="amount<?= $row->invoiceid ?>">  </td>
							<td class="nCategory">
								
								 <select id="select"  name='alpay<?= $row->invoiceid ?>'>
								 	<?
								 	
								 	if($row->paytype=="1"){
								 	?>
								 	<option value='0'>待付</option> 
           							 <option value='1' selected>結清 </option>
								 	
								 	<?
									}else{
								 	?>
								 		<option value='0' selected>待付</option> 
           						 		<option value='1'>結清 </option>
								 	
								 	<?
									}
								 	?>
								
             					 </select>
								<?//$this->all_model->getPayType($row->paytype)?> 
								
								
								 </td>	
								<td class="nCategory">
								 <select id="select"  name='paytype<?= $row->invoiceid ?>'>

								<?
								 	
								 	if($row->paytype=="1"){
								 	?>
								 <option value='0'>現金</option> 
           						 <option value='1' selected>支票 </option>
								 	
								 	<?
									}else{
								 	?>
								 	 <option value='0' selected>現金</option> 
           						 <option value='1' >支票 </option>
								 	
								 	<?
									}
								 	?>
							
							
				
              </select>
							<?//$this->all_model->getAlPay($row->alpay)?>
							
							
							  </td>	
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
