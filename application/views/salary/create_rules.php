<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstControls{line-height:17px;}
.plft0{padding-left: 0px;}
.prit0{padding-right: 0px;}
.btnp{padding: 5px 10px !important;}
/*.rule-form .form-control{height:32px !important;}
.rule-form .control-label{line-height:32px !important;}*/
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
.form_head ul{ padding:0px; margin-bottom:0px;}
.form_head ul li{ display:inline-block;}
.sal_incre_rang:hover{border:2px solid #<?php echo $this->session->userdata("company_color_ses"); ?>}
.sal_incre_rang:hover input{border:2px solid #<?php echo $this->session->userdata("company_color_ses"); ?>}


.rule-form .form-control {
height: 30px;
margin-top: 0px;
font-size: 12px;
background-color: #FFF;
margin-bottom:10px;
}
.rule-form .control-label {
font-size: 13px;
line-height: 30px;
<?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
color: #000;
margin-bottom:10px;
}
.rule-form .form-control:focus {
box-shadow: none!important;
}
.rule-form .form_head {
background-color: #f2f2f2;
<?php /*?>border-top: 8px solid #93c301;<?php */?>
border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
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
margin-top: -4px;
padding: 7px;
}
.rule-form .form_sec {
background-color: #f2f2f2;

display: block;
width: 100%;
padding: 5px 0px 9px 0px;
border-bottom-left-radius: 0px;/*6px;*/
border-bottom-right-radius: 0px;/*6px;*/
}
.form-group{
margin-bottom: 10px;
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
.paddg{ 0px 20px;}

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

.btn.btnp{padding:4px 17px !important; margin-top:1px;}

</style>
<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid">
   <div class="row">
    <div class="col-sm-8 plft0"> 
     <ol class="breadcrumb container-fluid">
      <li><a href="<?php echo site_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
      <li><a href="<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]); ?>">Rule List</a></li>
      <li><a href="<?php echo site_url("salary-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Rule Filter</a></li>
      <li class="active">Salary Rule</li>
    </ol>
   </div>
  </div>
 </div>
</div>

<div id="main-wrapper" class="container-fluid compp_fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="mb20">
        <div class="panel panel-white">
          <?php 
$tooltip=getToolTip('salary-rule-page-2');$val=json_decode($tooltip[0]->step);
?>
          <?php if($emp_not_any_cycle_counts > 0 or $this->session->flashdata('message')){?>
          <div class="msgtxtalignment">
            <?php if($this->session->flashdata('message')) { ?>
            <div class="msg-left cre_rule"> <?php echo $this->session->flashdata('message'); ?> </div>
            <div  class="msg-right cre_rule">
              <?php if($emp_not_any_cycle_counts > 0){echo "<span style='color:red;'>". $emp_not_any_cycle_counts. " Employee(s) under your responsibility are not covered in any rule as yet. <a href='". site_url("emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";} ?>
            </div>
            <?php } else { ?>
            <?php if($emp_not_any_cycle_counts > 0){echo "<span class='cre_rule' style='color:red;'>". $emp_not_any_cycle_counts. " Employee(s) under your responsibility are not covered in any rule as yet. <a href='". site_url("emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";} ?>
            <?php } ?>
          </div>
          <?php } ?>
          <div class="panel-body">
            <div class="rule-form">
              <form id="frm_rule_step1" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("rules/set_rules/".$rule_dtls['id']."/1"); ?>">
                <?php echo HLP_get_crsf_field();?>
                <div class="form-group">
                  <div class="row" id="dv_frm_head">
                    <div class="col-sm-12">
                      <div class="form_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4>Define Basic Rules
                                  <?php //echo $rule_dtls["name"]; ?>
                                  <span id="spn_rule_name"></span></h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info">
                                <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[0]?$val[0]:'Define basic rules to setup your compensation plan which will impact your increment grid as well as budget allocation.'; ?>"><i style="margin-top:-2px;font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
                        <div class="col-sm-12">

                        <div class="rule_box clearfix" >
                          <div class="col-sm-6 removed_padding">
                            <label for="inputEmail3" class="control-label">Plan Name </label>
                          </div>
                          <div class="col-sm-6 pad_right0">
                            <div class="form-input">
                              <input type="text" class="form-control" value="<?php echo $rule_dtls["name"]; ?>" readonly="readonly" style="background-color:#eee !important; pointer-events:none;"/>
                            </div>
                          </div>

                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Salary Rule Name <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Write name of this specific rule which will be displayed to all users." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6 pad_right0">
                            <input type="text" id="txt_salary_rule_name" name="txt_salary_rule_name" value="<?php echo $rule_dtls["salary_rule_name"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>

                           <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Include inactive employees <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2]?:'Click “Yes” In case all in-active employees to be covered in this plan eg. Maternity case, long leave cases, etc. ' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6 pad_right0">
                              <select class="form-control" name="ddl_include_inactive" required>
                                <option value="yes" <?php if($rule_dtls['include_inactive'] == 'yes'){ echo 'selected="selected"'; } ?> >Yes</option>
                                <option value="no" <?php if($rule_dtls['include_inactive'] != 'yes'){ echo 'selected="selected"'; } ?> >No</option>
                              </select>
                            </div>
							
							<div class="col-sm-6 removed_padding">
								<label class="control-label">Performance Period <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Define your performance period which will mainly be used to calculate the pro-rated increase for the employees joined between this period." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          	</div>
                          	<div class="col-sm-6">
								<div class="row">
								  <div class="col-sm-6 paddr0">
									<input type="text" id="txt_pp_start_dt" name="txt_pp_start_dt" class="form-control" maxlength="10" onchange="CheckFromDateToDate('txt_pp_start_dt','txt_pp_end_dt');" value="<?php if($rule_dtls["pp_start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["pp_start_dt"]));} ?>" placeholder="Start Date" autocomplete="off" onblur="checkDateFormat(this)"/>
								  </div>
								  <div class="col-sm-6 paddr0">
									<input type="text" id="txt_pp_end_dt" name="txt_pp_end_dt" class="form-control" maxlength="10" onchange="CheckFromDateToDate('txt_pp_start_dt','txt_pp_end_dt');" value="<?php if($rule_dtls["pp_end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["pp_end_dt"]));} ?>" placeholder="End Date" autocomplete="off"  onblur="checkDateFormat(this)"/>
								  </div>
								</div>
                          	</div>
                        </div>



                        <div class="rule_box clearfix" >

                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Apply prorated increase calculations</label>
                          </div>

                          <div class="col-sm-6 paddr0">
                            <select class="form-control" id="ddl_prorated_increase" name="ddl_prorated_increase" onchange="toggle_pro_rated_period();" required>
                              <option value="yes" <?php if($rule_dtls['prorated_increase'] == 'yes'){ echo 'selected="selected"'; } ?> >Simple Proration For All Employees</option>
							  <option value="fixed_period" <?php if($rule_dtls['prorated_increase'] == 'fixed_period'){ echo 'selected="selected"'; } ?> >Simple Proration For Fixed Period</option>
                              <option value="no" <?php if($rule_dtls['prorated_increase'] == 'no'){ echo 'selected="selected"'; } ?> >No</option>
                              <option value="fixed-percentage" <?php if($rule_dtls['prorated_increase'] == 'fixed-percentage'){ echo 'selected="selected"'; } ?> >Fixed %ages</option>
                            </select>
                          </div>

                          <div class="col-sm-6 removed_padding pro-rated-period">
                            <label class="control-label">Performance period for pro-rated calculations <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="This performance period will be used to calculate pro-rated increase for employees joined between
this period." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6 pro-rated-period">
                            <div class="row">
                              <div class="col-sm-6 paddr0">
                                <input type="text" id="txt_start_dt" name="txt_start_dt" class="form-control" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="Start Date" autocomplete="off" onblur="checkDateFormat(this)" />
                              </div>
                              <div class="col-sm-6 paddr0">
                                <input type="text" id="txt_end_dt" name="txt_end_dt" class="form-control" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="End Date" autocomplete="off"  onblur="checkDateFormat(this)" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6 removed_padding fixed-percentage">
                            <label class="control-label">Fixed %ages for a range of DOJ</label>
                          </div>
                          <div class="col-sm-6 fixed-percentage" >
                            <div class="row">
                              <?php /*?><div class="col-sm-12">
<div class="form-group">
<label class="control-label">Range</label>
</div>
</div><?php */?>
                              <div class="col-sm-12">
                                <div class="row" id="dv_btn_add_row_fixed_percentage">
                                  <div class="col-sm-2 plft0 col-sm-offset-10" style="padding-right:0px;">
                                    <button style=" margin-bottom: 10px;" type="button" class="pull-right btn btnp btn-primary btn-w90 addFixedPerAnotherRow" >ADD</button>
                                  </div>
                                </div>
                                <div id="add_fixed_percentage">
                                  <?php 
if($rule_dtls['fixed_percentage_range_of_doj']){


$fixed_percentage_arr = json_decode($rule_dtls["fixed_percentage_range_of_doj"], true);
//print_r($fixed_percentage_arr);

$deleteBtn1 = 0;
foreach($fixed_percentage_arr as $row)
{?>
                                  <div class="form-group rv1" id="dv_new_fixed_percentage_row" style="margin-bottom: 0px !important;">
                                    <div class="row">
                                     <div class="col-sm-12">
                                      <div class="col-sm-3 plft0">
                                        <input type="text"  name="txt_start_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per " maxlength="10"  value="<?php if($row["From"] != "0000-00-00"){ echo $row["From"];;} ?>" placeholder="From Date"  onblur="checkDateFormat(this)"/>
                                      </div>
                                      <div class="col-sm-3 plft0">
                                        <input type="text"  name="txt_end_dt_fixed_per[]" class="form-control txt_end_dt_fixed_per" maxlength="10" value="<?php if($row["To"] != "0000-00-00"){ echo $row["To"];;} ?>" placeholder="To Date"  onblur="checkDateFormat(this)" />
                                      </div>
                                      <div class="col-sm-4 plft0 prit0">
                                        <input type="text" id="txt_fixed_per" name="txt_fixed_per[]" class="form-control txt_fixed_per" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age" value="<?php if($row["Percentage"] != "0000-00-00"){ echo $row["Percentage"];;} ?>" />
                                      </div>
                                      <div class="col-sm-2" id="dv_btn_dlt_fixed_percentage">
                                        <?php if($deleteBtn1 != 0){ ?>
                                        <button style="margin-left:4px;" type="button" class=" btn btnp btn-danger btn-w90" onclick="$(this).closest('.rv1').remove();">DELETE</button>
                                        <?php } ?>
                                      </div>
                                     </div>
                                    </div>
                                  </div>
                                  <?php  $deleteBtn1++;
}
} else{?>
                                  <div class="form-group rv1" id="dv_new_fixed_percentage_row" style="margin-bottom: 0px !important;">
                                    <div class="row">
                                     <div class="col-sm-12">
                                      <div class="col-sm-3 plft0">
                                        <input type="text"  name="txt_start_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per" maxlength="10"  value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="From Date"  onblur="checkDateFormat(this)" />
                                      </div>
                                      <div class="col-sm-3 plft0">
                                        <input type="text"  name="txt_end_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per" maxlength="10"  value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="To Date"  onblur="checkDateFormat(this)" />
                                      </div>
                                      <div class="col-sm-4 plft0 prit0">
                                        <input type="text" id="txt_fixed_per" name="txt_fixed_per[]" class="form-control" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age"/>
                                      </div>
                                      <div class="col-sm-2" id="dv_btn_dlt_fixed_percentage">
                                        <button style="margin-left:4px;" type="button" class=" btn btnp btn-danger btn-w90" onclick="$(this).closest('.rv1').remove();">DELETE</button>
                                      </div>
                                     </div>
                                    </div>
                                  </div>
                                  <?php } ?>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                        </div>


                        <div id="dv_partial_page_data">
                          
                            <div class="rule_box clearfix" >
                              <div class="">
							<div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Rounding up for the Final Salary</label>
                            </div>
                            <div class="col-sm-6 paddr0" style="margin-bottom:8px;">
                              <select name="ddl_rounding_final_salary" class="form-control" required>
								<option value="1" <?php
									if ($rule_dtls['rounding_final_salary'] == 1) {
										echo 'selected="selected"';
									}
									?>>Round up to nearest 1</option>
								<option value="10" <?php
									if ($rule_dtls['rounding_final_salary'] == 10) {
										echo 'selected="selected"';
									}
									?>>Round up to nearest 10</option>
								<option value="25" <?php
									if ($rule_dtls['rounding_final_salary'] == 25) {
										echo 'selected="selected"';
									}
									?>>Round up to nearest 25</option>
								<option value="50" <?php
									if ($rule_dtls['rounding_final_salary'] == 50) {
										echo 'selected="selected"';
									}
									?>>Round up to nearest 50</option>
								<option value="100" <?php
									if ($rule_dtls['rounding_final_salary'] == 100) {
										echo 'selected="selected"';
									}
									?>>Round up to nearest 100</option>
								<option value="1000" <?php
									if ($rule_dtls['rounding_final_salary'] == 1000) {
										echo 'selected="selected"';
									}
									?>>Round up to nearest 1000</option>
							  </select>
                            </div>  
							  
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Salary elements to be reviewed<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[1]?$val[1]:'Select which salary element this salary review will impact. ' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6 paddr0" style="margin-bottom:8px;">
                              <select id="ddl_increment_applied_elem" onchange="hide_list('ddl_increment_applied_elem');" name="ddl_increment_applied_elem[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="all">All</option>
                                <?php if($salary_applied_on_elem_list){
$salary_applied_on_elements = "";
if(isset($rule_dtls['salary_applied_on_elements']))
{
$salary_applied_on_elements = explode(",", $rule_dtls['salary_applied_on_elements']);
}
foreach($salary_applied_on_elem_list as $row){ ?>
                                <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($salary_applied_on_elements) and in_array($row["business_attribute_id"], $salary_applied_on_elements)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                <?php }} ?>
                              </select>
                            </div>

                            <div class="col-sm-6 removed_padding">
                                <label class="control-label">Show Variable Salary To Managers <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Select “Yes” if you want to show both current
and revised variable pay on manager’s salary
review screen. This will reflect information
from the Target bonus column from the
database along" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              </div>


                            <div class="col-sm-6 pad_right0">
                                <select class="form-control" name="ddl_display_variable_salary" required>
                                <option value="1" <?php if($rule_dtls['display_variable_salary'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                                <option value="2" <?php if($rule_dtls['display_variable_salary'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
                                </select>
                              </div>
							  
							<div class="col-sm-6 removed_padding">
								<label class="control-label">Type of hike should be editable</label>
							</div>
							<div class="col-sm-6">							
								<div class="row">
									<div class="col-sm-12" style="padding-right: 0px;">
										<div class="quartile">          
											<ul>				
												<?php $type_of_hike_can_edit_arr = explode(",", $rule_dtls["type_of_hike_can_edit"]); ?>				
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" name="chk_type_of_hike_can_edit[]" id="chk_merit_hike" class="quartile_dvs" value="<?php echo CV_SALARY_MERIT_HIKE; ?>" <?php if(in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?> <?php if(!$rule_dtls["type_of_hike_can_edit"]){ echo "required"; } ?> onclick="validate_type_of_hike_can_edit_options(this);">Merit
														</label>
													</div>
												</li>
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" name="chk_type_of_hike_can_edit[]" id="chk_market_hike" class="quartile_dvs" value="<?php echo CV_SALARY_MARKET_HIKE; ?>" <?php if(in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?> onclick="validate_type_of_hike_can_edit_options(this);">Market Correction
														</label>
													</div>
												</li>
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" name="chk_type_of_hike_can_edit[]" id="chk_promotion_hike" class="quartile_dvs" value="<?php echo CV_SALARY_PROMOTION_HIKE; ?>" <?php if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?> onclick="validate_type_of_hike_can_edit_options(this);">Promotion
														</label>
													</div>
												</li>
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" name="chk_type_of_hike_can_edit[]" id="chk_total_hike" class="quartile_dvs" value="<?php echo CV_SALARY_TOTAL_HIKE; ?>" <?php if(in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?> onclick="validate_type_of_hike_can_edit_options(this);">Total
														</label>
													</div>
												</li>								
											</ul>
										</div>
									</div>
								</div>
							</div>

                           </div>

                           </div>
                          

                          <div class="rule_box clearfix" style="margin-top: 8px;" >
                            <div class="col-sm-6 removed_padding">
                              <label class="control-label">Performance based salary increase <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[3]?$val[3]:'Select “Yes” if using performance based salary differentiation model for your salary review.' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6 pad_right0">
                              <select class="form-control" id="ddl_performnace_based_hikes" name="ddl_performnace_based_hikes" required onchange="manage_performnace_based_hikes(this.value);">
                                <option value="">Select</option>
                                <option value="yes" <?php if($rule_dtls['performnace_based_hike'] == 'yes'){ ?> selected="selected" <?php } ?> >Yes</option>
                                <option value="no" <?php if($rule_dtls['performnace_based_hike'] == 'no'){ ?> selected="selected" <?php } ?> >No</option>
                              </select>
                            </div>

            							<div class="col-sm-6 removed_padding">
            							  <label class="control-label">Manager’s can change the ratings <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="This will allow managers to change the ratings of their team members
at their end itself and will also change the salary increase as defined
in the increment grid below for each rating." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            							</div>
            							<div class="col-sm-6 pad_right0">
            							  <select class="form-control" name="ddl_manager_can_change_rating" required>
            								<option value="1" <?php if($rule_dtls['manager_can_change_rating'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
            								<option value="2" <?php if($rule_dtls['manager_can_change_rating'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
            							  </select>
            							</div>

                           <div class="col-sm-6 removed_padding">
                                <label class="control-label">Show Performance Achievement To Managers
                                <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Select “Yes” if you want to show the performance
                          achievement %age also along with the performance rating
                          on manager’s salary review screen." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              </div>
                              <div class="col-sm-6 pad_right0">
                                <select class="form-control" name="ddl_display_performance_achievement" required>
                                <option value="1" <?php if($rule_dtls['display_performance_achievement'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                                <option value="2" <?php if($rule_dtls['display_performance_achievement'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
                                </select>
                              </div>

                        </div>




                          <div class="rule_box clearfix">
                            <div class="col-sm-6 removed_padding">
                              <label class="control-label"> Pay range comparison after merit increase<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[4]?$val[4]:'Select “Yes” if you want to calculate employee parity with the selected pay range after applying performance/merit based salary increase on the current salary.' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6 pad_right0">
                              <select class="form-control" id="ddl_comparative_ratio" name="ddl_comparative_ratio" required onchange="manage_comparative_ratio(this.value);">
                                <option value="">Select</option>
                                <option value="yes" <?php if($rule_dtls['comparative_ratio'] == 'yes'){ echo 'selected="selected"'; } ?> >Yes</option>
                                <option value="no" <?php if($rule_dtls['comparative_ratio'] == 'no'){ echo 'selected="selected"'; } ?> >No</option>
                              </select>
                            </div>
                            
							
							<div class="col-sm-6 removed_padding">
                              <label class="control-label"> Pay Range comparison model<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[5]?$val[5]:'Select which salary increase model you would like to choose between :-
                              1. Current salary distance from the target position or
                              2. Current salary positioning in on a pay range (quartile positioning)' ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
							<div class="col-sm-6 pad_right0">
							  <select class="form-control" id="ddl_salary_position_based_on" name="ddl_salary_position_based_on" required onchange="manage_salary_position_based_on();">
								<!--<option value="">Select</option>-->
								<option value="1" <?php if($rule_dtls['salary_position_based_on'] == "1"){ echo 'selected="selected"'; } ?> >Distance</option>
								<option value="2" <?php if($rule_dtls['salary_position_based_on'] == "2"){ echo 'selected="selected"'; } ?> >Quartile</option>
							  </select>
							</div>
							<div id="dv_distance_for_crr">
								
								<div id="dv_apply_comparative_ratio_no">
                              <div class="col-sm-6 removed_padding">
                                <label class="control-label">Select target positioning<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php //echo $val[6] ?> Select the target positioning for all your employees from the list of pay
range data points you have uploaded." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              </div>
                              <div class="col-sm-6 pad_right0">
                                <select class="form-control" id="ddl_comparative_ratio1" name="ddl_comparative_ratio1">
                                </select>
                              </div>
                            </div>
							
								<div class="col-sm-6 removed_padding">
								  <label class="control-label">Create comparative ratios <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[7]?$val[7]:'On the distance model drop down write in the information icon - “Select the standard %ile positioning for all employees”.
                                  In this rule, there will be another drop down with information icon and write there :-
                                 “Define your Comparative ratio ranges to propose salary increase for difference CR ranges.”
                                  In the quartile model page rule, write in the information icon– “Select multiple ranges to identify your population indifferent quartile of your pay range to propose salary increase.”' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
								</div>
								<div class="col-sm-6 pad_right0">
								  <div class="row">
									<?php /*?><div class="col-sm-12">
	<div class="form-group">
	<label class="control-label">Range</label>
	</div>
	</div><?php */?>
									<div class="col-sm-12">
									  <?php 
									  $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
	
	if(($rule_dtls['comparative_ratio_range']) and $rule_dtls['salary_position_based_on']=="1"){	
		$deleteBtn = 0;
		foreach($crr_arr as $row)
		{ ?>
										  <div class="form-group rv1" id="dv_new_ratio_range_row" style="margin-bottom: 0px;">
											<div class="row">
											  <div class="col-sm-10">
												<input type="text" name="txt_crr[]" class="form-control" id="txt_crr" placeholder="Range" value="<?php echo $row['max']; ?>" required="required" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);">
											  </div>
											  <div class="col-sm-2 plft0" id="dv_btn_dlt">
												<?php if($deleteBtn == 0){ ?>
                         <button style="padding:4px 12px; margin-left:-6px;" type="button" class="btn btn-primary btn-w94" onclick="addAnotherRow();">ADD CRR </button>
                         <?php }else{ ?>
                        <button style="padding:4px 17px; margin-left:-6px;" type="button" class="btn btn-danger btn-w94" onclick="$(this).closest('.rv1').remove();">DELETE</button>
                        <?php } ?>
											  </div>
											</div>
										  </div>
										  <?php $deleteBtn++;
		}}else{ ?>
									  <div class="form-group rv1" id="dv_new_ratio_range_row" style="margin-bottom: 0px;">
										<div class="row">
										  <div class="col-sm-10">
											<input type="text" name="txt_crr[]" class="form-control distance_dvs" id="txt_crr" placeholder="Range" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);">
										  </div>
										  <div class="col-sm-2 plft0" id="dv_btn_dlt">
                          <button style="margin-top:1px; padding:4px 12px; margin-left:-6px;" type="button" class="btn btn-primary btn-w94" onclick="addAnotherRow();">ADD CRR </button>
                      </div>
										</div>
									  </div>
									  <?php }?>
									  <div class="row" id="dv_btn_add_row">
										<div class="col-sm-2 plft0 col-sm-offset-10">
										  <!-- <button style="padding:4px 12px; margin-left:-6px;" type="button" class="btn btn-primary" onclick="addAnotherRow();">ADD CRR </button> -->
										</div>
									  </div>
									</div>
								  </div>
								</div>
							</div>
                <div id="dv_quartile">
				
				<div class="col-sm-6 removed_padding">
				  <label class="control-label"> Apply market increase to bring employees to min salary</label>
				</div>
				<div class="col-sm-6 pad_right0">
				  <select class="form-control" id="ddl_bring_emp_to_min_sal" name="ddl_bring_emp_to_min_sal" required>
					<option value="1" <?php if($rule_dtls['bring_emp_to_min_sal'] == "1"){ echo 'selected="selected"'; } ?> >Yes</option>
					<option value="2" <?php if($rule_dtls['bring_emp_to_min_sal'] == "2"){ echo 'selected="selected"'; } ?> >No</option>
				  </select>
				</div>
				
                <div class="col-sm-6 removed_padding">
                <label class="control-label">Choose comparative ratio ranges to see employee population distribution <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[7] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                </div>
                <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-12" style="padding-right: 0px;">
                  <div class="quartile">          
                    <ul>
                    <?php $quartile_key_arr = array();
                    foreach($crr_arr as $key => $qk_row)
                    {
                      $quartile_key_arr[] = $key;
                    }
                    foreach($market_salary_elements_list as $mkt_row){?>
                      <li>
                      <div class="checkbox">
                        <label>
                        <input type="checkbox" name="chk_quartile[]" class="quartile_dvs" value="<?php echo $mkt_row["id"].CV_CONCATENATE_SYNTAX.$mkt_row["ba_name"].CV_CONCATENATE_SYNTAX.$mkt_row["display_name"]; ?>" <?php if(in_array($mkt_row["id"].CV_CONCATENATE_SYNTAX.$mkt_row["ba_name"], $quartile_key_arr)){echo "checked";} ?>>
                        <?php echo $mkt_row["display_name"]; ?> </label>
                      </div>
                      </li>
                     <?php } ?> 
                    </ul>
                  </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
							
						
							
                          </div>




                          <div class="">
                            <div class="rule_box clearfix">
                            <div class="col-sm-6 removed_padding">
                              <label class="control-label"><!-- Salary increment range on recommended %Age -->Manager’s Flexibility
                              <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Select a %age point will give managers a choice to give salary increase
recommendation within a pre-defined range. E.g. if 10 and 10 selected
in both higher and lower side and system recommends an ideal
increase of 10% the range will become 9% and 11%." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span><!-- The flexibility managers can have while recommending salary review  --></label>
                            </div>
                            <div class="col-sm-6">
                              <div class="row">
                                <div class="col-sm-12 pad_right0">
                                 <div class="sal_incre_rang">
                                  <span class="cantxt">Can go</span> <input type="text" name="txt_manager_discretionary_decrease" class="form-control range" required="required" value="<?php if($rule_dtls["Manager_discretionary_decrease"]){echo $rule_dtls["Manager_discretionary_decrease"];}else{echo "";} ?>" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this, 3);" onBlur="validate_percentage_onblure_common(this, 3);" /> <span class="low_high"> % age lower than recommended increase</span>
                                 </div>
                                </div>
                               
                                <div class="col-sm-12 pad_right0"> 
                                 <div class="sal_incre_rang">
                                  <span class="cantxt">Can go</span><input style="margin-left:3px;" type="text" name="txt_manager_discretionary_increase" class="form-control range" required="required" value="<?php if($rule_dtls["Manager_discretionary_increase"]){echo $rule_dtls["Manager_discretionary_increase"];}else{echo "";} ?>" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this, 3);" onBlur="validate_percentage_onblure_common(this, 3);"/> 
                                  <span class="low_high"> % age higher than recommended increase</span>
                                 </div>
                                </div>

                              </div>
                            </div>
                          </div>


                          <div class="rule_box clearfix">
                            <?php /*?><div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Standard promotion increase %age</label>
                            </div>
                            <div class="col-sm-6 pad_right0">
                              <input type="text" name="txt_standard_promotion_increase" value="<?php echo $rule_dtls["standard_promotion_increase"]; ?>" class="form-control" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);"/>
                            </div><?php */?>

                           

                            <div class="col-sm-6 removed_padding">
                              <label for="ddl_promotion_basis_on" class="control-label">Promotion Based On  <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Based on your internal promotion policy, select which parameter is to
be used to consider for promotion recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              </div>
                              <div class="col-sm-6 pad_right0">
                              <select class="form-control" id="ddl_promotion_basis_on" name="ddl_promotion_based_on" <?php if($rule_dtls["rule_refresh_status"]==1){ echo 'disabled'; } ?> onchange="get_promotion_basis_on_elements_list();" required="required">
							  <option value="0">NA</option>
                                <?php /*?><option <?php if($rule_dtls["promotion_basis_on"]==1){
                              echo 'selected';
                              } ?> value="1">Designation</option><?php */?>
                              <option <?php if($rule_dtls["promotion_basis_on"]==2){
                              echo 'selected';
                              } ?> value="2">Grade</option>
                              <option <?php if($rule_dtls["promotion_basis_on"]==3){
                              echo 'selected';
                              } ?> value="3">Level</option>

                              </select>
                              </div>
<div id="dv_promotion_basis_on_elements_list"></div>

                              <div class="col-sm-6 removed_padding">
                                <label class="control-label">Grade/level/Designation editable by managers <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Select “Yes” if you want to allow managers to change the
grade/level/designation while recommending for promotion." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              </div>
                              <div class="col-sm-6 pad_right0">
                                <select class="form-control" name="ddl_promotion_can_edit" required>
                                <option value="1" <?php if($rule_dtls['promotion_can_edit'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                                <option value="2" <?php if($rule_dtls['promotion_can_edit'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
                                </select>
                              </div>
                            </div>
							 


                      <div class="rule_box clearfix">
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Additional Field 1 (Optional) 
                                <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <input type="text" name="txt_esop_title" value="<?php echo $rule_dtls["esop_title"]; ?>" class="form-control" placeholder="Additional Field 1" maxlength="50"/>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <select class="form-control" id="ddl_esop_type" name="ddl_esop_type">
                                <option <?php if($rule_dtls["esop_type"]==1){
echo 'selected';
} ?> value="1">Numeric</option>
                                <option <?php if($rule_dtls["esop_type"]==2){
echo 'selected';
} ?> value="2">Alpha Numeric</option>
                                <option <?php if($rule_dtls["esop_type"]==3){
echo 'selected';
} ?> value="3">Percentage</option>
                              </select>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <select class="form-control" id="ddl_esop_right" name="ddl_esop_right">
                                  <option <?php if($rule_dtls["esop_right"]==1){
                                  echo 'selected';
                                  } ?> value="1">Approver 1</option>
                                  <option <?php if($rule_dtls["esop_right"]==2){
                                  echo 'selected';
                                  } ?> value="2">Approver 2</option>
                                  <option <?php if($rule_dtls["esop_right"]==3){
                                  echo 'selected';
                                  } ?> value="3">Approver 3</option>
                                  <option <?php if($rule_dtls["esop_right"]==4){
                                  echo 'selected';
                                  } ?> value="4">Approver 4</option>
                              </select>
                            </div>
                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Additional <!-- Recommendation --> Field 2 (Optional) <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select
                              which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <input type="text" name="txt_pay_per_title" value="<?php echo $rule_dtls["pay_per_title"]; ?>" class="form-control" placeholder="Additional Field 2" maxlength="50"/>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <select class="form-control" id="ddl_pay_per_type" name="ddl_pay_per_type">
                                <option <?php if($rule_dtls["pay_per_type"]==1){
echo 'selected';
} ?> value="1">Numeric</option>
                                <option <?php if($rule_dtls["pay_per_type"]==2){
echo 'selected';
} ?> value="2">Alpha Numeric</option>
                                <option <?php if($rule_dtls["pay_per_type"]==3){
echo 'selected';
} ?> value="3">Percentage</option>
                              </select>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <select class="form-control" id="ddl_pay_per_right" name="ddl_pay_per_right">
                                <option <?php if($rule_dtls["pay_per_right"]==1){
echo 'selected';
} ?> value="1">Approver 1</option>
                                <option <?php if($rule_dtls["pay_per_right"]==2){
echo 'selected';
} ?> value="2">Approver 2</option>
                                <option <?php if($rule_dtls["pay_per_right"]==3){
echo 'selected';
} ?> value="3">Approver 3</option>
                                <option <?php if($rule_dtls["pay_per_right"]==4){
echo 'selected';
} ?> value="4">Approver 4</option>
                              </select>
                            </div>



                            <div class="col-sm-6 removed_padding" style="display:none;">
                              <label for="inputPassword" class="control-label">Additional Field 3 (Optional) 
                                <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="top" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-2 pad_right0" style="display:none;">
                              <input type="text" name="txt_bonus_recommendation_title" value="<?php echo $rule_dtls["bonus_recommendation_title"]; ?>" class="form-control" placeholder="Additional Field 3" maxlength="50"/>
                            </div>
                            <div class="col-sm-2 pad_right0" style="display:none;">
                              <select class="form-control" id="ddl_bonus_recommendation_type" name="ddl_bonus_recommendation_type">
                                <option <?php if($rule_dtls["bonus_recommendation_type"]==1){
echo 'selected';
} ?> value="1">Numeric</option>
                                <option <?php if($rule_dtls["bonus_recommendation_type"]==2){
echo 'selected';
} ?> value="2">Alpha Numeric</option>
                                <option <?php if($rule_dtls["bonus_recommendation_type"]==3){
echo 'selected';
} ?> value="3">Percentage</option>
                              </select>
                            </div>





                            <div class="col-sm-2 pad_right0" style="display:none;">
                              <select class="form-control" id="ddl_bonus_recommendation_right" name="ddl_bonus_recommendation_right">
                                <option <?php if($rule_dtls["bonus_recommendation_right"]==1){
echo 'selected';
} ?> value="1">Approver 1</option>
                                <option <?php if($rule_dtls["bonus_recommendation_right"]==2){
echo 'selected';
} ?> value="2">Approver 2</option>
                                <option <?php if($rule_dtls["bonus_recommendation_right"]==3){
echo 'selected';
} ?> value="3">Approver 3</option>
                                <option <?php if($rule_dtls["bonus_recommendation_right"]==4){
echo 'selected';
} ?> value="4">Approver 4</option>
                              </select>
                            </div>

                           


                            <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Additional <!-- Recommendation --> Field 3 (Optional) <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="top" title=" Additional field are flexible fields to get any additional
recommendations from the managers while getting salary review
recommendation as per the above rules. You can also select
which type of input is needed and which approver level can give
this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-2 pad_right0 ">
                              <input type="text" name="txt_retention_bonus_title" value="<?php echo $rule_dtls["retention_bonus_title"]; ?>" class="form-control" placeholder="Additional Field 4" maxlength="50"/>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <select class="form-control" id="ddl_retention_bonus_type" name="ddl_retention_bonus_type">
                                <option <?php if($rule_dtls["retention_bonus_type"]==1){
echo 'selected';
} ?> value="1">Numeric</option>
                                <option <?php if($rule_dtls["retention_bonus_type"]==2){
echo 'selected';
} ?> value="2">Alpha Numeric</option>
                                <option <?php if($rule_dtls["retention_bonus_type"]==3){
echo 'selected';
} ?> value="3">Percentage</option>
                              </select>
                            </div>
                            <div class="col-sm-2 pad_right0">
                              <select class="form-control" id="ddl_retention_bonus_right" name="ddl_retention_bonus_right">
                                <option <?php if($rule_dtls["retention_bonus_right"]==1){
echo 'selected';
} ?> value="1">Approver 1</option>
                                <option <?php if($rule_dtls["retention_bonus_right"]==2){
echo 'selected';
} ?> value="2">Approver 2</option>
                                <option <?php if($rule_dtls["retention_bonus_right"]==3){
echo 'selected';
} ?> value="3">Approver 3</option>
                                <option <?php if($rule_dtls["retention_bonus_right"]==4){
echo 'selected';
} ?> value="4">Approver 4</option>
                              </select>
                            </div>
                          

                          <div style="display: none;">
                          <div class="col-sm-6 removed_padding" >
                              <label for="inputPassword" class="control-label">Select Bonus Rule <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="top" title=" If you bonus calculations are already concluded and you would
like to reflect the final bonus payout on manager’s salary review
recommendations, select the rule name here from bonus rules
list and managers will be able to see the final bonus paid or
being paid to employees." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6 pad_right0">
                              <select id="linked_bonus_rule_id"  name="linked_bonus_rule_id" class="form-control">
                                <option  value="">No Bonus Rule Selected</option>
                                  <?php foreach ($bonusListForSalaryRuleCreation as $row) { ?>
                                   <option value="<?=$row->id?>" <?=($rule_dtls["linked_bonus_rule_id"]==$row->id) ? 'selected': ''?> ><?=$row->bonus_rule_name?></option>
                                  <?php } ?>
                              </select>
                            </div>
                          </div>

                          </div>
						  
						
						
                          </div>



                          <div class="col-sm-10 col-sm-offset-2 paddr0" >
                            <div id="dv_frm_1_btn">
                              <input type="hidden" class="btn-w120" value="0" id="hf_show_next_step" name="hf_show_next_step" />
                              <input type="submit" class="btn-w120" id="btnAdd_1st" value="" style="display:none" />
                              <div class="col-sm-12 paddr0 mob-center text-right creatSam" > <a  class="btn btn-success mar_l_5 btn-w120" href="<?php echo site_url("salary-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Back</a>
                                <input type="button" id="btn_edit_next" value="<?php if($rule_dtls['status'] >= 2){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn mar_l_5 btn-success btn-w120" onclick="submit_frm('0');" />
                                <?php if($rule_dtls['status'] >= 2){?>
                                <input type="button" id="btn_next" value="Next Step" class="btn mar_l_5 btn-success btn-w120"  onclick="submit_frm('1');"/>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="incre_budget_table" id="dv_partial_page_data_2"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php /*?><div id="loading" style="position:absolute;width:100%;height:100%; top:0; z-index:9999; background:#000;display:none; opacity:.5;">
<img src="<?php echo base_url("assets/loading.gif"); ?>" style="width:20%; margin-left:40%; margin-top:10%;" />
</div><?php */?>

<script type="text/javascript">
function get_promotion_basis_on_elements_list()
{
	$("#dv_promotion_basis_on_elements_list").html("");
	var promotion_basis_on_val = $("#ddl_promotion_basis_on").val();
	if(promotion_basis_on_val>0)
	{		
		$.get("<?php echo site_url("rules/get_promotion_basis_on_elements_list/".$rule_dtls['id']);?>/"+promotion_basis_on_val, function(data)
		{
			$("#dv_promotion_basis_on_elements_list").html(data);
		});
	}
}
get_promotion_basis_on_elements_list();

function show_hide_budget_dv(val, to_currency, show_prorated_current_sal, is_need_pre_fill)
{
	<?php /*?>$("#txt_budget_amt").prop('required',false);
	$("#txt_budget_percent").prop('required',false);
	$("#dv_budget_amt").hide();
	$("#dv_budget_manual").hide();
	$("#dv_budget_per_incre").hide();
	
	if(val=='Automated locked')
	{
	$("#txt_budget_amt").prop('required',true);
	$("#dv_budget_amt").show();      
	}
	else if(val=='Automated but x% can exceed')
	{
	$("#txt_budget_amt").prop('required',true);
	$("#txt_budget_percent").prop('required',true);
	$("#dv_budget_amt").show();
	$("#dv_budget_per_incre").show();
	}
	else if(val=='Manual')
	{<?php */?>
	$("#dv_budget_manual").html("");
   $("#dv_budget_list_btn").hide();
	$("#dv_review_plan_btn").hide();
	$(".cls_x_per").hide();
	if(val=='Automated but x% can exceed')
	{
		$(".cls_x_per").show();
	}
	
	if(val != '')
	{
		$("#hrf_d_file_format").attr("href", "<?php echo site_url('rules/get_file_to_upload_x_increments/'.$rule_dtls['id']); ?>/"+to_currency+"/"+show_prorated_current_sal);
		
		$("#loading").css('display','block');
		$.post("<?php echo site_url("rules/get_managers_for_manual_bdgt");?>",{budget_type: val, to_currency: to_currency, show_prorated_current_sal:show_prorated_current_sal, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
		{
			if(data)
			{
				$("#dv_budget_manual").html(data);
				/*$("#dv_budget_manual").show();*/
        $("#dv_budget_list_btn").show();
				$("#dv_submit_3_step").show();
				$("#dv_review_plan_btn").show();
				if(is_need_pre_fill==1)
				{
					var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
					var i = 0;
					var items = [];               
					if(json_manual_budget_dtls)
					{
						$.each(JSON.parse(json_manual_budget_dtls),function(key,valll)
						{
							//alert(valll[0])
							<?php /*?>if(val=='Manual')
							{
							items.push(valll[1]);
							}<?php */?>
							if(val=='Automated but x% can exceed')
							{
							items.push(valll[2]);
							}
						});
					}
					<?php /*?>if(val=='Manual')
					{
						$("input[name='txt_manual_budget_amt[]']").each( function (key, v)
						{
							$(this).val(items[i]);
							//$(this).prop('readonly',true);
							calculat_percent_increased_val(1, items[i], (i+1));
							i++;    
						});
					}<?php */?>
					if(val=='Automated but x% can exceed')
					{
						$("input[name='txt_manual_budget_per[]']").each( function (key, v)
						{
							$(this).val(get_formated_percentage_common(items[i]));
							//$(this).prop('readonly',true);
							calculat_percent_increased_val(2, items[i], (i+1));
							i++;    
						});
					}
					<?php 
					if($this->session->flashdata('ses_open_by_quick_plan')==1)
					{ ?>
						setTimeout(function(){$("#frm_rule_step4").submit();},50);
					<?php } ?>
				}
				settabletxtcolor();
				<?php /*?>var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
				var i = 0;
				var items = [];
				if(json_manual_budget_dtls)
				{               
				$.each(JSON.parse(json_manual_budget_dtls),function(key,valll)
				{
				items.push(valll[1]);
				});
				$("input[name='txt_manual_budget_amt[]']").each( function (key, v)
				{
				$(this).val(items[i])
				i++;    
				});
				}			<?php */?>	 
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
	}
	<?php /*?>}<?php */?>
}

function addAnotherRow()
{    
var cl2 = $("#dv_new_ratio_range_row").clone()
.find("input:text").val("").end();
cl2.find("#dv_btn_dlt").html('<button style="margin-left:-6px;" type="button" class="btn btnp btn-danger btn-w94" onclick="$(this).closest(\'.rv1\').remove();">DELETE</button>');
cl2.insertBefore("#dv_btn_add_row");
cl2.find("input:text").focus();
}

// function addFixedPerAnotherRow()
// { 


// var cl2 = $("#dv_new_fixed_percentage_row").clone()
// .find("input:text").val("").end();

// cl2.find("#dv_btn_dlt_fixed_percentage").html('<button type="button" class="btn btn-danger" onclick="$(this).closest(\'.rv1\').remove();">DELETE</button>');
// cl2.insertBefore("#dv_btn_add_row_fixed_percentage");
// cl2.find(".txt_start_dt_fixed_per").removeClass('hasDatepicker');
//   cl2.find(".txt_end_dt_fixed_per").removeClass('hasDatepicker');
// cl2.find(".txt_start_dt_fixed_per").datepicker();
//   cl2.find(".txt_end_dt_fixed_per").datepicker();
// //cl2.find("input:text").datepicker();


// }


function submit_frm(is_next_step)
{
  
$("#hf_show_next_step").val(is_next_step);
$("#btnAdd_1st" ).trigger( "click" );

}
<?php 
if($this->session->flashdata('step')==1)
{ ?>

 $.get("<?php echo site_url("rules/get_salary_rule_step4_frm/".$rule_dtls["id"]);?>", function(data)
  {
  if(data)
  {
  $("#loading").css('display','none');
  $("#dv_frm_1_btn").html('');
  $("#dv_partial_page_data").html('');
  $("#dv_partial_page_data_2").html('');
  $("#dv_partial_page_data_2").html(data);
  }
  else
  {
  $("#loading").css('display','none');
  window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
  }
  }); 
<?php } ?>

function set_rules(frm)
{
	var form=$("#"+frm.id);
	if(frm.id == "frm_rule_step1")
	{
		if($("#ddl_salary_position_based_on").val()== "2")
		{
			var checked_quartile_chks_cnts = $("input[name='chk_quartile[]']:checked").length;		
			if(!checked_quartile_chks_cnts)
			{
				custom_alert_popup("You must check at least one Market Elements.");				
				setTimeout(function(){$("#loading").css('display','none');},1);
				return false;
			}
		}
	}
	
	//if(request_confirm()) {
	$("#loading").css('display','block');
	
	if(frm.id == "frm_rule_step4")
	{		
		return true;		
	}
	
	$.ajax({
	type:"POST",
	url:form.attr("action"),
	data:form.serialize(),
	success: function(response)
	{
	if(response==4)
	{
	$("#loading").css('display','none');
	//window.location.href= "<?php //echo site_url("view-rule-budget/".$rule_dtls["id"]);?>";
	<?php if($rule_dtls["rule_refresh_status"]==1){?>
		window.location.href= "<?php echo site_url("rules/refresh_salary_rule_data/".$rule_dtls["id"]);?>";
	<?php }else{ ?>
		window.location.href= "<?php echo site_url("view-salary-rule-details/".$rule_dtls["id"]);?>";
	<?php } ?>
	}
	else if(response==3)
	{
	$.get("<?php echo site_url("rules/get_salary_rule_step4_frm/".$rule_dtls["id"]);?>", function(data)
	{
	if(data)
	{
	$("#loading").css('display','none');
	$("#dv_frm_1_btn").html('');
	$("#dv_partial_page_data_2").html(data);
	}
	else
	{
	$("#loading").css('display','none');
	window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
	}
	}); 
	} 
	else if(response==2)
	{
	$.get("<?php echo site_url("rules/get_salary_rule_step3_frm/".$rule_dtls["id"]);?>", function(data)
	{
	if(data)
	{
	$("#loading").css('display','none');
	$("#dv_frm_1_btn").html('');
	$("#dv_partial_page_data").html('');
	$("#dv_partial_page_data_2").html('');
	$("#dv_partial_page_data_2").html(data);
	}
	else
	{
	$("#loading").css('display','none');
	window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
	}
	}); 
	} 
	else if(response==1)
	{
	$.get("<?php echo site_url("rules/get_salary_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
	{
	if(data)
	{
	$("#loading").css('display','none');
	$("#dv_frm_1_btn").html('');
	$("#spn_rule_name").html(' :- '+ $("#txt_salary_rule_name").val());
	$("#dv_frm_head").hide();
	$(".center_head").css("margin-bottom", "0px");
	$("#dv_partial_page_data").html('');
	$("#dv_partial_page_data_2").html(data);
	}
	else
	{
	$("#loading").css('display','none');
	window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
	}
	}); 
	}
	else
	{
	$("#loading").css('display','none');
	window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
	}
	}
	});
	return false;
	/*} else {*/
/*	return false;*/
/*	}*/



}

function manage_performnace_based_hikes(val)
{
<?php /*?> $("#txt_rating1").prop('required',false);
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
}<?php */?>	

if(val=='yes')
{
$.post("<?php echo site_url("rules/get_ratings_list");?>",{txt_name:'rating', rule_id:'<?php echo $rule_dtls['id']; ?>'}, function(data)
{
if(data)
{
<?php /*?> $("#dv_rating_list_yes").html(data);
$("input[name='ddl_market_salary_rating[]']").each( function (key, v)
{
$(this).val(items[i])
i++;	
});
$("#dv_rating_list_yes").show();<?php */?>
}
else
{
$("#ddl_performnace_based_hikes").val('no');
<?php /*?> $("#txt_rating1").prop('required',true);
$("#dv_rating_list_no").show();<?php */?>
$("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>No rating available.</b></span></div>');
$.magnificPopup.open({
items: {
src: '#common_popup_for_alert'
},
type: 'inline'
});
setTimeout(function(){$('#common_popup_for_alert').magnificPopup('close');},2000);
}
});
}
else if(val=='no')
{
<?php /*?> $("#txt_rating1").prop('required',true);
$("#txt_rating1").val(items[i]);
$("#dv_rating_list_no").show();<?php */?>
}
}

function manage_comparative_ratio(val)
{
$("#ddl_comparative_ratio1").prop('required',false);
//$("#dv_apply_comparative_ratio_no").hide();
$("#dv_btn_add_row").show();
//$("#dv_apply_comparative_ratio_yes").hide();    
//$("#dv_apply_comparative_ratio_yes").html('');


var jsonRating = '<?php echo $rule_dtls["comparative_ratio_calculations"]; ?>';
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
$.post("<?php echo site_url("rules/get_ratings_list");?>",{txt_name:'comparative_ratio', rule_id:'<?php echo $rule_dtls['id']; ?>'}, function(data)
{
if(data)
{
<?php /*?>$("#dv_apply_comparative_ratio_yes").html(data);
if(jsonRating)
{
$("select[name='ddl_market_salary_comparative_ratio[]']").each( function (key, v)
{
$(this).val(items[i])
i++;	
});
}
$("#dv_apply_comparative_ratio_yes").show();<?php */?>
}
else
{
$("#ddl_comparative_ratio").val('no');
manage_comparative_ratio($("#ddl_comparative_ratio").val());
<?php /*?>$("#ddl_comparative_ratio1").prop('required',true);<?php */?>

$("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>No rating available.</b></span></div>');
$.magnificPopup.open({
items: {
src: '#common_popup_for_alert'
},
type: 'inline'
});
setTimeout(function(){$('#common_popup_for_alert').magnificPopup('close');},2000);
}
});        
}
else if(val=='no')
{	
//$("#dv_btn_add_row").hide();
<?php /*?>var remove_cnt = 0;
$('.rv1').each(function() {
if(remove_cnt>0)
{
$(this).remove();
}
remove_cnt++;
});

$("#ddl_comparative_ratio1").prop('required',true);
$.post("<?php echo site_url("rules/get_comparative_ratio_element_for_no");?>", function(data)
{
if(data)
{
$("#ddl_comparative_ratio1").html(data);<?php */?> 
if(items[i] != null)
{  
$("#ddl_comparative_ratio1").val(items[i]); 
}
<?php /*?>}
else
{
$("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>Market salary elements are not available.</b></span></div>');
$.magnificPopup.open({
items: {
src: '#common_popup_for_alert'
},
type: 'inline'
});
setTimeout(function(){$('#common_popup_for_alert').magnificPopup('close');},2000);
}
$("#dv_apply_comparative_ratio_no").show();
});<?php */?> 
}
}

//Piy@17Dec19 
function calculat_percent_increased_val(typ, val, index_no)
{
  <?php /*?>if(typ==1)
  {
    //$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    $("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(val));
    var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100);
    $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
  }
  else<?php */?> if(typ==2)
  {
  var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100;
  var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1));
  $("#hf_additional_bdgt_per_"+ index_no).val(val);

  //$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
  $("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(revised_bdgt));
  var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100);
  $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
  $("#td_increased_amt_val_"+ index_no).html(get_formated_amount_common(increased_bdgt));
  $("#hf_increased_amt_val_"+ index_no).val(increased_bdgt);
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
   // amtval += ($("#td_increased_amt_val_"+ i).html().replace(/[^0-9.-]/g,''))*1;
    amtval += $("#hf_increased_amt_val_"+ i).val()*1;
  }
  //val = (($("#th_total_budget_plan").html().replace(/[^0-9.]/g,''))*1) + amtval; 
  val = ($("#hf_total_budget_plan").val()*1) + amtval;  

  var per = (val/$("#hf_total_current_sal").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');
  $("#txt_standard_bdgt_per").val(get_formated_percentage_common(per));

  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  
  per = (amtval/$("#hf_total_current_sal").val()*100);
  $("#th_total_budget_manual").html(get_formated_percentage_common(per) + ' %');

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}

function show_standard_bdgt_dv_to_managers()
{
	$("#th_final_per").hide();
	$("#rv_input_standard_bdgt_per_dv_to_managers").show();
  $("#standard_bdgt_per_edit").hide(); 
}

function hide_standard_bdgt_dv_to_managers()
{
  $("#th_final_per").show();
  $("#rv_input_standard_bdgt_per_dv_to_managers").hide();
  $("#standard_bdgt_per_edit").show(); 
}



function allocate_standard_bdgt_to_managers()
{	
	var standard_bdgt_bdgt_per = $("#txt_standard_bdgt_per").val()*1; 
	if(standard_bdgt_bdgt_per<=0)
	{
		return false;
	}
	var index_no = 1;
	$("input[name='txt_manual_budget_per[]']").each( function (key, v)
	{
		var manager_rule_base_bdgt_per = $("#hf_manager_rule_base_bdgt_per_"+ index_no).val()*1;
		
		var additional_bdgt_per = 0;
		if(manager_rule_base_bdgt_per != 0)
		{
			additional_bdgt_per = ((standard_bdgt_bdgt_per - manager_rule_base_bdgt_per)/manager_rule_base_bdgt_per)*100;
		}
		$("#hf_additional_bdgt_per_"+ index_no).val(additional_bdgt_per);
		/*if(additional_bdgt_per < 0)
		{
			additional_bdgt_per = 0;
		}*/
	
		var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*additional_bdgt_per)/100;
		var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1));		
		$("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(revised_bdgt));
		var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100);
		$("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
		$("#td_increased_amt_val_"+ index_no).html(get_formated_amount_common(increased_bdgt));
		$("#hf_increased_amt_val_"+ index_no).val(increased_bdgt);		
		
		$(this).val(get_formated_percentage_common(additional_bdgt_per));
		index_no++;
	});	
	calculat_total_revised_bgt();
	hide_standard_bdgt_dv_to_managers();
}
/*
function calculat_percent_increased_val(typ, val, index_no)
{
  //console.log(typ);
if(typ==1)
{
$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));	
var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
$("#td_increased_amt_"+ index_no).html(increased_amt+' %');	
//$("#td_increased_amt_val_"+ index_no).html(val).toFixed(0); 
}
else if(typ==2)
{
var increased_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100).toFixed(0);
var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));	
var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
$("#td_increased_amt_"+ index_no).html(increased_amt+' %');	
$("#td_increased_amt_val_"+ index_no).html(increased_bdgt); 
}
calculat_total_revised_bgt();
var totalrevised= ($("#th_total_budget").html().replace(/[^0-9.]/g,''))*1;
var totalplan= ($("#th_total_budget_plan").html().replace(/[^0-9.]/g,''))*1;
var val =totalrevised-totalplan;
var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
$("#th_additional_budget_manual").html(formated_val);
}

function calculat_total_revised_bgt()
{
var manager_cnt = $("#hf_manager_cnt").val();
var val = 0;
for(var i=1; i<manager_cnt; i++)
{
val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
}

var per = (val/$("#hf_total_current_sal").val()*100).toFixed(2);
$("#th_final_per").html(per + ' %');

var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
$("#th_total_budget").html(formated_val);
$("#th_total_budget_manual").html(formated_val);
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

if(((that.value).split('.')).length==2)
{
var arr = (that.value).split('.');
if(arr[1].length>2)
{
that.value=arr[0]+"."+arr[1].substring(0,2);
}     
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

if(((that.value).split('.')).length==2)
{
var arr = (that.value).split('.');
if(arr[1].length>2)
{
that.value=arr[0]+"."+arr[1].substring(0,2);
}     
}

if((that.value) && Number(that.value)<=0)
{
that.value="0";
}
}

function roundToTwo(num) {    
return +(Math.round(num + "e+2")  + "e-2");
}

$.post("<?php echo site_url("rules/get_comparative_ratio_element_for_no");?>", function(data)
{
if(data)
{
$("#ddl_comparative_ratio1").html(data);   
//$("#ddl_comparative_ratio1").val(items[i]);  
<?php if($rule_dtls['default_market_benchmark']){ ?>
$("#ddl_comparative_ratio1").val('<?php echo $rule_dtls['default_market_benchmark']; ?>');  
<?php } ?>      
}
else
{
$("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>Market salary elements are not available.</b></span></div>');
$.magnificPopup.open({
items: {
src: '#common_popup_for_alert'
},
type: 'inline'
});
setTimeout(function(){$('#common_popup_for_alert').magnificPopup('close');},2000);
}
$("#dv_apply_comparative_ratio_no").show();
});

manage_performnace_based_hikes('<?php echo $rule_dtls['performnace_based_hike'];?>');
manage_comparative_ratio('<?php echo $rule_dtls['comparative_ratio'];?>');


</script>
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
<script> 
function manage_salary_position_based_on()
{
	if($("#ddl_salary_position_based_on").val()== "2")
	{
		$("#dv_distance_for_crr").hide();
		$("#dv_quartile").show();
		//$(".quartile_dvs").prop('required',true);
		$(".distance_dvs").prop('required',false);
	}
	else
	{
		$("#dv_distance_for_crr").show();
		$("#dv_quartile").hide();
		//$(".quartile_dvs").prop('required',false);
		$(".distance_dvs").prop('required',true);
	}
}


function toggle_pro_rated_period()
{
	if($("#ddl_prorated_increase").val()=="no")
	{
		$(".pro-rated-period").hide();
		$(".fixed-percentage").hide();
		$("#txt_start_dt").val('00/00/0000');
		$("#txt_end_dt").val('00/00/0000');
	}
	else if ($("#ddl_prorated_increase").val()=="fixed-percentage")
	{
		$(".pro-rated-period").hide();
		$(".fixed-percentage").show();
	}
	else if($("#ddl_prorated_increase").val()=="fixed_period")
	{
		$(".pro-rated-period").show();
		$(".fixed-percentage").hide();
		if($("#txt_start_dt").val()=="00/00/0000")
		{
			$("#txt_start_dt").val('');
		}
		if($("#txt_end_dt").val()=="00/00/0000")
		{
			$("#txt_end_dt").val('');
		}
	}
	else
	{
		$(".pro-rated-period").hide();
		$(".fixed-percentage").hide();
		if($("#txt_start_dt").val()=="00/00/0000")
		{
			$("#txt_start_dt").val('');
		}
		if($("#txt_end_dt").val()=="00/00/0000")
		{
			$("#txt_end_dt").val('');
		}
	}
}

$(document).ready(function()
{
$( "#txt_pp_start_dt,#txt_pp_end_dt,#txt_start_dt,#txt_end_dt" ).datepicker({ 
dateFormat: 'dd/mm/yy',
changeMonth : true,
changeYear : true,
// yearRange: "1995:new Date().getFullYear()",
}); 

toggle_pro_rated_period(); 
manage_salary_position_based_on();

$('.addFixedPerAnotherRow').click(function(){
    $('#add_fixed_percentage').append('<div style="margin-bottom:0px;" class="form-group rv1" id="dv_new_fixed_percentage_row"><div class="row"><div class="col-sm-12"><div class="col-sm-3 plft0"><input type="text"  name="txt_start_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per" maxlength="10"  value="" placeholder="From Date"  onblur="checkDateFormat(this)" /></div><div class="col-sm-3 plft0"><input type="text"  name="txt_end_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per" maxlength="10"  value="" placeholder="To Date"  onblur="checkDateFormat(this)" /></div><div class="col-sm-4 plft0 prit0"><input type="text" id="txt_fixed_per" name="txt_fixed_per[]" class="form-control" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age"/></div><div class="col-sm-2" id="dv_btn_dlt_fixed_percentage"><button style="margin-left:4px;" type="button" class="btn btnp btn-danger btn-w90" onclick="$(this).closest(\'.rv1\').remove();">DELETE</button></div></div></div></div>');
});
});
$('body').on('focus',".txt_start_dt_fixed_per", function(){
    $(this).datepicker({ 
dateFormat: 'dd/mm/yy',
changeMonth : true,
changeYear : true,
// yearRange: "1995:new Date().getFullYear()",
});
});
$('body').on('focus',".txt_end_dt_fixed_per", function(){
    $(this).datepicker({ 
dateFormat: 'dd/mm/yy',
changeMonth : true,
changeYear : true,
// yearRange: "1995:new Date().getFullYear()",
});
});
function CheckFromDateToDate(FromDate, ToDate) 
{
//document.getElementById("spn_error_msg").innerHTML ="";
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
//alert("Start date must be less than end date.");
//document.getElementById("spn_error_msg").innerHTML ="<div align='left' style='color:red;'><b>Start date must be less than end date.</b></div>";
document.getElementById(FromDate).value = "";
//play_msg("Start date must be less than end date.");
return false;
}
else {
return true;
}
}

function validate_type_of_hike_can_edit_options(obj)
{
	var checked_cnt = 0;
	var is_need_error_show = false;
	//var sList = "";
	$("input:checkbox[name^='chk_type_of_hike_can_edit']").each(function () {
		//sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
		if(this.checked)
		{
			checked_cnt++;
		}
		if(checked_cnt > 1 && $('#chk_total_hike').is(":checked")== true)
		{
			checked_cnt--;
			$(obj).prop("checked", false);
			is_need_error_show = true;
		}
	});				
	if(is_need_error_show)
	{
		custom_alert_popup("You can select 'Total' hike or 'Merit/Market/Promotion' hikes.");
	}
	if(checked_cnt<1)
	{
		$('#chk_merit_hike').prop('required',true);
	}
	else
	{
		$('#chk_merit_hike').prop('required',false);
	}
}
</script>

