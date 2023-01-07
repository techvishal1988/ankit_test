<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model
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
    
        public function grade($rpt_for)
        {
			if($rpt_for=="Target")
			{
				$rpt_for="Targetsalary";
			}
			elseif($rpt_for=="Total")
			{
				$rpt_for="Totalsalary";
			}
			else
			{
				$rpt_for="CurrentBasesalary";
			}
			//return $this->db->query("select min( compBenView3.`Salaryafterlastincrease` ) as Minimum,avg(compBenView3.`Salaryafterlastincrease`) as avg,max( compBenView3.`Salaryafterlastincrease` ) as Maximum,Grade from  compBenView3 group by Grade")->result_array();
            return $this->db->query("select min( compBenView3.$rpt_for ) as Minimum,avg(compBenView3.$rpt_for) as avg,max( compBenView3.$rpt_for ) as Maximum,Grade from  compBenView3 group by Grade")->result_array();
        }
        public function level($rpt_for)
        {
			if($rpt_for=="Target")
			{
				$rpt_for="Targetsalary";
			}
			elseif($rpt_for=="Total")
			{
				$rpt_for="Totalsalary";
			}
			else
			{
				$rpt_for="CurrentBasesalary";
			}
            //return $this->db->query("select min( compBenView3.`Salaryafterlastincrease` ) as Minimum,avg(compBenView3.`Salaryafterlastincrease`) as avg,max( compBenView3.`Salaryafterlastincrease` ) as Maximum,Level from compBenView3 group by Level")->result_array();
			return $this->db->query("select min( compBenView3.$rpt_for ) as Minimum,avg(compBenView3.$rpt_for) as avg,max( compBenView3.$rpt_for ) as Maximum,Level from compBenView3 group by Level")->result_array();
        }
        public function designation($rpt_for)
        {
			if($rpt_for=="Target")
			{
				$rpt_for="Targetsalary";
			}
			elseif($rpt_for=="Total")
			{
				$rpt_for="Totalsalary";
			}
			else
			{
				$rpt_for="CurrentBasesalary";
			}
			//return $this->db->query("select min( compBenView3.`Salaryafterlastincrease` ) as Minimum,avg(compBenView3.`Salaryafterlastincrease`) as avg,max(compBenView3.`Salaryafterlastincrease` ) as Maximum,DesignationTitle from  compBenView3 group by DesignationTitle")->result_array();
            return $this->db->query("select min( compBenView3.$rpt_for ) as Minimum,avg(compBenView3.$rpt_for) as avg,max(compBenView3.$rpt_for ) as Maximum,DesignationTitle from  compBenView3 group by DesignationTitle")->result_array();
        }
        public function get_table($table, $fields, $condition_arr, $order_by = "id", $group_by = "") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		if($group_by)
		{
			$this->db->group_by($group_by);
		}
		return $this->db->get()->result_array();		
	}
        
        public  function get_salary_increase_rpt_data_function()
        {
            return $this->db->query("SELECT `func`.`id`, `func`.`name`, min(empsal.manager_discretions) as 'Minimum_hike', avg(empsal.manager_discretions) as 'Average_hike',max(empsal.manager_discretions) as 'Maximum_hike' FROM `employee_salary_details` `empsal`, `manage_function` `func`, `login_user` `lusr` WHERE `lusr`.`id` = `empsal`.`user_id` and `lusr`.`function_id` = `func`.`id` group by `func`.`id`, `func`.`name` ORDER BY `lusr`.`id` asc")->result_array();
        }
        
        public function GetRule()
        {
            return $this->db->query('select id,salary_rule_name from hr_parameter where status >= 6 and status !=8')->result_array();
        }
        
        function paymix()
        {
            return $this->db->query("select emp.function, emp.grade, emp.PerformanceRatingforthisfiscalyear,
                                        avg(emp.currentbasesalary) as 'Salary',
                                        avg(emp.currenttargetbonus) as 'Variable',
                                        avg(Allowance1 + Allowance2 + Allowance3 + Allowance4 + Allowance5 + Allowance6 + Allowance7 + Allowance8 + Allowance9 + Allowance10) as 'Allowance'
                                        from compBenView3 emp
                                        group by emp.function, emp.grade, emp.PerformanceRatingforthisfiscalyear
                                        order by emp.function,  emp.grade, emp.PerformanceRatingforthisfiscalyear")->result_array();
        }
        
        function getAllCycle()
        {
            $array=array(
                "type"=>1,
                "status"=>1
            );
            //$this->db->where($array);
            return $this->db->get_where("performance_cycle",$array)->result_array();
        }
        
        function getAllRulesOfCycle($cycleID)
        {
            $array=array(
                          "performance_cycle_id"=>$cycleID
                         );
            //$this->db->where($array);
            return $this->db->get_where("hr_parameter",$array)->result_array();
        }
	
	function bonus_review($arr = "")
	{
		$query='select '
				. 'employee_bonus_details.company_name,'. 'employee_bonus_details.emp_name as Employee_Name,'. 'employee_bonus_details.email_id,'
				. 'employee_bonus_details.country,'. 'employee_bonus_details.city,'. 'employee_bonus_details.business_level_1,'
				. 'employee_bonus_details.business_level_2,'. 'employee_bonus_details.business_level_3,'. 'employee_bonus_details.function,'
				. 'employee_bonus_details.sub_function,'. 'employee_bonus_details.designation,'. 'employee_bonus_details.grade,'
				. 'employee_bonus_details.level,'. 'employee_bonus_details.education,'. 'employee_bonus_details.special_category,'
				. 'employee_bonus_details.joining_date_the_company	as DOJ,'. 'employee_bonus_details.start_date_for_role,'. 'employee_bonus_details.end_date_the_role,'
				. 'employee_bonus_details.performnace_rating,'. 'employee_bonus_details.currency,'. 'employee_bonus_details.current_base_salary,'
				. 'employee_bonus_details.current_target_bonus,'. 'employee_bonus_details.bl_1_achievement as BU_1_Achievement,'. 'employee_bonus_details.bl_2_achievement as BU_2_Achievement,'
				. 'employee_bonus_details.bl_3_achievement as BU_3_Achievement,'. 'employee_bonus_details.function_achievement,'. 'employee_bonus_details.individual_achievement'
				. ' from  employee_bonus_details';
		if($arr)
		{
			$query .= " where ".$arr;
		}
		return $this->db->query($query)->result_array();
	}
	  
	function lti_review($arr = "")
	{
		$query='select '
				. 'employee_lti_details.company_name,'. 'employee_lti_details.emp_name as Employee_Name,'. 'employee_lti_details.email_id,'
				. 'employee_lti_details.country,'. 'employee_lti_details.city,'. 'employee_lti_details.business_level_1,'
				. 'employee_lti_details.business_level_2,'. 'employee_lti_details.business_level_3,'. 'employee_lti_details.function,'
				. 'employee_lti_details.sub_function,'. 'employee_lti_details.designation,'. 'employee_lti_details.grade,'
				. 'employee_lti_details.level,'. 'employee_lti_details.education,'. 'employee_lti_details.special_category,'
				. 'employee_lti_details.joining_date_the_company	as DOJ,'. 'employee_lti_details.start_date_for_role,'. 'employee_lti_details.end_date_the_role,'
				.  'employee_lti_details.currency,'. 'employee_lti_details.current_base_salary, employee_lti_details.final_incentive as final_incentive,'
				. 'employee_lti_details.current_target_bonus '
				. '  from  employee_lti_details employee_lti_details join lti_rules lti_rules on lti_rules.id=employee_lti_details.rule_id';
		if($arr)
		{
			$query .= " where ".$arr;
		}
		return $this->db->query($query)->result_array();
	}
		
	public function getRNRInfoForDBReport()
	{
		return $this->db->query('select rules.rule_name,(select GROUP_CONCAT(DISTINCT rrud.user_id) from rnr_rule_users_dtls as rrud where rrud.rule_id = rules.id) as user_ids, rules.award_value as Amount,prd.createdon as Recommended_on_date from rnr_rules rules left join proposed_rnr_dtls prd on prd.rule_id=rules.id where rules.status=6')->result_array();
	}
	
	public function GetRnrDetailForEmp($UID)
	{	
		//Note :: status  7 or more than 6 means rule is completed with all emp Salary/Bonus increments
	   //$this->db->select("*");
		$this->db->select("manage_company.company_name,login_user.".CV_BA_NAME_EMP_FULL_NAME." as name, login_user.".CV_BA_NAME_EMP_EMAIL." as email, login_user.status, manage_country.name as country, manage_city.name as city,  "
				. "manage_designation.name as designation, manage_function.name as function, manage_subfunction.name as subfunction,"
				. " manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3,"
				. "login_user.".CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE." as date_of_joining,"
				."");
		$this->db->from('login_user');    
		$this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY,"left");
		$this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY,"left");
		//$this->db->join("manage_bussiness_unit", "manage_bussiness_unit.id = login_user.bussiness_unit_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION,"left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.". CV_BA_NAME_SUBFUNCTION,"left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.". CV_BA_NAME_DESIGNATION,"left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.". CV_BA_NAME_GRADE,"left");
		$this->db->join("manage_level", "manage_level.id = login_user.". CV_BA_NAME_LEVEL,"left");
		$this->db->join("manage_company", "manage_company.id = login_user.company_Id","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.". CV_BA_NAME_BUSINESS_LEVEL_3,"left");
		$this->db->where("login_user.id ", $UID);
		return $this->db->get()->result_array(); //$data = $this->db->get()->result_array();
	}
        
        public function BonusRules($select="*")
        {
            return $this->db->query('select '.$select.' from hr_parameter_bonus')->result_array();
        }
        public function rnrRules($select="*")
        {
            return $this->db->query('select '.$select.' from rnr_rules')->result_array();
        }
        public function SalaryRules()
        {
            return $this->db->query('select * from hr_parameter')->result_array();
        }
		
	public function get_rule_wise_emp_list_for_increments_for_api_comp_graph($rule_id, $arr = "")
	{	
		$this->db->select("employee_salary_details.company_name,employee_salary_details.emp_name as employee_name,"
			. "employee_salary_details.email_id,employee_salary_details.country,employee_salary_details.city,"
			. "employee_salary_details.business_level_1,employee_salary_details.business_level_2,"
			. "employee_salary_details.business_level_3,employee_salary_details.function,employee_salary_details.sub_function,"
			. "employee_salary_details.designation,"
			. "employee_salary_details.grade,employee_salary_details.level,employee_salary_details.education,"
				. "employee_salary_details.	critical_talent,employee_salary_details.critical_position,"
			. "employee_salary_details.special_category,"
			. "employee_salary_details.joining_date_the_company as DOJ, employee_salary_details.joining_date_for_increment_purposes,"
			. "employee_salary_details.recently_promoted,employee_salary_details.performance_rating,employee_salary_details.Currency,"
			. "employee_salary_details.current_base_salary,employee_salary_details.current_target_bonus,"
			. "employee_salary_details.allowance_1,employee_salary_details.allowance_2,employee_salary_details.allowance_3,"
			. "employee_salary_details.allowance_4,employee_salary_details.allowance_5,employee_salary_details.allowance_6,"
			. "employee_salary_details.allowance_7,employee_salary_details.allowance_8,employee_salary_details.allowance_9,"
			. "employee_salary_details.allowance_10,employee_salary_details.total_compensation,employee_salary_details.approver_1,"
			. "employee_salary_details.approver_2,employee_salary_details.approver_3,employee_salary_details.approver_4,"
			. "employee_salary_details.manager_name,employee_salary_details.authorised_signatory_for_letter,"
			. "employee_salary_details.authorised_signatory_title_for_letter,employee_salary_details.hr_authorised_signatory_for_letter,"
			."employee_salary_details.hr_authorised_signatory_title_for_letter,"
				. "(employee_salary_details.market_salary/employee_salary_details.final_salary)*100 as cr_after_salary_increase,"
				. "(employee_salary_details.market_salary/employee_salary_details.increment_applied_on_salary)*100 as cr_before_salary_increase,"
				. "employee_salary_details.emp_citation as Reason_for_promotion,employee_salary_details.manager_discretions as promotion_increase_percentage,employee_salary_details.final_salary,"    
			. "((employee_salary_details.final_salary - employee_salary_details.increment_applied_on_salary) / employee_salary_details.increment_applied_on_salary)*100 as Salary_increase_percentage");
		$this->db->from("employee_salary_details");
		$this->db->join("hr_parameter", "hr_parameter.id = employee_salary_details.rule_id");
        $this->db->join("performance_cycle", "performance_cycle.id = hr_parameter.performance_cycle_id");
		$this->db->where(array("employee_salary_details.rule_id"=>$rule_id));
		if($arr)
		{
			$this->db->where($arr);
		}
		$data = $this->db->get()->result_array();
		return $data;
	}
	
	public function getbusiness_attributeDisplayname($table,$data)
	{
		return $this->db->get_where($table,$data)->result_array();
	}


	public function get_employee_historical_report($select_str, $condition)
	{
        $this->db->select($select_str);
        $this->db->from('login_user_history');
        //$this->db->join("login_user", "login_user_history.id = salary_rule_users_dtls.user_id");
        $this->db->join("manage_country", "manage_country.id = login_user_history." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user_history." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user_history." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user_history." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user_history." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user_history." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user_history." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user_history." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user_history." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user_history." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user_history." . CV_BA_NAME_SUB_SUBFUNCTION . "", "left");
        $this->db->join("manage_education", "manage_education.id = login_user_history." . CV_BA_NAME_EDUCATION . "", "left");
        $this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user_history." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
        $this->db->join("manage_critical_position", "manage_critical_position.id = login_user_history." . CV_BA_NAME_CRITICAL_POSITION . "", "left"); 
        $this->db->join("manage_special_category", "manage_special_category.id = login_user_history." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
        $this->db->join("manage_currency", "manage_currency.id = login_user_history." . CV_BA_NAME_CURRENCY . "", "left");
     //   $this->db->where(array("login_user_history.status" => CV_STATUS_ACTIVE));
        if ($condition) {
            $this->db->where($condition);
		} 
		$this->db->order_by('login_user_history.id ASC, pk ASC');
	
        return $this->db->get()->result_array();
	}


	/*
	* Grade wise cost summary
	*/
	public function cost_summary_by_grade($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr) {

		if(empty($rule_id)) {
			return;
		}

		$select_str = 'salary_rule_users_dtls.grade AS band,
						salary_rule_users_dtls.employee_role AS role,
						COUNT(salary_rule_users_dtls.user_id) AS headcount,
						SUM(employee_salary_details.increment_applied_on_salary) AS current_ctc,
						SUM(employee_salary_details.final_salary) AS proposed_ctc,
						(SUM(`employee_salary_details`.`final_salary`) -  SUM(`employee_salary_details`.`increment_applied_on_salary`)) As `increment`,
						((SUM(`employee_salary_details`.`final_salary`) -  SUM(`employee_salary_details`.`increment_applied_on_salary`))/ SUM(`employee_salary_details`.`increment_applied_on_salary`)) * 100 As cost_impact,
						(SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_merit_hike`)/100))/ SUM(`employee_salary_details`.`increment_applied_on_salary`) * 100) AS `merit_per`,
						SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_merit_hike`)/100)) AS `merit_amt`,
						(SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`sp_manager_discretions`)/100))/ SUM(`employee_salary_details`.`increment_applied_on_salary`) * 100) AS `promotion_per`,	
						SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`sp_manager_discretions`)/100)) AS `promotion_amt`,
						(SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_market_hike`)/100))/ SUM(`employee_salary_details`.`increment_applied_on_salary`) * 100) AS `market_adjustment_per`,
						SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_market_hike`)/100)) AS `market_adjustment_amt`';	

		$this->db->select($select_str);
        $this->db->from('salary_rule_users_dtls');
		$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id AND login_user.status = 1");
        $this->db->join("employee_salary_details", "employee_salary_details.rule_id = salary_rule_users_dtls.rule_id AND employee_salary_details.user_id = salary_rule_users_dtls.user_id");

		//$rule_ids = array(27, 28, 29, 30, 44);
		//$this->db->where_in('salary_rule_users_dtls.rule_id', $rule_ids);
		//$this->db->group_by(array('salary_rule_users_dtls.grade', 'salary_rule_users_dtls.employee_role', 'salary_rule_users_dtls.rule_id'));

		$this->db->where('salary_rule_users_dtls.rule_id', $rule_id);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		$this->db->group_by(array('salary_rule_users_dtls.grade', 'salary_rule_users_dtls.employee_role'));

        return $this->db->get()->result_array();
	}

	/*
	* Performance rating wise cost summary
	*/
	public function cost_summary_by_performance_rating($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array

		if(empty($rule_id)) {
			return;
		}

		//	salary_rule_users_dtls.employee_role AS role,
		$select_str = 'employee_salary_details.performance_rating AS band,
						COUNT(salary_rule_users_dtls.user_id) AS headcount,
						SUM(employee_salary_details.increment_applied_on_salary) AS current_ctc,
						SUM(employee_salary_details.final_salary) AS proposed_ctc,
						(SUM(`employee_salary_details`.`final_salary`) -  SUM(`employee_salary_details`.`increment_applied_on_salary`)) As `increment`,
						((SUM(`employee_salary_details`.`final_salary`) -  SUM(`employee_salary_details`.`increment_applied_on_salary`))/ SUM(`employee_salary_details`.`increment_applied_on_salary`)) * 100 As cost_impact,
						(SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_merit_hike`)/100))/ SUM(`employee_salary_details`.`increment_applied_on_salary`) * 100) AS `merit_per`,
						SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_merit_hike`)/100)) AS `merit_amt`,
						(SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`sp_manager_discretions`)/100))/ SUM(`employee_salary_details`.`increment_applied_on_salary`) * 100) AS `promotion_per`,	
						SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`sp_manager_discretions`)/100)) AS `promotion_amt`,
						(SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_market_hike`)/100))/ SUM(`employee_salary_details`.`increment_applied_on_salary`) * 100) AS `market_adjustment_per`,
						SUM(((`employee_salary_details`.`increment_applied_on_salary` * `employee_salary_details`.`final_market_hike`)/100)) AS `market_adjustment_amt`';	


		$this->db->select($select_str);
		$this->db->from('salary_rule_users_dtls');
		$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id AND login_user.status = 1");
		$this->db->join("employee_salary_details", "employee_salary_details.rule_id = salary_rule_users_dtls.rule_id AND employee_salary_details.user_id = salary_rule_users_dtls.user_id");

		//$rule_ids = array(27, 28, 29, 30, 44);
		//$this->db->where_in('salary_rule_users_dtls.rule_id', $rule_ids);
		//$this->db->group_by(array('employee_salary_details.performance_rating', 'salary_rule_users_dtls.employee_role', 'salary_rule_users_dtls.rule_id'));

		$this->db->where('salary_rule_users_dtls.rule_id', $rule_id);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		$this->db->group_by(array('employee_salary_details.performance_rating'));

		return $this->db->get()->result_array();
	}

	public function get_range_pene_and_avg_increase_summary($rule_id, $rating_arr, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array

		$select_str = '`employee_salary_details`.`id`,
		`employee_salary_details`.`user_id`,
		`login_user`.`name`,
		`salary_rule_users_dtls`.`rating_for_current_year` AS `pms_rating`,
		`employee_salary_details`.`performance_rating_id` AS `pms_rating_id`,
		`salary_rule_users_dtls`.`critical_talent` AS `talent_rating`,
		`employee_salary_details`.`increment_applied_on_salary` AS `current_ctc`,
		`employee_salary_details`.`max_salary_for_penetration` AS `max_salary_for_penetration`,
		`employee_salary_details`.`min_salary_for_penetration` AS `min_salary_for_penetration`,
		`employee_salary_details`.`manager_discretions` AS `final_increment_per`,
		`employee_salary_details`.`final_salary` AS `final_ctc`,
		(
			(
				`employee_salary_details`.`increment_applied_on_salary` - `employee_salary_details`.`min_salary_for_penetration`
			) /(
				`employee_salary_details`.`max_salary_for_penetration` - `employee_salary_details`.`min_salary_for_penetration`
			) * 100
		) AS `pre_range_penetration`,
		(
			(
				`employee_salary_details`.`final_salary` - `employee_salary_details`.`min_salary_for_penetration`
			) /(
				`employee_salary_details`.`max_salary_for_penetration` - `employee_salary_details`.`min_salary_for_penetration`
			) * 100
		) AS `post_range_penetration`';

		$this->db->select($select_str);
		$this->db->from('salary_rule_users_dtls');
		$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id AND login_user.status = 1");
		$this->db->join("employee_salary_details", "employee_salary_details.rule_id = salary_rule_users_dtls.rule_id AND employee_salary_details.user_id = salary_rule_users_dtls.user_id");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = employee_salary_details.performance_rating_id AND manage_rating_for_current_year.status = 1");

		$this->db->where('salary_rule_users_dtls.rule_id', $rule_id);

		if(!empty($rating_arr) && is_array($rating_arr)) {

			$this->db->where_in('manage_rating_for_current_year.id', $rating_arr);
		}

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();
	}


	public function get_range_pene_and_avg_increase_final_summary($rule_id, $rating_arr, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array

		$select_str = '
		`salary_rule_users_dtls`.`rating_for_current_year` AS `pms_rating`,
		`employee_salary_details`.`performance_rating_id` AS `pms_rating_id`,
		`salary_rule_users_dtls`.`critical_talent` AS `talent_rating`';

		$this->db->select($select_str);
		$this->db->from('salary_rule_users_dtls');
		$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id AND login_user.status = 1");
		$this->db->join("employee_salary_details", "employee_salary_details.rule_id = salary_rule_users_dtls.rule_id AND employee_salary_details.user_id = salary_rule_users_dtls.user_id");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = employee_salary_details.performance_rating_id AND manage_rating_for_current_year.status = 1");
		$this->db->group_by(array('salary_rule_users_dtls.rating_for_current_year', 'salary_rule_users_dtls.critical_talent')); 

		$this->db->where('salary_rule_users_dtls.rule_id', $rule_id);

		if(!empty($rating_arr) && is_array($rating_arr)) {

			$this->db->where_in('manage_rating_for_current_year.id', $rating_arr);
		}

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();
	}


	public function get_grade_and_level_summary_by_rule($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array
		if(empty($rule_id)) {
			return;
		}

		$select_str = '
		`employee_salary_details`.`grade` AS `band`,
		`manage_grade`.`id` AS `band_id`,
		`employee_salary_details`.`level` AS `current_level`,
		`manage_level`.`id` AS `level_id`,
		count(`employee_salary_details`.`grade`) AS `headcount`';

		$this->db->select($select_str);
		$this->db->from('employee_salary_details');
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id AND login_user.status = 1");
		$this->db->join("manage_grade", "manage_grade.name = employee_salary_details.grade AND manage_grade.status = 1");
		$this->db->join("manage_level", "manage_level.name = employee_salary_details.level AND manage_level.status = 1");
		$this->db->group_by(array('`employee_salary_details`.`grade`', '`employee_salary_details`.`level`'));

		$cond = array('`employee_salary_details`.`rule_id`' => $rule_id);
		$this->db->where($cond);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();

	}


	public function get_promotion_summary($rule_id, $new_promotion_field, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be array
		//function_arr should be an array

		$select_str = '
		`employee_salary_details`.`grade` AS `band`,
		`employee_salary_details`.`level` AS `current_level`,
		`employee_salary_details`.`'.$new_promotion_field . '` AS `promotion_field`,
		count(`employee_salary_details`.`'.$new_promotion_field . '`) AS `promotion_count`';

		$this->db->select($select_str);
		$this->db->from('employee_salary_details');
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id AND login_user.status = 1");
		$this->db->group_by(array('`employee_salary_details`.`grade`', '`employee_salary_details`.`level`', '`employee_salary_details`.`'.$new_promotion_field . '`'));

		$cond = array('`employee_salary_details`.`rule_id`' => $rule_id);
		$this->db->where($cond);
		$new_promotion_field_array = array('0', '');
		$this->db->where_not_in('`employee_salary_details`.`'.$new_promotion_field . '`', $new_promotion_field_array);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();

	}


	public function get_post_promotion_summary($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be array
		//function_arr should be an array

		$select_str = '
		`employee_salary_details`.`emp_new_grade` AS `new_band`,
		`employee_salary_details`.`emp_new_level` AS `new_level`,
		count(`employee_salary_details`.`emp_new_grade`) AS `new_grade_count`,
		count(`employee_salary_details`.`emp_new_level`) AS `new_level_count`';

		$this->db->select($select_str);
		$this->db->from('employee_salary_details');
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id AND login_user.status = 1");
		$this->db->group_by(array('`employee_salary_details`.`emp_new_grade`', '`employee_salary_details`.`emp_new_level`'));

		$cond = array('`employee_salary_details`.`rule_id`' => $rule_id, '`employee_salary_details`.`emp_new_grade` !=' => '', '`employee_salary_details`.`emp_new_level` !=' => '');
		$this->db->where($cond);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();

	}


	public function get_grade_summary_by_rule($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array

		$select_str = '
		`employee_salary_details`.`grade` AS `band`,
		count(`employee_salary_details`.`grade`) AS `headcount`';

		$this->db->select($select_str);
		$this->db->from('employee_salary_details');
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id AND login_user.status = 1");
		$this->db->group_by(array('`employee_salary_details`.`grade`'));

		$cond = array('`employee_salary_details`.`rule_id`' => $rule_id);
		$this->db->where($cond);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();
	}

	public function get_esop_filed_summary($rule_id, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array

		$select_str = '
		`employee_salary_details`.`grade` AS `band`,
		`employee_salary_details`.`esop` AS `esop`,
		COUNT(`employee_salary_details`.`esop`) AS `esopCount`';

		$this->db->select($select_str);
		$this->db->from('employee_salary_details');
		$this->db->join("login_user", "login_user.id = employee_salary_details.user_id AND login_user.status = 1");
		$this->db->group_by(array('`employee_salary_details`.`grade`'));

		$cond = array('`employee_salary_details`.`rule_id`' => $rule_id, '`employee_salary_details`.`esop` !=' => '');
		$this->db->where($cond);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();

	}


	/*
	* get data from salary_rule_users_dtls
	*/
	public function get_filed_summary($rule_id, $field_name, $has_emp_data_cond, $emps_data_arr, $function_arr) {
		//has_emp_data_cond should be true or false
		//emps_data_arr should be an array
		//function_arr should be an array

		$select_str = '
		`salary_rule_users_dtls`.`grade` AS `band`,
		`salary_rule_users_dtls`.`'. $field_name . '` AS `field`,
		SUM(`salary_rule_users_dtls`.`'. $field_name . '`) AS `fieldCount`';

		$this->db->select($select_str);
		$this->db->from('salary_rule_users_dtls');
		$this->db->join("login_user", "login_user.id = salary_rule_users_dtls.user_id AND login_user.status = 1");
		$this->db->join("employee_salary_details", "employee_salary_details.rule_id = salary_rule_users_dtls.rule_id AND employee_salary_details.user_id = salary_rule_users_dtls.user_id");
		$this->db->group_by(array('`employee_salary_details`.`grade`'));

		$cond = array('`employee_salary_details`.`rule_id`' => $rule_id);
		$this->db->where($cond);

		if($has_emp_data_cond && !empty($emps_data_arr)) {

			$this->db->where_in('`employee_salary_details`.`user_id`', $emps_data_arr);

		}

		if(!empty($function_arr) && is_array($function_arr)) {

			$this->db->where_in('`employee_salary_details`.`function`', $function_arr);
		}

		return $this->db->get()->result_array();

	}

}