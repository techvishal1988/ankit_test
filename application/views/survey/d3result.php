<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/chartjs') ?>/css/custom.css">
<style>
.fstMultipleMode {
	display: block;
}
.fstMultipleMode .fstControls {
	width:100% !important;
}
.my-form {
background:#<?php echo $this->session->userdata("company_light_color_ses");
?>!important;
}
<!--
.fstElement:hover {
box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses");
?>!important;
-->
<!--
shumsul--> border: 1px solid #<?php echo $this->session->userdata("company_color_ses");
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
.control-label {
	line-height:42px;
	font-size: 11.25px;
 <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>  background-color:#<?php echo $this->session->userdata("company_light_color_ses");
?> !important;
	color: #000;
	margin-bottom:10px;
}
.salary_rt_ftr .form_sec {
	background-color: #f2f2f2;
	margin-bottom: 30px;
	margin-top: 10px;
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
</style>

<!-- Bootstrap core CSS -->

<link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
<style>
.bg {
 // background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
	background-size:cover;
}
/*Start shumsul*/
    .page-inner {
	padding:0 0 40px;
 background: url(<?php echo $this->session->userdata('company_bg_img_url_ses');
?>) 0 0 no-repeat !important;
	background-size: cover !important;
}
/*End shumsul*/


.piechart {
	position: relative;
	display: block;
	margin: 0 auto;
}
.centerLabel {
	position: absolute;
	margin-left: 477px;
	text-align: center;
	margin-top: -270px;
}
@media(max-width:640px) {
 .centerLabel {
 position: absolute;
 margin-left: 124px;
 text-align: center;
 margin-top: -270px;
 font-size: 15px;
}
#totalsal {
font-size:10px;
}
}
.fstMultipleMode .fstQueryInputExpanded{width: 78% !important;}
.card {margin-top: 10px !important;}
</style>

<link rel="stylesheet" href="<?php echo base_url('assets/chartjs') ?>/css/custom.css">
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo base_url('survey') ?>"> Survey</a></li>
        <li class="active">Result</li>
    </ol>
</div>
<div id="popoverlay" class=" popoverlay"></div>
<div class="bg">
  <div class="container">
    <?php 
    $tooltip=getToolTip('survey-result');
    $val = json_decode($tooltip[0]->step);
    ?>
  
    <div class="row">
        <h3 style="background: #f5f5f5; padding-top: 10px; padding-bottom: 10px; margin-bottom: 0px; text-align: center; margin-left: 5px; margin-right: 10px;" >Survey Results for <?=$surveyinfo[0]['survey_name'];?> <span style=" float: none;" type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title="<?php echo $val[0] ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></h3>
        <div class="col-md-1 col-sm-1 col-lg-1 hide">
             
        <div class="salary_rt_ftr">
          <div class="form_sec clearfix">
            <form class="form-horizontal mob_no_lbl_bg" method="post" action="">
            	<?php echo HLP_get_crsf_field();?>
              <div class="row">
                <input style="margin-bottom:15px;" type="submit" value="Select All" class="btn btn-primary">

                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Country</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                      <input type="hidden" name="survey_id" id="survey_id" value="<?php echo  $survey[0]['survey_id'] ?>" />
                    <input type="hidden" name="userids" id="userids" value="<?php echo $UserIds ?>" />
                    <div class="">
                      <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">City</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_city" onchange="hide_list('ddl_city');" name="ddl_city[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Business Level 1</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Business Level 2</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Business Level 3</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Function</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_function" onchange="hide_list('ddl_function');" name="ddl_function[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Sub Function</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_sub_function" onchange="hide_list('ddl_sub_function');" name="ddl_sub_function[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Designation</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Grade</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Level</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Education</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_education" onchange="hide_list('ddl_education');" name="ddl_education[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Talent</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_critical_talent" onchange="hide_list('ddl_critical_talent');" name="ddl_critical_talent[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Position</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_critical_position" onchange="hide_list('ddl_critical_position');" name="ddl_critical_position[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Special Category</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_cspecial_category" onchange="hide_list('ddl_cspecial_category');" name="ddl_special_category[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> ><?php echo $row["name"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Tenure in company</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_tenure_company" onchange="hide_list('ddl_tenure_company');" name="ddl_tenure_company[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $i; ?>" <?php echo $selected;?> ><?php echo $i; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group my-form attireBlock">
                  <label class="col-sm-4 col-xs-12 control-label removed_padding">Tenure in Role</label>
                  <div class="col-sm-8 col-xs-12 removed_padding">
                    <div class="">
                      <select id="ddl_tenure_role" onchange="hide_list('ddl_tenure_role');" name="ddl_tenure_role[]" class="form-control multipleSelect" multiple="multiple">
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
                        <option  value="<?php echo $i; ?>" <?php echo $selected;?> ><?php echo $i; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="sub-btnn text-right">
                  <input type="submit" id="btnAdd" value="View Report" class="btn btn-primary" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-lg-12">
       <div class="">
   
    <div class="filters mt-4  mybgcls">
        <div class=" row align-items-center" style="margin-left:0;margin-right: 5px;margin-top: 10px;">
            <div class="col-md-9">
                <div class="">
                    <div class="col" style="max-width: 100px">Filters:</div>
                    <div class="col" id="appliedFilters"></div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <button id="exportPdf" class="btn btn-default">
                    <img src="<?php echo base_url('assets/reports') ?>/icons/PDF-Icon.png" alt="download pdf">
                </button>
                <!--<button id="exportCsv" class="btn btn-default">-->
                    <a href="<?php echo base_url('survey/get_survey_results_rpt/'.$surveyinfo[0]['survey_id']); ?>"><img src="<?php echo base_url('assets/reports') ?>/icons/CSV-Icon.png" alt="download csv"></a>
                <!--</button>-->
            </div>
        </div>
    </div>
    <div>
        <div class="mt-3" id="chartNode"></div>
    </div>
    <div class="pb-4"></div>
</div>
      </div>
    </div>
  </div>
</div>
<div class="loader" style="display: block">
    <img src="<?php echo base_url() ?>assets/loading.gif" alt="">
</div>

<?php
  $this->load->view('common/common-js');
?>

<script src="<?php echo base_url() ?>assets/chartjs/js/script-questions.js"></script>
<script>
    $(document).ready(function() {
        var users='';
        <?php if($UserIds!='') { ?>
            users='<?php echo str_replace(',','_',$UserIds) ?>';
        <?php } ?>
        var ReportURL='<?php echo base_url() ?>api/survey/SurveyResult/<?php echo end($this->uri->segment_array()) ?>/'+users;
        //var ReportURL='<?php echo base_url() ?>api/graph/SurveyResult/<?php echo end($this->uri->segment_array()) ?>/'+users;
        App(ReportURL);

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
    })
</script>

<script>
   $('.multipleSelect').fastselect();
</script> 
<script>

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
</script>