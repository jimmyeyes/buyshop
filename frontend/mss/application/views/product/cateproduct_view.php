<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            商品列表
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">商品列表</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
        <h2 class="box-header">商品列表 </h2>
<table class="table table-striped table-bordered table-hover" id="sample_2">
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
        </div>
    </div>
    

