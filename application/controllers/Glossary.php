<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Glossary extends CI_Controller 
{	 
	 public function __construct()
	 {		
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->load->library('session', 'encrypt');			
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');      
		$this->load->model('glossary_model');
		$this->lang->load('message', 'english');
		HLP_is_valid_web_token();
	 }
	
         public function index()
         {
             if(!helper_have_rights(CV_GLOSSARY, CV_VIEW_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_view_right_glossary').'</div>';		
                        redirect(site_url("dashboard"));
		}
             $data['glossary']=$this->glossary_model->get_glossary('glossary_of_terms',array());
             $data['title'] = "Glossary Listing";
             $data['body']='glossary/index';
             $this->load->view('common/structure',$data);
         }
         
         public function delete($id)
         {
             if(!helper_have_rights(CV_GLOSSARY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_delete_right_glossary').'</div>';		
                        redirect(site_url("dashboard"));
		}
            $res=$this->glossary_model->delete_glossary('glossary_of_terms',array('id'=>$id));
            if($res)
            {
                $msg='<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_delete_glossary').'</div>';
            }
            else 
            {
                 $msg='<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_delete_glossary_error').'</div>';
            }
            $this->session->set_flashdata('message',$msg);
            redirect(base_url('glossary/index/'.$id)); 
         }


     public function add()
	 {
        if(!helper_have_rights(CV_GLOSSARY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_add_right_glossary').'</div>';		
            redirect(site_url("dashboard"));
		}
		$data['msg'] = "";
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('textname', 'Text', 'trim|required|max_length[250]');
			$this->form_validation->set_rules('meaning', 'Meaning', 'trim|required|max_length[500]');
			
			if($this->form_validation->run())
			{
				$save_data=array(
								'text'=>$this->input->post('textname'),
								'meaning'=>$this->input->post('meaning'),
								'createdon' => date("Y-m-d H:i:s"),
								'createdby'=>$this->session->userdata('userid_ses'),
								'createdby_proxy'=>$this->session->userdata('proxy_userid_ses')
                    			);
				$res=$this->glossary_model->save('glossary_of_terms',$save_data);
				if($res)
				{
					$msg='<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_created_glossary').'</div>';
				}
				else 
				{
					 $msg='<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_created_glossary_error').'</div>';
				}
				$this->session->set_flashdata('message',$msg);
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.validation_errors().'</b></div>');
			}
			redirect(base_url('glossary/add'));		
		}		
		
		$data['title'] = "Glossary";
        $data['body']='glossary/add_edit';
		$this->load->view('common/structure',$data);
	}
    
	public function edit($id)
	{
        if(!helper_have_rights(CV_GLOSSARY, CV_INSERT_RIGHT_NAME))
		{
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_edit_right_glossary').'</div>';		
            redirect(site_url("dashboard"));
		}
		$data['msg'] = "";
		$data['glossary']=$this->glossary_model->get_glossary('glossary_of_terms',array('id'=>$id));
		if(!$data['glossary'])
		{
			redirect(base_url('glossary'));
		}
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('textname', 'Text', 'trim|required|max_length[250]');
			$this->form_validation->set_rules('meaning', 'Meaning', 'trim|required|max_length[500]');
			
			if($this->form_validation->run())
			{
				$save_data=array(
								'text'=>$this->input->post('textname'),
								'meaning'=>$this->input->post('meaning'),
								'updatedon' => date("Y-m-d H:i:s"),
								'updatedby'=>$this->session->userdata('userid_ses'), 
								"updatedby_proxy" => $this->session->userdata('proxy_userid_ses')
								);
				$res=$this->glossary_model->update('glossary_of_terms',$save_data,array('id'=>$this->input->post('id')));
				if($res)
				{
					$msg='<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_edit_right_glossary_success').'</div>';
				}
				else 
				{
					 $msg='<div class="alert alert-dabger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$this->lang->line('msg_no_edit_right_glossary_error').'</div>';
				}
				$this->session->set_flashdata('message',$msg);
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.validation_errors().'</b></div>');
			}
			redirect(base_url('glossary/edit/'.$id));			
		}
		
		$data['title'] = "Edit Glossary";
        $data['body']='glossary/add_edit';
		$this->load->view('common/structure',$data);
	}
	
	

}
