var FormWizard = function () {    return {        //main function to initiate the module        init: function () {            if (!jQuery().bootstrapWizard) {                return;            }            function format(state) {                if (!state.id)                    return state.text; // optgroup                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;            }            var form = $('.plan_submit_form');            var error = $('.alert-danger', form);            var success = $('.alert-success', form);            form.validate({                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.                errorElement: 'span', //default input error message container                errorClass: 'help-block help-block-error', // default input error message class                focusInvalid: false, // do not focus the last invalid input                rules: {                    fullname: {                        required: true                    },                    businessname: {                        required: true                    },                    username: {                        required: true                    },                    password: {                        required: true                    },                    email: {                        required: true,                        email: true                    },                    phone: {                        digits: true,                        required: true                    },                    tc: {                        required: true,                        minlength: 1                    },                    add_plan: {                        required: true                    },                      card_name: {                        required: true                    },                    card_number: {                        minlength: 16,                        maxlength: 16,                        required: true                    },                    securitycode: {                        digits: true,                        required: true,                        minlength: 3,                        maxlength: 4                    },                    zipcode: {                        required: true                    }                },                messages: {                    tc: {                        required: "Please agree the condition",                        minlength: jQuery.validator.format("Please select at least one option")                    },                    add_plan: {                        required: "Please select plan"                    }                },                errorPlacement: function (error, element) { // render error placement for each input type                    if (element.attr("name") == "tc") { // for uniform checkboxes, insert the after the given container                        error.insertAfter("#form_tc_error");                    } else {                        error.insertAfter(element); // for other inputs, just perform default behavior                    }                },                invalidHandler: function (event, validator) { //display error alert on form submit                       success.hide();                    error.show();                    Metronic.scrollTo(error, -200);                },                highlight: function (element) { // hightlight error inputs                    $(element)                            .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group                },                unhighlight: function (element) { // revert the change done by hightlight                    $(element)                            .closest('.form-group').removeClass('has-error'); // set error class to the control group                },                success: function (label) {                    if (label.attr("for") == "tc") { // for checkboxes and radio buttons, no need to show OK icon                        label.closest('.form-group').removeClass('has-error').addClass('has-success');                        label.remove(); // remove error label here                    } else { // display success icon for other inputs                        label                                .addClass('valid') // mark the current input as valid and display OK icon                                .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group                    }                },                submitHandler: function (form) {                    success.show();                    error.hide();                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax\                }            });            var displayConfirm = function () {                $('#tab4 .form-control-static', form).each(function () {                    if ($(this).attr("data-display") == 'tc') {                        var tc = [];                        $('[name="tc"]:checked', form).each(function () {                            tc.push($(this).attr('data-title'));                        });                        $(this).html(tc.join("<br>"));                    }                });            }            var handleTitle = function (tab, navigation, index) {                var total = navigation.find('li').length;                var current = index + 1;                // set wizard title                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);                // set done steps                jQuery('li', $('#form_wizard_1')).removeClass("done");                var li_list = navigation.find('li');                for (var i = 0; i < index; i++) {                    jQuery(li_list[i]).addClass("done");                }                if (current == 1) {                    $('#form_wizard_1').find('.button-previous').hide();                } else {                    $('#form_wizard_1').find('.button-previous').show();                }                if (current >= total) {                    $('#form_wizard_1').find('.button-next').hide();                    $('#form_wizard_1').find('.button-submit').show();                    displayConfirm();                } else {                    $('#form_wizard_1').find('.button-next').show();                    $('#form_wizard_1').find('.button-submit').hide();                }                Metronic.scrollTo($('.page-title'));            }            // default form wizard            $('#form_wizard_1').bootstrapWizard({                'nextSelector': '.button-next',                'previousSelector': '.button-previous',                onTabClick: function (tab, navigation, index, clickedIndex) {                    return false;                    /*                     success.hide();                     error.hide();                     if (form.valid() == false) {                     return false;                     }                     handleTitle(tab, navigation, clickedIndex);                     */                },                onNext: function (tab, navigation, index) {                    success.hide();                    error.hide();                    if (form.valid() == false) {                        return false;                    }                    handleTitle(tab, navigation, index);                },                onPrevious: function (tab, navigation, index) {                    success.hide();                    error.hide();                    handleTitle(tab, navigation, index);                },                onTabShow: function (tab, navigation, index) {                    var total = navigation.find('li').length;                    var current = index + 1;                    var $percent = (current / total) * 100;                    $('#form_wizard_1').find('.progress-bar').css({                        width: $percent + '%'                    });                }            });            $('#form_wizard_1').find('.button-previous').hide();            //$('#form_wizard_1 .button-submit').hide();            $('#plan_submit_form .button-submit').click(function () {                var form = $('#plan_submit_form');                $.ajax({                    url: "http://localhost:82/propertytax247/Singup/cart",                    type: "POST",                    data: new FormData((form)[0]),                    contentType: false,                    cache: false,                    processData: false,                    success: function (data)                    {                        if (data == "success") {                            $('#order_fail_msg').hide();                            $('#user_exists_msg').hide();                            $('#order_success_msg').show();                        }                        else if (data == "fail") {                            $('#user_exists_msg').hide();                            $('#order_success_msg').hide();                            $('#order_fail_msg').show();                        }                        else if (data == "exists") {                            $('#order_success_msg').hide();                            $('#order_fail_msg').hide();                            $('#user_exists_msg').show();                        }                    },                    error: function ()                    {                    }                });            }).hide();                        $('#client_newplan_submit_form .button-submit').click(function () {                var form = $('#client_newplan_submit_form');                $.ajax({                    url: "http://localhost:82/propertytax247/Client/new_plan",                    type: "POST",                    data: new FormData((form)[0]),                    contentType: false,                    cache: false,                    processData: false,                    success: function (data)                    {                        if (data == "success") {                            $('#order_fail_msg').hide();                            $('#order_success_msg').show();                        }                        else if (data == "fail") {                            $('#order_success_msg').hide();                            $('#order_fail_msg').show();                        }                    },                    error: function ()                    {                    }                });            }).hide();        }    };}();