<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Priority extends CI_Controller {

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
            'title' => 'Priority',
            'main_content' => 'admin/priority/index'
        );
        $this->load->view('admin/common/content', $data);
    }

    /* Add Priority Details Start here */

    public function add_priority() {
        $add_priority_plan = $this->input->post('add_priority_plan');
        $add_priority_type = $this->input->post('add_priority_type');
        $add_priority_price1 = $this->input->post('add_priority_price');
        $add_priority_price = number_format((float) $add_priority_price1, 2, '.', '');
        $add_priority_duration = $this->input->post('add_priority_duration');
        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['admin_id'];
        $data = array(
            'Plan_Id' => $add_priority_plan,
            'Priority_Type' => $add_priority_type,
            'Status' => 1
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_priority');
        $count = $q->num_rows();
        if ($count == 0) {
            $insert_data = array(
                'Plan_Id' => $add_priority_plan,
                'Priority_Type' => $add_priority_type,
                'Priority_Price' => $add_priority_price,
                'Priority_Duration' => $add_priority_duration,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_priority', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "exists";
        }
    }

    /* Add Priority Details End here */

    /* Edit Priority Details Start here */

    public function Editpriority() {
        $priority_id = $this->input->post('priority_id');
        $data = array(
            'priority_id' => $priority_id
        );
        $this->load->view('admin/priority/edit_priority', $data);
    }

    public function edit_Priority() {
        $edit_priority_id = $this->input->post('edit_priority_id');
        $edit_priority_plan = $this->input->post('edit_priority_plan');
        $edit_priority_type = $this->input->post('edit_priority_type');
        $edit_priority_price1 = $this->input->post('edit_priority_price');
        $edit_priority_price = number_format((float) $edit_priority_price1, 2, '.', '');
        $edit_priority_duration = $this->input->post('edit_priority_duration');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['admin_id'];
        $data = array(
            'Priority_Id !=' => $edit_priority_id,
            'Plan_Id' => $edit_priority_plan,
            'Priority_Type' => $edit_priority_type,
            'Status' => 1
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_priority');
        $count = $q->num_rows();
        if ($count == 0) {
            $update_data = array(
                'Plan_Id' => $edit_priority_plan,
                'Priority_Type' => $edit_priority_type,
                'Priority_Price' => $edit_priority_price,
                'Priority_Duration' => $edit_priority_duration,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Priority_Id', $edit_priority_id);
            $q = $this->db->update('tbl_priority', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "exists";
        }
    }

    /* Edit Priority Details End here */
    /* Delete Priority Details Start here */

    public function Deletepriority() {
        $priority_id = $this->input->post('priority_id');
        $data = array(
            'priority_id' => $priority_id
        );
        $this->load->view('admin/priority/delete_priority', $data);
    }

    public function delete_priority() {
        $delete_priority_id = $this->input->post('delete_priority_id');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['admin_id'];
        $update_data = array(
            'Status' => 0,
            'Modified_By' => $modified_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Priority_Id', $delete_priority_id);
        $q = $this->db->update('tbl_priority', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Delete Priority Details End here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
