<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Xoxoday extends CI_Controller 
{	 
	 public function __construct()
	 {		
        parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->library('session', 'encrypt');
		$this->load->model("admin_model");
		$this->load->model("rule_model");
		$this->load->model("xoxo_model");
		//$this->load->model("common_model");
		//if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '' or ($this->session->userdata('userid_ses') != $this->session->userdata('proxy_userid_ses')))
		if(!$this->session->userdata('userid_ses') or !$this->session->userdata('role_ses') or $this->session->userdata('dbname_ses') == '')
		{			
			redirect(site_url("dashboard"));			
		}   
		HLP_is_valid_web_token();                    
    }
	
	public function index()
	{		
		$data["msg"] = "";
		
		// $list = file_get_contents("http://corp.xoxoday.com/index.php?route=clientapp/voucherlist/getvoucherlist&key=12hjk3208dsf7823hj");
        // $data['voucher'] = json_decode($list);

        $url = CV_XOXODAY_URL."?route=clientapp/voucherlist/products";
		$param = array(
			// 'product_id' => 47668,
			// 'country_name' => "philippines",
			// 'currency_code' => "PHP",
			'limit' => 24,
			'offset' => 0,
			// 'username' => "",
			// 'password' => "",
		);

        $data['voucher'] = xoxoday_CURL($url, "POST", $param);
        $data['title'] = "Voucher List";
		$data['body'] = "xoxoday/index";
        $this->load->view('common/structure',$data);
	}

	Public function VoucherBooking(){

		if($this->input->post() ) {
			$vurl = CV_XOXODAY_URL."?route=clientapp/voucherlist/products";
			$vparam = array (
				'product_id' => $this->input->post('product_id'),
				'limit' => 1,
			);
	        $vdetails = xoxoday_CURL($vurl, "POST", $vparam);
	        if($vdetails->success) {

				$vpoints = $this->input->post('denomination');
				$userid = $this->session->userdata('userid_ses');
				$upoint = $this->rule_model->get_table_row('login_user','points',array('id'=>$userid, "status" => 1));
				if(isset($upoint['points']) && $upoint['points'] >= $vpoints) {

					$externalorderid = rand(1111111111,9999999999);
					$url = CV_XOXODAY_URL."?route=clientapp/egv_test/getvoucher&key=12hjk3208dsf7823hj";
					$param = array(
						'username' => "test@abc.com",
						'password' => "Qt26dghd",
						'externalorderid' => $externalorderid,
						'denomination' => $vpoints,
						'voucher_id' => $this->input->post('product_id'),
						'quantity' => 1,
					);

			        $data = xoxoday_CURL($url, "POST", $param);
			        if($data->success){
			        	$pointArray = array(
			        		'user_id'=> $userid,
			        		'points'=> $vpoints,
			        		'v_code'=> $data->vouchers[0]->code,
			        		'v_expiry_date'=> $data->vouchers[0]->validity_date,
			        		'order_id'=> $externalorderid,
			        		'xoxo_order_id'=> $data->order_id,
			        		'status'=> $data->success,
			        		'updatedby'=> $userid,
			        		'updatedon'=> date("Y-m-d H:i:s"),
			        		'createdby'=> $userid,
			        		'v_name'=> $vdetails->vouchers[0]->product_name,
			        		'v_descriptions'=> $vdetails->vouchers[0]->product_description,
			        		'v_img'=> $vdetails->vouchers[0]->product_image,
			        	);
			        
				        $fpoint = $upoint['points'] - $vpoints;
						$this->rule_model->manage_users_history('id ='.$userid);
				        $upoint_update = $this->admin_model->update_tbl_data("login_user", array('points'=> $fpoint), array('id'=>$userid));
				        $insert_point = $this->xoxo_model->insert_point_redem($pointArray);

				        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Voucher redeem successfully.</b></div>'); 

			        } else {
			        	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>Your transition is not completed.</b></div>');
			        }
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have sufficient point.</b></div>');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b>You do not have Permission to redeem Voucher.</b></div>');
			}
		}
		redirect(site_url("xoxoday"));
	}

	// Public function get_VoucherBookingDetails(){

	// 	$curl = curl_init();

	// 	curl_setopt_array($curl, array(
	// 	  CURLOPT_URL => "https://corp.xoxoday.com/index.php?route=clientapp/egv_test/getorder&key=12hjk3208dsf7823hj",
	// 	  CURLOPT_RETURNTRANSFER => true,
	// 	  CURLOPT_ENCODING => "",
	// 	  CURLOPT_MAXREDIRS => 10,
	// 	  CURLOPT_TIMEOUT => 30,
	// 	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	// 	  CURLOPT_CUSTOMREQUEST => "POST",
	// 	  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"username\"\r\n\r\ntest@abc.com\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"password\"\r\n\r\nQt26dghd\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"order_id\"\r\n\r\nORD234\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"externalorderid\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
	// 	  CURLOPT_HTTPHEADER => array(
	// 	    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
	// 	  ),
	// 	));

	// 	$response = curl_exec($curl);
	// 	$err = curl_error($curl);

	// 	curl_close($curl);

	// 	if ($err) {
	// 	  echo "cURL Error #:" . $err;
	// 	} else {
	// 	  $data['voucher'] = json_decode($response);
 //        	echo "<pre>"; print_r($data['voucher']);die();
	// 	}
	// }

	// public function get_VoucherList($id = '') {

	// 	$id = 47668;
	// 	$curl = curl_init();
	// 	$pram = array(
	// 	  CURLOPT_URL => "http://corp.xoxoday.com/index.php?route=clientapp/voucherlist/products",
	// 	  CURLOPT_RETURNTRANSFER => true,
	// 	  CURLOPT_ENCODING => "",
	// 	  CURLOPT_MAXREDIRS => 10,
	// 	  CURLOPT_TIMEOUT => 30,
	// 	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	// 	  CURLOPT_CUSTOMREQUEST => "POST",
	// 	  CURLOPT_POSTFIELDS => "",
	// 	  CURLOPT_HTTPHEADER => array(
	// 	    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
	// 	  )
	// 	);
	// 	if(isset($id) && $id!=''){
	// 		$pram[CURLOPT_POSTFIELDS] = "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"product_id\"\r\n\r\n".$id."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--";

			
	// 		// $pram[CURLOPT_POSTFIELDS] = "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"product_id\"\r\n\r\n".$id."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"country_name\"\r\n\r\nphilippines\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"currency_code\"\r\n\r\nPHP\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"limit\"\r\n\r\n50\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"offset\"\r\n\r\n0\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"username\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"password\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--";
	// 	}

	// 	curl_setopt_array($curl, $pram);

	// 	$response = curl_exec($curl);
	// 	$err = curl_error($curl);

	// 	curl_close($curl);

	// 	if ($err) {
	// 	  echo "cURL Error #:" . $err;
	// 	} else {
	// 	  	$data['voucher'] = json_decode($response);
 //        	// echo "<pre>"; print_r($data['voucher']);die();
	// 	}
	// 	$data['title'] = "New Page";
	// 	$data['body'] = "xoxoday";
 //        $this->load->view('common/structure',$data);
	// }
}
