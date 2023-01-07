 <div id="comparison_with_team_<?php echo $uid; ?>"></div>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithTeam_<?php echo $uid; ?>);
	function drawComparisonWithTeam_<?php echo $uid; ?>(gheight = 330,action='direct')
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
			if(!helper_have_rights(CV_COMPARISON_WITH_TEAM_CHART, CV_VIEW_RIGHT_NAME))
				{ ?>					
					 $("#comparison_with_team_<?php echo $uid; ?>").html("<br><p style='font-size: 15px;font-weight: bold;color: #74767D;text-align: center; margin-top: 10px;'><?php echo $salary_dtls["name"]; ?></p> <br/>You have no rights to view this chart");
						// $("#comparison_with_team").css("text-align","center");
						 $("#comparison_with_team_<?php echo $uid; ?>").css("height","330px");
						 $("#comparison_with_team_<?php echo $uid; ?>").css("background","#FFFFFF");
						 $("#comparison_with_team_<?php echo $uid; ?>").removeClass("chart");
				<?php }
			else { ?>
				var data = google.visualization.arrayToDataTable([
				 //['Employee','Salary','Mysal', {'type': 'string', 'role': 'annotation'}],
				 ['Employee','<?php echo $salary_dtls["name"]; ?> Salary','Team Salary', {'type': 'string', 'role': 'annotation'}],
				 <?php $p=1; $emp_sal = $salary_dtls[$graph_for."_salary"];
				 
					foreach($graph_dtls as $value)
					{ 			 	
						$team_emp_sal = $value[$graph_for."_salary"];		
						if(!$team_emp_sal)
						{
							continue;
						}	
						echo "['".$value["name"]."' , ".str_replace(",","",$emp_sal).", ".str_replace(",","",$team_emp_sal).",'".HLP_get_formated_amount_common(str_replace(",","",$team_emp_sal))."'],"; 
						$p++;
					 }
				 ?>
				]);
				if(action==="click")
				{
					var options = {
						title:'<?php echo $salary_dtls["name"]; ?>',
						height:gheight,
						pointSize: 6,
						annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
						titleTextStyle: {
							color: '#74767D',
							fontSize: 18					
						},
						hAxis: {
						   title: 'Team Members',
						   slantedText:true, slantedTextAngle:22, // here you can even use 180
						   //textPosition: posi
						},
						legend: {position: 'right', textStyle: {fontSize: 11}},//{position: 'none'},
						vAxis: {
						   title: 'Salary'
						},
						series: {
							  0: { pointSize: 0, color: '#a52714' },
							  1: { color: '#3366cc' },
						}
					};
				}
				else {
					var options = {
						title:'<?php echo $salary_dtls["name"]; ?>',
						height:gheight,
						pointSize: 6,
						annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
						titleTextStyle: {
							color: '#74767D',
							fontSize: 16
							
						},
						backgroundColor: { 
							  fill: '#FFF',
							  fillOpacity: 0.8
						 },
						 hAxis: {
						   title: 'Team Members',
						   slantedText:true, slantedTextAngle:45, // here you can even use 180
						   textPosition: posi
						 },
						 legend: {position: 'bottom'},//{position: 'none'},
						 vAxis: {
						   title: 'Salary'
						 },
						 series: {
							  0: { pointSize: 0, color: '#a52714' },
							  1: { color: '#3366cc' },
						 }
					};
				}
				var chart = new google.visualization.LineChart(document.getElementById('comparison_with_team_<?php echo $uid; ?>'));
				chart.draw(data, options);
				var h=$( '#comparison_with_team_<?php echo $uid; ?>' ).height();
					$('.cwt').css('margin-top','-'+(parseInt(h))+'px');
					$('.cwt').css('position','absolute');
					$('.cwt').html('<img src="'+chart.getImageURI()+'" />');
				if(gheight == 200)
				{
					$("#comparison_with_team_<?php echo $uid; ?>").append('<div style="position: absolute;right: 3%;bottom: 44%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
				}
	<?php } } else{ ?>
			$("#comparison_with_team_<?php echo $uid; ?>").html("<br><p style='font-size: 15px;font-weight: bold; color: #74767D;text-align: center; margin-top: 10px;'><?php echo $salary_dtls["name"]; ?></p> <br/>No record found.");
			// $("#comparison_with_team").css("text-align","center");
			 $("#comparison_with_team_<?php echo $uid; ?>").css("height","330px");
			 $("#comparison_with_team_<?php echo $uid; ?>").css("background","#FFFFFF");
			 $("#comparison_with_team_<?php echo $uid; ?>").removeClass("chart");
	<?php } ?>
		//setGraphHeaderStyles();
	}
	
	$('#comparison_with_team_<?php echo $uid; ?>').on('click',function(e){
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
                drawComparisonWithTeam_<?php echo $uid; ?>("75%","click");
                //setGraphHeaderStyles();
				setGraphHeaderStyles("45");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawComparisonWithTeam_<?php echo $uid; ?>();
                arrangeBottomCharts();
            }
            
        });
		
	drawComparisonWithTeam_<?php echo $uid; ?>();
</script> 
