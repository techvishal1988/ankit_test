<div id="current_market_positioning_<?php echo $uid; ?>" class="chart topchart"></div> 
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawCurrentMarketPositioning_<?php echo $uid; ?>);
	function drawCurrentMarketPositioning_<?php echo $uid; ?>(gheight = 330,action='direct')
	{
		var posi = 'none';//'default';
		var showlbl = 0;//1;
		if(gheight == 330)
		{
			showlbl = 0;
			posi = 'none';
		}
		//textPosition: posi
	<?php if(count($graph_dtls) > 1){
			if(!helper_have_rights(CV_CURRENT_MARKET_POSITIONING_CHART, CV_VIEW_RIGHT_NAME))
			{ ?>
				$("#current_market_positioning_<?php echo $uid; ?>").html("<br><p style='font-size: 12px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'><?php echo $salary_dtls["name"]; ?></p> <br/>You have no rights to view this chart.");
				//$("#current_market_positioning").css("text-align","center");
				$("#current_market_positioning_<?php echo $uid; ?>").css("height","330px");
				$("#current_market_positioning_<?php echo $uid; ?>").css("background","#FFFFFF");
				$("#current_market_positioning_<?php echo $uid; ?>").removeClass("chart");
	<?php } else { ?>
			var data = google.visualization.arrayToDataTable([
			['%tile','Current Salary','Market Salary', {'type': 'string', 'role': 'annotation'}],
			<?php foreach($graph_dtls as $value) { 
				$mrkt_val = 0;
				if($value["value"])
				{
					$mrkt_val = $value["value"];
				}
				if($mrkt_val <= 0 or !strpos($value["ba_name"], strtolower($graph_for)))
				{
					continue;
				}

				echo "['".$value["display_name"]."',".str_replace(",","",$salary_dtls[$graph_for."_salary"]).",".str_replace(",","",$mrkt_val).",'".HLP_get_formated_amount_common(str_replace(",","",$mrkt_val))."'],";
			}

               //echo "[' ',".str_replace(",","",$salary_dtls[$graph_for."_salary"]).",null,'".number_format(str_replace(",","",$salary_dtls[$graph_for."_salary"]), 0, '.', ',')."'],";
			?>
		]);
		if(action=="click")
		{
			var options = {
				title:'<?php echo $salary_dtls["name"]; ?>',
				//width:500,
				height:gheight,
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#74767D',
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
				
				hAxis: {
				  title: 'Market pay range for the position',
				  slantedText:true,
				  slantedTextAngle:22, // here you can even use 180
				  //textPosition: posi
				},
				legend: {position: 'right', textStyle: {fontSize: 11}},//{position: 'none'},
				vAxis: {
				  title: 'Salary'
				},
				series: {
					0: { color: '#a52714' },
					1: { pointSize: 6,color: '#3366cc' },
					
				},
				//curveType: 'function'
			};          
		}
		else {
				var options = {
				title:'<?php echo $salary_dtls["name"]; ?>',
				//width:500,
				height:gheight,
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#74767D',
					fontSize: 15
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
				hAxis: {
				  title: 'Market pay range for the position',
				  slantedText:true, slantedTextAngle:45, // here you can even use 180
				  textPosition: posi
				},
				legend: {position: 'bottom'},//{position: 'none'},
				vAxis: {
				  title: 'Salary'
				},
				series: {
					0: { color: '#a52714' },
					1: { pointSize: 6,color: '#3366cc' },
					
				},
				//curveType: 'function'
			};          
		}
			var chart = new google.visualization.LineChart(document.getElementById('current_market_positioning_<?php echo $uid; ?>'));
			chart.draw(data, options);
			 var h=$( '#current_market_positioning_<?php echo $uid; ?>' ).height();
			$('.cmp').css('margin-top','-'+(parseInt(h)+65)+'px');
			$('.cmp').css('position','absolute');
			$('.cmp').html('<img src="'+chart.getImageURI()+'" />');
			if(gheight == 200)
			{
				$("#current_market_positioning_<?php echo $uid; ?>").append('<div style="position: absolute;right: 5%;top: 9%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
			}
		<?php }}else{
			if(!helper_have_rights(CV_CURRENT_MARKET_POSITIONING_CHART, CV_VIEW_RIGHT_NAME))
		{ ?>
			$("#current_market_positioning_<?php echo $uid; ?>").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'><?php echo $salary_dtls["name"]; ?></p> <br/>You have no rights to view this chart.");
			//$("#current_market_positioning").css("text-align","center");
			$("#current_market_positioning_<?php echo $uid; ?>").css("height","300px");
			$("#current_market_positioning_<?php echo $uid; ?>").css("background","#FFFFFF");
			$("#current_market_positioning_<?php echo $uid; ?>").removeClass("chart");
		<?php } else { ?>
$("#current_market_positioning_<?php echo $uid; ?>").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'><?php echo $salary_dtls["name"]; ?></p> <br/> No record found.");
	   //$("#current_market_positioning").css("text-align","center");
	   $("#current_market_positioning_<?php echo $uid; ?>").css("height","300px");
	   $("#current_market_positioning_<?php echo $uid; ?>").css("background","#FFFFFF");
	   $("#current_market_positioning_<?php echo $uid; ?>").removeClass("chart");
		<?php } }?>
	}
	
	$('#current_market_positioning_<?php echo $uid; ?>').on('click',function(e)
	{
		if(!$("#popoverlay").is(':visible')){
			$('#popoverlay').show();
			$(this).css({
				width:"90%",
				height:"75%",
				margin:"0",
				border:"none",
				position:"fixed",
				left:"5%",
				top:"15%",
				"z-index":"10"
			});
			drawCurrentMarketPositioning_<?php echo $uid; ?>("75%","click");
			setGraphHeaderStyles("45");
		}
		else
		{
			$('#popoverlay').hide();
			$(this).html("");
			$(this).removeAttr("style");
			drawCurrentMarketPositioning_<?php echo $uid; ?>();
			setGraphHeaderStyles();
		}		
	});
		 
	drawCurrentMarketPositioning_<?php echo $uid; ?>();
</script> 
