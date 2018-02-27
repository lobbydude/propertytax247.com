<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-screen-tablet"></i>Account History
                        </div>						<div class="tools hidden-xs" style="width:15%">                              <button id="btnExport" class="btn-default">Export to excel</button>                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="Export_Excel">
                            <thead>
                                <tr>
                                    <th style="width:100px;">Client Name</th>
                                    <th style="width:100px;">Plan Amount ($)</th>
                                    <th style="width:100px;">Current Balance ($)</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $this->db->where('Status', 1);
                                $q_user = $this->db->get('tbl_user');
                                foreach ($q_user->result() as $row_user) {
                                    $Username = $row_user->Username;
                                    $client_id = $row_user->User_Id;
                                    $get_transaction = array(
                                        'User_Id' => $client_id,
                                        'Status' => 1
                                    );
                                    $this->db->select_sum('Paid_Amt');
                                    $this->db->where($get_transaction);
                                    $q_transaction = $this->db->get('tbl_transaction');
                                    $result_transaction = $q_transaction->result();
                                    $plan_amount1 = $result_transaction[0]->Paid_Amt;
                                    $plan_amount = number_format((float) $plan_amount1, 2, '.', '');
                                    $this->db->select_sum('Total_Amount');
                                    $this->db->where($get_transaction);
                                    $q_acc = $this->db->get('tbl_account');
                                    $result_acc = $q_acc->result();
                                    $total_amount = $result_acc[0]->Total_Amount;
                                    $balance1 = $plan_amount - $total_amount;
                                    $balance = number_format((float) $balance1, 2, '.', '');
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <a target="_blank" href="<?php echo site_url('Admin/acchistory/' . $client_id) ?>"><?php echo $Username; ?></a>
                                        </td>
                                        <td><?php echo $plan_amount; ?></td>
                                        <td><?php echo $balance; ?></td>
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