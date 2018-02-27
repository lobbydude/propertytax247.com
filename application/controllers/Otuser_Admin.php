<?php

class Otuser_admin extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Admin_Login');
        }
    }

    public function signup() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'admin/otuser/signup'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function signup_placeorder() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'admin/otuser/signup_placeorder'
        );
        $this->load->view('admin/common/content', $data);
    }

    public function place_order() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'admin/otuser/place_order'
        );
        $this->load->view('admin/common/content', $data);
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
