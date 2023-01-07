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
	font-size: 12px;
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
.head h4{ margin:0px;}
.padd{ padding:10px 20px 0px 20px !important; }
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo base_url("performance-cycle"); ?>">Comp Plans</a></li>
        <li> <?php $l=explode('-',$this->uri->segment(1)); ?><a href="<?php echo base_url("salary-rule-list/".$performance_cycle_dtls['id']); ?>">Salary Rules</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <?php echo $this->session->flashdata('message'); ?>  
    <div class="form_head clearfix">
        <div class="col-sm-12">
            <ul>
                <li>
                    <div class="form_tittle">
                        <h4>Salary Filter</h4>
                    </div>
                </li>
                <!-- <li>
                    <div class="form_info">
                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[1] ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>

    <div class="form_sec clearfix">
    
    <form class="form-horizontal mob_no_lbl_bg" method="post">
  	    <?php echo HLP_get_crsf_field();?>
	    <div class="row">
    	    <div class="col-sm-6">
                <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Country</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                            <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="all">All</option>
                                <?php foreach($country_list as $row){ 
                                    if(in_array($row['id'],$rule_dtls['country'])){?>
                                    <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['country']) and in_array($row["id"], $rule_dtls['country'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } } ?>
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
                        <?php foreach($city_list as $row){ 
                            if(in_array($row['id'],$rule_dtls['city'])){ ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['city']) and in_array($row["id"], $rule_dtls['city'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } }?>
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
                        <?php foreach($bussiness_level_1_list as $row){
                            if(in_array($row['id'],$rule_dtls['business_level1'])){ ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level1']) and in_array($row["id"], $rule_dtls['business_level1'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } } ?>
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
                        <?php foreach($bussiness_level_2_list as $row){ 
                            if(in_array($row['id'],$rule_dtls['business_level2'])){?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level2']) and in_array($row["id"], $rule_dtls['business_level2'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } } ?>
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
                        <?php foreach($bussiness_level_3_list as $row){
                            if(in_array($row['id'],$rule_dtls['business_level3'])){?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['business_level3']) and in_array($row["id"], $rule_dtls['business_level3'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } } ?>
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
                      <?php foreach($function_list as $row){ 
                          if(in_array($row['id'],$rule_dtls['functions'])){?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['functions']) and in_array($row["id"], $rule_dtls['functions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php } }?>
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
                        <?php foreach($sub_function_list as $row){ 
                            if(in_array($row['id'],$rule_dtls['sub_functions'])){?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['sub_functions']) and in_array($row["id"], $rule_dtls['sub_functions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } }?>
                    </select>
                  </div>
               </div>  
            </div>
                                    
            <div class="form-group my-form attireBlock">
               <label class="col-sm-4 col-xs-12 control-label removed_padding">Designation</label>
               <div class="col-sm-8 col-xs-12 removed_padding">
                <div class="">
                   <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                        <option  value="all">All</option>
                        <?php foreach($designation_list as $row){
                            if(in_array($row['id'],$rule_dtls['designations'])){?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['designations']) and in_array($row["id"], $rule_dtls['designations'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                        <?php } } ?>
                    </select>
                  </div>
               </div>  
            </div>                  
                        
                                 
        </div>
        <div class="col-sm-6">
           
          <div class="form-group my-form attireBlock">
             <label class="col-sm-4 col-xs-12 control-label removed_padding">Grade</label>
             <div class="col-sm-8 col-xs-12 removed_padding">
              <div class="">
               <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                      <option  value="all">All</option>
                      <?php foreach($grade_list as $row){
                          if(in_array($row['id'],$rule_dtls['grades'])){
                          ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['grades']) and in_array($row["id"], $rule_dtls['grades'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php } } ?>
                  </select>
                </div>
             </div>  
          </div> 
          
          <div class="form-group my-form attireBlock">
             <label class="col-sm-4 col-xs-12 control-label removed_padding">Level</label>
             <div class="col-sm-8 col-xs-12 removed_padding">
              <div class="">
               <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" required="required" multiple="multiple">
                      <option  value="all">All</option>
                      <?php foreach($level_list as $row){ 
                          if(in_array($row['id'],$rule_dtls['levels'])){?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['levels']) and in_array($row["id"], $rule_dtls['levels'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php } } ?>
                  </select>
                </div>
             </div>  
          </div>
           
          <div class="form-group my-form attireBlock">
             <label class="col-sm-4 col-xs-12 control-label removed_padding">Education</label>
             <div class="col-sm-8 col-xs-12 removed_padding">
              <div class="">
                 <select id="ddl_education" onchange="hide_list('ddl_education');" name="ddl_education[]" class="form-control multipleSelect" required="required" multiple="multiple">
                      <option  value="all">All</option>
                      <?php foreach($education_list as $row){
                          if(in_array($row['id'],$rule_dtls['educations'])){
                          ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['educations']) and in_array($row["id"], $rule_dtls['educations'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php } }?>
                  </select>
                </div>
             </div>  
          </div>

          <div class="form-group my-form attireBlock">
             <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Talent</label>
             <div class="col-sm-8 col-xs-12 removed_padding">
              <div class="">
                <select id="ddl_critical_talent" onchange="hide_list('ddl_critical_talent');" name="ddl_critical_talent[]" class="form-control multipleSelect" required="required" multiple="multiple">
                      <option  value="all">All</option>
                      <?php foreach($critical_talent_list as $row){ 
                                if(in_array($row['id'],$rule_dtls['critical_talents'])){
                          ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['critical_talents']) and in_array($row["id"], $rule_dtls['critical_talents'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php     }
                            } ?>
                  </select>
                </div>
             </div>  
          </div>

          <div class="form-group my-form attireBlock">
             <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Position</label>
             <div class="col-sm-8 col-xs-12 removed_padding">
              <div class="">
                <select id="ddl_critical_position" onchange="hide_list('ddl_critical_position');" name="ddl_critical_position[]" class="form-control multipleSelect" required="required" multiple="multiple">
                      <option  value="all">All</option>
                      <?php foreach($critical_position_list as $row){
                                if(in_array($row['id'],$rule_dtls['critical_positions'])){
                        ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['critical_positions']) and in_array($row["id"], $rule_dtls['critical_positions'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php } }?>
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
                      <?php foreach($special_category_list as $row){
                            if(in_array($row['id'],$rule_dtls['special_category'])){      
                        ?>
                      <option  value="<?php echo $row["id"]; ?>" <?php if(isset($rule_dtls['special_category']) and in_array($row["id"], $rule_dtls['special_category'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                      <?php }
                      } ?>
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
                      <?php for($i=0; $i<=35; $i++){ 
                            if(in_array($i,$rule_dtls['tenure_company'])){
                        ?>
                      <option  value="<?php echo $i; ?>" <?php if(isset($rule_dtls['tenure_company']) and in_array($i, $rule_dtls['tenure_company'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                      <?php } }?>
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
                      <?php for($i=0; $i<=35; $i++){ 
                                if(in_array($i,$rule_dtls['tenure_roles'])){
                        ?>
                      <option  value="<?php echo $i; ?>" <?php if(isset($rule_dtls['tenure_roles']) and in_array($i, $rule_dtls['tenure_roles'])){echo 'selected="selected"';}?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                      <?php } }?>
                  </select>
                </div>
             </div>  
          </div> 
          
          <div class="form-group my-form attireBlock">
             <label class="col-sm-4 col-xs-12 control-label removed_padding">Cutoff Date</label>
             <div class="col-sm-8 col-xs-12 removed_padding">
              <div class="">
                  <input readonly="true" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($rule_dtls["cutoff_date"]) and $rule_dtls["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($rule_dtls["cutoff_date"]));} ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)">
                </div>
             </div>  
          </div>
          

          <div class="sub-btnn text-right">
            <input type="submit" id="btnAdd" value="Search" class="btn btn-primary" />
          </div> 

        </div>
    </div>
  </form> 
 </div>
 </div>
</div>

<script>
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
$('form').submit(function()
{
  setTimeout(function(){ $("#loading").css('display','none'); }, 3000);
});

</script>