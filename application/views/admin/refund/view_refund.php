<?php
$refund_id = $this->uri->segment(3);
$get_refund = array(
    'R_Id' => $refund_id,
    'Status' => 1
);
$this->db->where($get_refund);
$q_refund = $this->db->get('tbl_refund');
foreach ($q_refund->result() as $row_refund) {
    $User_Id = $row_refund->User_Id;
    $unique_id = $row_refund->Unique_No;
    $txn_id = $row_refund->Txn_Id;
    $get_user = array(
        'User_Id' => $User_Id
    );
    $this->db->where($get_user);
    $q_user = $this->db->get('tbl_user');
    foreach ($q_user->result() as $row_user) {
        $Username = $row_user->Username;
    }
    $plan_id = $row_refund->Plan_Id;
    $get_plan = array(
        'Plan_Id' => $plan_id
    );
    $this->db->where($get_plan);
    $q_plan = $this->db->get('tbl_plan');
    foreach ($q_plan->result() as $row_plan) {
        $plan_name = $row_plan->Plan_Name;
        $order_type = $row_plan->Type;
        $plan_price1 = $row_plan->Price;
        $plan_price = number_format((float) $plan_price1, 2, '.', '');
    }
    $Reason = $row_refund->Reason;
    $Refund_Status = $row_refund->Refund_Status;
    $Amount = $row_refund->Amount;
    $Remarks = $row_refund->Remarks;
}
$get_txn_paid = array(
    'User_Id' => $User_Id,
    'Mode' => 'Transfer',
    'Status' => 1
);
$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn_paid);
$q_txn_paid = $this->db->get('tbl_transaction');
$result_txn_paid = $q_txn_paid->result();
$paid_amount = $result_txn_paid[0]->Paid_Amt;
$get_txn_refund = array(
    'User_Id' => $User_Id,
    'Mode' => 'Refund',
    'Status' => 1
);
$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn_refund);
$q_txn_refund = $this->db->get('tbl_transaction');
$result_txn_refund = $q_txn_refund->result();
$refund_amount = $result_txn_refund[0]->Paid_Amt;
$total_paid_amount = $paid_amount - $refund_amount;
$get_account = array(
    'User_Id' => $User_Id,
    'Status' => 1
);
$this->db->select_sum('Total_Amount');
$this->db->where($get_account);
$q_acc = $this->db->get('tbl_account');
$result_acc = $q_acc->result();
$total_amount = $result_acc[0]->Total_Amount;
$balance1 = $total_paid_amount - $total_amount;
$balance = number_format((float) $balance1, 2, '.', '');

$get_txn = array(
    'txn_id' => $txn_id,
    'User_Id' => $User_Id
);
$this->db->where($get_txn);
$q_txn = $this->db->get('tbl_transaction');
foreach ($q_txn->result() as $row_txn) {
    $transaction_id = $row_txn->Transaction_Id;
}
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#refund_response_card_name').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#refund_response_card_number').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#refund_response_securitycode').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
        $('#refund_response_zipcode').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        });
    });
    function admin_refund_form() {
        var form = $('#admin_refund_form');
        var payment_type = $("input[name='payment_option']:checked").val();
        if (payment_type == "order") {
            if (!form.valid())
                return false;
            $.ajax({
                url: "<?php echo site_url('Admin/refund_response') ?>",
                type: "POST",
                data: new FormData((form)[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "success") {
                        $('#refund_response_fail').hide();
                        $('#refund_response_payment').hide();
                        $('#refund_response_success').show();
                    }
                    else if (data == "fail") {
                        $('#refund_response_success').hide();
                        $('#refund_response_payment').hide();
                        $('#refund_response_fail').show();
                    } else {
                        $('#refund_response_fail').hide();
                        $('#refund_response_success').hide();
                        $('#refund_response_payment').show();
                        $('#refund_response_payment').html(data);
                    }

                },
                error: function ()
                {
                }
            });
        }
        if (payment_type == "order_pp") {
            $.ajax({
                url: "<?php echo site_url('Admin/refund_paypal_response') ?>",
                type: "POST",
                data: new FormData((form)[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                     if (data == "success") {
                        $('#refund_response_fail').hide();
                        $('#refund_response_payment').hide();
                        $('#refund_response_success').show();
                    }
                    else if (data == "fail") {
                        $('#refund_response_success').hide();
                        $('#refund_response_payment').hide();
                        $('#refund_response_fail').show();
                    } else {
                        $('#refund_response_fail').hide();
                        $('#refund_response_success').hide();
                        $('#refund_response_payment').show();
                        $('#refund_response_payment').html(data);
                    }
                },
                error: function ()
                {
                }
            });
        }
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
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-folder-alt"></i>Refund
                        </div>
                        <div class="tools hidden-xs" style="width:15%">
                            <h4 id="plantotal_head"><strong style="padding-top: 50px;">Txn Id : <?php echo $transaction_id; ?></strong></h4>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal validate plan_submit_form" id="admin_refund_form" method="POST">
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#taborder2" data-toggle="tab" class="step">
                                                <span class="number"> 1 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Refund Details 
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
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="taborder2">
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2"><strong>Username : </strong></label>
                                                            <div class="col-md-4  margin-top-10">
                                                                <?php echo $Username; ?>
                                                            </div>
                                                            <label class="control-label col-md-2"><strong>Plan Name : </strong></label>
                                                            <div class="col-md-4  margin-top-10">
                                                                <?php echo $plan_name . " ($order_type)"; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2"><strong>Reason : </strong></label>
                                                            <div class="col-md-4  margin-top-10">
                                                                <?php echo $Reason; ?>
                                                            </div>

                                                            <label class="control-label col-md-2"><strong>Status : </strong></label>
                                                            <div class="col-md-4  margin-top-10">
                                                                <?php echo $Refund_Status; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2"><strong>Plan Price : </strong></label>
                                                            <div class="col-md-4  margin-top-10">
                                                                <?php echo "$ " . $plan_price; ?>
                                                            </div>
                                                            <label class="control-label col-md-2"><strong>Current Balance : </strong></label>
                                                            <div class="col-md-4  margin-top-10">
                                                                <?php echo "$ " . $balance; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Refund Amount ($) 
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <div class="form-group form-md-line-input has-info">
                                                                    <input type="text" class="form-control input-sm" name="refund_response_amount" id="refund_response_amount" data-validate="required,number" data-message-required="Please Enter Amount." value="<?php echo $Amount; ?>">
                                                                </div>
                                                            </div>
                                                            <label class="control-label col-md-2">Remarks <span class="required"> * </span> </label>                                                                                                
                                                            <div class="col-md-4">
                                                                <div class="form-group form-md-line-input has-info">
                                                                    <input type="text" class="form-control input-sm" name="refund_response_remarks" id="refund_response_remarks" data-validate="required" data-message-required="Please Enter Remarks." value="<?php echo $Remarks ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <div class="checkbox-list">
                                                                    <input type="checkbox" name="refund_response_tc" value="yes" data-validate="required" data-merefund_response_tcssage-required="Please Agree The Terms and Conditions" autocomplete="off"/> I have read and agree to the <a href="http://propertyreport247.com/term-condition.html" target="_blank">term and condition</a> <span class="required"> * </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-body" id="tabcontent" style="display:none">
                                                    <div class="tabbable-custom nav-justified">
                                                        <ul class="nav nav-tabs nav-justified">
                                                            <li id="tab" style="display:none">
                                                                <a href="#tab_content" data-toggle="tab" class="col-md-11">
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="tab-pane" id="taborder3">
                                            <input type="hidden" value="<?php echo $refund_id; ?>" name="refund_response_refundid" id="refund_response_refundid">
                                            <input type="hidden" value="<?php echo $plan_id; ?>" name="refund_response_planid" id="refund_response_planid">
                                            <input type="hidden" value="<?php echo $User_Id; ?>" name="refund_response_userid" id="refund_response_userid">
                                            <input type="hidden" value="<?php echo $unique_id; ?>" name="refund_response_unique_id" id="refund_response_unique_id">
                                            <input type="hidden" value="<?php echo $txn_id; ?>" name="refund_response_txnid" id="refund_response_txnid">

                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div id="refund_response_success" class="alert alert-success" style="display:none;">Refund amount transfered successfully.</div>
                                                    <div id="refund_response_fail" class="alert alert-danger" style="display:none;">Failed to transfer amount.</div>
                                                    <div id="refund_response_payment" class="alert alert-danger" style="display:none;"></div>
                                                </div>
                                            </div>
                                            <h3 class="block">Provide your billing and credit card or Paypal details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Payment Options 
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="radio" name="payment_option" value="order" onclick="paymentmethod(this.value)" autocomplete="off" checked>
                                                        <img src="<?php echo site_url('assets/global/img/card1.png') ?>" border="0" style="width:160px"/>
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="radio" name="payment_option" value="order_pp" onclick="paymentmethod(this.value)" autocomplete="off">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" style="cursor:pointer">
                                                    </label>
                                                </div>
                                            </div>    

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
                                                                <div id="savecard_info">
                                                                    <div class="form-group">
                                                                        <?php
                                                                        $admin_id = $this->session->userdata('admin_id');
                                                                        $card_data = array(
                                                                            'Admin_Id' => $admin_id,
                                                                            'Status' => 1
                                                                        );
                                                                        $this->db->where($card_data);
                                                                        $q_cards = $this->db->get('tbl_cards_admin');
                                                                        $count_cards = $q_cards->num_rows();
                                                                        if ($count_cards > 0) {
                                                                            foreach ($q_cards->result() as $row_cards) {
                                                                                $Card_Type = $row_cards->Card_Type;
                                                                                $Card_Number = $row_cards->Card_Number;
                                                                                $Card_Holder_Name = $row_cards->Card_Holder_Name;
                                                                                ?>
                                                                                <div class="col-md-4">
                                                                                    <label>
                                                                                        <input type="radio" name="saved_card_no" id="saved_card_no">
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
                                                                                        <i style="cursor:pointer;color:#002040;" class="fa fa-close"> </i>
                                                                                    </label>                                                                                                                                                       
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

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
                                                                                <input type="text" class="form-control input-sm" style="width: 227px;" name="zipcode" id="zipcode" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Enter Billing Zipcode">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>   
                                                            <div class="tab-pane" id="tab_1_2">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-2">Card Holder Name <span class="required" style="margin-left:-4px;">
                                                                            * </span>
                                                                    </label>                                       
                                                                    <div class="col-md-3">
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <input type="text" class="form-control input-sm" id="Card_Holder_Name" name="Card_Holder_Name" autocomplete="off" data-validate="required" data-message-required="Enter Holder Name"> 
                                                                        </div>
                                                                    </div>

                                                                    <label class="control-label col-md-2">Card Number 
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-3">                                           
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <input type="text" class="form-control input-sm" id="Card_Number" name="Card_Number" autocomplete="off" data-validate="required,number" maxlength="16" minlength="16"  data-message-required="Enter Card Number">
                                                                        </div>
                                                                    </div>                                                                  
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-2">Expiration Month <span class="required">
                                                                            * </span>
                                                                    </label>                                       
                                                                    <div class="col-md-3">
                                                                        <select class="form-control select2me" autocomplete="off" name="Expired_Month" id="Expired_Month">
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
                                                                        <select class="form-control select2me" autocomplete="off" name="Expired_Year" id="Expired_Year">
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
                                                                            <input type="password" class="form-control input-sm" name="securitycode" id="securitycode" data-validate="required,number" data-message-required="Enter Card Security Code." autocomplete="off"  maxlength="3">
                                                                        </div>
                                                                    </div>
                                                                    <label class="col-md-2 control-label">Billing Zip Code <span class="required"> *</span></label>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group form-md-line-input has-info">
                                                                            <input type="text" class="form-control input-sm" name="Zip_Code" id="Zip_Code" autocomplete="off" data-validate="required,number" maxlength="6" data-message-required="Enter Billing Zipcode">
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
                                        <div class="col-md-offset-9 col-md-3">
                                            <a href="javascript:;" class="btn default button-previous">
                                                <i class="m-icon-swapleft"></i> Back 
                                            </a>
                                            <a href="javascript:;" class="btn blue button-next">
                                                Continue <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                            <a class="btn blue button-submit" onclick="admin_refund_form()">
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
    </div>
</div>
