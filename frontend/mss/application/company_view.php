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
        <h2 class="box-header"> 新增廠商</h2>
        <div class="box-content">
            <?php echo form_open_multipart('company/company_adds'); ?>
           <input class="form-field " type="text"  name="name">
            <input type="submit" class="button white" value="ADD">
            </form>
        </div>
        </div>

    <div class="box themed_box">
        <h2 class="box-header">廠商列表 </h2>
        <div class="box-content">
        	
        	  <form action="<?=$url?>company/company_bath" method="post">
            <input type='hidden' name ='companyid' value='<?=$companyid ?>'>
            <p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選
         <select name="modtype">
         
          <option value="1">編輯</option>
             <option value="2">刪除</option>
          </select>
          </p> 
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th></th>
                    	<!--<th>操作</th> -->
                        <th>公司代號</th>
                        <th>公司名稱</th>
     					<th>聯絡人</th>
     					<th>手機</th>
                        <th>電話</th>
                      
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
                     <!--    <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "company_del" ?>/<?= $row->companyid ?>">刪除</a></td> -->
                         <td class="nCategory"><?=$row->companyno?>  </td>
                         <td class="nTitle"><a href="<?= $adminurl . "company_edit" ?>/<?= $row->companyid ?>"><?= $row->companyname ?></a></td>
                         <td class="nCategory"> <?=$row->contactname?></td>
                         <td class="nCategory"> <?=$row->tel?> </td>
                         <td class="nCategory"> <?=$row->mobile?> </td>
						 <td class="nCategory"><?=$row->bankid?> </td>		
						  <td class="nCategory"><?=$row->addr?> </td>		
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            
              <br />   <br />
           <input type="submit" class="button themed" value="Submit"> 
            </form>
            <div class="clear"></div>
        </div>
    </div>

</div>
