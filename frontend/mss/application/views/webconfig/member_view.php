<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            使用者管理
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">系統設置</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">使用者管理</a>
            </li>
            <li class="pull-right">
                <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                    <i class="fa fa-calendar"></i>
								<span>
								</span>
                    <i class="fa fa-angle-down"></i>
                </div>
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>新增使用者
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="<?=$url?>welcome/member_add" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Username</label>
                    <div class="col-md-4">
                        <input type="text"  name="name" class="form-control" placeholder="請輸入帳號">
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
            <i class="fa fa-cogs"></i>使用者清單
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
            <tr>
                    	<th>操作</th>
                        <th>帳號</th>
                        <th>權限</th>
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
                        	 <td class="nTitle"><a onClick="return check();" href="<?= $adminurl . "member_del" ?>/<?= $row->memberid ?>">刪除</a></td>
                            <td class="nTitle"><a href="<?= $adminurl . "member_edit" ?>/<?= $row->memberid ?>"><?= $row->username ?></a></td>
                            <td class="nCategory"><?
                            $auth= $row->authority;	
                           $arr=$this->all_model->getAuth();
                            foreach($arr as $name =>$val ){
                            if(($val & $auth) == $val){
                            ?>
                                <input  type="checkbox" checked name="auth[]" Value="<?=$val?>" />
                                <?=$name?>
                            <?php
                            }}
                            ?>
                            </td>
                        </tr>
                        <? }
                    ?>
                </tbody>
            </table>
    </div>
</div>
<!-- END SAMPLE TABLE PORTLET-->
