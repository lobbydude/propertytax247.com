<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Planwise extends CI_Controller {



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

            'main_content' => 'admin/planwise/index'

        );

        $this->load->view('admin/common/content', $data);

    }



    /* Add Plan Details Start here */



    public function add_planwise() {

        $this->form_validation->set_rules('add_planwise_plan', '', 'trim|required');

        $this->form_validation->set_rules('add_planwise_state', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $add_planwise_plan = $this->input->post('add_planwise_plan');

            $add_planwise_state = $this->input->post('add_planwise_state');

            $add_planwise_county = $this->input->post('add_planwise_county');

            $sess_data = $this->session->all_userdata();

            $inserted_id = $sess_data['admin_id'];



            $data = array(

                'Plan_Id' => $add_planwise_plan,

                'State_Id' => $add_planwise_state,

                'Status' => 1

            );

            $this->db->where($data);

            $q = $this->db->get('tbl_statewise');

            $count = $q->num_rows();

            if ($count == 0) {

                $uniq_id = uniqid();

                $insert_data1 = array(

                    'Plan_Id' => $add_planwise_plan,

                    'State_Id' => $add_planwise_state,

                    'Unique_Id' => $uniq_id,

                    'Inserted_By' => $inserted_id,

                    'Inserted_Date' => date('Y-m-d H:i:s'),

                    'Status' => 1

                );

                $this->db->insert('tbl_statewise', $insert_data1);



                $this->db->where('Unique_Id', $uniq_id);

                $q_select = $this->db->get('tbl_statewise');

                foreach ($q_select->result() as $row_select) {

                    $statewise_id = $row_select->S_Id;

                }

                for ($i = 0; $i < sizeof($add_planwise_county); $i++) {

                    $insert_data2 = array(

                        'County_Id' => $add_planwise_county[$i],

                        'Statewise_Id' => $statewise_id,

                        'Inserted_By' => $inserted_id,

                        'Inserted_Date' => date('Y-m-d H:i:s'),

                        'Status' => 1

                    );

                    $q = $this->db->insert('tbl_countywise', $insert_data2);

                }

                if ($q) {

                    echo "success";

                } else {

                    echo "fail";

                }

            } else {

                echo "exists";

            }

        }

    }



    /* Add Plan Details End here */



    /* Edit Planwise Details Start here */



    public function Editplanwise() {

        $s_id = $this->input->post('s_id');

        $data = array(

            's_id' => $s_id

        );

        $this->load->view('admin/planwise/edit_planwise', $data);

    }



    public function edit_planwise() {

        $this->form_validation->set_rules('edit_planwise_plan', '', 'trim|required');

        $this->form_validation->set_rules('edit_planwise_state', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $s_id = $this->input->post('edit_planwise_id');

            $edit_planwise_plan = $this->input->post('edit_planwise_plan');

            $edit_planwise_state = $this->input->post('edit_planwise_state');

            $edit_planwise_county = $this->input->post('edit_planwise_county');

            $sess_data = $this->session->all_userdata();

            $modified_id = $sess_data['admin_id'];



            $data = array(

                'S_Id !=' => $s_id,

                'Plan_Id' => $edit_planwise_plan,

                'State_Id' => $edit_planwise_state,

                'Status' => 1

            );

            $this->db->where($data);

            $q = $this->db->get('tbl_statewise');

            $count = $q->num_rows();

            if ($count == 0) {

                $update_data = array(

                    'Plan_Id' => $edit_planwise_plan,

                    'State_Id' => $edit_planwise_state,

                    'Modified_By' => $modified_id,

                    'Modified_Date' => date('Y-m-d H:i:s')

                );

                $this->db->where('S_Id', $s_id);

                $this->db->update('tbl_statewise', $update_data);



                $this->db->where('Statewise_Id', $s_id);

                $this->db->delete('tbl_countywise');

                for ($i = 0; $i < sizeof($edit_planwise_county); $i++) {

                    $insert_data = array(

                        'County_Id' => $edit_planwise_county[$i],

                        'Statewise_Id' => $s_id,

                        'Inserted_By' => $modified_id,

                        'Inserted_Date' => date('Y-m-d H:i:s'),

                        'Status' => 1

                    );

                    $q = $this->db->insert('tbl_countywise', $insert_data);

                }

                if ($q) {

                    echo "success";

                } else {

                    echo "fail";

                }

            } else {

                echo "exists";

            }

        }

    }



    /* Edit Planwise Details End here */



    /* Delete Planwise Start Here */



    public function Deleteplanwise() {

        $s_id = $this->input->post('s_id');

        $data = array(

            's_id' => $s_id

        );

        $this->load->view('admin/planwise/delete_planwise', $data);

    }



    public function Delete_planwise() {

        $this->form_validation->set_rules('delete_planwise_id', 'ID', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $s_id = $this->input->post('delete_planwise_id');

            $sess_data = $this->session->all_userdata();

            $modified_id = $sess_data['admin_id'];

            $update_data1 = array(

                'Status' => 0,

                'Modified_By' => $modified_id,

                'Modified_Date' => date('Y-m-d H:i:s')

            );

        }

        $this->db->where('S_Id', $s_id);

        $q_statewise = $this->db->update('tbl_statewise', $update_data1);

        $update_data2 = array(

            'Status' => 0

        );

        $this->db->where('Statewise_Id', $s_id);

        $this->db->update('tbl_countywise', $update_data2);

        if ($q_statewise) {

            echo "success";

        } else {

            echo "fail";

        }

    }



    /* Delete Planwise End Here */



    public function import_state() {

        $plan_id = $this->input->post('import_state_plan');

        $filename = $_FILES["import_state_file"]["tmp_name"];

        //date_default_timezone_set("Asia/Kolkata");
        date_default_timezone_set('US/Eastern');

        if ($_FILES["import_state_file"]["size"] > 0) {

            $file = fopen($filename, "r");

            $sess_data = $this->session->all_userdata();

            $inserted_id = $sess_data['admin_id'];

            while (($stateData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $state_abrvn = $stateData[0];

                $this->db->where('Abbreviation', $state_abrvn);

                $q_state = $this->db->get('tbl_state');

                foreach ($q_state->result() as $row_state) {

                    $state_id = $row_state->State_ID;

                }

                $insert_data1 = array(

                    'Plan_Id' => $plan_id,

                    'State_Id' => $state_id,

                    'Inserted_By' => $inserted_id,

                    'Inserted_Date' => date('Y-m-d H:i:s'),

                    'Status' => 1

                );

                $this->db->insert('tbl_statewise', $insert_data1);

            }

            echo "success";

        }

    }



    public function import_county() {

        $filename = $_FILES["import_county_file"]["tmp_name"];

        //date_default_timezone_set("Asia/Kolkata");
        date_default_timezone_set('US/Eastern');

        if ($_FILES["import_county_file"]["size"] > 0) {

            $file = fopen($filename, "r");

            $sess_data = $this->session->all_userdata();

            $inserted_id = $sess_data['admin_id'];

            while (($countyData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $state_id = $countyData[0];

                $county_name = $countyData[1];

                $this->db->where('County', $county_name);

                $q_county = $this->db->get('tbl_county');

                foreach ($q_county->result() as $row_county) {

                    $county_id = $row_county->County_ID;

                }

                $insert_data1 = array(

                    'Statewise_Id' => $state_id,

                    'County_Id' => $county_id,

                    'Inserted_By' => $inserted_id,

                    'Inserted_Date' => date('Y-m-d H:i:s'),

                    'Status' => 1

                );

                $this->db->insert('tbl_countywise', $insert_data1);

            }

            echo "success";

        }

    }



    function clear_cache() {

        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma:no-cache");

    }



}