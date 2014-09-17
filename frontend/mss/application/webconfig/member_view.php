<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">
        <div class="box themed_box">
        <h2 class="box-header"> 新增使用者</h2>
        <div class="box-content">
            <?php echo form_open_multipart('welcome/member_add'); ?>
           <input class="form-field small" type="text" size="10" name="name">
            <input type="submit" class="button white" value="ADD">請輸入帳號
            </form>
        </div>
        </div>
    <div class="box themed_box">
        <h2 class="box-header">使用者列表 </h2>
        <div class="box-content">
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>操作</th>
                        <th>帳號</th>
                        <th>權限</th>
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
                        	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "member_del" ?>/<?= $row->memberid ?>">刪除</a></td>
                            <td class="nTitle"><a href="<?= $adminurl . "member_edit" ?>/<?= $row->memberid ?>"><?= $row->username ?></a></td>
                            <td class="nCategory"><?
                            $auth= $row->authority;	
               $arr=$this->all_model->getAuth();
foreach($arr as $name =>$val ){
if(($val & $auth) == $val){
				?>
					<input  type="checkbox" checked name="auth[]" Value="<?=$val?>" />
					<?=$name?>
				<?php
				}}
				?>
                            </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>