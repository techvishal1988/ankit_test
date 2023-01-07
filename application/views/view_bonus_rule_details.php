<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<!-- **************** Filter form css Start ***************** -->
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
/********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/

.fstMultipleMode {
  display: block;
}
.fstMultipleMode .fstControls {
  width:23.2em !important;
}
.my-form {
background:#<?php echo $this->session->userdata("company_light_color_ses");
?>!important;
}
.fstElement:hover {
box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses");
?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses");
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
  margin-bottom: 30px;
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
  background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
  
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
}
.rule-form .form_sec {
  padding-top: 10px;
  background-color: #f2f2f2;
/*  margin-bottom: 30px;*/
  display: block;
  width: 100%;
  /*padding: 5px 0px 9px 0px;*/
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
.paddg{ 0px 20px;}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{ background-color:#eee !important;}
.myspan{
        font-size: inherit !important;
        color:#4E5E6A !important;
    }
    #txt_manual_budget_amt{
        border: none !important;
    width: 118px;
    margin-left: 30px;
    margin-top: -25px;
    padding: 0px !important;
    background: #fff !important;
        font-weight: 400;
    }   
.panel-heading.pading{padding: 2px 32px 2px 0px !important;}  


</style>
<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
    <li><a href="<?php echo site_url("bonus-rule-list/".$rule_dtls['performance_cycle_id']); ?>">Rule List</a></li>
    <li class="active"><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Rule Detail</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12" id="dv_partial_page_data">
      <div class="mb20">
        <div class="panel-white">
          <div class="">
            <div class="row">
              <div class="col-sm-12"> <?php echo $this->session->flashdata('message');  
                                $tooltip=getToolTip('bonus-rule-page-1');
                                $page1=json_decode($tooltip[0]->step); 
                                $p2=getToolTip('bonus-rule-page-2');
                                $page2=json_decode($p2[0]->step);
                                $p3=getToolTip('bonus-rule-page-3');
                                $page3=json_decode($p3[0]->step); 
                                ?> </div>
            </div>
            
            <!-- **************** Filter form HTML Start ***************** -->
            <div class="salary_rt_ftr " role="tablist" aria-multiselectable="true">
              <div class="panel panel-default" >
                <div class="panel-heading pading" role="tab" id="headingOne">
                  <div class="form_head clearfix" style="padding:0px; border:0px !important; border-radius:0px; box-shadow:0px 0px 0px 0px #d6d6d6 !important;">
                    <div class="col-sm-12">
                      <ul style="padding-top:8px">
                        <li>
                          <!-- <div class="form_tittle">
                            <h4 style="cursor:pointer; color:#00adef" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i class="more-less glyphicon glyphicon-minus"></i> employee segments to be covered</h4>
                          </div> -->
                          <div class="form_tittle">
                            <h4 style="cursor:pointer; color:#000" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i style="display: none;" class="more-less glyphicon glyphicon-minus"></i>employee segments to be covered</h4>
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
                              <label class="col-sm-4 control-label removed_padding">Business Level 1 Achievement</label>
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
                              <label class="col-sm-4 control-label removed_padding">Business Level 2 Achievement</label>
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
                              <label class="col-sm-4 control-label removed_padding">Business Level 3 Achievement</label>
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
                            <?php /* if($performance_cycle_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){ */ ?>
                            <div class="form-group my-form attireBlock">
                              <label class="col-sm-4 col-xs-12 control-label removed_padding">Sub Sub Function</label>
                              <div class="col-sm-8 col-xs-12 removed_padding">
                                <div class="">
                                  <select id="ddl_sub_subfunction" name="ddl_sub_subfunction[]" onchange="hide_list('ddl_sub_subfunction');" class="multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php foreach($sub_subfunction_list as $row){?>
                                    <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_subfunctions']) and in_array($row["id"], $rule_dtls['sub_subfunctions'])){echo 'selected="selected"';}?> <?php echo $row["name"]; ?>><?php echo $row["name"]; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <?php /* } */ ?>
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
                          <input for="inputEmail3" class="form-control" value="<?php if(isset($rule_dtls["name"])){echo $rule_dtls["name"];} ?>" />
                        </div>
                        <div class="col-sm-6 removed_padding">
                          <label for="inputPassword" class="control-label"><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> Rule Name</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" name="txt_rule_name" value="<?php echo $rule_dtls["bonus_rule_name"]; ?>" class="form-control" required="required" maxlength="100" />
                        </div>
                        
                        <div class="col-sm-6 removed_padding">
                            <label class="control-label">Apply prorated <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> calculations</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" name="ddl_prorated_increase" required >
                              <option value="yes" <?php if($rule_dtls['prorated_increase'] == 'yes'){ echo 'selected="selected"'; } ?> >Yes</option>
                              <option value="no" <?php if($rule_dtls['prorated_increase'] != 'yes'){ echo 'selected="selected"'; } ?> >No</option>
                            </select>
                        </div>
                        <div class="col-sm-6 removed_padding">
                        <label class="control-label">Performance period for pro-rated calculations</label>
                        </div>
                        <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-6">
                            <input type="text" id="txt_start_dt" name="txt_start_dt" class="form-control" required="required" maxlength="10" value="<?php if($rule_dtls["start_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["start_dt"]));} ?>" placeholder="Start Date" autocomplete="off" />
                          </div>
                          <div class="col-sm-6">
                            <input type="text" id="txt_end_dt" name="txt_end_dt" class="form-control" required="required" maxlength="10" value="<?php if($rule_dtls["end_dt"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["end_dt"]));} ?>" placeholder="End Date" autocomplete="off" />
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
                    <div class="form_sec clearfix" style="pointer-events:none;">
                      <div class="col-sm-12">
                        <div class="col-sm-6 removed_padding" style="display:none;">
                          <label for="inputEmail3" class="control-label"><?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> To Be Paid On The Basis Of</label>
                        </div>
                        <div class="col-sm-6 removed_padding" style="margin:9px 0px; display:none;">
                          <div class="form-input beg_color">
                            <label style="display:inline; margin-right:10px; margin-left:8px;">
                              <input  type="radio" name="rb_payment_basis" value="M" <?php if($rule_dtls['payment_basis'] == 'M'){ ?>checked="checked"<?php } ?>>
                              <span>Multiple Roles Held</span></label>
                            <label style="display:inline; margin-right:10px; margin-left:8px;">
                              <input  type="radio" name="rb_payment_basis" value="L" <?php if($rule_dtls['payment_basis'] == 'L'){ ?>checked="checked"<?php } ?>>
                              <span>Last Role Held</span></label>
                          </div>
                        </div>
                        
                        <div class="col-sm-6 removed_padding">
                          <label for="inputPassword" class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> calculation as a %Age of a salary element</label>
                        </div>
                        <div class="col-sm-6">
                          <select class="form-control" id="ddl_target_bonus" name="ddl_target_bonus" >
                            <option value="">Select</option>
                            <option value="yes" <?php if($rule_dtls['target_bonus'] == 'yes'){ ?> selected="selected" <?php } ?>>Yes</option>
                            <option value="no" <?php if($rule_dtls['target_bonus'] == 'no'){ ?> selected="selected" <?php } ?>>No</option>
                          </select>
                        </div>
                        <div class="form-group" id="dv_target_bonus_on" style="display:none;">
                          <div class="col-sm-6 removed_padding">
                              <label for="inputPassword" class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> linked to which salary elements <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                            <div class="col-sm-6" style="margin-bottom:12px;">
                              <select id="ddl_bonus_applied_elem" name="ddl_bonus_applied_elem[]" class="form-control multipleSelect" multiple="multiple" >
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
                              <select class="form-control" id="ddl_target_bonus_elem_value_type" name="ddl_target_bonus_elem_value_type" >
                                <option value="1" <?php if($rule_dtls['target_bonus_elem_value_type'] == 1){ ?> selected="selected" <?php } ?>>Percentage</option>
                                <option value="2" <?php if($rule_dtls['target_bonus_elem_value_type'] == 2){ ?> selected="selected" <?php } ?>>Amount</option>
                              </select>
                            </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Target <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> based on</label>
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control" id="ddl_target_bonus_on" name="ddl_target_bonus_on" >
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
              
              <div id="dv_achievements_elements" style="display:none; pointer-events:none;"> </div>
              
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
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[5] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      
                        <div class="form_sec clearfix" style="pointer-events:none;">
                            <div class="col-sm-12">                    
                                <div class="col-sm-6 removed_padding">
                                  <label class="control-label">Performance Type</label>
                                </div>
                                <div class="col-sm-6 ">
                                    <select class="form-control" name="ddl_performance_type" required>
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
                                                  
                                    <div class="col-sm-6 removed_padding">
                                        <label class="control-label">Define payout approach for <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?></label>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <select class="form-control" name="ddl_performance_achievements_multiplier" required>
                                            <option value="1" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '1'){ echo 'selected="selected"'; } ?>>Single Multiplier</option>
                                            <option value="2" <?php if($rule_dtls['performance_achievements_multiplier_type'] == '2'){ echo 'selected="selected"'; } ?> >Decelerated or Accelerated Multiplier</option>
                                        </select>
                                    </div>
                            
                               <div class="row">
                                 <div style="padding-left: 15px !important;" class="col-sm-6 removed_padding pl15">
                                            <label class="control-label">Define performance ranges</label>
                                   </div>
                                <div class="col-sm-6">
                                  <?php 
                                if($rule_dtls['performance_achievement_rangs']){
                                    $rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"], true);
                                    
                                    foreach($rangs_arr as $row)
                                    { ?>
                                      <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="txt_perfo_achiev_range[]" class="form-control" id="txt_perfo_achiev_range" placeholder="Range" value="<?php echo $row['max']; ?>" required="required" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);">
                                        </div> 
                                        </div>                                       
                              <?php }} ?>  
                                </div>
                              </div>
                                  <div class="col-sm-12">
                                        <div class="form_sec  clearfix table-responsive forth">
                                          <table class="table table_p table-bordered th-top-aln">
                                            <thead>
                                              <tr>
                                                <th>Performance Range</th>
                                                <th>Define <?php if($rule_dtls["performance_achievements_multiplier_type"]==2){echo "Define Accelerators/ Decelerators";}else{ echo "Single Multiplier (In %)"; } ?> for each performance range</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php $i=0;
                                                    $rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"],true);
                                                    $multipliers_arr = json_decode($rule_dtls["performance_achievements_multipliers"],true);
                                                    foreach($rangs_arr as $row)
                                                    { ?>
                                                      <tr>
                                                        <td><?php 
                                                        $multipliers_val = "";
                                                        if(isset($multipliers_arr[$i]))
                                                        { 
                                                            $multipliers_val = $multipliers_arr[$i];
                                                        } 
                                                        
                                                        if($i==0)
                                                        { 
                                                            echo "0 < ".$row["max"];
                                                        } 
                                                        else
                                                        {
                                                            echo $row["min"]." To < ".$row["max"];
                                                        }
                                                        
                                                         ?></td>
                                                        <td><input  type="text" id="txt_perfo_achie_rangs_<?php echo $i; ?>" name="txt_perfo_achie_rangs[]" class="form-control w_unset" required onKeyUp="validate_negative_percentage_onkeyup_common(this);" onBlur="validate_negative_percentage_onblure_common(this);" maxlength="5" value="<?php echo $multipliers_val; ?>" style="text-align:center;" /></td>
                                                      </tr>
                                                      
                                                      <?php if(($i+1) == count($rangs_arr))
                                                        {
                                                            if(isset($multipliers_arr[$i+1]))
                                                            { 
                                                                $multipliers_val = $multipliers_arr[$i+1];
                                                            }
                                                            echo '<tr><td> > '.$row["max"].'</td><td><input  type="text" id="txt_perfo_achie_rangs_'. $i .'" name="txt_perfo_achie_rangs[]" class="form-control w_unset" required onKeyUp="validate_negative_percentage_onkeyup_common(this);" onBlur="validate_negative_percentage_onblure_common(this);" maxlength="5" value="'. $multipliers_val .'" style="text-align:center;" /></td>
                                                      </tr>';
                                                        } ?>
                                                      
                                              <?php $i++; } ?>
                                            </tbody>
                                          </table>
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
                            <div class="form_info">
                              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $page2[6] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="form_sec clearfix" style="pointer-events:none;">
                      <div class="col-sm-12">
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">The flexibility managers can have while allocated <?php if($rule_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){echo CV_BONUS_SIP_LABEL_NAME;}else{echo CV_BONUS_LABEL_NAME;} ?> </label>
                        </div>
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-1"> <span style="font-weight:bold; font-size:20px;">-</span> </div>
                            <div class="col-sm-5">
                              <input type="text" name="txt_manager_discretionary_decrease" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_decrease"]){echo $rule_dtls["manager_discretionary_decrease"];}else{echo "0";} ?>" maxlength="5" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" />
                            </div>
                            <div class="col-sm-1"> <span style="font-weight:bold; font-size:20px;">+</span> </div>
                            <div class="col-sm-5">
                              <input type="text" name="txt_manager_discretionary_increase" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_increase"]){echo $rule_dtls["manager_discretionary_increase"];}else{echo "0";} ?>" maxlength="5" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" />
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
                              <h4>Budget Allocation</h4>
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
                    <div class="form_sec clearfix" style="pointer-events:none;">
                      <div class="col-sm-12">
                        <div class="col-sm-6 removed_padding">
                          <label for="inputEmail3" class="control-label">Overall Budget Allocation</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-input">
                            <select class="form-control" name="ddl_overall_budget"  id="ddl_overall_budget">
                              <option value="">Select</option>
                              <option value="No limit" <?php if($rule_dtls["overall_budget"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                              <option value="Automated locked" <?php if($rule_dtls["overall_budget"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                              <option value="Automated but x% can exceed" <?php if($rule_dtls["overall_budget"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                              <?php /*?><option value="Manual" <?php if($rule_dtls["overall_budget"]=="Manual"){echo 'selected="selected"';} ?>>Manual</option><?php */?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-3 p_l0">
                        <select class="form-control" required id="ddl_to_currency">
                          <?php foreach($currencys as $currency){?>
                            <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]; ?></option>
                            <?php } ?>
                        </select>               
                    </div>
                    <div class="col-sm-12 removed_padding">
                      <div class="form-group" id="dv_budget_manual" style="display:none;"> </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if(($is_enable_approve_btn) and $rule_dtls["status"]==4){ ?>
            <form action="<?php echo site_url("reject-bonus-rule-approval-request/".$rule_dtls["id"]); ?>" method="post" class="form-inline">
              <?php echo HLP_get_crsf_field();?>
              <div class="row" style="display: none;" id="dv_remark">
                <div class="col-sm-12">
                 <div class="rule-form" style="margin-bottom:10px;">
                  <div class="form_sec clearfix">
                     <div class="col-sm-12">
                      <div class="form-input">
                        <input type="hidden" name="hf_req_for" id="hf_req_for" value="" />
                        <textarea class="form-control" rows="6" name="txt_remark" placeholder="Eneter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px;height: 98px;width:100%;"></textarea>
                      </div>
                     </div>
                   </div> 
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="submit-btn" style="display: none;" id="dv_remrk_submit_btn">
                    <input type="submit" class="btn btn-twitter m-b-sm add-btn ml-mb " value="Submit Reason" id="btnReject" />
                  </div>
                  <div class="submit-btn" id="dv_reject_btn">
                    <input type="button" onclick="show_remark_dv();" class="btn btn-twitter ml-mb add-btn" value="Reject" id="btnReject" />
                  </div>
                  <div class="submit-btn" id="dv_delete_btn">
                    <input type="button" onclick="show_remark_dv_on_delete();" class="btn btn-twitter ml-mb add-btn" value="Delete" id="btn_delete" />
                  </div>
                  <div class="submit-btn"> <a class="anchor_cstm_popup_cls_bonus_rule_appv" href="<?php echo site_url("update-bonus-rule-approvel/".$rule_dtls["id"]); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_bonus_rule_appv', 'Are you sure, You want to approve request?')">
                    <input type="button" class="btn btn-twitter ml-mb add-btn" value="Approve" id="btnSave" />
                    </a> 
                  </div>
                 </div>
                </div>  
            </form>
            <?php } ?>
            
            <?php if($rule_dtls["status"]==3){?>
                    <div class="row">
                      <div class="col-sm-12" id="budget_action_confirm">
                        <a href="<?php echo site_url("send-bonus-rule-for-approval/".$rule_dtls["id"]."/1"); ?>" onclick="return on_confirm_hide_btns();">
                            <input type="button" title="Send For Release" class="btn btn-twitter ml-mb add-btn" value="Send for Approval – HR Driven Process" id="btnSave" />
                        </a> 
                        
                        <a href="<?php echo site_url("send-bonus-rule-for-approval/".$rule_dtls["id"]); ?>" onclick="return on_confirm_hide_btns();">
                            <input title="Send For Approval" type="button" class="btn btn-twitter ml-mb add-btn" value="Send for Approval - Manager Self Service Process" id="btnSave" />
                        </a>
                        
                        <a href="<?php echo site_url("create-bonus-rule/".$rule_dtls["id"]); ?>">
                            <input type="button" class="btn btn-twitter ml-mb add-btn" value="Edit Rule" id="btnSave" />
                        </a>      
               
            <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
$('.multipleSelect').fastselect();

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
                    $(this).val(items[i]);
          //$(this).prop('disabled',true);
                    i++;    
                });
                $("#dv_rating_list_yes").show();

            }
            else
            {
                $("#ddl_performnace_based_hikes").val('no');
                $("#txt_rating1").prop('required',true);
                $("#dv_rating_list_no").show();
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
        $("#txt_rating1").prop('required',true);
        $("#txt_rating1").val(items[i]);
        $("#dv_rating_list_no").show();

    }

}

show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', $("#ddl_to_currency").val()); 
function show_hide_budget_dv(val, to_currency)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
    $("#dv_submit_2_step").hide();

    if(val != '')
    {
        $.post("<?php echo site_url("bonus/get_managers_for_manual_bdgt/1");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
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
            //$(this).val(items[i].toLocaleString());
            //$(this).prop('disabled',true);
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
            //$(this).val(items[i]);
            //$(this).prop('disabled',true);
            $("#dv_x_per_budget_"+ r).html(items[i]);
            calculat_percent_increased_val(2, items[i], (i+1));
            i++;    r++;
          });
          calculat_total_revised_bgt();
        } settabletxtcolor();         
            }
        $("#budget_action_confirm").show();    
          
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
  var val = 0;
  var amtval = 0;
  for(var i=1; i<manager_cnt; i++)
  {
    val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
    amtval += ($("#td_increased_amt_val_"+ i).html().replace(/[^0-9.]/g,''))*1;
  }

  var per = (val/$("#hf_total_target_bonus").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');

  //var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
  val = (($("#th_total_budget_plan").html().replace(/[^0-9.]/g,''))*1) + amtval;  

  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  $("#th_total_budget_manual").html(formated_val);

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}


function calculat_percent_increased_val(typ, val, index_no)
{
    //var cncy= $('#th_total_budget').html();
    //var curncy=cncy.split(' ');
  if(typ==1)
  {
    $("#td_revised_bdgt_"+ index_no).html(Math.round(val).toLocaleString());  
    var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
    $("#td_increased_amt_"+ index_no).html(increased_amt+' %'); 
  }
  else if(typ==2)
  {
    var increased_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100).toFixed(0);
    var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
    $("#td_revised_bdgt_"+ index_no).html(Math.round(revised_bdgt).toLocaleString()); 
    var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
    $("#td_increased_amt_"+ index_no).html(increased_amt+' %'); 
    $("#td_increased_amt_val_"+ index_no).html(increased_bdgt);
  }
}

*/
function addCommas_NIU(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function show_target_bonus_elem()
{
    var target_bonus = $("#ddl_target_bonus").val();
    if(target_bonus == "yes")
    {
        $("#dv_target_bonus_on").show();        
    }
    else
    {
        $("#ddl_target_bonus_on").val("");
        $("#dv_target_bonus_elem").html("");
        $("#dv_target_bonus_elem").hide();
        $("#dv_target_bonus_on").hide();
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
    }  */ 
    
    if(target_bonus == "yes"  || target_bonus == "no")
    {
        $.post("<?php echo site_url("bonus/get_target_bonus_elements/".$rule_dtls["id"]);?>",{elem_for: elem_for, elem_value_type: elem_value_type}, function(data)
        {
            if(data)
            {
                $("#dv_target_bonus_elem").html(data);
                $("#dv_target_bonus_elem").show();
                
                
                /*$("input[name='txt_target_bonus_elem[]']").each( function (key, v)
                {
                    $(this).val(items[i]);
          $(this).prop('disabled',true);
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
              
              /*$("#txt_target_elem_"+elem_arr[0]).prop('disabled',true);
              $("#txt_bl1_weight_"+elem_arr[0]).prop('disabled',true);
              $("#txt_bl2_weight_"+elem_arr[0]).prop('disabled',true);
              $("#txt_bl3_weight_"+elem_arr[0]).prop('disabled',true);
              $("#txt_funct_weight_"+elem_arr[0]).prop('disabled',true);
              $("#txt_sub_funct_weight_"+elem_arr[0]).prop('disabled',true);
              $("#txt_sub_subfunct_weight_"+elem_arr[0]).prop('disabled',true);
              $("#txt_indivi_weight_"+elem_arr[0]).prop('disabled',true);*/
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
            
            /*$("#txt_bl1_weightage").prop('disabled',true);
            $("#txt_bl2_weightage").prop('disabled',true);
            $("#txt_bl3_weightage").prop('disabled',true);
            $("#txt_funct_weightage").prop('disabled',true);
            $("#txt_sub_funct_weightage").prop('disabled',true);
            $("#txt_sub_subfunct_weightage").prop('disabled',true);
            $("#txt_indivi_weightage").prop('disabled',true);*/
            get_achievements_elements();
          }
        }
        $("#tr_btn_put_achievement").hide();
            }
        });
    }
    else
    {
        $("#dv_target_bonus_elem").html("");
        $("#dv_target_bonus_elem").hide();

    }
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
</script> 
<script type="text/javascript">

show_target_bonus_elem();
get_target_bonus_elem();
show_performance_type_elem_dtls('<?php echo $rule_dtls['performance_type'];?>');
<?php /*?>manage_performnace_based_hikes('<?php echo $rule_dtls['performnace_based_hike'];?>');<?php */?>

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

}*/
</script> 
