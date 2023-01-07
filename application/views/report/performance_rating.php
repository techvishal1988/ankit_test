<div class="page-breadcrumb">
   <div class="container-fluid compp_fluid"> 
    <div class="row">
       <div class="col-sm-8">
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"> Analytics/Reports</a></li>
            <li class="active">Performance Rating Distribution Report</li>
        </ol>
       </div>
       <div class="col-sm-4"></div>
    </div>
   </div>
</div>
<div class="page-title">
<link rel="stylesheet" href="<?php echo base_url('assets/chartjs') ?>/css/custom.css">
<div class="loader">
    <img src="<?php echo base_url('assets/reports') ?>/loading.gif" alt="">
</div>

<div class="container-fluid compp_fluid">
    <div class="text-center mt-4">
        <?php
        $tooltip=getToolTip('headcount-report');
              $val=json_decode($tooltip[0]->step);
        ?>
        <h3 class="text20 textbold" style="margin-bottom:-8px">Performance Rating Distribution Report<strong class="total-emp"></strong>
    </div>
    <div class="filters mt-4">
        <div class="row align-items-center" style="margin-bottom: 8px; margin-top: 0px;">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-1 filter-text" style="max-width: 100px">Filters:</div>
                    <div class="col-md-9" id="appliedFilters"></div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <?php $this->load->view('report/download_reports_link'); ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3" id="chartNode">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-6 <?php print $hide_field_array["country"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="countryChart" class="w-100" style="height: 400px" ></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["city"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="cityChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["business_level_1"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="businessUnit1" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["business_level_2"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="businessUnit2" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["business_level_3"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="businessUnit3" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["grade"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="hcByGrade" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["level"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="hcByLevel" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["function"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="hcByFunction" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["start_date_for_role"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="hcByTenure" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["gender"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="genderChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["education"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="educationChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["critical_talent"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="identifiedTalentChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["critical_position"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="criticalPositionHolderChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["special_category"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="specialCategoryOneChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["urban_rural_classification"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="urbanRuralClassificationChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["subfunction"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="subFunctionChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 <?php print $hide_field_array["sub_subfunction"] ?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="subSubFunctionChart" class="w-100" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-4"></div>
</div>
<script>

var GRAPHAPIURL="<?php echo base_url('api/graph/report/1/1') ?>";
    var titlePrefix = 'Rating Distribution by  ';
var dataKeys = {
    "employeeCode": "<?php echo !empty($datakey_array['employee_code']) ? $datakey_array['employee_code'] : 'employee_code'; ?>",
    "name": "<?php echo !empty($datakey_array['name']) ? $datakey_array['name'] : 'name'; ?>",
    "email": "<?php echo !empty($datakey_array['email']) ? $datakey_array['email'] : 'email'; ?>",
    "designation": "<?php echo !empty($datakey_array['designation']) ? $datakey_array['designation'] : 'designation'; ?>",
    "businessUnit1": "<?php echo !empty($datakey_array['business_level_1']) ? $datakey_array['business_level_1'] : 'business_level_1'; ?>",
    "businessUnit2": "<?php echo !empty($datakey_array['business_level_2']) ? $datakey_array['business_level_2'] : 'business_level_2'; ?>",
    "businessUnit3": "<?php echo !empty($datakey_array['business_level_3']) ? $datakey_array['business_level_3'] : 'business_level_3'; ?>",
    "education": "<?php echo !empty($datakey_array['education']) ? $datakey_array['education'] : 'education'; ?>",
    "startDate": "<?php echo !empty($datakey_array['company_joining_date']) ? $datakey_array['company_joining_date'] : 'company_joining_date'; ?>",
    "perfRating": "<?php echo !empty($datakey_array['rating_for_current_year']) ? $datakey_array['rating_for_current_year'] : 'performance_rating'; ?>",
    "country": "<?php  echo !empty($datakey_array['country']) ? $datakey_array['country'] : 'country'; ?>",
    "city": "<?php  echo !empty($datakey_array['city']) ? $datakey_array['city'] : 'city'; ?>",
    "grade": "<?php  echo !empty($datakey_array['grade']) ? $datakey_array['grade'] : 'grade'; ?>",
    "level": "<?php  echo !empty($datakey_array['level']) ? $datakey_array['level'] : 'level'; ?>",
    "function": "<?php  echo !empty($datakey_array['function']) ? $datakey_array['function'] : 'function'; ?>",
    "gender": "<?php  echo !empty($datakey_array['gender']) ? $datakey_array['gender'] : 'gender'; ?>",
    "subFunction": "<?php  echo !empty($datakey_array['subfunction']) ? $datakey_array['subfunction'] : 'subfunction'; ?>",
    "subSubFunction": "<?php  echo !empty($datakey_array['sub_subfunction']) ? $datakey_array['sub_subfunction'] : 'sub_subfunction'; ?>",
    "identifiedTalent": "<?php  echo !empty($datakey_array['critical_talent']) ? $datakey_array['critical_talent'] : 'critical_talent'; ?>",
    "criticalPositionHolder": "<?php  echo !empty($datakey_array['critical_position']) ? $datakey_array['critical_position'] : 'critical_position'; ?>",
    "specialCategoryOne": "<?php  echo !empty($datakey_array['special_category']) ? $datakey_array['special_category'] : 'special_category'; ?>",
    "urbanRuralClassification": "<?php  echo !empty($datakey_array['urban_rural_classification']) ? $datakey_array['urban_rural_classification'] : 'urban_rural_classification'; ?>",
};


var displayName = {
    "employeeCode": "<?php echo !empty($display_field_name_array['employee_code']) ? $display_field_name_array['employee_code'] : 'Employee Code'; ?>",
    "name": "<?php echo !empty($display_field_name_array['name']) ? $display_field_name_array['name'] : 'Employee Full name'; ?>",
    "email": "<?php echo !empty($display_field_name_array['email']) ? $display_field_name_array['email'] : 'Email'; ?>",
    "designation": "<?php echo !empty($display_field_name_array['designation']) ? $display_field_name_array['designation'] : 'Title'; ?>",
    "businessUnit1": "<?php echo !empty($display_field_name_array['business_level_1']) ? $display_field_name_array['business_level_1'] : 'Group'; ?>",
    "businessUnit2": "<?php echo !empty($display_field_name_array['business_level_2']) ? $display_field_name_array['business_level_2'] : 'Division';?>",
    "businessUnit3": "<?php echo !empty($display_field_name_array['business_level_3']) ? $display_field_name_array['business_level_3'] : 'Area';?>",
    "education": "<?php echo !empty($display_field_name_array['education']) ? $display_field_name_array['education'] : 'Education';?>",
    "startDate": "<?php echo !empty($display_field_name_array['company_joining_date']) ? $display_field_name_array['company_joining_date'] : 'Date of Joining' //echo CV_BA_NAME_START_DATE_FOR_ROLE;?>",
    "perfRating": "<?php echo !empty($display_field_name_array['rating_for_current_year']) ? $display_field_name_array['rating_for_current_year'] : 'Performance Rating' //echo CV_BA_NAME_RATING_FOR_CURRENT_YEAR;?>",
    "country": "<?php  echo !empty($display_field_name_array['country']) ? $display_field_name_array['country'] : 'Country' ?>",
    "city": "<?php  echo !empty($display_field_name_array['city']) ? $display_field_name_array['city'] : 'City' ?>",
    "grade": "<?php  echo !empty($display_field_name_array['grade']) ? $display_field_name_array['grade'] : 'Grade' ?>",
    "level": "<?php  echo !empty($display_field_name_array['level']) ? $display_field_name_array['level'] : 'Level' ?>",
    "function": "<?php  echo !empty($display_field_name_array['function']) ? $display_field_name_array['function'] : 'Function' ?>",
    "gender": "<?php  echo !empty($display_field_name_array['gender']) ? $display_field_name_array['gender'] : 'Gender' ?>",
    "subFunction": "<?php  echo !empty($display_field_name_array['subfunction']) ? $display_field_name_array['subfunction'] : 'Sub Function' ?>",
    "subSubFunction": "<?php  echo !empty($display_field_name_array['sub_subfunction']) ? $display_field_name_array['sub_subfunction'] : 'Sub Sub Function' ?>",
    "identifiedTalent": "<?php  echo !empty($display_field_name_array['critical_talent']) ? $display_field_name_array['critical_talent'] : 'Identified talent' ?>",
    "criticalPositionHolder": "<?php  echo !empty($display_field_name_array['critical_position']) ? $display_field_name_array['critical_position'] : 'Critical Position holder' ?>",
    "specialCategoryOne": "<?php  echo !empty($display_field_name_array['special_category']) ? $display_field_name_array['special_category'] : 'Special Category-1' ?>",
    "urbanRuralClassification": "<?php  echo !empty($display_field_name_array['urban_rural_classification']) ? $display_field_name_array['urban_rural_classification'] : 'Urban/Rural classification' ?>",
};

var tenure_list = <?php print json_encode($tenure_list); ?>;
var chartExportPptArray = [];
<?php if( $hide_field_array["country"] != 'hide') { ?>  chartExportPptArray.push("countryChart"); <?php } ?>
<?php if( $hide_field_array["city"] != 'hide') { ?>  chartExportPptArray.push("cityChart"); <?php } ?>
<?php if( $hide_field_array["business_level_1"] != 'hide') { ?>  chartExportPptArray.push("businessUnit1"); <?php } ?>
<?php if( $hide_field_array["business_level_2"] != 'hide') { ?>  chartExportPptArray.push("businessUnit2"); <?php } ?>
<?php if( $hide_field_array["business_level_3"] != 'hide') { ?>  chartExportPptArray.push("businessUnit3"); <?php } ?>
<?php if( $hide_field_array["grade"] != 'hide') { ?>  chartExportPptArray.push("hcByGrade"); <?php } ?>
<?php if( $hide_field_array["level"] != 'hide') { ?>  chartExportPptArray.push("hcByLevel"); <?php } ?>
<?php if( $hide_field_array["function"] != 'hide') { ?>  chartExportPptArray.push("hcByFunction"); <?php } ?>
<?php if( $hide_field_array["company_joining_date"] != 'hide') { ?>  chartExportPptArray.push("hcByTenure"); <?php } ?>
<?php if( $hide_field_array["gender"] != 'hide') { ?>  chartExportPptArray.push("genderChart"); <?php } ?>
<?php if( $hide_field_array["subfunction"] != 'hide') { ?>  chartExportPptArray.push("subFunctionChart"); <?php } ?>
<?php if( $hide_field_array["sub_subfunction"] != 'hide') { ?>  chartExportPptArray.push("subSubFunctionChart"); <?php } ?>
<?php if( $hide_field_array["education"] != 'hide') { ?>  chartExportPptArray.push("educationChart"); <?php } ?>
<?php if( $hide_field_array["critical_talent"] != 'hide') { ?>  chartExportPptArray.push("identifiedTalentChart"); <?php } ?>
<?php if( $hide_field_array["critical_position"] != 'hide') { ?>  chartExportPptArray.push("criticalPositionHolderChart"); <?php } ?>
<?php if( $hide_field_array["special_category"] != 'hide') { ?>  chartExportPptArray.push("specialCategoryOneChart"); <?php } ?>
<?php if( $hide_field_array["urban_rural_classification"] != 'hide') { ?>  chartExportPptArray.push("urbanRuralClassificationChart"); <?php } ?>
</script>
<?php
 $this->load->view('common/common-js');
?>
<script src="<?php echo base_url('assets/chartjs') ?>/js/performance_rating.js"></script>
<script>
    $(document).ready(function() {
        App(GRAPHAPIURL);
        
    })
</script>
</div>

