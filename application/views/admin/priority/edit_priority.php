<?php
$this->db->where('Priority_Id', $priority_id);
$q = $this->db->get('tbl_priority');
foreach ($q->result() as $row) {
    $plan_id = $row->Plan_Id;
    $priority_type = $row->Priority_Type;
    $priority_price = $row->Priority_Price;
    $priority_duration = $row->Priority_Duration;
}
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div id="edit_priority_exists" class="alert alert-info" style="display:none;">Priority details already exists.</div>
            <div id="edit_priority_success" class="alert alert-success" style="display:none;">Priority details updated successfully.</div>
            <div id="edit_priority_error" class="alert alert-danger" style="display:none;">Failed to update priority details.</div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="edit_priority_id" name="edit_priority_id" value="<?php echo $priority_id ?>">
        <div class="form-group">
            <label class="control-label col-md-3">Plan Name <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <select class="form-control select2me" name="edit_priority_plan" id="edit_priority_plan">
                    <?php
                    $this->db->where('Plan_Id', $plan_id);
                    $q_plan = $this->db->get('tbl_plan');
                    foreach ($q_plan->result() as $row_plan) {
                        $plan_name = $row_plan->Plan_Name;
                        $no_of_order = $row_plan->No_Of_Order;
                        ?>
                        <option value="<?php echo $plan_id ?>"><?php echo $plan_name . " / " . $no_of_order . " orders"; ?></option>
                        <?php
                    }
                    $this->db->where('Plan_Id !=', $plan_id);
                    $q_plan_select = $this->db->get('tbl_plan');
                    foreach ($q_plan_select->result() as $row_plan_select) {
                        $plan_id_select = $row_plan_select->Plan_Id;
                        $plan_name_select = $row_plan_select->Plan_Name;
                        $no_of_order_select = $row_plan_select->No_Of_Order;
                        ?>
                        <option value="<?php echo $plan_id_select ?>"><?php echo $plan_name_select . " / " . $no_of_order_select . " orders"; ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Priority Type<span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <select class="form-control select2me" name="edit_priority_type" id="edit_priority_type">
                    <option value="<?php echo $priority_type; ?>"><?php echo $priority_type; ?></option>                    
                    <!--<option value="Rush Order">Rush Order</option>-->
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Priority Price <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-8">
                <div class="form-group form-md-line-input has-info">
                    <input type="text" class="form-control input-sm" name="edit_priority_price" id="edit_priority_price" placeholder="Price" value="<?php echo $priority_price; ?>">
                    <label for="form_control_1"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Duration <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-8">
                <div class="form-group form-md-line-input has-info">
                    <input type="text" class="form-control input-sm" name="edit_priority_duration" id="edit_priority_duration" placeholder="Duration" value="<?php echo $priority_duration; ?>">
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