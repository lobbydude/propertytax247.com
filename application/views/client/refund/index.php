<?php
$client_id = $this->session->userdata('client_id');
$get_refund = array(
    'User_Id' => $client_id,
    'Status' => 1
);
$this->db->where($get_refund);
$this->db->order_by('R_Id', 'asc');
$q_refund = $this->db->get('tbl_refund');
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>

<script>
    function show_refund() {
        $('#refund_request').modal("show");
    }

    function view_Refund(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Client/view_refund') ?>",
            data: "refund_id=" + id,
            cache: false,
            success: function (html) {
                $("#view_refund_request_form").html(html);

            }
        });
    }
    $(document).ready(function () {
        $('#refund_request_form').submit(function (e) {
            e.preventDefault();
            var form = $('#refund_request_form');
            if (!form.valid()) {
                jQuery('form:contains("validate-has-error")').css("display:block");
                return false;
            }
            $('html,body').animate({scrollTop: $("#refund_request_form").offset().top}, 'slow');
            $.ajax({
                url: "<?php echo site_url('Client/refund_request') ?>",
                type: "POST",
                data: new FormData((form)[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "success") {
                        $('#refund_request_error').hide();
                        $('#refund_request_success').show();
                        window.location.reload();
                    }
                    else if (data == "fail") {
                        $('#refund_request_success').hide();
                        $('#refund_request_error').show();
                    }
                },
                error: function ()
                {
                }
            });
        });
    });
</script>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption" style="margin-top:8px;">
                            <i class="icon-briefcase"></i>Refund History
                        </div>
                        <div class="tools" style="width:35%">
						 <div class="col-md-6">
                                <h4 id="plantotal_head" onclick="show_refund()" style="cursor:pointer">
								 <strong><u>Request for refund</u></strong>
								</h4>
							</div>
							<div class="col-md-6">
                              <button id="btnExport" class="btn-default">Export to excel</button>
							</div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Reason</th> 
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($q_refund->result() as $row_refund) {
                                    $R_Id = $row_refund->R_Id;
                                    $plan_id = $row_refund->Plan_Id;
                                    $get_plan = array(
                                        'Plan_Id' => $plan_id
                                    );
                                    $this->db->where($get_plan);
                                    $q_plan = $this->db->get('tbl_plan');
                                    foreach ($q_plan->result() as $row_plan) {
                                        $plan_name = $row_plan->Plan_Name;
                                        $plan_type = $row_plan->Type;
                                    }
                                    $Reason = $row_refund->Reason;
                                    $Refund_Status = $row_refund->Refund_Status;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $plan_name . " ($plan_type)"; ?></a></td>
                                        <td><?php echo $Reason; ?></td>
                                        <td><?php echo $Refund_Status; ?></td>
                                        <td>
                                            <a class="btn btn-xs black node-buttons" data-toggle="modal" href="#view_refund_request" onclick="view_Refund(<?php echo $R_Id; ?>)">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
<!-- Refund Request Popup Start Here --> 
<div id="refund_request" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Request for Refund</h4>
            </div>
            <form role="form" id="refund_request_form" method="post" class="form-horizontal validate">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div id="refund_request_success" class="alert alert-success" style="display:none;">Refund request send successfully.</div>
                            <div id="refund_request_error" class="alert alert-danger" style="display:none;">Failed to send refund details.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-md-3">Choose Plan
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <select class="form-control select2me" name="refund_request_plan" id="refund_request_plan" data-validate="required" data-message-required="Please Choose Plan.">
                                    <option value=""> -- Select Plan -- </option>
                                    <?php
                                    $i = 1;
                                    $q_cart = $this->db->query("SELECT SUM(No_of_Order) as OrderNo,Plan_Id,Txn_Id,Cart_Id,Unique_no,Order_Type FROM `tbl_cart` WHERE User_Id='$client_id' AND Status=1 AND Cart_Status!='Refunded' GROUP BY Unique_no");
                                    $count_cart = $q_cart->num_rows();
                                    if ($count_cart > 0) {
                                        foreach ($q_cart->result() as $row_cart) {
                                            $cart_id_cart = $row_cart->Cart_Id;
                                            $plan_id_cart = $row_cart->Plan_Id;
                                            $no_of_order_cart = $row_cart->OrderNo;
                                            $unique_no_cart = $row_cart->Unique_no;
                                            $Cart_Status = $row_cart->Cart_Status;
                                            if ($Cart_Status == "") {
                                                $orderplacing_data = array(
                                                    'User_Id' => $client_id,
                                                    'Cart_Unique_no' => $unique_no_cart,
                                                    'Status' => 1
                                                );
                                                $this->db->where($orderplacing_data);
                                                $q_orderplacing = $this->db->get('tbl_order');
                                                $count_orderplacing = $q_orderplacing->num_rows();
                                                if ($count_orderplacing == 0) {
                                                    $get_plan_cart = array(
                                                        'Plan_Id' => $plan_id_cart,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($get_plan_cart);
                                                    $q_plan_cart = $this->db->get('tbl_plan');
                                                    $count_plan_cart = $q_plan_cart->num_rows();
                                                    foreach ($q_plan_cart->result() as $row_plan_cart) {
                                                        $plan_name_cart = $row_plan_cart->Plan_Name;
                                                        $plan_type_cart = $row_plan_cart->Type;
                                                        ?>
                                                        <option value="<?php echo $cart_id_cart; ?>"><?php echo $plan_name_cart . "  " . $plan_type_cart . " / " . $no_of_order_cart . " orders"; ?></option>
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
                        <div class="form-group">
                            <label class="control-label col-md-3">Reason <span class="required"> * </span> </label>                                                                                                
                            <div class="col-md-8">
                                <div class="form-group form-md-line-input has-info">
                                    <input type="text" class="form-control input-sm" name="refund_request_reason" id="refund_request_reason" data-validate="required" data-message-required="Please Enter Reason.">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <div class="checkbox-list">
                                    <input type="checkbox" name="refund_request_tc" value="yes" data-validate="required" data-message-required="Please Agree The Terms and Conditions" autocomplete="off"/> I have read and agree to the <a href="https://propertyreport247.com/term-condition.html" title="Term & Conditions" target="_blank">terms of conditions</a> <span class="required">  * </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn blue">Send</button>
                    <button type="button" data-dismiss="modal" class="btn default">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Refund Request Popup End Here -->

<!-- Refund Request Popup Start Here --> 
<div id="view_refund_request" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">View Refund</h4>
            </div>
            <form role="form" id="view_refund_request_form" method="post" class="form-horizontal validate">

            </form>
        </div>
    </div>
</div>
<!-- Refund Request Popup End Here -->