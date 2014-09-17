$(document).ready(function() {

    //BOX LOGIN ERROR TEST//
    $("#content-login .error").hide();
    $("#error").click(function() {
        $("#box-login").show('shake', 55);
        $(".header-login").show('shake', 55);
        $("#content-login .error").show('blind', 500);
        return false;
    });

    //LANGUAGE //
    $(".flag").hide();
    $(".language_button").click(function() {
        $(".flag").toggle('drop');
    });

    //BOX SORTABLE //
    $(".column.half").sortable({
        connectWith: '.column.half',
        handle: '.box-header'
    });
    $(".column.full").sortable({
        connectWith: '.column.full',
        handle: '.box-header'
    });
    $(".box").find(".box-header").prepend('<span class="close"></span>').end();
    $(".box-header .close ").click(function() {
        $(this).parents(".box .box-header").toggleClass("box-header closed").toggleClass("box-header");
        $(this).parents(".box:first").find(".box-content").toggle();
        $(this).parents(".box:first").find(".example").toggle();
    });

    //MESSAGE - TAG HIDE //
    $(".message").click(function() {
        $(this).hide('blind', 500);
        return false;
    });
    $(".tag").click(function() {
        $(this).hide('highlight', 500);
        return false;
    });

    //SEARCH INPUT//
    $("#search_input").focusin(
        function() {
            $('#search_input').val('');
        });
    $("#search_input").focusout(
        function() {
            $('#search_input').val('Search...');
        });

    //VALIDATION FORM//
    var validator = $("#formtest").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 2
            },
            lastname: {
                required: true,
                minlength: 2
            },
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#form-password"
            },
            email: {
                required: true,
                email: true
            },
            email_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#form-email"
            },
            dateformat: "required",
            terms: "required"
        },
        messages: {
            firstname: "Enter your firstname",
            lastname: "Enter your lastname",
            username: {
                required: "Enter a username",
                minlength: jQuery.format("Enter at least {0} characters"),
                remote: jQuery.format("{0} is already in use")
            },
            password: {
                required: "Provide a password",
                rangelength: jQuery.format("Enter at least {0} characters")
            },
            password_confirm: {
                required: "Repeat your password",
                minlength: jQuery.format("Enter at least {0} characters"),
                equalTo: "Enter the same password as above"
            },
            email: {
                required: "Please enter a valid email address",
                minlength: "Please enter a valid email address",
                remote: jQuery.format("{0} is already in use")
            },
            dateformat: "Choose your preferred dateformat",
            terms: "Please accept terms of use"
        },
        errorPlacement: function(error, element) {
            if ( element.is(":radio") )
                error.appendTo( element.parent().prev() );
            else if ( element.is(":checkbox") )
                error.appendTo ( element.parent().prev() );
            else
                error.appendTo( element.prev() );
        },
        submitHandler: function() {
            alert("Validate!");
        },
        success: function(label) {
            label.html("&nbsp;").addClass("valid_small");
        }
    });
    $("#form-username").focus(function() {
        var firstname = $("#form-firstname").val();
        var lastname = $("#form-lastname").val();
        if(firstname && lastname && !this.value) {
            this.value = firstname + "." + lastname;
        }
    });
    $("#reset").click (function(){
        $("#formtest .form-field").val ("");
    });

    //VALIDATION FORM//
    var validator = $("#namesub").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            }

        },
        messages: {
            name: "請輸入名稱"
        }
    });

    //VALIDATION FORM//
    var validator = $("#categoryval").validate({
        rules: {
            category: {
                required: true,
                minlength: 2
            }

        },
        messages: {
            name: "請輸入名稱"
        }
    });

    var validator = $("#cateval2").validate({
        rules: {
            o_category: {
                required: true,
                minlength: 2
            }

        },
        messages: {
            name: "請輸入名稱"
        }
    });

    var validator = $("#normalform").validate({
        rules: {
            title: {
                required: true,
                minlength: 2
            }

        },
        messages: {
            name: "請輸入名稱"
        }
    });

    var validator = $("#checkemail").validate({
        rules: {
            email: {
                required: true,
                minlength: 2
            }

        },
        messages: {
            name: "請輸入email"
        }
    });

    //VALIDATION FORM//
    var validator = $("#contactform").validate ({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            company:"required",
            name: "required",
            phone:"required",
            email:"required",
            contacttype:"required",
            content:"required"

        },
        messages: {
            company:"請輸入",
            name: "請輸入",
            phone:"請輸入",
            email:"請輸入",
            contacttype:"請選擇",
            content:"請輸入"

        }
    });


    //VALIDATION FORM//
    var validator = $("#plannform2").validate ({
        rules: {
            company: {
                required: true,
                minlength: 2
            },
            companyphone:"required",
            name:"required",
            email:"required",
            phone:"required"

        },
        messages: {
            company: "必須輸入",
            companyphone:"必須輸入",
            name:"必須輸入",
            email:"必須輸入",
            phone:"必須輸入"
        }
    });


    //TEXTAREA INPUT//
    $("#form-message").resizable({
        handle: "se",
        containment: '#formtest'
    });
    $("textarea.form-field").resizable({
        handle: "se",
        containment: '.box-content'
    });

    //CHECKBOX //
    $(".checkbox").button();
    $(".radiocheck").buttonset();

    //WYSIWYG//
    $('#wysiwyg').wysiwyg();
    $('#wysiwyg2').wysiwyg();
    $('#wysiwyg3').wysiwyg();
    $('#wysiwyg4').wysiwyg();
    $('#wysiwyg5').wysiwyg();
    //TABLE//
    oTable = $('#tabledata').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });


    //TABLE//
    oTable = $('#tabledata0').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });


    //TABLE//
    oTable = $('#tabledata1').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });



    //TABLE//
    oTable = $('#tabledata2').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });

    $("#checkboxall").click(function()
    {
        var checked_status = this.checked;
        $("input[name=checkall]").each(function()
        {
            this.checked = checked_status;
        });
    });
    $("#checkboxalltabs").click(function()
    {
        var checked_status = this.checked;
        $("input[name=checkalltabs]").each(function()
        {
            this.checked = checked_status;
        });
    });
    $("#checkboxalltabs2").click(function()
    {
        var checked_status = this.checked;
        $("input[name=checkalltabs2]").each(function()
        {
            this.checked = checked_status;
        });
    });
    $(".openable").click(function()
    {
        $(this).parents().next(".openable-tr").toggle();
    });

    //LIGHTBOX//
    $(".lightbox").fancybox();
    $(".lightbox[rel=lightbox-gallery]").fancybox();

    //GALLERY//
    $(".gallery-list li").hover(function() {
        $(this).find(".gallery-buttons").toggle();
    });

    //ACCORDION//
    $(".accordion").accordion();

    //DIALOG//
    $('.dialog').dialog({
        autoOpen: false,
        width: 800,
        height: 260,
        modal: true
    });
    $('.opener').click(function() {
        $('.dialog').dialog('open');
    });
    $('.closer').click(function() {
        $('.dialog').dialog('close');
    });

    //DATAPICKER//
    $(".datepicker").datepicker();

    //TABS - SORTABLE//
    $(".tabs").tabs();
    $(".tabs.sortable").tabs().find(".ui-tabs-nav").sortable({
        axis:'x'
    });

    //SKIN//
    $(".skin_block").hide();
    $('.skin_button').click(function() {
        $(".skin_block").toggle('drop');
    });

    //SLIDER//
    $(".slider-vertical").slider({
        orientation: "vertical",
        range: "min",
        min: 0,
        max: 100,
        value: 60,
        slide: function(event, ui) {
            $(".amount-vert").val(ui.value);
        }
    });
    $(".amount-vert").val($(".slider-vertical").slider("value"));

    $(".slider-horizontal").slider({
        range: true,
        min: 0,
        max: 500,
        values: [75, 300],
        slide: function(event, ui) {
            $(".amount-hor").val('$' + ui.values[0] + ' - $' + ui.values[1]);
        }
    });
    $(".amount-hor").val('$' + $(".slider-horizontal").slider("values", 0) + ' - $' + $(".slider-horizontal").slider("values", 1));

    //PROGRESSBAR//

    $(".progressbar").progressbar({
        value:0
    });
    $(".progressbar .ui-progressbar-value").animate({
        width:'5%'
    }, 1500);

    $("#prog-10").click(function() {
        $(".progressbar .ui-progressbar-value").animate({
            width:'10%'
        }, 1500);
    });
    $("#prog-30").click(function() {
        $(".progressbar .ui-progressbar-value").animate({
            width:'30%'
        }, 1500);
    });
    $("#prog-50").click(function() {
        $(".progressbar .ui-progressbar-value").animate({
            width:'50%'
        }, 1500);
    });
    $("#prog-70").click(function() {
        $(".progressbar .ui-progressbar-value").animate({
            width:'70%'
        }, 1500);
    });
    $("#prog-100").click(function() {
        $(".progressbar .ui-progressbar-value").animate({
            width:'100%'
        }, 1500);
    });

    $(".progressbaractive").progressbar({
        value: 0
    });
    $(".progressbarpending").progressbar({
        value: 0
    });
    $(".progressbarsuspended").progressbar({
        value: 0
    });

    $(".progressbaractive .ui-progressbar-value").animate({
        width:'60%'
    }, 1500);
    $(".progressbarpending .ui-progressbar-value").animate({
        width:'30%'
    }, 1500);
    $(".progressbarsuspended .ui-progressbar-value").animate({
        width:'10%'
    }, 1500);
});