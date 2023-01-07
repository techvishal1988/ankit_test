<style>
.chart-container {
	max-width: 1150px;
	text-align: center;
}

.pd0 {
	padding: 0;
}

/*.pie {
            position: absolute;
            margin: 0 auto;
            width: 100%;
        }*/
.box {
	max-width: 500px;
	margin: 40px 0;
	background: lightgray;
}

.box-left {
	float: left;
	text-align: left;
}

.box-right {
	float: right;
	text-align: right;
}

.box p {
	color: #000;
	padding: 15px;
	margin: 0;
	line-height: 16px;
	max-width: 65%;
}

.p-right {
	float: right;
}


/*@media (max-width: 1440px) {

  .graph_detail {height: 16.2vh !important;}
}
*/
@media screen and (min-width: 992px) and (max-width: 1199px) {
	.chart-container {
		max-width: 950px;
	}
	.box {
		max-width: 390px;
		margin: 30px 0;
	}
	.box p {
		max-width: 60%;
	}
}

@media only screen and (max-width: 991px) {
	.pie {
		position: relative;
	}
	.chart-container {
		max-width: 100%;
	}
	.box {
		max-width: 100%;
		margin: 30px 0;
	}
	.box p {
		max-width: 100%;
	}
	.p-right,.box-right,.box-left {
		float: none;
		text-align: left;
	}
	.inline {
		display: block !important;
	}
	.first {
		text-align: center;
		margin: 0 !important;
		padding: 5%;
	}
	.second {
		text-align: center;
		margin: 0 !important;
		padding: 5%;
	}
	.two {
		display: none;
	}
	.one {
		display: none;
	}
	.class-1 {
		width: 100% !important;
		padding: 0 !important;
		margin: auto 0 !important;
	}
	.class-2 {
		width: 100% !important;
		padding: 0 !important;
		margin: auto 0 !important;
	}
}

* {
	box-sizing: border-box;
}

.container-one {
	position: absolute;
	width: 100%;
	top: 19%;
	left: 33%;
}

.one {
	shape-outside: circle(50%);
	width: 550px;
	height: 550px;
	float: left;
	opacity: 1;
}

.text-right {
	text-align: right;
}

.two {
	shape-outside: circle(50%);
	width: 550px;
	height: 550px;
	float: right;
	opacity: 1;
}

.box-1 {
	width: 100%;
	height: 100%;
	margin-top: 8%;
	text-align: center;
}

.inline {
	display: inline-flex;
}

.class-1 {
	width: 50%;
}

.class-2 {
	width: 50%;
}

.pd-0 {
	padding: 0;
}

body {
	overflow-x: hidden;
}

/*.class-1{*/ /*!*padding-left: 8%;*!*/ /*margin-top: 1%;*/ /*}*/
	/*.class-2{*/ /*!*padding-right: 8%;*!*/ /*margin-top: 1%;*/ /*}*/
.first {
	margin-right: -46%;
	margin-top: -7%;
}

.second {
	margin-left: -46%;
	margin-top: -7%;
}

.mt-7 {
	margin-top: 7%;
}

.headingg {
	display: block;
	width: 100%;
	padding: 1%;
	margin-bottom: 1%;
	background-color: #d0cece;
	text-align: center;
}

.headingg h4 {
	margin: 0px;
	font-size: 20px;
	font-weight: 400;
	color: #000;
}
</style>
<link
	href="<?php echo base_url() ?>assets/salary/css/style.css"
	rel="stylesheet" type="text/css">
<style>
/*Start shumsul*/
.page-inner {
	padding: 0 0 40px;
	background: url(<?   php echo $   this- >   session- >   userdata('company_bg_img_url_ses'
		); ?>) 0 0 no-repeat !important;
	background-size: cover !important;
	margin-bottom: 8px;
}

/*End shumsul*/
#container { /*position:absolute;margin-left:24%;margin-top:3%;*/
	width: 100%;
}

.total_salary {
	z-index: 50;
	top: 45%;
	left: 0%;
	position: unset !important;
}

.highcharts-button-symbol {
	display: none;
}

.highcharts-background {
	fill-opacity: 0.1;
}

p.algn {
	text-align: justify;
}

p.pad_l {
	padding-left: 3%;
}

p.pad_r {
	padding-right: 3%;
}

.card-2.newcard {
	background: rgba(0, 0, 0, .5);
}

.card-2.newcard .highcharts-button-box {
	display: none;
}

.graph_detail {
	position: relative;
	overflow: hidden;
	height: 22.2vh;
	color: #000;
	display: block;
	width: 100%;
	padding: 4% 6% 6% 6%;
	background:#d7ecfb;
	margin-bottom: 4%;
	text-align: justify;
	/*background: #fff; */
	/*background: -moz-linear-gradient(left, #b2b2b2 0%, #f2f2f2 100%, #eaeaea 100%,
		#f2f2f2 100%); 
	background: -webkit-linear-gradient(left, #b2b2b2 0%, #f2f2f2 100%, #eaeaea 100%,
		#f2f2f2 100%); 
	background: linear-gradient(to right, #b2b2b2 0%, #f2f2f2 100%, #eaeaea 100%,
		#f2f2f2 100%); 
	filter: progid :   DXImageTransform.Microsoft.gradient (    
		startColorstr = 
		 '#b2b2b2', endColorstr =   '#f2f2f2', GradientType =   1 );*/
	/* IE6-9 */
}

.graph_detail .hide_grd {
	position: absolute;
	bottom: 0;
	width: 90%;
	height: 14px;
	background: #d7ecfb; 
	/*background: -moz-linear-gradient(left, #b2b2b2 0%, #f2f2f2 100%, #eaeaea 100%,
		#f2f2f2 100%); 
	background: -webkit-linear-gradient(left, #b2b2b2 0%, #f2f2f2 100%, #eaeaea 100%,
		#f2f2f2 100%); 
	background: linear-gradient(to right, #b2b2b2 0%, #f2f2f2 100%, #eaeaea 100%,
		#f2f2f2 100%); 
	filter: progid :   DXImageTransform.Microsoft.gradient (    
		startColorstr = 
		 '#b2b2b2', endColorstr =   '#f2f2f2', GradientType =   1 );*/
	/* IE6-9 */
}

.graph_detail .hide_grd2 {
	position: absolute;
	bottom: 0;
	width: 90%;
	height: 14px;
	background: #d7ecfb; 
	/*background: -moz-linear-gradient(left, #f2f2f2 0%, #b2b2b2 100%, #eaeaea 100%,
		#b2b2b2 100%); 
	background: -webkit-linear-gradient(left, #f2f2f2 0%, #b2b2b2 100%, #eaeaea 100%,
		#b2b2b2 100%); 
	background: linear-gradient(to right, #f2f2f2 0%, #b2b2b2 100%, #eaeaea 100%,
		#b2b2b2 100%); 
	filter: progid :   DXImageTransform.Microsoft.gradient (    
		startColorstr = 
		 '#b2b2b2', endColorstr =   '#f2f2f2', GradientType =   1 );*/
	
}

.graph_invert {
	background: #d7ecfb; 
	/*background: -moz-linear-gradient(left, #f2f2f2 0%, #b2b2b2 100%, #eaeaea 100%,
		#b2b2b2 100%); 
	background: -webkit-linear-gradient(left, #f2f2f2 0%, #b2b2b2 100%, #eaeaea 100%,
		#b2b2b2 100%); 
	background: linear-gradient(to right, #f2f2f2 0%, #b2b2b2 100%, #eaeaea 100%,
		#b2b2b2 100%); 
	filter: progid :   DXImageTransform.Microsoft.gradient (    
		startColorstr = 
		 '#b2b2b2', endColorstr =   '#f2f2f2', GradientType =   1 );*/
	
}

.graph_detail p {
	text-align: justify;
	font-size: 13px;
	line-height: 18px;
	margin: 0px;
}

.graph_detail h4 {
	font-size: 14px;
	font-weight: bold;
	line-height: 18px;
	margin-bottom: 5px;
}

.graph_stat {
	display: block;
	width: 100%; 
	background-color:#d6eaf8; 
	/*background: -moz-radial-gradient(center, ellipse cover, rgba(178, 178, 178, 1)
		0%, rgba(255, 255, 255, 1) 100% ); 
	background: -webkit-radial-gradient(center, ellipse cover, rgba(178, 178, 178, 1)
		0%, rgba(255, 255, 255, 1) 100% ); 
	background: radial-gradient(ellipse at center, rgba(178, 178, 178, 1) 0%,
		rgba(255, 255, 255, 1) 100% );
	filter: progid :   DXImageTransform.Microsoft.gradient (    
		startColorstr = 
		 '#b2b2b2', endColorstr =   '#ffffff', GradientType =   1 );*/
}

.p_b_0 {
	margin-bottom: 1% !important;
}
</style>
		<?php
		error_reporting(0);
		//  echo '<pre />';
		//  print_r($salary_dtls);
		//
		?>
<div class="page-breadcrumb">
<div class="col-md-4">
<ol class="breadcrumb container">
	<li><a href="<?php echo base_url("manager/self"); ?>">My Self</a></li>
	<li class="active">Total Rewards Statement</li>
</ol>
</div>
</div>
<div id="popoverlay" class=" popoverlay"></div>
<div class="bg">
<div class="container card-2 newcard"
	style="padding: 11px 22px !important;">
<div class="row">
<div class="col-sm-12">
<div class="headingg">
<h4>Total Rewards Statement (In Local Currency)</h4>
</div>
</div>

<div class="col-sm-3"><?php 
if(!empty($graph_txt_dtls['left_half'])){
	$leftData   = json_decode($graph_txt_dtls['left_half']);

	$lefttop    = str_replace("'","",$leftData->top_left);
	$lefttop    = str_replace('"',"",$lefttop);

	$leftcenter = str_replace("'","",$leftData->center_left);
	$leftcenter    = str_replace('"',"",$leftcenter);


	$leftbottom    = str_replace("'","",$leftData->bottom_left);
	$leftbottom    = str_replace('"',"",$leftbottom);
	?>
<div class="graph_detail " data-tcontent="<?php echo $lefttop;?>"><?php 
echo $lefttop;
$string = (strlen($lefttop) > 260) ? substr($lefttop,0,260).'...' : $lefttop;
//echo $string;
?>
<div class="hide_grd"></div>
</div>

<div class="graph_detail " data-tcontent="<?php echo $leftcenter;?>"><?php echo $leftcenter; ?>
<div class="hide_grd"></div>
</div>

<div class="graph_detail p_b_0"
	data-tcontent="<?php echo $leftbottom;?>"><?php echo $leftbottom;?>
<div class="hide_grd"></div>
</div>
<?php } ?></div>
<div class="col-sm-6">
<div class="graph_stat">
<div id="container" class="pie" style="height: 68.3vh; padding-top: 4%;"></div>
<div class="total_salary">
<div class="info">
<h4><?php $total=0;
foreach($attr as $at)
{
	if($at['value']!='')
	{
		$total=$total+ $at["value"];

	}
}
$total_amount = HLP_get_formated_amount_common($total,0);

// echo $total_amount;
?></h4>
</div>
</div>
</div>
</div>
<div class="col-sm-3 git "><?php 
if(!empty($graph_txt_dtls['right_half'])){
	$rightData = json_decode($graph_txt_dtls['right_half']);

	$righttop    = str_replace("'","",$rightData->top_right);
	$righttop    = str_replace('"',"",$righttop);

	$rightcenter = str_replace("'","",$rightData->center_right);
	$rightcenter    = str_replace('"',"",$rightcenter);

	$rightbottom    = str_replace("'","",$rightData->bottom_right);
	$rightbottom    = str_replace('"',"",$rightbottom);
	?>
<div class="graph_detail graph_invert"
	data-tcontent="<?php echo $righttop;?>"><?php echo $righttop;?>
<div class="hide_grd2"></div>
</div>

<div class="graph_detail graph_invert"
	data-tcontent="<?php echo $rightcenter;?>"><?php echo $rightcenter;?>
<div class="hide_grd2"></div>
</div>

<div class="graph_detail graph_invert p_b_0"
	data-tcontent="<?php echo $rightbottom;?>"><?php echo $rightbottom;?>
<div class="hide_grd2"></div>
</div>
	<?php } ?></div>
</div>

</div>

</div>
</div>

<!-- Modal -->
<div class="modal fade" id="donatModal" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Content</h5>
<button type="button" class="close" data-dismiss="modal"
	aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="donatModal_body">...</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<script
	src="<?php echo base_url('assets/chartjs') ?>/js/highchart.js"></script>
<script
	src="<?php echo base_url('assets/chartjs') ?>/js/exporting.js"></script>
<script
	src="<?php echo base_url('assets/chartjs') ?>/js/export-data.js"></script>
<script
	src="<?php echo base_url('assets/chartjs') ?>/js/highchart3d.js"></script>
<!-- this library is used two times in this pages  -->
<!-- <script src="https://code.highcharts.com/highcharts-3d.js"></script> -->

<script>
    $(document).ready(function(){
        $('.graph_detail').click(function(){
            var cdata = $(this).data('tcontent');
            if(cdata.length > 10) {
                $('#donatModal_body').empty();
                $('#donatModal_body').html(cdata);
                $('#donatModal').modal('show');
            }
            
        });
    });
    var pieColors = (function () {
        var colors = [];
        colors =['#ADD8E6',
                '#6495ED',
                '#4682B4',
                '#4169E1',
                '#191970',
                '#87CEFA',
                '#87CEEB',
                '#00BFFF',
                '#B0C4DE',
                '#1E90FF',
                '#633EBB',
                '#BE61CA',
                '#FFEC21',
                '#93F03B'
            ];
        return colors;
    }());
 // Radialize the colors
 
			
    Highcharts.setOptions(
    		
    	    {
    	    	 lang: {
    	        thousandsSep: ','
    	    },
        colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        })
    });
    Highcharts.chart('container', {
        
         chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            events:{
              
                load: addTitle,
                redraw: addTitle,
                
                
            },
            height: 400,
            type: 'pie',
            style: {
            	fontFamily: 'Century Gothic',
            	color: "#000",
            	fontSize: '15px'
            }
        },
//            {
//            height: 400,
//            type: 'pie',
//            events:{
//                // load:function(){
//                //     var chart = this,
//                //     series = chart.series[0],
//                //     firstPoint = series.data[0].y,
//                //     nextPoint = series.data[1].y,
//                //     percent = (firstPoint / (firstPoint + nextPoint)) * 100,
//                //     value = 0;
//                // chart.setTitle({
//                //     text: 'Total Amount : <?php //echo $total_amount; ?>',useHTML:true
//                //     });
//                // }
//                load: addTitle,
//                redraw: addTitle,
//                
//            },
//            options3d: {
//                enabled: true,
//                alpha: 40
//            }
//        },

        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },

//        plotOptions: {
//            pie: {
//                dataLabels: {
//                    distance: -30
//                }
//            }
//        },
        plotOptions: {
            pie: {
                //innerSize: 140,
              //  depth: 45,
              
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    distance: 5,
                    enabled: true,
                    color: '#000000',
                    connectorWidth: 1,
                    useHTML: true,
                    format: '</b></span>{point.percentage:.0f}%</span>',
                    /*format: '<b>{point.y} </b><span>&#40</span>{point.percentage:.0f}%<span>&#41;</span>',*/
//                    
//                    formatter: function () {
//                        return Highcharts.numberFormat(this.point.y, 0, '.', ',');
//                    },
                },
                showInLegend: true,
                // allowPointSelect: true,
                // cursor: 'pointer',
                // dataLabels: { enabled: false },
            }
        },
        
        tooltip: {
            pointFormat: "Percentage: <b>{point.percentage:.0f}%</b>"
        },
        series: [{
            name: 'Amount',
           

            data: [
                <?php

                $val="";
                foreach($attr as $at)
                {
                    if($at['value'])
                    {   
                    	$partial_elmt_val = $at['value'];
						//$per_val = ($at['value']/$total)*100;
						//$val.= $at["display_name"];
                        //$val.= "['".$at["display_name"]." (".HLP_get_formated_percentage_common($per_val,0)."%)',".$at["value"]."],";

                        $val.= "['".$at["display_name"]." (".HLP_get_formated_percentage_common($partial_elmt_val,0).")',".$at["value"]."],";
                        
                    }
                }
                echo rtrim($val,',');
                ?>
            ]
        }]
    });
    function addTitle() {
        if (this.title) {
            this.title.destroy();
        }

        var r = this.renderer,
            x = this.series[0].center[0] + this.plotLeft,
            y = this.series[0].center[1] + this.plotTop;
        var amt_center = '<?php echo $total_amount;?>';
        this.title = r.text(amt_center, 0, 0)
            .css({
            color: '#000',
            fontSize: '16px',
            fontWeight: '800',
        }).hide().add();

        var bbox = this.title.getBBox();
        this.title.attr({
            x: x - (bbox.width / 2),
            y: y + 5
        }).show();
    }

</script>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  -->
<!-- <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawdontpie);

      function drawdontpie() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Salary Components'],
          //['Work',     11],
          <?php /*
            $val="";
                foreach($attr as $at)
                {
                    if($at['value'])
                    {
                        $val.= "['".$at["display_name"]."',".$at["value"]."],";
                        
                    }
                }
                echo rtrim($val,',');
               */
          
          ?>
        ]);

		if(window.innerWidth <=550) {
        var width = 300,
	    height = 300;
       } else {
        var width = 570,
	    height = 570;
       }
	   
        var options = {
          //title: 'Salary Components',
          pieHole: 0.4,
          //pieSliceText: 'value-and-percentage',
		  backgroundColor: 'transparent',
		  pieSliceText: 'label',
		  width:width,
		  height:height,
          pieSliceTextStyle: {
            color: '#fff',
            rotate: '90deg'
          },
		  legend: {position: 'none'},
         // legend: 'bottom',
          chartArea : {left:10,top:30,width:"90%",height:"80%"}
          
           
        };

        var chartt = new google.visualization.PieChart(document.getElementById('pie'));
        
        chartt.draw(data, options);
      }


    </script>  -->
