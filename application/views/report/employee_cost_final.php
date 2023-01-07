<?php header('Access-Control-Allow-Origin: https://alpha.compport.com'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>

<link rel="stylesheet" href="
    <?php echo base_url('assets/chartjs') ?>/css/custom.css">
<style>
    #lg-popup {
        position: fixed;
        top: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 10;
        display: none;
    }
    
    .lg-popup-graph {
        margin: 10%;
        height: 70vh;
        width: 80vw;
        display: none;
        overflow: hidden;
    }


.title_text{display: block;
    width: 100%;
    margin-top: 12px;
    margin-bottom: 5px;}
.title_text span{display:block; color: #000; padding:8px;  background-color:#fff!important; border: 1px solid #c3c3c3 !important; max-height:64px;
    overflow-y:auto; line-height: 18px; box-shadow: 0 1px 6px 0 rgba(32, 33, 36, .1)}
.report_form .form-inline .form-group label.white{color: #131313 !important;}
.form-horizontal .fstMultipleMode{position: absolute; z-index: 9;}
.form-horizontal .fstMultipleMode .fstQueryInputExpanded{font-size:13px;}
.form-horizontal .fstMultipleMode {
    padding-top: 2px !important;}
</style>
<div class="page-breadcrumb">
    <div class="container-fluid compp_fluid">
        <div class="row">
          <div class="col-sm-8 padl0">
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0)"> Analytics/Reports</a>
            </li>
            <li class="active">Employee Cost </li>
        </ol>
    </div>
    <div class="col-sm-4">
    </div>
</div>
</div>
</div>
<div class="page-title">
    <div class="container-fluid compp_fluid">
        <div class="text-center mt-4" style="display: none;">
            <h3 class="text20 textbold" id="dashboardTitle" style="margin-bottom:-8px"><!-- Employee Cost  -->
            <!-- <span style=" float: none;" type="button"class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i
              class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> -->
                </h3>
         
            
        </div>

        <div class="reportss" style="margin-right:-15px; margin-bottom: 8px;margin-top: 8px; background-color:#f5f5f5;padding: 10px 10px 2px 10px;margin-left: -8px;">
          <div class="row">   
             <div class="col-sm-12"> 
              <div class="report_form clearfix">

                <form class="form-horizontal" >
                 <div class="col-sm-2" style="padding-left: 0px; width: 16%;font-size: 20px;font-weight: bold;">
                        Employee Cost for
                    </div>
                    <div class="col-sm-3 padr0 padl0">
                     <div class="form-group my-form attireBlock">
                        <label class="col-sm-3 col-xs-12 control-label removed_padding">Salary Type </label>
                      <!-- <label>Salary Type : </label> -->
                      <div class="col-sm-9 col-xs-12 removed_padding">
                            <select multiple="multiple" name="salary_type"  id="salary_type"   onchange="hide_list('salary_type');"  class="form-control multipleSelect" required="required" multiple="multiple"   >
                            <option value='all'>All</option>
                        </select>
                    </div>
                     <!--  <input type="button" class="btn btn-primary btn-all" id="select_all" name="select_all" value="Select All">   -->
                    </div> 
                   </div>

                    <div class="col-sm-3 padr0">
                     <div class="form-group my-form attireBlock">
                      <label class="col-sm-3 col-xs-12 control-label removed_padding">Currency</label>  
                       <!-- <label>Currency : </label> -->
                       <div class="col-sm-9 col-xs-12 removed_padding">
                        <select name="country_id" class="form-control" id="country_id"></select>
                       </div>
                     </div>
                    </div>
                      
                    <div class="col-sm-3">
                     <div class="form-group my-form attireBlock">
                           <label class="col-sm-3 col-xs-12 control-label removed_padding">Cost Type</label>
                     <!-- <label>Employee Cost Type : </label> -->
                        <div class="col-sm-9 col-xs-12 removed_padding">
                         <select name="data_type" class="form-control" id="data_type">
                            <option value="1">Total Sum</option>
                            <option value="2">Max-Avg-Min</option>
                         </select>
                        </div> 
                    </div>
                   </div>
                    
                   
                     <div class="form-group" id="rules" style="margin-bottom: 0px; ">
                        <input style="width: 9%;  height: 30px; float: left;" type="button" id="btn_update_report" value="Update Report" class="btn btn-primary" />
                     </div>
                </form>
               </div> 
               
          </div>
          <div class="col-sm-12">
              <div class="title_text">
                      <div class="text-left"> <span id="lable_info"></span></div>
                 </div>
             </div>
          </div>

             
        </div>
    <div class="filters mt-4" >
                <div class="row align-items-center" style="margin-top: -8px;">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-1 filter-text" style="max-width: 100px">Filters:</div>
                            <div class="col-md-9" id="appliedFilters"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
                        <button id="exportPpts" class="btn btn-default">
                            <img src="<?php echo base_url('assets/reports') ?>/icons/ppt-icon.png" alt="download ppt">
                        </button>
                        <button id="exportPdf" class="btn btn-default">
                            <img src="
                                <?php echo base_url('assets/reports') ?>/icons/PDF-Icon.png" alt="download pdf">
                            </button>
                            <button id="exportCsv" class="btn btn-default">
                                <img src="
                                    <?php echo base_url('assets/reports') ?>/icons/CSV-Icon.png" alt="download csv">
                                </button>
                            </div>
                        </div>
                    </div>
        <div class="row justify-content-center mt-3" id="chartNode">
            <div class="col-md-12">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="country-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="city-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="businessunit-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="grade-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="level-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="function-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                                      <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="performance_rating-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="gender-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-4"></div>
    </div>
</div>
<div id="lg-popup">
    <div id="country-container-lg" class="lg-popup-graph"></div>
    <div id="city-container-lg" class="lg-popup-graph"></div>
    <div id="level-container-lg" class="lg-popup-graph"></div>
    <div id="grade-container-lg" class="lg-popup-graph"></div>

    <div id="function-container-lg" class="lg-popup-graph"></div>
    <div id="businessunit-container-lg" class="lg-popup-graph"></div>
    <div id="performance_rating-container-lg" class="lg-popup-graph"></div>
    <div id="gender-container-lg" class="lg-popup-graph"></div>
</div>
<script src="<?php echo base_url('assets/chartjs') ?>/js/highchart.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/exporting.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/dom-to-image.min.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/jspdf.full.min.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/xlsx.min.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/jszip.min.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/pptxgen.min.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/lodash.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/nodejs_support.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/script_employee_cost_final.js"></script>
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
<script>
    $('.multipleSelect').fastselect();
    $(document).ready(function() {
        $('#select_all').click(function() {
            
            $('#salary_type option').prop('selected', true);
        });
        var nodejs_api_helper = new NodeJs_API_Helper('<?php echo $_COOKIE['Acc3ssTo73n']; ?>');    

        // ensure all charts use the class  highcharts_on_this_page 
        var allChartsOnThePage = $(".highcharts_on_this_page");

        var exportToPDFBtn = $('#exportPdf');
        var exportToExcelBtn = $('#exportCsv');
        var filterDiv = $('#appliedFilters');
        var exportToPptsBtn = $('#exportPpts');

        getSalaryType(nodejs_api_helper);
        getCountry(nodejs_api_helper);
        $("#lable_info").html("Employee Cost refers to : Base/Basic");
        
        initialize(nodejs_api_helper.base_url + '/employeesalary/current_base_salary/0/1', nodejs_api_helper, allChartsOnThePage, filterDiv, exportToPDFBtn, exportToExcelBtn, exportToPptsBtn); //for default year -- currently one
        

            
        $("#btn_update_report").click(function() {
       // alert($('#salary_type').val());
        if (!$("#salary_type option:selected").length){
                custom_alert_popup("Please select a Salary type and then proceed!");
                $('#salary_type').focus();

                return false;
            }else{
            var salary_type_text = $('#salary_type').find('option:selected').map(function() {
                return $(this).text();});
            $("#lable_info").html("Employee Cost refers to : "+salary_type_text.get());
            
            initialize(nodejs_api_helper.base_url + '/employeesalary/' + $("#salary_type").val().join("+") + "/" + $("#country_id").find(":selected").val() + "/" + $("#data_type").find(":selected").val(), nodejs_api_helper, allChartsOnThePage, filterDiv, exportToPDFBtn, exportToExcelBtn);
            //alert($("#salary_type").val().join("+"));
        }});
        
    });
</script>

<style type="text/css">
 .fstMultipleMode {
    display: block;
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
    margin-left:3px !important;
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
.fstMultipleMode.fstActive .fstResults{position: absolute !important;}  
</style>