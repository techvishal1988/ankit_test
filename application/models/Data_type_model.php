<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Data_type_model extends CI_MODEL
{
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$dbname = $this->session->userdata("dbname_ses");
		if(trim($dbname))
		{
			$this->db->query("Use $dbname");		
		}
    }
	
/*	function check_module($module_id,$module_value){
	
	
	if($module_id != "N/A") {
		$result = "";
		$this->db->select('table_name');
$this->db->from('modules');
$this->db->where('id',$module_id);

$query=$this->db->get();

foreach ($query->result() as $row)
{
       $result =  $row->table_name;
        
}


$this->db->select('name');

$this->db->from($result);
$this->db->where('name',$module_value);
$query=$this->db->get();

$count = $query->num_rows();




	
if($count <= 0 ){
	$sql = "insert into ".$result." (name) values(?)";
	$query = $this->db->query($sql,array($module_value));
}


	
		
	}
			
	
	}
	
	
	function fetch(){
		$this->db->select('code');
		$this->db->select('display_text');
		$query = $this-> db -> get('data_type');

		$result = $query->result_array();
		return $result;
		
	}
	function updateDataType($module,$id){
		
		$this->db->where('id', $id);
		$this->db->update('business_attribute', array('data_type_code' => $module));
		
	}*/
	public function myGetType($var)
    {
        if (is_array($var)) return "array";
        if (is_bool($var)) return "boolean";
        if (is_float($var)) return "float";
        if (is_int($var)) return "integer";
        if (is_null($var)) return "NULL";
        if (is_numeric($var)) return "numeric";
        if (is_object($var)) return "object";
        if (is_resource($var)) return "resource";
        if (is_string($var)) return "string";
        return "unknown type";
    }
	
	public function get_data_types(){
		
		$this->db->select('*');
		$this->db->from('data_type');
		return $this->db->get()->result_array();
	}	



}
?>