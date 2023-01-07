
<div class="col-md-6 col-md-offset-3">
    <?php if($templatedesc[0]->latter_head_url!='') { ?>
  <div style="position: relative;">  
    <div class="my_bg2" style=" background: url('http://localhost/comp-ben-user-portal/uploads/upload123.jpg'); background-position: center 0; width: 100%;">
        <!-- <img width="100%" height="100%" src="http://localhost/comp-ben-user-portal/uploads/survey/5d800c687094577cb4904d917dff3232.jpg" class="" /> -->
        <!-- <img width="100%" height="850px" src="<?php echo $templatedesc[0]->latter_head_url ?>" class="" /> -->
        <div class="textCon2">
        <?php      
            if(isset($salary)) {
                $page = $salary[0]['TemplateDesc'];
                $page = str_replace("{{employee_name}}",$salary[0]['emp_name'],$page);
                $page = str_replace("{{employee_title}}",$salary[0]['emp_new_designation'],$page);
                $page = str_replace("{{employee_function}}",$salary[0]['function'],$page);
                $page = str_replace("{{business_unit}}",$salary[0]['business_level_3'],$page);
                $page = str_replace("{{last_performance_rating}}",$salary[0]['performance_rating'],$page);
                $page = str_replace("{{currency}}",$salary[0]['currency'],$page);  
                $attribute=attrTemplate($salary[0]['salary_applied_on_elements']);
                $attval='';
                foreach($attribute as $attr)
                {
                 $attval.=   $attr['display_name'].', ';
                 $page = str_replace("{{".str_replace(' ','_',$attr['ba_name'])."}}",HLP_get_formated_amount_common($salary[0][str_replace(' ','_',strtolower($attr['ba_name']))]),$page);
                 
                 $page = str_replace("{{existing_".str_replace(' ','_',$attr['display_name'])."}}",HLP_get_formated_amount_common($salary[0]["existing_".str_replace(' ','_',($attr['display_name']))]),$page);
                }
                $attval=rtrim($attval,",");
                $page = str_replace("{{all_current_salary_elements}}",$attval,$page);
                $page = str_replace("{{current_salary_element_on_which_increase_is_applied_on}}",$attval,$page);
                $page = str_replace("{{current_CR}}",($salary[0]['crr_val']),$page);
                $page = str_replace("{{final_approved_salary_increase_percentage}}",((($salary[0]['final_salary'] - $salary[0]['increment_applied_on_salary']) / $salary[0]['increment_applied_on_salary'])*100),$page);
                $page = str_replace("{{final_approved_salary_increase_amount}}",HLP_get_formated_amount_common(($salary[0]['final_salary']-$salary[0]['increment_applied_on_salary'])),$page);
                //$page = str_replace("{{new_salary_element_after_applying_increase}}",$salary[0][''],$page);
                $page = str_replace("{{final_approved_promotion_increase}}",$salary[0]['standard_promotion_increase'],$page);
                $page = str_replace("{{new_salary_element_after_applying_promotion_increase}}",HLP_get_formated_amount_common($salary[0]['final_salary']),$page);
                $page = str_replace("{{promotion_to_new_title}}",$salary[0]['emp_new_designation'],$page);
                $page = str_replace("{{manager_full_name}}",$salary[0]['manager_name'],$page);
                $page = str_replace("{{authorised_signatory_for_letter}}",$salary[0]['authorised_signatory_for_letter'],$page);
                $page = str_replace("{{authorised_signatorys_title_for_letter}}",$salary[0]['authorised_signatory_title_for_letter'],$page);
                $page = str_replace("{{hr_authorised_signatory_for_letter}}",$salary[0]['hr_authorised_signatory_for_letter'],$page);
                $page = str_replace("{{hr_authorised_signatorys_title_for_letter}}",$salary[0]['hr_authorised_signatory_title_for_letter'],$page);
            }
            if(isset($bonus))
            {
                $page=$bonus[0]['TemplateDesc'];
                $page = str_replace("{{employee_name}}",$bonus[0]['emp_name'],$page);
                $page = str_replace("{{employee_title}}",$bonus[0]['emp_new_designation'],$page);
                $page = str_replace("{{employee_function}}",$bonus[0]['function'],$page);
                $page = str_replace("{{business_unit}}",$bonus[0]['business_level_3'],$page);
                $page = str_replace("{{last_performance_rating}}",$bonus[0]['performance_rating'],$page);
                $page = str_replace("{{currency}}",$bonus[0]['currency'],$page);
                $page = str_replace("{{current_target_bonus_amount}}",$bonus[0][''],$page);
                $page = str_replace("{{current_target_bonus_as_percentage_of_base_salary}}",$bonus[0][''],$page);
                $page = str_replace("{{business_unit_1_name}}",$bonus[0]['bl_1_name'],$page);
                $page = str_replace("{{business_unit_2_name}}",$bonus[0]['bl_2_name'],$page);
                $page = str_replace("{{business_unit_3_name}}",$bonus[0]['bl_3_name'],$page);
                $page = str_replace("{{function_name}}",$bonus[0]['function_name'],$page);
                $page = str_replace("{{business_unit_1_weightage}}",$bonus[0]['bl_1_weightage'],$page);
                $page = str_replace("{{business_unit_2_weightage}}",$bonus[0]['bl_2_weightage'],$page);
                $page = str_replace("{{business_unit_3_weightage}}",$bonus[0]['bl_3_weightage'],$page);
                $page = str_replace("{{function_weihtage}}",$bonus[0]['function_weightage'],$page);
                $page = str_replace("{{business_unit_1_acheivement_percentage}}",$bonus[0]['bl_1_achievement'],$page);
                $page = str_replace("{{business_unit_2_acheivement_percentage}}",$bonus[0]['bl_2_achievement'],$page);
                $page = str_replace("{{business_unit_3_acheivement_percentage}}",$bonus[0]['bl_3_achievement'],$page);
                
                $page = str_replace("{{function_acheivement_percentage}}",$bonus[0][''],$page);
                $page = str_replace("{{final_bonus_multiplier_percentage}}",$bonus[0][''],$page);
                
                
                $page = str_replace("{{individual_performance_achievement_percentage}}",$bonus[0]['individual_achievement'],$page);
                $page = str_replace("{{final_bonus_amount}}",$bonus[0]['final_bonus'],$page);
                $page = str_replace("{{manager_full_name}}",$bonus[0]['manager_name'],$page);
                $page = str_replace("{{authorised_signatory_for_letter}}",$bonus[0]['authorised_signatory_for_letter'],$page);
                $page = str_replace("{{authorised_signatorys_title_for_letter}}",$bonus[0]['authorised_signatory_title_for_letter'],$page);
                $page = str_replace("{{hr_authorised_signatory_for_letter}}",$bonus[0]['hr_authorised_signatory_for_letter'],$page);
                $page = str_replace("{{hr_authorised_signatorys_title_for_letter}}",$bonus[0]['hr_authorised_signatory_title_for_letter'],$page);
            }
            if(isset($lti))
            {
                $page=$lti[0]['TemplateDesc'];
                $page = str_replace("{{employee_name}}",$lti[0]['emp_name'],$page);
                $page = str_replace("{{employee_title}}",$lti[0]['emp_new_designation'],$page);
                $page = str_replace("{{employee_function}}",$lti[0]['function'],$page);
                $page = str_replace("{{business_unit}}",$lti[0]['business_level_3'],$page);
                $page = str_replace("{{last_performance_rating}}",$lti[0]['performance_rating'],$page);
                $page = str_replace("{{currency}}",$lti[0]['currency'],$page);
                
                $page = str_replace("{{current_target_LTI_amount}}",$lti[0][''],$page);
                $page = str_replace("{{current_target_LTI_as_percentage_of_base_salary}}",$lti[0][''],$page);
                $page = str_replace("{{final_LTI_amount}}",$lti[0][''],$page);
                $page = str_replace("{{final_LTI_as_percentage_of_base_salary}}",$lti[0][''],$page);
                
                echo '<pre />';
                print_r(json_decode($lti[0]['target_lti_dtls']));
                
                $page = str_replace("{{vesting_1_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                $page = str_replace("{{vesting_2_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                $page = str_replace("{{vesting_3_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                $page = str_replace("{{vesting_4_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                $page = str_replace("{{vesting_5_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                $page = str_replace("{{vesting_6_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                $page = str_replace("{{vesting_7_percentage_of_total_grant_due_date_and_amount}}",$lti[0][''],$page);
                
                $page = str_replace("{{manager_full_name}}",$lti[0]['manager_name'],$page);
                $page = str_replace("{{authorised_signatory_for_letter}}",$lti[0]['authorised_signatory_for_letter'],$page);
                $page = str_replace("{{authorised_signatorys_title_for_letter}}",$lti[0]['authorised_signatory_title_for_letter'],$page);
                $page = str_replace("{{hr_authorised_signatory_for_letter}}",$lti[0]['hr_authorised_signatory_for_letter'],$page);
                $page = str_replace("{{hr_authorised_signatorys_title_for_letter}}",$lti[0]['hr_authorised_signatory_title_for_letter'],$page);
            }
            echo $page;
        ?>  
    </div>
    </div>
    <?php } else { ?>
     
    <?php } ?>
         
    
<div>    
</div>