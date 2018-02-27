<?php
$client_id = $this->session->userdata('client_id');
$get_txn = array(
    'User_Id' => $client_id,
    'Mode' => 'Transfer',
    'Status' => 1
);
$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn);
$q_txn = $this->db->get('tbl_transaction');
$result_txn = $q_txn->result();
$plan_amount1 = $result_txn[0]->Paid_Amt;
$plan_amount = number_format((float) $plan_amount1, 2, '.', '');

$get_txn_paid = array(
    'User_Id' => $client_id,
    'Mode' => 'Transfer',
    'Status' => 1
);
$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn_paid);
$q_txn_paid = $this->db->get('tbl_transaction');
$result_txn_paid = $q_txn_paid->result();
$paid_amount = $result_txn_paid[0]->Paid_Amt;
$get_txn_refund = array(
    'User_Id' => $client_id,
    'Mode' => 'Refund',
    'Status' => 1
);

$this->db->select_sum('Paid_Amt');
$this->db->where($get_txn_refund);
$q_txn_refund = $this->db->get('tbl_transaction');
$result_txn_refund = $q_txn_refund->result();
$refund_amount = $result_txn_refund[0]->Paid_Amt;
$total_paid_amount = $paid_amount - $refund_amount;

$get_acc = array(
    'User_Id' => $client_id,
    'Status' => 1
);
$this->db->select_sum('Order_Amount');
$this->db->where($get_acc);
$q_acc = $this->db->get('tbl_billing');
$result_acc = $q_acc->result();
$total_amount = $result_acc[0]->Order_Amount;
$balance1 = $total_paid_amount - $total_amount;
$balance = number_format((float) $balance1, 2, '.', '');

$get_cartamount = array(
    'User_Id' => $client_id,
    'Status' => 1
);
$this->db->where($get_cartamount);
$q_cartamount = $this->db->get('tbl_cartamount');
?>

<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption" style="padding-top: 19px;">
                            <i class="icon-screen-tablet"></i>Account History
                        </div>
                        <div class="tools hidden-xs" style="width:54%">
                            <div class="col-md-6" style="margin-left:90px;">
                                <h4 id="plantotal_head"><strong> Total Balance Amount : $<?php echo $balance; ?></strong></h4>
							</div>
							<div class="col-md-4">
                              <button id="btnExport" class="btn-default">Export to excel</button>
							</div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>                                    
                                    <th>Plan Name</th>
                                    <th>Plan Amount ($)</th>
                                    <th>Total Amount ($)</th>
                                    <th>Balance Amount ($)</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($q_cartamount->result() as $row_cartamount) {
                                    $plan_id = $row_cartamount->Plan_Id;
                                    $txn_id = $row_cartamount->Txn_Id;
                                    $no_of_order_total = $row_cartamount->No_Of_Order;
                                    $get_plan = array(
                                        'Plan_Id' => $plan_id
                                    );
                                    $this->db->where($get_plan);
                                    $q_plan = $this->db->get('tbl_plan');
                                    foreach ($q_plan->result() as $row_plan) {
                                        $plan_name = $row_plan->Plan_Name;
                                        $plan_type = $row_plan->Type;
                                    }
                                    $plan_date1 = $row_cartamount->Inserted_Date;
                                    $plan_date = date("d-M-Y", strtotime($plan_date1));
                                    $plan_cart_amount1 = $row_cartamount->Plan_Amount;
                                    $plan_cart_amount = number_format((float) $plan_cart_amount1, 2, '.', '');
                                    if ($plan_type == "Single") {
                                        $total_plan_amount = $plan_cart_amount;
                                    }
                                    if ($plan_type == "Bulk") {
                                        $no_of_order = $no_of_order_total / 10;
                                        $total_plan_amount1 = $plan_cart_amount * $no_of_order;
                                        $total_plan_amount = number_format((float) $total_plan_amount1, 2, '.', '');
                                    }
                                    $total_acc=0;
                                    $get_accamount = array(
                                        'Txn_Id'=>$txn_id,
                                        'Plan_Id'=>$plan_id,
                                        'User_Id' => $client_id,
                                        'Status' => 1
                                    );
                                    $this->db->where($get_accamount);
                                    $q_accamount = $this->db->get('tbl_account');
                                    foreach($q_accamount->result() as $row_accamount){
                                        $total_accamount=$row_accamount->Total_Amount;
                                        $total_acc=$total_acc+$total_accamount;
                                    }
                                    $balance_amount1=$total_plan_amount-$total_acc;
                                    $balance_amount = number_format((float) $balance_amount1, 2, '.', '');
                                    ?>

                                    <tr class="odd gradeX">                                                                                
                                        <td><?php echo $plan_name . " ($plan_type)"; ?></a></td>
                                        <td><?php echo $plan_cart_amount; ?></td>
                                        <td><?php echo $total_plan_amount; ?></td>
                                        <td>
										<?php 
										if($balance_amount>0){
											echo $balance_amount; 
										}else{
											echo "0.00";
										}?>
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
