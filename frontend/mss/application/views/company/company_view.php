<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Supplier
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Supplier</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>add Supplier
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="<?=$adminurl?>company_adds" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">名稱</label>
                    <div class="col-md-4">
                        <input type="text"  name="name" class="form-control" placeholder="請輸入名稱">
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
                              <i class="fa fa-cogs"></i>廠商列表
                          </div>
                          <div class="tools">
                              <a href="javascript:;" class="collapse"></a>
                              <a href="javascript:;" class="remove"></a>
                          </div>
                      </div>
                      <div class="portlet-body flip-scroll">


                          <form action="<?=$url?>company/company_bath" method="post">
                              <input type='hidden' name ='companyid' value='<?=$companyid ?>'>
                                  <select class="form-control input-medium select2me" name="modtype">

                                      <option value="1">編輯</option>
                                      <option value="2">刪除</option>
                                  </select>
                              </p>


                  <table class="table table-striped table-bordered table-hover" id="sample_2">
                  <thead >

                    <tr>
                        <th style="width1:8px;">
                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                        </th>
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

                                    ?>
                                    <tr >
                                    <td><input class="checkboxes" type="checkbox" value="<?=$row->companyid ?>" name="chk[]"/></td>
                                 <!--    <td ><a onClick="return check();" href="<?= $adminurl . "company_del" ?>/<?= $row->companyid ?>">刪除</a></td> -->
                                     <td><?=$row->companyno?>  </td>
                                     <td ><a href="<?= $adminurl . "company_edit" ?>/<?= $row->companyid ?>"><?= $row->companyname ?></a></td>
                                     <td> <?=$row->contactname?></td>
                                     <td> <?=$row->tel?> </td>
                                     <td> <?=$row->mobile?> </td>
                                     <td><?=$row->bankid?> </td>
                                      <td><?=$row->addr?> </td>
                                    </tr>
                                    <? }
                                ?>
                            </tbody>
                        </table>

                       <input type="submit" class="btn green" value="Submit">
                        </form>
                      </div>
                  </div>
            <!-- END SAMPLE TABLE PORTLET-->

