<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Survey extends REST_Controller {
   
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->load->library('session', 'encrypt');			
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');  
       // $this->load->model('Report_model');
       // $this->load->model('performance_cycle_model');
       // $this->load->model('api/rule_model');
        //$this->load->model('admin_model');
        $this->load->model('common_model');
        $this->load->model('survey_model');
    }
	
    public function index_get()
	{
	}

    public function SurveyResult_get($surveyID='',$userids='')
    {
		
		if(1) {
            
        if(empty($surveyID))
        {
            header("HTTP/1.0 301 Survey ID is missing");
            echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "You must have to pass Survey ID"));
            return;
        }

        $survey_question_select_fields 	= "question_id, p_qid, survey_id, QuestionType, QuestionName, QuestionTitle, is_mandatory, q_order_no, sacle_upto";
        $survey_question_select_where 	= array('survey_id' => $surveyID);//, 'QuestionType' => 4
        $data['question']				= $this->common_model->get_table("survey_questions", $survey_question_select_fields , $survey_question_select_where , "question_id ASC");

        $myarr=[];
		$survey_question_option_select_fields = "surveyAnsID, question_id, Answer";
        $survey_option_type_questions =  array(5);//array(1,3,5,7)
        $survey_ranking_type_questions =  array(4);
        $survey_3dimensional_type_questions = array(6);

		foreach($data['question'] as $key => $qu)
		{
			if(in_array($qu['QuestionType'],$survey_option_type_questions)) {//have options

				$survey_question_option_where 	= array('question_id' => $qu['question_id']);
				$myarr[]=[
                    'question_id'	=>	$qu['question_id'],
                    'question'	    =>	$qu['QuestionName'],
                    'question_type'	=>	$qu['QuestionType'],
                    'p_qid'         =>  $qu['p_qid'],
					'choices'	    =>	$this->common_model->get_table("survey_answers", $survey_question_option_select_fields , $survey_question_option_where , "surveyAnsID ASC"),
				];

            } else if(in_array($qu['QuestionType'],$survey_ranking_type_questions)) {//have ranking

				$myarr[]=[
                    'question_id'	=>	$qu['question_id'],
                    'question'	    =>	$qu['QuestionName'],
                    'question_type'	=>	$qu['QuestionType'],
                    'p_qid'         =>  $qu['p_qid'],
                ];

            } else if(in_array($qu['QuestionType'],$survey_3dimensional_type_questions)) {//have 3dimensional

				$myarr[]=[
                    'question_id'	=>	$qu['question_id'],
                    'question'	    =>	$qu['QuestionName'],
                    'question_type'	=>	$qu['QuestionType'],
                    'p_qid'         =>  $qu['p_qid'],
                ];

			} else {//dont have options

				$myarr[]=[
                    'question_id'	=>	$qu['question_id'],
                    'question'	    =>	$qu['QuestionName'],
                    'question_type'	=>	$qu['QuestionType'],
                    'p_qid'         =>  $qu['p_qid'],
					'choices'	    =>	array(),
				];

			}

		}

		for($i=0;$i<count($myarr);$i++)
		{

			if(!empty($myarr[$i]['choices'])) {

				foreach($myarr[$i]['choices'] as $choice_key => $s) {
					$anscount = array();

					if($user_ids)
					{
						$where='question_id = '.$s['question_id'].' AND surveyAnsID = '.$s['surveyAnsID'].' AND user_id IN ('.str_replace('_',',',$user_ids).')';
						$anscount=$this->Survey_model->get_data('user_survey_answer',$where);
					}
					else
					{
						$survey_answer_select_fields 	= "userAnswerID, user_survey_response_id, textAnswer, user_id, question_id, surveyAnsID";
						$survey_answer_select_where 	= array('question_id' => $s['question_id'], 'surveyAnsID' => $s['surveyAnsID']);
						$anscount						= $this->common_model->get_table("user_survey_answer", $survey_answer_select_fields , $survey_answer_select_where , "userAnswerID ASC");
					}

					$emp = array();

					if(!empty($anscount)) {
						foreach($anscount as $e)  
						{
							$emp[]	=	$e['user_id'];    
						}
					}

					$myarr[$i]['choices'][$choice_key]['employees']	= $emp;
                }

            } else if($myarr[$i]['question_type'] == 6) { //3 dimensional

                if($myarr[$i]['p_qid']) {

                    $survey_answer_select_fields 	= "textAnswer AS answer, user_id AS user_id, question_id";
                    $survey_answer_select_where 	= array('question_id' => $myarr[$i]['question_id']);
                    $myarr[$i]['option_arr']		= $this->common_model->get_table("user_survey_answer", $survey_answer_select_fields , $survey_answer_select_where , "question_id ASC");

                }

            } else if($myarr[$i]['question_type'] == 4) { //ranking

                if($myarr[$i]['p_qid']) {

                    $survey_answer_select_fields 	= "textAnswer AS rank, COUNT(`user_id`) AS total_emps, question_id";
                    $survey_answer_select_where 	= array('question_id' => $myarr[$i]['question_id']);
                    $myarr[$i]['option_arr']		= $this->common_model->get_table("user_survey_answer", $survey_answer_select_fields , $survey_answer_select_where , "textAnswer ASC", "textAnswer");
                }
            }
        }

        $ques_type_6_master_array = array();
        $ques_type_6_sub_array = array();
        $ques_type_5_master_array = array();
        $ques_type_5_sub_array = array();
        $ques_type_4_master_array = array();
        $ques_type_4_sub_array = array();

            foreach($myarr as $my_arr_key => $my_arr_val)
            {

                if(!empty($my_arr_val['question_type']) && $my_arr_val['question_type'] == 6) { 

                    if(isset($my_arr_val['p_qid']) && $my_arr_val['p_qid'] == 0) {

                        $ques_type_6_master_array[] = $my_arr_val;

                    } else {

                        $ques_type_6_sub_array[]    = $my_arr_val;
                    }

                } else if(!empty($my_arr_val['question_type']) && $my_arr_val['question_type'] == 5) {

                    if(isset($my_arr_val['p_qid']) && $my_arr_val['p_qid'] == 0) {

                        $ques_type_5_master_array[] = $my_arr_val;

                    } else {

                        $ques_type_5_sub_array[]    = $my_arr_val;
                    }

                } else if(!empty($my_arr_val['question_type']) && $my_arr_val['question_type'] == 4) {

                    if(isset($my_arr_val['p_qid']) && $my_arr_val['p_qid'] == 0) {

                        $ques_type_4_master_array[] = $my_arr_val;

                    } else {

                        $ques_type_4_sub_array[]    = $my_arr_val;
                    }

                } else {

                    $kl=0;
                    foreach($my_arr_val['choices'] as $k=>$s) {
                        
                        foreach($s as $key=>$vv) {

                            if($key=='Answer')
                            {
                                $myarr[$my_arr_key]['choices'][$kl]['choice'] =$myarr[$my_arr_key]['choices'][$kl][$key];
                                unset($myarr[$key]['choices'][$kl][$key]);
                            }
                        
                            if($key!='choice' && $key!='employees')
                            {
                                unset($myarr[$key]['choices'][$kl][$key]);
                            }
                        }
                        $kl++;
                    }
                }
            }

            //for ques_type_6
            $ques_type_6_final_array = array();
            if(!empty($ques_type_6_master_array) && !empty($ques_type_6_sub_array)) {

                foreach($ques_type_6_master_array as $master_key => $ques_type_6_master_value) {

                    $ques_type_6_final_array[$master_key]['question']       = $ques_type_6_master_value['question'];
                    $ques_type_6_final_array[$master_key]['question_id']    = $ques_type_6_master_value['question_id'];
                    $i = 0;

                    foreach($ques_type_6_sub_array as $sub_key => $ques_type_6_sub_value) {

                        if($ques_type_6_master_value['question_id'] == $ques_type_6_sub_value['p_qid']) {

                            $ques_type_6_final_array[$master_key]['sub_arr'][$i]['sub_question'] = $ques_type_6_sub_value['question'];

                            $total_participants_importance      = 0;
                            $total_scale_importance             = 0;
                            $total_participants_satisfaction    = 0;
                            $total_scale_satisfaction           = 0;
                            //$total_participants                 = 0;

                            foreach($ques_type_6_sub_value['option_arr'] as $ques_type_6_sub_options => $ques_type_6_sub_option_val) {

                                //add get average value
                                if(!empty($ques_type_6_sub_option_val['answer'])) {

                                    if(stristr($ques_type_6_sub_option_val['answer'], CV_SURVEY_3D_IMPORTANCE, true)) {
                                        //for importance
                                        $total_scale_importance  += (int)stristr($ques_type_6_sub_option_val['answer'], CV_SURVEY_3D_IMPORTANCE, true);
                                        $total_participants_importance++;

                                    } else if (stristr($ques_type_6_sub_option_val['answer'], CV_SURVEY_3D_SATISFACTION, true)) {
                                        //for satisfaction

                                        $total_scale_satisfaction += (int)stristr($ques_type_6_sub_option_val['answer'], CV_SURVEY_3D_SATISFACTION, true);
                                        $total_participants_satisfaction++;
                                    }

                                }
                                //end average value
                                //$total_participants++;

                            }

                            $ques_type_6_final_array[$master_key]['sub_arr'][$i]['avg_importance']      = 0;
                            $ques_type_6_final_array[$master_key]['sub_arr'][$i]['avg_satisfaction']    = 0;

                            if(!empty($total_participants_importance) && !empty( $total_scale_importance)) {

                                $avg_importance = $total_scale_importance/$total_participants_importance;

                                if($avg_importance) {
                                    $avg_importance = round($avg_importance, 2);
                                }

                                $ques_type_6_final_array[$master_key]['sub_arr'][$i]['avg_importance']  = $avg_importance;

                            }

                            if(!empty($total_participants_satisfaction) && !empty( $total_scale_satisfaction)) {

                                $avg_satisfaction = $total_scale_satisfaction/$total_participants_satisfaction;

                                if($avg_satisfaction) {
                                    $avg_satisfaction = round($avg_satisfaction, 2);
                                }

                                $ques_type_6_final_array[$master_key]['sub_arr'][$i]['avg_satisfaction']  = $avg_satisfaction;

                            }

                            $ques_type_6_final_array[$master_key]['total_participants'] = $total_participants_importance;
                            $i++;
                        }
                    }

                    $ques_type_6_final_array[$master_key]['legend']['avg_importance_title'] = 'Importance';
                    $ques_type_6_final_array[$master_key]['legend']['avg_satisfaction_title'] = 'Satisfaction';

                }
            }
            //end ques_type_6

            //for ques_type_5
            $ques_type_5_final_array = array();
            if(!empty($ques_type_5_master_array) && !empty($ques_type_5_sub_array)) {

                foreach($ques_type_5_master_array as $master_key => $ques_type_5_master_value) {

                    $ques_type_5_final_array[$master_key]['question']       = $ques_type_5_master_value['question'];
                    $ques_type_5_final_array[$master_key]['question_id']    = $ques_type_5_master_value['question_id'];

                    $i = 0;
                    
                    foreach($ques_type_5_sub_array as $sub_key => $ques_type_5_sub_value) {

                        if($ques_type_5_master_value['question_id'] == $ques_type_5_sub_value['p_qid']) {//dd($ques_type_5_sub_value, false);
                           $ques_type_5_final_array[$master_key]['sub_arr'][$i]['sub_question'] = $ques_type_5_sub_value['question'];

                           $total_participants = 0;

                           foreach($ques_type_5_sub_value['choices'] as $ques_type_5_sub_choice => $ques_type_5_sub_val) {//dd($ques_type_5_sub_val);

                                $ques_type_5_final_array[$master_key]['sub_arr'][$i]['options'][trim($ques_type_5_sub_val['Answer'])] = $ques_type_5_sub_val['employees'];
                                $total_participants += count($ques_type_5_sub_val['employees']);

                           }

                           $ques_type_5_final_array[$master_key]['sub_arr'][$i]['total_participants'] = $total_participants;
                           $i++;
                        }
                    }
                }
            }
            //end ques_type_5

            //for ques_type_4
            $ques_type_4_final_array = array();
            if(!empty($ques_type_4_master_array) && !empty($ques_type_4_sub_array)) {

                foreach($ques_type_4_master_array as $master_key => $ques_type_4_master_value) {

                    $ques_type_4_final_array[$master_key]['question']       = $ques_type_4_master_value['question'];
                    $ques_type_4_final_array[$master_key]['question_id']    = $ques_type_4_master_value['question_id'];

                    $i = 0;
                    
                    foreach($ques_type_4_sub_array as $sub_key => $ques_type_4_sub_value) {

                        if($ques_type_4_master_value['question_id'] == $ques_type_4_sub_value['p_qid']) {

                            $ques_type_4_final_array[$master_key]['sub_arr'][$i]['sub_question'] = $ques_type_4_sub_value['question'];
                            $ques_type_4_final_array[$master_key]['sub_arr'][$i]['options']      = $ques_type_4_sub_value['option_arr'];

                            $total_participants = 0;

                            foreach($ques_type_4_sub_value['option_arr'] as $ques_type_4_sub_options => $ques_type_4_sub_option_val) {//dd($ques_type_4_sub_option_val);

                                $total_participants += $ques_type_4_sub_option_val['total_emps'];
                                $ques_type_4_final_array[$master_key]['rank_arr'][] = $ques_type_4_sub_option_val['rank'];

                            }

                           $ques_type_4_final_array[$master_key]['sub_arr'][$i]['total_participants'] = $total_participants;
                           $i++;
                        }
                    }

                    $ques_type_4_final_array[$master_key]['rank_arr'] = array_unique($ques_type_4_final_array[$master_key]['rank_arr']);
                    sort($ques_type_4_final_array[$master_key]['rank_arr']);
                }
            }

            $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$myarr,
                            "quesType4Data" =>$ques_type_4_final_array,
                            "quesType5Data" =>$ques_type_5_final_array,
                            "quesType6Data" =>$ques_type_6_final_array,
                            );

            $this->set_response($rdata, REST_Controller::HTTP_OK);

		} else {// previous code
              
            if($surveyID=='')
            {
                header("HTTP/1.0 301 Survey ID is missing");
                echo json_encode(array("status" => "failed", "statusCode" => 301, "message" => "You must have to pass Survey ID"));
                return; 

            }
           
           $data['question']=$this->Survey_model->get_data('survey_questions',$where=['survey_id'=>$surveyID]); 
           $myarr=[];
          foreach($data['question'] as $qu)
          {
             $myarr[]=[
                 'question'=>$qu['QuestionName'],
                 'choices'=>$this->Survey_model->get_data('survey_answers',$where=['question_id'=>$qu['question_id']])
             ]; 
             $qarray[]['question']= $this->Survey_model->get_data('survey_answers',$where=['question_id'=>$qu['question_id']]);
             
          }

          $emp=[];
          for($i=0;$i<count($myarr);$i++)
          {
              $k=0;
              foreach($myarr[$i]['choices'] as $s) {
              if($user_ids)
                    {
                            $where='question_id = '.$s['question_id'].' AND surveyAnsID = '.$s['surveyAnsID'].' AND user_id IN ('.str_replace('_',',',$user_ids).')';
                            $anscount=$this->Survey_model->get_data('user_survey_answer',$where);
                    }
                    else
                    {
                            $anscount=$this->Survey_model->get_data('user_survey_answer',$where=['question_id'=>$s['question_id'],'surveyAnsID'=>$s['surveyAnsID']]);
                    }
               
                foreach($anscount as $e)  
                {
                    $emp[]=$e['user_id'];    
                }
              $myarr[$i]['choices'][$k]['employees']= $emp;      
              $k++;
              }
               
          }
          $kk=0;
         for($co=0;$co<count($myarr);$co++)
         {
              $kl=0;
             foreach($myarr[$co]['choices'] as $k=>$s) {
                 
                 foreach($s as $key=>$vv) {
//                     echo $kl.'->'.$key.'<br/>';
                 if($key=='Answer')
                 {
                      $myarr[$co]['choices'][$kl]['choice'] =$myarr[$co]['choices'][$kl][$key];
                      unset($myarr[$co]['choices'][$kl][$key]);
                 }
                 
                 if($key!='choice' && $key!='employees')
                 {
                   unset($myarr[$co]['choices'][$kl][$key]);
                     
                 }
                 
                 
                 }
              $kl++;
             }
               $kk++;
         }
         
            $rdata=array(
                            "status" => "success",
                            "statusCode" => 200,
                            "data" =>$myarr
                            );
			$this->set_response($rdata, REST_Controller::HTTP_OK);
		}
	}
	
}
