<script src="<?php echo base_url('assets/chartjs') ?>/js/highchart.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/exporting.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style type="text/css">
/********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/
.fstElement:foucs {box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses");?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses");?>!important;}
.fstChoiceItem {background-color:#<?php echo $this->session->userdata("company_color_ses");?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses");?>!important;font-size:1em;}
.fstResultItem {font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected {background-color:#<?php echo $this->session->userdata("company_color_ses");?>!important;
border-top-color:#<?php echo $this->session->userdata("company_light_color_ses");?>!important;}
.fstControls { line-height:17px;}

.blackk{color: #fff !important; background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}
.disabled {pointer-events:none; //This makes it not clickable  opacity:0.6; //This grays it out to look disabled}
.box-report-degn .report-title h3{background-color:#<?php echo $this->session->userdata("company_light_color_ses");?>!important;}
.custombox{}
.custombox table p{padding: 0px;}
.mailbox-content table tbody tr td{line-height: 25px;}
.tablecustm thead tr th{vertical-align: middle; letter-spacing: 1px;}
</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container-fluid">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li><a href="<?php echo site_url("salary-rule-list/").$performance_cycle_id; ?>">Rule List</a></li>
        <li class="active">Rule Dashboard</li>
    </ol>
</div>

<div class="row mb20">
    <div class="col-md-12" style="margin-bottom: 10px;margin-top: 30px;">
        <div class="col-md-3">
            <div class="card-body">
                <div id="genderChart" class="w-100" style="height: 300px"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-body">
                <div id="genderChart1" class="w-100" style="height: 300px"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-body">
                <div id="genderChart2" class="w-100" style="height: 300px"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-body">
                <div id="genderChart3" class="w-100" style="height: 300px"></div>
            </div>
        </div>
    </div>
</div>

<div id="main-wrapper" class="container-fluid">

  <div class="col-md-12 background-cls" style="margin-bottom: 20px;"> 
   <div class="mailbox-content custombox"> 
    <div class="attr_wise_reports dashbord_pg clearfix " > 
           <h4>Budget allocation by various segments</h4>
            <ul>
            <li>
                <div btnvalue="approver_1" class="btn btn-twitter dd-btn btn_attributeswise" id="btn_attributeswise_approver_1" processed="notprocessed">Approver-1</div>
            </li>    

            <?php foreach($ddl_attributeswise_budget as $attr){?>
                <li>
                    <div btnvalue="<?php echo $attr["ba_name"]; ?>" class="btn btn-twitter dd-btn btn_attributeswise"  id="btn_attributeswise_<?php echo $attr["ba_name"]; ?>" /><?php echo $attr["display_name"]; ?></div> 
                </li>
            <?php } ?> 

            <li>
                <div btnvalue="emp_performance_rating" class="btn btn-twitter dd-btn btn_attributeswise" id="btn_attributeswise_emp_performance_rating">Performance Rating </div>
            </li> 
            <li>
                <div btnvalue="increment_distribution" class="btn btn-twitter dd-btn btn_attributeswise" id="btn_attributeswise_increment_distribution">Increment Distribution</div>
            </li>   
        </ul>
     </div>
  

    <?php foreach($ddl_attributeswise_budget as $attr){?>
        <div  id="panel_attributeswise_<?php echo $attr["ba_name"]; ?>" class="form-group panel_attributeswise"  style="display:none;" >
            <div class="row"><div class="col-sm-12"><div btnvalue="<?php echo $attr["ba_name"]; ?>" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_<?php echo $attr["ba_name"]; ?>_print" />Download Data</div></div></div>
            <div class="content"></div>
            <div btnvalue="<?php echo $attr["ba_name"]; ?>" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_<?php echo $attr["ba_name"]; ?>_print2" />Download Data</div>                        
        </div>
    <?php } ?> 
    <div id="panel_attributeswise_approver_1" class="form-group panel_attributeswise" style="display:none;">
        <div class="row"><div class="col-sm-12"><div btnvalue="approver_1" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_approver_1_print" processed="processed">Download Data</div></div></div>
        <div class="content"></div>
        <div btnvalue="approver_1" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_approver_1_print2" processed="processed">Download Data</div>
    </div>
    <div id="panel_attributeswise_emp_performance_rating" class="form-group panel_attributeswise" style="display:none;">
        <div class="row"><div class="col-sm-12"><div btnvalue="emp_performance_rating" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_emp_performance_rating_print" processed="processed">Download Data</div></div></div>
        <div class="content"></div>
        <div btnvalue="emp_performance_rating" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_emp_performance_rating_print2" processed="processed">Download Data</div>
    </div>
    <div id="panel_attributeswise_increment_distribution" class="form-group panel_attributeswise" style="display:none;">
        <div class="row"><div class="col-sm-12"><div btnvalue="increment_distribution" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_increment_distribution_print" processed="processed">Download Data</div></div></div>
        <div class="content"></div>
        <div btnvalue="increment_distribution" class="btn btn-twitter dd-btn btn_attributeswise_print pull-right" style="margin-top: 10px" id="btn_attributeswise_increment_distribution_print2" processed="processed">Download Data</div>
    </div>
    </div>
</div>

<div class="col-md-12 background-cls" style="margin-bottom: 20px; padding-bottom: 0px;"> 
     <div class="custombox" style="padding: 10px !important;"> 
        <div class="attr_wise_reports dashbord_pg clearfix " > 
            <h4>Additional Analytics</h4>
            <div class="report_filter" style="width: 100%; display: block;">
            <form class="form-horizontal range-pene-and-avg-increase" action="<?php echo site_url("report/range-pene-and-avg-increase-summary/".$rule_id); ?>" method="post" enctype="multipart/form-data">
            <?php echo HLP_get_crsf_field();?>
                <div class="form_sec clearfix"> 
                    <div class="col-sm-11 padlt0"> 
                        <div class="form-group my-form nobg">
                            <label for="inputEmail3" class="col-sm-4 col-xs-12 label_h control-label" style="font-size: 13px !important;"> Range Penetration & Average Increase Report</label>
                            <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                <select id="report_rating_ids" onchange="hide_list('report_rating_ids');" name="report_rating_ids[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($rattings){
                                        foreach($rattings as $row){ ?>
                                            <option  value="<?php echo $row->id;?>"><?php echo $row->name; ?></option>
                                    <?php }
                                        } ?>
                                </select>
                                <select id="functions_name_pene" onchange="hide_list('functions_name_pene');" name="functions_name_pene[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($function_array){
                                                foreach($function_array as $fun_row){ ?>
                                                        <option  value="<?php echo $fun_row['function_name'];?>"><?php echo $fun_row['function_name']; ?></option>
                                                <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 mob-center padlt0 padrt0">
                        <input style="width: 100%; height: 32px;" type="submit" id="btnAdd" value="Submit" class="btn btn-success pull-right marbt10" />
                    </div> 
                </div>                        
            </form> 
           </div>

            <div class="report_filter" style="width: 100%; display: block;">
                <form class="form-horizontal range-pene-and-avg-increase" action="<?php echo site_url("report/promotion-summary/".$rule_id); ?>" method="post" enctype="multipart/form-data">
                    <?php echo HLP_get_crsf_field();?>
                    <div class="form_sec clearfix"> 
                        <div class="col-sm-11 padlt0"> 
                            <div class="form-group my-form nobg">
                                <label for="inputEmail3" class="col-sm-4 col-xs-12 label_h control-label" style="font-size: 13px !important;"> Promotion Summary Report</label>
                                <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                    <select id="functions_name" onchange="hide_list('functions_name');" name="functions_name[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                     <option  value="all">All</option>
                                        <?php if($function_array){
                                                    foreach($function_array as $fun_row){ ?>
                                                         <option  value="<?php echo $fun_row['function_name'];?>"><?php echo $fun_row['function_name']; ?></option>
                                                    <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 mob-center padlt0 padrt0">
                            <input style="width: 100%; height: 32px;" type="submit" id="btnAdd" value="Submit" class="btn btn-success pull-right marbt10" />
                        </div>
                    </div> 
                </form> 
            </div>

            <div class="report_filter" style="width: 100%; display: block;">
                <form class="form-horizontal range-pene-and-avg-increase" action="<?php echo site_url("report/grade-cost-summary/").$rule_id; ?>" method="post" enctype="multipart/form-data">
                    <?php echo HLP_get_crsf_field();?>
                    <div class="form_sec clearfix"> 
                        <div class="col-sm-11 padlt0"> 
                            <div class="form-group my-form nobg">
                                <label for="" class="col-sm-4 col-xs-12 label_h control-label" style="font-size: 13px !important;"> Cost Summary Grade Report</label>
                                <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                    <select id="functions_name_grade" onchange="hide_list('functions_name_grade');" name="functions_name_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                     <option  value="all">All</option>
                                        <?php if($function_array){
                                                    foreach($function_array as $fun_row){ ?>
                                                         <option  value="<?php echo $fun_row['function_name'];?>"><?php echo $fun_row['function_name']; ?></option>
                                                    <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 mob-center padlt0 padrt0">
                            <input style="width: 100%; height: 32px;" type="submit" id="btnAdd" value="Submit" class="btn btn-success pull-right marbt10" />
                        </div>
                    </div> 
                </form> 
            </div>

            <div class="report_filter" style="width: 100%; display: block;">
                <form class="form-horizontal range-pene-and-avg-increase" action="<?php echo site_url("report/performance-rating-cost-summary/").$rule_id; ?>" method="post" enctype="multipart/form-data">
                    <?php echo HLP_get_crsf_field();?>
                    <div class="form_sec clearfix"> 
                        <div class="col-sm-11 padlt0"> 
                            <div class="form-group my-form nobg">
                                <label for="" class="col-sm-4 col-xs-12 label_h control-label" style="font-size: 13px !important;"> Cost Summary Performance Rating Report</label>
                                <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                    <select id="functions_name_per" onchange="hide_list('functions_name_per');" name="functions_name_per[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                     <option  value="all">All</option>
                                        <?php if($function_array){
                                                    foreach($function_array as $fun_row){ ?>
                                                         <option  value="<?php echo $fun_row['function_name'];?>"><?php echo $fun_row['function_name']; ?></option>
                                                    <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 mob-center padlt0 padrt0">
                            <input style="width: 100%; height: 32px;" type="submit" id="btnAdd" value="Submit" class="btn btn-success pull-right marbt10" />
                        </div>
                    </div> 
                </form> 
            </div>

            <div class="report_filter" style="width: 100%; display: block;">
                <form class="form-horizontal range-pene-and-avg-increase" action="<?php echo site_url("report/miscellaneous-summary/").$rule_id; ?>" method="post" enctype="multipart/form-data">
                    <?php echo HLP_get_crsf_field();?>
                    <div class="form_sec clearfix"> 
                        <div class="col-sm-11 padlt0"> 
                            <div class="form-group my-form nobg">
                                <label for="" class="col-sm-4 col-xs-12 label_h control-label" style="font-size: 13px !important;"> Process Miscellaneous Summary Report</label>
                                <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                    <select id="functions_name_process" onchange="hide_list('functions_name_process');" name="functions_name_process[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                     <option  value="all">All</option>
                                        <?php if($function_array){
                                                    foreach($function_array as $fun_row){ ?>
                                                         <option  value="<?php echo $fun_row['function_name'];?>"><?php echo $fun_row['function_name']; ?></option>
                                                    <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 mob-center padlt0 padrt0">
                            <input style="width: 100%; height: 32px;" type="submit" id="btnAdd" value="Submit" class="btn btn-success pull-right marbt10" />
                        </div>
                    </div> 
                </form> 
            </div>

         <!-- <div class="box-report-degn">
            <div class="report-title">
              <h3>Cost Summary Report</h3>
            </div>    
            <div class="reports-buttons">     
            <ul>
                <li>
                    <a class="btn btn-twitter dd-btn costsumry" href="<?php //echo site_url("report/grade-cost-summary/").$rule_id; ?>">Grade</a>
                </li>
                <li>
                   <a class="btn btn-twitter dd-btn costsumry" href="<?php //echo site_url("report/performance-rating-cost-summary/").$rule_id; ?>">Performance Rating</a>
                </li> 
             </ul>
            </div>
           </div> 

           <div class="box-report-degn">
            <div class="report-title">
                <h3>Process Summary Report</h3> 
            </div>
            <div class="reports-buttons">
               <ul>
                <li>
                    <a class="btn btn-twitter dd-btn costsumry" href="<?php//echo site_url("report/promotion-summary/").$rule_id; ?>">Promotion Summary Report</a>
                </li>
                <li>
                    <a class="btn btn-twitter dd-btn costsumry" href="<?php //echo site_url("report/miscellaneous-summary/").$rule_id; ?>">Miscellaneous Summary Report</a>
                </li>
             </ul>
            </div>
           </div>-->


          </div>
        </div>
    </div>
</div> 


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<?php $employeeCount = array();
    $totalEmp = 0;
    if($approval_count){ 
        $i = 0;
        foreach ($approval_count as $key => $value) { 
            $i++; 
            $employeeCount[] = $value['count'];
            $totalEmp += $value['count']; 
            }
        for($k =($i+1); $k<5;$k++)
        { $employeeCount[] = 0;  }

    } 
?>



<script type="text/javascript"> 

$( ".range-pene-and-avg-increase" ).submit(function( event ) {
    setTimeout(function(){
        location.reload();
    }, 2000);
});

$('.multipleSelect').fastselect();





function hide_list(obj_id)
{
    
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
            	$(this).find(".fstChoiceRemove").trigger("click");
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
$( document ).ready(function() {
 var color = ['#1319CC','#E87B14','red','#ba5154'];
var approval =[
<?php foreach ($employeeCount as $key => $value) { ?>
   { name: 'Approver <?php echo ($key+1); ?>',value:'<?php echo $value; ?> (<?php echo number_format(($value*100)/$totalEmp,2); ?>% )', y: <?php echo $value; ?> },
<?php } ?>
            
            // { name: 'Approver 2',value:'18,17', y: 18 },
            // { name: 'Approver 3',value:'10,17', y: 0 },
            // { name: 'Approver 4', value:'10,17',y: 0 },
        ];

Highcharts.chart('genderChart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Pending cases for Approvals',
        style: {
                color: '#000000',
                fontSize: '12px'
        }
    },
    tooltip: {
        pointFormat: '{point.value}'
    },
    exporting: {
            enabled: false
        },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            colors:color,
            dataLabels: {
                enabled: false,
                format: '{point.value}',
                distance: 2,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: '',
        data: approval
    }]
});
<?php $allocatedBudget=$budget_amount->allocated_budget;
      $leftBudget=$budget_amount->available_budget;
 ?>
var totalBudget = '<?php echo $budget_amount->allocated_budget ;// $allocatedBudget; ?>';
var leftBudget = '<?php echo ($budget_amount->available_budget) ; //($leftBudget) ?>';
//console.log(<?php echo $avail?>);
var budget =[
            { name: 'Allocated Budget : <?php echo number_format($allocatedBudget,0); ?><br>',value:'<?php echo number_format($allocatedBudget,0).',<br/>'.number_format(( ($allocatedBudget-($leftBudget))*100)/$allocatedBudget,0); ?>', y: <?php echo $allocatedBudget; ?> },
            { name: 'Available Budget : <?php echo number_format($leftBudget,0) ?>',value:'<?php echo $leftBudget.','.number_format(( ($leftBudget)*100)/$allocatedBudget,0); ?>', y: <?php echo ($leftBudget) ?> },
        ];



Highcharts.chart('genderChart1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Budget Utilisation ',
        style: {
                color: '#000000',
                fontSize: '12px'
        }
    },
    // tooltips: {
    //             titleFontFamily: 'Open Sans',
    //             caretSize: 5,
    //             cornerRadius: 2,
    //             xPadding: 10,
    //             yPadding: 10
    //         },
    // // showDatapoints: true,
    // tooltip: {
    //     //pointFormat: '{point.value}%'
    //     enabled: true
    // },
    tooltip: {
        pointFormat: ''
    },
    exporting: {
            enabled: false
        },

    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            colors: color,
            dataLabels: {
                enabled: false,
                format: '{point.value} %',
                distance: 3,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        },
        // series: {
        //     states: {
        //         hover: {
        //             enabled: false
        //         }
        //     }
        // }
    },
    series: [{
        name: '',
        data:budget,
    }]
});

var rating =[
<?php foreach ($performances as $key => $value) {  ?>
   { name: '<?php echo $value->performance_rating; ?>',value:'<?php echo number_format( ($value->count*100)/$performances_total,0); ?> % ( <?php echo $value->count; ?> )', y: <?php echo $value->count; ?> },
<?php } ?>
        ];

Highcharts.chart('genderChart2', {
    chart: {
        type: 'pie'
    },
    // legend: {
    //         align: 'right',
    //         verticalAlign: 'middle',
    //         layout: 'vertical',
    //     },
    title: {
        text: 'Rating Distribution',
        style: {
                color: '#000000',
                fontSize: '12px'
        }
    },

    tooltip: {
        pointFormat: '{point.value}'
    },
    exporting: {
            enabled: false
        },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            colors: color,
            dataLabels: {
                enabled: false,
                format: '{point.value}',
                distance: 2,
            }
        }
    },
    series: [{
        name: 'Share',
        data:rating
    }]
});



        var rating_data=[];
        var rating_label=[];
        
<?php foreach ($performances as $key => $value) { ?>
    rating_data.push(<?php echo number_format(($value->ratting_total)/$value->count,1); ?>);
    rating_label.push('<?php echo $value->performance_rating; ?>');
    
<?php } ?>
//console.log(rating_data);
        
Highcharts.chart('genderChart3', {
    chart: {
        type: 'column',
    },
    title: {
        text: 'Average Increase by Rating',
        style: {
                color: '#000000',
                fontSize: '12px'
        }
    },
    
    xAxis: {
        categories: rating_label,
        
        labels: {
            style: {
                fontSize:'9px',
                fontWeight: 'bold'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
     legend: {
        verticalAlign: 'top',
        enabled: false,

        
    },
    tooltip: {
        pointFormat: '{point.data} {point.y:.1f}%'
    },
    exporting: {
            enabled: false
        },
    plotOptions: {
        colors: color,
        showInLegend: false,
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
                format: '{point.y} %',   
                enabled: true
            }
        }
    },
    series: [{
        data: rating_data
    }]
});

});
</script> 



<script>
//Piy19Dec19

$('.btn_attributeswise').click(function() {
  var for_attributes = $(this).attr('btnvalue');
  if( $(this).attr('processed')=='processed')
  {
    $(".panel_attributeswise").hide();
    $('#panel_attributeswise_'+for_attributes).show();
  }
  else
  {
  show_attributeswise_budget_dv(for_attributes );
  }
});

$('.btn_attributeswise_print').click(function() {    
  var for_attributes = $(this).attr('btnvalue'); 
  exportTableToXLS('Report_'+for_attributes +'_'+ new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls","#panel_attributeswise_" + for_attributes );  
});

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename,selector) {
    var csv = [];
    var rows = document.querySelectorAll(selector + " table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
        //  row.push('"'+cols[j].style.display+'"');
          if(cols[j].style.display != 'none'){
           row.push('"'+cols[j].innerText+'"');
          }
        
        csv.push(row.join(","));        
    }
    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
function exportTableToXLS(filename,selector) {

    var table = $(selector + " table");
    if(table && table.length){
        var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
        $(table).table2excel({
        exclude: ".noExl",
        name: "Excel Document Name",
        filename: filename,//"Report_"+ selector + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
        preserveColors: preserveColors
        });
    }

}
function show_attributeswise_budget_dv(for_attributes)
{

    var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
    var rid= '<?php echo $rule_id; ?>';
    if(for_attributes!='increment_distribution'){
        var url='<?php echo site_url("rules/get_attributeswise_dashboard_bdgt");?>';
    }
    else
    {
      var url='<?php echo site_url("rules/get_increment_distribution_dashboard_bdgt");?>';
    }
    if(for_attributes != '')
    {

        $.ajax(url, {
           type: 'POST',  
           data: {
                  'for_attributes': for_attributes, 
                  'rid':rid,
                  '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val
                  }, 
            beforeSend: function(jqXHR, settings){
                  $("#loading").css('display','block');
                  $(".panel_attributeswise").hide();                 
            },
            success: function (data, status, xhr) {
            //    console.log( data);    
                if(data)
                {
                    $("#panel_attributeswise_"+for_attributes+ " .content").html(data);
                    $("#panel_attributeswise_"+for_attributes).show();
                    $("#btn_attributeswise_"+for_attributes).attr('processed','processed');
                    $('html, body').animate({
                    scrollTop: $("#btn_attributeswise_"+for_attributes).offset().top
                    }, 1000);           
                }
                        
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log('error');
            },complete:function(){ 
                set_csrf_field();
                $("#loading").css('display','none');
                settabletxtcolor();
            }
        });

    }
}
//Piy End
</script>