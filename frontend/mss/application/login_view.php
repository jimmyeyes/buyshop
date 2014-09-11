<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Merchant Soultion System</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/jquery/jquery.ui.all.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/table_data.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/lightbox/style.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $currurl; ?>css/style.css" title="style_blue" media="screen"/>
        <link rel="alternate stylesheet" type="text/css" href="<?php echo $currurl; ?>css/style_green.css" title="style_green" media="screen" />
        <link rel="alternate stylesheet" type="text/css" href="<?php echo $currurl; ?>css/style_red.css" title="style_red" media="screen" />
        <link rel="alternate stylesheet" type="text/css" href="<?php echo $currurl; ?>css/style_purple.css" title="style_purple" media="screen" />
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
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

        <?php //if ($fail == "1"): ?>
            <script type="text/javascript">
                $(document).ready(function() {

                    //BOX LOGIN ERROR TEST//
                    //$("#content-login .error").hide();
                       function a(){
                    $("#box-login").show('shake', 55);
                    $(".header-login").show('shake', 55);
                    $("#content-login .error").show('blind', 500);
}

                   <?php echo $fail; ?>
            });

            </script>

    </head>
    <body>




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
        <div id="wrapper">
            <ul id="topbar">
                <li><a class="button white fl" title="preview" href="<?=base_url()?>/index.php/"><span class="icon_single preview"></span></a></li>
                <li class="s_1"></li>
                <li class="logo"><strong></strong> ADMIN</li>
            </ul>

            <div id="content-login">
              
                <h2 class="header-login">Login </h2>
                <form id="box-login" action="<?=base_url()?>index.php/welcome/logining" method="post">
                    <p>
                        <label class="req"> username </label>
                        <br/>
                        <input type="text" name="user" value="" id="username"/>
                    </p>
                    <p>
                        <label class="req"> password </label>
                        <br/>
                        <input type="password" name="pass" value="" id="password"/>
                    </p>

                    <p class="fr">

                        <input type="submit" value="Login" class="button themed" id="login"/>
                    </p>

                       
                    <div class="clear"></div>
                </form>

                <span id="err" class="message error"> <strong>Username</strong> and/or <strong>Password</strong> are wrong</span>

            </div>

        </div>

        <div id="footer">
            <p class="copy fl">Copyright 2013<strong> Merchant Soultion System  </strong> All rights reserved.</p>
            <ul class="button language_button white fr">
                <li class="icon_single language fl"></li>
                <li class="flag en fl"></li>
                <li class="flag es fl"></li>
                <li class="flag de fl"></li>
                <li class="flag it fl"></li>
                <li class="clear"></li>
            </ul>
            <ul class="skinner fr">
                <li class="fl"><a href="#" rel="style_blue" class="styleswitch skin skin_blue fl"></a></li>
                <li class="fl"><a href="#" rel="style_green" class="styleswitch skin skin_green fl"></a></li>
                <li class="fl"><a href="#" rel="style_red" class="styleswitch skin skin_red fl"></a></li>
                <li class="fl"><a href="#" rel="style_purple" class="styleswitch skin skin_purple fl"></a></li>
                <li class="clear"></li>
            </ul>
        </div>
    </body>
</html>