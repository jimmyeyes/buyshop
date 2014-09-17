<?= $menu ?>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div class="box themed_box">
			<h2 class="box-header">Enter Shipping Information</h2>
			<div class="box-content">
				 <form action="<?=$url?>order/tracknumber_adds" method="post">
				<table class="display" id="">
                <thead>
                    <tr>
                     <th>Order ID</th>
                     <th> Tracking Number</th>
                     <th>Weight(g)</th>
                     <th>SN</th>
                     <th>Shipping Courier</th>
                     <th> Package Type</th>
                       <th>Status</th>
                     <th> Shipping Date</th>
                     <th> Shipped Item Info：</th>
                     <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <tr >
                       	 	<td class="nCategory"> <?=$orderlist->orderlistid?> </td>
                        	<td class="nCategory"><input class="form-field 10px" type="text" name="number" > </td>
                        	<td class="nCategory"> <input class="form-field 10px" type="text" name="weight" ></td>
                          	<td class="nCategory"> <input class="form-field 10px" type="text" name="sn" ></td>
                        	<td class="nCategory">  <select  name='courierid' > 
          					 <option value=''></option>
             				    <?
            				foreach ($courier->result() as $row2) {
                			echo "<option value='{$row2->courierid}'>{$row2->name}</option>";
            				}?>
            				</select>
                        	</td>
                       		 <td class="nCategory">
                        	 <select  name='package' >
          	 				<option value=''></option>
             				<?
            				foreach ($package->result() as $row2) {
                				echo "<option value='{$row2->packageid}'>{$row2->name}</option>";
            				}?>

                        	 </td>
                        	 <td class="nCategory"> 
								<div class="radiocheck">
									<input id="radio1" type="radio" value="0" name="shippreturn" checked /><label for="radio1">shippied</label>
									<input id="radio2" type="radio" value="1" name="shippreturn"/><label for="radio2">return</label>
								
								</div>
						  	</td>

                        	<td class="nCategory">   	<input class="form-field 10px" type="text" name="date" value="<?=$date?>"> </td>
							<td class="nCategory">  <?
						
							$sql="select * from orderlistprod where orderlistid='$orderlist->orderlistid'";
							$query=$this->db->query($sql);
							foreach ($query->result() as $row2) {
								echo $row2->Title."<br >";
							}
							

						?> </td>	
						<td>  <input type="submit" class="button white" value="ADD" ></td>
                        </tr>
                </tbody>
            </table>
		     <input type="hidden" value="<?php echo $orderlist->orderlistid; ?>" name='orderlistid'>
			
			</form>
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="box themed_box">
			<h2 class="box-header">Existing Shipping Information </h2>
			<div class="box-content">
		<table class="display" id="">
                <thead>
                    <tr>
                     <th>OrderID</th>
                     <th>Courier</th>
                     <th>Tracking Number</th>
                     <th>Weight(g)</th>
                     <th>SN</th>
                       <th> Status</th>
                     <th>Shipping Date</th>
                     <th>Shipped Item Info</th>
                     
                     <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($querylist->result() as $row) {
                    	echo "   <form action='".$url."order/tracknumber_update/' method='post' >";
                    	?>
               
                        <tr >
                   
                        <td class="nCategory"><?=$row->orderlistid?>  </td>
                        <td class="nCategory"><?=$row->couriername?>  </td>
                        <td class="nCategory"><?=$row->number?>  </td>
						<td class="nCategory"><?=$row->weight?>  </td>	
						<td class="nCategory"><?=$row->sn?>  </td>	
						
						<td class="nCategory"><?
							if($row->shippreturn=="0"){
								echo "Shipped";
							}else
								echo "Return";
							
							?>  </td>	
						<td class="nCategory"><?=$row->shippingdate?>  </td>	
						<td class="nCategory"><?
						
						$sql="select * from orderlistprod where orderlistid='$row->orderlistid'";
						$query=$this->db->query($sql);
							foreach ($query->result() as $row2) {
								echo $row2->Title."<br >";
							}
							
							?>  </td>	
							
							
							
						<td class="nCategory">
							
						
							<input type="hidden" name="tracknumberid" value='<?=$row->tracknumberid?>'>
							<input type="hidden" name="orderlistid" value='<?=$row->orderlistid?>'>
							
							<a href="<?=$url."order/tracknumber_del/".$row->tracknumberid?>/<?=$row->orderlistid?>">DEL</a>  </td>	
                      
                        </tr>
                          </form>
                        <? } ?>
                </tbody>
            </table>
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="clear"></div>
	</div>
</div>
