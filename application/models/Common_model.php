<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
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


public function send_emails($mail_from="", $mail_to="", $subject="", $mail_body="",$email_config1,$mail_fromname="")
	{
		return true;
		// print_r($email_config1);
		// exit;
// 		$protocol=$email_config1['protocol'];
// 		$smtp_host=$email_config1['smtp_host'];
// 		$smtp_port=$email_config1['smtp_port'];
// 		$smtp_user=$email_config1['smtp_user'];
// 		$smtp_pass= $email_config1['smtp_pass'];
// 		$smtp_crypto=strtolower($email_config1['smtp_crypto']);


// 		$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
// 		$email_subject='Testing Email';
// 		$email_config["protocol"] = $protocol;
// 		$email_config["smtp_host"] = $smtp_host;
// 		$email_config["smtp_port"] =  $smtp_port;
// 		$email_config["smtp_user"] = $smtp_user;
// 		$email_config["smtp_pass"] = $smtp_pass;
// 		$email_config["smtp_crypto"] = $smtp_crypto;
// 		$this->load->library('email');
// 		$this->email->initialize($email_config);
// 		$this->load->library('email', $email_config);
//         $this->email->set_newline("\r\n");
// // $this->email->from('info@compport.com', "Compport");
// // $this->email->to(array('rahultitbhopal07@gmail.com','jaiprakash201019@gmail.com','ravi.singroli@compport.com','rakesh.saoji@compport.com'));
// 		$this->email->from($mail_from,$mail_fromname);
// 		$this->email->to($mail_to);
// 		$this->email->bcc('rahultitbhopal07@gmail.com');
// 		$this->email->bcc('jaiprakash201019@gmail.com');
// 		$this->email->subject($subject);
// 		$this->email->message($mail_body);
// 		$this->email->send();
// 		echo $this->email->print_debugger();
// 		$this->email->clear();
	
	} 

	public function send_emails_from_corn_job($mail_from="", $mail_to="", $subject="", $mail_body="",$email_config1,$mail_fromname="")
	{
		// print_r($email_config1);
		// exit;
		$protocol=$email_config1['protocol'];
		$smtp_host=$email_config1['smtp_host'];
		$smtp_port=$email_config1['smtp_port'];
		$smtp_user=$email_config1['smtp_user'];
		$smtp_pass= $email_config1['smtp_pass'];
		$smtp_crypto=strtolower($email_config1['smtp_crypto']);


		$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
		$email_subject='Testing Email';
		$email_config["protocol"] = $protocol;
		$email_config["smtp_host"] = $smtp_host;
		$email_config["smtp_port"] =  $smtp_port;
		$email_config["smtp_user"] = $smtp_user;
		$email_config["smtp_pass"] = $smtp_pass;
		$email_config["smtp_crypto"] = $smtp_crypto;
		$this->load->library('email');
		$this->email->initialize($email_config);
		$this->load->library('email', $email_config);
        $this->email->set_newline("\r\n");
// $this->email->from('info@compport.com', "Compport");
// $this->email->to(array('rahultitbhopal07@gmail.com','jaiprakash201019@gmail.com','ravi.singroli@compport.com','rakesh.saoji@compport.com'));
		$this->email->from($mail_from,$mail_fromname);
		$this->email->to($mail_to);
		
		//$this->email->bcc('jaiprakash201019@gmail.com');
		$this->email->subject($subject);
		$this->email->message($mail_body);
		return $this->email->send();
		//echo $this->email->print_debugger();
		$this->email->clear();
	
	} 


	public function send_emails_new($mail_from="", $mail_to="", $subject="", $mail_body="",$email_config1,$mail_fromname="")
	{
		// print_r($email_config1);
		// exit;
		$protocol=$email_config1['protocol'];
		$smtp_host=$email_config1['smtp_host'];
		$smtp_port=$email_config1['smtp_port'];
		$smtp_user=$email_config1['smtp_user'];
		$smtp_pass= $email_config1['smtp_pass'];
		$smtp_crypto=strtolower($email_config1['smtp_crypto']);


		$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
		$email_subject='Testing Email';
		$email_config["protocol"] = $protocol;
		$email_config["smtp_host"] = $smtp_host;
		$email_config["smtp_port"] =  $smtp_port;
		$email_config["smtp_user"] = $smtp_user;
		$email_config["smtp_pass"] = $smtp_pass;
		$email_config["smtp_crypto"] = $smtp_crypto;
		$this->load->library('email');
		$this->email->initialize($email_config);
		$this->load->library('email', $email_config);
        $this->email->set_newline("\r\n");

		$this->email->from($mail_from,$mail_fromname);
		$this->email->to($mail_to);
		//$this->email->bcc('jaiprakash201019@gmail.com');
		$this->email->subject($subject);
		$this->email->message($mail_body);
		$this->email->send();
		//echo $this->email->print_debugger();
		$this->email->clear();
	
	} 


	public function check_role_permissions($role_id, $page_id)
	{	
		if($role_id==1)
		{
			return array("role_id"=>$role_id, "view"=>1,"insert"=>1, "update"=>1, "delete"=>1);
		}	

		$this->db->select("role_permissions.*");
		$this->db->join("pages", "pages.id = role_permissions.page_id");
		$this->db->where(array("role_permissions.role_id"=> $role_id, "role_permissions.page_id"=> $page_id, "pages.status"=>1));		
		return $this->db->from("role_permissions")->get()->row_array();
	}
	
	public function set_permissions_session_arr()
	{	
		$this->db->select("role_permissions.*");
		$this->db->join("pages", "pages.id = role_permissions.page_id");
		if($this->session->userdata('role_ses') <10 and $this->session->userdata('is_manager_ses')==1)
		{
			$this->db->where("(role_permissions.role_id = ". $this->session->userdata('role_ses')." OR role_permissions.role_id = 10) AND pages.status = 1");		
		}
		else
		{
			$this->db->where(array("role_permissions.role_id"=> $this->session->userdata('role_ses'), "pages.status"=>1));		
		}
		$data = $this->db->from("role_permissions")->get()->result_array();
		$view_arr = $insert_arr = $update_arr = $delete_arr = array();
		$hr_usr_ids = "";
		if($data)
		{
			foreach($data as $row)
			{
				if($row['view']==1)
				{
					$view_arr[] = $row['page_id'];
				}
				if($row['insert']==1)
				{
					$insert_arr[] = $row['page_id'];
				}
				if($row['update']==1)
				{
					$update_arr[] = $row['page_id'];
				}
				if($row['delete']==1)
				{
					$delete_arr[] = $row['page_id'];
				}
			}
		}
		
		
		if($this->session->userdata('role_ses') > 1 and $this->session->userdata('role_ses') < 10)
		{
			$hr_usr_ids_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'), 1);
			if($hr_usr_ids_arr)
			{
				$hr_usr_ids = $hr_usr_ids_arr["usr_ids"];
			}
		}
		
		$ses_arr = array("view_rights_arr_ses"=>$view_arr, "insert_rights_arr_ses"=>$insert_arr, "update_rights_arr_ses"=>$update_arr, "delete_rights_arr_ses"=>$delete_arr, "hr_usr_ids_ses"=>$hr_usr_ids);
		$this->session->set_userdata($ses_arr);
	}

	/*public function get_value_coma_seprated($data_arr, $col_name)
	{
		$str = "";
		if(count($data_arr)==1)
		{
			$str = $data_arr[0][$col_name];
		}
		elseif(count($data_arr)>1)
		{
			$str = implode(",",$this->array_value_recursive($col_name, $data_arr));
		}
		return $str;
	}*/
	
	public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}

	public function get_table($table, $fields, $condition_arr, $order_by = "id", $group_by = "") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}

		if($group_by)
		{
			$this->db->group_by($group_by);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->result_array();		
	}
	
	public function get_data_in_key_val_format($tbl, $key_col_name, $val_col_name, $cnd_arr, $order_by = "id")
	{
		$this->db->select("CONCAT(\"{\", GROUP_CONCAT('\"',UPPER(".$key_col_name."),'\":', '\"',".$val_col_name.",'\"'), \"}\") AS json_obj");		
        $this->db->from($tbl);
		if($cnd_arr)
		{
			$this->db->where($cnd_arr);
		}
		$this->db->order_by($order_by);
		$data = $this->db->get()->row_array();
		return json_decode($data["json_obj"], true);
	}

	public function get_user_rights_comma_seprated($table_name,$col_name,$condition_arr,$master_table_name)
	{
		$data_arr = array();
		$data_arr = $this->get_table($table_name, $col_name, $condition_arr);
		if(count($data_arr)==1 and $data_arr[0][$col_name]=="0")
		{
			$data_arr = $this->get_table($master_table_name, "id as $col_name", array("status"=>1));
		}		

		$str = "";
		if(count($data_arr)==1)
		{
			$str = $data_arr[0][$col_name];
		}
		elseif(count($data_arr)>1)
		{
			$str = implode(",",$this->array_value_recursive($col_name, $data_arr));
		}
		return $str;
	}
	
	public function get_users_for_proxy_NIU($term,$condition_arr)
    {   
        //print_r($this->session->userdata('role_ses'));    
        //$query = $this->db->query("SELECT email as value FROM login_user WHERE status=1 AND role > ".$this->session->userdata('proxy_role_ses')." AND role <= 11 and id != ".$this->session->userdata('userid_ses')." AND email LIKE '%".$term."%' ");
        if($this->session->userdata('role_ses')==10)
        {
            $query = $this->db->query("SELECT lusr.email as value FROM login_user lusr join row_owner rw on rw.user_id=lusr.id WHERE lusr.status=1 AND lusr.role > ".$this->session->userdata('proxy_role_ses')." AND lusr.role <= 11 and lusr.id != ".$this->session->userdata('userid_ses')." AND lusr.email LIKE '%".$term."%' and rw.first_approver='".$this->session->userdata('email_ses')."' or rw.second_approver='".$this->session->userdata('email_ses')."' or rw.third_approver='".$this->session->userdata('email_ses')."' or rw.fourth_approver='".$this->session->userdata('email_ses')."' group by lusr.email");    
        }
        else if($this->session->userdata('role_ses')==3)
            {
            $this->db->select("login_user.email as value");
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		$this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user.business_level_1_id","left");
		$this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user.business_level_2_id","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
                //echo $condition_arr; die;
                //login_user.role > 1 and login_user.status = 1 and login_user.country_id in (1,2) and login_user.city_id in (1) and login_user.business_level_1_id in (1) and login_user.business_level_2_id in (1) and login_user.business_level_3_id in (1) and login_user.function_id in (1,2,3,4,5,6,7) and login_user.sub_function_id in (1,2,3,4,5,6,7) and login_user.desig in (1,2,3,4,5,6,7) and login_user.grade in (1,2,3,4)
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where(array("login_user.manage_hr_only"=>0));//Taking only company Emp
                $this->db->like('login_user.email', $term);
		$query= $this->db->from("login_user")->get();
                //echo $this->db->last_query(); die;
        }
        else {
             $query = $this->db->query("SELECT email as value FROM login_user WHERE status=1 AND role > ".$this->session->userdata('proxy_role_ses')." AND role <= 11 and id != ".$this->session->userdata('userid_ses')." AND email LIKE '%".$term."%' ");
        }
//       echo $this->db->last_query(); die;
        echo json_encode($query->result_array());
    }
	
	public function get_users_for_proxy($term,$condition_arr)
    {
        if($this->session->userdata('role_ses')==10)
        {
            $query = $this->db->query("SELECT lusr.".CV_BA_NAME_EMP_EMAIL." AS value FROM login_user lusr WHERE lusr.status=1 AND lusr.role > ".$this->session->userdata('proxy_role_ses')." AND lusr.role <= 11 and lusr.id != ".$this->session->userdata('userid_ses')." AND lusr.email LIKE '%".$term."%' AND (lusr.".CV_BA_NAME_APPROVER_1." = '".$this->session->userdata('email_ses')."' OR lusr.".CV_BA_NAME_APPROVER_2." = '".$this->session->userdata('email_ses')."' OR lusr.".CV_BA_NAME_APPROVER_3." = '".$this->session->userdata('email_ses')."' OR lusr.".CV_BA_NAME_APPROVER_4." = '".$this->session->userdata('email_ses')."') GROUP BY lusr.".CV_BA_NAME_EMP_EMAIL);    
        }
        else if($this->session->userdata('role_ses') > 1 and $this->session->userdata('role_ses') < 10)
        {			
			
			if($this->session->userdata('hr_usr_ids_ses'))
			{
				$hr_usr_ids_ses = $this->session->userdata('hr_usr_ids_ses');
				$this->db->simple_query('SET SESSION group_concat_max_len=9999999');
				$hr_emps_1st_approver_arr = $this->db->select("GROUP_CONCAT(CONCAT(id) SEPARATOR ',') AS usr_ids")->where("login_user.".CV_BA_NAME_EMP_EMAIL." IN (SELECT DISTINCT(lusr.".CV_BA_NAME_APPROVER_1.") FROM login_user lusr WHERE lusr.id IN (".$this->session->userdata('hr_usr_ids_ses')."))")->get("login_user")->row_array();
				if($hr_emps_1st_approver_arr["usr_ids"])
				{
					$hr_usr_ids_ses .=  ", ".$hr_emps_1st_approver_arr["usr_ids"];
				}			
				$this->db->where("login_user.status = 1 AND login_user.id IN (".$hr_usr_ids_ses.")");
			}
			$this->db->select("login_user.".CV_BA_NAME_EMP_EMAIL." AS value");
			$this->db->where(array("login_user.manage_hr_only"=>0));//Taking only company Emp
			if($condition_arr)
			{
				$this->db->where($condition_arr);
			}
			$this->db->like('login_user.'.CV_BA_NAME_EMP_EMAIL, $term);
			$query= $this->db->from("login_user")->get();
        }
        else
		{
             $query = $this->db->query("SELECT ".CV_BA_NAME_EMP_EMAIL." AS value FROM login_user WHERE status=1 AND role > ".$this->session->userdata('proxy_role_ses')." AND role <= 11 AND id != ".$this->session->userdata('userid_ses')." AND ".CV_BA_NAME_EMP_EMAIL." LIKE '%".$term."%' ");
        }
        echo json_encode($query->result_array());
    }
	
	public function get_employee_dtls_by_datum_tbl($condition_arr)
	{		
		$this->db->select("MAX(CASE WHEN `business_attribute_id` = 73 THEN `value` END) AS company_name,
MAX(CASE WHEN `business_attribute_id` = 1 THEN `value` END) AS emp_name,
MAX(CASE WHEN `business_attribute_id` = 168 THEN `value` END) AS emp_first_name,
MAX(CASE WHEN `business_attribute_id` = 2 THEN `value` END) AS email_id,
MAX(CASE WHEN `business_attribute_id` = 135 THEN `value` END) AS gender,
MAX(CASE WHEN `business_attribute_id` = 3 THEN `value` END) AS country,
MAX(CASE WHEN `business_attribute_id` = 4 THEN `value` END) AS city,
MAX(CASE WHEN `business_attribute_id` = 5 THEN `value` END) AS business_level_1,
MAX(CASE WHEN `business_attribute_id` = 6 THEN `value` END) AS business_level_2,
MAX(CASE WHEN `business_attribute_id` = 7 THEN `value` END) AS business_level_3,
MAX(CASE WHEN `business_attribute_id` = 10 THEN `value` END) AS designation,
MAX(CASE WHEN `business_attribute_id` = 8 THEN `value` END) AS function,
MAX(CASE WHEN `business_attribute_id` = 9 THEN `value` END) AS sub_function,
MAX(CASE WHEN `business_attribute_id` = 136 THEN `value` END) AS sub_sub_function,
MAX(CASE WHEN `business_attribute_id` = 11 THEN `value` END) AS grade,
MAX(CASE WHEN `business_attribute_id` = 12 THEN `value` END) AS level,
MAX(CASE WHEN `business_attribute_id` = 13 THEN `value` END) AS education,
MAX(CASE WHEN `business_attribute_id` = 14 THEN `value` END) AS critical_talent,
MAX(CASE WHEN `business_attribute_id` = 15 THEN `value` END) AS critical_position,
MAX(CASE WHEN `business_attribute_id` = 16 THEN `value` END) AS special_category,
MAX(CASE WHEN `business_attribute_id` = 22 THEN `value` END) AS recently_promoted,
MAX(CASE WHEN `business_attribute_id` = 24 THEN `value` END) AS rating_for_this_fiscal_year,
MAX(CASE WHEN `business_attribute_id` = 35 THEN `value` END) AS currency,
MAX(CASE WHEN `business_attribute_id` = 36 THEN `value` END) AS current_base_salary,
MAX(CASE WHEN `business_attribute_id` = 38 THEN `value` END) AS allowance_1,
MAX(CASE WHEN `business_attribute_id` = 39 THEN `value` END) AS allowance_2,
MAX(CASE WHEN `business_attribute_id` = 40 THEN `value` END) AS allowance_3,
MAX(CASE WHEN `business_attribute_id` = 41 THEN `value` END) AS allowance_4,
MAX(CASE WHEN `business_attribute_id` = 42 THEN `value` END) AS allowance_5,
MAX(CASE WHEN `business_attribute_id` = 43 THEN `value` END) AS allowance_6,
MAX(CASE WHEN `business_attribute_id` = 44 THEN `value` END) AS allowance_7,
MAX(CASE WHEN `business_attribute_id` = 45 THEN `value` END) AS allowance_8,
MAX(CASE WHEN `business_attribute_id` = 46 THEN `value` END) AS allowance_9,
MAX(CASE WHEN `business_attribute_id` = 47 THEN `value` END) AS allowance_10,
MAX(CASE WHEN `business_attribute_id` = 138 THEN `value` END) AS allowance_11,
MAX(CASE WHEN `business_attribute_id` = 139 THEN `value` END) AS allowance_12,
MAX(CASE WHEN `business_attribute_id` = 140 THEN `value` END) AS allowance_13,
MAX(CASE WHEN `business_attribute_id` = 141 THEN `value` END) AS allowance_14,
MAX(CASE WHEN `business_attribute_id` = 142 THEN `value` END) AS allowance_15,
MAX(CASE WHEN `business_attribute_id` = 143 THEN `value` END) AS allowance_16,
MAX(CASE WHEN `business_attribute_id` = 144 THEN `value` END) AS allowance_17,
MAX(CASE WHEN `business_attribute_id` = 145 THEN `value` END) AS allowance_18,
MAX(CASE WHEN `business_attribute_id` = 146 THEN `value` END) AS allowance_19,
MAX(CASE WHEN `business_attribute_id` = 147 THEN `value` END) AS allowance_20,
MAX(CASE WHEN `business_attribute_id` = 21 THEN `value` END) AS bonus_incentive_applicable,
MAX(CASE WHEN `business_attribute_id` = 37 THEN `value` END) AS current_target_bonus,
MAX(CASE WHEN `business_attribute_id` = 48 THEN `value` END) AS total_compensation,
MAX(CASE WHEN `business_attribute_id` = 18 THEN `value` END) AS joining_date_for_increment_purposes,
MAX(CASE WHEN `business_attribute_id` = 17 THEN `value` END) AS joining_date_the_company,
MAX(CASE WHEN `business_attribute_id` = 19 THEN `value` END) AS start_date_for_role,
MAX(CASE WHEN `business_attribute_id` = 20 THEN `value` END) AS end_date_the_role,
MAX(CASE WHEN `business_attribute_id` = 64 THEN `value` END) AS approver_1,
MAX(CASE WHEN `business_attribute_id` = 65 THEN `value` END) AS approver_2,
MAX(CASE WHEN `business_attribute_id` = 66 THEN `value` END) AS approver_3,
MAX(CASE WHEN `business_attribute_id` = 67 THEN `value` END) AS approver_4,
MAX(CASE WHEN `business_attribute_id` = 68 THEN `value` END) AS manager_name,
MAX(CASE WHEN `business_attribute_id` = 69 THEN `value` END) AS authorised_signatory_for_letter,
MAX(CASE WHEN `business_attribute_id` = 70 THEN `value` END) AS authorised_signatory_title_for_letter,
MAX(CASE WHEN `business_attribute_id` = 71 THEN `value` END) AS hr_authorised_signatory_for_letter,
MAX(CASE WHEN `business_attribute_id` = 72 THEN `value` END) AS hr_authorised_signatory_title_for_letter");
		$this->db->from("datum");		
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->group_by("row_num");
		return $this->db->get()->row_array();
	}


################ Kingjuliean Work ##########################		
	public function getEmailTemplate($emailTemplateId)
		{
			return $this->db->query("SELECT * FROM email_templates as et JOIN email_target_point as etp on etp.target_point_id=et.target_point_id where et.status=1 and etp.target_point='".$emailTemplateId."'")->result();
		}

		public function updatePassword($id,$password)
		{
			return $this->db->query("UPDATE login_user set pass='".md5($password)."' where id='".$id."'");
		}

		public function getTableAttributes($cond)
		{
			return $this->db->query("SELECT * from table_attribute ".$cond)->result();
			 //$this->db->query('module_name',$module)->where('status',1)->get('table_attribute')->order_by('col_attributes_order','asc')->result();
		}

		public function getEmailTemplateList()
		{
			return $this->db->query("SELECT * FROM email_templates as et JOIN email_target_point as etp on etp.target_point_id=et.target_point_id where et.status=1")->result();
		}

		public function getTriggerPoints($id='')
		{

			if($id!='')
			{
return $this->db->query("SELECT * from email_target_point WHERE status=1 ")->result();
			}else
			{
			return $this->db->query("SELECT * from email_target_point WHERE target_point_id NOT IN(SELECT et.target_point_id FROM email_target_point as etp JOIN email_templates as et on etp.target_point_id=et.target_point_id) and status=1 ")->result();	
			}
			

		}


	/**
	 * Send individual mail to user in the real time
	*/
	public function send_individual_mail(array $data_array)
	{
		if(empty($data_array)) {
			return false;
		}

		$company_id 	= !empty($data_array['company_id']) ? (int)$data_array['company_id'] : 0;
		$user_id 		= !empty($data_array['user_id']) ? (int)$data_array['user_id'] : 0;
		$user_name 		= !empty($data_array['user_name']) ? trim($data_array['user_name']) : '';
		$mail_to 		= !empty($data_array['mail_to']) ? trim($data_array['mail_to']) : '';
		$mail_subject 	= !empty($data_array['mail_subject']) ? trim($data_array['mail_subject']) : '';
		$mail_body 		= !empty($data_array['mail_body']) ? trim($data_array['mail_body']) : '';


		if(empty($company_id) ||
			empty($user_id) ||
			empty($user_name) ||
			empty($mail_to) ||
			empty($mail_subject) ||
			empty($mail_body)) {

			return false;
		}

		$mail_body 			= stripslashes($mail_body);
		$email_config_info	= HLP_GetSMTP_Details($data_array['company_id']);

		if(empty($email_config_info['result']) ||
			empty($email_config_info['email_from']) ||
			empty($email_config_info['mail_fromname'])) {

				return false;
		}

		$mail_from 		= !empty($email_config_info['email_from']) ? trim($email_config_info['email_from']) : '';
		$mail_fromname 	= !empty($email_config_info['mail_fromname']) ? trim($email_config_info['mail_fromname']) : '';

		$email_config_det	= $email_config_info['result'];


		if(	empty($mail_from) ||
			empty($mail_fromname) ||
			empty($email_config_det['protocol']) ||
			empty($email_config_det['smtp_host']) ||
			empty($email_config_det['smtp_port']) ||
			empty($email_config_det['smtp_user']) ||
			empty($email_config_det['smtp_pass']) ||
			empty($email_config_det['smtp_crypto']) ) {

				return false;
		}

		$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
		$email_config["protocol"] 		= $email_config_det['protocol'];
		$email_config["smtp_host"] 		= $email_config_det['smtp_host'];
		$email_config["smtp_port"] 		= $email_config_det['smtp_port'];
		$email_config["smtp_user"] 		= $email_config_det['smtp_user'];
		$email_config["smtp_pass"] 		= $email_config_det['smtp_pass'];
		$email_config["smtp_crypto"] 	= strtolower($email_config_det['smtp_crypto']);

		$this->load->library('email', $email_config);
		$this->email->set_newline("\r\n");

		$this->email->from($mail_from,$mail_fromname);
		$this->email->to($mail_to);
		$this->email->subject($mail_subject);
		$this->email->message($mail_body);
		$rslt = $this->email->send();
		$this->email->clear();

		if($rslt) {//insert entry into sent_mail_new_approver

			$batchItemsQueueInsertData 	  = array();
			$key = 0;
			$currentTime = date("Y-m-d H:i:s",time());

			//set cron_mail_queue table data
			$batchItemsQueueInsertData[$key]['q_id']	  		= 0;//for direct mail
			$batchItemsQueueInsertData[$key]['user_id']	  		= $user_id;
			$batchItemsQueueInsertData[$key]['name']	  		= $user_name;
			$batchItemsQueueInsertData[$key]['email']	  		= $mail_to;
			$batchItemsQueueInsertData[$key]['status']			= 1;//mail send
			$batchItemsQueueInsertData[$key]['priority_level']	= 1;
			$batchItemsQueueInsertData[$key]['email_from'] 		= $mail_from;
			$batchItemsQueueInsertData[$key]['email_from_name']	= $mail_fromname;
			$batchItemsQueueInsertData[$key]['email_subject'] 	= $mail_subject;
			$batchItemsQueueInsertData[$key]['email_content']	= addslashes($mail_body);
			$batchItemsQueueInsertData[$key]['createdon']		= $currentTime;
			$batchItemsQueueInsertData[$key]['updatedon']	  	= $currentTime;

			if(!empty($batchItems['email_cc']) && is_array($batchItems['email_cc'])) {
				$batchItemsQueueInsertData[$key]['email_cc'] = json_encode($batchItems['email_cc']);
			}

			if(!empty($batchItems['email_bcc']) && is_array($batchItems['email_bcc'])) {
				$batchItemsQueueInsertData[$key]['email_bcc'] = json_encode($batchItems['email_bcc']);
			}

			$this->set_mail_data($batchItemsQueueInsertData);

		}

		return $rslt;
	}


	public function set_mail_data($batchItemsQueueInsertData) {

		if(count($batchItemsQueueInsertData) == 0){ return;}

		$total_insert_rows = $this->db->insert_batch('sent_mail_new_approver', $batchItemsQueueInsertData);

	}
}