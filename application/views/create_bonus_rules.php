<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
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

/*.msgtxtalignment .msg-left{
    width: 29%;
    display: inline-block;
}*/

.msgtxtalignment .msg-left .alert-success{background:transparent; padding-right: 0px;}

.msgtxtalignment .msg-left .close{display:none;}

/*.msgtxtalignment .msg-right{
    width: 55% !important;
    display: inline-block !important;
}*/

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
</style>

<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo site_url("dashboard"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
    <li class="active"><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Rules</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12" id="dv_partial_page_data">
      <div class="mb20">
        <div class="mailbox-content">
          <div class="">
            <div class="row">
              <div class="col-sm-12">
                <?php 
             $tooltip=getToolTip('bonus-rule-page-2');
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
                          echo "<span style='color:red;'>". $emp_not_any_cycle_counts. " employee(s) under your responsibility are not covered under in rule as yet <a href='". site_url("bonus/emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";
                        echo '</div>';
                      } else {
                        echo "<span class='cre_rule' style='color:red;'>". $emp_not_any_cycle_counts. " employee(s) under your responsibility are not covered under in rule as yet <a href='". site_url("bonus/emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";
                      } 
                    ?>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="rule-form">
              <form id="frm_rule_step1"  method="post" action="<?php echo site_url('save-bonus/'.$rule_dtls['id'].'/1'); ?>" onsubmit="return set_rules(this);">
                <?php echo HLP_get_crsf_field();?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form_head center_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?></h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $rule_val[0] ?>"><i style="font-size: 20px;" class="themeclr fa fa-info-circle" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
                        <div class="col-sm-12">
                          <?php /*?><div class="col-sm-6 removed_padding">
                            <label for="inputEmail3" class="control-label">Plan Name </label>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-input">
                              <input type="text" name="txt_performance_cycle" class="form-control" value="<?php if(isset($rule_dtls["name"])){echo $rule_dtls["name"];} ?>" readonly="readonly" style="background-color:#eee !important; pointer-events:none;"/>
                            </div>
                          </div><?php */?>
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label"><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Rule Name</label>
                          </div>
                          <div class="col-sm-6 ">
                            <input type="text" name="txt_rule_name" value="<?php echo $rule_dtls["bonus_rule_name"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Apply prorated <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> calculations</label>
                          </div>
                          <div class="col-sm-6 ">
                            <select class="form-control" name="ddl_prorated_increase" required>
                              <option value="yes" <?php if($rule_dtls['prorated_increase'] == 'yes'){ echo 'selected="selected"'; } ?> >Yes</option>
                              <option value="no" <?php if($rule_dtls['prorated_increase'] != 'yes'){ echo 'selected="selected"'; } ?> >No</option>
                            </select>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Performance period for pro-rated calculations </label>
                          </div>
                          <div class="col-sm-6">
                            <div class="row">
                              <div class="col-sm-6">
                                <input type="text" id="txt_start_dt" name="txt_start_dt" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="Start Date" autocomplete="off" onblur="checkDateFormat(this)"/>
                                 <!-- <input type="text" id="txt_start_dt" name="txt_start_dt" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="Start Date" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/> -->
                              </div>
                              <div class="col-sm-6">
                                <input type="text" id="txt_end_dt" name="txt_end_dt" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="End Date" autocomplete="off" onblur="checkDateFormat(this)"/>
                                <!-- <input type="text" id="txt_end_dt" name="txt_end_dt" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="End Date" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/> -->
                              </div>
                            </div>
                          </div>
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
                        <div class="col-sm-12">
                          <div class="col-sm-6 removed_padding" style="display:none;">
                            <label for="inputEmail3" class="control-label"><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> To Be Paid On The Basis Of <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $rule_val[2] ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6 removed_padding" style="display:none;">
                            <div class="form-input beg_color" style="margin: 9px 0px;">
                              <label style="display:inline; margin-right:10px; margin-left:8px;">
                                <input type="radio" name="rb_payment_basis" value="M" <?php if($rule_dtls['payment_basis'] == 'M'){ ?>checked="checked"<?php } ?>>
                                <span>Multiple Roles Held</span></label>
                              <label style="display:inline;">
                                <input type="radio" name="rb_payment_basis" value="L" <?php if($rule_dtls['payment_basis'] == 'L'){ ?>checked="checked"<?php } ?>>
                                <span>Last Role Held</span></label>
                            </div>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> calculation as a %Age of a salary element <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $rule_val[2] ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control" id="ddl_target_bonus" name="ddl_target_bonus" required  onchange="show_target_bonus_elem();">
                              <option value="">Select</option>
                              <option value="yes" <?php if($rule_dtls['target_bonus'] == 'yes'){ ?> selected="selected" <?php } ?>>Yes</option>
                              <option value="no" <?php if($rule_dtls['target_bonus'] == 'no'){ ?> selected="selected" <?php } ?>>No</option>
                            </select>
                          </div>
                          <div id="dv_target_bonus_on" style="display:none;">
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> linked to which salary elements <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6" style="margin-bottom:8px;">
                              <select id="ddl_bonus_applied_elem" onchange="hide_list('ddl_bonus_applied_elem');" name="ddl_bonus_applied_elem[]" class="form-control multipleSelect" multiple="multiple">
                                <option  value="all">All</option>
                                <?php if($bonus_applied_on_elem_list){
                                    $bonus_applied_on_elements = "";
                                    if(isset($rule_dtls['bonus_applied_on_elements']))
                                    {
                                      $bonus_applied_on_elements = explode(",", $rule_dtls['bonus_applied_on_elements']);
                                    }
                                    foreach($bonus_applied_on_elem_list as $row){ ?>
                                <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($bonus_applied_on_elements) and in_array($row["business_attribute_id"], $bonus_applied_on_elements)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                <?php }} ?>
                              </select>
                            </div>
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> as %age or Amount of the selected salary elements </label>
                            </div>
                            <div class="col-sm-6">
                              <select class="form-control" id="ddl_target_bonus_elem_value_type" name="ddl_target_bonus_elem_value_type" onchange="get_target_bonus_elem();">
                                <option value="1" <?php if($rule_dtls['target_bonus_elem_value_type'] == 1){ ?> selected="selected" <?php } ?>>Percentage</option>
                                <option value="2" <?php if($rule_dtls['target_bonus_elem_value_type'] == 2){ ?> selected="selected" <?php } ?>>Amount</option>
                              </select>
                            </div>
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> based on </label>
                            </div>
                            <div class="col-sm-6">
                              <select class="form-control" id="ddl_target_bonus_on" name="ddl_target_bonus_on" onchange="get_target_bonus_elem();">
                                <option value="">Select</option>
                                <option value="designation" <?php if($rule_dtls['target_bonus_on'] == 'designation'){ ?> selected="selected" <?php } ?>>Designation</option>
                                <option value="grade" <?php if($rule_dtls['target_bonus_on'] == 'grade'){ ?> selected="selected" <?php } ?>>Grade</option>
                                <option value="level" <?php if($rule_dtls['target_bonus_on'] == 'level'){ ?> selected="selected" <?php } ?>>Level</option>
                              </select>
                            </div>
                          </div>
                          <div id="dv_target_bonus_elem" style="display:none;"> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="dv_achievements_elements" style="display:none;"> </div>                      
                
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4>Individual Performance Based <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Multiplier</h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $rule_val[5] ?>"><i style="font-size:20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      
                        <div class="form_sec clearfix">
                            <div class="col-sm-12">                    
                                <div class="col-sm-6 removed_padding">
                                  <label class="control-label">Performance Type</label>
                                </div>
                                <div class="col-sm-6 ">
                                    <select class="form-control" name="ddl_performance_type" onchange="show_performance_type_elem_dtls(this.value);" required>
                                        <option value="">Select</option>
                                        <option value="1" <?php if($rule_dtls['performance_type'] == '1'){ echo 'selected="selected"'; } ?>>Rating Wise</option>
                                        <option value="2" <?php if($rule_dtls['performance_type'] == '2'){ echo 'selected="selected"'; } ?> >Achievement %age Wise</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="display:none;" >
                                <div class="row">
                                  <div class="col-sm-9">
                                    <div class="row">
                                      <div class="col-sm-6 removed_padding">
                                        <label for="inputEmail3" class="control-label">Performance Based Hikes</label>
                                      </div>
                                      <div class="col-sm-6 removed_padding">
                                        <div class="form-input">
                                          <select class="form-control" id="ddl_performnace_based_hikes" name="ddl_performnace_based_hikes" onchange="manage_performnace_based_hikes(this.value);">
                                            <option value="">Select</option>
                                            <option value="yes" <?php if($rule_dtls['performnace_based_hike'] == 'yes'){ ?> selected="selected" <?php } ?>>Yes</option>
                                            <option value="no" <?php if($rule_dtls['performnace_based_hike'] == 'no'){ ?> selected="selected" <?php } ?>>No</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                <div class="form-group" style="display:none;" id="dv_rating_list_yes"> </div>
                                <div style="display:none;" id="dv_rating_list_no">
                                <div class="col-sm-6 removed_padding">
                                  <label for="inputEmail3" class="control-label">Default Hike (No Ratings)</label>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-input">
                                    <input type="text" class="form-control" name="rating_for_all" id="txt_rating1" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);">
                                  </div>
                                </div>
                              </div>
                              
                                <div class="form-group" style="display:none;" id="dv_performance_achievements_rang">
                                
                                  <!--<div class="col-sm-12">-->                    
                                        <div class="col-sm-6 removed_padding">
                                            <label class="control-label">Define payout approach for <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?></label>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <select class="form-control" name="ddl_performance_achievements_multiplier" required>
                                                <option value="1" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '1'){ echo 'selected="selected"'; } ?>>Single Multiplier</option>
                                                <option value="2" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '2'){ echo 'selected="selected"'; } ?> >Decelerated or Accelerated Multiplier</option>
                                            </select>
                                        </div>
                                    <!--</div>-->
                                <div class="row">
                                   <div style="padding-left: 15px !important;" class="col-sm-6 removed_padding pl15">
                                            <label class="control-label">Define performance ranges</label>
                                   </div>
                                  <div class="col-sm-6">
                                    <?php 
                                if($rule_dtls['performance_achievement_rangs']){
                                    $rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"], true);
                                    $deleteBtn = 0;
                                    foreach($rangs_arr as $row)
                                    { ?>
                                      <div class="form-group rv1" id="dv_range_row">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" name="txt_perfo_achiev_range[]" class="form-control" id="txt_perfo_achiev_range" placeholder="Range" value="<?php echo $row['max']; ?>" required="required" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);">
                                                </div>
                                                <div class="col-sm-3" id="dv_btn_perfo_achiev_range_dlt">
                                                  <?php if($deleteBtn != 0){ ?>
                                                      <button type="button" class="btn btn-danger btn-w94" onclick="$(this).closest('.rv1').remove();">DELETE</button>
                                                    <?php } ?>
                                                </div>                                            
                                            </div>
                                        </div>
                                    <?php $deleteBtn++;
                                    }}else{ ?>
                                        <div class="form-group rv1" id="dv_range_row">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" name="txt_perfo_achiev_range[]" class="form-control" id="txt_perfo_achiev_range" placeholder="Range" value="" required="required" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);">
                                                </div>
                                                <div class="col-sm-3" id="dv_btn_perfo_achiev_range_dlt">
                                                    <button type="button" class="btn btn-danger btn-w94" onclick="$(this).closest('.rv1').remove();">DELETE</button>
                                                </div>                                            
                                            </div>
                                        </div>
                                    <?php }?>

                                    <div class="row" id="dv_btn_add_row">
                                            <div class="col-sm-3 col-sm-offset-9">
                                                <button type="button" class="btn btn-primary btn-w94" onclick="addAnotherRow();">ADD RANGE </button>
                                            </div>   
                                        </div>

                                  </div>
                                </div>              
                            
                                  
                                    
                                </div>
                            </div>
                        </div>
                
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="form_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4>Manager's Discretion</h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip" title="<?php echo $rule_val[6]; ?>"  data-placement="bottom"><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
                        <div class="col-sm-12">
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">The flexibility managers can have while allocated <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> </label>
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
                <div class="row">
                  <input type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
                  <input type="submit" id="btnAdd_1st" value="" style="display:none" />
                  <div class="col-sm-12 text-right mob-center">
                    <a class="btn btn-success ml-mb btn-w120" href="<?php echo site_url("bonus-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Back</a>
                    
                    <input type="button" id="btn_edit_next" value="<?php if($rule_dtls['status'] >= 2){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn btn-success ml-mb btn-w120" onclick="submit_frm('0');" />
                    <?php if($rule_dtls['status'] >= 2){?>
                    <input  type="button" id="btn_next" value="Next Step" class="ml-mb btn-w120 btn btn-success"  onclick="submit_frm('1');"/>
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
  <div class="col-md-12" id="dv_partial_page_data_2"> </div>
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
//***************** New Functions Started ***********************//
$(document).ready(function()
{
    $( "#txt_start_dt,#txt_end_dt" ).datepicker({ 
    dateFormat: 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
       // yearRange: "1995:new Date().getFullYear()",
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

function get_achievements_elements()
{
  $("#dv_achievements_elements").html("");
  $("#dv_achievements_elements").hide();
  var bl_1_achievment = 0;
  var bl_2_achievment = 0;
  var bl_3_achievment = 0;
  var function_achievment = 0;
  var sub_function_achievment = 0;
  var sub_subfunction_achievment = 0;
  
  var txt_bl_1_weightage=$("input[name='txt_bl_1_weightage[]']");
  var txt_bl_2_weightage=$("input[name='txt_bl_2_weightage[]']");
  var txt_bl_3_weightage=$("input[name='txt_bl_3_weightage[]']");
  var txt_function_weightage=$("input[name='txt_function_weightage[]']");
  var txt_sub_function_weightage=$("input[name='txt_sub_function_weightage[]']");
  var txt_sub_subfunction_weightage=$("input[name='txt_sub_subfunction_weightage[]']");
  
  $("input[name='txt_individual_weightage[]']").each( function (key, v)
  {   
    if(($(txt_bl_1_weightage[key]).val()*1) > 0)
    {
      bl_1_achievment = <?php echo CV_BUSINESS_LEVEL_ID_1 ?>;
    }
    if(($(txt_bl_2_weightage[key]).val()*1) > 0)
    {
      bl_2_achievment = <?php echo CV_BUSINESS_LEVEL_ID_2 ?>;
    }
    if(($(txt_bl_3_weightage[key]).val()*1) > 0)
    {
      bl_3_achievment = <?php echo CV_BUSINESS_LEVEL_ID_3 ?>;
    }
    if(($(txt_function_weightage[key]).val()*1) > 0)
    {
      function_achievment = <?php echo CV_FUNCTION_ID ?>;
    }
    if(($(txt_sub_function_weightage[key]).val()*1) > 0)
    {
      sub_function_achievment = <?php echo CV_SUB_FUNCTION_ID ?>;
    }
    if(($(txt_sub_subfunction_weightage[key]).val()*1) > 0)
    {
      sub_subfunction_achievment = <?php echo CV_SUB_SUB_FUNCTION_ID ?>;
    }   
  });
  if(bl_1_achievment > 0 || bl_2_achievment > 0 || bl_3_achievment > 0 || function_achievment > 0 || sub_function_achievment > 0 || sub_subfunction_achievment > 0)
  {
    var base_url = "<?php echo site_url("bonus/get_achievements_elements/".$rule_dtls['id']);?>";
    var url = base_url +"/"+ bl_1_achievment +"/"+ bl_2_achievment +"/"+ bl_3_achievment +"/"+ function_achievment +"/"+ sub_function_achievment +"/"+ sub_subfunction_achievment;
    $.get(url, function(data)
    {
      if(data)
      {
        $("#dv_achievements_elements").html(data);
        $("#dv_achievements_elements").show();
      }
    });
  }
  else
  {
    custom_alert_popup("Please fill any weightage value first.");
  }

}

function show_target_bonus_elem()
{
  $("#dv_achievements_elements").html("");
  $("#dv_achievements_elements").hide();
  $("#dv_target_bonus_elem").html("");
    $("#dv_target_bonus_elem").hide();
  
    var target_bonus = $("#ddl_target_bonus").val();
    if(target_bonus == "yes")
    {
        $("#dv_target_bonus_on").show();  
    $("#ddl_bonus_applied_elem").attr('required', true);      
    }
    else
    {
        $("#ddl_target_bonus_on").val("");        
        $("#dv_target_bonus_on").hide();
    $("#ddl_bonus_applied_elem").attr('required', false);
    get_target_bonus_elem();
    }
  
}

function get_target_bonus_elem()
{   
    var target_bonus = $("#ddl_target_bonus").val();
    var elem_for = $("#ddl_target_bonus_on").val();
  var elem_value_type = $("#ddl_target_bonus_elem_value_type").val();
  
  $("#dv_achievements_elements").html("");
  $("#dv_achievements_elements").hide();
  
  $("#dv_target_bonus_elem").html("");
    $("#dv_target_bonus_elem").hide();
    
    var json_elem_arr = '<?php echo $rule_dtls["target_bonus_dtls"]; ?>';
    /*var i = 0;
    var items = [];
    if(json_elem_arr)
    {
        $.each(JSON.parse(json_elem_arr),function(key,vall){
            items.push(vall);
        });
    } */
  if(target_bonus == "yes" || target_bonus == "no")
  {
        $.post("<?php echo site_url("bonus/get_target_bonus_elements/".$rule_dtls["id"]);?>",{elem_for: elem_for, elem_value_type: elem_value_type}, function(data)
        {
            if(data)
            {
                $("#dv_target_bonus_elem").html(data);
                $("#dv_target_bonus_elem").show();                
                
               /* $("input[name='txt_target_bonus_elem[]']").each( function (key, v)
                {
                    $(this).val(items[i])
                    i++;    
                });*/
        if(target_bonus == "yes" && (elem_for))
        {             
          if(json_elem_arr)
          {
            var i = 0;
            var bl1_arr = ('<?php echo $rule_dtls["bl_1_weightage"]; ?>').split(",");         
            var bl2_arr = ('<?php echo $rule_dtls["bl_2_weightage"]; ?>').split(",");
            var bl3_arr = ('<?php echo $rule_dtls["bl_3_weightage"]; ?>').split(",");
            var funct_arr = ('<?php echo $rule_dtls["function_weightage"]; ?>').split(",");
            var sub_funct_arr = ('<?php echo $rule_dtls["sub_function_weightage"]; ?>').split(",");
            var sub_subfunct_arr = ('<?php echo $rule_dtls["sub_subfunction_weightage"]; ?>').split(",");
            var indivi_arr = ('<?php echo $rule_dtls["individual_weightage"]; ?>').split(",");
            
            $.each(JSON.parse(json_elem_arr),function(key,vall)
            {
              var elem_arr = key.split('<?php echo CV_CONCATENATE_SYNTAX; ?>');
              $("#txt_target_elem_"+elem_arr[0]).val(vall);
              $("#txt_bl1_weight_"+elem_arr[0]).val(bl1_arr[i]);
              $("#txt_bl2_weight_"+elem_arr[0]).val(bl2_arr[i]);
              $("#txt_bl3_weight_"+elem_arr[0]).val(bl3_arr[i]);
              $("#txt_funct_weight_"+elem_arr[0]).val(funct_arr[i]);
              $("#txt_sub_funct_weight_"+elem_arr[0]).val(sub_funct_arr[i]);
              $("#txt_sub_subfunct_weight_"+elem_arr[0]).val(sub_subfunct_arr[i]);
              $("#txt_indivi_weight_"+elem_arr[0]).val(indivi_arr[i]);
              i++;
            });
            get_achievements_elements();
          }
        }
        else
        {
          var bl_1_weightage_arr = '<?php echo $rule_dtls["bl_1_weightage"]; ?>';
          if(bl_1_weightage_arr)
          {
            var bl1_arr = ('<?php echo $rule_dtls["bl_1_weightage"]; ?>').split(",");         
            var bl2_arr = ('<?php echo $rule_dtls["bl_2_weightage"]; ?>').split(",");
            var bl3_arr = ('<?php echo $rule_dtls["bl_3_weightage"]; ?>').split(",");
            var funct_arr = ('<?php echo $rule_dtls["function_weightage"]; ?>').split(",");
            var sub_funct_arr = ('<?php echo $rule_dtls["sub_function_weightage"]; ?>').split(",");
            var sub_subfunct_arr = ('<?php echo $rule_dtls["sub_subfunction_weightage"]; ?>').split(",");
            var indivi_arr = ('<?php echo $rule_dtls["individual_weightage"]; ?>').split(",");
            
            $("#txt_bl1_weightage").val(bl1_arr[0]);
            $("#txt_bl2_weightage").val(bl2_arr[0]);
            $("#txt_bl3_weightage").val(bl3_arr[0]);
            $("#txt_funct_weightage").val(funct_arr[0]);
            $("#txt_sub_funct_weightage").val(sub_funct_arr[0]);
            $("#txt_sub_subfunct_weightage").val(sub_subfunct_arr[0]);
            $("#txt_indivi_weightage").val(indivi_arr[0]);
            get_achievements_elements();
          }
        }
            }
        });
  }
}

function show_performance_type_elem_dtls(val)
{
  $("#txt_rating1").prop('required',false);
    $("#dv_rating_list_yes").hide();
    $("#dv_rating_list_no").hide();
    $("#dv_rating_list_yes").html("");  
  $("#dv_performance_achievements_rang").hide();
  
  $("input[name='txt_perfo_achiev_range[]']").each( function (key, v)
  {
    $(this).prop('required',false);
  });
  
  if(val==1)
  {
    $("#ddl_performnace_based_hikes").val('yes');
    manage_performnace_based_hikes($("#ddl_performnace_based_hikes").val());
  }
  else if(val==2)
  {
    $("input[name='txt_perfo_achiev_range[]']").each( function (key, v)
    {
      $(this).prop('required',true);
    });
    $("#dv_performance_achievements_rang").show();
  }
}

function manage_performnace_based_hikes(val)
{
    $("#txt_rating1").prop('required',false);
    $("#dv_rating_list_yes").hide();
    $("#dv_rating_list_no").hide();
    $("#dv_rating_list_yes").html("");
    
    var jsonRating = '<?php echo $rule_dtls["performnace_based_hike_ratings"]; ?>';
    var i = 0;
    var items = [];
    if(jsonRating)
    {
        $.each(JSON.parse(jsonRating),function(key,vall){
            items.push(vall);
        });
    }   

    if(val=='yes')
    {
        var pid = $("#hf_performance_cycle_id").val();
        $.post("<?php echo site_url("bonus/get_ratings_list");?>",{pid:pid,txt_name:'rating', rule_id:'<?php echo $rule_dtls['id']; ?>'}, function(data)
        {
            if(data)
            {
                $("#dv_rating_list_yes").html(data);
                $("input[name='ddl_market_salary_rating[]']").each( function (key, v)
                {
                    $(this).val(items[i])
                    i++;    
                });
                $("#dv_rating_list_yes").show();
            }
            else
            {
                $("#ddl_performnace_based_hikes").val('no');
                $("#txt_rating1").prop('required',true);
                $("#dv_rating_list_no").show();
            }
        });         
    }
    else if(val=='no')
    {
        $("#txt_rating1").prop('required',true);
        $("#txt_rating1").val(items[i]);
        $("#dv_rating_list_no").show();
    }
}

function submit_frm(is_next_step)
{
  $("#hf_show_next_step").val(is_next_step);
  $("#btnAdd_1st" ).trigger( "click" );
}

function set_rules(frm)
{   
    var form=$("#"+frm.id); 
  if(frm.id == 'frm_rule_step1')
  {   
    var total_weightage = 0;
    var flag = 1;
    var alert_msg = "";
    if($("#ddl_target_bonus").val() == "yes")
    {
      $("input[name='hf_target_bonus_elem[]']").each( function (key, v)
      {   
        total_weightage = 0;
        var elem_arr = $(this).val().split('<?php echo CV_CONCATENATE_SYNTAX; ?>');
        total_weightage += ($("#txt_bl1_weight_"+elem_arr[0]).val())*1;
        total_weightage += ($("#txt_bl2_weight_"+elem_arr[0]).val())*1;
        total_weightage += ($("#txt_bl3_weight_"+elem_arr[0]).val())*1;
        total_weightage += ($("#txt_funct_weight_"+elem_arr[0]).val())*1;
        total_weightage += ($("#txt_sub_funct_weight_"+elem_arr[0]).val())*1;
        total_weightage += ($("#txt_sub_subfunct_weight_"+elem_arr[0]).val())*1;
        total_weightage += ($("#txt_indivi_weight_"+elem_arr[0]).val())*1;  
        if(total_weightage != "100")
        {
          flag = 0;
          alert_msg = "Total of all Business Level Weightage for "+ $("#ddl_target_bonus_on").val() +" " + elem_arr[1] + " should be equal to 100";
          return false;
        }
      });
    }
    else
    {
      total_weightage += ($("#txt_bl1_weightage").val())*1;
      total_weightage += ($("#txt_bl2_weightage").val())*1;
      total_weightage += ($("#txt_bl3_weightage").val())*1;
      total_weightage += ($("#txt_funct_weightage").val())*1;
      total_weightage += ($("#txt_sub_funct_weightage").val())*1;
      total_weightage += ($("#txt_sub_subfunct_weightage").val())*1;
      total_weightage += ($("#txt_indivi_weightage").val())*1;  
      if(total_weightage != "100")
      {
        flag = 0;
        alert_msg = "Total of all Business Level Weightage should be equal to 100";
      }
    }
    
    if(!flag)
    {
      custom_alert_popup(alert_msg);
      setTimeout(function(){ $("#loading").css('display','none'); }, 100);
      return false;
    }   
  }

  /*if( !request_confirm() ) {
    return false;
  }*/
    
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
                //window.location.href= "<?php //echo site_url("view-bonus-rule-budget/".$rule_dtls["id"]);?>";
				window.location.href= "<?php echo site_url("view-bonus-rule-details/".$rule_dtls["id"]);?>";
            }           
            else if(response==1)
            {
                 $.get("<?php echo site_url("bonus/get_bonus_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
                 {
                    if(data)
                    {
                        $("#loading").css('display','none');
                        $("#dv_partial_page_data").html('');
                        $("#dv_partial_page_data_2").html(data);
                    }
                    else
                    {
                        $("#loading").css('display','none');
                        window.location.href="<?php echo site_url("bonus-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
                    }
          //var getheight = parseInt($(window).height()) - 100;
          //$('.page-inner').css('height',getheight + 'px');
                }); 
            }
      else if(response==2)
            {
                 $.get("<?php echo site_url("bonus/get_bonus_rule_step3_frm/".$rule_dtls["id"]);?>", function(data)
                 {
                    if(data)
                    {
                        $("#loading").css('display','none');
                        $("#dv_partial_page_data").html('');
                        $("#dv_partial_page_data_2").html(data);
                    }
                    else
                    {
                        $("#loading").css('display','none');
                        window.location.href="<?php echo site_url("bonus-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
                    }
          //var getheight = parseInt($(window).height()) - 100;
          //$('.page-inner').css('height',getheight + 'px');
                }); 
            }
            else
            {
                $("#loading").css('display','none');
                window.location.href= "<?php echo site_url("bonus-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
            }
        }
    });
    return false;
}


function fill_below_weightage(val, indx, obj)
{
  var i=1;
  $("input[name='hf_target_bonus_elem[]']").each( function (key, v)
  {   
    var elem_arr = $(this).val().split('<?php echo CV_CONCATENATE_SYNTAX; ?>');   
    if(i>indx)
    {
      $("#"+obj+elem_arr[0]).val(val);
    }   
    i++;  
  });
}
//***************** New Functions Ended ***********************//


/*function manage_function_achievements()
{
   var function_weightage_val = $("#txt_function_weightage").val();
   if(function_weightage_val > 0)
   {
    $("#dv_function_achievement").show();
   }
   else
   {
     $("#dv_function_achievement").hide();
   }
}

function manage_business_level_achievements()
{
  $("input[name='txtbusiness_level[]']").each( function (key, v)
  {
    var bl_weightage_val = $(this).val();
    var ba_id = $(this).attr('lang');
    if(bl_weightage_val > 0)
    {
      $("#dv_business_level_achievement_"+ba_id).show();
    }
    else
    {
      $("#dv_business_level_achievement_"+ba_id).hide();
    }
  });
   
}*/



function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
{
  
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
    $("#dv_submit_2_step").hide();

    if(val != '')
    {
    $("#loading").css('display','block');
        $.post("<?php echo site_url("bonus/get_managers_for_manual_bdgt");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
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
        }
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
      $("#loading").css('display','none');
        });
    } else {
      var getheight = parseInt($(window).height()) - 100;
      $('.page-inner').css('height',getheight + 'px');
    }
    
}
//Piy@17Dec19 
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

  var per = (val/$("#hf_total_target_bonus").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');

  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  $("#th_total_budget_manual").html(formated_val);

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}
/*
function calculat_percent_increased_val(typ, val, index_no)
{ 
  if(typ==1)
  {
    //$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")); 
	$("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(val));
    var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100);
  $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %'); 
  //$("#td_increased_amt_val_"+ index_no).html(val).toFixed(0); 
  }
  else if(typ==2)
  {
    var increased_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100).toFixed(0);
    var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1));
    //$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")); 
	$("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(revised_bdgt)); 
    var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100);
    $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %'); 
  $("#td_increased_amt_val_"+ index_no).html(increased_bdgt); 

  }
  calculat_total_revised_bgt();
}

function calculat_total_revised_bgt()
{ 
  var manager_cnt = $("#hf_manager_cnt").val();
  var val = 0;
  for(var i=1; i<manager_cnt; i++)
  {
    val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
  }
  
  var per = (val/$("#hf_total_target_bonus").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');
  
  //var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  $("#th_total_budget_manual").html(formated_val);


  var val = 0;
  for(var i=1; i<manager_cnt; i++)
  {
    val += ($("#td_increased_amt_val_"+ i).html().replace(/[^0-9.]/g,''))*1;
  }
  var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    $("#th_additional_budget_manual").html(formated_val);
}
*/
function validate_onkeyup(that)
{
    that.value = that.value.replace(/[^0-9.]/g,'');
    if(((that.value).split('.')).length>2)
    {
        var arr = (that.value).split('.');
        that.value=arr[0]+"."+arr[1];
    }
}
function validate_onblure(that)
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
</script> 
<script type="text/javascript">

show_target_bonus_elem();
if($("#ddl_target_bonus").val() == "yes")
{
  get_target_bonus_elem();
}
show_performance_type_elem_dtls('<?php echo $rule_dtls['performance_type'];?>');
<?php /*?>manage_performnace_based_hikes('<?php echo $rule_dtls['performnace_based_hike'];?>');
<?php if(!$rule_dtls['performnace_based_hike']){?>
  $("#ddl_performnace_based_hikes").val('yes');
  manage_performnace_based_hikes('yes');
<?php } ?><?php */?>

//manage_function_achievements();
//manage_business_level_achievements();
</script> 
