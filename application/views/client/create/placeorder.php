<?php
$plan_id = $this->input->post('add_plan');
$get_plan = array(
    'Plan_Id' => $plan_id,
    'Status' => 1
);
$this->db->where($get_plan);
$q_plan = $this->db->get('tbl_plan');
$count_plan = $q_plan->num_rows();
if ($count_plan > 0) {
    foreach ($q_plan->result() as $row_plan) {
        $plan_name = $row_plan->Plan_Name;
        $plan_type = $row_plan->Type;
        $plan_price = $row_plan->Price;
        $no_of_order = $row_plan->No_Of_Order;
    }
}
$plan_total = number_format((float) $plan_price, 2, '.', '');
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
   
    $(document).ready(function () {
        $('#username').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
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
    
  
    function plan_submit_form() {
        var form = $('#plan_submit_form');
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
                if (data == "success") {
                    $('#order_fail_msg').hide();
                    $('#user_exists_msg').hide();
                    $('#order_success_msg').show();
                    window.location.href = "<?php echo site_url('Client_Login') ?>";
                }
                else if (data == "fail") {
                    $('#user_exists_msg').hide();
                    $('#order_success_msg').hide();
                    $('#order_fail_msg').show();
                }
                else if (data == "exists") {
                    $('#order_success_msg').hide();
                    $('#order_fail_msg').hide();
                    $('#user_exists_msg').show();
                }
            },
            error: function ()
            {
            }
        });
    }
	function paymentmethod(data) {
        if (data == "order_pp") {
            $('#billing_order').hide();
        } else {
            $('#billing_order').show();
        }
    }
</script>

<!-- BEGIN FORM-->
<div class="row" style="margin-top:-90px;">
    <div class="col-md-12">
        <div class="portlet box blue" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-folder-alt"></i>Order Information
                </div>
                <div class="tools hidden-xs">
                    <h4 id="plantotal_head" class="margin-top-10"><strong>Total : $<span id="plantotal" class="plantotal"><?php echo $plan_total; ?></span></strong></h4>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal validate plan_submit_form" id="plan_submit_form" method="POST">
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
                                            <i class="fa fa-check"></i> Sign up </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#taborder3" data-toggle="tab" class="step active">
                                        <span class="number">
                                            3 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Billing Information </span>
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
                                        <h3 class="block">HERE'S HOW OUR TITLE ORDERING PROCESS WORKS:</h3>
                                        <ul>
                                            <li>Choose the desired Property Report Plans.</li>
                                            <li>Once selected, you will be taken to the billing page for payment. PayPal and all major credit cards are accepted.</li>
                                            <li>Once your payment is processed, you will be directed to our <a target="_blank" href="<?php echo site_url('Client_Login'); ?>">Propertyreport247.com</a> Customer Logins to place your orders.</li>
                                            <li>Every Orders Placed through <a href="<?php echo site_url('Client_Login'); ?>" target="_blank">Propertyreport247.com</a> the ETA will be notified within 4 hours.</li>
                                            <li>When your order is completed, the email notification will be sent and the same order will appear in your <a target="_blank" href="<?php echo site_url('Client_Login'); ?>">Propertyreport247.com</a> login account and you can view it or download the report.</li><br>
                                            <li> <b>Note: </b>Order cancellation need to be placed within 2 hours from the time of placing the order. 
						Any Order cancelled and that exceeds the time limit of 2 hours will not be considered as cancelled order.</li>
                                        </ul>  
                                    </div>
                                </div>
                                <div class="tab-pane" id="taborder2">
                                    <h3 class="block">Provide your account details</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">First & Last Name 
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="fullname" id="fullname" data-validate="required" data-message-required="Please Enter Your Name" autocomplete="off">
                                            </div>
                                        </div>

                                        <label class="control-label col-md-3">Business Name / Last & First Name                                            
                                        </label>
                                        <div class="col-md-3">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="businessname" id="businessname" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Username
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="username" data-validate="required" data-message-required="Please Enter Username" autocomplete="off" tabindex="0" id="username">
                                            </div>
                                        </div>

                                        <label class="control-label col-md-2"> Password 
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">														
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="password" class="form-control input-sm" name="password" id="password" data-validate="required" data-message-required="Please Enter Password" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Email Address 
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm"  name="email" data-validate="required,email" data-message-required="Please Enter Valid Email Address" autocomplete="off" id="email">
                                            </div>
                                        </div>
                                        <label class="control-label col-md-2">Phone No
                                            <span class="required"> * </span>
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
                                                   <input type="text" style="width:40px; margin-bottom: 20px; border-bottom-color: #002040;" class="form-control input-sm" name="initials" id="initials" data-validate="required" data-message-required="Please Enter Your Initials Name"><p style="margin-left:44px; margin-top: -38px;">Your Initials as acknowledgement of agreement to our <a title="term and Conditions" target="_blank" href="http://localhost/term-condition.html">terms and conditions</a> of using our service & reports. <span class="required">
                                                            * </span></p>  
                                                </div>
                                            </div> 
                                        </label>

                                    </div>
                                    <div class="form-group" style="margin-top:-10px;">
                                        <div class="col-md-4">
                                            <div class="checkbox-list">
                                                <input type="checkbox" name="tc" value="yes" data-validate="required" data-message-required="Please Agree The Terms and Conditions" autocomplete="off"/> I have read and agree to the <a title="term and Conditions" target="_blank" href="http://localhost/term-condition.html">terms and conditions</a><span class="required">  * </span>
                                            </div>
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
                                <div class="tab-pane" id="taborder3">
                                    <input type="hidden" value="<?php echo $plan_type; ?>" name="add_signup_order_type" id="add_signup_order_type">
                                    <input type="hidden" value="<?php echo $plan_id; ?>" name="add_signup_plan" id="add_signup_plan">
                                    <input type="hidden" value="<?php echo '1|' . $no_of_order . '|' . $plan_total; ?>" name="add_signup_no_of_order" id="add_signup_no_of_order">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="order_success_msg" class="alert alert-success" style="display:none;">Plan details submitted successfully.Please login and place the order.</div>
                                            <div id="order_fail_msg" class="alert alert-danger" style="display:none;">Failed to submit plan details.</div>
                                            <div id="user_exists_msg" class="alert alert-info" style="display:none;">Username already exists.</div>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="form-body">
                                            <h3 class="block">Provide your billing and credit card or Paypal details</h3>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <h4 class="block">Selected Plan : <span class="selected_planname"><?php echo $plan_name . " at $" . $plan_total ?></span></h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <h4 class="block">Plan Type : <span id="selected_plantype" class="selected_plantype"><?php echo $plan_type; ?></span></h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <h4 class="block">No Of Order : <span id="selected_no_of_order" class="selected_no_of_order"><?php echo $no_of_order; ?></span></h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <h4 class="block">Total Amount ($): <span id="selected_total_amount" class="selected_total_amount"><?php echo $plan_total; ?></span></h4>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Payment Options 
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="radio" name="payment_option" value="order" onclick="paymentmethod(this.value)" checked>
                                                        <img src="<?php echo site_url('assets/global/img/card1.png') ?>" border="0" style="width:260px"/>
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="radio" name="payment_option" value="order_pp" onclick="paymentmethod(this.value)">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer">
                                                    </label>
                                                </div>
                                                <div class="col-md-4">                                           
                                                        <img src="<?php echo site_url('assets/global/img/security1.png') ?>"  style="width: 400px; height: 100px; padding-left: 280px;"/>
                                                    </div>                                               
                                            </div>   
                                            <div id="billing_order">
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Card Holder Name <span class="required">
                                                            * </span>
                                                    </label>                                       
                                                    <div class="col-md-2">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" id="card_name" name="card_name" autocomplete="off" data-validate="required" data-message-required="Please Enter Holder Name"> 
                                                        </div>
                                                    </div>

                                                    <label class="control-label col-md-2">Card Number 
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-2">                                           
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" id="card_number" name="card_number" autocomplete="off" data-validate="required,number" maxlength="16" data-message-required="Please Enter Card Number">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">                                           
                                                        <img src="<?php echo site_url('assets/global/img/security2.png') ?>" style="width: 418px; padding-left: 244px "/>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Expiration Period <span class="required"> *</span></label>
                                                    <div class="col-md-4">
                                                        <div class="col-md-6">
                                                            <select class="form-control select2me" autocomplete="off">
                                                                <?php
                                                                for ($m = 1; $m <= 12; $m++) {
                                                                    $current_month = date('m');
                                                                    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                                    ?>
                                                                    <option value="<?php echo $m; ?>" <?php
                                                                    if ($current_month == $m) {
                                                                        echo "selected=selected";
                                                                    }
                                                                    ?>><?php echo $month . " (" . $m . ")"; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control select2me" autocomplete="off">
                                                                <?php
                                                                $current_year = date('Y');
                                                                for ($y = 0; $y < 10; $y++) {
                                                                    $year = $current_year + $y;
                                                                    ?>
                                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-2">                                           

                                                    </div>
                                                    <div class="col-md-2">                                           
                                                        <img src="<?php echo site_url('assets/global/img/security3.png') ?>" style="width: 417px; height: 53px; padding-left: 276px; " />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Card Security Code <span class="required"> *</span></label>
                                                    <div class="col-md-2">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="password" class="form-control input-sm" name="securitycode" id="securitycode" data-validate="required,number" data-message-required="Please Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                        </div>
                                                    </div>
                                                    <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                    <div class="col-md-2">
                                                        <div class="form-group form-md-line-input has-info">
                                                            <input type="text" class="form-control input-sm" name="zipcode" id="zipcode" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Please Enter Billing Zipcode">
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
                            <div class="row">
                                <div class="col-md-offset-10 col-md-2">
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
            </div>
        </div>
    </div>
</div>
<!-- END FORM-->
