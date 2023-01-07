<div id="comparison_with_peers" class="chart bottomchart" style="text-align:left; background-color:#000 !important"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithPeers);
	function drawComparisonWithPeers(gheight=295, action='direct')
	{
		var posi = 'none';//'default';
		var showlbl = 0;//1;
		if(gheight == 295)
		{
			showlbl = 0;
			posi = 'none';
		}
		
		var txt_mrgn = 15;
		if(gheight !=295)
		{
			txt_mrgn = 5;
		}
			
		<?php if(count($peer_salary_graph_dtls)> 1){ 
		if(!helper_have_rights(CV_COMPARISON_WITHPEERS_CHART, CV_VIEW_RIGHT_NAME))
                    { ?>
                        //$("#comparison_with_peers").html("<br><p style='font-size: 14px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Comparison with Peers</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
                        $("#comparison_with_peers").html("<br><p style='font-size: 13px; margin-top:10px;font-weight: bold; color: #74767D; text-align: center;'>Peer Comparison</p> <br/><p style='margin-top:"+txt_mrgn+"%;'>You have no rights to view this chart.</p>");
                        //$("#comparison_with_peers").css("text-align","center");
                        $("#comparison_with_peers").css("height","295px");
                        $("#comparison_with_peers").css("background","#FFFFFF");
                        $("#comparison_with_peers").removeClass("chart");
                    <?php }
                    else {?>
		<?php /*?>var data = google.visualization.arrayToDataTable([
			//['%tile','PeerSal','Mysal', {'type': 'string', 'role': 'annotation'}],
			['%tile','<?php echo $salary_dtls["name"]; ?> Salary','Revised Salary','Peers Salary', {'type': 'string', 'role': 'annotation'}],<?php */?>
			var data = google.visualization.arrayToDataTable([
			['%tile','Current','Revised','Peers Range','Revised Peers Range', {'type': 'string', 'role': 'annotation'}],
			<?php $p=1; 
			$current_salary = HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]);
			$revised_current_salary = HLP_get_formated_amount_common($salary_dtls["final_salary"]);
			foreach($peer_salary_graph_dtls as $value) { 
				//echo "['".$value["email"]."',".str_replace(",","",$value["final_salary"])."],"; 
                //echo "['Peer$p',null ,".str_replace(",","",$value["final_salary"]).",'".number_format(str_replace(",","",$value["final_salary"]), 2, '.', ',')."'],"; 
				//$emp_sal = $salary_dtls[$graph_for."_salary"];
				$peer_emp_sal = HLP_get_formated_amount_common($value[$graph_for."_salary"]);		
				if(!$peer_emp_sal)
				{
					continue;
				}
				$peer_emp_revised_sal = HLP_get_formated_amount_common($value["emp_revised_salary"]);
				//echo "['Peer$p', ".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).", ".str_replace(",","",$value["increment_applied_on_salary"]).",'".number_format(str_replace(",","",$value["increment_applied_on_salary"]), 2, '.', ',')."'],"; 
				//echo "['".$value["name"]."', ".str_replace(",","",$emp_sal).", ".str_replace(",","",$peer_emp_sal).",'".number_format(str_replace(",","",$peer_emp_sal), 2, '.', ',')."'],";
				echo "['', ".str_replace(",","",$current_salary).", ".str_replace(",","",$revised_current_salary).", ".str_replace(",","",$peer_emp_sal).",".str_replace(",","",$peer_emp_revised_sal).",'".str_replace(",","",$peer_emp_sal)."'],";
                            $p++;
			}
			//echo "['Current Salary', ".str_replace(",","",$emp_sal).", null,'".number_format(str_replace(",","",$emp_sal), 2, '.', ',')."'],";
			?>
		]);
		
		if(action==="click")
                {
                    
                    var options = {
                        //title:'Comparison across the Peers  - by <?php //echo @$peer_type ?>',
                         title:'Peer Comparison <?php //echo @$peer_type ?>',
                        height:gheight,
                        pointSize: 6,
                        fontName: 'Century Gothic Regular',
                        fontSize: 14,
                        chartArea:{
									left:100,
									//top:'20%',
									width:'88%',
									//height:'90%'
								  },		  
                        annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#000',
                            fontSize: 18
                        },
			hAxis: {
			  title: 'Peer Members',
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
                           // 0: { pointSize: 6, pointShape: { type: 'circle' }, color: '#a52714' },
						    0: { pointSize: 0, pointShape: { type: 'circle' }, color: '#a52714' },
							1: { pointSize: 0, color: '#008000' },
                            2: { color: '#3366cc' },
							3: { color: '#FF6600' },
                            
                        },
                        //curveType: 'function'
		};setTimeout(function(){ setGraphHeaderStyles(); }, 50);
                }
                else {
		
			var options = {
							//title:'Comparison across the Peers  - by <?php //echo $peer_type ?>',
							title:'Peer Comparison  <?php //echo $peer_type ?>',
							
							height:gheight,
							pointSize: 6,
							fontName: 'Century Gothic Regular',
							 chartArea:{
										left:80,
										//top:'20%',
										width:'75%',
										//height:'90%'
									   },
							annotations: { stemColor: 'transparent', alignment: 'center', style: 'line', textStyle: {opacity:showlbl } },
							titleTextStyle: {
								color: '#000',
								fontSize: 13
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
				legend: {position: 'bottom', textStyle: {fontSize: 10}},//{position: 'none'},
				vAxis: {
				  title: 'Salary'
				},
				series: {
								//0: { pointSize: 6, pointShape: { type: 'circle' }, color: '#a52714' },
								0: { pointSize: 0, pointShape: { type: 'circle' }, color: '#a52714' },
								1: { pointSize: 0, color: '#008000' },
								2: { color: '#3366cc' },
								3: { color: '#FF6600' },
								
							},
							//curveType: 'function'
			};  setTimeout(function(){ setGraphHeaderStyles(); }, 50);    
		
		}
		
		var chart = new google.visualization.LineChart(document.getElementById('comparison_with_peers'));
		chart.draw(data, options);
		<?php }} else{ ?>
		   //$("#comparison_with_peers").html("<br><p style='font-size: 13px; color:4E5E6A; font-weight: bold; margin-top: 10px;'>Peer Comparison</p> <br/> <p style='margin-top:"+txt_mrgn+"%;'>No record found.</p>");
		   $("#comparison_with_peers").html("<br><p style='font-size: 13px; color:#000; font-weight: bold; margin-top: 10px;'>Peer Comparison</p> <br/> <p style='margin-top:"+txt_mrgn+"%;'>No record found.</p>");
                   $("#comparison_with_peers").css("text-align","center");
                   $("#comparison_with_peers").css("height","295px");
                   $("#comparison_with_peers").css("background","#FFFFFF");
                   $("#comparison_with_peers").removeClass("chart");
		<?php } ?>
		setGraphHeaderStyles();
	}
        <?php /*?>$('#comparison_with_peers').on('click',function(e){
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
                drawComparisonWithPeers("75%");
                //setGraphHeaderStyles();
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawComparisonWithPeers();
                setGraphHeaderStyles();
            }
            
        });<?php */?>
	
        drawComparisonWithPeers();
        
</script>
