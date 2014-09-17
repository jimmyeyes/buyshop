
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
	
	//alert(vall);
	var arr=new Array();

	<?php
			$string="";

			     $string .= "var aI930022={'' : '','510' : 'Samsung N9000 case' }; ";
			$val="";
			$sql = "SELECT distinct(model) as model,r1.categoryid  FROM `product` m  left join category r1 on m.categoryid=r1.categoryid ";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
                $sql = "select m.*  from product m where model='".$row->model."' and categoryid='$row->categoryid' order by prodname asc";
             	$query2 = $this->db->query($sql);
				$model=$row->model;
				$model =str_replace(' ', '', $model);
				$model =str_replace('-', '', $model);
				$model =str_replace('.', '', $model);
				$model =str_replace('/', '', $model);

				$string.="var a".$model.$row->categoryid."={";
				$val="";
			//	$val.="'1' : 'test'";
            	 foreach ($query2->result() as $row2) {
            	 	$name=$row2->prodname;
						//$name=str_replace($name, " ", "_");
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
                     $brand =str_replace(':', '', $brand);

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

<?
}
?>

</script>


<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Inventory Process
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Inventory Process</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>Inventory Process
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">


           <form action="<?=$url?>purchase/purchase_adds" name="FormCode">
         
         	<?for($i=1;$i<2;$i++){?>
         
          <label > 採購類型 </label>
          <select class="form-control input-medium select2me" id="select"  name='purchasetype<?=$i?>'>
          	<option value='1'>待訂</option>
              <option value='2'>已訂</option>


          </select>
           
            
            <label > 類別名稱 </label>
            <select class="form-control input-medium select2me" id='categoryid<?=$i?>' name='categoryid<?=$i?>' onchange="SelZero<?=$i?>(this.options[this.options.selectedIndex].value);">
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
            <select class="form-control input-medium select2me" id='brandid<?=$i?>' name='brandid<?=$i?>' onchange="SelZero3<?=$i?>(this.options[this.options.selectedIndex].value);">
			
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
			<input  type="text" class="form-control" name="sku<?=$i?>" id="sku<?=$i?>">
			
			<br>
			<label >  數量 </label>
			<input  type="text" class="form-control"  name="amount<?=$i?>">
			<label>  日期 </label>

                <div class="input-group input-medium date date-picker " data-date="<?=$pdate?>"  data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                    <input type="text" name="pdate<?=$i?>" class="form-control" value="<?=$pdate?>" readonly>
                        <span class="input-group-btn">

                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>


                        </span>
                </div>


             <input type="submit" class="btn blue" value="Add">
              </form>



        <div class="clearfix">
        </div>


           <?}?>



           <!-- BEGIN EXAMPLE TABLE PORTLET-->
           <div class="portlet box grey">
               <div class="portlet-title">
                   <div class="caption">
                       <i class="fa fa-user"></i>待訂
                   </div>
                   <div class="actions">
                       <div class="btn-group">

                       </div>
                   </div>
               </div>
               <div class="portlet-body">


                   <form id="form" action="<?=$url?>purchase/orderbathupdate" method="post">
                       <input type='hidden' name ='purchaseid' value='<?=$purchaseid1 ?>'>
                       <input type='hidden' name ='type' value='1'>
                       <label > 公司名稱 </label>
                       <?
                       $type=1;

                       echo "<select class=\"form-control input-medium select2me\" id=\"select\" name='companyid'>";
                       $sql = "select * from company";

                       $queryco = $this->db->query($sql);
                       echo "<option value=''></option> ";
                       foreach ($queryco->result() as $row2) {
                           echo "<option value='{$row2->companyid}' ";

                           echo ">{$row2->companyname}</option>";
                       }
                       echo "</select>";
                       ?>

                       <table class="table table-striped table-bordered table-hover" id="sample_2">
                           <thead>
                           <tr>
                               <th> <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/></th>
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
                                   <td><input class="checkboxes" type="checkbox" value="<?= $row->purchaseid ?>" id="chk" name="chk1[]"/></td>
                                   <td ><a class="btn red" onClick="return check();"  href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                                   <td ><input class="form-field datepicker"   type="text" value="<?= $row->pdate ?>"  name="pdate"></td>
                                   <td ><?=$row->category?>  </td>
                                   <td ><?=$row->brand?>  </td>
                                   <td ><?=$row->prodname?>  </td>
                                   <td ><?=$row->model?>  </td>
                                   <td ><?=$row->sku?>  </td>
                                   <td ><input class="form-control"    type="text" value="<?=$row->amount?>" name="amount<?=$row->purchaseid ?>">  </td>

                               </tr>
                           <? }
                           ?>
                           </tbody>
                       </table>
                       <input type="submit" class="btn blue" value="已訂" >
                   </form>
               </div>
           </div>


           <!-- BEGIN EXAMPLE TABLE PORTLET-->
           <div class="portlet box grey">
               <div class="portlet-title">
                   <div class="caption">
                       <i class="fa fa-user"></i>已訂
                   </div>
                   <div class="actions">
                       <div class="btn-group">

                       </div>
                   </div>
               </div>
               <div class="portlet-body">



                   <form action="<?=$url?>purchase/orderbathupdate" method="post">
                       <input type='hidden' name ='purchaseid' value='<?=$purchaseid2 ?>'>
                       <input type='hidden' name ='type' value='2'>

                       <table class="table table-striped table-bordered table-hover" id="sample_4">
                           <thead>
                           <tr>
                               <th> <input type="checkbox" class="group-checkable" data-set="#sample_4 .checkboxes"/></th>
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
                           foreach ($query22->result() as $row) {


                               ?>
                               <tr >
                                   <td><input  class="checkboxes" type="checkbox" value="<?= $row->purchaseid ?>" name="chk2[]"/></td>
                                   <td ><a class="btn red" onClick="return check();" href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                                   <td >

                                       <div class="input-group input-medium date date-picker " data-date="<?=$row->pdate?>"  data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                           <input type="text" name="pdate<?=$row->purchaseid ?>" class="form-control" value="<?=$row->pdate?>" readonly>
                                 <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                                       </div>



                                   </td>

                                   <td >  <input class="form-control"    type="text"  name="no<?=$row->purchaseid ?>"></td>
                                   <td ><input class="form-control"    type="text"  name="price<?=$row->purchaseid ?>">  </td>
                                   <td >
                                       <select class="form-control input-medium select2me"  name='paytype<?=$row->purchaseid ?>'>
                                           <option value='0'>待付</option>
                                           <option value='1'>結清 </option>
                                       </select>
                                   </td>
                                   <td >

                                       <select class="form-control input-medium select2me"  name='alpay<?=$row->purchaseid ?>'>
                                           <option value='0'>現金</option>
                                           <option value='1'>支票 </option>
                                       </select>
                                   </td>


                                   <td ><?=$row->companyname?>  </td>
                                   <td ><?=$row->category?>  </td>
                                   <td ><?=$row->brand?>  </td>
                                   <td ><?=$row->prodname?>  </td>
                                   <td ><?=$row->model?>  </td>
                                   <td ><?=$row->sku?>  </td>
                                   <td ><input class="form-control"   type="text" value="<?=$row->amount?>" name="amount<?=$row->purchaseid ?>">  </td>
                               </tr>
                           <? }
                           ?>
                           </tbody>
                       </table>
                       <input type="submit" class="btn blue" value="入庫" >

                   </form>
               </div>
           </div>

         
