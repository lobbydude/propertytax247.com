<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plan extends CI_Controller {

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
            'title' => 'Plans',
            'main_content' => 'admin/plan/index'
        );
        $this->load->view('admin/common/content', $data);
    }

    /* Add Plan Details Start here */

    public function add_plan() {
        $add_plan_name = $this->input->post('add_plan_name');
        $add_order_type = $this->input->post('add_order_type');
        $add_no_of_order = $this->input->post('add_no_of_order');
        $add_plan_price_amt = $this->input->post('add_plan_price');
        $add_plan_price = number_format((float) $add_plan_price_amt, 2, '.', '');
        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['admin_id'];
        $data = array(
            'Plan_Name' => $add_plan_name,
            'Type' => $add_order_type,
            'Status' => 1
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_plan');
        $count = $q->num_rows();
        if ($count == 0) {
            $insert_data = array(
                'Plan_Name' => $add_plan_name,
                'Type' => $add_order_type,
                'Price' => $add_plan_price,
                'No_Of_Order' => $add_no_of_order,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_plan', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "exists";
        }
    }

    /* Add Plan Details End here */

    /* Edit Plan Details Start here */

    public function Editplan() {
        $plan_id = $this->input->post('plan_id');
        $data = array(
            'plan_id' => $plan_id
        );
        $this->load->view('admin/plan/edit_plan', $data);
    }

    public function edit_plan() {
        $edit_plan_id = $this->input->post('edit_plan_id');
        $edit_plan_name = $this->input->post('edit_plan_name');
        $edit_order_type = $this->input->post('edit_order_type');
        $edit_no_of_order = $this->input->post('edit_no_of_order');
        $edit_plan_price_amt = $this->input->post('edit_plan_price');
        $edit_plan_price = number_format((float) $edit_plan_price_amt, 2, '.', '');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['admin_id'];
        $data = array(
            'Plan_Id !=' => $edit_plan_id,
            'Plan_Name' => $edit_plan_name,
            'Type' => $edit_order_type,
            'Status' => 1
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_plan');
        $count = $q->num_rows();
        if ($count == 0) {
            $update_data = array(
                'Plan_Name' => $edit_plan_name,
                'Type' => $edit_order_type,
                'No_Of_Order' => $edit_no_of_order,
                'Price' => $edit_plan_price,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Plan_Id', $edit_plan_id);
            $q = $this->db->update('tbl_plan', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "exists";
        }
    }

    /* Edit Plan Details End here */

    /* Delete Plan Details Start here */

    public function Deleteplan() {
        $plan_id = $this->input->post('plan_id');
        $data = array(
            'plan_id' => $plan_id
        );
        $this->load->view('admin/plan/delete_plan', $data);
    }

    public function delete_plan() {
        $delete_plan_id = $this->input->post('delete_plan_id');
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['admin_id'];
        $update_data = array(
            'Status' => 0,
            'Modified_By' => $modified_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Plan_Id', $delete_plan_id);
        $q = $this->db->update('tbl_plan', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Delete Plan Details End here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
