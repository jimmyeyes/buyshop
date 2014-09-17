<?= $menu ?>
<script>
function SelectAccount(vall){
	  var arr=new Array();
  <?
		 $sql = "select *  from accounttoken ";
            	$queryarr = $this->db->query($sql);
            	foreach ($queryarr->result() as $rowarr) {
                     echo "arr[".$rowarr->accounttokenid."] = ['$rowarr->username','$rowarr->paypal','$rowarr->name','$rowarr->addr','$rowarr->zipcode','$rowarr->phone','$rowarr->country','$rowarr->city','$rowarr->accounttokenid','$rowarr->exptime','$rowarr->Currency','$rowarr->paypalusername','$rowarr->paypalpassword','$rowarr->signature'];";
           		 }		   
    ?>
    

var oform = document.forms["ebayaccount"];
oform.elements.username.value=arr[vall][0];
//oform.elements.username.disabled = true; 

oform.elements.paypal.value=arr[vall][1];
oform.elements.name.value=arr[vall][2];
oform.elements.addr.value=arr[vall][3];
oform.elements.zipcode.value=arr[vall][4];
oform.elements.phone.value=arr[vall][5];
oform.elements.country.value=arr[vall][6];
oform.elements.city.value=arr[vall][7];
oform.elements.accounttokenid.value=arr[vall][8];
oform.elements.exptime.value=arr[vall][9];
oform.elements.paypalusername.value=arr[vall][11];
oform.elements.paypalpassword.value=arr[vall][12];
oform.elements.signature.value=arr[vall][13];
oform.elements.edit.value="1";
oform.elements.submit.value="Edit";
oform.elements.ebay=arr[vall][8];
    oform.elements.Currency.value=arr[vall][10];

}

function delAccount(){
	var oform = document.forms["ebayaccount"];
    var username=oform.elements.username.value;

    if(username==""){
        alert("請選擇");
        return;

    }
    if ( confirm("確認刪除？"))
    {
        window.location.href="<?=$url; ?>order/delToken/"+username;

    }else{

    }



}



function SelectAccountpaypal(vall){
    var arr=new Array();
    <?
           $sql = "select *  from paypalaccount ";
                  $queryarr = $this->db->query($sql);
                  foreach ($queryarr->result() as $rowarr) {
                       echo "arr[".$rowarr->paypalaccountid."] = ['$rowarr->paypalaccountid','$rowarr->paypalusername','$rowarr->paypalpassword','$rowarr->signature','$rowarr->paypal'];";
                      }
      ?>


    var oform = document.forms["paypal"];
    oform.elements.paypalaccountid.value=arr[vall][0];
    oform.elements.paypalusername.value=arr[vall][1];
    oform.elements.paypalpassword.value=arr[vall][2];
    oform.elements.signature.value=arr[vall][3];
    oform.elements.paypal.value=arr[vall][4];
    oform.elements.edit.value="1";
    oform.elements.submit.value="Edit";

}

function delAccountpaypal(){
    var oform = document.forms["paypal"];
    var username=oform.elements.paypalaccountid.value;

    if(username==""){
        alert("請選擇");
        return;

    }
    if ( confirm("確認刪除？"))
    {
        window.location.href="<?=$url; ?>order/delTokenpaypal/"+username;

    }else{

    }



}


</script>

<div id="subnavbar"></div>
<div id="content">
	
		<div id="tabs" class="box tabs themed_box">
			<h2 class="box-header"></h2>
			<ul class="tabs-nav">
				<li class="tab"><a href="#tabs-1">一般設定</a></li>
				<li class="tab"><a href="#tabs-2">eBay 帳號</a></li>
                <li class="tab"><a href="#tabs-3">paypal 帳號</a></li>
			</ul>
			<div class="box-content">

		<div id="tabs-1">
			<div class="column half fl">
		<div class="box themed_box">
			<h2 class="box-header">匯率 </h2>
			<div class="box-content">
				<form action="<?= $adminurl ?>webconfig_update" method="post">
					<label > PUS:</label><input class="form-field 10"  value="<?= $query->pus ?>" name="pus" type="text" />
				
					<label > PUK:</label>  <input class="form-field 10"  value="<?= $query->puk ?>" name="puk" type="text" />
					
					<label> PAU:</label>  <input class="form-field 10" value="<?= $query->pau ?>" name="pau" type="text" />
					
					<label > BUS:</label>  <input class="form-field 10" value="<?= $query->bus ?>" name="bus" type="text" />
					<p>
					<input type="submit" class="button themed" value="Update" />
					<p>
				</form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>

			<div class="box themed_box">
			<h2 class="box-header">公式 </h2>
			<div class="box-content">
				<form action="<?= $adminurl ?>webconfig_fun_update" method="post">
					<label class="form-label"> <h2>美金:</h2></label>
					
					費用Ａ
					售價＊ <input class="form-field 10" value="<?= $query->usfee1 ?>" name="usfee1" type="text" />＋
					<input class="form-field 10" value="<?= $query->usfee2 ?>" name="usfee2" type="text" />
						<br>費用Ｂ -1
						售價＊ <input class="form-field 10" value="<?= $query->usfee3 ?>" name="usfee3" type="text" />
						<br>費用Ｂ -2
						售價＊ <input class="form-field 10" value="<?= $query->usfee4 ?>" name="usfee4" type="text" />
						<br>費用Ｂ -3
						售價＊ <input class="form-field 10" value="<?= $query->usfee5 ?>" name="usfee5" type="text" />
						
						
					<label class="form-label"> <h2>英鎊:</h2></label> 
					
					費用Ａ
					售價＊ <input class="form-field 10" value="<?= $query->ukfee1 ?>" name="ukfee1" type="text" />＋
					<input class="form-field 10" value="<?= $query->ukfee2 ?>" name="ukfee2" type="text" />
						<br>費用Ｂ 
						售價＊ <input class="form-field 10" value="<?= $query->ukfee3 ?>" name="ukfee3" type="text" />
					
					<label class="form-label"> <h2>澳幣:</h2></label>  
					
					費用Ａ
					售價＊ <input class="form-field 10" value="<?= $query->aufee1 ?>" name="aufee1" type="text" />＋
					<input class="form-field 10" value="<?= $query->aufee2 ?>" name="aufee2" type="text" />
						<br>費用Ｂ 
						售價＊ <input class="form-field 10" value="<?= $query->aufee3 ?>" name="aufee3" type="text" />
					
					<label class="form-label"> <h2>電匯:</h2></label>  
					手續費<input class="form-field 10" value="<?= $query->busfee1 ?>" name="busfee1" type="text" />
					<p>

					<input type="submit" class="button themed" value="Update" />
					<p>
				</form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

	<div class="column half fr">

		<div class="box themed_box">
			<h2 class="box-header"> Fedex IE運費</h2>
			<div class="box-content">
				<form action="<?= $adminurl ?>webconfig_shipping_update" method="post">
	<?
	$j=1;
					$i=1;
					foreach($shipping ->result() as $row){
					?>
					<label > <?=$row -> kg ?>  KG運費:</label>  <input class="form-field small" value="<?=$row -> fee ?>" name="shipping<?=$i ?>" type="text" />
					
					<?
					$j++;
					if($j==3){
						echo "<p>";
						$j=1;
					}
					$i++;
					}
					?>
					
						<input type="submit" class="button themed" value="Update" />
						</form>
			</div>
		</div>
		<div class="clear"></div>
		
		
		<div class="box themed_box">
			<h2 class="box-header"> 運送廠商</h2>
			<div class="box-content">
				
				
					<form action="<?= $adminurl ?>courier_adds" method="post">
					  <input class="form-field small" value="" name="name" type="text" />
					<input type="submit" class="button themed" value="Add" />
					</form>
				
				<br />
	<?
					foreach($courier ->result() as $row){
					?>
					<form action="<?= $adminurl ?>courier_update" method="post">
					  <input class="form-field small" value="<?=$row->name?>" name="name" type="text" />
					 <input class="form-field small" value="<?=$row->courierid?>" name="courierid" type="hidden" />
					
						<input type="submit" class="button themed" value="Update" />
						<a href="<?= $adminurl ?>courier_del/<?=$row->courierid?>" class="button themed">DEL</a>
						</form>
						<br />
					<?}
					
					?>
			</div>
		</div>
		<div class="clear"></div>

        <div class="box themed_box">
            <h2 class="box-header"> 排除地區</h2>
            <div class="box-content">

                <?php echo form_open_multipart('product/excludelist_adds'); ?>
                key
                <input class="form-field small" type="text" size="10" name="key">
                value  <input class="form-field small" type="text" size="10" name="value">
                <input type="submit" class="button white" value="ADD">
                </form>


                <table class="display" id="tabledata">
                    <thead>
                    <tr>
                        <th></th>

                        <th>VALUE</th>
                        <th>KEY</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($queryexce->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                            <form action="<?=$url?>product/excludelist_update" method="post">


                                <td class="nCategory"><a href="<?=$url?>product/excludelist_del/<?=$row->varlistid?>">DEL</a>  </td>

                                <td class="nCategory"> <input  type="text"  value="<?=$row->no?>" name="value" />  </td>

                                <td class="nCategory"> <input type="text"  value="<?=$row->name?>" name="key" />  <input type="hidden" value="<?=$row->varlistid?>" name="varlistid" />
                                    <input type="submit" class="button themed" value="Update">

                                </td>


                            </form>
                        </tr>
                    <? }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clear"></div>
	    </div>
			<div class="clear"></div>
		</div>
		
		<div id="tabs-2">
			<div class="column full">
		
			
		<div class="box themed_box">
			<h2 class="box-header">eBay Account </h2>
			<div class="box-content">
				
				  <form id="ebayaccount" method="post" action='<?=$url; ?>order/seller_adds'>
				
			
				<select name='ebay' onchange="SelectAccount(this.options[this.options.selectedIndex].value);"
					<option></option>	
					<option></option>	

				     <?
				foreach($accounttoken->result() as $row){
					?>
					<option value='<?=$row->accounttokenid?>'><?=$row->username?></option>	
					<?
				}
				//javascript: SelectAccount(<?=$row->accounttokenid?>); return false;
				?>
				</select>
				<br />
				<label class=""> eBay 帳號 </label>
				<input class="form-field 20px" type="text" value="" name="username"><br />
				
				<label class=""> paypal 帳號： </label>
				<input class="form-field 20px" type="text" value="" name="paypal"><br />


				<label > 名稱： </label>
				<input class="form-field small big" type="text" value="" name="name">
				<br />
				<label class=""> 郵遞區號： </label>
				<input class="form-field 20px" type="text" value="" name="zipcode">
				<br />
				<label > 地址： </label>
				<input class="form-field  small big" type="text" value="" name="addr">
				<br />
				<label > 電話： </label>
				<input class="form-field 20px" type="text" value="" name="phone">
				<br />
				<label> 國家： </label>
				<input class="form-field 20px" type="text" value="" name="country">
				<br />
				<label > 城市： </label>
				<input class="form-field 20px" type="text" value="" name="city"><br />
                 <label > 貨幣別： </label>
                <input class="form-field 20px" type="text" value="" name="Currency"> USD,GBP,AUD<br />
				<label > 到期時間： </label>
				<input class="form-field 40px" type="text" value="" name="exptime">
				
			
				
	        	<input type="hidden" value="" name="edit">
				<input type="hidden" value="" name="accounttokenid">

				<br />
				<a class="button white"	href="javascript: delAccount(); return false;">DEL</a>
				<input type="submit" class="button white" name="submit"  value="Adds">
		  </form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	    </div>
		</div>


        <div id="tabs-3">
            <div class="column full">


                <div class="box themed_box">
                    <h2 class="box-header">PayPal Account </h2>
                    <div class="box-content">

                        <form id="paypal" method="post" action='<?=$url; ?>order/paypal_adds'>


                            <select name='paypalsel'  onchange="SelectAccountpaypal(this.options[this.options.selectedIndex].value);"
                            <option></option>
                            <option></option>

                            <?
                            foreach($paypalaccount->result() as $row){
                                ?>
                                <option value='<?=$row->paypalaccountid?>'><?=$row->paypal?></option>
                            <?
                            }
                            //javascript: SelectAccount(<?=$row->accounttokenid?>); return false;
                            ?>
                            </select>
                            <br />

                            <label class=""> paypal ： </label>
                            <input class="form-field small big" type="text" value="" name="paypal"><br />



                            <label class=""> paypal api帳號： </label>
                            <input class="form-field small big" type="text" value="" name="paypalusername"><br />


                            <label class=""> paypal api密碼： </label>
                            <input class="form-field small big" type="text" value="" name="paypalpassword"><br />


                            <label class=""> paypal api signature： </label>
                            <input class="form-field small big" type="text" value="" name="signature"><br />


                            <input type="hidden" value="" name="edit">
                            <input type="hidden" value="" name="paypalaccountid">

                            <br />
                            <a class="button white"	href="javascript: delAccountpaypal(); return false;">DEL</a>
                            <input type="submit" class="button white" name="submit"  value="Adds">
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>





		
		</div>
		
		</div>

	<div class="clear"></div>
</div>

