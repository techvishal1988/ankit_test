<style>
	tr.plan_bdgt_row td
	{
		background:#D6D6D6 !important;
		font-weight:bold !important;
	}
</style>
<div class="page-breadcrumb">
  <ol class="breadcrumb container">
   <!--  <li><a href="<?php //echo site_url("dashboard"); ?>">Dashboard</a></li> -->
    <li><a href="<?php echo site_url("manager/myteam"); ?>">My Team</a></li>
    <li class="active"><?php echo $title; ?></li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="col-md-12 padr0 padl0">
    <div class="mailbox-content" style="padding-bottom: 10px;"> <?php echo $this->session->flashdata('message');
      echo $msg;
     if(isset($salary_rule_list)){ ?>
      <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
          <tr>
            <th class="hidden-xs" width="5%">S.No</th>            
            <th>Salary Review</th>
			<th>Allocated Budget</th>      			
			<th>Available Budget</th>
			<th>Direct Reports Budget</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Status</th>
            <th> Action </th>
          </tr>
        </thead>
        <tbody id="tbl_body">
          <?php 
                $i=1;
				foreach($plan_dtls as $p_row)
				{
					$allocated_budget = $available_budget = $direct_emps_budget = 0;
					foreach($salary_rule_list as $row)
					{
						if($p_row["id"] == $row["performance_cycle_id"])
						{
							$allocated_budget += $row['rule_wise_budget_dtls']["allocated_budget"];
							$available_budget += $row['rule_wise_budget_dtls']["available_budget"];
							$direct_emps_budget += $row['rule_wise_budget_dtls']["direct_emps_budget"];
						}					
					}?>
					<tr class="plan_bdgt_row">
						<td></td>
						<td><?php echo $p_row['name'] ?></td>							
						<td class="text-right"><?php echo $m_currency_name["name"]." ".HLP_get_formated_amount_common($allocated_budget); ?></td>						
						<td class="text-right"><?php echo $m_currency_name["name"]." ".HLP_get_formated_amount_common($available_budget); ?></td>
						<td class="text-right"><?php echo $m_currency_name["name"]." ".HLP_get_formated_amount_common($direct_emps_budget); ?></td> 
						<td colspan="4"></td>
					</tr>
					<?php
					foreach($salary_rule_list as $row)
					{ 
						if($p_row["id"] == $row["performance_cycle_id"])
						{?>
							<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $row['salary_rule_name']; ?></td>
							
							<td class="text-right"><?php echo $m_currency_name["name"]." ".HLP_get_formated_amount_common($row['rule_wise_budget_dtls']["allocated_budget"]); ?></td>						
							<td class="text-right"><?php echo $m_currency_name["name"]." ".HLP_get_formated_amount_common($row['rule_wise_budget_dtls']["available_budget"]); ?></td>
							<td class="text-right"><?php echo $m_currency_name["name"]." ".HLP_get_formated_amount_common($row['rule_wise_budget_dtls']["direct_emps_budget"]); ?></td>
							
							<td class="text-center"><?php echo date("d/m/Y", strtotime($row["start_date"])); ?></td>
							<td class="text-center"><?php echo date("d/m/Y", strtotime($row["end_date"])); ?></td>
							<td class="text-center">
							<?php  
							$status = "Approved";
							if($row["status"] == 7)
							{
							$status = "Send to Managers to verify before release";
							}
							elseif($row["status"] == 9)
							{
							$status = "Released";
							} echo $status; ?>
							</td>  
							<td class="text-center">
							<a data-toggle="tooltip" data-original-title="View and Edit Employee Wise Recommendations" data-placement="bottom" href="<?php echo site_url('manager/managers-list-to-recommend-salary/'.$row["id"]) ?>" alt="view and edit employee wise recommendations"><i class="fa fa-list" aria-hidden="true"></i></a>
							|
							<a data-toggle="tooltip" data-original-title="Download Data" data-placement="bottom" href="<?php echo site_url('manager/dashboard/download_rule_emp_lists/'.$row['id']) ?>"><i class="fa fa-download themeclr" aria-hidden="true"></i></a>
							|
							<a data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo site_url('print-preview-salary/'.$row['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
							</td>
							</tr>
				<?php 		$i++; 
			  			}
					}
				}
                ?>
        </tbody>
      </table>
      <?php }else echo "<p>No record found.</p>"; ?>
    </div>
  </div>
</div>
