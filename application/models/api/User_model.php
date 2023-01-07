<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
    }
    
    public function setdb($dbname)
    {
       $this->db->query("use ".$dbname); 
    }
    
    public function updatetoken($userid,$token)
    {
        $this->db->where('id',$userid);
        $res=$this->db->update('login_user',array('token'=>$token));
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    public function userByToken($token)
    {
        return $this->db->get_where('login_user',array('token'=>$token))->result();
    }
    
    public function profile($userid)
    {
        return $this->db->query('select  lu.id as userid , lu.email, comp.company_name, rol.name as rolename, mc.name as countryname,lu.name as employeename from login_user lu join manage_company comp on comp.id=lu.company_Id join roles rol on lu.role=rol.id join manage_country mc on mc.id=lu.country_id  where lu.id='.$userid)->result();
       
    }




    
	     
}