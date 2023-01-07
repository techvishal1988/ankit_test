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
    <li><a href="<?php echo site_url("sip-rule-list/".$rule_dtls['performance_cycle_id']); ?>">Rule List</a></li>
    <li class="active"><?php echo CV_BONUS_SIP_LABEL_NAME; ?> Rule Detail</li>
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
                      <ul>
                        <li>
                          <div class="form_tittle">
                            <h4 style="cursor:pointer; pointer-events: none;" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="show_filters();"><i style="display: none;" class="more-less glyphicon glyphicon-minus"></i> employee segments to be covered</h4>
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
                      <!-- <form class="form-horizontal" method="post" action=""> -->
                      <div class="form-horizontal">


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
                      </div>
                      <!-- </form> -->
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
                          <input type="text" name="txt_rule_name" value="<?php echo $rule_dtls["sip_rule_name"]; ?>" class="form-control" required="required" maxlength="100" />
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
                              <?php /*?><div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">Range</label>
                        </div>
                        </div><?php */?>
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
                                          <div class="col-sm-2 plft0" id="dv_btn_dlt_fixed_percentage"><button type="button" class="btn btnp btn-danger btn-w60" onclick="removeFixedPerRow(this);">DELETE</button></div>
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
                                <div id="add_fixed_percentage">                                  
                                </div>
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
                    <div class="form_sec clearfix" style="pointer-events:none;">
                      <div class="col-sm-12">                          
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
                          
                          <div class="target_sip_elem" id="dv_target_sip_elem" style="display:none;"></div>
                        </div>
						
					  <div class="col-sm-12" style="margin-top:10px;">
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
					  <div class="col-sm-12">
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


			<div style="pointer-events:none;">
            <?php $this->load->view('sip/sip_multiplier_panel', array("is_loaded_from_summary_page"=>1)); ?>    
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
            <form action="<?php echo site_url("reject-sip-rule-approval-request/".$rule_dtls["id"]); ?>" method="get" class="form-inline" id="reject_form_submission">
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
                    <input type="submit" class="btn btn-twitter m-b-sm add-btn ml-mb "  value="Submit Reason" id="btnReject" />
                    <!-- onclick="submitForm(this.form);" -->
                  </div>
                  <div class="submit-btn" id="dv_reject_btn">
                    <input type="button" onclick="show_remark_dv();" class="btn btn-twitter ml-mb add-btn" value="Reject" id="btnReject" />
                  </div>
                  <div class="submit-btn" id="dv_delete_btn">
                    <input type="button" onclick="show_remark_dv_on_delete();" class="btn btn-twitter ml-mb add-btn" value="Delete" id="btn_delete" />
                  </div>
                  <div class="submit-btn"> <a class="anchor_cstm_popup_cls_sip_rule_appv" href="<?php echo site_url("update-sip-rule-approvel/".$rule_dtls["id"]); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sip_rule_appv', 'Are you sure, You want to approve request?')">
                    <input type="button" class="btn btn-twitter ml-mb add-btn" value="Approve" id="btnSave" />
                    </a>
                  </div>
                 </div>
                </div>
            </form>
            <?php } ?>

            <?php if($rule_dtls["status"]==3){?>
                    <div class="row">
                      <div class="col-sm-12">
                        <a class="anchor_cstm_popup_cls_sip_hr" href="<?php echo site_url("send-sip-rule-for-approval/".$rule_dtls["id"]."/1"); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sip_hr','<?php echo CV_CONFIRMATION_RELEASED_MESSAGE;?>')">
                            <input type="button" title="Send For Release" class="btn btn-twitter ml-mb add-btn" value="Send for Approval – HR Driven Process" id="btnSave" />
                        </a>

                        <a class="anchor_cstm_popup_cls_sip_mana" href="<?php echo site_url("send-sip-rule-for-approval/".$rule_dtls["id"]); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sip_mana','<?php echo CV_CONFIRMATION_APRROVED_MESSAGE;?>')">
                            <input title="Send For Approval" type="button" class="btn btn-twitter ml-mb add-btn" value="Send for Approval - Manager Self Service Process" id="btnSave" />
                        </a>

                        <a href="<?php echo site_url("create-sip-rule/".$rule_dtls["id"]); ?>">
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
}*/




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

show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', $("#ddl_to_currency").val());
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

  var per = (val/$("#hf_total_target_sip").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');
  //piy@18Dec2019
  val = (($("#th_total_budget_plan").html().replace(/[^0-9.]/g,''))*1) + amtval;  
  //var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  $("#th_total_budget_manual").html(formated_val);

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}
*/
</script>
<script type="text/javascript">
function show_filters()
{
  $('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
}
show_target_sip_elem();
get_target_sip_elem();
</script>
