<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">

	  <div class="box themed_box">
        <h2 class="box-header"> 新增會計科目</h2>
        <div class="box-content">
            <?php echo form_open_multipart('account/accounttype_adds'); ?>
         會計科目  <input class="form-field 30px" type="text" size="10" name="name">
           編號 <input class="form-field 10px" type="text" size="10" name="no">
       
           
            <input type="submit" class="button white" value="ADD">
            </form>
        </div>
        </div>

        <div class="box themed_box">
        <h2 class="box-header"> 會計科目列表</h2>
       
        <div class="box-content">
            <table class="display" id="tabledata">
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
                        	 	<input type="submit" value="更新">
                        	 </td>
                            <td class="nTitle">
                            	<input type="text" name="name" value="<?= $row->name ?>">
                            	</td>
                            <td class="nCategory">
                            	
                            	<input type="text" name="no" value="<?=$row->no?> "> </td>
                            </form>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>