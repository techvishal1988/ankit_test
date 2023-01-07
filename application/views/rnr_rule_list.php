<style>.mailbox-content table tbody tr:nth-child(odd){background:none;}</style>
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-sm-6">
    <ol class="breadcrumb wn_btn xs-only-text-center" style="padding-top: 6px !important;">
        <!--<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li><a href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
    </div>
    <div class="col-sm-6 ">
       <?php if(helper_have_rights(CV_COMP_RNR, CV_INSERT_RIGHT_NAME)) { ?>
        <div class="pull-right xs-only-text-center">
            <a href="<?php echo site_url("rnr-rule-filters/".$performance_cycle_id); ?>"><button class="btn btn-success create_new_rule_btn" type="button">Create New <?php echo $title; ?> Rules</button></a>
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
<?php echo $this->session->flashdata('message');
      echo $msg;
	  $is_show_null_record_msg = 1; ?>
   	<?php if($rnr_rule_list){
		  $is_show_null_record_msg = 0; ?>
       <?php /*?> <p><?php echo $title; ?> Rule List Created By Self</p><?php */?>
	   <div class="table-responsive"> <!--shumsul-->
        <table id="example" class="table border rule-list" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th>Plan Name</th>
                <th>Rule Name</th>
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
       
             foreach($rnr_rule_list as $row)
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
				echo "<td>".$row["rule_name"]."</td>";
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
				echo "<td class='text-center'>".$status."</td>";         
                echo "<td class='text-center'>".$row["created_by_name"]."</td>";
				
                echo "<td class='text-center'>".date("d/m/Y", strtotime($row["createdon"]))."</td>";
                echo "<td class='text-center' style='max-width:400px;'>";
				
				if($row["createdby"] == $this->session->userdata("userid_ses"))
				{
					if($row["status"]==1 or $row["status"] == 3)
					{
						echo "<a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("rnr-rule-filters/$performance_cycle_id/$id")."'alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return confirm('Are you sure, You want to delete rule?')" href="<?php echo site_url("delete-rnr-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
						
					}				
					elseif($row["status"] == 4)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-rnr-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";
					}
					elseif($row["status"] == 5)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-rnr-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a> | <a data-toggle='tooltip' data-original-title='Edit Rule' data-placement='bottom' href='".site_url("rnr-rule-filters/$performance_cycle_id/$id")."'alt='Edit Rule' title='Edit Rule'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";
						
						 /*| <a data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return confirm('Are you sure, You want to delete rule?')" href="<?php echo site_url("delete-rnr-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>*/
						
					}
					elseif($row["status"] == 6)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-rnr-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";

            echo " | <a data-toggle='tooltip' data-original-title='Upload data' data-placement='bottom' onclick='openEmailTemplatePopup(".$id.")' alt='Send Email' title='Send Email'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
					}
					else
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-rnr-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";
					} 
					//if($row["status"] < 6)
					if($row["proposed_usr_cnts"] <= 0 and ($this->session->userdata("userid_ses") == $row["createdby"] or $this->session->userdata("role_ses") == CV_ROLE_ADMIN_USER))
					{?>
						 | <a class="nchor_cstm_popup_cls_rnr_delete<?php echo $id; ?>"  data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_rnr_delete<?php echo $id; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo site_url("delete-rnr-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>
				<?php
					}
					
				}
				else
				{
					if($row["status"] >= 3)
					{
						echo "<a data-toggle='tooltip' data-original-title='View Rule' data-placement='bottom' href='".site_url("view-rnr-rule-details/$id")."' alt='View Rule' title='View Rule'><i class='fa fa-eye' aria-hidden='true'></i></a>";
					}
					if($this->session->userdata('role_ses') <= 2 and $row["status"] < 6)
					{?>
						<a class="nchor_cstm_popup_cls_rnr_delete<?php echo $id; ?>" data-toggle='tooltip' data-original-title='Delete' data-placement='bottom' onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_rnr_delete<?php echo $id; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo site_url("delete-rnr-rule/$id"); ?>" alt="Delete" title="Delete"><i class='fa fa-trash' aria-hidden='true'></i></a>
				<?php } 
				}

                echo "</td>";
                echo "</tr>";
                $i++;
             }?>                     
        </tbody>
       </table> 
	   </div>
       
    <?php } ?> 
       
   	<?php if($rnr_approvel_request_list){
		  $is_show_null_record_msg = 0; ?>
       
        <p>Pending Approval List of <?php echo $title; ?></p>
        <div class="table-responsive">
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
             foreach($rnr_approvel_request_list as $row)
             {
                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                echo "<td>".$row["name"]."</td>";
				echo "<td>".$row["rule_name"]."</td>";
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
                if($row["type"]==5)
                {
                    echo "<a href='".site_url("view-rnr-rule-details/$rule_id")."'>Approve R and R Rule</a>";
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

    <?php  
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
            url: '<?Php echo site_url('performance_cycle/getEmailrnrRuleTemplate'); ?>',
            type: 'get',
            contentType: 'application/json',
            
            success: function (res) {
              
              var obj=JSON.parse(res);
            
              if(obj.first_mail[0].email_body!="")
              {
                  ancoreTag='<a class="btn btn-primary" onclick="loaderActivate()" href="<?=site_url("sentEmailrnrToApprove/")?>'+ruleId+'">Send Mail</a>';
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
                  ancoreTag='<a class="btn btn-primary" onclick="loaderActivate()" href="<?=site_url("reminderEmailrnrToApprovers/")?>'+ruleId+'">Send Reminder Mail</a>';
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
