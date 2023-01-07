<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->load->library('session', 'encrypt');			
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');  
		$this->load->model('faq_model');	
		$this->lang->load('message', 'english');
		HLP_is_valid_web_token();
    }
	
	public function index()
	{
            if(!helper_have_rights(CV_FAQ, CV_VIEW_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right_faqs').'</b></div>';		
                        redirect(site_url("dashboard"));
		}
                $data['faq']=$this->faq_model->get_glossary('faq',array('status'=>1));
		$data['title'] = "FAQ";
		$data['body']='faq/faqs';
		$this->load->view('common/structure',$data);	
	}
        
        public function listing()
         {
            if(!helper_have_rights(CV_FAQ, CV_VIEW_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right_faqs').'</b></div>';		
                        redirect(site_url("dashboard"));
		}
             $data['glossary']=$this->faq_model->get_glossary('faq',array('status'=>1));
             $data['title'] = "FAQ Listing";
             $data['body']='faq/index';
             $this->load->view('common/structure',$data);
         }
        
        public function add()
        {
            if(!helper_have_rights(CV_FAQ, CV_INSERT_RIGHT_NAME))
			{
				$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right_faqs').'</b></div>';		
				redirect(site_url("dashboard"));
			}
			
			if($this->input->post())
			{
				$this->form_validation->set_rules('textname', 'Question', 'trim|required|max_length[250]');
				$this->form_validation->set_rules('meaning', 'Answer', 'trim|required|max_length[500]');
				
				if($this->form_validation->run())
				{
					$save_data=array(
									'question'=>$this->input->post('textname'),
									'answer'=>$this->input->post('meaning'),
									'createdon' => date("Y-m-d H:i:s"),
									'createdby'=>$this->session->userdata('userid_ses'),
									'createdby_proxy'=>$this->session->userdata('proxy_userid_ses')
									);
					$res=$this->faq_model->save('faq',$save_data);
					if($res)
					{
						$msg='<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_created_faqs').'</div>';
					}
					else 
					{
						 $msg='<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_created_faqs_error').'</div>';
					}
					$this->session->set_flashdata('message',$msg);
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.validation_errors().'</b></div>');
				}
				redirect(base_url('faq/add'));			
			}
		
           $data['title'] = "FAQ Add";
           $data['body']='faq/add_edit';
           $this->load->view('common/structure',$data); 
        }
        
    public function edit($id)
	{
        if(!helper_have_rights(CV_FAQ, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] ='<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_edit_right_faqs').'</b></div>';		
            redirect(site_url("dashboard"));
		}
		
		$data['msg'] = "";
		$data['faq']=$this->faq_model->get_glossary('faq',array('id'=>$id));
		if(!$data['faq'])
		{
			redirect(base_url('faq/listing'));
		}
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('textname', 'Question', 'trim|required|max_length[250]');
			$this->form_validation->set_rules('meaning', 'Answer', 'trim|required|max_length[500]');
			
			if($this->form_validation->run())
			{
				$save_data=array(
								'question'=>$this->input->post('textname'),
								'answer'=>$this->input->post('meaning'),
								'updatedon' => date("Y-m-d H:i:s"),
								'updatedby'=>$this->session->userdata('userid_ses'), 
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses')
								);
				$res=$this->faq_model->update('faq',$save_data,array('id'=>$this->input->post('id')));
				if($res)
				{
					$msg='<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_edit_right_faqs_success').'</div>';
				}
				else 
				{
					 $msg='<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_edit_right_faqs_error').'</div>';
				}
                $this->session->set_flashdata('message',$msg);
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.validation_errors().'</b></div>');
			}
			redirect(base_url('faq/edit/'.$id));			
		}
		
		$data['title'] = "Edit FAQ";
        $data['body']='faq/add_edit';
		$this->load->view('common/structure',$data);
	}
        
        function delete($id)
        {
            if(!helper_have_rights(CV_FAQ, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_delete_right_faqs').'</b></div>';		
                        redirect(site_url("dashboard"));
		}
            $save_data=[
                        'status'=>0,
                        'updatedby'=>$this->session->userdata('userid_ses'), 
                        "updatedby_proxy" => $this->session->userdata('proxy_userid_ses')
                    ];
                    $res=$this->faq_model->update('faq',$save_data,array('id'=>$id));
                    if($res)
                    {
                        $msg='<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_delete_faqs').'</div>';
                    }
                    else 
                    {
                         $msg='<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_delete_faqs_error').'</div>';
                    }
                    $this->session->set_flashdata('message',$msg);
                    redirect(base_url('faq/listing/'));
        }
	
	
}
