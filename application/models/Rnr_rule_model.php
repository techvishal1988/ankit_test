<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Rnr_rule_model extends CI_Model
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
	
	public function get_all_emp_ids_for_a_rnr_cycle($condition_arr)
	{	
		$this->db->select("rnr_rule_users_dtls.user_id");
		$this->db->from("rnr_rules");
		$this->db->join("rnr_rule_users_dtls","rnr_rule_users_dtls.rule_id = rnr_rules.id");
		return $this->db->where($condition_arr)->get()->result_array();
	}

    public function get_rule_dtls_for_performance_cycles($condition_arr)
	{	
		$this->db->select("rnr_rules.*,(select GROUP_CONCAT(DISTINCT rrud.user_id) from rnr_rule_users_dtls as rrud where rrud.rule_id = rnr_rules.id) as user_ids, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date");
		$this->db->from("rnr_rules");
		$this->db->join("performance_cycle","performance_cycle.id = rnr_rules.performance_cycle_id");
		return $this->db->where($condition_arr)->get()->row_array();
	}
	
	public function get_table_row($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->row_array();		
	}	

	public function insert_rules($data)
	{
		$this->db->insert("rnr_rules",$data);
		return $this->db->insert_id();
	}

	public function update_rules($condition_arr,$setData)
	{		
		$this->db->where($condition_arr);
		$this->db->update('rnr_rules', $setData);
	}
	     
}