<?= $menu ?>
<div id="subnavbar"></div>
<div id="content">
	<div class="box themed_box">
		<h2 class="box-header">會計科目管理</h2>
		<div class="box-content">
			<form action="<?php echo $adminurl; ?>accounttype_edit_update" method="post">
				<label class="form-label"> 科目： </label>
				<input class="form-field small" type="text" value="<?php echo $row -> name; ?>"  name="name">
				
				<label class="form-label"> 編號： </label>
				<input class="form-field small" type="text"  value="<?php echo $row -> no; ?>"  name="no">
				
			<br />
			<input type="hidden" value="<?php echo $id; ?>" name='id'>
			<input type="submit" class="button white" value="Update" />
			</form>
			<div class="clear"></div>
		</div>
	</div>

</div>
