<style>
.td1{
	background-color:#CCC;
	font-size:19px;
	width:200px;
}
    .form-control{
        width: 550px;;
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
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box grey">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-square"></i>Order #<?=$orderlistid?> Details </h2>
        </div>
        <div class="actions">
            <div class="btn-group">

            </div>
        </div>
    </div>
    <div class="portlet-body">
			<form name="frmSubmit" id="frmSubmit" action="<?=$url?>order/print_label" method="post">
			  <div class="radiocheck">
                <!--    <input id="radio1" type="radio" value="address" name="type" checked /><label for="radio1">Air Mail</label>
                  <input id="radio5" type="radio" value="fedex" name="type"/><label for="radio5">FedEx</label>-->

                    <input id="radio1" type="radio" value="dhl" name="type"/><label for="radio1">DHL</label>
                    <input id="radio2" type="radio" value="invoice" name="type"/><label for="radio2">Invoice</label>

                    <?

                    $i=3;
                    $sql="select * from printsetting";
                    $query2=$this->db->query($sql);

                    foreach($query2->result() as $row3){
                        ?>
                        <input id="radio<?=$i?>" type="radio" value="<?=$row3->printsettingid?>" name="type"/><label for="radio<?=$i?>"><?=$row3->name?></label>
                        <?
                        $i++;
                    }

                    ?>


                  <!--	<a class="btn blue" target="_blank" href="<?=$url?>order/printaddr/<?=$trans->accounttokenid?>/<?=$orderlistid?>">列印地址</a>
                      <a class="btn yellow" target="_blank" href="<?=$url?>order/dhl_print/<?=$orderlistid?>">列印DHL 標簽</a>
                     <a class="btn green"  target="_blank" href="<?=$url?>order/printvoice/<?=$trans->accounttokenid?>/<?=$orderlistid?>">列印發票</a>
      -->

              </div>
              	<input type="hidden" value="<?=$trans->accounttokenid?>" name="accounttokenid" />
              	<input type='hidden' value="<?=$orderlistid?>" name="orderlistid" />
                <input class="btn blue" type='submit'  value="Print" onclick="document.frmSubmit.target='_new'">
			</form>


        <div class="portlet-body form">
				<form name="form1" id="form1" action="<?=$url?>order/updateordershipinfo" method="post" role="form">
				<input type="hidden" name="orderlistid" value="<?=$orderlistid?>">
				<input type="hidden" name="BuyerUserID" value="<?=$trans->BuyerUserID?>">
				<h2> Shipping Info： </h2>
                  <div class="form-group">
				<table>
				<tr>
					<td class='td1'>Recipient Name</td><td><input type="text" class="form-control" name="SHIPTONAME" value="<?=$trans->Name?>"></td>
				</tr>	
					<tr>
					<td class='td1'>Street Address</td><td><input type="text" class="form-control" name="SHIPTOSTREET" value="<?=$trans->Street1?><?=$trans->Street2?>"></td>
				</tr>
					<tr>
					<td class='td1'>City</td><td><input type="text" name="SHIPTOCITY" class="form-control" value="<?=$trans->CityName?>"></td>
				</tr>
					<tr>
					<td class='td1'>State</td><td><input type="text" name="SHIPTOSTATE" class="form-control" value="<?=$trans->StateOrProvince?>"></td>

				</tr>
					<tr>
					<td class='td1'>Zip Code</td><td><input type="text" name="SHIPTOZIP" class="form-control" value="<?=$trans->PostalCode?>"></td>
				</tr>
			    <tr>
					<td class='td1'>Country</td><td><input type="text" name="SHIPTOCOUNTRYNAME" class="form-control" value="<?=$trans->CountryName?>"></td>
				</tr>

                    <tr>
                        <td class='td1'>Country Code</td><td><input type="text" name="Country" class="form-control" value="<?=$trans->Country?>"></td>
                    </tr>
					<tr>
					<td class='td1'>Phone</td><td><input type="text" name="phone" class="form-control" value="<?=$trans->Phone?>"></td>
				</tr>
				</table>
                  </div>

				<label>  Update Order Status： </label>
				<table>
				<tr>
					<td class='td1'>current status</td><td><?=$status?></td>
				</tr>	
					<tr>
					<td class='td1'>Change Status</td><td>
						<select class="form-control input-medium select2me" name="status">
							<option>Label Printd</option>
							<option>Reversed</option>

						</select>
					</td>
				</tr>
				</table>
					<label>  Submit Change： </label>
					<table>
					<tr>
					<td >Username</td><td>Password</td><td></td>

					</tr>
					<tr>
					<td><input type='text' class="form-control" name="username"></td>
                    <td><input type='password' class="form-control" name="password"></td>
                    <td><input class="btn red" type='submit'  value="Modify Order"></td>
					
					</tr>
			
					</table>
				</form>

            </div>

        <form name="form1" id="form1" action="<?=$url?>order/updateContent" method="post">
            <input type="hidden" name="orderlistid" value="<?=$orderlistid?>">
            <table>
                <tr>
                    <td >content</td>

                </tr>
                <tr>

                    <?
                    $sql="select * from mynote where orderlistid='$orderlistid'";
                    $count=$this->db->query($sql)->num_rows();

                    if($count >0){
                        $row=$this->db->query($sql)->row();
                        $content=$row->content;
                    }else{
                        $content="";
                    }


                    ?>

                    <td><input type='text' class="form-control" value="<?=$content?>" name="content"></td>


                </tr>

            </table>

            <input class="btn red" type='submit'  value="Update DHL content">
        </form>

        <br>
			

				
				<label>  Modeification History： </label>
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

		</div>
	</div>
</div>
