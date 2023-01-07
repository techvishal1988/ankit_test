<div id="salary_movement_chart" class="chart topchart"></div>
<?php /*?><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script> <?php */?>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawSalaryMovementChart);
	function drawSalaryMovementChart(gheight = 295,action='direct') 
	{
		var posi = 'none';//'out';
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
			
		<?php if(count($user_salary_graph_dtls) > 1)
		{
			if(!helper_have_rights(CV_SALARY_MOVEMENT_CHART, CV_VIEW_RIGHT_NAME))
			{ ?>
				//$("#salary_movement_chart").html("<br><p style='font-size: 14px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Salary growth in the company</p><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
				$("#salary_movement_chart").html("<br><p style='font-size: 14px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Salary Growth</p><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
			   // $("#salary_movement_chart").css("text-align","center");
				$("#salary_movement_chart").css("height","295px");
				$("#salary_movement_chart").css("background","#FFFFFF");
				$("#salary_movement_chart").removeClass("chart");
	  <?php }
			else
			{ ?>
				var data = google.visualization.arrayToDataTable([
				['Year', 'Salary', {'type': 'string', 'role': 'annotation'}, {'type': 'string', 'role': 'style'}],
				<?php $idSMC = 0;
				$current_salary = HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]);
				$revised_current_salary = HLP_get_formated_amount_common($salary_dtls["final_salary"]); 
				
				foreach($user_salary_graph_dtls as $value)
				{ 
					$user_sal_val = 0;
					$user_rating_name = "";
					if($value["value"])
					{
						$user_sal_val = $value["value"];
					}
					
					if($graph_for == "Base")
					{
						if($user_sal_val <= 0 or strpos($value["ba_name"], strtolower("Total")) === 0 or strpos($value["ba_name"], strtolower("Target")) === 0)
						{
							continue;
						}
					}
					else
					{
						if($user_sal_val <= 0 or strpos($value["ba_name"], strtolower($graph_for)) === false)
						{
							continue;
						}
					}
					
					if(strpos($value["ba_name"], "after_last_increase") !== false)
					{
						$user_rating_name = $salary_dtls[CV_BA_NAME_RATING_FOR_LAST_YEAR];
					}
					elseif(strpos($value["ba_name"], "after_2nd_last_increase") !== false)
					{
						$user_rating_name = $salary_dtls[CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR];
					}
					elseif(strpos($value["ba_name"], "after_3rd_last_increase") !== false)
					{
						$user_rating_name = $salary_dtls[CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR];
					}
					elseif(strpos($value["ba_name"], "after_4th_last_increase") !== false)
					{
						$user_rating_name = $salary_dtls[CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR];
					}
					elseif(strpos($value["ba_name"], "after_5th_last_increase") !== false)
					{
						$user_rating_name = $salary_dtls[CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR];
					}
					
					if($user_rating_name != "")
					{
						$user_rating_name = "(".$user_rating_name.")";
					}
					
					echo "['".date('d/m/Y',strtotime($value["effective_date"]))."".$user_rating_name."',".str_replace(",","",$user_sal_val).",'".HLP_get_formated_amount_common(str_replace(",","",$user_sal_val))."',''],"; 
				}
				//echo "['Current Year (".$salary_dtls["performance_rating"].")',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",'".HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"])."','point {fill-color: #a52714; font-weight:bold; }'],";
				//echo "['Current Year (".$salary_dtls["performance_rating"].")',".str_replace(",","",$salary_dtls[$graph_for."_salary"]).",'".HLP_get_formated_amount_common($salary_dtls[$graph_for."_salary"])."','point {fill-color: #a52714; font-weight:bold; }'],";
				
				echo "['Current Year (".$salary_dtls["performance_rating"].")',".str_replace(",","",$current_salary).",'".$current_salary."','point {fill-color: #a52714; font-weight:bold; }'],";				
				echo "['Current Year Revised (".$salary_dtls["performance_rating"].")',".str_replace(",","",$revised_current_salary).",'".$revised_current_salary."','point {fill-color: #008000; font-weight:bold; }'],";
				
?>
			]);
			
			//data.addColumn({type: 'string', role: 'annotation'});
			if(action=="click")
			{
			   var options = {
					//tooltip: {trigger: 'none'},
					//annotation: { 1: {style: 'none'}},
					//width:450,						
					pointSize: 6,
					fontName: 'Century Gothic Regular',
					fontSize: 14,
					annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
					titleTextStyle: {
						color: '#000',
						fontSize: 18
					},
					height:gheight,
					title:'Salary Growth',
					//pop up view
					//title:'Salary growth in the company',
					//pointSize: 4,
					chartArea:{
						left:100,
						//top:'20%',
						width:'90%',
						//height:'90%'
					},
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
							title: 'Year',
							count: 1, 
							viewWindowMode: 'pretty', 
							slantedText:true, 
							slantedTextAngle:20, // here you can even use 180
							//textPosition: posi
							textStyle : {
                             fontSize: 14 
                             }
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
				setTimeout(function(){ setGraphHeaderStyles(); }, 50);
			}
			else {
				var options = {
					//backgroundColor: { fill:'transparent' }
					//tooltip: {trigger: 'none'},
					//annotation: { 1: {style: 'none'}},
					//width:450,	
					backgroundColor: { 
						  fill: '#FFF',
						  fillOpacity: 0.8
					  },
					pointSize: 6,
					fontName: 'Century Gothic Regular',
					annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
					titleTextStyle: {
						color: '#000',
						fontSize: 13
					},
					height:gheight,
					title:'Salary Growth',
					//title:'Salary growth in the company',
					//pointSize: 4,
					chartArea:{
						left:80,
						//top:0,
						width:'75%',
						//height:'90%'
					},
					/*explorer: {
						maxZoomOut:2,
						keepInBounds: true
					},*/
					hAxis: {
						title: 'Year',
						count: 1, 
						viewWindowMode: 'pretty', 
						slantedText:true, slantedTextAngle:45, // here you can even use 180
						
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
				setTimeout(function(){ setGraphHeaderStyles(); }, 50);
			}
			var chart = new google.visualization.LineChart(document.getElementById('salary_movement_chart'));
			chart.draw(data, options);
			var h=$( '#salary_movement_chart' ).height();
			$('.smc').css('margin-top','-'+(parseInt(h)+65)+'px');
			$('.smc').css('position','absolute');
			$('.smc').html('<img src="'+chart.getImageURI()+'" />');
			if(gheight == 200)
			{
				$("#salary_movement_chart").append('<div style="position: absolute;right: 4%;top: 7%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
			}
	<?php } 
		}
		else
		{ ?>
			//$("#salary_movement_chart").html("<br><p style='font-size: 13px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'> Salary growth in the company</p><p style='margin-top:"+txt_mrgn+"%;'>No record found.</p>");
			$("#salary_movement_chart").html("<br><p style='font-size: 13px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Salary Growth </p><p style='margin-top:"+txt_mrgn+"%;'>No record found.</p>");
			$("#salary_movement_chart").css("text-align","center");
			$("#salary_movement_chart").css("height","295px");
			$("#salary_movement_chart").css("background","#FFFFFF");
			$("#salary_movement_chart").removeClass("chart");
 <?php } ?>
	}
	       
	drawSalaryMovementChart();
</script> 
