<div class="row">
  <div class="col-md-12">
    <div class="mb20">
      <div class="mailbox-content">
        <div class="">
          <div class="rule-form">
            <form id="frm_rule_step3" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("save-sip/".$rule_dtls['id']."/3"); ?>">
              <?php echo HLP_get_crsf_field();?>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form_head clearfix">
                      <div class="col-sm-12">
                        <ul>
                          <li>
                            <div class="form_tittle">
                              <h4>Define Budget Allocation</h4>
                            </div>
                          </li>
                          <li>
                            <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $rule_val[0] ?>"><i style="font-size:20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="form_sec clearfix">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <div class="row">
                            <div style="padding-left: 15px !important;" class="col-sm-6 removed_padding pl15">
                              <label class="control-label">Overall Budget Allocation</label>
                            </div>
                            <div class="col-sm-2">
                              <select class="form-control" name="ddl_overall_budget" required id="ddl_overall_budget">
                                <option value="">Select</option>
                                <option value="No limit" <?php if($rule_dtls["overall_budget"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                                <option value="Automated locked" <?php if($rule_dtls["overall_budget"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                                <option value="Automated but x% can exceed" <?php if($rule_dtls["overall_budget"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                                <?php /*?><option value="Manual" <?php if($rule_dtls["overall_budget"]=="Manual"){echo 'selected="selected"';} ?>>Manual</option><?php */?>
                              </select>
                            </div>
                            <div class="col-sm-2">
                              <select class="form-control" name="ddl_to_currency" id="ddl_to_currency" required>
                                <?php foreach($currencys as $currency){?>
                                <option value="<?php echo $currency["id"]; ?>" <?php if($rule_dtls["to_currency_id"]){ if($rule_dtls["to_currency_id"] == $currency["id"]){echo 'selected="selected"';}}elseif($default_currency[CV_BA_NAME_CURRENCY] == $currency["id"]){echo 'selected="selected"';} ?>><?php echo $currency["name"]; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="col-sm-2" style="padding: 0px;">
                              <button type="button" style="margin-top:1px; width:92%;" class="btn p_btn btn-success" onclick="get_budget_dtls();">Show me the Money</button>
                            </div>
                            <div id="dv_budget_manual" style="display:none;"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
			  	<div class="col-sm-12 text-right">
					<div class="submit-btn">
						<a class="btn btn-success ml-mb" href="<?php echo site_url("create-sip-rule/".$rule_dtls["id"]); ?>">Back</a>
						<span id="dv_submit_2_step" style="display:none;">
						<button type="submit" id="btnAdd_3rd" class="ml-mb btn btn-success">Review The Plan</button>
						</span>
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

show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', $("#ddl_to_currency").val(), '1');

function show_2nd_step_form_NIU()
{
	$("#loading").show();
	$.get("<?php echo site_url("sip/get_sip_rule_step2_frm/".$rule_dtls["id"]);?>", function(data)
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
			window.location.href= "<?php echo site_url("sip-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
		}
	});
}
$('form').attr( "autocomplete", "off" );
</script>