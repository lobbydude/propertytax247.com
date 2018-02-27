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
                    $("#add_planwise_county_div").show(10);
                    $("#add_planwise_county_from").html(msg);
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
        $('#add_planwise_county_from').multiselect({
            includeSelectAllOption: true,
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            }
        });

        $("#import_state_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('Planwise/import_state') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#import_state_error').show();
                    }
                    else {
                        $('#import_state_success').show();
                    }
                },
                error: function ()
                {
                }
            });
        }));

        $("#import_county_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('Planwise/import_county') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#import_county_error').show();
                    }
                    else {
                        $('#import_county_success').show();
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
            <div class="col-md-12 col-sm-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-globe"></i>State and County Wise Plan
                        </div>
                        <div class="tools hidden-xs" style="width:15%">                              
                            <button id="btnExport" class="btn-default">Export to excel</button>                        
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="reload" style="padding-top: 10px;"></a>
                            <a data-toggle="modal" href="#import_state_model" style="color:#fff; font-weight:bold;text-decoration:underline;">Import State</a>
                            <a data-toggle="modal" href="#import_county_model" style="color:#fff; font-weight:bold; text-decoration:underline;">Import County</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>
                                    <th style="width:35px">S.No</th>
                                    <th>Plan</th>
                                    <th>State</th>
                                    <th style="width:70px;background: none">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($q->result() as $row) {
                                    $S_Id = $row->S_Id;
                                    $plan_id = $row->Plan_Id;
                                    $state_id_select = $row->State_Id;
                                    $this->db->where('Plan_Id', $plan_id);
                                    $q_plan_select = $this->db->get('tbl_plan');
                                    foreach ($q_plan_select->result() as $row_plan_select) {
                                        $plan_name = $row_plan_select->Plan_Name;
                                    }
                                    $this->db->where('State_ID', $state_id_select);
                                    $q_state_select = $this->db->get('tbl_state');
                                    foreach ($q_state_select->result() as $row_state_select) {
                                        $state_select = $row_state_select->State;
                                        $abbreviation_select = $row_state_select->Abbreviation;
                                    }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $plan_name; ?></td>
                                        <td><?php echo $abbreviation_select . "-" . $state_select; ?></td>
                                        <td>                                        
                                            <a class="btn btn-xs black node-buttons" data-toggle="modal" href="#edit_planwise_model" onclick="edit_Planwise(<?php echo $S_Id; ?>)">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <a class="btn btn-xs node-buttons" data-toggle="modal" href="#delete_planwise_model" onclick="delete_Planwise(<?php echo $S_Id; ?>)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="add_planwise_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" style="width: 60%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">State and County Wise Plan</h4>
                            </div>
                            <form action="#" id="add_planwise_form" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="add_planwise_exists" class="alert alert-info" style="display:none;">This plan details already exists.</div>
                                            <div id="add_planwise_success" class="alert alert-success" style="display:none;">Plan details added successfully.</div>
                                            <div id="add_planwise_error" class="alert alert-danger" style="display:none;">Failed to add plan details.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Plan <span class="required">* </span></label>
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
                                            <label class="control-label col-md-2">State
                                                <span class="required">* </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" onChange="showCounty(this);" id="add_planwise_state" name="add_planwise_state">                                                   
                                                    <option value="0"> Select State </option>
                                                    <?php
                                                    foreach ($q_state->result() as $row_state) {
                                                        $state_id = $row_state->State_ID;
                                                        $state = $row_state->State;
                                                        $abbreviation = $row_state->Abbreviation;
                                                        ?>
                                                        <option value="<?php echo $state_id ?>"><?php echo $abbreviation . "-" . $state; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="add_planwise_county_div" style="display:none">
                                            <label class="control-label col-md-2">County
                                                <span class="required">* </span>
                                            </label>
                                            <div class="col-sm-4">
                                                <select name="add_planwise_county_from[]" id="add_planwise_county_from" class="form-control" size="8" multiple="multiple">

                                                </select>
                                            </div>
                                            <div class="col-sm-1" style="margin-top: 45px">
                                                <button type="button" id="add_planwise_county_from_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                <button type="button" id="add_planwise_county_from_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                <button type="button" id="add_planwise_county_from_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                <button type="button" id="add_planwise_county_from_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                            </div>
                                            <div class="col-sm-4">
                                                <select name="add_planwise_county_from_to[]" id="add_planwise_county_from_to" class="form-control" size="8" multiple="multiple">

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
                    <div class="modal-dialog"  style="width: 60%">
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

                <div id="import_state_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Import State</h4>
                            </div>
                            <form action="#" id="import_state_form" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="import_state_success" class="alert alert-success" style="display:none;">State imported successfully.</div>
                                            <div id="import_state_error" class="alert alert-danger" style="display:none;">Failed to import state.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Plan <span class="required">* </span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" name="import_state_plan" id="import_state_plan">   
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
                                            <label class="col-md-2 control-label">Upload </label>
                                            <div class="col-md-2">
                                                <span class="btn grey-cascade fileinput-button">
                                                    <i class="fa fa-plus"></i>
                                                    <span>Upload files... </span>
                                                    <input type="file" name="import_state_file" id="import_state_file" data-validate="required" data-message-required="Please select file." onchange="$('#import_state_filename').html(this.value)">
                                                </span>
                                                <p id="import_state_filename"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn blue">Upload</button>
                                    <button type="button" data-dismiss="modal" class="btn default">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div id="import_county_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Import County</h4>
                            </div>
                            <form action="#" id="import_county_form" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="import_county_success" class="alert alert-success" style="display:none;">County imported successfully.</div>
                                            <div id="import_county_error" class="alert alert-danger" style="display:none;">Failed to import county.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Upload </label>
                                            <div class="col-md-2">
                                                <span class="btn grey-cascade fileinput-button">
                                                    <i class="fa fa-plus"></i>
                                                    <span>Upload files... </span>
                                                    <input type="file" name="import_county_file" id="import_county_file" data-validate="required" data-message-required="Please select file." onchange="$('#import_county_filename').html(this.value)">
                                                </span>
                                                <p id="import_county_filename"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn blue">Upload</button>
                                    <button type="button" data-dismiss="modal" class="btn default">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <a class="b-c WpoiA" data-toggle="modal" href="#add_planwise_model">
        <i class="fa fa-plus"></i>
    </a>
</div>
<!-- END CONTENT -->
