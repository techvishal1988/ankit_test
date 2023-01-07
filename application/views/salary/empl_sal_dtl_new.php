<link href='https://fonts.googleapis.com/css?family=Gothic+A1:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
<!-- Bootstrap core CSS -->
<link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
<style>
 .card-1 {
   background-size: cover;
   padding: 10px 10px 5px 10px !important;
   box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
 }
 .card-1-c {
   background: url(<?php echo base_url() ?>assets/salary/img/c1-cricle.png);
   //width: 65%; /*Shumsul*/
   width: 80px;
   display: block;
   height: 80px;
   background-size: cover;
   text-align: center;
   padding-top: 34px;
   color: #fff;
   margin-top: -20px;
   font-weight: bold;
   font-size: 14px;

 }

 .black-card-1 img{width:22px; margin-top:5px; margin-right:5px;}

 .black-card-1 img.editicon{margin-top: 1px; margin-right:7px;}

 .black-card-1 {
   /*border-bottom-left-radius: 10px;
   border-bottom-right-radius: 10px;*/
   background:#2f2f2f;
   background-size: cover;
   color: #fff;
   padding: 5px 30px;
   background-repeat: no-repeat;
   padding-bottom: 23px;
   /*margin-bottom: 10px;*/
   /*Shumsul*/
   /*border-radius: 17px;*/
   background-attachment: scroll;
   position: relative;
 }

.black-card-1 .flot_icon{ position: absolute;   bottom: 10px; right: 6px; cursor: pointer; }
.black-card-1 .flot_icon ul{padding-left: 0px; margin-top: -5px; margin-right: 5px; position: relative; z-index: 2;}
.black-card-1 .flot_icon ul li{ display: block;}
.black-card-1 .flot_icon ul li.mr28{margin-top: 28px;}
.black-card-1 .flot_icon ul li.mr28.mr0{margin-top: 0px;}
.black-card-1 .flot_icon ul li i{font-size: 15px;}
.black-card-1 .flot_icon.promo{top: 5px; right: 3px; height: 1px;}
.flot_icon.promo.prop{top:6; right: 3px; height: 80px;}

 .black-card-1 p.rang{ margin-left:-10px; text-align: center; font-style: italic; margin-bottom: 2px; font-size: 12px; color: #d2d2d2 !important}

 .card-1-c2 {
   background: url(<?php echo base_url() ?>assets/salary/img/c2-cricle.png);
   //width: 65%; /*Shumsul*/
   width: 80px;
   display: block;
   height: 80px;
   background-size: cover;
   text-align: center;
   padding-top: 30px;
   color: #fff;
   padding-left: 2px;
   margin-top: -15px;
   font-size: 14px;
   font-weight: bold;
 }
 #salary_movement_chart, #comparison_with_peers, #current_market_positioning, #comparison_with_team {
   margin-bottom: 20px;
   margin-top: 20px;
   
 }
 .pcc, .pc {
   padding-left: 0px;
   width: 100px;
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
   margin-left: 0px;
 }
 .pc:focus, .pcc:focus {
   outline: none;
 }

 #txt_citation, .customcls, #txt_bonus_recommendation{
   background: transparent;
   width: 100%;
   border: none;
   border-bottom: solid #000 1px;
   /*display: none;*/
   /*color: white;*/
 }

select.customcls option{color: #000;}

 .promoprice, .promoper {
   padding-left: 0px;
   width: 100px;
   position: absolute;
   background: transparent;
   border: none;
   border-bottom: solid gray 1px;
   margin-left: -2px;
   text-align: right;
 }
 #prompers {
   /* float: right; */
 }
 .promoper {
   width: 64px;
   text-align: right;
   font-size: 20px;
   font-size: 19px;
 }
 #promper {
   float: left;
   margin-left: 3px !important;
 }
 .promoper:focus, .promoprice:focus, .customcls:focus, #txt_citation:focus, #txt_bonus_recommendation:focus{
   outline: none;
 }
 .mycls {
   display: none;
 }
 .customcls {
   width: 69%;
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
 .black-card-1 h3 {
   margin-top:12px !important;
   font-size: 18px;
 }

 .card-2 {
   padding: 10px 10px 10px 10px !important;
   background-color: rgb(255, 255, 255, .8) !important;
   min-height:375px;
  display: -webkit-box;
display: -moz-box;
display: -ms-box;
display: -webkit-flex;
display: box;
display: flex !important;
-webkit-box-pack: justify;
-moz-box-pack: justify;
-o-box-pack: justify;
-ms-box-pack: justify;
-webkit-justify-content: space-evenly;
justify-content: space-evenly;
-webkit-box-orient: vertical;
-moz-box-orient: vertical;
-o-box-orient: vertical;
-ms-box-orient: vertical;
-webkit-box-lines: single;
-moz-box-lines: single;
-o-box-lines: single;
-ms-box-lines: single;
-webkit-flex-flow: column nowrap;
flex-flow: column nowrap;
 }

.card-2p{min-height: 375px; vertical-align: middle ;  width: 100%;}

.card-2p{ vertical-align: middle ;  width: 100%; }

.card_fix_ver_cen{display: table-cell;
height: 93px;
width: 100% !important;
display: -webkit-box;
display: -moz-box;
display: -ms-box;
display: -webkit-flex;
display: box;
display: flex !important;
-webkit-box-pack: justify;
-moz-box-pack: justify;
-o-box-pack: justify;
-ms-box-pack: justify;
-webkit-justify-content: space-evenly;
justify-content: space-evenly;
-webkit-box-orient: vertical;
-moz-box-orient: vertical;
-o-box-orient: vertical;
-ms-box-orient: vertical;
-webkit-box-lines: single;
-moz-box-lines: single;
-o-box-lines: single;
-ms-box-lines: single;
-webkit-flex-flow: column nowrap;
flex-flow: column nowrap;}


.b-cardp.padmin{padding: 9px 17px;}
.b-cardp{display: inline-block; width: 100%; padding: 10px 30px;}
.b-cardp input.ex_box{background:transparent; border:none; border-bottom:solid gray 1px; width:100%;
                      margin-bottom: 10px; margin-top:7px;
                     }
.b-cardp span.din_txt{font-size: 13px; vertical-align: top;}




 /*Start shumsul*/
 .page-inner {
  /* padding:0 0 40px;*/
   background: url(<?php echo $this->session->userdata('company_bg_img_url_ses');
    ?>) 0 0 no-repeat !important;
  background-size: cover !important;
  background-position: bottom -110px right 0px !important; background-attachment: fixed !important;
 }
 /*End shumsul*/
 .map-2, .map-1 {
   text-align:center;
 }
 .bg {
  margin: 15px 0 45px 0;
}
.box-cls{
  padding: 5px 15px !important;
}

.card_cust p{margin-bottom: 0px;}
.card_cust p.head{ font-size: 14px;
  height: 20px !important;
  letter-spacing: .5px; }
  .card_cust p.bodytxt{font-size: 20px;
    line-height: 36px;
    color: #4E5E6A;}    

.emp_info{display: block; width: 100%; padding: 10px 6px 4px 6px; background-color: rgba(255, 255, 255, .8);}
.emp_info .left_info{display: block; width: 100%;}
.emp_info .right_info{display: block; width: 100%;}
.emp_info .left_info table tr td{padding-right:20px; font-size:14px; padding-bottom: 5px; background-color: transparent !important;}
.emp_info .right_info table{float: right;}
.emp_info .right_info table tr td{padding-right:20px; font-size:14px; padding-bottom: 5px; background-color: transparent !important;}
.center-box-new{display: block; width:100%; position: relative; background-color: rgba(255, 255, 255, .8);}
.center-box-new .new-cd{width: 100%;text-align: center; display: inline-block;}
.center-box-new .new-cd table tr td{ background-color: transparent !important; border:none; font-size: 15px; padding: 0px 0px 3px 0px !important;}
.center-box-new .new-cd table tr td span{margin-left: 8px; color: unset;}
/* .center-box-new i{position: absolute; color: red; top: 3px; right: 6px; font-size: 16px;} */
.center-box-new .new-cd p.info{font-size: 14px; font-weight: normal;}
.center-box-new .new-cd p.data{font-size: 22px;}
.center-box-new .new-cd table tr td.current_box_lft{width:60%; text-align:right;  font-size:14px;}
.center-box-new .new-cd table tr td.current_box_rft{text-align: left;}


select.grap_sted{height:30px; padding:0px 10px !important; width:200px; /* border-radius:12px; */ /* background-color: transparent; */}
select.grap_sted option{color:#000;} 
.emp_name_tittle{display: block; width: 100%; position: relative; background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.emp_name_tittle h3{ margin: 0px;
    padding: 9px 10px;
    font-size: 13px;
    font-weight: 300;
    text-transform: capitalize; color: #fff;}   
.proxyBtn.pbtn{margin-top: 20px;}
.proxyBtn .btn{margin-right: 10px;}

a.backbtn{/* position:absolute; */ margin:8px 8px 0px 0px;  transition: 1s; font-weight: bold; right:14px; font-size: 15px; text-decoration: none; color:#fff;  }

a.backbtn:hover{opacity: 1;} 
.modal-body .bodyp{ margin-top: 20px; padding:10px;background-color: #f5f5f7 !important;} 

 .left_info .per_rating{} 
 .left_info .per_rating .per_rating{}
 .left_info .per_rating .per_rating span.editbtn{}
 .left_info .per_rating .per_rat_dropdown{}
 .form-inlinep.form-group{ display: inline-block; margin-bottom:3px;}
 .btn.btnp{ margin-top:1px; padding: 4px 12px !important; border-radius: 4px;}
#sidebar{width: 200px !important;}
.dataTable.table>thead>tr>th{text-align: left !important;}
.container-fluid{padding: 0px 30px;}
.mailbox-content table tbody tr td{color: #000 !important;}
.table tbody tr td, .table thead tr th{font-size: 16px !important;}

.black-box-new .tittle-info-links{display: inline; }
.black-box-new .tittle-info-links img{width: 22px;
    margin-bottom: 1px;
    cursor: pointer;}
table.dataTable thead th, table.dataTable.no-footer{border-bottom: 0px !important;}  
</style>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/style3.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.min.css">
<?php
$emp_revised_final_roundup_sal = HLP_get_round_off_val($salary_dtls["final_salary"], $rule_dtls["rounding_final_salary"]);

$merit_increase_amount = ($salary_dtls["increment_applied_on_salary"]*$salary_dtls["final_merit_hike"])/100;
$market_correction_amount = ($salary_dtls["increment_applied_on_salary"]*$salary_dtls["final_market_hike"])/100;
$total_salary_increment_amount = ($salary_dtls["increment_applied_on_salary"]*$salary_dtls["manager_discretions"])/100;
?>

<input type="hidden" id="hf_emp_sal_id" value="<?php echo $salary_dtls["id"]; ?>" />
<input type="hidden" id="hf_emp_hike_merit" value="<?php echo $salary_dtls["final_merit_hike"]; ?>" />
<input type="hidden" id="hf_emp_hike_market" value="<?php echo $salary_dtls["final_market_hike"]; ?>" />
<input type="hidden" id="hf_emp_hike_total" value="<?php echo $salary_dtls["manager_discretions"]; ?>" />
<input  type="hidden" id="hf_increment_applied_on_sal" value="<?php echo $salary_dtls["increment_applied_on_salary"]; ?>" />

<input type="hidden" id="hf_merit_hike_amt" value="<?php echo $merit_increase_amount; ?>">
<input type="hidden" id="hf_market_hike_amt" value="<?php echo $market_correction_amount; ?>">
<input type="hidden" id="hf_total_hike_amt" value="<?php echo $salary_increment_amount; ?>">

<?php 
if(!isset($is_open_frm_manager_side))
{
	$is_open_frm_manager_side = 0;
}
if(!isset($is_open_frm_hr_side))
{
	$is_open_frm_hr_side = 0;
}
$emp_currency_name = "$";
if($salary_dtls["currency_type"])
{
	$emp_currency_name = $salary_dtls["currency_type"];
}

$rule_id = $rule_dtls["id"];
$type_of_hike_can_edit_arr = explode(",", $rule_dtls["type_of_hike_can_edit"]);

$checkApproverEsopRights = $checkApproverPayPerRights = $checkApproverBonusRecommandetionRights = "";
if($is_open_frm_hr_side == 1)
{
	if($is_hr_can_edit_hikes == 1)
	{
		$checkApproverEsopRights = 1;
		$checkApproverPayPerRights = 1;      
		$checkApproverBonusRecommandetionRights = 1;
	}
}
else
{
	$manager_emailid = strtolower($this->session->userdata('email_ses'));
	if($rule_dtls['esop_right']==1)
	{
		$colName="approver_1,approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['esop_right']==2)
	{
		$colName="approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['esop_right']==3)
	{
		$colName="approver_3,approver_4";
	}
	else if($rule_dtls['esop_right']==3)
	{
		$colName="approver_4";
	}
	
	if($rule_dtls['pay_per_right']==1)
	{
		$colName2="approver_1,approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['pay_per_right']==2)
	{
		$colName2="approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['pay_per_right']==3)
	{
		$colName2="approver_3,approver_4";
	}
	else if($rule_dtls['pay_per_right']==3)
	{
		$colName2="approver_4";
	}
	
	if($rule_dtls['retention_bonus_right']==1)
	{
		$colName3="approver_1,approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['retention_bonus_right']==2)
	{
		$colName3="approver_2,approver_3,approver_4";
	}
	else if($rule_dtls['retention_bonus_right']==3)
	{
		$colName3="approver_3,approver_4";
	}
	else if($rule_dtls['retention_bonus_right']==4)
	{
		$colName3="approver_4";
	}				
	$checkApproverEsopRights = HLP_find_approver($rule_id, $manager_emailid, $colName);
	$checkApproverPayPerRights = HLP_find_approver($rule_id, $manager_emailid, $colName2);      
	$checkApproverBonusRecommandetionRights = HLP_find_approver($rule_id, $manager_emailid, $colName3);
}


$is_user_can_edit_salary_hikes = 0;//1=Yes(Can Modiffy the Hikes), 0=No(Can Not Modiffy the Hikes)
if($is_open_frm_hr_side == 1 and $is_hr_can_edit_hikes == 1)
{
	$is_user_can_edit_salary_hikes = 1;
}
else
{
	if($this->session->userdata('is_manager_ses') == 1 and $is_open_frm_manager_side == 1)
	{
		$salary_n_rule_dtls = array(
									"rule_status"=>$rule_dtls["status"],
									"budget_accumulation"=>$rule_dtls["budget_accumulation"],
									"salary_hike_approval_status"=>$salary_dtls["salary_hike_approval_status"],
									"manager_emailid"=>$salary_dtls["manager_emailid"],
									"approver_1"=>$salary_dtls["approver_1"],
									"approver_2"=>$salary_dtls["approver_2"],
									"approver_3"=>$salary_dtls["approver_3"],
									"approver_4"=>$salary_dtls["approver_4"]
									);
		$is_manager_can_edit_dtls = HLP_is_manager_can_edit_salary_hikes($salary_n_rule_dtls, $this->session->userdata('email_ses'));
		if($is_manager_can_edit_dtls["is_access_to_edit"])
		{
			$is_user_can_edit_salary_hikes = 1;
		}
	}
}

$promotion_col_name = CV_BA_NAME_GRADE;
$other_then_promotion_col_arr = array("designation", "level");
$level_name = "Grade";				
if($rule_dtls['promotion_basis_on']==1)
{
	$promotion_col_name = CV_BA_NAME_DESIGNATION;
	$other_then_promotion_col_arr = array("grade", "level");
	$level_name = "Designation";
}
elseif($rule_dtls['promotion_basis_on']==3)
{
	$promotion_col_name = CV_BA_NAME_LEVEL;
	$other_then_promotion_col_arr = array("designation", "grade");
	$level_name = "Level";
}

if($is_open_frm_hr_side != 1)
{
	$other_then_promotion_col_arr = array();
}
$is_promotion_editable_by_current_usr = 0;
//if(((isset($is_hr_can_edit_hikes) and $is_hr_can_edit_hikes == 1)) or (in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr)==true and $is_user_can_edit_salary_hikes == 1))
if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr)==true and $is_user_can_edit_salary_hikes == 1)
{
	$is_promotion_editable_by_current_usr = 1;
}

$is_already_promoted = 0;
if($salary_dtls['emp_new_'.$promotion_col_name] > 0)
{
	$is_already_promoted = 1;
}
?>

<div id="popoverlay" class="popoverlay"></div>
<div class="bg">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="emp_name_tittle clearfix">
          <div class="col-sm-9">
            <h3>
				<strong style="text-transform: uppercase; font-size:16px;">
					<?php echo $salary_dtls["name"]; ?>
				</strong>, 
				<?php echo $salary_dtls["current_designation"]; ?></h3>
          </div>
          <div class="col-sm-3"> 

           
         <div class="custom_icon_popup">
            <div class="pull-right">
                <ul class="nav pull-right">
                    <li class="dropdown">
                      <?php if(@$emp!='employee') { ?>
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-align-left"></i></a><?php } ?>
                        <ul class="dropdown-menu">
                            <div class="employee-list-manager">
                              <!-- <h3 style="margin-left: 5px;">Employee list</h3> -->
                                  <?php   
                                  if($staff_list)
                                  { ?>
                                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                                      <thead>
                                        <tr>
                                          <th><!-- <?php //echo $business_attributes[0]["display_name"]; ?> -->Employee list</th>
                                        </tr>
                                      </thead>
                                      <tbody class="lmd_height">
                                        <?php 
                                        foreach($staff_list as $row)
                                        {
                                          echo "<tr><td><a href='".site_url($urls_arr["emp_increment_dtls_pg_url"]."/".$rule_id."/".$row["id"])."'>".$row["name"]." </a></td></tr>";
                                        }
                                        ?>
                                      </tbody>
                                    </table>
                                  <?php
                                  } ?>
                            </div>
                        </ul>
                    </li>
                </ul>
              </div>
            </div> 
        

            <a  class="backbtn pull-right" title="back" href="<?php echo site_url($urls_arr["main_increments_list_url"]."/".$rule_id); ?>">Team Table View</a>
            <?php /* 
            <?php if(@$emp!='employee') { ?>
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn pull-right" style="margin:5px 0px 0px 35px;"> <i class="glyphicon glyphicon-align-left"></i> </button>
            <?php } ?>
             */ ?>

        </div>
       </div> 
      </div>
      <div class="col-sm-12">
        <div class="emp_info clearfix">
          <div class="col-sm-4">
            <div class="left_info">
              <table>
                <tr>
                  	<td>
						<div class="per_rating" id="dv_performance_rating">
							<?php if($is_user_can_edit_salary_hikes ==  1)
								  {
									   if(($is_open_frm_manager_side == 1 and $rule_dtls['manager_can_change_rating'] == 1) or ($is_open_frm_hr_side == 1)){ ?>
										<span style="margin-right:3px;" id="btn_edit_rating">
										<i class="fa fa-pencil-square-o themeclr"></i>
										</span>
								 <?php }
								  }
								  echo $salary_dtls["performance_rating"]; ?>
							<?php if($rule_dtls['display_performance_achievement'] == "1"){ ?>
								(<strong><?php echo $salary_dtls["performance_achievement"]; ?>%</strong>)
							<?php } ?>
						</div>
						<div class="per_rat_dropdown" id="dv_performance_rating_dropdown" style="display:none;">
						  <div class="form-inlinep form-group">
							<select class="grap_sted form-control" name="ddl_performance_rating" id="ddl_performance_rating">
							  <option value="0">Select Performance Rating</option>
							  <?php
							  if($performance_rating_list){
								  foreach ($performance_rating_list as $key => $rating)
								  { ?>
									 <option value="<?php echo $rating['id']; ?>" <?php if($salary_dtls['performance_rating'] == $rating['name']){ echo 'selected'; } ?> ><?php echo $rating['name']; ?></option>
								  <?php 
								  }
							} ?>
							</select>
						  </div>
						  <button href="javascript:;" onclick="upd_emp_performance_rating_for_salary();" class="btn btnp btn-primary"><i class="fa fa-check"></i></button>
						  <button href="javascript:;" id="btn_cancel_rating_change" class="btn btnp btn-primary"><i class="fa fa-times"></i></button>
					   </div>
					</td>
                </tr>
                <tr>
                  <td>Joined organization on <strong><?php echo date('d/m/Y',strtotime($salary_dtls["joining_date_for_increment_purposes"])); ?></strong></td>
                </tr>
              </table>
            </div>
          </div>
         
          <div class="col-sm-8" style="display: none;">
            <div class="right_budget_popup">
              <ul>
                <li class="tab_view">
                  <div class="tab_budget">
                    <span>Total / Available (Utilized) : USD 28,030  / 12,322 (143.96%) </span>
                  </div>
                </li>
                <li class="tab_view">
                  <div class="tab_budget">
                     <span>Direct Reports Total / Available : USD 28,030 / -12,322</span>
                  </div>
                </li>
                <li class="pop-overr">
                
                <div style="position: relative;"> 
                          <a data-toggle="tooltip" data-original-title="View Budget Details" data-placement="top" href="javascript:void();" class="shw_btn_pop_budget pull-right" ><i class="fa fa-dollar themeclr" aria-hidden="true"></i></a>           
                           <div id="hike_wise_bdgt" class="allocated_budget_detail" style="display: none;">
                            <div class="budget_allocated_table">
                              <div class="table-responsive">  
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                   <th colspan="2"></th>
                                   <th colspan="2" class="grey_bg_merit">Merit Increase</th>
                                   <th colspan="2" class="redish_bg_promotion">Promotion Increase</th>
                                   <th colspan="2" class="blue_bg_salary">Salary Correction</th>
                                  </tr>
                                      <tr>
                                        <th colspan="2"></th>
                                        <th class="grey_bg_merit">Amount</th>
                                        <th class="grey_bg_merit">%age</th>
                                        <th class="redish_bg_promotion">Amount</th>
                                        <th class="redish_bg_promotion">%age </th>
                                        <th class="blue_bg_salary">Amount</th>
                                        <th class="blue_bg_salary">%age </th>
                                      </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td colspan="2" class="pad00">
                                        <div class="team_alll">
                                          <table>
                                            <tbody>
                                              <tr>
                                                <td style="width:53%;" class="text-right">Direct Team : </td>
                                                <td>Allocated Budget</td>
                                              </tr>
                                              <tr>
                                                <td class="pdtp-0"></td>
                                                <td class="pdtp-0">Available Budget</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                      </td>
                                      <td colspan="2" class="pad00">
                                        <table class="width-100">
                                            <tbody>
                                              <tr>
                                                <td class="width-50 text-right"><sspan id="dv_m_direct_emps_merit_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_merit_allocated_budget"]); ?></sspan></td>
                                                <td><sspan id="dv_m_direct_emps_merit_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_merit_allocated_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                              <tr>
                                                <td class="width-50 text-right pdtp-0"><sspan id="dv_m_direct_emps_merit_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_merit_available_budget"]); ?></sspan></td>
                                                <td class="pdtp-0"><sspan id="dv_m_direct_emps_merit_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_merit_available_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </td>
                                      <td colspan="2" class="pad00">
                                        <table class="width-100">
                                            <tbody>
                                              <tr>
                                                <td class="width-50 text-right"><sspan id="dv_m_direct_emps_promotion_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_promotion_allocated_budget"]); ?></sspan></td>
                                                <td><sspan id="dv_m_direct_emps_promotion_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_promotion_allocated_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                              <tr>
                                                <td class="width-50 text-right pdtp-0"><sspan id="dv_m_direct_emps_promotion_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_promotion_available_budget"]); ?></sspan></td>
                                                <td class="pdtp-0"><sspan id="dv_m_direct_emps_promotion_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_promotion_available_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </td>
                                      <td colspan="2" class="pad00">
                                        <table class="width-100">
                                            <tbody>
                                              <tr>
                                                <td class="width-50 text-right"><sspan id="dv_m_direct_emps_market_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_market_allocated_budget"]); ?></sspan></td>
                                                <td><sspan id="dv_m_direct_emps_market_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_market_allocated_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                              <tr>
                                                <td class="width-50 text-right pdtp-0"><sspan id="dv_m_direct_emps_market_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_market_available_budget"]); ?></sspan></td>
                                                <td class="pdtp-0"><sspan id="dv_m_direct_emps_market_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_market_available_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </td>
                                    </tr>

                                     <tr>
                                      <td colspan="2" class="pad00">
                                        <div class="team_alll">
                                          <table>
                                            <tbody>
                                              <tr>
                                                <td style="width:53%;" class="text-right">All Team collective : </td>
                                                <td>Allocated Budget</td>
                                              </tr>
                                              <tr>
                                                <td class="pdtp-0"></td>
                                                <td class="pdtp-0">Available Budget</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                      </td>
                                      <td colspan="2" class="pad00">
                                        <table class="width-100">
                                            <tbody>
                                              <tr>
                                                <td class="width-50 text-right"><sspan id="dv_m_all_emps_merit_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_merit_allocated_budget"]); ?></sspan></td>
                                                <td><sspan id="dv_m_all_emps_merit_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_merit_allocated_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                              <tr>
                                                <td class="width-50 text-right pdtp-0"><sspan id="dv_m_all_emps_merit_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_merit_available_budget"]); ?></sspan></td>
                                                <td class="pdtp-0"><sspan id="dv_m_all_emps_merit_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_merit_available_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </td>
                                      <td colspan="2" class="pad00">
                                        <table class="width-100">
                                            <tbody>
                                              <tr>
                                                <td class="width-50 text-right"><sspan id="dv_m_all_emps_promotion_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_promotion_allocated_budget"]); ?></sspan></td>
                                                <td><sspan id="dv_m_all_emps_promotion_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_promotion_allocated_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                              <tr>
                                                <td class="width-50 text-right pdtp-0"><sspan id="dv_m_all_emps_promotion_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_promotion_available_budget"]); ?></sspan></td>
                                                <td class="pdtp-0"><sspan id="dv_m_all_emps_promotion_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_promotion_available_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </td>
                                      <td colspan="2" class="pad00">
                                        <table class="width-100">
                                            <tbody>
                                              <tr>
                                                <td class="width-50 text-right"><sspan id="dv_m_all_emps_market_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_market_allocated_budget"]); ?></sspan></td>
                                                <td><sspan id="dv_m_all_emps_market_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_market_allocated_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                              <tr>
                                                <td class="width-50 text-right pdtp-0"><sspan id="dv_m_all_emps_market_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_market_available_budget"]); ?></sspan></td>
                                                <td class="pdtp-0"><sspan id="dv_m_all_emps_market_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_market_available_budget_per"]); ?></sspan>%</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </td>
                                    </tr>
                                   </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                    </li>
                  </ul>
                </div>
              </div>










          <div class="col-sm-8">
			<?php 
			if($is_open_frm_manager_side)
			{ 
				$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($this->session->userdata('email_ses'))); ?>
				<div class="right_info">
					<table>
						<tr>
							<td style="padding-right:5px; text-align:right;">
								Total Team Budget 
								<a href="JavaScript:Void(0);" data-placement="right" data-toggle="tooltip" data-original-title="This is the total budget allocated to your teams below your hierarchy, including your direct reports."><i class="fa fa-info-circle themeclr"></i> </a>:
							</td>
							<td>
								<strong>
									<?php echo $rule_dtls['rule_currency_name']." ";
									echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"]); ?>
								</strong>
							</td>
							<td style="padding-right:5px; text-align:right;">
								Available Budget 
								<a href="JavaScript:Void(0);" data-placement="right" data-toggle="tooltip" data-original-title="This is the budget left in your budget pool that can be allocated to any of your team members, if you have been given that right to do so."><i class="fa fa-info-circle themeclr"></i>
								</a>:
							</td>
							<td>
								<strong>
									<?php echo $rule_dtls['rule_currency_name']." ";
									echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"]); ?>
								</strong>
							</td>
						</tr>
						<?php
						$managers_budget_dtls_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
						foreach($managers_budget_dtls_arr as $key => $value)
						{
							if(strtolower($salary_dtls["manager_emailid"]) == strtolower($value[0]))
							{?>
								<td style="padding-right:5px; text-align:right;">
									My Direct Reports Budget 
									<a href="JavaScript:Void(0);" data-placement="right" data-toggle="tooltip" data-original-title="This is the budget allocated to your direct reports only."><i class="fa fa-info-circle themeclr"></i></a> :
								</td>
								<td colspan="2">
									<strong>
										<?php echo $rule_dtls['rule_currency_name']." ";
										echo HLP_get_formated_amount_common($value[1] + (($value[1]*$value[2])/100)); ?>
									</strong>
								</td>
							<?php break;
							}
						} ?>
					</table>
				</div>
			<?php 
			} ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="sidebar">
          	<div id="dismiss"> <i class="glyphicon glyphicon-arrow-left"></i> </div>
			<div>
				<h3 style="margin-left: 5px;">Employee list</h3>
				<?php   
				if($staff_list)
				{ ?>
					<table id="example" class="table border" style="width: 100%; cellspacing: 0;">
						<thead>
							<tr>
								<th><?php echo $business_attributes[0]["display_name"]; ?></th>
							</tr>
						</thead>
						<tbody id="tbl_body">
							<?php 
							foreach($staff_list as $row)
							{
								echo "<tr><td><a href='".site_url($urls_arr["emp_increment_dtls_pg_url"]."/".$rule_id."/".$row["id"])."'>".$row["name"]." </a></td></tr>";
							}
							?>
						</tbody>
					</table>
				<?php
				} ?>
			</div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="column-1">
          <div class="map-1"  >
            <div id="salary_movement_chart" class="chart topchart"></div>
          </div>
          <div class="map-2">
            <div id="comparison_with_peers" class="chart bottomchart"></div>
            <div class="comp" style="display:none;">
              <?php //if(count($peer_salary_graph_dtls)> 1){ ?>
              Compare on :
              <select name="peertype" id="peertype" class="form-group" onchange="getAjaxPeerGraph()">
                <option value="<?php echo CV_BA_NAME_DESIGNATION;?>"> Designation</option>
				<option value="<?php echo CV_BA_NAME_GRADE;?>"> Grade</option>
                <option value="<?php echo CV_BA_NAME_LEVEL;?>"> Level</option>
              </select>
              <?php //}  ?>
            </div>
			<div style="text-align:center; display:none;">
            <select class="grap_sted form-control" name="ddl_team_data_for" id="ddl_team_data_for" onchange="getAjaxTeamDataForGraph()">
              <option value="Base">Base Salary</option>
              <option value="Target">Target Salary</option>
              <option value="Total">Total Salary</option>
            </select>
          </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="center-box-new card-1 card_fix_ver_cen" style="margin-top:11px; ">
          <div class="new-cd">
            <table class="table">
              <tr>
                <td class="current_box_lft">
				<?php if(!empty($table_atrribute_name_array['increment_applied_on_salary'])) { echo $table_atrribute_name_array['increment_applied_on_salary'];} else { echo 'Salary Being Reviewed'; } ?> <span>:</span>
				</td>
                <td class="current_box_rft text-left">
					<strong style="margin-left:10px;">
						<?php 
							echo $emp_currency_name." ".HLP_get_formated_amount_common($salary_dtls["increment_applied_on_salary"]);
						?>
					</strong>
				</td>
              </tr>
              <?php if($rule_dtls['display_variable_salary'] == "1")
			  { ?>
              <tr>
				<td style="text-align:right;font-size:14px;"><?php if(!empty($table_atrribute_name_array['current_target_bonus'])) { echo $table_atrribute_name_array['current_target_bonus'];} else { echo 'Variable Salary'; }?> <span>:</span></td>
				<td class="text-left">
					<strong style="margin-left:10px;">
					<?php					 
						echo $emp_currency_name." ".HLP_get_formated_amount_common($salary_dtls["current_target_bonus"]); ?>
					</strong>
				</td>
              </tr>
              <?php 
			  } ?>
			  <tr>
				<td style="text-align:right;font-size:14px;"><?php if(!empty($table_atrribute_name_array['current_position_pay_range'])) { echo $table_atrribute_name_array['current_position_pay_range'];} else { echo 'Salary Positioning'; }?> <span>:</span></td>
				<td class="text-left">
					<?php 
					if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
					{
						echo '<strong style="margin-left:10px;">'.$salary_dtls["post_quartile_range_name"].'</strong>';
					}
					else
					{
						if($salary_dtls["mkt_salary_after_promotion"]>0)
						{
							echo '<strong style="margin-left:10px;">'. HLP_get_formated_percentage_common(($salary_dtls["increment_applied_on_salary"]/$salary_dtls["mkt_salary_after_promotion"])*100).'</strong>%';
						}
						else
						{
							echo '<strong style="margin-left:10px;">0.00</strong>%';
						}
					}
					?>
				</td>
		  	  </tr>
            </table>
          </div>
        </div>
     
		<div class="card-2">
      <div class="card-2p">
	  		<?php if(isset($table_atrribute_name_array["merit_increase_amount"])){?>
	  	
			  <div class="black-box-new grey_bg_merit colordgn-blacktext clearfix" style="margin-bottom: 10px;">
				<div class="incre_detail_div">
				  <h3 class="text-center"><b>Merit Increase</b></h3>
				  <div class="icre_edit_detal clearfix">
					<div class="incre_amount">
					  <h4><?php echo $emp_currency_name;?> 
					  <span id="spn_amt_merit">
					  <?php echo HLP_get_formated_amount_common($merit_increase_amount);?>
					  </span>
					  <span id="spn_amt_input_merit" style="display:none;">
					  <input type="text" id="txt_amt_merit" value="<?php echo round($merit_increase_amount);?>" maxlength="12" class="icre_value" onKeyUp="validate_percentage_onkeyup_common(this,9);" onblur="validate_percentage_onblure_common(this,9); getper('merit', this.value); $('#hf_merit_hike_amt').val(this.value);"/>
					  </span>
					  </h4>
					</div>
					<div class="incre_per">
						<h4><span id="spn_hike_merit"><?php echo HLP_get_formated_percentage_common($salary_dtls["final_merit_hike"]); ?></span><span id="spn_hike_input_merit" style="display:none;"><input type="text" id="txt_hike_merit" value="<?php echo HLP_get_formated_percentage_common($salary_dtls["final_merit_hike"]);?>" maxlength="5" class="icre_per" onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this); getamt('merit', this.value); $('#hf_merit_hike_amt').val(this.value*$('#hf_increment_applied_on_sal').val()*0.01);"/></span>%
						</h4>
					</div>

            <div class="side-links" >
            <ul>
            <?php //if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr)))){
			if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr)){ ?>
            <li><img id="icon_edit_merit" onclick="show_opt_to_edit_hike('merit');" src="<?php echo base_url("assets/salary/img/edit_black.png"); ?>"/></li>
            <li><img style="display:none;"  id="icon_ok_merit" onclick="upd_merit_hike('merit');" src="<?php echo base_url("assets/salary/img/ok_black.png"); ?>"/></li>
            <li><img style="display:none;" id="icon_cross_merit" onclick="hide_opt_to_edit_hike('merit');" src="<?php echo base_url("assets/salary/img/cross_black.png"); ?>"/></li>
            <?php } ?>
            </ul>
          </div>

				  </div>
				</div>
				
			  </div>
			  
			  <?php }
			  if(isset($table_atrribute_name_array["sp_increased_salary"]))
			  {
			   if($rule_dtls['promotion_basis_on'] > 0){ ?>
			  <div class="black-box-new redish_bg_promotion colordgn-blacktext  clearfix" style="margin-bottom: 10px;">
				<div class="incre_detail_div">
					<h3 class="text-center"><b>Promotion</b>
					<div class="beg_color promotion_rec">
					  <label class="white black">
						<?php 
						$is_promotion_chk_checked = ""; 
						$is_promotion_chk_editable = 'disabled';
						if($is_already_promoted==1)
						{
							$is_promotion_chk_checked = "checked";
						}
						if($is_user_can_edit_salary_hikes)
						{
							$is_promotion_chk_editable = "";
						}
						if($is_promotion_chk_checked == "checked")
						{
							$is_promotion_chk_editable = 'disabled';
						}
						
						if($is_promotion_editable_by_current_usr == 1)
						{
							$promotion_readOnly='';
						} 
						else
						{
							$promotion_readOnly='readonly';
						}
						?>
					  <input id="chk_dfault_promotion" type="checkbox" <?php echo $is_promotion_chk_checked;?> <?php echo $is_promotion_chk_editable; ?> <?php if($is_promotion_chk_checked == ""){?>onclick="promotion_edit('<?php if($is_already_promoted != 1){ echo "1"; }else{ echo "0"; } ?>');" <?php } ?> />
					  <span></span></label>
					</div>
					</h3>
					<div class="icre_edit_detal clearfix">
						<div class="incre_amount">
							<h4><?php echo $emp_currency_name;?> 
								<span id="spn_amt_promotion">
								<?php echo HLP_get_formated_amount_common($salary_dtls["sp_increased_salary"]);?>
								</span>
								<span id="spn_amt_input_promotion" style="display:none;">
								<input type="text" id="txt_amt_promotion" value="<?php echo round($salary_dtls["sp_increased_salary"]);?>" maxlength="12" class="icre_value" onKeyUp="validate_percentage_onkeyup_common(this,9);" onblur="validate_percentage_onblure_common(this,9); getper('promotion', this.value); $('#hf_amt_promotion').val(this.value);" <?php echo $promotion_readOnly; ?>/>
								<input id="hf_amt_promotion" maxlength="10" type="hidden" value="<?php echo ($salary_dtls["sp_increased_salary"]); ?>">
								</span>
							</h4>
						</div>
						<div class="incre_per">
							<h4><span id="spn_hike_promotion"><?php echo HLP_get_formated_percentage_common($salary_dtls["sp_manager_discretions"]); ?></span><span id="spn_hike_input_promotion" style="display:none;"><input type="text" id="txt_hike_promotion" value="<?php if($is_already_promoted==1){echo HLP_get_formated_percentage_common($salary_dtls["sp_manager_discretions"]);}else{echo HLP_get_formated_percentage_common($salary_dtls['standard_promotion_increase']);}?>" maxlength="5" class="icre_per" onKeyUp="validate_percentage_onkeyup_common(this);" onblur="validate_percentage_onblure_common(this); getamt('promotion', this.value); $('#hf_amt_promotion').val(this.value*$('#hf_increment_applied_on_sal').val()*0.01);" <?php echo $promotion_readOnly; ?>/></span>%
							</h4>
						</div>

            <div class="side-links" >
          <ul>
          <?php if($rule_dtls['status'] < CV_STATUS_RULE_RELEASED){  ?>
          <li><img style=" <?php if($is_already_promoted != 1){?>display: none;<?php } ?>" id="icon_edit_promotion" onclick="promotion_edit();" src="<?php echo base_url("assets/salary/img/edit_black.png"); ?>"/></li>
          <li><img style="display: none;"  id="icon_ok_promotion" onclick="update_emp_promotion();" src="<?php echo base_url("assets/salary/img/ok_black.png"); ?>"/></li>
          <li><img style="display: none;" id="icon_cancel_promotion" onclick="delete_promotion();" src="<?php echo base_url("assets/salary/img/cancel_black.png"); ?>"/></li>
          <li><img style="display: none;" id="icon_cross_promotion" onclick="promotion_close('<?php if($is_already_promoted != 1){ echo "1"; }else{ echo "0"; } ?>');" src="<?php echo base_url("assets/salary/img/cross_black.png"); ?>"/></li>
        <?php } ?>
          </ul>
        </div>

					</div>
					<div class="promo_select">
					<div class="text-center">
						<select style="margin-top:7px; display:none;" class="customcls form-group" <?php if($is_user_can_edit_salary_hikes == 1 and ($is_open_frm_hr_side == 1 or $rule_dtls["promotion_can_edit"]==1)){ ?> id="ddl_emp_new_position" <?php } ?>>
							<option value="">Select <?php echo $level_name; ?></option>
							<?php $display_name1 = "";
							if(${$promotion_col_name."_list"})
							{
								foreach (${$promotion_col_name."_list"} as $promotion_value)
								{ ?>
									<option <?php if($salary_dtls['emp_new_'.$promotion_col_name]==$promotion_value['id']){ echo 'selected'; $display_name1 = $promotion_value['name']; } ?> value="<?php echo $promotion_value['id']; ?>"><?php echo $promotion_value['name']; ?></option>
								<?php
								}
							} ?>      
						</select>
					</div>
					</div>
				  	<h4 class="text-center" id="lbl_emp_new_position"> <?php if($display_name1){echo ucfirst($promotion_col_name)." - ". $display_name1;} ?></h4>
				  	<?php
					if($is_open_frm_hr_side==1)
					{
						$display_name2 = $display_name3 = ""; ?>
						<div class="promo_select">
							<div class="text-center">						
								<select class="customcls form-group" <?php if($is_user_can_edit_salary_hikes){ ?> id="ddl_emp_<?php echo $other_then_promotion_col_arr[0]; ?>" onchange="update_emp_promotion_basis_on('<?php echo "emp_new_".$other_then_promotion_col_arr[0]; ?>', this.value);" <?php }else{echo 'style="display:none;"';} ?>>
									<option value="">Select <?php echo $other_then_promotion_col_arr[0]; ?></option>
									<?php 
									if(${$other_then_promotion_col_arr[0]."_list"})
									{													
										foreach (${$other_then_promotion_col_arr[0]."_list"} as $othr_row)
										{ ?>
											<option <?php if($salary_dtls['emp_new_'.$other_then_promotion_col_arr[0]]==$othr_row['id']){ echo 'selected'; $display_name2 = $othr_row['name']; } ?> value="<?php echo $othr_row['id'] ?>"><?php echo $othr_row['name']; ?></option>
										<?php
										}
									} ?>      
								</select>						
							</div>
						</div>
				  		<h4 class="text-center"><?php if(!$is_user_can_edit_salary_hikes){echo $display_name2;} ?></h4>
						<div class="promo_select">
							<div class="text-center">						
								<select class="customcls form-group" <?php if($is_user_can_edit_salary_hikes){ ?> id="ddl_emp_<?php echo $other_then_promotion_col_arr[1]; ?>" onchange="update_emp_promotion_basis_on('<?php echo "emp_new_".$other_then_promotion_col_arr[1]; ?>', this.value);" <?php }else{echo 'style="display:none;"';} ?>>
									<option value="">Select <?php echo $other_then_promotion_col_arr[1]; ?></option>
									<?php 
									if(${$other_then_promotion_col_arr[1]."_list"})
									{													
										foreach (${$other_then_promotion_col_arr[1]."_list"} as $othr_row)
										{ ?>
											<option <?php if($salary_dtls['emp_new_'.$other_then_promotion_col_arr[1]]==$othr_row['id']){ echo 'selected'; $display_name3 = $othr_row['name']; } ?> value="<?php echo $othr_row['id'] ?>"><?php echo $othr_row['name']; ?></option>
										<?php
										}
									} ?>      
								</select>						
							</div>
						</div>
				  		<h4 class="text-center"><?php if(!$is_user_can_edit_salary_hikes){echo $display_name3;} ?></h4>
				  	<?php
					} ?>
				</div>
				
			  </div>	
			  <?php }}
			  if(isset($table_atrribute_name_array["market_correction_amount"])){ ?>		  
			  <div class="black-box-new blue_bg_salary colordgn-blacktext  clearfix" style="margin-bottom: 10px;">
				<div class="incre_detail_div">
				  <h3 class="text-center"><b>Salary Correction</b></h3>
				  <div class="icre_edit_detal clearfix">
					<div class="incre_amount">
					  <h4><?php echo $emp_currency_name;?> <span id="spn_amt_market"><?php echo HLP_get_formated_amount_common($market_correction_amount);?></span> <span id="spn_amt_input_market" style="display:none;">
        <input type="text" id="txt_amt_market" value="<?php echo round($market_correction_amount);?>" maxlength="12" class="icre_value" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9); getper('market', this.value); $('#hf_market_hike_amt').val(this.value);"/>
        </span> </h4>
					</div>
					<div class="incre_per">
					  <h4><span id="spn_hike_market"><?php echo HLP_get_formated_percentage_common($salary_dtls["final_market_hike"]); ?></span><span id="spn_hike_input_market" style="display:none;">
        <input type="text" id="txt_hike_market" value="<?php echo HLP_get_formated_percentage_common($salary_dtls["final_market_hike"]);?>" maxlength="5" class="icre_per" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this); getamt('market', this.value); $('#hf_market_hike_amt').val(this.value*$('#hf_increment_applied_on_sal').val()*0.01);"/>
        </span>%</h4>
					</div>

         <div class="side-links" >
          <ul>
          <?php //if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr)))){
		  if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr)){ ?>
          <li><img id="icon_edit_market" onclick="show_opt_to_edit_hike('market');" src="<?php echo base_url("assets/salary/img/edit_black.png"); ?>"/></li>
          <li><img style="display: none;"  id="icon_ok_market" onclick="upd_merit_hike('market');" src="<?php echo base_url("assets/salary/img/ok_black.png"); ?>"/></li>
          <li><img style="display: none;" onclick="hide_opt_to_edit_hike('market');" id="icon_cross_market" src="<?php echo base_url("assets/salary/img/cross_black.png"); ?>"/></li>
          <?php } ?>
          </ul>
        </div>

				  </div>
				</div>
				
			  </div>
			  <?php } ?>
			  <div class="black-box-new clearfix" style="margin-bottom: 10px;">
				<div class="incre_detail_div">
				  <h3 class="text-center">Total Increase
           <div class="tittle-info-links" >
            <!-- <img id="icon_inform_total" src="<?php //echo base_url("assets/salary/img/inform.png"); ?>"/> -->
            <img id="icon_comments_total" src="<?php echo base_url("assets/salary/img/comments.png"); ?>" onclick="show_comments_dv('<?php echo $salary_dtls['id']; ?>', <?php echo $is_user_can_edit_salary_hikes; ?>);"/>
           </div>   
          </h3>
				  <div class="icre_edit_detal clearfix">
					<div class="incre_amount">
					  <h4><?php echo $emp_currency_name;?> <span id="spn_amt_total"><?php echo HLP_get_formated_amount_common($total_salary_increment_amount);?></span> <span id="spn_amt_input_total" style="display:none;">
        <input type="text" id="txt_amt_total" value="<?php echo round($total_salary_increment_amount);?>" maxlength="12" class="icre_value" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9); getper('total', this.value); $('#hf_total_hike_amt').val(this.value);"/>
        </span> </h4>
					</div>
					<div class="incre_per">
					  <h4><span id="spn_hike_total"><?php echo HLP_get_formated_percentage_common($salary_dtls["manager_discretions"]); ?></span><span id="spn_hike_input_total" style="display:none;">
        <input type="text" id="txt_hike_total" value="<?php echo HLP_get_formated_percentage_common($salary_dtls["manager_discretions"]);?>" maxlength="5" class="icre_per" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this); getamt('total', this.value); $('#hf_total_hike_amt').val(this.value*$('#hf_increment_applied_on_sal').val()*0.01);"/>
        </span>%</h4>
					</div>
         <div class="side-links" >
          <ul>
          <?php //if($is_user_can_edit_salary_hikes==1 and ($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr)))){
		  if($is_user_can_edit_salary_hikes==1 and in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr)){ ?>
          <li><img id="icon_edit_total" onclick="show_opt_to_edit_hike('total');" src="<?php echo base_url("assets/salary/img/edit.png"); ?>"/></li>
          <li><img style="display: none;"  id="icon_ok_total" onclick="upd_merit_hike('total');" src="<?php echo base_url("assets/salary/img/ok.png"); ?>"/></li>
          <li><img style="display: none;" onclick="hide_opt_to_edit_hike('total');" id="icon_cross_total" src="<?php echo base_url("assets/salary/img/cross.png"); ?>"/></li>
          <?php } ?>
          </ul>
        </div>

				  </div>
				</div>
				
			  </div>
			  
			  <?php if($rule_dtls['esop_title']!="" && !empty($checkApproverEsopRights)) {?>
				  <div class="black-box-new clearfix" style="margin-bottom: 10px;">
					<div class="additinal_field_box">
					  <div class="text-left">
						<h4><?php echo $rule_dtls['esop_title'] ?></h4>
					  </div>
					  <input type="text" placeholder="<?php echo $rule_dtls["esop_title"]; ?>" id="txt_esop" value="<?php echo $salary_dtls["esop"]; ?>" onKeyUp="<?php if($rule_dtls["esop_type"] == 3){?>validate_percentage_onkeyup_common(this);<?php }elseif($rule_dtls["esop_type"] == 1){?>validate_onkeyup_num(this);<?php } ?>" onblur="<?php if($rule_dtls["esop_type"] == 3){?>validate_percentage_onblure_common(this);<?php }elseif($rule_dtls["esop_type"] == 1){?>validate_onblure_num(this);<?php } ?>" maxlength="<?php if($rule_dtls["esop_type"] == 3 or $rule_dtls["esop_type"] == 1){ echo "10"; }else{ echo "200"; } ?>" />					  
					  <div class="icon"> <img id="icon_ok_additinal" src="<?php echo base_url("assets/salary/img/ok.png"); ?>" onclick="update_emp_additional_field_dtls('esop');"/> </div>
					</div>
				  </div>
			  <?php } if($rule_dtls['pay_per_title']!="" && !empty($checkApproverPayPerRights)) {?>
				  <div class="black-box-new clearfix" style="margin-bottom: 10px;">
					<div class="additinal_field_box">
					  <div class="text-left">
						<h4><?php echo $rule_dtls["pay_per_title"]; ?></h4>
					  </div>
					  <input type="text" placeholder="<?php echo $rule_dtls["pay_per_title"]; ?>" id="txt_pay_per" value="<?php echo $salary_dtls["pay_per"]; ?>" onKeyUp="<?php if($rule_dtls["pay_per_type"] == 3){?>validate_percentage_onkeyup_common(this);<?php }elseif($rule_dtls["pay_per_type"] == 1){?>validate_onkeyup_num(this);<?php } ?>" onblur="<?php if($rule_dtls["pay_per_type"] == 3){?>validate_percentage_onblure_common(this);<?php }elseif($rule_dtls["pay_per_type"] == 1){?>validate_onblure_num(this);<?php } ?>" maxlength="<?php if($rule_dtls["pay_per_type"] == 3 or $rule_dtls["pay_per_type"] == 1){ echo "10"; }else{ echo "200"; } ?>" />
					  <div class="icon"> <img id="icon_ok_additinal" src="<?php echo base_url("assets/salary/img/ok.png"); ?>" onclick="update_emp_additional_field_dtls('pay_per');"/> </div>
					</div>
				  </div>
			  <?php } if($rule_dtls['retention_bonus_title']!="" && !empty($checkApproverBonusRecommandetionRights)) {?>
				  <div class="black-box-new clearfix" style="margin-bottom: 0px;">
					<div class="additinal_field_box">
					  <div class="text-left">
						<h4><?php echo $rule_dtls["retention_bonus_title"]; ?></h4>
					  </div>
					  <input type="text" placeholder="<?php echo $rule_dtls["retention_bonus_title"]; ?>" id="txt_retention_bonus" value="<?php echo $salary_dtls["retention_bonus"]; ?>" onKeyUp="<?php if($rule_dtls["retention_bonus_type"] == 3){?>validate_percentage_onkeyup_common(this);<?php }elseif($rule_dtls["retention_bonus_type"] == 1){?>validate_onkeyup_num(this);<?php } ?>" onblur="<?php if($rule_dtls["retention_bonus_type"] == 3){?>validate_percentage_onblure_common(this);<?php }elseif($rule_dtls["retention_bonus_type"] == 1){?>validate_onblure_num(this);<?php } ?>" maxlength="<?php if($rule_dtls["retention_bonus_type"] == 3 or $rule_dtls["retention_bonus_type"] == 1){ echo "10"; }else{ echo "200"; } ?>" />
					  <div class="icon"> <img id="icon_ok_additinal" src="<?php echo base_url("assets/salary/img/ok.png"); ?>" onclick="update_emp_additional_field_dtls('retention_bonus');"/> </div>
					</div>
				  </div>
			  <?php } ?>
			</div>
        </div>
        <?php if($emp_bonus_dtls){?>
        <div class="center-box-new card-1" style="margin-top:11px;">
          <div class="new-cd">
            <table class="table">
              <tr>
                <td style="width:50%; text-align:right; padding-right:15px; font-size:14px;">Target bonus <span>:</span></td>
                <td class="text-left"><strong style="margin-left:10px;" id="view_final_salary">
                  <?php echo $emp_currency_name." ". HLP_get_formated_amount_common($emp_bonus_dtls["target_bonus"]); ?></strong></td>
              </tr>
              <tr>
                <td style="width:180px; text-align:right; padding-right:15px; font-size:14px;">Bonus Amount payable <span>:</span></td>
                <td class="text-left"><strong style="margin-left:10px;">
                  <?php echo $emp_currency_name." ".HLP_get_formated_amount_common($emp_bonus_dtls["final_bonus"]). "(".$emp_bonus_dtls["final_bonus_per"]."%)"; ?>
                  </strong></td>
              </tr>
            </table>
          </div>
        </div>
        <?php } ?>
        <div class="center-box-new card-1 add-bottom card_fix_ver_cen" style="margin-top:11px;">
          <div class="new-cd">
            <table class="table">
              <tr>
                <td style="width:60%; text-align:right; padding-right:14px; font-size:15px;"><?php if(!empty($table_atrribute_name_array['final_salary'])) { echo $table_atrribute_name_array['final_salary'];} else { echo 'Revised Total Salary';} ?> <span>:</span></td>
                <td class="text-left"><strong style="margin-left:10px;" id="view_final_salary">
                  <?php echo $emp_currency_name." ". HLP_get_formated_amount_common($emp_revised_final_roundup_sal); ?></strong></td>
              </tr>
              <?php if($rule_dtls['display_variable_salary'] == "1"){ ?>
              <tr>
                <td style="text-align:right; padding-right:15px; font-size:15px;"><?php if(!empty($table_atrribute_name_array['revised_variable_salary'])) { echo $table_atrribute_name_array['revised_variable_salary'];} else { echo 'Variable Salary'; }?> <span>:</span></td>
                <td class="text-left"><strong style="margin-left:10px;">
                  <?php $rsu_enabled_for_domains_arr = explode(",", CV_RSU_ENABLED_FOR_DOMAINS_ARRAY);
				  	if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr))
					{									
						$new_total_fixed_salary = round(($emp_revised_final_roundup_sal*$salary_dtls["other_data_11"]/100), CV_RSU_ROUND_OFF);
						$revised_variable_salary = $emp_revised_final_roundup_sal - $new_total_fixed_salary;
					}
					else
					{									
						$new_total_fixed_salary = $current_total_fixed_salary + ($current_total_fixed_salary*$row["manager_discretions"]/100);
						$revised_variable_salary = $salary_dtls["current_target_bonus"] + ($salary_dtls["current_target_bonus"]*$salary_dtls["manager_discretions"]/100);
					}
				  
				  
				  //echo $emp_currency_name." ".HLP_get_formated_amount_common($salary_dtls["current_target_bonus"] + ($salary_dtls["current_target_bonus"]*($salary_dtls["sp_manager_discretions"] + $salary_dtls["manager_discretions"])/100));
				  echo $emp_currency_name." ".HLP_get_formated_amount_common($revised_variable_salary); ?>
                  </strong></td>
              </tr>
              <?php } ?>
              <tr>
                <td style="text-align:right; padding-right:15px; font-size:15px;"><?php if(!empty($table_atrribute_name_array['new_positioning_in_pay_range'])) { echo $table_atrribute_name_array['new_positioning_in_pay_range'];} else { echo 'Salary Positioning'; }?> <span>: </span></td>
                <td class="text-left"><strong style="margin-left:10px;">
				<?php                                             
					if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
					{
					  echo '<strong style="margin-left:10px;" id="revised_comparative_ratio">'.$salary_dtls["post_quartile_range_name"].'</strong>';
					}
					else
					{
						if($salary_dtls["mkt_salary_after_promotion"]>0){echo '<strong style="margin-left:10px;" id="revised_comparative_ratio">'. HLP_get_formated_percentage_common(($emp_revised_final_roundup_sal/$salary_dtls["mkt_salary_after_promotion"])*100);}else{echo '0.00';}
					  echo "</strong>%";
					  }
					 ?></strong>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="column-1">
          <div class="map-1 " >
            <div id="current_market_positioning" class="chart topchart"></div>
          </div>
          <div class="map-2 ">
            <div id="comparison_with_team" class="chart bottomchart" ></div>
            <div class="comp" style="height: 34px; display:none;"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Bootstrap core JavaScript -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" ></script>
<script>

<?php 
if($is_user_can_edit_salary_hikes ==  1)
{
	if(($is_open_frm_manager_side == 1 and $rule_dtls['manager_can_change_rating'] == 1) or ($is_open_frm_hr_side == 1)) { ?>
		$("#btn_edit_rating").click(function()
		{
			$("#dv_performance_rating").hide();
			$("#dv_performance_rating_dropdown").show();
		});
		$("#btn_cancel_rating_change").click(function()
		{
			$("#dv_performance_rating").show();
			$("#dv_performance_rating_dropdown").hide();
		});
		
		function upd_emp_performance_rating_for_salary()
		{
			var user_id = "<?php echo $salary_dtls['user_id'];?>";
			var rule_id = "<?php echo $rule_id;?>";
			var rating_id = $("#ddl_performance_rating").val();
			if(rating_id > 0)
			{
				$("#loading").show();
				var aurl = "<?php echo site_url($urls_arr["modify_rating_url"]);?>/"+rule_id+"/"+user_id +"/"+rating_id;
				$.ajax({
					url: aurl, success: function(result)
					{						
						if(result)
						{
							var response = JSON.parse(result);
							if(response.status)
							{
								window.location.href= "<?php echo current_url();?>";
							}
							else
							{
								custom_alert_popup(response.message);
							}
							$("#loading").hide();
						}
					}
				});
			}
			else
			{
				custom_alert_popup("Please select performance rattting.");
			}
		}
<?php 
	}
}

if($is_open_frm_hr_side==1){ ?>
	function update_emp_promotion_basis_on(based_on, new_position_id)
	{
		var emp_sal_id = $.trim($("#hf_emp_sal_id").val());
		if(emp_sal_id>0)
		{
			var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
			$.post("<?php echo site_url("increments/update_emp_promotion_basis_on"); ?>",{"emp_sal_id":emp_sal_id, "new_position_id" : new_position_id, "new_position_for" : based_on, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},function(data)
			{
				 set_csrf_field();
			});
		}
	}
<?php } ?>

function update_emp_additional_field_dtls(field_name)
{
	var emp_sal_id = $("#hf_emp_sal_id").val();	
	var esop_val = "";
	var retention_bonus_val = "";
	var pay_per_val = "";
	
	if($("#txt_esop").length)
	{
		esop_val = $("#txt_esop").val();
	}
	if($("#txt_retention_bonus").length)
	{
		retention_bonus_val = $("#txt_retention_bonus").val();
	}	
	if($("#txt_pay_per").length)
	{
		pay_per_val = $("#txt_pay_per").val();
	}

	if(emp_sal_id>0)
	{
		$("#loading").css('display','block');
		var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
		$.post("<?php echo site_url("increments/update_emp_additional_field_dtls"); ?>",{"emp_sal_id":emp_sal_id, "esop_val" : esop_val, "retention_bonus_val" : retention_bonus_val, "pay_per_val" : pay_per_val, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},function(data)
		{
			if(data)
			{
				var response = JSON.parse(data);
			}
			set_csrf_field();
			$("#loading").css('display','none');
		});
	}
}


/*****Hikes edit save code starts here******/  
function show_opt_to_edit_hike(obj)
{
	$('#spn_amt_'+obj).hide();
	$('#spn_hike_'+obj).hide();
	$('#spn_amt_input_'+obj).show();
	$('#spn_hike_input_'+obj).show();
	$('#icon_edit_'+obj).hide();
	$('#icon_ok_'+obj).show();
	$('#icon_cross_'+obj).show();
}

function hide_opt_to_edit_hike(obj)
{
	$('#spn_amt_'+obj).show();
	$('#spn_hike_'+obj).show();
	$('#spn_amt_input_'+obj).hide();
	$('#spn_hike_input_'+obj).hide();
	$('#icon_edit_'+obj).show();
	$('#icon_ok_'+obj).hide();
	$('#icon_cross_'+obj).hide();
}

function upd_merit_hike(obj)
{	
	<?php /*?><?php if(!helper_have_rights(CV_INCREMENTS_ID, CV_UPDATE_RIGHT_NAME)){ ?>
		alert("You do not have update inrements rights.");
		return false;
	<?php } ?><?php */?>
	var old_sal = $('#hf_increment_applied_on_sal').val();
    var emp_sal_id = $("#hf_emp_sal_id").val();
	//var new_hike = $('#txt_hike_'+obj).val();
	//var new_hike = ($('#txt_amt_'+obj).val()/old_sal)*100;
	var new_hike = ($('#hf_'+obj+'_hike_amt').val()/old_sal)*100;
	
	if(emp_sal_id>0 && new_hike != $("#hf_emp_hike_"+obj).val())
	{
		$("#loading").show();
		var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
		$.post("<?php echo site_url($urls_arr["modify_increment_url"]); ?>",{"emp_sal_id":emp_sal_id, "new_per" : new_hike, "hike_type":obj, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},function(data)
		{
			if(data)
			{
				var response = JSON.parse(data);
				if(response.status)
				{
					window.location.href= "<?php echo current_url();?>";
				}
				else
				{
					custom_alert_popup(response.msg);
					$('#txt_hike_'+obj).focus();
				}
				$("#loading").hide();
			}
			else
			{
				$('#txt_hike_'+obj).val($("#hf_emp_hike_"+obj).val());
			}
			set_csrf_field();
		});	
	}		
	//hide_opt_to_edit_hike(obj);             
}

function getper(obj, new_amt)
{
	var old_sal = $('#hf_increment_applied_on_sal').val();
	if(new_amt>0)
	{
		$('#txt_hike_'+obj).val(get_formated_percentage_common((new_amt/old_sal)*100));
	}
	else
	{
		$('#txt_hike_'+obj).val("");
	}
}
function getamt(obj, new_per)
{
	var old_sal = $('#hf_increment_applied_on_sal').val();
	if(new_per>0)
	{
		$('#txt_amt_'+obj).val(Math.round((old_sal*new_per)/100));
	}
	else
	{
		$('#txt_amt_'+obj).val("");
	}
}
/*****Hikes edit save code ends here******/

/*****Promotion increase edit save code starts here******/ 

function promotion_edit(reset_chk)
{
	$('#icon_ok_promotion').show();
	<?php if($is_already_promoted == 1){?>
		$('#icon_cancel_promotion').show();
	<?php } ?>
	$('#icon_cross_promotion').show();
	$('#ddl_emp_new_position').show();	
	$('#spn_amt_input_promotion').show();
	$('#spn_hike_input_promotion').show();
	$("#txt_hike_promotion").focus();
	
	$('#spn_amt_promotion').hide();
	$('#spn_hike_promotion').hide();
	$('#icon_edit_promotion').hide();
	$('#lbl_emp_new_position').hide(); 
	if(!$("#chk_dfault_promotion").is(":checked"))
	{
		promotion_close(reset_chk);
	}	
}

function promotion_close(reset_chk)
{
	$('#icon_ok_promotion').hide();
	$('#icon_cancel_promotion').hide();
	$('#icon_cross_promotion').hide();
	$('#ddl_emp_new_position').hide();
	$('#spn_amt_input_promotion').hide();
	$('#spn_hike_input_promotion').hide();
	
	$('#spn_amt_promotion').show();
	$('#spn_hike_promotion').show();	
	$('#lbl_emp_new_position').show(); 
	if(reset_chk == 1)
	{	
		$("#chk_dfault_promotion").prop("checked", false);
	}
	if($("#chk_dfault_promotion").is(":checked"))
	{
		$('#icon_edit_promotion').show();
	}
	else
	{
		$('#icon_edit_promotion').hide();
	}
}

function delete_promotion()
{
	var emp_sal_id = $("#hf_emp_sal_id").val();	
	$("#loading").show();
	$.ajax({
		type:"GET",
		url:'<?php echo site_url($urls_arr["delete_promotion_url"]) ?>/'+emp_sal_id,
		success: function(data)
		{
			var response = JSON.parse(data);
			if(response.status)
			{
				window.location.href= "<?php echo current_url();?>";
			}
			else
			{				
				$("#loading").hide();
				custom_alert_popup(response.msg);
			}
		}
	});
}

function update_emp_promotion()
{	
	var emp_sal_id = $("#hf_emp_sal_id").val();
	var old_sal = $('#hf_increment_applied_on_sal').val();
	var emp_promotion_per = ($('#hf_amt_promotion').val()/old_sal)*100;
	var standard_promotion_increase = <?php echo $salary_dtls["standard_promotion_increase"]; ?>;
	var manager_can_exceed_budget = <?php echo $rule_dtls['manager_can_exceed_budget']; ?>;
	if((emp_promotion_per*1) > standard_promotion_increase && manager_can_exceed_budget != <?php echo CV_MANAGER_CAN_EXCEED_BUDGET; ?> && manager_can_exceed_budget != <?php echo CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT; ?>)
	{
		custom_alert_popup("Promotion hike can not be increase more than "+standard_promotion_increase+"%");
		return;
	}
	
	var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
	//var emp_promotion_per = $('#txt_hike_promotion').val();
	$("#loading").show();
	$.ajax({
		type:"POST",
		url:'<?php echo site_url($urls_arr["modify_promotion_url"]) ?>/'+emp_sal_id,
		data:{txt_emp_sp_salary_per:emp_promotion_per, txt_emp_new_designation:$('#ddl_emp_new_position').val(), '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},
		success: function(data)
		{
			var response = JSON.parse(data);
			if(response.status)
			{
				window.location.href= "<?php echo current_url();?>";
			}
			else
			{          
				$("#txt_hike_promotion").focus();
				set_csrf_field();
				$("#loading").css('display','none');
				custom_alert_popup(response.msg);				
			}			
		}      
	});
}  
/*****Promotion increase edit save code ends here******/ 
</script>




<!-- ******************** Start :: Graph Related JS Only Goes Here ******************** -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script type="text/javascript">
	function downloadchart(cls)
	{
		var options = {};
		var pdf = new jsPDF('p', 'pt', 'a4');
		pdf.fromHTML($("."+cls).html(), 15, 15, options, function() {
			pdf.save(cls+'.pdf');
		});
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
	setGraphHeaderStyles("37");
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
                setGraphHeaderStyles();
                arrangeBottomCharts();
              }

            });
        
	function setGraphHeaderStyles(wdth = 25)
	{
		//for setting title styles
		var y, labels =  document.querySelectorAll('[text-anchor="start"]');
		for (var i=0;i<labels.length;i++)
		{ 
		   //y = parseInt(labels[i].getAttribute('y'));
		   //labels[i].setAttribute('x', 190);
		   //labels[i].setAttribute('x', wdth+"%");
		   labels[i].setAttribute('font-family', 'Gothic A1');
		   //labels[i].setAttribute('font-weight', 'bold');
		   //labels[i].setAttribute('font-size', 16);
		   //labels[i].setAttribute('text-align', 'center');
		   //labels[i].setAttribute('text-decoration', 'underline');
		   //#74767D
		   //labels[i].setAttribute('font-color', '#74767D');
		   
		   var title = labels[i].textContent;
		   //console.log(titl);
			/*if(title=='Salary Growth' || title=='Target Pay Comparison'|| title=='Comparison with Team' || title=='Peer Comparison' || title=='Designation' || title=='Comparison across the Peers  - by Designation' || title=='Comparison across the Peers  - by level' )
			{
			  labels[i].setAttribute('x', wdth+"%");
			}*/
			if(title=='Salary Growth')
			{
			  labels[i].setAttribute('x', "41%");
			}
			if(title=='Target Pay Comparison')
			{
			  labels[i].setAttribute('x', "35%");
			}
			if(title=='Comparison with Team')
			{
			  labels[i].setAttribute('x', "35%");
			}
			if(title=='Peer Comparison' || title=='Designation' || title=='Comparison across the Peers  - by Designation' || title=='Comparison across the Peers  - by level' )
			{
			  labels[i].setAttribute('x', "39%");
			}	
		}
	}


	function getAjaxSalaryMovementGraph()
	{
		var empid = "<?php echo $salary_dtls['user_id'];?>";
		var rule_id = "<?php echo $rule_id;?>";
		var type = $("#ddl_team_data_for").val();
		<?php if($this->session->userdata('is_manager_ses') == 1 and $is_open_frm_manager_side==1){?> 
		var aurl = "<?php echo site_url('manager/dashboard/get_emp_salary_movement_data_graph');?>/"+rule_id+"/"+empid+"/"+type;
		<?php }else{?> 
		var aurl = "<?php echo site_url('increments/get_emp_salary_movement_data_graph');?>/"+rule_id+"/"+empid+"/"+type;
		<?php } ?> 
		$.ajax({url: aurl, success: function(result)
		{
		$("#salary_movement_chart").html(result);
		setGraphHeaderStyles("70");
		}});
	}
	
	function getAjaxPeerGraph()
	{
		var empid = "<?php echo $salary_dtls['id'];?>";
		var peer_type = $("#peertype").val();
		var graph_for = $("#ddl_team_data_for").val();//$("#ddl_peer_data_for").val();
		<?php if($this->session->userdata('is_manager_ses') == 1 and $is_open_frm_manager_side==1){?> 
		
		  var aurl = "<?php echo site_url('manager/dashboard/get_peer_employee_salary_dtls_for_graph');?>/"+empid+"/"+peer_type+"/"+graph_for;
		<?php }else{?> 
		  var aurl = "<?php echo site_url('increments/get_peer_employee_salary_dtls_for_graph');?>/"+empid+"/"+peer_type+"/"+graph_for;
		<?php } ?> 
		//alert(aurl);return;
		$.ajax({url: aurl, success: function(result){
		  $("#comparison_with_peers").html(result);
		  setGraphHeaderStyles();
		}});
	}
  
  $(document).ready(function()
  {
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
  
  <?php /*?><?php if($company_dtls["peer_graph_for"] == CV_LEVEL){?>
		$("#peertype").val("<?php echo CV_LEVEL; ?>");
		//getAjaxPeerGraph();
  <?php } ?><?php */?>
  $("#peertype").val("<?php echo $company_dtls["peer_graph_for"]; ?>");
  //getAjaxPeerGraph();
  
  <?php //if($this->session->userdata('market_data_by_ses') == CV_MARKET_SALARY_CTC_ELEMENT){?>
    function getAjaxMarketDataMultipleBenchmarkGraph()
    {
      var empid = "<?php echo $salary_dtls['user_id'];?>";
      var rule_id = "<?php echo $rule_id;?>";
      var type = $("#ddl_team_data_for").val();//$("#ddl_market_data_for").val();
      <?php if($this->session->userdata('is_manager_ses') == 1 and $is_open_frm_manager_side==1){?> 
       var aurl = "<?php echo site_url('manager/dashboard/get_emp_market_data_graph_for_multiple_benchmark');?>/"+rule_id+"/"+empid+"/"+type;
     <?php }else{?> 
       var aurl = "<?php echo site_url('increments/get_emp_market_data_graph_for_multiple_benchmark');?>/"+rule_id+"/"+empid+"/"+type;
     <?php } ?> 
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
    $("#loading").show();
    var empid = "<?php echo $salary_dtls['user_id'];?>";
    var rule_id = "<?php echo $rule_id;?>";
    var type = $("#ddl_team_data_for").val();
    <?php if($this->session->userdata('is_manager_ses') == 1 and $is_open_frm_manager_side==1){?> 
      var aurl = "<?php echo site_url('manager/dashboard/get_emp_team_data_for_graph');?>/"+rule_id+"/"+empid+"/"+type;
    <?php }else{?> 
      var aurl = "<?php echo site_url('increments/get_emp_team_data_for_graph');?>/"+rule_id+"/"+empid+"/"+type;
    <?php } ?> 
    $.ajax({url: aurl, success: function(result)
      {
       $("#comparison_with_team").html(result);
       setGraphHeaderStyles();
       setTimeout(function(){ $("#loading").hide(); }, 1000);
     }});
    getAjaxSalaryMovementGraph();
    getAjaxMarketDataMultipleBenchmarkGraph();
    getAjaxPeerGraph();

  }
  getAjaxTeamDataForGraph();
</script>
<!-- ******************** End: Graph Related JS Only Goes Here ******************** -->
<script src="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">

$(function() {
  $("ul.dropdown-menu").on("click", function(e) {
    $(".custom_icon_popup ul.nav li.dropdown").addClass("opennn");
    e.stopPropagation()
  });
  $(document).on("click", function(e) {
    if ($(e.target).is(".custom_icon_popup ul.nav li.dropdown") === false) {
      $(".custom_icon_popup ul.nav li.dropdown").removeClass("opennn");
    }
  });
});
  
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
	
	$('#example').DataTable({
      "paging":   false,
      "info":     false,
      "searching": false
    });
  });






$(document).ready(function()
{    
    $('.shw_btn_pop_budget').click( function(e)
  {
        //console.log(e.currentTarget.lang);
   
        e.preventDefault(); // stops link from making page jump to the top
        e.stopPropagation(); // when you click the button, it stops the page from seeing it as clicking the body too
        //$('.allocated_budget_detail').toggle();
    $('.allocated_budget_detail').hide();
    $('#hike_wise_bdgt').toggle();
    });
    
    $('.allocated_budget_detail').click( function(e)
  {        
        e.stopPropagation(); // when you click within the content area, it stops the page from seeing it as clicking the body too        
    });
    
    $('body').click( function()
  {       
        $('.allocated_budget_detail').hide();        
    });    
});
</script>


<style type="text/css">
.launch-modal{}
.launch-modal textarea{border-color: #bdbdbd;}
.launch-modal .modal-header{padding: 10px 20px !important; height: 40px !important;}
.tooltip-inner{font-size: 10px;}
.promaction.before_edit img{position: relative; left:284%;}

</style>


<!-- Start :: Salary/Promotion Comments section -->
<div class="modal fade" id="salary_promotion_comment_dv" role="dialog">
  <div class="modal-dialog" role="document">
    <!-- Modal content-->
    <div class="modal-content">
		
			<div class="modal-header headp">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<label style="font-size: 16px;">Comments</label>
				</h4>
			</div>
			<div class="modal-body">
				<form id="frm_salary_promotion_comment" class="form-horizontal" method="post" action="<?php echo site_url("increments/ins_upd_salary_promotion_comment/".$is_open_frm_manager_side); ?>" onsubmit="return ins_upd_salary_promotion_comment(this);" >
					<?php echo HLP_get_crsf_field(); ?>
					<input type="hidden" id="hf_usr_tbl_id" name="hf_usr_tbl_id" />
					<input type="hidden" id="hf_comment_dtls" value='<?php echo $salary_dtls["comments"]; ?>' />
						<div class="row">
             <div class="col-sm-11"> 
							<div class="form-group my-form">	
								<div class="form-input removed_padding">
									<textarea rows="1"  type="text" name="txt_comment" id="txt_comment" class="form-control" required maxlength="150"></textarea>
								</div>
							</div>   
						</div>
            <div class="col-sm-1">
              <button type="submit" value="Save" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>
            </div>
          
				</form>
          <div class="col-sm-12">
            <div id="dv_salary_promotion_comment_tbl" class="promotion_comments">
             <div class="table-responsive"> 
              <table class="table border" style="width: 100%; cellspacing: 0;">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Comment</th>                                    
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody id="tbl_body_salary_promotion_comment"> 
                </tbody>
              </table>
            </div>
           </div>  
          </div>
        </div>

			</div>
			     
    </div>
  </div>

<script>
function show_comments_dv(tbl_id, can_edit)
{
	$('#dv_salary_promotion_comment_tbl').hide();
	$('#frm_salary_promotion_comment').hide();
	
	var comment_dtls = $("#hf_comment_dtls").val();
	if(comment_dtls)
	{
		create_comments_tbl(comment_dtls);
	}
	if(can_edit==1)
	{
		$("#hf_usr_tbl_id").val(tbl_id);
		$('#frm_salary_promotion_comment').show();
	}
	$('#salary_promotion_comment_dv').modal("show");
}

function create_comments_tbl(comment_dtls)
{
	
	var data = JSON.parse(comment_dtls);
	$("#tbl_body_salary_promotion_comment").html(""); 
	var str = "";
	for(var i=0; i< data.length; i++)
	{//console.log(data[i].c_by_name);
		str += "<tr><td>"+data[i].c_by_name+"</td><td>"+data[i].type+"</td><td>"+data[i].msg+"</td><td>"+data[i].c_on+"</td></tr>";
	}
	//console.log(str);
	$("#tbl_body_salary_promotion_comment").html(str); 
	$('#dv_salary_promotion_comment_tbl').show();
}

function ins_upd_salary_promotion_comment(frm)
{
	var form=$("#"+frm.id);	
	if($("#txt_comment").val()=="")
	{
		return false;
	}
	$("#loading").css('display','block');
	var tbl_id = $("#hf_usr_tbl_id").val();
	$.ajax({
		type:"POST",
		url:form.attr("action"),
		data:form.serialize(),
		success: function(response)
		{
			var data = JSON.parse(response);
			if(data.status)
			{
				$("#hf_comment_dtls").val(data.new_comment_dtls);
				$("#txt_comment").val("");
				create_comments_tbl(data.new_comment_dtls);
			}		
			set_csrf_field();
			$("#loading").css('display','none');
		}
	});
	return false;
}
</script>
<!-- End :: Salary/Promotion Comments section -->
