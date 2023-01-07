<?php
if(!isset($is_open_frm_manager_side))
{
	$is_open_frm_manager_side = 0;
}
if(!isset($is_open_frm_hr_side))
{
	$is_open_frm_hr_side = 0;
}

$rule_id = $rule_dtls['id'];
$checkApproverEsopRights = $checkApproverPayPerRights = $checkApproverBonusRecommandetionRights = "";

if($is_open_frm_hr_side == 1)
{
	if($is_hr_can_edit_hikes == 1)
	{
		$checkApproverEsopRights = 1;
		$checkApproverPayPerRights = 1;      
		$checkApproverBonusRecommandetionRights = 1;
	}
}
else
{
	$manager_emailid = strtolower($this->session->userdata('email_ses'));
	if($rule_dtls['esop_right']==1)
	{
		$colName="approver_1,approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['esop_right']==2)
	{
		$colName="approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['esop_right']==3)
	{
		$colName="approver_3,approver_4";
	}
	else if($rule_dtls['esop_right']==3)
	{
		$colName="approver_4";
	}
	
	if($rule_dtls['pay_per_right']==1)
	{
		$colName2="approver_1,approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['pay_per_right']==2)
	{
		$colName2="approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['pay_per_right']==3)
	{
		$colName2="approver_3,approver_4";
	}
	else if($rule_dtls['pay_per_right']==3)
	{
		$colName2="approver_4";
	}
	
	if($rule_dtls['retention_bonus_right']==1)
	{
		$colName3="approver_1,approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['retention_bonus_right']==2)
	{
		$colName3="approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['retention_bonus_right']==3)
	{
		$colName3="approver_3,approver_4";
	}
	else if($rule_dtls['retention_bonus_right']==4)
	{
		$colName3="approver_4";
	}				
	$checkApproverEsopRights=HLP_find_approver($rule_id,$manager_emailid,$colName);
	$checkApproverPayPerRights=HLP_find_approver($rule_id,$manager_emailid,$colName2);      
	$checkApproverBonusRecommandetionRights=HLP_find_approver($rule_id,$manager_emailid,$colName3);
}


$type_of_hike_can_edit_arr = explode(",", $rule_dtls["type_of_hike_can_edit"]);
				
//if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr) or $is_open_frm_hr_side == 1)
if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr))
{
	$readOnly='';
} 
else
{
	$readOnly='readonly'; 
} 


$promotion_col_name = CV_BA_NAME_GRADE;
$other_then_promotion_col_arr = array("new_designation", "new_level");				
if($rule_dtls['promotion_basis_on']==1)
{
	$promotion_col_name = CV_BA_NAME_DESIGNATION;
	$other_then_promotion_col_arr = array("new_grade", "new_level");	
}
elseif($rule_dtls['promotion_basis_on']==3)
{
	$promotion_col_name = CV_BA_NAME_LEVEL;
	$other_then_promotion_col_arr = array("new_designation", "new_grade");
}
if(!$is_open_frm_hr_side)
{
	$other_then_promotion_col_arr = array();
}  

$rsu_color_cls = "";
$rsu_enabled_for_domains_arr = explode(",", CV_RSU_ENABLED_FOR_DOMAINS_ARRAY);
if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr))
{
	$rsu_color_cls = "green_bg_RSU";
}

$i=0;
foreach($staff_list as $row)
{
	$emp_revised_final_roundup_sal = HLP_get_round_off_val($row["final_salary"], $rule_dtls["rounding_final_salary"]);
	$is_user_can_edit_salary_hikes = 0;//1=Yes(Can Modiffy the Hikes), 0=No(Can Not Modiffy the Hikes)
	if($is_open_frm_hr_side == 1)
	{
		if($is_hr_can_edit_hikes == 1)
		{
			$is_user_can_edit_salary_hikes = 1;
		}
	}
	else
	{
		if($this->session->userdata('is_manager_ses') == 1 and $is_open_frm_manager_side == 1)
		{
			$salary_n_rule_dtls = array(
									"rule_status"=>$rule_dtls["status"],
									"budget_accumulation"=>$rule_dtls["budget_accumulation"],
									"salary_hike_approval_status"=>$row["emp_salary_status"],
									"manager_emailid"=>$row["manager_emailid"],
									"approver_1"=>$row["first_approver"],
									"approver_2"=>$row["second_approver"],
									"approver_3"=>$row["third_approver"],
									"approver_4"=>$row["fourth_approver"]
									);
									
			$is_manager_can_edit_dtls=HLP_is_manager_can_edit_salary_hikes($salary_n_rule_dtls, $manager_emailid);
			if($is_manager_can_edit_dtls["is_access_to_edit"])
			{
				$is_user_can_edit_salary_hikes = 1;
			}
		}
	}
							
	$sp_per = $row["sp_manager_discretions"];
	$all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];					
	$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rule_dtls["Manager_discretionary_increase"]/100);							
	$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rule_dtls["Manager_discretionary_decrease"]/100);		
	$denominator = 0;					
	if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
	{
		//$current_position_pay_range = $row["pre_quartile_range_name"];
		$numerator = $row["increment_applied_on_salary"] - $row["min_salary_for_penetration"];
		$denominator = $row["max_salary_for_penetration"] - $row["min_salary_for_penetration"];
		$current_position_pay_range = HLP_get_range_penetration_for_salary($numerator, $denominator);									
	}
	else
	{
		$current_position_pay_range = '0.00%';
		if($row["market_salary"]>0)
		{
			$current_position_pay_range = HLP_get_formated_percentage_common(($row["increment_applied_on_salary"]/$row["market_salary"])*100).'%';
		}
		//$current_position_pay_range = HLP_get_formated_percentage_common($row["current_crr"]).'%';
	}
	$more = $more1="";
	$temp2 = json_decode($row['promotion_comment'], true);								
	if(json_last_error()=== JSON_ERROR_NONE)
	{
		for($j=count($temp2)-1; $j>=0; $j--)
		{
			if(!empty($temp2[$j]['permotion_per']))
			{
				$more1 .= $temp2[$j]['changed_by']." : ".HLP_get_formated_percentage_common($temp2[$j]['permotion_per']).'<br>';
			}
			if(!empty($temp2[$j]['increment_per']))
			{
				$more .= $temp2[$j]['changed_by']." : ".HLP_get_formated_percentage_common($temp2[$j]['increment_per']).'<br>';
			}									
		}							
	}
	
	$current_total_fixed_salary = $row["increment_applied_on_salary"]-$row["current_target_bonus"];								
	if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr))
	{					
		$revised_variable_salary = 0;				
		$new_total_fixed_salary = round(($emp_revised_final_roundup_sal*$row["other_data_11"]/100), CV_RSU_ROUND_OFF);
		$final_revised_ctc_salary = $new_total_fixed_salary;
		if($row["other_data_11"] != 100)
		{
			$revised_variable_salary = $emp_revised_final_roundup_sal - $new_total_fixed_salary;
			$final_revised_ctc_salary = $emp_revised_final_roundup_sal;
		}	
	}
	else
	{									
		$new_total_fixed_salary = $current_total_fixed_salary + ($current_total_fixed_salary*$row["manager_discretions"]/100);
		$revised_variable_salary = $row["current_target_bonus"] + ($row["current_target_bonus"]*$row["manager_discretions"]/100);
	}
	
	$merit_increase_amount = $row["increment_applied_on_salary"]*$row["final_merit_hike"]/100;
	$market_correction_amount = $row["increment_applied_on_salary"]*$row["final_market_hike"]/100;
	$salary_increment_amount = $row["increment_applied_on_salary"]*$row["manager_discretions"]/100;
	
	foreach($table_atrributes as $key)
	{
		if($key->attribute_name=='name')
		{
			/*$conditions = " rule_id='".$rule_id."' and letter_status >=1  AND user_id='".$row["id"]."' ";
			$letter_status = $this->rule_model->get_table_row("employee_salary_details", 'user_id,letter_path',$conditions);*/
			
			echo "<th><a target='_blank' href=".site_url("view-employee/".$row["id"]).">".$row["name"]."</a><a class='pull-left view_dash' title='See Analytics' href=".site_url($view_emp_increments_dtls_path."/".$rule_id."/".$row["id"])."><i class='fa fa-qrcode themeclr' aria-hidden='true'></i></a>";
			if($row["letter_status"] >= 1)
			{
				$url=base64_encode($rule_id.'/'.$row["id"]);
				echo "<br><a target='_blank' href=".site_url("employee/view-letter/".$url).">View Letter</a>";
			}
			echo "</th>";
		}
		else if($key->attribute_name=='employee_code')
		{
			echo "<th class='text-center'>".$row[$key->attribute_name]."</th>";
		}
		else if($key->attribute_name=='performance_rating')
		{
			echo "<td class='text-center'><div class='edit_recommd'><rating style='color:#FF6600; font-weight:bold;' class='spn_performance_rating'>".$row["performance_rating"]." &nbsp;";
			if($is_user_can_edit_salary_hikes)
			{	
				if(($is_open_frm_manager_side == 1 and $rule_dtls['manager_can_change_rating'] == 1) or $is_open_frm_hr_side == 1)
				{
					echo "<span class='fa fa-edit' onclick='show_performance_rating_spn(this);'></span>";
				}
			}
			echo "</rating>"; ?>
	
			<select class="form-control cls_ddl_performance_rating" style="display:none;" onchange="upd_emp_performance_rating_for_salary('<?php echo $row["id"]; ?>', '<?php echo $rule_id; ?>', this.value, '<?php echo $row['tbl_pk_id']; ?>');">
				<option value="0">Select</option>
				<?php if($performance_rating_list)
				{
					foreach ($performance_rating_list as $key => $rating)
					{ ?>
						<option value="<?php echo $rating['id']; ?>" <?php if($row['performance_rating'] == $rating['name']){ echo 'selected'; } ?> ><?php echo $rating['name']; ?></option>
					<?php 
					}
				} ?> 
			</select>           
			<?php 
			echo "</div></td>";
		}
		else if($key->attribute_name=='increment_applied_on_salary')
		{
			echo '<td class="txtalignright">'.HLP_get_formated_amount_common($row["increment_applied_on_salary"]).'</td>';
		}									
		else if($key->attribute_name=='current_target_bonus')
		{
			echo '<td class="txtalignright">'.HLP_get_formated_amount_common($row["current_target_bonus"]).'</td>';
		}
		else if($key->attribute_name=='current_position_pay_range')
		{
			echo "<td class='txtalignright'>".$current_position_pay_range."</td>";
		}
		else if($key->attribute_name=='position_pay_range_after_promotion')
		{
			if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
			{
				//echo "<td class='txtalignright'>".$row["quartile_range_name_after_promotion"]."%</td>";
				$numerator = ($row["increment_applied_on_salary"] + ($row["increment_applied_on_salary"]*($row["final_merit_hike"]+$row["sp_manager_discretions"])/100)) - $row["min_salary_for_penetration"];
				echo "<td class='txtalignright redish_bg'>".HLP_get_range_penetration_for_salary($numerator, $denominator)."</td>";
			}
			else
			{
				echo "<td class='txtalignright redish_bg'>".$row["crr_after_promotion"]."%</td>";
			}								
			
		}
		elseif($key->attribute_name=='merit_increase_amount')
		{			
			//if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr))))
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr))
			{				
				echo "<td class='txtalignright grey_bg'><div class='edit_recommd'><span class='salary_element_merit".$row['tbl_pk_id']."' >".HLP_get_formated_amount_common($merit_increase_amount)."</span><input class='form-control' onKeyUp='validate_onkeyup_num(this);' id='salary_increment_merit".$row['tbl_pk_id']."' maxlength=10 type='text' value=".round($merit_increase_amount)." style='display:none;' onblur='getper(\"merit\",this.value,".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).")'><span class='fa fa-edit salary_edit_merit".$row['tbl_pk_id']."' onclick='salary_edit(\"merit\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");'></span><span class='fa fa-close salary_close_merit".$row['tbl_pk_id']."' onclick='salary_close(\"merit\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");' style='display:none;'></span></div></td>";
			}
			else
			{
				echo "<td class='txtalignright grey_bg'>".HLP_get_formated_amount_common($merit_increase_amount)."</td>";									
			}
		}
		elseif($key->attribute_name=='merit_increase_percentage')
		{
			//if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr))))
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr))
			{
				echo "<td class='txtalignright grey_bg'><div class='edit_recommd'><span class='salary_element_merit".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["final_merit_hike"])."%</span><input class='form-control' onKeyUp='validate_percentage_onkeyup_common(this,3);' type='text' value=" . HLP_get_formated_percentage_common($row["final_merit_hike"])." id='salary_per_merit".$row['tbl_pk_id']."' style='display:none;' onblur='getamt(\"merit\",this.value,".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).")' /><input type='hidden' value=".$row["final_merit_hike"]." id='salary_per_hidden_merit".$row['tbl_pk_id']."' /><span class='fa fa-edit salary_edit_merit".$row['tbl_pk_id']."' onclick='salary_edit(\"merit\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");'></span><span class='fa fa-close salary_close_merit".$row['tbl_pk_id']."' onclick='salary_close(\"merit\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");' style='display:none;'></span></div></td>";
			}
			else
			{							
				echo "<td class='txtalignright grey_bg'><div class='edit_recommd'><span class='salary_increase".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["final_merit_hike"])."%</span></div></td>";
			}
		}
		elseif($key->attribute_name=='market_correction_amount')
		{
			//if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr))))
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr))
			{				
				echo "<td class='txtalignright blue_bg'><div class='edit_recommd'><span class='salary_element_market".$row['tbl_pk_id']."' >".HLP_get_formated_amount_common($market_correction_amount)."</span><input class='form-control' onKeyUp='validate_onkeyup_num(this);' id='salary_increment_market".$row['tbl_pk_id']."' maxlength=10 type='text' value=".round($market_correction_amount)." style='display:none;' onblur='getper(\"market\",this.value,".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).")'><span class='fa fa-edit salary_edit_market".$row['tbl_pk_id']."' onclick='salary_edit(\"market\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");'></span><span class='fa fa-close salary_close_market".$row['tbl_pk_id']."' onclick='salary_close(\"market\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");' style='display:none;'></span></div></td>";
			}
			else
			{
				echo "<td class='txtalignright blue_bg'>".HLP_get_formated_amount_common($market_correction_amount)."</td>";									
			}
		}
		elseif($key->attribute_name=='market_correction_percentage')
		{
			//if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr))))
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr))
			{
				echo "<td class='txtalignright blue_bg'><div class='edit_recommd'><span class='salary_element_market".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["final_market_hike"])."%</span>
				<input class='form-control' onKeyUp='validate_percentage_onkeyup_common(this,3);' type='text' value=" . HLP_get_formated_percentage_common($row["final_market_hike"])." id='salary_per_market".$row['tbl_pk_id']."' style='display:none;' onblur='getamt(\"market\",this.value,".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).")' /><input type='hidden' value=".$row["final_market_hike"]." id='salary_per_hidden_market".$row['tbl_pk_id']."' /><span class='fa fa-edit salary_edit_market".$row['tbl_pk_id']."' onclick='salary_edit(\"market\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");'></span><span class='fa fa-close salary_close_market".$row['tbl_pk_id']."' onclick='salary_close(\"market\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");' style='display:none;'></span></div></td>";
			}
			else
			{							
				echo "<td class='txtalignright blue_bg'><div class='edit_recommd'><span class='salary_increase".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["final_market_hike"])."%</span></div></td>";
			}
		}
		else if($key->attribute_name=='salary_increment_amount')
		{
			//if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr))))
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr))
			{				
				echo "<td class='txtalignright'><div class='edit_recommd'><span class='salary_element_total".$row['tbl_pk_id']."' >".HLP_get_formated_amount_common($salary_increment_amount)."</span><input class='form-control' onKeyUp='validate_onkeyup_num(this);' id='salary_increment_total".$row['tbl_pk_id']."' maxlength=10 type='text' value=".round($salary_increment_amount)." style='display:none;' onblur='getper(\"total\",this.value,".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).")'><span class='fa fa-edit salary_edit_total".$row['tbl_pk_id']."' onclick='salary_edit(\"total\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");'></span><span class='fa fa-close salary_close_total".$row['tbl_pk_id']."' onclick='salary_close(\"total\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");' style='display:none;'></span></div></td>";
			}
			else
			{
				echo "<td class='txtalignright pramod'><span class='font_sz14'><b>".HLP_get_formated_amount_common($salary_increment_amount)."</b></span></td>";									
			}
		}
		else if($key->attribute_name=='manager_discretions')
		{
			//if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr))))
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr))
			{
				echo "<td class='txtalignright' style='position:relative;'><div class='edit_recommd'><span class='salary_element_total".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["manager_discretions"])."%</span><input class='form-control' onKeyUp='validate_percentage_onkeyup_common(this,3);' type='text' value=".HLP_get_formated_percentage_common($row["manager_discretions"])." id='salary_per_total".$row['tbl_pk_id']."' style='display:none;' onblur='getamt(\"total\",this.value,".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).")'><input type='hidden' value=".$row["manager_discretions"]." id='salary_per_hidden_total".$row['tbl_pk_id']."' /><span class='fa fa-edit salary_edit_total".$row['tbl_pk_id']."' onclick='salary_edit(\"total\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");'></span><span class='fa fa-close salary_close_total".$row['tbl_pk_id']."' onclick='salary_close(\"total\",".$row['tbl_pk_id'].",".($row["increment_applied_on_salary"]).");' style='display:none;'></span><br><span class='original_recomd'><em data-toggle='tooltip' title='Original salary increase as per rules'>"."(".HLP_get_formated_percentage_common($all_hikes_total)."%)</em></span></div></td>";
			}
			else
			{							
				echo "<td class='txtalignright' style='position:relative;'><div class='edit_recommd'><span class='salary_increase".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["manager_discretions"])."%</span><br><span class='original_recomd'><em data-toggle='tooltip' title='Original salary increase as per rules'>"."(".HLP_get_formated_percentage_common($all_hikes_total)."%)</em></span></div></td>";
			}
		}
		else if($key->attribute_name=='salary_increase_range')
		{
			if($rule_dtls["Manager_discretionary_increase"] > 0 or $rule_dtls["Manager_discretionary_decrease"] )
			{
				echo "<td class='txtalignright'>".HLP_get_formated_percentage_common($manager_max_dec_per)." - ".HLP_get_formated_percentage_common($manager_max_incr_per)."%</td>";
			}
			else
			{
				echo '<td></td>';
			}
		}
		else if($key->attribute_name=='salary_comment')
		{
			echo "<td class=''>".$more."</td>";
		}
		else if($key->attribute_name=='promotion_recommandetion')
		{ ?> 
			<td class="redish_bg">
				<div class="beg_color">
					<label style="color:#000 !important; margin-bottom: 0px !important;">
						<?php $is_chk_check = ""; $is_chk_editable = 'disabled';
						if($row['emp_new_'.$promotion_col_name]>0){ $is_chk_check = "checked";}
						if($is_user_can_edit_salary_hikes){$is_chk_editable = "";}
						if($is_chk_check == "checked"){$is_chk_editable = 'disabled';}
						 ?>
						
						<input type="checkbox" id="chk_dfault_promotion<?php echo $row['tbl_pk_id']; ?>" style="opacity:1; margin-top:1px;" <?php echo $is_chk_check; ?> <?php echo $is_chk_editable; ?> <?php if($is_chk_check == ""){?>onclick="promotion_edit('<?php echo $row['tbl_pk_id']; ?>', '<?php echo $row["standard_promotion_increase"]; ?>', '<?php echo $rule_dtls['manager_can_exceed_budget']; ?>', '<?php echo $is_user_can_edit_salary_hikes; ?>');" <?php } ?>>
						<span></span>
					</label>
					<div class="edit_recommd promo_recommd">
						<?php if($is_user_can_edit_salary_hikes){ ?>
							<span class="fa fa-edit promotion_edit<?php echo $row['tbl_pk_id']; ?>" style=" <?php if($is_chk_check != "checked"){ echo "display:none;"; } ?> " onclick="promotion_edit('<?php echo $row['tbl_pk_id']; ?>','<?php echo $row["standard_promotion_increase"]; ?>','<?php echo $rule_dtls['manager_can_exceed_budget']; ?>');"></span>
							<?php  if($is_chk_check == "checked"){ ?>
								<span class="fa fa-minus promotio_del<?php echo $row['tbl_pk_id']; ?>" onclick="deletepromotion('<?php echo $row['tbl_pk_id']; ?>');" style="display:none;"></span>
							<?php } ?>
							<span class="fa fa-close promotion_close<?php echo $row['tbl_pk_id']; ?>" onclick="promotion_close('<?php echo $row['tbl_pk_id']; ?>','<?php echo $row["standard_promotion_increase"]; ?>' ,'<?php echo $rule_dtls['manager_can_exceed_budget']; ?>', <?php if($is_chk_check != "checked"){ echo "1"; }else{ echo "0"; } ?>);" style="display:none;"></span>
						<?php } ?>
					</div>
				</div>
			</td>
		<?php
		}
		else if($key->attribute_name=='sp_increased_salary')
		{ ?>								
			<td class="txtalignright redish_bg">
				<div class="edit_recommd">
					<span class="promotion_element<?php echo $row['tbl_pk_id']; ?>" >
						<?php echo HLP_get_formated_amount_common($row["sp_increased_salary"]); ?>
					</span>												
					<input class="form-control" onKeyUp="validate_onkeyup_num(this);" id="promotion_increment<?php echo $row['tbl_pk_id']; ?>" maxlength="10" type="text" value="<?php echo round($row["sp_increased_salary"]); ?>" style="display:none;" onblur="getperr(this.value,'<?php echo $row['tbl_pk_id']; ?>','<?php echo round($row["increment_applied_on_salary"]); ?>')" <?=$readOnly?>>
					<input id="hf_promotion_increment<?php echo $row['tbl_pk_id']; ?>" maxlength="10" type="hidden" value="<?php echo ($row["sp_increased_salary"]); ?>">
				</div>
			</td>								
		<?php 
		} 
		else if($key->attribute_name=='sp_manager_discretions')
		{  ?>
			<td class="txtalignright redish_bg">
				<div class="edit_recommd">
					<span class="promotion_element<?php echo $row['tbl_pk_id']; ?>" >
						<?php echo HLP_get_formated_percentage_common($sp_per); ?>%
					</span>
					<input class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,3);" id="promotion_per<?php echo $row['tbl_pk_id']; ?>" type="text" value="<?php if($row['emp_new_'.$promotion_col_name]>0){ echo HLP_get_formated_percentage_common($sp_per);}else{ echo HLP_get_formated_percentage_common($row['standard_promotion_increase']); } ?>" style="display: none;" onblur="getamtt(this.value,'<?php echo $row['tbl_pk_id']; ?>','<?php echo round($row["increment_applied_on_salary"]); ?>')" <?=$readOnly?>>
					<input id="promotion_per_hidden<?php echo $row['tbl_pk_id']; ?>" type="hidden" value="<?php if($row['emp_new_'.$promotion_col_name]>0){ echo HLP_get_formated_percentage_common($sp_per);} else { echo HLP_get_formated_percentage_common($row['standard_promotion_increase']); }  ?>" style="display: none;" onblur="getamtt(this.value,'<?php echo $row['tbl_pk_id']; ?>','<?php echo round($row["increment_applied_on_salary"]); ?>')">
				</div>
			</td>
		<?php
		}
		else if($key->attribute_name=="new_".$promotion_col_name)
		{ ?>								
			<td class="redish_bg">
				<select class="form-control cls_emp_<?php echo $key->attribute_name.$row['tbl_pk_id']; ?>" <?php if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or $rule_dtls["promotion_can_edit"]==1)){ ?> id="ddl_emp_new_designation_<?php echo $row['tbl_pk_id']; ?>" <?php } ?> style="display:none;">
					<option value="">Select <?php echo $level_name; ?></option>
					<?php $display_name1 = "";
					if($promotion_basic_list)
					{
						foreach ($promotion_basic_list as $promotion_value)
						{ ?>
							<option <?php if($row['emp_new_'.$promotion_col_name]==$promotion_value['id']){ echo 'selected'; $display_name1 = $promotion_value['name']; } ?> value="<?php echo $promotion_value['id']; ?>"><?php echo $promotion_value['name']; ?></option>
						<?php
						}
					} ?>      
				</select>										
				<span <?php //if($is_open_frm_hr_side){ ?> class="promotion_element<?php echo $row['tbl_pk_id']; ?>" <?php //} ?> ><b><?php echo $display_name1; ?></b></span>
			</td>								
		<?php
		}
		else if(in_array($key->attribute_name, $other_then_promotion_col_arr))
		{
			$display_name2 =""; ?>								
			<td class="redish_bg">										
				<select class="form-control cls_emp_<?php echo $key->attribute_name.$row['tbl_pk_id']; ?>" <?php if($is_user_can_edit_salary_hikes){ ?> id="ddl_emp_<?php echo $key->attribute_name.$row['tbl_pk_id']; ?>" onchange="update_emp_promotion_basis_on('<?php echo "emp_".$key->attribute_name; ?>', <?php echo $row['tbl_pk_id']; ?>);" <?php }else{echo 'style="display:none;"';} ?>>
					<option value="">Select <?php echo $key->display_name; ?></option>
					<?php 
					if(${"list_of_".$key->attribute_name})
					{													
						foreach (${"list_of_".$key->attribute_name} as $othr_row)
						{ ?>
							<option <?php if($row['emp_'.$key->attribute_name]==$othr_row['id']){ echo 'selected'; $display_name2 = $othr_row['name']; } ?> value="<?php echo $othr_row['id'] ?>"><?php echo $othr_row['name']; ?></option>
						<?php
						}
					} ?>      
				</select>	
				<?php if(!$is_user_can_edit_salary_hikes){echo $display_name2;} ?>									
			</td>								
		<?php
		}
										
		else if($key->attribute_name=='promotion_comment')
		{ ?>
			<td class='redish_bg'><b><?=$more1?></b></td>
		<?php
		}
		else if($key->attribute_name=='final_total_increment_amount')
		{ ?>
			<td class="txtalignright">
				<?php echo HLP_get_formated_amount_common($emp_revised_final_roundup_sal-$row["increment_applied_on_salary"]) ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='final_total_increment_percent')
		{ ?>
			<td class='txtalignright <?=($all_hikes_total < $row["manager_discretions"])? 'redColor':'' ?>'>
				<?php echo HLP_get_formated_percentage_common((float)$row["manager_discretions"]); ?>%
			</td>
		<?php }
		else if($key->attribute_name=='final_salary')
		{?>
			<td class="txtalignright">
				<?php if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr))
					{
						echo HLP_get_formated_amount_common($final_revised_ctc_salary);
					}
					else
					{
						echo HLP_get_formated_amount_common($emp_revised_final_roundup_sal);
					} ?>
			</td>
		<?php } 
		else if($key->attribute_name=='current_total_fixed_salary')
		{
			echo '<td class="txtalignright">'.HLP_get_formated_amount_common($current_total_fixed_salary).'</td>';
		} 
		else if($key->attribute_name=='new_total_fixed_salary')
		{
			echo '<td class="txtalignright">'.HLP_get_formated_amount_common($new_total_fixed_salary).' </td>';
		} 
		else if($key->attribute_name=='revised_variable_salary')
		{ ?>								
			<td class="txtalignright">
				<?php echo HLP_get_formated_amount_common($revised_variable_salary); ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='market_salary')
		{ ?>								
			<td class="txtalignright">
				<?php echo HLP_get_formated_amount_common($row["market_salary"]); ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='market_salary_after_promotion')
		{ ?>								
			<td class="txtalignright">
				<?php echo HLP_get_formated_amount_common($row["mkt_salary_after_promotion"]); ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='current_monthly_salary_being_reviewed')
		{ ?>								
			<td class="txtalignright">
				<?php echo HLP_get_formated_amount_common($row["increment_applied_on_salary"]/12); ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='final_new_monthly_salary')
		{ ?>								
			<td class="txtalignright">
				<?php echo HLP_get_formated_amount_common($emp_revised_final_roundup_sal/12); ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='new_positioning_in_pay_range')
		{ ?>
			<td class="txtalignright">
				<?php if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{
				  //echo $row["post_quartile_range_name"];
					$numerator = $emp_revised_final_roundup_sal - $row["min_salary_for_penetration"];
					echo HLP_get_range_penetration_for_salary($numerator, $denominator);
				}
				else
				{
					if($row["mkt_salary_after_promotion"]>0)
					{
						echo HLP_get_formated_percentage_common(($emp_revised_final_roundup_sal/$row["mkt_salary_after_promotion"])*100); 
					}
					else
					{
						echo '0.00';
					}
						echo "%";
				} ?>  
			</td>
		<?php
		}
		else if($key->attribute_name=='tenure_in_company')
		{ ?>								
			<td class="txtalignright">
				<?php if($rule_dtls["effective_dt"] != "0000-00-00" and $row["joining_date_the_company"] != "0000-00-00"){ echo "<b>".round((strtotime($rule_dtls["effective_dt"]) - strtotime($row["joining_date_the_company"])) / 31536000, 1)." Year</b>";}else{"0 Year";} ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='tenure_in_role')
		{ ?>								
			<td class="txtalignright">
				<?php if($rule_dtls["effective_dt"] != "0000-00-00" and $row["promoted_in_2_yrs"] != "0000-00-00"){ echo "<b>".round((strtotime($rule_dtls["effective_dt"]) - strtotime($row["promoted_in_2_yrs"])) / 31536000, 1)." Year</b>";}else{echo "0 Year";} ?>
			</td>								
		<?php
		}
		else if($key->attribute_name=='comments')
		{ ?>								
			<td class="txtalignright">
				<div class="edit_recommd">
					<span class="fa fa-edit" onclick="show_comments_dv('<?php echo $row['tbl_pk_id']; ?>', <?php echo $is_user_can_edit_salary_hikes; ?>);"></span>
				</div>
				<input id="hf_comment_dtls_<?php echo $row['tbl_pk_id']; ?>" type="hidden" value='<?php echo $row['comments']; ?>'>
			</td>								
		<?php
		}
		else if($key->attribute_name=='other_data_9' or $key->attribute_name=='other_data_10' or $key->attribute_name=='other_data_11')
		{ 
			echo "<td class='".$rsu_color_cls."'>".$row[$key->attribute_name]."</td>";
		}
		else
		{
			echo "<td class='text-center'>".$row[$key->attribute_name]."</td>";
		}
	} ?>
	
	<!-- Note :: Start :: RSU Section For Fresh Work Only -->
	<?php if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr)){?>
		<td class="txtalignright green_bg_RSU">
			<?php echo HLP_get_formated_amount_common($new_total_fixed_salary*$row["other_data_10"]); ?>
		</td>
	<?php } ?>
	<!-- Note :: End: RSU Section For Fresh Work Only -->

	<?php
	if($rule_dtls['esop_title']!="" && !empty($checkApproverEsopRights))
	{ ?>
		<td class="txtalignright <?php echo $rsu_color_cls; ?>">
			<div class="edit_recommd">
				<span class="additional_fields_element<?php echo $row['tbl_pk_id']; ?> additional_fields_esop<?php echo $row['tbl_pk_id']; ?>" >
					<?php if($row["esop"]){ echo $row["esop"];}else{echo 0;} ?>
				</span>
				<input class="form-control additional_fields<?php echo $row['tbl_pk_id']; ?>" type="text" placeholder="<?php echo $rule_dtls["esop_title"]; ?>" name="txt_esop" id="txt_esop<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $row["esop"]; ?>" <?php if($rule_dtls["esop_type"] == 3){?> onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" maxlength="10" <?php }elseif($rule_dtls["esop_type"] == 1){?> onKeyUp="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" maxlength="10" <?php }else{ ?> maxlength="200" <?php } ?> style="display:none;"/>
										
				<?php if($is_user_can_edit_salary_hikes){?>
					<span class="fa fa-edit additional_fields_edit<?php echo $row['tbl_pk_id']; ?>" onclick='additional_fields_edit("<?php echo $row['tbl_pk_id']; ?>");'></span>
					<span class="fa fa-close additional_fields_close<?php echo $row['tbl_pk_id'] ?>" onclick='additional_fields_close("<?php echo $row['tbl_pk_id']; ?>");' style="display:none;"></span>
				<?php } ?>
			</div>
		</td>
	<?php } ?>
	
	<!-- Note :: Start :: RSU Section For Fresh Work Only -->
	<?php if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr)){?>		
		<td class="txtalignright green_bg_RSU" id="td_emp_new_total_fixed_salary_<?php echo $row['tbl_pk_id']; ?>">
			<?php $final_rsu_amt = $new_total_fixed_salary*$row["esop"];
				echo HLP_get_formated_amount_common($final_rsu_amt); ?>
		</td>
		<td class="txtalignright green_bg_RSU">
			<spn id="spn_emp_new_total_fixed_salary_<?php echo $row['tbl_pk_id']; ?>">
				<?php $rsu_division_val = CV_RSU_DIVISION_VALUE*$currency_rate_dtls[strtoupper($row["currency"])];
				$emp_final_rsu = 0;
				if($rsu_division_val>0)
				{										
					$emp_final_rsu = $final_rsu_amt/$rsu_division_val;
				}
				echo HLP_get_formated_amount_common($emp_final_rsu); ?>
			</spn>
			<input type="hidden" id="hf_emp_new_total_fixed_salary_<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $new_total_fixed_salary; ?>"/>
			<input type="hidden" id="hf_emp_rsu_division_val_<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $rsu_division_val; ?>"/>
		</td>
	<?php } ?>
	<!-- Note :: End: RSU Section For Fresh Work Only -->
	
	<?php if($rule_dtls['pay_per_title']!="" && !empty($checkApproverPayPerRights))
	{?>
		<td class="txtalignright">
			<div class="edit_recommd">
				<span class="additional_fields_element<?php echo $row['tbl_pk_id']; ?> additional_fields_pay_per<?php echo $row['tbl_pk_id']; ?>" >
					<?php if($row["pay_per"]){ echo $row["pay_per"];}else{echo 0;}
		?>
				</span>
				<input class="form-control additional_fields<?php echo $row['tbl_pk_id']; ?>" type="text" placeholder="<?php echo $rule_dtls["pay_per_title"]; ?>" name="txt_pay_per" id="txt_pay_per<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $row["pay_per"]; ?>" <?php if($rule_dtls["pay_per_type"] == 3){?> onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" maxlength="10" <?php }elseif($rule_dtls["pay_per_type"] == 1){?> onKeyUp="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" maxlength="10" <?php }else{ ?> maxlength="200" <?php } ?> style="display:none;"/>
				<?php if($is_user_can_edit_salary_hikes){?>
					<span class="fa fa-edit additional_fields_edit<?php echo $row['tbl_pk_id']; ?>" onclick='additional_fields_edit("<?php echo $row['tbl_pk_id']; ?>");'></span>
					<span class="fa fa-close additional_fields_close<?php echo $row['tbl_pk_id'] ?>" onclick='additional_fields_close("<?php echo $row['tbl_pk_id']; ?>");' style="display:none;"></span>
				<?php } ?>
			</div>								
		</td>
	<?php
	}
	if($rule_dtls['retention_bonus_title']!="" && !empty($checkApproverBonusRecommandetionRights))
	{?> 
		<td class="txtalignright">
			<div class="edit_recommd">
				<span class="additional_fields_element<?php echo $row['tbl_pk_id']; ?> additional_fields_retention_bonus<?php echo $row['tbl_pk_id']; ?>" >
					<?php if($row["retention_bonus"])
					{
						echo $row["retention_bonus"];
					}
					else
					{
						echo 0;
					} ?>
				</span>
				<input class="form-control additional_fields<?php echo $row['tbl_pk_id']; ?>" type="text" placeholder="<?php echo $rule_dtls["retention_bonus_title"]; ?>" name="txt_retention_bonus" id="txt_retention_bonus<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $row["retention_bonus"]; ?>" <?php if($rule_dtls["retention_bonus_type"] == 3){?> onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" maxlength="10" <?php }elseif($rule_dtls["retention_bonus_type"] == 1){?> onKeyUp="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" maxlength="10" <?php }else{ ?> maxlength="200" <?php } ?> style="display:none;"/>
				
				<?php if($is_user_can_edit_salary_hikes){?>
					<span class="fa fa-edit additional_fields_edit<?php echo $row['tbl_pk_id']; ?>" onclick='add3_edit("<?php echo $row['tbl_pk_id']; ?>");'></span>
					<span class="fa fa-close additional_fields_close<?php echo $row['tbl_pk_id'] ?>" onclick='additional_fields_close("<?php echo $row['tbl_pk_id']; ?>");' style="display:none;"></span>
				<?php } ?>
			</div>
		</td>
	<?php
	} 
	
	?>
	<input type="hidden" id="hf_increment_applied_on_salary<?php echo $row['tbl_pk_id']; ?>" value="<?php echo ($row["increment_applied_on_salary"]); ?>" />
	<input type="hidden" value="<?php echo $row["id"]; ?>" id="hf_emp_id_<?php echo $row['tbl_pk_id']; ?>" />	
	<input id="hf_promotion_increment<?php echo $row['tbl_pk_id']; ?>" type="hidden" value="<?php echo $row["sp_increased_salary"]; ?>">
	<input id="hf_merit_hike_amt_<?php echo $row['tbl_pk_id']; ?>" type="hidden" value="<?php echo $merit_increase_amount; ?>">
	<input id="hf_market_hike_amt_<?php echo $row['tbl_pk_id']; ?>" type="hidden" value="<?php echo $market_correction_amount; ?>">
	<input id="hf_total_hike_amt_<?php echo $row['tbl_pk_id']; ?>" type="hidden" value="<?php echo $salary_increment_amount; ?>">
	<?php 
	$i++;
} ?>

<style type="text/css">
.table-scroll thead.emp_list_head tr:nth-child(1) th{border-bottom: 0px !important;}
.table-scroll thead.emp_list_head tr:nth-child(2) th{border-top: 0px !important; padding: 0px !important; padding-bottom: 0px !important;}	
.table-scroll thead.emp_list_head tr:nth-child(2) th input{border: 0px !important;}	
.table-scroll{max-height: 62vh !important;}
</style>