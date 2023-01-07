<!-- Bootstrap core CSS -->
<link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
<style>
.box-cls{padding: 5px 15px !important;}
.bg {
	background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
	background-size: cover;
}
.card-1 {
 background: url(<?php echo base_url() ?>assets/salary/img/card-1.png);
	background-size: cover;
	padding: 5px;
	padding-top: 5px;
	/*margin-top: 6px;*/
	/*padding-bottom: 29px;*/
	 box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
.card-1-c {
 background: url(<?php echo base_url() ?>assets/salary/img/c1-cricle.png);
 //width: 65%; /*Shumsul*/
	width: 70px;  /*Shumsul*/
	display: block;
	height: 70px;
	background-size: cover;
	text-align: center;
	padding-top: 25px;
	color: #fff;
	margin-top: -15px;
  font-size: 13px;
  font-weight: bold;
}
.black-card-1 {
	border-bottom-left-radius: 10px;
	border-bottom-right-radius: 10px;
 background: url(<?php echo base_url() ?>assets/salary/img/black-card.png);
	background-size: cover;
	color: #fff;
	padding: 5px 30px;
	background-repeat: no-repeat;
	padding-bottom: 23px;
	margin-bottom: 10px;
	/*Shumsul*/
	    border-radius: 17px;
	background-attachment: scroll;
}
.card-1-c2 {
 background: url(<?php echo base_url() ?>assets/salary/img/c2-cricle.png);
 //width: 65%; /*Shumsul*/
	width: 70px;  /*Shumsul*/
	display: block;
	height: 70px;
	background-size: cover;
	text-align: center;
	padding-top: 25px;
	color: #fff;
 //padding-left: 9px; /*Shumsul*/
	padding-left: 2px; /*Shumsul*/
	margin-top: -15px;
  font-size: 13px; font-weight: bold;
}
#salary_movement_chart, #comparison_with_peers, #current_market_positioning, #comparison_with_team {
	margin-bottom: 20px;
	margin-top: 20px;
}
.pcc, .pc {
	padding-left: 0px;
	width: 110px;
	position: absolute;
	background: transparent;
	border: none;
	border-bottom: solid gray 1px;
	margin-left: 5px;
	text-align: right;
}
#per {
 //float: right; /*Shumsul*/
	float: left;  /*Shumsul*/
}
.pcc {
	width: 60px;
	text-align:right;
}
.perEdit {
	margin-left: 65px !important;
}
#spercentage {
	float: left;
	font-size: 20px;
	margin-left: 5px;
}
.pc:focus, .pcc:focus {
	outline: none;
}
#txt_citation, .customcls {
	background: transparent;
	width: 100%;
	border: none;
	border-bottom: solid gray 1px;
	display: none;
	color: orange;
}
.promoprice, .promoper {
	padding-left: 0px;
	width: 110px;
	position: absolute;
	background: transparent;
	border: none;
	border-bottom: solid gray 1px;
	margin-left: 5px;
	text-align: right;
}
#prompers {
	float: right;
}
.promoper {
	width: 65px;
	text-align: right;
	font-size: 20px;
}
#promper {
	float: left;
	margin-left: 10px;
}
.promoper:focus, .promoprice:focus, .customcls:focus, #txt_citation:focus {
	outline: none;
}
.mycls {
	display: none;
}
.customcls {
	width: 78%;
}
.comp {
	background: #fff;
	text-align: center;
	margin-top: -11px;
}
.popoverlay {
	width:100%;
	height:100%;
	display:none;
	position:fixed;
	top:0px;
	left:0px;
	background:rgba(0, 0, 0, 0.75);
	z-index: 9;
}
.black-card-1 h2 {
	margin-top: 20px !important;
}
.card-2 {
	padding-top: 5px !important;
}
/*Start shumsul*/
    .page-inner {
	padding:0 0 40px;
 background: url(<?php echo $this->session->userdata('company_bg_img_url_ses');
?>) 0 0 no-repeat !important;
	background-size: cover !important;
}
/*End shumsul*/
.map-2, .map-1 {
	text-align:center;
}
.bg {
    margin: 15px 0 45px 0;
}

.card_cust p{margin-bottom: 0px;}
.card_cust p.head{ font-size: 14px;
    height: 20px !important;
    letter-spacing: .5px; }
.card_cust p.bodytxt{font-size: 20px;
    line-height: 36px;
    color: #4E5E6A;}  

</style>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/style3.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.min.css">
<?php 
   //error_reporting(0);
   $total_sal_incr_per = round($salary_dtls["manager_discretions"]); ?>

<div id="popoverlay" class=" popoverlay"></div>
<div class="bg">
  <div class="container">
    <div class="row">
      
      <div class="col-sm-4">
        <div class="column-1">
          <div class="map-1"  >
            <div id="salary_movement_chart" class="chart topchart"></div>
          </div>
          <div class="map-2 ">
            <div id="comparison_with_peers" class="chart bottomchart"></div>
            <div class="comp" style="display:none;">
              <?php //if(count($peer_salary_graph_dtls)> 1){ ?>
              Compare on :
              <select name="peertype" id="peertype" class="form-group" onchange="getAjaxPeerGraph()">
                <option value="<?php echo CV_GRADE;?>"> Designation</option>
                <option value="<?php echo CV_LEVEL;?>"> Level</option>
              </select>
              <?php //}  ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
      <div class="card-1 samMarginEmp new-box" style="margin-top: 11px;">
          <p><?php echo $salary_dtls["name"]; ?> <span class="custom-span">|</span><span><?php echo $salary_dtls["current_designation"]; ?></span></p>
          <p><span class="custom-p"><?php echo $salary_dtls["performance_rating"]; ?></span></p>
          <select name="ddl_team_data_for" id="ddl_team_data_for" class="form-control" onchange="getAjaxTeamDataForGraph()">
            <option value="Base">Base Salary</option>
            <option value="Target">Target Salary</option>
            <option value="Total">Total Salary</option>
          </select>
          <div class="clearfix"></div>
        </div>
        <div class="card-1 samMarginEmp box-cls" style="    margin-top: 11px;">
          <h3 class="text-center">Current</h3>
          <div class="card-1-left card_cust">
            <p class="head">Annual Salary</p>
            <p class="bodytxt"><strong>
              <?php if($salary_dtls["currency_type"]){echo $salary_dtls["currency_type"];}else{echo "$";} ?>
              <?php echo HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]); ?>
              <strong></p>
          </div>
          <div class="card-1-right card_cust">  
                <p class="head">Comparative
                  Ratio</p>
              
              <p class="bodytxt"><strong>
                <?php 
                 if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common(($salary_dtls["increment_applied_on_salary"]/$salary_dtls["market_salary"])*100);}else{echo 0;}
							  ?>%
              </strong></p>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="card-2">
        <form action="" method="post">
        	<?php echo HLP_get_crsf_field();?>
          <div class="black-card-1">
            <h3 class="text-center">Salary Review</h3>
            <div class="row">
              <div class="col-xs-7">
                <h3>
                  <?php if($salary_dtls["currency_type"]){echo $salary_dtls["currency_type"];}else{echo "$";} ?>
                  <span id="p"><?php echo HLP_get_formated_percentage_common(($salary_dtls["increment_applied_on_salary"]*$total_sal_incr_per)/100); ?></span></h3>
                <input  type="hidden" id="hiddensal" value="<?php echo round($salary_dtls["increment_applied_on_salary"]) ?>" />
              </div>
              <div class="col-xs-5">
                <div class="row">
                  <div class="col-xs-8">
                    <h2> <span id="spercentage">
                      <?php $total_sal_incr_per = round($salary_dtls["manager_discretions"]);echo HLP_get_formated_percentage_common($total_sal_incr_per); ?>
                      </span><span id="per">%</span></h2>
                  </div>
                  <div class="col-xs-4 action" style="    text-align: right;"> <img onclick="salaryedit()" src="<?php echo base_url() ?>assets/salary/img/edit.png"/> </div>
                </div>
              </div>
            </div>
          </div>
          <script>
                    
                    function salaryedit()
                    {
                        var val=($('#p').html());
                        val=val.replace(/\,/g,'');
                        val='';//parseInt(val)
                        $('#p').html('<input class="pc" onKeyUp="validate_percentage_onkeyup_common(this,9);" onblur="validate_percentage_onblure_common(this,9); getper(this.value)" id="txt_emp_salary" name="txt_emp_salary" value="'+val+'" maxlength="12" required />');
                        $('#spercentage').html('<input class="pcc" onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this); getamt(this.value)" id="txt_emp_salary_per" name="txt_emp_salary_per" value="'+$('#spercentage').html()+'" maxlength="5" required/>');
                        $('#spercentage').css('margin-left','0px');
                        //$('.action').html(' <img onclick="update_emp_salary_per()" src="<?php echo base_url() ?>assets/salary/img/ok.png"/>');
						$('.action').html('');
						$('#per').addClass('perEdit');
                        
                    }
                    salaryedit();
                    
                    function savesalaryinfo_NIU()
                    {
                        var val=$('.pc').val();
                        var sper=$('.pcc').val();
                         $('#p').html(val);
                         $('#spercentage').html(sper);
                         $('#spercentage').css('margin-left','20px');
                         $('.action').html(' <img onclick="salaryedit()" src="<?php echo base_url() ?>assets/salary/img/edit.png"/>');
                    }
                    
                </script>
          <div class="black-card-1">
            		<?php 
                        $sp_per=$salary_dtls["standard_promotion_increase"];
						if($salary_dtls["emp_new_designation"] != "")
						{
							$sp_per=$salary_dtls["sp_manager_discretions"];
						}
                    ?>
            <h3 class="text-center">Promotion</h3>
            <div class="row">
              <?php
                            if($this->session->userdata('role_ses')!=3)
                            {
                              if($salary_dtls['emp_new_designation']=='')
                                {
                                  $pstyle=' style="    float: right; margin-top: -18px;    margin-right: -4px;"';
                                    $cls='mycls';
                                    $style='style="    margin-left: 150px;"';
                                    $img=base_url().'assets/salary/img/plus.png';
                                }
                                else
                                {
                                    $cls='';
                                     $pstyle=' style="    float: right; margin-top: -50px;    margin-right: -4px;"';
                                    $img=base_url().'assets/salary/img/edit.png';
                                }  
                            }?>
              <div class="col-xs-7 <?php echo @$cls; ?>" >
                <h3>
                  <?php if($salary_dtls["currency_type"]){echo $salary_dtls["currency_type"];}else{echo "$";} ?>
                  <span id="promprice"><?php //echo HLP_get_formated_amount_common(round($salary_dtls["sp_increased_salary"],2)); ?></span></h3>
                <p><?php //echo $salary_dtls['emp_new_designation'] ?></p>
              </div>
              <div class="col-xs-5">
                <div class="row">
                  <div class="col-xs-8 <?php echo @$cls; ?>" >
                    <h2><span id="promper"> <?php //echo HLP_get_formated_amount_common((float)$sp_per); ?></span><span id="prompers">%</span></h2>
                  </div>
                  <div class="col-xs-4 astatus" style="    text-align: right; display:none;">
                    <div class="promaction"> <img onclick="promoedit()" <?php echo @$style ?> src="<?php echo @$img ?>"/> </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row astatus">
              <input class="customcls" placeholder="Enter new designantion" name="txt_emp_new_designation" id="txt_emp_new_designation" value=""/>
              <div class="<?php echo @$cls ?>" <?php echo @$pstyle ?>> <?php /*?><img onclick="deletepromotion()" src="<?php echo base_url() ?>assets/salary/img/cancel.png"/><?php */?> </div>
              <textarea  rows="1" id="txt_citation" name="txt_citation" placeholder="Comments" maxlength="150"></textarea>
              <input type="submit" name="btn_submit" value="Submit" class="btn btn-success"/>
            </div>
            <script>
				function promoedit()
				{
					var val=($('#promprice').html());
					val=val.replace(/\,/g,'');
					val=parseInt(val);
				   
					$('#promprice').html('<input class="promoprice" onKeyUp="validate_percentage_onkeyup_common(this,9);" onblur="validate_percentage_onblure_common(this,9); getperr(this.value)" name="amount" value="'+Math.round(val)+'" maxlength="12" />');
					$('#promper').html('<input class="promoper" id="txt_emp_sp_salary_per" onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this); getamtt(this.value)" name="txt_emp_sp_salary_per" value="'+$('#promper').html()+'" maxlength="5" />');
					$('#promper').css('margin-left','0px');
					//$('.promaction').html(' <img onclick="update_emp_promotions_dtls()" src="<?php //echo base_url() ?>assets/salary/img/ok.png"/>');
					$('.customcls').show();
					$('#txt_citation').show();
					$('.mycls').show();
									
					<?php if($salary_dtls["sp_manager_discretions"] <= 0){ ?>
						$('.promoprice').val('');
					<?php } ?>
				}
				promoedit();
				function savepromoinfo_NIU()
				{
					var val=$('.promoprice').val();
					var sper=$('.promoper').val();
					 $('#promprice').html(val);
					 $('#promper').html(sper);
					 $('#promper').css('margin-left','20px');
					 $('.promaction').html(' <img onclick="promoedit()" src="<?php echo base_url() ?>assets/salary/img/edit.png"/>');
					 $('.customcls').hide();
				}
				function getamtt(cp)
				{
					var oldsal=$('#hiddensal').val();
					if(cp>0)
					{
						$('.promoprice').val(Math.round(((parseInt(oldsal)*parseInt(cp))/100)));
					}
					else
					{
						$('.promoprice').val("");
					}
				}
				function getperr(cp)
				{
					var oldsal=$('#hiddensal').val();
					if(cp>0)
					{
						$('#txt_emp_sp_salary_per').val(get_formated_percentage_common(parseInt(cp)/(parseInt(oldsal))*100,0));
					}
					else
					{
						$('#txt_emp_sp_salary_per').val("");
					}
				}
			</script> 
          </div>
          </form>
        </div>
        <div class="card-1 add-bottom box-cls">
          <h3 class="text-center">Revised</h3>
          <div class="card-1-left card_cust">
            <p class="head">Annual Salary</p>
            <p class="bodytxt" id="view_final_salary"><strong>
              <?php if($salary_dtls["currency_type"]){echo $salary_dtls["currency_type"];}else{echo "$";} ?>
              <?php echo HLP_get_formated_amount_common($salary_dtls["final_salary"]); ?></strong></p>
          </div>
          <div class="card-1-right card_cust">
             <p class="head">Comparative Ratio</p>
             <p class="bodytxt"> <strong><span id="revised_comparative_ratio">
                <?php if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common((float)($salary_dtls["final_salary"]/$salary_dtls["market_salary"])*100);}else{echo '0';} ?>
                %</span></strong></p>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="column-1">
          <div class="map-1 " >
            <div id="current_market_positioning" class="chart topchart"></div>
          </div>
          
          <div class="map-2 ">
            <div id="comparison_with_team" class="chart bottomchart"></div>
            <div class="comp" style="height: 34px; display:none;"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script> 
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script> 
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" ></script> 
<script>
	$(function() 
	{    
		$( "#txt_emp_new_designation").autocomplete({
			minLength: 2,
			//method: "POST",
			source: '<?php echo base_url() ?>manager/dashboard/get_designations_autocomplete',
			open: function() { 
				var wdt =$( "#txt_emp_new_designation").outerWidth();
				console.log("width"+wdt);
				$('#txt_emp_new_designation').autocomplete("widget").width(wdt); 
			},
			select: function(event, ui) {}
		});
	});
	function getper(cp)
	{
		var oldsal=$('#hiddensal').val();
		if(cp>0)
		{
			$('#txt_emp_salary_per').val(get_formated_percentage_common(parseInt(cp)/(parseInt(oldsal))*100),0);
		}
		else
		{
			$('#txt_emp_salary_per').val("");
		}
	}
	function getamt(cp)
	{
		var oldsal=$('#hiddensal').val();
		//alert(oldsal+cp)
		if(cp>0)
		{
			$('.pc').val(Math.round(((parseInt(oldsal)*parseInt(cp))/100)));
		}
		else
		{
			$('.pc').val("");
		}
	}
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<?php /*?><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script><?php */?> 
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
    
	//google.charts.load('current', {'packages':['corechart', 'bar']});
	//google.charts.setOnLoadCallback(drawSalaryMovementChart);

	function drawSalaryMovementChart_NIU(gheight = 330,action='direct') 
	{
            var posi = 'none';//'out';
            var showlbl = 0;//1;
            if(gheight == 330)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($user_salary_graph_dtls) > 1){
				if(!helper_have_rights(CV_SALARY_MOVEMENT_CHART, CV_VIEW_RIGHT_NAME))
				{ ?>
					$("#salary_movement_chart").html("<br><p style='font-size: 14px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Salary growth in the company</p>You have no rights to view this chart");
				   // $("#salary_movement_chart").css("text-align","center");
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
					if($user_sal_val <= 0)
					{
						continue;
					}
					echo "['".str_replace("increase","",str_replace("Salary after","",$value["display_name"]))."',".str_replace(",","",$user_sal_val).",'".HLP_get_formated_amount_common(str_replace(",","",$user_sal_val))."',''],"; 
                            
			}
			echo "['Current Year',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",'".HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"])."','point {fill-color: #a52714; font-weight:bold; }'],";
			?>
		]);
                //data.addColumn({type: 'string', role: 'annotation'});
                //console.log(data);
				
                if(action=="click")
				{
				   var options = {
                    
                        //tooltip: {trigger: 'none'},
                        //annotation: { 1: {style: 'none'}},
                        //width:450,						
                        pointSize: 6,
                        annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#74767D',
                            fontSize: 15
                        },
                        height:gheight,
                        title:'Salary growth in the company',
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
                            title: 'Year',
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
                        annotations: { stemColor: 'transparent', style: 'line', textStyle: {opacity:showlbl } },
                        titleTextStyle: {
                            color: '#74767D',
                            fontSize: 15
                        },
                        height:gheight,
                        title:'Salary growth in the company',
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
							title: 'Year',
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
		   $("#salary_movement_chart").html("<br><p style='font-size: 14px; margin-top: 10px;font-weight: bold; color: #74767D; text-align: center;'>Salary growth in the company</p>No record found.");
                   //$("#salary_movement_chart").css("text-align","center");
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
                    top:"15%",
                    position:"fixed",
                    "z-index":"10"
                });

                drawSalaryMovementChart("75%","click");
				setGraphHeaderStyles("45");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawSalaryMovementChart();
                setGraphHeaderStyles();
            }            
        });
		
	
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
                drawCurrentMarketPositioning("75%","click");
				setGraphHeaderStyles("45");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawCurrentMarketPositioning();
                setGraphHeaderStyles();
            }
            
        });
        
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
                drawComparisonWithPeers("75%","click");
                //setGraphHeaderStyles();
				setGraphHeaderStyles("45");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawComparisonWithPeers();
                setGraphHeaderStyles();
                arrangeBottomCharts();
            }
            
        });
        
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
                drawComparisonWithTeam("75%","click");
                //setGraphHeaderStyles();
				setGraphHeaderStyles("45");
            }
            else
            {
                $('#popoverlay').hide();
                $(this).html("");
                $(this).removeAttr("style");
                drawComparisonWithTeam();
                arrangeBottomCharts();
            }
            
        });
        
	function setGraphHeaderStyles(wdth = 25)
	{
		//for setting title styles
		var y, labels =  document.querySelectorAll('[text-anchor="start"]');
		for (var i=0;i<labels.length;i++) { 
		   //y = parseInt(labels[i].getAttribute('y'));
		   //labels[i].setAttribute('x', 190);
		   //labels[i].setAttribute('x', wdth+"%");
		   labels[i].setAttribute('font-family', 'roboto');
		   //labels[i].setAttribute('font-weight', 'bold');
		  // labels[i].setAttribute('font-size', 14);
		   //labels[i].setAttribute('text-align', 'center');
		   //labels[i].setAttribute('text-decoration', 'underline');
		   //#74767D
		   //labels[i].setAttribute('font-color', '#74767D');
		   
		   var titl = labels[i].textContent;
		   //console.log(titl);
		   if(titl=='Salary growth in the company' || titl=='Current Market Positioning'|| titl=='Comparison with Team' || titl=='Comparison with Peers -' || titl=='Designation' || titl=='Comparison with Peers - Designation' || titl=='Comparison with Peers - level' )
		   {
				labels[i].setAttribute('x', wdth+"%");
		   }
		}
	}
    
	function getAjaxSalaryMovementGraph()
	{
		var empid = "<?php echo $salary_dtls['user_id'];?>";
		var type = $("#ddl_team_data_for").val(); 
		var aurl = "<?php echo site_url('manager/dashboard/get_emp_salary_movement_data_graph_adhoc');?>/"+empid+"/"+type; 
		$.ajax({url: aurl, success: function(result)
		{
			$("#salary_movement_chart").html(result);
			setGraphHeaderStyles();
		}});
	}
	    
	function getAjaxPeerGraph()
	{
		var empid = "<?php echo $salary_dtls['user_id'];?>";
		var peer_type = $("#peertype").val();
		var graph_for = $("#ddl_team_data_for").val();//$("#ddl_peer_data_for").val();
		
		var aurl = "<?php echo site_url('manager/dashboard/get_peer_employee_salary_dtls_for_graph_adhoc');?>/"+empid+"/"+peer_type+"/"+graph_for;
		$.ajax({url: aurl, success: function(result){
			$("#comparison_with_peers").html(result);
			setGraphHeaderStyles();
		}});
	}
        
	$(document).ready(function(){
		$(window).resize(function(){
			drawSalaryMovementChart();
			//drawCurrentMarketPositioning();
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
	}
	arrangeBottomCharts();
	
	<?php if($company_dtls["peer_graph_for"] == CV_LEVEL){?>
		$("#peertype").val("<?php echo CV_LEVEL; ?>");
		//getAjaxPeerGraph();
	<?php } ?>
	//getAjaxPeerGraph();
		
	<?php //if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT){?>
		function getAjaxMarketDataMultipleBenchmarkGraph()
		{
			var empid = "<?php echo $salary_dtls['user_id'];?>";
			var type = $("#ddl_team_data_for").val();//$("#ddl_market_data_for").val();				
			var aurl = "<?php echo site_url('manager/dashboard/get_emp_market_data_graph_for_multiple_benchmark_adhoc');?>/"+empid+"/"+type;
			$.ajax({url: aurl, success: function(result)
			{
				$("#current_market_positioning").html(result);
				setGraphHeaderStyles();
			}});
		}
		//getAjaxMarketDataMultipleBenchmarkGraph();
	<?php //} ?>
		
		
	function getAjaxTeamDataForGraph()
	{
		var empid = "<?php echo $salary_dtls['user_id'];?>";
		var type = $("#ddl_team_data_for").val();
		var aurl = "<?php echo site_url('manager/dashboard/get_emp_team_data_for_graph_adhoc');?>/"+empid+"/"+type;
		$.ajax({url: aurl, success: function(result)
		{
			$("#comparison_with_team").html(result);
			setGraphHeaderStyles();
		}});
		getAjaxSalaryMovementGraph();
		getAjaxMarketDataMultipleBenchmarkGraph();
		getAjaxPeerGraph();
	}
	getAjaxTeamDataForGraph();
</script> 
<script src="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.concat.min.js"></script> 
<script type="text/javascript">
	$(document).ready(function () {
		$("#sidebar").mCustomScrollbar({
			theme: "minimal"
		});

		$('#dismiss, .overlay').on('click', function () {
			$('#sidebar').removeClass('active');
			$('.overlay').fadeOut();
		});

		$('#sidebarCollapse').on('click', function () {
			$('#sidebar').addClass('active');
			$('.overlay').fadeIn();
			$('.collapse.in').toggleClass('in');
			$('a[aria-expanded=true]').attr('aria-expanded', 'false');
		});
	});
	$(document).ready(function() {
		$('#example').DataTable({
			"paging":   false,
			 "info":     false,
			 "searching": false
		});
	});
</script>