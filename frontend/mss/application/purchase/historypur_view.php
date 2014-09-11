<?= $menu ?>
<div id="subnavbar">
</div>
<script>
function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>
<div id="content">
    <div class="box themed_box">
        <h2 class="box-header">歷史訂單 </h2>
        <div class="box-content">
        	  <form action="<?=$url?>purchase/orderbathupdate" method="post">
            <input type='hidden' name ='purchaseid' value='<?=$purchaseid ?>'>
       	      <input type='hidden' name ='type' value='4'>
        	
            <label >  日期： </label>
			<input class="form-field datepicker"    type="text"  name="pdate">
			
			 <label >  發票號碼： </label>
			<input class="form-field "    type="text"  name="no">
			
			 <label >  單價： </label>
			<input class="form-field "    type="text"  name="price">

			<label >付款狀態</label>
			 <select id="select"  name='paytype'>
				<option value='0'>待付</option> 
           		 <option value='1'>結清 </option>
              </select>

             <label > 交易條件 </label>
         	 <select id="select"  name='alpay'>
				<option value='0'>現金</option> 
           		 <option value='1'>支票 </option>
              </select>
           
        	<p><input type="checkbox" name="allbox" onclick="check_all(this,'chk[]')" />全選</p> 
            <table class="display" id="tabledata4">
                <thead>
                    <tr>
                   	<th>選擇</th>
                      <th>操作</th>
                        <th>日期</th>
                        <th>公司名稱</th>
                         <th>類別名稱</th>
                         <th>品牌</th>
     					<th>品名</th>
                        <th>型號</th>
                         <th>SKU</th>
                          <th>數量</th>
                         <th>發票號碼</th>
                           <th>單價</th>
                            <th>付款狀態</th>
                           <th>交易條件</th>
                           
                        
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
                        	<td><input type="checkbox" value="<?=$row->purchaseid ?>" name="chk[]"/></td>
                          
                           <td class="nTitle"><a onClick="return check();"  href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                        	 <td class="nTitle"><?= $row->pdate ?></td>
                             <td class="nCategory"><?=$row->companyname?>  </td>
                               <td class="nCategory"><?=$row->category?>  </td>
                               <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nCategory"><?=$row->prodname?>  </td>
                           <td class="nCategory"><?=$row->model?>  </td>
                           	<td class="nCategory"><?=$row->sku?>  </td>	
                           	<td class="nCategory"><?=$row->amount?>  </td>		
							<td class="nCategory"><?=$row->no?>  </td>	
							<td class="nCategory"><?=$row->price?>  </td>	
						<td class="nCategory"><?=$this->all_model->getPayType($row->paytype)?>  </td>	
						<td class="nCategory"><?=$this->all_model->getAlPay($row->alpay)?>  </td>	
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
             
            <input type="submit" value="更新" >
            </form>
            <div class="clear"></div>
        </div>
    </div>

</div>
