<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>新增項目
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

            <?php echo form_open_multipart('account/income_adds'); ?>
           

            <select class="form-control input-medium select2me" name='accounttypeid'>
            <?
            $sql = "select * from accounttype";

            $query2 = $this->db->query($sql);
			
            foreach ($query2->result() as $row2) {
                echo "<option value='{$row2->accounttypeid}' ";
               
                echo ">{$row2->name}</option>";
            }

            ?>
            </select>
          
            <select class="form-control input-medium select2me" name='inout'>
			<option value='0'>收入</option> 
      		 <option value='1'>費用</option>
      		  <option value='2'>成本</option>
            </select>

             <label>  金額    </label>
         <input  class="form-control"  type="text" name='amount' value="">
            
            <label>  日期： </label>
        <div class="input-group input-medium date date-picker " data-date=""  data-date-format="yyyy-mm-dd" data-date-viewmode="years">
            <input type="text" name="pdate" class="form-control" value="" readonly>
            <span class="input-group-btn">
            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>


        <input type="submit" class="btn blue" value="ADD">
            </form>
        </div>
        </div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>搜尋
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">
           <form action="<?=$url?>account/income" method="post">

               <div class="form-group">

               <label class="control-label col-md-3">  日期： </label>


               <div class="col-md-4">
                   <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                       <input type="text"  value="<?=$pdates?>" class="form-control" name="pdates">
												<span class="input-group-addon">
													to
												</span>
                       <input type="text" value="<?=$pdatee?>" class="form-control" name="pdatee">
                   </div>
                   <!-- /input-group -->
											<span class="help-block">
												Select date range
											</span>
               </div>

               <input type="submit" class="btn blue" value="搜尋">
              </div>
            </form>
        </div>
        </div>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>Income Statement
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

        <table class="table table-striped table-bordered table-hover" id="sample_2">
                <thead>
                    <tr>
                    	<th>刪除</th>
                    	<th>日期</th>
                    	<th>會計科目</th>
                    	<th>收入/費用/成本</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $in=0;
					$out=0;
                    
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        	<td><a href="<?= $adminurl . "income_del" ?>/<?= $row->incomeid ?>">刪除</a></td>
                        		<td><?=$row->pdate?></td>
                        	<td><?=$row->name?></td>
                        	<td><?=$this->all_model->getInout($row->type)?></td>
                        	<td><?=$row->amount?></td>
                        </tr>
                        <? 
                        
                        if($row->type==0){
                        	$in+=$row->amount;
                        }else{
                        	$out+=$row->amount;
                        }
                        
                        
					}
                    ?>
                </tbody>
            </table>
        </div>
    </div>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>Financial summary
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">

            <h2>Net Income:</h2>
            
            <?=$in-$out?>
            
            <br />
             <h2>Net Profit Margain:</h2>
              <?php
              $div="";
             if($out !=0 & $in!=0)
               $div=@$out/$in;
              if($div!=0){
              echo 	$div *100;
              }
             ?>
            
            <br />
            

    </div>
</div>
