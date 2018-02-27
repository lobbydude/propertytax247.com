<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Defaultctrlr extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        self::$db = & get_instance()->db;
    }

    public function index() {
       // $this->load->view('client/login/index');
       redirect('Client');;
    }

}

?>