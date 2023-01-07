  <link href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url("assets/css/samshul.css"); ?>" rel="stylesheet" type="text/css"/>
  <?php //echo '<pre />'; levels print_r($rule_dtls) ?>
    <style type="text/css">
@page
{
	size: landscape;
	margin: 1cm;
}
</style>
  <style>
      .form_head {
        
        border-top: 8px solid #FF0101;
        border-left: #FF0101 solid 2px;
        border-right: #FF0101 solid 2px;
        border-bottom: #FF0101 solid 2px;
        border-radius: 5px;
       
}
.form_title h4{
    background-color: #f2f2f2;
}
.table{
        width: 100%;
       
        /*border-right: #FF0101 solid 2px;*/
       
}
  </style>
  
  
  <style type="text/css" media="print">
@page
{
	size: landscape;
	margin: 1cm;
}
</style>
          <?php 
             $rule = getinformation(SALARY_RULE);
             $rule_val=json_decode($rule[0]->steps); 
             $filter = getinformation(SALARY_RULE_FILTER);
             $filter_val=json_decode($filter[0]->steps); 
//              echo '<pre />';
//              print_r($rule_dtls);
              
              function getName($arr,$forArr)
              {
                  $string='';
                  for($i=0;$i<count($forArr);$i++)
                  {
                      foreach($arr as $ar)
                      {
                          if($ar['id']==$forArr[$i])
                          {
                            $string.=$ar['name'].',';  
                          }
                      }
                  }
                  echo rtrim($string,',');
              }
            ?>
			
<div class="container-fluid">


			
  <div class="row">
      <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
      <div class="form_tittle ">
            <h4>Salary Rule Filters</h4>
             
      </div>
      
         <table class="table table-bordered">
                                <tr>
                                    <td>Country</td>
                                    <td>
                                        <?php 
                                            
                                        getName($country_list,$rule_dtls['country']);
                                        
                                        ?>
                                        </td>
                                </tr>
                                <tr>
                                    <td>
                                        City
                                    </td>
                                    <td>
                                        <?php 
                                            
                                        getName($city_list,$rule_dtls['city']);
                                        
                                        ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bussiness Level 1</td>
                                    <td>
                                    <?php 
                                            
                                        getName($bussiness_level_1_list,$rule_dtls['business_level1']);
                                        
                                        ?></td>
                                </tr>
                                  <tr>
                                    <td>Bussiness Level 2</td>
                                    <td>
                                    <?php 
                                          
                                        getName($bussiness_level_2_list,$rule_dtls['business_level2']);
                                        
                                        ?></td>
                                </tr>
                                 <tr>
                                    <td>Bussiness Level 3</td>
                                    <td>
                                    <?php 
                                            
                                        getName($bussiness_level_3_list,$rule_dtls['business_level3']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Function</td>
                                    <td><?php 
                                            
                                        getName($function_list,$rule_dtls['functions']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>
                                      Sub Function
                                    </td>
                                    <td><?php 
                                            
                                        getName($sub_function_list,$rule_dtls['sub_functions']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td> Designation
                                    <td><?php 
                                            
                                        getName($designation_list,$rule_dtls['designations']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Grade</td>
                                    <td><?php 
                                            
                                        getName($grade_list,$rule_dtls['grades']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Education</td>
                                    <td><?php 
                                            
                                        getName($education_list,$rule_dtls['educations']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Critical Talent</td>
                                    <td><?php 
                                            
                                        getName($critical_talent_list,$rule_dtls['critical_talents']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Critical Position</td>
                                    <td><?php 
                                            
                                        getName($critical_position_list,$rule_dtls['critical_positions']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Special Category</td>
                                    <td><?php 
                                            
                                        getName($special_category_list,$rule_dtls['special_category']);
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Level</td>
                                    <td>
                                        <?php 
                                        $level = explode(',',$rule_dtls['levels']);
                                        getName($level_list,$level);
                                        ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tenure in the company</td>
                                    <td><?php 
                                    $tn='';
                                            foreach($rule_dtls['tenure_company'] as $cp)
                                            {
                                               $tn.= $cp.',';
                                            }
                                            echo rtrim($tn,',');
                                       
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        Tenure in the Role
                                    </td>
                                    <td><?php 
                                            
                                       $tn='';
                                            foreach($rule_dtls['tenure_roles'] as $cp)
                                            {
                                               $tn.= $cp.',';
                                            }
                                            echo rtrim($tn,',');
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>
                                            Cutoff Date
                                    </td>
                                    <td>
                                            <?php echo date('d/m/Y',strtotime($rule_dtls['cutoff_date'])); ?>
                                    </td>
                                </tr>
                               </table>       
  </div>
      </div>
  </div>
  <br />
  <div class="row">
      <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
              <div class="form_tittle ">
                  <h4>Step One</h4>
              </div>
	  <table class="table table-bordered">
             <tr> 
                 <td>Plan Name</td>
                 <td><?php echo $rule_dtls["name"]; ?></td>
                 
             </tr>
             <tr>
                 <td>Prorated Increase</td>
                 <td><?php echo $rule_dtls["prorated_increase"] ?></td>
                 
             </tr>
             <tr> 
                 <td>Rule Dates</td>
                 <td><?php echo date('d/m/Y',strtotime($rule_dtls["start_dt"])).' to '.date('d/m/Y',strtotime($rule_dtls["end_dt"]));?></td>
                 
             </tr>
             
         </table>
          </div>
        
          </div>
      </div>
  
         <br />
         <div class="row">
      <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
      <div class="form_tittle ">
         <h4>Step Two</h4>
      </div>
         <table class="table table-bordered">
             <tr>
                 <td>Salary Rule Name</td>
                 <td><?php echo $rule_dtls["salary_rule_name"]; ?></td>
                 
             </tr>
             <tr>
                 <td>Salary increment Applied On</td>
                 <td>
                       <?php if($salary_applied_on_elem_list){
                                $salary_applied_on_elements = "";
                                if(isset($rule_dtls['salary_applied_on_elements']))
                                {
                                    $salary_applied_on_elements = explode(",", $rule_dtls['salary_applied_on_elements']);
                                }
                                $ba='';
                                foreach($salary_applied_on_elem_list as $row){ ?>
                                <?php if(($salary_applied_on_elements) and in_array($row["business_attribute_id"], $salary_applied_on_elements))
                                        $ba.=$row["display_name"].','; 
                                        
                                }} echo rtrim($ba,','); ?>
                      </td>
                 
             </tr>
             <tr>
                 <td>Include Inactive</td>
                 <td><?php echo $rule_dtls["include_inactive"]; ?></td>
                 
             </tr>
             <tr>
                 <td>Performance Based Hikes</td>
                 <td><?php echo $rule_dtls["performnace_based_hike"] ?></td>
                 
             </tr>
             <tr>
                 <td>Comparative ratio to be applied after performance based merit increase</td>
                 <td><?php echo $rule_dtls["comparative_ratio"] ?></td>
                 
             </tr>

             

             <tr>
                 <td>Comparative ratio ranges (CRR)</td>
                 <td>
                     <?php														
                                    $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                                    $mx='';
                                    foreach($crr_arr as $row)
                                    {			
                                     $mx.=$row["max"].',';
                                    }
                                    echo rtrim($mx,',')
                                    ?>
                 </td>
                 
             </tr>
         </table>
         <br />
         <h4>Step Three</h4>
         <table class="table table-bordered">
             <tr>
                 <td>Manager's discretionary increase</td>
                 <td>-<?php echo $rule_dtls["Manager_discretionary_decrease"]; ?>, +<?php echo $rule_dtls["Manager_discretionary_increase"]; ?></td>
                 
             </tr>
             <tr>
                 <td>Standard Promotion Increase</td>
                 <td><?php echo $rule_dtls["standard_promotion_increase"]; ?></td>
                 
             </tr>
            
         </table>
         </div>
      </div>
  </div>
		<br />
                  <div class="row">
      <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
      <div class="form_tittle ">
                <h4>Step Four</h4>
      </div>
                <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Rating</th>
                          <th>Performance based hike</th>
                          <th>Market Benchmark</th>
                          <?php $i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
                        foreach($crr_arr as $row)
                        { 
                    ?>
                          <?php 
						if($i==0)
						{ 
							echo "<th><".$row["max"]."CR</th>";
						}
						
						else
						{
							echo "<th>".$row["min"]." < ".$row["max"]."CR</th>";
						}
						
						if(($i+1)==count($crr_arr))
						{
							echo "<th> > ".$row["max"]."CR</th>";
						}
					?>
                          <?php 
                            $i++; 
                        } 
                    ?>
                          <th>Max Hike</th>
                          <th>Recently promoted max salary increase</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php //echo "<pre>";print_r(json_decode($rule_dtls["crr_percent_values"],true));
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
                    {
                        echo "<td>".$rating_name_arr[1]."</td>";
						
                    }
                    else
                    {
                        echo "<td>".$rating_name_arr[0]."</td>";
                    }
					echo "<td>".$rating_val_arr[$key]."</td>";
					
					
					//if($rule_dtls["comparative_ratio"] == 'yes')
					if($rule_dtls["performnace_based_hike"] == 'yes')
                    {	
						$market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1[$key]);
						  
                        echo "<td>".$market_salalry_arr[1]."</td>";
						
                    }
                    else
                    {
						$market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $crr_arr1['all']);
                        echo "<td>".$market_salalry_arr[1]."</td>";
                    }
                ?>
                          <?php /*?><td><?php $market_salalry_arr =explode(CV_CONCATENATE_SYNTAX, $val);
						  echo $market_salalry_arr[1]; ?></td><?php */?>
                          <?php 
                    $i = 0;
                    foreach($crr_arr as $row)
                    { 
                ?>
                          <td><?php echo $crr_percent_values_arr[$i][$j]; ?></td>
                          <?php 
                    $i++; 
                    } 
                ?>
                          
                          <!--Note :: Added below <td> to manage more than value of last max range-->
                          <td><?php echo $crr_percent_values_arr[$i][$j]; ?></td>
                          <td><?php echo $max_hike_arr[$j]; ?></td>
                          <td><?php echo $recently_promoted_max_salary_arr[$j]; ?></td>
                        </tr>
                        <?php 
                $j++;} 
            ?>
                      </tbody>
                    </table>
              </div>
      </div>
  </div>
                   <br />
                   <div class="row">
                    <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
      <div class="form_tittle ">
                    <h4>Step Five</h4>
      </div>
                    <table class="table table-bordered">
                        <tr>
                            <td>Overall budget allocated for salary increase for the team</td>
                            <td><?php echo $rule_dtls["overall_budget"] ?></td>
                        </tr>
                    </table>
                    </div>
      </div>
                   </div>
                   <br />
                   <div class="row">
                    <div class="col-md-12 borderCon">
          <div class="form_head clearfix table-responsive">
              <div id="dv_budget_manual">
                  <?php get_managers_for_manual_bdgt( $rule_dtls["overall_budget"],$rule_dtls['id']) ?>
              </div>
          </div></div></div>
		  
		  </div><!--End Container-->
            
          
    <script src="<?php echo base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

  
//show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>'); 
function show_hide_budget_dv(val)
{
        $.post("<?php echo site_url("rules/get_managers_for_manual_bdgt");?>",{budget_type: val, rid:<?php echo $rule_dtls['id']; ?>}, function(data)
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
            
          
        
        });
    //}
    
}

 
</script>

