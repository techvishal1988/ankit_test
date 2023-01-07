<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Salary Rules Approval Request List</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
			<div class="col-md-12">
               <div class="mailbox-content">
               <?php echo $this->session->flashdata('message'); ?>   
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Plan Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Requested On</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0;
                     foreach($rules_approvel_request_list as $row)
                     {
                        echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
						echo "<td>".$row["name"]."</td>";
						if($row["start_date"] != '0000-00-00')
						{
							 echo "<td>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
						}
						else
						{
							 echo "<td></td>";
						}
						if($row["end_date"] != '0000-00-00')
						{
							echo "<td>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
						}
						else
						{
						   echo "<td></td>"; 
						}                         
						
						echo "<td>".date("d/m/Y", strtotime($row["request_date"]))."</td>";
						echo "<td>";
						$rule_id = $row["rule_id"];
                        if($row["type"]==2)
                        {
    						echo "<a href='".site_url("view-salary-rule-details/$rule_id")."'>View Salary Rule</a>";
                        }
                        elseif($row["type"]==3)
                        {
                            echo "<a href='".site_url("view-bonus-rule-details/$rule_id")."'>View Bonus Rule</a>";
                        }
						echo "</td>";
						echo "</tr>";
                		$i++;
                     }
                     ?>  
                     
                    </tbody>
                   </table>                    
                </div>
            </div>
</div>
</div>