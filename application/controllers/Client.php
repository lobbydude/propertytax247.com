<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Client extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isClient()) {
            redirect('Client_Login');
        }
    }

    public function index() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'client/index'
        );
        $this->load->view('client/common/content', $data);
    }

    public function newplan() {
        $data = array(
            'title' => 'New Plan',
            'main_content' => 'client/newplan'
        );
        $this->load->view('client/common/content', $data);
    }

    public function new_plan() {
        $this->form_validation->set_rules('card_name', '', 'trim|required');
        $this->form_validation->set_rules('card_number', '', 'trim|required');
        $this->form_validation->set_rules('securitycode', '', 'trim|required');
        $this->form_validation->set_rules('zipcode', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('client_id');
            $plan_type = $this->input->post('add_new_order_type');
            $plan_id = $this->input->post('add_new_plan');
            $add_new_no_of_order = explode('|', $this->input->post('add_new_no_of_order'));
            $no_of_order = $add_new_no_of_order[0];
            $order_count = $add_new_no_of_order[1];
            $order_amt = $add_new_no_of_order[2];
            $total_order = $no_of_order * $order_count;
            $total_amt = $no_of_order * $order_amt;
            $insert_txn_data = array(
                'User_Id' => $user_id,
                'Plan_Id' => $plan_id,
                'Plan_Type' => $plan_type,
                'No_Of_Order' => $total_order,
                'Plan_Amt' => $order_amt,
                'Total_Amt' => $total_amt,
                'Paid_Amt' => $total_amt,
                'Mode' => 'Transfer',
                'Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_transaction', $insert_txn_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //   $this->load->view('error');
        }
    }

    public function editorder() {
        $data = array(
            'title' => 'Edit Order',
            'main_content' => 'client/edit_order'
        );
        $this->load->view('client/common/content', $data);
    }

    public function edit_orderinfodata() {
        $this->form_validation->set_rules('edit_client_orderinfo_order_number', '', 'trim|required');
        $this->form_validation->set_rules('edit_client_orderinfo_statelist', '', 'trim|required');
        $this->form_validation->set_rules('edit_client_orderinfo_zipcode', '', 'trim|required');
        $this->form_validation->set_rules('edit_client_orderinfo_borrowername', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $edit_client_orderinfo_orderid = $this->input->post('edit_client_orderinfo_orderid');
            $edit_client_orderinfo_street = $this->input->post('edit_client_orderinfo_street');
            $edit_client_orderinfo_order_number = $this->input->post('edit_client_orderinfo_order_number');
            $edit_client_orderinfo_statelist = $this->input->post('edit_client_orderinfo_statelist');
            $edit_client_orderinfo_city = $this->input->post('edit_client_orderinfo_city');
            $edit_client_orderinfo_zipcode = $this->input->post('edit_client_orderinfo_zipcode');
            $edit_client_orderinfo_borrowername = $this->input->post('edit_client_orderinfo_borrowername');
            $edit_client_orderinfo_apn = $this->input->post('edit_client_orderinfo_apn');
            $edit_client_orderinfo_notes = $this->input->post('edit_client_orderinfo_notes');
            //date_default_timezone_set("Asia/Kolkata");
            date_default_timezone_set('US/Eastern');
            $modified_id = $this->session->userdata('client_id');
            $update_data = array(
                'Street' => $edit_client_orderinfo_street,
                'Order_Number' => $edit_client_orderinfo_order_number,
                'State_County' => $edit_client_orderinfo_statelist,
                'City' => $edit_client_orderinfo_city,
                'Zipcode' => $edit_client_orderinfo_zipcode,
                'Borrower_Name' => $edit_client_orderinfo_borrowername,
                'APN' => $edit_client_orderinfo_apn,
                'Notes' => $edit_client_orderinfo_notes,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );

            $this->db->where('Order_Id', $edit_client_orderinfo_orderid);
            $q = $this->db->update('tbl_order', $update_data);
            
            $this->db->where('Order_Id', $edit_client_orderinfo_orderid);
            $q_order = $this->db->get('tbl_order');
            foreach ($q_order->result() as $row_order){
                $product_type=$row_order->Product_Type;
                $order_date1=$row_order->Order_Date;
                $order_date = date("d-m-Y", strtotime($order_date1));
            }

            /* Attachment Code Start Here */
            $this->load->view('client/M_pdf');
            $image_url = site_url('assets/admin/layout4/img/ordersheet.png');
            $order_sheet = "<div style='border:1px solid #002040;'>";
            $order_sheet .= "<div style='width:40%;float:left;margin-left:30px;margin-top:20px'>";
            $order_sheet .="<img src='$image_url'>";
            $order_sheet .="</div>";
            $order_sheet .="<div style='width:50%;float:left'>";
            $order_sheet .="<center><h4>PROPERTYREPORT247.COM<br>";
            $order_sheet .="2423 S ALDER ST PHILADELPHIA, PA 19148<br>";
            $order_sheet .="Toll Free : 1-844-508-4853</h4>";
            $order_sheet .="</center>";
            $order_sheet .="</div>";
            $order_sheet .="<br><br>";
            $order_sheet .="<div style='width:100%;margin:30px'>";
            $order_sheet .="<h4>Order Information : </h4>";
            $order_sheet .= "<table style='border-collapse:collapse;border:1px solid #002040;width:96%'>";
            $order_sheet .="<tr>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Order Number : </strong> $edit_client_orderinfo_order_number</td>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Order Date : </strong>" . $order_date . "</td>";
            $order_sheet .="</tr>";
            $order_sheet .="<tr>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Property Type : </strong> $product_type</td>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>State & County : </strong> $edit_client_orderinfo_statelist</td>";
            $order_sheet .="</tr>";
            $order_sheet .="<tr>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Street & Address : </strong> $edit_client_orderinfo_street</td>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>City : </strong> $edit_client_orderinfo_city</td>";
            $order_sheet .="</tr>";
            $order_sheet .="<tr>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Zip Code : </strong> $edit_client_orderinfo_zipcode</td>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Borrower Name : </strong> $edit_client_orderinfo_borrowername</td>";
            $order_sheet .="</tr>";
            $order_sheet .="<tr>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>APN : </strong> $edit_client_orderinfo_apn</td>";
            $order_sheet .="<td style='border:1px solid #002040;'><strong>Additional Notes  : </strong> $edit_client_orderinfo_notes</td>";
            $order_sheet .="</tr>";
            $order_sheet .="</table></div><br>";
            $order_sheet .="<p style='margin:30px'><b>Please Make Checks Payable to:</b><br>";
            $order_sheet .="Mailing Address:<br>";
            $order_sheet .="<b>Propertyreport247.com</b> <br> 2423 S Alder ST<br>Philadelphia, PA 19148,<br>Abstract Shop,LLC</p>";
            $order_sheet .="<br><br>";
            $order_sheet .="<p style='text-align:center;'><b>THANK YOU FOR THE OPPORTUNITY TO SERVE YOU</b><br>";
            $order_sheet .="For Queries Please Contact:<br>";
            $order_sheet .="Propertyreport247.com, Tollfree : 1-844-508-4853 / Email: techteam@drnds.com</p></div>";
            $mpdf1 = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
            $mpdf1->SetDisplayMode('fullpage');
            $mpdf1->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
            $mpdf1->WriteHTML($order_sheet);
            $mpdf1->Output('orders/order_sheet' . $edit_client_orderinfo_order_number . '.pdf', 'F');
            /* Attachment Code End Here */

            $update_doc_data = array(
                'File' => "order_sheet$edit_client_orderinfo_order_number.pdf",
                'Description' => "Order Sheet",
                'Uploaded_By' => 'client',
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $get_doc_data = array(
                'Order_Id' => $edit_client_orderinfo_orderid,
                'Doc_Type' => "Order Sheet",
                'Status' => 1
            );
            $this->db->where($get_doc_data);
            $this->db->update('tbl_orderdocuments', $update_doc_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    public function upload_order() {
        $this->form_validation->set_rules('edit_client_orderupload_description', '', 'trim|required');
//$this->form_validation->set_rules('edit_client_orderupload_file', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            if (is_array($_FILES)) {
                if (is_uploaded_file($_FILES['edit_client_orderupload_file']['tmp_name'])) {
                    $edit_client_orderupload_orderid = $this->input->post('edit_client_orderupload_orderid');
                    $edit_client_orderupload_doctype = $this->input->post('edit_client_orderupload_doctype');
                    $edit_client_orderupload_description = $this->input->post('edit_client_orderupload_description');
                    $sourcePath = $_FILES['edit_client_orderupload_file']['tmp_name'];
                    $file_name = rand() . $_FILES['edit_client_orderupload_file']['name'];
                    $targetPath = "orders/" . $file_name;
                    $inserted_id = $this->session->userdata('client_id');
                    //date_default_timezone_set("Asia/Kolkata");
                    date_default_timezone_set('US/Eastern');
                    if (move_uploaded_file($sourcePath, $targetPath)) {
                        $insert_data = array(
                            'Order_Id' => $edit_client_orderupload_orderid,
                            'Doc_Type' => $edit_client_orderupload_doctype,
                            'Description' => $edit_client_orderupload_description,
                            'File' => $file_name,
                            'Uploaded_By' => 'client',
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'), 'Status' => 1
                        );
                        $q = $this->db->insert('tbl_orderdocuments', $insert_data);
                        if ($q) {
                            echo "success";
                        } else {
                            echo "fail";
                        }
                    }
                }
            }
        }
    }

    public function placeorder() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'client/placeorder'
        );
        $this->load->view('client/common/content', $data);
    }

    public function cart() {
        //ini_set('error_reporting', E_STRICT);
        $kelement = $this->input->post('kelement');
        $address_count = $this->input->post('address_count');
        $user_id = $this->session->userdata('client_id');
        $this->load->view('phpmailer/class_phpmailer');
        if ($user_id) {
            $plan_id = $this->input->post('plan_id');
            $total_amount = $this->input->post('total_amount');

            for ($i = 1; $i <= $address_count; $i++) {
                $street = $this->input->post('street' . $kelement . $i);
                $order_number = $this->input->post('order_number' . $kelement . $i);
                $product_type = $this->input->post('product_type' . $kelement . $i);
                $productprice = $this->input->post('propertyprice' . $kelement . $i);
                $statelist = $this->input->post('statelist' . $kelement . $i);
                $city = $this->input->post('city' . $kelement . $i);
                $zipcode = $this->input->post('zipcode' . $kelement . $i);
                $borrowername = $this->input->post('borrowername' . $kelement . $i);
                $apn = $this->input->post('apn' . $kelement . $i);
                $notes = $this->input->post('notes' . $kelement . $i);
                $rushorder = $this->input->post('rushorder' . $kelement . $i);
                $orderprice = $this->input->post('orderprice' . $kelement . $i);
                $txn_id = $this->input->post('txn_number' . $kelement . $i);
               // $cart_id = $this->input->post('cart_number' . $kelement . $i);
                $unique_id = $this->input->post('unique_number' . $kelement . $i);
                $today = date('Y-m-d H:i:s');
                $set_date = date('Y-m-d H:i:s', strtotime($today) + 172800);
				$get_cart_data = array(
                    'User_Id' => $user_id,
                    'Txn_Id' => $txn_id,
                    'Plan_Id' => $plan_id,
                    'St_County'=>$statelist,
                    'Unique_no' => $unique_id,
                    'Status' => 1
                );
                $this->db->where($get_cart_data);
                $q_cart = $this->db->get('tbl_cart');
                foreach ($q_cart->result() as $row_cart) {
                    $cart_id = $row_cart->Cart_Id;
                }
                $inserted_date = date('Y-m-d H:i:s');
                $insert_order_data = array(
                    'Txn_Id' => $txn_id,
                    'User_Id' => $user_id,
                    'Cart_id' => $cart_id,
                    'Cart_Unique_no' => $unique_id,
                    'Plan_Id' => $plan_id,
                    'Product_Type' => $product_type,
                    'Product_Price' => $productprice,
                    'Street' => $street,
                    'Order_Number' => $order_number,
                    'State_County' => $statelist,
                    'City' => $city,
                    'Zipcode' => $zipcode,
                    'Borrower_Name' => $borrowername,
                    'APN' => $apn,
                    'Notes' => $notes,
                    'Priority' => $rushorder,
                    'Order_Date' => date('Y-m-d'),
                    'Order_Status' => 'Processing',
                    'Set_Date' => $set_date,
                    'Inserted_Date' => $inserted_date,
                    'Status' => 1
                );
                $this->db->insert('tbl_order', $insert_order_data);
                $order_id = $this->db->insert_id();

                /* Attachment Code Start Here */
                $image_url = site_url('assets/admin/layout4/img/ordersheet.png');
                $order_sheet = "<div style='border:1px solid #002040;'>";
                $order_sheet .= "<div style='width:40%;float:left;margin-left:30px;margin-top:20px'>";
                $order_sheet .="<img src='$image_url'>";
                $order_sheet .="</div>";
                $order_sheet .="<div style='width:50%;float:left'>";
                $order_sheet .="<center><h4>PROPERTYREPORT247.COM<br>";
                $order_sheet .="2423 S ALDER ST PHILADELPHIA, PA 19148<br>";
                $order_sheet .="Toll Free : 1-844-508-4853</h4>";
                $order_sheet .="</center>";
                $order_sheet .="</div>";
                $order_sheet .="<br><br>";
                $order_sheet .="<div style='width:100%;margin:30px'>";
                $order_sheet .="<h4>Order Information : </h4>";
                $order_sheet .= "<table style='border-collapse:collapse;border:1px solid #002040;width:96%'>";
                $order_sheet .="<tr>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Order Number : </strong> $order_number</td>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Order Date : </strong>" . date('d-m-Y') . "</td>";
                $order_sheet .="</tr>";
                $order_sheet .="<tr>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Property Type : </strong> $product_type</td>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>State & County : </strong> $statelist</td>";
                $order_sheet .="</tr>";
                $order_sheet .="<tr>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Street & Address : </strong> $street</td>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>City : </strong> $city</td>";
                $order_sheet .="</tr>";
                $order_sheet .="<tr>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Zip Code : </strong> $zipcode</td>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Borrower Name : </strong> $borrowername</td>";
                $order_sheet .="</tr>";
                $order_sheet .="<tr>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>APN : </strong> $apn</td>";
                $order_sheet .="<td style='border:1px solid #002040;'><strong>Additional Notes  : </strong> $notes</td>";
                $order_sheet .="</tr>";
                $order_sheet .="</table></div><br>";
                $order_sheet .="<p style='margin:30px'><b>Please Make Checks Payable to:</b><br>";
                $order_sheet .="Mailing Address:<br>";
                $order_sheet .="<b>Propertyreport247.com</b> <br> 2423 S Alder ST<br>Philadelphia, PA 19148,<br>Abstract Shop,LLC</p>";
                $order_sheet .="<br><br>";
                $order_sheet .="<p style='text-align:center;'><b>THANK YOU FOR THE OPPORTUNITY TO SERVE YOU</b><br>";
                $order_sheet .="For Queries Please Contact:<br>";
                $order_sheet .="Propertyreport247.com, Tollfree : 1-844-508-4853 / Email: neworders@propertyreport247.com</p></div>";
				$mpdf1 = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
                $mpdf1->SetDisplayMode('fullpage');
                $mpdf1->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
                $mpdf1->WriteHTML($order_sheet);
                $mpdf1->Output('orders/order_sheet' . $order_number . '.pdf', 'F');
                /* Attachment Code End Here */
                $insert_doc_data = array(
                    'Order_Id' => $order_id,
                    'Doc_Type' => "Order Sheet",
                    'File' => "order_sheet$order_number.pdf",
                    'Description' => "Order Sheet",
                    'Uploaded_By' => 'client',
                    'Inserted_By' => $user_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_orderdocuments', $insert_doc_data);

                $insert_billing_data[] = array(
                    'User_Id' => $user_id,
                    'Txn_Id' => $txn_id,
                    'Order_Id' => $order_id,
                    'Product_Price' => $productprice,
                    'Priority_Price' => $rushorder,
                    'Order_Amount' => $productprice + $rushorder,
                    'Status' => 1
                );
            }
            $this->db->insert_batch('tbl_billing', $insert_billing_data);
            $insert_account = array(
                'Txn_Id' => $txn_id,
                'User_Id' => $user_id,
                'Plan_Id'=>$plan_id,
                'Order_Date' => date('Y-m-d'),
                'Total_Amount' => $total_amount,
                'Inserted_By' => $user_id,
                'Inserted_Date' => $inserted_date,
                'Status' => 1
            );
            $this->db->insert('tbl_account', $insert_account);
            $this->db->where('Plan_Id', $plan_id);
            $q_plan = $this->db->get('tbl_plan');
            foreach ($q_plan->result() as $row_plan) {
                $plan_name = $row_plan->Plan_Name;
            }
            $username = $this->session->userdata('client_username');

            $this->db->where('User_Id', $user_id);
            $q_user = $this->db->get('tbl_user');
            foreach ($q_user->result() as $row_user) {
                $user_email = $row_user->Email_Address;
            }
            $order_date_mail = date('d-M-Y H:i:s');
			// Invoice Mail Code Start
            $invoice_id = str_pad(($txn_id), 4, '0', STR_PAD_LEFT);
            $msg1 = "Hello $username, <br><br> <p>Thank you for placing the Orders. Your payment has made successfully, please find the attached invoice.</p><br>";
			$msg1 .="You can also log in to web portal <a href='https://www.propertyreport247.com'>propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br>";
            $msg1 .="If you have any Query ,kindly revert back.<br><br><br>";
            $msg1 .="Thank you,<br>";
            $msg1 .="Best Regards,<br>";
            $msg1 .="Propertyreport247.com,<br>";
            $msg1 .="2423 S Alder ST,<br>";
            $msg1 .="Philadelphia, PA 19148<br>";
            $msg1 .="<img src=" . base_url('assets/admin/layout4/img/logo-light1.png') . "><br>";
            $msg1 .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";

            /* Attachment Code Start Here */
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
            $msg_doc .= "<table cellpading='23' style='border-collapse:collapse;border:1px solid #002040;width:97%'><tr>";
            $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px;'>Order Date</th>";
            $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px;'>Order No</th>";
            $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px;'>Plan</th>";
            $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px;'>Product Type</th>";
            $msg_doc .="<th style='background-color:#002040;color:#fff;border:1px solid #002040;padding:10px;'>Price ($)</th>";
            $msg_doc .="</tr>";
            $total_amount_doc = 0;
            for ($k = 1; $k <= $address_count; $k++) {
                $order_number_doc = $this->input->post('order_number' . $kelement . $k);
                $product_type_doc = $this->input->post('product_type' . $kelement . $k);
                $productprice_doc = $this->input->post('propertyprice' . $kelement . $k);
                $rushorder_doc = $this->input->post('rushorder' . $kelement . $k);
                $total_price_doc = $productprice_doc + $rushorder_doc;
                $msg_doc .="<tr>";
                $msg_doc .="<td style='border:1px solid #002040;'>$order_date_mail</td>";
                $msg_doc .="<td style='border:1px solid #002040;'>$order_number_doc</td>";
                $msg_doc .="<td style='border:1px solid #002040;'>$plan_name</td>";
                $msg_doc .="<td style='border:1px solid #002040;'>$product_type_doc</td>";
                $msg_doc .="<td style='border:1px solid #002040;'>$total_price_doc</td>";
                $msg_doc .="</tr>";
                $total_amount_doc = $total_price_doc + $total_amount_doc;
            }
			 $msg_doc .="<tr>";
            $msg_doc .="<td colspan='3' style='border:1px solid #002040;'></td>";
            $msg_doc .="<td style='border:1px solid #002040;'>Total</td>";
            $msg_doc .="<td style='border:1px solid #002040;'>$total_amount_doc</td>";
            $msg_doc .="</tr>";
            $msg_doc .="</table><br><br>";
            $msg_doc .="<p style='margin-left:10px'>Please Make Checks Payable to:<br>";
            $msg_doc .="Mailing Address:<br>";
            $msg_doc .="Propertyreport247.com <br> 2423 S Alder ST<br>Philadelphia, PA 19148</p>";
            $msg_doc .="<br><br><br><br>";
            $msg_doc .="<p style='text-align:center;'>THANK YOU FOR THE OPPORTUNITY TO SERVE YOU<br>";
            $msg_doc .="For Queries Please Contact:<br>";
            $msg_doc .="Propertyreport247.com, Toll Free : 1-844-508-4853, Email : neworders@propertyreport247.com</p></div>";
            $mpdf = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($msg_doc);
            $attachment = $mpdf->Output('orders.pdf', 'S');
            /* Attachment Code End Here */
		// New Orders created Mail 
            $mail1 = new PHPMailer();
            $mail1->IsSMTP();
            $mail1->CharSet = 'UTF-8';            
			$mail1->Host = "localhost";
            //$mail1->SMTPAuth = true;
            $mail1->Port = 465;
            $mail1->Username = "neworders@propertyreport247.com";
            $mail1->Password = 'Abs@789';
            $mail1->SMTPSecure = 'ssl';
            $mail1->From = "neworders@propertyreport247.com";
            $mail1->FromName = "Propertyreport247.com";
            $mail1->isHTML(true);
            $mail1->Subject = "Propertyreport247.com - $address_count - New Orders";
            $mail1->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg1</font>";
            $mail1->addAddress("$user_email");
            $mail1->addBCC("neworders@propertyreport247.com");
            $mail1->AddStringAttachment($attachment, 'invoice.pdf');
            $mail1->SMTPDebug = 1;
            $mail1->send();

            $msg = "Hello $username, <br><br><p>Thank you for choosing us and placing the order.</p>";
			$msg .="<p>We will revert to you with an ETA and status shortly.</p><br>";
			$msg .="<p style='font-weight: bold;'><b>Note: Please login to web portal to track further status/update of the files</b><br>";
			$msg .="<p>Thank you for the business.</p>";			
            $msg .="Order Date : $order_date_mail<br>";
            $msg .="Plan : $plan_name<br><br>";
            $msg .="<table border='2' cellpading='8' style='border-collapse:collapse;font-family: Helvetica;font-size:14px'><tr>";
            $msg .="<th style='background-color:#3598dc;color:#fff;'>Order No</th>";
            $msg .="<th style='background-color:#3598dc;color:#fff;'>Order Date</th>";
            $msg .="<th style='background-color:#3598dc;color:#fff'>Product Type</th>";
            $msg .="<th style='background-color:#3598dc;color:#fff'>Rush Order</th>";
            $msg .="<th style='background-color:#3598dc;color:#fff'>Price</th>";
            $msg .="</tr>";

            for ($j = 1; $j <= $address_count; $j++) {
                $order_number_mail = $this->input->post('order_number' . $kelement . $j);
                $product_type_mail = $this->input->post('product_type' . $kelement . $j);
                $productprice_mail = $this->input->post('propertyprice' . $kelement . $j);
                $rushorder_mail = $this->input->post('rushorder' . $kelement . $j);
                $msg .="<tr>";
                $msg .="<td>$order_number_mail</td>";
                $msg .="<td>$order_date_mail</td>";
                $msg .="<td>$product_type_mail</td>";
                $msg .="<td>$rushorder_mail</td>";
                $msg .="<td>$productprice_mail</td>";
                $msg .="</tr>";
            }
            $msg .="</table><br><br><br><br><br>";
            $msg .="Thank you,<br>";
            $msg .="Best Regards,<br>";
            $msg .="Propertyreport247.com,<br>";
            $msg .="2423 S Alder ST,<br>";
            $msg .="Philadelphia, PA 19148<br>";
			$image_url = site_url('assets/admin/layout4/img/ordersheet.png');
			$msg .="<img src='$image_url'><br/>";
            //$msg .="<img src=" . base_url('assets/admin/layout4/img/logo-light1.png') . "><br>";
            $msg .="--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
            ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = "localhost";
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->Username = "neworders@propertyreport247.com";
            $mail->Password = 'Abs@789';
            $mail->SMTPSecure = 'ssl';
            $mail->From = "neworders@propertyreport247.com";
            $mail->FromName = "Propertyreport247.com";
            $mail->isHTML(true);
            $mail->Subject = "Propertyreport247.com - $address_count - New Orders";
            $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
            $mail1->addAddress("$user_email");
            $mail->addBCC("neworders@propertyreport247.com");
            $mail->SMTPDebug = 1;
            $mail->send();
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function download_document() {
        $filename = $this->uri->segment(3);
        $data = file_get_contents(base_url('orders/' . $filename)); // Read the file's contents
        force_download($filename, $data);
    }

    public function account() {
        $data = array(
            'title' => 'Account History',
            'main_content' => 'client/history/account'
        );
        $this->load->view('client/common/content', $data);
    }

    public function viewaccount() {
        $data = array(
            'title' => 'Account History',
            'main_content' => 'client/history/view_account'
        );
        $this->load->view('client/common/content', $data);
    }

    public function payment() {
        $data = array(
            'title' => 'Payment History',
            'main_content' => 'client/history/payment'
        );
        $this->load->view('client/common/content', $data);
    }

    public function invoice() {
        $data = array(
            'title' => 'Payment History',
            'main_content' => 'client/history/invoice'
        );
        $this->load->view('client/common/content', $data);
    }

    public function searchorder() {
        $order_no = $this->input->post('search_order');
        $data = array(
            'title' => 'Order',
            'main_content' => 'client/searchorder',
            'order_no' => $order_no
        );
        $this->load->view('client/common/content', $data);
    }

    public function check_order() {
        $order_no = $this->input->post('ordernumber');
        $this->db->where('Order_Number', $order_no);
        $q_order = $this->db->get('tbl_order');
        $count_order = $q_order->num_rows();
        if ($count_order > 0) {
            echo "exists";
            return false;
        } else {
            echo "success";
        }
    }

    public function profile() {
        $data = array(
            'title' => 'Profile',
            'main_content' => 'client/profile'
        );
        $this->load->view('client/common/content', $data);
    }

    public function edit_profile() {
        $this->form_validation->set_rules('fullname', '', 'trim|required');
        $this->form_validation->set_rules('businessname', '', 'trim|required');
        $this->form_validation->set_rules('username', '', 'trim|required');
        $this->form_validation->set_rules('email', '', 'trim|required');
        $this->form_validation->set_rules('phone', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $client_id = $this->input->post('client_id');
            $fullname = $this->input->post('fullname');
            $businessname = $this->input->post('businessname');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $modified_id = $this->session->userdata('client_id');
            //date_default_timezone_set("Asia/Kolkata");
			date_default_timezone_set('US/Eastern');
            $update_data = array(
                'First_Name' => $fullname,
                'Business_Name' => $businessname,
                'Username' => $username,
                'Email_Address' => $email,
                'Phone_Number' => $phone,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('User_Id', $client_id);
            $q = $this->db->update('tbl_user', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    public function makepayment() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'client/makepayment'
        );
        $this->load->view('client/common/content', $data);
    }

    public function make_payment() {
        $this->form_validation->set_rules('make_pay_amt', '', 'trim|required');
        $this->form_validation->set_rules('make_card_name', '', 'trim|required');
        $this->form_validation->set_rules('make_card_number', '', 'trim|required');
        $this->form_validation->set_rules('make_exp_month', '', 'trim|required');
        $this->form_validation->set_rules('make_exp_year', '', 'trim|required');
        $this->form_validation->set_rules('make_securitycode', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $make_pay_amt = $this->input->post('make_pay_amt');
            $plan_id = $this->input->post('make_plan_id');
            $plan_amount = $this->input->post('make_plan_amt');
            $no_of_order = $this->input->post('make_no_of_order');
            $user_id = $this->session->userdata('client_id');
            $insert_txn_data = array(
                'User_Id' => $user_id,
                'Plan_Id' => $plan_id,
                'Plan_Amt' => $plan_amount,
                'Paid_Amt' => $make_pay_amt,
                'No_Of_Order' => $no_of_order,
                'Mode' => 'Transfer',
                'Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q_txn = $this->db->insert('tbl_transaction', $insert_txn_data);
            if ($q_txn) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Delete Order Details Start here */

    public function delete_orderinfo() {
        $order_id = $this->input->post('order_id');
        $order_no = $this->input->post('order_no');
        $data = array(
            'order_id' => $order_id,
            'order_no' => $order_no
        );
        $this->load->view('client/delete_order', $data);
    }

    public function delete_order() {
        $delete_order_id = $this->input->post('delete_order_id');
        $reason = $this->input->post('reason');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['client_id'];
        $update_data1 = array(
            'Cancel_Reason' => $reason,
            'Order_Status' => 'Canceled',
            'Modified_By' => $modified_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Order_Id', $delete_order_id);
        $q = $this->db->update('tbl_order', $update_data1);
        $update_data2 = array(
            'Status' => 0
        );
        $this->db->where('Order_Id', $delete_order_id);
        $this->db->update('tbl_billing', $update_data2);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Delete Order Details End here */
	/* User Upload Document Delete Details Start here */
	 public function Deletedocument() {
        $doc_id = $this->input->post('doc_id');        
        $data = array(
            'doc_id' => $doc_id
        );
        $this->load->view('client/delete_document', $data);        
    }
    public function delete_document() {            
        $delete_document_id = $this->input->post('delete_document_id');             
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['client_id'];
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
	/* User Upload Document Delete Details Start here */
	
	

    /* Refund Details Start here */

    public function refund() {
        $data = array(
            'title' => 'Refund',
            'main_content' => 'client/refund/index'
        );
        $this->load->view('client/common/content', $data);
    }

    public function refund_request() {
        $this->form_validation->set_rules('refund_request_plan', '', 'trim|required');
        $this->form_validation->set_rules('refund_request_reason', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $cart_id = $this->input->post('refund_request_plan');

            $get_data = array(
                'Cart_Id' => $cart_id,
                'Status' => 1
            );
            $this->db->where($get_data);
            $q_cart = $this->db->get('tbl_cart');
            foreach ($q_cart->result() as $row_cart) {
                $plan_id = $row_cart->Plan_Id;
                $unique_no = $row_cart->Unique_no;
				$txn_id = $row_cart->Txn_Id;
            }
            $reason = $this->input->post('refund_request_reason');
            $tc = $this->input->post('refund_request_tc');
            $user_id = $this->session->userdata('client_id');
            $inserted_id = $this->session->userdata('client_id');
            $insert_refund_data = array(
                'User_Id' => $user_id,
                'Unique_No' => $unique_no,
				'Txn_Id'=>$txn_id,
                'Plan_Id' => $plan_id,
                'Reason' => $reason,
                'T&C' => $tc,
                'Refund_Status' => 'Processing',
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q_refund = $this->db->insert('tbl_refund', $insert_refund_data);
            if ($q_refund) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    public function view_refund() {
        $refund_id = $this->input->post('refund_id');
        $data = array(
            'refund_id' => $refund_id
        );
        $this->load->view('client/refund/view_refund', $data);
    }

    /* Refund Details End here */

    /* Cancel History Start Here */

    public function cancel() {
        $data = array(
            'title' => 'Cancel',
            'main_content' => 'client/history/cancel'
        );
        $this->load->view('client/common/content', $data);
    }

    /* Cancel History End Here */

    public function reset() {
        $data = array(
            'title' => 'Profile',
            'main_content' => 'client/reset'
        );
        $this->load->view('client/common/content', $data);
    }

    public function reset_pwd() {
        $this->form_validation->set_rules('current_pwd', '', 'trim|required');
        $this->form_validation->set_rules('new_pwd', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $client_id = $this->input->post('client_id');
            $current_pwd = $this->input->post('current_pwd');
            $new_pwd = $this->input->post('new_pwd');
            $modified_id = $this->session->userdata('client_id');
            $password = base64_encode($current_pwd);
            $new_password = base64_encode($new_pwd);
            $data_client = array(
                'User_Id' => $client_id,
                'Password' => $password
            );
            $this->db->where($data_client);
            $q_client = $this->db->get('tbl_user');
            $count_admin = $q_client->num_rows();
            if ($count_admin == 1) {
                $update_data = array(
                    'Password' => $new_password,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('User_Id', $client_id);
                $q = $this->db->update('tbl_user', $update_data);
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
        $client_id = $this->session->userdata('client_id');
        //date_default_timezone_set("Asia/Kolkata");
		date_default_timezone_set('US/Eastern');
        $data = array(
            'Last_Login' => date('Y-m-d H:i:s')
        );
        $this->db->where('User_Id', $client_id);
        $update = $this->db->update('tbl_user', $data);
        if ($update) {
            $this->session->sess_Destroy();
            redirect('Client_Login');
        }
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
