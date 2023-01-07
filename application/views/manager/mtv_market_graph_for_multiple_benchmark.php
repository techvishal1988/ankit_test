<div id="current_market_positioning_<?php echo $uid; ?>" class="chart topchart"></div>

<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawCurrentMarketPositioning_<?php echo $uid; ?>);
	function drawCurrentMarketPositioning_<?php echo $uid; ?>(gheight = 330)
	{
		var posi = 'none';//'default';
		var showlbl = 0;//1;
		if(gheight == 330)
		{
			showlbl = 0;
			posi = 'none';
		}
		//textPosition: posi
	  <?php if(!helper_have_rights(CV_CURRENT_MARKET_POSITIONING_CHART, CV_VIEW_RIGHT_NAME))
			{ ?>
				$("#current_market_positioning_<?php echo $uid; ?>").html("<br><p style='font-size: 14px; margin-top: 10px;'><?php echo $salary_dtls["name"]; ?></p> <br/>You have no rights to view this chart.");
				$("#current_market_positioning_<?php echo $uid; ?>").css("text-align","center");
				$("#current_market_positioning_<?php echo $uid; ?>").css("height","300px");
				$("#current_market_positioning_<?php echo $uid; ?>").css("background","#FFFFFF");
				$("#current_market_positioning_<?php echo $uid; ?>").removeClass("chart");
	  <?php }
			else
			{ ?>
			var data = google.visualization.arrayToDataTable([
				['%tile','Salary','Salary','Salary','Salary','Salary', {'type': 'string', 'role': 'annotation'}],
			<?php
				echo "['$graph_for Salary Min',".str_replace(",","",$usr_full_dtls["CurrentBasesalary"]).",".str_replace(",","",$usr_full_dtls["Company1".$graph_for."SalaryMin"]).",".str_replace(",","",$usr_full_dtls["Company2".$graph_for."SalaryMin"]).",".str_replace(",","",$usr_full_dtls["Company3".$graph_for."SalaryMin"]).",".str_replace(",","",$usr_full_dtls["Average".$graph_for."SalaryMin"]).",'".HLP_get_formated_amount_common(str_replace(",","",$usr_full_dtls["Average".$graph_for."SalaryMin"]))."'],";
				
				echo "['$graph_for Salary Max',".str_replace(",","",$usr_full_dtls["CurrentBasesalary"]).",".str_replace(",","",$usr_full_dtls["Company1".$graph_for."SalaryMax"]).",".str_replace(",","",$usr_full_dtls["Company2".$graph_for."SalaryMax"]).",".str_replace(",","",$usr_full_dtls["Company3".$graph_for."SalaryMax"]).",".str_replace(",","",$usr_full_dtls["Average".$graph_for."SalaryMax"]).",'".HLP_get_formated_amount_common(str_replace(",","",$usr_full_dtls["Average".$graph_for."SalaryMax"]))."'],";
				
				echo "['$graph_for Salary Average',".str_replace(",","",$usr_full_dtls["CurrentBasesalary"]).",".str_replace(",","",$usr_full_dtls["Company1".$graph_for."SalaryAverage"]).",".str_replace(",","",$usr_full_dtls["Company2".$graph_for."SalaryAverage"]).",".str_replace(",","",$usr_full_dtls["Company3".$graph_for."SalaryAverage"]).",".str_replace(",","",$usr_full_dtls["Average".$graph_for."SalaryAverage"]).",'".HLP_get_formated_amount_common(str_replace(",","",$usr_full_dtls["Average".$graph_for."SalaryAverage"]))."'],";
			?>
		]);
		var options = {
                        title:'<?php echo $salary_dtls["name"]; ?>',
                        //width:500,
                        height:gheight,
                        annotations: { stemColor: 'white', style: 'line', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#74767D'
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
						  title: '%ile Market Salary for the matched job',
						  slantedText:true, slantedTextAngle:45, // here you can even use 180
						  textPosition: posi
						},
						legend: {position: 'bottom'},//{position: 'none'},
						vAxis: {
						  title: 'Salary'
						},
						series: {
									0: { color: '#a52714' },
									1: { pointSize: 6,color: '#F0F' },
									2: { pointSize: 6,color: '#3366cc' },
									3: { pointSize: 6,color: '#3C0' },
									4: { pointSize: 6,color: '#FF0' },
								},
						//curveType: 'function'
				};          
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
		<?php } ?>
	}
       
	drawCurrentMarketPositioning_<?php echo $uid; ?>();
</script>
