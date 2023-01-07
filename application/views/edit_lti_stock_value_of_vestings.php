<style>
.form_head ul {
	padding:0px;
	margin-bottom:0px;
}
.form_head ul li {
	display:inline-block;
}
.rule-form .control-label {
	font-size: 12px;
	line-height: 30px;
}
.rule-form .form-control {
	height: 30px;
	margin-top: 0px;
	font-size: 12px;
	background-color: #FFF;
	margin-bottom:10px;
}
.rule-form .control-label {
	font-size: 11.25px;
 <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?> background-color:#<?php echo $this->session->userdata("company_light_color_ses");
?>;
	color: #000;
	margin-bottom:10px;
}
.rule-form .form-control:focus {
	box-shadow: none!important;
}
.rule-form .form_head {
	background-color: #f2f2f2;
 <?php /*?>border-top: 8px solid #93c301;<?php */?> border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
?>;
}
.rule-form .form_head .form_tittle {
	display: block;
	width: 100%;
}
.rule-form .form_head .form_tittle h4 {
	font-weight: bold;
	color: #000;
	text-transform: uppercase;
	margin: 0;
	padding: 12px 0px;
	margin-left: 5px;
}
.rule-form .form_head .form_info {
	display: block;
	width: 100%;
	text-align: center;
}
.rule-form .form_head .form_info i {
	color: #8b8b8b;
	font-size: 24px;
	padding: 7px;
	margin-top:-4px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
	margin-bottom: 30px;
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
	border-bottom-left-radius: 6px;
	border-bottom-right-radius: 6px;
}
.rule-form .form_info .btn-default {
	border: 0px;
	padding: 0px;
	background-color: transparent!important;
}
.rule-form .form_info .tooltip {
	border-radius: 6px !important;
}
.mar10 {
	margin-bottom: 10px !important;
}
</style>
<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
    <li class="active">Edit LTI Stock Value Of Vestings</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
<!-- container -->
<div class="row">
  <div class="col-md-12">
    <div class="mb20">
      <div class="panel panel-white">
        <?php 		 
		  $p3=getToolTip('lti-rule-page-3');
		  $page3=json_decode($p3[0]->step);
		  ?>
        <div class="panel-body">
          <div class="rule-form">
          	<form method="post" action="">
                <div class="form-group" style="margin-bottom:0px;">
                  <div class="row">                   
                    <div class="col-sm-12">
                    <?php echo $this->session->flashdata('message'); ?>
                      <div class="rule-form">
                        <div class="form_head clearfix">
                          <div class="col-sm-12">
                            <ul>
                              <li>
                                <div class="form_tittle">
                                  <h4>Edit LTI Stock Value Of Vestings</h4>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="form_sec  clearfix table-responsive"  style="margin-bottom:10px;">
                          <table class="table table-bordered ">
                            <thead>
                            </thead>
                            <tbody>
                              <?php $i=0; $j=0;
								if($target_lti_elements)
								{ 
									$target_lti_dtl_arr = "";
									if($rule_dtls['target_lti_dtls'])
									{
										$target_lti_dtl_arr = json_decode($rule_dtls['target_lti_dtls'], true);
									}
									
									foreach($target_lti_elements as $row){						
										if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_STOCK and $i == 0){ ?>
										  <tr bgcolor="#BBFFFF">
											<th>Period <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[1] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Current Stock Value <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-1 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[3] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-2 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[4] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-3 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[5] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-4 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[6] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-5 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[7] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-6 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[8] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
											<th>Vesting-7 <span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $page3[9] ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
										  </tr>
										  <tr bgcolor="#BBFFFF">
											<th style="min-width:85px;">Stock Price</th>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?>" name="txt_grant_val" placeholder="0" required /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?>" name="txt_vesting_val_1" placeholder="0" required /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?>" name="txt_vesting_val_2" placeholder="0" /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?>" name="txt_vesting_val_3" placeholder="0" /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?>" name="txt_vesting_val_4" placeholder="0" /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?>" name="txt_vesting_val_5" placeholder="0" /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?>" name="txt_vesting_val_6" placeholder="0" /></td>
											<td><input type="text" class="form-control" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" maxlength="7" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?>" name="txt_vesting_val_7" placeholder="0" /></td>
										  </tr>
										  <?php $i++; } ?>
                              <?php } }?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" value="Update" class="pull-right btn btn-success"/>
                    </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
