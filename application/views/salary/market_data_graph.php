<div id="current_market_positioning" class="chart topchart"></div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>  -->
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart','bar']});
	google.charts.setOnLoadCallback(drawCurrentMarketPositioning);
	function drawCurrentMarketPositioning(gheight = 295,action='direct')
	{
		var posi = 'none';//'default';
		var showlbl = 0;//1;
		if(gheight == 295)
		{
			showlbl = 0;
			posi = 'none';
		}
		//textPosition: posi
		
		var txt_mrgn = 15;
		if(gheight != 295)
		{
			txt_mrgn = 5;
		}
		
	<?php if(count($makt_salary_graph_dtls) > 1){
			if(!helper_have_rights(CV_CURRENT_MARKET_POSITIONING_CHART, CV_VIEW_RIGHT_NAME))
			{ ?>
				//$("#current_market_positioning").html("<br><p style='font-size: 12px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Comparison with target pay range</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
				$("#current_market_positioning").html("<br><p style='font-size: 12px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Target Pay Comparison</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
				$("#current_market_positioning").css("text-align","center");
				$("#current_market_positioning").css("height","295px");
				$("#current_market_positioning").css("background","#FFFFFF");
				$("#current_market_positioning").removeClass("chart");
	<?php } else { ?>
			<?php /*?>var data = google.visualization.arrayToDataTable([
			['%tile','<?php echo $salary_dtls["name"]; ?> Salary','Revised Salary','Market Salary', {'type': 'string', 'role': 'annotation'}],<?php */?>
			var data = google.visualization.arrayToDataTable([
			['%tile','Current', {'type': 'string', 'role': 'tooltip', 'p': {'html': true}},'Revised',{'type': 'string', 'role': 'tooltip', 'p': {'html': true}},'Pay Range',{'type': 'string', 'role': 'tooltip', 'p': {'html': true}}, {'type': 'string', 'role': 'annotation'}],
			<?php 
			$current_salary = HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]);
			$revised_current_salary = HLP_get_formated_amount_common($salary_dtls["final_salary"]);
			foreach($makt_salary_graph_dtls as $value) { 
				$mrkt_val = 0;
				if($value["value"])
				{
					$mrkt_val = HLP_get_formated_amount_common($value["value"]);
				}
				if($mrkt_val <= 0 or !strpos($value["ba_name"], strtolower($graph_for)))
				{
					continue;
				}


                $payrange_sal_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span> Pay Range : <b>'.$mrkt_val.'</b></span></div> ';

				$revised_sal_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span> Revised : <b> '.$revised_current_salary.'</b></span></div> ';

                $current_sal_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span> Current : <b>'.$current_salary.'</b></span></div>';




				echo "['".$value["display_name"]."', ".str_replace(",","",$current_salary).",'$current_sal_tool', ".str_replace(",","",$revised_current_salary).", '$revised_sal_tool', ".str_replace(",","",$mrkt_val).", '$payrange_sal_tool' , '".$mrkt_val."'],";
			}               
			?>
		]);
		if(action=="click")
		{
			var options = {
				//title:'Comparison with target pay range',
				title:'Target Pay Comparison',
				//width:500,
				height:gheight,
				fontName: 'Century Gothic Regular',
				fontSize: 14,
				tooltip: { isHtml: true },
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#000',
					fontSize: 18
				},
				//pointSize: 6,
				/*explorer: {
					maxZoomOut:2,
					keepInBounds: true
				},
				chartArea: {
					backgroundColor: {
						stroke: '#000',
						strokeWidth: 1
					}
				},*/                        
				chartArea:{
						left:100,
						//top:'20%',
						width:'88%',
						//height:'90%'
					},
				hAxis: {
				  //title: 'Pay range for the position',
				  slantedText:true,
				  slantedTextAngle:22, // here you can even use 180
				  //textPosition: posi
				  textStyle : {
                             fontSize: 14 
                             }
				},
				legend: {position: 'top', alignment: 'end', textStyle: {fontSize: 13}},//{position: 'none'},
				vAxis: {
				  title: 'Salary'
				},
				series: {
					0: { color: '#a52714' },
					1: { color: '#008000' },
					2: { pointSize: 6,color: '#3366cc' },
					
				},
				//curveType: 'function'
			};  setTimeout(function(){ setGraphHeaderStyles(); }, 50);        
		}
		else {
				var options = {

				//title:'Comparison with target pay range',
				title:'Target Pay Comparison',
				//width:500,
				height:gheight,
				fontName: 'Century Gothic Regular',
				tooltip: { isHtml: true },
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#000',
					fontSize: 13
				},
				backgroundColor: { 
					  fill: '#FFF',
					  fillOpacity: 0.8
				  },
				//pointSize: 6,
				/*explorer: {
					maxZoomOut:2,
					keepInBounds: true
				},
				chartArea: {
					backgroundColor: {
						stroke: '#000',
						strokeWidth: 1
					}
				},*/  
				 chartArea:{
						left:80,
						//top:'20%',
						width:'75%',
						//height:'90%'
					},

				hAxis: {
						 textStyle: {color: 'black'},
			        titleTextStyle: {color: 'black'},	

				  //title: 'Pay range for the position',
				  //viewWindowMode: 'pretty', 
				  slantedText:true, slantedTextAngle:45, // here you can even use 180
				},
				legend: {position: 'bottom',alignment: 'center', textStyle: {fontSize: 10, fontName: 'Century Gothic Regular'}},//{position: 'none'},
				vAxis: {
				  title: 'Salary'
				},
				series: {
					0: { color: '#a52714' },
					1: { color: '#008000' },
					2: { pointSize: 6,color: '#3366cc' },
					
				},
				//curveType: 'function'
			};    setTimeout(function(){ setGraphHeaderStyles(); }, 50);      
		}
			var chart = new google.visualization.LineChart(document.getElementById('current_market_positioning'));
			chart.draw(data, options);
			 var h=$( '#current_market_positioning' ).height();
			$('.cmp').css('margin-top','-'+(parseInt(h)+65)+'px');
			$('.cmp').css('position','absolute');
			$('.cmp').html('<img src="'+chart.getImageURI()+'" />');
			if(gheight == 200)
			{
				$("#current_market_positioning").append('<div style="position: absolute;right: 5%;top: 9%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
			}
		<?php }}else{
			if(!helper_have_rights(CV_CURRENT_MARKET_POSITIONING_CHART, CV_VIEW_RIGHT_NAME))
		{ ?>
			//$("#current_market_positioning").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Comparison with target pay range</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
			$("#current_market_positioning").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Target Pay Comparison</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
		    $("#current_market_positioning").css("text-align","center");
			$("#current_market_positioning").css("height","295px");
			$("#current_market_positioning").css("background","#FFFFFF");
			$("#current_market_positioning").removeClass("chart");
		<?php } else { ?>
$("#current_market_positioning").html("<br><p style='font-size: 13px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Comparison with target pay range</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>No record found.</p>");
	   //$("#current_market_positioning").css("text-align","center");
	   $("#current_market_positioning").css("height","295px");
	   $("#current_market_positioning").css("background","#FFFFFF");
	   $("#current_market_positioning").removeClass("chart");
		<?php } }?>
	}
	       
	drawCurrentMarketPositioning();
</script> 
