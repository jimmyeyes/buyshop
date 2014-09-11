
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>新增會計科目
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">



        <!-- END FORM-->
        </div>
        </div>


        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-square"></i>會計科目列表
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
                    	<th>操作</th>
                        <th>科目</th>
                        <th>編號</th>
     					
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
                        	<form action="<?= $adminurl ?>accounttype_update" method="post">
                        		<input type="hidden" name="type" value="4">
                        		<input type="hidden" name="id" value="<?=$row->accounttypeid?>">
                        		
                        	 <td class="nTitle"><a  onClick="return check();" href="<?= $adminurl . "accounttype_del" ?>/<?= $row->accounttypeid ?>">刪除</a>
                        	 	<input type="submit" class="btn blue" value="更新">
                        	 </td>
                            <td class="nTitle">
                            	<input type="text" class="form-control" name="name" value="<?= $row->name ?>">
                            	</td>
                            <td class="nCategory">
                            	
                            	<input type="text" class="form-control" name="no" value="<?=$row->no?> "> </td>
                            </form>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>

    </div>
</div>
