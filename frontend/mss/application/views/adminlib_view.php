<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Merchant Soultion System</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="MSS" name="description"/>
    <meta content="jwliu.com" name="author"/>
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/select2/select2_metro.css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->

    <!-- file-->
    <link href="/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet"/>
    <link href="/assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    <!-- end file _-->
    <!-- BEGIN THEME STYLES -->
    <link href="/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/pages/tasks.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-timepicker/compiled/timepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
    <!-- END THEME STYLES -->


    <link rel="shortcut icon" href="favicon.ico"/>

    <script>
        function check()
        {
            if (!confirm("確認刪除!"))
                return false;
        }

        function check_all(obj,cName)
        {


            var checkboxs = document.getElementsByName(cName);
             //alert(checkboxs.length);
            for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
        }


    </script>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">


<?php

if ($this->session->userdata('username') == false) {
    redirect('/welcome/login', 'refresh');
}else{

}
?>

<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="/">
            <img src="/assets/img/logo.png" alt="logo" class="img-responsive"/>
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="/assets/img/menu-toggler.png" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
        <!-- BEGIN USER LOGIN DROPDOWN -->
        <li class="dropdown user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <img alt="" src="/assets/img/avatar.png"/>
				<span class="username">
					<?=$this->session->userdata("username")?>
				</span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu">



                <li class="divider">
                </li>
                <li>
                    <a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> Full Screen</a>
                </li>

                <li>
                    <a href="<?=$url?>welcome/logout"><i class="fa fa-key"></i> Log Out</a>
                </li>
            </ul>
        </li>
        <!-- END USER LOGIN DROPDOWN -->
         </ul>

    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>


            <?= $menu ?>


           </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">


        <?php echo $main ?>


        <div class="clearfix">
        </div>

    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        2014 &copy; MSS
    </div>
    <div class="footer-tools">
		<span class="go-top">
			<i class="fa fa-angle-up"></i>
		</span>
    </div>
</div>
<!-- END FOOTER -->

<?
if (@$noscript=="1") {
}else{
?>




    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="/assets/plugins/respond.min.js"></script>
    <script src="/assets/plugins/excanvas.min.js"></script>
    <![endif]-->
    <script src="/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!--    <script src="/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>-->
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="/assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="/assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
    <script src="/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="/assets/plugins/data-tables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="/assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/clockface/js/clockface.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>
    <script src="/assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->



    <!-- BEGIN:File Upload Plugin JS files-->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="/assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="/assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="/assets/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="/assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="/assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
    <!-- END:File Upload Plugin JS files-->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/scripts/app.js" type="text/javascript"></script>
<script src="/assets/scripts/index.js" type="text/javascript"></script>
<script src="/assets/scripts/table-managed.js"></script>
<script type="text/javascript" src="/js/jquery.selectboxes.js"></script>
<script type="text/javascript" src="/js/jquery.selectboxes.pack.js"></script>
<script type="text/javascript" src="/js/pace.min.js"></script>

<script src="/assets/scripts/form-components.js"></script>
<script src="/assets/scripts/form-validation.js"></script>
<script src="/assets/scripts/table-advanced.js"></script>
    <!-- upload file -->
<script src="/assets/scripts/form-fileupload.js"></script>
    <!-- END upload file -->

<!-- END PAGE LEVEL SCRIPTS -->


    <script>
    jQuery(document).ready(function() {
        App.init(); // initlayout and core plugins
        Index.init();
        TableManaged.init();
        FormComponents.init();
        FormValidation.init();
        FormFileUpload.init();


    });
</script>

<?}?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?
$ip = $_SERVER["REMOTE_ADDR"]; //取得頁面ip
$nowdate = strtotime("now"); //現在時間
$viewinfo = $_SERVER["HTTP_USER_AGENT"];
$viewpath = $_SERVER["REQUEST_URI"];
$viewstate = $_SERVER["REQUEST_METHOD"];
$viewhttp = $_SERVER["SERVER_PROTOCOL"];
$viewquerystring = $_SERVER["QUERY_STRING"];
$viewhost = $_SERVER["HTTP_HOST"];
$ref = @$_SERVER['HTTP_REFERER'];
// echo $ref;

$sql = "insert into log (ip,viewinfo,viewdate,viewpath,viewstate,viewhttp,viewquerystring,viewref,viewhost) value('$ip','$viewinfo',NOW(),'$viewpath','$viewstate','$viewhttp','$viewquerystring','$ref','$viewhost')";
//echo $sql;
$this->db->query($sql);


?>
