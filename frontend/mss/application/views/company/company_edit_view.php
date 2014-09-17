<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            廠商資料
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">廠商資料</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>新增廠商
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
		<h2 class="box-header">編輯廠商</h2>

			<form action="<?php echo $adminurl; ?>company_edit_update" method="post">
				<label > 公司代號： </label>
				<input class="form-control" type="text" value="<?php echo $row -> companyno; ?>"  name="companyno">
				
				<label class=""> 公司名稱： </label>
				<input class="form-control" type="text" value="<?php echo $row -> companyname; ?>"  name="companyname">
				
				<label class=""> 地址： </label>
				<input class="form-control" type="text" value="<?php echo $row -> addr; ?>"  name="addr">
				<br>
				<label > 聯絡人： </label>
				<input class="form-control" type="text"  value="<?php echo $row -> contactname; ?>"  name="contactname">
			
				
				<label class="">  電話： </label>
				<input class="form-control" type="text"  value="<?php echo $row -> tel; ?>" name="tel">
				
				<label class="">  手機： </label>
				<input class="form-control" type="text" value="<?php echo $row -> mobile; ?>" name="mobile">

				<label class="">  傳真： </label>
				<input class="form-control" type="text" value="<?php echo $row -> fax; ?>" name="fax">
				
				<label>  網站： </label>
				<input class="form-control" type="text" value="<?php echo $row -> website; ?>" name="website">
				
					<label class="">  email： </label>
				<input class="form-control" type="text" value="<?php echo $row -> email; ?>" name="email">
				
				
				<label class="">  銀行帳號： </label>
				<input class="form-control" type="text" value="<?php echo $row -> bankid; ?>" name="bankid">
				

			<br />
			<input type="hidden" value="<?php echo $id; ?>" name='id'>
			<input type="submit" class="btn blue" value="Update" />
			</form>


		</div>
	</div>

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>新增廠商
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">

		<h2 class="box-header">商品列表 </h2>

        <table class="table table-striped table-bordered table-hover" id="sample_2">
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

	</div>
</div>
