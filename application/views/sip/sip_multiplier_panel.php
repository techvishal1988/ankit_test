<div class="row">
  <div class="col-md-12">
    <div class="mb20">
      <div class="">
        <div class="">
          <div class="rule-form">
            <form id="frm_rule_step2"  method="post" action="<?php echo site_url('save-sip/'.$rule_dtls['id'].'/2'); ?>" onsubmit="return set_rules(this);" enctype="multipart/form-data">
              <?php echo HLP_get_crsf_field();?>
              <div class="form-group">
                <div class="row">
				
                  <div class="col-sm-12">
				  <?php if($rule_dtls["performance_achievements_multiplier_type"] != 3){ ?>
                    <div class="form_head clearfix">
                      <div class="col-sm-12">
                        <ul>
                          <li>
                            <div class="form_tittle">
                              <h4>Define Performance Ranges & Multiplier</h4>
                            </div>
                          </li>
                          <li>
                            <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $rule_val[5] ?>"><i style="font-size:20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="form_sec sip_frm clearfix">
					  <?php  $multiplier_arr_dtls = json_decode($rule_dtls["multiplier_dtls"], true);
					  foreach($multiplier_arr_dtls as $m_row){?>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <div class="row">
                            <div style="padding-left: 15px !important; width:35%" class="col-sm-5 removed_padding pl15">
                              <label class="control-label">Define Ranges & Multipliers For <?php echo $m_row["value"]; ?> Performance</label>
                            </div>
                            <div class="col-sm-7" style="width:65%">
                              <div class="table-responsive">
                                <table class="table table_p table-bordered th-top-aln" id="tbl_multiplier_performance_range">
                                  <thead>
                                    <tr>
                                      <th colspan="2">Performance Ranges ( in %)</th>
                                      <th rowspan="2">Define
                                        <?php if($rule_dtls["performance_achievements_multiplier_type"]==2){echo "Accelerators/Decelerators";}else{ echo " Multipliers (In %)"; } ?></th>
										<?php if(!isset($is_loaded_from_summary_page)){?>	
                                      <th colspan="2" rowspan="2"><button type="button" class="btn btn-primary btn-w94" onclick="addPerformanceRange(this, '<?php echo $m_row["key"]; ?>');">ADD RANGE </button></th>
									  <?php } ?>
                                    </tr>
                                    <tr>
                                      <th>More Than or Equal To</th>
                                      <th>Less than</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
						$i=0;
						$rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"],true);
						if($rangs_arr[$m_row["key"]])
						{
							foreach($rangs_arr[$m_row["key"]] as $key => $row)
							{ ?>
                                    <tr>
                                      <td class="weblik-cen2"><input class="form-control performance-ranges" type="text" name=" txt_perfo_achiev_min_<?php echo $m_row["key"]; ?>[]" required value="<?php echo $row['min']; ?>" disabled ></td>
                                      <td class="weblik-cen2"><input class="form-control  performance-ranges" type="text" name="txt_perfo_achiev_max_<?php echo $m_row["key"]; ?>[]" onchange="performance_max_range_change(this);"
												  value="<?php echo $row['max']; ?>" required maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"></td>
                                      <td class="weblik-cen2"><input class="form-control performance-ranges" type="text" name="txt_perfo_achiev_val_<?php echo $m_row["key"]; ?>[]" value="<?php echo $row['multiplier']; ?>" required maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"></td>
									  <?php if(!isset($is_loaded_from_summary_page)){?>
                                      <td class="weblik-cen2"><button type="button" class="btn btn-primary btn-w94" onclick="removePerformanceRange(this);">DELETE </button></td>
									  <?php } ?>
                                    </tr>
                      <?php }
						}
						else {  ?>
								<tr>
								  <td class="weblik-cen2">
									<input class="form-control  performance-ranges" type="text" name=" txt_perfo_achiev_min_<?php echo $m_row["key"]; ?>[]" value="0" disabled required></td>
								  <td class="weblik-cen2">
									<input class="form-control  performance-ranges" type="text" onchange="performance_max_range_change(this);" name="txt_perfo_achiev_max_<?php echo $m_row["key"]; ?>[]" value="" required maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"></td>
								  <td class="weblik-cen2">
									<input class="form-control  performance-ranges" type="text" name="txt_perfo_achiev_val_<?php echo $m_row["key"]; ?>[]" value="" required maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"></td>
								  <td class="weblik-cen2"><button type="button" class="btn btn-primary btn-w94" onclick="removePerformanceRange(this);">DELETE </button></td>
								</tr>
                        <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
					  <?php } ?>
                    </div>
				  <?php } ?>
				  
				  <div class="form_sec clearfix">
				  	<div class="col-sm-12">
					  <div class="form-group">
						<div class="col-sm-6 removed_padding">
						  <label class="control-label" style="font-size:12px !important;">No Incentive For All Factors If Individual Performance Is Below Minimum Of The Range</label>
						</div>
						<div class="col-sm-6 ">
						  <select class="form-control" name="ddl_individual_performance_below_check" required>
							<option value="1" <?php if($rule_dtls['individual_performance_below_check'] == '1'){ echo 'selected="selected"'; } ?>>No</option>
							<option value="2" <?php if($rule_dtls['individual_performance_below_check'] == '2'){ echo 'selected="selected"'; } ?> >Yes</option>							
						  </select>
						</div>
					  </div>
					</div>
					<div class="col-sm-12">
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">Define Overall Min & Max Payouts</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="row">                              
                              <div class="col-sm-6">
                                <input type="text" name="txt_min_payout" id="txt_min_payout" class="form-control" required="required" value="<?php if($rule_dtls['min_payout']>0){ echo $rule_dtls['min_payout']; } ?>" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);" />
                              </div>                              
                              <div class="col-sm-6">
                                <input name="txt_max_payout" type="text" class="form-control" required="required" value="<?php if($rule_dtls['max_payout']>0){ echo $rule_dtls['max_payout']; } ?>" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"/>
                              </div>
                            </div>
                          </div>
                        </div>
					<?php if(!isset($is_loaded_from_summary_page)){?>	
					<div class="col-sm-12">
					  <div class="form-group">
						<div class="col-sm-6 removed_padding">
						  <label class="control-label">Select File To Upload Actual Achievements</label>
						</div>
						<div class="col-sm-6" style="padding-right: -1px;">
						    <input style="width:70%; display: inline-block;" type="file" name="achievements_file" id="achievements_file" class="form-control" title="Choose a file csv to upload" accept="application/msexcel*" <?php if($rule_dtls['actual_achievement_file_path'] == ""){?>required<?php } ?>>
							<a style="vertical-align: top; margin-left: 5px; float: right;" class="downloadcsv" href="<?php echo site_url('sip/get_file_to_upload_achievements/'.$rule_dtls['id']); ?>">
								<input type="button" value="Download File Format" class="btn btn-success">
							</a>
						</div>
					  </div>
					</div>
					<?php } ?>
				  </div>
				  
                  </div>
				
				
				
                </div>
              </div>
			  <?php if(!isset($is_loaded_from_summary_page)){?>
              <div class="row" id="dv_action_step2">
                <input type="hidden" value="0" id="hf_show_next_step3" name="hf_show_next_step3" />
                <input type="submit" id="btnAdd_2nd" value="" style="display:none" />
                <div class="col-sm-12 text-right mob-center"> <a class="btn btn-success ml-mb" href="<?php echo site_url("create-sip-rule/".$rule_dtls["id"]); ?>">Back</a>
                  <input type="button" id="btn_edit_next" value="<?php if($rule_dtls['actual_achievement_file_path']){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn btn-success ml-mb" onclick="submit_step2_frm('0');" />
                  <?php if($rule_dtls['actual_achievement_file_path']){?>
                  <input  type="button" id="btn_next" value="Next Step" class="ml-mb btn btn-success"  onclick="submit_step2_frm('1');"/>
                </div>
                <?php } ?>
              </div>
			  <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
