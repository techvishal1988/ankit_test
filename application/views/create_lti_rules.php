<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstControls{line-height:17px;}
.fstMultipleMode.fstActive .fstResults{max-height:19em;}
/*.rule-form .form-control{height:38px !important;}
.rule-form .control-label{line-height:38px !important;}*/
.mailbox-content table thead tr th{vertical-align: top;}
</style>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
.form_head ul{ padding:0px; margin-bottom:0px;}
.form_head ul li{ display:inline-block;}



.rule-form .form-control {
	height: 30px;
	margin-top: 0px;
	font-size: 12px;
	background-color: #FFF;
	margin-bottom:10px;
}
.rule-form .control-label {
	font-size: 12px;
	line-height: 30px;
	<?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
	background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
	color: #000;
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
	color: #000 !important;
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
.form-group{
    margin-bottom: 10px;
}
.mailbox-content{
	 padding-bottom: 10px;
}
.paddg{ 0px 20px;}

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

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="page-breadcrumb">
  <ol class="breadcrumb container">
     <li><a href="<?php echo base_url("performance-cycle"); ?>">Comp Plans</a></li>
    <li><a href="<?php echo site_url('lti-rule-list/'.$rule_dtls['id']); ?>">LTI rule list</a></li>
    <li class="active"><?php echo $title; ?></li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12" id="dv_partial_page_data">
	 <div class="mb20">
        <div class="panel-white">
          <div class="">
		  	<div class="row">
				<div class="col-sm-12">
					<?php 
						$tooltip=getToolTip('lti-rule-page-2');
						$val=json_decode($tooltip[0]->step);
					?>
                    
                    <?php if($emp_not_any_cycle_counts > 0 or $this->session->flashdata('message')){?>
                        <div class="msgtxtalignment">
						<?php if($this->session->flashdata('message')) { ?>
                      <div class="msg-left cre_rule">
                        <?php echo $this->session->flashdata('message'); ?>
                      </div>
                      <div  class="msg-right cre_rule"> 
                    <?php    
                        if($emp_not_any_cycle_counts > 0){
                          echo "<span style='color:red;'>". $emp_not_any_cycle_counts. " employee(s) under your responsibility are not covered under in rule as yet <a href='". site_url("lti-emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";
                        }
                    ?>
                      </div>
                    <?php                            
                    } else{
                      if($emp_not_any_cycle_counts > 0){
                        echo "<span class='cre_rule' style='color:red;'>". $emp_not_any_cycle_counts. " employee(s) under your responsibility are not covered under in rule as yet <a href='". site_url("lti-emp-list-not-in-cycle/".$rule_dtls["performance_cycle_id"]."/1")."' >Click Here </a> to see the list.</span>";
                      }
                    }?>
						</div>
                    <?php } ?>
				</div>
			</div>
            <div class="rule-form pad_b_10">
			  <form id="frm_rule_step1"  method="post" action="<?php echo site_url('save-lti-rule/'.$rule_dtls['id'].'/1'); ?>" onsubmit="return set_rules(this);">
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
							  <div class="form_info">
								<span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
							  </div>
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
							<label class="control-label">LTI Rule Name</label>
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
							  <div class="form_info">
								<span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[1] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
							  </div>
							</li>
						  </ul>
						</div>
					  </div>
                      	
					  	<div class="form_sec clearfix">
							<div class="col-sm-12">
                            <div class="col-sm-6 removed_padding">
                            	<label for="inputPassword" class="control-label">LTI Linked with <span type="button"  data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[2] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label>
                            </div>
                          	<div class="col-sm-6">
                                <select class="form-control" id="ddl_lti_linked_with" name="ddl_lti_linked_with" required>
                                    <option value="">Select</option>
                                    <option value="<?php echo CV_LTI_LINK_WITH_STOCK; ?>" <?php if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_STOCK){ ?> selected="selected" <?php } ?>>Stock Value</option>
                                    <option value="<?php echo CV_LTI_LINK_WITH_CASH; ?>" <?php if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_CASH){ ?> selected="selected" <?php } ?>>Cash</option>
                                </select>
                            </div>
                            
                            <div class="col-sm-6 removed_padding">
                            	<label for="inputPassword" class="control-label">LTI Grant Baseline <span type="button"  data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[3] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label></label>
                            </div>
                          	<div class="col-sm-6">
                                <select class="form-control" id="ddl_lti_basis_on" name="ddl_lti_basis_on" onchange="show_hide_salary_elem_dv();" required>
                                    <option value="">Select</option>
                                    <option value="1" <?php if($rule_dtls['lti_basis_on'] == '1'){ ?> selected="selected" <?php } ?>>Linked To Salary Elements</option>
                                    <option value="2" <?php if($rule_dtls['lti_basis_on'] == '2'){ ?> selected="selected" <?php } ?>>Fixed Amount</option>
                                </select>
                            </div>
                            
                            <div id="dv_salary_elem" style="display:none;">
                            	<div class="col-sm-6 removed_padding">
                                    <label for="inputPassword" class="control-label">Salary Elements <span type="button"  data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[4] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label></label>            
                                </div>
                        		<div class="col-sm-6" style="margin-bottom:8px;">
                                    <select id="ddl_salary_elements" onchange="hide_list('ddl_salary_elements');" name="ddl_salary_elements[]" class="form-control multipleSelect" multiple="multiple">
                                        <option  value="all">All</option>
                                        <?php if($salary_applied_on_elem_list){
                                            $salary_applied_on_elements = "";
                                            if(isset($rule_dtls['applied_on_elements']))
                                            {
                                                $salary_applied_on_elements = explode(",", $rule_dtls['applied_on_elements']);
                                            }
                                            foreach($salary_applied_on_elem_list as $row){ ?>
                                        <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($salary_applied_on_elements) and in_array($row["business_attribute_id"], $salary_applied_on_elements)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-6 removed_padding">
                            	<label for="inputPassword" class="control-label">LTI Differentiation To Be Based On <span type="button" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[5] ?>"><i class="fa fa-info" aria-hidden="true"></i></span></label></label>
                            </div>
                          	<div class="col-sm-6">
                                <select class="form-control" id="ddl_target_lti_on" name="ddl_target_lti_on" required>
                                    <option value="">Select</option>
                                    <option value="<?php echo CV_DESIGNATION; ?>" <?php if($rule_dtls['target_lti_on'] == CV_DESIGNATION){ ?> selected="selected" <?php } ?>>Designation</option>
                                    <option value="<?php echo CV_GRADE; ?>" <?php if($rule_dtls['target_lti_on'] == CV_GRADE){ ?> selected="selected" <?php } ?>>Grade</option>
                                    <option value="<?php echo CV_LEVEL; ?>" <?php if($rule_dtls['target_lti_on'] == CV_LEVEL){ ?> selected="selected" <?php } ?>>Level</option>
                                </select>
                            </div> 
                            						  
						</div>
					  	</div>
					</div>
				</div>
				</div>
				
                <div class="row">  
                    <div class="col-sm-12">    
                        <div class="form-group">
                           <div class="form_head clearfix">
                            <div class="col-sm-12">
                            <ul>
                            <li>
                              <div class="form_tittle">
                                <h4>Manager's Discretion</h4>
                              </div>
                              </li>
                            <li>
                              <div class="form_info">
                                <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[6] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
                              </div>
                              </li>
                             </ul>
                            </div>
                            
                          </div>
                           <div class="form_sec clearfix">                       
                           <div class="col-sm-12">
                                
                                <div class="col-sm-6 removed_padding">
                                    <label class="control-label">Manager's Discretion For LTI Allocation</label>
                                </div>
                                <div class="col-sm-6">
                                
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <span style="font-weight:bold; font-size:20px;">-</span>
                                        </div>
                                        <div class="col-sm-4">
                                           <input type="text" name="txt_manager_discretionary_decrease" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_decrease"]){echo $rule_dtls["manager_discretionary_decrease"];}else{echo "";} ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" />
                                        </div>
                                        
                                        <div class="col-sm-1">
                                            <span style="font-weight:bold; font-size:20px;">+</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" name="txt_manager_discretionary_increase" class="form-control" required="required" value="<?php if($rule_dtls["manager_discretionary_increase"]){echo $rule_dtls["manager_discretionary_increase"];}else{echo "";} ?>" maxlength="5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);"/>
                                         </div>                              
                                    </div>                          
                                </div>
                                                            
                             </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-sm-12 text-right">
                    <input type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
                    <input type="submit" id="btnAdd_1st" value="" style="display:none" />
                    	<a  class="mar_l_5 btn btn-success" href="<?php echo site_url("lti-rule-filters/".$rule_dtls["performance_cycle_id"]."/".$rule_dtls["id"]); ?>">Back</a>
                        <input  type="button" id="btn_edit_next" value="<?php if($rule_dtls['status'] >= 2){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="mar_l_5 btn btn-success" onclick="submit_frm('0');" />
					<?php if($rule_dtls['status'] >= 2){?>
                        	<input type="button" id="btn_next" value="Next Step" class="btn btn-success mar_l_5"  onclick="submit_frm('1');"/>
                    <?php } ?>
                    </div>
				</div>   
                </div>
				
				

			  </form>
			</div>
		  </div>
		</div>
	   </div>
    </div>
    <div class="col-md-12" id="dv_partial_page_data_2"> </div>
  </div>
</div>
<script type="text/javascript">
$('.multipleSelect').fastselect();
function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
            	$(this).find(".fstChoiceRemove").trigger("click");
            });
            show_list(obj_id);
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}

function show_list(obj)
{
    $('#'+ obj ).siblings('.fstResults').children('.fstResultItem') .each(function(i, selected)
	{
        if($(this).html()!='All')
        {
            $(this).trigger("click");
        }
    });
}

function show_hide_salary_elem_dv()
{
	$("#ddl_salary_elements").prop('required',false);
	$("#dv_salary_elem").hide();
	if($("#ddl_lti_basis_on").val()=='1')
	{
		$("#ddl_salary_elements").prop('required',true);
		$("#dv_salary_elem").show();
	}
}

function show_hide_budget_dv(val, to_currency,is_need_pre_fill)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
    $("#dv_submit_3_step").hide();
	$('.page-inner').css('height','');

    if(val != '')
    {
		$("#loading").css('display','block');
        $.post("<?php echo site_url("lti_rule/get_managers_for_manual_bdgt");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
        {
            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();
                $("#dv_submit_3_step").show();
				
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
							calculat_percent_increased_val(1, items[i], (i+1));
							i++;    
						});
					}
					if(val=='Automated but x% can exceed')
					{
						$("input[name='txt_manual_budget_per[]']").each( function (key, v)
						{
							$(this).val(items[i]);
							//$(this).prop('readonly',true);;
							calculat_percent_increased_val(2, items[i], (i+1));
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
			$("#loading").css('display','none');
        });
    } else {
		var getheight = parseInt($(window).height()) - 100;
		$('.page-inner').css('height',getheight + 'px');
	}
}
//Piy@17Dec19 
function calculat_percent_increased_val(typ, val, index_no)
{
  if(typ==1)
  {
    //$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    $("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(val));
    var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100);
    $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
  }
  else if(typ==2)
  {
  var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100;
  var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1));

  //$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
  $("#td_revised_bdgt_"+ index_no).html(get_formated_amount_common(revised_bdgt));
  var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100);
  $("#td_increased_amt_"+ index_no).html(get_formated_percentage_common(increased_amt)+' %');
  $("#td_increased_amt_val_"+ index_no).html(get_formated_amount_common(increased_bdgt));
  }
  calculat_total_revised_bgt();
}


function calculat_total_revised_bgt()
{
  var manager_cnt = $("#hf_manager_cnt").val();
  //var val = 0;
  var amtval = 0;
  for(var i=1; i<manager_cnt; i++)
  {
   // val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
    amtval += ($("#td_increased_amt_val_"+ i).html().replace(/[^0-9.]/g,''))*1;
  }
  val = (($("#th_total_budget_plan").html().replace(/[^0-9.]/g,''))*1) + amtval;  

  var per = (val/$("#hf_total_base_lti").val()*100);
  $("#th_final_per").html(get_formated_percentage_common(per) + ' %');

  var formated_val = get_formated_amount_common(val);
  $("#th_total_budget").html(formated_val);
  $("#th_total_budget_manual").html(formated_val);

  formated_val = get_formated_amount_common(amtval);
  $("#th_additional_budget_manual").html(formated_val);
}

/*function calculat_percent_increased_val(typ, val, index_no)
{
	if(typ==1)
	{
		//$("#td_revised_bdgt_"+ index_no).html(val);	
		$("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
		var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
		$("#td_increased_amt_"+ index_no).html(increased_amt+' %');	
	}
	else if(typ==2)
	{
		var increased_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100).toFixed(0);;
		var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
		//$("#td_revised_bdgt_"+ index_no).html(revised_bdgt);
		$("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
		var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
		$("#td_increased_amt_"+ index_no).html(increased_amt+' %');	
		$("#td_increased_amt_val_"+ index_no).html(increased_bdgt);
	}
	calculat_total_revised_bgt();
}

function calculat_total_revised_bgt()
{
	var manager_cnt = $("#hf_manager_cnt").val();
	var val = 0;
	for(var i=1; i<manager_cnt; i++)
	{
		val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
	}
	//$("#th_total_budget").html(val.toFixed(0));
	//$("#th_total_budget").html(val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
	
	var per = (val/$("#hf_total_base_lti").val()*100).toFixed(2);
	$("#th_final_per").html(per + ' %');
	
	var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	$("#th_total_budget").html(formated_val);
	$("#th_total_budget_manual").html(formated_val);

	var val = 0;
	for(var i=1; i<manager_cnt; i++)
	{
		val += ($("#td_increased_amt_val_"+ i).html().replace(/[^0-9.]/g,''))*1;
	}
	var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
  	$("#th_additional_budget_manual").html(formated_val);
}
*/
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

function submit_frm(is_next_step)
{
	$("#hf_show_next_step").val(is_next_step);
	$("#btnAdd_1st" ).trigger( "click" );
}

function set_rules(frm)
{   
    var form=$("#"+frm.id);	
	/*if(frm.id == 'frm_rule_step1')
	{
		var total_weightage = 0;
		total_weightage += ($("#txt_individaul_bussiness_level").val())*1;
		total_weightage += ($("#txt_function_weightage").val())*1;
		
		$("input[name='txtbusiness_level[]']").each( function (key, v)
		{
			total_weightage += ($(this).val())*1;
		});
		
		if(total_weightage != "100")
		{
			alert("Total of all Business Level Weightage should we equeal to 100");
			return false;
		}
	}*/

	/*if( !request_confirm()) {
		return false;
	}*/
		
	$("#loading").css('display','block');
    $.ajax({
        type:"POST",
        url:form.attr("action"),
        data:form.serialize(),
        success: function(response)
        {
            if(response==3)
            {
                $("#loading").css('display','none');
                //window.location.href= "<?php //echo site_url("view-lti-rule-budget/".$rule_dtls["id"]);?>";
				window.location.href= "<?php echo site_url("view-lti-rule-details/".$rule_dtls["id"]);?>";
            }    
			else if(response==2)
            {
                 $.get("<?php echo site_url("lti_rule/get_rule_step3_frm/".$rule_dtls["id"]);?>", function(data)
                 {
					if(data)
					{
						$("#loading").css('display','none');
						$("#dv_frm_1_btn").html('');
						$("#dv_partial_page_data").html('');
						$("#dv_partial_page_data_2").html('');
						$("#dv_partial_page_data_2").html(data);
					}
					else
					{
						$("#loading").css('display','none');
						window.location.href= "<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
					}
                }); 
            }        
            else if(response==1)
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
            else
            {
                $("#loading").css('display','none');
                window.location.href= "<?php echo site_url("lti-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
            }
        }
    });
    return false;
}

show_hide_salary_elem_dv()
</script>
