<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
.plft0{padding-left: 0px;}
.prit0{padding-right: 0px;}

.fstMultipleMode {
	display: block;
}



.my-form {
background:#<?php echo $this->session->userdata("company_light_color_ses");
?>!important;
}
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
.fstResults {
	position:relative !important;
}
.form_head ul {
	padding:0px;
	margin-bottom:0px;
}
.form_head ul li {
	display:inline-block;
}
.control-label {
	line-height:42px;
	font-size: 12px;
 <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>  background-color:#<?php echo $this->session->userdata("company_light_color_ses");
?> !important;
	color: #000;
	margin-bottom:10px;
}



.form_head {
	background-color: #f2f2f2;
 <?php /*?>border-top: 8px solid #93c301;<?php */?>  border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
?>;
}
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
	/*color: #8b8b8b;*/
	font-size: 24px;
	padding: 7px;
	margin-top:-4px;
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
	margin-bottom: 10px;
	display: block;
	width: 100%;
	padding:20px;
	border-bottom-left-radius: 6px;
	border-bottom-right-radius: 6px;
}
.head h4 {
	margin:0px;
}
.padd {
	padding:10px 20px 0px 20px !important;
}
/***added to center align the form head text****/
.form_head.center_head {
	border-bottom: 0px;
	margin-bottom: 10px;
}
.form_head.center_head ul {
	text-align: center;
}
.form_head.center_head ul .form_tittle h4 {
	padding: 0px;
}
.form_head.center_head ul .form_tittle h4 p {
	margin:0px;
	font-size: 16px;
	font-weight: bold;
	text-transform: uppercase;
}
.form-horizontal .control-label{font-size: 13px !important;}

/***added to center align the form head text****/
</style>
<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid">
  <div class="row">
   <div class="col-sm-8 plft0">  
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
      <li>
        <a href="<?php echo $rule_list_pg_url; ?>"><?php echo 'Rule List';  ?></a></li>
      <li class="active"><?php echo $title; ?></li>
    </ol>
   </div> 
   <div class="col-sm-4"></div>
  </div>
 </div>
</div>



<div id="main-wrapper" class="container-fluid compp_fluid">
  <?php 
    echo $this->session->flashdata('message'); 
	echo $msg;    
	$val=json_decode($tooltip[0]->step);    
?>

  <div class="salary_rt_ftr">
    <div class="">
    <div class="form_head center_head clearfix">
      <div class="col-sm-12">
        <ul class="">
          <li>
            <div class="form_tittle">
              <h4><span><?php echo $performance_cycle_dtls["name"]; ?></span></h4>
            </div>
          </li>
        </ul>
      </div>
    </div>
    
    <div class="form_sec clearfix">
    <div class="form_head new_fom_head clearfix">
      <div class="col-sm-12">
        <ul>
          <li>
            <div class="form_tittle">
              <h4>Select Target Population For This Plan</h4>
            </div>
          </li>
          <li>
            <div class="form_info">
              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $$val[1]?$$val[1]:'Select your employee population to cover under this plan. All the filter are interloped but they will only show the impact upon clicking “Confirm Selection” at the bottom right of the page.'; ?>"><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
            </div>
          </li>
          <li>
            <form class="form-horizontal" method="post" action="">
              <?php echo HLP_get_crsf_field();?>
              <input type="hidden" name="hf_select_all_filters" value="1" />
              <input style="margin-top:-5px;" type="submit" value="Select All" class="btn btn-primary"/>
            </form> 
            <?php $select_all = "";
          if($this->input->post("hf_select_all_filters"))
          {
          $select_all = 'selected="selected"';  
          }
      ?>          
          </li>
        </ul>
      </div>
    </div>




		<form class="form-horizontal mob_no_lbl_bg" method="post" action="">
			<?php echo HLP_get_crsf_field();?>

			<div class="row">
            <div class="col-sm-12"> 
              <div class="fltr_rule_box clearfix">
                <div class="col-sm-6 paddl0">
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Country</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            
                            <?php 
if(!empty($country_list)){?>
  <option  value="all">All</option>
  <?php 
                            foreach($country_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['country']) and in_array($row["id"], $rule_dtls['country'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">City</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_city" onchange="hide_list('ddl_city');" name="ddl_city[]" class="form-control multipleSelect" required="required" multiple="multiple">
                           <?php 
if(!empty($city_list)){?>
  <option  value="all">All</option>
  <?php 
                             foreach($city_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['city']) and in_array($row["id"], $rule_dtls['city'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Bussiness Level 1</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <?php 
if(!empty($bussiness_level_1_list)){?>
  <option  value="all">All</option>
  <?php 
                           foreach($bussiness_level_1_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level1']) and in_array($row["id"], $rule_dtls['business_level1'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                           <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Bussiness Level 2</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" required="required" multiple="multiple">
                           <?php 
if(!empty($bussiness_level_2_list)){?>
  <option  value="all">All</option>
  <?php 
                            foreach($bussiness_level_2_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level2']) and in_array($row["id"], $rule_dtls['business_level2'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                             <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Bussiness Level 3</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" required="required" multiple="multiple">
                           <?php 
if(!empty($bussiness_level_3_list)){?>
  <option  value="all">All</option>
  <?php 
                             foreach($bussiness_level_3_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level3']) and in_array($row["id"], $rule_dtls['business_level3'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Function</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_function" onchange="hide_list('ddl_function');" name="ddl_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                           <?php 
if(!empty($function_list)){?>
  <option  value="all">All</option>
  <?php 
                            foreach($function_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['functions']) and in_array($row["id"], $rule_dtls['functions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Sub Function</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_sub_function" onchange="hide_list('ddl_sub_function');" name="ddl_sub_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                              <?php 
if(!empty($sub_function_list)){?>
  <option  value="all">All</option>
  <?php  foreach($sub_function_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_functions']) and in_array($row["id"], $rule_dtls['sub_functions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    
                    <?php /* if($performance_cycle_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){ */ 
                    if(isset($sub_subfunction_list)){ ?>
                        <div class="form-group my-form attireBlock">
                           <label class="col-sm-4 col-xs-12 control-label removed_padding">Sub Sub Function</label>
                           <div class="col-sm-8 col-xs-12 removed_padding">
                            <div class="">
                               <select id="ddl_sub_subfunction" name="ddl_sub_subfunction[]" onchange="hide_list('ddl_sub_subfunction');" class="multipleSelect" required="required" multiple="multiple">
                                    <!--<option  value="all">All</option>-->
 <?php 
if(!empty($sub_subfunction_list)){?>
  <option  value="all">All</option>
  <?php  foreach($sub_subfunction_list as $row){?> 
                                    <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_subfunctions']) and in_array($row["id"], $rule_dtls['sub_subfunctions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                    <?php } ?>
                                </select>
                              </div>
                           </div>  
                        </div>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                                
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Designation</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                           <?php 
if(!empty($designation_list)){?>
  <option  value="all">All</option>
  <?php
                            foreach($designation_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['designations']) and in_array($row["id"], $rule_dtls['designations'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                           <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
					
					<div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Tenure in the company</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_tenure_company" onchange="hide_list('ddl_tenure_company');" name="ddl_tenure_company[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <option  value="all">All</option>
							
							<?php /*?><?php //Start :: tenures_list is only for a demo (just neet to remove if condition)
							if(isset($tenures_list)){foreach($tenures_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['tenure_company']) and in_array($row["id"], $rule_dtls['tenure_company'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["slot_no"]; ?></option>
                            <?php }}else{ 
							//End :: tenures_list is only for a demo (Remove else end braces also)
							?><?php */?>
							
                            <?php for($i=0; $i<=35; $i++){?>
                            <option  value="<?php echo $i; ?>" <?php if(isset($rule_dtls['tenure_company']) and in_array($i, $rule_dtls['tenure_company'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                            <?php }//} ?>
                          </select>
                        </div>
                      </div>
                    </div>
                </div>



                <div class="col-sm-6 paddr0">
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Grade</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <?php 
if(!empty($grade_list)){?>
  <option  value="all">All</option>
  <?php foreach($grade_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['grades']) and in_array($row["id"], $rule_dtls['grades'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                           <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                           
                          </select>
                         

                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Level</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" required="required" multiple="multiple">
                             <?php 
if(!empty($level_list)){?>
  <option  value="all">All</option>
  <?php  foreach($level_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['levels']) and in_array($row["id"], $rule_dtls['levels'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                         <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Education</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_education" onchange="hide_list('ddl_education');" name="ddl_education[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <?php 
if(!empty($education_list)){?>
  <option  value="all">All</option>
  <?php foreach($education_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['educations']) and in_array($row["id"], $rule_dtls['educations'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                          <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Talent</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_critical_talent" onchange="hide_list('ddl_critical_talent');" name="ddl_critical_talent[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <?php 
if(!empty($critical_talent_list)){?>
  <option  value="all">All</option>
  <?php foreach($critical_talent_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['critical_talents']) and in_array($row["id"], $rule_dtls['critical_talents'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Position</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_critical_position" onchange="hide_list('ddl_critical_position');" name="ddl_critical_position[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <?php 
if(!empty($critical_position_list)){?>
  <option  value="all">All</option>
  <?php foreach($critical_position_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['critical_positions']) and in_array($row["id"], $rule_dtls['critical_positions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                           <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Special Category</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_cspecial_category" onchange="hide_list('ddl_cspecial_category');" name="ddl_special_category[]" class="form-control multipleSelect" required="required" multiple="multiple">
                          <?php 
if(!empty($special_category_list)){?>
  <option  value="all">All</option>
  <?php foreach($special_category_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['special_category']) and in_array($row["id"], $rule_dtls['special_category'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                          <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
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
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Tenure in the Role</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_tenure_role" onchange="hide_list('ddl_tenure_role');" name="ddl_tenure_role[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <option  value="all">All</option>
							
							<?php /*?><?php //Start :: tenures_list is only for a demo (just neet to remove if condition)
							if(isset($tenures_list)){foreach($tenures_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['tenure_roles']) and in_array($row["id"], $rule_dtls['tenure_roles'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["slot_no"]; ?></option>
                            <?php }}else{ 
							//End :: tenures_list is only for a demo (Remove else end braces also)
							?><?php */?>
							
                            <?php for($i=0; $i<=35; $i++){?>
                            <option  value="<?php echo $i; ?>" <?php if(isset($rule_dtls['tenure_roles']) and in_array($i, $rule_dtls['tenure_roles'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                            <?php }//} ?>
                          </select>
                        </div>
                      </div>
                    </div>
					<?php if($rule_type != "salary"){ ?>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Cutoff Date</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($rule_dtls["cutoff_date"]) and $rule_dtls["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["cutoff_date"]));} ?>" autocomplete="off" onblur="checkDateFormat(this)">
                        </div>
                      </div>
                    </div> 
					<?php } ?>
                </div>
              </div>
            </div> 



			<?php if(isset($rule_type) and $rule_type == "salary"){ ?>
               <div class="col-sm-12">
                <div class="fltr_rule_box clearfix" >
                   <div class="col-sm-6 paddl0">
                        <div class="form-group my-form attireBlock">
                          <label class="col-sm-4 col-xs-12 control-label removed_padding">Choose Plan Type</label>
                          <div class="col-sm-8 col-xs-12 removed_padding">
                            <div class="">
                             <select id="ddl_quick_plan" class="form-control" name="ddl_quick_plan">
                              <option value=""> Create Your Customised Rule</option>
							  <?php foreach($quick_module_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if($row["id"]==$this->input->post('ddl_quick_plan')){echo 'selected="selected"';}?>><?php echo $row["plan_name"]; ?></option>
                           <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div> 
                    </div>
                   <div class="col-sm-6 paddr0">
                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Salary Rule Name</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <input type="text" id="txt_salary_rule_name" name="txt_salary_rule_name" value="<?php echo $rule_dtls["salary_rule_name"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                        </div>
                      </div> 
                   </div>

                   <div class="col-sm-6 paddl0">
                        <div class="form-group my-form attireBlock">
                          <label class="col-sm-4 col-xs-12 control-label removed_padding">Enter Your Salary Budget</label>
                          <div class="col-sm-8 col-xs-12 removed_padding">
                            <div class="">
                             <input type="text" id="txt_budget_per" name="txt_budget_per" class="form-control" maxlength="6" onkeyup="validate_percentage_onkeyup_common(this,3);" onblur="validate_percentage_onblure_common(this,3);" placeholder="Enter Your Salary Budget" value="<?php echo $this->input->post('txt_budget_per'); ?>" />
                            </div>
                          </div>
                        </div> 
                    </div>
                   <div class="col-sm-6 paddr0">
                      <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Cutoff Date</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
							<input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($rule_dtls["cutoff_date"]) and $rule_dtls["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["cutoff_date"]));} ?>" autocomplete="off" onblur="checkDateFormat(this)">
                        </div>
                      </div>
                    </div> 
                   </div>
                   
                   <div class="col-sm-6 paddl0">
                   <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Effective Date</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
							<input id="txt_effective_dt" name="txt_effective_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($rule_dtls["effective_dt"]) and $rule_dtls["effective_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["effective_dt"]));} ?>" autocomplete="off" onblur="checkDateFormat(this)">
						</div>
                      </div>
                    </div>
                 </div>
                </div>
               </div> 
            <?php } ?>    

  
            <div class="">
                <div class="col-sm-12">
                    <div class="sub-btnn text-right" id="dv_next" <?php if($select_all != ""){}elseif(!isset($rule_dtls)){echo 'style="display:none;"';} ?>>
                          <input type="submit" id="btnAdd" name="btn_next" value="Continue" class="btn btn-primary" />
                        </div>
                    <div class="sub-btnn text-right" id="dv_confirm_selection" <?php if(isset($rule_dtls) or $select_all != ""){echo 'style="display:none;"';} ?>>
                      <input type="submit" name="btn_confirm_selection" value="Confirm Selection" class="btn btn-primary" />
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
<div id="plan_detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        
        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>John</td>
                  <td>Doe</td>
                  <td>john@example.com</td>
                </tr>
                <tr>
                  <td>Mary</td>
                  <td>Moe</td>
                  <td>mary@example.com</td>
                </tr>
                <tr>
                  <td>July</td>
                  <td>Dooley</td>
                  <td>july@example.com</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
   	$('.multipleSelect').fastselect();
	$(document).ready(function()
	{
		$( "#txt_cutoff_dt, #txt_effective_dt" ).datepicker({ 
			dateFormat: 'dd/mm/yy',
			changeMonth : true,
			changeYear : true,
			// yearRange: "1995:new Date().getFullYear()",
		});
        var classcheck = $('.fstControls .fstQueryInput').hasClass('fstQueryInputExpanded');
        if(classcheck) {
            $('.fstControls .fstQueryInput').attr('required',true);
        }

        $('.fstControls .fstQueryInput').change(function(){
            var check_class = $(this).hasClass('fstQueryInputExpanded');
            if(!check_class) {
                $(this).removeAttr('required',true);
            }
        });      
	});


  /*$(function() {
  $(".fstMultipleMode").addClass('dexpand');
});*/

$('#quick_plan_detail').change(function(){
  //this is just getting the value that is selected
  var title = $(this).val();
  $('.modal-title').html(title);
  $('#plan_detail').modal('show');
});

</script> 
<script>
<?php /*?>function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
                if($(this).attr("data-value")!= 'all')
                {
                    $(this).find(".fstChoiceRemove").trigger("click");
                }
            });
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}<?php */?>

function hide_list(obj_id)
{
    $("#dv_next").hide();
	$("#dv_confirm_selection").show();
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
                //if($(this).attr("data-value")!= 'all')
                //{
                    $(this).find(".fstChoiceRemove").trigger("click");
                //}
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
<style type="text/css">
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
</style>
