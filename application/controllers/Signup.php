<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function index() {
        $this->load->view('client/create/index');
    }

    public function placeorder() {
        $data = array(
            'title' => 'Signup',
            'main_content' => 'client/create/placeorder'
        );
        $this->load->view('client/create/content', $data);
    }

    public function fetch_county() {
        $statewise = ($_REQUEST["statewise_id"] <> "") ? trim($_REQUEST["statewise_id"]) : "";
        $statelist = explode('|', $statewise);
        $statewise_id = $statelist[0];
        if ($statewise_id <> "") {
            $this->db->where('Statewise_Id', $statewise_id);
            $sql_countywise = $this->db->get('tbl_countywise');
            foreach ($sql_countywise->result() as $row_countywise) {
                $county_id = $row_countywise->County_Id;
                $this->db->where('County_ID', $county_id);
                $sql_county = $this->db->get('tbl_county');
                foreach ($sql_county->result() as $row_county) {
                    $county = $row_county->County;
                    ?>
                    <option value="<?php echo $county_id . "|" . $county; ?>"><?php echo $county; ?></option>
                    <?php
                }
            }
        }
    }

    public function cart() {
        $this->form_validation->set_rules('Card_Holder_Name', '', 'trim|required');
        $this->form_validation->set_rules('Card_Number', '', 'trim|required');
        $this->form_validation->set_rules('Expired_Month', '', 'trim|required');
        $this->form_validation->set_rules('Expired_Year', '', 'trim|required');
        $this->form_validation->set_rules('Zip_Code', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            session_start();
            if (isset($_SESSION["cart_item"])) {
                if (count($_SESSION['cart_item']) > 0) {
                    $this->load->view('phpmailer/class_phpmailer');
                    $this->load->view('client/M_pdf');
                    $fullname = $this->input->post('fullname');
                    $businessname = $this->input->post('businessname');
                    $username = $this->input->post('username');
                    $password1 = $this->input->post('password');
                    $password = base64_encode($password1);
                    $email = $this->input->post('email');
                    $phone = $this->input->post('phone');
                    $tc = $this->input->post('tc');
                    $joined_date = date('Y-m-d');
                    $Card_Holder_Name = $this->input->post('Card_Holder_Name');
                    $Card_Number = $this->input->post('Card_Number');
                    $Cvv = $this->input->post('securitycode');
                    $card_type_digit = substr($Card_Number, 0, 1);
                    if ($card_type_digit == 3) {
                        $card_type = "American";
                    }if ($card_type_digit == 4) {
                        $card_type = "Visa";
                    }if ($card_type_digit == 5) {
                        $card_type = "Master";
                    }if ($card_type_digit == 6) {
                        $card_type = "Discover";
                    }
                    $Expired_Year = $this->input->post('Expired_Year');
                    $Expired_Month = $this->input->post('Expired_Month');
                    $Zip_Code = $this->input->post('Zip_Code');

                    $data_user = array(
                        'Username' => $username,
                        'Status' => 1
                    );
                    $this->db->where($data_user);
                    $q_user = $this->db->get('tbl_user');
                    $count_user = $q_user->num_rows();

                    if ($count_user < 1) {
                        $insert_user_data = array(
                            'First_Name' => $fullname,
                            'Business_Name' => $businessname,
                            'Username' => $username,
                            'Password' => $password,
                            'Email_Address' => $email,
                            'Phone_Number' => $phone,
                            'TC' => $tc,
                            'Joined_Date' => $joined_date,
                            'Status' => 1
                        );
                        $q_user_insert = $this->db->insert('tbl_user', $insert_user_data);
                        $user_id = $this->db->insert_id();

                        $link = "http://localhost:82/propertytax247/Client_Login";
                        $msg = "Hello $username, <br><br> <p style='text-indent:25px'>Your account has been created successfully, Please find the below your login credentials:</p><br><br> Login URL : <br> $link <br>  Username : $username <br> Password : $password1<br><br>";
                        $msg .="You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.";
                        $msg .="<br><br><br><br><br>";
                        $msg .="Thank you,<br>";
                        $msg .="Best Regards,<br>";
                        $msg .="Propertyreport247.com,<br>";
                        $msg .="2423 S Alder ST,<br>";
                        $msg .="Philadelphia, PA 19148<br>";
                        $msg .="<img src='https://www.propertyreport247.com/images/logo-light1.png'><br>";
                        $msg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";

                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->CharSet = 'UTF-8';
                        $mail->Host = "smtpout.secureserver.net";
                        $mail->SMTPAuth = true;
                        $mail->Port = 465;
//                        $mail->Username = "info@propertyreport247.com";
//                        $mail->Password = 'info247';
                        $mail->Username = "neworders@propertyreport247.com";
                        $mail->Password = 'Abs@789';
                        $mail->SMTPSecure = 'ssl';
                        $mail->From = "neworders@propertyreport247.com";
                        $mail->FromName = "Propertyreport247.com";
                        $mail->isHTML(true);
                        $mail->Subject = "PropertyReport247.com || New Account Creation";
                        $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
                        $mail->addAddress($email);
                        $mail->addBCC('neworders@propertyreport247.com');
                        $mail->SMTPDebug = 1;
                        $mail->send();
                        if ($q_user_insert) {
                            // $total_amount = $_POST['total_amount'];
                            $total_amount = 0;
                            if (isset($_SESSION["cart_item"])) {
                                foreach ($_SESSION["cart_item"] as $item) {
                                    $plan_id_sess_tot = $item['plan_name'];
                                    $order_type_sess_tot = $item['order_type'];
                                    $no_of_order_sess_tot = $item['no_of_order'];
                                    $q_plan_sess_tot = "select * from tbl_plan where Plan_Id=$plan_id_sess_tot";
                                    $result_plan_sess_tot = mysql_query($q_plan_sess_tot);
                                    while ($row_plan_sess_tot = mysql_fetch_array($result_plan_sess_tot)) {
                                        $plan_price_sess1_tot = $row_plan_sess_tot['Price'];
                                        if ($order_type_sess_tot == "Bulk") {
                                            $no_of_order_array_tot = explode('|', $no_of_order_sess_tot);
                                            $no_of_order_id_tot = count($no_of_order_array_tot);
                                            $no_of_order_tot = 0;
                                            for ($l_tot = 0; $l_tot < ($no_of_order_id_tot - 1); $l_tot++) {
                                                $no_of_order_tot = $no_of_order_tot + $no_of_order_array_tot[$l_tot];
                                            }
                                            $nooforder_tot = $no_of_order_tot / 10;
                                            $plan_price1_tot = $plan_price_sess1_tot * $nooforder_tot;
                                            $plan_price_tot = number_format((float) $plan_price1_tot, 2, '.', '');
                                        } else {
                                            $plan_price_tot = number_format((float) $plan_price_sess1_tot, 2, '.', '');
                                        }

                                        $total_amount = $plan_price_tot + $total_amount;
                                    }
                                }
                            }
                            $plan_total_tot = number_format((float) $total_amount, 2, '.', '');

                            $this->load->library('authorize_net');
                            $auth_net = array(
                                'x_card_num' => $Card_Number,
                                'x_exp_date' => $Expired_Month . '/' . $Expired_Year,
                                'x_card_code' => $Cvv,
                                'x_amount' => $plan_total_tot,
                                'x_first_name' => $Card_Holder_Name,
                                'x_zip' => $Zip_Code,
                                'x_phone' => $phone,
                                'x_email' => $email,
                                'x_customer_ip' => $this->input->ip_address()
                            );
                            $this->authorize_net->setData($auth_net);
                            if ($this->authorize_net->authorizeAndCapture()) {
                                $transaction_id = $this->authorize_net->getTransactionId();
                                $txn_date = date('Y-m-d H:i:s');
                                $select_txn_insert = "INSERT INTO tbl_transaction (Transaction_Id,User_Id, Total_Amt, Paid_Amt, Mode, Date, Status) VALUES ('$transaction_id','$user_id', '$plan_total_tot', '$plan_total_tot', 'Transfer', '$txn_date'," . 1 . ")";
                                $q_txn_insert = mysql_query($select_txn_insert);
                                $txn_id = mysql_insert_id();
                                if (isset($_POST['save_card'])) {
                                    $Inserted_Date = date('Y-m-d H:i:s');
                                    $insert_card_data = array(
                                        'User_Id' => $user_id,
                                        'Card_Holder_Name' => $Card_Holder_Name,
                                        'Card_Number' => $Card_Number,
                                        'Expired_Month' => $Expired_Month,
                                        'Expired_Year' => $Expired_Year,
                                        'Zip_Code' => $Zip_Code,
                                        'Card_Type' => $card_type,
                                        'Inserted_By' => $user_id,
                                        'Inserted_Date' => $Inserted_Date,
                                        'Status' => 1
                                    );
                                    $this->db->insert('tbl_cards', $insert_card_data);
                                }
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
                                $invoicemsg = "Hello $username, <br><br> <p style='text-indent:25px'>Thank you for Placing the Orders. Your payment has made successfully, please find the attached invoice.<br><br>";
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
                                //$mail->Host = "localhost";
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
                                $mail1->addBCC('neworders@propertyreport247.com');
                                $mail1->AddStringAttachment($attachment, 'invoice.pdf');
                                $mail1->SMTPDebug = 1;
                                $mail1->send();
                                unset($_SESSION['cart_item']);
                                echo "success";
                            } else {
                                echo '<p>' . $this->authorize_net->getError() . '</p>';
                                $this->authorize_net->debug();
                            }
                        } else {
                            echo "fail";
                        }
                    } else {
                        echo "exists";
                    }
                } else {
                    echo "nocart";
                }
            } else {
                echo "nocart";
            }
        } else {
            //   $this->load->view('error');
        }
    }

    public function paypalcart() {
        session_start();
        if (isset($_SESSION["cart_item"])) {
            if (count($_SESSION['cart_item']) > 0) {
                $this->load->view('phpmailer/class_phpmailer');
                $fullname = $this->input->post('fullname');
                $businessname = $this->input->post('businessname');
                $username = $this->input->post('username');
                $password1 = $this->input->post('password');
                $password = base64_encode($password1);
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $tc = $this->input->post('tc');
                $joined_date = date('Y-m-d');
                $data_user = array(
                    'Username' => $username,
                    'Status' => 1);
                $this->db->where($data_user);
                $q_user = $this->db->get('tbl_user');
                $count_user = $q_user->num_rows();
                if ($count_user < 1) {
                    $insert_user_data = array(
                        'First_Name' => $fullname,
                        'Business_Name' => $businessname,
                        'Username' => $username,
                        'Password' => $password,
                        'Email_Address' => $email,
                        'Phone_Number' => $phone,
                        'TC' => $tc,
                        'Joined_Date' => $joined_date,
                        'Status' => 1);
                    $q_user_insert = $this->db->insert('tbl_user', $insert_user_data);
                    $user_id = $this->db->insert_id();
                    $link = "http://localhost:82/propertytax247/Client_Login";
                    $msg = "Hello $username, <br><br> <p style='text-indent:25px'>Your account has been created successfully, Please find the below your login credentials:</p><br><br> Login URL : <br> $link <br>  Username : $username <br> Password : $password1<br><br>";
					$msg .="You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br><br>";
                    $msg .="<br><br><br><br><br>";
                    $msg .="Thank you,<br>";
                    $msg .="Best Regards,<br>";
                    $msg .="Propertyreport247.com,<br>";
                    $msg .="2423 S Alder ST,<br>";
                    $msg .="Philadelphia, PA 19148<br>";
                    $msg .="<img src='https://www.propertyreport247.com/images/logo-light1.png'><br>";
                    $msg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->CharSet = 'UTF-8';
                    $mail->Host = "smtpout.secureserver.net";
                    $mail->SMTPAuth = true;
                    $mail->Port = 465;
                    $mail->Username = "neworders@propertyreport247.com";
                    $mail->Password = 'Abs@789';
                    $mail->SMTPSecure = 'ssl';
                    $mail->From = "neworders@propertyreport247.com";
                    $mail->FromName = "Propertyreport247.com";
                    $mail->isHTML(true);
                    $mail->Subject = "PropertyReport247.com || New Account Creation";
                    $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
                    $mail->addAddress($email);
                    $mail->addBCC('neworders@propertyreport247.com');
                    $mail->SMTPDebug = 1;
                    $mail->send();
                    if ($q_user_insert) {
                        $form = "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' name='paypal_form' id='paypal_form'>"
                                . "<input type='hidden' name='cmd' value='_cart'>"
                                . "<input type='hidden' name='upload' value='1'>"
                                . "<input type='hidden' name='business' value='sgratman@gmail.com'>"
                                . "<input type='hidden' name='currency_code' value='US'>";
                        $total_amount = 0;
                        $k = 1;
                        if (isset($_SESSION["cart_item"])) {
                            foreach ($_SESSION["cart_item"] as $item) {
                                $plan_id_sess = $item['plan_name'];
                                $order_type_sess = $item['order_type'];
                                $no_of_order_sess = $item['no_of_order'];
                                $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_sess";
                                $result_plan_sess = mysql_query($q_plan_sess);
                                while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                                    $plan_name_sess = $row_plan_sess['Plan_Name'];
                                    $plan_price_sess1 = $row_plan_sess['Price'];
                                    $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                                    if ($order_type_sess == "Bulk") {
                                        $no_of_order_array = explode('|', $no_of_order_sess);
                                        $no_of_order_id = count($no_of_order_array);
                                        $no_of_order = 0;
                                        for ($l = 0; $l < ($no_of_order_id - 1); $l++) {
                                            $no_of_order = $no_of_order + $no_of_order_array[$l];
                                        }
                                        $nooforder = $no_of_order / 10;
                                        $plan_price1 = $plan_price_sess1 * $nooforder;
                                        $plan_price = number_format((float) $plan_price1, 2, '.', '');
                                    } else {
                                        $no_of_order = 1;
                                        $plan_price = number_format((float) $plan_price_sess1, 2, '.', '');
                                    }
                                    $form .= "<input type='hidden' name='item_name_$k' value='$plan_name_sess - $order_type_sess ($no_of_order orders)'>";
                                    $form .= "<input type='hidden' name='amount_$k' value='$plan_price'>";
                                    $form .= "<input type='hidden' name='custom' value='$user_id'/>";
                                    $form .= "<input type='hidden' name='return' value='http://localhost:82/propertytax247/Signup/success'/>";
                                    $total_amount = $plan_price + $total_amount;
                                }
                                $k++;
                            }
                        }
                        $form .= "</form>";
                        echo $form;
                    } else {
                        echo "fail";
                    }
                } else {
                    echo "exists";
                }
            } else {
                echo "nocart";
            }
        } else {
            echo "nocart";
        }
    }

    public function success() {
        $data = array(
            'title' => 'Payment',
            'main_content' => 'client/create/success'
        );
        $this->load->view('client/create/content', $data);
    }

    public function change_plan() {
        $type = $this->input->post('type');
        $this->db->where('Type', $type);
        $q_plan = $this->db->get('tbl_plan');
        echo "<option value=''> -- Select Plan -- </option>";
        foreach ($q_plan->result() as $row_plan) {
            $plan_id = $row_plan->Plan_Id;
            $plan_name = $row_plan->Plan_Name;
            $price = $row_plan->Price;
            ?>
            <option value="<?php echo $plan_id; ?>"><?php echo $plan_name . " at $$price"; ?></option>
            <?php
        }
    }

    public function change_order() {
        $plan_id = $this->input->post('plan_id');
        $this->db->where('Plan_Id', $plan_id);
        $q_plan = $this->db->get('tbl_plan');
        echo "<option value=''> -- Select Order -- </option>";
        foreach ($q_plan->result() as $row_plan) {
            $no_of_order = $row_plan->No_Of_Order;
            $type = $row_plan->Type;
            $price = $row_plan->Price;
        }
        if ($type == "Single") {
            for ($k = 1; $k < 10; $k++) {
                ?>
                <option value="<?php echo $k . "|" . $no_of_order . "|" . $price; ?>"><?php echo $k; ?></option>
                <?php
            }
        } else {
            for ($j = 1; $j <= 50; $j++) {
                ?>
                <option value="<?php echo $j . "|" . $no_of_order . "|" . $price; ?>"><?php echo $j; ?></option>
                <?php
            }
        }
    }

}
