<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authenticate {

    function isAdmin() {
        $CI = & get_instance();
        $CI->load->library('session');
        $sess_data = $CI->session->all_userdata();
        $sess_id = $CI->session->userdata('admin_id');
        if ($sess_id == NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function isClient() {
        $CI = & get_instance();
        $CI->load->library('session');
        $sess_data = $CI->session->all_userdata();
        $sess_id = $CI->session->userdata('client_id');
        if ($sess_id == NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
