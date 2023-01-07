<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model
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

    public function get_uploaded_file_list($condition_arr)
	{
   		$this->db->select("data_upload.*, login_user.name");
   		$this->db->from("data_upload");
   		$this->db->join("login_user", "login_user.id = data_upload.uploaded_by_user_id");
   		if($condition_arr)
   		{
   			$this->db->where($condition_arr);
   		}
   		$this->db->order_by('id','desc');
   		return $this->db->get()->result_array();
	}

	public function insert_uploaded_file_dtls($data)
	{
		$this->db->insert("data_upload",$data);
		return $this->db->insert_id();
	}

	public function get_uploaded_file_dtls($upload_id)
	{
		return $this->db->select("id,original_file_name,uploaded_by_user_id, status")->where("id",$upload_id)->get("data_upload")->row_array();
	}

	public function update_uploaded_file_status($condition_arr,$setData)
	{
		$this->db->where($condition_arr);
		$this->db->update('data_upload', $setData);
	}

	public function deleteData_upload_row($deleteArray){
		$this->db->delete('data_upload',$deleteArray);
	}

	public function updatePerformanceStatus($data,$conditionArr){
		$this->db->update("performance_cycle",$data,$conditionArr);
	}

	public function get_table_row($table, $fields, $condition_arr)
	{
		$this->db->select($fields);
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();
	}

//********** CB::Ravi on 07-12-2018 :: New code after removing Datum tbl concept Start **************************//
	public function create_upload_temp_table($table_name, $fields)
	{
		$this->load->dbforge();
		$this->dbforge->drop_table($table_name,TRUE);
		if($fields)
		{
			$fields["is_error"] = array('type' => 'tinyint', 'constraint' => '1', 'default' => 0);
			$fields["error_msg"] = array('type' => 'TEXT', 'null' => TRUE);
   			$fields["error_field"] = array('type' => 'TEXT', 'null' => TRUE);

			$fields = array_merge(array("id"=>array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE)), $fields);

			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$attributes = array('ENGINE' => 'InnoDB');
			$this->dbforge->create_table($table_name, FALSE, $attributes);
			if(array_key_exists('email', $fields))//if(in_array('email', $fields))
			{
				$this->db->query("CREATE INDEX temp_upload_data_email_IDX ON ".$table_name." (email);");
			}

			if(array_key_exists('approver_1', $fields))
			{
				$this->db->query("CREATE INDEX temp_approver_1_IDX ON ".$table_name." (approver_1);");
			}

			if(array_key_exists('approver_2', $fields))
			{
				$this->db->query("CREATE INDEX temp_approver_2_IDX ON ".$table_name." (approver_2);");
			}

			if(array_key_exists('approver_3', $fields))
			{
				$this->db->query("CREATE INDEX temp_approver_3_IDX ON ".$table_name." (approver_3);");
			}

			if(array_key_exists('approver_4', $fields))
			{
				$this->db->query("CREATE INDEX temp_approver_4_IDX ON ".$table_name." (approver_4);");
			}

			if(array_key_exists('authorised_signatory_for_letter', $fields))
			{
				$this->db->query("CREATE INDEX temp_auth_sign_letter_IDX ON ".$table_name." (authorised_signatory_for_letter);");
			}

			if(array_key_exists('hr_authorised_signatory_for_letter', $fields))
			{
				$this->db->query("CREATE INDEX temp_hr_auth_sign_letter_IDX ON ".$table_name." (hr_authorised_signatory_for_letter);");
			}

			if(array_key_exists('cost_center', $fields))
			{
				$this->db->query("CREATE INDEX temp_cost_center_IDX ON ".$table_name." (cost_center);");
			}

			if(array_key_exists('employee_type', $fields))
			{
				$this->db->query("CREATE INDEX temp_employee_type_IDX ON ".$table_name." (employee_type);");
			}

			if(array_key_exists('country', $fields))
			{
				$this->db->query("CREATE INDEX temp_country_IDX ON ".$table_name." (country);");
			}

			if(array_key_exists('city', $fields))
			{
				$this->db->query("CREATE INDEX temp_city_IDX ON ".$table_name." (city);");
			}

			if(array_key_exists('business_level_1', $fields))
			{
				$this->db->query("CREATE INDEX temp_business_level_1_IDX ON ".$table_name." (business_level_1);");
			}

			if(array_key_exists('business_level_2', $fields))
			{
				$this->db->query("CREATE INDEX temp_business_level_2_IDX ON ".$table_name." (business_level_2);");
			}

			if(array_key_exists('business_level_3', $fields))
			{
				$this->db->query("CREATE INDEX temp_business_level_3_IDX ON ".$table_name." (business_level_3);");
			}

			if(array_key_exists('function', $fields))
			{
				$this->db->query("CREATE INDEX temp_function_IDX ON ".$table_name." (function);");
			}

			if(array_key_exists('subfunction', $fields))
			{
				$this->db->query("CREATE INDEX temp_subfunction_IDX ON ".$table_name." (subfunction);");
			}

			if(array_key_exists('sub_subfunction', $fields))
			{
				$this->db->query("CREATE INDEX temp_sub_subfunction_IDX ON ".$table_name." (sub_subfunction);");
			}

			if(array_key_exists('designation', $fields))
			{
				$this->db->query("CREATE INDEX temp_designation_IDX ON ".$table_name." (designation);");
			}

			if(array_key_exists('grade', $fields))
			{
				$this->db->query("CREATE INDEX temp_grade_IDX ON ".$table_name." (grade);");
			}

			if(array_key_exists('level', $fields))
			{
				$this->db->query("CREATE INDEX temp_level_IDX ON ".$table_name." (level);");
			}

			if(array_key_exists('employee_role', $fields))
			{
				$this->db->query("CREATE INDEX temp_employee_role_IDX ON ".$table_name." (employee_role);");
			}

			if(array_key_exists('education', $fields))
			{
				$this->db->query("CREATE INDEX temp_education_IDX ON ".$table_name." (education);");
			}

			if(array_key_exists('critical_talent', $fields))
			{
				$this->db->query("CREATE INDEX temp_critical_talent_IDX ON ".$table_name." (critical_talent);");
			}

			if(array_key_exists('critical_position', $fields))
			{
				$this->db->query("CREATE INDEX temp_critical_position_IDX ON ".$table_name." (critical_position);");
			}

			if(array_key_exists('special_category', $fields))
			{
				$this->db->query("CREATE INDEX temp_special_category_IDX ON ".$table_name." (special_category);");
			}

			if(array_key_exists('rating_for_current_year', $fields))
			{
				$this->db->query("CREATE INDEX temp_rating_for_current_year_IDX ON ".$table_name." (rating_for_current_year);");
			}

			if(array_key_exists('rating_for_last_year', $fields))
			{
				$this->db->query("CREATE INDEX temp_rating_for_last_year_IDX ON ".$table_name." (rating_for_last_year);");
			}

			if(array_key_exists('rating_for_2nd_last_year', $fields))
			{
				$this->db->query("CREATE INDEX temp_rating_for_2nd_last_year_IDX ON ".$table_name." (rating_for_2nd_last_year);");
			}

			if(array_key_exists('rating_for_3rd_last_year', $fields))
			{
				$this->db->query("CREATE INDEX temp_rating_for_3rd_last_year_IDX ON ".$table_name." (rating_for_3rd_last_year);");
			}

			if(array_key_exists('rating_for_4th_last_year', $fields))
			{
				$this->db->query("CREATE INDEX temp_rating_for_4th_last_year_IDX ON ".$table_name." (rating_for_4th_last_year);");
			}

			if(array_key_exists('rating_for_5th_last_year', $fields))
			{
				$this->db->query("CREATE INDEX temp_rating_for_5th_last_year_IDX ON ".$table_name." (rating_for_5th_last_year);");
			}

			if(array_key_exists('currency', $fields))
			{
				$this->db->query("CREATE INDEX temp_currency_IDX ON ".$table_name." (currency);");
			}

			$this->db->query("CREATE INDEX temp_upload_data_is_error_IDX ON ".$table_name." (is_error);");

			//$this->dbforge->drop_table($table_name,TRUE);
		}
	}

	public function insert_data_in_tmp_tbl($table_name, $fields, $file_path, $upload_id, $mapped_ba_ids_arr, $required_fields_arr, $numeric_fields_arr, $field_from_temp, $master_fields_arr,$params=[])
	{

		$pass = "Compport@1234";
		//piy@3Mar to support | as delimiter for people strong csv
		$enclosed_by=(isset($params['enclosed_by']))? $params['enclosed_by']:'"';
		$delimited_by=(isset($params['delimited_by']))? $params['delimited_by']:',';
		$terminated_by=(isset($params['terminated_by']))? $params['terminated_by']:'\r\n';

		ini_set('memory_limit','3072M');
		set_time_limit(1200);
		// Performance Testing By Ravi
		$this->db->insert("tbl_audit_log", array("process"=>"Load Data Start", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		//Insert data into temp table
		$this->db->query("LOAD DATA LOCAL INFILE '".$file_path."' INTO TABLE ".$table_name." CHARACTER SET latin1 FIELDS TERMINATED BY '".$delimited_by."' ENCLOSED BY '".$enclosed_by."' LINES TERMINATED BY '".$terminated_by."' IGNORE 1 LINES (".$fields.")");
		//$this->db->query("LOAD DATA LOCAL INFILE '".$file_path."' INTO TABLE ".$table_name." FIELDS TERMINATED BY ',' ENCLOSED BY '".$enclosed_by."' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (".$fields.")");
		//$this->db->query("LOAD DATA LOCAL INFILE '".$file_path."' INTO TABLE ".$table_name." CHARACTER SET UTF8 FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '".$enclosed_by."' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (".$fields.")");
		//************************ All kind of validations Start *********************************//

		// Performance Testing By Ravi
		$this->db->insert("tbl_audit_log", array("process"=>"Load Data END", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

	        //Required fields check
	        // $req_str = implode(" IS NULL OR ", $required_fields_arr) . " IS NULL OR " . implode(" = '' OR ", $required_fields_arr) . " = ''";
	        // $this->db->query("UPDATE " . $table_name . " tu SET tu.is_error= 1, tu.error_msg = 'Required fields are missing.' WHERE tu.is_error = 0 AND (" . $req_str . ")");
	        foreach ($required_fields_arr as $key => $field) {
	            $req_str = " $field IS NULL OR  $field = '' ";
	            $this->db->query("UPDATE " . $table_name . " tu SET tu.is_error= 1, tu.error_msg = 'Required fields are missing.', tu.error_field = '$field' WHERE tu.is_error = 0 AND (" . $req_str . ")");
	        }

		// Performance Testing By Ravi
		$this->db->insert("tbl_audit_log", array("process"=>"Required Check End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		//Numeric fields check

	        foreach ($numeric_fields_arr as $key => $field) {
	            $req_str = " $field NOT REGEXP '^[0-9.]+$' ";
	            $this->db->query("UPDATE " . $table_name . " tu SET tu.is_error= 1, tu.error_msg = 'Numeric fields are having invalid data.', tu.error_field = '$field' WHERE tu.is_error = 0 AND (" . $req_str . ")");
	        }

        	$this->db->insert("tbl_audit_log", array("process" => "Numeric Check End", "upload_id" => $upload_id, "created_on" => date("Y-m-d H:i:s")));

		//Email format as well Domain related emails check
		//$email_format_regex = "^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$";
		$company_domain_name = strtolower($this->session->userdata('domainname_ses'));
		//$email_format_regex = "^[A-Z0-9._%-]+@".$company_domain_name."$";
		$email_format_regex = "^[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@".$company_domain_name."$";
		if(!$this->session->userdata('domain_check_required_ses'))
		{
			$email_format_regex = "^[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9]\\.[a-zA-Z]{2,4}$";
		}

		 /* No need to validate below fields
	       $email_arr   = array(CV_BA_NAME_EMP_EMAIL);

        if (in_array(CV_FIRST_APPROVER_ID, $mapped_ba_ids_arr)) {
            $email_arr[] = CV_BA_NAME_APPROVER_1;
        }
        if (in_array(CV_SECOND_APPROVER_ID, $mapped_ba_ids_arr)) {
            $email_arr[] = CV_BA_NAME_APPROVER_2;
        }
        if (in_array(CV_THIRD_APPROVER_ID, $mapped_ba_ids_arr)) {
            $email_arr[] = CV_BA_NAME_APPROVER_3;
        }
        if (in_array(CV_FOURTH_APPROVER_ID, $mapped_ba_ids_arr)) {
            $email_arr[] = CV_BA_NAME_APPROVER_4;
        }
        if (in_array(69, $mapped_ba_ids_arr)) {
            $email_arr[] = CV_BA_NAME_AUTHORISED_SIGNATORY_FOR_LETTER;
        }
        if (in_array(71, $mapped_ba_ids_arr)) {
            $email_arr[] = CV_BA_NAME_HR_AUTHORISED_SIGNATORY_FOR_LETTER;
        }

        foreach ($email_arr as $key => $field) {
            if ($field == "email") {
                $req_str   = "$field NOT REGEXP '$email_format_regex'";
                $email_str = "" . CV_BA_NAME_EMP_EMAIL . " NOT REGEXP '" . $email_format_regex . "'";
            } else {
                $req_str = " $field != '' AND $field NOT REGEXP '$email_format_regex' ";
            }
            $this->db->query("UPDATE " . $table_name . " tu SET tu.is_error= 1, tu.error_msg = 'Email format is not valid.', tu.error_field = '$field' WHERE tu.is_error = 0 AND (" . $req_str . ")");
		} */
		//validate email only for other_data_20 field
		$field 		= CV_BA_NAME_OTHER_DATA_20;
		$req_str   	= "$field NOT REGEXP '$email_format_regex'";
		$this->db->query("UPDATE " . $table_name . " tu SET tu.is_error= 1, tu.error_msg = 'Email format is not valid.', tu.error_field = 'Official Field Id' WHERE tu.is_error = 0 AND (" . $req_str . ")");

   		// Performance Testing By Ravi
   		$this->db->insert("tbl_audit_log", array("process"=>"Email Check End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		//Check the dates are in required (d-M-y) formats
   		$dt_required_format = "%d-%M-%y";
   		$date_format_arr = array();
   		$date_cols_arr_to_upd = array();
        if (in_array(CV_BA_ID_COMPANY_JOINING_DATE, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_COMPANY_JOINING_DATE;
            // $date_format_arr[] = "(" . CV_BA_NAME_COMPANY_JOINING_DATE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_COMPANY_JOINING_DATE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = CV_BA_NAME_COMPANY_JOINING_DATE . " = STR_TO_DATE(" . CV_BA_NAME_COMPANY_JOINING_DATE . ", '%d-%M-%y')";
        }
        if (in_array(CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE;
            // $date_format_arr[] = "(" . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . " = STR_TO_DATE(" . CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE . ", '%d-%M-%y')";
        }
        if (in_array(CV_BA_ID_START_DATE_FOR_ROLE, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_START_DATE_FOR_ROLE;
            // $date_format_arr[] = "(" . CV_BA_NAME_START_DATE_FOR_ROLE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_START_DATE_FOR_ROLE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_START_DATE_FOR_ROLE . " = STR_TO_DATE(" . CV_BA_NAME_START_DATE_FOR_ROLE . ", '%d-%M-%y')";
        }
        if (in_array(CV_BA_ID_END_DATE_FOR_ROLE, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_END_DATE_FOR_ROLE;
            // $date_format_arr[] = "(" . CV_BA_NAME_END_DATE_FOR_ROLE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_END_DATE_FOR_ROLE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_END_DATE_FOR_ROLE . " = STR_TO_DATE(" . CV_BA_NAME_END_DATE_FOR_ROLE . ", '%d-%M-%y')";
        }
        if (in_array(CV_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE_ID, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE;
            // $date_format_arr[] = "(" . CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE . " = STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE . ", '%d-%M-%y')";
        }
        if (in_array(CV_BA_ID_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE;
            // $date_format_arr[] = "(" . CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE . " = STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE . ", '%d-%M-%y')";
        }
        if (in_array(CV_BA_ID_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE;
            // $date_format_arr[] = "(" . CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE . " = STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE . ", '%d-%M-%y')";
        }
        if (in_array(CV_BA_ID_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE;
            // $date_format_arr[] = "(" . CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE . " = STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE . ", '%d-%M-%y')";
        }
        if (in_array(CV_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE_ID, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE;
            // $date_format_arr[] = "(" . CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE . " = STR_TO_DATE(" . CV_BA_NAME_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE . ", '%d-%M-%y')";
        }

        if (in_array(CV_BA_ID_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN;
            // $date_format_arr[] = "(" . CV_BA_NAME_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN . " != '' AND TO_DAYS(STR_TO_DATE(" . CV_BA_NAME_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN . ", '" . $dt_required_format . "')) is null)";
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN . " = STR_TO_DATE(" . CV_BA_NAME_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN . ", '%d-%M-%y')";
        }
		
	if (in_array(CV_BA_ID_PROMOTED_IN_2_YRS, $mapped_ba_ids_arr)) {
            $date_format_arr[] = CV_BA_NAME_PROMOTED_IN_2_YRS;
            $date_cols_arr_to_upd[] = "" . CV_BA_NAME_PROMOTED_IN_2_YRS . " = STR_TO_DATE(" . CV_BA_NAME_PROMOTED_IN_2_YRS . ", '%d-%M-%y')";
        }

       foreach ($date_format_arr as $key => $field) {
    		$req_str = " $field != '' AND TO_DAYS(STR_TO_DATE($field, '$dt_required_format')) is NULL ";
    		$this->db->query("UPDATE " . $table_name . " tu SET tu.is_error= 1, tu.error_msg = 'Dates format is not valid.', tu.error_field = '$field' WHERE tu.is_error = 0 AND (" . $req_str . ")");
    	}
		// Performance Testing By Ravi
		$this->db->insert("tbl_audit_log", array("process"=>"Date Check End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));


		//************************ All kind of validations End *********************************//

		$field_from_temp_arr = explode(",", $field_from_temp);
		$usr_upd_arr = array();
		foreach($field_from_temp_arr as $row)
		{
			$usr_upd_arr[] = "lu.".$row." = CASE WHEN (tu.".$row." = '' OR tu.".$row." IS NULL) THEN lu.".$row." ELSE tu.".$row." END";
		}

		$str_seprate = "";
		$master_field_names_in_login_tbl_arr = array();
		//Insert data from temp table to master table
		foreach($master_fields_arr as $row)
		{
			$master_tbl_name = "manage_".$row;
			if($row == CV_BA_NAME_RATING_FOR_LAST_YEAR or $row == CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR or $row == CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR or $row == CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR or $row == CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR)
			{
				$master_tbl_name = "manage_".CV_BA_NAME_RATING_FOR_CURRENT_YEAR;
			}
			else
			{	//Piy@21Jan Set NA to empty value. Filter in rule does not list these records
			//	$this->db->query("UPDATE {$table_name} tu SET tu.{$row} = 'NA' WHERE tu.{$row} = '' OR tu.{$row} = null");
			}

			$this->db->query("INSERT INTO ".$master_tbl_name." (name) SELECT DISTINCT tu.".$row." FROM ".$table_name." tu WHERE tu.is_error = 0 AND tu.".$row." != '' AND NOT EXISTS (SELECT 1 FROM ".$master_tbl_name." mt WHERE mt.name = tu.".$row.")");
			$this->db->query("UPDATE ".$table_name." tu SET tu.".$row." = (SELECT mt.id FROM ".$master_tbl_name." mt WHERE mt.name = tu.".$row.") WHERE tu.is_error = 0");
			$str_seprate = ",";

			$master_field_names_in_login_tbl_arr[] = $row;
			$usr_upd_arr[] = "lu.".$row." = CASE WHEN (tu.".$row." = '' OR tu.".$row." IS NULL) THEN lu.".$row." ELSE tu.".$row." END";
			$this->db->insert("tbl_audit_log", array("process"=>"Masters Created: ". $row, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
		}

		// Performance Testing By Ravi
		$this->db->insert("tbl_audit_log", array("process"=>"Masters Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		//Manage login_user tbl History before updating data of the users

		$query = $this->db->select("COUNT(id) AS id FROM ".$table_name." WHERE is_error = 0")->get()->row_array();
		$total_no_of_rows 		= $query['id'];
		$row_processing_limit 	= 200;//update as per requirement
		$batch_start_point 		= 1;
		$batch_end_point 		= $row_processing_limit;

		//check for update or insert in login_user table
		$query_login_user = $this->db->select("COUNT(id) AS emp_count FROM login_user WHERE upload_id != 0 AND createdby != 0")->get()->row_array();
		$has_previous_data = false;

		if($query_login_user['emp_count'] > 0) {

			$has_previous_data = true;
		}

		$this->db->insert("tbl_audit_log", array("process"=>"Created total rows: ".$total_no_of_rows . " Chunk: ". $row_processing_limit, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		while($batch_start_point <= $total_no_of_rows) {

			//$this->db->query("INSERT INTO login_user_history SELECT * FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." IN (SELECT tu.".CV_BA_NAME_EMP_EMAIL." FROM ".$table_name." tu WHERE tu.is_error = 0)");

			if($has_previous_data) {

				$this->db->query("INSERT INTO login_user_history SELECT * FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." IN (SELECT tu.".CV_BA_NAME_EMP_EMAIL." FROM ".$table_name." tu WHERE tu.is_error = 0 and tu.id between ". $batch_start_point . " and ". $batch_end_point .")");
				$this->db->insert("tbl_audit_log", array("process"=>"History users chunk end: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
			}

			//Update all date columns with the date format as "yyyy-mm-dd"
			if($date_cols_arr_to_upd)
			{
				$this->db->query("UPDATE ".$table_name." SET ".implode(", ", $date_cols_arr_to_upd)." WHERE is_error = 0  and id between ". $batch_start_point . " and ". $batch_end_point);

				// Performance Testing By Ravi
				$this->db->insert("tbl_audit_log", array("process"=>"Date column chunk end: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

			}

			//Updated already exist users data from temp to login_user table
			if($has_previous_data && $usr_upd_arr)
			{
				// Update login_user about to start
				$this->db->insert("tbl_audit_log", array("process"=>"Update about to start: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

				$this->db->query("UPDATE login_user lu INNER JOIN ".$table_name." tu USING (".CV_BA_NAME_EMP_EMAIL.") SET lu.upload_id = ".$upload_id.", lu.updatedon = '".date("Y-m-d H:i:s")."', ".implode(", ", $usr_upd_arr). " WHERE tu.is_error = 0 and tu.id between ". $batch_start_point . " and ". $batch_end_point);

				// Performance Testing By Ravi
				$this->db->insert("tbl_audit_log", array("process"=>"Update finished: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

			}

			//Insert data from temp table to login_user table
			//$this->db->query("INSERT INTO login_user (pass,role,status,upload_id,company_Id,updatedby,createdby,updatedon,createdon,createdby_proxy,updatedby_proxy,".$field_from_temp.$str_seprate.implode(",", $master_field_names_in_login_tbl_arr).") SELECT '".md5($pass)."', 11,1,".$upload_id.",'".$this->session->userdata('companyid_ses')."','".$this->session->userdata('userid_ses')."','".$this->session->userdata('userid_ses')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$this->session->userdata('proxy_userid_ses')."','".$this->session->userdata('proxy_userid_ses')."',".$field_from_temp.$str_seprate.implode(",", $master_fields_arr)." FROM ".$table_name." tu WHERE tu.is_error = 0 AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_EMP_EMAIL.")");

			$select_str = '`tu`.`email` AS `email`';
			$this->db->select($select_str);
			$this->db->from($table_name . ' AS `tu`');
			$this->db->join("login_user", "login_user.email = tu.email", "left");
			$this->db->where('tu.is_error', 0);
			$this->db->where('login_user.email IS NULL', NULL);
			$this->db->where('tu.id >=', $batch_start_point);
			$this->db->where('tu.id <=', $batch_end_point);
			$rslt_array = $this->db->get()->result_array();

			if(!empty($rslt_array)) {

				$email_array = array();

				foreach($rslt_array as $key => $user_det) {

					$email_array[$key] = "'".$user_det['email']."'";

				}

				if(!empty($email_array)) {

					$email_str = implode(", ", $email_array);
					$this->db->query("INSERT INTO login_user (pass,role,status,upload_id,company_Id,updatedby,createdby,updatedon,createdon,createdby_proxy,updatedby_proxy,".$field_from_temp.$str_seprate.implode(",", $master_field_names_in_login_tbl_arr).") SELECT '".md5($pass)."', 11,1,".$upload_id.",'".$this->session->userdata('companyid_ses')."','".$this->session->userdata('userid_ses')."','".$this->session->userdata('userid_ses')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$this->session->userdata('proxy_userid_ses')."','".$this->session->userdata('proxy_userid_ses')."',".$field_from_temp.$str_seprate.implode(",", $master_fields_arr)." FROM ".$table_name." tu WHERE tu.".CV_BA_NAME_EMP_EMAIL." IN (".$email_str.")");

					$this->db->insert("tbl_audit_log", array("process"=>"New users chunk end: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
				} else {

					$this->db->insert("tbl_audit_log", array("process"=>"No N users found chunk end: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
				}

			} else {

				$this->db->insert("tbl_audit_log", array("process"=>"No new users found chunk end: ".$batch_start_point . " to ". $batch_end_point, "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
			}

			$batch_start_point 	= $batch_end_point + 1;
			$batch_end_point	= $batch_end_point + $row_processing_limit;
		}

		// Performance Testing By Ravi
		$this->db->insert("tbl_audit_log", array("process"=>"New Users Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		//Create managers
		/* $new_managers_to_upd_role_arr = array();
		if(in_array(CV_FIRST_APPROVER_ID, $mapped_ba_ids_arr))
		{
			//Insert 1st Approvers
			//$this->db->query("INSERT INTO login_user (".CV_BA_NAME_EMP_EMAIL.",pass,role,is_manager,status,upload_id,company_Id,updatedby,createdby,updatedon,createdon,createdby_proxy,updatedby_proxy) SELECT DISTINCT tu.".CV_BA_NAME_APPROVER_1.", '".md5($pass)."', 10,1,1,".$upload_id.",'".$this->session->userdata('companyid_ses')."','".$this->session->userdata('userid_ses')."','".$this->session->userdata('userid_ses')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$this->session->userdata('proxy_userid_ses')."','".$this->session->userdata('proxy_userid_ses')."' FROM ".$table_name." tu WHERE tu.is_error = 0 AND tu.".CV_BA_NAME_APPROVER_1." != '' AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_1.")");
			$new_managers_to_upd_role_arr[] = "lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_1."";

			// Performance Testing By Ravi
			//$this->db->insert("tbl_audit_log", array("process"=>"1st Manager Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
		}
		if(in_array(CV_SECOND_APPROVER_ID, $mapped_ba_ids_arr))
		{
			//Insert 2nd Approvers
			//$this->db->query("INSERT INTO login_user (".CV_BA_NAME_EMP_EMAIL.",pass,role,is_manager,status,upload_id,company_Id,updatedby,createdby,updatedon,createdon,createdby_proxy,updatedby_proxy) SELECT DISTINCT tu.".CV_BA_NAME_APPROVER_2.", '".md5($pass)."', 10,1,1,".$upload_id.",'".$this->session->userdata('companyid_ses')."','".$this->session->userdata('userid_ses')."','".$this->session->userdata('userid_ses')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$this->session->userdata('proxy_userid_ses')."','".$this->session->userdata('proxy_userid_ses')."' FROM ".$table_name." tu WHERE tu.is_error = 0 AND tu.".CV_BA_NAME_APPROVER_2." != '' AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_2.")");
			$new_managers_to_upd_role_arr[] = "lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_2."";

			// Performance Testing By Ravi
			//$this->db->insert("tbl_audit_log", array("process"=>"2nd Manager Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
		}
		if(in_array(CV_THIRD_APPROVER_ID, $mapped_ba_ids_arr))
		{
			//Insert 3rd Approvers
			//$this->db->query("INSERT INTO login_user (".CV_BA_NAME_EMP_EMAIL.",pass,role,is_manager,status,upload_id,company_Id,updatedby,createdby,updatedon,createdon,createdby_proxy,updatedby_proxy) SELECT DISTINCT tu.".CV_BA_NAME_APPROVER_3.", '".md5($pass)."', 10,1,1,".$upload_id.",'".$this->session->userdata('companyid_ses')."','".$this->session->userdata('userid_ses')."','".$this->session->userdata('userid_ses')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$this->session->userdata('proxy_userid_ses')."','".$this->session->userdata('proxy_userid_ses')."' FROM ".$table_name." tu WHERE tu.is_error = 0 AND tu.".CV_BA_NAME_APPROVER_3." != '' AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_3.")");
			$new_managers_to_upd_role_arr[] = "lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_3."";

			// Performance Testing By Ravi
			//$this->db->insert("tbl_audit_log", array("process"=>"3rd Manager Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
		}
		if(in_array(CV_FOURTH_APPROVER_ID, $mapped_ba_ids_arr))
		{
			//Insert 4th Approvers
			//$this->db->query("INSERT INTO login_user (".CV_BA_NAME_EMP_EMAIL.",pass,role,is_manager,status,upload_id,company_Id,updatedby,createdby,updatedon,createdon,createdby_proxy,updatedby_proxy) SELECT DISTINCT tu.".CV_BA_NAME_APPROVER_4.", '".md5($pass)."', 10,1,1,".$upload_id.",'".$this->session->userdata('companyid_ses')."','".$this->session->userdata('userid_ses')."','".$this->session->userdata('userid_ses')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$this->session->userdata('proxy_userid_ses')."','".$this->session->userdata('proxy_userid_ses')."' FROM ".$table_name." tu WHERE tu.is_error = 0 AND tu.".CV_BA_NAME_APPROVER_4." != '' AND NOT EXISTS (SELECT 1 FROM login_user lu WHERE lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_4.")");
			$new_managers_to_upd_role_arr[] = "lu.".CV_BA_NAME_EMP_EMAIL." = tu.".CV_BA_NAME_APPROVER_4."";

			// Performance Testing By Ravi
			//$this->db->insert("tbl_audit_log", array("process"=>"4th Manager Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
		}

		//Updated already exist users role & is_manager column value into login_user table if now they are become a manager
		//NOTE :: Move this functionality in hidden process in below method as set_role_for_managers()
		if($new_managers_to_upd_role_arr)
		{
			$this->db->query("UPDATE login_user lu SET is_manager = 1 WHERE role > 1 AND role < 10 AND upload_id = ".$upload_id." AND is_manager=0 AND EXISTS(SELECT 1 FROM ".$table_name." tu WHERE tu.is_error = 0 AND (".implode(" OR ", $new_managers_to_upd_role_arr)."))");
			$this->db->query("UPDATE login_user lu SET is_manager = 1, role = 10 WHERE role >= 11 AND upload_id = ".$upload_id." AND is_manager=0 AND EXISTS(SELECT 1 FROM ".$table_name." tu WHERE tu.is_error = 0 AND (".implode(" OR ", $new_managers_to_upd_role_arr)."))");

			// Performance Testing By Ravi
			$this->db->insert("tbl_audit_log", array("process"=>"Changed role as Manager old emps End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));
		}*/

		//Updated tenures of the users
		foreach($field_from_temp_arr as $row)
		{
			if($row == CV_COMPANY_JOINING_DATE)
			{
				$this->db->query("UPDATE login_user lu SET tenure_company = timestampdiff(YEAR,lu.".$row.", '".date("Y-m-d H:i:s")."') WHERE upload_id = ".$upload_id);
			}
			if($row == CV_INCREMENT_PURPOSE_JOINING_DATE)
			{
				$this->db->query("UPDATE login_user lu SET tenure_role = timestampdiff(YEAR,lu.".$row.", '".date("Y-m-d H:i:s")."') WHERE upload_id = ".$upload_id);
			}
		}
		
		$this->create_managers_hierarchy($upload_id);

		// Performance Testing By Ravi
		//$this->db->insert("tbl_audit_log", array("process"=>"Tenures Created End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s")));

		$response = $this->db->select("COUNT(*) AS new_users_cnts FROM login_user lu WHERE lu.upload_id = ".$upload_id)->get()->row_array();
		/*$response["error_data"] = $this->db->select($fields.",error_msg,error_field")->from($table_name)->where("is_error = 1")->get()->result_array();

		$this->load->dbforge();
		$this->dbforge->drop_table($table_name,TRUE);
  		$this->db->insert("tbl_audit_log", array("process" => "Drop Temp Table", "upload_id" => $upload_id, "created_on" => date("Y-m-d H:i:s")));*/
		
		$error_data_response = $this->db->select("COUNT(*) AS error_cnts FROM ".$table_name." WHERE is_error = 1")->get()->row_array();
		$response["error_data"] = array("tbl_colmn_str"=>$fields.",error_msg,error_field", "error_cnts"=>$error_data_response["error_cnts"], "tmp_tbl_name"=>$table_name);
		
		if($upload_id>1)
		{
			$this->load->dbforge();
			$this->dbforge->drop_table("temp_upload_data_".($upload_id-1),TRUE);
		}
		return $response;
	}

	public function set_role_for_managers($manager_emails_arr)
	{
		
		$this->db->query("INSERT INTO login_user_history SELECT * FROM login_user WHERE role > 1 AND role < 10 AND  is_manager=0 AND ".CV_BA_NAME_EMP_EMAIL." IN(".implode(",", $manager_emails_arr).")");
        $this->db->query("UPDATE login_user SET is_manager = 1, updatedon = '".date('Y-m-d H:i:s')."', updatedby_proxy = '".$this->session->userdata('proxy_userid_ses')."' WHERE role > 1 AND role < 10 AND  is_manager=0 AND ".CV_BA_NAME_EMP_EMAIL." IN(".implode(",", $manager_emails_arr).")");

		$this->db->query("INSERT INTO login_user_history SELECT * FROM login_user WHERE role >= 11 AND is_manager=0 AND ".CV_BA_NAME_EMP_EMAIL." IN(".implode(",", $manager_emails_arr).")");
        $this->db->query("UPDATE login_user lu SET is_manager = 1, role = 10, updatedon = '".date('Y-m-d H:i:s')."', updatedby_proxy = '".$this->session->userdata('proxy_userid_ses')."' WHERE role >= 11 AND is_manager=0 AND ".CV_BA_NAME_EMP_EMAIL." IN(".implode(",", $manager_emails_arr).")");
	}
	

	public function set_role_for_managers_upload_id($upload_id,$uid)  //used in integration
	{
		$whr = "select DISTINCT(approver_1) as approver FROM login_user WHERE upload_id = {$upload_id} 
		UNION 
		select DISTINCT(approver_2) as approver FROM login_user WHERE upload_id = {$upload_id} 
		UNION
		select DISTINCT(approver_3) as approver FROM login_user WHERE upload_id = {$upload_id} 
		UNION
		select DISTINCT(approver_4) as approver FROM login_user WHERE upload_id = {$upload_id}";
	
		$sql = "INSERT INTO login_user_history SELECT * FROM login_user lu WHERE lu.email IN ({$whr})";
		$this->db->query($sql);
		$sql = " UPDATE login_user lu SET lu.is_manager = 1, lu.updatedon = NOW(), lu.updatedby_proxy = {$uid},lu.updatedby ={$uid}, 
			lu.role = CASE WHEN (lu.role >= 11 OR lu.role IS NULL) THEN 10 ELSE lu.role END WHERE  lu.email IN (${whr});";	  
	   $this->db->query($sql);
	}
	

	
	public function create_managers_hierarchy($upload_id)
	{
		$managers_hierarchy_based_on_dtls = $this->db->select("managers_hierarchy_based_on FROM manage_company WHERE id = '".$this->session->userdata('companyid_ses')."'")->get()->row_array();
		if($managers_hierarchy_based_on_dtls["managers_hierarchy_based_on"] == CV_MANAGERS_HIERARCHY_BY_1ST_MANAGER)
		{
			$this->db->query("UPDATE login_user 
INNER JOIN (SELECT lu.id, lu.email, lu.approver_1 AS M1,
IFNULL(lu1.approver_1,lu.approver_1) AS M2,
IFNULL(IFNULL(lu2.approver_1,lu1.approver_1),lu.approver_1) AS M3,
IFNULL(IFNULL(IFNULL(lu3.approver_1,lu2.approver_1),lu1.approver_1),lu.approver_1) AS M4
FROM login_user lu 
LEFT JOIN login_user AS lu1 ON lu.approver_1 = lu1.email 
LEFT JOIN login_user AS lu2 ON lu1.approver_1 = lu2.email 
LEFT JOIN login_user AS lu3 ON lu2.approver_1 = lu3.email 
) tmp_tbl_manager_dtls ON login_user.id = tmp_tbl_manager_dtls.id
SET login_user.approver_2=tmp_tbl_manager_dtls.M2, login_user.approver_3=tmp_tbl_manager_dtls.M3, login_user.approver_4=tmp_tbl_manager_dtls.M4 WHERE login_user.upload_id = ".$upload_id);
		}
	}

	//********************** New code after removing Datum tbl concept End   ********************//
     public function update_business_attribute_ba_name_by_uploaded_data($fields_val)
     {
      $this->db->update_batch('business_attribute', $fields_val, 'id');
      return true;
     }

     public function update_business_attribute_ba_display_name_by_uploaded_data($fields_val) {

      $this->db->update_batch('business_attribute', $fields_val, 'id');
      return true;
	 }


}
