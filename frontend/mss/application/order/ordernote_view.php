<?= $menu ?>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div class="box themed_box">
			<h2 class="box-header">Seller Note </h2>
			<div class="box-content">
				
				OrderID:<?=$row->OrderID?> <br />
				
				<?
				$modify="";
				
				if($query->modifyusername==""){
					$modify=$this -> session -> userdata('username');
				}else{
					$modify=$query->modifyusername;
				}
				?>

				Owndership:<?=$modify?>
			 <form action="<?=$url?>order/updateordernote" method="post">
				<textarea name="note"   cols="100" rows="30"><?=$query -> note; ?></textarea>				

				<br /><br />
				上次更新日期<?php echo $query->updatetime; ?>
			
				<input type="hidden" value="<?php echo $query->ordernoteid; ?>" name='ordernoteid'>
				<input type="hidden" value="<?=$modify ?>" name='modify'>

				<br /><br />
			  	<input type="submit" class="button white" value="Update" >
			</form>
		
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
