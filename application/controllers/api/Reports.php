<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Reports extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->load->library('session', 'encrypt');			
        $this->load->model('api/rule_model');
        $this->load->model('admin_model');
		$this->load->model('api/report_model', 'report_model');
    }
	
    public function paymix_get($data_for=1)
    {
		
		$rpt_data_in_modules = "'employee_full_name', 'employee_first_name', 'email', 'country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function', 'subfunction', 'sub_subfunction', 'designation', 'grade', 'level', 'education', 'critical_talent', 'critical_position', 'special_category', 'currency', 'gender', 'previous_year_rating', 'rating', 'performance_achievement'";
		
		if($data_for == 2)
		{
			$rpt_data_in_modules .= ", 'talent_rating'";
		}
		else
		{
			$rpt_data_in_modules .= ", 'salary', 'bonus_applied_on'";
		}
		//********* Start : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		$arr = "login_user.role > 2 AND login_user.status != 2 ";		
		$hr_emps_arr = "";
		$hr_emps_data_arr = "";
		if($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9)//HR Type of Users
		{	
			$hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}			
		}
		elseif($this->session->userdata('role_ses') == 10)//Manager Type of Users
		{
			$hr_emps_data_arr = HLP_get_manager_emps_arr($this->session->userdata('email_ses'));
			if(!$hr_emps_data_arr)
			{
				$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$hr_emps_data_arr
					);
				$this->set_response($rdata, REST_Controller::HTTP_OK);
				exit;	
			}
		}
		
		if($hr_emps_data_arr)
		{
			$hr_emps_arr = $this->rule_model->array_value_recursive("id", $hr_emps_data_arr);		
			if(count($hr_emps_arr)>1)
			{
				$arr .= " AND login_user.id in (".implode(",", $hr_emps_arr).")";
			}
			else
			{
				$arr .= " AND login_user.id in (".$hr_emps_arr.")";
			}	
		}
		//********* End : If logged in user is HR/MAnager then get HR/Manager Emps to show report  ********//
		
		if($this->session->userdata('keyword'))
		{
			if($arr)
			{
				$arr .= " AND ";
			}
			$arr .= "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}

		$data['keyword'] =	$this->session->userdata('keyword');
		$this->session->unset_userdata('keyword');		
		$users_list = $this->admin_model->get_table("login_user", "id, upload_id", $arr);
		
		$staff_list= $this->report_model->get_paymix_rpt_data($rpt_data_in_modules, $users_list);
		//echo "<pre>";print_r($data);die;
		
		$rdata=array(
					"status" => "success",
					"statusCode" => 200,
					"data" =>$staff_list
					);
		$this->set_response($rdata, REST_Controller::HTTP_OK);
    }
}
