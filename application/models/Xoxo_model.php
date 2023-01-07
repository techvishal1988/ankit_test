<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Xoxo_model extends CI_Model
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
    }	

    public function get_point_redemptions_list( $condition_arr, $select = '*' )
	{
		$this->db->select($select);
		$this->db->from("point_redemptions");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by('id','desc');
		return $this->db->get()->result_array();
	}
	
	public function insert_point_redem($data)
	{
		$this->db->insert("point_redemptions",$data);
		return $this->db->insert_id();
	}
	
	public function update_point_redem($data, $where_condition)
	{	
		$this->db->where($where_condition);
		$this->db->update('point_redemptions', $data);
	}

}