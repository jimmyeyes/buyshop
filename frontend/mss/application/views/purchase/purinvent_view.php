<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">
    <div class="box themed_box">
        <h2 class="box-header">待入庫 </h2>
        <div class="box-content">
           <form action="<?=$url?>purchase/orderbathupdate" method="post">
       	    <input type='hidden' name ='purchaseid' value='<?=$purchaseid ?>'>
       	      <input type='hidden' name ='type' value='3'>
        	
            
            <label >  日期： </label>
			<input class="form-field datepicker"    type="text"  name="pdate">
			
			 <label >  發票號碼： </label>
			<input class="form-field "    type="text"  name="no">
			
			 <label >  單價： </label>
			<input class="form-field "    type="text"  name="price">

			<label >已付款/未付款</label>

			 <select id="select"  name='paytype'>
				<option value='0'>待付</option> 
           		 <option value='1'>結清 </option>
              </select>


             <label > 交易條件 </label>
         	 <select id="select"  name='alpay'>
				<option value='0'>現金</option> 
           		 <option value='1'>支票 </option>
              </select>
           
        	
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>選擇</th>
                    	<th>操作</th>
                        <th>日期</th>
                        <th>廠商</th>
     					<th>品名</th>
                        <th>型號</th>
                        <th>數量</th>
                         <th>sku</th>
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
                        	<td><input type="checkbox" value="1" name="chk<?=$row->purchaseid ?>"/></td>
                        	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "purchase_del" ?>/<?= $row->purchaseid ?>/<?= $type ?>">刪除</a></td>
                            <td class="nTitle"><a href="<?= $adminurl . "purinvent_detail" ?>/<?= $row->purchaseid ?>"><?= $row->pdate ?></a></td>
                             <td class="nCategory"><?=$row->companyname?>  </td>
                            <td class="nCategory"><?=$row->prodname?>  </td>
                           <td class="nCategory"><?=$row->model?>  </td>
							<td class="nCategory"><?=$row->amount?>  </td>	
							<td class="nCategory"><?=$row->sku?>  </td>		
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
               <input type="submit" value="入庫" >
            </form>
            <div class="clear"></div>
        </div>
    </div>

</div>
