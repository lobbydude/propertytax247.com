<?php
session_start();
$client_id = $this->session->userdata('client_id');
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

$get_transaction = array(
    'User_Id' => $client_id,
    'Status' => 1
);
$this->db->select_sum('Order_Amount');
$this->db->where($get_transaction);
$q_acc = $this->db->get('tbl_billing');
$result_acc = $q_acc->result();
$total_amt = $result_acc[0]->Order_Amount;
$balance1 = $total_paid_amount - $total_amt;
$balance = number_format((float) $balance1, 2, '.', '');
?>
<script>
    function edit_cart(code) {
        $.ajax({
            type: 'post',
            url: "<?php echo site_url('Cart/Editcart') ?>",
            data: {
                code: code
            },
            success: function (response) {
                document.getElementById("editcart").innerHTML = response;
            }
        });
    }

    function removecart11(county_order, code, orders) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Cart/removecart') ?>",
            data: {
                county_order: county_order,
                order_code: code
            },
            cache: false,
            success: function (html) {
                var url = "<?php echo site_url('Cart/Editcart') ?>/" + code;
                var timer = setInterval(function () {
                    $('#editcart').load(url);
                }, 1000);
                setTimeout(function () {
                    clearInterval(timer);
                }, 1000);
            }
        });
    }

    function removecart(county_order, code, orders) {
        var regExp = /\(([^)]+)\)/;
        var matches = regExp.exec(county_order);
        var deleteorder = matches[1];
        var total_order = 0;
        var newTxt = orders.split('(');
        for (var i = 1; i < newTxt.length; i++) {
            total_order = parseInt(total_order) + parseInt(newTxt[i].split(')')[0]);
        }
        var count_order = parseInt(total_order) - parseInt(deleteorder);
        if (count_order < 10) {
            $("#add_cart_delete").hide();
            $("#mincart_item").show();
        } else if (count_order > 10) {
            var nooforder = count_order / 10;
            if ((nooforder % 1) != 0) {
                $("#add_cart_delete").hide();
                $('#mincart_item').show(0).delay(5000).hide(0);
            } else {
                $.ajax({
                    url: "<?php echo site_url('Cart/removecart') ?>",
                    type: 'post',
                    data: {
                        county_order: county_order,
                        order_code: code
                    },
                    method: 'POST',
                    success: function (msg)
                    {
                        $("#mincart_item").hide();
                        $("#add_cart_delete").show();
                        var url = "<?php echo site_url('Cart/Editcart') ?>/" + code;
                        var timer = setInterval(function () {
                            $('#editcart').load(url);
                        }, 1000);
                        setTimeout(function () {
                            clearInterval(timer);
                        }, 1000);
                    }
                });
            }
        }
        else {
            $.ajax({
                url: "<?php echo site_url('Cart/removecart') ?>",
                type: 'post',
                data: {
                    county_order: county_order,
                    order_code: code
                },
                method: 'POST',
                success: function (msg)
                {
                    $("#mincart_item").hide();
                    $("#add_cart_delete").show();
                    var url = "<?php echo site_url('Cart/Editcart') ?>/" + code;
                    var timer = setInterval(function () {
                        $('#editcart').load(url);
                    }, 1000);
                    setTimeout(function () {
                        clearInterval(timer);
                    }, 1000);
                }
            });
        }
    }

    function removefromcart(code) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Cart/removefromcart') ?>",
            data: {
                order_code: code
            },
            cache: false,
            success: function (html) {
                window.location.reload();
            }
        });
    }

    function change_county(state_id) {
        $.ajax({
            url: "<?php echo site_url('Cart/change_county') ?>",
            type: 'post',
            data: {
                state_id: state_id
            },
            method: 'POST',
            success: function (msg)
            {
                $("#add_county").html(msg);
            }
        });
    }

    function Addcart() {
        var order_type = $("#order_type").val();
        var state;
        var statename;
        var county;
        var no_of_order;
        var order_code;
        var countyname;
        if (order_type == "Single") {
            state = $("#add_state").val();
            statename = $("#add_state option:selected").text();
            county = $("#add_county option:selected").val();
            countyname = $("#add_county option:selected").text();
            no_of_order = 1;
            order_code = $("#order_code").val();
            if (state == "" || county == "") {
                $("#add_cart_success").hide();
                $("#add_cart_validateerror").show();
            } else {
                $.ajax({
                    url: "<?php echo site_url('Cart/addtocart') ?>",
                    type: 'post',
                    data: {
                        state_id: state,
                        statename: statename,
                        county_id: county,
                        no_of_order: no_of_order,
                        order_code: order_code,
                        order_type: order_type
                    },
                    method: 'POST',
                    success: function (msg)
                    {
                        $("#add_cart_validateerror").hide();
                        $("#add_cart_success").show();
                        var url = "<?php echo site_url('Cart/Editcart') ?>/" + order_code;
                        var timer = setInterval(function () {
                            $('#editcart').load(url);
                        }, 1000);
                        setTimeout(function () {
                            clearInterval(timer);
                        }, 1000);
                    }
                });
            }
        } else {
            state = $("#add_state").val();
            statename = $("#add_state option:selected").text();
            county = $("#add_county option:selected").text();
            no_of_order = $("#no_of_order").val();
            var countyval = $("#add_county option:selected").val();
            order_code = $("#order_code").val();
            if (state == "" || countyval == "" || no_of_order == "0" || no_of_order == "") {
                $("#add_cart_success").hide();
                $("#add_cart_validateerror").show();
            } else {
                if (no_of_order < 10) {
                    $("#add_cart_validateerror").hide();
                    $("#add_cart_success").hide();
                    $('#mincart_item').show(0).delay(5000).hide(0);
                } else if (no_of_order > 10) {
                    var nooforder = no_of_order / 10;
                    if ((nooforder % 1) != 0) {
                        $("#add_cart_validateerror").hide();
                        $("#add_cart_success").hide();
                        $('#mincart_item').show(0).delay(5000).hide(0);
                    } else {
                        $.ajax({
                            url: "<?php echo site_url('Cart/addtocart') ?>",
                            type: 'post',
                            data: {
                                state_id: state,
                                statename: statename,
                                county_id: county,
                                no_of_order: no_of_order,
                                order_code: order_code,
                                order_type: order_type
                            },
                            method: 'POST',
                            success: function (msg)
                            {
                                if (msg == "exists")
                                {
                                    $("#mincart_item").hide();
                                    $("#add_cart_validateerror").hide();
                                    $("#add_cart_success").hide();
                                    $("#add_cart_exists").show();
                                } else {
                                    $("#add_cart_exists").hide();
                                    $("#mincart_item").hide();
                                    $("#add_cart_validateerror").hide();
                                    $("#add_cart_success").show();
                                    var url = "<?php echo site_url('Cart/Editcart') ?>/" + order_code;
                                    var timer = setInterval(function () {
                                        $('#editcart').load(url);
                                    }, 1000);
                                    setTimeout(function () {
                                        clearInterval(timer);
                                    }, 1000);
                                }
                            }
                        });
                    }
                } else {
                    $.ajax({
                        url: "<?php echo site_url('Cart/addtocart') ?>",
                        type: 'post',
                        data: {
                            state_id: state,
                            statename: statename,
                            county_id: county,
                            no_of_order: no_of_order,
                            order_code: order_code,
                            order_type: order_type
                        },
                        method: 'POST',
                        success: function (msg)
                        {
                            if (msg == "exists")
                            {
                                $("#mincart_item").hide();
                                $("#add_cart_validateerror").hide();
                                $("#add_cart_success").hide();
                                $("#add_cart_exists").show();
                            } else {
                                $("#add_cart_exists").hide();
                                $("#mincart_item").hide();
                                $("#add_cart_validateerror").hide();
                                $("#add_cart_success").show();
                                var url = "<?php echo site_url('Cart/Editcart') ?>/" + order_code;
                                var timer = setInterval(function () {
                                    $('#editcart').load(url);
                                }, 1000);
                                setTimeout(function () {
                                    clearInterval(timer);
                                }, 1000);
                            }
                        }
                    });
                }
            }
        }

    }
</script>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-screen-tablet"></i>Checkout
                        </div>
                        <div class="tools hidden-xs">
                            <div class="col-md-12">
                                <h4 id="plantotal_head"><strong>Balance Amount : $<?php echo $balance; ?></strong></h4>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Plan Name</th>
                                    <th>Plan Type</th>
                                    <th>State & County</th>
                                    <th>Plan Price</th>
                                    <th>Plan Total</th>
                                    <th>Modify</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $k = 1;
                                $total_amount = 0;
                                if (isset($_SESSION["cart_item"])) {
                                    foreach ($_SESSION["cart_item"] as $item) {
                                        $plan_id_sess = $item['plan_name'];
                                        $order_type_sess = $item['order_type'];
                                        $state_id_sess = $item['state'];
                                        $county_id_sess = $item['county'];
                                        $countyorder_sess = $item['countyorder'];
                                        $code_sess = $item['code'];
                                        $no_of_order_sess = $item['no_of_order'];
                                        $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_sess";
                                        $result_plan_sess = mysql_query($q_plan_sess);
                                        while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                                            $plan_name_sess = $row_plan_sess['Plan_Name'];
                                            $plan_price_sess1 = $row_plan_sess['Price'];
                                            $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                                            ?>
                                            <tr>
                                                <td><?php echo $k; ?></td>
                                                <td><?php echo $plan_name_sess; ?></td>
                                                <td><?php echo $order_type_sess; ?></td>                 
                                                <td>
                                                    <?php
                                                    if ($order_type_sess == "Single") {
                                                        $q_statewise = "select * from tbl_statewise where Status=1 AND S_Id=$state_id_sess";
                                                        $result_statewise = mysql_query($q_statewise);
                                                        while ($row_statewise = mysql_fetch_array($result_statewise)) {
                                                            $state_id = $row_statewise['State_Id'];
                                                            $q_county = "select * from tbl_county where County_ID=$county_id_sess";
                                                            $result_county = mysql_query($q_county);
                                                            while ($row_county = mysql_fetch_array($result_county)) {
                                                                $county_name = $row_county['County'];
                                                            }
                                                            $q_state = "select * from tbl_state where State_ID=$state_id";
                                                            $result_state = mysql_query($q_state);
                                                            while ($row_state = mysql_fetch_array($result_state)) {
                                                                $state_abbreviation = $row_state['Abbreviation'];
                                                                ?>
                                                                <?php echo $state_abbreviation . " - " . $county_name; ?>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        $county_order_array = explode('|', $countyorder_sess);
                                                        $count_countyorder_id = count($county_order_array);
                                                        for ($l = 0; $l < ($count_countyorder_id - 1); $l++) {
                                                            $county_order = $county_order_array[$l];
                                                            ?>
                                                            <?php echo $county_order; ?><br/>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>				
                                                <td>$<?php echo $plan_price_sess; ?></td>	
                                                <td>
                                                    <?php
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
                                                        echo "$" . $plan_price;
                                                    } else {
                                                        $plan_price = number_format((float) $plan_price_sess1, 2, '.', '');
                                                        echo "$" . $plan_price;
                                                    }
                                                    ?>
                                                </td>            
                                                <td>
                                                    <a class="delete" data-toggle="modal" href="#edit_cart_model" onClick="edit_cart('<?php echo $code_sess; ?>')">
                                                        Modify
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="removefromcart('<?php echo $code_sess; ?>')" class="delete">Delete</a>
                                                </td>    
                                            </tr>
                                            <?php
                                            $total_amount = $plan_price + $total_amount;
                                        }
                                        $k++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td>Cart items is empty.</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table><hr/>
                        <div class="row static-info align-reverse">
                            <div class="col-md-12 value" style="margin-top: -30px;">
                                <h3> Total: $<?php
                                    $total_amount1 = number_format((float) $total_amount, 2, '.', '');
                                    echo $total_amount1;
                                    ?> </h3>                               
                                <a href="<?php echo site_url('Cart/billing'); ?>" class="delete">PROCEED TO CHECKOUT</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->

<!-- Modify Popup Content Start here-->
<div id="edit_cart_model" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Change State and County</h4>
            </div>
            <form role="form" id="editcart" method="post" class="form-horizontal">

            </form>
        </div>
    </div>
</div>