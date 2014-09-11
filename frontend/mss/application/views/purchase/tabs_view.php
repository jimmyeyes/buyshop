
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
                <a href="#">採購</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

        <h2 class="box-header">待訂 </h2>


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
            <i class="fa fa-user"></i>
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">


        <h2 class="box-header">已訂 </h2>
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
                    foreach ($query2->result() as $row) {

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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">


        <h2 class="box-header">歷史訂單 </h2>
        	  <form action="<?=$url?>purchase/historyorderbath" method="post">
            <input type='hidden' name ='purchaseid' value='<?=$purchaseid4 ?>'>
       	      <input type='hidden' name ='type' value='4'>


            <label >  日期： </label>

          <div class="input-group input-medium date date-picker " data-date="<?=$pdate?>"  data-date-format="yyyy-mm-dd" data-date-viewmode="years">
              <input type="text" name="pdate" class="form-control" value="<?=$pdate?>" readonly>
                <span class="input-group-btn">

                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>


                </span>
          </div>


         <select class="form-control input-medium select2me" name="modtype">

          <option value="1">編輯</option>
            <option value="2">刪除</option>
          </select>
          </p>

               <table class="table table-striped table-bordered table-hover" id="sample_3">
                <thead>
                    <tr>
                   	<th> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/></th>
                   <!-- <th>操作</th> -->
                    <th>日期</th>
                    <th>公司名稱</th>
                    <th>類別名稱</th>
                    <th>品牌</th>
     				<th>品名</th>
                    <th>型號</th>
                    <th>SKU</th>
                     <th>數量</th>
                     <th>發票號碼</th>
                     <th>單價</th>
                     <th>付款狀態</th>
                    <th>交易條件</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $type=4;
                    $i = 0;
                    foreach ($query4->result() as $row) {

                        ?>
                        <tr >
                        	<td><input class="checkboxes" type="checkbox" value="<?=$row->purchaseid ?>" name="chk3[]"/></td>

                        <!--    <td ><a onClick="return check();"  href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td> -->
                        	 <td ><?= $row->pdate ?></td>
                             <td ><?=$row->companyname?>  </td>
                               <td ><?=$row->category?>  </td>
                               <td ><?=$row->brand?>  </td>
                            <td ><?=$row->prodname?>  </td>
                           <td ><?=$row->model?>  </td>
                           	<td ><?=$row->sku?>  </td>
                           	<td ><?=$row->amount?>   </td>
							<td ><?=$row->no?> </td>
							<td ><?=$row->price?>  </td>

					<!--	 <td >
                            <select   name='paytype<?=$row->purchaseid ?>'>
                            	<?if($row->paytype==0){?>
								<option selected value='0'>待付</option>
           						 <option value='1'>結清 </option>
           						 <?}else{?>
           		 				<option value='0'>待付</option>
           						 <option selected value='1'>結清 </option>
           						  <?}?>
           						  </select>
                            	 </td>
                           <td >  <select  name='alpay<?=$row->purchaseid ?>'>

                           	<?if($row->alpay==0){?>
           						 <option selected value='0'>現金</option>
           						 <option value='1'>支票 </option>

           						  <?}else{?>
           						 <option value='0'>現金</option>
           						  <option selected value='1'>支票 </option>

           		 	 	 	 <?}?>
           						  </select> </td>-->


						<td ><?=$this->all_model->getPayType($row->paytype)?>  </td>
						<td ><?=$this->all_model->getAlPay($row->alpay)?>  </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>



            <input type="submit" class="btn blue" value="Submit" >
            </form>

    </div>
</div>


