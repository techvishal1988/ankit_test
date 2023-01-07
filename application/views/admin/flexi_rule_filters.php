<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
.fstMultipleMode {
	display: block;
}
.fstMultipleMode .fstControls {
	width:25.7em;
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
/***added to center align the form head text****/
</style>

<div class="page-breadcrumb">
  <ol class="breadcrumb container">
   
    
    <li class="active"><?php echo $title; ?></li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <?php 
    echo $this->session->flashdata('message'); 
	echo $msg;    
	$val=json_decode($tooltip[0]->step);    
?>
  <div class="salary_rt_ftr">
    
    <div class="form_head clearfix">
      <div class="col-sm-12">
        <ul>
          <li>
            <div class="form_tittle">
              <h4>Select Target Population For Flexi Plan</h4>
            </div>
          </li>
          <li>
            <div class="form_info">
              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[1] ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
            </div>
          </li>
          <li>
            <form class="form-horizontal" method="post" action="">
              <?php echo HLP_get_crsf_field();?>
              <input type="hidden" name="hf_select_all_filters" value="1" />
              <input type="submit" value="Select All" class="btn btn-primary"/>
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
    <div class="form_sec clearfix"> 
		<form class="form-horizontal mob_no_lbl_bg frm_cstm_popup_cls_flexi_filter" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_flexi_filter')">
			<?php echo HLP_get_crsf_field();?>
           
			      <div class="row">
              
              <div class="col-sm-6">
                  <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Name</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <input id="ddl_name" onblur="hide_list('ddl_name')" name="ddl_name" class="form-control" value="<?= $rule_dtls['flexi_plan_name']?$rule_dtls['flexi_plan_name']:'';  ?>" placeholder=" FLEXI PLAN NAME" required="required">
                        </div>
                      </div>
                    </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Select Flexi Plan Type</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_type" onchange="change_type(this.value);hide_list('ddl_type');" name="ddl_type" class="form-control" required="required">
                            <option  value="grade" <?php 
                            if(isset($rule_dtls['flexi_type'])){ 
                              if($rule_dtls['flexi_type']=='grade'){ echo "selected"; } 
                          } ?> >Grade</option>
                            <option  value="level" <?php 
                            if(isset($rule_dtls['flexi_type'])){ 
                              if($rule_dtls['flexi_type']=='level'){ echo "selected"; } 
                          } ?>>Level</option>
                          </select>
                        </div>
                      </div>
                    </div>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                  <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">People Managers</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
               
            <div class="">
              <?php //echo $rule_dtls['managers']; ?>
             <select id="survey_for"  name="survey_for[]"  class="form-control multipleSelect" required="required" multiple="multiple" onchange="hide_list('survey_for')" >
                 <?php
                        if($rule_dtls['managers']=='manager')
                        {
                            $manager='selected';
                            $both='';
                        }
                        if($rule_dtls['managers']=='employee')
                        {
                            $employee='selected';
                             $both='';
                        }
                        if($rule_dtls['managers']=='both')
                        {
                          $manager='';
                          $manager='';
                            $both='selected';
                        }
                 ?>  
                 <option  value="manager" <?php echo $manager ?>  <?php echo $select_all; ?> >People Managers</option>
                   <option  value="employee" <?php echo $employee ?>  <?php echo $select_all; ?> >Individual Contributor</option>
                   <option  value="both" <?php echo $both ?> <?php echo $select_all; ?> >Both</option>
                   
                </select>
              </div>
           </div>  
        </div>
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Country</label>
                      <?php //print_r($rule_dtls['country']); ?>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <option  value="all">All</option>
                            <?php foreach($country_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['country']) and in_array($row["id"], $rule_dtls['country'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($city_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['city']) and in_array($row["id"], $rule_dtls['city'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($bussiness_level_1_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level1']) and in_array($row["id"], $rule_dtls['business_level1'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($bussiness_level_2_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level2']) and in_array($row["id"], $rule_dtls['business_level2'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($bussiness_level_3_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level3']) and in_array($row["id"], $rule_dtls['business_level3'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($function_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['functions']) and in_array($row["id"], $rule_dtls['functions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($sub_function_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_functions']) and in_array($row["id"], $rule_dtls['sub_functions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                                    <option  value="all">All</option>


                                    <?php foreach($sub_subfunction_list as $row){?>
                                    <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_subfunctions']) and in_array($row["id"], $rule_dtls['sub_subfunctions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                    <?php } ?>
                                </select>
                              </div>
                           </div>  
                        </div>
                    <?php } /* }  */ ?>
                                
                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Designation</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                            <option  value="all">All</option>
                            <?php foreach($designation_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['designations']) and in_array($row["id"], $rule_dtls['designations'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                </div>



                <div class="col-sm-6">
                  

                    <div class="form-group my-form attireBlock label_grade" <?php 
                            if(isset($rule_dtls['flexi_type'])){ 
                              if($rule_dtls['flexi_type']!='grade'){ echo 'style="display: none;"'; } 
                          } ?>>
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Grade</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" multiple="multiple">
                            <option  value="all">All</option>
                            <?php foreach($grade_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['grades']) and in_array($row["id"], $rule_dtls['grades'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group my-form attireBlock label_type" <?php 
                            if(isset($rule_dtls['flexi_type'])){ 
                              if($rule_dtls['flexi_type']!='level'){ echo 'style="display: none;"'; } 
                          } else{ echo 'style="display: none;"';}?> >
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Level</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" multiple="multiple">
                            <option  value="all">All</option>
                            <?php foreach($level_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['levels']) and in_array($row["id"], $rule_dtls['levels'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option  value="all">All</option>
                            <?php foreach($special_category_list as $row){?>
                            <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['special_category']) and in_array($row["id"], $rule_dtls['special_category'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                   
                                       
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="sub-btnn text-right" id="dv_next" <?php if($select_all != ""){echo 'style="display:none;"';}elseif(!isset($rule_dtls)){echo 'style="display:none;"';} ?>>
                          <input type="submit" id="btnAdd" name="btn_next" value="Next" class="btn btn-primary" />
                        </div>
                    <div class="sub-btnn text-right" id="dv_confirm_selection" <?php if($select_all != ""){echo '';}elseif(isset($rule_dtls)){echo 'style="display:none;"';} ?>>
                      <input type="submit" name="btn_confirm_selection" value="Confirm Selection" class="btn btn-primary" />
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>

<script>

  function change_type(val){
    $('.label_grade').hide();
    $('.label_type').hide();
    if(val == 'grade'){
      $('.label_grade').show();
    }else{
      $('.label_type').show();
    }
  }
   	$('.multipleSelect').fastselect();
  
	$(document).ready(function()
	{
		$( "#txt_cutoff_dt" ).datepicker({ 
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
</script> 
<script>
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
