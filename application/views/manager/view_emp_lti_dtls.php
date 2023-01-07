<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
/*::-webkit-scrollbar
{
  width: 12px;  
  height: 12px;
}
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
    color: #576271;
    font-size: 13px;
}
.leftBottom td {
    font-weight: 400;
    color: #576271;
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
    padding: 30px 28px;
	margin-top: 15px;
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
    padding: 30px 28px;
    /*margin-top: 15px;*/
}
.rightBottom h3 {
    color: #000;
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 30px 0;
}
.darkOverlay {
    background-color: #333;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15), 0 10px 14px rgba(0,0,0,0.30);
    /* box-shadow: 0 3px 22px 0 rgba(0,0,0,0.7); */
    padding: 28px 18px;
    background-image: url('<?php echo base_url("assets/images/darkoverlay.png"); ?>');
    background-size: cover;
}
.darkOverlay h2 {
    color: rgba(255,255,255,1);
    font-size: 18px;
    font-weight: 400;
    margin: 0 0 15px 0;
}
.darkOverlay p {
    color: rgba(255,255,255,1);
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

.darkOverlay input{font-size: 16px !important; color: #000;}

.darkOverlay input, .darkOverlay button {
    display: inline-block;
    max-width: 135px !important;
}
.darkOverlay .lessFont img {
    max-width: 12px;
}
.team .container {
    width: 100% !important;
}
@media screen and (max-width: 767px) {
    .table-responsive {
        border: 0;
}
}

.darkOverlay input {
	/*background-color: rgba(255,255,255,0.2);*/
}
#emplist.table tr th{text-align: left !important; vertical-align: inherit;}
</style>

<section class="team ">
    <div class="container">
        <div class="row">
            <?php 
				$is_enable_approve_btn=1;
				$total_incentive = 0;
				foreach($staff_list as $row)
				{
					if($row["emp_incentive_status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
					{
						$is_enable_approve_btn=0;
					}
				}
            
            ?>
        	<?php $expand_cls = 12; if(count($staff_list)>0 and $this->session->userdata('role_ses') < 11){ $expand_cls = 8;?>
            <div class="col-md-4 left-md">
                <div class="leftTeamArea whiteBlock">
                    <?php if($is_enable_approve_btn == 1 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>
                                    <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>" style="position: absolute;  margin-left: 46%;  margin-top: 13px;" href="<?php echo site_url("manager/send-lti-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')">
                                        <input type="button" class="btn btn-twitter m-b-sm add-btn" value="Submit For Next Level" id="btnSave" />
                                    </a>
                              <?php } ?> 
                    <div class="leftTop">
                        <p>My Team <!--<span class="badge"><?php echo count($staff_list); ?></span>--><span class="pull-right closeClick"><i class="fa fa-times"></i></span></p>
                    </div><!--.leftTop-->
                    <div class="leftBottom">
                        <div class="table-responsive">          
                            <table class="table" id="emplist">
                                <thead>
                                <tr>
                                   
									<th>Employee <!--<i class="fa fa-long-arrow-up"></i>--></th>
                                    
                                     <th>Performance<br>Rating</th>
                                    <!--<th>Grant Value</th>-->
									<th>System<br>Reco.<br>LTI</th>
                                    <th>Manager's<br>Reco.<br>LTI</th>
                                    <!--<th>Manager</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($staff_list as $row){?>
                                    <tr>
									
										
                                        <td>
											<?php if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side))
                                                { ?>
                                           			<a href="<?php echo site_url("manager/view-employee-lti-dtls/".$row["rule_id"]."/".$row["id"]); ?>"><?php echo $row["name"]; ?></a>
                                            <?php } else { ?>
                                            		<a href="<?php echo site_url("view-employee-lti-dtls/".$row["rule_id"]."/".$row["id"]); ?>"><?php echo $row["name"]; ?></a>
                                            <?php } ?>
                                         </td>
                                        <td><?php echo $row["performance_rating"]; ?></td>
                                        <td class="txtalignright"><?php echo HLP_get_formated_amount_common($row["actual_incentive"]); ?></td>
                                        <td class="txtalignright"><?php echo HLP_get_formated_amount_common($row["final_incentive"]); ?></td>
                                        <!--<td><?php echo $row["last_manager_name"]; ?></td>-->
                                    </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div><!--.leftBottom-->
                </div>
            </div><!--.col-md-4-->
            <?php } ?>
            <div class="col-md-<?php echo $expand_cls; ?> right-md">
                <div class="rightTeamArea transparentBlock">
                    <div class="rightBottom whiteBlock">
                        <button class="btn btn-primary btn-xs" type="button" id="showteam" onclick="showteam()">Show Team</button>
						<?php echo $this->session->flashdata('message');
							$vesting_arr = json_decode($rule_dtls["target_lti_dtls"], true);
							$stock_share_price = 0; 
							$currency_type = "$ ";
							if($emp_lti_dtls["currency_type"]){$currency_type = $emp_lti_dtls["currency_type"]." ";}
							if($rule_dtls["lti_linked_with"]=="Stock Value")
							{
								$currency_type="";
								$stock_share_price = $vesting_arr[0]["grant_value_arr"][0];
							}
									
                         	$dis_cls = 'disabled="disabled"'; if($this->session->userdata('is_manager_ses') == 1 && $emp_lti_dtls["rule_status"]==6 && strtolower($emp_lti_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side)){ $dis_cls = ""; }?>
                    	<form action="" method="post" class="frm_cstm_popup_cls_default">
                        	<?php echo HLP_get_crsf_field();?>
							
							<?php $managers_arr = json_decode($rule_dtls['budget_dtls'],true);
							foreach($managers_arr as $key => $value)
							{
							  if(strtolower($this->session->userdata('email_ses')) == strtolower($value[0]))
							  {
								$manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
								echo "<p><b style='float:right; font-size:16px;'> (Total Budget :: " . HLP_get_formated_amount_common($manager_tot_bdgt);
								$used_budget = HLP_get_managers_emps_total_budget_lti($rule_dtls['id'], strtolower($value[0]));
								echo  " , Available Budget :: ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). ")</b></p>";
								break;
							  }
							} ?>
							
							
                            <h3><!--<span style="font-weight:bold;">Recommended LTI For : </span>--> <span style="font-weight:bold; color:#F00; font-size:20px;"><?php echo $emp_lti_dtls["name"]; ?>, <?php echo $emp_lti_dtls["current_designation"]; ?></span></h3>
                                                       
                            <div class="row darkOverlay">
                                <div class="col-md-10">
                                	<div class="row">
                                    	<div class="col-md-5">
                                            <h2>
                                                Performance Rating
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>
                                                <?php if($emp_lti_dtls["performance_rating"]){echo $emp_lti_dtls["performance_rating"];}else{echo "-----";} ?> 
                                            </h2>
                                         </div>
                                        
                                     </div>
                                     <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-5" style="margin-top:8px;">
                                            <h2>
                                                Recommended LTI
                                            </h2>
                                         </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                             <div class="col-md-12">
                                                 <h2>
                                                 	<input type="hidden" name="hf_emp_lti_id" value="<?php echo $emp_lti_dtls["id"]; ?>" />
                                                 	<?php /*?><input type="text" value="<?php echo $emp_lti_dtls["final_incentive"]; ?>" class="form-control" style="max-width:240px !important;" placeholder="Enter your Amount" name="txt_target_lti_amt" id="txt_target_lti_amt" maxlength="10" required onKeyUp="validate_onkeyup_dec(this);" onBlur="manage_target_bonus('1'), validate_onblure_dec(this);" <?php echo $dis_cls; ?>/><?php */?>
                                                    
                                                    <input type="text" value="<?php echo round($emp_lti_dtls["final_incentive"]); ?>" class="form-control" style="max-width:300px !important;" placeholder="Enter your Amount" name="txt_target_lti_amt" id="txt_target_lti_amt" maxlength="12" required onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" <?php echo $dis_cls; ?>/>
                                                    
                                                </h2>

                                                
                                             </div>

                                             <div class="col-sm-12">
                                                 <h2 style="max-width: 300px !important; background-color: #eee;padding: 8px 12px;">
                                                     <?php if($rule_dtls["lti_basis_on"]!=2){ ?>
                                                 <span style="max-width: 300px !important; background-color: #eee;font-size: 16px; color: #000;">
                                                 <?php //echo $emp_lti_dtls["grant_value"];
                                                        echo HLP_get_formated_percentage_common($emp_lti_dtls["final_incentive"]/(($emp_lti_dtls["actual_incentive"]*100)/$emp_lti_dtls["grant_value"])*100); ?>
                                                 % of Base Salary</span>
                                                 <?php } ?>
                                                 </h2>
                                             </div>
                                                                                
                                            </div>
                                         </div>
                                        
                                        <?php if($this->session->userdata('is_manager_ses') == 1 && $emp_lti_dtls["rule_status"]==6 && strtolower($emp_lti_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side)){?>
                                            <div class="col-md-1" style="padding-left:0px;">
                                                <button style="margin-left:32px; font-size: 16px; margin-top:52px; height: 33px;" type="submit" class="btn btn-primary" onclick="return return request_custom_confirm('frm_cstm_popup_cls_default');">Recommend</button>                                               
                                            </div>
                                        <?php } ?>
                                        
                                     </div>
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h2 style="margin-bottom:3px;">
												<?php if($rule_dtls["lti_linked_with"]=="Stock Value")
                                                {                                                    
                                                    echo "Target Number of Shares";
                                                } 
                                                else
                                                {
                                                    echo "Target LTI";
                                                } ?>
                                                
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2 style="margin-bottom:3px;">
                                                <?php if($rule_dtls["lti_linked_with"] != "Stock Value")
                                                {
                                                    echo $currency_type;
                                                }
                                                
                                                 
                                                
                                                if($rule_dtls["lti_linked_with"]=="Stock Value")
                                                {
                                                    echo HLP_get_formated_amount_common(($emp_lti_dtls["final_incentive"]/$stock_share_price));
                                                    echo " Shares";
                                                } 
                                                else
                                                {
                                                    echo HLP_get_formated_amount_common($emp_lti_dtls["final_incentive"]);
                                                }
                                                ?>
                                            </h2>
                                         </div>                                        
                                    </div>

                                    
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    
                    <div class="rightTop whiteBlock" style="margin-top:15px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="whiteOverlay" style="background-image:url('')">
                                    <?php 
									$last_not_null_vesting_index = 0;
									$total_incentive_befor_last = 0;
									if($vesting_arr[1]["vesting_1_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 1;
									}
									if($vesting_arr[2]["vesting_2_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 2;
									}
									if($vesting_arr[3]["vesting_3_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 3;
									}
									if($vesting_arr[4]["vesting_4_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 4;
									}
									if($vesting_arr[5]["vesting_5_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 5;
									}
									if($vesting_arr[6]["vesting_6_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 6;
									}
									if($vesting_arr[7]["vesting_7_arr"][$index_for_vesting]>0)
									{
										$last_not_null_vesting_index = 7;
									}
									
									?>
                                    <table id="example" class="table tablep border  ">
                                        <thead>
                                            <tr>
                                                <th>Vestings</th>
                                                <th>%age of Vestings</th>
                                                <th><?php if($rule_dtls["lti_linked_with"]=="Stock Value"){echo "Shares";}else{echo "Amount";} ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            	
                                            <tr>
                                                <td>Vesting - 1</td>
                                                <td class="txtalignright">
													<?php $v1_per = 0; 
                                                    if($vesting_arr[1]["vesting_1_arr"][$index_for_vesting])
													{ $v1_per = $vesting_arr[1]["vesting_1_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v1_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright">
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v1_per, 1, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vesting - 2</td>
                                                <td class="txtalignright">
													<?php $v2_per = 0; 
                                                    if($vesting_arr[2]["vesting_2_arr"][$index_for_vesting])
													{ $v2_per = $vesting_arr[2]["vesting_2_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v2_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright">
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v2_per, 2, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vesting - 3</td>
                                                <td class="txtalignright">
													<?php $v3_per = 0; 
                                                    if($vesting_arr[3]["vesting_3_arr"][$index_for_vesting])
													{ $v3_per = $vesting_arr[3]["vesting_3_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v3_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright">
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v3_per, 3, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vesting - 4</td>
                                                <td class="txtalignright">
													<?php $v4_per = 0; 
                                                    if($vesting_arr[4]["vesting_4_arr"][$index_for_vesting])
													{ $v4_per = $vesting_arr[4]["vesting_4_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v4_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright">
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v4_per, 4, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vesting - 5</td>
                                                <td class="txtalignright">
													<?php $v5_per = 0; 
                                                    if($vesting_arr[5]["vesting_5_arr"][$index_for_vesting])
													{ $v5_per = $vesting_arr[5]["vesting_5_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v5_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright">
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v5_per, 5, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vesting - 6</td>
                                                <td class="txtalignright">
													<?php $v6_per = 0; 
                                                    if($vesting_arr[6]["vesting_6_arr"][$index_for_vesting])
													{ $v6_per = $vesting_arr[6]["vesting_6_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v6_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright"> 
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v6_per, 6, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vesting - 7</td>
                                                <td class="txtalignright">
													<?php $v7_per = 0; 
                                                    if($vesting_arr[7]["vesting_7_arr"][$index_for_vesting])
													{ $v7_per = $vesting_arr[7]["vesting_7_arr"][$index_for_vesting];}
													echo HLP_get_formated_percentage_common($v7_per); ?>
                                                    %
                                                </td>
                                                <td class="txtalignright"> 
													<?php $val = get_share_or_amtount_for_lti_vestings($emp_lti_dtls["final_incentive"], $v7_per, 7, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $rule_dtls["lti_linked_with"]);
														$total_incentive_befor_last += $val;
														echo $currency_type . HLP_get_formated_amount_common(($val)); ?>
                                                </td>
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
<?php
function get_share_or_amtount_for_lti_vestings($incentive, $per, $current_index, $last_not_null_vesting_index, $total_incentive_befor_last, $stock_share_price, $lti_linked_with)
{
	if($lti_linked_with=="Stock Value")
	{
		if($current_index == $last_not_null_vesting_index)
		{
			return round(($incentive/$stock_share_price) - $total_incentive_befor_last);
		}
		$vest_amt = ($incentive*$per)/100;
		return round($vest_amt/$stock_share_price);
	}
	else
	{
		if($current_index == $last_not_null_vesting_index)
		{
			return round($incentive - $total_incentive_befor_last);
		}
		return round(($incentive*$per)/100);
	}	
}
?>

<script>
     $('#showteam').hide();
$('.closeClick').click(function() {
	if ($('.left-md').hasClass('col-md-4')) {
		$('.left-md').hide();
                 $('#showteam').show();
		$('.left-md').removeClass('col-md-4');
		$('.right-md').removeClass('col-md-8').addClass('col-md-12');
	} else {
		$('.left-md').show();
		$('.left-md').addClass('col-md-4');
		$('.right-md').removeClass('col-md-12').addClass('col-md-8');
	}
});
function showteam()
{
     $('#showteam').hide();
     $('.left-md').addClass('col-md-4');
     if ($('.right-md').hasClass('col-md-12')) {
		
        $('.right-md').removeClass('col-md-12');
        $('.right-md').removeClass('col-md-12').addClass('col-md-8');
	}
     $('.left-md').show();
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