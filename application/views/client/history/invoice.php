<?php
$client_id = $this->session->userdata('client_id');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-credit-card"></i>Invoice History
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Bill No</th>
                                    <th>Bill Date & Time</th>
                                    <th>CR/DR</th>
                                    <th>Billing Amount ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $k = 1;
                                $get_transaction = array(
                                    'User_Id' => $client_id,
                                    'Status' => 1
                                );
                                $this->db->order_by('txn_id', 'desc');
                                $this->db->where($get_transaction);
                                $q_transaction = $this->db->get('tbl_transaction');
                                foreach ($q_transaction->result() as $row_transaction) {
                                    $txn_id = $row_transaction->txn_id;
                                    $invoice_id = str_pad(($txn_id), 4, '0', STR_PAD_LEFT);
                                    $total_amt1 = $row_transaction->Paid_Amt;
                                    $total_amt = number_format((float) $total_amt1, 2, '.', '');
                                    $order_date1 = $row_transaction->Date;
                                    $order_date = date("d-M-Y H:i:s", strtotime($order_date1));
                                    $mode = $row_transaction->Mode;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $k; ?></td>
                                        <td>
                                            <a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Bill-Report.mrt&param1=' . $txn_id) ?>">
                                                <?php echo $invoice_id; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $order_date; ?></td>
                                        <td>
                                            <?php
                                            if ($mode == "Transfer") {
                                                echo "DR";
                                            }if ($mode == "Refund") {
                                                echo "CR";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $total_amt; ?></td>
                                    </tr>
                                    <?php
                                    $k++;
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
