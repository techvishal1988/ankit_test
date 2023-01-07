<div class="page-breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <ol class="breadcrumb wn_btn">
          <li><a href="<?php echo site_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
          <li> <a href="<?php echo $rule_list_pg_url; ?>"><?php echo 'Rule List';  ?></a></li>
          <li class="active"><?php echo $title; ?></li>
        </ol>
      </div>
      <div class="col-sm-4" style="padding-right:0px;">
       <div class="pull-right">
      	<a type="button" id="btnPrint" class="btn btn-success" value="Print">Print</a>
      	</div>
      </div>
    </div>
  </div>
</div>

<div id="main-wrapper" class="container">
    <div class="row mb20">
        <div class="col-md-12 col-xs-12 background-cls">
            <div class="mailbox-content" style="overflow-x:auto">
				<?php
                $cnt = 1+count($rule_list); 
                $per = round(100/$cnt);
                
				/*$rule_names = $country_names = $city_names = $bl1_names = $bl2_names = $function_names = $sub_function_names = $designation_names = $grade_names = $level_names = $education_names = $critical_talent_names = $critical_position_names = $special_category_names = $pro_rated = $salary_elements = $performance_base = $market_comparison_after_performance = $total_emps = $total_managers = $total_budget = $total_current_salary = $total_budget_to_cr1 = "";*/
				$rule_names = $total_emps = $total_managers = $total_budget = $total_current_salary = $total_budget_to_cr1 = $targeted_population_lnks = $basic_info_lnks = $increased_per = "";
				
				foreach($rule_list as $row)
				{
					$rule_names .= "<th width=".$per.">".$row["salary_rule_name"]."</th>";					
					/*$country_names .= "<td>".$row["country_names"]."</td>";
					$city_names .= "<td>".$row["city_names"]."</td>";
					$bl1_names .= "<td>".$row["bl1_names"]."</td>";
					$bl2_names .= "<td>".$row["bl2_names"]."</td>";
					$bl3_names .= "<td>".$row["bl3_names"]."</td>";
					$function_names .= "<td>".$row["function_names"]."</td>";
					$sub_function_names .= "<td>".$row["sub_function_names"]."</td>";
					$designation_names .= "<td>".$row["designation_names"]."</td>";
					$grade_names .= "<td>".$row["grade_names"]."</td>";
					$level_names .= "<td>".$row["level_names"]."</td>";
					$education_names .= "<td>".$row["education_names"]."</td>";
					$critical_talent_names .= "<td>".$row["critical_talent_names"]."</td>";
					$critical_position_names .= "<td>".$row["critical_position_names"]."</td>";
					$special_category_names .= "<td>".$row["special_category_names"]."</td>";
					
					$pro_rated .= "<td style='text-transform: capitalize;'>".$row["prorated_increase"]."</td>";
					$salary_elements .= "<td>".$row["salary_element_names"]."</td>";
					$performance_base .= "<td style='text-transform: capitalize;'>".$row["performnace_based_hike"]."</td>";
					$market_comparison_after_performance .= "<td style='text-transform: capitalize;'>".$row["comparative_ratio"]."</td>";*/
					
					$targeted_population_lnks .="<th width=".$per."><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">See Details</a></th>";
					$basic_info_lnks .="<th width=".$per."><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">See Details</a></th>";
					
					$rule_comparison_dtls = json_decode($row["managers_bdgt_dtls_for_tbl_head"], true);
					$manager_budget_dtls = json_decode($row["manual_budget_dtls"], true);
					$total_emps .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".$rule_comparison_dtls["total_employees"]."</a></td>";
					$total_managers .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".count($manager_budget_dtls)."</a></td>";
					$increased_per .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".HLP_get_formated_percentage_common($rule_comparison_dtls["total_increased_amt_per"])."%</a></td>";
					$total_budget .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".$row["currency_name"]." ".HLP_get_formated_amount_common($rule_comparison_dtls["total_revised_budget"])."</a></td>";
					$total_current_salary .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".$row["currency_name"]." ".HLP_get_formated_amount_common($rule_comparison_dtls["total_emps_total_salary"])."</a></td>";
					$total_budget_to_cr1 .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".$row["currency_name"]." ".HLP_get_formated_amount_common($rule_comparison_dtls["total_budget_to_cr1"])."</a></td>";
					$avg_of_total_pre_cr .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".HLP_get_formated_percentage_common($rule_comparison_dtls["avg_of_total_pre_cr"])."%</a></td>";
					$avg_of_total_post_cr .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".HLP_get_formated_percentage_common($rule_comparison_dtls["avg_of_total_post_cr"])."%</a></td>";
					$avg_of_total_improvment_on_cr .= "<td><a target='_blank' href=".site_url("view-salary-rule-details/".$row["id"]).">".HLP_get_formated_percentage_common($rule_comparison_dtls["avg_of_total_improvment_on_cr"])."%</a></td>";
					
				}
				?>
				<div class="table-responsive" id="dvContents">
                    <table border="1" cellspacing="0" class="table border" style="width:100%;  overflow:scroll !important;">
                        <thead>
                            <tr style="border-bottom:1px solid #000;">
                                <th width="<?php echo $per; ?>%">Rules</th>
                                <?php echo $rule_names; ?>
                            </tr>                    
                        </thead>
                        <tbody id="tbl_body">
                        	<?php
							/*echo "<tr><th>Country</th>". $country_names ."</tr>";
							echo "<tr><th>City</th>". $city_names ."</tr>";							
							echo "<tr><th>Business Level 1</th>". $bl1_names ."</tr>";
							echo "<tr><th>Business Level 2</th>". $bl2_names ."</tr>";
							echo "<tr><th>Business Level 3</th>". $bl3_names ."</tr>";
							echo "<tr><th>Functions</th>". $function_names ."</tr>";
							echo "<tr><th>Sub-Functions</th>". $sub_function_names ."</tr>";
							echo "<tr><th>Designation</th>". $designation_names ."</tr>";
							echo "<tr><th>Grade</th>". $grade_names ."</tr>";
							echo "<tr><th>Level</th>". $level_names ."</tr>";
							echo "<tr><th>Education</th>". $education_names ."</tr>";
							echo "<tr><th>Critical Talent</th>". $critical_talent_names ."</tr>";
							echo "<tr><th>Critical Position</th>". $critical_position_names ."</tr>";
							echo "<tr><th>Special Category</th>". $special_category_names ."</tr>";
							
							echo "<tr><th>Apply Prorated Increase Calculations</th>". $pro_rated ."</tr>";			
							echo "<tr><th>Performance Base Salary Increase</th>". $performance_base ."</tr>";
							echo "<tr><th>Calculate Market Comparison After Applying Performance Based Increase</th>". $market_comparison_after_performance ."</tr>";
							echo "<tr><th>Salary Elements To Be Reviewed</th>". $salary_elements ."</tr>";*/
							
							echo "<tr><th>Targeted Population</th>". $targeted_population_lnks ."</tr>";
							echo "<tr><th>Basic Information</th>". $basic_info_lnks ."</tr>";
							
							echo "<tr><th>Total Managers</th>". $total_managers ."</tr>";
							echo "<tr><th>Total Number of Employees</th>". $total_emps ."</tr>";							
							echo "<tr><th>Total Current Salary </th>". $total_current_salary ."</tr>";
							echo "<tr><th>Total Budget As Per The Plan </th>". $total_budget ."</tr>";
							echo "<tr><th>% Increased </th>". $increased_per ."</tr>";
							//echo "<tr><th>Total Budget To CR 1</th>". $total_budget_to_cr1 ."</tr>";
							echo "<tr><th>Average of Pre Increased CR</th>". $avg_of_total_pre_cr ."</tr>";
							echo "<tr><th>Average of Post Increased CR</th>". $avg_of_total_post_cr ."</tr>";
							echo "<tr><th>Average of CR Improvement</th>". $avg_of_total_improvment_on_cr ."</tr>";

							?>
						</tbody>
                    </table>
                </div>      
                      
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function () {
    $("#btnPrint").click(function () {
        var contents = $("#dvContents").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>&nbsp;</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        //frameDoc.document.write('<link href="http://localhost/comp-ben-user-portal/assets/css/custom.css" rel="stylesheet" type="text/css" />');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    });
});
</script>