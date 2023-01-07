<?php defined('BASEPATH') or exit('No direct script access allowed');

class Scheduler extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        //    $this->load->library('session', 'encrypt');
        $this->load->helper(array('form', 'url', 'date'));

        //    $this->load->library('form_validation');
        $this->load->database();
        //$this->log=[];
    }

    /**
     *  Piy@1Jan20
     *  SP Single Sign on Login Service
     */
    public function cron_log($operation = '', $message = '', $json_text = '', $type = '')
    {
        if ($operation == 'csv') {
            $dt = new DateTime;
            $createdon = $dt->format('Y-m-d@H-i');
            $query = "SELECT * FROM `cron_log` order by createdon desc, id desc limit 0,30";
            $data_for_file = $this->db->query($query)->result_array();
            downloadcsv($data_for_file, $createdon . ".csv");
            exit();
        } else if ($operation == 'del') {
            $query = "TRUNCATE TABLE `cron_log`";
            $data_for_file = $this->db->query($query);
            //echo $_SERVER['USER_PORTAL_BASE_URL'];
            echo "Deleted Log";
            exit();
        } else {
            $json_text = json_encode($json_text);
            $compnay_url = $_SERVER['HTTP_HOST'];
            $this->db->query("INSERT INTO `cron_log`( `compnay_url`, `message`, `json_text`,  `type`, `operation`)  VALUES ('{$compnay_url}','{$message}','{$json_text}','{$type}','{$operation}')");
        }
    }

    public function execute()
    {
        /*  $schedulers = [

            'sftp' => [
                'username' => 'compport',
                'password' => 'CoMp@P$tr0n$20',
                'dirpath' => '/Spectra',
                'hostname' => 'dataexchanger.peoplestrong.com'
            ],
            'mapping_id' => 5,
            'user_id' => 1,
            'file_type_action' => 5,
            'csv_delimiters' => ['enclosed_by' => '"', 'delimited_by' => '|'],
            'duration'=>60

        ];

        $schedulers['sftp']['outbound_path'] = $schedulers['sftp']['dirpath'] . '/Outbound/Current/';
        $schedulers['sftp']['outbound_archive_path'] = $schedulers['sftp']['dirpath'] . '/Outbound/Archive/';
        $schedulers['sftp']['outbound_log_path'] = $schedulers['sftp']['dirpath'] . '/Outbound/Log/';
        $schedulers['csv_delimiters']['enclosed_by'] = '"';
        $schedulers['csv_delimiters']['delimited_by'] = '|';


        d(json_encode( $schedulers));*/
        $sql = "SELECT s.id,s.company_id,s.function,s.interval,s.param,mc.dbname as dbname,mc.api_key as apikey FROM " . CV_PLATFORM_DB_NAME . ".scheduler s join " . CV_PLATFORM_DB_NAME . ".manage_company mc on mc.id=s.company_id where s.status=1 AND mc.status=1 and s.function like 'php%' ORDER BY s.id  DESC";
        $schedulers = $this->db->query($sql)->result();
        foreach ($schedulers as $scheduler) {
            if (trim($scheduler->dbname) && $scheduler->function) {
                if (($scheduler->interval - time()) > 0) {
                    continue;
                }
                if (method_exists($this, $scheduler->function)) {
                    $result = call_user_func_array(array($this, $scheduler->function), [$scheduler->id, $scheduler]);
                } else {
                    echo "method does not exist";
                }
            } else {
                continue;
            }
        }
    }


    public function php_employeeUploadJob($id, $scheduler = [])
    {   $log='';
        if (!count($scheduler)) {
            $sql = "SELECT s.id,s.company_id,s.function,s.interval,s.param,mc.dbname as dbname,mc.api_key as apikey FROM " . CV_PLATFORM_DB_NAME . ".scheduler s join " . CV_PLATFORM_DB_NAME . ".manage_company mc on mc.id=s.company_id where s.status=1 AND mc.status=1 and s.function like 'php%' and s.id={$id} ORDER BY s.id  DESC";
            $scheduler = $this->db->query($sql)->result()[0];
        }
        //d($scheduler);
        if (trim($scheduler->dbname)) {
            $this->db->query("Use " . $scheduler->dbname);
            $options = json_decode($scheduler->param, true);
            $options['company_id'] = $scheduler->company_id;

            $result = $this->_getSFTPRemoteCsvFile($options);

            if (isset($result['upload_id']) && $result['upload_id']>0) {
                $this->load->model("mapping_model");
                @$mapping = json_decode($this->mapping_model->getMapping(array('id' =>  $options['mapping_id']))[0]["mapp_data"], true);
                $response = $this->_createUsersCSVMapping($result['upload_id'], $mapping, $options);

                foreach ($response['log'] as $l) {
                    $log .= "\r\n" . $l[0] . " - " . $l[1];
                }
                if ($options['sftp']['outbound_archive_path']) {
                    $response = $this->_setSFTPMoveCsvTOArchive($result['sftp_filename'], $result['local_filename'], $options);
                    foreach ($response['log'] as $l) {
                        $log .= "\r\n" . $l[0] . " - " . $l[1];
                    }
                }
            } else {
                foreach ($result['log'] as $l) {
                    $log .= "\r\n" . $l[0] . " - " . $l[1];
                }
            }
            if ($options['sftp']['outbound_log_path']) {
                $this->_setSFTPLogCsvFile($log, $options);
            }
            $sql = "UPDATE " . CV_PLATFORM_DB_NAME . ".scheduler s SET s.interval = UNIX_TIMESTAMP() - 30 + " . $options['duration'] . ", s.last_run=NOW(), s.last_status= '" . json_decode($log) . "' WHERE s.id={$id}";
            $result = $this->db->query($sql);
        }
    }

    private function _createUsersCSVMapping($upload_id, $ddl_mapping, $options)
    {
        $this->load->model("upload_model");
        $uploaded_file_dtl = $this->upload_model->get_uploaded_file_dtls($upload_id);
        $csv_file = base_url() . "uploads/" . $uploaded_file_dtl["original_file_name"];
        $detail = array(
            'userid_ses' => $options['user_id'],
            'companyid_ses' => $options['company_id'],
            'proxy_userid_ses' => $options['user_id']
        );
        $this->session->set_userdata($detail);

        if (($handle1 = fopen($csv_file, "r")) !== FALSE) {
            $sheet_head = fgetcsv($handle1);
            $sheet_head[] = "Remark";
            $sheet_head[] = "Error Field";
            $error_arr = array($sheet_head);

            $req_ba_list = $this->upload_model->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(id)) AS ba_ids, (select GROUP_CONCAT(CONCAT(id)) FROM `business_attribute` WHERE `data_type_code`='NUMERIC') AS numeric_ba_ids", array("status" => 1, 'is_required' => 1));
            $required_ba_ids_arr = explode(",", $req_ba_list["ba_ids"]);
            $numeric_ba_ids_arr = explode(",", $req_ba_list["numeric_ba_ids"]);
            $master_ba_ids_arr = array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_EDUCATION, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_BA_ID_SPECIAL_CATEGORY, CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID, CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, CV_CURRENCY_ID, CV_SUB_SUB_FUNCTION_ID, CV_BA_ID_RATING_FOR_2ND_LAST_YEAR, CV_BA_ID_RATING_FOR_3RD_LAST_YEAR, CV_BA_ID_RATING_FOR_4TH_LAST_YEAR, CV_BA_ID_RATING_FOR_5TH_LAST_YEAR, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE);


            $temp_tbl_fields = $field_from_csv_arr = $field_from_temp_arr = $master_fields_arr = $required_fields_arr = $numeric_fields_arr = $mapped_ba_ids_arr = $mapp_data = array();
            for ($i = 0; $i < 250; $i++) {
                if (isset($ddl_mapping[$i]) && $ddl_mapping[$i] != 'N/A') {

                    list($mapped_ba_id, $col_name) = explode(CV_CONCATENATE_SYNTAX, $ddl_mapping[$i]);
                    $mapp_data[$i] = $ddl_mapping[$i];
                    $temp_tbl_fields[$col_name] = array('type' => 'VARCHAR', 'constraint' => '150', 'null' => TRUE);
                    $mapped_ba_ids_arr[] = $mapped_ba_id;

                    $field_from_csv_arr[] = $col_name;

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
            $temp_table_name = "temp_upload_data_" . $upload_id;
            $this->upload_model->create_upload_temp_table($temp_table_name, $temp_tbl_fields);
            $response = $this->upload_model->insert_data_in_tmp_tbl($temp_table_name, implode(",", $field_from_csv_arr), $csv_file, $upload_id, $mapped_ba_ids_arr, $required_fields_arr, $numeric_fields_arr, implode(",", $field_from_temp_arr), $master_fields_arr, $options['csv_delimiters']);
            //      d( $response);
            if ($response["new_users_cnts"] > 0) {
                $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 2, "is_manager_role_updated" => 2));
            } else {
                $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 3));
            }

            $this->upload_model->set_role_for_managers_upload_id($upload_id, $options['user_id']);
            $this->upload_model->create_managers_hierarchy($upload_id);

            if ($response["error_data"]['error_cnts'] > 0) {
                $error_arr = array_merge($error_arr, $response["error_data"]);
                if ($response["new_users_cnts"] > 0) {
                    $log[] = ["Error in Data", "Partial records are invalid"];
                } else {
                    $log[] = ["Error in Data", "Invalid records found"];
                }
            } else if ($response["new_users_cnts"] > 0) {
                $log[] = ["Success", "Data uploaded successfully"];
                return ['error' => false, 'log' => $log];
            } else {
                $log[] = ["Invalid Data", "No data uploaded, may data incorrect or not exist. Try again!"];
            }
            return ['error' => true, 'errorData' => $error_arr, 'log' => $log];
        }
        $log[] = ["Invalid File", "Unable to read file"];
        return ['error' => true, 'log' => $log];
    }

    private function _getSFTPRemoteCsvFile($options)
    {
        $this->load->library('sftp');
        $sftp_config['hostname'] = $options['sftp']['hostname'];
        $sftp_config['username'] = $options['sftp']['username'];
        $sftp_config['password'] =  $options['sftp']['password'];
        $sftp_config['debug'] = false;

        // Actually try and connect to the remote server...
        if ($this->sftp->connect($sftp_config)) {
            $sftp_filename = '';
            $local_filename = '';
            $list_files = $this->sftp->list_files($options['sftp']['outbound_path']);
            foreach ($list_files  as $fn) {
                list($fname, $ext) = explode(".", $fn);
                if ($ext == 'csv') {
                    $sftp_filename = $fn;
                    break;
                }
            }

            if ($sftp_filename) {
                $local_filename = "uploads/" . $options['company_id'] . "_" . $sftp_filename;
                $response = $this->sftp->download($options['sftp']['outbound_path'] .  $sftp_filename, $local_filename);
                if ($response) {
                    $upload_db_arr = array(
                        "original_file_name" => basename($local_filename),
                        "uploaded_file_name" => basename($sftp_filename),
                        "upload_date" => date("Y-m-d H:i:s"),
                        "uploaded_by_user_id" => $options['user_id'],
                        "file_type" => $options['file_type_action'],
                        "createdby_proxy" => $options['user_id'],
                    );
                    $this->load->model("upload_model");
                    $upload_id = $this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
                    $log[] = ['Success', 'Download file successfully'];
                    return ['log' => $log, 'sftp_filename' => $sftp_filename, 'local_filename' => $local_filename, 'upload_id' => $upload_id];
                } else {
                    $log[] = ['Remote File Missing', 'Unable to download file'];
                }
            } else {
                $log[] = ['Remote File Missing', 'Unable to locate file'];
            }
        } else {
            $log[] = ['Connection Failure', 'Unable to connect remote server'];
        }

        return ['log' => $log, 'sftp_filename' => $sftp_filename];
    }    

    private function _setSFTPMoveCsvTOArchive($sftp_filename, $local_filename, $options)
    {
        //  d($sftp_filename, $local_filename, $options);
        $this->load->library('sftp');
        $sftp_config['hostname'] = $options['sftp']['hostname'];
        $sftp_config['username'] = $options['sftp']['username'];
        $sftp_config['password'] =  $options['sftp']['password'];
        $sftp_config['debug'] = false;

        // Actually try and connect to the remote server...
        if ($this->sftp->connect($sftp_config)) {
            $response = $this->sftp->upload($local_filename, $options['sftp']['outbound_archive_path'] .  $sftp_filename);
            if ($response) {
                $response = $this->sftp->delete_file($options['sftp']['outbound_path'] .  $sftp_filename);
                if (!$response) {
                    $log[] = ['Remote File Missing', 'Unable to delete file'];
                }
            } else {
                $log[] = ['Remote File Missing', 'Unable to upload file'];
            }
        }
        else {
            $log[] = ['Connection Failure', 'Unable to connect remote server'];
        }
        return ['log' => $log];
    }

    private function _setSFTPLogCsvFile($log_message, $options)
    {
        //    d($log);
        $this->load->library('sftp');
        $sftp_config['hostname'] = $options['sftp']['hostname'];
        $sftp_config['username'] = $options['sftp']['username'];
        $sftp_config['password'] =  $options['sftp']['password'];
        $sftp_config['debug'] = false;

        // Actually try and connect to the remote server...
        if ($this->sftp->connect($sftp_config)) {
            $local_filename = "uploads/" . $options['company_id'] . "_" . date('dmY_His') . '.log';
            file_put_contents($local_filename, $log_message);
            $response = $this->sftp->upload($local_filename, $options['sftp']['outbound_log_path'] .  "log_" . date('dmY_His') . '.log');
            unlink($local_filename);
            if ($response) {
                $log[] = ['Success', 'Log upload successfully'];
            } else {
                $log[] = ['Failure', 'Unable to upload log file'];
            }
        } else {
            $log[] = ['Connection Failure', 'Unable to connect remote server'];
        }
        return ['log' => $log];
    }

    private function _updateUsersCSVStatus($upload_id, $status)
    {

        $this->load->model("user_model");
        $users = [];
        $overall_success = TRUE;
        $rec_count = 0;
        $uploaded_file_dtl = $this->upload_model->get_uploaded_file_dtls($upload_id);
        $csv_file = base_url() . "uploads/" . $uploaded_file_dtl["original_file_name"];

        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            $sheet_head = fgetcsv($handle);
            $sheet_head[] = "Remark";
            $error_arr = array($sheet_head);

            // validating records.
            while (($email_records = fgetcsv($handle)) !== FALSE) {
                //get_user_id_by_email
                $user_id = $this->user_model->get_user_id_by_email($email_records[0]);

                if (!$user_id) {
                    $overall_success = FALSE;
                    $email_records[] = "No Record Found";
                } elseif ($this->user_model->check_rights_conflicts($user_id) && $status == 1) {
                    $overall_success = FALSE;
                    $email_records[] = "Conflict Right Issue";
                } else {
                    $users[$user_id] = $email_records[0];
                }
                $error_arr[] = $email_records;
            }

            if (!$overall_success) {/*
                $this->session->set_userdata(array("errors_file_data" => $error_arr));
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data may be incorrect or not exist in file. Try again!</b></div>');
                redirect(site_url($redirect_to));*/
            }

            //set data
            $overall_success = TRUE;
            $error_arr = [];
            foreach ($users as $user_id => $email) {
                $response = $this->user_model->update_status($user_id, $status);
                if (isset($response["error_msg"]) && !empty($response["error_msg"])) {
                    $overall_success = FALSE;
                    $error_arr[] = [$email, $response["error_msg"]];
                } else {
                    $rec_count++;
                }
            }
            if ($overall_success && ($rec_count > 0)) {
                $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 2));
                $log[] = ["Success", "Data uploaded successfully"];
                return ['error' => false];
            } else {
                $this->session->set_userdata(array("errors_file_data" => $error_arr));
                $this->upload_model->update_uploaded_file_status(array("id" => $upload_id), array("status" => 3));
                $log[] = ["Invalid Data", "No data uploaded, may data incorrect or not exist. Try again!"];
                return ['error' => true, 'errorData' => $error_arr];
            }

            fclose($handle);
        }
    }

    private function _sendCsvOnMail($body, $subject = 'Website Report', $user_id, $csvData = [])
    {

        $to = 'piyush.bagri@compport.com';
        $csv_file = "uploads/error_" . time() .  ".csv";
        $body .= "\n" . $log;

        $email_config = array('charset' => 'utf-8', 'mailtype' => 'html');
        $email_config["protocol"] = "smtp";
        $email_config["smtp_host"] = 'smtp.gmail.com';
        $email_config["smtp_port"] =  465;
        $email_config["smtp_user"] = 'rewards@oyorooms.com';
        $email_config["smtp_pass"] = 'Comp@2019';
        $email_config["smtp_crypto"] = "ssl";
        $this->load->library('email', $email_config);
        $this->email->set_newline("\r\n");
        $this->email->from('info@compport.com', "Compport");
        $this->email->to(array($to));
        $this->email->subject($subject);

        if (count($csvData)) {
            // Open temp file pointer
            $fp = fopen($csv_file, 'w+');
            if (!$fp) return FALSE;
            // Loop data and write to file pointer
            foreach ($csvData as $line) {
                fputcsv($fp, $line);
            }
            fclose($fp);
            $this->email->attach($csv_file);
            echo  $csv_file;
        }

        $this->email->message($body);
        if ($this->email->send()) {
            echo 'send';
        } else {
            echo  'not send';
        }
        echo $this->email->print_debugger();
    }


    public function index()
    {
    }


    public function insertEmployeeRecord()
    {
    }



    /*
    private function create_csv_string_download($data,$f_name)
    {
        $filename = time() . ".csv";
        if($f_name)
        {
            $filename = $f_name;
        }
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // Open temp file pointer
        if (!$fp = fopen('php://output', 'w+')) return FALSE;

        // Loop data and write to file pointer
        foreach($data as $line)  fputcsv($fp, $line);
         
        fclose($fp);
    }

    private function _create_csv_string($data) {
   
        
        // Open temp file pointer
        if (!$fp = fopen('php://output', 'w+')) return FALSE;
       
        // Loop data and write to file pointer
        foreach($data as $line) fputcsv($fp, $line);
       
        // Place stream pointer at beginning
        rewind($fp);
        fclose($fp);
        // Return the data
        return stream_get_contents($fp);
    
    }
    */
    /*
    private function _getSFTPRemoteCsvFile_old($options)
    {
        // d($options);
        $default_options = [
            'csv_file' => "uploads/" . time() . $options['company_id'] .  ".csv",
        ];
        $options = array_merge($options, $default_options);

        $fh = fopen($options['csv_file'], 'w');
        if ($fh !== FALSE) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $options['sftp']['OutBoundUrl']);
            curl_setopt($ch, CURLOPT_USERPWD, $options['sftp']['username'] . ':' . $options['sftp']['password']);
            curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            file_put_contents($options['csv_file'], $response);
            $error = curl_error($ch);
            curl_close($ch);

            if ($response) {
                $upload_db_arr = array(
                    "original_file_name" => basename($options['csv_file']),
                    "uploaded_file_name" =>  basename($options['sftp']['dirpath']),
                    "upload_date" => date("Y-m-d H:i:s"),
                    "uploaded_by_user_id" => $options['user_id'],
                    "file_type" => $options['file_type_action'],
                    "createdby_proxy" => $options['user_id'],
                );
                $this->load->model("upload_model");
                return $this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
            } else {
                $log[] = ['SFTP Failure', $error];
            }
        } else {
            $log[] = ['Local File Error', 'Unable to open file'];
        }

        return ['log' => $log];
    }

*/
}
