<?php
$this->db->order_by('Plan_Id', 'desc');
$get_plan = array(
    'Type' => 'Single',
    'Status' => 1
);
$this->db->where($get_plan);
$q_plan = $this->db->get('tbl_plan');
$count_plan = $q_plan->num_rows();
$plan_total = number_format((float) 0, 2, '.', '');

// Save card Query start here
if (isset($_POST['save_card'])) {
    $Card_Holder_Name = $_POST['Card_Holder_Name'];
    $Card_Number = $_POST['Card_Number'];
    $card_type_digit = substr($Card_Number, 0, 1);
    if ($card_type_digit == 3) {
        $card_type = "American";
    }if ($card_type_digit == 4) {
        $card_type = "Visa";
    }if ($card_type == 5) {
        $card_type = "Master";
    }if ($card_type == 6) {
        $card_type = "Discover";
    }
    $Expired_Year = $_POST['Expired_Year'];
    $Expired_Month = $_POST['Expired_Month'];
    $Zip_Code = $_POST['Zip_Code'];
    $Inserted_Date = date('Y-m-d H:i:s');
    $select_card_insert = "INSERT INTO tbl_cards (User_Id, Card_Holder_Name, Card_Number, Expired_Year, Expired_Month, Zip_Code,Card_Type, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$Card_Holder_Name', '$Card_Number', '$Expired_Year', '$Expired_Month', '$Zip_Code','$card_type','$user_id', '$Inserted_Date'," . 1 . ")";
    mysql_query($select_card_insert);
}
// Save card Query End here
?>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Property | Client Signup</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="<?php echo site_url('assets/admin/pages/css/login-soft.css') ?>" rel="stylesheet" type="text/css"/>
        <?php $this->load->view('common/head'); ?>
        <script src="<?php echo site_url('assets/admin/pages/scripts/client-login-validation.js') ?>" type="text/javascript"></script>
        <link href="<?php echo site_url('assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
        <style>
            #add_state_ms{
                background-position:162px center;
            }       

        </style>

        <script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
        <script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
        <script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
        <script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>

        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url('Cart/Storeitems') ?>",
                    data: {
                        total_cart_items: "totalitems"
                    },
                    success: function (response) {
                        $('#total_items').html(response);
                    }
                });
            });
            function show_cart()
            {
                $.ajax({
                    type: 'post',
                    url: "<?php echo site_url('Cart/Signupcartitems') ?>",
                    data: {
                        showcart: "cart"
                    },
                    success: function (response) {
                        document.getElementById("show_cart").innerHTML = response;
                    }
                });
            }
            function removepopupcart(code) {
                $.ajax({
                    url: "<?php echo site_url('Cart/removefromcart') ?>",
                    type: 'post',
                    data: {
                        order_code: code
                    },
                    method: 'POST',
                    success: function (msg)
                    {
                        $('[class="dropdown dropdown-user dropdown-dark"]').parent().removeClass('open');
                        $("#total_items").html(msg);
                    }
                });
            }
            // Space bar remove query start here
            $(document).ready(function () {
                $('#email').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
                $('#password').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
                $('#phone').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });

                $('#username').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
                // Billing Amount
                $('#card_name').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
                $('#card_number').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
                $('#securitycode').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
                $('#zipcode').live('keydown', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 32) {
                        e.preventDefault();
                    }
                });
            });
            // Space bar remove query End here

            function selected_plan() {
                var plan_type;
                if (document.getElementById("add_signup_order_type_single").checked) {
                    plan_type = document.getElementById("add_signup_order_type_single").value;
                } else {
                    plan_type = document.getElementById("add_signup_order_type_bulk").value;
                }
                var plan = $("#add_signup_plan option:selected").text();
                var no_of_order_list = $("#add_signup_no_of_order option:selected").val();
                var arr = no_of_order_list.split('|');
                var no_of_order = arr[0];
                var bulk_order = arr[1];
                var price = arr[2];
                var total_order = no_of_order * bulk_order;
                var plan_amount = no_of_order * price;
                $("#selected_planname").html(plan);
                if (plan_type == "Single") {
                    $("#selected_plantype").html(plan_type);
                } else {
                    var plantype = plan_type + "(" + no_of_order + ")";
                    $("#selected_plantype").html(plantype);
                }
                $('#selected_no_of_order').html(total_order);
                $(".selected_total_amount").html(parseInt(plan_amount).toFixed(2));
            }

            function paymentmethod(data) {
                if (data == "order_pp") {
                    $('#billing_order').hide();
                } else {
                    $('#billing_order').show();
                }
            }
            /* Special Char Disable Query*/
            /*Special Character Disable Query*/
			function alpha(e){
			var k = e.charCode ? e.charCode : e.keyCode;
			return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 9); //k=9(keycode for tab)
			}

            function change_plan(type) {
                $.ajax({
                    url: "<?php echo site_url('Cart/change_plan') ?>",
                    type: 'post',
                    data: {
                        type: type
                    },
                    method: 'POST',
                    success: function (msg)
                    {
                        $("#add_plan").html(msg);
                    }
                });
            }
            function change_state(plan_id) {
                var add_order_type = $("#add_order_type").val();
                if (add_order_type == "Single") {
                    $.ajax({
                        url: "<?php echo site_url('Cart/change_state_single'); ?>",
                        type: 'post',
                        data: {
                            plan_id: plan_id
                        },
                        method: 'POST',
                        success: function (msg)
                        {
                            $("#add_state").html(msg);
                        }
                    });
                }
                if (add_order_type == "Bulk") {
                    $.ajax({
                        url: "<?php echo site_url('Cart/change_state_bulk'); ?>",
                        type: 'post',
                        data: {
                            plan_id: plan_id
                        },
                        method: 'POST',
                        success: function (msg)
                        {
                            $("#add_state_div").html(msg);
                        }
                    });
                }
            }

            function change_county(state_id) {
                var add_order_type = $("#add_order_type").val();
                if (add_order_type == "Single") {
                    $.ajax({
                        url: "<?php echo site_url('Cart/change_county_single'); ?>",
                        type: 'post',
                        data: {
                            state_id: state_id
                        },
                        method: 'POST',
                        success: function (msg)
                        {
                            $("#add_county").html(msg);
                            var state = $('#add_state:selected').text();
                            $("#add_state").attr("title", state);
                        }
                    });
                }
                if (add_order_type == "Bulk") {
                    $.ajax({
                        url: "<?php echo site_url('Cart/change_county_bulk'); ?>",
                        type: 'post',
                        data: {
                            state_id: state_id
                        },
                        method: 'POST',
                        success: function (msg)
                        {
                            $('#add_county').hide();
                            $("#add_county_div").html(msg);
                            var state = $('#add_state :selected').text();
                            $("#add_state").attr("title", state);
                        }
                    });
                }
            }

            function change_price(plan_id) {
                $.ajax({
                    url: "<?php echo site_url('Cart/change_price'); ?>",
                    type: 'post',
                    data: {
                        plan_id: plan_id
                    },
                    method: 'POST',
                    success: function (msg)
                    {
                        $("#add_price").val(msg);
                    }
                });
            }

            function plan_submit_form() {
                var form = $('#plan_submit_form');
				  var payment_type = $("input[name='payment_option']:checked").val();
                if (payment_type == "order") {
                if (!form.valid())
                    return false;
                $.ajax({
                    url: "<?php echo site_url('Signup/cart') ?>",
                    type: "POST",
                    data: new FormData((form)[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        if (data == "nocart") {
                                $("#user_exists_msg").hide();
                                $("#order_fail_msg").hide();
                                $("#payment_error_msg").hide();
                                $("#order_success_msg").hide();
                                $("#empty_cart_msg").show();
                            }
                        else if (data == "success") {
                            $("#empty_cart_msg").hide();
                            $("#user_exists_msg").hide();
                            $("#order_fail_msg").hide();
                            $("#payment_error_msg").hide();
                            $("#order_success_msg").show();
                            window.location.href = 'http://localhost:82/propertytax247/Client_Login';
                        }
                        else if (data == "fail") {
                            $("#empty_cart_msg").hide();
                            $("#order_success_msg").hide();
                            $("#user_exists_msg").hide();
                            $("#payment_error_msg").hide();
                            $("#order_fail_msg").show();
                        }
                        else if (data == "exists") {
                            $("#empty_cart_msg").hide();
                            $("#order_success_msg").hide();
                            $("#order_fail_msg").hide();
                            $("#payment_error_msg").hide();
                            $("#user_exists_msg").show();
                        } else {
                            $("#empty_cart_msg").hide();
                            $("#order_success_msg").hide();
                            $("#order_fail_msg").hide();
                            $("#user_exists_msg").hide();
                            $("#payment_error_msg").show();
                            $("#payment_error_msg").html(data);
                        }
                    },
                    error: function ()
                    {
                    }
                });
			}
                    if (payment_type == "order_pp") {
                    $.ajax({
                        url: "<?php echo site_url('Signup/paypalcart') ?>",
                        type: "POST",
                        data: new FormData((form)[0]),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data)
                        {
				if (data == "nocart") {
                                $("#order_success_msg").hide();
                                $("#user_exists_msg").hide();
                                $("#order_fail_msg").hide();
                                $("#empty_cart_msg").show();
                            }
                            else if (data == "fail") {
				$("#empty_cart_msg").hide();
                                $("#order_success_msg").hide();
                                $("#user_exists_msg").hide();
                                $("#order_fail_msg").show();
                            }
                            else if (data == "exists") {
				$("#empty_cart_msg").hide();
                                $("#order_success_msg").hide();
                                $("#order_fail_msg").hide();
                                $("#user_exists_msg").show();
                            } else {
				$("#empty_cart_msg").hide();
                                $("#order_fail_msg").hide();
                                $("#user_exists_msg").hide();
                                $('#paypal_div').html(data);
                                $('#paypal_form').submit();
                            }
                        },
                        error: function ()
                        {
                        }
                    });
                }
            }
            function addcart() {
                var order_type = $('#add_order_type').val();
                var plan_name = $('#add_plan').val();
                var price = $('#add_price').val();
                if (order_type != "" || plan_name != "" || price != "") {
                    if (order_type == "Single") {
                        var countyid = $('#add_county option:selected').val();
                        var countyname = $('#add_county option:selected').text();
                        var no_of_order = 1;
                        var state = $('#add_state option:selected').val();
                        var countyorder = countyname + "(" + no_of_order + ")";
                        if (state == "" || countyid == "") {
                            $('#lesscart_item').hide();
                            $("#validatecart_item").show();
                            return false;
                        } else {
                            $.ajax({
                                type: 'post',
                                url: "<?php echo site_url('Cart/addcart') ?>",
                                data: {
                                    order_type: order_type,
                                    plan_name: plan_name,
                                    state: state,
                                    county: countyid,
                                    countyorder: countyorder,
                                    no_of_order: no_of_order,
                                    price: price

                                },
                                success: function (response) {
                                    $("#validatecart_item").hide();
                                    $('#lesscart_item').hide();
                                    $('#total_items').html(response);
                                    $('#addcart_item_success').show(0).delay(5000).hide(0);
                                }
                            });
                        }
                    } else {
                        var countycheckid = [];
                        var no_of_order = [];
                        var no_of_order_count = 0;
                        var state = [];
                        var countyid = [];
                        var countyorder = [];
                        var length = $('[name="add_county"]').length;
                        for (var i = 0; i < length; i++) {
                            if (document.planForm.add_county[i].checked) {
                                countycheckid = i + 1;
                                if (parseInt($('#no_of_order_count' + countycheckid).val()) == 0) {
                                    $("#validatecart_item").hide();
                                    $('#lesscart_item').show();
                                    return false;
                                } else {
                                    no_of_order += $('#no_of_order_count' + countycheckid).val() + "|";
                                    no_of_order_count = parseInt(no_of_order_count) + parseInt($('#no_of_order_count' + countycheckid).val());
                                    countyid += $('#' + countycheckid).val() + "|";
                                    countyorder += $('#' + countycheckid).val() + "(" + $('#no_of_order_count' + countycheckid).val() + ")|";
                                }
                            }
                        }
                        $.each($("#add_state option:selected"), function () {
                            state += $(this).val() + "|";
                        });
                        if (no_of_order_count < 10) {
                            $("#validatecart_item").hide();
                            $('#lesscart_item').show(0).delay(5000).hide(0);
                            return false;
                        } else if (no_of_order_count > 10) {
                            var nooforder = no_of_order_count / 10;
                            if ((nooforder % 1) != 0) {
                                $("#validatecart_item").hide();
                                $('#lesscart_item').show(0).delay(5000).hide(0);
                                return false;
                            } else {
                                $.ajax({
                                    type: 'post',
                                    url: "<?php echo site_url('Cart/addcart') ?>",
                                    data: {
                                        order_type: order_type,
                                        plan_name: plan_name,
                                        state: state,
                                        county: countyid,
                                        countyorder: countyorder,
                                        no_of_order: no_of_order,
                                        price: price

                                    },
                                    success: function (response) {
                                        $("#validatecart_item").hide();
                                        $('#plantotal').html(response);
                                        $('#total_items').html(response);
                                        $('#addcart_item_success').show(0).delay(5000).hide(0);
                                    }
                                });
                            }

                        } else {
                            $.ajax({
                                type: 'post',
                                url: "<?php echo site_url('Cart/addcart') ?>",
                                data: {
                                    order_type: order_type,
                                    plan_name: plan_name,
                                    state: state,
                                    county: countyid,
                                    countyorder: countyorder,
                                    no_of_order: no_of_order,
                                    price: price

                                },
                                success: function (response) {
                                    $("#validatecart_item").hide();
                                    $('#plantotal').html(response);
                                    $('#total_items').html(response);
                                    $('#addcart_item_success').show(0).delay(5000).hide(0);
                                }
                            });
                        }
                    }
                } else {
                    $("#validatecart_item").show();
                    return false;
                }
            }
        </script>
    </head>
    <!-- BEGIN FORM-->
    <body class="page-header-fixed page-sidebar-closed-hide-logo login" style="background-image: url('assets/admin/layout4/img/login-bg.png');
          background-repeat: no-repeat;">
        <nav class="navbar yamm navbar-default navbar-static-top" style="min-height:128px;">
            <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">          
                        </div>
                        <div class="col-md-4">
                            <p class="social-icons pull-right" style="margin:0px -60px;">           
                                <i class="fa fa-phone-square"></i>Toll Free : 1-844-50TITLE
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="https://propertyreport247.com"><img src="<?php echo site_url('assets/admin/layout4/img/logo-light.png') ?>" style="width: 270px; height:88px; background-color:transparent;" class="logo-default"/></a>
                </div>        <!-- end .navbar-header -->

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="https://propertyreport247.com">Home</a></li>             
                        <li><a href="https://propertyreport247.com/plan.php">Plans</a></li>
                        <li><a href="https://propertyreport247.com/coverage.html">Coverage</a></li>
                        <li><a href="https://propertyreport247.com/samplereport.html">Sample Report</a></li>
                        <li ><a href="http://localhost:82/propertytax247/Signup" target="_blank">Place Order</a></li>			          
                        <li><a href="https://propertyreport247.com/contactus.html">Contact us</a></li>
                        <link href="<?php echo site_url('orders/assets/global/css/nav.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
                        <li class="active"><a href="http://localhost:82/propertytax247/Client_Login">Login</a></li>			
                        <li class="dropdown yamm-fw cart-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:0" onclick="show_cart()">
                                <span class="label label-warning cart-inside" id="total_items">0</span>
                                <div class="cart-image"></div>
                            </a>
                            <div class="dropdown-menu arrow_box" 
                                 style="background-color: #528FCC;color:#fff; width:270px; padding:10px;
                                 margin:27px 0px 0px -85px; background-image:url('assets/global/img/slash-bg.png'); ">
                                <ul>
                                    <li>
                                        <div class="yamm-content" id="show_cart"></div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                        if (count($_SESSION["cart_item"]) > 0) {
                            ?>
                            <div class="col-md-12">
                                <a href="https://propertyreport247.com/checkout.php" class="delete pull-right" id="checkout_btn" style="float: right; margin-top: -12px; margin-right: -15px; padding: 10px;">CHECKOUT</a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- end .navbar-collapse collapse --> 

            </div>
            <!-- end .container --> 
        </nav>   
        <div class="clearfix">
        </div>
        <div class="page-container" style="margin-top:0px">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-folder-alt"></i>Order Information
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal validate plan_submit_form" style="margin:0px; padding:0px;" name="planForm" id="plan_submit_form" method="POST">
                                <div class="form-wizard">
                                    <div class="form-body">
                                        <h4 class="block margin-top-10">WHEN YOU REPORT IS COMPLETE IT WILL BE SENT TO YOUR PROPERTYREPORT247.COM DASHBOARD, <a target="_blank" href="<?php echo site_url('Client_Login'); ?>">LOGIN HERE</a> TO VIEW.</h4>
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li>
                                                <a href="#taborder1" data-toggle="tab" class="step">
                                                    <span class="number">
                                                        1 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Plan Selection Procedure </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#taborder2" data-toggle="tab" class="step">
                                                    <span class="number">
                                                        2 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Billing Information </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#taborder3" data-toggle="tab" class="step">
                                                    <span class="number">
                                                        3 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Choose Plan</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#taborder4" data-toggle="tab" class="step active">
                                                    <span class="number">
                                                        4 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Sign up  </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success">
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="taborder1">
                                                <div class="form-group">
                                                    <h3 class="block" style="padding-top: 10px; padding-bottom: 10px;">HERE'S HOW OUR TITLE ORDERING PROCESS WORKS:</h3>
                                                    <ul style="color:#002040;">
                                                        <li>Choose the desired Property Report Plans.</li>
                                                        <li>Once selected, you will be taken to the billing page for payment. PayPal and all major credit cards are accepted.</li>
                                                        <li>Once your payment is processed, you will be directed to our <a target="_blank" href="<?php echo site_url('Client_Login'); ?>"><span class="report">Propertyreport247.com</span></a> Customer Logins to place your orders.</li>
                                                        <li>Every Orders Placed through <a href="<?php echo site_url('Client_Login'); ?>" target="_blank"><span class="report">Propertyreport247.com</span></a> the ETA will be notified within 4 hours.</li>
                                                        <li>When your order is completed, the email notification will be sent and the same order will appear in your <a target="_blank" href="<?php echo site_url('Client_Login'); ?>"><span class="report">Propertyreport247.com</span></a> login account and you can view it or download the report.</li><br>
                                                        <li><b>Note: </b>Order cancellation need to be placed within 2 hours from the time of placing the order. 
                                                            Any Order cancelled and that exceeds the time limit of 2 hours will not be considered as cancelled order.</li>
                                                    </ul>                                       
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="taborder3">
                                                <div class="portlet-body form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <div id="addcart_item_success" class="alert alert-success" style="display:none;padding: 4px;text-align: center">Your Cart details added successfully.</div>
                                                                <div id="lesscart_item" class="alert alert-danger" style="display:none;padding: 4px;text-align: center">FOR BULK ORDERS - THE MINIMUM ORDERS SHOULD BE IN 10, 20 30..</div>
								<div id="validatecart_item" class="alert alert-danger" style="display:none;padding: 4px;text-align: center">Please enter all data.</div>
                                                            </div>

                                                        </div>
                                                        <h3 class="block">Provide your plan details</h3>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Plan Type <span class="required"> * </span></label>
                                                            <div class="col-md-2">                                                          
                                                                <select class="form-control select2me" name="add_order_type" id="add_order_type" data-validate="required" data-message-required="Please Select Plan Type"  onChange="change_plan(this.value);" autocomplete="off">
                                                                    <option value=""> -- Plan Type -- </option>
                                                                    <option value="Single">Single</option>
                                                                    <option value="Bulk">Bulk</option>                                                                
                                                                </select>                                                        
                                                            </div>
                                                            <label class="control-label col-md-2">Plan Name <span class="required"> * </span></label>
                                                            <div class="col-md-2">                                                          
                                                                <select class="form-control select2me" name="add_plan" id="add_plan" data-validate="required" data-message-required="Please Select Plan Name" onClick="change_price(this.value)"  onChange="change_state(this.value)" autocomplete="off">
                                                                    <option value=""> -- Plan Name -- </option>
                                                                </select>                                                        
                                                            </div>                                                        
                                                        </div><br>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">State Name <span class="required"> * </span></label>
                                                            <div class="col-md-2">     
                                                                <div id="add_state_div">
                                                                    <select class="form-control select2me" name="add_state" id="add_state" onchange="change_county(this.value)" data-validate="required" data-message-required="Please Select State Name" autocomplete="off">
                                                                        <option value=""> -- State Name -- </option>
                                                                        Provide your billing and credit card or Paypal details               
                                                                    </select>        
                                                                </div>
                                                            </div>
                                                            <label class="control-label col-md-2">County Name<span class="required"> * </span>                                                            
                                                            </label>
                                                            <div class="col-md-4">
                                                                <div id="add_county_div">
                                                                    <select class="form-control select2me" data-validate="required" data-message-required="Please Select County Name" name="add_county" id="add_county" autocomplete="off" >
                                                                        <option value=""> -- County Name -- </option>
                                                                    </select>
                                                                </div>
                                                            </div>                                                        
                                                        </div><br>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Price
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <input type="text" placeholder="Price" value="$0.00" name="add_price" id="add_price" class="form-control input-sm" disabled="disabled">
                                                            </div>                                                        
                                                            <div class="col-md-3">
                                                                <input type="button" value="ADD TO CART" name="buynow_submit" id="buynow" class="submit btn blue button" onclick="addcart()">
                                                            </div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="form-body" id="tabcontent" style="display:none">
                                                        <div class="tabbable-custom nav-justified">
                                                            <ul class="nav nav-tabs nav-justified">
                                                                <li><a data-toggle="tab" class="col-md-11"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="tab-pane active" id="taborder4">
						<div class="row">
                                                    <div class="col-md-10">
                                                        <div id="order_success_msg" class="alert alert-success" style="display:none;">Plan details submitted successfully.Please login and place the order.</div>
                                                        <div id="order_fail_msg" class="alert alert-danger" style="display:none;">Failed to submit plan details.</div>
                                                        <div id="user_exists_msg" class="alert alert-info" style="display:none;">Username already exists.</div>
                                                        <div id="empty_cart_msg" class="alert alert-danger" style="display:none;">Your Cart is empty. Please try again.</div>
                                                        <div id="payment_error_msg" class="alert alert-danger"></div>
                                                    </div>
                                                </div>
                                                <h3 class="block">Provide your account details</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">First & Last Name <span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" name="fullname" id="fullname" data-validate="required" data-message-required="Please Enter Your Name" autocomplete="off" onkeypress="return alpha(event)">
                                                        </div>
                                                    </div>

                                                    <label class="control-label col-md-2">Business Name 
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" name="businessname" id="businessname" autocomplete="off" onkeypress="return alpha(event)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Username<span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" name="username" data-validate="required" data-message-required="Please Enter Username" autocomplete="off" tabindex="0" id="username" onkeypress="return alpha(event)">
                                                        </div>
                                                    </div>

                                                    <label class="control-label col-md-2"> Password <span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-4">														
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="password" class="form-control input-sm" name="password" id="password" data-validate="required" data-message-required="Please Enter Password" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Email Address <span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm"  name="email" data-validate="required,email" data-message-required="Please Enter Valid Email Address" autocomplete="off" id="email">
                                                        </div>
                                                    </div>
                                                    <label class="control-label col-md-2">Phone No <span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" name="phone" id="phone" data-validate="required,number" data-message-required="Please Enter Mobile Number" maxlength="15" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12" style="margin-bottom: 10px;">
                                                        <div class="col-md-10">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" maxlength="3" style="width:30px; margin-bottom:20px; border:1px solid #002040; border-color: #002040; margin-left: -15px;" class="form-control input-sm" name="initials" id="initials" autocomplete="off" data-validate="required" data-message-required="Please Enter Your Initials Name">
                                                                <p style="margin-left:19px; margin-top: -40px;">Your Initials as acknowledgement of agreement to our
                                                                    <a title="term and Conditions" target="_blank" href="https://propertyreport247.com/term-condition.html">terms and conditions</a> of using our service & reports. 
                                                                    <span class="required"> * </span>
                                                                </p>  
                                                            </div>
                                                        </div> 
                                                    </label>
                                                </div>

                                                <div class="form-group" style="margin-top:-10px;">
                                                    <div class="col-md-4">
                                                        <div class="checkbox-list">
                                                            <input type="checkbox" name="tc" value="yes" data-validate="required" data-message-required="Please Agree The Terms and Conditions" autocomplete="off"/> I have read and agree to the <a title="term and Conditions" target="_blank" href="https://propertyreport247.com/term-condition.html">terms and conditions</a> <span class="required">  * </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="taborder2">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div id="order_success_msg" class="alert alert-success" style="display:none;">Plan details submitted successfully.Please login and place the order.</div>
                                                        <div id="order_fail_msg" class="alert alert-danger" style="display:none;">Failed to submit plan details.</div>
                                                        <div id="user_exists_msg" class="alert alert-info" style="display:none;">Username already exists.</div>
                                                        <div id="payment_error_msg" class="alert alert-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="portlet-body form">
                                                    <div class="form-body">
                                                        <h3 class="block">Provide your billing and credit card or Paypal details</h3><br/>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Payment Options 
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <label>
                                                                    <input type="radio" name="payment_option" value="order" onclick="paymentmethod(this.value)" autocomplete="off" checked>
                                                                    <img src="<?php echo site_url('assets/global/img/card1.png') ?>" border="0" style="width:145px; height: 30px;"/>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>
                                                                    <input type="radio" name="payment_option" value="order_pp" onclick="paymentmethod(this.value)" autocomplete="off">
                                                                    <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer">
                                                                </label>
                                                            </div>
                                                        </div>    
                                                        <div id="billing_order">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Card Holder Name <span class="required">
                                                                        * </span>
                                                                </label>                                       
                                                                <div class="col-md-3">
                                                                    <div class="form-group form-md-line-input has-info">
                                                                        <input type="text" class="form-control input-sm" id="Card_Holder_Name" name="Card_Holder_Name" autocomplete="off" data-validate="required" data-message-required="Please Enter Holder Name" onkeypress="return alpha(event)"> 
                                                                    </div>
                                                                </div>

                                                                <label class="control-label col-md-2">Card Number 
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-3">                                           
                                                                    <div class="form-group form-md-line-input has-info">
                                                                        <input type="text" class="form-control input-sm" id="Card_Number" name="Card_Number" autocomplete="off" data-validate="required,number" maxlength="16" minlength="16" data-message-required="Please Enter Card Number">
                                                                    </div>
                                                                </div>                                               
                                                            </div><br/>                                            
                                                            <div class="form-group">
                                                                        <label class="control-label col-md-2">Expiration Month <span class="required" style="margin-left:-4px;">
                                                                                * </span>
                                                                        </label>                                       
                                                                        <div class="col-md-3">
                                                                            <select class="form-control select2me" autocomplete="off" name="Expired_Month" id="Expired_Month" data-validate="required" data-message-required="Select Card Expired Month">
                                                                                <option value="" selected>--Select Card Expiry Month--</option>
                                                                                <?php
                                                                                for ($m = 1; $m <= 12; $m++) {
                                                                                    $current_month = date('m');
                                                                                    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                                                    ?>
                                                                                    <option value="<?php echo $m; ?>" <?php
                                                                                    if ($current_month == $m) {
                                                                                        //echo "selected=selected";
                                                                                    }
                                                                                    ?>><?php echo $month . " (" . $m . ")"; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                            </select>
                                                                        </div>

                                                                        <label class="control-label col-md-2">Expiration Year 
                                                                            <span class="required"> * </span>
                                                                        </label>
                                                                        <div class="col-md-3">                                           
                                                                            <select class="form-control select2me" autocomplete="off" name="Expired_Year" id="Expired_Year" data-validate="required" data-message-required="Select Card Expired Year">
																				<option value="" selected>--Select Card Expiry Year--</option>
                                                                                <?php
                                                                                $current_year = date('Y');
                                                                                for ($y = 0; $y < 10; $y++) {
                                                                                    $year = $current_year + $y;
                                                                                    ?>
                                                                                    <option value="<?php echo $year; ?>" <?php
                                                                                    if ($current_year == $year) {
                                                                                        //echo "selected=selected";
                                                                                    }
                                                                                    ?>><?php echo $year; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                            </select>
                                                                        </div>                                                                  
                                                                    </div>                                       
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label">Card Security Code <span class="required"> *</span></label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group form-md-line-input has-info">
                                                                        <input type="password" class="form-control input-sm" name="securitycode" id="securitycode" data-validate="required,number" data-message-required="Please Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                                    </div>
                                                                </div>
                                                                <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group form-md-line-input has-info">
                                                                        <input type="text" class="form-control input-sm" name="Zip_Code" id="Zip_Code" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Please Enter Billing Zipcode">
                                                                    </div>
                                                                </div>                                                    
                                                            </div>

                                                            <div class="form-group" >
                                                                <div class="col-md-4">
                                                                    <div class="checkbox-list">
                                                                        <input type="checkbox" name="save_card" value="yes" autocomplete="off"/> Save this Card for fast checkout 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row" style="margin-top:-47px; float:right; width:97%;">
                                            <div class="col-md-offset-7 pull-right" style="float:right; margin-right:17px; margin-top:-3px;">
                                                <a href="javascript:;" class="btn default button-previous">
                                                    <i class="m-icon-swapleft"></i> Back 
                                                </a>
                                                <a href="javascript:;" class="btn blue button-next">
                                                    Continue <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                                <a class="btn blue button-submit" onclick="plan_submit_form()">
                                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div style="background-color:#f5f5f5">
                                <div class="col-md-offset-8">                                           
                                    <img style="height: 62px; margin-top:-15px; margin-left:80px;" src="<?php echo site_url('assets/global/img/secure.png') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM-->
			<div id="paypal_div"></div>
            <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/css/tooltip.css') ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/dropdown/jquery-ui.css') ?>" />
            <script type="text/javascript" src="<?php echo site_url('assets/global/dropdown/jquery-ui.min.js') ?>"></script>
            <link href="<?php echo site_url('assets/global/dropdown/jquery.multiselect.css') ?>" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url('assets/global/dropdown/jquery.multiselect.js') ?>" type="text/javascript"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/dropdown/component.css') ?>" />      
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer" style="margin-left:-18px;">
                <div class="copyright">
                    Copyright © 2016 <a target="_blank" href="#" style="color:#fff">Abstract Shop, LLC</a> All Rights Reserved. 
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
    </body>
    <!-- END BODY -->
</html>