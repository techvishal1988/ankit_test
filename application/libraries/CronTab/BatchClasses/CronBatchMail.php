<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CronBatchMail {

	private $batchID;
	private $objectType;
	private $companyID;
	private $emailType;
	private $priorityLevel;
	private $numberOfItmes;
	private $currentTime;
	private $batchItems = array();
	private $emailSetStatus;
	private $adminDBGetstatus;
	private $adminDBEmailCreatedStatus;
	private $adminDBEmailInProcessStatus;
	private $totalInsertedRows;
	private $msg;
	private $dbName;
	private $adminDBName;
	private $site_url;
	private $CI;

	public function __construct(){

		$this->CI = & get_instance();
		$this->priorityLevel    = 1;/* Change according to requirement */
		$this->currentTime	  	= date("Y-m-d H:i:s",time());
		$this->emailSetStatus	= 0; //for comapny db email create but not send
		$this->adminDBGetstatus	= 0; //for admin db get row
		$this->adminDBEmailInProcessStatus = 1; //for admin db set status
		$this->adminDBEmailCreatedStatus = 2; //for admin db set status
		$this->totalInsertedRows = 0; //set default is 0
		$this->db 		  		= $this->CI->db;
		$this->adminDBName      = CV_PLATFORM_DB_NAME;
		$this->site_url 		= base_url();

	}

	public function init(){

		$this->batchItems   	= $this->getCronBatchItems();
		$this->numberOfItmes 	= count($this->batchItems);

		/* if no record found for process then return  and update cronLog and cronTab table */
		if(!$this->numberOfItmes){ return $this->msg;}
		/* process batch data */
		$processBatchDataCount = $this->processBatchData($this);
		/* end process batch data */
		/* After complete all process */
		$processBatchData['processRcCount'] = isset($processBatchDataCount) ? $processBatchDataCount : 0;

		/* Update admin DB after complete all process */
		$updateAdminDB = $this->update_admin_db($this);

		return $this->msg;//$processBatchData;
	}

	public function getBatchValue($memberName){
		if(isset($this->$memberName)){
			return $this->$memberName;
		} else {
			show_error("The $memberName is not valid");
		}
	}

	public function getCronBatchItems(){

		$process_data_array = array();
		/**
		 * select row for create mail from admin db and get data from corn_job_queue table which have status 0
		 */

		$this->db->query("Use ". $this->adminDBName);
		$where_job_queue_condition = array('corn_job_queue.status' => $this->adminDBGetstatus);
		$where_in_job_queue_condition = array(NEW_EMPLOYEEE, SALARY_RULE_NEXT_LEVEL_APPROVER, NEW_SALARY_RULE_RELESED_MANAGER, NEW_SALARY_RULE_RELESED_EMPLOYEE, SALARY_RULE_APPROVE, SALARY_RULE_APPROVE_REMINDER);//update as per requirement
		$this->db->select('corn_job_queue.q_id, corn_job_queue.json_text, corn_job_queue.compnay_id, corn_job_queue.mail_stage, corn_job_queue.status, manage_company.dbname');
		$this->db->from('corn_job_queue');
		$this->db->join("manage_company","manage_company.id = corn_job_queue.compnay_id");
		$this->db->where($where_job_queue_condition);
		$this->db->where_in('mail_stage', $where_in_job_queue_condition);
		$this->db->order_by('q_id', 'ASC');
		$result = $this->db->get()->row_array();

		if(empty($result)) {
			$this->msg = "NO PROCESS PENDING FOR CREATE MAIL: ". $this->currentTime;
			return $process_data_array;
		}

		if(empty($result['compnay_id'])) {

			$this->update_admin_db_by_qid($result['q_id']);
			$this->msg = "THERE ARE SEEMS ERROR COMPANY ID NOT FOUND: ". $this->currentTime;
			return $process_data_array;
		}

		/**
		 * select company database
		 */
		if(!empty($result['dbname'])) {

			$where_check_db_condition = array('SCHEMA_NAME' => $result['dbname']);
			$this->db->select('SCHEMA_NAME');
			$this->db->from('INFORMATION_SCHEMA.SCHEMATA');
			$this->db->where($where_check_db_condition);
			$check_db = $this->db->get()->row_array();

			if(empty($check_db)){
				/*
				* if schema not found then return
				*/
				$this->update_admin_db_by_qid($result['q_id']);
				$this->msg = "THERE ARE SEEMS ERROR COMPANY DATABASE NOT EXIST: ". $this->currentTime;
				return $process_data_array;

			}

			$this->db->query("Use ". $result['dbname']);

		} else {

			$this->update_admin_db_by_qid($result['q_id']);
			$this->msg = "THERE ARE SEEMS ERROR COMPANY DB NAME NOT FOUND: ". $this->currentTime;
			return $process_data_array;
		}

		$this->batchID 		= $result['q_id'];
		$this->companyID 	= $result['compnay_id'];
		$this->dbName 		= $result['dbname'];

		if(!empty($result['mail_stage']) && $result['mail_stage'] == NEW_SALARY_RULE_RELESED_MANAGER) {

			$process_data_array = $this->get_salary_rule_relesed_manager_data($result);

		} else if(!empty($result['mail_stage']) && $result['mail_stage'] == NEW_EMPLOYEEE) {

			$process_data_array = $this->get_new_emp_data($result);

		} else if(!empty($result['mail_stage']) && $result['mail_stage'] == SALARY_RULE_APPROVE) {//done

			$process_data_array = $this->get_salary_rule_approve_data($result);

		} else if(!empty($result['mail_stage']) && $result['mail_stage'] == SALARY_RULE_APPROVE_REMINDER) {//done

			$process_data_array = $this->get_salary_rule_approve_reminder_data($result);

		} else if(!empty($result['mail_stage']) && $result['mail_stage'] == NEW_SALARY_RULE_RELESED_EMPLOYEE) {//done

			$process_data_array = $this->get_salary_rule_relesed_employee_data($result);

		} else if(!empty($result['mail_stage']) && $result['mail_stage'] == SALARY_RULE_NEXT_LEVEL_APPROVER) {

			$process_data_array = $this->get_salary_rule_next_level_approver_data($result);

		} else {//default case

			$this->msg = "MAIL STAGE NOT FOUND : ". $this->currentTime;
			return $process_data_array;

		}

		//$this->msg = "DATA FOUND SUCESSFULLY";
		return $process_data_array;
	}


	public function processBatchData($cronBatch){

		$priorityLevel  = $cronBatch->getBatchValue('priorityLevel');
		$batchItemsData	= $cronBatch->getBatchValue('batchItems');
		$currentTime 	= $cronBatch->getBatchValue('currentTime');
		$emailSetStatus = $cronBatch->getBatchValue('emailSetStatus');
		$batchID 		= $cronBatch->getBatchValue('batchID');
		$companyID 		= $cronBatch->getBatchValue('companyID');
		$emailType 		= $cronBatch->getBatchValue('emailType');
		$dbName 		= $cronBatch->getBatchValue('dbName');

		if(count($batchItemsData) == 0){ return;}

			/**
			 * get config details
			 */
			$email_config	= HLP_GetSMTP_Details($companyID);

			if(count($email_config) == 0){ $this->msg = "SMTP DETAILS NOT FOUND: ". $this->currentTime; return;}

			$batchItemsQueueInsertData 	  = array();

			foreach($batchItemsData as $key => $batchItems){

				//set cron_mail_queue table data
				$batchItemsQueueInsertData[$key]['q_id']	  		= $batchID;
				$batchItemsQueueInsertData[$key]['user_id']	  		= trim($batchItems['user_id']);
				$batchItemsQueueInsertData[$key]['name']	  		= trim($batchItems['name']);
				$batchItemsQueueInsertData[$key]['email']	  		= trim($batchItems['email']);
				$batchItemsQueueInsertData[$key]['status']			= $emailSetStatus;
				$batchItemsQueueInsertData[$key]['priority_level']	= $priorityLevel;
				$batchItemsQueueInsertData[$key]['email_from'] 		= trim($email_config['email_from']);
				$batchItemsQueueInsertData[$key]['email_from_name']	= trim($email_config['mail_fromname']);
				$batchItemsQueueInsertData[$key]['email_subject'] 	= trim($batchItems['email_subject']);
				$batchItemsQueueInsertData[$key]['email_content']	= addslashes($batchItems['email_content']);
				$batchItemsQueueInsertData[$key]['createdon']		= $currentTime;

				//$batchItemsQueueInsertData[$key]['updatedon']	  = '';
				if(!empty($batchItems['email_cc']) && is_array($batchItems['email_cc'])) {
					$batchItemsQueueInsertData[$key]['email_cc'] = json_encode($batchItems['email_cc']);
				}

				if(!empty($batchItems['email_bcc']) && is_array($batchItems['email_bcc'])) {
					$batchItemsQueueInsertData[$key]['email_bcc'] = json_encode($batchItems['email_bcc']);
				}

			}

		//Save data into sent_mail_new_approver table.
		if(count($batchItemsQueueInsertData)){

			$total_insert_rows = $this->db->insert_batch('sent_mail_new_approver', $batchItemsQueueInsertData);
			$this->totalInsertedRows =  $total_insert_rows;

		}

		$this->msg = count($batchItemsQueueInsertData). " RECORDS INSERT SUCESSFULLY: ". $this->currentTime;
		return count($batchItemsQueueInsertData);/* return count all insert records */
	}


	public function get_email_template($template_type) {

		$template_data = array();

		if(empty($template_type)) {

			return $template_data;
		}

		$where_template_Condition = array( 'email_templates.status' => 1, 'email_target_point.target_point' => $template_type);
		$this->db->select('email_subject, email_body');
		$this->db->from('email_templates');
		$this->db->join("email_target_point","email_target_point.target_point_id = email_templates.target_point_id");
		$this->db->where($where_template_Condition);
		$template_data = $this->db->get()->row_array();

		return $template_data;

	}


	public function get_rule_details($rule_id) {

		$rule_data = array();

		if(empty($rule_id)) {

			return $rule_data;
		}

		$where_rule_Condition = array( 'hr_parameter.id' => $rule_id);
		$this->db->select('hr_parameter.salary_rule_name, performance_cycle.name');
		$this->db->from('hr_parameter');
		$this->db->join("performance_cycle","performance_cycle.id = hr_parameter.performance_cycle_id");
		$this->db->where($where_rule_Condition);
		$rule_data = $this->db->get()->row_array();

		return $rule_data;
	}


	public function get_user_details(array $user_list) {

		$user_data = array();

		if(empty($user_list)) {

			return $user_data;
		}

		$where_user_condition = array( 'login_user.status' => 1);
		$this->db->select('id AS user_id , name, other_data_20 AS email');
		$this->db->from('login_user');
		$this->db->where($where_user_condition);
		$this->db->where_in('login_user.id', $user_list);
		$this->db->order_by("login_user.id", "asc");
		$user_data = $this->db->get()->result_array();

		return $user_data;
	}


	public function update_admin_db($cronBatch) {

		$currentTime 			= $cronBatch->getBatchValue('currentTime');
		$adminDBEmailCreatedStatus 	= $cronBatch->getBatchValue('adminDBEmailCreatedStatus');
		$batchID 				= $cronBatch->getBatchValue('batchID');
		$companyID 				= $cronBatch->getBatchValue('companyID');
		$emailType 				= $cronBatch->getBatchValue('emailType');
		$totalInsertedRows		= $cronBatch->getBatchValue('totalInsertedRows');

		$where_condition = array('q_id' => $batchID,
								'compnay_id' => $companyID,
								'mail_stage' => $emailType
							);

		$data = array(
			'total' 	=> $totalInsertedRows,
			'status'  	=> $adminDBEmailCreatedStatus,
			'updatedon' => $currentTime
		);

		$this->db->where($where_condition);
		$rslt = $this->db->update($this->adminDBName . ".corn_job_queue", $data);

		return $rslt;
	}

	public function update_admin_db_by_qid($qid) {

		$currentTime 			= $this->currentTime;
		$adminDBEmailCreatedStatus 	= $this->adminDBEmailCreatedStatus;
		$totalInsertedRows		= $this->totalInsertedRows;

		$where_condition = array('q_id' => $qid);

		$data = array(
			'total' 	=> $totalInsertedRows,
			'status'  	=> $adminDBEmailCreatedStatus,
			'updatedon' => $currentTime
		);

		$this->db->where($where_condition);
		$rslt = $this->db->update($this->adminDBName . ".corn_job_queue", $data);

		return $rslt;
	}

	public function update_admin_db_inprocess($cronBatch) {

		$currentTime 			= $cronBatch->getBatchValue('currentTime');
		$adminDBEmailInProcessStatus 	= $cronBatch->getBatchValue('adminDBEmailInProcessStatus');
		$batchID 				= $cronBatch->getBatchValue('batchID');
		$companyID 				= $cronBatch->getBatchValue('companyID');
		$emailType 				= $cronBatch->getBatchValue('emailType');
		$totalInsertedRows		= 0;

		$where_condition = array('q_id' => $batchID,
								'compnay_id' => $companyID,
								'mail_stage' => $emailType
							);

		$data = array(
			'total' 	=> $totalInsertedRows,
			'status'  	=> $adminDBEmailInProcessStatus,
			'updatedon' => $currentTime
		);

		$this->db->where($where_condition);
		$rslt = $this->db->update($this->adminDBName . ".corn_job_queue", $data);

		return $rslt;
	}

	/*
	* send mail data to new employees NEW_EMPLOYEEE
	*/
	public function get_new_emp_data(array $result) {
		/**
		 * set Mail type
		 */
		$data_array = array();

		$this->emailType 	= NEW_EMPLOYEEE;
		/*
		* update admin status set inprocess
		*/
		$this->update_admin_db_inprocess($this);

		$result_data	= json_decode($result['json_text'], true);

		if(empty($result_data['user_list'])) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		$userselected_list	= explode(',',$result_data['user_list']);	

		if(empty($result_data['condtion'])) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		$where_rule_Condition = $result_data['condtion'];
		$this->db->select('id, email, name, approver_1, approver_2, approver_3, approver_4, manager_name');
		$this->db->from('login_user');
		$this->db->where($where_rule_Condition);
		$user_list = $this->db->get()->result();

		if(empty($user_list)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO USER FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		if(empty($result_data['manager_arr'])) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO MANAGER ARRAY FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		$newmanager_arr		= explode(',', $result_data['manager_arr']);
		$filter_useremail	= array();

		if(in_array('manager', $newmanager_arr)) {

			foreach ($user_list as $row) 
			{
				if(!in_array($row->manager_name, $userselected_list))
				{
					array_push($filter_useremail, $row->manager_name);
				}                                   
			}		
		}

		if(in_array('approver_1', $newmanager_arr)) {

			foreach ($user_list as $row) 
			{
				if(!in_array($row->approver_1, $userselected_list))
				{
					array_push($filter_useremail, $row->approver_1);
				}                               
			}
		}

		if(in_array('approver_2', $newmanager_arr)) {

			foreach ($user_list as $row) 
			{
				if(!in_array($row->approver_2, $userselected_list))
				{
				array_push($filter_useremail, $row->approver_2);
				}                                  
			}
		}

		if(in_array('approver_3', $newmanager_arr)) {

			foreach ($user_list as $row) 
			{
				if(!in_array($row->approver_3, $userselected_list))
				{
				array_push($filter_useremail, $row->approver_3);
				}              
			}
		}

		if(in_array('approver_4', $newmanager_arr)) {

			foreach ($user_list as $row) 
			{
				if(!in_array($row->approver_4, $userselected_list))
				{
					array_push($filter_useremail, $row->approver_4);
				}           
			}
		}

		if(in_array('employee', $newmanager_arr)) {

			foreach ($user_list as $row) 
			{
				if(!in_array($row->email, $userselected_list))
				{
					array_push($filter_useremail,$row->email);
				}                                     
			}
		}

		$final_emaillist	= array_unique(array_merge($userselected_list , $filter_useremail));

		$user_final_data = array();

		if(!empty($final_emaillist) && is_array($final_emaillist)) {

			$where_user_condition = array('login_user.status' => 1);
			$where_in_condition = $final_emaillist;
			$this->db->select( 'id, name, other_data_20 AS email');
			$this->db->from('login_user');
			$this->db->where($where_user_condition);
			$this->db->where_in('email', $where_in_condition);
			$this->db->order_by("login_user.id", "asc");
			$user_final_data = $this->db->get()->result_array();
			
		} else {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO USER LIST FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		if(!empty($user_final_data)) {

			/*
			* get email template
			*/
			$template_data = $this->get_email_template(NEW_EMPLOYEEE);

			foreach($user_final_data as $user_key => $user_data) {

				$password	= rand(99999999,999999);
				$str		= str_replace("{{employee_first_name}}", $user_data["name"] , $template_data['email_body']);
				$str		= str_replace("{{email_id_reciver}}", $user_data["email"] , $str);
				$str		= str_replace("{{url}}", $this->site_url, $str);
				$str		= str_replace("{{password}}", $password, $str);
				$mail_body	= $str;

				$data_array[$user_key]						= $user_data;
				$data_array[$user_key]['email_content'] 	= $mail_body;
				$data_array[$user_key]['email_subject'] 	= $template_data['email_subject'];

			}
		} else {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO USER FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;

		}

		return $data_array;
	}


	/*
	* send mail data for salary rule next level approver  SALARY_RULE_NEXT_LEVEL_APPROVER
	*/
	public function get_salary_rule_next_level_approver_data(array $result) {

		$data_array = array();
		/**
		 * set Mail type
		 */

		$this->emailType 	= SALARY_RULE_NEXT_LEVEL_APPROVER;
		/*
		* update admin status set inprocess
		*/
		$this->update_admin_db_inprocess($this);

		$result_data	= json_decode($result['json_text'], true);
		$plan_name		= $result_data['plan_name'];

		$user_list		= array();

		if(!empty($result_data['user_list'])) {

			$user_list	= json_decode($result_data['user_list'], true);
		}

		if(empty($user_list) || !is_array($user_list)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		$user_data = array();
		
		$where_user_condition = array( 'login_user.status' => 1);
		$this->db->select('id AS user_id , name, other_data_20 AS email');
		$this->db->from('login_user');
		$this->db->where($where_user_condition);
		$this->db->where_in('login_user.email', $user_list);
		$this->db->order_by("login_user.id", "asc");
		$user_data = $this->db->get()->result_array();

		if(empty($user_data)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		/*
		* get email template
		*/
		$template_data = $this->get_email_template(SALARY_RULE_NEXT_LEVEL_APPROVER);

		foreach($user_data as $key => $user_det) {

			$str	= str_replace("{{approvers_first_name}}", $user_det['name'], $template_data['email_body']);
			$str	= str_replace("{{plan_name}}", $plan_name, $str);
			$str	= str_replace("{{url}}", $this->site_url, $str);
			$str	= str_replace("{{email_id_reciver}}", $user_det["email"], $str);

			$mail_body	= $str;

			$data_array[$key] 					= $user_det;
			$data_array[$key]['email_content'] 	= $mail_body;
			$data_array[$key]['email_subject'] 	= $template_data['email_subject'];

		}

		return $data_array;
	}


	/*
	* send mail data for salary rule approve SALARY_RULE_APPROVE
	*/
	public function get_salary_rule_approve_data(array $result) {
		/**
		 * set Mail type
		 */
		$data_array = array();

		$this->emailType 	= SALARY_RULE_APPROVE;

		/*
		* update admin status set inprocess
		*/
		$this->update_admin_db_inprocess($this);

		$result_data	= json_decode($result['json_text'], true);
		$rule_id		= $result_data['rule_id'];

		if(empty($rule_id)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO RULE ID FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		$rule_data = $this->get_rule_details($rule_id);

		if(empty($rule_data)) { return $data_array; }

		$rule_name = $rule_data['name'];

		/**
		 * get approve data array
		 */
		$where_rule_Condition = array( 'employee_salary_details.rule_id' => $rule_id);
		$this->db->select('employee_salary_details.approver_1,login_user.name,login_user.id, login_user.other_data_20 AS email');
		$this->db->from('employee_salary_details');
		$this->db->join("login_user","login_user.email = employee_salary_details.approver_1");
		$this->db->where($where_rule_Condition);
		$this->db->group_by('employee_salary_details.approver_1');
		$approver_arr = $this->db->get()->result_array();

		if(empty($approver_arr)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		/*
		* get email template
		*/
		$template_data = $this->get_email_template(SALARY_RULE_APPROVE);

		foreach($approver_arr as $approver_key => $approver_val) {

			$password	= HLP_generateRandomStringPassword();
			$str		= str_replace("{{approvers_first_name}}", $approver_val["name"] , $template_data['email_body']);
			$str		= str_replace("{{plan_name}}", $rule_name , $str);
			$str		= str_replace("{{email_id_reciver}}", $approver_val["email"] , $str);
			$str		= str_replace("{{url}}", $this->site_url, $str);
			$str		= str_replace("{{password}}", $password, $str);
			$mail_body	= $str;

			$data_array[$approver_key]['user_id'] 			= $approver_val['id'];
			$data_array[$approver_key]['name'] 				= $approver_val['name'];
			$data_array[$approver_key]['email'] 			= $approver_val['email'];
			$data_array[$approver_key]['email_content'] 	= $mail_body;
			$data_array[$approver_key]['email_subject'] 	= $template_data['email_subject'];

		}

		return $data_array;

	}


	/*
	* send mail data for salary rule approve reminder SALARY_RULE_APPROVE_REMINDER
	*/
	public function get_salary_rule_approve_reminder_data(array $result) {

		/**
		 * set Mail type
		 */
		$data_array = array();

		$this->emailType 	= SALARY_RULE_APPROVE_REMINDER;

		/*
		* update admin status set inprocess
		*/
		$this->update_admin_db_inprocess($this);

		$result_data	= json_decode($result['json_text'], true);
		$rule_id		= $result_data['rule_id'];

		if(empty($rule_id)) { return $data_array; }

		$rule_data = $this->get_rule_details($rule_id);

		if(empty($rule_data)) { return $data_array; }

		$rule_name = $rule_data['name'];

		/**
		 * get approve data array
		 */
		$where_rule_Condition = array( 'employee_salary_details.rule_id' => $rule_id, 'employee_salary_details.status <' => 5, );//need to change cond
		$this->db->select('employee_salary_details.manager_emailid,login_user.name,login_user.id, login_user.other_data_20 AS email');
		$this->db->from('employee_salary_details');
		$this->db->join("login_user","login_user.email = employee_salary_details.manager_emailid");
		$this->db->where($where_rule_Condition);
		$this->db->group_by('employee_salary_details.manager_emailid');
		$approver_arr = $this->db->get()->result_array();

		if(empty($approver_arr)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		/*
		* get email template
		*/
		$template_data = $this->get_email_template(SALARY_RULE_APPROVE_REMINDER);

		foreach($approver_arr as $approver_key => $approver_val) {

			$str		= str_replace("{{approvers_first_name}}", $approver_val["name"] , $template_data['email_body']);
			$str		= str_replace("{{plan_name}}", $rule_name , $str);
			$str		= str_replace("{{email_id_reciver}}", $approver_val["email"] , $str);
			$str		= str_replace("{{url}}", $this->site_url, $str);
			$mail_body	= $str;

			$data_array[$approver_key]['user_id'] 			= $approver_val['id'];
			$data_array[$approver_key]['name'] 				= $approver_val['name'];
			$data_array[$approver_key]['email'] 			= $approver_val['email'];
			$data_array[$approver_key]['email_content'] 	= $mail_body;
			$data_array[$approver_key]['email_subject'] 	= $template_data['email_subject'];

		}

		return $data_array;

	}


	/*
	* send mail data for new salary rule relesed employee NEW_SALARY_RULE_RELESED_EMPLOYEE
	*/
	public function get_salary_rule_relesed_employee_data(array $result) {

		$data_array = array();
		/**
		 * set Mail type
		 */
		$this->emailType 	= NEW_SALARY_RULE_RELESED_EMPLOYEE;

		/*
		* update admin status set inprocess
		*/
		$this->update_admin_db_inprocess($this);

		$result_data	= json_decode($result['json_text'], true);
		$user_list		= $result_data['managers'];
		$rule_id		= $result_data['rule_id'];

		if(empty($user_list)) {

			/* If no row found for process then update admin DB for complete all process */
			$updateAdminDB = $this->update_admin_db($this);
			$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
			return $data_array;
		}

		if(!empty($user_list) && !empty($rule_id)){

			/*
			* get user data from login user & employee_salary_details table
			*/
			$where_user_condition = array('employee_salary_details.rule_id' => $rule_id, 'login_user.status' => 1, 'employee_salary_details.letter_status' => 3);
			$where_in_job_queue_condition = $user_list;
			$this->db->select( 'employee_salary_details.user_id, employee_salary_details.emp_name AS name, login_user.other_data_20 AS email');
			$this->db->from('employee_salary_details');
			$this->db->join("login_user","employee_salary_details.user_id = login_user.id");
			$this->db->where($where_user_condition);
			$this->db->where_in('employee_salary_details.approver_1', $where_in_job_queue_condition);
			$this->db->order_by("employee_salary_details.id", "asc");
			$user_data = $this->db->get()->result_array();

			if(empty($user_data)) {

				/* If no row found for process then update admin DB for complete all process */
				$updateAdminDB = $this->update_admin_db($this);
				$this->msg = "NO EMPLOYEE DATA FOUND FOR PROCESS : ". $this->currentTime;
				return $data_array;
			}

			/**
			 * get rule details
			 */
			$rule_data = $this->get_rule_details($rule_id);

			if(!empty($user_data) && !empty($rule_data)){

				/*
				* get email template
				*/
				$template_data = $this->get_email_template(NEW_SALARY_RULE_RELESED_EMPLOYEE);

				foreach($user_data as $key => $user_det) {

					$password	= HLP_generateRandomStringPassword();
					$str	= str_replace("{{employee_first_name}}", $user_det['name'], $template_data['email_body']);
					$str	= str_replace("{{url}}", $this->site_url, $str);
					$str	= str_replace("{{plan_name}}", $rule_data["name"], $str);
					$str	= str_replace("{{rule_name}}", $rule_data["salary_rule_name"], $str);
					$str	= str_replace("{{email_id_reciver}}", $user_det['email'], $str);
					$str	= str_replace("{{password}}", $password, $str);
					$mail_body	= $str;

					$data_array[$key] 					= $user_det;
					$data_array[$key]['email_content'] 	= $mail_body;
					$data_array[$key]['email_subject'] 	= $template_data['email_subject'];

				}
			}
		}

		return $data_array;

	}


	/*
	* send mail data for new salary rule relesed manager NEW_SALARY_RULE_RELESED_MANAGER
	*/
	public function get_salary_rule_relesed_manager_data(array $result) {

		$data_array = array();
		/**
		 * set Mail type
		 */
		$this->emailType 	= NEW_SALARY_RULE_RELESED_MANAGER;

		/*
		* update admin status set inprocess
		*/
		$this->update_admin_db_inprocess($this);

		$result_data	= json_decode($result['json_text'], true);
		$user_list		= $result_data['managers'];
		$rule_id		= $result_data['rule_id'];

		if(!empty($user_list) && !empty($rule_id)){

			/*
			* get user data from login user table
			*/
			$user_data = $this->get_user_details($user_list);

			if(empty($user_data)) {

				/* If no row found for process then update admin DB for complete all process */
				$updateAdminDB = $this->update_admin_db($this);
				$this->msg = "NO DATA FOUND FOR PROCESS: ". $this->currentTime;
				return $data_array;
			}

			/**
			 * get rule details
			 */
			$rule_data = $this->get_rule_details($rule_id);

			if(empty($rule_data)) {

				/* If no row found for process then update admin DB for complete all process */
				$updateAdminDB = $this->update_admin_db($this);
				$this->msg = "NO RULE DATA FOUND FOR PROCESS: ". $this->currentTime;
				return $data_array;
			}

			if(!empty($user_data) && !empty($rule_data)){

				/*
				* get email template
				*/
				$template_data = $this->get_email_template(NEW_SALARY_RULE_RELESED_MANAGER);

				foreach($user_data as $key => $user_det) {

					$str	= str_replace("{{employee_first_name}}", $user_det['name'], $template_data['email_body']);
					//$str	= str_replace("{{url}}", site_url(), $str);
					//$str	= str_replace("{{plan_name}}", $rule_data["name"], $str);
					$str	= str_replace("{{rule_name}}", $rule_data["salary_rule_name"], $str);

					$mail_body	= $str;

					$data_array[$key] 					= $user_det;
					$data_array[$key]['email_content'] 	= $mail_body;
					$data_array[$key]['email_subject'] 	= $template_data['email_subject'];

				}
			}
		}

		return $data_array;

	}


	/*
	* send mail data for genarate letter 	genarate_letter
	*/
	public function get_genarate_letter_data() {

	}

}
