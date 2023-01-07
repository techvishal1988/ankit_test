<!-- **************** Filter form css Start ***************** -->
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>

<style>
/********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}


/********dynamic colour for table from company colour***********/
    
.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls {width:24.0em; }

.my-form{background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}

.fstResults{ position:relative !important;}

.form_head ul{ padding:0px; margin-bottom:0px;}

.form_head ul li{ display:inline-block;}


.form_head {
	background-color: #f2f2f2;
	<?php /*?>border-top: 8px solid #93c301;<?php */?>
	border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
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
	color: #8b8b8b;
	font-size: 20px;
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
	/*margin-bottom: 30px;*/
	display: block;
	width: 100%;
	padding:20px;
	border-bottom-left-radius: 6px;
	border-bottom-right-radius: 6px;
}
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
	font-size: 12px;
	background-color: #FFF;
	margin-bottom:10px;
}
.rule-form .control-label {
	font-size: 12px;
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
	margin-top:-4px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
	/*margin-bottom: 10px;*/
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
.tooltipcls{
    margin-left: 10px;
}

#dv_budget_manual table tr td .form-control
{
	margin-bottom:0px !important;
}

#dv_budget_manual table tr td
{
	vertical-align: middle;
}

.panel-heading.pading{padding: 2px 32px 2px 0px !important;}

.form-group{margin-bottom: 10px;}

</style>
<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
   <div class="col-sm-12 col-xs-12">
   <ol class="breadcrumb">
    <li><a href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
    <li><a href="<?php echo site_url('rnr-rule-list/'.$rule_dtls['performance_cycle_id']); ?>">RNR rule list</a></li>
    <li class="active"><?php echo $title; ?></li>
     </ol>
   </div>
   </div>
 </div>
</div>
<div id="main-wrapper" class="container"><!-- container -->
<div class="row">
  <div class="col-md-12">
    <div class="mb20">
      <div class="panel panel-white"> <?php 
      echo $this->session->flashdata('message');
      $p=getToolTip('rnr-rule-page-1');
      $page1=json_decode($p[0]->step);
      $p2=getToolTip('rnr-rule-page-2');
      $page2=json_decode($p2[0]->step);
      $p3=getToolTip('rnr-rule-page-3');
      $page3=json_decode($p3[0]->step);
      $p4=getToolTip('rnr-rule-page-4');
      $page4=json_decode($p4[0]->step);
      ?>
        <div class="panel-body">
<!-- **************** Filter form HTML Start ***************** -->
			<div class="salary_rt_ftr " role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading pading" role="tab" id="headingOne">
                    	<div class="form_head clearfix" style="padding:0px; border:0px !important; border-radius:0px; box-shadow:0px 0px 0px 0px #d6d6d6 !important;">
                            <div class="col-sm-12">
                                <ul>
                                    <li>
                                      <!-- <div class="form_tittle">
                                        <h4 style="cursor:pointer; color:#00adef" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i class="more-less glyphicon glyphicon-minus"></i>  Employee segments to be covered</h4>
                                      </div> -->
                                      <div class="form_tittle">
                                        <h4 style="cursor:pointer; color:#000" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i style="display: none;" class="more-less glyphicon glyphicon-minus"></i>  Employee segments to be covered</h4>
                                      </div>
                                      </li>
                                    <li>
                                      <div class="form_info">
                                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page1[0]; ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                                      </div>
                                      </li>
                                </ul>
                            </div>                    
                        </div>                        
						
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							
							<div class="form_sec clearfix" style="pointer-events:none;">
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
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12 ">
                  <div class="form_head clearfix">
                    <div class="col-sm-12">
                    <ul>
                    <li>
                      <div class="form_tittle">
                        <h4>Step One</h4>
                      </div>
                      </li>
                    <li>
                      <div class="form_info">
                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                      </div>
                      </li>
                     </ul>
                    </div>
                    
                  </div>
                  <div class="form_sec clearfix" style="pointer-events:none;">
                 
                    <div class="col-sm-12">
                      <div class="col-sm-6 removed_padding">
                        <label for="inputEmail3" class="control-label">Plan Name</label>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-input">
                          <input type="text" name="txt_performance_cycle" class="form-control" value="<?php echo $rule_dtls["name"]; ?>" readonly="readonly"/>
                        </div>
                      </div>
                      
					<div class="col-sm-6 removed_padding">
                        <label class="control-label">Rule Name</label>
                      </div>
                      <div class="col-sm-6 ">
                        <input type="text" name="txt_performance_cycle" class="form-control" value="<?php echo $rule_dtls["rule_name"]; ?>" readonly="readonly"/>
                      </div>
                    </div>
                
                  </div>
                </div>
              </div>
			  
              <div id="dv_partial_page_data">
                <div class="row">
                  <div class="col-sm-12 ">
                    <div class="form_head clearfix">
                      <div class="col-sm-12">
                    <ul>
                    <li>
                      <div class="form_tittle">
                        <h4>Step Two</h4>
                      </div>
                      </li>
                    <li>
                      <div class="form_info">
                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[1] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                      </div>
                      </li>
                     </ul>
                    </div>
                    </div>
                    <div class="form_sec clearfix" >
                      <div class="col-sm-12">
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Category <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[2] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6" style="pointer-events:none;">
                            <input type="text" name="txt_category" value="<?php echo $rule_dtls["category"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Criteria <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[3] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6" style="pointer-events:none;">
                            <input type="text" name="txt_criteria" value="<?php echo $rule_dtls["criteria"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Award Type <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[4] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label></label>
                          </div>
                          <div class="col-sm-6" style="pointer-events:none;">
                            <select class="form-control" id="ddl_award_type" name="ddl_award_type" required onchange="reset_budget_fields();">
                              <option value="1" <?php if($rule_dtls['award_type'] == "1"){ ?> selected="selected" <?php } ?>>Cash</option>
                              <option value="2" <?php if($rule_dtls['award_type'] == "2"){ ?> selected="selected" <?php } ?>>Points</option>
                              <option value="3" <?php if($rule_dtls['award_type'] == "3"){ ?> selected="selected" <?php } ?>>Just Recognisation (Manager)</option>
                              <option value="4" <?php if($rule_dtls['award_type'] == "4"){ ?> selected="selected" <?php } ?>>Just Recognisation (Employee)</option>
                            </select>
                          </div>
                          <div class="col-sm-6 removed_padding dv_award_value">
                            <label for="inputPassword" class="control-label">Award Value <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[5] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label></label>
                          </div>
                          <div class="col-sm-6 dv_award_value" style="pointer-events:none;">
                            <input type="text" name="txt_award_value" id="txt_award_value" value="<?php echo $rule_dtls["award_value"]; ?>" class="form-control" required="required" maxlength="10" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" onchange="reset_budget_fields();"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Award Frequency (In Months) <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[6] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label></label>
                          </div>
                          <div class="col-sm-6" style="pointer-events:none;">
                            <input type="text" name="txt_award_frequency" id="txt_award_frequency" value="<?php echo $rule_dtls["award_frequency"]; ?>" class="form-control" required="required" maxlength="2" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);" onchange="reset_budget_fields();"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Frequency for Employee (In Months) <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[7] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label></label>
                          </div>
                          <div class="col-sm-6" style="pointer-events:none;">
                            <input type="text" name="txt_emp_frequency_for_award" value="<?php echo $rule_dtls["emp_frequency_for_award"]; ?>" class="form-control" required="required" maxlength="2" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Is Approval Required <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[8] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label></label>
                          </div>
                          <div class="col-sm-6" style="pointer-events:none;">
                            <select class="form-control" id="ddl_is_approval_required" name="ddl_is_approval_required" required>
                              <option value="1" <?php if($rule_dtls['is_approval_required'] == "1"){ ?> selected="selected" <?php } ?>>Yes</option>
                              <option value="2" <?php if($rule_dtls['is_approval_required'] == "2"){ ?> selected="selected" <?php } ?>>No</option>
                            </select>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
                            
              <div class="row" id="dv_overall_budget">
                  <div class="col-sm-12 ">
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
                              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[9] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="form_sec clearfix" style="pointer-events:none;">
                      <div class="col-sm-12">
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Overall Budget Allocation</label>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control" name="ddl_overall_budget" required id="ddl_overall_budget">
                            <option value="">Select</option>
                            <option value="No limit" <?php if($rule_dtls["budget_type"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                            <option value="Automated locked" <?php if($rule_dtls["budget_type"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                            <option value="Automated but x% can exceed" <?php if($rule_dtls["budget_type"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                            <?php /*?><option value="Manual" <?php if($rule_dtls["budget_type"]=="Manual"){echo 'selected="selected"';} ?>>Manual</option><?php */?>
                          </select>
                        </div>
                        <div class="col-sm-3 p_l0">
                        <select class="form-control" required id="ddl_to_currency">
                        	<?php foreach($currencys as $currency){?>
                            <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]; ?></option>
                            <?php } ?>
                        </select>               
                    </div>
                      </div>
                      
                      <div class="col-sm-12">
                      <div class="form-group" id="dv_budget_manual" style="display:none;"> </div>
                    </div>
                    </div>
                  </div>
                </div>  
              
              
              <?php if(($is_enable_approve_btn) and $rule_dtls["status"]==4){ ?>
              <form action="<?php echo site_url("reject-rnr-rule-approval-request/".$rule_dtls["id"]); ?>" method="post" class="form-inline">
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
                </div>
                <div class="row">
                    <div class="col-sm-12">                        
                        <div class="submit-btn all" style="display: none;" id="dv_remrk_submit_btn">
                            <input type="submit" class="btn btn-twitter add-btn" value="Submit Reason" id="btnReject" />
                        </div>
                    
                        <div class="submit-btn all" id="dv_reject_btn">
                            <input type="button" onclick="show_remark_dv();" class="btn btn-twitter add-btn" value="Reject" id="btnReject" />
                        </div>
                 
         
                        <div class="submit-btn all" id="dv_delete_btn"> 
                            <input type="button" onclick="show_remark_dv_on_delete();" class="btn btn-twitter add-btn" value="Delete" id="btn_delete" />
                        </div>
                   
                        <div class="submit-btn all"> 
                            <a class="anchor_cstm_popup_cls_rnr_rule_appv" href="<?php echo site_url("update-rnr-rule-approvel/".$rule_dtls["id"]); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_rnr_rule_appv','Are you sure, You want to approve request?')">
                                <input type="button" class="btn btn-twitter add-btn" value="Approve" id="btnSave" />
                            </a>
                        </div>
                    </div>
                </div>
                
              </form>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
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

function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
	
	if($("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
	{
		$("#txt_award_value").val('0');
		$(".dv_award_value").hide();
	}
	
	var award_val = ($("#txt_award_value").val())*1;
	var award_fr_val = ($("#txt_award_frequency").val())*1;
	
	if(award_fr_val <= 0 && $("#ddl_award_type").val()==1)
	{
		 $("#ddl_overall_budget").val('');
		 if(is_need_pre_fill==0)
		 {
			custom_alert_popup("please enter Award Frequency value first");
		 }
		return false;
	}

    if(val != '')
    {
		if($("#ddl_award_type").val()==2 || $("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
		{
			award_val = 0;
		}
		
        $.post("<?php echo site_url("rnr_rule/get_managers_for_manual_bdgt");?>",{budget_type: val, to_currency: to_currency, award_val: award_val, award_fr_val: award_fr_val, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
        {
            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();
				
				if($("#ddl_award_type").val()==2 || $("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
				{
					 $("#dv_overall_budget").hide();
				}
				else
				{
					$("#dv_overall_budget").show();
				}
				
				if(is_need_pre_fill==1)
				{
					var json_manual_budget_dtls = '<?php echo $rule_dtls["budget_dtls"]; ?>';
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
							i++;    
						});
					}
					if(val=='Automated but x% can exceed')
					{
						$("input[name='txt_manual_budget_per[]']").each( function (key, v)
						{
							$(this).val(items[i]);
							//$(this).prop('readonly',true);;
							i++;    
						});
					}settabletxtcolor();
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
        });
    }
}

show_hide_budget_dv('<?php echo $rule_dtls["budget_type"]; ?>', $("#ddl_to_currency").val(), '1');


function show_remark_dv()
{
 custom_confirm_popup_callback('Are you sure, You want to reject this request ?',function(result)
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
  custom_confirm_popup_callback('Are you sure, You want to delete this rule ?',function(result)
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



// function show_remark_dv()
// {
// 	var conf = confirm("Are you sure, You want to reject this request ?");
// 	if(!conf)
// 	{
// 	  return false;
// 	}
// 	$("#hf_req_for").val('1');
// 	$("#dv_reject_btn").hide();
// 	$("#dv_delete_btn").show();
// 	$("#dv_remark").show();
// 	$("#dv_remrk_submit_btn").show();
// }
// function show_remark_dv_on_delete()
// {
// 	var conf = confirm("Are you sure, You want to delete this rule ?");
// 	if(!conf)
// 	{
// 	  return false;
// 	}
// 	$("#hf_req_for").val('2');
// 	$("#dv_reject_btn").show();
// 	$("#dv_delete_btn").hide();
// 	$("#dv_remark").show();
// 	$("#dv_remrk_submit_btn").show();
// } 



function show_filters()
{
	$('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
}
</script>

