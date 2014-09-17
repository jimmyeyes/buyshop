<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">
<script>
<?for($i=1;$i<2;$i++){?>
function SelZero<?=$i?>(vall){
	var arr=new Array();
	<?php 
			$string="";
			$val="";
	        $sql = "select m.* from category m order by categoryid asc";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            	  $sql = "select m.* from product m where categoryid=".$row->categoryid." order by categoryid asc";
             	 $query2 = $this->db->query($sql);
			
			$string.="var p".$row->categoryid."={";
			$val="";
			$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            		if($val==""){
            			$val.="'".$row2->brand.$row->categoryid."' : '".$row2->brand."'";
            		}else{
            			$val.=",'".$row2->brand.$row->categoryid."' : '".$row2->brand."'";
            		}
				}
				$string.=$val." };     ";
			}
		 echo $string;
		  $sql = "select m.* from category m order by categoryid asc";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr[".$row->categoryid."] = p".$row->categoryid.";";
			}
	?>
$("#brandid<?=$i?>").removeOption(/./);         //先移除原有的選項
 //alert( arr[0]);
$("#brandid<?=$i?>").addOption(arr[vall], false); //帶入新的選項
}

function SelZero2<?=$i?>(vall){
	
	//alert(vall);
	var arr=new Array();

	<?php 
			$string="";
			$val="";
			$sql = "SELECT distinct(model) as model,r1.categoryid  FROM `product` m  left join category r1 on m.categoryid=r1.categoryid ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
                $sql = "select m.*  from product m where model='".$row->model."' and categoryid='$row->categoryid' order by prodname asc";
             	$query2 = $this->db->query($sql);
				$model=$row->model;
				$model =str_replace(' ', '', $model);
				$model =str_replace('-', '', $model);
				$model =str_replace('/', '', $model);

				$string.="var a".$model.$row->categoryid."={";
				$val="";
				$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            	 	$name=$row2->prodname;
						//$name=str_replace($name, " ", "_");
            		if($val==""){
            			
            			$val.="'".$row2->productid."' : '".$row2->prodname."'";
            		}else{
            			$val.=",'".$row2->productid."' : '".$row2->prodname."'";
            		}
				}
				
				$string.=$val." };     ";
	
			}
		 echo $string;

			$sql = "SELECT distinct(model) as model ,r1.categoryid FROM `product` m  left join category r1 on m.categoryid=r1.categoryid ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		$model=$row->model;
					$model =str_replace(' ', '', $model);
					$model =str_replace('-', '', $model);
				$model =str_replace('/', '', $model);

            		echo "arr['a".$model.$row->categoryid."'] = a".$model.$row->categoryid.";";
			}

	?>

	
$("#productid<?=$i?>").removeOption(/./);         //先移除原有的選項
 //alert( arr[1]);
$("#productid<?=$i?>").addOption(arr[vall], false); //帶入新的選項
	

}


function SelZero3<?=$i?>(vall){
	var arr=new Array();
	<?php 
	
			$string="";
			$val="";
			$sql = "SELECT distinct(brand),categoryid FROM `product` ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            	  $sql = "select distinct(model) as model  from product m where brand='".$row->brand."' and categoryid='".$row->categoryid."' order by model asc";
             	 $query2 = $this->db->query($sql);
			
				$string.="var p".$row->brand.$row->categoryid."={";
				$val="";
				$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            	 	$model=$row2->model;
				$model =str_replace(' ', '', $model);
				$model =str_replace('-', '', $model);
				$model =str_replace('/', '', $model);
            		if($val==""){
            			
            			$val.="'a".$model.$row->categoryid."' : '".$row2->model."'";
            		}else{
            			$val.=",'a".$model.$row->categoryid."' : '".$row2->model."'";
            		}
				}
				
				$string.=$val." };     ";
	
			}
		 echo $string;

		$sql = "SELECT distinct(brand),categoryid FROM `product` ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr['".$row->brand.$row->categoryid."'] = p".$row->brand.$row->categoryid.";";
			}

	?>

	
$("#model<?=$i?>").removeOption(/./);         //先移除原有的選項
 //alert( arr[1]);
$("#model<?=$i?>").addOption(arr[vall], false); //帶入新的選項

}



function SelZero4<?=$i?>(vall){
	
		var arr=new Array();
	var arr2=new Array();
	
	<?php 
	
			$string="";
			$val="";
		    $sql = "select m.* from product m order by categoryid asc";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr[".$row->productid."] = \"".$row->sku."\";";
			}

			  $sql = "select m.* from product m order by categoryid asc";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
            		echo "arr2[".$row->productid."] = \"".$row->prodname."\";";
			}

	?>



$("#sku<?=$i?>").val(arr[vall]);

}


<?
}
?>

</script>
<div class="column full">

        <div class="box themed_box">
        <h2 class="box-header"> 採購</h2>
        <div class="box-content">
          
           <form action="<?=$url?>purchase/purchase_adds" name="FormCode">
         
         	<?for($i=1;$i<2;$i++){?>
         
          <label > 採購類型 </label>
          <select id="select"  name='purchasetype<?=$i?>'>
          	<option value='999'>暫存</option> 
		
           </select>
           
            
            <label > 類別名稱 </label>
            <select id='categoryid<?=$i?>' name='categoryid<?=$i?>' onchange="SelZero<?=$i?>(this.options[this.options.selectedIndex].value);">
           <option value=''></option>
            	 <?
            $sql = "select m.* from category m order by categoryid asc";
	//echo $sql;
            $query = $this->db->query($sql);
			 echo " ";
            foreach ($query->result() as $row2) {
                echo "<option value='{$row2->categoryid}' ";
                echo ">{$row2->category}</option>";
            }
            echo "</select>";
            ?>

               <label > 品牌 </label>
            <select id='brandid<?=$i?>' name='brandid<?=$i?>' onchange="SelZero3<?=$i?>(this.options[this.options.selectedIndex].value);">
			
             </select>
             
               <label>  型號： </label>
		<!--	<input class="form-field 10px" type="text" name="model<?=$i?>" id="model<?=$i?>"  >-->
            
              <select id='model<?=$i?>' name="model<?=$i?>"   onchange="SelZero2<?=$i?>(this.options[this.options.selectedIndex].value);">
			
			 </select>
             

              <label > 品名 </label>
            <select id='productid<?=$i?>' name='productid<?=$i?>'  onchange="SelZero4<?=$i?>(this.options[this.options.selectedIndex].value);" >
		<!--	<input class="form-field small" type="text"  name="productname<?=$i?>" id="productname<?=$i?>"  >-->
			 </select>
			
			  <label>  SKU： </label>
			<input class="form-field 10px" type="text" name="sku<?=$i?>" id="sku<?=$i?>">
			
			<br>
			<label >  數量： </label>
			<input class="form-field 10px" type="text"  name="amount<?=$i?>">
			<labe>  日期： </label>
			<input class="form-field datepicker"  value='<?=$pdate?>'   type="text" name="pdate<?=$i?>">
			
          <br />
            
            
             <input type="submit" class="button themed" value="ADD">
              </form>
             
            <?
            
            }
  if( $has !=""){
			   	
				?>
				
				  <form action="<?=$url?>purchase/purchaseaddbath" method="post">
            <input type='hidden' name ='purchaseid' value='<?=$purchaseid ?>'>
            <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選/全不選
         <select name="modtype">
         
          <option value="1">待訂</option>
             <option value="2">刪除</option>
          </select>
          </p>
			<table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th></th>
                    	<th>日期</th>
                    	<th>類別名稱</th>
                    	<th>品牌</th>
     					<th>型號</th>
                        <th>品名</th>  
                        <th>SKU</th>
                        <th>數量</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($querylist->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                         <td><input type="checkbox" value="<?=$row->purchaseid ?>" name="chk[]"/></td>
                      	  	 <td class="nCategory"><?=$row->pdate?>  </td>
                        	 <td class="nCategory"><?=$row->category?>  </td>
                        	 <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nTitle"><?=$row->model?></td>
                            <td class="nCategory"><?=$row->prodname?> </td>
                         <td class="nCategory"><?=$row->sku?> </td>
                          <td class="nCategory"><?=$row->amount?> </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
				   
				   
				  <input type="submit" class="button themed" value="submit">
				   
				<?
			   }?>
			   
			   
            
          
        </div>
        </div>
        </div>
 
</div>
