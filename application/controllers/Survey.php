<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller 
{	 
	 public function __construct()
	 {		
            parent::__construct();
            date_default_timezone_set('Asia/Calcutta');
            $this->load->helper(array('form', 'url', 'date'));
            $this->load->library('form_validation');
            $this->load->library('session', 'encrypt');	
            $this->load->model("common_model");
            $this->load->model("Survey_model");
			$this->load->model('admin_model');
			$this->lang->load('message', 'english');
            HLP_is_valid_web_token();                 
    }

    public function getQuestion(){
    	echo json_encode(getQuestion());
    }
    public function index()
    {
    	// echo "<pre>";
    	// print_r($this->session->userdata());
    	// die;
        $data['title'] = 'Survey Management';
		$data['body'] = 'survey/dashboard';
		$this->load->view('common/structure',$data);
    }

    
    function ready_to_launch_survey() {
    	if(!helper_have_rights(CV_SURVEY, CV_VIEW_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>';		
            redirect(site_url("dashboard"));
		}
		$data['adminCategory'] = $this->Survey_model->getAdminCategory('category');


		$data['survey'] = $this->Survey_model->getAdminSurvey('survey',array('status'=> CV_STATUS_ACTIVE, 'is_published > ' => 0));
		// echo "<pre>";
		// print_r($data);
		// die;
		$data['title'] = 'Survey';
		$data['body'] = 'survey/ready_to_launch_survey';

		$this->load->view('common/structure',$data);
	}

    public function dashboard_analytics($type="",$pageno=1) {

    	if(!helper_have_rights(CV_SURVEY, CV_VIEW_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>';		
            redirect(site_url("dashboard"));
		}
		
		$data['title'] = 'Survey Analytics Dashboard';
		$data['count_progress_company'] = $this->Survey_model->latest_company_survey(array('is_published' => 0));
		$data['count_lunch_company'] = $this->Survey_model->latest_company_survey(array('is_published > ' => 0, 'is_published < ' => 3));
		$data['count_completed_company'] = $this->Survey_model->latest_company_survey(array('is_published' => 3));

		// load Pagination library
        $limit_per_page = 10;
        $num_links = 2;
        if(empty($pageno)){$pageno=1;}
        $offset = ($pageno-1) * $limit_per_page;
		if(empty($type)){ $type="draft"; }
		$data['currenttab'] = $type;
		$data['currentindex'] = ($offset+1);
        $count_progress_company = count($data['count_progress_company']);
        if ( $count_progress_company > 0 ) 
        {
        	if($type=="draft" && $count_progress_company > $limit_per_page){
            	$data['progress_company_survey'] = $this->Survey_model->latest_company_survey(array('is_published' => 0), $limit_per_page, $offset);
            	$data["links_progress"] = HLP_Pagination(base_url() . 'survey/dashboard-analytics/draft', $count_progress_company, $pageno, $limit_per_page,$num_links);
        	}else{
        		$data['progress_company_survey'] = $this->Survey_model->latest_company_survey(array('is_published' => 0), $limit_per_page, 0);
        		$data["links_progress"] = HLP_Pagination(base_url() . 'survey/dashboard-analytics/draft', $count_progress_company, 1, $limit_per_page,$num_links);
        	}
        }

        $count_lunch_company = count($data['count_lunch_company']);
        if ( $count_lunch_company > 0 ) 
        {
        	if($type=="launch" && $count_lunch_company > $limit_per_page){
            	$data['lunch_company_survey'] = $this->Survey_model->latest_company_survey(array('is_published > ' => 0, 'is_published < ' => 3), $limit_per_page, $offset);
            	$data["links_lunch"] = HLP_Pagination(base_url() . 'survey/dashboard-analytics/launch', $count_lunch_company, $pageno, $limit_per_page,$num_links);
        	}else{
        		$data['lunch_company_survey'] = $this->Survey_model->latest_company_survey(array('is_published > ' => 0, 'is_published < ' => 3), $limit_per_page, 0);
        		$data["links_lunch"] = HLP_Pagination(base_url() . 'survey/dashboard-analytics/launch', $count_lunch_company, 1, $limit_per_page,$num_links);
        	}
        }

        $count_completed_company = count($data['count_completed_company']);
        if ( $count_completed_company > 0 ) 
        {
        	if($type=="completed" && $count_completed_company > $limit_per_page){
            	$data['completed_company_survey'] = $this->Survey_model->latest_company_survey(array('is_published' => 3), $limit_per_page, $offset);
            	$data["links_completed"] = HLP_Pagination(base_url() . 'survey/dashboard-analytics/completed', $count_completed_company, $pageno, $limit_per_page,$num_links);
        	}else{
        		$data['completed_company_survey'] = $this->Survey_model->latest_company_survey(array('is_published' => 3), $limit_per_page, 0);
        		$data["links_completed"] = HLP_Pagination(base_url() . 'survey/dashboard-analytics/completed', $count_completed_company, 1, $limit_per_page,$num_links);
        	}
        }

        if(empty($data['progress_company_survey']) && empty($data['lunch_company_survey']) && empty($data['completed_company_survey'])){
        	$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_empty_list_survey').' </b></div>');
        	redirect(site_url("survey/create"));
        }

        $data['body'] = 'survey/dashboard_analytics';
		$this->load->view('common/structure',$data);
	}

    public function survey_filters($surveyID='',$withoutview="")
    {
    	

		if(empty($surveyID)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_found_survey').'</b></div>');
			redirect(base_url('survey/create'));
		}		

		if(!helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></div>';		
			redirect(site_url("dashboard"));
		}

		$data['survey']=$this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);

		$data["msg"] = "";
		$user_id = $this->session->userdata('userid_ses');
		$data['right_dtls'] = $this->common_model->get_table("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");


		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");

		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
		$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
		$data['education_list'] = $this->common_model->get_table("manage_education","id, name", "status = 1", "name asc");
		$data['critical_talent_list'] = $this->common_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
		$data['critical_position_list'] = $this->common_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
		$data['special_category_list'] = $this->common_model->get_table("manage_special_category","id, name", "status = 1", "name asc");

		if($this->input->post())
		{	
			if(!$this->input->post("hf_select_all_filters"))
			{					
				if(in_array('all', $this->input->post("ddl_country")))
				{
					$country_arr =$country_arr_view;				
				}
				else
				{
					$country_arr = implode(",",$this->input->post("ddl_country"));
				}

				if(in_array('all', $this->input->post("ddl_city")))
				{
					$city_arr = $city_arr_view;
				}
				else
				{
					$city_arr = implode(",",$this->input->post("ddl_city"));
				}

				if(in_array('all', $this->input->post("ddl_bussiness_level_1")))
				{
					$bussiness_level_1_arr = $bl1_arr_view;				
				}
				else
				{
					$bussiness_level_1_arr=implode(",",$this->input->post("ddl_bussiness_level_1"));
				}

				if(in_array('all', $this->input->post("ddl_bussiness_level_2")))
				{
					$bussiness_level_2_arr = $bl2_arr_view;				
				}
				else
				{
					$bussiness_level_2_arr=implode(",",$this->input->post("ddl_bussiness_level_2"));
				}

				if(in_array('all', $this->input->post("ddl_bussiness_level_3")))
				{
					$bussiness_level_3_arr = $bl3_arr_view;				
				}
				else
				{
					$bussiness_level_3_arr=implode(",",$this->input->post("ddl_bussiness_level_3"));
				}

				if(in_array('all', $this->input->post("ddl_function")))
				{
					$function_arr = $function_arr_view;
				}
				else
				{
					$function_arr = implode(",",$this->input->post("ddl_function"));
				}

				if(in_array('all', $this->input->post("ddl_sub_function")))
				{
					$sub_function_arr = $sub_function_arr_view;
				}
				else
				{
					$sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
				}

				if(in_array('all', $this->input->post("ddl_designation")))
				{
					$designation_arr = $designation_arr_view;
				}
				else
				{
					$designation_arr = implode(",",$this->input->post("ddl_designation"));
				}

				if(in_array('all', $this->input->post("ddl_grade")))
				{
					$grade_arr = $grade_arr_view;
				}
				else
				{
					$grade_arr = implode(",",$this->input->post("ddl_grade"));
				}

				if(in_array('all', $this->input->post("ddl_level")))
				{
					$level_arr = $level_arr_view;
				}
				else
				{
					$level_arr = implode(",",$this->input->post("ddl_level"));
				}

				if(in_array('all', $this->input->post("ddl_education")))
				{
					$temp_arr = array();
					$education_arr = "";
					foreach($data['education_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$education_arr = implode(",",$temp_arr);
					}

				}
				else
				{
					$education_arr = implode(",",$this->input->post("ddl_education"));
				}

				if(in_array('all', $this->input->post("ddl_critical_talent")))
				{
					$temp_arr = array();
					$critical_talent_arr = "";
					foreach($data['critical_talent_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$critical_talent_arr = implode(",",$temp_arr);
					}

				}
				else
				{
					$critical_talent_arr = implode(",",$this->input->post("ddl_critical_talent"));
				}

				if(in_array('all', $this->input->post("ddl_critical_position")))
				{
					$temp_arr = array();
					$critical_position_arr = "";
					foreach($data['critical_position_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$critical_position_arr = implode(",",$temp_arr);
					}

				}
				else
				{
					$critical_position_arr = implode(",",$this->input->post("ddl_critical_position"));
				}

				if(in_array('all', $this->input->post("ddl_special_category")))
				{
					$temp_arr = array();
					$special_category_arr = "";
					foreach($data['special_category_list'] as $item_row)
					{
						array_push($temp_arr,$item_row["id"]); 
					}
					if($temp_arr)
					{
						$special_category_arr = implode(",",$temp_arr);
					}

				}
				else
				{
					$special_category_arr = implode(",",$this->input->post("ddl_special_category"));
				}

				if(in_array('all', $this->input->post("ddl_tenure_company")))
				{
					$temp_arr = array();
					for($i=0; $i<=35; $i++)
					{
						array_push($temp_arr,$i); 
					}
					if($temp_arr)
					{
						$tenure_company_arr = implode(",",$temp_arr);
					}

				}
				else
				{
					$tenure_company_arr = implode(",",$this->input->post("ddl_tenure_company"));
				}

				if(in_array('all', $this->input->post("ddl_tenure_role")))
				{
					$temp_arr = array();
					for($i=0; $i<=35; $i++)
					{
						array_push($temp_arr,$i); 
					}
					if($temp_arr)
					{
						$tenure_role_arr = implode(",",$temp_arr);
					}

				}
				else
				{
					$tenure_role_arr = implode(",",$this->input->post("ddl_tenure_role"));
				}
				$where ="login_user.role > 1 and login_user.status = 1";
				if($country_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_COUNTRY." in (".$country_arr.")";
				}

				if($city_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_CITY." in (".$city_arr.")";
				}

				if($bussiness_level_1_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_1." in (".$bussiness_level_1_arr.")";
				}

				if($bussiness_level_2_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_2." in (".$bussiness_level_2_arr.")";
				}

				if($bussiness_level_3_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_3." in (".$bussiness_level_3_arr.")";
				}

				if($function_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_FUNCTION." in (".$function_arr.")";
				}

				if($sub_function_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_SUBFUNCTION." in (".$sub_function_arr.")";
				}

				if($designation_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_DESIGNATION." in (".$designation_arr.")";
				}

				if($grade_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_GRADE." in (".$grade_arr.")";
				}

				if($level_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_LEVEL." in (".$level_arr.")";
				}

				if($education_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_EDUCATION." in (".$education_arr.")";
				}

				if($critical_talent_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_CRITICAL_TALENT." in (".$critical_talent_arr.")";
				}

				if($critical_position_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_CRITICAL_POSITION." in (".$critical_position_arr.")";
				}

				if($special_category_arr)
				{
					$where .= " and login_user.".CV_BA_NAME_SPECIAL_CATEGORY." in (".$special_category_arr.")";
				}

				if($tenure_company_arr)
				{
					$where .= " and login_user.tenure_company in (".$tenure_company_arr.")";
				}

				if($tenure_role_arr)
				{

					$where .= " and login_user.tenure_role in (".$tenure_role_arr.")";

				}

//CB:: Because we have no need to check duplicate emps in a cycle for a rules
/*if($already_created_rule_for_emp_ids)
{
$where .= " and login_user.id not in (".implode(",",$already_created_rule_for_emp_ids).")";
}*/
if($this->input->post('survey_for')=="manager")
{
	$where .= " and login_user.is_manager=1"; 
}
if($this->input->post('survey_for')=="employee")
{
	$where .= " and login_user.is_manager != 1"; 
}
$this->load->model('admin_model');
$user_ids_arr = array();
$data['employees'] = $this->admin_model->get_employees_as_per_rights($where);
$txt_cutoff_dt = $this->input->post("txt_cutoff_dt");
foreach($data['employees'] as $row)
{
	if($txt_cutoff_dt != "")
	{
		$txt_cutoff_dt = date("Y-m-d",strtotime(str_replace("/","-",$txt_cutoff_dt)));							
		$joining_dt = date("Y-m-d",strtotime($row["date_of_joining"]));
		if($row["date_of_joining"] != "" and $joining_dt <= $txt_cutoff_dt)
		{
			$user_ids_arr[] = $row["id"];
		}
	}
	else
	{
		$user_ids_arr[] = $row["id"];
	}
}

if(empty($user_ids_arr)){
	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_user_found_filter_survey').'</b></div>');	
	redirect($_SERVER['HTTP_REFERER']);
}

$usr_ids = implode(",",$user_ids_arr);
$db_arr = array(
	"survey_for"=>$this->input->post('survey_for'),
			// "user_ids" => $usr_ids,
			// "country" => HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY),//$country_arr,
			// "city" => HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY),//$city_arr,
			// "business_level1" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1),//$bussiness_level_1_arr,
			// "business_level2" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2),//$bussiness_level_2_arr,
			// "business_level3" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3),//$bussiness_level_3_arr,
			// "functions" => HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION),//$function_arr,
			// "sub_functions" => HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION),//$sub_function_arr,
			// "designations" => HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION),//$designation_arr,
			// "grades" => HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE),//$grade_arr,
			// "levels" => HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL),//$level_arr,
			// "educations" => HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION),//$education_arr,
			// "critical_talents" => HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT),//$critical_talent_arr,
			// "critical_positions" => HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION),//$critical_position_arr,
			// "special_category" => HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY),//$special_category_arr,
	"tenure_company" => $tenure_company_arr,
	"cutoff_date" => $txt_cutoff_dt,
	"tenure_roles" => $tenure_role_arr,
	"updatedby" => $this->session->userdata('userid_ses'),
	"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
	"updatedon" => date("Y-m-d H:i:s")
);

if(HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY)){
	$db_arr['country'] = HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY);
}
if(HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY)){
	$db_arr['city'] = HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY); 
}

if(HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1)){
	$db_arr['business_level1'] = HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1);
}
if(HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2)){
	$db_arr['business_level2'] = HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2);
}

if(HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3)){
	$db_arr['business_level3'] = HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3);
}

if(HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION)){
	$db_arr['functions'] = HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION);
} 
if(HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION)){
	$db_arr['sub_functions'] = HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION);
}
if(HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION)){
	$db_arr['designations'] = HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION);
}
if(HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE)){
	$db_arr['grades'] = HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE);
}

if(HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL)){
	$db_arr['levels'] = HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL);
}

if(HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION)){
	$db_arr['educations'] = HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION);
}

if(HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT)){
	$db_arr['critical_talents'] = HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT);
}

if(HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION)){
	$db_arr['critical_positions'] = HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION);
}
if(HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY)){
	$db_arr['special_category'] = HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY);
}

if($this->input->post("btn_confirm_selection"))
{
	if($this->input->post('survey_id') != '')
	{
		$data['survey'][0] = array_merge($data['survey'][0],$db_arr);
	}
	else
	{
		$data['survey'][0] = $db_arr;
	}
}
else
{				
	if($this->input->post('survey_id')=='')
	{
		$db_arr["status"] = 1;
		$db_arr["createdby"] = $this->session->userdata('userid_ses');
		$db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
		$db_arr["createdon"] = date("Y-m-d H:i:s");
		$surveyID=$this->Survey_model->savedata('survey',$db_arr);   
	}
	else
	{
		$this->Survey_model->updatedata('survey',$db_arr,$where=array('survey_id'=>$this->input->post('survey_id'))); 
		$surveyID=$this->input->post('survey_id');
	}

	$db_survey_usr_ids_arr = array();
	foreach($user_ids_arr as $usr_id)
	{
		$db_survey_usr_ids_arr[] = array("survey_id"=>$surveyID, "user_id"=>$usr_id);
	}
	if($db_survey_usr_ids_arr)
	{
		$this->Survey_model->deletedata("survey_users_id_dtls", array("survey_id"=>$surveyID));
		$this->Survey_model->saveBatch("survey_users_id_dtls", $db_survey_usr_ids_arr);
	}

	$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filter saved successfully. Total '.count($user_ids_arr).' employee in this filter</b></div>');
	redirect(base_url('survey/publish/'.$surveyID));
}
}
}

if($country_arr_view)
{
	$data['country_list'] = $this->common_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
}
else
{
	$data['country_list'] = $this->common_model->get_table("manage_country","id, name", "status = 1", "name asc");
}		

if($city_arr_view)
{
	$data['city_list'] = $this->common_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
}
else
{
	$data['city_list'] = $this->common_model->get_table("manage_city","id, name", "status = 1", "name asc");
}		

if($bl1_arr_view)
{
	$data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
}
else
{
	$data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
}

if($bl2_arr_view)
{
	$data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
}
else
{
	$data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
}

if($bl3_arr_view)
{
	$data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
}
else
{
	$data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
}

if($designation_arr_view)
{
	$data['designation_list'] = $this->common_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
}
else
{
	$data['designation_list'] = $this->common_model->get_table("manage_designation","id, name", "status = 1", "name asc");
}

if($function_arr_view)
{
	$data['function_list'] = $this->common_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
}
else
{
	$data['function_list'] = $this->common_model->get_table("manage_function","id, name", "status = 1", "name asc");
}

if($sub_function_arr_view)
{
	$data['sub_function_list'] = $this->common_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
}
else
{
	$data['sub_function_list'] = $this->common_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
}		

if($grade_arr_view)
{
	$data['grade_list'] = $this->common_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
}
else
{
	$data['grade_list'] = $this->common_model->get_table("manage_grade","id, name", "status = 1", "name asc");
}

if($level_arr_view)
{
	$data['level_list'] = $this->common_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
}
else
{
	$data['level_list'] = $this->common_model->get_table("manage_level","id, name", "status = 1", "name asc");
}		

$data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]);
$data['category'] = $this->Survey_model->getCompanyCategory();
$data['survey_id']=$surveyID;
if($withoutview == "withoutview"){
	return $data;
}
$data['title'] = "Survey Filters";
$data['pageName']='filtersurvey';
$data['body'] = "survey/create";
$this->load->view('common/structure',$data);

	}
	public function template(){
		echo "<pre>";
			print_r($_POST);
			die;
	}
    function create($surveyID, $surveyFrom="")
    {
		$data['category'] = $this->Survey_model->getCompanyCategory();
		if(!empty($surveyID)){
			if(!empty($surveyFrom) && $surveyFrom==1){
				$data['survey'] = $this->Survey_model->get_AdminData('survey',$where=['survey_id'=>$surveyID]);

				echo "<pre>";print_r($data);die();
			} else {
				$data['survey'] = $this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);
			}
		}
		if($this->input->post()) {
			
			
			if($this->input->post('template')){
				// echo "<pre>";
				// print_r($_POST);
				// die;
				$template = array(
					'target_point_id'=>$_POST['trigger_point'],
					'email_subject'=>$_POST['subject'],
					'email_body'=>$_POST['body'],
					//'createdby'=>$this->session->userdata('userid_ses'),
					//'createdby_proxy'=>$this->session->userdata('proxy_userid_ses'),
				);
				if($_POST['template_id'] != ''){
					$template['updatedby_proxy'] = $this->session->userdata('proxy_userid_ses');
					$template['updatedby'] = $this->session->userdata('userid_ses');
					$template['updatedon'] = date('Y-m-d');

					$flag = $this->db->where('id',$_POST['template_id'])->update('email_templates',$template);
				}else{
					$template['createdby_proxy'] = $this->session->userdata('proxy_userid_ses');
					$template['createdby'] = $this->session->userdata('userid_ses');
					$template['createdon'] = date('Y-m-d');

					$flag = $this->db->insert('email_templates',$template);
				}

				
				
				
				if($flag){
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record Save</b></div>');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Error</b></div>');
				}
				
				redirect($_SERVER['HTTP_REFERER']);
			}
			if(!empty($this->input->post('survey_id'))){
				// Update Functionlity
				if(empty($data['survey'])) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_invalid_survey').'</b></div>');
					redirect(base_url('survey'));
				} else {

					if(empty($this->input->post('survey_name')) || empty($this->input->post('desc')) || empty($this->input->post('close_desc'))){
					
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_required_validation').'</b></div>');
						redirect(base_url('survey/create/'.$surveyID));
					
					} else {

						$db_arr=[
									"survey_name"=> $this->input->post('survey_name'),
									"description"=> $this->input->post('desc'),
									"closing_description" => $this->input->post('close_desc'),
									"category_id" => $this->input->post('survey_category'),
									"updatedby" => $this->session->userdata('userid_ses'),
									"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
									"updatedon" => date("Y-m-d H:i:s")
								];
						
						if($_FILES['survey_image']['name']) {
							$upload_arr = HLP_upload_img('survey_image', "uploads/survey/");
							if(count($upload_arr) == 2)
							{ 
								$db_arr['survey_img'] = "uploads/survey/".$upload_arr[0];
							} else {
								$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$upload_arr[0].'</b></div>');	
								redirect(base_url('survey/create/'.$surveyID));
							}

						}

						$resut = $this->Survey_model->updatedata('survey',$db_arr,$where=['survey_id'=>$this->input->post('survey_id')]); 
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_update').'</b></div>');
						redirect(base_url('survey/questions_create/'.$surveyID));
						// redirect(base_url('survey/dashboard-analytics'));
					}

				}
				
			} else {
				if(empty($this->input->post('survey_name')) || empty($this->input->post('desc')) || empty($this->input->post('close_desc'))){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_required_validation').'</b></div>');
					redirect($_SERVER['HTTP_REFERER']);
				} else {

					$db_arr=[
								"survey_name"=> $this->input->post('survey_name'),
								"closing_description" => $this->input->post('close_desc'),
								"description"=> $this->input->post('desc'),
								"category_id" => 1,
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
								"createdon" => date("Y-m-d H:i:s")
							];
					if($_FILES['survey_image']['name']) {
						
						$upload_arr = HLP_upload_img('survey_image', "uploads/survey/");
						if(count($upload_arr) == 2)
						{ 
							$db_arr['survey_img'] = "uploads/survey/".$upload_arr[0];
						} else {
							$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$upload_arr[0].'</b></div>');	
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
					$surveyID = $this->Survey_model->savedata('survey',$db_arr);
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_save_survey').'</b></div>');
					redirect(base_url('survey/questions_create/'.$surveyID));
				}
			}
			
		} else {
			if(!empty($surveyID)){
				$data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]);
			}
			$data['categories']=$this->Survey_model->get_data('category',$where=['status'=>1]);
			$data['survey_id']=$surveyID;
            $data['title'] = "Survey";
			$data['pageName']='survey';
            $data['body'] = "survey/create";
            $this->load->view('common/structure',$data); 
		}     
    }
        
    /* CB Harshit - NIU 
    function questions($surveyID)
    {
          if(!helper_have_rights(CV_SURVEY, CV_VIEW_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>';		
                        redirect(site_url("dashboard"));
		}  
          $data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]);
          if(isset($data['questions']) && empty($data['questions'])) {
	        redirect(base_url('survey/questions_create/'.$surveyID));
	      }
          $data['survey_id']=$surveyID;
          $data['title'] = "Survey Questions";
          $data['body'] = "survey/questions";
          $this->load->view('common/structure',$data); 
    }*/
    function questions_create($surveyID)
    {

    	if(empty($surveyID)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_found_survey').'</b></div>');
                redirect(base_url('survey/create'));
			// redirect($_SERVER['HTTP_REFERER']);
		}
        if(!helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></div>';		
            redirect(site_url("dashboard"));
		}
        if($this->input->post())
        {
        	$all_error = 0;
			$errormsg= "";
			if ( empty(trim($this->input->post('QuestionName'))) ) {
				$all_error++;
				$errormsg = "QuestionName is required";
			}else if( (empty($this->input->post('QuestionType')))){
				$all_error++;
				$errormsg = "QuestionType is required";
			}else if( (int)$this->input->post('QuestionType') == 3 && empty($this->input->post('QuestionTitle'))){
				$all_error++;
				$errormsg = "QuestionTitle is required";
			}else if( (int)$this->input->post('QuestionType') == 4 ){
				if(count($this->input->post('subQuestion')) < $this->input->post('scaleUpto'))
				$all_error++;
				$errormsg = "invalid field upto";
			}else{
				if(in_array($this->input->post('QuestionType'), array(1,3,5,7))){
					$aws = $this->input->post('answer');
					$error = 0;
					for($i = 0; $i < count($aws); $i++){
						if( strlen(trim($aws[$i])) == 0  ) {
							$error = 1;
						}
						if(($i==1) && $error==0){
							break;
						}
					}
					if($error > 0){
						$all_error++;
						$errormsg = "First two answers are required";
					}
				}
			}
			
			if($all_error > 0) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$errormsg.'</b></div>');
                redirect(base_url('survey/questions_create/'.$surveyID));
			}
			if(isset($_POST['mandetory'])){
				$mandetory = $_POST['mandetory'];
			}else{
				$mandetory = 2;
			}
			$db_arr=[
                "survey_id"=>$surveyID,
                "QuestionType"=>$this->input->post('QuestionType'),
                "QuestionName"=>$_POST['QuestionName'],
                "is_mandatory"=>$mandetory,
			];

			if(!empty($this->input->post('QuestionTitle'))){
				$db_arr['QuestionTitle'] = htmlspecialchars($this->input->post('QuestionTitle'));
			}

			if(!empty($this->input->post('scaleUpto'))){
				$db_arr['sacle_upto'] = $this->input->post('scaleUpto');
			}
			
			/* //CB-Harshit[29-11-2018] - code is in working condition but now its is not in use
		  	if($_FILES['question_image']['name']) {
				$file_type = explode('.',$_FILES['question_image']['name']);
				if($file_type[1] == 'jpg' || $file_type[1] == 'jpeg' || $file_type[1] == 'png' || $file_type[1] == 'gif') { 
					//$uploaded_file_name = $_FILES['question_image']['name'];
					$filename = 'survey_'.$surveyID.'_'.time().".".$file_type[1];//$_FILES["myfile"]["name"];
					$dd = move_uploaded_file($_FILES["question_image"]["tmp_name"],  "uploads/survey/question/".$filename);
					$db_arr['quest_img'] = "uploads/survey/question/".$filename;

				}
			}*/

            $QuestionID=$this->Survey_model->savedata('survey_questions',$db_arr);
            $ids = array();
            if(in_array($this->input->post('QuestionType'), array(4,5,6))){	
            	$subQues = $this->input->post('subQuestion');
            	foreach ($subQues as $key => $subQue) {
            		//# code...
					$ques=array(
					   	'p_qid'=>$QuestionID,
					   	'survey_id'=>$surveyID,
					   	'QuestionType'=>$this->input->post('QuestionType'),
						'QuestionName'=>$subQue,
					);
					$this->db->insert('survey_questions',$ques);
					$ids[]=$this->db->insert_id();
				}
				//$res=$this->Survey_model->saveBatch('survey_questions',$ques);
            }
            // rating case add sub question _4   

            if(in_array($this->input->post('QuestionType'), array(1,3,5,7))){
			   	$i = 0;               	
			   	$ans=array();
				$qid = $QuestionID;
				for($j=0;$j<count($this->input->post('answer'));$j++)
				{	
					$answer_name = $this->input->post('answer')[$j];
					if(!empty($answer_name)) {
						$ans[]=array(
							'question_id'=>$qid,
							'Answer'=>htmlspecialchars($this->input->post('answer')[$j]),
							'ans_img' => ''
						);
					}
				}

				if(!empty($ids)){
					$idsCount = count($ids);  
					$i = 0;               	
					do {
					$qid = $ids[$i];
					for($j=0;$j<count($this->input->post('answer'));$j++)
					{	
					$answer_name = $this->input->post('answer')[$j];
					if(!empty($answer_name)) {
						$ans[]=array(
							'question_id'=>$qid,
							'Answer'=>htmlspecialchars($this->input->post('answer')[$j]),
							'ans_img' => ''
						);
					}
					}
					$i++;
					} while ($idsCount > $i);

				}
				

				$res=$this->Survey_model->saveBatch('survey_answers',$ans);   
			}else {
			 	$res=true; 
			}

            if($res)
            {
                 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_save').'</b></div>');

                if( $this->input->post('btn_save_create_more') ){
                	redirect(base_url('survey/questions_create/'.$surveyID));
                } else{
                	redirect(base_url('survey/survey_filters/'.$surveyID));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_error_saving_survey').'</b></div>');
                 redirect(base_url('survey/questions_create/'.$surveyID));
            }
        }

        // $data['body'] = "survey/questions_create";
        $data['question_types']=$this->Survey_model->get_data('survey_question_type');
        $data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID,'p_qid'=>'0']);
        $data['category'] = $this->Survey_model->getCompanyCategory();
        $data['survey'] = $this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);
        $data['survey_id']=$surveyID;
		$data['pageName']='question';
        $data['title'] = "Question Create";
        $data['body'] = "survey/create";
        $this->load->view('common/structure',$data); 
    }

    function questions_edit($surveyID,$questionID)
    {

    	if(empty($surveyID) || empty($questionID)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_exist_survey').'</b></div>');
                redirect(base_url('survey/create'));
		}
        if(!helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></div>';		
                        redirect(site_url("dashboard"));
		}
          $data['question']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID,'question_id'=>$questionID]);
         
	          $data['answer']=$this->Survey_model->get_data('survey_answers',$where=['question_id'=>$questionID]);
	          $data['answer_count']=count($data['answer']);
	        
          $data['sub_ques']=$this->Survey_model->get_data('survey_questions',$where=['p_qid'=>$questionID]);
        
        if($this->input->post())
        { 

          	$all_error = 0;
        	$errormsg= "";
			if ( empty(trim($this->input->post('QuestionName'))) ) {
				$all_error++;
				$errormsg = "QuestionName is required";
			}else if( (empty($this->input->post('QuestionType')))){
				$all_error++;
				$errormsg = "QuestionType is required";
			}else if($this->input->post('QuestionType') == 3 && (empty($this->input->post('QuestionTitle')))){
				$all_error++;
				$errormsg = "QuestionTitle is required";
			}else if( (int)$this->input->post('QuestionType') == 4 || (int)$this->input->post('QuestionType') == 6 ){
				if(count($this->input->post('subQuestion')) < $this->input->post('scaleUpto'))
				$all_error++;
				$errormsg = "invalid field upto";
			}else {
				if(in_array($this->input->post('QuestionType'), array(1,3,5,7))){
					$aws = $this->input->post('answer');
					$error = 0;
					for($i = 0; $i < count($aws); $i++){
						if( strlen(trim($aws[$i])) == 0  ) {
							$error = 1;
						}
						if(($i==1) && $error==0){
							break;
						}
					}
					if($error > 0){
						$all_error++;
						$errormsg = "First two answer is required";
					}
				}
			}
			
			if($all_error > 0) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$errormsg.'</b></div>');
                redirect(base_url('survey/questions_edit/'.$surveyID.'/'.$questionID));
			}
			
          	$db_arr=[
              	"survey_id"=>$surveyID,
              	"QuestionType"=>$this->input->post('QuestionType'),
              	"QuestionName"=>$this->input->post('QuestionName'),
		  	];

		  	if(!empty($this->input->post('QuestionTitle')) && ($this->input->post('QuestionType') == 2 || $this->input->post('QuestionType') == 3) ){
				$db_arr['QuestionTitle'] = $this->input->post('QuestionTitle');
			} else {
				$db_arr['QuestionTitle'] = '';
			}

			if(isset($_POST['mandetory'])){
				$mandetory = $_POST['mandetory'];
			}else{
				$mandetory = 2;
			}
			$db_arr['is_mandatory'] = $mandetory;

			if(!empty($this->input->post('scaleUpto'))){
				$db_arr['sacle_upto'] = $this->input->post('scaleUpto');
			}

		  	/* //CB-Harshit[29-11-2018] - code is in working condition but now its is not in use
		  	if($_FILES['question_image']['name']) {
		  		$upload_arr = HLP_upload_img('question_image', "uploads/survey/question/");
				if(count($upload_arr) == 2)
				{ 
					$db_arr['quest_img'] = "uploads/survey/question/".$upload_arr[0];
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid file type.</b></div>');
                	redirect(base_url('survey/questions_edit/'.$surveyID.'/'.$questionID));
				}
			}*/
			// print_r($db_arr);
			// print_r(['survey_id'=>$surveyID,'question_id'=>$questionID]);
			// die;
            $QuestionID=$this->Survey_model->updatedata('survey_questions',$db_arr,$where=['survey_id'=>$surveyID,'question_id'=>$questionID]); 
            // sub question logic
            if(in_array($this->input->post('QuestionType'), array(4,5,6))){	
            	$delete = $this->Survey_model->deletedata('survey_questions',$where=['p_qid'=>$questionID]);
            	$subQuesIds = $_POST['subQuesId'];
            	$delete = $this->Survey_model->deletedata_whereIn('survey_answers','question_id',$subQuesIds);
            	$subQues = $this->input->post('subQuestion');
            	foreach ($subQues as $key => $subQue) {
            			//if(!empty($subQue)){
							$ques_insert=array(
								"survey_id"=>$surveyID,
								'p_qid'=>$questionID,
								'QuestionType'=>$this->input->post('QuestionType'),
								'QuestionName'=>htmlspecialchars($subQue),
							);
						//}
					$this->db->insert('survey_questions',$ques_insert);
					$ids[]=$this->db->insert_id();
				}
            }

if(in_array($this->input->post('QuestionType'), array(2,4,6))){
	$delete = $this->Survey_model->deletedata('survey_answers',$where=['question_id'=>$questionID]);
 	$res=true; 
} else {
	// if($this->input->post('QuestionType')!=2 && $this->input->post('QuestionType')!=4)
	// {
	$delete = $this->Survey_model->deletedata('survey_answers',$where=['question_id'=>$questionID]);

   	$i = 0;               	
   	$ans=array();
	$qid = $questionID;
	for($j=0;$j<count($this->input->post('answer'));$j++)
	{	
		$answer_name = $this->input->post('answer')[$j];
		if(!empty($answer_name)) {
			$ans[]=array(
				'question_id'=>$qid,
				'Answer'=>htmlspecialchars($this->input->post('answer')[$j]),
				'ans_img' => ''
			);
		}
	}
	if(!empty($ids)){
		$idsCount = count($ids);  
		$i = 0;               	
		//$ans=array();
		do {
		$qid = $ids[$i];
		for($j=0;$j<count($this->input->post('answer'));$j++)
		{	
		$answer_name = $this->input->post('answer')[$j];
		if(!empty($answer_name)) {
			$ans[]=array(
				'question_id'=>$qid,
				'Answer'=>htmlspecialchars($this->input->post('answer')[$j]),
				'ans_img' => ''
			);
		}
		}
		$i++;
		} while ($idsCount > $i);

	}
	$res=$this->Survey_model->saveBatch('survey_answers',$ans);   
			 
} 

      //       if($this->input->post('QuestionType')==2 && $this->input->post('QuestionType')==4)
      //       {
      //       	$delete = $this->Survey_model->deletedata('survey_answers',$where=['question_id'=>$questionID]);
      //        	$res=true; 
      //       } else {

      //       	$id_to_delete =array();
      //           $ans=array();
      //           $anwser_without_image = array();
      //           $anwser_with_image = array();
      //           for($i=0;$i<count($this->input->post('answer'));$i++)
      //           {
      //               $answer_name = $this->input->post('answer')[$i];
      //               $aws_id      = $this->input->post('awsid')[$i];
      //               if(!empty($answer_name)) { 
      //               	 // CB-Harshit[29-11-2018] - code is in working condition but now its is not in use
      //               	$aws_image_name = $_FILES['answer_img']['name'][$i];
      //               	if(!empty($aws_image_name)) { 
      //               		$file_type = explode('.',$_FILES['answer_img']['name'][$i]);
      //               		if($file_type[1] == 'jpg' || $file_type[1] == 'jpeg' || $file_type[1] == 'png' || $file_type[1] == 'gif') {
                				
      //           				$filename = 'survey_'.$surveyID.'_'.time().".".$file_type[1];//$_FILES["myfile"]["name"];
						// 		$dd = move_uploaded_file($_FILES["answer_img"]["tmp_name"][$i],  "uploads/survey/answer/".$filename);
						// 		if(!empty($aws_id))	{
						// 			$anwser_with_image[] = array(
						// 				'surveyAnsID' => $aws_id,
						// 				'Answer'=>htmlspecialchars($this->input->post('answer')[$i]),
						// 				'ans_img' => 'uploads/survey/answer/'.$filename
						// 			);
						// 		} else {
						// 			$ans[]=array(
		    //                        		'question_id'=>$questionID,
		    //                        		'Answer'=>htmlspecialchars($this->input->post('answer')[$i]),
		    //                        		'ans_img' => 'uploads/survey/answer/'.$filename
		    //                         );
						// 		}
									
						// 	}
      //               	} else {
      //               			if(!empty($aws_id))	{
						// 			$anwser_without_image[] = array(
						// 				'surveyAnsID' => $aws_id,
						// 				'Answer'=>htmlspecialchars($this->input->post('answer')[$i])
						// 			);
						// 		} else {
						// 			$ans[]=array(
		    //                        		'question_id'=>$questionID,
		    //                        		'Answer'=>htmlspecialchars($this->input->post('answer')[$i]),
		    //                        		'ans_img' => 'nn'
		    //                         );
						// 		}
      //               	/*}*/
      //               } else {
      //               	if(!empty($aws_id))	{
						// 	$id_to_delete[] = $aws_id;
						// }
      //               }
      //           }
      //           if(!empty($id_to_delete)){
      //           	$delete = $this->Survey_model->deletedata_whereIn('survey_answers','surveyAnsID',$id_to_delete);
      //           }
      //       	if(!empty($anwser_with_image)) {
      //       		$this->db->update_batch('survey_answers',$anwser_with_image, 'surveyAnsID'); 
      //       	}

      //       	if(!empty($anwser_without_image)) {
      //       		$this->db->update_batch('survey_answers',$anwser_without_image, 'surveyAnsID'); 
      //       	}
      //       	if(!empty($ans)) {
      //       		$res=$this->Survey_model->saveBatch('survey_answers',$ans); 	
      //       	} else {
      //       		$res= true;
      //       	}
            	
      //       }
                
            if($res)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_save').'</b></div>');
                   redirect(base_url('survey/questions_create/'.$surveyID));
            }
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_error_saving_survey').'</b></div>');
                   redirect(base_url('survey/questions_create/'.$surveyID));
            }
        }
          // $data['title'] = "Question Create";
          // $data['body'] = "survey/questions_create";
        $data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID,'p_qid'=>'0']);
        // echo "<pre>";
        // print_r($data['questions']);
        // die;
        $data['question_types']=$this->Survey_model->get_data('survey_question_type');
        $data['questionID'] = $questionID;
        $data['category'] = $this->Survey_model->getCompanyCategory();
        $data['survey'] = $this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);
        $data['survey_id']=$surveyID;
		$data['pageName']='question';
        $data['title'] = "Question Create";
        $data['body'] = "survey/create";
        // echo "<pre>";print_r($data);die();
          $this->load->view('common/structure',$data); 
    }

    function deleteSurvey($surveyID,$parm2='')
    {
    	//echo $surveyID;
    	$survey = $this->db->where('survey_id',$surveyID)->get('survey')->row();

    	
    	$survey_questions = $this->db->select("GROUP_CONCAT(`question_id`) as qid")->where('survey_id',$surveyID)->get('survey_questions')->result();
    	$question_Ids = explode(',', $survey_questions[0]->qid);

    	//$survey_ans = $this->db->where_in('question_id',$question_Ids)->get('survey_answers')->result();
    	//$survey_users_id_dtls = $this->db->where('survey_id',$surveyID)->get('survey_users_id_dtls')->result();

    	$this->db->where('survey_id',$surveyID)->delete('survey');
    	$this->db->where('survey_id',$surveyID)->delete('survey_questions');
    	$this->db->where_in('question_id',$question_Ids)->delete('survey_answers');
    	$this->db->where('survey_id',$surveyID)->delete('survey_users_id_dtls');

    	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data deleted</b></div>');
    	if($parm2 != ''){
    		redirect(site_url("survey/dashboard-analytics/".$parm2));
    	}		
            redirect(site_url("survey/dashboard-analytics"));
    	// echo "<pre>";
    	// print_r($survey);
    	// print_r($survey_questions);
    	// print_r($survey_ans);
    	// print_r($survey_users_id_dtls);
    }
    function deleteQuestion($surveyID,$questionID)
    {
    	if(empty($surveyID) || empty($questionID)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_exist_survey').'</b></div>');
                redirect(base_url('survey/create'));
		}
        if(!helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></div>';		
            redirect(site_url("dashboard"));
		}
          $this->Survey_model->deletedata('survey_questions',$where=['question_id'=>$questionID]);  
          $this->Survey_model->deletedata('survey_answers',$where=['question_id'=>$questionID]);     
          $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_deleted').'</b></span></div>');
          redirect(base_url('survey/questions_create/'.$surveyID));
    }

    function getUsers()
    {
        if(!helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></div>');		
            redirect(site_url("dashboard"));
		}
        /*$data['survey']=$this->Survey_model->get_data_order('survey',$where='survey_id IN (SELECT survey_id FROM survey_users_id_dtls WHERE user_id ='.$this->session->userdata('userid_ses').') and is_published=1 AND start_date >= CURDATE()');

         $data['survey']=$this->Survey_model->get_data_order('survey',$where='survey_id IN (SELECT survey_id FROM survey_users_id_dtls WHERE user_id ='.$this->session->userdata('userid_ses').') and is_published=1 AND start_date >= CURDATE()');*/
		 
		 $data['survey'] = $this->common_model->get_table("survey", "survey.*, DATE_ADD(survey.start_date, INTERVAL survey.surevy_open_periods DAY) AS survey_end_dt", 'survey_id IN (SELECT survey_id FROM survey_users_id_dtls WHERE user_id ='.$this->session->userdata('userid_ses').') AND is_published=1 AND start_date <= CURDATE() AND CURDATE() <= DATE_ADD(survey.start_date, INTERVAL survey.surevy_open_periods DAY)', "survey_id DESC");

        // $data['survey']=$this->Survey_model->get_data_order('survey',$where='FIND_IN_SET ('.$this->session->userdata('userid_ses').',`user_ids`) and is_published=1');
        // echo "<pre>";
        // print_r($data['survey']);
        // die;
        $data['title'] = "Survey users";
        $data['body'] = "survey/usersSurvey";
        $this->load->view('common/structure',$data);   
    }

    public function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
    }


    function user_survey_questions1111($surveyID)
    {
        $data['surveydtl']=$this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);  
        $thankupMess= $data['surveydtl'][0]['closing_description'];
        //die;
        $data['question']=$this->db->where(['survey_id'=>$surveyID,'p_qid'=>'0'])->where_in('QuestionType',array(1,2,3))->get('survey_questions')->result_array();  
        //$data['question']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]);  
        if($this->input->post())
        {
        	// echo json_encode($_POST);
        	// die;
			$inputArr = $this->input->post();
			$inputArr['question'] = HLP_unsetEmptyVal($inputArr['question']);
			if(count($inputArr['question']) > 0) {
				$userResp = [
					'user_id' => $this->session->userdata('userid_ses'),
					'survey_id' => $surveyID,
				];
				$respArr = $this->Survey_model->get_data('user_survey_response',$userResp);
				if(count($respArr) > 0) {
					$condition = $userResp;
					$userResp['status'] = $inputArr['submittype'];
					$userResp['updatedon'] =  date("Y-m-d H:i:s");
					$userRespID = $this->Survey_model->updatedata('user_survey_response',$userResp,$condition);
					$userRespID = $respArr[0]['id'];
				} else {
					$userResp['status'] = $inputArr['submittype'];
					$userResp['createdon'] =  date("Y-m-d H:i:s");
					$userRespID = $this->Survey_model->savedata('user_survey_response',$userResp);
				}
				foreach($inputArr['question'] as $key=>$val)
          		{
          			$queId = explode('_',$key);
          			$qtype = $queId[0];
          			$queId = $queId[1];
              		if(!empty($val))
              		{
              			$qd=[
							'user_survey_response_id' => $userRespID,
							'question_id' => $queId,
							'user_id' => $this->session->userdata('userid_ses'),
						]; 
						$cqd = $qd;
						
                 		if($qtype==3)
                 		{
                 			$userAnsID=$this->db->where($qd)->delete('user_survey_answer');
	                        $answerArr=$inputArr['question'][$key];
	                        $final = $qd;
	                        $c = count($answerArr);
							foreach ($answerArr as $y => $v) {
								if (strpos($v, '_') !== false) {
									//$final = $qa;
								    $qa=explode('_',$v);
			                        if($qa[0] == $queId){
										$final['surveyAnsID']=$qa[1];
			                        }
			                        $final['textAnswer']=end($answerArr);
								}
								//	if(!empty($v))
                        			
								//}
								$final_data[] = $final;
							}
							// echo json_encode($final_data);
							// die;
							//$getansArr = $this->Survey_model->get_data('user_survey_answer',$cqd);
							//if(count($getansArr) > 0) {
								//$userAnsID = $this->Survey_model->updatedata('user_survey_answer',$qd,$cqd);
							//} else{
                     		$userAnsID=$this->db->insert_batch('user_survey_answer',$final_data); 
							//}

                 		} else if($qtype==2) {
	                        $answerID=$inputArr['question'][$key];
							$qd['textAnswer'] = $answerID; 
                     		$getansArr = $this->Survey_model->get_data('user_survey_answer',$cqd);
							if(count($getansArr) > 0) {
								$userAnsID = $this->Survey_model->updatedata('user_survey_answer',$qd,$cqd);
							} else{
                     			$userAnsID=$this->Survey_model->savedata('user_survey_answer',$qd); 
							} 

                 		} else if($qtype==1) {
                 			$ansArr = $inputArr['question'][$key];
                 			$userAnsID=$this->db->where($qd)->delete('user_survey_answer'); 
                 			foreach ($ansArr as $k => $v) {
	                 			$qa=explode('_',$v);
								$qd['surveyAnsID']=$qa[1];
	                     		$userAnsID=$this->Survey_model->savedata('user_survey_answer',$qd); 
                 			}
							// $qa=explode('_',$inputArr['question'][$key]);
							// $qd['surveyAnsID']=$qa[1];
       //            			$getansArr = $this->Survey_model->get_data('user_survey_answer',$cqd);
							// if(count($getansArr) > 0) {
							// 	$userAnsID = $this->Survey_model->updatedata('user_survey_answer',$qd,$cqd);
							// } else{
       //               			$userAnsID=$this->Survey_model->savedata('user_survey_answer',$qd); 
							// }    
                 		}
              		}
          		}
           
				//$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>manish'.$this->lang->line('msg_save').'</b></div>');
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$thankupMess.'</b></div>');
				redirect(base_url('survey/users'));
		  	} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_atlest_1_ans_survey').'</b></div>');
				redirect(base_url('survey/user-survey-questions/'.$surveyID));
			} 
        }

        if(! (isset($data['surveydtl'][0]) && chkEmpSurvey($this->session->userdata('userid_ses'),$data['surveydtl'][0]['survey_id']) && ($data['surveydtl'][0]['is_published'] == 1)) )
		{
		//	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');	
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');	
			// echo "string";
			// die;
            redirect(site_url("survey/users"));
		}
        $data['surveyID']=$surveyID;
        $data['title'] = "Survey";
        $data['body'] = "survey/user_survey_questions";
        $this->load->view('common/structure',$data); 
         
    }


    function user_survey_questions_demo($surveyID){
    	echo json_encode($_POST);
    }
    function user_survey_questions($surveyID)
    {
        $data['surveydtl']=$this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);  
        $thankupMess= $data['surveydtl'][0]['closing_description'];
        $data['question']=$this->db->where(['survey_id'=>$surveyID,'p_qid'=>'0'])->where_in('QuestionType',array(1,2,3,4,5,6,7))->get('survey_questions')->result_array();

        if($this->input->post())
        {
        	// echo json_encode($_POST);
        	// die;
			$inputArr = $this->input->post();
			$inputArr['question'] = HLP_unsetEmptyVal($inputArr['question']);
			if(count($inputArr['question']) > 0) {
				$userResp = [
					'user_id' => $this->session->userdata('userid_ses'),
					'survey_id' => $surveyID,
				];
				$respArr = $this->Survey_model->get_data('user_survey_response',$userResp);
				if(count($respArr) > 0) {
					$condition = $userResp;
					$userResp['status'] = $inputArr['submittype'];
					$userResp['updatedon'] =  date("Y-m-d H:i:s");
					$userRespID = $this->Survey_model->updatedata('user_survey_response',$userResp,$condition);
					$userRespID = $respArr[0]['id'];
				} else {
					$userResp['status'] = $inputArr['submittype'];
					$userResp['createdon'] =  date("Y-m-d H:i:s");
					$userRespID = $this->Survey_model->savedata('user_survey_response',$userResp);
				}
				$final =array();
				foreach($inputArr['question'] as $key=>$val)
          		{
          			$queId = explode('_',$key);
          			$qtype = $queId[0];
          			$queId = $queId[1];
              		//if(!empty($val) && $this->in_array_r($queId, $data['question']))
              		if(!empty($val))
              		{
              			$con=[
							'user_survey_response_id' => $userRespID,
							'user_id' => $this->session->userdata('userid_ses')
						]; 
              			$qd=[
							'user_survey_response_id' => $userRespID,
							'question_id' => $queId,
							'user_id' => $this->session->userdata('userid_ses')
						]; 
						$cqd = $qd;
                 		if($qtype==3)
                 		{
	                        $answerArr=$_POST['question'][$key];
							foreach ($answerArr as $y => $v) {
								if(!empty($v)){
									if (strpos($v, '_') !== false) {
									    $qa=explode('_',$v);
				                        if($qa[0] == $queId){
											$qd['surveyAnsID']=$qa[1];
				                        }
									}else{
										if(!empty($v))
	                        			$qd['textAnswer']=$v;
									}
								}else{
									$qd['textAnswer']='';
								}
							}
							$final[] = $qd;
							

                 		} else if($qtype==2) {
	                        $answerID=$inputArr['question'][$key];
	                        $qd['surveyAnsID']='';
							$qd['textAnswer'] = $answerID; 
							$final[] = $qd;

                 		} else if($qtype==1) {
                 			
							$qa=explode('_',$inputArr['question'][$key]);
							$qd['surveyAnsID']=$qa[1];
							$qd['textAnswer']='';
							$final[] = $qd;
                 		}else if($qtype==4) {
       						$arr=$inputArr['question'][$key];
							$qd['surveyAnsID']='';
							$qd['textAnswer']=$arr;
							$final[] = $qd;
							/*foreach ($arr as $k => $v) {
								$qd['textAnswer']=$v;
								$final[] = $qd;
							}*/
                 		}else if($qtype==5) {
							$qd['surveyAnsID']=$inputArr['question'][$key];
							$qd['textAnswer']='';
							$final[] = $qd;
                 		}else if($qtype==6) {

							$arr	= $_POST['question'][$key];
							$qd['surveyAnsID']	= '';

							foreach($arr as $k => $v) {

								if(($k % 2) == 0) {//this is importance answer

									$v = $v . CV_SURVEY_3D_IMPORTANCE;
								} else {//this is satisfaction answer

									$v = $v . CV_SURVEY_3D_SATISFACTION;
								}

								$qd['textAnswer']	= $v;
								$final[] 			= $qd;

							}
                 		}else if($qtype==7) {
                 			$arr=$inputArr['question'][$key];
							foreach ($arr as $k => $v) {
								$qd['surveyAnsID']=$v;
								$qd['textAnswer']='';
								$final[] = $qd;
							}
                 		}

              		}
				}

				$userAnsID=$this->db->where($con)->delete('user_survey_answer');           		
				$flag=$this->db->insert_batch('user_survey_answer',$final);           		
				if($flag){
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$thankupMess.'</b></div>');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Technical error</b></div>');
				}      
				redirect(base_url('survey/thanks_message/'.$surveyID));
		  	} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_atlest_1_ans_survey').'</b></div>');
				redirect(base_url('survey/user-survey-questions/'.$surveyID));
			} 
        }

        if(! (isset($data['surveydtl'][0]) && chkEmpSurvey($this->session->userdata('userid_ses'),$data['surveydtl'][0]['survey_id']) && ($data['surveydtl'][0]['is_published'] == 1)) )
		{
		//	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');	
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');	
			// echo "string";
			// die;
            redirect(site_url("survey/users"));
		}
        $data['surveyID']=$surveyID;
        $data['title'] = "Survey";
        $data['body'] = "survey/user_survey_questions";
        $this->load->view('common/structure',$data); 
         
    }

    function result($surveyID)
    {
		$data['result']=$this->Survey_model->GetUserQuestionAnswer($surveyID);
		//         echo '<pre />';
		//         print_r($data['result']); die;
		$qa=[];
		$qacount=0;
		foreach($data['result'] as $r)
		{
		 foreach($data['result'] as $qc)
		 {
		     if($qc['QuestionName']==$r['QuestionName'])
		     {
		       $qacount++;  
		     }
		 }
		 $qa[$r['QuestionName']]=($qacount/count($data['result']))*100;
		 $qacount=0;
		}

		/* $data['text']=$this->Survey_model->GetUserQuestionAnswerText($surveyID);
		 $qacount=0;
		 foreach($data['text'] as $r)
		 {
		     foreach($data['text'] as $qc)
		     {
		         if($qc['QuestionName']==$r['QuestionName'])
		         {
		           $qacount++;  
		         }
		     }
		     $qa[$r['QuestionName']]=($qacount/count($data['text']))*100;
		     $qacount=0;
		 } */
		 $data['result']=$qa;
		 $data['title'] = "Survey Result";
		 $data['body'] = "survey/result";
		 $this->load->view('common/structure',$data); 
         
    }
      
	function results($surveyID)
	{
		$user_id = $this->session->userdata('userid_ses');
		$data['right_dtls'] = $this->common_model->get_table("rights_on_country", "*", array("status"=>1, "user_id"=>$user_id), "id desc");
		
		$country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");
		$city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
		$bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
		$bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
		$bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");
		
		$designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
		$function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
		$sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
		$grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
		$level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");
		$data['education_list'] = $this->common_model->get_table("manage_education","id, name", "status = 1", "name asc");
		$data['critical_talent_list'] = $this->common_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
		$data['critical_position_list'] = $this->common_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
		$data['special_category_list'] = $this->common_model->get_table("manage_special_category","id, name", "status = 1", "name asc");

		$user_ids = "";
		if($this->input->post())
		{						
			if(in_array('all', $this->input->post("ddl_country")))
			{
				$country_arr =$country_arr_view;				
			}
			else
			{
				$country_arr = implode(",",$this->input->post("ddl_country"));
			}

			if(in_array('all', $this->input->post("ddl_city")))
			{
				$city_arr = $city_arr_view;
			}
			else
			{
				$city_arr = implode(",",$this->input->post("ddl_city"));
			}

			if(in_array('all', $this->input->post("ddl_bussiness_level_1")))
			{
				$bussiness_level_1_arr = $bl1_arr_view;				
			}
			else
			{
				$bussiness_level_1_arr=implode(",",$this->input->post("ddl_bussiness_level_1"));
			}

			if(in_array('all', $this->input->post("ddl_bussiness_level_2")))
			{
				$bussiness_level_2_arr = $bl2_arr_view;				
			}
			else
			{
				$bussiness_level_2_arr=implode(",",$this->input->post("ddl_bussiness_level_2"));
			}

			if(in_array('all', $this->input->post("ddl_bussiness_level_3")))
			{
				$bussiness_level_3_arr = $bl3_arr_view;				
			}
			else
			{
				$bussiness_level_3_arr=implode(",",$this->input->post("ddl_bussiness_level_3"));
			}

			if(in_array('all', $this->input->post("ddl_function")))
			{
				$function_arr = $function_arr_view;
			}
			else
			{
				$function_arr = implode(",",$this->input->post("ddl_function"));
			}

			if(in_array('all', $this->input->post("ddl_sub_function")))
			{
				$sub_function_arr = $sub_function_arr_view;
			}
			else
			{
				$sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
			}

			if(in_array('all', $this->input->post("ddl_designation")))
			{
				$designation_arr = $designation_arr_view;
			}
			else
			{
				$designation_arr = implode(",",$this->input->post("ddl_designation"));
			}

			if(in_array('all', $this->input->post("ddl_grade")))
			{
				$grade_arr = $grade_arr_view;
			}
			else
			{
				$grade_arr = implode(",",$this->input->post("ddl_grade"));
			}
			
			if(in_array('all', $this->input->post("ddl_level")))
			{
				$level_arr = $level_arr_view;
			}
			else
			{
				$level_arr = implode(",",$this->input->post("ddl_level"));
			}

			if(in_array('all', $this->input->post("ddl_education")))
			{
				$temp_arr = array();
				$education_arr = "";
				foreach($data['education_list'] as $item_row)
				{
					array_push($temp_arr,$item_row["id"]); 
				}
				if($temp_arr)
				{
					$education_arr = implode(",",$temp_arr);
				}
				
			}
			else
			{
				$education_arr = implode(",",$this->input->post("ddl_education"));
			}

			if(in_array('all', $this->input->post("ddl_critical_talent")))
			{
				$temp_arr = array();
				$critical_talent_arr = "";
				foreach($data['critical_talent_list'] as $item_row)
				{
					array_push($temp_arr,$item_row["id"]); 
				}
				if($temp_arr)
				{
					$critical_talent_arr = implode(",",$temp_arr);
				}
				
			}
			else
			{
				$critical_talent_arr = implode(",",$this->input->post("ddl_critical_talent"));
			}

			if(in_array('all', $this->input->post("ddl_critical_position")))
			{
				$temp_arr = array();
				$critical_position_arr = "";
				foreach($data['critical_position_list'] as $item_row)
				{
					array_push($temp_arr,$item_row["id"]); 
				}
				if($temp_arr)
				{
					$critical_position_arr = implode(",",$temp_arr);
				}
				
			}
			else
			{
				$critical_position_arr = implode(",",$this->input->post("ddl_critical_position"));
			}

			if(in_array('all', $this->input->post("ddl_special_category")))
			{
				$temp_arr = array();
				$special_category_arr = "";
				foreach($data['special_category_list'] as $item_row)
				{
					array_push($temp_arr,$item_row["id"]); 
				}
				if($temp_arr)
				{
					$special_category_arr = implode(",",$temp_arr);
				}
				
			}
			else
			{
				$special_category_arr = implode(",",$this->input->post("ddl_special_category"));
			}

			if(in_array('all', $this->input->post("ddl_tenure_company")))
			{
				$temp_arr = array();
				for($i=0; $i<=35; $i++)
				{
					array_push($temp_arr,$i); 
				}
				if($temp_arr)
				{
					$tenure_company_arr = implode(",",$temp_arr);
				}
				
			}
			else
			{
				$tenure_company_arr = implode(",",$this->input->post("ddl_tenure_company"));
			}

			if(in_array('all', $this->input->post("ddl_tenure_role")))
			{
				$temp_arr = array();
				for($i=0; $i<=35; $i++)
				{
					array_push($temp_arr,$i); 
				}
				if($temp_arr)
				{
					$tenure_role_arr = implode(",",$temp_arr);
				}
				
			}
			else
			{
				$tenure_role_arr = implode(",",$this->input->post("ddl_tenure_role"));
			}
			
			$where ="login_user.role > 1 and login_user.status = 1";
			if($country_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_COUNTRY." in (".$country_arr.")";
			}
			
			if($city_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_CITY." in (".$city_arr.")";
			}

			if($bussiness_level_1_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_1." in (".$bussiness_level_1_arr.")";
			}

			if($bussiness_level_2_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_2." in (".$bussiness_level_2_arr.")";
			}

			if($bussiness_level_3_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_3." in (".$bussiness_level_3_arr.")";
			}

			if($function_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_FUNCTION." in (".$function_arr.")";
			}

			if($sub_function_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_SUBFUNCTION." in (".$sub_function_arr.")";
			}

			if($designation_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_DESIGNATION." in (".$designation_arr.")";
			}

			if($grade_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_GRADE." in (".$grade_arr.")";
			}
			
			if($level_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_LEVEL." in (".$level_arr.")";
			}

			if($education_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_EDUCATION." in (".$education_arr.")";
			}

			if($critical_talent_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_CRITICAL_TALENT." in (".$critical_talent_arr.")";
			}

			if($critical_position_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_CRITICAL_POSITION." in (".$critical_position_arr.")";
			}

			if($special_category_arr)
			{
				$where .= " and login_user.".CV_BA_NAME_SPECIAL_CATEGORY." in (".$special_category_arr.")";
			}

			if($tenure_company_arr)
			{
				$where .= " and login_user.tenure_company in (".$tenure_company_arr.")";
			}

			if($tenure_role_arr)
			{
				$where .= " and login_user.tenure_role in (".$tenure_role_arr.")";
			}
	
			$user_ids_arr = array();
			$data['employees'] = $this->admin_model->get_employees_as_per_rights($where);
			foreach($data['employees'] as $row)
			{
				$user_ids_arr[] = $row["id"];
			}
			$user_ids = implode(",",$user_ids_arr);
		}
		
		if($country_arr_view)
		{
			$data['country_list'] = $this->common_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
		}
		else
		{
			$data['country_list'] = $this->common_model->get_table("manage_country","id, name", "status = 1", "name asc");
		}		
		
		if($city_arr_view)
		{
			$data['city_list'] = $this->common_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
		}
		else
		{
			$data['city_list'] = $this->common_model->get_table("manage_city","id, name", "status = 1", "name asc");
		}		

		if($bl1_arr_view)
		{
			$data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
		}

		if($bl2_arr_view)
		{
			$data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
		}

		if($bl3_arr_view)
		{
			$data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
		}
		else
		{
			$data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
		}

		if($designation_arr_view)
		{
			$data['designation_list'] = $this->common_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
		}
		else
		{
			$data['designation_list'] = $this->common_model->get_table("manage_designation","id, name", "status = 1", "name asc");
		}

		if($function_arr_view)
		{
			$data['function_list'] = $this->common_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
		}
		else
		{
			$data['function_list'] = $this->common_model->get_table("manage_function","id, name", "status = 1", "name asc");
		}

		if($sub_function_arr_view)
		{
			$data['sub_function_list'] = $this->common_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
		}
		else
		{
			$data['sub_function_list'] = $this->common_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");			
		}		

		if($grade_arr_view)
		{
			$data['grade_list'] = $this->common_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
		}
		else
		{
			$data['grade_list'] = $this->common_model->get_table("manage_grade","id, name", "status = 1", "name asc");
		}
		
		if($level_arr_view)
		{
			$data['level_list'] = $this->common_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
		}
		else
		{
			$data['level_list'] = $this->common_model->get_table("manage_level","id, name", "status = 1", "name asc");
		}
		
          $data['question']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]);
          //$data['answer']=$this->Survey_model->get_data('survey_answers',$where=['question_id'=>$questionID]);
          //echo '<pre />';
          $qarray=[];
          foreach($data['question'] as $qu)
          {
             $qarray[$qu['QuestionName']]= $this->Survey_model->get_data('survey_answers',$where=['question_id'=>$qu['question_id']]);
             
          }
          $finalarr=[];
          foreach($qarray as $key=>$sa)
          {
              foreach($sa as $s)
              {
				  if($user_ids)
				  {
					  $where='question_id = '.$s['question_id'].' AND surveyAnsID = '.$s['surveyAnsID'].' AND user_id IN ('.$user_ids.')';
					  $anscount=$this->Survey_model->get_data('user_survey_answer',$where);
				  }
				  else
				  {
					  $anscount=$this->Survey_model->get_data('user_survey_answer',$where=['question_id'=>$s['question_id'],'surveyAnsID'=>$s['surveyAnsID']]);
				  }
				  
                 $finalarr[$key][$s['Answer']]=count($anscount);
              }
          }

		$data['UserIds']=$user_ids;
		$data['result']=$finalarr;
		$data['title'] = "Survey Result";
		$data['body'] = "survey/d3result";
		$data['surveyinfo'] = $this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyID]);

         $this->load->view('common/structure',$data);
      }
      
    function updatesurvey($survey_id,$status,$addurl='')
    {
		$survey_check = $this->Survey_model->get_survey_questoin_ans($survey_id);
		if($survey_check > 0) {
			$survey = $this->Survey_model->get_data('survey',$where=['survey_id'=>$survey_id]);
			if(isset($survey[0]['country']) && $survey[0]['country']==''){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_complete_forpublish_survey').'</b></div>');
				redirect(base_url('survey/survey_filters/'.$survey_id));
			}
			if(isset($survey[0]['start_date']) && $survey[0]['start_date']=='0000-00-00'){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_complete_forpublish_survey').'</b></div>');
				redirect(base_url('survey/publish/'.$survey_id));
			}
			if(($survey[0]['status'] != 1) && (int)$status > 0){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>This Survey is not Active. Change Active Status.</b></div>');
				redirect(base_url('survey/publish/'.$survey_id));
			}
			$db_arr=[
				"is_published"=> $status,
			];
			$surveyID=$this->Survey_model->updatedata('survey',$db_arr,$where=['survey_id'=>$survey_id]); 
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_update').'</b></div>');
            if(!empty($addurl) && $addurl=="launchComplete"){
            	$this->session->set_flashdata('message', '<div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You successfully launched survey. To track your survey live, please go to your dashboard. </b></div></div></div>');
            	redirect(base_url('survey/dashboard-analytics/launch'));
            	//redirect(base_url('survey'));
            }
            if(!empty($addurl)){
            	redirect(base_url('survey/dashboard-analytics/'.$addurl));
            }
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_complete_forpublish_survey').'</b></div>');
			redirect(base_url('survey/questions_create/'.$survey_id));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	function publish($surveyId, $page="") {
		if(empty($surveyId)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_found_survey').'</b></div>');
                redirect(base_url('survey/create'));
		}
		$data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyId]);
		$data['survey'] = $this->Survey_model->get_data('survey',$where=['survey_id'=>$surveyId]);
		if( !($data['survey']) ){
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_exist_survey').'</b></div>');
			redirect(base_url('survey/dashboard-analytics'));
		}
		if(isset($data['survey'][0]['is_published']) && $data['survey'][0]['is_published']==3){
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_edit_completed_survey').'</b></div>');
			redirect(base_url('survey/dashboard-analytics'));
		}

		if($this->input->post()) {

			if(empty($data['questions']) && (int)$this->input->post('is_published') != 0) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_question_req_survey').'</b></div>');
				redirect(base_url('survey/questions_create/'.$surveyId));
			}

			if(empty($data['survey'][0]['survey_for']) && (int)$this->input->post('is_published') != 0) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_filter_req_survey').'</b></div>');
				redirect(base_url('survey/survey_filters/'.$surveyId));
			}


			$this->form_validation->set_rules('is_published', 'Publishing Status', 'trim|required|integer');
			$this->form_validation->set_rules('surevy_open_periods', 'Open Periods (in days)', 'trim|required|integer');

			if((int)$this->input->post('is_published') == 0){
				$this->form_validation->set_rules('start_dt', 'Start Date', 'trim|required');
				$this->form_validation->set_rules('survey_type', 'Type', 'trim|required|integer');
				$this->form_validation->set_rules('frequency_dependent_on', 'Frequency Dependent On', 'trim|integer');
				$this->form_validation->set_rules('frequency_days', 'Frequency Days Confirmation', 'trim|integer');
				$this->form_validation->set_rules('is_active', 'Active Status', 'trim|integer');
			}

			if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.validation_errors().'</b></div>');
				redirect($_SERVER['HTTP_REFERER']);
            }

			if((int)$data['survey'][0]['is_published'] == 0){
				$type = $this->input->post('survey_type');
				$stdate = explode('/',$this->input->post('start_dt'));
				$date = $stdate[2].'-'.$stdate[1].'-'.$stdate[0];
				$day = $this->input->post('surevy_open_periods');
				$enddate = strtotime("+".$day." day", strtotime($date));
			    
	            if(strtotime(date("Y-m-d")) > $enddate ){ 
	            	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_not_less_date_survey').'</b></div>');
					redirect($_SERVER['HTTP_REFERER']);
				}

				$updateArray = array(
					'survey_type' 			=> $type,
					'start_date'	  		=> $date,
					'is_published'			=> $this->input->post('is_published'),
					'status'				=> $this->input->post('is_active'),
					'surevy_open_periods' 	=> $this->input->post('surevy_open_periods'),
				);
			} else {
				$updateArray = array(
					'is_published'			=> $this->input->post('is_published'),
					'surevy_open_periods' 	=> $this->input->post('surevy_open_periods')
				);
			}
			
			if($type == CV_SURVEY_TYPE_PERIODIC) {
				$updateArray['frequency_dependent_on'] 	= $this->input->post('frequency_dependent_on');
				$updateArray['frequency_days'] 			= $this->input->post('frequency_days');
			}

			$surveyID = $this->Survey_model->updatedata('survey',$updateArray,$where=['survey_id'=>$surveyId]);

			if($this->input->post('is_published') == CV_SURVEY_PUBLISHED_TRUE) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_published_survey').'</b></div>');
			} else {
				if((int)$data['survey'][0]['is_published'] == 0){
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Survey is ready to launch</b></div>');
					
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_update').'</b></div>');
				}
			}
			if($page=="create"){
				redirect(base_url('survey/launch/'.$surveyId));
			}
			
			// redirect(base_url('survey/dashboard-analytics'));
			redirect($_SERVER['HTTP_REFERER']);
			
		} else {
				
	        // $data['category'] = $this->Survey_model->getCompanyCategory();
	        $data['survey_id']=$surveyId;
			$data['pageName']='setupsurvey';
			$data['title'] = 'Survey';
			$data['body'] = "survey/create";
			$this->load->view('common/structure',$data);		
		}
	}

	public function launch($surveyID) 
	{
		if(empty($surveyID)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_found_survey').'</b></div>');
                redirect(base_url('survey/create'));
		}
		$data['questions'] = $this->Survey_model->show_company_survey($surveyID);
		$data['survey'] = $this->Survey_model->get_data('survey', array('survey_id'=> $surveyID,'status != '=> 4));
		if(empty($data['survey'])){
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_exist_survey').'</b></div>');		
            redirect(site_url("survey/dashboard-analytics"));
		}
		if(isset($data['survey'][0]['is_published']) && $data['survey'][0]['is_published']==3){
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_edit_completed_survey').'</b></div>');
			redirect(base_url('survey/dashboard-analytics'));
		}
		if( empty($data['questions']) ) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_question_req_survey').'</b></div>');
			redirect(base_url('survey/questions_create/'.$surveyID));
		}

		if( empty($data['survey'][0]['survey_for']) ) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_filter_req_survey').'</b></div>');
			redirect(base_url('survey/survey_filters/'.$surveyID));
		}
		// $data['questions']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]);
		
		$data['result']=$data['questions'];
		$data['showfilter'] = true;
		$data['survey_id']=$surveyID;
		$data['pageName']='launchSurvey';
		$data['title'] = 'Survey';
		$data['body'] = 'survey/create';
		$this->load->view('common/structure',$data);
	}
	
	/************ Survey new part start ****************/  

	// function get_category_info_NIU() {
	// 	$category_id = $this->input->post('category_id');
	// 	$survey = $this->Survey_model->getAdminSurvey('survey',array('category_id' =>$category_id, 'status'=> CV_STATUS_ACTIVE, 'is_published > ' => 0));
	// 	echo json_encode($survey);
	// }

	// function get_exists_category_info_NIU() {
	// 	$category_id = $this->input->post('category_id');
	// 	$survey = $this->Survey_model->getCategorySurvey('survey',array('category_id' =>$category_id, 'status'=> CV_STATUS_ACTIVE));
	// 	echo json_encode($survey);
	// }

	function copy_admin_exists_survey() {
		$survey_id = $this->input->post('surveyid');
		$result = $this->Survey_model->copy_admin_survey($survey_id);
		echo json_encode($result);
	}

	function copy_company_exists_survey() {
		$survey_id = $this->input->post('surveyid');
		$result = $this->Survey_model->copy_company_survey($survey_id);
		echo json_encode($result);
	}

	// function show_admin_survey_NIU() {
	// 	$survey_id = $this->input->post('surveyid');
	// 	echo $this->Survey_model->show_admin_survey($survey_id);
		
	// }

	// function show_company_survey_NIU() {
	// 	$survey_id = $this->input->post('surveyid');
	// 	$result = json_encode($this->Survey_model->show_company_survey($survey_id));
	// 	echo $result;
	// }

	function reset_token() {
		echo $this->security->get_csrf_hash();
	}


	public function viewsurvey($surveyID) {

		if(!helper_have_rights(CV_SURVEY, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');		
            redirect(site_url("dashboard"));
		}
		if(empty($surveyID)){
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_exist_survey').'</b></div>');		
            redirect(site_url("survey/dashboard-analytics"));
		}

		//$data['survey'] = $this->Survey_model->get_data('survey', array('survey_id'=> $surveyID,'status != '=> 4, 'is_published > '=>0));
		$data['survey'] = $this->Survey_model->get_data('survey', array('survey_id'=> $surveyID,'status != '=> 4));
		if(empty($data['survey'])){
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_record_not_exist_survey').'</b></div>');		
            redirect(site_url("survey/dashboard-analytics"));
		}

		$data['result'] = $this->Survey_model->show_company_survey($surveyID);
		// echo "<pre>";
		// print_r($data['survey']);
		// die;
		$data['title'] = 'View Survey';
		$data['body'] = 'survey/view_survey';
		$this->load->view('common/structure',$data);
	}

	public function aimzone(){
		$data['aimlist'] = $this->Survey_model->getAimZoneMaster('(az.createdby="'.$this->session->userdata('userid_ses').'" or az.aim_owner_id ="'.$this->session->userdata('userid_ses').'" or (azi.item_owner_id ="'.$this->session->userdata('userid_ses').'" AND `azi`.`is_active` = "'.CV_STATUS_ACTIVE.'"))');
		// if(empty($data['aimlist'])) {
		// 	redirect(base_url('survey/aim-zone-details'));
		// }
		$data['title'] = 'Action Planning Zone';
		$data['body'] = 'survey/aimzone';
		// echo "<pre>";print_r($data);die();
		$this->load->view('common/structure',$data);
    }

    public function aimzone_details($pagetype, $aimzoneId){

    	$data['editowner'] = false;
    	$data['editsurvey'] = false;
    	$data['getitem'] = false;
    	$data['pagetype'] = (!empty($pagetype))?$pagetype:"create";
    	$data['aimItemList'] = array();
    	if(isset($aimzoneId) && !empty($aimzoneId)){
    		//check the condition create by or owner
    		$data['aimlist'] = $this->Survey_model->getAimZoneMaster('az.id="'.$aimzoneId.'" AND (az.createdby="'.$this->session->userdata('userid_ses').'" or az.aim_owner_id ="'.$this->session->userdata('userid_ses').'" or (azi.item_owner_id ="'.$this->session->userdata('userid_ses').'" AND `azi`.`is_active` = "'.CV_STATUS_ACTIVE.'"))');
    		if(empty($data['aimlist'])){
    			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_right').'</b></div>');
				redirect(base_url('survey/aim-zone'));
    		}
    		if(($data['aimlist'][0]['createdby'] == $this->session->userdata('userid_ses') || $data['aimlist'][0]['aim_owner_id'] == $this->session->userdata('userid_ses'))){
    			$data['getitem'] = true;
    			if($data['pagetype']=="edit"){
    				$data['editowner'] = true;
    			}
    		}
    		if($data['aimlist'][0]['createdby'] == $this->session->userdata('userid_ses')) {
    			$data['getitem'] = true;
    			if($data['pagetype']=="edit"){
    				$data['editsurvey'] = true;
    			}
    		}
    		if($data['getitem']){
    			$data['aimItemList'] = $this->Survey_model->getAimZoneItem(array('azi.is_active'=> CV_STATUS_ACTIVE, 'azi.aimzone_id'=>$aimzoneId));
    		} else {
    			$data['aimItemList'] = $this->Survey_model->getAimZoneItem('(azi.createdby="'.$this->session->userdata('userid_ses').'" or azi.item_owner_id ="'.$this->session->userdata('userid_ses').'") AND azi.is_active='.CV_STATUS_ACTIVE.' AND azi.aimzone_id = '.$aimzoneId);
    		}
    		if(empty($data['aimItemList'])){
    			redirect(base_url('survey/aim-zone-details'));
    		};
    	}

    	if($this->input->post()) {
    		$inputArr = $this->input->post();
    		for ($i=0; $i < count($inputArr['focus']); $i++) {

            	if(!empty($inputArr['status'][$i]) && $inputArr['status'][$i]==2){
	            	if( empty($inputArr['focus'][$i]) || empty($inputArr['action'][$i]) || empty($inputArr['impact'][$i]) || empty($inputArr['metric'][$i]) || empty($inputArr['comment'][$i]) || empty($inputArr['aim_action_status'][$i]) ){
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_required_validation').'</b></div>');
						redirect($_SERVER['HTTP_REFERER']);
					}
            	}else{
            		if( empty($inputArr['focus'][$i]) || empty($inputArr['action'][$i]) || empty($inputArr['impact'][$i]) || empty($inputArr['metric'][$i]) || empty($inputArr['comment'][$i]) || empty($inputArr['status'][$i]) ){
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_required_validation').'</b></div>');
						redirect($_SERVER['HTTP_REFERER']);
					}
            	}
            	if(empty($inputArr['aim_item_owner_id'][$i])){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please Select Action Item Owner from Autocomplete dropdown.</b></div>');
					redirect($_SERVER['HTTP_REFERER']);
				}
    		}

    		if(isset($aimzoneId) && !empty($aimzoneId)) {
    			$aimID = $aimzoneId;
	    		if( isset($inputArr['survey_id']) || isset($inputArr['aim_owner'])) {	
	    			$update_master_arr = [
							"updatedby" => $this->session->userdata('userid_ses'),
							"updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
							"updatedon" => date("Y-m-d H:i:s")
						];
	    			if($data['editsurvey']){
	    				$update_master_arr["survey_id"] = $this->input->post('survey_id');
	    			}
	    			if($data['editowner']){
	    				$update_master_arr["aim_owner_id"] = $this->input->post('aim_owner');
	    			}
	    			$updateID = $this->Survey_model->updatedata('survey_aimzone_master', $update_master_arr, array("id"=> $aimzoneId));
	    		}
    		} else {

	    		// Validation --
	    		$this->form_validation->set_rules('survey_id', 'Survey', 'trim|required|integer');
				$this->form_validation->set_rules('aim_owner', 'Owner', 'trim|required|integer');
				if ($this->form_validation->run() == FALSE)
	            {
	                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.validation_errors().'</b></div>');
					redirect($_SERVER['HTTP_REFERER']);
	            }

	            // Insert Aimzone master table array
	    		$master_arr = [
					"survey_id"=> $this->input->post('survey_id'),
					"aim_owner_id" => $this->input->post('aim_owner'),
					"createdby" => $this->session->userdata('userid_ses'),
					"createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
					"createdon" => date("Y-m-d H:i:s")
				];
	    		$aimID = $this->Survey_model->savedata('survey_aimzone_master',$master_arr);
    		}

    		if( isset($inputArr['aimItem_id']) ) {
    			$ToUpdateAimID = $inputArr['aimItem_id'];
    			$aim_items_update['is_active'] = 2;
    			$aim_items_update['updatedby'] = $this->session->userdata('userid_ses');
    			$aim_items_update['updatedby_proxy'] = $this->session->userdata('proxy_userid_ses');
    			$aim_items_update['updatedon'] = date("Y-m-d H:i:s");
    			$updateID = $this->Survey_model->updateWhereIn('survey_aimzone_items',$aim_items_update,"id",$ToUpdateAimID);
			}

			if(isset($inputArr['focus'])) {
	    		// aimzone item table array
	    		for ($i=0; $i < count($inputArr['focus']); $i++) { 
	    			$aim_items[$i]['focus'] = $inputArr['focus'][$i];
	    			$aim_items[$i]['action'] = $inputArr['action'][$i];
	    			$aim_items[$i]['impact'] = $inputArr['impact'][$i];
	    			$aim_items[$i]['metric'] = $inputArr['metric'][$i];
	    			$aim_items[$i]['comment'] = $inputArr['comment'][$i];
	    			$aim_items[$i]['status'] = $inputArr['status'][$i];
	    			if($inputArr['status'][$i]==2){
	    				$aim_items[$i]['aim_action_status'] = $inputArr['aim_action_status'][$i];
	    			}else{
	    				$aim_items[$i]['aim_action_status'] = 0;
	    			}
	    			$aim_items[$i]['item_owner_id'] = $inputArr['aim_item_owner_id'][$i];
	    			$aim_items[$i]['aimzone_id'] = $aimID;
	    			$aim_items[$i]['is_active'] = 1;
	    			$aim_items[$i]['createdby'] = $this->session->userdata('userid_ses');
	    			$aim_items[$i]['createdby_proxy'] = $this->session->userdata('proxy_userid_ses');
	    			$aim_items[$i]['createdon'] = date("Y-m-d H:i:s");
	    		}
	    		// echo "<pre>"; print_r($inputArr); print_r($master_arr); print_r($aimID); print_r($aim_items); print_r($$aim_itemID); die();
	    		$aim_itemID = $this->Survey_model->saveBatch('survey_aimzone_items',$aim_items);
	    	}

    		if($data['editowner'] || $data['pagetype'] == "create")
			{
				############ Get SMTP DEtails FOR Sending Mail #############

                   $email_config=HLP_GetSMTP_Details();

                 #############################################################
				$emailTemplate=$this->common_model->getEmailTemplate("surveyActionPlan");
				$emaildetails = $this->Survey_model->getAimZoneMasterforEmail(array('az.id'=>$aimID));

					$str=str_replace("{{reciver_name}}",$emaildetails[0]['name'], $emailTemplate[0]->email_body);

					$mail_body=$str;

					$mail_sub =  $emailTemplate[0]->email_subject;
				
				//$this->common_model->send_emails(CV_EMAIL_FROM, trim($emaildetails[0]['email']), $mail_sub, $mail_body, trim($emaildetails[0]['cemail']));
				

               $this->common_model->send_emails($email_config['email_from'], trim($emaildetails[0]['email']), $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname'],trim($emaildetails[0]['cemail']));
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_save').'</b></div>');
			redirect(base_url('survey/aim-zone'));
    	}
    	
    	$data['survey'] = $this->Survey_model->getData('survey', "survey_name, survey_id", array('status != '=> 4, 'is_published'=>3));

		$data['title'] = 'Deatils of Action Planning Zone';
		$data['body'] = 'survey/aimzone_details';
		// echo "<pre>";print_r($data);die();
		$this->load->view('common/structure',$data);
    }

    public function get_users_for_aim(){
    	$term = $this->input->get('term', TRUE);
		$result = $this->Survey_model->getAutoCompleteUser($term); 
		echo json_encode($result);
	}

	public function aimzone_delete(){
		$id = $this->input->post('aimid');
		$result = $this->Survey_model->updatedata('survey_aimzone_items',array("is_active"=>"3"),array("id"=>"$id"));
		if($result){
			echo json_encode(array("status"=>true,"msg"=>"Deleted successfully"));
		}else{
			echo json_encode(array("status"=>false,"msg"=>"Some Error to Deleted"));
		}
	}

	public function sevenrs(){
		$data['title'] = '7Rs';
		$data['body'] = 'survey/sevenrs';
		$this->load->view('common/structure',$data);
	}

	public function thanks_message($survey_id)
    {   
    	 $data["survey_id"]=$survey_id;
    	$data['survey'] = $this->Survey_model->getData('survey', "closing_description,survey_name", array('survey_id'=>$survey_id));
        $data['title'] = 'Dashboard';
		$data['body'] = 'survey/survey_thanks_mess';
		$this->load->view('common/structure',$data);
    }

    public function survey_welcome_message($survey_id)
    {   $data["survey_id"]=$survey_id;
    $data['survey'] = $this->Survey_model->getData('survey', "description,survey_name", array('survey_id'=>$survey_id));

        $data['title'] = 'Dashboard';
		$data['body'] = 'survey/survey_welcome_mess';
		$this->load->view('common/structure',$data);
    }


    public function survey_user_end()
    {   $data["survey_id"]=$survey_id;
        $data['title'] = 'Dashboard';
		$data['body'] = 'survey/survey_userend';
		$this->load->view('common/structure',$data);
    }

    public function accordian_with_table_NIU()
    {   
        $data['title'] = 'Accordian with table ';
		$data['body'] = 'survey/accordian-with-table-NIU';
		$this->load->view('common/structure',$data);
    }

	public function get_survey_results_rpt($survey_id)
	{		
		$usr_survey_res_dtls = $this->common_model->get_table("user_survey_response", "id, user_id, (SELECT email FROM login_user WHERE id = user_id) AS user_email", array("survey_id"=>$survey_id), "id ASC");
		
		$csv_file_name = "Survey-Result.csv";
		header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $csv_file_name . '"');
        $fp = fopen('php://output', 'wb');
		
		$head_arr = array();
        $head_arr["Email"] = "Email";
		$head_arr["Question Name"] = "Question Name";
		$head_arr["Response"] = "Response";
		fputcsv($fp, $head_arr);
		
		foreach($usr_survey_res_dtls as $row)
		{ 
			$q_ans_dtls = $this->common_model->get_table("user_survey_answer", "question_id, surveyAnsID, textAnswer, (SELECT p_qid FROM survey_questions WHERE survey_questions.question_id = user_survey_answer.question_id) AS p_qid, (SELECT QuestionName FROM survey_questions WHERE survey_questions.question_id = user_survey_answer.question_id) AS QuestionName, (SELECT QuestionType FROM survey_questions WHERE survey_questions.question_id = user_survey_answer.question_id) AS QuestionType, (SELECT Answer FROM survey_answers WHERE survey_answers.surveyAnsID = user_survey_answer.surveyAnsID) AS users_ans", array("user_survey_response_id"=>$row["id"], "user_id"=>$row["user_id"]), "userAnswerID ASC");
			$q_ids_arr = array();
			//echo "<pre>";print_r($q_ans_dtls);die;
			foreach($q_ans_dtls as $q_row)
			{
				if(!in_array($q_row["question_id"], $q_ids_arr))
				{
					$response_arr = array();
					$response_arr[] = $row["user_email"];
					$response_arr[] = $q_row["QuestionName"];
					if($q_row["QuestionType"]==1)
					{
						$response_arr[] = $q_row["users_ans"];
					}
					elseif($q_row["QuestionType"]==2)
					{
						$response_arr[] = $q_row["textAnswer"];
					}
					elseif($q_row["QuestionType"]==3)
					{
						$ans_arr = array();
						if($q_row["users_ans"])
						{
							$ans_arr[] = "Choosed Opt: ". $q_row["users_ans"];
						}
						if($q_row["textAnswer"])
						{
							$ans_arr[] = " Text Answer: ". $q_row["textAnswer"];
						}
						$response_arr[] = implode(", ", $ans_arr);
					}
					elseif($q_row["QuestionType"]==4)
					{
						unset($response_arr[1]); 						
						$p_q_dtls = $this->admin_model->get_table_row("survey_questions", "QuestionName", array("question_id"=>$q_row["p_qid"]), "question_id ASC");
						$response_arr[] = "Question: ". $p_q_dtls["QuestionName"]." Option: ". $q_row["QuestionName"];
						$response_arr[] = $q_row["textAnswer"];
					}
					elseif($q_row["QuestionType"]==5 or $q_row["QuestionType"]==6)
					{
						$response_arr[] = $q_row["textAnswer"];
					}
					elseif($q_row["QuestionType"]==7)
					{						
						$ans_arr = array();
						foreach($q_ans_dtls as $qans_row)
						{
							if($q_row["question_id"] == $qans_row["question_id"])
							{
								if($q_row["users_ans"])
								{
									$ans_arr[] = "Ans: ". $qans_row["users_ans"];
								}
							}
						}
						$response_arr[] = implode(", ", $ans_arr);
					}					
					$q_ids_arr[] = $q_row["question_id"];
					fputcsv($fp, $response_arr);
				}				
			}
        }
	}


}
