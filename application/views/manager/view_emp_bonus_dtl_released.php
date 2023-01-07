
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
::-webkit-scrollbar
{
  width: 12px;  /* for vertical scrollbars */
  height: 12px; /* for horizontal scrollbars */
}
::-webkit-scrollbar-track
{
  background: rgba(0, 0, 0, 0.1);
}
::-webkit-scrollbar-thumb
{
    background: rgba(0, 0, 0, 0.3);
    border-radius: 8px;
}
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
    font-family: 'Roboto';
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
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    font-weight: 400;
    margin: 0 0 10px 0;
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
@media screen and (max-width: 767px) {
    .table-responsive {
        border: 0;
}
}

.darkOverlay input {
	/*background-color: rgba(255,255,255,0.2);*/
}
</style>
<?php /*?><div class="page-title">
    <div class="container">
        <div class="page-title-heading">
            <h3>Salary Review for <?php echo $bonus_dtls["name"]; ?>, <span style="font-size:12px;">(<?php echo $bonus_dtls["current_designation"]; ?>)</span></h3>
        </div>
        <div class="page-title-controls">
            <ul>
               
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div><?php */?>
<section class="team bodybg">
    <div class="container">
        <div class="row">
            <?php 
            
           /* function searchForId($id, $array) {
                    foreach ($array as $key => $val) {
                        if ($val['id'] === $id) {
                            return $array[$key];
                        }
                    }
                    return null;
                 }*/
            
            //echo '<pre />'; print_r($staff_list);
            
                //print_r($manager_staf_list);
                 /*if(isset($manager_staf_list))
                 {
                        $arr=[];
                        foreach($manager_staf_list as $msl)
                        {
                            array_push($arr,searchForId($msl['id'],$staff_list));
                        }
                        //print_r($arr);
                        $staff_list=$arr;
                 }*/
                
                
                
                ?>
        	<?php $expand_cls = 12; if(count($staff_list)>0){
                    $expand_cls = 8; 
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
//                             echo '<pre />';
//                             print_r($staff_list); die;
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
             
            
            <div class="col-md-4 left-md" <?php echo @$cls ?>>
                <div class="leftTeamArea whiteBlock">
                   <?php /*?> <?php if($is_enable_approve_btn == 1 and $this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>
            <a style="    position: absolute;  margin-left: 46%;  margin-top: 13px;" href="<?php echo site_url("manager/send-bonus-for-next-level/".$rule_id); ?>" onclick="return confirm('Are you sure, You want?')">
                        <input type="button" class="btn btn-twitter m-b-sm add-btn" value="Submit For Next Level" id="btnSave" />
                    </a>
              <?php } ?><?php */?>
                    <div class="leftTop">
                        <p>My Team <!--<span class="badge"><?php echo count($staff_list); ?></span> -->
                            
                            <span class="pull-right closeClick" ><i class="fa fa-times"></i></span></p>
                    </div><!--.leftTop-->
                    <?php //echo '<pre />'; print_r($staff_list); ?>
                    <div class="leftBottom">
                        <div class="table-responsive">          
                            <table class="table" id="emplist">
                                <thead>
                                <tr>
                                    <th>Employee <!--<i class="fa fa-long-arrow-up"></i>--></th>
                                    <th>Rating</th>
                                    <th>Amount</th>
                                    <!--<th>Manager</th>-->
                                    <th>Bonus %</th>
                                    <th>Manager Bonus %</th>
                                </tr>
                                </thead>
                                <tbody>
                                	<?php
                                        
                                        foreach($staff_list as $row){?>
                                    <tr>                                        
					<?php if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>	
                                            <td><a href='<?php echo site_url("manager/view-employee-bonus-increments-released/".$row["rule_id"]."/".$row["id"]); ?>'><?php echo $row["name"]; ?></a></td>										
                                        <?php } else {?>
                                            <td><a href='<?php echo site_url("view-employee-bonus-increments-released/".$row["rule_id"]."/".$row["id"]); ?>'><?php echo $row["name"]; ?></a></td>
                                        <?php } ?>
                                        
                                            
                                        
                                        <td><?php echo $row['performance_rating'] ?></td>
                                        <td><?php if($row["currency_type"]){echo $row["currency_type"];}else{echo "$";} ?> <?php echo HLP_get_formated_amount_common($row["final_bonus"]); ?></td>
                                            <!--<td><?php echo $row['last_manager_name'] ?></td>-->
                                        <td><?php echo $row['actual_bonus_per'] ?>%</td>
                                        <td>
										<?php /*?><img src="<?php echo base_url("images/down.png"); ?>"><?php */?> <?php echo $row["final_bonus_per"]; ?>%
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
            <div class="col-md-<?php echo $expand_cls; ?> right-md<?php //if(count($staff_list)>0){echo "8";}else{echo "12";}?> <?php echo @$offsetcls ?>">
                <div class="rightTeamArea transparentBlock">
                    <?php /*?><div class="rightTop whiteBlock">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="whiteOverlay">
                                    <h2>Target Bonus</h2>
                                    <p>$ <?php echo number_format($bonus_dtls["target_bonus"], 0, '.', ','); ?></p>
                                </div><!--.whiteOverlay-->
                            </div><!--.col-md-6-->
                            <div class="col-md-6">
                                <div class="whiteOverlay">
                                    <h2>Performance Rating</h2>
                                    <p><?php if($bonus_dtls["performnace_rating"]){echo $bonus_dtls["performnace_rating"];}else{echo "-----";} ?></p>
                                </div><!--.whiteOverlay-->
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><!--.rightTop-->
                    <div class="rightCenterOne">
                        <div class="row">
                            <div class="col-md-6 pdr0">
                                <div class="lessWhiter">
                                    <h3>Business Level -1</h3>
                                    <p><?php echo $bonus_dtls["bl_1_name"]; ?></p>
                                    <br>
                                    <p>Weighting - <span><?php echo $bonus_dtls["bl_1_weightage"]; ?>%</span></p>
                                    <p>Actual Achievement - <span><?php echo $bonus_dtls["bl_1_achievement"]; ?>%</span></p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                            <div class="col-md-6">
                                <div class="lessWhiter">
                                    <h3>Business Level -2</h3>
                                    <p><?php echo $bonus_dtls["bl_2_name"]; ?></p>
                                    <br>
                                    <p>Weighting - <span><?php echo $bonus_dtls["bl_2_weightage"]; ?>%</span></p>
                                    <p>Actual Achievement - <span><?php echo $bonus_dtls["bl_2_achievement"]; ?>%</span></p>
                                </div><!--.lessWhiter-->     
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><!--.rightCenterOne-->
                    <div class="rightCenterTwo">
                        <div class="row">
                            <div class="col-md-6 pdr0">
                                <div class="lessWhiter">
                                    <h3>Business Level -3</h3>
                                    <p><?php echo $bonus_dtls["bl_3_name"]; ?></p>
                                    <br>
                                    <p>Weighting - <span><?php echo $bonus_dtls["bl_3_weightage"]; ?>%</span></p>
                                    <p>Actual Achievement - <span><?php echo $bonus_dtls["bl_3_achievement"]; ?>%</span></p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                            <div class="col-md-6">
                                <div class="lessWhiter">
                                    <h3>Individual</h3>
                                    <p><?php echo $bonus_dtls["individual_name"]; ?></p>
                                    <br>
                                    <p>Weighting - <span><?php echo $bonus_dtls["individual_weightage"]; ?>%</span></p>
                                    <p>Actual Achievement - <span><?php echo $bonus_dtls["individual_achievement"]; ?>%</span></p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><!--.rightCenterTwo--><?php */?>
                    
                    <?php /*?><div class="rightBottom whiteBlock">
                        <h3>Recommended Bonus Multiplier / Amount</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="darkOverlay">
                                    <h2>Target Bonus Amount</h2>
                                    <p class="hide-element1">$ <?php echo number_format($bonus_dtls["final_bonus"], 0, '.', ','); ?></p>
                                    <div class="show-element1">
                                        <div class="form-inline">
                                        	
                                            <input type="text" class="form-control" value="<?php echo $bonus_dtls["final_bonus"]; ?>" placeholder="Enter your Amount" name="txt_target_bonus_amt" id="txt_target_bonus_amt" maxlength="10" required onKeyUp="validate_onkeyup_dec(this);" onBlur="validate_onblure_dec(this);">
                                            <input type="hidden" name="hf_emp_bonus_amt" id="hf_emp_bonus_amt" value="<?php echo $bonus_dtls["final_bonus"]; ?>" />
                                            <button type="button" onclick="update_emp_bonus_dtls('1')" class="btn btn-primary save-link1">Save</button>
                                            <button type="button" class="btn btn-primary cancel-link1">Cancel</button>
                                        </div>
                                    </div>
                                    <?php if($this->session->userdata('role_ses') == 10 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
                                    	<input type="hidden" name="hf_emp_bonus_id" id="hf_emp_bonus_id" value="<?php echo $bonus_dtls["id"]; ?>" />
                                    	<p class="text-right lessFont"><img class="edit-link1" src="<?php echo base_url("assets/images/edit.png"); ?>" alt="edit"></p>
                                    <?php } ?>
                                </div><!--.darkOverlay-->
                            </div><!--.col-md-6-->
                            <div class="col-md-6">
                                <div class="darkOverlay">
                                    <h2>Target Bonus Percentage</h2>
                                    <p class="hide-element2"><?php echo $bonus_dtls["final_bonus_per"]; ?>%</p>
                                    <div class="show-element2">
                                        <div class="form-inline">
                                            <input type="text" class="form-control" value="<?php echo round($bonus_dtls["final_bonus_per"]); ?>" placeholder="Enter your Percentage" name="txt_target_bonus_per" id="txt_target_bonus_per" maxlength="5" required onKeyUp="validate_onkeyup_dec(this);" onBlur="validate_onblure_dec(this);">
                                            <input type="hidden" name="hf_emp_bonus_per" id="hf_emp_bonus_per" value="<?php echo round($bonus_dtls["final_bonus_per"]); ?>" />
                                            <button type="button" onclick="update_emp_bonus_dtls('2')" class="btn btn-primary save-link2">Save</button>
                                            <button type="button" class="btn btn-primary cancel-link2">Cancel</button>
                                        </div>
                                    </div>
                                    <?php if($this->session->userdata('role_ses') == 10 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
                                    	<p class="text-right lessFont"><img class="edit-link2" src="<?php echo base_url("assets/images/edit.png"); ?>" alt="edit"></p>
                                    <?php } ?>
                                </div><!--.darkOverlay-->
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><?php */?>
                    
                    
                    <div class="rightBottom whiteBlock">
                        <button class="btn btn-primary btn-xs" type="button" id="showteam" onclick="showteam()">Show Team</button>
                    	<?php echo $this->session->flashdata('message'); ?>
                        <?php $dis_cls = 'disabled="disabled"'; if($this->session->userdata('is_manager_ses') == 1 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side)){ $dis_cls = ""; }?>
                        <form method="post" action="">
                        	<h3><!--<span style="font-weight:bold;">Recommended Bonus For : </span>--> <span style="font-weight:bold;color:#F00; font-size:16px;"><?php echo $bonus_dtls["name"]; ?>, <?php echo $bonus_dtls["current_designation"]; ?></span></h3>
                        
                            <div class="row darkOverlay">
                                <div class="col-md-10">
                                	<div class="row">
                                        <div class="col-md-5">
                                            <h2>
                                                Target Bonus
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>
                                                <?php if($bonus_dtls["currency_type"]){echo $bonus_dtls["currency_type"];}else{echo "$";} ?> <?php echo HLP_get_formated_amount_common($bonus_dtls["target_bonus"]); ?>
                                            </h2>
                                         </div>
                                          <div class="clearfix"></div>
                                        <div class="col-md-5">
                                            <h2>
                                                Performance Rating
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>
                                                <?php if($bonus_dtls["performnace_rating"]){echo $bonus_dtls["performnace_rating"];}else{echo "-----";} ?> 
                                            </h2>
                                         </div>
                                     </div>
                                     <div class="clearfix"><br /></div>
                                    <div class="row">
                                        <div class="col-md-5" style="margin-top:10px;">
                                            <h2>
                                                Recommended Bonus
                                            </h2>
                                         </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                             <div class="col-md-12">
                                                 <h2>
                                                     <span style="width:100%;position: absolute; padding: 9px;  border-right: solid #555 1px; width: 50px;text-align: center;  color: #555;"><?php if($bonus_dtls["currency_type"]){echo $bonus_dtls["currency_type"];}else{echo "$";} ?></span> <input style="padding: 6px 55px!important;"  type="text" class="form-control " value="<?php echo round($bonus_dtls["final_bonus"]); ?>" placeholder="Enter your Amount" name="txt_target_bonus_amt" id="txt_target_bonus_amt" maxlength="12" required onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9); manage_target_bonus('1')" <?php echo $dis_cls; ?>>
                                                </h2>
                                             </div>
                                             <div class="col-md-12">
                                                <h2>
                                                    <span style="width:100%;position: absolute; padding: 9px;  border-right: solid #555 1px; width: 50px; text-align: center; color: #555;">%</span><input style=" padding: 6px 55px!important;"  type="text" class="form-control" value="<?php echo $bonus_dtls["final_bonus_per"]; ?>" placeholder="Enter your Percentage" name="txt_target_bonus_per" id="txt_target_bonus_per" maxlength="7" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3); manage_target_bonus('2')" <?php echo $dis_cls; ?>>
                                                    <span style="color: gray;font-size: 13px;">Of Target Bonus</span>
                                                </h2> 
                                             </div>                                   
                                            </div>
                                         </div>
                                        
                                        <?php if($this->session->userdata('is_manager_ses') == 1 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side)){?>
                                            <div class="col-md-1">
                                                <?php /*?><button style="margin-top:22px; margin-left:30px;" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure ?');">Recommend</button><?php */?>
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
                                    
                                    <table id="example" class="table border  ">
                                        <thead>
                                            <tr>
                                                <th>Business Level</th>
                                                <th>Business Name</th>
                                                <th>Weighting</th>
                                                <th>Actual Achievement</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            <?php if(round($bonus_dtls["bl_1_weightage"])!=0 && round($bonus_dtls["bl_1_achievement"])!=0) { ?>                                            
                                            <tr>
                                                <td>Business Level -1</td>
                                                <td><?php echo $bonus_dtls["bl_1_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_1_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_1_achievement"]; ?>%</td>
                                            </tr>
                                                <?php } ?>
                                            <?php if(round($bonus_dtls["bl_2_weightage"])!=0 && round($bonus_dtls["bl_2_achievement"])!=0) { ?>
                                            <tr>
                                                <td>Business Level -2</td>
                                                <td><?php echo $bonus_dtls["bl_2_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_2_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_2_achievement"]; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["bl_3_weightage"])!=0 && round($bonus_dtls["bl_3_achievement"])!=0) { ?>
                                            <tr>
                                                <td>Business Level -3</td>
                                                <td><?php echo $bonus_dtls["bl_3_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_3_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["bl_3_achievement"]; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["function_weightage"])!=0 && round($bonus_dtls["function_achievement"])!=0) { ?>
                                            <tr>
                                                <td>Function</td>
                                                <td><?php echo $bonus_dtls["function_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["function_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["function_achievement"]; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(round($bonus_dtls["individual_weightage"])!=0 && round($bonus_dtls["individual_achievement"])!=0) { ?>
                                            <tr>
                                                <td>Individual</td>
                                                <td><?php echo $bonus_dtls["individual_name"]; ?></td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["individual_weightage"]; ?>%</td>
                                                <td class="txtalignright"><?php echo $bonus_dtls["individual_achievement"]; ?>%</td>
                                            </tr>
                                            <?php } ?>
                                            
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
	if ($('.left-md').hasClass('col-md-4')) {
		$('.left-md').hide();
		$('.left-md').removeClass('col-md-4');
                $('#showteam').show();
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
		$("#txt_target_bonus_per").val(get_formated_percentage_common((txt_amt_val/target_bonus)*100,2));
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
<?php /*?> <?php if($this->session->userdata('role_ses') == 10 && $bonus_dtls["rule_status"]==6 && strtolower($bonus_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
<script >

$('.edit-link1').click(function(){
	$('.edit-link1').hide();
	$('.hide-element1').hide();
	$('.show-element1').show();
});
$('.edit-link2').click(function()
{
	$('.edit-link2').hide();
	$('.hide-element2').hide();
	$('.show-element2').show();
});
$('.cancel-link1').click(function()
{
	$('.edit-link1').show();
	$('.hide-element1').show();
	$('.show-element1').hide();
});
$('.cancel-link2').click(function()
{
	$('.edit-link2').show();
	$('.hide-element2').show();
	$('.show-element2').hide();
});
$('.save-link1').click(function()
{
	$('.edit-link1').show();
	$('.hide-element1').show();
	$('.show-element1').hide();
});
$('.save-link2').click(function()
{
	$('.edit-link2').show();
	$('.hide-element2').show();
	$('.show-element2').hide();
});

function update_emp_bonus_dtls(typ)
{
	// <?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
		// alert("You do not have update inrements rights.");
		// return false;
	<?php } ?> 
	
	var emp_bonus_id = $.trim($("#hf_emp_bonus_id").val());
	var txt_per_val = $.trim($("#txt_target_bonus_per").val());
	var txt_amt_val = $.trim($("#txt_target_bonus_amt").val());
	var hf_per_val = $.trim($("#hf_emp_bonus_per").val());
	var hf_amt_val = $.trim($("#hf_emp_bonus_amt").val());	
	
	var txt_val = txt_amt_val;
	var hf_val = hf_amt_val;
	if(typ=='2')
	{
		txt_val = txt_per_val;
		hf_val = hf_per_val;
	}

	if((txt_val) && emp_bonus_id>0 && txt_val != hf_val)
	{
		$.post("<?php echo site_url("manager/dashboard/update_emp_bonus_dtls"); ?>",{"emp_bonus_id":emp_bonus_id, "new_val" : txt_val, 'type':typ},function(data)
		{
		   if(data)
		   {
			   var response = JSON.parse(data);
			   $("#txt_name").val(response.emp_name);
			   if(response.status)
			   {
					$("#txt_target_bonus_per").val(response.new_per);
					$("#txt_target_bonus_amt").val(response.increased_bonus);
					$("#hf_emp_bonus_per").val(response.new_per);
					$("#hf_emp_bonus_amt").val(response.increased_bonus);
					$('.hide-element1').html(response.increased_bonus);
			   }
			   else
			   {
				    if(typ=='2')
					{
						$("#txt_target_bonus_per").val($("#hf_emp_bonus_per").val());
					}
					else
					{
						$("#txt_target_bonus_amt").val($("#hf_emp_bonus_amt").val());
					}
				   alert(response.msg);
			   }
		   }
		   else
		   {
			    if(typ=='2')
				{
					$("#txt_target_bonus_per").val($("#hf_emp_bonus_per").val());
				}
				else
				{
					$("#txt_target_bonus_amt").val($("#hf_emp_bonus_amt").val());
				}
		   }
		 });
	}
	else
	{
		if(typ=='2')
		{
			$("#txt_target_bonus_per").val($("#hf_emp_bonus_per").val());
		}
		else
		{
			$("#txt_target_bonus_amt").val($("#hf_emp_bonus_amt").val());
		}
	}
	
	if(typ=='2')
	{
		$(".cancel-link2" ).click();
	}
	else
	{
		$(".cancel-link1" ).click();
	}
	
}
</script>
<?php } ?><?php */?>

