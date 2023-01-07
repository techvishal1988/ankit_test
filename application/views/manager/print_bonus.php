<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title><?php echo $title; ?></title>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <link href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/samshul.css"); ?>" rel="stylesheet" type="text/css"/>

</head>
<body>
    <div class="container-fluid borderCon">
      <div class="row">
          <div class="col-md-12">
            <div class="form_head">
              <div class="clearfix table-responsive">
                <div class="form_tittle ">
                  <h4>Bonus Rule Filters</h4>
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
                        <td>Bussiness Level 1 Achievement</td>
                        <td><?php echo $rule_dtls['bl1_names']; ?></td>
                    </tr>
                      <tr>
                        <td>Bussiness Level 2 Achievement</td>
                        <td><?php echo $rule_dtls['bl2_names']; ?></td>
                    </tr>
                     <tr>
                        <td>Bussiness Level 3 Achievement</td>
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
                        <td> Sub Sub Function </td>
                        <td><?php echo $rule_dtls['sub_subfunction_names']; ?></td>
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
                    <td><?php echo CV_BONUS_SIP_LABEL_NAME; ?> Rule Name</td>
                    <td><?php echo ucfirst($rule_dtls["bonus_rule_name"]); ?></td>
                  </tr>
                  <tr>
                      <td>Apply prorated increase calculations</td>
                      <td><?php echo ucfirst($rule_dtls["prorated_increase"]); ?></td>
                  </tr>
                  <tr>
                      <td>Performance period for pro-rated calculations</td>
                      <td><?php 
                            if($rule_dtls["start_dt"] != '0000-00-00' && $rule_dtls["end_dt"] != '0000-00-00')
                            echo HLP_DateConversion($rule_dtls["start_dt"]).'&nbsp; to &nbsp;'.HLP_DateConversion($rule_dtls["end_dt"]);
                          ?>
                      </td>
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
                      <td>Target <?php echo CV_BONUS_SIP_LABEL_NAME; ?> calculation as a %Age of a salary element</td>
                      <td><?php echo ucfirst($rule_dtls["target_bonus"]); ?></td>
                  </tr>
                  <?php if($rule_dtls["target_bonus"] == 'yes'){ ?>
                  <tr id="dv_target_bonus_on">
                      <td><?php echo CV_BONUS_SIP_LABEL_NAME; ?> applicable on salary elements</td>
                      <td>
                        <?php echo $rule_dtls["bonus_applied_on_elem_list"];
                         /*if($bonus_applied_on_elem_list){
                              $bonus_applied_on_elements = "";
                              if(isset($rule_dtls['bonus_applied_on_elements']))
                              {
                                  $bonus_applied_on_elements = explode(",", $rule_dtls['bonus_applied_on_elements']);
                              }
                              $ba='';
                              foreach($bonus_applied_on_elem_list as $row){ ?>
                              <?php if(($bonus_applied_on_elements) and in_array($row["business_attribute_id"], $bonus_applied_on_elements))
                                      $ba.=$row["display_name"].', ';   
                              }} echo rtrim($ba,', ');*/ ?>
                      </td>
                  </tr>
                  <tr>
                      <td>Target <?php echo CV_BONUS_SIP_LABEL_NAME; ?> %age or Amount</td>
                      <td><?php echo ($rule_dtls['target_bonus_elem_value_type'] == 1)?"Percentage":"Amount";?></td>
                  </tr>
                  <tr>
                      <td>Target <?php echo CV_BONUS_SIP_LABEL_NAME; ?> based on</td>
                      <td><?php echo ucfirst($rule_dtls["target_bonus_on"]); ?></td>
                  </tr>
                  <?php } ?>
                </table>
                <div id="dv_target_bonus_elem" style="display:none;"> </div>
              </div>
              <br/>

              <?php /* if(isset($bussiness_levels) && count($bussiness_levels)>0){
                $i = 0; foreach($bussiness_levels as $attrKey=>$attrName){ ?>

              <div class="clearfix table-responsive">
                <div class="form_tittle">
                    <h4><?php echo $attrName['display_name']; ?></h4>
                </div>
                <table class="table table-bordered">
                    <?php if(isset($attrName['bussiness_level_values']) && count($attrName['bussiness_level_values'])>0){                            
                        foreach($attrName['bussiness_level_values'] as $subAttr){ ?>
                        <tr>
                            <td><?php echo $subAttr['value']; ?></td>
                            <td><?php if($rule_dtls["business_level_achievement"])
                                      {
                                        $old_bl_arr = json_decode($rule_dtls["business_level_achievement"],true);
                                        foreach($old_bl_arr as $bl_key=> $bl_val)
                                        { 
                                            $bl_key_arr = explode(CV_CONCATENATE_SYNTAX, $bl_key);
                                            if($bl_key_arr[0]==$subAttr['business_attribute_id']){echo $bl_val; continue;}
                                        }
                                      } ?>
                            </td>
                        </tr>
                       <?php } } ?> 
                </table>
              </div>
              <?php $i++;} echo "<br/>"; } */ ?> 
              
              <div id="dv_achievements_elements" style="display:none; pointer-events:none;"> </div>

              <div class="clearfix table-responsive">
                <div class="form_tittle">
                    <h4>PERFORMANCE BASED <?php echo CV_BONUS_SIP_LABEL_NAME; ?> MULTIPLIER </h4>
                </div>
                <table class="table table-bordered">
                  <?php  $v=json_decode($rule_dtls["performnace_based_hike_ratings"]);
                    if(!empty($rule_dtls['performance_type'])) {
                        $type_performance = 'Achievement &#37;age Wise';
                        if($rule_dtls['performance_type'] == 1) {
                            $type_performance = 'Rating Wise';
                        }
                    } else {
                        $type_performance = '';
                    }
                    echo '<tr><td>Performance Type</td><td>'.$type_performance.'</td></tr>';
                    if($rule_dtls['performance_type'] == 1){
                      foreach($v as $key=>$val)
                      {
                        $vv=explode(CV_CONCATENATE_SYNTAX,$key);
                        echo '<tr><td>'.$vv[1].'</td><td>'.$val.'</td></tr>';
                      }
                    } elseif ($rule_dtls['performance_type'] == 2) {

                      echo '<tr class="dv_performance_achievements_rang"><td>Define Payout Multiplier for each other ranges</td><td>'.(($rule_dtls['performance_achievements_multiplier_type'] == '1')? "Single Multiplier" : "Decelerated or Accelerated Multiplier" ).'</td></tr>';
                      if($rule_dtls['performance_achievement_rangs']){
                        $rangs_arr = json_decode($rule_dtls["performance_achievement_rangs"], true);
                          foreach($rangs_arr as $row)
                          { 
                            echo '<tr class="dv_performance_achievements_rang"><td></td><td>'.$row['max'].'</td></tr>'; 
                          }
                      }
                    }

                  ?>
                </table>
                <?php if($rule_dtls['performance_type'] == 2) { ?>
                <table class="table table-bordered dv_performance_achievements_rang">
                  <thead>
                    <tr>
                      <th>Performance Range</th>
                      <th>Define <?php if($rule_dtls["performance_achievements_multiplier_type"]==2){echo "Accelerated / Decelerated";}else{ echo "Single Multiplier (In %)"; } ?> for each range</th>
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
                              <td><input  type="text" id="txt_perfo_achie_rangs_<?php echo $i; ?>" name="txt_perfo_achie_rangs[]" class="form-control w_unset" required onKeyUp="validate_negative_percentage_onkeyup_common(this);" onBlur="validate_negative_percentage_onblure_common(this);" maxlength="5" value="<?php echo $multipliers_val; ?>" style="text-align:center;" /></td>
                            </tr>
                            
                            <?php if(($i+1) == count($rangs_arr))
                              {
                                  if(isset($multipliers_arr[$i+1]))
                                  { 
                                      $multipliers_val = $multipliers_arr[$i+1];
                                  }
                                  echo '<tr><td> > '.$row["max"].'</td><td><input  type="text" id="txt_perfo_achie_rangs_'. $i .'" name="txt_perfo_achie_rangs[]" class="form-control w_unset" required onKeyUp="validate_negative_percentage_onkeyup_common(this);" onBlur="validate_negative_percentage_onblure_common(this);" maxlength="5" value="'. $multipliers_val .'" style="text-align:center;" /></td>
                            </tr>';
                              } ?>
                            
                    <?php $i++; } ?>
                  </tbody>
                </table>
                <?php } ?>
              </div>

              <div class="clearfix table-responsive">
                <div class="form_tittle">
                    <h4>Manager's Discretionary</h4>
                </div>
                <table class="table table-bordered">
                    <tr>
                      <td>Flexibility managers can have while recommending salary review  </td>
                      <td>-<?php echo $rule_dtls["manager_discretionary_decrease"]; ?>, +<?php echo $rule_dtls["manager_discretionary_increase"]; ?></td>
                    </tr>
                </table>
              </div>

              <div class="clearfix table-responsive">
                <div class="form_tittle">
                    <h4>Budget Allocation</h4>
                </div>
                <table class="table table-bordered m0">
                  <tr>
                      <td>Overall budget allocated </td>
                      <td><?php echo $rule_dtls["overall_budget"] ?></td>
                      <?php if(isset($currencys[0])) { ?>
                      <td><?php echo ( !empty($currencys[0]['display_name'])) ? $currencys[0]['display_name'] : $currencys[0]['name']; ?></td>
                      <?php } ?>
                  </tr>
                </table>
                <div id="dv_budget_manual"></div>
              </div>
            </div>
          </div>
      </div>
    </div>


  <br />
  <br />
        <?php /* <div class="row">
      <div class="col-md-12 borderCon">
          
         <h4>BUSINESS LEVEL WEIGHTAGE</h4>
         <table class="table table-bordered">
             <?php foreach($bussiness_levels as $attrName){ ?>
             <tr>
                 <td><?php echo $attrName['display_name']; ?></td>
                 <td>
                     <?php if($rule_dtls["business_level"])
                                {
                                    $old_bl_arr = json_decode($rule_dtls["business_level"],true);
                                    foreach($old_bl_arr as $bl_key=> $bl_val)
                                    { 
                                        $bl_key_arr = explode(CV_CONCATENATE_SYNTAX, $bl_key);
                                        if($bl_key_arr[0]==$attrName['business_attribute_id']){echo $bl_val; continue;}
                                    }
                                    }?>
                 </td>
             </tr>
             <?php } ?>
             <tr>
                 <td>Function</td>
                 <td><?php $exp_arr = explode(".", $rule_dtls["function_weightage"]); if($exp_arr[1]>0){echo $rule_dtls["function_weightage"];}else{echo $exp_arr[0];} ?></td>
             </tr>
             <tr>
                 <td>Individual</td>
                 <td><?php $exp_arr = explode(".", $rule_dtls["individaul_bussiness_level"]); if($exp_arr[1]>0){echo $rule_dtls["individaul_bussiness_level"];}else{echo $exp_arr[0];} ?></td>
             </tr>
          </table>
         </div>
      </div>

    <br />
                  <div class="row">
      <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
      <div class="form_tittle ">
                <h4>Function Achievements</h4>
      </div>
                <?php if(isset($functions) && count($functions)>0){ $i = 0;                              
                       foreach($functions as $row){ ?>
              <table class="table table-bordered">
                  <tr>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php if($rule_dtls["function_achievement"])
                              {
                                  $old_fa_arr = json_decode($rule_dtls["function_achievement"],true);
                                  foreach($old_fa_arr as $fa_key=> $fa_val)
                                  { 
                                      $fa_key_arr = explode(CV_CONCATENATE_SYNTAX, $fa_key);
                                      if($fa_key_arr[0]==$row['id']){echo $fa_val; continue;}
                                  }
                                  }?>
                      </td>
                  </tr>
                    
                <?php } ?> </table><?php ?>
                <?php $i++; } ?>
              </div>
      </div>
  </div> */ ?>
            
          
  <script src="<?php echo base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
  
      function get_target_bonus_elem()
      {   
          var target_bonus = '<?php echo $rule_dtls['target_bonus']; ?>';
          var elem_for = '<?php echo $rule_dtls['target_bonus_on']; ?>';
          var elem_value_type = '<?php echo $rule_dtls['target_bonus_elem_value_type']; ?>';
        
          $("#dv_achievements_elements").html("");
          $("#dv_achievements_elements").hide();
        
          $("#dv_target_bonus_elem").html("");
          $("#dv_target_bonus_elem").hide();
          
          var json_elem_arr = '<?php echo $rule_dtls["target_bonus_dtls"]; ?>';
          
          if(target_bonus == "yes"  || target_bonus == "no")
          {
              $.post("<?php echo site_url("printview/get_target_bonus_elements/".$rule_dtls["id"]);?>",{elem_for: elem_for, elem_value_type: elem_value_type}, function(data)
              {
                  if(data)
                  {
                      $("#dv_target_bonus_elem").html(data);
                      $("#dv_target_bonus_elem").show();
              
                      if(target_bonus == "yes" && (elem_for))
                      {             
                        if(json_elem_arr)
                        {
                          var i = 0;
                          var bl1_arr = ('<?php echo $rule_dtls["bl_1_weightage"]; ?>').split(",");         
                          var bl2_arr = ('<?php echo $rule_dtls["bl_2_weightage"]; ?>').split(",");
                          var bl3_arr = ('<?php echo $rule_dtls["bl_3_weightage"]; ?>').split(",");
                          var funct_arr = ('<?php echo $rule_dtls["function_weightage"]; ?>').split(",");
                          var sub_funct_arr = ('<?php echo $rule_dtls["sub_function_weightage"]; ?>').split(",");
                          var sub_subfunct_arr = ('<?php echo $rule_dtls["sub_subfunction_weightage"]; ?>').split(",");
                          var indivi_arr = ('<?php echo $rule_dtls["individual_weightage"]; ?>').split(",");
                          
                          $.each(JSON.parse(json_elem_arr),function(key,vall)
                          {
                            var elem_arr = key.split('<?php echo CV_CONCATENATE_SYNTAX; ?>');
                            $("#txt_target_elem_"+elem_arr[0]).val(vall);
                            $("#txt_bl1_weight_"+elem_arr[0]).val(bl1_arr[i]);
                            $("#txt_bl2_weight_"+elem_arr[0]).val(bl2_arr[i]);
                            $("#txt_bl3_weight_"+elem_arr[0]).val(bl3_arr[i]);
                            $("#txt_funct_weight_"+elem_arr[0]).val(funct_arr[i]);
                            $("#txt_sub_funct_weight_"+elem_arr[0]).val(sub_funct_arr[i]);
                            $("#txt_sub_subfunct_weight_"+elem_arr[0]).val(sub_subfunct_arr[i]);
                            $("#txt_indivi_weight_"+elem_arr[0]).val(indivi_arr[i]);
                            i++;
                          });
                          get_achievements_elements();
                        }
                      } else {
                        var bl_1_weightage_arr = '<?php echo $rule_dtls["bl_1_weightage"]; ?>';
                        if(bl_1_weightage_arr)
                        {
                          var bl1_arr = ('<?php echo $rule_dtls["bl_1_weightage"]; ?>').split(",");         
                          var bl2_arr = ('<?php echo $rule_dtls["bl_2_weightage"]; ?>').split(",");
                          var bl3_arr = ('<?php echo $rule_dtls["bl_3_weightage"]; ?>').split(",");
                          var funct_arr = ('<?php echo $rule_dtls["function_weightage"]; ?>').split(",");
                          var sub_funct_arr = ('<?php echo $rule_dtls["sub_function_weightage"]; ?>').split(",");
                          var sub_subfunct_arr = ('<?php echo $rule_dtls["sub_subfunction_weightage"]; ?>').split(",");
                          var indivi_arr = ('<?php echo $rule_dtls["individual_weightage"]; ?>').split(",");
                          
                          $("#txt_bl1_weightage").val(bl1_arr[0]);
                          $("#txt_bl2_weightage").val(bl2_arr[0]);
                          $("#txt_bl3_weightage").val(bl3_arr[0]);
                          $("#txt_funct_weightage").val(funct_arr[0]);
                          $("#txt_sub_funct_weightage").val(sub_funct_arr[0]);
                          $("#txt_sub_subfunct_weightage").val(sub_subfunct_arr[0]);
                          $("#txt_indivi_weightage").val(indivi_arr[0]);
                          
                          get_achievements_elements();
                        }
                      }
                      $("#tr_btn_put_achievement").hide();
                      $('input, textarea').attr("disabled","disabled");
                  }
              });
          }
          else
          {
              $("#dv_target_bonus_elem").html("");
              $("#dv_target_bonus_elem").hide();
          }
      }

      function get_achievements_elements()
      {
        $("#dv_achievements_elements").html("");
        $("#dv_achievements_elements").hide();
        var bl_1_achievment = 0;
        var bl_2_achievment = 0;
        var bl_3_achievment = 0;
        var function_achievment = 0;
        var sub_function_achievment = 0;
        var sub_subfunction_achievment = 0;
        
        var txt_bl_1_weightage=$("input[name='txt_bl_1_weightage[]']");
        var txt_bl_2_weightage=$("input[name='txt_bl_2_weightage[]']");
        var txt_bl_3_weightage=$("input[name='txt_bl_3_weightage[]']");
        var txt_function_weightage=$("input[name='txt_function_weightage[]']");
        var txt_sub_function_weightage=$("input[name='txt_sub_function_weightage[]']");
        var txt_sub_subfunction_weightage=$("input[name='txt_sub_subfunction_weightage[]']");
        
        $("input[name='txt_individual_weightage[]']").each( function (key, v)
        {   
          if(($(txt_bl_1_weightage[key]).val()*1) > 0)
          {
            bl_1_achievment = <?php echo CV_BUSINESS_LEVEL_ID_1 ?>;
          }
          if(($(txt_bl_2_weightage[key]).val()*1) > 0)
          {
            bl_2_achievment = <?php echo CV_BUSINESS_LEVEL_ID_2 ?>;
          }
          if(($(txt_bl_3_weightage[key]).val()*1) > 0)
          {
            bl_3_achievment = <?php echo CV_BUSINESS_LEVEL_ID_3 ?>;
          }
          if(($(txt_function_weightage[key]).val()*1) > 0)
          {
            function_achievment = <?php echo CV_FUNCTION_ID ?>;
          }
          if(($(txt_sub_function_weightage[key]).val()*1) > 0)
          {
            sub_function_achievment = <?php echo CV_SUB_FUNCTION_ID ?>;
          }
          if(($(txt_sub_subfunction_weightage[key]).val()*1) > 0)
          {
            sub_subfunction_achievment = <?php echo CV_SUB_SUB_FUNCTION_ID ?>;
          }   
        });
        if(bl_1_achievment > 0 || bl_2_achievment > 0 || bl_3_achievment > 0 || function_achievment > 0 || sub_function_achievment > 0 || sub_subfunction_achievment > 0)
        {
          var base_url = "<?php echo site_url("printview/get_achievements_elements/".$rule_dtls['id']);?>";
          var url = base_url +"/"+ bl_1_achievment +"/"+ bl_2_achievment +"/"+ bl_3_achievment +"/"+ function_achievment +"/"+ sub_function_achievment +"/"+ sub_subfunction_achievment;
          $.get(url, function(data)
          {
            if(data)
            {
              $("#dv_achievements_elements").html(data);
              $("#dv_achievements_elements").show();
            }
          });
        }
        else
        {
          custom_alert_popup("Please fill any weightage value first.");
        }
      }

      <?php if($this->session->userdata('is_manager_ses')==0){ ?>
      function show_hide_budget_dv(val, to_currency)
      {
          $("#dv_budget_manual").html("");
          $("#dv_budget_manual").hide();
          $("#dv_submit_2_step").hide();

          if(val != '')
          {
              $.post("<?php echo site_url("bonus/get_managers_for_manual_bdgt/1");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
              {
                  if(data)
                  {
                      $("#dv_budget_manual").html(data);
                      $("#dv_budget_manual").show();
                      
                      var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
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
                          //$(this).val(items[i].toLocaleString());
                          //$(this).prop('disabled',true);
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
                          //$(this).val(items[i]);
                          //$(this).prop('disabled',true);
                          $("#dv_x_per_budget_"+ r).html(items[i]);
                          calculat_percent_increased_val(2, items[i], (i+1));
                          i++;    r++;
                        });
                        calculat_total_revised_bgt();
                      }  
                      $('input, textarea').attr("disabled","disabled");            
                  }
              });
          }
      }

      function calculat_percent_increased_val(typ, val, index_no)
      {
        if(typ==1)
        {
          $("#td_revised_bdgt_"+ index_no).html(Math.round(val).toLocaleString());  
          var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
          $("#td_increased_amt_"+ index_no).html(increased_amt+' %'); 
        }
        else if(typ==2)
        {
          var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100;
          var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
          $("#td_revised_bdgt_"+ index_no).html(Math.round(revised_bdgt).toLocaleString()); 
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
        var per = (val/$("#hf_total_target_bonus").val()*100).toFixed(2);
        $("#th_final_per").html(per + ' %');
        
        var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $("#th_total_budget").html(formated_val);
        $("#th_total_budget_manual").html(formated_val);
      }

      <?php } else { ?>
        function show_hide_budget_dv(val, to_currency)
        {
            $("#dv_budget_manual").html("");
            $("#dv_budget_manual").hide();
            $("#dv_submit_2_step").hide();

            if(val != '')
            {
                $.get("<?php echo site_url("printview/get_managers_for_manual_bdgt_bonus");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
                {
                    if(data)
                    {
                        $("#dv_budget_manual").html(data);
                        $("#dv_budget_manual").show();
                        
                        var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
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
                            $(this).prop('disabled',true);;
                            i++;    
                          });
                        }
                        if(val=='Automated but x% can exceed')
                        {
                          $("input[name='txt_manual_budget_per[]']").each( function (key, v)
                          {
                            $(this).val(items[i]);
                            $(this).prop('disabled',true);;
                            i++;    
                          });
                        }              
                    }
                  $('input, textarea').attr("disabled","disabled");
                });
            }
        }
      <?php } ?>
      show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', <?php echo $rule_dtls["to_currency_id"]; ?>); 
      get_target_bonus_elem();
      $('input, textarea').attr("disabled","disabled");
  </script>
<?php /* ?>
<script type="text/javascript">
function manage_function_achievements()
{
   var function_weightage_val = $("#txt_function_weightage").val();
   if(function_weightage_val > 0)
   {
    $("#dv_function_achievement").show();
   }
   else
   {
     $("#dv_function_achievement").hide();
   }
}

function manage_business_level_achievements()
{
  $("input[name='txtbusiness_level[]']").each( function (key, v)
  {
    var bl_weightage_val = $(this).val();
    var ba_id = $(this).attr('lang');
    if(bl_weightage_val > 0)
    {
      $("#dv_business_level_achievement_"+ba_id).show();
    }
    else
    {
      $("#dv_business_level_achievement_"+ba_id).hide();
    }
  });
   
}

function show_remark_dv()
{
  var conf = confirm("Are you sure, You want to reject this request ?");
  if(!conf)
  {
    return false;
  }
  $("#hf_req_for").val('1');
  $("#dv_reject_btn").hide();
  $("#dv_delete_btn").show();
  $("#dv_remark").show();
  $("#dv_remrk_submit_btn").show();
}
function show_remark_dv_on_delete()
{
  var conf = confirm("Are you sure, You want to delete this rule ?");
  if(!conf)
  {
    return false;
  }
  $("#hf_req_for").val('2');
  $("#dv_reject_btn").show();
  $("#dv_delete_btn").hide();
  $("#dv_remark").show();
  $("#dv_remrk_submit_btn").show();
} 

function manage_performnace_based_hikes(val)
{
    $("#txt_rating1").prop('required',false);
    $("#dv_rating_list_yes").hide();
    $("#dv_rating_list_no").hide();
    $("#dv_rating_list_yes").html("");
    
    var jsonRating = '<?php echo $rule_dtls["performnace_based_hike_ratings"]; ?>';
    var i = 0;
    var items = [];
    if(jsonRating)
    {
        $.each(JSON.parse(jsonRating),function(key,vall){
            items.push(vall);
        });
    }   

    if(val=='yes')

    {

        var pid = $("#hf_performance_cycle_id").val();

        $.post("<?php echo site_url("manager/dashboard/get_ratings_list_bonus");?>",{pid:pid,txt_name:'rating'}, function(data)

        {

            if(data)

            {

                $("#dv_rating_list_yes").html(data);
                $("input[name='ddl_market_salary_rating[]']").each( function (key, v)
                {
                    $(this).val(items[i]);
          $(this).prop('disabled',true);
                    i++;    
                });
                $("#dv_rating_list_yes").show();

            }
            else
            {
                $("#ddl_performnace_based_hikes").val('no');
                $("#txt_rating1").prop('required',true);
                $("#dv_rating_list_no").show();
                $("#common_popup_for_alert").html('<div align="left" style="color:blue;" id="notify"><span><b>No rating available.</b></span></div>');
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

    else if(val=='no')
    {
        $("#txt_rating1").prop('required',true);
        $("#txt_rating1").val(items[i]);
        $("#dv_rating_list_no").show();

    }

}

show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>'); 
function show_hide_budget_dv(val)
{
    $("#dv_budget_manual").html("");
    $("#dv_budget_manual").hide();
    $("#dv_submit_2_step").hide();

    if(val != '')
    {
        $.post("<?php echo site_url("printview/get_managers_for_manual_bdgt_bonus");?>",{budget_type: val, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
        {
            if(data)
            {
                $("#dv_budget_manual").html(data);
                $("#dv_budget_manual").show();
                
        var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
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
            $(this).prop('disabled',true);;
            i++;    
          });
        }
        if(val=='Automated but x% can exceed')
        {
          $("input[name='txt_manual_budget_per[]']").each( function (key, v)
          {
            $(this).val(items[i]);
            $(this).prop('disabled',true);;
            i++;    
          });
        }              
            }
          
        });
    }
}

function get_target_bonus_elem()
{   
    var target_bonus = $("#ddl_target_bonus").val();
    var elem_for = $("#ddl_target_bonus_on").val();
  var elem_value_type = $("#ddl_target_bonus_elem_value_type").val();
  
  $("#dv_achievements_elements").html("");
  $("#dv_achievements_elements").hide();
  
  $("#dv_target_bonus_elem").html("");
    $("#dv_target_bonus_elem").hide();
    
    var json_elem_arr = '<?php echo $rule_dtls["target_bonus_dtls"]; ?>';
    // var i = 0;
    // var items = [];
    // if(json_elem_arr)
    // {
    //     $.each(JSON.parse(json_elem_arr),function(key,vall){
    //         items.push(vall);
    //     });
    // }  
    
    if(target_bonus == "yes"  || target_bonus == "no")
    {
        $.post("<?php echo site_url("bonus/get_target_bonus_elements/".$rule_dtls["id"]);?>",{elem_for: elem_for, elem_value_type: elem_value_type}, function(data)
        {
            if(data)
            {
                $("#dv_target_bonus_elem").html(data);
                $("#dv_target_bonus_elem").show();
                
                
                /*$("input[name='txt_target_bonus_elem[]']").each( function (key, v)
                {
                    $(this).val(items[i]);
          $(this).prop('disabled',true);
                    i++;    
                });
        
        if(target_bonus == "yes" && (elem_for))
        {             
          if(json_elem_arr)
          {
            var i = 0;
            var bl1_arr = ('<?php echo $rule_dtls["bl_1_weightage"]; ?>').split(",");         
            var bl2_arr = ('<?php echo $rule_dtls["bl_2_weightage"]; ?>').split(",");
            var bl3_arr = ('<?php echo $rule_dtls["bl_3_weightage"]; ?>').split(",");
            var funct_arr = ('<?php echo $rule_dtls["function_weightage"]; ?>').split(",");
            var sub_funct_arr = ('<?php echo $rule_dtls["sub_function_weightage"]; ?>').split(",");
            var sub_subfunct_arr = ('<?php echo $rule_dtls["sub_subfunction_weightage"]; ?>').split(",");
            var indivi_arr = ('<?php echo $rule_dtls["individual_weightage"]; ?>').split(",");
            
            $.each(JSON.parse(json_elem_arr),function(key,vall)
            {
              var elem_arr = key.split('<?php echo CV_CONCATENATE_SYNTAX; ?>');
              $("#txt_target_elem_"+elem_arr[0]).val(vall);
              $("#txt_bl1_weight_"+elem_arr[0]).val(bl1_arr[i]);
              $("#txt_bl2_weight_"+elem_arr[0]).val(bl2_arr[i]);
              $("#txt_bl3_weight_"+elem_arr[0]).val(bl3_arr[i]);
              $("#txt_funct_weight_"+elem_arr[0]).val(funct_arr[i]);
              $("#txt_sub_funct_weight_"+elem_arr[0]).val(sub_funct_arr[i]);
              $("#txt_sub_subfunct_weight_"+elem_arr[0]).val(sub_subfunct_arr[i]);
              $("#txt_indivi_weight_"+elem_arr[0]).val(indivi_arr[i]);
              
              i++;
            });
            get_achievements_elements();
          }
        }
        else
        {
          var bl_1_weightage_arr = '<?php echo $rule_dtls["bl_1_weightage"]; ?>';
          if(bl_1_weightage_arr)
          {
            var bl1_arr = ('<?php echo $rule_dtls["bl_1_weightage"]; ?>').split(",");         
            var bl2_arr = ('<?php echo $rule_dtls["bl_2_weightage"]; ?>').split(",");
            var bl3_arr = ('<?php echo $rule_dtls["bl_3_weightage"]; ?>').split(",");
            var funct_arr = ('<?php echo $rule_dtls["function_weightage"]; ?>').split(",");
            var sub_funct_arr = ('<?php echo $rule_dtls["sub_function_weightage"]; ?>').split(",");
            var sub_subfunct_arr = ('<?php echo $rule_dtls["sub_subfunction_weightage"]; ?>').split(",");
            var indivi_arr = ('<?php echo $rule_dtls["individual_weightage"]; ?>').split(",");
            
            $("#txt_bl1_weightage").val(bl1_arr[0]);
            $("#txt_bl2_weightage").val(bl2_arr[0]);
            $("#txt_bl3_weightage").val(bl3_arr[0]);
            $("#txt_funct_weightage").val(funct_arr[0]);
            $("#txt_sub_funct_weightage").val(sub_funct_arr[0]);
            $("#txt_sub_subfunct_weightage").val(sub_subfunct_arr[0]);
            $("#txt_indivi_weightage").val(indivi_arr[0]);
            
            get_achievements_elements();
          }
        }
        $("#tr_btn_put_achievement").hide();
            }
        });
    }
    else
    {
        $("#dv_target_bonus_elem").html("");
        $("#dv_target_bonus_elem").hide();

    }
}

function get_achievements_elements()
{
  $("#dv_achievements_elements").html("");
  $("#dv_achievements_elements").hide();
  var bl_1_achievment = 0;
  var bl_2_achievment = 0;
  var bl_3_achievment = 0;
  var function_achievment = 0;
  var sub_function_achievment = 0;
  var sub_subfunction_achievment = 0;
  
  var txt_bl_1_weightage=$("input[name='txt_bl_1_weightage[]']");
  var txt_bl_2_weightage=$("input[name='txt_bl_2_weightage[]']");
  var txt_bl_3_weightage=$("input[name='txt_bl_3_weightage[]']");
  var txt_function_weightage=$("input[name='txt_function_weightage[]']");
  var txt_sub_function_weightage=$("input[name='txt_sub_function_weightage[]']");
  var txt_sub_subfunction_weightage=$("input[name='txt_sub_subfunction_weightage[]']");
  
  $("input[name='txt_individual_weightage[]']").each( function (key, v)
  {   
    if(($(txt_bl_1_weightage[key]).val()*1) > 0)
    {
      bl_1_achievment = <?php echo CV_BUSINESS_LEVEL_ID_1 ?>;
    }
    if(($(txt_bl_2_weightage[key]).val()*1) > 0)
    {
      bl_2_achievment = <?php echo CV_BUSINESS_LEVEL_ID_2 ?>;
    }
    if(($(txt_bl_3_weightage[key]).val()*1) > 0)
    {
      bl_3_achievment = <?php echo CV_BUSINESS_LEVEL_ID_3 ?>;
    }
    if(($(txt_function_weightage[key]).val()*1) > 0)
    {
      function_achievment = <?php echo CV_FUNCTION_ID ?>;
    }
    if(($(txt_sub_function_weightage[key]).val()*1) > 0)
    {
      sub_function_achievment = <?php echo CV_SUB_FUNCTION_ID ?>;
    }
    if(($(txt_sub_subfunction_weightage[key]).val()*1) > 0)
    {
      sub_subfunction_achievment = <?php echo CV_SUB_SUB_FUNCTION_ID ?>;
    }   
  });
  if(bl_1_achievment > 0 || bl_2_achievment > 0 || bl_3_achievment > 0 || function_achievment > 0 || sub_function_achievment > 0 || sub_subfunction_achievment > 0)
  {
    var base_url = "<?php echo site_url("bonus/get_achievements_elements/".$rule_dtls['id']);?>";
    var url = base_url +"/"+ bl_1_achievment +"/"+ bl_2_achievment +"/"+ bl_3_achievment +"/"+ function_achievment +"/"+ sub_function_achievment +"/"+ sub_subfunction_achievment;
    $.get(url, function(data)
    {
      if(data)
      {
        $("#dv_achievements_elements").html(data);
        $("#dv_achievements_elements").show();
      }
    });
  }
  else
  {
    alert("Please fill any weightage value first.");
  }

}

function show_target_bonus_elem()
{
    var target_bonus = $("#ddl_target_bonus").val();
    if(target_bonus == "yes")
    {
        $("#dv_target_bonus_on").show();        
    }
    else
    {
        $("#ddl_target_bonus_on").val("");
        $("#dv_target_bonus_elem").html("");
        $("#dv_target_bonus_elem").hide();
        $("#dv_target_bonus_on").hide();
    }
}


// function get_target_bonus_elem()
// {   
//     var target_bonus = $("#ddl_target_bonus").val();
//     var elem_for = $("#ddl_target_bonus_on").val();
    
//     var json_elem_arr = '<?php echo $rule_dtls["target_bonus_dtls"]; ?>';
//     var i = 0;
//     var items = [];
//     if(json_elem_arr)
//     {
//         $.each(JSON.parse(json_elem_arr),function(key,vall){
//             items.push(vall);
//         });
//     }   
    
//     if(target_bonus == "yes" && (elem_for))
//     {
//         $.post("<?php echo site_url("bonus/get_target_bonus_elements");?>",{elem_for: elem_for}, function(data)
//         {
//             if(data)
//             {
//                 $("#dv_target_bonus_elem").html(data);
//                 $("#dv_target_bonus_elem").show();
                
                
//                 $("input[name='txt_target_bonus_elem[]']").each( function (key, v)
//                 {
//                     $(this).val(items[i]);
//          $(this).prop('disabled',true);
//                     i++;    
//                 });
//             }
//         });
//     }
//     else
//     {
//         $("#dv_target_bonus_elem").html("");
//         $("#dv_target_bonus_elem").hide();

//     }
// }

</script>

<script type="text/javascript">

show_target_bonus_elem();
get_target_bonus_elem();
manage_performnace_based_hikes('<?php echo $rule_dtls['performnace_based_hike'];?>');

manage_function_achievements();
manage_business_level_achievements();
</script>

<?php */?>
</body>
</html>


    <style type="text/css">
        @page
        {
          size: landscape;
          margin: 1cm;
        }
        thead { display: table-header-group }
        tfoot { display: table-row-group }
        table thead tr {
            page-break-inside: avoid;
        }
        table tbody tr {
            page-break-inside: avoid;
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
        
        /******bonus print view css starts******/

        #dv_achievements_elements .form_head {
          border: none !important;
          padding: 0px !important;
        }
        #dv_achievements_elements .form_head .col-sm-12, #dv_achievements_elements .form_sec .col-sm-12{padding: 0px !important;}
        #dv_achievements_elements .form_sec .col-sm-12{ border-top: 1px solid #ddd; border-right: 1px solid #ddd; border-left: 1px solid #ddd; }
        #dv_achievements_elements .form_sec .col-sm-12:last-child{ border-bottom: 1px solid #ddd;}
        #dv_achievements_elements .form_sec > .col-sm-12 > .col-sm-6{ line-height: 30px; padding:8px; border-right: 1px solid #ddd;}
        #dv_achievements_elements .form_sec > .col-sm-12 > .col-sm-6:last-child{border-right: 0px solid #ddd;}
        #dv_achievements_elements .form_head ul{ padding-left: 0px; }
        #dv_achievements_elements .form_head ul li{list-style: none;}
        #dv_achievements_elements .form_head ul li .form_tittle{margin-bottom: 12px;}
        #dv_achievements_elements .form_head ul li .form_info{display: none;}
        
        /*****bonus print view css starts*******/

    </style>
        
    <style type="text/css" media="print">
      @page
      {
        size: landscape;
        margin: 1cm;
      }
    </style>