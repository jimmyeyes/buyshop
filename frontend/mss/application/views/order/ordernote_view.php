<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>Seller Note  OrderID:<?=$row->OrderID?>
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">
				

				
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
				<textarea name="note" class="form-control "  cols="100" rows="30"><?=$query -> note; ?></textarea>

				<br /><br />
				上次更新日期<?php echo $query->updatetime; ?>
			
				<input type="hidden" value="<?php echo $query->ordernoteid; ?>" name='ordernoteid'>
				<input type="hidden" value="<?=$modify ?>" name='modify'>

				<br /><br />
			  	<input type="submit" class="btn blue" value="Update" >
			</form>
		

	</div>
</div>
