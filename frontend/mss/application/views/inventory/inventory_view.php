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
            	 	$brand=$row2->brand;

            	 	$brand =str_replace(' ', '', $brand);
                    $brand =str_replace('-', '', $brand);
                    $brand =str_replace('/', '', $brand);
                    $brand =str_replace('.', '', $brand);
                    $brand =str_replace('"', '', $brand);
                    $brand =str_replace(':', '', $brand);
                    $brand =str_replace("'", '', $brand);


            		if($val==""){
            			$val.="'".$brand.$row->categoryid."' : '".$brand."'";
            		}else{
            			$val.=",'".$brand.$row->categoryid."' : '".$brand."'";
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
				$model =str_replace('.', '', $model);

				$string.="var a".$model.$row->categoryid."={";
				$val="";
				$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            	 	$name=$row2->prodname;
                    $name=str_replace("'",'"',$name);

            		if($val==""){
            			
            			$val.="'".$row2->productid."' : '".$name."'";
            		}else{
            			$val.=",'".$row2->productid."' : '".$name."'";
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
					$model =str_replace('.', '', $model);


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

			         $brand=$row->brand;
			        $brand =str_replace(' ', '', $brand);
                    $brand =str_replace('-', '', $brand);
                    $brand =str_replace('/', '', $brand);
                    $brand =str_replace('.', '', $brand);
                    $brand =str_replace('"', '', $brand);
                    $brand =str_replace(':', '', $brand);
                    $brand =str_replace("'", '', $brand);


				$string.="var p".$brand.$row->categoryid."={";
				$val="";
				$val.="'' : ''";
            	 foreach ($query2->result() as $row2) {
            	 	$model=$row2->model;
			        $model =str_replace(' ', '', $model);
                    $model =str_replace('-', '', $model);
                    $model =str_replace('/', '', $model);
                    $model =str_replace('.', '', $model);
                    $model =str_replace('"', '', $model);
                    $model =str_replace("'", '', $model);


            		if($val==""){
            			
            			$val.="'a".$model.$row->categoryid."' : '".$model."'";
            		}else{
            			$val.=",'a".$model.$row->categoryid."' : '".$model."'";
            		}
				}
				
				$string.=$val." };     ";
	
			}
		 echo $string;

		$sql = "SELECT distinct(brand),categoryid FROM `product` ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {


                     $brand=$row->brand;
			        $brand =str_replace(' ', '', $brand);
                    $brand =str_replace('-', '', $brand);
                    $brand =str_replace('/', '', $brand);
                    $brand =str_replace('.', '', $brand);
                    $brand =str_replace('"', '', $brand);
                    $brand =str_replace(':', '', $brand);
                    $brand =str_replace("'", '', $brand);

            		echo "arr['".$brand.$row->categoryid."'] = p".$brand.$row->categoryid.";";
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

                     $prodname=$row->prodname;
                    $prodname=str_replace("'",'"',$row->prodname);
            		echo "arr2[".$row->productid."] = '".$prodname."';";
			}

	?>



$("#sku<?=$i?>").val(arr[vall]);

}
</script>



<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            採購
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">庫存管理</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
    <div class="caption">
    <i class="fa fa-user"></i>採購
</div>
<div class="actions">
    <div class="btn-group">

    </div>
</div>
</div>
<div class="portlet-body">

           <form action="<?=$url?>inventory/inventory_adds" name="FormCode">
        
            <label > 類別名稱 </label>
           
            <select class="form-control input-medium select2me" id='categoryid' name='categoryid' onchange="SelZero(this.options[this.options.selectedIndex].value);">
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
            <select class="form-control input-medium select2me" id='brandid' name='brandid' onchange="SelZero3(this.options[this.options.selectedIndex].value);">
            
             </select>
          
		   <label>  型號</label>
		<!--	<input  type="text" name="model<?=$i?>" id="model<?=$i?>"  >-->
            
              <select class="form-control input-medium select2me" id='model<?=$i?>' name="model<?=$i?>"   onchange="SelZero2<?=$i?>(this.options[this.options.selectedIndex].value);">
			
			 </select>
             

              <label > 品名 </label>
            <select class="form-control input-medium select2me" id='productid<?=$i?>' name='productid<?=$i?>'  onchange="SelZero4<?=$i?>(this.options[this.options.selectedIndex].value);" >
		<!--	<input class="form-field small" type="text"  name="productname<?=$i?>" id="productname<?=$i?>"  >-->
			 </select>
			
			<label>  SKU </label>
			<input class="form-control"  type="text" name="sku" id="sku">
			
			<br />
			<label > 數量 </label>
			<input  class="form-control" type="text" name="amount">
			<label > 金額 </label>
			<input  class="form-control"  type="text" name="price">
			<label>  日期 </label>
                <div class="input-group input-medium date date-picker " data-date="<?=$pdate?>"  data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                    <input type="text" name="pdate" class="form-control" value="<?=$pdate?>" readonly>
                        <span class="input-group-btn">
                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                </div>
			

            <input type="submit" class="btn blue" value="ADD">
            </form>

        </div>
        </div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>類別名稱
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">


                 <table class="table table-striped table-bordered table-hover" id="sample_2">
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
                        	 <td ><a  class="btn red" onClick="return check();" href="<?=  base_url() . "index.php/product/category_del" ?>/<?= $row->category ?>">刪除</a></td>
                        	 <td><a  href="<?= base_url() . "index.php/product/productcate" ?>/<?= $row->categoryid ?>"><?=$row->category?></a>  </td>
                           
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
        </div>
    </div>





    <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
    <div class="caption">
    <i class="fa fa-user"></i>庫存總覽
</div>
<div class="actions">
    <div class="btn-group">

    </div>
</div>
</div>
<div class="portlet-body">


            <table class="table table-striped table-bordered table-hover" id="sample_3"/>
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

                           <td><?=$row->category?>  </td>
                           <td><?=$row->brand?>  </td>
                           <td ><a  href="<?= base_url()."index.php/product/" . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>
                           <td><?=$row->model?>  </td>
                           <td><a href="<?= $adminurl . "inventory_detail" ?>/<?= $row->productid ?>"><?= $row->sku ?></a>  </td>
                           <td><?=$row->ean?>  </td>
                           <td><?=$row->upc?>  </td>
                           <td><?=$row->mpn?>  </td>
                           <td>
                           	
                           	<?php
                           	$sql="SELECT sum(r1.amount) as amount  FROM `inventorylist` r1 where  r1.productid='".$row->productid."' ";
                           	$query=$this->db->query($sql);
							//echo $sql;
							foreach($query->result() as $row2){
								echo $row2->amount;
								
							}
                           	?>
                           	 </td>
                           	 <td>
                           	
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

    </div>
     </div>



    <!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
    <div class="caption">
    <i class="fa fa-user"></i>庫存列表
</div>
<div class="actions">
    <div class="btn-group">

    </div>
</div>
</div>
<div class="portlet-body">

        	  <form action="<?=$url?>inventory/inventory" method='post' >
            <select class="form-control input-medium select2me"  name='typeid' >
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
            <input class="form-control"   type="text"  value="<?=$keyword?>" name="keyword">
            
            <input type="submit" class="btn blue" value="查詢" >
        	</form>
        	 
        	   <form action="<?=$url?>inventory/inventory_update" method="post">
       	   <input type='hidden' name ='inventorylistid' value='<?=$inventorylistid ?>'>
  			<input type='hidden' name ='productid' value='<?=$productid ?>'>
         <table class="table table-striped table-bordered table-hover" id="sample_4">
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
							  <td><a onClick="return check();" href="<?= $adminurl . "inventory_brifdel" ?>/<?= $row->inventorylistid ?>">刪除</a> </td>
                        	<td><input class="form-field px30"   type="text" value="<?=$row->amount?>" name="amount<?=$row->inventorylistid ?>">   </td>		
              				<td> <input class="form-field px50"    type="text" value="<?=$row->price?>"  name="price<?=$row->inventorylistid ?>">  </td>	
                           <td><?=$row->category?>  </td>
                           <td><?=$row->brand?>  </td>
                           <td ><?= $row->prodname ?></td>
                           <td><?=$row->model?>  </td>
                           <td><?= $row->sku ?> </td>
                             <td><?=$row->ean?>  </td>
                           <td><?=$row->upc?>  </td>
                           <td><?=$row->mpn?>  </td>
                        
                        </tr>
                        <? }
                        }
                    ?>
                </tbody>
            </table>
              <input type="submit" class="btn blue" value="更新" >
            </form>
        </div>

</div>
