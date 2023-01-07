<div class="panel-body">
  <div class="form-horizontal">
    <div id="dv_partial_page_data" style="overflow-x: auto;">
      <?php $is_enable_approve_btn=0; 
	  	$tbl_ids_arr = array();
        $manager_emailid = strtolower($this->session->userdata('email_ses'));
        if( $staff_list ){ $tbl_cnt = 0; ?>
      <table id="example" class="table border  ">
        <thead>
            <tr><td colspan='13'>
                <b>
                    <?php if(strtolower($staff_list[0]["last_action_by"]) == $manager_emailid)
                    {
                        echo "My Direct Reports";
                    }
                    else
                    {
                        if($staff_list[0]["last_manager_name"])
                        {
                            echo "Direct Reports Of - ".$staff_list[0]["last_manager_name"];
                        }
                        else
                        {
                            echo "Direct Reports Of - ".$staff_list[0]["last_action_by"];
                        }                               
                    }

                    $managers_arr = json_decode($staff_list[0]['manual_budget_dtls'],true);
                    foreach($managers_arr as $key => $value)
                    {
                      if(strtolower($staff_list[0]["last_action_by"]) == strtolower($value[0]))
                      {
                        $manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
                        echo "</b><b style='float:right;'> (Total Budget : " . HLP_get_formated_amount_common($manager_tot_bdgt);
                        $used_budget = HLP_get_managers_emps_total_budget_bonus($staff_list[0]['rule_id'], strtolower($value[0]));
                        echo  " , Available Budget : ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). ")";
                        break;
                      }
                    } ?>
                </b>
            </td></tr>                  <tr>
            <th class="hidden-xs" width="5%">S.No</th>
           <!-- <th>Plan Name</th>
            <th>Rule Name</th>-->
            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
            <th><?php echo $business_attributes[6]["display_name"]; ?></th>
            <th><?php echo $business_attributes[9]["display_name"]; ?></th>
            <th><?php echo $business_attributes[10]["display_name"]; ?></th>
            <th><?php echo $business_attributes[11]["display_name"]; ?></th>
            <th><?php if($type==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> %age</th>
            <th><?php if($type==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Amount</th>

            <!-- <th><?php echo $business_attributes[17]["display_name"]; ?> for <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> pro-rated calculation</th> -->

            <th>Date of Joining</th>
            <th><?php if($performance_type==2){echo $business_attributes[133]["display_name"];}else{echo $business_attributes[23]["display_name"];} ?></th>
            <!--<th> Manager Name </th>
            <th> Manager Email </th>-->
            <th> Action </th>
          </tr>
        </thead>
        <tbody id="tbl_body">
          <?php $i=0; $is_enable_approve_btn=1;
                     
                     $rule_id = $staff_list[0]["rule_id"];
                     $prev_record_manager_email = "";
                     $pk_ids = array();
                     
                     foreach($staff_list as $row)
                     {
                        if($row["emp_bonus_status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
                        {
                            $is_enable_approve_btn=0;
                        }                       
                        
                        if($prev_record_manager_email != "" and strtolower($row["last_action_by"]) != $prev_record_manager_email)
                        {
							$tbl_cnt++;
                            if(strtolower($staff_list[$i-1]["manager_emailid"]) == $manager_emailid and count($pk_ids)>0)
                            {?>
                              <tr>
                                <td colspan='13' style='text-align:right'>
                                <form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_bonus_increment"); ?>" method="post" class="form-inline">
                                    <?php echo HLP_get_crsf_field();?>
                                    <input type="button" id="btn_reject_<?php echo $i; ?>" onclick="show_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Reject"/>
                                    <div class="row" id="dv_remark_<?php echo $i; ?>" style="display: none;">
                                      <div class="col-sm-12">
                                        <div class="form-input">
                                          <input type="hidden" name="emp_bonus_dtl_tbl_pk_ids" value="<?php echo implode(",",$pk_ids); ?>" />
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
                                  </form></td>
                              </tr>
                              <?php $pk_ids = array(); 
							  	$tbl_ids_arr[] = $tbl_cnt-1;                  
                            } ?>
                          </tbody>
                        </table>
                        <table class='table border'>
                          <thead>
                            <tr><td colspan='13'>
                                <b>
                                    <?php if(strtolower($row["last_action_by"]) == $manager_emailid)
                                    {
                                        echo "My Direct Reports";
                                    }
                                    else
                                    {
                                        if($row["last_manager_name"])
                                        {
                                            echo "Direct Reports Of - ".$row["last_manager_name"];
                                        }
                                        else
                                        {
                                            echo "Direct Reports Of - ".$row["last_action_by"];
                                        }
                                    }

                                    $managers_arr = json_decode($row['manual_budget_dtls'],true);
                                    foreach($managers_arr as $key => $value)
                                    {
                                      if(strtolower($row["last_action_by"]) == strtolower($value[0]))
                                      {
                                        $manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
                                        echo "</b><b style='float:right;'> (Total Budget :: " . HLP_get_formated_amount_common($manager_tot_bdgt);
                                        $used_budget = HLP_get_managers_emps_total_budget_bonus($row['rule_id'], strtolower($value[0]));
                                        echo  " , Available Budget :: ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). ")";
                                        break;
                                      }
                                    } ?>
                                </b>
                            </td></tr>
                            <tr>
                              <th class="hidden-xs" width="5%">S.No</th>
                              <!--<th>Plan Name</th>
                              <th>Rule Name</th>-->
                              <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                              <th><?php echo $business_attributes[6]["display_name"]; ?></th>
                              <th><?php echo $business_attributes[9]["display_name"]; ?></th>
                              <th><?php echo $business_attributes[10]["display_name"]; ?></th>
                              <th><?php echo $business_attributes[11]["display_name"]; ?></th>
                              <th><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> %age</th>
                              <th><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Amount</th>
                              <!-- <th><?php echo $business_attributes[17]["display_name"]; ?></th> -->
                              <th>Date of Joining</th>
                              <th>
							  
							  <?php if($performance_type==2){echo $business_attributes[133]["display_name"];}else{echo $business_attributes[23]["display_name"];} ?></th>
                              <!--<th> Manager Name </th>
                              <th> Manager Email </th>-->
                              <th> Action </th>
                            </tr>
                          </thead>
                          <tbody>
                  <?php }                           
                        
                        if(strtolower($row["manager_emailid"]) == $manager_emailid and $row["emp_bonus_status"] > 1 and $row["emp_bonus_status"] < 5 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side))
                        {
                            $pk_ids[] = $row["tbl_pk_id"];
                        }
                         
						 if($tbl_cnt<=0)
						 {
							 echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
						 }
						 else
						 {
							 echo "<tr class='tr_class_".$rule_id."_".$tbl_cnt."'><td class='hidden-xs'>". ($i + 1) ."</td>";
						 }
                        
                        echo "<td><a target='_blank' href=".site_url("view-employee/".$row["id"]).">".$row["name"]."</a></td>";
                        echo "<td>".$row["business_unit_3"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
                        echo "<td>".$row["grade"]."</td>";
                        echo "<td>".$row["level"]."</td>";                              
                        echo "<td class='txtalignright'>".HLP_get_formated_percentage_common($row["final_bonus_per"])."%</td>";
                        echo "<td class='txtalignright'>".HLP_get_formated_amount_common($row["final_bonus"])."</td>";
                        echo "<td>".$row["date_of_joining"]."</td>";
						if($performance_type==2)
						{
							 echo "<td>".$row[CV_BA_NAME_PERFORMANCE_ACHIEVEMENT]."</td>";
						}
						else
						{
							 echo "<td>".$row["performance_rating"]."</td>";
						}                       
                        echo "<td style='width:140px;'>";
                        
						$link_txt_name = CV_BONUS_LABEL_NAME;
						if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID)
						{$link_txt_name =  CV_BONUS_SIP_LABEL_NAME;}
                                  
                        if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side))
                        {                   
                            echo "<a href='".site_url("manager/view-employee-bonus-increments/".$rule_id."/".$row["id"])."'>View ".$link_txt_name." </a> ";
                        }
                        else
                        {
                            echo "<a href='".site_url("view-employee-bonus-increments/".$rule_id."/".$row["id"])."'>View ".$link_txt_name." </a> ";
                        }
						
						if($rule_dtls['status']==CV_STATUS_RULE_RELEASED)
                        {
                            echo " | <a href='". site_url("employee/view-bonus-letter/".$rule_id."/".$row['id'])."'>View letter</a>"; 
                        }
                        echo "</td></tr>";
                        
                        if(count($staff_list) == ($i+1) and count($pk_ids)>0)
                        {
							$tbl_ids_arr[] = $tbl_cnt-1;
							?>
                          <tr>
                            <td colspan='13' style='text-align:right'><form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_bonus_increment"); ?>" method="post" class="form-inline">
                                <?php echo HLP_get_crsf_field();?>
                                <input type="button" id="btn_reject_<?php echo $i; ?>" onclick="show_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Reject"/>
                                <div class="row" id="dv_remark_<?php echo $i; ?>" style="display: none;">
                                  <div class="col-sm-12">
                                    <div class="form-input">
                                      <input type="hidden" name="emp_bonus_dtl_tbl_pk_ids" value="<?php echo implode(",",$pk_ids); ?>" />
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
                              </form></td>
                          </tr>
                  <?php }
                        $prev_record_manager_email = strtolower($row["last_action_by"]);
                        $i++;
                     }
                     ?>
        </tbody>
      </table>
      <br>
      <?php if($is_enable_approve_btn == 1 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>
            <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>"  href="<?php echo site_url("manager/send-bonus-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')"> 
                <input type="button" class="btn btn-twitter m-b-sm add-btn h_p8 h_mr8" value="Submit For Next Level" id="btnSave" />
            </a>
      <?php } ?>
      <?php }else echo "<p>No record found.</p>"; ?>
    </div>
  </div>
</div>

<script>
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
    <?php if( $staff_list ){ ?>
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
    <?php } ?>
<?php } ?>