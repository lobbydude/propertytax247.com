<?php
session_start();
$total_amount = 0;
if (count($_SESSION['cart_item']) > 0) {
    $total_amount = 0;
    if (isset($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $plan_id_sess = $item['plan_name'];
            $order_type_sess = $item['order_type'];
            $no_of_order_sess = $item['no_of_order'];
            $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_sess";
            $result_plan_sess = mysql_query($q_plan_sess);
            while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                $plan_name_sess = $row_plan_sess['Plan_Name'];
                $plan_price_sess1 = $row_plan_sess['Price'];
                if ($order_type_sess == "Bulk") {
                    $no_of_order_array = explode('|', $no_of_order_sess);
                    $no_of_order_id = count($no_of_order_array);
                    $no_of_order = 0;
                    for ($l = 0; $l < ($no_of_order_id - 1); $l++) {
                        $no_of_order = $no_of_order + $no_of_order_array[$l];
                    }
                    $nooforder = $no_of_order / 10;
                    $plan_price1 = $plan_price_sess1 * $nooforder;
                    $plan_price = number_format((float) $plan_price1, 2, '.', '');
                } else {
                    $plan_price = number_format((float) $plan_price_sess1, 2, '.', '');
                }

                $total_amount = $plan_price + $total_amount;
            }
        }
    }
    $plan_total = number_format((float) $total_amount, 2, '.', '');
    ?>
    <script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
    <script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
    <script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
    <script>
        $(document).ready(function () {
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


        // Payment Method Information    
        function paymentmethod(data) {
            if (data == "order_pp") {
                $('#billing_order').hide();
            } else {
                $('#billing_order').show();
            }
        }
        // Save Card information
        function savecard(data) {
            if (data == "card_pp") {
                $('#saved_card').hide();
            } else {
                $('#saved_card').show();
            }
        }

        function client_cart_form() {
            var form = $('#client_cart_form');
			 var payment_type = $("input[name='payment_option']:checked").val();
            if (payment_type == "order") {
            if (!form.valid())
                return false;
            $.ajax({
                url: "<?php echo site_url('Cart/cartsubmit') ?>",
                type: "POST",
                data: new FormData((form)[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "success") {
                        $("#order_fail_msg").hide();
                        $("#order_success_msg").show();
                        window.location.href = "<?php echo site_url('Client/placeorder'); ?>";
                    }
                    else {
                        $("#order_success_msg").hide();						
						$("#order_fail_msg").show();
                        $("#order_fail_msg").html(data);
                    }
                },
                error: function ()
                {
                }
            });
		}
		 if (payment_type == "order_pp") {
                $.ajax({
                    url: "<?php echo site_url('Cart/paypalcart') ?>",
                    type: "POST",
                    data: new FormData((form)[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        if (data == "fail") {
                            $("#order_success_msg").hide();
                            $("#user_exists_msg").hide();
                            $("#order_fail_msg").show();
                        }
                        else if (data == "exists") {
                            $("#order_success_msg").hide();
                            $("#order_fail_msg").hide();
                            $("#user_exists_msg").show();
                        } else {
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
        function delete_card(id) {
            var formdata = {
                card_id: id
            };
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Cart/delete_card') ?>",
                data: formdata,
                cache: false,
                success: function (html) {
                    $("#delete_client_card_form").html(html);
                }
            });
        }
		 // Special Char Disable query
        function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }
		
		
    </script>
    <!-- BEGIN FORM-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-folder-alt"></i>Billing Information
                            </div>
                            <div class="tools hidden-xs">
                                <h4 id="plantotal_head" class="margin-top-10"><strong>Total : $<span id="new_plantotal" class="plantotal"><?php echo $plan_total; ?></span></strong></h4>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal validate plan_submit_form" id="client_cart_form" method="POST">
                                <div class="form-wizard">
                                    <div class="form-body">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li>
                                                <a href="#taborder2" data-toggle="tab" class="step">
                                                    <span class="number"> 1 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i>Plan Instructions 
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#taborder3" data-toggle="tab" class="step active">
                                                    <span class="number"> 2 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Billing Information 
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success">
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="taborder2">
                                                <div class="portlet-body form">
                                                    <div class="form-body">
                                                        <h3 class="block">Provide your plan details</h3>
                                                        <div class="form-group">
                                                            <h3 class="block" style="padding-top: 10px; padding-bottom: 10px;">HERE'S HOW OUR TITLE ORDERING PROCESS WORKS:</h3>
                                                            <ul style="color: #002040;">
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

                                                    <div class="form-body" id="tabcontent" style="display:none">
                                                        <div class="tabbable-custom nav-justified">
                                                            <ul class="nav nav-tabs nav-justified">
                                                                <li style="display:none">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="tab-pane" id="taborder3">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div id="order_success_msg" class="alert alert-success" style="display:none;">Plan details submitted successfully.</div>
                                                        <div id="order_fail_msg" class="alert alert-danger" style="display:none;"></div>
                                                    </div>
                                                </div>
                                                <h3 class="block">Provide your billing and credit card or Paypal details</h3>
                                                <div class="form-group">
                                                    <div class="col-md-3">
                                                        <h4 class="block">Total Amount : $<span class="selected_new_total_amount" id="selected_new_total_amount"><?php echo $plan_total; ?></span></h4>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="<?php echo $plan_total; ?>" name="total_amount" id="total_amount">
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">Payment Options 
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-3">
                                                        <label>
                                                            <input type="radio" name="payment_option" value="order" onclick="paymentmethod(this.value)" checked>
                                                            <img src="<?php echo site_url('assets/global/img/card1.png') ?>" border="0" style="width:160px"/>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>
                                                            <input type="radio" name="payment_option" value="order_pp" onclick="paymentmethod(this.value)">
                                                            <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer">
                                                        </label>
                                                    </div>

                                                </div>
                                                <!-- New Card and Save card Design start here-->
                                                <div class="row" id="billing_order">
                                                    <div class="col-md-12">
                                                        <div class="tabbable tabbable-custom tabbable-noborder">
                                                            <ul class="nav nav-tabs" id="tabs">
                                                                <li class="active" onclick="client_tabopen('#navs', $(this).index())">
                                                                    <a href="#tab_1_1" data-toggle="tab">
                                                                        Saved Card </a>
                                                                </li>
                                                                <li onclick="client_tabopen('#navs', $(this).index())">
                                                                    <a href="#tab_1_2" data-toggle="tab">
                                                                        New Credit Card</a>
                                                                </li>
                                                            </ul>

                                                            <div class="tab-content">
                                                                <div class="tab-pane active fontawesome-demo" id="tab_1_1">
                                                                    <?php
                                                                    $client_id = $this->session->userdata('client_id');
                                                                    $card_data = array(
                                                                        'User_id' => $client_id,
                                                                        'Status' => 1
                                                                    );
                                                                    $this->db->where($card_data);
                                                                    $q_cards = $this->db->get('tbl_cards');
                                                                    $count_cards = $q_cards->num_rows();
                                                                    if ($count_cards > 0) {
                                                                        ?>
                                                                        <div id="savecard_info">
                                                                            <div class="form-group">
                                                                                <?php
                                                                                foreach ($q_cards->result() as $row_cards) {
                                                                                    $Card_Id = $row_cards->Id;
                                                                                    $Card_Type = $row_cards->Card_Type;
                                                                                    $Card_Number = $row_cards->Card_Number;
                                                                                    $Card_Holder_Name = $row_cards->Card_Holder_Name;
                                                                                    ?>
                                                                                    <div class="col-md-4">
                                                                                        <label>
                                                                                            <input type="radio" name="saved_card_no" id="saved_card_no" value="<?php echo $Card_Id; ?>" checked>
                                                                                            <?php
                                                                                            if ($Card_Type == "American") {
                                                                                                ?>
                                                                                                <img src="<?php echo site_url('assets/global/img/american.png') ?>" style="width:60px;" />
                                                                                            <?php } ?>
                                                                                            <?php
                                                                                            if ($Card_Type == "Visa") {
                                                                                                ?>
                                                                                                <img src="<?php echo site_url('assets/global/img/visa.png') ?>" style="width:60px;" />
                                                                                            <?php } ?>
                                                                                            <?php
                                                                                            if ($Card_Type == "Master") {
                                                                                                ?>
                                                                                                <img src="<?php echo site_url('assets/global/img/mastercard.png') ?>" style="width:60px;" />
                                                                                            <?php } ?>
                                                                                            <?php
                                                                                            if ($Card_Type == "Discover") {
                                                                                                ?>
                                                                                                <img src="<?php echo site_url('assets/global/img/discover.png') ?>" style="width:60px;" />
                                                                                            <?php } ?>
                                                                                            <span><?php echo $Card_Holder_Name; ?></span> 
                                                                                            <span><?php
                                                                                                $first_two_digit = substr($Card_Number, 0, 2);
                                                                                                echo $first_two_digit . 'XX-XXXX-XXXX-' . substr($Card_Number, -4);
                                                                                                ?></span>  
                                                                                            <a class="btn btn-xs black" href="#client_delete_card_model" data-toggle="modal" onclick="delete_card('<?php echo $Card_Id; ?>')">
                                                                                                <i style="cursor:pointer;color:#002040;" class="fa fa-close"></i>
                                                                                            </a>

                                                                                        </label>                                                                                                                                                       
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-md-2 control-label">Security Code <span class="required"> *</span></label>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group form-md-line-input has-info">
                                                                                        <input type="password" class="form-control input-sm" style="width: 227px;" name="saved_securitycode" id="saved_securitycode" data-validate="required,number" data-message-required="Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                                                    </div>
                                                                                </div>
                                                                                <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group form-md-line-input has-info">
                                                                                        <input type="text" class="form-control input-sm" style="width: 227px;" name="saved_zipcode" id="saved_zipcode" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Enter Billing Zipcode">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    } else {
                                                                        echo "Saved Cards Not Found.";
                                                                    }
                                                                    ?>
                                                                </div>   
                                                                <div class="tab-pane" id="tab_1_2">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-2">Card Holder Name <span class="required" style="margin-left:-4px;">
                                                                                * </span>
                                                                        </label>                                       
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-md-line-input has-info">
                                                                                <input type="text" class="form-control input-sm" style="width:227px;" id="Card_Holder_Name" name="Card_Holder_Name" autocomplete="off" data-validate="required" data-message-required="Enter Holder Name" onkeypress="return alpha(event)"> 
                                                                            </div>
                                                                        </div>

                                                                        <label class="control-label col-md-2">Card Number 
                                                                            <span class="required"> * </span>
                                                                        </label>
                                                                        <div class="col-md-3">                                           
                                                                            <div class="form-group form-md-line-input has-info">
                                                                                <input type="text" class="form-control input-sm" style="width: 227px;" id="Card_Number" name="Card_Number" autocomplete="off" data-validate="required,number" maxlength="16" data-message-required="Enter Card Number">
                                                                            </div>
                                                                        </div>                                                                  
                                                                    </div>

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
                                                                        <label class="col-md-2 control-label">Security Code <span class="required"> *</span></label>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-md-line-input has-info">
                                                                                <input type="password" class="form-control input-sm" style="width: 227px;" name="securitycode" id="securitycode" data-validate="required,number" data-message-required="Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                                            </div>
                                                                        </div>
                                                                        <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-md-line-input has-info">
                                                                                <input type="text" class="form-control input-sm" style="width: 227px;" name="Zip_Code" id="Zip_Code" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Enter Billing Zipcode">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-1"></label>
                                                                            <div class="col-md-6">
                                                                                <div class="checkbox-list" style="padding-left: 30px;" >
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
                                                <!-- New Card and Save card Design End here-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">                           
                                        <div class="row" style="float: right; width: 97%; margin-top: -53px; opacity: 0.99;">
                                            <div class="pull-right" style="float: right; margin-right: 11px;">
                                                <a href="javascript:;" class="btn default button-previous">
                                                    <i class="m-icon-swapleft"></i> Back 
                                                </a>
                                                <a href="javascript:;" class="btn blue button-next">
                                                    Continue <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                                <a class="btn blue button-submit" onclick="client_cart_form()">
                                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div style="background-color:#f5f5f5">
                                <div class="col-md-offset-8">                                           
                                    <img style="height: 62px; margin-top: -20px; margin-left: -4px;" src="<?php echo site_url('assets/global/img/secure.png') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM-->
			<div id="paypal_div"></div>
        </div>
    </div>

    <!-- Delete Order Popup Start Here -->

    <div id="client_delete_card_model" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Delete Card</h4>
                </div>
                <form role="form" id="delete_client_card_form" method="post" class="form-horizontal" name="delete_client_card_form">

                </form>
            </div>
        </div>
    </div>

    <!-- Delete Order Popup End Here -->

    <?php
} else {
    redirect('Client/newplan');
}
?>