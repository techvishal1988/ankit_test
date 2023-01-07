<!-- **************** Filter form css Start ***************** -->
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style type="text/css">
  /********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/


.rule-form table tr td.com_bg_colo_sal{background-color:<?php echo  hex2rgb($this->session->userdata('company_light_color_ses'),"0.1"); ?>!important;}

.fstMultipleMode { display: block; }
/* .fstMultipleMode .fstControls {width:23.2em !important; } */
.fstQueryInput{width:12px !important;}
.my-form{background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.control-label {
  line-height:30px;
  font-size: 11.25px;
  <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
  background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?> !important;
  color: #000;
  margin-bottom:10px;
}

.form_head {
  background-color: #f2f2f2;
  <?php /*?>border-top: 8px solid #93c301;<?php */?>
  border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
}

.rule-form .control-label {
  <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
  background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>;
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

</style>
<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid">
    <div class="row">
      <div class="col-sm-8" style="padding-left: 0px;">
        <ol class="breadcrumb wn_btn">
          <li><a href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
          <li><a href="<?php echo site_url("salary-rule-list/".$rule_dtls['performance_cycle_id']); ?>">Rule List</a></li>
          <li class="active"><span>View Salary Rule Details</span></li>
        </ol>
      </div>
      <div class="col-sm-4 padr0"> <a class="pull-right btn btn-primary viewBtn" href="javascript:void(0)" onclick="printPage('<?php echo base_url() ?>print-preview-salary/<?php echo $rule_dtls['id'] ?>');">Print</a> </div>
    </div>
  </div>
</div>
<div id="main-wrapper" class="container-fluid compp_fluid input-pointer-disable">
<!-- container -->
<div class="row">
  <div class="col-md-12" id="area">
    <div class="mb20">
      <div class="panel panel-white"> <?php echo $this->session->flashdata('message');
          
             
            $tooltip=getToolTip('salary-rule-filter');
            $page1=json_decode($tooltip[0]->step); 
                  $t2=getToolTip('salary-rule-page-2');
            $page2=json_decode($t2[0]->step); 
            $t3=getToolTip('salary-rule-page-3');
            $page3=json_decode($t3[0]->step); 
             
             $t4=getToolTip('salary-rule-page-4');
             $page4=json_decode($t4[0]->step); 
            ?>
        <div class="panel-body" >
          <!-- **************** Filter form HTML Start ***************** -->
          <div  class="salary_rt_ftr" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default" >
              <div class="panel-heading pading" role="tab" id="headingOne" >
                <div class="form_head clearfix" style="padding:0px; border:0px !important; border-radius:0px; box-shadow:0px 0px 0px 0px #d6d6d6 !important;">
                  <div class="col-sm-12">
                    <ul style="padding-top: 8px;">
                      <li>
                        <!-- <div class="form_tittle">
                          <h4 style="cursor:pointer; color:#00adef" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i  class="more-less glyphicon glyphicon-minus"></i> employee segments to be covered</h4>
                        </div> -->
                        <div class="form_tittle">
                          <h4 style="cursor:pointer; color:#000;" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i style="display: none;"  class="more-less glyphicon glyphicon-minus"></i> employee segments to be covered</h4>
                        </div>
                      </li>
                      <li>
                        <div class="form_info">
                          <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page1[0]?$page1[0]:'Select your employee population to cover under this plan. All the filter are interloped but they will only show the impact upon clicking “Confirm Selection” at the bottom right of the page.'; ?>"><i style="font-size: 20px;" class="themeclr fa fa-info-circle" aria-hidden="true"></i></button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <div class="form_sec clearfix">
                    <form class="form-horizontal" method="post" action="">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Country</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($country_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['country']) and in_array($row["id"], $rule_dtls['country'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">City</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_city" onchange="hide_list('ddl_city');" name="ddl_city[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($city_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['city']) and in_array($row["id"], $rule_dtls['city'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Bussiness Level 1</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($bussiness_level_1_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level1']) and in_array($row["id"], $rule_dtls['business_level1'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Bussiness Level 2</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($bussiness_level_2_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level2']) and in_array($row["id"], $rule_dtls['business_level2'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Bussiness Level 3</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($bussiness_level_3_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level3']) and in_array($row["id"], $rule_dtls['business_level3'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Function</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_function" onchange="hide_list('ddl_function');" name="ddl_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($function_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['functions']) and in_array($row["id"], $rule_dtls['functions'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Sub Function</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_sub_function" onchange="hide_list('ddl_sub_function');" name="ddl_sub_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($sub_function_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_functions']) and in_array($row["id"], $rule_dtls['sub_functions'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
						  
						  <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Sub Sub Function</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_sub_subfunction" onchange="hide_list('ddl_sub_subfunction');" name="ddl_sub_subfunction[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($sub_subfunction_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_subfunctions']) and in_array($row["id"], $rule_dtls['sub_subfunctions'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
						  
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Designation</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($designation_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['designations']) and in_array($row["id"], $rule_dtls['designations'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
						  <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Tenure in the company</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_tenure_company" onchange="hide_list('ddl_tenure_company');" name="ddl_tenure_company[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php for($i=0; $i<=35; $i++){?>
                                  <option  value="<?php echo $i; ?>" <?php if(isset($rule_dtls['tenure_company']) and in_array($i, $rule_dtls['tenure_company'])){echo 'selected="selected"';}?>><?php echo $i; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
						  
						  <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Effective Date</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <input id="txt_effective_dt" name="txt_effective_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($rule_dtls["effective_dt"]) and $rule_dtls["effective_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["effective_dt"]));} ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)">
                              </div>
                            </div>
                          </div>
						  
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Grade</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($grade_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['grades']) and in_array($row["id"], $rule_dtls['grades'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Level</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($level_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['levels']) and in_array($row["id"], $rule_dtls['levels'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Education</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_education" onchange="hide_list('ddl_education');" name="ddl_education[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($education_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['educations']) and in_array($row["id"], $rule_dtls['educations'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Critical Talent</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_critical_talent" onchange="hide_list('ddl_critical_talent');" name="ddl_critical_talent[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($critical_talent_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['critical_talents']) and in_array($row["id"], $rule_dtls['critical_talents'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Critical Position</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_critical_position" onchange="hide_list('ddl_critical_position');" name="ddl_critical_position[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($critical_position_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['critical_positions']) and in_array($row["id"], $rule_dtls['critical_positions'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Special Category</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_cspecial_category" onchange="hide_list('ddl_cspecial_category');" name="ddl_special_category[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php foreach($special_category_list as $row){?>
                                  <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['special_category']) and in_array($row["id"], $rule_dtls['special_category'])){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
						  
						<div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Cost Center</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_cost_center" onchange="hide_list('ddl_cost_center');" name="ddl_cost_center[]" class="form-control multipleSelect" required="required" multiple="multiple">
                          <?php 
if(!empty($cost_center_list)){?>
  <option  value="all">All</option>
  <?php foreach($cost_center_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['cost_centers']) and in_array($row["id"], $rule_dtls['cost_centers'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                          <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
						<div class="form-group my-form attireBlock">
						  <label class="col-sm-4 col-xs-12 control-label removed_padding">Employee Type</label>
						  <div class="col-sm-8 col-xs-12 removed_padding">
							<div class="">
							  <select id="ddl_employee_type" onchange="hide_list('ddl_employee_type');" name="ddl_employee_type[]" class="form-control multipleSelect" required="required" multiple="multiple">
							  <?php 
						if(!empty($employee_type_list)){?>
						<option  value="all">All</option>
						<?php foreach($employee_type_list as $row){?>
								<option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['employee_types']) and in_array($row["id"], $rule_dtls['employee_types'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
							  <?php } }else{ ?>
						<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
								<?php } ?>
							  </select>
							</div>
						  </div>
						</div>
						<div class="form-group my-form attireBlock">
						  <label class="col-sm-4 col-xs-12 control-label removed_padding">Employee Role</label>
						  <div class="col-sm-8 col-xs-12 removed_padding">
							<div class="">
							  <select id="ddl_employee_role" onchange="hide_list('ddl_employee_role');" name="ddl_employee_role[]" class="form-control multipleSelect" required="required" multiple="multiple">
							  <?php 
						if(!empty($employee_role_list)){?>
						<option  value="all">All</option>
						<?php foreach($employee_role_list as $row){?>
								<option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['employee_roles']) and in_array($row["id"], $rule_dtls['employee_roles'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
							  <?php } }else{ ?>
						<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
								<?php } ?>
							  </select>
							</div>
						  </div>
						</div>
						  
                          
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Tenure in the Role</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <select id="ddl_tenure_role" onchange="hide_list('ddl_tenure_role');" name="ddl_tenure_role[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                  <option  value="all">All</option>
                                  <?php for($i=0; $i<=35; $i++){?>
                                  <option  value="<?php echo $i; ?>" <?php if(isset($rule_dtls['tenure_roles']) and in_array($i, $rule_dtls['tenure_roles'])){echo 'selected="selected"';}?>><?php echo $i; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group my-form attireBlock">
                            <label class="col-sm-4 control-label removed_padding">Cutoff Date</label>
                            <div class="col-sm-8 removed_padding">
                              <div class="">
                                <input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($rule_dtls["cutoff_date"]) and $rule_dtls["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["cutoff_date"]));} ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- **************** Filter form HTML End ***************** -->
          <div class="rule-form">
            <div class="">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form_head clearfix">
                    <div class="col-sm-12">
                      <ul>
                        <li>
                          <div class="form_tittle">
                            <h4>Define Basic Rules</h4>
                          </div>
                        </li>
                        <li>
                          <div class="form_info">
                            <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[0]?$page2[0]:'Define basic rules to setup your compensation plan which will impact your increment grid as well as budget allocation.'; ?>"><i style="font-size: 20px;" class="themeclr fa fa-info-circle" aria-hidden="true"></i></button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="form_sec clearfix pointnoneclass">
                    <div class="col-sm-12">
                     <div class="rule_box clearfix">
                      <div class="col-sm-6 removed_padding">
                        <label for="inputEmail3" class="control-label">Plan Name</label>
                      </div>
                      <div class="col-sm-6 pad_right0">
                        <div class="form-input">
                          <input type="text" name="txt_performance_cycle" class="form-control" value="<?php echo $rule_dtls["name"]; ?>" readonly="readonly"/>
                        </div>
                      </div>
                      <div class="col-sm-6 removed_padding">
                        <label for="inputPassword" class="control-label">Salary Rule Name <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Write name of this specific rule which will be displayed to all users." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                      </div>
                      <div class="col-sm-6 pad_right0">
                        <input type="text" name="txt_salary_rule_name" class="form-control" value="<?php echo $rule_dtls["salary_rule_name"]; ?>" readonly="readonly"/>
                      </div>
                      <div class="col-sm-6 removed_padding">
                          <label for="inputPassword" class="control-label">Include inactive employees <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[2]?:'Click “Yes” In case all in-active employees to be covered in this plan eg. Maternity case, long leave cases, etc. ' ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0">
                          <select class="form-control" name="ddl_include_inactive" disabled="disabled">
                            <option value="">Select</option>
                            <option value="yes" <?php if($rule_dtls["include_inactive"]=="yes"){echo 'selected="selected"';} ?> >Yes</option>
                            <option value="no" <?php if($rule_dtls["include_inactive"]=="no"){echo 'selected="selected"';} ?> >No</option>
                          </select>
                        </div>
						
						<div class="col-sm-6 removed_padding">
								<label class="control-label">Performance Period <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Define your performance period which will mainly be used to calculate the pro-rated increase for the employees joined between this period." ><i class="fa fa-info" aria-hidden="true"></i></span></label>
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

                    <div class="rule_box clearfix">
                      <div class="col-sm-6 removed_padding">
                      <label class="control-label">Apply prorated increase calculations <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Select your proration rule from the option given here. “Simple proration for all employees” means whoever has joined during the performance period, will get prorated increase based on the number of days spent during this period.“Simple proration for fixed period” means that proration will only be applied to employee who have joined during the period defined under this selection.“No Proration” means all employees will get full increase.“Fixed %Age proration” means the employees joined between a specific period will get a fixed multiplier of the eligible increase as defined under this rule. E.g. if employee joined between 1-Oct to 31-Dec you can choose to give them fixed 50% of their eligible increase instead of day wise proration." ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                      </div>
                      <div class="col-sm-6 pad_right0">
                      <select class="form-control" id="ddl_prorated_increase" name="ddl_prorated_increase">
                        <option value="yes" <?php if($rule_dtls['prorated_increase'] == 'yes'){ echo 'selected="selected"'; } ?> >Simple Proration For All Employees</option>
						<option value="fixed_period" <?php if($rule_dtls['prorated_increase'] == 'fixed_period'){ echo 'selected="selected"'; } ?> >Simple Proration For Fixed Period</option>
                        <option value="no" <?php if($rule_dtls['prorated_increase'] == 'no'){ echo 'selected="selected"'; } ?> >No</option>
                        <option value="fixed-percentage" <?php if($rule_dtls['prorated_increase'] == 'fixed-percentage'){ echo 'selected="selected"'; } ?> >Fixed %ages</option>
                      </select>
                      </div>
                      <div class="col-sm-6 removed_padding pro-rated-period">
                      <label class="control-label">Performance period for pro-rated calculations </label>
                      </div>
                      <div class="col-sm-6 pro-rated-period">
                      <div class="row">
                        <div class="col-sm-6 pad_right0">
                        <input type="text" id="txt_start_dt" name="txt_start_dt" class="form-control" maxlength="10" value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="Start Date" autocomplete="off" onkeypress="return false;" />
                        </div>
                        <div class="col-sm-6 pad_right0">
                        <input type="text" id="txt_end_dt" name="txt_end_dt" class="form-control" maxlength="10" value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="End Date" autocomplete="off" onkeypress="return false;" />
                        </div>
                      </div>
                      </div>
                      </div>


                      <div class="col-sm-6 removed_padding fixed-percentage">
                      <label class="control-label">Fixed %ages for a range of DOJ</label>
                      </div>
                        <div class="col-sm-6 fixed-percentage" >
                        <div class="row">
                          <div class="col-sm-12">
                          <div id="add_fixed_percentage">
                            <?php 
                        if($rule_dtls['fixed_percentage_range_of_doj']){
                        
                        $fixed_percentage_arr = json_decode($rule_dtls["fixed_percentage_range_of_doj"], true);
                        
                          foreach($fixed_percentage_arr as $row)
                          {?>
                            <div class="form-group rv1" id="dv_new_fixed_percentage_row">
                            <div class="row">
                            
                              <div class="col-sm-4 plft0">
                              <input type="text"  name="txt_start_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per " maxlength="10"  value="<?php if($row["From"] != "0000-00-00"){ echo $row["From"];;} ?>" placeholder="From Date" />
                              </div>
                              <div class="col-sm-4 plft0">
                              <input type="text"  name="txt_end_dt_fixed_per[]" class="form-control txt_end_dt_fixed_per" maxlength="10" value="<?php if($row["To"] != "0000-00-00"){ echo $row["To"];;} ?>" placeholder="To Date" />
                              </div>
                              <div class="col-sm-4 plft0">
                              <input type="text" id="txt_fixed_per" name="txt_fixed_per[]" class="form-control txt_fixed_per" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age" value="<?php if($row["Percentage"] != "0000-00-00"){ echo $row["Percentage"];;} ?>" />
                              </div>
                             
                            
                            </div>
                            </div>
                            <?php  
                          }
                        } else{?>
                            <div class="form-group rv1" id="dv_new_fixed_percentage_row">
                            <div class="row">
                            
                              <div class="col-sm-3 plft0">
                              <input type="text"  name="txt_start_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per" maxlength="10"  value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="From Date" />
                              </div>
                              <div class="col-sm-3 plft0">
                              <input type="text"  name="txt_end_dt_fixed_per[]" class="form-control txt_start_dt_fixed_per" maxlength="10"  value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="To Date" />
                              </div>
                              <div class="col-sm-4 plft0">
                              <input type="text" id="txt_fixed_per" name="txt_fixed_per[]" class="form-control" maxlength="5" onkeyup="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this);" placeholder="Fixed %age"/>
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
                      <div class="col-sm-12 clearfix">
                       <div class="rule_box clearfix">
                        <div class="col-sm-6 removed_padding">
                          <label for="inputPassword" class="control-label">Salary elements to be reviewed <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[1]?$page2[1]:'Select which salary element this salary review will impact. ' ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0" style="margin-bottom:12px;">
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
                          <label class="control-label">Show Variable Salary To Managers <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Select “Yes” if you want to show both current and revised variable pay on manager’s salary review screen. This will reflect information from the Target bonus column from the database along" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
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
															<input type="checkbox" class="quartile_dvs" value="<?php echo CV_SALARY_MERIT_HIKE; ?>" <?php if(in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?> >Merit
														</label>
													</div>
												</li>
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="quartile_dvs" value="<?php echo CV_SALARY_MARKET_HIKE; ?>" <?php if(in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?>>Market Correction
														</label>
													</div>
												</li>
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="quartile_dvs" value="<?php echo CV_SALARY_PROMOTION_HIKE; ?>" <?php if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?>>Promotion
														</label>
													</div>
												</li>
												<li>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="quartile_dvs" value="<?php echo CV_SALARY_TOTAL_HIKE; ?>" <?php if(in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr)){echo "checked";} ?> >Total
														</label>
													</div>
												</li>								
											</ul>
										</div>
									</div>
								</div>
							</div>
                        </div>

                        
                       <div class="rule_box clearfix">
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Performance based salary increase <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[3]?$page2[3]:'Select “Yes” if using performance based salary differentiation model for your salary review.' ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0">
                          <select class="form-control" id="ddl_performnace_based_hikes" name="ddl_performnace_based_hikes" disabled="disabled">
                            <option value="">Select</option>
                            <option value="yes" <?php if($rule_dtls["performnace_based_hike"]=="yes"){echo 'selected="selected"';} ?>>Yes</option>
                            <option value="no" <?php if($rule_dtls["performnace_based_hike"]=="no"){echo 'selected="selected"';} ?>>No</option>
                          </select>
                        </div>
            
            <div class="col-sm-6 removed_padding">
              <label class="control-label">Manager’s can change the ratings <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="This will allow managers to change the ratings of their team members at their end itself and will also change the salary increase as defined in the increment grid below for each rating." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            </div>
            <div class="col-sm-6 pad_right0">
              <select class="form-control" name="ddl_manager_can_change_rating" required>
              <option value="1" <?php if($rule_dtls['manager_can_change_rating'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
              <option value="2" <?php if($rule_dtls['manager_can_change_rating'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
              </select>
            </div>
             <div class="col-sm-6 removed_padding">
            <label class="control-label">Show Performance Achievement  To Managers  <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Select “Yes” if you want to show the performance achievement %age also along with the performance rating
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
                          <label class="control-label">Pay range comparison after merit increase <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[4]?$page2[4]:'Select “Yes” if you want to calculate employee parity with the selected pay range after applying performance/merit based salary increase on the current salary.' ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0">
                          <select class="form-control" id="ddl_comparative_ratio" name="ddl_comparative_ratio" disabled="disabled">
                            <option value="">Select</option>
                            <option value="yes" <?php if($rule_dtls["comparative_ratio"]=="yes"){echo 'selected="selected"';} ?>>Yes</option>
                            <option value="no" <?php if($rule_dtls["comparative_ratio"]=="no"){echo 'selected="selected"';} ?>>No</option>
                          </select>
                        </div>
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Pay Range comparison model<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[5]?$page2[5]:'Select which salary increase model you would like to choose between :-
                              1. Current salary distance from the target position or
                              2. Current salary positioning in on a pay range (quartile positioning)' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0">
                          <select class="form-control" id="ddl_salary_position_based_on" name="ddl_salary_position_based_on">
                            <!--<option value="">Select</option>-->
                            <option value="1" <?php if($rule_dtls['salary_position_based_on'] == "1"){ echo 'selected="selected"'; } ?> >Distance</option>
                            <option value="2" <?php if($rule_dtls['salary_position_based_on'] == "2"){ echo 'selected="selected"'; } ?> >Quartile</option>
                          </select>
                        </div>
                        <?php if($rule_dtls['salary_position_based_on']=="1"){ ?>
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Select target positioning <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[6]?$page2[6]:'Select the target positioning for all your employees from the list of pay range data points you have uploaded.' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0">
                          <select class="form-control" id="ddl_comparative_ratio1" name="ddl_comparative_ratio1">
                          </select>
                        </div>
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Create comparative ratios <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[7]?$page2[7]:'On the distance model drop down write in the information icon - “Select the standard %ile positioning for all employees”.
                                  In this rule, there will be another drop down with information icon and write there :-
                                 “Define your Comparative ratio ranges to propose salary increase for difference CR ranges.”
                                  In the quartile model page rule, write in the information icon– “Select multiple ranges to identify your population indifferent quartile of your pay range to propose salary increase.”' ?>" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_right0">
                          <div class="row">
                            <div class="col-sm-12">
                              <?php
                  
                  $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                  foreach($crr_arr as $row)
                  {     
                  echo '<div class="form-group rv1" id="dv_new_ratio_range_row">
                    <div class="row">
                      <div class="col-sm-12">
                        <input type="text" name="txt_crr[]" class="form-control" value="'.$row["max"].'" readonly="readonly">
                      </div>
                    </div>
                  </div>';
                  }                           
                  ?>
                            </div>
                          </div>
                        </div>
                        <?php }else{?>
						
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
                          <label class="control-label">Choose comparative ratio ranges to see employee population distribution <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page2[7] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="quartile">
                                <ul>
                                  <?php 
                    //echo $rule_dtls["comparative_ratio_range"];
                    $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                    $quartile_key_arr = array();
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
                        <?php } ?>
                      </div>
                    </div>
                  </div>


              
                    <div class="col-sm-12">
                      <div class="rule_box clearfix">
                      <div class="col-sm-6 removed_padding">
                        <label class="control-label">Manager’s Flexibility <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom"title="Select a %age point will give managers a choice to give salary increase recommendation within a pre-defined range. E.g. if 10 and 10 selected
in both higher and lower side and system recommends an ideal increase of 10% the range will become 9% and 11%." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                      </div>
                      <div class="col-sm-6">
                        <div class="row">

                          <div class="col-sm-12 pad_right0">
                             <div class="sal_incre_rang">
                              <span class="cantxt">Can go</span> <input style="margin-top:0px;" type="text" name="txt_manager_discretionary_decrease" class="form-control range" required="required" value="<?=$rule_dtls["Manager_discretionary_decrease"]?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" /> <span class="low_high"> % age lower than recommended increase</span>
                             </div>
                          </div>
                               
                          <div class="col-sm-12 pad_right0"> 
                           <div class="sal_incre_rang">
                            <span class="cantxt">Can go</span><input style="margin-left:3px; margin-top:0px;" type="text" name="txt_manager_discretionary_increase" class="form-control range" required="required" value="<?=$rule_dtls["Manager_discretionary_increase"]?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);"/> 
                            <span class="low_high"> % age higher than recommended increase</span>
                           </div>
                          </div>

                        </div>
                      </div>
                    </div>


                    <div class="rule_box clearfix">
                      <?php /*?><div class="col-sm-6 removed_padding">
                        <label for="inputEmail3" class="control-label"> Standard promotion increase %age <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Propose a standard promotion increase here for all promotion case. Depending upon the rule setup promotion
increase can in included or excluded from the overall manager’s budget" data-original-title=""><i class=" fa fa-info" aria-hidden="true"></i></span> </label>
                      </div>
                      <div class="col-sm-6 pad_right0">
                        <input type="text" name="txt_standard_promotion_increase" class="form-control" value="<?php echo $rule_dtls["standard_promotion_increase"]; ?>" readonly="readonly"/>
                      </div><?php */?>
                      <div class="col-sm-6 removed_padding">
                        <label for="ddl_promotion_basis_on" class="control-label">Promotion Based On <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Based on your internal promotion policy, select which parameter is to be used to consider for promotion recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                      </div>
                      <div class="col-sm-6 pad_right0">
                        <select class="form-control" id="ddl_promotion_basis_on" name="ddl_promotion_basis_on">
                          <option value="0">NA</option>
						  <option <?php if($rule_dtls["promotion_basis_on"]==1){
echo 'selected';
} ?> value="1">Designation</option>
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
                                <label class="control-label">Grade/level/Designation editable by managers <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Select “Yes” if you want to allow managers to change the grade/level/designation while recommending for promotion." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
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
                        <label for="inputPassword" class="control-label">Additional Field 1 (Optional) <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
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
                        <label for="inputPassword" class="control-label">Additional Field 2 (Optional) <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select
                              which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                      </div>
                      <div class="col-sm-2 pad_right0 ">
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
                        <label for="inputPassword" class="control-label">Additional Field 3 (Optional) <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="top" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
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
                        <label for="inputPassword" class="control-label">Additional <!-- Recommendation  -->Field 3 (Optional) <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="top" title=" Additional field are flexible fields to get any additional recommendations from the managers while getting salary review recommendation as per the above rules. You can also select which type of input is needed and which approver level can give this recommendation." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                      </div>
                      <div class="col-sm-2 pad_right0">
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
                        <label for="inputPassword" class="control-label">Select Bonus Rule</label>
                      </div>
                      <div class="col-sm-6 pad_right0" style="margin-bottom:8px;">
                        <select id="linked_bonus_rule_id"  name="linked_bonus_rule_id" class="form-control" >
                          <option  value="">No Bonus Rule Selected</option>
                          <?php foreach ($bonusListForSalaryRuleCreation as $row) { ?>
                          <option value="<?=$row->id?>" <?=($rule_dtls["linked_bonus_rule_id"]==$row->id) ? 'selected': ''?> >
                          <?=$row->bonus_rule_name?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                     </div>

                    </div>

                    </div>
                  </div>
                </div>
              </div>
              <div id="dv_partial_page_data_2">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form_head pad_rt_0 clearfix">
                      <div class="col-sm-12">
                        <ul>
                          <li>
                            <div class="form_tittle">
                              <h4>Standard Salary Review Grid</h4>
                            </div>
                          </li>
                          <li>
                            <div class="form_info">
                              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page3[0]?$page3[0]:'Define your proposed performance/merit based salary increases as well as proposed correction increase for this compensation plan.' ?>"><i style="font-size:20px" class="themeclr fa fa-info-circle" aria-hidden="true"></i></button>
                            </div>
                          </li>
						  <li class="color-detail preinc pull-right">
                            <div class="color_info">
                              <span style="margin-right: 5px; width: 70px; height: 17.5px; display: inline-block; padding: 1px 20px; background-color: #FF6600;"></span><span> Total Proposed Salary %age</span>
                            </div>
                          </li>
                          <?php /*?><li class="color-detail preinc <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "pull-right"; }?> ">
                            <div class="color_info"> <span class="c_grn"></span><span> Pre increase population distribution</span> </div>
                            <div class="color_info"> <span class="c_blue"></span><span> Post increase population distribution</span> </div>
                          </li>
                          <li class="color-detail mar0 pull-right" style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> ">
                            <div class="color_info"> <span class="c_yello" id="spn_improvement_pre_avg_crr"></span><span> Average Comparative ratio before increase </span> </div>
                            <div class="color_info"> <span class="c_yello" id="spn_improvement_post_avg_crr"></span><span> Average Comparative ratio after increase </span> </div>
                            <div class="color_info"> <span class="c_yello" id="spn_improvement_avg_crr"></span><span> Total improvement in the average comparative ratio </span> </div>
                          </li><?php */?>
                        </ul>
                      </div>
                    </div>
                    <?php
                    $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);?>
                    <div class="form_sec clearfix forth" >
                     <div class="table-normal-scll"> 
                      <table class="table table-bordered th-top-aln budget-table" style="padding:0px 10px !important;">
                        <thead>
                          <tr>
                            <?php 
            
              $tag = "";
              $mkt_col_styl = "display:none;";
              if($rule_dtls['salary_position_based_on'] != "2")
              {
                $mkt_col_styl = "";
                $tag = "CR";
              }
            
            if($rule_dtls["performnace_based_hike"] == 'yes'){?>
                            <th rowspan="2">Rating (Population</br> Distribution)
                              <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[1] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span><?php */?></th>
                            <th rowspan="2"><!-- Performance Based Increase -->Merit </br>Increase
                              <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[2] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span><?php */?></th>
                            <?php }else{ ?>
                            <th rowspan="2">Base Increase
                              <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[2] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span><?php */?></th>
                            <?php } ?>

                            <th colspan="<?php $colspn_cnt = 2; if($rule_dtls['salary_position_based_on'] == "2"){$colspn_cnt = 1;}echo count($crr_arr)+$colspn_cnt; ?>">Proposed Salary Correction %age <span style="color:#FF6600;">(Total Proposed Salary %age)</span></th>

                            
                            <th rowspan="2">Overall Max Increase
                              <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[4] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span><?php */?></th>
                            <th rowspan="2">Max Increase For</br> Recently Promoted </br> Cases
                              <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[5] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span><?php */?></th>
                          </tr>

                          <tr>
                            <th style="width:18%; <?php echo $mkt_col_styl; ?>">Target Position in pay range  
                              <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[3] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span><?php */?></th>
                            <?php $i=0; 

                          foreach($crr_arr as $row)
                            {  
                                if($i==0)
                                { 
                                    echo "<th style='width:13%;'> &nbsp; < ".$row["max"]." ".$tag."</th>";
                                }                                
                                else
                                {
                                    echo "<th style='width:13%;'>".$row["min"]." To < ".$row["max"]." ".$tag."</th>";
                                }
                                
                                if(($i+1)==count($crr_arr))
                                {
                                    echo "<th style='width:13%;'> &nbsp; > ".$row["max"]." ".$tag."</th>";
                                }                            
                                $i++;
                            }
                    ?>
                          </tr>


                        </thead>
                        <tbody style="padding: 0px 10px !important;">
                          <?php //echo "<pre>";print_r(json_decode($rule_dtls["crr_percent_values"],true));
        //$total_emps_cnt = count(explode(",",$rule_dtls['user_ids']));
                $crr_percent_values_arr = json_decode($rule_dtls["crr_percent_values"],true);
        $max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"],true);
        $recently_promoted_max_salary_arr = json_decode($rule_dtls["if_recently_promoted"],true);
        $j=0; $crr_arr1 = json_decode($rule_dtls["comparative_ratio_calculations"],true);
        $rating_val_arr = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
               //echo "<pre>";print_r($crr_arr1);die; 
          foreach($rating_val_arr as $key => $val)
                { //echo print_r($key);die;
            ?>
                          <tr>
                            <?php $rating_name_arr =explode(CV_CONCATENATE_SYNTAX, $key); 
        
                    //if($rule_dtls["comparative_ratio"] == 'yes')
          if($rule_dtls["performnace_based_hike"] == 'yes')
                    { ?>
                            <input type="hidden" id="hf_rating_val_<?php echo $j; ?>" value="<?php echo $rating_name_arr[0]; ?>" />
                            <td><?php echo $rating_name_arr[1]; ?>
                              <div class="perf_inc_hk"> <?php echo HLP_get_formated_percentage_common(($rating_wise_total_emps[$key]/$total_emps_cnt)*100) ?>%</div></td>
                            <?php }
                    else
                    {
                        //echo "<td>".$rating_name_arr[0]."</td>";
                    }
          ?>
                            <input type="hidden" id="hf_ratings_<?php echo $j; ?>" value="<?php echo $rating_val_arr[$key]; ?>" />
                            <td><input type="text" class="form-control txt_color" value="<?php echo $rating_val_arr[$key]; ?>%" style="text-align:right; width:130px;" />
                            </td>
                            <?php 
          //if($rule_dtls["comparative_ratio"] == 'yes')
          if($rule_dtls["performnace_based_hike"] == 'yes')
                    { 
            $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1[$key]); ?>
                            <input type="hidden" id="hf_market_salary_comparative_ratio_<?php echo $j; ?>" value="<?php echo $crr_arr1[$key]; ?>" />
                            <?php echo (isset($market_salalry_arr[0]) && $market_salalry_arr[0]!='') ? "<td style='".$mkt_col_styl."'>".HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$market_salalry_arr[0].")")."</td>" : "<td style='".$mkt_col_styl."'>$market_salalry_arr[1]</td>";
            
                    }
                    else
                    {
            $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1['all']); ?>
                            <input type="hidden" id="hf_market_salary_comparative_ratio_<?php echo $j; ?>" value="<?php echo $crr_arr1[$key]; ?>" />
                            <?php echo (isset($market_salalry_arr[0]) && $market_salalry_arr[0]!='') ? "<td>".HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$market_salalry_arr[0].")")."</td>" : "<td>$market_salalry_arr[1]</td>";
                    }
                ?>
                            <?php /*?><td><?php $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $val);
              echo $market_salalry_arr[1]; ?></td><?php */?>
                            <?php 
                    $i = 0;
          $rating_val_for_txt = $rating_val_arr[$key];
                    foreach($crr_arr as $row)
                    { 
                ?>
                            <td style="width:13%;"><input type="text" class="form-control" name="txt_range_val<?php echo $i; ?>[]" value="<?php echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]); ?>%" readonly="readonly" style="float:left; width:47%; margin-bottom:3px; text-align:right;">
                              <div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
                                <?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));}elseif($rating_val_for_txt){echo HLP_get_formated_percentage_common($rating_val_for_txt);}else{echo "0.00";} ?>%</div>
                              <div class="calu hide_pre_post_population">
                                <div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
                                <?php //if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
                                <div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
                                <?php //} ?>
                              </div></td>
                            <?php 
                    $i++; 
                    } 
                ?>
                            <!--Note :: Added below <td> to manage more than value of last max range-->
                            <td style="width:13%;"><input type="text" class="form-control" name="txt_range_val<?php echo $i; ?>[]" value="<?php echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]); ?>%" readonly="readonly" style="float:left; width:47%; margin-bottom:3px; text-align:right;">
                              <div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
                                <?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));}elseif($rating_val_for_txt){echo HLP_get_formated_percentage_common($rating_val_for_txt);}else{echo "0.00";} ?>%</div>
                              <div class="calu hide_pre_post_population">
                                <div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
                                <?php //if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
                                <div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
                                <?php //} ?>
                              </div></td>
                            <td style="width:9.5%;"><input type="text" class="form-control" name="txt_max_hike[]" value="<?php echo HLP_get_formated_percentage_common($max_hike_arr[$j]); ?>%" readonly="readonly" style="text-align:right; width: 130px;"></td>
                            <td><input type="text" class="form-control" name="txt_recently_promoted_max_salary_increase[]" value="<?php echo HLP_get_formated_percentage_common($recently_promoted_max_salary_arr[$j]); ?>%" readonly="readonly" style="text-align:right;"></td>
                          </tr>
                          <?php 
                $j++;} 
            ?>
                        </tbody>
                      </table>
                    </div>
            
            

			<?php if($rule_dtls["hike_multiplier_basis_on"]){?>
              <div style="margin-top:10px;">
                <div class="col-sm-6 removed_padding">
                  <label class="control-label">Apply multiplier to differentiate your standard salary review grid
 <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="This options allows you to differentiate your salary increase grid by country, grade/band or level. By selecting the option between these three choices, system will ask to put multipliers for each country or grade or level and apply those multiplies on the standard grid and use it for your increment and budget simulation automatically. Eg if you choose grade and for grade -1 enter 80, in the relevant field below, it will use 80% of thr standard grid as recommended increase for employee in grade-1" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                </div>
                <div class="col-sm-6 pad_r0">
                  <select class="form-control" id="ddl_hike_multiplier_basis_on" name="ddl_hike_multiplier_basis_on">
                  <option value="">Select</option>
				  <option <?php if($rule_dtls["hike_multiplier_basis_on"]=="1"){ echo 'selected'; } ?> value="1">Country</option>
                  <option <?php if($rule_dtls["hike_multiplier_basis_on"]=="2"){ echo 'selected'; } ?> value="2">Grade</option>
                  <option <?php if($rule_dtls["hike_multiplier_basis_on"]=="3"){ echo 'selected'; } ?> value="3">Level</option>
                  </select>
                </div>
                <div id="dv_multipliers_list"></div>
              </div>
			<?php } ?> 
            </div>
          </div>
          
                  </div>
                </div>


 

<?php if($rule_dtls["hike_multiplier_basis_on"]){
		$this->load->view('salary/increment_grid_after_multiplier');
	  } ?>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form_head clearfix">
                      <div class="col-sm-12">
                        <ul>
                          <li>
                            <div class="form_tittle">
                              <h4>Define Budget Allocation</h4>
                            </div>
                          </li>
                          <li>
                            <div class="form_info">
                              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="Define rules related to budget management in this section and see the outcome table below by approver-1.<?php //echo $page4[0] ?>"><i style="font-size: 20px;" class=" fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="form_sec clearfix">
                      <div class="col-sm-12">
                        <div>
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Budget accumulation as per approver’s hierarchy <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, it would continue to accumulate the budgets from Approver-1 to Approver-2 to Approver-3 and finally to Approver-4. In case of “No”, the budget saved will retain with the respective approvers only." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_r0">
                          <select class="form-control" name="ddl_budget_accumulation" required>
                            <option value="1" <?php if($rule_dtls['budget_accumulation'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                            <option value="2" <?php if($rule_dtls['budget_accumulation'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
                          </select>
                        </div>
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Include promotion budget in the overall allocated budget <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, all budget limits included in the manager’s budget allocation will also include any salary increase given towards promotions recommendations. Otherwise, it will be excluded from the overall budget allocated to managers." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6 pad_r0">
                          <select class="form-control" name="ddl_include_promotion_budget" required>
                            <option value="1" <?php if($rule_dtls['include_promotion_budget'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                            <option value="2" <?php if($rule_dtls['include_promotion_budget'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
                          </select>
                        </div>
            
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Define budget management rule<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, managers will be able cross all limits at individual limit but will be restricted to the allocated overall budget while submission. Otherwise they will be restricted to recommend increase within the defined increase limits for individuals as well." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span>
                         </label>
                        </div>
                        <div class="col-sm-6 pad_r0">
                         <select class="form-control" name="ddl_manager_can_exceed_budget" required>
                          <option value="1" <?php if($rule_dtls['manager_can_exceed_budget'] == 1){ echo 'selected="selected"'; } ?> >Don't apply individual limits but limits on overall budget</option>
                          <option value="2" <?php if($rule_dtls['manager_can_exceed_budget'] == 2){ echo 'selected="selected"'; } ?> >Apply both limits</option>
                         <option value="3" <?php if($rule_dtls['manager_can_exceed_budget'] == 3){ echo 'selected="selected"'; } ?> >Apply individual limits but no limits on overall budget</option>  
                         <option value="4" <?php if($rule_dtls['manager_can_exceed_budget'] == 4){ echo 'selected="selected"'; } ?> >Don't apply any limits</option>     
                        </select>
                        </div>

												



						<div class="col-sm-6 removed_padding">
						  <label class="control-label">Calculate budget on employees prorated salary
              <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, the calculation of budget will happen on the pro-rated salaries for employee who have joined during the performance period. Otherwise salaries will be calculated on the full salaries of selected employees in this plan." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
						</div>
						<div class="col-sm-6 pad_r0">
						  <select class="form-control" id="ddl_show_prorated_current_sal" name="ddl_show_prorated_current_sal" >
							<option value="1" <?php if($rule_dtls['show_prorated_current_sal'] == 1){ echo 'selected="selected"'; } ?> >Yes</option>
							<option value="2" <?php if($rule_dtls['show_prorated_current_sal'] == 2){ echo 'selected="selected"'; } ?> >No</option>
						  </select>
						</div>

              <div class="col-sm-6 removed_padding">
                <label class="control-label">Check and define overall budget allocation <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="This section allows you to build your budgets according to your methodology. “No Limit” means, even while managers will see individual salary increase recommendation and overall recommended budget, they will be able to cross it by any %age or amount.“Automated locked” means, all budgets will be locked as per the recommended increases and if managers would like to increase somebody’s salary, they will have to decrease another increase for another employees first to create a pool.“Automated but x% can exceed” allows you to allocate positive of negative budget allocation for specific managers as per your choice." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
              </div>
                <div class="col-sm-3">
                  <select class="form-control" name="ddl_overall_budget" disabled="disabled">
                    <option value="">Select</option>
                    <option value="No limit" <?php if($rule_dtls["overall_budget"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                    <option value="Automated locked" <?php if($rule_dtls["overall_budget"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                    <option value="Automated but x% can exceed" <?php if($rule_dtls["overall_budget"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                  </select>
                </div>
                <div class="col-sm-3 p_l0 pad_r0">
                  <select class="form-control" required id="ddl_to_currency">
                    <?php foreach($currencys as $currency){?>
                    <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]; ?></option>
                    <?php } ?>
                  </select>
                </div>
               </div>

              </div>



                        <!--PIY -->

                  <div class="form_sec clearfix" style="">

                    <div class="col-sm-12">
                    <div class="attr_wise_reports clearfix">
                      <h4>Budget allocation by various segments</h4>
                     <ul>
                      <li>
                      <div btnvalue="approver_1" class="btn btn-twitter dd-btn btn_attributeswise" id="btn_attributeswise_approver_1" processed="processed">Approver-1</div>
                      </li>    
          
                     <?php foreach($ddl_attributeswise_budget as $attr){?>
                         <li>
                          <div btnvalue="<?php echo $attr["ba_name"]; ?>" class="btn btn-twitter dd-btn btn_attributeswise"  id="btn_attributeswise_<?php echo $attr["ba_name"]; ?>" /><?php echo $attr["display_name"]; ?></div> 
                        </li>
                     <?php } ?> 

                     <li>
                      <div btnvalue="emp_performance_rating" class="btn btn-twitter dd-btn btn_attributeswise" id="btn_attributeswise_emp_performance_rating">Performance Rating </div>
                     </li>  
                     <li>
                      <div btnvalue="increment_distribution" class="btn btn-twitter dd-btn btn_attributeswise" id="btn_attributeswise_increment_distribution">Increment Distribution</div>
                     </li>  
                      
                    </ul>
                  </div>
                </div>
                
                


                  <!--PIY END -->

                      <div class="col-sm-12">
                        <div class="form-group panel_attributeswise" id="panel_attributeswise_approver_1" style="display:none;"> <div class="content">
                          
                          <?php $managers_bdgt_dtls_for_tbl_head = json_decode($rule_dtls['managers_bdgt_dtls_for_tbl_head'], true);
                $managers_bdgt_dtls_arr = json_decode($rule_dtls['managers_bdgt_dtls_for_tbl'], true);             ?>
                          <div class="table-responsive">
                            <table class="tablecustm table table-bordered">
                              <thead>
                                <tr>
                                  <th style="vertical-align: middle;">Approver-1</th>
                  <?php if(isset($managers_bdgt_dtls_for_tbl_head["f_col"])){ ?>
                    <th style="vertical-align: middle;">Function</th>
                <!--    <th style="vertical-align: middle;">BU Level-3</th> -->
                  <?php } ?>
                                  <th style="vertical-align: middle;">Number of<br>
                                    Employees</th>
                                  <th style="vertical-align: middle;"><?php if($rule_dtls['show_prorated_current_sal'] == 1){echo "Prorated"; }?> Current Salary (<?php echo $rule_dtls['rule_currency_name']; ?>)</th>
                                  <th style="vertical-align: middle;">Budget %age as per
                                    the rule</th>
                                  <th style="vertical-align: middle;">Budget amount as per
                                    the rule (<?php echo $rule_dtls['rule_currency_name']; ?>)</th>
                                  
                                  <?php if($rule_dtls['overall_budget'] == "Automated but x% can exceed"){ ?>
                                  <th style="vertical-align: middle;">Additional budget %age</th>
                                    
                                  <th style="vertical-align: middle;">Additional Budget amount (<?php echo $rule_dtls['rule_currency_name']; ?>)</th>
                                  
                                  <th style="vertical-align: middle;">Final Budget %age</th>

                                  <th style="vertical-align: middle;">Final Budget Amount
                                    (<?php echo $rule_dtls['rule_currency_name']; ?>)</th>
                                  <?php } ?>
                                  

                                  <th style="vertical-align: middle; display:none; <?php if($rule_dtls['salary_position_based_on'] == "2"){echo  "display:none;";} ?>">Budget to bring all to their target<br/>
                                    positioning (only for reference)<br />
                                    (<?php echo $rule_dtls['rule_currency_name']; ?>)</th>
                                </tr>
                                <tr class="tablealign">
                                  <th style="text-align: right;">Total</th>
                  <?php if(isset($managers_bdgt_dtls_for_tbl_head["f_col"])){ ?>
                    <th></th>
              <!--      <th>&nbsp;</th> -->
                  <?php } ?>
                                  <th><?php echo $managers_bdgt_dtls_for_tbl_head["total_employees"]; ?></th>
                                  <th style="text-align: right !important;"><?php echo HLP_get_formated_amount_common($managers_bdgt_dtls_for_tbl_head["total_emps_total_salary"]); ?></th>
                                  <th style="vertical-align: middle;"><?php echo 
                                    HLP_get_formated_percentage_common(($managers_bdgt_dtls_for_tbl_head["total_budget_as_per_plan"]) /                                   $managers_bdgt_dtls_for_tbl_head[ "total_emps_total_salary" ] * 100)                                
                                    ?> %</th>
                                  <th style="text-align: right !important;"><?php echo HLP_get_formated_amount_common($managers_bdgt_dtls_for_tbl_head["total_budget_as_per_plan"]); ?></th>
                                  <?php if($rule_dtls['overall_budget'] == "Automated but x% can exceed"){?>

                                  <!-- piy@18Dec19 -->
                                   <th style="text-align: right !important;"><?php echo 
                                    HLP_get_formated_percentage_common(($managers_bdgt_dtls_for_tbl_head["total_revised_budget"]-$managers_bdgt_dtls_for_tbl_head["total_budget_as_per_plan"]) /                                   $managers_bdgt_dtls_for_tbl_head[ "total_emps_total_salary" ] * 100)                                
                                    ?> %</th>
                                 
                                  <th style="text-align: right !important;"><?php echo HLP_get_formated_amount_common($managers_bdgt_dtls_for_tbl_head["total_revised_budget"]-$managers_bdgt_dtls_for_tbl_head["total_budget_as_per_plan"]); ?></th>
                                  <th style="text-align: right !important;"><?php echo HLP_get_formated_percentage_common($managers_bdgt_dtls_for_tbl_head["total_increased_amt_per"]); ?> %</th>

                                 <th style="text-align: right !important;"><?php echo HLP_get_formated_amount_common($managers_bdgt_dtls_for_tbl_head["total_revised_budget"]); ?></th>
                                  <?php } ?>
                                  
                                  <th style="display:none; <?php if($rule_dtls['salary_position_based_on'] == "2"){ echo "display:none;"; } ?> text-align: right !important;"><?php echo HLP_get_formated_amount_common($managers_bdgt_dtls_for_tbl_head["total_budget_to_cr1"]); ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach($managers_bdgt_dtls_arr as $row){?>
                                <tr>
                                  <td><?php
                    if($row['manager_name'])
                    {
                      echo $row['manager_name'];
                    }
                    else
                    {
                      echo $row['manager_email'];
                    }  ?>
                                  </td>
                  <?php if(isset($managers_bdgt_dtls_for_tbl_head["f_col"])){ ?>
                    <td><?php echo $row['f_name'] ?></td>
               <!--     <td><?php echo $row['bl3_name'] ?></td>-->
                  <?php } ?>
                                  <td class="text-center"><?php echo $row['total_employees']; ?></td>
                                  <td class="txtalignright"><?php echo HLP_get_formated_amount_common($row["emps_total_salary"]); ?></td>
                                  
                                  <td class="text-center com_bg_colo_sal fnt_bold" style="vertical-align: middle;"><?php echo HLP_get_formated_percentage_common($row["budget_as_per_plan"]/$row["emps_total_salary"]*100); ?> %</td>
                                  
                                  <td class="txtalignright com_bg_colo_sal fnt_bold"><?php echo HLP_get_formated_amount_common($row["budget_as_per_plan"]); ?></td>
                                  
                                  <?php if($rule_dtls['overall_budget'] == "Automated but x% can exceed"){ ?>
                                  <td class="txtalignright "><?php echo HLP_get_formated_percentage_common($row["additional_budget_per"]); ?> %</td>
                                  
                                  <td class="txtalignright"><?php echo HLP_get_formated_amount_common($row["revised_budget"]-$row["budget_as_per_plan"]); ?></td>

                                   <td class="text-center com_bg_colo_sal fnt_bold"><?php echo HLP_get_formated_percentage_common($row["increased_amt_per"]); ?> %</td>
          <td  class="txtalignright com_bg_colo_sal fnt_bold"><?php echo HLP_get_formated_amount_common($row["revised_budget"]); ?></td>
                                  <?php } ?>
                                 
                                  <td class="txtalignright" style="display:none; <?php if($rule_dtls['salary_position_based_on'] == "2"){echo  "display:none;";} ?>"><?php echo HLP_get_formated_amount_common($row["total_budget_to_cr1"]); ?></td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                         <div btnvalue="approver_1" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" id="btn_attributeswise_approver_1_print" style="margin-top: 10px" >Download Data</div>
                         </div>

                      </div>

                      <!--piy-->
                      <div class="col-sm-12">
                          <!--<div id="panel_attributeswise_approver_niu" class="form-group panel_attributeswise" style="display: none;"><div class="content"></div></div>-->
                        <?php foreach($ddl_attributeswise_budget as $attr){?>
                        <div  id="panel_attributeswise_<?php echo $attr["ba_name"]; ?>" class="form-group panel_attributeswise"  style="display:none;" >
                          <div class="content"></div>
                          <div btnvalue="<?php echo $attr["ba_name"]; ?>" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_<?php echo $attr["ba_name"]; ?>_print" />Download Data</div>                         
                        </div>
                        <?php } ?> 

                        <div id="panel_attributeswise_emp_performance_rating" class="form-group panel_attributeswise" style="display:none;">
                          <div class="content"></div>
                          <div btnvalue="emp_performance_rating" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_emp_performance_rating_print" processed="processed">Download Data</div>
                        </div>

                        <div id="panel_attributeswise_increment_distribution" class="form-group panel_attributeswise" style="display:none;">
                          <div class="content"></div>
                          <div btnvalue="increment_distribution" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_increment_distribution_print" processed="processed">Download Data</div>
                        </div>   
                    </div>
                      <!--piy end -->
                    </div>
                  </div>
                </div>
              </div>

               <div class="row">
                <div class="col-sm-12">
                 <div class="form_head clearfix">
                  <div class="col-sm-12">
                    <ul>
                      <li>
                        <div class="form_tittle">
                          <h4>Rule specific Analytics</h4>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="form_sec clearfix">
                 <div class="col-sm-12">
               <div class="sal_reports_onclk clearfix"> 
                <a class="btn btn-primary viewBtn" target="_blank" href="<?php echo site_url("report/salary_analysis/".$rule_dtls['performance_cycle_id']."/".$rule_dtls['id']); ?>">Salary Increase Range Report</a>
                <a class="btn btn-primary viewBtn" target="_blank" href="<?php echo site_url("report/compposition-rule-wise/".$rule_dtls['performance_cycle_id']."/".$rule_dtls['id']); ?>">Comp Positioning Report</a>
                <a class="btn btn-primary viewBtn" target="_blank" href="<?php echo site_url("report/salary-increase-budget/".$rule_dtls['performance_cycle_id']."/".$rule_dtls['id']); ?>">Salary increase budget allocation vs utilisation Report</a>
                <a class="btn btn-primary viewBtn" target="_blank" href="<?php echo site_url("report/salary-increase/".$rule_dtls['performance_cycle_id']."/".$rule_dtls['id']); ?>">Oveall Salary growth Report</a>
               </div>  
              </div>
             </div>
            </div>
           </div>


              <?php if(($is_enable_approve_btn) and $rule_dtls["status"]==4){ ?>
              <form action="<?php echo site_url("reject-salary-rule-approval-request/".$rule_dtls["id"]); ?>" method="post" class="form-inline">
                <?php echo HLP_get_crsf_field();?>
                <div class="row" style="display: none;" id="dv_remark">
                  <div class="col-sm-12">
                    <div class="form_sec clearfix">
                      <div class="col-sm-12">
                        <div class="form-input">
                          <input type="hidden" name="hf_req_for" id="hf_req_for" value="" />
                          <textarea class="form-control" rows="6" name="txt_remark" placeholder="Enter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px;height: 98px;width: 100%;"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="submit-btn" style="display: none;" id="dv_remrk_submit_btn">
                      <input type="submit" class="btn mar_l_5 btn-twitter m-b-sm add-btn" value="Submit Reason" id="btnReject" />
                    </div>
                    <div class="submit-btn" id="dv_reject_btn">
                      <input type="button" onclick="show_remark_dv();" class="btn btn-twitter mar_l_5 m-b-sm add-btn" value="Reject" id="btnReject" />
                    </div>
                    <div class="submit-btn" id="dv_delete_btn">
                      <input type="button" onclick="show_remark_dv_on_delete();" class="btn mar_l_5 btn-twitter m-b-sm add-btn" value="Delete" id="btn_delete" />
                    </div>
                    <div class="submit-btn"> <a class="anchor_cstm_popup_cls_sal_rule_appv" href="<?php echo site_url("update-salary-rule-approvel/".$rule_dtls["id"]); ?>"  onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sal_rule_appv', '<?php echo CV_CONFIRMATION_APRROVED_MESSAGE;?>')">
                      <input type="button" class="btn mar_l_5 btn-twitter m-b-sm add-btn" value="Approve" id="btnSave" />
                      </a> </div>
                  </div>
                </div>
              </form>
              <?php } ?>

           
              <?php if($rule_dtls["status"]==3){?> 
                <div class="row">
                 <div class="col-sm-12">
                  <div class="form_sec clearfix" style="padding-bottom: 0px;">
                   <div class="col-sm-6" style="padding-right: 0px;">
                      <label class="control-label" style="text-align: right !important;padding-right: 9px;">Select a manager to send for approval</label>
                    </div>
                    <div class="col-sm-6">
                     <select class="form-control" required name="ddl_users_for_approval" onchange="changeManger(this.value)">
                      <?php foreach($users_for_approval_req_list as $usrs_row){?>
                      <option value="<?php echo $usrs_row["id"]; ?>" <?=($usrs_row["id"]==$this->session->userdata('userid_ses')) ? 'selected' : '' ?> ><?php echo $usrs_row["name"]; ?></option>
                      <?php } ?>
                      </select>
                     </div>
                </div>
              <div class="row">
                <div class="col-lg-12 text-right"> <a class="anchor_cstm_popup_cls_sal_hrman" href="<?php echo site_url("send-rule-for-approval/".$rule_dtls["id"]."/1/".$this->session->userdata('userid_ses')); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sal_hrman','<?php echo CV_CONFIRMATION_MESSAGE;?>')">
                  <input type="button" class="btn btn-twitter mar_l_5  add-btn" value="Send for Approval – HR Driven Process" title="Send For Release" id="btnSave" />
                  </a> <a id="sendManagerId" class="anchor_cstm_popup_cls_sal_man" href="<?php echo site_url("send-rule-for-approval/".$rule_dtls["id"]."/0/".$this->session->userdata('userid_ses')); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sal_man','<?php echo CV_CONFIRMATION_MESSAGE;?>')">
                  <input type="button" class="btn btn-twitter mar_l_5 add-btn" value="Send for Approval - Manager Self Service Process" title="Send For Approval" id="btnSave" />
                  </a> <a href="<?php echo site_url("create-salary-rules/".$rule_dtls["id"]); ?>">
                  <input type="button" class="btn btn-twitter mar_l_5 dd-btn" value="Edit Rule" id="btnSave" />
                  </a> </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

$('.multipleSelect').fastselect();

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

function get_multipliers_list()
{
	var multiplier_val = $("#ddl_hike_multiplier_basis_on").val();
	$("#dv_multipliers_list").html("");
	if(multiplier_val)
	{
		$.get("<?php echo site_url("rules/get_multipliers_list/".$rule_dtls['id']);?>/"+multiplier_val, function(data)
		{
			$("#dv_multipliers_list").html(data);
		});
  	}
}
get_multipliers_list();

function show_remark_dv()
{
 custom_confirm_popup_callback('<?php echo CV_CONFIRMATION_REJECT_MESSAGE;?>',function(result)
  {
 
  if(result)
  {
  $("#hf_req_for").val('1');
  $("#dv_reject_btn").hide();
  $("#dv_delete_btn").show();
  $("#dv_remark").show();
  $("#dv_remrk_submit_btn").show();
  }
  }
);
  
}

function show_remark_dv_on_delete()
{
  custom_confirm_popup_callback('<?php echo CV_CONFIRMATION_DELETE_MESSAGE;?>',function(result)
  {
 
  if(result)
  {

  $("#hf_req_for").val('2');
  $("#dv_reject_btn").show();
  $("#dv_delete_btn").hide();
  $("#dv_remark").show();
  $("#dv_remrk_submit_btn").show();
  }
  }
  );
 
}  
  



/*function show_remark_dv()
{
  var conf = confirm("<?php //echo CV_CONFIRMATION_REJECT_MESSAGE;?>");
  if(!conf)
  {
    return false;
  }
  $("#hf_req_for").val('1');
  $("#dv_reject_btn").hide();
  $("#dv_delete_btn").show();
  $("#dv_remark").show();
  $("#dv_remrk_submit_btn").show();
}
function show_remark_dv_on_delete()
{
  var conf = confirm("<?php //echo CV_CONFIRMATION_DELETE_MESSAGE;?>");
  if(!conf)
  {
    return false;
  }
  $("#hf_req_for").val('2');
  $("#dv_reject_btn").show();
  $("#dv_delete_btn").hide();
  $("#dv_remark").show();
  $("#dv_remrk_submit_btn").show();
}  
  */
//show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', $("#ddl_to_currency").val()); 
function show_hide_budget_dv_NIU(val, to_currency)
{
   <?php /*?> $("#txt_budget_amt").prop('required',false);
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
    
    //setTimeout(function(){ $("#loading").css('display','block'); }, 1000);
        $.post("<?php echo site_url("rules/get_managers_for_manual_bdgt/1");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
        {
            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();

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
        
        var r=1;
        if(val=='Manual')
        {
          //$("input[name='txt_manual_budget_amt[]']").each( function (key, v)
          
          $("input[name='hf_managers[]']").each( function (key, v)
          {
            //$(this).val(Math.round(items[i]).toLocaleString());
            //$(this).prop('readonly',true);
            $("#dv_manual_budget_"+ r).html(Math.round(items[i]).toLocaleString());
            calculat_percent_increased_val(1, items[i], (i+1));
            i++;   r++; 
          });
          calculat_total_revised_bgt();
        }
        if(val=='Automated but x% can exceed')
        {
          //$("input[name='txt_manual_budget_per[]']").each( function (key, v)
          $("input[name='hf_managers[]']").each( function (key, v)
          {
            //$(this).val(items[i]);
            //$(this).prop('readonly',true);
            $("#dv_x_per_budget_"+ r).html(items[i]);
            calculat_percent_increased_val(2, items[i], (i+1));
            i++;    r++;
          });
          calculat_total_revised_bgt();
          
        }
            }settabletxtcolor();

      $("#loading").css('display','none');
        });
    //}
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

  var per = (val/$("#hf_total_current_sal").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');

  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);

  per = (amtval/$("#hf_total_current_sal").val()*100);
  $("#th_total_budget_manual").html(get_formated_percentage_common(per) + ' %');

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}


for(var i=0; i<<?php echo $j; ?>; i++)
{
  get_emp_perc_crr_range_wise(i); 
}
<?php if($j===0){ ?>
  get_emp_perc_crr_range_wise(0); 
<?php } ?>

var total_pre_population = 0;
var total_post_population = 0;
var total_emps_in_rule = <?php echo $total_emps_cnt; ?>;
function get_emp_perc_crr_range_wise(obj_id_no)
{return;//Stopped Calculation of Pre & Post Population Distributions
  var loop_cnt = <?php echo $i; ?>;
  var rule_id = <?php echo $rule_dtls['id']; ?>;
  var rating_val = $("#hf_rating_val_"+obj_id_no).val();  
  var increment_percet = ($("#hf_ratings_"+obj_id_no).val())*1;
  var mkt_sal_val = $("#hf_market_salary_comparative_ratio_"+obj_id_no).val();
  
  /*if(increment_percet <=0)
  {
    for(var i=0; i<=loop_cnt; i++)
    {
      $("#dv_emp_perc_crr_wise_"+obj_id_no+"_"+i).html("0%"); 
    }
    return;
  }*/
  
  $("#rpt_loading").show();
  
  
  $.post("<?php echo site_url("rules/get_emp_perc_crr_range_wise");?>",{rule_id:rule_id, rating_val:rating_val,increment_percet:increment_percet, mkt_sal_val:mkt_sal_val}, function(data)
    {
    if(data)
    {     
      var emp_perc_crr_range_wise = JSON.parse(data);
      total_pre_population += emp_perc_crr_range_wise[2];
      total_post_population += emp_perc_crr_range_wise[3];
      for(var i=0; i<=loop_cnt; i++)
      {
        $("#dv_emp_perc_crr_wise_"+obj_id_no+"_"+i).html(emp_perc_crr_range_wise[0][i]);
        <?php //if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
          $("#dv_emp_perc_updated_crr_wise_"+obj_id_no+"_"+i).html(emp_perc_crr_range_wise[1][i]);
        <?php //} ?>
      }     
    }
    
    })
  .always(function() 
  {
    var total_grid_rows = <?php echo $j-1; ?>;
    <?php if($j===0){ ?> total_grid_rows = 0; <?php } ?>
    if(total_grid_rows == obj_id_no)
    {
      setTimeout(function(){
        
        var spn_improvement_avg_crr = (total_post_population - total_pre_population) / total_emps_in_rule;
        $("#spn_improvement_pre_avg_crr").html(get_formated_percentage_common(total_pre_population/total_emps_in_rule) +"%");
        $("#spn_improvement_post_avg_crr").html(get_formated_percentage_common(total_post_population/total_emps_in_rule) +"%");
        $("#spn_improvement_avg_crr").html(get_formated_percentage_common(spn_improvement_avg_crr) +"%");     
        $("#rpt_loading").hide(); 
      
      }, 3000);
    }
  });
  
}
//alert("<?php echo $rule_dtls['default_market_benchmark']; ?>")
$.post("<?php echo site_url("rules/get_comparative_ratio_element_for_no");?>", function(data)
{
  if(data)
  {
    $("#ddl_comparative_ratio1").html(data);
    <?php if($rule_dtls['default_market_benchmark']){ ?>
      //alert('iii');
      $("#ddl_comparative_ratio1").val('<?php echo $rule_dtls['default_market_benchmark']; ?>');  
    <?php } ?>      
  }
});

function show_filters()
{
  $('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
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
toggle_pro_rated_period(); 
</script>
<script type="text/javascript">
function closePrint () {
  document.body.removeChild(this.__container__);
}

function setPrint () {
  var ths = this.contentWindow;
    this.contentWindow.__container__ = this;
    this.contentWindow.onbeforeunload = closePrint;
    this.contentWindow.onafterprint = closePrint;
  setTimeout(function(){
    ths.focus(); // Required for IE
    ths.print();
    $("#loading").hide();
    }, 3000);
}

function printPage_new (sURL) {
  //console.log($('#area').html());
  var divName = 'area';
   var printContents = document.getElementById(divName).innerHTML;
   console.log(printContents);
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
function printPage (sURL) {
var val1 = $("#spn_improvement_pre_avg_crr").html();
var val2 = $("#spn_improvement_post_avg_crr").html();
var val3 = $("#spn_improvement_avg_crr").html();
sURL= sURL+'?val1='+val1+'&val2='+val2+'&val3='+val3;
// console.log(sURL);
  $("#loading").show();
  var oHiddFrame = document.createElement("iframe");
  oHiddFrame.onload = setPrint;
  oHiddFrame.style.visibility = "hidden";
  oHiddFrame.style.position = "fixed";
  oHiddFrame.style.right = "0";
  oHiddFrame.style.bottom = "0";
  oHiddFrame.src = sURL;
  document.body.appendChild(oHiddFrame);
}

function changeManger(managerId) {
  
  var url='<?php echo site_url("send-rule-for-approval/".$rule_dtls["id"]."/0/"); ?>'+managerId;
  // alert(url);
  // return false;
  $("#sendManagerId").attr('href',url);
}


//Piy19Dec19
settabletxtcolor();
$('.btn_attributeswise').click(function() {
  var for_attributes = $(this).attr('btnvalue');
  if( $(this).attr('processed')=='processed')
  {
    $(".panel_attributeswise").hide();
    $('#panel_attributeswise_'+for_attributes).show();
    $('html, body').animate({
      scrollTop: $("#btn_attributeswise_"+for_attributes).offset().top
      }, 1000); 
  }
  else
  {
  var to_currency=  $("#ddl_to_currency").val();
  var budget_type='<?php echo $rule_dtls["overall_budget"]; ?>';
  show_attributeswise_budget_dv(budget_type,for_attributes,to_currency );
  }
});

$('.btn_attributeswise_print').click(function() {
  var for_attributes = $(this).attr('btnvalue'); 
  exportTableToCSV(for_attributes + ".csv","#panel_attributeswise_" + for_attributes );  

});

function show_attributeswise_budget_dv(budget_type,for_attributes, to_currency)
{

    var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();

    var rid= '<?php echo $rule_dtls['id']; ?>';
    if(for_attributes!='increment_distribution'){
      var url='<?php echo site_url("rules/get_attributeswise_bdgt");?>';
    }
    else
    {
      var url='<?php echo site_url("rules/get_increment_distribution_bdgt");?>';
    }
 
    if(for_attributes != '')
    {

        $.ajax(url, {
           type: 'POST',  
           data: {'budget_type':budget_type,
                  'for_attributes': for_attributes, 
                  'to_currency': to_currency, 
                  'rid':rid,
                  '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val
                  }, 
            beforeSend: function(jqXHR, settings){
                  $("#loading").css('display','block');
                  $(".panel_attributeswise").hide();                 
            },
            success: function (data, status, xhr) {
            //    console.log( data);    
                if(data)
                {
                    $("#panel_attributeswise_"+for_attributes+ " .content").html(data);
                    $("#panel_attributeswise_"+for_attributes).show();
                    $("#btn_attributeswise_"+for_attributes).attr('processed','processed');
                    $('html, body').animate({
                    scrollTop: $("#btn_attributeswise_"+for_attributes).offset().top
                    }, 1000);           
                }
                        
            },

            error: function (jqXhr, textStatus, errorMessage) {
                console.log('error');
            },complete:function(){ 
                set_csrf_field();
                $("#loading").css('display','none');
                settabletxtcolor();
            }
        });

    }
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename,selector) {
    var csv = [];
    var rows = document.querySelectorAll(selector + " table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
        //  row.push('"'+cols[j].style.display+'"');
          if(cols[j].style.display != 'none'){
           row.push('"'+cols[j].innerText+'"');
          }
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
//Piy End
//

</script>
<style>
    #txt_manual_budget_amt{
                border: none !important;
                width: 118px;
                margin-left: 30px;
                margin-top: -25px;
                padding: 0px !important;
    }
    .myspan{
        font-size: inherit !important;
        color:#4E5E6A !important;
    }

    .form_head ul li{vertical-align: top;}


.fstResults{ position:relative !important;}

.form_head ul{ padding:0px; margin-bottom:0px;}

.form_head ul li{ display:inline-block;}


 .form_head .form_tittle {
  display: block;
  width: 100%;
}
.form_head .form_tittle h4 {
  font-weight: bold;
  color: #000;
  text-transform: uppercase;
  margin: 0;
  padding: 12px 0px;
  margin-left: 5px;
}
.form_head .form_info {
  display: block;
  width: 100%;
  text-align: center;
}
.form_head .form_info i {
  color: #8b8b8b;
  font-size: 24px;
  padding: 7px;
  margin-top:4px;
} 
.tooltipcls{
    margin-left: 10px !important;
}
.form_head .form_info .btn-default {
  border: 0px;
  padding: 0px;
  background-color: transparent!important;
}
 .form_head .form_info .tooltip {
  border-radius: 6px !important;
}
.salary_rt_ftr .form_sec {
  background-color: #f2f2f2;
  /*margin-bottom: 30px;*/
  display: block;
  width: 100%;
  padding:20px;
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;
}

.panel-heading.pading{padding: 2px 32px 2px 0px !important;}  

.pad_r0{padding-right: 0px !important;}
.form-horizontal .control-label{font-size: 13px !important;}
</style>
<!-- **************** Filter form css End ***************** -->
<style>
.form_head ul{ padding:0px; margin-bottom:0px;}
.form_head ul li{ display:inline-block;}

.rule-form .control-label {
  font-size: 12px;
  line-height: 30px;
}
.rule-form .form-control {
  height: 30px;
  margin-top: 0px;
  font-size: 13px;
  background-color: #FFF;
  margin-bottom:10px;
 /* padding: 6px 3px !important;*/
}

.budget-table .form-control {padding: 6px 3px !important;}


.rule-form .form_head .form_tittle {
  display: block;
  width: 100%;
}
.rule-form .form_head .form_tittle h4 {
  font-weight: bold;
  color: #000;
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
  color: #8b8b8b;
  font-size: 24px;
  padding: 7px;
  margin-top:1px;
}
.rule-form .form_sec {
  background-color: #f2f2f2;
  margin-bottom: 10px;
  display: block;
  width: 100%;
  padding: 5px 0px 9px 0px;
  border-bottom-left-radius: 0px;/*6px;*/
  border-bottom-right-radius: 0px;/*6px;*/
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

.crr_per{display: inline-block; vertical-align: top;
    /* float: right; */
    font-weight: bold;
    font-size: 10px;
    padding: 1px;
    text-align: center;
    }
.perf_inc_hk{width:100%; font-size:13px; padding:2px 0px; text-align:left; font-weight:bold;}

.rule-form .form-control.spl_box{padding: 4px !important;}    
.crr_per.first{width: 47%; font-size: 13px; margin-top: 6px; color: #ff6600 ! important;}

.calu{display:inline-block; width:100%;}
.calu .crr_per.secnd{width: 47%; font-size: 13px; padding: 2px 6px 2px 0px; text-align: right;}
.calu .crr_per.third{width: 47%; font-size: 13px; padding: 2px 6px 2px 0px; text-align: right;}

.green{background-color: #46b603; color: #fff; font-weight: normal;} 
.blue{background-color: #0084ff; color: #fff; font-weight: normal;}
.voilet{background-color: #6a01a6; color: #fff; font-weight: normal;}

.hide_pre_post_population{display:none !important;}
</style>
