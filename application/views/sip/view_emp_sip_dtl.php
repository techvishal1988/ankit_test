
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

#emplist.table tr th:nth-child(1){width:150px !important;}
#emplist.table tr th:nth-child(3){width:100px !important;}

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

                             $rule_id = $rule_dtls["id"];
                             $prev_record_manager_email = "";
                             $pk_ids = array();

                             foreach($staff_list as $row)
                             {
                                if($row["status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
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
            <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>" style=" position: absolute;  margin-left: 46%;  margin-top: 13px;" href="<?php echo site_url("manager/send-sip-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')">
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
									 <th>Employee Name</th>
									 


                                    <th>Incentive Amount</th>
                                    <th>Incentive <br>Percentage</th>
                                </tr>
                                </thead>
                                <tbody>
                                	<?php

                                        foreach($staff_list as $row){?>
                                    <tr>

					<?php if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side)){?>
                                            <td><a href='<?php echo site_url("manager/view-employee-sip-dtls/".$row["rule_id"]."/".$row["user_id"]); ?>'><?php echo $row["emp_name"]; ?></a></td>
                                        <?php } else {?>
                                            <td><a href='<?php echo site_url("view-employee-sip-dtls/".$row["rule_id"]."/".$row["user_id"]); ?>'><?php echo $row["emp_name"]; ?></a></td>
                                        <?php } ?>


                                       
                                        <td style="min-width: 100px;"><?php echo $row["currency"]; ?>&nbsp;<?php echo HLP_get_formated_amount_common($row["final_sip"]); ?></td>
                                            <!--<td><?php echo $row['last_manager_name'] ?></td>-->
                                        <!-- <td><?php //echo $row['actual_sip_per'] ?>%</td> -->
                                        <td>
										 <?php echo $row["final_sip_per"]; ?>%
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
                    	
                        <?php $dis_cls = 'disabled="disabled"'; if($this->session->userdata('is_manager_ses') == 1 && $rule_dtls["status"]==6 && strtolower($sip_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side)){ $dis_cls = ""; }?>
                        <form class="frm_cstm_popup_cls_sip_dtl" method="post" action="">
                        	<?php echo HLP_get_crsf_field();?>

							<?php
							$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
							foreach($managers_arr as $key => $value)
							{
							  if(strtolower($this->session->userdata('email_ses')) == strtolower($value[0]))
							  {
								$manager_tot_bdgt = $value[1] + (($value[1]*$value[2])/100);
								echo "<span><b class='tot_bug'> Total Budget : " . HLP_get_formated_amount_common($manager_tot_bdgt)."</b></span>";
								$used_budget = 0;//HLP_get_managers_emps_total_budget_sip($rule_dtls['id'], strtolower($value[0]));
								//echo  "<span><b class='avl_bug'> Available Budget : ".HLP_get_formated_amount_common($manager_tot_bdgt - $used_budget). "</b></span>";
								echo  "<span><b class='avl_bug'> Available Budget : 0</b></span>";
								break;
							  }
							}
							?>
                        	<h3><span style="font-weight:bold;color:#F00; font-size:20px;"><?php echo $sip_dtls["emp_name"]; ?>, <?php echo $sip_dtls["designation"]; ?></span></h3>

                            <div class="row darkOverlay">
                                <div class="col-md-12">
                                    <div class="dark-box">
                                	<div class="row">

                                        <div class="col-md-5">
                                            <h2>
                                                Target <?php echo CV_BONUS_SIP_LABEL_NAME; ?>
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>
                                                <?php echo $sip_dtls["currency"]; ?> <?php echo HLP_get_formated_amount_common($sip_dtls["target_sip"]); ?>
                                            </h2>
                                      </div>
                                      </div>
                                     </div>
                                     <?php /*?><div class="clearfix"></div>
                                    <div class="dark-box">
                                     <div class="row">
                                        <div class="col-md-5">
                                            <h2>
                                                 Individual Achievement %
                                            </h2>
                                         </div>
                                        <div class="col-md-7">
                                            <h2>

												<?php 
													if($sip_dtls["performance_achievement"]){echo $sip_dtls["performance_achievement"].'%';}else{echo "-----";} ?>
                                            </h2>
                                         </div>
                                     </div>
                                    </div><?php */?>
                                     <div class="clearfix"></div>
                                    <div class="dark-box">
                                     <div class="row">
                                        <div class="col-md-5">
                                            <h2 style="margin-top:7px;">
                                                Final <?php echo CV_BONUS_SIP_LABEL_NAME; ?>
                                            </h2>
                                         </div>
                                        <div class="col-lg-7">
                                            <div class="row">
                                             <div class="col-md-12">
                                                 <h2 style="margin-bottom: 0px;">
                                                     <span style="width:100%;position: absolute; padding: 9px; width: 50px;text-align: center;  color: #000; font-size: 16px;"><?php echo $sip_dtls["currency"]; ?></span>
													 <input style="width:48%; margin-right:2%; padding: 6px 43px!important;"  type="text" class="form-control " value="<?php echo round($sip_dtls["final_sip"]); ?>" placeholder="Enter your Amount" name="txt_target_sip_amt" id="txt_target_sip_amt" maxlength="12" required onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9); manage_target_sip('1')" <?php echo $dis_cls; ?>>

                                                    <span style="width:100%;position: absolute; margin-top:9px; color: #000; background-color: transparent; font-size: 16px; margin-left: 68px;">% of Target </span>
                                                    <input style="width:48%;" type="text" class="form-control" value="<?php echo $sip_dtls["final_sip_per"]; ?>" placeholder="Enter your Percentage" name="txt_target_sip_per" id="txt_target_sip_per" maxlength="7" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3); manage_target_sip('2')" <?php echo $dis_cls; ?>>


                                                </h2>
                                             </div>
                                             <?php /*?><div class="col-md-12" style="display: none;">
                                                <h2 style="margin-bottom: 3px;">

                                                   <span style="width:100%;position: absolute; margin-top:9px; color: #000; background-color: transparent; font-size: 16px; margin-left: 68px;">% of Target  <?php echo CV_BONUS_SIP_LABEL_NAME; ?> </span>
                                                    <input style="width:275px;" type="text" class="form-control" value="<?php echo $sip_dtls["final_sip_per"]; ?>" placeholder="Enter your Percentage" name="txt_target_sip_per" id="txt_target_sip_per" maxlength="7" required onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3); manage_target_sip('2')" <?php echo $dis_cls; ?>>


                                                </h2>
                                             </div><?php */?>

                                         </div>
                                         </div>
                                     </div>



                                     </div>

                                    <div class="row">
                                     <?php if($this->session->userdata('is_manager_ses') == 1 && $rule_dtls["status"]==6 && strtolower($sip_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses')) and isset($is_open_frm_manager_side)){?>
                                            <div class="col-sm-offset-5 col-sm-7 text-right">
                                                <button style="width:50%; font-size:15px;  height: 38px" type="submit" class="btn btn-primary" onclick="return request_custom_confirm('frm_cstm_popup_cls_sip_dtl');">Recommend</button>
                                                <input type="hidden" name="hf_emp_sip_id" id="hf_emp_sip_id" value="<?php echo $sip_dtls["id"]; ?>" />
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
                                                <th style="vertical-align: middle;">Linked to <br>Performance of</th>
                                                <th style="vertical-align: middle;">Weighting</th>
                                                <th style="vertical-align: middle;">Actual<br> Achievement</th>
                                                <th style="vertical-align: middle;">Weighted Average<br> Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_weighted_avg_score=0;
											$emp_weightage_achievement_dtls = json_decode($sip_dtls["emp_weightage_achievement_dtls"], true);
											foreach($emp_weightage_achievement_dtls as $ewa_row)
											{ ?>											
												<tr>
													<td><?php echo $ewa_row["n"]; ?></td>
													<td class="txtalignright"><?php echo $ewa_row["w"]; ?>%</td>
													<td class="txtalignright"><?php echo $ewa_row["a"]; ?>%</td>
													<td><?php
														$avg_score=HLP_get_formated_percentage_common(($ewa_row["w"]*$ewa_row["a"])/100);
														$total_weighted_avg_score += $avg_score;
														echo $avg_score; ?>%</td>
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

function manage_target_sip(targeted_by)
{
	var target_sip = '<?php echo $sip_dtls["target_sip"]; ?>';
    var txt_per_val = $.trim($("#txt_target_sip_per").val());
	var txt_amt_val = $.trim($("#txt_target_sip_amt").val());

	if(targeted_by == 1)
	{
		$("#txt_target_sip_per").val(get_formated_percentage_common((txt_amt_val/target_sip)*100));
	}
	else
	{
		$("#txt_target_sip_amt").val(Math.round(((txt_per_val*target_sip)/100)));
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
