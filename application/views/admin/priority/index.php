<?php
$this->db->order_by('Plan_Id', 'desc');
$this->db->where('Status', 1);
$q_plan = $this->db->get('tbl_plan');

$this->db->order_by('Priority_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_priority');
?>
<script>
    function edit_Priority(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Priority/Editpriority') ?>",
            data: "priority_id=" + id,
            cache: false,
            success: function (html) {
                $("#editpriority_form").html(html);

            }
        });
    }
    
    function delete_Priority(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Priority/Deletepriority') ?>",
            data: "priority_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletepriority_form").html(html);

            }
        });
    }
    
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-map"></i>Priority
                        </div>						<div class="tools hidden-xs" style="width:15%">                              <button id="btnExport" class="btn-default">Export to excel</button>                        </div>						
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Priority Type</th>
                                    <th>Priority Price ($)</th>
                                    <th>Priority Duration</th>
                                    <th style="width:70px;background: none">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($q->result() as $row) {
                                    $priority_id = $row->Priority_Id;
                                    $plan_id = $row->Plan_Id;
                                    $priority_type = $row->Priority_Type;
                                    $priority_price = $row->Priority_Price;
                                    $priority_duration = $row->Priority_Duration;
                                    $this->db->where('Plan_Id', $plan_id);
                                    $select_plan = $this->db->get('tbl_plan');
                                     foreach ($select_plan->result() as $row_select_plan) {
                                          $plan_name = $row_select_plan->Plan_Name;										  $plan_type = $row_select_plan->Type;
                                     }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $plan_name . " - " . $plan_type; ?></td>
                                        <td><?php echo $priority_type; ?></td>
                                        <td><?php echo $priority_price; ?></td>
                                        <td><?php echo $priority_duration; ?></td>

                                        <td>                                        
                                            <a class="btn btn-xs black node-buttons" data-toggle="modal" href="#edit_priority_model" onclick="edit_Priority(<?php echo $priority_id; ?>)">
                                               <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <a class="btn btn-xs node-buttons" data-toggle="modal" href="#delete_priority_model" onclick="delete_Priority(<?php echo $priority_id; ?>)">
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
                <!-- Add Priority Popup Start Here --> 
                <div id="add_priority_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">New Priority</h4>
                            </div>
                            <form role="form" id="add_priority_form" method="post" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="add_priority_exists" class="alert alert-info" style="display:none;">Priority details already exists.</div>
                                            <div id="add_priority_success" class="alert alert-success" style="display:none;">Priority details added successfully.</div>
                                            <div id="add_priority_error" class="alert alert-danger" style="display:none;">Failed to add priority details.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Plan Name 
                                                <span class="required">  * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" name="add_priority_plan" id="add_priority_plan">                                                   
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
                                            <label class="control-label col-md-3">Priority Type<span class="required">
                                                    * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me" name="add_priority_type" id="add_priority_type">
                                                    <option value="Rush Order" selected="selected">Rush Order</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Priority Price <span class="required"> * </span> </label>                                                                                                
                                            <div class="col-md-8">
                                                <div class="form-group form-md-line-input has-info">
                                                    <input type="text" class="form-control input-sm" name="add_priority_price" id="add_priority_price" placeholder="Price">
                                                    <label for="form_control_1"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Duration <span class="required"> * </span> </label>                                                                                                
                                            <div class="col-md-8">
                                                <div class="form-group form-md-line-input has-info">
                                                    <input type="text" class="form-control input-sm" name="add_priority_duration" id="add_priority_duration" placeholder="Priority Duration">
                                                    <label for="form_control_1"></label>
                                                </div>
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
                <!-- Add Priority Popup End Here -->

                <!-- Edit Priority Popup Start Here -->
                <div id="edit_priority_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Edit Priority</h4>
                            </div>
                            <form role="form" id="editpriority_form" method="post" class="form-horizontal">

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Priority Popup End Here -->

                <!-- Delete Priority Popup Start Here -->
                <div id="delete_priority_model" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Delete Priority</h4>
                            </div>
                            <form role="form" id="deletepriority_form" method="post" class="form-horizontal">

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Priority Popup End Here -->
            </div>
        </div>
    </div>
    <a class="b-c WpoiA" data-toggle="modal" href="#add_priority_model">
        <i class="fa fa-plus"></i>
    </a>
</div>

<!--Priority Data table Export in Excel-->
<script src="<?php echo site_url('assets/global/export/datatables.js') ?>"></script>
<link href="<?php echo site_url('assets/global/export/datatables.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript">$( document ).ready(function() {
    $('#sample_2').DataTable({
        "processing": true,
        "dom": 'lBfrtip',
        "buttons": [            
            {                
                extend: 'collection',                
                text: 'Export',                
                buttons: [                                        
                    'excel',                                        
                    'pdf'  
                ]            
            }        
        ]       
    })
    ;});
</script>