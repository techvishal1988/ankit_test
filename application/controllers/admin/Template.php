<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller 
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
	
	public function checkTitle()
	{
		$title=$this->input->post('title');
		$status=$this->template_model->get_templates("template",array("TemplateTitle"=>$title));
		echo count($status);
	}

	public function template($templateID ='')
	{
		if($templateID){
			$data['st_save'] = 2;
		} else {
			$data['st_save'] = 1;
		}
		$data['ba_attr']=$this->template_model->BussinessAtt();
		$data['rating_for_current_yr'] = $this->template_model->manage_rating_for_current_year();

		
		if(!helper_have_rights(CV_CREATE_TEMPLATE, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></span></div>';	
			redirect(site_url("dashboard"));
		}
		
		if($templateID)
		{
	$data['templatedesc']=$this->template_model->getTemplate($templateID);
	// print_r($data['templatedesc']);
	// die;
			if(!$data['templatedesc'])
			{
				redirect(site_url("admin/template/template"));
			}
		}
		
		if ($this->input->post()) {


			if ($templateID) {
				$this->form_validation->set_rules('title', 'Template Title', 'trim|required|max_length[150]');
			} else {
				$this->form_validation->set_rules('title', 'Template Title', 'trim|required|max_length[150]|is_unique[template.TemplateTitle]', array('is_unique' => 'This %s already exists.'));
			}

			//$this->form_validation->set_rules('desc', 'Template', 'trim|required|max_length[50000]');
			// remove max length validation according to sachin sir
$this->form_validation->set_rules('desc', 'Template', 'trim|required');

			if ($this->form_validation->run()) {


				$templatedata['RuleType'] = 'salary';
				$templatedata['TemplateTitle'] = $this->input->post('title');
				$templatedata['TemplateDesc'] = addslashes($this->input->post('desc'));
				$templatedata['PromotionDesc'] = addslashes($this->input->post('promotion_desc'));

				if (!empty($_FILES['latterhead']['name'])) {
					$upload_arr = HLP_upload_img('latterhead', "uploads/", 2048);
					if (count($upload_arr) == 2) {
						$f_path = 'uploads/' . $upload_arr[0];
						$templatedata['latter_head_url'] = base_url() . $f_path;
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $upload_arr[0] . '</b></div>');
						if ($templateID) {
							redirect('admin/template/template/' . $templateID);
						} else {
							redirect('admin/template/template');
						}
					}
				}
				if (!empty($_FILES['digital_signature']['name'])) {
					$upload_arr = HLP_upload_img('digital_signature', "uploads/", 2048);
					if (count($upload_arr) == 2) {
						$f_path = 'uploads/' . $upload_arr[0];
						$templatedata['`digital_signature_url` '] = base_url() . $f_path;
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $upload_arr[0] . '</b></div>');
						if ($templateID) {
							redirect('admin/template/template/' . $templateID);
						} else {
							redirect('admin/template/template');
						}
					}
				}

				if ($templateID) {
					$this->template_model->updateTemplate($templateID, $templatedata);
$delrow =  $this->template_model->deleteTemplate($templateID);
if($delrow>0){
if ($data['rating_for_current_yr']) {
						foreach ($data['rating_for_current_yr'] as $rating_value) {
							$templateratingdata['template_id '] = $templateID;
							$templateratingdata['raing_id'] = $rating_value['id'];
							$templateratingdata['raing_desc'] = $this->input->post('rating_desc' . $rating_value['id']);
							$this->template_model->saveTemplateRating($templateratingdata);
						}
					}	
}


					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data updated successfully.</b></div>');
				} else {
					$templatedata['timestamp'] = date("Y-m-d H:i:s");
					$resid = $this->template_model->saveTemplate($templatedata);
					if ($data['rating_for_current_yr']) {
						foreach ($data['rating_for_current_yr'] as $rating_value) {
							$templateratingdata['template_id '] = $resid;
							$templateratingdata['raing_id'] = $rating_value['id'];
							$templateratingdata['raing_desc'] = $this->input->post('rating_desc' . $rating_value['id']);
							$this->template_model->saveTemplateRating($templateratingdata);
						}
					}

					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_template_save') . '</b></div>');
					redirect('admin/template/template');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
			}
			if ($templateID) {
				redirect('admin/template/template/' . $templateID);
			} else {
				$arrayinfo = array(
					'TemplateTitle' => $this->input->post('title'),
					'TemplateDesc' => $this->input->post('desc'),
					'PromotionDesc' => $this->input->post('promotion_desc'),
				);
				$data['templatedesc'] = array((object) $arrayinfo);
                // redirect('admin/template/template');
			}
		}


		$data['template'] = $this->template_model->getalltemplate();
		$removeColumn = array('id','rule_id','user_id','status','updatedby','updatedon','created_by','created_on','createdby_proxy','updatedby_proxy');
		$column = $this->db->list_fields('employee_salary_details');
		$result=array_diff($column,$removeColumn);
		$data['heads'] = $result;
		$data['title'] = "Create Letter Template";
		$data['body'] = "admin/template/template";
		$this->load->view('common/structure',$data);	

	}
	
	public function index()
	{
		$data['template']=$this->template_model->getalltemplate();
		if($this->session->userdata('keyword'))
		{
			@$arr = "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}
		$data['staff_list'] = $this->admin_model->get_staff_list(@$arr);
		$data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");			
		$data['title'] = "Staffs";
		$data['body'] = "admin/template/staff_list";
		$this->load->view('common/structure',$data);		
	}
	
public function delete_template($tempid)
{

$res=$this->admin_model->get_table_row('hr_parameter','id',array('template_id'=>$tempid));
// print_r($res);
// die();
if(!empty($res))
{
// $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show"><strong>Error!</strong><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>This template link with latter.So please unlink first.</b></div> ');

redirect(base_url('admin/template/template')); 
}
else
{
$this->admin_model->delete_min_pay_capping('template', array('TemplateID'=>$tempid));
$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Template successfully deleted</div>');	
redirect(base_url('admin/template/template'));
}



  
}

	public function rules()
	{
		$uid=$this->session->userdata('userid_ses');
		// $data['salary_rule_list']=$this->template_model->mysalaryrule('hr_parameter', 'status='.CV_STATUS_RULE_RELEASED.' AND id IN(SELECT rule_id FROM salary_rule_users_dtls WHERE user_id = '.$uid.' GROUP BY rule_id)');
		$data['salary_rule_list']=$this->template_model->mysalaryrule('hr_parameter', 'status>=6 AND status != '.CV_STATUS_RULE_DELETED.' AND  id IN(SELECT rule_id FROM salary_rule_users_dtls WHERE user_id = '.$uid.' GROUP BY rule_id)');
// echo $this->db->last_query();
// die;

		$data['bonus']=$this->template_model->mysalaryrule('hr_parameter_bonus', 'status='.CV_STATUS_RULE_RELEASED.' AND id IN(SELECT rule_id FROM bonus_rule_users_dtls WHERE user_id = '.$uid.' GROUP BY rule_id)');
		$data['lti']=$this->template_model->mysalaryrule('lti_rules', 'status='.CV_STATUS_RULE_RELEASED.' AND id IN(SELECT rule_id FROM lti_rule_users_dtls WHERE user_id = '.$uid.' GROUP BY rule_id)');
		$data['title'] = "List of compensation statement rules";
		$data['b_title']='Rules';
		$data['body'] = "admin/template/rule_list";
		$this->load->view('common/structure',$data);	
	}

	// public function view_letter($ruleID, $userID)
	// {
	// 	$data['userID'] = $userID; //$this->session->userdata('userid_ses');
	// 	$rule_dtls = $this->template_model->mysalaryrule("hr_parameter", "status=".CV_STATUS_RULE_RELEASED." AND id IN(SELECT rule_id FROM salary_rule_users_dtls WHERE user_id = ".$data['userID']." AND rule_id = '".$ruleID."' GROUP BY `rule_id`)");
	// 	if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
	// 	{
	// 		redirect(site_url("dashboard"));
	// 	}

	// 	$data['ruleID']=$ruleID;
	// 	$data['cycleID']=$rule_dtls[0]["performance_cycle_id"];
	// 	$data['templateID']=$rule_dtls[0]["template_id"];
	// 	$data['latterhead']=$this->template_model->getLatterHead();
	// 	//$data['salary']=$this->template_model->mysalaryrule('hr_parameter','id='.$ruleID.'  and performance_cycle_id='.$cycleID);
	// 	$data['salary']=$this->template_model->getSalaryDetail($data['ruleID'],$data['cycleID'],$data['templateID'],$data['userID']);
	// 	$data["target_total_sal_elems"] = $this->admin_model->get_table_row("manage_company","target_sal_elem, total_sal_elem", array("id"=>$this->session->userdata('companyid_ses')));
	// 	$data["defult_salary_elem_list"] = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", "(module_name = '".CV_SALARY_ELEMENT."' OR module_name = '".CV_BONUS_APPLIED_ON."')");
		
	// 	$data['staff_list'] = $this->template_model->get_data('login_user','id='.$data['userID']);
	// 	$data['templatedesc']=$this->template_model->getTemplate($data['templateID']);
		
	// 	/*$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$userID), "id desc");
	// 	$salary_elems = $this->rule_model->get_salary_applied_on_elememts_list("datum.data_upload_id = '".$users_last_tuple_dtls["data_upload_id"]."' AND datum.row_num = '".$users_last_tuple_dtls["row_num"]."' AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		
	// 	foreach($salary_elems as $row)
	// 	{
	// 		$data['salary'][0]["existing_".str_replace(' ','_',$row['display_name'])] = $row['value'];
	// 	}
	// 	echo "<pre>";print_r($data['salary']);die;*/
	// 	$data['title'] = "View letter";
	// 	$data['b_title']='Letter / View letter';
	// 	$data['body'] = "admin/template/pdf";
	// 	$this->load->view('common/structure',$data);			 
	// }
	public function view_letter_NIU($ruleID, $userID) {
         $url=explode('/',base64_decode($ruleID));
        
		if($userID!='')
		{
           $userID = $userID;
		}else
		{
           $userID = $url[1];
		}
         //$this->session->userdata('userid_ses');
       $data['userID'] = $userID;
       // $rule_dtls = $this->template_model->mysalaryrule('hr_parameter', 'id=' . $ruleID . ' and status=' . CV_STATUS_RULE_RELEASED);
         $rule_dtls = $this->template_model->mysalaryrule('hr_parameter', 'id=' . $url[0] . ' and status>=6');

        if (!$rule_dtls or HLP_requested_is_valid($userID) == false) {
            redirect(site_url("dashboard"));
        }

        $data['ruleID'] = $url[0];
        $data['cycleID'] = $rule_dtls[0]["performance_cycle_id"];
        $data['templateID'] = $rule_dtls[0]["template_id"];
        $data['latterhead'] = $this->template_model->getLatterHead();
       
 $data['salary'] = $this->template_model->get_data('employee_salary_details', 'rule_id = '.$url[0].' and  user_id=' . $data['userID']);
 $rating_for_last_year = $data['salary'][0]['rating_for_last_year'];

 $emp_rating = $data['salary'][0]['performance_rating'];

 $data['manage_rating_data'] = $this->template_model->get_data('manage_rating_for_current_year', 'name="' . $emp_rating.'"');
 // print_r( $data['manage_rating_data']);die;
$rating_id = $data['manage_rating_data'][0]['id'];

        $data['staff_list'] = $this->template_model->get_data('login_user', 'id=' . $data['userID']);

        $data['templatedesc'] = $this->template_model->get_data('template', 'TemplateID=' . $data['templateID']);
// print_r($data['templatedesc']);die;
 $data['templateratingdesc'] = $this->template_model->get_data('template_rating_desc', 'template_id=' . $data['templateID'] .' and raing_id='.$rating_id);
//print_r($data['templateratingdesc']);die;
 $manage_company = $this->template_model->get_data('manage_company', 'id=' .$this->session->userdata('companyid_ses'));

        $data['incentivedetails'] = $this->template_model->get_data('salary_rule_users_dtls', 'rule_id = '.$url[0].' and  user_id=' . $data['userID']);

        $html = $this->load->view("admin/template/pdf",$data,true);
        $filename = md5($data['userID']).".pdf";
 
        $this->load->library('m_pdf');
      
        //$this->m_pdf->pdf->open_layer_pane = true;
         //$this->m_pdf->pdf->BeginLayer(1);
        $url =$data['templatedesc'][0]['latter_head_url'];
        // $this->m_pdf->pdf->SetWatermarkImage($url, 0.4,'',10);
        // $this->m_pdf->pdf->showWatermarkImage = true;
        $this->m_pdf->pdf->SetHTMLHeader('<div style="width:100%;text-align:center ! important;"><img src="' .$url . '" style="width:80px; height:auto;margin-left:290px;margin-top:20px;"/></div>');
 /*$this->m_pdf->pdf->SetHTMLFooter('
 	<div style="width:100%; border-top: 1px solid black; height:110px;">
'.COMPANY_ADDRESS_FOR_LETTER.'	</div>
');*/

         $this->m_pdf->pdf->AddPage('', // L - landscape, P - portrait 
        '', '', '', '',
        15, // margin_left
        15, // margin right
       40, // margin top
       35, // margin bottom
        0, // margin header
        0); // margin footer
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($filename, "I");
        //$this->m_pdf->pdf->EndLayer(); 

    }
	
	public function view_letter($ruleID, $userID = 0) {

         $url=explode('/',base64_decode($ruleID));

		if($userID!='')
		{
           $userID = $userID;
		}else
		{
           $userID = $url[1];
		}

		if(empty($url[0]) || empty($userID)) {
			//if rule id or user id not found
			redirect(site_url("dashboard"));
		}

        $data['userID'] = $userID;
       // $rule_dtls = $this->template_model->mysalaryrule('hr_parameter', 'id=' . $ruleID . ' and status=' . CV_STATUS_RULE_RELEASED);
         $rule_dtls = $this->template_model->mysalaryrule('hr_parameter', 'id=' . $url[0] . ' and status>=6');

        if (!$rule_dtls or HLP_requested_is_valid($userID) == false) {
            redirect(site_url("dashboard"));
        }

        $data['ruleID'] = $url[0];
        $data['cycleID'] = $rule_dtls[0]["performance_cycle_id"];
        $data['templateID'] = $rule_dtls[0]["template_id"];
        $data['latterhead'] = $this->template_model->getLatterHead();
       
 $data['salary'] = $this->template_model->get_data('employee_salary_details', 'rule_id = '.$url[0].' and  user_id=' . $data['userID']);
 $rating_for_last_year = $data['salary'][0]['rating_for_last_year'];

 $emp_rating = $data['salary'][0]['performance_rating'];

 $data['manage_rating_data'] = $this->template_model->get_data('manage_rating_for_current_year', 'name="' . $emp_rating.'"');
 // print_r( $data['manage_rating_data']);die;
$rating_id = $data['manage_rating_data'][0]['id'];

        $data['staff_list'] = $this->template_model->get_data('login_user', 'id=' . $data['userID']);

        $data['templatedesc'] = $this->template_model->get_data('template', 'TemplateID=' . $data['templateID']);
// print_r($data['templatedesc']);die;
 $data['templateratingdesc'] = $this->template_model->get_data('template_rating_desc', 'template_id=' . $data['templateID'] .' and raing_id='.$rating_id);
//print_r($data['templateratingdesc']);die;
 $manage_company = $this->template_model->get_data('manage_company', 'id=' .$this->session->userdata('companyid_ses'));

        $data['incentivedetails'] = $this->template_model->get_data('salary_rule_users_dtls', 'rule_id = '.$url[0].' and  user_id=' . $data['userID']);

        $html = $this->load->view("admin/template/pdf",$data,true);
        $filename = md5($data['userID']).".pdf";
 
        $this->load->library('m_pdf');
      
        //$this->m_pdf->pdf->open_layer_pane = true;
         //$this->m_pdf->pdf->BeginLayer(1);
        $url =$data['templatedesc'][0]['latter_head_url'];
        // $this->m_pdf->pdf->SetWatermarkImage($url, 0.4,'',10);
        // $this->m_pdf->pdf->showWatermarkImage = true;
        //$this->m_pdf->pdf->SetHTMLHeader('<div style="width:100%;text-align:center ! important;"><img src="' .$url . '" style="width:80px; height:auto;margin-left:290px;margin-top:20px;"/></div>');
 /*$this->m_pdf->pdf->SetHTMLFooter('
 	<div style="width:100%; border-top: 1px solid black; height:110px;">
'.COMPANY_ADDRESS_FOR_LETTER.'	</div>
');*/

        /* $this->m_pdf->pdf->AddPage('', // L - landscape, P - portrait 
        '', '', '', '',
        15, // margin_left
        15, // margin right
       40, // margin top
       35, // margin bottom
        0, // margin header
        0); // margin footer
*/        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($filename, "I");
        //$this->m_pdf->pdf->EndLayer(); 

    }
	
	public function print_letter($ruleID, $userID)
	{
		$uid = $userID; //$this->session->userdata('userid_ses');
		$rule_dtls = $this->template_model->mysalaryrule('hr_parameter','FIND_IN_SET('.$uid.',user_ids) and id='.$ruleID.' and status='.CV_STATUS_RULE_RELEASED);
		if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
		{
			redirect(site_url("dashboard"));
		}

		$cycleID = $rule_dtls[0]["performance_cycle_id"];
		$templateID = $rule_dtls[0]["template_id"];		
		
		$data['latterhead']=$this->template_model->getLatterHead();
		//$uid=$this->session->userdata('userid_ses');
		//$data['salary']=$this->template_model->mysalaryrule('hr_parameter','id='.$ruleID.'  and performance_cycle_id='.$cycleID);
		$data['salary']=$this->template_model->getSalaryDetail($ruleID, $cycleID, $templateID, $uid);
		$data['staff_list'] = $this->template_model->get_data('login_user', 'id='.$uid);
		$data['templatedesc'] = $this->template_model->getTemplate($templateID);
		$data['title'] = "View Letter";
		$data['b_title']='Letter';
		$data['body'] = "admin/template/pdf";
		$this->load->view('admin/template/para',$data);	
	}
	
	public function print_letter_w($ruleID, $userID)
	{
		$uid = $userID; //$this->session->userdata('userid_ses');
		$rule_dtls = $this->template_model->mysalaryrule('hr_parameter','FIND_IN_SET('.$uid.',user_ids) and id='.$ruleID.' and status='.CV_STATUS_RULE_RELEASED);
		if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
		{
			redirect(site_url("dashboard"));
		}

		$cycleID = $rule_dtls[0]["performance_cycle_id"];
		$templateID = $rule_dtls[0]["template_id"];
		
		$data['userID']=$uid;
		$data['latterhead']=$this->template_model->getLatterHead();
		$data['salary']=$this->template_model->getSalaryDetail($ruleID, $cycleID, $templateID, $uid);
		$data['staff_list'] = $this->template_model->get_data('login_user','id='.$uid);
		$data['templatedesc']=$this->template_model->getTemplate($templateID);
		$data['title'] = "View Letter";
		$data['b_title']='Letter';
		$data['body'] = "admin/template/pdf";
		$this->load->view('admin/template/paraw',$data);			 
	}
	
	public function view_letter_bonus($ruleID, $userID)
	{
		$data['userID'] = $userID; //$this->session->userdata('userid_ses');
		
		$rule_dtls = $this->template_model->mysalaryrule("hr_parameter_bonus", "status=".CV_STATUS_RULE_RELEASED." AND id IN(SELECT rule_id FROM bonus_rule_users_dtls WHERE user_id = ".$data['userID']." AND rule_id = '".$ruleID."' GROUP BY `rule_id`)");
		
		if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
		{
			redirect(site_url("dashboard"));
		}

		$data['ruleID']=$ruleID;
		$data['cycleID']=$rule_dtls[0]["performance_cycle_id"];
		$data['templateID']=$rule_dtls[0]["template_id"];

		$data['latterhead']=$this->template_model->getLatterHead();
		$data['bonus']=$this->template_model->getBonusDetail($ruleID, $data['cycleID'], $data['templateID'], $data['userID']);
		$data['templatedesc']=$this->template_model->getTemplate($data['templateID']);
		$data['title'] = "View letter";
		$data['b_title']='Letter / View letter';
		$data['body'] = "admin/template/pdf";
		$data['print_url']='_bonus';
		$this->load->view('common/structure',$data);	
	}
	
	public function print_letter_bonus($ruleID, $userID)
	{
		$uid = $userID; //$this->session->userdata('userid_ses');
		$rule_dtls = $this->template_model->mysalaryrule('hr_parameter_bonus','FIND_IN_SET('.$uid.',user_ids) and id='.$ruleID.' and status='.CV_STATUS_RULE_RELEASED);
		
		if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
		{
			redirect(site_url("dashboard"));
		}

		$cycleID = $rule_dtls[0]["performance_cycle_id"];
		$templateID = $rule_dtls[0]["template_id"];
		
		$data['latterhead']=$this->template_model->getLatterHead();
		$data['bonus']=$this->template_model->getBonusDetail($ruleID, $cycleID, $templateID, $uid);
		$data['staff_list'] = $this->template_model->get_data('login_user','id='.$uid);
		$data['templatedesc']=$this->template_model->getTemplate($templateID);
		$data['title'] = "View Letter";
		$data['b_title']='Letter';
		$data['body'] = "admin/template/pdf";
		$this->load->view('admin/template/para',$data);			 
	}
	
	public function print_letter_w_bonus($ruleID, $userID)
	{
		$uid = $userID; //$this->session->userdata('userid_ses');
		$rule_dtls = $this->template_model->mysalaryrule('hr_parameter_bonus','FIND_IN_SET('.$uid.',user_ids) and id='.$ruleID.' and status='.CV_STATUS_RULE_RELEASED);
		
		if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
		{
			redirect(site_url("dashboard"));
		}

		$cycleID = $rule_dtls[0]["performance_cycle_id"];
		$templateID = $rule_dtls[0]["template_id"];
		$data['latterhead']=$this->template_model->getLatterHead();
		//$data['salary']=$this->template_model->mysalaryrule('hr_parameter','id='.$ruleID.'  and performance_cycle_id='.$cycleID);

		$data['userID'] = $uid;
		$data['bonus']=$this->template_model->getBonusDetail($ruleID, $cycleID, $templateID, $uid);
		$data['staff_list'] = $this->template_model->get_data('login_user','id='.$uid);
		$data['templatedesc']=$this->template_model->getTemplate($templateID);
		$data['title'] = "View Letter";
		$data['b_title']='Letter';
		$data['body'] = "admin/template/pdf";
		$this->load->view('admin/template/paraw',$data);
	}
	
	public function view_letter_lti($ruleID, $userID)
	{
		$data['userID'] = $userID; //$this->session->userdata('userid_ses');
		$rule_dtls = $this->template_model->mysalaryrule("lti_rules", "status=".CV_STATUS_RULE_RELEASED." AND id IN(SELECT rule_id FROM lti_rule_users_dtls WHERE user_id = ".$data['userID']." AND rule_id = '".$ruleID."' GROUP BY `rule_id`)");
		if(!$rule_dtls or HLP_requested_is_valid($userID)==false)
		{
			redirect(site_url("dashboard"));
		}

		$data['ruleID']=$ruleID;
		$data['cycleID']=$rule_dtls[0]["performance_cycle_id"];
		$data['templateID']=$rule_dtls[0]["template_id"];
		$data['latterhead']=$this->template_model->getLatterHead();
		$data['lti']=$this->template_model->getLTIDetail($ruleID, $data['cycleID'], $data['templateID'], $data['userID']);
		$data['templatedesc']=$this->template_model->getTemplate($data['templateID']);
		$data['title'] = "View letter";
		$data['b_title']='Letter / View letter';
		$data['body'] = "admin/template/pdf";
		$this->load->view('common/structure',$data);	
	}

	public function savepdf($templateID)
	{
		if($this->session->userdata('keyword'))
		{
			@$arr = "(login_user.name LIKE '%".$this->session->userdata('keyword')."%' or login_user.email LIKE '%".$this->session->userdata('keyword')."%')";
		}
		$data['staff_list'] = $this->template_model->get_staff_list(@$arr);


		$empids=$this->input->post('empids');
		$ids=explode(',',$empids);
		$data['templatedesc']=$this->template_model->getTemplate($templateID);
		$this->load->library('m_pdf');
		for($i=0;$i<count($ids);$i++)
		{
			$pdfFilePath = sha1($ids[$i]+time()).'.pdf';
			if (!is_dir('uploads/pdf/'.$ids[$i])) 
			{

				mkdir('./uploads/pdf/'.$ids[$i], 0777,TRUE);

			}
			$data['empid']=$ids[$i];    
			$location=$_SERVER['DOCUMENT_ROOT'].'/comp-ben-user-portal/uploads/pdf/'.$ids[$i].'/';     
			$html= $this->load->view('admin/template/pdf',$data,true);
//                    $this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->Output($location.$pdfFilePath, "F"); 
			$save=[
				'user_id'=>$ids[$i],
				'Pdf_name'=>$data['templatedesc'][0]->TemplateTitle,
				'Pdf_link'=>base_url().'uploads/pdf/'.$ids[$i].'/'.$pdfFilePath
			];
			$this->template_model->savedata('user_pdf',$save);
		}
	}
	
	public function viewtemplate()
	{
		
		$data['pdf']=$this->template_model->mypdf();
		$data['title'] = "Template List";
		$data['body'] = "admin/template/user_templates";
		$this->load->view('common/structure',$data);
		
	}
	
	public function get_old_template($ruleType)
	{
		$oldtemplates=$this->template_model->get_old_template('template',array('RuleType'=>$ruleType));
		echo json_encode($oldtemplates);
	}
	public function getTemplate($templateID)
	{
		$template=$this->template_model->getTemplate($templateID);
		echo json_encode($template);
	}
	public function getTemplateRatingDesc($templateID,$ratingID) {
		$template = $this->template_model->getTemplateRatingDesc($templateID,$ratingID);
		echo json_encode($template);
	}
	public function view_employee_increment_dtls($rule_id, $user_id, $upload_id)
	{	
		
		$data["rule_dtls"] = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
		$data['salary_dtls'] = $this->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$user_id));
		echo '<pre />';
		print_r($data['salary_dtls']); die;

	}
	public function view_employee_bonus_increment_dtls($rule_id, $user_id, $upload_id)
	{	
		$data["rule_dtls"] = $this->bonus_model->get_bonus_rule_dtls(array("hr_parameter_bonus.id"=>$rule_id));
		$data['staff_list'] = $this->bonus_model->get_rule_wise_emp_list_for_increments($rule_id);
		$data['bonus_dtls'] = $this->bonus_model->get_employee_bonus_dtls(array("employee_bonus_details.rule_id"=>$rule_id, "employee_bonus_details.user_id"=>$user_id));
		echo '<pre />';
		print_r($data['bonus_dtls']); die;
		;	
	}
	public function graph()
	{

		$employee_id = 2;
		$increment_applied_on_amt = 0;
		$performnace_based_increment_percet=0;
		$users_last_tuple_dtls = $this->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");
		$data['attr']=$this->template_model->getAttr($users_last_tuple_dtls['row_num'],$users_last_tuple_dtls['data_upload_id']);
		$data['title'] = "Graph";
		$data['body'] = "graph";
		$this->load->view('common/structure',$data);	
	}

	public function header_image()
	{
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['file_name']=time();
		$this->load->library('upload', $config);
		if($this->input->post('save'))
		{
			if (!$this->upload->do_upload('latterhead'))
			{
				if($this->upload->do_upload('latterhead')=='')
				{

				}
				$this->session->set_flashdata('message', '<label class="label-warning">'.$this->upload->display_errors().'</label>');
				redirect(base_url('admin/template/header_image'));


			}
			else
			{
				$data=[
					'latter_head_url'=>base_url().'uploads/'.$this->upload->data('file_name')
				];
				$this->template_model->header_image($data,$this->session->userdata('companyid_ses'));
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>letterhead successfully uploaded</div>');
				redirect(base_url('admin/template/header_image'));
			} 
		}
//            echo '<pre />';
//            print_r($this->session->userdata('companyid_ses'));
		$data['title'] = "Template format";
		$data['body'] = "admin/template/templateheader";
		$this->load->view('common/structure',$data);
	}

	

}
