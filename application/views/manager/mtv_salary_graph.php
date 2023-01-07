<div id="dv_salary_graph_<?php echo $uid; ?>"></div>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart', 'bar']});
google.charts.setOnLoadCallback(drawSalaryMovementChart_<?php echo $uid; ?>);

function drawSalaryMovementChart_<?php echo $uid; ?>(gheight = 330,action='direct') 
{
		var posi = 'none';//'out';
		var showlbl = 0;//1;
		if(gheight == 330)
		{
			showlbl = 0;
			posi = 'none';
		}
		//textPosition: posi
	<?php if(count($graph_dtls) > 1)
		  {
				if(!helper_have_rights(CV_SALARY_MOVEMENT_CHART, CV_VIEW_RIGHT_NAME))
				{ ?>
					$("#dv_salary_graph_<?php echo $uid; ?>").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'><?php echo $salary_dtls["name"]; ?></p>You have no rights to view this chart");
				   // $("#salary_movement_chart").css("text-align","center");
					$("#dv_salary_graph_<?php echo $uid; ?>").css("height","300px");
					$("#dv_salary_graph_<?php echo $uid; ?>").css("background","#FFFFFF");
					$("#dv_salary_graph_<?php echo $uid; ?>").removeClass("chart");
				<?php }
				else { ?>
				var data = google.visualization.arrayToDataTable([
				['Year', 'Salary', {'type': 'string', 'role': 'annotation'}, {'type': 'string', 'role': 'style'}],
				<?php $idSMC = 0; foreach($graph_dtls as $value) { 
				$user_sal_val = 0;
				if($value["value"])
				{
						$user_sal_val = $value["value"];
				}
				if($user_sal_val <= 0)
				{
					continue;
				}
				echo "['".str_replace("increase","",str_replace("Salary after","",$value["display_name"]))."',".str_replace(",","",$user_sal_val).",'".HLP_get_formated_amount_common(str_replace(",","",$user_sal_val))."',''],"; 
						
		}
		//echo "['Current Year',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",'".number_format($salary_dtls["increment_applied_on_salary"], 0, '.', ',')."','point {fill-color: #a52714; font-weight:bold; }'],";
		?>
	]);
			//data.addColumn({type: 'string', role: 'annotation'});
			
			if(action=="click")
			{
			   var options = 
			   {
					//tooltip: {trigger: 'none'},
					//annotation: { 1: {style: 'none'}},
					//width:450,						
					pointSize: 6,
					annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
					titleTextStyle: 
					{
						color: '#74767D',
						fontSize: 15
					},
					height:gheight,
					title:'<?php echo $salary_dtls["name"]; ?>',
					//pointSize: 4,
					/*chartArea:{
						//left:20,
						//top:0,
						//width:'50%',
						//height:'90%'
					},
					explorer: {
						maxZoomOut:2,
						keepInBounds: true
					},*/
					hAxis: {
						title: 'Year (Salary after nth increment)',
						count: 1, 
						viewWindowMode: 'pretty', 
						slantedText:true, 
						slantedTextAngle:22, // here you can even use 180
						//textPosition: posi
						},
					legend: {position: 'none'},
					vAxis: {
				  		title: 'Salary',
							  
					},
					series: {
						0: { pointSize: 6,color: '#3366cc' },
						//1: { pointSize: 6,color: '#a52714' },
					},
					
				   // curveType: 'function'
		
				}; 
			}
			else
			{
				var options = 
				{
					//backgroundColor: { fill:'transparent' }
					//tooltip: {trigger: 'none'},
					//annotation: { 1: {style: 'none'}},
					//width:450,	
					backgroundColor: { 
						  fill: '#FFF',
						  fillOpacity: 0.8
					},
					pointSize: 6,
					annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
					titleTextStyle:
					{
						color: '#74767D',
						fontSize: 15
					},
					height:gheight,
					title:'<?php echo $salary_dtls["name"]; ?>',
					//pointSize: 4,
					/*chartArea:{
						//left:20,
						//top:0,
						//width:'50%',
						//height:'90%'
					},
					explorer: {
						maxZoomOut:2,
						keepInBounds: true
					},*/
					hAxis: {
						title: 'Year (Salary after nth increment)',
						count: 1, 
						viewWindowMode: 'pretty', 
						slantedText:true, slantedTextAngle:45, // here you can even use 180
						textPosition: posi
					},
					legend: {position: 'none'},
					vAxis: {
						title: 'Salary',
					},
					series: {
						0: { pointSize: 6,color: '#3366cc' },
						//1: { pointSize: 6,color: '#a52714' },
					},
			 		// curveType: 'function'
		
				};
			}
			var chart = new google.visualization.LineChart(document.getElementById('dv_salary_graph_<?php echo $uid; ?>'));
			chart.draw(data, options);
			var h=$( '#dv_salary_graph_<?php echo $uid; ?>' ).height();
			$('.smc').css('margin-top','-'+(parseInt(h)+65)+'px');
			$('.smc').css('position','absolute');
			$('.smc').html('<img src="'+chart.getImageURI()+'" />');
			if(gheight == 200)
			{
				$("#dv_salary_graph_<?php echo $uid; ?>").append('<div style="position: absolute;right: 4%;top: 7%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
			}
	<?php } }
		else{ ?>
			$("#dv_salary_graph_<?php echo $uid; ?>").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'><?php echo $salary_dtls["name"]; ?></p>No record found.");
			//$("#salary_movement_chart").css("text-align","center");
			$("#dv_salary_graph_<?php echo $uid; ?>").css("height","300px");
			$("#dv_salary_graph_<?php echo $uid; ?>").css("background","#FFFFFF");
			$("#dv_salary_graph_<?php echo $uid; ?>").removeClass("chart");
		<?php }  ?>
}

$('#dv_salary_graph_<?php echo $uid; ?>').on('click',function(e){
		if(!$("#popoverlay").is(':visible')){
			$('#popoverlay').show();
			$(this).css({
				width:"90%",
				height:"75%",
				margin:"0",
				border:"none",
				left:"5%",
				top:"15%",
				position:"fixed",
				"z-index":"10"
			});

			drawSalaryMovementChart_<?php echo $uid; ?>("75%","click");
			setGraphHeaderStyles("45");
		}
		else
		{
			$('#popoverlay').hide();
			$(this).html("");
			$(this).removeAttr("style");
			drawSalaryMovementChart_<?php echo $uid; ?>();
			setGraphHeaderStyles();
		}            
	});

drawSalaryMovementChart_<?php echo $uid; ?>();	
</script> 
