

<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            編輯帳號
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
                <a href="#">編輯帳號</a>
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
            <i class="fa fa-reorder"></i>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
			<form class="horizontal-form" action="<?php echo $adminurl; ?>member_edit_update" method="post">

                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input class="form-control" type="text" value="<?php echo $row -> name; ?>"  name="name">
                            </div>


                            <div class="form-group">
                                <label class="control-label"> Username： </label>
                                <?php echo $row -> username; ?>

                            </div>

                            <div class="form-group">

                                <label class="control-label"> Password： </label>
                                <input  type="password" class="form-control"  name="password">
                                <label class="control-label"> Confirm Password： </label>
                                <input  type="password" class="form-control"  name="chkpassword">

                            </div>
                            <div class="form-group">
                                <label class="control-label"> 權限: </label>
                                <div class="checkbox-list" data-error-container="#disablenote_error">
                                <?php
                                $auth=$row -> authority;
                                 $arr=$this->all_model->getAuth();
                                foreach($arr as $name =>$val ){
                                if(($val & $auth) == $val){
                                ?>
                                    <label  class="checkbox-inline">
                                        <input  type="checkbox" checked name="auth[]" Value="<?=$val?>" />
                                    <?=$name?></label>
                                </tr>
                                <?
                                }
                                else{
                                ?>
                                    <label name="disable" id='disable' class="checkbox-inline">
                                    <input  type="checkbox"  name="auth[]" Value="<?=$val?>" />
                                    <?=$name?></label>
                                </tr>
                                <?
                                }
                                }
                                ?>

                                </div>
                            </div>

                            <input type="hidden" value="<?php echo $id; ?>" name='id'>
                            <div class="form-actions right">
			                    <input type="submit" class="btn blue" value="Update" />
                            </div>
                 </div>
                 </div>
              </div>

			</form>
        </div>
    </div>
