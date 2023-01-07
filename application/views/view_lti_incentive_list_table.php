<div class="panel-body">
  <div class="form-horizontal">
    <div id="dv_partial_page_data" style="overflow-x: auto;">
      <?php $is_enable_approve_btn=0; $tbl_ids_arr = array();
        $manager_emailid = strtolower($this->session->userdata('email_ses'));
        if($staff_list){ $tbl_cnt = 0; ?>
    <div class="table-scroll">   
      <table id="example" class="table border  ">
        <thead>
           <tr><th style="text-align: left !important;">
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
                    }?>
                 </b></th>

                 <td colspan='9'><b>
                    <?php
                    $managers_arr = json_decode($staff_list[0]['budget_dtls'],true);
                    foreach($managers_arr as $key => $value)
                    {
                      if(strtolower($staff_list[0]["last_action_by"]) == strtolower($value[0]))
                      {
                        $manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
                        echo "</b><b style='float:right;'> (Total Budget : " . HLP_get_formated_amount_common($manager_tot_bdgt);
                        $used_budget = HLP_get_managers_emps_total_budget_lti($staff_list[0]['rule_id'], strtolower($value[0]));
                        echo  " , Available budget : ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). ")";
                        break;
                      }
                    } ?>
                  </b>
                </td>
            </tr>

            <tr>
           <!--  <th class="hidden-xs" width="5%">S.No</th> -->
           <!-- <th>Plan Name</th>
            <th>Rule Name</th>-->
            <th style="text-align: left !important;"><?php echo $business_attributes[0]["display_name"]; ?></th>
            <?php /*?><th><?php echo $business_attributes[1]["display_name"]; ?></th><?php */?>
            <?php /*<th><?php echo $business_attributes[6]["display_name"]; ?></th>*/?>
            <th><?php echo $business_attributes[7]["display_name"]; ?></th>
            <th><?php echo $business_attributes[9]["display_name"]; ?></th>
            <th><?php echo $business_attributes[10]["display_name"]; ?></th>
            <th><?php echo $business_attributes[11]["display_name"]; ?></th>
            <th><?php echo $business_attributes[17]["display_name"]; ?></th>
            <th><?php echo $business_attributes[23]["display_name"]; ?></th>
            <?php /*?><th>LTI linked To</th>
            <th>LTI Grant Baseline</th><?php */?>
            <th>Grant %</th>
            <th>Grant Value</th>
            <!-- <th> Manager Name </th> -->
            <th> Action </th>
          </tr>
        </thead>
        <tbody>
          <?php $i=0; $is_enable_approve_btn=1; $total_incentive = 0;
                     $rule_id = $staff_list[0]["rule_id"];
            foreach($staff_list as $row)
            {
                if($row["emp_incentive_status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
                {
                    $is_enable_approve_btn=0;
                }     
                $total_incentive += $row["final_incentive"];               
                        
                if($prev_record_manager_email != "" and strtolower($row["last_action_by"]) != $prev_record_manager_email)
                {
                  $tbl_cnt++;
                    if(strtolower($staff_list[$i-1]["manager_emailid"]) == $manager_emailid and count($pk_ids)>0)
                    { ?>
                      <tr>
                        <td colspan='10' style='text-align:right'>
                        <form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_bonus_increment"); ?>" method="post" class="form-inline">
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
        




            <tr><th style="text-align: left !important;">
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
                    }?>

                  </b></th>
                  <td colspan='9'><b>
                  <?php
                    $managers_arr = json_decode($row['budget_dtls'],true);
                    foreach($managers_arr as $key => $value)
                    {
                      if(strtolower($row["last_action_by"]) == strtolower($value[0]))
                      {
                        $manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
                        echo "</b><b style='float:right;'> (Total Budget :: " . HLP_get_formated_amount_common($manager_tot_bdgt);
                        $used_budget = HLP_get_managers_emps_total_budget_lti($row['rule_id'], strtolower($value[0]));
                        echo  " , Available budget :: ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). ")";
                        break;
                      }
                    } ?>
                </b>
            </td></tr>
           <!--  <tr>
               <th class="hidden-xs" width="5%">S.No</th>
               <th>Plan Name</th>
               <th>Rule Name</th>
               <th><?php //echo $business_attributes[0]["display_name"]; ?></th>
               <?php /*?><th><?php echo $business_attributes[1]["display_name"]; ?></th><?php */?>
               <?php /*<th><?php echo $business_attributes[6]["display_name"]; ?></th>*/?>
               <th><?php //echo $business_attributes[7]["display_name"]; ?></th>
               <th><?php //echo $business_attributes[9]["display_name"]; ?></th>
               <th><?php //echo $business_attributes[10]["display_name"]; ?></th>
               <th><?php //echo $business_attributes[11]["display_name"]; ?></th>
               <th><?php //echo $business_attributes[17]["display_name"]; ?></th>
               <th><?php //echo $business_attributes[23]["display_name"]; ?></th>
               <?php /*?><th>LTI linked To</th>
               <th>LTI Grant Baseline</th><?php */?>  
               <th>Grant %</th>
               <th>Grant Value</th>
               <th> Manager Name </th>
               <th> Action </th>
           </tr> -->
      
          <?php }                           
                        
                if(strtolower($row["manager_emailid"]) == $manager_emailid and $row["emp_incentive_status"] > 1 and $row["emp_incentive_status"] < 5 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side))
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
                         
                // echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                echo "<th><a target='_blank' href=".site_url("view-employee/".$row["id"]).">".$row["name"]."</a></th>";
                //echo "<td>".$row["business_unit_3"]."</td>";
                echo "<td>".$row["function"]."</td>";
                echo "<td>".$row["desig"]."</td>";
                echo "<td>".$row["grade"]."</td>";
                echo "<td>".$row["level"]."</td>";
                echo "<td>".$row["date_of_joining"]."</td>";
                echo "<td>".$row["performance_rating"]."</td>";
                //echo "<td>".$row["lti_linked_with"]."</td>";

              /*  if($row["lti_basis_on"]==2) {
                    echo "<td>Fixed Value</td>";
                } else {
                    echo "<td>Linked to Salary elements</td>";
                }*/

                if($row["lti_basis_on"]==2)
                {
                    echo "<td class='txtalignright'>-</td>";
                }
                else
                {
                    echo "<td class='txtalignright'>".HLP_get_formated_percentage_common($row["grant_value"])."</td>";
                }
                echo "<td class='txtalignright'>".HLP_get_formated_amount_common($row["final_incentive"])."</td>";
                // echo "<td>".$row["last_manager_name"]."</td>";

                //echo "<td>".$row["last_manager_name"]."</td>";
                //echo "<td>".$row["last_action_by"]."</td>";
                if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side))
                {                   
					if($row["rule_staus"]==CV_STATUS_RULE_RELEASED)
					{
						echo "<td><a href='".site_url("manager/view-employee-lti-dtls-released/".$row["rule_id"]."/".$row["id"])."'>View Incentive</a></td>";
					}
					else
					{
						echo "<td><a href='".site_url("manager/view-employee-lti-dtls/".$row["rule_id"]."/".$row["id"])."'>View Incentive</a></td>";
					}
                    
                }
                else
                {
                    echo "<td><a href='".site_url("view-employee-lti-dtls/".$row["rule_id"]."/".$row["id"])."'>View Incentive</a></td>";
                }
                echo "</tr>";
                        
                        if(count($staff_list) == ($i+1) and count($pk_ids)>0)
                        { $tbl_ids_arr[] = $tbl_cnt-1; ?>
          <!-- <tr>
            <td colspan='14' style='text-align:right'><form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_bonus_increment"); ?>" method="post" class="form-inline">
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
          </tr> -->
          <?php }
                        $prev_record_manager_email = strtolower($row["last_action_by"]);
                        $i++;
                     }
                     ?>
            <tr><td colspan="9" align="right">Total Incentive </td><td><?php echo $total_incentive; ?></td></tr>
        </tbody>
      </table>
      </div>
      <br>
      <?php if($is_enable_approve_btn == 1 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>
            <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>" href="<?php echo site_url("manager/send-lti-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')">
                <input type="button" class="btn btn-twitter m-b-sm add-btn h_p8 h_mr8" value="Submit For Next Level" id="btnSave" />
            </a>
      <?php } ?>
      <?php }else echo "<p>No record found.</p>"; ?>
    </div>
  </div>
</div>
<?php if(isset($is_open_frm_manager_side)) { ?>
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


<style type="text/css">
table>thead>tr>th{border-bottom: 1px solid #ddd !important;} 
</style>

