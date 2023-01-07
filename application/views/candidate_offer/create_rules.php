<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<script>
var useFastselect = true;
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
	.fstResultItem{ font-size:1em;}
	.fstControls{line-height:17px;}

	.rule-form.rule-comm .form_head ul{ padding:0px; margin-bottom:0px;}
	.rule-form.rule-comm .form_head ul li{ display:inline-block;}

	.rule-form.rule-comm .form-control {
	height: 30px;
	margin-top: 0px;
	font-size: 12px;
	background-color: #FFF;
	margin-bottom:10px;
	}
	.rule-form.rule-comm .control-label {
	font-size: 13px;
	line-height: 30px;
	color: #000;
	margin-bottom:10px;
	}
	.rule-form.rule-comm .form-control:focus {
	box-shadow: none!important;
	}
	.rule-form.rule-comm .form_head {
	background-color: #f2f2f2;
	
	}
	.rule-form.rule-comm .form_head .form_tittle {
	display: block;
	width: 100%;
	}
	.rule-form.rule-comm .form_head .form_tittle h4 {
	font-weight: bold;
	color: #000 !important;
	text-transform: uppercase;
	margin: 0;
	padding: 12px 0px;
	margin-left: 5px;
	}
	.rule-form.rule-comm .form_head .form_info {
	display: block;
	width: 100%;
	text-align: center;
	}
	.rule-form.rule-comm .form_head .form_info i {
	/*color: #8b8b8b;*/
	font-size: 24px;
	margin-top: -4px;
	padding: 7px;
	}
	.rule-form.rule-comm .form_sec {
	background-color: #f2f2f2;
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
	border-bottom-left-radius: 0px;/*6px;*/
	border-bottom-right-radius: 0px;/*6px;*/
	}
	.rule-form.rule-comm .form-group{
	margin-bottom: 10px;
	}
	.rule-form.rule-comm .form_info .btn-default {
	border: 0px;
	padding: 0px;
	background-color: transparent!important;
	}
	.rule-form.rule-comm .form_info .tooltip {
	border-radius: 6px !important;
	}
	
	
	
	.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
	border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
	.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
	.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
	.sal_incre_rang:hover{border:2px solid #<?php echo $this->session->userdata("company_color_ses"); ?>}
	.sal_incre_rang:hover input{border:2px solid #<?php echo $this->session->userdata("company_color_ses"); ?>}
	.rule-form.rule-comm .control-label {background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;}
	.rule-form.rule-comm .form_head {border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;}


</style>
<div class="page-breadcrumb">
	<div class="container-fluid compp_fluid">
		<div class="row">
			<div class="col-sm-8 padlt0">
				<ol class="breadcrumb container-fluid">
					<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
					<li class="active">Candidate Salary Rule</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div id="main-wrapper" class="container-fluid compp_fluid">
	<div id="fmsg">
			<?php
			if(!empty($this->session->flashdata('msg'))) {
				echo $this->session->flashdata('msg'); }
			?>
			</div>
	<div class="row">
		<div class="col-md-12">
			<div class="mb20">
				<div class="panel panel-white">
					<?php $tooltip=getToolTip('salary-rule-page-2');$val=json_decode($tooltip[0]->step); ?>
					<div class="panel-body">
						<div class="rule-form rule-comm">
							<form name="candidateOfferRule" id="candidateOfferRule"  method="post" action="" >
								<?php echo HLP_get_crsf_field();?>
								<input type="hidden" class="btn-w120" value="<?php if(!empty($rule_dtls['id'])) { echo $rule_dtls['id']; }?>" id="rule_id" name="rule_id" />
								<div class="form-group">
									<div class="row" id="dv_frm_head">
										<div class="col-sm-12">
											<div class="form_head clearfix">
												<div class="col-sm-12">
													<ul>
														<li>
															<div class="form_tittle">
																<h4>Define Basic Offer Rules <span id="spn_rule_name"></span></h4>
															</div>
														</li>
														<li>
															<div class="form_info">
																<button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title=""><i style="margin-top:-2px;font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
															</div>
														</li>
														<li>
															<div class="form_info">
																<span class="msg"></span>
															</div>
														</li>
													</ul>
												</div>
											</div>
											<div class="form_sec clearfix">
												<div class="col-sm-12">
													<div class="" >
														<div class="" >
															<div class="col-sm-6 removed_padding">
																<label for="offer_rule_name" class="control-label">Offer Rule Name <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Write name of this specific rule which will be displayed to all Offer." data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label>
															</div>
															<div class="col-sm-6 padrt0">
																<input type="text" id="offer_rule_name" name="offer_rule_name" value="<?php if(!empty($rule_dtls['offer_rule_name'])) { echo $rule_dtls['offer_rule_name']; }?>" class="form-control" required="required" maxlength="128"/>
															</div>
														</div>
														<div id="dv_partial_page_data">
															<div class="" >
																<div class="">
																	<div class="col-sm-6 removed_padding">
																		<label for="offer_applied_on_elements" class="control-label">Select salary component to be compared for internal data<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></label>
																	</div>
																	<div class="col-sm-6 padrt0" style="margin-bottom:8px;">
																		<select id="offer_applied_on_elements"  name="offer_applied_on_elements[]" class="form-control multipleSelect" required="required" multiple="multiple">
																			<option  value="all">All</option>
																			<?php if($salary_applied_on_elem_list){
																				$offer_applied_on_elements = "";
																				if(!empty($rule_dtls['offer_applied_on_elements'])) { 
																					$offer_applied_on_elements = explode(",", $rule_dtls['offer_applied_on_elements']);
																				}

																				foreach($salary_applied_on_elem_list as $row) { ?>
																					<option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($offer_applied_on_elements) and in_array($row["business_attribute_id"], $offer_applied_on_elements)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
																				<?php }
																				} ?>
																		</select>
																	</div>
																</div>
															</div>
															<div class="">
																<div>
																	<div>
																		<div class="col-sm-6 removed_padding">
																			<label for ="pay_range_basis_on" class="control-label">
																			Select salary component to be compared for pay range data<span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="Select salary component to be compared for pay range data" data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
																			</label>
																		</div>
																		<div class="col-sm-6 padrt0">
																			<select class="form-control" id="pay_range_basis_on" name="pay_range_basis_on" required="required">
																				<?php if(!empty($market_salary_elements_list)){
																					foreach($market_salary_elements_list as $row) {;
																						$value = $row["id"];
																						$selected = '';

																						if(!empty($rule_dtls['pay_range_basis_on']) && $rule_dtls['pay_range_basis_on'] == $value) {
																							$selected = 'selected="selected"';
																						}
																						?>
																				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $row["display_name"] ?></option>
																				<?php }
																					} ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-6 removed_padding">
																		<label for="txt_crr" class="control-label">
																		Select positioning in the internal data <span style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
																		</label>
																	</div>
																	<div class="col-sm-6 padrt0">
																		<div class="row">
																			<div class="col-sm-12">
																				<div class="form-group rv1" style="margin-bottom: 0px;">
																					<div class="row">
																						<div class="col-sm-12">
																							<input type="text" name="txt_crr[]" class="form-control distance_dvs" id="txt_crr" placeholder="Range" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);">
																						</div>
																						<!--<div class="col-sm-2 plft0" id="dv_btn_dlt">
																							<button style="margin-top:1px; padding:4px 12px; margin-left:-6px;" type="button" class="btn btn-primary btn-w94" onclick="addAnotherRow();">ADD CRR </button>
																						</div>-->
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
                                                                    <div class="col-sm-6 removed_padding">
																		<label class="control-label">
																		Effective Date
																		</label>
																	</div>
																	<div class="col-sm-6 padrt0">
																	  <div class="">
																		<input id="txt_effective_dt" name="txt_effective_dt" type="text" class="form-control " required="required" maxlength="10" value="<?php if(!empty($rule_dtls["effective_dt"]) && $rule_dtls["effective_dt"] != "0000-00-00"){ echo $rule_dtls["effective_dt"];} ?>" autocomplete="off" onblur="checkDateFormat(this)">
																	  </div>
																	</div>
																	<!--<div class="col-sm-6 removed_padding">
																		<label class="control-label">
																		CutOff Date
																		</label>
																	</div>
																	<div class="col-sm-6 pad_right0">
																	  <div class="">
																	  <input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php //if(!empty($rule_dtls["cutoff_date"]) && $rule_dtls["cutoff_date"] != "0000-00-00"){ echo $rule_dtls["cutoff_date"];} ?>" autocomplete="off" onblur="checkDateFormat(this)">
																	  </div>
																	</div>-->
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-12 padrt0 mob-center text-right creatSam" >
														<input type="submit" id="btnAdd" name="btn_next" value="<?php echo $button_text; ?>" class="btn btn-primary ">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						<?php if(!empty($all_offer_rule_dets)) { ?>
						<div>
							<table class="table border" id="datatable">
								<thead>
									<th>S.No</th>
									<th>Rule Name</th>
									<th>Effective Date</th>
									<!--<th>CutOff Date</th>-->
									<th>Status</th>
									<th>Edit</th>
								</thead>
								<tbody>
									<?php
										$i = 1;
										foreach ($all_offer_rule_dets as $key => $det_val) { ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $det_val['offer_rule_name']; ?></td>
										<td><?php echo $det_val['effective_dt']; ?></td>
										<!--<td><?php //echo $det_val['cutoff_date']; ?></td>-->
										<td><?php echo $det_val['status']; ?></td>
										<td><a href="<?php echo site_url("candidate-offer-rule-setting").'/'.$det_val['id']; ?>">Edit</a></td>
									</tr>
									<?php
										$i++;
										}
										?>
								</tbody>
							</table>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/candidate_offer.js"); ?>"></script>
