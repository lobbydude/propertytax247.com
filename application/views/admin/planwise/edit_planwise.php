<?php
$this->db->where('S_Id', $s_id);
$q = $this->db->get('tbl_statewise');
foreach ($q->result() as $row) {
    $plan_id_select = $row->Plan_Id;
    $state_id_select = $row->State_Id;
    $this->db->where('Plan_Id', $plan_id_select);
    $q_plan_select = $this->db->get('tbl_plan');
    foreach ($q_plan_select->result() as $row_plan_select) {
        $plan_name_select = $row_plan_select->Plan_Name;
        $no_of_order_select = $row_plan_select->No_Of_Order;
    }
    $this->db->where('State_ID', $state_id_select);
    $q_state_select = $this->db->get('tbl_state');
    foreach ($q_state_select->result() as $row_state_select) {
        $state_select = $row_state_select->State;
    }
}
?>
<script src="<?php echo site_url('assets/global/scripts/multiselect.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit_planwise_county_from').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            }
        });
    });
</script>
<script>
    function showCounty(sel) {
        var state_id = sel.options[sel.selectedIndex].value;
        if (state_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Admin/fetch_county') ?>",
                data: "state_id=" + state_id,
                cache: false,
                success: function (msg) {
                    $("#edit_planwise_county_from").html(msg);
                    $('#edit_planwise_county_from_to option[value!="0"]').remove();
                }
            });
        }
    }
</script>
<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_planwise_exists" class="alert alert-info" style="display:none;">This plan details already exists.</div>
            <div id="edit_planwise_success" class="alert alert-success" style="display:none;">Plan details updated successfully.</div>
            <div id="edit_planwise_error" class="alert alert-danger" style="display:none;">Failed to update plan details.</div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="edit_planwise_id" id="edit_planwise_id" value="<?php echo $s_id ?>">
        <div class="form-group">
            <label class="control-label col-md-2">Plan <span class="required">* </span></label>
            <div class="col-md-8">
                <select class="form-control select2me" name="edit_planwise_plan" id="edit_planwise_plan">   
                    <option value="<?php echo $plan_id_select ?>"><?php echo $plan_name_select . "/" . $no_of_order_select . " orders"; ?></option>
                    <?php
                    $this->db->where('Plan_Id !=', $plan_id_select);
                    $q_plan = $this->db->get('tbl_plan');
                    foreach ($q_plan->result() as $row_plan) {
                        $plan_id = $row_plan->Plan_Id;
                        $plan_name = $row_plan->Plan_Name;
                        $no_of_order = $row_plan->No_Of_Order;
                        ?>
                        <option value="<?php echo $plan_id ?>"><?php echo $plan_name . "/" . $no_of_order . " orders"; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">State
                <span class="required">* </span>
            </label>
            <div class="col-md-8">
                <select class="form-control select2me" onChange="showCounty(this);" id="edit_planwise_state" name="edit_planwise_state">                                                   
                    <option value="<?php echo $state_id_select ?>"><?php echo $state_select; ?></option>
                    <?php
                    $this->db->where('State_ID !=', $state_id_select);
                    $q_state = $this->db->get('tbl_state');
                    foreach ($q_state->result() as $row_state) {
                        $state_id = $row_state->State_ID;
                        $state = $row_state->State;
                        ?>
                        <option value="<?php echo $state_id ?>"><?php echo $state; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">County
                <span class="required">* </span>
            </label>
            <div class="col-sm-4">
                <select name="edit_planwise_county_from[]" id="edit_planwise_county_from" class="form-control" size="8" multiple="multiple">
                    <?php
                    $data_county1 = array(
                        'State_ID' => $state_id_select,
                    );
                    $this->db->where($data_county1);
                    $q_county_select1 = $this->db->get('tbl_county');
                    $count_rows = $q_county_select1->num_rows();
                    foreach ($q_county_select1->result() as $row_county_select1) {
                        $county_id_select1 = $row_county_select1->County_ID;
                        $county_select1 = $row_county_select1->County;
                        ?>
                        <option value="<?php echo $county_id_select1; ?>"><?php echo $county_select1; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-sm-1" style="margin-top: 45px;">
                <button type="button" id="edit_planwise_county_from_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                <button type="button" id="edit_planwise_county_from_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                <button type="button" id="edit_planwise_county_from_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                <button type="button" id="edit_planwise_county_from_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
            </div>

            <div class="col-sm-4">
                <select name="edit_planwise_county_from_to[]" id="edit_planwise_county_from_to" class="form-control" size="8" multiple="multiple">
                    <?php
                    $this->db->where('Statewise_Id', $s_id);
                    $q_statewise2 = $this->db->get('tbl_countywise');
                    foreach ($q_statewise2->result() as $row_statewise2) {
                        $county_id2 = $row_statewise2->County_Id;
                        $data_county2 = array(
                            'State_ID' => $state_id_select,
                            'County_ID' => $county_id2
                        );
                        $this->db->where($data_county2);
                        $q_county_select2 = $this->db->get('tbl_county');
                        foreach ($q_county_select2->result() as $row_county_select2) {
                            $county_id_select2 = $row_county_select2->County_ID;
                            $county_select2 = $row_county_select2->County;
                            ?>
                            <option value="<?php echo $county_id_select2; ?>" selected="selected"><?php echo $county_select2; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn blue">Update</button>
    <button type="button" data-dismiss="modal" class="btn default">Close</button>
</div>