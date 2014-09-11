<?= $menu ?>
<div id="subnavbar"></div>
<div id="content">
	<div class="box themed_box">
		<h2 class="box-header">Edit 使用者</h2>
		<div class="box-content">
			<form action="<?php echo $adminurl; ?>member_edit_update" method="post">
				<label class="form-label"> Name： </label>
				<input class="form-field small" type="text" value="<?php echo $row -> name; ?>"  name="name">
				<label class="form-label"> Username： </label><?php echo $row -> username; ?>
				<label class="form-label"> Password： </label>
				<input class="form-field small" type="password"  name="password">
				<label class="form-label"> Confirm Password： </label>
				<input class="form-field small" type="password"  name="chkpassword">


				<label class="form-label"> 權限: </label>
				<table>
				<?php
				$auth=$row -> authority;
				
           $arr=$this->all_model->getAuth();

foreach($arr as $name =>$val ){
if(($val & $auth) == $val){
				?>
				<tr>
					<td>
					<input  type="checkbox" checked name="auth[]" Value="<?=$val?>" />
					<?=$name?></td>
				</tr>
				<?
				}
				else{
				?>
				<tr>
					<td>
					<input  type="checkbox"  name="auth[]" Value="<?=$val?>" />
					<?=$name?></td>
				</tr>
				<?
				}
				}
				?>

				</table>

			<br />
			<input type="hidden" value="<?php echo $id; ?>" name='id'>
			<input type="submit" class="button white" value="Update" />
			</form>
			<div class="clear"></div>
		</div>
	</div>
</div>
