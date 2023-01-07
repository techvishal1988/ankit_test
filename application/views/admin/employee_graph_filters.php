<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>

<style>


.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls {width:25.7em; }

.my-form{background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
<!--.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;--> <!--shumsul-->
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
	margin-bottom: 30px;
	display: block;
	width: 100%;
	padding:20px;
	border-bottom-left-radius: 6px;
	border-bottom-right-radius: 6px;
}
.head h4{ margin:0px;}
.padd{ padding:10px 20px 0px 20px !important; }
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">    
         <li>General Settings</li>    
        <li class="active"><?php echo $title; ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<?php 
    echo $this->session->flashdata('message'); echo $msg;
    $tooltip=getToolTip('employee_graph_filters');
    $val=json_decode($tooltip[0]->step); 
    
?>
   <div class="salary_rt_ftr">
   
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
                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[0];?>"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
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
    
  <form class="form-horizontal" method="post" action="">
  	<?php echo HLP_get_crsf_field();?>
	<div class="row">
<?php //echo $survey[0]['country'];echo '<pre />'; print_r($survey); ?>
	
    	<div class="col-sm-6">
            <div class="form-group my-form attireBlock">
               <label class="col-sm-4 control-label removed_padding">Graph For</label>
               <div class="col-sm-8 removed_padding">
                   
                <div class="">
                 <select id="survey_for"  name="survey_for"  class="form-control multipleSelect" required="required" multiple="multiple">
                     <?php
                            if($survey[0]['graph_for']=='manager')
                            {
                                $manager='selected';
                            }
                            if($survey[0]['graph_for']=='employee')
                            {
                                $employee='selected';
                            }
                            if($survey[0]['graph_for']=='both')
                            {
                                $both='selected';
                            }
                     ?>  
                     <option  value="manager" <?php echo $manager ?>  <?php echo $select_all; ?> >Manager</option>
                       <option  value="employee" <?php echo $employee ?>  <?php echo $select_all; ?> >Employee</option>
                       <option  value="both" <?php echo $both ?> <?php echo $select_all; ?> >Both</option>
                       
                    </select>
                  </div>
               </div>  
            </div>
            <div class="form-group my-form attireBlock">
               <label class="col-sm-4 control-label removed_padding">Country</label>
               <div class="col-sm-8 removed_padding">
                   <input type="hidden" name="survey_id" value="<?php echo  $survey[0]['Esg_id'] ?>" />
                <div class="">
                 <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                        <option  value="all">All</option>
                        <?php foreach($country_list as $row){
                            
                            if(in_array($row["id"],explode(',',$survey[0]['country'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                        <?php foreach($city_list as $row){
                             if(in_array($row["id"],explode(',',$survey[0]['city'])))
                                {
                                    $selected='selected';
                                }
                                else {
                                    $selected='';
                                }
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } ?>
                    </select>
                  </div>
               </div>
            </div>
            
            <div class="form-group my-form attireBlock">
               <label class="col-sm-4 control-label removed_padding">Business Level 1</label>
               <div class="col-sm-8 removed_padding">
                <div class="">
                 <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" required="required" multiple="multiple">
                        <option  value="all">All</option>
                        <?php foreach($bussiness_level_1_list as $row){
                            if(in_array($row["id"],explode(',',$survey[0]['business_level1'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } ?>
                    </select>
                  </div>
               </div>  
            </div>  

            <div class="form-group my-form attireBlock">
               <label class="col-sm-4 control-label removed_padding">Business Level 2</label>
               <div class="col-sm-8 removed_padding">
                <div class="">
                 <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" required="required" multiple="multiple">
                        <option  value="all">All</option>
                        <?php foreach($bussiness_level_2_list as $row){ 
                            if(in_array($row["id"],explode(',',$survey[0]['business_level2'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } ?>
                    </select>
                  </div>
               </div>  
            </div> 

            <div class="form-group my-form attireBlock">
               <label class="col-sm-4 control-label removed_padding">Business Level 3</label>
               <div class="col-sm-8 removed_padding">
                <div class="">
                 <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" required="required" multiple="multiple">
                        <option  value="all">All</option>
                        <?php foreach($bussiness_level_3_list as $row){
                            if(in_array($row["id"],explode(',',$survey[0]['business_level3'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                      <?php foreach($function_list as $row){
                          if(in_array($row["id"],explode(',',$survey[0]['functions'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
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
                        <?php foreach($sub_function_list as $row){
                            if(in_array($row["id"],explode(',',$survey[0]['sub_functions'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
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
                        <?php foreach($designation_list as $row){ 
                            if(in_array($row["id"],explode(',',$survey[0]['designations'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }   
                            ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
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
                      <?php foreach($grade_list as $row){
                          if(in_array($row["id"],explode(',',$survey[0]['grades'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                      <?php foreach($level_list as $row){
                           if(in_array($row["id"],explode(',',$survey[0]['levels'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
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
                      <?php foreach($education_list as $row){
                           if(in_array($row["id"],explode(',',$survey[0]['educations'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                      <?php foreach($critical_talent_list as $row){
                           if(in_array($row["id"],explode(',',$survey[0]['critical_talents'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
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
                      <?php foreach($critical_position_list as $row){
                          if(in_array($row["id"],explode(',',$survey[0]['critical_positions'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                      <?php foreach($special_category_list as $row){
                          if(in_array($row["id"],explode(',',$survey[0]['special_category'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                      <?php for($i=0; $i<=35; $i++){
                          if(in_array($row["id"],explode(',',$survey[0]['tenure_company'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $i; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $i; ?></option>
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
                      <?php for($i=0; $i<=35; $i++){
                           if(in_array($row["id"],explode(',',$survey[0]['tenure_roles'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            } 
                            ?>
                      <option  value="<?php echo $i; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                      <?php } ?>
                  </select>
                </div>
             </div>  
          </div> 
           
        <div class="sub-btnn text-right">            
            <div class="sub-btnn text-right" id="dv_next" <?php if($select_all != ""){}elseif(!isset($survey[0])){echo 'style="display:none;"';} ?>>
            	<input type="submit" id="btnAdd" name="btn_next" value="Continue" class="btn btn-primary" />
            </div>
            <div class="sub-btnn text-right" id="dv_confirm_selection" <?php if(isset($survey[0]) or $select_all != ""){echo 'style="display:none;"';} ?>>
            	<input type="submit" name="btn_confirm_selection" value="Confirm Selection" class="btn btn-primary" />
            </div>
        </div>

        </div>
    </div>
  </form> 
 </div>
 </div>
</div>

<script>
   $('.multipleSelect').fastselect();
   $(document).ready(function(){
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