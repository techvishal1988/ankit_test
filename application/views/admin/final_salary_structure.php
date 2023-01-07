<?php ?>
<style type="text/css">
 /********dynamic colour for table from company colour***********/
 .tablecustm>thead>tr:nth-child(odd)>th{background-color:<?php echo hex2rgb($this->session->userdata('company_color_ses'), ".9"); ?>!important; }
 .tablecustm>thead>tr:nth-child(even)>th{background-color:<?php echo hex2rgb($this->session->userdata('company_color_ses'), "0.6"); ?>!important;}


 .tablecustm>tbody>tr:nth-child(odd)>td{background-color:<?php echo hex2rgb($this->session->userdata('company_light_color_ses'), "0.1"); ?>!important;}

 .tablecustm>tbody>tr:nth-child(odd)>td input.form-control{background-color:<?php echo hex2rgb($this->session->userdata('company_light_color_ses'), "0.1"); ?>!important;}

 .tablecustm>tbody>tr:nth-child(odd)>td select.form-control{background-color:<?php echo hex2rgb($this->session->userdata('company_light_color_ses'), "0.1"); ?>!important;}

 .tablecustm>thead>tr>th{ vertical-align: middle;}
 .tablecustm tr td span{    color: unset;
  font-size: unset;
  text-align: unset;}

</style>


<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="<?php echo site_url("flexi-plan-filters"); ?>">Set flexi Rule Filters</a></li>
    <li class="active"><?php echo (isset($title)) ? $title : ''; ?></lti>
    </ol>
  </div>

  <div id="main-wrapper" class="container aop">
    <div class="row">

      <div class="col-md-12">
        <div class="mb20">

          <div class="panel panel-white">   
            <?php echo $this->session->flashdata('message'); ?> 

            <div class="panel-body">
              <div class="rule-form">

                <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                  <?php echo HLP_get_crsf_field(); ?>
                  <div class="form-group">
                    <div class="">
                      <div class="col-sm-12">
                        <div class="form_head clearfix">
                          <div class="col-sm-12">
                            <ul>
                              <li>
                                <div class="form_tittle">
                                  <h4>Final Salary Structure</h4>
                                </div>
                              </li>
                            </ul>
                          </div>

                        </div> 
<!--
-->     <div class="form_sec clearfix" id="dv_frm_head">
  <?php //print_r($salary_applied_on_elem_list);die(); ?>
  <div class="col-sm-12">
    <div class="table-responsive">

      <table style="margin-bottom:10px;" class="table tablecustm table-bordered">
        <thead>
          <tr>
            <th>Salary Elements</th>
            <th>Type of Element</th>
            <th>Fixed Salary Element</th>
            <th>Condition</th>
            <th>Applicability</th>
            <th>Part of <br> Flexi pay</th>
            
            <?php 
if($flaxi_plan['flexi_type'] == 'grade'){
$list = $gradelist;
$text = "Grade";
            }else{
$list = $levellist;
$text = "Level";
            }
            //print_r($list);
            for ($i = 0; $i < count($list); $i++) { ?>
              <th><?php echo $text.' - '.$list[$i]['name']; ?></th>
            <?php } ?>
<input type="hidden" name="flexi_type" value="<?php echo strtolower($text); ?>">
          </tr>


        </thead>
        <tbody>
          <?php
//                                                           
          $current_base_salary_id = $current_base_salaryarr[0]['id'];

          $current_esic_salary_id = $current_esic_salaryarr[0]['id'];

          for ($l = 0; $l < count($salary_applied_on_elem_list); $l++) {

  $final_salary_row = HLP_get_salary_element_based_final_salary_row($salary_applied_on_elem_list[$l]['business_attribute_id'],$flaxi_plan['id']); 


            ?>
            <tr>
              <td ><span style="width:130px; display:block;"><?php echo $salary_applied_on_elem_list[$l]['display_name']; ?></span></td>
              <td>
                 <select style="width:95px; <?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id || $salary_applied_on_elem_list[$l]['business_attribute_id']==$current_esic_salary_id){ echo ''; } ?>" name="ddl_type_of_element_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" id="ddl_type_of_element_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" class="form-control typeelement"  onchange="putvalidation('<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>')" >
                <option value="">Select</option>
                <option value="1" <?php if($final_salary_row['type_of_element']==1){ echo 'selected';} ?>>% of Fixed Pay</option>
                <option value="2" <?php if($final_salary_row['type_of_element']==2){ echo 'selected';} ?>>% of Basic</option>
                <option value="3" <?php if($final_salary_row['type_of_element']==3){ echo 'selected';} ?>>Fixed Amount</option>
                <option value="4" <?php if($final_salary_row['type_of_element']==4){ echo 'selected';} ?>>Data Upload</option>
                <option value="5" <?php if($final_salary_row['type_of_element']==5){ echo 'selected';} ?>>Remainder Value</option>
              </select>
            </td>
              <td><input style="height:14px !important; margin-top:6px;" type="checkbox"  class="form-control" name="ddl_fixed_salary_element_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" id="ddl_fixed_salary_element_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" value="1" <?php if($final_salary_row['fixed_salary_element']==1){ echo 'checked';} ?>></td>
              <td>
                <select style="width:95px; <?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){  }else{ if($final_salary_row['type_of_element']==4 || $final_salary_row['type_of_element']==5){ echo 'pointer-events:none;';} } ?>" name="ddl_condition_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" id="ddl_condition_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" class="form-control"  onchange="putcondition('<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>')"  required>
                <option value="">Select</option>
                <option value="1"  <?php if($final_salary_row['salary_condition']==1){ echo 'selected';} ?>>Amount is less or equal to Basic Salary</option>
                <option value="2" <?php if($final_salary_row['salary_condition']==2){ echo 'selected';} ?>>Amount is greater than Basic salary</option> 
                <option value="3" <?php if($final_salary_row['salary_condition']==3){ echo 'selected';} ?>>Amount is less or equal to Fixed Salary</option> 
                <option value="4" <?php if($final_salary_row['salary_condition']==4){ echo 'selected';} ?>>Amount is greater than Fixed salary</option>
                <option value="5" <?php if($final_salary_row['salary_condition']){if($final_salary_row['salary_condition']==5){ echo 'selected';}}else{echo "selected";} ?>>Not Applicable</option>   
              </select></td>
              <td><input  style="width:65px; text-align:center; <?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){ echo 'pointer-events:none;'; }else{ if($final_salary_row['type_of_element']==4 || $final_salary_row['type_of_element']==5){ echo 'pointer-events:none;';}} ?>" value="0" type="text" name="txt_applicability_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" id="txt_applicability_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);" required   class="form-control mar_bot" value="<?php if($final_salary_row['applicability']){echo round($final_salary_row['applicability'], 0); }else if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){ echo 0; } ?>"></td>
              <td><input style="height:14px !important; margin-top:6px; width:50px;" type="checkbox" style="<?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){ echo 'pointer-events:none;'; }else{ if($final_salary_row['type_of_element']==4 || $final_salary_row['type_of_element']==5){ echo 'pointer-events:none;';}} ?>"  class="form-control " name="txt_part_of_flexi_pay_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" id="txt_part_of_flexi_pay_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" value="1" <?php if($final_salary_row['part_of_flexi_pay']==1){ echo 'checked';} ?> onclick="enablerange('<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>');"></td>
             
              <?php
               $samount=explode(',',$final_salary_row['amount']);
               $smin_range=explode(',',$final_salary_row['min_range']);
               $smax_range=explode(',',$final_salary_row['max_range']);
              for ($j = 0; $j < count($list); $j++) {
                $part_of_flexi_pay =  $final_salary_row['part_of_flexi_pay'];
                $final_salary_grade_wise_row = HLP_get_salary_element_based_final_salary_grade_wise_row($salary_applied_on_elem_list[$l]['business_attribute_id'],$list[$j]['id']); 
               ?>
               <td>
                <input  style="width:65px; text-align:center; <?php if($final_salary_row['type_of_element']==4 || $final_salary_row['type_of_element']==5){ echo 'pointer-events:none;';} if($part_of_flexi_pay==1){ echo 'display: none'; }?>" type="text" name="txt_grade_val_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] . "[]" ?>"  class="form-control mar_bot txt_grade_val_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" value="<?php echo $samount[$j] ?>"  <?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){ ?> onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3d);" <?php }  ?>  onchange="fill_below_value(this.value,'<?php echo $j; ?>','txt_grade_val_','<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>');" >
               <input style="width:65px; margin-bottom:10px !important; text-align:center; <?php if($final_salary_row['type_of_element']==4 || $final_salary_row['type_of_element']==5){ echo 'pointer-events:none;';}  if($part_of_flexi_pay!=1){ echo 'display: none'; }?>" type="text" name="txt_min_val_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] . "[]"  ?>"  class="form-control mar_bot txt_min_val_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" value="<?php echo $smin_range[$j] ?>"  <?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){ ?> onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3d);" <?php }  ?> placeholder="Min Range"  onchange="fill_below_value(this.value,'<?php echo $j; ?>','txt_min_val_','<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>');">
                 <input style="width:65px; text-align:center; <?php if($final_salary_row['type_of_element']==4 || $final_salary_row['type_of_element']==5){ echo 'pointer-events:none;';} if($part_of_flexi_pay!=1){ echo 'display: none'; }?>" type="text" name="txt_max_val_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] . "[]" ?>"  class="form-control mar_bot txt_max_val_<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>" value="<?php echo $smax_range[$j] ?>"  <?php if($salary_applied_on_elem_list[$l]['business_attribute_id']==$current_base_salary_id){ ?> onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3d);" <?php }  ?> placeholder="Max Range" onchange="fill_below_value(this.value,'<?php echo $j; ?>','txt_max_val_','<?php echo $salary_applied_on_elem_list[$l]['business_attribute_id'] ?>');"></td>
             <?php } ?>
           <?php } ?>
         </tbody>
       </table>   

     </div>                                     
   </div>
 </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-sm-12 mob-center text-right">  
    <input type="submit" id="btnAdd" name="btnAdd" value="Submit" class="btn mar_l_5 btn-success" />

  </div>
</div>   
</form>
</div>
</div>                 
</div>
</div>
</div>
</div>
</div>


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
    height: 24px !important;
    margin-top: 0px;
    font-size: 10px;
    background-color: #FFF;
    /*margin-bottom:10px;*/
    padding: 3px 3px !important;
  }
  .rule-form .control-label {
    font-size: 12px;
    <?php /* ?>background-color: rgba(147, 195, 1, 0.2);<?php */ ?> background-color: #<?php echo $this->session->userdata("company_light_color_ses");
    ?>;
    margin-bottom:10px;
  }
  .rule-form .form-control:focus {
    box-shadow: none!important;
  }
  .rule-form .form_head {
    background-color: #f2f2f2;
    <?php /* ?>border-top: 8px solid #93c301;<?php */ ?> border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
    ?>;
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
    /*color: #8b8b8b;*/
    font-size: 24px;
    padding: 7px;
    margin-top: -4px;
  }
  .rule-form .form_sec {
    background-color: #f2f2f2;
    display: block;
    width: 100%;
    padding: 5px 0px 9px 0px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
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
  .form-group {
    margin-bottom: 10px;
  }
  .mailbox-content, .panel-white {
    padding-bottom: 2px;
  }
  .paddg {
    0px 20px;
  }

  .msgtxtalignment .msg-left{
    width: 29%;
    display: inline-block;
  }

  .msgtxtalignment .msg-left .alert-success{background:transparent; padding-right: 0px;}

  .msgtxtalignment .msg-left .close{display:none;}

  .msgtxtalignment .msg-right{
    width: 55% !important;
    display: inline-block !important;
  }

  .alert 
  {
    margin-bottom: -10px !important;
    margin-top: -5px !important;
  }

  .rule-form .form-control.mar_bot{margin-bottom: 0px !important; }

</style>

<script type="text/javascript">
  $( document ).ready(function() {
    var remider_id = '<?php echo $reminderarr['allowance_id']; ?>';
    if(remider_id){
      $(".typeelement option[value*='5']").remove(); 
    }  
    $('#ddl_type_of_element_'+remider_id).append('<option value="5" selected>Reminder Value</option>');
  });


  function putvalidation(ba_id){
    var type_of_element = $("#ddl_type_of_element_"+ba_id).val();

    if(type_of_element==1 || type_of_element==2){

      $(".txt_grade_val_"+ba_id).attr({
        'onKeyUp': 'validate_percentage_onkeyup_common(this,3)',
        'onBlur': 'validate_percentage_onblure_common(this,3)'
      });
      $(".txt_min_val_"+ba_id).attr({
        'onKeyUp': 'validate_percentage_onkeyup_common(this,3)',
        'onBlur': 'validate_percentage_onblure_common(this,3)'
      });
      $(".txt_max_val_"+ba_id).attr({
        'onKeyUp': 'validate_percentage_onkeyup_common(this,3)',
        'onBlur': 'validate_percentage_onblure_common(this,3)'
      });
      $('#ddl_condition_'+ba_id).val('');
      $("#ddl_condition_"+ba_id).css('pointer-events','');
      $('#txt_applicability_'+ba_id+","+".txt_grade_val_"+ba_id).val('');
      $("#txt_applicability_"+ba_id+","+".txt_grade_val_"+ba_id+","+".txt_min_val_"+ba_id+","+".txt_max_val_"+ba_id).css('pointer-events','');
       $("#txt_part_of_flexi_pay_"+ba_id).css('pointer-events','');
      exists = 0 != $("#ddl_type_of_element_"+ba_id+" option[value*='5']").length;

      if(exists){
       $(".typeelement option[value*='5']").remove();  
       $('.typeelement').append('<option value="5">Reminder Value</option>');
     }

   }else if(type_of_element==3){
    $(".txt_grade_val_"+ba_id).attr({
      'onKeyUp': 'validate_onkeyup_num(this)',
      'onBlur': 'validate_onblure_num(this)'
    });
    $(".txt_min_val_"+ba_id).attr({
      'onKeyUp': 'validate_onkeyup_num(this)',
      'onBlur': 'validate_onblure_num(this)'
    });
    $(".txt_max_val_"+ba_id).attr({
      'onKeyUp': 'validate_onkeyup_num(this)',
      'onBlur': 'validate_onblure_num(this)'
    });
    $('#ddl_condition_'+ba_id).val('');
    $("#ddl_condition_"+ba_id).css('pointer-events','');
    $('#txt_applicability_'+ba_id+","+".txt_grade_val_"+ba_id).val('');
    $("#txt_applicability_"+ba_id+","+".txt_grade_val_"+ba_id+","+".txt_min_val_"+ba_id+","+".txt_max_val_"+ba_id).css('pointer-events','');
     $("#txt_part_of_flexi_pay_"+ba_id).css('pointer-events','');
    exists = 0 != $("#ddl_type_of_element_"+ba_id+" option[value*='5']").length;

    if(exists){
      $(".typeelement option[value*='5']").remove();  
      $('.typeelement').append('<option value="5">Reminder Value</option>');
    }

  }else if(type_of_element==4){


    $('#ddl_condition_'+ba_id).val(5);
    $("#ddl_condition_"+ba_id).css('pointer-events','none');
 $("#txt_part_of_flexi_pay_"+ba_id).css('pointer-events','none');


    $('#txt_applicability_'+ba_id+","+".txt_grade_val_"+ba_id+","+".txt_min_val_"+ba_id+","+".txt_max_val_"+ba_id).val(0);
    $("#txt_applicability_"+ba_id+","+".txt_grade_val_"+ba_id+","+".txt_min_val_"+ba_id+","+".txt_max_val_"+ba_id).css('pointer-events','none');
    exists = 0 != $("#ddl_type_of_element_"+ba_id+" option[value*='5']").length;

    if(exists){
      $(".typeelement option[value*='5']").remove(); 
      $('.typeelement').append('<option value="5">Reminder Value</option>');
    }

  }else if(type_of_element==5){
    $(".typeelement option[value*='5']").remove();   
    $('#ddl_type_of_element_'+ba_id).append('<option value="5">Reminder Value</option>');
    $('#ddl_type_of_element_'+ba_id).val(5);
    $('#ddl_condition_'+ba_id).val(5);
    $("#ddl_condition_"+ba_id).css('pointer-events','none');

    $('#txt_applicability_'+ba_id+","+".txt_grade_val_"+ba_id+","+".txt_min_val_"+ba_id+","+".txt_max_val_"+ba_id).val(0);
    $("#txt_applicability_"+ba_id+","+".txt_grade_val_"+ba_id+","+".txt_min_val_"+ba_id+","+".txt_max_val_"+ba_id).css('pointer-events','none');
     $("#txt_part_of_flexi_pay_"+ba_id).css('pointer-events','none');

  }

}


function putcondition(ba_id){
  var ddl_condition = $("#ddl_condition_"+ba_id).val();
  if(ddl_condition==5){
    $("#txt_applicability_"+ba_id).val(0);
    $("#txt_applicability_"+ba_id).css('pointer-events','none');

  }else{
   $('#txt_applicability_'+ba_id).val('');
   $("#txt_applicability_"+ba_id).css('pointer-events','');
 }
}


// $(".typeelement").change(function(e)
//  {
//     var id = this.id.split("ddl_type_of_element_");

//     if($("#"+this.id).val()==5){
//    $(".typeelement option[value*='5']").hide();
//    $("#"+this.id+" option[value*='5']").show();
//    $('#ddl_condition_'+id[1]).val(5);
//     $("#ddl_condition_"+id[1]).css('pointer-events','none');
//       $('#txt_applicability_'+id[1]+","+".txt_grade_val_"+id[1]).val(0);
//     $("#txt_applicability_"+id[1]+","+".txt_grade_val_"+id[1]).css('pointer-events','none');

// }else{
//       $(".typeelement option[value*='5']").show();
//       $('#ddl_condition_'+id[1]).val('');
//     $("#ddl_condition_"+id[1]).css('pointer-events','');
//       $('#txt_applicability_'+id[1]+","+".txt_grade_val_"+id[1]).val('');
//     $("#txt_applicability_"+id[1]+","+".txt_grade_val_"+id[1]).css('pointer-events','');
// }

// });


function enablerange(ba_id){

  if($("#txt_part_of_flexi_pay_"+ba_id).prop("checked") == true){
   $('.txt_grade_val_'+ba_id).val('');
   $('.txt_grade_val_'+ba_id).hide();
    $('.txt_min_val_'+ba_id).show();
    $('.txt_max_val_'+ba_id).show();
    
    
  }
  else{
    $('.txt_grade_val_'+ba_id).show();
    $('.txt_min_val_'+ba_id).hide();
    $('.txt_max_val_'+ba_id).hide();
    $('.txt_min_val_'+ba_id).val('');
    $('.txt_max_val_'+ba_id).val('');
  }
}

</script>

<script>
    function fill_below_value(fillval, indx,fieldname, id)
    {
    
        var i = 0;
        $("."+fieldname + id).each(function () {
            //  alert(i);
            if (i > indx)
            {
//            if ($(this).val() == "0.00" || $(this).val() == "0" || $(this).val() == "") {
                $(this).val(fillval);
            }
            i++;
//            }
        })
    }
</script> 