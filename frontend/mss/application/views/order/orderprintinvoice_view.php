<style type="text/css">
input{
	border:0px;  overflow:hidden; font-size:18px; 
	font-family: "Helvetica"; 
}
textarea{
	border:0px;  overflow:hidden; font-size:18px; 
	font-family: "Helvetica";
}
body{
	font-family: "Helvetica";
	font-size:20px;font-weight:900; 
}
.title{
	font-weight:900;
	font-family: "Helvetica";
}
</style>
<span style="background-color: #999999">Invoice  ID#<?=$orderlistid?></span>
<br />
<table border="0">
	<tr><td>
		<textarea cols="53" rows="1">報關內容</textarea>
	</td></tr>
</table>

<br />                             
<table border="0">
		<tr><td>
	<span class="title">Content </span>
	</td><td>
		<span class="title">QTY</span>
	</td><td>
	<span class="title">Value</span>

	</td><td>
	<span class="title">Subtotal</span>

	</td></tr>
<? 
$sql="select  * from orderlistprod where orderlistid='".$orderlistid."'";
$query=$this->db->query($sql);
foreach($query->result() as $row){?>

	<tr><td>
	<textarea cols="35" rows="1"   id="shippingAddressInputTextArea" style="">
<?=$row->Title?>
	</textarea>
	
	
	</td><td>
		<textarea cols="3" rows="1"   id="shippingAddressInputTextArea" style="">
<?=$row->QuantityPurchased?>
	</textarea>
	</td><td>
		
			<textarea cols="6" rows="1"   id="shippingAddressInputTextArea" style="">
<?=$row->TransactionPrice?>
	</textarea>
	
	</td><td>
			
			<textarea cols="6" rows="1"   id="shippingAddressInputTextArea" style="">
<?=$row->TransactionPrice?>
	</textarea>
	</td></tr>
<? }?>

</table>

<br />

<table border="0">
	<tr><td>
<span class="title">Shipping</span>

	</td><td>
<span class="title">Total</span>

	</td></tr>
	<tr><td>

			<textarea cols="10" rows="1"   id="shippingAddressInputTextArea" style="">
<?=$ShippingServiceCost?>	</textarea>

	</td><td>
			<textarea cols="10" rows="1"   id="shippingAddressInputTextArea" style="">
<?=$ShippingServiceCurrency?> <?=$total?>
	</textarea>
	</td></tr>
</table>
<br />
<table border="0">
	<tr><td>
<span class="title">CONSIGNEE</span>
</textarea>
	</td><td>	
<span class="title">SHIPPER</span>
</textarea>
	</td></tr>
	<tr><td>
<textarea cols="25" rows="8"  >
<?=$name2?>

<?=$addr2?>
<?=$addr21?>

<?=$zipcode2?>

<?=$city2?>

<?=$country2?>

<?=$phone2?>

<?=$email?>
</textarea>
	</td><td>
	
		<textarea cols="25" rows="8">
<?=$name?>

<?=$addr?>

<?=$zipcode?>

<?=$city?>

<?=$country?>

<?=$phone?>
	</textarea>

	</td></tr>
</table>
