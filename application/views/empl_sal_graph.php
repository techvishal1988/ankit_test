
    <!-- Bootstrap core CSS -->
   
   <link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
   <style>
       .bg{
	background: url(<?php echo base_url() ?>assets/salary/img/bg-1.png);
	background-size: cover;
        
}
.card-1{
	background: url(<?php echo base_url() ?>assets/salary/img/card-1.png);
	background-size: contain;
	padding: 15px;
	margin-top: 6px;
	padding-bottom: 29px;
	 box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
.card-1-c{
	background: url(<?php echo base_url() ?>assets/salary/img/c1-cricle.png);
	width: 65%;
	display: block;
	height: 50px;
	background-size: cover;
	text-align: center;
	padding-top: 17px;
	color: #fff;
         margin-top: -17px;
}
.black-card-1{
	border-bottom-left-radius: 10px;
	border-bottom-right-radius: 10px;
	background: url(<?php echo base_url() ?>assets/salary/img/black-card.png);
	background-size: cover;
	color: #fff;
	padding: 5px 30px;
	background-repeat: no-repeat;
	padding-bottom: 23px;
	margin-bottom: 10px;
       
}
.card-1-c2{
	background: url(<?php echo base_url() ?>assets/salary/img/c2-cricle.png);
	width: 65%;
	display: block;
	height: 50px;
	background-size: cover;
	text-align: center;
	padding-top: 15px;
	color: #fff;
        padding-left: 9px;
        margin-top: -17px;
}
#salary_movement_chart,#comparison_with_peers,#current_market_positioning,#comparison_with_team{
        margin-bottom: 20px;
    margin-top: 20px;
}
 .pcc, .pc{
        padding-left: 0px;
        width: 110px;
        position: absolute;
        background: transparent;
        border: none;
        border-bottom: solid gray 1px;
        margin-left: 5px;
}
#per{
    float: right;
}
.pcc{
    width: 40px;

}
#spercentage{
    float: left;
    margin-left: 5px;
}

.pc:focus, .pcc:focus{
    outline: none;
}
#txt_citation,.customcls{
    background: transparent;
    width: 100%;
    border: none;
    border-bottom: solid gray 1px; 
    display: none;
        color: orange;
}
.promoprice, .promoper{
        padding-left: 0px;
        width: 110px;
        position: absolute;
        background: transparent;
        border: none;
        border-bottom: solid gray 1px;
        margin-left: 5px;
     }
#prompers{
    float: right;
}
.promoper{
    width: 40px;

}
#promper{
    float: left;
    margin-left: 10px;
}

.promoper:focus, .promoprice:focus,.customcls:focus,#txt_citation:focus{
    outline: none;
        }
        .mycls{
            display: none;
        }      
        .customcls{ width: 78%;}
        .comp{
            background: #fff;
            text-align: center;
            margin-top: -20px;
        }
        .popoverlay{ width:100%;
    height:100%;
    display:none;
    position:fixed;
    top:0px;
    left:0px;
    background:rgba(0,0,0,0.75);
    z-index: 9;}
	
	 .black-card-1 h2{    margin-top: 16px !important;}
         .card-2{padding-top: 5px !important;}
   </style>
  <style>
.piechart
{
    position: relative;
}


.centerLabel
{
    position: absolute;
    margin-left: 150px;
    text-align: center;
    margin-top: -270px;
}
</style> 
   
   <?php 
   error_reporting(0);
//  echo '<pre />';
//  print_r($salary_dtls);
//   
	?>
   <div id="popoverlay" class=" popoverlay"></div>
   <div class="bg">
       <div class="container">
        <div class="row">
            <div class="col-sm-6">
            <div class="column-1">
            	<div class="map-1"  >
            		<div id="salary_movement_chart" class="chart topchart"></div>
            	</div>
            	<div class="map-2 ">
            		<div id="comparison_with_peers" class="chart bottomchart"></div>
                        <div class="comp">
                      	<?php //if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?> 
                     
				</div> 
            	</div>
            </div>
            </div>
         <?php /* ?>   <div class="col-sm-4">
                <div class="card-1" style="    margin-top: 20px;">
            	<h3 class="text-center"></h3>
            	<div class="card-1-left">
            	<p><span style="color: red;font-style: italic;font-weight: bold;"><?php echo $salary_dtls["name"]; ?></span> <span style="color: red;font-style: italic;font-weight: bold;"> <?php echo $salary_dtls["current_designation"]; ?></span></p>
            	</div>
            	<div class="card-1-right">
            	<div class="row">
            		<div class="col-xs-8">
						<p><strong>Comparative Ratio</strong></p>
            		</div>
                    <div class="col-xs-5" style="    margin-left: 50px;">
            			<span class="card-1-c"><?php 
                                            if($salary_dtls["market_salary"]){echo round(($salary_dtls["final_salary"]/$salary_dtls["market_salary"])*100,0);}else{echo 0;}
							?>%</span>
            		</div>
            	</div>
            </div>
            <div class="clearfix"></div>
            </div>
                <?php 
       $total=0;
            foreach($attr as $at)
                {
                    if($at['value']!='')
                    {
                       $total=$total+ $at["value"];
                      
                    }
                }
                
        ?>
            <div class="card-2">
                <h4>Salary breakup</h4>
                <div id="piechart" style="width: 380px; height: 421px;padding: 0px;    margin-left: -15px;">
                </div>
                 <div class="centerLabel">
                 <?php echo HLP_get_formated_amount_common($total) ?>
                 <p id="totalsal">Annual Salary</p>
             </div>
                <script>
                    
                    function salaryedit()
                    {
                        var val=($('#p').html());
                        val=val.replace(/\,/g,'');
                        val=parseInt(val)
                        $('#p').html('<input class="pc" onblur="getper(this.value)" value="'+val+'" maxlength="10" />');
                        $('#spercentage').html('<input class="pcc" onblur="getamt(this.value)" id="txt_emp_salary_per" name="txt_emp_salary_per" value="'+$('#spercentage').html()+'" maxlength="5" />');
                        $('#spercentage').css('margin-left','0px');
                        $('.action').html(' <img onclick="update_emp_salary_per()" src="<?php echo base_url() ?>assets/salary/img/ok.png"/>');
                        
                    }
                    
                    
                    function savesalaryinfo()
                    {
                        var val=$('.pc').val();
                        var sper=$('.pcc').val();
                         $('#p').html(val);
                         $('#spercentage').html(sper);
                         $('#spercentage').css('margin-left','20px');
                         $('.action').html(' <img onclick="salaryedit()" src="<?php echo base_url() ?>assets/salary/img/edit.png"/>');
                    }
                    
                </script>
               
            </div>
            
			</div> <?php */ ?>
            <div class="col-sm-6">
            <div class="column-1">
            	<div class="map-1 " >
            	<div id="current_market_positioning" class="chart topchart"></div>
            	</div>
            	<div class="map-2 ">
            		<div id="comparison_with_team" class="chart bottomchart"></div>
            	</div>
            </div>
            </div>
        </div>
    </div>
   </div>
	
    





    <!-- Bootstrap core JavaScript -->
    
   
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script type="text/javascript">
    function downloadchart(cls)
   {
       var options = {
        };
        var pdf = new jsPDF('p', 'pt', 'a4');
        pdf.fromHTML($("."+cls).html(), 15, 15, options, function() {
          pdf.save(cls+'.pdf');
        });
   }
        google.charts.load('current', {'packages':['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawSalaryMovementChart);
	function drawSalaryMovementChart(gheight = 300) 
	{
            var posi = 'out';
            var showlbl = 1;
            if(gheight == 300)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($user_salary_graph_dtls) > 1){
                    if(!helper_have_rights(CV_SALARY_MOVEMENT_CHART, CV_VIEW_RIGHT_NAME))
                    { ?>
                        $("#salary_movement_chart").html("<br><p style='font-size: 14px; margin-top: 10px;'>Salary Movement Chart</p>You have no rights to view this chart");
                        $("#salary_movement_chart").css("text-align","center");
                        $("#salary_movement_chart").css("height","300px");
                        $("#salary_movement_chart").css("background","#FFFFFF");
                        $("#salary_movement_chart").removeClass("chart");
                    <?php }
                    else {
                    ?>
		var data = google.visualization.arrayToDataTable([
			['Year', 'Salary', {'type': 'string', 'role': 'annotation'}, {'type': 'string', 'role': 'style'}],
			<?php $idSMC = 0; foreach($user_salary_graph_dtls as $value) { 
			$user_sal_val = 0;
                            if($value["value"])
                            {
                                    $user_sal_val = $value["value"];
                            }
                            //echo "['".str_replace("increase","",str_replace("Salary after","",$value["display_name_override"]))."',".str_replace(",","",$user_sal_val).",'".number_format(str_replace(",","",$user_sal_val), 0, '.', ',')."',''],";
							echo "['".str_replace("increase","",str_replace("Salary after","",$value["display_name"]))."',".str_replace(",","",$user_sal_val).",'".HLP_get_formated_amount_common(str_replace(",","",$user_sal_val))."',''],"; 
                            
			}
			echo "['Current Year',".str_replace(",","",$salary_dtls["final_salary"]).",'".HLP_get_formated_amount_common($salary_dtls["final_salary"])."','point {fill-color: #a52714; font-weight:bold; }'],";
			?>
		]);
                //data.addColumn({type: 'string', role: 'annotation'});
                //console.log(data);
                
		var options = {
                        //tooltip: {trigger: 'none'},
                        //annotation: { 1: {style: 'none'}},
                        //width:450,						
                        pointSize: 6,
                        annotations: { stemColor: 'white', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#74767D'
                        },
                        height:gheight,
                        title:'Salary Movement Chart',
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
                            count: -1, 
                            viewWindowMode: 'pretty', 
                            slantedText: true,
                            slantedTextAngle: 20,
                            textPosition: posi
			},
			legend: {position: 'none'},
			vAxis: {
			  title: 'Salary'
			},
                        series: {
                            0: { pointSize: 6,color: '#3366cc' },
                            //1: { pointSize: 6,color: '#a52714' },
                            
                        },
                       // curveType: 'function'
			
		};
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
                <?php } }else{ ?>
		   $("#salary_movement_chart").html("<br><p style='font-size: 14px; margin-top: 10px;'>Salary Movement Chart</p>No record found.");
                   $("#salary_movement_chart").css("text-align","center");
                   $("#salary_movement_chart").css("height","300px");
                   $("#salary_movement_chart").css("background","#FFFFFF");
                   $("#salary_movement_chart").removeClass("chart");
		<?php }  ?>
	}
        $('#salary_movement_chart').on('click',function(e){
            if(!$("#popoverlay").is(':visible')){
                $('#popoverlay').show();
                $(this).css({
                    width:"90%",
                    height:"75%",
                    margin:"0",
                    border:"none",
                    left:"5%",
                    top:"20%",
                    position:"fixed",
                    "z-index":"10"
                });
                drawSalaryMovementChart("75%");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawSalaryMovementChart();
                setGraphHeaderStyles();
            }
            drawdontpie();
        });
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawCurrentMarketPositioning);
	function drawCurrentMarketPositioning(gheight = 300)
	{
            var posi = 'default';
            var showlbl = 1;
            if(gheight == 300)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($makt_salary_graph_dtls) > 1){
                    if(!helper_have_rights(CV_CURRENT_MARKET_POSITIONING_CHART, CV_VIEW_RIGHT_NAME))
                    { ?>
                        $("#current_market_positioning").html("<br><p style='font-size: 14px; margin-top: 10px;'>Current Market Positioning</p> <br/>You have no rights to view this chart.");
                        $("#current_market_positioning").css("text-align","center");
                        $("#current_market_positioning").css("height","300px");
                        $("#current_market_positioning").css("background","#FFFFFF");
                        $("#current_market_positioning").removeClass("chart");
                    <?php }
                    else {
                    ?>
		var data = google.visualization.arrayToDataTable([
			['%tile','Mysal','Amt', {'type': 'string', 'role': 'annotation'}],
			<?php foreach($makt_salary_graph_dtls as $value) { 
				$mrkt_val = 0;
				if($value["value"])
				{
					$mrkt_val = $value["value"];
				}
				
				echo "['".str_replace("market salary for the matched job","",$value["display_name"])."',".str_replace(",","",$salary_dtls["final_salary"]).",".str_replace(",","",$mrkt_val).",'".HLP_get_formated_amount_common(str_replace(",","",$mrkt_val))."'],";
			}
			
                        echo "[' ',".str_replace(",","",$salary_dtls["final_salary"]).",null,'".HLP_get_formated_amount_common(str_replace(",","",$salary_dtls["final_salary"]))."'],";
			?>
		]);
		var options = {
                        title:'Current Market Positioning',
                        //width:500,
                        height:gheight,
                        annotations: { stemColor: 'white', textStyle: {opacity:showlbl } },
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
                          textPosition: posi
			},
			legend: {position: 'none'},
			vAxis: {
			  title: 'Salary'
			},
                        series: {
                            0: { color: '#a52714' },
                            1: { pointSize: 6,color: '#3366cc' },
                            
                        },
                        //curveType: 'function'
		};          
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
                        $("#current_market_positioning").html("<br><p style='font-size: 14px; margin-top: 10px;'>Current Market Positioning</p> <br/>You have no rights to view this chart.");
                        $("#current_market_positioning").css("text-align","center");
                        $("#current_market_positioning").css("height","300px");
                        $("#current_market_positioning").css("background","#FFFFFF");
                        $("#current_market_positioning").removeClass("chart");
                    <?php } else {
                        ?>
		   $("#current_market_positioning").html("<br><p style='font-size: 14px; margin-top: 10px;'>Current Market Positioning</p> <br/> No record found.");
                   $("#current_market_positioning").css("text-align","center");
                   $("#current_market_positioning").css("height","300px");
                   $("#current_market_positioning").css("background","#FFFFFF");
                   $("#current_market_positioning").removeClass("chart");
                    <?php } }?>
	}
        $('#current_market_positioning').on('click',function(e){
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
                drawCurrentMarketPositioning("75%");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawCurrentMarketPositioning();
                setGraphHeaderStyles();
            }
            drawdontpie();
        });
        
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithPeers);
	function drawComparisonWithPeers(gheight=300)
	{
            var posi = 'default';
            var showlbl = 1;
            if(gheight == 300)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($peer_salary_graph_dtls)> 1){
                    
                    if(!helper_have_rights(CV_COMPARISON_WITHPEERS_CHART, CV_VIEW_RIGHT_NAME))
                    { ?>
                        $("#comparison_with_peers").html("<br><p style='font-size: 14px; margin-top: 10px;'>Comparison with Peers</p> <br/>You have no rights to view this chart.");
                        $("#comparison_with_peers").css("text-align","center");
                        $("#comparison_with_peers").css("height","300px");
                        $("#comparison_with_peers").css("background","#FFFFFF");
                        $("#comparison_with_peers").removeClass("chart");
                    <?php }
                    else { ?>
		var data = google.visualization.arrayToDataTable([
			['%tile','PeerSal','Mysal', {'type': 'string', 'role': 'annotation'}],
			<?php $p=1; foreach($peer_salary_graph_dtls as $value) { 
				//echo "['".$value["email"]."',".str_replace(",","",$value["final_salary"])."],"; 
                            //echo "['Peer$p',null ,".str_replace(",","",$value["final_salary"]).",'".number_format(str_replace(",","",$value["final_salary"]), 0, '.', ',')."'],"; 
							echo "['Peer$p', ".str_replace(",","",$salary_dtls["final_salary"]).", ".str_replace(",","",$value["final_salary"]).",'".HLP_get_formated_amount_common(str_replace(",","",$value["final_salary"]))."'],"; 
                            $p++;
			}
			echo "['Current Salary', ".str_replace(",","",$salary_dtls["final_salary"]).", null,'".HLP_get_formated_amount_common(str_replace(",","",$salary_dtls["final_salary"]))."'],";
			?>
		]);
		var options = {
                        title:'Comparison with Peers',
                        height:gheight,
                        pointSize: 6,
                        annotations: { stemColor: 'white', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#74767D'
                        },
			hAxis: {
			  title: 'Employee',
                          textPosition: posi
			},
			legend: {position: 'none'},
			vAxis: {
			  title: 'Salary'
			},
			series: {
                           // 0: { pointSize: 6, pointShape: { type: 'circle' }, color: '#a52714' },
						    0: { pointSize: 0, pointShape: { type: 'circle' }, color: '#a52714' },
                            1: { color: '#3366cc' },
                            
                        },
                        curveType: 'function'
		};          
		var chart = new google.visualization.LineChart(document.getElementById('comparison_with_peers'));
		chart.draw(data, options);
                var h=$( '#comparison_with_peers' ).height();
                $('.cwp').css('margin-top','-'+(parseInt(h))+'px');
                $('.cwp').css('position','absolute');
                $('.cwp').html('<img src="'+chart.getImageURI()+'" />');
                if(gheight == 200)
                {
                    $("#comparison_with_peers").append('<div id="exppeer" style="position: absolute;right: 3%;bottom: 42%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
                }
                    <?php }} else{ ?>
		   $("#comparison_with_peers").html("<br><p style='font-size: 14px; margin-top: 10px;'>Comparison with Peers</p> <br/> No record found.");
                   $("#comparison_with_peers").css("text-align","center");
                   $("#comparison_with_peers").css("height","300px");
                   $("#comparison_with_peers").css("background","#FFFFFF");
                   $("#comparison_with_peers").removeClass("chart");
		<?php } ?>
	}
        $('#comparison_with_peers').on('click',function(e){
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
                arrangeBottomCharts();
                drawdontpie();
            }
            
        });
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithTeam);
	function drawComparisonWithTeam(gheight = 300)
        {
            var posi = 'default';
            var showlbl = 1;
            if(gheight == 300)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
            
            <?php if(count($team_salary_graph_dtls) > 1){ 
                if(!helper_have_rights(CV_COMPARISON_WITH_TEAM_CHART, CV_VIEW_RIGHT_NAME))
                    { ?>
                        
                         $("#comparison_with_team").html("<br><p style='font-size: 14px; margin-top: 10px;'>Comparison with Team</p> <br/>You have no rights to view this chart");
                             $("#comparison_with_team").css("text-align","center");
                             $("#comparison_with_team").css("height","300px");
                             $("#comparison_with_team").css("background","#FFFFFF");
                             $("#comparison_with_team").removeClass("chart");
                        <?php }
                    else { ?>
            var data = google.visualization.arrayToDataTable([
             ['Employee','Salary','Mysal', {'type': 'string', 'role': 'annotation'}],
             <?php $p=1; foreach($team_salary_graph_dtls as $value) { 
              //echo "['Memeber$p' ,null ,".str_replace(",","",$value["final_salary"]).",'".number_format(str_replace(",","",$value["final_salary"]), 0, '.', ',')."'],"; 
			  	echo "['Memeber$p' , ".str_replace(",","",$salary_dtls["final_salary"]).", ".str_replace(",","",$value["final_salary"]).",'".HLP_get_formated_amount_common(str_replace(",","",$value["final_salary"]))."'],"; 
                $p++;
             }
             echo "['Current Salary', ".str_replace(",","",$salary_dtls["final_salary"]).", null,'".HLP_get_formated_amount_common(str_replace(",","",$salary_dtls["final_salary"]))."'],";
             ?>
            ]);
            var options = {
                        title:'Comparison with Team',
                        height:gheight,
                        pointSize: 6,
                        annotations: { stemColor: 'white', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#74767D'
                        },
             hAxis: {
               title: 'Employee',
               textPosition: posi
             },
             legend: {position: 'none'},
             vAxis: {
               title: 'Salary'
             },
             series: {
                                      0: { pointSize: 0, color: '#a52714' },
                                      1: { color: '#3366cc' },
             }
            };
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
               $("#comparison_with_team").html("<br><p style='font-size: 14px; margin-top: 10px;'>Comparison with Team</p> <br/>No record found.");
                             $("#comparison_with_team").css("text-align","center");
                             $("#comparison_with_team").css("height","300px");
                             $("#comparison_with_team").css("background","#FFFFFF");
                             $("#comparison_with_team").removeClass("chart");
            <?php } ?>

                       setGraphHeaderStyles();
        } //End
        
        $('#comparison_with_team').on('click',function(e){
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
                drawComparisonWithTeam("75%");
                //setGraphHeaderStyles();
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawComparisonWithTeam();
                arrangeBottomCharts();
                drawdontpie();
            }
            
        });
        
        function setGraphHeaderStyles()
        {
            //for setting title styles
            var y, labels =  document.querySelectorAll('[text-anchor="start"]');
            for (var i=0;i<labels.length;i++) { 
               //y = parseInt(labels[i].getAttribute('y'));
               //labels[i].setAttribute('x', 190);
               labels[i].setAttribute('x', "25%");
               labels[i].setAttribute('font-family', 'inherit');
               labels[i].setAttribute('font-weight', 400);
               labels[i].setAttribute('font-size', 14);
               //#74767D
               //labels[i].setAttribute('font-color', '#74767D');
            }
        }
        
        function getAjaxPeerGraph()
        {
            
            var type = $("#peertype").val();
			
            var aurl = "<?php echo site_url('employee/dashboard/get_peer_employee_salary_dtls_for_graph');?>/"+type;
			
            //alert(aurl);return;
            $.ajax({url: aurl, success: function(result){
                $("#comparison_with_peers").html(result);
                setGraphHeaderStyles();
                drawdontpie();
            }});
        }
        
	$(document).ready(function(){
            $(window).resize(function(){
                drawSalaryMovementChart();
                drawCurrentMarketPositioning();
                drawComparisonWithPeers();
                drawComparisonWithTeam();
            });
            $(".centerTopCir").on("scroll",function(){
               $(this).css("style","transform: rotate(10deg);") 
            });
            
            
	});
        
        /*jQuery.ui.autocomplete.prototype._resizeMenu = function () {
            var ul = this.menu.element;
            ul.outerWidth(this.element.outerWidth());
        }*/
        function arrangeBottomCharts()
        {
            var ismDesktop = window.matchMedia( "(min-width: 600px)" );
            var isDesktop = window.matchMedia( "(min-width: 1400px)" );
            if (isDesktop.matches) {
                // window width is at least 500px
                $(".bottomchart").each(function(){
                    //alert($("#dv_promotion_part1").height()+ " "+$("#cntcenterpart").css("margin-top"));
                    //var ht = (($("#dv_promotion_part1").height()*32)/100);//cntcenterpart
                    //var htpcnt =  (($("#dv_promotion_part1").height()*5)/100);
                    //var ht = ($("#dv_promotion_part1").height() + parseInt($("#cntcenterpart").css("margin-top")))-htpcnt;
                    //var ht = ($("#dv_promotion_part1").height() + parseInt($("#cntcenterpart").css("margin-top")))-htpcnt;
                    var ht = parseInt($("#cntcenterpart").css("margin-top"));
                    //alert(ht);
                    $(this).css("margin-top",ht);
                    //$("#exppeer").css("bottom","57%");
                })
            }
            else if (ismDesktop.matches) {
                // window width is at least 500px
                $(".bottomchart").each(function(){
                    //alert($("#dv_promotion_part1").height()+ " "+$("#cntcenterpart").css("margin-top"));
                    //var ht = (($("#dv_promotion_part1").height()*32)/100);//cntcenterpart
                    //var htpcnt = (($("#dv_promotion_part1").height()*5)/100);
                    var ht = ($("#dv_promotion_part1").height() + parseInt($("#cntcenterpart").css("margin-top")))- 28;
                    //alert(ht);
                    var ht = parseInt($("#cntcenterpart").css("margin-top"))+10;
                    $(this).css("margin-top",ht);
                    $("#exppeer").css("bottom","47%");
                })
            }
            drawdontpie();
        }
        arrangeBottomCharts();
        
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawdontpie);

      function drawdontpie() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Salary Components'],
          //['Work',     11],
          <?php 
            $val='';
                foreach($attr as $at)
                {
                    if($at['value']!='')
                    {
                        $val.= "['".$at["display_name"]."',".$at["value"]."],";
                        
                    }
                }
                echo rtrim($val,',');
               
          
          ?>
        ]);

        var options = {
          title: 'Salary Components',
          pieHole: 0.4,
          pieSliceText: 'value-and-percentage',
          pieSliceTextStyle: {
            color: '#fff',
          },
          legend: 'bottom',
           chartArea : {left:20,top:20,width:"90%",height:"80%"}
          
           
        };

        var chartt = new google.visualization.PieChart(document.getElementById('piechart'));
        
        chartt.draw(data, options);
      }
    </script>