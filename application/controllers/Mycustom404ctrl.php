<?php 
class Mycustom404ctrl extends CI_Controller
{
    public function __construct()
	{
        parent::__construct();
    }

    public function index()
	{
		$data["heading"]= "404 Page Not Found";
		$data["message"]= "Page Not Found.";
		$this->load->view('errors/html/error_custom', $data);
    }
}

?>