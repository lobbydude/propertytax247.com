<?php
$this->db->order_by('S_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_statewise');

$this->db->order_by('Plan_Id', 'desc');
$this->db->where('Status', 1);
$q_plan = $this->db->get('tbl_plan');

$this->db->order_by('State_ID', 'desc');
$q_state = $this->db->get('tbl_state');
?>

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
                    $("#add_planwise_county_from").html(msg);
                    // $("#ms-add_planwise_county").load(location.href + " #ms-add_planwise_county");
                }
            });
        }
    }
    function edit_Planwise(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Planwise/Editplanwise') ?>",
            data: "s_id=" + id,
            cache: false,
            success: function (html) {
                $("#editplanwise_form").html(html);

            }
        });
    }

    function delete_Planwise(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Planwise/Deleteplanwise') ?>",
            data: "s_id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteplanwise_form").html(html);
            }
        });
    }
</script>
<script src="<?php echo site_url('assets/global/scripts/multiselect.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_planwise_county_from').multiselect();
        $('#multiselectdemo').multiselect();

    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-globe"></i>State and County Wise Plan
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <select name="from[]" id="multiselectdemo" class="form-control" size="8" multiple="multiple">
                                    <option value="1" data-position="1">Item 1</option>
                                    <option value="2" data-position="2">Item 5</option>
                                    <option value="2" data-position="3">Item 2</option>
                                    <option value="2" data-position="4">Item 4</option>
                                    <option value="3" data-position="5">Item 3</option>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <button type="button" id="multiselectdemo_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                <button type="button" id="multiselectdemo_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                <button type="button" id="multiselectdemo_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                <button type="button" id="multiselectdemo_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                            </div>

                            <div class="col-sm-5">
                                <select name="to[]" id="multiselectdemo_to" class="form-control" size="8" multiple="multiple">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="add_planwise_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">State and County Wise Plan</h4>
                            </div>
                            <form action="#" id="add_planwise_form" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="add_planwise_success" class="alert alert-success" style="display:none;">Plan details added successfully.</div>
                                            <div id="add_planwise_error" class="alert alert-danger" style="display:none;">Failed to add plan details.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Plan <span class="required">* </span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" name="add_planwise_plan" id="add_planwise_plan">   
                                                    <?php
                                                    foreach ($q_plan->result() as $row_plan) {
                                                        $plan_id = $row_plan->Plan_Id;
                                                        $plan_name = $row_plan->Plan_Name;
                                                        $no_of_order = $row_plan->No_Of_Order;
                                                        ?>
                                                        <option value="<?php echo $plan_id ?>"><?php echo $plan_name . " / " . $no_of_order . " orders"; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">State
                                                <span class="required">* </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" onChange="showCounty(this);" id="add_planwise_state" name="add_planwise_state">                                                   
                                                    <option value="0"> Select State </option>
                                                    <?php
                                                    foreach ($q_state->result() as $row_state) {
                                                        $state_id = $row_state->State_ID;
                                                        $state = $row_state->State;
                                                        ?>
                                                        <option value="<?php echo $state_id ?>"><?php echo $state; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="planwise_county_div">
                                            <label class="control-label col-md-3">County
                                                <span class="required">* </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="col-sm-5">
                                                    <select name="add_planwise_county_from[]" id="add_planwise_county_from" class="form-control" size="8" multiple="multiple">
                                                        <option value="1" data-position="1">Item 1</option>
                                                        <option value="2" data-position="2">Item 5</option>
                                                        <option value="2" data-position="3">Item 2</option>
                                                        <option value="2" data-position="4">Item 4</option>
                                                        <option value="3" data-position="5">Item 3</option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-2">
                                                    <button type="button" id="add_planwise_county_from_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                    <button type="button" id="add_planwise_county_from_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                    <button type="button" id="add_planwise_county_from_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                    <button type="button" id="add_planwise_county_from_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                                </div>

                                                <div class="col-sm-5">
                                                    <select name="add_planwise_county_to[]" id="add_planwise_county_from_to" class="form-control" size="8" multiple="multiple">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">County
                                            <span class="required">* </span>
                                        </label>
                                        <div class="col-md-8">
                                            <select name="add_planwise_countydemo[]" id="add_planwise_countydemo" class="multi-select" multiple="multiple" style="position: absolute; left: -9999px;">                    <option value="2954">ADAMS</option>
                                                <option value="2955">ASOTIN</option>
                                                <option value="7008">BARRON</option>
                                                <option value="7009">BAYFIELD</option>
                                                <option value="2956">BENTON</option>
                                                <option value="7010">BROWN</option>
                                                <option value="6767">CHALLAM</option>
                                                <option value="2957">CHELAN</option>
                                                <option value="2958">CLALLAM</option>
                                                <option value="2959">CLARK</option>
                                                <option value="2960">COLUMBIA</option>
                                                <option value="2961">COWLITZ</option>
                                                <option value="7011">DANE</option>
                                                <option value="2962">DOUGLAS</option>
                                                <option value="7012">DUNN</option>
                                                <option value="7013">EAU CLAIRE</option>
                                                <option value="6797">EDMONDS</option>
                                                <option value="2963">FERRY</option>
                                                <option value="2964">FRANKLIN</option>
                                                <option value="2965">GARFIELD</option>
                                                <option value="2966">GRANT</option>
                                                <option value="2967">GRAYS HARBOR</option>
                                                <option value="2968">ISLAND</option>
                                                <option value="2969">JEFFERSON</option>
                                                <option value="2970">KING</option>
                                                <option value="2971">KITSAP</option>
                                                <option value="2972">KITTITAS</option>
                                                <option value="2973">KLICKITAT</option>
                                                <option value="7014">LACROSSE</option>
                                                <option value="7015">LAFAYETTE</option>
                                                <option value="2974">LEWIS</option>
                                                <option value="2975">LINCOLN</option>
                                                <option value="2976">MASON</option>
                                                <option value="2977">OKANOGAN</option>
                                                <option value="2978">PACIFIC</option>
                                                <option value="2979">PEND OREILLE</option>
                                                <option value="2980">PIERCE</option>
                                                <option value="2981">SAN JUAN</option>
                                                <option value="2982">SKAGIT</option>
                                                <option value="2983">SKAMANIA</option>
                                                <option value="2984">SNOHOMISH</option>
                                                <option value="2985">SPOKANE</option>
                                                <option value="2986">STEVENS</option>
                                                <option value="2987">THURSTON</option>
                                                <option value="2988">WAHKIAKUM</option>
                                                <option value="2989">WALLA WALLA</option>
                                                <option value="2990">WHATCOM</option>
                                                <option value="2991">WHITMAN</option>
                                                <option value="2992">YAKIMA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn blue">Save</button>
                            <button type="button" data-dismiss="modal" class="btn default">Close</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Planwise Popup Start Here -->
            <div id="edit_planwise_model" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Edit Plan Details</h4>
                        </div>
                        <form role="form" id="editplanwise_form" method="post" class="form-horizontal">

                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Planwise Popup End Here -->

            <!-- Delete Planwise Popup Start Here -->
            <div id="delete_planwise_model" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Delete Plan Details</h4>
                        </div>
                        <form role="form" id="deleteplanwise_form" method="post" class="form-horizontal">

                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Planwise Popup End Here -->
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<a class="b-c WpoiA" data-toggle="modal" href="#add_planwise_model">
    <i class="fa fa-plus"></i>
</a>
</div>
<!-- END CONTENT -->
