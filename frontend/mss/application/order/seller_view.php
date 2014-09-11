<?= $menu ?>

<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		
			<div class="box themed_box">
			<h2 class="box-header">EBAY Account </h2>
			<div class="box-content">
				 <table class="display" id="">
                <thead>
                    <tr>
                
                     <th>EBAY username</th>
                     <th>Session EXTIME</th>
                    </tr>
                </thead>
                <tbody>
                    <?
				foreach($query->result() as $row){
					?>
					<tr>
					<td><a href='<?=$url . "order/seller_detail" ?>/<?=$row->accounttokenid?>'><?=$row->username?></a></td>
					<td><?=$row->exptime?></td>
					</tr>
					<?
				}
				?>
                </tbody>
            </table>
				 
			
			</div>
		</div>
		
		<div class="box themed_box">
			<h2 class="box-header">EBAY Account </h2>
			<div class="box-content">
				  <form id="categoryval" method="post" action='<?php echo $adminurl; ?>seller_adds'>
				
				<label class="form-label"> ebay 帳號 </label>
				<input class="form-field small" type="text" value=""  name="username">

				<label class="form-label"> paypal 帳號： </label>
				<input class="form-field 20px" type="text" value="" name="paypal">
				<br>
				<label class="form-label"> 名稱： </label>
				<input class="form-field 20px" type="text" value="" name="name">
				<label class="form-label"> 地址： </label>
				<input class="form-field 20px" type="text" value="" name="addr">
				<label class="form-label"> 電話： </label>
				<input class="form-field 20px" type="text" value="" name="phone">
				<label class="form-label"> 國家： </label>
				<input class="form-field 20px" type="text" value="" name="county">
			
				<label class="form-label"> Session Time： </label>
				<input class="form-field 20px" type="text" value="" name="county">
		
				<input type="hidden" name='accountokenid' value="">
				<br />
				<input type="submit"  value="ADDS">
		  </form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
