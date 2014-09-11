




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>發票管理
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">


        <form action="<?=$url?>account/invoicelist" method="post" class="form-inline" role="form">

            <div class="form-group">

                <label class=" control-label">Search </label>


                <input class="" name="keyword" type="text" placeholder="keyword">

            </div>

            <input class="btn blue" type="submit" value="Search">
        </form>


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

            <table class="table table-hover" id="sample_3">
                <thead>
                <tr>
                    <th> <input type="checkbox" class="group-checkable" onclick="check_all(this,'chk3[]')"/></th>
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
                    <?

                    flush();
                }
                ?>
                </tbody>
            </table>



            <input type="submit" class="btn blue" value="Submit" >
        </form>
