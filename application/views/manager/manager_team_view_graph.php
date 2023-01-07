<!-- Bootstrap core CSS -->
<link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
<style>
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
 
	width: 50px;  /*Shumsul*/
	display: block;
	height: 50px;
	background-size: cover;
	text-align: center;
	padding-top: 17px;
	color: #fff;
	margin-top: -5px;
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
	width: 50px;  /*Shumsul*/
	display: block;
	height: 50px;
	background-size: cover;
	text-align: center;
	padding-top: 15px;
	color: #fff;

	padding-left: 2px; /*Shumsul*/
	margin-top: -5px;
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

</style>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/style3.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.min.css">


<div id="popoverlay" class=" popoverlay"></div>
<div class="bg">

  <div class="container">
    <div class="row">
      <div class="col-md-12">
      		<form action="" method="post">
            	<?php echo HLP_get_crsf_field();?>
                <div class="row" style="background: #fff; margin: 10px 0px 10px 0px; opacity:0.8;">
                    <div class="col-md-2">
                        <h2><p style="font-size:24px; margin-left: 8px;margin-top: -3px;">My Team</p></h2>
                    </div>
                    <div class="col-md-2">
                        <select name="ddl_team_data_for" id="ddl_team_data_for" class="" style="width:160px; margin:14px 0px 14px -15px; height:32px !important;">
                            <option value="Base">Base Salary</option>
                            <option value="Target" <?php if($this->input->post("ddl_team_data_for")=="Target"){ echo "selected";} ?>>Target Salary</option>
                            <option value="Total" <?php if($this->input->post("ddl_team_data_for")=="Total"){ echo "selected";} ?>>Total Salary</option>
                        </select>
                        
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="btn_salary" value="salary" class="btn btn-info" style="width:145px; margin:14px 0px 0px 2px; !important;">Salary Growth</button>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" name="btn_market" value="market" class="btn btn-info" style="width:145px; margin:14px 0px 0px 2px; !important;">Market Fitment</button>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" name="btn_peers" value="peers" class="btn btn-info" style="width:145px; margin:14px 0px 0px 2px; !important;">Peer Comparison</button>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" name="btn_team" value="team" class="btn btn-info" style="width:145px; margin:14px 0px 0px 2px; !important;">Team Comparison</button>
                    </div>
                    
                </div>
            </form>
      </div>
      
      <?php foreach($staff_list as $row){?>
          <div class="col-sm-4">
            <div class="column-1">
              <div class="map-1" style="margin-bottom:10px;">
                <div id="dv_graph_<?php echo $row["id"]; ?>" class="chart topchart"></div>
              </div>
            </div>
          </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>> 
<script type="text/javascript">
        
	function setGraphHeaderStyles(wdth = 25)
	{
		//for setting title styles
		var y, labels =  document.querySelectorAll('[text-anchor="start"]');
		for (var i=0;i<labels.length;i++) { 
		   //y = parseInt(labels[i].getAttribute('y'));
		   //labels[i].setAttribute('x', 190);
		   //labels[i].setAttribute('x', wdth+"%");
		   labels[i].setAttribute('font-family', 'Century Gothic Regular');
		   //labels[i].setAttribute('font-weight', 'bold');
		   //labels[i].setAttribute('font-size', 14);
		   //labels[i].setAttribute('text-align', 'center');
		   //labels[i].setAttribute('text-decoration', 'underline');
		   //#74767D
		   //labels[i].setAttribute('font-color', '#74767D');
		}
	}
        
	$(document).ready(function()
	{
		$(".centerTopCir").on("scroll",function(){
		   $(this).css("style","transform: rotate(10deg);") 
		});            
	});
        
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


	function get_manager_team_view_graph_dtls(empid)
	{
		var graph_type = "<?php echo $graph_type;?>";
		var graph_for = $("#ddl_team_data_for").val();
		var aurl = "<?php echo site_url('manager/dashboard/get_manager_team_view_graph_dtls');?>/"+empid+"/"+graph_type+"/"+graph_for;
		$.ajax({url: aurl, success: function(result)
		{
			$("#dv_graph_"+empid).html(result);
			setGraphHeaderStyles();
		}});
	}

	<?php foreach($staff_list as $row){?>
		get_manager_team_view_graph_dtls(<?php echo $row["id"]; ?>);
    <?php } ?>
	
</script> 
