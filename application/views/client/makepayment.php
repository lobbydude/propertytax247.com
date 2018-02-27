<?php
$plan_id = $this->uri->segment(3);
$this->db->where('Plan_Id', $plan_id);
$q_plan = $this->db->get('tbl_plan');
foreach ($q_plan->result() as $row_plan) {
    $plan_name = $row_plan->Plan_Name;
    $no_of_order = $row_plan->No_Of_Order;
    $plan_price = $row_plan->Price;
    $order_type = $row_plan->Type;
}
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#make_pay_amt').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#make_card_name').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#make_card_number').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#make_securitycode').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#make_zipcode').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
    });
    function paymentmethod(data) {
        if (data == "order_pp") {
            $('#billing_order').hide();
        } else {
            $('#billing_order').show();
        }
    }

    $(document).ready(function () {
        $('#client_payment_submit_form').submit(function (e) {
            e.preventDefault();
            var form = $('#client_payment_submit_form');
            var payment_type = $("input[name='make_payment_option']:checked").val();
            if (payment_type == "order") {
                if (!form.valid())
                    return false;
                $('html,body').animate({scrollTop: $("#client_payment_submit_form").offset().top}, 'slow');
                $.ajax({
                    url: "<?php echo site_url('Cart/cart_makepayment') ?>",
                    type: "POST",
                    data: new FormData((form)[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        if (data == "success") {
                            $('#payment_error_msg').hide();
                            $('#payment_success_msg').modal('show', {backdrop: 'static'});
                        }
                        else {
                            $('#payment_success_msg').hide();
                            $('#payment_error_msg').show();
                            $('#payment_error_msg').html(data);
                        }
                    },
                    error: function ()
                    {
                    }
                });
            }
            if (payment_type == "order_pp") {
                $.ajax({
                    url: "<?php echo site_url('Cart/paypal_makepayment') ?>",
                    type: "POST",
                    data: new FormData((form)[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        $('#make_paypal_div').html(data);
                        $('#make_paypal_form').submit();
                    },
                    error: function ()
                    {
                    }
                });
            }
        });
    });
	
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
</script>

<!-- BEGIN FORM-->

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-folder-alt"></i>Make Payment
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal validate plan_submit_form" id="client_payment_submit_form" method="POST">
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps" style="display:none"></ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="taborder2">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div id="payment_error_msg" class="alert alert-danger" style="display:none;"></div>
                                                </div>
                                            </div>
                                            <h4 class="block"><strong>Selected Plan : <span class="planname"><?php echo $plan_name . " / " . $no_of_order . " orders at $" . $plan_price; ?></span></strong></h4>
                                            <h4 class="block">Provide your billing and credit card or paypal details</h4>
                                            <div class="row">
                                                <input type="hidden" name="make_plan_id" id="make_plan_id" value="<?php echo $plan_id; ?>">
                                                <input type="hidden" name="make_order_type" id="make_order_type" value="<?php echo $order_type; ?>">
                                                <input type="hidden" name="make_no_of_order" id="make_no_of_order" value="<?php echo $no_of_order; ?>">
                                                <input type="hidden" name="make_plan_amt" id="make_plan_amt" value="<?php echo $plan_price; ?>">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Enter the Amount 
                                                            <span class="required"> * </span>
                                                        </label>                                       
                                                        <div class="col-md-4">
                                                            <div class="form-group form-md-line-input has-info">
                                                                <input type="text" class="form-control input-sm" placeholder="Amount" name="make_pay_amt"  id="make_pay_amt" autocomplete="off" data-validate="required,number">
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Payment Options 
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="radio" name="make_payment_option" value="order" onclick="paymentmethod(this.value)" checked>
                                                        <img src="<?php echo site_url('assets/global/img/card1.png') ?>" border="0" style="width:160px"/>
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="radio" name="make_payment_option" value="order_pp" onclick="paymentmethod(this.value)">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row" id="billing_order">
                                                <div class="col-md-12">
                                                    <div class="tabbable tabbable-custom tabbable-noborder">
                                                        <ul class="nav nav-tabs" id="tabs">
                                                            <li class="active">
                                                                <a href="#tab_card_1" data-toggle="tab">
                                                                    Saved Card 
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#tab_card_2" data-toggle="tab">
                                                                    New Credit Card
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content">
                                                            <div class="tab-pane active fontawesome-demo" id="tab_card_1">
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
                                                                                        <input type="radio" name="make_saved_card_no" id="make_saved_card_no" value="<?php echo $Card_Id; ?>">
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
                                                                                    <input type="password" class="form-control input-sm" style="width: 227px;" name="make_saved_securitycode" id="make_saved_securitycode" data-validate="required,number" data-message-required="Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                                                </div>
                                                                            </div>
                                                                            <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group form-md-line-input has-info">
                                                                                    <input type="text" class="form-control input-sm" style="width: 227px;" name="make_saved_zipcode" id="make_saved_zipcode" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Enter Billing Zipcode">
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
                                                            <div class="tab-pane" id="tab_card_2">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-2">Card Holder Name <span class="required" style="margin-left:-4px;">
                                                                            * </span>
                                                                    </label>                                       
                                                                    <div class="col-md-3">
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <input type="text" class="form-control input-sm" style="width:227px;" id="Make_Card_Holder_Name" name="Make_Card_Holder_Name" autocomplete="off" data-validate="required" data-message-required="Enter Holder Name"> 
                                                                        </div>
                                                                    </div>

                                                                    <label class="control-label col-md-2">Card Number 
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-3">                                           
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <input type="text" class="form-control input-sm" style="width: 227px;" id="Make_Card_Number" name="Make_Card_Number" autocomplete="off" data-validate="required,number" maxlength="16" data-message-required="Enter Card Number">
                                                                        </div>
                                                                    </div>                                                                  
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-2">Expiration Month <span class="required" style="margin-left:-4px;">
                                                                            * </span>
                                                                    </label>                                       
                                                                    <div class="col-md-3">
                                                                        <select class="form-control select2me" autocomplete="off" name="Make_Expired_Month" id="Make_Expired_Month">
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

                                                                    <label class="control-label col-md-2">Expiration Year 
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-3">                                           
                                                                        <select class="form-control select2me" autocomplete="off" name="Make_Expired_Year" id="Make_Expired_Year">
                                                                            <?php
                                                                            $current_year = date('Y');
                                                                            for ($y = 0; $y < 10; $y++) {
                                                                                $year = $current_year + $y;
                                                                                ?>
                                                                                <option value="<?php echo $year; ?>" <?php
                                                                                if ($current_year == $year) {
                                                                                    echo "selected=selected";
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
                                                                            <input type="password" class="form-control input-sm" style="width: 227px;" name="Make_Securitycode" id="Make_Securitycode" data-validate="required,number" data-message-required="Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                                        </div>
                                                                    </div>
                                                                    <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <input type="text" class="form-control input-sm" style="width: 227px;" name="Make_Zip_Code" id="Make_Zip_Code" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Enter Billing Zipcode">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-10 col-md-2">  
                                            <input type="submit" value="Submit" class="btn blue">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END FORM-->
    <div id="make_paypal_div"></div>
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
	
<div class="modal fade" id="payment_success_msg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#3598dc;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Success!</h4>
            </div>
            <div class="modal-body">
                <p>Your payment has been made successfully.<br>
                    Please <b>CLOSE</b> this window and click <b>REFRESH</b> button in place order page.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal" onclick="window.close()">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

