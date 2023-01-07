<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tooltip extends CI_Controller 
{	 
	public function __construct()
	{		
		parent::__construct();		
		date_default_timezone_set('Asia/Calcutta');
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');	
		$this->load->model("Tooltip_model");
		$this->load->model("admin_model");
		$this->load->model("common_model");
		$this->load->model("rule_model");
		$this->load->model("bonus_model");
		$this->lang->load('message', 'english');
		HLP_is_valid_web_token();		
	}
	
        public function index()
        {
            if(!helper_have_rights(CV_TOOLTIP, CV_VIEW_RIGHT_NAME))
		{
            $data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                        <b>'.$this->lang->line('msg_no_view_right_tips').'</b>
                            </div>';		
                        redirect(site_url("dashboard"));
		}
            $data['tooltips'] = $this->Tooltip_model->getAllTooltip();
			if(!$data['tooltips'])
			{
				redirect(site_url("admin/tooltip/create"));
			}
            $data['title']    = "Tooltip Listing";
            $data['body']     = "admin/tooltip/index";
            $this->load->view('common/structure',$data);	
        }

        // public function delete($tooltip_desc_id = ''){
        //     $this->db->where('tooltip_page_id',$tooltip_desc_id)->delete('tooltip_screen');
        //     redirect(base_url().'admin/tooltip');
        // }
        public function Create($tooltip_desc_id = '')
	    {
            $data['parentArray'] = $this->Tooltip_model->get_parent_data(); 
            if(!helper_have_rights(CV_TOOLTIP, CV_VIEW_RIGHT_NAME))
	    	{
                $data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <b>'.$this->lang->line('msg_no_add_right_tips').'</b>
                                </div>';		
                redirect(site_url("dashboard"));
            }
            
            if(!empty($tooltip_desc_id)) {
                $data['pages'] = $this->Tooltip_model->getpages($tooltip_desc_id);
            } else {
                $data['pages']=$this->Tooltip_model->getpages();
            }
            
            if($this->input->post('save')!='')
            {
                if($this->input->post('description')=='')
                {
                    $msg='<div class="alert alert-danger alert-dismissible fade in" role="alert"> 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button><b>'.$this->lang->line('msg_created_tips_error').'</b>
                          </div>'; 
                }
               else
               {
                   
                $tdata=array(
                                        'step'=>json_encode($this->input->post('description')),
                                        //'Screen_No'=>$this->input->post('Screen_No'),
                                        'tooltip_page_id'=>$this->input->post('tooltip_page_id')
                                    );
                   
               }
                $res=$this->Tooltip_model->savedata('tooltip_screen',$tdata);
                if($res)
                {
                   $msg='<div class="alert alert-success alert-dismissable fade in">
                            <strong>Success!</strong> '.$this->lang->line('msg_created_tips').'
                          </div>'; 
                }
                else
                {
                    $msg='<div class="alert alert-danger alert-dismissable fade in">
                            <strong>Error!</strong> '.$this->lang->line('msg_created_tips_error').'
                          </div>';
                }
                $this->session->set_flashdata('msg', @$msg); 
                redirect('admin/tooltip/create');
            }
            if($this->input->post('update')!='')
            {
                $data=[
                       'step'=>json_encode($this->input->post('description')),
                    
                ];
                //'Screen_No'=>$this->input->post('Screen_No')
               $res= $this->Tooltip_model->update('tooltip_screen',$data,array('tooltip_page_id'=>$tooltip_desc_id));
                if($res)
                {
                   $msg='<div class="alert alert-success alert-dismissable fade in">
                            <strong>Success!</strong> '.$this->lang->line('msg_no_edit_right_tips_success').'
                          </div>'; 
                }
                else
                {
                    $msg='<div class="alert alert-danger alert-dismissable fade in">
                            <strong>Error!</strong> '.$this->lang->line('msg_no_edit_right_tips_error').'
                          </div>';
                }
                $this->session->set_flashdata('msg', @$msg); 
                redirect('admin/tooltip');
            }
            if($tooltip_desc_id!='')
            {
                $data['tooltipdesc']=$this->Tooltip_model->gettooltip($tooltip_desc_id);
                $data['updation']='yes';
                $data['pageID']=$tooltip_desc_id;
            }
            
           // $this->session->set_flashdata('msg', @$msg); 
           $data['title'] = "Create tooltip";
           $data['body'] = "admin/tooltip/create_add";
           $this->load->view('common/structure',$data);	
			
	}
        
        /*public function delete($tooltip_desc_id)
        {
            $res=$ths->db->delete($tooltip_desc_id);
             if($res)
                {
                   $msg='<div class="alert alert-success alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Data deleted successfully.
                          </div>'; 
                }
                else
                {
                    $msg='<div class="alert alert-error alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> Error while deleting data.
                          </div>';
                }
             $this->session->set_flashdata('msg', $msg); 
             $this->redirect(base_url('admin/tooltip'));
        }*/
        
        function ajaxscreen($tooltip_desc_id,$scid)
        {
            $data['tooltipdesc']=$this->Tooltip_model->tooltipsc($tooltip_desc_id,$scid);
            if(count($data['tooltipdesc'])==0)
            {
                echo 'Data not found. <a href="'.base_url('admin/tooltip/create').'" class="btn btn-primary btn-xs">Create</a> tooltip for this rule and screen';
            }
            else {
            $this->load->view('admin/tooltip/ajax',$data);
            }
        }
	

}
