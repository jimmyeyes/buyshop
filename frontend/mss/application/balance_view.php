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

function SelZero(vall){
	var arr=new Array();
	<?php 
	
			$string="";
			$val="";
	        $sql = "select * from varlist m where type=1 ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            	  $sql = "select m.* from accounttype m where type=".$row->no." ";
             	 $query2 = $this->db->query($sql);
			
			$string.="var p".$row->no."={";
			$val="";
			$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            		if($val==""){
            			$val.="'".$row2->accounttypeid."' : '".$row2->name."'";
            		}else{
            			$val.=",'".$row2->accounttypeid."' : '".$row2->name."'";
            		}
				}
				
				$string.=$val." };     ";
	
			}
		 echo $string;

		  $sql = "select m.* from varlist m where m.type=1";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr[".$row->varlistid."] = p".$row->varlistid.";";
			}

	?>

	
 $("#accounttypeid").removeOption(/./);         //先移除原有的選項
 //alert( arr[1]);
    $("#accounttypeid").addOption(arr[vall], false); //帶入新的選項

	
}
function SelZero1(vall){
	var arr=new Array();
	<?php 
	
			$string="";
			$val="";
	        $sql = "select * from varlist m where type=1 ";
	
            $query = $this->db->query($sql);
			
            foreach ($query->result() as $row) {
            	  $sql = "select m.* from accounttype m where type=".$row->no." ";
             	 $query2 = $this->db->query($sql);
			
			$string.="var p".$row->no."={";
			$val="";
			$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            		if($val==""){
            			$val.="'".$row2->accounttypeid."' : '".$row2->name."'";
            		}else{
            			$val.=",'".$row2->accounttypeid."' : '".$row2->name."'";
            		}
				}
				
				$string.=$val." };     ";
	
			}
		 echo $string;

		  $sql = "select m.* from varlist m where m.type=1";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr[".$row->varlistid."] = p".$row->varlistid.";";
			}

	?>

	
 $("#accounttypeid1").removeOption(/./);         //先移除原有的選項
 //alert( arr[1]);
    $("#accounttypeid1").addOption(arr[vall], false); //帶入新的選項

	
}
function SelZero2(vall){
	var arr=new Array();
	<?php 
	
			$string="";
			$val="";
	        $sql = "select * from varlist m where type=1";
	
            $query = $this->db->query($sql);
			
            foreach ($query->result() as $row) {
            	  $sql = "select m.* from accounttype m where type=".$row->no." ";
             	 $query2 = $this->db->query($sql);
			
			$string.="var p".$row->no."={";
			$val="";
			$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            		if($val==""){
            			$val.="'".$row2->accounttypeid."' : '".$row2->name."'";
            		}else{
            			$val.=",'".$row2->accounttypeid."' : '".$row2->name."'";
            		}
				}
				
				$string.=$val." };     ";
	
			}
		 echo $string;

		  $sql = "select m.* from varlist m where m.type=1";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr[".$row->varlistid."] = p".$row->varlistid.";";
			}

	?>

	
 $("#accounttypeid2").removeOption(/./);         //先移除原有的選項
 //alert( arr[1]);
    $("#accounttypeid2").addOption(arr[vall], false); //帶入新的選項

	
}
function SelZero3(vall){
	var arr=new Array();
	<?php 
	
			$string="";
			$val="";
	        $sql = "select * from varlist m where type=1 ";
	
            $query = $this->db->query($sql);
			
            foreach ($query->result() as $row) {
            	  $sql = "select m.* from accounttype m where type=".$row->no." ";
             	 $query2 = $this->db->query($sql);
			
			$string.="var p".$row->no."={";
			$val="";
			$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            		if($val==""){
            			$val.="'".$row2->accounttypeid."' : '".$row2->name."'";
            		}else{
            			$val.=",'".$row2->accounttypeid."' : '".$row2->name."'";
            		}
				}
				
				$string.=$val." };     ";
			}
		 echo $string;

		  $sql = "select m.* from varlist m where m.type=1";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            	echo "arr[".$row->varlistid."] = p".$row->varlistid.";";
			}

	?>

	
$("#accounttypeid3").removeOption(/./);         //先移除原有的選項
 //alert( arr[1]);
$("#accounttypeid3").addOption(arr[vall], false); //帶入新的選項

	
}
</script>
<div id="content">
	<div class="column full">
	 <div class="box themed_box">
        <h2 class="box-header"> 新增項目</h2>
        <div class="box-content">
            <?php echo form_open_multipart('account/balance_adds'); ?>
           
             <label>  日期： </label>
		<input class="form-field datepicker"    type="text" name="pdate">

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
            
              <select name='inout' >
             <option value=''></option> 
            <option value='1'>資產</option> 
			<option value='2'>負債</option> 
      		 <option value='3'>業主權益</option>
            </select>

            金額 <input class="form-field 10px" type="text" name='amount' value="">
            
            <input type="submit" class="button white" value="ADD">
            </form>
        </div>
        </div>

    </div>
    
      <div class="box themed_box">
        <h2 class="box-header"> 搜尋</h2>
        <div class="box-content">
           <form action="<?=$url?>account/balance" method="post">
           
         
            <labe>  日期： </label>
			<input class="form-field datepicker"  value="<?=$pdates?>"   type="text" name="pdates">
			
			<input class="form-field datepicker"  value="<?=$pdatee?>"  type="text" name="pdatee">
            
            
            <input type="submit" class="button white" value="搜尋">
            </form>
        </div>
        </div>
    
    <div class="column full">
	 <div class="box themed_box">
        <h2 class="box-header">Balance Sheet</h2>
        <div class="box-content">
          
         <table style="width:100%;">
         	<tr style="width:50%; ">
         		<td>
         			
         	 <table style="width:50%;float:left;">
         	   <tr>
         		<td><h2>Assets<h2></td>
         		</tr>
         	
         			
         			  <?php
                  $i=0;
				    $total=0;
                    foreach ($querytab1->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	
                        	<td><?=$row->pdate;?></td>
                        	<td><?=$row->name;?></td>
                        	
                        	<td><?=$row->amount?></td>
                        </tr>
                        <? 
                        	@$total+=$row->amount;
					}
                    ?>
                      <tr><td></td><td></td><td><h3><?=	@$total;?></h3></td></tr>
         	</table> 
         
         	</td><td>
         		
         		 <table  style="width:50%;float:right;">
         	<tr>
         		<td><h2>Liabilities</h2></td>
         	<tr>
         		  <?php
                  $i=0;
				  $total=0;
                    foreach ($querytab2->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	
                        	<td><?=$row->pdate;?></td>
                        	<td><?=$row->name;?></td>
                        	<td><?=$row->amount?></td>
                        </tr>
                        <? 
					 @$total+=$row->amount;
					}
                    ?>
                   <tr><td></td><td></td><td><h3><?=	@$total;?></h3></td></tr>
         	</table> 
         
         	</td>
         	<tr>
         	
         	<tr>
         		<td></td><td>
         			
         			 <table style="width:50%;float:right;">
         	
         	<tr>
         		<td><h2>Owner's Equity</h2></td>
         	<tr>
         		
         		  <?php
                  $i=0;
				  $total=0;
                    foreach ($querytab3->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	
                        	<td><?=$row->pdate;?></td>
                        	<td><?=$row->name;?></td>
                        	
                        	<td><?=$row->amount?></td>
                        </tr>
                        <? 
					 	@$total+=$row->amount;
					}
                    ?>
                      <tr><td></td><td></td><td><h3><?=	@$total;?></h3></td></tr>
         	</table> 
         	
         			
         		</td>
         	<tr>
         	</table> 
          
        </div>
        </div>

    </div>
    
    

<div class="column half fl">
        <div class="box themed_box">
        <h2 class="box-header"> Assets</h2>
        <div class="box-content">

        	  <form action="<?=$url?>account/balance_bath_update" method="post">
            <input type='hidden' name ='balanceid' value='<?=$balanceid1 ?>'>
              <input type='hidden' name ='type' value='1'>

            
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk1[]')" />全選</p> 
        	
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>選擇</th>
                        <th>刪除</th>
                   		 <th>日期</th>
                    	<th>會計科目</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
					  $in=0;
					$out=0;
					$Assetsin=0;
                    foreach ($query1->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        		<td><input type="checkbox" value="<?=$row->balanceid ?>" name="chk1[]"/></td>
                        	<td><a onClick="return check();"  href="<?= $adminurl . "balance_del" ?>/<?= $row->balanceid ?>">刪除</a></td>
                        	<td>
                        		
                        			<input class="form-field datepicker"  value="<?=$row->pdate;?>"  type="text" name="pdate<?= $row->balanceid ?>">
                        		</td>
                        	
                        	
                        	<td>
                        	
                        	  <?
            echo "<select name='accounttypeid$row->balanceid'>";
            $sql = "select * from accounttype";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option";
                
				if($row->accounttypeid==$row2->accounttypeid){
					echo " selected ";
				}
				
                echo " value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
</td>
                        	
                        	<td>
                        		<input class="form-field 10px" type="text" name='amount<?= $row->balanceid ?>' value="<?=$row->amount?>">
                        		</td>
                        </tr>
                        <? 
                        	@$Assetsin+=$row->amount;
					}
                    ?>
                </tbody>
            </table>
             
               <input type="submit" class="button white" value="修改">
                <h2> Assets:<?=@$Assetsin?></h2>
          </form>
        </div>
    </div>

    </div>
    
    <div class="column half fr">
        <div class="box themed_box">
        <h2 class="box-header">liabilities </h2>
        <div class="box-content">
        	
        	 <form action="<?=$url?>account/balance_bath_update" method="post">
            <input type='hidden' name ='balanceid' value='<?=$balanceid2 ?>'>
              <input type='hidden' name ='type' value='2'>

  
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk2[]')" />全選</p> 
        	
            <table class="display" id="tabledata1">
                <thead>
                    <tr>
                    	<th>選擇</th>
                   		<th>刪除</th>
                    	 <th>日期</th>
                    	<th>會計科目</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
					  $in=0;
					$out=0;
					$liabilitiesout=0;
                    foreach ($query4->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        		<td><input type="checkbox" value="<?=$row->balanceid ?>" name="chk2[]"/></td>
                        	<td><a onClick="return check();"  href="<?= $adminurl . "balance_del" ?>/<?= $row->balanceid ?>">刪除</a></td>
                        <td>
                        		
                        			<input class="form-field datepicker"  value="<?=$row->pdate;?>"  type="text" name="pdate<?= $row->balanceid ?>">
                        		</td>
                        	
                        	
                        	<td>
                        	
                        	  <?
            echo "<select name='accounttypeid$row->balanceid'>";
            $sql = "select * from accounttype";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option";
                
				if($row->accounttypeid==$row2->accounttypeid){
					echo " selected ";
				}
				
                echo " value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
</td>
                        	
                        	<td>
                        		<input class="form-field 10px" type="text" name='amount<?= $row->balanceid ?>' value="<?=$row->amount?>">
                        		</td>
                        </tr>
                        <? 
					
                        	@$liabilitiesout+=$row->amount;

					}
                    ?>
                </tbody>
            </table>
             <input type="submit" class="button white" value="修改">
             <h2> Liabilities :<?=@$liabilitiesout?></h2>
          </form>
        </div>
    </div>

    </div>
    
    <div class="column half fr">
        <div class="box themed_box">
        <h2 class="box-header">owner's Equity </h2>
        <div class="box-content">
        	
        	 <form action="<?=$url?>account/balance_bath_update" method="post">
            <input type='hidden' name ='balanceid' value='<?=$balanceid3 ?>'>
              <input type='hidden' name ='type' value='3'>
        	
        	
            
          
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk3[]')" />全選</p> 
            <table class="display" id="tabledata4">
                <thead>
                    <tr>
                    	<th>選擇</th>
                        <th>刪除</th>
                       <th>日期</th>
                    	<th>會計科目</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
					  $in=0;
					$out=0;
					$Equityout="";
                    foreach ($query3->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        		<td><input type="checkbox" value="<?=$row->balanceid ?>" name="chk3[]"/></td>
                        	<td><a onClick="return check();"  href="<?= $adminurl . "balance_del" ?>/<?= $row->balanceid ?>">刪除</a></td>
                        	<td>
                        		
                        			<input class="form-field datepicker"  value="<?=$row->pdate;?>"  type="text" name="pdate<?= $row->balanceid ?>">
                        		</td>
                        	
                        	
                        	<td>
                        	
                        	  <?
            echo "<select name='accounttypeid$row->balanceid'>";
            $sql = "select * from accounttype";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option";
                
				if($row->accounttypeid==$row2->accounttypeid){
					echo " selected ";
				}
				
                echo " value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
</td>
                        	
                        	<td>
                        		<input class="form-field 10px" type="text" name='amount<?= $row->balanceid ?>' value="<?=$row->amount?>">
                        		</td>
                        </tr>
                        <? 

                        	@$Equityout+=$row->amount;				
					}
                    ?>
                </tbody>
            </table>
              <input type="submit" class="button white" value="修改">
            <h2>Equity: <?=@$Equityout?></h2>
           <h2>liabilities and equity: <?=@$Equityout+$liabilitiesout?></h2>
           
          </form>
        </div>
    </div>

    </div>
<div class="clear"></div>
</div>