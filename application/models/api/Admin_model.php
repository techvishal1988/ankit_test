<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
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

	public function get_staff_list($condition_arr="")
	{	
		$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, login_user.upload_id, manage_country.name as country, manage_city.name as city,  manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as subfunction, manage_grade.name as grade, manage_level.name as level, manage_business_level_3.name as business_unit_3");
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		//$this->db->join("manage_bussiness_unit", "manage_bussiness_unit.id = login_user.bussiness_unit_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		$this->db->join("manage_level", "manage_level.id = login_user.level","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->where(array("role >"=> 2, "login_user.status !="=>2));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$data = $this->db->from("login_user")->get()->result_array();
		$tempArr =	array();	
		if($data)
		{
			foreach($data as $row)
			{
				//$row["business_unit_3"] = "";
				$row["date_of_joining"] = "";
				$row["performance_rating"] = "";

				/*$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_BUSINESS_LEVEL_3_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["business_unit_3"] = $dt["value"];
				}*/

				$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["date_of_joining"] = $dt["value"];
				}

				$this->db->select("value");
				$this->db->join("datum","datum.row_num = tuple.row_num");
				$this->db->where(array("datum.data_upload_id"=>$row["upload_id"], "business_attribute_id"=>CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID, "tuple.data_upload_id"=>$row["upload_id"], "user_id"=>$row["id"]));
				$dt = $this->db->get("tuple")->row_array();
				if($dt)
				{
					$row["performance_rating"] = $dt["value"];
				}

				$tempArr[] = $row;
			}
		}
		return $tempArr;
	}

	public function get_staff_list_by_uploaded_id($condition_arr)
	{	
		$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.desig, login_user.status");
		$this->db->from("tuple");
		$this->db->where($condition_arr);
		$this->db->join("login_user","login_user.id = tuple.user_id");
		return $this->db->get()->result_array();
	}

	public function insert_staff($staff_db_arr)
	{	
		$this->db->insert("login_user",$staff_db_arr);
	}

	public function get_designation_list()
	{	
		$this->db->select("*");
		//return $this->db->where(array("status"=>1, "id >"=>1))->get("manage_designation")->result_array();
		//return $this->db->where(array("status"=>1, "id ="=>3))->get("manage_designation")->result_array();
		return $this->db->get("manage_designation")->result_array();
	}	

	public function insert_designation($db_arr)
	{	
		$this->db->insert("manage_designation",$db_arr);

	}

	public function get_country_list()
	{	
		$this->db->select("*");
		return $this->db->from("manage_country")->get()->result_array();
	}

	public function insert_country($country_db_arr)
	{	
		$this->db->insert("manage_country",$country_db_arr);
	}

	public function staffDetails($usrId)
	{
//            echo $usrId;
		return $this->db->from('tuple')->where(array('user_id'=>$usrId))->order_by('tuple.id','desc')->get()->row_array();
	}
        
        public function staffattributes()
        {
            $this->db->select("ba_grouping");		
            $this->db->from("business_attribute");
            $this->db->group_by("ba_grouping")->order_by('ba_groups_order','asc');
//            $result=array();
            $result=array();
            $grarr=array();
            $group= $this->db->get()->result_array();
            foreach($group as $row){
                $grarr[]=$row['ba_grouping'];
            }
//            print_r($grarr);die;
            foreach($grarr as $gr){
                $this->db->select("*");
                $result[$gr]=$this->db->from('business_attribute')->where(array('ba_grouping'=>$gr))->order_by('ba_attributes_order','asc')->get()->result_array();;
            }
//            $this->db->select("*");
            return $result;
//	    return $this->db->from("business_attribute")->get()->result_array();
        }

        public function completeStafDetails($whereCondition)
	{
//            	$dt= $this->db->from('datum')->where($whereCondition)->join('business_attribute','business_attribute.id=datum.business_attribute_id')->order_by('datum.display_name_override','asc')->get()->result_array();	
//                    print_r($dt);
                    return $this->db->from('datum')->where($whereCondition)->join('business_attribute','business_attribute.id=datum.business_attribute_id')->order_by('datum.display_name_override','asc')->get()->result_array();	
//		return $this->db->from('datum')->where($whereCondition)->order_by('datum.display_name_override','asc')->get()->result_array();	
	}
	
	public function get_city_list()
	{	
		$this->db->select("*");
		return $this->db->from("manage_city")->get()->result_array();
	}

	public function get_bussiness_unit_list_NIU()
	{	
		$this->db->select("*");
		return $this->db->from("manage_bussiness_unit")->get()->result_array();
	}

	public function get_grade_list()
	{	
		$this->db->select("*");
		return $this->db->from("manage_grade")->get()->result_array();
	}

	public function check_user_rights_conflicts($user_id, $user_role, $country_ids, $city_ids, $bussiness_level_1_ids, $bussiness_level_2_ids, $bussiness_level_3_ids, $fun_ids, $sub_fun_ids, $designation_ids, $grade_ids)
	{	
		//Check without cuurent user
		/*$qry ="Select user_id from rights_on_grades where grade_id in (1,0) and user_id in 
				( 
					Select user_id from rights_on_designations where designation_id in (1,0) and user_id in 
				    ( 
				    	Select user_id from rights_on_sub_functions where sub_function_id in (1,0) and user_id in        ( 
				        	Select user_id from rights_on_functions where function_id in (1,0) and user_id in 
				            ( 
				            	Select user_id from rights_on_business_units where business_unit_id in (1,0) and user_id in 
				                ( 
				                	Select user_id from rights_on_city where city_id in (3,0) and user_id in
				                    (
				                    	Select user_id from rights_on_country where country_id in (1,2,0) and user_id <> 36
				                     )
				             	)
				        	) 
						) 
					) 
				)";*/


		$country_cnd = " and country_id in (0,".$country_ids.")";
		if($country_ids=="0")
		{
			$country_cnd = "";
		}
		$city_cnd = " and city_id in (0,".$city_ids.")";
		if($city_ids=="0")
		{
			$city_cnd = "";
		}
		$bussiness_level_1_cnd = " and business_level_1_id in (0,".$bussiness_level_1_ids.")";
		if($bussiness_level_1_ids=="0")
		{
			$bussiness_level_1_cnd = "";
		}

		$bussiness_level_2_cnd = " and business_level_2_id in (0,".$bussiness_level_2_ids.")";
		if($bussiness_level_2_ids=="0")
		{
			$bussiness_level_2_cnd = "";
		}
		$bussiness_level_3_cnd = " and business_level_3_id in (0,".$bussiness_level_3_ids.")";
		if($bussiness_level_3_ids=="0")
		{
			$bussiness_level_3_cnd = "";
		}

		$fun_cnd = " and function_id in (0,".$fun_ids.")";
		if($fun_ids=="0")
		{
			$fun_cnd = "";
		}
		$sub_fun_cnd = " and sub_function_id in (0,".$sub_fun_ids.")";
		if($sub_fun_ids=="0")
		{
			$sub_fun_cnd = "";
		}
		$designation_cnd = " and designation_id in (0,".$designation_ids.")";
		if($designation_ids=="0")
		{
			$designation_cnd = "";
		}
		$grade_cnd = " and grade_id in (0,".$grade_ids.")";
		if($grade_ids=="0")
		{
			$grade_cnd = "";
		}
		
		$user_id_cnd = "";
		if($user_id)
		{
			$user_id_cnd = "id != '".$user_id."' and ";
		}

		//Check for over all users accept given user
		$qry ="Select id as user_id from login_user where ".$user_id_cnd." role = ".$user_role." and status=1 and id in 
				( 
					Select user_id from rights_on_grades where status=1 ".$grade_cnd." and user_id in 
					( 
						Select user_id from rights_on_designations where status=1 ".$designation_cnd." and user_id in 
					    ( 
					    	Select user_id from rights_on_sub_functions where status=1 ".$sub_fun_cnd." and user_id in        ( 
					        	Select user_id from rights_on_functions where status=1 ".$fun_cnd." and user_id in 
					            ( 
					            	Select user_id from rights_on_business_level_3 where status=1 ".$bussiness_level_3_cnd." and user_id in 
					                ( 
					                	Select user_id from rights_on_business_level_2 where status=1 ".$bussiness_level_2_cnd." and user_id in 
						                ( 
						                	Select user_id from rights_on_business_level_1 where status=1 ".$bussiness_level_1_cnd." and user_id in 
							                (
							                	Select user_id from rights_on_city where status=1 ".$city_cnd." and user_id in
							                    (
							                    	Select user_id from rights_on_country where status=1 ".$country_cnd."
							                     )
						                     )
					                     )
					             	)
					        	) 
							) 
						) 
					)
				)";
		return $this->db->query($qry)->result_array();
	}

	public function insert_user_rights_temp_NIU($db_arr)
	{	
		$this->db->insert("user_rights_temp",$db_arr);
		return $this->db->insert_id();
	}

	public function get_users_for_view_rights() 
	{
		$this->db->select("user_id");		
        $this->db->from("rights_on_country");
		//$this->db->where("status = 1 and user_id in (select id from login_user where status=1 and role > 1)");
		$this->db->where("status = 1 and user_id in (select id from login_user where status=1 and role > 2)");
		$this->db->group_by("user_id");
		return $this->db->get()->result_array();		
	}

	public function insert_data_in_tbl($table, $db_arr)
	{	
		$this->db->insert($table,$db_arr);
	}

	public function get_table_row($table, $fields, $condition_arr) 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		return $this->db->get()->row_array();		
	}

	public function get_table($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->result_array();		
	}

	public function update_tbl_data($table, $data, $where_condition)
	{	
		$this->db->where($where_condition);
		$this->db->update($table, $data);
	} 

	public function get_employees_as_per_rights($condition_arr)
	{	
		$this->db->select("login_user.id, login_user.email, login_user.name, login_user.role, login_user.status, login_user.hr_user_id, manage_country.name as country, manage_city.name as city, manage_business_level_1.name as business_level_1, manage_business_level_2.name as business_level_2, manage_business_level_3.name as business_level_3, manage_designation.name as desig, manage_function.name as function, manage_subfunction.name as sub_function, manage_grade.name as grade");
		$this->db->join("manage_country", "manage_country.id = login_user.country_id","left");
		$this->db->join("manage_city", "manage_city.id = login_user.city_id","left");
		$this->db->join("manage_business_level_1", "manage_business_level_1.id = login_user.business_level_1_id","left");
		$this->db->join("manage_business_level_2", "manage_business_level_2.id = login_user.business_level_2_id","left");
		$this->db->join("manage_business_level_3", "manage_business_level_3.id = login_user.business_level_3_id","left");
		$this->db->join("manage_function", "manage_function.id = login_user.function_id","left");
		$this->db->join("manage_subfunction", "manage_subfunction.id = login_user.sub_function_id","left");
		$this->db->join("manage_designation", "manage_designation.id = login_user.desig","left");
		$this->db->join("manage_grade", "manage_grade.id = login_user.grade","left");
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->where(array("login_user.manage_hr_only"=>0));//Taking only company Emp
		return $this->db->from("login_user")->get()->result_array();
	}

	public function update_employees_hr($data, $where_condition)
	{	
		$this->db->where($where_condition);
		$this->db->update('login_user', $data);
	} 
	
	public function get_role_permission_details($role_id)
	{
		$this->db->select('role_permissions.id, role_permissions.view, role_permissions.insert, role_permissions.update, role_permissions.delete, pages.name as page_name, pages.id as page_id');
		$this->db->from('pages');
		$this->db->join('role_permissions', 'role_permissions.page_id = pages.id', 'left');
		$this->db->where('role_permissions.role_id', $role_id);
		return $this->db->get()->result_array();		

	}

	public function autocomplete($term)
    {
        $query = $this->db->query("SELECT email as value FROM login_user WHERE status != 2 AND role > 2 AND id != ".$this->session->userdata('userid_ses')." AND email LIKE '%".$term."%' ");
        echo json_encode($query->result_array());
    }
	     
}