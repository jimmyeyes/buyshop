<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">
	
	 <div class="box themed_box">
        <h2 class="box-header"> 新增項目</h2>
        <div class="box-content">
            <?php echo form_open_multipart('account/income_adds'); ?>
           
            <?
            echo "<select name='accounttypeid'>";
            $sql = "select * from accounttype";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
           
          
            <select name='inout'>
			<option value='0'>收入</option> 
      		 <option value='1'>費用</option>
      		  <option value='2'>成本</option>
            </select>
            
            金額 <input class="form-field 10px" type="text" name='amount' value="">
            
            <labe>  日期： </label>
			<input class="form-field datepicker"    type="text" name="pdate">
            
            <input type="submit" class="button white" value="ADD">
            </form>
        </div>
        </div>
        
        
         <div class="box themed_box">
        <h2 class="box-header"> 搜尋</h2>
        <div class="box-content">
           <form action="<?=$url?>account/income" method="post">
           
         
            <labe>  日期： </label>
			<input class="form-field datepicker"  value="<?=$pdates?>"   type="text" name="pdates">
			
			<input class="form-field datepicker"  value="<?=$pdatee?>"  type="text" name="pdatee">
            
            
            <input type="submit" class="button white" value="搜尋">
            </form>
        </div>
        </div>


        <div class="box themed_box">
        <h2 class="box-header"> Income Statement</h2>
        <div class="box-content">
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>刪除</th>
                    	<th>日期</th>
                    	<th>會計科目</th>
                    	<th>收入/費用/成本</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $in=0;
					$out=0;
                    
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	<td><a href="<?= $adminurl . "income_del" ?>/<?= $row->incomeid ?>">刪除</a></td>
                        		<td><?=$row->pdate?></td>
                        	<td><?=$row->name?></td>
                        	<td><?=$this->all_model->getInout($row->type)?></td>
                        	<td><?=$row->amount?></td>
                        </tr>
                        <? 
                        
                        if($row->type==0){
                        	$in+=$row->amount;
                        }else{
                        	$out+=$row->amount;
                        }
                        
                        
					}
                    ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
    
        <div class="box themed_box">
        <h2 class="box-header">Financial summary</h2>
        <div class="box-content">
            
            <h2>Net Income:</h2>
            
            <?=$in-$out?>
            
            <br />
             <h2>Net Profit Margain:</h2>
              <?php
              $div="";
             if($out !=0 & $in!=0)
               $div=@$out/$in;
              if($div!=0){
              echo 	$div *100;
              }
             ?>
            
            <br />
            
            <div class="clear"></div>
        </div>
    </div>
</div>
