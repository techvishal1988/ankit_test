<style>
.table{
	background-color:#fff;
}
</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>
        <li><a href="<?php echo base_url("manager/dashboard/salary_rules"); ?>">Salary Rules</a></li>
        <li class="active">Increment Calculation</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-12">
    	<p>Plan Name : <b><?php echo $rule_dtls["name"]; ?></b></p>
        <p>Rule Name : <b><?php echo $rule_dtls["salary_rule_name"]; ?>
        	| <a data-toggle="tooltip" data-original-title="Print Rule" data-placement="bottom" target="_blank" href="<?php echo base_url('print-preview-salary/'.$rule_dtls['id']) ?>"><i class="fa fa-print" aria-hidden="true" style="color:#FF6600"></i></a>
        </b></p>
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); ?>      
            <div class="panel-body" style="background-color:#f5f5f5; box-shadow:3px 3px 5px 6px;">
            <div class="form-horizontal ">                
                <div id="dv_partial_page_data" style="overflow-x: auto;">
                <?php $is_enable_approve_btn=0;
					   $manager_emailid = strtolower($this->session->userdata('email_ses'));
					 if($staff_list){?>
                	<table id="example" class="table border  ">
                    <thead>
                    	<tr><td colspan='16'>
                        <b>
							<?php if(strtolower($staff_list[0]["last_action_by"]) == $manager_emailid)
                            {echo "My Direct Reports";}
                            else{echo "Direct Reports Of - ".$staff_list[0]["last_manager_name"];} ?>
                        </b>
                        </td></tr>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th> 
                            <th>Plan Name</th>
                            <th>Rule Name</th>
                            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                            <?php /*?><th><?php echo $business_attributes[1]["display_name"]; ?></th><?php */?>
                            <?php/*<th><?php echo $business_attributes[6]["display_name"]; ?></th>*/?>                            
                            <th><?php echo $business_attributes[9]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[10]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[11]["display_name"]; ?></th>   
                            <th><?php echo $business_attributes[17]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[23]["display_name"]; ?></th>
                            <th>Current Salary</th>
                                        <th>Increment Amount</th>
                                        <th>New Salary</th>
                                        <th>CRR</th>
                            <th> Manager Name </th>
                            <!--<th> Manager Email </th>-->
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0; $is_enable_approve_btn=1;
                    
                     $rule_id = $staff_list[0]["rule_id"];
					 $prev_record_manager_email = "";
					 $pk_ids = array();
					 
                     foreach($staff_list as $row)
                     {
                        if($row["emp_salary_status"] >= 5 or strtolower($row["manager_emailid"]) != $manager_emailid)
                        {
                            $is_enable_approve_btn=0;
                        }						
						
						if($prev_record_manager_email != "" and strtolower($row["last_action_by"]) != $prev_record_manager_email)
						{
							if(strtolower($staff_list[$i-1]["manager_emailid"]) == $manager_emailid and count($pk_ids)>0)
							{?>
								<tr><td colspan='16' style='text-align:right'>
                                
                                <form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_increment"); ?>" method="post" class="form-inline">
                                	<input type="button" id="btn_reject_<?php echo $i; ?>" onclick="show_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Reject"/>
                                    
                                     <div class="row" id="dv_remark_<?php echo $i; ?>" style="display: none;">
                                        <div class="col-sm-12">                            	
                                            <div class="form-input">
                                                <input type="hidden" name="emp_sal_tbl_pk_ids" value="<?php echo implode(",",$pk_ids); ?>" />
                                                <textarea class="form-control" rows="6" name="txt_remark" placeholder="Eneter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px; height: 70px;width:100%;"></textarea>
                                            </div>                              				
                                        </div>                                                 
                                        <div class="col-sm-8 col-sm-offset-3">                        
                                            <div class="submit-btn">
                                                <input type="submit" class="btn btn-twitter m-b-sm add-btn" value="Submit"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="submit-btn">
                                                <input type="button" onclick="hide_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Cancel" />
                                            </div>
                                        </div>                   
                                    </div>
                                </form>
                                
								</td></tr>	
							<?php $pk_ids = array();						
							} ?>
							</tbody></table><table class='table border'>
							
                        	<thead>
                            <tr><td colspan='16'>
                            <b>
                                <?php if(strtolower($row["last_action_by"]) == $manager_emailid)
                                {echo "My Direct Reports";}
                                else{echo "Direct Reports Of - ".$row["last_manager_name"];} ?>
                            </b>
                            </td></tr>
                        	<tr>
							<th class="hidden-xs" width="5%">S.No</th> 
                            <th>Plan Name</th>
                            <th>Rule Name</th>
                            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                            <?php/*<th><?php echo $business_attributes[6]["display_name"]; ?></th>*/?>                            
                            <th><?php echo $business_attributes[9]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[10]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[11]["display_name"]; ?></th>   
                            <th><?php echo $business_attributes[17]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[23]["display_name"]; ?></th>
                            <th>Current Salary</th>
                                        <th>Increment Amount</th>
                                        <th>New Salary</th>
                                        <th>CRR</th>
                            <th> Manager Name </th>
                            <!--<th> Manager Email </th>-->
                            <th> Action </th>
                            </tr>
                    		</thead>
                            <tbody>
                  <?php }							
						
						if(strtolower($row["manager_emailid"]) == $manager_emailid and $row["emp_salary_status"] > 1 and $row["emp_salary_status"] < 5)
                        {
							$pk_ids[] = $row["tbl_pk_id"];
						}
						 
                        echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
						echo "<td>".$row["performance_cycle_name"]."</td>";
						echo "<td>".$row["rule_name"]."</td>";
                        echo "<td>".$row["name"]."</td>";
						//echo "<td>".$row["email"]."</td>";
                        //echo "<td>".$row["business_unit_3"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
                        echo "<td>".$row["grade"]."</td>";
                        echo "<td>".$row["level"]."</td>";
                        echo "<td>".$row["date_of_joining"]."</td>";
                        echo "<td>".$row["performance_rating"]."</td>";
                        echo "<td>".$row["increment_applied_on_salary"]."</td>";
                                    echo "<td>".round(($row["final_salary"]-$row["increment_applied_on_salary"]),2)."</td>";
                                    echo "<td>".$row["final_salary"]."</td>"; ?>
                                     <td><?php if($row["market_salary"]){echo round(($row["increment_applied_on_salary"]/$row["market_salary"])*100,0);}else{echo 0;}
                                     ?>%</td><?php 
						echo "<td>".$row["last_manager_name"]."</td>";
						//echo "<td>".$row["last_action_by"]."</td>";                     
                        echo "<td><a href='".site_url("manager/view-employee-increments/".$rule_id."/".$row["id"]."/".$row["upload_id"])."'>View dashboard</a>";
						echo "</td></tr>";
						
						if(count($staff_list) == ($i+1) and count($pk_ids)>0)
						{?>
							<tr><td colspan='16' style='text-align:right'>
                            
                            <form id="<?php echo $i; ?>" action="<?php echo site_url("manager/dashboard/reject_emp_increment"); ?>" method="post" class="form-inline">
                                	<input type="button" id="btn_reject_<?php echo $i; ?>" onclick="show_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Reject"/>
                                    
                                     <div class="row" id="dv_remark_<?php echo $i; ?>" style="display: none;">
                                        <div class="col-sm-12">                            	
                                            <div class="form-input">
                                                <input type="hidden" name="emp_sal_tbl_pk_ids" value="<?php echo implode(",",$pk_ids); ?>" />
                                                <textarea class="form-control" rows="6" name="txt_remark" placeholder="Eneter your remark." required="required" maxlength="1000" style="margin: 0px 0px 10px; height: 70px;width:100%;"></textarea>
                                            </div>                              				
                                        </div>                                                 
                                        <div class="col-sm-8 col-sm-offset-3">                        
                                            <div class="submit-btn">
                                                <input type="submit" class="btn btn-twitter m-b-sm add-btn" value="Submit"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="submit-btn">
                                                <input type="button" onclick="hide_remark_dv('<?php echo $i; ?>');" class="btn btn-twitter m-b-sm add-btn" value="Cancel" />
                                            </div>
                                        </div>                   
                                    </div>
                                </form>
							</td></tr>							
				  <?php }
						$prev_record_manager_email = strtolower($row["last_action_by"]);
                		$i++;
                     }
                     ?>  
                    </tbody>
                   </table> 
                   <br>
                    <?php if($is_enable_approve_btn){?>                   
                    <a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>" href="<?php echo site_url("manager/send-for-next-level/".$rule_id); ?>" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_id; ?>','Are you sure, You want?')">
                    <input type="button" class="btn btn-twitter m-b-sm add-btn" value="Submit For Next Level" id="btnSave" />
                    </a>
                    <?php } ?>
                <?php }else echo "<p>No record found.</p>"; ?>  
                </div>  
            </div>                 
            </div>
        </div>
    </div>
    
</div>
</div>

<script>
function show_remark_dv(obj)
{
	$("#dv_remark_"+obj).show();
	$("#btn_reject_"+obj).hide();
}

function hide_remark_dv(obj)
{
	$("#dv_remark_"+obj).hide();
	$("#btn_reject_"+obj).show();
}

</script>