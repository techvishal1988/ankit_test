<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');

        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
        $this->load->model("admin_model");
        $this->load->model("common_model");
        $this->load->model("upload_model");
        $this->load->model('performance_cycle_model');
        $this->load->model("rule_model");
        $this->load->model("Empgraph_model");
        $this->lang->load('message', 'english');
        $this->session->set_userdata(array('sub_session' => $this->session->userdata('role_ses')));

        $this->user_id          = $this->session->userdata('userid_ses');
        $this->user_role_id     = $this->session->userdata('role_ses');

        $get_emp_profile_page   = $this->uri->segment(1);
        $get_emp_profile_url_arr= ['view-employee', 'view-emoloye'];

        if (!$this->user_id || !$this->session->userdata('role_ses') || $this->session->userdata('dbname_ses') == '' ||
             ($this->session->userdata('role_ses') > 9 && !in_array($get_emp_profile_page, $get_emp_profile_url_arr))) {

                redirect(site_url("dashboard"));

        }

        HLP_is_valid_web_token();
    }

    public function index() {
        $data['msg'] = "";

        if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
            redirect(site_url("no-rights"));
        }

        if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
            $data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->lang->line('msg_no_add_right') . '</b></span></div>';
        }

        $arr = "";
        if ($this->input->post()) {
            $this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
        }

        if ($this->session->userdata('keyword')) {
            $arr = "(login_user." . CV_BA_NAME_EMP_FULL_NAME . " LIKE '%" . $this->session->userdata('keyword') . "%' OR login_user." . CV_BA_NAME_EMP_EMAIL . " LIKE '%" . $this->session->userdata('keyword') . "%')";
        }

        $data['keyword'] = $this->session->userdata('keyword');
        $this->session->unset_userdata('keyword');
        $data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name, status, ba_name", "", "id asc");
        $data['title'] = "Employee list";
        $data['body'] = "admin/staff_list";
        $data['hide_field_array'] = get_business_attribute_status_array($data['business_attributes']);

        $this->load->view('common/structure', $data);
    }

    public function hr_list() {
        $data['msg'] = "";
        $arr = "(login_user.role = 2 OR login_user.role = 3)";
        if ($this->input->post()) {
            $this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
        }

        if ($this->session->userdata('keyword')) {
            $arr .= " AND (login_user." . CV_BA_NAME_EMP_FULL_NAME . " LIKE '%" . $this->session->userdata('keyword') . "%' OR login_user." . CV_BA_NAME_EMP_EMAIL . " LIKE '%" . $this->session->userdata('keyword') . "%')";
        }

        $data['keyword'] = $this->session->userdata('keyword');
        $data['staff_list'] = $this->admin_model->get_staff_list($arr);
        $data['title'] = "Hr List";
        $data['body'] = "admin/staff_list";
        $this->load->view('common/structure', $data);
    }

//    public function add_staff() {
//        if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
//            redirect(site_url("staff"));
//        }
//
//        $data['msg'] = "";
//        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
//        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
//            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
//        }
//        $data['attributes'] = $this->admin_model->staffattributes(array("module_name !=" => $ba_not_for));
//
//        if ($this->input->post()) {
//            $this->form_validation->set_rules("txt_" . CV_EMP_NAME_ID, 'Name', 'trim|required|max_length[50]');
//            $this->form_validation->set_rules("txt_" . CV_EMAIL_ID, 'Email', 'trim|required|max_length[50]|valid_email');
//            $this->form_validation->set_rules('ddl_role', 'Role', 'trim|required');
//            if ($this->form_validation->run()) {
//                // Check all requireds, emails and numerics type validations Start -------------------
//                $req_ba_list = $this->upload_model->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(id)) AS ba_ids, (select GROUP_CONCAT(CONCAT(id)) FROM `business_attribute` WHERE `data_type_code`='NUMERIC') AS numeric_ba_ids", array("status" => 1, 'is_required' => 1));
//                $requiredFields = explode(",", $req_ba_list["ba_ids"]);
//                $numeric_ba_ids_arr = explode(",", $req_ba_list["numeric_ba_ids"]);
//                $emails_type_ba_arr = array(CV_EMAIL_ID, 64, 65, 66, 67, 69, 71);
//                $err_str = "";
//                foreach ($data['attributes'] as $ba_key => $ba_value) {
//                    foreach ($ba_value as $ba_row) {
//                        $txtVal = trim($this->input->post("txt_" . $ba_row["id"]));
//
//                        if (in_array($ba_row["id"], $requiredFields) and $txtVal == "") {
//                            $err_str .= $ba_row["display_name"] . " can not be a null value.</br>";
//                            //break;
//                        }
//
//                        if (in_array($ba_row["id"], $emails_type_ba_arr) and $txtVal != "") {
//                            $company_domain_name = strtolower($this->session->userdata('domainname_ses'));
//                            if ($this->form_validation->valid_emails(strtolower($txtVal)) == false or preg_match("/@.*" . $company_domain_name . "$/", strtolower($txtVal)) == false) {
//                                $err_str .= $ba_row["display_name"] . " should have a valid and your domain related email.</br>";
//                                //break;
//                            }
//                        }
//
//                        if (in_array($ba_row["id"], $numeric_ba_ids_arr) and $txtVal != "") {
//                            $txtVal = str_replace(array(",", " "), "", $txtVal);
//                            if (!$this->form_validation->numeric($txtVal)) {
//                                $err_str .= $ba_row["display_name"] . " should have numeric values only.</br>";
//                                //break;
//                            }
//                        }
//                    }
//                }
//
//                if ($err_str != "") {
//                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $err_str . '</b></div>');
//                    redirect(site_url("add-staff"));
//                }
//
//                // Check all requireds, emails and numerics type validations End -------------------
//
//                $name = trim($this->input->post("txt_" . CV_EMP_NAME_ID));
//                $email = trim($this->input->post("txt_" . CV_EMAIL_ID));
//                //$pwd = $this->input->post('txt_pwd');
//                //$user_designation = $this->input->post('ddl_user_designation');
//                $role = $this->input->post('ddl_role');
//                $user_dtls = $this->admin_model->get_table_row("login_user", "id", array("email" => $email), "id desc");
//                $is_new_usr = 1; //0=No,1=Yes
//                if ($user_dtls) {
//                    if (!helper_have_rights(CV_STAFF_ID, CV_UPDATE_RIGHT_NAME)) {
//                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
//                        redirect(site_url("staff"));
//                    }
//
//                    $is_new_usr = 0;
//                    $manage_hr_only = 0;
//                    if (($role == '3' or $role == '4' or $role == '5') and $this->input->post('chk_manage_hr_only') == 1) {
//                        $manage_hr_only = 1;
//                    }
//
//                    $uid = $user_dtls["id"];
//                    $this->admin_model->update_tbl_data("login_user", array("name" => $name, "role" => $role, 'manage_hr_only' => $manage_hr_only, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array("id" => $uid));
//                    /* code for mager check start */
//
//                    if ($this->input->post('txt_' . CV_FIRST_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
//                            ));
//                        }
//                    }
//                    if ($this->input->post('txt_' . CV_SECOND_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
//                            ));
//                        }
//                    }
//                    if ($this->input->post('txt_' . CV_THIRD_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
//                            ));
//                        }
//                    }
//                    if ($this->input->post('txt_' . CV_FOURTH_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
//                            ));
//                        }
//                    }
//
//                    /* code for mager check end */
//                    $this->session->set_flashdata('message', '<<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_edit_success_employee') . '</b></div>');
//                } else {
//                    $staff_db_arr = array(
//                        "name" => $name,
//                        "email" => $email,
//                        //"pass"=>md5($pwd),
//                        //"status"=>$status,
//                        //"desig"=>$user_designation,
//                        "role" => $role,
//                        "company_Id" => $this->session->userdata('companyid_ses'),
//                        "createdby" => $this->session->userdata('userid_ses'),
//                        "updatedby" => $this->session->userdata('userid_ses'),
//                        "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
//                        "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
//                        "createdon" => date("Y-m-d H:i:s"),
//                        "updatedon" => date("Y-m-d H:i:s"));
//
//                    if (($role == '3' or $role == '4' or $role == '5') and $this->input->post('chk_manage_hr_only') == 1) {
//                        $staff_db_arr['manage_hr_only'] = 1;
//                    }
//
//                    $this->admin_model->insert_staff($staff_db_arr);
//                    $uid = $this->db->insert_id();
//                    /* code for mager check start */
//
//                    if ($this->input->post('txt_' . CV_FIRST_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
//                            ));
//                        }
//                    }
//                    if ($this->input->post('txt_' . CV_SECOND_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
//                            ));
//                        }
//                    }
//                    if ($this->input->post('txt_' . CV_THIRD_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
//                            ));
//                        }
//                    }
//                    if ($this->input->post('txt_' . CV_FOURTH_APPROVER_ID) != '') {
//                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)), "id desc");
//                        $ap_role = $ap_dtls["role"];
//                        if (setManager($ap_role)) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
//                            ));
//                        }
//                        if ($ap_role == 11) {
//                            $this->admin_model->update_tbl_data("login_user", array(
//                                "role" => '10',
//                                "is_manager" => '1',
//                                    ), array(
//                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
//                            ));
//                        }
//                    }
//
//                    /* code for mager check end */
//
//                    $verification_url = site_url("verify-account/" . base64_encode($uid) . "/" . base64_encode($email));
//                    $mail_body = "Dear " . strtoupper($name) . ",
//					<br /><br />
//					Your Username :" . $email . "<br />
//					<br /><br />
//					<a href=" . $verification_url . ">Click here </a> to set your password for login.<br /><br />";
//                    $mail_sub = "Account Details.";
//                    $this->send_emails(CV_EMAIL_FROM, $email, $mail_sub, $mail_body);
//                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_create_success_employee') . '</b></div>');
//                }
//
//                $upload_db_arr = array(
//                    "original_file_name" => CV_DEFAULT_FILE_NAME,
//                    "status" => 1,
//                    "upload_date" => date("Y-m-d H:i:s"),
//                    "uploaded_by_user_id" => $this->session->userdata('userid_ses'),
//                    "createdby_proxy" => $this->session->userdata("proxy_userid_ses"));
//                $upload_id = $this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
//
//                $cnt = 0;
//                $row_no = 0;
//                $rowOwner_db_arr = array(
//                    "row_id" => $row_no,
//                    "upload_id" => $upload_id,
//                    "first_approver" => "",
//                    "second_approver" => "",
//                    "third_approver" => "",
//                    "fourth_approver" => "");
//
//                $db_datum_ins_arr = array();
//                $db_datum_upd_arr = array();
//
//                foreach ($data['attributes'] as $ba_key => $ba_value) {
//                    foreach ($ba_value as $ba_row) {
//                        $txt_val = trim($this->input->post("txt_" . $ba_row["id"]));
//                        if (in_array($ba_row["id"], $numeric_ba_ids_arr) and $txt_val != "") {
//                            $txt_val = str_replace(array(",", " "), "", $txt_val);
//                        }
//                        $ba_id = $ba_row["id"];
//                        $db_datum_ins_arr[] = array(
//                            "row_num" => $row_no,
//                            "col_num" => $cnt,
//                            "data_upload_id" => $upload_id,
//                            "uploaded_value" => $txt_val,
//                            "value" => $txt_val,
//                            "business_attribute_id" => $ba_id
//                        );
//
//                        if ($txt_val) {
//                            $db_datum_upd_arr[] = array("business_attribute_id" => $ba_id, "uploaded_value" => $txt_val, "value" => $txt_val);
//                        }
//                        $cnt++;
//                    }
//                }
//
//
//                if ($is_new_usr) {
//                    $this->upload_model->ins_upd_datum_by_batch($upload_id, $row_no, $db_datum_ins_arr);
//
//                    $this->upload_model->insertRowOwner($rowOwner_db_arr);
//                    $tuples_db_arr = array(
//                        "row_num" => $row_no,
//                        "data_upload_id" => $upload_id,
//                        "created_by_user_id" => $this->session->userdata("userid_ses"),
//                        "createdby_proxy" => $this->session->userdata("proxy_userid_ses"));
//                    $this->upload_model->insert_tuples($tuples_db_arr);
//                } else {
//                    $this->upload_model->ins_upd_datum_by_batch($upload_id, $row_no, $db_datum_upd_arr, $uid);
//                }
//
//                redirect(site_url("update-approvel/" . $upload_id));
//                //redirect(site_url("add-staff"));
//            } else {
//                $this->session->set_flashdata('message', '<<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
//                redirect(site_url("add-staff"));
//            }
//        }
//
//        $data['roles'] = $this->admin_model->get_table("roles", "*", array("id >" => 2));
//        $data['title'] = "Add Employee";
//        $data['body'] = "admin/add_staff";
//        $this->load->view('common/structure', $data);
//    }
    //************ modify funtion for add emp by rajesh narvariya on 08-01-2019 *************//
    public function add_staff() {
        if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
            redirect(site_url("staff"));
        }

        $data['msg'] = "";
        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
        }
        $data['attributes'] = $this->admin_model->staffattributes(array("module_name !=" => $ba_not_for));

        if ($this->input->post()) {
            $this->form_validation->set_rules("txt_" . CV_EMP_NAME_ID, 'Name', 'trim|required|max_length[50]');
            $this->form_validation->set_rules("txt_" . CV_EMAIL_ID, 'Email', 'trim|required|max_length[50]|valid_email');
            $this->form_validation->set_rules('ddl_role', 'Role', 'trim|required');
            if ($this->form_validation->run()) {
                // Check all requireds, emails and numerics type validations Start -------------------
                $req_ba_list = $this->upload_model->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(id)) AS ba_ids, (select GROUP_CONCAT(CONCAT(id)) FROM `business_attribute` WHERE `data_type_code`='NUMERIC') AS numeric_ba_ids", array("status" => 1, 'is_required' => 1));
                $requiredFields = explode(",", $req_ba_list["ba_ids"]);
                $numeric_ba_ids_arr = explode(",", $req_ba_list["numeric_ba_ids"]);
                $emails_type_ba_arr = array(CV_EMAIL_ID, 64, 65, 66, 67, 69, 71);
                $err_str = "";
                foreach ($data['attributes'] as $ba_key => $ba_value) {
                    foreach ($ba_value as $ba_row) {
                        $txtVal = trim($this->input->post("txt_" . $ba_row["id"]));

                        if (in_array($ba_row["id"], $requiredFields) and $txtVal == "") {
                            $err_str .= $ba_row["display_name"] . " can not be a null value.</br>";
                            //break;
                        }

                        if (in_array($ba_row["id"], $emails_type_ba_arr) and $txtVal != "") {
                            $company_domain_name = strtolower($this->session->userdata('domainname_ses'));
                            if ($this->form_validation->valid_emails(strtolower($txtVal)) == false or preg_match("/@.*" . $company_domain_name . "$/", strtolower($txtVal)) == false) {
                                $err_str .= $ba_row["display_name"] . " should have a valid and your domain related email.</br>";
                                //break;
                            }
                        }

                        if (in_array($ba_row["id"], $numeric_ba_ids_arr) and $txtVal != "") {
                            $txtVal = str_replace(array(",", " "), "", $txtVal);
                            if (!$this->form_validation->numeric($txtVal)) {
                                $err_str .= $ba_row["display_name"] . " should have numeric values only.</br>";
                                //break;
                            }
                        }
                    }
                }

                if ($err_str != "") {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $err_str . '</b></div>');
                    redirect(site_url("add-staff"));
                }

                // Check all requireds, emails and numerics type validations End -------------------

                $name = trim($this->input->post("txt_" . CV_EMP_NAME_ID));
                $email = trim($this->input->post("txt_" . CV_EMAIL_ID));
                //$pwd = $this->input->post('txt_pwd');
                //$user_designation = $this->input->post('ddl_user_designation');
                $role = $this->input->post('ddl_role');
                $user_dtls = $this->admin_model->get_table_row("login_user", "id", array("email" => $email), "id desc");
                $is_new_usr = 1; //0=No,1=Yes
                if ($user_dtls) {
                    if (!helper_have_rights(CV_STAFF_ID, CV_UPDATE_RIGHT_NAME)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
                        redirect(site_url("staff"));
                    }

                    $is_new_usr = 0;
                    $manage_hr_only = 0;
                    if (($role == '3' or $role == '4' or $role == '5') and $this->input->post('chk_manage_hr_only') == 1) {
                        $manage_hr_only = 1;
                    }

                    $uid = $user_dtls["id"];
                    $this->admin_model->update_tbl_data("login_user", array("name" => $name, "role" => $role, 'manage_hr_only' => $manage_hr_only, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array("id" => $uid));
                    /* code for mager check start */

                    if ($this->input->post('txt_' . CV_FIRST_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_SECOND_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_THIRD_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_FOURTH_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
                            ));
                        }
                    }

                    /* code for mager check end */
                    $this->session->set_flashdata('message', '<<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_edit_success_employee') . '</b></div>');
                } else {
                    //print_r($data['attributes']);
                    $emp_db_arr = array();
                    foreach ($data['attributes'] as $ba_key => $ba_value) {
                        foreach ($ba_value as $ba_row) {
                            $txt_val = trim($this->input->post("txt_" . $ba_row["id"])) . "";

                            $m_ba_id_arr = array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_SUB_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_CURRENCY_ID, CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID, CV_BA_ID_RATING_FOR_2ND_LAST_YEAR, CV_BA_ID_RATING_FOR_3RD_LAST_YEAR, CV_BA_ID_RATING_FOR_4TH_LAST_YEAR, CV_BA_ID_RATING_FOR_5TH_LAST_YEAR, CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE);
                            if (in_array($ba_row["id"], $m_ba_id_arr)) {
                                if ($ba_row["id"] == CV_BA_ID_COUNTRY) {
                                    $country_dtls = $this->admin_model->get_table_row("manage_country", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");

                                    if ($country_dtls['id'] != "") {
                                        $country_id = $country_dtls['id'];
                                    } else {
                                        $country_id = $this->admin_model->insert_manage_table("manage_country", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_COUNTRY] = $country_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_CITY) {
                                    $city_dtls = $this->admin_model->get_table_row("manage_city", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($city_dtls['id'] != "") {
                                        $city_id = $city_dtls['id'];
                                    } else {
                                        $city_id = $this->admin_model->insert_manage_table("manage_city", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CITY] = $city_id;
                                }
                                if ($ba_row["id"] == CV_BUSINESS_LEVEL_ID_1) {
                                    $bl1_dtls = $this->admin_model->get_table_row("manage_business_level_1", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($bl1_dtls['id'] != "") {
                                        $bl1_id = $bl1_dtls['id'];
                                    } else {
                                        $bl1_id = $this->admin_model->insert_manage_table("manage_business_level_1", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_BUSINESS_LEVEL_1] = $bl1_id;
                                }
                                if ($ba_row["id"] == CV_BUSINESS_LEVEL_ID_2) {
                                    $bl2_dtls = $this->admin_model->get_table_row("manage_business_level_2", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($bl2_dtls['id'] != "") {
                                        $bl2_id = $bl2_dtls['id'];
                                    } else {
                                        $bl2_id = $this->admin_model->insert_manage_table("manage_business_level_2", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_BUSINESS_LEVEL_2] = $bl2_id;
                                }
                                if ($ba_row["id"] == CV_BUSINESS_LEVEL_ID_3) {
                                    $bl3_dtls = $this->admin_model->get_table_row("manage_business_level_3", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($bl3_dtls['id'] != "") {
                                        $bl3_id = $bl3_dtls['id'];
                                    } else {
                                        $bl3_id = $this->admin_model->insert_manage_table("manage_business_level_3", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_BUSINESS_LEVEL_3] = $bl3_id;
                                }
                                if ($ba_row["id"] == CV_FUNCTION_ID) {
                                    $function_dtls = $this->admin_model->get_table_row("manage_function", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($function_dtls['id'] != "") {
                                        $function_id = $function_dtls['id'];
                                    } else {
                                        $function_id = $this->admin_model->insert_manage_table("manage_function", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_FUNCTION] = $function_id;
                                }
                                if ($ba_row["id"] == CV_SUB_FUNCTION_ID) {
                                    $subfunction_dtls = $this->admin_model->get_table_row("manage_subfunction", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($subfunction_dtls['id'] != "") {
                                        $subfunction_id = $subfunction_dtls['id'];
                                    } else {
                                        $subfunction_id = $this->admin_model->insert_manage_table("manage_subfunction", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_SUBFUNCTION] = $subfunction_id;
                                }
                                if ($ba_row["id"] == CV_SUB_SUB_FUNCTION_ID) {
                                    $sub_subfunction_dtls = $this->admin_model->get_table_row("manage_sub_subfunction", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($sub_subfunction_dtls['id'] != "") {
                                        $sub_subfunction_id = $sub_subfunction_dtls['id'];
                                    } else {
                                        $sub_subfunction_id = $this->admin_model->insert_manage_table("manage_sub_subfunction", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_SUB_SUBFUNCTION] = $sub_subfunction_id;
                                }
                                if ($ba_row["id"] == CV_DESIGNATION_ID) {
                                    $designation_dtls = $this->admin_model->get_table_row("manage_designation", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($designation_dtls['id'] != "") {
                                        $designation_id = $designation_dtls['id'];
                                    } else {
                                        $designation_id = $this->admin_model->insert_manage_table("manage_designation", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_DESIGNATION] = $designation_id;
                                }
                                if ($ba_row["id"] == CV_GRADE_ID) {
                                    $grade_dtls = $this->admin_model->get_table_row("manage_grade", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($grade_dtls['id'] != "") {
                                        $grade_id = $grade_dtls['id'];
                                    } else {
                                        $grade_id = $this->admin_model->insert_manage_table("manage_grade", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_GRADE] = $grade_id;
                                }
                                if ($ba_row["id"] == CV_LEVEL_ID) {
                                    $level_dtls = $this->admin_model->get_table_row("manage_level", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($level_dtls['id'] != "") {
                                        $level_id = $level_dtls['id'];
                                    } else {
                                        $level_id = $this->admin_model->insert_manage_table("manage_level", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_LEVEL] = $level_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_CRITICAL_TALENT) {
                                    $talent_dtls = $this->admin_model->get_table_row("manage_critical_talent", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($talent_dtls['id'] != "") {
                                        $talent_id = $talent_dtls['id'];
                                    } else {
                                        $talent_id = $this->admin_model->insert_manage_table("manage_critical_talent", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CRITICAL_TALENT] = $talent_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_CRITICAL_POSITION) {
                                    $position_dtls = $this->admin_model->get_table_row("manage_critical_position", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($position_dtls['id'] != "") {
                                        $position_id = $position_dtls['id'];
                                    } else {
                                        $position_id = $this->admin_model->insert_manage_table("manage_critical_position", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CRITICAL_POSITION] = $position_id;
                                }
                                if ($ba_row["id"] == CV_CURRENCY_ID) {
                                    $currency_dtls = $this->admin_model->get_table_row("manage_currency", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($currency_dtls['id'] != "") {
                                        $currency_id = $currency_dtls['id'];
                                    } else {
                                        $currency_id = $this->admin_model->insert_manage_table("manage_currency", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CURRENCY] = $currency_id;
                                }

                                if ($ba_row["id"] == CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID) {
                                    $prev_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_rating_dtls['id'] != "") {
                                        $prev_rating_id = $prev_rating_dtls['id'];
                                    } else {
                                        $prev_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_LAST_YEAR] = $prev_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_2ND_LAST_YEAR) {
                                    $prev_2nd_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_2nd_yr_rating_dtls['id'] != "") {
                                        $prev_2nd_yr_rating_id = $prev_2nd_yr_rating_dtls['id'];
                                    } else {
                                        $prev_2nd_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR] = $prev_2nd_yr_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_3RD_LAST_YEAR) {
                                    $prev_3rd_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_3rd_yr_rating_dtls['id'] != "") {
                                        $prev_3rd_yr_rating_id = $prev_3rd_yr_rating_dtls['id'];
                                    } else {
                                        $prev_3rd_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR] = $prev_3rd_yr_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_4TH_LAST_YEAR) {
                                    $prev_4th_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_4th_yr_rating_dtls['id'] != "") {
                                        $prev_4th_yr_rating_id = $prev_4th_yr_rating_dtls['id'];
                                    } else {
                                        $prev_4th_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR] = $prev_4th_yr_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_5TH_LAST_YEAR) {
                                    $prev_5th_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_5th_yr_rating_dtls['id'] != "") {
                                        $prev_5th_yr_rating_id = $prev_5th_yr_rating_dtls['id'];
                                    } else {
                                        $prev_5th_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR] = $prev_5th_yr_rating_id;
                                }

                                if ($ba_row["id"] == CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID) {
                                    $current_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($current_rating_dtls['id'] != "") {
                                        $current_rating_id = $current_rating_dtls['id'];
                                    } else {
                                        $current_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] = $current_rating_id;
                                }
								
								if($ba_row["id"] == CV_BA_ID_COST_CENTER)
								{
                                    $cost_center_dtls = $this->admin_model->get_table_row("manage_cost_center", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($cost_center_dtls['id'] != "")
									{
                                        $cost_center_id = $cost_center_dtls['id'];
                                    }
									else
									{
                                        $cost_center_id = $this->admin_model->insert_manage_table("manage_cost_center", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_COST_CENTER] = $cost_center_id;
                                }
								
								if($ba_row["id"] == CV_BA_ID_EMPLOYEE_TYPE)
								{
                                    $employee_type_dtls = $this->admin_model->get_table_row("manage_employee_type", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($employee_type_dtls['id'] != "")
									{
                                        $employee_type_id = $employee_type_dtls['id'];
                                    }
									else
									{
                                        $employee_type_id = $this->admin_model->insert_manage_table("manage_employee_type", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_EMPLOYEE_TYPE] = $employee_type_id;
                                }
								
								if($ba_row["id"] == CV_BA_ID_EMPLOYEE_ROLE)
								{
                                    $employee_role_dtls = $this->admin_model->get_table_row("manage_employee_role", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($employee_role_dtls['id'] != "")
									{
                                        $employee_role_id = $employee_role_dtls['id'];
                                    }
									else
									{
                                        $employee_role_id = $this->admin_model->insert_manage_table("manage_employee_role", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_EMPLOYEE_ROLE] = $employee_role_id;
                                }

                            } else {
                                $current_date = new DateTime(date('Y-m-d'));
                                if ($ba_row["id"] == 17) {
                                    $dateofjoing = new DateTime($this->input->post("txt_" . $ba_row["id"]));

                                    $differenceofjoing = $current_date->diff($dateofjoing);
                                    $emp_db_arr["tenure_company"] = (string) $differenceofjoing->y;
                                }
                                if ($ba_row["id"] == 18) {
                                    $dateofjoingforsal = new DateTime($this->input->post("txt_" . $ba_row["id"]));

                                    $differenceforsal = $current_date->diff($dateofjoingforsal);
                                    $emp_db_arr["tenure_role"] = (string) $differenceforsal->y;
                                }
                                $emp_db_arr[$ba_row["ba_name"]] = $txt_val;
                            }
                        }
                    }


                    $emp_extra_arr = array(
                        "company_Id" => $this->session->userdata('companyid_ses'),
                        "updatedby" => $this->session->userdata('userid_ses'),
                        "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
                        "updatedon" => date("Y-m-d H:i:s"));
                    $emp_db_arr = array_merge($emp_db_arr, $emp_extra_arr);
                    if (($role == '3' or $role == '4' or $role == '5') and $this->input->post('chk_manage_hr_only') == 1) {
                        $emp_db_arr['manage_hr_only'] = 1;
                    }

                    $this->admin_model->insert_staff($emp_db_arr);
                    $uid = $this->db->insert_id();



                    /* code for mager check start */

                    if ($this->input->post('txt_' . CV_FIRST_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_SECOND_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_THIRD_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_FOURTH_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $uid);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
                            ));
                        }
                    }

                    /* code for mager check end */

                    $verification_url = site_url("verify-account/" . base64_encode($uid) . "/" . base64_encode($email));
                    $mail_body = "Dear " . strtoupper($name) . ",
                    <br /><br />
                    Your Username :" . $email . "<br />
                    <br /><br />
                    <a href=" . $verification_url . ">Click here </a> to set your password for login.<br /><br />";
                    $mail_sub = "Account Details.";
                    //$this->send_emails(CV_EMAIL_FROM, $email, $mail_sub, $mail_body);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_create_success_employee') . '</b></div>');
                }

                $upload_db_arr = array(
                    "original_file_name" => CV_DEFAULT_FILE_NAME,
                    "status" => 1,
                    "upload_date" => date("Y-m-d H:i:s"),
                    "uploaded_by_user_id" => $this->session->userdata('userid_ses'),
                    "createdby_proxy" => $this->session->userdata("proxy_userid_ses"));
                $upload_id = $this->upload_model->insert_uploaded_file_dtls($upload_db_arr);
            } else {
                $this->session->set_flashdata('message', '<<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
                redirect(site_url("add-staff"));
            }
        }

        $data['roles'] = $this->admin_model->get_table("roles", "*", array("id >" => 2));
        $data['title'] = "Add Employee";
        $data['body'] = "admin/add_staff";
        $this->load->view('common/structure', $data);
    }

    public function view_emoloye($user_id) {

        $allowed_user_role_id   =  array(10,11); //manager & employee
        $allowed_hr_role_id     =  array(2,3,4,5,6,7,8,9); //manager & employee
        $show_breadcrumb        = true;

        if (in_array($this->user_role_id, $allowed_user_role_id) || in_array($this->user_role_id, $allowed_hr_role_id)) {//check if user manager, employee or hr

            $allowed_users      = array();
            $show_breadcrumb    = false;

            if ($this->user_role_id == 10) {//manager

                $this->load->model("manager_model");

                $allowed_users[] = $this->user_id;

                $manager_email = $this->session->userdata('email_ses');
                $fields        = 'id';
                $table         = 'login_user';
                $condition_arr = '';//['login_user.'.CV_BA_NAME_APPROVER_1 => $manager_email];
                $or_condition_arr = ['login_user.'.CV_BA_NAME_APPROVER_1 => $manager_email, 'login_user.'.CV_BA_NAME_APPROVER_2 => $manager_email, 'login_user.'.CV_BA_NAME_APPROVER_3 => $manager_email, 'login_user.'.CV_BA_NAME_APPROVER_4 => $manager_email];
                $order_by      = 'id';

                $emp_list = $this->manager_model->get_table_rows($table, $fields, $condition_arr, $or_condition_arr, $order_by, true);

                if (!empty($emp_list)) {

                    foreach($emp_list as $emp_data) {

                        $allowed_users[] = $emp_data['id'];

                    }

                }

            } else if (in_array($this->user_role_id, $allowed_hr_role_id)) {//hr

                $allowed_users[] = $this->user_id;
                $emp_list = $this->session->userdata('hr_usr_ids_ses');

                if (!empty($emp_list)) {

                    $emp_list = explode(',', $emp_list);
                    $allowed_users = array_merge($allowed_users, $emp_list);

                }
            } else if ($this->user_role_id == 11) { //employee

                $allowed_users[] = $this->user_id;

            }

            if (!in_array($user_id, $allowed_users)) {

                redirect(site_url("dashboard"));

            }

        }

        //below cond not check for employee
        if (!($this->user_role_id == 11 && $this->user_id == $user_id) && !helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_edit_right') . '</b></div>');
            redirect(site_url("staff"));
        }

        $data['msg'] = "";
        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
        }
        $data['attributes'] = $this->admin_model->staffattributes(array("module_name !=" => $ba_not_for));


        if ($_FILES['emp_img']['name']) {
            $upload_arr = HLP_upload_img('emp_img', "uploads/imp_employee/", 1024);
            if (count($upload_arr) == 2) {
                $f_path = 'uploads/imp_employee/' . $upload_arr[0];
                $this->admin_model->update_tbl_data("login_user", array("pic_url" => $f_path), array("id" => $user_id));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $upload_arr[0] . '</b></div>');
                redirect(site_url("view-emoloye/" . $user_id));
            }
        }
        $attribu_Data = $this->admin_model->staff_attributes_for_export();
        foreach ($attribu_Data as $val) {

            if (in_array($val['id'], array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_EDUCATION, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_BA_ID_SPECIAL_CATEGORY, CV_CURRENCY_ID, CV_SUB_SUB_FUNCTION_ID, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE))) {

                $str[] = " manage_" . $val['ba_name'] . ".name as " . $val['ba_name'];
            }
            elseif($val['id']==CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_2ND_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_3RD_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_4TH_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_5TH_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR ;
            }
            elseif($val['id']==CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_CURRENT_YEAR;
            }
            else
            {
                $str[] = " login_user." . $val['ba_name'];
            }
        }
        $strdata = implode(",", $str);
        $strdata .= ",login_user.role as role";

        $data['staffDetail'] = $this->admin_model->get_staff_Details($strdata, $user_id);
//        $tupleData = $this->admin_model->staffDetails($user_id);
//        $data['staffDetail'] = $this->admin_model->completeStafDetails(array('row_num' => $tupleData['row_num'], 'data_upload_id' => $tupleData['data_upload_id']));

        $data['roles'] = $this->admin_model->get_table("roles", "*", array("id >" => 2));
        $data['title'] = "Employee Detail";
        $data['uri_key'] = "view-emoloye";
        $data['body'] = "admin/view_staff";
        $data['userid'] = $user_id;
        $data['show_breadcrumb'] = $show_breadcrumb ?? false;
        $this->load->view('common/structure', $data);
    }

    public function edit_employee($user_id) {
        if (!helper_have_rights(CV_STAFF_ID, CV_UPDATE_RIGHT_NAME)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_edit_right') . '</b></div>');
            redirect(site_url("staff"));
        }

        $data['msg'] = "";
        $ba_not_for = CV_MARKET_SALARY_CTC_ELEMENT;
        if ($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT) {
            $ba_not_for = CV_MARKET_SALARY_ELEMENT;
        }
        $data['attributes'] = $this->admin_model->staffattributes(array("module_name !=" => $ba_not_for));

        if ($this->input->post()) {
            $this->form_validation->set_rules("txt_" . CV_EMP_NAME_ID, 'Name', 'trim|required|max_length[50]');

            $this->form_validation->set_rules('ddl_role', 'Role', 'trim|required');
            if ($this->form_validation->run()) {
                // Check all requireds, emails and numerics type validations Start -------------------
                $req_ba_list = $this->upload_model->get_table_row("business_attribute", "GROUP_CONCAT(CONCAT(id)) AS ba_ids, (select GROUP_CONCAT(CONCAT(id)) FROM `business_attribute` WHERE `data_type_code`='NUMERIC') AS numeric_ba_ids", array("status" => 1, 'is_required' => 1));
                $requiredFields = explode(",", $req_ba_list["ba_ids"]);
                $numeric_ba_ids_arr = explode(",", $req_ba_list["numeric_ba_ids"]);

                $err_str = "";
                foreach ($data['attributes'] as $ba_key => $ba_value) {
                    foreach ($ba_value as $ba_row) {
                        $txtVal = trim($this->input->post("txt_" . $ba_row["id"]));

                        if (in_array($ba_row["id"], $requiredFields) and $txtVal == "") {
                            $err_str .= $ba_row["display_name"] . " can not be a null value.</br>";
                            //break;
                        }

                        if (in_array($ba_row["id"], $numeric_ba_ids_arr) and $txtVal != "") {
                            $txtVal = str_replace(array(",", " "), "", $txtVal);
                            if (!$this->form_validation->numeric($txtVal)) {
                                $err_str .= $ba_row["display_name"] . " should have numeric values only.</br>";
                                //break;
                            }
                        }
                    }
                }

                if ($err_str != "") {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $err_str . '</b></div>');
                    redirect(site_url("edit-employee/" . $user_id));
                }

                // Check all requireds, emails and numerics type validations End -------------------

                $name = trim($this->input->post("txt_" . CV_EMP_NAME_ID));

                //$pwd = $this->input->post('txt_pwd');
                //$user_designation = $this->input->post('ddl_user_designation');
                $role = $this->input->post('ddl_role');
                $user_dtls = $this->admin_model->get_table_row("login_user", "id", array("id" => $user_id), "id desc");
                $is_new_usr = 1; //0=No,1=Yes
                if ($user_dtls) {
                    $emp_db_arr = array();
                    foreach ($data['attributes'] as $ba_key => $ba_value) {
                        foreach ($ba_value as $ba_row) {
                            $txt_val = trim($this->input->post("txt_" . $ba_row["id"])) . "";

                            $m_ba_id_arr = array(CV_EMAIL_ID, CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_SUB_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_CURRENCY_ID, CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID, CV_BA_ID_RATING_FOR_2ND_LAST_YEAR, CV_BA_ID_RATING_FOR_3RD_LAST_YEAR, CV_BA_ID_RATING_FOR_4TH_LAST_YEAR, CV_BA_ID_RATING_FOR_5TH_LAST_YEAR, CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, CV_BA_ID_EDUCATION, CV_BA_ID_SPECIAL_CATEGORY, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE);

                            if (in_array($ba_row["id"], $m_ba_id_arr)) {

                                if ($ba_row["id"] == CV_BA_ID_COUNTRY) {

                                    $country_dtls = $this->admin_model->get_table_row("manage_country", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");

                                    if ($country_dtls['id'] != "") {
                                        $country_id = $country_dtls['id'];
                                    } else {
                                        $country_id = $this->admin_model->insert_manage_table("manage_country", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_COUNTRY] = $country_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_CITY) {
                                    $city_dtls = $this->admin_model->get_table_row("manage_city", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($city_dtls['id'] != "") {
                                        $city_id = $city_dtls['id'];
                                    } else {
                                        $city_id = $this->admin_model->insert_manage_table("manage_city", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CITY] = $city_id;
                                }
                                if ($ba_row["id"] == CV_BUSINESS_LEVEL_ID_1) {
                                    $bl1_dtls = $this->admin_model->get_table_row("manage_business_level_1", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($bl1_dtls['id'] != "") {
                                        $bl1_id = $bl1_dtls['id'];
                                    } else {
                                        $bl1_id = $this->admin_model->insert_manage_table("manage_business_level_1", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_BUSINESS_LEVEL_1] = $bl1_id;
                                }
                                if ($ba_row["id"] == CV_BUSINESS_LEVEL_ID_2) {
                                    $bl2_dtls = $this->admin_model->get_table_row("manage_business_level_2", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($bl2_dtls['id'] != "") {
                                        $bl2_id = $bl2_dtls['id'];
                                    } else {
                                        $bl2_id = $this->admin_model->insert_manage_table("manage_business_level_2", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_BUSINESS_LEVEL_2] = $bl2_id;
                                }
                                if ($ba_row["id"] == CV_BUSINESS_LEVEL_ID_3) {
                                    $bl3_dtls = $this->admin_model->get_table_row("manage_business_level_3", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($bl3_dtls['id'] != "") {
                                        $bl3_id = $bl3_dtls['id'];
                                    } else {
                                        $bl3_id = $this->admin_model->insert_manage_table("manage_business_level_3", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_BUSINESS_LEVEL_3] = $bl3_id;
                                }
                                if ($ba_row["id"] == CV_FUNCTION_ID) {
                                    $function_dtls = $this->admin_model->get_table_row("manage_function", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($function_dtls['id'] != "") {
                                        $function_id = $function_dtls['id'];
                                    } else {
                                        $function_id = $this->admin_model->insert_manage_table("manage_function", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_FUNCTION] = $function_id;
                                }
                                if ($ba_row["id"] == CV_SUB_FUNCTION_ID) {
                                    $subfunction_dtls = $this->admin_model->get_table_row("manage_subfunction", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($subfunction_dtls['id'] != "") {
                                        $subfunction_id = $subfunction_dtls['id'];
                                    } else {
                                        $subfunction_id = $this->admin_model->insert_manage_table("manage_subfunction", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_SUBFUNCTION] = $subfunction_id;
                                }
                                if ($ba_row["id"] == CV_SUB_SUB_FUNCTION_ID) {
                                    $sub_subfunction_dtls = $this->admin_model->get_table_row("manage_sub_subfunction", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($sub_subfunction_dtls['id'] != "") {
                                        $sub_subfunction_id = $sub_subfunction_dtls['id'];
                                    } else {
                                        $sub_subfunction_id = $this->admin_model->insert_manage_table("manage_sub_subfunction", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_SUB_SUBFUNCTION] = $sub_subfunction_id;
                                }
                                if ($ba_row["id"] == CV_DESIGNATION_ID) {
                                    $designation_dtls = $this->admin_model->get_table_row("manage_designation", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($designation_dtls['id'] != "") {
                                        $designation_id = $designation_dtls['id'];
                                    } else {
                                        $designation_id = $this->admin_model->insert_manage_table("manage_designation", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_DESIGNATION] = $designation_id;
                                }
                                if ($ba_row["id"] == CV_GRADE_ID) {
                                    $grade_dtls = $this->admin_model->get_table_row("manage_grade", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($grade_dtls['id'] != "") {
                                        $grade_id = $grade_dtls['id'];
                                    } else {
                                        $grade_id = $this->admin_model->insert_manage_table("manage_grade", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_GRADE] = $grade_id;
                                }
                                if ($ba_row["id"] == CV_LEVEL_ID) {
                                    $level_dtls = $this->admin_model->get_table_row("manage_level", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($level_dtls['id'] != "") {
                                        $level_id = $level_dtls['id'];
                                    } else {
                                        $level_id = $this->admin_model->insert_manage_table("manage_level", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_LEVEL] = $level_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_CRITICAL_TALENT) {
                                    $talent_dtls = $this->admin_model->get_table_row("manage_critical_talent", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($talent_dtls['id'] != "") {
                                        $talent_id = $talent_dtls['id'];
                                    } else {
                                        $talent_id = $this->admin_model->insert_manage_table("manage_critical_talent", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CRITICAL_TALENT] = $talent_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_CRITICAL_POSITION) {
                                    $position_dtls = $this->admin_model->get_table_row("manage_critical_position", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($position_dtls['id'] != "") {
                                        $position_id = $position_dtls['id'];
                                    } else {
                                        $position_id = $this->admin_model->insert_manage_table("manage_critical_position", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CRITICAL_POSITION] = $position_id;
                                }
                                if ($ba_row["id"] == CV_CURRENCY_ID) {
                                    $currency_dtls = $this->admin_model->get_table_row("manage_currency", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($currency_dtls['id'] != "") {
                                        $currency_id = $currency_dtls['id'];
                                    } else {
                                        $currency_id = $this->admin_model->insert_manage_table("manage_currency", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_CURRENCY] = $currency_id;
                                }

                                if ($ba_row["id"] == CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID) {
                                    $prev_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_rating_dtls['id'] != "") {
                                        $prev_rating_id = $prev_rating_dtls['id'];
                                    } else {
                                        $prev_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_LAST_YEAR] = $prev_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_2ND_LAST_YEAR) {
                                    $prev_2nd_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_2nd_yr_rating_dtls['id'] != "") {
                                        $prev_2nd_yr_rating_id = $prev_2nd_yr_rating_dtls['id'];
                                    } else {
                                        $prev_2nd_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR] = $prev_2nd_yr_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_3RD_LAST_YEAR) {
                                    $prev_3rd_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_3rd_yr_rating_dtls['id'] != "") {
                                        $prev_3rd_yr_rating_id = $prev_3rd_yr_rating_dtls['id'];
                                    } else {
                                        $prev_3rd_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR] = $prev_3rd_yr_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_4TH_LAST_YEAR) {
                                    $prev_4th_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_4th_yr_rating_dtls['id'] != "") {
                                        $prev_4th_yr_rating_id = $prev_4th_yr_rating_dtls['id'];
                                    } else {
                                        $prev_4th_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR] = $prev_4th_yr_rating_id;
                                }
                                if ($ba_row["id"] == CV_BA_ID_RATING_FOR_5TH_LAST_YEAR) {
                                    $prev_5th_yr_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($prev_5th_yr_rating_dtls['id'] != "") {
                                        $prev_5th_yr_rating_id = $prev_5th_yr_rating_dtls['id'];
                                    } else {
                                        $prev_5th_yr_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR] = $prev_5th_yr_rating_id;
                                }

                                if ($ba_row["id"] == CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID) {
                                    $current_rating_dtls = $this->admin_model->get_table_row("manage_rating_for_current_year", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($current_rating_dtls['id'] != "") {
                                        $current_rating_id = $current_rating_dtls['id'];
                                    } else {
                                        $current_rating_id = $this->admin_model->insert_manage_table("manage_rating_for_current_year", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] = $current_rating_id;
                                }

                                /* for education */
                                if ($ba_row["id"] == CV_BA_ID_EDUCATION) {
                                    $education_dtls = $this->admin_model->get_table_row("manage_education", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($education_dtls['id'] != "") {
                                        $education_id = $education_dtls['id'];
                                    } else {
                                        $education_id = $this->admin_model->insert_manage_table("manage_education", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_EDUCATION] = $education_id;
                                }

                                /* for special category */
                                if ($ba_row["id"] == CV_BA_ID_SPECIAL_CATEGORY) {
                                    $special_category_dtls = $this->admin_model->get_table_row("manage_special_category", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($special_category_dtls['id'] != "") {
                                        $special_category_id = $special_category_dtls['id'];
                                    } else {
                                        $special_category_id = $this->admin_model->insert_manage_table("manage_special_category", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_SPECIAL_CATEGORY] = $special_category_id;
                                }
								
								if($ba_row["id"] == CV_BA_ID_COST_CENTER)
								{
                                    $cost_center_dtls = $this->admin_model->get_table_row("manage_cost_center", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($cost_center_dtls['id'] != "")
									{
                                        $cost_center_id = $cost_center_dtls['id'];
                                    }
									else
									{
                                        $cost_center_id = $this->admin_model->insert_manage_table("manage_cost_center", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_COST_CENTER] = $cost_center_id;
                                }
								
								if($ba_row["id"] == CV_BA_ID_EMPLOYEE_TYPE)
								{
                                    $employee_type_dtls = $this->admin_model->get_table_row("manage_employee_type", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($employee_type_dtls['id'] != "")
									{
                                        $employee_type_id = $employee_type_dtls['id'];
                                    }
									else
									{
                                        $employee_type_id = $this->admin_model->insert_manage_table("manage_employee_type", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_EMPLOYEE_TYPE] = $employee_type_id;
                                }
								
								if($ba_row["id"] == CV_BA_ID_EMPLOYEE_ROLE)
								{
                                    $employee_role_dtls = $this->admin_model->get_table_row("manage_employee_role", "id", array("name" => $this->input->post("txt_" . $ba_row["id"])), "id desc");
                                    if ($employee_role_dtls['id'] != "")
									{
                                        $employee_role_id = $employee_role_dtls['id'];
                                    }
									else
									{
                                        $employee_role_id = $this->admin_model->insert_manage_table("manage_employee_role", array("name" => $this->input->post("txt_" . $ba_row["id"])));
                                    }
                                    $emp_db_arr[CV_BA_NAME_EMPLOYEE_ROLE] = $employee_role_id;
                                }

                            } else {
                                $current_date = new DateTime(date('Y-m-d'));
                                if ($ba_row["id"] == 17) {
                                    $dateofjoing = new DateTime($this->input->post("txt_" . $ba_row["id"]));

                                    $differenceofjoing = $current_date->diff($dateofjoing);
                                    $emp_db_arr["tenure_company"] = (string) $differenceofjoing->y;
                                }
                                if ($ba_row["id"] == 18) {
                                    $dateofjoingforsal = new DateTime($this->input->post("txt_" . $ba_row["id"]));

                                    $differenceforsal = $current_date->diff($dateofjoingforsal);
                                    $emp_db_arr["tenure_role"] = (string) $differenceforsal->y;
                                }
                                $emp_db_arr[$ba_row["ba_name"]] = $txt_val;
                            }
                        }
                    }


                    $emp_extra_arr = array(
                        "company_Id" => $this->session->userdata('companyid_ses'),
                        "createdby" => $this->session->userdata('userid_ses'),
                        "updatedby" => $this->session->userdata('userid_ses'),
                        "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                        "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
                        "createdon" => date("Y-m-d H:i:s"),
                        "updatedon" => date("Y-m-d H:i:s"));
                    $emp_db_arr = array_merge($emp_db_arr, $emp_extra_arr);
                    if (($role == '3' or $role == '4' or $role == '5') and $this->input->post('chk_manage_hr_only') == 1) {
                        $emp_db_arr['manage_hr_only'] = 1;
                    }
                    //piy@20Jan
                    $this->load->model("user_model");
                    $this->user_model->create_users_history(array("id" => $user_id));
                    $this->admin_model->update_tbl_data("login_user", $emp_db_arr, array("id" => $user_id));
                    /* code for mager check start */

                    if ($this->input->post('txt_' . CV_FIRST_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FIRST_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_SECOND_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_SECOND_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_THIRD_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_THIRD_APPROVER_ID)
                            ));
                        }
                    }
                    if ($this->input->post('txt_' . CV_FOURTH_APPROVER_ID) != '') {
                        $ap_dtls = $this->admin_model->get_table_row("login_user", "role", array("email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)), "id desc");
                        $ap_role = $ap_dtls["role"];
                        if (setManager($ap_role)) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
                            ));
                        }
                        if ($ap_role == 11) {
                            $this->rule_model->manage_users_history("id=" . $user_id);
                            $this->admin_model->update_tbl_data("login_user", array(
                                "role" => '10',
                                "is_manager" => '1',
                            ), array(
                                "email" => $this->input->post('txt_' . CV_FOURTH_APPROVER_ID)
                            ));
                        }
                    }
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_edit_success_employee') . '</b></div>');
                } else {
                    redirect(site_url("edit-employee/" . $user_id));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
                redirect(site_url("edit-employee/" . $user_id));
            }
        }

        $attribu_Data = $this->admin_model->staff_attributes_for_export();
        foreach ($attribu_Data as $val) {

            if (in_array($val['id'], array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_EDUCATION, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_BA_ID_SPECIAL_CATEGORY, CV_CURRENCY_ID, CV_SUB_SUB_FUNCTION_ID, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE))) {

                $str[] = " manage_" . $val['ba_name'] . ".name as " . $val['ba_name'];
            }
            elseif($val['id']==CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_2ND_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_3RD_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_4TH_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR ;
            }
            elseif($val['id']==CV_BA_ID_RATING_FOR_5TH_LAST_YEAR)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR ;
            }
            elseif($val['id']==CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID)
            {
                $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_CURRENT_YEAR;
            }
            else {
                $str[] = " login_user." . $val['ba_name'];
            }
        }
        $strdata = implode(",", $str);
        $strdata .= ",login_user.role as role";

        $data['staffDetail'] = $this->admin_model->get_staff_Details($strdata, $user_id);
        $data['roles'] = $this->admin_model->get_table("roles", "*", array("id >" => 2));
        $data['title'] = "Edit Employee";
        $data['body'] = "admin/add_staff";
        $this->load->view('common/structure', $data);
    }

    public function add_hr() {
        $role_select = '';
        $check_role = json_decode(CV_VIEW_ROLE_ARRAY);
        if ($this->uri->segment('2')) {
            if (in_array($this->uri->segment('2'), $check_role)) {
                $role_select = $this->uri->segment('2');
            } else {
                $role_select = '';
            }
        }

        $data['role_select'] = $role_select;

        if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
            redirect(site_url("staff"));
        }

        $data['msg'] = "";

        if ($this->input->post()) {
            if (!$this->input->post("hf_select_all_filters")) {
                $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('txt_email', 'Email', 'trim|required|max_length[50]|valid_email');
                $this->form_validation->set_rules('ddl_role', 'Role', 'trim|required');
                if ($this->form_validation->run()) {

                    $email_arr = explode('@', $this->input->post("txt_email"));
                    if (strtolower(end($email_arr)) != strtolower($this->session->userdata('domainname_ses'))) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please enter your domain related email only.</b></div>');
                        redirect(site_url("add-hr"));
                    }

                    if (in_array('0', $this->input->post("ddl_country"))) {
                        $country_arr = 0;
                    } else {
                        $country_arr = implode(",", $this->input->post("ddl_country"));
                    }

                    if (in_array('0', $this->input->post("ddl_city"))) {
                        $city_arr = 0;
                    } else {
                        $city_arr = implode(",", $this->input->post("ddl_city"));
                    }

                    if (in_array('0', $this->input->post("ddl_bussiness_level_1"))) {
                        $bussiness_level_1_arr = 0;
                    } else {
                        $bussiness_level_1_arr = implode(",", $this->input->post("ddl_bussiness_level_1"));
                    }

                    if (in_array('0', $this->input->post("ddl_bussiness_level_2"))) {
                        $bussiness_level_2_arr = 0;
                    } else {
                        $bussiness_level_2_arr = implode(",", $this->input->post("ddl_bussiness_level_2"));
                    }

                    if (in_array('0', $this->input->post("ddl_bussiness_level_3"))) {
                        $bussiness_level_3_arr = 0;
                    } else {
                        $bussiness_level_3_arr = implode(",", $this->input->post("ddl_bussiness_level_3"));
                    }

                    if (in_array('0', $this->input->post("ddl_function"))) {
                        $function_arr = 0;
                    } else {
                        $function_arr = implode(",", $this->input->post("ddl_function"));
                    }

                    if (in_array('0', $this->input->post("ddl_sub_function"))) {
                        $sub_function_arr = 0;
                    } else {
                        $sub_function_arr = implode(",", $this->input->post("ddl_sub_function"));
                    }

                    if (in_array('0', $this->input->post("ddl_sub_subfunction"))) {
                        $sub_subfunction_arr = 0;
                    } else {
                        $sub_subfunction_arr = implode(",", $this->input->post("ddl_sub_subfunction"));
                    }

                    if (in_array('0', $this->input->post("ddl_designation"))) {
                        $designation_arr = 0;
                    } else {
                        $designation_arr = implode(",", $this->input->post("ddl_designation"));
                    }

                    if (in_array('0', $this->input->post("ddl_grade"))) {
                        $grade_arr = 0;
                    } else {
                        $grade_arr = implode(",", $this->input->post("ddl_grade"));
                    }

                    if (in_array('0', $this->input->post("ddl_level"))) {
                        $level_arr = 0;
                    } else {
                        $level_arr = implode(",", $this->input->post("ddl_level"));
                    }

                    $name = trim($this->input->post('txt_name'));
                    $email = trim($this->input->post('txt_email'));
                    $role = $this->input->post('ddl_role');
                    $rights_for_user_id = "";

                    $user_dtls = $this->admin_model->get_table_row("login_user", "id,role", array("email" => $email), "id desc");
                    if ($user_dtls) {
                        $rights_for_user_id = $user_dtls["id"];
                    }

                    $is_rights_conflict = $this->admin_model->check_user_rights_conflicts($rights_for_user_id, $role, $country_arr, $city_arr, $bussiness_level_1_arr, $bussiness_level_2_arr, $bussiness_level_3_arr, $function_arr, $sub_function_arr, $sub_subfunction_arr, $designation_arr, $grade_arr, $level_arr);
                    if ($is_rights_conflict) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Selected rights are conflict with others.</b></div>');
                        redirect(site_url("add-hr"));
                    }



                    if ($user_dtls) {
                        if (!helper_have_rights(CV_STAFF_ID, CV_UPDATE_RIGHT_NAME)) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have update rights.</b></div>');
                            redirect(site_url("staff"));
                        }

                        $uid = $user_dtls["id"];
                        if (setManager($user_dtls['role'])) {
                            $this->admin_model->update_tbl_data("login_user", array("is_manager" => '1', "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array("id" => $uid));
                        }
                        $this->admin_model->update_tbl_data("login_user", array("name" => $name, "role" => $role, "updatedby" => $this->session->userdata('userid_ses'), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'), "updatedon" => date("Y-m-d H:i:s")), array("id" => $uid));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid user. Please select a valid user.</b></div>');
                        redirect(site_url("add-hr"));
                        /* $staff_db_arr = array(
                          "name"=>$name,
                          "email"=>$email,
                          "role"=>$role,
                          "company_Id"=>$this->session->userdata('companyid_ses'),
                          "createdby" =>$this->session->userdata('userid_ses'),
                          "updatedby"=>$this->session->userdata('userid_ses'),
                          "createdby_proxy" =>$this->session->userdata('proxy_userid_ses'),
                          "updatedby_proxy"=>$this->session->userdata('proxy_userid_ses'),
                          "createdon" =>date("Y-m-d H:i:s"),
                          "updatedon"=>date("Y-m-d H:i:s"));
                          $this->admin_model->insert_staff($staff_db_arr);
                          $uid = $this->db->insert_id();

                          $verification_url = site_url("verify-account/".base64_encode($uid)."/".base64_encode($email));
                          $mail_body = "Dear ".strtoupper($name).",
                          <br /><br />
                          Your Username :".$email."<br />
                          <br /><br />
                          <a href=".$verification_url.">Click here </a> to set your password for login.<br /><br />";
                          $mail_sub = "Account Details.";
                          $this->send_emails(CV_EMAIL_FROM,$email, $mail_sub, $mail_body);
                          $this->session->set_flashdata('message', '<div align="left" style="color:blue;" id="notify"><span><b>New HR member created successfully.</b></span></div>');
                         */
                      }

                      $this->admin_model->update_tbl_data("rights_on_country", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_city", array("status" => 2), array("user_id" => $uid, "status" => 1));

                      $this->admin_model->update_tbl_data("rights_on_business_level_1", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_business_level_2", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_business_level_3", array("status" => 2), array("user_id" => $uid, "status" => 1));

                      $this->admin_model->update_tbl_data("rights_on_functions", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_sub_functions", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_sub_subfunctions", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_designations", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_grades", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      $this->admin_model->update_tbl_data("rights_on_levels", array("status" => 2), array("user_id" => $uid, "status" => 1));
                      if (in_array('0', $this->input->post("ddl_country"))) {
                        $db_arr = array(
                            "user_id" => $uid,
                            "country_id" => 0,
                            "createdby" => $this->session->userdata('userid_ses'),
                            "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                            "createdon" => date("Y-m-d H:i:s")
                        );
                        $this->admin_model->insert_data_in_tbl("rights_on_country", $db_arr);
                    } else {
                        foreach ($_REQUEST['ddl_country'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "country_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_country", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_city"))) {
                        foreach ($_REQUEST['ddl_city'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "city_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_city", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_city'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "city_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_city", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_bussiness_level_1"))) {
                        foreach ($_REQUEST['ddl_bussiness_level_1'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "business_level_1_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_business_level_1", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_bussiness_level_1'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "business_level_1_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_business_level_1", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_bussiness_level_2"))) {
                        foreach ($_REQUEST['ddl_bussiness_level_2'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "business_level_2_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_business_level_2", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_bussiness_level_2'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "business_level_2_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_business_level_2", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_bussiness_level_3"))) {
                        foreach ($_REQUEST['ddl_bussiness_level_3'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "business_level_3_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_business_level_3", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_bussiness_level_3'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "business_level_3_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_business_level_3", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_function"))) {
                        foreach ($_REQUEST['ddl_function'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "function_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_functions", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_function'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "function_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_functions", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_sub_function"))) {
                        foreach ($_REQUEST['ddl_sub_function'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "sub_function_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_sub_functions", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_sub_function'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "sub_function_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_sub_functions", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_sub_subfunction"))) {
                        foreach ($_REQUEST['ddl_sub_subfunction'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "sub_subfunction_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_sub_subfunctions", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_sub_subfunction'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "sub_subfunction_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_sub_subfunctions", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_designation"))) {
                        foreach ($_REQUEST['ddl_designation'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "designation_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_designations", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_designation'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "designation_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_designations", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_grade"))) {
                        foreach ($_REQUEST['ddl_grade'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "grade_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_grades", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_grade'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "grade_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_grades", $db_arr);
                        }
                    }

                    if (in_array('0', $this->input->post("ddl_level"))) {
                        foreach ($_REQUEST['ddl_level'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "level_id" => 0,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_levels", $db_arr);
                        }
                    } else {
                        foreach ($_REQUEST['ddl_level'] as $key => $value) {
                            $db_arr = array(
                                "user_id" => $uid,
                                "level_id" => $value,
                                "createdby" => $this->session->userdata('userid_ses'),
                                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                                "createdon" => date("Y-m-d H:i:s")
                            );
                            $this->admin_model->insert_data_in_tbl("rights_on_levels", $db_arr);
                        }
                    }
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New rights created successfully.</b></div>');
                    redirect(site_url("add-hr"));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
                    redirect(site_url("add-hr"));
                }
            }
        }

        $data['country_list'] = $this->admin_model->get_table("manage_country", "id, name", array("status" => 1));
        /* if(!$data['country_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active country for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */

      $data['city_list'] = $this->admin_model->get_table("manage_city", "id, name", array("status" => 1));
        /* if(!$data['city_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active city for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */

      $data['bussiness_level_1_list'] = $this->admin_model->get_table("manage_business_level_1", "id, name", array("status" => 1));
      $data['bussiness_level_2_list'] = $this->admin_model->get_table("manage_business_level_2", "id, name", array("status" => 1));
      $data['bussiness_level_3_list'] = $this->admin_model->get_table("manage_business_level_3", "id, name", array("status" => 1));

        /* if(!$data['bussiness_unit_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active business units for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */

      $data['designation_list'] = $this->admin_model->get_table("manage_designation", "id, name", array("status" => 1));
        /* if(!$data['designation_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active designations for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */

      $data['function_list'] = $this->admin_model->get_table("manage_function", "id, name", array("status" => 1));
        /* if(!$data['function_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active functions for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */

      $data['sub_function_list'] = $this->admin_model->get_table("manage_subfunction", "id, name", array("status" => 1));
      $data['sub_subfunction_list'] = $this->admin_model->get_table("manage_sub_subfunction", "id, name", array("status" => 1));
        /* if(!$data['sub_function_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active sub functions for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */

      $data['grade_list'] = $this->admin_model->get_table("manage_grade", "id, name", array("status" => 1));
      $data['level_list'] = $this->admin_model->get_table("manage_level", "id, name", array("status" => 1));
        /* if(!$data['grade_list'])
          {
          $this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>You must have active grades for creating HR Rights.</b></span></div>");
          redirect(site_url("hr-list"));
      } */
      $data['roles'] = $this->admin_model->get_table("roles", "*", array("id >" => 2, "id <" => 10));
      $data['title'] = "Add HR";
      $data['body'] = "admin/add_hr";
      $this->load->view('common/structure', $data);
  }

  public function check_email_exist() {
    if (trim($this->input->post("email_id"))) {
        $user_dtls = $this->admin_model->get_table_row("login_user", "id, name", array("email" => trim($this->input->post("email_id"))), "id desc");
        if ($user_dtls) {
            $right_dtls = $this->admin_model->get_table_row("rights_on_country", "*", array("status" => 1, "user_id" => $user_dtls["id"]), "id desc");
            if ($right_dtls) {
                $response = array("status" => 3, "emp_name" => $user_dtls["name"]);
                echo json_encode($response);
                die;
            } else {
                $response = array("status" => 2, "emp_name" => $user_dtls["name"]);
                echo json_encode($response);
                die;
            }
        } else {
            echo false;
        }
    } else {
        echo false;
    }
}

public function change_employee_status($user_id, $status, $redirect_url) {
    if ($redirect_url != "staff" and $redirect_url != "hr-list") {
        $redirect_url = "staff";
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_UPDATE_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_edit_right') . '</b></div>');
        redirect(site_url($redirect_url));
    }

    if ($status) {
        $user_cntry_arr = $this->admin_model->get_table("rights_on_country", "country_id", array("status" => 1, "user_id" => $user_id));
        if ($user_cntry_arr) {
            $country_arr = $this->common_model->array_value_recursive("country_id", $user_cntry_arr);

            if (count($country_arr) > 1) {
                $country_arr = implode(",", $country_arr);
            }

            $user_city_arr = $this->admin_model->get_table("rights_on_city", "city_id", array("status" => 1, "user_id" => $user_id));
            $city_arr = $this->common_model->array_value_recursive("city_id", $user_city_arr);
            if (count($city_arr) > 1) {
                $city_arr = implode(",", $city_arr);
            }

            $user_bl1_arr = $this->admin_model->get_table("rights_on_business_level_1", "business_level_1_id", array("status" => 1, "user_id" => $user_id));
            $bussiness_level_1_arr = $this->common_model->array_value_recursive("business_level_1_id", $user_bl1_arr);
            if (count($bussiness_level_1_arr) > 1) {
                $bussiness_level_1_arr = implode(",", $bussiness_level_1_arr);
            }
//echo "<pre>";print_r();die;
            $user_bl2_arr = $this->admin_model->get_table("rights_on_business_level_2", "business_level_2_id", array("status" => 1, "user_id" => $user_id));
            $bussiness_level_2_arr = $this->common_model->array_value_recursive("business_level_2_id", $user_bl2_arr);
            if (count($bussiness_level_2_arr) > 1) {
                $bussiness_level_2_arr = implode(",", $bussiness_level_2_arr);
            }

            $user_bl3_arr = $this->admin_model->get_table("rights_on_business_level_3", "business_level_3_id", array("status" => 1, "user_id" => $user_id));
            $bussiness_level_3_arr = $this->common_model->array_value_recursive("business_level_3_id", $user_bl3_arr);
            if (count($bussiness_level_3_arr) > 1) {
                $bussiness_level_3_arr = implode(",", $bussiness_level_3_arr);
            }

            $user_funct_arr = $this->admin_model->get_table("rights_on_functions", "function_id", array("status" => 1, "user_id" => $user_id));
            $function_arr = $this->common_model->array_value_recursive("function_id", $user_funct_arr);
            if (count($function_arr) > 1) {
                $function_arr = implode(",", $function_arr);
            }

            $user_sub_funct_arr = $this->admin_model->get_table("rights_on_sub_functions", "sub_function_id", array("status" => 1, "user_id" => $user_id));
            $sub_function_arr = $this->common_model->array_value_recursive("sub_function_id", $user_sub_funct_arr);
            if (count($sub_function_arr) > 1) {
                $sub_function_arr = implode(",", $sub_function_arr);
            }
            //piy@20jan
            $user_sub_subfunct_arr = $this->admin_model->get_table("rights_on_sub_subfunctions", "sub_subfunction_id", array("status" => 1, "user_id" => $user_id));
            $sub_subfunction_arr = $this->common_model->array_value_recursive("sub_subfunction_id", $user_sub_subfunct_arr);
            if (count($sub_function_arr) > 1) {
                $sub_subfunction_arr = implode(",", $sub_subfunction_arr);
            }

            $user_desig_arr = $this->admin_model->get_table("rights_on_designations", "designation_id", array("status" => 1, "user_id" => $user_id));
            $designation_arr = $this->common_model->array_value_recursive("designation_id", $user_desig_arr);
            if (count($designation_arr) > 1) {
                $designation_arr = implode(",", $designation_arr);
            }

            $user_grd_arr = $this->admin_model->get_table("rights_on_grades", "grade_id", array("status" => 1, "user_id" => $user_id));
            $grade_arr = $this->common_model->array_value_recursive("grade_id", $user_grd_arr);
            if (count($grade_arr) > 1) {
                $grade_arr = implode(",", $grade_arr);
            }

            $user_lvl_arr = $this->admin_model->get_table("rights_on_levels", "level_id", array("status" => 1, "user_id" => $user_id));
            $level_arr = $this->common_model->array_value_recursive("level_id", $user_lvl_arr);
            if (count($level_arr) > 1) {
                $level_arr = implode(",", $level_arr);
            }

            $user_dtls = $this->admin_model->get_table_row("login_user", "id, email, role", array("id" => $user_id), "id desc");

            $rights_for_user_id = $user_dtls["id"];
            $role = $user_dtls["role"];
            $is_rights_conflict = $this->admin_model->check_user_rights_conflicts($rights_for_user_id, $role, $country_arr, $city_arr, $bussiness_level_1_arr, $bussiness_level_2_arr, $bussiness_level_3_arr, $function_arr, $sub_function_arr,$sub_subfunction_arr, $designation_arr, $grade_arr, $level_arr);
            if ($is_rights_conflict) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Rights are conflict with others, you can not activate this user.</b></div>');
                redirect(site_url($redirect_url));
            }
        }
    }
    //piy@20Jan
    $this->load->model("user_model");
    $this->user_model->create_users_history(array("id" => $user_id));
    $this->admin_model->update_tbl_data("login_user", array("status" => $status, "updatedby" => $this->session->userdata('userid_ses'), "updatedon" => date("Y-m-d H:i:s"), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses')), array("id" => $user_id));
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Status updated successfully.</b></div>');
    redirect(site_url($redirect_url));
}

public function delete_employee($id, $redirect_url) {
    if ($redirect_url != "staff" and $redirect_url != "hr-list") {
        $redirect_url = "staff";
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_DELETE_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_delete_right') . '</b></div>');
        redirect(site_url($redirect_url));
    }
    //piy@20Jan
    $this->load->model("user_model");
    $this->user_model->create_users_history(array("id" => $id));
    $this->admin_model->update_tbl_data("login_user", array("status" => 2, "updatedby" => $this->session->userdata('userid_ses'), "updatedon" => date("Y-m-d H:i:s"), "updatedby_proxy" => $this->session->userdata('proxy_userid_ses')), array("id" => $id));
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Staff member deleted successfully.</b></div>');
    redirect(site_url($redirect_url));
}

public function country_list($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_COUNTRY_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_delete_right') . '</b></div>');
        redirect(site_url('no-rights'));
    }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "status" => $status);

            if ($id) {
                $this->admin_model->update_tbl_data("manage_country", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_country($db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New country created successfully.</b></div>');
            }
            redirect(site_url("country"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("country"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_country", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_country_list();
    $data['title'] = "Manage Country";
    $data['url_key'] = "country";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function business_attributes_list() {
    $data['msg'] = "";
    $data['business_attributes_list'] = $this->admin_model->get_business_attributes_list();
    $data['title'] = "Business Attributes";
    $data['body'] = "admin/business_attributes_list";
    $this->load->view('common/structure', $data);
}

public function designation_list($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_DESIGNATION_LIST, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }

    if ($this->input->is_ajax_request()) {

        if(!empty($this->input->post("dataArr"))) {

            $data               = $this->input->post("dataArr");
            $table              = 'manage_designation';
            $updateFieldName    = 'order_no';
            $whereFieldsName    = 'id';

            $result = $this->admin_model->changeTableFieldsOrder($data, $table, $updateFieldName, $whereFieldsName);

            if ($result) {
                echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "msg" => "Record updated successfully."));
            } else {
                echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "There are seems some error."));
            }

        } else {
            echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "There are seems some error."));
        }

        return;

    } else if ($this->input->post()) {//previous condition

        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');

        if ($this->form_validation->run()) {

            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "status" => $status
            );

            if ($id) {
                $this->admin_model->update_tbl_data("manage_designation", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_designation($db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New designation created successfully.</b></div>');
            }
            redirect(site_url("designation"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("designation"));
        }

    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_designation", "id, name, order_no, status", array("id" => $id));
    }

    $orderBy = 'order_no';
    $data['list'] = $this->admin_model->get_designation_list($orderBy);
    $data['title'] = "Manage Designation";
    $data['url_key'] = "designation";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_level($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_LEVEL_LIST, CV_VIEW_RIGHT_NAME)) {//need to discuss with ravi
        redirect(site_url("no-rights"));
    }

    if ($this->input->is_ajax_request()) {

        if(!empty($this->input->post("dataArr"))) {

            $data               = $this->input->post("dataArr");
            $table              = 'manage_level';
            $updateFieldName    = 'order_no';
            $whereFieldsName    = 'id';

            $result = $this->admin_model->changeTableFieldsOrder($data, $table, $updateFieldName, $whereFieldsName);

            if ($result) {
                echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "msg" => "Record updated successfully."));
            } else {
                echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "There are seems some error."));
            }
        } else {
            echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "There are seems some error."));
        }

        return;

    } else if ($this->input->post()) {

        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');

        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');

            $db_arr = array(
                "name" => $name,
                "status" => $status
            );

            if ($id) {
                $this->admin_model->update_tbl_data("manage_level", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_level($db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New designation created successfully.</b></div>');
            }
            redirect(site_url("manage-level"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-level"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_level", "id, name, order_no, status", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_level", "id, name, order_no, status" , "", "order_no" );
    $data['title'] = "Manage Level";
    $data['url_key'] = "manage-level";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_grade($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_GRADE, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }

    if ($this->input->is_ajax_request()) {

        if(!empty($this->input->post("dataArr"))) {

            $data               = $this->input->post("dataArr");
            $table              = 'manage_grade';
            $updateFieldName    = 'order_no';
            $whereFieldsName    = 'id';

            $result = $this->admin_model->changeTableFieldsOrder($data, $table, $updateFieldName, $whereFieldsName);

            if ($result) {
                echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "msg" => "Record updated successfully."));
            } else {
                echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "There are seems some error."));
            }

            return;

        } else {//previous condition

            $this->form_validation->set_rules('txt_order', 'Order', 'trim|required|max_length[2]|numeric');
            $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[2]|numeric|is_natural_no_zero');
            if ($this->form_validation->run()) {
                $order = $this->input->post('txt_order');
                $db_arr = array("order_no" => $order);
                $gid = $this->input->post('id');
                $this->admin_model->update_tbl_data("manage_grade", $db_arr, array("id" => $gid));
                echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "value" => $order, "msg" => "Record updated successfully."));
                return;
            }
            echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "Order must contain only numbers."));
            return;
        }
    } else if ($this->input->post()) {

        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');

        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');

            $db_arr = array(
                "name" => $name,
                "status" => $status
            );

            if ($id) {
                $this->admin_model->update_tbl_data("manage_grade", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_grade", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New grade created successfully.</b></div>');
            }
            redirect(site_url("manage-grade"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-grade"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_grade", "id, name, order_no, status", array("id" => $id));
    }

    $orderBy = 'order_no';
    $data['list'] = $this->admin_model->get_grade_list($orderBy);
    $data['title'] = "Manage Grade";
    $data['url_key'] = "manage-grade";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_city($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_CITY_ID, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('ddl_tier', 'Tier', 'trim|required', array('required' => '%s field is required. Firstly please create Tier from Tier Masters'));

        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');

            $tier = $this->input->post('ddl_tier');
            $db_arr = array(
                "name" => $name,
                "status" => $status,
                "tier_id" => $tier);
            if ($id) {
                $this->admin_model->update_tbl_data("manage_city", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_city", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New city created successfully.</b></div>');
            }
            redirect(site_url("manage-city"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-city"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_city", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_city_list();
    $data['tier_list'] = $this->admin_model->get_tier_list(array("status" => 1));

    $data['url_key'] = "manage-city";
    $data['title'] = "Manage City";

    $data['body'] = "admin/manage";
        // $data['body'] = "admin/manage_city";
    $this->load->view('common/structure', $data);
}

public function upload_city_data() {
    if ($this->input->post()) {
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name'] != "") {
            $file_type = explode('.', $_FILES['myfile']['name']);
            if ($file_type[1] == 'csv')
			{
				$scan_file_result = HL_scan_uploaded_file($_FILES['myfile']['name'],$_FILES['myfile']['tmp_name']);
				if($scan_file_result === true)
				{
					$filename = $_FILES["myfile"]["tmp_name"];
					$file = fopen($filename, "r");
					$row = 1;
					while (($data = fgetcsv($file, "", ",")) !== FALSE) {
						if ($row == 1) {
							$row++;
							continue;
						}
						if (!empty(trim($data[0])) and ! empty(trim($data[1]))) {
							$tierdetail = $this->admin_model->get_table_row("tier_master", "id", array("name" => trim($data[1])));
							if (empty($tierdetail["id"])) {
	
							} else {
								$tierid = $tierdetail["id"];
							}
							$citydetail = $this->admin_model->get_table_row("manage_city", "id", array("name" => trim($data[0])));
							if (empty($citydetail["id"])) {
									// $this->admin_model->insert_data_in_tbl("manage_city", array("name" => trim($data[0]), "area" => trim($data[1]), "tier_id" => $tierid));
							} else {
								$this->admin_model->update_tbl_data("manage_city", array("tier_id" => $tierid), array("id" => $citydetail["id"]));
							}
						}
					}
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record Updated Successfully.</b></div>');
					redirect(site_url("manage-city/"));
				}
				else
				{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
					redirect(site_url("manage-city/"));
                }
				
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
                redirect(site_url("manage-city/"));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please Select CSV File.</b></div>');
            redirect(site_url("manage-city/"));
        }
    }
}

public function download_city_sample_file() {
    $data['list'] = $this->admin_model->get_city_list();

    $condition_arr = array();
    $csv_file = "default_file_format.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csv_file . '"');

    $fp = fopen('php://output', 'wb');
    fputcsv($fp, array("City Name", "Tier"));

    foreach ($data['list'] as $row) {
        fputcsv($fp, array($row['name'], ""));
    }
    fclose($fp);
}

public function manage_business_level1($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_BUSINESS_LEVEL_1, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }

    if ($this->input->is_ajax_request()) {
        $this->form_validation->set_rules('txt_order', 'Order', 'trim|required|max_length[2]|numeric');
        $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[2]|numeric|is_natural_no_zero');
        if ($this->form_validation->run()) {
            $order = $this->input->post('txt_order');
            $db_arr = array("order_no" => $order);
            $gid = $this->input->post('id');
            $this->admin_model->update_tbl_data("manage_business_level_1", $db_arr, array("id" => $gid));
            echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "value" => $order, "msg" => "Record updated successfully."));
            return;
        }
        echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "Order must contain only numbers."));
        return;
    }

    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "status" => $status);
            if ($id) {
                $this->admin_model->update_tbl_data("manage_business_level_1", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_business_level_1", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New business level 1 created successfully.</b></div>');
            }
            redirect(site_url("manage-business-level-1"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-business-level-1"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_business_level_1", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_business_level_1", "*", array("status" => 1));
    $data['title'] = "Manage Business Level 1";
    $data['url_key'] = "manage-business-level-1";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_business_level2($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_BUSINESS_LEVEL_2, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }

    if ($this->input->is_ajax_request()) {
        $this->form_validation->set_rules('txt_order', 'Order', 'trim|required|max_length[2]|numeric');
        $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[2]|numeric|is_natural_no_zero');
        if ($this->form_validation->run()) {
            $order = $this->input->post('txt_order');
            $db_arr = array("order_no" => $order);
            $gid = $this->input->post('id');
            $this->admin_model->update_tbl_data("manage_business_level_2", $db_arr, array("id" => $gid));
            echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "value" => $order, "msg" => "Record updated successfully."));
            return;
        }
        echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "Order must contain only numbers."));
        return;
    }

    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "status" => $status);
            if ($id) {
                $this->admin_model->update_tbl_data("manage_business_level_2", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_business_level_2", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New business level 2 created successfully.</b></div>');
            }
            redirect(site_url("manage-business-level-2"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-business-level-2"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_business_level_2", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_business_level_2", "*", array("status" => 1));
    $data['title'] = "Manage Business Level 2";
    $data['url_key'] = "manage-business-level-2";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_business_level3($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_BUSINESS_LEVEL_3, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }

    if ($this->input->is_ajax_request()) {
        $this->form_validation->set_rules('txt_order', 'Order', 'trim|required|max_length[2]|numeric');
        $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[2]|numeric|is_natural_no_zero');
        if ($this->form_validation->run()) {
            $order = $this->input->post('txt_order');
            $db_arr = array("order_no" => $order);
            $gid = $this->input->post('id');
            $this->admin_model->update_tbl_data("manage_business_level_3", $db_arr, array("id" => $gid));
            echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "value" => $order, "msg" => "Record updated successfully."));
            return;
        }
        echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "Order must contain only numbers."));
        return;
    }

    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "status" => $status);
            if ($id) {
                $this->admin_model->update_tbl_data("manage_business_level_3", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_business_level_3", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New business level 3 created successfully.</b></div>');
            }
            redirect(site_url("manage-business-level-3"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-business-level-3"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_business_level_3", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_business_level_3", "*", array("status" => 1));
    $data['title'] = "Manage Business Level 3";
    $data['url_key'] = "manage-business-level-3";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_functions($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_FUNCTIONS, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('txt_owner_id', 'Order', 'trim|required|valid_email');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $txt_owner_id = $this->input->post('txt_owner_id');
            $data['user_detais'] = $this->admin_model->get_table_row("login_user", "*", array("email" => $txt_owner_id));

            if ($data['user_detais']) {
                $db_arr = array(
                    "name" => $name,
                    "status" => $status,
                    "owner_id" => $data['user_detais']['id']);
                if ($id) {
                    $this->admin_model->update_tbl_data("manage_function", $db_arr, array("id" => $id));
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
                } else {
                    $this->admin_model->insert_data_in_tbl("manage_function", $db_arr);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New function created successfully.</b></div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Email Id Not Vaild.</b></div>');
            }
            redirect(site_url("manage-functions"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-functions"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_function", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_function", "*", array());
    $data['title'] = "Manage Functions";
    $data['url_key'] = "manage-functions";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_sub_functions($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_SUB_FUNCTIONS, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('txt_owner_id', 'owner', 'trim|required|valid_email');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $txt_owner_id = $this->input->post('txt_owner_id');
            $data['user_detais'] = $this->admin_model->get_table_row("login_user", "*", array("email" => $txt_owner_id));

            if ($data['user_detais']) {
                $db_arr = array(
                    "name" => $name,
                    "status" => $status,
                    "owner_id" => $data['user_detais']['id']);
                if ($id) {
                    $this->admin_model->update_tbl_data("manage_subfunction", $db_arr, array("id" => $id));
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
                } else {
                    $this->admin_model->insert_data_in_tbl("manage_subfunction", $db_arr);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New sub function created successfully.</b></div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Email Id Not Vaild.</b></div>');
            }
            redirect(site_url("manage-sub-functions"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-sub-functions"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_subfunction", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_subfunction", "*", array());
    $data['title'] = "Manage Sub Functions";
    $data['url_key'] = "manage-sub-functions";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_sub_subfunctions($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_SUB_SUB_FUNCTIONS, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "status" => $status);
            if ($id) {
                $this->admin_model->update_tbl_data("manage_sub_subfunction", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_sub_subfunction", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New sub sub function created successfully.</b></div>');
            }
            redirect(site_url("manage-sub-subfunctions"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-sub-subfunctions"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_sub_subfunction", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_sub_subfunction", "*", array());
    $data['title'] = "Manage Sub Sub Functions";
    $data['url_key'] = "manage-sub-subfunctions";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_ratings($id = 0) {
    $data['msg'] = "";
        // if (!helper_have_rights(CV_MANAGE_GRADE, CV_VIEW_RIGHT_NAME)) {
        //     redirect(site_url("no-rights"));
        // }

    if ($this->input->is_ajax_request()) {
        $this->form_validation->set_rules('txt_order', 'Order', 'trim|required|max_length[2]|numeric');
        $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[2]|numeric|is_natural_no_zero');
        if ($this->form_validation->run()) {
            $order = $this->input->post('txt_order');
            $db_arr = array("order_no" => $order);
            $gid = $this->input->post('id');
            $this->admin_model->update_tbl_data("manage_rating_for_current_year", $db_arr, array("id" => $gid));
            echo json_encode(array('status' => true, "csrf" => $this->security->get_csrf_hash(), "value" => $order, "msg" => "Record updated successfully."));
            return;
        }
        echo json_encode(array('status' => false, "csrf" => $this->security->get_csrf_hash(), "msg" => "Order must contain only numbers."));
        return;
    }

    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        $this->form_validation->set_rules('txt_order', 'Order', 'trim|required|max_length[2]|numeric|is_natural_no_zero');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $order = $this->input->post('txt_order');
            $db_arr = array(
                "name" => $name,
                "status" => $status,
                "order_no" => $order);
            if ($id) {
                $this->admin_model->update_tbl_data("manage_rating_for_current_year", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
            } else {
                $this->admin_model->insert_data_in_tbl("manage_grade", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New record created successfully.</b></div>');
            }
            redirect(site_url("manage-ratings"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-ratings"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("manage_rating_for_current_year", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_table("manage_rating_for_current_year", "*", "");
    $data['title'] = "Manage Ratings";
    $data['url_key'] = "manage-ratings";
    $data['body'] = "admin/manage";
    $this->load->view('common/structure', $data);
}

public function manage_currency($id = 0) {
    $data['msg'] = "";
    if (!helper_have_rights(CV_MANAGE_CURRENCY, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_display_name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('txt_name', 'Code', 'trim|required|max_length[5]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $display_name = $this->input->post('txt_display_name');
            $name = $this->input->post('txt_name');
            $status = $this->input->post('ddl_status');
            $db_arr = array(
                "name" => $name,
                "display_name" => $display_name,
                "status" => $status);
            if ($id) {
                $is_currency_exist = $this->admin_model->get_table_row("manage_currency", "*", array("name" => $name));
                if ($is_currency_exist["id"] != $id) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Currency already exist.</b></div>');
                } else {
                    $this->admin_model->update_tbl_data("manage_currency", $db_arr, array("id" => $id));
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
                }
            } else {
                $is_currency_exist = $this->admin_model->get_table_row("manage_currency", "*", array("name" => $name));
                if ($is_currency_exist) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Currency already exist.</b></div>');
                } else {
                    $this->admin_model->insert_data_in_tbl("manage_currency", $db_arr);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New currency created successfully.</b></div>');
                }
            }
            redirect(site_url("manage-currency"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            redirect(site_url("manage-currency"));
        }
    }

    if ($id) {
        $data['currency_dtl'] = $this->admin_model->get_table_row("manage_currency", "*", array("id" => $id));
    }

    $data['currencys_list'] = $this->admin_model->get_table("manage_currency", "*", array());
    $data['title'] = "Manage Currency";
    $data['body'] = "admin/manage_currency";
    $this->load->view('common/structure', $data);
}

public function currency_rates() {
    $data['msg'] = "";
    if (!helper_have_rights(CV_CURRENCY_RATES, CV_VIEW_RIGHT_NAME)) {
        redirect(site_url("no-rights"));
    }
    $currencys = $this->admin_model->get_table("manage_currency", "*", array("status" => 1));

    if ($this->input->post()) {
        foreach ($currencys as $frm_row) {
            foreach ($currencys as $to_row) {
                $db_arr = array("rate" => $this->input->post("txt_rates_" . $frm_row["id"] . "_" . $to_row["id"]));

                $is_currency_exist = $this->admin_model->get_table_row("currency_rates", "*", array("from_currency" => $frm_row["id"], "to_currency" => $to_row["id"]));

                if ($is_currency_exist) {
                    $db_arr["updated_by"] = $this->session->userdata('userid_ses');
                    $db_arr["updated_on"] = date("Y-m-d H:i:s");
                    $this->admin_model->update_tbl_data("currency_rates", $db_arr, array("id" => $is_currency_exist["id"]));
                } else {
                    $db_arr["from_currency"] = $frm_row["id"];
                    $db_arr["to_currency"] = $to_row["id"];
                    $db_arr["created_by"] = $this->session->userdata('userid_ses');
                    $db_arr["created_on"] = date("Y-m-d H:i:s");
                    $this->admin_model->insert_data_in_tbl("currency_rates", $db_arr);
                }
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data submitted successfully.</b></div>');
        }
            //echo "<pre>";print_r($this->input->post());die;
        redirect(site_url("currency-rates"));
    }

    $data['currencys_list'] = $currencys;
    $data['rates'] = json_encode($this->admin_model->get_table("currency_rates", "*", array("status" => 1)));
    $data['title'] = "Currency Rates / Conversions";
    $data['body'] = "admin/currency_rates";
    $this->load->view('common/structure', $data);
}

public function edit_company_info() {
    $data['msg'] = "";
    if (!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }
    if (!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_UPDATE_RIGHT_NAME)) {
        $data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_edit_right') . '</b></div>';
    }

    $data["company_dtl"] = $this->admin_model->get_table_row("manage_company", "*", array("id" => $this->session->userdata('companyid_ses')));
    if ($data["company_dtl"]) {
        if ($this->input->post()) {
            if (!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_UPDATE_RIGHT_NAME)) {
                redirect(site_url("edit-company-info"));
            }

            $this->form_validation->set_rules('txt_color', 'Company theme color', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('txt_light_color', 'Company theme light color', 'trim|required|max_length[50]');

            $this->form_validation->set_rules('ddl_peer_graph_for', 'Peers', 'trim|required');
            $this->form_validation->set_rules('ddl_market_data_by', 'Benchmark Type', 'trim|required');
            $this->form_validation->set_rules('ddl_adhoc_salary_review_for', 'Adhoc Salary Review', 'trim|required');
            if ($this->input->post("ddl_adhoc_salary_review_for") == CV_ADHOC_ANNIVERSARY_TIME) {
                $this->form_validation->set_rules('txt_preserved_days', 'Preserved Days For Anniversary Based Rule', 'trim|required');
            }
            $this->form_validation->set_rules('ddl_target_sal_elem[]', 'Target Salary Elements', 'trim|required');
            $this->form_validation->set_rules('ddl_total_sal_elem[]', 'Total Salary Elements', 'trim|required');
            $this->form_validation->set_rules('ddl_adhoc_sal_elem[]', 'Adhoc Salary Elements', 'trim|required');


            if ($this->form_validation->run()) {



                $db_arr = array(
                        //"company_name"=> $this->input->post("txt_company"),
                    "company_color" => $this->input->post("txt_color"),
                    "company_light_color" => $this->input->post("txt_light_color"),
                    "peer_graph_for" => $this->input->post("ddl_peer_graph_for"),
                    "peer_group_base" => $this->input->post("ddl_peer_group_base"),
                    "market_data_by" => $this->input->post("ddl_market_data_by"),
                    "target_sal_elem" => implode(",", $this->input->post("ddl_target_sal_elem")),
                    "total_sal_elem" => implode(",", $this->input->post("ddl_total_sal_elem")),
                    "adhoc_sal_elem" => implode(",", $this->input->post("ddl_adhoc_sal_elem")),
                    "adhoc_salary_review_for" => $this->input->post("ddl_adhoc_salary_review_for"),
                    "preserved_days" => $this->input->post("txt_preserved_days"),
					"managers_hierarchy_based_on" => $this->input->post("ddl_managers_hierarchy_based_on"),
                    "updated_on" => date("Y-m-d H:i:s"));
                    if($this->input->post("smtp[password]"))
                     {

                      $db_arr["smtp_detail"]=serialize($this->input->post("smtp"));

                     }
                     else
                     {
                        $smtpdata=$this->input->post("smtp");
                        unset($smtpdata['password']);
                        $db_arr["smtp_detail"] = serialize($smtpdata);

                     }

                if ($db_arr["adhoc_salary_review_for"] != CV_ADHOC_ANNIVERSARY_TIME) {
                    $db_arr["preserved_days"] = 0;
                }

                if ($_FILES['comp_logo']['name']) {
                    $upload_arr = HLP_upload_img('comp_logo', "uploads/comp_logos/");
                    if (count($upload_arr) == 2) {
                        $f_path = 'uploads/comp_logos/' . $upload_arr[0];
                        $db_arr["company_logo"] = base_url() . $f_path;
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $upload_arr[0] . '</b></div>');
                        redirect(site_url("edit-company-info"));
                    }

                        /* $file_type = explode('.',$_FILES['comp_logo']['name']);
                          $img_ext = strtolower($file_type[1]);

                          if($img_ext == 'png' || $img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'gif')
                          {
                          $fName = time().".".$img_ext;
                          if (move_uploaded_file($_FILES["comp_logo"]["tmp_name"],  "uploads/comp_logos/".$fName))
                          {
                          $db_arr["company_logo"] = base_url()."uploads/comp_logos/".$fName;
                          }
                          else
                          {
                          $this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Logo was not uploaded.</b></span></div>');
                          redirect(site_url("edit-company-info"));
                          }
                          }
                          else
                          {
                          $this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Please upload correct image for logo.</b></span></div>');
                          redirect(site_url("edit-company-info"));
                      } */
                  }

                  if ($_FILES['comp_bg_img']['name']) {
                    $upload_arr = HLP_upload_img('comp_bg_img', "uploads/comp_logos/", 2048);
                    if (count($upload_arr) == 2) {
                        $f_path = 'uploads/comp_logos/' . $upload_arr[0];
                        $db_arr["company_bg_img"] = base_url() . $f_path;
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $upload_arr[0] . '</b></div>');
                        redirect(site_url("edit-company-info"));
                    }


                        /* $bg_file_type = explode('.',$_FILES['comp_bg_img']['name']);
                          $bg_img_ext = strtolower($bg_file_type[1]);

                          if($bg_img_ext == 'png' || $bg_img_ext == 'jpg' || $bg_img_ext == 'jpeg' || $bg_img_ext == 'gif')
                          {
                          $bg_fName = "bg_img_".time().".".$bg_img_ext;
                          if (move_uploaded_file($_FILES["comp_bg_img"]["tmp_name"],  "uploads/comp_logos/".$bg_fName))
                          {
                          $db_arr["company_bg_img"] = base_url()."uploads/comp_logos/".$bg_fName;
                          }
                          else
                          {
                          $this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Company background image was not uploaded.</b></span></div>');
                          redirect(site_url("edit-company-info"));
                          }
                          }
                          else
                          {
                          $this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Please upload correct image for company background.</b></span></div>');
                          redirect(site_url("edit-company-info"));
                      } */
                  }



                  $this->admin_model->update_tbl_data("manage_company", $db_arr, array("manage_company.id" => $this->session->userdata('companyid_ses')));
                  unset($db_arr['smtp_detail']);
				  unset($db_arr['managers_hierarchy_based_on']);
                  $dbname = CV_PLATFORM_DB_NAME;
                  //$this->db->query("Use $dbname");
                  $this->db->where(array("manage_company.id" => $this->session->userdata('companyid_ses')));
                  $this->db->update("{$dbname}.manage_company", $db_arr);

                  $new_ses_arr = array(
                    'company_color_ses' => $db_arr['company_color'],
                    'company_light_color_ses' => $db_arr['company_light_color'],
                    'market_data_by_ses' => $db_arr["market_data_by"],
                );
                  if (isset($db_arr['company_logo']) and $db_arr['company_logo'] != "") {
                    $new_ses_arr["company_logo_ses"] = $db_arr['company_logo'];
                }
                if (isset($db_arr['company_bg_img']) and $db_arr['company_bg_img'] != "") {
                    $new_ses_arr["company_bg_img_url_ses"] = $db_arr['company_bg_img'];
                }
                $this->session->set_userdata($new_ses_arr);

                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Company details updated successfully.</b></div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            }
            redirect(site_url("edit-company-info"));
        }

            //$data["salary_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list(array("business_attribute.status"=>1, "business_attribute.module_name"=>CV_SALARY_ELEMENT));
            //$data["salary_elem_list"] = $this->common_model->get_table("business_attribute", "id as business_attribute_id, display_name", array("business_attribute.status"=>1, "business_attribute.module_name"=>CV_SALARY_ELEMENT), "display_name asc");
        $data["salary_elem_list"] = $this->common_model->get_table("business_attribute", "id as business_attribute_id, display_name", "business_attribute.status = 1 AND (business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "')", "display_name asc");
        $data['title'] = "Edit Company Profile";
        $data['body'] = "admin/edit_company_dtls";
        $this->load->view('common/structure', $data);
    } else {
        redirect(site_url("dashboard"));
    }
}

public function send_emails($mail_from = "", $mail_to = "", $subject = "", $mail_body = "") {
$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
$email_config["protocol"] = "smtp";
$email_config["smtp_host"] = 'smtp.sendgrid.net';
$email_config["smtp_port"] =  465;
$email_config["smtp_user"] = 'apikey';
$email_config["smtp_pass"] = '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';
$email_config["smtp_crypto"] = "ssl";
$this->load->library('email', $email_config);
$this->email->set_newline("\r\n");
$this->email->from($mail_from);
$this->email->to($mail_to);
$this->email->subject($subject);
$this->email->message($mail_body);
$this->email->send();
$this->email->clear();


    // $this->load->library('email');
    // $config['protocol'] = 'sendmail';
    // $config['mailpath'] = '/usr/sbin/sendmail';
    // $config['charset'] = 'iso-8859-1';
    // $config['wordwrap'] = TRUE;
    // $config['mailtype'] = 'html';
    // $this->email->initialize($config);
    // $this->email->from($mail_from);
    // $this->email->to($mail_to);
    // $this->email->subject($subject);

}

public function view_emplyoee_details($empId) {
    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', "<div align='left' style='color:red;' id='notify'><span><b>" . $this->lang->line('msg_no_view_right') . "</b></span></div>");
        redirect(site_url("no-rights"));
    }

    $data['msg'] = "";
    $tupleData = $this->admin_model->staffDetails($empId);
    $data['staffDetail'] = $this->admin_model->completeStafDetails(array('row_num' => $tupleData['row_num'], 'data_upload_id' => $tupleData['data_upload_id']));

        // echo "<pre>";print_r($data['staffDetail']);die();
    $data['title'] = "Staffs List";
    $data['body'] = "admin/view_emp_details.php";
    $this->load->view('common/structure', $data);
}

    /* public function edit_emplyoee_details($empId)
      {
      $data['msg'] = "";
      $tupleData = $this->admin_model->staffDetails($empId);
      $data['staffDetail'] = $this->admin_model->completeStafDetails(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));

      // echo "<pre>";print_r($data['staffDetail']);die();
      $data['title'] = "Staffs";
      $data['body'] = "admin/edit_emp_details.php";
      $this->load->view('common/structure',$data);
  } */

  public function autocomplete_email() {
    $term = $this->input->get('term', TRUE);
    $this->admin_model->autocomplete($term);
}

// role delete function added by rahul singh

function delete_role($user_id,$role_id)
{
  $res=$this->admin_model->get_table_row('login_user','is_manager,role',['id'=>$user_id]);
  if($res['is_manager']==0){$role='11';}else{$role='10';}
  $data['role']=$role;
  $this->admin_model->update_tbl_data('login_user', $data,['id'=>$user_id]);
  $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>User removed from this role successfully.</b></div>');
   redirect(site_url("view-user-right-details/".$role_id));
}


public function download_salary_structure_NIU($flexiid,$type,$ruleid='') {
//$type=1(Core data) $type=2(Roule data)
   //die();
$data['msg'] = "";
  $condition_list= $this->admin_model->get_table_row('flexi_plan_filter','*', ['id'=>$flexiid]);
  $conditions.=' login_user.country IN ('.$condition_list['country'].')';
  $conditions.=' and login_user.city IN ('.$condition_list['city'].')';
  $conditions.=' and login_user.business_level_1 IN ('.$condition_list['business_level1'].')';
  $conditions.=' and login_user.business_level_2 IN ('.$condition_list['business_level2'].')';
  $conditions.=' and login_user.business_level_3 IN ('.$condition_list['business_level3'].')';
  $conditions.=' and login_user.function IN ('.$condition_list['functions'].')';
  $conditions.=' and login_user.subfunction IN ('.$condition_list['sub_functions'].')';
  $conditions.=' and login_user.sub_subfunction IN ('.$condition_list['sub_subfunctions'].')';
  $conditions.=' and login_user.designation IN ('.$condition_list['designations'].')';
  $conditions.=' and login_user.special_category IN ('.$condition_list['special_category'].')';

if($condition_list['flexi_type']=='grade')
{
$conditions.=' and login_user.grade IN ('.$condition_list['grades'].')';
$flexi_plan_type='grade';
$gradelevel_list=$this->db->query('SELECT name FROM `manage_grade` WHERE `id` IN ('.$condition_list['grades'].')  order by order_no ASC')->result_array();
}
else
{
$conditions.=' and login_user.level IN ('.$condition_list['levels'].')';
 $flexi_plan_type='level';
$gradelevel_list=$this->db->query('SELECT name FROM `manage_level` WHERE `id` IN ('.$condition_list['levels'].') order by  order_no ASC')->result_array();
}
$gradelevel_final_list=array();
foreach ($gradelevel_list as $key => $value) {
  array_push($gradelevel_final_list, $value['name']);
}
$arr=$conditions;
$data['keyword'] = $this->session->userdata('keyword');
$this->session->unset_userdata('keyword');
$staff_list = $this->admin_model->get_staff_list_for_download($arr);
$staff_list = DownloadSalaryStructure($staff_list,$flexiid,$type,$ruleid,$flexi_plan_type,$gradelevel_final_list);
        downloadcsv($staff_list);
}
// download flexi plan existing data
public function download_flexi_data($flexiid,$datatype,$ruleid)
{

$emparr = [];
$temparr = [];
$remove_attname=array('education','critical_talent','critical_position','special_category','start_date_for_role','end_date_for_role','bonus_incentive_applicable','recently_promoted','performance_achievement','rating_for_current_year','rating_for_last_year','rating_for_2nd_last_year','rating_for_3rd_last_year','rating_for_4th_last_year','rating_for_5th_last_year','increment_purpose_joining_date','increment_applied_on');
 $salary_elememts = $this->db->query("SELECT * FROM `business_attribute` where  ba_grouping='Salary'  and status=1 ORDER BY `business_attribute`.`ba_attributes_order` ASC")->result_array();
 $fields='tbl_bulk_upload_flexi_data.employee_code,tbl_bulk_upload_flexi_data.email,';
 $att_list_array['Employee Code']='employee_code';
 $att_list_array['Email ID']='email';
 foreach ($salary_elememts as $value)
 {
    if(in_array($value['ba_name'],$remove_attname))
      {
        continue;
      }
    $fields.='tbl_bulk_upload_flexi_data.'.$value['ba_name'].',';
    $att_list_array[$value['display_name']]=$value['ba_name'];
 }
 $fields.='tbl_bulk_upload_flexi_data.revised_fixed_salary';
 $att_list_array['Revised Fixed Salary']='revised_fixed_salary';
 //$datatype=1 coredata $datatype=2 ruledata
 if($datatype==1)
 {
   $ruleid=0;
 }else
 {
   $ruleid=$ruleid;
 }
$data_list=$this->admin_model->get_table('tbl_bulk_upload_flexi_data', $fields, ['flexi_id'=>$flexiid,'rule_id'=>$ruleid],'','','');
foreach ($data_list as $data)
{
  foreach ($att_list_array as $key => $value)
  {
    $emparr[$key] = $data[$value];
  }

  array_push($temparr, $emparr);
}

downloadcsv($temparr);
}

public function download_salary_structure($flexiid,$type,$ruleid='') {
//$type=1(Core data) $type=2(Roule data)
   //die();
$data['msg'] = "";
  $condition_list= $this->admin_model->get_table_row('flexi_plan_filter','*', ['id'=>$flexiid]);
  $conditions =' login_user.country IN ('.$condition_list['country'].')';
  $conditions.=' and login_user.city IN ('.$condition_list['city'].')';
  $conditions.=' and login_user.business_level_1 IN ('.$condition_list['business_level1'].')';
  $conditions.=' and login_user.business_level_2 IN ('.$condition_list['business_level2'].')';
  $conditions.=' and login_user.business_level_3 IN ('.$condition_list['business_level3'].')';
  $conditions.=' and login_user.function IN ('.$condition_list['functions'].')';
  $conditions.=' and login_user.subfunction IN ('.$condition_list['sub_functions'].')';
  $conditions.=' and login_user.sub_subfunction IN ('.$condition_list['sub_subfunctions'].')';
  $conditions.=' and login_user.designation IN ('.$condition_list['designations'].')';
  $conditions.=' and login_user.special_category IN ('.$condition_list['special_category'].')';

if($condition_list['flexi_type']=='grade')
{
$conditions.=' and login_user.grade IN ('.$condition_list['grades'].')';
$flexi_plan_type='grade';
$gradelevel_list=$this->db->query('SELECT name FROM `manage_grade` WHERE `id` IN ('.$condition_list['grades'].')  order by order_no ASC')->result_array();
}
else
{
$conditions.=' and login_user.level IN ('.$condition_list['levels'].')';
 $flexi_plan_type='level';
$gradelevel_list=$this->db->query('SELECT name FROM `manage_level` WHERE `id` IN ('.$condition_list['levels'].') order by  order_no ASC')->result_array();
}

if($type == 2)
{
	$conditions.=' AND login_user.id IN (SELECT user_id FROM employee_salary_details where rule_id = '.$ruleid.')';
}
$gradelevel_final_list=array();
foreach ($gradelevel_list as $key => $value) {
  array_push($gradelevel_final_list, $value['name']);
}
$arr=$conditions;
$data['keyword'] = $this->session->userdata('keyword');
$this->session->unset_userdata('keyword');
//$staff_list = $this->admin_model->get_staff_list_for_download($arr);

$staff_list = $this->admin_model->get_table("login_user", "id", $arr);
$staff_list = DownloadSalaryStructure($staff_list,$flexiid,$type,$ruleid,$flexi_plan_type,$gradelevel_final_list);
        downloadcsv($staff_list);
}

    // Code start by omkar
public function staffexport() {
    $data['msg'] = "";

    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
        $data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_add_right') . '</b></span></div>';
    }
    $arr = "";
    if ($this->input->post()) {
        $this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
    }

    $hr_emps_arr = "";
        if ($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users
            $hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
            if (!$hr_emps_data_arr) {
                downloadcsv($hr_emps_data_arr);
                exit;
            }
            $hr_emps_arr = $this->common_model->array_value_recursive("id", $hr_emps_data_arr);
            if (count($hr_emps_arr) > 1) {
                $arr = "login_user.id in (" . implode(",", $hr_emps_arr) . ")";
            } else {
                $arr = "login_user.id in (" . $hr_emps_arr . ")";
            }
        }

        if ($this->session->userdata('keyword')) {
            if ($arr) {
                $arr .= " AND ";
            }
            $arr .= "(login_user.name LIKE '%" . $this->session->userdata('keyword') . "%' or login_user.email LIKE '%" . $this->session->userdata('keyword') . "%')";
        }

        $data['keyword'] = $this->session->userdata('keyword');
        $this->session->unset_userdata('keyword');
        $staff_list = $this->admin_model->get_staff_list_for_download($arr);
        $staff_list = GetEmpAllDataFromEmpId($staff_list);
        downloadcsv($staff_list);
    }

    public function ajaxemplist() {
        $data['msg'] = "";

        if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
            redirect(site_url("no-rights"));
        }

        if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
            $data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_add_right') . '</b></span></div>';
        }

        $arr = "";
        if ($this->input->post()) {
            $this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
        }

        $hr_emps_arr = "";
        if ($this->session->userdata('role_ses') > 2 and $this->session->userdata('role_ses') <= 9) {//HR Type of Users
            $hr_emps_data_arr = HLP_get_hr_emps_arr($this->session->userdata('userid_ses'));
            if (!$hr_emps_data_arr) {
                $usr_arr = [
                    "draw" => ($_GET['draw']),
                    "search" => $_GET['search']['value'],
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => array()
                ];
                echo json_encode($usr_arr);
                exit;
            }
            $hr_emps_arr = $this->common_model->array_value_recursive("id", $hr_emps_data_arr);
            if (count($hr_emps_arr) > 1) {
                $arr = "login_user.id in (" . implode(",", $hr_emps_arr) . ")";
            } else {
                $arr = "login_user.id in (" . $hr_emps_arr . ")";
            }
        }

        if ($this->session->userdata('keyword')) {
            if ($arr) {
                $arr .= " AND ";
            }
            $arr .= "(login_user.name LIKE '%" . $this->session->userdata('keyword') . "%' or login_user.email LIKE '%" . $this->session->userdata('keyword') . "%')";
        }

        $data['keyword'] = $this->session->userdata('keyword');
        $this->session->unset_userdata('keyword');

        //$staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
        //$staff_list = $this->admin_model->get_staff_list($arr, $_GET['length'], $_GET['start']);
        $clarr = array();
        $searcharr = array();
        for ($cl = 0; $cl < count($_GET['columns']); $cl++) {
            array_push($clarr, $_GET['columns'][$cl]['data']);
            array_push($searcharr, $_GET['columns'][$cl]['search']['value']);
        }

       // error_reporting(0);
        $grparr = [];
        if (isset($searcharr)) {

            foreach ($searcharr as $key => $sa) {
                if ($sa != '') {
                    $grparr[$clarr[$key]] = $sa;
                }
            }

            if(!empty($grparr)) {

                $staff_list = $this->multi_array_search($this->admin_model->get_staff_list($arr), $grparr);
                $staff_total = count($staff_list);

            } else {

                $staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
                $staff_list  = $this->admin_model->get_staff_list($arr, $_GET['length'], $_GET['start']);

            }
        }

        if (isset($_GET['order'])) {
            if ($_GET['order'][0]['dir'] == 'desc') {
                $order = SORT_DESC;
            } else {
                $order = SORT_ASC;
            }

            $arr = $staff_list;
            $sort = array();
            foreach ($arr as $k => $v) {
                $sort[$clarr[$_GET['order'][0]['column']]][$k] = $v[$clarr[$_GET['order'][0]['column']]];
            }
            array_multisort($sort[$clarr[$_GET['order'][0]['column']]], $order, $arr);
            $staff_list = $arr;
        }

        $sr = [];
        if (!empty($_GET['search']['value'])) {
            $sr[] = [
                "sr" => $_GET['search']['value']
            ];
            $staff_list = in_array($_GET['search']['value'], $staff_list);
        } 

        $d = [
            "draw" => ($_GET['draw']),
            "search" => $_GET['search']['value'],
            "recordsTotal" => $staff_total,
            "recordsFiltered" => $staff_total,
            "data" => $staff_list,
            "myData" => "yes"
        ];

        echo json_encode($d);
    }

    // for search in array
    public function searchinarr($array, $search) {
        echo '<pre />';
//            print_r($array);
        print_r($search);
        die;
        //echo $value;

        $results = array();

        foreach ($search as $key => $value) {
            foreach ($array as $k => $val) {
                foreach ($val as $k => $v) {
                    if ($key == $k && $value == $v) {
//                                 echo $key.'->'.$value.'<br />';
//                                 echo $k.'->'.$val.'<br />';
                        if (strpos(strtolower($v), strtolower($value)) !== false) {
                            $results[] = $val;
                        }
                    }
                }
            }
        }




        /* if (is_array($array)) {
          if (isset($array[$key]) && $array[$key] == strpos($value,$value)) {
          $results[] = $array;
      } */

//			foreach ($array as $subarray) {
//				$results = array_merge($results, $this->searchinarr($subarray, $key, $value));
//			}
//		echo '<pre />';
//                print_r($results);
      return $results;
  }

  function multi_array_search($array, $search) {

        // Create the result array
    $result = array();
    $resultss = [];
        // Iterate over each array element
    foreach ($array as $key => $value) {

            // Iterate over each search condition
        foreach ($search as $k => $v) {
//                      if(strpos(strtolower($value[$k]),strtolower($v))!== false)
//                            {
//                                $resultss[] = $value;
//                            }
                // If the array element does not meet the search condition then continue to the next element
            if (!isset($value[$k]) || $value[$k] != (strpos(strtolower($value[$k]), strtolower($v)) !== false)) {

                continue 2;
            }
        }

            // Add the array element's key to the result array
        $result[] = $value;
    }
//                  echo '<pre />';
//                  print_r($resultss);
        // Return the result array
    return $result;
}

//	public function ajax_emp_not_in_rule_list($pc_id)
//	{
//		$data['msg'] = "";
//
//		if(!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME))
//		{
//			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></span></div>');
//			redirect(site_url("no-rights"));
//		}
//
//		if(!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME))
//		{
//			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></span></div>';
//		}
//
//		$arr = "";
//		if($this->input->post())
//		{
//			$this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
//		}
//
//
//                // not in rule start
//
//                $data['totalempinrule']=$this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$pc_id));
//
//             $empids='';
//                foreach($data['totalempinrule'] as $temp)
//                {
//                     $empids.=$temp['user_ids'];
//                }
//
//                //$data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);
////                echo count($data['emp_not_in_rule']); die;
//                // not in rule end
//		$data['keyword'] =	$this->session->userdata('keyword');
//		$this->session->unset_userdata('keyword');
//
//                if($this->session->userdata('keyword'))
//		{
//			$arr = "(login_user.id not in(".$empids.") )";
//		}
//
//                $arr = "(login_user.id not in(".$empids.") and login_user.status=1 )";
//                $staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
//
//                $staff_list = $this->admin_model->get_staff_list($arr,$_GET['length'],$_GET['start']);
////                 echo '<pre />'; print_r($_GET['start'].'-'.$_GET['length']);
////                 print_r($_GET);
////                 die;
//
//		$clarr=array();
//		$searcharr=array();
//		for($cl=0;$cl<count($_GET['columns']);$cl++)
//		{
//			array_push($clarr,$_GET['columns'][$cl]['data']);
//			array_push($searcharr,$_GET['columns'][$cl]['search']['value']);
//
//		}
//		error_reporting(0);
//		if(isset($searcharr))
//		{
//		   foreach($searcharr as $key=>$sa)
//		   {
//			   if($sa!='')
//			   {
//				   $vs= $clarr[$key];
//				   $arval=trim($sa);
////                                   print_r($staff_list);
//				   $staff_list=$this->searchinarr($this->admin_model->get_staff_list($arr),@$vs,@$arval);
//                                   $staff_total= count($staff_list);
//			   }
//
//		   }
//
//
//		}
//		//echo $clarr[$_GET['order'][0]['column']];
//		if(isset($_GET['order']))
//		{
//			if($_GET['order'][0]['dir']=='desc')
//			{
//				$order=SORT_DESC;
//			}
//			else
//			{
//				$order=SORT_ASC;
//			}
//
//			//$staff_list=$this->SortByKeyValue($staff_list,$clarr[$_GET['order'][0]['column']],$order);
//			$arr  = $staff_list;
//			$sort = array();
//			foreach($arr as $k=>$v) {
//				$sort[$clarr[$_GET['order'][0]['column']]][$k] = $v[$clarr[$_GET['order'][0]['column']]];
//			}
//			array_multisort($sort[$clarr[$_GET['order'][0]['column']]], $order, $arr);
//
////                    echo "<pre>";
////                    print_r($arr);
//			$staff_list=$arr;
//
//		}
//		$sr=[];
//		if(!empty($_GET['search']['value']))
//		{
//			$sr[]=[
//				"sr"=>$_GET['search']['value']
//			];
//			$staff_list=in_array($_GET['search']['value'],$staff_list);
//		}
//		$d=[
//			"draw"=>($_GET['draw']),
//			"search"=>$_GET['search']['value'],
//			"recordsTotal"=>$staff_total,
//			"recordsFiltered"=>$staff_total,
//			"data"=>$staff_list
//		];
//		echo json_encode($d);
//	}
//**   modify to function for searching of emp not in rule list **//
public function ajax_emp_not_in_rule_list($pc_id) {

    $data['msg'] = "";

    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
        $data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_add_right') . '</b></span></div>';
    }

    $arr = "";
    if ($this->input->post()) {
        $this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
    }

    //$data['totalempinrule'] = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id" => $pc_id));
    $condition_arr = array("performance_cycle_id" => $pc_id, "status !=" => 8);
    $data['totalempinrule'] = $this->common_model->get_table("hr_parameter", "id", $condition_arr, "id asc");

    $ruleIds = array();

    if(!empty($data['totalempinrule'])) {

        foreach ($data['totalempinrule'] as $temp) {
            $ruleIds[] = $temp['id'];
        }

    }

    $arr = "(login_user.id NOT IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id IN(" . implode(",", $ruleIds) . ")) and login_user.status=1 )";

    if ($this->session->userdata('keyword')) {

        if ($arr) {
            $arr .= "  AND ";
        }
        $arr .= "(login_user." . CV_BA_NAME_EMP_FULL_NAME . " LIKE '%" . $this->session->userdata('keyword') . "%' or login_user." . CV_BA_NAME_EMP_EMAIL . " LIKE '%" . $this->session->userdata('keyword') . "%')";
    }

    $data['keyword'] = $this->session->userdata('keyword');
    $this->session->unset_userdata('keyword');

    //$staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
    //$staff_list = $this->admin_model->get_staff_list($arr, $_GET['length'], $_GET['start']);

    $clarr = array();
    $searcharr = array();
    for ($cl = 0; $cl < count($_GET['columns']); $cl++) {
        array_push($clarr, $_GET['columns'][$cl]['data']);
        array_push($searcharr, $_GET['columns'][$cl]['search']['value']);
    }

    //error_reporting(0);
    $grparr = [];
    if (isset($searcharr)) {

        foreach ($searcharr as $key => $sa) {
            if ($sa != '') {
                $grparr[$clarr[$key]] = $sa;
            }
        }

        if(!empty($grparr)) {

            $staff_list = $this->multi_array_search($this->admin_model->get_staff_list($arr), $grparr);
            $staff_total = count($staff_list);

        } else {

            $staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
            $staff_list  = $this->admin_model->get_staff_list($arr, $_GET['length'], $_GET['start']);

        }

    }

    if (isset($_GET['order'])) {
        if ($_GET['order'][0]['dir'] == 'desc') {
            $order = SORT_DESC;
        } else {
            $order = SORT_ASC;
        }

        $arr = $staff_list;
        $sort = array();
        foreach ($arr as $k => $v) {
            $sort[$clarr[$_GET['order'][0]['column']]][$k] = $v[$clarr[$_GET['order'][0]['column']]];
        }
        array_multisort($sort[$clarr[$_GET['order'][0]['column']]], $order, $arr);
        $staff_list = $arr;
    }
    $sr = [];
    if (!empty($_GET['search']['value'])) {
        $sr[] = [
            "sr" => $_GET['search']['value']
        ];
        $staff_list = in_array($_GET['search']['value'], $staff_list);
    }
    $d = [
        "draw" => ($_GET['draw']),
        "search" => $_GET['search']['value'],
        "recordsTotal" => $staff_total,
        "recordsFiltered" => $staff_total,
        "data" => $staff_list
    ];
    echo json_encode($d);
}

//        public function ajax_emp_not_in_bonus_rule_list($pc_id)
//	{
//		$data['msg'] = "";
//
//		if(!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME))
//		{
//			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_view_right').'</b></div>');
//			redirect(site_url("no-rights"));
//		}
//
//		if(!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME))
//		{
//			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>'.$this->lang->line('msg_no_add_right').'</b></span></div>';
//		}
//
//		$arr = "";
//		if($this->input->post())
//		{
//			$this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
//		}
//
//
//                // not in rule start
//
//                $data['totalempinrule']=$this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id"=>$pc_id));
//
//             $empids='';
//                foreach($data['totalempinrule'] as $temp)
//                {
//                     $empids.=$temp['user_ids'];
//                }
//
////                $data['emp_not_in_rule']=$this->admin_model->getEmpNotInRule($empids);
////                echo count($data['emp_not_in_rule']); die;
//                // not in rule end
//		$data['keyword'] =	$this->session->userdata('keyword');
//		$this->session->unset_userdata('keyword');
//
//                if($this->session->userdata('keyword'))
//		{
//			$arr = "(login_user.id not in(".$empids."))";
//		}
//
//                $arr = "(login_user.id not in(".$empids.") and login_user.status=1 )";
//                $staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
//
//                $staff_list = $this->admin_model->get_staff_list($arr,$_GET['length'],$_GET['start']);
////                 echo '<pre />'; print_r($_GET['start'].'-'.$_GET['length']);
////                 print_r($_GET);
////                 die;
//
//		$clarr=array();
//		$searcharr=array();
//		for($cl=0;$cl<count($_GET['columns']);$cl++)
//		{
//			array_push($clarr,$_GET['columns'][$cl]['data']);
//			array_push($searcharr,$_GET['columns'][$cl]['search']['value']);
//
//		}
//		error_reporting(0);
//		if(isset($searcharr))
//		{
//		   foreach($searcharr as $key=>$sa)
//		   {
//			   if($sa!='')
//			   {
//				   $vs= $clarr[$key];
//				   $arval=trim($sa);
////                                   print_r($staff_list);
//				   $staff_list=$this->searchinarr($this->admin_model->get_staff_list($arr),@$vs,@$arval);
//                                   $staff_total= count($staff_list);
//			   }
//
//		   }
//
//
//		}
//		//echo $clarr[$_GET['order'][0]['column']];
//		if(isset($_GET['order']))
//		{
//			if($_GET['order'][0]['dir']=='desc')
//			{
//				$order=SORT_DESC;
//			}
//			else
//			{
//				$order=SORT_ASC;
//			}
//
//			//$staff_list=$this->SortByKeyValue($staff_list,$clarr[$_GET['order'][0]['column']],$order);
//			$arr  = $staff_list;
//			$sort = array();
//			foreach($arr as $k=>$v) {
//				$sort[$clarr[$_GET['order'][0]['column']]][$k] = $v[$clarr[$_GET['order'][0]['column']]];
//			}
//			array_multisort($sort[$clarr[$_GET['order'][0]['column']]], $order, $arr);
//
////                    echo "<pre>";
////                    print_r($arr);
//			$staff_list=$arr;
//
//		}
//		$sr=[];
//		if(!empty($_GET['search']['value']))
//		{
//			$sr[]=[
//				"sr"=>$_GET['search']['value']
//			];
//			$staff_list=in_array($_GET['search']['value'],$staff_list);
//		}
//		$d=[
//			"draw"=>($_GET['draw']),
//			"search"=>$_GET['search']['value'],
//			"recordsTotal"=>$staff_total,
//			"recordsFiltered"=>$staff_total,
//			"data"=>$staff_list
//		];
//		echo json_encode($d);
//	}
public function ajax_emp_not_in_bonus_rule_list($pc_id) {

    $data['msg'] = "";

    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
        $data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_add_right') . '</b></span></div>';
    }

    $arr = "";
    if ($this->input->post()) {
        $this->session->set_userdata('keyword', trim($this->input->post('txt_keyword')));
    }

    //$data['totalempinrule'] = $this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id" => $pc_id));
    $condition_arr = array("performance_cycle_id" => $pc_id, "status !=" => 8);
    $data['totalempinrule'] = $this->common_model->get_table("hr_parameter_bonus", "id", $condition_arr, "id asc");
    $ruleIds = array();

    if(!empty($data['totalempinrule'])) {

        foreach ($data['totalempinrule'] as $temp) {
            $ruleIds[] = $temp['id'];
        }
    }

    //$arr = "(login_user.id NOT IN (" . $empids . ") and login_user.status=1 )";
    $arr = "(login_user.id NOT IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id IN (" . implode(",", $ruleIds) . ")) and login_user.status=1 )";

    if ($this->session->userdata('keyword')) {

        if ($arr) {
            $arr .= "  AND ";
        }

        $arr .= "(login_user." . CV_BA_NAME_EMP_FULL_NAME . " LIKE '%" . $this->session->userdata('keyword') . "%' or login_user." . CV_BA_NAME_EMP_EMAIL . " LIKE '%" . $this->session->userdata('keyword') . "%')";
    }


    $data['keyword'] = $this->session->userdata('keyword');
    $this->session->unset_userdata('keyword');
    //$staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
    //$staff_list = $this->admin_model->get_staff_list($arr, $_GET['length'], $_GET['start']);

    $clarr = array();
    $searcharr = array();
    for ($cl = 0; $cl < count($_GET['columns']); $cl++) {
        array_push($clarr, $_GET['columns'][$cl]['data']);
        array_push($searcharr, $_GET['columns'][$cl]['search']['value']);
    }

    //error_reporting(0);
    $grparr = [];
    if (isset($searcharr)) {
        foreach ($searcharr as $key => $sa) {
            if ($sa != '') {
                $grparr[$clarr[$key]] = $sa;
            }
        }

        if(!empty($grparr)) {

            $staff_list = $this->multi_array_search($this->admin_model->get_staff_list($arr), $grparr);
            $staff_total = count($staff_list);

        } else {

            $staff_total = $this->admin_model->get_staff_list($arr, 0, 0);
            $staff_list = $this->admin_model->get_staff_list($arr, $_GET['length'], $_GET['start']);

        }

    }

    if (isset($_GET['order'])) {
        if ($_GET['order'][0]['dir'] == 'desc') {
            $order = SORT_DESC;
        } else {
            $order = SORT_ASC;
        }

        $arr = $staff_list;
        $sort = array();
        foreach ($arr as $k => $v) {
            $sort[$clarr[$_GET['order'][0]['column']]][$k] = $v[$clarr[$_GET['order'][0]['column']]];
        }
        array_multisort($sort[$clarr[$_GET['order'][0]['column']]], $order, $arr);
        $staff_list = $arr;
    }
    $sr = [];
    if (!empty($_GET['search']['value'])) {
        $sr[] = [
            "sr" => $_GET['search']['value']
        ];
        $staff_list = in_array($_GET['search']['value'], $staff_list);
    }
    $d = [
        "draw" => ($_GET['draw']),
        "search" => $_GET['search']['value'],
        "recordsTotal" => $staff_total,
        "recordsFiltered" => $staff_total,
        "data" => $staff_list
    ];
    echo json_encode($d);
}

public function empbonusexport($pc_id) {
    $data['msg'] = "";

    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
        $data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_add_right') . '</b></div>';
    }


    $data['totalempinrule'] = $this->performance_cycle_model->get_bonus_rules_list(array("hr_parameter_bonus.performance_cycle_id" => $pc_id));

    $empids = '';
    foreach ($data['totalempinrule'] as $temp) {
        $empids .= $temp['user_ids'];
    }
    $arr = "(login_user.id not in(" . $empids . ") and login_user.status=1 )";
    $staff_list = $this->admin_model->get_staff_list($arr);
    $staff_list = GetEmpAllDataFromEmpId($staff_list);
    downloadcsv($staff_list);
}

public function empexport($pc_id) {

    $data['msg'] = "";

    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }

    if (!helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME)) {
        $data['msg'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_add_right') . '</b></div>';
    }


    $data['totalempinrule'] = $this->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id" => $pc_id));
    $empids = array();
    foreach ($data['totalempinrule'] as $temp) {
            //$empids.=$temp['user_ids'];
        $empids[] = $temp['id'];
    }
    $arr = "(login_user.id not in(SELECT user_id FROM salary_rule_users_dtls WHERE rule_id IN(" . implode(",", $empids) . ")) )";
    $staff_list = $this->admin_model->get_staff_list($arr);
    $staff_list = GetEmpAllDataFromEmpId($staff_list);
    downloadcsv($staff_list);
}

public function comingsoonlti() {

    $data['title'] = "Coming soon";
    $data['body'] = "coming_soon";
    $data['dashboard'] = "admin/dashboard/";
    $data['message'] = "This section can customized as per organization requirement.";
    $this->load->view('common/structure', $data);
}

public function comingsoonrandr() {

    $data['title'] = "Coming soon";
    $data['body'] = "coming_soon";
    $data['dashboard'] = "admin/dashboard/";
    $data['message'] = "This section can customized as per organization requirement.";
    $this->load->view('common/structure', $data);
}

public function comingsoonreport() {

    $data['title'] = "Coming soon";
    $data['body'] = "coming_soon";
    $data['dashboard'] = "admin/dashboard/";
    $data['message'] = "This section can customized as per organization requirement.";
    $this->load->view('common/structure', $data);
}

public function myemployee() {
    $this->load->model("manager_model");
    if (!helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_no_view_right') . '</b></div>');
        redirect(site_url("no-rights"));
    }

    $data['msg'] = "";
    $data["staff_list"] = $this->manager_model->list_of_manager_emps();
    $data['business_attributes'] = $this->common_model->get_table("business_attribute", "id, display_name", "", "id asc");
    $data['title'] = "Manager Team";
    $data['body'] = "manager/team";
    $this->load->view('common/structure', $data);
}

public function autocomplete_email_for_approver() {
    $term = $this->input->get('term', TRUE);
    $this->admin_model->autocompleteformanager($term);
}

public function edit_company_logo() {
    $this->load->helper('imagecroper_helper');
    $data['msg'] = "";
    $data["company_dtl"] = $this->admin_model->get_table_row("manage_company", "*", array("id" => $this->session->userdata('companyid_ses')));
    if ($data["company_dtl"]) {
        if ($this->input->post()) {
            $post = isset($_POST) ? $_POST : array();
            $userId = isset($post['id']) ? intval($post['id']) : 0;
                $t_width = 300; // Maximum thumbnail width
                $t_height = 300;    // Maximum thumbnail height
                if (isset($_POST['t']) and $_POST['t'] == "ajax") {
                    extract($_POST);
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/user-portal/uploads/comp_logos/' . $_POST['image_name'];
                    $ratio = ($t_width / $w1);
                    $nw = ceil($w1 * $ratio);
                    $nh = ceil($h1 * $ratio);
                    $nimg = imagecreatetruecolor($nw, $nh);
                    $im_src = imagecreatefromjpeg($imagePath);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w1, $h1);
                    imagejpeg($nimg, $imagePath, 90);
                }
                $comlogo = base_url('uploads/comp_logos/' . $_POST['image_name']) . '?' . time();
                $db_arr = ["company_logo" => $comlogo];
                $this->admin_model->update_tbl_data("manage_company", $db_arr, array("id" => $this->session->userdata('companyid_ses')));
                $dbname = CV_PLATFORM_DB_NAME;
                $this->db->query("Use $dbname");
                $this->db->where(array("manage_company.id" => $this->session->userdata('companyid_ses')));
                $this->db->update("manage_company", $db_arr);
                if (isset($db_arr['company_logo']) and $db_arr['company_logo'] != "") {
                    $new_ses_arr["company_logo_ses"] = $db_arr['company_logo'];
                }
                if (isset($db_arr['company_bg_img']) and $db_arr['company_bg_img'] != "") {
                    $new_ses_arr["company_bg_img_url_ses"] = $db_arr['company_bg_img'];
                }
                $this->session->set_userdata($new_ses_arr);

                echo json_encode(
                    array('status' => 'image updated successfully',
                        'image' => $comlogo
                    ));
            }
        } else {
            echo json_encode(array('status' => 'Error while update image'));
        }
    }

    public function edit_company_bg() {
        $this->load->helper('imagecroper_helper');
        $data['msg'] = "";
        $data["company_dtl"] = $this->admin_model->get_table_row("manage_company", "*", array("id" => $this->session->userdata('companyid_ses')));
        if ($data["company_dtl"]) {
            if ($this->input->post()) {
                $post = isset($_POST) ? $_POST : array();
                $userId = isset($post['id']) ? intval($post['id']) : 0;
                $t_width = 300; // Maximum thumbnail width
                $t_height = 300;    // Maximum thumbnail height
                if (isset($_POST['t']) and $_POST['t'] == "ajax") {
                    extract($_POST);
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/user-portal/uploads/comp_logos/' . $_POST['image_name'];
                    $ratio = ($t_width / $w1);
                    $nw = ceil($w1 * $ratio);
                    $nh = ceil($h1 * $ratio);
                    $nimg = imagecreatetruecolor($nw, $nh);
                    $im_src = imagecreatefromjpeg($imagePath);
                    imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w1, $h1);
                    imagejpeg($nimg, $imagePath, 90);
                }
                $comlogo = base_url('uploads/comp_logos/' . $_POST['image_name']) . '?' . time();
                $db_arr = ["company_bg_img" => $comlogo];
                $this->admin_model->update_tbl_data("manage_company", $db_arr, array("id" => $this->session->userdata('companyid_ses')));
                $dbname = CV_PLATFORM_DB_NAME;
                $this->db->query("Use $dbname");
                $this->db->where(array("manage_company.id" => $this->session->userdata('companyid_ses')));
                $this->db->update("manage_company", $db_arr);
                if (isset($db_arr['company_logo']) and $db_arr['company_logo'] != "") {
                    $new_ses_arr["company_logo_ses"] = $db_arr['company_logo'];
                }
                if (isset($db_arr['company_bg_img']) and $db_arr['company_bg_img'] != "") {
                    $new_ses_arr["company_bg_img_url_ses"] = $db_arr['company_bg_img'];
                }
                $this->session->set_userdata($new_ses_arr);
                echo json_encode(
                    array('status' => 'image updated successfully',
                        'image' => $comlogo
                    ));
            }
        } else {
            echo json_encode(array('status' => 'Error while update image'));
        }
    }

    function changeProfilePic() {
        $this->load->helper('imagecroper_helper');
        $post = isset($_POST) ? $_POST : array();
        $max_width = "2064";
        $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = $_SERVER['DOCUMENT_ROOT'] . '/user-portal/uploads/comp_logos';
        $valid_formats = array("jpg", "png", "gif", "jpeg");
        $name = $_FILES['profile-pic']['name'];
        $size = $_FILES['profile-pic']['size'];
        if (strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            if (in_array($ext, $valid_formats)) {

                $actual_image_name = time() . '_' . $userId . '.' . $ext;
                $filePath = $path . '/' . $actual_image_name;
                $tmp = $_FILES['profile-pic']['tmp_name'];
                if (move_uploaded_file($tmp, $filePath)) {
                    $width = getWidth($filePath);
                    $height = getHeight($filePath);
                    //Scale the image if it is greater than the width set above
                    if ($width > $max_width) {
                        $scale = $max_width / $width;
                        $uploaded = resizeImage($filePath, $width, $height, $scale, $ext);
                    } else {
                        $scale = 1;
                        $uploaded = resizeImage($filePath, $width, $height, $scale, $ext);
                    }
                    echo "<img id='photo'  file-name='" . $actual_image_name . "' class='img-responsive' src='" . base_url('uploads/comp_logos/') . $actual_image_name . '?' . time() . "' class='preview'/>";
                } else
                echo "failed";
            } else
            echo "Invalid file format..";
        } else
        echo "Please select image..!";
        exit;
    }

    function changeProfilePicbg() {
        $this->load->helper('imagecroper_helper');
        $post = isset($_POST) ? $_POST : array();
        $max_width = "2064";
        $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = $_SERVER['DOCUMENT_ROOT'] . '/user-portal/uploads/comp_logos';
        $valid_formats = array("jpg", "png", "gif", "jpeg");
        $name = $_FILES['bg-pic']['name'];
        $size = $_FILES['bg-pic']['size'];
        if (strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            if (in_array($ext, $valid_formats)) {

                $actual_image_name = time() . '_' . $userId . '.' . $ext;
                $filePath = $path . '/' . $actual_image_name;
                $tmp = $_FILES['bg-pic']['tmp_name'];
                if (move_uploaded_file($tmp, $filePath)) {
                    $width = getWidth($filePath);
                    $height = getHeight($filePath);
                    //Scale the image if it is greater than the width set above
                    if ($width > $max_width) {
                        $scale = $max_width / $width;
                        $uploaded = resizeImage($filePath, $width, $height, $scale, $ext);
                    } else {
                        $scale = 1;
                        $uploaded = resizeImage($filePath, $width, $height, $scale, $ext);
                    }
                    echo "<img id='photo' file-name='" . $actual_image_name . "' class='img-responsive' src='" . base_url('uploads/comp_logos/') . $actual_image_name . '?' . time() . "' class='preview'/>";
                } else
                echo "failed";
            } else
            echo "Invalid file format..";
        } else
        echo "Please select image..!";
        exit;
    }

    // Code end by omkar
    public function employee_graph_filters($Esg_id = '') {
        if ($Esg_id != '') {
            $data['survey'] = $this->Empgraph_model->get_data('emp_salary_graph_txt_dtls', $where = ['Esg_id' => $Esg_id]);
        }
        $data["msg"] = "";
        $user_id = $this->session->userdata('userid_ses');
        $data['right_dtls'] = $this->common_model->get_table("rights_on_country", "*", array("status" => 1, "user_id" => $user_id), "id desc");

//		if(!$data['right_dtls'])
//		{
//			$this->session->set_flashdata("message", "<div align='left' style='color:red;' id='notify'><span><b>Your right's criteria not set yet. Please contact your admin.</b></span></div>");
//			redirect(site_url("dashboard"));
//		}

        $country_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_country", "country_id", array("status" => 1, "user_id" => $user_id), "manage_country");
        $city_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_city", "city_id", array("status" => 1, "user_id" => $user_id), "manage_city");
        $bl1_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_1", "business_level_1_id", array("status" => 1, "user_id" => $user_id), "manage_business_level_1");
        $bl2_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_2", "business_level_2_id", array("status" => 1, "user_id" => $user_id), "manage_business_level_2");
        $bl3_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_business_level_3", "business_level_3_id", array("status" => 1, "user_id" => $user_id), "manage_business_level_3");

        $designation_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_designations", "designation_id", array("status" => 1, "user_id" => $user_id), "manage_designation");
        $function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_functions", "function_id", array("status" => 1, "user_id" => $user_id), "manage_function");
        $sub_function_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_sub_functions", "sub_function_id", array("status" => 1, "user_id" => $user_id), "manage_subfunction");
        $grade_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_grades", "grade_id", array("status" => 1, "user_id" => $user_id), "manage_grade");
        $level_arr_view = $this->common_model->get_user_rights_comma_seprated("rights_on_levels", "level_id", array("status" => 1, "user_id" => $user_id), "manage_level");
        $data['education_list'] = $this->common_model->get_table("manage_education", "id, name", "status = 1", "name asc");
        $data['critical_talent_list'] = $this->common_model->get_table("manage_critical_talent", "id, name", "status = 1", "name asc");
        $data['critical_position_list'] = $this->common_model->get_table("manage_critical_position", "id, name", "status = 1", "name asc");
        $data['special_category_list'] = $this->common_model->get_table("manage_special_category", "id, name", "status = 1", "name asc");

        if ($this->input->post()) {
            if (!$this->input->post("hf_select_all_filters")) {
                if (in_array('all', $this->input->post("ddl_country"))) {
                    $country_arr = $country_arr_view;
                } else {
                    $country_arr = implode(",", $this->input->post("ddl_country"));
                }

                if (in_array('all', $this->input->post("ddl_city"))) {
                    $city_arr = $city_arr_view;
                } else {
                    $city_arr = implode(",", $this->input->post("ddl_city"));
                }

                if (in_array('all', $this->input->post("ddl_bussiness_level_1"))) {
                    $bussiness_level_1_arr = $bl1_arr_view;
                } else {
                    $bussiness_level_1_arr = implode(",", $this->input->post("ddl_bussiness_level_1"));
                }

                if (in_array('all', $this->input->post("ddl_bussiness_level_2"))) {
                    $bussiness_level_2_arr = $bl2_arr_view;
                } else {
                    $bussiness_level_2_arr = implode(",", $this->input->post("ddl_bussiness_level_2"));
                }

                if (in_array('all', $this->input->post("ddl_bussiness_level_3"))) {
                    $bussiness_level_3_arr = $bl3_arr_view;
                } else {
                    $bussiness_level_3_arr = implode(",", $this->input->post("ddl_bussiness_level_3"));
                }

                if (in_array('all', $this->input->post("ddl_function"))) {
                    $function_arr = $function_arr_view;
                } else {
                    $function_arr = implode(",", $this->input->post("ddl_function"));
                }

                if (in_array('all', $this->input->post("ddl_sub_function"))) {
                    $sub_function_arr = $sub_function_arr_view;
                } else {
                    $sub_function_arr = implode(",", $this->input->post("ddl_sub_function"));
                }

                if (in_array('all', $this->input->post("ddl_designation"))) {
                    $designation_arr = $designation_arr_view;
                } else {
                    $designation_arr = implode(",", $this->input->post("ddl_designation"));
                }

                if (in_array('all', $this->input->post("ddl_grade"))) {
                    $grade_arr = $grade_arr_view;
                } else {
                    $grade_arr = implode(",", $this->input->post("ddl_grade"));
                }

                if (in_array('all', $this->input->post("ddl_level"))) {
                    $level_arr = $level_arr_view;
                } else {
                    $level_arr = implode(",", $this->input->post("ddl_level"));
                }

                if (in_array('all', $this->input->post("ddl_education"))) {
                    $temp_arr = array();
                    $education_arr = "";
                    foreach ($data['education_list'] as $item_row) {
                        array_push($temp_arr, $item_row["id"]);
                    }
                    if ($temp_arr) {
                        $education_arr = implode(",", $temp_arr);
                    }
                } else {
                    $education_arr = implode(",", $this->input->post("ddl_education"));
                }

                if (in_array('all', $this->input->post("ddl_critical_talent"))) {
                    $temp_arr = array();
                    $critical_talent_arr = "";
                    foreach ($data['critical_talent_list'] as $item_row) {
                        array_push($temp_arr, $item_row["id"]);
                    }
                    if ($temp_arr) {
                        $critical_talent_arr = implode(",", $temp_arr);
                    }
                } else {
                    $critical_talent_arr = implode(",", $this->input->post("ddl_critical_talent"));
                }

                if (in_array('all', $this->input->post("ddl_critical_position"))) {
                    $temp_arr = array();
                    $critical_position_arr = "";
                    foreach ($data['critical_position_list'] as $item_row) {
                        array_push($temp_arr, $item_row["id"]);
                    }
                    if ($temp_arr) {
                        $critical_position_arr = implode(",", $temp_arr);
                    }
                } else {
                    $critical_position_arr = implode(",", $this->input->post("ddl_critical_position"));
                }

                if (in_array('all', $this->input->post("ddl_special_category"))) {
                    $temp_arr = array();
                    $special_category_arr = "";
                    foreach ($data['special_category_list'] as $item_row) {
                        array_push($temp_arr, $item_row["id"]);
                    }
                    if ($temp_arr) {
                        $special_category_arr = implode(",", $temp_arr);
                    }
                } else {
                    $special_category_arr = implode(",", $this->input->post("ddl_special_category"));
                }

                if (in_array('all', $this->input->post("ddl_tenure_company"))) {
                    $temp_arr = array();
                    for ($i = 0; $i <= 35; $i++) {
                        array_push($temp_arr, $i);
                    }
                    if ($temp_arr) {
                        $tenure_company_arr = implode(",", $temp_arr);
                    }
                } else {
                    $tenure_company_arr = implode(",", $this->input->post("ddl_tenure_company"));
                }

                if (in_array('all', $this->input->post("ddl_tenure_role"))) {
                    $temp_arr = array();
                    for ($i = 0; $i <= 35; $i++) {
                        array_push($temp_arr, $i);
                    }
                    if ($temp_arr) {
                        $tenure_role_arr = implode(",", $temp_arr);
                    }
                } else {
                    $tenure_role_arr = implode(",", $this->input->post("ddl_tenure_role"));
                }
                $where = "login_user.role > 1 and login_user.status = 1";
                if ($country_arr) {
                    $where .= " and login_user." . CV_BA_NAME_COUNTRY . " in (" . $country_arr . ")";
                }

                if ($city_arr) {
                    $where .= " and login_user." . CV_BA_NAME_CITY . " in (" . $city_arr . ")";
                }

                if ($bussiness_level_1_arr) {
                    $where .= " and login_user." . CV_BA_NAME_BUSINESS_LEVEL_1 . " in (" . $bussiness_level_1_arr . ")";
                }

                if ($bussiness_level_2_arr) {
                    $where .= " and login_user." . CV_BA_NAME_BUSINESS_LEVEL_2 . " in (" . $bussiness_level_2_arr . ")";
                }

                if ($bussiness_level_3_arr) {
                    $where .= " and login_user." . CV_BA_NAME_BUSINESS_LEVEL_3 . " in (" . $bussiness_level_3_arr . ")";
                }

                if ($function_arr) {
                    $where .= " and login_user." . CV_BA_NAME_FUNCTION . " in (" . $function_arr . ")";
                }

                if ($sub_function_arr) {
                    $where .= " and login_user." . CV_BA_NAME_SUBFUNCTION . " in (" . $sub_function_arr . ")";
                }

                if ($designation_arr) {
                    $where .= " and login_user." . CV_BA_NAME_DESIGNATION . " in (" . $designation_arr . ")";
                }

                if ($grade_arr) {
                    $where .= " and login_user." . CV_BA_NAME_GRADE . " in (" . $grade_arr . ")";
                }

                if ($level_arr) {
                    $where .= " and login_user." . CV_BA_NAME_LEVEL . " in (" . $level_arr . ")";
                }

                if ($education_arr) {
                    $where .= " and login_user." . CV_BA_NAME_EDUCATION . " in (" . $education_arr . ")";
                }

                if ($critical_talent_arr) {
                    $where .= " and login_user." . CV_BA_NAME_CRITICAL_TALENT . " in (" . $critical_talent_arr . ")";
                }

                if ($critical_position_arr) {
                    $where .= " and login_user." . CV_BA_NAME_CRITICAL_POSITION . " in (" . $critical_position_arr . ")";
                }

                if ($special_category_arr) {
                    $where .= " and login_user." . CV_BA_NAME_SPECIAL_CATEGORY . " in (" . $special_category_arr . ")";
                }

                if ($tenure_company_arr) {
                    $where .= " and login_user.tenure_company in (" . $tenure_company_arr . ")";
                }

                if ($tenure_role_arr) {
                    $where .= " and login_user.tenure_role in (" . $tenure_role_arr . ")";
                }

                //CB:: Because we have no need to check duplicate emps in a cycle for a rules
                /* if($already_created_rule_for_emp_ids)
                  {
                  $where .= " and login_user.id not in (".implode(",",$already_created_rule_for_emp_ids).")";
              } */
              if ($this->input->post('survey_for') == "manager") {
                $where .= " and login_user.is_manager=1";
            }
            if ($this->input->post('survey_for') == "employee") {
                $where .= " and login_user.is_manager != 1";
            }
            $this->load->model('admin_model');
            $user_ids_arr = array();
            $data['employees'] = $this->admin_model->get_employees_as_per_rights($where);
            foreach ($data['employees'] as $row) {
                $user_ids_arr[] = $row["id"];
            }

            if ($this->input->post("btn_confirm_selection")) {
                $usr_ids = implode(",", $user_ids_arr);
                $choosed_filter_data_arr = array(
                    "graph_for" => $this->input->post('survey_for'),
                    "country" => HLP_get_unique_ids_for_filters($usr_ids, $country_arr, CV_BA_NAME_COUNTRY),
                    "city" => HLP_get_unique_ids_for_filters($usr_ids, $city_arr, CV_BA_NAME_CITY),
                    "business_level1" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_1_arr, CV_BA_NAME_BUSINESS_LEVEL_1),
                    "business_level2" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_2_arr, CV_BA_NAME_BUSINESS_LEVEL_2),
                    "business_level3" => HLP_get_unique_ids_for_filters($usr_ids, $bussiness_level_3_arr, CV_BA_NAME_BUSINESS_LEVEL_3),
                    "functions" => HLP_get_unique_ids_for_filters($usr_ids, $function_arr, CV_BA_NAME_FUNCTION),
                    "sub_functions" => HLP_get_unique_ids_for_filters($usr_ids, $sub_function_arr, CV_BA_NAME_SUBFUNCTION),
                    "designations" => HLP_get_unique_ids_for_filters($usr_ids, $designation_arr, CV_BA_NAME_DESIGNATION),
                    "grades" => HLP_get_unique_ids_for_filters($usr_ids, $grade_arr, CV_BA_NAME_GRADE),
                    "levels" => HLP_get_unique_ids_for_filters($usr_ids, $level_arr, CV_BA_NAME_LEVEL),
                    "educations" => HLP_get_unique_ids_for_filters($usr_ids, $education_arr, CV_BA_NAME_EDUCATION),
                    "critical_talents" => HLP_get_unique_ids_for_filters($usr_ids, $critical_talent_arr, CV_BA_NAME_CRITICAL_TALENT),
                    "critical_positions" => HLP_get_unique_ids_for_filters($usr_ids, $critical_position_arr, CV_BA_NAME_CRITICAL_POSITION),
                    "special_category" => HLP_get_unique_ids_for_filters($usr_ids, $special_category_arr, CV_BA_NAME_SPECIAL_CATEGORY),
                    "tenure_company" => $tenure_company_arr,
                    "tenure_roles" => $tenure_role_arr
                );

                if ($this->input->post('survey_id') != '') {
                    $data['survey'][0] = array_merge($data['survey'][0], $choosed_filter_data_arr);
                } else {
                    $data['survey'][0] = $choosed_filter_data_arr;
                }
            } else {
                $userIDs = array('userIDGraph' => implode(",", $user_ids_arr));
                $this->session->set_userdata($userIDs);

                    /* $db_arr["status"] = 1;
                      $db_arr["createdby"] = $this->session->userdata('userid_ses');
                      $db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
                      $db_arr["createdon"] = date("Y-m-d H:i:s"); */
                      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filter saved successfully. Total ' . count($user_ids_arr) . ' employee in this filter</b></div>');
                      redirect(base_url('admin/admin_dashboard/employee_graph_create/'));
                  }
              }
          }

          if ($country_arr_view) {
            $data['country_list'] = $this->common_model->get_table("manage_country", "id, name", "status = 1 and id in (" . $country_arr_view . ")", "name asc");
        } else {
            $data['country_list'] = $this->common_model->get_table("manage_country", "id, name", "status = 1", "name asc");
        }

        if ($city_arr_view) {
            $data['city_list'] = $this->common_model->get_table("manage_city", "id, name", "status = 1 and id in (" . $city_arr_view . ")", "name asc");
        } else {
            $data['city_list'] = $this->common_model->get_table("manage_city", "id, name", "status = 1", "name asc");
        }

        if ($bl1_arr_view) {
            $data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1", "id, name", "status = 1 and id in(" . $bl1_arr_view . ")", "name asc");
        } else {
            $data['bussiness_level_1_list'] = $this->common_model->get_table("manage_business_level_1", "id, name", "status = 1", "name asc");
        }

        if ($bl2_arr_view) {
            $data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2", "id, name", "status = 1 and id in(" . $bl2_arr_view . ")", "name asc");
        } else {
            $data['bussiness_level_2_list'] = $this->common_model->get_table("manage_business_level_2", "id, name", "status = 1", "name asc");
        }

        if ($bl3_arr_view) {
            $data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3", "id, name", "status = 1 and id in(" . $bl3_arr_view . ")", "name asc");
        } else {
            $data['bussiness_level_3_list'] = $this->common_model->get_table("manage_business_level_3", "id, name", "status = 1", "name asc");
        }

        if ($designation_arr_view) {
            $data['designation_list'] = $this->common_model->get_table("manage_designation", "id, name", "status = 1 and id in(" . $designation_arr_view . ")", "name asc");
        } else {
            $data['designation_list'] = $this->common_model->get_table("manage_designation", "id, name", "status = 1", "name asc");
        }

        if ($function_arr_view) {
            $data['function_list'] = $this->common_model->get_table("manage_function", "id, name", "status = 1 and id in(" . $function_arr_view . ")", "name asc");
        } else {
            $data['function_list'] = $this->common_model->get_table("manage_function", "id, name", "status = 1", "name asc");
        }

        if ($sub_function_arr_view) {
            $data['sub_function_list'] = $this->common_model->get_table("manage_subfunction", "id, name", "status = 1 and id in(" . $sub_function_arr_view . ")", "name asc");
        } else {
            $data['sub_function_list'] = $this->common_model->get_table("manage_subfunction", "id, name", "status = 1", "name asc");
        }

        if ($grade_arr_view) {
            $data['grade_list'] = $this->common_model->get_table("manage_grade", "id, name", "status = 1 and id in(" . $grade_arr_view . ")", "name asc");
        } else {
            $data['grade_list'] = $this->common_model->get_table("manage_grade", "id, name", "status = 1", "name asc");
        }

        if ($level_arr_view) {
            $data['level_list'] = $this->common_model->get_table("manage_level", "id, name", "status = 1 and id in(" . $level_arr_view . ")", "name asc");
        } else {
            $data['level_list'] = $this->common_model->get_table("manage_level", "id, name", "status = 1", "name asc");
        }

        $data['title'] = "Total Rewards Page settings";
        $data['body'] = "admin/employee_graph_filters";
        $this->load->view('common/structure', $data);
    }

    function employee_graph_create($Esg_id = '') {
        $data['esg'] = $this->Empgraph_model->get_data('emp_salary_graph_txt_dtls', $where = ['esg_id' => $Esg_id]);
        if ($this->input->post()) {
            $left = array(
                'top_left' => $this->input->post('left'),
                'center_left' => $this->input->post('left_center'),
                'bottom_left' => $this->input->post('left_bottom'),
            );

            $right = array(
                'top_right' => $this->input->post('right'),
                'center_right' => $this->input->post('right_center'),
                'bottom_right' => $this->input->post('right_bottom'),
            );

            /* if($this->input->post('survey_id')=='')
              {
              $Esg_id=$this->Empgraph_model->savedata('emp_salary_graph_txt_dtls',$db_arr);
              }
              else {
              $this->Empgraph_model->updatedata('emp_salary_graph_txt_dtls',$db_arr,$where=['Esg_id'=>$this->input->post('survey_id')]);
              $Esg_id=$this->input->post('survey_id');
          } */
          if ($Esg_id == '') {
            $ids = explode(',', $this->input->post('userids'));
            for ($i = 0; $i < count($ids); $i++) {
                $db_arr = [
                    "user_id" => $ids[$i],
                    "updatedby" => $this->session->userdata('userid_ses'),
                    "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
                    "updatedon" => date("Y-m-d H:i:s"),
                    "left_half" => json_encode($left, TRUE),
                    "right_half" => json_encode($right, TRUE),
                    "status" => 1,
                ];
                    //$Esg_id = $this->Empgraph_model->savedata('emp_salary_graph_txt_dtls',$db_arr);
                $this->Empgraph_model->savedata('emp_salary_graph_txt_dtls', $db_arr);
            }
        }
        if ($Esg_id != '') {
            $db_arr = [
                "updatedby" => $this->session->userdata('userid_ses'),
                "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
                "updatedon" => date("Y-m-d H:i:s"),
                "left_half" => json_encode($left, TRUE),
                "right_half" => json_encode($right, TRUE),
            ];
            $Esg_id = $this->Empgraph_model->updatedata('emp_salary_graph_txt_dtls', $db_arr, $where = ['esg_id' => $this->input->post('Esg_id')]);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b><b>Data saved successfully.</b></div>');
        redirect(base_url('admin/admin_dashboard/employee_graph'));
    }
    $data['Esg_id'] = $Esg_id;
    $data['title'] = "Employee salary graph create";
    $data['body'] = "admin/create_emp_sal_graph";
    $this->load->view('common/structure', $data);
}

function employee_graph() {
    $data['survey'] = $this->Empgraph_model->getData('emp_salary_graph_txt_dtls');
    $data['title'] = "Employee graph listing";
    $data['body'] = "admin/employee_graph";
    $this->load->view('common/structure', $data);
}

public function tenure_classification($id = 0) {
    $data['msg'] = "";
//        if (!helper_have_rights(CV_CITY_ID, CV_VIEW_RIGHT_NAME)) {
//            redirect(site_url("no-rights"));
//        }
    if ($this->input->post()) {

        //$this->admin_model->delete_table("tenure_classification");
		$this->db->truncate('tenure_classification');
        $c_slot = count($this->input->post('txt_slot'));
        for ($i = 0; $i <= $c_slot; $i++) {
            $slot = $this->input->post('txt_slot')[$i];
            $start = $this->input->post('txt_start')[$i];
            $end = $this->input->post('txt_end')[$i];
            if ($i == $c_slot) {
                $slot = "> ".$this->input->post('txt_end')[$i - 1];
                $start = $this->input->post('txt_end')[$i - 1];
                $end = 1000;
            }

            $db_arr = array(
                "slot_no" => $slot,
                "start_month" => $start,
                "end_month" => $end,
                "status" => CV_STATUS_ACTIVE,
                "createdby" => $this->session->userdata('userid_ses'),
                "createdby_proxy" => $this->session->userdata('proxy_userid_ses'),
                "createdon" => date("Y-m-d H:i:s")
            );
            $this->admin_model->insert_data_in_tbl("tenure_classification", $db_arr);
        }
            // die();
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New tenure created successfully.</b></div>');

        redirect(site_url("tenure-classification"));
    }


    $data['list'] = $this->admin_model->get_tenure_list();

    $data['title'] = "Set Min Salary Tenure/Band wise";
    $data['url_key'] = "tenure-classification";
    $data['body'] = "admin/tenure_classification";
    $this->load->view('common/structure', $data);
}

function key_cross_cell_bonus() {

    $subfarr = [];
    $subfcountarr = [];
    $functionlist = $this->common_model->get_table("manage_function", "id, name", "status = 1", "name asc");
    $gradelist = $this->common_model->get_table("manage_grade", "id, name", "status = 1", "order_no asc");
    foreach ($functionlist as $val) {
            //echo $val['id'];
        $sublist = $this->admin_model->get_subfunction_list($val['id']);
        $sublistidcount = $this->admin_model->get_count_subfunction_list($val['id']);
        array_push($subfarr, $sublist);
        array_push($subfcountarr, $sublistidcount);
    }
    $data['functionlist'] = $functionlist;
    $data['subfunctionlist'] = $subfarr;
    $data['subcount'] = $subfcountarr;
    $data['gradelist'] = $gradelist;

    if ($this->input->post()) {
        $this->admin_model->delete_table("key_cross_cell_bonus");
        for ($l = 0; $l < count($gradelist); $l++) {
            for ($j = 0; $j < count($functionlist); $j++) {
                for ($k = 0; $k < count($subfarr[$j]); $k++) {
                    $this->form_validation->set_rules("txt_per_val_" . $subfarr[$j][$k]['id'] . "_" . $functionlist[$j]['id'] . "_" . $gradelist[$l]['id'], '%age Value', 'trim|required');

                    if ($this->form_validation->run()) {
                        $db_arr = array(
                            "grade_id" => $gradelist[$l]['id'],
                            "function_id" => $functionlist[$j]['id'],
                            "subfunction_id" => $subfarr[$j][$k]['id'],
                            "per_val" => $this->input->post("txt_per_val_" . $subfarr[$j][$k]['id'] . "_" . $functionlist[$j]['id'] . "_" . $gradelist[$l]['id']),
                            "createdby" => $this->session->userdata('userid_ses'),
                            "createdby_proxy" => $this->session->userdata('proxy_userid_ses')
                        );

                        $this->admin_model->insert_data_in_tbl("key_cross_cell_bonus", $db_arr);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New Key Cross Cell created successfully.</b></div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
                    }
                }
            }
        }
        redirect(site_url("key-cross-cell-bonus"));
    }



    $data['title'] = "Key Cross Cell Bonus";
    $data['body'] = "admin/key_cross_cell_bonus";
    $this->load->view('common/structure', $data);
}

public function tier($id = 0) {
    $data['msg'] = "";
//        if (!helper_have_rights(CV_CITY_ID, CV_VIEW_RIGHT_NAME)) {
//            redirect(site_url("no-rights"));
//        }
    if ($this->input->post()) {
        $this->form_validation->set_rules('txt_name', 'Slot', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('txt_per', '%age', 'trim|required|max_length[7]');
        $this->form_validation->set_rules('ddl_status', 'Status', 'trim|required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('txt_name');
            $per_val = $this->input->post('txt_per');
            $status = $this->input->post('ddl_status');

            if ($id) {
                $db_arr = array(
                    "name" => $name,
                    "per_val" => $per_val,
                    "status" => $status,
                    "updatedby" => $this->session->userdata('userid_ses'),
                    "updatedon" => date("Y-m-d H:i:s"),
                    "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'));
                $this->admin_model->update_tbl_data("tier_master", $db_arr, array("id" => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
                redirect(site_url("tier/".$id));
            } else {
                $db_arr = array(
                    "name" => $name,
                    "per_val" => $per_val,
                    "status" => $status,
                    "createdby" => $this->session->userdata('userid_ses'),
                    "createdby_proxy" => $this->session->userdata('proxy_userid_ses')
                );
                $this->admin_model->insert_data_in_tbl("tier_master", $db_arr);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New tier created successfully.</b></div>');
            }
            redirect(site_url("tier"));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
            if ($id) {
                redirect(site_url("tier/".$id));
            }
            redirect(site_url("tier"));
        }
    }

    if ($id) {
        $data['detail'] = $this->admin_model->get_table_row("tier_master", "*", array("id" => $id));
    }

    $data['list'] = $this->admin_model->get_tier_list();

    $data['title'] = "Tier Master";
    $data['url_key'] = "tier";
    $data['body'] = "admin/tier";
    $this->load->view('common/structure', $data);
}

function target_for_adjustment() {

    $gradelist = $this->common_model->get_table("manage_grade", "id, name", "status = 1", "order_no asc");
    $data['market_salary'] = $this->rule_model->get_market_salary_header_list(array("business_attribute.status" => 1, "business_attribute.module_name" => $this->session->userdata('market_data_by_ses')));

    $data['gradelist'] = $gradelist;

    if ($this->input->post()) {
        $this->admin_model->delete_table("target_for_adjustment");
        for ($l = 0; $l < count($gradelist); $l++) {

            $db_arr = array(
                "grade_id" => $gradelist[$l]['id'],
                "calculation_type" => $this->input->post("ddl_calculation_type_" . $gradelist[$l]['id']),
                "tfp_org" => $this->input->post("ddl_tfp_org_" . $gradelist[$l]['id']),
                "tcc_org" => $this->input->post("ddl_tcc_org_" . $gradelist[$l]['id']),
                "tfp_business" => $this->input->post("ddl_tfp_business_" . $gradelist[$l]['id']),
                "tcc_business" => $this->input->post("ddl_tcc_business_" . $gradelist[$l]['id']),
                "createdby" => $this->session->userdata('userid_ses'),
                "createdby_proxy" => $this->session->userdata('proxy_userid_ses')
            );

            $this->admin_model->insert_data_in_tbl("target_for_adjustment", $db_arr);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New target for adjustment created successfully.</b></div>');
        }
        redirect(site_url("target-for-adjustment/" . $tenureid));
    }



    $data['title'] = "Target for Adjustement";
    $data['body'] = "admin/target_for_adjustment";
    $this->load->view('common/structure', $data);
}

function min_pay_capp($tenure_id) {

    $gradelist = $this->common_model->get_table("manage_grade", "id, name", "status = 1", "order_no DESC");
    $data['tenure'] = $this->admin_model->get_table_row("tenure_classification", "*", array("id" => $tenure_id));
    $tierlist = $this->common_model->get_table("tier_master", "id, name", "status = 1", "name asc");

    if ($this->input->post()) {


        $tenuredellist = $this->common_model->get_table("tbl_min_pay_capping_master", "id", "tenure_id=" . $tenure_id . "", "");


        if (!empty($tenuredellist)) {

            for ($i = 0; $i < count($tenuredellist); $i++) {

                $this->admin_model->delete_min_pay_capping("tbl_min_pay_capping_dtls", array("min_pay_capping_master_id" => $tenuredellist[$i]['id']));
            }
            $this->admin_model->delete_min_pay_capping("tbl_min_pay_capping_master", array("tenure_id" => $tenure_id));
        }

        for ($l = 0; $l < count($gradelist); $l++) {

            $db_arr = array(
                "tenure_id" => $tenure_id,
                "grade_id" => $gradelist[$l]['id'],
                "createdby" => $this->session->userdata('userid_ses'),
                "createdby_proxy" => $this->session->userdata('proxy_userid_ses')
            );

            $lastid = $this->admin_model->insert_min_pay_capping_master($db_arr);
            if ($lastid) {

                for ($j = 0; $j < count($tierlist); $j++) {
                    $tier_arr = array(
                        "min_pay_capping_master_id" => $lastid,
                        "tier_id" => $tierlist[$j]['id'],
                        "tier_val" => $this->input->post("txt_tier_val_" . $tierlist[$j]['id'] . "_" . $gradelist[$l]['id'])
                    );
                    $this->admin_model->insert_data_in_tbl("tbl_min_pay_capping_dtls", $tier_arr);
                }
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . $this->lang->line('msg_min_pay_band_salary_insert') . '</b></div>');
        }
        redirect(site_url("min-pay-capp/" . $tenure_id));
    }


    $data['gradelist'] = $gradelist;
    $data['tierlist'] = $tierlist;

    $data['title'] = "Band Wise Minimum Pay ";
    $data['body'] = "admin/min_pay_capp";
    $this->load->view('common/structure', $data);
}

public function upload_min_pay_capp_data($tenure_id) {
    $gradelist = $this->common_model->get_table("manage_grade", "id, name", "status = 1", "order_no DESC");
    $tierlist = $this->common_model->get_table("tier_master", "id, name", "status = 1", "name asc");
    if ($this->input->post()) {
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name'] != "") {
            $file_type = explode('.', $_FILES['myfile']['name']);
            if ($file_type[1] == 'csv')
			{
				$scan_file_result = HL_scan_uploaded_file($_FILES['myfile']['name'],$_FILES['myfile']['tmp_name']);
				if($scan_file_result === true)
				{
					$filename = $_FILES["myfile"]["tmp_name"];
					$file = fopen($filename, "r");
					$row = 1;
					$tenuredellist = $this->common_model->get_table("tbl_min_pay_capping_master", "id", "tenure_id=" . $tenure_id . "", "");
					if (!empty($tenuredellist)) {
	
						for ($i = 0; $i < count($tenuredellist); $i++) {
	
							$this->admin_model->delete_min_pay_capping("tbl_min_pay_capping_dtls", array("min_pay_capping_master_id" => $tenuredellist[$i]['id']));
						}
						$this->admin_model->delete_min_pay_capping("tbl_min_pay_capping_master", array("tenure_id" => $tenure_id));
					}
	
					while (($data = fgetcsv($file, "", ",")) !== FALSE) {
						if ($row == 1) {
							$row++;
							continue;
						}
	
						$gradedetail = $this->admin_model->get_table_row("manage_grade", "id", array("name" => trim($data[0])));
						if (empty($gradedetail["id"])) {
	
						} else {
							$db_arr = array(
								"tenure_id" => $tenure_id,
								"grade_id" => $gradedetail["id"],
								"createdby" => $this->session->userdata('userid_ses'),
								"createdby_proxy" => $this->session->userdata('proxy_userid_ses')
							);
	
							$lastid = $this->admin_model->insert_min_pay_capping_master($db_arr);
							if ($lastid) {
	
								for ($j = 0; $j < count($tierlist); $j++) {
	
	
									$tier_arr = array(
										"min_pay_capping_master_id" => $lastid,
										"tier_id" => $tierlist[$j]['id'],
										"tier_val" => $data[$j + 1]
									);
									$this->admin_model->insert_data_in_tbl("tbl_min_pay_capping_dtls", $tier_arr);
								}
							}
						}
					}
	
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record Updated Successfully.</b></div>');
					redirect(site_url("min-pay-capp/" . $tenure_id));
				}
				else
				{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
					redirect(site_url("min-pay-capp/" . $tenure_id));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
                redirect(site_url("min-pay-capp/" . $tenure_id));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please Select CSV File.</b></div>');
            redirect(site_url("min-pay-capp/" . $tenure_id));
        }
    }
}

public function employee_graph_update($user_id) {
    $data['staff_list'] = $this->Empgraph_model->get_graph_emp_list();

    if ($user_id) {
        $data['employee_graph_details'] = $this->Empgraph_model->get_graph_emp_dtls($user_id);

    }

    if ($this->input->post()) {
        $left = array(
            'top_left' => $this->input->post('left'),
            'center_left' => $this->input->post('left_center'),
            'bottom_left' => $this->input->post('left_bottom'),
        );

        $right = array(
            'top_right' => $this->input->post('right'),
            'center_right' => $this->input->post('right_center'),
            'bottom_right' => $this->input->post('right_bottom'),
        );



        $db_arr = [
            "user_id" => $user_id,
            "updatedby" => $this->session->userdata('userid_ses'),
            "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
            "updatedon" => date("Y-m-d H:i:s"),
            "left_half" => json_encode($left, TRUE),
            "right_half" => json_encode($right, TRUE),
            "status" => 1,
        ];
                    //$Esg_id = $this->Empgraph_model->savedata('emp_salary_graph_txt_dtls',$db_arr);
        $this->Empgraph_model->savedata('emp_salary_graph_txt_dtls', $db_arr);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b><b>Data saved successfully.</b></div>');
        redirect(base_url('admin/admin_dashboard/employee_graph_update/'.$user_id));
    }

    $data['user_id'] = $user_id;
    $data['title'] = "Employee Graph Update";
    $data['body'] = "admin/employee_graph_update";
    $this->load->view('common/structure', $data);
}
//piy@16Dec19 Add level and Education
public function download_min_pay_capp_sample_file() {
    $gradelist = $this->common_model->get_table("manage_grade", "id, name", "status = 1", "order_no DESC");
    $tierlist = $this->common_model->get_table("tier_master", "id, name", "status = 1", "name asc");
    $tierarr = array("Band");
    foreach ($tierlist as $tier) {
        array_push($tierarr, $tier['name']);
    }
    $csv_file = "default_file_format.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csv_file . '"');

    $fp = fopen('php://output', 'wb');
    fputcsv($fp, $tierarr);

    foreach ($gradelist as $row) {
        fputcsv($fp, array($row['name'], ""));
    }
    fclose($fp);
}
//piy@16Dec19 Add level and Education
public function upload_market_data()
{


	$ba_mkt_for = CV_MARKET_SALARY_ELEMENT;
	if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
	{
		$ba_mkt_for = CV_MARKET_SALARY_CTC_ELEMENT;
	}
	$upd_mkt_data_ba_names_arr = array(CV_BA_NAME_COUNTRY, CV_BA_NAME_CITY, CV_BA_NAME_BUSINESS_LEVEL_1, CV_BA_NAME_BUSINESS_LEVEL_2, CV_BA_NAME_BUSINESS_LEVEL_3, CV_BA_NAME_FUNCTION, CV_BA_NAME_SUBFUNCTION, CV_BA_NAME_SUB_SUBFUNCTION, CV_BA_NAME_GRADE, CV_BA_NAME_LEVEL, CV_BA_NAME_DESIGNATION, CV_BA_NAME_EDUCATION,CV_BA_NAME_JOB_CODE, CV_BA_NAME_JOB_NAME, CV_BA_NAME_JOB_LEVEL, CV_BA_NAME_URBAN_RURAL_CLASSIFICATION,CV_BA_NAME_LEVEL,CV_BA_NAME_EDUCATION);


	$ba_list = $this->admin_model->get_ba_list_to_upload_mkt_data("id, ba_name,module_name,display_name", "business_attribute.status = " . CV_STATUS_ACTIVE . " AND (business_attribute.module_name = '" . $ba_mkt_for . "' OR business_attribute.module_name = '" . CV_COUNTRY . "' OR business_attribute.module_name = '" . CV_CITY . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_1 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_2 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_3 . "' OR business_attribute.module_name = '" . CV_FUNCTION . "' OR business_attribute.module_name = '" . CV_SUB_FUNCTION . "'  OR business_attribute.module_name = '" . CV_SUB_SUB_FUNCTION . "'  OR business_attribute.module_name = '" . CV_GRADE ."' OR business_attribute.module_name = '" . CV_LEVEL .  "' OR business_attribute.module_name = '" . CV_DESIGNATION . "' OR business_attribute.module_name = '" . CV_EDUCATION . "' OR business_attribute.ba_name in('" . CV_BA_NAME_JOB_CODE . "','" . CV_BA_NAME_JOB_NAME . "','" . CV_BA_NAME_JOB_LEVEL . "','" . CV_BA_NAME_URBAN_RURAL_CLASSIFICATION . "'))");

	$header_name_list = $ba_name_list = $ba_names_to_upd = $ba_names_to_upd_mkt_data_list = array();
	foreach($ba_list as $row)
	{
		$header_name_list[] = $row["display_name"];
		$ba_name_list[] = $row["ba_name"];
		if(in_array($row["ba_name"], $upd_mkt_data_ba_names_arr))
		{
			$ba_names_to_upd_mkt_data_list[] = $row;
		}
		if(!in_array($row["ba_name"], $upd_mkt_data_ba_names_arr))
		{
			$ba_names_to_upd[] = $row["ba_name"];
		}
	}

	if (($this->input->post("ddl_ba_names_to_upd_mkt_data")) and ($_FILES))
	{
		$choosed_ba_names_to_upd_mkt_data_arr = $this->input->post("ddl_ba_names_to_upd_mkt_data");
		$file_type = explode('.', $_FILES['myfile']['name']);
		if ($file_type[1] == 'csv')
		{
			$scan_file_result = HL_scan_uploaded_file($_FILES['myfile']['name'], $_FILES['myfile']['tmp_name']);
			if($scan_file_result === true)
			{
				$uploaded_file_name = $_FILES['myfile']['name'];
				$fName = time() . "." . $file_type[1];
				move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/" . $fName);
				
				$csv_file = base_url() . "uploads/" . $fName;
				if (($handle = fopen($csv_file, "r")) !== FALSE)
				{
					$tot_ins_hc = $this->admin_model->insert_all_market_data_in_tbl(implode(",", $ba_name_list), $csv_file, $ba_names_to_upd, $choosed_ba_names_to_upd_mkt_data_arr);
					//echo "<pre>";print_r($tot_ins_hc);die;
					if ($tot_ins_hc > 0)
					{
						$i = 1;
						while (($data = fgetcsv($handle)) !== FALSE)
						{
							$num = count($data);
							$impload_data = implode(",", $data);
							$this->admin_model->update_ba_display_name_on_market_data_upload($ba_name_list, $impload_data);
							if ($i < 2)
							{
								break;
							}
							$i++;
						}
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data Upload Successfully</b></div>');
					}
					else
					{
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data not uploaded. Please try agian with correct data</b></div>');
					}
					redirect(site_url("market-data-upload/"));
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>File not readable. Please try again.</b></div>');
				}
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
			}			
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
			redirect(site_url("market-data-upload/"));
		}
	}
	$data["header_name_list"] = $header_name_list;
	$data["ba_name_list"] = $ba_name_list;
	$data["ba_names_to_upd_mkt_data_list"] = $ba_names_to_upd_mkt_data_list;
	//echo "<pre>";print_r($ba_names_to_upd);die;
	$data["mkt_data_list"] = $this->admin_model->get_market_data_Details();
	$data['title'] = "Upload Market Data";
	$data['body'] = "admin/upload_market_data";
	$this->load->view('common/structure', $data);
}
//piy@16Dec19 Add level and Education
public function download_market_data_sample_format_file()
{
	$ba_mkt_for = CV_MARKET_SALARY_ELEMENT;
	if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
	{
		$ba_mkt_for = CV_MARKET_SALARY_CTC_ELEMENT;
	}

	$ba_list = $this->admin_model->get_ba_list_to_upload_mkt_data("id, ba_name, module_name, display_name", "business_attribute.status = " . CV_STATUS_ACTIVE . " AND (business_attribute.module_name = '" . $ba_mkt_for . "' OR business_attribute.module_name = '" . CV_COUNTRY . "' OR business_attribute.module_name = '" . CV_CITY . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_1 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_2 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_3 . "' OR business_attribute.module_name = '" . CV_FUNCTION . "' OR business_attribute.module_name = '" . CV_SUB_FUNCTION . "'  OR business_attribute.module_name = '" . CV_SUB_SUB_FUNCTION . "' OR business_attribute.module_name = '" . CV_GRADE . "' OR business_attribute.module_name = '" . CV_LEVEL .  "' OR business_attribute.module_name = '" . CV_DESIGNATION . "' OR business_attribute.module_name = '" . CV_EDUCATION ."' OR business_attribute.ba_name in('" . CV_BA_NAME_JOB_CODE . "','" . CV_BA_NAME_JOB_NAME . "','" . CV_BA_NAME_JOB_LEVEL . "','" . CV_BA_NAME_URBAN_RURAL_CLASSIFICATION . "'))");




	$csv_file = "market-data-file-format.csv";
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="' . $csv_file . '"');

	$fp = fopen('php://output', 'wb');
	$header_name_arr = array();
	foreach($ba_list as $row)
	{
		$header_name_arr[] = $row["display_name"];
	}
	fputcsv($fp, $header_name_arr);
	fclose($fp);
}
//piy@16Dec19 Add level and Education
public function market_data_export()
{
	$ba_mkt_for = CV_MARKET_SALARY_ELEMENT;
	if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
	{
		$ba_mkt_for = CV_MARKET_SALARY_CTC_ELEMENT;
	}

	$ba_list = $this->admin_model->get_ba_list_to_upload_mkt_data("id, ba_name,module_name,display_name", "business_attribute.status = " . CV_STATUS_ACTIVE . " AND (business_attribute.module_name = '" . $ba_mkt_for . "' OR business_attribute.module_name = '" . CV_COUNTRY . "' OR business_attribute.module_name = '" . CV_CITY . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_1 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_2 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_3 . "' OR business_attribute.module_name = '" . CV_FUNCTION . "' OR business_attribute.module_name = '" . CV_SUB_FUNCTION . "'  OR business_attribute.module_name = '" . CV_SUB_SUB_FUNCTION . "' OR business_attribute.module_name = '" . CV_GRADE ."' OR business_attribute.module_name = '" . CV_LEVEL .  "' OR business_attribute.module_name = '" . CV_DESIGNATION . "' OR business_attribute.module_name = '" . CV_EDUCATION . "' OR business_attribute.ba_name in('" . CV_BA_NAME_JOB_CODE . "','" . CV_BA_NAME_JOB_NAME . "','" . CV_BA_NAME_JOB_LEVEL . "','" . CV_BA_NAME_URBAN_RURAL_CLASSIFICATION . "'))");

    $headerarr = array("S.No.");
    $ba_name_list = array();
    foreach($ba_list as $row)
    {
       $headerarr[] = $row["display_name"];
       $ba_name_list[] = $row["ba_name"];
	}

    $mkt_data_list = $this->admin_model->get_market_data_Details();

    $csv_file = "market-data-list.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csv_file . '"');
    $fp = fopen('php://output', 'wb');

    fputcsv($fp, $headerarr);
    $i = 0;

    foreach ($mkt_data_list as $row) {
        $k = 0;
        $mkt_data_arr = array($i + 1);

        foreach ($ba_name_list as $ba_name) {
            if ($k > 8) {
                array_push($mkt_data_arr, $row[$ba_name]);
            } else {
                array_push($mkt_data_arr, $row[$ba_name]);
            }

            $k++;
        }
        fputcsv($fp, $mkt_data_arr);
        $i++;
    }
    fclose($fp);
}
public function upload_market_data_NIU()
    {
        $ba_mkt_for = CV_MARKET_SALARY_ELEMENT;
        if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT)
        {
            $ba_mkt_for = CV_MARKET_SALARY_CTC_ELEMENT;
        }
        $upd_mkt_data_ba_names_arr = array(CV_BA_NAME_COUNTRY, CV_BA_NAME_CITY, CV_BA_NAME_BUSINESS_LEVEL_1, CV_BA_NAME_BUSINESS_LEVEL_2, CV_BA_NAME_BUSINESS_LEVEL_3, CV_BA_NAME_FUNCTION, CV_BA_NAME_SUBFUNCTION, CV_BA_NAME_SUB_SUBFUNCTION, CV_BA_NAME_GRADE, CV_BA_NAME_DESIGNATION, CV_BA_NAME_JOB_CODE, CV_BA_NAME_JOB_NAME, CV_BA_NAME_JOB_LEVEL, CV_BA_NAME_URBAN_RURAL_CLASSIFICATION);
        $ba_list = $this->admin_model->get_ba_list_to_upload_mkt_data("id, ba_name,module_name,display_name", "business_attribute.status = " . CV_STATUS_ACTIVE . " AND (business_attribute.module_name = '" . $ba_mkt_for . "' OR business_attribute.module_name = '" . CV_COUNTRY . "' OR business_attribute.module_name = '" . CV_CITY . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_1 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_2 . "' OR business_attribute.module_name = '" . CV_BUSINESS_LEVEL_3 . "' OR business_attribute.module_name = '" . CV_FUNCTION . "' OR business_attribute.module_name = '" . CV_SUB_FUNCTION . "'  OR business_attribute.module_name = '" . CV_SUB_SUB_FUNCTION . "'  OR business_attribute.module_name = '" . CV_GRADE . "' OR business_attribute.module_name = '" . CV_DESIGNATION . "' OR business_attribute.ba_name in('" . CV_BA_NAME_JOB_CODE . "','" . CV_BA_NAME_JOB_NAME . "','" . CV_BA_NAME_JOB_LEVEL . "','" . CV_BA_NAME_URBAN_RURAL_CLASSIFICATION . "'))");

        $header_name_list = $ba_name_list = $ba_names_to_upd = $ba_names_to_upd_mkt_data_list = array();
        foreach($ba_list as $row)
        {
            $header_name_list[] = $row["display_name"];
            $ba_name_list[] = $row["ba_name"];
            if(in_array($row["ba_name"], $upd_mkt_data_ba_names_arr))
            {
                $ba_names_to_upd_mkt_data_list[] = $row;
            }
            if(!in_array($row["ba_name"], $upd_mkt_data_ba_names_arr))
            {
                $ba_names_to_upd[] = $row["ba_name"];
            }
        }

        if (($this->input->post("ddl_ba_names_to_upd_mkt_data")) and ($_FILES))
        {
            $choosed_ba_names_to_upd_mkt_data_arr = $this->input->post("ddl_ba_names_to_upd_mkt_data");

            $file_type = explode('.', $_FILES['myfile']['name']);
            if ($file_type[1] == 'csv')
            {
                $uploaded_file_name = $_FILES['myfile']['name'];
                $fName = time() . "." . $file_type[1];
                move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/" . $fName);
                $csv_file = base_url() . "uploads/" . $fName;
                if (($handle = fopen($csv_file, "r")) !== FALSE)
                {
                    $tot_ins_hc = $this->admin_model->insert_all_market_data_in_tbl(implode(",", $ba_name_list), $csv_file, $ba_names_to_upd, $choosed_ba_names_to_upd_mkt_data_arr);
                    //echo "<pre>";print_r($tot_ins_hc);die;
                    if ($tot_ins_hc > 0)
                    {
                        $i = 1;
                        while (($data = fgetcsv($handle)) !== FALSE)
                        {
                            $num = count($data);
                            $impload_data = implode(",", $data);
                            $this->admin_model->update_ba_display_name_on_market_data_upload($ba_name_list, $impload_data);
                            if ($i < 2)
                            {
                                break;
                            }
                            $i++;
                        }
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data Upload Successfully</b></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data not uploaded. Please try agian with correct data</b></div>');
                    }
                    redirect(site_url("market-data-upload/"));
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>File not readable. Please try again.</b></div>');
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
                redirect(site_url("market-data-upload/"));
            }
        }
        $data["header_name_list"] = $header_name_list;
        $data["ba_name_list"] = $ba_name_list;
        $data["ba_names_to_upd_mkt_data_list"] = $ba_names_to_upd_mkt_data_list;
        //echo "<pre>";print_r($ba_names_to_upd);die;
        $data["mkt_data_list"] = $this->admin_model->get_market_data_Details();
        $data['title'] = "Upload Market Data";
        $data['body'] = "admin/upload_market_data";
        $this->load->view('common/structure', $data);
    }
/// final salary structure @rajesh
// added and modify by rahul
function final_salary_structure($filter_id = '') {
    //echo $filter_id;
    if($filter_id =='')
    {
        redirect(site_url("flexi-plan"));
    }

    $data['flaxi_plan'] = $this->admin_model->get_table_row("flexi_plan_filter", "id,flexi_type,grades,levels", array('id'=>$filter_id));

    $grades = $data['flaxi_plan']['grades'];
    $data['gradelist'] = $this->common_model->get_table("manage_grade", "id, name",  "status = 1 and id in (".$grades.")", "order_no asc");

    $level = $data['flaxi_plan']['levels'];
    $data['levellist'] = $this->common_model->get_table("manage_level", "id, name",  "status = 1 and id in (".$level.")", "order_no asc");
    if($data['flaxi_plan']['flexi_type']=='grade')
    {
        $list=$data['gradelist'];
    }else
    {
        $list= $data['levellist'];
    }

    $data["salary_applied_on_elem_list"] = $this->rule_model->get_salary_applied_on_elememts_list_new("business_attribute.status = 1 AND (business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "')");


    $data['current_base_salaryarr'] = $this->common_model->get_table("business_attribute", "id", "status = 1 and ba_name_cw = 'Base/Basic'");

    $data['current_esic_salaryarr'] = $this->common_model->get_table("business_attribute", "id", "status = 1 and ba_name_cw = 'ESIC'");

    $data['reminderarr'] = $this->admin_model->get_table_row("final_salary_structure", "allowance_id", "type_of_element = 5");
       if ($this->input->post()) {

         if($this->input->post('save_as_draft')){
        $status = '1';
    }else{
        $status = '2';
    }
$this->admin_model->delete_min_pay_capping("final_salary_structure", array('flaxi_plan_id'=>$filter_id));

        for ($i = 0; $i < count($data["salary_applied_on_elem_list"]); $i++) {
         $type_of_element = $this->input->post("ddl_type_of_element_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']);
         $fixed_salary_element = $this->input->post("ddl_fixed_salary_element_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']);
         $sal_condition = $this->input->post("ddl_condition_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']);
         $applicability = $this->input->post("txt_applicability_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']);


         $part_of_flexi_pay = $this->input->post("txt_part_of_flexi_pay_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']);

$final_arr =array(
            "flaxi_plan_id" => $filter_id,
            "allowance_id" => $data["salary_applied_on_elem_list"][$i]['business_attribute_id'],
            // "grade_id" => $list[$j]['id'],
            "type" => $_POST['flexi_type'],
            "type_of_element" => $type_of_element,
            "fixed_salary_element"=>$fixed_salary_element,
            "salary_condition"=>$sal_condition,
            "applicability"=>$applicability,
            'part_of_flexi_pay'=>$part_of_flexi_pay,
            'status'=>$status,
            "createdby" => $this->session->userdata('userid_ses'),
            "createdby_proxy" => $this->session->userdata('proxy_userid_ses')
        );

if($this->input->post("txt_part_of_flexi_pay_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']))
         {
            $final_arr['amount']='';
            $final_arr['min_range']= implode(',',$this->input->post("txt_min_val_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']));

                $final_arr['max_range']= implode(',',$this->input->post("txt_max_val_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']));


         }
         else
         {
             $final_arr['min_range']='';
             $final_arr['max_range']='';
             $final_arr['amount']=implode(',',$this->input->post("txt_grade_val_" . $data["salary_applied_on_elem_list"][$i]['business_attribute_id']));

         }

          $this->admin_model->insert_data_in_tbl("final_salary_structure", $final_arr);

    }

    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Final Salary Structure Save Successfully.</b></div>');

      redirect(site_url("flexi-plan/"));

    }
    $data['title'] = "Final Salary Structure";
    $data['body'] = "admin/final_salary_structure";
    $this->load->view('common/structure', $data);
}

public function flexi_plan_delete($id)
{
$this->admin_model->delete_min_pay_capping("final_salary_structure", array('flaxi_plan_id'=>$id));
$this->admin_model->delete_min_pay_capping("flexi_plan_filter", array('id'=>$id));
 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Final Salary Structure Deleted Successfully.</b></div>');

      redirect(site_url("flexi-plan/"));
}

public function flexi_plan_launched()
{
   $flexiid=$_POST['flexiid'];
   $date=date('Y-m-d', strtotime(str_replace('/','-', $_POST['launched_date'])));
   $launched_date=$date;
   $days=$_POST['noofdays'];
   $noofdays= date('Y-m-d', strtotime($date. ' + '.$days.' days'));
   $setData['launched_at']=$launched_date;
   $setData['employees_to_complete']=$noofdays;
   $this->admin_model->update_flexi_filter(array('id'=>$flexiid),$setData);
   $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Launched Date Save Successfully.</b></div>');

}

public function get_flexi_plan_launched()
{
 $flexi_filter=$this->admin_model->get_flexi_filter($_GET['flexiid']);
 if($flexi_filter['launched_at']!='')
 {
      $date1_ts = strtotime($flexi_filter['launched_at']);
      $date2_ts = strtotime($flexi_filter['employees_to_complete']);
      $diff = $date2_ts - $date1_ts;
      $days= round($diff / 86400);
      echo $days.'_'.$flexi_filter['launched_at'];
 }

}

public function flexi_plan_copy($id)
{
$flexi_filter=$this->admin_model->get_flexi_filter($id);
$flexi_id=$this->admin_model->insert_flexi_filter($flexi_filter);
$final_salary_structure=$this->admin_model->get_final_salary_structure($id);
foreach ($final_salary_structure as $key) {
 $key->flaxi_plan_id=$flexi_id;
 $this->admin_model->insert_data_in_tbl("final_salary_structure", $key);
}
 redirect(site_url("flexi-plan-filters/".$flexi_id));
}


public function flexi_plan($id=0, $isdelete=0)
    {
        $data["salary_cycles_list"] = $this->admin_model->get_table("flexi_plan_filter","*");
        $data['title'] = "Flexi Plan";
        $data['body'] = "admin/flexi_plan";
        $this->load->view('common/structure',$data);
    }
// end
//*************************code added by nibha**********************
public function enter_prc($id = 0)
	{
           
        $data['msg'] = "";
        if (!helper_have_rights(CV_LEVEL_LIST, CV_VIEW_RIGHT_NAME)) {//need to discuss with ravi
            redirect(site_url("no-rights"));
        }
        if ($this->input->post()) {    
            $this->form_validation->set_rules('cost', 'Cost', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('revenue', 'Revenue', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('profit', 'Profit', 'trim|required');
            $this->form_validation->set_rules('bu', 'Buisness Unit', 'trim|required');                       
            if ($this->form_validation->run()) {              
                $db_arr = array(
                    "cost" =>  $this->input->post('cost'),
                    "revenue" => $this->input->post('revenue'),
                    "profit" =>  $this->input->post('profit'),
                    "city_id" => $this->input->post('city'),
                    "business_unit_id" => $this->input->post('bu'),
                    "year_id" => $this->input->post('financial_year'),
                    "country_id" =>  $this->input->post('country'),

                );    
                if ($id) {
                    $this->admin_model->update_tbl_data("revenue_per_business_units_in_year", $db_arr, array("id" => $id));
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Record updated successfully.</b></div>');
                } else {
                    $this->admin_model->insert_data_in_tbl("revenue_per_business_units_in_year",$db_arr);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>New designation created successfully.</b></div>');
                }
                redirect(site_url("enter-prc"));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
                redirect(site_url("enter-prc"));
            }
        }
    
        if ($id) {
            $data['detail'] = $this->admin_model->get_table_row("revenue_per_business_units_in_year", "*", array("id" => $id));
        }
    
        $data['list'] = $this->admin_model->get_revenue_per_business();      
        $data['url_key'] = "enter-prc";
		$data['title'] = "Upload Company Financials";
		$data['body']='admin/enter_prc';
		$this->load->view('common/structure',$data);
	}
//***************

public function flexi_plan_filters($flexi_id='')
{
    $user_id = $this->session->userdata('userid_ses');
    if($flexi_id !=''){
        $data["rule_dtls"] = $this->admin_model->get_table_row("flexi_plan_filter","*",array('id'=>$flexi_id));
           }
            if($data["rule_dtls"])
            {
                $is_need_update = 1;
                $data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
                $data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
                $data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
                $data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
                $data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
                $data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
                $data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
                $data["rule_dtls"]["sub_subfunctions"] = explode(",",$data["rule_dtls"]["sub_subfunctions"]);
                $data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
                $data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);

                $data["rule_dtls"]["levels"] = explode(",",$data["rule_dtls"]["levels"]);

                $data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);

              $flexi_id = $data["rule_dtls"]["id"];
            }

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


        if($this->input->post())
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
               // print_r($manager_arr);
               // die();
                $db_arr = array(

                    "country" => $country_arr,
                    "city" => $city_arr,
                    "business_level1" =>$bussiness_level_1_arr,
                    "business_level2" =>$bussiness_level_2_arr,
                    "business_level3" =>$bussiness_level_3_arr,
                    "functions" => $function_arr,
                    "sub_functions" =>$sub_function_arr,
                    "designations" =>$designation_arr,
                    "grades" =>$grade_arr,
                    "levels" =>$level_arr,
                    "flexi_type" =>$_POST['ddl_type'],
                    "flexi_plan_name" =>$_POST['ddl_name'],
                    "managers" =>$manager_arr,
                    "special_category" =>$special_category_arr,
                    "updatedby" => $this->session->userdata('userid_ses'),
                    "updatedby_proxy" => $this->session->userdata('proxy_userid_ses'),
                    "updatedon" => date("Y-m-d H:i:s")
                );
                $db_arr['sub_subfunctions'] = "";
                $db_arr['sub_subfunctions'] = $sub_subfunction_arr;
// print_r($db_arr);
// die();
                if($this->input->post("btn_confirm_selection"))
                {
                    if($flexi_id > 0)
                    {
                        $data["rule_dtls"] = array_merge($data["rule_dtls"],$db_arr);
                    }
                    else
                    {
                        $data["rule_dtls"] = $db_arr;
                    }
                    $data["rule_dtls"]["country"] = explode(",",$data["rule_dtls"]["country"]);
                    $data["rule_dtls"]["city"] = explode(",",$data["rule_dtls"]["city"]);
                    $data["rule_dtls"]["business_level1"] = explode(",",$data["rule_dtls"]["business_level1"]);
                    $data["rule_dtls"]["business_level2"] = explode(",",$data["rule_dtls"]["business_level2"]);
                    $data["rule_dtls"]["business_level3"] = explode(",",$data["rule_dtls"]["business_level3"]);
                    $data["rule_dtls"]["functions"] = explode(",",$data["rule_dtls"]["functions"]);
                    $data["rule_dtls"]["sub_functions"] = explode(",",$data["rule_dtls"]["sub_functions"]);
                    $data["rule_dtls"]["sub_subfunctions"] = explode(",",$data["rule_dtls"]["sub_subfunctions"]);
                    $data["rule_dtls"]["designations"] = explode(",",$data["rule_dtls"]["designations"]);
                    $data["rule_dtls"]["grades"] = explode(",",$data["rule_dtls"]["grades"]);
                    $data["rule_dtls"]["levels"] = explode(",",$data["rule_dtls"]["levels"]);
                    $data["rule_dtls"]["educations"] = explode(",",$data["rule_dtls"]["educations"]);
                    $data["rule_dtls"]["critical_talents"] = explode(",",$data["rule_dtls"]["critical_talents"]);
                    $data["rule_dtls"]["critical_positions"] = explode(",",$data["rule_dtls"]["critical_positions"]);
                    $data["rule_dtls"]["special_category"] = explode(",",$data["rule_dtls"]["special_category"]);
                    $data["rule_dtls"]["tenure_company"] = explode(",",$data["rule_dtls"]["tenure_company"]);
                    $data["rule_dtls"]["tenure_roles"] = explode(",",$data["rule_dtls"]["tenure_roles"]);
                    //echo "<pre>";print_r($data["rule_dtls"]);die;

                    if($flexi_id > 0)
                    {

                        $this->admin_model->update_flexi_filter(array("id"=>$flexi_id), $db_arr);
                    }
                    else
                    {
                        $db_arr["createdby"] = $this->session->userdata('userid_ses');
                        $db_arr["createdby_proxy"] = $this->session->userdata('proxy_userid_ses');
                        $db_arr["createdon"] = date("Y-m-d H:i:s");
                        $flexi_id = $this->admin_model->insert_flexi_filter($db_arr);
                    }

                    if($flexi_id)
                    {


                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Flexi filter save successfully.</b></div>');
                        redirect(site_url("final-salary-structure/".$flexi_id));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Filters not saved. Try again!</b></span></div>');

                            redirect(site_url("flexi-plan-filters"));


                    }

                }
                else
                {
                    redirect(site_url("final-salary-structure/".$flexi_id));
                    echo $flexi_id;
                    die;
                }
            }
        }

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

        $data['tooltip'] = getToolTip('salary-rule-filter');

        $data['title'] = "Set flexi Rule Filters";
        $data['body'] = "admin/flexi_rule_filters";
        $this->load->view('common/structure',$data);
}

function test_email()
{
$email_config = Array('charset' => 'utf-8', 'mailtype' => 'html');
$email_subject='Testing Email';
$email_config["protocol"] = "smtp";
$email_config["smtp_host"] = 'smtp.gmail.com';
$email_config["smtp_port"] =  465;
$email_config["smtp_user"] = 'rewards@oyorooms.com';
$email_config["smtp_pass"] = 'yurfnxknndihutnp';
$email_config["smtp_crypto"] = "ssl";
$this->load->library('email', $email_config);
$this->email->set_newline("\r\n");
$this->email->from('info@compport.com', "Compport");
$this->email->to(array('rahultitbhopal07@gmail.com','ravi.singroli@compport.com','rakesh.saoji@compport.com'));
$this->email->subject($email_subject);
$this->email->message('<h1>Sending email via SMTP server</h1><p>This email has sent via SMTP server from CodeIgniter application.</p>');
if ($this->email->send()) {
    echo 'send';
    }
    else
    {
         echo  $this->email->print_debugger();
        echo 'not send';
    }

}

// upload flexi report fille

public function upload_flexi_report_NIU()
{
$file_type = explode('.', $_FILES['uploadfile']['name']);
if (end($file_type) == 'csv')
{
$uploaded_file_name = $_FILES['uploadfile']['name'];
 $fName = time() . "-bulk-flexireport." . end($file_type);
 move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "uploads/" . $fName);
  $csv_file =base_url() ."uploads/" . $fName;
  // $delimiter=','; $enclosure='"'; $escape = '\\';
  // $header = null;
  // $data = array();
  // $lines = file($csv_file);
if($_POST['downloadtype']==2)
  {
    $rule_id=$_POST['ruleid'];
  }else{$rule_id=0;}

$newCsvData = array();
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    $i=0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($i==0)
        {
          $data[] = 'rule_id';
          $data[] = 'flexi_id';
          $data[] = 'status';
        }else
        {
           $data[] = $rule_id;
           $data[] = $_POST['flexi_id'];
           $data[] = '1';
        }

        $newCsvData[] = $data;
        $i++;
    }
    fclose($handle);
}
$handle = fopen('uploads/uploadflexidata.csv', 'w');
foreach ($newCsvData as $line) {
   fputcsv($handle, $line);
}
fclose($handle);

$remove_attname=array('education','critical_talent','critical_position','special_category','start_date_for_role','end_date_for_role','bonus_incentive_applicable','recently_promoted','performance_achievement','rating_for_current_year','rating_for_last_year','rating_for_2nd_last_year','rating_for_3rd_last_year','rating_for_4th_last_year','rating_for_5th_last_year','increment_applied_on');


 $salary_elememts = $this->db->query("SELECT * FROM `business_attribute` where ba_grouping='Personal' OR ba_grouping='Salary' OR ba_grouping='Business'  and status=1 ORDER BY `business_attribute`.`ba_attributes_order` ASC")->result_array();
 foreach ($salary_elememts as $value)
 {
    if(in_array($value['ba_name'],$remove_attname))
      {
        continue;
      }
    $att_list_array[]=$value['ba_name'];
 }

$fields=implode(',',$att_list_array).',rule_id,flexi_id,status';
$newfile_path='uploads/uploadflexidata.csv';
   $enclosed_by = '"';
$check_exist_data=$this->admin_model->get_table('tbl_bulk_upload_flexi_data', 'id',['rule_id'=>$rule_id,'flexi_id'=>$_POST['flexi_id']]);
if(!empty($check_exist_data))
{
$this->admin_model->delete_min_pay_capping('tbl_bulk_upload_flexi_data',['rule_id'=>$rule_id,'flexi_id'=>$_POST['flexi_id']]);
}
  $this->db->query("LOAD DATA LOCAL INFILE '" . $newfile_path . "' INTO TABLE tbl_bulk_upload_flexi_data FIELDS TERMINATED BY ',' ENCLOSED BY '" . $enclosed_by . "' LINES TERMINATED BY '\n' IGNORE 1 LINES (" . $fields . ")");
  //unlink($csv_file);
  //unlink($newfile_path);
  $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data Upload Successfully.</b></div>');
redirect(site_url("flexi-plan"));
}
else
{
$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b> File format incorrect.Please upload correct file (*.csv)..</b></div>');
     redirect(site_url("flexi-plan"));
}
}

public function upload_flexi_report()
{
$file_type = explode('.', $_FILES['uploadfile']['name']);
if (end($file_type) == 'csv')
{
	$scan_file_result = HL_scan_uploaded_file($_FILES['uploadfile']['name'],$_FILES['uploadfile']['tmp_name']);
	if($scan_file_result === true)
	{
		$uploaded_file_name = $_FILES['uploadfile']['name'];
		 $fName = time() . "-bulk-flexireport." . end($file_type);
		 move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "uploads/" . $fName);
		  $csv_file =base_url() ."uploads/" . $fName;
		  // $delimiter=','; $enclosure='"'; $escape = '\\';
		  // $header = null;
		  // $data = array();
		  // $lines = file($csv_file);
		if($_POST['downloadtype']==2)
		  {
			$rule_id=$_POST['ruleid'];
		  }else{$rule_id=0;}
		
		$newCsvData = array();
		if (($handle = fopen($csv_file, "r")) !== FALSE) {
			$i=0;
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if($i==0)
				{
				  $data[] = 'rule_id';
				  $data[] = 'flexi_id';
				  $data[] = 'status';
				}else
				{
				   $data[] = $rule_id;
				   $data[] = $_POST['flexi_id'];
				   $data[] = '1';
				}
		
				$newCsvData[] = $data;
				$i++;
			}
			fclose($handle);
		}
		$handle = fopen('uploads/uploadflexidata.csv', 'w');
		foreach ($newCsvData as $line) {
		   fputcsv($handle, $line);
		}
		fclose($handle);
		
		$remove_attname=array('education','critical_talent','critical_position','special_category','start_date_for_role','end_date_for_role','bonus_incentive_applicable','recently_promoted','performance_achievement','rating_for_current_year','rating_for_last_year','rating_for_2nd_last_year','rating_for_3rd_last_year','rating_for_4th_last_year','rating_for_5th_last_year','increment_applied_on');
		
		
		 $salary_elememts = $this->db->query("SELECT * FROM `business_attribute` WHERE business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."' OR id In(2,48,169)) ORDER BY `business_attribute`.`ba_attributes_order` ASC")->result_array();
		 foreach ($salary_elememts as $value)
		 {
			if(in_array($value['ba_name'],$remove_attname))
			  {
				continue;
			  }
			$att_list_array[]=$value['ba_name'];
		 }
		
		$fields=implode(',',$att_list_array).',revised_fixed_salary,rule_id,flexi_id,status';
		$newfile_path='uploads/uploadflexidata.csv';
		   $enclosed_by = '"';
		$check_exist_data=$this->admin_model->get_table('tbl_bulk_upload_flexi_data', 'id',['rule_id'=>$rule_id,'flexi_id'=>$_POST['flexi_id']]);
		if(!empty($check_exist_data))
		{
		$this->admin_model->delete_min_pay_capping('tbl_bulk_upload_flexi_data',['rule_id'=>$rule_id,'flexi_id'=>$_POST['flexi_id']]);
		}
		  $this->db->query("LOAD DATA LOCAL INFILE '" . $newfile_path . "' INTO TABLE tbl_bulk_upload_flexi_data FIELDS TERMINATED BY ',' ENCLOSED BY '" . $enclosed_by . "' LINES TERMINATED BY '\n' IGNORE 1 LINES (" . $fields . ")");
		  //unlink($csv_file);
		  unlink($newfile_path);
		  $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data Upload Successfully.</b></div>');
		redirect(site_url("flexi-plan"));
	}
	else
	{
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
		redirect(site_url("flexi-plan"));
	}
}
else
{
$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b> File format incorrect.Please upload correct file (*.csv)..</b></div>');
     redirect(site_url("flexi-plan"));
}
}


	public function configure_promotion_upgrade_data()
	{
		if ($_FILES)
		{
			$choosed_ba_names_to_upd_mkt_data_arr = $this->input->post("ddl_ba_names_to_upd_mkt_data");
			$file_type = explode('.', $_FILES['promotion_upgrade_file']['name']);
			if (strtolower(end($file_type)) == 'csv')
			{
				$scan_file_result = HL_scan_uploaded_file($_FILES['promotion_upgrade_file']['name'], $_FILES['promotion_upgrade_file']['tmp_name']);
				if($scan_file_result === true)
				{
					$uploaded_file_name = $_FILES['promotion_upgrade_file']['name'];
					$fName = time() . "." . $file_type[1];
					move_uploaded_file($_FILES["promotion_upgrade_file"]["tmp_name"], "uploads/" . $fName);
					
					$csv_file = base_url() . "uploads/" . $fName;
					$response = $this->admin_model->upload_promotion_upgrade_dtls_into_tmp_tbl($csv_file);
					if($response["error_cnts"] > 0)
					{
						$this->session->set_flashdata('error_file_message', "<div class='alert alert-danger alert-dismissible fade in' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button> <b>Some rows having incorrect data, to get error's file click on the download link below.</b></div><b><div style='margin-bottom:15px;' class='text-center'><a class='btn btn-primary' href=".site_url("download-promotion-upgrade-error-file")." target='_blank'>Download Error File</a></div></b>");
					}
					
					if($response["correct_cnts"] > 0)
					{
						$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Data uploaded successfully.</b></div>');
					}				
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>"'.$scan_file_result.'.</b></div>');
				}			
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please upload correct file (*.csv).</b></div>');
			}
			redirect(site_url("configure-promotion-upgrade-data"));
		}
		
		$data["tbl_data"] = $this->admin_model->get_table("tbl_promotion_up_gradation", "id, designation_frm, designation_to, grade_frm, grade_to, level_frm, level_to", "", "id ASC");
		
		$data["designations_list"] = $this->common_model->get_data_in_key_val_format("manage_designation", "id", "name", "");
		$data["grades_list"] = $this->common_model->get_data_in_key_val_format("manage_grade", "id", "name", "");
		$data["levels_list"] = $this->common_model->get_data_in_key_val_format("manage_level", "id", "name", "");
		
		$data['title'] = "Configure Promotion Upgrade Data";
		$data['body'] = "admin/configuration_to_upgrad_promotion";
		$this->load->view('common/structure', $data);
	}
	
	public function download_promotion_upgrade_data_format_file()
	{
		$tbl_data = $this->admin_model->get_table("tbl_promotion_up_gradation", "id, designation_frm, designation_to, grade_frm, grade_to, level_frm, level_to", "", "id ASC");
		
		$designations_list = $this->common_model->get_data_in_key_val_format("manage_designation","id","name","");
		$grades_list = $this->common_model->get_data_in_key_val_format("manage_grade", "id", "name", "");
		$levels_list = $this->common_model->get_data_in_key_val_format("manage_level", "id", "name", "");
		
		$csv_file = "promotion-upgrade-file-format.csv";
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $csv_file . '"');
		$fp = fopen('php://output', 'wb');
		$header_name_arr = array("From Designation", "From Grade", "From Level", "To Designation", "To Grade", "To Level");		
		fputcsv($fp, $header_name_arr);
		
		foreach($tbl_data as $row)
		{
			$item_arr = array($designations_list[$row["designation_frm"]], $grades_list[$row["grade_frm"]], $levels_list[$row["level_frm"]], $designations_list[$row["designation_to"]], $grades_list[$row["grade_to"]],$levels_list[$row["level_to"]]);
			fputcsv($fp, $item_arr);
		}
		
		fclose($fp);
	}
	
	public function download_promotion_upgrade_error_file()
	{		
		$error_data = $this->admin_model->get_table("temp_tbl_promotion_upgrade_dtls", "frm_designation, frm_grade, frm_level, to_designation, to_grade, to_level, error_msg", "is_error = 1", "id ASC");
		
		if(count($error_data) > 0)
		{
			$error_shet_header = array("From Designation", "From Grade", "From Level", "To Designation", "To Grade", "To Level", "Error Message");
			$error_arr = array_merge($error_shet_header, $error_data);
			downloadcsv($error_arr, "error-file.csv");
		}
		else
		{
			redirect(site_url("configure-promotion-upgrade-data"));
		}
	}


}
