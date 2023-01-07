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
  .card{margin-left:7px; margin-bottom: 10px;}
  </style>
	<div class="page-breadcrumb">
	  <div class="container-fluid compp_fluid">	
	  	<div class="row">
	  	<div class="col-sm-8">	
		 <ol class="breadcrumb">
			<li>
				<a href="javascript:void(0)"> Analytics/Reports</a>
			</li>
			<li class="active">Revenue and Profit per FTE vs Avg FTE Cost</li>
		 </ol>
		</div>
		<div class="col-sm-4"></div>
	     </div>
	    </div>
      </div>
   
	<div class="page-title">
		<div class="container-fluid compp_fluid">
		  <div class="text-center mt-4">
			<h3 class="textbold text20" id="dashboardTitle" style="margin-bottom:-8px">Revenue and Profit per FTE vs Avg FTE Cost for<!-- <span style=" float: none;" type="button"class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> -->
				<div style="display: inline-block;">
				 <form class="form-inline">
					<div class="form-group">
						<label class="textbold text20" style="color: #000 !important;">Year</label>
						<select name="financial_year" style="width: auto; display: inline-block;" class="form-control report-selected-text" id="financial_year"></select>
					</div>
					<div class="form-group" id="rules" style="margin-bottom: 0px;">
						<input type="button" id="btn_update_report" value="Update Report"  class="btn btn-primary" />
					</div>
				 </form>
				</div>
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
								<div class="col-12">
									<div class="card mb-4">
										<div class="card-body">
											<div id="country-container" class="w-100 highcharts_on_this_page" style="height: 500px"></div>
											
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="card mb-4">
										<div class="card-body">
											<div id="city-container" class="w-100 highcharts_on_this_page" style="height: 500px"></div>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="card mb-4">
										<div class="card-body">
											<div id="businessunit-container" class="w-100 highcharts_on_this_page" style="height: 500px"></div>
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
				<div id="businessunit-container-lg" class="lg-popup-graph"></div>
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
			<script src="<?php echo base_url('assets/chartjs') ?>/js/script_profit_FTE.js"></script>
			<script src="<?php echo base_url('assets/chartjs') ?>/js/highchart3d.js"></script>
			retretre----<?php echo $_COOKIE['Acc3ssTo73n']; ?>-----tertre
			<script>   
$(document).ready(function() {

	 $(function() {
	        $( "#from, #to" ).datepicker({
	            defaultDate: "+1w",
	            changeMonth: true,
	            numberOfMonths: 1,
	            onSelect: function( selectedDate ) {
	                if(this.id == 'from'){
	                  var dateMin = $('#from').datepicker("getDate");
	                  var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 1); 
	                  var rMax = "1y+1m +7d";//new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 365); 
	                  $('#to').datepicker("option","minDate",rMin);
	                  $('#to').datepicker("option","maxDate",rMax);                    
	                }
	                
	            }
	        });
	    });
		
    var nodejs_api_helper = new NodeJs_API_Helper('<?php echo $_COOKIE['Acc3ssTo73n']; ?>');    
	// ensure all charts use the class  highcharts_on_this_page 
	var allChartsOnThePage = $(".highcharts_on_this_page");	
	var exportToPDFBtn = $('#exportPdf');
	var exportToExcelBtn = $('#exportCsv');
	var filterDiv = $('#appliedFilters');
	var exportToPptsBtn = $('#exportPpts');

    getFinancialYear(nodejs_api_helper);
    initialize(nodejs_api_helper.base_url +'/profit/1',  nodejs_api_helper, allChartsOnThePage, filterDiv, exportToPDFBtn, exportToExcelBtn, exportToPptsBtn); //for default year -- currently one

    $("#btn_update_report").click(function() {
        initialize(nodejs_api_helper.base_url +'/profit/'+ $("#financial_year").find(":selected").val(), nodejs_api_helper, allChartsOnThePage, filterDiv, exportToPDFBtn, exportToExcelBtn);
        //console.log($("#financial_year").find(":selected").val(););
    });
});
</script>

