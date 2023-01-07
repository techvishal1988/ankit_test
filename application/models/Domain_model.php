<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Domain_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();		
    }	

	public function is_valid_domain_NIU($domain_name)
	{	
	   // return  array("company_Id"=>12,"company_name"=>"Innctech Solutions", "domainName"=>"innctech.com", "dbname"=>"innctech_compben");
	    $this->db->query('use '.CV_PLATFORM_DB_NAME);
		$this->db->select("manage_company.id as company_Id, manage_company.company_name, manage_company.status as company_status, domain.domainName, manage_company.dbname, manage_company.company_color, manage_company.company_light_color, manage_company.company_logo");
		$this->db->from("domain");
		//$this->db->where("domain.domainName = '$domain_name' and manage_company.status =1");
		$this->db->where("domain.domainName = '$domain_name'");
		$this->db->join("manage_company","manage_company.id = domain.company_Id");
		$result = $this->db->get()->row_array();   
		if($result)
		{
        	return  $result ;
		}
	}
	
	public function is_valid_domain($domain_name)
	{	
	    $current_sub_domain_name = $_SERVER['HTTP_HOST'];
		$excluded_sub_domains_arr = array("", "localhost", "alpha.compport.com", "demo.compport.com");
		$select_param = "manage_company.id as company_Id, manage_company.company_name, manage_company.status as company_status, domain.domainName, manage_company.dbname,
		 manage_company.company_color, manage_company.company_light_color, manage_company.company_logo, manage_company.domain_check_required, manage_company.manage_module, 
		 domain.sub_domain_name";
		 $dbname = CV_PLATFORM_DB_NAME;
	 //   $this->db->query('use '.CV_PLATFORM_DB_NAME);
		$this->db->select($select_param);
		$this->db->from("{$dbname}.domain");
		$this->db->where("domain.domainName = '$domain_name' OR domain.sub_domain_name = '$domain_name'" );
		$this->db->join("{$dbname}.manage_company","manage_company.id = domain.company_Id");
		$result = $this->db->get()->row_array(); 	
		if($result)
		{
			if($result["sub_domain_name"] == $current_sub_domain_name or  in_array($result["sub_domain_name"], $excluded_sub_domains_arr))
			{
        		return $result;
			}
		}
		else
		{
			$this->db->select($select_param);
			$this->db->from("{$dbname}.domain");
			$this->db->where("domain.sub_domain_name = '$current_sub_domain_name'");
			$this->db->join("{$dbname}.manage_company","manage_company.id = domain.company_Id");
			$result = $this->db->get()->row_array(); 		  
			if($result)
			{
				return $result;
			}
		}
	}
	public function get_sso_config()
	{

		$current_sub_domain_name = $_SERVER['HTTP_HOST'];
		/*$excluded_sub_domains_arr = array("", "localhost", "alpha.compport.com", "demo.compport.com");
		/*$select_param = "manage_company.id as company_Id, manage_company.company_name, manage_company.status as company_status, domain.domainName, manage_company.dbname,
		manage_company.company_color, manage_company.company_light_color, manage_company.company_logo, manage_company.domain_check_required, manage_company.manage_module, 
		domain.sub_domain_name";*/
		$select_param = "sso_config";
		$dbname = CV_PLATFORM_DB_NAME;
		//$this->db->query('use ' . CV_PLATFORM_DB_NAME);
		$this->db->select($select_param);
		$this->db->from("{$dbname}.domain");
		$this->db->where("domain.sub_domain_name = '$current_sub_domain_name'");
		$this->db->join("{$dbname}.manage_company", "manage_company.id = domain.company_Id");
		$result = $this->db->get()->row_array();
		if ($result["sso_config"]) {
			$config = json_decode($result["sso_config"],true);
			return (is_array($config))?$config:false;
		}
		return  $this->get_local_config($current_sub_domain_name);
	}
	//get default sso config for development environment that are not set in db
	private function get_local_config($sub_domain_name)
	{   
		require_once(APPPATH.'config/sso/settings.php');

		//$config['localhost']['autologin']=false;
		//$config['alpha.compport.com']['autologin']=false;
		//$config['localhost']['showloginbox']=true;
		//$config['alpha.compport.com']['showloginbox']=true;
		//unset($config['localhost']);
		//unset($config['alpha.compport.com']);
		if (isset($config[$sub_domain_name])) {
			return $config[$sub_domain_name];
		}
		return false;
	}
 
}