<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">
<div class="column full">

        <div class="box themed_box">
        <h2 class="box-header"> 採購</h2>
        <div class="box-content">
           <?php echo form_open_multipart('purchase/purinvent_detail_update'); ?>
         
          <label > 採購類型 </label>     
          <?=$this->all_model -> getPurchasetype($row->purchasetype);?>
           
         
          <label > 公司名稱 </label>
            <?=$row->companyname?>
          
             <label > 產品名稱 </label>
            <?
           if($row->productid){
           	echo $this->all_model -> getProduct($row->productid);
           }
            ?>
           
            <label >  sku： </label>
			<?=$row->sku?>
			<label >  數量： </label>
			<?=$row->amount?>
			<br><br>
		   <label >  日期： </label>
			<input class="form-field datepicker"  value="<?=$row->pdate?>"   type="text" name="pdate">
			
			<label >  發票號碼： </label>
			<input class="form-field "   type="text" value='<?=$row->no?>' name="no">
			
			<label >  單價： </label>
			<input class="form-field "   type="text" value="<?=$row->price?>" name="price">

			
			<label class="form-label">已付款/未付款</label>

			<div class="radiocheck">
		<?
if($row->alpay){
	?>
	<input id="radio1" type="radio" checked value="1" name="alpay"/><label for="radio1">已付款</label>
	<input id="radio2" type="radio" value="0" name="alpay"/><label for="radio2">未付款</label>
	<?
	}else{
	?>

	<input id="radio1" type="radio" value="1" name="alpay"/><label for="radio1">已付款</label>
	<input id="radio2" type="radio" value="0" checked name="alpay"/><label for="radio2">未付款</label>
	<?

	}
	?>
		</div>

              <label class="form-label required"> 交易條件 </label>
           <?
            echo "<select id=\"select\"  name='paytype'>";
if($row->paytype){
		echo "<option value='0'>現金</option> ";
		echo "<option selected value='1'>支票 </option>";
	}else{
		echo "<option  selected value='0'>現金</option> ";
		echo "<option  value='1'>支票 </option>";
	}
	
			
            echo "</select>";
            ?>
            
          <br />   <br />
           <input type="hidden" name='id' value="<?=$id?>">
            <input type="hidden" name='amount' value="<?=$row->amount?>">
             <input type="hidden" name='productid' value="<?=$row->productid?>">
               <input type="hidden" name='sku' value="<?=$row->sku?>">
            <input type="submit" class="button themed" value="入庫">
            </form>
        </div>
        </div>
        </div>
 
</div>
