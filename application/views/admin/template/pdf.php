<html>
<head>
    <title>

    </title>
    <style>
    body {
    	background-image: url("<?php echo $templatedesc[0]['latter_head_url']; ?>"); 
    	/*background-position: 50% 50%;*/
    	background-repeat: no-repeat;
    	 /*background-image-resize: 3;*/
    	/*height: 100%;*/
        /*font-family: Calibri;*/
      
        background-image-resize: 6;  height: 40mm;
       
        }

p{margin-bottom: 5px !important;}
table { margin-bottom: 0px; padding: 0px; width: 100%; cellspacing: 0;   border-collapse: collapse;}
table>thead>tr>th{border: 1px solid #000 !important;}
table >tr:first-child td{ background-color: #4286f4;}
table td {padding: 8px; text-align: left; border: 1px solid #000 !important; background-color: unset;}
table th {padding: 8px; text-align: left; /*background-color: #f1f1f1; */ border: 1px solid #000 !important;}
table >tr:first-child  td{ background-color: #4286f4;}
</style>

</head>
<body ><?php
// print_r($salary[0]);
// echo $ruleID. $salary[0]['user_id'];
 // print_r ($templatedesc[0]);
 // die;	  
                    if(isset($salary[0]))
					{
						
$get_ratingdata=$this->admin_model->get_table_row('login_user', '*',['id'=>$salary[0]['user_id']]);

$get_tempdata=$this->admin_model->get_table_row('tbl_bulk_upload_flexi_data', '*',['email'=>$get_ratingdata['email'],'status'=>1,'rule_id'=>$ruleID]);

		$page=stripslashes($templatedesc[0]['TemplateDesc']);
$sp_manager_discretions=intval($salary[0]['sp_manager_discretions']);
if($sp_manager_discretions>0)
{
$page = str_replace("{{promotion_content}}",$templatedesc[0]['PromotionDesc'],$page);	
}else
{
$page = str_replace("{{promotion_content}}",'',$page);	
}
		

$page = str_replace("{{digital_signature}}",'<img src="'.$templatedesc[0]['digital_signature_url'].'">',$page);

$page = str_replace("rgb(78, 94, 106)",'black',$page);
$page = str_replace("{{page_break}}",'<div style="page-break-after: always;"></div>',$page);
//<div style="page-break-before: always; page-break-after: always;"></div>
//$page = str_replace("{{rating_content}}",$templateratingdesc[0]['raing_desc']?$templateratingdesc[0]['raing_desc']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{rating_content}}",$templateratingdesc[0]['raing_desc'],$page);
		$annual_pms = 1000;
		$compensation_table = '<div class="table-responsive"> 
				<table id="example"  style="width: 100%; cellspacing: 0;   border-collapse: collapse;">
					<thead>
						<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Fixed Pay as on 1-Apr-17(Rs.)</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Increase in Fixed Payduring the year (Rs.)</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Annual PMS Increment (Rs.)*</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Total Increase for FY’18 (Rs.)</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Total Increase for FY’18 (%)</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">New Fixed Pay w.e.f. 1st April’18(Rs.)</th>
						</tr>
					</thead>
					<tbody>
<tr>
                        <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($salary[0]['increment_applied_on_salary'],0).'</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format((($salary[0]['increment_applied_on_salary'] * $salary[0]['manager_discretions'])),0).'</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($annual_pms,0).'</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format(((($salary[0]['increment_applied_on_salary'] * $salary[0]['manager_discretions'])/100)+$annual_pms),0).'</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($salary[0]['manager_discretions'],0).'</td>
                        <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($salary[0]['final_salary'],0).'</td>
                        </tr>
					</tbody>
					</table>
					</div>';

				
$special_increment = $salary[0]['mkt_correction_hike']+$salary[0]['min_band_salary_hike']+$salary[0]['standard_promotion_increase']+$salary[0]['rj_increment_hike'];

if($salary[0]['performnace_based_increment']>0 || $special_increment>0 || $salary[0]['standard_promotion_increase']>0)	{
					$increment_breakup_table = '<div class="table-responsive"> 
				<table id="example"   style="width: 100%; cellspacing: 0;   border-collapse: collapse;">
					<thead>
						<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Annual Compensation Increment</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">% Increase</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Amount (Rs.)</th>
						</tr>
					</thead>
					<tbody>'; ?> 

					<?php

if($salary[0]['performnace_based_increment']>0){
					 $increment_breakup_table .=' <tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Merit Increment basis performance rating</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($salary[0]['performnace_based_increment'],0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format((($salary[0]['increment_applied_on_salary']*$salary[0]['performnace_based_increment'])/100),0).'</td>
					</tr>'; ?> 

					<?php
} if($special_increment >0){

					$increment_breakup_table .='<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Special Increment</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($special_increment,0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format((($salary[0]['increment_applied_on_salary']*$special_increment)/100),0).'</td>
					</tr>';?>
					<?php 
				}
				if($salary[0]['standard_promotion_increase'] >0){
					$increment_breakup_table .='<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Increase on account ofUpgrade</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($salary[0]['standard_promotion_increase'],0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format((($salary[0]['increment_applied_on_salary']*$salary[0]['standard_promotion_increase'])/100),0).'</td>					
					</tr>';?>
					<?php
}
					$increment_breakup_table .='<tr>
					<td style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Total Annual Increment for FY’18 Appraisal</td>
					<td style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format($salary[0]['performnace_based_increment']+$special_increment+$salary[0]['standard_promotion_increase'],0).'</td>
					<td style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format(((($salary[0]['increment_applied_on_salary']*$salary[0]['performnace_based_increment'])/100)+(($salary[0]['increment_applied_on_salary']*$special_increment)/100)+(($salary[0]['increment_applied_on_salary']*$salary[0]['standard_promotion_increase'])/100)),0).'</td>					
					</tr>

					</tbody>

					</table></div>';
				}else{
					$increment_breakup_table = "";
				}
$pre_incentive_total = $incentivedetails[0]['previous_business_incentive']+ $incentivedetails[0]['previous_cross_sell_incentive'] +$incentivedetails[0]['previous_contest_incentive'];

$revise_incentive_total = $incentivedetails[0]['revise_business_incentive']+ $incentivedetails[0]['revise_cross_sell_incentive'] +$incentivedetails[0]['revise_contest_incentive'];

if($incentivedetails[0]['previous_business_incentive']>0 || $incentivedetails[0]['previous_cross_sell_incentive']>0 || $incentivedetails[0]['previous_contest_incentive']>0)	{

$incentive_table = '<div class="table-responsive"> 
				<table id="example"  style="width: 100%; cellspacing: 0;   border-collapse: collapse;">
					<thead>
						<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Incentive Details</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Previous</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Revise</th>
						</tr>
					</thead>
					<tbody>'; ?> 

					<?php

if($incentivedetails[0]['previous_business_incentive']>0){
					 $incentive_table .='<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Business Incentive</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($incentivedetails[0]['previous_business_incentive'],0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($incentivedetails[0]['revise_business_incentive'],0).'</td>
					</tr>';?>
					<?php 
				}
				if($incentivedetails[0]['previous_cross_sell_incentive'] >0){
					$incentive_table .='<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Cross Sell Incentive</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($incentivedetails[0]['previous_cross_sell_incentive'],0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($incentivedetails[0]['revise_cross_sell_incentive'],0).'</td>
					</tr>';?>
					<?php 
				}
				if($incentivedetails[0]['previous_contest_incentive'] >0){
					$incentive_table .='
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Contest Incentive</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($incentivedetails[0]['previous_contest_incentive'],0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($incentivedetails[0]['revise_contest_incentive'],0).'</td>					
					</tr>';?>
					<?php 
				}
				
					$incentive_table .='

					<tr>
					<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Total Incentive Earned</th>
					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format($pre_incentive_total,0).'</th>
					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format($revise_incentive_total,0).'</th>					
					</tr>

					</tbody>

					</table></div>';
}else{
					$incentive_table = "";
				}

if(!empty($salary[0]['emp_new_designation'])){
			$grade1 = $salary[0]['emp_new_designation'];
		}else{
			$grade1 = $salary[0]['grade'];
		}
					$basic_info_table = '<div class="table-responsive"> 
				<table id="example" style="width: 100%; cellspacing: 0;   border-collapse: collapse;">
					
					<tbody>
					<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; ">Employee ID</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; ">'.$get_ratingdata['employee_code'].'</th>
						
						</tr>
						<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; ">Name</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; ">'.$salary[0]['emp_name'].'</th>
						
						</tr>
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Designation</td>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$salary[0]['designation'].'</td>
					
					</tr>
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Grade</td>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$grade1.'</td>
					 
					</tr>
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Level</td>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$salary[0]['level'].'</td>
					 				
					</tr>
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Department</td>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$salary[0]['function'].'</td>
					 				
					</tr>
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Sub Department</td>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$salary[0]['sub_function'].'</td>
					 				
					</tr>
					<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Location</td>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$salary[0]['city'].'</td>
					 				
					</tr>

					

					</tbody>

					</table></div>';
////  final salary with previous year

					$final_salary_table_with_previous_year = '<div class="table-responsive"> 
				<table id="example" style="width: 100%; cellspacing: 0;   border-collapse: collapse;">
					<thead>
						<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Components</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Annualized FY’18 (Rs.)</th>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Annualized FY’19 (Rs.)</th>
						</tr>
					</thead>
					<tbody>';

$elem = json_decode($salary[0]['increment_applied_on_elem_dtls']);
foreach ($elem as $elem_val) { 
	if($elem_val->value>0){
$ba_name = $elem_val->ba_name;
$ba_value = $elem_val->value;
$fixed_ba_value += $elem_val->value;
$ba_value_hike_amount = $elem_val->value + ($elem_val->value*$salary[0]['manager_discretions'])/100;

$fixed_ba_value_hike_amount += $ba_value_hike_amount;

$att_name=$this->admin_model->get_table_row("business_attribute","ba_name_cw", ['ba_name'=>$ba_name]);
	$final_salary_table_with_previous_year .= '<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$att_name['ba_name_cw'].'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($ba_value,0).'</td>
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($ba_value_hike_amount,0).'</td>					
					</tr>';
				}

 }


				$final_salary_table_with_previous_year .='<tr>
					<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Fixed Pay</th>
					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format($fixed_ba_value,0).'</th>
					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format($fixed_ba_value_hike_amount,0).'</th>					
					</tr>
					

					</tbody>

					</table></div>';
// <tr>
// 					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Gratuity</td>
// 					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;"></td>
// 					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;"></td>					
// 					</tr>
// 					<tr>
// 					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Performance Pay (FY’18 on Actuals)</td>
// 					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;"></td>
// 					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;"></td>					
// 					</tr>
// 					<tr>
// 					<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Total Cost to Company (CTC)</th>
// 					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;"></th>
// 					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;"></th>					
// 					</tr>

$fixed_ba_value_hike_amount = "";
/// final salary only current year
$final_salary_table_only_current_year = '<div class="table-responsive"> 
<table id="example" style="width: 100%; cellspacing: 0;   border-collapse: collapse;">
					<thead>
						<tr>
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Components</th>
						
						<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Annualized FY’19 (Rs.)</th>
						</tr>
					</thead>
					<tbody>';

$elem = json_decode($salary[0]['increment_applied_on_elem_dtls']);
// echo '<pre>';
// print_r($elem);
// die;
foreach ($elem as $elem_val) { 
	if($elem_val->value>0){

$ba_name = $elem_val->ba_name;
$ba_value = $elem_val->value;
$fixed_ba_value += $elem_val->value;
$ba_value_hike_amount = $elem_val->value + ($elem_val->value*$salary[0]['manager_discretions'])/100;

$fixed_ba_value_hike_amount += $ba_value_hike_amount;
$att_name=$this->admin_model->get_table_row("business_attribute","ba_name_cw", ['ba_name'=>$ba_name]);

	$final_salary_table_only_current_year .= '<tr>
					<td style="padding: 8px; text-align: left; border: 1px solid #ddd;">'.$att_name['ba_name_cw'].'</td>
					
					<td style="padding: 8px; text-align: right; border: 1px solid #ddd;">'.number_format($ba_value_hike_amount,0).'</td>					
					</tr>';
				}

 }


				$final_salary_table_only_current_year .='<tr>
					<th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Fixed Pay</th>
					
					<th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;">'.number_format($fixed_ba_value_hike_amount,0).'</th>					
					</tr>
					


					</tbody>

					</table></div>';
					// <tr>
					// <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Gratuity</td>
					
					// <td style="padding: 8px; text-align: right; border: 1px solid #ddd;"></td>					
					// </tr>
					// <tr>
					// <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Performance Pay (FY’18 on Actuals)</td>
				
					// <td style="padding: 8px; text-align: right; border: 1px solid #ddd;"></td>					
					// </tr>
					// <tr>
					// <th style="padding: 8px; text-align: left; background-color: #4286f4; color: white; border: 1px solid #ddd;">Total Cost to Company (CTC)</th>
					
					// <th style="padding: 8px; text-align: right; background-color: #4286f4; color: white; border: 1px solid #ddd;"></th>					
					// </tr>

$page = str_replace("{{Name of the company}}",$salary[0]['company_name'],$page);
$page = str_replace("{{Employee Code}}",$get_ratingdata['employee_code'],$page);
$page = str_replace("{{Employee Full name}}",$salary[0]['emp_name'],$page);
$page = str_replace("{{Email ID}}",$salary[0]['email_id'],$page);
$salaryatt_list=$this->admin_model->get_table("business_attribute","ba_name,ba_name_cw", ['module_name'=>'salary']);
$page = str_replace("{{Books And Periodicals Allowances}}",HLP_get_formated_amount_common($salary[0]['allowance_13']),$page);
foreach($salaryatt_list as $key=>$value)
{
$name="{{".$value['ba_name_cw']."}}";
$page = str_replace($name,HLP_get_formated_amount_common($salary[0][$value['ba_name']]),$page);
}

$page = str_replace("{{BU Level-1 (top organisation)}}",$salary[0]['business_level_1']?$salary[0]['business_level_1']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{BU Level-2 (Division)}}",$salary[0]['business_level_2']?$salary[0]['business_level_2']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{BU Level-3 (Area)}}",$salary[0]['business_level_3']?$salary[0]['business_level_3']:BLANK_TEXT_FIELD_LETTER,$page);

		$page = str_replace("{{Function}}",$salary[0]['function']?$salary[0]['function']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{Designation/Title}}",$salary[0]['designation']?$salary[0]['designation']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{Employee First Name}}",$salary[0]['emp_first_name']?$salary[0]['emp_first_name']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{City}}",$salary[0]['city']?$salary[0]['city']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{Country}}",$salary[0]['country']?$salary[0]['country']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{Function}}",$salary[0]['function']?$salary[0]['function']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{Sub Function}}",$salary[0]['sub_function']?$salary[0]['sub_function']:BLANK_TEXT_FIELD_LETTER,$page);
		$page = str_replace("{{Sub Sub Function}}",$salary[0]['sub_sub_function']?$salary[0]['sub_sub_function']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Level}}",$salary[0]['level']?$salary[0]['level']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Education}}",$salary[0]['education']?$salary[0]['education']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Identified talent}}",$salary[0]['critical_talent']?$salary[0]['critical_talent']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Critical Position holder}}",$salary[0]['critical_position']?$salary[0]['critical_position']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Gender}}",$salary[0]['gender']?$salary[0]['gender']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Special Category-1}}",$salary[0]['special_category']?$salary[0]['special_category']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Date of Joining}}",$salary[0]['joining_date_the_company'],$page);
$page = str_replace("{{performance_rating}}",$salary[0]['performance_rating'],$page);
$page = str_replace("{{Date of joining for salary review purpose}}",$salary[0]['increment_purpose_joining_date'],$page);

$page = str_replace("{{Start date for role (for bonus calculation only)}}",$salary[0]['start_date_for_role'],$page);
$page = str_replace("{{End date of the role (for bonus calculation only)}}",$salary[0]['end_date_for_role'],$page);
$page = str_replace("{{Bonus/ Incentive applicability}}",HLP_get_formated_amount_common($salary[0]['bonus_incentive_applicable'],0),$page);
$page = str_replace("{{Recently Promoted (Yes/No)}}",$salary[0]['recently_promoted']?$salary[0]['recently_promoted']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Performance Achievement}}",$salary[0]['performance_achievement']?$salary[0]['performance_achievement']:BLANK_TEXT_FIELD_LETTER,$page);

// $get_ratingdata=$this->admin_model->get_table_row('login_user', '*',['id'=>$salary[0]['user_id']]);
   
$page = str_replace("{{Currency}}",$salary[0]['currency']?$salary[0]['currency']:BLANK_TEXT_FIELD_LETTER,$page);


 $previous_year=$this->admin_model->get_table_row('manage_rating_for_current_year', 'name',['id'=>$get_ratingdata['rating_for_last_year']]);

 $current_year=$this->admin_model->get_table_row('manage_rating_for_current_year', 'name',['id'=>$get_ratingdata['rating_for_current_year']]); 

 $second_year=$this->admin_model->get_table_row('manage_rating_for_current_year', 'name',['id'=>$get_ratingdata['rating_for_2nd_last_year']]); 
 
 $third_year=$this->admin_model->get_table_row('manage_rating_for_current_year', 'name',['id'=>$get_ratingdata['rating_for_3rd_last_year']]);  
 $fourth_year=$this->admin_model->get_table_row('manage_rating_for_current_year', 'name',['id'=>$get_ratingdata['rating_for_4th_last_year']]); 
 $fifth_year=$this->admin_model->get_table_row('manage_rating_for_current_year', 'name',['id'=>$get_ratingdata['rating_for_5th_last_year']]);

$page = str_replace("{{Performance Rating for previous year}}",$previous_year['name']?$previous_year['name']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Performance Rating for this year}}",$current_year['name']?$current_year['name']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Performance Rating for 2nd last year}}",$second_year['name']?$second_year['name']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Performance Rating for 3rd last year}}",$third_year['name']?$third_year['name']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Performance Rating for 4th last year}}",$fourth_year['name']?$fourth_year['name']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Performance Rating for 5th last year}}",$fifth_year['name']?$fifth_year['name']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Effective date of Last Salary increase}}",$get_ratingdata['effective_date_of_last_salary_increase']?$get_ratingdata['effective_date_of_last_salary_increase']:BLANK_DATE_FIELD_LETTER,$page);

$page = str_replace("{{Effective date of 2nd Salary increase}}",$get_ratingdata['effective_date_of_2nd_last_salary_increase']?$get_ratingdata['effective_date_of_2nd_last_salary_increase']:BLANK_DATE_FIELD_LETTER,$page);

$page = str_replace("{{Effective date of 3rd last Salary increase}}",$get_ratingdata['effective_date_of_3rd_last_salary_increase']?$get_ratingdata['effective_date_of_3rd_last_salary_increase']:BLANK_DATE_FIELD_LETTER,$page);

$page = str_replace("{{Effective date of 4th Last Salary increase}}",$get_ratingdata['effective_date_of_4th_last_salary_increase']?$get_ratingdata['effective_date_of_4th_last_salary_increase']:BLANK_DATE_FIELD_LETTER,$page);

$page = str_replace("{{Effective date of 5th Last Salary increase}}",$get_ratingdata['effective_date_of_5th_last_salary_increase']?$get_ratingdata['effective_date_of_5th_last_salary_increase']:BLANK_DATE_FIELD_LETTER,$page);


$page = str_replace("{{Base Salary after last increase}}",HLP_get_formated_amount_common($get_ratingdata['salary_after_last_increase']),$page);

$page = str_replace("{{Base Salary after 2nd last increase}}",HLP_get_formated_amount_common($get_ratingdata['salary_after_2nd_last_increase']),$page);

$page = str_replace("{{Base Salary after 3rd last increase}}",HLP_get_formated_amount_common($get_ratingdata['salary_after_3rd_last_increase']),$page);

$page = str_replace("{{Base Salary after 4th last increase}}",HLP_get_formated_amount_common($get_ratingdata['salary_after_4th_last_increase']),$page);

$page = str_replace("{{Base Salary after 5th last increase}}",HLP_get_formated_amount_common($get_ratingdata['salary_after_5th_last_increase']),$page);

$page = str_replace("{{Total Salary after last increase}}",HLP_get_formated_amount_common($get_ratingdata['total_salary_after_last_increase']),$page);

$page = str_replace("{{Total Salary after 2nd last increase}}",HLP_get_formated_amount_common($get_ratingdata['total_salary_after_2nd_last_increase']),$page);

$page = str_replace("{{Total Salary after 3rd last increase}}",HLP_get_formated_amount_common($get_ratingdata['total_salary_after_3rd_last_increase']),$page);

$page = str_replace("{{Total Salary after 4th last increase}}",HLP_get_formated_amount_common($get_ratingdata['total_salary_after_4th_last_increase']),$page);

$page = str_replace("{{Total Salary after 5th last increase}}",HLP_get_formated_amount_common($get_ratingdata['total_salary_after_5th_last_increase']),$page);


$page = str_replace("{{Target Salary after last increase}}",HLP_get_formated_amount_common($get_ratingdata['target_salary_after_last_increase']),$page);

$page = str_replace("{{Target Salary after 2nd last increase}}",HLP_get_formated_amount_common($get_ratingdata['target_salary_after_2nd_last_increase']),$page);

$page = str_replace("{{Target Salary after 3rd last increase}}",HLP_get_formated_amount_common($get_ratingdata['target_salary_after_3rd_last_increase']),$page);

$page = str_replace("{{Target Salary after 4th last increase}}",HLP_get_formated_amount_common($get_ratingdata['target_salary_after_4th_last_increase']),$page);

$page = str_replace("{{Target Salary after 5th last increase}}",HLP_get_formated_amount_common($get_ratingdata['target_salary_after_5th_last_increase']),$page);

$page = str_replace("{{Current target bonus}}",HLP_get_formated_amount_common($get_ratingdata['current_target_bonus']),$page);
$page = str_replace("{{Total compensation}}",HLP_get_formated_amount_common($get_ratingdata['total_compensation']),$page);
$page = str_replace("{{Increment to be applied on}}",HLP_get_formated_amount_common($get_ratingdata['increment_applied_on']),$page);
$page = str_replace("{{Market Data matching job code}}",$get_ratingdata['job_code']?$get_ratingdata['job_code']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Matched market job name}}",$get_ratingdata['job_name']?$get_ratingdata['job_name']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Matched job level}}",$get_ratingdata['job_level']?$get_ratingdata['job_level']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Manager Name}}",$get_ratingdata['manager_name']?$get_ratingdata['manager_name']:BLANK_TEXT_FIELD_LETTER,$page);
for($app=1;$app<5;$app++)
{
$name="{{Approver-".$app."}}";
$repname="approver_".$app."";
$page = str_replace($name,$salary[0][$repname]?$salary[0][$repname]:BLANK_TEXT_FIELD_LETTER,$page);
}

$page = str_replace("{{Authorised signatory}}",$get_ratingdata['authorised_signatory_for_letter']?$get_ratingdata['authorised_signatory_for_letter']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Authorised signatory's title}}",$get_ratingdata['authorised_signatorys_title_for_letter']?$get_ratingdata['authorised_signatorys_title_for_letter']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{HR Authorised signatory for letter}}",$get_ratingdata['hr_authorised_signatory_for_letter']?$get_ratingdata['hr_authorised_signatory_for_letter']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{HR Authorised signatory's title for letter}}",$get_ratingdata['hr_authorised_signatorys_title_for_letter']?$get_ratingdata['hr_authorised_signatorys_title_for_letter']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Teeth/Tail Ratio}}",$get_ratingdata['teeth_tail_ratio']?$get_ratingdata['teeth_tail_ratio']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Previous Talent Rating}}",$get_ratingdata['previous_talent_rating']?$get_ratingdata['previous_talent_rating']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Promoted in 2 yrs}}",$get_ratingdata['promoted_in_2_yrs']?$get_ratingdata['promoted_in_2_yrs']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Engagement level}}",$get_ratingdata['engagement_level']?$get_ratingdata['engagement_level']:BLANK_TEXT_FIELD_LETTER,$page);

$page = str_replace("{{Successor Identified}}",$get_ratingdata['successor_identified']?$get_ratingdata['successor_identified']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Readyness level}}",$get_ratingdata['readyness_level']?$get_ratingdata['readyness_level']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace("{{Urban/Rural classification}}",$get_ratingdata['urban_rural_classification']?$get_ratingdata['urban_rural_classification']:BLANK_TEXT_FIELD_LETTER,$page);
if($get_ratingdata['employee_movement_into_bonus_plan']=='0000-00-00')
{
$page = str_replace("{{Employee Movement into Bonus Plan}}",BLANK_DATE_FIELD_LETTER,$page);
}else
{
$page = str_replace("{{Employee Movement into Bonus Plan}}",$get_ratingdata['employee_movement_into_bonus_plan']?$get_ratingdata['employee_movement_into_bonus_plan']:BLANK_DATE_FIELD_LETTER,$page);	
}

for($other=9;$other<=20;$other++)
{
$name="{{Other Data-".$other."}}";
$repname="{{other_data_".$other."}}";
$page = str_replace($name,$salary[0][$repname]?$salary[0][$repname]:BLANK_TEXT_FIELD_LETTER,$page);
}

 $hr_parameters=$this->admin_model->get_table_row('hr_parameter','*',['id'=>$ruleID]);
if($hr_parameters['salary_position_based_on']=="2")
{
$page = str_replace('{{Current Positioning in pay range}}',$salary[0]['post_quartile_range_name']?HLP_get_formated_percentage_common($salary[0]['post_quartile_range_name']).'%':BLANK_TEXT_FIELD_LETTER,$page);
}
else
{

$page = str_replace('{{Current Positioning in pay range}}',HLP_get_formated_percentage_common($salary[0]['crr_val']).'%',$page);
}
$current_fixed_salary=HLP_get_formated_amount_common($salary[0]["increment_applied_on_salary"]-$salary[0]["current_target_bonus"]);

$page = str_replace('{{Current Fixed Salary}}',$current_fixed_salary,$page);

$fianl_fixed_salary=HLP_get_formated_amount_common($salary[0]["final_salary"]-($salary[0]["current_target_bonus"] + ($salary[0]["current_target_bonus"]*($salary[0]["sp_manager_discretions"] +$salary[0]["manager_discretions"])/100)));

$page = str_replace('{{Current Variable Salary}}',HLP_get_formated_amount_common($salary[0]["current_target_bonus"]),$page);

$page = str_replace('{{Current Total Salary}}',HLP_get_formated_amount_common($salary[0]["increment_applied_on_salary"]),$page,$page);

$page = str_replace('{{Final Fixed Salary}}',$fianl_fixed_salary,$page);

$rule_dtls=$this->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$salary[0]["rule_id"], "hr_parameter.status !="=>CV_STATUS_RULE_DELETED));	


$total_sal_incr_per = $salary[0]["manager_discretions"];
$IncrementAmount=HLP_get_formated_amount_common(($salary[0]["increment_applied_on_salary"]*$total_sal_incr_per)/100 - $salary[0]["sp_increased_salary"]);
$page = str_replace('{{Salary Increment Amount}}',$IncrementAmount,$page);

$page = str_replace('{{Salary increase recommended by manager}}',HLP_get_formated_percentage_common($total_sal_incr_per).'%',$page);

$all_hikes_total =$salary[0]["performnace_based_increment"]+$salary[0]["crr_based_increment"];
			$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rule_dtls["Manager_discretionary_increase"]/100);
			$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rule_dtls["Manager_discretionary_decrease"]/100);
$increaserange=(HLP_get_formated_percentage_common($manager_max_dec_per) .'% to '. HLP_get_formated_percentage_common($manager_max_incr_per).'%' ) ;

$page=str_replace('{{Salary increase range}}',$increaserange,$page);		
$page=str_replace('{{Salary Comments}}',$salary[0]["salary_comment"]?$salary[0]['salary_comment']:BLANK_TEXT_FIELD_LETTER,$page);		
$page=str_replace('{{Promotion Increase amount}}',HLP_get_formated_amount_common($salary[0]["sp_increased_salary"]),$page);

$sp_per=$salary[0]["sp_manager_discretions"];	
$page=str_replace('{{Promotion Increase %age}}',HLP_get_formated_amount_common($sp_per),$page);		
 
$page=str_replace('{{Promotion Comments}}',$salary[0]["promotion_comment"]?$salary[0]['promotion_comment']:BLANK_TEXT_FIELD_LETTER,$page);

$Final_Total_Increment_Amount=(HLP_get_formated_amount_common(($salary[0]["final_salary"]-$salary[0]["increment_applied_on_salary"])+$salary[0]["sp_increased_salary"]));
$page=str_replace('{{Final Total Increment Amount}}',number_format($Final_Total_Increment_Amount,0),$page);

$Final_Total_Increment_Amount_age=HLP_get_formated_percentage_common((float)$sp_per+$salary[0]["manager_discretions"]).'%';

$page=str_replace('{{Final Total increment %age}}',HLP_get_formated_percentage_common($Final_Total_Increment_Amount_age),$page);

$Final_New_Salary=HLP_get_formated_amount_common($salary[0]["final_salary"]);

$page=str_replace('{{Final New Salary}}',$Final_New_Salary,$page);

 $totalrevised=$salary[0]["current_target_bonus"] + ($salary[0]["current_target_bonus"]*($salary[0]["sp_manager_discretions"] + $salary[0]["manager_discretions"])/100);

$page=str_replace('{{Revised Variable Salary}}',HLP_get_formated_amount_common($totalrevised),$page);		

$Positioning_in_Pay_range=HLP_get_formated_percentage_common(($salary[0]["final_salary"]/$salary[0]["market_salary"])*100).'%';

$page=str_replace('{{New Positioning in Pay range}}',$Positioning_in_Pay_range,$page);

if($hr_parameters['esop_title']!='')
{
$additional_field1=$hr_parameters['esop_title'].' : '.$salary[0]["espo"];	
}
if($hr_parameters['esop_title']!='')
{
$additional_field2=$hr_parameters['pay_per_title'].' : '.$salary[0]["per_pay"];	
}
if($hr_parameters['esop_title']!='')
{
$additional_field3=$hr_parameters['retention_bonus_title'].' : '.$salary[0]["retention_bonus"];
}

$page=str_replace('{{Additional Field1}}',$additional_field1,$page);
$page=str_replace('{{Additional Field2}}',$additional_field2,$page);
$page=str_replace('{{Additional Field3}}',$additional_field3,$page);
if(!empty($salary[0]['emp_new_designation'])){
			$grade = $salary[0]['emp_new_designation'];
		}else{
			$grade = $salary[0]['grade'];
		}
		$page = str_replace("{{Grade}}",$grade,$page);
			
 					$page = str_replace("{{compensation_table}}",$compensation_table,$page);
					$page = str_replace("{{increment_breakup_table}}",$increment_breakup_table,$page);

					$page = str_replace("{{incentive_table}}",$incentive_table,$page);
					$page = str_replace("{{basic_info_table}}",$basic_info_table,$page);
					$page = str_replace("{{final_salary_table_with_previous_year}}",$final_salary_table_with_previous_year,$page);
					$page = str_replace("{{final_salary_table_only_current_year}}",$final_salary_table_only_current_year,$page);

					$page = str_replace("{{total_incentive_earned}}",number_format($revise_incentive_total,0),$page);
					}
   

   // replace tem data
   $remove_attname=array('education','critical_talent','critical_position','special_category','start_date_for_role','end_date_for_role','bonus_incentive_applicable','recently_promoted','performance_achievement','rating_for_current_year','rating_for_last_year','rating_for_2nd_last_year','rating_for_3rd_last_year','rating_for_4th_last_year','rating_for_5th_last_year','increment_applied_on','increment_purpose_joining_date','start_date_for_role','total_compensation','end_date_for_role');

 $salary_elememts= $this->db->query("SELECT * FROM `business_attribute` where  ba_grouping='Salary'  and status=1 ORDER BY `business_attribute`.`ba_attributes_order` ASC")->result_array();
 foreach ($salary_elememts as $value)
 {
    if(in_array($value['ba_name'],$remove_attname))
      { 
        continue; 
      }
    $att_list_array[$value['ba_name']]=$value['ba_name_cw'];     
 }
 // print_r($get_tempdata);
 // die;
if(!empty($get_tempdata))
{
 foreach($att_list_array as $key=>$value)
 {
	 $name="{{Temp ".$value."}}";
	 $page = str_replace($name,HLP_get_formated_amount_common($get_tempdata[$key]),$page);	
 }
     $page=str_replace("{{Temp Books And Periodicals Allowances}}",HLP_get_formated_amount_common($get_tempdata['allowance_13']),$page);
    $page=str_replace("{{Temp Total compensation}}",HLP_get_formated_amount_common($get_tempdata['total_compensation']),$page);		
    $page=str_replace("{{Temp Revised Fixed Salary}}",HLP_get_formated_amount_common($get_tempdata['revised_fixed_salary']),$page);	
}
else
{
 foreach($att_list_array as $key=>$value)
 {
	 $name="{{Temp ".$value."}}";
	 $page = str_replace($name,'',$page);	
 }
$page=str_replace("{{Temp Books And Periodicals Allowances}}",'',$page);
$page=str_replace("{{Temp Total compensation}}",'',$page);		
$page=str_replace("{{Temp Revised Fixed Salary}}",'',$page);		
}

$page = str_replace('{{New Level}}',$salary[0]['emp_new_level']?$salary[0]['emp_new_level']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace('{{New Designation}}',$salary[0]['emp_new_designation']?$salary[0]['emp_new_designation']:BLANK_TEXT_FIELD_LETTER,$page);
$page = str_replace('{{New Grade}}',$salary[0]['emp_new_grade']?$salary[0]['emp_new_grade']:BLANK_TEXT_FIELD_LETTER,$page);
// print_r($att_list_array);
// echo '<br><br>';
// print_r($get_tempdata);
// echo '<br><br>';

   echo $page;
//die; 
// echo 'fdgdfg'.$page;
		//die;
		   ?>
</body>
</html>