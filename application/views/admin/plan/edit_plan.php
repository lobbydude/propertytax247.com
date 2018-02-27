<?php
$this->db->where('Plan_Id', $plan_id);
$q = $this->db->get('tbl_plan');
foreach ($q->result() as $row) {
    $plan_name = $row->Plan_Name;
    $type = $row->Type;
    $no_of_order = $row->No_Of_Order;
    $plan_price = $row->Price;
}
?>
<script>
    $('#edit_plan_name').live('keydown', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 32) {
            e.preventDefault();
        }
    });
    $('#edit_no_of_order').live('keydown', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 32) {
            e.preventDefault();
        }
    });
    $('#edit_plan_price').live('keydown', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 32) {
            e.preventDefault();
        }
    });
    function edit_change_order(type) {
        if (type == "Single") {
            $('#edit_no_of_order').val("1");
            $("#edit_no_of_order").attr("disabled", "disabled");
        } else {
            $("#edit_no_of_order").removeAttr("disabled");
        }
    }
</script>
<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_plan_success" class="alert alert-success" style="display:none;">Plan details updated successfully.</div>
            <div id="edit_plan_exists" class="alert alert-info" style="display:none;">Plan details already exists.</div>
            <div id="edit_plan_error" class="alert alert-danger" style="display:none;">Failed to update plan details.</div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="edit_plan_id" name="edit_plan_id" value="<?php echo $plan_id ?>">
        <div class="form-group">
            <label class="control-label col-md-3">Plan Name <span class="required"> * </span>
            </label>
            <div class="col-md-8">
                <div class="form-group form-md-line-input has-info">
                    <input type="text" class="form-control input-sm" name="edit_plan_name" id="edit_plan_name" placeholder="No of Orders" value="<?php echo $plan_name; ?>">
                    <label for="form_control_1"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Type <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-8">
                <select class="form-control select2me" id="edit_order_type" name="edit_order_type" onchange="edit_change_order(this.value)">
                    <option value="Single" <?php
                    if ($type == "Single") {
                        echo "selected=selected";
                    }
                    ?>>Single</option>
                    <option value="Bulk" <?php
                    if ($type == "Bulk") {
                        echo "selected=selected";
                    }
                    ?>>Bulk</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">No of Orders <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-8">
                <div class="form-group form-md-line-input has-info">
                    <input type="text" class="form-control input-sm" name="edit_no_of_order" id="edit_no_of_order" placeholder="No of Orders" value="<?php echo $no_of_order; ?>" <?php
                    if ($type == "Single") {
                        echo "disabled=disabled";
                    }
                    ?>>
                    <label for="form_control_1"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Price ($) <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-8">
                <div class="form-group form-md-line-input has-info">
                    <input type="text" class="form-control input-sm" name="edit_plan_price" id="edit_plan_price" placeholder="Price" value="<?php echo $plan_price; ?>">
                    <label for="form_control_1"></label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn blue">Update</button>
    <button type="button" data-dismiss="modal" class="btn default">Close</button>
</div>