<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Glossary_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $dbname = $this->session->userdata("dbname_ses");
        if(trim($dbname))
        {
                $this->db->query("Use $dbname");		
        }
        date_default_timezone_set('Asia/Calcutta');
    }
    
    function save($table,$data)
    {
        $res=$this->db->insert($table,$data);
        if($res)
            {
                return  true;
            }
            else {
                return false;
            }
    }
    function get_glossary($table,$condition)
    {
        return $this->db->get_where($table,$condition)->result();
    }
    
    function update($table,$data,$condition)
    {
        $this->db->where($condition);
        $res=$this->db->update($table,$data);
        if($res)
            {
                return  true;
            }
            else {
                return false;
            }
    }
    
    function delete_glossary($table,$condition)
    {
        $this->db->where($condition);
        $res=$this->db->delete($table);
        if($res)
            {
                return  true;
            }
            else {
                return false;
            }
    }

	
	     
}