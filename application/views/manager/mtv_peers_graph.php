<div id="comparison_with_peers_<?php echo $uid; ?>"></div>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithPeers_<?php echo $uid; ?>);
	function drawComparisonWithPeers_<?php echo $uid; ?>(gheight=330, action='direct')
	{
		var posi = 'none';//'default';
		var showlbl = 0;//1;
		if(gheight == 330)
		{
			showlbl = 0;
			posi = 'none';
		}
			
		<?php if(count($graph_dtls)> 1){ 
		if(!helper_have_rights(CV_COMPARISON_WITHPEERS_CHART, CV_VIEW_RIGHT_NAME))
                    { ?>
                        $("#comparison_with_peers_<?php echo $uid; ?>").html("<br><p style='font-size: 15px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'><?php echo $salary_dtls["name"]; ?></p> <br/>You have no rights to view this chart.");
                        //$("#comparison_with_peers").css("text-align","center");
                        $("#comparison_with_peers_<?php echo $uid; ?>").css("height","330px");
                        $("#comparison_with_peers_<?php echo $uid; ?>").css("background","#FFFFFF");
                        $("#comparison_with_peers_<?php echo $uid; ?>").removeClass("chart");
                    <?php }
                    else {?>
		var data = google.visualization.arrayToDataTable([
			//['%tile','PeerSal','Mysal', {'type': 'string', 'role': 'annotation'}],
			['%tile','<?php echo $salary_dtls["name"]; ?> Salary','Peers Salary', {'type': 'string', 'role': 'annotation'}],
			<?php $p=1; foreach($graph_dtls as $value) { 
				//echo "['".$value["email"]."',".str_replace(",","",$value["final_salary"])."],"; 
                //echo "['Peer$p',null ,".str_replace(",","",$value["final_salary"]).",'".number_format(str_replace(",","",$value["final_salary"]), 2, '.', ',')."'],"; 
				$emp_sal = $salary_dtls[$graph_for."_salary"];
				$peer_emp_sal = $value[$graph_for."_salary"];		
				if(!$peer_emp_sal)
				{
					continue;
				}
				//echo "['Peer$p', ".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).", ".str_replace(",","",$value["increment_applied_on_salary"]).",'".number_format(str_replace(",","",$value["increment_applied_on_salary"]), 2, '.', ',')."'],"; 
				//echo "['".$value["name"]."', ".str_replace(",","",$emp_sal).", ".str_replace(",","",$peer_emp_sal).",'".number_format(str_replace(",","",$peer_emp_sal), 2, '.', ',')."'],";
				echo "['', ".str_replace(",","",$emp_sal).", ".str_replace(",","",$peer_emp_sal).",'".HLP_get_formated_amount_common(str_replace(",","",$peer_emp_sal), 2)."'],";
                            $p++;
			}
			//echo "['Current Salary', ".str_replace(",","",$emp_sal).", null,'".number_format(str_replace(",","",$emp_sal), 2, '.', ',')."'],";
			?>
		]);
		
		if(action==="click")
		{
			var options = 
			{
				title:'<?php echo $salary_dtls["name"]; ?>',
				height:gheight,
				pointSize: 6,
				annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
				titleTextStyle: {
					color: '#74767D',
					fontSize: 18
			},
			hAxis: {
			  title: 'Peer Members',
			  slantedText:true, slantedTextAngle:22, // here you can even use 180
              //textPosition: posi
			},
			legend: {position: 'right', textStyle: {fontSize: 11}},//{position: 'none'},
			vAxis: {
			  title: 'Salary'
			},
			series: {
					   // 0: { pointSize: 6, pointShape: { type: 'circle' }, color: '#a52714' },
						0: { pointSize: 0, pointShape: { type: 'circle' }, color: '#a52714' },
						1: { color: '#3366cc' },
						
					},
                        //curveType: 'function'
			};
		}
		else
		{
			var options = 
			{
				title:'<?php echo $salary_dtls["name"]; ?>  <?php //echo $peer_type ?>',
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
				  title: 'Peer Members',
				  slantedText:true, slantedTextAngle:45, // here you can even use 180
				  textPosition: posi
				},
				legend: {position: 'bottom'},//{position: 'none'},
				vAxis: {
				  title: 'Salary'
				},
				series: {
							//0: { pointSize: 6, pointShape: { type: 'circle' }, color: '#a52714' },
							0: { pointSize: 0, pointShape: { type: 'circle' }, color: '#a52714' },
							1: { color: '#3366cc' },
				},
				//curveType: 'function'
			};		
		}
		
		var chart = new google.visualization.LineChart(document.getElementById('comparison_with_peers_<?php echo $uid; ?>'));
		chart.draw(data, options);
		<?php }} else{ ?>
		   $("#comparison_with_peers_<?php echo $uid; ?>").html("<br><p style='font-size: 15px; margin-top: 10px;'><?php echo $salary_dtls["name"]; ?></p> <br/> No record found.");
                   $("#comparison_with_peers_<?php echo $uid; ?>").css("text-align","center");
                   $("#comparison_with_peers_<?php echo $uid; ?>").css("height","330px");
                   $("#comparison_with_peers_<?php echo $uid; ?>").css("background","#FFFFFF");
                   $("#comparison_with_peers_<?php echo $uid; ?>").removeClass("chart");
		<?php } ?>
		setGraphHeaderStyles();
	}
	
	$('#comparison_with_peers_<?php echo $uid; ?>').on('click',function(e)
	{
		if(!$("#popoverlay").is(':visible'))
		{
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
			drawComparisonWithPeers_<?php echo $uid; ?>("75%","click");
			//setGraphHeaderStyles();
			setGraphHeaderStyles("45");
		}
		else
		{
			$('#popoverlay').hide();
			$(this).html("");
			$(this).removeAttr("style");
			drawComparisonWithPeers_<?php echo $uid; ?>();
			setGraphHeaderStyles();
			arrangeBottomCharts();
		}		
	});

drawComparisonWithPeers_<?php echo $uid; ?>();
        
</script> 
