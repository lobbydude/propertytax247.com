<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
    }

    public function index() {
        if ($this->session->userdata('client_id') != NULL) {
            $data = array(
                'title' => 'Dashboard',
                'main_content' => 'client/cart/checkout'
            );
            $this->load->view('client/common/content', $data);
        } else {
            redirect('Client_Login');
        }
    }

    public function Storeitems() {
        $showcart = $this->input->post('showcart');
        $total_cart_items = $this->input->post('total_cart_items');
        $data = array(
            'showcart' => $showcart,
            'total_cart_items' => $total_cart_items
        );
        $this->load->view('client/cart/storeitems', $data);
    }

    public function Signupcartitems() {
        $showcart = $this->input->post('showcart');
        $total_cart_items = $this->input->post('total_cart_items');
        $data = array(
            'showcart' => $showcart,
            'total_cart_items' => $total_cart_items
        );
        $this->load->view('client/cart/signupcartitems', $data);
    }

    public function Editcart() {
        $code = $this->input->post('code');
        $data = array(
            'code' => $code
        );
        $this->load->view('client/cart/edit_cart', $data);
    }

    public function change_county() {
        $state_id = $this->input->post('state_id');
        $data = array(
            'state_id' => $state_id
        );
        $this->load->view('client/cart/change_county', $data);
    }

    public function addtocart() {
        session_start();
        $state = $_POST['state_id'];
        $statename = $_POST['statename'];
        $county = $_POST['county_id'];
        $no_of_order = $_POST['no_of_order'];
        $order_code = $_POST['order_code'];
        $order_type = $_POST['order_type'];
        if ($order_type == "Single") {
            $countyorder = $county . "(" . $no_of_order . ")";
            foreach ($_SESSION["cart_item"] as $k => $v) {
                if ($order_code == $v['code']) {
                    $_SESSION['cart_item'][$k]['state'] = $state;
                    $_SESSION['cart_item'][$k]['county'] = $county;
                    $_SESSION['cart_item'][$k]['no_of_order'] = $no_of_order;
                    $_SESSION['cart_item'][$k]['countyorder'] = $countyorder;
                }
            }
        } else {
            $countyorder = $statename . " - " . $county . "(" . $no_of_order . ")";
            foreach ($_SESSION["cart_item"] as $k => $v) {
                if ($order_code == $v['code']) {
                    $order_type_session = $_SESSION['cart_item'][$k]['order_type'];
                    $plan_id_session = $_SESSION['cart_item'][$k]['plan_name'];
                    $state_session = $_SESSION['cart_item'][$k]['state'];
                    $county_session = $_SESSION['cart_item'][$k]['county'];
                    $no_of_order_session = $_SESSION['cart_item'][$k]['no_of_order'];
                    $county_order_session = $_SESSION['cart_item'][$k]['countyorder'];
                    $price_session = $_SESSION['cart_item'][$k]['price'];
                    $countyname = $statename . " - " . $county;

                    if (strpos($county_order_session, "$countyname") !== false) {
                        echo "exists";
                    } else {
                        $county_session .=$countyname . "|";
                        $_SESSION['cart_item'][$k]['county'] = $county_session;
                        $no_of_order_session .= $no_of_order . "|";
                        $_SESSION['cart_item'][$k]['no_of_order'] = $no_of_order_session;
                        $county_order_session .= $countyorder . "|";
                        $_SESSION['cart_item'][$k]['countyorder'] = $county_order_session;

                        $no_of_order_array = explode('|', $no_of_order_session);
                        $no_of_order_id = count($no_of_order_array);
                        $no_of_order1 = 0;
                        for ($l = 0; $l < ($no_of_order_id - 1); $l++) {
                            $no_of_order1 = $no_of_order1 + $no_of_order_array[$l];
                        }
                        $nooforder = $no_of_order1 / 10;
                        $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_session";
                        $result_plan_sess = mysql_query($q_plan_sess);
                        while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                            $no_of_order_sess1 = $row_plan_sess['No_Of_Order'];
                            $plan_price_sess1 = $row_plan_sess['Price'];
                            $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                            $perorder_price = $plan_price_sess1 / $no_of_order_sess1;
                            $perorder_amt = number_format((float) $perorder_price, 2, '.', '');
                        }
                        $plan_price1 = $plan_price_sess1 * $nooforder;
                        $plan_price = number_format((float) $plan_price1, 2, '.', '');
                        $plan_total_amount = "$no_of_order1 orders @ $$perorder_amt each / $$plan_price Total";
                        $_SESSION['cart_item'][$k]['price'] = $plan_total_amount;
                    }
                }
            }
        }
    }

    public function removecart() {
        session_start();
        $order_code = $_POST['order_code'];
        $county_order = $_POST['county_order'] . "|";
        $state_session = "";
        $county_session = "";
        $no_of_order_session = "";
        $countyorder_session = "";

        foreach ($_SESSION["cart_item"] as $k => $v) {
            if ($order_code == $v['code']) {
                $order_type_session = $_SESSION['cart_item'][$k]['order_type'];
                $plan_id_session = $_SESSION['cart_item'][$k]['plan_name'];
                $state_session .= $_SESSION['cart_item'][$k]['state'];
                $county_session .= $_SESSION['cart_item'][$k]['county'];
                $no_of_order_session .= $_SESSION['cart_item'][$k]['no_of_order'];
                $county_order_session = $_SESSION['cart_item'][$k]['countyorder'];
                $price_session = $_SESSION['cart_item'][$k]['price'];
                $countyorder_sessionval = str_replace($county_order, '', $county_order_session);
                $_SESSION['cart_item'][$k]['countyorder'] = $countyorder_sessionval;

                preg_match_all("/\(([^\)]*)\)/", $countyorder_sessionval, $matches_order);
                $no_order_session = $matches_order[1];
                $no_order_count = array_sum($no_order_session);
                $no_of_order_array = implode("|", $no_order_session);
                $_SESSION['cart_item'][$k]['no_of_order'] = $no_of_order_array . "|";
                $nooforder = $no_order_count / 10;
                $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_session";
                $result_plan_sess = mysql_query($q_plan_sess);
                while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                    $no_of_order_sess1 = $row_plan_sess['No_Of_Order'];
                    $plan_price_sess1 = $row_plan_sess['Price'];
                    $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                    $perorder_price = $plan_price_sess1 / $no_of_order_sess1;
                    $perorder_amt = number_format((float) $perorder_price, 2, '.', '');
                }
                $plan_price1 = $plan_price_sess1 * $nooforder;
                $plan_price = number_format((float) $plan_price1, 2, '.', '');
                $plan_total_amount = "$no_order_count orders @ $$perorder_amt each / $$plan_price Total";
                $_SESSION['cart_item'][$k]['price'] = $plan_total_amount;
            }
        }
    }

    public function removefromcart() {
        session_start();
        $code = $this->input->post('order_code');
        if (!empty($_SESSION["cart_item"])) {
            foreach ($_SESSION["cart_item"] as $k => $v) {
                if ($code == $v['code']) {
                    unset($_SESSION["cart_item"][$k]);
                    echo count($_SESSION['cart_item']);
                }
                if (empty($_SESSION["cart_item"])) {
                    unset($_SESSION["cart_item"]);
                }
            }
        } else {
            echo 0;
        }
    }

    public function billing() {
        if ($this->session->userdata('client_id') != NULL) {
            $data = array(
                'title' => 'billing',
                'main_content' => 'client/cart/billing'
            );
            $this->load->view('client/common/content', $data);
        } else {
            redirect('Client_Login');
        }
    }

    public function cart_makepayment() {
        $this->load->view('phpmailer/class_phpmailer');
        $user_id = $this->session->userdata('client_id');
        $make_pay_amt = $this->input->post('make_pay_amt');
        $plan_id = $this->input->post('make_plan_id');
        $plan_amount = $this->input->post('make_plan_amt');
        $order_type = $this->input->post('make_order_type');
        $no_of_order = $this->input->post('make_no_of_order');
        if (isset($_POST['save_card'])) {
            $Card_Holder_Name = $this->input->post('Make_Card_Holder_Name');
            $Card_Number = $this->input->post('Make_Card_Number');
            $Expired_Year = $this->input->post('Make_Expired_Year');
            $Expired_Month = $this->input->post('Make_Expired_Month');
            $Zip_Code = $this->input->post('Make_Zip_Code');
            $Cvv = $this->input->post('Make_Securitycode');
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
        }
        if (isset($_POST['saved_card_no'])) {
            $saved_card_id = $this->input->post('saved_card_no');
            $data_card = array(
                'User_id' => $user_id,
                'Id' => $saved_card_id,
                'Status' => 1
            );
            $this->db->where($data_card);
            $q_cards = $this->db->get('tbl_cards');
            foreach ($q_cards->result() as $row_cards) {
                $Card_Holder_Name = $row_cards->Card_Holder_Name;
                $Card_Number = $row_cards->Card_Number;
                $Expired_Year = $row_cards->Expired_Year;
                $Expired_Month = $row_cards->Expired_Month;
                $card_type = $row_cards->Card_Type;
            }
            $Zip_Code = $this->input->post('make_saved_zipcode');
            $Cvv = $this->input->post('make_saved_securitycode');
        }
        $data_user = array(
            'User_Id' => $user_id,
            'Status' => 1
        );
        $this->db->where($data_user);
        $q_user = $this->db->get('tbl_user');
        foreach ($q_user->result() as $row_user) {
            $email = $row_user->Email_Address;
            $phone = $row_user->Phone_Number;
        }
        $this->load->library('authorize_net');
        $auth_net = array(
            'x_card_num' => $Card_Number,
            'x_exp_date' => $Expired_Month . '/' . $Expired_Year,
            'x_card_code' => $Cvv,
            'x_amount' => $make_pay_amt,
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
            $select_txn_insert = "INSERT INTO tbl_transaction (Transaction_Id,User_Id, Total_Amt, Paid_Amt, Mode, Date, Status) VALUES ('$transaction_id','$user_id', '$plan_amount', '$make_pay_amt', 'Transfer', '$txn_date'," . 1 . ")";
            $q_txn_insert = mysql_query($select_txn_insert);
            $txn_id = mysql_insert_id();
            if ($q_txn_insert) {

                if (isset($_POST['save_card'])) {
                    $Inserted_Date = date('Y-m-d H:i:s');
                    $select_card_insert = "INSERT INTO tbl_cards (User_Id, Card_Holder_Name, Card_Number, Expired_Year, Expired_Month, Zip_Code,Card_Type, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$Card_Holder_Name', '$Card_Number', '$Expired_Year', '$Expired_Month', '$Zip_Code','$card_type','$user_id', '$Inserted_Date'," . 1 . ")";
                    mysql_query($select_card_insert);
                }
                $q_plan = "select * from tbl_plan where Plan_Id=$plan_id and Status=1";
                $result_plan = mysql_query($q_plan);
                $cart_date = date('Y-m-d H:i:s');
                while ($row_plan = mysql_fetch_array($result_plan)) {
                    $plan_name = $row_plan['Plan_Name'];
                    $plan_price1 = $row_plan['Price'];
                    $plan_price = number_format((float) $plan_price1, 2, '.', '');
                    $Unique_no = uniqid();
                    $select_cart_insert = "INSERT INTO tbl_cart (User_Id, Txn_Id, Plan_Id, Plan_Name, Order_Type,Unique_no,Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id', '$plan_name', '$order_type','$Unique_no', '$user_id', '$cart_date', " . 1 . ")";
                    mysql_query($select_cart_insert);
                    $select_cart_insert = "INSERT INTO tbl_cartamount (User_Id, Txn_Id, Plan_Id, Plan_Name,Plan_Amount,Total_Amount, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id', '$plan_name','$plan_price','$make_pay_amt', '$user_id', '$cart_date', " . 1 . ")";
                    mysql_query($select_cart_insert);
                }

                echo "success";
            }
        } else {
            echo '<p>' . $this->authorize_net->getError() . '</p>';
            $this->authorize_net->debug();
        }
    }

    public function paypal_makepayment() {
        $user_id = $this->session->userdata('client_id');
        $make_pay_amt = $this->input->post('make_pay_amt');
        $plan_id = $this->input->post('make_plan_id');
        $plan_amount = $this->input->post('make_plan_amt');
        $order_type = $this->input->post('make_order_type');
        $no_of_order = $this->input->post('make_no_of_order');
        $form = "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' name='make_paypal_form' id='make_paypal_form'>"
                . "<input type='hidden' name='cmd' value='_cart'>"
                . "<input type='hidden' name='upload' value='1'>"
                . "<input type='hidden' name='business' value='sgratman@gmail.com'>"
                . "<input type='hidden' name='currency_code' value='US'>";

        $q_plan = "select * from tbl_plan where Plan_Id=$plan_id";
        $result_plan = mysql_query($q_plan);
        while ($row_plan = mysql_fetch_array($result_plan)) {
            $plan_name = $row_plan['Plan_Name'];
            $plan_price1 = $row_plan['Price'];
            $plan_price = number_format((float) $plan_price1, 2, '.', '');
        }
        $form .= "<input type='hidden' name='item_name_1' value='$plan_name - $order_type ($no_of_order orders)'>";
        $form .= "<input type='hidden' name='amount_1' value='$make_pay_amt'>";
        $form .= "<input type='hidden' name='custom' value='$plan_id'/>";
        $form .= "<input type='hidden' name='return' value='http://localhost:82/propertytax247/Cart/make_success'/>";
        $form .= "</form>";
        echo $form;
    }

    public function make_success() {
        $data = array(
            'title' => 'Payment',
            'main_content' => 'client/cart/make_success'
        );
        $this->load->view('client/common/content', $data);
    }

    public function cartsubmit() {
        session_start();
        $this->load->view('phpmailer/class_phpmailer');
        $this->load->view('client/M_pdf');
        $user_id = $this->session->userdata('client_id');
        $username = $this->session->userdata('client_username');
        $total_amount = $this->input->post('total_amount');

        if (isset($_POST['saved_card_no'])) {
            $saved_card_id = $this->input->post('saved_card_no');
            $data_card = array(
                'User_id' => $user_id,
                'Id' => $saved_card_id,
                'Status' => 1
            );
            $this->db->where($data_card);
            $q_cards = $this->db->get('tbl_cards');
            foreach ($q_cards->result() as $row_cards) {
                $Card_Holder_Name = $row_cards->Card_Holder_Name;
                $Card_Number = $row_cards->Card_Number;
                $Expired_Year = $row_cards->Expired_Year;
                $Expired_Month = $row_cards->Expired_Month;
                $card_type = $row_cards->Card_Type;
            }
            $Zip_Code = $this->input->post('saved_zipcode');
            $Cvv = $this->input->post('saved_securitycode');
        } else {
            $Card_Holder_Name = $this->input->post('Card_Holder_Name');
            $Card_Number = $this->input->post('Card_Number');
            $Expired_Year = $this->input->post('Expired_Year');
            $Expired_Month = $this->input->post('Expired_Month');
            $Zip_Code = $this->input->post('Zip_Code');
            $Cvv = $this->input->post('securitycode');
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
        }
        $data_user = array(
            'User_Id' => $user_id,
            'Status' => 1
        );
        $this->db->where($data_user);
        $q_user = $this->db->get('tbl_user');
        foreach ($q_user->result() as $row_user) {
            $email = $row_user->Email_Address;
            $phone = $row_user->Phone_Number;
        }
        $this->load->library('authorize_net');
        $auth_net = array(
            'x_card_num' => $Card_Number,
            'x_exp_date' => $Expired_Month . '/' . $Expired_Year,
            'x_card_code' => $Cvv,
            'x_amount' => $total_amount,
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
            $select_txn_insert = "INSERT INTO tbl_transaction (Transaction_Id,User_Id, Total_Amt, Paid_Amt, Mode, Date, Status) VALUES ('$transaction_id','$user_id', '$total_amount', '$total_amount', 'Transfer', '$txn_date'," . 1 . ")";
            $q_txn_insert = mysql_query($select_txn_insert);
            $txn_id = mysql_insert_id();
            if ($q_txn_insert) {

                if (isset($_POST['save_card'])) {
                    $Inserted_Date = date('Y-m-d H:i:s');
                    $select_card_insert = "INSERT INTO tbl_cards (User_Id, Card_Holder_Name, Card_Number, Expired_Year, Expired_Month, Zip_Code,Card_Type, Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$Card_Holder_Name', '$Card_Number', '$Expired_Year', '$Expired_Month', '$Zip_Code','$card_type','$user_id', '$Inserted_Date'," . 1 . ")";
                    mysql_query($select_card_insert);
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
                                $select_cart_insert = "INSERT INTO tbl_cart (User_Id, Txn_Id, Plan_Id, Plan_Name, Order_Type, St_County, No_Of_Order, Unique_no,Inserted_By, Inserted_Date, Status) VALUES ('$user_id', '$txn_id', '$plan_id_sess', '$plan_name_sess', '$order_type_sess','$county_id_no', '$no_of_order', '$Unique_no','$user_id', '$cart_date', " . 1 . ")";
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
            }
        } else {
            echo '<p>' . $this->authorize_net->getError() . '</p>';
            $this->authorize_net->debug();
        }
    }

    public function paypalcart() {
        session_start();
        $user_id = $this->session->userdata('client_id');
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
                    $form .= "<input type='hidden' name='return' value='http://localhost:82/propertytax247/Cart/success'/>";
                    $total_amount = $plan_price + $total_amount;
                }
                $k++;
            }
        }
        $form .= "</form>";
        echo $form;
    }

    public function success() {
        $data = array(
            'title' => 'Payment',
            'main_content' => 'client/cart/success'
        );
        $this->load->view('client/common/content', $data);
    }

    public function change_plan() {
        $type = $this->input->post('type');
        $get_data = array(
            'Type' => $type,
            'Status' => 1
        );
        $this->db->where($get_data);
        $q_plan = $this->db->get('tbl_plan');
        $count_plan = $q_plan->num_rows();
        if ($count_plan > 0) {
            ?>
            <option value="">Select Plan</option>
            <?php
            foreach ($q_plan->result() as $row_plan) {
                ?>
                <option value="<?php echo $row_plan->Plan_Id; ?>"><?php echo $row_plan->Plan_Name; ?></option>
                <?php
            }
        } else {
            ?>
            <option value="">Select Plan</option>
            <?php
        }
    }

    public function change_state_single() {
        $plan_id = $this->input->post('plan_id');
        $data = array(
            'plan_id' => $plan_id
        );
        $this->load->view('client/cart/change_state_single', $data);
    }

    public function change_state_bulk() {
        $plan_id = $this->input->post('plan_id');
        $data = array(
            'plan_id' => $plan_id
        );
        $this->load->view('client/cart/change_state_bulk', $data);
    }

    public function change_county_single() {
        $state_id = $this->input->post('state_id');
        $data = array(
            'state_id' => $state_id
        );
        $this->load->view('client/cart/change_county_single', $data);
    }

    public function change_county_bulk() {
        $state_id = $this->input->post('plan_id');
        $data = array(
            'state_id' => $state_id
        );
        $this->load->view('client/cart/change_county_bulk', $data);
    }

    public function change_price() {
        $plan_id = $this->input->post('plan_id');
        $data = array(
            'plan_id' => $plan_id
        );
        $this->load->view('client/cart/change_price', $data);
    }

    public function addcart() {
        session_start();
        if (isset($_POST['order_type'])) {
            $code = rand();
            $itemArray = array($code => array('order_type' => $_POST['order_type'], 'plan_name' => $_POST['plan_name'], 'state' => $_POST['state'], 'county' => $_POST['county'], 'no_of_order' => $_POST['no_of_order'], 'countyorder' => $_POST['countyorder'], 'price' => $_POST['price'], 'code' => $code));
            if (!empty($_SESSION["cart_item"])) {
                if (in_array($code, $_SESSION["cart_item"])) {
                    foreach ($_SESSION["cart_item"] as $k => $v) {
                        if ($code == $k) {
                            $_SESSION["cart_item"][$k]["order_type"] = $_POST['order_type'];
                            $_SESSION["cart_item"][$k]["plan_name"] = $_POST['plan_name'];
                            $_SESSION["cart_item"][$k]["state"] = $_POST['state'];
                            $_SESSION["cart_item"][$k]["county"] = $_POST['county'];
                            $_SESSION["cart_item"][$k]["no_of_order"] = $_POST['no_of_order'];
                            $_SESSION["cart_item"][$k]["countyorder"] = $_POST['countyorder'];
                            $_SESSION["cart_item"][$k]["price"] = $_POST['price'];
                            $_SESSION["cart_item"][$k]["code"] = $code;
                        }
                    }
                } else {
                    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                }
            } else {
                $_SESSION["cart_item"] = $itemArray;
            }
            echo count($_SESSION['cart_item']);
        }
    }

    /* Delete Card Details Start here */

    public function delete_card() {
        $card_id = $this->input->post('card_id');
        $data = array(
            'card_id' => $card_id
        );
        $this->load->view('client/cart/delete_card', $data);
    }

    public function delete_carddetails() {
        $delete_card_id = $this->input->post('delete_card_id');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['client_id'];
        $update_data = array(
            'Status' => 0,
            'Modified_By' => $modified_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Id', $delete_card_id);
        $q = $this->db->update('tbl_cards', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Delete Card Details End here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
