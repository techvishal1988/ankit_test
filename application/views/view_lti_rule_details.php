<!-- **************** Filter form css Start ***************** -->
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>

<style>
/********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/

    
.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls {width:23.0em !important; }

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

.control-label {
	line-height:42px;
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
.panel-heading.pading{padding: 2px 32px 2px 0px !important;} 

.table tr th{text-align: center;}


</style>
<!-- **************** Filter form css End ***************** -->

<style>
.form_head ul{ padding:0px; margin-bottom:0px;}
.form_head ul li{ display:inline-block;}

.rule-form .control-label {
	font-size: 12px;
	line-height: 29px;
}
.rule-form .form-control {
	height: 30px;
	margin-top: 0px;
	font-size: 12px;
	background-color: #FFF;
	margin-bottom:10px;
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
	font-size: 20px;
	padding: 7px;
	margin-top:-4px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
	margin-bottom: 10px;
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
	border-bottom-left-radius: 0px; /*6px;*/
	border-bottom-right-radius: 0px; /*6px;*/
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
#txt_manual_budget_amt {
    border: none !important;
    width: 118px;
    margin-left: 30px;
    margin-top: -25px;
    padding: 0px !important;
}
.tooltipcls{
    float:none !important;
}
</style>
<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
    <li><a href="<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]); ?>">Rule List</a></li>
    <li class="active">View LTI Rule Details</li>
  </ol>
</div>
<div id="main-wrapper" class="container"><!-- container -->
<div class="row">
  <div class="col-md-12">
    <div class="mb20">
      <div class="panel panel-white"> <?php 
      echo $this->session->flashdata('message');
      $p=getToolTip('lti-rule-page-1');
      $page1=json_decode($p[0]->step);
      $p2=getToolTip('lti-rule-page-2');
      $page2=json_decode($p2[0]->step);
      $p3=getToolTip('lti-rule-page-3');
      $page3=json_decode($p3[0]->step);
      $p4=getToolTip('lti-rule-page-4');
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
                                        <h4 style="cursor:pointer; color:#00adef" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i class="  more-less glyphicon glyphicon-minus"></i> mployee segments to be covered</h4>
                                      </div> -->
                                      <div class="form_tittle">
                                        <h4 style="cursor:pointer; color:#000" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i style="display: none;" class="  more-less glyphicon glyphicon-minus"></i> mployee segments to be covered</h4>
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
									<div class="form-group my-form attireBlock" >
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
									   <input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" maxlength="10" value="<?php if(isset($rule_dtls["cutoff_date"]) and $rule_dtls["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["cutoff_date"]));} ?>" >
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
            <div class="form-group" style="margin-bottom:0px !important;">
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
                    <div class="form_sec clearfix">
                      <div class="col-sm-12">
                      
                      	<div class="col-sm-6 removed_padding">
                            	<label for="inputPassword" class="control-label">LTI Linked with <span type="button" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[2] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                        <div class="col-sm-6" style="pointer-events:none;">
                            <select class="form-control" id="ddl_lti_linked_with" name="ddl_lti_linked_with" required>
                                <option value="">Select</option>
                                <option value="<?php echo CV_LTI_LINK_WITH_STOCK ?>" <?php if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_STOCK){ ?> selected="selected" <?php } ?>>Stock Value</option>
                                <option value="<?php echo CV_LTI_LINK_WITH_CASH ?>" <?php if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_CASH){ ?> selected="selected" <?php } ?>>Cash</option>
                            </select>
                        </div>
                        
                        <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">LTI Grant Baseline <span type="button"  data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[3] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6" style="pointer-events:none;">
                            <select class="form-control" id="ddl_lti_basis_on" name="ddl_lti_basis_on" onchange="show_hide_salary_elem_dv();" required>
                                <option value="">Select</option>
                                <option value="1" <?php if($rule_dtls['lti_basis_on'] == '1'){ ?> selected="selected" <?php } ?>>Linked To Salary Elements</option>
                                <option value="2" <?php if($rule_dtls['lti_basis_on'] == '2'){ ?> selected="selected" <?php } ?>>Fixed Amount</option>
                            </select>
                        </div>
                        
                        <div id="dv_salary_elem" style="display:none;">
                            <div class="col-sm-6 removed_padding">
                                <label for="inputPassword" class="control-label">Salary Elements <span type="button" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[4] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>            
                            </div>
                            <div class="col-sm-6" style="margin-bottom:12px;pointer-events:none;">
                                <select id="ddl_salary_elements" onchange="hide_list('ddl_salary_elements');" name="ddl_salary_elements[]" class="form-control multipleSelect" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($salary_applied_on_elem_list){
                                        $salary_applied_on_elements = "";
                                        if(isset($rule_dtls['applied_on_elements']))
                                        {
                                            $salary_applied_on_elements = explode(",", $rule_dtls['applied_on_elements']);
                                        }
                                        foreach($salary_applied_on_elem_list as $row){ ?>
                                    <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($salary_applied_on_elements) and in_array($row["business_attribute_id"], $salary_applied_on_elements)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">LTI Differentiation To Be Based On <span type="button" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[5] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        </div>
                        <div class="col-sm-6" style="pointer-events:none;">
                            <select class="form-control" id="ddl_target_lti_on" name="ddl_target_lti_on" required>
                                <option value="">Select</option>
                                <option value="<?php echo CV_DESIGNATION; ?>" <?php if($rule_dtls['target_lti_on'] == CV_DESIGNATION){ ?> selected="selected" <?php } ?>>Designation</option>
                                <option value="<?php echo CV_GRADE; ?>" <?php if($rule_dtls['target_lti_on'] == CV_GRADE){ ?> selected="selected" <?php } ?>>Grade</option>
                                <option value="<?php echo CV_LEVEL; ?>" <?php if($rule_dtls['target_lti_on'] == CV_LEVEL){ ?> selected="selected" <?php } ?>>Level</option>
                            </select>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">  
                    <div class="col-sm-12 ">    
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
                              <div class="form_info">
                                <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[5] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
                              </div>
                              </li>
                             </ul>
                            </div>
                            
                          </div>
                           <div class="form_sec clearfix" style="pointer-events:none;">                       
                           <div class="col-sm-12">
                                
                                <div class="col-sm-6 removed_padding">
                                    <label class="control-label">Manager's Discretion For LTI Allocation </label>
                                </div>
                                <div class="col-sm-6">
                                
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <span style="font-weight:bold; font-size:20px;">-</span>
                                        </div>
                                        <div class="col-sm-4">
                                           <input type="text" name="txt_manager_discretionary_decrease" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_decrease"]){echo $rule_dtls["manager_discretionary_decrease"];}else{echo "0";} ?>" maxlength="5" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" />
                                        </div>
                                        
                                        <div class="col-sm-1">
                                            <span style="font-weight:bold; font-size:20px;">+</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" name="txt_manager_discretionary_increase" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_increase"]){echo $rule_dtls["manager_discretionary_increase"];}else{echo "0";} ?>" maxlength="5" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);"/>
                                         </div>                              
                                    </div>                          
                                </div>
                                                            
                             </div>
                            </div>
                        </div>    
                    </div>   
                </div>
                
              <div class="row">
    <div class="col-sm-12 ">
      <div class="rule-form">
        <div class="form_head clearfix">
          <div class="col-sm-12">
            <ul>
              <li>
                <div class="form_tittle">
                  <h4>Step Three</h4>
                </div>
              </li>
              <li>
                <div class="form_info">
                  <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page3[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="form_sec  clearfix table-responsive">
          <table class="table table-bordered ">
            <thead>
              
            </thead>
            <tbody>
			<?php $i=0; $j=0;
                if($target_lti_elements)
                { 
					$target_lti_dtl_arr = "";
					if($rule_dtls['target_lti_dtls'])
					{
						$target_lti_dtl_arr = json_decode($rule_dtls['target_lti_dtls'], true);
						//echo "<pre>";print_r($target_lti_elements);die;
					}
					
					$vesting_dates_arr = "";
					if($rule_dtls['vesting_date_dtls'])
					{
						$vesting_dates_arr = json_decode($rule_dtls['vesting_date_dtls'], true);
					}
					?>
                    
                    <tr bgcolor="#BBFFFF" style="pointer-events:none;">
                            <th style="min-width:85px;" colspan="2">Vesting Dates </th>                            
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[0]; ?>"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[1]; ?>"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[2]; ?>"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[3]; ?>"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[4]; ?>"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[5]; ?>"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" maxlength="10" required value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[6]; ?>"/></td>
                      </tr>
                      
					<?php foreach($target_lti_elements as $row){						
						if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_STOCK and $i == 0){ ?>
                    
                		<tr bgcolor="#BBFFFF" class="custom_icon_color">
                            <th>Period <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[1] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Stock Value at the time of Grant <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-1 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[3] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-2 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[4] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-3 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[5] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-4 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[6] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-5 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[7] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-6 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[8] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-7 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[9] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        </tr>
                      
                		<tr bgcolor="#BBFFFF"  style="pointer-events:none;">
                            <th style="min-width:85px;">Stock Price</th>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?>" name="txt_grant_val[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?>" name="txt_vesting_val_1[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?>" name="txt_vesting_val_2[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?>" name="txt_vesting_val_3[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?>" name="txt_vesting_val_4[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?>" name="txt_vesting_val_5[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?>" name="txt_vesting_val_6[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?>" name="txt_vesting_val_7[]" placeholder="0" /></td>
                      </tr>
                	<?php $i++; } ?>
                    
                  <?php if($j==0){?>
                  	 <tr class="custom_icon_color">
                        <th bgcolor="#B9B9B9" ><?php echo ucfirst($rule_dtls['target_lti_on']); ?> <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[10] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th bgcolor="#B9B9B9"><?php if($rule_dtls['lti_basis_on']==2){echo "Fixed Amount";}else{echo "Grant as %age of selected salary elements";} ?> <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                       <th>Vesting-1 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[11] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th>Vesting-2 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[12] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th>Vesting-3 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[13] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th>Vesting-4 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[14] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th>Vesting-5 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[15] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th>Vesting-6 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[16] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th>Vesting-7 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[17] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                      </tr>
                  <?php } ?>  
                  <tr style="pointer-events:none;">
                  
                    <td bgcolor="#B9B9B9" style="min-width:85px;" id="td_<?php echo $i; ?>"><?php $name_arr = explode(CV_CONCATENATE_SYNTAX, $row); echo $name_arr[1]; ?></td>
                    <td bgcolor="#B9B9B9">
                        
                        <input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?>" name="txt_grant_val[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?>" name="txt_vesting_val_1[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?>" name="txt_vesting_val_2[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?>" name="txt_vesting_val_3[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?>" name="txt_vesting_val_4[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?>" name="txt_vesting_val_5[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?>" name="txt_vesting_val_6[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?>" name="txt_vesting_val_7[]" placeholder="0" /></td>
                  </tr>
                  
            <?php $i++;$j++;} }?>
            </tbody>
          </table>
		  
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
                        <h4>Define Budget Allocation</h4>
                      </div>
                      </li>
                    <li>
                      <div class="form_info">
                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page4[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
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
                        <select class="form-control" name="ddl_overall_budget" required id="ddl_overall_budget" disabled="disabled">
                            <option value="">Select</option>
                            <option value="No limit" <?php if($rule_dtls["budget_type"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                            <option value="Automated locked" <?php if($rule_dtls["budget_type"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                            <option value="Automated but x% can exceed" <?php if($rule_dtls["budget_type"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                             <?php /*?><option value="Manual" <?php if($rule_dtls["budget_type"]=="Manual"){echo 'selected="selected"';} ?>>Manual</option> <?php */?>
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
            <div class="form-group" id="dv_budget_manual" style="display:none; pointer-events:none;">
                
            </div>
            </div>
            </div>
            </div>

        </div>
              
              <?php if(($is_enable_approve_btn) and $rule_dtls["status"]==4){ ?>
                            
              <form action="<?php echo site_url("reject-lti-rule-approval-request/".$rule_dtls["id"]); ?>" method="post" class="form-inline">
              	<?php echo HLP_get_crsf_field();?>
                <div class="row" style="display: none;" id="dv_remark">
                    <div class="col-sm-12 ">                  
                    	<div class="form_sec clearfix">                     
                        	<div class="col-sm-12">                            	
                                <div class="form-input">
                                	<input type="hidden" name="hf_req_for" id="hf_req_for" value="" />
                                	<textarea class="form-control" rows="6" name="txt_remark" placeholder="Enter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px;height: 98px;width: 883px;"></textarea>
                                </div>                              				
                            </div>                    
                      </div>
                    </div>
                </div> 
                
                <div class="row">
                     <div class="col-sm-12">                      
                        <div class="submit-btn" style="display: none;" id="dv_remrk_submit_btn">
                            <input style="margin-left:10px;"  type="submit" class="btn btn-twitter  add-btn" value="Submit Reason" id="btnReject" />
                        </div>
                        <div class="submit-btn" id="dv_reject_btn">
                            <input style="margin-left:10px;"  type="button" onclick="show_remark_dv();" class="btn btn-twitter add-btn" value="Reject" id="btnReject" />
                        </div>
                        <div class="submit-btn" id="dv_delete_btn"> 
                            <input style="margin-left:10px;"  type="button" onclick="show_remark_dv_on_delete();" class="btn btn-twitter add-btn" value="Delete" id="btn_delete" />
                        </div>
                        <div class="submit-btn"> 
                            <a class="anchor_cstm_popup_cls_lti_rule_appv" href="<?php echo site_url("update-lti-rule-approvel/".$rule_dtls["id"]); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_lti_rule_appv', 'Are you sure, You want to approve request?')">
                                <input style="margin-left:10px;"  type="button" class="btn btn-twitter add-btn" value="Approve" id="btnSave" />
                            </a>
                        </div>
                    </div>
                </div>
              </form>
              
              <?php } ?>
              
              <?php if($rule_dtls["status"]==3){?>
                <div class="row">
                    <div class="col-sm-12" id="budget_action_confirm">
                        <a  href="<?php echo site_url("send-lti-rule-for-approval/".$rule_dtls["id"]."/1"); ?>" onclick="return on_confirm_hide_btns();">
                          <input style="margin-left:10px;" title="Send For Release" type="button" class="btn btn-twitter add-btn" value="Send for Approval – HR Driven Process" id="btnSave" />
                        </a>
                    
                        <a  href="<?php echo site_url("send-lti-rule-for-approval/".$rule_dtls["id"]); ?>" onclick="return on_confirm_hide_btns();">
                          <input title="Send For Approval" style="margin-left:10px;" type="button" class="btn btn-twitter add-btn" value="Send for Approval - Manager Self Service Process" id="btnSave" />
                        </a>
                   
                        <a  href="<?php echo site_url("create-lti-rules/".$rule_dtls["id"]); ?>">
                          <input style="margin-left:10px;" type="button" class="btn btn-twitter add-btn" value="Edit Rule" id="btnSave" />
                        </a>
                    </div>      
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

function show_hide_salary_elem_dv()
{
	$("#ddl_salary_elements").prop('required',false);
	$("#dv_salary_elem").hide();
	if($("#ddl_lti_basis_on").val()=='1')
	{
		$("#ddl_salary_elements").prop('required',true);
		$("#dv_salary_elem").show();
	}
}

function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
    $("#dv_submit_3_step").hide();

    if(val != '')
    {
        $.post("<?php echo site_url("lti_rule/get_managers_for_manual_bdgt/1");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
        {
            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();
                $("#dv_submit_3_step").show();
				
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
					
					var r=1;
					if(val=='Manual')
					{
						//$("input[name='txt_manual_budget_amt[]']").each( function (key, v)
						$("input[name='hf_managers[]']").each( function (key, v)
						{
							//$(this).val(Math.round(items[i]).toLocaleString());
							//$(this).prop('readonly',true);;
							$("#dv_manual_budget_"+ r).html(Math.round(items[i]).toLocaleString());
							calculat_percent_increased_val(1, items[i], (i+1));
							i++;    r++;
						});
						calculat_total_revised_bgt();
					}
					if(val=='Automated but x% can exceed')
					{
						//$("input[name='txt_manual_budget_per[]']").each( function (key, v)
						$("input[name='hf_managers[]']").each( function (key, v)
						{
							//$(this).val(Math.round(items[i]).toLocaleString());
							//$(this).prop('readonly',true);;
							$("#dv_x_per_budget_"+ r).html(items[i]);
							calculat_percent_increased_val(2, items[i], (i+1));
							i++;    r++;
						});
						calculat_total_revised_bgt();
					}

				}
				settabletxtcolor();               
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
    //var cncy= $('#th_total_budget').html();
    //var curncy=cncy.split(' ');
	if(typ==1)
	{
		//$("#td_revised_bdgt_"+ index_no).html(val);
		$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));	
		var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
		$("#td_increased_amt_"+ index_no).html(increased_amt+' %');	
	}
	else if(typ==2)
	{
		var increased_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100).toFixed(0);
		var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
		//$("#td_revised_bdgt_"+ index_no).html(revised_bdgt);	
		$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
		var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
		$("#td_increased_amt_"+ index_no).html(increased_amt+' %');	
		$("#td_increased_amt_val_"+ index_no).html(increased_bdgt);
	}
}
function calculat_total_revised_bgt()
{
	var manager_cnt = $("#hf_manager_cnt").val();
	var val = 0;
	for(var i=1; i<manager_cnt; i++)
	{
		val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
	}
	//$("#th_total_budget").html(val.toFixed(0));
	//$("#th_total_budget").html(val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
	
	var per = (val/$("#hf_total_base_lti").val()*100).toFixed(2);
	$("#th_final_per").html(per + ' %');
	
	var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
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

function submit_frm(is_next_step)
{
	$("#hf_show_next_step").val(is_next_step);
	$("#btnAdd_1st" ).trigger( "click" );
}

function set_rules(frm)
{   
    var form=$("#"+frm.id);	
	/*if(frm.id == 'frm_rule_step1')
	{
		var total_weightage = 0;
		total_weightage += ($("#txt_individaul_bussiness_level").val())*1;
		total_weightage += ($("#txt_function_weightage").val())*1;
		
		$("input[name='txtbusiness_level[]']").each( function (key, v)
		{
			total_weightage += ($(this).val())*1;
		});
		
		if(total_weightage != "100")
		{
			alert("Total of all Business Level Weightage should we equeal to 100");
			return false;
		}
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
                window.location.href= "<?php echo site_url("view-lti-rule-budget/".$rule_dtls["id"]);?>";
            }    
			else if(response==2)
            {
                 $.get("<?php echo site_url("lti_rule/get_rule_step3_frm/".$rule_dtls["id"]);?>", function(data)
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
						window.location.href= "<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
					}
                }); 
            }        
            else if(response==1)
            {
                 $.get("<?php echo site_url("lti_rule/get_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
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
                        window.location.href= "<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
                    }
                }); 
            }
            else
            {
                $("#loading").css('display','none');
                window.location.href= "<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
            }
        }
    });
    return false;
}

show_hide_salary_elem_dv()

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




/*function show_remark_dv()
{
	var conf = confirm("Are you sure, You want to reject this request ?");
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
	var conf = confirm("Are you sure, You want to delete this rule ?");
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


function show_filters()
{
	$('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
}


function on_confirm_hide_btns()
{
 custom_confirm_popup_callback('<?php echo CV_CONFIRMATION_RELEASED_MESSAGE;?>',function(result)
  {
 
  if(result)
  {
   $("#budget_action_confirm").hide();
  }
  }
);
  
}



/*function on_confirm_hide_btns(){

 if (confirm('<?php //echo CV_CONFIRMATION_RELEASED_MESSAGE;?>')) {
    $("#budget_action_confirm").hide();
    return true;
} else {
  return false;   
}

}
*/

</script>

