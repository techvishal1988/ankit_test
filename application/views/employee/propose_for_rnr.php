<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
::-webkit-scrollbar
{
  width: 12px;  /* for vertical scrollbars */
  height: 12px; /* for horizontal scrollbars */
}
::-webkit-scrollbar-track
{
  background: rgba(0, 0, 0, 0.1);
}
::-webkit-scrollbar-thumb
{
    background: rgba(0, 0, 0, 0.3);
    border-radius: 8px;
}

.bodybg {
    /*background-image: url('<?php //echo $this->session->userdata('company_bg_img_url_ses') ?>');*/
    background-size: cover;
    
}
.page-inner {
	background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
	background-size: cover;
}
.team {
    padding: 50px 0;
}
.whiteBlock {
    background-color: #f9f9f9;
    /*box-shadow: 0 0 4px 1px #aaa;*/
}
.leftTop {
    padding: 20px;
    box-shadow: -5px -1px 6px 3px rgba(0,0,0,0.1);
}
.leftTop p {
    font-weight: 400;
    color: #576271;
    font-size: 18px;
    margin: 0;
}
.leftTop p .badge {
    margin: -3px 0 0 25px;
    font-size: 11px;
    background-color: #003277;
}
.closeClick {
    cursor: pointer;
}
.leftBottom {
    overflow-y: auto;
    padding: 22px 10px 22px 12px;
    max-height: 643px;
}
.leftBottom th {
    font-weight: 500;
    color: #576271;
    font-size: 13px;
}
.leftBottom td {
    font-weight: 400;
    color: #576271;
    font-size: 12px;
    padding: 8px 0 !important;
    border-color: #eee !important;
}
.leftBottom .table>thead>tr>th {
    border-bottom: 1px solid #ddd;
    padding: 0 0 2px 0 !important;
}
.leftBottom th i {
    color: #003277;
    font-size: 12px;
    /* padding-left: 3px; */
}
.leftBottom th:first-child {
    position: relative;
}
.leftBottom th:first-child:after {
    content: " ";
    display: inline-block;
    height: 1px;
    background-color: #003277;
    width: 20px;
    position: absolute;
    left: 0;
    bottom: 0;
}
.rightTop {
    padding: 30px 28px;
	/*margin-top: 15px;*/
}
.rightTop .whiteOverlay {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.08), 0 10px 20px rgba(0,0,0,0.15);
    /* box-shadow: 0 3px 22px 0 rgba(0,0,0,0.7); */
    padding: 28px 20px;
    /*background-image: url('<?php //echo base_url("assets/images/whiteoverlay.png"); ?>');*/
    background-size: cover;
}
.rightTop .whiteOverlay h2 {
    color: #000;
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 5px 0;
}
.rightTop .whiteOverlay p {
    color: #000;
    font-size: 20px;
    font-weight: 500;
    margin: 0;
}
.lessWhiter {
    background-color: #f9f9f9;
    box-shadow: 0 0 4px 1px #aaa;
    text-align: center;
    padding: 15px 0;
    /*background-image: url('<?php //echo base_url("assets/images/greyoverlay.png"); ?>');*/
    background-size: cover;
}
.rightCenterOne, .rightCenterTwo {
   /* margin-top: 15px;*/ 
}
.pdr0 {
    padding-right: 0;
}
.lessWhiter h3 {
    color: #000;
    font-size: 16px;
    font-weight: 500;
    margin: 0 0 8px 0;
}
.lessWhiter p {
    color: rgba(0,0,0,0.7);
    font-size: 14px;
    font-weight: 400;
    margin: 0 0 0 0;
}
.lessWhiter p span {
    font-weight: 700;
}
.rightBottom {
    padding: 30px 28px;
    /*margin-top: 15px;*/
	margin-bottom: 15px;
}
.rightBottom h3 {
    color: #000;
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 30px 0;
}
.darkOverlay {
    background-color: #333;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15), 0 10px 14px rgba(0,0,0,0.30);
    /* box-shadow: 0 3px 22px 0 rgba(0,0,0,0.7); */
    padding: 28px 18px;
    background-image: url('<?php echo base_url("assets/images/darkoverlay.png"); ?>');
    background-size: cover;
}
.darkOverlay h2 {
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    font-weight: 400;
    margin: 0 0 10px 0;
}
.darkOverlay p {
    color: rgba(255,255,255,0.7);
    font-size: 24px;
    font-weight: 700;
    margin: 0;
}
.show-element1, .show-element2 {
    display: none;
}
.darkOverlay .lessFont {
    font-size: 18px;
    position: absolute;
    right: 35px;
}
.darkOverlay input, .darkOverlay button {
    display: inline-block;
    max-width: 135px !important;
}
.darkOverlay .lessFont img {
    max-width: 12px;
}
.team .container {
    width: 80% !important;
}

.pad_l_15{padding-left: 15px !important;}

@media screen and (max-width: 767px) {
    .table-responsive {
        border: 0;
}
}

.darkOverlay input {
	/*background-color: rgba(255,255,255,0.2);*/
}
</style>

<section class="team bodybg">
    <div class="container">
        <div class="row">
        	<?php echo $msg; echo $this->session->flashdata('message'); ?>
            <div class="col-md-12 right-md">
                <div class="rightTeamArea transparentBlock">
                  
                        <div class="rightTop whiteBlock">
                        	<?php if(($rnr_rules) or $emp_details["points"] >= 100){ ?>
                                <div class="row">
                                    <div class="col-md-12 mob_left text-right" style="margin-right:5px;">
                                    	<?php if($emp_details["points"] >= 100){ ?>
                                        	<a class="btn btn-success btn_p"  href="<?php echo site_url("xoxoday"); ?>">Redeem</a>
                                        <?php }if($rnr_rules){ ?>                                    	
                                    		<a class="btn btn-success btn_p"  href="<?php echo site_url("propose-for-recognized-rnr"); ?>">Recognize Your Peer</a>
                                        <?php } ?>
                                    </div>
                                 </div>
                            
							<?php } if($emp_rnr_history){ ?>
                            	<div class="row">
                                <div class="col-md-12">
                                    <div class="whiteOverlay">
                                        <h2>Reward Received by : <?php echo $emp_details["name"];?> so far</h2>
                                        <table id="example" class="table border  ">
                                            <thead>
                                                <tr>
                                                    <th>Reward Type</th>
                                                    <th>Date Of Reward</th>
                                                    <th>Recommended By</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php foreach($emp_rnr_history as $row){ ?>
                                                    <tr>
                                                        <td><?php echo $row["rule_name"]; ?></td>
                                                        <td><?php if($row["reward_date"] != "0000-00-00 00:00:00"){ echo date("d/m/Y", strtotime($row["reward_date"]));} ?></td>
                                                        <td><?php echo $row["recommended_by"]; ?></td>
                                                        <td><?php echo $row["award_value"]; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div><!--.whiteOverlay-->
                                </div>
                            </div><!--.row-->
							<?php } ?>
                        </div>
                </div><!--.rightTeamArea-->
            </div><!--.col-md-8-->
        </div><!--.row-->
    </div><!--.container-->
</section>

<script>
$(".rightCenterOne").hide();
$(".rightCenterTwo").hide();
$("#dv_frm_submit").hide();
$("#dv_available_budget").hide();
$("#spn_exceed_budget").hide();

function get_rule_dtls(rid)
{
	$(".rightCenterOne").hide();
	$(".rightCenterTwo").hide();
	$("#dv_frm_submit").hide();
	$("#dv_available_budget").hide();
	$("#spn_exceed_budget").hide();
	
	$(".spn_award_amt").html("");
	$("#spn_award_criteria").html("");
	$("#spn_award_fr").html("");
	$("#spn_emp_fr").html("");
	$("#spn_managers_available_budget").html("");
	if(rid=="")
	{
		return false;
	}
	$("#loading").css('display','block');
	
	$.post("<?php echo site_url("manager/dashboard/get_rnr_rule_dtls"); ?>",{"rid":rid},
	function(data)
	{
		if(data)
		{
		   var response = JSON.parse(data);
		   if(response.status)
		   {
				$(".spn_award_amt").html(response.rule_dtls.award_value);
				$("#spn_award_criteria").html(response.rule_dtls.criteria);
				$("#spn_award_fr").html(response.rule_dtls.award_frequency);
				$("#spn_emp_fr").html(response.rule_dtls.emp_frequency_for_award);
				$("#spn_managers_available_budget").html(response.rule_dtls.manager_available_budget);
				
				if(response.rule_dtls.manager_available_budget*1 >= response.rule_dtls.award_value*1)
				{
					$(".rightCenterOne").show();
					$(".rightCenterTwo").show();
					$("#dv_frm_submit").show();
				}
				else
				{
					$("#spn_exceed_budget").show();
				}
				$("#dv_available_budget").show();
				
		   }
		}	
		$("#loading").css('display','none');	
	});	
}

$('.closeClick').click(function() {
	if ($('.left-md').hasClass('col-md-4')) {
		$('.left-md').hide();
		$('.left-md').removeClass('col-md-4');
		$('.right-md').removeClass('col-md-8').addClass('col-md-12');
	} else {
		$('.left-md').show();
		$('.left-md').addClass('col-md-4');
		$('.right-md').removeClass('col-md-12').addClass('col-md-8');
	}
});
</script>