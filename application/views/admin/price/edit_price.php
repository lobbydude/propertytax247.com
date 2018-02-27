<?php
$this->db->where('Price_Id', $price_id);
$q = $this->db->get('tbl_price');
foreach ($q->result() as $row) {
    $price_id = $row->Price_Id;
    $plan_id = $row->Plan_Id;
    $product_type = $row->Product_Type;
    $order_type_id = $row->Order_Type;
    $price = $row->Price;
}
?>
<script>
    // No Space bar query
    $('#edit_price_amt').live('keydown', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 32) {
                e.preventDefault();
            }
        }); 
    </script>
<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
             <div id="edit_price_exists" class="alert alert-info" style="display:none;">Price details already exists.</div>
            <div id="edit_price_success" class="alert alert-success" style="display:none;">Price details updated successfully.</div>
            <div id="edit_price_error" class="alert alert-danger" style="display:none;">Failed to update Price details.</div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="edit_price_id" name="edit_price_id" value="<?php echo $price_id ?>">
        <div class="form-group">
            <label class="control-label col-md-3">Plan <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <select class="form-control select2me" name="edit_price_plan" id="edit_price_plan">                                        
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
            <label class="control-label col-md-3">Product Type<span class="required">
                    * </span>
            </label>
            <div class="col-md-9">
                <div class="radio-list" data-error-container="#form_2_membership_error" >
                    <div class="col-md-5">
                        <label>
                            <input type="radio" name="edit_price_type" id="edit_price_residential" value="Residential" <?php
                            if ($product_type == "Residential") {
                                echo "checked";
                            }
                            ?>/>
                            Residential </label>
                    </div>    
                     <div class="col-md-4">
                        <label>
                            <input type="radio" name="edit_price_type" id="edit_price_commercial" value="Commercial" <?php
                            if ($product_type == "Commercial") {
                                echo "checked";
                            }
                            ?>/>
                            Commercial </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Order Type <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <select class="form-control select2me" name="edit_price_orderype" id="edit_price_orderype">                                        
                    <?php
                    $this->db->where('Order_Type_ID', $order_type_id);
                    $q_ordertype = $this->db->get('tbl_ordertype');
                    foreach ($q_ordertype->result() as $row_ordertype) {
                        $order_type = $row_ordertype->Order_Type;
                        ?>
                        <option value="<?php echo $order_type_id ?>"><?php echo $order_type; ?></option>
                        <?php
                    }
                    $this->db->where('Order_Type_ID !=', $order_type_id);
                    $q_ordertype_select = $this->db->get('tbl_ordertype');
                    foreach ($q_ordertype_select->result() as $row_ordertype_select) {
                        $ordertype_id_select = $row_ordertype_select->Order_Type_ID;
                        $order_type_select = $row_ordertype_select->Order_Type;
                        ?>
                        <option value="<?php echo $ordertype_id_select ?>"><?php echo $order_type_select; ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"> Price <span class="required"> * </span>
            </label>
            <div class="col-md-8">
                <div class="form-group form-md-line-input has-info">
                    <input type="text" class="form-control input-sm" name="edit_price_amt" id="edit_price_amt" placeholder="Price" value="<?php echo $price; ?>">
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