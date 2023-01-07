<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ravi extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->load->library('session', 'encrypt');			
		$this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');   
		$this->load->model("business_attribute_model");
		$this->load->model("upload_model");
		                           
    }
	
	public function test_req()
	{
		echo "<pre>F";print_r(realpath(FCPATH.'uploads'));
		echo "<pre>B";print_r(BASEPATH);
		echo "<pre>A";print_r(APPPATH);
		echo "<pre>";print_r($_SERVER);die;
	}
	
	public function tu($action="")
	{	
		if ($_FILES)
		{
		
			$curl = curl_init();	
			curl_setopt_array($curl, array(
									CURLOPT_URL => "http://scanner-service:8080/scan",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 0,
									CURLOPT_FOLLOWLOCATION => true,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($_FILES["myfile"]["tmp_name"]), 'name'=>$_FILES['myfile']['name']),
								));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			echo "Error-11---".$_FILES["myfile"]["tmp_name"];print_r($err);
			echo "Response-11---";print_r($response);die;
		
		
		
		
		
			$file_data = file_get_contents($_FILES["myfile"]["tmp_name"]);
			
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://scanner-service:8080/scan",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => array('file'=> $file_data, 'name'=>$_FILES['myfile']['name']),
			  CURLOPT_HTTPHEADER => array(
				"Content-Type: text/csv"
			  ),
			));
			
			$response = curl_exec($curl);
			
			$err = curl_error($curl);

	 	curl_close($curl);

	 	if ($err) {
	 	  echo "cURL Error #:" . $err;
	 	} else {
	 	 
         	echo "Res -2---<pre>"; print_r($response);
	 	}
			

			
			$file_type = explode('.', $_FILES['myfile']['name']);
			$uploaded_file_name = $_FILES['myfile']['name'];
			$ts = time();
			$fName = $ts . "." . $file_type[1]; //$_FILES["myfile"]["name"];
			//$dd = move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/" . $fName);
			$f_absolute_path = $_FILES["myfile"]["tmp_name"];
			
			$curl = curl_init();	
			curl_setopt_array($curl, array(
									CURLOPT_URL => "http://scanner-service:8080/scan",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 0,
									CURLOPT_FOLLOWLOCATION => true,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($_FILES["myfile"]["tmp_name"]), 'name'=>$_FILES['myfile']['name']),
								));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			echo "Err-111---<pre>";print_r($err);
			echo "R-ravi-111---<pre>";print_r($response);
			
			
			$curl = curl_init();	
			curl_setopt_array($curl, array(
									CURLOPT_URL => "http://scanner-service:8080/scan",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 0,
									CURLOPT_FOLLOWLOCATION => true,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($file_data, 'text/csv', 'file'), 'name'=>$_FILES['myfile']['name']),
								));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			echo "Err-2---<pre>";print_r($err);
			echo "R ravi-2---<pre>";print_r($response);die;
			
			
			echo "<pre>";print_r($file_data);die;
			$file_type = explode('.', $_FILES['myfile']['name']);
			$uploaded_file_name = $_FILES['myfile']['name'];
			$ts = time();
			$fName = $ts . "." . $file_type[1]; //$_FILES["myfile"]["name"];
			$dd = move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/" . $fName);
			/*$final_result = HL_scan_uploaded_file($fName, "uploads/" . $fName);
			echo "1=>".$final_result."<br>";
			
			$final_result = HL_scan_uploaded_file("", "uploads/" . $fName);
			echo "2=>".$final_result."<br>";*/
			
			
			
			//$f_absolute_path = "/app/uploads/" . $fName;
			$f_absolute_path = $_FILES["myfile"];
			$curl = curl_init();	
			curl_setopt_array($curl, array(
									CURLOPT_URL => "http://scanner-service:8080/scan",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 0,
									CURLOPT_FOLLOWLOCATION => true,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => array('datafile'=> new CURLFILE($f_absolute_path, 'text/csv', 'datafile'), 'name'=>$uploaded_file_name),
								));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			echo "<pre>";print_r($response);die;
			$final_result = "Uploaded file having some virus.";
			if($err)
			{
			  $final_result = "Error :".$err;
			}
			else
			{
				if(trim($response) == "Everything ok : true")
				{
					$final_result = true;
				}			  
			}
			echo "3=>".$final_result."<br>";
			
			
			
			$f_absolute_path = "/uploads/" . $fName;
			$curl = curl_init();	
			curl_setopt_array($curl, array(
									CURLOPT_URL => "http://scanner-service:8080/scan",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 0,
									CURLOPT_FOLLOWLOCATION => true,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($f_absolute_path), 'name'=>"rv"),
								));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			$final_result = "Uploaded file having some virus.";
			if($err)
			{
			  $final_result = "Error :".$err;
			}
			else
			{
				if(trim($response) == "Everything ok : true")
				{
					$final_result = true;
				}			  
			}
			echo "4=>".$final_result."<br>";
			
			
			die;
			/*echo $_SERVER['DOCUMENT_ROOT']."/uploads/".$fName;
			echo "<br>";
			// Name of your CSV file
			echo $csv_file = FCPATH . "uploads/" . $fName;die;		
			$curl = curl_init();	
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://scanner-service:8080/scan",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($csv_file),'name' => $fName),
			));
			
			
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			$final_result = "Uploaded file having some virus.";
			if($err)
			{
			  $final_result = "Error :".$err;
			}
			else
			{
				if(trim($response) == "Everything ok : true")
				{
					$final_result = true;
				}			  
			}*/
			echo $final_result;die;
		}



		$data["msg"] = "";
        $data['body'] = "upload_file";
        $data['formaction'] = str_replace("_","-","ravi/tu");
        $data['actionpath'] = $action;

        if ($action == "bulk_delete") {
            $redirect_to            = "bulk-delete";
            $data['title']          = "Bulk Delete Records";
            $data['button_title']   = "Bulk Delete";
            $file_type_action       = 2;
        }
        else if ($action == "bulk_active") {
            $redirect_to            = "bulk-active";
            $data['title']          = "Bulk Active Records";
            $data['button_title']   = "Activate Employees Record";
            $file_type_action       = 3;
        }
        else if ($action == "bulk_inactive") {
            $redirect_to            = "bulk-inactive";
            $data['title']          = "Bulk Inactive Records";
            $data['button_title']   = "Inactivate Employees Record";
            $file_type_action       = 4;
        }
        else {
            // case of bulk_insert
            $redirect_to              = "upload-data";
            $data['title']            = "Uploaded Files";
            $file_type_action         = 1;
            $redirect_to              = "upload-data";
            $data['title']            = "Upload Data";
            $data['button_title']     = "Upload";

        }

        $business_attribute_list = $this->business_attribute_model->get_business_attributes(array("status" => 1));
        $email_ba_is_active_with_required = $this->business_attribute_model->get_business_attributes(array("status" => 1, 'is_required' => 1, "module_name" => CV_EMAIL_MODULE_NAME));


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
	
	public function scan($action="")
	{	
		if ($_FILES)
		{
			$file_type = explode('.', $_FILES['myfile']['name']);
			$uploaded_file_name = $_FILES['myfile']['name'];
			$ts = time();
			$fName = $ts . "." . $file_type[1]; //$_FILES["myfile"]["name"];
			$dd = move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/" . $fName);

			// Name of your CSV file
			$csv_file = FCPATH . "uploads/" . $fName;		
			$curl = curl_init();	
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://scanner-service:8080/scan",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($csv_file),'name' => $fName),
			));
			
			
			
			$response = curl_exec($curl);
			$err = curl_error($curl);			
			curl_close($curl);
			$final_result = "Uploaded file having some virus.";
			if($err)
			{
			  $final_result = "Error :".$err;
			}
			else
			{
				if(trim($response) == "Everything ok : true")
				{
					$final_result = true;
				}			  
			}
			echo $final_result;die;
		}



		$data["msg"] = "";
        $data['body'] = "upload_file";
        $data['formaction'] = str_replace("_","-","ravi/tu");
        $data['actionpath'] = $action;

        if ($action == "bulk_delete") {
            $redirect_to            = "bulk-delete";
            $data['title']          = "Bulk Delete Records";
            $data['button_title']   = "Bulk Delete";
            $file_type_action       = 2;
        }
        else if ($action == "bulk_active") {
            $redirect_to            = "bulk-active";
            $data['title']          = "Bulk Active Records";
            $data['button_title']   = "Activate Employees Record";
            $file_type_action       = 3;
        }
        else if ($action == "bulk_inactive") {
            $redirect_to            = "bulk-inactive";
            $data['title']          = "Bulk Inactive Records";
            $data['button_title']   = "Inactivate Employees Record";
            $file_type_action       = 4;
        }
        else {
            // case of bulk_insert
            $redirect_to              = "upload-data";
            $data['title']            = "Uploaded Files";
            $file_type_action         = 1;
            $redirect_to              = "upload-data";
            $data['title']            = "Upload Data";
            $data['button_title']     = "Upload";

        }

        $business_attribute_list = $this->business_attribute_model->get_business_attributes(array("status" => 1));
        $email_ba_is_active_with_required = $this->business_attribute_model->get_business_attributes(array("status" => 1, 'is_required' => 1, "module_name" => CV_EMAIL_MODULE_NAME));


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
	
	public function pin()
	{		
        echo "<pre>";print_r(phpinfo());die;
	}
	
}
