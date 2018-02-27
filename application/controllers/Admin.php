<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Admin_Login');
        }
    }

    public function index() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'admin/index'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function fetch_county() {
        $state_id = ($_REQUEST["state_id"] <> "") ? trim($_REQUEST["state_id"]) : "";
        if ($state_id <> "") {
            $this->db->where('State_ID', $state_id);
            $this->db->order_by('County');
            $sql_county = $this->db->get('tbl_county');

            $count_county = $sql_county->num_rows();
            if ($count_county > 0) {
                foreach ($sql_county->result() as $row_county) {
                    ?>
                    <option value="<?php echo $row_county->County_ID; ?>"><?php echo $row_county->County; ?></option>
                    <?php
                }
            } else {
                ?>
                <option value="0">Select County</option>
                <?php
            }
        }
    }

    public function editorder() {
        $data = array(
            'title' => 'Edit Order',
            'main_content' => 'admin/edit_order'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function edit_orderinfodata() {
        $this->form_validation->set_rules('edit_admin_orderinfo_order_number', '', 'trim|required');
        $this->form_validation->set_rules('edit_admin_orderinfo_statelist', '', 'trim|required');
        $this->form_validation->set_rules('edit_admin_orderinfo_zipcode', '', 'trim|required');
        $this->form_validation->set_rules('edit_admin_orderinfo_borrowername', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $edit_admin_orderinfo_orderid = $this->input->post('edit_admin_orderinfo_orderid');
            $edit_admin_orderinfo_street = $this->input->post('edit_admin_orderinfo_street');
            $edit_admin_orderinfo_order_number = $this->input->post('edit_admin_orderinfo_order_number');
            $edit_admin_orderinfo_statelist = $this->input->post('edit_admin_orderinfo_statelist');
            $edit_admin_orderinfo_city = $this->input->post('edit_admin_orderinfo_city');
            $edit_admin_orderinfo_zipcode = $this->input->post('edit_admin_orderinfo_zipcode');
            $edit_admin_orderinfo_borrowername = $this->input->post('edit_admin_orderinfo_borrowername');
            $edit_admin_orderinfo_apn = $this->input->post('edit_admin_orderinfo_apn');
            $edit_admin_orderinfo_notes = $this->input->post('edit_admin_orderinfo_notes');
            $edit_admin_orderinfo_status = $this->input->post('edit_admin_orderinfo_status');
            $edit_admin_orderinfo_comments = $this->input->post('edit_admin_orderinfo_comments');
            //date_default_timezone_set("Asia/Kolkata");
			date_default_timezone_set('US/Eastern');
            $modified_id = $this->session->userdata('admin_id');
            $update_data = array(
                'Street' => $edit_admin_orderinfo_street,
                'Order_Number' => $edit_admin_orderinfo_order_number,
                'State_County' => $edit_admin_orderinfo_statelist,
                'City' => $edit_admin_orderinfo_city,
                'Zipcode' => $edit_admin_orderinfo_zipcode,
                'Borrower_Name' => $edit_admin_orderinfo_borrowername,
                'APN' => $edit_admin_orderinfo_apn,
                'Notes' => $edit_admin_orderinfo_notes,
                'Order_Status' => $edit_admin_orderinfo_status,
                'Comments' => $edit_admin_orderinfo_comments,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );

            $this->db->where('Order_Id', $edit_admin_orderinfo_orderid);
            $q = $this->db->update('tbl_order', $update_data);
			if ($edit_admin_orderinfo_status == "Completed") {
                $this->db->where('Order_Id', $edit_admin_orderinfo_orderid);
                $q_order_data = $this->db->get('tbl_order');
                foreach ($q_order_data->result() as $row_order_data) {
                    $user_id = $row_order_data->User_Id;
                }
                $this->db->where('User_Id', $user_id);
                $q_user = $this->db->get('tbl_user');
                foreach ($q_user->result() as $row_user) {
                    $client_username = $row_user->Username;
                    $client_email = $row_user->Email_Address;
                }
                $msg = "Hello $client_username, <br><br> <p style='text-indent:25px'>Your order is completed and now you can download from our web portal.</p><br>";
                $msg .="You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br><br><br><br><br><br>";
                $msg .="Thanks & Regards<br>";
                $msg .="Propertyreport247.com,<br>";
                $msg .="2423 S Alder ST,Philadelphia, PA 19148<br>";
                $msg .="<img src=" . base_url('assets/admin/layout4/img/logo-light1.png') . "><br>";
                $msg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                    This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
                                    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
                $this->load->view('phpmailer/class_phpmailer');
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->Host = "localhost";
                //$mail->SMTPAuth = true;
                $mail->Port = 465;
                $mail->Username = "neworders@propertyreport247.com";
                $mail->Password = 'Abs@789';
                $mail->SMTPSecure = 'ssl';
                $mail->From = "neworders@propertyreport247.com";
                $mail->FromName = "Propertyreport247.com";
                $mail->isHTML(true);
                $mail->Subject = "Propertyreport247.com - $edit_admin_orderinfo_order_number - Completed Order";
                $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
                $mail->addAddress($client_email);
				$mail->addBCC("neworders@propertyreport247.com");
                $mail->SMTPDebug = 1;
                $mail->send();
            }
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Delete Order Details Start here */

    public function Deleteorder() {
        $order_id = $this->input->post('order_id');
        $order_no = $this->input->post('order_no');
        $data = array(
            'order_id' => $order_id,
            'order_no' => $order_no
        );
        $this->load->view('admin/delete_order', $data);
    }

    public function delete_order() {
        $delete_order_id = $this->input->post('delete_order_id');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['admin_id'];
        $update_data = array(
            'Status' => 0,
            'Modified_By' => $modified_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Order_Id', $delete_order_id);
        $q = $this->db->update('tbl_order', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Delete Order Details End here */
	
	 /* Admin Upload Document Delete Details Start here */	 
    public function Deletedocument() {
        $doc_id = $this->input->post('doc_id');        
        $data = array(
            'doc_id' => $doc_id
        );
        $this->load->view('admin/delete_document', $data);
    }
    public function delete_document() {            
        $delete_document_id = $this->input->post('delete_document_id');         
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['admin_id'];
        $update_data = array(
            'Status' => 0,
            'Modified_By' => $modified_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Doc_Id', $delete_document_id);
        $q = $this->db->update('tbl_orderdocuments', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }    
   	/* Admin Upload Document Delete Details End here */	

    public function upload_order() {
        $this->form_validation->set_rules('edit_admin_orderupload_description', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            if (is_array($_FILES)) {
                if (is_uploaded_file($_FILES['edit_admin_orderupload_file']['tmp_name'])) {
                    $edit_admin_orderupload_orderid = $this->input->post('edit_admin_orderupload_orderid');
                    $edit_admin_orderupload_doctype = $this->input->post('edit_admin_orderupload_doctype');
                    $edit_admin_orderupload_description = $this->input->post('edit_admin_orderupload_description');
                    $sourcePath = $_FILES['edit_admin_orderupload_file']['tmp_name'];
                    $file_name = rand() . $_FILES['edit_admin_orderupload_file']['name'];
                    $targetPath = "orders/" . $file_name;                    
                    $inserted_id = $this->session->userdata('admin_id');
                    //date_default_timezone_set("Asia/Kolkata");
                    date_default_timezone_set('US/Eastern');
                    $this->db->where('Order_Id', $edit_admin_orderupload_orderid);
                    $q_order = $this->db->get('tbl_order');
                    foreach ($q_order->result() as $row_order) {
                        $order_status = $row_order->Order_Status;
                        $user_id = $row_order->User_Id;
                        $order_number = $row_order->Order_Number;
                    }
                    $this->db->where('User_Id', $user_id);
                    $q_user = $this->db->get('tbl_user');
                    foreach ($q_user->result() as $row_user) {
                        $client_username = $row_user->Username;
                        $client_email = $row_user->Email_Address;
                    }
                    ini_set('upload_max_filesize', '10M');
                    ini_set('post_max_size', '10M');
                    if ($edit_admin_orderupload_doctype == "Title Search Package") {
                    if ($order_status == "Completed") {
                        if (move_uploaded_file($sourcePath, $targetPath)) {
                            $insert_data = array(
                                'Order_Id' => $edit_admin_orderupload_orderid,
                                'Doc_Type' => $edit_admin_orderupload_doctype,
                                'Description' => $edit_admin_orderupload_description,
                                'File' => $file_name,
                                'Uploaded_By' => 'admin',
                                'Inserted_By' => $inserted_id,
                                'Inserted_Date' => date('Y-m-d H:i:s'),
                                'Status' => 1
                            );
                            $q = $this->db->insert('tbl_orderdocuments', $insert_data);
                            if ($q) {
                                $msg = "Hello $client_username, <br><br> <p style='text-indent:25px'>Your order is completed and now you can download from our web portal.</p><br>";
                                $msg .="You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br><br><br><br><br><br>";                                
                                $msg .="Thanks & Regards<br>";
                                $msg .="Propertyreport247.com,<br>";
                                $msg .="2423 S Alder ST,Philadelphia, PA 19148<br>";
                                $msg .="<img src=" . base_url('assets/admin/layout4/img/ordersheet.png') . "><br>";
                                $msg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
                                $this->load->view('phpmailer/class_phpmailer');
                                $mail = new PHPMailer();
                                $mail->IsSMTP();
                                $mail->CharSet = 'UTF-8';
                                $mail->Host = "localhost";
                                //$mail->SMTPAuth = true;
                                $mail->Port = 465;
                                $mail->Username = "neworders@propertyreport247.com";
                                $mail->Password = 'Abs@789';
                                $mail->SMTPSecure = 'ssl';
                                $mail->From = "neworders@propertyreport247.com";
                                $mail->FromName = "Propertyreport247.com";
                                $mail->isHTML(true);
                                $mail->Subject = "Propertyreport247.com - $order_number - Completed Order";
                                $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
                                $mail->addAddress($client_email);
                                $mail->addBCC("neworders@propertyreport247.com");
                                $mail->SMTPDebug = 1;
                                $mail->send();
                                echo "success";
                            } else {
                                echo "fail";
                            }
                        }
                    } else {
                        echo "notyet";
                    }
				}else{
					if (move_uploaded_file($sourcePath, $targetPath)) {
                            $insert_data = array(
                                'Order_Id' => $edit_admin_orderupload_orderid,
                                'Doc_Type' => $edit_admin_orderupload_doctype,
                                'Description' => $edit_admin_orderupload_description,
                                'File' => $file_name,
                                'Uploaded_By' => 'admin',
                                'Inserted_By' => $inserted_id,
                                'Inserted_Date' => date('Y-m-d H:i:s'),
                                'Status' => 1
                            );
							// Completed Orders Mail
                            $q = $this->db->insert('tbl_orderdocuments', $insert_data);
                            if ($q) {
                                $msg = "Hello $client_username, <br><br> <p style='text-indent:25px'>Your order is completed and now you can download from our web portal.<br><br>You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href'https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for the business.</p><br><br><br>";                                
                                $msg .="Thank you for the business.<br><br>";
                                $msg .="Thanks & Regards<br>";
                                $msg .="Propertyreport247.com,<br>";
                                $msg .="2423 S Alder ST,Philadelphia, PA 19148<br>";
                                $msg .="<img src=" . base_url('assets/admin/layout4/img/logo-light1.png') . "><br>";
                                $msg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
                                $this->load->view('phpmailer/class_phpmailer');
                                $mail = new PHPMailer();
                                $mail->IsSMTP();
                                $mail->CharSet = 'UTF-8';
                                $mail->Host = "localhost";
                                //$mail->SMTPAuth = true;
                                $mail->Port = 465;
                                $mail->Username = "neworders@propertyreport247.com";
                                $mail->Password = 'Abs@789';
                                $mail->SMTPSecure = 'ssl';
                                $mail->From = "neworders@propertyreport247.com";
                                $mail->FromName = "Propertyreport247.com";
                                $mail->isHTML(true);
                                $mail->Subject = "Propertyreport247.com - $order_number - Completed Order";
                                $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
                                $mail->addAddress($client_email);
                                $mail->addBCC("neworders@propertyreport247.com");
                                $mail->SMTPDebug = 1;
                                $mail->send();
                                echo "success";
                            } else {
                                echo "fail";
                            }
                        }
				}
                }
            }
        }
    }

    public function searchorder() {
        $order_no = $this->input->post('search_order');
        $data = array(
            'title' => 'Order',
            'main_content' => 'admin/searchorder',
            'order_no' => $order_no
        );
        $this->load->view('admin/common/content', $data);
    }

    public function download_document() {
        $filename = $this->uri->segment(3);
        $data = file_get_contents(site_url('orders/' . $filename)); // Read the file's contents
        force_download($filename, $data);
    }

    public function account() {
        $data = array(
            'title' => 'Account History',
            'main_content' => 'admin/history/account'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function acchistory() {
        $data = array(
            'title' => 'Account History',
            'main_content' => 'admin/history/acchistory'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function payment() {
        $data = array(
            'title' => 'Account History',
            'main_content' => 'admin/history/payment'
        );
        $this->load->view('admin/common/content', $data);
    }

    /* Refund Details Start here */

    public function refund() {
        $data = array(
            'title' => 'Refund',
            'main_content' => 'admin/refund/index'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function ViewRefund() {
        $data = array(
            'title' => 'Refund',
            'main_content' => 'admin/refund/view_refund'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function refund_response() {
        $this->form_validation->set_rules('refund_response_planid', '', 'trim|required');
        $this->form_validation->set_rules('refund_response_remarks', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $refund_id = $this->input->post('refund_response_refundid');
            $plan_id = $this->input->post('refund_response_planid');
            $user_id = $this->input->post('refund_response_userid');
            $unique_id = $this->input->post('refund_response_unique_id');
            $amount = $this->input->post('refund_response_amount');
            $remarks = $this->input->post('refund_response_remarks');
            $tc = $this->input->post('refund_response_tc');
            $txn_id = $this->input->post('refund_response_txnid');

            $inserted_id = $this->session->userdata('admin_id');
            $this->db->where('Plan_Id', $plan_id);
            $q_plan = $this->db->get('tbl_plan');
            foreach ($q_plan->result() as $row_plan) {
                $plan_amount = $row_plan->Price;
            }
            $update_cart_data = array(
                'Cart_Status' => 'Refunded'
            );
            $this->db->where('Unique_no', $unique_id);
            $this->db->update('tbl_cart', $update_cart_data);

            $Card_Holder_Name = $this->input->post('Card_Holder_Name');
            $Card_Number = $this->input->post('Card_Number');
            $Expired_Year = $this->input->post('Expired_Year');
            $Expired_Month = $this->input->post('Expired_Month');
            $Zip_Code = $this->input->post('Zip_Code');
            $card_type_digit = substr($Card_Number, 0, 1);

            if ($card_type_digit == "3") {
                $card_type = "American";
            } else if ($card_type_digit == "4") {
                $card_type = "Visa";
            } else if ($card_type_digit == "5") {
                $card_type = "Master";
            } else if ($card_type_digit == "6") {
                $card_type = "Discover";
            } else {
                $card_type = "Others";
            }
            $Inserted_Date = date('Y-m-d H:i:s');
            if (isset($_POST['save_card'])) {
                $select_card_insert = "INSERT INTO tbl_cards_admin (Admin_Id, Card_Holder_Name, Card_Number, Expired_Year, Expired_Month, Zip_Code,Card_Type, Inserted_By, Inserted_Date, Status) VALUES ('$inserted_id', '$Card_Holder_Name', '$Card_Number', '$Expired_Year', '$Expired_Month', '$Zip_Code','$card_type','$inserted_id', '$Inserted_Date'," . 1 . ")";
                mysql_query($select_card_insert);
            }

            $get_txn = array(
                'txn_id' => $txn_id,
                'User_Id' => $user_id
            );
            $this->db->where($get_txn);
            $q_txn = $this->db->get('tbl_transaction');
            foreach ($q_txn->result() as $row_txn) {
                $transaction_id = $row_txn->Transaction_Id;
            }

            $authnet_values = array
                (
                "x_login" => "3N5s3JyJr",
                "x_version" => "3.1",
                "x_delim_char" => "|",
                "x_delim_data" => "TRUE",
                "x_url" => "FALSE",
                "x_type" => "CREDIT",
                "x_method" => "CC",
                "x_tran_key" => "86577phtVXGL8st6",
                "x_trans_id" => "$transaction_id",
                "x_relay_response" => "FALSE",
                "x_card_num" => "$Card_Number",
                "x_exp_date" => "$Expired_Month$Expired_Year",
                "x_description" => "Refund",
                "x_Amount" => "$amount",
                "x_first_name" => "$Card_Holder_Name",
                "x_zip" => "$Zip_Code"
            );
            $fields = "";
            foreach ($authnet_values as $key => $value)
                $fields .= "$key=" . urlencode($value) . "&";
            $fields = rtrim($fields, "& ");

            $ch = curl_init("https://secure.authorize.net/gateway/transact.dll");
            curl_setopt($ch, CURLOPT_HEADER, 0); // removes HTTP headers from response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data
            curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields, "& ")); // use HTTP POST to send form data
            $authorize_response = curl_exec($ch); //execute post and get results
            curl_close($ch);
            $response_array = explode($authnet_values["x_delim_char"], $authorize_response);
            if ($response_array[1] == 1) {
                $insert_txn_data = array(
                    'User_Id' => $user_id,
                    'Total_Amt' => $plan_amount,
                    'Paid_Amt' => $amount,
                    'Mode' => 'Refund',
                    'Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_transaction', $insert_txn_data);
				$refund_txn_id = mysql_insert_id();
                $update_refund_data = array(
					'Refund_Txn_Id' => $refund_txn_id,
                    'Amount' => $amount,
                    'Remarks' => $remarks,
                    'Confirmation' => $tc,
                    'Refund_Status' => 'Completed',
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('R_Id', $refund_id);
                $q_refund = $this->db->update('tbl_refund', $update_refund_data);
                if ($q_refund) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo '<b>Payment Error </b>: ' . $response_array[3];
            }
        }
    }

	public function refund_paypal_response() {
        $this->load->view('admin/refund/class_refund');
        $this->form_validation->set_rules('refund_response_planid', '', 'trim|required');
        $this->form_validation->set_rules('refund_response_remarks', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $refund_id = $this->input->post('refund_response_refundid');
            $plan_id = $this->input->post('refund_response_planid');
            $user_id = $this->input->post('refund_response_userid');
            $unique_id = $this->input->post('refund_response_unique_id');
            $amount = $this->input->post('refund_response_amount');
            $remarks = $this->input->post('refund_response_remarks');
            $tc = $this->input->post('refund_response_tc');
            $txn_id = $this->input->post('refund_response_txnid');

            $inserted_id = $this->session->userdata('admin_id');
            $this->db->where('Plan_Id', $plan_id);
            $q_plan = $this->db->get('tbl_plan');
            foreach ($q_plan->result() as $row_plan) {
                $plan_amount = $row_plan->Price;
            }
            $update_cart_data = array(
                'Cart_Status' => 'Refunded'
            );
            $this->db->where('Unique_no', $unique_id);
            $this->db->update('tbl_cart', $update_cart_data);
            $get_txn = array(
                'txn_id' => $txn_id,
                'User_Id' => $user_id
            );
            $this->db->where($get_txn);
            $q_txn = $this->db->get('tbl_transaction');
            foreach ($q_txn->result() as $row_txn) {
                $transaction_id = $row_txn->Transaction_Id;
            }

            $aryData['transactionID'] = "$transaction_id";
            $aryData['refundType'] = "Partial"; //Partial or Full
            $aryData['currencyCode'] = "USD";
            $aryData['amount'] = $amount;
            $aryData['memo'] = "";
            $aryData['invoiceID'] = "";

            $ref = new PayPalRefund("live");
            $aryRes = $ref->refundAmount($aryData);
            if ($aryRes['ACK'] == "Success") {
                $insert_txn_data = array(
                    'Transaction_Id' => $aryRes['REFUNDTRANSACTIONID'],
                    'User_Id' => $user_id,
                    'Total_Amt' => $plan_amount,
                    'Paid_Amt' => $amount,
                    'Mode' => 'Refund',
                    'Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_transaction', $insert_txn_data);
                $refund_txn_id = mysql_insert_id();
                $update_refund_data = array(
                    'Refund_Txn_Id' => $refund_txn_id,
                    'Amount' => $amount,
                    'Remarks' => $remarks,
                    'Confirmation' => $tc,
                    'Refund_Status' => 'Completed',
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('R_Id', $refund_id);
                $q_refund = $this->db->update('tbl_refund', $update_refund_data);
                if ($q_refund) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo 'Error Refunding Amount';
            }
        }
    }
	
    /* Refund Details End here */

    /* Cancel History Start Here */

    public function cancel() {
        $data = array(
            'title' => 'Cancel',
            'main_content' => 'admin/history/cancel'
        );
        $this->load->view('admin/common/content', $data);
    }

    /* Cancel History End Here */

    public function onetimeuser() {
        $data = array(
            'title' => 'Onetime User',
            'main_content' => 'admin/onetimeuser'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function profile() {
        $data = array(
            'title' => 'Profile',
            'main_content' => 'admin/profile'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function edit_profile() {
        $this->form_validation->set_rules('username', '', 'trim|required');
        $this->form_validation->set_rules('email', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $admin_id = $this->input->post('admin_id');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $modified_id = $this->session->userdata('admin_id');
            //date_default_timezone_set("Asia/Kolkata");
			date_default_timezone_set('US/Eastern');
            $update_data = array(
                'Admin_Username' => $username,
                'Admin_Email' => $email,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Admin_Id', $admin_id);
            $q = $this->db->update('tbl_admin', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    public function reset() {
        $data = array(
            'title' => 'Profile',
            'main_content' => 'admin/reset'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function reset_pwd() {
        $this->form_validation->set_rules('current_pwd', '', 'trim|required');
        $this->form_validation->set_rules('new_pwd', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $admin_id = $this->input->post('admin_id');
            $current_pwd = $this->input->post('current_pwd');
            $new_pwd = $this->input->post('new_pwd');
            $modified_id = $this->session->userdata('admin_id');
            //date_default_timezone_set("Asia/Kolkata");
			date_default_timezone_set('US/Eastern');
            $password = base64_encode($current_pwd);
            $new_password = base64_encode($new_pwd);
            $data_admin = array(
                'Admin_Id' => $admin_id,
                'Admin_Password' => $password
            );
            $this->db->where($data_admin);
            $q_admin = $this->db->get('tbl_admin');
            $count_admin = $q_admin->num_rows();
            if ($count_admin == 1) {
                $update_data = array(
                    'Admin_Password' => $new_password,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Admin_Id', $admin_id);
                $q = $this->db->update('tbl_admin', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "invalid";
            }
        }
    }

    public function Logout() {
        $sess_data = $this->session->all_userdata();
        $admin_id = $sess_data['admin_id'];
        //date_default_timezone_set("Asia/Kolkata");
		date_default_timezone_set('US/Eastern');
        $data = array(
            'Last_Login' => date('Y-m-d H:i:s')
        );
        $this->db->where('Admin_Id', $admin_id);
        $update = $this->db->update('tbl_admin', $data);
        if ($update) {
            $this->session->sess_Destroy();
            redirect('Admin_Login');
        }
    }		/* Delete Admin Savecard Details Start here */    public function delete_card() {        $card_id = $this->input->post('card_id');        $data = array(            'card_id' => $card_id        );        $this->load->view('admin/refund/delete_card', $data);    }    public function delete_carddetails() {        $delete_card_id = $this->input->post('delete_card_id');        $sess_data = $this->session->all_userdata();        $modified_id = $sess_data['admin_id'];        $update_data = array(            'Status' => 0,            'Modified_By' => $modified_id,            'Modified_Date' => date('Y-m-d H:i:s')        );        $this->db->where('Id', $delete_card_id);        $q = $this->db->update('tbl_cards_admin', $update_data);        if ($q) {            echo "success";        } else {            echo "fail";        }    }    /* Delete Admin Savecard Details End here */			

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
