<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Client extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isClient()) {
            redirect('Client_Login');
        }
    }
    public function index() {
        $data = array(
            'title' => 'Payment',
            'main_content' => 'client/payment/index'
        );
        $this->load->view('client/common/content', $data);
    }    
   
    function do_user_payment()
{
     $this->load->library('auth_payment');	
     $card_expiration = $_POST['crMonth'].$_POST['crYear'];
	   
     $x_login  	 = "3N5s3JyJr";
     $x_tran_key  = "7cv4SDN9WcaF645m";
     $card_number = $_POST['ccn']; 
   
     $invoice_num = '';
		   
     $x_card_code = $_POST['CSV'];
	   
     $post_values['x_invoice_num'] = $invoice_num;
     $post_values['x_login'] 		 = $x_login;
     $post_values['x_tran_key'] 	 = $x_tran_key;
		   
     $post_values['x_card_code'] 	 = $x_card_code;
			   
      $post_values['x_version'] 	= "3.1";
      $post_values['x_delim_data'] = "TRUE";
      $post_values['x_delim_char'] = "|";
      $post_values['x_relay_response'] = "FALSE";
			   
      $post_values['x_type'] 	= "AUTH_CAPTURE"; //Optional
      $post_values['x_method'] = "CC";
      $post_values['x_card_num'] = $card_number;
      $post_values['x_exp_date'] = $card_expiration;
      $post_values['x_amount']   =  'Your Charges';
			   
      $post_values['x_first_name'] = $user_first_name; //Optional (From Client)
      $post_values['x_last_name'] = $user_last_name; //Optional (From Client)
      $post_values['x_address'] = $user_address1; //Optional (From Client)
      $post_values['x_state'] = $user_state; //Optional (From Client)
      $post_values['x_zip'] = $user_zip; //Optional (From Client)
			   
      //Calling Payment function
			  
     $paymentResponse = $this->auth_payment->do_payment($post_values);
 
     if($paymentResponse[0]==1 && $paymentResponse[1]==1 && $paymentResponse[2]==1)
     {
          // payment is successful. Do your action here
     }
    else
     {
          // payment failed.
          return $paymentResponse[3]; // return error
     }
}


function do_payment ($post_values)
{
        $post_url = "https://test.authorize.net/gateway/transact.dll";		  
        // This section takes the input fields and converts them to the proper format
	$post_string = "";
	foreach( $post_values as $key => $value )
	{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
	   $post_string = rtrim( $post_string, "& " );
	
	// This sample code uses the CURL library for php to establish a connection,
		// submit the post, and record the response.
		// If you receive an error, you may want to ensure that you have the curl
		// library enabled in your php configuration
		
		$request = curl_init($post_url); // initiate curl object
		
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
		$post_response = curl_exec($request); // execute curl post and store results in $post_response
		
		// additional options may be required depending upon your server configuration
		// you can find documentation on curl options at http://www.php.net/curl_setopt
		curl_close ($request); // close curl object
		
		// This line takes the response and breaks it into an array using the specified delimiting character
		$response_array = explode($post_values["x_delim_char"],$post_response);
		
		// The results are output to the screen in the form of an html numbered list.
		if($response_array)
		{
		return $response_array;
		}
	  else { return ''; }
	}

   
    
    
    


}
