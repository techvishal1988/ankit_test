<style>.mailbox-content table tbody tr:nth-child(odd){background:none;}
/*.mailbox-content table tbody tr td{ font-size: 11px !important; }*/
.beg_color input[type="checkbox"]+span:before{width:19px; height: 19px; margin-top:1px;}
</style>
<div class="page-breadcrumb">
   <div class="row">
   <div class="col-sm-8">
    <ol class="breadcrumb wn_btn" style="padding-top: 6px !important;">
<!--        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li><a  href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
        <li class="active">Salary Review</li>
     
      </ol>
      </div>
        <div class="col-sm-4">
         <?php 
               if(helper_have_rights(CV_COMP_SALARY, CV_INSERT_RIGHT_NAME)) { 
          if($cycle_dtls["is_adhoc_cycle"]==2){?>
        <div class="pull-right">
            <a href="<?php echo site_url("salary-rule-filters/".$performance_cycle_id); ?>"><button class="create_new_rule_btn btn btn-success" type="button">Create New Salary Review</button></a>
        </div>
               <?php }} ?>
     </div>
     </div>    
</div>

<div class="modal fade" id="emailTemplate" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
                    <?php echo HLP_get_crsf_field();?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><label style="font-size: 16px;">Email To be send</label></h4>
         
        </div>
        
        <div class="modal-body">
          <div id="exTab2" > 
          <ul class="nav nav-tabs">
          <li class="active">
          <a  href="#1" data-toggle="tab">First Time Mail</a>
          </li>
          <li><a href="#2" data-toggle="tab">Reminder Mail</a>
          </li>

          </ul>

          <div class="tab-content">
          <div class="tab-pane active" id="1">
          <div id="setBody1">

          </div>



          <div class="modal-footer" id="setFooter1">

          </div>
          </div>
          <div class="tab-pane" id="2">
          <div  id="setBody2">

          </div>



          <div class="modal-footer" id="setFooter2">

          </div>
          </div>

          </div>
  </div>
        </div>

        
       
      </div>
      
    </div>
</div> 


<div id="main-wrapper" class="container-fluid">
<div class="col-md-12 background-cls">
   <div class="mailbox-content ">
<?php echo $this->session->flashdata('message');
      echo $msg;
      $is_show_null_record_msg = 1;
	  $is_show_comparison_btn = 0;
      
      ?>
   	<?php if($salary_rule_list){
                $is_show_null_record_msg = 0;
                $empcount=0;
                foreach($totalempinrule as $emp)
                {
                    //$empcount+=count(explode(',',$emp['user_ids'])).'-';
                     $empcount += $emp['rule_tot_emp_cnt'];
                    //if($emp['status'] >= 3)
                    //{
                    $is_show_comparison_btn++;
                   // }
                }    
              
            ?>
       <!-- <p>Salary Rule List Created By Self</p>-->
        <p style="padding-bottom:20px;">
        <?php 
		if($this->session->userdata('role_ses') != CV_ROLE_BUSINESS_UNIT_HEAD){
			if($is_show_comparison_btn>1){?>
        	<button  class="btn btn-success pull-left" onclick="view_rule_comparison();">Compare Rules</button> 
        <?php } ?>
        Total <a href="<?php echo base_url('employee-not-in-any-rule/'.$performance_cycle_id) ?>"><strong><?php echo $emp_not_in_rule["total_emp_cnt"]; ?></strong></a> employees not covered in under this review plan</p>
		<?php } ?>
		<!--shumsul-->
		<div class="table-responsive"> 
        <table id="example" class="table border table-responsive rule-list" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th>Plan Name</th>
                <th>Salary Review</th>
                <th>Total Employee</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created On</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body ">                   
         <?php $i=0;
       
             foreach($salary_rule_list as $row)
             {
                $id = $row["id"];
				if($row["createdby"] == $this->session->userdata("userid_ses"))
				{
					echo "<tr class='beg_color'>";
				}
				else
				{
					echo "<tr class='beg_color' style='background-color:#fafde4'>";
				}
                echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
				echo "<td>";
				if($is_show_comparison_btn>1){
					if($row["status"]>=3)
					{
						echo "<label style='color:#000 !important;' ><input type='checkbox' name='chk_rules_for_comparison[]' value='".$id."' style='opacity:1; margin-top:1px;'><span style='vertical-align: sub; font-size:13px; color:#000 !important;'>".$row["name"]."</span></label>";
					}
					else
					{
						echo "<label style='color:#000 !important;' ><input disabled type='checkbox' disabled style='opacity:1; margin-top:1px;'><span style='vertical-align: sub; font-size:13px; color:#000 !important;'>".$row["name"]."</span></label>";
					}
				}
				else
				{
					echo $row["name"];
				}
				echo "</td>";
                  
				echo "<td>".$row["salary_rule_name"]."</td>";
                //$ids=explode(',',$row['user_ids']);
                echo '<td class="text-center">'.$row['rule_tot_emp_cnt'].'</td>';                
                if($row["start_date"] != '0000-00-00')
                {
                     echo '<td class="text-center">'.date("d/m/Y", strtotime($row["start_date"])).'</td>';
                }
                else
                {
                     echo "<td class='text-center'></td>";
                }
                
                if($row["end_date"] != '0000-00-00')
                {
                    echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                }
                else
                {
                   echo "<td class='text-center'></td>"; 
                }   
				$status = "In Process";
				if($row["status"] == 4)
				{
					$status = "Approval Pending";
				}
				elseif($row["status"] == 5)
				{
					$status = "Rejected";
				}
				elseif($row["status"] == 6)
				{
					$status = "Approved";
				}
				elseif($row["status"] == 7)
				{
					$status = "Send to Managers to verify before release";
				}
				elseif($row["status"] == 9)
				{
					$status = "Released";
				}
				echo "<td class='text-center'>".$status."</td>";         
                echo "<td class='text-center'>".$row["created_by_name"]."</td>";
                echo "<td class='text-center'>".date("d/m/Y", strtotime($row["createdon"]))."</td>";
                echo "<td class='text-center' style='max-width:400px;'>";
				if($row["createdby"] == $this->session->userdata("userid_ses"))
				{
					if($row["status"]==1 or $row["status"] == 2)
					{
						echo "<a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("salary-rule-filters/$performance_cycle_id/$id")."' alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return confirm('Are you sure, You want to delete rule?')" href="<?php echo site_url("delete-salary-rule/$id"); ?>"alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
						
						
					}
					elseif($row["status"] == 3)
					{
						//echo "<a href='".site_url("view-salary-rule-details/$id")."'>View Rule</a> | <a href='".site_url("create-salary-rules/$id")."'>Edit</a> | <a href='".site_url("view-rule-budget/$id")."'>Send For Approval</a>";
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-salary-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("salary-rule-filters/$performance_cycle_id/$id")."' alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Send for Approval' data-placement='bottom' href='".site_url("view-salary-rule-details/$id")."'alt='Send for Approval' title='Send for Approval''><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></a>";
						
						
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom'  onclick="return confirm('Are you sure, You want to delete rule?')" href="<?php echo site_url("delete-salary-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
						
					}
					elseif($row["status"] == 4)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-salary-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View and Edit Employee Wise Recommendations' data-placement='bottom' href='".site_url("view-increments/$id")."'alt='View and Edit Employee Wise Recommendations' title='View and Edit Employee Wise Recommendations'><i class='fa fa-list' aria-hidden='true'></i></a>";
						
					}
					elseif($row["status"] == 5)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-salary-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("salary-rule-filters/$performance_cycle_id/$id")."' alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom'  onclick="return confirm('Are you sure, You want to delete rule?')" href="<?php echo site_url("delete-salary-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
							
					}
					elseif($row["status"] == 6 || $row["status"] == 7)
					{

						//echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom'  href='".site_url("view-salary-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View Increment List' data-placement='bottom' href='".site_url("view-increments/$id")."'alt='View Increment List' title='View Increment List'><i class='fa fa-list' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Upload data' data-placement='bottom' href='".site_url("salary-rules-upgrade-promotion/$id")."'alt='Upload data' title='Upload data'><i class='fa fa-upload' aria-hidden='true'></i></a> ";
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom'  href='".site_url("view-salary-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View and Edit Employee Wise Recommendations' data-placement='bottom' href='".site_url("view-increments/$id")."'alt='View and Edit Employee Wise Recommendations' title='View and Edit Employee Wise Recommendations'><i class='fa fa-list' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View Refresh Rule Data' data-placement='bottom' href='".site_url("reopen-salary-rule/$id")."'alt='View Refresh Rule Data' title='View Refresh Rule Data'><i class='fa fa-refresh' aria-hidden='true'></i></a> ";

						
					}
                    elseif($row["status"] == 9)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom'  href='".site_url("view-salary-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View and Edit Employee Wise Recommendations' data-placement='bottom' href='".site_url("view-increments/$id")."'alt='VView and Edit Employee Wise Recommendations' title='View and Edit Employee Wise Recommendations'><i class='fa fa-list' aria-hidden='true'></i></a>";
						
					}
					else
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-salary-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";
					}  
					
					if($row["status"] < 9)
					{?>
						| <a class="anchor_cstm_popup_cls_sal_delete_<?php echo $id; ?>" data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_sal_delete_<?php echo $id; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo site_url("delete-salary-rule/$id"); ?>"alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>
					<?php } 
				}
				elseif($this->session->userdata('role_ses') == CV_ROLE_BUSINESS_UNIT_HEAD and $row["status"] >= 3 and $cycle_dtls["is_adhoc_cycle"]==2)
				{
					echo "<a data-toggle='tooltip' data-original-title='View and Edit Employee Wise Recommendations' data-placement='bottom' href='".site_url("view-increments/$id")."'alt='View and Edit Employee Wise Recommendations' title='View and Edit Employee Wise Recommendations'><i class='fa fa-list' aria-hidden='true'></i></a> ";
				}
				else
				{
					if($row["status"] >= 3 and $cycle_dtls["is_adhoc_cycle"]==2)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-salary-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";					
					}
					
					if($row["status"] >= 6 and $cycle_dtls["is_adhoc_cycle"]==2)
					{
						echo " | <a data-toggle='tooltip' data-original-title='View and Edit Employee Wise Recommendations' data-placement='bottom' href='".site_url("view-increments/$id")."'alt='View and Edit Employee Wise Recommendations' title='View and Edit Employee Wise Recommendations'><i class='fa fa-list' aria-hidden='true'></i></a> ";					
					}
					
					if($this->session->userdata('role_ses') <= 2 and $row["status"] < 9  and $cycle_dtls["is_adhoc_cycle"]==2)
					{?>
						<a class="anchor_cstm_popup_cls_sal_delete_<?php echo $id; ?>" data-toggle='tooltip' data-original-title='Delete' data-placement='bottom'  onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sal_delete_<?php echo $id; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo site_url("delete-salary-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>
				<?php }
				}
				
				if($this->session->userdata('role_ses') != CV_ROLE_BUSINESS_UNIT_HEAD)
				{
					if($row["status"] >= 3 and $cycle_dtls["is_adhoc_cycle"]==2)
					{
						echo ' | <a target="_blank" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" href="'.base_url("print-preview-salary/".$id).'"><i class="fa fa-print" aria-hidden="true"></i></a>';
						// echo ' | <a target="_blank" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" href="'.base_url("rules/print_data/".$id).'"><i class="fa fa-print" aria-hidden="true"></i></a>';
					
						// echo ' | <a target="_blank" data-toggle="tooltip" data-original-title="Download Employee Letter(s)" data-placement="bottom" target="_blank" href="'.base_url("rules/download/".$row['performance_cycle_id'].'/'.$id).'"><i class="fa fa-download" aria-hidden="true"></i></a>';
					}
	
	
					//Piy@2Jan20 hide dashoboard link if all employess_salery_detail status is < 5	  
					$show_view_rule_dashboard =($row["status"] > 3);  
					foreach($rules_release_approvel_list as $record)
					{
						if( $record['rule_id']==$id && $record['total_emp_in_rule']<= $record['total_appoved_emp_in_rule'])
						{$show_view_rule_dashboard =false;}
					}
					if($show_view_rule_dashboard) echo " | <a data-toggle='tooltip' data-original-title='Upload data' data-placement='bottom' href='".site_url('rules/view_rule_dashboard/'.$id)."' alt='Dashboard' title='Dashboard'><i class='fa fa-files-o' aria-hidden='true'></i></a>";
					
					echo " | <a data-toggle='tooltip' data-original-title='Upload data' data-placement='bottom' onclick='openEmailTemplatePopup(".$id.")' alt='Send Email' title='Send Email'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
				}

                
                echo "</td></tr>";
                $i++;
             }?>   
            <tr>
                <td colspan="3" style="text-align: right;">Total employees covered in rules mentioned in above table </td>
                <td class='text-center'><b><?php echo $empcount ?></b></td>
                <td  colspan="6"></td>
            </tr>   
            
        </tbody>
       </table>
</div>	   
       
    <?php } ?> 
       
       
   	<?php if($approvel_request_list){
		$is_show_null_record_msg = 0; ?>
        
        <p>Pending Approval List of Salary Rules</p>
        <div class="table-responsive"> 
         <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
            <thead>
                <tr>
                    <th class="hidden-xs" width="5%">S.No</th>
                    <th>Plan Name</th>
                    <th>Salary Review</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Requested On</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbl_body">                   
             <?php $i=0;
             foreach($approvel_request_list as $row)
             {
                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                echo "<td>".$row["name"]."</td>";
				echo "<td>".$row["salary_rule_name"]."</td>";
                if($row["start_date"] != '0000-00-00')
                {
                     echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
                }
                else
                {
                     echo "<td class='text-center'></td>";
                }
                if($row["end_date"] != '0000-00-00')
                {
                    echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                }
                else
                {
                   echo "<td class='text-center'></td>"; 
                }                         
                
                echo "<td class='text-center'>".date("d/m/Y", strtotime($row["request_date"]))."</td>";
                echo "<td class='text-center'  style='max-width:400px;'>";
                $rule_id = $row["rule_id"];
                if($row["type"]==2)
                {
                    echo "<a href='".site_url("view-salary-rule-details/$rule_id")."'>Approve Salary Rule</a>";
                }                
                echo "</td>";
                echo "</tr>";
                $i++;
             }
             ?>  
             
            </tbody>
          </table>
          </div>   
    <?php } ?> 
    
    <?php $is_show_release_list = 0; 
   // print_r($rules_release_approvel_list);
		if($this->session->userdata('role_ses') < 2 and $rules_release_approvel_list){ 
			?>
<div style="display:none;" id="dv_release_list" >
        <p>Pending Rule List To Release
 </p>
        <div class="table-responsive"> 
         <table class="table border" style="width: 100%; cellspacing:0;">
            <thead>
                <tr>
                    <th class="hidden-xs" width="5%">S.No</th>
                    <th>Plan Name</th>
                    <th>Rule Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Template</th>
                    <th> Email </th>
                   <!--  <th> Action </th> -->
                </tr>
            </thead>
            <tbody id="tbl_body">                   
             <?php $i=0;
             foreach($rules_release_approvel_list as $row)
             {
				$rule_id = $row["rule_id"];
			// if($row["total_emp_in_rule"]==$row["total_appoved_emp_in_rule"])
//             {
				$is_show_release_list = 1; 
				echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
				echo "<td>".$row["name"]."</td>";
				echo "<td>".$row["salary_rule_name"]."</td>";
				if($row["start_date"] != '0000-00-00')
				{
					 echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
				}
				else
				{
					 echo "<td class='text-center'></td>";
				}
				if($row["end_date"] != '0000-00-00')
				{
					echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
				}
				else
				{
				   echo "<td class='text-center'></td>"; 
				}?>                         
				
					<td>
						<select name="TempateID_<?php echo $rule_id; ?>" class="form-control" required="true" id="TempateID_<?php echo $rule_id; ?>" <?php if($row["template_id"]!='0'){ echo 'disabled';} ?>>
							 
							   <?php 
							   if(!empty($template))
							   {								
								   foreach($template as $tmpl)
								   {
										$selectdata='';
									 if($row["template_id"]==$tmpl->TemplateID)
										{
										$selectdata= 'selected ';
										}
									   echo '<option '.$selectdata.'  value="'.$tmpl->TemplateID.'">'.$tmpl->TemplateTitle.'</option>';
								   }
							   }
							   else
							   {
								 echo '<option  value="">No Template Available</option>';
							   }
							   
							   ?>
							</select>
					</td>
					<td class="text-center">
						<div class="beg_color">
							<label class="black"> &nbsp; <input type="checkbox" id="sendemailchk" name="chk_send_mail" onclick="show_panel_to_release_letters(<?php echo $rule_id; ?>);" value="1" style="opacity:1; margin-top:1px;"><span></span></label>
						</div>
					</td>
						<!-- <div class='beg_color'> -->
							<?php /*?><label><input type='radio' value='1' name='rb_mail_for' checked="checked"/><span>All</span></label>&nbsp;
							<label><input type='radio' value='2' name='rb_mail_for'/><span>Only Managers</span></label>&nbsp;<?php */?>
							<!-- <input <?php if($row["rule_status"]==7){echo 'disabled="disabled"';} ?> type="<?php if($row["rule_status"]==6){echo 'submit';}else{echo 'button';} ?>" name="btn_send_to_manager" value="Send To Managers" class="btn btn-success">&nbsp;
                            <input type="submit" name="btn_release" value="Final Release" class="btn btn-success"> -->
						<!-- </div> -->
					
                    <?php
					echo "</tr>";
                	$i++;
				//}
             }
             ?>  
             
            </tbody>
          </table> 
         </div>
         </div>  
    <?php } ?> 

       
     <?php  if($is_show_release_list)
			{
				$is_show_null_record_msg = 0;
			}
		    if($is_show_null_record_msg)
			{
				echo "<p>No record found.</p>";	
			}
	?> 

	

    </div>
    <div id="dv_release_list1" class="mailbox-content" style="display: none;" >
	</div>
</div>

</div>

<script>
<?php if($is_show_release_list){ ?>
	$("#dv_release_list").show();
<?php } ?>

// $("#checkAll").click(function () {
//     $(".checkBoxClass").prop('checked', $(this).prop('checked'));
// });

function view_rule_comparison(obj, evnt)
{
	var val = $(obj).is(":checked");
	var r_ids = "";
	var cnt = 0;
	
	$("input[name='chk_rules_for_comparison[]']").each(function ()
	{
		if($(this).is(":checked"))
		{
			if(r_ids)
			{
				r_ids = r_ids +"-"+ $(this).val();
			}
			else
			{
				r_ids = $(this).val();
			}
			cnt = cnt+1;			
		}		
	});
	
	if(cnt>1)
	{
		$("#loading").css('display','show');
		$.get("<?php echo site_url("rules/get_encoded_url/".$performance_cycle_id);?>/"+r_ids, function(url)
		{
			if(url)
			{
				//$("#loading").css('display','none');
				window.location.href= url;
			}
		});		
	}
	else
	{
		custom_alert_popup("Please select atleast 2 rules for comparisons.");
	}
}

function openEmailTemplatePopup(ruleId) {

  var ancoreTag,bodytag='';

 $('#loading').show();
 var csrf_val = $('input[name=csrf_test_name]');
        $.ajax({
            url: '<?Php echo site_url('performance_cycle/getEmailTemplate'); ?>',
            type: 'get',
            contentType: 'application/json',
            
            success: function (res) {
              
              var obj=JSON.parse(res);
            
              if(obj.first_mail[0].email_body!="")
              {
                  ancoreTag='<a class="btn btn-primary" onclick="loaderActivate()" href="<?=site_url("sent_email_approvers/")?>'+ruleId+'">Send Mail</a>';
                    bodytag=obj.first_mail[0].email_body;
                  $("#setFooter1").html(ancoreTag);
                  $("#setBody1").html(bodytag);
              }
              else
              {
                 bodytag="No Email Template Created Yet.Please Create Email Template First.";
                  
                  $("#setBody1").html(bodytag);
              }
               if(obj.reminder_mail[0].email_body!="")
              {
                  ancoreTag='<a class="btn btn-primary" onclick="loaderActivate()" href="<?=site_url("reminder_email_approvers/")?>'+ruleId+'">Send Reminder Mail</a>';
                    bodytag=obj.reminder_mail[0].email_body;
                  $("#setFooter2").html(ancoreTag);
                  $("#setBody2").html(bodytag);
              }
              else
              {
                  bodytag="No Template Created Yet.Please Create Template First.";
                  
                  $("#setBody2").html(bodytag);
              }
              $("#loading").hide();  
                
            }
        });
   
      $("#emailTemplate").modal('show');
}

function show_panel_to_release_letters(rule_id)
{
	$('#dv_release_list1').html("");
	if($('#TempateID_'+rule_id).val()=='')
	{
		custom_alert_popup('Please select template.');
		return false;
	}
	
	//$('#manager_list').show();
	if($(this).prop("checked") == false)
	{
		$('#dv_release_list1').hide();
		//$('#manager_list').hide();
	}
	else
	{
		$("#loading").show();
		$.ajax({
			url: '<?php echo base_url('rules/get_managerList'); ?>',
			type: 'GET',
			data: {rule_id:rule_id},
		})
		.done(function(data)
		{
			$('#dv_release_list1').html(data);
			$('#dv_release_list1').show();
			$('#TempateID').val($('#TempateID_'+rule_id).val());
			$("#loading").hide();
		});		
	}
}
</script>
