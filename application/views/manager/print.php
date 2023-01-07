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
                    <h4>Salary Rule Filters</h4>
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
              <br/><br/><br/>

              <div class="clearfix table-responsive">
                  <div class="form_tittle ">
                      <h4>DEFINE BASIC RULES</h4>
                  </div>
                  <table class="table table-bordered">
                    <tr>
                      <td width="40%">Plan Name</td>
                      <td  colspan="3"><?php echo ucfirst($rule_dtls["name"]); ?></td>
                    </tr>
                    <tr>
                      <td>Salary Rule Name</td>
                      <td  colspan="3"><?php echo ucfirst($rule_dtls["salary_rule_name"]); ?></td>
                    </tr>
                    <tr>
                      <td>Apply prorated increase calculations</td>
                      <td colspan="3"><?php echo ucfirst($rule_dtls["prorated_increase"]); ?></td>
                    </tr>
                    <?php if($rule_dtls["prorated_increase"]=="yes"){ ?>
                    <tr> 
                      <td>Performance period for pro-rated calculations</td>
                      <td colspan="3"><?php echo HLP_DateConversion($rule_dtls["start_dt"]).' to '.HLP_DateConversion($rule_dtls["end_dt"]);?></td>
                      </tr>
                      <?php } ?>
                    <tr>
                      <td>Salary elements to be reviewed </td>
                      <td colspan="3">
                      <?php if($salary_applied_on_elem_list){
                        $salary_applied_on_elements = "";
                        if(isset($rule_dtls['salary_applied_on_elements']))
                        {
                            $salary_applied_on_elements = explode(",", $rule_dtls['salary_applied_on_elements']);
                        }
                        $ba='';
                        foreach($salary_applied_on_elem_list as $row){ ?>
                        <?php if(($salary_applied_on_elements) and in_array($row["business_attribute_id"], $salary_applied_on_elements))
                                $ba.=$row["display_name"].', ';   
                        }} echo rtrim($ba,', '); ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Include inactive employees</td>
                      <td colspan="3"><?php echo ucfirst($rule_dtls["include_inactive"]); ?></td>
                    </tr>
                    <tr>
                      <td>Performance base salary increase</td>
                      <td colspan="3"><?php echo ucfirst($rule_dtls["performnace_based_hike"]); ?></td>
                    </tr>
                    <tr>
                       <td>Calculate market comparison after applying performance based increase</td>
                       <td colspan="3"><?php echo ucfirst($rule_dtls["comparative_ratio"]); ?></td>
                    </tr>

                    <tr>
                       <td>Salary position, from reference point, based on</td>
                       <td colspan="3">
                        <?php 
                          if($rule_dtls['salary_position_based_on'] == "1"){
                            echo 'Distance'; 
                          }else{
                            echo 'Quartile'; 
                          } 
                       ?>
                       </td>
                    </tr>
                    <?php if($rule_dtls['salary_position_based_on']=="1"){ ?>
                      <tr>
                       <td>Market Benchmark for calculating comparative ratio</td>
                       <td colspan="3">
                         
                        <?php echo ucfirst( $rule_dtls['default_market_benchmark']); ?>
                       </td>
                      </tr>
                       <tr>
                       <td>Choose comparative ratio ranges to see employee population distribution</td>
                       <td colspan="3">
                          <?php
                           //echo $rule_dtls["comparative_ratio_range"];
                            $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                            foreach($crr_arr as $row)
                            {     
                              echo $row["max"];
                            }                           
                          ?>
                       </td>
                      </tr>
                    <?php }else{ ?>
                        <tr>
                       <td>Choose comparative ratio ranges to see employee population distribution</td>
                       <td colspan="3">
                          <?php 
                    
                    $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                    $quartile_key_arr = array();
                    foreach($crr_arr as $key => $qk_row)
                    {
                      $quartile_key_arr[] = $qk_row['max'];
                    }
                    echo implode(',',$quartile_key_arr);
                    foreach($market_salary_elements_list as $mkt_row){ ?>
                       
                        <?php 
                        // if(in_array($mkt_row["id"].CV_CONCATENATE_SYNTAX.$mkt_row["ba_name"], $quartile_key_arr)){
                        //   echo ' <label>'.$mkt_row["display_name"].'</label>';
                        //   } 
                        ?>
                      
                     <?php } ?> 
                       </td>
                      </tr>
                    <?php } ?>  
                     

                    <tr>
                      <td>The flexibility managers can have while recommending salary review </td>
                      <td colspan="3"><?php echo '- '.$rule_dtls["Manager_discretionary_decrease"]." + ".$rule_dtls["Manager_discretionary_decrease"]; ?></td>
                    </tr>

                    <tr>
                      <td>Standard promotion increase %age </td>
                      <td colspan="3"><?php echo ucfirst($rule_dtls["standard_promotion_increase"]); ?></td>
                    </tr>

                     <tr>
                      <td>Promotion Based On </td>
                      <td colspan="3">
                        <?php if($rule_dtls["promotion_basis_on"]==1){
                          $text =  "Designation";
                        }else if($rule_dtls["promotion_basis_on"]==2){
                          $text =  "Grade";
                        }else if($rule_dtls["promotion_basis_on"]==3){
                          $text =  "Role";
                        }
                        echo ucfirst($text);
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Additional Recommendation Field 1</td>
                      <td><?php echo ucfirst($rule_dtls["esop_title"]); ?></td>
                      <td>

                        <?php 
                        $text = '';
                        if($rule_dtls["esop_type"]==1){
                          $text =  "Numeric";
                        }else if($rule_dtls["esop_type"]==2){
                          $text =  "Alpha Numeric";
                        }else if($rule_dtls["esop_type"]==2){
                          $text =  "Percentage";
                        }
                        echo ucfirst($text);
                        ?>
                      </td>
                      <td>
                        <?php 
                        $text = '';
                        if($rule_dtls["esop_right"]==1){
                          $text =  "Approve 1";
                        }else if($rule_dtls["esop_right"]==2){
                          $text =  "Approve 2";
                        }else if($rule_dtls["esop_right"]==3){
                          $text =  "Approve 3";
                        }else if($rule_dtls["esop_right"]==4){
                          $text =  "Approve 4";
                        }
                        echo ucfirst($text);
                        ?>
                      </td>
                    </tr>

                    <tr>
                      <td>Additional Recommendation Field 2 </td>
                      <td><?php echo ucfirst($rule_dtls["pay_per_title"]); ?></td>
                      <td>
                        <?php 
                        $text = '';
                        if($rule_dtls["pay_per_type"]==1){
                          $text =  "Numeric";
                        }else if($rule_dtls["pay_per_type"]==2){
                          $text =  "Alpha Numeric";
                        }else if($rule_dtls["pay_per_type"]==2){
                          $text =  "Percentage";
                        }
                        echo ucfirst($text);
                        ?>

                        </td>
                      <td>
                        
                          <?php if($rule_dtls["pay_per_right"]==1){
                          $text =  "Approve 1";
                        }else if($rule_dtls["pay_per_right"]==2){
                          $text =  "Approve 2";
                        }else if($rule_dtls["pay_per_right"]==3){
                          $text =  "Approve 3";
                        }else if($rule_dtls["pay_per_right"]==4){
                          $text =  "Approve 4";
                        }
                        echo ucfirst($text);
                        ?>

                        </td>
                    </tr>

                    <tr>
                      <td>Additional Recommendation Field 3 </td>
                      <td><?php echo ucfirst($rule_dtls["retention_bonus_title"]); ?></td>
                      <td>
                        <?php if($rule_dtls["retention_bonus_type"]==1){
                          $text =  "Numeric";
                        }else if($rule_dtls["retention_bonus_type"]==2){
                          $text =  "Alpha Numeric";
                        }else if($rule_dtls["retention_bonus_type"]==2){
                          $text =  "Percentage";
                        }
                        echo ucfirst($text);
                        ?>
                        </td>
                      <td>
                       
                          <?php if($rule_dtls["retention_bonus_right"]==1){
                          $text =  "Approve 1";
                        }else if($rule_dtls["retention_bonus_right"]==2){
                          $text =  "Approve 2";
                        }else if($rule_dtls["retention_bonus_right"]==3){
                          $text =  "Approve 3";
                        }else if($rule_dtls["retention_bonus_right"]==4){
                          $text =  "Approve 4";
                        }
                        echo ucfirst($text);
                        ?>

                        </td>
                    </tr>
                    <tr>
                      <td>Select Bonus Rule</td>
                      <td colspan="3">
                        <?= $rule_dtls["bonus_rule_name"]?$rule_dtls["bonus_rule_name"]:'No Bonus Rule Selected';
                        ?>
                      </td>
                    </tr> 
                  </table>
              </div>
              <br/>
              <!-- <div class="clearfix table-responsive">
                <div class="form_tittle ">
                   <h4>Step Two</h4>
                </div>
                <table class="table table-bordered">
                  
                </table>
              </div> -->
              <br/>
              <br/><br/>
              <div class="clearfix table-responsive">
                <div class="form_tittle ">
                    <h4>DEFINE SALARY REVIEW GRID</h4>
                </div>
                <div class="form_head pad_rt_0 clearfix">
                  <div class="col-sm-12">
                      <ul>
                        <li style="list-style: none;" class="color-detail preinc <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "pull-right"; }?> ">
                              <div class="color_info">
                                <span class="c_grn"></span><span> Pre increase population distribution</span>
                              </div>
                              <div class="color_info">
                                <span class="c_blue"></span><span> Post increase population distribution</span>
                  
                              </div>
                            </li>
                            <li class="color-detail mar0 pull-right" style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?>list-style: none; ">
                            <div class="color_info">
                              <span class="c_yello" id="spn_improvement_pre_avg_crr"><?php if($val['val1']){ echo $val['val1']; } ?></span><span> &nbsp;Average Comparative ratio before increase
                             </span>
                            </div> 
                            <div class="color_info">
                              <span class="c_yello" id="spn_improvement_post_avg_crr"><?php if($val['val2']){ echo $val['val2']; } ?></span><span> &nbsp;Average Comparative ratio after increase
                             </span>
                            </div> 
                             <div class="color_info">
                              <span class="c_yello" id="spn_improvement_avg_crr"><?php if($val['val3']){ echo $val['val3']; } ?>&nbsp;</span><span> Total improvement in the average comparative ratio
                             </span>
                            </div> 
                            </li>
                       </ul>
                  </div>
                </div>
                <?php
                    $crr_percent_values_arr = json_decode($rule_dtls["crr_percent_values"],true);
                    $max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"],true);
                    $recently_promoted_max_salary_arr = json_decode($rule_dtls["if_recently_promoted"],true);
                    $j=0; $crr_arr1 = json_decode($rule_dtls["comparative_ratio_calculations"],true);
                    $rating_val_arr = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
                ?>
               <!--  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <?php if($rule_dtls["performnace_based_hike"] == 'yes') { ?>
                        <th>Rating</th>
                        <th>Performance Based Increase</th>
                        <?php } else { ?>
                        <th>Base Increase</th>
                        <?php } ?>
                        <th>Market Benchmark</th>
                          <?php $i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                            foreach($crr_arr as $row)
                            { 
                              if($i==0)
                              { 
                                echo "<th><".$row["max"]."CR</th>";
                              } else {
                                echo "<th>".$row["min"]." < ".$row["max"]."CR</th>";
                              }

                              if(($i+1)==count($crr_arr))
                              {
                                echo "<th> > ".$row["max"]."CR</th>";
                              }
                                  $i++; 
                            } 
                          ?>
                        <th>Overall Max Increase </th>
                        <th>Max increase for Recently Promoted</th>
                      </tr>
                      <?php
                        foreach($rating_val_arr as $key => $val)
                        { 
                      ?>
                      <tr>
                        <?php $rating_name_arr =explode(CV_CONCATENATE_SYNTAX, $key);
                          if($rule_dtls["performnace_based_hike"] == 'yes')
                          {
                              echo "<td>".$rating_name_arr[1]."</td>";
                          } else {
                              // echo "<td>".$rating_name_arr[0]."</td>";
                          }
                          echo "<td>".$rating_val_arr[$key]."</td>";
                
                          if($rule_dtls["performnace_based_hike"] == 'yes')
                          { 
                              $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1[$key]);
                              echo (isset($market_salalry_arr[0]) && $market_salalry_arr[0]!='') ? "<td>".HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$market_salalry_arr[0].")")."</td>" : "<td>$market_salalry_arr[1]</td>";
                          } else {
                              $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1['all']);
                              echo (isset($market_salalry_arr[0]) && $market_salalry_arr[0]!='') ? "<td>".HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$market_salalry_arr[0].")")."</td>" : "<td>$market_salalry_arr[1]</td>";
                          }
                          $i = 0;
                          foreach($crr_arr as $row)
                          { 
                        ?>
                          <td><?php echo $crr_percent_values_arr[$i][$j]; ?></td>
                        <?php  $i++; 
                          } 
                        ?>
                        <td><?php echo $crr_percent_values_arr[$i][$j]; ?></td>
                        <td><?php echo $max_hike_arr[$j]; ?></td>
                        <td><?php echo $recently_promoted_max_salary_arr[$j]; ?></td>
                      </tr>
                      <?php $j++;} ?>
                    </tbody>
                </table> -->

                <table class="table table-bordered" style="padding:0px 10px;">
                      <tbody>
                        <tr>
                        <?php 
            
              $tag = "";
              $mkt_col_styl = "display:none;";
              if($rule_dtls['salary_position_based_on'] != "2")
              {
                $mkt_col_styl = "";
                $tag = "CR";
              }
            
            if($rule_dtls["performnace_based_hike"] == 'yes'){?>
                          <th>Rating </th>
                          <th>Performance Based Increase</th>
                         <?php }else{ ?>
                            <th>Base Increase</th>
                          <?php } ?>
                          <th style="width:15%; <?php echo $mkt_col_styl; ?>">Target position in Market BM</th>
                          <?php $i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                
                          foreach($crr_arr as $row)
                            {  
                                if($i==0)
                                { 
                                    echo "<th> &nbsp; < ".$row["max"]." ".$tag."</th>";
                                }                                
                                else
                                {
                                    echo "<th>".$row["min"]." To < ".$row["max"]." ".$tag."</th>";
                                }
                                
                                if(($i+1)==count($crr_arr))
                                {
                                    echo "<th> &nbsp; > ".$row["max"]." ".$tag."</th>";
                                }                            
                                $i++;
                            }
                    ?>
                          <th>Overall Max Increase</th>
                          <th>Max increase for Recently Promoted Cases</th>
                        </tr>
                      <!-- </thead> -->
                      <!-- <tbody style="pointer-events:none;"> -->
                        <?php //echo "<pre>";print_r(json_decode($rule_dtls["crr_percent_values"],true));
                        //$total_emps_cnt = count(explode(",",$rule_dtls['user_ids']));
                        $crr_percent_values_arr = json_decode($rule_dtls["crr_percent_values"],true);
                        $max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"],true);
                        $recently_promoted_max_salary_arr = json_decode($rule_dtls["if_recently_promoted"],true);
                        $j=0; $crr_arr1 = json_decode($rule_dtls["comparative_ratio_calculations"],true);
                        $rating_val_arr = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
                          //echo "<pre>";print_r($crr_arr1);die; 
foreach($rating_val_arr as $key => $val)
  { //echo print_r($key);die;
?>
<tr>
<?php $rating_name_arr =explode(CV_CONCATENATE_SYNTAX, $key); 
//if($rule_dtls["comparative_ratio"] == 'yes')
  if($rule_dtls["performnace_based_hike"] == 'yes')
  { ?>
    <input type="hidden" id="hf_rating_val_<?php echo $j; ?>" value="<?php echo $rating_name_arr[0]; ?>" />
    <td>
      <?php echo $rating_name_arr[1]; ?>
      <div class="green perf_inc_hk">
      <?php echo round(($rating_wise_total_emps[$key]/$total_emps_cnt)*100) ?>%
      </div>
    </td>
  <?php }else{
    //echo "<td>".$rating_name_arr[0]."</td>";
  } ?>
  <input type="hidden" id="hf_ratings_<?php echo $j; ?>" value="<?php echo $rating_val_arr[$key]; ?>" />
  <td> 
    <span><?php echo $rating_val_arr[$key]; ?> </span> 
  </td>
          
<?php 
//if($rule_dtls["comparative_ratio"] == 'yes')
if($rule_dtls["performnace_based_hike"] == 'yes')
{ 
  $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1[$key]); ?>

  <input type="hidden" id="hf_market_salary_comparative_ratio_<?php echo $j; ?>" value="<?php echo $crr_arr1[$key]; ?>" />

  <?php echo (isset($market_salalry_arr[0]) && $market_salalry_arr[0]!='') ? "<td style='".$mkt_col_styl."'>".HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$market_salalry_arr[0].")")."</td>" : "<td style='".$mkt_col_styl."'>$market_salalry_arr[1]</td>";
}
else
{
  $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1['all']); ?>
  <input type="hidden" id="hf_market_salary_comparative_ratio_<?php echo $j; ?>" value="<?php echo $crr_arr1[$key]; ?>" />
  <?php echo (isset($market_salalry_arr[0]) && $market_salalry_arr[0]!='') ? "<td>".HLP_get_filter_names("business_attribute","display_name","business_attribute.status = 1 AND id IN (".$market_salalry_arr[0].")")."</td>" : "<td>$market_salalry_arr[1]</td>";
}
?>

<?php 
$i = 0;
$rating_val_for_txt = $rating_val_arr[$key];
foreach($crr_arr as $row)
{ ?>
  <td>
    <span><?php echo $crr_percent_values_arr[$i][$j]; ?></span>
  <div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
  <?php if(isset($crr_percent_values_arr[$i][$j])){echo ($rating_val_for_txt + $crr_percent_values_arr[$i][$j]);}elseif($rating_val_for_txt){echo $rating_val_for_txt;}else{echo "0";} ?>%
  </div>
  <div class="calu">
  <div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
  <?php //if(isset($is_show_on_manager) and $is_show_on_manager==1){?>

  <div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
  <?php //} ?>
  </div>                             
  </td>
  <?php 
  $i++; 
} 
?>
                          
                          <!--Note :: Added below <td> to manage more than value of last max range-->
<td>
  <span><?php echo $crr_percent_values_arr[$i][$j]; ?></span>
  <div class="crr_per first" id="dv_perf_plus_crr_rating_<?php echo $j."_".$i; ?>">
  <?php if(isset($crr_percent_values_arr[$i][$j])){echo ($rating_val_for_txt + $crr_percent_values_arr[$i][$j]);}elseif($rating_val_for_txt){echo $rating_val_for_txt;}else{echo "0";} ?>%
  </div>
<div class="calu">
<div class="crr_per green secnd" id="dv_emp_perc_crr_wise_<?php echo $j."_".$i; ?>"></div>
<?php //if(isset($is_show_on_manager) and $is_show_on_manager==1){?>

<div class="crr_per blue third" id="dv_emp_perc_updated_crr_wise_<?php echo $j."_".$i; ?>"></div>
<?php //} ?>
</div>
</td>
<td>
  <span><?php echo $max_hike_arr[$j]; ?></span>
</td>
<td>
  <span><?php echo $recently_promoted_max_salary_arr[$j]; ?></span>
</td>
                        </tr>
                        <?php 
                $j++;} 
            ?>
                      </tbody>
                    </table>

              </div>

              <?php if(isset($is_open_frm_sal_review_pg) and $is_open_frm_sal_review_pg == 1){}else{?>
              <br /><br />
              <br /><br />
              <div class="clearfix table-responsive">
                <div class="form_tittle ">
                    <h4>DEFINE BUDGET ALLOCATION</h4>
                </div>
                <table class="table table-bordered">
                    <tr>
                      <td>Budget accumulation</td>
                      <td  colspan="3">
                          <?php 
                          if($rule_dtls['budget_accumulation'] == '1'){ 
                              echo 'Yes';
                            }else{
                              echo 'No';
                            } ?>
                      </td>
                    </tr>
                     <tr>
                      <td>Promotion budget to be part of the Overall Budget</td>
                      <td  colspan="3">
                        <?php 
                          if($rule_dtls['ddl_include_promotion_budget'] == '1'){ 
                              echo 'Yes';
                            }else{
                              echo 'No';
                            } ?>
                      </td>
                    </tr>
                     <tr>
                      <td>Oveall Budget Allocation</td>
                      <td  colspan="3">
                         <?php 
                          if($rule_dtls['overall_budget'] == 'No limit'){ 
                              echo 'No limit';
                            }else if($rule_dtls['overall_budget'] == 'Automated locked'){
                              echo 'Automated locked';
                            }elseif($rule_dtls['overall_budget'] == 'Automated but x% can exceed'){
                              echo 'Automated but x% can exceed';
                            }
                          ?>
                      </td>
                    </tr>
                </table>
                <!-- <table class="table table-bordered m0">
                    <tr>
                        <td>Overall budget allocated for salary increase for the team</td>
                        <td><?php echo $rule_dtls["overall_budget"] ?></td>
                        <?php if(isset($currencys[0])) { ?>
                        <td><?php echo (!empty($currencys[0]['display_name'])) ? $currencys[0]['display_name'] : $currencys[0]['name']; ?></td>
                        <?php } ?>
                    </tr>
                </table> -->
                <div id="dv_budget_manual">
                  <?php //if($this->session->userdata('is_manager_ses')==0){ get_managers_for_manual_bdgt( $rule_dtls["overall_budget"],$rule_dtls['id']);
                  //} ?>
                </div>
              </div>
              <?php } ?>

            </div>
          </div>
      </div>
    </div><!--End Container-->
          
    <script src="<?php echo base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>

    <?php if($this->session->userdata('is_manager_ses')==0){ ?>
    <script type="text/javascript">

        function show_hide_budget_dv(val, to_currency)
        {
            $.post("<?php echo site_url("rules/get_managers_for_manual_bdgt/1");?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
            {
                if(data) {
                    $("#dv_budget_manual").html(data);
                    $("#dv_budget_manual").show();

                    var json_manual_budget_dtls = '<?php echo $rule_dtls["manual_budget_dtls"]; ?>';
                    var i = 0;
                    var items = [];               
                    $.each(JSON.parse(json_manual_budget_dtls),function(key,valll)
                    {
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
                      $("input[name='hf_managers[]']").each( function (key, v)
                      {
                        $("#dv_manual_budget_"+ r).html(Math.round(items[i]).toLocaleString());
                        calculat_percent_increased_val(1, items[i], (i+1));
                        i++;   r++; 
                      });
                      calculat_total_revised_bgt();
                    }
                    if(val=='Automated but x% can exceed')
                    {
                      $("input[name='hf_managers[]']").each( function (key, v)
                      {
                        $("#dv_x_per_budget_"+ r).html(items[i]);
                        calculat_percent_increased_val(2, items[i], (i+1));
                        i++;    r++;
                      });
                      calculat_total_revised_bgt();
                    }
                }
                $("#loading").css('display','none');
                $('input').attr("disabled","disabled");
            });
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
          
          var per = (val/$("#hf_total_current_sal").val()*100).toFixed(2);
          $("#th_final_per").html(per + ' %');
          
          var formated_val = val.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
          $("#th_total_budget").html(formated_val);
          $("#th_total_budget_manual").html(formated_val);
        }
        
        show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', <?php echo $rule_dtls["to_currency_id"]; ?>);
    </script>

    <?php } else { ?>

    <script type="text/javascript">
        $(function(){
            show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>',<?php echo $rule_dtls["to_currency_id"]; ?>);
            $('input[name="txt_manual_budget_per[]"').attr("disabled","disabled");
        });
        function show_hide_budget_dv(val, to_currency)
        {
            $.post("<?php echo site_url("manager/dashboard/get_managers_for_manual_bdgt"); ?>",{budget_type: val, to_currency: to_currency, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
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
                        $(this).prop('readonly',true);;
                        i++;    
                      });
                    }
                    if(val=='Automated but x% can exceed')
                    {
                      $("input[name='txt_manual_budget_per[]']").each( function (key, v)
                      {
                        $(this).val(items[i]);
                        $(this).prop('readonly',true);;
                        i++;    
                      });
                    }
                }
                $('input').attr("disabled","disabled");
            });
        }

    </script>
    <?php } ?>

</body>
</html>