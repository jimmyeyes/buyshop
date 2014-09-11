<?= $menu ?>
<div id="subnavbar">
</div>
<script>

<?
$i="";
?>

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
        <h2 class="box-header"> 採購</h2>
        <div class="box-content">
          
           <form action="<?=$url?>inventory/inventory_adds" name="FormCode">
        
            <label > 類別名稱 </label>
           
            <select id='categoryid' name='categoryid' onchange="SelZero(this.options[this.options.selectedIndex].value);">
           
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
            <select id='brandid' name='brandid' onchange="SelZero3(this.options[this.options.selectedIndex].value);">
            
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
			<input class="form-field 10px" type="text" name="sku" id="sku">
			
			<br />
			<label > 數量： </label>
			<input class="form-field px20" type="text" name="amount">
			<label > 金額： </label>
			<input class="form-field 10px" type="text" name="price">
			<labe>  日期： </label>
			<input class="form-field datepicker"    type="text" name="pdate">
			
          <br />   <br />
            <input type="submit" class="button themed" value="ADD">
            </form>
        </div>
        </div>
        </div>
        
        <div class="box themed_box">
            <h2 class="box-header">類別名稱</h2>
            <div class="box-content">
                <table class="display" id="tabledata1">
                <thead>
                    <tr>
                    	<th>操作</th>
                    	<th>類別名稱</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($querycate->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "category_del" ?>/<?= $row->category ?>">刪除</a></td>
                        	 <td class="nCategory"><a  href="<?= $adminurl . "productcate" ?>/<?= $row->categoryid ?>"><?=$row->category?></a>  </td>
                           
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
        
        
	
	 <div class="column full">
    <div class="box themed_box">
        <h2 class="box-header">庫存總覽 </h2>
        <div class="box-content">
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                         <th>類別名稱</th>
                         <th>品牌</th>
                        <th>品名</th>
     					<th>型號</th>
                        <th>SKU</th>
                        <th>EAN</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>數量</th>
                        <th>單價</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($queryinvent->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">

                           <td class="nCategory"><?=$row->category?>  </td>
                           <td class="nCategory"><?=$row->brand?>  </td>
                           <td class="nTitle"><a  href="<?= base_url()."index.php/product/" . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>
                           <td class="nCategory"><?=$row->model?>  </td>
                           <td class="nCategory"><a href="<?= $adminurl . "inventory_detail" ?>/<?= $row->productid ?>"><?= $row->sku ?></a>  </td>
                           <td class="nCategory"><?=$row->ean?>  </td>
                           <td class="nCategory"><?=$row->upc?>  </td>
                           <td class="nCategory"><?=$row->mpn?>  </td>
                           <td class="nCategory">
                           	
                           	<?php
                           	$sql="SELECT sum(r1.amount) as amount  FROM `inventorylist` r1 where  r1.productid='".$row->productid."' ";
                           	$query=$this->db->query($sql);
							//echo $sql;
							foreach($query->result() as $row2){
								echo $row2->amount;
								
							}
                           	?>
                           	 </td>
                           	 <td class="nCategory">
                           	
                           	<?php
                           	$sql="SELECT max(r1.price)  as amount  FROM `inventorylist` r1  where r1.productid='".$row->productid."'";
                          // echo $sql;
						   	$query=$this->db->query($sql);

							foreach($query->result() as $row2){
								echo $row2->amount;
								
							}
                           	?>
                           	 </td>
							<? //$row2->amount?> <?//$row2->price?>
             
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
     </div>
    
     <div class="column full">
    <div class="box themed_box">
        <h2 class="box-header">庫存列表 </h2>
        <div class="box-content">
        	  <form action="<?=$url?>inventory/inventory" method='post' >
            <select  name='typeid' >
        		 <?
            $sql = "select m.* from searchtype m ";
	//echo $sql;
            $query2 = $this->db->query($sql);
			 echo " ";
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->column}' ";
                echo ">{$row2->name}</option>";
            }
            echo "</select>";
            ?>
            <input class="form-field "  type="text"  value="<?=$keyword?>" name="keyword">
            
            <input type="submit" value="查詢" >
        	</form>
        	 
        	   <form action="<?=$url?>inventory/inventory_update" method="post">
       	   <input type='hidden' name ='inventorylistid' value='<?=$inventorylistid ?>'>
  			<input type='hidden' name ='productid' value='<?=$productid ?>'>
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
            <table class="display" id="tabledata3">
                <thead>
                    <tr>
                    	<th>選擇</th>
                    	<th>刪除</th>
                    	 <th>數量</th>
                        <th>單價</th>
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
                    
                    if($isvisable!=0){
                    $i = 0;
                    foreach ($queryselect->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
							<td><input type="checkbox" value="<?= $row->inventorylistid ?>" name="chk[]"/></td>
							  <td class="nCategory"><a onClick="return check();" href="<?= $adminurl . "inventory_brifdel" ?>/<?= $row->inventorylistid ?>">刪除</a> </td>
                        	<td class="nCategory"><input class="form-field px30"   type="text" value="<?=$row->amount?>" name="amount<?=$row->inventorylistid ?>">   </td>		
              				<td class="nCategory"> <input class="form-field px50"    type="text" value="<?=$row->price?>"  name="price<?=$row->inventorylistid ?>">  </td>	
                           <td class="nCategory"><?=$row->category?>  </td>
                           <td class="nCategory"><?=$row->brand?>  </td>
                           <td class="nTitle"><?= $row->prodname ?></td>
                           <td class="nCategory"><?=$row->model?>  </td>
                           <td class="nCategory"><?= $row->sku ?> </td>
                             <td class="nCategory"><?=$row->ean?>  </td>
                           <td class="nCategory"><?=$row->upc?>  </td>
                           <td class="nCategory"><?=$row->mpn?>  </td>
                        
                        </tr>
                        <? }
                        }
                    ?>
                </tbody>
            </table>
              <input type="submit" value="更新" >
            </form>
            <div class="clear"></div>
        </div>
    </div>
     </div>
</div>
