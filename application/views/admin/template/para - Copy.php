<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="<?php echo base_url("assets/plugins/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css"/>
  <script src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
  <script src="<?php echo base_url("assets/plugins/jquery/jquery-2.1.4.min.js");?>"></script>
</head>
<style>
.my_bg2{
position:absolute;

//border:red solid 1px;
//width:595px;
//height:842px;

}

.textCon2 {
    position: absolute;
    top: 170px;
    left: 80px;
    width: 85%;
    padding: 24px;
    /* padding-left: 102px; */
    margin-top: 50px;
    margin: 22px 0px;
    //border: green solid 1px;
}

</style>
<body>


  


<div class="container-fluid">
    <div class="container"> 
	  <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12">
		   	    	   <div class="my_bg2">
	     <!--<img style="width:100%;"  src="<?php echo $latterhead[0]->latter_head_url ?>" class="" /> -->
	   </div>
	     
        <div class="textCon2">
<?php
		   
		   $page=$templatedesc[0]->TemplateDesc;
$staff_list=GetEmpAllDataFromEmpsal($staff_list);
$emmpinfo=getempdesc($staff_list,$staff_list[0]['id']); 

$page = str_replace("{{employee_name}}",@$emmpinfo['name'],$page);
$page = str_replace("{{email}}",@$emmpinfo['email'],$page);
$page = str_replace("{{employee_function}}",@$emmpinfo['function'],$page);
$page = str_replace("{{business_unit}}",@$emmpinfo['business_unit_3'],$page);
$page = str_replace("{{employee_title}}",@$emmpinfo['desig'],$page);
$page = str_replace("{{salary_increase}}",@$emmpinfo['Salary after last increase'],$page);
$page = str_replace("{{new_base_salary}}",@$emmpinfo['crr_based_salary'],$page);
$page = str_replace("{{new_target_bonus}}",@$emmpinfo['target_bonus'],$page);
$page = str_replace("{{long_term_incentive_allocated}}",@$emmpinfo['final_incentive'],$page);
$page = str_replace("{{target_lti_amount}}",@$emmpinfo['actual_incentive'],$page);
$page = str_replace("{{bonus_payout}}",@$emmpinfo['Current target bonus'],$page);
$page = str_replace("{{new_target_bonus}}",@$emmpinfo['final_bonus_per'],$page);
$page = str_replace("{{vesting_table}}",@$emmpinfo['target_lti_dtls'],$page);
$page = str_replace("{{target_lti}}",@$emmpinfo['actual_incentive'],$page);
$page = str_replace("{{target_bonus_for_current_year}}",@$emmpinfo['target_bonus'],$page);
$page = str_replace("{{bonus_amount_for_current_year}}",@$emmpinfo['final_bonus_per'],$page);
$page = str_replace("{{salary_review}}",@$emmpinfo['crr_based_salary'],$page);
$page = str_replace("{{bonus_multiplier_allocated}}",((@$emmpinfo['individual_weightage']*@$emmpinfo['individual_achievement'])+(@$emmpinfo['bl_3_weightage']*@$emmpinfo['bl_3_achievement'])+(@$emmpinfo['bl_2_weightage']*@$emmpinfo['bl_2_achievement'])+(@$emmpinfo['bl_1_weightage']*@$emmpinfo['bl_1_achievement'])+(@$emmpinfo['function_weightage']*@$emmpinfo['function_achievement'])),$page);

echo $page;

		   ?>
	 
        </div>
		</div>
	  

	  
	  </div>
   
    </div>
</div>

<script>



    //myWindow = window.open("http://localhost/comp-ben-user-portal/admin/template/print_latter/2/1/1", "", "width=auto, height=auto");
	window.print();


</script>
</body>
</html>
