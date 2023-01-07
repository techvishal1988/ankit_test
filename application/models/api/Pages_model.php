<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		
    }
    public function setdb($dbname)
    {
       $this->db->query("use ".$dbname); 
    }
    
    public function getfaq()
    {
        return $this->db->get_where('faq',array('status'=>1))->result_array();
    }
   
}