<?php
$client_id = $this->session->userdata('client_id');
$plan_id = $this->uri->segment(3);
$get_cart = array(
    'Plan_Id' => $plan_id,
    'User_Id' => $client_id,
    'Status' => 1
);
$this->db->where($get_cart);
$q_cart = $this->db->get('tbl_cartamount');

$get_plan = array(
    'Plan_Id' => $plan_id
);
$this->db->where($get_plan);
$q_plan = $this->db->get('tbl_plan');
foreach ($q_plan->result() as $row_plan) {
    $plan_name = $row_plan->Plan_Name;
}
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-screen-tablet"></i>Account History - <?php echo $plan_name; ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Plan Date</th>
                                    <th>Plan Name</th>
                                    <th>Plan Amount ($)</th> 
                                    <th>Paid Amount ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($q_cart->result() as $row_cart) {
                                    $plan_date1 = $row_cart->Inserted_Date;
                                    $plan_date = date("d-M-Y", strtotime($plan_date1));
                                    $plan_amount1 = $row_cart->Plan_Amount;
                                    $plan_amount = number_format((float) $plan_amount1, 2, '.', '');
                                    $Txn_Id = $row_cart->Txn_Id;
                                    $get_txn = array(
                                        'User_Id' => $client_id,
                                        'txn_id' => $Txn_Id,
                                        'Status' => 1
                                    );
                                    $this->db->where($get_txn);
                                    $q_txn = $this->db->get('tbl_transaction');
                                    foreach ($q_txn->result() as $row_txn) {
                                        $paid_amount = $row_txn->Paid_Amt;
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $plan_date; ?></td>
                                            <td><?php echo $plan_name; ?></td>
                                            <td><?php echo $plan_amount; ?></td>
                                            <td><?php echo $paid_amount; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
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
