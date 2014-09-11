<?= $menu ?>
<style>
.td1{
	background-color:#CCC;
	font-size:19px;
	width:150px;
	
}

</style>

<script>

    function checkreturn(){
        var oform = document.forms["form1"];
        var orderlistid=  oform.elements.orderlistid.value;
        if(confirm("確定退貨？"))
        {
            window.location="<?=$url?>order/toback_update/"+orderlistid;
        }
        else
        {

        }
    }

</script>


<div id="subnavbar"></div>
<div id="content">
	<div class="column full">
		<div class="box themed_box">
			<h2 class="box-header">Order #<?=$orderlistid?> Details </h2>
			<div class="box-content">
				<form name="form1" id="form1" action="<?=$url?>order/updateordershipinfo" method="post">
				<input type="hidden" name="orderlistid" value="<?=$orderlistid?>">
				<input type="hidden" name="BuyerUserID" value="<?=$trans->BuyerUserID?>">
				<h2> Shipping Info： </h2>
				<table>
				<tr>
					<td class='td1'>Recipient Name</td><td><input type="text" name="SHIPTONAME" value="<?=$trans->Name?>"></td>
				</tr>	
					<tr>
					<td class='td1'>Street Address</td><td><input type="text" name="SHIPTOSTREET" value="<?=$trans->Street1?>"></td>
				</tr>
					<tr>
					<td class='td1'>City</td><td><input type="text" name="SHIPTOCITY" value="<?=$trans->CityName?>"></td>
				</tr>
					<tr>
					<td class='td1'>State</td><td><input type="text" name="SHIPTOSTATE" value="<?=$trans->StateOrProvince?>"></td>

				</tr>
					<tr>
					<td class='td1'>Zip Code</td><td><input type="text" name="SHIPTOZIP" value="<?=$trans->PostalCode?>"></td>

				</tr>
					<tr>
					<td class='td1'>Country</td><td><input type="text" name="SHIPTOCOUNTRYNAME" value="<?=$trans->CountryName?>"></td>

				</tr>
				
					<tr>
					<td class='td1'>Phone</td><td><input type="text" name="phone" value="<?=$trans->Phone?>"></td>
				</tr>
				</table>
				
				<labe>  Update Order Status： </label>
				<table>
				<tr>
					<td class='td1'>current status</td><td><?=$status?></td>
				</tr>	
					<tr>
					<td class='td1'>Change Status</td><td>
						<select name="status">
							<option>Label Printd</option>
							<option>Reversed</option>

						</select>
					</td>
				</tr>
				</table>
					<labe>  Submit Change： </label>
					<table>
					<tr class='td1'>
					<td >username</td><td>password</td><td></td><td></td>

					</tr>
					<tr>
					<td><input type='text' name="username"></td><td><input type='password' name="password"></td><td><input class="button white" type='submit'  value="Modify Order"></td>
					<td><a class="button white" target="_blank" href="<?=$url?>order/printaddr/<?=$trans->accounttokenid?>/<?=$orderlistid?>">列印地址</a>
					<a class="button white"  target="_blank" href="<?=$url?>order/printvoice/<?=$trans->accounttokenid?>/<?=$orderlistid?>">列印發票</a>
					<a class="button white"  onclick="checkreturn()">退貨</a>
					</td>
					</tr>
				
					</table>


				</form>
				
			
				  	</table>
				  
				
				<labe>  Modeification History： </label>
				<table>
					<tr class='td1'>
					<td>Date</td><td>Modification Content</td><td>Modifier</td>
				</tr>
				<?
				
				if($status!=""){
				foreach($shippingaddr->result() as $row){
				?>
				<tr>
					<td width="200px"><?=$row->createtime?></td><td><?=$row->recipientname."  ".$row->addr."  ".$row->city."  ".$row->state."  ".$row->zipcode."  ".$row->country?></td><td width="100px" align="right"><?=$row->name?></td>
				</tr>
				<? }}?>
				</table>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
