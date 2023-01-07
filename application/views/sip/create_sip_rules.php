<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
.weblik-cen2{text-align:-webkit-center;}
.weblik-cen2 input{margin-bottom: 0px !important;  text-align: center;}
.fstElement:foucs {
box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses");
?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses");
?>!important;
}
.fstChoiceItem {
background-color:#<?php echo $this->session->userdata("company_color_ses");
?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses");
?>!important;
  font-size:1em;
}
.fstResultItem {
  font-size:1em;
}
.fstResultItem.fstFocused, .fstResultItem.fstSelected {
background-color:#<?php echo $this->session->userdata("company_color_ses");
?>!important;
border-top-color:#<?php echo $this->session->userdata("company_light_color_ses");
?>!important;
}
.fstControls {
  line-height:17px;
}
/*.rule-form .form-control{height:32px !important;}
.rule-form .control-label{line-height:32px !important;}*/
.sip-params {
  width: 88px;
}
.performance-ranges {
  width:100%;
  margin-bottom:0px;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
.form_head ul {
  padding:0px;
  margin-bottom:0px;
}
.form_head ul li {
  display:inline-block;
}
.rule-form .control-label {
  font-size: 12px;
  line-height: 30px;
}
.rule-form .form-control {
  height: 30px;
  margin-top: 0px;
  font-size: 12px;
  background-color: #FFF;
  margin-bottom:10px;
}
.rule-form .control-label {
  font-size: 12px;
 <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?> background-color: #<?php echo $this->session->userdata("company_light_color_ses");
?>;
  margin-bottom:10px;
}
.rule-form .form-control:focus {
  box-shadow: none!important;
}
.rule-form .form_head {
  background-color: #f2f2f2;
 <?php /*?>border-top: 8px solid #93c301;<?php */?> border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
?>;
}
.rule-form .form_head .form_tittle {
  display: block;
  width: 100%;
}
.rule-form .form_head .form_tittle h4 {
  font-weight: bold;
  color: #000 !important;
  text-transform: uppercase;
  margin: 0;
  padding: 12px 0px;
  margin-left: 5px;
}
.rule-form .form_head .form_info {
  display: block;
  width: 100%;
  text-align: center;
}
.rule-form .form_head .form_info i {
  /*color: #8b8b8b;*/
  font-size: 24px;
  padding: 7px;
  margin-top: -4px;
}
.rule-form .form_sec {
  background-color: #f2f2f2;
  display: block;
  width: 100%;
  padding: 5px 0px 9px 0px;
  border-bottom-left-radius: 0px;
  border-bottom-right-radius: 0px;
}
.rule-form .form_info .btn-default {
  border: 0px;
  padding: 0px;
  background-color: transparent!important;
}
.rule-form .form_info .tooltip {
  border-radius: 6px !important;
}
.mar10 {
  margin-bottom: 10px !important;
}
.form-group {
  margin-bottom: 10px;
}
.mailbox-content, .panel-white {
  padding-bottom: 2px;
}
.paddg {
0px 20px;
}

.alert
{
  margin-bottom: -10px !important;
  margin-top: -5px !important;
}

/***added to center align the form head text****/
.form_head.center_head{border-bottom: 0px; margin-bottom: 10px;}
.form_head.center_head ul{text-align: center;}
.form_head.center_head ul .form_tittle h4{padding: 0px;}
.form_head.center_head ul .form_tittle h4 p{margin:0px;font-size: 16px;font-weight: bold; text-transform: uppercase;}
.form_head.center_head ul .form_tittle h4 span{font-size: 12px; color: #3e3d3d;}
/***added to center align the form head text****/

 /********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/

</style>
<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo site_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
	<li><a href="<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]); ?>">Rule List</a></li>
	<li><a href="<?php echo site_url("sip-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Rule Filter</a></li>
    <li class="active"><?php echo CV_BONUS_SIP_LABEL_NAME; ?> Rules</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row" id="dv_step_1">
    <div class="col-md-12" id="dv_partial_page_data">
      <div class="mb20">
        <div class="mailbox-content">
          <div class="">
            <div class="row">
              <div class="col-sm-12">
                <?php
             $tooltip=getToolTip('sip-rule-page-2');
             $rule_val=json_decode($tooltip[0]->step);
                ?>
                <?php if($emp_not_any_cycle_counts > 0 or $this->session->flashdata('message')){?>
                <div class="msgtxtalignment">
                  <?php
                      if(@$this->session->flashdata('message')) {
                        echo '<div class="msg-left cre_rule">';
                          echo $this->session->flashdata('message');
                        echo '</div>';
                        echo '<div  class="msg-right cre_rule">';
                          echo "<span style='color:red;'>". $emp_not_any_cycle_counts. " employee(s) under your responsibility are not covered under in rule as yet <a href='". site_url("sip/emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";
                        echo '</div>';
                      } else {
                        echo "<span class='cre_rule' style='color:red;'>". $emp_not_any_cycle_counts. " employee(s) under your responsibility are not covered under in rule as yet <a href='". site_url("sip/emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";
                      }
                    ?>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="rule-form">
              <form id="frm_rule_step1"  method="post" action="<?php echo site_url('save-sip/'.$rule_dtls['id'].'/1'); ?>" onsubmit="return set_rules(this);">
                <?php echo HLP_get_crsf_field();?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form_head center_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4><?php echo CV_BONUS_SIP_LABEL_NAME; ?></h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $rule_val[0] ?>"><i style="font-size: 20px;" class="themeclr fa fa-info-circle" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
                        <div class="col-sm-12 padr0">
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label"><?php echo CV_BONUS_SIP_LABEL_NAME; ?> Rule Name</label>
                          </div>
                          <div class="col-sm-6 ">
                            <input type="text" name="txt_rule_name" value="<?php echo $rule_dtls["sip_rule_name"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Recurring plan</label>
                          </div>
                          <div class="col-sm-6 ">
                            <select class="form-control"name="ddl_recurring_plan"  onchange="recurringPlanChange(this)" required>
                              <option value="1" <?php if($rule_dtls['recurring_plan'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                              <option value="0" <?php if($rule_dtls['recurring_plan'] == '0'){ echo 'selected="selected"'; } ?> >No</option>
                            </select>
                          </div>
                          <div id="recurring_plan_wrapper" <?php if($rule_dtls['recurring_plan'] == '0'){ echo 'style="display:none;"'; } ?> >
                            <div class="col-sm-6 removed_padding">
                              <label class="control-label">Frequency of Plan</label>
                            </div>
                            <div class="col-sm-6 ">
                              <select class="form-control" name="ddl_frequency_of_plan" required>
                                <option value="1" <?php if($rule_dtls['recurring_plan'] == '1'){ echo 'selected="selected"'; } ?>>Monthly</option>
                                <option value="2" <?php if($rule_dtls['recurring_plan'] == '2'){ echo 'selected="selected"'; } ?>>Quarterly</option>
                                <option value="3" <?php if($rule_dtls['recurring_plan'] == '3'){ echo 'selected="selected"'; } ?>>Annually</option>
                              </select>
                            </div>
                            <div class="col-sm-6 removed_padding">
                              <label class="control-label">Plan Period </label>
                            </div>
                            <div class="col-sm-6">
                              <div class="row">
                                <div class="col-sm-6">
                                  <input type="text" id="txt_plan_start_dt" name="txt_plan_start_dt" class="form-control" maxlength="10" onkeypress="return false;" onblur="checkDateFormat(this)" placeholder="Start Date" value="<?php if(isset($rule_dtls["recurr_plan_start_dt"]) && !empty($rule_dtls["recurr_plan_start_dt"]) && ($rule_dtls["recurr_plan_start_dt"] != "0000-00-00")) { echo date('d/m/Y', strtotime($rule_dtls["recurr_plan_start_dt"])); } ?>" />
                                </div>
                                <div class="col-sm-6">
                                  <input type="text" id="txt_plan_end_dt" name="txt_plan_end_dt" class="form-control" maxlength="10"  onkeypress="return false;" placeholder="End Date" onblur="checkDateFormat(this)" value="<?php if(isset($rule_dtls["recurr_plan_end_dt"]) && !empty($rule_dtls["recurr_plan_end_dt"]) && ($rule_dtls["recurr_plan_end_dt"] != "0000-00-00")) { echo date('d/m/Y', strtotime($rule_dtls["recurr_plan_end_dt"]));} ?>" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Start: prorated block -->
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Apply prorated increase calculations</label>
                          </div>
                          <div class="col-sm-6 ">
                            <select class="form-control" id="ddl_prorated_increase" name="ddl_prorated_increase" onchange="toggle_pro_rated_period();" required>
                              <option value="yes" <?php if($rule_dtls['prorated_increase'] == 'yes'){ echo 'selected="selected"'; } ?> >Simple Proration</option>
                              <option value="no" <?php if($rule_dtls['prorated_increase'] == 'no'){ echo 'selected="selected"'; } ?> >No</option>
                              <option value="fix" <?php if($rule_dtls['prorated_increase'] == 'fix'){ echo 'selected="selected"'; } ?> >Fixed %ages</option>
                            </select>
                          </div>
                          <div id="fixed_percentage_wrapper" <?php if($rule_dtls['prorated_increase'] != 'fix') echo 'style="display:none;"' ?>>
                            <div class="col-sm-6 removed_padding ">
                              <label class="control-label">Fixed %ages for a range of DOJ</label>
                            </div>
                            <div class="col-sm-6 " >
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="row" id="dv_btn_add_row_fixed_percentage">
                                    <?php
                                        $fix_per_range_doj = json_decode($rule_dtls["fix_per_range_doj"],true);
                                        $loop_cnt = 0;
                                        if(isset($fix_per_range_doj) && !empty($fix_per_range_doj)) {
                                          $ele_cnt = count($fix_per_range_doj);
                                          foreach($fix_per_range_doj as $key => $row)
                                          {
                                        ?>
                                    <div class="rv1">
                                      <div class="col-sm-3 plft0">
                                        <input type="text"  name="txt_fix_per_range_doj_min[]" class="form-control " maxlength="10"   placeholder="From Day"
                                            value="<?php echo $row['min'] ?>"
                                            <?php if($loop_cnt == 0) echo "disabled"; ?>
                                            />
                                      </div>
                                      <div class="col-sm-4 plft0">
                                        <input type="text"  name="txt_fix_per_range_doj_max[]" class="form-control " placeholder="To Day"
                                            <?php if($loop_cnt == ($ele_cnt-1)) { echo "disabled data-last='yes' value='Last Day of the month'"; } else echo "value='" . $row['max'] . "'"; ?>
                                              />
                                      </div>
                                      <div class="col-sm-3 plft0">
                                        <input type="text" name="txt_fix_per_range_doj_val[]" class="form-control txt_fixed_per" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age" value="<?php echo $row['val'] ?>" />
                                      </div>
                                      <?php if($loop_cnt == 0){ ?>
                                      <div class="col-sm-2 plft0">
                                        <button style=" margin-bottom: 10px;" type="button" class="pull-right btn btnp btn-primary btn-w60 addFixedPerAnotherRow" >ADD</button>
                                      </div>
                                      <?php } else { ?>
                                      <div class="col-sm-2 plft0" id="dv_btn_dlt_fixed_percentage">
                                        <button type="button" class="btn btnp btn-danger btn-w60" onclick="removeFixedPerRow(this);">DELETE</button>
                                      </div>
                                      <?php } ?>
                                    </div>
                                    <?php $loop_cnt++; }} else { ?>
                                    <div>
                                      <div class="col-sm-3 plft0">
                                        <input type="text"  name="txt_fix_per_range_doj_min[]" class="form-control " maxlength="10"   placeholder="From Day"
                                             value="0" disabled
                                             />
                                      </div>
                                      <div class="col-sm-4 plft0">
                                        <input type="text"  name="txt_fix_per_range_doj_max[]" class="form-control " placeholder="To Day"
                                             value="Last Day of the month" disabled
                                             data-last="yes"
                                               />
                                        <!-- txt_end_dt_fixed_per -->
                                      </div>
                                      <div class="col-sm-3 plft0">
                                        <input type="text" name="txt_fix_per_range_doj_val[]" class="form-control txt_fixed_per" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age" value="<?php if($row["Percentage"] != "0000-00-00"){ echo $row["Percentage"];;} ?>" />
                                      </div>
                                      <div class="col-sm-2 plft0">
                                        <button style=" margin-bottom: 10px;" type="button" class="pull-right btn btnp btn-primary btn-w60 addFixedPerAnotherRow" >ADD</button>
                                      </div>
                                    </div>
                                    <?php } ?>
                                  </div>
                                  <div id="add_fixed_percentage"> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- END: prorated block -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4>Step One</h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $rule_val[1] ?>"><i style="font-size:20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
					  	
						
                        <div class="col-sm-12 padr0">                          
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Target Incentive <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $rule_val[2] ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control" id="ddl_target_sip" name="ddl_target_sip" required  onchange="show_target_sip_elem();">
                              <option value="1" <?php if($rule_dtls['target_sip'] == '1'){ ?> selected="selected" <?php } ?>>% of Salary Elements</option>
                              <option value="2" <?php if($rule_dtls['target_sip'] == '2'){ ?> selected="selected" <?php } ?>>Fixed Amount</option>
                              <option value="3" <?php if($rule_dtls['target_sip'] == '3'){ ?> selected="selected" <?php } ?>>Uploaded Target Incentive</option>
                            </select>
                          </div>
                          <!--<div id="dv_target_sip_wrapper" style="display:none;">-->
                          <div id="dv_target_sip_on" style="display:none;">
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Target Incentive Linked to % of Salary Element<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6" style="margin-bottom:11px;">
                              <select id="ddl_sip_applied_elem" onchange="hide_list('ddl_sip_applied_elem');" name="ddl_sip_applied_elem[]" class="form-control multipleSelect" multiple="multiple">
                                <option  value="all">All</option>
                                <?php if($sip_applied_on_elem_list){
                                      $sip_applied_on_elements = "";
                                      if(isset($rule_dtls['sip_applied_on_elements']))
                                      {
                                        $sip_applied_on_elements = explode(",", $rule_dtls['sip_applied_on_elements']);
                                      }
                                      foreach($sip_applied_on_elem_list as $row){ ?>
                                <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($sip_applied_on_elements) and in_array($row["business_attribute_id"], $sip_applied_on_elements)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                <?php }} ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Target <?php echo CV_BONUS_SIP_LABEL_NAME; ?> based on </label>
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control" id="ddl_target_sip_on" name="ddl_target_sip_on" onchange="get_target_sip_elem();">
                              <option value="designation" <?php if($rule_dtls['target_sip_on'] == 'designation'){ ?> selected="selected" <?php } ?>>Designation</option>
                              <option value="grade" <?php if($rule_dtls['target_sip_on'] == 'grade'){ ?> selected="selected" <?php } ?>>Grade</option>
                              <option value="level" <?php if($rule_dtls['target_sip_on'] == 'level'){ ?> selected="selected" <?php } ?>>Level</option>
                            </select>
                          </div>
                          <div id="ddl_sip_parameter_wrapper">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="col-sm-6 removed_padding">
                                  <label for="" class="control-label">Add SIP Parameters </label>
                                </div>
                                <div class="col-sm-6">
                                  <select class="form-control" id="ddl_sip_parameter" name="ddl_sip_parameter" onchange="add_sip_parameter(this);">
                                    <option value="select">Select</option>
                                    <?php
                                foreach ($ba_list as $key => $ba) {
                                ?>
                                    <option value="<?php echo $ba['ba_name']; ?>"
                                  data-ba_id="<?php echo $ba['id']; ?>"
                                  data-ba_name="<?php echo $ba['ba_name']; ?>"
                                  ><?php echo $ba['display_name']; ?></option>
                                    <?php
                                  }
                                ?>
                                    <option value="Custom">Custom</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="target_sip_elem" id="dv_target_sip_elem" style="display:none; padding-right: 15px;"></div>
                        </div>
						
						<div class="col-sm-12 padr0" style="margin-top:10px;">
                          <div class="form-group">
                            <div class="col-sm-6 removed_padding">
                              <label class="control-label">Define payout approach for <?php echo CV_BONUS_SIP_LABEL_NAME; ?></label>
                            </div>
                            <div class="col-sm-6 ">
                              <select class="form-control" id="ddl_performance_achievements_multiplier"
                                            name="ddl_performance_achievements_multiplier" required>
                                <option value="1" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '1'){ echo 'selected="selected"'; } ?>>Single Multiplier</option>
                                <option value="2" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '2'){ echo 'selected="selected"'; } ?> >Decelerated or Accelerated Multiplier</option>
								<option value="3" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '3'){ echo 'selected="selected"'; } ?> >Simple Multiplier of Achievement</option>
								
                              </select>
                            </div>
                          </div>
                        </div>
						<div class="col-sm-12 padr0">
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">The flexibility managers can have while allocating <?php echo CV_BONUS_SIP_LABEL_NAME; ?> </label>
                          </div>
                          <div class="col-sm-6">
                            <div class="row">
                              <div class="col-sm-1"> <span style="font-weight:bold; font-size:20px;">-</span> </div>
                              <div class="col-sm-5">
                                <input type="text" name="txt_manager_discretionary_decrease" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_decrease"]>0){echo $rule_dtls["manager_discretionary_decrease"];}else{echo "";} ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" />
                              </div>
                              <div class="col-sm-1"> <span style="font-weight:bold; font-size:20px;">+</span> </div>
                              <div class="col-sm-5">
                                <input type="text" name="txt_manager_discretionary_increase" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_increase"]>0){echo $rule_dtls["manager_discretionary_increase"];}else{echo "";} ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);"/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php /*?><div id="dv_achievements_elements" style="display:none;"></div><?php */?>
                
                <div class="row" id="dv_action">
                  <input type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
                  <input type="hidden" value="" id="hf_selected_ba" name="hf_selected_ba" />
                  <input type="hidden" value="" id="hf_selected_custom_id" name="hf_selected_custom_id" />
                  <input type="submit" id="btnAdd_1st" value="" style="display:none" />
                  <div class="col-sm-12 text-right mob-center"> <a class="btn btn-success ml-mb" href="<?php echo site_url("sip-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Back</a>
                    <input type="button" id="btn_edit_next" value="<?php if($rule_dtls['status'] >= 2){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn btn-success ml-mb" onclick="submit_frm('0');" />
                    <?php if($rule_dtls['status'] >= 2){?>
                    <input  type="button" id="btn_next" value="Next Step" class="ml-mb btn btn-success"  onclick="submit_frm('1');"/>
                  </div>
                  <?php } ?>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="dv_partial_page_data_2"></div>
  <div id="dv_partial_page_data_3"></div>
</div>
<script>
$('.multipleSelect').fastselect();

function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
              $(this).find(".fstChoiceRemove").trigger("click");
            });
            show_list(obj_id);
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });
}

function show_list(obj)
{
    $('#'+ obj ).siblings('.fstResults').children('.fstResultItem') .each(function(i, selected)
  {
        if($(this).html()!='All')
        {
            $(this).trigger("click");
        }
    });
}
</script>
<script type="text/javascript">

custom_input_id = 0;
//***************** New Functions Started ***********************//
$(document).ready(function() {
    $( "#txt_plan_start_dt, #txt_plan_end_dt, #txt_start_dt,#txt_end_dt" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
       // yearRange: "1995:new Date().getFullYear()",
     });

     $('.addFixedPerAnotherRow').click(function () {
        $('#add_fixed_percentage').append('<div style="margin-bottom:0px;" class="form-group rv1" id="dv_new_fixed_percentage_row"><div class="row"><div class=""><div class="col-sm-3 plft0"><input type="text"  name="txt_fix_per_range_doj_min[]" class="form-control" maxlength="10" value="" placeholder="From Day" /></div><div class="col-sm-4 plft0"><input type="text"  name="txt_fix_per_range_doj_max[]" class="form-control" maxlength="10"  value="" placeholder="To Day" /></div><div class="col-sm-3 plft0"><input style="width:103%;" type="text" name="txt_fix_per_range_doj_val[]" class="form-control" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age"/></div><div class="col-sm-2 plft0" id="dv_btn_dlt_fixed_percentage"><button  type="button" class="btn btnp btn-danger btn-w60" onclick="removeFixedPerRow(this);">DELETE</button></div></div></div></div>');

        var inp_last_day_of_month = $("[name='txt_fix_per_range_doj_max[]']").filter('[data-last="yes"]').first();

        inp_last_day_of_month.removeAttr("disabled").val("");
        inp_last_day_of_month.data('last','no').attr('data-last','no');

        last_inp = $("[name='txt_fix_per_range_doj_max[]']").last();

        last_inp.val("Last Day of the month");
        last_inp.prop("disabled", true);
        last_inp.data('last','yes').attr('data-last','yes');
      });
 });

function CheckFromDateToDate(FromDate, ToDate)
{
    var sessionLanguage;
    var str1 = document.getElementById(FromDate).value; //Fromdate
    var str2 = document.getElementById(ToDate).value;  //todate

    var sptdate1 = str1.replace("-", "/").replace("-", "/").split("/");
    var sptdate2 = str2.replace("-", "/").replace("-", "/").split("/");
    var datestring1 = sptdate1[1] + "/" + sptdate1[0] + "/" + sptdate1[2];
    var datestring2 = sptdate2[1] + "/" + sptdate2[0] + "/" + sptdate2[2];
    var date1 = new Date(datestring1)
    var date2 = new Date(datestring2);
    if (date2 < date1)
    {
        document.getElementById(FromDate).value = "";
        return false;
    }
    else {
        return true;
    }
}

function addAnotherRow()
{
    var cl2 = $("#dv_range_row").clone()
    .find("input:text").val("").end();
    cl2.find("#dv_btn_perfo_achiev_range_dlt").html('<button type="button" class="btn btn-danger btn-w94" onclick="$(this).closest(\'.rv1\').remove();">DELETE</button>');
    cl2.insertBefore("#dv_btn_add_row");
  cl2.find("input:text").focus();
}

function show_target_sip_elem()
{
  $("#dv_achievements_elements").html("");
  $("#dv_achievements_elements").hide();
  $("#dv_target_sip_elem").html("");
  $("#dv_target_sip_elem").hide();

  var target_sip = $("#ddl_target_sip").val();
  
  if(target_sip == "1") {
    //$("#dv_target_sip_wrapper").show();
    $("#dv_target_sip_on").show();
    $("#ddl_sip_applied_elem").attr('required', true);
    
  }
  else if((target_sip == "2") || (target_sip == "3")) {
    //$("#dv_target_sip_wrapper").show();
    $("#dv_target_sip_on").hide();
    $("#ddl_sip_applied_elem").removeAttr('required');
  }
  //$("#ddl_sip_parameter_wrapper").show();
  get_target_sip_elem();
}

function get_target_sip_elem()
{
    var target_sip = $("#ddl_target_sip").val();
    var elem_for = $("#ddl_target_sip_on").val();

    $("#dv_achievements_elements").html("");
    $("#dv_achievements_elements").hide();

    $("#dv_target_sip_elem").html("");
    $("#dv_target_sip_elem").hide();

    //var json_elem_arr = '<?php echo $rule_dtls["target_sip_dtls"]; ?>';
    /*var i = 0;
    var items = [];
    if(json_elem_arr)
    {
        $.each(JSON.parse(json_elem_arr),function(key,vall){
            items.push(vall);
        });
    } */
  // if(target_sip == "1" || target_sip == "2")
  // {
	var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();

	$.get("<?php echo site_url("sip/get_target_sip_elements/".$rule_dtls["id"]);?>/"+target_sip+"/"+elem_for, function(data)
	{
		rtn_json = JSON.parse(data);
		if(rtn_json)
		{
			$("#dv_target_sip_elem").html(rtn_json.html);
			$("#dv_target_sip_elem").show();

			$("#ddl_sip_parameter").find('option').show();

			// $('#hf_selected_ba').val(rtn_json.hf_selected_ba);
			$('#hf_selected_ba').val(JSON.stringify(rtn_json.hf_selected_ba));
			$('#hf_selected_custom_id').val(JSON.stringify(rtn_json.hf_selected_custom_id));
			custom_input_id = rtn_json.custom_input_id;

			var sip_ba_options = $("#ddl_sip_parameter").find("option");

			for (var i = 0; i < rtn_json.hf_selected_ba.length; i++) {
			  sip_ba_options.each(function (key, v) {
				  if($(this).data('ba_id') == rtn_json.hf_selected_ba[i]) {
					$(this).hide();
				  }
				});
			}
		}
		//set_csrf_field();
	});
  // }
}

function submit_frm(is_next_step)
{
  $("#hf_show_next_step").val(is_next_step);
  $("#btnAdd_1st").trigger( "click" );
}

function submit_step2_frm(is_next_step)
{
  $("#hf_show_next_step3").val(is_next_step);
  $("#btnAdd_2nd").trigger( "click" );
}

function set_rules(frm)
{
  var form=$("#"+frm.id);  
  if(frm.id == 'frm_rule_step1')
  {
    var total_weightage = 0;
    var flag = 1;
    var alert_msg = "";

    var selected_ba_id = $('#hf_selected_ba').val();
    if(selected_ba_id) {
      selected_ba_id = JSON.parse(selected_ba_id);
    }
    else {
      selected_ba_id = [];
    }

    var selected_custom_id = $('#hf_selected_custom_id').val();
    if(selected_custom_id) {
      selected_custom_id = JSON.parse(selected_custom_id);
    }
    else {
      selected_custom_id = [];
    }

	function get_ba_weightage(ele_id)
	{
		if($(ele_id).length)
		{
			ba_id = $(ele_id).data('ba_id');
		
			// check if value exists
			if($.inArray(ba_id, selected_ba_id) != -1)
			{
				return ($(ele_id).val())*1
			}
		}
		return 0;
	}

	var loop_cnt = 1;
	$("input[name='hf_target_sip_elem[]']").each( function (key, v)
	{
		total_weightage = 0;
		var elem_arr = $(this).val().split('<?php echo CV_CONCATENATE_SYNTAX; ?>');
		
		if($("#txt_indivi_weight_"+elem_arr[0]).length)
		total_weightage += ($("#txt_indivi_weight_"+elem_arr[0]).val())*1;
		
		total_weightage += get_ba_weightage("#txt_business_level_1_"+loop_cnt);
		total_weightage += get_ba_weightage("#txt_business_level_2_"+loop_cnt);
		total_weightage += get_ba_weightage("#txt_business_level_3_"+loop_cnt);
		total_weightage += get_ba_weightage("#txt_function_"+loop_cnt);
		total_weightage += get_ba_weightage("#txt_subfunction_"+loop_cnt);
		total_weightage += get_ba_weightage("#txt_sub_subfunction_"+loop_cnt);
	
		$.each( selected_custom_id, function( key, value )
		{
			custom_input_name = "#custom_input_"+value+"_"+loop_cnt;
			if($(custom_input_name).length)
			total_weightage += ($(custom_input_name).val())*1;
		});
	
		if(total_weightage != "100")
		{
			flag = 0;
			alert_msg = "Total of all Business Level Weightage for "+ $("#ddl_target_sip_on").val() + " " + elem_arr[1] + " should be equal to 100";
			return false;
		}
		loop_cnt++;
	});
	
    if(!flag)
    {
      custom_alert_popup(alert_msg);
      setTimeout(function(){ $("#loading").css('display','none'); }, 100);
      return false;
    }
  }

  	if(frm.id == 'frm_rule_step2')
	{
		if($("#hf_show_next_step3").val() != 1)
		{
			$("#loading").css('display','block');
			return true;
		}
	}

	$("#loading").css('display','block');
    $.ajax({
		type:"POST",
		url:form.attr("action"),
		data:form.serialize(),
		success: function(response)
		{
			if(response==3)
			{
				$("#loading").css('display','none');
				window.location.href= "<?php echo site_url("view-sip-rule-details/".$rule_dtls["id"]);?>";
			}
			else if(response==1)
			{
				$.get("<?php echo site_url("sip/get_sip_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
				{
					if(data)
					{
						$("#loading").css('display','none');
						//$("#dv_partial_page_data").html('');
						$("#dv_action").hide();
						$('#dv_partial_page_data').attr('style','pointer-events:none;');
						$("#dv_partial_page_data_2").html(data);
						var y = $(window).scrollTop();  //your current y position on the page
						$(window).scrollTop(y+380);
					}
					else
					{
						$("#loading").css('display','none');
						window.location.href="<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
					}
				});
			}	
			else if(response==2)
			{
				$.get("<?php echo site_url("sip/get_sip_rule_step3_frm/".$rule_dtls["id"]);?>", function(data)
				{
					if(data)
					{
						$("#loading").css('display','none');;
						$("#dv_action_step2").hide();
						$('#dv_partial_page_data_2').attr('style','pointer-events:none;');
						$("#dv_partial_page_data_3").html(data);
						var y = $(window).scrollTop();  //your current y position on the page
						$(window).scrollTop(y+380);
					}
					else
					{
						$("#loading").css('display','none');
						window.location.href="<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
					}
				});
			}		
			else
			{
				$("#loading").css('display','none');
				window.location.href= "<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
			}
		}
    });
    return false;
}

<?php if($this->session->flashdata('show_step')==3){ ?>
	$.get("<?php echo site_url("sip/get_sip_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
	{
		if(data)
		{
			$("#dv_action").hide();
			$('#dv_partial_page_data').attr('style','pointer-events:none;');
			$("#dv_partial_page_data_2").html(data);
			$.get("<?php echo site_url("sip/get_sip_rule_step3_frm/".$rule_dtls["id"]);?>", function(data)
			{
				if(data)
				{
					$("#loading").css('display','none');;
					$("#dv_action_step2").hide();
					$('#dv_partial_page_data_2').attr('style','pointer-events:none;');
					$("#dv_partial_page_data_3").html(data);
					var y = $(window).scrollTop();  //your current y position on the page
					setTimeout(function(){ $(window).scrollTop(y+5000); }, 100);
				}
				else
				{
					$("#loading").css('display','none');
					window.location.href="<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
				}
			});
		}
		else
		{
			$("#loading").css('display','none');
			window.location.href="<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
		}
	});
<?php } ?>


function fill_below_weightage(val, indx, obj)
{
  var i=1;
  $("input[name='hf_target_sip_elem[]']").each( function (key, v)
  {
    var elem_arr = $(this).val().split('<?php echo CV_CONCATENATE_SYNTAX; ?>');
    if(i>indx)
    {
      $("#"+obj+elem_arr[0]).val(val);
    }
    i++;
  });
}


function fill_below_weightage_ba(val, indx, obj)
{
  var i=1;
  $("input[name='hf_target_sip_elem[]']").each( function (key, v)
  {
    var elem_arr = $(this).val().split('<?php echo CV_CONCATENATE_SYNTAX; ?>');

    if(i>indx)
    {
      $("#"+obj+i).val(val);
    }
    i++;
  });
}
//***************** New Functions Ended ***********************//

function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
    $("#dv_submit_2_step").hide();

    if(val != '')
    {
   		$("#loading").css('display','block');
        var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();

        $.post("<?php echo site_url("sip/get_managers_for_manual_bdgt");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val}, function(data)
        {

            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();
                $("#dv_submit_2_step").show();

        if($("#hf_manager_cnt").val()>3)
        {
          $('.page-inner').css('height','');
        }
        else
        {
          var getheight = parseInt($(window).height()) - 100;
          $('.page-inner').css('height',getheight + 'px');
        }

        if(is_need_pre_fill==1)
        {
          var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
          var i = 0;
          var items = [];
          $.each(JSON.parse(json_manual_budget_dtls),function(key,valll)
          {
             //alert(valll[0])
            if(val=='Manual')
            {
              items.push(valll[1]);
            }
            if(val=='Automated but x% can exceed')
            {
              items.push(valll[2]);
            }
          });
          if(val=='Manual')
          {
            $("input[name='txt_manual_budget_amt[]']").each( function (key, v)
            {
              $(this).val(items[i]);
              //$(this).prop('readonly',true);;
              calculat_percent_increased_val(1, items[i], (i+1));
              i++;
            });
          }
          if(val=='Automated but x% can exceed')
          {
            $("input[name='txt_manual_budget_per[]']").each( function (key, v)
            {
              $(this).val(items[i]);
              //$(this).prop('readonly',true);
              calculat_percent_increased_val(2, items[i], (i+1));
              i++;
            });
          }
        }settabletxtcolor();
            }
            else
            {
                $("#ddl_overall_budget").val('');
                $("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>You have no manager to set budget for manually.</b></span></div>');
                $.magnificPopup.open({
                    items: {
                        src: '#common_popup_for_alert'
                    },
                    type: 'inline'
                });
                setTimeout(function(){$('#common_popup_for_alert').magnificPopup('close');},2000);
            }
            set_csrf_field();
            $("#loading").css('display','none');
        });
    }
	/*else {
      var getheight = parseInt($(window).height()) - 100;
      $('.page-inner').css('height',getheight + 'px');
    }*/

}

function calculat_percent_increased_val(typ, val, index_no)
{
  if(typ==1)
  {
    //$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
  	$("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(val));
    var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100);
    $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
  }
  else if(typ==2)
  {
	var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100;
	var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1));

	//$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
	$("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(revised_bdgt));
	var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100);
	$("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
  $("#td_increased_amt_val_"+ index_no).html(get_formated_amount_common(increased_bdgt));
  }
  calculat_total_revised_bgt();
}


function calculat_total_revised_bgt()
{
  var manager_cnt = $("#hf_manager_cnt").val();
  //var val = 0;
  var amtval = 0;
  for(var i=1; i<manager_cnt; i++)
  {
   // val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
    amtval += ($("#td_increased_amt_val_"+ i).html().replace(/[^0-9.]/g,''))*1;
  }
  val = (($("#th_total_budget_plan").html().replace(/[^0-9.]/g,''))*1) + amtval;  

  var per = (val/$("#hf_total_target_sip").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');

  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  $("#th_total_budget_manual").html(formated_val);

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}

</script>
<script type="text/javascript">
show_target_sip_elem();

function add_sip_parameter(select_ele) {

  var selected_option = $(select_ele).find(':selected');
  var option_text = selected_option.text();
  var option_value = selected_option.val();
  var target_sip_table = $("#dv_target_sip_elem").find('table');
  var param_header = target_sip_table.find('thead').find('tr:nth-child(2)');
  var already_added = false;
  var sip_param_th;

  if(option_text.toLowerCase() == "select") {
    return false;
  }
  else if((option_text.toLowerCase() != "custom")) {
    $.each( param_header.children(), function( i, val ) {
      if ($(val).data("value") == option_value) {
        already_added = true;
        sip_param_th = $(val);
      }
    });
  }

  // setting colspan dynamically of header
  var weightage_th = target_sip_table.find('thead').find('tr:nth-child(1)').find('th:last-child');
  // var weightage_th = target_sip_table.find('thead').find('tr:nth-child(1)').find('th:nth-child(2)');

  weightage_th.prop("colspan", "" + (parseInt(weightage_th.prop("colspan"))+1));

  // setting colspan dynamically of footer
  var achievment_button_td = target_sip_table.find('tfoot tr td');

  achievment_button_td.prop("colspan", "" + (parseInt(achievment_button_td.prop("colspan"))+1));

  if(already_added) {
    show_sip_parameter(sip_param_th);
  }
  else {
    if(param_header.children().length == 13) {
      custom_alert_popup('Maximum 10 Parameters can be added.');
      return false;
    }

    if(option_text.toLowerCase() == "custom") {
      custom_input_id++;

      input_or_text = "<br><input class='form-control' style='margin-top:10px;' type='text' id='custom_input_name_" + custom_input_id + "' name='custom_input_name_" + custom_input_id + "' value='Custom_" + custom_input_id + "' >";
      input_options = "data-value='" + option_value + "' data-custom_id='" + custom_input_id + "'";
    }
    else {
      input_or_text = option_text;
      input_options = "data-value='" + option_value + "' data-ba_id='" + selected_option.data('ba_id') + "'";
    }

    param_header.append("<th class='sip-params' " + input_options + " >" + input_or_text + "<br><span class='cross-button' onclick='hide_sip_parameter(this)'>x</span></th>");
    var k = 1;

    target_sip_table.find('tbody tr').each(function() {

      if(option_text.toLowerCase() == "custom") {
        input_options = " name='custom_input_" + custom_input_id + "[]' id='custom_input_" + custom_input_id + "_" + k + "' onchange='fill_below_weightage_ba(this.value, " + k + ", \"custom_input_" + custom_input_id + "_\");' ";
      }
      else {
        input_options = "data-ba_id='" + selected_option.data('ba_id') + "' data-ba_name='" + selected_option.data('ba_name') + "' name='txt_" + selected_option.data('ba_name') + "[]' id='txt_" + selected_option.data('ba_name') + "_" + k + "' onchange='fill_below_weightage_ba(this.value, " + k + ", \"txt_" + selected_option.data('ba_name') + "_\");' ";
      }

      $( this ).append("<td class='weblik-cen'><input type='text' class='form-control bo_vl_width' maxlength='6' onkeyup='validate_percentage_onkeyup_common(this,3);' onblur='validate_percentage_onblure_common(this,3);' style='text-align:center;' " + input_options + "  ></td>");
      k++;
    });

  }


  if(option_text.toLowerCase() != "custom") {
    $(select_ele).find(':selected').hide();
    addSelectedIds('hf_selected_ba', selected_option.data('ba_id'));
  }
  else {
    addSelectedIds('hf_selected_custom_id', custom_input_id);
  }
  $(select_ele).val("select");
}

function hide_sip_parameter(span_ele)
{
  var sip_param_th = $(span_ele).parent();
  var column_position_in_table = sip_param_th.index();
  var target_sip_table = sip_param_th.parentsUntil("table").parent();
  var target_sip_tr_arr = target_sip_table.find('tbody').find('tr');

  sip_param_th.hide();
  for (var i = 0; i < target_sip_tr_arr.length; i++) {
    $(target_sip_tr_arr[i]).find('td').eq(column_position_in_table).hide();
  }

  if(sip_param_th.data('value').toLowerCase() == "custom") {
    removeSelectedIds('hf_selected_custom_id', sip_param_th.data('custom_id'));
  }
  else {
    removeSelectedIds('hf_selected_ba', sip_param_th.data('ba_id'));
  }

  // showing the sip option again
  $("#ddl_sip_parameter").find("option[value='" + $(span_ele).parent().data('value') + "']").show();

  set_target_incentive_grid_col_width()
}

// function to make td with equal width for target incentive grid//
function set_target_incentive_grid_col_width()
{
var count_first_hed_td=0;
$.each($('.td_frist_hed'), function (index, value) {
count_first_hed_td++;
});
var count_first_hed_sec_td=0;
$.each($('.sip-params'), function (index, value) {
if ($(this).css('display')=='none')
  {

  }
else{
count_first_hed_sec_td++;}
});
var td_final_width = 100/( count_first_hed_td + count_first_hed_sec_td) ;
$(".td_ravi").css({'width': td_final_width +'%'});
$(".sip-params").css({'width': td_final_width +'%'});
$(".first_hed_colone").css({'width': (td_final_width*count_first_hed_td) +'%'});
$(".first_hed_coltwo").css({'width': (td_final_width*count_first_hed_sec_td) +'%'});
$(".first_hed_colone").attr({'colspan': count_first_hed_td});
$(".first_hed_coltwo").attr({'colspan': count_first_hed_sec_td});
}


function show_sip_parameter(sip_param_th) {

  var column_position_in_table = sip_param_th.index();
  var target_sip_table = sip_param_th.parentsUntil("table").parent();
  var target_sip_tr_arr = target_sip_table.find('tbody').find('tr');

  sip_param_th.show();
  for (var i = 0; i < target_sip_tr_arr.length; i++) {
    $(target_sip_tr_arr[i]).find('td').eq(column_position_in_table).show();
  }

  // hiding the sip option again
  setTimeout(function(){ set_target_incentive_grid_col_width();}, 10);
}

function toggle_pro_rated_period() {
  if ($("#ddl_prorated_increase").val() == "no") {
    $(".pro-rated-period").hide();
    $("#fixed_percentage_wrapper").hide();
    $("#txt_start_dt").val('00/00/0000');
    $("#txt_end_dt").val('00/00/0000');
  } else if ($("#ddl_prorated_increase").val() == "fix") {
    $(".pro-rated-period").hide();
    $("#fixed_percentage_wrapper").show();
  } else {
    $(".pro-rated-period").show();
    $("#fixed_percentage_wrapper").hide();
    if ($("#txt_start_dt").val() == "00/00/0000") {
      $("#txt_start_dt").val('');
    }
    if ($("#txt_end_dt").val() == "00/00/0000") {
      $("#txt_end_dt").val('');
    }
  }
}

<?php /*?>$("#ddl_performance_achievements_multiplier").change(function()
{
	var multiplier_th = $("#tbl_multiplier_performance_range").find('thead tr:nth-child(1) th:nth-child(2)');
	
	if($(this).val() == 1)
	{
		multiplier_th.text('Define Multiplier (In %)');
	}
	else 
	{
		multiplier_th.text('Define Accelerated/Deaccelerated');
	}
});<?php */?>

function recurringPlanChange(selectEle) {
  recurring_plan_wrapper = $("#recurring_plan_wrapper");
  if($(selectEle).val() == 0) {
    recurring_plan_wrapper.hide();
  }
  else {
    recurring_plan_wrapper.show();
  }
}
function removeFixedPerRow(ele) {
  $(ele).closest('.rv1').remove();

  last_inp = $("[name='txt_fix_per_range_doj_max[]']").last();

  last_inp.val("Last Day of the month");
  last_inp.prop("disabled", true);
  last_inp.data('last','yes').attr('data-last','yes');
}

function addSelectedIds(ele_id, val) {
  var selected_ba_id = $('#' + ele_id).val();
  if(selected_ba_id) {
    selected_ba_id = JSON.parse(selected_ba_id);
  }
  else {
    selected_ba_id = [];
  }
  // check if value already exists
  if($.inArray(val, selected_ba_id) == -1) {
    selected_ba_id.push(val);
  }

  $('#' + ele_id).val(JSON.stringify(selected_ba_id));
}

function removeSelectedIds(ele_id, val) {
  var selected_ba_id = $('#' + ele_id).val();
  if(selected_ba_id) {
    selected_ba_id = JSON.parse(selected_ba_id);
  }
  else {
    selected_ba_id = [];
  }

  // check if value already exists
  if($.inArray(val, selected_ba_id) != -1) {
    // remove item
    selected_ba_id = $.grep(selected_ba_id, function(value) {
      return value != val;
    });
  }

  $('#' + ele_id).val(JSON.stringify(selected_ba_id));
}

function addPerformanceRange(ele, perf_range_for)
{
	var max_range_defined_yet = $('[name="txt_perfo_achiev_max_'+perf_range_for+'[]"]').last();
	var new_min_range_val = 0;
	//alert($('[name="txt_perfo_achiev_max_'+perf_range_for+'[]"]').length);
	if($('[name="txt_perfo_achiev_max_'+perf_range_for+'[]"]').length > 0)
	{
		if(max_range_defined_yet.val() > 0)
		{
			new_min_range_val = parseInt(max_range_defined_yet.val());// + 1;
		}
		else
		{
			custom_alert_popup('Please Define the previous Performance Range first.');
			max_range_defined_yet.focus();
			return false;
		}
	}
	else
	{
		new_min_range_val = 0;
	}

  tbody = $(ele).parent().parent().parent().parent().find('tbody');
  tbody.append('<tr><td class="weblik-cen2"><input class="performance-ranges form-control" type="text" name="txt_perfo_achiev_min_'+perf_range_for+'[]" value="' + new_min_range_val + '" required disabled ></td><td class="weblik-cen2"><input class="performance-ranges form-control" type="text" name="txt_perfo_achiev_max_'+perf_range_for+'[]" onchange="performance_max_range_change(this);" value="" required></td><td class="weblik-cen2"><input class="performance-ranges form-control" type="text" name="txt_perfo_achiev_val_'+perf_range_for+'[]" value="" required></td><td class="weblik-cen2"><button type="button" class="btn btn-primary btn-w94" onclick="removePerformanceRange(this);">DELETE </button></td></tr>');
}

function removePerformanceRange(ele)
{
  $(ele).parent().parent().remove();
}

function performance_max_range_change(ele)
{
  var next_min_ele = $(ele).parent().parent().next().first().children().first().children().first();
  next_min_ele.val(parseInt($(ele).val()));//+1);
}
</script>
