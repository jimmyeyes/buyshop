<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>列表
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">


        	  <form action="<?=$url?>inventory/inventory_update2" method="post">
       	   <input type='hidden' name ='inventorylistid' value='<?=$inventorylistid ?>'>
		 <input type='hidden' name ='inventoryid' value='<?=$inventoryid ?>'>

          	 <label >  單價： </label>
			<input class="form-control"    type="text"  name="price">
			
			 <label >  數量： </label>
			<input class="form-control"     type="text"  name="amount">


                  <table class="table table-striped table-bordered table-hover" id="sample_2">
                <thead>
                    <tr>
                    	<th><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/></th>
                        <th>品名</th>
      					<th>單價</th>
                        <th>數量</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	
                         	<td><input class="checkboxes" type="checkbox" value="<?= $row->inventorylistid ?>" name="chk[]"/>
                         		<a onClick="return check();" href="<?= $adminurl . "inventory_del" ?>/<?= $row->inventorylistid ?>/2/<?= $row->productid ?>">刪除</a>
                         	
                         	</td>
                           <td ><?= $row->prodname ?></td>
                           <td ><?=$row->price?>  </td>
                           <td ><?=$row->amount?>  </td>

                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
             <input type="submit" class="btn blue" value="更新" >
            </form>

    </div>
     </div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>退貨操作列表
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

        <table class="table table-striped table-bordered table-hover" id="sample_3">
                <thead>
                    <tr>
                    	<th>選擇</th>
                        <th>品名</th>
      					<th>單價</th>
                        <th>數量</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	
                        	<td>
                        	  <form action="<?=$url?>welcome/inventory_back_opt" method="post">
       	 		      
 					    <input type='hidden' name ='inventorylistid' value='<?=$row->inventorylistid ?>'>
                        	
                        	  <input type="submit" class="btn blue" value="退貨" >
                         	</td>
                           <td ><?= $row->prodname ?></td>
                           <td ><?=$row->price?>  </td>
                           <td ><input type="text" value="<?=$row->amount?>" name ="amount">  </td>
                           
							</form>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
           
            </form>

    </div>

 
</div>
