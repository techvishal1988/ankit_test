<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Pages extends REST_Controller {
   
    function __construct()
        {
        // Construct the parent class
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->load->library('session', 'encrypt');			
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->model('api/pages_model');
    }
    public function faqs_get()
	{
		
                $faqs= $this->pages_model->getfaq();
                $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$faqs
                            );
                $this->set_response($rdata, REST_Controller::HTTP_OK);
		
	}
    
  
}
