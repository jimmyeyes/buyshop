<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

			<h2 class="box-header">Enter Shipping Information</h2>

				 <form action="<?=$url?>order/tracknumber_adds" method="post">

		         <input type="hidden" value="<?php echo $orderlist->orderlistid; ?>" name='orderlistid'>

                     <table class="display" id="">
                         <thead>
                         <tr>
                             <th>Order ID</th>
                             <th> Tracking Number</th>
                             <th>Weight(g)</th>

                             <th>Shipping Courier</th>
                             <th> Package Type</th>

                             <th> Shipping Date</th>
                             <th> Shipped Item Info：</th>
                             <th>Action</th>
                         </tr>
                         </thead>
                         <tbody>
                         <tr >
                             <td > <?=$orderlist->orderlistid?> </td>
                             <td ><input class="form-control " type="text" name="number" > </td>
                             <td > <input class="form-control " type="text" name="weight" ></td>
                             <td >  <select class="form-control input-medium select2me"  name='courierid' >
                                     <option value=''></option>
                                     <?
                                     foreach ($courier->result() as $row2) {
                                         echo "<option value='{$row2->courierid}'>{$row2->name}</option>";
                                     }?>
                                 </select>
                             </td>
                             <td class="">
                                 <select class="form-control input-medium select2me"  name='package' >
                                     <option value=''></option>
                                     <?
                                     foreach ($package->result() as $row2) {
                                         echo "<option value='{$row2->packageid}'>{$row2->name}</option>";
                                     }?>

                             </td>


                             <td class="">   	<input  class="form-control " type="text" name="date" value="<?=$date?>"> </td>
                             <td class="">  <?

                                 $sql="select * from orderlistprod where orderlistid='$orderlist->orderlistid'";
                                 $query=$this->db->query($sql);
                                 foreach ($query->result() as $row2) {
                                     echo $row2->Title."<br >";
                                 }


                                 ?> </td>
                             <td>  <input type="submit" class="btn blue" value="ADD" ></td>
                         </tr>
                         </tbody>
                     </table>


			</form>


		

			<h2 class="box-header">Existing Shipping Information </h2>
        <table class="table table-striped table-bordered table-hover" id="">
                <thead>
                    <tr>
                     <th>OrderID</th>
                     <th>Courier</th>
                     <th>Tracking Number</th>
                     <th>Weight(g)</th>

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
                   
                        <td ><?=$row->orderlistid?>  </td>
                        <td ><?=$row->couriername?>  </td>
                        <td ><?=$row->number?>  </td>
						<td ><?=$row->weight?>  </td>	

						<td ><?=$row->shippingdate?>  </td>	
						<td ><?
						
						$sql="select * from orderlistprod where orderlistid='$row->orderlistid'";
						$query=$this->db->query($sql);
							foreach ($query->result() as $row2) {
								echo $row2->Title."<br >";
							}
							
							?>  </td>	

						<td >
							<input type="hidden" name="tracknumberid" value='<?=$row->tracknumberid?>'>
							<input type="hidden" name="orderlistid" value='<?=$row->orderlistid?>'>
							
							<a href="<?=$url."order/tracknumber_del/".$row->tracknumberid?>/<?=$row->orderlistid?>">DEL</a>  </td>	
                      
                        </tr>
                          </form>
                        <? } ?>
                </tbody>
            </table>
	    </div>
    </div>

