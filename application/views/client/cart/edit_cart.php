<?php
session_start();
if ($this->uri->segment(3) != "") {
    $code = $this->uri->segment(3);
} else {
    $code = $_POST['code'];
}
foreach ($_SESSION["cart_item"] as $k => $v) {
    if ($code == $v["code"]) {
        $order_type = $v['order_type'];
        $plan_id = $v['plan_name'];
        $state = $v['state'];
        $county = $v['county'];
        $countyorder = $v['countyorder'];
        $no_of_order = $v['no_of_order'];
        $price = $v['price'];
    }
}

$this->db->where('Plan_Id', $plan_id);
$q_plan = $this->db->get('tbl_plan');
foreach ($q_plan->result() as $row_plan) {
    $plan_name = $row_plan->Plan_Name;
    $plan_price = $row_plan->Price;
}
?>
<script language="javascript" type="text/javascript">
function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }
}
</script>
<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
                <div id="add_cart_success" class="alert alert-success" style="display:none;">Cart details added successfully.</div>
                <div id="add_cart_exists" class="alert alert-danger" style="display:none;">State and County already exists.</div>
                <div id="add_cart_error" class="alert alert-danger" style="display:none;">Failed to add cart details.</div>
                <div id="add_cart_validateerror" class="alert alert-danger" style="display:none;">Please enter all data.</div>
                <div id="add_cart_delete" class="alert alert-success" style="display:none;">County deleted successfully.</div>
                <div id="mincart_item" class="alert alert-danger" style="display:none;">FOR BULK ORDERS - THE MINIMUM ORDERS SHOULD BE IN 10, 20 30..</div>
            </div>
    </div>
    <div class="row">
        <input type="hidden" value="<?php echo $code; ?>" name="order_code" id="order_code">
        <input type="hidden" value="<?php echo $order_type; ?>" name="order_type" id="order_type">

        <div class="form-group">
            <label class="control-label col-md-3">Plan Name : <b><?php echo $plan_name; ?></b></label>
            <label class="control-label col-md-3">Orders : <b><?php echo $order_type; ?></b></label>
            <label class="control-label col-md-6">Price : <b><?php echo $price; ?></b></label>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">State <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-5">
                <select class="form-control select2me" id="add_state" name="add_state" onchange="change_county(this.value)">
                    <option value=''> --Select State-- </option>
                    <?php
                    $get_statewise = array(
                        'Plan_Id' => $plan_id,
                        'Status' => 1
                    );
                    $this->db->where($get_statewise);
                    $q_statewise = $this->db->get('tbl_statewise');
                    $count_statewise = $q_statewise->num_rows();
                    if ($count_statewise > 0) {
                        foreach ($q_statewise->result() as $row_statewise) {
                            $S_Id = $row_statewise->S_Id;
                            $State_Id = $row_statewise->State_Id;
                            $this->db->where('State_ID', $State_Id);
                            $q_state = $this->db->get('tbl_state');
                            foreach ($q_state->result() as $row_state) {
                                $Abbreviation = $row_state->Abbreviation;
                                ?>
                                <option value="<?php echo $S_Id; ?>"><?php echo $Abbreviation; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">County <span class="required"> * </span> </label>                                                                                                
            <div class="col-md-5">
                <select class="form-control select2me" id="add_county" name="add_county">
                    <option value=''> --Select County-- </option>
                </select>
            </div>            
        </div>

        <?php if ($order_type == "Bulk") { ?>
            <div class = "form-group">
                <label class = "control-label col-md-3">No of Orders <span class = "required"> * </span> </label>
                <div class = "col-md-1">
                    <div class = "form-group form-md-line-input has-info">
                        <input type="number" name="no_of_order" style="width: 37px; text-align:center;" value="0" min="1" max="10" maxlength="2" id="no_of_order" class='form-control input-sm' onKeyDown="limitText(this,5);"
onKeyUp="limitText(this,5);">                        
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="button" class="delete" name="add" value="Add" onclick="Addcart()">
                </div>
            </div>
        <?php } else { ?>
            <div class = "form-group">
                <label class = "control-label col-md-3"></label>
                <div class="col-md-3">
                    <input type="button" class="delete" name="add" value="Add" onclick="Addcart()">
                </div>
            </div>
        <?php } ?>
    </div>
    <div class='row'>
        <div class="col-md-12">        
            <div class="modify">
                <ul>
                    <?php
                    if ($order_type == "Single") {
                        $q_statewise = "select * from tbl_statewise where Status=1 AND S_Id=$state";
                        $result_statewise = mysql_query($q_statewise);
                        while ($row_statewise = mysql_fetch_array($result_statewise)) {
                            $state_id = $row_statewise['State_Id'];
                            $q_county = "select * from tbl_county where County_ID=$county";
                            $result_county = mysql_query($q_county);
                            while ($row_county = mysql_fetch_array($result_county)) {
                                $county_name = $row_county['County'];
                            }
                            $q_state = "select * from tbl_state where State_ID=$state_id";
                            $result_state = mysql_query($q_state);
                            while ($row_state = mysql_fetch_array($result_state)) {
                                $state_abbreviation = $row_state['Abbreviation'];
                                ?>
                                <li>
                                    <?php echo $state_abbreviation . " - " . $county_name; ?>
                                </li>
                                <?php
                            }
                        }
                    } else {
                        $county_order_array = explode('|', $countyorder);
                        $count_county_order = count($county_order_array);
                        for ($l = 0; $l < ($count_county_order - 1); $l++) {
                            $county_order_no = $county_order_array[$l];                            
                            ?>
                            <li class='col-md-4'>
                                <?php echo $county_order_no; ?> 
                                <i class="fa fa-close" style="cursor:pointer;" onclick="removecart('<?php echo $county_order_no ?>', '<?php echo $code; ?>','<?php echo $countyorder;?>')"></i>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>                
            </div>         
        </div>     
    </div>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn blue" onclick="window.location.reload()">Close</button>
</div>