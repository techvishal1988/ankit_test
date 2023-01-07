<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
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
html, body {
    height: 100%;
}
.bodybg {
    background-image: url('<?php echo base_url("assets/images/team.png"); ?>');
    background-size: cover;
    background-repeat: no-repeat;
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
    font-family: 'Roboto';
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
    font-family: 'Roboto';
    font-weight: 500;
    color: #576271;
    font-size: 13px;
}
.leftBottom td {
    font-family: 'Roboto';
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
    font-family: "Roboto";
    color: #000;
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 5px 0;
}
.rightTop .whiteOverlay p {
    font-family: "Roboto";
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
    font-family: "Roboto";
    color: #000;
    font-size: 16px;
    font-weight: 500;
    margin: 0 0 8px 0;
}
.lessWhiter p {
    font-family: "Roboto";
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
    font-family: "Roboto";
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
    font-family: "Roboto";
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    font-weight: 400;
    margin: 0 0 10px 0;
}
.darkOverlay p {
    font-family: "Roboto";
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

.darkOverlay input {
	/*background-color: rgba(255,255,255,0.2);*/
}
</style>

<section class="team bodybg">
    <div class="container">
        <div class="row">
<div class="col-md-1 left-md"></div>
            <div class="col-md-10 right-md">
                <div class="rightTeamArea transparentBlock">
                    <div class="rightBottom whiteBlock"><?php echo $this->session->flashdata('message'); ?>
                    	<form action="" method="post">
                            <h3><span style="font-weight:bold;">Recommend R&R For :</span> <span style="font-weight:bold;font-style:italic; color:#F00;"></span>
                            
                            </h3>
                            <div class="row darkOverlay">
                                <div class="col-md-10">
                                    <p>
                                        <select class="form-control" name="ddl_rnr" id="ddl_rnr" onchange="get_rule_dtls(this.value);" required>
                                            <option value="">Select</option>
                                            <?php foreach($rnr_rules as $row){ ?>
                                                <option value="<?php echo $row["id"];?>"><?php echo $row["rule_name"];?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </p>
                                    <p style="margin-top:20px;">
                                    <input type="email" class="form-control" name="txt_emp_email" id="txt_emp_email" required="required" style="max-width:100% !important;" maxlength="50"/>                                    </p>
                                </div>
                                <div class="col-md-2" id="dv_frm_submit">
                                    <p style="margin-top:30px; margin-left:55px">
                                        <button type="submit" class="btn btn-primary">Go</button>
                                    </p>
                                </div>
                            </div><!--.row-->
                        </form>
                    </div>
                    <div class="rightCenterOne rightTop whiteBlock" style="background-image: url('<?php echo base_url("assets/images/whiteoverlay.png"); ?>');">
                        <div class="row">
                            <div class="col-md-4 pdr0">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Reward Criteria</h3>
                                    <br>
                                    <p><span id="spn_award_criteria"></span></p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                            <div class="col-md-4 pdr0">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Frequency of <br />Award Recommendation</h3>
                                    <br>
                                    <p><span id="spn_award_fr"></span> / Per Month</p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                            <div class="col-md-4">
                                <div class="lessWhiter whiteOverlay">
                                    <h3>Frequency For Employee <br />To Receive This Award</h3>
                                    <br>
                                    <p>Once In <span id="spn_emp_fr"></span> Months</p>
                                </div><!--.lessWhiter-->
                            </div><!--.col-md-6-->
                        </div><!--.row-->
                    </div><!--.rightCenterOne-->                    
                </div><!--.rightTeamArea-->
            </div><!--.col-md-8-->
        </div><!--.row-->
    </div><!--.container-->
</section>

<script>
$(".rightCenterOne").hide();
$("#dv_frm_submit").hide();

function get_rule_dtls(rid)
{
	$(".rightCenterOne").hide();
	$("#dv_frm_submit").hide();	
	$("#spn_award_criteria").html("");
	$("#spn_award_fr").html("");
	$("#spn_emp_fr").html("");
	if(rid=="")
	{
		return false;
	}
	$("#loading").css('display','block');
	
	$.get("<?php echo site_url("dashboard/get_rnr_rule_dtls_to_anyone/"); ?>"+rid,
	function(data)
	{
		if(data)
		{
		   var response = JSON.parse(data);
		   if(response.status)
		   {
			   $("#spn_award_type").show();
			   $("#dv_reward_unit_value").show();
				$("#spn_award_criteria").html(response.rule_dtls.criteria);
				$("#spn_award_fr").html(response.rule_dtls.award_frequency);
				$("#spn_emp_fr").html(response.rule_dtls.emp_frequency_for_award);	
				$(".rightCenterOne").show();
				$("#dv_frm_submit").show();
		   }
		   else
		   {
			    $("#ddl_rnr").val("");
				custom_alert_popup('Invalid rule. Please select a valid rule.');   
		   }
		}	
		$("#loading").css('display','none');	
	});	
}

$(function()
{    
	$( "#txt_emp_email" ).autocomplete({
		minLength: 2,        
		search: function(event, ui) {$('#loading').show();},
   		response: function(event, ui) {$('#loading').hide();},
		source: '<?php echo site_url("dashboard/get_users_for_rnr"); ?>',
		select: function(event, ui) {}
	});
});

</script>