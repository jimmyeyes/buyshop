<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>退貨列表
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">
        	  <form action="<?=$url?>inventory/inventory_back_bathupdate" method="post">
       	   <input type='hidden' name ='inventorylistid' value='<?=$inventorylistid ?>'>

	

            	 <?
            $sql = "select m.* from company m ";
	//echo $sql;
            $query2 = $this->db->query($sql);
			 echo " ";
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->companyid}' ";
                echo ">{$row2->companyname}</option>";
            }
            echo "</select>";
            ?>
			
			 <label >  發票號碼： </label>
			<input class="form-control"   type="text"  name="no">

                  <table class="table table-striped table-bordered table-hover" id="sample_3">
                <thead>
                    <tr>
                    	<!--<th>選擇</th> -->
                    	<th>操作</th>   
                        <th>類別名稱</th>
                         <th>品牌</th>
                        <th>品名</th>
     					<th>型號</th>
                        <th>SKU</th>
                        <th>數量</th>
                        <th>單價</th>
                       
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
                        	<!-- <td><input type="checkbox" value="<?=$row->inventorylistid ?>" name="chk[]"/></td> -->
                        	 <td ><a onClick="return check();" href="<?= $adminurl . "inventory_del" ?>/<?= $row->inventorylistid ?>/1">刪除</a> </td>
                         
                                <td ><?=$row->category?>  </td>
                           <td ><?=$row->brand?>  </td>
                            <td ><?= $row->prodname ?></td>
                            <td ><?=$row->model?>  </td>
                            <td ><?=$row->sku?>  </td>
                           <td ><?=$row->amount?>  </td>
                        <td ><?=$row->price?>  </td>       
                          
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
         
    </div>

</div>
