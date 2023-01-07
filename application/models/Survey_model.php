<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Survey_model extends CI_Model
{
    function __construct()
    {
                parent::__construct();
                $this->load->database();
        $dbname = $this->session->userdata("dbname_ses");
        if(trim($dbname))
        {
            $this->db->query("Use $dbname");        
        }
        date_default_timezone_set('Asia/Calcutta');
    }       
    
    public function getData($table, $columns="*", $whereArray=array(), $orderby="", $orderby_type="DESC",$limit="")
    {
        $this->db->select($columns);
        $this->db->from($table);

        if(!empty($whereArray) && $whereArray!=''){
            $this->db->where($whereArray);
        }
        if($orderby!='' && $orderby_type!=''){
            $this->db->order_by($orderby,$orderby_type);
        }
        if(!empty($limit) && $limit!=""){
            $this->db->limit($limit);
        }
      return $this->db->get()->result_array();  
    }
    
    public function saveBatch($table,$data)
    {
        $this->db->insert_batch($table,$data);
        return $this->db->insert_id();
    }
    public function get_data($table,$condition = null)
    {
        if($condition == null){
            return $this->db->get($table)->result_array();
        }else{
            return $this->db->get_where($table,$condition)->result_array();
        }
        
    }
    public function get_data_order($table,$condition)
    {
        $this->db->order_by('survey_id','DESC');
        return $this->db->get_where($table,$condition)->result_array();
    }
    // public function get_data_order_greter($table,$condition)
    // {
    //     $this->db->order_by('survey_id','DESC');
    //     return $this->db->get_where($table,$condition)->result_array();
    // }
    public function savedata($table,$data)
    {
        $res=$this->db->insert($table,$data);
        if($res)
        {
            return $this->db->insert_id();;
        }
        else
        {
            return false;
        }
        
    }
    public function updatedata($table,$data,$condition)
    {
        $this->db->where($condition);
        $res=$this->db->update($table,$data);
        if($res)
        {
            return $this->db->insert_id();;
        }
        else
        {
            return false;
        }
        
    }
    public function deletedata($table,$condition)
    {
        $this->db->where($condition);
        $res=$this->db->delete($table);
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    public function updateWhereIn($table,$data,$col,$val)
    {
        $this->db->where_in($col,$val);
        $res=$this->db->update($table,$data);
        if($res)
        {
            return $this->db->insert_id();;
        }
        else
        {
            return false;
        }
        
    }
    
    public function GetUserQuestionAnswer($surveyID)
    {
        return $this->db->query("select * FROM user_survey_answer us join survey_questions sq on sq.question_id=us.question_id join survey su on su.survey_id=sq.survey_id join user_survey_answer usa on usa.surveyID=sq.survey_id where usa.surveyID=".$surveyID." ")->result_array();
    }
    public function GetUserQuestionAnswerText($surveyID)
    {
        return $this->db->query("select * FROM survey_text_answer us join survey_questions sq on sq.question_id=us.question_id join survey su on su.survey_id=sq.survey_id join user_survey_answer usa on usa.surveyID=sq.survey_id where usa.surveyID=".$surveyID." ")->result_array();
    }

    public function get_survey_questoin_ans($surveyID) {
        $query = 'SELECT count(*) as counter FROM `survey_questions` WHERE `survey_id` = '.$surveyID;
        return $this->db->query($query)->row_array()['counter'];
    }
    
    /* Rahul 12-11-2018 */
    /* New survey concept */

    public function get_admin_company_survey_counts() {
        $this->db->query('use '.CV_PLATFORM_DB_NAME);
        $master_count = $this->db->get_where('survey', array('status' => CV_STATUS_ACTIVE,'is_published > ' => 0))->num_rows();
        $company_db = $this->session->userdata('dbname_ses');
        $this->db->query('use '.$company_db);
        $publish_count = $this->db->get_where('survey', array('status' => CV_STATUS_ACTIVE,'is_published > ' => 0))->num_rows();
        $inprogress_count = $this->db->get_where('survey', array('status' => CV_STATUS_ACTIVE,'is_published' => 0))->num_rows();
        $completed_count = $this->db->query('SELECT *  FROM `survey` WHERE DATE_ADD(start_date , INTERVAL surevy_open_periods DAY) >= CURDATE()')->num_rows();
        return array('master_count' => $master_count, 'publish_count' => $publish_count, 'inprogress_count' => $inprogress_count, 'completed_count' => $completed_count);
    }

    public function latest_master_survey($whereArray = array()) {

        $this->db->query('use '.CV_PLATFORM_DB_NAME);
        $this->db->select('s.survey_name, c.name as category_name,(select count(*) from survey_questions as sq where sq.survey_id = s.survey_id) as question_count');
        $this->db->from('survey as s');
        $this->db->join('category as c','c.id = s.category_id');
        $this->db->where('s.status',CV_STATUS_ACTIVE);
        // $this->db->where('DATE_ADD(s.start_date , INTERVAL s.surevy_open_periods DAY) >=', 'CURDATE()');
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }
        $this->db->order_by("s.createdon", "desc");
        $this->db->limit(10);
        $surveyArray = $this->db->get()->result_array();

        $company_db = $this->session->userdata('dbname_ses');
        $this->db->query('use '.$company_db);
        return $surveyArray;
    }

    public function latest_company_survey($whereArray = array(), $limit="", $start=0) {
        $this->db->select('s.category_id,s.survey_id, s.survey_name, s.survey_img, s.description, s.closing_description, s.start_date, s.createdon, s.surevy_open_periods, s.is_published, s.status, c.name as category_name,(select count(*) from survey_questions as sq where sq.survey_id = s.survey_id and sq.p_qid = 0) as question_count');
        $this->db->from('survey as s');
        $this->db->join('category as c','c.id = s.category_id');
        //$this->db->where('DATE_ADD(s.start_date , INTERVAL s.surevy_open_periods DAY) >=', 'CURDATE()');
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }else{
            $this->db->where('s.status',CV_STATUS_ACTIVE);
        }
        $this->db->order_by("s.createdon", "desc");
        if(!empty($limit)){
            $this->db->limit($limit, $start);
        }
        $surveyArray = $this->db->get()->result_array();
        return $surveyArray;
    }

    public function getAdminCategory($table_name) {
        $this->db->query('use '.CV_PLATFORM_DB_NAME);
        //$this->db->order_by('id','ASC');
		$this->db->order_by("FIELD(id, 1, 2, 3, 6, 4, 5)");
        $category = $this->db->get($table_name)->result_array();
        $company_db = $this->session->userdata('dbname_ses');
        $this->db->query('use '.$company_db);
        return $category;
    }

    public function getAdminSurvey($table_name,$whereArray) {

        $this->db->query('use '.CV_PLATFORM_DB_NAME);
        $this->db->select("survey.tooltip_desc_msg,survey.survey_id,survey.category_id,survey.survey_name,survey.description,survey.survey_img,if(survey.survey_type = 1,'One Time', 'Periodic') as survey_type,(SELECT count(survey_questions.survey_id) FROM survey_questions WHERE survey_questions.survey_id = survey.survey_id)as que_count");
        $this->db->order_by('survey.survey_name','ASC');
        $survey = $this->db->get_where($table_name,$whereArray)->result_array();
        // echo $this->db->last_query();
        // die;
        $company_db = $this->session->userdata('dbname_ses');
        // echo $company_db;
        // die;
        $this->db->query('use '.$company_db);
        return $survey;
    }

    public function getCompanyCategory() {
        $this->db->order_by('name','ASC');
        return $this->db->get_where('category', array('status' => CV_STATUS_ACTIVE))->result_array();
    }

    // public function getCategorySurvey_NIU($table_name,$whereArray){
    //     $this->db->select("survey.survey_id,survey.category_id,survey.survey_name,survey.description,survey.survey_img,if(survey.survey_type = 1,'One Time', 'Periodic') as survey_type, (SELECT count(survey_questions.survey_id) FROM survey_questions WHERE survey_questions.survey_id = survey.survey_id)as que_count");
    //     $this->db->order_by('survey.survey_name','ASC');
    //     $survey = $this->db->get_where($table_name,$whereArray)->result_array();
    //     return $survey;
    // }

    public function copy_admin_survey($sureyId) {
        $this->db->query('use '.CV_PLATFORM_DB_NAME);
        $admin_survey = $this->db->get_where('survey',array('survey_id' => $sureyId))->row_array();
        if($admin_survey) {
                    $this->db->trans_begin();
                    //$this->db->query('use '.CV_PLATFORM_DB_NAME);
                    $admin_survey_question  = $this->db->get_where('survey_questions',array('p_qid'=>'0','survey_id' => $sureyId))->result_array();

                    $company_db = $this->session->userdata('dbname_ses');
                    $this->db->query('use '.$company_db);
                    $this->db->select('id,name,status');
                    $admin_category = $this->db->get_where('category',array('id'=>$admin_survey['category_id']))->row_array();

                     // Admin category name
                    $category_id = $admin_category['id'];
                    $category_name = $admin_category['name'];

                    // Check category name on company database
                    $category_status = $this->db->get_where('category',array('name' => $category_name))->num_rows(); 
                    if(!$category_status) {
                        $this->db->insert('category',array('name' => $category_name));
                        $category_id = $this->db->insert_id();
                    }
                    $insertSurvey = array(
                            'category_id'               => $category_id,
                            'survey_name'               => $admin_survey['survey_name'],
                            'description'               => $admin_survey['description'],
                            'closing_description'       => $admin_survey['closing_description'],
                            //'tooltip_desc_msg'          => $admin_survey['tooltip_desc_msg'],
                            'survey_type'               => $admin_survey['survey_type'],
                            'survey_for'                => $admin_survey['survey_for'],
                            'frequency_dependent_on'    => $admin_survey['frequency_dependent_on'],
                            'frequency_days'            => $admin_survey['frequency_days'],
                            'start_date'                => $admin_survey['start_date'],
                            'surevy_open_periods'       => $admin_survey['surevy_open_periods'],
                            "createdby"                 => $this->session->userdata('userid_ses'),
                            "createdby_proxy"           => $this->session->userdata('proxy_userid_ses'),
                            "createdon"                 => date("Y-m-d H:i:s")
                    );
                    $this->db->query('use '.$company_db);
                    $this->db->insert('survey',$insertSurvey);
                    $newSurveyId = $this->db->insert_id();
                    if(!empty($admin_survey['survey_img'])) {
                        $updateArray = array(
                            "updatedon"     => date("Y-m-d H:i:s")
                        );
                        $imgpath = CV_PLATFORM_COMPANY_BASE_URL.$admin_survey['survey_img'];
                        //$imgpath = 'https://compben.awtech.in/admin-portal/uploads/comp_logos/default_bg_img.png';
                        $file_ext = pathinfo($imgpath,PATHINFO_EXTENSION);
                        $new_img_name = $admin_survey['survey_name'].'-'.$newSurveyId.'.'.$file_ext;

                        $content = file_get_contents($imgpath);
                        $fp = fopen("uploads/survey/".$new_img_name, "w");
                        fwrite($fp, $content);
                        fclose($fp);
                        $updateArray['survey_img'] = 'uploads/survey/'.$new_img_name;

                        $this->db->where('survey_id',$newSurveyId);
                        $this->db->update('survey',$updateArray);
                    }
                    $question = array();
                    $result=$s_question = array();
                    if(!empty($admin_survey_question)){
                        foreach($admin_survey_question as $qsId=>$value){
                            $final['p_qid']= $value['p_qid'];
                            $final['survey_id']= $newSurveyId;
                            $final['QuestionType']= $value['QuestionType'];
                            $final['QuestionName']= $value['QuestionName'];
                            $final['QuestionTitle']= $value['QuestionTitle'];
                            $final['q_order_no']= $value['q_order_no'];
                            $final['sacle_upto']= $value['sacle_upto'];
                            $final['is_mandatory']= $value['is_mandatory'];


                            // question insert
                            //$result[$qsId]['question']=$final;
                            $this->db->query('use '.$company_db);
                            $this->db->insert('survey_questions',$final);
                            $qId = $this->db->insert_id();
                            //$qId = $qsId;
                            // sub question
                            if($value['QuestionType'] == 4 || $value['QuestionType'] == 5 || $value['QuestionType'] == 6){
                                $this->db->query('use '.CV_PLATFORM_DB_NAME);
                                $sub_questions  = $this->db->get_where('survey_questions',array('p_qid'=>$value['question_id']))->result_array();
                                $sub_ids = $s_question = array();
                                if(!empty($sub_questions)){
                                    foreach($sub_questions as $key=>$sub_question){
                                        //$s_question['QuestionName']  = $final;
                                        $final['QuestionName']  = $sub_question['QuestionName'];
                                        $final['p_qid']         = $qId;
                                        $final['q_order_no']    = 0;
                                        $final['sacle_upto']    = 0;
                                        $final['is_mandatory']  = 1;
                                        $s_question[] = $final;
                                        $this->db->query('use '.$company_db);
                                        $this->db->insert('survey_questions',$final);
                                        if($value['QuestionType'] == 5){
                                            $sub_ids[] = $this->db->insert_id();    
                                        }
                                    }
                                }
                                //$result[$qsId]['sub_question']=$s_question;
                            }
                            if($value['QuestionType'] == 1 || $value['QuestionType'] == 3 || $value['QuestionType'] == 5 || $value['QuestionType'] == 7){
                               $this->db->query('use '.CV_PLATFORM_DB_NAME);
                               $answares  = $this->db->get_where('survey_answers',array('question_id' => $value['question_id']))->result_array(); 
                               $ans = array();
                               if(!empty($answares)){
                                   foreach($answares as $key=>$answare){
                                        $ans_final['question_id']= $qId;
                                        $ans_final['Answer']= $answare['Answer'];
                                        $ans_final['ans_img']= $answare['ans_img'];
                                        $ans[] = $ans_final;
                                   }
                               }

                               if(!empty($sub_ids)){
                                    foreach($sub_ids as $skey=>$sub_id){
                                        if(!empty($answares)){
                                            foreach($answares as $key=>$answare){
                                                $ans_final['question_id']= $sub_id;
                                                $ans_final['Answer']= $answare['Answer'];
                                                $ans_final['ans_img']= $answare['ans_img'];
                                                $ans[] = $ans_final;
                                            }
                                        }
                                    }
                               }
                               if(!empty($ans)){
                                   //$result[$qsId]['response']=$ans;
                                   $this->db->query('use '.$company_db);
                                   $this->db->insert_batch('survey_answers',$ans);
                                   // batch insert in 
                               }
                            }
                            //$question[] = $final;
                        }
                    }else{

                    }

                    if ($this->db->trans_status() === FALSE)
                    {
                        //echo "error";
                    $this->db->trans_rollback();
                    return array("status"=>false, "message"=>"Invalid survey id");
                    }
                    else
                    {
                       // echo "success";
                    $this->db->trans_commit();
                    return array("status"=>true, "id"=>$newSurveyId, "message"=>"Record successfully added.");
                    }
        } else {
            return array("status"=>false, "message"=>"Invalid survey id");
        }            
        die;
            // $qid = '';
            // if( count($admin_survey_question) ) {
            //     foreach($admin_survey_question as $qes) {
            //         $qid .= $qes['question_id'].',';
            //     }
            //     $qid = rtrim($qid,',');
            // }

            // $admin_survey_anwser    = $this->db->query('SELECT * FROM `survey_answers` WHERE `question_id` IN ('.$qid.')')->result_array(); 
            // //-------------------- Comapny Insert section -----------------------------
            // // Change Database
            // $company_db = $this->session->userdata('dbname_ses');
            // $this->db->query('use '.$company_db);
            
            // // Admin category name
            // $category_id = $admin_category['id'];
            // $category_name = $admin_category['name'];
            
            // // Check category name on company database
            // $category_status = $this->db->get_where('category',array('name' => $category_name))->num_rows(); 
            // if(!$category_status) {
            //     $this->db->insert('category',array('name' => $category_name));
            //     $category_id = $this->db->insert_id();
            // }

            // Insert survey data on company database
            // $insertSurvey = array(
            //     'category_id'               => $category_id,
            //     'survey_name'               => $admin_survey['survey_name'],
            //     'description'               => $admin_survey['description'],
            //     //'survey_img'                => $admin_survey['survey_img'],
            //     'survey_type'               => $admin_survey['survey_type'],
            //     'survey_for'                => $admin_survey['survey_for'],
            //     'frequency_dependent_on'    => $admin_survey['frequency_dependent_on'],
            //     'frequency_days'            => $admin_survey['frequency_days'],
            //     'start_date'                => $admin_survey['start_date'],
            //     'surevy_open_periods'       => $admin_survey['surevy_open_periods'],
            //     "createdby"                 => $this->session->userdata('userid_ses'),
            //     "createdby_proxy"           => $this->session->userdata('proxy_userid_ses'),
            //     "createdon"                 => date("Y-m-d H:i:s")
            // );
           
            // $this->db->insert('survey',$insertSurvey);
            // $survey_insert_id = $this->db->insert_id();

            // $existingSrvey = $this->db->get_where('survey', array('survey_id' => $survey_insert_id))->row_array();

            
            // $updateArray = array(
            //     'survey_name'   => $existingSrvey['survey_name'].'-'.$survey_insert_id,
            //     'is_published'  => 0,
            //     'status'        => 1,
            //     "updatedby"     => $this->session->userdata('userid_ses'),
            //     "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
            //     "updatedon"     => date("Y-m-d H:i:s")
            // );
            // if(!empty($admin_survey['survey_img'])) {
            //     $imgpath = CV_PLATFORM_COMPANY_BASE_URL.'uploads/survey/'.$admin_survey['survey_img'];
            //     //$imgpath = 'https://compben.awtech.in/admin-portal/uploads/comp_logos/default_bg_img.png';
            //     $file_ext = pathinfo($imgpath,PATHINFO_EXTENSION);
            //     $new_img_name = $existingSrvey['survey_name'].'-'.$survey_insert_id.'.'.$file_ext;

            //     $content = file_get_contents($imgpath);
            //     $fp = fopen("uploads/survey/".$new_img_name, "w");
            //     fwrite($fp, $content);
            //     fclose($fp);
            //     $updateArray['survey_img'] = $new_img_name;
            // }
            // $this->db->where('survey_id',$survey_insert_id);
            // $this->db->update('survey',$updateArray);

            // Company Survey question insert

            // foreach(@$admin_survey_question as $asq) {
            //     $question_id    = $asq['question_id'];
            //     $question_type  = $asq['QuestionType'];
            //     $question_name  = $asq['QuestionName'];
            //     $question_title  = $asq['QuestionTitle'];
            //     $question_img  = $asq['quest_img'];

            //     $this->db->insert('survey_questions', 
            //         array(
            //             'survey_id'     => $survey_insert_id,
            //             'QuestionType'  => $question_type,
            //             'QuestionName'  => $question_name,
            //             'QuestionTitle'  => $question_title,
            //             //'quest_img'     => $question_img
            //         )
            //     );

                // $question_inserted_id = $this->db->insert_id();
                // if(!empty($question_img)) {
                //     $imgpath_ques = CV_PLATFORM_COMPANY_BASE_URL.'uploads/survey/question/'.$question_img;
                //     //$imgpath = 'https://compben.awtech.in/admin-portal/uploads/comp_logos/default_bg_img.png';
                //     $file_ext_ques = pathinfo($imgpath_ques,PATHINFO_EXTENSION);
                //     $new_img_name_ques = $question_name.'-'.$question_inserted_id.'.'.$file_ext_ques;

                //     $content_ques = file_get_contents($imgpath_ques);
                //     $fp_ques = fopen("uploads/survey/question/".$new_img_name_ques, "w");
                //     fwrite($fp_ques, $content_ques);
                //     fclose($fp_ques);
                //     $updateArrayQuestion['quest_img'] = $new_img_name_ques;
                //     $this->db->where('question_id',$question_inserted_id);
                //     $this->db->update('survey_questions',$updateArrayQuestion);
                // }
                

                // Answer insertion
                // foreach(@$admin_survey_anwser as $awn) {
                //     if($awn['question_id'] == $question_id) {
                //         $ans_name = $awn['Answer'];
                //         $ans_img = $awn['ans_img'];
                //         $this->db->insert('survey_answers',
                //             array(
                //                 'question_id' => $question_inserted_id,
                //                 'Answer'      => $awn['Answer'],
                //                 'ans_img'     => $awn['ans_img'],    
                //             )
                //         );
                //         $answer_inserted_id = $this->db->insert_id();
                //         if(!empty($ans_img)) {
                //             $imgpath_aws = CV_PLATFORM_COMPANY_BASE_URL.'uploads/survey/answer/'.$ans_img;
                //             $file_ext_aws = pathinfo($imgpath_aws,PATHINFO_EXTENSION);
                //             $new_img_name_aws = $ans_img.'-'.$answer_inserted_id.'.'.$file_ext_aws;

                //             $content_aws = file_get_contents($imgpath_aws);
                //             $fp_aws = fopen("uploads/survey/question/".$new_img_name_aws, "w");
                //             fwrite($fp_aws, $content_aws);
                //             fclose($fp_aws);
                //             $this->db->where('question_id',$answer_inserted_id);
                //             $this->db->update('survey_answers',array('ans_img' => $new_img_name_aws));
                //         }
                        
                //     }
                // }

            //}
            
        //     return array("status"=>true, "id"=>$survey_insert_id, "message"=>"Record successfully added.");
        // } else {
        //     return array("status"=>false, "message"=>"Invalid survey id");
        // }
    }

    public function copy_company_survey($sureyId) {

        $check = $this->db->get_where('survey',array('survey_id' => $sureyId))->row_array();
        if($check){
            $this->db->query('insert into survey ( category_id, keywords, survey_name, description, closing_description, survey_img, survey_type, survey_for, is_published, country, city, business_level1, business_level2, business_level3, functions, sub_functions, designations, grades, levels, educations, critical_talents, critical_positions, special_category, tenure_company, cutoff_date, frequency_dependent_on, frequency_days, start_date, surevy_open_periods, status, tenure_roles, createdby, createdby_proxy,updatedby_proxy) select category_id, keywords, survey_name, description, closing_description, survey_img, survey_type, survey_for, is_published, country, city, business_level1, business_level2, business_level3, functions, sub_functions, designations, grades, levels, educations, critical_talents, critical_positions, special_category, tenure_company, cutoff_date, frequency_dependent_on, frequency_days, start_date, surevy_open_periods, status, tenure_roles, createdby, createdby_proxy,updatedby_proxy from survey where survey_id='.$sureyId);

            $survey_insert_id = $this->db->insert_id();
            // $existingSrvey = $this->db->get_where('survey', array('survey_id' => $sureyId))->row_array();

            $cs_arr = array(
                'survey_name' => $check['survey_name'].'-'.$survey_insert_id,
                'is_published' => 0,
                'status' => 1,
                "createdby" => $this->session->userdata('userid_ses'),
                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                "createdon" => date("Y-m-d H:i:s"),
                "updatedby" => $this->session->userdata('userid_ses'),
                "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
                "updatedon" => date("Y-m-d H:i:s")
            );
            $this->db->where('survey_id',$survey_insert_id);
            $this->db->update('survey',$cs_arr);


            // Question data copy
            $selectQuestion = $this->db->get_where('survey_questions', array('survey_id' => $sureyId))->result_array();
            $qid = '';
            if( count($selectQuestion) ) {
                foreach($selectQuestion as $qes) {
                    $qid .= $qes['question_id'].',';
                }
                $qid = rtrim($qid,',');
            }

            $company_survey_anwser    = $this->db->query('SELECT * FROM `survey_answers` WHERE `question_id` IN ('.$qid.')')->result_array();

            foreach(@$selectQuestion as $asq) {
                $question_id    = $asq['question_id'];
                $question_type  = $asq['QuestionType'];
                $question_name  = $asq['QuestionName'];
                $question_title  = $asq['QuestionTitle'];
                $question_img  = $asq['quest_img'];

                if(!empty($asq['quest_img'])) {
                    $imgpath = CV_PLATFORM_COMPANY_BASE_URL.'uploads/survey/question/'.$asq['quest_img'];
                    $file_ext = pathinfo($imgpath,PATHINFO_EXTENSION);
                    $new_img_name = strtolower($asq['QuestionName']).'-'.$question_id.'.'.$file_ext;

                    $content = file_get_contents($imgpath);
                    $fp = fopen("uploads/survey/question/".$new_img_name, "w");
                    fwrite($fp, $content);
                    fclose($fp);
                    $question_img = $new_img_name;
                }

                $this->db->insert('survey_questions', 
                    array(
                        'survey_id'     => $survey_insert_id,
                        'QuestionType'  => $question_type,
                        'QuestionName'  => $question_name,
                        'QuestionTitle'  => $question_title,
                        'quest_img'     => $question_img
                    )
                );

                $question_inserted_id = $this->db->insert_id();

                // Answer insertion
                foreach(@$company_survey_anwser as $awn) {
                    if($awn['question_id'] == $question_id) {
                        $this->db->insert('survey_answers',
                            array(
                                'question_id' => $question_inserted_id,
                                'Answer'      => $awn['Answer'],
                                'ans_img'     => $awn['ans_img'],    
                            )
                        );
                    }
                }

            }
            return array("status"=>true, "id"=>$survey_insert_id, "message"=>"Record successfully added.");
        } else {
            return array("status"=>false, "message"=>"Invalid survey id");
        }
        
    }

    // public function show_admin_survey_NIU($surveyid) {
    //     $this->db->query('use '.CV_PLATFORM_DB_NAME);
    //     $this->db->order_by('createdon','ASC');
    //     //--------------------------------------------------
    //     $question = $this->db->get_where('survey_questions',array('survey_id'=>$surveyid))->result_array();
    //     $questionArray = array();
    //     foreach(@$question as $ques) {
    //         $answer = $this->db->get_where('survey_answers',array('question_id'=>$ques['question_id']))->result_array();
    //         $awsArray = array();
    //         foreach(@$answer as $aws) {
    //             $insArray = array('question_id' => $aws['question_id'],'answer' => $aws['Answer'], 'ans_img' => $aws['ans_img']);
    //             array_push($awsArray,$insArray);
    //         }
    //         $array = array(
    //             'qid'   => $ques['question_id'],
    //             'type'  => $ques['QuestionType'],
    //             'name'  => $ques['QuestionName'],
    //             'title' => $ques['QuestionTitle'],
    //             'img'   => $ques['quest_img'],
    //             'aws'   => $awsArray
    //         );
    //         array_push($questionArray,$array);
    //     }
    //     //--------------------------------------------------
    //     $company_db = $this->session->userdata('dbname_ses');
    //     $this->db->query('use '.$company_db);
    //     return json_encode($questionArray);
    // }

    public function show_company_survey($surveyid) {
        //echo $surveyid;die;
        $question = $this->db->get_where('survey_questions',array('survey_id'=>$surveyid,'p_qid'=>'0'))->result_array();
        $questionArray = array();
        foreach(@$question as $ques) {
            $answer = $this->db->get_where('survey_answers',array('question_id'=>$ques['question_id']))->result_array();
            $sub_question = $this->db->get_where('survey_questions',array('p_qid'=>$ques['question_id']))->result_array();
            $awsArray = array();

            $subArray = array();
            if(!empty($sub_question)){
                foreach(@$sub_question as $sub) {
                    $sArray = array('question_id' => $sub['question_id'],'QuestionName' => $sub['QuestionName'], 'sacle_upto' => $sub['sacle_upto']);
                    array_push($subArray,$sArray);
                }
            }

            foreach(@$answer as $aws) {
                $insArray = array('question_id' => $aws['question_id'],'answer' => $aws['Answer'], 'ans_img' => $aws['ans_img']);
                array_push($awsArray,$insArray);
            }
            $array = array(
                'qid'   => $ques['question_id'],
                'type'  => $ques['QuestionType'],
                'name'  => $ques['QuestionName'],
                'title' => $ques['QuestionTitle'],
                'sacle_upto' => $ques['sacle_upto'],
                'img'   => $ques['quest_img'],
                'aws'   => $awsArray,
                'sub'   => $subArray
            );
            array_push($questionArray,$array);
        }
        return $questionArray;
    }

    public function get_row_data($table, $whereArray=array()) {
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }
        return $this->db->get($table)->row_array();
    }

    public function deletedata_whereIn($table,$column,$ids)
    {
        $this->db->where_in($column,$ids);
        $res=$this->db->delete($table);
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }

    public function get_AdminData($table,$condition)
    {
        $this->db->query('use '.CV_PLATFORM_DB_NAME);
        $result = $this->db->get_where($table,$condition)->result_array();
        $company_db = $this->session->userdata('dbname_ses');
        $this->db->query('use '.$company_db);
        return $result;
    }

    public function getAutoCompleteUser($term) {
        $this->db->select("email as value, id");
        $this->db->from("login_user");
        $this->db->where(array("status"=>1,"id != " => $this->session->userdata('userid_ses')));
        $this->db->like('email', $term);
        return $this->db->get()->result_array();
    }

    public function getAimZoneMaster($whereArray=array()) {
        $this->db->select('l.name, l.email, s.survey_name, az.*');
        $this->db->from('survey_aimzone_master as az');
        $this->db->join('survey as s','s.survey_id = az.survey_id');
        $this->db->join('login_user as l','l.id = az.aim_owner_id');
        $this->db->join('survey_aimzone_items as azi','azi.aimzone_id = az.id');
        $this->db->where('az.status !=',3);
        
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }
        $this->db->group_by("az.id");
        $this->db->order_by("az.createdon", "desc");
        // $this->db->limit(10);
        $aimArray = $this->db->get()->result_array();
        return $aimArray;
    }

    public function getAimZoneMasterforEmail($whereArray=array()) {
        $this->db->select('l.name, l.email,lc.name as cname, lc.email as cemail, s.survey_name, az.*');
        $this->db->from('survey_aimzone_master as az');
        $this->db->join('survey as s','s.survey_id = az.survey_id');
        $this->db->join('login_user as l','l.id = az.aim_owner_id');
        $this->db->join('login_user as lc','lc.id = az.createdby');
        $this->db->where('az.status !=',3);
        
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }
        $this->db->order_by("az.createdon", "desc");
        // $this->db->limit(10);
        $aimArray = $this->db->get()->result_array();
        return $aimArray;
    }

    public function getAimZoneItem($whereArray=array()) {
        $this->db->select('l.name, l.email, li.email as item_owner_email, s.survey_name, az.survey_id, az.aim_owner_id, azi.*');
        $this->db->from('survey_aimzone_items as azi');
        $this->db->join('survey_aimzone_master as az','az.id = azi.aimzone_id');
        $this->db->join('survey as s','s.survey_id = az.survey_id');
        $this->db->join('login_user as l','l.id = az.aim_owner_id');
        $this->db->join('login_user as li','li.id = azi.item_owner_id');
        // $this->db->where('(azi.createdby="'.$this->session->userdata('userid_ses').'" or azi.item_owner_id ="'.$this->session->userdata('userid_ses').'")');
        
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }
        $this->db->order_by("azi.createdon", "ASC");
        $aimItemArray = $this->db->get()->result_array();
        return $aimItemArray;
    }

    public function getuserAnswer($whereArray=array()) {
        $this->db->select('usr.user_id as userId, usr.survey_id, usr.status, usa.*');
        $this->db->from('user_survey_response as usr');
        $this->db->join('user_survey_answer as usa','usa.user_survey_response_id = usr.id');
        
        if(!empty($whereArray)){
            $this->db->where($whereArray);
        }
        $result = $this->db->get()->result_array();
        return $result;
    }


}