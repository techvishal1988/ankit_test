<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_cycle_model extends CI_Model
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

	public function get_salary_rules_list($condition_arr)
	{
		$this->db->select("hr_parameter.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = hr_parameter.createdby) as created_by_name");
		$this->db->from("hr_parameter");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}   
        public function get_bonus_rules_list($condition_arr)
	{
		$this->db->select("hr_parameter_bonus.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = hr_parameter_bonus.createdby) as created_by_name");
		$this->db->from("hr_parameter_bonus");
		$this->db->join("performance_cycle", "performance_cycle.id = hr_parameter_bonus.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	} 
        public function get_lti_rules_list($condition_arr)
	{
		$this->db->select("lti_rules.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = lti_rules.createdby) as created_by_name");
		$this->db->from("lti_rules");
		$this->db->join("performance_cycle", "performance_cycle.id = lti_rules.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	} 
        public function get_rnr_rules_list($condition_arr)
	{
		$this->db->select("rnr_rules.*, performance_cycle.name, performance_cycle.start_date, performance_cycle.end_date, (select name from login_user where login_user.id = rnr_rules.createdby) as created_by_name");
		$this->db->from("rnr_rules");
		$this->db->join("performance_cycle", "performance_cycle.id = rnr_rules.performance_cycle_id");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->result_array();
	}
        public function get_performance_cycles($condition_arr)
	{
		$this->db->select("performance_cycle.*, (select count(*) from hr_parameter where hr_parameter.performance_cycle_id = performance_cycle.id) as salary_rules_count, (select count(*) from hr_parameter_bonus where hr_parameter_bonus.performance_cycle_id = performance_cycle.id) as bonus_rules_count, (select count(*) from lti_rules where lti_rules.performance_cycle_id = performance_cycle.id) as lti_rules_count, (select count(*) from rnr_rules where rnr_rules.performance_cycle_id = performance_cycle.id) as rnr_rules_count");
		$this->db->from("performance_cycle");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by("performance_cycle.id asc");
		return $this->db->get()->result_array();
	}

	
	
}