
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
/*::-webkit-scrollbar
{
  width: 12px;  
  height: 12px;
::-webkit-scrollbar-track
{
  background: rgba(0, 0, 0, 0.1);
}
::-webkit-scrollbar-thumb
{
    background: rgba(0, 0, 0, 0.3);
    border-radius: 8px;
}*/
html, body {
    height: 100%;
}
.bodybg {
    background-image: url('<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>');
    background-size: cover;
    background-repeat: no-repeat;
}
.team {
    padding: 50px 0;
}
.whiteBlock {
    background-color: #f9f9f9;
    box-shadow: 0 0 4px 1px #aaa;
}

.whiteBlock table tr th, .whiteBlock table tr td{font-size: 16px;}

.leftTop {
    padding: 20px;
    box-shadow: -5px -1px 6px 3px rgba(0,0,0,0.1);
}
.leftTop p {
    font-weight: 400;
    color: #576271;
    font-size: 18px;
    margin: 0;
}
.leftTop p .badge {
    margin: -3px 0 0 25px;
    font-size: 11px;
    background-color: #003277;
}
.closeClick {
    cursor: pointer;
}
.leftBottom {
    overflow-y: auto;
    padding: 22px 10px 22px 12px;
    max-height: 643px;
}
.leftBottom th {
    font-weight: 500;
    color: #000;
    font-size: 13px;
}
.leftBottom td {
    font-weight: 400;
    color: #000;
    font-size: 12px;
    padding: 8px 0 !important;
    border-color: #eee !important;
}
.leftBottom .table>thead>tr>th {
    border-bottom: 1px solid #ddd;
    padding: 0 0 2px 0 !important;
}
.leftBottom th i {
    color: #003277;
    font-size: 12px;
    /* padding-left: 3px; */
}
.leftBottom th:first-child {
    position: relative;
}
.leftBottom th:first-child:after {
    content: " ";
    display: inline-block;
    height: 1px;
    background-color: #003277;
    width: 20px;
    position: absolute;
    left: 0;
    bottom: 0;
}
.rightTop {
    /*padding: 30px 28px;*/
     padding: 25px 25px 25px 25px;
}
.rightTop .whiteOverlay {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.08), 0 10px 20px rgba(0,0,0,0.15);
    /* box-shadow: 0 3px 22px 0 rgba(0,0,0,0.7); */
    padding: 28px 20px;
    background-image: url('<?php echo base_url("assets/images/whiteoverlay.png"); ?>');
    background-size: cover;
}
.rightTop .whiteOverlay h2 {
    color: #000;
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 5px 0;
}
.rightTop .whiteOverlay p {
    color: #000;
    font-size: 20px;
    font-weight: 500;
    margin: 0;
}
.lessWhiter {
    background-color: #f9f9f9;
    box-shadow: 0 0 4px 1px #aaa;
    text-align: center;
    padding: 15px 0;
    background-image: url('<?php echo base_url("assets/images/greyoverlay.png"); ?>');
    background-size: cover;
}
.rightCenterOne, .rightCenterTwo {
    margin-top: 15px; 
}
.pdr0 {
    padding-right: 0;
}
.lessWhiter h3 {
    color: #000;
    font-size: 16px;
    font-weight: 500;
    margin: 0 0 8px 0;
}
.lessWhiter p {
    color: rgba(0,0,0,0.7);
    font-size: 14px;
    font-weight: 400;
    margin: 0 0 0 0;
}
.lessWhiter p span {
    font-weight: 700;
}
.rightBottom {
    /*padding: 30px 28px;*/
    padding: 20px 25px 25px 25px;
    /*margin-top: 15px;*/
}
.rightBottom h3 {
    color: #000;
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 20px 0;
}
.darkOverlay {
    background-color: #333;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15), 0 10px 14px rgba(0,0,0,0.30);
    /* box-shadow: 0 3px 22px 0 rgba(0,0,0,0.7); */
    padding: 16px 3px;
    background-image: url('<?php echo base_url("assets/images/darkoverlay.png"); ?>');
    background-size: cover;
}
.darkOverlay h2 {
    color: rgba(255,255,255,0.8);
    font-size: 18px;
    font-weight: 400;
    margin: 0 0 15px 0;
}
.darkOverlay p {
    color: rgba(255,255,255,0.7);
    font-size: 24px;
    font-weight: 700;
    margin: 0;
}
.show-element1, .show-element2 {
    display: none;
}
.darkOverlay .lessFont {
    font-size: 18px;
    position: absolute;
    right: 35px;
}
.darkOverlay input, .darkOverlay button {
    display: inline-block;
    /*max-width: 135px !important;*/
}
.darkOverlay .lessFont img {
    max-width: 12px;
}
.team .container {
   // width: 80% !important; /*Shumsul*/
    width: 100% !important; /*Shumsul*/
}

#emplist.table tr th:nth-child(1){width:100px !important;}
#emplist.table tr th:nth-child(3){width:80px !important;}

#emplist.table tr th{text-align: left !important; vertical-align: inherit;}
#emplist.table tbody tr td:nth-child(3){text-align: right !important;}
#emplist.table tbody tr td:nth-child(4),#emplist.table tbody tr td:nth-child(5){text-align: center !important;}
@media screen and (max-width: 767px) {
    .table-responsive {
        border: 0;
}
}

.darkOverlay input {
	color: #000 !important;
}
</style>

<section class="team bodybg">
    <div class="container">
        <div class="row">
           
        	<?php $expand_cls = 12; if(count($staff_list)>0){
                    $expand_cls = 7; 
                    $manager_emailid=$this->session->userdata('email_ses');
                    if(@$removeleft=='removeleft')
                    {
                        $cls='style="display:none;"';
                        $offsetcls='col-md-offset-2';
                    }
                    $i=0; $is_enable_approve_btn=1;
                             
                             $rule_id = $staff_list[0]["rule_id"];
                             $prev_record_manager_email = "";
                             $pk_ids = array();

                             foreach($staff_list as $row)
                             {
                                if($row["emp_bonus_status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
                                {
                                    $is_enable_approve_btn=0;
                             }
                             $prev_record_manager_email = strtolower($row["last_action_by"]);
                                $i++;
                                }
                    ?>
             
            
            <div class="col-md-5 left-md" <?php echo @$cls ?>>
                <div class="leftTeamArea whiteBlock">
                    <?php if($is_enable_approve_btn == 1 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>
            <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>" style="position: absolute;  margin-left: 46%;  margin-top: 13px;" href="<?php echo site_url("manager/send-bonus-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')">
                        <input type="button" class="btn btn-twitter m-b-sm add-btn" value="Submit For Next Level" id="btnSave" />
                    </a>
              <?php } ?>
                    <div class="leftTop">
                        <p>My Team                         
                            <span class="pull-right closeClick" ><i class="fa fa-times"></i></span></p>
                    </div><!--.leftTop-->
                    
                    <div class="leftBottom">
                        <div class="table-responsive">          
                            <table class="table" id="emplist">
                                <thead>
                                <tr>
									 <th>Employee <!--<i class="fa fa-long-arrow-up"></i>--></th>
									 <?php if($rule_dtls["performance_type"]==2)
										 {
											echo "<th>Performance<br>Achievement <br>%</th>";
										}
										else
										{
											echo "<th>Performance<br>Rating</th>";
										} ?>
                                   
                                    
                                    <th>Incentive Amount<!-- Amount --></th>
                                    <!--<th>Manager</th>-->
                                    <!-- <th>System<br> Reco. <br>Bonus %</th> -->
                                    <th>Incentive <br>Percentage</th>
                                </tr>
                                </thead>
                                <tbody>
                                	<?php
                                        
                                        foreach($staff_list as $row){?>
                                    <tr>
										                                       
					<?php if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>	
                                            <td><a href='<?php echo site_url("manager/view-employee-bonus-increments/".$row["rule_id"]."/".$row["id"]); ?>'><?php echo $row["name"]; ?></a></td>										
                                        <?php } else {?>
                                            <td><a href='<?php echo site_url("view-employee-bonus-increments/".$row["rule_id"]."/".$row["id"]); ?>'><?php echo $row["name"]; ?></a></td>
                                        <?php } ?>
                                        
                                            
                                        <?php if($rule_dtls["performance_type"]==2)
										 {
											echo "<td style='max-width: 120px;' class='text-center'>".$row['performance_achievement']."%</td>";
										}
										else
										{
											echo "<td style='max-width: 120px;' class='text-left'>".$row['performance_rating']."</td>";
										} ?> 
                                        <td style="min-width: 100px;"><?php if($row["currency_type"]){echo $row["currency_type"];}else{echo "$";} ?>&nbsp;<?php echo HLP_get_formated_amount_common($row["final_bonus"]); ?></td>
                                            <!--<td><?php echo $row['last_manager_name'] ?></td>-->
                                        <!-- <td><?php //echo $row['actual_bonus_per'] ?>%</td> -->
                                        <td>
										 <?php echo $row["final_bonus_per"]; ?>%
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div><!--.leftBottom-->
                </div>
            </div><!--.col-md-4-->
            <?php } ?>
            <div class="col-md-<?php echo $expand_cls; ?> right-md <?php echo @$offsetcls ?>">
              <?php echo $this->session->flashdata('message'); ?> 
                <div class="rightTeamArea transparentBlock" style="position: relative;">
                    <div class="rightBottom whiteBlock">
                        <button class="btn btn-primary btn-xs" type="button" id="showteam" onclick="showteam()">Show Team</button>
                        
                        <?php $dis_cls = 'disabled="disabled"'; if(($is_hr_can_edit_bonus==1) or ($this->session->userdata('is_manager_ses') == 1 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side))){ $dis_cls = ""; }?>
                        <form class="frm_cstm_popup_cls_default" method="post" action="">
                        	<?php echo HLP_get_crsf_field();?>
							
							<?php
							$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
							foreach($managers_arr as $key => $value)
							{
							  if(strtolower($this->session->userdata('email_ses')) == strtolower($value[0]))
							  {
								$manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
								echo "<span><b class='tot_bug'> Total Budget : " . HLP_get_formated_amount_common($manager_tot_bdgt)."</b></span>";
								$used_budget = HLP_get_managers_emps_total_budget_bonus($rule_dtls['id'], strtolower($value[0]));
								echo  "<span><b class='avl_bug'> Available Budget : ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). "</b></span>";
								break;
							  }
							} 
							?>
                        	<h3><!--<span style="font-weight:bold;">Recommended Bonus For : </span>--> <span style="font-weight:bold;color:#F00; font-size:20px;"><?php echo $bonus_dtls["name"]; ?>, <?php echo $bonus_dtls["current_designation"]; ?></span></h3>
                        
                            <div class="row darkOverlay">
                                <div class="col-md-12">
                                    <div class="dark-box">
                                	<div class="row">
                                      
                                        <div class="col-md-5">
                                            <h2>
                                                Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?>
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>
                                                <?php if($bonus_dtls["currency_type"]){echo $bonus_dtls["currency_type"];}else{echo "$";} ?> <?php echo HLP_get_formated_amount_common($bonus_dtls["target_bonus"]); ?>
                                            </h2>
                                         </div>
                                      </div>
                                     </div>
                                     <div class="clearfix"></div>
                                    <div class="dark-box">
                                     <div class="row">
                                        <div class="col-md-5">
                                            <h2>
                                                 <?php if($rule_dtls["performance_type"]==2)
												 {
                                                    echo "Individual Achievement %";
													//echo "Individual Performance Achievement";
												}
												else
												{
													echo "Individual Performance Rating";
												} ?>
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>
											
												<?php if($rule_dtls["performance_type"]==2)
												 {
													if($bonus_dtls["performance_achievement"]){echo $bonus_dtls["performance_achievement"].'%';}else{echo "-----";}
												}
												else
												{
													if($bonus_dtls["performnace_rating"]){echo $bonus_dtls["performnace_rating"];}else{echo "-----";}
												} ?> 
                                            </h2>
                                         </div>
                                     </div>
                                    </div>
                                     <div class="clearfix"></div>
                                    <div class="dark-box"> 
                                     <div class="row">
                                        <div class="col-md-5">
                                            <h2 style="margin-top:7px;">
                                                Final<!-- Recommended --> <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?>
                                            </h2>
                                         </div>
                                        <div class="col-lg-7">
                                            <div class="row">
                                             <div class="col-md-12">
                                                 <h2 style="margin-bottom: 0px;">
                                                     <span style="width:100%;position: absolute; padding: 9px; width: 50px;text-align: center;  color: #000; font-size: 16px;"><?php if($bonus_dtls["currency_type"]){echo $bonus_dtls["currency_type"];}else{echo "$";} ?></span> <input style="width:48%; margin-right:2%; padding: 6px 43px!important;"  type="text" class="form-control " value="<?php echo round($bonus_dtls["final_bonus"]); ?>" placeholder="Enter your Amount" name="txt_target_bonus_amt" id="txt_target_bonus_amt" maxlength="12" required onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9); manage_target_bonus('1')" <?php echo $dis_cls; ?>>
                                                    
                                                    <span style="width:100%;position: absolute; margin-top:9px; color: #000; background-color: transparent; font-size: 16px; margin-left: 68px;">% of Target <?php /*if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;}*/ ?></span>
                                                    <input style="width:48%;" type="text" class="form-control" value="<?php echo $bonus_dtls["final_bonus_per"]; ?>" placeholder="Enter your Percentage" name="txt_target_bonus_per" id="txt_target_bonus_per" maxlength="7" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3); manage_target_bonus('2')" <?php echo $dis_cls; ?>>


                                                </h2>
                                             </div>
                                             <div class="col-md-12" style="display: none;">
                                                <h2 style="margin-bottom: 3px;">
                                                    
                                                   <span style="width:100%;position: absolute; margin-top:9px; color: #000; background-color: transparent; font-size: 16px; margin-left: 68px;">% of Target  <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> </span>
                                                    <input style="width:275px;" type="text" class="form-control" value="<?php echo $bonus_dtls["final_bonus_per"]; ?>" placeholder="Enter your Percentage" name="txt_target_bonus_per" id="txt_target_bonus_per" maxlength="7" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3); manage_target_bonus('2')" <?php echo $dis_cls; ?>>
                                                    

                                                </h2> 
                                             </div> 
                                                                               
                                         </div>
                                         </div>
                                     </div>    
                                        
                                        
                                        
                                     </div>
                                     
                                    <div class="row">
                                     <?php if(($is_hr_can_edit_bonus==1) or ($this->session->userdata('is_manager_ses') == 1 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side))){?>
                                            <div class="col-sm-offset-5 col-sm-7 text-right">
                                                <button style="width:50%; font-size:15px;  height: 38px" type="submit" class="btn btn-primary" onclick="return request_custom_confirm('frm_cstm_popup_cls_default');">Recommend</button>
                                                <input type="hidden" name="hf_emp_bonus_id" id="hf_emp_bonus_id" value="<?php echo $bonus_dtls["id"]; ?>" />
                                            </div>
                                        <?php } ?>
                                    
                                 </div> 
                              </div>
                                
                            </div>
                        </form>
                    </div><!--.rightBottom-->
                    
                    
                    <div class="rightTop whiteBlock" style="margin-top:15px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="whiteOverlay table-responsive" style="background-image:url('')">
                                    
                                    <table id="example" class="table tablep border  ">
                                        <thead>
                                            <tr>
                                                <!-- <th>Business Level</th> -->
                                                <th style="vertical-align: middle;">Linked to <br>Performance of</th>
                                                <th style="vertical-align: middle;">Weighting</th>
                                                <th style="vertical-align: middle;">Actual<br> Achievement</th>
                                                <th style="vertical-align: middle;">Weighted Average<br> Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            <?php $total_weighted_avg_score=0;
if(round($bonus_dtls["bl_1_weightage"])!=0 && round($bonus_dtls["bl_1_achievement"])!=0) { ?>                                            
                                            <tr>
                                                <!-- <td>Business Level -1</td> -->
                                                <td><?php echo $bonus_dtls["bl_1_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_1_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_1_achievement"]; ?>%</td>
                                                <td><?php           
                                                    $bl_1_avg_score=HLP_get_formated_percentage_common(($bonus_dtls["bl_1_weightage"]*$bonus_dtls["bl_1_achievement"])/100);
                                                    $total_weighted_avg_score += $bl_1_avg_score;
                                                echo $bl_1_avg_score; ?>%</td>
                                            </tr>
                                             
                                                <?php } ?>
                                            <?php if(round($bonus_dtls["bl_2_weightage"])!=0 && round($bonus_dtls["bl_2_achievement"])!=0) { ?>
                                            <tr>
                                              <!--   <td>Business Level -2</td> -->
                                                <td><?php echo $bonus_dtls["bl_2_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_2_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_2_achievement"]; ?>%</td>
                                                <td><?php  $bl_2_avg_score =  HLP_get_formated_percentage_common(($bonus_dtls["bl_2_weightage"]*$bonus_dtls["bl_2_achievement"])/100);
                                                 $total_weighted_avg_score += $bl_2_avg_score;
                                                 echo $bl_2_avg_score; ?>%</td>
                                            </tr>
                                             
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["bl_3_weightage"])!=0 && round($bonus_dtls["bl_3_achievement"])!=0) { ?>
                                            <tr>
                                               <!--  <td>Business Level -3</td> -->
                                                <td><?php echo $bonus_dtls["bl_3_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_3_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_3_achievement"]; ?>%</td>
                                                
                                                <td><?php  $bl_3_avg_score =  HLP_get_formated_percentage_common(($bonus_dtls["bl_3_weightage"]*$bonus_dtls["bl_3_achievement"])/100);
                                                 $total_weighted_avg_score += $bl_3_avg_score;
                                                 echo $bl_3_avg_score; ?>%</td>
                                            </tr>
                                             
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["function_weightage"])!=0 && round($bonus_dtls["function_achievement"])!=0) { ?>
                                            <tr>
                                               <!--  <td>Function</td> -->
                                                <td><?php echo $bonus_dtls["function_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["function_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["function_achievement"]; ?>%</td>
                                               
                                                <td><?php  $function_avg_score =  HLP_get_formated_percentage_common(($bonus_dtls["function_weightage"]*$bonus_dtls["function_achievement"])/100);
                                                 $total_weighted_avg_score += $function_avg_score;
                                                 echo $function_avg_score; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["sub_function_weightage"])!=0 && round($bonus_dtls["sub_function_achievement"])!=0) { ?>
                                            <tr>
                                               <!--  <td>Sub Function</td> -->
                                                <td><?php echo $bonus_dtls["sub_function_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["sub_function_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["sub_function_achievement"]; ?>%</td>
                                                <!-- <td><?php //echo HLP_get_formated_percentage_common(($bonus_dtls["sub_function_weightage"]*$bonus_dtls["sub_function_achievement"])/100); ?>%</td> -->
                                                <td><?php  $sub_function_avg_score =  HLP_get_formated_percentage_common(($bonus_dtls["sub_function_weightage"]*$bonus_dtls["sub_function_achievement"])/100);
                                                 $total_weighted_avg_score += $sub_function_avg_score;
                                                 echo $sub_function_avg_score; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["sub_subfunction_weightage"])!=0 && round($bonus_dtls["sub_subfunction_achievement"])!=0) { ?>
                                            <tr>
                                                <!-- <td>Sub Sub Function</td> -->
                                                <td><?php echo $bonus_dtls["sub_subfunction_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["sub_subfunction_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["sub_subfunction_achievement"]; ?>%</td>
                                                
                                                 <td><?php  $sub_subfunction_avg_score =  HLP_get_formated_percentage_common(($bonus_dtls["sub_subfunction_weightage"]*$bonus_dtls["sub_subfunction_achievement"])/100);
                                                 $total_weighted_avg_score += $sub_subfunction_avg_score;
                                                 echo $sub_subfunction_avg_score; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            
                                            <?php if(round($bonus_dtls["individual_weightage"])!=0 && round($bonus_dtls["individual_achievement"])!=0) { ?>
                                            <tr>
                                               <!--  <td>Individual</td> -->
                                                <td><?php echo $bonus_dtls["individual_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["individual_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["individual_achievement"]; ?>%</td>
                                                
                                                 <td><?php  $individual_avg_score =  HLP_get_formated_percentage_common(($bonus_dtls["individual_weightage"]*$bonus_dtls["individual_achievement"])/100);
                                                 $total_weighted_avg_score += $individual_avg_score;
                                                 echo $individual_avg_score; ?>%</td>
                                            </tr>                                            
                                            <?php } ?>
                                            
											<tr>
                                              <td style="text-align: right;" colspan="3">
                                                <b>Total Weighted Average Score</b>
                                                </td>
                                              <td><?php echo HLP_get_formated_percentage_common( $total_weighted_avg_score); ?>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--.whiteOverlay-->
                            </div>
                        </div><!--.row-->
                    </div>
                    
                </div><!--.rightTeamArea-->
            </div><!--.col-md-8-->
        </div><!--.row-->
    </div><!--.container-->
</section>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" ></script>
<script>
    $('#showteam').hide();
$('.closeClick').click(function() {
	if ($('.left-md').hasClass('col-md-5')) {
		$('.left-md').hide();
		$('.left-md').removeClass('col-md-5');
                $('#showteam').show();
		$('.right-md').removeClass('col-md-7').addClass('col-md-12');
	} else {
                $('.left-md').show();
		$('.left-md').addClass('col-md-5');
		$('.right-md').removeClass('col-md-12').addClass('col-md-7');
	}
});
function showteam()
{
     $('#showteam').hide();
     $('.left-md').addClass('col-md-5');
     if ($('.right-md').hasClass('col-md-12')) {
		
        $('.right-md').removeClass('col-md-12');
        $('.right-md').removeClass('col-md-12').addClass('col-md-7');
	}
     $('.left-md').show();
}
function validate_onkeyup_dec(that)
{
    that.value = that.value.replace(/[^0-9.]/g,'');
    if(((that.value).split('.')).length>2)
    {
        var arr = (that.value).split('.');
        that.value=arr[0]+"."+arr[1];
    }
}

function validate_onblure_dec(that)
{
    that.value = that.value.replace(/[^0-9.]/g,'');
    if(((that.value).split('.')).length>2)
    {
        var arr = (that.value).split('.');
        that.value=arr[0]+"."+arr[1];
    }

    if((that.value) && Number(that.value)<=0)
    {
        that.value="0";
    }
}

function manage_target_bonus(targeted_by)
{
	var target_bonus = '<?php echo $bonus_dtls["target_bonus"]; ?>';
    var txt_per_val = $.trim($("#txt_target_bonus_per").val());
	var txt_amt_val = $.trim($("#txt_target_bonus_amt").val());

	if(targeted_by == 1)
	{
		$("#txt_target_bonus_per").val(get_formated_percentage_common((txt_amt_val/target_bonus)*100));
	}
	else
	{
		$("#txt_target_bonus_amt").val(Math.round(((txt_per_val*target_bonus)/100)));
	}
}
$(document).ready(function() {
    $('#emplist').DataTable({
        "paging":   false,
         "info":     false,
         "searching": false
    });
} );
</script>

<style type="text/css">
  .tablep tbody tr td{text-align: center;}
</style>
