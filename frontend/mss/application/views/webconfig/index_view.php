<script>
function SelectAccount(vall){
	  var arr=new Array();
  <?
		 $sql = "select *  from accounttoken ";
            	$queryarr = $this->db->query($sql);
            	foreach ($queryarr->result() as $rowarr) {
                     echo "arr[".$rowarr->accounttokenid."] = ['$rowarr->username','$rowarr->paypal','$rowarr->name','$rowarr->addr','$rowarr->zipcode','$rowarr->phone','$rowarr->country','$rowarr->city','$rowarr->accounttokenid','$rowarr->exptime','$rowarr->Currency','$rowarr->paypalusername','$rowarr->paypalpassword','$rowarr->signature','$rowarr->PersonName','$rowarr->addr2'];";
           		 }		   
    ?>
    

var oform = document.forms["ebayaccount"];
oform.elements.username.value=arr[vall][0];
//oform.elements.username.disabled = true; 

oform.elements.paypal.value=arr[vall][1];
oform.elements.name.value=arr[vall][2];
oform.elements.addr.value=arr[vall][3];
oform.elements.addr2.value=arr[vall][15];
oform.elements.zipcode.value=arr[vall][4];
oform.elements.phone.value=arr[vall][5];
oform.elements.country.value=arr[vall][6];
oform.elements.city.value=arr[vall][7];
oform.elements.accounttokenid.value=arr[vall][8];
oform.elements.exptime.value=arr[vall][9];
oform.elements.PersonName.value=arr[vall][14];
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
    oform.elements.paypalpassword.value="";//arr[vall][2];
    oform.elements.signature.value="";//arr[vall][3];
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



function SelectPrint(vall){
    var arr=new Array();
    <?
          $sql = "select *  from printsetting ";
          $queryarr = $this->db->query($sql);
          foreach ($queryarr->result() as $rowarr) {
               echo "arr[".$rowarr->printsettingid."] = ['$rowarr->printsettingid','$rowarr->name','$rowarr->width','$rowarr->height','$rowarr->sendtop','$rowarr->sendleft','$rowarr->rectop','$rowarr->recleft','$rowarr->orderidtop','$rowarr->orderidleft','$rowarr->sendyeartop','$rowarr->sendyearleft','$rowarr->sendmonthtop','$rowarr->sendmonthleft','$rowarr->senddaytop','$rowarr->senddayleft','$rowarr->desctop','$rowarr->descleft','$rowarr->ORIENTATION','$rowarr->size'];";
          }
      ?>


    var oform = document.forms["print"];
    oform.elements.printsettingid.value=arr[vall][0];
    oform.elements.name.value=arr[vall][1];
    oform.elements.width.value=arr[vall][2];
    oform.elements.height.value=arr[vall][3];

    oform.elements.sendtop.value=arr[vall][4];
    oform.elements.sendleft.value=arr[vall][5];
    oform.elements.rectop.value=arr[vall][6];
    oform.elements.recleft.value=arr[vall][7];
    oform.elements.orderidtop.value=arr[vall][8];
    oform.elements.orderidleft.value=arr[vall][9];

    oform.elements.sendyeartop.value=arr[vall][10];
    oform.elements.sendyearleft.value=arr[vall][11];
    oform.elements.sendmonthtop.value=arr[vall][12];
    oform.elements.sendmonthleft.value=arr[vall][13];
    oform.elements.senddaytop.value=arr[vall][14];
    oform.elements.senddayleft.value=arr[vall][15];

    oform.elements.desctop.value=arr[vall][16];
    oform.elements.descleft.value=arr[vall][17];
    oform.elements.ORIENTATION.value=arr[vall][18];
    oform.elements.size.value=arr[vall][19];



    oform.elements.edit.value="1";
    oform.elements.submit.value="Edit";

}

function delPrint(){
    var oform = document.forms["print"];
    var username=oform.elements.printsettingid.value;

    if(username==""){
        alert("請選擇");
        return;

    }
    if ( confirm("確認刪除？"))
    {
        window.location.href="<?=$url; ?>welcome/delprint/"+username;

    }else{

    }
}


</script>
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            系統設置
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">系統設置</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    0
                </div>
                <div class="desc">
                    New Feedbacks
                </div>
            </div>
            <a class="more" href="#">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?=$orderamount?>
                </div>
                <div class="desc">
                     Orders
                </div>
            </div>
            <a class="more" href="#">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?=$buyersnote?>
                </div>
                <div class="desc">
                    BuyersNote
                </div>
            </div>
            <a class="more" href="#">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat yellow">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                   <?=number_format($paypalamt, 2);?>
                </div>
                <div class="desc">
                    PayPal AMT Amount
                </div>
            </div>
            <a class="more" href="#">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>

    <div class="portlet box blue tabbable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-reorder"></i>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tabbable portlet-tabs" id="tabs">
                <ul class="nav nav-tabs">

                    <li class="active"><a data-toggle="tab" href="#tabs-1">General</a></li>
                    <li ><a data-toggle="tab" href="#tabs-2">eBay </a></li>
                    <li ><a data-toggle="tab"  href="#tabs-3">PayPal </a></li>
                    <li ><a data-toggle="tab" href="#portlet_tab_4">Shipping</a></li>
               <!--     <li ><a data-toggle="tab"  href="#tabs-5">列印設定</a></li>-->

                    <li ><a data-toggle="tab"  href="#tabs-6">Print</a></li>
                    <li ><a data-toggle="tab"  href="#tabs-7">Accounting</a></li>
                    <li ><a data-toggle="tab"  href="#tabs-8">User</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1">



                        <div class="col-md-6 col-sm-6">

                                <h2 >匯率 </h2>

                                    <form action="<?= $adminurl ?>webconfig_update" method="post">
                                        <label > PUS:</label><input class="form-control"   value="<?= $query->pus ?>" name="pus" type="text" />

                                        <label > PUK:</label>  <input class="form-control"   value="<?= $query->puk ?>" name="puk" type="text" />

                                        <label> PAU:</label>  <input class="form-control"  value="<?= $query->pau ?>" name="pau" type="text" />

                                        <label > BUS:</label>  <input class="form-control"  value="<?= $query->bus ?>" name="bus" type="text" />
                                        <p>
                                            <input type="submit" class="btn blue" value="Update" />
                                        <p>
                                    </form>




                                <h2 >公式 </h2>

                                    <form action="<?= $adminurl ?>webconfig_fun_update" method="post">
                                        <label class="form-label"> <h2>美金:</h2></label>

                                        費用Ａ
                                        售價＊ <input class="form-control"  value="<?= $query->usfee1 ?>" name="usfee1" type="text" />＋
                                        <input class="form-control"  value="<?= $query->usfee2 ?>" name="usfee2" type="text" />
                                        <br>費用Ｂ -1
                                        售價＊ <input class="form-control"  value="<?= $query->usfee3 ?>" name="usfee3" type="text" />
                                        <br>費用Ｂ -2
                                        售價＊ <input class="form-control"  value="<?= $query->usfee4 ?>" name="usfee4" type="text" />
                                        <br>費用Ｂ -3
                                        售價＊ <input class="form-control"  value="<?= $query->usfee5 ?>" name="usfee5" type="text" />


                                        <label class="form-label"> <h2>英鎊:</h2></label>

                                        費用Ａ
                                        售價＊ <input class="form-control"  value="<?= $query->ukfee1 ?>" name="ukfee1" type="text" />＋
                                        <input class="form-control"  value="<?= $query->ukfee2 ?>" name="ukfee2" type="text" />
                                        <br>費用Ｂ
                                        售價＊ <input class="form-control"  value="<?= $query->ukfee3 ?>" name="ukfee3" type="text" />

                                        <label class="form-label"> <h2>澳幣:</h2></label>

                                        費用Ａ
                                        售價＊ <input class="form-control"  value="<?= $query->aufee1 ?>" name="aufee1" type="text" />＋
                                        <input class="form-control"  value="<?= $query->aufee2 ?>" name="aufee2" type="text" />
                                        <br>費用Ｂ
                                        售價＊ <input class="form-control"  value="<?= $query->aufee3 ?>" name="aufee3" type="text" />

                                        <label class="form-label"> <h2>電匯:</h2></label>
                                        手續費<input class="form-control"  value="<?= $query->busfee1 ?>" name="busfee1" type="text" />
                                        <p>

                                            <input type="submit" class="btn blue" value="Update" />
                                        <p>
                                    </form>
                        </div>

                        <div class="col-md-6 col-sm-6">

                                <h2 > 運送廠商</h2>

                                    <form action="<?= $adminurl ?>courier_adds" method="post">
                                        <input class="form-control"   value="" name="name" type="text" />
                                        <input type="submit" class="btn blue" value="Add" />
                                    </form>

                                    <br />
                                    <?
                                    foreach($courier ->result() as $row){
                                        ?>
                                        <form action="<?= $adminurl ?>courier_update" method="post">
                                            <input class="form-control"   value="<?=$row->name?>" name="name" type="text" />
                                            <input class="form-control"   value="<?=$row->courierid?>" name="courierid" type="hidden" />

                                            <input type="submit" class="btn blue" value="Update" />
                                            <a href="<?= $adminurl ?>courier_del/<?=$row->courierid?>" class="btn red">DEL</a>
                                        </form>
                                        <br />
                                    <?}

                                    ?>

                                <h2 > 排除地區</h2>

                                    <?php echo form_open_multipart('product/excludelist_adds'); ?>
                                    key
                                    <input class="form-control"   type="text" size="10" name="key">
                                    value  <input class="form-control"   type="text" size="10" name="value">
                                    <input type="submit" class="btn blue" value="ADD">
                                    </form>


                                    <table class="display" id="tabledata">
                                        <thead>
                                        <tr>
                                            <th></th>

                                            <th>VALUE</th>
                                            <th>KEY</th>
                                            <th></th>

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
                                                    <td ><a class="btn red" href="<?=$url?>product/excludelist_del/<?=$row->varlistid?>">DEL</a>  </td>

                                                    <td > <input  class="form-control" type="text"  value="<?=$row->no?>" name="value" />  </td>

                                                    <td > <input class="form-control" type="text"  value="<?=$row->name?>" name="key" />  <input type="hidden" value="<?=$row->varlistid?>" name="varlistid" /></td>
                                                    <td> <input type="submit" class="btn blue" value="Update"></td>

                                                </form>
                                            </tr>
                                        <? }
                                        ?>
                                        </tbody>
                                    </table>

                        </div>

                        <div class="col-md-12 col-sm-12">

                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cogs"></i>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="javascript:;" class="remove"></a>
                                    </div>
                                </div>
                                <div class="portlet-body flip-scroll">
                                    <!-- BEGIN FORM-->
                                    <form action='<?php echo $adminurl; ?>shipping_add' method="post" class="form-inline" role="form">
                                        <div class="form-group">

                                            <input type="text"  name="kg" class="form-control" placeholder="KG">
                                        </div>
                                        <div class="form-group">
                                            <input type="text"  name="fee" class="form-control" placeholder="Fee">
                                        </div>


                                        <button type="submit" class="btn blue">Add</button>
                                    </form>
                                    <!-- END FORM-->


                            <form action="<?=$url?>welcome/shipping_bath" method="post" class="form-inline" role="form">
                                <input type='hidden' name ='shippingid' value='<?=$shippingid ?>'>

                                <table class="table table-bordered table-striped table-condensed flip-content" id="sample_2">
                                    <thead class="flip-content">

                                    <tr>
                                        <th style="width1:8px;">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                                        </th>
                                        <th>KG</th>
                                        <th>Free</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($shipping->result() as $row): ?>
                                        <tr>
                                            <td><input class="checkboxes" type="checkbox" value="<?=$row->shippingid ?>" name="chk[]"/></td>
                                            <td> <input class="form-control" type="text" value="<?php echo $row->kg; ?>" name="kg<?php echo $row->shippingid; ?>"/>   </td>
                                            <td> <input class="form-control" type="text" value="<?php echo $row->fee; ?>" name="fee<?php echo $row->shippingid; ?>"/>   </td>
                                        </tr>

                                    <?php endforeach; ?>

                                    </tbody>
                                </table>

                                <select name="modtype" class="layout-option form-control input-small">
                                    <option value="0">Select Action</option>
                                    <option value="1">Edit</option>
                                    <option value="2">Delete</option>
                                </select>
                                <input type="submit" class="btn blue" value="Go">
                            </form>

                        </div>

                        </div>
                    </div>

                    </div>


                    <div class="tab-pane" id="tabs-2">
                        <div class="col-md-12 col-sm-12">

                            <h2 >eBay Account </h2>

                            <form id="ebayaccount" method="post" action='<?=$url; ?>order/seller_adds'>
                                <select class="form-control"  name='ebay' onchange="SelectAccount(this.options[this.options.selectedIndex].value);"
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
                                <input class="form-control" type="text" value="" name="username"><br />

                                <label class=""> paypal 帳號： </label>
                                <input class="form-control" type="text" value="" name="paypal"><br />


                                <label > 公司名稱： </label>
                                <input class="form-control" type="text" value="" name="name">
                                <br />
                                <label > 寄送名稱： </label>
                                <input class="form-control" type="text" value="" name="PersonName">
                                <br />
                                <label class=""> 郵遞區號： </label>
                                <input class="form-control" type="text" value="" name="zipcode">
                                <br />
                                <label > 地址： </label>
                                <input class="form-control" type="text" value="" name="addr">
                                <br />

                                <label > 地址： </label>
                                <input class="form-control" type="text" value="" name="addr2">
                                <br />
                                <label > 電話： </label>
                                <input class="form-control" type="text" value="" name="phone">
                                <br />
                                <label> 國家： </label>
                                <input class="form-control" type="text" value="" name="country">
                                <br />
                                <label > 城市： </label>
                                <input class="form-control" type="text" value="" name="city"><br />
                                <label > 貨幣別： </label>
                                <input class="form-control" type="text" value="" name="Currency">
                                <span class="help-block">
                                USD,GBP,AUD</span>
                                <label > 到期時間： </label>
                                <input class="form-control" type="text" value="" name="exptime">



                                <input type="hidden" value="" name="edit">
                                <input type="hidden" value="" name="accounttokenid">

                                <br />
                                <a class="btn red"	href="javascript: delAccount(); return false;">DEL</a>
                                <input type="submit" class="btn blue"	 name="submit"  value="Adds">
                            </form>

                        </div>
                    </div>

                    <div class="tab-pane " id="tabs-3">
                        <div class="col-md-12 col-sm-12">

                            <h2 >PayPal Account </h2>

                            <form id="paypal" method="post" action='<?=$url; ?>order/paypal_adds'>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select  class="form-control"  name='paypalsel'  onchange="SelectAccountpaypal(this.options[this.options.selectedIndex].value);"
                                            <option></option>
                                            <option></option>

                                            <?
                                            foreach($paypalaccount->result() as $row){
                                                ?>
                                                <option value='<?=$row->paypalaccountid?>'><?=$row->paypal?></option>
                                            <?}
                                            //javascript: SelectAccount(<?=$row->accounttokenid?>); return false;
                                            ?>
                                            </select>
                                            <br />
                                            <label class=""> paypal ： </label>
                                            <input class="form-control" type="text" value="" name="paypal"><br />

                                            <label class=""> paypal api帳號： </label>
                                            <input class="form-control" type="text" value="" name="paypalusername"><br />

                                            <label class=""> paypal api密碼： </label>
                                            <input class="form-control" type="text" value="" name="paypalpassword"><br />

                                            <label class=""> paypal api signature： </label>
                                            <input class="form-control" type="text" value="" name="signature"><br />

                                            <input type="hidden" value="" name="edit">
                                            <input type="hidden" value="" name="paypalaccountid">
                                            <a class="btn red"	href="javascript: delAccountpaypal(); return false;">DEL</a>
                                            <input type="submit" class="btn blue" name="submit"  value="Adds">
                                        </div>
                                      </div>
                                  </div>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>


                    <div class="tab-pane " id="portlet_tab_4">
                        <div class="col-md-12 col-sm-12">
                            <h2 >eBay Ship Service </h2>
                            <form action="<?= $adminurl ?>ebayship_adds" method="post">
                                <input class="form-control"   value="" name="name" type="text" />
                                <input type="submit" class="btn blue" value="Add" />
                            </form>
                            <br />
                            <?
                            $sql="select * from varlist where type=7";
                            $courier=$this->db->query($sql);

                            foreach($courier ->result() as $row){
                                ?>
                                <form action="<?= $adminurl ?>ebayship_update" method="post">
                                    <input class="form-control"   value="<?=$row->name?>" name="name" type="text" />
                                    <input class="form-control"   value="<?=$row->varlistid?>" name="id" type="hidden" />

                                    <input type="submit" class="btn blue" value="Update" />
                                    <a href="<?= $adminurl ?>ebayship_del/<?=$row->varlistid?>" class="btn red">DEL</a>
                                </form>
                                <br />
                            <?}?>
                        </div>
                    </div>

                    <div class="tab-pane " id="tabs-5">
                        <div class="col-md-12 col-sm-12">
                            <h2 >Air Mail Print Setting </h2>
                            <form id="paypal" method="post" action='<?=$url; ?>welcome/print_edit'>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                            <label class=""> SIZE Width ： </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->width?>" name="width"><br />
</div>
                                            <div class="col-md-6">
                                            <label class="">  Height： </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->height?>" name="height"><br />
</div>

                                            <div class="col-md-6">

                                            <label class=""> 第一段：左 </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->firstleft?>" name="firstleft"><br />
</div>
                                            <div class="col-md-6">
                                            <label class=""> 上： </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->firsttop?>" name="firsttop"><br />
</div>
                                            <div class="col-md-6">

                                            <label class=""> 第二段：左 </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->secleft?>" name="secleft"><br />
</div>
                                            <div class="col-md-6">

                                            <label class=""> 上： </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->sectop?>" name="sectop"><br />
</div>
                                            <div class="col-md-6">

                                            <label class=""> 第三段：左 </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->thirdleft?>" name="thirdleft"><br />
</div>
                                            <div class="col-md-6">
                                            <label class=""> 上： </label>
                                            <input class="form-control" type="text" value="<?=$webprpfile->thirdtop?>" name="thirdtop"><br />
</div>


                                            <input type="submit" class="btn blue" name="submit"  value="Edit">

                                        </div>
                                    </div>
                                </div>

                            </form>
                            <div class="clear"></div>

                        </div>
                    </div>


                    <div class="tab-pane " id="tabs-6">
                        <div class="col-md-12 col-sm-12">

                            <h2 >Print Setting </h2>

                            <form id="print" method="post" action='<?=$url; ?>welcome/printsetting_update'>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select  class="form-control"  name='printsettingid'  onchange="SelectPrint(this.options[this.options.selectedIndex].value);"
                                            <option></option>
                                            <option></option>

                                            <?
                                            $sql = "select *  from printsetting ";
                                            $queryarr = $this->db->query($sql);
                                            foreach($queryarr->result() as $row){
                                                ?>
                                                <option value='<?=$row->printsettingid?>'><?=$row->name?></option>
                                            <?}
                                            //javascript: SelectAccount(<?=$row->accounttokenid?>); return false;
                                            ?>
                                            </select>

                                        <div class="col-md-12">
                                            <label class=""> Name ： </label>
                                            <input class="form-control" type="text" value="" name="name"><br />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="">  Width ： </label>
                                            <input class="form-control" type="text" value="" name="width"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="">  Height： </label>
                                            <input class="form-control" type="text" value="" name="height"><br />
                                        </div>

                                            <div class="col-md-6">

                                                <label class=""> 寄件者：上 </label>
                                                <input class="form-control" type="text" value="" name="sendtop"><br />
                                            </div>

                                        <div class="col-md-6">
                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text" value="" name="sendleft"><br />
                                        </div>



                                        <div class="col-md-6">

                                            <label class=""> 收件者：上 </label>
                                            <input class="form-control" type="text" value="" name="rectop"><br />
                                        </div>
                                        <div class="col-md-6">

                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text" value="" name="recleft"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class=""> 訂單號碼：上 </label>
                                            <input class="form-control" type="text" value="" name="orderidtop"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text" value="" name="orderidleft"><br />
                                        </div>


                                            <div class="col-md-6">
                                                <label class=""> 寄件日期年：上 </label>
                                                <input class="form-control" type="text" value="" name="sendyeartop"><br />
                                            </div>
                                        <div class="col-md-6">
                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text" value="" name="sendyearleft"><br />
                                        </div>


                                        <div class="col-md-6">
                                            <label class=""> 寄件日期月：上 </label>
                                            <input class="form-control" type="text" value="" name="sendmonthtop"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text" value="" name="sendmonthleft"><br />
                                        </div>

                                        <div class="col-md-6">
                                            <label class=""> 寄件日期日：上 </label>
                                            <input class="form-control" type="text" value="" name="senddaytop"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text" value="" name="senddayleft"><br />
                                        </div>

                                        <div class="col-md-6">
                                            <label class=""> 物品描述：上 </label>
                                            <input class="form-control" type="text" value="" name="desctop"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class=""> 左： </label>
                                            <input class="form-control" type="text"  name="descleft"><br />
                                        </div>

                                            <div class="col-md-6">
                                                <label class=""> 直橫P=portrait, L=landscape： </label>
                                                <input class="form-control" type="text"  name="ORIENTATION"><br />
                                            </div>


                                            <div class="col-md-6">
                                                <label class="">  Font Size： </label>
                                                <input class="form-control" type="text" value="" name="size"><br />
                                            </div>

                                            <input type="hidden" value="" name="edit">
                                            <input type="hidden" value="" name="printid">
                                            <a class="btn red"	href="javascript: delPrint(); return false;">DEL</a>
                                            <input type="submit" class="btn blue" name="submit"  value="Adds">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>


                    <div class="tab-pane " id="tabs-7">
                        <div class="col-md-12 col-sm-12">


                            <!-- BEGIN FORM-->
                            <form action="<?=base_url()?>index.php/account/accounttype_adds" method="post" class="form-horizontal">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">會計科目</label>
                                        <div class="col-md-4">

                                            <input type="text"  name="name" class="form-control" placeholder="請輸入名稱">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">編號</label>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" size="10" name="no" placeholder="編號">
                                            <button type="submit" class="btn blue">新增</button>
                                        </div>

                                    </div>


                                </div>
                            </form>


                            <table class="table table-striped table-bordered table-hover" id="sample_2">
                                <thead>
                                <tr>
                                    <th>操作</th>
                                    <th>科目</th>
                                    <th>編號</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($queryaccounting->result() as $row) {
                                    $i++;
                                    $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                                    ?>
                                    <tr class="<?= $bgColor; ?>">
                                        <form action="<?=base_url() ?>index.php/account/accounttype_update" method="post">
                                            <input type="hidden" name="type" value="4">
                                            <input type="hidden" name="id" value="<?=$row->accounttypeid?>">

                                            <td class="nTitle"><a  class="btn red"   onClick="return check();" href="<?=base_url() ?>index.php/account/accounttype_del/<?= $row->accounttypeid ?>">刪除</a>
                                                <input type="submit" class="btn blue" value="更新">
                                            </td>
                                            <td class="nTitle">
                                                <input type="text" class="form-control" name="name" value="<?= $row->name ?>">
                                            </td>
                                            <td class="nCategory">

                                                <input type="text" class="form-control" name="no" value="<?=$row->no?> "> </td>
                                        </form>
                                    </tr>
                                <? }
                                ?>
                                </tbody>
                            </table>

                        </div>

                    </div>

                    <div class="tab-pane " id="tabs-8">


                        <!-- END PAGE HEADER-->
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>新增使用者
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="<?=$url?>welcome/member_add" method="post" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Username</label>
                                            <div class="col-md-4">
                                                <input type="text"  name="name" class="form-control" placeholder="請輸入帳號">
                                                <button type="submit" class="btn blue">新增</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>

                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i>使用者清單
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body flip-scroll">
                                <table class="table table-bordered table-striped table-condensed flip-content">
                                    <thead class="flip-content">
                                    <tr>
                                        <th>操作</th>
                                        <th>帳號</th>
                                        <th>權限</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($querymember->result() as $row) {
                                        $i++;
                                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                                        ?>
                                        <tr class="<?= $bgColor; ?>">
                                            <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "member_del" ?>/<?= $row->memberid ?>">刪除</a></td>
                                            <td class="nTitle"><a href="<?= $adminurl . "member_edit" ?>/<?= $row->memberid ?>"><?= $row->username ?></a></td>
                                            <td class="nCategory"><?
                                                $auth= $row->authority;
                                                $arr=$this->all_model->getAuth();
                                                foreach($arr as $name =>$val ){
                                                    if(($val & $auth) == $val){
                                                        ?>
                                                        <input  type="checkbox" checked name="auth[]" Value="<?=$val?>" />
                                                        <?=$name?>
                                                    <?php
                                                    }}
                                                ?>
                                            </td>
                                        </tr>
                                    <? }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->


                       </div>


                </div>

            </div>
        </div>
    </div>


