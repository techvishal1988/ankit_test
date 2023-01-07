<?php header('Access-Control-Allow-Origin: https://alpha.compport.com'); ?>

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
    .map {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* this adds the "card" effect */
  padding: 16px;
  text-align: center;
    margin-left: -8px;
    margin-right: -15px;
    border-radius: 5px;
  margin-top: 10px;
  background-color: #f1f1f1;
}
    .lg-popup-graph {
        margin: 10%;
        height: 70vh;
        width: 80vw;
        display: none;
        overflow: hidden;
    }
    
</style>
<div class="page-breadcrumb">
    <div class="container-fluid compp_fluid"> 
    <div class="row">
     <div class="col-sm-8">
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0)"> Analytics/Reports</a>
            </li>
            <li class="active">Talent vs Performance Rating Distribution Report </li>
        </ol>
    </div>
    <div class="col-sm-4"></div>
</div>
</div>
</div>
<div class="page-title">
    <div class="container-fluid compp_fluid">
        <div class="text-center mt-4">
            <h3 class="text20 textbold" id="dashboardTitle" style="margin-bottom:-8px">Talent vs Performance Rating Distribution Report
		<!-- <span style=" float: none;" type="button"class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span> -->
				</h3>
         
            
        </div>
       

   	<div class="filters mt-4">
				<div class="row align-items-center" style="margin-bottom: 8px; margin-top:-8px;">
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-1 filter-text" style="max-width: 100px">Filters:</div>
							<div class="col-md-9" id="appliedFilters"></div>
						</div>
					</div>
					<div class="col-md-3 text-right">
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
<!--        <div class="row justify-content-center mt-3" id="chartNode">-->
<!--            <div class="col-md-12">-->
<!--                <div class="row mt-4">-->
                    <div class="map">
                        <div >
                            <div >
                                <div id="country-container" style="width: 100% ;height: 500px" ></div>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <div>
                            <div >
                                <div id="city-container"  style="width: 100% ;height: 500px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <div >
                            <div >
                                <div id="level-container"  style="width: 100% ;height: 500px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <div >
                            <div >
                                <div id="grade-container"  style="width: 100% ;height: 500px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <div>
                            <div >
                                <div id="function-container"  style="width: 100%;height: 500px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <div >
                            <div >
                                <div id="businessunit-container"  style="width: 100%;height: 500px"></div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-6">-->
<!--                        <div class="card mb-4">-->
<!--                            <div class="card-body">-->
<!--                                <div id="performance_rating-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="card mb-4">-->
<!--                            <div class="card-body">-->
<!--                                <div id="gender-container" class="w-100 highcharts_on_this_page" style="height: 400px"></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
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
<!--    <div id="performance_rating-container-lg" class="lg-popup-graph"></div>-->
<!--    <div id="gender-container-lg" class="lg-popup-graph"></div>-->
</div>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/highchart.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/exporting.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/dom-to-image.min.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/jspdf.full.min.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/xlsx.min.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/lodash.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/nodejs_support.js">
</script>
<script src="
				<?php echo base_url('assets/chartjs') ?>/js/script_talent_vs_performance.js">
</script>

<script>
    $(document).ready(function() {
    	
        var nodejs_api_helper = new NodeJs_API_Helper('<?php echo $_COOKIE['Acc3ssTo73n']; ?>');    

        // ensure all charts use the class  highcharts_on_this_page 
        var allChartsOnThePage = $(".highcharts_on_this_page");

        var exportToPDFBtn = $('#exportPdf');
        var exportToExcelBtn = $('#exportCsv');
        var filterDiv = $('#appliedFilters');



        initialize(nodejs_api_helper.base_url + '/headcountPR', nodejs_api_helper, allChartsOnThePage, filterDiv, exportToPDFBtn, exportToExcelBtn); //for default year -- currently one
        


        
    });
</script>