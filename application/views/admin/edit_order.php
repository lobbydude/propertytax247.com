<?php
$order_id = $this->uri->segment(3);
$this->db->where('Order_Id', $order_id);
$q = $this->db->get('tbl_order');
foreach ($q->result() as $row) {
    $Plan_Id = $row->Plan_Id;
    $Street = $row->Street;
    $Order_Number = $row->Order_Number;
    $State_County = $row->State_County;
    $Priority1 = $row->Priority;
    $Priority = number_format((float) $Priority1, 2, '.', '');
    $this->db->where('Plan_Id', $Plan_Id);
    $q_plan = $this->db->get('tbl_plan');
    foreach ($q_plan->result() as $row_plan) {
        $plan_name = $row_plan->Plan_Name;
    }
    $City = $row->City;
    $Zipcode = $row->Zipcode;
    $Borrower_Name = $row->Borrower_Name;
    $APN = $row->APN;
    $Notes = $row->Notes;
    $Order_Date = $row->Order_Date;
    $Order_Status = $row->Order_Status;
    $Comments = $row->Comments;
}
?>
<script src="<?php echo site_url('assets/global/validation/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/resizeable.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('assets/global/validation/custom.js') ?>"></script>
<script>
    function showCounty(sel) {
        var statewise_id = sel.options[sel.selectedIndex].value;
        if (statewise_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Signup/fetch_county') ?>",
                data: "statewise_id=" + statewise_id,
                cache: false,
                success: function (msg) {
                    $("#edit_admin_orderinfo_countylist").html(msg);
                }
            });
        }
    }
	// Delete Admin upload Document start here
    function delete_document(id) {
        $.ajax({            
            type: "POST",
            url: "<?php echo site_url('Admin/Deletedocument') ?>",
            data: "doc_id=" + id,
            cache: false,
            success: function (html) {               
                $("#deletedocument_form").html(html);
            }
        });
    }   

    $(document).ready(function () {
        $('#edit_admin_orderinfo_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_admin_orderinfo_orderid: $('#edit_admin_orderinfo_orderid').val(),
                edit_admin_orderinfo_street: $('#edit_admin_orderinfo_street').val(),
                edit_admin_orderinfo_order_number: $('#edit_admin_orderinfo_order_number').val(),
                edit_admin_orderinfo_statelist: $('#edit_admin_orderinfo_statelist').val(),
                edit_admin_orderinfo_city: $('#edit_admin_orderinfo_city').val(),
                edit_admin_orderinfo_zipcode: $('#edit_admin_orderinfo_zipcode').val(),
                edit_admin_orderinfo_borrowername: $('#edit_admin_orderinfo_borrowername').val(),
                edit_admin_orderinfo_apn: $('#edit_admin_orderinfo_apn').val(),
                edit_admin_orderinfo_notes: $('#edit_admin_orderinfo_notes').val(),
                edit_admin_orderinfo_status: $('#edit_admin_orderinfo_status').val(),
                edit_admin_orderinfo_comments: $('#edit_admin_orderinfo_comments').val()
            };
            $.ajax({
                url: "<?php echo site_url('Admin/edit_orderinfodata') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    alert(msg);
                    die();
                    if (msg == 'fail') {
                        $('#edit_admin_orderinfo_error').show();
                    }
                    if (msg == 'success') {
                        $('#edit_admin_orderinfo_success').show();
                    }
                }
            });
        });

        $("#edit_admin_orderupload_form").on('submit', (function (e) {
            e.preventDefault();
            var form = $('#edit_admin_orderupload_form');
            if (!form.valid())
                return false;
            $.ajax({
                url: "<?php echo site_url('Admin/upload_order') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "notyet") {
                        $('#edit_admin_orderupload_error').hide();
                        $('#edit_admin_orderupload_success').hide();
                        $('#edit_admin_orderupload_notyet').show();
                    }
                    if (data == "fail") {
                        $('#edit_admin_orderupload_notyet').hide();
                        $('#edit_admin_orderupload_success').hide();
                        $('#edit_admin_orderupload_error').show();
                    }
                    if (data == "success") {
                        $('#edit_admin_orderupload_notyet').hide();
                        $('#edit_admin_orderupload_error').hide();
                        $("#edit_admin_orderupload_form")[0].reset();
                        $("#admin_upload_filename").html("");
                        $('#edit_admin_orderupload_success').show();
                        $('.document_table').load(location.href + ' .document_table tr');
                        // $('.document_table').load(location.href + ' .document_table tr');
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <?php if ($this->uri->segment(4) == "") { ?>
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-layers"></i>Order - <?php echo $plan_name . " - " . $Order_Number; ?>
                            </div>
                            <div class="tools margin-top-10">
                                <i onclick="window.history.back();" class="glyphicon glyphicon-step-backward" title="Back" style="cursor:pointer"></i>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form-horizontal validate" id="edit_admin_orderinfo_form">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="edit_admin_orderinfo_success" class="alert alert-success" style="display:none;">Order details updated successfully.</div>
                                        <div id="edit_admin_orderinfo_error" class="alert alert-danger" style="display:none;">Failed to update order details.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" id="edit_admin_orderinfo_orderid" name="edit_admin_orderinfo_orderid" value="<?php echo $order_id ?>">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Street & Address </label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="edit_admin_orderinfo_street" id="edit_admin_orderinfo_street" autocomplete="off" value="<?php echo $Street; ?>">
                                            </div>
                                        </div>
                                        <label class="col-md-2 control-label">Order Number <span class="required"> *</span></label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" style="margin-left: -10px;" name="edit_admin_orderinfo_order_number" id="edit_admin_orderinfo_order_number" data-validate="required" data-message-required="Please enter order number." autocomplete="off" value="<?php echo $Order_Number; ?>" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">State & County </label>
                                        <div class="col-md-4">
                                            <select class="form-control select2me" data-validate="required" autocomplete="off" onChange="showCounty(this);" id="edit_admin_orderinfo_statelist" name="edit_admin_orderinfo_statelist" >                                                   
                                                <option value="<?php echo $State_County; ?>"> <?php echo $State_County; ?> </option>
                                                <?php
                                                $statewise_data = array(
                                                    'St_County !=' => $State_County,
                                                    'Plan_Id' => $Plan_Id,
                                                    'Status' => 1
                                                );
                                                $this->db->where($statewise_data);
                                                $q_statewise_select = $this->db->get('tbl_cart');
                                                foreach ($q_statewise_select->result() as $row_statewise_select) {
                                                    $St_County = $row_statewise_select->St_County;
                                                    $countywise_order = $row_statewise_select->No_Of_Order;
                                                    ?>
                                                    <option value="<?php echo $St_County ?>"><?php echo $St_County . " ($countywise_order)"; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 control-label">City </label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" style="margin-left: -10px;" name="edit_admin_orderinfo_city" id="edit_admin_orderinfo_city" autocomplete="off" value="<?php echo $City; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Zip Code <span class="required"> *</span></label>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input has-info">
                                            <input type="text" class="form-control input-sm" name="edit_admin_orderinfo_zipcode" id="edit_admin_orderinfo_zipcode" data-validate="required,number" data-message-required="Please enter order number." maxlength="6" autocomplete="off" style="margin-left: -10px;" value="<?php echo $Zipcode; ?>">
                                        </div>
                                    </div>
                                    <label class="col-md-2 control-label">Borrower Name <span class="required"> *</span></label>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input has-info">
                                            <input type="text" class="form-control input-sm" style="margin-left: -5px;" name="edit_admin_orderinfo_borrowername" id="edit_admin_orderinfo_borrowername" autocomplete="off" value="<?php echo $Borrower_Name; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">APN </label>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input has-info">
                                            <input type="text" style="margin-left: -10px;" class="form-control input-sm" name="edit_admin_orderinfo_apn" id="edit_admin_orderinfo_apn" autocomplete="off" value="<?php echo $APN; ?>">
                                        </div>
                                    </div>
                                    <label class="col-md-2 control-label">Notes </label>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input has-info">
                                            <input type="text" class="form-control input-sm" style="margin-left: -5px;" name="edit_admin_orderinfo_notes" id="edit_admin_orderinfo_notes" autocomplete="off" value="<?php echo $Notes; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Status </label>
                                    <div class="col-md-4">
                                        <select class="form-control select2me" style="margin-left: -10px;" name="edit_admin_orderinfo_status" id="edit_admin_orderinfo_status">
                                            <option value="Processing" <?php
                                            if ($Order_Status == "Processing") {
                                                echo "selected";
                                            }
                                            ?>>Processing</option>
                                            <option value="Pending" <?php
                                            if ($Order_Status == "Pending") {
                                                echo "selected";
                                            }
                                            ?>>Pending</option>
                                            <option value="Hold" <?php
                                            if ($Order_Status == "Hold") {
                                                echo "selected";
                                            }
                                            ?>>Hold</option>
                                            <option value="Canceled" <?php
                                            if ($Order_Status == "Canceled") {
                                                echo "selected";
                                            }
                                            ?>>Canceled</option>
                                            <option value="Completed" <?php
                                            if ($Order_Status == "Completed") {
                                                echo "selected";
                                            }
                                            ?>>Completed</option>
                                        </select>
                                    </div>
                                    <?php if ($Priority != 0) { ?>
                                        <label class="col-md-2 control-label" style="color:red;"> Rush Order </label>
                                        <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="edit_client_orderinfo_notes" id="edit_client_orderinfo_notes" autocomplete="off" value="<?php echo $Priority; ?>" disabled="disabled">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Comments </label>
                                    <div class="col-md-5">
                                        <div class="form-group form-md-line-input has-info">
                                            <input type="text" class="form-control input-sm" style="margin-left: -10px;" name="edit_admin_orderinfo_comments" id="edit_admin_orderinfo_comments" autocomplete="off" value="<?php echo $Comments; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn blue">Submit</button>
                                    </div>
                                </div>
                            </form> <hr/>
                            <form role="form" class="form-horizontal validate" id="edit_admin_orderupload_form">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="edit_admin_orderupload_success" class="alert alert-success" style="display:none;">File uploaded successfully.</div>
                                        <div id="edit_admin_orderupload_error" class="alert alert-danger" style="display:none;">Failed to upload files.</div>
                                        <div id="edit_admin_orderupload_notyet" class="alert alert-info" style="display:none;">Order not yet completed.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <input type="hidden" id="edit_admin_orderupload_orderid" name="edit_admin_orderupload_orderid" value="<?php echo $order_id ?>">
                                        <label class="col-md-2 control-label">Document Type </label>
                                        <div class="col-md-3">
                                            <select class="form-control select2me" autocomplete="off" id="edit_admin_orderupload_doctype" name="edit_admin_orderupload_doctype" style="width:270px;" data-validate="required" data-message-required="Please select document type.">                                                                                                   
                                                <option value="">Select Document Type</option>
                                                <option value="Title Search Package">Title Search Package</option>
                                                <option value="Property Report">Property Report</option>
                                                <option value="Tax Certificate">Tax Certificate</option>
                                                <option value="BK Search">BK Search</option>
                                                <option value="Plat Map">Plat Map</option>
                                                <option value="Order Sheet">Order Sheet</option>
                                            </select>
                                        </div>
                                        <label class="col-md-1 control-label">Description</label>
                                        <div class="col-md-2">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="edit_admin_orderupload_description" id="edit_admin_orderupload_description" data-validate="required" data-message-required="Please enter description." autocomplete="off" style="width:170px;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="btn grey-cascade fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span>
                                                    Browse files</span>
                                                <input type="file" name="edit_admin_orderupload_file" id="edit_admin_orderupload_file" data-validate="required" data-message-required="Please select file." onchange="$('#admin_upload_filename').html(this.value)">
                                            </span>
                                            <p id="admin_upload_filename"></p>
                                        </div>
                                        <button type="submit" class="btn blue">Upload</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-hover document_table" id="sample_2">
                                <thead>
                                    <tr>
                                        <th style="width:115px">Order No</th>                                  
                                        <th>Document Type</th>
                                        <th>Description</th>
                                        <th>File</th>
                                        <th>Uploaded By</th>
                                        <th style="background: none">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->db->where('Status', 1);
                                    $this->db->where('Order_Id', $order_id);
                                    $q_orderdocments = $this->db->get('tbl_orderdocuments');
                                    foreach ($q_orderdocments->result() as $row_orderdocments) {
                                        $Doc_Id = $row_orderdocments->Doc_Id;
                                        $Doc_Type = $row_orderdocments->Doc_Type;
                                        $Description = $row_orderdocments->Description;
                                        $File = $row_orderdocments->File;
                                        $Uploaded_By = $row_orderdocments->Uploaded_By;
                                        $Inserted_By = $row_orderdocments->Inserted_By;
                                        if ($Uploaded_By == "admin") {
                                            $this->db->where('Admin_Id', $Inserted_By);
                                            $q_admin = $this->db->get('tbl_admin');
                                            foreach ($q_admin->result() as $row_admin) {
                                                $Uploaded_Username = $row_admin->Admin_Username;
                                            }
                                        } else {
                                            $this->db->where('User_Id', $Inserted_By);
                                            $q_user = $this->db->get('tbl_user');
                                            foreach ($q_user->result() as $row_user) {
                                                $Uploaded_Username = $row_user->Username;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $Order_Number; ?></td>
                                            <td><?php echo $Doc_Type; ?></td>
                                            <td><?php echo $Description; ?></td>
                                            <td><?php echo $File; ?></td>
                                            <td><?php echo $Uploaded_Username; ?></td>
                                            <td>
                                                <a target="_blank" class="btn btn-xs black" href="<?php echo site_url('orders/' . $File); ?>">
                                                    <span class="glyphicon glyphicon-download fa fa-exclamation-triangle tooltips" data-original-title="Order Download"></span>
                                                </a>                                             
                                                <a class="btn btn-xs black" href="#delete_document_model" data-toggle="modal" onclick="delete_document(<?php echo $Doc_Id;?>)">                                                                                                                              
                                                    <span class="glyphicon glyphicon-remove-circle fa fa-exclamation-triangle tooltips" data-original-title="Order Document Delete"></span>
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
            <?php } else {
                ?>
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-layers"></i>Order - <?php echo $plan_name . " - " . $Order_Number; ?>
                            </div>
                            <div class="tools margin-top-10">
                                <i onclick="window.history.back();" class="glyphicon glyphicon-step-backward" title="Back" style="cursor:pointer"></i>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form-horizontal validate" id="edit_admin_orderupload_form">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="edit_admin_orderupload_success" class="alert alert-success" style="display:none;">File uploaded successfully.</div>
                                        <div id="edit_admin_orderupload_error" class="alert alert-danger" style="display:none;">Failed to upload files.</div>
                                        <div id="edit_admin_orderupload_notyet" class="alert alert-info" style="display:none;">Order not yet completed.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <input type="hidden" id="edit_admin_orderupload_orderid" name="edit_admin_orderupload_orderid" value="<?php echo $order_id ?>">
                                        <label class="col-md-2 control-label">Document Type </label>
                                        <div class="col-md-3">
                                            <select class="form-control select2me" autocomplete="off" id="edit_admin_orderupload_doctype" name="edit_admin_orderupload_doctype">                                                   
                                                <option value="Title Search Package">Title Search Package</option>
                                                <option value="Property Report">Property Report</option>
                                                <option value="Tax Certificate">Tax Certificate</option>
                                                <option value="BK Search">BK Search</option>
                                                <option value="Plat Map">Plat Map</option>
                                                <option value="Order Sheet">Order Sheet</option>
                                            </select>
                                        </div>
                                        <label class="col-md-1 control-label">Description</label>
                                        <div class="col-md-2">
                                            <div class="form-group form-md-line-input has-info">
                                                <input type="text" class="form-control input-sm" name="edit_admin_orderupload_description" id="edit_admin_orderupload_description" data-validate="required" data-message-required="Please enter description." autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="btn grey-cascade fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span>
                                                    Browse files</span>
                                                <input type="file" name="edit_admin_orderupload_file" id="edit_admin_orderupload_file" data-validate="required" data-message-required="Please select file." onchange="$('#admin_upload_filename').html(this.value)">
                                            </span>
                                            <p id="admin_upload_filename"></p>
                                        </div>
                                        <button type="submit" class="btn blue">Upload</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-hover document_table" id="sample_2">
                                <thead>
                                    <tr>
                                        <th style="width:115px">Order No</th>                                  
                                        <th>Document Type</th>
                                        <th>Description</th>
                                        <th>File</th>
                                        <th>Uploaded By</th>
                                        <th style="background: none">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->db->where('Order_Id', $order_id);
                                    $q_orderdocments = $this->db->get('tbl_orderdocuments');
                                    foreach ($q_orderdocments->result() as $row_orderdocments) {
                                        $Doc_Type = $row_orderdocments->Doc_Type;
                                        $Description = $row_orderdocments->Description;
                                        $File = $row_orderdocments->File;
                                        $Uploaded_By = $row_orderdocments->Uploaded_By;
                                        $Inserted_By = $row_orderdocments->Inserted_By;
                                        if ($Uploaded_By == "admin") {
                                            $this->db->where('Admin_Id', $Inserted_By);
                                            $q_admin = $this->db->get('tbl_admin');
                                            foreach ($q_admin->result() as $row_admin) {
                                                $Uploaded_Username = $row_admin->Admin_Username;
                                            }
                                        } else {
                                            $this->db->where('User_Id', $Inserted_By);
                                            $q_user = $this->db->get('tbl_user');
                                            foreach ($q_user->result() as $row_user) {
                                                $Uploaded_Username = $row_user->Username;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $Order_Number; ?></td>
                                            <td><?php echo $Doc_Type; ?></td>
                                            <td><?php echo $Description; ?></td>
                                            <td><?php echo $File; ?></td>
                                            <td><?php echo $Uploaded_Username; ?></td>
                                            <td>
                                                <a target="_blank" class="btn btn-xs black" href="<?php echo site_url('Admin/download_document/' . $File); ?>">
                                                    <span class="glyphicon glyphicon-download fa fa-exclamation-triangle tooltips" data-original-title="Order Download"></span>
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
            <?php }
            ?>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>

<!-- Delete Order Upload Document Popup Start Here -->
<div id="delete_document_model" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Upload Order Document</h4>
            </div>
            <form role="form" id="deletedocument_form" name="deletedocument_form" method="post" class="form-horizontal">                
            </form>
        </div>
    </div>
</div>
<!-- Delete Order Upload Document Popup Start Here -->

