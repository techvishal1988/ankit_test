<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
::-webkit-scrollbar
/*{
  width: 12px;  
  height: 12px; 
::-webkit-scrollbar-track
{
  background: rgba(0, 0, 0, 0.1);
}
::-webkit-scrollbar-thumb
{
    background: rgba(0, 0, 0, 0.3);
    border-radius: 8px;
}*/
html, body {
    height: 100%;
}
.bodybg {
    background-image: url('<?php echo $this->session->userdata('company_bg_img_url_ses') ?>');
    background-size: cover;
    background-repeat: no-repeat;
    min-height:640px;
        margin-bottom: -15px;
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
    padding: 28px 10px;
    /*background-image: url('<?php //echo base_url("assets/images/whiteoverlay.png"); ?>');*/
    background-size: cover;
    margin-bottom: 15px;
    min-height: 138px;
}
@media (min-width: 992px) and (max-width: 1100px) {
    .rightTop .whiteOverlay {
        min-height: 194px;
    }
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
	margin-bottom: 0;
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
    width: 100% !important;
}
@media screen and (max-width: 767px) {
    .table-responsive {
        border: 0;
}
}

#emplist.table tr th{text-align: left !important; vertical-align: inherit;}

.darkOverlay input {
	/*background-color: rgba(255,255,255,0.2);*/
}
.rightTeamArea {
    background-size: cover;
}
</style>

<section class="team bodybg">
    <div class="container">
        <div class="row">
        	<?php if(count($staff_list)>0){?>
            <div class="col-md-4 left-md">
                <div class="leftTeamArea whiteBlock">
                    <div class="leftTop">
                        <p>My Team <!--<span class="badge"><?php echo count($staff_list); ?></span>--><span class="pull-right closeClick"><i class="fa fa-times"></i></span></p>
                    </div><!--.leftTop-->
                    <div class="leftBottom">
                        <div class="table-responsive">          
                            <table class="table" id="emplist">
                                <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Designation</th>
                                </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($staff_list as $row){?>
                                    <tr>
                                        <td><a href="<?php echo site_url("manager/propose-for-rnr/".$row["id"]); ?>"><?php echo $row["name"]; ?></a></td>
                                        <td><?php echo $row["desig"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div><!--.leftBottom-->
                </div>
            </div><!--.col-md-4-->
            <?php } ?>
            <div class="col-md-8 right-md">
                <div class="rightTeamArea transparentBlock">
                    <div class="rightBottom whiteBlock"><?php echo $this->session->flashdata('message'); ?>
                        <button class="btn btn-primary btn-xs" type="button" id="showteam" onclick="showteam()">Show Team</button>
                    	<form action="" method="post" class="frm_cstm_popup_cls_default">
                        	<?php echo HLP_get_crsf_field();?>
                            <h3><!--<span style="font-weight:bold;">Recommend R&R For :</span>--> <span style="font-weight:bold; color:#F00;"><?php echo $emp_details["name"];?>, <?php echo $emp_details["designation"];?></span>
                            <input type="hidden" name="hf_uid" value="<?php echo $emp_details["id"];?>" />
                            </h3>
                             <span class="reward_rnr_bug" style="margin-bottom: 0px;" id="dv_available_budget"><b>Total team budget available : <?php if($emp_details["currency_type"]){echo $emp_details["currency_type"];}else{echo "$";} ?> <span id="spn_managers_available_budget"></span></b></span>
                                    <span id="spn_exceed_budget">Insufficient amount<br />Selected award amount is <span class="spn_award_amt"></span></span>
                            <div class="row darkOverlay">
                                <div class="col-md-10" style="padding-left: 4px;">
                                    <p>
                                        <select class="form-control" name="ddl_rnr" id="ddl_rnr" onchange="get_rule_dtls(this.value);" required>
                                            <option value="">Select</option>
                                            <?php foreach($rnr_rules as $row){ ?>
                                                <option value="<?php echo $row["id"];?>"><?php echo $row["rule_name"];?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </p>
                                 <!--    <h2>&nbsp;</h2> -->
                                   
                                </div>
                                
                                <div class="col-md-2" style="padding-left: 5px;" id="dv_frm_submit">
                                    <p>
                                        <button style="font-size: 16px; height: 34px;" onclick="return request_custom_confirm('frm_cstm_popup_cls_default');" type="submit" class="btn btn-primary">Recommend</button>
                                    </p>
                                </div>
                            </div><!--.row-->
                        </form>
                    </div>
                    <div class="rightCenterOne rightTop whiteBlock" style="background-size:cover;background-image: url('<?php echo base_url("assets/images/whiteoverlay.png"); ?>');">
                        <div class="row">
                            <div class="col-md-12 pdr0">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Reward Criteria</h3>
                                    <br>
                                    <p><span id="spn_award_criteria"></span></p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><!--.rightCenterOne-->
                    <div class="rightCenterTwo rightTop whiteBlock" style="background-size:cover;background-image: url('<?php echo base_url("assets/images/whiteoverlay.png"); ?>');">
                        <div class="row">
                            <div class="col-md-4" id="dv_reward_unit_value">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Reward Unit <br>Value</h3>
                                    <br>
                                    <p><span id="spn_award_type"><?php if($emp_details["currency_type"]){echo $emp_details["currency_type"];}else{echo "$";} ?> </span><span class="spn_award_amt"></span></p>
                                </div><!--.lessWhiter-->     
                            </div><!--.col-md-4-->
                            <div class="col-md-4 pdr0">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Frequency of <br />Award Recommendation</h3>
                                    <br>
                                    <p> Once In <span id="spn_award_fr"></span> Month</p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                            <div class="col-md-4">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Frequency For Employee <br />To Receive This Award</h3>
                                    <br>
                                    <p>Once In <span id="spn_emp_fr"></span> Month</p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><!--.rightCenterTwo-->
                    
                    <?php if($emp_rnr_history){ ?>
                        <div class="rightTop whiteBlock">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="whiteOverlay">
                                        <h2>Reward Received by : <?php echo $emp_details["name"];?> so far</h2>
                                        <table id="example" class="table border  ">
                                            <thead>
                                                <tr>
                                                    <th>Reward Name</th>
                                                    <th>Date Of Reward</th>
                                                    <th>Recommended By</th>
                                                    <th>Reward Type</th>
                                                    <th>Reward Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php foreach($emp_rnr_history as $row){ ?>
                                                    <tr>
                                                        <td><?php echo $row["rule_name"]; ?></td>
                                                        <td><?php if($row["reward_date"] != "0000-00-00 00:00:00"){ echo date("d/m/Y", strtotime($row["reward_date"]));} ?></td>
                                                        <td><?php echo $row["recommended_by"]; ?></td>
                                                        <td><?php 
															 if($row["award_type"] == "1"){ echo "Cash"; }
															 elseif($row["award_type"] == "2"){ echo "Points";}
															 elseif($row["award_type"] == "3"){ echo "Just Recognisation"; } ?></td>
                                                        <td><?php if($row["award_type"] != "3"){echo HLP_get_formated_amount_common($row["award_value"]);} ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div><!--.whiteOverlay-->
                                </div>
                            </div><!--.row-->
                        </div>
                    <?php } ?>
                </div><!--.rightTeamArea-->
            </div><!--.col-md-8-->
        </div><!--.row-->
    </div><!--.container-->
</section>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" ></script>
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
	var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
	
	$.post("<?php echo site_url("manager/dashboard/get_rnr_rule_dtls"); ?>",{"rid":rid, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},
	function(data)
	{
		if(data)
		{
		   var response = JSON.parse(data);
		   if(response.status)
		   {
			   $("#spn_award_type").show();
			   $("#dv_reward_unit_value").show();
			    if(response.rule_dtls.award_type == 1)
				{
					$(".spn_award_amt").html(response.rule_dtls.award_value);
				}
				else if(response.rule_dtls.award_type == 2)
				{
					$(".spn_award_amt").html(response.rule_dtls.award_value + " Points");
					$("#spn_award_type").hide();
				}
				else if(response.rule_dtls.award_type == 3)
				{
					$("#dv_reward_unit_value").hide();
				}
				
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
				if(response.rule_dtls.award_type == 1)
				{
					$("#dv_available_budget").show();
				}
				
		   }
		}	
		set_csrf_field();
		$("#loading").css('display','none');	
	});	
}
$('#showteam').hide();
$('.closeClick').click(function() {
	if ($('.left-md').hasClass('col-md-4')) {
		$('.left-md').hide();
                $('#showteam').show();
		$('.left-md').removeClass('col-md-4');
		$('.right-md').removeClass('col-md-8').addClass('col-md-12');
        $(".right-md").css("padding-left","15px");
	} else {
		$('.left-md').show();
		$('.left-md').addClass('col-md-4');
		$('.right-md').removeClass('col-md-12').addClass('col-md-8');
	}
});
function showteam()
{
     $('#showteam').hide();
     $('.left-md').addClass('col-md-4');
     if ($('.right-md').hasClass('col-md-12')) {
		
        $('.right-md').removeClass('col-md-12');
        $('.right-md').removeClass('col-md-12').addClass('col-md-8');
        $(".right-md").css("padding-left","0px");
	}
     $('.left-md').show();
}
$(document).ready(function() {
    $('#emplist').DataTable({
        "paging":   false,
         "info":     false,
         "searching": false
    });
} );
</script>