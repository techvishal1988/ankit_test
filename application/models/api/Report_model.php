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
	
	public function get_paymix_rpt_data($rpt_data_in_modules, $users_list)
    {
        //$query = $this->db->query("select id, display_name, (replace(replace(ba_name, '/', ''), ' ', '')) AS column_names FROM business_attribute WHERE module_name IN(".$rpt_data_in_modules.")");
		$query = $this->db->query("select id, display_name, ba_name FROM business_attribute WHERE module_name IN(".$rpt_data_in_modules.")");
        $ba_head_arr = $query->result_array();
		
		
		$attribu_Data = $this->admin_model->staff_attributes_for_export();
        foreach($attribu_Data as $val)
		{
            if(in_array($val['id'], array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_EDUCATION, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_BA_ID_SPECIAL_CATEGORY, CV_CURRENCY_ID, CV_SUB_SUB_FUNCTION_ID)))
			{
                $qry_str_arr[] = "manage_" . $val['ba_name'] . ".name AS ".$val['ba_name'];
            }
			else
			{
                $qry_str_arr[] = "login_user.".$val['ba_name'];
            }
        }
        $qry_str = implode(",", $qry_str_arr);
		
		$final_arr = array();
		foreach($users_list as $row)
		{
			$temp = array();			
			//$users_dtls = $this->db->select("*")->from("login_user")->where("id = ".$row["id"])->get()->row_array();
			$users_dtls = $this->admin_model->get_staff_Details($qry_str, $row["id"]);
			
			foreach($ba_head_arr as $ba_row)
			{	
				//$d_val = $this->db->select("value")->from("datum")->where("row_num = '".$row["row_num"]."' AND data_upload_id = ".$row["upload_id"]." AND business_attribute_id = ".$ba_row["id"])->get()->row_array();
				//$temp[$ba_row["column_names"]] = array("name"=>$ba_row["display_name"], "value"=>$d_val["value"]);
				$temp[$ba_row["ba_name"]] = $users_dtls[$ba_row["ba_name"]];//$d_val["value"];
			}
			//$tenure_company_val = $this->db->select("tenure_company")->from("login_user")->where("id = ".$row["id"])->get()->row_array();
			$temp["tenure_company"] = $users_dtls["tenure_company"];//$tenure_company_val["tenure_company"];
			//$tenure_role_val = $this->db->select("tenure_role")->from("login_user")->where("id = ".$row["id"])->get()->row_array();
			$temp["tenure_role"] = $users_dtls["tenure_role"];//$tenure_role_val["tenure_role"];			
			$final_arr[] = $temp;
		}		
		//echo "<pre>";print_r($final_arr);die;		
		return $final_arr;
    }
	     
}