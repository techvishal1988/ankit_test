<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Table_settings extends CI_Controller 
{	 
	public function __construct()
	{		
		parent::__construct();		
		date_default_timezone_set('Asia/Calcutta');
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');	
		$this->load->model("template_model");
		$this->load->model("admin_model");
		$this->load->model("common_model");
		$this->load->model("rule_model");
		$this->load->model("bonus_model");
		$this->lang->load('message', 'english');
		HLP_is_valid_web_token();
	}
	
	public function index()
	{
		$con= array('module_name' =>'hr_screen');
		$data['msg'] = "";
		$data['table_attribute_list'] = $this->admin_model->get_table_attributes($con);
		$data['title'] = "Salary Review Table Settings";
		$data['body'] = "admin/table_setting/table_setting";
		$this->load->view('common/structure', $data);
	}

	public function updateSettings()
	{
		$result=$this->admin_model->updateSettings();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Update Table Settings</b></div>');

		redirect($_SERVER['HTTP_REFERER']);
	}

	 public function updateTableHideShow($id,$status)
	{
		$result=$this->admin_model->updateTableHideShow($id,$status);
		return true;
	}

	 public function changeOrder()
	{
		//print_r($_POST['data']);
		$result=$this->admin_model->changeOrder();
		return true;
	}

	
	
	

}
