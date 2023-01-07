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

.form_sec .salary-revw-grid tbody tr td input.spl_box{position: relative !important; padding-right:15px !important;}
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
</style>
<?php if(!isset($is_show_on_manager)){?>
<form id="frm_rule_step2" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("rules/set_rules/".$rule_dtls['id']."/2"); ?>">
<?php echo HLP_get_crsf_field();
 }
 $tooltip=getToolTip('salary-rule-page-3');$val=json_decode($tooltip[0]->step);
?>
	
    <div class="row">
        <div class="col-sm-12">
            <div class="rule-form mar10">
            <?php if(!isset($is_show_on_manager)){?>
                <div class="form_head pad_rt_0 clearfix">
                        <div class="col-sm-12">
                        <ul>
                        <li>
                          <div class="form_tittle">
                            <h4>Standard Salary Review Grid</h4>
                          </div>
                          </li>
                        <li>
                          <div class="form_info">
                            <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom"  title="<?php echo $val[0]?$val[0]:'Define your proposed performance/merit based salary increases as well as proposed correction increase for this compensation plan.' ?>" ><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                          </div>
                          </li>
						  <li class="color-detail preinc pull-right">
                            <div class="color_info">
                              <span style="margin-right: 5px; width: 70px; height: 17.5px; display: inline-block; padding: 1px 20px; background-color: #FF6600;"></span><span> Total Proposed Salary %age</span>
                            </div>
                          </li>
                           <?php /*?><li class="color-detail preinc pull-right hide_pre_post_population">
                            <div class="color_info">
                              <span class="c_grn"></span><span> Pre increase population distribution</span>
                            </div>
                            <div class="color_info">
                              <span class="c_blue"></span><span> Post increase population distribution</span>
                            </div>
                          </li><?php */?>						  
                         </ul>
                        </div>
                      </div>
            <?php } 
             $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
            ?>
            <div class="form_sec clearfix forth <?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>input-pointer-disable<?php } ?>">  
           <div class="table-normal-scll">     
            <table class="table salary-revw-grid table-bordered th-top-aln">
                <thead>
                    <tr>
                    	<?php if($rating_list){?>
                        <th rowspan="2">Rating (Population Distribution)</th>
                        <th rowspan="2" style="min-width:68px;">Merit <br>Increase <!-- Performance Based<br />Increase --> <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[1] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span><?php */?></th>
                        <?php }else{ ?>

                        <th rowspan="2" style="min-width:68px;">Base Increase <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[1] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span><?php */?></th>
                        <?php } ?>
						
                        <th colspan="<?php $colspn_cnt = 2; if($rule_dtls['salary_position_based_on'] == "2"){$colspn_cnt = 1;}echo count($crr_arr)+$colspn_cnt; ?>">Proposed Salary Correction %age <span style="color:#FF6600;">(Total Proposed Salary %age)</span></th>
						
                        
                        <th rowspan="2">Overall Max Increase <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[3] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span><?php */?></th>
                        <th rowspan="2">Max Increase For<br />Recently Promoted Cases <?php /*?><span  class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[4] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span><?php */?></th>
                        <input type="hidden" value="<?php echo count($crr_arr); ?>" name="hf_crr_counts" />
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
                    $crr_percent_values_arr = json_decode($rule_dtls["crr_percent_values"],true);
                    $max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"],true);
                    $recently_promoted_max_salary_arr = json_decode($rule_dtls["if_recently_promoted"],true);
					$rating_val_arr = json_decode($rule_dtls["performnace_based_hike_ratings"],true);					
					$ddl_mkt_salary_str = '';
					if($market_salary_elements_list)
					{
						foreach ($market_salary_elements_list as $mkt_items)
						{
							$ddl_mkt_salary_str .= '<option value="'.$mkt_items["business_attribute_id"].''.CV_CONCATENATE_SYNTAX.''.$mkt_items['ba_name'].'">'.$mkt_items["display_name"].'</option>';
						}
					}

                    $j=0; 
					if($rating_list)
					{
                    foreach($rating_list as $row)
                    { ?>
                    <tr>
                        <td>                 
                            <?php echo $row['value']; ?>    
                            <div class="perf_inc_hk">
								<?php echo HLP_get_formated_percentage_common(($row['rating_wise_total_emps']/$total_emps_cnt)*100) ?>%
                            </div>                    
                            <input type="hidden" id="hf_rating_val_<?php echo $j; ?>" value="<?php echo $row['id']; ?>" />
                        </td>
                        <td>                    
                            <div style="position: relative; display: inline;">
								<input type="text" id="txt_ratings_<?php echo $j; ?>" name="txt_ratings[]" class="form-control txt_color" required onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike(<?php echo $j; ?>);" maxlength="5" value="<?php echo HLP_get_formated_percentage_common($rating_val_arr[$row['id'].CV_CONCATENATE_SYNTAX.$row['value']]); ?>" style="text-align:center;" /><span></span></div>
                            <input type="hidden" id="<?php echo $row['id']; ?>" value="<?php echo $row['id'].CV_CONCATENATE_SYNTAX.$row['value']; ?>" name="hf_rating_name[]" />                            
                        </td>
                        <td style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> ">
                        <select class="form-control txt_color opt" id="ddl_market_salary_comparative_ratio_<?php echo $j; ?>" name="ddl_market_salary_comparative_ratio[]" required onchange="get_emp_perc_crr_range_wise(<?php echo $j; ?>);">
                        <?php echo $ddl_mkt_salary_str; ?>
                        </select>
						<?php 
                       	 echo '<input type="hidden" id="'.$row['id'].'" value="'.$row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['value'].'" name="hf_comparative_ratio_name[]" />';
                        ?>
                        </td>
                        <?php 
                            $i = 0;
							$rating_val_for_txt = $rating_val_arr[$row['id'].CV_CONCATENATE_SYNTAX.$row['value']];
                            foreach($crr_arr as $row)
                            { 
                        ?>                		
                        <td style="width:13%;"><div style="position: relative; display: inline;"><input type="text" class="form-control spl_box txt_color" id="txt_range_val_<?php echo $j."_".$i; ?>" name="txt_range_val<?php echo $i; ?>[]" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike(<?php echo $j; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;"><span></span></div>
                        
                        <div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
                        	(<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));}elseif($rating_val_for_txt){echo HLP_get_formated_percentage_common($rating_val_for_txt);}else{echo "0.00";} ?>%)
                        </div>
                        
                        <div class="calu hide_pre_post_population">
                        <div class="crr_per secnd green " id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
                        
                        <?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
                            
                        	<div class="crr_per third blue"id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
                        <?php } ?>
                        </div>
                        </td>      
                        <?php 
                            $i++; 
                            } 
                        ?>
                        
                        <!--Note :: Added below <td> to manage more than value of last max range-->
                        <td style="width:13%;"><div style="position: relative; display: inline;">
						<input type="text" class="form-control max_crr_box txt_color" id="txt_range_val_<?php echo $j."_".$i; ?>" name="txt_range_val<?php echo $i; ?>[]" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike(<?php echo $j; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;"><span></span></div>
                        
                        <div class="crr_per first " id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
                        	(<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));}elseif($rating_val_for_txt){echo HLP_get_formated_percentage_common($rating_val_for_txt);}else{echo "0.00";} ?>%)
                        </div>
                        <div class="calu hide_pre_post_population">
                        <div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
                        
                        <?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
                           
                        	<div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
                        <?php } ?>
                        </div>
                        </td> 
                        
                        <td><div style="position: relative; display: inline;"><input type="text" class="form-control txt_color" name="txt_max_hike[]" required="required" value="<?php echo HLP_get_formated_percentage_common($max_hike_arr[$j]); ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" id="txt_max_hike_<?php echo $j; ?>" onchange="validate_max_hike(<?php echo $j; ?>);" style="text-align:center;"><span></span></div></td> 
                        <td>
                        <div style="position: relative; display: inline;"><input type="text" class="form-control txt_color" name="txt_recently_promoted_max_salary_increase[]" id="txt_recently_promoted_max_salary_increase_<?php echo $j; ?>" value="<?php echo HLP_get_formated_percentage_common($recently_promoted_max_salary_arr[$j]); ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;"><span></span></div>
                        </td> 
                    </tr>
                <?php $j++;}
					}
					else
					{?>
                    <tr>
                        <!--<td>                    
                            Based Hike
                        </td>-->
                        <td>        
                        	<input type="text" class="form-control txt_color" id="txt_ratings_<?php echo $j; ?>" name="txt_rating1" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" value="<?php echo HLP_get_formated_percentage_common($rating_val_arr["all"]); ?>" required="required" onchange="validate_max_hike(<?php echo $j; ?>);" style="text-align:center;">
                        </td>
                        <td style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> ">
                        <select class="form-control txt_color" name="ddl_comparative_ratio1" id="ddl_comparative_ratio1" required onchange="get_emp_perc_crr_range_wise(<?php echo $j; ?>);">
                        <?php echo $ddl_mkt_salary_str;  ?>
                        </select>						
                        </td>
                        <?php 
                            $i = 0;
							$rating_val_for_txt = $rating_val_arr["all"];
                            foreach($crr_arr as $row)
                            { 
                        ?>                		
                        <td><input type="text" class="form-control txt_color" id="txt_range_val_<?php echo $j."_".$i; ?>" name="txt_range_val<?php echo $i; ?>[]" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike(<?php echo $j; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;">
                        
                        	<div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
								(<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));}elseif($rating_val_for_txt){echo HLP_get_formated_percentage_common($rating_val_for_txt);}else{echo "0.00";} ?>%)
                            </div>
                            <div class="calu hide_pre_post_population">
                            	<div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
								<?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
                                   
                                    <div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
                                <?php } ?>
                            </div>
                        </td>      
                        <?php 
                            $i++; 
                            } 
                        ?>
                        
                        <!--Note :: Added below <td> to manage more than value of last max range-->
                        <td><input type="text" class="form-control txt_color" id="txt_range_val_<?php echo $j."_".$i; ?>" name="txt_range_val<?php echo $i; ?>[]" value="<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common($crr_percent_values_arr[$i][$j]);} ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike(<?php echo $j; ?>);" style="float:left; width:47%; margin-bottom:3px; text-align:center;">
                        
                        <div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
                        	(<?php if(isset($crr_percent_values_arr[$i][$j])){echo HLP_get_formated_percentage_common(($rating_val_for_txt + $crr_percent_values_arr[$i][$j]));}elseif($rating_val_for_txt){echo HLP_get_formated_percentage_common($rating_val_for_txt);}else{echo "0.00";} ?>%)
                        </div>
                        <div class="calu hide_pre_post_population">
                        <div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
                        <?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
                            
                        	<div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
                        <?php } ?>
                        </div>
                        </td> 
                        
                        <td><input type="text" class="form-control txt_color" name="txt_max_hike[]" id="txt_max_hike_<?php echo $j; ?>" required="required" value="<?php echo HLP_get_formated_percentage_common($max_hike_arr[$j]); ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" onchange="validate_max_hike(<?php echo $j; ?>);" style="text-align:center;"></td> 
                        <td>
                        <input type="text" class="form-control txt_color" name="txt_recently_promoted_max_salary_increase[]" id="txt_recently_promoted_max_salary_increase_<?php echo $j; ?>" value="<?php echo HLP_get_formated_percentage_common($recently_promoted_max_salary_arr[$j]); ?>" required="required" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" style="text-align:center;" ></td> 
                    </tr>                    
                    <?php } ?>
            </tbody>
        </table>
      </div>
			
			<div style="margin-top:10px;">
				<div class="col-sm-6 removed_padding">
					<label class="control-label">Apply multiplier to differentiate your standard salary review grid<span style="margin-left: 10px;" class="tooltipcls myTip" data-toggle="tooltip control-label" data-placement="top" title="This options allows you to differentiate your salary increase grid by country, grade/band or level. By selecting the option between these three choices, system will ask to put multipliers for each country or grade or level and apply those multiplies on the standard grid and use it for your increment and budget simulation automatically. Eg if you choose grade and for grade -1 enter 80, in the relevant field below, it will use 80% of thr standard grid as recommended increase for employee in grade-1." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
				</div>
				<div class="col-sm-6 pad_r0" >
					<select class="form-control" id="ddl_hike_multiplier_basis_on" name="ddl_hike_multiplier_basis_on" onchange="get_multipliers_list();">
						<option value="">Select</option>
						<option <?php if($rule_dtls["hike_multiplier_basis_on"]=="1"){ echo 'selected'; } ?> value="1">Country</option>
						<option <?php if($rule_dtls["hike_multiplier_basis_on"]=="2"){ echo 'selected'; } ?> value="2">Grade</option>
						<option <?php if($rule_dtls["hike_multiplier_basis_on"]=="3"){ echo 'selected'; } ?> value="3">Level</option>
					</select>
				</div>
				<div id="dv_multipliers_list"></div>
			</div>
          </div>		  
         </div>
        </div>
    </div>    
	
<?php if(isset($is_show_on_manager) and $rule_dtls['hike_multiplier_basis_on']>0){?>
	<?php $this->load->view('salary/increment_grid_after_multiplier'); ?>
<?php } ?>
    
<?php if(!isset($is_show_on_manager)){?>
	<div class="row">
        <div class="col-sm-12 text-right">
        <div class="row">
        <input class="btn-w120" type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
        <input class="btn-w120" type="submit" id="btnAdd_2nd" value="" style="display:none" />
        
        <div class="col-sm-12 mob-center">
            	<a class="btn btn-success mar_l_5 btn-w120" href="">Back</a>
     

            <input type="button" id="btn_edit_next" value="<?php if($rule_dtls['multiplier_wise_per_dtls']){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn btn-success mar_l_5 btn-w120" onclick="submit_frm2('0');" />

         <?php if($rule_dtls['multiplier_wise_per_dtls']){?>
                <input type="button" id="btn_next" value="Next Step" class="btn btn-success mar_l_5 btn-w120"  onclick="submit_frm2('1');"/>
    	<?php } ?>
            </div>
        </div>
        </div>
        </div>
		
</form>

<?php } ?>

<script>
function get_multipliers_list()
{
	var multiplier_val = $("#ddl_hike_multiplier_basis_on").val();
	$("#dv_multipliers_list").html("");
	if(multiplier_val)
	{
		$.get("<?php echo site_url("rules/get_multipliers_list/".$rule_dtls['id']);?>/"+multiplier_val, function(data)
		{
			$("#dv_multipliers_list").html(data);
		});
	}
}
get_multipliers_list();

function submit_frm2(is_next_step)
{
	$("#hf_show_next_step").val(is_next_step);
	$("#btnAdd_2nd" ).trigger( "click" );
}

var json_elem_arr = '<?php echo $rule_dtls["comparative_ratio_calculations"]; ?>';
var default_market_benchmark_val = '<?php echo $rule_dtls["default_market_benchmark"]; ?>';
var i = 0;
var items = [];
if(json_elem_arr)
{
	$.each(JSON.parse(json_elem_arr),function(key,vall){
		items.push(vall);
	});
	
	$("select[name='ddl_market_salary_comparative_ratio[]']").each( function (key, v)
	{
		$(this).val(items[i]);
		i++;    
	});
}  
else if(default_market_benchmark_val)
{
	items.push(default_market_benchmark_val);
	$("select[name='ddl_market_salary_comparative_ratio[]']").each( function (key, v)
	{
		$(this).val(default_market_benchmark_val);
	});
}

<?php if($rule_dtls["performnace_based_hike"]=="no"){ ?>
	if(json_elem_arr)
	{
		$("#ddl_comparative_ratio1").val(items[i]);
	}
	else if(default_market_benchmark_val)
	{
		$("#ddl_comparative_ratio1").val(default_market_benchmark_val);
	}
<?php } ?>

function validate_max_hike(obj_id_no)
{ //return; // CB:: Ravi on 22-12-17 because client want here flexiblity, no need any check here
	var loop_cnt = <?php echo $i; ?>;
	var max_hike_val = ($("#txt_max_hike_"+obj_id_no).val())*1;
	var rating_val = ($("#txt_ratings_"+obj_id_no).val())*1;
	var max_range_val = 0;
	if($("#txt_max_hike_"+obj_id_no).val() == '')
	{
		$("#txt_max_hike_"+obj_id_no).val('');
		calculate_tot_crr_column_wise(obj_id_no, loop_cnt);
		return;
	}
	calculate_tot_crr_column_wise(obj_id_no, loop_cnt);
	for(var i=0; i<=loop_cnt; i++)
	{
		var crr_range_val = ($("#txt_range_val_"+obj_id_no+"_"+i).val())*1;
		if(crr_range_val > max_range_val)
		{
			max_range_val = crr_range_val;
		}		
	}
	var max_hike_upto = roundToTwo(rating_val + max_range_val);
	if(max_hike_val < max_hike_upto)
	{
		$("#txt_max_hike_"+obj_id_no).val('');
		if(max_hike_val != 0 && max_hike_upto > 0)
		{
			custom_alert_popup("Max hike should be greater than or equal to "+max_hike_upto);
		}
		return;
	}
	
	var max_hike_val_recently_promoted = ($("#txt_recently_promoted_max_salary_increase_"+obj_id_no).val())*1;
	if($("#txt_recently_promoted_max_salary_increase_"+obj_id_no).val() == '')
	{
		$("#txt_recently_promoted_max_salary_increase_"+obj_id_no).val('');
		return;
	}
	
	<?php /*?>var max_hike_upto = rating_val + max_range_val;
	if(max_hike_val_recently_promoted < max_hike_upto)
	{
		$("#txt_recently_promoted_max_salary_increase_"+obj_id_no).val('');
		alert("Recently promoted max salary increase should be greater than or equal to "+max_hike_upto);
		return;
	}<?php */?>
}


function calculate_tot_crr_column_wise(obj_id_no, loop_cnt)
{
	var rating_val = ($("#txt_ratings_"+obj_id_no).val())*1;
	for(var i=0; i<=loop_cnt; i++)
	{
		var crr_range_val1 = ($("#txt_range_val_"+obj_id_no+"_"+i).val())*1;
		$("#dv_perf_plus_crr_rating_"+obj_id_no+"_"+i).html("("+roundToTwo(rating_val + crr_range_val1)+"%)");	
	}
}

for(var i=0; i<<?php echo $j; ?>; i++)
{
	get_emp_perc_crr_range_wise(i,1);	
}
<?php if($j===0){ ?>
	get_emp_perc_crr_range_wise(0);	
<?php } ?>

var total_pre_population = 0;
var total_post_population = 0;
var total_emps_in_rule = <?php echo $total_emps_cnt; ?>;
function get_emp_perc_crr_range_wise(obj_id_no, is_loop_call=0)//is_loop_call=1 Means called this func from loop
{return;//Stopped Calculation of Pre & Post Population Distributions
	var loop_cnt = <?php echo $i; ?>;
	var rule_id = <?php echo $rule_dtls['id']; ?>;
	var rating_val = $("#hf_rating_val_"+obj_id_no).val();	
	var increment_percet = ($("#txt_ratings_"+obj_id_no).val())*1;
	var mkt_sal_val = $("#ddl_market_salary_comparative_ratio_"+obj_id_no).val();
	<?php if($j===0){ ?>
		var mkt_sal_val = $("#ddl_comparative_ratio1").val();
	<?php } ?>
	
	/*if(increment_percet <=0)
	{
		for(var i=0; i<=loop_cnt; i++)
		{
			$("#dv_emp_perc_crr_wise_"+obj_id_no+"_"+i).html("0%");	
		}
		return;
	}*/
	$("#rpt_loading").show();	
	
	$.post("<?php echo site_url("rules/get_emp_perc_crr_range_wise");?>",{rule_id:rule_id, rating_val:rating_val,increment_percet:increment_percet, mkt_sal_val:mkt_sal_val}, function(data)
    {
		if(data)
		{			
			var emp_perc_crr_range_wise = JSON.parse(data);
			total_pre_population += emp_perc_crr_range_wise[2];
			total_post_population += emp_perc_crr_range_wise[3];
			for(var i=0; i<=loop_cnt; i++)
			{
				$("#dv_emp_perc_crr_wise_"+obj_id_no+"_"+i).html(emp_perc_crr_range_wise[0][i]);
				<?php if(isset($is_show_on_manager) and $is_show_on_manager==1){?>
					$("#dv_emp_perc_updated_crr_wise_"+obj_id_no+"_"+i).html(emp_perc_crr_range_wise[1][i]);
				<?php } ?>
			}			
		}		
    })
	.always(function() 
	{
		var total_grid_rows = <?php echo $j-1; ?>;
		<?php if($j===0){ ?> total_grid_rows = 0; <?php } ?>
		if(is_loop_call == 1)
		{
			if(total_grid_rows == obj_id_no)
			{
				setTimeout(function(){
				
					var spn_improvement_avg_crr = (total_post_population - total_pre_population) / total_emps_in_rule;
					$("#spn_improvement_pre_avg_crr").html(get_formated_percentage_common(total_pre_population/total_emps_in_rule) +"%");
					$("#spn_improvement_post_avg_crr").html(get_formated_percentage_common(total_post_population/total_emps_in_rule) +"%");
					$("#spn_improvement_avg_crr").html(get_formated_percentage_common(spn_improvement_avg_crr) +"%");
					
					$("#hf_improvement_pre_avg_crr").val(get_formated_percentage_common(total_pre_population/total_emps_in_rule));
					$("#hf_improvement_post_avg_crr").val(get_formated_percentage_common(total_post_population/total_emps_in_rule));
					$("#hf_improvement_avg_crr").val(get_formated_percentage_common(spn_improvement_avg_crr));
					
					$("#rpt_loading").hide(); 
				 
				 }, 4000);
			}
		}
		else
		{
			setTimeout(function(){ $("#rpt_loading").hide(); }, 3000);
		}
	});
}
$('form').attr( "autocomplete", "off" );

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function(){
  $('.myTip').tooltip()
});
</script>

 




            