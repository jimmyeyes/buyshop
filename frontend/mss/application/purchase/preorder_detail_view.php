<?= $menu ?>
<div id="subnavbar">
</div>
<script>
function SelZero2(vall){
	var arr=new Array();
	<?php 
	
			$string="";
			$val="";
	       

		  $sql = "select m.* from product m order by categoryid asc";
            $query3 = $this->db->query($sql);
            foreach ($query3->result() as $row3) {
            		echo "arr[".$row3->productid."] = ".$row3->sku.";";
			}

	?>
$("#sku").val(arr[vall]);
	
}

</script>
<div id="content">
<div class="column full">

        <div class="box themed_box">
        <h2 class="box-header"> 採購</h2>
        <div class="box-content">
           <?php echo form_open_multipart('purchase/preorder_detail_mod'); ?>
         
          <label > 採購類型 </label>     
          <?=$this->all_model -> getPurchasetype($row->purchasetype);?>
           
         
          <label > 商品名稱 </label>
          <select id='select'  name='productid' onchange="SelZero2(this.options[this.options.selectedIndex].value);">
            <?
           if($row->productid){
        	 $sql = "select * from product";

            $query1 = $this->db->query($sql);
			
            foreach ($query1->result() as $row2) {
                echo "<option value='{$row2->productid}' ";
                if ($row2->productid == $row->productid) {
                    echo "selected='selected'";
                }
                echo ">{$row2->prodname}</option>";
            }
            
			// echo "<option value='0'>現金</option> ";
            
           }
            ?>
            </select>
            <label >  SKU： </label>
			<input class="form-field " id='sku'   type="text" value="<?=$row->sku?>" name="sku">
			<label >  數量： </label>
			<input class="form-field "    type="text" value="<?=$row->amount?>" name="amount">
			
			<br>
			 <input type="hidden" name='id' value="<?=$id?>">
            <input type="submit" class="button themed" value="修改">
			</form>
			 <?php echo form_open_multipart('purchase/preorder_detail_update'); ?>
			
			  <label > 廠商名稱 </label>
            <?
            echo "<select id=\"select\" name='companyid'>";
            $sql = "select * from company";

            $query = $this->db->query($sql);
			 echo "<option value=''></option> ";
            foreach ($query->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
               
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
			
			<label >  日期： </label>
			
			<input class="form-field datepicker"    type="text" value="<?=$row->pdate?>" name="pdate">

		
          <br />   <br />
           <input type="hidden" name='id' value="<?=$id?>">
            <input type="submit" class="button themed" value="已訂">
            </form>
        </div>
        </div>
        </div>
 
</div>
