<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>

<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>

<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>

<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<style>
    #add_state_ms{
        background-position: 120px center;
    }
</style>
<script>

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

    $(document).ready(function () {
        $('#client_newplan_submit_form').submit(function (e) {
            e.preventDefault();
            var form = $('#client_newplan_submit_form');
            if (!form.valid())
                return false;
            var order_type = $('#add_order_type').val();
            var plan_name = $('#add_plan').val();
            var price = $('#add_price').val();
            if (order_type == "Single") {
                var countyid = $('#add_county option:selected').val();
                var countyname = $('#add_county option:selected').text();
                var no_of_order = 1;
                var state = $('#add_state option:selected').val();
                var countyorder = countyname + "(" + no_of_order + ")";
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
                        $("#add_order_type, #add_plan, #add_state, #add_county").select2("val", "");
                        $("#client_newplan_submit_form")[0].reset();
                        $('#total_items').html(response);
                        $("#lesscart_item").hide();
                        $('#addcart_item_success').show(0).delay(5000).hide(0);
                    }
                });
            } else {
                var countycheckid = [];
                var no_of_order = [];
                var no_of_order_count = 0;
                var state = [];
                var countyid = [];
                var countyorder = [];
                // $("input:checkbox[name=add_county]:checked").each(function () {
                //countycheckid = $(this).attr("id");
                var length = $('[name="add_county"]').length;
                for (var i = 0; i < length; i++) {
                    if (document.planForm.add_county[i].checked) {
                        countycheckid = i + 1;
                        if (parseInt($('#no_of_order_count' + countycheckid).val()) == 0) {
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
                //});

                $.each($("#add_state option:selected"), function () {
                    state += $(this).val() + "|";
                });

                if (no_of_order_count < 10) {
                    $('#lesscart_item').show(0).delay(5000).hide(0);
                } else if (no_of_order_count > 10) {
                    var nooforder = no_of_order_count / 10;
                    if ((nooforder % 1) != 0) {
                        $('#lesscart_item').show(0).delay(5000).hide(0);
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
                                $('#total_items').html(response);
                                $("#add_order_type, #add_plan, #add_state, #add_county").select2("val", "");
                                $("#client_newplan_submit_form")[0].reset();
                                $("#lesscart_item").hide();
                                $("#add_state_ms").removeAttr("data-tooltip");
                                $("#add_county_li").removeAttr("data-tooltip");
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
                            $('#total_items').html(response);
                            $("#add_order_type, #add_plan, #add_state, #add_county").select2("val", "");
                            $("#client_newplan_submit_form")[0].reset();
                            $("#add_state_ms").removeAttr("data-tooltip");
                            $("#add_county_li").removeAttr("data-tooltip");
                            $("#lesscart_item").hide();
                            $('#addcart_item_success').show(0).delay(5000).hide(0);
                        }
                    });
                }
            }
        });
    });

</script>

<!-- BEGIN FORM-->

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-folder-alt"></i>Choose Plan
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal validate plan_submit_form" id="client_newplan_submit_form" name="planForm" method="POST">

                            <div class="form-wizard">

                                <div class="form-body">

                                    <ul class="nav nav-pills nav-justified steps" >

                                        <li style="display:none;">

                                            <a href="#taborder2" data-toggle="tab" class="step" >

                                                <span class="number"> 1 </span>

                                                <span class="desc">

                                                    <i class="fa fa-check"></i> Choose Plan(Orders) 

                                                </span>

                                            </a>

                                        </li>                                        

                                    </ul>



                                    <div class="tab-content">

                                        <div class="tab-pane" id="taborder2">

                                            <div class="portlet-body form">

                                                <div class="form-body">

                                                    <div class="form-group">

                                                        <div class="col-md-8">

                                                            <div id="addcart_item_success" class="alert alert-success" style="display:none;padding: 4px;text-align: center">Your Cart details added successfully.</div>

                                                            <div id="lesscart_item" class="alert alert-danger" style="display:none;padding: 4px;text-align: center">FOR BULK ORDERS - THE MINIMUM ORDERS SHOULD BE IN 10, 20 30..</div>

                                                        </div>

                                                    </div>

                                                    <h3 class="block">Provide your plan details</h3><br/>

                                                    <div class="form-group">

                                                        <label class="control-label col-md-2">Plan Type <span class="required"> * </span></label>

                                                        <div class="col-md-2">                                                          

                                                            <select class="form-control select2me" name="add_order_type" id="add_order_type" data-validate="required" data-message-required="Please Select Plan Type" onChange="change_plan(this.value);" autocomplete="off">

                                                                <option value=""> -- Plan Type -- </option>

                                                                <option value="Single">Single</option>

                                                                <option value="Bulk">Bulk</option>                                                                

                                                            </select>                                                        

                                                        </div>

                                                        <label class="control-label col-md-2">Plan Name <span class="required"> * </span></label>

                                                        <div class="col-md-2">                                                          

                                                            <select class="form-control select2me" name="add_plan" id="add_plan" data-validate="required" data-message-required="Please Select Plan" onClick="change_price(this.value)" onChange="change_state(this.value)" autocomplete="off">

                                                                <option value=""> -- Plan Name -- </option>

                                                            </select>                                                        

                                                        </div>                                                        

                                                    </div><br>

                                                    <div class="form-group">

                                                        <label class="control-label col-md-2">State Name <span class="required"> * </span></label>

                                                        <div class="col-md-2">     

                                                            <div id="add_state_div">

                                                                <select class="form-control select2me" name="add_state" id="add_state" onchange="change_county(this.value)" data-validate="required" data-message-required="Please Select State" autocomplete="off">

                                                                    <option value=""> -- State Name -- </option>

                                                                </select>        

                                                            </div>

                                                        </div>

                                                        <label class="control-label col-md-2">County Name<span class="required"> * </span>                                                            

                                                        </label>

                                                        <div class="col-md-4">

                                                            <div id="add_county_div">

                                                                <select class="form-control select2me" style="color:#cccccc;" data-validate="required" data-message-required="Please Select County" name="add_county" id="add_county" autocomplete="off">

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

                                                            <input type="text" placeholder="Price" value="$0.00" name="add_price" id="add_price" class="form-control input-sm" disabled="disabled" autocomplete="off">

                                                        </div>                                                        

                                                        <div class="col-md-3">

                                                            <input type="submit" value="ADD TO CART" name="buynow_submit" id="buynow" class="submit btn blue button">

                                                        </div>

                                                    </div>                                                    

                                                </div>

                                            </div>    

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

<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/css/tooltip.css') ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/dropdown/jquery-ui.css') ?>" />

<script type="text/javascript" src="<?php echo site_url('assets/global/dropdown/jquery-ui.min.js') ?>"></script>

<link href="<?php echo site_url('assets/global/dropdown/jquery.multiselect.css') ?>" rel="stylesheet" type="text/css" />

<script src="<?php echo site_url('assets/global/dropdown/jquery.multiselect.js') ?>" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/dropdown/component.css') ?>" />      



