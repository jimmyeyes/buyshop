<?= $menu ?>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div class="box themed_box">
			<h2 class="box-header">輸入運送碼 </h2>
			<div class="box-content">
				 <form action="<?=$url?>order/tracknumber_bathadds" method="post">
				<?
				foreach($query->result() as $row){
					

				?>
				
					<input type='hidden' name ='orderlistid' value='<?=$orderlistid ?>'>

			        <label > SN </label>
				 	<label > <?=$row->orderlistid?> </label>
           
             	 	<label > Tracking Number </label>
            		<input class="form-field 10px" type="text" name="number<?=$row->orderlistid?>" >
             
		  	 		<label>  Weight(g)： </label>
          	 		<input class="form-field 10px" type="text" name="weight<?=$row->orderlistid?>" >
            	
            	
          	 		<label > Shipping Courier </label>	
             <select  name='courierid<?=$row->orderlistid?>' > 
          	 <option value=''></option>
                 <?
            foreach ($courier->result() as $row2) {
                echo "<option value='{$row2->courierid}'>{$row2->name}</option>";
            }?>
            </select>
            
             <label > Package Type </label>
            <select  name='package<?=$row->orderlistid?>' >
          	 <option value=''></option>
             <?
            foreach ($package->result() as $row2) {
                echo "<option value='{$row2->packageid}'>{$row2->name}</option>";
            }?>

   
              <label > Shipping Date </label>
           	<input class="form-field 10px" type="text" name="date<?=$row->orderlistid?>" value="<?=$date?>">

			
			<label>  Shipped Item Info： </label>
			<label>  <?=$row->Title?> </label>
			
			<br />
				
		<?
		}
		?>
	 <input type="submit" class="button white" value="OK" >

			</form>
		
				<div class="clear"></div>
			</div>
		</div>
		
		
		
		
		<div class="clear"></div>
	</div>
</div>
