<style>.mailbox-content table tbody tr:nth-child(odd){background:none;}</style>
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-sm-8"> 
     <ol class="breadcrumb wn_btn" style="padding-top: 6px !important;">
        <!--<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li><a href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
        <li class="active"><?php echo $rule_txt_name; ?> Rules</li>
     </ol>
    </div>
     <div class="col-sm-4">
        <?php 
               if(helper_have_rights(CV_COMP_BONUS, CV_INSERT_RIGHT_NAME)) { ?>
        <div class="pull-right">
            <a href="<?php echo site_url("bonus-rule-filters/".$performance_cycle_id); ?>"><button class="btn btn-success create_new_rule_btn" type="button">Create New <?php echo $rule_txt_name; ?> Rules</button></a>
        </div>
               <?php } ?>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="col-md-12 background-cls">
   <div class="mailbox-content">
   <?php 
   		$is_show_null_record_msg = 1;
   		echo $this->session->flashdata('message');
      	echo $msg; ?>
   <?php if($bonus_rule_list){ 
        $is_show_null_record_msg = 0;
        $empcount=0;
                foreach($totalempinrule as $emp)
                {
                    
                     //$empcount+=count(explode(',',$emp['user_ids'])).'-';
					 $empcount += $emp['rule_tot_emp_cnt'];
                     
                } 
       ?>
   		<!--<p>Bonus Rule List Created By Self</p>-->
                <p>Total employees not covered in under this review cycle <a href="<?php echo base_url('bonus/employee-not-in-any-rule/'.$performance_cycle_id) ?>"><strong><?php echo $emp_not_in_rule["total_emp_cnt"]; ?></strong></a></p>
				
		<div class="table-responsive"> <!--shumsul-->		
        <table id="example" class="table border rule-list" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th>Plan Name</th>
                <th>Rule Name</th>
                <th>Total Employee</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created On</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body">                   
         <?php $i=0;
         if($bonus_rule_list)
         {
             foreach($bonus_rule_list as $row)
             {
                $id = $row["id"];
				if($row["createdby"] == $this->session->userdata("userid_ses"))
				{
					echo "<tr>";
				}
				else
				{
					echo "<tr style='background-color:#fafde4'>";
				}
                echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                echo "<td>".$row["name"]."</td>";
		echo "<td>".$row["bonus_rule_name"]."</td>";
                  //$ids=explode(',',$row['user_ids']);
                echo '<td class="text-center">'.$row['rule_tot_emp_cnt'].'</td>';   
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
						//echo "<a href='".site_url("create-bonus-rule/$id")."'>Edit Rule</a>";
						echo "<a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("bonus-rule-filters/$performance_cycle_id/$id")."'alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";//
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return confirm('<?php echo CV_CONFIRMATION_DELETE_MESSAGE?>')" href="<?php echo site_url("delete-bonus-rule/$id"); ?>"alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
											
					}
					elseif($row["status"] == 3)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("bonus-rule-filters/$performance_cycle_id/$id")."'alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Send for Approval' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='Send for Approval' title='Send for Approval''><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></a>";
						
						 /*| <a  data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return confirm('<?php echo CV_CONFIRMATION_DELETE_MESSAGE?>')" href="<?php echo site_url("delete-bonus-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
						
					}
					elseif($row["status"] == 4)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View Bonus List' data-placement='bottom' href='".site_url("view-bonus-increments/$id")."'alt='View Bonus List' title='View Bonus List'><i class='fa fa-list' aria-hidden='true'></i></a>";					
					}
					elseif($row["status"] == 5)
					{
						echo "<a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("bonus-rule-filters/$performance_cycle_id/$id")."'alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";	
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return confirm('<?php echo CV_CONFIRMATION_DELETE_MESSAGE?>')" href="<?php echo site_url("delete-bonus-rule/$id"); ?>"alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
										
					}
					elseif($row["status"] == 6)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View Bonus List' data-placement='bottom' href='".site_url("view-bonus-increments/$id")."'alt='View Bonus List' title='View Bonus List'><i class='fa fa-list' aria-hidden='true'></i></a>";	

                        echo " | <a data-toggle='tooltip' data-original-title='Upload data' data-placement='bottom' onclick='openEmailTemplatePopup(".$id.")' alt='Send Email' title='Send Email'><i class='fa fa-envelope' aria-hidden='true'></i></a>";				
					}
                    elseif($row["status"] == CV_STATUS_RULE_RELEASED)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='View Bonus List' data-placement='bottom' href='".site_url("view-bonus-increments/$id")."'alt='View Bonus List' title='View Bonus List'><i class='fa fa-list' aria-hidden='true'></i></a>";					
					}
					else
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";
					}
					
					if($row["status"] < CV_STATUS_RULE_RELEASED)
					{?>
						 | <a class="anchor_cstm_popup_cls_bonus_delete<?php echo $id; ?>" data-toggle='tooltip' data-original-title='Delete' data-placement='bottom'  onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_bonus_delete<?php echo $id; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo site_url("delete-bonus-rule/$id"); ?>"alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>
					<?php					
					} 
				}
				else
				{
					if($row["status"] >= 3)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-bonus-rule-details/$id")."'alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";
					}
					if($this->session->userdata('role_ses') <= 2 and $row["status"] < CV_STATUS_RULE_RELEASED)
					{?>
						<a class="anchor_cstm_popup_cls_bonus_delete<?php echo $id; ?>" data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_bonus_delete<?php echo $id; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo site_url("delete-bonus-rule/$id"); ?>"alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>
				<?php }
				}
                
				if($row["status"] >= 3)
				{
					echo ' | <a target="_blank" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" href="'.base_url("printpreview-bonus/".$id).'"><i class="fa fa-print" aria-hidden="true"></i></a>';
				}

                echo "</td>";
                echo "</tr>";
                $i++;
             }
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
                
        <p>Pending Approval List of Bonus Rules</p>

         <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
            <thead>
                <tr>
                    <th class="hidden-xs" width="5%">S.No</th>
                    <th>Plan Name</th>
                    <th>Rule Name</th>
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
				echo "<td>".$row["bonus_rule_name"]."</td>";
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
                echo "<td class='text-center' style='max-width:400px;'>";
                $rule_id = $row["rule_id"];
                if($row["type"]==3)
                {
                    echo "<a href='".site_url("view-bonus-rule-details/$rule_id")."'>Approve Bonus Rule</a>";
                }
                echo "</td>";
                echo "</tr>";
                $i++;
             }
             ?>  
             
            </tbody>
          </table> 
      		  
    <?php } ?>
  
    <?php $is_show_release_list = 0; 
		if($this->session->userdata('role_ses') <= 2 and $rules_release_approvel_list){ ?>
        <div style="display:none;" id="dv_release_list" >
        <p>Pending Rule Release List of <?php echo $rule_txt_name; ?> Rules</p>
		<div class="table-responsive"> <!--shumsul-->
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
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbl_body">                   
             <?php $i=0;
             foreach($rules_release_approvel_list as $row)
             {
				if($row["total_emp_in_rule"]==$row["total_appoved_emp_in_rule"])
                {
					$is_show_release_list = 1; 
					echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
					echo "<td>".$row["name"]."</td>";
					echo "<td>".$row["bonus_rule_name"]."</td>";
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
					}  ?>                        
					<form class="frm_cstm_popup_cls_default" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')" method="post" action="">
                    	<?php echo HLP_get_crsf_field();?>
                        <td class='text-center'>
                            <select name="TempateID" class="form-control" required="true">
                                 
                                   <?php 
                                   
                                   foreach($template as $tmpl)
                                   {
                                       echo '<option  value="'.$tmpl->TemplateID.'">'.$tmpl->TemplateTitle.'</option>';
                                   }
                                   
                                   ?>
                                </select>
                        </td>
                        <td class='text-center'>
                <div class="beg_color">
                    <label class="black"> &nbsp; <input type="checkbox" name="chk_send_mail" value="1" style="opacity:1; margin-top:1px;"><span></span></label>
                </div>
            </td>
					<?php echo "<td class='text-center'  style='max-width:400px;'>";
					$rule_id = $row["rule_id"]; ?>
					
						<input type="hidden" name="hf_rule_id" value="<?php echo $rule_id; ?>" required />
						<div class='beg_color'>
							<?php /*?><label><input type='radio' value='1' name='rb_mail_for' checked="checked"/><span>All</span></label>&nbsp;
							<label><input type='radio' value='2' name='rb_mail_for'/><span>Only Managers</span></label>&nbsp;<?php */?>
                            
                            
                            <input <?php if($row["rule_status"]==7){echo 'disabled="disabled"';} ?> type="<?php if($row["rule_status"]==6){echo 'submit';}else{echo 'button';} ?>" name="btn_send_to_manager" value="Send To Managers" class="btn btn-success btn-w130">&nbsp;
                            <input type="submit" name="btn_release" value="Final Release" class="btn btn-success btn-w130">
						</div>
					
					<?php                 
					echo "</td>";?>
                                        </form>
					<?php echo "</tr>";
                	$i++;
				}
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
</div>

</div>

<script>

function openEmailTemplatePopup(ruleId) {

  var ancoreTag,bodytag='';

 $('#loading').show();
 var csrf_val = $('input[name=csrf_test_name]');
        $.ajax({
            url: '<?Php echo site_url('performance_cycle/getEmailBonusRuleTemplate'); ?>',
            type: 'get',
            contentType: 'application/json',
            
            success: function (res) {
              
              var obj=JSON.parse(res);
            
              if(obj.first_mail[0].email_body!="")
              {
                  ancoreTag='<a class="btn btn-primary" onclick="loaderActivate()" href="<?=site_url("sentEmailBonusToApprove/")?>'+ruleId+'">Send Mail</a>';
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
                  ancoreTag='<a class="btn btn-primary" onclick="loaderActivate()" href="<?=site_url("reminderEmailBonusToApprovers/")?>'+ruleId+'">Send Reminder Mail</a>';
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




<?php if($is_show_release_list){ ?>
	$("#dv_release_list").show();
<?php } ?>
</script>
