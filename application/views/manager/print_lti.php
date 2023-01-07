<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title><?php echo $title; ?></title>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <link href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/samshul.css"); ?>" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        @page
        {
          size: landscape;
          margin: 1cm;
        }

        .form_head {
            padding: 1% 3% 1% 3%;    
        }
        .form_title h4{
            background-color: #f2f2f2;
        }
        .table{
            width: 100%;
        }
        .m0{margin: 0px !important;}
    </style>
        
    <style type="text/css" media="print">
      @page
      {
        size: landscape;
        margin: 1cm;
      }
    </style>
</head>
<body>
    <div class="container-fluid borderCon">
      <div class="row">
          <div class="col-md-12">
            <div class="form_head">
                <div class="clearfix table-responsive">
                    <div class="form_tittle ">
                        <h4>LTI Rule Filters</h4>
                    </div>
                    <table class="table table-bordered">
                      <tr>
                          <td>Country</td>
                          <td><?php echo $rule_dtls['country_names']; ?> </td>
                      </tr>
                      <tr>
                          <td> City </td>
                          <td><?php echo $rule_dtls['city_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Bussiness Level 1</td>
                          <td><?php echo $rule_dtls['bl1_names']; ?></td>
                      </tr>
                        <tr>
                          <td>Bussiness Level 2</td>
                          <td><?php echo $rule_dtls['bl2_names']; ?></td>
                      </tr>
                       <tr>
                          <td>Bussiness Level 3</td>
                          <td><?php echo $rule_dtls['bl3_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Function</td>
                          <td><?php echo $rule_dtls['function_names']; ?></td>
                      </tr>
                      <tr>
                          <td> Sub Function </td>
                          <td><?php echo $rule_dtls['sub_function_names']; ?></td>
                      </tr>
                      <tr>
                          <td> Designation </td>
                          <td><?php echo $rule_dtls['designation_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Grade</td>
                          <td><?php echo $rule_dtls['grade_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Level</td>
                          <td><?php echo $rule_dtls['level_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Education</td>
                          <td><?php echo $rule_dtls['education_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Critical Talent</td>
                          <td><?php echo $rule_dtls['critical_talent_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Critical Position</td>
                          <td><?php echo $rule_dtls['critical_position_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Special Category</td>
                          <td><?php echo $rule_dtls['special_category_names']; ?></td>
                      </tr>
                      <tr>
                          <td>Tenure in the company</td>
                          <td><?php echo $rule_dtls['tenure_company']; ?></td>
                      </tr>
                      <tr>
                          <td> Tenure in the Role </td>
                          <td><?php echo $rule_dtls['tenure_roles']; ?></td>
                      </tr>
                      <tr>
                          <td> Cutoff Date </td>
                          <td><?php echo HLP_DateConversion($rule_dtls['cutoff_date']); ?></td>
                      </tr>
                    </table> 
                </div>
                <br/>

                <div class="clearfix table-responsive">
                  <div class="form_tittle ">
                      <h4>Step One</h4>
                  </div>
                  <table class="table table-bordered">
                    <tr>
                      <td>Plan Name</td>
                      <td><?php echo ucfirst($rule_dtls["name"]); ?></td>
                    </tr>
                    <tr>
                      <td>Rule Name</td>
                      <td><?php echo ucfirst($rule_dtls["rule_name"]); ?></td>
                    </tr>
                  </table>
                </div>
                <br/>

                <div class="clearfix table-responsive">
                  <div class="form_tittle ">
                     <h4>Step Two</h4>
                  </div>
                  <table class="table table-bordered">
                    <tr>
                        <td>LTI Linked with</td>
                        <td><?php echo $rule_dtls["lti_linked_with"]; ?></td>
                    </tr>
                    <tr>
                        <td>LTI Grant Baseline</td>
                        <td><?php if($rule_dtls['lti_basis_on'] == 1){ echo 'Linked To Salary Elements';  } if($rule_dtls['lti_basis_on']==2){ echo 'Fixed Amount';} ?></td>
                    </tr>
                    <?php if(isset($rule_dtls['salary_applied_on_elem_list']) && $rule_dtls['salary_applied_on_elem_list']!='') { ?>
                    <tr>
                        <td>Salary Elements</td>
                        <td><?php echo $rule_dtls['salary_applied_on_elem_list']; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>LTI Differentiation To Be Based On</td>
                        <td><?php echo $rule_dtls['target_lti_on'] ?></td>
                    </tr>
                  </table>
                  <div class="form_tittle ">
                     <h4>MANAGER'S DISCRETION</h4>
                  </div>
                  <table class="table table-bordered">
                      <tr>
                        <td>Manager's discretionary increase</td>
                        <td>-<?php echo $rule_dtls["manager_discretionary_decrease"]; ?>, +<?php echo $rule_dtls["manager_discretionary_increase"]; ?></td>
                      </tr>
                  </table>
                </div>
                <br/>

                <div class="clearfix table-responsive">    
                    <div class="form_tittle ">
                        <h4>Step Three</h4>
                    </div>
                    <table class="table table-bordered">
                      <tbody>
                          <?php
                            if($rule_dtls['vesting_date_dtls'])
                            { $vesting_dates_arr = json_decode($rule_dtls['vesting_date_dtls'], true);
                          ?>
                          <tr>
                              <th style="min-width:85px;" colspan="2">Vesting Dates </th>                            
                              <td><?php echo (isset($vesting_dates_arr[0]))? $vesting_dates_arr[0]:''; ?></td>
                              <td><?php echo (isset($vesting_dates_arr[1]))? $vesting_dates_arr[1]:''; ?></td>
                              <td><?php echo (isset($vesting_dates_arr[2]))? $vesting_dates_arr[2]:''; ?></td>
                              <td><?php echo (isset($vesting_dates_arr[3]))? $vesting_dates_arr[3]:''; ?></td>
                              <td><?php echo (isset($vesting_dates_arr[4]))? $vesting_dates_arr[4]:''; ?></td>
                              <td><?php echo (isset($vesting_dates_arr[5]))? $vesting_dates_arr[5]:''; ?></td>
                              <td><?php echo (isset($vesting_dates_arr[6]))? $vesting_dates_arr[6]:''; ?></td>
                          </tr>
                          <?php } ?>
                          <?php $i=0; $j=0;
                            if($target_lti_elements)
                            { 
                              $target_lti_dtl_arr = "";
                              if($rule_dtls['target_lti_dtls'])
                              {
                                $target_lti_dtl_arr = json_decode($rule_dtls['target_lti_dtls'], true);
                                //echo "<pre>";print_r($target_lti_elements);die;
                              }
                              foreach($target_lti_elements as $row){
                              if($rule_dtls['lti_linked_with']=="Stock Value" and $i == 0){ ?>
                              <tr>
                                  <th>Period</th>
                                  <th>Current Stock Value</th>
                                  <th>Vesting-1</th>
                                  <th>Vesting-2</th>
                                  <th>Vesting-3</th>
                                  <th>Vesting-4</th>
                                  <th>Vesting-5</th>
                                  <th>Vesting-6</th>
                                  <th>Vesting-7</th>
                              </tr>
                              <tr>
                                  <th style="min-width:85px;">Stock Price</th>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?></td>
                                  <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?></td>
                              </tr>
                              <?php $i++; }  if($j==0){ ?>
                                 <tr>
                                    <th><?php echo ucfirst($rule_dtls['target_lti_on']); ?></th>
                                    <th><?php if($rule_dtls['lti_basis_on']==2){echo "Fixed Amount";}else{echo "Salary Percentage";} ?></th>
                                    <th>Vesting-1</th>
                                    <th>Vesting-2</th>
                                    <th>Vesting-3</th>
                                    <th>Vesting-4</th>
                                    <th>Vesting-5</th>
                                    <th>Vesting-6</th>
                                    <th>Vesting-7</th>
                                  </tr>
                              <?php } ?>  
                              <tr>
                                <td style="min-width:85px;" id="td_<?php echo $i; ?>"><?php $name_arr = explode(CV_CONCATENATE_SYNTAX, $row); echo $name_arr[1]; ?></td>
                                <td> <?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[0]["grant_value_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[1]["vesting_1_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[2]["vesting_2_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[3]["vesting_3_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[4]["vesting_4_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[5]["vesting_5_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[6]["vesting_6_arr"][$i]; ?></td>
                                <td><?php if($target_lti_dtl_arr) echo $target_lti_dtl_arr[7]["vesting_7_arr"][$i]; ?></td>
                              </tr>
                              <?php $i++;$j++;} }?>
                      </tbody>
                    </table>
                </div>
                <br/>

                <div class="clearfix table-responsive"> 
                  <div class="form_tittle ">
                      <h4>Step Four</h4>
                  </div>
                  <table class="table table-bordered m0">
                      <tr>
                          <td>Overall budget allocated</td>
                          <td><?php echo $rule_dtls["budget_type"] ?></td>
                          <?php if(isset($currencys[0])) { ?>
                          <td><?php echo (!empty($currencys[0]['display_name'])) ? $currencys[0]['display_name'] : $currencys[0]['name']; ?></td>
                        <?php } ?>
                      </tr>
                  </table>
                  <div class="form-group" id="dv_budget_manual" >
                      
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>          

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <?php if($this->session->userdata('is_manager_ses')==0){ ?>
    <script type="text/javascript">
        $(function(){
            show_hide_budget_dv('<?php echo $rule_dtls["budget_type"]; ?>', '<?php echo $rule_dtls["to_currency_id"]; ?>', '1');
        });

        function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
        {
            $("#dv_budget_manual").html("");
            $("#dv_budget_manual").hide();
            $("#dv_submit_3_step").hide();

            if(val != '')
            {
                $.post("<?php echo site_url("lti_rule/get_managers_for_manual_bdgt/1");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
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
                  
                          var r=1;
                          if(val=='Manual')
                          {
                            //$("input[name='txt_manual_budget_amt[]']").each( function (key, v)
                            $("input[name='hf_managers[]']").each( function (key, v)
                            {
                              //$(this).val(Math.round(items[i]).toLocaleString());
                              //$(this).prop('readonly',true);;
                              $("#dv_manual_budget_"+ r).html(Math.round(items[i]).toLocaleString());
                              calculat_percent_increased_val(1, items[i], (i+1));
                              i++;    r++;
                            });
                            calculat_total_revised_bgt();
                          }
                          if(val=='Automated but x% can exceed')
                          {
                            //$("input[name='txt_manual_budget_per[]']").each( function (key, v)
                            $("input[name='hf_managers[]']").each( function (key, v)
                            {
                              //$(this).val(Math.round(items[i]).toLocaleString());
                              //$(this).prop('readonly',true);;
                              $("#dv_x_per_budget_"+ r).html(items[i]);
                              calculat_percent_increased_val(2, items[i], (i+1));
                              i++;    r++;
                            });
                            calculat_total_revised_bgt();
                          }
                        }       
                    } else {
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

        function calculat_percent_increased_val(typ, val, index_no)
        {
            //var cncy= $('#th_total_budget').html();
            //var curncy=cncy.split(' ');
          if(typ==1)
          {
            //$("#td_revised_bdgt_"+ index_no).html(val);
            $("#td_revised_bdgt_"+ index_no).html(val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")); 
            var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
            $("#td_increased_amt_"+ index_no).html(increased_amt+' %'); 
          }
          else if(typ==2)
          {
            var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100;
            var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
            //$("#td_revised_bdgt_"+ index_no).html(revised_bdgt);  
            $("#td_revised_bdgt_"+ index_no).html(revised_bdgt.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
            $("#td_increased_amt_"+ index_no).html(increased_amt+' %'); 
          }
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
        }
    </script>

    <?php } else { ?>
    <script type="text/javascript">
        function show_hide_budget_dv(val, to_currency, is_need_pre_fill)
        {
            $("#dv_budget_manual").html("");
            $("#dv_budget_manual").hide();
            $("#dv_submit_3_step").hide();

            if(val != '')
            {
                $.get("<?php echo site_url("printview/get_managers_for_manual_bdgt_lti");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
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
                    } else {
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
                    $('input').attr("disabled","disabled");
                });
            }
        }

        $(function(){
            show_hide_budget_dv('<?php echo $rule_dtls["budget_type"]; ?>', '<?php echo $rule_dtls["to_currency_id"]; ?>','1');
            
        });
    </script>
    <?php } ?>
</body>
</html>

