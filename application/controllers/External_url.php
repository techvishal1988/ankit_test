<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class External_url extends CI_Controller
{   
    function __construct()
	{
		parent::__construct();
	}
    
    public function generali_url()
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
		  CURLOPT_HTTPHEADER => array(
			"Accept: */*",
			"Authorization: Bearer ".$post_params["AccessToken"],
			"Cache-Control: no-cache",
			"Connection: keep-alive",
			"Host: authdc2.peoplestrong.com",
			"Postman-Token: 23bc3085-c6ae-4d2a-bacb-033f96e2c2af,3863b429-ab3b-4c57-b366-45477bc1667a",
			"User-Agent: PostmanRuntime/7.13.0",
			"accept-encoding: gzip, deflate",
			"cache-control: no-cache",
			"content-length: "
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);		
		curl_close($curl);
		
		/*if($err)
		{
		  echo "cURL Error #:" . $err;
		}
		else
		{
		  echo $response;
		}*/
		
		$response = json_decode($response, true);
		if($response["preferred_useremail"])
		{
			$uname = $response["preferred_useremail"];
			$pass = "";
			$username_arr = explode('@', $uname);
			$domain_name = end($username_arr);
			
			$this->load->model("domain_model");
			$domain_dtls = $this->domain_model->is_valid_domain($domain_name);
			
			if($domain_dtls)
			{
				if($domain_dtls['company_status'])
				{
					$this->session->set_userdata(array('dbname_ses' => $domain_dtls['dbname']));
					$this->load->model("front_model");
					$result = $this->front_model->is_valid_user($uname, $pass, $domain_dtls['company_Id'], 1);
					$company_dtls = $this->front_model->get_table_row("manage_company", "*", array("id" => $domain_dtls['company_Id'], "dbname" => $domain_dtls['dbname']));
					if($result)
					{
						// Reset incorrect_attempts filed value
						$this->front_model->reset_login_attempt($uname);
						if($company_dtls)
						{
							$new_web_token = HLP_generate_web_token();
							$this->front_model->change_password(array("id" => $result['id']), array("web_token" => $new_web_token));
							$color = "00ADEF";
							if($company_dtls['company_color'])
							{
								$color = $company_dtls['company_color'];
							}
			
							if($company_dtls['company_light_color'])
							{
								$company_light_color = $company_dtls['company_light_color'];
							}
							else
							{
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
								'market_data_by_ses' => $company_dtls['market_data_by'],
								'domain_check_required_ses' => $domain_dtls['domain_check_required']
							);
							$this->session->set_userdata($detail);
							$this->load->model("common_model");
							$this->common_model->set_permissions_session_arr();
							$this->loggeddetails($result['id']);
							
							//Start :: Nibha's Work ******************
							$this->generateJWT($result['email'], $new_web_token, $result['role'], $domain_dtls['company_Id']);
							//End :: Nibha's Work ******************
			
							if($result['is_accept_term'] == 0)
							{
								redirect(site_url("term-conditions"));
							}
							else
							{
								if($this->session->userdata('role_ses') < 11)
								{
									redirect(site_url("dashboard"));
								}
								else
								{
									redirect(site_url("employee/dashboard"));
								}
							}
						}
						else
						{
							$msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid company.</b></div>';
						}
					}
					else
					{
						// Block user login after 3 unsuccessful attempts
						$this->front_model->check_login_attempt($uname);
						$info = $this->front_model->check_login_attempt($uname, 'check');
						if($info->incorrect_attempts > 2)
						{
							if($info->incorrect_attempts == 3)
							{
								############ Get SMTP DEtails FOR Sending Mail #############

								$email_config=HLP_GetSMTP_Details();

								#############################################################
								// Send email
								$emailTemplate=$this->common_model->getEmailTemplate("unblockAccount");
								$link = base_url('unblock/' . $info->web_token . '/' . base64_encode($info->email));		   
								$str=str_replace("{{url}}",$link, $emailTemplate[0]->email_body);
								$mail_body=$str;				   
								$mail_sub = $emailTemplate[0]->email_subject;
								$this->load->model("common_model");

								// $this->common_model->send_emails(CV_EMAIL_FROM, $uname, $mail_sub, $mail_body);

								$this->common_model->send_emails($email_config['email_from'], $uname, $mail_sub, $mail_body,$email_config['result'],$email_config['mail_fromname']);
							}				
							$msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your account has been locked due to multiple wrong entry of your password. Please reset your password by clicking forgot password option below.</b></div>';
						}
						else
						{
							$total_attempt = 3 - intval($info->incorrect_attempts);
							if($total_attempt == 1)
							{
								$total_attempt = 'Your ' . $total_attempt . ' attempt are remaining.';
							}
							else
							{
								$total_attempt = 'Your ' . $total_attempt . ' attempts are remaining.';
							}
							$msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again. ' . $total_attempt . '</b></div>';
						}
					}
				}
				else
				{
					$msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Services to this account are temporarily disabled. Please contact the administrator.</b></div>';
				}
			}
			else
			{
				$msg = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Invalid credentials. Please try again.</b></div>';
			}
		}
		$this->session->set_flashdata('message', $msg);
		redirect(site_url());		
		//echo "<pre>2--";print_r($response["preferred_username"]);
		/*$this->email->from(CV_EMAIL_FROM, 'Comport');
		$this->email->to('ravi.singroli@compport.com');
		
		$this->email->subject('Call Back');
		$msg = 'callbackurl :'.$_POST['callbackurl'] .'<br>';
		$msg .= 'token :'.$_POST['token'] .'<br>';
		$msg .= 'timestamp :'.$_POST['timestamp'] .'<br>';
		$this->email->message($msg);		
		$this->email->send();
		$this->load->view('welcome');*/
    }   
}
