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
	margin-top:-4px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
/*	margin-bottom: 30px;*/
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
	border-bottom-left-radius: 0px; /*6px;*/
	border-bottom-right-radius: 0px; /*6px;*/
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
    float:none !important;
} 
.table tr th{text-align: center;}
.table tr th i{display: block;}
</style>
<?php 
$tooltip=getToolTip('lti-rule-page-3');
$val=json_decode($tooltip[0]->step);
?>
<form id="frm_rule_step2" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("save-lti-rule/".$rule_dtls['id']."/2"); ?>">
	<?php echo HLP_get_crsf_field();?>
  <div class="row">
    <div class="col-sm-12 background-cls" style="margin-bottom:30px;">
      <div class="rule-form mailbox-content">
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
                  <h4>Step Two</h4>
                </div>
              </li>
              <li>
                <div class="form_info">
                  <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="form_sec  clearfix table-responsive">
          <table class="table table-bordered">
            <thead>
              
            </thead>
            <tbody>
			<?php $i=0;$j=0; 
                if($target_lti_elements)
                { 
					$target_lti_dtl_arr = "";
					if($rule_dtls['target_lti_dtls'])
					{
						$target_lti_dtl_arr = json_decode($rule_dtls['target_lti_dtls'], true);
						//echo "<pre>";print_r($target_lti_dtl_arr);die;
					}
					
					$vesting_dates_arr = "";
					if($rule_dtls['vesting_date_dtls'])
					{
						$vesting_dates_arr = json_decode($rule_dtls['vesting_date_dtls'], true);
					} ?>
                    
                    
                      
					<?php foreach($target_lti_elements as $row){
						if($rule_dtls['lti_linked_with'] == CV_LTI_LINK_WITH_STOCK and $i == 0){ ?>
                                          
                        <tr bgcolor="#BBFFFF" class="custom_icon_color">
                            <th>Period <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[1] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Stock Value At The Time Of Grant<span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2] ?>" data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></th>
                            <th>Vesting-1 <span   data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[3] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-2 <span   data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[4] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-3 <span   data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[5] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-4 <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[6] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-5 <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[7] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-6 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[8] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-7 <span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[9] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        </tr>
                        <tr bgcolor="#BBFFFF">
                            <th style="min-width:85px;" colspan="2">Vesting Dates </th>                            
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date0" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[0]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date1" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[1]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date2" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[2]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date3" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[3]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date4" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[4]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date5" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[5]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                            <td><input type="text" class="form-control date_for_vestings" name="txt_vesting_date[]" id="date6" maxlength="10"  value="<?php if($vesting_dates_arr) echo $vesting_dates_arr[6]; ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/></td>
                      </tr>                    
                      	<tr bgcolor="#BBFFFF">
                            <th style="min-width:85px;">Stock Price </th>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?>" name="txt_grant_val[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?>" name="txt_vesting_val_1[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?>" name="txt_vesting_val_2[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?>" name="txt_vesting_val_3[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?>" name="txt_vesting_val_4[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?>" name="txt_vesting_val_5[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?>" name="txt_vesting_val_6[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?>" name="txt_vesting_val_7[]" placeholder="0" /></td>
                      </tr>
                      
                	<?php $i++; } ?>
                    
                  <?php if($j==0){?>
                  	 <tr class="custom_icon_color">
                        <th bgcolor="#B9B9B9"><?php echo ucfirst($rule_dtls['target_lti_on']); ?> <span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[10] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                        <th bgcolor="#B9B9B9"><?php if($rule_dtls['lti_basis_on']==2){echo "Fixed Amount";}else{echo "Grant As %age Of Selected Salary Elements";} ?><span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[11] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                         <th>Vesting-1 
                         %age <span   data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[11] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-2 %age <span   data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[12] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-3 %age<span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[13] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-4 %age<span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[14] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-5 %age<span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[15] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-6 %age<span data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[16] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                            <th>Vesting-7 %age<span  data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[17] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></th>
                      </tr>
                  <?php } ?>  
                  <tr>
                  
                    <td bgcolor="#B9B9B9" style="min-width:85px;" id="td_<?php echo $i; ?>"><?php echo $row['name']; ?></td>
                    <td bgcolor="#B9B9B9">
                        <input type="hidden" value="<?php echo $row['id'].''.CV_CONCATENATE_SYNTAX.''.$row['name']; ?>" name="hf_target_lti_elem[]" />
                        <input type="text" class="form-control" onKeyUp="validate_percentage_onkeyup_common(this,9);" onBlur="validate_percentage_onblure_common(this,9);" maxlength="12" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?>" name="txt_grant_val[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv1" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?>" name="txt_vesting_val_1[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv2" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?>" name="txt_vesting_val_2[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv3" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?>" name="txt_vesting_val_3[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv4" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?>" name="txt_vesting_val_4[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv5" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?>" name="txt_vesting_val_5[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv6" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?>" name="txt_vesting_val_6[]" placeholder="0" /></td>
                            <td><input type="text" class="form-control tvv7" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);" maxlength="5" value="<?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?>" name="txt_vesting_val_7[]" placeholder="0" /></td>
                  </tr>
            <?php $i++;$j++;} }?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-sm-12 text-right">
        <input type="hidden" value="0" id="hf_show_next_step" name="hf_show_next_step" />
        <?php /*?><input type="submit" id="btnAdd_2nd" value="" style="display:none" /><?php */?>
        <a  class="mar_l_5 btn btn-success" href="">Back</a> 
       
          <input  type="button" id="btn_edit_next" value="<?php if($rule_dtls['budget_dtls']){ echo "Edit & Next Step"; }else{echo "Next Step";} ?>" class="mar_l_5 btn btn-success" onclick="submit_frm2('0');" />
        
        <?php if($rule_dtls['budget_dtls']){?>
       
          <input type="button" id="btn_next" value="Next Step" class="mar_l_5 btn btn-success"  onclick="submit_frm2('1');"/>
        
        <?php } ?>
      </div>
    </div>
    
  </div>
  
</form>
<script>

function submit_frm2(is_next_step)
{		
		var flag = false;	
		$("input[name='txt_vesting_val_1[]']").each( function(key, v)
		{	
		//var arr = $("input[name='txt_vesting_val_1[]']");
		//alert(arr.eq(key).val());
			var total_vesting_val = 0;
			var name = "";		
			for(var i=1; i<=7; i++)
			{
				total_vesting_val += ($("input[name='txt_vesting_val_"+i+"[]']").eq(key).val())*1;
			}
			
			var lti_linked_with = '<?php echo $rule_dtls['lti_linked_with']; ?>';
			//if(lti_linked_with == "Stock Value")
			if(lti_linked_with == "<?php echo CV_LTI_LINK_WITH_STOCK; ?>")
			{
                           	if(key > 0)
				{
					if(total_vesting_val != "100")
					{
                                            	name = $("#td_"+key).html();
						custom_alert_popup("Total value of all Vestings for " + name + " should be equal to 100");
						flag = true;
						return false;
					}
				}				
			}
			else
			{
                             if(total_vesting_val != "100")
				{
                                       name = $("#td_"+key).html();
					custom_alert_popup("Total value of all Vestings for " + name + " should be equal to 100");
					flag = true;
					return false;
				}
			}			
		});
           
	if(flag)
	{
		return false;	
	}
        else {
            if(chkdtval()===false)
            {
                return false;
            }
        }
	
	
	$("#hf_show_next_step").val(is_next_step);
	<?php /*?>$("#btnAdd_2nd" ).trigger( "click" );<?php */?>
	$( "#frm_rule_step2" ).submit();
}
function chkdtval()
{
    var flg1=0;
    var flg2=0;
    var flg3=0;
    var flg4=0;
    var flg5=0;
    var flg6=0;
    var flg7=0;
    console.log('hiii');
    $(".tvv1").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     if(val!=='')
     {
         flg1=1;
     }
     //console.log('1-'+val);
    });
    
   if(flg1===1)
   {
       if($('#date0').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 1 ');
        return false;
       }
   }
   $(".tvv2").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     
     if(val!=='')
     {
         flg2=1;
     }
      
    });
   if(flg2 ===1)
   {
      
       if($('#date1').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 2 ');
        
        return false;
       }
       
       	
   }
    $(".tvv3").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     
     if(val!=='')
     {
         flg3=1;
     }
      
    });
   if(flg3 ===1)
   {
      
       if($('#date2').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 3 ');
        
        return false;
       }
       
       	
   }
    $(".tvv4").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     
     if(val!=='')
     {
         flg4=1;
     }
      
    });
   if(flg4 ===1)
   {
      
       if($('#date3').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 4 ');
        
        return false;
       }
       
       	
   }
   $(".tvv5").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     
     if(val!=='')
     {
         flg5=1;
     }
      
    });
   if(flg5 ===1)
   {
      
       if($('#date4').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 5 ');
        
        return false;
       }
       
       	
   }
   $(".tvv6").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     
     if(val!=='')
     {
         flg6=1;
     }
      
    });
   if(flg6 ===1)
   {
      
       if($('#date5').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 6 ');
        
        return false;
       }
       
       	
   }
   $(".tvv7").each( function(key, v)
    {
     var val='';   
     val= $(this).val(); 
     
     if(val!=='')
     {
         flg7=1;
     }
      
    });
   if(flg7 ===1)
   {
      
       if($('#date6').val()==='')
       {
        custom_alert_popup('Please enter vesting date for vesting 7 ');
        
        return false;
       }
       
       	
   }
    
}
<?php /*?>function rv()
{
	$("input[name='txt_vesting_val_1[]']").each( function(key, v)
	{	
		for(var i=1; i<=7; i++)
		{
			if($("input[name='txt_vesting_val_"+i+"[]']").eq(key).val()=='')
			{
				$("input[name='txt_vesting_val_"+i+"[]']").eq(key).val('0');
			}
		}
		if($("input[name='txt_grant_val[]']").eq(key).val()=='')
		{
			$("input[name='txt_grant_val[]']").eq(key).val('0');
		}
	});
}
rv();<?php */?>



    $( ".date_for_vestings" ).datepicker({ 
    dateFormat: 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
       // yearRange: "1995:new Date().getFullYear()",
     });      
 $('form').attr( "autocomplete", "off" );
</script> 
