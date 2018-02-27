<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Client_Login extends CI_Controller {
    public static $db;
    public function __construct() {
        parent::__construct();
        session_start();
        self::$db = & get_instance()->db;
        if ($this->authenticate->isClient()) {
            redirect('Client');
        }
    }
    public function index() {
        $this->load->view('client/login/index');
    }

    public function validate() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = base64_encode($this->input->post('password'));
            $data = array(
                'Username' => $username,
                'Password' => $password
            );
            $this->db->where($data);
            $q = $this->db->get('tbl_user');
            $count = $q->num_rows();
            if ($count == 1) {
                $row = $q->row_array();
                $sess_data = array(
                    'client_id' => $row['User_Id'],
                    'client_username' => $row['Username'],
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($sess_data);
                echo 'success';
            } else {
                echo "invalid";
            }
        }
    }

    public function signup() {
        $fullname = $this->input->post('fullname');
        $businessname = $this->input->post('businessname');
        $username = $this->input->post('username');
        $password1 = $this->input->post('password');
        $password = base64_encode($password1);
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $tc = $this->input->post('tc');

        $data = array(
            'Username' => $username,
            'Status' => 1
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_user');
        $count = $q->num_rows();
        if ($count < 1) {
            $insert_data = array(
                'First_Name' => $fullname,
                'Business_Name' => $businessname,
                'Username' => $username,
                'Password' => $password,
                'Email_Address' => $email,
                'Phone_Number' => $phone,
                'TC' => $tc,
                'Joined_Date' => date('Y-m-d'),
                'Status' => 1
            );
			// New Account Creation Mail
            $q = $this->db->insert('tbl_user', $insert_data);
            if ($q) {
                $msg = "Hello $username, <br><br> <p>Your account has been created successfully, below is your login credentials:</p><br><br>Login URL : http://localhost:82/propertytax247/Client_Login <br>Username : $username <br> Password : $password1 <br><br>";
				$msg .="You can also log in to web portal <a href='<a href='https//www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br><br><br><br><br>";
                $msg .="Thank you,<br>";
                $msg .="Best Regards,<br>";                
                $msg .="Propertyreport247.com,<br>";
                $msg .="2423 S Alder ST,<br>";
                $msg .="Philadelphia, PA 19148<br>";
                $msg .="<img src=" . site_url('assets/admin/layout4/img/logo-light1.png') . "> <br>";
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
                $mail->Subject = "PropertyReport247.com || New Account Creation";
                $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
                $mail->addAddress($email);
                $mail->addBCC('neworders@propertyreport247.com');
                $mail->SMTPDebug = 1;
                $mail->send();
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "exists";
        }
    }

    public function forget_pwd() {
        $email = $this->input->post('email');
        $get_data = array(
            'Email_Address' => $email,
            'Status' => 1
        );
        $this->db->where($get_data);
        $q_user = $this->db->get('tbl_user');
        $count = $q_user->num_rows();
        if ($count == 1) {
            foreach ($q_user->result() as $row_user) {
                $user_id = $row_user->User_Id;
                $username = $row_user->Username;
            }
            $active_code = md5(uniqid(rand(5, 15), true));
            $link = site_url('Client_Login/Reset/' . $user_id . '/' . $active_code);
            $msg = "Hello $username, <br><br><p style='text-indent:25px'>As per your request, we have sent you the password reset url. Click the url to reset your password:</p><br> $link <br><br>"; // HTML message
			$msg .="You can also log in to web portal <a href='https://www.propertyreport247.com'>Propertyreport247.com</a> to assign new orders and retrieve your completed order. Please visit us at <a href='https://www.propertyreport247.com'>www.propertyreport247.com</a> regularly to know more about your production partner. Thank you for your business.<br><br><br><br>";
            $msg .="Thank you,<br>";
            $msg .="Best Regards,<br>";           
            $msg .="PropertyReport247.com,<br>";
            $msg .="2423 S Alder ST,<br>";
            $msg .="Philadelphia, PA 19148<br>";
            $msg .="<img src=" . base_url('assets/admin/layout4/img/logo-light1.png') . ">";
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
            $mail->Subject = "Propertyreport247.com || Password Recovery Link";
            $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
            $mail->addAddress($email);
            $mail->addBCC('neworders@propertyreport247.com');
            $mail->SMTPDebug = 1;
            if ($mail->send()) {
                $update_data = array(
                    'Active_Code' => $active_code
                );
                $this->db->where('User_Id', $user_id);
                $this->db->update('tbl_user', $update_data);
                echo "success";
            }
        } else {
            echo "invalid";
        }
    }

    public function reset() {
        if ($this->uri->segment(3) != "" && $this->uri->segment(4) != "") {
            $this->load->view('client/login/reset');
        } else {
            redirect('Client_Login');
        }
    }

    public function reset_pwd() {
        $password = base64_encode($this->input->post('password'));
        $user_id = $this->input->post('user_id');
        $active_code = $this->input->post('active_code');
        $get_data = array(
            'User_Id' => $user_id,
            'Active_Code' => $active_code
        );
        $this->db->where($get_data);
        $q_user = $this->db->get('tbl_user');
        $count_user = $q_user->num_rows();
        if ($count_user == 1) {
            $update_data = array(
                'Password' => $password,
                'Active_Code' => ""
            );
            $this->db->where('User_Id', $user_id);
            $q = $this->db->update('tbl_user', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }
}
