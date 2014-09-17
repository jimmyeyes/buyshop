
<script>
function check()
{
if (!confirm("確認刪除!"))
return false;
}
</script>

<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Category
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="first">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Category</a>
            </li>


        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i>Category
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body">
        <!-- BEGIN FORM-->
        <form action='<?php echo $adminurl; ?>category_add' method="post" class="form-inline" role="form">
                <div class="form-group">

                        <input type="text"  name="categoryno" class="form-control" placeholder="類別代號">
                </div>
                <div class="form-group">
                    <input type="text"  name="category" class="form-control" placeholder="類別名稱">
                </div>


                <button type="submit" class="btn blue">Add</button>
        </form>
        <!-- END FORM-->
    </div>
</div>



<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body flip-scroll">

        <form action="<?=$url?>product/category_bath" method="post" class="form-inline" role="form">
            <input type='hidden' name ='categoryid' value='<?=$categoryid ?>'>

            <table class="table table-bordered table-striped table-condensed flip-content" id="sample_2">
                <thead class="flip-content">

                <tr>
                    <th style="width1:8px;">
                        <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                    </th>
                    <th>NO</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($query->result() as $row): ?>
                    <tr>
                        <td><input class="checkboxes" type="checkbox" value="<?=$row->categoryid ?>" name="chk[]"/></td>
                        <td> <input class="form-control" type="text" value="<?php echo $row->categoryno; ?>" name="no<?php echo $row->categoryid; ?>"/>   </td>
                        <td> <input class="form-control" type="text" value="<?php echo $row->category; ?>" name="category<?php echo $row->categoryid; ?>"/>   </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

        <select name="modtype" class="layout-option form-control input-small">
            <option value="0">Select Action</option>
            <option value="1">Edit</option>
            <option value="2">Delete</option>
        </select>
        <input type="submit" class="btn blue" value="Go">
       </form>
    </div>
</div>
<!-- END SAMPLE TABLE PORTLET-->




