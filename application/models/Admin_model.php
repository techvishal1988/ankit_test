<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $dbname = $this->session->userdata("dbname_ses");
        if (trim($dbname)) {
            $this->db->query("Use $dbname");
        }
        date_default_timezone_set('Asia/Calcutta');
    }

    public function get_staff_list($condition_arr = "", $limit = 50000, $start = 0) {
        //Note :: status  7 or more than 6 means rule is completed with all emp Salary/Bonus increments
        if ($limit == 0 and $start == 0) {
            $this->db->select("*");
        } else {
            $this->db->select("login_user.id,login_user.employee_code, login_user." . CV_BA_NAME_EMP_EMAIL . ",
                login_user." . CV_BA_NAME_EMP_FULL_NAME . ", login_user.role, login_user.status, login_user.upload_id,
                manage_country.name AS country, manage_city.name AS city,  manage_designation.name AS desig,
                manage_function.name AS function, manage_subfunction.name AS subfunction, manage_grade.name AS grade,
                manage_level.name AS level, manage_business_level_3.name AS business_unit_3,
                login_user." . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . " AS date_of_joining,
                manage_rating_for_current_year.name AS performance_rating,
                (SELECT count(*) FROM hr_parameter JOIn salary_rule_users_dtls on salary_rule_users_dtls.rule_id = hr_parameter.id WHERE hr_parameter.status <= 6 AND login_user.id = salary_rule_users_dtls.user_id) AS emp_count_in_salary_rules,
                (SELECT COUNT(*) FROM hr_parameter_bonus JOIN bonus_rule_users_dtls ON bonus_rule_users_dtls.rule_id = hr_parameter_bonus.id WHERE hr_parameter_bonus.status <= 6 AND login_user.id = bonus_rule_users_dtls.user_id) AS emp_count_in_bonus_rules,
                login_user.company_joining_date AS company_joining_date, login_user.current_base_salary AS current_base_salary, 
                login_user.current_target_bonus AS current_target_bonus, login_user.total_compensation AS total_compensation, 
                login_user.approver_1 AS approver_1, login_user.manager_name AS manager_name, 
                manage_currency.name AS currency, manage_business_level_1.name AS group,
                manage_business_level_2.name AS division");
        }
        $this->db->from('login_user');
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
		$this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");
        $this->db->where(array("role >" => 2, "login_user.status !=" => 2));


        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        if ($limit == 0 and $start == 0) {
            return $this->db->count_all_results();
        }
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function get_staff_list_by_uploaded_id($condition_arr) {
        $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.desig, login_user.status");
        $this->db->from("tuple");
        $this->db->where($condition_arr);
        $this->db->join("login_user", "login_user.id = tuple.user_id");
        return $this->db->get()->result_array();
    }

    public function insert_staff($staff_db_arr) {
        $this->db->insert("login_user", $staff_db_arr);
    }

    public function get_designation_list($orderBy = '') {

        $this->db->select("id, name, order_no, status");

        if(!empty($orderBy)) {
            $this->db->order_by($orderBy);
        }
        return $this->db->get("manage_designation")->result_array();
    }

    public function insert_designation($db_arr) {
        $this->db->insert("manage_designation", $db_arr);
    }

    public function get_country_list() {
        $this->db->select("*");
        return $this->db->from("manage_country")->get()->result_array();
    }

    public function insert_country($country_db_arr) {
        $this->db->insert("manage_country", $country_db_arr);
    }

    public function staffDetails($usrId) {
//            echo $usrId;
        return $this->db->from('tuple')->where(array('user_id' => $usrId))->order_by('tuple.id', 'desc')->get()->row_array();
    }

    public function staffattributes($condition_arr = "") {
        $this->db->select("ba_grouping");
        $this->db->from("business_attribute");
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        $this->db->group_by("ba_grouping")->order_by('ba_groups_order', 'asc');
//            $result=array();
        $result = array();
        $grarr = array();
        $group = $this->db->get()->result_array();
        foreach ($group as $row) {
            $grarr[] = $row['ba_grouping'];
        }
//            print_r($grarr);die;
        foreach ($grarr as $gr) {
            $this->db->select("*");
            if ($condition_arr) {
                $this->db->where($condition_arr);
            }
            $result[$gr] = $this->db->from('business_attribute')->where(array('ba_grouping' => $gr))->order_by('ba_attributes_order', 'asc')->get()->result_array();
            ;
        }
//            $this->db->select("*");
        return $result;
//	    return $this->db->from("business_attribute")->get()->result_array();
    }

    public function completeStafDetails($whereCondition) {
//            	$dt= $this->db->from('datum')->where($whereCondition)->join('business_attribute','business_attribute.id=datum.business_attribute_id')->order_by('datum.display_name_override','asc')->get()->result_array();	
//                    print_r($dt);
        //return $this->db->from('datum')->where($whereCondition)->join('business_attribute','business_attribute.id=datum.business_attribute_id')->order_by('datum.display_name_override','asc')->get()->result_array();
        return $this->db->from('datum')->where($whereCondition)->join('business_attribute', 'business_attribute.id=datum.business_attribute_id')->order_by('business_attribute.display_name', 'asc')->get()->result_array();
//		return $this->db->from('datum')->where($whereCondition)->order_by('datum.display_name_override','asc')->get()->result_array();	
    }

    public function get_city_list() {
        $this->db->select("manage_city.*,tier_master.name as tier_name");
        return $this->db->from("manage_city")->join('tier_master', 'tier_master.id=manage_city.tier_id', 'left')->get()->result_array();
    }

    public function get_bussiness_unit_list_NIU() {
        $this->db->select("*");
        return $this->db->from("manage_bussiness_unit")->get()->result_array();
    }

    public function get_grade_list($orderBy = '') {
        $this->db->select("id, name, order_no, status");

        if(!empty($orderBy)) {
            $this->db->order_by($orderBy);
        }

        return $this->db->from("manage_grade")->get()->result_array();
    }

    public function check_user_rights_conflicts($user_id, $user_role, $country_ids, $city_ids, $bussiness_level_1_ids, $bussiness_level_2_ids, $bussiness_level_3_ids, $fun_ids, $sub_fun_ids, $sub_subfun_ids, $designation_ids, $grade_ids, $level_ids) {
        //Check without cuurent user
        /* $qry ="Select user_id from rights_on_grades where grade_id in (1,0) and user_id in 
          (
          Select user_id from rights_on_designations where designation_id in (1,0) and user_id in
          (
          Select user_id from rights_on_sub_functions where sub_function_id in (1,0) and user_id in        (
          Select user_id from rights_on_functions where function_id in (1,0) and user_id in
          (
          Select user_id from rights_on_business_units where business_unit_id in (1,0) and user_id in
          (
          Select user_id from rights_on_city where city_id in (3,0) and user_id in
          (
          Select user_id from rights_on_country where country_id in (1,2,0) and user_id <> 36
          )
          )
          )
          )
          )
          )"; */


        $country_cnd = " and country_id in (0," . $country_ids . ")";
        if ($country_ids == "0") {
            $country_cnd = "";
        }
        $city_cnd = " and city_id in (0," . $city_ids . ")";
        if ($city_ids == "0") {
            $city_cnd = "";
        }
        $bussiness_level_1_cnd = " and business_level_1_id in (0," . $bussiness_level_1_ids . ")";
        if ($bussiness_level_1_ids == "0") {
            $bussiness_level_1_cnd = "";
        }

        $bussiness_level_2_cnd = " and business_level_2_id in (0," . $bussiness_level_2_ids . ")";
        if ($bussiness_level_2_ids == "0") {
            $bussiness_level_2_cnd = "";
        }
        $bussiness_level_3_cnd = " and business_level_3_id in (0," . $bussiness_level_3_ids . ")";
        if ($bussiness_level_3_ids == "0") {
            $bussiness_level_3_cnd = "";
        }

        $fun_cnd = " and function_id in (0," . $fun_ids . ")";
        if ($fun_ids == "0") {
            $fun_cnd = "";
        }
        $sub_fun_cnd = " and sub_function_id in (0," . $sub_fun_ids . ")";
        if ($sub_fun_ids == "0") {
            $sub_fun_cnd = "";
        }

        $sub_subfun_cnd = " and sub_subfunction_id in (0," . $sub_subfun_ids . ")";
        if ($sub_subfun_ids == "0") {
            $sub_subfun_cnd = "";
        }

        $designation_cnd = " and designation_id in (0," . $designation_ids . ")";
        if ($designation_ids == "0") {
            $designation_cnd = "";
        }
        $grade_cnd = " and grade_id in (0," . $grade_ids . ")";
        if ($grade_ids == "0") {
            $grade_cnd = "";
        }

        $level_cnd = " and level_id in (0," . $level_ids . ")";
        if ($level_ids == "0") {
            $level_cnd = "";
        }

        $user_id_cnd = "";
        if ($user_id) {
            $user_id_cnd = "id != '" . $user_id . "' and ";
        }

        //Check for over all users accept given user
        $qry = "Select id as user_id from login_user where " . $user_id_cnd . " role = " . $user_role . " and status=1 and id in 
			  (
				Select user_id from rights_on_levels where status=1 " . $level_cnd . " and user_id in 
				( 
					Select user_id from rights_on_grades where status=1 " . $grade_cnd . " and user_id in 
					( 
						Select user_id from rights_on_designations where status=1 " . $designation_cnd . " and user_id in 
					    ( 
							Select user_id from rights_on_sub_subfunctions where status=1 " . $sub_subfun_cnd . " and user_id in
							( 
					    		Select user_id from rights_on_sub_functions where status=1 " . $sub_fun_cnd . " and user_id in
								( 
									Select user_id from rights_on_functions where status=1 " . $fun_cnd . " and user_id in
									( 
					            		Select user_id from rights_on_business_level_3 where status=1 " . $bussiness_level_3_cnd . " and user_id in
										( 
					                		Select user_id from rights_on_business_level_2 where status=1 " . $bussiness_level_2_cnd . " and user_id in
											( 
						                		Select user_id from rights_on_business_level_1 where status=1 " . $bussiness_level_1_cnd . " and user_id in
												(
							                		Select user_id from rights_on_city where status=1 " . $city_cnd . " and user_id in
													(
							                    		Select user_id from rights_on_country where status=1 " . $country_cnd . "
													)
						                     	)
					                     	)
					             		)
					        		) 
								)
							)
						) 
					)
				)
			)";
        return $this->db->query($qry)->result_array();
    }

    public function insert_user_rights_temp_NIU($db_arr) {
        $this->db->insert("user_rights_temp", $db_arr);
        return $this->db->insert_id();
    }

public function get_role_wise_users_for_view_rights($role_id) {
        $this->db->select("id as user_id");
        $this->db->where("status",'1');
        $this->db->where("role",$role_id);
        $this->db->from("login_user");
        return $this->db->get()->result_array();
    }


    public function get_users_for_view_rights() {
        $this->db->select("user_id");
        $this->db->from("rights_on_country");
        //$this->db->where("status = 1 and user_id in (select id from login_user where status=1 and role > 1)");
        $this->db->where("status = 1 and user_id in (select id from login_user where status=1 and role > 2)");
        $this->db->group_by("user_id");
        return $this->db->get()->result_array();
    }

    public function insert_data_in_tbl($table, $db_arr) {
        $this->db->insert($table, $db_arr);
    }

    public function get_table_row($table, $fields, $condition_arr, $order_by = "id") {
        $this->db->select($fields);
        $this->db->from($table);
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        $this->db->order_by($order_by);
        return $this->db->get()->row_array();
    }

    public function get_table($table, $fields, $condition_arr, $order_by = "id",$joincondition1='',$joincondition2='') {
        $this->db->select($fields);
        $this->db->from($table);
        if($joincondition1)
        {

          $this->db->join($joincondition1,$joincondition2);   
        }
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        $this->db->order_by($order_by);
        return $this->db->get()->result_array();
    }

    public function update_tbl_data($table, $data, $where_condition) {
        $this->db->where($where_condition);
        $this->db->update($table, $data);
    }

    /* public function get_employees_as_per_rights($condition_arr)
      {
      $this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, login_user.hr_user_id, manage_country.name as country, manage_city.name as city, manage_business_level_1.name as business_level_1, manage_business_level_2.name as business_level_2, manage_business_level_3.name as business_level_3, manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as sub_function, manage_grade.name as grade, manage_level.name as level, (select value from tuple join datum on datum.row_num = tuple.row_num where tuple.data_upload_id = login_user.upload_id and business_attribute_id = ". CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID ." and datum.data_upload_id = login_user.upload_id and tuple.user_id = login_user.id ORDER BY tuple.id DESC LIMIT 1) as date_of_joining");
      $this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
      $this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
      $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user.business_level_1_id","left");
      $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user.business_level_2_id","left");
      $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
      $this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
      $this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
      $this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
      $this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
      $this->db->join("manage_level", "manage_level.id = login_user.level","left");
      if($condition_arr)
      {
      $this->db->where($condition_arr);
      }
      $this->db->where(array("login_user.manage_hr_only"=>0));//Taking only company Emp
      return $this->db->from("login_user")->get()->result_array();
      } */

    public function get_employees_as_per_rights($condition_arr) {
        $this->db->select("login_user.id, login_user." . CV_BA_NAME_EMP_EMAIL . ", login_user." . CV_BA_NAME_EMP_FULL_NAME . ", login_user.role, login_user.status, login_user.hr_user_id, manage_country.name as country, manage_city.name as city, manage_business_level_1.name as business_level_1, manage_business_level_2.name as business_level_2, manage_business_level_3.name as business_level_3, manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as sub_function, manage_grade.name as grade, manage_level.name as level, login_user." . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . " as date_of_joining");
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        $this->db->where(array("login_user.manage_hr_only" => 0)); //Taking only company Emp
        return $this->db->from("login_user")->get()->result_array();
    }

    public function update_employees_hr($data, $where_condition) {
        $this->db->where($where_condition);
        $this->db->update('login_user', $data);
    }

    public function get_role_permission_details($role_id) {
        $this->db->select('role_permissions.id, role_permissions.view, role_permissions.insert, role_permissions.update, role_permissions.delete, pages.name as page_name, pages.id as page_id');
        $this->db->from('pages');
        $this->db->join('role_permissions', 'role_permissions.page_id = pages.id', 'left');
        $this->db->where('role_permissions.role_id', $role_id);
        return $this->db->get()->result_array();
    }

    public function autocomplete($term) {
        $query = $this->db->query("SELECT email as value FROM login_user WHERE status != 2 AND role > 1 AND id != " . $this->session->userdata('userid_ses') . " AND email LIKE '%" . $term . "%' ");
        echo json_encode($query->result_array());
    }

    public function get_role_info($roleID) {
        return $this->db->get_where('roles', array('id' => $roleID))->result();
    }

    public function autocompleteformanager($term) {
        $query = $this->db->query("SELECT email as value FROM login_user WHERE status != 2 AND role > 1 AND id != " . $this->session->userdata('userid_ses') . " AND email LIKE '%" . $term . "%' ");
        echo json_encode($query->result_array());
    }

    public function getEmpNotInRule($user_ids) {
        if ($user_ids != '') {
            return $this->db->query('select * from login_user where id not in(' . $user_ids . ') and role > 1 and status=1')->result();
        }

        //echo $this->db->last_query(); die;
    }

    public function staff_attributes() {
        $this->db->select("*");
        $this->db->from("business_attribute");
        $this->db->order_by('display_name', 'asc');
        $group = $this->db->get()->result_array();
        return $group;
    }

    public function staff_attributes_for_export($data='') {
        $this->db->select("id, ba_name, ba_name_cw, display_name, desciption, data_type_code,
                         module_name, ba_grouping, ba_groups_order, ba_attributes_order, status, is_required, updatedon, createdon");
        $this->db->from("business_attribute");
        if(!empty($data))
            $this->db->where_not_in('module_name',$data);
        $this->db->order_by('ba_attributes_order', 'asc');
        $group = $this->db->get()->result_array();
        return $group;
    }

    public function get_staff_list_for_download($condition_arr = "", $limit = 50000, $start = 0, $count = false) {
        //Note :: status  7 or more than 6 means rule is completed with all emp Salary/Bonus increments
        /*if ($limit == 0 and $start == 0) {
            $this->db->select("*");
        } else {
            $this->db->select("login_user.id");
        }*/

        $this->db->select("login_user.id");
        $this->db->from('login_user');
      /*  $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left"); */
        $this->db->where(array("login_user.role >" => 2, "login_user.status !=" => 2));


        if ($condition_arr) {
            $this->db->where($condition_arr);
        }

        if ($count) {//for record count
            return $this->db->count_all_results();
        }

        if($limit) {//for limit
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result_array();
    }

    public function completeStafDetails_fordownload($whereCondition) {
//            	$dt= $this->db->from('datum')->where($whereCondition)->join('business_attribute','business_attribute.id=datum.business_attribute_id')->order_by('datum.display_name_override','asc')->get()->result_array();	
//                    print_r($dt);
        //return $this->db->from('datum')->where($whereCondition)->join('business_attribute','business_attribute.id=datum.business_attribute_id')->order_by('datum.display_name_override','asc')->get()->result_array();
        return $this->db->from('datum')->where($whereCondition)->join('business_attribute', 'business_attribute.id=datum.business_attribute_id')->order_by('business_attribute.id', 'asc')->get()->result_array();
//		return $this->db->from('datum')->where($whereCondition)->order_by('datum.display_name_override','asc')->get()->result_array();	
    }

    public function attributes_for_pay_range($select="*") {
        $this->db->select($select);
        $this->db->from("business_attribute");
        $this->db->where('status', 1);
        $this->db->order_by('id', 'asc');
        $group = $this->db->get()->result_array();
        return $group;
    }

    public function getSalaryTotalElement($select="*") {
        $this->db->select($select);
        return $this->db->get('manage_company')->result_array();
    }

    public function BussinessAttr($ids) {
        return $this->db->query("select * from business_attribute where id in($ids)")->result_array();

        //return $this->db->get('business_attribute')->result_array();
    }

    public function get_employee_market_salary_dtls_for_graph($uid, $upload_id) {
        /* $ba_arr = $this->get_salary_elements_list("id", array("module_name"=>CV_MARKET_SALARY_ELEMENT));
          $ba_ids = $this->array_value_recursive('id', $ba_arr);

          $this->db->select("display_name_override, value");
          $this->db->from("tuple");
          $this->db->join("datum","datum.row_num = tuple.row_num");
          $this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id, "user_id"=>$uid));
          $this->db->where_in("datum.business_attribute_id",$ba_ids);
          $this->db->order_by("datum.value","asc");
          return $this->db->get()->result_array(); */

        $this->db->select("ba_name, display_name, value");
        $this->db->from("tuple");
        $this->db->join("datum", "datum.row_num = tuple.row_num");
        $this->db->join("business_attribute", "business_attribute.id = datum.business_attribute_id");
        $this->db->where(array("datum.data_upload_id" => $upload_id, "tuple.data_upload_id" => $upload_id, "user_id" => $uid));
        //CB:Ravi on 22-02-2018
        //$this->db->where(array("business_attribute.module_name"=>CV_MARKET_SALARY_ELEMENT));
        $this->db->where(array("business_attribute.module_name" => $this->session->userdata('market_data_by_ses')));
        $this->db->order_by("datum.value", "asc");
        return $this->db->get()->result_array();
    }

    public function get_emp_dtls_for_export_ruleList($str, $usrId,$type='',$ruleId) {
        $this->db->select($str.' ,employee_salary_details.*');
        $this->db->from('employee_salary_details');
        $this->db->join("login_user", "login_user.id = employee_salary_details.user_id", "left");
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
        $this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
        $this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left");
        $this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
        $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");
        $this->db->where('employee_salary_details.rule_id',$ruleId);
            if($type=='manager')
            {
             $this->db->where_in('employee_salary_details.user_id', $usrId);
             $this->db->group_by('employee_salary_details.user_id');
            }
            else
            {
              $this->db->where_in('employee_salary_details.user_id', $usrId);

            }
           $this->db->order_by('employee_salary_details.id');
    return $this->db->get()->result_array();
       
    }


    public function get_emp_dtls_for_export($str, $usrId, $join_cond = false) {
        /* Add join_cond for remove sub query on 24-12-2019, if remove sub query then req left join */

        if (empty($str) || empty($usrId)) {
            //if select field not found or userid empty then return
            return;
        }

        $this->db->select($str);
        $this->db->from('login_user');
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
        $this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
        $this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left");
        $this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
		$this->db->join("manage_cost_center", "manage_cost_center.id = login_user.".CV_BA_NAME_COST_CENTER, "left");
		$this->db->join("manage_employee_type", "manage_employee_type.id = login_user.".CV_BA_NAME_EMPLOYEE_TYPE, "left");
		$this->db->join("manage_employee_role", "manage_employee_role.id = login_user.".CV_BA_NAME_EMPLOYEE_ROLE, "left");
        $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");

        if ($join_cond) {
            $this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");
        }

        $this->db->where_in('login_user.id', $usrId);

        return $this->db->get()->result_array();
    }

    //** make function get tenure list by rajesh narvariya 04-01-2019 //
    public function get_tenure_list() {
        $this->db->select("*");
        return $this->db->from("tenure_classification")->get()->result_array();
    }

    public function get_subfunction_list($id) {
        $this->db->select('manage_subfunction.name,manage_subfunction.id');
        $this->db->distinct('manage_subfunction.id');
        $this->db->distinct('manage_subfunction.name');
        $this->db->from("login_user");
        $this->db->where(array("login_user." . CV_BA_NAME_FUNCTION => $id));
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "");
        $this->db->order_by("manage_subfunction.name", "asc");
        return $this->db->get()->result_array();
    }

    public function get_count_subfunction_list($id) {
        $this->db->select('count(DISTINCT(subfunction)) as totalsub');


        $this->db->from("login_user");
        $this->db->where(array("login_user." . CV_BA_NAME_FUNCTION => $id));
        return $this->db->get()->result_array();
    }

    function get_key_cross_cell_val($grade_id, $function_id, $subfunction_id) {
        $this->db->select("*");
        $this->db->from("key_cross_cell_bonus");
        $this->db->where(array("grade_id" => $grade_id, "function_id" => $function_id, "subfunction_id" => $subfunction_id));

        return $keyrow = $this->db->get()->row_array();
    }

    function delete_table($table) {
        $this->db->empty_table($table);
    }

    //************** get emplist create by rajesh on 05-01-2019
    function get_staff_Details($str, $user_id) {


        $this->db->select($str);

        $this->db->from('login_user');
        $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
        $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
        $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
        $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
        $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
        $this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
        $this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
        $this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left");
        $this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");		
		$this->db->join("manage_cost_center", "manage_cost_center.id = login_user.".CV_BA_NAME_COST_CENTER, "left");
		$this->db->join("manage_employee_type", "manage_employee_type.id = login_user.".CV_BA_NAME_EMPLOYEE_TYPE, "left");
		$this->db->join("manage_employee_role", "manage_employee_role.id = login_user.".CV_BA_NAME_EMPLOYEE_ROLE, "left");		
        $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");
        $this->db->where(array("login_user.id" => $user_id));

        return $this->db->get()->row_array();
        // echo $this->db->last_query();
    }

    //** make function get tenure list by rajesh narvariya 07-01-2019 //
    public function get_tier_list($condition_arr) {
        $this->db->select("*");
        if ($condition_arr) {
            $this->db->where($condition_arr);
        }
        return $this->db->from("tier_master")->get()->result_array();
    }

    //********* make function for get last insert id of table ** ///////
    public function insert_manage_table($table, $db_arr) {
        $this->db->insert($table, $db_arr);
        return $this->db->insert_id();
    }

    function get_target_adjustment_val($grade_id) {
        $this->db->select("*");
        $this->db->from("target_for_adjustment");
        $this->db->where(array("grade_id" => $grade_id));

        return $targetrow = $this->db->get()->row_array();
    }

    public function insert_min_pay_capping_master($db_arr) {
        $this->db->insert("tbl_min_pay_capping_master", $db_arr);
        return $this->db->insert_id();
    }

    function get_min_pay_capping_master_row($grade_id, $tenure_id) {
        $this->db->select("*");
        $this->db->from("tbl_min_pay_capping_master");
        $this->db->where(array("grade_id" => $grade_id, "tenure_id" => $tenure_id));

        return $masterrow = $this->db->get()->row_array();
    }

    function get_min_pay_capping_dtls_row($id, $tire_id) {
        $this->db->select("*");
        $this->db->from("tbl_min_pay_capping_dtls");
        $this->db->where(array("min_pay_capping_master_id" => $id, "tier_id" => $tire_id));

        return $dtlsrow = $this->db->get()->row_array();
    }

    public function delete_min_pay_capping($table, $conditionarr) {

        $this->db->where($conditionarr);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function get_ba_list_to_upload_mkt_data($select_fields, $condition_arr) {
        $this->db->select($select_fields);
        $this->db->from("business_attribute");
		if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
		{
            $this->db->order_by("FIELD(business_attribute.id, ".CV_BA_ID_COUNTRY.", ".CV_BA_ID_CITY.", ".CV_BUSINESS_LEVEL_ID_1.", ".CV_BUSINESS_LEVEL_ID_2.", ".CV_BUSINESS_LEVEL_ID_3.", ".CV_FUNCTION_ID.", ".CV_SUB_FUNCTION_ID.", ".CV_SUB_SUB_FUNCTION_ID.", ".CV_GRADE_ID.",".CV_LEVEL_ID.", ".CV_DESIGNATION_ID.", ".CV_EDUCATION_ID.", 154, 50, 51, 52, 75, 77, 76, 78, 80, 79, 81, 83, 82, 84, 86, 85, 87, 89, 88, 90, 92, 91, 93, 95, 94, 96, 98, 97, 99, 101, 100, 102, 104, 103, 105, 107, 106, 108, 110, 109)");
        }
		else
		{
			$this->db->order_by("FIELD(business_attribute.id, ".CV_BA_ID_COUNTRY.", ".CV_BA_ID_CITY.", ".CV_BUSINESS_LEVEL_ID_1.", ".CV_BUSINESS_LEVEL_ID_2.", ".CV_BUSINESS_LEVEL_ID_3.", ".CV_FUNCTION_ID.", ".CV_SUB_FUNCTION_ID.", ".CV_SUB_SUB_FUNCTION_ID.", ".CV_GRADE_ID.",".CV_LEVEL_ID.", ".CV_DESIGNATION_ID.", ".CV_EDUCATION_ID.", 154, 50, 51, 52, 55, 58, 61, 74, 113, 116, 119, 122, 125, 128, 134, 53, 56, 59, 62, 111, 114, 117, 120, 123, 126, 132, 54, 57, 60, 63, 112, 115, 118, 121, 124, 127, 133)");
		}
        return $this->db->where($condition_arr)->get()->result_array();
    }

     //piy@16Dec19 Add level and Education
    public function insert_all_market_data_in_tbl($fields, $file_path, $ba_names_to_upd, $choosed_ba_names_to_upd_mkt_data_arr) {
        $enclosed_by = '"';
        $this->db->query("TRUNCATE TABLE tbl_market_data;");
        #Insert data into temp table
        $this->db->query("LOAD DATA LOCAL INFILE '" . $file_path . "' INTO TABLE tbl_market_data FIELDS TERMINATED BY ',' ENCLOSED BY '" . $enclosed_by . "' LINES TERMINATED BY '\n' IGNORE 1 LINES (" . $fields . ")");

        $where_cnd_arr = array();
        if(in_array(CV_BA_NAME_COUNTRY, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu." . CV_BA_NAME_COUNTRY . " = tmd.country";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Country is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_country mc WHERE mc.name = tmd.country)");
        }
        if(in_array(CV_BA_NAME_CITY, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu." . CV_BA_NAME_CITY . " = tmd.city";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'City is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_city mc WHERE mc.name = tmd.city)");
        }
        if(in_array(CV_BA_NAME_BUSINESS_LEVEL_1, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_BUSINESS_LEVEL_1." = tmd.business_level_1";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Business level 1 is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_business_level_1 mbl1 WHERE mbl1.name = tmd.business_level_1)");
        }
        if(in_array(CV_BA_NAME_BUSINESS_LEVEL_2, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_BUSINESS_LEVEL_2." = tmd.business_level_2";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Business level 2 is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_business_level_2 mbl2 WHERE mbl2.name = tmd.business_level_2)");
        }
        if(in_array(CV_BA_NAME_BUSINESS_LEVEL_3, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_BUSINESS_LEVEL_3." = tmd.business_level_3";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Business level 3 is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_business_level_3 mbl3 WHERE mbl3.name = tmd.business_level_3)");
        }
        if(in_array(CV_BA_NAME_FUNCTION, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_FUNCTION." = tmd.function";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Function is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_function mf WHERE mf.name = tmd.function)");
        }
        if(in_array(CV_BA_NAME_SUBFUNCTION, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_SUBFUNCTION." = tmd.subfunction";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Sub Function is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_subfunction msf WHERE msf.name = tmd.subfunction)");
        }
        if(in_array(CV_BA_NAME_SUB_SUBFUNCTION, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_SUB_SUBFUNCTION." = tmd.sub_subfunction";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Sub Sub Function is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_sub_subfunction mssf WHERE mssf.name = tmd.sub_subfunction)");
        }
        if(in_array(CV_BA_NAME_GRADE, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_GRADE." = tmd.grade";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Grade is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_grade mg WHERE mg.name = tmd.grade)");
        }
        if(in_array(CV_BA_NAME_LEVEL, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_LEVEL." = tmd.level";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Level is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_level md WHERE md.name = tmd.level)");
        }        
        if(in_array(CV_BA_NAME_DESIGNATION, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_DESIGNATION." = tmd.designation";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Designation is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_designation md WHERE md.name = tmd.designation)");
        }
        if(in_array(CV_BA_NAME_EDUCATION, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_EDUCATION." = tmd.education";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Education is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_education md WHERE md.name = tmd.education)");
        }        


        if(in_array(CV_BA_NAME_JOB_CODE, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_JOB_CODE." = tmd.job_code";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Job code can not be blank.' WHERE tmd.is_error = 0 AND  tmd.job_code = ''");
        }
        if(in_array(CV_BA_NAME_JOB_NAME, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_JOB_NAME." = tmd.job_name";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Job name can not be blank.' WHERE tmd.is_error = 0 AND  tmd.job_name = ''");
        }
        if(in_array(CV_BA_NAME_JOB_LEVEL, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_JOB_LEVEL." = tmd.job_level";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Job level can not be blank.' WHERE tmd.is_error = 0 AND  tmd.job_level = ''");
        }
        if(in_array(CV_BA_NAME_URBAN_RURAL_CLASSIFICATION, $choosed_ba_names_to_upd_mkt_data_arr))
        {
            $where_cnd_arr[] = "lu.".CV_BA_NAME_URBAN_RURAL_CLASSIFICATION." = tmd.urban_rural_classification";
            $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Rural/Urban classification can not be blank.' WHERE tmd.is_error = 0 AND  tmd.urban_rural_classification = ''");
        }
        
  /*      
        //$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'urban/rural is not valid.' WHERE tmd.is_error = 0 AND tmd.urban_rural_classification !='' AND tmd.urban_rural_classification !='urban' AND tmd.urban_rural_classification !='rural' ");
*/
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.country = (SELECT mt.id FROM manage_country mt WHERE mt.name = tmd.country limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.city = (SELECT mt.id FROM manage_city mt WHERE mt.name = tmd.city limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.business_level_1 = (SELECT mt.id FROM manage_business_level_1 mt WHERE mt.name = tmd.business_level_1 limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.business_level_2 = (SELECT mt.id FROM manage_business_level_2 mt WHERE mt.name = tmd.business_level_2 limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.business_level_3 = (SELECT mt.id FROM manage_business_level_3 mt WHERE mt.name = tmd.business_level_3 limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.function = (SELECT mt.id FROM manage_function mt WHERE mt.name = tmd.function limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.subfunction = (SELECT mt.id FROM manage_subfunction mt WHERE mt.name = tmd.subfunction limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.sub_subfunction = (SELECT mt.id FROM manage_sub_subfunction mt WHERE mt.name = tmd.sub_subfunction limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.grade = (SELECT mt.id FROM manage_grade mt WHERE mt.name = tmd.grade limit 1) WHERE tmd.is_error = 0;");
        
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.level = (SELECT mt.id FROM manage_level mt WHERE mt.name = tmd.level limit 1) WHERE tmd.is_error = 0;");        
        
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.designation = (SELECT mt.id FROM manage_designation mt WHERE mt.name = tmd.designation limit 1) WHERE tmd.is_error = 0;");
        
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.education = (SELECT mt.id FROM manage_education mt WHERE mt.name = tmd.education limit 1) WHERE tmd.is_error = 0;");

        $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Combination not matched.' WHERE tmd.is_error = 0 AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE ".implode(" AND ", $where_cnd_arr).")");
        
        $update_qry_col_arr = array();
        //$ba_name_arr = explode(",", $fields);
        foreach($ba_names_to_upd as $ba_name)
        {
            $update_qry_col_arr[] = "lu.".$ba_name." = tmd.".$ba_name;
        }
        $this->db->query("UPDATE login_user lu,tbl_market_data tmd SET ".implode(", ", $update_qry_col_arr). " WHERE tmd.is_error = 0 AND ".implode(" AND ", $where_cnd_arr));
    //    d($this->db->last_query());
        $afftectedRows = $this->db->affected_rows();
        return $afftectedRows;
    }

    public function insert_all_market_data_in_tbl_NIU($fields, $file_path, $ba_names_to_upd, $choosed_ba_names_to_upd_mkt_data_arr) {
        $enclosed_by = '"';
        $this->db->query("TRUNCATE TABLE tbl_market_data;");
        //Insert data into temp table
        $this->db->query("LOAD DATA LOCAL INFILE '" . $file_path . "' INTO TABLE tbl_market_data FIELDS TERMINATED BY ',' ENCLOSED BY '" . $enclosed_by . "' LINES TERMINATED BY '\n' IGNORE 1 LINES (" . $fields . ")");

		$where_cnd_arr = array();
		if(in_array(CV_BA_NAME_COUNTRY, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu." . CV_BA_NAME_COUNTRY . " = tmd.country";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Country is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_country mc WHERE mc.name = tmd.country)");
		}
		if(in_array(CV_BA_NAME_CITY, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu." . CV_BA_NAME_CITY . " = tmd.city";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'City is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_city mc WHERE mc.name = tmd.city)");
		}
		if(in_array(CV_BA_NAME_BUSINESS_LEVEL_1, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_BUSINESS_LEVEL_1." = tmd.business_level_1";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Business level 1 is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_business_level_1 mbl1 WHERE mbl1.name = tmd.business_level_1)");
		}
		if(in_array(CV_BA_NAME_BUSINESS_LEVEL_2, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_BUSINESS_LEVEL_2." = tmd.business_level_2";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Business level 2 is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_business_level_2 mbl2 WHERE mbl2.name = tmd.business_level_2)");
		}
		if(in_array(CV_BA_NAME_BUSINESS_LEVEL_3, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_BUSINESS_LEVEL_3." = tmd.business_level_3";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Business level 3 is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_business_level_3 mbl3 WHERE mbl3.name = tmd.business_level_3)");
		}
		if(in_array(CV_BA_NAME_FUNCTION, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_FUNCTION." = tmd.function";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Function is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_function mf WHERE mf.name = tmd.function)");
		}
		if(in_array(CV_BA_NAME_SUBFUNCTION, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_SUBFUNCTION." = tmd.subfunction";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Sub Function is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_subfunction msf WHERE msf.name = tmd.subfunction)");
		}
		if(in_array(CV_BA_NAME_SUB_SUBFUNCTION, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_SUB_SUBFUNCTION." = tmd.sub_subfunction";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Sub Sub Function is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_sub_subfunction mssf WHERE mssf.name = tmd.sub_subfunction)");
		}
		if(in_array(CV_BA_NAME_GRADE, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_GRADE." = tmd.grade";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Grade is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_grade mg WHERE mg.name = tmd.grade)");
		}
		if(in_array(CV_BA_NAME_DESIGNATION, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_DESIGNATION." = tmd.designation";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Designation is not valid.' WHERE tmd.is_error = 0 AND  NOT EXISTS (SELECT 1 FROM manage_designation md WHERE md.name = tmd.designation)");
		}
		if(in_array(CV_BA_NAME_JOB_CODE, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_JOB_CODE." = tmd.job_code";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Job code can not be blank.' WHERE tmd.is_error = 0 AND  tmd.job_code = ''");
		}
		if(in_array(CV_BA_NAME_JOB_NAME, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_JOB_NAME." = tmd.job_name";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Job name can not be blank.' WHERE tmd.is_error = 0 AND  tmd.job_name = ''");
		}
		if(in_array(CV_BA_NAME_JOB_LEVEL, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_JOB_LEVEL." = tmd.job_level";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Job level can not be blank.' WHERE tmd.is_error = 0 AND  tmd.job_level = ''");
		}
		if(in_array(CV_BA_NAME_URBAN_RURAL_CLASSIFICATION, $choosed_ba_names_to_upd_mkt_data_arr))
		{
			$where_cnd_arr[] = "lu.".CV_BA_NAME_URBAN_RURAL_CLASSIFICATION." = tmd.urban_rural_classification";
			$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Rural/Urban classification can not be blank.' WHERE tmd.is_error = 0 AND  tmd.urban_rural_classification = ''");
		}
		
        
        //$this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'urban/rural is not valid.' WHERE tmd.is_error = 0 AND tmd.urban_rural_classification !='' AND tmd.urban_rural_classification !='urban' AND tmd.urban_rural_classification !='rural' ");

		$this->db->query("UPDATE tbl_market_data tmd SET tmd.country = (SELECT mt.id FROM manage_country mt WHERE mt.name = tmd.country limit 1) WHERE tmd.is_error = 0;");
		$this->db->query("UPDATE tbl_market_data tmd SET tmd.city = (SELECT mt.id FROM manage_city mt WHERE mt.name = tmd.city limit 1) WHERE tmd.is_error = 0;");
		$this->db->query("UPDATE tbl_market_data tmd SET tmd.business_level_1 = (SELECT mt.id FROM manage_business_level_1 mt WHERE mt.name = tmd.business_level_1 limit 1) WHERE tmd.is_error = 0;");
		$this->db->query("UPDATE tbl_market_data tmd SET tmd.business_level_2 = (SELECT mt.id FROM manage_business_level_2 mt WHERE mt.name = tmd.business_level_2 limit 1) WHERE tmd.is_error = 0;");
		$this->db->query("UPDATE tbl_market_data tmd SET tmd.business_level_3 = (SELECT mt.id FROM manage_business_level_3 mt WHERE mt.name = tmd.business_level_3 limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.function = (SELECT mt.id FROM manage_function mt WHERE mt.name = tmd.function limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.subfunction = (SELECT mt.id FROM manage_subfunction mt WHERE mt.name = tmd.subfunction limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.sub_subfunction = (SELECT mt.id FROM manage_sub_subfunction mt WHERE mt.name = tmd.sub_subfunction limit 1) WHERE tmd.is_error = 0;");
        $this->db->query("UPDATE tbl_market_data tmd SET tmd.grade = (SELECT mt.id FROM manage_grade mt WHERE mt.name = tmd.grade limit 1) WHERE tmd.is_error = 0;");
		$this->db->query("UPDATE tbl_market_data tmd SET tmd.designation = (SELECT mt.id FROM manage_designation mt WHERE mt.name = tmd.designation limit 1) WHERE tmd.is_error = 0;");

        $this->db->query("UPDATE tbl_market_data tmd SET tmd.is_error= 1, tmd.error_msg = 'Combination not matched.' WHERE tmd.is_error = 0 AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE ".implode(" AND ", $where_cnd_arr).")");
		
		$update_qry_col_arr = array();
		//$ba_name_arr = explode(",", $fields);
		foreach($ba_names_to_upd as $ba_name)
		{
			$update_qry_col_arr[] = "lu.".$ba_name." = tmd.".$ba_name;
		}
		$this->db->query("UPDATE login_user lu,tbl_market_data tmd SET ".implode(", ", $update_qry_col_arr). " WHERE tmd.is_error = 0 AND ".implode(" AND ", $where_cnd_arr));
		
        $afftectedRows = $this->db->affected_rows();
        return $afftectedRows;
    }

    //piy@16Dec19 Add level and Education

    function get_market_data_Details()
    {
        $this->db->select("tbl_market_data.*, manage_country.name AS country, manage_city.name AS city, manage_business_level_1.name AS business_level_1, manage_business_level_2.name AS business_level_2, manage_business_level_3.name AS business_level_3, manage_function.name AS function, manage_subfunction.name AS subfunction, manage_sub_subfunction.name AS sub_subfunction, manage_grade.name AS grade,manage_level.name AS level, manage_designation.name AS designation,manage_education.name AS education");
        $this->db->from('tbl_market_data');
        $this->db->join("manage_country", "manage_country.id = tbl_market_data.country", "left");
        $this->db->join("manage_city", "manage_city.id = tbl_market_data.city", "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = tbl_market_data.business_level_1", "left");
        $this->db->join("manage_business_level_2", "manage_business_level_2.id = tbl_market_data.business_level_2", "left");
        $this->db->join("manage_business_level_3", "manage_business_level_3.id = tbl_market_data.business_level_3", "left");
        $this->db->join("manage_function", "manage_function.id = tbl_market_data.function", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = tbl_market_data.subfunction", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = tbl_market_data.sub_subfunction", "left");
        $this->db->join("manage_grade", "manage_grade.id = tbl_market_data.grade", "left");

        $this->db->join("manage_level", "manage_level.id = tbl_market_data.level", "left");
        $this->db->join("manage_designation", "manage_designation.id = tbl_market_data.designation", "left");
        $this->db->join("manage_education", "manage_education.id = tbl_market_data.education", "left");
        $this->db->where(array("tbl_market_data.is_error" => 0));
        return $this->db->get()->result_array();
    }
    
    function get_market_data_Details_NIU()
	{
        $this->db->select("tbl_market_data.*, manage_country.name AS country, manage_city.name AS city, manage_business_level_1.name AS business_level_1, manage_business_level_2.name AS business_level_2, manage_business_level_3.name AS business_level_3, manage_function.name AS function, manage_subfunction.name AS subfunction, manage_sub_subfunction.name AS sub_subfunction, manage_grade.name AS grade, manage_designation.name AS designation");
        $this->db->from('tbl_market_data');
		$this->db->join("manage_country", "manage_country.id = tbl_market_data.country", "left");
		$this->db->join("manage_city", "manage_city.id = tbl_market_data.city", "left");
		$this->db->join("manage_business_level_1", "manage_business_level_1.id = tbl_market_data.business_level_1", "left");
		$this->db->join("manage_business_level_2", "manage_business_level_2.id = tbl_market_data.business_level_2", "left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = tbl_market_data.business_level_3", "left");
        $this->db->join("manage_function", "manage_function.id = tbl_market_data.function", "left");
        $this->db->join("manage_subfunction", "manage_subfunction.id = tbl_market_data.subfunction", "left");
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = tbl_market_data.sub_subfunction", "left");
        $this->db->join("manage_grade", "manage_grade.id = tbl_market_data.grade", "left");
		$this->db->join("manage_designation", "manage_designation.id = tbl_market_data.designation", "left");
        $this->db->where(array("tbl_market_data.is_error" => 0));
        return $this->db->get()->result_array();
    }
	
	public function update_ba_display_name_on_market_data_upload($ba_name_list, $fields_val)
	{
        $ex_fields_val = explode(",", $fields_val);
        $fields_arr = array();          
		$i=0;
		foreach($ba_name_list as $ba_name)
		{
			$fields_arr[] = array(
				'ba_name' => $ba_name,
				'display_name' => $ex_fields_val[$i]
			);
			$i++;
		}     
        $this->db->update_batch('business_attribute', $fields_arr, 'ba_name');
        return true;
    }
function get_final_salary_sturcture_row($allowance_id,$flaxi_plan_id='') {
        $this->db->select("*");
        $this->db->from("final_salary_structure");
        if($flaxi_plan_id!='')
        {
            $this->db->where(array("allowance_id" => $allowance_id,"flaxi_plan_id" => $flaxi_plan_id));
        }else
        {
           $this->db->where(array("allowance_id" => $allowance_id));  
        }
       
        $this->db->limit(1);

        return $masterrow = $this->db->get()->row_array();
    }

     function get_final_salary_sturcture_grade_wise_row($allowance_id,$grade_id) {
        $this->db->select("*");
        $this->db->from("final_salary_structure");
        $this->db->where(array("allowance_id" => $allowance_id,"grade_id"=>$grade_id));
        $this->db->limit(1);

        return $masterrow = $this->db->get()->row_array();
    }

   public function get_final_salary_structure_grade_wise($grade_id) {
        $this->db->select("final_salary_structure.*,business_attribute.display_name,business_attribute.ba_name,business_attribute.id as business_attribute_id");
        return $this->db->from("final_salary_structure")->join('business_attribute', 'business_attribute.id=final_salary_structure.allowance_id', 'left')->where("final_salary_structure.grade_id",$grade_id)->get()->result_array();
    }

 public function get_flexi_filter($flexiid)
    {
        $this->db->select('`flexi_plan_name`, `country`, `city`, `business_level1`, `business_level2`, `business_level3`, `functions`, `sub_functions`, `sub_subfunctions`, `designations`, `grades`, `levels`, `flexi_type`, `educations`, `critical_talents`, `critical_positions`, `special_category`, `tenure_company`, `tenure_roles`, `updatedby`, `updatedon`, `createdby`, `createdon`, `launched_at`, `employees_to_complete`, `createdby_proxy`, `updatedby_proxy`');
        $this->db->where('id',$flexiid);
        return $this->db->get("flexi_plan_filter")->row_array();
        
    }
    public function get_final_salary_structure($flexiid)
    {
    $this->db->select('flaxi_plan_id,type,status,grade_id,allowance_id,
  type_of_element,fixed_salary_element,salary_condition,applicability,amount,part_of_flexi_pay,min_range,max_range,createdby,createon,createdby_proxy,updatedby,updatedon,updatedby_proxy');
        $this->db->where('flaxi_plan_id',$flexiid);
        return $this->db->get("final_salary_structure")->result();
        
    }
    public function insert_flexi_filter($data)
    {
        $this->db->insert("flexi_plan_filter",$data);
        return $this->db->insert_id();
    }

    public function update_flexi_filter($condition_arr,$setData)
    {       
        $this->db->where($condition_arr);
        $this->db->update('flexi_plan_filter', $setData);
    }

##################### Kingjuliean Work (for table settings) ###################

public function get_table_attributes($condition_arr)
    {   
        $this->db->select("*");
        $this->db->from("table_attribute");
        if($condition_arr)
        {
         $this->db->where($condition_arr);
        }
        $this->db->order_by("col_attributes_order","asc");
        
        return $this->db->get()->result();
    }

    public function updateTableHideShow($id,$status)
    {
        $this->db->query("UPDATE table_attribute set status='".$status."' where id='".$id."'");
        return true;
    }

    public function updateSettings()
    {
        for($x = 0; $x < count($_POST['id']); $x++){

    
    $updateArray[] = array(
        'id'=>$_POST['id'][$x],
        'display_name' => $_POST['display_name'][$x]
        
    );
}      
    $this->db->update_batch('table_attribute',$updateArray, 'id'); 
    }

    public function changeOrder()
    {
        $j=1;
        for($i=0;$i<count($_POST['data']);$i++)
        {
             $this->db->query("UPDATE table_attribute set col_attributes_order='".$j++."' where id='".$_POST['data'][$i]."'");
        }
       
        return true;
    }

    public function changeTableFieldsOrder($data, $table, $updateFieldName, $whereFieldsName)
    {
        if(empty($data) || empty($table) || empty($updateFieldName) || empty($whereFieldsName)) {
            return false;
        }

        $j = 1;

        for($i=0 ; $i<count($data); $i++)
        {
             $this->db->query("UPDATE " . $table ." set `" . $updateFieldName ."` = '" .$j++. "' where `" . $whereFieldsName ."` ='". $data[$i]. "'");
        }

        return true;
    }

    //insert data into manage level
    public function insert_level($db_arr) {
        if (!empty($db_arr)) {
            $this->db->insert("manage_level", $db_arr);
        }
    }


    public function get_emp_list_for_report($condition_arr = "", $limit = 0, $start = 0, $count = false, $str = '') {
        //Note :: status  7 or more than 6 means rule is completed with all emp Salary/Bonus increments
        if($str) {

            $this->db->select($str);

        } else {

            $this->db->select("login_user.id");
        }

        $this->db->from('login_user');

        if($str) {

            $this->db->join("manage_country", "manage_country.id = login_user." . CV_BA_NAME_COUNTRY . "", "left");
            $this->db->join("manage_city", "manage_city.id = login_user." . CV_BA_NAME_CITY . "", "left");
            $this->db->join("manage_function", "manage_function.id = login_user." . CV_BA_NAME_FUNCTION . "", "left");
            $this->db->join("manage_subfunction", "manage_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
            $this->db->join("manage_designation", "manage_designation.id = login_user." . CV_BA_NAME_DESIGNATION . "", "left");
            $this->db->join("manage_grade", "manage_grade.id = login_user." . CV_BA_NAME_GRADE . "", "left");
            $this->db->join("manage_level", "manage_level.id = login_user." . CV_BA_NAME_LEVEL . "", "left");
            $this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . "", "left");
            $this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . "", "left");
            $this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . "", "left");
            $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUBFUNCTION . "", "left");
            $this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
            $this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
            $this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left");
            $this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
            $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");
            $this->db->join("manage_rating_for_current_year", "manage_rating_for_current_year.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . "", "left");

        }

        $this->db->where(array("login_user.role >" => 2, "login_user.status !=" => 2));


        if ($condition_arr) {
            $this->db->where($condition_arr);
        }

        if ($count) {//for record count
            return $this->db->count_all_results();
        }

        if($limit) {//for limit
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result_array();

    }

################################################################################


    public function upload_promotion_upgrade_dtls_into_tmp_tbl($file_path)
	{
		$temp_tbl_fields = array();
        $table_name = 'temp_tbl_promotion_upgrade_dtls';
        $this->load->dbforge();
        $this->dbforge->drop_table($table_name, TRUE);
        $temp_tbl_fields["frm_designation"] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
        $temp_tbl_fields["frm_grade"] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
        $temp_tbl_fields["frm_level"] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
        $temp_tbl_fields["to_designation"] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
        $temp_tbl_fields["to_grade"] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
        $temp_tbl_fields["to_level"] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
        $temp_tbl_fields["is_error"] = array('type' => 'tinyint', 'constraint' => '1', 'default' => 0);
        $temp_tbl_fields["error_msg"] = array('type' => 'TEXT', 'null' => TRUE);
        $temp_tbl_fields = array_merge(array("id"=>array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE)), $temp_tbl_fields);
        $this->dbforge->add_field($temp_tbl_fields);
        $this->dbforge->add_key('id', TRUE);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->dbforge->create_table($table_name, FALSE, $attributes);
        $this->db->query("CREATE INDEX temp_is_error_IDX ON ".$table_name." (is_error);");

        $field_from_csv_str = "frm_designation, frm_grade, frm_level, to_designation, to_grade, to_level";

		//Insert data into temp table
		$this->db->query("LOAD DATA LOCAL INFILE '".$file_path."' INTO TABLE ".$table_name." FIELDS TERMINATED BY ',' ENCLOSED BY '".$enclosed_by."' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (".$field_from_csv_str.")");
		
		//************************ All kind of validations Start *********************************//		
		$this->db->query("UPDATE ".$table_name." tt SET tt.is_error= 1, tt.error_msg = 'Invalid From Designation.' WHERE tt.is_error = 0 AND tt.frm_designation != '' AND NOT EXISTS (SELECT 1 FROM manage_designation mt WHERE mt.name = tt.frm_designation)");
		$this->db->query("UPDATE ".$table_name." tt SET tt.is_error= 1, tt.error_msg = 'Invalid From Grade.' WHERE tt.is_error = 0 AND tt.frm_grade != '' AND NOT EXISTS (SELECT 1 FROM manage_grade mt WHERE mt.name = tt.frm_grade)");
		$this->db->query("UPDATE ".$table_name." tt SET tt.is_error= 1, tt.error_msg = 'Invalid From Level.' WHERE tt.is_error = 0 AND tt.frm_level != '' AND NOT EXISTS (SELECT 1 FROM manage_level mt WHERE mt.name = tt.frm_level)");
		
		$this->db->query("UPDATE ".$table_name." tt SET tt.is_error= 1, tt.error_msg = 'Invalid To Designation.' WHERE tt.is_error = 0 AND tt.to_designation != '' AND NOT EXISTS (SELECT 1 FROM manage_designation mt WHERE mt.name = tt.to_designation)");
		$this->db->query("UPDATE ".$table_name." tt SET tt.is_error= 1, tt.error_msg = 'Invalid To Grade.' WHERE tt.is_error = 0 AND tt.to_grade != '' AND NOT EXISTS (SELECT 1 FROM manage_grade mt WHERE mt.name = tt.to_grade)");
		$this->db->query("UPDATE ".$table_name." tt SET tt.is_error= 1, tt.error_msg = 'Invalid To Level.' WHERE tt.is_error = 0 AND tt.to_level != '' AND NOT EXISTS (SELECT 1 FROM manage_level mt WHERE mt.name = tt.to_level)");		
		//************************ All kind of validations End *********************************//
		
<<<<<<< HEAD
		$this->db->select("ba_name, display_name, value");
		$this->db->from("tuple");
		$this->db->join("datum","datum.row_num = tuple.row_num");
		$this->db->join("business_attribute","business_attribute.id = datum.business_attribute_id");
		$this->db->where(array("datum.data_upload_id"=>$upload_id, "tuple.data_upload_id"=>$upload_id, "user_id"=>$uid));
		//CB:Ravi on 22-02-2018
		//$this->db->where(array("business_attribute.module_name"=>CV_MARKET_SALARY_ELEMENT));
		$this->db->where(array("business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')));
		$this->db->order_by("datum.value","asc");
		return $this->db->get()->result_array();
	} 
	public function test($query) {

		print "<br><pre>".$query."<br>";
		$dbname = "200306_1583480551";
		$this->db->query("Use ".$dbname);  
		$this->db->query($query);
		print "<br><pre>last execute query: ".$this->db->last_query();
	  }
}
=======
		 $this->db->query("UPDATE ".$table_name." tt SET tt.frm_designation = (SELECT mt.id FROM manage_designation mt WHERE mt.name = tt.frm_designation limit 1) WHERE tt.is_error = 0");
		 $this->db->query("UPDATE ".$table_name." tt SET tt.frm_grade = (SELECT mt.id FROM manage_grade mt WHERE mt.name = tt.frm_grade limit 1) WHERE tt.is_error = 0");
		 $this->db->query("UPDATE ".$table_name." tt SET tt.frm_level = (SELECT mt.id FROM manage_level mt WHERE mt.name = tt.frm_level limit 1) WHERE tt.is_error = 0");
		 
		 $this->db->query("UPDATE ".$table_name." tt SET tt.to_designation = (SELECT mt.id FROM manage_designation mt WHERE mt.name = tt.to_designation limit 1) WHERE tt.is_error = 0");
		 $this->db->query("UPDATE ".$table_name." tt SET tt.to_grade = (SELECT mt.id FROM manage_grade mt WHERE mt.name = tt.to_grade limit 1) WHERE tt.is_error = 0");
		 $this->db->query("UPDATE ".$table_name." tt SET tt.to_level = (SELECT mt.id FROM manage_level mt WHERE mt.name = tt.to_level limit 1) WHERE tt.is_error = 0");
		 
		//$response["error_data"] = $this->db->select($field_from_csv_str)->from($table_name)->where("is_error = 1")->get()->result_array();
		$correct_data = $this->db->select("COUNT(*) AS error_cnts")->from($table_name)->where("is_error = 1")->get()->row_array();
		$response["error_cnts"] = $correct_data["error_cnts"];	
		$correct_data = $this->db->select("COUNT(*) AS correct_cnts")->from($table_name)->where("is_error = 0")->get()->row_array();		
		$response["correct_cnts"] = $correct_data["correct_cnts"];
		 
		if($response["correct_cnts"]>0)
		{
			$this->db->query("TRUNCATE TABLE tbl_promotion_up_gradation;");
			
			//Insert data from temp table to tbl_promotion_up_gradation table
			$this->db->query("INSERT INTO tbl_promotion_up_gradation (designation_frm, designation_to, grade_frm, grade_to, level_frm, level_to, created_by, created_on) SELECT tt.frm_designation, tt.to_designation, tt.frm_grade, tt.to_grade, tt.frm_level, tt.to_level, '".$this->session->userdata('userid_ses')."', '".date("Y-m-d H:i:s")."' FROM ".$table_name." tt WHERE tt.is_error = 0");
		}
		return $response;
    }
    

    public function get_revenue_per_business() {
        $this->db->select("revenue_per_business_units_in_year.`id`,manage_country.name as country,manage_city.name as city,manage_business_level_1.name as business_level,financial_year.name as financial_year,revenue,cost,profit,revenue_per_business_units_in_year.createdon");
        $this->db->from('revenue_per_business_units_in_year');
        $this->db->join("manage_country", "manage_country.id = revenue_per_business_units_in_year.country_id" , "left");
        $this->db->join("manage_city", "manage_city.id = revenue_per_business_units_in_year.city_id" , "left");
        $this->db->join("manage_business_level_1", "manage_business_level_1.id = revenue_per_business_units_in_year.business_unit_id" , "left");
        $this->db->join("financial_year", "financial_year.id = revenue_per_business_units_in_year.year_id" , "left");
        return $this->db->get()->result_array();
    }

    

}
>>>>>>> cf8c0cd229d059a6a5658a9d249aa9e4d5af60c1
