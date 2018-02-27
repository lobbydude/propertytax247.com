<?php
session_start();
$item_no = $_GET['item_number'];
$transaction_id = $_GET['tx'];
$total_amount = $_GET['amt'];
$item_currency = $_GET['cc'];
$payment_status = $_GET['st'];
$user_id = $_GET['cm'];
?>

<div class="page-container" style="margin-top:0px">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-folder-alt"></i>Transaction Status
                    </div>
                </div>
                <div class="portlet-body form">
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                        if (count($_SESSION["cart_item"]) > 0) {
                            if ($payment_status == "Completed") {
                                $txn_date = date('Y-m-d H:i:s');
                                $select_txn_insert = "INSERT INTO tbl_transaction (Transaction_Id,User_Id, Total_Amt, Paid_Amt, Mode, Date, Status) VALUES ('$transaction_id','$user_id', '$total_amount', '$total_amount', 'Transfer', '$txn_date'," . 1 . ")";
                                $q_txn_insert = mysql_query($select_txn_insert);
                                $txn_id = mysql_insert_id();
                                foreach ($_SESSION["cart_item"] as $item) {
                                    $plan_id_sess = $item['plan_name'];
                                    $order_type_sess = $item['order_type'];
                                    $state_id_sess = $item['state'];
                                    $county_id_sess = $item['county'];
                                    $code_sess = $item['code'];
                                    $no_of_order_sess = $item['no_of_order'];
                                    $price = $item['price'];

                                    $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_sess";
                                    $result_plan_sess = mysql_query($q_plan_sess);
                                    $cart_date = date('Y-m-d H:i:s');
                                    while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                                        $plan_name_sess = $row_plan_sess['Plan_Name'];
                                        $plan_price_sess1 = $row_plan_sess['Price'];
                                        $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                                        if ($order_type_sess == "Single") {
                                            $no_of_order_total = 1;
                                            $q_statewise = "select * from tbl_statewise where Status=1 AND S_Id=$state_id_sess";
                                            $result_statewise = mysql_query($q_statewise);
                                            while ($row_statewise = mysql_fetch_array($result_statewise)) {
                                                $state_id = $row_statewise['State_Id'];
                                                $q_county = "select * from tbl_county where County_ID=$county_id_sess";
                                                $result_county = mysql_query($q_county);
                                                while ($row_county = mysql_fetch_array($result_county)) {
                                                    $county_name = $row_county['County'];
                                                }
                                                $q_state = "select * from tbl_state where State_ID=$state_id";
                                                $result_state = mysql_query($q_state);
                                                while ($row_state = mysql_fetch_array($result_state)) {
                                                    $state_abbreviation = $row_state['Abbreviation'];
                                                    $St_County = $state_abbreviation . " - " . $county_name;
                                                    $Unique_no = uniqid();
                                                    $select_cart_insert = "INSERT INTO tbl_cart (User_Id, Txn_Id, Plan_Id, Plan_Name, Order_Type, St_County, No_Of_Order,Unique_no,Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id_sess', '$plan_name_sess', '$order_type_sess', '$St_County', '$no_of_order_sess','$Unique_no', '$user_id', '$cart_date', " . 1 . ")";
                                                    mysql_query($select_cart_insert);
                                                }
                                            }
                                        } else {
                                            $no_of_order_total = 0;
                                            $county_id_array = explode('|', $county_id_sess);
                                            $no_of_order_array = explode('|', $no_of_order_sess);
                                            $count_county_id = count($county_id_array);
                                            $Unique_no = uniqid();
                                            for ($l = 0; $l < ($count_county_id - 1); $l++) {
                                                $county_id_no = $county_id_array[$l];
                                                $no_of_order = $no_of_order_array[$l];
                                                $select_cart_insert = "INSERT INTO tbl_cart (User_Id, Txn_Id, Plan_Id, Plan_Name, Order_Type, St_County, No_Of_Order, Unique_no,Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id_sess', '$plan_name_sess', '$order_type_sess','$county_id_no', '$no_of_order','$Unique_no', '$user_id', '$cart_date', " . 1 . ")";
                                                mysql_query($select_cart_insert);
                                                $no_of_order_total = $no_of_order_total + $no_of_order;
                                            }
                                        }
                                        $select_cart_insert = "INSERT INTO tbl_cartamount (User_Id, Txn_Id, Plan_Id, Plan_Name, No_Of_Order,Plan_Amount,Total_Amount, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id_sess', '$plan_name_sess', '$no_of_order_total','$plan_price_sess','$price', '$user_id', '$cart_date', " . 1 . ")";
                                        mysql_query($select_cart_insert);
                                    }
                                }
                                unset($_SESSION['cart_item']);
                                $msg = "This transaction was completed successfully.<br>Transaction Id : $transaction_id <br>";
                                $msg .="Click here login the site : <a href='http://localhost:82/propertytax247/Client_Login'>PropertyReport247.com</a>";
                                echo $msg;
                            } else {
                                echo "This transaction is not completed. Please try again.";
                            }
                        }
                    } else {
                        echo "Your Cart is Empty.";
                    }
                    ?>   
                </div>
            </div>
        </div>
    </div>
    <!-- END FORM-->
    <div id="paypal_div"></div>
