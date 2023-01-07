<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tooltip_model extends CI_Model
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
    
    public function save($table,$data)
    {
        $res=  $this->db->insert_batch($table,$data);
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function update($table,$data,$where)
    {
        
        $this->db->where($where);
        $res=$this->db->update($table,$data);
        
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getpages($id = '')
    {
        if(!empty($id)) {
            return $this->db->query('Select * from tooltip_page where tooltip_page_id not in(SELECT tooltip_page_id from tooltip_screen where tooltip_page_id != '.$id.') and status = 1  ORDER BY tooltip_page_id ASC')->result();
        } else {
            return $this->db->query('Select * from tooltip_page where tooltip_page_id not in(SELECT tooltip_page_id from tooltip_screen) and status = 1 ORDER BY tooltip_page_id ASC')->result();
        }
        
    }
    public function gettooltipscreen()
    {
        return $this->db->get('tooltip_screen')->result();
    }
    public function savedata($table,$data)
    {
        
        
        $res=$this->db->insert($table,$data);
        
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function gettooltip($tooltip_desc_id)
    {
        //return $this->db->query('select * from tooltip_page where tooltip_page_id='.$tooltip_desc_id)->result();
        return $this->db->query('select * from tooltip_page tp join tooltip_screen ts on ts.tooltip_page_id=tp.tooltip_page_id where tp.tooltip_page_id='.$tooltip_desc_id)->result();
    }
    public function gettooltipdetail($tooltip_page)
    {
        //return $this->db->query('select * from tooltip_page where tooltip_page_id='.$tooltip_desc_id)->result();
        return $this->db->query('select * from tooltip_page tp join tooltip_screen ts on ts.tooltip_page_id=tp.tooltip_page_id where tp.tooltip_page="'.$tooltip_page.'"')->result();
    }
    public function tooltipsc($tooltip_desc_id,$scno)
    {
        //return $this->db->query('select * from tooltip_page where tooltip_page_id='.$tooltip_desc_id)->result();
        return $this->db->query('select * from tooltip_page tp join tooltip_screen ts on ts.tooltip_page_id=tp.tooltip_page_id where ts.Screen_No='.$scno.' and tp.tooltip_page_id='.$tooltip_desc_id)->result();
    }
    public function getAllTooltip()
    {
        return $this->db->query('select * from tooltip_page tp join tooltip_screen ts on ts.tooltip_page_id=tp.tooltip_page_id GROUP by tp.tooltip_page_id')->result();
    }
    public function delete($tooltip_desc_id)
    {
        $res=$this->db->delete('tooltip_desc', array('tooltip_desc_id' => $tooltip_desc_id));
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_parent_data() {
        $parentKey = json_decode(CV_TOOLTIP_MASTER_ARRAY);
        return $this->db->select('id,name')->from('pages')->where_in('id', $parentKey)->order_by('name','asc')->get()->result_array();
    }
    
            
    
    
    
	
	     
}