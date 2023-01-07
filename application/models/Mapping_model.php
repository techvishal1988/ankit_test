<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mapping_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		$dbname = $this->session->userdata("dbname_ses");
		if(trim($dbname))
		{
			$this->db->query("Use $dbname");		
		}
		date_default_timezone_set('Asia/Calcutta');
    }	    

	public function getMapping($conditionArray = array())
	{	
		$result = $this->db->select("*");
		if(count($conditionArray) > 0){
			$result->where($conditionArray);
		}
		return $result->get("savedmappings")->result_array();
	}

	public function insertMappedDetails($mapped_arr)
	{	
		$this->db->insert("savedmappings",$mapped_arr);
	}

	public function UpdateMappedDetails($data, $conditionArr)
	{	
		$this->db->update("savedmappings",$data,$conditionArr);
	}

	
	
	     
}