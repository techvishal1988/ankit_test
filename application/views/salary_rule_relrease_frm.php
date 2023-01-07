<form onsubmit="return confirm('<?php echo CV_CONFIRMATION_MESSAGE;?>')" method="post" action="" id="release_letter">
<?php echo HLP_get_crsf_field(); ?>
<input type="hidden" name="hf_rule_id" value="<?php echo $rule_dtls["id"]; ?>" id="hf_rule_id"/>
<input type="hidden" name="TempateID" id="TempateID">
<input type="hidden" name="manager_ids" id="manager_ids">
<input type="hidden" name="hf_manager_ids_for_emp_release" id="hf_manager_ids_for_emp_release">
<p>Release Letter To Manager <span class="pull-right">
<input  type="button" name="btn_send_to_manager" value="Release To Managers" id="btn_send_to_manager" class="btn btn-success">
&nbsp;
<input type="button" name="btn_release_to_emps" value="Release To Employees" class="btn btn-success" id="btn_release_to_emps">
</span> </p>
<div class="table-responsive" id="manager_list">
<table class="table border" style="width: 100%; cellspacing:0;">
  <thead>
	<tr>
	  <th>Manager name</th>
	  <th>Number of employees</th>
	  <th>Fourth Approval completed</th>
	  <th>Release letter to managers
		<div class="beg_color">
		  <label class="black"> &nbsp;
		  <input type="checkbox"  style="opacity:1; margin-top:1px;"  id="checkAll">
		  <span></span></label>
		  Check All </div></th>
	  <th>Release letter to employees
		<div class="beg_color">
		  <label class="black"> &nbsp;
		  <input type="checkbox"  style="opacity:1; margin-top:1px;"  id="check_emp_All">
		  <span></span></label>
		  Check All </div></th>
	  <!--  <th> Action </th> -->
	</tr>
  </thead>
  <tbody id="tbl_manager_list_body">
  	<?php 		
	$managers_bdgt_dtls_arr = json_decode($rule_dtls['managers_bdgt_dtls_for_tbl'], true);
	foreach($managers_bdgt_dtls_arr as $row)
	{
		$letter_status = HLP_get_table_data('employee_salary_details', 'id', array('approver_1'=>$row['manager_email'],'rule_id'=>$rule_dtls["id"],'letter_status >='=>1)) ;
		$letter_status_for_emp = HLP_get_table_data('employee_salary_details', 'id', "rule_id = ".$rule_dtls["id"]." AND approver_1 = '".$row['manager_email']."' AND (letter_status = 2 OR letter_status = 3)") ;
		$approve_count = HLP_get_table_data('employee_salary_details', 'id', array('approver_1'=>$row['manager_email'],'rule_id'=>$rule_dtls["id"],'status='=>5)); ?>
		<tr>
			<td>
				<?php
				if($row['manager_name'])
				{
					echo $row['manager_name'];		
				}
				else
				{
					echo $row['manager_email'];		
				}  ?>
			</td>
			<td class="text-center"><?php echo $row['total_employees']; ?></td>
			<td class="text-center">
				<?php 
				if(!empty($approve_count))
				{ ?> 
					<span class="label label-success" style="color: #ffffff;font-size: 13px;background-color: #5cb85c;padding: 6px;">Completed</span>
				<?php }else{ ?> 
					<span class="label label-warning" style="color: #ffffff;font-size: 13px;padding: 6px;background-color:#f0ad4e;">Pending</span>
				 <?php } ?>			
			</td>
			<td class="text-center">
				<div class="beg_color" style="width: 100%;">
					<label class="black"> &nbsp; 
						<input type="checkbox" name="managers[]" <?php if(empty($approve_count)){ echo 'disabled '; echo ' class="notcheckbox"'; echo 'value=""';} ?> <?php if(count($letter_status)==$row['total_employees']){ echo 'checked disabled ';  echo ' class="notcheckbox"'; echo 'value=""';}else{ echo 'class="checkbox"';echo 'value="'.$row['manager_email'].'"';}?> style="opacity:1; margin-top:1px;"><span></span>
					</label>
				</div>
			 </td>
			<td class="text-center">
			  <div class="beg_color">
						<label class="black"> &nbsp; 
							<input type="checkbox" name="chk_manager_to_release_emps[]" <?php if(empty($approve_count)){ echo 'disabled '; echo ' class="notcheckbox"'; echo 'value=""';} ?> <?php if(count($letter_status_for_emp)==$row['total_employees']){ echo 'checked disabled ';  echo ' class="notcheckbox"'; echo 'value=""';}else{ echo 'class="emp_checkbox"';echo 'value="'.$row['manager_email'].'"';}?> style="opacity:1; margin-top:1px;">
							<span></span>
						</label>
				 </div>
			 </td> 
		</tr>
  	<?php } ?>
	
  </tbody>
</table>
</div>
 </form>
<script>
$('#checkAll').on('change', function() 
{   
	$('.checkbox').prop('checked', $(this).prop("checked"));
});

$(document).on('change','.checkbox', function() 
{     
	if($('.checkbox:checked').length == $('.checkbox').length){
		$('#checkAll').prop('checked',true);
	}else{
		$('#checkAll').prop('checked',false);
	}
});

$('#check_emp_All').on('change', function() 
{   
	$('.emp_checkbox').prop('checked', $(this).prop("checked"));
});

$(document).on('change','.emp_checkbox', function() 
{     
	if($('.emp_checkbox:checked').length == $('.emp_checkbox').length){
		$('#check_emp_All').prop('checked',true);
	}else{
		$('#check_emp_All').prop('checked',false);
	}
});


$('#btn_send_to_manager').click(function(event)
{
	var managers = [];
	$("#loading").show();
	$.each($("input[name='managers[]']:checked"), function()
	{ 
		if($(this).val())
		{           
			managers.push($(this).val());
		}	
	});
	if(managers.length==0)
	{
		$("#loading").hide();
		custom_alert_popup('Please select at least one manager for release letter.');
		return false;
	}
	var conf = confirm('<?php echo CV_CONFIRMATION_MESSAGE;?>');
	if(!conf)
	{
		$("#loading").hide();
		return false;
	}
	$('#manager_ids').val(managers.join(","));
	$.ajax({
		url:'<?php echo base_url('performance_cycle/releaseLetterToManager'); ?>',
		type: 'POST',
		data:$('#release_letter').serialize(),
	})
	.done(function(data)
	{
		location.reload(true);
	});
});

$('#btn_release_to_emps').click(function(event)
{
	var managers = [];
	$("#loading").show();
	$.each($("input[name='chk_manager_to_release_emps[]']:checked"), function(){ 
		if($(this).val())
		{           
			managers.push($(this).val());
		}	
	});
	if(managers.length==0)
	{
		$("#loading").hide();
		custom_alert_popup('Please select at least one manager for release letter.');
		return false;
	}
	
	var conf = confirm('<?php echo CV_CONFIRMATION_MESSAGE;?>');
	if(!conf)
	{
		$("#loading").hide();
		return false;
	}
	
	$('#hf_manager_ids_for_emp_release').val(managers.join(","));
	$.ajax({
		url:'<?php echo base_url('performance_cycle/finalReleaseLetterToEmployee'); ?>',
		type: 'POST',
		data:$('#release_letter').serialize(),
	})
	.done(function(data)
	{
		location.reload(true);
	});

});
</script>
