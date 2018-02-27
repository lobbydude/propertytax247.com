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
                            <i class="icon-credit-card"></i>Payment History
                        </div>						
						<div class="tools hidden-xs" style="width:15%">                              
						<button id="btnExport_payment" class="btn-default">Export to excel</button>      
						</div>
                    </div>
                    <div class="portlet-body">
                        <table class="sample_2 table table-hover">
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
                                    
                                    $get_order = array(
                                        'User_Id' => $client_id,
                                        'Txn_Id' => $txn_id
                                    );
                                    $this->db->where($get_order);
                                    $q_order = $this->db->get('tbl_order');
                                    $count_order = $q_order->num_rows();
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $k; ?></td>
                                        <td>
                                            <?php if ($count_order > 0) { ?>
                                                <a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Bill-Report.mrt&param1=' . $txn_id) ?>"><?php echo $invoice_id; ?></a>
                                                <?php
                                            } else {
                                                echo $invoice_id;
                                            }
                                            ?>
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

<!-- Download Option -->

<style>
#Export_Excel_Payment_wrapper{
	display:none;
}
</style>

<table class="sample_2 table table-hover" id="Export_Excel_Payment" style="display:none">
    <thead>
        <tr>
            <th style="width:35px">S.No</th>
            <th style="width:100px">Bill No</th>
            <th style="width:100px">Bill Date & Time</th>
            <th style="width:100px">CR/DR</th>
            <th style="width:100px">Billing Amount ($)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $k1 = 1;
        $get_transaction1 = array(
            'User_Id' => $client_id,
            'Status' => 1
        );
        $this->db->order_by('txn_id', 'desc');
        $this->db->where($get_transaction1);
        $q_transaction1 = $this->db->get('tbl_transaction');
        foreach ($q_transaction1->result() as $row_transaction1) {
            $txn_id1 = $row_transaction1->txn_id;
            $invoice_id1 = str_pad(($txn_id1), 4, '0', STR_PAD_LEFT);
            $total_amt11 = $row_transaction1->Paid_Amt;
            $total_amt1 = number_format((float) $total_amt11, 2, '.', '');
            $order_date11 = $row_transaction1->Date;
            $order_date1 = date("d-M-Y H:i:s", strtotime($order_date11));
            $mode1 = $row_transaction1->Mode;

            $get_order1 = array(
                'User_Id' => $client_id,
                'Txn_Id' => $txn_id1
            );
            $this->db->where($get_order1);
            $q_order1 = $this->db->get('tbl_order');
            $count_order1 = $q_order1->num_rows();
            ?>
            <tr class="odd gradeX">
                <td><?php echo $k1; ?></td>
                <td>
                    <?php if ($count_order1 > 0) { ?>
                        <a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Bill-Report.mrt&param1=' . $txn_id1) ?>"><?php echo "'" . $invoice_id1; ?></a>
                        <?php
                    } else {
                        echo "'" . $invoice_id1;
                    }
                    ?>
                </td>
                <td><?php echo $order_date1; ?></td>
                <td>
                    <?php
                    if ($mode1 == "Transfer") {
                        echo "DR";
                    }if ($mode1 == "Refund") {
                        echo "CR";
                    }
                    ?>
                </td>
                <td><?php echo $total_amt1; ?></td>
            </tr>
            <?php
            $k1++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#btnExport_payment").click(function () {
            $("#Export_Excel_Payment").btechco_excelexport({
                containerid: "Export_Excel_Payment",
                datatype: $datatype.Table,
                title:"Payment History"
            });
        });
    });
</script>