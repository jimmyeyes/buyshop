<?= $menu ?>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		
		
		
		<div class="box themed_box">
			<h2 class="box-header">EBAY Account </h2>
			<div class="box-content">
				  <form id="categoryval" method="post" action='<?php echo $adminurl; ?>seller_update'>
				
				<label class="form-label"> ebay 帳號 </label>
				<?=$row->username?>

				<label class="form-label"> paypal 帳號： </label>
				<input class="form-field 20px" type="text" value="<?=$row->paypal?>" name="paypal">
				
				<label class="form-label"> 名稱： </label>
				<input class="form-field small big" type="text" value="<?=$row->name?>" name="name">
				<label class="form-label"> 郵遞區號： </label>
				<input class="form-field 20px" type="text" value="<?=$row->zipcode?>" name="zipcode">
				<label class="form-label"> 地址： </label>
				<input class="form-field small big" type="text" value="<?=$row->addr?>" name="addr">
				<label class="form-label"> 電話： </label>
				<input class="form-field 20px" type="text" value="<?=$row->phone?>" name="phone">
				<label class="form-label"> 國家： </label>
				<input class="form-field 20px" type="text" value="<?=$row->country?>" name="country">
				<label class="form-label"> 城市： </label>
				<input class="form-field 20px" type="text" value="<?=$row->city?>" name="city">
			
				<label class="form-label"> Session Time： </label>
				<?=$row->exptime?>
		
				<input type="hidden" name='accounttokenid' value="<?=$row->accounttokenid?>">
				<br />
				<input type="submit" class="button white"  value="update">
			  </form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
