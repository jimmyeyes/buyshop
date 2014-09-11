<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Merchant Soultion System </title>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/jquery/jquery.ui.all.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/table_data.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/lightbox/style.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/style.css" title="style_blue" media="screen"/>

         <!--[if IE]><script type="<?php echo $currurl; ?>text/javascript" src="js/excanvas.js"></script><![endif]-->
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery-ui-1.8.2.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.fancybox-1.3.2.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.validate.js" ></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.wysiwyg.js" ></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.flot.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.flot.stack.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/styleswitch.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/custom.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/custom_graphs.js"></script>


        <script type="text/javascript" src="<?=base_url() ?>/application/views/ckeditor.js"></script>
        <script type="text/javascript" src="<?=base_url() ?>ckfinder/ckfinder.js"></script>
  
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.selectboxes.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.selectboxes.min.js"></script>
        <script type="text/javascript" src="<?php echo $currurl; ?>js/jquery.selectboxes.pack.js"></script>
        
        
        <script>
function check()
{
if (!confirm("確認刪除!"))
return false;
}

function check_all(obj,cName) 
{ 
	
    var checkboxs = document.getElementsByName(cName); 
   // alert(checkboxs.length);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 


</script>

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
    </head>
    <body>
    	
        <?php
       
        if ($this->session->userdata('username') == false) {
            redirect('/welcome/login', 'refresh');
        }else{
        	  
        }
        ?>
        <div id="wrapper">
            <ul id="topbar">
                <li><a class="button white fl" title="preview" href=""><span class="icon_single preview"></span></a></li>
                <li class="s_1"></li>
           
                <li class="s_1"></li>
                <li><a class="breadcrumb underline" href="<?php echo $url; ?>"> <h2>Welcome to Merchant Soultion System </h2></a></li>
                <li class="fr"><a class="button red fl" title="logout" href="<?= $url;
                    ?>welcome/logout"><span class="icon_text logout"></span>logout</a></li>
            </ul>


            <?php echo $main ?>

        </div>

        <div id="footer">
            <p class="copy fl">Copyright 2014<strong>   </strong>Merchant Soultion System  All rights reserved.     Page rendered in <strong>{elapsed_time}</strong> seconds</p>
       
            <ul class="skinner fr">
                <li class="fl"><a href="#" rel="style_blue" class="styleswitch skin skin_blue fl"></a></li>
            
                <li class="clear"></li>
            </ul>
        </div>
    </body>
</html>