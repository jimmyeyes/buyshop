<?= $menu ?>
<script>
function check_all(obj,cName) 
{
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>
<div id="subnavbar">
</div>
<div id="content">
    <div class="box themed_box">
        <h2 class="box-header">廠商列表 </h2>
        <div class="box-content">
        	
        	  <form action="<?=$url?>company/company_updatebath" method="post">
            <input type='hidden' name ='companyid' value='<?=$companyid ?>'>
            <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選/全不選</p> 
          
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th></th>
                    	 <th>公司代號</th>
                        <th>公司名稱</th>
     					<th>聯絡人</th>
     					<th>電話</th>
                        <th>手機</th>
                        <th>網站</th>
                        <th>銀行帳號</th>
                         <th>地址</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $i++;
                        $bgColor = ($i % 2 == 0) ? 'bgColor' : '';
                        ?>
                        <tr class="<?= $bgColor; ?>">
                        <td><input type="checkbox" value="<?=$row->companyid ?>" name="chk[]"/></td>
                         <td class="nCategory"> <input class="form-field px50"     type="text" value="<?=$row->companyno?>"  name="companyno<?=$row->companyid ?>">  </td>
                         <td class="nTitle"><a href="<?= $adminurl . "company_edit" ?>/<?= $row->companyid ?>"><?= $row->companyname ?></a></td>
                         <td class="nCategory"> <input class="form-field "    type="text" value="<?=$row->contactname?>"  name="contactname<?=$row->companyid ?>">  </td>
                         <td class="nCategory"> <input class="form-field "    type="text" value="<?=$row->tel?>"  name="tel<?=$row->companyid ?>"> </td>
                         <td class="nCategory"> <input  class="form-field px100"  type="text" value="<?=$row->mobile?>"  name="mobile<?=$row->companyid ?>">  </td>
						 <td class="nCategory"> <input class="form-field px240"    type="text" value="<?=$row->website?>"  name="website<?=$row->companyid ?>"> </td>	
						 <td class="nCategory"> <input class="form-field px240"    type="text" value="<?=$row->bankid?>"  name="bankid<?=$row->companyid ?>"> </td>		
						  <td class="nCategory"> <input class="form-field px240"    type="text" value="<?=$row->addr?>"  name="addr<?=$row->companyid ?>"> </td>		

                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
              <br /> 
         <input type="submit" class="button themed" value="UPDATE"> 
            </form>
            <div class="clear"></div>
        </div>
    </div>
</div>
