<?php
class otuser extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
    }

    public function index() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'otuser/index'
        );
        $this->load->view('otuser/common/content', $data);
    }
    
    public function place_order() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'otuser/place_order'
        );
        $this->load->view('otuser/common/content', $data);
    }
    
    public function payasyougo() {
        $data = array(
            'title' => 'Dashboard',
            'main_content' => 'otuser/payasyougo'
        );
        $this->load->view('otuser/common/content', $data);
    }
    
    public function fetch_county() {
        $state_id = ($_REQUEST["state_id"] <> "") ? trim($_REQUEST["state_id"]) : "";
        if ($state_id <> "") {
            $this->db->where('State_ID', $state_id);
            $this->db->order_by('County');
            $sql_county = $this->db->get('tbl_county');
            
            $count_county = $sql_county->num_rows();
            if ($count_county > 0) {
                foreach ($sql_county->result() as $row_county) {
                    ?>
                    <option value="<?php echo $row_county->County_ID; ?>"><?php echo $row_county->County; ?></option>
                    <?php
                }
            } else {
                ?>
                <option value="0">Select County</option>
                <?php
            }
        }
    }
    
    

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
