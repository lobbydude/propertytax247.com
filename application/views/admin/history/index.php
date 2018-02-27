<?php
$get_refund = array(
    'Status' => 1
);
$this->db->where($get_refund);
$this->db->order_by('R_Id', 'asc');
$q_refund = $this->db->get('tbl_refund');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-briefcase"></i>Refund History
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
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
                                    $User_Id = $row_refund->User_Id;
                                    $get_user = array(
                                        'User_Id' => $User_Id
                                    );
                                    $this->db->where($get_user);
                                    $q_user = $this->db->get('tbl_user');
                                    foreach ($q_user->result() as $row_user) {
                                        $Username = $row_user->Username;
                                    }
                                    $plan_id = $row_refund->Plan_Id;
                                    $get_plan = array(
                                        'Plan_Id' => $plan_id
                                    );
                                    $this->db->where($get_plan);
                                    $q_plan = $this->db->get('tbl_plan');
                                    foreach ($q_plan->result() as $row_plan) {
                                        $plan_name = $row_plan->Plan_Name;
                                    }
                                    $Reason = $row_refund->Reason;
                                    $Refund_Status = $row_refund->Refund_Status;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $Username; ?></td>
                                        <td><?php echo $plan_name; ?></td>
                                        <td><?php echo $Reason; ?></td>
                                        <td><?php echo $Refund_Status; ?></td>
                                        <td>
                                            <a class="btn btn-xs black node-buttons" href="<?php echo site_url('Admin/ViewRefund/' . $R_Id) ?>">
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
