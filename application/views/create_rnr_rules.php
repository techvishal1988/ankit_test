<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
.rule-form .form-control {
	height:30px !important;
}
.rule-form .control-label {
	line-height:30px !important;
}
.form_head ul {
	padding:0px;
	margin-bottom:0px;
}
.form_head ul li {
	display:inline-block;
}
.rule-form .control-label {
	font-size: 13px;
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
	
 <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>  background-color: #<?php echo $this->session->userdata("company_light_color_ses");
?>;
	color: #000;
	margin-bottom:10px;
}
.rule-form .form-control:focus {
	box-shadow: none!important;
}
.rule-form .form_head {
	background-color: #f2f2f2;
 <?php /*?>border-top: 8px solid #93c301;<?php */?>  border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
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
	font-size: 20px;
	padding: 7px;
  margin-top: -4px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
	/*margin-bottom: 30px;*/
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
	border-bottom-left-radius: 0px;/*6px;*/
	border-bottom-right-radius: 0px;/*6px;*/
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
.tooltipcls{
    margin-left: 10px;
}
.paddg {
0px 20px;
}


#dv_budget_manual table tr td .form-control
{
	margin-bottom:0px !important;
}

#dv_budget_manual table tr td
{
	vertical-align: middle;
}

.alert 
{
	margin-bottom: -10px !important;
	margin-top: -5px !important;
}

/***added to center align the form head text****/
.form_head.center_head{border-bottom: 0px; margin-bottom: 10px;}
.form_head.center_head ul{text-align: center;}
.form_head.center_head ul .form_tittle h4{padding: 0px;}
.form_head.center_head ul .form_tittle h4 p{margin:0px;font-size: 16px;font-weight: bold; text-transform: uppercase;}
.form_head.center_head ul .form_tittle h4 span{font-size: 12px; color: #3e3d3d;}
/***added to center align the form head text****/
</style>

<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo base_url("performance-cycle"); ?>">Comp Plans</a></li>
    <li><a href="<?php echo site_url('rnr-rule-list/'.$rule_dtls['performance_cycle_id']); ?>">RNR rule list</a></li>
    <li class="active"><?php echo $title; ?></li>
  </ol>
</div>
<?php 
$tooltip=getToolTip('rnr-rule-page-2');
$val=json_decode($tooltip[0]->step);
?>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12" id="dv_partial_page_data">
      <div class="mb20">
        <div class="panel-white" style="padding-bottom:10px;">
          <div>          	
                <div class="row">
                    <div class="col-sm-12">
						<?php if(@$this->session->flashdata('message')){?> 
                            <div class="msgtxtalignment text-center">
                              <div class='msg-left'>
								<?php echo $this->session->flashdata('message'); ?>
                            </div>
                          </div>
                        <?php } ?>
                    </div>
                </div>
            
            <div class="rule-form">
              <form id="frm_rule_step1"  method="post" action="<?php echo site_url('save-rnr-rule/'.$rule_dtls['id']); ?>">
              	<?php echo HLP_get_crsf_field();?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form_head center_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4><?php echo $rule_dtls["name"]; ?></h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
                        <div class="col-sm-12">
                          <?php /*?><div class="col-sm-6 removed_padding">
                            <label for="inputEmail3" class="control-label">Plan Name </label>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-input">
                              <input type="text" name="txt_performance_cycle" class="form-control" value="<?php if(isset($rule_dtls["name"])){echo $rule_dtls["name"];} ?>" readonly="readonly" style="background-color:#eee !important; pointer-events:none;"/>
                            </div>
                          </div><?php */?>
                          <div class="col-sm-6 removed_padding">
                            <label class="control-label">R and R Rule Name</label>
                          </div>
                          <div class="col-sm-6 ">
                            <input type="text" name="txt_rule_name" value="<?php echo $rule_dtls["rule_name"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form_head clearfix">
                        <div class="col-sm-12">
                          <ul>
                            <li>
                              <div class="form_tittle">
                                <h4>Step One</h4>
                              </div>
                            </li>
                            <li>
                              <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[1] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form_sec clearfix">
                        <div class="col-sm-12">
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Category <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[2] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" name="txt_category" value="<?php echo $rule_dtls["category"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Criteria <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[3] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" name="txt_criteria" value="<?php echo $rule_dtls["criteria"]; ?>" class="form-control" required="required" maxlength="100"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Award Type <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[4] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control" id="ddl_award_type" name="ddl_award_type" required onchange="reset_budget_fields();">
                              <option value="1" <?php if($rule_dtls['award_type'] == "1"){ ?> selected="selected" <?php } ?>>Cash</option>
                              <option value="2" <?php if($rule_dtls['award_type'] == "2"){ ?> selected="selected" <?php } ?>>Points</option>
                              <option value="3" <?php if($rule_dtls['award_type'] == "3"){ ?> selected="selected" <?php } ?>>Just Recognisation (Manager)</option>
                              <option value="4" <?php if($rule_dtls['award_type'] == "4"){ ?> selected="selected" <?php } ?>>Just Recognisation (Employee)</option>
                            </select>
                          </div>
                          <div class="col-sm-6 removed_padding dv_award_value">
                            <label for="inputPassword" class="control-label">Award Value <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[5] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6 dv_award_value">
                            <input type="text" name="txt_award_value" id="txt_award_value" value="<?php if($rule_dtls["award_value"]){echo $rule_dtls["award_value"];} ?>" class="form-control" required="required" maxlength="12" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" onchange="reset_budget_fields();"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Award Frequency (In Months) <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[6] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" name="txt_award_frequency" id="txt_award_frequency" value="<?php if($rule_dtls["award_frequency"]){echo $rule_dtls["award_frequency"];} ?>" class="form-control" required="required" maxlength="2" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);" onchange="reset_budget_fields();"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Frequency for Employee (In Months) <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[7] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" name="txt_emp_frequency_for_award" value="<?php if($rule_dtls["emp_frequency_for_award"]){echo $rule_dtls["emp_frequency_for_award"];} ?>" class="form-control" required="required" maxlength="2" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"/>
                          </div>
                          <div class="col-sm-6 removed_padding">
                            <label for="inputPassword" class="control-label">Is Approval Required <span type="button" class="tooltipcls" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[8] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control" id="ddl_is_approval_required" name="ddl_is_approval_required" required>
                              <option value="1" <?php if($rule_dtls['is_approval_required'] == "1"){ ?> selected="selected" <?php } ?>>Yes</option>
                              <option value="2" <?php if($rule_dtls['is_approval_required'] == "2"){ ?> selected="selected" <?php } ?>>No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" id="dv_overall_budget">
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
                            <div class="form_info">
                              <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[9] ?>"><i class="themeclr fa fa-info-circle" aria-hidden="true"></i></button>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="form_sec clearfix">
                      <div class="col-sm-12">
                        <div class="col-sm-6 removed_padding">
                          <label class="control-label">Overall Budget Allocation</label>
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
                          <button type="button" style="margin-top:1px; width: 100%;" class="btn p_btn btn-success" onclick="get_budget_dtls();">Show me the Money</button>
                        </div>
                      </div>
                      <div class="col-sm-12">
                      <div class="form-group" id="dv_budget_manual" style="display:none;"> </div>
                    </div>
                    </div>
                  </div>
                  
                  
                </div>
                <div class="row">
                  <div class="col-sm-12 text-right" style="margin-top:10px">
                  	<a style="margin-right:10px;" class="btn btn-success " href="<?php echo site_url("rnr-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Back</a>
                    
                    <input  type="submit" id="btnAdd_1st" name="btn_save_rule" value="Submit" class="btn btn-success pull-right" />
                    <input style="margin-right:10px;" type="submit" id="btnAdd_2st" name="btn_save_rule" value="Submit & Send For Approval" class="btn pull-right btn-success" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function reset_budget_fields()
{
	$("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
	$("#ddl_overall_budget").val('');
	$(".dv_award_value").show();
	if($("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
	{
		$("#txt_award_value").val('0');
		$(".dv_award_value").hide();
	}
	if($("#ddl_award_type").val()==1)
	{
		$("#dv_overall_budget").show();
	}
	if($("#ddl_award_type").val()==2 || $("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
	{
		$("#ddl_overall_budget").val('No limit');
		show_hide_budget_dv('No limit', $("#ddl_to_currency").val(), '0');
	}
}

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

function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
	
	if($("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
	{
		$("#txt_award_value").val('0');
		$(".dv_award_value").hide();
	}
	
	var award_val = ($("#txt_award_value").val())*1;
	var award_fr_val = ($("#txt_award_frequency").val())*1;
	
	if(award_fr_val <= 0 && $("#ddl_award_type").val()==1)
	{
		 $("#ddl_overall_budget").val('');
		 if(is_need_pre_fill==0)
		 {
			custom_alert_popup("Please enter Award Frequency value first");
		 }
		return false;
	}

    if(val != '')
    {
		if($("#ddl_award_type").val()==2 || $("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
		{
			award_val = 0;
		}
		
        $.post("<?php echo site_url("rnr_rule/get_managers_for_manual_bdgt");?>",{budget_type: val, to_currency: to_currency, award_val: award_val, award_fr_val: award_fr_val, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
        {
            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();
				if($("#ddl_award_type").val()==2 || $("#ddl_award_type").val()==3 || $("#ddl_award_type").val()==4)
				{
					 $("#dv_overall_budget").hide();
				}
				else
				{
					$("#dv_overall_budget").show();
				}
				if(is_need_pre_fill==1)
				{
					var json_manual_budget_dtls = '<?php echo $rule_dtls["budget_dtls"]; ?>';
					var i = 0;
					var items = [];               
					$.each(JSON.parse(json_manual_budget_dtls),function(key,valll)
					{
					   //alert(valll[0])
						if(val=='Manual')
						{
							items.push(valll[1]);
						}
						if(val=='Automated but x% can exceed')
						{
							items.push(valll[2]);
						}
					});
					if(val=='Manual')
					{
						$("input[name='txt_manual_budget_amt[]']").each( function (key, v)
						{
							$(this).val(items[i]);
							//$(this).prop('readonly',true);;
							i++;    
						});
					}
					if(val=='Automated but x% can exceed')
					{
						$("input[name='txt_manual_budget_per[]']").each( function (key, v)
						{
							$(this).val(items[i]);
							//$(this).prop('readonly',true);;
							i++;    
						});
					}
				}
				               
            }
            else
            {
                $("#ddl_overall_budget").val('');
                $("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>You have no manager to set budget for manually.</b></span></div>');
                $.magnificPopup.open({
                    items: {
                        src: '#common_popup_for_alert'
                    },
                    type: 'inline'
                });
                setTimeout(function(){$('#common_popup_for_alert').magnificPopup('close');},2000);
            }
        });
    }
}

function validate_onkeyup(that)
{
    that.value = that.value.replace(/[^0-9.]/g,'');
    if(((that.value).split('.')).length>2)
    {
        var arr = (that.value).split('.');
        that.value=arr[0]+"."+arr[1];
    }
}
function validate_onblure(that)
{
    that.value = that.value.replace(/[^0-9.]/g,'');
    if(((that.value).split('.')).length>2)
    {
        var arr = (that.value).split('.');
        that.value=arr[0]+"."+arr[1];
    }
    if((that.value) && Number(that.value)<=0)
    {
        that.value="0";
    }
}

function validate_onkeyup_num(that)
{
    that.value = that.value.replace(/[^0-9]/g,'');
    if(((that.value).split('.')).length>1)
    {
        var arr = (that.value).split('.');
        that.value=arr[0];
    }
}

function validate_onblure_num(that)
{
    that.value = that.value.replace(/[^0-9]/g,'');
    if(((that.value).split('.')).length>1)
    {
        var arr = (that.value).split('.');
        that.value=arr[0];
    }

    if((that.value) && Number(that.value)<=0)
    {
        that.value="0";
    }
}

show_hide_budget_dv('<?php echo $rule_dtls["budget_type"]; ?>', $("#ddl_to_currency").val(), '1');
</script> 
