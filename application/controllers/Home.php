<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->load->library('session', 'encrypt');
        $this->load->helper(array('form', 'url', 'date', 'cookie'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        delete_cookie("dn");
        $data['msg'] = "";
        $data['sso'] = false;
        $data['showloginbox'] = false;
        $this->load->model("domain_model");
        if ($this->input->post()) {
            HLP_is_cross_origin_req(); //To check request is coming from our server or not
            $this->form_validation->set_rules('email', 'EMAIL', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');

            if (HLP_need_to_enable_captcha()) {
                //$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha', array('required' => 'Please check the the captcha form.'));
                $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
            }

            if ($this->form_validation->run()) {
                $uname = $this->input->post('email');
                $pass = md5($this->input->post("password"));

                //$username_arr = explode('@', $uname);
               //$domain_name = end($username_arr);

                list($emp,$domain_name) = explode('@', $uname);
                if(empty($domain_name))
                {
                    $domain_name=  $_SERVER['HTTP_HOST'];
                }

                $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

                if ($domain_dtls) {
                    if ($domain_dtls['company_status']) {
                        $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
                        if ($_SERVER["HTTP_HOST"] == "localhost") {
                            set_cookie('dn', base64_encode($domain_dtls['dbname']), '270000'); //This cookie will expire within 270000 Sec
                        } else {
                            set_cookie('dn', base64_encode($domain_dtls['dbname']), '21600'); //This cookie will expire within 21600 Sec
                        }

                        $this->load->model("front_model");
                        $result = $this->front_model->is_valid_user($uname, $pass, $domain_dtls['company_Id']);

                        $company_dtls = $this->front_model->get_table_row("manage_company", "*", array("id" => $domain_dtls['company_Id'], "dbname" => $domain_dtls['dbname']));
                        if ($result) {
                            // Reset incorrect_attempts filed value
                            $this->front_model->reset_login_attempt($uname);
                            if ($company_dtls) {
                                $this->create_usr_session($result, $company_dtls, $domain_dtls);
                                /*$new_web_token = HLP_generate_web_token();
                                $this->front_model->change_password(array("id" => $result['id']), array("web_token" => $new_web_token));
                                $color = "00ADEF";
                                if ($company_dtls['company_color']) {
                                    $color = $company_dtls['company_color'];
                                }

                                if ($company_dtls['company_light_color']) {
                                    $company_light_color = $company_dtls['company_light_color'];
                                } else {
                                    $company_light_color = $company_dtls['company_color'];
                                }

                                $detail = array(
                                    'userid_ses' => $result['id'],
                                    'email_ses' => $result['email'],
                                    'username_ses' => $result['name'],
                                    'role_ses' => $result['role'],
                                    'is_manager_ses' => $result['is_manager'],
                                    'manage_hr_only_ses' => $result['manage_hr_only'],
                                    'companyid_ses' => $domain_dtls['company_Id'],
                                    'companyname_ses' => $domain_dtls['company_name'],
                                    'domainname_ses' => $domain_dtls['domainName'],
                                    'company_color_ses' => $color,
                                    'company_light_color_ses' => $company_light_color,
                                    'company_logo_ses' => $company_dtls['company_logo'],
                                    'company_bg_img_url_ses' => $company_dtls['company_bg_img'],
                                    'proxy_is_manager_ses' => $result['is_manager'],
                                    'proxy_manage_hr_only_ses' => $result['manage_hr_only'],
                                    'proxy_username_ses' => $result['name'],
                                    'proxy_userid_ses' => $result['id'],
                                    'proxy_role_ses' => $result['role'],
                                    'proxy_user_web_token_ses' => $new_web_token,
                                    'market_data_by_ses' => $company_dtls['market_data_by']
                                );
                                $this->session->set_userdata($detail);                                
                                $this->load->model("common_model");
                                $this->common_model->set_permissions_session_arr();
                                $this->loggeddetails($result['id']);
								
								//Start :: Nibha's Work ******************
								$this->generateJWT($result['email'],   $new_web_token ,  $result['role'], $domain_dtls['company_Id']);
								//End :: Nibha's Work ******************

                                if ($result['is_accept_term'] == 0) {
                                    redirect(site_url("term-conditions"));
                                } else {
                                    if ($this->session->userdata('role_ses') < 11) {
                                        redirect(site_url("dashboard"));
                                    }
									else {
                                        redirect(site_url("employee/dashboard"));
                                    }
                                }*/
                            } else {
                                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid company.</b></div>';
                            }
                        } else {


                            ############ Get SMTP DEtails FOR Sending Mail #############

                            $email_config = HLP_GetSMTP_Details();

                            #############################################################
                            // Block user login after 3 unsuccessful attempts
                            $this->front_model->check_login_attempt($uname);
                            $info = $this->front_model->check_login_attempt($uname, 'check');
                            if ($info) {
                                $this->loggeddetails($info->id, 2);
                            }
                            if ($info->incorrect_attempts > 2) {
                                if ($info->incorrect_attempts == 3) {
                                    // Send email
                                    $emailTemplate = $this->common_model->getEmailTemplate("unblockAccount");


                                    $link = base_url('unblock/' . $info->web_token . '/' . base64_encode($info->email));



                                    $str = str_replace("{{url}}", $link, $emailTemplate[0]->email_body);
                                    $mail_body = $str;

                                    $mail_sub = $emailTemplate[0]->email_subject;
                                    //echo $mail_body; die;
                                    $this->load->model("common_model");

                                    // $this->common_model->send_emails(CV_EMAIL_FROM, $uname, $mail_sub, $mail_body);

                                    $this->common_model->send_emails($email_config['email_from'], $uname, $mail_sub, $mail_body, $email_config['result'], $email_config['mail_fromname']);
                                }
                                if ($info->incorrect_attempts > 3) {
                                    $data['sendemail'] = '<a href="' . base_url('reset-token/' . base64_encode($info->email)) . '" class="btn btn-danger btn-block">Send Email for active your account.</a>';
                                }
                                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your account has been locked due to multiple wrong entry of your password. Please reset your password by clicking forgot password option below.</b></div>';
                            } else {
                                $total_attempt = 3 - intval($info->incorrect_attempts);
                                if ($total_attempt == 1) {
                                    $total_attempt = 'Your ' . $total_attempt . ' attempt are remaining.';
                                } else {
                                    $total_attempt = 'Your ' . $total_attempt . ' attempts are remaining.';
                                }
                                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again. ' . $total_attempt . '</b></div>';
                            }
                        }
                    } else {
                        $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Services to this account are temporarily disabled. Please contact the administrator.</b></div>';
                    }
                } else {
                    $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again.</b></div>';
                }
            } else {
                $data['msg'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>';
            }
        } else {


            if ($sso_config = $this->domain_model->get_sso_config()) {
                $this->session->set_userdata(['sso_config' => $sso_config]);
                $data['sso'] = true;
                if ($sso_config['showloginbox']) {
                    $data['showloginbox'] = true;
                }
                if ($sso_config['autologin']) {
                    $spUrl = base_url('ssologin/index.php?sso');
                    header('Pragma: no-cache');
                    header('Cache-Control: no-cache, must-revalidate');
                    header('Location: ' . $spUrl);
                    exit();
                    //todo autologin code
                }
            }
        }

        $data['title'] = "Home";
        $this->load->view('login', $data);
    }
    /**
     *  Piy@1Jan20
     *  SP Single Sign on Login Service
     */
    public function sso_log($operation = '', $message = '', $json_text = '', $type = '')
    {
        $this->load->database();
        if ($operation == 'csv') {
            $dt = new DateTime;
            $createdon = $dt->format('Y-m-d@H-i');
            $query = "SELECT * FROM " . CV_PLATFORM_DB_NAME . ".`sso_log` order by createdon desc, id desc limit 0,30";
            $data_for_file = $this->db->query($query)->result_array();
            downloadcsv($data_for_file, $createdon . ".csv");
            exit();
        } else if ($operation == 'del') {
            $query = "TRUNCATE TABLE " . CV_PLATFORM_DB_NAME . ".`sso_log`";
            $data_for_file = $this->db->query($query);
            echo $_SERVER['USER_PORTAL_BASE_URL'];
            echo "Deleted Log";
            exit();
        } else {
            $json_text = json_encode($json_text);
            $compnay_url = $_SERVER['HTTP_HOST'];
            $this->db->query("INSERT INTO " . CV_PLATFORM_DB_NAME . ".`sso_log`( `compnay_url`, `message`, `json_text`,  `type`, `operation`)  VALUES ('{$compnay_url}','{$message}','{$json_text}','{$type}','{$operation}')");
        }
    }
    /*
    * Piy@9Dec19 
    * logged in user to system on user email.
    */
    function sso_process_login($uname, $timestamp, $paramters = '')
    {
        delete_cookie("dn");
        $data['sso'] = false;
        $data['showloginbox'] = false;
        $this->load->model("domain_model");
        if ($sso_config = $this->domain_model->get_sso_config()) {
            $data['sso'] = true;
            if ($sso_config['showloginbox']) {
                $data['showloginbox'] = true;
            }
        }

        $uname     = base64_decode($uname);
        $timestamp = base64_decode($timestamp);
        $paramters = json_decode(base64_decode($paramters));
        list($emailid, $domain_name) = explode('@', $uname);
        if ($paramters->debug) $this->sso_log('sso_process_login', "saml attributes", $paramters, 'saml attributes'); //op msg json type

        if ($timestamp + 60 < time()) {
            $this->sso_log('sso_process_login', 'timestamp fail', $timestamp, 'timestamp fail'); //op msg json type
            redirect(site_url('home'));
        }

        if (!$domain_name) {
            $this->sso_log('sso_process_login', 'domain name', $domain_name, 'domain name not found'); //op msg json type
            $data['title'] = "Home";
            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again.</b></div>';
            $this->load->view('login', $data);
            return;
        }


        $this->load->model("domain_model");
        $domain_dtls = $this->domain_model->is_valid_domain($domain_name);
        // $this->sso_log('sso_process_login', 'domain fail', $domain_dtls , "domain: {$domain_name}"); //op msg json type

        if ($domain_dtls) {
            if ($domain_dtls['company_status']) {
                $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
                set_cookie('dn', base64_encode($domain_dtls['dbname']), '21600'); //This cookie will expire within 21600 Sec
                $this->load->model("front_model");
                //validate sso
                $result = $this->front_model->is_valid_sso_user($uname, $domain_dtls['company_Id']);

                $company_dtls = $this->front_model->get_table_row("manage_company", "*", array("id" => $domain_dtls['company_Id'], "dbname" => $domain_dtls['dbname']));
                if ($result) {
                    $this->session->set_userdata(array('ssologin_ses' => true));
                    $this->session->set_userdata(array('ssologin_ses_reverse_logout' => $paramters->reverseLogout));
                    // Reset incorrect_attempts filed value
                    $this->front_model->reset_login_attempt($uname);
                    if ($company_dtls) {
                        $this->create_usr_session($result, $company_dtls, $domain_dtls);
                    } else {
                        $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid company.</b></div>';
                    }
                } else {

                    ############ Get SMTP DEtails FOR Sending Mail #############
                    $email_config = HLP_GetSMTP_Details();
                    #############################################################
                    // Block user login after 3 unsuccessful attempts
                    $this->front_model->check_login_attempt($uname);
                    $info = $this->front_model->check_login_attempt($uname, 'check');
                    if ($info) {
                        $this->loggeddetails($info->id, 2);
                    }
                    if ($info->incorrect_attempts > 2) {
                        if ($info->incorrect_attempts == 3) {
                            // Send email
                            $emailTemplate = $this->common_model->getEmailTemplate("unblockAccount");
                            $link = base_url('unblock/' . $info->web_token . '/' . base64_encode($info->email));
                            $str       = str_replace("{{url}}", $link, $emailTemplate[0]->email_body);
                            $mail_body = $str;
                            $mail_sub = $emailTemplate[0]->email_subject;
                            //echo $mail_body; die;
                            $this->load->model("common_model");
                            // $this->common_model->send_emails(CV_EMAIL_FROM, $uname, $mail_sub, $mail_body);
                            $this->common_model->send_emails($email_config['email_from'], $uname, $mail_sub, $mail_body, $email_config['result'], $email_config['mail_fromname']);
                        }
                        if ($info->incorrect_attempts > 3) {
                            $data['sendemail'] = '<a href="' . base_url('reset-token/' . base64_encode($info->email)) . '" class="btn btn-danger btn-block">Send Email for active your account.</a>';
                        }
                        $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your account has been locked due to multiple wrong entry of your password. Please reset your password by clicking forgot password option below.</b></div>';
                    } else {
                        $total_attempt = 3 - intval($info->incorrect_attempts);
                        if ($total_attempt == 1) {
                            $total_attempt = 'Your ' . $total_attempt . ' attempt are remaining.';
                        } else {
                            $total_attempt = 'Your ' . $total_attempt . ' attempts are remaining.';
                        }
                        $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again. ' . $total_attempt . '</b></div>';
                    }
                }
            } else {
                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Services to this account are temporarily disabled. Please contact the administrator.</b></div>';
            }
        } else {
            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again.</b></div>';
        }

        $data['title'] = "Home";
        $this->load->view('login', $data);
    }

    public function send_resendemail($email)
    {

        $uname = base64_decode($email);
        $username_arr = explode('@', $uname);
        $domain_name = end($username_arr);

        $this->load->model("domain_model");
        $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

        if ($domain_dtls) {
            if ($domain_dtls['company_status']) {
                $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
                $this->load->model("front_model");
                $this->front_model->generate_token_request($uname);
                $info = $this->front_model->check_login_attempt($uname, 'check');
                // Send email
                $link = base_url('unblock/' . $info->web_token . '/' . base64_encode($info->email));
                $mail_body = "Dear User,
				<br /><br />
				Your account has been locked due to multiple wrong entry of your password.<br />
				Please <a href='" . $link . "' target='_blank'>Click Here</a> to unlock your account.
				<br /><br />";
                $mail_sub = "Unblock your account";
                //echo $mail_body; die;
                $this->load->model("common_model");

                // $this->common_model->send_emails(CV_EMAIL_FROM, $uname, $mail_sub, $mail_body);
                ############ Get SMTP DEtails FOR Sending Mail #############

                // $email_config=HLP_GetSMTP_Details($domain_dtls['company_Id']);

                #############################################################

                //$this->common_model->send_emails_from_corn_job($email_config['email_from'], $uname, $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);

                $user_data = $this->front_model->get_table_row("login_user", "id, other_data_20 AS email", array("email" => $uname));

                $mail_send_data = array(

                    'company_id'    => $domain_dtls['company_Id'],
                    'user_id'       => $info->id,
                    'user_name'     => $info->name,
                    'mail_to'       => $user_data['email'],
                    'mail_subject'  => $mail_sub,
                    'mail_body'     => addslashes($mail_body),

                );

                $this->common_model->send_individual_mail($mail_send_data);

                $this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Please check your email to activate your account.</b></span></div>');
                redirect(base_url());
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    public function account_unblock($token, $uemail)
    {

        $data['msg'] = "";

        $user_email = base64_decode($uemail);
        $username_arr = explode('@', $user_email);
        $domain_name = end($username_arr);
        $this->load->model("domain_model");
        $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

        if ($domain_dtls) {
            // $user_id = base64_decode($uid);
            if ($domain_dtls['company_status']) {
                $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
                $this->load->model("front_model");
                $result = $this->front_model->check_reset_token($token, $user_email);
                if ($result) {
                    $url = 'verify-account/' . base64_encode($result['id']) . '/' . base64_encode($result['email']);
                    redirect(base_url($url));
                } else {
                    redirect(base_url());
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    public function google_validate_captcha()
    {
        $google_captcha = $this->input->post('g-recaptcha-response');
        $google_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . CV_CAPTCHA_SECRET_KEY . "&response=" . $google_captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $google_response_arr = json_decode($google_response, true);
        if ($google_response_arr["success"] === true) {
            return TRUE;
        } else {
            $this->form_validation->set_message('google_validate_captcha', 'Invalid Captcha.');
            return FALSE;
        }
    }

    public function logout()
    {

        $ssologin_ses = $this->session->userdata('ssologin_ses');
        $ssologin_ses_reverse_logout = $this->session->userdata('ssologin_ses_reverse_logout');
        $data['sso'] = false;
        $data['showloginbox'] = false;
        $this->load->model("domain_model");
        if ($sso_config = $this->domain_model->get_sso_config()) {
            $data['sso'] = true;
            if ($sso_config['showloginbox']) {
                $data['showloginbox'] = true;
            }
        }
        $this->load->model("front_model");
        if ($this->session->userdata('userid_ses')) {
            $this->front_model->log_update_details($this->session->userdata('userid_ses'));
        }
        $this->session->sess_destroy();
        setcookie(session_name(), "", time() - 3600);
        delete_cookie("dn");
        $data["msg"] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Logged out successfully.</b></div>';
        $data['title'] = "Home";


        if ($ssologin_ses_reverse_logout &&  $ssologin_ses) {
            header('Pragma: no-cache');
            header('Cache-Control: no-cache, must-revalidate');
            header('Location: ' . site_url('ssologin/index.php?slo')); // $spUrl);
            exit();
        }
        $this->load->view('login', $data);
    }

    public function verify_account($uid, $uemail)
    {
        delete_cookie("dn");
        $data['msg'] = "";
        $user_email = base64_decode($uemail);
        $user_id = base64_decode($uid);
        $username_arr = explode('@', $user_email);
        $domain_name = end($username_arr);
        $this->load->model("domain_model");
        $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

        if ($domain_dtls) {
            if ($domain_dtls['company_status']) {

                $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
                set_cookie('dn', base64_encode($domain_dtls['dbname']), '21600'); //This cookie will expire within 21600 Sec

                $this->load->model("front_model");
                $check_blocked_status = $this->front_model->get_unblockeduserinfo($user_id, $user_email);

                if ($check_blocked_status->incorrect_attempts > 2) {

                    $result = $this->front_model->checked_blocked_user_info($user_id, $user_email);
                } else {

                    $result = $this->front_model->check_account_is_verified($user_id, $user_email);
                }

                if ($result) {
                    if ($this->input->post('password')) {
                        HLP_is_cross_origin_req(); //To check request is coming from our server or not
                        //$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|matches[conf_password]');
                        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!~#%*?&])[A-Za-z\d$@$!~#%*?&]{8,}/]|matches[conf_password]', array('regex_match' => 'Password must contain at least 8 characters including <br> one uppercase letter, one lowercase letter, one number and one special character.'));
                        $this->form_validation->set_rules('conf_password', ' confirm password', 'trim|required');

                        if ($this->form_validation->run()) {
                            $new_pwd = md5($this->input->post('password'));
                            $this->front_model->change_password(array("id" => $user_id), array("status" => "1", "pass" => $new_pwd, "incorrect_attempts" => 0));

                            $result = $this->front_model->is_valid_user($user_email, $new_pwd, $domain_dtls['company_Id']);

                            $company_dtls = $this->front_model->get_table_row("manage_company", "*", array("id" => $domain_dtls['company_Id'], "dbname" => $domain_dtls['dbname']));

                            if ($result) {
                                if ($company_dtls) {
                                    $this->create_usr_session($result, $company_dtls, $domain_dtls);
                                    /*$new_web_token = HLP_generate_web_token();
                                    $this->front_model->change_password(array("id" => $result['id']), array("web_token" => $new_web_token));
                                    $color = "00ADEF";
                                    if ($company_dtls['company_color']) {
                                        $color = $company_dtls['company_color'];
                                    }
                                    if ($company_dtls['company_light_color']) {
                                        $company_light_color = $company_dtls['company_light_color'];
                                    } else {
                                        $company_light_color = $company_dtls['company_color'];
                                    }

                                    $detail = array(
                                        'userid_ses' => $result['id'],
                                        'email_ses' => $result['email'],
                                        'username_ses' => $result['name'],
                                        'role_ses' => $result['role'],
                                        'is_manager_ses' => $result['is_manager'],
                                        'manage_hr_only_ses' => $result['manage_hr_only'],
                                        'companyid_ses' => $domain_dtls['company_Id'],
                                        'companyname_ses' => $domain_dtls['company_name'],
                                        'domainname_ses' => $domain_dtls['domainName'],
                                        'company_color_ses' => $color,
                                        'company_light_color_ses' => $company_light_color,
                                        'company_logo_ses' => $company_dtls['company_logo'],
                                        'company_bg_img_url_ses' => $company_dtls['company_bg_img'],
                                        'proxy_is_manager_ses' => $result['is_manager'],
                                        'proxy_manage_hr_only_ses' => $result['manage_hr_only'],
                                        'proxy_userid_ses' => $result['id'],
                                        'proxy_username_ses' => $result['name'],
                                        'proxy_role_ses' => $result['role'],
                                        'proxy_user_web_token_ses' => $new_web_token,
                                        'market_data_by_ses' => $company_dtls['market_data_by']
                                    );
                                    $this->session->set_userdata($detail);

                                    $this->load->model("common_model");
                                    $this->common_model->set_permissions_session_arr();
                                    $this->loggeddetails($result['id']);
                                    if ($this->session->userdata('role_ses') < 11) {
                                        redirect(site_url("dashboard"));
                                    }
									else {
                                        redirect(site_url("employee/dashboard"));
                                    }*/
                                } else {
                                    $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid company.</b></div>';
                                }
                            } else {
                                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid email.</b></div>';
                            }
                        } else {
                            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>';
                        }
                    }

                    $data['email'] = $result['email'];
                    $data['title'] = "Setup Your Account";
                    $this->load->view('set_employee_pwd', $data);
                } else {
                    redirect(site_url());
                }
            } else {
                redirect(site_url());
            }
        } else {
            redirect(site_url());
        }
    }

    public function forgot_password()
    {

        $this->load->model("common_model");
        $data['msg'] = "";

        if ($this->input->post()) {
            HLP_is_cross_origin_req(); //To check request is coming from our server or not
            $this->form_validation->set_rules('email', 'EMAIL', 'trim|required');
            if ($this->form_validation->run()) {
                $uname = $this->input->post('email');
                $username_arr = explode('@', $uname);
                $domain_name = end($username_arr);

                $this->load->model("domain_model");
                $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

                if ($domain_dtls) {
                    if ($domain_dtls['company_status']) {
                        $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));

                        $this->load->model("front_model");
                        $result = $this->front_model->get_table_row("login_user", "id, name, company_Id, other_data_20 AS email", array("email" => $uname, 'incorrect_attempts < ' => 3));

                        if ($result) {
                            $this->load->helper('string');
                            $new_pwd = strtolower(random_string('alnum', 6));
                            $this->front_model->change_password(array("id" => $result["id"]), array("pass" => md5($new_pwd)));
                            $emailTemplate = $this->common_model->getEmailTemplate('forgotPassword');
                            //                       $mail_body = "Dear " . strtoupper($result["name"]) . ",
                            // <br /><br />
                            // Your Username :" . $uname . "<br />
                            // <br /><br />
                            // New Password :" . $new_pwd . "<br />
                            // <br /><br />";

                            $mail_sub = $emailTemplate[0]->email_subject;
                            $str = str_replace("{{employee_first_name}}", strtoupper($result["name"]), $emailTemplate[0]->email_body);
                            $str = str_replace("{{url}}", site_url(), $str);
                            $str = str_replace("{{email_id_reciver}}", $uname, $str);
                            $str = str_replace("{{password}}", $new_pwd, $str);
                            $mail_body = $str;

                            //$this->common_model->send_emails(CV_EMAIL_FROM, $uname, $mail_sub, $mail_body);

                            ############ Get SMTP DEtails FOR Sending Mail #############

                            //$email_config=HLP_GetSMTP_Details($result['company_Id']);

                            #############################################################

                            //$this->common_model->send_emails_from_corn_job($email_config['email_from'], $uname, $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);

                            $mail_send_data = array(

                                'company_id'    => $result['company_Id'],
                                'user_id'       => $result['id'],
                                'user_name'     => $result['name'],
                                'mail_to'       => $result['email'],
                                'mail_subject'  => $mail_sub,
                                'mail_body'     => addslashes($mail_body),

                            );

                            $this->common_model->send_individual_mail($mail_send_data);

                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please check your mail box for getting login details.</b></div>');

                            redirect(site_url());
                        } else {
                            $info = $this->front_model->check_login_attempt($uname, 'check');
                            if ($info->incorrect_attempts > 2) {
                                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your account has been locked due to multiple wrong entry of your password. Please reset your password by clicking forgot password option below.</b></div>';
                            } else {
                                $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid email.</b></div>';
                            }
                        }
                    } else {
                        $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Services to this account are temporarily disabled. Please contact the administrator.</b></div>';
                    }
                } else {
                    $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid email..</b></div>';
                }
            } else {
                $data['msg'] = validation_errors();
            }
        }

        $data['title'] = "Forgot Password";
        $this->load->view('forgot_password', $data);
    }

    public function reset_password()
    {
        $data['msg'] = "";
        if ($this->input->post()) {

            HLP_is_cross_origin_req(); //To check request is coming from our server or not
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!~#%*?&])[A-Za-z\d$@$!~#%*?&]{8,}/]|matches[passconf]', array('regex_match' => 'New password must contain at least 8 characters including <br> one uppercase letter, one lowercase letter, one number and one special character.'));
            $this->form_validation->set_rules('passconf', 'confirm password', 'trim|required');
            if ($this->form_validation->run()) {
                $uname = $this->input->post('email');
                $username_arr = explode('@', $uname);
                $domain_name = end($username_arr);

                $this->load->model("domain_model");
                $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

                if ($domain_dtls) {
                    if ($domain_dtls['company_status']) {
                        $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));

                        $this->load->model("front_model");
                        $result = $this->front_model->get_table_row("login_user", "id, name", array("email" => $uname));
                        if ($result) {
                            $new_pwd = $this->input->post('password');
                            $this->front_model->change_password(array("id" => $result["id"]), array("pass" => md5($new_pwd), "incorrect_attempts" => 0));

                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your password has been successfully reset</b></div>');
                            redirect(site_url());
                        } else {
                            $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid email.</b></div>';
                        }
                    } else {
                        $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Services to this account are temporarily disabled. Please contact the administrator.</b></div>';
                    }
                } else {
                    $data["msg"] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid email..</b></div>';
                }
            } else {
                $data['msg'] = validation_errors();
            }
        }

        $data['title'] = "Reset Password";
        $this->load->view('reset_password', $data);
    }

    //** CB-rajesh on 03-01-2019 user logged details  **//
    protected function loggeddetails($user_id, $status = 1)
    {
        $logged_data = array(
            'user_id' => $user_id,
            'createdon' => date('Y-m-d h:i:s'),
            'ip_address' => $this->input->ip_address(),
            'status' => $status
        );

        $this->front_model->logged_user_details($logged_data);
    }

    public function term_conditions()
    {
        if ($this->session->userdata('role_ses') > 1 and $this->session->userdata('companyid_ses') == CV_SURVEY_COMPANY_ID) {
            redirect(site_url("survey/users"));
        }
        $this->load->model("front_model");
        $this->load->model("admin_model");

        $id = $this->session->userdata('userid_ses');
        if ($id) {
            $userdetails = $this->admin_model->get_table_row("login_user", "is_accept_term", array("id" => $id));
            if ($userdetails['is_accept_term'] == 1) {
                if ($this->session->userdata('role_ses') < 11) {
                    redirect(site_url("dashboard"));
                } else {
                    redirect(site_url("employee/dashboard"));
                }
            }
            if ($this->input->post()) {
                $this->form_validation->set_rules('txt_term', 'Term Condition', 'trim|required');

                if ($this->form_validation->run()) {
                    $term = $this->input->post('txt_term');
                    $db_arr = array(
                        "is_accept_term" => $term
                    );
                    if ($id) {
                        $this->admin_model->update_tbl_data("login_user", $db_arr, array("id" => $id));

                        if ($this->session->userdata('role_ses') < 11) {
                            redirect(site_url("dashboard"));
                        } else {
                            redirect(site_url("employee/dashboard"));
                        }
                    } else {
                        redirect(site_url("logout"));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>' . validation_errors() . '</b></div>');
                    redirect(site_url("term-conditions"));
                }
            }

            $data['title'] = "Accept Term";
            $this->load->view('term_conditions', $data);
        } else {
            redirect(site_url("logout"));
        }
    }

    //Start :: Nibha's Work ******************
    private function generateJWT($email, $uid, $webtoken, $role, $unit)
    {
        $this->load->helper(array('jwt_helper'));
        $token = array();

        $token['det'] = $email;
        $token['ui'] = $uid;
        $token['role'] = $role;
        $token['unit'] = $unit;
        $object = config_item('secret_key_jwt');
        //setcookie("Acc3ssTo73n", JWT::encode($token,$object ));
        set_cookie('Acc3ssTo73n', JWT::encode($token, $object), 2700);
    }
    //End :: Nibha's Work ******************

    private function create_usr_session($usr_info, $company_dtls, $domain_dtls)
    {
        $this->load->model("front_model");
        $new_web_token = HLP_generate_web_token();
        $this->front_model->change_password(array("id" => $usr_info['id']), array("web_token" => $new_web_token));
        $color = "00ADEF";
        if ($company_dtls['company_color']) {
            $color = $company_dtls['company_color'];
        }

        if ($company_dtls['company_light_color']) {
            $company_light_color = $company_dtls['company_light_color'];
        } else {
            $company_light_color = $company_dtls['company_color'];
        }

        $detail = array(
            'userid_ses' => $usr_info['id'],
            'email_ses' => $usr_info['email'],
            'username_ses' => $usr_info['name'],
            'role_ses' => $usr_info['role'],
            'is_manager_ses' => $usr_info['is_manager'],
            'manage_hr_only_ses' => $usr_info['manage_hr_only'],
            'companyid_ses' => $domain_dtls['company_Id'],
            'companyname_ses' => $domain_dtls['company_name'],
            'domainname_ses' => $domain_dtls['domainName'],
            'company_color_ses' => $color,
            'company_light_color_ses' => $company_light_color,
            'company_logo_ses' => $company_dtls['company_logo'],
            'company_bg_img_url_ses' => $company_dtls['company_bg_img'],
            'proxy_is_manager_ses' => $usr_info['is_manager'],
            'proxy_manage_hr_only_ses' => $usr_info['manage_hr_only'],
            'proxy_username_ses' => $usr_info['name'],
            'proxy_userid_ses' => $usr_info['id'],
            'proxy_role_ses' => $usr_info['role'],
            'proxy_user_web_token_ses' => $new_web_token,
            'market_data_by_ses' => $company_dtls['market_data_by'],
            'domain_check_required_ses' => $domain_dtls['domain_check_required']
        );

        //Add module status in seesion
        if (!empty($domain_dtls['manage_module'])) {
            $manage_module = json_decode($domain_dtls['manage_module']);

            foreach ($manage_module as $module_name => $module_status) {
                $detail[$module_name] =  $module_status;
            }
        }

        $this->session->set_userdata($detail);
        $this->load->model("common_model");
        $this->common_model->set_permissions_session_arr();
        $this->loggeddetails($usr_info['id'], 1);

        //Start :: Nibha's Work ******************
        $this->generateJWT($usr_info['email'], $usr_info['id'],   $new_web_token,  $usr_info['role'], $domain_dtls['company_Id']);
        //End :: Nibha's Work *****************

        //Redirection to check session existance
        set_cookie('attempt', 1, 60); //This cookie will expire within 60 Sec
        if (empty(get_cookie("attempt")) ||  get_cookie("attempt") == 1) {
            //  log_message('debug', 'redirect sso_process_login_attempt jump 1');
            $is_accept_term    = $usr_info['is_accept_term'];
            redirect(site_url("home/sso_process_login_attempt/" . $is_accept_term));
        }

        if ($this->session->userdata('role_ses') > 1 and $this->session->userdata('companyid_ses') == CV_SURVEY_COMPANY_ID) {
            redirect(site_url("survey/users"));
        }

        if ($usr_info['is_accept_term'] == 0) {
            redirect(site_url("term-conditions"));
        } else {
            if ($this->session->userdata('role_ses') < 11) {
                redirect(site_url("dashboard"));
            } else {
                redirect(site_url("employee/dashboard"));
            }
        }
    }

    public function sso_process_login_attempt($is_accept_term = 0)
    {
        log_message('debug', "attemp:" . get_cookie("attempt"));
        if ($this->session->userdata('role_ses')) {
            delete_cookie("attempt");

            if ($this->session->userdata('role_ses') > 1 and $this->session->userdata('companyid_ses') == CV_SURVEY_COMPANY_ID) {
                redirect(site_url("survey/users"));
            }

            if ($is_accept_term == 0) {
                redirect(site_url("term-conditions"));
            } else {
                if ($this->session->userdata('role_ses') < 11) {
                    redirect(site_url("dashboard"));
                } else {
                    redirect(site_url("employee/dashboard"));
                }
            }
        } else {
            set_cookie('attempt', 2, 30); //This cookie will expire within 2700 Sec
            redirect(site_url("ssologin/index.php?sso"));
        }
    }

    public function peoplestrongSSO()
    {
        $msg = "";
        $post_params =  $_POST;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $post_params["CallbackURL"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $post_params["AccessToken"],
                "Postman-Token: ff0e0a34-a8b1-443a-9ca8-3afcf60df150",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        $uname = $response["officialemail"];
        $employee_code = $response["employeecode"];

        /*
        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }*/

        //should be remove in production
        $uname = str_replace("peoplestrong.com", "four.com", $uname);

        if ($uname) {
            $pass = "";
            //$domain_name = end($username_arr);          

            $domain_name =  strtolower($_SERVER['HTTP_HOST']);
            if (in_array($domain_name, array("localhost", "uat.compport.com", "preview.compport.com"))) {
                list($email1, $domain_name) = explode('@', $uname);
            }

            $this->load->model("domain_model");
            $domain_dtls = $this->domain_model->is_valid_domain($domain_name);

            if ($domain_dtls) {
                if ($domain_dtls['company_status']) {
                    $this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
                    $this->load->model("front_model");
                    $result = $this->front_model->is_valid_user($uname, $pass, $domain_dtls['company_Id'], 2);


                    $company_dtls = $this->front_model->get_table_row("manage_company", "*", array("id" => $domain_dtls['company_Id'], "dbname" => $domain_dtls['dbname']));
                    if ($result) {

                        // Reset incorrect_attempts filed value
                        $this->front_model->reset_login_attempt($uname);
                        if ($company_dtls) {
                            $this->create_usr_session($result, $company_dtls, $domain_dtls);
                        } else {
                            $msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid company account.</b></div>';
                        }
                    } else {
                        // Block user login after 3 unsuccessful attempts
                        $this->front_model->check_login_attempt($uname);
                        $info = $this->front_model->check_login_attempt($uname, 'check');
                        if ($info) {
                            $this->loggeddetails($info->id, 2);
                        }
                        if ($info->incorrect_attempts > 2) {
                            if ($info->incorrect_attempts == 3) {
                                // Send email
                                $emailTemplate = $this->common_model->getEmailTemplate("unblockAccount");
                                $link = base_url('unblock/' . $info->web_token . '/' . base64_encode($info->email));
                                $str = str_replace("{{url}}", $link, $emailTemplate[0]->email_body);
                                $mail_body = $str;
                                $mail_sub = $emailTemplate[0]->email_subject;
                                $this->load->model("common_model");

                                //$this->common_model->send_emails(CV_EMAIL_FROM, $uname, $mail_sub, $mail_body);

                                ############ Get SMTP DEtails FOR Sending Mail #############

                                $email_config = HLP_GetSMTP_Details();

                                #############################################################

                                $this->common_model->send_emails($email_config['email_from'], $uname, $mail_sub, $mail_body, $email_config['result'], $email_config['mail_fromname']);
                            }
                            $msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your account has been locked due to multiple wrong entry of your password. Please reset your password by clicking forgot password option below.</b></div>';
                        } else {
                            $total_attempt = 3 - intval($info->incorrect_attempts);
                            if ($total_attempt == 1) {
                                $total_attempt = 'Your ' . $total_attempt . ' attempt are remaining.';
                            } else {
                                $total_attempt = 'Your ' . $total_attempt . ' attempts are remaining.';
                            }
                            $msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again. ' . $total_attempt . '</b></div>';
                        }
                    }
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Services to this account are temporarily disabled. Please contact the administrator.</b></div>';
                }
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid Account. Please try again.</b></div>';
            }
        }
        $msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Account doesn’t existed. Please try again.</b></div>';
        $data['msg'] = $msg;
        $data['title'] = "Home";
        $this->load->view('login', $data);
    }
}
