<style>
#dv_budget_manual table tr td .form-control
{
	margin-bottom:0px !important;
}

#dv_budget_manual table tr td
{
	vertical-align: middle;
}

</style>
<?php 
$tooltip=getToolTip('lti-rule-page-4');
$val=json_decode($tooltip[0]->step);
?>
<form id="frm_rule_step3" class="rule-form" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("save-lti-rule/".$rule_dtls['id']."/3"); ?>">
	<?php echo HLP_get_crsf_field();?>

	<div class="form-group mailbox-content">
        <div class="row">
            <div class="col-sm-12"> 
            	<div class="form_head center_head clearfix">
                    <div class="col-sm-12">
                        <ul>
                            <li>
                                <div class="form_tittle">
                                    <?php $tooltip_head=getToolTip('lti-rule-page-2');
                                    $tooltip_head_val=json_decode($tooltip_head[0]->step); ?>
                                    <h4><?php echo $rule_dtls["name"]; ?> :- <span><?php echo $rule_dtls["rule_name"]; ?></span></h4>
                                </div>
                            </li>
                            <li>
                                <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $tooltip_head_val[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                        </ul>
                    </div>
                </div>           
                <div class="form_head clearfix">
                      <div class="col-sm-12">
                    <ul>
                    <li>
                      <div class="form_tittle">
                        <h4>Define Budget Allocation</h4>
                      </div>
                      </li>
                    <li>
                      <div class="form_info">
                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[0] ?>"><i class="themeclr fa fa-info-circle" aria-hidden="true"></i></button>
                      </div>
                      </li>
                     </ul>
                    </div>
                    </div>
                <div class="form_sec clearfix">
                    <div class="col-sm-12">
                    <div class="col-sm-6 removed_padding">
                        <label class="control-label" style="color:#fff">Overall Budget Allocation</label>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" name="ddl_overall_budget" required id="ddl_overall_budget">
                            <option value="">Select</option>
                            <option value="No limit" <?php if($rule_dtls["budget_type"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                            <option value="Automated locked" <?php if($rule_dtls["budget_type"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                            <option value="Automated but x% can exceed" <?php if($rule_dtls["budget_type"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                             <?php /*?><option value="Manual" <?php if($rule_dtls["budget_type"]=="Manual"){echo 'selected="selected"';} ?>>Manual</option><?php */?> 
                        </select>								
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" name="ddl_to_currency" id="ddl_to_currency" required>
                            <?php foreach($currencys as $currency){?>
                            <option value="<?php echo $currency["id"]; ?>" <?php if($rule_dtls["to_currency_id"]){ if($rule_dtls["to_currency_id"] == $currency["id"]){echo 'selected="selected"';}}elseif($default_currency[CV_BA_NAME_CURRENCY] == $currency["id"]){echo 'selected="selected"';} ?>><?php echo $currency["name"]; ?></option>
                            <?php } ?>
                        </select>               
                    </div>
                    <div class="col-sm-2 removed_padding">
                      <button type="button" style="margin-top:1px; width:100%;" class="btn p_btn btn-success" onclick="get_budget_dtls();">Show me the Money</button>
                    </div>
                                
                </div>
                    
                <div class="col-sm-12">
                 <div class="form-group" id="dv_budget_manual" style="display:none;">
                            
                 </div>
                </div>
              </div>

            </div>
            
        </div>
        
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="submit-btn">
                    <input style="margin-top:5px;" type="button" id="btn_next" value="Back" class="btn btn-success"  onclick="show_2nd_step_form();"/>
                    <span   id="dv_submit_3_step" style="display:none;">
                        <button style="margin-top:5px; margin-left:5px;" type="submit" id="btnAdd_3rd" class="btn pull-right btn-success">Review The Plan</button>
                    </span>
                </div>
            </div>
        </div> 
        
    </div> 

	</div>


    
</form>

<script>
function get_budget_dtls()
{
	var bdgt_type = $("#ddl_overall_budget").val();
	var to_currency = $("#ddl_to_currency").val();
	if(bdgt_type)
	{
		show_hide_budget_dv(bdgt_type, to_currency, '0');
	}
	else
	{
		custom_alert_popup("Please select 'Overall Budget Allocation' first.");	
	}
	
}


show_hide_budget_dv('<?php echo $rule_dtls["budget_type"]; ?>', $("#ddl_to_currency").val(),'1');

function show_2nd_step_form()
{
	$.get("<?php echo site_url("lti_rule/get_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
	{
		if(data)
		{
			$("#loading").css('display','none');
			$("#dv_partial_page_data").html('');
			$("#dv_partial_page_data_2").html(data);
		}
		else
		{
			$("#loading").css('display','none');
			window.location.href= "<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
		}
	}); 
}
$('form').attr( "autocomplete", "off" );
</script>



            