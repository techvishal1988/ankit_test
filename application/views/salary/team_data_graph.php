 <div id="comparison_with_team" class="chart bottomchart" style="font-family:'Century Gothic Regular';">
 </div>
<?php /*?><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script> <?php */?>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithTeam);
	function drawComparisonWithTeam(gheight = 295,action='direct')
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
		
		<?php if(count($team_salary_graph_dtls) > 1){ 
			if(!helper_have_rights(CV_COMPARISON_WITH_TEAM_CHART, CV_VIEW_RIGHT_NAME))
				{ ?>
					
					 $("#comparison_with_team").html("<br><p style='font-size: 15px;font-weight: bold;color: #74767D;text-align: center; margin-top: 10px;'>Comparison with Team</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
						// $("#comparison_with_team").css("text-align","center");
						 $("#comparison_with_team").css("height","295px");
						 $("#comparison_with_team").css("background","#FFFFFF");
						 $("#comparison_with_team").removeClass("chart");
					<?php }
				else { ?>
		<?php /*?>var data = google.visualization.arrayToDataTable([
		 //['Employee','Salary','Mysal', {'type': 'string', 'role': 'annotation'}],
		 ['Employee','<?php echo $salary_dtls["name"]; ?> Salary','Revised Salary','Team Salary', {'type': 'string', 'role': 'annotation'}],<?php */?>
		 var data = google.visualization.arrayToDataTable([
		  ['Employee','Current', {'type': 'string', 'role': 'tooltip', 'p': {'html': true}},'Revised', {'type': 'string', 'role': 'tooltip', 'p': {'html': true}},'Team Range', {'type': 'string', 'role': 'tooltip', 'p': {'html': true}}, 'Team Revised Range', {'type': 'string', 'role': 'tooltip', 'p': {'html': true}}],
		 <?php $p=1; //$emp_sal = $salary_dtls[$graph_for."_salary"];
		 	$current_salary = HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]);
			$revised_current_salary = HLP_get_formated_amount_common($salary_dtls["final_salary"]);
		 	foreach($team_salary_graph_dtls as $value)
			{ 			 	
				$team_emp_sal = HLP_get_formated_amount_common($value[$graph_for."_salary"]);		
				if(!$team_emp_sal)
				{
					continue;
				}	
				$team_emp_revised_sal = HLP_get_formated_amount_common($value["emp_revised_salary"]);

                $current_salary_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span> Current : <b>'.$current_salary.'</b></span></div> ';

				$team_employee_sal_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span>  <b>'  .$value["name"].'</b> <br> Salary : <b> '.$team_emp_sal.'</b></span></div> ';
				
				$team_employee_revised_sal_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span>  <b>'  .$value["name"].'</b> <br>Team Revised Salary : <b> '.$team_emp_revised_sal.'</b></span></div> ';

                $revised_current_salary_tool = '<div style="padding:5px; white-space: nowrap; font-size:12px !important; color:#000;"><span> Revised : <b>'.$revised_current_salary.'</b></span></div> ';

				echo "['".$value["name"]."' , ".str_replace(",","",$current_salary).", '$current_salary_tool', ".str_replace(",","",$revised_current_salary).", '$revised_current_salary_tool', ".str_replace(",","",$team_emp_sal).", '$team_employee_sal_tool', ".str_replace(",","",$team_emp_revised_sal).", '$team_employee_revised_sal_tool'],"; 
				$p++;
			 }
			//echo "['Current Salary', ".str_replace(",","",$emp_sal).", null,'".number_format(str_replace(",","",$emp_sal), 0, '.', ',')."'],";
		 ?>
		]);
		if(action==="click")
		{
			var options = {
				title:'Comparison with Team',
				height:gheight,
				pointSize: 6,
				fontName: 'Century Gothic Regular',
				fontSize: 14,
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#000',
					fontSize: 18					
				},
				tooltip: { isHtml: true },
				chartArea:{
						left:100,
						//top:'20%',
						width:'88%',
						//height:'90%'
					},
				hAxis: {
				   title: 'Team Members',
				   slantedText:true, slantedTextAngle:22, // here you can even use 180
				   //textPosition: posi
				   textStyle : {
                             fontSize: 14 
                             }
				},
				legend: {position: 'top',alignment: 'end', textStyle: {fontSize: 13}},//{position: 'none'},
				vAxis: {
				   title: 'Salary'
				},
				series: {
					  0: { pointSize: 0, color: '#a52714' },
					  1: {  pointSize: 0, color: '#008000' },
					  2: { color: '#3366cc' },
					  3: { color: '#FF6600' },
				}
			};
			setTimeout(function(){ setGraphHeaderStyles(); }, 50);
		}
		else {
			var options = {
				title:'Comparison with Team',
				height:gheight,
				pointSize: 6,
				fontName: 'Century Gothic Regular',
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#000',
					fontSize: 13
					
				},
				tooltip: { isHtml: true },
				backgroundColor: { 
					  fill: '#FFF',
					  fillOpacity: 0.8
				 },
				 chartArea:{
						left:80,
						//top:'20%',
						width:'75%',
						//height:'90%'
					},
				 hAxis: {
				   title: 'Team Members',
				   color: '#000',
				   slantedText:true, slantedTextAngle:45, // here you can even use 180
				   textPosition: posi
				 },
				 legend: {position: 'bottom', textStyle: {fontSize: 10}},//{position: 'none'},
				 vAxis: {
				   title: 'Salary'
				 },
				 series: {
					  0: { pointSize: 0, color: '#a52714' },
					  1: { pointSize: 0, color: '#008000' },
					  2: { color: '#3366cc' },
					  3: { color: '#FF6600' },
				 }
			};
			setTimeout(function(){ setGraphHeaderStyles(); }, 50);
		}
		var chart = new google.visualization.LineChart(document.getElementById('comparison_with_team'));
		chart.draw(data, options);
		var h=$( '#comparison_with_team' ).height();
			$('.cwt').css('margin-top','-'+(parseInt(h))+'px');
			$('.cwt').css('position','absolute');
			$('.cwt').html('<img src="'+chart.getImageURI()+'" />');
		if(gheight == 200)
		{
			$("#comparison_with_team").append('<div style="position: absolute;right: 3%;bottom: 44%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
		}
	<?php } } else{ ?>
			
			$("#comparison_with_team").html("<br><p style='font-size: 13px;font-weight: bold; font-family:'Century Gothic Regular'; color: #74767D;text-align: center; margin-top: 10px;'>Comparison with Team</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>No record found.</p>");
			// $("#comparison_with_team").css("text-align","center");
			 $("#comparison_with_team").css("height","295px");
			 $("#comparison_with_team").css("background","#FFFFFF");
			 $("#comparison_with_team").removeClass("chart");
	<?php } ?>

		//setGraphHeaderStyles();
	}
	       
	drawComparisonWithTeam();
</script> 
