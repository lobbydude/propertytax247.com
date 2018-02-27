<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Otuser_Login extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        self::$db = & get_instance()->db;
    }
    public function index() {
        $this->load->view('otuser/login/index');
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
    
}