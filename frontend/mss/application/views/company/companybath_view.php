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


<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>廠商列表
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body flip-scroll">


            <form action="<?=$url?>company/company_updatebath" method="post">
            <input type='hidden' name ='companyid' value='<?=$companyid ?>'>

                <table class="table table-striped table-bordered table-hover" id="sample_2">

                <thead >
                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                        </th>
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
                        <td><input class="checkboxes" type="checkbox" value="<?=$row->companyid ?>" name="chk[]"/></td>
                         <td class="nCategory"> <input class="form-control"    type="text" value="<?=$row->companyno?>"  name="companyno<?=$row->companyid ?>">  </td>
                         <td class="nTitle"><a href="<?= $adminurl . "company_edit" ?>/<?= $row->companyid ?>"><?= $row->companyname ?></a></td>
                         <td class="nCategory"> <input class="form-control"    type="text" value="<?=$row->contactname?>"  name="contactname<?=$row->companyid ?>">  </td>
                         <td class="nCategory"> <input class="form-control"    type="text" value="<?=$row->tel?>"  name="tel<?=$row->companyid ?>"> </td>
                         <td class="nCategory"> <input  class="form-control"  type="text" value="<?=$row->mobile?>"  name="mobile<?=$row->companyid ?>">  </td>
						 <td class="nCategory"> <input class="form-control"    type="text" value="<?=$row->website?>"  name="website<?=$row->companyid ?>"> </td>	
						 <td class="nCategory"> <input class="form-control"    type="text" value="<?=$row->bankid?>"  name="bankid<?=$row->companyid ?>"> </td>		
						  <td class="nCategory"> <input class="form-control"    type="text" value="<?=$row->addr?>"  name="addr<?=$row->companyid ?>"> </td>		

                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
              <br /> 
         <input type="submit" class="btn green" value="UPDATE">
            </form>
    </div>
</div>
<!-- END SAMPLE TABLE PORTLET-->

