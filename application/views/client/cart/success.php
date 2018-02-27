<?php
$this->load->view('phpmailer/class_phpmailer');
$this->load->view('client/M_pdf');
session_start();
$item_no = $_GET['item_number'];
$transaction_id = $_GET['tx'];
$total_amount = $_GET['amt'];
$item_currency = $_GET['cc'];
$payment_status = $_GET['st'];
$user_id = $this->session->userdata('client_id');
$username = $this->session->userdata('client_username');
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
                        if (isset($_SESSION["cart_item"])) {
                            if (count($_SESSION["cart_item"]) > 0) {
                                if ($payment_status == "Completed") {
                                    $txn_date = date('Y-m-d H:i:s');
                                    $select_txn_insert = "INSERT INTO tbl_transaction (Transaction_Id,User_Id, Total_Amt, Paid_Amt, Mode, Date, Status) VALUES ('$transaction_id','$user_id', '$total_amount', '$total_amount', 'Transfer', '$txn_date'," . 1 . ")";
                                    $q_txn_insert = mysql_query($select_txn_insert);
                                    $txn_id = mysql_insert_id();
                                    /* Attachment Code Start Here */
                                    $invoice_id = str_pad(($txn_id), 4, '0', STR_PAD_LEFT);
                                    $image_url = site_url('assets/admin/layout4/img/ordersheet.png');
                                    $msg_doc = "<div style='border:1px solid #002040;'>";
                                    $msg_doc .= "<div style='width:40%;float:left;margin-left:30px;margin-top:20px'>";
                                    $msg_doc .="<img src='$image_url'>";
                                    $msg_doc .="</div>";
                                    $msg_doc .="<div style='width:30%;float:left'>";
                                    $msg_doc .="<center><h4>PROPERTYREPORT247.COM<br>";
                                    $msg_doc .="2423 S ALDER ST PHILADELPHIA, PA 19148<br>";
                                    $msg_doc .="Toll Free : 1-844-508-4853</h4>";
                                    $msg_doc .="</center>";
                                    $msg_doc .="</div>";
                                    $msg_doc .="<div style='width:21%;float:left;margin-top:50px;margin-left:10px'>";
                                    $msg_doc .="<h4 style='background-color:#002040;color:#fff;text-align:center;padding:5px'>Invoice No : $invoice_id</h4>";
                                    $msg_doc .="</div><br><br>";
                                    $msg_doc .="<div style='width:100%;margin:30px'>";
                                    $msg_doc .= "<table cellpading='23' style='border-collapse:collapse;height:50%;border:1px solid #002040;'><tr>";
                                    $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px'>Bill No</th>";
                                    $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px'>Plan Name</th>";
                                    $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px'>Plan Type</th>";
                                    $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px'>County Name</th>";
                                    $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px'>Plan Amount ($)</th>";
                                    $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px'>Bill Amount</th>";
                                    $msg_doc .="</tr>";

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
                                        $msg_doc .="<tr>";
                                        while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                                            $plan_name_sess = $row_plan_sess['Plan_Name'];
                                            $plan_price_sess1 = $row_plan_sess['Price'];
                                            $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                                            $msg_doc .="<td style='border:1px solid #002040;'>$invoice_id</td>";
                                            $msg_doc .="<td style='border:1px solid #002040;'>$plan_name_sess</td>";
                                            $msg_doc .="<td style='border:1px solid #002040;'>$order_type_sess</td>";

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
                                                $msg_doc .="<td style='border:1px solid #002040;'>$county_name</td>";
                                            } else {
                                                $msg_doc .="<td style='border:1px solid #002040;'>";
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
                                                    $msg_doc .="$county_id_no<br />";
                                                }
                                                $msg_doc .="</td>";
                                            }
                                            $select_cart_insert = "INSERT INTO tbl_cartamount (User_Id, Txn_Id, Plan_Id, Plan_Name, No_Of_Order,Plan_Amount,Total_Amount, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id_sess', '$plan_name_sess', '$no_of_order_total','$plan_price_sess','$price', '$user_id', '$cart_date', " . 1 . ")";
                                            mysql_query($select_cart_insert);
                                            $msg_doc .="<td style='border:1px solid #002040;'>$plan_price_sess</td>";
                                            $msg_doc .="<td style='border:1px solid #002040;'>$price</td>";
                                        }
                                        $msg_doc .="</tr>";
                                    }
                                    $msg_doc .="<tr>";
                                    $msg_doc .="<td colspan='4' style='border:1px solid #002040;'></td>";
                                    $msg_doc .="<td style='border:1px solid #002040;'>Total</td>";
                                    $msg_doc .="<td style='border:1px solid #002040;'>$ " . $total_amount . "</td>";
                                    $msg_doc .="</tr>";
                                    $msg_doc .="</table></div><br><br>";
                                    $msg_doc .="<br><br><br><br>";
                                    $msg_doc .="<p style='text-align:center;'><b>THANK YOU FOR THE OPPORTUNITY TO SERVE YOU</b><br>";
                                    $msg_doc .="For Queries Please Contact:<br>";
                                    $msg_doc .="Propertyreport247.com, Toll Free : 1-844-508-4853, Email : info@propertyreport247.com</p></div>";
                                    $msg_doc .="</div>";
                                    $invoicemsg = "Hello $username, <br><br> <p style='text-indent:25px'>Thank you for Placing the Orders. Your payment has made successfully, please find the attached invoice.<br>";
                                    $invoicemsg .="You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br>";
                                    $invoicemsg .="If you have any Query ,kindly revert back.";
                                    $invoicemsg .="<br><br><br><br><br><br>";
                                    $invoicemsg .="Thank you,<br>";
                                    $invoicemsg .="Best Regards,<br>";
                                    $invoicemsg .="Propertyreport247.com,<br>";
                                    $invoicemsg .="2423 S Alder ST,<br>";
                                    $invoicemsg .="Philadelphia, PA 19148<br>";
                                    $invoicemsg .="<img src='https://www.propertyreport247.com/images/logo-light1.png'><br>";
                                    $invoicemsg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";

                                    $mpdf = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
                                    $mpdf->SetDisplayMode('fullpage');
                                    $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
                                    $mpdf->WriteHTML($msg_doc);
                                    $attachment = $mpdf->Output('invoice.pdf', 'S');
                                    /* Attachment Code End Here */
                                    $mail1 = new PHPMailer();
                                    $mail1->IsSMTP();
                                    $mail1->CharSet = 'UTF-8';
                                    $mail1->Host = "smtpout.secureserver.net";
                                    $mail1->SMTPAuth = true;
                                    $mail1->Port = 465;
                                    $mail1->Username = "neworders@propertyreport247.com";
                                    $mail1->Password = 'Abs@789';
                                    $mail1->SMTPSecure = 'ssl';
                                    $mail1->From = "neworders@propertyreport247.com";
                                    $mail1->FromName = "Propertyreport247.com";
                                    $mail1->isHTML(true);
                                    $mail1->Subject = "PropertyReport247.com || Invoice";
                                    $mail1->Body = "<font style='font-family: Helvetica;font-size:14px'>$invoicemsg</font>";
                                    $mail1->addAddress($email);
                                    $mail1->addCC('neworders@propertyreport247.com');
                                    $mail1->AddStringAttachment($attachment, 'invoice.pdf');
                                    $mail1->SMTPDebug = 1;
                                    $mail1->send();
                                    unset($_SESSION['cart_item']);
                                    $msg = "This transaction was completed successfully.<br>Transaction Id : $transaction_id <br>";
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
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END CONTENT -->
