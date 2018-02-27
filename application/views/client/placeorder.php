<?php
$client_id = $this->session->userdata('client_id');
//$this->db->group_by('Plan_Id');
$get_transaction = array(
    'User_Id' => $client_id,
    'Status' => 1
);
$this->db->where($get_transaction);
$q_transaction = $this->db->get('tbl_transaction');
$count_transaction = $q_transaction->num_rows();
$plan_total = number_format((float) 0, 2, '.', '');

$get_txn_paid = array(
    'User_Id' => $client_id,
    'Mode' => 'Transfer',
    'Status' => 1
);
$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn_paid);
$q_txn_paid = $this->db->get('tbl_transaction');
$result_txn_paid = $q_txn_paid->result();
$paid_amount = $result_txn_paid[0]->Paid_Amt;
$get_txn_refund = array(
    'User_Id' => $client_id,
    'Mode' => 'Refund',
    'Status' => 1
);
$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn_refund);
$q_txn_refund = $this->db->get('tbl_transaction');
$result_txn_refund = $q_txn_refund->result();
$refund_amount = $result_txn_refund[0]->Paid_Amt;
$total_paid_amount = $paid_amount - $refund_amount;

$this->db->select_sum('Order_Amount');
$this->db->where($get_transaction);
$q_acc = $this->db->get('tbl_billing');
$result_acc = $q_acc->result();
$total_amount = $result_acc[0]->Order_Amount;
$balance1 = $total_paid_amount - $total_amount;
$balance = number_format((float) $balance1, 2, '.', '');

$q_cart = $this->db->query("SELECT SUM(No_of_Order) as OrderNo,Plan_Id,Txn_Id,Cart_Id,Unique_no,Order_Type FROM `tbl_cart` WHERE User_Id='$client_id' AND Status=1 AND Cart_Status!='Refunded' GROUP BY Plan_Id");
$count_cart = $q_cart->num_rows();
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>

<script>
    function tabopen(tablist1, count) {
        var arr = tablist1.split(',');
        var tablist = arr[0];
        var no_of_order = arr[1];
        var k = arr[2];
        var plan_id = arr[3];
        if (tablist1 != "") {
            for (var m = 1; m <= count; m++) {
                var tabname = "#tab" + m;
                if (tablist === tabname) {
                    $('.tab-content').show();
                    $(tablist).show();
                    $(tablist).addClass("active");
                    $(tabname + "_content").show();
                    $(tabname + "_content").addClass("active");
                    var plan_name = $(tabname + ".active").text();
                    $('.planname').html(plan_name);
                } else {
                    $(tabname).hide();
                    $(tabname + "_content").hide();
                    $(tabname + "_content").removeClass("active");
                }
            }

            //    $('.tab-content').show();
            //  $(tablist + "_content").show();
            //  $(tablist + "_content").addClass("active");
            var plantotal = 0;
            var plansubtotal;
            for (var l = 1; l <= no_of_order; l++) {
                if ($(tablist + '_content_order_' + l).css('display') != 'none') {
                    plansubtotal = $('#subtotal' + k + l).text();
                    plantotal = plantotal + parseInt(plansubtotal);
                }
            }
            $('#tabcontent').show();
            $('.plantotal').html(plantotal.toFixed(2));
            $('.kelement').val(k);
            $('.address_count').val('1');
            $('.plan_id').val(plan_id);
            $('.total_amount').val(plantotal.toFixed(2));
            var avail_bal = $('#bal_amt').val();
            var total_amt = $('.plantotal').html();
            var act_bal = parseInt(avail_bal) - parseInt(total_amt);
            $('#balance').html(act_bal.toFixed(2));
            if (parseInt(total_amt) > parseInt(avail_bal)) {
                var plan_id = $('.plan_id').val();
                var url = 'http://localhost:82/propertytax247/Client/makepayment/' + plan_id;
                $('#redirect_url').attr('href', url);
                $('#less_balance').modal('show', {backdrop: 'static'});
            }
        } else {
            $('#tabcontent').hide();
            var plantotal = 0;
            $('.plantotal').html(plantotal.toFixed(2));
            var avail_bal = $('#bal_amt').val();
            var total_amt = $('.plantotal').html();
            var act_bal = parseInt(avail_bal) - parseInt(total_amt);
            $('#balance').html(act_bal.toFixed(2));
        }
    }

    function tabclose(tabname, no_of_order, plan_id, k) {
        $('#' + tabname).hide();
        var plantotal = 0;
        var plansubtotal;
        for (var l = 1; l <= no_of_order; l++) {
            if ($('#tab' + k + '_content_order_' + l).css('display') != 'none') {
                plansubtotal = $('#subtotal' + k + l).text();
                plantotal = plantotal + parseInt(plansubtotal);
            }
        }
        $('#tabcontent').show();
        $('.plantotal').html(plantotal.toFixed(2));
        $('.kelement').val(k);
        $('.address_count').val('1');
        $('.plan_id').val(plan_id);
        $('.total_amount').val(plantotal.toFixed(2));
        var avail_bal = $('#bal_amt').val();
        var total_amt = $('.plantotal').html();
        var act_bal = parseInt(avail_bal) - parseInt(total_amt);
        $('#balance').html(act_bal.toFixed(2));
    }

    function showCounty(sel, no) {
        var statewise_id = sel.options[sel.selectedIndex].value;
        if (statewise_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Signup/fetch_county') ?>",
                data: "statewise_id=" + statewise_id,
                cache: false,
                success: function (msg) {
                    $("#countylist" + no).html(msg);
                }
            });
        }
    }

    function addmore(no_of_order, divname, button, k, address_count) {
        $(button).hide();
        $(divname).show();
        var plantotal = 0;
        var plansubtotal;
        for (var l = 1; l <= no_of_order; l++) {
            if ($('#tab' + k + '_content_order_' + l).css('display') != 'none') {
                plansubtotal = $('#subtotal' + k + l).text();
                plantotal = plantotal + parseInt(plansubtotal);
            }
        }
        $('.plantotal').html(plantotal.toFixed(2));
        $('.address_count').val(address_count);
        $('.total_amount').val(plantotal.toFixed(2));
        var avail_bal = $('#bal_amt').val();
        var total_amt = $('.plantotal').html();
        var act_bal = parseInt(avail_bal) - parseInt(total_amt);
        $('#balance').html(act_bal.toFixed(2));
        if (parseInt(total_amt) > parseInt(avail_bal)) {
            var plan_id = $('.plan_id').val();
            var url = 'http://localhost:82/propertytax247/Client/makepayment/' + plan_id;
            $('#redirect_url').attr('href', url);
            $('#less_balance').modal('show', {backdrop: 'static'});
        }
    }
    $(document).ready(function () {
        $('#client_placeorder_submit_form').submit(function (e) {
            e.preventDefault();
            var form = $('#client_placeorder_submit_form');
            if (!form.valid()) {
                jQuery('form:contains("validate-has-error")').css("display:block");
                return false;
            }
            var total_amount = parseInt($('#total_amount').val());
            var balance_amount = parseInt($('#bal_amt').val());
            if (total_amount <= balance_amount) {
                $('html,body').animate({scrollTop: $("#client_placeorder_submit_form").offset().top}, 'slow');
                $.ajax({
                    url: "<?php echo site_url('Client/cart') ?>",
                    type: "POST",
                    data: new FormData((form)[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data)
                    {
                        if (data == "success") {
                            $('#order_fail_msg').hide();
                            $('#order_success_msg').show();
                            var redirect_url = "http://localhost:82/propertytax247/Client#tab_1_2";
                            window.location.href = redirect_url;
                        }
                        if (data == "fail") {
                            $('#order_success_msg').hide();
                            $('#order_fail_msg').show();
                        }
                    },
                    error: function ()
                    {
                    }

                });
            } else {
                $('#less_balance').modal('show', {backdrop: 'static'});
            }
        });

        $('#refresh_amt').on('click', function () {
            $('#refresh_div').load(location.href + ' #refresh_div div');
            //updateamount();
            var total_amt = $('.plantotal').html();
            var total_amount = parseInt(total_amt);
            var avail_bal = $('#bal_amt').val();
            var act_bal = parseInt(avail_bal) - parseInt(total_amt);
            $('#balance').html(act_bal.toFixed(2));
            $('.plantotal').html(total_amount.toFixed(2));
        });
    });
    function updateamount() {
        var total_amt = $('.plantotal').html();
        var total_amount = parseInt(total_amt);
        var avail_bal = $('#bal_amt').val();
        var act_bal = parseInt(avail_bal) - parseInt(total_amt);
        $('#balance').html(act_bal.toFixed(2));
        $('.plantotal').html(total_amount.toFixed(2));
    }
    /*Special Character Disable Query*/                 
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
                        <div class="caption" style="padding-top:20px;">
                            <i class="icon-folder-alt"></i>Place Order
                        </div>
                        <div class="tools hidden-xs" style="width:70%">
                            <div id="refresh_div">
                                <div class="col-md-4">
                                    <h4 id="plantotal_head"><strong>Total Plan Amount : $<?php echo $balance; ?></strong></h4>
                                    <input type="hidden" value="<?php echo $balance; ?>" id="bal_amt" class="bal_amt">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 id="plantotal_head"><strong>Available Balance : $<span id="balance" class="balance"><?php echo $balance; ?></span></strong></h4>
                            </div>
                            <div class="col-md-4">
                                <h4 id="plantotal_head"><strong>Order Total Cost : $<span id="plantotal" class="plantotal"><?php echo $plan_total; ?></span></strong></h4>
                            </div>
                        </div>
                        <div class="tools margin-top-10">
                            <a class="reload" data-original-title="" title="" id="refresh_amt"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal validate plan_submit_form" id="client_placeorder_submit_form" method="POST">
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps" style="display:none"></ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="taborder2">
                                            <div class="form-group">
                                                <h3 class="block control-label">Choose your plan</h3>
                                            </div>
                                            <div class="portlet-body form">
                                                <input type="hidden" value="" class="kelement" name="kelement">
                                                <input type="hidden" value="" class="address_count" name="address_count">
                                                <input type="hidden" value="" class="plan_id" name="plan_id">
                                                <input type="hidden" value="" class="total_amount" name="total_amount" id="total_amount">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Report Credits You Selected <span class="required">
                                                            * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <select class="form-control select2me" name="add_plan" id="add_plan" onchange="tabopen($(this).val(),<?php echo $count_cart; ?>)" autocomplete="off" data-validate="required" data-message-required="Please Choose Plan.">
                                                            <option value=""> -- Select Plan -- </option>
                                                            <?php
                                                            $i = 1;
                                                            //$no_of_order=0;
                                                            if ($count_cart > 0) {
                                                                foreach ($q_cart->result() as $row_cart) {
                                                                    $plan_id = $row_cart->Plan_Id;
                                                                    $no_of_order = $row_cart->OrderNo;
                                                                    $Order_Type = $row_cart->Order_Type;
                                                                    $unique_no = $row_cart->Unique_no;

                                                                    $orderplacing_data = array(
                                                                        'Cart_Unique_no' => $unique_no,
                                                                        'Status' => 1
                                                                    );
                                                                    $this->db->where($orderplacing_data);
                                                                    $q_orderplacing = $this->db->get('tbl_order');
                                                                    $count_orderplacing = $q_orderplacing->num_rows();
                                                                    $no_order_in_placing = $no_of_order - $count_orderplacing;
                                                                    if ($no_order_in_placing > 0) {
                                                                        $get_plan = array(
                                                                            'Plan_Id' => $plan_id,
                                                                            'Status' => 1
                                                                        );
                                                                        $this->db->where($get_plan);
                                                                        $q_plan = $this->db->get('tbl_plan');
                                                                        $count_plan = $q_plan->num_rows();
                                                                        foreach ($q_plan->result() as $row_plan) {
                                                                            $plan_name = $row_plan->Plan_Name;
                                                                            $data_price = array(
                                                                                'Plan_Id' => $plan_id,
                                                                                'Product_Type' => 'Residential',
                                                                                'Status' => 1
                                                                            );
                                                                            $this->db->where($data_price);
                                                                            $q_price = $this->db->get('tbl_price');
                                                                            foreach ($q_price->result() as $row_price) {
                                                                                $price = $row_price->Price;
                                                                                ?>
                                                                                <option value="<?php echo "#tab" . $i . "," . $no_order_in_placing . ',' . $i . ',' . $plan_id ?>"><?php echo $plan_name . " ($Order_Type) / " . $no_order_in_placing . " orders"; ?></option>
                                                                                <?php
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-body" id="tabcontent" style="display:none">
                                                    <div class="tabbable-custom nav-justified">
                                                        <ul class="nav nav-tabs nav-justified">
                                                            <?php
                                                            $j = 1;
                                                            if ($count_cart > 0) {
                                                                foreach ($q_cart->result() as $row_cart) {
                                                                    $plan_id = $row_cart->Plan_Id;
                                                                    $no_of_order_tablist = $row_cart->OrderNo;
                                                                    $unique_no_tablist = $row_cart->Unique_no;
                                                                    $orderplace_tablist_data = array(
                                                                        'Cart_Unique_no' => $unique_no_tablist,
                                                                        'Status' => 1
                                                                    );
                                                                    $this->db->where($orderplace_tablist_data);
                                                                    $q_orderplace_tablist = $this->db->get('tbl_order');
                                                                    $count_orderplace_tablist = $q_orderplace_tablist->num_rows();
                                                                    $no_order_in_place_tablist = $no_of_order_tablist - $count_orderplace_tablist;
                                                                    if ($no_order_in_place_tablist > 0) {
                                                                        $get_plan = array(
                                                                            'Plan_Id' => $plan_id,
                                                                            'Status' => 1
                                                                        );
                                                                        $this->db->where($get_plan);
                                                                        $q_plan = $this->db->get('tbl_plan');
                                                                        $count_plan = $q_plan->num_rows();
                                                                        foreach ($q_plan->result() as $row_plan_tablist) {
                                                                            $plan_name_tablist = $row_plan_tablist->Plan_Name;
                                                                            ?>
                                                                            <li id="tab<?php echo $j; ?>" style="display:none">
                                                                                <a href="#tab<?php echo $j; ?>_content" data-toggle="tab" class="col-md-11">
                                                                                    <?php echo $plan_name_tablist . " / " . $no_order_in_place_tablist . " orders"; ?>
                                                                                </a>
                                                                            </li>
                                                                            <?php
                                                                            $j++;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                        <div class="tab-content" style="display: none">
                                                            <?php
                                                            $k = 1;
                                                            if ($count_cart > 0) {
                                                                foreach ($q_cart->result() as $row_cart) {
                                                                    $txn_id_tabcontent = $row_cart->Txn_Id;
                                                                    $plan_id_tabcontent = $row_cart->Plan_Id;
                                                                    $no_of_order_tabcontent = $row_cart->OrderNo;
                                                                    $unique_id_tabcontent = $row_cart->Unique_no;
                                                                    $cart_id_tabcontent = $row_cart->Cart_Id;

                                                                    $get_order_place_tabcontent = array(
                                                                        'Cart_Id' => $cart_id_tabcontent,
                                                                        'User_Id' => $client_id,
                                                                        'Cart_Unique_no' => $unique_id_tabcontent,
                                                                        'Status' => 1
                                                                    );
                                                                    $this->db->where($get_order_place_tabcontent);
                                                                    $q_order_place_tabcontent = $this->db->get('tbl_order');
                                                                    $count_order_place_tabcontent = $q_order_place_tabcontent->num_rows();
                                                                    $remaining_order = $no_of_order_tabcontent - $count_order_place_tabcontent;
                                                                    if ($remaining_order > 0) {
                                                                        $order_price_tabcontent = 0;
                                                                        $get_plan = array(
                                                                            'Plan_Id' => $plan_id,
                                                                            'Status' => 1
                                                                        );
                                                                        $this->db->where($get_plan);
                                                                        $q_plan = $this->db->get('tbl_plan');
                                                                        $count_plan = $q_plan->num_rows();
                                                                        foreach ($q_plan->result() as $row_plan_tabcontent) {
                                                                            $plan_name_tabcontent = $row_plan_tabcontent->Plan_Name;
                                                                            $data_residential_price = array(
                                                                                'Plan_Id' => $plan_id_tabcontent,
                                                                                'Product_Type' => 'Residential',
                                                                                'Status' => 1
                                                                            );
                                                                            $this->db->where($data_residential_price);
                                                                            $q_residential_price = $this->db->get('tbl_price');
                                                                            foreach ($q_residential_price->result() as $row_residential_price) {
                                                                                $residential_price = $row_residential_price->Price;
                                                                            }
                                                                            $data_commercial_price = array(
                                                                                'Plan_Id' => $plan_id_tabcontent,
                                                                                'Product_Type' => 'Commercial',
                                                                                'Status' => 1
                                                                            );
                                                                            $this->db->where($data_commercial_price);
                                                                            $q_commercial_price = $this->db->get('tbl_price');
                                                                            $count_commercial_price = $q_commercial_price->num_rows();
                                                                            if ($count_commercial_price == 0) {
                                                                                $commercial_price = 0;
                                                                            } else {
                                                                                foreach ($q_commercial_price->result() as $row_commercial_price) {
                                                                                    $commercial_price = $row_commercial_price->Price;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <div class="tab-pane" id="tab<?php echo $k; ?>_content" style="display:none">
                                                                                <?php
                                                                                $plan_subtotal = 0;
                                                                                for ($l = 1; $l <= $no_of_order_tabcontent; $l++) {
                                                                                    ?>
                                                                                    <div id="tab<?php echo $k; ?>_content_order_<?php echo $l; ?>" style="<?php
                                                                                    if ($l != 1) {
                                                                                        echo "display:none";
                                                                                    }
                                                                                    ?>">
                                                                                        <div class="portlet light">
                                                                                            <div class="portlet-title">
                                                                                                <div class="caption caption-md">
                                                                                                    <h4><strong>Address for Title Report #<?php echo $l; ?> :</strong></h4>
                                                                                                </div>
                                                                                                <div class="actions col-md-3">
                                                                                                    <div class="col-md-10">
                                                                                                        <input type="hidden" name="orderprice<?php echo $k . $l; ?>" id="orderprice<?php echo $k . $l; ?>" value="<?php echo $order_price_tabcontent; ?>">
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                                                                            <?php if ($l != 1) { ?>
                                                                                                                <span class='icon-close' onclick="tabclose('tab<?php echo $k; ?>_content_order_<?php echo $l; ?>',<?php echo $no_of_order_tabcontent . ',' . $plan_id_tabcontent . ',' . $k; ?>)" style="cursor:pointer; color:#00a63f; font-weight: bold;"></span>
                                                                                                            <?php }
                                                                                                            ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <input type="hidden" name="product_type<?php echo $k . $l; ?>" id="product_type<?php echo $k . $l; ?>" value="Residential"> 
                                                                                            <input type="hidden" name="order_number<?php echo $k . $l; ?>" id="order_number<?php echo $k . $l; ?>" value="<?php echo uniqid(); ?>"> 
                                                                                            <input type="hidden" name="txn_number<?php echo $k . $l; ?>" id="txn_number<?php echo $k . $l; ?>" value="<?php echo $txn_id_tabcontent; ?>"> 
                                                                                            <input type="hidden" name="unique_number<?php echo $k . $l; ?>" id="unique_number<?php echo $k . $l; ?>" value="<?php echo $unique_id_tabcontent; ?>"> 
                                                                                            <input type="hidden" name="cart_number<?php echo $k . $l; ?>" id="cart_number<?php echo $k . $l; ?>" value="<?php echo $cart_id_tabcontent; ?>"> 

                                                                                            <div class="col-md-6">
                                                                                                <div class="col-sm-6">
                                                                                                    <label>
                                                                                                        <input type="radio" name="propertyprice<?php echo $k . $l; ?>" id="residentialprice<?php echo $k . $l; ?>" value="<?php echo $residential_price; ?>" autocomplete="off" onchange="$('#commercial_price_div<?php echo $k . $l; ?>').hide();
                                                                                                                $('#residential_price_div<?php echo $k . $l; ?>').show();
                                                                                                                var rushprice = 0;
                                                                                                                if ($('#rushorder<?php echo $k . $l; ?>').is(':checked')) {
                                                                                                                    rushprice = $('#rushorder<?php echo $k . $l; ?>').val();
                                                                                                                }
                                                                                                                var property_price = $(this).val();
                                                                                                                var orderprice = $('#orderprice<?php echo $k . $l; ?>').val();
                                                                                                                var subtotal = parseInt(property_price) + parseInt(rushprice) + parseInt(orderprice);
                                                                                                                $('#subtotal<?php echo $k . $l; ?>').html(subtotal.toFixed(2));
                                                                                                                var plan_total = 0;
                                                                                                                for (var i = 1; i <= <?php echo $no_of_order_tabcontent ?>; i++) {
                                                                                                                    if ($('#tab<?php echo $k ?>' + '_content_order_' + i).css('display') != 'none') {
                                                                                                                        var plan_subtotal = $('#subtotal<?php echo $k ?>' + i).text();
                                                                                                                        plan_total = plan_total + parseInt(plan_subtotal);
                                                                                                                    }
                                                                                                                }
                                                                                                                $('.plantotal').html(plan_total.toFixed(2));
                                                                                                                $('#product_type<?php echo $k . $l; ?>').val('Residential');
                                                                                                                var avail_bal = $('#bal_amt').val();
                                                                                                                var total_amt = $('.plantotal').html();
                                                                                                                var act_bal = parseInt(avail_bal) - parseInt(total_amt);
                                                                                                                $('#balance').html(act_bal.toFixed(2));
                                                                                                                if (parseInt(total_amt) > parseInt(avail_bal)) {
                                                                                                                    var plan_id = $('.plan_id').val();
                                                                                                                    var url = 'http://localhost:82/propertytax247/Client/makepayment/' + plan_id;
                                                                                                                    $('#redirect_url').attr('href', url);
                                                                                                                    $('#less_balance').modal('show', {backdrop: 'static'});
                                                                                                                }
                                                                                                                $('.total_amount').val(plan_total.toFixed(2));" checked> Residential Property
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-sm-6">
                                                                                                    <p id="residential_price_div<?php echo $k . $l; ?>">
                                                                                                        <strong>This Address : $<span id="residential<?php echo $k . $l; ?>"><?php echo $residential_price; ?></span></strong>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">                                                                                                
                                                                                                <div class="col-md-6">
                                                                                                    <p id="commercial_price_div<?php echo $k . $l; ?>" style="display:none">
                                                                                                        <strong>This Address : $<span id="commercial<?php echo $k . $l; ?>"><?php echo $commercial_price; ?></span></strong>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label">State County <span class="required"> *</span></label>
                                                                                            <div class="col-md-4">
                                                                                                <select class="form-control select2me" id="statelist<?php echo $k . $l; ?>" name="statelist<?php echo $k . $l; ?>" data-validate="required" autocomplete="off" data-message-required="Please Select State and County Name.">                                                   
                                                                                                    <option value=""> Select State and County Name</option>
                                                                                                    <?php
                                                                                                    $statewise_data = array(
                                                                                                        'Plan_Id' => $plan_id_tabcontent,
                                                                                                        'User_Id' => $client_id,
                                                                                                        'Status' => 1
                                                                                                    );
                                                                                                    $this->db->where($statewise_data);
                                                                                                    $q_statewise = $this->db->get('tbl_cart');
                                                                                                    foreach ($q_statewise->result() as $row_statewise) {
                                                                                                        $Cart_Id = $row_statewise->Cart_Id;
                                                                                                        $St_County = $row_statewise->St_County;
                                                                                                        $countywise_order = $row_statewise->No_Of_Order;

                                                                                                        $orderplaced_data = array(
                                                                                                            'Cart_Id' => $Cart_Id,
                                                                                                            'Status' => 1
                                                                                                        );
                                                                                                        $this->db->where($orderplaced_data);
                                                                                                        $q_orderplaced = $this->db->get('tbl_order');
                                                                                                        $count_orderplaced = $q_orderplaced->num_rows();
                                                                                                        $no_order_in_county = $countywise_order - $count_orderplaced;
                                                                                                        if ($no_order_in_county > 0) {
                                                                                                            ?>
                                                                                                            <option value="<?php echo $St_County ?>"><?php echo $St_County . " ($no_order_in_county)"; ?></option>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <label class="col-md-2 control-label">Street & Address  <span class="required"> *</span> <?php //echo $countywise_order;  ?> </label>                                                                                            
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group form-md-line-input has-info">
                                                                                                    <input type="text" class="form-control input-sm" name="street<?php echo $k . $l; ?>" autocomplete="off" data-validate="required" data-message-required="Please Enter Street & Address">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label">City <span class="required"> *</span></label>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group form-md-line-input has-info">
                                                                                                    <input type="text" class="form-control input-sm" name="city<?php echo $k . $l ?>" autocomplete="off" data-validate="required" data-message-required="Please Enter City Name" onkeypress="return alpha(event)">
                                                                                                </div>
                                                                                            </div>
                                                                                            <label class="col-md-2 control-label">Zip code <span class="required"> *</span></label>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group form-md-line-input has-info">
                                                                                                    <input type="text" class="form-control input-sm" data-validate="required,number" maxlength="6" name="zipcode<?php echo $k . $l ?>" autocomplete="off" data-message-required="Please Enter Zipcode">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label">Borrower Name <span class="required"> *</span></label>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group form-md-line-input has-info">
                                                                                                    <input type="text" class="form-control input-sm" data-validate="required" name="borrowername<?php echo $k . $l ?>" autocomplete="off" data-message-required="Please Enter Borrower Name" onkeypress="return alpha(event)" >
                                                                                                </div>
                                                                                            </div>
                                                                                            <label class="col-md-2 control-label">APN </label>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group form-md-line-input has-info">
                                                                                                    <input type="text" class="form-control input-sm" name="apn<?php echo $k . $l ?>" autocomplete="off">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label">Additional Notes </label>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group form-md-line-input has-info">
                                                                                                    <input type="text" class="form-control input-sm" name="notes<?php echo $k . $l ?>" autocomplete="off">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6" style="margin-left:-15px">
                                                                                                <?php
                                                                                                $data_rush_price = array(
                                                                                                    'Plan_Id' => $plan_id_tabcontent,
                                                                                                    'Priority_Type' => 'Rush Order',
                                                                                                    'Status' => 1
                                                                                                );
                                                                                                $this->db->where($data_rush_price);
                                                                                                $q_rush_price = $this->db->get('tbl_priority');
                                                                                                foreach ($q_rush_price->result() as $row_rush_price) {
                                                                                                    $rush_price = $row_rush_price->Priority_Price;
                                                                                                }
                                                                                                ?>
                                                                                                <div class="col-md-7">
                                                                                                    <div class="checkbox-list">
                                                                                                        <input type="checkbox" id="rushorder<?php echo $k . $l; ?>" autocomplete="off" name="rushorder<?php echo $k . $l; ?>" value="<?php echo $rush_price ?>" onchange="if (this.checked) {
                                                                                                                    $('#rush_price_div<?php echo $k . $l; ?>').show();
                                                                                                                    var property_price;
                                                                                                                    if (document.getElementById('residentialprice<?php echo $k . $l; ?>').checked) {
                                                                                                                        property_price = document.getElementById('residentialprice<?php echo $k . $l; ?>').value;
                                                                                                                    } else {
                                                                                                                        property_price = document.getElementById('commercialprice<?php echo $k . $l; ?>').value;
                                                                                                                    }
                                                                                                                    var rushprice = $(this).val();
                                                                                                                    var orderprice = $('#orderprice<?php echo $k . $l; ?>').val();
                                                                                                                    var subtotal = parseInt(property_price) + parseInt(rushprice) + parseInt(orderprice);
                                                                                                                    $('#subtotal<?php echo $k . $l; ?>').html(subtotal.toFixed(2));
                                                                                                                    var plan_total = 0;
                                                                                                                    for (var i = 1; i <= <?php echo $no_of_order_tabcontent ?>; i++) {
                                                                                                                        if ($('#tab<?php echo $k ?>' + '_content_order_' + i).css('display') != 'none') {
                                                                                                                            var plan_subtotal = $('#subtotal<?php echo $k ?>' + i).text();
                                                                                                                            plan_total = plan_total + parseInt(plan_subtotal);
                                                                                                                        }
                                                                                                                    }
                                                                                                                    $('.plantotal').html(plan_total.toFixed(2));
                                                                                                                    $('.total_amount').val(plan_total.toFixed(2));
                                                                                                                    var avail_bal = $('#bal_amt').val();
                                                                                                                    var total_amt = $('.plantotal').html();
                                                                                                                    var act_bal = parseInt(avail_bal) - parseInt(total_amt);
                                                                                                                    $('#balance').html(act_bal.toFixed(2));
                                                                                                                    if (parseInt(total_amt) > parseInt(avail_bal)) {
                                                                                                                        var plan_id = $('.plan_id').val();
                                                                                                                        var url = 'http://localhost:82/propertytax247/Client/makepayment/' + plan_id;
                                                                                                                        $('#redirect_url').attr('href', url);
                                                                                                                        $('#less_balance').modal('show', {backdrop: 'static'});
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    $('#rush_price_div<?php echo $k . $l; ?>').hide();
                                                                                                                    var property_price;
                                                                                                                    if (document.getElementById('residentialprice<?php echo $k . $l; ?>').checked) {
                                                                                                                        property_price = document.getElementById('residentialprice<?php echo $k . $l; ?>').value;
                                                                                                                    } else {
                                                                                                                        property_price = document.getElementById('commercialprice<?php echo $k . $l; ?>').value;
                                                                                                                    }
                                                                                                                    var orderprice = $('#orderprice<?php echo $k . $l; ?>').val();
                                                                                                                    var subtotal = parseInt(property_price) + parseInt(orderprice);
                                                                                                                    $('#subtotal<?php echo $k . $l; ?>').html(subtotal.toFixed(2));
                                                                                                                    var plan_total = 0;
                                                                                                                    for (var i = 1; i <= <?php echo $no_of_order_tabcontent ?>; i++) {
                                                                                                                        if ($('#tab<?php echo $k ?>' + '_content_order_' + i).css('display') != 'none') {
                                                                                                                            var plan_subtotal = $('#subtotal<?php echo $k ?>' + i).text();
                                                                                                                            plan_total = plan_total + parseInt(plan_subtotal);
                                                                                                                        }
                                                                                                                    }
                                                                                                                    $('.plantotal').html(plan_total.toFixed(2));
                                                                                                                    $('.total_amount').val(plan_total.toFixed(2));
                                                                                                                    var avail_bal = $('#bal_amt').val();
                                                                                                                    var total_amt = $('.plantotal').html();
                                                                                                                    var act_bal = parseInt(avail_bal) - parseInt(total_amt);
                                                                                                                    $('#balance').html(act_bal.toFixed(2));
                                                                                                                    if (parseInt(total_amt) > parseInt(avail_bal)) {
                                                                                                                        var plan_id = $('.plan_id').val();
                                                                                                                        var url = 'http://localhost:82/propertytax247/Client/makepayment/' + plan_id;
                                                                                                                        $('#redirect_url').attr('href', url);
                                                                                                                        $('#less_balance').modal('show', {backdrop: 'static'});
                                                                                                                    }
                                                                                                                }"> Rush upgrade for this property
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-5 checkbox-list">
                                                                                                    <p id="rush_price_div<?php echo $k . $l; ?>" style="display:none;margin-bottom:0px">
                                                                                                        <strong>This Address : <?php echo "+$" . $rush_price; ?></strong>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <h4 class="col-md-5"><br/><strong>Order Sub Total : $<span id="subtotal<?php echo $k . $l; ?>"><?php echo $residential_price + $order_price_tabcontent; ?></span></strong></h4>
                                                                                        <?php
                                                                                        $plan_subtotal = $residential_price + $plan_subtotal + $order_price_tabcontent;
                                                                                        if ($no_of_order_tabcontent > 1 && $remaining_order != $l) {
                                                                                            ?>
                                                                                            <div class="form-group">
                                                                                                <label class="col-md-4"></label>
                                                                                                <div class="col-md-4">
                                                                                                    <a href="javascript:;" class="btn btn-circle blue" onclick="addmore(<?php echo $no_of_order_tabcontent; ?>, '#tab<?php echo $k; ?>_content_order_<?php echo $l + 1; ?>', this,<?php echo $k; ?>,<?php echo $l + 1; ?>)">
                                                                                                        Add Another Address
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                        $k++;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>                                                      

                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <div class="checkbox-list">
                                                                    <input type="checkbox" name="tc" value="yes" data-validate="required" data-message-required="Please Agree The Terms of Conditions" autocomplete="off"/> I have read and agree to the <a href="https://propertyreport247.com/term-condition.html" title="Term of Conditions" target="_blank">terms of conditions</a> <span class="required">  * </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row static-info align-reverse">
                                                                    <div class="col-md-11 name pull-right">
                                                                        <strong>Order Total : $<span class="plantotal"><?php echo $plan_total; ?></span> </strong>
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
</div>
</div>

<div class="modal fade" id="less_balance">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#3598dc;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Upgrade your Account</h4>
            </div>
            <div class="modal-body">
                <b>Your balance amount is less than total amount.</b><br><br>
                <a target="_blank" class="btn btn-circle blue" style="text-decoration:none" id="redirect_url">
                    <b>Make Payment</b></a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- Less balance amount Popup End here-->
<script type="text/javascript">
    function check_order(order_id, error_id)
    {
        var checkname = $('#' + order_id).val();
        var availname = remove_whitespaces(checkname);
        if (availname != '') {
            $('#' + error_id).show();
            var String = 'ordernumber=' + availname;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Client/check_order') ?>",
                data: String,
                cache: false,
                success: function (result) {
                    var result = remove_whitespaces(result);
                    if (result == 'exists') {
                        $('#' + error_id).html('This Order Number already exists.');
                        $('#' + error_id).addClass("validate-has-error");
                        // $('#' + order_id).addClass("validate-has-error");
                        jQuery('#' + order_id).closest('div').addClass('validate-has-error');
                    } else {
                        $('#' + error_id).html(' ');
                        $('#' + error_id).addClass("validate-has-error");
                    }
                }
            });
        } else {
            $('#' + error_id).html('');

        }
    }
    function remove_whitespaces(str) {
        var str = str.replace(/^\s+|\s+$/, '');
        return str;
    }
</script>