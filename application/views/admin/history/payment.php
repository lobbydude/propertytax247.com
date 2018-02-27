<?php
$this->db->order_by('Plan_Id', 'asc');
$get_plan = array(
    'Status' => 1
);
$this->db->where($get_plan);
$q_plan = $this->db->get('tbl_plan');
$count_plan = $q_plan->num_rows();
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable tabbable-custom tabbable-noborder">
                    <ul class="nav nav-tabs" id="tabs">
                        <?php
                        $i = 1;
                        foreach ($q_plan->result() as $row_plan) {
                            $plan_name = $row_plan->Plan_Name;
                            $plan_type = $row_plan->Type;
                            ?>
                            <li <?php
                            if ($i == 1) {
                                echo 'class=active';
                            }
                            ?>>
                                <a href="#tab_plan<?php echo $i; ?>" data-toggle="tab">
                                    <?php echo $plan_name . "<br>"; ?> 									
									<?php
                                    if ($plan_type == "Single") {
                                        echo "(S)";
                                    } else {
                                        echo "(B)";
                                    }
                                    ?>									
                                </a>
                            </li>
                            <?php
                            $i++;
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        $j = 1;
                        foreach ($q_plan->result() as $row_plan) {
                            $plan_id_tab = $row_plan->Plan_Id;
                            $plan_name_tab = $row_plan->Plan_Name;
                            ?>
                            <div class="tab-pane fontawesome-demo <?php
                            if ($j == 1) {
                                echo 'active';
                            }
                            ?>" id="tab_plan<?php echo $j; ?>">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="portlet box blue">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-wallet"></i><?php echo $plan_name_tab ?>
                                                </div>
                                                <div class="tools hidden-xs" style="width:15%">
                                                    <button id="btnExport<?php echo $j; ?>" class="btn-default">Export to excel</button>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <table class="sample_2 table table-hover" id="Export_Excel<?php echo $j; ?>">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:35px;">S.No</th>
                                                            <th style="width:100px;">Client Name</th> 
                                                            <th style="width:100px;">Bill Number</th>
                                                            <th style="width:100px;">Bill Date & Time</th>
                                                            <th style="width:100px;">DR/CR</th>
                                                            <th style="width:100px;">Billing Amount ($)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $k = 1;
                                                        $get_cart = array(
                                                            'Plan_Id' => $plan_id_tab,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($get_cart);
                                                        $q_cart = $this->db->get('tbl_cart');
                                                        foreach ($q_cart->result() as $row_cart) {
                                                            $txn_id = $row_cart->Txn_Id;
                                                            $get_transaction = array(
                                                                'txn_id' => $txn_id,
                                                                'Status' => 1
                                                            );
                                                            $this->db->where($get_transaction);
                                                            $q_transaction = $this->db->get('tbl_transaction');
                                                            foreach ($q_transaction->result() as $row_transaction) {
                                                                $txn_id = $row_transaction->txn_id;
                                                                $invoice_id = str_pad(($txn_id), 4, '0', STR_PAD_LEFT);
                                                                $user_id = $row_transaction->User_Id;
                                                                $total_amt = $row_transaction->Paid_Amt;
                                                                $order_date1 = $row_transaction->Date;
                                                                $order_date = date("d-M-Y H:i:s", strtotime($order_date1));
                                                                $mode = $row_transaction->Mode;
                                                                $this->db->where('User_Id', $user_id);
                                                                $q_user = $this->db->get('tbl_user');
                                                                foreach ($q_user->result() as $row_user) {
                                                                    $client_username = $row_user->Username;
                                                                }
                                                                $get_order = array(
                                                                    'User_Id' => $user_id,
                                                                    'Txn_Id' => $txn_id
                                                                );
                                                                $this->db->where($get_order);
                                                                $q_order = $this->db->get('tbl_order');
                                                                $count_order = $q_order->num_rows();
                                                                ?>
                                                                <tr class="odd gradeX">
                                                                    <td><?php echo $k; ?></td>
                                                                    <td><?php echo $client_username; ?></td>
                                                                    <td>
                                                                        <?php if ($count_order > 0) { ?><a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Bill-Report.mrt&param1=' . $txn_id) ?>"><?php echo "" . $invoice_id; ?></a>
                                                                            <?php
                                                                        } else {
                                                                            echo "" . $invoice_id;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $order_date; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($mode == "Transfer") {
                                                                            echo "CR";
                                                                        }if ($mode == "Refund") {
                                                                            echo "DR";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $total_amt; ?></td>
                                                                </tr>
                                                                <?php
                                                                $k++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>            
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            $("#btnExport<?php echo $j; ?>").click(function () {
                                                $("#Export_Excel<?php echo $j; ?>").btechco_excelexport({
                                                    containerid: "Export_Excel<?php echo $j; ?>",
                                                    datatype: $datatype.Table,
                                                    title:"Payment History"
                                                });
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    
                            <?php
                            $j++;
                        }
                        ?>            
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
