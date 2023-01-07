<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_proposal extends CI_Controller 
{	 
	 public function __construct()
	 {
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->library('form_validation');
		$this->load->library('session', 'encrypt');	
        $this->load->model("common_model");
        $this->load->model("user_model");

		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' )
		{
			redirect(site_url("dashboard"));
        }

		HLP_is_valid_web_token();

        $this->data_time = date("Y-m-d H:i:s");
        $this->data      = date("Y-m-d");

	}


    public function candidate_offer_proposal()
    {

        $data['title']          = 'Candidate offer proposal';
        $data['country_det']    = $this->common_model->get_table('manage_country', "id, name, currency_id, order_no", array("status" => 1), 'id');
        $data['city_det']       = $this->common_model->get_table('manage_city', "id, name, order_no", array("status" => 1), 'id');
        $data['function_det']   = $this->common_model->get_table('manage_function', "id, name, order_no", array("status" => 1), 'id');
        $data['grade_det']      = $this->common_model->get_table('manage_grade', "id, name, order_no", array("status" => 1), 'order_no');
        $data['level_det']      = $this->common_model->get_table('manage_level', "id, name, order_no", array("status" => 1), 'order_no');
        $data['title_det']      = $this->common_model->get_table('manage_designation', "id, name, order_no", array("status" => 1), 'order_no');
        $data['offer_rule_det'] = $this->common_model->get_table('hr_candidate_offer_parameter', "id, offer_rule_name", array("status" => 1, "effective_dt >=" => $this->data), 'id DESC');

        $data['body'] = 'candidate_offer/candidate_offer_proposal';

		$this->load->view('common/structure',$data);
    }


    public function company_users_data()
    {

        $candidateName  = "";
        $country        = "";
        $city           = "";
        $function       = "";
        $grade          = "";
        $level          = "";
        $title          = "";
        $offer_rule_id     = "";

        if ($this->input->post()) {

            $this->form_validation->set_rules('candidateName', 'Candidate Name', 'trim|required|max_length[64]');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|is_natural|max_length[2]');
            $this->form_validation->set_rules('city', 'City', 'trim|required|is_natural|max_length[3]');
            $this->form_validation->set_rules('function', 'Function', 'trim|required|is_natural|max_length[2]');
            $this->form_validation->set_rules('grade', 'Grade', 'trim|required|is_natural|max_length[2]');
            $this->form_validation->set_rules('level', 'Level', 'trim|required|is_natural|max_length[2]');
            $this->form_validation->set_rules('title', 'Title', 'trim|required|is_natural|max_length[2]');
            $this->form_validation->set_rules('offer_rule', 'Offer Rule', 'trim|required|is_natural|max_length[2]');

            if ($this->form_validation->run()) {

                $candidateName  = $this->input->post('candidateName', true);
                $country        = $this->input->post('country', true);
                $city           = $this->input->post('city', true);
                $function       = $this->input->post('function', true);
                $grade          = $this->input->post('grade', true);
                $level          = $this->input->post('level', true);
                $title          = $this->input->post('title', true);
                $offer_rule_id  = $this->input->post('offer_rule', true);

            } else {

                $result['data']     = "THERE ARE SEEMS SOME ERROR";
                $result['status']   = 'error';
                echo json_encode($result);
                return;
            }
        }

        $cond_array = array();

        if (!empty($country)) {
            $cond_array['country'] = $country;
        }

        if (!empty($city)) {
            $cond_array['city'] = $city;
        }

        if (!empty($function)) {
            $cond_array['function'] = $function;
        }

        if (!empty($grade)) {
            $cond_array['grade'] = $grade;
        }

        if (!empty($level)) {
            $cond_array['level'] = $level;
        }

        if (!empty($title)) {
            $cond_array['designation'] = $title;
        }

        $data['business_attributes']    = $this->common_model->get_table("business_attribute", "id, display_name, ba_name, status", array("status" => 1), "id asc");

        $offer_peer_filter_data_string      = "";//use in select query
        $offer_peer_filter_data_key_arr     = array();//use in filter data
        $data['attribute_details']          = array();
        $data['attribute_details_by_id']    = array();

        if(!empty($data['business_attributes'])) {

            foreach($data['business_attributes'] as $key => $attr_details) {//dd($attr_details);

                $data['attribute_details'][$attr_details['ba_name']]    = $attr_details['display_name'];
                $data['attribute_details_by_id'][$attr_details['id']]   = $attr_details['ba_name'];

            }
        }

        if($offer_rule_id) {

            $get_selected_offer_rule_det    = $this->common_model->get_table('hr_candidate_offer_parameter', "id, offer_rule_name, offer_applied_on_elements", array("status" => 1, "id" => $offer_rule_id));//return only single row
  
            if(!empty($get_selected_offer_rule_det[0]['offer_applied_on_elements'])) {

                $offer_applied_on_elements_arr = explode(",",$get_selected_offer_rule_det[0]['offer_applied_on_elements']);
                $offer_peer_filter_data_keys = array();//use in select query
    
                if(!empty($offer_applied_on_elements_arr) && !empty($data['attribute_details_by_id'])) {
    
                    $i = 0;
    
                    foreach($offer_applied_on_elements_arr as $key => $rule_key_id) {
    
                        if (array_key_exists($rule_key_id, $data['attribute_details_by_id'])) {

                            $offer_peer_filter_data_keys[$i] = 'login_user.'.$data['attribute_details_by_id'][$rule_key_id];
                            $offer_peer_filter_data_key_arr[$i] = $data['attribute_details_by_id'][$rule_key_id];
                            $i++;

                        }
                    }

                    $offer_peer_filter_data_string = implode(", ",$offer_peer_filter_data_keys);
                }    
            }
        }

        $select_str = "login_user.id, login_user.email, login_user.country, login_user.city, login_user.function, login_user.grade, login_user.level, login_user.designation, ";

        //peer(internal) emp salary fields
        if(!empty($offer_peer_filter_data_string)) {
            $select_str .= $offer_peer_filter_data_string. ", ";
        }

        //market salary fields
        $select_str .= "login_user.market_target_salary_level_min, login_user.market_total_salary_level_min, login_user.market_base_salary_level_min, login_user.market_target_salary_level_1, ";
        $select_str .= "login_user.market_total_salary_level_1, login_user.market_base_salary_level_1, login_user.market_target_salary_level_2, login_user.market_total_salary_level_2, login_user.market_base_salary_level_2, ";
        $select_str .= "login_user.market_target_salary_level_3, login_user.market_total_salary_level_3, login_user.market_base_salary_level_3, login_user.market_target_salary_level_4, login_user.market_total_salary_level_4, ";
        $select_str .= "login_user.market_base_salary_level_4, login_user.market_target_salary_level_5, login_user.market_total_salary_level_5, login_user.market_base_salary_level_5, login_user.market_target_salary_level_6, ";
        $select_str .= "login_user.market_total_salary_level_6, login_user.market_base_salary_level_6, login_user.market_target_salary_level_7, login_user.market_total_salary_level_7, login_user.market_base_salary_level_7, ";
        $select_str .= "login_user.market_target_salary_level_8, login_user.market_total_salary_level_8, login_user.market_base_salary_level_8, login_user.market_target_salary_level_9, login_user.market_total_salary_level_9, ";
        $select_str .= "login_user.market_base_salary_level_9, login_user.market_target_salary_sevel_max, login_user.market_total_salary_level_max, login_user.market_base_salary_level_max,";

        $data['salary_dtls']        = $this->user_model->get_users_details($select_str, $cond_array);

        //peer(internal) emp salary
        $data['peer_salary_dtls']   = array();

        //market salary
        $data['market_salary_dtls'] = array();

        //peer(internal) graph details
        $data['peer_graph_dtls']    = array();

        //market salary graph details
        $data['market_salary_graph_dtls'] = array();

        if(!empty($data['salary_dtls'])) {

            foreach($data['salary_dtls'] as $key => $salary_det) {//print $key; dd($salary_det);

                //set internal data
                foreach($salary_det as $salary_key => $salary_det_val) {

                    if(in_array($salary_key, $offer_peer_filter_data_key_arr)) {

                        if(!isset($data['peer_salary_dtls'][$key])) {
                            $data['peer_salary_dtls'][$key] = 0;
                        }

                        $data['peer_salary_dtls'][$key] = $data['peer_salary_dtls'][$key] + $salary_det_val;
                    }
                }

                $data['market_salary_dtls']['market_target_salary_level_min'][$key] = $salary_det['market_target_salary_level_min'];
                $data['market_salary_dtls']['market_total_salary_level_min'][$key]  = $salary_det['market_total_salary_level_min'];
                $data['market_salary_dtls']['market_base_salary_level_min'][$key]   = $salary_det['market_base_salary_level_min'];
                $data['market_salary_dtls']['market_target_salary_level_1'][$key]   = $salary_det['market_target_salary_level_1'];
                $data['market_salary_dtls']['market_total_salary_level_1'][$key]    = $salary_det['market_total_salary_level_1'];
                $data['market_salary_dtls']['market_base_salary_level_1'][$key]     = $salary_det['market_base_salary_level_1'];
                $data['market_salary_dtls']['market_target_salary_level_2'][$key]   = $salary_det['market_target_salary_level_2'];
                $data['market_salary_dtls']['market_total_salary_level_2'][$key]    = $salary_det['market_total_salary_level_2'];
                $data['market_salary_dtls']['market_base_salary_level_2'][$key]     = $salary_det['market_base_salary_level_2'];
                $data['market_salary_dtls']['market_target_salary_level_3'][$key]   = $salary_det['market_target_salary_level_3'];
                $data['market_salary_dtls']['market_total_salary_level_3'][$key]    = $salary_det['market_total_salary_level_3'];
                $data['market_salary_dtls']['market_base_salary_level_3'][$key]     = $salary_det['market_base_salary_level_3'];
                $data['market_salary_dtls']['market_target_salary_level_4'][$key]   = $salary_det['market_target_salary_level_4'];
                $data['market_salary_dtls']['market_total_salary_level_4'][$key]    = $salary_det['market_total_salary_level_4'];
                $data['market_salary_dtls']['market_base_salary_level_4'][$key]     = $salary_det['market_base_salary_level_4'];
                $data['market_salary_dtls']['market_target_salary_level_5'][$key]   = $salary_det['market_target_salary_level_5'];
                $data['market_salary_dtls']['market_total_salary_level_5'][$key]    = $salary_det['market_total_salary_level_5'];
                $data['market_salary_dtls']['market_base_salary_level_5'][$key]     = $salary_det['market_base_salary_level_5'];
                $data['market_salary_dtls']['market_target_salary_level_6'][$key]   = $salary_det['market_target_salary_level_6'];
                $data['market_salary_dtls']['market_total_salary_level_6'][$key]    = $salary_det['market_total_salary_level_6'];
                $data['market_salary_dtls']['market_base_salary_level_6'][$key]     = $salary_det['market_base_salary_level_6'];
                $data['market_salary_dtls']['market_target_salary_level_7'][$key]   = $salary_det['market_target_salary_level_7'];
                $data['market_salary_dtls']['market_total_salary_level_7'][$key]    = $salary_det['market_total_salary_level_7'];
                $data['market_salary_dtls']['market_base_salary_level_7'][$key]     = $salary_det['market_base_salary_level_7'];
                $data['market_salary_dtls']['market_target_salary_level_8'][$key]   = $salary_det['market_target_salary_level_8'];
                $data['market_salary_dtls']['market_total_salary_level_8'][$key]    = $salary_det['market_total_salary_level_8'];
                $data['market_salary_dtls']['market_base_salary_level_8'][$key]     = $salary_det['market_base_salary_level_8'];
                $data['market_salary_dtls']['market_target_salary_level_9'][$key]   = $salary_det['market_target_salary_level_9'];
                $data['market_salary_dtls']['market_total_salary_level_9'][$key]    = $salary_det['market_total_salary_level_9'];
                $data['market_salary_dtls']['market_base_salary_level_9'][$key]     = $salary_det['market_base_salary_level_9'];
                $data['market_salary_dtls']['market_target_salary_sevel_max'][$key] = $salary_det['market_target_salary_sevel_max'];
                $data['market_salary_dtls']['market_total_salary_level_max'][$key]  = $salary_det['market_total_salary_level_max'];
                $data['market_salary_dtls']['market_base_salary_level_max'][$key]   = $salary_det['market_base_salary_level_max'];

            }
        }

        //market emp salary graph det
        if(!empty($data['market_salary_dtls'])) {

            foreach($data['market_salary_dtls'] as $key => $market_salary_dtls) {

                if (array_key_exists($key, $data['attribute_details'])) {

                    $key = $data['attribute_details'][$key];

                }

                $data['market_salary_graph_dtls'][$key] = $this->get_avg_array_val($market_salary_dtls);
            }

        }

        //internal emp salary graph det
        if(!empty($data['peer_salary_dtls'])) {

            $data['peer_graph_dtls']['Min'] =  round(min($data['peer_salary_dtls']),2);
            $data['peer_graph_dtls']['Avg'] =  round($this->get_avg_array_val($data['peer_salary_dtls']),2);
            $data['peer_graph_dtls']['Max'] =  round(max($data['peer_salary_dtls']),2);

        }

        $result['data']     = $data;
        $result['status']   = 'success';
        echo json_encode($result);
        exit;
    }


    public function get_avg_array_val($data_array) {

        $avg_val = 0;

        if(!empty($data_array) && is_array($data_array)) {

            $avg_val = array_sum($data_array) / count($data_array) ;

        }

        return $avg_val;

    }


    public function candidate_offer_rule_setting($offer_rule_id =  0) {

        $this->load->model("rule_model");

        $data["button_text"] = 'Add';

        if ($offer_rule_id) {
            //get offer rule data
            $rule_dtls_arr =  $this->common_model->get_table('hr_candidate_offer_parameter', "id, offer_rule_name, offer_applied_on_elements, pay_range_basis_on, position, effective_dt, cutoff_date", array("id" => $offer_rule_id, "status" => 1), 'id DESC');

            if(!empty($rule_dtls_arr[0])) {

                $rule_dtls = array();

                foreach ($rule_dtls_arr as $key => $value) {

                    $rule_dtls['id'] = $value['id'];
                    $rule_dtls['offer_rule_name'] = $value['offer_rule_name'];
                    $rule_dtls['offer_applied_on_elements'] = $value['offer_applied_on_elements'];
                    $rule_dtls['pay_range_basis_on'] = $value['pay_range_basis_on'];
                    $rule_dtls['position'] = $value['position'];
                    $rule_dtls['effective_dt'] = date("d/m/Y",strtotime($value['effective_dt']));
                    //$rule_dtls['cutoff_date'] = date("d/m/Y",strtotime($value['cutoff_date']));

                }

                $data["rule_dtls"] = $rule_dtls;
                $data["button_text"] = 'Update';

            } else {//no result found
                redirect(site_url("candidate-offer-rule-setting"));
            }
        }

		$data["market_salary_elements_list"] = $this->rule_model->get_table("business_attribute", "id, ba_name, display_name", array("business_attribute.status"=>1, "business_attribute.module_name"=>$this->session->userdata('market_data_by_ses')), "ba_attributes_order ASC");
		$data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list("business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."')");
		$conditions=' rule_for=1 and bonus_given=1 and status='.CV_STATUS_RULE_RELEASED;
        $data["bonusListForSalaryRuleCreation"] =getSingleTableData('hr_parameter_bonus',$conditions,'id,bonus_rule_name') ;

        $all_offer_rule_dets        = array();
        $all_offer_rule_det_array   = $this->common_model->get_table('hr_candidate_offer_parameter', "id, offer_rule_name, offer_applied_on_elements, pay_range_basis_on, position, effective_dt, cutoff_date, status", array(), 'id DESC');

        if(!empty($all_offer_rule_det_array)) {

            foreach ($all_offer_rule_det_array as $key => $det_val) {

                $all_offer_rule_dets[$key]['id']                        = $det_val['id'];
                $all_offer_rule_dets[$key]['offer_rule_name']           = $det_val['offer_rule_name'];
                $all_offer_rule_dets[$key]['offer_applied_on_elements'] = $det_val['offer_applied_on_elements'];
                $all_offer_rule_dets[$key]['pay_range_basis_on']  = $det_val['pay_range_basis_on'];
                $all_offer_rule_dets[$key]['position']                  = $det_val['position'];
                $all_offer_rule_dets[$key]['effective_dt']              = date("d/m/Y",strtotime($det_val['effective_dt']));
               // $all_offer_rule_dets[$key]['cutoff_date']               = date("d/m/Y",strtotime($det_val['cutoff_date']));
                $all_offer_rule_dets[$key]['status']                    = !empty($det_val['status']) ? 'Active' : 'Inactive';

            }
        }

        $data["all_offer_rule_dets"] = $all_offer_rule_dets;
		$data['title'] = "Candidate Offer Rule";
		$data['body'] = "candidate_offer/create_rules";
        $this->load->view('common/structure',$data);

    }


    /* save offer rule */
    public function save_offer_rule() {

        if ($this->input->is_ajax_request() && $this->input->post()) {

            $this->form_validation->set_rules('offer_rule_name', 'Offer rule Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('pay_range_basis_on', 'Compared for pay range', 'trim|required');

            if($this->form_validation->run() && !empty($this->input->post("offer_applied_on_elements", true)) && is_array($this->input->post("offer_applied_on_elements", true))) {

                $this->load->model("rule_model");

                $rule_id = $this->input->post("rule_id", true);
                $candidate_offer_rule_data['offer_rule_name']            = $this->input->post("offer_rule_name", true);
                $candidate_offer_rule_data['offer_applied_on_elements']  = implode(",",$this->input->post("offer_applied_on_elements", true));
                $candidate_offer_rule_data['pay_range_basis_on']         = $this->input->post("pay_range_basis_on", true);
                $candidate_offer_rule_data['position']                   = '';
                $candidate_offer_rule_data['status']                     = 1;

                $effective_dt = $this->input->post("txt_effective_dt", true);
                //$cutoff_date = $this->input->post("txt_cutoff_dt", true);

                if(!empty($effective_dt)) {
                    $effective_dt = date("Y-m-d",strtotime(str_replace("/","-",$effective_dt)));
                }

                if(0 && !empty($cutoff_date)) {
                    $cutoff_date = date("Y-m-d",strtotime(str_replace("/","-",$cutoff_date)));
                }

                $candidate_offer_rule_data['effective_dt']               = $effective_dt;
                //$candidate_offer_rule_data['cutoff_date']                = $cutoff_date;

                if(!empty($rule_id)) {//update

                    $cond = array(
                        'id' => $rule_id,
                    );

                    $candidate_offer_rule_data["updatedby"]        = $this->session->userdata('userid_ses');
                    $candidate_offer_rule_data["updatedby_proxy"]  = $this->session->userdata('proxy_userid_ses');
                    $candidate_offer_rule_data["updatedon"]        = $this->data_time;

                    $this->rule_model->update_candidate_offer_rules($candidate_offer_rule_data, $cond);
                    $result['id']       =  $rule_id;
                    $result['msg']      =  '<div class="marbt15 alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Rule update successfully.</b></div>';

                } else {//create

                    $candidate_offer_rule_data["createdby"]        = $this->session->userdata('userid_ses');
                    $candidate_offer_rule_data["createdby_proxy"]  = $this->session->userdata('proxy_userid_ses');
                    $candidate_offer_rule_data["createdon"]        = $this->data_time;	

                    $result['id']       =  $this->rule_model->insert_candidate_offer_rules($candidate_offer_rule_data);
                    $result['msg']      =  '<div class="marbt15 alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Rule save successfully.</b></div>';
                }

                $this->session->set_flashdata('msg', $result['msg']);

                $result['status']   =  'success';
                echo json_encode($result);
                return;

            } else {
                $result['msg']      = '<div class="marbt15 alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>There are some error.</b></div>';
                $result['status']   = 'error';
                echo json_encode($result);
                return;
            }

        } else {

            $result['msg']      = '<div class="marbt15 alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>There are some error.</b></div>';
            $result['status']   = 'error';
            echo json_encode($result);
            return;
        }

    }


	 public function objective_settings()
    {
        $data['title'] = 'Objective Settings';
		$data['body'] = 'objective_settings';
		$this->load->view('common/structure',$data);
    }

    public function objective_settings_output()
    {
        $data['title'] = 'Objective Settings output';
		$data['body'] = 'objective_settings_output';
		$this->load->view('common/structure',$data);
    }

}
