<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corn_job_email_sent extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Wget') === false) {
            echo 'Access Forbidden. Contact Admin for more information.';
            die;
		}

        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
        $this->load->model("upload_model");
        //$this->load->model("approvel_model");
        $this->load->model('Mapping_model');
        $this->load->model("business_attribute_model");
        $this->load->model("rule_model");
        $this->load->model("common_model");
        $this->load->model("admin_model");
        $this->load->model("template_model");
        $this->load->database();

    }
	

	/*public function cron_send_mail()
	{

		//this method is use for send mail from admin db cron_mail_queue table
		$this->load->library('CronTab/BatchClasses/CronSendMail', null ,'CronSendMail');
		$this->CronSendMail->init();

	}*/

	/**
	 * Create Mail in company database
	 */
	public function cron_create_mail()
	{
		$this->load->library('CronTab/BatchClasses/CronBatchMail', null ,'cron_batch_mail');
		$rslt = $this->cron_batch_mail->init();
		die($rslt);
	}


	public function SentMailForEmployeeWithCornJob()
	{
	
	}
    
	public function mail_scheduler_by_cron()
	{
		$result=$this->db->query("SELECT * FROM corn_job_queue where status!=0 limit 5")->result();

		if(empty($result))
		{
			return false;
		}
		else
		{
			foreach ($result as $cron_job) {
			
			$getDb=$this->db->query("SELECT dbname from manage_company where id='".$cron_job->compnay_id."'")->result();
			if(trim($getDb[0]->dbname))
			{
				$this->db->query("Use ".$getDb[0]->dbname);        
			}
			else
			{
				continue;
			}

			if($cron_job->mail_stage==NEW_EMPLOYEEE)
			{
				//$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
			 	$obj=json_decode($cron_job->json_text);
				$userselected_list=explode(',',$obj->user_list);	
				$user_list=getSingleTableData('login_user',$obj->condtion,'id,email,name,approver_1,approver_2,approver_3,approver_4,manager_name');
				
				$newmanager_arr=explode(',',$obj->manager_arr);
				$filter_useremail=array();

$emailCount=$this->db->query("SELECT count(*) As total_records FROM sent_mail_new_approver where q_id='".$cron_job->q_id."'")->row();

if(!$emailCount->total_records)
 {

	if(in_array('manager', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		{
			if(!in_array($row->manager_name, $userselected_list))
			{
				array_push($filter_useremail, $row->manager_name);
			}                                   
		}   
	
		
	}
	if(in_array('approver_1', $newmanager_arr))
	{
		 foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_1, $userselected_list))
			{
			   array_push($filter_useremail, $row->approver_1);
			}                               
		 }
	}
	if(in_array('approver_2', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_2, $userselected_list))
			{
			   array_push($filter_useremail, $row->approver_2);
			}                                  
		 }
	}
	if(in_array('approver_3', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_3, $userselected_list))
			{
			   array_push($filter_useremail, $row->approver_3);
			}              
		 }
	}
	if(in_array('approver_4', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_4, $userselected_list))
			{
				array_push($filter_useremail, $row->approver_4);
			}           
		 }
	}
	if(in_array('employee', $newmanager_arr))
	{
		  foreach ($user_list as $row) 
		  {
			if(!in_array($row->email, $userselected_list))
			{
				array_push($filter_useremail,$row->email);
			}                                     
		  }
	}
	
	$final_emaillist=array_unique(array_merge($userselected_list,$filter_useremail));

	$main_db_arr = array();
					if($cron_job->status==1)
					{
							foreach($final_emaillist as $row => $value)
								{	
									$userName=$this->common_model->get_table('login_user', 'name,id', array('email'=>strtolower($value)), 'id');

									$main_db_arr[] = array("q_id"=>$cron_job->q_id, "user_id"=>$userName[0]['id'], "name"=>$userName[0]['name'], "email"=>$value, "status"=>0);
								}				
						if($main_db_arr)
						{
							$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);

							$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=2 where q_id='".$cron_job->q_id."'");
						}
					}

}
	
	############ Get SMTP DEtails FOR Sending Mail #############
	
	 $email_config=HLP_GetSMTP_Details($cron_job->compnay_id);
		 
	#############################################################
	$emailTemplate=$this->common_model->getEmailTemplate(NEW_EMPLOYEEE);

	$send_mail_arr = $this->db->query("SELECT id, q_id, name, email,user_id FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC")->result_array();

				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
					//return false;
				}

				foreach ($send_mail_arr as $row) {

					$password=rand(99999999,999999);
					
					$str=str_replace("{{employee_first_name}}",$row['name'], $emailTemplate[0]->email_body);
					$str=str_replace("{{url}}",site_url() , $str);
					$str=str_replace("{{email_id_reciver}}",$row['email'] , $str);
					$str=str_replace("{{password}}",$password , $str);
					$mail_body=$str;
					//echo $mail_body.'<hr>';
					$send_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row['email'], $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']); 

					//$send_status=1;
					if($send_status) 
					{
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);
						$this->common_model->updatePassword($row['user_id'],$password);
					}
				}
	
	
			}
			else if($cron_job->mail_stage==SALARY_RULE_NEXT_LEVEL_APPROVER)
			{
				//$this->db->query("DELETE FROM ".CV_PLATFORM_DB_NAME.".corn_job_queue where q_id='".$cron_job->q_id."'");
				$obj=json_decode($cron_job->json_text);
				$newEmailArray=json_decode($obj->user_list);

				if(!empty($newEmailArray))
						{
	
							############ Get SMTP DEtails FOR Sending Mail #############
	
							$email_config=HLP_GetSMTP_Details($cron_job->compnay_id);
	
							#############################################################
	
							$emailTemplate=$this->common_model->getEmailTemplate('salaryRuleNextLevelApprove');

							
				
				$emailCount=$this->db->query("SELECT count('id') As total_records FROM sent_mail_new_approver where q_id='".$cron_job->q_id."'")->row();

				if(!$emailCount->total_records)
				{
					$main_db_arr = array();
					if($cron_job->status==1)
					{
							foreach($newEmailArray as $row => $value )
								{	
									$userName=$this->common_model->get_table('login_user', 'name,id', array('email'=>strtolower($value)), 'id');

									$main_db_arr[] = array("q_id"=>$cron_job->q_id, "user_id"=>$userName[0]['id'], "name"=>$userName[0]['name'], "email"=>$value, "status"=>0);
								}				
						if($main_db_arr)
						{
							$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);

							$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=2 where q_id='".$cron_job->q_id."'");
						}
					}
					
				}
				
				$send_mail_arr = $this->db->query("SELECT id, q_id, name, email FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC")->result_array();

				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
					//return false;
				}

				foreach ($send_mail_arr as $row) {
					
					$str	= str_replace("{{approvers_first_name}}",$row['name'] , $emailTemplate[0]->email_body);
					$str	= str_replace("{{plan_name}}",$obj->plan_name , $str);
					$str	= str_replace("{{email_id_reciver}}",$row['email'] , $str);

					$mail_body=$str;

					$send_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row['email'], $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

					if($send_status)
					{
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);
					}

				}

				}
			}
			else if($cron_job->mail_stage==SALARY_RULE_APPROVE)
			{
				//$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
				$obj=json_decode($cron_job->json_text);
				
			   ############ Get SMTP DEtails FOR Sending Mail ###############

				  $email_config=HLP_GetSMTP_Details($cron_job->compnay_id);

			   ##############################################################
				//$conditions=$obj->conditions;
				$conditions=' id='.$obj->rule_id;
				$performance_cycle_id=getSingleTableData('hr_parameter',$conditions,'performance_cycle_id');
				
				$conditions2=' id='.$performance_cycle_id[0]->performance_cycle_id;				
				$rule_name=getSingleTableData('performance_cycle',$conditions2,'name');
				
				$emailTemplate=$this->common_model->getEmailTemplate(SALARY_RULE_APPROVE);				
				//$result=$this->performance_cycle_model->sentEmailToApprovers($obj->rule_id,$obj->user_session_email);
				$approver_arr=$this->db->query("SELECT esd.approver_1,lu.name,lu.id FROM `employee_salary_details` as esd JOIN login_user as lu on lu.email=esd.approver_1 where esd.rule_id='".$obj->rule_id."' group by esd.approver_1")->result();
				
				$tempArray=[];
				$subject="New Password";
								
				$emailCount=$this->db->query("SELECT count(*) As total_records FROM sent_mail_new_approver where q_id='".$cron_job->q_id."'")->row();
				
				if(!$emailCount->total_records)
				{
					$main_db_arr = array();
					if($cron_job->status==1)
					{
						foreach($approver_arr as $row)
						{	
							$main_db_arr[] = array("q_id"=>$cron_job->q_id, "user_id"=>$row->id, "name"=>$row->name, "email"=>$row->approver_1, "status"=>0);
						}				
						if($main_db_arr)
						{
							$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);

							$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=2 where q_id='".$cron_job->q_id."'");
						}
					}
				}
				//echo "SELECT id, q_id, name, email,user_id FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC";

				$send_mail_arr = $this->db->query("SELECT id, q_id, name, email,user_id FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC")->result_array();
				
				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
					//return false;
				}
				//echo "<pre>";print_r($send_mail_arr);die;
				
				foreach($send_mail_arr as $row)
				{	
					$password=HLP_generateRandomStringPassword();
					$str=str_replace("{{approvers_first_name}}", $row["name"] , $emailTemplate[0]->email_body);
					$str=str_replace("{{plan_name}}", $rule_name[0]->name , $str);
					$str=str_replace("{{email_id_reciver}}", $row["email"] , $str);
					$str=str_replace("{{url}}",base_url(), $str);
					$str=str_replace("{{password}}",$password, $str);
					$mail_body=$str;
					   
					$send_mail_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row["email"], $emailTemplate[0]->email_subject, $mail_body, $email_config['result'], $email_config['mail_fromname']);
					//$send_mail_status=1;
					if($send_mail_status)
					{
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);

						$this->common_model->updatePassword($row["user_id"],$password);
					}
					else
					{
						echo 'Not Sent<hr>'; 
					}		
				}
			}
			else if($cron_job->mail_stage==SALARY_RULE_APPROVE_REMINDER)
			{
				$obj=json_decode($cron_job->json_text);
				
			   ############ Get SMTP DEtails FOR Sending Mail ###############

				  $email_config=HLP_GetSMTP_Details($cron_job->compnay_id);

			   ##############################################################

				  $emailTemplate=$this->common_model->getEmailTemplate(SALARY_RULE_APPROVE_REMINDER);

				  $approver_arr=$this->db->query("SELECT esd.manager_emailid,lu.name,lu.id FROM `employee_salary_details` as esd JOIN login_user as lu on lu.email=esd.manager_emailid where esd.rule_id='".$obj->rule_id."' and esd.status<5 group by esd.manager_emailid")->result();

				  $emailCount=$this->db->query("SELECT count(*) As total_records FROM sent_mail_new_approver where q_id='".$cron_job->q_id."'")->row();
				
				if(!$emailCount->total_records)
				{
					$main_db_arr = array();
					if($cron_job->status==1)
					{
						foreach($approver_arr as $row)
						{	
							$main_db_arr[] = array("q_id"=>$cron_job->q_id, "user_id"=>$row->id, "name"=>$row->name, "email"=>$row->manager_emailid, "status"=>0);
						}				
						if($main_db_arr)
						{
							$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);

							$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=2 where q_id='".$cron_job->q_id."'");
						}
					}
				}
				

				$send_mail_arr = $this->db->query("SELECT id, q_id, name, email,user_id FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC")->result_array();
				
				// echo '<pre>';
				// print_r($send_mail_arr);
				// exit;

				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
					//return false;
				}

				foreach($send_mail_arr as $row)
				{	
					
					$str=str_replace("{{approvers_first_name}}",$row['name'] , $emailTemplate[0]->email_body);
				$str=str_replace("{{url}}",site_url() , $str);
				$str=str_replace("{{plan_name}}",$obj->plan_name , $str);
				$str=str_replace("{{email_id_reciver}}",$row['email'] , $str);
				$mail_body=$str;
					//echo $mail_body.'<hr>';



					$send_mail_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row["email"], $emailTemplate[0]->email_subject, $mail_body, $email_config['result'], $email_config['mail_fromname']);
					//$send_mail_status=1;
					if($send_mail_status)
					{
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);

						
					}
					
				}

			}

			else if($cron_job->mail_stage==NEW_SALARY_RULE_RELESED_EMPLOYEE)
			{
				$res=unserialize($cron_job->json_text);
			    ############ Get SMTP DEtails FOR Sending Mail ###############
				$email_config=HLP_GetSMTP_Details($cron_job->compnay_id);
			    ##############################################################
				$emailTemplate=$this->common_model->getEmailTemplate(NEW_SALARY_RULE_RELESED_EMPLOYEE);
				$manager_ids=explode(',',str_replace('on','',$res['managers']));
				$compnay_id=$cron_job->compnay_id;
				$emailCount=$this->db->query("SELECT count(*) As total_records FROM sent_mail_new_approver where q_id='".$cron_job->q_id."'")->row();
				
				if(!$emailCount->total_records)
				{
					$main_db_arr = array();
					if($cron_job->status==1)
					{
						for ($i=0; $i <count($manager_ids) ; $i++)
						{
							if($manager_ids[$i]!='')
							{	
								$conditions=" employee_salary_details.approver_1='".$manager_ids[$i]."' and employee_salary_details.rule_id='".$res['rule_id']."' and employee_salary_details.letter_status=3 ";
								$joincondition1="login_user";
								$joincondition2="employee_salary_details.user_id=login_user.id ";
								$employee_list=$this->admin_model->get_table("employee_salary_details", 'employee_salary_details.email_id,employee_salary_details.user_id,employee_salary_details.emp_name',$conditions,'',$joincondition1,$joincondition2);	
								$manager_id=$this->admin_model->get_table_row('login_user', 'id',array('email'=>$manager_ids[$i])); 
								foreach ($employee_list as $row)
								{	
									$main_db_arr[] = array("q_id"=>$cron_job->q_id, "user_id"=>$row['user_id'], "name"=>$row['emp_name'], "email"=>$row['email_id'], "status"=>0);	
								//$this->template_model->updateCommon('employee_salary_details',array("letter_status"=>1,"letter_path"=>$letter_path),array('user_id'=>$value['user_id'],'rule_id'=>$res['rule_id']));	
								}	
							}
						} 
	
						if($main_db_arr)
						{
							$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);
							$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=2 where q_id='".$cron_job->q_id."'");
						}	
					}
				}
				
				$send_mail_arr = $this->db->query("SELECT id, q_id, name, email,user_id FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC limit 50")->result_array();
				
				$pk_ids_arr = array();
				foreach($send_mail_arr as $tbl_row)
				{
					$pk_ids_arr[] = $tbl_row["id"];
				}
				if($pk_ids_arr)
				{
					$pk_ids_str = implode(",",$pk_ids_arr);
					$this->db->query("UPDATE sent_mail_new_approver SET status = 2, sent_date = '".date("Y-m-d H:i:s")."' WHERE q_id='".$cron_job->q_id."' AND id IN (".$pk_ids_str.") ");
				}
				
				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
					//return false;
				}
				$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$res['rule_id']));
				foreach($send_mail_arr as $row)
				{			
					$password=HLP_generateRandomStringPassword();			
					$str=str_replace("{{employee_first_name}}", $row['name'], $emailTemplate[0]->email_body);
					$str=str_replace("{{url}}", site_url(), $str);
					$str=str_replace("{{plan_name}}", $rule_dtls["name"], $str);
					$str=str_replace("{{rule_name}}", $rule_dtls["salary_rule_name"], $str);
					$str=str_replace("{{email_id_reciver}}", $row['email'], $str);
					$str=str_replace("{{password}}", $password, $str);
					$mail_body=$str;
					//echo $mail_body.'<hr>';
					$send_mail_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row["email"], $emailTemplate[0]->email_subject, $mail_body, $email_config['result'], $email_config['mail_fromname']);
					//$send_mail_status=1;
					if($send_mail_status)
					{						
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);
						$this->common_model->updatePassword($row["user_id"], $password);	
						sleep(2);					
					}					
				}
			}
			
		else if($cron_job->mail_stage==NEW_SALARY_RULE_RELESED_MANAGER)
			{
				$res=unserialize($cron_job->json_text);

			   ############ Get SMTP DEtails FOR Sending Mail ###############

				  $email_config=HLP_GetSMTP_Details($cron_job->compnay_id);

			   ##############################################################

				  $emailTemplate=$this->common_model->getEmailTemplate(NEW_SALARY_RULE_RELESED_MANAGER);


		         ################## Email Sent ####################
		

             $manager_ids=explode(',',str_replace('on','',$res['managers']));
	      
             $compnay_id=$cron_job->compnay_id;

             $emailCount=$this->db->query("SELECT count(*) As total_records FROM sent_mail_new_approver where q_id='".$cron_job->q_id."'")->row();


             if(!$emailCount->total_records)
				{
					$main_db_arr = array();
					if($cron_job->status==1)
					{

				for ($i=0; $i <count($manager_ids) ; $i++)
				{

				if($manager_ids[$i]!='')
				{

				
				$row=$this->admin_model->get_table_row('login_user', 'id,name,email',array('email'=>$manager_ids[$i])); 

				

				$main_db_arr[] = array("q_id"=>$cron_job->q_id, "user_id"=>$row['id'], "name"=>$row['name'], "email"=>$row['email'], "status"=>0);


				}
            } 

					if($main_db_arr)
					{
					$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);

					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=2 where q_id='".$cron_job->q_id."'");
					}

									
						
					}
				}


				$send_mail_arr = $this->db->query("SELECT id, q_id, name, email,user_id FROM sent_mail_new_approver where q_id='".$cron_job->q_id."' AND status = 0 ORDER BY id ASC")->result_array();
				
				// echo '<pre>';
				// print_r($send_mail_arr);
				// exit;

				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$cron_job->q_id."'");
					//return false;
				}
				
				$rule_dtls = $this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$res['rule_id']));
				
				foreach($send_mail_arr as $row)
				{	
					$str=str_replace("{{employee_first_name}}", $row['name'], $emailTemplate[0]->email_body);
					$str=str_replace("{{url}}", site_url(), $str);
					$str=str_replace("{{plan_name}}", $rule_dtls["name"], $str);
					$str=str_replace("{{rule_name}}", $rule_dtls["salary_rule_name"], $str);
					$mail_body=$str;
					//echo $mail_body.'<hr>';
					
					$send_mail_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row["email"], $emailTemplate[0]->email_subject, $mail_body, $email_config['result'], $email_config['mail_fromname']);
					//$send_mail_status=1;
					if($send_mail_status)
					{
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);						
					}					
				}
		     




		##################################################		  	


			}
			else if($cron_job->mail_stage=='genarate_letter')
			{
                $this->load->library('m_pdf'); 
		     $res=unserialize($result[0]->json_text);
             $manager_ids=explode(',',str_replace('on','',$res['managers']));
	         $data['templatedesc']=$this->template_model->get_data('template', 'TemplateID ='.$res['TempateID']);
             $compnay_id=$result[0]->compnay_id;

		     for ($i=0; $i <count($manager_ids) ; $i++)
		     {
               if($manager_ids[$i]!=''){

               $conditions=" employee_salary_details.approver_1='".$manager_ids[$i]."' and employee_salary_details.rule_id='".$res['rule_id']."' and employee_salary_details.letter_status=3 ";
               $joincondition1="login_user";
               $joincondition2="employee_salary_details.user_id=login_user.id ";
	           $employee_list=$this->admin_model->get_table("employee_salary_details", 'employee_salary_details.*,login_user.employee_code',$conditions,'',$joincondition1,$joincondition2); 
	           $manager_id=$this->admin_model->get_table_row('login_user', 'id',array('email'=>$manager_ids[$i])); 
	// / 'uploads/released_letters/company_id/rul_id/manager_id/employee_id.pdf'; 
			    if(!is_dir('uploads/released_letters/'.$compnay_id))
			    {
		          mkdir('./uploads/released_letters/'.$compnay_id, 0777,TRUE);
			    }
				if (!is_dir('uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'])) 
				{
					mkdir('./uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'], 0777,TRUE);
				} 
				if (!is_dir('uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'])) 
				{
					mkdir('./uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'], 0777,TRUE);
				}
	      

				foreach ($employee_list as $key => $value)
				{
		           $data['salary'][0] = $value;
				   $data['empid']=$value['user_id']; 
				   $pdfFilePath =$value['employee_code'].'-'.str_replace(' ','-', $value['emp_name']).'.pdf'; 
				   $letter_path ='uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'].'/'.$pdfFilePath;  
				
				//$location='uploads/'; 
				$location='uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'].'/';     
				$html= $this->load->view('admin/template/pdf',$data,true);
				 $mpdf = new mPDF();
				 $url =$data['templatedesc'][0]['latter_head_url'];
                 $mpdf->SetWatermarkImage($url, 0.1, '', P);
                 $mpdf->showWatermarkImage = true;
				 $mpdf->WriteHTML($html);
				 $mpdf->Output($location.$pdfFilePath, "F");

				// update letter_status  
				$this->template_model->updateCommon('employee_salary_details',array("letter_status"=>1,"letter_path"=>$letter_path),array('user_id'=>$value['user_id'],'rule_id'=>$res['rule_id']));
				
	               }

	            
	            }
            } 

               $this->db->query("update ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$result[0]->q_id."'"); 
    
		
			}
			else
			{
				continue;
			}			
		}

		}	  
	}


    public function SentMailForEmployeeWithCornJob_NIU()
	{
		$result=$this->db->query("SELECT * FROM corn_job_queue where status=1 limit 1")->result();
		
		if(empty($result))
		{
			return false;
		}
		else
		{
			$getDb=$this->db->query("SELECT dbname from manage_company where id='".$result[0]->compnay_id."'")->result();
			if(trim($getDb[0]->dbname))
			{
				$this->db->query("Use ".$getDb[0]->dbname);        
			}
	
			if($result[0]->mail_stage==NEW_EMPLOYEEE)
			{
				//$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$result[0]->q_id."'");
			 	$obj=json_decode($result[0]->json_text);
				$userselected_list=explode(',',$obj->user_list);	
				$user_list=getSingleTableData('login_user',$obj->condtion,'id,email,name,approver_1,approver_2,approver_3,approver_4,manager_name');
				
				$newmanager_arr=explode(',',$manager_arr);
				$filter_useremail=array();
	if(in_array('manager', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		{
			if(!in_array($row->manager_name, $userselected_list))
			{
				array_push($filter_useremail, $row->manager_name);
			}                                   
		}   
	
		
	}
	if(in_array('approver_1', $newmanager_arr))
	{
		 foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_1, $userselected_list))
			{
			   array_push($filter_useremail, $row->approver_1);
			}                               
		 }
	}
	if(in_array('approver_2', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_2, $userselected_list))
			{
			   array_push($filter_useremail, $row->approver_2);
			}                                  
		 }
	}
	if(in_array('approver_3', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_3, $userselected_list))
			{
			   array_push($filter_useremail, $row->approver_3);
			}              
		 }
	}
	if(in_array('approver_4', $newmanager_arr))
	{
		foreach ($user_list as $row) 
		 {
			if(!in_array($row->approver_4, $userselected_list))
			{
				array_push($filter_useremail, $row->approver_4);
			}           
		 }
	}
	if(in_array('employee', $newmanager_arr))
	{
		  foreach ($user_list as $row) 
		  {
			if(!in_array($row->email, $userselected_list))
			{
				array_push($filter_useremail,$row->email);
			}                                     
		  }
	}
	
	
	############ Get SMTP DEtails FOR Sending Mail #############
	
	 $email_config=HLP_GetSMTP_Details($result[0]->compnay_id);
		 
	#############################################################
	
	$final_emaillist=array_unique(array_merge($userselected_list,$filter_useremail));
	
	$emailTemplate=$this->common_model->getEmailTemplate(NEW_EMPLOYEEE);
	
	for($i=0;$i<count($final_emaillist);$i++)
	{
	
	   
	  $username=$this->admin_model->get_table_row('login_user','name,id',['email'=>$final_emaillist[$i]]);
	  
		$password=rand(99999999,999999);
		$result=$this->common_model->updatePassword($username['id'],$password);
		$str=str_replace("{{employee_first_name}}",$username['name'], $emailTemplate[0]->email_body);
		$str=str_replace("{{url}}",site_url() , $str);
		$str=str_replace("{{email_id_reciver}}",$final_emaillist[$i] , $str);
		$str=str_replace("{{password}}",$password , $str);
		$mail_body=$str;
		  // echo $mail_body.'<hr>';
	 $send_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $final_emaillist[$i], $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);
	 //$send_status=1; 
	 if($send_status)
	 {

	 }  
	   
	}
			}
			else if($result[0]->mail_stage==SALARY_RULE_NEXT_LEVEL_APPROVER)
			{
				$this->db->query("DELETE FROM ".CV_PLATFORM_DB_NAME.".corn_job_queue where q_id='".$result[0]->q_id."'");
				$obj=json_decode($result[0]->json_text);
				$newEmailArray=json_decode($obj->user_list);
				
				if(!empty($newEmailArray))
						{
	
							############ Get SMTP DEtails FOR Sending Mail #############
	
							$email_config=HLP_GetSMTP_Details($result[0]->compnay_id);
	
							#############################################################
	
							$emailTemplate=$this->common_model->getEmailTemplate('salaryRuleNextLevelApprove');
	
							for($i=0;$i<count($newEmailArray);$i++)
							{
	
								//echo $newEmailArray[$i];
								$result=$this->common_model->get_table('login_user', 'name', array('email'=>strtolower($newEmailArray[$i])), 'id');
	
								$str=str_replace("{{approvers_first_name}}",$result[0]['name'] , $emailTemplate[0]->email_body);
								$str=str_replace("{{plan_name}}",$ruleDtls['name'] , $str);
								$str=str_replace("{{email_id_reciver}}",$newEmailArray[$i] , $str);
	
								$mail_body=$str;
								//echo $mail_body.'<hr>';
								$this->common_model->send_emails_from_corn_job($email_config['email_from'], $new_manager_emailid, $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);
	
							}
						}
			}
			else if($result[0]->mail_stage==SALARY_RULE_APPROVE)
			{
				//$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$result[0]->q_id."'");
				$obj=json_decode($result[0]->json_text);
				
			   ############ Get SMTP DEtails FOR Sending Mail ###############
				  $email_config=HLP_GetSMTP_Details($result[0]->compnay_id);
			   ##############################################################
				//$conditions=$obj->conditions;
				$conditions=' id='.$obj->rule_id;
				$performance_cycle_id=getSingleTableData('hr_parameter',$conditions,'performance_cycle_id');
				
				$conditions2=' id='.$performance_cycle_id[0]->performance_cycle_id;				
				$rule_name=getSingleTableData('performance_cycle',$conditions2,'name');
				
				$emailTemplate=$this->common_model->getEmailTemplate(SALARY_RULE_APPROVE);				
				//$result=$this->performance_cycle_model->sentEmailToApprovers($obj->rule_id,$obj->user_session_email);
				$approver_arr=$this->db->query("SELECT esd.approver_1,lu.name,lu.id FROM `employee_salary_details` as esd JOIN login_user as lu on lu.email=esd.approver_1 where esd.rule_id='".$obj->rule_id."' group by esd.approver_1")->result();
				
				$tempArray=[];
				$subject="New Password";
				$count=count($approver_arr);
				
				$emailCount=$this->db->query("SELECT count(*) As total_records FROM sent_mail_new_approver where rule_id='".$obj->rule_id."'")->row();

				if(!$emailCount->total_records)
				{
					$main_db_arr = array();
					foreach($approver_arr as $row)
					{	
						$main_db_arr[] = array("rule_id"=>$obj->rule_id, "user_id"=>$row->id, "name"=>$row->name, "email"=>$row->approver_1, "status"=>0);
					}				
					if($main_db_arr)
					{
						$this->rule_model->insert_data_as_batch("sent_mail_new_approver", $main_db_arr);
					}
				}
				
				$send_mail_arr = $this->db->query("SELECT id, rule_id, name, email FROM sent_mail_new_approver where rule_id='".$obj->rule_id."' AND status = 0 ORDER BY id ASC")->result_array();
				if(empty($send_mail_arr))
				{
					$this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$result[0]->q_id."'");
					return false;
				}
				//echo "<pre>";print_r($send_mail_arr);die;
				
				foreach($send_mail_arr as $row)
				{	
					$password=HLP_generateRandomStringPassword();
					$str=str_replace("{{approvers_first_name}}", $row["name"] , $emailTemplate[0]->email_body);
					$str=str_replace("{{plan_name}}", $rule_name[0]->name , $str);
					$str=str_replace("{{email_id_reciver}}", $row["email"] , $str);
					$str=str_replace("{{url}}",base_url(), $str);
					$str=str_replace("{{password}}",$password, $str);
					$mail_body=$str;      
					$send_mail_status=$this->common_model->send_emails_from_corn_job($email_config['email_from'], $row["email"], $emailTemplate[0]->email_subject, $mail_body, $email_config['result'], $email_config['mail_fromname']);
					//echo "<pre>";print_r($send_mail_status);die;
					if($send_mail_status)
					{
						$this->db->query("UPDATE sent_mail_new_approver SET status = 1, sent_date = '".date("Y-m-d H:i:s")."' WHERE id = ".$row["id"]);	
						$this->common_model->updatePassword($row["rule_id"],$password);
					}		
				}
			}
			else if($result[0]->mail_stage==SALARY_RULE_APPROVE_REMINDER)
			{
				$this->db->query("DELETE FROM ".CV_PLATFORM_DB_NAME.".corn_job_queue where q_id='".$result[0]->q_id."'");
			}
			else
			{
				return false;
			}			
		}	  
	}

// public function SentMailForEmployeeWithCornJob_NIU()
// {
//     $result=$this->db->query("SELECT * FROM corn_job_queue where status=1 limit 1")->result();
//     $getDb=$this->db->query("SELECT dbname from manage_company where id='".$result[0]->compnay_id."'")->result();

//     if(trim($getDb[0]->dbname))
//         {
//             $this->db->query("Use ".$getDb[0]->dbname);        
//         }
//     if(empty($result))
//     {
//         return false;
//     }
//     else
//     {

//         if($result[0]->mail_stage==NEW_EMPLOYEEE)
//         {
//             $this->db->query("UPDATE ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$result[0]->q_id."'");
//          $obj=json_decode($result[0]->json_text);
   

//     $userselected_list=explode(',',$obj->user_list);

//  $user_list=getSingleTableData('login_user',$obj->condtion,'id,email,name,approver_1,approver_2,approver_3,approver_4,manager_name');

 
// $newmanager_arr=explode(',',$manager_arr);
// $filter_useremail=array();
// if(in_array('manager', $newmanager_arr))
// {
//     foreach ($user_list as $row) 
//     {
//         if(!in_array($row->manager_name, $userselected_list))
//         {
//             array_push($filter_useremail, $row->manager_name);
//         }                                   
//     }   

    
// }
// if(in_array('approver_1', $newmanager_arr))
// {
//      foreach ($user_list as $row) 
//      {
//         if(!in_array($row->approver_1, $userselected_list))
//         {
//            array_push($filter_useremail, $row->approver_1);
//         }                               
//      }
// }
// if(in_array('approver_2', $newmanager_arr))
// {
//     foreach ($user_list as $row) 
//      {
//         if(!in_array($row->approver_2, $userselected_list))
//         {
//            array_push($filter_useremail, $row->approver_2);
//         }                                  
//      }
// }
// if(in_array('approver_3', $newmanager_arr))
// {
//     foreach ($user_list as $row) 
//      {
//         if(!in_array($row->approver_3, $userselected_list))
//         {
//            array_push($filter_useremail, $row->approver_3);
//         }              
//      }
// }
// if(in_array('approver_4', $newmanager_arr))
// {
//     foreach ($user_list as $row) 
//      {
//         if(!in_array($row->approver_4, $userselected_list))
//         {
//             array_push($filter_useremail, $row->approver_4);
//         }           
//      }
// }
// if(in_array('employee', $newmanager_arr))
// {
//       foreach ($user_list as $row) 
//       {
//         if(!in_array($row->email, $userselected_list))
//         {
//             array_push($filter_useremail,$row->email);
//         }                                     
//       }
// }




function releaseLetterToManager()
{

	$this->load->library('m_pdf');
	$result=$this->db->query("SELECT * FROM ".CV_PLATFORM_DB_NAME.".corn_job_queue where mail_stage='genarate_letter' and status=1  limit 1")->result();
		if(empty($result))
		{
			return false;
		}
		else
		{
		    
		 
		     $res=unserialize($result[0]->json_text);
            
        $manager_ids=explode(',',str_replace('on','',$res['managers']));
    
     $getDb=$this->db->query("SELECT dbname from manage_company where id='".$result[0]->compnay_id."'")->result();
// print_r($getDb);
// die;
			if(trim($getDb[0]->dbname))
			{
				$this->db->query("Use ".$getDb[0]->dbname);        
			}
			else
			{
				return false;
			}
	$data['templatedesc']=$this->template_model->get_data('template', 'TemplateID ='.$res['TempateID']);
$compnay_id=$result[0]->compnay_id;

     for ($i=0; $i <count($manager_ids) ; $i++)
     {
   if($manager_ids[$i]!=''){

 $conditions=" employee_salary_details.approver_1='".$manager_ids[$i]."' and employee_salary_details.rule_id='".$res['rule_id']."' and employee_salary_details.letter_status=3 ";
$joincondition1="login_user";
$joincondition2="employee_salary_details.user_id=login_user.id ";
	$employee_list=$this->admin_model->get_table("employee_salary_details", 'employee_salary_details.*,login_user.employee_code',$conditions,'',$joincondition1,$joincondition2); 
	$manager_id=$this->admin_model->get_table_row('login_user', 'id',array('email'=>$manager_ids[$i])); 
	// / 'uploads/released_letters/company_id/rul_id/manager_id/employee_id.pdf'; 
	    if(!is_dir('uploads/released_letters/'.$compnay_id))
	    {
          mkdir('./uploads/released_letters/'.$compnay_id, 0777,TRUE);
	    }
		if (!is_dir('uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'])) 
		{
			mkdir('./uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'], 0777,TRUE);
		} 
		if (!is_dir('uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'])) 
		{
			mkdir('./uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'], 0777,TRUE);
		}
	      

			foreach ($employee_list as $key => $value)
			{
	           $data['salary'][0] = $value;
			   $data['empid']=$value['user_id']; 
			   $pdfFilePath =$value['employee_code'].'-'.str_replace(' ','-', $value['emp_name']).'.pdf'; 
			   $letter_path ='uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'].'/'.$pdfFilePath;  
			
			//$location='uploads/'; 
			$location='uploads/released_letters/'.$compnay_id.'/'.$res['rule_id'].'/'.$manager_id['id'].'/';     
			$html= $this->load->view('admin/template/pdf',$data,true);
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
			$mpdf->Output($location.$pdfFilePath, "F");

			// update letter_status  
			$this->template_model->updateCommon('employee_salary_details',array("letter_status"=>1,"letter_path"=>$letter_path),array('user_id'=>$value['user_id'],'rule_id'=>$res['rule_id']));
			
               }

            
              }
            } 

     $this->db->query("update ".CV_PLATFORM_DB_NAME.".corn_job_queue set status=0 where q_id='".$result[0]->q_id."'"); 
    
		}
}

function test_pdf()
{
$letter_path = 'test.pdf';  
$pdfFilePath = 'test.pdf'; 
  
// 'uploads/released_letters/company_id/rul_id/manager_id/employee_id.pdf';
 if(!is_dir('uploads/released_letters/1'))
{
 mkdir('./uploads/released_letters/1', 0777,TRUE);	
 if(!is_dir('uploads/released_letters/1/2'))
 {
      mkdir('./uploads/released_letters/1/2', 0777,TRUE);	
 }
 if(!is_dir('uploads/released_letters/1/2/3'))
 {
      mkdir('./uploads/released_letters/1/2/3', 0777,TRUE);	
 }
}
$location='uploads/released_letters/1/2/3/'; 
$this->load->library('m_pdf');
$mpdf = new mPDF();
$mpdf->WriteHTML('yest');
$mpdf->Output($location.$pdfFilePath, "F");	   
}

function test_email()
{ 
$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
$email_subject='Testing Email';
$email_config["protocol"] = "smtp";
$email_config["smtp_host"] = 'smtp.gmail.com';
$email_config["smtp_port"] =  465;
$email_config["smtp_user"] = 'rewards@oyorooms.com';
$email_config["smtp_pass"] = 'Comp@2019';
$email_config["smtp_crypto"] = "ssl";
$this->load->library('email', $email_config);
$this->email->set_newline("\r\n");
$this->email->from('info@compport.com', "Compport");
$this->email->to(array('jaiprakash201019@gmail.com','jai@alinasoftwares.in','ravi.singroli@compport.com','rakesh.saoji@compport.com'));
$this->email->subject($email_subject);
$this->email->message('<h1>Sending email via SMTP server</h1><p>From User End.</p>');
if ($this->email->send()) {
    echo 'send';
    }
    else
    {'not send';}
echo $this->email->print_debugger();
}


public function checkDb()
{
    
}

}