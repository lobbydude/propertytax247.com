<?php
$item_no = $_GET['item_number'];
$transaction_id = $_GET['tx'];
$total_amount = $_GET['amt'];
$item_currency = $_GET['cc'];
$payment_status = $_GET['st'];
$plan_id = $_GET['cm'];
$user_id = $this->session->userdata('client_id');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-screen-tablet"></i>Transaction Status
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if ($payment_status == "Completed") {
                            $q_plan = "select * from tbl_plan where Plan_Id=$plan_id";
                            $result_plan = mysql_query($q_plan);
                            $cart_date = date('Y-m-d H:i:s');
                            while ($row_plan = mysql_fetch_array($result_plan)) {
                                $plan_name = $row_plan['Plan_Name'];
                                $plan_price1 = $row_plan['Price'];
                                $plan_price = number_format((float) $plan_price1, 2, '.', '');
                                $order_type = $row_plan['Type'];
                            }
                            $txn_date = date('Y-m-d H:i:s');
                            $select_txn_insert = "INSERT INTO tbl_transaction (Transaction_Id,User_Id, Total_Amt, Paid_Amt, Mode, Date, Status) VALUES ('$transaction_id','$user_id', '$plan_price', '$total_amount', 'Transfer', '$txn_date'," . 1 . ")";
                            $q_txn_insert = mysql_query($select_txn_insert);
                            $txn_id = mysql_insert_id();
                            $Unique_no = uniqid();
                            $select_cart_insert = "INSERT INTO tbl_cart (User_Id, Txn_Id, Plan_Id, Plan_Name, Order_Type,Unique_no,Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id', '$plan_name', '$order_type','$Unique_no', '$user_id', '$cart_date', " . 1 . ")";
                            mysql_query($select_cart_insert);

                            $select_cartamt_insert = "INSERT INTO tbl_cartamount (User_Id, Txn_Id, Plan_Id, Plan_Name,Plan_Amount,Total_Amount, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id', '$plan_name', '$plan_price','$total_amount', '$user_id', '$cart_date', " . 1 . ")";
                            mysql_query($select_cartamt_insert);

                            $msg = "This transaction was completed successfully.<br>Transaction Id : $transaction_id <br>";
                            echo $msg;
                        } else {
                            echo "This transaction is not completed. Please try again.";
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
