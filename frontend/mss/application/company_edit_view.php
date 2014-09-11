<?= $menu ?>

<div id="subnavbar"></div>
<div id="content">
	<div class="box themed_box">
		<h2 class="box-header">編輯廠商</h2>
		<div class="box-content">
			<form action="<?php echo $adminurl; ?>company_edit_update" method="post">
				<label > 公司代號： </label>
				<input class="form-field 20px" type="text" value="<?php echo $row -> companyno; ?>"  name="companyno">
				
				<label class=""> 公司名稱： </label>
				<input class="form-field 20px" type="text" value="<?php echo $row -> companyname; ?>"  name="companyname">
				
				<label class=""> 地址： </label>
				<input class="form-field small" type="text" value="<?php echo $row -> addr; ?>"  name="addr">
				<br>
				<label > 聯絡人： </label>
				<input class="form-field 20px" type="text"  value="<?php echo $row -> contactname; ?>"  name="contactname">
			
				
				<label class="">  電話： </label>
				<input class="form-field 20px" type="text"  value="<?php echo $row -> tel; ?>" name="tel">
				
				<label class="">  手機： </label>
				<input class="form-field 20px" type="text" value="<?php echo $row -> mobile; ?>" name="mobile">

				<label class="">  傳真： </label>
				<input class="form-field 20px" type="text" value="<?php echo $row -> fax; ?>" name="fax">
				
				<label>  網站： </label>
				<input class="form-field 20px" type="text" value="<?php echo $row -> website; ?>" name="website">
				
					<label class="">  email： </label>
				<input class="form-field 20px" type="text" value="<?php echo $row -> email; ?>" name="email">
				
				
				<label class="">  銀行帳號： </label>
				<input class="form-field small" type="text" value="<?php echo $row -> bankid; ?>" name="bankid">
				

			<br />
			<input type="hidden" value="<?php echo $id; ?>" name='id'>
			<input type="submit" class="button white" value="Update" />
			</form>
			<div class="clear"></div>
		</div>
	</div>
	<div class="box themed_box">
		<h2 class="box-header">商品列表 </h2>
		<div class="box-content">
			<table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>類別名稱</th>
                    	<th>品牌</th>
                        <th>品名</th>
     					<th>型號</th>
     					<th>SKU</th>
     					 <th>EAN</th>
                          <th>UPC</th>
                            <th>MPN</th>
     					<th>單價</th>
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
                         <td class="nCategory"><?=$row->category?>  </td>
                            <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nTitle"><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>
                            <td class="nCategory"><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?=$row->model?> </a> </td>
                             <td class="nCategory"><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?=$row->sku?> </a> </td>
                               <td class="nCategory"><?=$row->ean?>  </td>
                             <td class="nCategory"><?=$row->upc?>  </td>
                               <td class="nCategory"><?=$row->mpn?>  </td>
                         <td class="nCategory"><?php
                         
                         if (($authority & 256) == 256) {
                         
                        	 echo $row->price ;
                         
						 }
                         ?>  </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
			<div class="clear"></div>
		</div>
	</div>
</div>
