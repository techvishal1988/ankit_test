<style>
.form_sec .salary-revw-grid {}
.form_sec .salary-revw-grid tbody tr td input{display: inline-block; text-align: right !important; position: relative !important; padding-right: 14px !important;}

.form_sec .salary-revw-grid tbody tr td input+span:after{content: "%";
    color: #000;
    position: absolute;
    right: 5px;
    top: -1px;
    font-size: 13px;
    font-weight: bold;
}

.form_sec .salary-revw-grid tbody tr td input.spl_box{position: relative !important; padding-right: 15px !important;}
.form_sec .salary-revw-grid tbody tr td input.spl_box+span:after{content: "%";
    color: #000;
    position: absolute;
    right: 6px;
    top: 4px;
    font-size: 13px;
    font-weight: bold;
}

.form_sec .salary-revw-grid tbody tr td input.max_crr_box{position: relative !important; padding-right: 15px !important;}    
.form_sec .salary-revw-grid tbody tr td input.max_crr_box+span:after{content: "%";
    color: #000;
    position: absolute;
    right: 6px;
    top: 4px;
    font-size: 13px;
    font-weight: bold;
}
.form_head ul{ padding:0px; margin-bottom:0px;}
.form_head ul li{ display:inline-block;}

.rule-form .control-label {
	font-size: 12px;
	line-height: 30px;
}
.rule-form .form-control {
	height: 30px;
	margin-top: 0px;
	font-size: 13px;
	background-color: #FFF;
	margin-bottom:10px;}
/*.rule-form .forth .form-control {
    height: 53px !important;
}*/

.rule-form .form-control.opt{font-size: 12px !important;}

.rule-form .control-label {
	font-size: 11.25px;
	<?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
	background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
	/*color: #000;*/
	margin-bottom:10px;
}
.rule-form .form-control:focus {
	box-shadow: none!important;
}
.rule-form .form_head {
	background-color: #f2f2f2;
	<?php /*?>border-top: 8px solid #93c301;<?php */?>
	border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
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
	margin-top:0px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
	
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
/*	border-bottom-left-radius: 6px;
	border-bottom-right-radius: 6px;*/
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
th .tooltipcls{
        text-align: center !important;
    float: none !important;
}
th{
    text-align: center;
}

.txt_color
{
	<?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
	background-color:#eee !important;
	<?php } ?>
}

.crr_per{display: inline-block; vertical-align: top;
    /* float: right; */
    font-weight: bold;
    font-size: 10px;
    padding: 1px;
    text-align: center;
    }

.perf_inc_hk{ font-weight: bold; font-size:13px; padding:2px 0px; text-align:left; vertical-align:top; margin-top:-1%;}

.rule-form .form-control.spl_box{padding: 4px 15px 4px 4px !important;}    
.crr_per.first{width: 47%; font-size: 13px; margin-top: 6px; color: #FF6600;}

.calu{display:inline-block; width:100%;}
.calu .crr_per.secnd{width: 47%; font-size: 13px; padding: 2px 6px 2px 0px; text-align: right;}
.calu .crr_per.third{width: 47%; font-size: 13px; padding: 2px 6px 2px 0px; text-align: right;}

.green{background-color: #46b603; color: #fff; font-weight: normal;} 
.blue{background-color: #0084ff; color: #fff; font-weight: normal;}
.voilet{background-color: #6a01a6; color: #fff; font-weight: normal;}
.form_head ul li {
    vertical-align: top;
}

.table.th-top-aln thead tr th{vertical-align: middle !important;}
.hide_pre_post_population{display:none; !important;}

.table.disa_input{}
.table.disa_input td input{pointer-events: none;}
</style>
<?php if(!isset($is_show_on_manager)){?>
<form id="frm_rule_step3" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("rules/set_rules/".$rule_dtls['id']."/3"); ?>">
<?php echo HLP_get_crsf_field();
 } 
 	$multiplier_wise_per_dtls = json_decode($rule_dtls["multiplier_wise_per_dtls"], true);
	$mw_rating_arr = $multiplier_wise_per_dtls["rating"];
	$mw_crr_arr = $multiplier_wise_per_dtls["crr"];
	$mw_mkt_elem_arr = $multiplier_wise_per_dtls["mkt_elem"];
	$mw_max_per_arr = $multiplier_wise_per_dtls["max_per"];
	$mw_recently_max_per_arr = $multiplier_wise_per_dtls["recently_max_per"];
	
	$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
	foreach($multiplier_elements_list as $me_row)
	{
		$rating_val_arr = $mw_rating_arr[$me_row["id"]];
		$mkt_elem_arr = $mw_mkt_elem_arr[$me_row["id"]];
		$crr_percent_values_arr = $mw_crr_arr[$me_row["id"]];
		$max_hike_arr = $mw_max_per_arr[$me_row["id"]];
		$recently_promoted_max_salary_arr = $mw_recently_max_per_arr[$me_row["id"]];
		
		?>
		<div class="row">
		  <div class="col-sm-12">
			<div class="rule-form mar10">
			  <div class="form_head pad_rt_0 clearfix">
				<div class="col-sm-12">
				  <ul>
					<li>
					  <div class="form_tittle">
						<h4><?php echo $lbl_prefix.$me_row["name"]; ?> Salary Review Grid</h4>
					  </div>
					</li>
				  </ul>
				</div>
			  </div>
			  <div class="form_sec clearfix forth">
               <div class="table-normal-scll">
				<table class="table salary-revw-grid table-bordered th-top-aln  <?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?> disa_input <?php } ?>">
				  <thead>
					<tr>
					  <?php if($rating_list){?>
					  <th rowspan="2">Rating (Population Distribution)</th>
					  <th rowspan="2" style="min-width:68px;">Merit <br>
						Increase </th>
					  <?php }else{ ?>
					  <th rowspan="2" style="min-width:68px;">Base Increase</th>
					  <?php } ?>
					  <th colspan="<?php $colspn_cnt = 2; if($rule_dtls['salary_position_based_on'] == "2"){$colspn_cnt = 1;}echo count($crr_arr)+$colspn_cnt; ?>">Proposed Salary Correction %age <span style="color:#FF6600;">(Total Proposed Salary %age)</span></th>
					  <th rowspan="2">Overall Max Increase</th>
					  <th rowspan="2">Max Increase For<br />
						Recently Promoted Cases</th>
					</tr>
					<tr>
					  <th style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> " >Target Position in pay range </th>
					  <?php $i=0; 
											
							$tag = "";
							if($rule_dtls['salary_position_based_on'] != "2")
							{
								$tag = "CR";
							}
							foreach($crr_arr as $row)
							{  
								if($i==0)
								{
									echo "<th style='width:13%;'> &nbsp; < ".$row["max"]." ".$tag."</th>";
								}                                
								else
								{
									echo "<th style='width:13%;'>".$row["min"]." To < ".$row["max"]." ".$tag."</th>";
								}
								
								if(($i+1)==count($crr_arr))
								{
									echo "<th style='width:13%;'> &nbsp; > ".$row["max"]." ".$tag."</th>";
								}                            
								$i++;
							} ?>
					</tr>
				  </thead>
				  <tbody>
					<?php			
						$j=0; 
						if($rating_list)
						{
							foreach($rating_list as $row)
							{ ?>
								<tr>
									<td>
										<?php echo $row['value']; ?>
									</td>
									<td>
										<div style="position: relative; display: inline;">
											<input type="text" class="form-control txt_color" required onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $row['id']; ?>);" maxlength="5" value="<?php echo HLP_get_formated_percentage_common($rating_val_arr[$row['id'].CV_CONCATENATE_SYNTAX.$row['value']]); ?>" style="text-align:center;" id="txt_rating_<?php echo $me_row["id"]."_".$row['id']; ?>" name="txt_rating_<?php echo $me_row["id"]; ?>[]"/>
											<span></span>
										</div>
									</td>
									<td style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> ">
										<select class="form-control txt_color opt" required name="ddl_market_element_<?php echo $me_row["id"]; ?>[]">
											<?php 
											if($market_salary_elements_list)
											{
												foreach ($market_salary_elements_list as $mkt_items)
												{?>
													<option value="<?php echo $mkt_items["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$mkt_items['ba_name']; ?>" <?php if($mkt_elem_arr[$row['id'].CV_CONCATENATE_SYNTAX.$row['value']] == $mkt_items["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$mkt_items['ba_name']){echo 'selected="selected"'; }?>><?php echo $mkt_items["display_name"]; ?></option>
											<?php }
											} ?>
										</select>
									</td>
									<?php 
									$i = 0;
									$rating_val_for_txt=$rating_val_arr[$row['id'].CV_CONCATENATE_SYNTAX.$row['value']];
									foreach($crr_arr as $crr_row)
									{ ?>
										<td style="width:13%;">
											<div style="position: relative; display: inline;">
												<input type="text" class="form-control spl_box txt_color" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $row['id']; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;" id="txt_crr_per_<?php echo $me_row["id"]."_".$row['id']."_".$i; ?>" name="txt_crr_per_<?php echo $me_row["id"]."_".$i; ?>[]">
												<span></span>
											</div>
											<div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $me_row["id"]."_".$row['id']."_".$i; ?>">
												(<?php if(isset($crr_percent_values_arr[$i][$j]))
														{
															echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));
														}
														elseif($rating_val_for_txt)
														{
															echo HLP_get_formated_percentage_common($rating_val_for_txt);
														}
														else
														{
															echo "0.00";
														} ?>%) 
											</div>
										</td> <?php $i++; 
									} ?>
									<!--Note :: Added below <td> to manage more than value of last max range-->
									<td style="width:13%;">
										<div style="position: relative; display: inline;">
											<input type="text" class="form-control max_crr_box txt_color" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $row['id']; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;" id="txt_crr_per_<?php echo $me_row["id"]."_".$row['id']."_".$i; ?>" name="txt_crr_per_<?php echo $me_row["id"]."_".$i; ?>[]">
											<span></span> 
										</div>
										<div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $me_row["id"]."_".$row['id']."_".$i; ?>">
											(<?php 
											if(isset($crr_percent_values_arr[$i][$j]))
											{
												echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));
											}
											elseif($rating_val_for_txt)
											{
												echo HLP_get_formated_percentage_common($rating_val_for_txt);
											}
											else
											{
												echo "0.00";
											} ?>%) 
										</div>
									</td>
									<td>
										<div style="position: relative; display: inline;">
											<input type="text" class="form-control txt_color" required="required" value="<?php echo HLP_get_formated_percentage_common($max_hike_arr[$j]); ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $row['id']; ?>);" style="text-align:center;" id="txt_max_hike_<?php echo $me_row["id"]."_".$row['id']; ?>" name="txt_max_hike_<?php echo $me_row["id"]; ?>[]" />
											<span></span> 
										</div>
									</td>
									<td>
										<div style="position: relative; display: inline;">
											<input type="text" class="form-control txt_color" value="<?php echo HLP_get_formated_percentage_common($recently_promoted_max_salary_arr[$j]); ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;" id="txt_recently_promoted_max_hike_<?php echo $me_row["id"]."_".$row['id']; ?>" name="txt_recently_promoted_max_hike_<?php echo $me_row["id"]; ?>[]" />
											<span></span> 
										</div>
									</td>
								</tr>
						<?php   $j++;
							}
						}
						else
						{ ?>
							<tr>
								<!--<td>                    
									Based Hike
								</td>-->
								<td>        
									<input type="text" class="form-control txt_color" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" value="<?php echo HLP_get_formated_percentage_common($rating_val_arr["all"]); ?>" required="required" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $j; ?>);" style="text-align:center;" id="txt_rating_<?php echo $me_row["id"]."_".$j; ?>" name="txt_rating_<?php echo $me_row["id"]; ?>">
								</td>
								<td style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> ">
									<select class="form-control txt_color" name="ddl_market_element_<?php echo $me_row["id"]; ?>[]">
									<?php 	if($market_salary_elements_list)
											{
												foreach ($market_salary_elements_list as $mkt_items)
												{?>
													<option value="<?php echo $mkt_items["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$mkt_items['ba_name']; ?>" <?php if($mkt_elem_arr["all"] == $mkt_items["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$mkt_items['ba_name']){echo 'selected="selected"'; }?>><?php echo $mkt_items["display_name"]; ?></option>
											<?php }
											} ?>
									</select>						
								</td>
								<?php 
								$i = 0;
								$rating_val_for_txt = $rating_val_arr["all"];
								foreach($crr_arr as $crr_row)
								{ ?>                		
									<td>
										<input type="text" class="form-control txt_color" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $j; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;" id="txt_crr_per_<?php echo $me_row["id"]."_".$j."_".$i; ?>" name="txt_crr_per_<?php echo $me_row["id"]."_".$i; ?>[]">
										<div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $me_row["id"]."_".$j."_".$i; ?>">
											(<?php 
												if(isset($crr_percent_values_arr[$i][$j]))
												{
													echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));
												}
												elseif($rating_val_for_txt)
												{
													echo HLP_get_formated_percentage_common($rating_val_for_txt);
												}
												else
												{
													echo "0.00";
												} ?>%)
										</div>
									</td>      
								<?php $i++; 
								} ?>
							
								<!--Note :: Added below <td> to manage more than value of last max range-->
								<td>
									<input type="text" class="form-control txt_color" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $j; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;" id="txt_crr_per_<?php echo $me_row["id"]."_".$j."_".$i; ?>" name="txt_crr_per_<?php echo $me_row["id"]."_".$i; ?>[]">
									<div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $me_row["id"]."_".$j."_".$i; ?>">
										(<?php 
										if(isset($crr_percent_values_arr[$i][$j]))
										{
											echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));
										}
										elseif($rating_val_for_txt)
										{
											echo HLP_get_formated_percentage_common($rating_val_for_txt);
										}
										else
										{
											echo "0.00";
										} ?>%)
									</div>							
								</td> 
								
								<td>
									<input type="text" class="form-control txt_color" required="required" value="<?php echo HLP_get_formated_percentage_common($max_hike_arr[$j]); ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike_mw(<?php echo $me_row["id"]; ?>, <?php echo $j; ?>);" style="text-align:center;" id="txt_max_hike_<?php echo $me_row["id"]."_".$j; ?>" name="txt_max_hike_<?php echo $me_row["id"]; ?>[]">
								</td> 
								<td>
									<input type="text" class="form-control txt_color" value="<?php echo HLP_get_formated_percentage_common($recently_promoted_max_salary_arr[$j]); ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;" id="txt_recently_promoted_max_hike_<?php echo $me_row["id"]."_".$j; ?>" name="txt_recently_promoted_max_hike_<?php echo $me_row["id"]; ?>[]">
								</td> 
							</tr>                    
						<?php 
						} ?>
				  </tbody>
				</table>
				</div>			
			  </div>
			</div>
		  </div>
		</div>
<?php 
	} ?>
	
<?php if(!isset($is_show_on_manager)){?>
		<div class="row">
			<div class="col-sm-12 text-right">
				<div class="row">
				<input class="btn-w120" type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
				<input class="btn-w120" type="submit" id="btnAdd_3rd" value="" style="display:none" />				
				<div class="col-sm-12 mob-center">
					<input  type="button" id="btn_next" value="Back" class="mar_l_5 btn btn-success btn-w130"  onclick="show_2nd_step_form();"/>	
					
					<input type="button" value="<?php if($rule_dtls['manual_budget_dtls']){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn btn-success mar_l_5 btn-w120" onclick="submit_frm3('0');" />

					 <?php if($rule_dtls['manual_budget_dtls']){?>
							<input type="button" value="Next Step" class="btn btn-success mar_l_5 btn-w120"  onclick="submit_frm3('1');"/>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>		
	</form>	
<?php } ?>


<script>
function show_2nd_step_form()
{
	$("#loading").show();
	$.get("<?php echo site_url("rules/get_salary_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
	{
		if(data)
		{
			$("#loading").css('display','none');
			//$("#dv_frm_1_btn").html('');
			//$("#dv_partial_page_data").html('');
			$("#dv_partial_page_data_2").html(data);
		}
		else
		{
			$("#loading").css('display','none');
			window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
		}
	}); 
}
function submit_frm3(is_next_step)
{
	$("#hf_show_next_step").val(is_next_step);
	$("#btnAdd_3rd" ).trigger( "click" );
}

function validate_max_hike_mw(mw_elem_id, rating_id)
{ 
	var loop_cnt = <?php echo $i; ?>;
	var max_hike_val = ($("#txt_max_hike_"+mw_elem_id+"_"+rating_id).val())*1;
	var rating_val = ($("#txt_rating_"+mw_elem_id+"_"+rating_id).val())*1;//alert(rating_val);alert(max_hike_val);
	var max_range_val = 0;
	if($("#txt_max_hike_"+mw_elem_id+"_"+rating_id).val() == '')
	{
		$("#txt_max_hike_"+mw_elem_id+"_"+rating_id).val('');
		calculate_tot_crr_column_wise_mw(mw_elem_id, rating_id, loop_cnt);
		return;
	}
	calculate_tot_crr_column_wise_mw(mw_elem_id, rating_id, loop_cnt);
	for(var i=0; i<=loop_cnt; i++)
	{
		var crr_range_val = ($("#txt_crr_per_"+mw_elem_id+"_"+rating_id+"_"+i).val())*1;
		if(crr_range_val > max_range_val)
		{
			max_range_val = crr_range_val;
		}		
	}
	var max_hike_upto = roundToTwo(rating_val + max_range_val);
	if(max_hike_val < max_hike_upto)
	{
		$("#txt_max_hike_"+mw_elem_id+"_"+rating_id).val('');
		if(max_hike_val != 0 && max_hike_upto > 0)
		{
			custom_alert_popup("Max hike should be greater than or equal to "+max_hike_upto);
		}
		return;
	}
	
	var max_hike_val_recently_promoted = ($("#txt_recently_promoted_max_hike_"+mw_elem_id+"_"+rating_id).val())*1;
	if($("#txt_recently_promoted_max_hike_"+mw_elem_id+"_"+rating_id).val() == '')
	{
		$("#txt_recently_promoted_max_hike_"+mw_elem_id+"_"+rating_id).val('');
		return;
	}
}

function calculate_tot_crr_column_wise_mw(mw_elem_id, rating_id, loop_cnt)
{
	var rating_val = ($("#txt_rating_"+mw_elem_id+"_"+rating_id).val())*1;
	for(var i=0; i<=loop_cnt; i++)
	{
		var crr_range_val1 = ($("#txt_crr_per_"+mw_elem_id+"_"+rating_id+"_"+i).val())*1;
		$("#dv_perf_plus_crr_rating_"+mw_elem_id+"_"+rating_id+"_"+i).html("("+roundToTwo(rating_val + crr_range_val1)+"%)");	
	}
}
</script>