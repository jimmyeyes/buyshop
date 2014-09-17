<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>輸入運送碼
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

				 <form action="<?=$url?>order/tracknumber_bathadds" method="post">
				<?
				foreach($query->result() as $row){
				?>
					<input type='hidden' name ='orderlistid' value='<?=$orderlistid ?>'>

			        <label > SN </label>
				 	<label > <?=$row->orderlistid?> </label>
           
             	 	<label > Tracking Number </label>
            		<input class="form-control " type="text" name="number<?=$row->orderlistid?>" >
             
		  	 		<label>  Weight(g)： </label>
          	 		<input class="form-control " type="text" name="weight<?=$row->orderlistid?>" >
            	
            	
          	 		<label > Shipping Courier </label>	
             <select class="form-control input-medium select2me" name='courierid<?=$row->orderlistid?>' >
          	 <option value=''></option>
                 <?
            foreach ($courier->result() as $row2) {
                echo "<option value='{$row2->courierid}'>{$row2->name}</option>";
            }?>
            </select>
            
             <label > Package Type </label>
            <select class="form-control input-medium select2me" name='package<?=$row->orderlistid?>' >
          	 <option value=''></option>
             <?
            foreach ($package->result() as $row2) {
                echo "<option value='{$row2->packageid}'>{$row2->name}</option>";
            }?>

   
              <label > Shipping Date </label>
           	<input class="form-control " type="text" name="date<?=$row->orderlistid?>" value="<?=$date?>">

			
			<label>  Shipped Item Info： </label>
			<label>  <?=$row->Title?> </label>
			
			<br />
				
		<?
		}
		?>
	        <input type="submit" class="btn blue" value="OK" >

			</form>
		

	</div>
</div>
