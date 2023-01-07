<link rel="stylesheet" href="<?php echo base_url('assets/custom/css/myStyle.css');?>">
<link rel="stylesheet" media="screen and (max-width: 45em)" href="<?php echo base_url('assets/custom/css/mobile.css');?>">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <style>

.darkOverlay input:focus, .darkOverlay select:focus,.darkOverlay textarea:focus  {
	background-color: transparent !important;
  	border-top: 0;
    border-left: 0;
        border: 0 !important;
    border-right: 0;
        color: #F57F19 !important;
}
.darkOverlay {
	width: 165px;
	height: 75px;
}
.form-control:focus {
  	border-top: 0 !important;
    border-left: 0 !important;
    border-right: 0  !important;
    border-bottom: 0 solid #fff;
        border: 0 !important;
    box-shadow: none  !important;

    color: #F57F19;
}
.customPlus {
	position: relative;
	top: -35px;
}
.customPlus .fa {
	font-size: 40px;
}
.darkOverlay textarea {
	resize: none;
}
.form-control::-webkit-input-placeholder { 
    color: #F57F19;
}
.form-control:-moz-placeholder { 
    color: #F57F19;
}
.form-control::-moz-placeholder { 
    color: #F57F19;
}
.form-control:-ms-input-placeholder { 
    color: #F57F19;
}
.form-control::-ms-input-placeholder { 
    color: #F57F19;
}
.darkOverlay input, .darkOverlay select {
	background-color: transparent;
	max-width: 200px;
	color: #F57F19 !important;
     border: 0 !important;
    padding-left: 0 !important;
      font-family: "Roboto";
      font-size: 18px;
}
.promoSelect h4 {
	margin-bottom: 0;
}
.darkOverlay textarea {
	background-color: transparent;
    width: 406px;
    color: #F57F19 !important;
    border: 0 !important;
    overflow: auto !important;
    overflow-y: auto;
    padding: 0;
    height: 37px !important;
    padding-left: 0 !important;
     font-family: "Roboto";
      font-size: 18px;
}
.promoSelect {
	height: 100% !important;
	padding-bottom: 30px;
	position: relative;
}
.promoSelect h4 {
	padding-top: 15px;
}
.save {
	position: absolute;
	top: 10px;
    right: 68px;
    height: 23px;
}
.btnsave{
    position: absolute;
 top: initial !important; 
right: 15px;
height: 23px;
background-size: 100%;
width: 30px;
height: 30px;
padding-left: 5px !important;
background-repeat: no-repeat;
background-image: url('<?php echo base_url() ?>assets/images/ok.png');
position: absolute;
bottom: 10px !important;
}
.cancel {
    position: absolute;
    top: 10px;
    right: 14px;
}
.promoSelect .form-control {
    display: inline-block;
    height: 30px;
    margin: 2px 5px 2px 2px;
}
.promoOverlay {
    width: 100%;
}
.darkOverlay select {
	height: 30px;
	display: inline-block;
}
.move-link {
	position: relative;
	left: 5px;
}
.darkOverlay input, .darkOverlay select{ color :#fff;}
	.save-link1 {
    display: inline-block;
    float: left;
    font-size: 12px;
    padding: 2px 5px;}
   .centerPartTop span input{ 
    border-radius: 50%;
    color: black;
    height: 60px;
    width: 60px;
  	border:none;
}
 .centerPartBottom span input{
 	 border-radius: 50%;
    color: black;
    height: 60px;
    width: 60px;
  	border:none;
 }
.page-inner {
    padding-bottom:  0 !important;
   }
 /*.bg-1{background-color: #f5f5f5;} */
  
.ui-autocomplete
{         
 max-height: 200px; 
 overflow-y: auto;         
 overflow-x: hidden;         
 padding: 0px;
 margin: 0px;
 /*max-width:197px !important;*/
 background-color:#FFFFFF !important;
}

.popoverlay{ width:100%;
    height:100%;
    display:none;
    position:fixed;
    top:0px;
    left:0px;
    background:rgba(0,0,0,0.75);
    z-index: 9;}
#dv_salary_increase_part2 div h2{margin:35px auto;}
@media only screen and (min-width:600px)  {

.no-pad-right{padding-right: 0px !important;}
.no-pad-left{padding-left: 0px !important;}
.container1 p{
    font-size: 13px;
    font-weight: 100; 
    color: black;
    margin-bottom: 25px;
}
/*.chart{ box-shadow: 0px 0px 1px 1px #888888;}*/
.topchart{ margin-bottom: 10px;}
    
/*.bottomchart{ margin-top: -45px;}
    body{background-color:red;} */
}
/*my css*/
div#salary_movement_chart{
    background-color: white;
    padding: 86px 0;
    margin: 30px 0 10px 0px;
    width: 100%;
    /* border: 1px solid;*/

}
div#comparison_with_team h2, #comparison_with_peers h2 {
 font-size: 14px;
}
.padLess1{
    /*border: 1px solid;*/
    background: white;
    margin: 29px 0px 0px px;
}
div#comparison_with_peers {
 background-color: white;
    height: 294px;
}
div#comparison_with_team{
 background-color: white;
    height: 294px;
    /*border: 1px solid;*/
    padding: 25px 0 0 0;
}
div#current_market_positioning {
    /* height: 278px; */
    background-color: white;
    padding: 86px 0;
    margin: 30px 0 10px -0;
    width: 100%;
}
.rightCir{
 color: black;
}
.centerPartBottom
{
 /*background-color: black;*/
    width: 78%;
    margin: 0 auto;
    border-radius: 20px;
    box-shadow: 0px 2px 22px 5px #aaa;
    /* margin: 14px 5px 0px; */
    margin-top: 20px;
    height: 148px;
    background-image: url(<?php echo base_url("assets/custom/img/bg-blackColor.png"); ?>);;
    height: 126px;
}

.bg-1{
    background-image: url(<?php echo base_url("assets/custom/img/bg-page.png"); ?>);;
    background-size: cover;
background-color: blanchedalmond;}

/*main.page-content.content-wrap{
 background-color: blanchedalmond;
   background-image: url("");
    background-size: cover;

}*/
.n1{
    padding-left: 12px;
    padding-right: 4px;

}
.centerPartTop{

     background-image: url(<?php echo base_url("assets/custom/img/bg-blackColor.png"); ?>);}
     .centerPart{
      background-image: url(<?php echo base_url("assets/custom/img/bg-white.png"); ?>);
      background-size: contain;
      border: 1px solid rgba(191, 190, 202, 0.24);
      border-width: 0px 2px 0px 2px:;
      margin: 0 -26px 0 -26px;
     }

.salaryLeft{
    padding: 20px 0 0 0;
}
.leftPart{
padding:13px 11px;}
@media only screen and (min-width: 992px) {
 .bg-1 .col-md-3.cust-md-3 {
 width: 30%;
 }
 .bg-1 .col-md-6.cust-md-6 {
  width: 40%;
 }
}
.centerBottomCir{
 background-image: none;
}
h4#head{
 padding: 19px 0 0 19px;
 font-weight: 400;
}
.promotionleft{
 padding: 5px 0 0 0;
}
h4#promotion_salary {
   
    margin-top: -5px;
    color: rgba(255,255,255,0.7);
    font-size: 11px;
    text-align: left;
    padding: 0 0 0 40px;

}
h4.text-center{
 font-weight: 400;
 text-align: center;
  padding: 0 !important;
}
h4#heading2 {
 font-weight: 400;
 text-align: center;
    padding: 0 0 0 40px;
    font-size: 16px;
}

.first-icon{
 padding: 0px 0 0 93px;
    margin-top: 12px;
    color: rgba(255,255,255,1);
     font-size: 26px;
}
/*.second-icon{
 margin-top: 22px;
    margin-right: 12px;
        color: rgba(255,255,255,0.7);
        font-size: 26px;
}
.third-icon{
     color: rgba(255,255,255,0.7);
     font-size: 26px;
}*/
.c1 {
    padding: 13px 0 0 0;
    word-spacing: 9px;
    font-size: 26px;
    color: rgba(255,255,255,0.7);
}
.centerPartTop span{
 font-weight: 700;
} 
.cir{
 font-weight: 700;
 padding: 0 0 0 14px;
}
h4#view_emp_salary_salary{
 text-align: left;
    padding: 0 0 0 40px;
}
.mainHeading {
	font-family: "Roboto";
	font-weight: 500;
	font-size: 21px;
	text-align: center;
	margin: 15px 0 5px 0;
	color: #000;
}
.s1, .rightCir h2 {
	margin-top: 0;
}
.rightCir {
    margin: 10px auto;
    position: relative;
    left: 9px;
    top: -12px;
}
.s1 {
	margin-bottom: 7px;
	color: #000;
}
.leftCurrent {
	padding-left: 0;
}
.s1, .s2, .rightCurrent p  {
	font-family: "Roboto";
	font-weight: 400;
	font-size: 17px;	
}
.s2  {
	font-size: 15px !important;
	margin-top: 5px !important;
}
.rightCurrent p, .rightCir {
	display: inline-block;
}
.rightCurrent p {
    max-width: 114px;
    text-align: right;
    margin: 15px 0 0 0px;
}
.padLess1 {
	background: transparent;
}
.centerPartBottom {
	margin-top: 10px;
}
.centerPart {
	background: #fff;
	border: 0;
	margin: 12px -15px 10px -15px;
	padding: 10px;
}
.centerPartBottom, .centerPartTop {
	box-shadow: none;
	width: 100%;
	    background-image: url('<?php echo base_url() ?>assets/images/card-2.png');
    background-size: cover;
}
.leftPart {
	padding: 0;
}
.customWhite {
	background-color: #fff;
    padding: 5px 20px 0 20px;
    background-image: url('<?php echo base_url() ?>assets/images/card-1.png');
    background-size: cover;	
}
.rightCir {
	background-image: url('<?php echo base_url() ?>assets/images/c2.png')
}
.sal {
	color: #fff;
	font-family: "Roboto";
	font-size: 24px !important;
	padding: 0 0 0 27px !important;
}
.salR {
	color: #fff !important;
	font-family: "Roboto";
	font-size: 22px !important;
	font-weight: 500 !important;
	padding: 0 0 0 27px !important;
	margin-top: 15px !important;
}
.salB {
	color: #fff !important;
    font-family: "Roboto";
    font-size: 34px !important;
    position: relative;
    top: 20px;
    left: 18px;
}
.setIcons {
  	position: relative;
    left: -18px;
    top: 40px;
}
.setIcons  i {
  font-size: 30px;
}
.salP {
	left: 0;
}
.setP {
    left: -69px;
    top: 31px;
}
.customRowPad {
	padding: 20px 0;
}
.centerPartBottom {
	height: 179px;
}
.setPlus {
    top: 8px;
    left: -14px;
}
.twoShow {
	display: none
}
h4#heading2 {
	margin: 0;
	line-height: 22px;
}
.custR {
    margin: 10px 0 0 0 !important;
    padding-top: 0 !important
}
h4#head {
	padding-left: 0;
	position: relative;
	left: -20px;
}
.btn-pdf {
    float: right;
    position: relative;
}
.btn-top-pdf {
    bottom: 41px;
}
.btn-bot-pdf {
	bottom: 31px;
}
.cst {
    top: -21px;
    left: 81px;
}
  </style>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script>
 $( function() {    
    $( "#txt_emp_new_designation").autocomplete({
        minLength: 2,
        method: "POST",
        source: '<?php echo site_url("manager/dashboard/get_designations_autocomplete"); ?>',
        open: function() { 
            var wdt =$( "#txt_emp_new_designation").outerWidth();
            console.log("width"+wdt);
            $('#txt_emp_new_designation').autocomplete("widget").width(wdt); 
        },
        select: function(event, ui) {

     }
    });
  } );
</script>
<?php $total_sal_incr_per = round($salary_dtls["manager_discretions"]); ?>
 <div class="page-title">
    <div class="container">
        <div class="page-title-heading">
            <h3>Salary Review for <?php echo $salary_dtls["name"]; ?>, <span style="font-size:12px;">(<?php echo $salary_dtls["current_designation"]; ?>)</span></h3>
        </div>
        <div class="page-title-controls">
            <ul>
               
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div> 

<div id="popoverlay" class=" popoverlay"></div>
<!-- Container (TOUR Section) -->
<div id="tour" class="bg-1">
<div class="container">
<!-- 	<div class="container-fluid"> -->
<!--                 <div class="row text-center container1">
                    <div class="col-lg-5 col-md-5"> -->
                        <!--<h2>Salary Movement Chart</h2>-->
<!--                         <div id="salary_movement_chart" class="chart topchart"  ></div>
                    </div>
                    <div class="col-lg-2 col-md-2 ">&nbsp;</div>
                    <div class="col-lg-5 col-md-5 "> -->
                        <!--<h2>Current Market Positioning</h2>-->
           <!--              <div id="current_market_positioning" class="chart topchart" style="text-align:right"></div>
                    </div>
                </div> -->
		<div class="row text-center container1">
		<div class="col-md-3 cust-md-3 padLess">
			 <div id="salary_movement_chart" class="chart topchart"></div>
                         <div class="smc"></div>
                         <button class="btn btn-sm btn-info btn-pdf btn-top-pdf" onclick="downloadchart('smc')"><span class="fa fa-file-pdf-o"></span></button>
			 


                        <!--<h2>Comparison with Peers</h2>-->
            <div style=" position: relative ">
				<div id="comparison_with_peers" class="chart bottomchart" style="text-align:left"></div>
                                <div class="cwp"></div>
                        <button class="btn btn-sm btn-info btn-pdf btn-bot-pdf" onclick="downloadchart('cwp')"><span class="fa fa-file-pdf-o"></span></button>
				<div style="position: absolute;left: 84%;top: 10%;" class="fa fa-arrows-alt" aria-hidden="true"></div>
				<div style="position: absolute;right: 10%;bottom: 5%;">
                      	<?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?> 
                        <?php if(count($peer_salary_graph_dtls)> 1){ ?>
                        Compare on :
                        <select name="peertype" id="peertype" class="form-group" onchange="getAjaxPeerGraph()">
                            <option value="<?php echo CV_GRADE;?>"> Designation</option>
                            <option value="<?php echo CV_LEVEL;?>"> Level</option>
                        </select>
                        <?php } } ?>
				</div> 
		</div>
                        <br/>
                  
                   
                
<!--                 <div class="row text-center container1">
                    <div class="col-lg-5 col-md-5">
             
                        <div id="salary_movement_chart" class="chart topchart"  ></div>
                    </div>
                    <div class="col-lg-2 col-md-2 ">&nbsp;</div>
                    <div class="col-lg-5 col-md-5 ">
               
                        <div id="current_market_positioning" class="chart topchart" style="text-align:right"></div>
                    </div>
                </div> -->
		</div>
		<div class="col-md-6 cust-md-6 padLess1">
			
		<div class="leftPart">
			<!-- <div class="col-lg-5 col-md-5 leftPart"> -->
                    <!--         <div class="row">
                                <div class="col-lg-9 col-md-9 col-md-offset-3 col-lg-offset-3" style="text-align: center"> -->
                                 <div class="row customWhite">
                                 	<div class="col-md-12">
                                 		<h2 class="mainHeading">Current</h2>
                                 	</div>
                                 	<div class="col-md-6">
                                 		<div class="leftCurrent">
                                 			<h2 class="s1">Annual Salary</h2>
                                 			<h4 class="s2">Rs <?php echo HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]); ?>
											</h4>
                                 		</div><!--.leftCurrent-->
                                 	</div>
                             		<div class="col-md-6">
                                 		<div class="rightCurrent">
                         				<p class="text-center">Comparative Ratio</p>  
                                 		<div class="rightCir" >
                                 				<h2><?php //echo $salary_dtls["crr_based_increment"]; 
							if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common(($salary_dtls["increment_applied_on_salary"]/$salary_dtls["market_salary"])*100,0);}else{echo 0;}
							?>%
						</h2>
						</div>
					  
                                 		</div><!--.leftCurrent-->
                                 	</div>
                                 </div>
                     <!--                <div class="row">
                                    <div class="col-md-12">
                                    <div class="underline1">
                                    </div>
                                    </div>
                                    </div> -->
                   <!--              </div>
                                    
                            </div> -->
                            <!-- <div class="row"> -->
	<!-- 			<div class="col-lg-6 col-md-6  col-md-offset-3 col-lg-offset-3 no-pad-right">
					<h4>Rs <?php echo number_format($salary_dtls["increment_applied_on_salary"], 0, '.', ','); ?>
					</h4>
					<p>Salary</p>
				</div> -->
<!-- 				<div class="col-lg-3 col-md-3 no-pad-left">
					
					<div class="leftCir" >
						<h2><?php //echo $salary_dtls["crr_based_increment"]; 
							if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common(($salary_dtls["increment_applied_on_salary"]/$salary_dtls["market_salary"])*100,0);}else{echo 0;}
							?>%
						</h2>
					</div>
					<p class="text-center">Comparative Ratio</p>     
				</div> -->
                            <!-- </div> -->
		<!-- 	</div>	 -->		
			

			<div id="cntcenterpart" class="centerPart">
		<!-- <div id="cntcenterpart" class="col-lg-2 col-md-2 centerPart">   -->
			<!-- <img src="../../../../assets/custom/img/bg-white.png"> -->
		
				<div id="dv_salary_increase_part1" class=" centerPartTop"> 				
					
					<!-- <h4 id="view_emp_salary_salary">
						RS <?php echo number_format(($salary_dtls["increment_applied_on_salary"]*$total_sal_incr_per)/100, 0, '.', ','); //$salary_dtls["performnace_based_salary"]; ?>
						
						<?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
						<a href="javascript:;" id="lnk_view_emp_salary_per"><span class="glyphicon glyphicon-pencil"></span></a>
					<?php } ?>
					
					</h4>
					</div>
					<div class="col-md-6">
					<div class="centerTopCir">
						<h2>
							<span class="salary-blue-box" id="spn_view_emp_salary_per">
							<?php $total_sal_incr_per = round($salary_dtls["manager_discretions"]);echo $total_sal_incr_per; ?></span>%					
						</h2>
					</div> 
					</div>
					</div>
 -->
 									<div class="row customRowPad">
						<div class="col-md-12">
<!-- 							<div class="salaryLeft"> -->
								<h4 class="text-center sal">Salary Review</h4>
  							<h4 id="view_emp_salary_salary" class="salR darkOverlay hide-element1" style="float: left">
      						Rs <?php echo HLP_get_formated_amount_common(($salary_dtls["increment_applied_on_salary"]*$total_sal_incr_per)/100, 0, '.', ','); //$salary_dtls["performnace_based_salary"]; ?>              
  					     </h4>

           <?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
            <!--<a href="javascript:;" id="lnk_view_emp_salary_per" class="edit-link1"><span class="glyphicon glyphicon-pencil"></span></a>-->
          <div class="darkOverlay show-element1" style="float: left;margin-left: 15px; display: none">
           <input type="text" onblur="getper(this.value)" id="am" autocomplete="off" class="form-control" placeholder="Enter your Amount" name="amount" required>
           <input  type="hidden" id="hiddensal" value="<?php echo round($salary_dtls["increment_applied_on_salary"]) ?>" />
          </div>
                   <script>
                  function showold()
                  {
                      $(this).hide();
                      $('.hide-element1').show();
                      $('.show-element1').hide();
                  }
                  function getamt(cp)
                  {
                      var oldsal=$('#hiddensal').val();
                      //alert(oldsal+cp)
                      $('#am').val(((parseInt(oldsal)*parseInt(cp))/100));
                  }
                  function getper(cp)
                  {
                      var oldsal=$('#hiddensal').val();
                      //alert(oldsal+cp)
                      //alert((parseInt(cp)/(parseInt(oldsal))*100).toFixed(2));
                      $('#txt_emp_salary_per').val(get_formated_percentage_common(parseInt(cp)/(parseInt(oldsal))*100, 0));
                  }
                  </script>
            <?php } ?>
         <!--    <?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
   
                                <div class="show-element1" style="display: none">
                                                    <div class="form-inline darkOverlay">
                                            <input style="width:90px"  type="text" onblur="getper(this.value)" id="am" autocomplete="off" class="form-control" placeholder="Enter your Amount" name="amount" required>
                                            <input  type="hidden" id="hiddensal" value="<?php echo round($salary_dtls["increment_applied_on_salary"]) ?>" />
                                            <input class="form-control" type="text"onblur="getamt(this.value)" name="txt_emp_salary_per" id="txt_emp_salary_per" maxlength="5" size="1" value="<?php echo $total_sal_incr_per; ?>" /> %
                                            <input type="hidden" name="hf_emp_salary_per" id="hf_emp_salary_per" value="<?php echo $total_sal_incr_per; ?>" />
                                            <input type="hidden" name="hf_emp_sal_id" id="hf_emp_sal_id" value="<?php echo $salary_dtls["id"]; ?>" />
                                            <span><button type="button" onclick="update_emp_salary_per();" class="btn btn-primary save-link1">Save</button></span>
                                            <span><button type="submit" onclick="showold()" class="btn btn-primary save-link1 move-link">Cancel</button></span>
                                        </div>
                                    <script>
                                        function showold()
                                        {
                                            $(this).hide();
                                            $('.hide-element1').show();
                                            $('.show-element1').hide();
                                        }
                                        function getamt(cp)
                                        {
                                            var oldsal=$('#hiddensal').val();
                                            //alert(oldsal+cp)
                                            $('#am').val(((parseInt(oldsal)*parseInt(cp))/100));
                                        }
                                        function getper(cp)
                                        {
                                            var oldsal=$('#hiddensal').val();
                                            //alert(oldsal+cp)
                                            //alert((parseInt(cp)/(parseInt(oldsal))*100).toFixed(2));
                                            $('#txt_emp_salary_per').val((parseInt(cp)/(parseInt(oldsal))*100).toFixed(0));
                                        }
                                        </script>
                                    </div>
                        
          <?php } ?> -->
            
                <h2 style="text-align: right;float: right;margin-bottom: 26px;">
              <span class="salary-blue-box salB cst hide-element1" id="spn_view_emp_salary_per">
              <?php $total_sal_incr_per = round($salary_dtls["manager_discretions"]);echo $total_sal_incr_per; ?>%  
              </span>

                <?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
            <!--<a href="javascript:;" id="lnk_view_emp_salary_per" class="edit-link1"><span class="glyphicon glyphicon-pencil"></span></a>-->
                  <div class="darkOverlay show-element1" style="float: right;margin-right: 15px; display: none;position: absolute;top: 47px;right: 19px;">
                         <input class="form-control" type="text"onblur="getamt(this.value)" name="txt_emp_salary_per" id="txt_emp_salary_per" maxlength="5" size="1" value="<?php echo $total_sal_incr_per; ?>" />
                          <input type="hidden" name="hf_emp_salary_per" id="hf_emp_salary_per" value="<?php echo $total_sal_incr_per; ?>" />
                          <input type="hidden" name="hf_emp_sal_id" id="hf_emp_sal_id" value="<?php echo $salary_dtls["id"]; ?>" />
                      </div>
                  <?php } ?>
              <span class="setIcons">
                <img class="first-icon edit-link1 hide-element1" src="<?php echo base_url() ?>assets/images/edit.png">
                <img style="position: relative;top: 37px;right: 16px;max-width: 123px;" class="first-icon save-link1 show-element1" onclick="update_emp_salary_per();" src="<?php echo base_url() ?>assets/images/ok.png">
                <!-- <i class="fa fa-trash-o first-icon edit-link1" aria-hidden="true"></i>  -->
              </span>   
            </h2>
						<!-- 	</div> -->
						</div>
<!-- 						<div class="col-md-12">
							<div class="salaryRight">
								<div class="centerTopCir">
						<h2 style="text-align: right">
							<span class="salary-blue-box salB" id="spn_view_emp_salary_per">
							<?php $total_sal_incr_per = round($salary_dtls["manager_discretions"]);echo $total_sal_incr_per; ?>%	
							</span>
							<span class="setIcons">
								<i class="fa fa-pencil-square-o first-icon edit-link1" aria-hidden="true"></i>
								 <i class="fa fa-trash-o first-icon edit-link1" aria-hidden="true"></i>	 -->
					<!--		</span>		
						</h2>
						
					</div> 
							</div>
						</div> -->
					</div>


				<!-- 	<div class="centerTopCir">
						<h2>
							<span class="salary-blue-box" id="spn_view_emp_salary_per">
							<?php $total_sal_incr_per = round($salary_dtls["manager_discretions"]);echo $total_sal_incr_per; ?></span>%					
						</h2>
					</div>  -->
			<!-- 		<h4 id="view_emp_salary_salary">
						RS <?php echo number_format(($salary_dtls["increment_applied_on_salary"]*$total_sal_incr_per)/100, 0, '.', ','); //$salary_dtls["performnace_based_salary"]; ?>
						
						<?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
						<a href="javascript:;" id="lnk_view_emp_salary_per"><span class="glyphicon glyphicon-pencil"></span></a>
					<?php } ?>
					
					</h4>  -->
				</div>
				
				<?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?> 
					<div class=" centerPartTop " id="dv_salary_increase_part2" style="display:none;">
						<h4 class="text-center">SALARY INCREASE</h4>					
						<div class="form-group">
							<h2>
								<span class="cir">
									<input name="txt_emp_salary_per" id="txt_emp_salary_per"  maxlength="5" size="1" value="<?php echo $total_sal_incr_per; ?>" style="color:black; text-align:center" /> %
									<input type="hidden" name="hf_emp_salary_per" id="hf_emp_salary_per" value="<?php echo $total_sal_incr_per; ?>" />
									<input type="hidden" name="hf_emp_sal_id" id="hf_emp_sal_id" value="<?php echo $salary_dtls["id"]; ?>" />
								</span>
							</h2>
							<h4></h4>
							<button id="save" onclick="update_emp_salary_per();" type="button" class="btn btn-primary btn-xs save" style="background-color:red !important;">Save</button>
							<button id="cancel" onclick="hide_dv('1');" type="button" class="btn btn-primary btn-xs cancel" style="background-color:red !important;">Cancel</button>
							<h4></h4>
						</div>						
					</div>
				<?php } ?>
				  
				<?php $sp_per=0; if($salary_dtls["sp_manager_discretions"] <= 0){ 
					  $sp_per=$salary_dtls["standard_promotion_increase"];?>




					<div id="dv_promotion_part1" class="centerPartBottom">
						<div class="row customRowPad">
							<div class="col-md-12">
								<div class="promotionleft">
						<h4 id="heading2" class="sal" style="margin: 5px 0 10px 0 !important">Promotion Recommendation</h4>
						<h4 id="promotion_salary" class="salR custR" style="float: left">Rs <?php echo HLP_get_formated_amount_common($salary_dtls["sp_increased_salary"]); ?>
						
						<?php /* if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
							<a id="lnk_promotion_part1" href="javascript:;">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>
							&nbsp;
							<a href="javascript:;" onclick="delete_promotion_dtls()">
								<span class="glyphicon glyphicon-trash" style="color:#FF0000"></span>
							</a>
						<?php }*/ ?>
						</h4>	
              <div class="centerBottomCir" style="float: right;position: relative;top: -38px;">
                 <h2 class="">
                  <span class="cir salB salP" style="position: relative;left: -40px;">
                  <?php echo round($sp_per); ?>%
                  </span>
                  <span class="setIcons setP">
                    <img class="first-icon edit-link2 hide-element2" src="<?php echo base_url() ?>assets/images/edit.png">
                <!--     <i class="fa fa-pencil-square-o first-icon editing" aria-hidden="true"></i> -->
                    <!-- <i class="fa fa-trash-o first-icon delete" aria-hidden="true"></i> --> 
                  </span>
        <!--          <span class="setIcons setPlus oneShow">
                    <i class="fa fa-plus first-icon" aria-hidden="true"></i>  
                  </span>  -->
                </h2>
  
                <!-- <div class="c1">
                  <i class="fa fa-trash-o second-icon" aria-hidden="true"></i>
                  <i class="fa fa-pencil-square-o third-icon" aria-hidden="true"></i>
                </div> -->
                </div><br>
						<h4 id="head" class="s2 custR" style="float: left;position: relative;top: 19px;left: -44px;"><?php echo $salary_dtls["emp_new_designation"]; ?>Sr. Manager</h4> 
					</div>






					</div>
						<a id="lnk_promotion_part1" href="javascript:;">
							<!-- <div class="centerBottomCir centerTopCir">
								<h2>
									<span class="glyphicon glyphicon-plus" style="right: 0px;"></span>
								</h2>
							</div> -->
						</a>
						
							<div class="col-md-6">
						<div class="centerBottomCir" style="display: none;">
								 <h2 class="">
									<span class="cir salB salP">
									<?php echo round($sp_per); ?>%
									</span>
									<span class="setIcons setP">
										<i class="fa fa-pencil-square-o first-icon editing" aria-hidden="true"></i>
										<!-- <i class="fa fa-trash-o first-icon delete" aria-hidden="true"></i> -->	
									</span>
				<!-- 					<span class="setIcons setPlus oneShow">
										<i class="fa fa-plus first-icon" aria-hidden="true"></i>	
									</span>	 -->
								</h2>
	
								<!-- <div class="c1">
									<i class="fa fa-trash-o second-icon" aria-hidden="true"></i>
									<i class="fa fa-pencil-square-o third-icon" aria-hidden="true"></i>
								</div> -->
								</div>
							</div>
	<!-- 						<div class="col-md-12">
								<div class="c1 customPlus" style="display: none">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</div>
							</div> -->
						</div>

					<h4></h4>					
					</div>
				<?php }else{ $sp_per=$salary_dtls["sp_manager_discretions"];?> -->
					<div id="dv_promotion_part1" class="centerPartBottom">
					<div class="row">
						<div class="col-md-6">
							<div class="promotionleft">
						<h4 class="text-center sal">Promotion</h4>

				</div>
						
						

						<div class="col-md-6">
                                                    <h4 class="salR">
							<?php echo $salary_dtls["emp_new_designation"]; ?>
						</h4> 
						<div class="centerBottomCir centerTopCir"><h2><?php echo round($sp_per); ?>%</h2></div>
				 		<h4>Rs <?php echo HLP_get_formated_amount_common($salary_dtls["sp_increased_salary"]); ?>
						
						<?php /*if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
							<a id="lnk_promotion_part1" href="javascript:;">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>
							&nbsp;
							<a href="javascript:;" onclick="delete_promotion_dtls()">
								<span class="glyphicon glyphicon-trash" style="color:#FF0000"></span>
							</a>
						<?php } */ ?>
						</h4>	 				
					</div>
				</div>
                                        </div> 
                                        </div>
				<?php } ?>


				
				<div id="dv_promotion_part2" class="centerPartBottom promoSelect" style="display: none">
					<h4 id="heading2" class="sal" style="padding: 20px 0 14px 0 !important">Promotion Recommendation</h4>
                                        <?php //print_r($salary_dtls) ?>
					<form id="frm_update_emp_promotions" method="post" onsubmit="return update_emp_promotions_dtls(this);" action="<?php echo site_url("manager/update-promotions/".$salary_dtls['id']); ?>">
	
						<div class="form-group darkOverlay promoOverlay">
					      	
                                                    <input style="    background: transparent;" class="form-control" type="text" id="sel1" readonly="true" value="<?php echo $salary_dtls['current_designation'] ?>" />
							<input type="text" class="form-control" placeholder="New Designation" name="txt_emp_new_designation" id="txt_emp_new_designation" value="<?php echo $salary_dtls["emp_new_designation"]; ?>" required>
																 
								<!-- <div class="centerBottomCir centerTopCir">
								 <h2>
									<span class="cir">
										<input name="txt_emp_sp_salary_per" id="txt_emp_sp_salary_per"  maxlength="5" size="1" value="<?php echo round($sp_per); ?>" style="color:black; text-align:center" required/> %
									</span>
								</h2>
								</div> -->
							
							<!-- <h4>Rs <?php // echo number_format(($salary_dtls["increment_applied_on_salary"]*$salary_dtls["sp_manager_discretions"]/100), 2, '.', ','); ?></h4> -->
							<textarea class="form-control" rows="3" id="txt_citation" name="txt_citation" placeholder="Comments" maxlength="150"><?php echo $salary_dtls["emp_citation"]; ?></textarea>
                                                        <input style="position: relative;left:3px;" type="text" onblur="getperr(this.value)" id="amm" autocomplete="off" class="form-control" placeholder="Enter your Amount" name="amount" required>
                                                        <input style="position: relative;left: 10px;" class="form-control" type="text"onblur="getamtt(this.value)" name="txt_emp_sp_salary_per" id="txt_emp_sp_salary_per" maxlength="5" size="1" value="<?php echo $total_sal_incr_per; ?>" /> 
                                                        <!--<img src="<?php echo base_url() ?>assets/images/ok.png" class="saving" style="max-width: 29px; position: absolute; bottom: 10px;right: 15px;">-->
                                                        <input type="submit" style="padding-left: 5px !important" value=""  class="btnsave save" /> 
<!-- 							<button id="Cancel" onclick="hide_dv('2');" type="button" class="btn btn-primary btn-xs cancel">Cancel</button> -->
                                                        <script>
                                                            function getamtt(cp)
                                                                {
                                                                    var oldsal=$('#hiddensal').val();
                                                                    //alert(oldsal+cp)
                                                                    $('#amm').val(((parseInt(oldsal)*parseInt(cp))/100));
                                                                }
                                                                function getperr(cp)
                                                                {
                                                                    var oldsal=$('#hiddensal').val();
                                                                    //alert(oldsal+cp)
                                                                    //alert((parseInt(cp)/(parseInt(oldsal))*100).toFixed(2));
                                                                    $('#txt_emp_sp_salary_per').val(get_formated_percentage_common(parseInt(cp)/(parseInt(oldsal))*100, 0));
                                                                }
                                                        </script>
						</div>
			
					</form>				
				</div> <!--.centrepartbottom-->
				
			</div>

			</div>


			<!-- 
								<div class="row">
                                    <div class="col-md-12">
                                    <div class="underline1">
                                    </div>
                                    </div>
                                    </div> -->



			<div class="row">
			<div class="col-md-12">
				   <div class="row customWhite">
                                 	<div class="col-md-12">
                                 		<h2 class="mainHeading">Revised</h2>
                                 	</div>
                                 	<div class="col-md-6">
                                 		<div class="leftCurrent">
                                 			<h2 class="s1">Annual Salary</h2>
                                 			       <h4 class="s2" id="view_final_salary">
						Rs <?php echo HLP_get_formated_amount_common($salary_dtls["final_salary"]); ?>
					</h4>
                                 		</div><!--.leftCurrent-->
                                 	</div>
                             		<div class="col-md-6">
                                 		<div class="rightCurrent">
                         				<p class="text-center">Comparative Ratio</p>  
                                 		<div class="rightCir" >
                                 				     <h2>
											<span id="revised_comparative_ratio">
												<?php //if($salary_dtls["market_salary"]){echo round($salary_dtls["increment_applied_on_salary"]/$salary_dtls["market_salary"],2);}else{echo 0;}
												if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common(($salary_dtls["final_salary"]/$salary_dtls["market_salary"])*100,0);}else{echo 0;} ?></span>%
										</h2>
						</div>
					  
                                 		</div><!--.leftCurrent-->
                                 	</div>
                                 </div>
			<div class="rightPart">
			<!-- <div class="col-lg-5 col-md-5 rightPart"> -->
                            <!-- <div class="row"> -->
                                <!-- <div class="col-lg-9 col-md-9" style="text-align: center"> -->
<!-- 
                                    <h2 class="s3">Revised</h2>
                                    <h4 id="view_final_salary">
						Rs <?php echo number_format($salary_dtls["final_salary"], 0, '.', ','); ?>
					</h4> -->
                                </div>
                                <!-- <div class="col-lg-3 col-md-3"></div>     -->
                            </div>
                   <!--          <div class="col-md-6">
	                            <div class="leftpart">
		                            <div class="bottomCir" >

				                            <h2>
											<span id="revised_comparative_ratio">
												<?php //if($salary_dtls["market_salary"]){echo round($salary_dtls["increment_applied_on_salary"]/$salary_dtls["market_salary"],2);}else{echo 0;}
												if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common(($salary_dtls["final_salary"]/$salary_dtls["market_salary"])*100,0);}else{echo 0;} ?></span>%
										</h2>
										</div>
										<p class="text-center">Comparative Ratio</p>
									</div>
								</div> -->

						</div><!--.row-->

						</div><!--.col-md-6-->
								<div class="col-md-3 cust-md-3 n1 padLess">
							 	<div id="current_market_positioning" class="chart topchart" style="text-align:right"></div>
                                                                <div class="cmp"></div>
                        <button  class="btn btn-sm btn-info btn-pdf btn-top-pdf" onclick="downloadchart('cmp')"><span class="fa fa-file-pdf-o"></span></button>
							 	<div style="position: relative;">
							 	  <div id="comparison_with_team" class="chart bottomchart" style="text-align: right"></div>
                                                                  <div class="cwt"></div>
                        <button class="btn btn-sm btn-info btn-pdf btn-bot-pdf" onclick="downloadchart('cwt')"><span class="fa fa-file-pdf-o"></span></button>
                        			<div style="position: absolute;left: 88%;top: 10%;" class="fa fa-arrows-alt" aria-hidden="true"></div></div>
							</div>
				<!-- 			 <div class="col-md-3 cust-md-3 ">
                        <h2>Comparison with Team</h2>
                      
                    </div> -->

						</div>
				




                            <!-- <div class="row">
				<div class="col-lg-3 col-md-3 rightPartSub no-pad-right">
					
					 <div class="rightCir" >
						<h2>
							<span id="revised_comparative_ratio">
								<?php //if($salary_dtls["market_salary"]){echo round($salary_dtls["increment_applied_on_salary"]/$salary_dtls["market_salary"],2);}else{echo 0;}
								if($salary_dtls["market_salary"]){echo HLP_get_formated_percentage_common(($salary_dtls["final_salary"]/$salary_dtls["market_salary"])*100,0);}else{echo 0;} ?></span>%
						</h2>
					</div>  
				 	<p class="text-center">Comparative ratio</p>     
				</div> 
				<div class="col-lg-6 col-md-6 no-pad-left">
					<h4 id="view_final_salary">
						Rs <?php echo number_format($salary_dtls["final_salary"], 0, '.', ','); ?>
					</h4>
					<p>Salary</p>
				</div>
                                <div class="col-lg-3 col-md-3"></div>    
                            </div> -->    
			</div>
			</div>
		</div>

                
                <!-- <div class="row text-center container1">
                    <div class="col-lg-5 col-md-5">
                        <!--<h2>Comparison with Peers</h2>-->
			<!-- <div id="comparison_with_peers" class="chart bottomchart" style="text-align:left"></div>
                        <br/>
                        <?php if($this->session->userdata('role_ses') == 10 && $salary_dtls["rule_status"]==6 && strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?> 
                        <?php if(count($peer_salary_graph_dtls)> 1){ ?>
                        Compare on :
                        <select name="peertype" id="peertype" class="form-group" onchange="getAjaxPeerGraph()">
                            <option value="<?php echo CV_GRADE;?>"> Designation</option>
                            <option value="<?php echo CV_LEVEL;?>"> Level</option>
                        </select>
                        <?php } } ?>
                    </div> --> -->
                   <!--  <div class="col-lg-2 col-md-2 ">&nbsp;</div> -->
                    <!-- <div class="col-lg-5 col-md-5 "> -->
                        <!--<h2>Comparison with Team</h2>-->
                        <!-- <div id="comparison_with_team" class="chart bottomchart" style="text-align: right"></div> -->
                    </div>
                </div>
	</div>  
  <!-- Modal --> 
</div>


<?php if($this->session->userdata('role_ses') == 10 and $salary_dtls["rule_status"]==6 and strtolower($salary_dtls["manager_emailid"]) == strtolower($this->session->userdata('email_ses'))){?>
	<script>
	/*$("#edit_emp_salary").click(function()*/
	$("#lnk_view_emp_salary_per").click(function()  
	{
		<?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
			 custom_alert_popup("You do not have update inrements rights.");
			 return false;
		<?php } ?>
		
		$("#dv_salary_increase_part2").show();
		$("#dv_salary_increase_part1").hide();
		$("#txt_emp_salary_per").focus();
	}); 
	function update_emp_salary_per()
	{
		<?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
			 custom_alert_popup("You do not have update inrements rights.");
			 return false;
		<?php } ?>
		var txt_val = $.trim($("#txt_emp_salary_per").val());
		var emp_sal_id = $.trim($("#hf_emp_sal_id").val());
                if(txt_val=='')
                {
                    custom_alert_popup('Please enter amount or percentage');
                }
		if((txt_val) && emp_sal_id>0 && txt_val != $("#hf_emp_salary_per").val())
		{
			$.post("<?php echo site_url("manager/dashboard/update_manager_discretions"); ?>",{"emp_sal_id":emp_sal_id, "new_per" : txt_val},function(data)
			{
			   if(data)
			   {
				   var response = JSON.parse(data);
				   $("#txt_name").val(response.emp_name);
				   if(response.status)
				   {
					   $("#hf_emp_salary_per").val(txt_val);
					   $("#spn_view_emp_salary_per").html(txt_val+'%');
					   $("#view_emp_salary_salary").html("Rs "+response.increased_salary);
					   $("#view_final_salary").html("RS "+response.final_updated_salary);
					   $("#revised_comparative_ratio").html(response.revised_comparative_ratio);
				   }
				   else
				   {
					   $("#txt_emp_salary_per").val($("#hf_emp_salary_per").val());
					   custom_alert_popup(response.msg);
				   }
			   }
			   else
			   {
				   $("#txt_emp_salary_per").val($("#hf_emp_salary_per").val());
			   }
			 });
		}
		else
		{
			$("#txt_emp_salary_per").val($("#hf_emp_salary_per").val());
		}
		$("#dv_salary_increase_part2").hide();
		$("#dv_salary_increase_part1").show();
	}
	
	function hide_dv(dv_no)
	{
		if(dv_no == '1')
		{
			$("#txt_emp_salary_per").val($("#hf_emp_salary_per").val());
			$("#dv_salary_increase_part2").hide();
			$("#dv_salary_increase_part1").show();
		}
		else
		{
			//$("#txt_emp_salary_per").val($("#hf_emp_salary_per").val());
			$("#dv_promotion_part2").hide();
			$("#dv_promotion_part1").show();
		}
	}
	
	$("#lnk_promotion_part1").click(function()
	{
		<?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
			 custom_alert_popup("You do not have update inrements rights.");
			 return false;
		<?php } ?>
        $("#dv_promotion_part1").hide();
     	$("#dv_promotion_part2").show();
    });
	
	function update_emp_promotions_dtls(frm)
	{
		<?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
			 custom_alert_popup("You do not have update inrements rights.");
			 return false;
		<?php } ?>
		
	   $("#loading").css('display','block');
		var form=$("#"+frm.id);
		$.ajax({
			type:"POST",
			url:form.attr("action"),
			data:form.serialize(),
			success: function(data)
			{
				var response = JSON.parse(data);
				if(response.status)
				{
					$("#loading").css('display','none');
					window.location.href= "<?php echo current_url();?>";
				}
				else
				{
					$("#loading").css('display','none');
					custom_alert_popup(response.msg);
				}
			}
		});
		return false;
	}

function delete_promotion_dtls()
{
	<?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
		 custom_alert_popup("You do not have update inrements rights.");
		 return false;
	<?php } ?>
		
	var conf = confirm('Are you sure, you want to delete promotion details ?');
	if(conf)
	{
		$("#loading").css('display','block');
		$.ajax({
			type:"POST",
			url:"<?php echo site_url("manager/dashboard/delete_emp_promotions_dtls/".$salary_dtls['id']); ?>",
			success: function(data)
			{
				var response = JSON.parse(data);
				if(response.status)
				{
					$("#loading").css('display','none');
					window.location.href= "<?php echo current_url();?>";
				}
				else
				{
					$("#loading").css('display','none');
					custom_alert_popup(response.msg);
				}
			}
		});
	}
}

	</script>
<?php } ?>

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
	function drawSalaryMovementChart(gheight = 200) 
	{
            var posi = 'out';
            var showlbl = 1;
            if(gheight == 200)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($user_salary_graph_dtls) > 1){ ?>
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
			echo "['Current Year',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",'".HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"])."','point {fill-color: #a52714; font-weight:bold; }'],";
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
                        curveType: 'function'
			
		};
		var chart = new google.visualization.LineChart(document.getElementById('salary_movement_chart'));
		chart.draw(data, options);
                 var h=$( '#salary_movement_chart' ).height();
                $('.smc').css('margin-top','-'+(parseInt(h)+65)+'px');
                $('.smc').css('position','absolute');
                $('.smc').html('<img src="'+chart.getImageURI()+'" />');
                if(gheight == 200)
                {
                    $("#salary_movement_chart").append('<div style="position: absolute;left: 84%;top: 7%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
                }
                <?php }else{ ?>
		   $("#salary_movement_chart").html("<h2>Salary Movement Chart</h2>No record found.");
                   $("#salary_movement_chart").css("text-align","center");
                   $("#salary_movement_chart").removeClass("chart");
		<?php } ?>
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
            
        });
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawCurrentMarketPositioning);
	function drawCurrentMarketPositioning(gheight = 200)
	{
            var posi = 'default';
            var showlbl = 1;
            if(gheight == 200)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($makt_salary_graph_dtls) > 1){ ?>
		var data = google.visualization.arrayToDataTable([
			['%tile','Mysal','Amt', {'type': 'string', 'role': 'annotation'}],
			<?php foreach($makt_salary_graph_dtls as $value) { 
				$mrkt_val = 0;
				if($value["value"])
				{
					$mrkt_val = $value["value"];
				}
				//echo "['".str_replace("market salary for the matched job","",$value["display_name_override"])."',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",".str_replace(",","",$mrkt_val).",'".number_format(str_replace(",","",$mrkt_val), 0, '.', ',')."'],"; 
				echo "['".str_replace("market salary for the matched job","",$value["display_name"])."',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",".str_replace(",","",$mrkt_val).",'".HLP_get_formated_amount_common(str_replace(",","",$mrkt_val))."'],";
			}
			//echo "['Current Salary',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",null,'".str_replace(",","",$salary_dtls["increment_applied_on_salary"])."'],";
                        echo "[' ',".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).",null,'".HLP_get_formated_amount_common(str_replace(",","",$salary_dtls["increment_applied_on_salary"]))."'],";
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
                        curveType: 'function'
		};          
		var chart = new google.visualization.LineChart(document.getElementById('current_market_positioning'));
                chart.draw(data, options);
                 var h=$( '#current_market_positioning' ).height();
                $('.cmp').css('margin-top','-'+(parseInt(h)+65)+'px');
                $('.cmp').css('position','absolute');
                $('.cmp').html('<img src="'+chart.getImageURI()+'" />');
                if(gheight == 200)
                {
                    $("#current_market_positioning").append('<div style="position: absolute;right: 8%;top: 9%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
                }
		<?php }else{ ?>
		   $("#current_market_positioning").html("<h2>Current Market Positioning</h2> <br/> No record found.");
                   $("#current_market_positioning").css("text-align","center");
                   $("#current_market_positioning").removeClass("chart");
		<?php } ?>
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
            
        });
        
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithPeers);
	function drawComparisonWithPeers(gheight=200)
	{
            var posi = 'default';
            var showlbl = 1;
            if(gheight == 200)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
		<?php if(count($peer_salary_graph_dtls)> 1){ ?>
		var data = google.visualization.arrayToDataTable([
			['%tile','PeerSal','Mysal', {'type': 'string', 'role': 'annotation'}],
			<?php $p=1; foreach($peer_salary_graph_dtls as $value) { 
				//echo "['".$value["email"]."',".str_replace(",","",$value["final_salary"])."],"; 
                            echo "['Peer$p',null ,".str_replace(",","",$value["final_salary"]).",'".HLP_get_formated_amount_common(str_replace(",","",$value["final_salary"]))."'],"; 
                            $p++;
			}
			echo "['Current Salary', ".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).", null,'".HLP_get_formated_amount_common(str_replace(",","",$salary_dtls["increment_applied_on_salary"]))."'],";
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
                            0: { pointSize: 6, pointShape: { type: 'circle' }, color: '#a52714' },
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
                    //$("#comparison_with_peers").append('<div id="exppeer" style="position: absolute;right: 3%;bottom: 57%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
                }
		<?php } else{ ?>
		   $("#comparison_with_peers").html("<h2>Comparison with Peers</h2> <br/> No record found.");
                   $("#comparison_with_peers").css("text-align","center");
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
            }
            
        });
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawComparisonWithTeam);
	function drawComparisonWithTeam(gheight = 200)
        {
            var posi = 'default';
            var showlbl = 1;
            if(gheight == 200)
            {
                showlbl = 0;
                posi = 'none';
            }
            //textPosition: posi
            
            <?php if(count($team_salary_graph_dtls) > 1){ ?>
            var data = google.visualization.arrayToDataTable([
             ['Employee','Salary','Mysal', {'type': 'string', 'role': 'annotation'}],
             <?php $p=1; foreach($team_salary_graph_dtls as $value) { 
              echo "['Memeber$p' ,null ,".str_replace(",","",$value["final_salary"]).",'".HLP_get_formated_amount_common(str_replace(",","",$value["final_salary"]))."'],"; 
                                          $p++;
             }
             echo "['Current Salary', ".str_replace(",","",$salary_dtls["increment_applied_on_salary"]).", null,'".HLP_get_formated_amount_common(str_replace(",","",$salary_dtls["increment_applied_on_salary"]))."'],";
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
                                      0: { color: '#a52714' },
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
                $("#comparison_with_team").append('<div style="position: absolute;right: 3%;bottom: 5%;" class="fa fa-arrows-alt" aria-hidden="true"></div>');
            }
            <?php } else{ ?>
               $("#comparison_with_team").html("<h2>Comparison with Team</h2> <br/>No record found.");
                             $("#comparison_with_team").css("text-align","center");
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
            var empid = "<?php echo $salary_dtls['id'];?>";
            var type = $("#peertype").val();
            var aurl = "<?php echo site_url('manager/dashboard/get_peer_employee_salary_dtls_for_graph');?>/"+empid+"/"+type;
            //alert(aurl);return;
            $.ajax({url: aurl, success: function(result){
                $("#comparison_with_peers").html(result);
                setGraphHeaderStyles();
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
        }
        arrangeBottomCharts();
		
		
$('.edit-link1').click(() => {
    $(this).hide();
    $('.hide-element1').hide();
	$('.show-element1').show();
});
$('.save-link1').click(() => {
    $(this).hide();
    $('.hide-element1').show();
	$('.show-element1').hide();
});
$('.edit-link2').click(() => {
    $(this).hide();
    $('.hide-element2').hide();
  $('.show-element2').show();
});
$('.oneShow i, .edit-link2').click(() => {
	$('#dv_promotion_part1').hide();
	$('#dv_promotion_part2').show();
}); 
$('.cancel').click(() => {
	$('h4#heading2').css('margin', '0');
	$('#dv_promotion_part2').hide();
	$('#dv_promotion_part1').show();
	$('.oneShow').show();
	$('.twoShow').hide();
	if($('.oneShow').is(':visible')) {
		$('h4#heading2').css('margin', '18px 0');
	} else {
		$('h4#heading2').css('margin', '0');
	}
});
$('.delete').click(() => {
	$('h4#heading2').css('margin', '10px 0');
	$('#dv_promotion_part2').hide();
	$('#dv_promotion_part1').show();
	$('.oneShow').show();
	$('.twoShow').hide();
	if($('.oneShow').is(':visible')) {
		$('h4#heading2').css('margin', '18px 0');
	} else {
		$('h4#heading2').css('margin', '0');
	}
});
$('.save').click(() => {
	$('h4#heading2').css('margin', '10px 0');
	$('#dv_promotion_part2').hide();
	$('#dv_promotion_part1').show();
	$('.oneShow').hide();
	$('.twoShow').show();
	if($('.oneShow').is(':visible')) {
		$('h4#heading2').css('margin', '18px 0');
	} else {
		$('h4#heading2').css('margin', '0');
	}
});
$('.editing').click(() => {
	$('#dv_promotion_part2').show();
	$('#dv_promotion_part1').hide();
});  
// if($('.oneShow').is(':visible')) {
// 	$('h4#heading2').css('margin', '18px 0');
// } else {
// 	$('h4#heading2').css('margin', '0');
// }
</script>

<style>
.show-element1 {
    display: none;
}
</style>
