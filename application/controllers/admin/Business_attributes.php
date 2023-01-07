<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Business_attributes extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');		
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');	
		$this->load->model("business_attribute_model");
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9)
		{			
			redirect(site_url("dashboard"));			
		}
		HLP_is_valid_web_token();
    }	
	
	public function business_attributes_list()
	{
		$data['msg'] = "";	
		
		if(!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></span></div>');
			redirect(site_url("no-rights"));		
		}
		
		if(!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>';		
		}
		
		if($this->input->post())
		{
			$this->session->set_userdata('ba_attribute_status_ddl_ses',$this->input->post('ddl_attribute_status'));
			$this->session->set_userdata('ba_is_required_ddl_ses',$this->input->post('ddl_is_required'));
		}	
		
		$condition_arr = array();
		
		$ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
		if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
		{
			$ba_not_for = CV_MARKET_SALARY_ELEMENT;
		}
		
		$condition_arr["business_attribute.module_name !="] = $ba_not_for;
		
		if($this->session->userdata('ba_attribute_status_ddl_ses'))
		{
			$condition_arr["business_attribute.status"] = '0';
			if($this->session->userdata('ba_attribute_status_ddl_ses') == 'Yes')
			{
				$condition_arr["business_attribute.status"] = '1';
			}
		}
		if($this->session->userdata('ba_is_required_ddl_ses'))
		{
			$condition_arr["business_attribute.is_required"] = '0';
			if($this->session->userdata('ba_is_required_ddl_ses') == 'Yes')
			{
				$condition_arr["business_attribute.is_required"] = '1';
			}
		}

		$data['business_attributes_list'] = $this->business_attribute_model->get_business_attributes_list($condition_arr);				
		$data['title'] = "Business Attributes";
		$data['body'] = "admin/business_attributes_list";
		$this->load->view('common/structure',$data);		
	}

	public function update_attributes_status()
	{
		if(!helper_have_rights(CV_BUSINESS_ATTRIBUTES, CV_INSERT_RIGHT_NAME))
		{
			redirect(site_url("business-attributes"));		
		}
			
		if($this->input->post())
		{
			$required = json_decode(CV_BUSINESS_REQUIRED_ACTIVE_INACTIVE_ARRAY);
			if(!empty($required)) {
				$required_counter = $active_counter = 0;
				$counter =  count($required);
				for($i = 0; $i < count($required); $i++) {
					if(in_array($required[$i],$this->input->post('chk_ba_required'))) {
						$required_counter++;
					}
					if(in_array($required[$i],$this->input->post('chk_ba_active'))) {
						$active_counter++;
					}
				}

				if( ($required_counter != $counter) || ($active_counter != $counter) ) {
					redirect(site_url("business-attributes"));
				}
			}
			
			$active_salary_module = CV_MARKET_SALARY_CTC_ELEMENT;
			if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
			{
				$active_salary_module = CV_MARKET_SALARY_ELEMENT;
			}
			
			//$this->business_attribute_model->update_business_attributes(array("status"=>0, "is_required"=>0), array("module_name !="=> CV_EMAIL_MODULE_NAME));
			$this->business_attribute_model->update_business_attributes(array("status"=>0, "is_required"=>0), "module_name NOT In('".CV_EMAIL_MODULE_NAME."','".$active_salary_module."')");

			if(isset($_REQUEST["chk_ba_active"]) and ($_REQUEST["chk_ba_active"]))
			{
				$active_ba_ids = implode(",", $_REQUEST["chk_ba_active"]);				
				$this->business_attribute_model->update_business_attributes(array("status"=>1), "id in ($active_ba_ids) ");
			}

			if(isset($_REQUEST["chk_ba_required"]) and ($_REQUEST["chk_ba_required"]))
			{
				$required_ba_ids = implode(",", $_REQUEST["chk_ba_required"]);				
				$this->business_attribute_model->update_business_attributes(array("is_required"=>1), "id in ($required_ba_ids) ");
			}

			foreach($_REQUEST['hf_ba_id'] as $key=> $value) 
			{ 
				if($value>0 and trim($_REQUEST['txt_ba_display_name'][$key]) != "") 
				{ 
					$this->business_attribute_model->update_business_attributes(array("display_name"=>trim($_REQUEST['txt_ba_display_name'][$key])), array("id"=>$value));
				}
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Business attributes updated successfully.</b></div>'); 	
		}				
		redirect(site_url("business-attributes"));
	}

	/*public function change_business_attributes_status($id, $status)
	{
		$this->business_attribute_model->update_business_attributes(array("status"=>$status), array("id"=>$id));
		$this->session->set_flashdata('message', '<div align="left" style="color:blue;" id="notify"><span><b>Status updated successfully.</b></span></div>'); 			
		redirect(site_url("business-attributes"));
	}

	public function change_business_attributes_required($id, $status)
	{
		$this->business_attribute_model->update_business_attributes(array("is_required"=>$status), array("id"=>$id));
		$this->session->set_flashdata('message', '<div align="left" style="color:blue;" id="notify"><span><b>Required status updated successfully.</b></span></div>'); 			
		redirect(site_url("business-attributes"));
	}*/

	public function export_business_attributes()
	{
            if(!helper_have_rights(CV_BUSINESS_ATTRIBUTES, CV_VIEW_RIGHT_NAME))
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></div>');
			redirect(site_url("no-rights"));		
		}
		$data['business_attributes_list'] = $this->business_attribute_model->get_business_attributes_list(array("status"=>1));
		 header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=business_attributes.csv'); 
        header('Pragma: no-cache');
        header("Expires: 0");
        $outstream = fopen("php://output", "w");
        $csv_fields = array();
      
        foreach($data['business_attributes_list'] as $row)
        {
            $csv_fields[]  = $row["display_name"];
        }
		fputcsv($outstream, $csv_fields);
        fclose($outstream);
	}
}
