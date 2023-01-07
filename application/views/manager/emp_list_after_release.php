
           
<div class="panel-body" style="    border: solid #ddd 1px;">
            <div class="form-horizontal ">                
                <div id="dv_partial_page_data" style="overflow-x: auto;">
                <?php $is_enable_approve_btn=0;
                      $tbl_ids_arr = array();
					   $manager_emailid = strtolower($this->session->userdata('email_ses'));
					 if($staff_list){ $tbl_cnt = 0; ?>
                        <div class="col-md-12 panel-heading panelpp" style="background: #f1f1f1; <?php if(empty($staff_list)){echo "display:none;";} ?> ">
          <b style="font-size: 11px;">
          <?php
                if($rule_dtls['promotion_can_edit']==2)
                {
                $readOnly='readonly';$hide='hide';
                } 
                else {
                $readOnly=''; $hide='';
                }
                $all_managers_in_a_rule_arr = $managers_downline_arr = array();
                $manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, $manager_emailid);
                 // $managers_arr = json_decode($staff_list[0]['manual_budget_dtls'],true);
                  $managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
                  foreach($managers_arr as $key => $value)
                  {
                    $all_managers_in_a_rule_arr[] = strtolower($value[0]);
                    if(strtolower($staff_list[0]["last_action_by"]) == strtolower($value[0]))
                    {
                      $managers_downline_arr = $manager_total_bdgt_dtls["managers_downline_arr"];

                      echo "</b><span class='budget_list'> Total Budget <a href='JavaScript:Void(0);' data-placement='bottom' data-toggle='tooltip' data-original-title='This is the total budget allocated to your teams below your hierarchy, including your direct reports.'><i style='font-size: 11px;' class='fa fa-info-circle themeclr'></i></a> : " .$rule_dtls['rule_currency_name']." ". HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"]).'</span>';
                      echo  "<span class='budget_list'> Available budget <a href='JavaScript:Void(0);' data-placement='bottom' data-toggle='tooltip' data-original-title='This is the budget left in your budget pool that can be allocated to any of your team members, if you have been given
                      that right to do so.'><i style='font-size: 11px;' class='fa fa-info-circle themeclr'></i> </a> : ".$rule_dtls['rule_currency_name']." ".HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"]).'</span>';

                      echo  "<span class='budget_list'>My Direct Reports Budget : <a href='JavaScript:Void(0);' data-placement='bottom' data-toggle='tooltip' data-original-title='This is the budget allocated to your direct reports only.'><i style='font-size: 11px;' class='fa fa-info-circle themeclr'></i></a> ".$rule_dtls['rule_currency_name']." ".HLP_get_formated_amount_common($value[1] + (($value[1]*$value[2])/100)).'</span>';
                     // break;
                    }
                  }

                  ?>
                </b>
         </div>
                	

             <div class="table-scroll notheight" style=" <?php if(empty($staff_list)){echo "display:none;";} ?> ">
          <table id="mytable_<?=$newId?>" class="table border myTable">

            <thead class="emp_list_head">
            <tr>
               
             <?php  

              ##################### Dynamic Header Goes Here ###################

                foreach ($table_atrributes as $row) { ?>
                                  <?php


                            if($row->attribute_name=='manager_discretions')
                            { 

                            echo '<th style="width:6.9%;">'.$row->display_name.'<a href="JavaScript:Void(0);" data-placement="bottom" data-toggle=tooltip data-original-title="The salary recommendationnnnn reflected here is based on the rules setup for this compensation review plan by HR. However, you may have rights and scope to review the budget of your team members within certain limits. Please check the “Available budget” on the top right hand side of this screen and click the edit button if you like to modify any salary recommendations"><i class="fa fa-info-circle themeclr"></i></a><br><span class="original_recomd">'.'Original Recommendation</span></th>'; 
                            }

                            else if($row->attribute_name=='promotion_recommandetion') 
                            {
                              echo '<th>Promotion<br>Recommendation</th>';
                            }

                                  else if($row->attribute_name=='sp_increased_salary')
                                  {
                                    
                                    echo '<th>Promotion Increase amount<a href="JavaScript:Void(0);" data-placement="bottom" data-toggle="tooltip" data-original-title="All promotion recommendations are subject to approval of the management. Please provide a valid reason for recommending promotion in your team to support your case."><i class="fa fa-info-circle themeclr"></i></a></th>';
                                  }

                                   else if($row->attribute_name=='new_designation')
                                  {
                                    echo '<th>'.$row->display_name.'</th>';
                                   
                                  }
                                  else if($row->attribute_name=='new_grade')
                                  {
                                    echo '<th>'.$row->display_name.'</th>';
                                   
                                  }
                                  else if($row->attribute_name=='new_level')
                                  {
                                    echo '<th>'.$row->display_name.'</th>';
                                    
                                  }
                                 

                                  else
                                  {
                                    
                                    if($row->attribute_name!='new_designation' && $row->attribute_name!='new_grade' && $row->attribute_name!='new_level')
                                    {

                                    echo '<th>'.$row->display_name.'</th>';
                                    }
                                   
                                  }
                                 
                                   ?>
                          <?php } ?>
                         
                      <?php if($rule_dtls['esop_title']!="" && !empty($checkApproverEsopRights)) {?>
                         <th><?php echo $rule_dtls['esop_title'] ?></th>
                       <?php } if($rule_dtls['pay_per_title']!="" && !empty($checkApproverPayPerRights)) {?>
                         <th><?php echo $rule_dtls['pay_per_title'] ?></th>
                          <?php } if($rule_dtls['retention_bonus_title']!="" && !empty($checkApproverBonusRecommandetionRights)) {?> 
                         <th><?php echo $rule_dtls['retention_bonus_title'] ?></th>
                       <?php 
                     }

##################### Dynamic Header End Here ###################

    ?>
</tr>
</thead>
<tbody id="tbl_body">                   
  <?php $i=0; $is_enable_approve_btn=1;

  $rule_id = $rule_dtls['id'];//$staff_list[0]["rule_id"];
  $prev_record_manager_email = "";
  $pk_ids = array();
  /*$esop_right = 0;
  $pay_per_right = 0;
  $retention_bonus_right = 0;*/
  foreach($staff_list as $row)
  {
    if($row["emp_salary_status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
    {
      $is_enable_approve_btn=0;
    }           

    if($prev_record_manager_email != "" and strtolower($row["last_action_by"]) != $prev_record_manager_email)
    {
      $tbl_cnt++;
      if(strtolower($staff_list[$i-1]["manager_emailid"]) == $manager_emailid and count($pk_ids)>0)
        {?>
          <tr><td colspan='<?=$colspanCount?>' style='text-align:right'>

            <form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_increment"); ?>" method="post" class="form-inline">
              <?php echo HLP_get_crsf_field();?>
              <input type="button" id="btn_reject_<?php echo $i; ?>" onclick="show_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Reject"/>

              <div class="row" id="dv_remark_<?php echo $i; ?>" style="display: none;">
                <div class="col-sm-12">                             
                  <div class="form-input">
                    <input type="hidden" name="emp_sal_tbl_pk_ids" value="<?php echo implode(",",$pk_ids); ?>" />
                    <textarea class="form-control" rows="6" name="txt_remark" placeholder="Eneter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px; height: 70px;width:100%;"></textarea>
                  </div>                                      
                </div>                                                 
                <div class="col-sm-8 col-sm-offset-3">                        
                  <div class="submit-btn">
                    <input type="submit" class="btn btn-twitter m-b-sm add-btn" value="Submit"/>
                  </div>
                </div>
                <div class="col-sm-1">
                  <div class="submit-btn">
                    <input type="button" onclick="hide_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Cancel" />
                  </div>
                </div>                   
              </div>
            </form>

          </td></tr>  
          <?php $pk_ids = array();
          $tbl_ids_arr[] = $tbl_cnt-1;            
        } ?>


        <tr><th>
          <b>
            <?php if(strtolower($row["last_action_by"]) == $manager_emailid)
            { echo "My Direct Reports ".$manager_emailid; }
            else {
              if($row["last_manager_name"])
              {
                echo "Direct Reports Of  ".$row["last_manager_name"];
              }
              else
              {
                echo "Direct Reports Of ".$row["last_action_by"];
              }
            }
            ?>
          </b></th> 
          <td colspan='<?=$colspanCount?>'><b>
            <?php 
            $managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
            foreach($managers_arr as $key => $value)
            {
              if(strtolower($row["last_action_by"]) == strtolower($value[0]))
              {

$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($value[0]));
echo "</b><span class='budget_list'> Total Budget : " .$rule_dtls['rule_currency_name']." ". HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"]).'</span>';
echo  " <span class='budget_list'>Available budget : ".$rule_dtls['rule_currency_name']." ".HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"]). ")".'</span>';
break;
}
}

?>
</b>
</td>
</tr>



<?php }             

if(strtolower($row["manager_emailid"]) == $manager_emailid and $row["emp_salary_status"] > 1 and $row["emp_salary_status"] < 5)
{
  $pk_ids[] = $row["tbl_pk_id"];
}

if($tbl_cnt<=0)
{
  echo "<tr>";
}
else
{
  echo "<tr class='tr_class_".$rule_id."_".$tbl_cnt."'>";
}


/*$approve_arr = get_approved_right ($row["tbl_pk_id"]);


foreach ($approve_arr[0] as $key => $value) {
  if(strtolower($value) == strtolower($this->session->userdata('username_ses'))){
    $ex_approve = explode( 'approver_',$key);
    if($row['esop_right'] == $ex_approve[1]){
      $esop_right = 1;
    }
    if($row['pay_per_right'] == $ex_approve[1]){
      $pay_per_right = 1;
    }
    if($row['retention_bonus_right'] == $ex_approve[1]){
      $retention_bonus_right = 1;
    }

  }
}*/
############# Edited By Kingjuliean ############################

$is_manager_can_edit_salary_hikes = 0;//1=Yes(Can Modiffy the Hikes), 0=No(Can Not Modiffy the Hikes)
if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side) and $is_open_frm_manager_side == 1)
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
  $is_manager_can_edit_dtls = HLP_is_manager_can_edit_salary_hikes($salary_n_rule_dtls, $this->session->userdata('email_ses'));
  if($is_manager_can_edit_dtls["is_access_to_edit"])
  {
    $is_manager_can_edit_salary_hikes = 1;
  }
}

// $sp_per=$row["standard_promotion_increase"];
// if($row["emp_new_designation"] != "")
// {

//$sp_per=$row["standard_promotion_increase"];
// if($row["emp_new_designation"] != "")
// {
//   $sp_per=$row["sp_manager_discretions"];
// }

  $sp_per=$row["sp_manager_discretions"];


$all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];

// $all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];

$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rule_dtls["Manager_discretionary_increase"]/100);

$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rule_dtls["Manager_discretionary_decrease"]/100);

if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
{
  $current_position_pay_range = $row["post_quartile_range_name"];
}
else
{
  if($row["market_salary"]){ $current_position_pay_range = HLP_get_formated_percentage_common(($row["increment_applied_on_salary"]/$row["market_salary"])*100).'%'; }else{$current_position_pay_range = 0 .'%';}
  //$current_position_pay_range = HLP_get_formated_percentage_common($row["current_crr"]).'%';
}

$more=$more1="";
              $temp2=json_decode($row['promotion_comment'],ture);

              if(json_last_error()=== JSON_ERROR_NONE)
                {
                  for($i=count($temp2)-1;$i>=0;$i--)
                  {
                    if(!empty($temp2[$i]['permotion_per']))
                    {
                      $more1.=$temp2[$i]['changed_by']." : ".HLP_get_formated_percentage_common($temp2[$i]['permotion_per']).'<br>';
                    }
                    if(!empty($temp2[$i]['increment_per']))
                    {
                      $more.=$temp2[$i]['changed_by']." : ".HLP_get_formated_percentage_common($temp2[$i]['increment_per']).'<br>';
                    }
                    
                  }
                  
                }


#########################################################################

######################### Dynamic Column Kingjuliean ################################
//print_r($table_atrributes);
//die();
foreach ($table_atrributes as $key) {

    if($key->attribute_name=='name')
      {
      echo "<th>".$row["name"]."<br><a href=".site_url("manager/view-employee-increments/".$rule_id."/".$row["id"]).">View Dashboard</a> <br> <a href='".base_url('employee/view-letter/'.$row['rule_id'].'/'.$row['id'])."'>View Letter</a> </th>";
      }
      else if($key->attribute_name=='employee_code')
      {
      echo "<th class='text-center'>".$row[$key->attribute_name]."</th>";
      }
      else if($key->attribute_name=='performance_rating')
      {
          echo "<td class='txtalignright'> <div class='edit_recommd'><rating style='color:#FF6600; font-weight:bold; font-size:14px;' class='spn_performance_rating'>".$row["performance_rating"]." &nbsp;</div></td>";
     
      }
        else if($key->attribute_name=='increment_applied_on_salary')
        {
        echo '<td class="txtalignright font-14b">'.HLP_get_formated_amount_common($row["increment_applied_on_salary"]).'</td>';
        }

         else if($key->attribute_name=='current_target_bonus')
        {
        echo '<td class="txtalignright font-14b">'.HLP_get_formated_amount_common($row["current_target_bonus"]).'</td>';
        }
        else if($key->attribute_name=='current_position_pay_range')
        {
        echo "<td class='txtalignright font-14b'>".$current_position_pay_range."</td>";
        }
		elseif($key->attribute_name=='merit_increase_amount')
		{
		   echo "<td class='txtalignright'>".HLP_get_formated_amount_common(($row["increment_applied_on_salary"]*$row["performnace_based_increment"])/100)."</td>";
		}
		elseif($key->attribute_name=='merit_increase_percentage')
		{
		   echo "<td class='txtalignright'>".HLP_get_formated_percentage_common($row["performnace_based_increment"])."%</td>";
		}
		elseif($key->attribute_name=='market_correction_amount')
		{
		   echo "<td class='txtalignright'>".HLP_get_formated_amount_common(($row["increment_applied_on_salary"]*$row["crr_based_increment"])/100)."</td>";
		}
		elseif($key->attribute_name=='market_correction_percentage')
		{
		   echo "<td class='txtalignright'>".HLP_get_formated_percentage_common($row["crr_based_increment"])."%</td>";
		}
        else if($key->attribute_name=='salary_increment_amount')
        {
            $salary_increment_amount = $row["increment_applied_on_salary"]*$row["manager_discretions"]/100;
           echo "<td class='txtalignright font-14b'>".HLP_get_formated_amount_common($salary_increment_amount)."</td>";
        }
else if($key->attribute_name=='manager_discretions')
 {
       echo "<td class='txtalignright '> <div class='edit_recommd'><span class='salary_increase".$row['tbl_pk_id']."' >".HLP_get_formated_percentage_common($row["manager_discretions"])."%</span><br><p class='original_recomd'><em data-toggle='tooltip' title='Original salary increase as per rules'>"."(".HLP_get_formated_percentage_common($all_hikes_total)."%)</em></p></div></td>";


 }
 else if($key->attribute_name=='salary_increase_range')
  {
    if($rule_dtls["Manager_discretionary_increase"] > 0 || $rule_dtls["Manager_discretionary_decrease"] )
                      {
                       echo "<td class='txtalignright '>".HLP_get_formated_percentage_common($manager_max_dec_per)." - ".HLP_get_formated_percentage_common($manager_max_incr_per)."%</td>";
                      }
                      else
                      {
                        echo '<td></td>';
                      }
}
else if($key->attribute_name=='salary_comment')
      {
        
      echo "<td class=''>".$more."</td>";

    

      ?><?php
     
      }
      else if($key->attribute_name=='promotion_recommandetion')
        { ?> 
          <td>
      <div class="beg_color">
        <label style="color:#000 !important;">&nbsp;
          <?php $is_chk_check = ""; $is_chk_editable = 'disabled';
           if($sp_per>0){ $is_chk_check = "checked"; }//echo "Yes"; }else{ echo "No"; }
           if($is_manager_can_edit_salary_hikes){ $is_chk_editable = ""; } ?>
          &nbsp;<input type="checkbox" id="chk_dfault_promotion<?php echo $row['tbl_pk_id']; ?>" style="opacity:1; margin-top:1px;" <?php echo $is_chk_check; ?> <?php echo $is_chk_editable; ?> onclick="set_default_promotion_to_emp('<?php echo $row['tbl_pk_id']; ?>','<?php echo $row["standard_promotion_increase"]; ?>','<?php echo $rule_dtls['manager_can_exceed_budget']; ?>');"><span></span>
        </label>
      </div>
    </td>
  <?php } 
 else if($key->attribute_name=='sp_increased_salary')
     { ?>
        
        <td class='txtalignright'><div class='edit_recommd'>
        <span class='promotion_element<?php echo $row['tbl_pk_id']; ?>' ><?php echo HLP_get_formated_amount_common($row["sp_increased_salary"]); ?></span> 
        <input type="hidden" id="hf_increment_applied_on_salary<?php echo $row['tbl_pk_id']; ?>" value="<?php echo round($row["increment_applied_on_salary"]); ?>" />
        <input class='form-control' onKeyUp='validate_onkeyup_num(this);'  id="promotion_increment<?php echo $row['tbl_pk_id']; ?>" maxlength=10 type='text' value="<?php echo round($row["sp_increased_salary"]); ?>" style='display:none;' onblur='getperr(this.value,"<?php echo $row['tbl_pk_id']; ?>","<?php echo round($row["increment_applied_on_salary"]); ?>")' <?=$readOnly?>>
        
  
  </div>
</td>

<?php } 
  else if($key->attribute_name=='sp_manager_discretions')
   {    ?>
        <td class='txtalignright'><div class='edit_recommd'><span class='promotion_element<?php echo $row['tbl_pk_id']; ?>' ><?php echo HLP_get_formated_percentage_common((float)$sp_per); ?>%</span>
        <input  class='form-control ' onKeyUp='validate_percentage_onkeyup_common(this,3);' id="promotion_per<?php echo $row['tbl_pk_id']; ?>" type='text' value="<?php if($sp_per>0){ echo HLP_get_formated_percentage_common((float)$sp_per);} else { echo HLP_get_formated_percentage_common((float)$rule_dtls['standard_promotion_increase']); }  ?>" style="display: none;" onblur='getamtt(this.value,"<?php echo $row['tbl_pk_id']; ?>","<?php echo round($row["increment_applied_on_salary"]); ?>")' <?=$readOnly?>>
          <input  class='form-control ' id="promotion_per_hidden<?php echo $row['tbl_pk_id']; ?>" type='hidden' value="<?php if($sp_per>0){ echo HLP_get_formated_percentage_common((float)$sp_per);} else { echo HLP_get_formated_percentage_common((float)$rule_dtls['standard_promotion_increase']); }  ?>" style="display: none;" onblur='getamtt(this.value,"<?php echo $row['tbl_pk_id']; ?>","<?php echo round($row["increment_applied_on_salary"]); ?>")'>
        
        </div>
        </td>

<?php }

 else if($key->attribute_name=='new_grade' || $key->attribute_name=='new_level' || $key->attribute_name=='new_designation')
{ ?>

  <td>
    <?php  echo $row['emp_new_designation']; ?>
  </td>

<?php }

 else if($key->attribute_name=='promotion_comment') { 
    
   ?>
    <td class=''><?=$more1?></td>
   

  <?php } else if($key->attribute_name=='final_total_increment_amount') { ?>
          <td class='txtalignright font-14b'><?php echo HLP_get_formated_amount_common($row["final_salary"]-$row["increment_applied_on_salary"]) ?></td>

  <?php } else if($key->attribute_name=='final_total_increment_percent') { ?>
<td class='txtalignright font-14b <?=($all_hikes_total<$sp_per+$row["manager_discretions"])? 'redColor':'' ?>'><?php echo HLP_get_formated_percentage_common((float)$sp_per+$row["manager_discretions"]); ?>%</td>
<?php }   else if($key->attribute_name=='final_salary') {?>

<td class='txtalignright font-14b'><?php echo HLP_get_formated_amount_common($row["final_salary"]); ?></td>
<?php }

  else if($key->attribute_name=='current_total_fixed_salary')
                    {
                      echo '<td class="txtalignright font-14b">'.HLP_get_formated_amount_common($row["increment_applied_on_salary"]-$row["current_target_bonus"]).'</td>';
                    } 
                  else if($key->attribute_name=='new_total_fixed_salary')
                    {
                      echo '<td class="txtalignright font-14b">'.HLP_get_formated_amount_common($row["final_salary"]-($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["sp_manager_discretions"] + $row["manager_discretions"])/100))).' </td>';
                    } 
 else if($key->attribute_name=='revised_variable_salary') { ?>

<td class='txtalignright font-14b'><?php echo HLP_get_formated_amount_common($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["sp_manager_discretions"] + $row["manager_discretions"])/100)); ?></td>

<?php } else if($key->attribute_name=='new_positioning_in_pay_range') { ?>

<td class='txtalignright font-14b'><?php if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
{
  echo $row["post_quartile_range_name"];
}
else
{
  if($row["market_salary"])
    {
    echo HLP_get_formated_percentage_common(($row["final_salary"]/$row["market_salary"])*100); 
    }
      else
        {
          echo '0';
        }
  echo "%";
} ?>
  
</td>

<?php }  else { echo "<td class='text-center'>".$row[$key->attribute_name]."</td>";  } ?>

    
  <?php  
############################### END #####################################
} ?>


<?php if($rule_dtls['esop_title']!="" && !empty($checkApproverEsopRights)) { ?>

  <td class='txtalignright'><div class='edit_recommd'><span class='additional_fields_element<?php echo $row['tbl_pk_id']; ?> additional_fields_esop<?php echo $row['tbl_pk_id']; ?>' ><?php if($row["esop"]){ echo $row["esop"];}else{echo 0;}
  ?></span><input class="form-control additional_fields<?php echo $row['tbl_pk_id']; ?>" type="text" placeholder="<?php echo $row["esop_title"]; ?>" name="txt_esop" id="txt_esop<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $row["esop"]; ?>" <?php if($row["esop_type"] == 3){?> onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" maxlength="10" <?php }elseif($row["esop_type"] == 1){?> onKeyUp="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" maxlength="10" <?php }else{ ?> maxlength="200" <?php } ?> style='display:none;'/>
  
  </div>
</td>
<?php } if($rule_dtls['pay_per_title']!="" && !empty($checkApproverPayPerRights)) {?>
  <td class='txtalignright'><div class='edit_recommd'>
    <span class='additional_fields_element<?php echo $row['tbl_pk_id']; ?> additional_fields_pay_per<?php echo $row['tbl_pk_id']; ?>' ><?php if($row["pay_per"]){ echo $row["pay_per"];}else{echo 0;}
  ?></span><input class="form-control additional_fields<?php echo $row['tbl_pk_id']; ?>" type="text" placeholder="<?php echo $row["pay_per_title"]; ?>" name="txt_pay_per" id="txt_pay_per<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $row["pay_per"]; ?>" <?php if($row["pay_per_type"] == 3){?> onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" maxlength="10" <?php }elseif($row["pay_per_type"] == 1){?> onKeyUp="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" maxlength="10" <?php }else{ ?> maxlength="200" <?php } ?> style='display:none;'/>
 

</div>
  </td>
<?php } if($rule_dtls['retention_bonus_title']!="" && !empty($checkApproverBonusRecommandetionRights)) {?> 
  <td class='txtalignright'>
    <div class='edit_recommd'>
<span class='additional_fields_element<?php echo $row['tbl_pk_id']; ?> additional_fields_retention_bonus<?php echo $row['tbl_pk_id']; ?>' ><?php if($row["retention_bonus"]){ echo $row["retention_bonus"];}else{echo 0;}
  ?></span><input class="form-control additional_fields<?php echo $row['tbl_pk_id']; ?>" type="text" placeholder="<?php echo $row["retention_bonus_title"]; ?>" name="txt_retention_bonus" id="txt_retention_bonus<?php echo $row['tbl_pk_id']; ?>" value="<?php echo $row["retention_bonus"]; ?>" <?php if($row["retention_bonus_type"] == 3){?> onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" maxlength="10" <?php }elseif($row["retention_bonus_type"] == 1){?> onKeyUp="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" maxlength="10" <?php }else{ ?> maxlength="200" <?php } ?> style='display:none;'/>
  


</div>
  </td>
<?php } ?>

<?php 
echo "</tr>";

if(count($staff_list) == ($i+1) and count($pk_ids)>0)
{ 
  $tbl_ids_arr[] = $tbl_cnt-1;
  ?>
  <tr><td colspan='<?=$colspanCount?>' style='text-align:right'>

    <form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_increment"); ?>" method="post" class="form-inline">
      <?php echo HLP_get_crsf_field();?>
      <input type="button" id="btn_reject_<?php echo $i; ?>" onclick="show_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Reject"/>

      <div class="row" id="dv_remark_<?php echo $i; ?>" style="display: none;">
        <div class="col-sm-12">                             
          <div class="form-input">
            <input type="hidden" name="emp_sal_tbl_pk_ids" value="<?php echo implode(",",$pk_ids); ?>" />
            <textarea class="form-control" rows="6" name="txt_remark" placeholder="Eneter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px; height: 70px;width:100%;"></textarea>
          </div>                                      
        </div>                                                 
        <div class="col-sm-8 col-sm-offset-3">                        
          <div class="submit-btn">
            <input type="submit" class="btn btn-twitter m-b-sm add-btn" value="Submit"/>
          </div>
        </div>
        <div class="col-sm-1">
          <div class="submit-btn">
            <input type="button" onclick="hide_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Cancel" />
          </div>
        </div>                   
      </div>
    </form>
  </td></tr>              
<?php }
$prev_record_manager_email = strtolower($row["last_action_by"]);
$i++;
}
?>  
</tbody>
</table> 

</div>

                   <br>
                    <?php if($is_enable_approve_btn){?>                   
                    <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>" href="<?php echo site_url("manager/send-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')">
                    <input type="button" class="btn btn-twitter m-b-sm add-btn h_p8 h_mr8" value="Submit For Next Level" id="btnSave" />
                    </a>
                    <?php } ?>
                <?php }else echo "<p>No record found.</p>"; ?>  
                </div>  
            </div>                 
            </div>
        
<style>
.table{
	background-color:#fff;
}
</style>
<script>

$(document).ready(function() {

$('#mytable_<?=$newId?> thead tr').clone(true).addClass('secondHeader').appendTo( '#mytable_<?=$newId?>   thead');
    $('#mytable_<?=$newId?> thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#mytable_<?=$newId?>').DataTable( {
        orderCellsTop: true,
       
        searching: true,
         paging: false, 
         info: false
         
       // fixedHeader: true
    } );

});


function show_remark_dv(obj)
{
	$("#dv_remark_"+obj).show();
	$("#btn_reject_"+obj).hide();
}

function hide_remark_dv(obj)
{
	$("#dv_remark_"+obj).hide();
	$("#btn_reject_"+obj).show();
}

</script>

<?php if(isset($is_open_frm_manager_side)){?>
<style>
    .light_green_bg td
    {
        background-color:<?php echo CV_LIGHT_GREEN_BG_COLOR; ?> !important;     
    }
    .light_yellow_bg td
    {
        background-color:<?php echo CV_LIGHT_YELLOW_BG_COLOR; ?> !important;        
    }
</style>
<?php if($staff_list){ ?>
<script>
    var rule_id = '<?php echo $rule_id; ?>';
    var tbl_ids_arr = '<?php echo json_encode($tbl_ids_arr); ?>';
    
    for(var i=0; i<='<?php echo $tbl_cnt; ?>'; i++)
    {
        if(jQuery.inArray(i, JSON.parse(tbl_ids_arr)) !== -1)
        {
            $(".tr_class_"+rule_id+"_"+i).addClass('light_green_bg');
        }
        else
        {
            $(".tr_class_"+rule_id+"_"+i).addClass('light_yellow_bg');
        }
    }
</script>
<?php } } ?>