<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {

    public function __construct() {
        parent::__construct();
       // die("Testing constructor");
        $this->load->database();
        $this->load->model("admin_model");
        $this->currentTime	= date("Y-m-d H:i:s",time());
        $this->dbname = '190902_1567424804';//'190916_1568632104';//$this->session->userdata("dbname_ses");
    }

		
	public function index() {

        $this->load->library('Mylibrary', null ,'mylibrary');
        $url = base_url()."test/mail_send_by_cron_new";

        $select_fields = 'id, mailTo, mailCc, mailBcc, mailFrom, mailFromName, mailSubject, mailContent';
        $data_array    =  $this->admin_model->get_table('cron_mail_queue', $select_fields, '');

        if(!empty($data_array)) {
            foreach($data_array as $key => $batchItem){
                $batchItem['companyid_ses'] =  $this->session->userdata('companyid_ses');
                $this->mylibrary->do_in_background($url, $batchItem);
            }
        } else {
            die("No data found");
        }
    }

    public function sent_mail_method() {

        die("sent_mail_method");
    }

}
