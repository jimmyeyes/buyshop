<?= $menu ?>
<div id="subnavbar">
</div>
<div id="content">
    <div class="box themed_box">
        <h2 class="box-header">商品列表 </h2>
        <div class="box-content">
            <table class="display" id="tabledata">
                <thead>
                    <tr>
                    	<th>操作</th>
                    	<th>類別名稱</th>
                    	<th>品牌</th>
                        <th>品名</th>
     					<th>型號</th>
                        <th>SKU</th>
                         <th>EAN</th>
                          <th>UPC</th>
                            <th>MPN</th>
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
                        	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "product_del" ?>/<?= $row->productid ?>">刪除</a></td>
                        	 <td class="nCategory"><?=$row->category?>  </td>
                        	   <td class="nCategory"><?=$row->brand?>  </td>
                            <td class="nTitle"><a href="<?= $adminurl . "product_edit" ?>/<?= $row->productid ?>"><?= $row->prodname ?></a></td>
                            <td class="nCategory"><?=$row->model?>  </td>
                          <td class="nCategory"><?=$row->sku?>  </td>
                               <td class="nCategory"><?=$row->ean?>  </td>
                             <td class="nCategory"><?=$row->upc?>  </td>
                               <td class="nCategory"><?=$row->mpn?>  </td>
                           
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
    
  
    
    

</div>
