<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $dbname = $this->session->userdata("dbname_ses");
        if (trim($dbname)) {
            $this->db->query("Use $dbname");
        }
        date_default_timezone_set('Asia/Calcutta');
    }

    //piy@13Dec19 To get user_id from email
    public function get_user_id_by_email($email_record)
    {
        $this->db->where('email', $email_record);
        $row = $this->db->get('login_user')->row_array();
        if (!empty($row)) {
            return $row['id'];
        } else {
            return false;
        }
    }

    //Piy@13Dec19 create user history log
    public function create_users_history($condition)
    {   $condition=is_array($condition)?HLP_convert_array_to_string_where_clause($condition):$condition;
        $this->db->query("INSERT INTO login_user_history SELECT * FROM login_user WHERE " . $condition );
    }

    //Piy@13Dec19 
    public function update($record, $condition_ary)
    {
        $this->create_users_history($condition_ary);
        $record["updatedby"]       = $this->session->userdata('userid_ses');
        $record["updatedon"]       = date("Y-m-d H:i:s");
        $record["updatedby_proxy"] = $this->session->userdata('proxy_userid_ses');
        return $this->admin_model->update_tbl_data("login_user", $record, $condition_ary);
    }

    //Piy@13Dec19 
    public function update_status($user_id, $status)
    {
        return $this->update(['status' => $status], ['id' => $user_id]);
    }
    
    //Piy@13Dec19 
    public function check_rights_conflicts($user_id) // on_activation

    {
        $user_role = $this->admin_model->get_table_row("login_user", "role", array("id" => $user_id));
        if ($user_role['role'] >= 11) {
            return false; //skip check for role >=11
        }

        $user_cntry_arr = $this->admin_model->get_table("rights_on_country", "country_id", array("status" => 1, "user_id" => $user_id));
        if ($user_cntry_arr) {
            $country_arr = $this->common_model->array_value_recursive("country_id", $user_cntry_arr);

            if (count($country_arr) > 1) {
                $country_arr = implode(",", $country_arr);
            }

            $user_city_arr = $this->admin_model->get_table("rights_on_city", "city_id", array("status" => 1, "user_id" => $user_id));
            $city_arr      = $this->common_model->array_value_recursive("city_id", $user_city_arr);
            if (count($city_arr) > 1) {
                $city_arr = implode(",", $city_arr);
            }

            $user_bl1_arr          = $this->admin_model->get_table("rights_on_business_level_1", "business_level_1_id", array("status" => 1, "user_id" => $user_id));
            $bussiness_level_1_arr = $this->common_model->array_value_recursive("business_level_1_id", $user_bl1_arr);
            if (count($bussiness_level_1_arr) > 1) {
                $bussiness_level_1_arr = implode(",", $bussiness_level_1_arr);
            }

            $user_bl2_arr          = $this->admin_model->get_table("rights_on_business_level_2", "business_level_2_id", array("status" => 1, "user_id" => $user_id));
            $bussiness_level_2_arr = $this->common_model->array_value_recursive("business_level_2_id", $user_bl2_arr);
            if (count($bussiness_level_2_arr) > 1) {
                $bussiness_level_2_arr = implode(",", $bussiness_level_2_arr);
            }

            $user_bl3_arr          = $this->admin_model->get_table("rights_on_business_level_3", "business_level_3_id", array("status" => 1, "user_id" => $user_id));
            $bussiness_level_3_arr = $this->common_model->array_value_recursive("business_level_3_id", $user_bl3_arr);
            if (count($bussiness_level_3_arr) > 1) {
                $bussiness_level_3_arr = implode(",", $bussiness_level_3_arr);
            }

            $user_funct_arr = $this->admin_model->get_table("rights_on_functions", "function_id", array("status" => 1, "user_id" => $user_id));
            $function_arr   = $this->common_model->array_value_recursive("function_id", $user_funct_arr);
            if (count($function_arr) > 1) {
                $function_arr = implode(",", $function_arr);
            }

            $user_sub_funct_arr = $this->admin_model->get_table("rights_on_sub_functions", "sub_function_id", array("status" => 1, "user_id" => $user_id));
            $sub_function_arr   = $this->common_model->array_value_recursive("sub_function_id", $user_sub_funct_arr);
            if (count($sub_function_arr) > 1) {
                $sub_function_arr = implode(",", $sub_function_arr);
            }

            $user_sub_subfunct_arr = $this->admin_model->get_table("rights_on_sub_subfunctions", "sub_subfunction_id", array("status" => 1, "user_id" => $user_id));
            $sub_subfunction_arr = $this->common_model->array_value_recursive("sub_subfunction_id", $user_sub_subfunct_arr);
            if (count($sub_function_arr) > 1) {
                $sub_subfunction_arr = implode(",", $sub_subfunction_arr);
            }            

            $user_desig_arr  = $this->admin_model->get_table("rights_on_designations", "designation_id", array("status" => 1, "user_id" => $user_id));
            $designation_arr = $this->common_model->array_value_recursive("designation_id", $user_desig_arr);
            if (count($designation_arr) > 1) {
                $designation_arr = implode(",", $designation_arr);
            }

            $user_grd_arr = $this->admin_model->get_table("rights_on_grades", "grade_id", array("status" => 1, "user_id" => $user_id));
            $grade_arr    = $this->common_model->array_value_recursive("grade_id", $user_grd_arr);
            if (count($grade_arr) > 1) {
                $grade_arr = implode(",", $grade_arr);
            }

            $user_lvl_arr = $this->admin_model->get_table("rights_on_levels", "level_id", array("status" => 1, "user_id" => $user_id));
            $level_arr    = $this->common_model->array_value_recursive("level_id", $user_lvl_arr);
            if (count($level_arr) > 1) {
                $level_arr = implode(",", $level_arr);
            }

            $user_dtls = $this->admin_model->get_table_row("login_user", "id, email, role", array("id" => $user_id), "id desc");

            $rights_for_user_id = $user_dtls["id"];
            $role               = $user_dtls["role"];
            $is_rights_conflict = $this->admin_model->check_user_rights_conflicts($rights_for_user_id, $role, $country_arr, $city_arr, $bussiness_level_1_arr, $bussiness_level_2_arr, $bussiness_level_3_arr, $function_arr, $sub_function_arr, $sub_subfunction_arr, $designation_arr, $grade_arr, $level_arr);            
            if ($is_rights_conflict) {
                return true;
            }

        }
        return false;
    }

    public function get_users_details($select_str, $condition_arr)
	{
        $this->db->select($select_str);
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
        $this->db->join("manage_sub_subfunction", "manage_sub_subfunction.id = login_user." . CV_BA_NAME_SUB_SUBFUNCTION . "", "left");
		$this->db->join("manage_education", "manage_education.id = login_user." . CV_BA_NAME_EDUCATION . "", "left");
		$this->db->join("manage_critical_talent", "manage_critical_talent.id = login_user." . CV_BA_NAME_CRITICAL_TALENT . "", "left");
		$this->db->join("manage_critical_position", "manage_critical_position.id = login_user." . CV_BA_NAME_CRITICAL_POSITION . "", "left"); 
        $this->db->join("manage_special_category", "manage_special_category.id = login_user." . CV_BA_NAME_SPECIAL_CATEGORY . "", "left");
        $this->db->join("manage_currency", "manage_currency.id = login_user." . CV_BA_NAME_CURRENCY . "", "left");
        $this->db->where(array("login_user.status" => CV_STATUS_ACTIVE));

        if ($condition_arr) {
            $this->db->where($condition_arr);
        }

        return $this->db->get()->result_array();
    }

    public function get_users_details_from_emails($str, array $usrId) {

        if (empty($str) || empty($usrId)) {
            //if select field not found or userid empty then return
            return;
        }

        $this->db->select($str);
        $this->db->from('login_user');
        $this->db->where_in('login_user.email', $usrId);
        $this->db->order_by("login_user.id", "asc");

        return $this->db->get()->result_array();
    }

} //end class
