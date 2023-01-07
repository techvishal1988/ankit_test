<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');

        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
        $this->load->model("upload_model");
        $this->load->model("user_model");
        $this->load->model('Mapping_model');
        $this->load->model("business_attribute_model");
        $this->load->model("rule_model");
        $this->load->model("common_model");
        $this->load->model("admin_model");
        if (!$this->session->userdata('userid_ses') or ! $this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or $this->session->userdata('role_ses') > 9) {
            redirect(site_url("dashboard"));
        }
        HLP_is_valid_web_token();
    }

    public function index($action)
	{

       if (!helper_have_rights(CV_UPLOAD_FILES_ID, CV_VIEW_RIGHT_NAME)) {
           $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></div>');
           redirect(site_url("no-rights"));
       }

       if (!helper_have_rights(CV_UPLOAD_FILES_ID, CV_INSERT_RIGHT_NAME)) {
           $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';
       }

        $data["msg"] = "";
        $data['body'] = "upload_file";
        $data['formaction'] = str_replace("_","-",$action);
        $data['actionpath'] = $action;

        if ($action == "bulk_delete") {
            $redirect_to            = "bulk-delete";
            $data['title']          = "Bulk Delete Records";
            $data['button_title']   = "Bulk Delete";
            $file_type_action       = 2;
            $data ['button_tooltip'] = "";
        }
        else if ($action == "bulk_active") {
            $redirect_to            = "bulk-active";
            $data['title']          = "Bulk Active Records";
            $data['button_title']   = "Activate Employees Record";
            $file_type_action       = 3;
            $data ['button_tooltip'] = "";
        }
        else if ($action == "bulk_inactive") {
            $redirect_to            = "bulk-inactive";
            $data['title']          = "Bulk Inactive Records";
            $data['button_title']   = "Inactivate Employees Record";
            $file_type_action       = 4;
            $data ['button_tooltip'] = "This step will inactivate your users and they will not be included in all the functionalities including rule design, analytics etc.";
        }
        else {
            // case of bulk_insert
            $redirect_to              = "upload-data";
            $data['title']            = "Uploaded Files";
            $file_type_action         = 1;
            $redirect_to              = "upload-data";
            $data['title']            = "Upload Data";
            $data['button_title']     = "Upload";
            $data ['button_tooltip']  = "";

        }

        $business_attribute_list = $this->business_attribute_model->get_business_attributes(array("status" => 1));
        $email_ba_is_active_with_required = $this->business_attribute_model->get_business_attributes(array("status" => 1, 'is_required' => 1, "module_name" => CV_EMAIL_MODULE_NAME));

        if ($_FILES) {
            if (!helper_have_rights(CV_UPLOAD_FILES_ID, CV_INSERT_RIGHT_NAME)) {
                //$this->session->set_flashdata('message', "<div align='left' style='color:red;' id='notify'><span><b>You don't have insert rights.</b></span></div>");
                redirect(site_url($redirect_to));
            }

            if (!helper_have_rights(CV_UPLOAD_FILES_ID, CV_UPDATE_RIGHT_NAME)) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></span></div>');
                redirect(site_url($redirect_to));
            }


            if (!$business_attribute_list or ! $email_ba_is_active_with_required) {
                redirect(site_url($redirect_to));
            }


            $user_id = $this->session->userdata("userid_ses");
            $user_email = $this->session->userdata("email_ses");
            $currentDateTime = date("Y-m-d H:i:s");
            $file_type = explode('.', $_FILES['myfile']['name']);
            //if(($_FILES['myfile']['type'] == 'text/csv' or $_FILES['myfile']['type'] == 'text/comma-separated-values' or $_FILES['myfile']['type'] == 'application/vnd.ms-excel') and $file_type[1] == 'csv')
            if ($file_type[1] == 'csv') {
                /* // Performance Testing By Ravi
                  $this->load->model('admin_model');
                  $this->admin_model->insert_data_in_tbl("tbl_audit_log", array("process"=>"File Upload", "step"=>"Start", "created_on"=>date("Y-m-d H:i:s"))); */
				
				$scan_file_result = HL_scan_uploaded_file($_FILES['myfile']['name'],$_FILES['myfile']['tmp_name']);
				if($scan_file_result === true)
				{
					$uploaded_file_name = $_FILES['myfile']['name'];
					$fName = time() . "." . $file_type[1]; //$_FILES["myfile"]["name"];
					$dd = move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/" . $fName);
				
					// Name of your CSV file
					$csv_file = base_url() . "uploads/" . $fName;
					if (($handle = fopen($csv_file, "r")) !== FALSE) {
	
						$file_data = file_get_contents("uploads/" . $fName);
						//$new_file_name =  "uploads/" . "UTF-8-Windows-1252".$fName;
						//$file_data = mb_convert_encoding($file_data,"UTF-8", "Windows-1252");
						$file_data= iconv( "UTF-8",  'ISO-8859-1//TRANSLIT//IGNORE',  $file_data);
						file_put_contents("uploads/" . $fName , $file_data );
						
						$header = fgetcsv($handle, ","); //Get header only from uploaded file
						$total_column = count($header);
						$upload_db_arr = array(
							"original_file_name" => $fName,
							"uploaded_file_name" => $uploaded_file_name,
							"upload_date" => $currentDateTime,
							"uploaded_by_user_id" => $user_id,
							"file_type" => $file_type_action,
							"createdby_proxy" => $this->session->userdata("proxy_userid_ses"));
	
						if (($action == "bulk_delete") || ($action == "bulk_active") || ($action == "bulk_inactive")) {
						  $upload_db_arr["status"] = 0;
						}
	
						$upload_id = $this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
	
						/* // Performance Testing By Ravi
						  $this->admin_model->insert_data_in_tbl("tbl_audit_log", array("process"=>"File Upload", "step"=>"End", "upload_id"=>$upload_id, "created_on"=>date("Y-m-d H:i:s"))); */
	
						if ($action == "bulk_delete") {
						  $this->bulk_options($upload_id, 2, $redirect_to);
						}
						else if ($action == "bulk_active") {
						  $this->bulk_options($upload_id, 1, $redirect_to);
						}
						else if ($action == "bulk_inactive") {
						  $this->bulk_options($upload_id, 0, $redirect_to);
						}
						else {
						  // case of bulk_upload
						  redirect(site_url("mapping-head/" . $upload_id));
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>File not readable. Please try again.</b></div>');
					}
				}
				else
				{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
            }
            redirect(site_url($redirect_to));
        }

        if (!$business_attribute_list) {
            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Before uplaod any file, you must have active business attributes.</b></div>';
        } elseif (!$email_ba_is_active_with_required) {
            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Email id should be set as mandatory attribute on "Business Attribute" screen.</b></div>';
        }

        $data["uploaded_file_list"] = $this->upload_model->get_uploaded_file_list(array("data_upload.uploaded_by_user_id" => $this->session->userdata("userid_ses"), "data_upload.status >" => 0, "data_upload.original_file_name !=" => CV_DEFAULT_FILE_NAME, "file_type" => $file_type_action));

        $this->load->model("admin_model");
        $data['company_dtls'] = $this->admin_model->get_table_row("manage_company", "*", array("id" => $this->session->userdata('companyid_ses')));
        // $data['title'] = "Uploaded Files";
        // $data['body'] = "upload_file";
        $this->load->view('common/structure', $data);
    }

    public function bulk_options($upload_id, $status, $redirect_to) {

     if( $status==2 && !helper_have_rights(CV_STAFF_ID, CV_DELETE_RIGHT_NAME)) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_delete_right') . '</b></div>');
          redirect(site_url($redirect_to));
      } else if ( !helper_have_rights(CV_STAFF_ID, CV_UPDATE_RIGHT_NAME)) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_edit_right') . '</b></div>');
          redirect(site_url($redirect_to));
      }

     $users=[];
     $overall_success = TRUE;
     $rec_count = 0;
     $uploaded_file_dtl = $this->upload_model->get_uploaded_file_dtls($upload_id);
     $csv_file = base_url() . "uploads/" . $uploaded_file_dtl["original_file_name"];

     if (($handle = fopen($csv_file, "r")) !== FALSE) {
      $handle1 = fopen($csv_file, "r");
      $sheet_head = fgetcsv($handle1);
      $sheet_head[] = "Remark";
      $error_arr = array($sheet_head);

      // validating records.
      while (($email_records = fgetcsv($handle1)) !== FALSE) {
       //get_user_id_by_email
       $user_id = $this->user_model->get_user_id_by_email($email_records[0]);

       if(!$user_id) {
        $overall_success = FALSE;
        $email_records[] = "No Record Found";
       }
       elseif($this->user_model->check_rights_conflicts($user_id) && $status==1)
       {
         $overall_success = FALSE;
         $email_records[] = "Conflict Right Issue";

       }
       else{
        $users[$user_id]=$email_records[0];
       }
       $error_arr[] = $email_records;
      }

      if (! $overall_success) {
       $this->session->set_userdata(array("errors_file_data" => $error_arr));
       $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data may be incorrect or not exist in file. Try again!</b></div>');
       redirect(site_url($redirect_to));
      }

      fclose($handle1);

      //set data
      $overall_success = TRUE;
      $error_arr=[] ;
     foreach ($users as $user_id => $email) {
       $response = $this->user_model->update_status($user_id, $status);
       if(isset($response["error_msg"]) && !empty($response["error_msg"])) {
        $overall_success = FALSE;
        $error_arr[] = [$email,$response["error_msg"]];
       }
       else {
        $rec_count++;
       }
      }
      if ($overall_success && ($rec_count > 0)) {
       $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 2));
       $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data uploaded successfully.</b></div>');
      }
      else {
       $this->session->set_userdata(array("errors_file_data" => $error_arr));
       $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 3));
       $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>No data uploaded, data may be incorrect or not exist in file. Try again!</b></div>');
      }

      fclose($handle);
     }
     redirect(site_url($redirect_to));
    }




    public function mapping_headers($upload_id = 0) {
        $data["msg"] = "";
        if (!helper_have_rights(CV_MAPPING_HEADERS_ID, CV_VIEW_RIGHT_NAME)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have view rights.</b></span></div>');
            redirect(site_url("no-rights"));
        }

        if (!helper_have_rights(CV_MAPPING_HEADERS_ID, CV_INSERT_RIGHT_NAME)) {
            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have insert rights.</b></div>';
        }

		$default_mapping_id = 1;//Used Default Mapping in case of Single Benchmark 
        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
        if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
		{
            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
			$default_mapping_id = 2;//Used Default Mapping in case of Multiple Benchmark 
        }

        $data['savedMapping'] = '';
        if($this->input->post('selectedMapping') && ($this->input->post('selectedMapping') != ''))
		{
            $data['savedMapping'] = $this->Mapping_model->getMapping(array('id' => $this->input->post('selectedMapping')));
        }
		else
		{
			//$data['savedMapping'] = $this->Mapping_model->getMapping(array('id' => $default_mapping_id));
		}
		
        $uploaded_file_dtl = $this->upload_model->get_uploaded_file_dtls($upload_id);
        $csv_file = base_url() . "uploads/" . $uploaded_file_dtl["original_file_name"];
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            $data['header_list'] = fgetcsv($handle, ","); //Get header only from uploaded file
            //$this->load->model("business_attribute_model");
            // $data['business_attribute_list'] = $this->business_attribute_model->get_business_attributes(array("status" => 1, "module_name !=" => $ba_not_for));
            $condition_arr = "business_attribute.module_name NOT IN ('".CV_MARKET_SALARY_ELEMENT."','".$ba_not_for."') AND business_attribute.status = ".CV_STATUS_ACTIVE;
            $data['business_attribute_list'] = $this->business_attribute_model->get_business_attributes($condition_arr);
            //echo "<pre>";print_r($data['business_attribute_list']);die;
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>File not in readable.</b></div>');
            redirect(site_url("upload-data"));
        }

        $data['upload_id'] = $upload_id;
        $data['title'] = "Mapping Headers";
        $data['body'] = "mapping_headers";
        $this->load->view('common/structure', $data);
    }

    public function download_error_file()
	{
        /*if (count($this->session->userdata('errors_file_data_new')) > 0) {
            downloadcsv($this->session->userdata('errors_file_data_new'), "employees-data-error-file.csv");
        }
        else {
            redirect(site_url("upload-data"));
        }*/
		$error_dtls = $this->session->userdata('errors_file_data_new');
		if (count($error_dtls) > 0)
		{
			$error_data = $this->rule_model->get_table($error_dtls["tmp_tbl_name"], $error_dtls["tbl_colmn_str"], "is_error = 1", "id ASC");
			$error_arr = array_merge($error_dtls["error_sheet_header"], $error_data);
            downloadcsv($error_arr, "employees-data-error-file.csv");
        }
        else
		{
            redirect(site_url("upload-data"));
        }
    }

    public function insert_headers() {
        if (!helper_have_rights(CV_MAPPING_HEADERS_ID, CV_INSERT_RIGHT_NAME)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have mapping insert rights.</b></div>');
            echo false;
            die;
        }

        $upload_id = $this->input->post('hf_upload_id');
        $uploaded_file_dtl = $this->upload_model->get_uploaded_file_dtls($upload_id);
        $csv_file = base_url() . "uploads/" . $uploaded_file_dtl["original_file_name"];

        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            $handle1 = fopen($csv_file, "r");
            $sheet_head = fgetcsv($handle1);
            $sheet_head[] = "Remark";
            $sheet_head[] = "Error Field";
            $error_arr = array($sheet_head);

            $req_ba_list = $this->upload_model->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(id)) AS ba_ids, (select GROUP_CONCAT(CONCAT(id)) FROM `business_attribute` WHERE `data_type_code`='NUMERIC') AS numeric_ba_ids", array("status" => 1, 'is_required' => 1));
            $required_ba_ids_arr = explode(",", $req_ba_list["ba_ids"]);
            $numeric_ba_ids_arr = explode(",", $req_ba_list["numeric_ba_ids"]);
            $master_ba_ids_arr = array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_EDUCATION, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_BA_ID_SPECIAL_CATEGORY, CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID, CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, CV_CURRENCY_ID, CV_SUB_SUB_FUNCTION_ID, CV_BA_ID_RATING_FOR_2ND_LAST_YEAR, CV_BA_ID_RATING_FOR_3RD_LAST_YEAR, CV_BA_ID_RATING_FOR_4TH_LAST_YEAR, CV_BA_ID_RATING_FOR_5TH_LAST_YEAR, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE);

// print_r($sheet_head);

            $temp_tbl_fields = $field_from_csv_arr = $field_from_temp_arr = $master_fields_arr = $required_fields_arr = $numeric_fields_arr = $mapped_ba_ids_arr = $mapp_data = array();
			$fields_arr = array();

            for ($i = 0; $i < count($_REQUEST['ddl_mapping']); $i++) {
                if ($_REQUEST['ddl_mapping'][$i] != 'N/A') {
                    $mapped_arr = explode(CV_CONCATENATE_SYNTAX, $_REQUEST['ddl_mapping'][$i]);
                    $mapp_data[$i] = $_REQUEST['ddl_mapping'][$i];
                    $temp_tbl_fields[$mapped_arr[1]] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
                    $mapped_ba_id = $mapped_arr[0];
                    $col_name = $mapped_arr[1];
                    $mapped_ba_ids_arr[] = $mapped_ba_id;

                    $field_from_csv_arr[] = $col_name;

					               $fields_arr[] = array(
                        'id' => $mapped_ba_id,
                        'display_name' => $sheet_head[$i]
                    );

                    if (in_array($mapped_ba_id, $master_ba_ids_arr)) {
                        $master_fields_arr[] = $col_name;
                    } else {
                        $field_from_temp_arr[] = $col_name;
                    }

                    if (in_array($mapped_ba_id, $required_ba_ids_arr)) {
                        $required_fields_arr[] = $col_name;
                    }
                    if (in_array($mapped_ba_id, $numeric_ba_ids_arr)) {
                        $numeric_fields_arr[] = $col_name;
                    }
                } else {
                    $temp_tbl_fields["NIU_" . $i] = array('type' => 'tinyint', 'constraint' => '1', 'null' => TRUE);
                    $field_from_csv_arr[] = "NIU_" . $i;
                }
            }
// echo '<pre>';
// print_r($field_from_csv_arr);
// die;
           if (isset($_REQUEST['saveMapping'])&&$_REQUEST['mappingName']!='')
           {
                $mappingDetails['title'] = $_REQUEST['mappingName'];
                $mappingDetails['mapp_data'] = json_encode($mapp_data);
                $mappingDetails['upload_id'] = $upload_id;
                $mappingDetails['mapping_for_benchmark'] = $this->session->userdata('market_data_by_ses');
                $mappingDetails['created_by'] = $this->session->userdata("userid_ses");
                $mappingDetails['createdby_proxy'] = $this->session->userdata("proxy_userid_ses");
                $mappingDetails["created_on"] = date("Y-m-d H:i:s");
                $this->Mapping_model->insertMappedDetails($mappingDetails);
            }
// echo '<pre>';
// print_r($temp_tbl_fields);
// die;
            $this->upload_model->create_upload_temp_table("temp_upload_data_" . $upload_id, $temp_tbl_fields);
            // die;
            $response = $this->upload_model->insert_data_in_tmp_tbl("temp_upload_data_" . $upload_id, implode(",", $field_from_csv_arr), $csv_file, $upload_id, $mapped_ba_ids_arr, $required_fields_arr, $numeric_fields_arr, implode(",", $field_from_temp_arr), $master_fields_arr);

            if($response["error_data"]["error_cnts"] > 0)
			{
                //$error_arr = array_merge($error_arr, $response["error_data"]);
				//$this->session->set_userdata(array("errors_file_data" => $error_arr));
				$response["error_data"]["error_sheet_header"] = $error_arr;
                $this->session->set_userdata(array("errors_file_data" => $response["error_data"]));
            }

            if ($response["new_users_cnts"] > 0) {

                $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 2, "is_manager_role_updated"=>2));
				$this->upload_model->update_business_attribute_ba_display_name_by_uploaded_data($fields_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data uploaded successfully.</b></div>');
            } else {
                $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 3));
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>No data uploaded, may data incorrect or not exist. Try again!</b></div>');
            }
        }
        redirect(site_url("upload-data"));
    }

	public function set_role_for_managers($upload_id)
	{
        $uploaded_file_dtls = $this->admin_model->get_table_row("data_upload", "id, uploaded_file_name, (SELECT ".CV_BA_NAME_EMP_FULL_NAME." FROM login_user WHERE login_user.id = data_upload.uploaded_by_user_id) AS owner_name, (SELECT ".CV_BA_NAME_EMP_EMAIL." FROM login_user WHERE login_user.id = data_upload.uploaded_by_user_id) AS owner_email", array("id"=>$upload_id, "status"=>2, "is_manager_role_updated"=>2, "id DESC"));

        if($uploaded_file_dtls)
		{
            ############ Get SMTP DEtails FOR Sending Mail #############

            $email_config=HLP_GetSMTP_Details();

            #############################################################

			$users_list = $this->admin_model->get_table("login_user", "id,approver_1,approver_2,approver_3,approver_4", array("upload_id" => $upload_id));

			foreach($users_list as $user)
			{
				$manager_emails_arr = array();
				if(trim($user['approver_1']))
				{
					$manager_emails_arr[] = "'".$user['approver_1']."'";
				}
				if(trim($user['approver_2']))
				{
					$manager_emails_arr[] = "'".$user['approver_2']."'";
				}
				if(trim($user['approver_3']))
				{
					$manager_emails_arr[] = "'".$user['approver_3']."'";
				}
				if(trim($user['approver_4']))
				{
					$manager_emails_arr[] = "'".$user['approver_4']."'";
				}
				if($manager_emails_arr)
				{
					$this->upload_model->set_role_for_managers($manager_emails_arr);
				}
			}
            $emailTemplate=$this->common_model->getEmailTemplate("managerCreated");
			$filename = $uploaded_file_dtls['uploaded_file_name'];
			$this->admin_model->update_tbl_data("data_upload", array("is_manager_role_updated" =>1), array("id" => $upload_id));
            $str=str_replace("{{manager_name}}",strtoupper($uploaded_file_dtls['owner_name']), $emailTemplate[0]->email_body);

            $mail_body=$str;

            $mail_sub =  $emailTemplate[0]->email_subject;

			//$this->common_model->send_emails(CV_EMAIL_FROM, $uploaded_file_dtls['owner_email'], $mail_sub, $mail_body);

            $this->common_model->send_emails($email_config['email_from'], $uploaded_file_dtls['owner_email'], $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
        }
    }

    public function savedMappings($uploadId = 0)
	{
        $data['title'] = "Mapping Headers";
        $data['body'] = "saved_mappings";
        $data['upload_id'] = $uploadId;

        // code for update the default Mapping as "ba_attributes_order" order asc
        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
        }
        //$condition_arr["business_attribute.module_name !="] = $ba_not_for;
        //$condition_arr["business_attribute.status"] = CV_STATUS_ACTIVE;
        $condition_arr = "business_attribute.module_name NOT IN ('".CV_MARKET_SALARY_ELEMENT."','".$ba_not_for."') AND business_attribute.status = ".CV_STATUS_ACTIVE;
        $ba_display_name = $this->business_attribute_model->get_ba_display_name($condition_arr);
        foreach ($ba_display_name as $val) {
            $mapp_data[] = $val['id'] . CV_CONCATENATE_SYNTAX . $val['ba_name'];
        }
        $mappingDetails['mapp_data'] = json_encode($mapp_data);
        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
            $this->Mapping_model->UpdateMappedDetails($mappingDetails, array('id' => 2, 'mapping_for_benchmark' => CV_MARKET_SALARY_CTC_ELEMENT));
        } else {
            $this->Mapping_model->UpdateMappedDetails($mappingDetails, array('id' => 1, 'mapping_for_benchmark' => CV_MARKET_SALARY_ELEMENT));
        }

        $data['mappings'] = $this->Mapping_model->getMapping(array('mapping_for_benchmark' => $this->session->userdata('market_data_by_ses')));
        if (!$data['mappings']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Old mapping not available.</b></div>');
            redirect(site_url("mapping-head/" . $uploadId));
        }
        $this->load->view('common/structure', $data);
    }

    public function download_sample($action)
	{
        $condition_arr = array();
        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
        $csv_file = "employees-data-file-format.csv";

        if (($action == "bulk_delete") || ($action == "bulk_active") || ($action == "bulk_inactive")) {

	         $csv_file = str_replace("_","-","{$action}-employees-data-file-format.csv");

          header('Content-Type: text/csv');
          header('Content-Disposition: attachment; filename="' . $csv_file . '"');
          $fp = fopen('php://output', 'wb');
          $titlearr[0] = "Email ID";
          fputcsv($fp, $titlearr);
          fclose($fp);
        }
        else {
        $csv_file = "default_single_benchmark.csv";
        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
            $csv_file = "employees-data-file-format.csv";//"default_multiple_benchmark.csv";
        }

        //$condition_arr["business_attribute.module_name !="] = $ba_not_for;
        //$condition_arr["business_attribute.status"] = CV_STATUS_ACTIVE;
        $condition_arr = "business_attribute.module_name NOT IN ('".CV_MARKET_SALARY_ELEMENT."','".$ba_not_for."') AND business_attribute.status = ".CV_STATUS_ACTIVE;
        $ba_display_name = $this->business_attribute_model->get_ba_display_name($condition_arr);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $csv_file . '"');

        $fp = fopen('php://output', 'wb');
        foreach ($ba_display_name as $val) {
            $titlearr[] = $val['display_name'];
        }
        fputcsv($fp, $titlearr);
        fclose($fp);
    }
}
// new code for filter user and send email by rahul singh

public function email_filter($ruleId='')
    {
        if($ruleId=='')
        {
            redirect(site_url("upload-data"));
        }
    $user_id = $this->session->userdata('userid_ses');
     $country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$user_id), "manage_country");

        $city_arr_view =  $this->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$user_id),"manage_city");
        $bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_1");
        $bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_2");
        $bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$user_id), "manage_business_level_3");

        $designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$user_id), "manage_designation");
        $function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$user_id), "manage_function");
        $sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$user_id), "manage_subfunction");
        $sub_subfunction_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_subfunctions","sub_subfunction_id", array("status"=>1, "user_id"=>$user_id), "manage_sub_subfunction");
        $grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$user_id), "manage_grade");
        $level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$user_id), "manage_level");


        $data['education_list'] = $this->rule_model->get_table("manage_education","id, name", "status = 1", "name asc");
        $data['critical_talent_list'] = $this->rule_model->get_table("manage_critical_talent","id, name", "status = 1", "name asc");
        $data['critical_position_list'] = $this->rule_model->get_table("manage_critical_position","id, name", "status = 1", "name asc");
        $data['special_category_list'] = $this->rule_model->get_table("manage_special_category","id, name", "status = 1", "name asc");

        if($country_arr_view)
        {
            $data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1 and id in (".$country_arr_view.")", "name asc");
        }
        else
        {
            $data['country_list'] = $this->rule_model->get_table("manage_country","id, name", "status = 1", "name asc");
        }

        if($city_arr_view)
        {
            $data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1 and id in (".$city_arr_view.")", "name asc");
        }
        else
        {
            $data['city_list'] = $this->rule_model->get_table("manage_city","id, name", "status = 1", "name asc");
        }

        if($bl1_arr_view)
        {
            $data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1 and id in(".$bl1_arr_view.")", "name asc");
        }
        else
        {
            $data['bussiness_level_1_list'] = $this->rule_model->get_table("manage_business_level_1","id, name", "status = 1", "name asc");
        }

        if($bl2_arr_view)
        {
            $data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1 and id in(".$bl2_arr_view.")", "name asc");
        }
        else
        {
            $data['bussiness_level_2_list'] = $this->rule_model->get_table("manage_business_level_2","id, name", "status = 1", "name asc");
        }

        if($bl3_arr_view)
        {
            $data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1 and id in(".$bl3_arr_view.")", "name asc");
        }
        else
        {
            $data['bussiness_level_3_list'] = $this->rule_model->get_table("manage_business_level_3","id, name", "status = 1", "name asc");
        }

        if($designation_arr_view)
        {
            $data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1 and id in(".$designation_arr_view.")", "name asc");
        }
        else
        {
            $data['designation_list'] = $this->rule_model->get_table("manage_designation","id, name", "status = 1", "name asc");
        }

        if($function_arr_view)
        {
            $data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1 and id in(".$function_arr_view.")", "name asc");
        }
        else
        {
            $data['function_list'] = $this->rule_model->get_table("manage_function","id, name", "status = 1", "name asc");
        }

        if($sub_function_arr_view)
        {
            $data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1 and id in(".$sub_function_arr_view.")", "name asc");
        }
        else
        {
            $data['sub_function_list'] = $this->rule_model->get_table("manage_subfunction","id, name", "status = 1", "name asc");
        }

        if($sub_subfunction_arr_view)
        {
            $data['sub_subfunction_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1 AND id IN(".$sub_subfunction_arr_view.")", "name asc");
        }
        else
        {
            $data['sub_subfunction_list'] = $this->rule_model->get_table("manage_sub_subfunction","id, name", "status = 1", "name asc");
        }

        if($grade_arr_view)
        {
            $data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1 and id in(".$grade_arr_view.")", "name asc");
        }
        else
        {
            $data['grade_list'] = $this->rule_model->get_table("manage_grade","id, name", "status = 1", "name asc");
        }

        if($level_arr_view)
        {
            $data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1 and id in(".$level_arr_view.")", "name asc");
        }
        else
        {
            $data['level_list'] = $this->rule_model->get_table("manage_level","id, name", "status = 1", "name asc");
        }
        $data['employee_list']=$this->common_model->get_table('login_user','id,email,name,approver_1,approver_2,approver_3,approver_4', ['status'=>1]);
        $data['tooltip'] = getToolTip('salary-rule-filter');
        $result=$this->common_model->getEmailTemplate(NEW_EMPLOYEEE);
        $data['title'] = "Email Filters";
        $data['email_template'] = $result[0]->email_body;
        $data['ruleid'] = $ruleId;
        $data['body'] = "email_filters.php";
        $this->load->view('common/structure',$data);


    }

function getEmailTemplate()
{

    if(!$this->input->post("hf_select_all_filters"))
    {
    if(in_array('both', $this->input->post("survey_for")))
    {
    $manager_arr ='both';
    }
    else
    {
    $manager_arr = implode(",",$this->input->post("survey_for"));
    }

    if(in_array('all', $this->input->post("ddl_country")))
    {
    $country_arr =$country_arr_view;
    }
    else
    {
    $country_arr = implode(",",$this->input->post("ddl_country"));
    }

    if(in_array('all', $this->input->post("ddl_city")))
    {
    $city_arr = $city_arr_view;
    }
    else
    {
    $city_arr = implode(",",$this->input->post("ddl_city"));
    }

    if(in_array('all', $this->input->post("ddl_bussiness_level_1")))
    {
    $bussiness_level_1_arr = $bl1_arr_view;
    }
    else
    {
    $bussiness_level_1_arr=implode(",",$this->input->post("ddl_bussiness_level_1"));
    }

    if(in_array('all', $this->input->post("ddl_bussiness_level_2")))
    {
    $bussiness_level_2_arr = $bl2_arr_view;
    }
    else
    {
    $bussiness_level_2_arr=implode(",",$this->input->post("ddl_bussiness_level_2"));
    }

    if(in_array('all', $this->input->post("ddl_bussiness_level_3")))
    {
    $bussiness_level_3_arr = $bl3_arr_view;
    }
    else
    {
    $bussiness_level_3_arr=implode(",",$this->input->post("ddl_bussiness_level_3"));
    }

    if(in_array('all', $this->input->post("ddl_function")))
    {
    $function_arr = $function_arr_view;
    }
    else
    {
    $function_arr = implode(",",$this->input->post("ddl_function"));
    }

    if(in_array('all', $this->input->post("ddl_sub_function")))
    {
    $sub_function_arr = $sub_function_arr_view;
    }
    else
    {
    $sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
    }

    if(in_array('all', $this->input->post("ddl_sub_subfunction")))
    {
    $sub_subfunction_arr = $sub_subfunction_arr_view;
    }
    else
    {
    $sub_subfunction_arr = implode(",",$this->input->post("ddl_sub_subfunction"));
    }

    if(in_array('all', $this->input->post("ddl_designation")))
    {
    $designation_arr = $designation_arr_view;
    }
    else
    {
    $designation_arr = implode(",",$this->input->post("ddl_designation"));
    }

    if(in_array('all', $this->input->post("ddl_grade")))
    {
    $grade_arr = $grade_arr_view;
    }
    else
    {
    $grade_arr = implode(",",$this->input->post("ddl_grade"));
    }

    if(in_array('all', $this->input->post("ddl_level")))
    {
    $level_arr = $level_arr_view;
    }
    else
    {
    $level_arr = implode(",",$this->input->post("ddl_level"));
    }

    if(in_array('all', $this->input->post("ddl_education")))
    {
    $temp_arr = array();
    $education_arr = "";
    foreach($data['education_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $education_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $education_arr = implode(",",$this->input->post("ddl_education"));
    }

    if(in_array('all', $this->input->post("ddl_critical_talent")))
    {
    $temp_arr = array();
    $critical_talent_arr = "";
    foreach($data['critical_talent_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $critical_talent_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $critical_talent_arr = implode(",",$this->input->post("ddl_critical_talent"));
    }

    if(in_array('all', $this->input->post("ddl_critical_position")))
    {
    $temp_arr = array();
    $critical_position_arr = "";
    foreach($data['critical_position_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $critical_position_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $critical_position_arr = implode(",",$this->input->post("ddl_critical_position"));
    }

    if(in_array('all', $this->input->post("ddl_special_category")))
    {
    $temp_arr = array();
    $special_category_arr = "";
    foreach($data['special_category_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $special_category_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $special_category_arr = implode(",",$this->input->post("ddl_special_category"));
    }

    if(in_array('all', $this->input->post("ddl_tenure_company")))
    {
    $temp_arr = array();
    for($i=0; $i<=CV_DEFAULT_MAX_TENURE; $i++)
    {
        array_push($temp_arr,$i);
    }
    if($temp_arr)
    {
        $tenure_company_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $tenure_company_arr = implode(",",$this->input->post("ddl_tenure_company"));
    }

    if(in_array('all', $this->input->post("ddl_tenure_role")))
    {
    $temp_arr = array();
    for($i=0; $i<=CV_DEFAULT_MAX_TENURE; $i++)
    {
        array_push($temp_arr,$i);
    }
    if($temp_arr)
    {
        $tenure_role_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $tenure_role_arr = implode(",",$this->input->post("ddl_tenure_role"));
    }

    $emailTemplate=$this->common_model->getEmailTemplate(NEW_EMPLOYEEE);
   $upload_id=$this->input->post("upload_id");
    $conditions=' upload_id='.$upload_id.' and id!='.$this->session->userdata('userid_ses');
if(!empty($country_arr))
{
  $conditions.=' and country IN ('.$country_arr.')';
}

if(!empty($city_arr))
{
  $conditions.=' and city IN ('.$city_arr.')';
}
if(!empty($bussiness_level_1_arr))
{
  $conditions.=' and business_level_1 IN ('.$bussiness_level_1_arr.')';
}
if(!empty($bussiness_level_2_arr))
{
  $conditions.=' and business_level_2 IN ('.$bussiness_level_2_arr.')';
}
if(!empty($bussiness_level_3_arr))
{
  $conditions.=' and business_level_3 IN ('.$bussiness_level_3_arr.')';
}
if(!empty($function_arr))
{
  $conditions.=' and function IN ('.$function_arr.')';
}
if(!empty($sub_function_arr))
{
  $conditions.=' and subfunction IN ('.$sub_function_arr.')';
}

if(!empty($designation_arr))
{
  $conditions.=' and designation IN ('.$designation_arr.')';
}

if(!empty($grade_arr))
{
  $conditions.=' and grade IN ('.$grade_arr.')';
}
if(!empty($level_arr))
{
  $conditions.=' and level IN ('.$level_arr.')';
}
if(!empty($special_category_arr))
{
  $conditions.=' and special_category IN ('.$special_category_arr.')';
}
if(!empty($sub_subfunction_arr))
{
  $conditions.=' and sub_subfunction IN ('.$sub_subfunction_arr.')';
}


$userselected_list=explode(',',$this->input->post("user_list"));

 $user_list=getSingleTableData('login_user',$conditions,'id,email,name,approver_1,approver_2,approver_3,approver_4,manager_name');
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

 $email_config=HLP_GetSMTP_Details();

#############################################################

$final_emaillist=array_unique(array_merge($userselected_list,$filter_useremail));
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

 $this->common_model->send_emails($email_config['email_from'], $final_emaillist[$i], $emailTemplate[0]->email_subject, $mail_body,$email_config['result'],$email_config['mail_fromname']);

}

}
$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Mail Sent Successfully.</b></div>');
redirect(base_url('upload-data'));
}

public function SetEmailIntoQueue()
{
    // print_r($_POST);
    // exit;

    if(in_array('both', $this->input->post("survey_for")))
    {
    $manager_arr ='both';
    }
    else
    {
    $manager_arr = implode(",",$this->input->post("survey_for"));
    }

    if(in_array('all', $this->input->post("ddl_country")))
    {
    $country_arr =$country_arr_view;
    }
    else
    {
    $country_arr = implode(",",$this->input->post("ddl_country"));
    }

    if(in_array('all', $this->input->post("ddl_city")))
    {
    $city_arr = $city_arr_view;
    }
    else
    {
    $city_arr = implode(",",$this->input->post("ddl_city"));
    }

    if(in_array('all', $this->input->post("ddl_bussiness_level_1")))
    {
    $bussiness_level_1_arr = $bl1_arr_view;
    }
    else
    {
    $bussiness_level_1_arr=implode(",",$this->input->post("ddl_bussiness_level_1"));
    }

    if(in_array('all', $this->input->post("ddl_bussiness_level_2")))
    {
    $bussiness_level_2_arr = $bl2_arr_view;
    }
    else
    {
    $bussiness_level_2_arr=implode(",",$this->input->post("ddl_bussiness_level_2"));
    }

    if(in_array('all', $this->input->post("ddl_bussiness_level_3")))
    {
    $bussiness_level_3_arr = $bl3_arr_view;
    }
    else
    {
    $bussiness_level_3_arr=implode(",",$this->input->post("ddl_bussiness_level_3"));
    }

    if(in_array('all', $this->input->post("ddl_function")))
    {
    $function_arr = $function_arr_view;
    }
    else
    {
    $function_arr = implode(",",$this->input->post("ddl_function"));
    }

    if(in_array('all', $this->input->post("ddl_sub_function")))
    {
    $sub_function_arr = $sub_function_arr_view;
    }
    else
    {
    $sub_function_arr = implode(",",$this->input->post("ddl_sub_function"));
    }

    if(in_array('all', $this->input->post("ddl_sub_subfunction")))
    {
    $sub_subfunction_arr = $sub_subfunction_arr_view;
    }
    else
    {
    $sub_subfunction_arr = implode(",",$this->input->post("ddl_sub_subfunction"));
    }

    if(in_array('all', $this->input->post("ddl_designation")))
    {
    $designation_arr = $designation_arr_view;
    }
    else
    {
    $designation_arr = implode(",",$this->input->post("ddl_designation"));
    }

    if(in_array('all', $this->input->post("ddl_grade")))
    {
    $grade_arr = $grade_arr_view;
    }
    else
    {
    $grade_arr = implode(",",$this->input->post("ddl_grade"));
    }

    if(in_array('all', $this->input->post("ddl_level")))
    {
    $level_arr = $level_arr_view;
    }
    else
    {
    $level_arr = implode(",",$this->input->post("ddl_level"));
    }

    if(in_array('all', $this->input->post("ddl_education")))
    {
    $temp_arr = array();
    $education_arr = "";
    foreach($data['education_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $education_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $education_arr = implode(",",$this->input->post("ddl_education"));
    }

    if(in_array('all', $this->input->post("ddl_critical_talent")))
    {
    $temp_arr = array();
    $critical_talent_arr = "";
    foreach($data['critical_talent_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $critical_talent_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $critical_talent_arr = implode(",",$this->input->post("ddl_critical_talent"));
    }

    if(in_array('all', $this->input->post("ddl_critical_position")))
    {
    $temp_arr = array();
    $critical_position_arr = "";
    foreach($data['critical_position_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $critical_position_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $critical_position_arr = implode(",",$this->input->post("ddl_critical_position"));
    }

    if(in_array('all', $this->input->post("ddl_special_category")))
    {
    $temp_arr = array();
    $special_category_arr = "";
    foreach($data['special_category_list'] as $item_row)
    {
        array_push($temp_arr,$item_row["id"]);
    }
    if($temp_arr)
    {
        $special_category_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $special_category_arr = implode(",",$this->input->post("ddl_special_category"));
    }

    if(in_array('all', $this->input->post("ddl_tenure_company")))
    {
    $temp_arr = array();
    for($i=0; $i<=CV_DEFAULT_MAX_TENURE; $i++)
    {
        array_push($temp_arr,$i);
    }
    if($temp_arr)
    {
        $tenure_company_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $tenure_company_arr = implode(",",$this->input->post("ddl_tenure_company"));
    }

    if(in_array('all', $this->input->post("ddl_tenure_role")))
    {
    $temp_arr = array();
    for($i=0; $i<=CV_DEFAULT_MAX_TENURE; $i++)
    {
        array_push($temp_arr,$i);
    }
    if($temp_arr)
    {
        $tenure_role_arr = implode(",",$temp_arr);
    }

    }
    else
    {
    $tenure_role_arr = implode(",",$this->input->post("ddl_tenure_role"));
    }

    //$emailTemplate=$this->common_model->getEmailTemplate(NEW_EMPLOYEEE);
   $upload_id=$this->input->post("upload_id");
    $conditions=' upload_id='.$upload_id.' and id!='.$this->session->userdata('userid_ses');
if(!empty($country_arr))
{
  $conditions.=' and country IN ('.$country_arr.')';
}

if(!empty($city_arr))
{
  $conditions.=' and city IN ('.$city_arr.')';
}
if(!empty($bussiness_level_1_arr))
{
  $conditions.=' and business_level_1 IN ('.$bussiness_level_1_arr.')';
}
if(!empty($bussiness_level_2_arr))
{
  $conditions.=' and business_level_2 IN ('.$bussiness_level_2_arr.')';
}
if(!empty($bussiness_level_3_arr))
{
  $conditions.=' and business_level_3 IN ('.$bussiness_level_3_arr.')';
}
if(!empty($function_arr))
{
  $conditions.=' and function IN ('.$function_arr.')';
}
if(!empty($sub_function_arr))
{
  $conditions.=' and subfunction IN ('.$sub_function_arr.')';
}

if(!empty($designation_arr))
{
  $conditions.=' and designation IN ('.$designation_arr.')';
}

if(!empty($grade_arr))
{
  $conditions.=' and grade IN ('.$grade_arr.')';
}
if(!empty($level_arr))
{
  $conditions.=' and level IN ('.$level_arr.')';
}
if(!empty($special_category_arr))
{
  $conditions.=' and special_category IN ('.$special_category_arr.')';
}
if(!empty($sub_subfunction_arr))
{
  $conditions.=' and sub_subfunction IN ('.$sub_subfunction_arr.')';
}

$data1=array(
            'condtion'=>$conditions
            ,'user_list'=>$this->input->post("user_list")
            ,'manager_arr'=>$manager_arr
            );
//print_r($data);
$this->db->insert(''.CV_PLATFORM_DB_NAME.'.corn_job_queue',array('json_text'=>json_encode($data1),'compnay_id'=>$this->session->userdata('companyid_ses'),'mail_stage'=>NEW_EMPLOYEEE, 'status' => 0, 'createdon' => date("Y-m-d H:i:s")));


//$userselected_list=explode(',',$this->input->post("user_list"));





$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your emails are queued and will go out shortly.</b></div>');

redirect(base_url('upload-data'));

}
public function MyTest()
{
    $email_config1=HLP_GetSMTP_Details();

     $emailTemplate=$this->common_model->getEmailTemplate(NEW_EMPLOYEEE);
     $mail_body="Final Test";

$this->common_model->send_emails($email_config1['email_from'], 'jaiprakash201019@gmail.com', $emailTemplate[0]->email_subject, $mail_body,$email_config1['result'],$email_config1['mail_fromname']);
exit;

}

}
