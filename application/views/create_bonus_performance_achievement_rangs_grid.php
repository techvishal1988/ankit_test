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
.rule-form .form-control.opt {
	font-size: 12px !important;
}
.rule-form .control-label {
	font-size: 11.25px;
 background-color: #<?php echo $this->session->userdata("company_light_color_ses");
?>;
	margin-bottom:10px;
}
.rule-form .form-control:focus {
	box-shadow: none!important;
}
.rule-form .form_head {
	background-color: #f2f2f2;
 border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
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
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
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
th .tooltipcls {
	text-align: center !important;
	float: none !important;
}
th {
	text-align: left;
}

.rule-form table.table_p{}
.rule-form table.table_p thead tr th{text-align: left!important;}
.rule-form table.table_p .form-control{width: unset !important; margin-bottom:0px !important;}
</style>
<div class="mb20">
        <div class="panel-white">
          <div class="">
<div class="rule-form">
	<form id="frm_rule_step2" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("save-bonus/".$rule_dtls['id']."/2"); ?>">
	  <?php echo HLP_get_crsf_field(); ?>
	  <div class="row">
	    <div class="col-sm-12">
            <div class="form_head center_head clearfix">
                <div class="col-sm-12">
                    <ul>
                        <li>
                            <div class="form_tittle">
                            	<?php $tooltip_head=getToolTip('bonus-rule-page-2');
             					$tooltip_head_val=json_decode($tooltip_head[0]->step); ?>
                                <h4><?php echo $rule_dtls["name"]; ?> :- <span><?php echo $rule_dtls["bonus_rule_name"]; ?></span></h4>
                            </div>
                        </li>
                        <li>
                            <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $tooltip_head_val[0] ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </div>
                        </li>
                    </ul>
                </div>
            </div>
	        <div class="form_head clearfix">
            
	          <div class="col-sm-12">
	            <ul>
	              <li>
	                <div class="form_tittle">
	                  <h4>Step Two</h4>
	                </div>
	              </li>
	              <li>
	                <div class="form_info">
	                  <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="Demo tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
	                </div>
	              </li>
	            </ul>
	          </div>
	        </div>
	        <div class="form_sec  clearfix table-responsive forth">
	          <table class="table table_p table-bordered th-top-aln">
	            <thead>
	              <tr>
	                <th>Performance Range</th>
	                <th>Define <?php if($rule_dtls["performance_achievements_multiplier_type"]==2){echo "Define Accelerators/ Decelerators";}else{ echo "Single Multiplier (In %)"; } ?> for each performance range</th>
	              </tr>
	            </thead>
	            <tbody>
	              <?php $i=0;
						$rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"],true);
						$multipliers_arr = json_decode($rule_dtls["performance_achievements_multipliers"],true);
	                    foreach($rangs_arr as $row)
	                    { ?>
	                      <tr>
	                        <td><?php 
							$multipliers_val = "";
							if(isset($multipliers_arr[$i]))
							{ 
								$multipliers_val = $multipliers_arr[$i];
							} 
							
							if($i==0)
							{ 
								echo "0 < ".$row["max"];
							} 
							else
							{
								echo $row["min"]." To < ".$row["max"];
							}
							
							 ?></td>
	                        <td><input  type="text" id="txt_perfo_achie_rangs_<?php echo $i; ?>" name="txt_perfo_achie_rangs[]" class="form-control w_unset" required onKeyUp="validate_negative_percentage_onkeyup_common(this,3);" onBlur="validate_negative_percentage_onblure_common(this,3);" maxlength="7" value="<?php echo $multipliers_val; ?>" style="text-align:center;" /></td>
	                      </tr>
	                      
	                      <?php if(($i+1) == count($rangs_arr))
							{
								if(isset($multipliers_arr[$i+1]))
								{ 
									$multipliers_val = $multipliers_arr[$i+1];
								}
								echo '<tr><td> > '.$row["max"].'</td><td><input  type="text" id="txt_perfo_achie_rangs_'. $i .'" name="txt_perfo_achie_rangs[]" class="form-control w_unset" required onKeyUp="validate_negative_percentage_onkeyup_common(this,3);" onBlur="validate_negative_percentage_onblure_common(this,3);" maxlength="7" value="'. $multipliers_val .'" style="text-align:center;" /></td>
	                      </tr>';
							} ?>
	                      
	              <?php $i++; } ?>
	            </tbody>
	          </table>
	        </div>
	      </div>
	 
	  </div>
	  <div class="row">
	    <div class="col-sm-12 text-right">
	      <div class="row">
	        <input type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
	        <input type="submit" id="btnAdd_2nd" value="" style="display:none" />
	        <div class="col-sm-12 mob-center"> <a style="margin:5px 5px;" class="btn btn-success" href="">Back</a>
	          <input style="margin:5px 5px;" type="button" id="btn_edit_next" value="<?php if($rule_dtls['manual_budget_dtls']){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="btn btn-success" onclick="submit_frm2('0');" />
	          <?php if($rule_dtls['manual_budget_dtls']){?>
	          <input style="margin:5px 5px;" type="button" id="btn_next" value="Next Step" class="btn btn-success"  onclick="submit_frm2('1');"/>
	          <?php } ?>
	        </div>
	      </div>
	    </div>
	  </div>
	</form>
</div>
</div>
</div>
</div>
<script>
function submit_frm2(is_next_step)
{
	$("#hf_show_next_step").val(is_next_step);
	$("#btnAdd_2nd" ).trigger( "click" );
}
$('form').attr( "autocomplete", "off" );
</script> 
