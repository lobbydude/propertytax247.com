<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Login extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        self::$db = & get_instance()->db;
    }

    public function index() {
        $this->load->view('admin/login/index');
    }

    public function validate() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = base64_encode($this->input->post('password'));
            $data = array(
                'Admin_Username' => $username,
                'Admin_Password' => $password
            );
            $this->db->where($data);
            $q = $this->db->get('tbl_admin');
            $count = $q->num_rows();
            if ($count == 1) {
                $row = $q->row_array();
                $sess_data = array(
                    'admin_id' => $row['Admin_Id'],
                    'admin_username' => $row['Admin_Username'],
                    'role' => 'admin',
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
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = base64_encode($this->input->post('password'));
        $data = array(
            'Admin_Username' => $username,
            'Admin_Password' => $password
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_admin');
        $count = $q->num_rows();
        if ($count < 1) {
            $insert_data = array(
                'Admin_Email' => $email,
                'Admin_Username' => $username,
                'Admin_Password' => $password,
                'Status' => 1
            );
            $q = $this->db->insert('tbl_admin', $insert_data);
            if ($q) {
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
            'Admin_Email' => $email,
            'Status' => 1
        );
        $this->db->where($get_data);
        $q_admin = $this->db->get('tbl_admin');
        $count = $q_admin->num_rows();
        if ($count == 1) {
            foreach ($q_admin->result() as $row_admin) {
                $admin_id = $row_admin->Admin_Id;
                $username = $row_admin->Admin_Username;
            }
            $active_code = md5(uniqid(rand(5, 15), true));
            $link = site_url('Admin_Login/Reset/' . $admin_id . '/' . $active_code);
            $msg = "Hello $username, <br><br><p style='text-indent:25px'>As per your request, we have sent you the password reset url. Click the url to reset your password:</p><br><br> $link <br><br><br><br><br><br>"; // HTML message
            $msg .="Thank you,<br>";
            $msg .="Best Regards,<br>";
            $msg .="<a href='https://www.propertyreport247.com/'>www.propertyreport247.com</a><br>";
            $msg .="Propertyreport247.com,<br>";
            $msg .="2423 S Alder ST,<br>";
            $msg .="Philadelphia, PA 19148<br>";
            $msg .="<img src=" . site_url('assets/admin/layout4/img/logo-light.png') . ">";
            $this->load->view('phpmailer/class_phpmailer');
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
            $mail->Subject = "Propertyreport247.com || Password Recovery Link";
            $mail->Body = "<font style='font-family: Helvetica;font-size:14px'>$msg</font>";
            $mail->addAddress($email);
            $mail->addBCC('neworders@propertyreport247.com');
            $mail->SMTPDebug = 1;
            if ($mail->send()) {
                $update_data = array(
                    'Active_Code' => $active_code
                );
                $this->db->where('Admin_Id', $admin_id);
                $this->db->update('tbl_admin', $update_data);
                echo "success";
            }
        } else {
            echo "invalid";
        }
    }

    public function reset() {
        if ($this->uri->segment(3) != "" && $this->uri->segment(4) != "") {
            $this->load->view('admin/login/reset');
        } else {
            redirect('admin_login');
        }
    }

    public function reset_pwd() {
        $password = base64_encode($this->input->post('password'));
        $admin_id = $this->input->post('admin_id');
        $active_code = $this->input->post('active_code');
        $get_data = array(
            'Admin_Id' => $admin_id,
            'Active_Code' => $active_code
        );
        $this->db->where($get_data);
        $q_admin = $this->db->get('tbl_admin');
        $count_admin = $q_admin->num_rows();
        if ($count_admin == 1) {
            $update_data = array(
                'Admin_Password' => $password,
                'Active_Code' => ""
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
}